<?php defined('SYSPATH') or die('No direct script access.');

class Api_Ab1_Shop_Transport_Company  {

    /**
     * Сохранение списка товаров
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     */
    public static function saveListCollations($shopTableCatalogID, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        $model = new Model_Ab1_Shop_Transport_Company();
        $model->setDBDriver($driver);

        $shopTransportCompanys = Request_RequestParams::getParamArray('data', array());
        foreach ($shopTransportCompanys as &$shopTransportCompany) {
            $model->clear();

            $id = intval(Arr::path($shopTransportCompany, 'shop_transport_company_id', 0));
            if ($id > 0) {
                if (!Helpers_DB::dublicateObjectLanguage($model, $id, $sitePageData, $sitePageData->shopID)) {
                    continue;
                }
            } else {
                $model->setShopTableCatalogID($shopTableCatalogID);
            }

            if($id < 1) {
                if (key_exists('is_public', $shopTransportCompany)) {
                    $model->setIsPublic($shopTransportCompany['is_public']);
                }
                if (key_exists('collations', $shopTransportCompany)) {
                    $model->addCollationsArray($shopTransportCompany['collations']);
                }
                if (key_exists('old_id', $shopTransportCompany)) {
                    $model->setOldID($shopTransportCompany['old_id']);
                }
                if (key_exists('last_name', $shopTransportCompany)) {
                    $model->setLastName($shopTransportCompany['last_name']);
                }
                if (key_exists('name', $shopTransportCompany)) {
                    if (!empty($shopTransportCompany['name'])) {
                        $model->setName($shopTransportCompany['name']);
                    }
                }
                if (key_exists('text', $shopTransportCompany)) {
                    $model->setText($shopTransportCompany['text']);
                }
            }

            $options = array();
            foreach($shopTransportCompany as $k => $v){
                if(strpos($k, 'options.') === 0){
                    $options[str_replace('options.', '', $k)] = $v;
                }
            }
            $model->addOptionsArray($options, FALSE);

            if (key_exists('price', $shopTransportCompany)) {
                $model->setPrice($shopTransportCompany['price']);
            }

            $shopTransportCompany['shop_transport_company_id'] = Helpers_DB::saveDBObject($model, $sitePageData, $sitePageData->shopID);
            $shopTransportCompany['shop_transport_company_name'] = trim($model->getLastName().' '.$model->getName());
        }

        return $shopTransportCompanys;
    }

    /**
     * Сохранение списка товаров
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @return false
     */
    public static function saveList(SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        $model = new Model_Ab1_Shop_Transport_Company();
        $model->setDBDriver($driver);

        $shopTransportCompanys = Request_RequestParams::getParamArray('shop_transport_companys', array());
        if ($shopTransportCompanys === NULL) {
            return FALSE;
        }

        foreach ($shopTransportCompanys as $id => $shopTransportCompany) {
            $id = intval($id);
            if ($id > 0) {
                if (!Helpers_DB::dublicateObjectLanguage($model, $id, $sitePageData, $sitePageData->shopID)) {
                    continue;
                }

                if (key_exists('is_public', $shopTransportCompany)) {
                    $model->setIsPublic($shopTransportCompany['is_public']);
                }
                if (key_exists('name', $shopTransportCompany)) {
                    if (!empty($shopTransportCompany['name'])) {
                        $model->setName($shopTransportCompany['name']);
                    }
                }

                if (key_exists('text', $shopTransportCompany)) {
                    $model->setText($shopTransportCompany['text']);
                }

                if (key_exists('last_name', $shopTransportCompany)) {
                    $model->setLastName($shopTransportCompany['last_name']);
                }

                if (key_exists('remarketing', $shopTransportCompany)) {
                    $model->setRemarketing($shopTransportCompany['remarketing']);
                }

                if (key_exists('shop_table_rubric_id', $shopTransportCompany)) {
                    $model->setShopTableRubricID($shopTransportCompany['shop_table_rubric_id']);
                }
                if (key_exists('options', $shopTransportCompany)) {
                    $options = $shopTransportCompany['options'];
                    if (is_array($options)) {
                        $model->addOptionsArray($options);
                    }
                }
                if (key_exists('collations', $shopTransportCompany)) {
                    $options = $shopTransportCompany['collations'];
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

        $model = new Model_Ab1_Shop_Transport_Company();
        $model->setDBDriver($driver);

        if (!Helpers_DB::dublicateObjectLanguage($model, $id, $sitePageData)) {
            throw new HTTP_Exception_500('TransportCompany not found.');
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
        $model = new Model_Ab1_Shop_Transport_Company();
        $model->setDBDriver($driver);

        $id = Request_RequestParams::getParamInt('id');
        if($id > 0) {
            if (!Helpers_DB::dublicateObjectLanguage($model, $id, $sitePageData, $sitePageData->shopMainID)) {
                throw new HTTP_Exception_500('TransportCompany not found.');
            }
        }

        Request_RequestParams::setParamBoolean('is_public', $model);
        Request_RequestParams::setParamStr('text', $model);
        Request_RequestParams::setParamStr('name', $model);
        Request_RequestParams::setParamBoolean("is_public", $model);
        Request_RequestParams::setParamStr("last_name", $model);
        Request_RequestParams::setParamStr("email", $model);
        Request_RequestParams::setParamStr("old_id", $model);
        Request_RequestParams::setParamInt("shop_table_select_id", $model);
        Request_RequestParams::setParamInt("shop_table_unit_id", $model);
        Request_RequestParams::setParamInt("shop_table_brand_id", $model);

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

            Helpers_DB::saveDBObject($model, $sitePageData, $sitePageData->shopMainID);
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

        $model = new Model_Ab1_Shop_Transport_Company();
        $model->setDBDriver($driver);

        $modelOld = new Model_Ab1_Shop_Transport_Company();
        $modelOld->setDBDriver($driver);

        if($isAll) {
            $transportCompanyIDs = Request_Request::find('DB_Ab1_Shop_Transport_Company', $sitePageData->shopMainID, $sitePageData, $driver,
                array('is_public_ignore' => TRUE, Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE), 0, TRUE);
            $transportCompanys = array();
            foreach ($transportCompanyIDs->childs as $child) {
                $transportCompanys[$child->values['old_id']] = $child;
            }

            $isCompany = FALSE;
            while ($reader->read()) {
                if ($reader->nodeType == XMLReader::ELEMENT) {
                    switch ($reader->localName) {
                        case 'Company':
                            if (!empty($model->getName())) {
                                if (key_exists($model->getOldID(), $transportCompanys)) {
                                    $modelOld->clear();
                                    $modelOld->__setArray(array('values' => $transportCompanys[$model->getOldID()]->values));

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
                if (key_exists($model->getOldID(), $transportCompanys)) {
                    $modelOld->clear();
                    $modelOld->__setArray(array('values' => $transportCompanys[$model->getOldID()]->values));

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
                                $ids = Request_Request::find('DB_Ab1_Shop_Transport_Company', $sitePageData->shopMainID, $sitePageData, $driver,
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
                $ids = Request_Request::find('DB_Ab1_Shop_Transport_Company', $sitePageData->shopMainID, $sitePageData, $driver,
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
