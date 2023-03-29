<?php defined('SYSPATH') or die('No direct script access.');

class Api_AutoPart_Shop_Product_Source_Price
{
    /**
     * Сохраняем продажную цена на товары компании и источника продаж
     * @param $shopCompanyID
     * @param $commission
     * @param $price
     * @param $positionNumber
     * @param $positionCount
     * @param Model_AutoPart_Shop_Product_Source $modelSource
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     */
    public static function savePrices($shopCompanyID, $commission, $price,
                                      $positionNumber, $positionCount,
                                      Model_AutoPart_Shop_Product_Source $modelSource,
                                      SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver){

        /** @var Model_AutoPart_Shop_Product_Source_Price $model */
        $model = Request_Request::findOneModel(
            DB_AutoPart_Shop_Product_Source_Price::NAME, $sitePageData->shopID, $sitePageData, $driver,
            Request_RequestParams::setParams(
                [
                    'shop_source_id' => $modelSource->getShopSourceID(),
                    'shop_company_id' => $shopCompanyID,
                    'shop_product_id' => $modelSource->getShopProductID(),
                ]
            )
        );
        if($model == false) {
            $model = new Model_AutoPart_Shop_Product_Source_Price();
            $model->setDBDriver($driver);

            $model->setShopSourceID($modelSource->getShopSourceID());
            $model->setShopCompanyID($shopCompanyID);
            $model->setShopProductID($modelSource->getShopProductID());
        }

        $model->setCommission($commission);
        $model->setPrice($price);
        $model->setPriceCost($modelSource->getPriceCost());
        $model->setProfit($price - $model->getPriceCost()- round($price / 100 * $commission));

        $model->setPriceSource($modelSource->getPriceSource());
        $model->setPriceMin($modelSource->getPriceMin());
        $model->setPriceMax($modelSource->getPriceMax());

        $model->setShopRubricSourceID($modelSource->getShopRubricSourceID());
        $model->setShopProductSourceID($modelSource->id);

        $model->setPositionNumber($positionNumber);
        $model->setPositionCount($positionCount);

        Helpers_DB::saveDBObject($model, $sitePageData, $modelSource->shopID);
    }
}