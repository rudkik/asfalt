<?php defined('SYSPATH') or die('No direct script access.');

class Api_Ab1_Shop_Product_Balance  {
    /**
     * Получаем остатки материала по подразделению
     * @param $shopProductID
     * @param $shopStorageID
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @return int|float
     */
    public static function getProductBalance($shopProductID, $shopStorageID,  SitePageData $sitePageData,
                                             Model_Driver_DBBasicDriver $driver, $shopID = 0)
    {
        if($shopID < 1){
            $shopID = $sitePageData->shopID;
        }

        $params = Request_RequestParams::setParams(
            array(
                'shop_product_id' => $shopProductID,
                'shop_storage_id' => $shopStorageID,
            )
        );
        $balance = Request_Request::findOne(
            'DB_Ab1_Shop_Product_Balance', $shopID, $sitePageData, $driver, $params
        );

        if($balance == null){
            return 0;
        }

        return floatval($balance->values['quantity']);
    }

    /**
     * Сохраняем остатки материала по подразделению
     * @param $quantity
     * @param $shopProductID
     * @param $shopStorageID
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @param int $shopID
     */
    public static function saveProductBalance($quantity, $shopProductID, $shopStorageID, SitePageData $sitePageData,
                                              Model_Driver_DBBasicDriver $driver, $shopID = 0)
    {
        if($shopID < 1){
            $shopID = $sitePageData->shopID;
        }

        $params = Request_RequestParams::setParams(
            array(
                'shop_product_id' => $shopProductID,
                'shop_storage_id' => $shopStorageID,
            )
        );
        $model = Request_Request::findOneModel(
            'DB_Ab1_Shop_Product_Balance', $shopID, $sitePageData, $driver, $params
        );

        if($model == null){
            $model = new Model_Ab1_Shop_Product_Balance();
            $model->setDBDriver($driver);

            $model->setShopProductID($shopProductID);
            $model->setShopStorageID($shopStorageID);
        }

        $model->setQuantity($quantity);

        Helpers_DB::saveDBObject($model, $sitePageData, $shopID);
    }
}
