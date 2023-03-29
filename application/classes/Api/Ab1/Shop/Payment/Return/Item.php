<?php defined('SYSPATH') or die('No direct script access.');

class Api_Ab1_Shop_Payment_Return_Item  {
    /**
     * Получение продукции для фикскального цека
     * @param $shopPaymentReturnID
     * @param Drivers_CashRegister_Aura3_GoodsList $goodsList
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     */
    public static function getGoodListFiscalCheck($shopPaymentReturnID, Drivers_CashRegister_Aura3_GoodsList $goodsList,
                                                  SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        $params = Request_RequestParams::setParams(
            array(
                'shop_payment_return_id' => $shopPaymentReturnID,
            )
        );
        $ids = Request_Request::find('DB_Ab1_Shop_Payment_Return_Item',
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
     * @param $shopPaymentReturnID
     * @param array $shopPaymentReturnItems
     * @param $shopClientID
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @return float|int
     */
    public static function save($shopPaymentReturnID, array $shopPaymentReturnItems, $shopClientID,
                                SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        $model = new Model_Ab1_Shop_Payment_Return_Item();
        $model->setDBDriver($driver);

        $shopPaymentReturnItemIDs = Request_Request::find('DB_Ab1_Shop_Payment_Return_Item', $sitePageData->shopID, $sitePageData, $driver,
            array('shop_payment_return_id' => $shopPaymentReturnID, Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE), 0, TRUE);

        $total = 0;
        foreach($shopPaymentReturnItems as $shopPaymentReturnItem){
            $shopProductID = intval(Arr::path($shopPaymentReturnItem, 'shop_product_id', 0));
            if($shopProductID < 1){
                continue;
            }
            $quantity = Request_RequestParams::strToFloat(Arr::path($shopPaymentReturnItem, 'quantity', 0));
            if($quantity <= 0){
                continue;
            }

            $amount = Request_RequestParams::strToFloat(Arr::path($shopPaymentReturnItem, 'amount', 0));
            if(($amount <= 0) && (count($shopPaymentReturnItems) == 1)){
                $amount = Request_RequestParams::getParamFloat('amount');
            }
            if($amount <= 0){
                continue;
            }

            $price = Api_Ab1_Shop_Product::getPrice(
                $shopClientID, 0, 0, $shopProductID, FALSE, $quantity,
                $sitePageData, $driver, FALSE, $model->getCreatedAt()
            )['price'];

            $model->clear();
            $shopPaymentReturnItemID = array_shift($shopPaymentReturnItemIDs->childs);
            if($shopPaymentReturnItemID !== NULL){
                $model->__setArray(array('values' => $shopPaymentReturnItemID->values));
            }

            $model->setShopProductID($shopProductID);
            $model->setShopClientID($shopClientID);
            $model->setQuantity($quantity);
            if($price > 0.001){
                $model->setPrice($price);
            }else{
                $model->setPrice(round($amount / $quantity, 2));
            }

            $model->setShopPaymentReturnID($shopPaymentReturnID);
            Helpers_DB::saveDBObject($model, $sitePageData);

            $total += $model->getAmount();
        }

        // удаляем лишние
        $driver->deleteObjectIDs($shopPaymentReturnItemIDs->getChildArrayID(), $sitePageData->userID,
            Model_Ab1_Shop_Payment_Return_Item::TABLE_NAME, array(), $sitePageData->shopID);

        return $total;
    }
}
