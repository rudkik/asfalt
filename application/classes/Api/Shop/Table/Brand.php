<?php defined('SYSPATH') or die('No direct script access.');

class Api_Shop_Table_Brand  {

    /**
     * Сохранение списка товаров
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     */
    public static function saveListCollations($shopTableCatalogID, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        $model = new Model_Shop_Table_Brand();
        $model->setDBDriver($driver);

        $shopTableBrands = Request_RequestParams::getParamArray('data', array());
        foreach ($shopTableBrands as &$shopTableBrand) {
            $model->clear();

            $id = intval(Arr::path($shopTableBrand, 'shop_table_brand_id', 0));
            if ($id > 0) {
                if (!Helpers_DB::dublicateObjectLanguage($model, $id, $sitePageData, $sitePageData->shopID)) {
                    continue;
                }
            } else {
                $model->setShopTableBrandTypeID($shopTableCatalogID);
            }

            if($id < 1) {
                if (key_exists('is_public', $shopTableBrand)) {
                    $model->setIsPublic($shopTableBrand['is_public']);
                }
                if (key_exists('collations', $shopTableBrand)) {
                    $model->addCollationsArray($shopTableBrand['collations']);
                }
                if (key_exists('old_id', $shopTableBrand)) {
                    $model->setOldID($shopTableBrand['old_id']);
                }
                if (key_exists('name', $shopTableBrand)) {
                    if (!empty($shopTableBrand['name'])) {
                        $model->setName($shopTableBrand['name']);

                        // определяем уникальное имя для сео
                        $model->setNameURL(Helpers_URL::getNameURL($model));
                    }
                }
                if (key_exists('text', $shopTableBrand)) {
                    $model->setText($shopTableBrand['text']);
                }
            }

            $options = array();
            foreach($shopTableBrand as $k => $v){
                if(strpos($k, 'options.') === 0){
                    $options[str_replace('options.', '', $k)] = $v;
                }
            }
            $model->addOptionsArray($options, FALSE);

            $shopTableBrand['shop_table_brand_id'] = Helpers_DB::saveDBObject($model, $sitePageData, $sitePageData->shopID);
            $shopTableBrand['shop_table_brand_name'] = $model->getName();
        }

        return $shopTableBrands;
    }

    /**
     * Сохранение списка товаров
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     */
    public static function saveList(SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        $model = new Model_Shop_Table_Brand();
        $model->setDBDriver($driver);

        $shopTableBrands = Request_RequestParams::getParamArray('shop_table_brands', array());
        if ($shopTableBrands === NULL) {
            return FALSE;
        }

        foreach ($shopTableBrands as $id => $shopTableBrand) {
            $id = intval($id);
            if ($id > 0) {
                if (!Helpers_DB::dublicateObjectLanguage($model, $id, $sitePageData, $sitePageData->shopID)) {
                    continue;
                }

                if (key_exists('is_public', $shopTableBrand)) {
                    $model->setIsPublic($shopTableBrand['is_public']);
                }
                if (key_exists('name', $shopTableBrand)) {
                    if (!empty($shopTableBrand['name'])) {
                        $model->setName($shopTableBrand['name']);

                        // определяем уникальное имя для сео
                        $model->setNameURL(Helpers_URL::getNameURL($model));
                    }
                }

                if (key_exists('text', $shopTableBrand)) {
                    $model->setText($shopTableBrand['text']);
                }

                if (key_exists('remarketing', $shopTableBrand)) {
                    $model->setRemarketing($shopTableBrand['remarketing']);
                }

                if (key_exists('shop_table_rubric_id', $shopTableBrand)) {
                    $model->setShopTableRubricID($shopTableBrand['shop_table_rubric_id']);
                }

                if (key_exists('options', $shopTableBrand)) {
                    $options = $shopTableBrand['options'];
                    if (is_array($options)) {
                        $model->addOptionsArray($options);
                    }
                }
                if (key_exists('collations', $shopTableBrand)) {
                    $options = $shopTableBrand['collations'];
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
        $model = new Model_Shop_Table_Brand();
        $model->setDBDriver($driver);

        $id = Request_RequestParams::getParamInt('id');
        if($id > 0) {
            if (!Helpers_DB::dublicateObjectLanguage($model, $id, $sitePageData)) {
                throw new HTTP_Exception_500('Brand not found.');
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

            $model = new Model_Shop_Table_Brand();
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
                    $ids = Request_Request::find('DB_Shop_Table_Brand',$sitePageData->shopID, $sitePageData, $driver,
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
