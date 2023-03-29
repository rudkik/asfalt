<?php defined('SYSPATH') or die('No direct script access.');

class Api_Ab1_Shop_Product_TurnPlace_Item  {

    /**
     * Сохранение список
     * @param Model_Ab1_Shop_Product_TurnPlace $modelProductTurnPlace
     * @param array $shopProductTurnPlaceItems
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @return bool
     */
    public static function save(Model_Ab1_Shop_Product_TurnPlace $modelProductTurnPlace,
                                array $shopProductTurnPlaceItems, SitePageData $sitePageData,
                                Model_Driver_DBBasicDriver $driver)
    {
        $model = new Model_Ab1_Shop_Product_TurnPlace_Item();
        $model->setDBDriver($driver);

        $params = Request_RequestParams::setParams(
            array(
                'shop_product_turn_place_id' => $modelProductTurnPlace->id,
            )
        );
        $shopProductTurnPlaceItemIDs = Request_Request::find('DB_Ab1_Shop_Product_TurnPlace_Item',
            $sitePageData->shopID, $sitePageData, $driver, $params, 0, TRUE
        );
        $shopProductTurnPlaceItemIDs->runIndex(true);

        foreach($shopProductTurnPlaceItems as $id => $shopProductTurnPlaceItem){
            $shopProductID = intval(Arr::path($shopProductTurnPlaceItem, 'shop_product_id', 0));
            if($shopProductID < 1){
                continue;
            }

            $price = Request_RequestParams::strToFloat(Arr::path($shopProductTurnPlaceItem, 'price', 0));
            $norm = Request_RequestParams::strToFloat(Arr::path($shopProductTurnPlaceItem, 'norm', 0));

            if(key_exists($id, $shopProductTurnPlaceItemIDs->childs)){
                $shopProductTurnPlaceItemIDs->childs[$id]->setModel($model);
                unset($shopProductTurnPlaceItemIDs->childs[$id]);
            }else{
                $model->clear();
                $model->setShopProductTurnPlaceID($modelProductTurnPlace->id);
            }

            $model->setShopTurnPlaceID($modelProductTurnPlace->getShopTurnPlaceID());
            $model->setFromAt($modelProductTurnPlace->getFromAt());
            $model->setToAt($modelProductTurnPlace->getToAt());
            $model->setShopProductID($shopProductID);
            $model->setPrice($price);
            $model->setNorm($norm);
            Helpers_DB::saveDBObject($model, $sitePageData);
        }

        // удаляем лишние
        $driver->deleteObjectIDs(
            $shopProductTurnPlaceItemIDs->getChildArrayID(), $sitePageData->userID,
            Model_Ab1_Shop_Product_TurnPlace_Item::TABLE_NAME, array()
        );

        return TRUE;
    }
}
