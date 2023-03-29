<?php defined('SYSPATH') or die('No direct script access.');

class Api_Ab1_Shop_Boxcar_Train  {

    /**
     * удаление товара
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

        $model = new Model_Ab1_Shop_Boxcar_Train();
        $model->setDBDriver($driver);

        if (!Helpers_DB::dublicateObjectLanguage($model, $id, $sitePageData)) {
            throw new HTTP_Exception_500('Train not found.');
        }

        if (($isUnDel && !$model->getIsDelete()) or (!$isUnDel && $model->getIsDelete())){
            return FALSE;
        }

        if ($isUnDel){
            $shopBoxcarIDs = Request_Request::find('DB_Ab1_Shop_Boxcar', $sitePageData->shopID, $sitePageData, $driver,
                array('shop_boxcar_train_id' => $id, 'is_delete' => 1, 'is_public' => 0, Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE));

            $driver->unDeleteObjectIDs($shopBoxcarIDs->getChildArrayID(), $sitePageData->userID, Model_Ab1_Shop_Boxcar::TABLE_NAME,
                array('is_public' => 1), $sitePageData->shopID);
        }else{
            $shopBoxcarIDs = Request_Request::find('DB_Ab1_Shop_Boxcar', $sitePageData->shopID, $sitePageData, $driver,
                array('shop_boxcar_train_id' => $id, Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE));

            $driver->deleteObjectIDs($shopBoxcarIDs->getChildArrayID(), $sitePageData->userID, Model_Ab1_Shop_Boxcar::TABLE_NAME,
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
     * Сохранение
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @return array
     * @throws HTTP_Exception_500
     */
    public static function save(SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        $model = new Model_Ab1_Shop_Boxcar_Train();
        $model->setDBDriver($driver);

        $id = Request_RequestParams::getParamInt('id');
        if($id > 0) {
            if (!Helpers_DB::dublicateObjectLanguage($model, $id, $sitePageData)) {
                throw new HTTP_Exception_500('Train not found.');
            }
        }

        Request_RequestParams::setParamBoolean('is_public', $model);
        Request_RequestParams::setParamStr('text', $model);
        Request_RequestParams::setParamStr('name', $model);
        Request_RequestParams::setParamStr("old_id", $model);
        Request_RequestParams::setParamInt("shop_raw_id", $model);
        Request_RequestParams::setParamInt("shop_boxcar_departure_station_id", $model);
        Request_RequestParams::setParamInt("shop_boxcar_client_id", $model);
        Request_RequestParams::setParamInt("shop_boxcar_factory_id", $model);
        Request_RequestParams::setParamInt("shop_client_id", $model);
        Request_RequestParams::setParamInt("shop_client_contract_id", $model);

        Request_RequestParams::setParamStr("tracker", $model);
        Request_RequestParams::setParamStr("contract_number", $model);
        Request_RequestParams::setParamDateTime('contract_date', $model);

        Request_RequestParams::setParamDateTime('date_shipment', $model);
        Request_RequestParams::setParamStr("downtime_permitted", $model);
        Request_RequestParams::setParamFloat("fine_day", $model);

        $options = Request_RequestParams::getParamArray('options');
        if ($options !== NULL) {
            $model->addOptionsArray($options);
        }

        $result = array();
        if ($model->validationFields($result)) {
            if($model->id < 1) {
                Helpers_DB::saveDBObject($model, $sitePageData);
            }

            // сохраняем список вагонов
            $shopBoxcars = Request_RequestParams::getParamArray('shop_boxcars');
            if($shopBoxcars !== NULL) {
                $model->setIsExit(Api_Ab1_Shop_Boxcar::saveList($model, $shopBoxcars, $sitePageData, $driver));
            }

            // загружаем фотографии
            $file = new Model_File($sitePageData);
            $file->saveFiles(Request_RequestParams::getParamArray('files'), $model, $sitePageData, $driver);

            Helpers_DB::saveDBObject($model, $sitePageData);
            $result['values'] = $model->getValues();
        }

        return array(
            'id' => $model->id,
            'result' => $result,
        );
    }
}
