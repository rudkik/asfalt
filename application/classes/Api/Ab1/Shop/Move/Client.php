<?php defined('SYSPATH') or die('No direct script access.');

class Api_Ab1_Shop_Move_Client  {
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

        $model = new Model_Ab1_Shop_Move_Client();
        $model->setDBDriver($driver);

        if (!Helpers_DB::dublicateObjectLanguage($model, $id, $sitePageData)) {
            throw new HTTP_Exception_500('Client not found. #9');
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
        $model = new Model_Ab1_Shop_Move_Client();
        $model->setDBDriver($driver);

        $id = Request_RequestParams::getParamInt('id');
        if($id > 0) {
            if (!Helpers_DB::dublicateObjectLanguage($model, $id, $sitePageData)) {
                throw new HTTP_Exception_500('Client not found. #10');
            }
        }

        Request_RequestParams::setParamInt("shop_table_rubric_id", $model);
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
        Request_RequestParams::setParamInt("organization_type_id", $model);

        Request_RequestParams::setParamStr('bin', $model);
        Request_RequestParams::setParamStr('address', $model);
        Request_RequestParams::setParamStr('account', $model);
        Request_RequestParams::setParamStr('bank', $model);
        Request_RequestParams::setParamStr('contract', $model);
        Request_RequestParams::setParamInt('shop_payment_type_id', $model);
        Request_RequestParams::setParamStr('name_1c', $model);
        Request_RequestParams::setParamStr('name_site', $model);

        /*if(Func::_empty($model->getOldID())){
            $n = Database::instance()->query(Database::SELECT, 'SELECT nextval(\'number_move_client\') as id;')->as_array(NULL, 'id')[0];
            $n = '000000'.$n;
            $n = 'М'.substr($n, strlen($n) - 8);
            $model->setOldID($n);
        }*/

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

        $model = new Model_Ab1_Shop_Move_Client();
        $model->setDBDriver($driver);

        $modelOld = new Model_Ab1_Shop_Move_Client();
        $modelOld->setDBDriver($driver);

        if($isAll) {
            $clientIDs = Request_Request::find('DB_Ab1_Shop_Move_Client', $sitePageData->shopMainID, $sitePageData, $driver,
                array('is_public_ignore' => TRUE, Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE), 0, TRUE);

            $clients = array();
            foreach ($clientIDs->childs as $child) {
                $clients[$child->values['old_id']] = $child;
            }

            $isCompany = FALSE;
            while ($reader->read()) {
                if ($reader->nodeType == XMLReader::ELEMENT) {
                    switch ($reader->localName) {
                        case 'development':
                            if (!empty($model->getName())) {
                                if (key_exists($model->getOldID(), $clients)) {
                                    $modelOld->clear();
                                    $modelOld->__setArray(array('values' => $clients[$model->getOldID()]->values));

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
                if (key_exists($model->getOldID(), $clients)) {
                    $modelOld->clear();
                    $modelOld->__setArray(array('values' => $clients[$model->getOldID()]->values));

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
                                $ids = Request_Request::find('DB_Ab1_Shop_Move_Client', $sitePageData->shopMainID, $sitePageData, $driver,
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
                $ids = Request_Request::find('DB_Ab1_Shop_Move_Client', $sitePageData->shopMainID, $sitePageData, $driver,
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
