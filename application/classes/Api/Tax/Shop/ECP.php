<?php defined('SYSPATH') or die('No direct script access.');

class Api_Tax_Shop_ECP  {

    /**
     * Сохраняем ЭЦП
     * @param $id
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @return array
     * @throws HTTP_Exception_500
     */
    public static function save($id, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        $model = new Model_Tax_Shop_ECP();
        $model->setDBDriver($driver);

        if($id > 0) {
            if (!Helpers_DB::dublicateObjectLanguage($model, $id, $sitePageData)) {
                throw new HTTP_Exception_500('ECP not found.');
            }

            $type = $model->getShopTableCatalogID();
        }else{
            $type = Request_RequestParams::getParamInt('type');
            $model->setShopTableCatalogID($type);
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

        Request_RequestParams::setParamStr('auth_password', $model);
        Request_RequestParams::setParamStr('gostknca_password', $model);

        $options = Request_RequestParams::getParamArray('options');
        if ($options !== NULL) {
            $model->addOptionsArray($options);
        }

        // файл авторизации
        if (key_exists('file_auth', $_FILES)){
            $fileAuth = $_FILES['file_auth'];

            $pathInfo = pathinfo($fileAuth['name']);
            if ((key_exists('extension', $pathInfo)) && ($pathInfo['extension'] == 'p12')){

                $newFilePath = 'ecp' . DIRECTORY_SEPARATOR . $sitePageData->shopID . DIRECTORY_SEPARATOR;
                Helpers_Path::createPath(DOCROOT . $newFilePath);

                if (move_uploaded_file($fileAuth['tmp_name'], DOCROOT . $newFilePath . 'auth.p12')) {
                    $model->setAuthFile('/' . str_replace('\\', '/', $newFilePath . 'auth.p12'));
                    $model->setAuthName($fileAuth['name']);
                }
            }
        }

        // файл авторизации
        if (key_exists('file_gostknca', $_FILES)){
            $fileGostknca = $_FILES['file_gostknca'];

            $pathInfo = pathinfo($fileGostknca['name']);
            if ((key_exists('extension', $pathInfo)) && ($pathInfo['extension'] == 'p12')){
                $newFilePath = 'ecp' . DIRECTORY_SEPARATOR . $sitePageData->shopID . DIRECTORY_SEPARATOR;
                Helpers_Path::createPath(DOCROOT . $newFilePath);

                if (move_uploaded_file($fileGostknca['tmp_name'], DOCROOT . $newFilePath . 'gostknca.p12')) {
                    $model->setGostkncaFile('/' . str_replace('\\', '/', $newFilePath . 'gostknca.p12'));
                    $model->setGostkncaName($fileGostknca['name']);
                }
            }
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
                        Model_Tax_Shop_ECP::TABLE_ID, $model->id, $model->getShopTableCatalogID(),
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
}
