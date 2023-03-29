<?php defined('SYSPATH') or die('No direct script access.');

class Api_Ab1_Shop_Delivery_Discount_Item  {
    /**
     * Просчет заблокированного баланса продукта прайс-листа
     * @param int $shopDeliveryDiscountItemID
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @param bool $isSaveAmount
     * @param string | null $dateTo
     * @return bool|int
     * @throws HTTP_Exception_500
     */
    public static function calcBalanceBlock($shopDeliveryDiscountItemID, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver,
                                            $isSaveAmount = TRUE, $dateTo = null)
    {
        $shopDeliveryDiscountItemID = intval($shopDeliveryDiscountItemID);
        if($shopDeliveryDiscountItemID < 1) {
            return FALSE;
        }

        $amount = 0;
        $params = Request_RequestParams::setParams(
            array(
                'shop_product_price_id' => $shopDeliveryDiscountItemID,
                'created_at_to' => $dateTo,
                'sum_amount' => TRUE,
                'count_id' => TRUE,
            )
        );
        // реализация
        $ids = Request_Request::findBranch('DB_Ab1_Shop_Car_Item',
            array(), $sitePageData, $driver, $params
        );
        if(count($ids->childs) > 0){
            $amount += $ids->childs[0]->values['amount'];
        }

        // штучный товар
        $ids = Request_Request::findBranch('DB_Ab1_Shop_Piece_Item',
            array(), $sitePageData, $driver, $params
        );
        if(count($ids->childs) > 0){
            $amount += $ids->childs[0]->values['amount'];
        }

        if($isSaveAmount && $dateTo == null) {
            $model = new Model_Ab1_Shop_Delivery_Discount_Item();
            $model->setDBDriver($driver);
            if (!Helpers_DB::getDBObject($model, $shopDeliveryDiscountItemID, $sitePageData, $sitePageData->shopMainID)) {
                throw new HTTP_Exception_500('Product price id="' . $shopDeliveryDiscountItemID . '" not found. #10032001612');
            }
            $model->setBlockAmount($amount);
            Helpers_DB::saveDBObject($model, $sitePageData);
        }

        return $amount;
    }

    /**
     *  Просчет заблокированного баланса продуктов прайс-листов
     * @param array $shopDeliveryDiscountItemIDs
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     */
    public static function calcBalancesBlock(array $shopDeliveryDiscountItemIDs, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        foreach ($shopDeliveryDiscountItemIDs as $child){
            self::calcBalanceBlock(intval($child), $sitePageData, $driver);
        }
    }

    /**
     * Сохранение список
     * @param $shopPriceListID
     * @param $shopClientID
     * @param $fromAt
     * @param $toAt
     * @param array $shopDeliveryPrices
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @return bool
     */
    public static function save($shopPriceListID, $shopClientID, $fromAt, $toAt,
                                array $shopDeliveryPrices, SitePageData $sitePageData,
                                Model_Driver_DBBasicDriver $driver)
    {
        $model = new Model_Ab1_Shop_Delivery_Discount_Item();
        $model->setDBDriver($driver);

        $params = Request_RequestParams::setParams(
            array(
                'shop_delivery_discount_id' => $shopPriceListID,
            )
        );
        $shopDeliveryDiscountItemIDs = Request_Request::find('DB_Ab1_Shop_Delivery_Discount_Item',
            $sitePageData->shopMainID, $sitePageData, $driver, $params, 0, TRUE
        );
        $shopDeliveryDiscountItemIDs->runIndex(true);

        foreach($shopDeliveryPrices as $id => $shopDeliveryPrice){
            $shopDeliveryID = intval(Arr::path($shopDeliveryPrice, 'shop_product_id', 0));
            $shopDeliveryRubricID = intval(Arr::path($shopDeliveryPrice, 'shop_product_rubric_id', 0));

            $discount = Request_RequestParams::strToFloat(Arr::path($shopDeliveryPrice, 'discount', 0));
            $price = Request_RequestParams::strToFloat(Arr::path($shopDeliveryPrice, 'price', 0));
            $amount = Request_RequestParams::strToFloat(Arr::path($shopDeliveryPrice, 'amount', 0));

            if(key_exists($id, $shopDeliveryDiscountItemIDs->childs)){
                $shopDeliveryDiscountItemIDs->childs[$id]->setModel($model);
                unset($shopDeliveryDiscountItemIDs->childs[$id]);
            }else{
                $model->clear();
                $model->setShopDeliveryDiscountID($shopPriceListID);
            }

            $model->setFromAt($fromAt);
            $model->setToAt($toAt);
            $model->setShopProductID($shopDeliveryID);
            $model->setShopProductRubricID($shopDeliveryRubricID);
            $model->setProductShopBranchID(Arr::path($shopDeliveryPrice, 'product_shop_branch_id', 0));
            $model->setShopClientID($shopClientID);
            $model->setPrice($price);
            $model->setDiscount($discount);
            $model->setAmount($amount);
            Helpers_DB::saveDBObject($model, $sitePageData, $sitePageData->shopMainID);
        }

        // удаляем лишние
        $driver->deleteObjectIDs(
            $shopDeliveryDiscountItemIDs->getChildArrayID(), $sitePageData->userID,
            Model_Ab1_Shop_Delivery_Discount_Item::TABLE_NAME, array(), $sitePageData->shopMainID
        );

        return TRUE;
    }
}
