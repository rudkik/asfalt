<?php defined('SYSPATH') or die('No direct script access.');

class Api_Ab1_Shop_Move_Place  {

    /**
     * Сохранение списка товаров
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     */
    public static function saveListCollations($shopTableCatalogID, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        $model = new Model_Ab1_Shop_Move_Place();
        $model->setDBDriver($driver);

        $shopMovePlaces = Request_RequestParams::getParamArray('data', array());
        foreach ($shopMovePlaces as &$shopMovePlace) {
            $model->clear();

            $id = intval(Arr::path($shopMovePlace, 'shop_move_place_id', 0));
            if ($id > 0) {
                if (!Helpers_DB::dublicateObjectLanguage($model, $id, $sitePageData, $sitePageData->shopID)) {
                    continue;
                }
            } else {
                $model->setShopTableCatalogID($shopTableCatalogID);
            }

            if($id < 1) {
                if (key_exists('is_public', $shopMovePlace)) {
                    $model->setIsPublic($shopMovePlace['is_public']);
                }
                if (key_exists('collations', $shopMovePlace)) {
                    $model->addCollationsArray($shopMovePlace['collations']);
                }
                if (key_exists('old_id', $shopMovePlace)) {
                    $model->setOldID($shopMovePlace['old_id']);
                }
                if (key_exists('last_name', $shopMovePlace)) {
                    $model->setLastName($shopMovePlace['last_name']);
                }
                if (key_exists('name', $shopMovePlace)) {
                    if (!empty($shopMovePlace['name'])) {
                        $model->setName($shopMovePlace['name']);
                    }
                }
                if (key_exists('text', $shopMovePlace)) {
                    $model->setText($shopMovePlace['text']);
                }
            }

            $options = array();
            foreach($shopMovePlace as $k => $v){
                if(strpos($k, 'options.') === 0){
                    $options[str_replace('options.', '', $k)] = $v;
                }
            }
            $model->addOptionsArray($options, FALSE);

            if (key_exists('price', $shopMovePlace)) {
                $model->setPrice($shopMovePlace['price']);
            }

            $shopMovePlace['shop_move_place_id'] = Helpers_DB::saveDBObject($model, $sitePageData, $sitePageData->shopID);
            $shopMovePlace['shop_move_place_name'] = trim($model->getLastName().' '.$model->getName());
        }

        return $shopMovePlaces;
    }

