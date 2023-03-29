<?php defined('SYSPATH') or die('No direct script access.');

class Api_Ab1_Shop_Lessee_Car  {

    /**
     * Получаем список выехавших машин за заданный период
     * @param $dateFrom
     * @param $dateTo
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @param null $elements
     * @param array $params
     * @param boolean $isAllBranch
     * @return MyArray
     */
    public static function getExitShopCar($dateFrom, $dateTo, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver,
                                          $elements = NULL, $params = array(), $isAllBranch = false)
    {
        $params = array_merge(
            Request_RequestParams::setParams(
                array(
                    'exit_at_from' => $dateFrom,
                    'exit_at_to' => $dateTo,
                    'is_exit' => 1,
                    'quantity_from' => 0,
                    'is_charity' => FALSE,
                    'shop_storage_id',
                    'shop_subdivision_id',
                    'shop_heap_id',
                    'shop_formula_product_id',
                )
            ),
            $params
        );
        if($isAllBranch){
            $shopCarIDs = Request_Request::findBranch('DB_Ab1_Shop_Lessee_Car',
                array(), $sitePageData, $driver, $params, 0, TRUE, $elements
            );
        }else {
            $shopCarIDs = Request_Request::find('DB_Ab1_Shop_Lessee_Car',
                $sitePageData->shopID, $sitePageData, $driver, $params, 0, TRUE, $elements
            );
        }

        return $shopCarIDs;
    }

