<?php defined('SYSPATH') or die('No direct script access.');

class Api_Ab1_Shop_Payment_Item  {
    /**
     * Получение продукции для фикскального цека
     * @param $shopPaymentID
     * @param Drivers_CashRegister_Aura3_GoodsList $goodsList
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     */
    public static function getGoodListFiscalCheck($shopPaymentID, Drivers_CashRegister_Aura3_GoodsList $goodsList,
                                                  SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        $params = Request_RequestParams::setParams(
            array(
                'shop_payment_id' => $shopPaymentID,
            )
        );
        $ids = Request_Request::find('DB_Ab1_Shop_Payment_Item',
            $sitePageData->shopID, $sitePageData, $driver, $params, 0, TRUE,
            array('shop_product_id' => array('name'))
        );
        foreach ($ids->childs as $child){
            $goodsList->addGoods(
                $child->getElementValue('shop_product_id'),
                $child->values['price'],
                $child->values['quantity']
            );
        }
    }

    /**
     * Сохранение список
     * @param $shopPaymentID
     * @param array $shopPaymentItems
     * @param $shopClientID
     * @param $shopClientContractID
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @param int $productShopDeliveryID
     * @param int $deliveryAmount
     * @return float|int
     */
    public static function save($shopPaymentID, array $shopPaymentItems, $shopClientID, $shopClientContractID,
                                SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver,
                                $productShopDeliveryID = 0, $deliveryAmount = 0)
    {
        $model = new Model_Ab1_Shop_Payment_Item();
        $model->setDBDriver($driver);

        $shopPaymentItemIDs = Request_Request::find('DB_Ab1_Shop_Payment_Item', $sitePageData->shopID, $sitePageData, $driver,
            array('shop_payment_id' => $shopPaymentID, Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE), 0, TRUE);

        $total = 0;
        foreach($shopPaymentItems as $shopPaymentItem){
            $shopProductID = intval(Arr::path($shopPaymentItem, 'shop_product_id', 0));
            if($shopProductID < 1){
                continue;
            }
            $quantity = Request_RequestParams::strToFloat(Arr::path($shopPaymentItem, 'quantity', 0));
            if($quantity <= 0){
                continue;
            }
            $amount = Request_RequestParams::strToFloat(Arr::path($shopPaymentItem, 'amount', 0));
            if(($amount <= 0) && (count($shopPaymentItems) == 1)){
                $amount = Request_RequestParams::getParamFloat('amount');
            }
            if($amount <= 0){
                continue;
            }

            $price = Request_RequestParams::strToFloat(Arr::path($shopPaymentItem, 'price', 0));
            if($price <= 0){
                $price = Api_Ab1_Shop_Product::getPrice(
                    $shopClientID, $shopClientContractID, 0, $shopProductID, FALSE, 0,
                    $sitePageData, $driver, FALSE, $model->getCreatedAt()
                )['price'];
            }

            $shopPaymentItemIDs->childShiftSetModel($model);

            $model->setShopProductID($shopProductID);
            $model->setQuantity($quantity);
            if($price > 0.001){
                $model->setPrice($price);
            }else{
                $model->setPrice(round($amount / $quantity, 2));
            }

            $model->setShopPaymentID($shopPaymentID);
            Helpers_DB::saveDBObject($model, $sitePageData);

            $total += $model->getAmount();
        }

        if($productShopDeliveryID > 0){
            $modelProduct = new Model_Ab1_Shop_Product();
            $modelProduct->setDBDriver($driver);
            if(!Helpers_DB::getDBObject($model, $productShopDeliveryID, $sitePageData)) {
                $shopPaymentItemIDs->childShiftSetModel($model);
                $model->setQuantity(1);
                $model->setShopProductID($productShopDeliveryID);
                $model->setPrice($deliveryAmount);
                $model->setShopPaymentID($shopPaymentID);

                Helpers_DB::saveDBObject($model, $sitePageData);

                $total += $model->getAmount();
            }
        }

        // удаляем лишние
        $driver->deleteObjectIDs($shopPaymentItemIDs->getChildArrayID(), $sitePageData->userID,
            Model_Ab1_Shop_Payment_Item::TABLE_NAME, array(), $sitePageData->shopID);

        return $total;
    }
}
