<?php defined('SYSPATH') or die('No direct script access.');

class Api_Hotel_Shop_Feast  {

    /**
     * удаление праздников
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @param int $id
     * @return bool
     * @throws HTTP_Exception_500
     */
    public static function delete(SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver, $id = 0)
    {
        if ($id < 1) {
            $id = Request_RequestParams::getParamInt('id');
            if ($id < 0) {
                return FALSE;
            }
        }

        $model = new Model_Hotel_Shop_Feast();
        $model->setDBDriver($driver);

        if (!Helpers_DB::dublicateObjectLanguage($model, $id, $sitePageData)) {
            throw new HTTP_Exception_500('Feast not found.');
        }

        if(Request_RequestParams::getParamBoolean("is_undel") === TRUE){
            $model->dbUnDelete($sitePageData->userID, 0, $sitePageData->shopID);

            $shopFeastDayIDs = Request_Request::find('DB_Hotel_Shop_Feast_Day', $sitePageData->shopID, $sitePageData, $driver,
                array('shop_feast_id' => $id, 'is_delete_ignore' => TRUE, 'old_id' => 1, Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE));
            $driver->unDeleteObjectIDs($shopFeastDayIDs->getChildArrayID(), $sitePageData->userID, Model_Hotel_Shop_Feast_Day::TABLE_NAME);
        }else {
            $model->dbDelete($sitePageData->userID, 0, $sitePageData->shopID);

            $shopFeastDayIDs = Request_Request::find('DB_Hotel_Shop_Feast_Day', $sitePageData->shopID, $sitePageData, $driver,
                array('shop_feast_id' => $id, Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE));
            $driver->deleteObjectIDs($shopFeastDayIDs->getChildArrayID(), $sitePageData->userID, Model_Hotel_Shop_Feast_Day::TABLE_NAME,
                array('old_id' => 1));
        }

        return TRUE;
    }

    /**
     * Сохранение товары
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @throws HTTP_Exception_500
     */
    public static function save(SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        $model = new Model_Hotel_Shop_Feast();
        $model->setDBDriver($driver);

        $id = Request_RequestParams::getParamInt('id');
        if($id > 0) {
            if (!Helpers_DB::dublicateObjectLanguage($model, $id, $sitePageData)) {
                throw new HTTP_Exception_500('Feast not found.');
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

        Request_RequestParams::setParamDateTime('date_from', $model);
        Request_RequestParams::setParamDateTime('date_to', $model);

        $options = Request_RequestParams::getParamArray('options');
        if ($options !== NULL) {
            $model->addOptionsArray($options);
        }

        $result = array();
        if ($model->validationFields($result)) {
            if($model->id < 1) {
                Helpers_DB::saveDBObject($model, $sitePageData);
            }

            Api_Hotel_Shop_Feast_Day::save($model->id, $model->getDateFrom(), $model->getDateTo(), $sitePageData, $driver);

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
                        Model_Hotel_Shop_Feast::TABLE_ID, $model->id, $model->getShopTableCatalogID(),
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
