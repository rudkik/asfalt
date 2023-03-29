<?php defined('SYSPATH') or die('No direct script access.');

class Api_Ab1_Shop_Move_Other  {
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

        $model = new Model_Ab1_Shop_Move_Other();
        $model->setDBDriver($driver);

        if (!Helpers_DB::dublicateObjectLanguage($model, $id, $sitePageData)) {
            throw new HTTP_Exception_500('Car not found.');
        }

        if(Request_RequestParams::getParamBoolean("is_undel") === TRUE){
            $model->dbUnDelete($sitePageData->userID, 0, $sitePageData->shopID);
        }else {
            $model->dbDelete($sitePageData->userID, 0, $sitePageData->shopID);
        }
    }


    /**
     * Сохранение товары
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @return array
     * @throws HTTP_Exception_500
     */
    public static function save(SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        $model = new Model_Ab1_Shop_Move_Other();
        $model->setDBDriver($driver);

        $id = Request_RequestParams::getParamInt('id');
        if($id > 0) {
            if (!Helpers_DB::dublicateObjectLanguage($model, $id, $sitePageData)) {
                throw new HTTP_Exception_500('Car not found.');
            }
        }

        Request_RequestParams::setParamBoolean('is_public', $model);
        Request_RequestParams::setParamStr('text', $model);
        Request_RequestParams::setParamStr('name', $model);
        Request_RequestParams::setParamStr("old_id", $model);

        Request_RequestParams::setParamInt("shop_material_id", $model);
        Request_RequestParams::setParamInt("shop_material_other_id", $model);
        Request_RequestParams::setParamInt("shop_transport_company_id", $model);
        Request_RequestParams::setParamInt("shop_move_place_id", $model);

        Request_RequestParams::setParamFloat('quantity', $model);
        Request_RequestParams::setParamInt('shop_driver_id', $model);
        Request_RequestParams::setParamDateTime('exit_at', $model);
        Request_RequestParams::setParamDateTime('created_at', $model);
        Request_RequestParams::setParamDateTime('weighted_exit_at', $model);

        $shopCarTareID = $model->getShopCarTareID();
        Request_RequestParams::setParamInt('shop_car_tare_id', $model);
        if ($shopCarTareID != $model->getShopCarTareID() || Func::_empty($model->getName()) || $model->getShopTransportID() == 0) {
            $modelCarTare = new Model_Ab1_Shop_Car_Tare();
            $modelCarTare->setDBDriver($driver);
            Helpers_DB::getDBObject($modelCarTare, $model->getShopCarTareID(), $sitePageData, $sitePageData->shopMainID);
            $model->setShopTransportID($modelCarTare->getShopTransportID());

            $model->setTarra($modelCarTare->getWeight());
            $model->setName($modelCarTare->getName());
        }

        // определяем транспортную компанию
        if($model->isEditValue('name') || $model->getShopTransportCompanyID() < 1){
            $carTare = Request_Request::findOneByField(
                'DB_Ab1_Shop_Car_Tare', 'name_full', $model->getName(), 0, $sitePageData, $driver
            );
            if($carTare != null && $carTare->values['shop_transport_company_id'] > 0) {
                $model->setShopTransportCompanyID($carTare->values['shop_transport_company_id']);
            }elseif($model->isEditValue('name')){
                $model->setShopTransportCompanyID(0);
            }
        }

        // определяем привязку к путевому листу
        if($model->id < 1
            || $model->getCreatedAt() != $model->getOriginalValue('created_at')
            || $model->getShopTransportID() != $model->getOriginalValue('shop_transport_id')){
            $model->setShopTransportWaybillID(
                Api_Ab1_Shop_Transport_Waybill::findWaybillID(
                    $model->getShopTransportID(), $model->getCreatedAt(), $sitePageData, $driver
                )
            );
        }

        $options = Request_RequestParams::getParamArray('options');
        if ($options !== NULL) {
            $model->addOptionsArray($options);
        }

        $model->setName(mb_strtoupper($model->getName()));

        $driverName = Request_RequestParams::getParamStr('shop_driver_name');
        if($driverName !== NULL) {
            if (!empty($driverName)) {
                $shopDriverIDs = Request_Request::find('DB_Ab1_Shop_Driver', $sitePageData->shopMainID, $sitePageData, $driver,
                    array('shop_client_id' => $model->getShopMovePlaceID(), 'name_full' => $driverName,
                        Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE), 1);

                if (count($shopDriverIDs->childs) > 0) {
                    $shopDriverID = $shopDriverIDs->childs[0]->id;
                } else {
                    $modelDriver = new Model_Ab1_Shop_Driver();
                    $modelDriver->setDBDriver($driver);
                    $modelDriver->setName($driverName);
                    $modelDriver->setShopClientID($model->getShopMovePlaceID());
                    $shopDriverID = Helpers_DB::saveDBObject($modelDriver, $sitePageData, $sitePageData->shopMainID);
                }
            } else {
                $shopDriverID = 0;
            }
            $model->setShopDriverID($shopDriverID);
        }

        $options = Request_RequestParams::getParamArray('options');
        if ($options !== NULL) {
            $model->addOptionsArray($options);
        }

        $result = array();
        if ($model->validationFields($result)) {
            if($model->id < 1) {
                $model->setWeightedExitOperationID($sitePageData->operationID);
                $model->setWeightedExitAt(date('Y-m-d H:i:s'));

                $brutto = Request_RequestParams::getParamFloat('brutto');
                if($brutto >= $model->getTarra()){
                    $model->setQuantity($brutto - $model->getTarra());
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

    /**
     * Сохраняем машины + оплату в виде XML
     * @param $from
     * @param $to
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @return string
     */
    public static function saveXML($from, $to, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver, $isPHPOutput = FALSE)
    {
        // получаем список машина
        $carIDs = Request_Request::find('DB_Ab1_Shop_Move_Other', $sitePageData->shopID, $sitePageData, $driver,
            array(Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE, 'created_at_from' => $from, 'created_at_to' => $to), 0, TRUE);

        $modelMaterial = new Model_Ab1_Shop_Material();
        $modelMaterial->setDBDriver($driver);

        $modelPlace = new Model_Ab1_Shop_Move_Place();
        $modelPlace->setDBDriver($driver);

        $data = '<?xml version="1.0" encoding="UTF-8"?><Data1C>';
        foreach($carIDs->childs as $car){
            if ((floatval($car->values['quantity']) < 0.001)
                || (!Helpers_DB::getDBObject($modelPlace, $car->values['shop_move_place_id'], $sitePageData, $sitePageData->shopMainID))
                || (!Helpers_DB::getDBObject($modelMaterial, $car->values['shop_material_id'], $sitePageData))){
                continue;
            }

            $data .= '<move>'
                .'<NumDoc>'.$car->values['number'].'</NumDoc>'
                .'<DateDoc>'.strftime('%d.%m.%Y %H:%M:%S', strtotime($car->values['created_at'])).'</DateDoc>'
                .'<subdivision_id>'.$modelPlace->getOldID().'</subdivision_id>';

            $data .= '<GoodString>'
                .'<Code>'.$modelMaterial->getOldID().'</Code>'
                .'<quantity>'.$car->values['quantity'].'</quantity>'
                .'</GoodString>';

            $data .= '</move>';
        }
        $data .= '</Data1C>';

        if($isPHPOutput) {
            header('Content-Type: text/xml');
            header('Content-Disposition: attachment;filename="move-other.xml"');
            header('Cache-Control: max-age=0');

            echo $data;
            exit();
        }

        return $data;
    }
}
