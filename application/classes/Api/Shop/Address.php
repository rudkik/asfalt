<?php defined('SYSPATH') or die('No direct script access.');

class Api_Shop_Address  {

    /**
     * Сохранение списка товаров
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     */
    public static function saveListCollations(SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        $model = new Model_Shop_Address();
        $model->setDBDriver($driver);

        $shopAddresses = Request_RequestParams::getParamArray('data', array());
        foreach ($shopAddresses as &$shopAddress) {
            $model->clear();

            $id = intval(Arr::path($shopAddress, 'shop_address_id', 0));
            if ($id > 0) {
                if (!Helpers_DB::dublicateObjectLanguage($model, $id, $sitePageData, $sitePageData->shopID)) {
                    continue;
                }
            }

            if($id < 1) {
                if (key_exists('is_public', $shopAddress)) {
                    $model->setIsPublic($shopAddress['is_public']);
                }
                if (key_exists('old_id', $shopAddress)) {
                    $model->setOldID($shopAddress['old_id']);
                }
                if (key_exists('name', $shopAddress)) {
                    if (!empty($shopAddress['name'])) {
                        $model->setName($shopAddress['name']);
                    }
                }
                if (key_exists('text', $shopAddress)) {
                    $model->setText($shopAddress['text']);
                }
            }

            $shopAddress['shop_address_id'] = Helpers_DB::saveDBObject($model, $sitePageData, $sitePageData->shopID);
            $shopAddress['shop_address_name'] = $model->getName();
        }

        return $shopAddresses;
    }

    /**
     * Сохранение списка товаров
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     */
    public static function saveList(SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        $model = new Model_Shop_Address();
        $model->setDBDriver($driver);

        $shopAddresses = Request_RequestParams::getParamArray('shop_addresss', array());
        if ($shopAddresses === NULL) {
            return FALSE;
        }

        foreach ($shopAddresses as $id => $shopAddress) {
            $id = intval($id);
            if ($id > 0) {
                if (!Helpers_DB::dublicateObjectLanguage($model, $id, $sitePageData, $sitePageData->shopID)) {
                    continue;
                }

                if (key_exists('is_public', $shopAddress)) {
                    $model->setIsPublic($shopAddress['is_public']);
                }
                if (key_exists('name', $shopAddress)) {
                    if (!empty($shopAddress['name'])) {
                        $model->setName($shopAddress['name']);
                    }
                }

                if (key_exists('text', $shopAddress)) {
                    $model->setText($shopAddress['text']);
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

        $model = new Model_Shop_Address();
        $model->setDBDriver($driver);

        if (!Helpers_DB::dublicateObjectLanguage($model, $id, $sitePageData)) {
            throw new HTTP_Exception_500('Address not found.');
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
        $model = new Model_Shop_Address();
        $model->setDBDriver($driver);

        $id = Request_RequestParams::getParamInt('id');
        if($id > 0) {
            if (!Helpers_DB::dublicateObjectLanguage($model, $id, $sitePageData)) {
                throw new HTTP_Exception_500('Address not found.');
            }
        }

        Request_RequestParams::setParamInt("shop_table_rubric_id", $model);
        Request_RequestParams::setParamBoolean('is_main_shop', $model);
        Request_RequestParams::setParamInt('land_id', $model);
        Request_RequestParams::setParamInt('city_id', $model);
        Request_RequestParams::setParamStr('street', $model);
        Request_RequestParams::setParamStr('street_conv', $model);
        Request_RequestParams::setParamStr('house', $model);
        Request_RequestParams::setParamStr('office', $model);
        Request_RequestParams::setParamStr('address', $model);
        Request_RequestParams::setParamStr('map_data', $model);
        Request_RequestParams::setParamInt('map_type_id', $model);
        Request_RequestParams::setParamStr('name', $model);
        Request_RequestParams::setParamStr('comment', $model);
        Request_RequestParams::setParamBoolean('is_public', $model);

        $isTranslate = Request_RequestParams::getParamBoolean('is_translate');
        if($isTranslate !== NULL) {
            $model->setIsTranslatesCurrentLanguage($isTranslate, $sitePageData->dataLanguageID, $sitePageData->shop->getLanguageIDsArray());
        }

        $landIDs = Request_RequestParams::getParamArray('land_ids');
        if($landIDs !== NULL) {
            $model->setLandIDsArray($landIDs);
        }

        // если это главный адрес, то находит id
        if ($model->getIsMainShop()){
            $model->id = Request_Shop_Address::getMainAddressID($sitePageData->shopID, $sitePageData, $driver);
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
