<?php defined('SYSPATH') or die('No direct script access.');

class Api_Ab1_Shop_Supplier_Contract  {
    /**
     * Сохранение в EXCEL
     * @param $fileName
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @throws HTTP_Exception_404
     */
    public static function saveContractWord($fileName, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        $path = Helpers_Path::getPathFile(
            APPPATH,  array('views', 'ab1', '_report', $sitePageData->dataLanguageID, '_word', 'contract')
        );

        if (empty($fileName) || (!file_exists($path.$fileName))){
            throw new HTTP_Exception_404('File not found.');
        }

        ob_end_clean();
        require_once APPPATH.'vendor'.DIRECTORY_SEPARATOR.'PHPWord'.DIRECTORY_SEPARATOR.'Autoloader.php';

        $phpWord = new \PhpOffice\PhpWord\PhpWord();
        $phpWord->loadTemplate($path.$fileName);


        $objReader = \PhpOffice\PhpWord\IOFactory::createReader('Word2007');
        $phpWord = $objReader->load($path.$fileName);


        Helpers_Word::replaceText($phpWord->getSections(), '{#year#}', '2019');
       // $phpWord->setValue('variableName', 'MyVariableValue');

        header('Content-Type: application/x-download;charset=UTF-8');
        header("Content-Disposition: attachment; filename*=UTF-8''".rawurlencode($fileName));
        header('Cache-Control: max-age=0');

        $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($d, 'Word2007');
        $objWriter->save('php://output');
        exit;



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

        $model = new Model_Ab1_Shop_Supplier_Contract();
        $model->setDBDriver($driver);

        if (!Helpers_DB::dublicateObjectLanguage($model, $id, $sitePageData, $sitePageData->shopMainID)) {
            throw new HTTP_Exception_500('Supplier contract not found.');
        }

        if(Request_RequestParams::getParamBoolean("is_undel") === TRUE){
            $model->dbUnDelete($sitePageData->userID, 0, $sitePageData->shopMainID);
        }else {
            $model->dbDelete($sitePageData->userID, 0, $sitePageData->shopMainID);
        }
    }

    /**
     * Сохранение
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @return array
     * @throws HTTP_Exception_500
     */
    public static function save(SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        $model = new Model_Ab1_Shop_Supplier_Contract();
        $model->setDBDriver($driver);

        $id = Request_RequestParams::getParamInt('id');
        if($id > 0) {
            if (!Helpers_DB::dublicateObjectLanguage($model, $id, $sitePageData, $sitePageData->shopMainID)) {
                throw new HTTP_Exception_500('Supplier contract not found.');
            }
        }

        Request_RequestParams::setParamBoolean('is_public', $model);
        Request_RequestParams::setParamStr('text', $model);
        Request_RequestParams::setParamStr('name', $model);
        Request_RequestParams::setParamStr("old_id", $model);
        Request_RequestParams::setParamInt("shop_supplier_id", $model);

        Request_RequestParams::setParamStr('number', $model);
        Request_RequestParams::setParamStr('name', $model);
        Request_RequestParams::setParamFloat('amount', $model);
        Request_RequestParams::setParamDateTime('from_at', $model);
        Request_RequestParams::setParamDateTime('to_at', $model);

        $options = Request_RequestParams::getParamArray('options');
        if ($options !== NULL) {
            $model->addOptionsArray($options);
        }

        $result = array();
        if ($model->validationFields($result)) {
            if($model->id < 1) {
                Helpers_DB::saveDBObject($model, $sitePageData, $sitePageData->shopMainID);
            }

            // загружаем фотографии
            $file = new Model_File($sitePageData);
            $file->saveFiles(Request_RequestParams::getParamArray('files'), $model, $sitePageData, $driver);

            $shopSupplierContractItems = Request_RequestParams::getParamArray('shop_supplier_contract_items');
            if($shopSupplierContractItems !== NULL) {
                $model->setAmount(
                    Api_Ab1_Shop_Supplier_Contract_Item::save(
                        $model->id, $model->getShopSupplierID(), $shopSupplierContractItems, $sitePageData, $driver
                    )
                );
            }

            Helpers_DB::saveDBObject($model, $sitePageData, $sitePageData->shopMainID);
            $result['values'] = $model->getValues();
        }

        return array(
            'id' => $model->id,
            'result' => $result,
        );
    }
}
