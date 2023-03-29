<?php defined('SYSPATH') or die('No direct script access.');

class Api_Shop_AddressContact  {

    /**
     * Сохранение списка товаров
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     */
    public static function saveListCollations($shopTableCatalogID, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        $model = new Model_Shop_AddressContact();
        $model->setDBDriver($driver);

        $shopAddressContacts = Request_RequestParams::getParamArray('data', array());
        foreach ($shopAddressContacts as &$shopAddressContact) {
            $model->clear();

            $id = intval(Arr::path($shopAddressContact, 'shop_address_contact_id', 0));
            if ($id > 0) {
                if (!Helpers_DB::dublicateObjectLanguage($model, $id, $sitePageData, $sitePageData->shopID)) {
                    continue;
                }
            } else {
                $model->setShopTableCatalogID($shopTableCatalogID);
            }

            if($id < 1) {
                if (key_exists('is_public', $shopAddressContact)) {
                    $model->setIsPublic($shopAddressContact['is_public']);
                }
                if (key_exists('collations', $shopAddressContact)) {
                    $model->addCollationsArray($shopAddressContact['collations']);
                }
                if (key_exists('old_id', $shopAddressContact)) {
                    $model->setOldID($shopAddressContact['old_id']);
                }
                if (key_exists('name', $shopAddressContact)) {
                    if (!empty($shopAddressContact['name'])) {
                        $model->setName($shopAddressContact['name']);
                    }
                }
                if (key_exists('text', $shopAddressContact)) {
                    $model->setText($shopAddressContact['text']);
                }
            }

            $options = array();
            foreach($shopAddressContact as $k => $v){
                if(strpos($k, 'options.') === 0){
                    $options[str_replace('options.', '', $k)] = $v;
                }
            }
            $model->addOptionsArray($options, FALSE);

            if (key_exists('price', $shopAddressContact)) {
                $model->setPrice($shopAddressContact['price']);
            }

            $shopAddressContact['shop_address_contact_id'] = Helpers_DB::saveDBObject($model, $sitePageData, $sitePageData->shopID);
            $shopAddressContact['shop_address_contact_name'] = $model->getName();
        }

        return $shopAddressContacts;
    }

    /**
     * Сохранение списка товаров
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     */
    public static function saveList(SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        $model = new Model_Shop_AddressContact();
        $model->setDBDriver($driver);

        $shopAddressContacts = Request_RequestParams::getParamArray('shop_address_contacts', array());
        if ($shopAddressContacts === NULL) {
            return FALSE;
        }

        foreach ($shopAddressContacts as $id => $shopAddressContact) {
            $id = intval($id);
            if ($id > 0) {
                if (!Helpers_DB::dublicateObjectLanguage($model, $id, $sitePageData, $sitePageData->shopID)) {
                    continue;
                }

                if (key_exists('is_public', $shopAddressContact)) {
                    $model->setIsPublic($shopAddressContact['is_public']);
                }
                if (key_exists('name', $shopAddressContact)) {
                    if (!empty($shopAddressContact['name'])) {
                        $model->setName($shopAddressContact['name']);
                    }
                }

                if (key_exists('text', $shopAddressContact)) {
                    $model->setText($shopAddressContact['text']);
                }

                if (key_exists('shop_table_rubric_id', $shopAddressContact)) {
                    $model->setShopTableRubricID($shopAddressContact['shop_table_rubric_id']);
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

        $model = new Model_Shop_AddressContact();
        $model->setDBDriver($driver);

        if (!Helpers_DB::dublicateObjectLanguage($model, $id, $sitePageData)) {
            throw new HTTP_Exception_500('Contact not found.');
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
        $model = new Model_Shop_AddressContact();
        $model->setDBDriver($driver);

        $id = Request_RequestParams::getParamInt('id');
        if($id > 0) {
            if (!Helpers_DB::dublicateObjectLanguage($model, $id, $sitePageData)) {
                throw new HTTP_Exception_500('Contact not found.');
            }
        }

        Request_RequestParams::setParamInt("shop_table_rubric_id", $model);
        Request_RequestParams::setParamBoolean('is_public', $model);
        Request_RequestParams::setParamStr('text', $model);
        Request_RequestParams::setParamStr('name', $model);
        Request_RequestParams::setParamInt("land_id", $model);
        Request_RequestParams::setParamInt("city_id", $model);
        Request_RequestParams::setParamInt("contact_type_id", $model);
        Request_RequestParams::setParamInt("order", $model);
        Request_RequestParams::setParamStr("old_id", $model);
        Request_RequestParams::setParamInt("shop_table_select_id", $model);
        Request_RequestParams::setParamInt('shop_address_id', $model);

        if ($model->getShopAddressID() == 0){
            $model->setShopAddressID(Request_Shop_Address::getMainAddressID($sitePageData->shopID, $sitePageData, $driver));
        }

        $landIDs = Request_RequestParams::getParamArray('land_ids');
        if($landIDs !== NULL) {
            $model->setLandIDsArray($landIDs);
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
}
