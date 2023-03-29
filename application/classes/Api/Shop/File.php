<?php defined('SYSPATH') or die('No direct script access.');

class Api_Shop_File  {

    /**
     * Сохранение списка товаров
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     */
    public static function saveListCollations($shopTableCatalogID, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        $model = new Model_Shop_File();
        $model->setDBDriver($driver);

        $shopFiles = Request_RequestParams::getParamArray('data', array());
        foreach ($shopFiles as &$shopFile) {
            $model->clear();

            $id = intval(Arr::path($shopFile, 'shop_file_id', 0));
            if ($id > 0) {
                if (!Helpers_DB::dublicateObjectLanguage($model, $id, $sitePageData, $sitePageData->shopID)) {
                    continue;
                }
            } else {
                $model->setShopTableCatalogID($shopTableCatalogID);
            }

            if($id < 1) {
                if (key_exists('is_public', $shopFile)) {
                    $model->setIsPublic($shopFile['is_public']);
                }
                if (key_exists('collations', $shopFile)) {
                    $model->addCollationsArray($shopFile['collations']);
                }
                if (key_exists('old_id', $shopFile)) {
                    $model->setOldID($shopFile['old_id']);
                }
                if (key_exists('article', $shopFile)) {
                    $model->setArticle($shopFile['article']);
                }
                if (key_exists('name', $shopFile)) {
                    if (!empty($shopFile['name'])) {
                        $model->setName($shopFile['name']);
                    }
                }
                if (key_exists('text', $shopFile)) {
                    $model->setText($shopFile['text']);
                }
            }

            $options = array();
            foreach($shopFile as $k => $v){
                if(strpos($k, 'options.') === 0){
                    $options[str_replace('options.', '', $k)] = $v;
                }
            }
            $model->addOptionsArray($options, FALSE);

            if (key_exists('price', $shopFile)) {
                $model->setPrice($shopFile['price']);
            }

            $shopFile['shop_file_id'] = Helpers_DB::saveDBObject($model, $sitePageData, $sitePageData->shopID);
            $shopFile['shop_file_name'] = $model->getName();
        }

        return $shopFiles;
    }

    /**
     * Сохранение списка товаров
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     */
    public static function saveList(SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        $model = new Model_Shop_File();
        $model->setDBDriver($driver);

        $shopFiles = Request_RequestParams::getParamArray('shop_files', array());
        if ($shopFiles === NULL) {
            return FALSE;
        }

        foreach ($shopFiles as $id => $shopFile) {
            $id = intval($id);
            if ($id > 0) {
                if (!Helpers_DB::dublicateObjectLanguage($model, $id, $sitePageData, $sitePageData->shopID)) {
                    continue;
                }

                if (key_exists('is_public', $shopFile)) {
                    $model->setIsPublic($shopFile['is_public']);
                }
                if (key_exists('name', $shopFile)) {
                    if (!empty($shopFile['name'])) {
                        $model->setName($shopFile['name']);
                    }
                }

                if (key_exists('text', $shopFile)) {
                    $model->setText($shopFile['text']);
                }

                if (key_exists('article', $shopFile)) {
                    $model->setArticle($shopFile['article']);
                }

                if (key_exists('remarketing', $shopFile)) {
                    $model->setRemarketing($shopFile['remarketing']);
                }

                if (key_exists('shop_table_rubric_id', $shopFile)) {
                    $model->setShopTableRubricID($shopFile['shop_table_rubric_id']);
                }

                if (key_exists('options', $shopFile)) {
                    $options = $shopFile['options'];
                    if (is_array($options)) {
                        $model->addOptionsArray($options);
                    }
                }
                if (key_exists('collations', $shopFile)) {
                    $options = $shopFile['collations'];
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
     * Сохранение товары
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @throws HTTP_Exception_500
     */
    public static function save(SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        $model = new Model_Shop_File();
        $model->setDBDriver($driver);

        $id = Request_RequestParams::getParamInt('id');
        if($id > 0) {
            if (!Helpers_DB::dublicateObjectLanguage($model, $id, $sitePageData)) {
                throw new HTTP_Exception_500('Files not found.');
            }

            $type = $model->getShopTableCatalogID();
            $isGroup = $model->getIsGroup();
        }else{
            $type = Request_RequestParams::getParamInt('type');
            $isGroup = Request_RequestParams::getParamBoolean('is_group');

            $model->setShopTableCatalogID($type);
            $model->setIsGroup($isGroup);
        }


        Request_RequestParams::setParamInt("shop_table_rubric_id", $model);

        Request_RequestParams::setParamBoolean('is_public', $model);
        Request_RequestParams::setParamStr('text', $model);
        Request_RequestParams::setParamStr('name', $model);
        Request_RequestParams::setParamBoolean("is_public", $model);
        Request_RequestParams::setParamStr("article", $model);
        Request_RequestParams::setParamInt("order", $model);
        Request_RequestParams::setParamBoolean("is_group", $model);
        Request_RequestParams::setParamStr("old_id", $model);
        Request_RequestParams::setParamStr('remarketing', $model);
        Request_RequestParams::setParamInt("shop_table_select_id", $model);
        Request_RequestParams::setParamInt("shop_table_unit_id", $model);
        Request_RequestParams::setParamInt("shop_table_brand_id", $model);

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
                        Model_Shop_File::TABLE_ID, $model->id, $model->getShopTableCatalogID(),
                        $filters, $modelType->getChildShopTableCatalogID('filter', $sitePageData->dataLanguageID),
                        $sitePageData, $driver));
                }

                // сохраняем список хэштегов
                $hashtags = Request_RequestParams::getParamArray('shop_table_hashtags');
                if ($hashtags !== NULL) {
                    $model->setShopTableHashtagIDsArray(Api_Shop_Table_ObjectToObject::saveToHashtags(
                        Model_Shop_File::TABLE_ID, $model->id, $model->getShopTableCatalogID(),
                        $hashtags, $modelType->getChildShopTableCatalogID('hashtag', $sitePageData->dataLanguageID),
                        $sitePageData, $driver));
                }
            }

            // сохраняем группу товаров
            $groups = Request_RequestParams::getParamArray('shop_table_groups');
            if ($groups !== NULL) {
                $model->setShopTableGroupIDsArray(Api_Shop_Table_Group::saveList(
                    Model_Shop_File::TABLE_ID, $model->id, $model->getShopTableCatalogID(),
                    $groups,
                    $sitePageData, $driver));
            }

            // подобные товары
            $similars = Request_RequestParams::getParamArray('shop_table_similars');
            if($similars !== NULL){
                $model->setShopTableSimilarIDsArray(Api_Shop_Table_Similar::saveList(
                    Model_Shop_File::TABLE_ID, $model->id, $model->getShopTableCatalogID(),
                    $similars,
                    $sitePageData, $driver));
            }

            Helpers_DB::saveDBObject($model, $sitePageData);
            $result['values'] = $model->getValues();
        }

        return array(
            'id' => $model->id,
            'type' => $type,
            'is_group' => $isGroup,
            'result' => $result,
        );
    }
}
