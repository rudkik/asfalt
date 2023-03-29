<?php defined('SYSPATH') or die('No direct script access.');

class Api_Shop_Mark  {
    /**
     * Сохранение в EXCEL
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @throws HTTP_Exception_404
     */
    public static function saveXLS(SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        $path = APPPATH.'views'.DIRECTORY_SEPARATOR.'cabinet'.DIRECTORY_SEPARATOR. $sitePageData->dataLanguageID.DIRECTORY_SEPARATOR
            .'_shop'.DIRECTORY_SEPARATOR .'mark'.DIRECTORY_SEPARATOR.'xls'.DIRECTORY_SEPARATOR;

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

        $shopMarkIDs = Request_Request::find('DB_Shop_Mark', $sitePageData->shopID, $sitePageData, $driver,
            array('is_public_ignore' => TRUE), intval(Request_RequestParams::getParamInt('limit')), TRUE);

        $row = $options['row'];
        foreach ($shopMarkIDs->childs as $shopMarkID){
            if (empty($shopMarkID->values['uuid'])) {
                $model = new Model_Shop_Mark();
                $model->setDBDriver($driver);
                Helpers_DB::getDBObject($model, $shopMarkID->id, $sitePageData);
                $model->setUUID($model->_GUID());
                Helpers_DB::saveDBObject($model, $sitePageData);
            }

            foreach ($options['fields'] as $column => $field){
                $fieldName = Arr::path($field, 'field', '');

                if (empty($fieldName)){
                    $value = Arr::path($field, 'value_default', '');
                }else{
                    $value = Arr::path($shopMarkID->values, $fieldName, Arr::path($field, 'value_default', ''));
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
        $model = new Model_Shop_Mark();
        $model->setDBDriver($driver);

        $shopMarks = Request_RequestParams::getParamArray('data', array());
        foreach ($shopMarks as &$shopMark) {
            $model->clear();

            $id = intval(Arr::path($shopMark, 'shop_mark_id', 0));
            if ($id > 0) {
                if (!Helpers_DB::dublicateObjectLanguage($model, $id, $sitePageData, $sitePageData->shopID)) {
                    continue;
                }
            } else {
                $model->setShopTableCatalogID($shopTableCatalogID);
            }

            if($id < 1) {
                if (key_exists('is_public', $shopMark)) {
                    $model->setIsPublic($shopMark['is_public']);
                }
                if (key_exists('collations', $shopMark)) {
                    $model->addCollationsArray($shopMark['collations']);
                }
                if (key_exists('old_id', $shopMark)) {
                    $model->setOldID($shopMark['old_id']);
                }
                if (key_exists('name', $shopMark)) {
                    if (!empty($shopMark['name'])) {
                        $model->setName($shopMark['name']);

                        // определяем уникальное имя для сео
                        $nameURL = $model->getNameURL();
                        $model->setNameURL(Helpers_URL::getNameURL($model));
                        if ((! $model->getIsDelete()) && ($nameURL != $model->getNameURL())){
                            Helpers_DB::replaceSubNameURL($nameURL, $model->getNameURL(), $driver, $sitePageData->shopID, $sitePageData->dataLanguageID);
                        }
                    }
                }
                if (key_exists('text', $shopMark)) {
                    $model->setText($shopMark['text']);
                }
            }

            $options = array();
            foreach($shopMark as $k => $v){
                if(strpos($k, 'options.') === 0){
                    $options[str_replace('options.', '', $k)] = $v;
                }
            }
            $model->addOptionsArray($options, FALSE);

            $shopMark['shop_mark_id'] = Helpers_DB::saveDBObject($model, $sitePageData, $sitePageData->shopID);
            $shopMark['shop_mark_name'] = $model->getName();
        }

        return $shopMarks;
    }

    /**
     * Сохранение списка товаров
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     */
    public static function saveList(SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        $model = new Model_Shop_Mark();
        $model->setDBDriver($driver);

        $shopMarks = Request_RequestParams::getParamArray('shop_marks', array());
        if ($shopMarks === NULL) {
            return FALSE;
        }

        foreach ($shopMarks as $id => $shopMark) {
            $id = intval($id);
            if ($id > 0) {
                if (!Helpers_DB::dublicateObjectLanguage($model, $id, $sitePageData, $sitePageData->shopID)) {
                    continue;
                }

                if (key_exists('is_public', $shopMark)) {
                    $model->setIsPublic($shopMark['is_public']);
                }
                if (key_exists('name', $shopMark)) {
                    if (!empty($shopMark['name'])) {
                        $model->setName($shopMark['name']);
                    }

                    // определяем уникальное имя для сео
                    $nameURL = $model->getNameURL();
                    $model->setNameURL(Helpers_URL::getNameURL($model));
                    if ((! $model->getIsDelete()) && ($nameURL != $model->getNameURL())){
                        Helpers_DB::replaceSubNameURL($nameURL, $model->getNameURL(), $driver, $sitePageData->shopID, $sitePageData->dataLanguageID);
                    }
                }

                if (key_exists('text', $shopMark)) {
                    $model->setText($shopMark['text']);
                }
                if (key_exists('remarketing', $shopMark)) {
                    $model->setRemarketing($shopMark['remarketing']);
                }
                if (key_exists('shop_table_rubric_id', $shopMark)) {
                    $model->setShopTableRubricID($shopMark['shop_table_rubric_id']);
                }
                if (key_exists('options', $shopMark)) {
                    $options = $shopMark['options'];
                    if (is_array($options)) {
                        $model->addOptionsArray($options);
                    }
                }
                if (key_exists('collations', $shopMark)) {
                    $options = $shopMark['collations'];
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

        $model = new Model_Shop_Mark();
        $model->setDBDriver($driver);

        if (!Helpers_DB::dublicateObjectLanguage($model, $id, $sitePageData)) {
            throw new HTTP_Exception_404('Mark not found.');
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
        $model = new Model_Shop_Mark();
        $model->setDBDriver($driver);

        $id = Request_RequestParams::getParamInt('id');
        if($id > 0) {
            if (!Helpers_DB::dublicateObjectLanguage($model, $id, $sitePageData)) {
                throw new HTTP_Exception_500('Mark not found.');
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
        Request_RequestParams::setParamInt("order", $model);
        Request_RequestParams::setParamStr("old_id", $model);
        Request_RequestParams::setParamStr('remarketing', $model);
        Request_RequestParams::setParamInt("shop_table_param1_id", $model);
        Request_RequestParams::setParamInt("shop_table_param2_id", $model);
        Request_RequestParams::setParamInt("shop_table_param3_id", $model);

        $isTranslate = Request_RequestParams::getParamBoolean('is_translate');
        if($isTranslate !== NULL) {
            $model->setIsTranslatesCurrentLanguage($isTranslate, $sitePageData->dataLanguageID, $sitePageData->shop->getLanguageIDsArray());
        }

        // определяем уникальное имя для сео
        $nameURL = $model->getNameURL();
        $model->setNameURL(Helpers_URL::getNameURL($model));
        if ((! $model->getIsDelete()) && ($nameURL != $model->getNameURL())){
            Helpers_DB::replaceSubNameURL($nameURL, $model->getNameURL(), $driver, $sitePageData->shopID, $sitePageData->dataLanguageID);
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

            // загружаем дополнительные поля
            $options = Request_RequestParams::getParamArray('options');
            $files = Helpers_Image::getChildrenFILES('options');
            if ((!empty($files)) && ($options === NULL)){
                $options = array();
            }
            foreach ($files as $key => $child) {
                if ($child['error'] == 0) {
                    $options[$key] = array(
                        'file' => $file->saveDownloadFilePath($child, $model->id, Model_Shop_Mark::TABLE_ID, $sitePageData),
                        'name' => $child['name'],
                        'size' => $child['size'],
                    );
                }
            }
            if ($options !== NULL) {
                $model->addOptionsArray($options);
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
