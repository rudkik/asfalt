<?php defined('SYSPATH') or die('No direct script access.');

class Api_Hotel_Shop_Payment  {
    /**
     * Добавление платежа к заказу
     * @param float $amount
     * @param int $shopBillID
     * @param bool $isPaid
     * @param int $shopPaidTypeID
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @return array
     * @throws HTTP_Exception_404
     * @throws HTTP_Exception_500
     */
    public static function addByBill($amount, $shopBillID, $isPaid, $shopPaidTypeID, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        if (!($amount > 0)){
            throw new HTTP_Exception_500('Amount more 0.');
        }

        $modelBill = new Model_Hotel_Shop_Bill();
        $modelBill->setDBDriver($driver);
        if (! Helpers_DB::getDBObject($modelBill, $shopBillID, $sitePageData)) {
            throw new HTTP_Exception_404('Bill not is found!');
        }

        if($modelBill->getAmount() - $modelBill->getPaidAmount() < $amount){
            throw new HTTP_Exception_500('Amount more paid amount.');
        }

        $model = new Model_Hotel_Shop_Payment();
        $model->setDBDriver($driver);

        $model->setPercent(100);
        $model->setAmount($amount);
        $model->setShopBillID($shopBillID);
        $model->setShopClientID($modelBill->getShopClientID());

        if ($isPaid){
            $model->setIsPaid(TRUE);
            $model->setPaidAt(date('Y-m-d H:i:s'));
        }
        $model->setShopPaidTypeID($shopPaidTypeID);

        $n = Database::instance()->query(Database::SELECT, 'SELECT nextval(\'shop_payment\') as id;')->as_array(NULL, 'id')[0];
        $n = '0000000000'.$n;
        $n = 'К'.substr($n, strlen($n) - 10);
        $model->setNumber($n);
        Helpers_DB::saveDBObject($model, $sitePageData);


        if ($isPaid) {
            // пересчет баланса клиента
            Api_Hotel_Shop_Client::recountClientBalance($modelBill->getShopClientID(), $sitePageData, $driver, TRUE);
            // пересчет оплаты заказа
            $modelBill->setPaidAmount(Api_Hotel_Shop_Bill::recountBillPaidAmount($modelBill->id, $sitePageData, $driver));
        }
        Helpers_DB::saveDBObject($modelBill, $sitePageData);

        return $model->getValues(TRUE, TRUE, $sitePageData->shopMainID);
    }

