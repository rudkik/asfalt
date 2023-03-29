<?php defined('SYSPATH') or die('No direct script access.');

class Api_Ab1_Shop_Client_Attorney_Item  {

    /**
     * Сохранение список продукции доверенности
     * @param $shopID
     * @param $shopClientAttorneyID
     * @param array $shopClientAttorneyItems
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @return array
     */
    public static function save($shopID, $shopClientAttorneyID, array $shopClientAttorneyItems, SitePageData $sitePageData,
                                Model_Driver_DBBasicDriver $driver)
    {
        $model = new Model_Ab1_Shop_Client_Attorney_Item();
        $model->setDBDriver($driver);

        $params = Request_RequestParams::setParams(
            array(
                'shop_client_attorney_id' => $shopClientAttorneyID,
                'sort_by' => array('id' => 'asc'),
            )
        );
        $shopClientAttorneyItemIDs = Request_Request::find('DB_Ab1_Shop_Client_Attorney_Item',
            $sitePageData->shopMainID, $sitePageData, $driver, $params, 0, TRUE
        );
        $shopClientAttorneyItemIDs->runIndex();

        $products = array();
        $total = 0;
        foreach($shopClientAttorneyItems as $itemID => $shopClientAttorneyItem){
            $shopProductID = intval(Arr::path($shopClientAttorneyItem, 'shop_product_id', 0));
            $shopProductRubricID = intval(Arr::path($shopClientAttorneyItem, 'shop_product_rubric_id', 0));

            $quantity = Request_RequestParams::strToFloat(Arr::path($shopClientAttorneyItem, 'quantity', 0));
            if($quantity == 0 && ($shopProductID > 0 || $shopProductRubricID > 0)){
                continue;
            }

            $price = Request_RequestParams::strToFloat(Arr::path($shopClientAttorneyItem, 'price', 0));

            if($quantity <= 0){
                $quantity = 1;
                $price =  Request_RequestParams::strToFloat(Arr::path($shopClientAttorneyItem, 'amount', 0));
            }

            if(key_exists($itemID, $shopClientAttorneyItemIDs->childs)){
                $shopClientAttorneyItemIDs->childs[$itemID]->setModel($model);
                unset($shopClientAttorneyItemIDs->childs[$itemID]);
            }else{
                $model->clear();
            }

            $model->setShopProductID($shopProductID);
            $model->setShopProductRubricID($shopProductRubricID);
            $model->setQuantity($quantity);
            $model->setPrice($price);
            $model->setShopClientAttorneyID($shopClientAttorneyID);
            $model->setDiscount(Request_RequestParams::strToFloat(Arr::path($shopClientAttorneyItem, 'discount', 0)));

            if($shopProductID > 0){
                $modelItem = new Model_Ab1_Shop_Product();
                $id = $shopProductID;
            }else{
                $modelItem = new Model_Ab1_Shop_Product_Rubric();
                $id = $shopProductRubricID;
                $shopID = $sitePageData->shopMainID;
            }
            $modelItem->setDBDriver($driver);

            if(Helpers_DB::getDBObject($modelItem, $id, $sitePageData, $shopID)){
                $name = $modelItem->getName();
            }else{
                $name = 'Все';
            }

            $model->setName(
                'Продукция: <b>'.$name.'</b> на сумму: <b>'
                .Func::getPriceStr($sitePageData->currency, $model->getAmount() - $model->getBlockAmount())
                .'</b><br>'
            );

            if($model->getPrice() == 0){
                $model->setPrice(1);
            }

            $model->setNameWeight(
                'Продукция: <b>'.$name.'</b> кол-во: <b>'
                .Func::getPriceStr($sitePageData->currency, ($model->getAmount() - $model->getBlockAmount()) / $model->getPrice())
                .'</b><br>'
            );

            Helpers_DB::saveDBObject($model, $sitePageData, $sitePageData->shopMainID);

            $key = $shopProductID.'_'.$shopProductRubricID;
            if(!key_exists($key, $products)){
                $products[$key] = array(
                    'amount' => 0,
                    'quantity' => 0,
                    'name' => $name,
                );
            }
            $products[$key]['amount'] += $model->getAmount() - $model->getBlockAmount();
            $products[$key]['quantity'] += ($model->getAmount() - $model->getBlockAmount()) / $model->getPrice();

            $total += $model->getAmount();
        }

        // удаляем лишние
        $driver->deleteObjectIDs($shopClientAttorneyItemIDs->getChildArrayID(), $sitePageData->userID,
            Model_Ab1_Shop_Client_Attorney_Item::TABLE_NAME, array(), $sitePageData->shopMainID);


        $result = array(
            'amount' => $total,
            'name' => '',
            'name_weight' => '',
        );
        foreach($products as $child){
            $name = $child['name'];
            $result['name'] .= 'Продукция: <b>'.$name.'</b> на сумму: <b>'
                .Func::getPriceStr($sitePageData->currency, $child['amount'])
                .'</b><br>';

            $result['name_weight'] .= 'Продукция: <b>'.$name.'</b> кол-во: <b>'
                .Func::getNumberStr($child['quantity'], true, 3, false)
                .'</b><br>';
        }

        return $result;
    }
}
