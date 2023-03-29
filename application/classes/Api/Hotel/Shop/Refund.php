<?php defined('SYSPATH') or die('No direct script access.');

class Api_Hotel_Shop_Refund  {

    /**
     * Сохранение товары
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @throws HTTP_Exception_500
     */
    public static function save(SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        $model = new Model_Hotel_Shop_Refund();
        $model->setDBDriver($driver);

        $id = Request_RequestParams::getParamInt('id');
        if($id > 0) {
            if (!Helpers_DB::dublicateObjectLanguage($model, $id, $sitePageData)) {
                throw new HTTP_Exception_500('Refund not found.');
            }
        }

        Request_RequestParams::setParamBoolean('is_public', $model);
        Request_RequestParams::setParamStr('text', $model);
        Request_RequestParams::setParamStr('name', $model);
        Request_RequestParams::setParamStr("old_id", $model);
        Request_RequestParams::setParamStr("number", $model);
        Request_RequestParams::setParamDateTime('date', $model);

        Request_RequestParams::setParamInt('refund_type_id', $model);

        $oldShopClientID = $model->getShopClientID();
        Request_RequestParams::setParamInt('shop_client_id', $model);

        $oldAmount = $model->getAmount();
        Request_RequestParams::setParamFloat('amount', $model);

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
            // номера ставим только если возврат был на банковскую карту
            if(Func::_empty($model->getNumber()) && ($model->getRefundTypeID() == Model_Hotel_RefundType::REFUND_TYPE_BANK_CARD)){
                $n = Database::instance()->query(Database::SELECT, 'SELECT nextval(\'shop_refund\') as id;')->as_array(NULL, 'id')[0];
                $n = '0000000000'.$n;
                $n = 'К'.substr($n, strlen($n) - 10);
                $model->setNumber($n);
            }
            Helpers_DB::saveDBObject($model, $sitePageData);
            $result['values'] = $model->getValues();

            if (!$model->getIsDelete()) {
                // пересчет баланса клиента
                Api_Hotel_Shop_Client::recountClientBalance($model->getShopClientID(), $sitePageData, $driver, TRUE);
                if($oldShopClientID != $model->getShopClientID()) {
                    Api_Hotel_Shop_Client::recountClientBalance($oldShopClientID, $sitePageData, $driver, TRUE);
                }
            }
        }

        return array(
            'id' => $model->id,
            'result' => $result,
        );
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

        $model = new Model_Hotel_Shop_Refund();
        $model->setDBDriver($driver);

        if (!Helpers_DB::dublicateObjectLanguage($model, $id, $sitePageData)) {
            throw new HTTP_Exception_500('Refund not found.');
        }

        if(Request_RequestParams::getParamBoolean("is_undel") === TRUE){
            $model->dbUnDelete($sitePageData->userID, 0, $sitePageData->shopID);
        }else {
            $model->dbDelete($sitePageData->userID, 0, $sitePageData->shopID);
        }

        // пересчет баланса клиента
        Api_Hotel_Shop_Client::recountClientBalance($model->getShopClientID(), $sitePageData, $driver, TRUE);

        return TRUE;
    }
}