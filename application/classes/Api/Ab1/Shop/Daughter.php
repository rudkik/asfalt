<?php defined('SYSPATH') or die('No direct script access.');

class Api_Ab1_Shop_Daughter  {

    /**
     * Сохранение списка товаров
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     */
    public static function saveListCollations($shopTableCatalogID, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        $model = new Model_Ab1_Shop_Daughter();
        $model->setDBDriver($driver);

        $shopDaughters = Request_RequestParams::getParamArray('data', array());
        foreach ($shopDaughters as &$shopDaughter) {
            $model->clear();

            $id = intval(Arr::path($shopDaughter, 'shop_daughter_id', 0));
            if ($id > 0) {
                if (!Helpers_DB::dublicateObjectLanguage($model, $id, $sitePageData, $sitePageData->shopID)) {
                    continue;
                }
            } else {
                $model->setShopTableCatalogID($shopTableCatalogID);
            }

            if($id < 1) {
                if (key_exists('is_public', $shopDaughter)) {
                    $model->setIsPublic($shopDaughter['is_public']);
                }
                if (key_exists('collations', $shopDaughter)) {
                    $model->addCollationsArray($shopDaughter['collations']);
                }
                if (key_exists('old_id', $shopDaughter)) {
                    $model->setOldID($shopDaughter['old_id']);
                }
                if (key_exists('last_name', $shopDaughter)) {
                    $model->setLastName($shopDaughter['last_name']);
                }
                if (key_exists('name', $shopDaughter)) {
                    if (!empty($shopDaughter['name'])) {
                        $model->setName($shopDaughter['name']);
                    }
                }
                if (key_exists('text', $shopDaughter)) {
                    $model->setText($shopDaughter['text']);
                }
            }

            $options = array();
            foreach($shopDaughter as $k => $v){
                if(strpos($k, 'options.') === 0){
                    $options[str_replace('options.', '', $k)] = $v;
                }
            }
            $model->addOptionsArray($options, FALSE);

            if (key_exists('price', $shopDaughter)) {
                $model->setPrice($shopDaughter['price']);
            }

            $shopDaughter['shop_daughter_id'] = Helpers_DB::saveDBObject($model, $sitePageData, $sitePageData->shopID);
            $shopDaughter['shop_daughter_name'] = trim($model->getLastName().' '.$model->getName());
        }

        return $shopDaughters;
    }

