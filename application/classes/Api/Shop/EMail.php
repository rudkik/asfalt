<?php defined('SYSPATH') or die('No direct script access.');

class Api_Shop_EMail  {

    /**
     * Сохранение списка товаров
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     */
    public static function saveListCollations($shopTableCatalogID, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        $model = new Model_Shop_EMail();
        $model->setDBDriver($driver);

        $shopEMails = Request_RequestParams::getParamArray('data', array());
        foreach ($shopEMails as &$shopEMail) {
            $model->clear();

            $id = intval(Arr::path($shopEMail, 'shop_good_id', 0));
            if ($id > 0) {
                if (!Helpers_DB::dublicateObjectLanguage($model, $id, $sitePageData, $sitePageData->shopID)) {
                    continue;
                }
            } else {
                $model->setShopTableCatalogID($shopTableCatalogID);
            }

            if($id < 1) {
                if (key_exists('is_public', $shopEMail)) {
                    $model->setIsPublic($shopEMail['is_public']);
                }
                if (key_exists('old_id', $shopEMail)) {
                    $model->setOldID($shopEMail['old_id']);
                }
                if (key_exists('name', $shopEMail)) {
                    if (!empty($shopEMail['name'])) {
                        $model->setName($shopEMail['name']);
                    }
                }
                if (key_exists('text', $shopEMail)) {
                    $model->setText($shopEMail['text']);
                }
            }

            $shopEMail['shop_good_id'] = Helpers_DB::saveDBObject($model, $sitePageData, $sitePageData->shopID);
            $shopEMail['shop_good_name'] = $model->getName();
        }

        return $shopEMails;
    }

    /**
     * Сохранение списка товаров
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     */
    public static function saveList(SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        $model = new Model_Shop_EMail();
        $model->setDBDriver($driver);

        $shopEMails = Request_RequestParams::getParamArray('shop_goods', array());
        if ($shopEMails === NULL) {
            return FALSE;
        }

        foreach ($shopEMails as $id => $shopEMail) {
            $id = intval($id);
            if ($id > 0) {
                if (!Helpers_DB::dublicateObjectLanguage($model, $id, $sitePageData, $sitePageData->shopID)) {
                    continue;
                }
                if (key_exists('is_public', $shopEMail)) {
                    $model->setIsPublic($shopEMail['is_public']);
                }
                if (key_exists('name', $shopEMail)) {
                    if (!empty($shopEMail['name'])) {
                        $model->setName($shopEMail['name']);
                    }
                }
                if (key_exists('text', $shopEMail)) {
                    $model->setText($shopEMail['text']);
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

        $model = new Model_Shop_EMail();
        $model->setDBDriver($driver);

        if (!Helpers_DB::dublicateObjectLanguage($model, $id, $sitePageData)) {
            throw new HTTP_Exception_500('E-mail not found.');
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
        $model = new Model_Shop_EMail();
        $model->setDBDriver($driver);

        $id = Request_RequestParams::getParamInt('id');
        if($id > 0) {
            if (!Helpers_DB::dublicateObjectLanguage($model, $id, $sitePageData)) {
                throw new HTTP_Exception_500('E-mail not found.');
            }
        }

        Request_RequestParams::setParamBoolean('is_public', $model);
        Request_RequestParams::setParamStr('text', $model);
        Request_RequestParams::setParamStr('name', $model);
        Request_RequestParams::setParamInt("email_type_id", $model);

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