    /**
     * Сохранение списка товаров
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @return false
     */
    public static function saveList(SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        $model = new Model_Ab1_Shop_Move_Place();
        $model->setDBDriver($driver);

        $shopMovePlaces = Request_RequestParams::getParamArray('shop_move_places', array());
        if ($shopMovePlaces === NULL) {
            return FALSE;
        }

        foreach ($shopMovePlaces as $id => $shopMovePlace) {
            $id = intval($id);
            if ($id > 0) {
                if (!Helpers_DB::dublicateObjectLanguage($model, $id, $sitePageData, $sitePageData->shopID)) {
                    continue;
                }

                if (key_exists('is_public', $shopMovePlace)) {
                    $model->setIsPublic($shopMovePlace['is_public']);
                }
                if (key_exists('name', $shopMovePlace)) {
                    if (!empty($shopMovePlace['name'])) {
                        $model->setName($shopMovePlace['name']);
                    }
                }

                if (key_exists('text', $shopMovePlace)) {
                    $model->setText($shopMovePlace['text']);
                }

                if (key_exists('last_name', $shopMovePlace)) {
                    $model->setLastName($shopMovePlace['last_name']);
                }

                if (key_exists('remarketing', $shopMovePlace)) {
                    $model->setRemarketing($shopMovePlace['remarketing']);
                }

                if (key_exists('shop_table_rubric_id', $shopMovePlace)) {
                    $model->setShopTableRubricID($shopMovePlace['shop_table_rubric_id']);
                }
                if (key_exists('options', $shopMovePlace)) {
                    $options = $shopMovePlace['options'];
                    if (is_array($options)) {
                        $model->addOptionsArray($options);
                    }
                }
                if (key_exists('collations', $shopMovePlace)) {
                    $options = $shopMovePlace['collations'];
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

        $model = new Model_Ab1_Shop_Move_Place();
        $model->setDBDriver($driver);

        if (!Helpers_DB::dublicateObjectLanguage($model, $id, $sitePageData)) {
            throw new HTTP_Exception_500('Place not found.');
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
        $model = new Model_Ab1_Shop_Move_Place();
        $model->setDBDriver($driver);

        $id = Request_RequestParams::getParamInt('id');
        if($id > 0) {
            if (!Helpers_DB::dublicateObjectLanguage($model, $id, $sitePageData)) {
                throw new HTTP_Exception_500('Place not found.');
            }
        }

        Request_RequestParams::setParamBoolean('is_public', $model);
        Request_RequestParams::setParamStr('text', $model);
        Request_RequestParams::setParamStr('name', $model);
        Request_RequestParams::setParamStr("old_id", $model);
        Request_RequestParams::setParamInt("organization_type_id", $model);

        Request_RequestParams::setParamStr('bin', $model);
        Request_RequestParams::setParamStr('address', $model);
        Request_RequestParams::setParamStr('account', $model);
        Request_RequestParams::setParamStr('bank', $model);
        Request_RequestParams::setParamStr('contract', $model);
        Request_RequestParams::setParamInt('shop_payment_type_id', $model);
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

        $model = new Model_Ab1_Shop_Move_Place();
        $model->setDBDriver($driver);

        $modelOld = new Model_Ab1_Shop_Move_Place();
        $modelOld->setDBDriver($driver);

        if($isAll) {
            $placeIDs = Request_Request::find('DB_Ab1_Shop_Move_Place', $sitePageData->shopMainID, $sitePageData, $driver,
                array('is_public_ignore' => TRUE, Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE), 0, TRUE);

            $places = array();
            foreach ($placeIDs->childs as $child) {
                $places[$child->values['old_id']] = $child;
            }

            $isCompany = FALSE;
            while ($reader->read()) {
                if ($reader->nodeType == XMLReader::ELEMENT) {
                    switch ($reader->localName) {
                        case 'development':
                            if (!empty($model->getName())) {
                                if (key_exists($model->getOldID(), $places)) {
                                    $modelOld->clear();
                                    $modelOld->__setArray(array('values' => $places[$model->getOldID()]->values));

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
                        case 'code':
                            $reader->read();
                            if ($reader->nodeType == XMLReader::TEXT) {
                                $model->setOldID($reader->value);
                            }
                            break;
                        case 'name':
                            $reader->read();
                            if ($reader->nodeType == XMLReader::TEXT) {
                                $model->setName($reader->value);
                            }
                            break;
                    }
                }
            }

            if ($isCompany && (!empty($model->getName()))) {
                if (key_exists($model->getOldID(), $places)) {
                    $modelOld->clear();
                    $modelOld->__setArray(array('values' => $places[$model->getOldID()]->values));

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
                        case 'development':
                            if(!empty($model->getName())) {
                                $ids = Request_Request::find('DB_Ab1_Shop_Move_Place', $sitePageData->shopMainID, $sitePageData, $driver,
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
                        case 'code':
                            $reader->read();
                            if($reader->nodeType == XMLReader::TEXT) {
                                $model->setOldID($reader->value);
                            }
                            break;
                        case 'name':
                            $reader->read();
                            if($reader->nodeType == XMLReader::TEXT) {
                                $model->setName($reader->value);
                            }
                            break;
                            break;
                    }
                }
            }

            if($isCompany && (!empty($model->getName()))) {
                $ids = Request_Request::find('DB_Ab1_Shop_Move_Place', $sitePageData->shopMainID, $sitePageData, $driver,
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
