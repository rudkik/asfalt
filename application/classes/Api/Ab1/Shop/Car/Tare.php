<?php defined('SYSPATH') or die('No direct script access.');

class Api_Ab1_Shop_Car_Tare  {
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

        $model = new Model_Ab1_Shop_Car_Tare();
        $model->setDBDriver($driver);

        if (!Helpers_DB::dublicateObjectLanguage($model, $id, $sitePageData, $sitePageData->shopMainID)) {
            throw new HTTP_Exception_500('Car tare not found.');
        }

        if(Request_RequestParams::getParamBoolean("is_undel") === TRUE){
            $model->dbUnDelete($sitePageData->userID, 0, $sitePageData->shopID);
        }else {
            $model->dbDelete($sitePageData->userID, 0, $sitePageData->shopID);
        }
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
        $model = new Model_Ab1_Shop_Car_Tare();
        $model->setDBDriver($driver);
        $id = Request_RequestParams::getParamInt('id');
        if($id > 0) {
            if (!Helpers_DB::dublicateObjectLanguage($model, $id, $sitePageData, $sitePageData->shopMainID)) {
                throw new HTTP_Exception_500('Car tare not found.');
            }
        }

        Request_RequestParams::setParamBoolean('is_public', $model);
        Request_RequestParams::setParamStr('name', $model);
        Request_RequestParams::setParamBoolean("is_public", $model);
        Request_RequestParams::setParamFloat("weight", $model);
        Request_RequestParams::setParamStr('driver', $model);
        Request_RequestParams::setParamBoolean('is_test', $model);
        Request_RequestParams::setParamInt('shop_transport_company_id', $model);
        Request_RequestParams::setParamInt('shop_transport_id', $model);
        Request_RequestParams::setParamInt('tare_type_id', $model);
        Request_RequestParams::setParamInt('shop_client_id', $model);

        $result = array();
        if ($model->validationFields($result)) {
            if($model->id < 1){
                $modelOld = Request_Request::findOneModel(
                    'DB_Ab1_Shop_Car_Tare', $sitePageData->shopID, $sitePageData, $driver,
                    Request_RequestParams::setParams(
                        array(
                            'tare_type_id' => $model->getTareTypeID(),
                            'name_full' => $model->getName(),
                        )
                    )
                );

                if($modelOld != null){
                    $modelOld->setWeight($model->getWeight());
                    $model = $modelOld;
                }
            }

            Helpers_DB::saveDBObject($model, $sitePageData, $sitePageData->shopMainID);
            $result['values'] = $model->getValues();
        }

        return array(
            'id' => $model->id,
            'tare_type_id' => $model->getTareTypeID(),
            'result' => $result,
        );
    }
}
