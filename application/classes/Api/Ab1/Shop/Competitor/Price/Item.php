<?php defined('SYSPATH') or die('No direct script access.');

class Api_Ab1_Shop_Competitor_Price_Item  {

    /**
     * Сохранение список цен прайс-листа конкурента
     * @param $shopCompetitorPriceID
     * @param $shopCompetitorID
     * @param $date
     * @param array $shopCompetitorPriceItems
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @return bool
     */
    public static function save($shopCompetitorPriceID, $shopCompetitorID, $date, array $shopCompetitorPriceItems,
                                SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        $model = new Model_Ab1_Shop_Competitor_Price_Item();
        $model->setDBDriver($driver);

        $params = Request_RequestParams::setParams(
            array(
                'shop_competitor_price_id' => $shopCompetitorPriceID,
            )
        );
        $shopCompetitorPriceItemIDs = Request_Request::find('DB_Ab1_Shop_Competitor_Price_Item',
            $sitePageData->shopID, $sitePageData, $driver, $params, 0, TRUE
        );

        foreach($shopCompetitorPriceItems as $shopCompetitorPriceItem){
            $shopProductID = intval(Arr::path($shopCompetitorPriceItem, 'shop_product_id', 0));
            if($shopProductID < 1){
                continue;
            }

            $price = Helpers_Array::pathFloat($shopCompetitorPriceItem, 'price', 0);
            if($price <= 0){
                continue;
            }

            $shopCompetitorPriceItemID = array_shift($shopCompetitorPriceItemIDs->childs);
            if($shopCompetitorPriceItemID !== NULL){
                $shopCompetitorPriceItemID->setModel($model);
            }else{
                $model->clear();
            }

            $model->setShopProductID($shopProductID);
            $model->setPrice($price);
            $model->setDelivery(Helpers_Array::pathFloat($shopCompetitorPriceItem, 'delivery', 0));
            $model->setDeliveryZHD(Helpers_Array::pathFloat($shopCompetitorPriceItem, 'delivery_zhd', 0));
            $model->setProductCapacity(Arr::path($shopCompetitorPriceItem, 'product_capacity', ''));

            $model->setDate($date);
            $model->setShopCompetitorPriceID($shopCompetitorPriceID);
            $model->setShopCompetitorID($shopCompetitorID);
            Helpers_DB::saveDBObject($model, $sitePageData);
        }

        // удаляем лишние
        $driver->deleteObjectIDs($shopCompetitorPriceItemIDs->getChildArrayID(), $sitePageData->userID,
            Model_Ab1_Shop_Competitor_Price_Item::TABLE_NAME, array(), $sitePageData->shopID);

        return TRUE;
    }
}
