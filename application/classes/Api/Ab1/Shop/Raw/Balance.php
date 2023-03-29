<?php defined('SYSPATH') or die('No direct script access.');

class Api_Ab1_Shop_Raw_Balance  {
    /**
     * Получаем остатки сырья по подразделению
     * @param $shopRawID
     * @param $shopSubdivisionID
     * @param $shopHeapID
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @return int|float
     */
    public static function getRawBalance($shopRawID, $shopSubdivisionID, $shopHeapID,
                                         SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        $params = Request_RequestParams::setParams(
            array(
                'shop_raw_id' => $shopRawID,
                'shop_subdivision_id' => $shopSubdivisionID,
                'shop_heap_id' => $shopHeapID,
            )
        );
        $balance = Request_Request::findOne(
            'DB_Ab1_Shop_Raw_Balance', $sitePageData->shopID, $sitePageData, $driver, $params
        );

        if($balance == null){
            return 0;
        }

        return floatval($balance->values['quantity']);
    }

    /**
     * Сохраняем остатки сырья по подразделению
     * @param $quantity
     * @param $shopRawID
     * @param $shopSubdivisionID
     * @param $shopHeapID
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @param int $shopID
     */
    public static function saveRawBalance($quantity, $shopRawID, $shopSubdivisionID, $shopHeapID,
                                               SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver, $shopID = 0)
    {
        if($shopID < 1){
            $shopID = $sitePageData->shopID;
        }

        $params = Request_RequestParams::setParams(
            array(
                'shop_raw_id' => $shopRawID,
                'shop_subdivision_id' => $shopSubdivisionID,
                'shop_heap_id' => $shopHeapID,
            )
        );
        $model = Request_Request::findOneModel(
            'DB_Ab1_Shop_Raw_Balance', $shopID, $sitePageData, $driver, $params
        );

        if($model == null){
            $model = new Model_Ab1_Shop_Raw_Balance();
            $model->setDBDriver($driver);

            $model->setShopRawID($shopRawID);
            $model->setShopSubdivisionID($shopSubdivisionID);
            $model->setShopHeapID($shopHeapID);
        }

        $model->setQuantity($quantity);

        Helpers_DB::saveDBObject($model, $sitePageData);

    }
}
