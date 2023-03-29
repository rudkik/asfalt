<?php defined('SYSPATH') or die('No direct script access.');

class Api_Shop_Table_Rubric  {

    /**
     * Сохранение списка товаров
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     */
    public static function saveListCollations($shopTableRubricTypeID, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        $model = new Model_Shop_Table_Rubric();
        $model->setDBDriver($driver);

        $shopTableRubrics = Request_RequestParams::getParamArray('data', array());
        foreach ($shopTableRubrics as &$shopTableRubric) {
            $model->clear();

            $id = intval(Arr::path($shopTableRubric, 'shop_table_rubric_id', 0));
            if ($id > 0) {
                if (!Helpers_DB::dublicateObjectLanguage($model, $id, $sitePageData, $sitePageData->shopID)) {
                    continue;
                }
            } else {
                $model->setShopTableRubricTypeID($shopTableRubricTypeID);
            }

            if($id < 1) {
                if (key_exists('is_public', $shopTableRubric)) {
                    $model->setIsPublic($shopTableRubric['is_public']);
                }
                if (key_exists('collations', $shopTableRubric)) {
                    $model->addCollationsArray($shopTableRubric['collations']);
                }
                if (key_exists('old_id', $shopTableRubric)) {
                    $model->setOldID($shopTableRubric['old_id']);
                }
                if (key_exists('name', $shopTableRubric)) {
                    if (!empty($shopTableRubric['name'])) {
                        $model->setName($shopTableRubric['name']);
                    }
                }
                if (key_exists('text', $shopTableRubric)) {
                    $model->setText($shopTableRubric['text']);
                }
            }

            $options = array();
            foreach($shopTableRubric as $k => $v){
                if(strpos($k, 'options.') === 0){
                    $options[str_replace('options.', '', $k)] = $v;
                }
            }
            $model->addOptionsArray($options, FALSE);

            // определяем уникальное имя для сео
            $model->setNameURL(Helpers_URL::getNameURL($model));

            $shopTableRubric['shop_table_rubric_id'] = Helpers_DB::saveDBObject($model, $sitePageData, $sitePageData->shopID);
            $shopTableRubric['shop_table_rubric_name'] = $model->getName();
        }

        return $shopTableRubrics;
    }

    /**
     * Сохранение списка товаров
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     */
    public static function saveList(SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        $model = new Model_Shop_Table_Rubric();
        $model->setDBDriver($driver);

        $shopTableRubrics = Request_RequestParams::getParamArray('shop_table_rubrics', array());
        if ($shopTableRubrics === NULL) {
            return FALSE;
        }

        foreach ($shopTableRubrics as $id => $shopTableRubric) {
            $id = intval($id);
            if ($id > 0) {
                if (!Helpers_DB::dublicateObjectLanguage($model, $id, $sitePageData, $sitePageData->shopID)) {
                    continue;
                }

                if (key_exists('is_public', $shopTableRubric)) {
                    $model->setIsPublic($shopTableRubric['is_public']);
                }
                if (key_exists('name', $shopTableRubric)) {
                    if (!empty($shopTableRubric['name'])) {
                        $model->setName($shopTableRubric['name']);
                    }
                }

                if (key_exists('text', $shopTableRubric)) {
                    $model->setText($shopTableRubric['text']);
                }

                if (key_exists('remarketing', $shopTableRubric)) {
                    $model->setRemarketing($shopTableRubric['remarketing']);
                }

                if (key_exists('shop_table_rubric_id', $shopTableRubric)) {
                    $model->setShopTableRubricID($shopTableRubric['shop_table_rubric_id']);
                }

                if (key_exists('options', $shopTableRubric)) {
                    $options = $shopTableRubric['options'];
                    if (is_array($options)) {
                        $model->addOptionsArray($options);
                    }
                }
                if (key_exists('collations', $shopTableRubric)) {
                    $options = $shopTableRubric['collations'];
                    if (!is_array($options)) {
                        $options = explode("\r\n", $options);
                    }
                    $model->addCollationsArray($options);
                }
                // определяем уникальное имя для сео
                $model->setNameURL(Helpers_URL::getNameURL($model));

                Helpers_DB::saveDBObject($model, $sitePageData, $sitePageData->shopID);
            }
        }
    }

