<?php defined('SYSPATH') or die('No direct script access.');

class Api_Tax_Shop_Invoice_Commercial  {

    /**
     * Сохранение товары
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @throws HTTP_Exception_500
     */
    public static function save(SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        $model = new Model_Tax_Shop_Invoice_Commercial();
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
        Request_RequestParams::setParamStr('address_delivery', $model);
        Request_RequestParams::setParamDateTime('date', $model);
        Request_RequestParams::setParamInt('shop_contract_id', $model);
        Request_RequestParams::setParamInt('shop_attorney_id', $model);
        Request_RequestParams::setParamInt('paid_type_id', $model);

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

            $shopInvoiceCommercialItems = Request_RequestParams::getParamArray('shop_invoice_items');
            if($shopInvoiceCommercialItems !== NULL) {
                $model->setAmount(Api_Tax_Shop_Invoice_Commercial_Item::save($model, $shopInvoiceCommercialItems, $sitePageData, $driver));
            }

            // привязываем счет на оплату с счетом-фактурой
            if(Request_RequestParams::getParamBoolean('is_invoice_proforma')){
                $shopInvoiceProformaID = Request_RequestParams::getParamInt('shop_invoice_proforma_id');
                if($shopInvoiceProformaID > 0){
                    $model->setShopInvoiceProformaIDs($shopInvoiceProformaID);

                    Api_Tax_Shop_Invoice_Proforma::addToTieToShopInvoiceCommercial(
                        $shopInvoiceProformaID, $model->id, $sitePageData, $driver
                    );
                }
            }

            // загружаем фотографии
            $file = new Model_File($sitePageData);
            $file->saveFiles(Request_RequestParams::getParamArray('files'), $model, $sitePageData, $driver);

            Helpers_DB::saveDBObject($model, $sitePageData);
            $result['values'] = $model->getValues();
        }

        return array(
            'result' => $result,
        );
    }
}
