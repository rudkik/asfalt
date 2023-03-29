<?php defined('SYSPATH') or die('No direct script access.');

class Api_Ab1_Shop_Bid  {
    /**
     * удаление
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

        $model = new Model_Ab1_Shop_Bid();
        $model->setDBDriver($driver);

        if (!Helpers_DB::dublicateObjectLanguage($model, $id, $sitePageData)) {
            throw new HTTP_Exception_500('Bid not found.');
        }

        if (($isUnDel && !$model->getIsDelete()) or (!$isUnDel && $model->getIsDelete())){
            return FALSE;
        }

        if ($isUnDel){
            $shopBidItemIDs = Request_Request::find('DB_Ab1_Shop_Bid_Item', $sitePageData->shopID, $sitePageData, $driver,
                array('shop_bid_id' => $id, 'is_delete' => 1, 'is_public' => 0, Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE));

            $driver->unDeleteObjectIDs($shopBidItemIDs->getChildArrayID(), $sitePageData->userID, Model_Ab1_Shop_Bid_Item::TABLE_NAME,
                array('is_public' => 1), $sitePageData->shopID);
        }else{
            $shopBidItemIDs = Request_Request::find('DB_Ab1_Shop_Bid_Item', $sitePageData->shopID, $sitePageData, $driver,
                array('shop_bid_id' => $id, Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE));

            $driver->deleteObjectIDs($shopBidItemIDs->getChildArrayID(), $sitePageData->userID, Model_Ab1_Shop_Bid_Item::TABLE_NAME,
                array('is_public' => 0), $sitePageData->shopID);
        }

        if($isUnDel){
            $model->dbUnDelete($sitePageData->userID, 0, $sitePageData->shopID);
        }else {
            $model->dbDelete($sitePageData->userID, 0, $sitePageData->shopID);
        }

        return TRUE;
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
        $model = new Model_Ab1_Shop_Bid();
        $model->setDBDriver($driver);

        $id = Request_RequestParams::getParamInt('id');
        if($id > 0) {
            if (!Helpers_DB::dublicateObjectLanguage($model, $id, $sitePageData)) {
                throw new HTTP_Exception_500('Bid not found.');
            }
        }

        Request_RequestParams::setParamBoolean('is_public', $model);
        Request_RequestParams::setParamStr('text', $model);
        Request_RequestParams::setParamStr('name', $model);
        Request_RequestParams::setParamStr("old_id", $model);

        Request_RequestParams::setParamInt("rejection_reason_id", $model);
        Request_RequestParams::setParamInt('shop_client_id', $model);
        Request_RequestParams::setParamInt('shop_product_id', $model);
        Request_RequestParams::setParamFloat('quantity', $model);
        Request_RequestParams::setParamFloat('delivery', $model);

        Request_RequestParams::setParamInt('month', $model);
        Request_RequestParams::setParamInt('year', $model);
        $model->setDate($model->getYear().'-'.$model->getMonth().'-01');

        $options = Request_RequestParams::getParamArray('options');
        if ($options !== NULL) {
            $model->addOptionsArray($options);
        }

        $result = array();
        if ($model->validationFields($result)) {
            if($model->id < 1) {
                Helpers_DB::saveDBObject($model, $sitePageData);
            }

            $shopBidItems = Request_RequestParams::getParamArray('shop_bid_items');
            if($shopBidItems !== NULL) {
               $model->setQuantity(
                   Api_Ab1_Shop_Bid_Item::save($model->id, $model->getShopClientID(), $model->getDate(), $shopBidItems, $sitePageData, $driver)
               );
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
