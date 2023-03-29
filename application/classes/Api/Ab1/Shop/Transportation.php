<?php defined('SYSPATH') or die('No direct script access.');

class Api_Ab1_Shop_Transportation  {
    /**
     * Сохранение
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @return array
     * @throws HTTP_Exception_500
     */
    public static function save(SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        $model = new Model_Ab1_Shop_Transportation();
        $model->setDBDriver($driver);

        $id = Request_RequestParams::getParamInt('id');
        if($id > 0) {
            if (!Helpers_DB::dublicateObjectLanguage($model, $id, $sitePageData)) {
                throw new HTTP_Exception_500('Transportation not found.');
            }
        }

        Request_RequestParams::setParamBoolean('is_public', $model);
        Request_RequestParams::setParamStr('text', $model);
        Request_RequestParams::setParamStr('name', $model);
        Request_RequestParams::setParamStr("old_id", $model);

        Request_RequestParams::setParamInt("shop_ballast_driver_id", $model);
        Request_RequestParams::setParamInt('shop_ballast_distance_id', $model);
        Request_RequestParams::setParamInt("shop_transportation_place_id", $model);
        Request_RequestParams::setParamInt('shop_work_shift_id', $model);
        Request_RequestParams::setParamDateTime('date', $model);
        Request_RequestParams::setParamDateTime('created_at', $model);
        Request_RequestParams::setParamInt("flight", $model);

        $shopBallastCarIDID = $model->getShopBallastCarID();
        Request_RequestParams::setParamInt('shop_ballast_car_id', $model);

        if($shopBallastCarIDID != $model->getShopBallastCarID()){
            $modelCar = new Model_Ab1_Shop_Ballast_Car();
            $modelCar->setDBDriver($driver);
            if(Helpers_DB::getDBObject($modelCar, $model->getShopBallastCarID(), $sitePageData, $sitePageData->shopMainID)){
                $model->setName($modelCar->getName());
            }else{
                $model->setName('');
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
                /** @var Model_Ab1_Shop_Transportation_Distance $modelDistance */
                $modelDistance = $model->getElement('shop_ballast_distance_id', true);
                $model->setTariff($modelDistance->getTariff());
                $model->setTariffHoliday($modelDistance->getTariffHoliday());
            }

            if($model->id < 1) {
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
        }

        return array(
            'id' => $model->id,
            'result' => $result,
        );
    }
}
