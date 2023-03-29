<?php defined('SYSPATH') or die('No direct script access.');

class Api_Ab1_Shop_Product_Price  {
    /**
     * Просчет заблокированного баланса продукта прайс-листа
     * @param int $shopProductPriceID
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @param bool $isSaveAmount
     * @param string | null $dateTo
     * @return bool|int
     * @throws HTTP_Exception_500
     */
    public static function calcBalanceBlock($shopProductPriceID, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver,
                                            $isSaveAmount = TRUE, $dateTo = null)
    {
        $shopProductPriceID = intval($shopProductPriceID);
        if($shopProductPriceID < 1) {
            return FALSE;
        }

        $amount = 0;
        $params = Request_RequestParams::setParams(
            array(
                'shop_product_price_id' => $shopProductPriceID,
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
            $model = new Model_Ab1_Shop_Product_Price();
            $model->setDBDriver($driver);
            if (!Helpers_DB::getDBObject($model, $shopProductPriceID, $sitePageData, $sitePageData->shopMainID)) {
                throw new HTTP_Exception_500('Product price id="' . $shopProductPriceID . '" not found. #10032001612');
            }
            $model->setBlockAmount($amount);
            Helpers_DB::saveDBObject($model, $sitePageData);
        }

        return $amount;
    }

    /**
     *  Просчет заблокированного баланса продуктов прайс-листов
     * @param array $shopProductPriceIDs
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     */
    public static function calcBalancesBlock(array $shopProductPriceIDs, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        foreach ($shopProductPriceIDs as $child){
            self::calcBalanceBlock(intval($child), $sitePageData, $driver);
        }
    }

    /**
     * Сохранение список
     * @param $shopPriceListID
     * @param $shopClientID
     * @param $fromAt
     * @param $toAt
     * @param array $shopProductPrices
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @return bool
     */
    public static function save($shopPriceListID, $shopClientID, $fromAt, $toAt,
                                array $shopProductPrices, SitePageData $sitePageData,
                                Model_Driver_DBBasicDriver $driver)
    {
        $model = new Model_Ab1_Shop_Product_Price();
        $model->setDBDriver($driver);

        $params = Request_RequestParams::setParams(
            array(
                'shop_pricelist_id' => $shopPriceListID,
            )
        );
        $shopProductPriceIDs = Request_Request::find('DB_Ab1_Shop_Product_Price',
            $sitePageData->shopMainID, $sitePageData, $driver, $params, 0, TRUE
        );
        $shopProductPriceIDs->runIndex(true);

        foreach($shopProductPrices as $id => $shopProductPrice){
            $shopProductID = intval(Arr::path($shopProductPrice, 'shop_product_id', 0));
            $shopProductRubricID = intval(Arr::path($shopProductPrice, 'shop_product_rubric_id', 0));

            $discount = Request_RequestParams::strToFloat(Arr::path($shopProductPrice, 'discount', 0));
            $price = Request_RequestParams::strToFloat(Arr::path($shopProductPrice, 'price', 0));
            $amount = Request_RequestParams::strToFloat(Arr::path($shopProductPrice, 'amount', 0));

            if(key_exists($id, $shopProductPriceIDs->childs)){
                $shopProductPriceIDs->childs[$id]->setModel($model);
                unset($shopProductPriceIDs->childs[$id]);
            }else{
                $model->clear();
                $model->setShopPriceListID($shopPriceListID);
            }

            $model->setFromAt($fromAt);
            $model->setToAt($toAt);
            $model->setShopProductID($shopProductID);
            $model->setShopProductRubricID($shopProductRubricID);
            $model->setProductShopBranchID(Arr::path($shopProductPrice, 'product_shop_branch_id', 0));
            $model->setShopClientID($shopClientID);
            $model->setPrice($price);
            $model->setDiscount($discount);
            $model->setAmount($amount);
            Helpers_DB::saveDBObject($model, $sitePageData, $sitePageData->shopMainID);
        }

        // удаляем лишние
        $driver->deleteObjectIDs(
            $shopProductPriceIDs->getChildArrayID(), $sitePageData->userID,
            Model_Ab1_Shop_Product_Price::TABLE_NAME, array(), $sitePageData->shopMainID
        );

        return TRUE;
    }
}
