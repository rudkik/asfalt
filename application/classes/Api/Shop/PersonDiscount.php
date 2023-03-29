<?php defined('SYSPATH') or die('No direct script access.');

class Api_Shop_PersonDiscount {

    /**
     * Сохранение списка товаров
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     */
    public static function saveListCollations($shopTableCatalogID, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        $model = new Model_Shop_PersonDiscount();
        $model->setDBDriver($driver);

        $shopCoupons = Request_RequestParams::getParamArray('data', array());
        foreach ($shopCoupons as &$shopCoupon) {
            $model->clear();

            $id = intval(Arr::path($shopCoupon, 'shop_coupon_id', 0));
            if ($id > 0) {
                if (!Helpers_DB::dublicateObjectLanguage($model, $id, $sitePageData, $sitePageData->shopID)) {
                    continue;
                }
            } else {
                $model->setShopTableCatalogID($shopTableCatalogID);
            }

            if($id < 1) {
                if (key_exists('is_public', $shopCoupon)) {
                    $model->setIsPublic($shopCoupon['is_public']);
                }
                if (key_exists('collations', $shopCoupon)) {
                    $model->addCollationsArray($shopCoupon['collations']);
                }
                if (key_exists('old_id', $shopCoupon)) {
                    $model->setOldID($shopCoupon['old_id']);
                }
                if (key_exists('number', $shopCoupon)) {
                    $model->setNumber($shopCoupon['number']);
                }
                if (key_exists('name', $shopCoupon)) {
                    if (!empty($shopCoupon['name'])) {
                        $model->setName($shopCoupon['name']);
                    }
                }
                if (key_exists('discount', $shopCoupon)) {
                    $model->setDiscount($shopCoupon['discount']);
                }
                if (key_exists('text', $shopCoupon)) {
                    $model->setText($shopCoupon['text']);
                }
                if (key_exists('from_at', $shopCoupon)) {
                    $model->setFromAt($shopCoupon['from_at']);
                }
                if (key_exists('to_at', $shopCoupon)) {
                    $model->setToAt($shopCoupon['to_at']);
                }
            }

            $options = array();
            foreach($shopCoupon as $k => $v){
                if(strpos($k, 'options.') === 0){
                    $options[str_replace('options.', '', $k)] = $v;
                }
            }
            $model->addOptionsArray($options, FALSE);

            if (key_exists('price', $shopCoupon)) {
                $model->setPrice($shopCoupon['price']);
            }

            $shopCoupon['shop_coupon_id'] = Helpers_DB::saveDBObject($model, $sitePageData, $sitePageData->shopID);
            $shopCoupon['shop_coupon_name'] = $model->getName();
        }

        return $shopCoupons;
    }

    /**
     * Сохранение списка товаров
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     */
    public static function saveList(SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        $model = new Model_Shop_PersonDiscount();
        $model->setDBDriver($driver);

        $shopCoupons = Request_RequestParams::getParamArray('shop_coupons', array());
        if ($shopCoupons === NULL) {
            return FALSE;
        }

        foreach ($shopCoupons as $id => $shopCoupon) {
            $id = intval($id);
            if ($id > 0) {
                if (!Helpers_DB::dublicateObjectLanguage($model, $id, $sitePageData, $sitePageData->shopID)) {
                    continue;
                }

                if (key_exists('is_public', $shopCoupon)) {
                    $model->setIsPublic($shopCoupon['is_public']);
                }
                if (key_exists('name', $shopCoupon)) {
                    if (!empty($shopCoupon['name'])) {
                        $model->setName($shopCoupon['name']);
                    }
                }

                if (key_exists('text', $shopCoupon)) {
                    $model->setText($shopCoupon['text']);
                }

                if (key_exists('number', $shopCoupon)) {
                    $model->setNumber($shopCoupon['number']);
                }

                if (key_exists('remarketing', $shopCoupon)) {
                    $model->setRemarketing($shopCoupon['remarketing']);
                }

                if (key_exists('shop_table_rubric_id', $shopCoupon)) {
                    $model->setShopTableRubricID($shopCoupon['shop_table_rubric_id']);
                }

                if (key_exists('discount', $shopCoupon)) {
                    $model->setPriceOld($shopCoupon['discount']);
                }

                if (key_exists('from_at', $shopCoupon)) {
                    $model->setPriceOld($shopCoupon['from_at']);
                }

                if (key_exists('to_at', $shopCoupon)) {
                    $model->setPriceOld($shopCoupon['to_at']);
                }

                if (key_exists('options', $shopCoupon)) {
                    $options = $shopCoupon['options'];
                    if (is_array($options)) {
                        $model->addOptionsArray($options);
                    }
                }
                if (key_exists('collations', $shopCoupon)) {
                    $options = $shopCoupon['collations'];
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

        $model = new Model_Shop_PersonDiscount();
        $model->setDBDriver($driver);

        if (!Helpers_DB::dublicateObjectLanguage($model, $id, $sitePageData)) {
            throw new HTTP_Exception_500('Coupons not found.');
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
        $model = new Model_Shop_PersonDiscount();
        $model->setDBDriver($driver);

        $id = Request_RequestParams::getParamInt('id');
        if($id > 0) {
            if (!Helpers_DB::dublicateObjectLanguage($model, $id, $sitePageData)) {
                throw new HTTP_Exception_500('Coupons not found.');
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
        Request_RequestParams::setParamStr("phone", $model);
        Request_RequestParams::setParamFloat("discount", $model);
        Request_RequestParams::setParamBoolean("is_percent", $model);
        Request_RequestParams::setParamInt("order", $model);
        Request_RequestParams::setParamStr("old_id", $model);
        Request_RequestParams::setParamStr('remarketing', $model);
        Request_RequestParams::setParamInt("shop_table_select_id", $model);
        Request_RequestParams::setParamInt("shop_table_unit_id", $model);
        Request_RequestParams::setParamInt("shop_table_brand_id", $model);
        Request_RequestParams::setParamDateTime('from_at', $model);
        Request_RequestParams::setParamDateTime('to_at', $model);

        $rubrics = Request_RequestParams::getParamArray('shop_table_rubric_ids');
        if ($rubrics !== NULL) {
            $model->setShopTableRubricIDsArray($rubrics);
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
                        Model_Shop_PersonDiscount::TABLE_ID, $model->id, $model->getShopTableCatalogID(),
                        $filters, $modelType->getChildShopTableCatalogID('filter', $sitePageData->dataLanguageID),
                        $sitePageData, $driver));
                }

                // сохраняем список хэштегов
                $hashtags = Request_RequestParams::getParamArray('shop_table_hashtags');
                if ($hashtags !== NULL) {
                    $model->setShopTableHashtagIDsArray(Api_Shop_Table_ObjectToObject::saveToHashtags(
                        Model_Shop_PersonDiscount::TABLE_ID, $model->id, $model->getShopTableCatalogID(),
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