    /**
     * сохранение списка товаров
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @return false
     */
    public static function saveList(SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        $model = new Model_Ab1_Shop_Daughter();
        $model->setDBDriver($driver);

        $shopDaughters = Request_RequestParams::getParamArray('shop_daughters', array());
        if ($shopDaughters === NULL) {
            return FALSE;
        }

        foreach ($shopDaughters as $id => $shopDaughter) {
            $id = intval($id);
            if ($id > 0) {
                if (!Helpers_DB::dublicateObjectLanguage($model, $id, $sitePageData, $sitePageData->shopID)) {
                    continue;
                }

                if (key_exists('is_public', $shopDaughter)) {
                    $model->setIsPublic($shopDaughter['is_public']);
                }
                if (key_exists('name', $shopDaughter)) {
                    if (!empty($shopDaughter['name'])) {
                        $model->setName($shopDaughter['name']);
                    }
                }

                if (key_exists('text', $shopDaughter)) {
                    $model->setText($shopDaughter['text']);
                }

                if (key_exists('last_name', $shopDaughter)) {
                    $model->setLastName($shopDaughter['last_name']);
                }

                if (key_exists('remarketing', $shopDaughter)) {
                    $model->setRemarketing($shopDaughter['remarketing']);
                }

                if (key_exists('shop_table_rubric_id', $shopDaughter)) {
                    $model->setShopTableRubricID($shopDaughter['shop_table_rubric_id']);
                }
                if (key_exists('options', $shopDaughter)) {
                    $options = $shopDaughter['options'];
                    if (is_array($options)) {
                        $model->addOptionsArray($options);
                    }
                }
                if (key_exists('collations', $shopDaughter)) {
                    $options = $shopDaughter['collations'];
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

        $model = new Model_Ab1_Shop_Daughter();
        $model->setDBDriver($driver);

        if (!Helpers_DB::dublicateObjectLanguage($model, $id, $sitePageData)) {
            throw new HTTP_Exception_500('Daughter not found.');
        }

        if(Request_RequestParams::getParamBoolean("is_undel") === TRUE){
            $model->dbUnDelete($sitePageData->userID, 0, $sitePageData->shopID);
        }else {
            $model->dbDelete($sitePageData->userID, 0, $sitePageData->shopID);
        }
    }


    /**
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @return array
     * @throws HTTP_Exception_500
     */
    public static function save(SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        $model = new Model_Ab1_Shop_Daughter();
        $model->setDBDriver($driver);

        $id = Request_RequestParams::getParamInt('id');
        if($id > 0) {
            if (!Helpers_DB::dublicateObjectLanguage($model, $id, $sitePageData)) {
                throw new HTTP_Exception_500('Daughter not found.');
            }
        }
        Request_RequestParams::setParamBoolean('is_public', $model);
        Request_RequestParams::setParamStr('text', $model);
        Request_RequestParams::setParamStr('name', $model);
        Request_RequestParams::setParamStr("old_id", $model);
        Request_RequestParams::setParamInt("daughter_weight_id", $model);

        Request_RequestParams::setParamStr('name_1c', $model);
        Request_RequestParams::setParamStr('name_site', $model);

        // название
        if(empty($model->getName()) || empty($model->getNameSite()) || empty($model->getName1C())){
            if(!empty($model->getName())){
                $name = $model->getName();
            }elseif(!empty($model->getName1C())){
                $name = $model->getName1C();
            }elseif(!empty($model->getNameSite())){
                $name = $model->getNameSite();
            }else{
                $name = '';
            }

            if(empty($model->getName())){
                $model->setName($name);
            }
            if(empty($model->getNameSite())){
                $model->setNameSite($name);
            }
            if(empty($model->getName1C())){
                $model->setName1C($name);
            }
        }

        $options = Request_RequestParams::getParamArray('options');
        if ($options !== NULL) {
            $model->addOptionsArray($options);
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
            'result' => $result,
        );
    }

    /**
     * Загрузить клиентов из XML
     * @param $fileName
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     */
    public static function loadXML($fileName, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver, $isAll = TRUE)
    {
        $reader = new XMLReader();
        $reader->open($fileName);

        $model = new Model_Ab1_Shop_Daughter();
        $model->setDBDriver($driver);

        $modelOld = new Model_Ab1_Shop_Daughter();
        $modelOld->setDBDriver($driver);

        if($isAll) {
            $daughterIDs = Request_Request::find('DB_Ab1_Shop_Daughter', $sitePageData->shopMainID, $sitePageData, $driver,
                array('is_public_ignore' => TRUE, Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE), 0, TRUE);
            $daughters = array();
            foreach ($daughterIDs->childs as $child) {
                $daughters[$child->values['old_id']] = $child;
            }

            $isCompany = FALSE;
            while ($reader->read()) {
                if ($reader->nodeType == XMLReader::ELEMENT) {
                    switch ($reader->localName) {
                        case 'Company':
                            if (!empty($model->getName())) {
                                if (key_exists($model->getOldID(), $daughters)) {
                                    $modelOld->clear();
                                    $modelOld->__setArray(array('values' => $daughters[$model->getOldID()]->values));

                                    $modelOld->setName1C($model->getName());
                                    $modelOld->setOptions($model->getOptions());
                                    Helpers_DB::saveDBObject($modelOld, $sitePageData);
                                } else {
                                    $model->setName1C($model->getName());
                                    $model->setNameSite($model->getName());
                                    Helpers_DB::saveDBObject($model, $sitePageData);
                                }
                            }
                            $isCompany = TRUE;
                            $model->clear();
                            break;
                        case 'Id':
                            $reader->read();
                            if ($reader->nodeType == XMLReader::TEXT) {
                                $model->setOldID($reader->value);
                            }
                            break;
                        case 'Name':
                            $reader->read();
                            if ($reader->nodeType == XMLReader::TEXT) {
                                $model->setName($reader->value);
                            }
                            break;
                    }
                }
            }

            if ($isCompany && (!empty($model->getName()))) {
                if (key_exists($model->getOldID(), $daughters)) {
                    $modelOld->clear();
                    $modelOld->__setArray(array('values' => $daughters[$model->getOldID()]->values));

                    $modelOld->setName1C($model->getName());
                    $modelOld->setOptions($model->getOptions());
                    Helpers_DB::saveDBObject($modelOld, $sitePageData);
                } else {
                    $model->setName1C($model->getName());
                    $model->setNameSite($model->getName());
                    Helpers_DB::saveDBObject($model, $sitePageData);
                }
            }
        }else{
            $isCompany = FALSE;
            while ($reader->read()) {
                if ($reader->nodeType == XMLReader::ELEMENT) {
                    switch($reader->localName){
                        case 'Company':
                            if(!empty($model->getName())) {
                                $ids = Request_Request::find('DB_Ab1_Shop_Daughter', $sitePageData->shopMainID, $sitePageData, $driver,
                                    array('old_id' => $model->getOldID(), 'is_public_ignore' => TRUE, Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE), 1, TRUE);

                                if(count($ids->childs) > 0){
                                    $modelOld->clear();
                                    $modelOld->__setArray(array('values' => $ids->childs[0]->values));

                                    $modelOld->setName1C($model->getName());
                                    $modelOld->setOptions($model->getOptions());
                                    Helpers_DB::saveDBObject($modelOld, $sitePageData);
                                }else {
                                    $model->setName1C($model->getName());
                                    $model->setNameSite($model->getName());
                                    Helpers_DB::saveDBObject($model, $sitePageData);
                                }
                            }

                            $isCompany = TRUE;
                            $model->clear();
                            break;
                        case 'Id':
                            $reader->read();
                            if($reader->nodeType == XMLReader::TEXT) {
                                $model->setOldID($reader->value);
                            }
                            break;
                        case 'Name':
                            $reader->read();
                            if($reader->nodeType == XMLReader::TEXT) {
                                $model->setName($reader->value);
                            }
                            break;
                    }
                }
            }

            if($isCompany && (!empty($model->getName()))) {
                $ids = Request_Request::find('DB_Ab1_Shop_Daughter', $sitePageData->shopMainID, $sitePageData, $driver,
                    array('old_id' => $model->getOldID(), 'is_public_ignore' => TRUE, Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE), 1, TRUE);

                if(count($ids->childs) > 0){
                    $modelOld->clear();
                    $modelOld->__setArray(array('values' => $ids->childs[0]->values));

                    $modelOld->setName1C($model->getName());
                    $modelOld->setOptions($model->getOptions());
                    Helpers_DB::saveDBObject($modelOld, $sitePageData);
                }else {
                    $model->setName1C($model->getName());
                    $model->setNameSite($model->getName());
                    Helpers_DB::saveDBObject($model, $sitePageData);
                }
            }
        }

        $reader->close();
    }
}
