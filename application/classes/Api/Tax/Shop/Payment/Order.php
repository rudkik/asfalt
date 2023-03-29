<?php defined('SYSPATH') or die('No direct script access.');

class Api_Tax_Shop_Payment_Order  {

    /**
     * Сохранение товары
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @throws HTTP_Exception_500
     */
    public static function save(SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        $model = new Model_Tax_Shop_Payment_Order();
        $model->setDBDriver($driver);

        $id = Request_RequestParams::getParamInt('id');
        if($id > 0) {
            if (!Helpers_DB::dublicateObjectLanguage($model, $id, $sitePageData)) {
                throw new HTTP_Exception_500('Payment order not found.');
            }

            $type = $model->getShopTableCatalogID();
        }else{
            $type = Request_RequestParams::getParamInt('type');
            $model->setShopTableCatalogID($type);
        }

        Request_RequestParams::setParamInt("shop_table_rubric_id", $model);
        Request_RequestParams::setParamBoolean('is_public', $model);
        Request_RequestParams::setParamStr('text', $model);
        Request_RequestParams::setParamStr('name', $model);
        Request_RequestParams::setParamBoolean("is_public", $model);
        Request_RequestParams::setParamStr("old_id", $model);
        Request_RequestParams::setParamInt("shop_table_select_id", $model);
        Request_RequestParams::setParamInt("shop_table_unit_id", $model);
        Request_RequestParams::setParamInt("shop_table_brand_id", $model);

        Request_RequestParams::setParamStr('number', $model);
        Request_RequestParams::setParamInt('shop_contractor_id', $model);
        Request_RequestParams::setParamStr('address_delivery', $model);
        Request_RequestParams::setParamDateTime('date', $model);
        Request_RequestParams::setParamFloat('amount', $model);
        Request_RequestParams::setParamInt('knp_id', $model);
        Request_RequestParams::setParamInt('kbk_id', $model);
        Request_RequestParams::setParamInt('kbe_id', $model);
        Request_RequestParams::setParamInt('gov_contractor_id', $model);
        Request_RequestParams::setParamInt('authority_id', $model);
        Request_RequestParams::setParamBoolean('is_items', $model);
        Request_RequestParams::setParamInt('shop_bank_account_id', $model);

        // при создании нового контрагента
        if(Request_RequestParams::getParamBoolean('is_add_contractor')){
            $shopContractor = Request_RequestParams::getParamArray('shop_contractor');
            if ($shopContractor !== NULL){
                $shopContractor = Api_Tax_Shop_Contractor::saveOfArray($shopContractor, $sitePageData, $driver);
                $model->setShopContractorID($shopContractor['id']);
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

            if(Func::_empty($model->getNumber())){
                $model->setNumber(Api_Tax_Sequence::getSequence($model->tableName,
                    Helpers_DateTime::getYear($model->getDate()), $sitePageData, $driver));
            }

            $shopPaymentOrderItems = Request_RequestParams::getParamArray('shop_payment_order_items');
            if($shopPaymentOrderItems !== NULL) {
                $model->setAmount(Api_Tax_Shop_Payment_Order_Item::save($model->id, $model->getShopContractorID(), $shopPaymentOrderItems, $sitePageData, $driver));
            }

            // загружаем фотографии
            $file = new Model_File($sitePageData);
            $file->saveFiles(Request_RequestParams::getParamArray('files'), $model, $sitePageData, $driver);

            if($type > 0) {
                $modelType = new Model_Shop_Table_Catalog();
                $modelType->setDBDriver($driver);
                Helpers_DB::dublicateObjectLanguage($modelType, $type, $sitePageData);

                // сохраняем список хэштегов
                $hashtags = Request_RequestParams::getParamArray('shop_table_hashtags');
                if ($hashtags !== NULL) {
                    $model->setShopTableHashtagIDsArray(Api_Shop_Table_ObjectToObject::saveToHashtags(
                        Model_Tax_Shop_Payment_Order::TABLE_ID, $model->id, $model->getShopTableCatalogID(),
                        $hashtags, $modelType->getChildShopTableCatalogID('hashtag', $sitePageData->dataLanguageID),
                        $sitePageData, $driver));
                }
            }

            Helpers_DB::saveDBObject($model, $sitePageData);
            $result['values'] = $model->getValues();
        }

        return array(
            'id' => $model->id,
            'type' => $type,
            'result' => $result,
        );
    }
}
