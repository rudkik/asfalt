<?php defined('SYSPATH') or die('No direct script access.');

class Api_Shop_Car  {
    /**
     * Сохранение товары
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @throws HTTP_Exception_500
     */
    public static function saveXLS(SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        $path = APPPATH.'views'.DIRECTORY_SEPARATOR.'cabinet'.DIRECTORY_SEPARATOR. $sitePageData->dataLanguageID.DIRECTORY_SEPARATOR
            .'_shop'.DIRECTORY_SEPARATOR .'car'.DIRECTORY_SEPARATOR.'xls'.DIRECTORY_SEPARATOR;

        $fileName = Request_RequestParams::getParamStr('file');
        if (empty($fileName) || (!file_exists($path.$fileName))){
            throw new HTTP_Exception_404('File not found.');
        }

        $info = pathinfo($fileName);
        $options = require $path.$info['filename'] . '.php';

        ob_end_clean();
        require_once APPPATH.'vendor'.DIRECTORY_SEPARATOR.'excel'.DIRECTORY_SEPARATOR.'PHPExcel.php';

        $objPHPExcel = PHPExcel_IOFactory::load($path.$fileName);
        $sheet = $objPHPExcel->getActiveSheet();

        $shopCarIDs = Request_Shop_Car::find($sitePageData->shopID, $sitePageData, $driver,
            array('is_public_ignore' => TRUE), intval(Request_RequestParams::getParamInt('limit')), TRUE);

        $row = $options['row'];
        foreach ($shopCarIDs->childs as $shopCarID){
            if (empty($shopCarID->values['uuid'])) {
                $model = new Model_Shop_Car();
                $model->setDBDriver($driver);
                Helpers_DB::getDBObject($model, $shopCarID->id, $sitePageData);
                $model->setUUID($model->_GUID());
                Helpers_DB::saveDBObject($model, $sitePageData);
            }

            foreach ($options['fields'] as $column => $field){
                $fieldName = Arr::path($field, 'field', '');

                if (empty($fieldName)){
                    $value = Arr::path($field, 'value_default', '');
                }else{
                    $value = Arr::path($shopCarID->values, $fieldName, Arr::path($field, 'value_default', ''));
                }

                $sheet->getCellByColumnAndRow($column - 1, $row)->setValue($value);
            }

            $row++;
        }

        header('Content-Type: application/x-download;charset=UTF-8');
        header("Content-Disposition: attachment; filename*=UTF-8''".rawurlencode($fileName));
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save('php://output');
    }

    /**
     * Сохранение списка товаров
     * @param $shopTableCatalogID
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @return mixed|null
     */
    public static function saveListCollations($shopTableCatalogID, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        $model = new Model_Shop_Car();
        $model->setDBDriver($driver);

        $shopCars = Request_RequestParams::getParamArray('data', array());
        foreach ($shopCars as &$shopCar) {
            $model->clear();

            $id = intval(Arr::path($shopCar, 'shop_car_id', 0));
            if ($id > 0) {
                if (!Helpers_DB::dublicateObjectLanguage($model, $id, $sitePageData, $sitePageData->shopID)) {
                    continue;
                }
            } else {
                $model->setShopTableCatalogID($shopTableCatalogID);
            }

            if($id < 1) {
                if (key_exists('is_public', $shopCar)) {
                    $model->setIsPublic($shopCar['is_public']);
                }
                if (key_exists('collations', $shopCar)) {
                    $model->addCollationsArray($shopCar['collations']);
                }
                if (key_exists('old_id', $shopCar)) {
                    $model->setOldID($shopCar['old_id']);
                }
                if (key_exists('article', $shopCar)) {
                    $model->setArticle($shopCar['article']);
                }
                if (key_exists('name', $shopCar)) {
                    if (!empty($shopCar['name'])) {
                        $model->setName($shopCar['name']);

                        $model->setNameURL(Helpers_URL::getNameURL($model));
                    }
                }
                if (key_exists('price_old', $shopCar)) {
                    $model->setPriceOld($shopCar['price_old']);
                }
                if (key_exists('text', $shopCar)) {
                    $model->setText($shopCar['text']);
                }
            }

            $options = array();
            foreach($shopCar as $k => $v){
                if(strpos($k, 'options.') === 0){
                    $options[str_replace('options.', '', $k)] = $v;
                }
            }
            $model->addOptionsArray($options, FALSE);

            $model->setNameURL(Helpers_URL::getNameURL($model));

            if (key_exists('price', $shopCar)) {
                $model->setPrice($shopCar['price']);
            }
            if (key_exists('price_cost', $shopCar)) {
                $model->setPriceCost($shopCar['price_cost']);
            }

            $shopCar['shop_car_id'] = Helpers_DB::saveDBObject($model, $sitePageData, $sitePageData->shopID);
            $shopCar['shop_car_name'] = $model->getName();
        }

        return $shopCars;
    }

