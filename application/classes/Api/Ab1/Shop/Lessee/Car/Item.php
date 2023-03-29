<?php defined('SYSPATH') or die('No direct script access.');

class Api_Ab1_Shop_Lessee_Car_Item  {

    /**
     * Сохранение список
     * @param Model_Ab1_Shop_Lessee_Car $modelLesseeCar
     * @param array $shopCarItems
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @return array
     */
    public static function save(Model_Ab1_Shop_Lessee_Car $modelLesseeCar, array $shopCarItems,
                                SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        $params = Request_RequestParams::setParams(
            array(
                'shop_lessee_car_id' => $modelLesseeCar->id,
            )
        );
        $shopCarItemIDs = Request_Request::find('DB_Ab1_Shop_Lessee_Car_Item',
            $sitePageData->shopID, $sitePageData, $driver, $params, 0, TRUE
        );
        $shopCarItemIDs->runIndex();

        $total = 0;
        $quantityAll = 0;

        $model = new Model_Ab1_Shop_Lessee_Car_Item();
        $model->setDBDriver($driver);
        foreach($shopCarItems as $key => $shopCarItem){
            $quantity = Request_RequestParams::strToFloat(Arr::path($shopCarItem, 'quantity', 0));
            if($quantity <= 0){
                continue;
            }

            $model->clear();
            if(key_exists($key, $shopCarItemIDs->childs)){
                $shopCarItemIDs->childs[$key]->setModel($model);
                unset($shopCarItemIDs->childs[$key]);
            }

            $model->setShopStorageID($modelLesseeCar->getShopStorageID());
            $model->setShopSubdivisionID($modelLesseeCar->getShopSubdivisionID());
            $model->setShopHeapID($modelLesseeCar->getShopHeapID());

            $model->setShopProductID($modelLesseeCar->getShopProductID());
            $model->setQuantity($quantity);
            $model->setShopLesseeCarID($modelLesseeCar->id);
            $model->setShopClientID($modelLesseeCar->getShopClientID());


            Helpers_DB::saveDBObject($model, $sitePageData);

            $total = $total + $model->getAmount();
            $quantityAll = $quantityAll + $model->getQuantity();

            $productPrices[$model->getShopProductPriceID()] = $model->getShopProductPriceID();
        }

        // удаляем лишние
        $driver->deleteObjectIDs(
            $shopCarItemIDs->getChildArrayID(), $sitePageData->userID,
            Model_Ab1_Shop_Lessee_Car_Item::TABLE_NAME, array(), $sitePageData->shopID
        );

        return array(
            'amount' => $total,
            'quantity' => $quantityAll,
        );
    }

    /**
     * Сохранение одну запись
     * @param Model_Ab1_Shop_Lessee_Car $model
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     */
    public static function saveOne(Model_Ab1_Shop_Lessee_Car $model, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        $params = Request_RequestParams::setParams(
            array(
                'shop_lessee_car_id' => $model->id,
            )
        );
        $shopCarItemIDs = Request_Request::find('DB_Ab1_Shop_Lessee_Car_Item',
            $sitePageData->shopID, $sitePageData, $driver, $params, 0, TRUE
        );

        $modelItem = new Model_Ab1_Shop_Lessee_Car_Item();
        $modelItem->setDBDriver($driver);
        $shopCarItemID = array_shift($shopCarItemIDs->childs);
        if($shopCarItemID !== NULL){
            $shopCarItemID->setModel($modelItem);
        }

        $modelItem->setShopStorageID($model->getShopStorageID());
        $modelItem->setShopSubdivisionID($model->getShopSubdivisionID());
        $modelItem->setShopHeapID($model->getShopHeapID());

        $modelItem->setShopProductID($model->getShopProductID());
        $modelItem->setQuantity($model->getQuantity());
        $modelItem->setShopLesseeCarID($model->id);
        $modelItem->setShopClientID($model->getShopClientID());
        Helpers_DB::saveDBObject($modelItem, $sitePageData);

        // удаляем лишние
        $driver->deleteObjectIDs(
            $shopCarItemIDs->getChildArrayID(), $sitePageData->userID,
            Model_Ab1_Shop_Lessee_Car_Item::TABLE_NAME, array(), $sitePageData->shopID
        );
    }
}
