<?php defined('SYSPATH') or die('No direct script access.');

class Api_Shop_Client  {

    /**
     * Сохранение списка товаров
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     */
    public static function saveListCollations($shopTableCatalogID, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        $model = new Model_Shop_Client();
        $model->setDBDriver($driver);

        $shopClients = Request_RequestParams::getParamArray('data', array());
        foreach ($shopClients as &$shopClient) {
            $model->clear();

            $id = intval(Arr::path($shopClient, 'shop_client_id', 0));
            if ($id > 0) {
                if (!Helpers_DB::dublicateObjectLanguage($model, $id, $sitePageData, $sitePageData->shopID)) {
                    continue;
                }
            } else {
                $model->setShopTableCatalogID($shopTableCatalogID);
            }

            if($id < 1) {
                if (key_exists('is_public', $shopClient)) {
                    $model->setIsPublic($shopClient['is_public']);
                }
                if (key_exists('collations', $shopClient)) {
                    $model->addCollationsArray($shopClient['collations']);
                }
                if (key_exists('old_id', $shopClient)) {
                    $model->setOldID($shopClient['old_id']);
                }
                if (key_exists('last_name', $shopClient)) {
                    $model->setLastName($shopClient['last_name']);
                }
                if (key_exists('name', $shopClient)) {
                    if (!empty($shopClient['name'])) {
                        $model->setName($shopClient['name']);
                    }
                }
                if (key_exists('text', $shopClient)) {
                    $model->setText($shopClient['text']);
                }
            }

            $options = array();
            foreach($shopClient as $k => $v){
                if(strpos($k, 'options.') === 0){
                    $options[str_replace('options.', '', $k)] = $v;
                }
            }
            $model->addOptionsArray($options, FALSE);

            if (key_exists('price', $shopClient)) {
                $model->setPrice($shopClient['price']);
            }

            $shopClient['shop_client_id'] = Helpers_DB::saveDBObject($model, $sitePageData, $sitePageData->shopID);
            $shopClient['shop_client_name'] = trim($model->getLastName().' '.$model->getName());
        }

        return $shopClients;
    }

    /**
     * Сохранение списка
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @return bool
     */
    public static function saveList(SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        $model = new Model_Shop_Client();
        $model->setDBDriver($driver);

        $shopClients = Request_RequestParams::getParamArray('shop_clients', array());
        if ($shopClients === NULL) {
            return FALSE;
        }

        foreach ($shopClients as $id => $shopClient) {
            $id = intval($id);
            if ($id > 0) {
                if (!Helpers_DB::dublicateObjectLanguage($model, $id, $sitePageData, $sitePageData->shopID)) {
                    continue;
                }

                if (key_exists('is_public', $shopClient)) {
                    $model->setIsPublic($shopClient['is_public']);
                }
                if (key_exists('name', $shopClient)) {
                    if (!empty($shopClient['name'])) {
                        $model->setName($shopClient['name']);
                    }
                }

                if (key_exists('text', $shopClient)) {
                    $model->setText($shopClient['text']);
                }

                if (key_exists('last_name', $shopClient)) {
                    $model->setLastName($shopClient['last_name']);
                }

                if (key_exists('remarketing', $shopClient)) {
                    $model->setRemarketing($shopClient['remarketing']);
                }

                if (key_exists('shop_table_rubric_id', $shopClient)) {
                    $model->setShopTableRubricID($shopClient['shop_table_rubric_id']);
                }
                if (key_exists('options', $shopClient)) {
                    $options = $shopClient['options'];
                    if (is_array($options)) {
                        $model->addOptionsArray($options);
                    }
                }
                if (key_exists('collations', $shopClient)) {
                    $options = $shopClient['collations'];
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

        $model = new Model_Shop_Client();
        $model->setDBDriver($driver);

        if (!Helpers_DB::dublicateObjectLanguage($model, $id, $sitePageData)) {
            throw new HTTP_Exception_500('Client not found.');
        }

        if(Request_RequestParams::getParamBoolean("is_undel") === TRUE){
            $model->dbUnDelete($sitePageData->userID, 0, $sitePageData->shopID);
        }else {
            $model->dbDelete($sitePageData->userID, 0, $sitePageData->shopID);
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
        $model = new Model_Shop_Client();
        $model->setDBDriver($driver);

        $id = Request_RequestParams::getParamInt('id');
        if($id > 0) {
            if (!Helpers_DB::dublicateObjectLanguage($model, $id, $sitePageData)) {
                throw new HTTP_Exception_500('Client not found.');
            }

            $type = $model->getShopTableCatalogID();
        }else{
            $type = Request_RequestParams::getParamInt('type');
            $model->setShopTableCatalogID($type);
        }


        $oldRubricID = $model->getShopTableRubricID();
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

            if($type > 0) {
                $modelType = new Model_Shop_Table_Catalog();
                $modelType->setDBDriver($driver);
                Helpers_DB::dublicateObjectLanguage($modelType, $type, $sitePageData);

                // сохраняем список хэштегов
                $hashtags = Request_RequestParams::getParamArray('shop_table_hashtags');
                if ($hashtags !== NULL) {
                    $model->setShopTableHashtagIDsArray(Api_Shop_Table_ObjectToObject::saveToHashtags(
                        Model_Shop_Client::TABLE_ID, $model->id, $model->getShopTableCatalogID(),
                        $hashtags, $modelType->getChildShopTableCatalogID('hashtag', $sitePageData->dataLanguageID),
                        $sitePageData, $driver));
                }
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

    /**
     * Получаем ID клиента по контакту или создаем клиента
     * @param $shopID
     * @param $contact
     * @param $clientContactTypeID
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @param bool $isCreateClient
     * @param string $clientName
     * @return mixed
     */
    public static function getShopClientIDByContact($shopID, $contact, $clientContactTypeID, SitePageData $sitePageData,
                                                    Model_Driver_DBBasicDriver $driver, $isCreateClient = FALSE, $clientName = '')
    {
        $params = Request_RequestParams::setParams(
            array(
                'name' => $contact,
                'client_contact_type_id' => $clientContactTypeID,

            )
        );
        $shopClientIDs = Request_Shop_ClientContact::findShopClientContactIDs($shopID, $sitePageData, $driver,
            $params, 1, TRUE);

        if(count($shopClientIDs->childs) > 0){
            return $shopClientIDs->childs[0]->values['shop_client_id'];
        }

        if($isCreateClient) {
            $modelClient = new Model_Shop_Client();
            $modelClient->setDBDriver($driver);
            $modelClient->setName($clientName);
            Helpers_DB::saveDBObject($modelClient, $sitePageData, $shopID);

            $model = new Model_Shop_Client_Contact();
            $model->setDBDriver($driver);
            $model->setName($contact);
            $model->setClientContactTypeID($clientContactTypeID);
            $model->setShopClientID($modelClient->id);
            Helpers_DB::saveDBObject($modelClient, $sitePageData, $shopID);

            return $modelClient->id;
        }

        return 0;
    }
}