    /**
     * удаление реализации
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

        $model = new Model_Ab1_Shop_Lessee_Car();
        $model->setDBDriver($driver);

        if (!Helpers_DB::dublicateObjectLanguage($model, $id, $sitePageData)) {
            throw new HTTP_Exception_500('Car lessee not found.');
        }

        if (($isUnDel && !$model->getIsDelete()) or (!$isUnDel && $model->getIsDelete())){
            return FALSE;
        }

        if($isUnDel){
            $params = Request_RequestParams::setParams(
                array(
                    'shop_lessee_car_id' => $id,
                    'is_delete' => 1,
                    'is_public' => FALSE,
                )
            );
            $ids = Request_Request::find('DB_Ab1_Shop_Lessee_Car_Item', $sitePageData->shopID, $sitePageData, $driver, $params);
            $driver->unDeleteObjectIDs(
                $ids->getChildArrayID(), $sitePageData->userID, Model_Ab1_Shop_Lessee_Car_Item::TABLE_NAME,
                array('is_public' => 1), $sitePageData->shopID
            );

            $model->dbUnDelete($sitePageData->userID, 0, $sitePageData->shopID);

            Api_Ab1_Shop_Register_Raw::unDelShopLesseeCar($model, $sitePageData, $driver);
            Api_Ab1_Shop_Register_Material::unDelShopLesseeCar($model, $sitePageData, $driver);
        }else {
            $params = Request_RequestParams::setParams(
                array(
                    'shop_lessee_car_id' => $id,
                    'is_delete' => 0,
                    'is_public' => TRUE,
                )
            );
            $ids = Request_Request::find('DB_Ab1_Shop_Lessee_Car_Item', $sitePageData->shopID, $sitePageData, $driver, $params);
            $driver->deleteObjectIDs(
                $ids->getChildArrayID(), $sitePageData->userID, Model_Ab1_Shop_Lessee_Car_Item::TABLE_NAME,
                array('is_public' => 0), $sitePageData->shopID
            );

            $model->dbDelete($sitePageData->userID, 0, $sitePageData->shopID);

            Api_Ab1_Shop_Register_Raw::delShopLesseeCar($model, $sitePageData, $driver);
            Api_Ab1_Shop_Register_Material::delShopLesseeCar($model, $sitePageData, $driver);
        }

        // пересчитать баланс остатка продукции
        Api_Ab1_Shop_Product_Storage::calcProductBalance(
            $model->getShopProductID(), $model->getShopStorageID(), $sitePageData, $driver, true
        );

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
        $model = new Model_Ab1_Shop_Lessee_Car();
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
        Request_RequestParams::setParamInt("shop_transport_company_id", $model);
        Request_RequestParams::setParamStr("ticket", $model);
        Request_RequestParams::setParamInt('shop_product_id', $model);
        Request_RequestParams::setParamInt('shop_driver_id', $model);
        Request_RequestParams::setParamDateTime('exit_at', $model);
        Request_RequestParams::setParamDateTime('arrival_at', $model);
        Request_RequestParams::setParamInt("shop_storage_id", $model);

        $options = Request_RequestParams::getParamArray('options');
        if ($options !== NULL) {
            $model->addOptionsArray($options);
        }

        Request_RequestParams::setParamInt("shop_turn_place_id", $model);
        Request_RequestParams::setParamInt('shop_client_id', $model);

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
        Api_Ab1_Shop_Turn_Place::setTurn($model, $sitePageData, $driver);

        // просчитываем стоимость доставки
        $deliveryAmount = Request_RequestParams::getParamFloat('delivery_amount');
        Request_RequestParams::setParamInt('shop_delivery_id', $model);
        Request_RequestParams::setParamFloat('delivery_km', $model);
        $model->setDeliveryAmount(
            Api_Ab1_Shop_Delivery::getPrice(
                $deliveryAmount, $model->getDeliveryKM(), $model->getDeliveryQuantity(), $model->getShopDeliveryID(),
                false, $sitePageData, $driver
            )
        );

        $result = array();
        if ($model->validationFields($result)) {
            if($model->id < 1) {
                $tare = Request_RequestParams::getParamFloat('tare');
                if($tare > 0.0001){
                    $model->setTarra($tare);
                    $model->setShopTurnID(Model_Ab1_Shop_Turn::TURN_WEIGHTED_EXIT);
                }

                $model->setCashOperationID($sitePageData->operationID);
                Helpers_DB::saveDBObject($model, $sitePageData);
            }

            // загружаем фотографии
            $file = new Model_File($sitePageData);
            $file->saveFiles(Request_RequestParams::getParamArray('files'), $model, $sitePageData, $driver);

            // сохраняем товары реализации
            $shopCarItems = Request_RequestParams::getParamArray('shop_car_items');
            if($shopCarItems !== NULL) {
                $arr = Api_Ab1_Shop_Lessee_Car_Item::save(
                    $model, $shopCarItems, $sitePageData, $driver
                );
                $model->setAmount($arr['amount']);
                $model->setQuantity($arr['quantity']);
                $model->setPrice(round($model->getAmount() / $model->getQuantity(), 2));
            }else{
                Request_RequestParams::setParamFloat('quantity', $model);
                Api_Ab1_Shop_Lessee_Car_Item::saveOne($model, $sitePageData, $driver);
            }

            // Сохраняем расхода материалов по рецептам
            Api_Ab1_Shop_Register_Material::saveShopLesseeCar($model, $sitePageData, $driver);

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
     * @param bool $isPHPOutput
     * @return string
     */
    public static function saveXML($from, $to, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver, $isPHPOutput = FALSE)
    {
        // получаем список машина
        $carIDs = Api_Ab1_Shop_Lessee_Car::getExitShopCar(
            $from, $to, $sitePageData, $driver,
            array(
                'shop_client_id' => array('name', 'bik', 'bin', 'address', 'account', 'bank', 'old_id'),
                'shop_product_id' => array('old_id'),
                'shop_delivery_id' => array('old_id'),
                'shop_client_attorney_id' => array('number', 'from_at', 'client_name', 'old_id'),
                'shop_client_contract_id' => array('from_at', 'number'),
                'shop_client_id.organization_type_id' => array('old_id'),
            )
        );

        $data = '<?xml version="1.0" encoding="UTF-8"?><Data1C>';
        foreach($carIDs->childs as $car){
            if (floatval($car->values['quantity'] < 0.001)){
                continue;
            }

            $data .= '<realization>'
                .'<NumDoc>'.$car->values['number'].'</NumDoc>'
                .'<DateDoc>'.strftime('%d.%m.%Y %H:%M:%S', strtotime($car->values['created_at'])).'</DateDoc>'
                .'<IdKlient>'.$car->getElementValue('shop_client_id', 'old_id').'</IdKlient>'
                .'<Company>'.htmlspecialchars($car->getElementValue('shop_client_id'), ENT_XML1).'</Company>'
                .'<BIN>'.htmlspecialchars($car->getElementValue('shop_client_id', 'bin'), ENT_XML1).'</BIN>'
                .'<BIK>'.htmlspecialchars($car->getElementValue('shop_client_id', 'bik'), ENT_XML1).'</BIK>'
                .'<address>'.htmlspecialchars($car->getElementValue('shop_client_id', 'address'), ENT_XML1).'</address>'
                .'<account>'.htmlspecialchars($car->getElementValue('shop_client_id', 'account'), ENT_XML1).'</account>'
                .'<organization_type>'.htmlspecialchars($car->getElementValue('organization_type_id', 'old_id'), ENT_XML1).'</organization_type>'
                .'<bank>'.htmlspecialchars($car->getElementValue('shop_client_id', 'bank'), ENT_XML1).'</bank>'
                . '<car_number>'.$car->values['name'].'</car_number>';

            if($car->values['shop_payment_id'] < 1) {
                if ($car->values['shop_client_attorney_id'] > 0) {
                    $data .= '<attorney>' . $car->getElementValue('shop_client_attorney_id', 'old_id') . '</attorney>'
                        . '<attorneyNum>' . $car->getElementValue('shop_client_attorney_id', 'number') . '</attorneyNum>'
                        . '<attorneyDate>' . Helpers_DateTime::getDateFormatRus($car->getElementValue('shop_client_attorney_id', 'from_at')) . '</attorneyDate>'
                        . '<attorneyName>' . $car->getElementValue('shop_client_attorney_id', 'client_name') . '</attorneyName>'
                        . '<cash>0</cash>';
                }else{
                    $data .= '<cash>1</cash>';
                }
            }else{
                $data .= '<cash>1</cash>';
            }

            if ($car->values['shop_client_contract_id'] > 0) {
                $data .= '<contractNum>' . $car->getElementValue('shop_client_contract_id', 'number') . '</contractNum>'
                    . '<contractDate>' . Helpers_DateTime::getDateFormatRus($car->getElementValue('shop_client_contract_id', 'from_at')) . '</contractDate>'
                    . '<contractID>' . $car->values['shop_client_contract_id'] . '</contractID>';
            }

            // доставка
            if($car->values['shop_delivery_id'] > 0){
                $data .= '<is_delivery>1</is_delivery>'
                    . '<delivery>'.$car->getElementValue('shop_delivery_id', 'old_id').'</delivery>'
                    . '<delivery_amount>'.$car->values['delivery_amount'].'</delivery_amount>'
                    . '<delivery_km>'.$car->values['delivery_km'].'</delivery_km>'
                    . '<waybill>'.$car->values['id'].'</waybill>'
                    . '<number>'.$car->values['name'].'</number>';

                // считаем для Жанны не правильное значение
                $deliveryPrice = Api_Ab1_Shop_Delivery::getPrice(
                    $car->values['delivery_amount'], $car->values['delivery_km'], $car->values['delivery_quantity'],
                    $car->values['shop_delivery_id'], $car->values['is_charity'], $sitePageData, $driver, TRUE
                );
                $data .= '<delivery_count>'.$deliveryPrice['value'].'</delivery_count>';
            }else{
                $data .= '<is_delivery>0</is_delivery>';
            }

            $data .= '<GoodString>'
                .'<Code>'.$car->getElementValue('shop_product_id', 'old_id').'</Code>'
                .'<quantity>'.$car->values['quantity'].'</quantity>'
                .'<price>'.$car->values['price'].'</price>'
                .'<sum>'.$car->values['amount'].'</sum>'
                .'</GoodString>';

            $data .= '</realization>';
        }

        $pieceIDs = Api_Ab1_Shop_Piece::getExitShopPieces(
            $from, $to, $sitePageData, $driver,
            array(
                'shop_client_id' => array('name', 'bik', 'bin', 'address', 'account', 'bank', 'old_id'),
                'shop_delivery_id' => array('old_id'),
                'shop_client_attorney_id' => array('number', 'from_at', 'client_name', 'old_id'),
                'shop_client_contract_id' => array('from_at', 'number'),
            )
        );

        if (count($pieceIDs->childs) > 0) {
            $params = Request_RequestParams::setParams(
                array(
                    'shop_piece_id' => $pieceIDs->getChildArrayID(),
                    'quantity_from' => 0,
                )
            );
            $pieceItemIDs = Request_Request::find('DB_Ab1_Shop_Piece_Item',
                $sitePageData->shopID, $sitePageData, $driver,
                $params, 0, TRUE,
                array(
                    'shop_product_id' => array('old_id')
                )
            );

            $pieceIDs->runIndex();
        }else{
            $pieceItemIDs = new MyArray();
        }

        foreach($pieceItemIDs->childs as $pieceItem){
            $piece = $pieceIDs->childs[$pieceItem->values['shop_piece_id']];

            if (floatval($pieceItem->values['quantity']) < 0.001){
                continue;
            }

            $data .= '<realization>'
                .'<NumDoc>'.$piece->values['number'].'</NumDoc>'
                .'<DateDoc>'.strftime('%d.%m.%Y %H:%M:%S', strtotime($piece->values['created_at'])).'</DateDoc>'
                .'<IdKlient>'.$piece->getElementValue('shop_client_id', 'old_id').'</IdKlient>'
                .'<Company>'.htmlspecialchars($piece->getElementValue('shop_client_id'), ENT_XML1).'</Company>'
                .'<BIN>'.htmlspecialchars($piece->getElementValue('shop_client_id', 'bin'), ENT_XML1).'</BIN>'
                .'<BIK>'.htmlspecialchars($piece->getElementValue('shop_client_id', 'bik'), ENT_XML1).'</BIK>'
                .'<address>'.htmlspecialchars($piece->getElementValue('shop_client_id', 'address'), ENT_XML1).'</address>'
                .'<account>'.htmlspecialchars($piece->getElementValue('shop_client_id', 'account'), ENT_XML1).'</account>'
                .'<bank>'.htmlspecialchars($piece->getElementValue('shop_client_id', 'bank'), ENT_XML1).'</bank>'
                . '<car_number>'.$piece->values['name'].'</car_number>';

            if($piece->values['shop_payment_id'] < 1) {
                if ($piece->values['shop_client_attorney_id'] > 0) {
                    $data .= '<attorney>' . $piece->getElementValue('shop_client_attorney_id', 'old_id') . '</attorney>'
                        . '<attorneyNum>' . $piece->getElementValue('shop_client_attorney_id', 'number') . '</attorneyNum>'
                        . '<attorneyDate>' . Helpers_DateTime::getDateFormatRus($piece->getElementValue('shop_client_attorney_id', 'from_at')) . '</attorneyDate>'
                        . '<attorneyName>' . $piece->getElementValue('shop_client_attorney_id', 'client_name') . '</attorneyName>'
                        . '<cash>0</cash>';
                }else{
                    $data .= '<cash>1</cash>';
                }
            }else{
                $data .= '<cash>1</cash>';
            }

            if ($piece->values['shop_client_contract_id'] > 0) {
                $data .= '<contractNum>' . $piece->getElementValue('shop_client_contract_id', 'number') . '</contractNum>'
                    . '<contractDate>' . Helpers_DateTime::getDateFormatRus($piece->getElementValue('shop_client_contract_id', 'from_at')) . '</contractDate>'
                    . '<contractID>' . $car->values['shop_client_contract_id'] . '</contractID>';
            }

            // доставка
            if($piece->values['shop_delivery_id'] > 0){
                $data .= '<is_delivery>1</is_delivery>'
                    . '<delivery>'.$piece->getElementValue('shop_delivery_id', 'old_id').'</delivery>'
                    . '<delivery_amount>'.$piece->values['delivery_amount'].'</delivery_amount>'
                    . '<delivery_km>'.$piece->values['delivery_km'].'</delivery_km>'
                    . '<waybill>'.$piece->values['id'].'</waybill>'
                    . '<number>'.$piece->values['name'].'</number>';

                // считаем для Жанны не правильное значение
                $deliveryPrice = Api_Ab1_Shop_Delivery::getPrice(
                    $piece->values['delivery_amount'], $piece->values['delivery_km'], $piece->values['delivery_quantity'],
                    $piece->values['shop_delivery_id'], $piece->values['is_charity'], $sitePageData, $driver, TRUE
                );
                $data .= '<delivery_count>'.$deliveryPrice['value'].'</delivery_count>';

                $piece->values['shop_delivery_id'] = 0;
            }else{
                $data .= '<is_delivery>0</is_delivery>';
            }

            $data .= '<GoodString>'
                .'<Code>'.$pieceItem->getElementValue('shop_product_id', 'old_id').'</Code>'
                .'<quantity>'.$pieceItem->values['quantity'].'</quantity>'
                .'<price>'.$pieceItem->values['price'].'</price>'
                .'<sum>'.$pieceItem->values['amount'].'</sum>'
                .'</GoodString>';

            $data .= '</realization>';
        }

        $data .= '</Data1C>';

        if($isPHPOutput) {
            header('Content-Type: text/xml');
            header('Content-Disposition: attachment;filename="realization.xml"');
            header('Cache-Control: max-age=0');

            echo $data;
            exit();
        }

        return $data;
    }

