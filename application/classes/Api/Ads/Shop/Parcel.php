<?php defined('SYSPATH') or die('No direct script access.');

class Api_Ads_Shop_Parcel  {
    const WRITE_LOGS = TRUE;
    private static function _writeLogs($select){
        if (!self::WRITE_LOGS){
            return FALSE;
        }

        if(is_array($select)){
            $select = Json::json_encode($select);
        }

        $select = Date::formatted_time('now').': '.$select;

        try {
            file_put_contents(APPPATH.'logs'.DIRECTORY_SEPARATOR.'shipito-kg.txt', $select."\r\n" , FILE_APPEND);
        } catch (Exception $e) {
        }

        return TRUE;
    }

    const APIKEY = 'mIUEoBSX25DfRvdw5qIHfvs5xYKpZ0knNE3uGUBx';

    /**
     * Оправляем информацию о посылке на адрес https://shipito.kg/api/api.php
     * @param Model_Ads_Shop_Parcel $model
     * @param SitePageData $sitePageData
     * @return bool
     */
    public static function sendShipitoKGAddParcel(Model_Ads_Shop_Parcel $model, SitePageData $sitePageData){

        $params = array(
            'Action' => 'Add',
            'Tracking' => $model->getTracker(),
            'Location' => 'DE',
            'Description' => Func::get_in_translate_to_en($model->getText()),
            'Qty' => 1,
            'Total' => $model->getPrice(),
            'APIKEY' => self::APIKEY,
        );

        $cs = curl_init();
        $opt = array(
            CURLOPT_URL => 'https://shipito.kg/api/api.php',
            CURLOPT_HEADER => 0,
            CURLOPT_COOKIESESSION => true,
            CURLOPT_TIMEOUT => 10,
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_FOLLOWLOCATION => 0,
            CURLOPT_POST => TRUE,
            CURLOPT_POSTFIELDS => json_encode($params),
            CURLOPT_HTTPHEADER => array(
                'APIKEY: '.self::APIKEY,
                'Content-Type: application/json'
            )
        );
        curl_setopt_array($cs, $opt);
        $result = curl_exec($cs);
        curl_close($cs);

        // записываем в лог
        self::_writeLogs('id='.$model->id.' '.$result);

        $result = json_decode($result, TRUE);
        if($result['Status'] == 'ok'){
            $model->setWarehouseID($result['WarehouseID']);
            Helpers_DB::saveDBObject($model, $sitePageData);

            return TRUE;
        }else{
            self::sendShipitoKGGetParcelStatusModel($model, $sitePageData);
        }

        return FALSE;
    }

    /**
     * Получаем статус посылки о посылке по адресу https://shipito.kg/api/api.php
     * @param int $id
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @return bool
     */
    public static function sendShipitoKGGetParcelStatus($id, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver){

        $model = new Model_Ads_Shop_Parcel();
        $model->setDBDriver($driver);
        if ((!Helpers_DB::getDBObject($model, $id, $sitePageData)) || ($model->getWarehouseID() < 1)){
            return FALSE;
        }

        return self::sendShipitoKGGetParcelStatusModel($model, $sitePageData);
    }

