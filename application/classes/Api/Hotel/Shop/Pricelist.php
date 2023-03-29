<?php defined('SYSPATH') or die('No direct script access.');

class Api_Hotel_Shop_Pricelist  {
    /**
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @return array
     * @throws HTTP_Exception_500
     */
    public static function save(SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        $model = new Model_Hotel_Shop_Pricelist();
        $model->setDBDriver($driver);

        $id = Request_RequestParams::getParamInt('id');
        if($id > 0) {
            if (!Helpers_DB::dublicateObjectLanguage($model, $id, $sitePageData)) {
                throw new HTTP_Exception_500('Pricelist not found.');
            }
        }

        Request_RequestParams::setParamBoolean('is_public', $model);
        Request_RequestParams::setParamStr('text', $model);
        Request_RequestParams::setParamStr('name', $model);
        Request_RequestParams::setParamStr("old_id", $model);
        Request_RequestParams::setParamDateTime('date_from', $model);
        Request_RequestParams::setParamDateTime('date_to', $model);

        $result = array();
        if ($model->validationFields($result)) {
            if($model->id < 1) {
                Helpers_DB::saveDBObject($model, $sitePageData);
            }

            // загружаем фотографии
            $file = new Model_File($sitePageData);
            $file->saveFiles(Request_RequestParams::getParamArray('files'), $model, $sitePageData, $driver);

            $shopPricelistItems = Request_RequestParams::getParamArray('shop_pricelist_items');
            if($shopPricelistItems !== NULL) {
                Api_Hotel_Shop_Pricelist_Item::save($model->id, $model->getDateFrom(), $model->getDateTo(),
                    $shopPricelistItems, $sitePageData, $driver);
            }

            Helpers_DB::saveDBObject($model, $sitePageData);
            $result['values'] = $model->getValues();
        }

        return array(
            'id' => $model->id,
            'result' => $result,
        );
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

        $isUnDel = Request_RequestParams::getParamBoolean("is_undel");

        $model = new Model_Hotel_Shop_Pricelist();
        $model->setDBDriver($driver);

        if (!Helpers_DB::dublicateObjectLanguage($model, $id, $sitePageData)) {
            throw new HTTP_Exception_500('Pricelist not found.');
        }

        if (($isUnDel && !$model->getIsDelete()) or (!$isUnDel && $model->getIsDelete())){
            return FALSE;
        }

        // удаляем записи о купленных товаров
        if ($isUnDel){
            $shopPieceItemIDs = Request_Request::find('DB_Hotel_Shop_Pricelist_Item', $sitePageData->shopID, $sitePageData, $driver,
                array('shop_pricelist_id' => $id, 'is_delete' => 1, 'is_public' => 0, Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE));

            $driver->unDeleteObjectIDs($shopPieceItemIDs->getChildArrayID(), $sitePageData->userID, Model_Hotel_Shop_Pricelist_Item::TABLE_NAME,
                array('is_public' => 1), $sitePageData->shopID);

            $model->dbUnDelete($sitePageData->userID, 0, $sitePageData->shopID);
        }else{
            $shopPieceItemIDs = Request_Request::find('DB_Hotel_Shop_Pricelist_Item', $sitePageData->shopID, $sitePageData, $driver,
                array('shop_pricelist_id' => $id, Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE));

            $driver->deleteObjectIDs($shopPieceItemIDs->getChildArrayID(), $sitePageData->userID, Model_Hotel_Shop_Pricelist_Item::TABLE_NAME,
                array('is_public' => 0), $sitePageData->shopID);

            $model->dbDelete($sitePageData->userID, 0, $sitePageData->shopID);
        }

        return TRUE;
    }
}