<?php defined('SYSPATH') or die('No direct script access.');

class Api_Magazine_Shop_Realization_Item  {

    /**
     * Сохранение список реализации
     * @param Model_Magazine_Shop_Realization $modelRealization
     * @param array $shopRealizationItems
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @return array
     */
    public static function save(Model_Magazine_Shop_Realization $modelRealization, array $shopRealizationItems,
                                SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        // находим все продукты
        $shopProductionIDs = array();
        foreach($shopRealizationItems as $shopRealizationItem){
            $shopProductionID = intval(Arr::path($shopRealizationItem, 'shop_production_id', 0));
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
                $sitePageData->shopMainID, $sitePageData, $driver, $params, 0, TRUE,
                array(
                    'shop_product_id' => array('price_average'),
                )
            );
            $shopProductionIDs->runIndex();
        }else{
            $shopProductionIDs = new MyArray();
        }

        $model = new Model_Magazine_Shop_Realization_Item();
        $model->setDBDriver($driver);

        $params = Request_RequestParams::setParams(
            array(
                'shop_realization_id' => $modelRealization->id,
            )
        );
        $shopRealizationItemIDs = Request_Request::find('DB_Magazine_Shop_Realization_Item',
            $sitePageData->shopID, $sitePageData, $driver, $params, 0, TRUE,
            array('shop_production_id' => array('shop_product_id'))
        );
        // задаем старые цены для старых товаров
        foreach($shopRealizationItemIDs->childs as $shopRealizationItemID){
            $shopProductionID = $shopRealizationItemID->values['shop_production_id'];
            if(key_exists($shopProductionID, $shopProductionIDs->childs)) {
                $shopProductionIDs->childs[$shopProductionID]->values['price'] = $shopRealizationItemID->values['price'];
            }
        }
        $shopRealizationItemIDs->runIndex(TRUE, 'shop_production_id');

        $amountAll = 0;
        $quantityAll = 0;
        foreach($shopRealizationItems as $shopRealizationItem){
            $quantity = Request_RequestParams::strToFloat(Arr::path($shopRealizationItem, 'quantity', 0));
            $shopProductionID = intval(Arr::path($shopRealizationItem, 'shop_production_id', 0));
            if($shopProductionID <= 0){
                continue;
            }

            if(key_exists($shopProductionID, $shopProductionIDs->childs)){
                if($modelRealization->getShopWriteOffTypeID() == Model_Magazine_Shop_WriteOff_Type::WRITE_OFF_TYPE_OVER_THE_NORM
                    || $modelRealization->getShopWriteOffTypeID() == Model_Magazine_Shop_WriteOff_Type::WRITE_OFF_TYPE_RECEPTION
                    || $modelRealization->getShopWriteOffTypeID() == Model_Magazine_Shop_WriteOff_Type::WRITE_OFF_TYPE_BY_STANDART){
                    $price = Request_RequestParams::strToFloat(Arr::path($shopRealizationItem, 'price', 0));
                    if($price <= 0){
                        $coefficient = $shopProductionIDs->childs[$shopProductionID]->values['coefficient'];
                        if($coefficient == 0){
                            $coefficient = 1;
                        }

                        $price = $shopProductionIDs->childs[$shopProductionID]->getElementValue('shop_product_id', 'price_average', 0);
                        $price = round($price / $coefficient, 2);
                    }
                }elseif($modelRealization->getIsSpecial() == Model_Magazine_Shop_Realization::SPECIAL_TYPE_WRITE_OFF
                    || $shopProductionIDs->childs[$shopProductionID]->values['is_price_cost'] == 1){
                    $price = $shopProductionIDs->childs[$shopProductionID]->values['price_cost'];
                }else{
                    $price = $shopProductionIDs->childs[$shopProductionID]->values['price'];
                }
                $shopProductID = $shopProductionIDs->childs[$shopProductionID]->values['shop_product_id'];
            }else{
                continue;
            }

            $model->clear();
            if(key_exists($shopProductionID, $shopRealizationItemIDs->childs)){
                $shopRealizationItemID = $shopRealizationItemIDs->childs[$shopProductionID];
                $shopRealizationItemID->setModel($model);

                unset($shopRealizationItemIDs->childs[$shopProductionID]);
            }

            switch ($model->getShopWriteOffTypeID()){
                case Model_Magazine_Shop_WriteOff_Type::WRITE_OFF_TYPE_RECEPTION:
                case Model_Magazine_Shop_WriteOff_Type::WRITE_OFF_TYPE_OVER_THE_NORM:
                case Model_Magazine_Shop_WriteOff_Type::WRITE_OFF_TYPE_BY_STANDART:
                    $model->setCreatedAt($modelRealization->getCreatedAt());
                    break;
            }

            $model->setShopProductionID($shopProductionID);
            $model->setQuantity($quantity);
            $model->setPrice($price);
            $model->setShopRealizationID($modelRealization->id);
            $model->setShopCardID($modelRealization->getShopCardID());
            $model->setShopWorkerID($modelRealization->getShopWorkerID());
            $model->setIsSpecial($modelRealization->getIsSpecial());
            $model->setShopWriteOffTypeID($modelRealization->getShopWriteOffTypeID());
            Helpers_DB::saveDBObject($model, $sitePageData);

            // расход продуктов
            Api_Magazine_Shop_Product::calcExpense($shopProductID, $sitePageData, $driver, TRUE);
            // расход продукции
            Api_Magazine_Shop_Production::calcExpense($shopProductionID, $sitePageData, $driver, TRUE);

            $amountAll = $amountAll + $model->getAmount();
            $quantityAll = $quantityAll + $model->getQuantity();
        }

        // удаляем лишние
        $driver->deleteObjectIDs(
            $shopRealizationItemIDs->getChildArrayID(), $sitePageData->userID,
            Model_Magazine_Shop_Realization_Item::TABLE_NAME, array(), $sitePageData->shopID
        );

        // пересчитываем остатки удаленных записей
        foreach ($shopRealizationItemIDs->childs as $child){
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
