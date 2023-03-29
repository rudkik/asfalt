<?php defined('SYSPATH') or die('No direct script access.');

class Api_Ab1_Shop_Product_Delivery  {

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

        $model = new Model_Ab1_Shop_Product_Delivery();
        $model->setDBDriver($driver);

        if (!Helpers_DB::dublicateObjectLanguage($model, $id, $sitePageData, $sitePageData->shopMainID)) {
            throw new HTTP_Exception_500('Product delivery not found.');
        }

        if(Request_RequestParams::getParamBoolean("is_undel") === TRUE){
            $model->dbUnDelete($sitePageData->userID, 0, $sitePageData->shopMainID);
        }else {
            $model->dbDelete($sitePageData->userID, 0, $sitePageData->shopMainID);
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
        $model = new Model_Ab1_Shop_Product_Delivery();
        $model->setDBDriver($driver);

        $id = Request_RequestParams::getParamInt('id');
        if($id > 0) {
            if (!Helpers_DB::dublicateObjectLanguage($model, $id, $sitePageData, $sitePageData->shopMainID)) {
                throw new HTTP_Exception_500('Product delivery not found.');
            }
        }

        Request_RequestParams::setParamBoolean('is_public', $model);

        Request_RequestParams::setParamInt('shop_product_id', $model);
        Request_RequestParams::setParamInt('shop_delivery_id', $model);

        $result = array();
        if ($model->validationFields($result)) {
            Helpers_DB::saveDBObject($model, $sitePageData, $sitePageData->shopMainID);
            $result['values'] = $model->getValues();
        }

        return array(
            'id' => $id,
            'result' => $result,
        );
    }


    /**
     * Сохранение товары
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @throws HTTP_Exception_500
     */
    public static function saveList(SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        $shopProductID = Request_RequestParams::getParamInt('shop_product_id');
        if ($shopProductID < 1) {
            throw new HTTP_Exception_500('Product not found.');
        }

        $shopDeliveries = Request_RequestParams::getParamArray('shop_delivery_ids');
        if ($shopDeliveries === NULL) {
            return FALSE;
        }

        $shopProductDeliveryIDs = Request_Request::find('DB_Ab1_Shop_Product_Delivery', $sitePageData->shopMainID, $sitePageData, $driver,
            array('shop_product_id' => $shopProductID, Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE), 0, TRUE);

        $model = new Model_Ab1_Shop_Product_Delivery();
        $model->setDBDriver($driver);

        foreach ($shopDeliveries as $id => $value) {
            if($value < 1){
                continue;
            }
            $id = floatval($id);
            if ($id < 1) {
                continue;
            }

            $model->clear();
            $shopProductDeliveryID = array_shift($shopProductDeliveryIDs->childs);
            if($shopProductDeliveryID !== NULL){
                $model->__setArray(array('values' => $shopProductDeliveryID->values));
            }

            $model->setShopDeliveryID($id);
            $model->setShopProductID($shopProductID);
            Helpers_DB::saveDBObject($model, $sitePageData);
        }
        $driver->deleteObjectIDs($shopProductDeliveryIDs->getChildArrayID(TRUE), $sitePageData->userID,
            Model_Ab1_Shop_Product_Price::TABLE_NAME, array(), $sitePageData->shopMainID);

        return array(
            'shop_product_id' => $shopProductID,
        );
    }
}
