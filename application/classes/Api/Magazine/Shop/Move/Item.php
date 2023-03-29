<?php defined('SYSPATH') or die('No direct script access.');

class Api_Magazine_Shop_Move_Item  {

    /**
     * Сохранение список
     * @param $shopMoveID
     * @param $branchMoveID
     * @param array $shopMoveItems
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @return array
     */
    public static function save($shopMoveID, $branchMoveID, array $shopMoveItems,
                                SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        $shopBranchIDs = Request_Shop::getBranchShopIDs(
            $sitePageData->shopMainID, $sitePageData, $driver
        )->getChildArrayID(TRUE);
        $shopBranchIDs[$sitePageData->shopID] = $sitePageData->shopID;
        $shopBranchIDs[$sitePageData->shopMainID] = $sitePageData->shopMainID;

        // находим все продукты
        $shopProductionIDs = array();
        foreach($shopMoveItems as $shopReviseItem){
            $shopProductionID = intval(Arr::path($shopReviseItem, 'shop_production_id', 0));
            if($shopProductionID <= 0){
                continue;
            }
            $shopProductionIDs[$shopProductionID] = $shopProductionID;
        }
        if(!empty($shopProductionIDs)) {
            $params = Request_RequestParams::setParams(
                array(
                    'id' => $shopProductionIDs,
                    'is_delete_ignore' => TRUE,
                    'is_public_ignore' => TRUE,
                )
            );
            $shopProductionIDs = Request_Request::find('DB_Magazine_Shop_Production',
                $sitePageData->shopMainID, $sitePageData, $driver, $params, 0, TRUE
            );
            $shopProductionIDs->runIndex();
        }else{
            $shopProductionIDs = new MyArray();
        }

        $model = new Model_Magazine_Shop_Move_Item();
        $model->setDBDriver($driver);

        $params = Request_RequestParams::setParams(
            array(
                'shop_move_id' => $shopMoveID,
            )
        );
        $shopMoveItemIDs = Request_Request::find('DB_Magazine_Shop_Move_Item',
            $sitePageData->shopID, $sitePageData, $driver, $params, 0, TRUE
        );

        $quantityAll = 0;
        foreach($shopMoveItems as $shopMoveItem){
            $quantity = Request_RequestParams::strToFloat(Arr::path($shopMoveItem, 'quantity', 0));
            if($quantity <= 0){
                continue;
            }
            $shopProductionID = intval(Arr::path($shopMoveItem, 'shop_production_id', 0));
            if($shopProductionID <= 0){
                continue;
            }

            if(key_exists($shopProductionID, $shopProductionIDs->childs)){
                $shopProductID = $shopProductionIDs->childs[$shopProductionID]->values['shop_product_id'];
            }else{
                continue;
            }

            $model->clear();
            $shopMoveItemID = array_shift($shopMoveItemIDs->childs);
            if($shopMoveItemID !== NULL){
                $shopMoveItemID->setModel($model);
            }

            $model->setShopProductionID($shopProductionID);
            $model->setQuantity($quantity);
            $model->setShopMoveID($shopMoveID);
            $model->setBranchMoveID($branchMoveID);
            Helpers_DB::saveDBObject($model, $sitePageData);

            foreach ($shopBranchIDs as $shopBranchID) {
                try {
                    $tmp = $sitePageData->shopID;
                    $sitePageData->shopID = $shopBranchID;

                    // расход продуктов
                    Api_Magazine_Shop_Product::calcExpense($shopProductID, $sitePageData, $driver, TRUE);
                    // расход продукции
                    Api_Magazine_Shop_Production::calcExpense($shopProductionID, $sitePageData, $driver, TRUE);

                    // приход продуктов
                    Api_Magazine_Shop_Product::calcComing($shopProductID, $sitePageData, $driver, TRUE);
                    // приход продукции
                    Api_Magazine_Shop_Production::calcComing($shopProductionID, $sitePageData, $driver, TRUE);
                } finally {
                    $sitePageData->shopID = $tmp;
                }
            }

            $quantityAll = $quantityAll + $model->getQuantity();
        }

        // пересчитываем удаленные записи
        foreach ($shopMoveItemIDs->childs as $child){
            $shopProductionID = $child->values['shop_production_id'];

            if(key_exists($shopProductionID, $shopProductionIDs->childs)){
                $shopProductID = $shopProductionIDs->childs[$shopProductionID]->values['shop_product_id'];
            }else{
                $shopProductID = 0;
            }

            foreach ($shopBranchIDs as $shopBranchID) {
                try {
                    $tmp = $sitePageData->shopID;
                    $sitePageData->shopID = $shopBranchID;

                    // расход продуктов
                    Api_Magazine_Shop_Product::calcExpense($shopProductID, $sitePageData, $driver, TRUE);
                    // расход продукции
                    Api_Magazine_Shop_Production::calcExpense($shopProductionID, $sitePageData, $driver, TRUE);

                    // приход продуктов
                    Api_Magazine_Shop_Product::calcComing($shopProductID, $sitePageData, $driver, TRUE);
                    // приход продукции
                    Api_Magazine_Shop_Production::calcComing($shopProductionID, $sitePageData, $driver, TRUE);
                } finally {
                    $sitePageData->shopID = $tmp;
                }
            }
        }

        // удаляем лишние
        $driver->deleteObjectIDs(
            $shopMoveItemIDs->getChildArrayID(), $sitePageData->userID,
            Model_Magazine_Shop_Move_Item::TABLE_NAME, array(), $sitePageData->shopID
        );

        return $quantityAll;
    }
}