    /**
     * Сохранить рубрику в товар определенного языка
     * @param $id
     * @param $languageID
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @param int $shopGoodID
     * @return int
     */
    public static function saveInGoodLanguage($id, $languageID, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver,
                                              $shopGoodID = -1)
    {
        $model = new Model_Shop_Table_Rubric();
        $model->setDBDriver($driver);

        if ((!Helpers_DB::getDBObject($model, $id, $sitePageData, -1, $languageID))
            || ($model->languageID != $languageID)){
            return 0;
        }

        $modelGood = new Model_Shop_Good();
        $modelGood->setDBDriver($driver);

        $tmp = $sitePageData->dataLanguageID;
        $sitePageData->dataLanguageID = $languageID;
        try {
            if($shopGoodID > 0) {
                Helpers_DB::dublicateObjectLanguage($modelGood, $shopGoodID, $sitePageData);
            }

            $modelGood->setName($model->getName());
            $modelGood->setShopTableRubricID($model->getRootID());
            $modelGood->setShopTableSelectID($model->getShopTableSelectID());
            $modelGood->setShopTableCatalogID($model->getShopTableCatalogID());
            $modelGood->setShopTableBrandID($model->getShopTableBrandID());
            $modelGood->setShopTableUnitID($model->getShopTableUnitID());
            $modelGood->setText($model->getText());
            $modelGood->setOptions($model->getOptions());
            $modelGood->setIsTranslates($model->getIsTranslates());
            $modelGood->setIsPublic($model->getIsPublic());
            $modelGood->setNameURL($model->getNameURL());
            $modelGood->setImagePath($model->getImagePath());
            $modelGood->setFiles($model->getFiles());
            $modelGood->setSEO($model->getSEO());
            $modelGood->setCreatedAt($model->getCreatedAt());
            $modelGood->setUpdatedAt($model->getUpdatedAt());
            $modelGood->setUpdateUserID($model->getUpdateUserID());
            $modelGood->setCreateUserID($model->getCreateUserID());

            Helpers_DB::saveDBObject($modelGood, $sitePageData);
        }finally{
            $sitePageData->dataLanguageID = $tmp;
        }

        return $modelGood->id;
    }

    /**
     * Сохранить рубрику в товар всех языков
     * @param $id
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @return int
     * @throws HTTP_Exception_500
     */
    public static function saveInGood($id, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        $shopGoodID = 0;
        foreach ($sitePageData->shopMain->getLanguageIDsArray() as $languageID){
            $tmp = self::saveInGoodLanguage($id, $languageID, $sitePageData, $driver, $shopGoodID);
            if ($tmp > 0){
                $shopGoodID = $tmp;
            }
        }

        if ($shopGoodID < 1) {
            throw new HTTP_Exception_500('Rubric not found.');
        }

        return $shopGoodID;
    }


    /**
     * Сохранение
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @return array - id, type, table_id, result
     * @throws HTTP_Exception_500
     */
    public static function save(SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        $model = new Model_Shop_Table_Rubric();
        $model->setDBDriver($driver);

        $id = Request_RequestParams::getParamInt('id');
        if($id > 0) {
            if (!Helpers_DB::dublicateObjectLanguage($model, $id, $sitePageData)) {
                throw new HTTP_Exception_500('Rubric not found.');
            }

            $type = $model->getShopTableCatalogID();
            $tableID = $model->getTableID();
        }else{
            $type = Request_RequestParams::getParamInt('type');
            $tableID = Request_RequestParams::getParamInt('table_id');

            $model->setShopTableCatalogID($type);
            $model->setTableID($tableID);
        }

        Request_RequestParams::setParamInt("root_id", $model);
        Request_RequestParams::setParamBoolean('is_public', $model);
        Request_RequestParams::setParamStr('text', $model);
        Request_RequestParams::setParamStr('name', $model);
        Request_RequestParams::setParamStr('remarketing', $model);
        Request_RequestParams::setParamInt("shop_table_select_id", $model);
        Request_RequestParams::setParamInt("shop_table_unit_id", $model);
        Request_RequestParams::setParamInt("shop_table_brand_id", $model);

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
        $nameURL = $model->getNameURL();
        $model->setNameURL(Helpers_URL::getNameURL($model));
        if ((! $model->getIsDelete()) && ($nameURL != $model->getNameURL())){
            Helpers_DB::replaceSubNameURL($nameURL, $model->getNameURL(), $driver, $sitePageData->shopID, $sitePageData->dataLanguageID);
        }

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

            $model = new Model_Shop_Table_Rubric();
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
                    $ids = Request_Request::find('DB_Shop_Table_Rubric', $sitePageData->shopID, $sitePageData, $driver,
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
