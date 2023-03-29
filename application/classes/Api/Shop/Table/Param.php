<?php defined('SYSPATH') or die('No direct script access.');

class Api_Shop_Table_Param  {

    /**
     * Сохранение списка товаров
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     */
    public static function saveListCollations($shopTableCatalogID, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        $paramIndex = Request_RequestParams::getParamInt('param_index');

        $model = new Model_Shop_Table_Param($paramIndex);
        $model->setDBDriver($driver);

        $shopTableParams = Request_RequestParams::getParamArray('data', array());
        foreach ($shopTableParams as &$shopTableParam) {
            $model->clear();

            $id = intval(Arr::path($shopTableParam, 'shop_table_brand_id', 0));
            if ($id > 0) {
                if (!Helpers_DB::dublicateObjectLanguage($model, $id, $sitePageData, $sitePageData->shopID)) {
                    continue;
                }
            } else {
                $model->setShopTableParamTypeID($shopTableCatalogID);
            }

            if($id < 1) {
                if (key_exists('is_public', $shopTableParam)) {
                    $model->setIsPublic($shopTableParam['is_public']);
                }
                if (key_exists('collations', $shopTableParam)) {
                    $model->addCollationsArray($shopTableParam['collations']);
                }
                if (key_exists('old_id', $shopTableParam)) {
                    $model->setOldID($shopTableParam['old_id']);
                }
                if (key_exists('name', $shopTableParam)) {
                    if (!empty($shopTableParam['name'])) {
                        $model->setName($shopTableParam['name']);

                        // определяем уникальное имя для сео
                        $model->setNameURL(Helpers_URL::getNameURL($model));
                    }
                }
                if (key_exists('text', $shopTableParam)) {
                    $model->setText($shopTableParam['text']);
                }
            }

            $options = array();
            foreach($shopTableParam as $k => $v){
                if(strpos($k, 'options.') === 0){
                    $options[str_replace('options.', '', $k)] = $v;
                }
            }
            $model->addOptionsArray($options, FALSE);

            $shopTableParam['shop_table_brand_id'] = Helpers_DB::saveDBObject($model, $sitePageData, $sitePageData->shopID);
            $shopTableParam['shop_table_brand_name'] = $model->getName();
        }

        return $shopTableParams;
    }

    /**
     * Сохранение списка товаров
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     */
    public static function saveList(SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        $paramIndex = Request_RequestParams::getParamInt('param_index');

        $model = new Model_Shop_Table_Param($paramIndex);
        $model->setDBDriver($driver);

        $shopTableParams = Request_RequestParams::getParamArray('shop_table_brands', array());
        if ($shopTableParams === NULL) {
            return FALSE;
        }

        foreach ($shopTableParams as $id => $shopTableParam) {
            $id = intval($id);
            if ($id > 0) {
                if (!Helpers_DB::dublicateObjectLanguage($model, $id, $sitePageData, $sitePageData->shopID)) {
                    continue;
                }

                if (key_exists('is_public', $shopTableParam)) {
                    $model->setIsPublic($shopTableParam['is_public']);
                }
                if (key_exists('name', $shopTableParam)) {
                    if (!empty($shopTableParam['name'])) {
                        $model->setName($shopTableParam['name']);

                        // определяем уникальное имя для сео
                        $model->setNameURL(Helpers_URL::getNameURL($model));
                    }
                }

                if (key_exists('text', $shopTableParam)) {
                    $model->setText($shopTableParam['text']);
                }

                if (key_exists('remarketing', $shopTableParam)) {
                    $model->setRemarketing($shopTableParam['remarketing']);
                }

                if (key_exists('shop_table_rubric_id', $shopTableParam)) {
                    $model->setShopTableRubricID($shopTableParam['shop_table_rubric_id']);
                }

                if (key_exists('options', $shopTableParam)) {
                    $options = $shopTableParam['options'];
                    if (is_array($options)) {
                        $model->addOptionsArray($options);
                    }
                }
                if (key_exists('collations', $shopTableParam)) {
                    $options = $shopTableParam['collations'];
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
        $paramIndex = Request_RequestParams::getParamInt('param_index');

        $id = Request_RequestParams::getParamInt('id');
        if($id < 0){
            return FALSE;
        }

        $model = new Model_Shop_Table_Param($paramIndex);
        $model->setDBDriver($driver);

        if (!Helpers_DB::getDBObject($model, $id, $sitePageData)) {
            throw new HTTP_Exception_404('Table param not found.');
        }

        if(Request_RequestParams::getParamBoolean("is_undel") === TRUE){
            $model->dbUnDelete($sitePageData->userID, 0, $sitePageData->shopID);
        }else {
            $model->dbDelete($sitePageData->userID, 0, $sitePageData->shopID);
        }
    }

    /**
     * Сохранение хэштега
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @return array - id, type, table_id, result
     * @throws HTTP_Exception_500
     */
    public static function save(SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        $paramIndex = Request_RequestParams::getParamInt('param_index');
        $model = new Model_Shop_Table_Param($paramIndex);
        $model->setDBDriver($driver);

        $id = Request_RequestParams::getParamInt('id');
        if($id > 0) {
            if (!Helpers_DB::dublicateObjectLanguage($model, $id, $sitePageData)) {
                throw new HTTP_Exception_500('Param not found.');
            }

            $type = $model->getShopTableCatalogID();
            $tableID = $model->getTableID();
        }else{
            $type = Request_RequestParams::getParamInt('type');
            $tableID = Request_RequestParams::getParamInt('table_id');

            $model->setShopTableCatalogID($type);
            $model->setTableID($tableID);
        }

        Request_RequestParams::setParamInt("shop_table_rubric_id", $model);
        Request_RequestParams::setParamBoolean('is_public', $model);
        Request_RequestParams::setParamStr('text', $model);
        Request_RequestParams::setParamStr('name', $model);
        Request_RequestParams::setParamInt("is_public", $model);
        Request_RequestParams::setParamStr('remarketing', $model);

        $isTranslate = Request_RequestParams::getParamBoolean('is_translate');
        if($isTranslate !== NULL) {
            $model->setIsTranslatesCurrentLanguage($isTranslate, $sitePageData->dataLanguageID, $sitePageData->shop->getLanguageIDsArray());
        }

        // дополнительные поля
        $tmp = Request_RequestParams::getParamArray('options');
        if (($tmp !== NULL)) {
            $model->addOptionsArray($tmp, TRUE);
        }

        // seo
        $tmp = Request_RequestParams::getParamArray('seo');
        if (($tmp !== NULL)) {
            $model->setSEOArray($tmp, $sitePageData->dataLanguageID);
        }

        // определяем уникальное имя для сео
        $model->setNameURL(Helpers_URL::getNameURL($model));

        $result = array();
        if ($model->validationFields($result)) {
            if($model->id < 1) {
                Helpers_DB::saveDBObject($model, $sitePageData);
            }

            // загружаем фотографии
            $file = new Model_File($sitePageData);
            $file->saveFiles(Request_RequestParams::getParamArray('files'), $model, $sitePageData, $driver);

            Helpers_DB::saveDBObject($model, $sitePageData);
            $result['values'] = $model->getValues();
        }

        return array(
            'id' => $model->id,
            'type' => $type,
            'table_id' => $tableID,
            'param_index' => $paramIndex,
            'result' => $result,
        );
    }
}
