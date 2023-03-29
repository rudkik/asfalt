<?php defined('SYSPATH') or die('No direct script access.');

class Api_Magazine_Shop_Revise_Item  {

    /**
     * Сохранение список
     * @param Model_Magazine_Shop_Revise $modelRevise
     * @param array $shopReviseItems
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @param bool $isCalcStock - пересчитывать остатки
     * @return array
     */
    public static function save(Model_Magazine_Shop_Revise $modelRevise, array $shopReviseItems,
                                SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver, $isCalcStock = TRUE)
    {
        // находим все продукты
        $shopProductIDs = array();
        $arr = array();
        foreach($shopReviseItems as $shopReviseItem){
            $shopProductID = intval(Arr::path($shopReviseItem, 'shop_product_id', 0));
            if($shopProductID > 0){
                $shopProductIDs[$shopProductID] = $shopProductID;
            }

            if(key_exists($shopProductID, $arr)){
                $arr[$shopProductID]['quantity_actual'] =
                    Request_RequestParams::strToFloat(Arr::path($arr[$shopProductID], 'quantity_actual', 0))
                    + Request_RequestParams::strToFloat(Arr::path($shopReviseItem, 'quantity_actual', 0));
            }else{
                $arr[$shopProductID] = $shopReviseItem;
            }
        }
        $shopReviseItems = $arr;

        if(!empty($shopProductIDs)) {
            $params = Request_RequestParams::setParams(
                array(
                    'id' => $shopProductIDs,
                )
            );
            $shopProductIDs = Request_Request::find('DB_Magazine_Shop_Product',
                $sitePageData->shopMainID, $sitePageData, $driver, $params, 0, TRUE,
                array('shop_product_stock_id' => array('quantity_balance'))
            );
            $shopProductIDs->runIndex();
        }else{
            $shopProductIDs = new MyArray();
        }

        $model = new Model_Magazine_Shop_Revise_Item();
        $model->setDBDriver($driver);

        $params = Request_RequestParams::setParams(
            array(
                'shop_revise_id' => $modelRevise->id,
            )
        );
        $shopReviseItemIDs = Request_Request::find('DB_Magazine_Shop_Revise_Item',
            $sitePageData->shopID, $sitePageData, $driver, $params, 0, TRUE
        );

        // остаток на конец дня создания ревизии
        $dateRevise = Helpers_DateTime::getDateFormatPHP($modelRevise->getCreatedAt()).' 23:59:59';
        $stock = Api_Magazine_Shop_Product::stockDate($dateRevise, $sitePageData, $driver);

        $quantityActualAll = 0;
        $quantityAll = 0;
        foreach($shopReviseItems as $shopReviseItem){
            $quantityActual = Request_RequestParams::strToFloat(Arr::path($shopReviseItem, 'quantity_actual', 0));
            if($quantityActual < 0){
                continue;
            }
            $shopProductID = intval(Arr::path($shopReviseItem, 'shop_product_id', 0));
            if($shopProductID <= 0){
                continue;
            }

            $model->clear();
            $shopReviseItemID = array_shift($shopReviseItemIDs->childs);
            if($shopReviseItemID !== NULL){
                $shopReviseItemID->setModel($model);
            }

            $model->setQuantity(0);
            if(key_exists($shopProductID, $shopProductIDs->childs)){
                if(key_exists($shopProductID, $stock)) {
                    $shopProduct = $shopProductIDs->childs[$shopProductID];
                    $model->setQuantity($stock[$shopProductID] * $shopProduct->values['coefficient_revise']);
                }
            }

            $model->setShopProductID($shopProductID);
            $model->setQuantityActual($quantityActual);
            $model->setShopReviseID($modelRevise->id);
            Helpers_DB::saveDBObject($model, $sitePageData);

            if($isCalcStock) {
                // расход продуктов
                Api_Magazine_Shop_Product::calcExpense($shopProductID, $sitePageData, $driver, TRUE);
                // приход продуктов
                Api_Magazine_Shop_Product::calcComing($shopProductID, $sitePageData, $driver, TRUE);
            }

            $quantityActualAll = $quantityActualAll + $model->getQuantityActual();
            $quantityAll = $quantityAll + $model->getQuantity();
        }

        // удаляем лишние
        $driver->deleteObjectIDs(
            $shopReviseItemIDs->getChildArrayID(), $sitePageData->userID,
            Model_Magazine_Shop_Revise_Item::TABLE_NAME, array(), $sitePageData->shopID
        );

        return array(
            'quantity_actual' => $quantityActualAll,
            'quantity' => $quantityAll,
        );
    }
}