    /**
     * Сохранение товары
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @throws HTTP_Exception_500
     */
    public static function save(SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        $model = new Model_Hotel_Shop_Payment();
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
        Request_RequestParams::setParamBoolean("is_public", $model);
        Request_RequestParams::setParamStr("old_id", $model);
        Request_RequestParams::setParamInt('shop_paid_type_id', $model);
        Request_RequestParams::setParamStr('number', $model);

        $oldShopClientID = $model->getShopClientID();
        Request_RequestParams::setParamInt('shop_client_id', $model);

        $oldShopBillID = $model->getShopBillID();
        Request_RequestParams::setParamInt('shop_bill_id', $model);

        Request_RequestParams::setParamFloat('amount', $model);

        $isPaid = Request_RequestParams::getParamBoolean('is_paid');
        if ($isPaid !== NULL){
            $model->setIsPaid($isPaid);
        }
        if ($model->getIsPaid()) {
            Request_RequestParams::setParamDateTime('paid_at', $model);
        }

        // при создании нового контрагента
        if(Request_RequestParams::getParamBoolean('is_add_client')){
            $shopClient = Request_RequestParams::getParamArray('shop_client');
            if ($shopClient !== NULL){
                $shopClient = Api_Hotel_Shop_Client::saveOfArray($shopClient, $sitePageData, $driver);
                $model->setShopClientID($shopClient['id']);
            }
        }

        $options = Request_RequestParams::getParamArray('options');
        if ($options !== NULL) {
            $model->addOptionsArray($options);
        }

        $result = array();
        if ($model->validationFields($result)) {
            if($model->id < 1) {
                Helpers_DB::saveDBObject($model, $sitePageData);
            }

            // номера ставим только если оплата наличными или пост терминал
            if(Func::_empty($model->getNumber()) && (($model->getShopPaidTypeID() == 903) || ($model->getShopPaidTypeID() == 899))){
                $n = Database::instance()->query(Database::SELECT, 'SELECT nextval(\'shop_payment\') as id;')->as_array(NULL, 'id')[0];
                $n = '0000000000'.$n;
                $n = 'К'.substr($n, strlen($n) - 10);
                $model->setNumber($n);
            }

            // загружаем фотографии
            $file = new Model_File($sitePageData);
            $file->saveFiles(Request_RequestParams::getParamArray('files'), $model, $sitePageData, $driver);

            Helpers_DB::saveDBObject($model, $sitePageData);
            $result['values'] = $model->getValues();

            if (!$model->getIsDelete()) {
                // пересчет баланса клиента
                Api_Hotel_Shop_Client::recountClientBalance($model->getShopClientID(), $sitePageData, $driver, TRUE);
                if($oldShopClientID != $model->getShopClientID()) {
                    Api_Hotel_Shop_Client::recountClientBalance($oldShopClientID, $sitePageData, $driver, TRUE);
                }

                // пересчет оплаты заказа
                Api_Hotel_Shop_Bill::recountBillPaidAmount($model->getShopBillID(), $sitePageData, $driver, TRUE);
                if($oldShopBillID != $model->getShopBillID()) {
                    Api_Hotel_Shop_Bill::recountBillPaidAmount($oldShopBillID, $sitePageData, $driver, TRUE);
                }
            }
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
        // получаем список оплат
        $params = Request_RequestParams::setParams(
            array(
                'is_paid' => TRUE,
                'shop_paid_type_id' => array(899, 900, 903, 906),
                'paid_at_from_equally' => $from,
                'paid_at_to' => $to,
            )
        );
        $shopPaymentIDs = Request_Request::find('DB_Hotel_Shop_Payment', $sitePageData->shopID, $sitePageData, $driver,
            $params, 0, TRUE);

        $modelRoom = new Model_Hotel_Shop_Room();
        $modelRoom->setDBDriver($driver);

        $modelService = new Model_Hotel_Shop_Service();
        $modelService->setDBDriver($driver);

        $modelClient = new Model_Hotel_Shop_Client();
        $modelClient->setDBDriver($driver);

        $data = '<?xml version="1.0" encoding="UTF-8"?><Data1C>';
        foreach($shopPaymentIDs->childs as $shopPaymentID){
            if (!Helpers_DB::getDBObject($modelClient, $shopPaymentID->values['shop_client_id'], $sitePageData)){
                continue;
            }

            $shopBillItemIDs = Request_Request::find('DB_Hotel_Shop_Bill_Item', $sitePageData->shopID, $sitePageData, $driver,
                array(
                    'shop_bill_id' => $shopPaymentID->values['shop_bill_id'], Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE,
                ),
                0, TRUE);

            $shopBillServiceIDs = Request_Request::find('DB_Hotel_Shop_Service',
                $sitePageData->shopID, $sitePageData, $driver,
                array('shop_bill_id' => $shopPaymentID->values['shop_bill_id'], Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE),
                0, TRUE
            );
            if((count($shopBillItemIDs->childs) == 0) && (count($shopBillServiceIDs->childs) == 0)){
                continue;
            }

            $data .= '<payment>'
                .'<NumDoc>'.$shopPaymentID->values['number'].'</NumDoc>'
                .'<bill_id>'.$shopPaymentID->values['shop_bill_id'].'</bill_id>'
                .'<date>'.strftime('%d.%m.%Y %H:%M:%S', strtotime($shopPaymentID->values['paid_at'])).'</date>';

            $data .= '<client>'
                .'<id>'.$modelClient->id.'</id>'
                .'<id_1c>'.$modelClient->getOldID().'</id_1c>'
                .'<name>'.htmlspecialchars($modelClient->getName(), ENT_XML1).'</name>'
                .'<bik>'.htmlspecialchars($modelClient->getBIK(), ENT_XML1).'</bik>'
                .'<bin>'.htmlspecialchars($modelClient->getBIN(), ENT_XML1).'</bin>'
                .'<bank>'.htmlspecialchars($modelClient->getBank(), ENT_XML1).'</bank>'
                .'<account>'.htmlspecialchars($modelClient->getAccount(), ENT_XML1).'</account>'
                .'<address>'.htmlspecialchars($modelClient->getAccount(), ENT_XML1).'</address>'
                .'</client>';

            $data .='<amount>'.$shopPaymentID->values['amount'].'</amount>'
                .'<amount_pko>'. round($shopPaymentID->values['amount'], 0) . '</amount_pko>'
                .'<sumNDS>'.round($shopPaymentID->values['amount'] / 112 * 12, 2).'</sumNDS>';

            // комнаты
            if(count($shopBillItemIDs->childs) > 0) {
                $names = 'Оплата за номера: ';
                foreach ($shopBillItemIDs->childs as $shopBillItemID) {
                    if (!Helpers_DB::getDBObject($modelRoom, $shopBillItemID->values['shop_room_id'], $sitePageData)) {
                        continue;
                    }

                    $names .= $modelRoom->getName()
                        . ' c ' . Helpers_DateTime::getDateFormatRus($shopBillItemID->values['date_from'])
                        . ' по ' . strftime('%d.%m.%Y', strtotime($shopBillItemID->values['date_to'])+24*60*60) . ', ';
                }
            }

            // услуги
            if(count($shopBillServiceIDs->childs) > 0) {
                $names = 'Оплата за услуги: ';
                foreach ($shopBillServiceIDs->childs as $shopBillServiceID) {
                    if (!Helpers_DB::getDBObject($modelService, $shopBillServiceID->values['shop_service_id'], $sitePageData)) {
                        continue;
                    }

                    $names .= $modelService->getName() . ', ';
                }
            }
            $names = mb_substr($names, 0, -2);
            $data .= '<is_post_terminal>'.($shopPaymentID->values['shop_paid_type_id'] == 903).'</is_post_terminal>'
                .'<is_card>'.($shopPaymentID->values['shop_paid_type_id'] == 900).'</is_card>'
                .'<is_cash>'.(($shopPaymentID->values['shop_paid_type_id'] == 899) || ($shopPaymentID->values['shop_paid_type_id'] == 903)).'</is_cash>';

            $data .= '<paid_type>'.$shopPaymentID->values['shop_paid_type_id'].'</paid_type>';

            $data .= '<comment>'.$names.'</comment>';
            $data .= '</payment>';
        }
        $data .= '</Data1C>';

        if($isPHPOutput) {
            header('Content-Type: text/xml');
            header('Content-Disposition: attachment;filename="payment.xml"');
            header('Cache-Control: max-age=0');

            echo $data;
            exit();
        }

        return $data;
    }

    /**
     * Загрузить оплат из XML
     * @param $fileName
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     */
    public static function loadXML($fileName, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        $xml = simplexml_load_file($fileName);

        $model = new Model_Hotel_Shop_Payment();
        $model->setDBDriver($driver);

        $modelBill = new Model_Hotel_Shop_Bill();
        $modelBill->setDBDriver($driver);

        foreach($xml->payment as $payment) {
            $shopBillID = trim($payment->bill_id);
            $number = trim($payment->payment_number);

            $params = Request_RequestParams::setParams(
                array(
                    'shop_bill_id' => $shopBillID,
                    'number' => $number,
                )
            );
            $paymentIDs = Request_Request::find('DB_Hotel_Shop_Payment', $sitePageData->shopID, $sitePageData, $driver,
                $params, 1, TRUE);
            if (count($paymentIDs->childs) > 0){
                continue;
            }

            if (! Helpers_DB::getDBObject($modelBill, $shopBillID, $sitePageData)){
                continue;
            }

            $model->clear();
            $model->setShopBillID($shopBillID);
            $model->setNumber($number);
            $model->setPaidAt(trim($payment->payment_date));
            $model->setAmount(trim($payment->amount));

            if (trim($payment->terminal) == 1){
                $model->setShopPaidTypeID(901);
            }else{
                $model->setShopPaidTypeID(902);
            }
            $model->setShopClientID($modelBill->getShopClientID());

            Helpers_DB::saveDBObject($model, $sitePageData);

            $modelBill->setPaidAmount($modelBill->getPaidAmount() + $model->getAmount());
            Helpers_DB::saveDBObject($modelBill, $sitePageData);
        }
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

        $model = new Model_Hotel_Shop_Payment();
        $model->setDBDriver($driver);

        if (!Helpers_DB::dublicateObjectLanguage($model, $id, $sitePageData)) {
            throw new HTTP_Exception_500('Payment not found.');
        }

        if(Request_RequestParams::getParamBoolean("is_undel") === TRUE){
            $model->dbUnDelete($sitePageData->userID, 0, $sitePageData->shopID);
        }else {
            $model->dbDelete($sitePageData->userID, 0, $sitePageData->shopID);
        }

        // пересчет баланса клиента
        Api_Hotel_Shop_Client::recountClientBalance($model->getShopClientID(), $sitePageData, $driver, TRUE);
        // пересчет оплаты заказа
        Api_Hotel_Shop_Bill::recountBillPaidAmount($model->getShopBillID(), $sitePageData, $driver, TRUE);

        return TRUE;
    }
}