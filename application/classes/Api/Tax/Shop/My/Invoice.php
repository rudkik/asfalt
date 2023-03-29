<?php defined('SYSPATH') or die('No direct script access.');

class Api_Tax_Shop_My_Invoice  {

    /**
     * Сохранение товары
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @throws HTTP_Exception_500
     */
    public static function save(SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        $model = new Model_Tax_Shop_My_Invoice();
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
        Request_RequestParams::setParamBoolean("is_public", $model);
        Request_RequestParams::setParamStr("email", $model);
        Request_RequestParams::setParamStr("old_id", $model);

        Request_RequestParams::setParamStr('number', $model);
        Request_RequestParams::setParamInt('shop_contractor_id', $model);
        Request_RequestParams::setParamDateTime('date', $model);
        Request_RequestParams::setParamInt('shop_contract_id', $model);

        Request_RequestParams::setParamBoolean('is_act_service', $model);
        Request_RequestParams::setParamStr('act_service_number', $model);
        Request_RequestParams::setParamDateTime('act_service_date', $model);
        Request_RequestParams::setParamBoolean('is_act_product', $model);
        Request_RequestParams::setParamStr('act_product_number', $model);
        Request_RequestParams::setParamDateTime('act_product_date', $model);
        Request_RequestParams::setParamBoolean('is_invoice_commercial', $model);
        Request_RequestParams::setParamStr('invoice_commercial_number', $model);
        Request_RequestParams::setParamDateTime('invoice_commercial_date', $model);
        Request_RequestParams::setParamBoolean('is_cash_memo', $model);
        Request_RequestParams::setParamStr('cash_memo_number', $model);
        Request_RequestParams::setParamDateTime('cash_memo_date', $model);

        $isNDS = Request_RequestParams::getParamBoolean('is_nds');
        if ($isNDS !== NULL) {
            $model->setIsNDS($isNDS);
        }
        if ($model->getIsNDS() && ($model->getNDS() == 0)){
            $model->setNDS(Api_Tax_NDS::getNDS());
        }

        // при создании нового контрагента
        if(Request_RequestParams::getParamBoolean('is_add_contractor')){
            $shopContractor = Request_RequestParams::getParamArray('shop_contractor');
            if ($shopContractor !== NULL){
                $shopContractor = Api_Tax_Shop_Contractor::saveOfArray($shopContractor, $sitePageData, $driver);
                $model->setShopContractorID($shopContractor['id']);
            }
        }

        // при создании нового договора
        if(Request_RequestParams::getParamBoolean('is_add_contract')){
            $shopContract = Request_RequestParams::getParamArray('shop_contract');
            if ($shopContract !== NULL){
                $shopContract = Api_Tax_Shop_Contract::saveOfArray($model->getShopContractorID(), $shopContract, $sitePageData, $driver);
                $model->setShopContractID($shopContract['id']);
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

            $shopMyInvoiceItems = Request_RequestParams::getParamArray('shop_my_invoice_items');
            if($shopMyInvoiceItems !== NULL) {
                $model->setAmount(Api_Tax_Shop_My_Invoice_Item::save($model, $shopMyInvoiceItems, $sitePageData, $driver));
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
