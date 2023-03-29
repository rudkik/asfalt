<?php defined('SYSPATH') or die('No direct script access.');

class Api_Nur_Shop_Task_Current  {

    /**
     * Получить текущие задания клиентов
     * @param $dateFrom
     * @param $dateTo
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @param null $shopBookkeeperID
     * @param bool $isLoadFinish
     * @return array
     */
    public static function getCurrentTasks($dateFrom, $dateTo, SitePageData $sitePageData,
                                           Model_Driver_DBBasicDriver $driver, $shopBookkeeperID = NULL,
                                           $isLoadFinish = FALSE)
    {
        // получаем список задач в заданный период
        $params = Request_RequestParams::setParams(
            array(
                'period_from' => $dateFrom,
                'period_to' => $dateTo,
            )
        );
        $shopTaskIDs = Request_Nur_Shop_Task::findShopTaskIDs(
            $sitePageData->shopMainID, $sitePageData, $driver, $params, 0, TRUE
        );

        if(count($shopTaskIDs->childs) == 0){
            return array();
        }

        // получаем список клиентов
        if($sitePageData->shopMainID != $sitePageData->shopID) {
            $params = Request_RequestParams::setParams(
                array(
                    'shop_bookkeeper_id' => $shopBookkeeperID,
                    'id' => $sitePageData->branchID,
                )
            );
            $shopIDs = Request_Nur_Shop::findShopIDs(
                $sitePageData, $driver, $params, 0, TRUE,
                array('shop_bookkeeper_id' => array('name'))
            );
        }else{
            $params = Request_RequestParams::setParams(
                array(
                    'shop_bookkeeper_id' => $shopBookkeeperID,
                )
            );
            $shopIDs = Request_Nur_Shop::findShopBranchIDs(
                $sitePageData->shopMainID, $sitePageData, $driver, $params, 0, TRUE,
                array('shop_bookkeeper_id' => array('name'))
            );
        }

        if(count($shopIDs->childs) == 0){
            return array();
        }

        // получаем список групп, в которые входят задачи
        $params = Request_RequestParams::setParams(
            array(
                'shop_task_id' => $shopTaskIDs->getChildArrayID(),
            )
        );
        $shopTaskGroupIDs = Request_Nur_Shop_Task_Group_Item::findShopTaskGroupItemIDs(
            $sitePageData->shopMainID, $sitePageData, $driver, $params, 0, TRUE
        );

        // группируем задачи по группам
        $shopTaskIDs->runIndex();

        $shopTaskGroups = array();
        foreach ($shopTaskGroupIDs->childs as $shopTaskGroupID){
            $task = $shopTaskGroupID->values['shop_task_id'];
            if(!key_exists($task, $shopTaskIDs->childs)){
                continue;
            }

            $group = $shopTaskGroupID->values['shop_task_group_id'];
            if(!key_exists($group, $shopTaskGroups)){
                $shopTaskGroups[$group] = array();
            }

            $shopTaskGroups[$group][$task] = $shopTaskIDs->childs[$task];
        }
        // получаем список выполненных и выполняющихся заданий
        $params = Request_RequestParams::setParams(
            array(
                'period_basic_from' => $dateFrom,
                'period_basic_to' => $dateTo,
            )
        );
        $shopTaskCurrentIDs = Request_Nur_Shop_Task_Current::findBranchShopTaskCurrentIDs(
            $shopIDs->getChildArrayID(), $sitePageData, $driver, $params, 0, TRUE
        );

        $shopTaskCurrents = array();
        foreach ($shopTaskCurrentIDs->childs as $child){
            $shopTaskCurrents[$child->values['shop_task_id'].'-'.$child->values['shop_id']] = empty($child->values['date_finish']);
        }

        $result = array();
        $yearFrom = Helpers_DateTime::getYear($dateFrom);
        $yearTo = Helpers_DateTime::getYear($dateTo);
        foreach ($shopIDs->childs as $child){
            $taskIDs = Arr::path(json_decode($child->values['requisites'], TRUE), 'shop_group_task_ids', array());
            if((! is_array($taskIDs)) || (empty($taskIDs))){
                continue;
            }

            foreach ($shopTaskGroups as $shopTaskGroupID => $shopTasks) {
                if (array_search($shopTaskGroupID, $taskIDs) === FALSE) {
                    continue;
                }

                foreach ($shopTasks as $shopTaskID => $shopTask) {
                    $key = $shopTaskID.'-'.$child->id;
                    $isTask = key_exists($key, $shopTaskCurrents) !== FALSE;

                    if(($isTask) && (!$shopTaskCurrents[$key])){
                        continue;
                    }
                    if((!$isLoadFinish) && ($isTask)){
                        continue;
                    }

                    $dateFrom = Helpers_DateTime::changeDateYear($shopTask->values['date_from'], $yearFrom);
                    if(strtotime($shopTask->values['date_from']) < strtotime($shopTask->values['date_to'])){
                        $dateTo = Helpers_DateTime::changeDateYear($shopTask->values['date_to'], $yearTo);
                    }else{
                        $dateTo = Helpers_DateTime::changeDateYear($shopTask->values['date_to'], $yearFrom + 1);
                    }

                    $values = array(
                        'shop_id' => $child->id,
                        'shop_name' => $child->values['name'],
                        'shop_task_id' => $shopTaskID,
                        'shop_task_name' => $shopTask->values['name'],
                        'shop_bookkeeper_id' => $child->values['shop_bookkeeper_id'],
                        'shop_bookkeeper_name' => $child->getElementValue('shop_bookkeeper_id'),
                        'date_from' => $dateFrom,
                        'date_to' => $dateTo,
                    );

                    if($isTask && $shopTaskCurrents[$key]){
                        $values['status'] = 1;
                    }elseif(strtotime($dateTo) < time()){
                        $values['status'] = 2;
                    }else{
                        $values['status'] = 0;
                    }

                    $result[] = $values;
                }
            }
        }

        return $result;
    }

