<?php defined('SYSPATH') or die('No direct script access.');

class Api_Ab1_Shop_Delivery_Discount  {
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

        $model = new Model_Ab1_Shop_Pricelist();
        $model->setDBDriver($driver);

        if (!Helpers_DB::dublicateObjectLanguage($model, $id, $sitePageData)) {
            throw new HTTP_Exception_500('Discount not found.');
        }

        if (($isUnDel && !$model->getIsDelete()) or (!$isUnDel && $model->getIsDelete())){
            return FALSE;
        }

        // удаляем записи
        if ($isUnDel){
            $shopDeliveryDiscountItemIDs = Request_Request::find('DB_Ab1_Shop_Delivery_Discount_Item',
                $sitePageData->shopMainID, $sitePageData, $driver,
                array('shop_delivery_discount_id' => $id, 'is_delete' => 1, 'is_public' => 0, Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE)
            );

            $driver->unDeleteObjectIDs(
                $shopDeliveryDiscountItemIDs->getChildArrayID(), $sitePageData->userID, Model_Ab1_Shop_Delivery_Discount::TABLE_NAME,
                array('is_public' => 1), $sitePageData->shopMainID
            );

            $model->dbUnDelete($sitePageData->userID, 0, $sitePageData->shopMainID);
        }else{
            $shopDeliveryDiscountItemIDs = Request_Request::find('DB_Ab1_Shop_Piece_Item',
                $sitePageData->shopMainID, $sitePageData, $driver,
                array('shop_delivery_discount_id' => $id, Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE)
            );

            $driver->deleteObjectIDs(
                $shopDeliveryDiscountItemIDs->getChildArrayID(), $sitePageData->userID, Model_Ab1_Shop_Delivery_Discount_Item::TABLE_NAME,
                array('is_public' => 0), $sitePageData->shopMainID
            );

            $model->dbDelete($sitePageData->userID, 0, $sitePageData->shopMainID);
        }

        if(Request_RequestParams::getParamBoolean("is_undel") === TRUE){
            $model->dbUnDelete($sitePageData->userID, 0, $sitePageData->shopMainID);
        }else {
            $model->dbDelete($sitePageData->userID, 0, $sitePageData->shopMainID);
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
        $model = new Model_Ab1_Shop_Delivery_Discount();
        $model->setDBDriver($driver);

        $id = Request_RequestParams::getParamInt('id');
        if($id > 0) {
            if (!Helpers_DB::dublicateObjectLanguage($model, $id, $sitePageData, $sitePageData->shopMainID)) {
                throw new HTTP_Exception_500('Discount not found.');
            }
        }

        Request_RequestParams::setParamBoolean('is_public', $model);
        Request_RequestParams::setParamStr('text', $model);
        Request_RequestParams::setParamStr('name', $model);
        Request_RequestParams::setParamStr("old_id", $model);
        Request_RequestParams::setParamInt('shop_client_id', $model);
        Request_RequestParams::setParamDateTime('from_at', $model);
        Request_RequestParams::setParamDateTime('to_at', $model);

        $options = Request_RequestParams::getParamArray('options');
        if ($options !== NULL) {
            $model->addOptionsArray($options);
        }

        $result = array();
        if ($model->validationFields($result)) {
            if($model->id < 1) {
                Helpers_DB::saveDBObject($model, $sitePageData, $sitePageData->shopMainID);
            }

            // загружаем фотографии и файлы
            DB_Basic::saveFiles($model, $sitePageData, $driver);

            $shopDeliveryPrices = Request_RequestParams::getParamArray('shop_delivery_discount_items');
            if ($shopDeliveryPrices !== NULL) {
                Api_Ab1_Shop_Delivery_Discount_Item::save(
                    $model->id, $model->getShopClientID(), $model->getFromAt(), $model->getToAt(), $shopDeliveryPrices,
                    $sitePageData, $driver
                );
            }

            Helpers_DB::saveDBObject($model, $sitePageData, $sitePageData->shopMainID);
            $result['values'] = $model->getValues();
        }

        return array(
            'id' => $model->id,
            'result' => $result,
        );
    }
}
