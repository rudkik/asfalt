<?php defined('SYSPATH') or die('No direct script access.');

class Api_Shop_Good  {
    /**
     * Сохранение товаров в Excel-файл
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @throws HTTP_Exception_404
     */
    public static function saveXLS(SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        $path = APPPATH.'views'.DIRECTORY_SEPARATOR.'cabinet'.DIRECTORY_SEPARATOR. $sitePageData->dataLanguageID.DIRECTORY_SEPARATOR
            .'_shop'.DIRECTORY_SEPARATOR .'good'.DIRECTORY_SEPARATOR.'xls'.DIRECTORY_SEPARATOR;

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

        $shopGoodIDs = Request_Request::find('DB_Shop_Good',$sitePageData->shopID, $sitePageData, $driver,
            array('is_public_ignore' => TRUE), intval(Request_RequestParams::getParamInt('limit')), TRUE);

        $row = $options['row'];
        foreach ($shopGoodIDs->childs as $shopGoodID){
            if (empty($shopGoodID->values['uuid'])) {
                $model = new Model_Shop_Good();
                $model->setDBDriver($driver);
                Helpers_DB::getDBObject($model, $shopGoodID->id, $sitePageData);
                $model->setUUID($model->_GUID());
                Helpers_DB::saveDBObject($model, $sitePageData);
            }

            foreach ($options['fields'] as $column => $field){
                $fieldName = Arr::path($field, 'field', '');

                if (empty($fieldName)){
                    $value = Arr::path($field, 'value_default', '');
                }else{
                    $value = Arr::path($shopGoodID->values, $fieldName, Arr::path($field, 'value_default', ''));
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
     * @param array $currentDatas
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @return mixed|null
     */
    public static function saveListCollations($shopTableCatalogID, array $currentDatas, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        $model = new Model_Shop_Good();
        $model->setDBDriver($driver);

        $isAll = Request_RequestParams::getParamBoolean('is_all');
        if($isAll) {
            $shopGoods = $currentDatas;
        }else{
            $shopGoods = Request_RequestParams::getParamArray('data', array());
        }

        foreach ($shopGoods as &$shopGood) {
            $model->clear();

            $id = intval(Arr::path($shopGood, 'shop_good_id', 0));
            if ($id > 0) {
                if (!Helpers_DB::dublicateObjectLanguage($model, $id, $sitePageData, $sitePageData->shopID)) {
                    continue;
                }
            } else {
                $model->setShopTableCatalogID($shopTableCatalogID);
            }

            if (key_exists('is_public', $shopGood) && ($id < 1)) {
                $model->setIsPublic($shopGood['is_public']);
            }
            if (key_exists('collations', $shopGood) && ($id < 1)) {
                $model->addCollationsArray($shopGood['collations']);
            }
            if (key_exists('old_id', $shopGood) && (($id < 1) || (empty($model->getOldID())))) {
                $model->setOldID($shopGood['old_id']);
            }
            if (key_exists('article', $shopGood) && (($id < 1) || (empty($model->getArticle())))) {
                $model->setArticle($shopGood['article']);
            }
            if (key_exists('name', $shopGood) && (($id < 1) || (empty($model->getName())))) {
                if (!empty($shopGood['name'])) {
                    $model->setName($shopGood['name']);
                    $model->setNameURL(Helpers_URL::getNameURL($model));
                }
            }
            if (key_exists('price_old', $shopGood)) {
                $model->setPriceOld($shopGood['price_old']);
            }
            if (key_exists('text', $shopGood)) {
                $model->setText($shopGood['text']);
            }

            $options = array();
            foreach($shopGood as $k => $v){
                if(strpos($k, 'options.') === 0){
                    $options[str_replace('options.', '', $k)] = $v;
                }
            }
            $model->addOptionsArray($options, FALSE);

            $model->setNameURL(Helpers_URL::getNameURL($model));

            if (key_exists('price', $shopGood)) {
                $model->setPrice($shopGood['price']);
            }
            if (key_exists('price_cost', $shopGood)) {
                $model->setPriceCost($shopGood['price_cost']);
            }

            $shopGood['shop_good_id'] = Helpers_DB::saveDBObject($model, $sitePageData, $sitePageData->shopID);
            $shopGood['shop_good_name'] = $model->getName();
        }

        if (!$isAll){
            $shopGoods = Api_Shop_Load_Data::findCollations($currentDatas, $shopTableCatalogID,
                Model_Shop_Good::TABLE_ID, $sitePageData, $driver);
        }

        return $shopGoods;
    }

    /**
     * Сохранение списка товаров
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @return bool
     */
    public static function saveList(SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        $model = new Model_Shop_Good();
        $model->setDBDriver($driver);

        $shopGoods = Request_RequestParams::getParamArray('shop_goods', array());
        if ($shopGoods === NULL) {
            return FALSE;
        }

        foreach ($shopGoods as $id => $shopGood) {
            $id = intval($id);
            if ($id > 0) {
                if (!Helpers_DB::dublicateObjectLanguage($model, $id, $sitePageData, $sitePageData->shopID)) {
                    continue;
                }

                if (key_exists('is_public', $shopGood)) {
                    $model->setIsPublic($shopGood['is_public']);
                }
                if (key_exists('name', $shopGood)) {
                    if (!empty($shopGood['name'])) {
                        $model->setName($shopGood['name']);
                    }
                }

                if (key_exists('text', $shopGood)) {
                    $model->setText($shopGood['text']);
                }

                if (key_exists('article', $shopGood)) {
                    $model->setArticle($shopGood['article']);
                }

                if (key_exists('remarketing', $shopGood)) {
                    $model->setRemarketing($shopGood['remarketing']);
                }

                if (key_exists('shop_table_rubric_id', $shopGood)) {
                    $model->setShopTableRubricID($shopGood['shop_table_rubric_id']);
                }

                if (key_exists('shop_table_unit_id', $shopGood)) {
                    $model->setShopTableUnitID($shopGood['shop_table_unit_id']);
                }

                if (key_exists('shop_table_brand_id', $shopGood)) {
                    $model->setShopTableBrandID($shopGood['shop_table_brand_id']);
                }

                if (key_exists('price_old', $shopGood)) {
                    $model->setPriceOld($shopGood['price_old']);
                }

                if (key_exists('options', $shopGood)) {
                    $options = $shopGood['options'];
                    if (is_array($options)) {
                        $model->addOptionsArray($options);
                    }
                }
                if (key_exists('collations', $shopGood)) {
                    $options = $shopGood['collations'];
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
     * @throws HTTP_Exception_404
     */
    public static function delete(SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        $id = Request_RequestParams::getParamInt('id');
        if($id < 0){
            return FALSE;
        }

        $model = new Model_Shop_Good();
        $model->setDBDriver($driver);

        if (!Helpers_DB::dublicateObjectLanguage($model, $id, $sitePageData, -1, Request_RequestParams::getParamInt('version'))) {
            throw new HTTP_Exception_404('Goods not found.');
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
     * Сохранение товара
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @return array
     * @throws HTTP_Exception_500
     */
    public static function save(SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        $model = new Model_Shop_Good();
        $model->setDBDriver($driver);

        $id = Request_RequestParams::getParamInt('id');
        if($id > 0) {
            if (!Helpers_DB::dublicateObjectLanguage($model, $id, $sitePageData)) {
                throw new HTTP_Exception_500('Goods not found.');
            }

            $type = $model->getShopTableCatalogID();
            $isGroup = $model->getIsGroup();
        }else{
            $id = Request_RequestParams::getParamInt('clone_id');
            if($id > 0) {
                $id = Helpers_DB::cloneObjectLanguages($model, $id, $sitePageData);

                if (!Helpers_DB::dublicateObjectLanguage($model, $id, $sitePageData)) {
                    throw new HTTP_Exception_500('Goods not found.');
                }

                $type = $model->getShopTableCatalogID();
                $isGroup = $model->getIsGroup();
            }else{
                $type = Request_RequestParams::getParamInt('type');
                $isGroup = Request_RequestParams::getParamBoolean('is_group');

                $model->setShopTableCatalogID($type);
                $model->setIsGroup($isGroup);
            }
        }

        $oldRubricID = $model->getShopTableRubricID();
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
        Request_RequestParams::setParamInt("shop_table_select_id", $model);
        Request_RequestParams::setParamInt("shop_table_unit_id", $model);
        Request_RequestParams::setParamInt("shop_table_brand_id", $model);
        Request_RequestParams::setParamInt("shop_table_stock_id", $model);
        Request_RequestParams::setParamStr('stock_name', $model);

        $isTranslate = Request_RequestParams::getParamBoolean('is_translate');
        if($isTranslate !== NULL) {
            $model->setIsTranslatesCurrentLanguage($isTranslate, $sitePageData->dataLanguageID, $sitePageData->shop->getLanguageIDsArray());
        }

        // определяем уникальное имя для сео
        $model->setNameURL(Helpers_URL::getNameURL($model));

        $workTypeID = Request_RequestParams::getParamInt('work_type_id');
        if ($workTypeID !== NULL) {
            if (($workTypeID != Model_WorkType::WORK_TYPE_FINISH) || (!Func::_empty($model->getName()))){
                $model->setWorkTypeID($workTypeID);
            }
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
                        'file' => $file->saveDownloadFilePath($child, $model->id, Model_Shop_Good::TABLE_ID, $sitePageData),
                        'name' => $child['name'],
                        'size' => $child['size'],
                    );
                }
            }
            if ($options !== NULL) {
                $model->addOptionsArray($options);
            }

            // сохраняем список рубрик
            $rubrics = Request_RequestParams::getParamArray('shop_table_rubrics');
            if ($rubrics !== NULL) {
                $model->setShopTableRubricIDsArray(
                    Api_Shop_Table_Rubric_Object::save($model, $rubrics, $sitePageData, $driver)
                );
            }

            if($type > 0) {
                $modelType = new Model_Shop_Table_Catalog();
                $modelType->setDBDriver($driver);
                Helpers_DB::dublicateObjectLanguage($modelType, $type, $sitePageData, $sitePageData->shopMainID);

                // сохраняем список фильтров
                $filters = Request_RequestParams::getParamArray('shop_table_filters');
                if ($filters !== NULL) {
                    $model->setShopTableFilterIDsArray(Api_Shop_Table_ObjectToObject::saveToFilters(
                        Model_Shop_Good::TABLE_ID, $model->id, $model->getShopTableCatalogID(),
                        $filters, $modelType->getChildShopTableCatalogID('filter', $sitePageData->languageID),
                        $sitePageData, $driver));
                }

                // сохраняем список хэштегов
                $hashtags = Request_RequestParams::getParamArray('shop_table_hashtags');
                if ($hashtags !== NULL) {
                    $model->setShopTableHashtagIDsArray(Api_Shop_Table_ObjectToObject::saveToHashtags(
                        Model_Shop_Good::TABLE_ID, $model->id, $model->getShopTableCatalogID(),
                        $hashtags, $modelType->getChildShopTableCatalogID('hashtag', $sitePageData->languageID),
                        $sitePageData, $driver));
                }
            }

            // сохраняем группу товаров
            $groups = Request_RequestParams::getParamArray('shop_table_groups');
            if ($groups !== NULL) {
                $model->setShopTableGroupIDsArray(Api_Shop_Table_Group::saveList(
                    Model_Shop_Good::TABLE_ID, $model->id, $model->getShopTableCatalogID(),
                    $groups,
                    $sitePageData, $driver));
            }

            // подобные товары
            $similars = Request_RequestParams::getParamArray('shop_table_similars');
            if($similars !== NULL){
                $model->setShopTableSimilarIDsArray(Api_Shop_Table_Similar::saveList(
                    Model_Shop_Good::TABLE_ID, $model->id, $model->getShopTableCatalogID(),
                    $similars,
                    $sitePageData, $driver));
            }

            // определяем уникальное имя для сео
            $model->setNameURL(Helpers_URL::getNameURL($model));

            Helpers_DB::saveDBObject($model, $sitePageData);
            $result['values'] = $model->getValues();

            if(! $model->getIsGroup()) {
                // пересчитываем количество товаров на складе
               // self::countUpStorageShopGood($model->id, $sitePageData, $driver);

                // если поменяли рубрику, то пересчитываем предыдущую рубрику
                if ($oldRubricID != $model->getShopTableRubricID()) {
                    //Api_ShopTableRubric::countUpStorageShopTableRubric($oldRubricID, $sitePageData, $driver);
                }
            }
        }

        return array(
            'id' => $model->id,
            'type' => $type,
            'is_group' => $isGroup,
            'result' => $result,
        );
    }

    /**
     * Размещаем товары в складе
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @throws HTTP_Exception_500
     */
    public static function markOutStock(SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        $shopTableStockID = Request_RequestParams::getParamStr('shop_table_stock_barcode');
        if (empty($shopTableStockID)){
            return FALSE;
        }
        $shopTableStockID = Request_Shop_Table_Stock::findShopTableStockIDs($sitePageData->shopID, $sitePageData, $driver,
            array('barcode' => $shopTableStockID, 'is_public_ignore' => TRUE, Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE), $limit = 1);
        if (count($shopTableStockID->childs) == 0){
            return FALSE;
        }
        $shopTableStockID = $shopTableStockID->childs[0]->id;

        $type = Request_RequestParams::getParamInt('type');

        $stockNames = Request_RequestParams::getParamArray('stock_names');
        if (!empty($stockNames)){
            $shopGoodIDs = Request_Request::find('DB_Shop_Good',$sitePageData->shopID, $sitePageData, $driver,
                array('type' => $type, 'stock_name' => $stockNames, 'work_type_id' => -1, 'is_public_ignore' => TRUE,
                    Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE), 0, TRUE);
        }else{
            $shopGoodIDs = new MyArray();
        }

        $model = new Model_Shop_Good();
        $model->setDBDriver($driver);
        foreach ($shopGoodIDs->childs as $shopGoodID){
            $model->clear();
            $model->__setArray(array('values' => $shopGoodID->values));
            $model->setShopTableStockID($shopTableStockID);
            Helpers_DB::saveDBObject($model, $sitePageData);
        }

        return array(
            'type' => $type,
            'result' => array(
                'error' => FALSE
            ),
        );
    }

    /**
     * Размещаем товары в ревизию
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @throws HTTP_Exception_500
     */
    public static function addListRevisionGoods(SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        $shopTableRevisionID = Request_RequestParams::getParamStr('id');
        if (empty($shopTableRevisionID)){
            return FALSE;
        }
        $modelRevision = new Model_Shop_Table_Revision();
        $modelRevision->setDBDriver($driver);
        if (! Helpers_DB::dublicateObjectLanguage($modelRevision, $shopTableRevisionID, $sitePageData)) {
            return FALSE;
        }

        $shopTableStockID = Request_RequestParams::getParamStr('shop_table_stock_barcode');
        if (empty($shopTableStockID)){
            return FALSE;
        }
        $shopTableStockID = Request_Shop_Table_Stock::findShopTableStockIDs($sitePageData->shopID, $sitePageData, $driver,
            array('barcode' => $shopTableStockID, Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE), 1);
        if (count($shopTableStockID->childs) == 0){
            return FALSE;
        }
        $shopTableStockID = $shopTableStockID->childs[0]->id;

        $type = Request_RequestParams::getParamInt('goods-type');
        $stockNames = Request_RequestParams::getParamArray('stock_names');
        $shopGoodIDs = Request_Request::find('DB_Shop_Good',$sitePageData->shopID, $sitePageData, $driver,
            array('type' => $type, 'stock_name' => $stockNames, 'is_public_ignore' => TRUE, 'work_type_id' => -1,
                Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE), 0, TRUE);

        $newGoods = array();
        foreach ($stockNames as $stockName){
            $newGoods[$stockName] = '';
        }
        $stockNames = $newGoods;

        $model = new Model_Shop_Table_Revision_Child();
        $model->setDBDriver($driver);

        $modelGood = new Model_Shop_Good();
        $modelGood->setDBDriver($driver);
        foreach ($shopGoodIDs->childs as $shopGoodID){
            $modelGood->clear();
            $modelGood->__setArray(array('values' => $shopGoodID->values));

            $model->clear();
            $model->setRootTableID(Model_Shop_Good::TABLE_ID);
            $model->setShopRootObjectID($shopGoodID->id);
            $model->setShopRootCatalogID($shopGoodID->values['shop_table_catalog_id']);
            $model->setNewShopTableStockID($shopTableStockID);
            $model->setOldShopTableStockID($modelGood->getShopTableStockID());
            $model->setChildTableID(Model_Shop_Table_Revision::TABLE_ID);
            $model->setShopChildObjectID($modelRevision->id);
            $model->setShopChildCatalogID($modelRevision->getShopTableCatalogID());

            Helpers_DB::saveDBObject($model, $sitePageData);

            $modelGood->setShopTableStockID($shopTableStockID);
            Helpers_DB::saveDBObject($modelGood, $sitePageData);

            unset($stockNames[$modelGood->getStockName()]);
        }

        // если не найден штрихкод то добавляет запись, как новый приход
        foreach ($stockNames as $stockName => $value){
            $stockName = trim($stockName);
            if (empty($stockName)){
                continue;
            }
            $modelGood->clear();
            $modelGood->setShopTableCatalogID($type);
            $modelGood->setStockName($stockName);
            $modelGood->setWorkTypeID(Model_WorkType::WORK_TYPE_NOT_WORK);
            $modelGood->setShopTableStockID($shopTableStockID);
            Helpers_DB::saveDBObject($modelGood, $sitePageData);

            $model->clear();
            $model->setRootTableID(Model_Shop_Good::TABLE_ID);
            $model->setShopRootObjectID($modelGood->id);
            $model->setShopRootCatalogID($type);
            $model->setNewShopTableStockID($shopTableStockID);
            $model->setOldShopTableStockID($modelGood->getShopTableStockID());
            $model->setChildTableID(Model_Shop_Table_Revision::TABLE_ID);
            $model->setShopChildObjectID($modelRevision->id);
            $model->setShopChildCatalogID($modelRevision->getShopTableCatalogID());
            Helpers_DB::saveDBObject($model, $sitePageData);
        }

        return array(
            'type' => $type,
            'id' => $shopTableRevisionID,
            'result' => array(
                'error' => FALSE
            ),
        );
    }

    /**
     * Посчитать количетсво на складе
     * @param integer $shopID
     * @param Model_Driver_DBBasicDriver $driver
     * @param boolean $isIgnorIsPublic
     * @param integer $limit
     * @return MyArray
     */
    public static function getShopGoodItemStorageCount($shopID, $shopGoodID, SitePageData $sitePageData,
                                                       Model_Driver_DBBasicDriver $driver){
        $sql = GlobalData::newModelDriverDBSQL();
        $sql->getRootSelect()->addFunctionField('', 'storage_count', Model_Driver_DBBasicSelect::FUNCTION_SUM, 'storage_sum');
        $sql->setTableName(Model_Shop_GoodItem::TABLE_NAME);

        $sql->getRootWhere()->addField("is_delete", '', 0);
        $sql->getRootWhere()->addField("shop_id", '', $shopID);
        $sql->getRootWhere()->addField("shop_good_id", '', $shopGoodID);

        $arr = $driver->getSelect($sql, TRUE, 0, $shopID)['result'];

        if(count($arr) == 0){
            return NULL;
        }else{
            return $arr[0]['storage_sum'];
        }
    }

}
