<?php defined('SYSPATH') or die('No direct script access.');

class Api_Ab1_Shop_Defect_Car  {
    /**
     * Получаем список выехавших машин за заданный период
     * @param $dateFrom
     * @param $dateTo
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @param null $elements
     * @param array $params
     * @param bool $isAllBranch
     * @return MyArray
     */
    public static function getExitShopDefectCar($dateFrom, $dateTo, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver,
                                          $elements = NULL, $params = array(), $isAllBranch = false)
    {
        $params = array_merge(
            $params,
            Request_RequestParams::setParams(
                array(
                    'exit_at_from' => $dateFrom,
                    'exit_at_to' => $dateTo,
                    'is_exit' => 1,
                    'quantity_from' => 0,
                )
            )
        );

        $shopID = $sitePageData->shopID;
        if($isAllBranch){
            $shopID = 0;
        }

        $shopDefectCarIDs = Request_Request::find('DB_Ab1_Shop_Defect_Car',
            $shopID, $sitePageData, $driver, $params, 0, TRUE, $elements
        );

        return $shopDefectCarIDs;
    }

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

        $model = new Model_Ab1_Shop_Defect_Car();
        $model->setDBDriver($driver);

        if (!Helpers_DB::dublicateObjectLanguage($model, $id, $sitePageData)) {
            throw new HTTP_Exception_500('Car not found.');
        }

        if(Request_RequestParams::getParamBoolean("is_undel") === TRUE){
            $model->dbUnDelete($sitePageData->userID, 0, $sitePageData->shopID);
            Api_Ab1_Shop_Register_Material::unDelShopDefectCar($model, $sitePageData, $driver);
        }else {
            $model->dbDelete($sitePageData->userID, 0, $sitePageData->shopID);
            Api_Ab1_Shop_Register_Material::delShopDefectCar($model, $sitePageData, $driver);
        }

