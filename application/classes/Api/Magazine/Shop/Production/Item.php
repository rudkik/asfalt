<?php defined('SYSPATH') or die('No direct script access.');

class Api_Magazine_Shop_Production_Item  {

    /**
     * Сохранение список
     * @param $rootShopProductionID
     * @param array $shopProductionItems
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @return int
     */
    public static function save($rootShopProductionID, array $shopProductionItems,
                                SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        $model = new Model_Magazine_Shop_Production_Item();
        $model->setDBDriver($driver);

        $modelProduct = new Model_Magazine_Shop_Product();
        $modelProduct->setDBDriver($driver);

        $modelProduction = new Model_Magazine_Shop_Production();
        $modelProduction->setDBDriver($driver);

        $params = Request_RequestParams::setParams(
            array(
                'root_id' => $rootShopProductionID,
            )
        );
        $shopProductionItemIDs = Request_Request::find('DB_Magazine_Shop_Production_Item',
            $sitePageData->shopMainID, $sitePageData, $driver, $params, 0, TRUE
        );

        $arr = array();
        foreach($shopProductionItems as $shopProductionItem){
            $coefficient = Request_RequestParams::strToFloat(Arr::path($shopProductionItem, 'coefficient', 0));
            if($coefficient <= 0){
                continue;
            }

            $shopProductID = intval(Arr::path($shopProductionItem, 'shop_product_id', 0));
            $shopProductionID = intval(Arr::path($shopProductionItem, 'shop_production_id', 0));
            if(($shopProductID <= 0) && ($shopProductionID <= 0)){
                continue;
            }
            if((!Helpers_DB::getDBObject($modelProduct, $shopProductID, $sitePageData, $sitePageData->shopMainID))
                && (!Helpers_DB::getDBObject($modelProduction, $shopProductionID, $sitePageData, $sitePageData->shopMainID))){
                continue;
            }

            $model->clear();
            $shopProductionItemID = array_shift($shopProductionItemIDs->childs);
            if($shopProductionItemID !== NULL){
                $shopProductionItemID->setModel($model);
            }

            $model->setShopProductID($shopProductID);
            $model->setShopProductionID($shopProductionID);
            $model->setCoefficient($coefficient);
            $model->setRootID($rootShopProductionID);
            Helpers_DB::saveDBObject($model, $sitePageData, $sitePageData->shopMainID);

            $arr[] = array(
                'id' => $shopProductID,
                'coefficient' => $coefficient,
            );
        }

        // удаляем лишние
        $driver->deleteObjectIDs(
            $shopProductionItemIDs->getChildArrayID(), $sitePageData->userID,
            Model_Magazine_Shop_Production_Item::TABLE_NAME, array(), $sitePageData->shopMainID
        );

        if((count($arr) == 1) && ($arr[0] > 0)){
            return $arr[0];
        }else{
            return array(
                'id' => 0,
                'coefficient' => 0,
            );
        }
    }
}
