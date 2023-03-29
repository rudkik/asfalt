<?php defined('SYSPATH') or die('No direct script access.');

class Api_Shop_Branch  {

    /**
     * Сохранение списка товаров
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     */
    public static function saveListCollations($shopTableCatalogID, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        $model = new Model_Shop();
        $model->setDBDriver($driver);

        $shopBranchs = Request_RequestParams::getParamArray('data', array());
        foreach ($shopBranchs as &$shopBranch) {
            $model->clear();

            $id = intval(Arr::path($shopBranch, 'shop_branch_id', 0));
            if ($id > 0) {
                if (!Helpers_DB::dublicateObjectLanguage($model, $id, $sitePageData, $sitePageData->shopID)) {
                    continue;
                }
            } else {
                $model->setShopTableCatalogID($shopTableCatalogID);
            }

            if($id < 1) {
                if (key_exists('is_public', $shopBranch)) {
                    $model->setIsPublic($shopBranch['is_public']);
                }
                if (key_exists('collations', $shopBranch)) {
                    $model->addCollationsArray($shopBranch['collations']);
                }
                if (key_exists('old_id', $shopBranch)) {
                    $model->setOldID($shopBranch['old_id']);
                }
                if (key_exists('sub_domain', $shopBranch)) {
                    $model->setSubDomain($shopBranch['sub_domain']);
                }
                if (key_exists('domain', $shopBranch)) {
                    $model->setDomain($shopBranch['domain']);
                }
                if (key_exists('name', $shopBranch)) {
                    if (!empty($shopBranch['name'])) {
                        $model->setName($shopBranch['name']);
                    }
                }
                if (key_exists('text', $shopBranch)) {
                    $model->setText($shopBranch['text']);
                }
            }

            $options = array();
            foreach($shopBranch as $k => $v){
                if(strpos($k, 'options.') === 0){
                    $options[str_replace('options.', '', $k)] = $v;
                }
            }
            $model->addOptionsArray($options, FALSE);

            if (key_exists('price', $shopBranch)) {
                $model->setPrice($shopBranch['price']);
            }

            $shopBranch['shop_branch_id'] = Helpers_DB::saveDBObject($model, $sitePageData, $sitePageData->shopID);
            $shopBranch['shop_branch_name'] = $model->getName();
        }

        return $shopBranchs;
    }

