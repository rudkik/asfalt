<?php defined('SYSPATH') or die('No direct script access.');

class Api_Ab1_Shop_Payment  {

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

        $model = new Model_Ab1_Shop_Payment();
        $model->setDBDriver($driver);

        if (!Helpers_DB::dublicateObjectLanguage($model, $id, $sitePageData)) {
            throw new HTTP_Exception_500('Payment not found.');
        }

        if(Request_RequestParams::getParamBoolean("is_undel") === TRUE){
            $model->dbUnDelete($sitePageData->userID, 0, $sitePageData->shopID);
        }else {
            $model->dbDelete($sitePageData->userID, 0, $sitePageData->shopID);
        }

        // баланс прихода денег
        Api_Ab1_Shop_Client::calcBalanceCash($model->getShopClientID(), $sitePageData, $driver);

        return TRUE;
    }

    /**
     * Печать фискального чека
     * @param float $paidAmount
     * @param int $shopPaymentID
     * @param int $paymentTypeID
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @return string
     */
    public static function printFiscalCheck(float $paidAmount, int $shopPaymentID, int $paymentTypeID,
                                            SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver) {

        $fiscalCheck = new Drivers_CashRegister_Aura3_FiscalCheck();

        // список продукции реализации
        Api_Ab1_Shop_Payment_Item::getGoodListFiscalCheck(
            $shopPaymentID, $fiscalCheck->getGoodsList(), $sitePageData, $driver
        );

        switch ($paymentTypeID){
            case Model_Ab1_PaymentType::PAYMENT_TYPE_BANK_CARD:
                $paymentType = Drivers_CashRegister_Aura3::PAYMENT_CARD;
                break;
            default:
                $paymentType = Drivers_CashRegister_Aura3::PAYMENT_CASH;
        }

        // печать чека
        return Drivers_CashRegister_RemoteComputerAura3::printFiscalCheck(
            'payment_'.$shopPaymentID, floatval($paidAmount), $fiscalCheck, $sitePageData, $paymentType
        );
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
        $model = new Model_Ab1_Shop_Payment();
        $model->setDBDriver($driver);

        $id = Request_RequestParams::getParamInt('id');
        if($id > 0) {
            if (!Helpers_DB::dublicateObjectLanguage($model, $id, $sitePageData)) {
                throw new HTTP_Exception_500('Payment not found.');
            }
        }

        Request_RequestParams::setParamBoolean('is_public', $model);
        Request_RequestParams::setParamStr('text', $model);
        Request_RequestParams::setParamStr('name', $model);
        Request_RequestParams::setParamStr("old_id", $model);
        Request_RequestParams::setParamInt("shop_cashbox_terminal_id", $model);

        $shopCarID = Request_RequestParams::getParamInt('shop_car_id');
        if ($shopCarID !== NULL) {
            $model->setShopCarID($shopCarID);
        }

        $shopClientID = $model->getShopClientID();
        Request_RequestParams::setParamInt('shop_client_id', $model);
        Request_RequestParams::setParamInt('shop_client_contract_id', $model);
        Request_RequestParams::setParamStr('number', $model);
        Request_RequestParams::setParamInt('payment_type_id', $model);

        // если чек был распечатан, но по каким-то причинам не зафиксирован в системе
        $isFiscalCheck = Request_RequestParams::getParamBoolean('is_fiscal_check');
        if($isFiscalCheck === true){
            Request_RequestParams::setParamStr('fiscal_check', $model);
            $model->setIsFiscalCheck(true);
        }

        $options = Request_RequestParams::getParamArray('options');
        if ($options !== NULL) {
            $model->addOptionsArray($options);
        }

        $result = array();
        $fiscalResult = null;
        if ($model->validationFields($result)) {
            // счетчик как в 1с
            DB_Basic::setNumber1CIfEmpty($model, 'number', $sitePageData, $driver, $sitePageData->shopID);

            // Получаем / создаем день фиксации цены продукции на баланс
            if ($model->id < 1 || $model->getShopClientID() != $model->getOriginalValue('shop_client_id')) {
                $model->setShopClientBalanceDayID(
                    Api_Ab1_Shop_Client_Balance_Day::setClientBalanceDay(
                        $model->getShopClientID(), $model->getCreatedAt(), $sitePageData, $driver
                    )
                );
            }

            if ($model->id < 1) {
                Helpers_DB::saveDBObject($model, $sitePageData);
            }

            // сохраняем товары счета
            $shopPaymentItems = Request_RequestParams::getParamArray('shop_payment_items');
            if($shopPaymentItems !== NULL) {
                $model->setAmount(
                    Api_Ab1_Shop_Payment_Item::save(
                        $model->id, $shopPaymentItems, $model->getShopClientID(), $model->getShopClientContractID(),
                        $sitePageData, $driver
                    )
                );
            }
            // загружаем фотографии
            $file = new Model_File($sitePageData);
            $file->saveFiles(Request_RequestParams::getParamArray('files'), $model, $sitePageData, $driver);

            Helpers_DB::saveDBObject($model, $sitePageData);
            $result['values'] = $model->getValues();

            if (!Helpers_DB::getDBObject($model, $model->id, $sitePageData)) {
                throw new HTTP_Exception_500('Payment not found.');
            }

            // печать фискального чека
            if(!$model->getIsFiscalCheck()){
                $paidAmount = Request_RequestParams::getParamFloat('paid_amount');
                if($paidAmount < $model->getAmount()){
                    $paidAmount = $model->getAmount();
                }

                $fiscalResult = self::printFiscalCheck($paidAmount, $model->id, $model->getPaymentTypeID(), $sitePageData, $driver);
                if(array($fiscalResult)){
                    $model->setFiscalCheck(Arr::path($fiscalResult, 'number', ''));

                    if (!$model->getIsFiscalCheck()) {
                        $fiscalResult['status'] = false;
                    }
                }
            }

            Helpers_DB::saveDBObject($model, $sitePageData);
            $result['values'] = $model->getValues();

            // связь с машиной
            if ($shopCarID > 0) {
                $modelCar = new Model_Ab1_Shop_Car();
                $modelCar->setDBDriver($driver);

                if (Helpers_DB::dublicateObjectLanguage($modelCar, $shopCarID, $sitePageData)) {
                    $modelCar->setShopPaymentID($model->id);
                    Helpers_DB::saveDBObject($modelCar, $sitePageData);
                }
            }

            if(! $model->getIsDelete()) {
                // баланс прихода денег
                Api_Ab1_Shop_Client::calcBalanceCash($shopClientID, $sitePageData, $driver);
                if ($shopClientID != $model->getShopClientID()) {
                    Api_Ab1_Shop_Client::calcBalanceCash($model->getShopClientID(), $sitePageData, $driver);
                }
            }
        }

        return array(
            'id' => $model->id,
            'result' => $result,
            'fiscal_result' => $fiscalResult,
        );
    }

    /**
     * Сохранение
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @return array
     * @throws HTTP_Exception_500
     */
    public static function addCar(SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        $shopCarID = Request_RequestParams::getParamInt('shop_car_id');
        if ($shopCarID < 1){
            throw new HTTP_Exception_500('Car ID not is found!');
        }

        $car = Request_Request::findOneByField(
            'DB_Ab1_Shop_Car', 'id', $shopCarID, $sitePageData->shopID, $sitePageData, $driver,
            [
                'shop_delivery_id' => ['shop_product_id'],
            ]
        );
        if ($car == null){
            throw new HTTP_Exception_500('Car id="' . $shopCarID . '" not is found!');
        }

        $model = new Model_Ab1_Shop_Payment();
        $model->setDBDriver($driver);

        $model->setShopCarID($shopCarID);

        Request_RequestParams::setParamBoolean('is_public', $model);
        Request_RequestParams::setParamStr('text', $model);
        Request_RequestParams::setParamStr('name', $model);
        Request_RequestParams::setParamStr("old_id", $model);

        $shopClientID = $model->getShopClientID();
        Request_RequestParams::setParamInt('shop_client_id', $model);
        Request_RequestParams::setParamInt('shop_client_contract_id', $model);
        Request_RequestParams::setParamStr('number', $model);
        Request_RequestParams::setParamInt('payment_type_id', $model);

        // если чек был распечатан, но по каким-то причинам не зафиксирован в системе
        $isFiscalCheck = Request_RequestParams::getParamBoolean('is_fiscal_check');
        if($isFiscalCheck === true){
            Request_RequestParams::setParamStr('fiscal_check', $model);
            $model->setIsFiscalCheck(true);
        }

        $options = Request_RequestParams::getParamArray('options');
        if ($options !== NULL) {
            $model->addOptionsArray($options);
        }

        $result = array();
        $fiscalResult = null;
        if ($model->validationFields($result)) {
            // счетчик как в 1с
            DB_Basic::setNumber1CIfEmpty($model, 'number', $sitePageData, $driver, $sitePageData->shopID);

            // Получаем / создаем день фиксации цены продукции на баланс
            if ($model->id < 1 || $model->getShopClientID() != $model->getOriginalValue('shop_client_id')) {
                $model->setShopClientBalanceDayID(
                    Api_Ab1_Shop_Client_Balance_Day::setClientBalanceDay(
                        $model->getShopClientID(), $model->getCreatedAt(), $sitePageData, $driver
                    )
                );
            }

            if ($model->id < 1) {
                Helpers_DB::saveDBObject($model, $sitePageData);
            }

            // сохраняем товары счета
            $shopPaymentItems = Request_RequestParams::getParamArray('shop_payment_items');
            if($shopPaymentItems !== NULL) {
                $model->setAmount(
                    Api_Ab1_Shop_Payment_Item::save(
                        $model->id, $shopPaymentItems, $model->getShopClientID(), $model->getShopClientContractID(),
                        $sitePageData, $driver,
                        intval($car->getElementValue('shop_delivery_id', 'shop_product_id', 0)),
                        $car->values['delivery_amount']
                    )
                );
            }
            // загружаем фотографии
            $file = new Model_File($sitePageData);
            $file->saveFiles(Request_RequestParams::getParamArray('files'), $model, $sitePageData, $driver);

            Helpers_DB::saveDBObject($model, $sitePageData);
            $result['values'] = $model->getValues();

            if (!Helpers_DB::getDBObject($model, $model->id, $sitePageData)) {
                throw new HTTP_Exception_500('Payment not found.');
            }

            // печать фискального чека
            if(!$model->getIsFiscalCheck()){
                $paidAmount = Request_RequestParams::getParamFloat('paid_amount');
                if($paidAmount < $model->getAmount()){
                    $paidAmount = $model->getAmount();
                }

                $fiscalResult = self::printFiscalCheck($paidAmount, $model->id, $model->getPaymentTypeID(), $sitePageData, $driver);
                if(array($fiscalResult)){
                    $model->setFiscalCheck(Arr::path($fiscalResult, 'number', ''));

                    if (!$model->getIsFiscalCheck()) {
                        $fiscalResult['status'] = false;
                    }
                }
            }

            Helpers_DB::saveDBObject($model, $sitePageData);
            $result['values'] = $model->getValues();

            // связь с машиной
            if ($shopCarID > 0) {
                $modelCar = new Model_Ab1_Shop_Car();
                $modelCar->setDBDriver($driver);

                if (Helpers_DB::dublicateObjectLanguage($modelCar, $shopCarID, $sitePageData)) {
                    $modelCar->setShopPaymentID($model->id);
                    Helpers_DB::saveDBObject($modelCar, $sitePageData);
                }
            }

            if(! $model->getIsDelete()) {
                // баланс прихода денег
                Api_Ab1_Shop_Client::calcBalanceCash($shopClientID, $sitePageData, $driver);
                if ($shopClientID != $model->getShopClientID()) {
                    Api_Ab1_Shop_Client::calcBalanceCash($model->getShopClientID(), $sitePageData, $driver);
                }
            }
        }

        return array(
            'id' => $model->id,
            'result' => $result,
            'fiscal_result' => $fiscalResult,
        );
    }

    /**
     * Сохранение
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @return array
     * @throws HTTP_Exception_500
     */
    public static function addPiece(SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        $shopPieceID = Request_RequestParams::getParamInt('shop_piece_id');
        if ($shopPieceID < 1){
            throw new HTTP_Exception_500('Piece ID not is found!');
        }

        $piece = Request_Request::findOneByField(
            'DB_Ab1_Shop_Piece', 'id', $shopPieceID, $sitePageData->shopID, $sitePageData, $driver,
            [
                'shop_delivery_id' => ['shop_product_id'],
            ]
        );
        if ($piece == null){
            throw new HTTP_Exception_500('Piece id="' . $shopPieceID . '" not is found!');
        }

        $model = new Model_Ab1_Shop_Payment();
        $model->setDBDriver($driver);

        Request_RequestParams::setParamInt("shop_table_rubric_id", $model);
        Request_RequestParams::setParamBoolean('is_public', $model);
        Request_RequestParams::setParamStr('text', $model);
        Request_RequestParams::setParamStr('name', $model);
        Request_RequestParams::setParamBoolean("is_public", $model);
        Request_RequestParams::setParamStr("last_name", $model);
        Request_RequestParams::setParamStr("email", $model);
        Request_RequestParams::setParamStr("old_id", $model);
        Request_RequestParams::setParamInt("shop_table_select_id", $model);
        Request_RequestParams::setParamInt("shop_table_unit_id", $model);
        Request_RequestParams::setParamInt("shop_table_brand_id", $model);

        $shopClientID = $model->getShopClientID();
        Request_RequestParams::setParamInt('shop_client_id', $model);
        Request_RequestParams::setParamStr('number', $model);
        Request_RequestParams::setParamInt('payment_type_id', $model);

        $options = Request_RequestParams::getParamArray('options');
        if ($options !== NULL) {
            $model->addOptionsArray($options);
        }

        $result = array();
        $fiscalResult = null;
        if ($model->validationFields($result)) {
            // счетчик как в 1с
            DB_Basic::setNumber1CIfEmpty($model, 'number', $sitePageData, $driver, $sitePageData->shopID);

            if ($model->id < 1) {
                Helpers_DB::saveDBObject($model, $sitePageData);
            }

            $model->setShopPieceID($shopPieceID);

            $pieceItemIDs = Request_Request::find(
                'DB_Ab1_Shop_Piece_Item', $sitePageData->shopID, $sitePageData, $driver,
                Request_RequestParams::setParams(['shop_piece_id' => $shopPieceID]),
                0, TRUE
            );

            $shopPaymentItems = array();
            foreach ($pieceItemIDs->childs as $pieceItemID){
                $shopPaymentItems[] = array(
                    'shop_product_id' => $pieceItemID->values['shop_product_id'],
                    'quantity' => $pieceItemID->values['quantity'],
                    'amount' => $pieceItemID->values['amount'],
                );
            }
            $model->setAmount(
                Api_Ab1_Shop_Payment_Item::save(
                    $model->id, $shopPaymentItems, $model->getShopClientID(), 0, $sitePageData, $driver,
                    intval($piece->getElementValue('shop_delivery_id', 'shop_product_id', 0)),
                    $piece->values['delivery_amount']
                )
            );

            $modelPiece = new Model_Ab1_Shop_Piece();
            $modelPiece->setDBDriver($driver);

            if (Helpers_DB::dublicateObjectLanguage($modelPiece, $shopPieceID, $sitePageData)) {
                $modelPiece->setShopPaymentID($model->id);
                Helpers_DB::saveDBObject($modelPiece, $sitePageData);
            }

            // загружаем фотографии
            $file = new Model_File($sitePageData);
            $file->saveFiles(Request_RequestParams::getParamArray('files'), $model, $sitePageData, $driver);

            // печать фискального чека
            if(!$model->getIsFiscalCheck()){
                $paidAmount = Request_RequestParams::getParamFloat('paid_amount');
                if($paidAmount < $model->getAmount()){
                    $paidAmount = $model->getAmount();
                }

                $fiscalResult = self::printFiscalCheck($paidAmount, $model->id, $model->getPaymentTypeID(), $sitePageData, $driver);
                if(array($fiscalResult)){
                    $model->setFiscalCheck(Arr::path($fiscalResult, 'number', ''));

                    if (!$model->getIsFiscalCheck()) {
                        $fiscalResult['status'] = false;
                    }
                }
            }

            Helpers_DB::saveDBObject($model, $sitePageData);
            $result['values'] = $model->getValues();

            if(! $model->getIsDelete()) {
                // баланс прихода денег
                Api_Ab1_Shop_Client::calcBalanceCash($shopClientID, $sitePageData, $driver);
                if ($shopClientID != $model->getShopClientID()) {
                    Api_Ab1_Shop_Client::calcBalanceCash($model->getShopClientID(), $sitePageData, $driver);
                }
            }
        }

        return array(
            'id' => $model->id,
            'result' => $result,
            'fiscal_result' => $fiscalResult,
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
        // получаем список оплат
        $params = Request_RequestParams::setParams(
            array(
                'created_at_from' => $from,
                'created_at_to' => $to
            )
        );
        $shopPaymentIDs = Request_Request::findBranch('DB_Ab1_Shop_Payment',
            array(), $sitePageData, $driver, $params, 0, TRUE,
            array(
                'shop_client_id' => array('name', 'old_id', 'bin', 'address', 'account', 'bik'),
                'shop_cashbox_id' => array('name', 'old_id'),
                'payment_type_id' => array('name', 'old_id'),
                'shop_id' => array('name', 'old_id'),
                'shop_client_id.organization_type_id' => array('old_id'),
            )
        );

        $data = '<?xml version="1.0" encoding="UTF-8"?><Data1C>';
        foreach($shopPaymentIDs->childs as $shopPaymentID){
            $data .= '<Invoice>'
                .'<NumDoc>'.$shopPaymentID->values['number'].'</NumDoc>'
                .'<date>'.strftime('%d.%m.%Y %H:%M:%S', strtotime($shopPaymentID->values['created_at'])).'</date>'
                .'<branch>'.$shopPaymentID->getElementValue('shop_id', 'old_id').'</branch>'
                .'<branch_name>'.$shopPaymentID->getElementValue('shop_id', 'name').'</branch_name>'
                .'<IdKlient>'.$shopPaymentID->getElementValue('shop_client_id', 'old_id').'</IdKlient>'
                .'<Company>'.htmlspecialchars($shopPaymentID->getElementValue('shop_client_id', 'name'), ENT_XML1).'</Company>'
                .'<BIN>'.htmlspecialchars($shopPaymentID->getElementValue('shop_client_id', 'bin'), ENT_XML1).'</BIN>'
                .'<address>'.htmlspecialchars($shopPaymentID->getElementValue('shop_client_id', 'address'), ENT_XML1).'</address>'
                .'<account>'.htmlspecialchars($shopPaymentID->getElementValue('shop_client_id', 'account'), ENT_XML1).'</account>'
                .'<bank>'.htmlspecialchars($shopPaymentID->getElementValue('shop_client_id', 'bik'), ENT_XML1).'</bank>'
                .'<organization_type>'.htmlspecialchars($shopPaymentID->getElementValue('organization_type_id', 'old_id'), ENT_XML1).'</organization_type>'
                .'<cashbox>'.htmlspecialchars($shopPaymentID->getElementValue('shop_cashbox_id', 'old_id'), ENT_XML1).'</cashbox>'
                .'<cashbox_name>'.htmlspecialchars($shopPaymentID->getElementValue('shop_cashbox_id'), ENT_XML1).'</cashbox_name>'
                .'<TypePay>'.htmlspecialchars($shopPaymentID->getElementValue('payment_type_id', 'old_id'), ENT_XML1).'</TypePay>'
                .'<TypePayName>'.htmlspecialchars($shopPaymentID->getElementValue('payment_type_id'), ENT_XML1).'</TypePayName>'
                .'<amount>'.$shopPaymentID->values['amount'].'</amount>'
                .'<amount_pko>'. round($shopPaymentID->values['amount'], 0) . '</amount_pko>'
                .'<sumNDS>'.round($shopPaymentID->values['amount'] / 112 * 12, 2).'</sumNDS>';

            $params = Request_RequestParams::setParams(
                array(
                    'shop_payment_id' => $shopPaymentID->id
                )
            );
            $shopPaymentItemIDs = Request_Request::find('DB_Ab1_Shop_Payment_Item',
                $shopPaymentID->values['shop_id'], $sitePageData, $driver, $params, 0, TRUE,
                array(
                    'shop_product_id' => array('product_type_id', 'old_id'),
                )
            );

            $data .= '<Goods>';
            foreach($shopPaymentItemIDs->childs as $shopPaymentItemID){

                $data .= '<GoodString>'
                    .'<Code>'.htmlspecialchars($shopPaymentItemID->getElementValue('shop_product_id', 'old_id'), ENT_XML1).'</Code>'
                    .'<Type>'.htmlspecialchars($shopPaymentItemID->getElementValue('shop_product_id', 'product_type_id'), ENT_XML1).'</Type>'
                    .'<quantity>'.$shopPaymentItemID->values['quantity'].'</quantity>'
                    .'<price>'.$shopPaymentItemID->values['price'].'</price>'
                    .'<sum>'.$shopPaymentItemID->values['amount'].'</sum>'
                    .'<sumBN>'.($shopPaymentItemID->values['amount'] - round($shopPaymentItemID->values['amount'] / 112 * 12, 2)) .'</sumBN>'
                    .'<sumNDS>'.round($shopPaymentItemID->values['amount'] / 112 * 12, 2).'</sumNDS>'
                    .'</GoodString>';
            }
            $data .= '</Goods>';

            $data .= '</Invoice>';
        }
        $data .= '</Data1C>';

        if($isPHPOutput) {
            header('Content-Type: text/xml');
            header('Content-Disposition: attachment;filename="invoice.xml"');
            header('Cache-Control: max-age=0');

            echo $data;
            exit();
        }


        return $data;
    }
}
