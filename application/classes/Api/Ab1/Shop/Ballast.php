<?php defined('SYSPATH') or die('No direct script access.');

class Api_Ab1_Shop_Ballast  {

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

        $model = new Model_Ab1_Shop_Ballast();
        $model->setDBDriver($driver);

        if (!Helpers_DB::dublicateObjectLanguage($model, $id, $sitePageData)) {
            throw new HTTP_Exception_500('Ballast not found.');
        }

        if (($isUnDel && !$model->getIsDelete()) or (!$isUnDel && $model->getIsDelete())){
            return FALSE;
        }

        if($isUnDel){
            $model->dbUnDelete($sitePageData->userID, 0, $sitePageData->shopID);
            Api_Ab1_Shop_Register_Raw::unDelShopBallast($model, $sitePageData, $driver);
        }else {
            $model->dbDelete($sitePageData->userID, 0, $sitePageData->shopID);
            Api_Ab1_Shop_Register_Raw::delShopBallast($model, $sitePageData, $driver);
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
        $model = new Model_Ab1_Shop_Ballast();
        $model->setDBDriver($driver);

        $id = Request_RequestParams::getParamInt('id');
        if($id > 0) {
            if (!Helpers_DB::dublicateObjectLanguage($model, $id, $sitePageData)) {
                throw new HTTP_Exception_500('Ballast not found.');
            }
        }

        Request_RequestParams::setParamBoolean('is_public', $model);
        Request_RequestParams::setParamStr('text', $model);
        Request_RequestParams::setParamStr('name', $model);
        Request_RequestParams::setParamStr("old_id", $model);

        Request_RequestParams::setParamInt("shop_ballast_driver_id", $model);
        Request_RequestParams::setParamInt("shop_ballast_crusher_id", $model);
        Request_RequestParams::setParamInt('shop_ballast_distance_id', $model);
        Request_RequestParams::setParamInt("take_shop_ballast_crusher_id", $model);
        Request_RequestParams::setParamInt('shop_work_shift_id', $model);
        Request_RequestParams::setParamDateTime('date', $model);
        Request_RequestParams::setParamBoolean('is_storage', $model);
        Request_RequestParams::setParamDateTime('created_at', $model);

        $shopBallastCarID = $model->getShopBallastCarID();
        Request_RequestParams::setParamInt('shop_ballast_car_id', $model);

        if($shopBallastCarID != $model->getShopBallastCarID()){
            $modelCar = new Model_Ab1_Shop_Ballast_Car();
            $modelCar->setDBDriver($driver);
            if(Helpers_DB::getDBObject($modelCar, $model->getShopBallastCarID(), $sitePageData, $sitePageData->shopMainID)){
                $model->setQuantity($modelCar->getQuantity());
                $model->setName($modelCar->getName());
            }else{
                $model->setQuantity(14);
            }

            $model->setShopTransportID($modelCar->getShopTransportID());
        }

        // определяем привязку к путевому листу
        if($model->getDate() != $model->getOriginalValue('date')
            || $model->getShopTransportID() != $model->getOriginalValue('shop_transport_id')){
            $model->setShopTransportWaybillID(
                Api_Ab1_Shop_Transport_Waybill::findWaybillID(
                    $model->getShopTransportID(), $model->getDate(), $sitePageData, $driver
                )
            );
        }else{
            $model->setShopTransportWaybillID(0);
        }

        $options = Request_RequestParams::getParamArray('options');
        if ($options !== NULL) {
            $model->addOptionsArray($options);
        }

        $result = array();
        if ($model->validationFields($result)) {
            if($model->getShopBallastDistanceID() != $model->getOriginalValue('shop_ballast_distance_id')){
                /** @var Model_Ab1_Shop_Ballast_Distance $modelDistance */
                $modelDistance = $model->getElement('shop_ballast_distance_id', true);
                $model->setTariff($modelDistance->getTariff());
                $model->setTariffHoliday($modelDistance->getTariffHoliday());
            }

            if($model->getShopBallastCrusherID() != $model->getOriginalValue('shop_ballast_crusher_id')){
                /** @var Model_Ab1_Shop_Ballast_Crusher $modelCrusher */
                $modelCrusher = $model->getElement('shop_ballast_crusher_id', true);
                $model->setIsStorage($modelCrusher->getIsStorage());
            }

            if($model->getShopRawID() < 1){
                $model->setShopRawID(423186);  // балласт
            }
            if($model->id < 1) {
                // проверяем, чтобы не создавали подряд две одинаковые машины в течение 2 минут
                if(Request_RequestParams::getParamBoolean('is_add') && !$sitePageData->operation->getIsAdmin()) {
                    $ids = Request_Request::find('DB_Ab1_Shop_Ballast',
                        $sitePageData->shopID, $sitePageData, $driver,
                        Request_RequestParams::setParams(
                            array(
                                'shop_ballast_car_id' => $model->getShopBallastCarID(),
                                'created_at_from' => Helpers_DateTime::minusMinutes(date('Y-m-d H:i:s'), 1),
                            )
                        ),
                        1, TRUE
                    );
                    if (count($ids->childs) > 0) {
                        return array(
                            'id' => $ids->childs[0]->id,
                            'result' => array(
                                'error' => TRUE,
                                'values' => $ids->childs[0]->values,
                            ),
                        );
                    }
                }

                if(Func::_empty($model->getDate())) {
                    $model->setDate(date('Y-m-d H:i:s'));
                }
                Helpers_DB::saveDBObject($model, $sitePageData);
            }

            // загружаем фотографии
            $file = new Model_File($sitePageData);
            $file->saveFiles(Request_RequestParams::getParamArray('files'), $model, $sitePageData, $driver);

            Helpers_DB::saveDBObject($model, $sitePageData);
            $result['values'] = $model->getValues();

            Api_Ab1_Shop_Register_Raw::saveShopBallast($model, $sitePageData, $driver);
        }

        return array(
            'id' => $model->id,
            'result' => $result,
        );
    }
}
