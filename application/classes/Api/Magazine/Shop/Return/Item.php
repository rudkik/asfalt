<?php defined('SYSPATH') or die('No direct script access.');

class Api_Magazine_Shop_Return_Item  {

    /**
     * Сохранение список
     * @param Model_Magazine_Shop_Return $modelReturn
     * @param array $shopReturnItems
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @return array
     */
    public static function save(Model_Magazine_Shop_Return $modelReturn, array $shopReturnItems,
                                SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        $model = new Model_Magazine_Shop_Return_Item();
        $model->setDBDriver($driver);

        $params = Request_RequestParams::setParams(
            array(
                'shop_return_id' => $modelReturn->id,
            )
        );
        $shopReturnItemIDs = Request_Request::find('DB_Magazine_Shop_Return_Item',
            $sitePageData->shopID, $sitePageData, $driver, $params, 0, TRUE
        );

        $amountAll = 0;
        $quantityAll = 0;
        foreach($shopReturnItems as $shopReturnItem){
            $quantity = Request_RequestParams::strToFloat(Arr::path($shopReturnItem, 'quantity', 0));
            if($quantity <= 0){
                continue;
            }
            $price = Request_RequestParams::strToFloat(Arr::path($shopReturnItem, 'price', 0));
            if($price <= 0){
                continue;
            }
            $shopProductID = intval(Arr::path($shopReturnItem, 'shop_product_id', 0));
            if($shopProductID <= 0){
                continue;
            }

            $model->clear();
            $shopReturnItemID = array_shift($shopReturnItemIDs->childs);
            if($shopReturnItemID !== NULL){
                $shopReturnItemID->setModel($model);
            }

            $model->setShopProductID($shopProductID);
            $model->setQuantity($quantity);
            $model->setPrice($price);
            $model->setShopReturnID($modelReturn->id);
            $model->setShopSupplierID($modelReturn->getShopSupplierID());
            $model->setIsNDS($modelReturn->getIsNDS());
            Helpers_DB::saveDBObject($model, $sitePageData);

            // расход продуктов
            Api_Magazine_Shop_Product::calcExpense($shopProductID, $sitePageData, $driver, TRUE);

            $amountAll = $amountAll + $model->getAmount();
            $quantityAll = $quantityAll + $model->getQuantity();
        }

        // удаляем лишние
        $driver->deleteObjectIDs(
            $shopReturnItemIDs->getChildArrayID(), $sitePageData->userID,
            Model_Magazine_Shop_Return_Item::TABLE_NAME, array(), $sitePageData->shopID
        );

        return array(
            'amount' => $amountAll,
            'quantity' => $quantityAll,
        );
    }
}