    /**
     * Сохранение списка товаров
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     */
    public static function saveList(SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        $model = new Model_Shop_Car();
        $model->setDBDriver($driver);

        $shopCars = Request_RequestParams::getParamArray('shop_cars', array());
        if ($shopCars === NULL) {
            return FALSE;
        }

        foreach ($shopCars as $id => $shopCar) {
            $id = intval($id);
            if ($id > 0) {
                if (!Helpers_DB::dublicateObjectLanguage($model, $id, $sitePageData, $sitePageData->shopID)) {
                    continue;
                }

                if (key_exists('is_public', $shopCar)) {
                    $model->setIsPublic($shopCar['is_public']);
                }
                if (key_exists('name', $shopCar)) {
                    if (!empty($shopCar['name'])) {
                        $model->setName($shopCar['name']);
                    }
                }

                if (key_exists('text', $shopCar)) {
                    $model->setText($shopCar['text']);
                }

                if (key_exists('article', $shopCar)) {
                    $model->setArticle($shopCar['article']);
                }

                if (key_exists('remarketing', $shopCar)) {
                    $model->setRemarketing($shopCar['remarketing']);
                }

                if (key_exists('shop_table_rubric_id', $shopCar)) {
                    $model->setShopTableRubricID($shopCar['shop_table_rubric_id']);
                }

                if (key_exists('price_old', $shopCar)) {
                    $model->setPriceOld($shopCar['price_old']);
                }

                if (key_exists('options', $shopCar)) {
                    $options = $shopCar['options'];
                    if (is_array($options)) {
                        $model->addOptionsArray($options);
                    }
                }
                if (key_exists('collations', $shopCar)) {
                    $options = $shopCar['collations'];
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

        $model = new Model_Shop_Car();
        $model->setDBDriver($driver);

        if (!Helpers_DB::dublicateObjectLanguage($model, $id, $sitePageData)) {
            throw new HTTP_Exception_404('Car not found.');
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
        $model = new Model_Shop_Car();
        $model->setDBDriver($driver);

        $id = Request_RequestParams::getParamInt('id');
        if($id > 0) {
            if (!Helpers_DB::dublicateObjectLanguage($model, $id, $sitePageData)) {
                throw new HTTP_Exception_500('Car not found.');
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
        Request_RequestParams::setParamStr("article", $model);
        Request_RequestParams::setParamFloat("price_old", $model);
        Request_RequestParams::setParamFloat("price", $model);
        Request_RequestParams::setParamFloat("discount", $model);
        Request_RequestParams::setParamBoolean("is_percent", $model);
        Request_RequestParams::setParamInt("order", $model);
        Request_RequestParams::setParamBoolean("is_group", $model);
        Request_RequestParams::setParamStr("old_id", $model);
        Request_RequestParams::setParamStr('remarketing', $model);
        Request_RequestParams::setParamInt("shop_mark_id", $model);
        Request_RequestParams::setParamInt("shop_model_id", $model);
        Request_RequestParams::setParamInt("production_land_id", $model);
        Request_RequestParams::setParamInt("location_land_id", $model);
        Request_RequestParams::setParamInt("location_city_id", $model);
        Request_RequestParams::setParamInt("currency_id", $model);

        for ($i = 1; $i <= Model_Shop_Table_Param::PARAMS_COUNT; $i++){
            Request_RequestParams::setParamInt('shop_table_param_'.$i.'_id', $model);
            Request_RequestParams::setParamInt('param_'.$i.'_int', $model);
            Request_RequestParams::setParamFloat('param_'.$i.'_float', $model);
            Request_RequestParams::setParamStr('param_'.$i.'_str', $model);
        }

        $isTranslate = Request_RequestParams::getParamBoolean('is_translate');
        if($isTranslate !== NULL) {
            $model->setIsTranslatesCurrentLanguage($isTranslate, $sitePageData->dataLanguageID, $sitePageData->shop->getLanguageIDsArray());
        }

        $name = $model->getName();
        $shopMark = $model->getElement('shop_mark_id', TRUE);
        if ($shopMark !== NULL){
            $name = trim($name . ' ' . $shopMark->getName());
        }
        $shopModel = $model->getElement('shop_model_id', TRUE);
        if ($shopModel !== NULL){
            $name = trim($name . ' '. $shopModel->getName());
        }
        $model->setNameTotal($name);

        // определяем уникальное имя для сео
        $model->setNameURL(Helpers_URL::getNameURL($model));

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

            // загружаем дополнительные поля
            $options = Request_RequestParams::getParamArray('options');
            $files = Helpers_Image::getChildrenFILES('options');
            if ((!empty($files)) && ($options === NULL)){
                $options = array();
            }
            foreach ($files as $key => $child) {
                if ($child['error'] == 0) {
                    $options[$key] = array(
                        'file' => $file->saveDownloadFilePath($child, $model->id, Model_Shop_Car::TABLE_ID, $sitePageData),
                        'name' => $child['name'],
                        'size' => $child['size'],
                    );
                }
            }
            if ($options !== NULL) {
                $model->addOptionsArray($options);
            }

            if($type > 0) {
                $modelType = new Model_Shop_Table_Catalog();
                $modelType->setDBDriver($driver);
                Helpers_DB::dublicateObjectLanguage($modelType, $type, $sitePageData, $sitePageData->shopMainID);

                // сохраняем список фильтров
                $filters = Request_RequestParams::getParamArray('shop_table_filters');
                if ($filters !== NULL) {
                    $model->setShopTableFilterIDsArray(Api_Shop_Table_ObjectToObject::saveToFilters(
                        Model_Shop_Car::TABLE_ID, $model->id, $model->getShopTableCatalogID(),
                        $filters, $modelType->getChildShopTableCatalogID('filter', $sitePageData->languageID),
                        $sitePageData, $driver));
                }

                // сохраняем список хэштегов
                $hashtags = Request_RequestParams::getParamArray('shop_table_hashtags');
                if ($hashtags !== NULL) {
                    $model->setShopTableHashtagIDsArray(Api_Shop_Table_ObjectToObject::saveToHashtags(
                        Model_Shop_Car::TABLE_ID, $model->id, $model->getShopTableCatalogID(),
                        $hashtags, $modelType->getChildShopTableCatalogID('hashtag', $sitePageData->languageID),
                        $sitePageData, $driver));
                }
            }

            // определяем уникальное имя для сео
            $model->setNameURL(Helpers_URL::getNameURL($model));

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
