<?php defined('SYSPATH') or die('No direct script access.');

class Api_AutoPart_Shop_Product_Join
{
    /**
     * Добавить статистику по оператору для распознования
     * @param $shopSourceID
     * @param $shopProductID
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     */
    public static function addJoin($shopSourceID, $shopProductID, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver){
        /** @var Model_AutoPart_Shop_Product_Source_Price $model */
        $model = Request_Request::findOneModel(
            DB_AutoPart_Shop_Product_Join::NAME, $sitePageData->shopID, $sitePageData, $driver,
            Request_RequestParams::setParams(
                [
                    'shop_source_id' => $shopSourceID,
                    'shop_operation_id' => $sitePageData->operationID,
                    'date' => Helpers_DateTime::getCurrentDatePHP(),
                ]
            )
        );
        if($model == false) {
            $model = new Model_AutoPart_Shop_Product_Join();
            $model->setDBDriver($driver);

            $model->setShopSourceID($shopSourceID);
            $model->setShopOperationID($sitePageData->operationID);
            $model->setDate(Helpers_DateTime::getCurrentDatePHP());
        }

        if($model->getShopProductID() == $shopProductID){
            return;
        }

        $model->setShopProductID($shopProductID);
        $model->setQuantity($model->getQuantity() + 1);

        Helpers_DB::saveDBObject($model, $sitePageData);

        $driver->updateObjects(
            Model_AutoPart_Shop_Product::TABLE_NAME, array($shopProductID),
            array(
                'shop_product_join_id' => $model->id,
            )
        );
    }
}