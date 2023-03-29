<?php defined('SYSPATH') or die('No direct script access.');

class Api_Shop_Calendar  {

    /**
     * Сохранение списка товаров
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     */
    public static function saveListCollations($shopTableCatalogID, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        $model = new Model_Shop_Calendar();
        $model->setDBDriver($driver);

        $shopCalendars = Request_RequestParams::getParamArray('data', array());
        foreach ($shopCalendars as &$shopCalendar) {
            $model->clear();

            $id = intval(Arr::path($shopCalendar, 'shop_calendar_id', 0));
            if ($id > 0) {
                if (!Helpers_DB::dublicateObjectLanguage($model, $id, $sitePageData, $sitePageData->shopID)) {
                    continue;
                }
            } else {
                $model->setShopTableCatalogID($shopTableCatalogID);
            }

            if($id < 1) {
                if (key_exists('is_public', $shopCalendar)) {
                    $model->setIsPublic($shopCalendar['is_public']);
                }
                if (key_exists('collations', $shopCalendar)) {
                    $model->addCollationsArray($shopCalendar['collations']);
                }
                if (key_exists('old_id', $shopCalendar)) {
                    $model->setOldID($shopCalendar['old_id']);
                }
                if (key_exists('article', $shopCalendar)) {
                    $model->setArticle($shopCalendar['article']);
                }
                if (key_exists('name', $shopCalendar)) {
                    if (!empty($shopCalendar['name'])) {
                        $model->setName($shopCalendar['name']);
                    }
                }
                if (key_exists('text', $shopCalendar)) {
                    $model->setText($shopCalendar['text']);
                }
            }

            $options = array();
            foreach($shopCalendar as $k => $v){
                if(strpos($k, 'options.') === 0){
                    $options[str_replace('options.', '', $k)] = $v;
                }
            }
            $model->addOptionsArray($options, FALSE);

            if (key_exists('price', $shopCalendar)) {
                $model->setPrice($shopCalendar['price']);
            }

            $shopCalendar['shop_calendar_id'] = Helpers_DB::saveDBObject($model, $sitePageData, $sitePageData->shopID);
            $shopCalendar['shop_calendar_name'] = $model->getName();
        }

        return $shopCalendars;
    }

    /**
     * Сохранение списка товаров
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     */
    public static function saveList(SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        $model = new Model_Shop_Calendar();
        $model->setDBDriver($driver);

        $shopCalendars = Request_RequestParams::getParamArray('shop_calendars', array());
        if ($shopCalendars === NULL) {
            return FALSE;
        }

        foreach ($shopCalendars as $id => $shopCalendar) {
            $id = intval($id);
            if ($id > 0) {
                if (!Helpers_DB::dublicateObjectLanguage($model, $id, $sitePageData, $sitePageData->shopID)) {
                    continue;
                }

                if (key_exists('is_public', $shopCalendar)) {
                    $model->setIsPublic($shopCalendar['is_public']);
                }
                if (key_exists('name', $shopCalendar)) {
                    if (!empty($shopCalendar['name'])) {
                        $model->setName($shopCalendar['name']);
                    }
                }

                if (key_exists('text', $shopCalendar)) {
                    $model->setText($shopCalendar['text']);
                }

                if (key_exists('article', $shopCalendar)) {
                    $model->setArticle($shopCalendar['article']);
                }

                if (key_exists('remarketing', $shopCalendar)) {
                    $model->setRemarketing($shopCalendar['remarketing']);
                }

                if (key_exists('shop_table_rubric_id', $shopCalendar)) {
                    $model->setShopTableRubricID($shopCalendar['shop_table_rubric_id']);
                }

                if (key_exists('options', $shopCalendar)) {
                    $options = $shopCalendar['options'];
                    if (is_array($options)) {
                        $model->addOptionsArray($options);
                    }
                }
                if (key_exists('collations', $shopCalendar)) {
                    $options = $shopCalendar['collations'];
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
        $model = new Model_Shop_Calendar();
        $model->setDBDriver($driver);

        $id = Request_RequestParams::getParamInt('id');
        if($id > 0) {
            if (!Helpers_DB::dublicateObjectLanguage($model, $id, $sitePageData)) {
                throw new HTTP_Exception_500('Calendars not found.');
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

        Request_RequestParams::setParamDateTime("date_from", $model);
        Request_RequestParams::setParamDateTime("date_to", $model);

        Request_RequestParams::setParamTime("time_from", $model);
        Request_RequestParams::setParamTime("time_to", $model);
        Request_RequestParams::setParamInt("calendar_event_type_id", $model);

        $options = Request_RequestParams::getParamArray('time_options');
        if ($options !== NULL) {
            $model->addTimeOptionsArray($options);
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
                        Model_Shop_Calendar::TABLE_ID, $model->id, $model->getShopTableCatalogID(),
                        $filters, $modelType->getChildShopTableCatalogID('filter', $sitePageData->dataLanguageID),
                        $sitePageData, $driver));
                }

                // сохраняем список хэштегов
                $hashtags = Request_RequestParams::getParamArray('shop_table_hashtags');
                if ($hashtags !== NULL) {
                    $model->setShopTableHashtagIDsArray(Api_Shop_Table_ObjectToObject::saveToHashtags(
                        Model_Shop_Calendar::TABLE_ID, $model->id, $model->getShopTableCatalogID(),
                        $hashtags, $modelType->getChildShopTableCatalogID('hashtag', $sitePageData->dataLanguageID),
                        $sitePageData, $driver));
                }
            }

            // сохраняем группу товаров
            $groups = Request_RequestParams::getParamArray('shop_table_groups');
            if ($groups !== NULL) {
                $model->setShopTableGroupIDsArray(Api_Shop_Table_Group::saveList(
                    Model_Shop_Calendar::TABLE_ID, $model->id, $model->getShopTableCatalogID(),
                    $groups,
                    $sitePageData, $driver));
            }

            // подобные товары
            $similars = Request_RequestParams::getParamArray('shop_table_similars');
            if($similars !== NULL){
                $model->setShopTableSimilarIDsArray(Api_Shop_Table_Similar::saveList(
                    Model_Shop_Calendar::TABLE_ID, $model->id, $model->getShopTableCatalogID(),
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
