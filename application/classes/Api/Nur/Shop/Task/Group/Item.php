<?php defined('SYSPATH') or die('No direct script access.');

class Api_Nur_Shop_Task_Group_Item  {

    /**
     * Сохранение список
     * @param $shopTaskGroupID
     * @param array $shopTaskGroupItems
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @return array
     */
    public static function save($shopTaskGroupID, array $shopTaskGroupItems,
                                SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        $model = new Model_Nur_Shop_Task_Group_Item();
        $model->setDBDriver($driver);

        $params = Request_RequestParams::setParams(
            array(
                'shop_task_group_id' => $shopTaskGroupID,
            )
        );
        $shopTaskGroupItemIDs = Request_Nur_Shop_Task_Group_Item::findShopTaskGroupItemIDs(
            $sitePageData->shopID, $sitePageData, $driver, $params, 0, TRUE
        );

        $result = array();
        foreach($shopTaskGroupItems as $shopTaskID){
            $shopTaskID = intval($shopTaskID);
            if($shopTaskID <= 0){
                continue;
            }

            $model->clear();
            $shopTaskGroupItemID = array_shift($shopTaskGroupItemIDs->childs);
            if($shopTaskGroupItemID !== NULL){
                $shopTaskGroupItemID->setModel($model);
            }

            $model->setShopTaskID($shopTaskID);
            $model->setShopTaskGroupID($shopTaskGroupID);
            Helpers_DB::saveDBObject($model, $sitePageData);
            $result[] = $shopTaskID;
        }

        // удаляем лишние
        $driver->deleteObjectIDs(
            $shopTaskGroupItemIDs->getChildArrayID(), $sitePageData->userID,
            Model_Nur_Shop_Task_Group_Item::TABLE_NAME, array(), $sitePageData->shopID
        );

        return $result;
    }
}
