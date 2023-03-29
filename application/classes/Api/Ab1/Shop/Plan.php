<?php defined('SYSPATH') or die('No direct script access.');

class Api_Ab1_Shop_Plan  {
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

        $model = new Model_Ab1_Shop_Plan();
        $model->setDBDriver($driver);

        if (!Helpers_DB::dublicateObjectLanguage($model, $id, $sitePageData)) {
            throw new HTTP_Exception_500('Plan not found.');
        }

        if (($isUnDel && !$model->getIsDelete()) or (!$isUnDel && $model->getIsDelete())){
            return FALSE;
        }

        if ($isUnDel){
            $shopPlanItemIDs = Request_Request::find('DB_Ab1_Shop_Plan_Item', $sitePageData->shopID, $sitePageData, $driver,
                array('shop_plan_id' => $id, 'is_delete' => 1, 'is_public' => 0, Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE));

            $driver->unDeleteObjectIDs($shopPlanItemIDs->getChildArrayID(), $sitePageData->userID, Model_Ab1_Shop_Plan_Item::TABLE_NAME,
                array('is_public' => 1), $sitePageData->shopID);
        }else{
            $shopPlanItemIDs = Request_Request::find('DB_Ab1_Shop_Plan_Item', $sitePageData->shopID, $sitePageData, $driver,
                array('shop_plan_id' => $id, Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE));

            $driver->deleteObjectIDs($shopPlanItemIDs->getChildArrayID(), $sitePageData->userID, Model_Ab1_Shop_Plan_Item::TABLE_NAME,
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
        $model = new Model_Ab1_Shop_Plan();
        $model->setDBDriver($driver);

        $id = Request_RequestParams::getParamInt('id');
        if($id > 0) {
            if (!Helpers_DB::dublicateObjectLanguage($model, $id, $sitePageData)) {
                throw new HTTP_Exception_500('Plan not found.');
            }
        }

        Request_RequestParams::setParamBoolean('is_public', $model);
        Request_RequestParams::setParamStr('text', $model);
        Request_RequestParams::setParamStr('name', $model);
        Request_RequestParams::setParamStr("old_id", $model);
        Request_RequestParams::setParamInt('shop_client_id', $model);
        Request_RequestParams::setParamDateTime('date', $model);

        $model->setTimeFrom(Request_RequestParams::getParamTime('time_from'));
        $model->setTimeTo(Request_RequestParams::getParamTime('time_to'));

        Request_RequestParams::setParamStr("facility", $model);
        Request_RequestParams::setParamInt('car_count', $model);
        Request_RequestParams::setParamInt('shop_client_foreman_id', $model);

        $cars = Request_RequestParams::getParamArray('cars');
        if ($cars !== NULL) {
            $model->setCarsArray($cars);
        }

        $deliveries = Request_RequestParams::getParamArray('deliveries');
        if ($deliveries !== NULL) {
            $model->setDeliveriesArray($deliveries);
        }

        $options = Request_RequestParams::getParamArray('options');
        if ($options !== NULL) {
            $model->addOptionsArray($options);
        }

        $result = array();
        if ($model->validationFields($result)) {
            if ($model->id < 1){
                Helpers_DB::saveDBObject($model, $sitePageData);
            }

            $shopPlanItems = Request_RequestParams::getParamArray('shop_plan_items');
            if($shopPlanItems !== NULL) {
                Api_Ab1_Shop_Plan_Item::saveList($model->id, $model->getShopClientID(), $model->getDate(), $model->getDateFrom(),
                    $model->getDateTo(), $shopPlanItems, $sitePageData, $driver);
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