    /**
     * Сохраняем машины + оплату в виде XML
     * @param $from
     * @param $to
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @return string
     */
    /*public static function saveXMLOld($from, $to, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver, $isPHPOutput = FALSE)
    {
        // получаем список машина
        $carIDs = Api_Ab1_Shop_Lessee_Car::getExitShopCar(
            $from, $to, $sitePageData, $driver,
            array(
                'shop_client_id' => array('name', 'bik', 'address', 'account', 'bank', 'old_id'),
                'shop_product_id' => array('old_id'),
                'shop_delivery_id' => array('delivery_amount', 'bik', 'address', 'account', 'bank', 'old_id'),
                'shop_client_attorney_id' => array('number', 'from_at', 'client_name', 'old_id'),
                'shop_client_contract_id' => array('from_at', 'number'),
            )
        );



        $modelProduct = new Model_Ab1_Shop_Product();
        $modelProduct->setDBDriver($driver);

        $modelDelivery = new Model_Ab1_Shop_Delivery();
        $modelDelivery->setDBDriver($driver);

        $modelClient = new Model_Ab1_Shop_Client();
        $modelClient->setDBDriver($driver);

        $modelAttorney = new Model_Ab1_Shop_Client_Attorney();
        $modelAttorney->setDBDriver($driver);

        Model_Ab1_Shop_Client_Contract::

        $data = '<?xml version="1.0" encoding="UTF-8"?><Data1C>';
        foreach($carIDs->childs as $car){
            if (($car->values['quantity'] * 1 < 0.001)
                || (!Helpers_DB::getDBObject($modelClient, $car->values['shop_client_id'], $sitePageData, $sitePageData->shopMainID))
                || (!Helpers_DB::getDBObject($modelProduct, $car->values['shop_product_id'], $sitePageData))){
                continue;
            }

            $data .= '<realization>'
                .'<NumDoc>'.$car->values['number'].'</NumDoc>'
                .'<DateDoc>'.strftime('%d.%m.%Y %H:%M:%S', strtotime($car->values['created_at'])).'</DateDoc>'
                .'<IdKlient>'.$modelClient->getOldID().'</IdKlient>'
                .'<Company>'.htmlspecialchars($modelClient->getName(), ENT_XML1).'</Company>'
                .'<BIN>'.htmlspecialchars($modelClient->getBIN(), ENT_XML1).'</BIN>'
                .'<BIK>'.htmlspecialchars($modelClient->getBIK(), ENT_XML1).'</BIK>'
                .'<address>'.htmlspecialchars($modelClient->getAddress(), ENT_XML1).'</address>'
                .'<account>'.htmlspecialchars($modelClient->getAccount(), ENT_XML1).'</account>'
                .'<bank>'.htmlspecialchars($modelClient->getBank(), ENT_XML1).'</bank>'
                . '<car_number>'.$car->values['name'].'</car_number>';

            if($car->values['shop_payment_id'] < 1) {
                if (($car->values['shop_client_attorney_id'] > 0) && (Helpers_DB::getDBObject($modelAttorney, $car->values['shop_client_attorney_id'], $sitePageData))) {
                    $data .= '<attorney>' . $modelAttorney->getOldID() . '</attorney>'
                        . '<cash>0</cash>';
                }else{
                    $data .= '<cash>1</cash>';
                }
            }else{
                $data .= '<cash>1</cash>';
            }

            // доставка
            if(($car->values['shop_delivery_id'] > 0) && (Helpers_DB::getDBObject($modelDelivery, $car->values['shop_delivery_id'], $sitePageData))){
                $data .= '<is_delivery>1</is_delivery>'
                    . '<delivery>'.$modelDelivery->getOldID().'</delivery>'
                    . '<delivery_amount>'.$car->values['delivery_amount'].'</delivery_amount>'
                    . '<delivery_km>'.$car->values['delivery_km'].'</delivery_km>'
                    . '<waybill>'.$car->values['id'].'</waybill>'
                    . '<number>'.$car->values['name'].'</number>';

                // считаем для Жанны не правильное значение
                $deliveryPrice = Api_Ab1_Shop_Delivery::getPrice($car->values['delivery_amount'], $car->values['delivery_km'], $car->values['quantity'],
                    $modelDelivery->id, $sitePageData, $driver, TRUE);
                $data .= '<delivery_count>'.$deliveryPrice['value'].'</delivery_count>';
            }else{
                $data .= '<is_delivery>0</is_delivery>';
            }

            $data .= '<GoodString>'
                .'<Code>'.$modelProduct->getOldID().'</Code>'
                .'<quantity>'.$car->values['quantity'].'</quantity>'
                .'<price>'.$car->values['price'].'</price>'
                .'<sum>'.$car->values['amount'].'</sum>'
                .'</GoodString>';

            $data .= '</realization>';
        }

        $pieceIDs = Api_Ab1_Shop_Piece::getExitShopPieces(
            $from, $to, $sitePageData, $driver, array('shop_client_id' => array('name'))
        );

        if (count($pieceIDs->childs) > 0) {
            $pieceItemIDs = Request_Request::find('DB_Ab1_Shop_Piece_Item', $sitePageData->shopID, $sitePageData, $driver,
                array('shop_piece_id' => array('value' => $pieceIDs->getChildArrayID()), 'quantity_from' => 0,
                    Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE),
                0, TRUE, array('shop_product_id' => array('name')));

            $pieceIDs->runIndex();
        }else{
            $pieceItemIDs = new MyArray();
        }

        foreach($pieceItemIDs->childs as $pieceItem){
            $piece = $pieceIDs->childs[$pieceItem->values['shop_piece_id']];

            if (($pieceItem->values['quantity'] * 1 < 0.001)
                || (!Helpers_DB::getDBObject($modelClient, $piece->values['shop_client_id'], $sitePageData))
                || (!Helpers_DB::getDBObject($modelProduct, $pieceItem->values['shop_product_id'], $sitePageData))){
                continue;
            }

            $data .= '<realization>'
                .'<NumDoc>'.$piece->values['number'].'</NumDoc>'
                .'<DateDoc>'.strftime('%d.%m.%Y %H:%M:%S', strtotime($piece->values['created_at'])).'</DateDoc>'
                .'<IdKlient>'.$modelClient->getOldID().'</IdKlient>'
                .'<Company>'.htmlspecialchars($modelClient->getName(), ENT_XML1).'</Company>'
                .'<BIN>'.htmlspecialchars($modelClient->getBIN(), ENT_XML1).'</BIN>'
                .'<BIK>'.htmlspecialchars($modelClient->getBIK(), ENT_XML1).'</BIK>'
                .'<address>'.htmlspecialchars($modelClient->getAddress(), ENT_XML1).'</address>'
                .'<account>'.htmlspecialchars($modelClient->getAccount(), ENT_XML1).'</account>'
                .'<bank>'.htmlspecialchars($modelClient->getBank(), ENT_XML1).'</bank>'
                . '<car_number>'.$piece->values['name'].'</car_number>';

            if($piece->values['shop_payment_id'] < 1) {
                if (($piece->values['shop_client_attorney_id'] > 0) && (Helpers_DB::getDBObject($modelAttorney, $piece->values['shop_client_attorney_id'], $sitePageData))) {
                    $data .= '<attorney>' . $modelAttorney->getOldID() . '</attorney>'
                        . '<cash>0</cash>';
                }else{
                    $data .= '<cash>1</cash>';
                }
            }else{
                $data .= '<cash>1</cash>';
            }

            // доставка
            if(($piece->values['shop_delivery_id'] > 0) && (Helpers_DB::getDBObject($modelDelivery, $piece->values['shop_delivery_id'], $sitePageData))){
                $data .= '<is_delivery>1</is_delivery>'
                    . '<delivery>'.$modelDelivery->getOldID().'</delivery>'
                    . '<delivery_amount>'.$piece->values['delivery_amount'].'</delivery_amount>'
                    . '<delivery_km>'.$piece->values['delivery_km'].'</delivery_km>'
                    . '<waybill>'.$piece->values['id'].'</waybill>'
                    . '<number>'.$piece->values['name'].'</number>';

                // считаем для Жанны не правильное значение
                $deliveryPrice = Api_Ab1_Shop_Delivery::getPrice($piece->values['delivery_amount'], $piece->values['delivery_km'], $pieceItem->values['quantity'],
                    $modelDelivery->id, $sitePageData, $driver, TRUE);
                $data .= '<delivery_count>'.$deliveryPrice['value'].'</delivery_count>';

                $piece->values['shop_delivery_id'] = 0;
            }else{
                $data .= '<is_delivery>0</is_delivery>';
            }

            $data .= '<GoodString>'
                .'<Code>'.$modelProduct->getOldID().'</Code>'
                .'<quantity>'.$pieceItem->values['quantity'].'</quantity>'
                .'<price>'.$pieceItem->values['price'].'</price>'
                .'<sum>'.$pieceItem->values['amount'].'</sum>'
                .'</GoodString>';

            $data .= '</realization>';
        }

        $data .= '</Data1C>';

        if($isPHPOutput) {
            header('Content-Type: text/xml');
            header('Content-Disposition: attachment;filename="realization.xml"');
            header('Cache-Control: max-age=0');

            echo $data;
            exit();
        }


        return $data;
    }*/
}