        // пересчитать баланс остатка продукции
        Api_Ab1_Shop_Product_Storage::calcProductBalance(
            $model->getShopProductID(), $model->getShopStorageID(), $sitePageData, $driver, true
        );
    }


    /**
     * Сохранение
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @param bool $isWeighted
     * @return array
     * @throws HTTP_Exception_500
     */
    public static function save(SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver, $isWeighted = true)
    {
        $model = new Model_Ab1_Shop_Defect_Car();
        $model->setDBDriver($driver);

        $id = Request_RequestParams::getParamInt('id');
        if($id > 0) {
            if (!Helpers_DB::dublicateObjectLanguage($model, $id, $sitePageData)) {
                throw new HTTP_Exception_500('Car not found.');
            }
        }

        Request_RequestParams::setParamInt("shop_table_rubric_id", $model);
        Request_RequestParams::setParamBoolean('is_public', $model);
        Request_RequestParams::setParamStr('text', $model);
        Request_RequestParams::setParamStr('name', $model);
        Request_RequestParams::setParamStr("old_id", $model);
        Request_RequestParams::setParamInt("shop_table_select_id", $model);
        Request_RequestParams::setParamInt("shop_table_unit_id", $model);
        Request_RequestParams::setParamInt("shop_table_brand_id", $model);
        Request_RequestParams::setParamInt("shop_payment_id", $model);
        Request_RequestParams::setParamInt("shop_transport_company_id", $model);
        Request_RequestParams::setParamInt("shop_storage_id", $model);
        Request_RequestParams::setParamInt("shop_turn_place_id", $model);
        Request_RequestParams::setParamInt("shop_client_id", $model);
        Request_RequestParams::setParamInt('shop_product_id', $model);
        Request_RequestParams::setParamFloat('quantity', $model);
        Request_RequestParams::setParamInt('shop_driver_id', $model);
        Request_RequestParams::setParamDateTime('exit_at', $model);
        Request_RequestParams::setParamDateTime('arrival_at', $model);
        Request_RequestParams::setParamBoolean('is_delivery', $model);

        $options = Request_RequestParams::getParamArray('options');
        if ($options !== NULL) {
            $model->addOptionsArray($options);
        }

        // добавляем id водителя
        $driverName = Request_RequestParams::getParamStr('shop_driver_name');
        if($driverName !== NULL) {
            $model->setShopDriverID(
                Api_Ab1_Shop_Driver::getShopDriverIDByName(
                    $driverName, $model->getShopClientID(), $sitePageData, $driver
                )
            );
        }

        $model->setShopTransportID(
            Request_Request::findIDByField(
                'DB_Ab1_Shop_Transport', 'number_full', $model->getName(), 0, $sitePageData, $driver
            )
        );

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
        if(!$model->getIsDelivery()
            && ($model->getCreatedAt() != $model->getOriginalValue('created_at')
                || $model->getShopTransportID() != $model->getOriginalValue('shop_transport_id'))){
            $model->setShopTransportWaybillID(
                Api_Ab1_Shop_Transport_Waybill::findWaybillID(
                    $model->getShopTransportID(), $model->getCreatedAt(), $sitePageData, $driver
                )
            );
        }else{
            $model->setShopTransportWaybillID(0);
        }

        // Ставим очередь для машины через весовую
        if($isWeighted) {
            Api_Ab1_Shop_Turn_Place::setTurn($model, $sitePageData, $driver);
        }

        $options = Request_RequestParams::getParamArray('options');
        if ($options !== NULL) {
            $model->addOptionsArray($options);
        }

        $result = array();
        if ($model->validationFields($result)) {
            // счетчик как в 1с
            DB_Basic::setNumber1CIfEmpty($model, 'number', $sitePageData, $driver, $sitePageData->shopID);

            if($model->isEditValue('shop_product_id')){
                $modelProduct = new Model_Ab1_Shop_Product();
                $modelProduct->setDBDriver($driver);

                Helpers_DB::getDBObject($modelProduct, $model->getShopProductID(), $sitePageData);

                $model->setShopSubdivisionID($modelProduct->getShopSubdivisionID());
                $model->setShopStorageID($modelProduct->getShopStorageID());
            }

            if($model->id < 1) {
                if(!$isWeighted){
                    $model->setIsExit(true);
                    $model->setExitAt(date('Y-m-d H:i:s'));
                }

                $model->setCashOperationID($sitePageData->operationID);
                Helpers_DB::saveDBObject($model, $sitePageData);
            }

            // Сохраняем расхода материалов по рецептам
            Api_Ab1_Shop_Register_Material::saveShopDefectCar($model, $sitePageData, $driver);

            // пересчитать баланс остатка продукции
            Api_Ab1_Shop_Product_Storage::calcProductBalance(
                $model->getShopProductID(), $model->getShopStorageID(), $sitePageData, $driver, true
            );
            if($model->getShopProductID() != $model->getOriginalValue('shop_product_id')
                || $model->getShopStorageID() != $model->getOriginalValue('shop_storage_id')) {
                Api_Ab1_Shop_Product_Storage::calcProductBalance(
                    $model->getOriginalValue('shop_product_id'),
                    $model->getOriginalValue('shop_storage_id'),
                    $sitePageData, $driver, true
                );
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
        $carIDs = Request_Request::find('DB_Ab1_Shop_Defect_Car', $sitePageData->shopID, $sitePageData, $driver,
            array(Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE, 'created_at_from' => $from, 'created_at_to' => $to,
                'is_exit' => 1), 0, TRUE);

        $modelProduct = new Model_Ab1_Shop_Product();
        $modelProduct->setDBDriver($driver);

        $modelClient = new Model_Ab1_Shop_Client();
        $modelClient->setDBDriver($driver);

        $data = '<?xml version="1.0" encoding="UTF-8"?><Data1C>';
        foreach($carIDs->childs as $car){
            if ((floatval($car->values['quantity']) < 0.001)
                || (!Helpers_DB::getDBObject($modelClient, $car->values['shop_client_id'], $sitePageData, $sitePageData->shopMainID))
                || (!Helpers_DB::getDBObject($modelProduct, $car->values['shop_product_id'], $sitePageData))){
                continue;
            }

            $data .= '<move>'
                .'<NumDoc>'.$car->values['number'].'</NumDoc>'
                .'<DateDoc>'.strftime('%d.%m.%Y %H:%M:%S', strtotime($car->values['created_at'])).'</DateDoc>'
                .'<subdivision_id>'.$modelClient->getOldID().'</subdivision_id>';

            $data .= '<GoodString>'
                .'<Code>'.$modelProduct->getOldID().'</Code>'
                .'<quantity>'.$car->values['quantity'].'</quantity>'
                .'</GoodString>';

            $data .= '</move>';
        }
        $data .= '</Data1C>';

        if($isPHPOutput) {
            header('Content-Type: text/xml');
            header('Content-Disposition: attachment;filename="move.xml"');
            header('Cache-Control: max-age=0');

            echo $data;
            exit();
        }

        return $data;
    }
}
