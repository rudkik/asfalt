<?php defined('SYSPATH') or die('No direct script access.');

class Api_Shop_Model  {
    /**
     * Сохранение товары
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @throws HTTP_Exception_500
     */
    public static function saveXLS(SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        $path = APPPATH.'views'.DIRECTORY_SEPARATOR.'cabinet'.DIRECTORY_SEPARATOR. $sitePageData->dataLanguageID.DIRECTORY_SEPARATOR
            .'_shop'.DIRECTORY_SEPARATOR .'model'.DIRECTORY_SEPARATOR.'xls'.DIRECTORY_SEPARATOR;

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

        $shopModelIDs = Request_Request::find('DB_Shop_Model', $sitePageData->shopID, $sitePageData, $driver,
            array('is_public_ignore' => TRUE), intval(Request_RequestParams::getParamInt('limit')), TRUE);

        $row = $options['row'];
        foreach ($shopModelIDs->childs as $shopModelID){
            if (empty($shopModelID->values['uuid'])) {
                $model = new Model_Shop_Model();
                $model->setDBDriver($driver);
                Helpers_DB::getDBObject($model, $shopModelID->id, $sitePageData);
                $model->setUUID($model->_GUID());
                Helpers_DB::saveDBObject($model, $sitePageData);
            }

            foreach ($options['fields'] as $column => $field){
                $fieldName = Arr::path($field, 'field', '');

                if (empty($fieldName)){
                    $value = Arr::path($field, 'value_default', '');
                }else{
                    $value = Arr::path($shopModelID->values, $fieldName, Arr::path($field, 'value_default', ''));
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
        $model = new Model_Shop_Model();
        $model->setDBDriver($driver);

        $shopModels = Request_RequestParams::getParamArray('data', array());
        foreach ($shopModels as &$shopModel) {
            $model->clear();

            $id = intval(Arr::path($shopModel, 'shop_model_id', 0));
            if ($id > 0) {
                if (!Helpers_DB::dublicateObjectLanguage($model, $id, $sitePageData, $sitePageData->shopID)) {
                    continue;
                }
            } else {
                $model->setShopTableCatalogID($shopTableCatalogID);
            }

            if($id < 1) {
                if (key_exists('is_public', $shopModel)) {
                    $model->setIsPublic($shopModel['is_public']);
                }
                if (key_exists('collations', $shopModel)) {
                    $model->addCollationsArray($shopModel['collations']);
                }
                if (key_exists('old_id', $shopModel)) {
                    $model->setOldID($shopModel['old_id']);
                }
                if (key_exists('shop_mark_id', $shopModel)) {
                    $model->setOldID($shopModel['shop_mark_id']);
                }
                if (key_exists('name', $shopModel)) {
                    if (!empty($shopModel['name'])) {
                        $model->setName($shopModel['name']);
                    }
                }
                if (key_exists('text', $shopModel)) {
                    $model->setText($shopModel['text']);
                }
            }

            $options = array();
            foreach($shopModel as $k => $v){
                if(strpos($k, 'options.') === 0){
                    $options[str_replace('options.', '', $k)] = $v;
                }
            }
            $model->addOptionsArray($options, FALSE);

            $model->setNameURL(Helpers_URL::getNameURL($model));

            $shopModel['shop_model_id'] = Helpers_DB::saveDBObject($model, $sitePageData, $sitePageData->shopID);
            $shopModel['shop_model_name'] = $model->getName();
        }

        return $shopModels;
    }

    /**
     * Сохранение списка товаров
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     */
    public static function saveList(SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        $model = new Model_Shop_Model();
        $model->setDBDriver($driver);

        $shopModels = Request_RequestParams::getParamArray('shop_models', array());
        if ($shopModels === NULL) {
            return FALSE;
        }

        foreach ($shopModels as $id => $shopModel) {
            $id = intval($id);
            if ($id > 0) {
                if (!Helpers_DB::dublicateObjectLanguage($model, $id, $sitePageData, $sitePageData->shopID)) {
                    continue;
                }

                if (key_exists('is_public', $shopModel)) {
                    $model->setIsPublic($shopModel['is_public']);
                }
                if (key_exists('name', $shopModel)) {
                    if (!empty($shopModel['name'])) {
                        $model->setName($shopModel['name']);
                    }
                }

                if (key_exists('text', $shopModel)) {
                    $model->setText($shopModel['text']);
                }
                if (key_exists('remodeleting', $shopModel)) {
                    $model->setRemodeleting($shopModel['remodeleting']);
                }
                if (key_exists('shop_table_rubric_id', $shopModel)) {
                    $model->setShopTableRubricID($shopModel['shop_table_rubric_id']);
                }
                if (key_exists('shop_mark_id', $shopModel)) {
                    $model->setOldID($shopModel['shop_mark_id']);
                }
                if (key_exists('options', $shopModel)) {
                    $options = $shopModel['options'];
                    if (is_array($options)) {
                        $model->addOptionsArray($options);
                    }
                }
                if (key_exists('collations', $shopModel)) {
                    $options = $shopModel['collations'];
                    if (!is_array($options)) {
                        $options = explode("\r\n", $options);
                    }
                    $model->addCollationsArray($options);
                }

                $model->setNameURL(Helpers_URL::getNameURL($model));

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

        $model = new Model_Shop_Model();
        $model->setDBDriver($driver);

        if (!Helpers_DB::dublicateObjectLanguage($model, $id, $sitePageData)) {
            throw new HTTP_Exception_404('Model not found.');
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
        $model = new Model_Shop_Model();
        $model->setDBDriver($driver);

        $id = Request_RequestParams::getParamInt('id');
        if($id > 0) {
            if (!Helpers_DB::dublicateObjectLanguage($model, $id, $sitePageData)) {
                throw new HTTP_Exception_500('Model not found.');
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
        Request_RequestParams::setParamStr('remodeleting', $model);
        Request_RequestParams::setParamInt("shop_table_param1_id", $model);
        Request_RequestParams::setParamInt("shop_table_param2_id", $model);
        Request_RequestParams::setParamInt("shop_table_param3_id", $model);
        Request_RequestParams::setParamInt("shop_mark_id", $model);

        $isTranslate = Request_RequestParams::getParamBoolean('is_translate');
        if($isTranslate !== NULL) {
            $model->setIsTranslatesCurrentLanguage($isTranslate, $sitePageData->dataLanguageID, $sitePageData->shop->getLanguageIDsArray());
        }

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
                        'file' => $file->saveDownloadFilePath($child, $model->id, Model_Shop_Model::TABLE_ID, $sitePageData),
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