    /**
     * удаление 
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @return bool
     * @throws HTTP_Exception_500
     */
    public static function delete(SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        $id = Request_RequestParams::getParamInt('id');
        if($id < 0){
            return FALSE;
        }
        $isUnDel = Request_RequestParams::getParamBoolean("is_undel");

        $model = new Model_Nur_Shop_Task_Current();
        $model->setDBDriver($driver);

        if (!Helpers_DB::dublicateObjectLanguage($model, $id, $sitePageData)) {
            throw new HTTP_Exception_500('Current task not found.');
        }

        if (($isUnDel && !$model->getIsDelete()) or (!$isUnDel && $model->getIsDelete())){
            return FALSE;
        }

        if($isUnDel){
            $params = Request_RequestParams::setParams(
                array(
                    'shop_task_group_id' => $id,
                    'is_delete' => 1,
                    'is_public' => FALSE,
                )
            );
            $ids = Request_Nur_Shop_Task_Current_Item::findShopCurrentItemIDs(
                $sitePageData->shopID, $sitePageData, $driver, $params
            );
            $driver->unDeleteObjectIDs(
                $ids->getChildArrayID(), $sitePageData->userID, Model_Nur_Shop_Task_Current_Item::TABLE_NAME,
                array('is_public' => 1), $sitePageData->shopID
            );

            $model->dbUnDelete($sitePageData->userID, 0, $sitePageData->shopID);
        }else {
            $params = Request_RequestParams::setParams(
                array(
                    'shop_task_group_id' => $id,
                    'is_delete' => 0,
                    'is_public' => TRUE,
                )
            );
            $ids = Request_Nur_Shop_Task_Current_Item::findShopCurrentItemIDs(
                $sitePageData->shopID, $sitePageData, $driver, $params
            );
            $driver->deleteObjectIDs(
                $ids->getChildArrayID(), $sitePageData->userID, Model_Nur_Shop_Task_Current_Item::TABLE_NAME,
                array('is_public' => 0), $sitePageData->shopID
            );

            $model->dbDelete($sitePageData->userID, 0, $sitePageData->shopID);
        }

        return TRUE;
    }

    /**
     * Сохранение
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @return array
     * @throws HTTP_Exception_500
     */
    public static function save(SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        $model = new Model_Nur_Shop_Task_Current();
        $model->setDBDriver($driver);

        $id = Request_RequestParams::getParamInt('id');
        if($id > 0) {
            if (!Helpers_DB::dublicateObjectLanguage($model, $id, $sitePageData)) {
                throw new HTTP_Exception_500('Current not found.');
            }
        }

        Request_RequestParams::setParamBoolean('is_public', $model);
        Request_RequestParams::setParamStr('text', $model);
        Request_RequestParams::setParamStr('name', $model);
        Request_RequestParams::setParamStr("old_id", $model);

        $options = Request_RequestParams::getParamArray('options');
        if ($options !== NULL) {
            $model->addOptionsArray($options);
        }

        $result = array();
        if ($model->validationFields($result)) {
            if($model->id < 1) {
                Helpers_DB::saveDBObject($model, $sitePageData);
            }

            // загружаем фотографии
            $file = new Model_File($sitePageData);
            $file->saveFiles(Request_RequestParams::getParamArray('files'), $model, $sitePageData, $driver);

            // сохраняем товары
            $shopTaskCurrentItems = Request_RequestParams::getParamArray('shop_task_group_items');
            if($shopTaskCurrentItems !== NULL) {
                $model->setShopTaskIDsArray(
                    Api_Nur_Shop_Task_Current_Item::save(
                        $model->id, $shopTaskCurrentItems, $sitePageData, $driver
                    )
                );
            }

            Helpers_DB::saveDBObject($model, $sitePageData);
            $result['values'] = $model->getValues();
        }

        return array(
            'id' => $model->id,
            'result' => $result,
        );
    }
}
