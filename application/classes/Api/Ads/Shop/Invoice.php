<?php defined('SYSPATH') or die('No direct script access.');

class Api_Ads_Shop_Invoice  {

    /**
     * Отправляем сообщение пользователю о добавления счета
     * @param Model_Ads_Shop_Invoice $model
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @return bool
     */
    public static function sendAddInvoice(Model_Ads_Shop_Invoice $model, SitePageData $sitePageData,
                                          Model_Driver_DBBasicDriver $driver)
    {
        $modelClient = new  Model_Ads_Shop_Client();
        $modelClient->setDBDriver($driver);
        if (!Helpers_DB::getDBObject($modelClient, $model->getShopClientID(), $sitePageData)){
            return FALSE;
        }

        $email = $modelClient->getEmail();
        if(! empty($email)) {
            return Mail::sendEMailHTML($sitePageData, $email, 'Добавлен счет на оплату',
                'Добрый день, добавлен счет на оплату №' . $model->id . ' на сумму: ' . $model->getAmount().'$.');
        }

        return FALSE;
    }

    /**
     * Добавление счета
     * @param Model_Ads_Shop_Parcel $model
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @return array
     * @throws HTTP_Exception_500
     */
    public static function add(Model_Ads_Shop_Parcel $modelParcel, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        $model = new Model_Ads_Shop_Invoice();
        $model->setDBDriver($driver);

        $model->setAmount($modelParcel->getAmount() - $modelParcel->getInvoiceAmount());
        $model->setShopClientID($modelParcel->getShopClientID());
        $model->setShopParcelID($modelParcel->id);

        $modelParcel->setInvoiceAmount($modelParcel->getAmount());
        Helpers_DB::saveDBObject($model, $sitePageData);

        self::sendAddInvoice($model, $sitePageData, $driver);
    }

    /**
     * удаление счета
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @param int $id
     * @return bool
     * @throws HTTP_Exception_500
     */
    public static function delete(SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver, $id = 0)
    {
        if ($id < 1) {
            $id = Request_RequestParams::getParamInt('id');
            if ($id < 0) {
                return FALSE;
            }
        }

        $model = new Model_Ads_Shop_Invoice();
        $model->setDBDriver($driver);

        if (!Helpers_DB::dublicateObjectLanguage($model, $id, $sitePageData)) {
            throw new HTTP_Exception_500('Invoice not found.');
        }

        $modelParcel = new Model_Ads_Shop_Parcel();
        $modelParcel->setDBDriver($driver);

        if(Request_RequestParams::getParamBoolean("is_undel") === TRUE){
            $model->dbUnDelete($sitePageData->userID, 0, $sitePageData->shopID);

            if ($model->getIsPaid()) {
                $modelParcel->setPaidAmount($modelParcel->getPaidAmount() + $model->getAmount());
            }
            $modelParcel->setInvoiceAmount($modelParcel->getInvoiceAmount() + $model->getAmount());
        }else {
            $model->dbDelete($sitePageData->userID, 0, $sitePageData->shopID);

            if ($model->getIsPaid()) {
                $modelParcel->setPaidAmount($modelParcel->getPaidAmount() - $model->getAmount());
            }
            $modelParcel->setInvoiceAmount($modelParcel->getInvoiceAmount() - $model->getAmount());
        }

        Helpers_DB::saveDBObject($modelParcel, $sitePageData);

        return TRUE;
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
        $model = new Model_Ads_Shop_Invoice();
        $model->setDBDriver($driver);

        $id = Request_RequestParams::getParamInt('id');
        if($id > 0) {
            if (!Helpers_DB::dublicateObjectLanguage($model, $id, $sitePageData)) {
                throw new HTTP_Exception_500('Invoice not found.');
            }
        }

        Request_RequestParams::setParamBoolean('is_public', $model);
        Request_RequestParams::setParamStr('text', $model);
        Request_RequestParams::setParamStr('name', $model);
        Request_RequestParams::setParamStr('old_id', $model);

        $amount = $model->getAmount();
        Request_RequestParams::setParamFloat('amount', $model);
        Request_RequestParams::setParamDateTime('date_paid', $model);
        Request_RequestParams::setParamInt('shop_client_id', $model);

        $shopParcelID = $model->getShopParcelID();
        Request_RequestParams::setParamInt('shop_parcel_id', $model);

        $isPayOld = $model->getIsPaid();
        $isPay = Request_RequestParams::getParamBoolean('is_paid');
        if ($isPay !== NULL){
            $model->setPaid($isPay);
        }

        $options = Request_RequestParams::getParamArray('options');
        if ($options !== NULL) {
            $model->addOptionsArray($options);
        }

        $result = array();
        if ($model->validationFields($result)) {
            if($model->id < 1) {
                Helpers_DB::saveDBObject($model, $sitePageData);
                self::sendAddInvoice($model, $sitePageData, $driver);
            }

            // фиксируем оплаченную сумму
            $modelParcel = new Model_Ads_Shop_Parcel();
            $modelParcel->setDBDriver($driver);
            if (($shopParcelID == $model->getShopParcelID())) {
                if (($amount != $model->getAmount())  && ($shopParcelID > 0)){
                    if (Helpers_DB::getDBObject($modelParcel, $model->getShopParcelID(), $sitePageData)) {
                        $modelParcel->setInvoiceAmount($modelParcel->getInvoiceAmount() - $amount + $model->getAmount());

                        if ($isPayOld) {
                            if ($isPay) {
                                $modelParcel->setPaidAmount($modelParcel->getPaidAmount() - $amount + $model->getAmount());
                            } else {
                                $modelParcel->setPaidAmount($modelParcel->getPaidAmount() - $amount);
                            }
                        }

                        Helpers_DB::saveDBObject($modelParcel, $sitePageData);
                    }
                }
            }else{
                if ($shopParcelID > 0){
                    if (Helpers_DB::getDBObject($modelParcel, $shopParcelID, $sitePageData)) {
                        $modelParcel->setInvoiceAmount($modelParcel->getInvoiceAmount() - $amount);

                        if ($isPayOld) {
                            $modelParcel->setPaidAmount($modelParcel->getPaidAmount() - $amount);
                        }

                        Helpers_DB::saveDBObject($modelParcel, $sitePageData);
                    }
                }

                if ($model->getShopParcelID() > 0){
                    if (Helpers_DB::getDBObject($modelParcel, $model->getShopParcelID(), $sitePageData)) {
                        $modelParcel->setInvoiceAmount($modelParcel->getInvoiceAmount() + $model->getAmount());

                        if ($isPay) {
                            $modelParcel->setPaidAmount($modelParcel->getPaidAmount() + $model->getAmount());
                        }

                        Helpers_DB::saveDBObject($modelParcel, $sitePageData);
                    }
                }
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
