<?php defined('SYSPATH') or die('No direct script access.');

class Api_Tax_Shop_Invoice_Proforma  {

    /**
     * Добавляем привязку счет-фактуры к счету на оплату
     * @param $shopInvoiceProformaID
     * @param $shopInvoiceCommercialID
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @return bool
     */
    public static function addToTieToShopInvoiceCommercial($shopInvoiceProformaID, $shopInvoiceCommercialID,
                                                        SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        $model = new Model_Tax_Shop_Invoice_Proforma();
        $model->setDBDriver($driver);

        if (!Helpers_DB::getDBObject($model, $shopInvoiceProformaID, $sitePageData)) {
            return FALSE;
        }

        $model->addShopInvoiceCommercialIDs($shopInvoiceCommercialID);
        Helpers_DB::saveDBObject($model, $sitePageData);
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
        $model = new Model_Tax_Shop_Invoice_Proforma();
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
        Request_RequestParams::setParamStr("old_id", $model);
        Request_RequestParams::setParamInt("shop_bank_account_id", $model);

        Request_RequestParams::setParamStr('number', $model);
        Request_RequestParams::setParamInt('shop_contractor_id', $model);
        Request_RequestParams::setParamDateTime('date', $model);
        Request_RequestParams::setParamInt('shop_contract_id', $model);
        Request_RequestParams::setParamInt('knp_id', $model);
        Request_RequestParams::setParamBoolean('is_paid', $model);

        if($model->id < 1){
            $model->setIsNDS(Arr::path($sitePageData->shop->getRequisitesArray(), 'is_nds', FALSE));
        }else{
            $isNDS = Request_RequestParams::getParamBoolean('is_nds');
            if ($isNDS !== NULL) {
                $model->setIsNDS($isNDS);
            }
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

        // при создании новой доверенности
        if(Request_RequestParams::getParamBoolean('is_add_attorney')){
            $shopAttorney = Request_RequestParams::getParamArray('shop_attorney');
            if ($shopAttorney !== NULL){
                $shopAttorney = Api_Tax_Shop_Attorney::saveOfArray($model->getShopContractorID(), $shopAttorney, $sitePageData, $driver);
                $model->setShopAttorneyID($shopAttorney['id']);
            }
        }

        $options = Request_RequestParams::getParamArray('options');
        if ($options !== NULL) {
            $model->addOptionsArray($options);
        }

        if(Func::_empty($model->getNumber())){
            $model->setNumber(Api_Tax_Sequence::getSequence($model->tableName,
                Helpers_DateTime::getYear($model->getDate()), $sitePageData, $driver));
        }

        $result = array();
        if ($model->validationFields($result)) {
            if($model->id < 1) {
                Helpers_DB::saveDBObject($model, $sitePageData);
            }
            $shopInvoiceProformaItems = Request_RequestParams::getParamArray('shop_invoice_items');
            if($shopInvoiceProformaItems !== NULL) {
                $model->setAmount(Api_Tax_Shop_Invoice_Proforma_Item::save($model, $shopInvoiceProformaItems, $sitePageData, $driver));
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
