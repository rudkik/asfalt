<?php defined('SYSPATH') or die('No direct script access.');

class Api_Shop_Table_Unit  {

    /**
     * Сохранение списка товаров
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     */
    public static function saveListCollations($shopTableUnitTypeID, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        $model = new Model_Shop_Table_Unit();
        $model->setDBDriver($driver);

        $shopTableUnits = Request_RequestParams::getParamArray('data', array());
        foreach ($shopTableUnits as &$shopTableUnit) {
            $model->clear();

            $id = intval(Arr::path($shopTableUnit, 'shop_table_unit_id', 0));
            if ($id > 0) {
                if (!Helpers_DB::dublicateObjectLanguage($model, $id, $sitePageData, $sitePageData->shopID)) {
                    continue;
                }
            } else {
                $model->setShopTableUnitTypeID($shopTableUnitTypeID);
            }

            if($id < 1) {
                if (key_exists('is_public', $shopTableUnit)) {
                    $model->setIsPublic($shopTableUnit['is_public']);
                }
                if (key_exists('collations', $shopTableUnit)) {
                    $model->addCollationsArray($shopTableUnit['collations']);
                }
                if (key_exists('old_id', $shopTableUnit)) {
                    $model->setOldID($shopTableUnit['old_id']);
                }
                if (key_exists('name', $shopTableUnit)) {
                    if (!empty($shopTableUnit['name'])) {
                        $model->setName($shopTableUnit['name']);

                        // определяем уникальное имя для сео
                        $model->setNameURL(Helpers_URL::getNameURL($model));
                    }
                }
                if (key_exists('text', $shopTableUnit)) {
                    $model->setText($shopTableUnit['text']);
                }
            }

            $options = array();
            foreach($shopTableUnit as $k => $v){
                if(strpos($k, 'options.') === 0){
                    $options[str_replace('options.', '', $k)] = $v;
                }
            }
            $model->addOptionsArray($options, FALSE);

            $shopTableUnit['shop_table_unit_id'] = Helpers_DB::saveDBObject($model, $sitePageData, $sitePageData->shopID);
            $shopTableUnit['shop_table_unit_name'] = $model->getName();
        }

        return $shopTableUnits;
    }

    /**
     * Сохранение списка товаров
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     */
    public static function saveList(SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        $model = new Model_Shop_Table_Unit();
        $model->setDBDriver($driver);

        $shopTableUnits = Request_RequestParams::getParamArray('shop_table_units', array());
        if ($shopTableUnits === NULL) {
            return FALSE;
        }

        foreach ($shopTableUnits as $id => $shopTableUnit) {
            $id = intval($id);
            if ($id > 0) {
                if (!Helpers_DB::dublicateObjectLanguage($model, $id, $sitePageData, $sitePageData->shopID)) {
                    continue;
                }

                if (key_exists('is_public', $shopTableUnit)) {
                    $model->setIsPublic($shopTableUnit['is_public']);
                }
                if (key_exists('name', $shopTableUnit)) {
                    if (!empty($shopTableUnit['name'])) {
                        $model->setName($shopTableUnit['name']);

                        // определяем уникальное имя для сео
                        $model->setNameURL(Helpers_URL::getNameURL($model));
                    }
                }

                if (key_exists('text', $shopTableUnit)) {
                    $model->setText($shopTableUnit['text']);
                }

                if (key_exists('remarketing', $shopTableUnit)) {
                    $model->setRemarketing($shopTableUnit['remarketing']);
                }

                if (key_exists('shop_table_rubric_id', $shopTableUnit)) {
                    $model->setShopTableRubricID($shopTableUnit['shop_table_rubric_id']);
                }

                if (key_exists('options', $shopTableUnit)) {
                    $options = $shopTableUnit['options'];
                    if (is_array($options)) {
                        $model->addOptionsArray($options);
                    }
                }
                if (key_exists('collations', $shopTableUnit)) {
                    $options = $shopTableUnit['collations'];
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
     * Сохранение хэштега
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @return array - id, type, table_id, result
     * @throws HTTP_Exception_500
     */
    public static function save(SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        $model = new Model_Shop_Table_Unit();
        $model->setDBDriver($driver);

        $id = Request_RequestParams::getParamInt('id');
        if($id > 0) {
            if (!Helpers_DB::dublicateObjectLanguage($model, $id, $sitePageData)) {
                throw new HTTP_Exception_500('Unit not found.');
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

            if($type > 0) {
                $modelType = new Model_Shop_Table_Catalog();
                $modelType->setDBDriver($driver);
                Helpers_DB::dublicateObjectLanguage($modelType, $type, $sitePageData, $sitePageData->shopMainID);

                // сохраняем список хэштегов
                $hashtags = Request_RequestParams::getParamArray('shop_table_hashtags');
                if ($hashtags !== NULL) {
                    $model->setShopTableHashtagIDsArray(Api_Shop_Table_ObjectToObject::saveToHashtags(
                        Model_Shop_Table_Unit::TABLE_ID, $model->id, $model->getShopTableCatalogID(),
                        $hashtags, $modelType->getChildShopTableCatalogID('hashtag', $sitePageData->languageID),
                        $sitePageData, $driver));
                }
            }

            Helpers_DB::saveDBObject($model, $sitePageData);
            $result['values'] = $model->getValues();
        }

        return array(
            'id' => $model->id,
            'type' => $type,
            'table_id' => $tableID,
            'result' => $result,
        );
    }

    /**
     * Массовое добавление изображений, если первое изображение не задано
     * поиск идет или по id или по штрихкоду
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @return array
     */
    public static function addImages(SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        ini_set('max_file_uploads', '5000');
        set_time_limit(3600);

        $isBarcode = Request_RequestParams::getParamBoolean('is_barcode');

        $result = array();
        if(key_exists('files', $_FILES)){
            // получаем список файлов в архиве
            $files = Helpers_Image::getChildrenFILES('files');

            $model = new Model_Shop_Table_Unit();
            $model->setDBDriver($driver);
            $modelFile = $file = new Model_File($sitePageData);

            foreach($files as $file){
                $old = pathinfo($file['name'], PATHINFO_FILENAME);
                $id = intval($old);
                if(($id === FALSE) || ($id < 1) || (strval($id) != $old)){
                    $result[$old] = 'not a number';
                    continue;
                }

                if($isBarcode === TRUE){
                    $ids = Request_Request::find('DB_Shop_Table_Unit', $sitePageData->shopID, $sitePageData, $driver,
                        array('options' => array('barcode' => $id), 'is_public_ignore' => TRUE, 'image_path_empty' => TRUE, Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE));

                    if(count($ids->childs) < 1){
                        $result[$old] = 'not find';
                        continue;
                    }
                    $id = $ids->childs[0]->id;
                }

                if(! Helpers_DB::getDBObject($model, $id, $sitePageData)){
                    $result[$old] = 'not find';
                    continue;
                }

                if(!Func::_empty($model->getImagePath())){
                    $result[$old] = 'not empty image '. $model->getImagePath();
                    continue;
                }

                if ($modelFile->addImageInModel($file, $model, $sitePageData, $driver)){
                    Helpers_DB::saveDBObject($model, $sitePageData);

                    $result[$old] = 'save';
                }
            }
        }

        return $result;
    }
}
