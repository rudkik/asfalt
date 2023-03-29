<?php defined('SYSPATH') or die('No direct script access.');

class Api_Ab1_Shop_Plan_Transport  {
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

        $model = new Model_Ab1_Shop_Plan_Transport();
        $model->setDBDriver($driver);

        if (!Helpers_DB::dublicateObjectLanguage($model, $id, $sitePageData)) {
            throw new HTTP_Exception_500('Plan transport not found.');
        }

        if (($isUnDel && !$model->getIsDelete()) or (!$isUnDel && $model->getIsDelete())){
            return FALSE;
        }

        if ($isUnDel){
            $shopPlanTransportItemIDs = Request_Request::find('DB_Ab1_Shop_Plan_Transport_Item', $sitePageData->shopID, $sitePageData, $driver,
                array('shop_plan_id' => $id, 'is_delete' => 1, 'is_public' => 0, Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE));

            $driver->unDeleteObjectIDs($shopPlanTransportItemIDs->getChildArrayID(), $sitePageData->userID, Model_Ab1_Shop_Plan_Transport_Item::TABLE_NAME,
                array('is_public' => 1), $sitePageData->shopID);
        }else{
            $shopPlanTransportItemIDs = Request_Request::find('DB_Ab1_Shop_Plan_Transport_Item', $sitePageData->shopID, $sitePageData, $driver,
                array('shop_plan_id' => $id, Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE));

            $driver->deleteObjectIDs($shopPlanTransportItemIDs->getChildArrayID(), $sitePageData->userID, Model_Ab1_Shop_Plan_Transport_Item::TABLE_NAME,
                array('is_public' => 0), $sitePageData->shopID);
        }

        if($isUnDel){
            $model->dbUnDelete($sitePageData->userID, 0, $sitePageData->shopID);
        }else {
            $model->dbDelete($sitePageData->userID, 0, $sitePageData->shopID);
        }

        return TRUE;
    }

    /**
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @return array
     * @throws HTTP_Exception_500
     */
    public static function save(SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        $model = new Model_Ab1_Shop_Plan_Transport();
        $model->setDBDriver($driver);

        $id = Request_RequestParams::getParamInt('id');
        if($id > 0) {
            if (!Helpers_DB::dublicateObjectLanguage($model, $id, $sitePageData)) {
                throw new HTTP_Exception_500('Plan transport not found.');
            }
        }

        Request_RequestParams::setParamBoolean('is_public', $model);
        Request_RequestParams::setParamStr('text', $model);
        Request_RequestParams::setParamStr('name', $model);
        Request_RequestParams::setParamStr("old_id", $model);
        Request_RequestParams::setParamDateTime('date', $model);

        $options = Request_RequestParams::getParamArray('options');
        if ($options !== NULL) {
            $model->addOptionsArray($options);
        }

        $result = array();
        if ($model->validationFields($result)) {
            if ($model->id < 1){
                Helpers_DB::saveDBObject($model, $sitePageData);
            }

            $shopPlanTransportItems = Request_RequestParams::getParamArray('shop_plan_transport_items');
            if($shopPlanTransportItems !== NULL) {
                $model->setCount(
                    Api_Ab1_Shop_Plan_Transport_Item::save(
                        $model->id, $model->getDate(), $shopPlanTransportItems, $sitePageData, $driver
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
