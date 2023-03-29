<?php defined('SYSPATH') or die('No direct script access.');

class Api_Shop_Good_To_Operation  {

    /**
     * Сохранение цены оператору
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @throws HTTP_Exception_500
     */
    public static function saveOperation(SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        $model = new Model_Shop_Good_To_Operation();
        $model->setDBDriver($driver);

        $shopOperationID = Request_RequestParams::getParamInt('shop_operation_id');
        if($shopOperationID < 1){
            throw new HTTP_Exception_500('Operation not found.');
        }

        // получаем текущие
        $goodToOperationIDs = Request_Request::find('DB_Shop_Good_To_Operation', $sitePageData->shopID, $sitePageData, $driver,
            array('is_delete_public_ignore' => TRUE, 'shop_operation_id' => $shopOperationID, Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE), 0, TRUE);

        $shopGoods = Request_RequestParams::getParamArray('shop_goods', array(), array());
        foreach($shopGoods as $shopGoodID => $price){
            $shopGoodID = intval($shopGoodID);
            $price = floatval($price);
            if($shopGoodID < 1){
                continue;
            }

            $model->clear();
            $goodToOperationID = array_shift($goodToOperationIDs->childs);
            if($goodToOperationID !== NULL){
                $model->__setArray(array('values' => $goodToOperationID->values));
            }

            $model->setShopOperationID($shopOperationID);
            $model->setShopGoodID($shopGoodID);
            $model->setPrice($price);
            Helpers_DB::saveDBObject($model, $sitePageData);
        }

        // удаляем лишние
        $driver->deleteObjectIDs($goodToOperationIDs->getChildArrayID(), $sitePageData->userID,
            Model_Shop_Good_To_Operation::TABLE_NAME, array(), $sitePageData->shopID);

        return array(
            'shop_operation_id' => $shopOperationID,
            'result' => array('error' => FALSE),
        );
    }

    /**
     * Сохранение цены товару
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @throws HTTP_Exception_500
     */
    public static function saveGood(SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        $model = new Model_Shop_Good_To_Operation();
        $model->setDBDriver($driver);

        $shopGoodID = Request_RequestParams::getParamInt('shop_good_id');
        if($shopGoodID < 1){
            throw new HTTP_Exception_500('Goods not found.');
        }

        // получаем текущие
        $goodToOperationIDs = Request_Request::find('DB_Shop_Good_To_Operation', $sitePageData->shopID, $sitePageData, $driver,
            array('is_delete_public_ignore' => TRUE, 'shop_good_id' => $shopGoodID, Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE), 0, TRUE);

        //
        $shopGoods = Request_RequestParams::getParamArray('shop_goods', array(), array());
        foreach($shopGoods as $shopOperationID => $price){
            $shopOperationID = intval($shopOperationID);
            $price = floatval($price);
            if($shopOperationID < 1){
                continue;
            }

            $model->clear();
            $goodToOperationID = array_shift($goodToOperationIDs->childs);
            if($goodToOperationID !== NULL){
                $model->__setArray(array('values' => $goodToOperationID->values));
            }

            $model->setShopOperationID($shopOperationID);
            $model->setShopGoodID($shopGoodID);
            $model->setPrice($price);
            Helpers_DB::saveDBObject($model, $sitePageData);
        }

        // удаляем лишние
        $driver->deleteObjectIDs($goodToOperationIDs->getChildArrayID(), $sitePageData->userID,
            Model_Shop_Good_To_Operation::TABLE_NAME, array(), $sitePageData->shopID);

        return array(
            'shop_good_id' => $shopGoodID,
            'result' => array('error' => FALSE),
        );
    }
}