    /**
     * Получаем статус посылки о посылке по адресу https://shipito.kg/api/api.php
     * @param Model_Ads_Shop_Parcel $model
     * @param SitePageData $sitePageData
     * @return bool
     */
    public static function sendShipitoKGGetParcelStatusModel(Model_Ads_Shop_Parcel $model, SitePageData $sitePageData){

        if ($model->getWarehouseID() > 0) {
            $params = array(
                'Action' => 'Check',
                'Location' => 'DE',
                'WarehouseID' => $model->getWarehouseID(),
                'APIKEY' => self::APIKEY,
            );
        }else{
            $params = array(
                'Action' => 'Check',
                'Location' => 'DE',
                'Tracking' => $model->getTracker(),
                'APIKEY' => self::APIKEY,
            );
        }

        $cs = curl_init();
        $opt = array(
            CURLOPT_URL => 'https://shipito.kg/api/api.php',
            CURLOPT_HEADER => 0,
            CURLOPT_COOKIESESSION => true,
            CURLOPT_TIMEOUT => 10,
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_FOLLOWLOCATION => 0,
            CURLOPT_POST => TRUE,
            CURLOPT_POSTFIELDS => json_encode($params),
            CURLOPT_HTTPHEADER => array(
                'APIKEY: '.self::APIKEY,
                'Content-Type: application/json'
            )
        );
        curl_setopt_array($cs, $opt);
        $result = curl_exec($cs);
        curl_close($cs);

        // записываем в лог
        self::_writeLogs($result);

        $result = json_decode($result, TRUE);
        if(($result['Status'] == 'ok') && ($result['Result'] == 'На складе')){
            $model->setParcelStatusID(Model_Ads_ParcelStatus::PARCEL_STATUS_IN_STOCK);
            $model->setWarehouseWeight($result['Weight']);
            Helpers_DB::saveDBObject($model, $sitePageData);

            return TRUE;
        }

        return FALSE;
    }

    /**
     * Все посылки на складе изменяем статус отправлено
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     */
    public static function setInStockToSend(SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver){

        $params = Request_RequestParams::setParams(
            array(
                'parcel_status_id' => Model_Ads_ParcelStatus::PARCEL_STATUS_IN_STOCK,
            )
        );
        $shopParcelIDs = Request_Request::find('DB_Ads_Shop_Parcel', $sitePageData->shopID, $sitePageData, $driver, $params,
            0, TRUE, array('shop_client_id' => array('email'), 'parcel_status_id' => array('name')));

        $driver->updateObjects(Model_Ads_Shop_Parcel::TABLE_NAME, $shopParcelIDs->getChildArrayID(),
            array('parcel_status_id' => Model_Ads_ParcelStatus::PARCEL_STATUS_SEND, 'date_send' => date('Y-m-d')));

        foreach ($shopParcelIDs->childs as $shopParcelID){
            self::sendEMailParcelStatus($shopParcelID->getElementValue('shop_client', 'email'), $shopParcelID->id ,
                $shopParcelID->getElementValue('parcel_status_id'), $sitePageData);
        }
    }

    /**
     * Добавление новой посылки от пользователя
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @return array
     */
    public static function add(SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver){
        if($sitePageData->userID < 1){
            throw new HTTP_Exception_500('User not auth.');
        }

        $tracker = Request_RequestParams::getParamStr('tracker');
        $price = Request_RequestParams::getParamFloat('price');
        $text = Request_RequestParams::getParamStr('text');
        if (empty($tracker) || empty($text)){
            return array(
                'id' => '0',
                'result' => FALSE,
            );
        }

        $model = new Model_Ads_Shop_Parcel();
        $model->setDBDriver($driver);

        $model->setTracker($tracker);
        $model->setPrice($price);
        $model->setText($text);
        $model->setShopClientID(Request_Ads_Shop_Client::getShopClientIDByUserID($sitePageData->userID, $sitePageData, $driver));

        $result = array();
        if ($model->validationFields($result)) {
            Helpers_DB::saveDBObject($model, $sitePageData);
            $result['values'] = $model->getValues();

            self::sendShipitoKGAddParcel($model, $sitePageData);
        }

        return array(
            'id' => $model->id,
            'result' => $result,
        );
    }

