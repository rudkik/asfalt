<?php defined('SYSPATH') or die('No direct script access.');

class Api_Magazine_Shop_Realization_Return_Item  {

    /**
     * Сохранение список реализации
     * @param Model_Magazine_Shop_Realization_Return $modelRealizationReturn
     * @param array $shopRealizationReturnItems
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @return array
     */
    public static function save(Model_Magazine_Shop_Realization_Return $modelRealizationReturn, array $shopRealizationReturnItems,
                                SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        // находим все продукты
        $shopProductionIDs = array();
        foreach($shopRealizationReturnItems as $shopRealizationReturnItem){
            $shopProductionID = intval(Arr::path($shopRealizationReturnItem, 'shop_production_id', 0));
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

        $model = new Model_Magazine_Shop_Realization_Return_Item();
        $model->setDBDriver($driver);

        $params = Request_RequestParams::setParams(
            array(
                'shop_realization_return_id' => $modelRealizationReturn->id,
            )
        );
        $shopRealizationReturnItemIDs = Request_Request::find('DB_Magazine_Shop_Realization_Return_Item',
            $sitePageData->shopID, $sitePageData, $driver, $params, 0, TRUE,
            array('shop_production_id' => array('shop_product_id'))
        );
        // задаем старые цены для старых товаров
        foreach($shopRealizationReturnItemIDs->childs as $shopRealizationReturnItemID){
            $shopProductionID = $shopRealizationReturnItemID->values['shop_production_id'];
            if(key_exists($shopProductionID, $shopProductionIDs->childs)) {
                $shopProductionIDs->childs[$shopProductionID]->values['price'] = $shopRealizationReturnItemID->values['price'];
            }
        }
        $shopRealizationReturnItemIDs->runIndex(TRUE, 'shop_production_id');

        $amountAll = 0;
        $quantityAll = 0;
        foreach($shopRealizationReturnItems as $shopRealizationReturnItem){
            $quantity = Request_RequestParams::strToFloat(Arr::path($shopRealizationReturnItem, 'quantity', 0));
            $shopProductionID = intval(Arr::path($shopRealizationReturnItem, 'shop_production_id', 0));
            if($shopProductionID <= 0){
                continue;
            }

            if(key_exists($shopProductionID, $shopProductionIDs->childs)){
                $price = $shopProductionIDs->childs[$shopProductionID]->values['price'];
                $shopProductID = $shopProductionIDs->childs[$shopProductionID]->values['shop_product_id'];
            }else{
                continue;
            }

            $model->clear();
            if(key_exists($shopProductionID, $shopRealizationReturnItemIDs->childs)){
                $shopRealizationReturnItemID = $shopRealizationReturnItemIDs->childs[$shopProductionID];
                $shopRealizationReturnItemID->setModel($model);

                unset($shopRealizationReturnItemIDs->childs[$shopProductionID]);
            }

            $model->setShopRealizationReturnID($modelRealizationReturn->id);
            $model->setShopProductionID($shopProductionID);
            $model->setQuantity($quantity);
            $model->setPrice($price);
            Helpers_DB::saveDBObject($model, $sitePageData);

            // расход продуктов
            Api_Magazine_Shop_Product::calcComing($shopProductID, $sitePageData, $driver, TRUE);
            // расход продукции
            Api_Magazine_Shop_Production::calcComing($shopProductionID, $sitePageData, $driver, TRUE);

            $amountAll = $amountAll + $model->getAmount();
            $quantityAll = $quantityAll + $model->getQuantity();
        }

        // удаляем лишние
        $driver->deleteObjectIDs(
            $shopRealizationReturnItemIDs->getChildArrayID(), $sitePageData->userID,
            Model_Magazine_Shop_Realization_Return_Item::TABLE_NAME, array(), $sitePageData->shopID
        );

        // пересчитываем остатки удаленных записей
        foreach ($shopRealizationReturnItemIDs->childs as $child){
            // расход продуктов
            Api_Magazine_Shop_Product::calcExpense($child->getElementValue('shop_production_id', 'shop_product_id'), $sitePageData, $driver, TRUE);
            // расход продукции
            Api_Magazine_Shop_Production::calcExpense($child->values['shop_production_id'], $sitePageData, $driver, TRUE);
        }

        return array(
            'amount' => $amountAll,
            'quantity' => $quantityAll,
        );
    }
}
