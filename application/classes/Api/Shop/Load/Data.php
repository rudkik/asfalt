<?php defined('SYSPATH') or die('No direct script access.');

class Api_Shop_Load_Data  {

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

        $model = new Model_Shop_Load_Data();
        $model->setDBDriver($driver);

        if (!Helpers_DB::dublicateObjectLanguage($model, $id, $sitePageData)) {
            throw new HTTP_Exception_404('Load data not found.');
        }

        if(Request_RequestParams::getParamBoolean("is_undel") === TRUE){
            $model->dbUnDelete($sitePageData->userID, 0, $sitePageData->shopID);
        }else {
            $model->dbDelete($sitePageData->userID, 0, $sitePageData->shopID);
        }

        // пересчитываем количество товаров на складе
        //Api_ShopTableRubric::countUpStorageShopTableRubric($model->getShopTableRubricID(), $sitePageData, $driver);

    }

    /**
     * Сохранение товары
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @throws HTTP_Exception_500
     */
    public static function save(SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        $isLoadFile = FALSE;

        $model = new Model_Shop_Load_Data();
        $model->setDBDriver($driver);

        $id = Request_RequestParams::getParamInt('id');
        if($id > 0) {
            if (!Helpers_DB::dublicateObjectLanguage($model, $id, $sitePageData)) {
                throw new HTTP_Exception_500('Load data not found.');
            }

            $type = $model->getShopTableCatalogID();
            $tableID = $model->getTableID();
        }else{
            $type = Request_RequestParams::getParamInt('type');
            $tableID = Request_RequestParams::getParamInt('table_id');

            $model->setShopTableCatalogID($type);
            $model->setTableID($tableID);
        }

        Request_RequestParams::setParamBoolean('is_public', $model);
        Request_RequestParams::setParamStr('text', $model);
        Request_RequestParams::setParamStr('name', $model);
        Request_RequestParams::setParamInt('first_row', $model);

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
                        'file' => $file->saveDownloadFilePath($child, $model->id, Model_Shop_Load_Data::TABLE_ID, $sitePageData),
                        'name' => $child['name'],
                        'size' => $child['size'],
                    );
                }
            }
            if ($options !== NULL) {
                $model->addOptionsArray($options);
            }

            if(key_exists('file', $_FILES)) {
                $data = Helpers_Excel::loadFileInData($_FILES['file']['tmp_name'], $model->getFirstRow(), $model->getOptionsArray());

                if(Request_RequestParams::getParamBoolean('is_add_data') === TRUE){
                    $model->addDataArray($data);
                }else {
                    $model->setDataArray($data);
                }
                $isLoadFile = TRUE;
            }

            Helpers_DB::saveDBObject($model, $sitePageData);
            $result['values'] = $model->getValues();
        }

        return array(
            'id' => $model->id,
            'type' => $type,
            'table_id' => $tableID,
            'result' => $result,
            'is_load_file' => $isLoadFile,
        );
    }

    /**
     * Поиск соответствий данных с БД
     * @param array $data
     * @param $shopTableCatalogID
     * @param $tableID
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @return array
     */
    public static function findCollations(array $data, $shopTableCatalogID, $tableID, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        switch ($tableID) {
            case Model_Shop_Good::TABLE_ID:
                $objects = Request_Request::find('DB_Shop_Good',$sitePageData->shopID, $sitePageData, $driver,
                    array('type' => $shopTableCatalogID, Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE), 0, TRUE);
                $field = 'shop_good_';
                break;
            default:
                return $data;
        }

        // распарсить массив соответствий
        foreach ($objects->childs as $object) {
            if (empty($object->values['collations'])) {
                $object->values['collations'] = array();
            } else {
                $object->values['collations'] = json_decode($object->values['collations'], TRUE);
            }
        }

        // сопоставление данных
        foreach ($data as &$record) {
            $collations = Arr::path($record, 'collations', '');

            $record[$field.'id'] = 0;
            foreach ($objects->childs as $key => $object) {
                if(array_search($collations, $object->values['collations']) !== FALSE){
                    $record[$field.'id'] = $object->values['id'];
                    $record[$field.'name'] = $object->values['name'];

                    unset($objects->childs[$key]);
                    break;
                }
            }
        }

        return $data;
    }

}