    /**
     * Сохранение посылки
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @return array
     * @throws HTTP_Exception_500
     */
    public static function save(SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        $model = new Model_Ads_Shop_Parcel();
        $model->setDBDriver($driver);

        $id = Request_RequestParams::getParamInt('id');
        if($id > 0) {
            if (!Helpers_DB::dublicateObjectLanguage($model, $id, $sitePageData)) {
                throw new HTTP_Exception_500('Parcel not found.');
            }
        }

        Request_RequestParams::setParamBoolean('is_public', $model);
        Request_RequestParams::setParamStr('text', $model);
        Request_RequestParams::setParamStr('name', $model);
        Request_RequestParams::setParamStr('old_id', $model);

        Request_RequestParams::setParamFloat('amount', $model);
        Request_RequestParams::setParamFloat('paid_amount', $model);

        $oldTracker = $model->getTracker();
        Request_RequestParams::setParamStr('tracker', $model);
        Request_RequestParams::setParamFloat('price', $model);
        Request_RequestParams::setParamDateTime('date_receipt_at', $model);
        Request_RequestParams::setParamStr('shop_name', $model);
        Request_RequestParams::setParamDateTime('date_send', $model);
        Request_RequestParams::setParamStr('address', $model);
        Request_RequestParams::setParamDateTime('tracker_send', $model);
        Request_RequestParams::setParamInt('shop_client_id', $model);

        $weight = $model->getWeight();
        Request_RequestParams::setParamFloat('weight', $model);

        $parcelStatusID = $model->getParcelStatusID();
        Request_RequestParams::setParamInt('parcel_status_id', $model);

        switch ($model->getParcelStatusID()) {
            case Model_Ads_ParcelStatus::PARCEL_STATUS_IN_STOCK:
                if(Func::_empty($model->getDateReceiptAt())){
                    $model->setDateReceiptAt(date('Y-m-d'));
                }
                break;
            case Model_Ads_ParcelStatus::PARCEL_STATUS_SEND:
                if(Func::_empty($model->getDateSend())){
                    $model->setDateSend(date('Y-m-d'));
                }
                break;
        }

        $options = Request_RequestParams::getParamArray('options');
        if ($options !== NULL) {
            $model->addOptionsArray($options);
        }

        if ($weight != $model->getWeight()){
            $model->setAmount($model->getWeight() * Api_Ads_Shop_Client::getPriceDelivery($model->getShopClientID(), $sitePageData, $driver));
        }

        $result = array();
        if ($model->validationFields($result)) {
            if($model->id < 1) {
                Helpers_DB::saveDBObject($model, $sitePageData);
            }

            if ($model->getAmount() - $model->getInvoiceAmount() > 0) {
                Api_Ads_Shop_Invoice::add($model, $sitePageData, $driver);
            }

            // загружаем фотографии
            $file = new Model_File($sitePageData);
            $file->saveFiles(Request_RequestParams::getParamArray('files'), $model, $sitePageData, $driver);

            Helpers_DB::saveDBObject($model, $sitePageData);

            if ($parcelStatusID != $model->getParcelStatusID()){
                $modelClient = $model->getElement('shop_client_id', TRUE);
                $modelStatus = $model->getElement('parcel_status_id', TRUE);
                if (($modelStatus !== NULL) && ($modelClient !== NULL)){
                    self::sendEMailParcelStatus($modelClient->getEMail(), $model->id , $modelStatus->getName(), $sitePageData);
                }
            }

            // добавляем посылку для отслеживания
            if (($oldTracker != $model->getTracker()) || (($model->getWarehouseID() == 0) && (!Func::_empty($model->getTracker())))) {
                self::sendShipitoKGAddParcel($model, $sitePageData);
            }
            $result['values'] = $model->getValues();
        }

        return array(
            'id' => $model->id,
            'result' => $result,
        );
    }

    /**
     * Отправляем сообщение пользователю о изменению статуса посылки
     * @param $email
     * @param $shopParcelID
     * @param $parcelStatusName
     * @param SitePageData $sitePageData
     */
    public static function sendEMailParcelStatus($email, $shopParcelID, $parcelStatusName, SitePageData $sitePageData)
    {
        if((! empty($email)) && (! empty($parcelStatusName))) {
            return Mail::sendEMailHTML($sitePageData, $email, 'Изменился статус Вашей посылки',
                'Добрый день, изменился статус посылки №' . $shopParcelID . '.<br> Новый статус: ' . $parcelStatusName);
        }
    }

}