    /**
     * Сохранение списка товаров
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     */
    public static function saveList(SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        $model = new Model_Shop();
        $model->setDBDriver($driver);

        $shopBranchs = Request_RequestParams::getParamArray('shop_branchs', array());
        if ($shopBranchs === NULL) {
            return FALSE;
        }

        foreach ($shopBranchs as $id => $shopBranch) {
            $id = intval($id);
            if ($id > 0) {
                if (!Helpers_DB::dublicateObjectLanguage($model, $id, $sitePageData, $sitePageData->shopID)) {
                    continue;
                }

                if (key_exists('is_public', $shopBranch)) {
                    $model->setIsPublic($shopBranch['is_public']);
                }
                if (key_exists('name', $shopBranch)) {
                    if (!empty($shopBranch['name'])) {
                        $model->setName($shopBranch['name']);
                    }
                }

                if (key_exists('text', $shopBranch)) {
                    $model->setText($shopBranch['text']);
                }

                if (key_exists('sub_domain', $shopBranch)) {
                    $model->setSubDomain($shopBranch['sub_domain']);
                }
                if (key_exists('domain', $shopBranch)) {
                    $model->setDomain($shopBranch['domain']);
                }

                if (key_exists('remarketing', $shopBranch)) {
                    $model->setRemarketing($shopBranch['remarketing']);
                }

                if (key_exists('shop_table_rubric_id', $shopBranch)) {
                    $model->setShopTableRubricID($shopBranch['shop_table_rubric_id']);
                }

                if (key_exists('price_old', $shopBranch)) {
                    $model->setPriceOld($shopBranch['price_old']);
                }

                if (key_exists('options', $shopBranch)) {
                    $options = $shopBranch['options'];
                    if (is_array($options)) {
                        $model->addOptionsArray($options);
                    }
                }
                if (key_exists('collations', $shopBranch)) {
                    $options = $shopBranch['collations'];
                    if (!is_array($options)) {
                        $options = explode("\r\n", $options);
                    }
                    $model->addCollationsArray($options);
                }

                Helpers_DB::saveDBObject($model, $sitePageData, $sitePageData->shopID);
            }
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

        $model = new Model_Shop();
        $model->setDBDriver($driver);

        if (!Helpers_DB::dublicateObjectLanguage($model, $id, $sitePageData)) {
            throw new HTTP_Exception_500('Branch not found.');
        }

        if(Request_RequestParams::getParamBoolean("is_undel") === TRUE){
            $model->dbUnDelete($sitePageData->userID, 0, $sitePageData->shopID);
        }else {
            $model->dbDelete($sitePageData->userID, 0, $sitePageData->shopID);
        }
    }

    /**
     * Сохранение товары
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @throws HTTP_Exception_500
     */
    public static function save(SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        $model = new Model_Shop();
        $model->setDBDriver($driver);

        $id = Request_RequestParams::getParamInt('id');
        if($id > 0) {
            if (!Helpers_DB::dublicateObjectLanguage($model, $id, $sitePageData)) {
                throw new HTTP_Exception_500('Branch not found.');
            }

            $type = $model->getShopTableCatalogID();
        }else{
            $type = Request_RequestParams::getParamInt('type');

            $model->setShopTableCatalogID($type);
            $model->setMainShopID($sitePageData->shopID);
        }

        Request_RequestParams::setParamInt("shop_operation_id", $model);
        Request_RequestParams::setParamInt("shop_table_rubric_id", $model);
        Request_RequestParams::setParamBoolean('is_public', $model);
        Request_RequestParams::setParamStr('text', $model);
        Request_RequestParams::setParamStr('name', $model);
        Request_RequestParams::setParamBoolean("is_public", $model);
        Request_RequestParams::setParamStr("sub_domain", $model);
        Request_RequestParams::setParamStr("domain", $model);
        Request_RequestParams::setParamStr("official_name", $model);
        Request_RequestParams::setParamInt("order", $model);
        Request_RequestParams::setParamStr("old_id", $model);
        Request_RequestParams::setParamStr('remarketing', $model);
        Request_RequestParams::setParamInt("shop_table_select_id", $model);
        Request_RequestParams::setParamInt("shop_table_unit_id", $model);
        Request_RequestParams::setParamInt("shop_table_brand_id", $model);

        Request_RequestParams::setParamInt("shop_address_id", $model);
        Request_RequestParams::setParamInt("city_id", $model);
        Request_RequestParams::setParamInt("default_language_id", $model);
        Request_RequestParams::setParamInt("default_currency_id", $model);
        Request_RequestParams::setParamStr("official_name", $model);
        Request_RequestParams::setParamInt("shop_root_id", $model);
        Request_RequestParams::setParamBoolean("is_block", $model);
        Request_RequestParams::setParamBoolean("is_active", $model);

        $tmp = Request_RequestParams::getParamArray('currency_ids');
        if($tmp !== NULL){
            $model->setCurrencyIDsArray($tmp);
        }

        $tmp = Request_RequestParams::getParamArray('language_ids');
        if($tmp !== NULL){
            $model->setLanguageIDsArray($tmp);
        }

        $tmp = Request_RequestParams::getParamArray('city_ids');
        if($tmp !== NULL){
            $model->setCityIDsArray($tmp);
        }

        $tmp = Request_RequestParams::getParamArray('work_time');
        if($tmp !== NULL){
            $model->setWorkTimeArray($tmp);
        }

        $tmp = Request_RequestParams::getParamArray('delivery_work_time');
        if($tmp !== NULL){
            $model->setDeliveryWorkTimeArray($tmp);
        }

        $tmp = Request_RequestParams::getParamArray('shop_menu');
        if($tmp !== NULL){
            $model->setShopMenuArray($tmp);
        }

        $tmp = Request_RequestParams::getParamArray('params');
        if($tmp !== NULL){
            $model->setParamsArray($tmp);
        }

        $options = Request_RequestParams::getParamArray('options');
        if ($options !== NULL) {
            $model->addOptionsArray($options);
        }

        $seo = Request_RequestParams::getParamArray('seo');
        if ($seo !== NULL) {
            $model->setSEOArray($seo);
        }

        $result = array();
        if ($model->validationFields($result)) {
            if($model->id < 1) {
                Helpers_DB::saveDBObject($model, $sitePageData);
                $isAdd = TRUE;
            }else{
                $isAdd = FALSE;
            }

            // загружаем фотографии
            $file = new Model_File($sitePageData);
            $file->saveFiles(Request_RequestParams::getParamArray('files'), $model, $sitePageData, $driver);

            if($type > 0) {
                $modelType = new Model_Shop_Table_Catalog();
                $modelType->setDBDriver($driver);
                Helpers_DB::dublicateObjectLanguage($modelType, $type, $sitePageData);

                // сохраняем список фильтров
                $filters = Request_RequestParams::getParamArray('shop_table_filters');
                if ($filters !== NULL) {
                    $model->setShopTableFilterIDsArray(Api_Shop_Table_ObjectToObject::saveToFilters(
                        Model_Shop::TABLE_ID, $model->id, $model->getShopTableCatalogID(),
                        $filters, $modelType->getChildShopTableCatalogID('filter', $sitePageData->dataLanguageID),
                        $sitePageData, $driver));
                }

                // сохраняем список хэштегов
                $hashtags = Request_RequestParams::getParamArray('shop_table_hashtags');
                if ($hashtags !== NULL) {
                    $model->setShopTableHashtagIDsArray(Api_Shop_Table_ObjectToObject::saveToHashtags(
                        Model_Shop::TABLE_ID, $model->id, $model->getShopTableCatalogID(),
                        $hashtags, $modelType->getChildShopTableCatalogID('hashtag', $sitePageData->dataLanguageID),
                        $sitePageData, $driver));
                }

                // выполняем SQL запрос после создание записи
                if ($isAdd){
                    $insertSQL = $modelType->getInsetSQLChild();
                    if(!empty($insertSQL)){
                        $driver->sendSQL(str_replace('#id#', $model->id, $insertSQL));
                    }
                }
            }

            // сохраняем группу товаров
            $groups = Request_RequestParams::getParamArray('shop_table_groups');
            if ($groups !== NULL) {
                $model->setShopTableGroupIDsArray(Api_Shop_Table_Group::saveList(
                    Model_Shop::TABLE_ID, $model->id, $model->getShopTableCatalogID(),
                    $groups,
                    $sitePageData, $driver));
            }

            // подобные товары
            $similars = Request_RequestParams::getParamArray('shop_table_similars');
            if($similars !== NULL){
                $model->setShopTableSimilarIDsArray(Api_Shop_Table_Similar::saveList(
                    Model_Shop::TABLE_ID, $model->id, $model->getShopTableCatalogID(),
                    $similars,
                    $sitePageData, $driver));
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
