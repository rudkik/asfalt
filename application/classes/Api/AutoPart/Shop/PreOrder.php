<?php defined('SYSPATH') or die('No direct script access.');

class Api_AutoPart_Shop_PreOrder
{
    /**
     * Пересчитываем количество
     * @param $shopPreOrderID
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @throws HTTP_Exception_404
     */
    public static function calcTotal($shopPreOrderID, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver){
        $ids = Request_Request::find(
            DB_AutoPart_Shop_Bill_Item::NAME, 0, $sitePageData, $driver,
            Request_RequestParams::setParams(
                [
                    'shop_pre_order_id' => $shopPreOrderID,
                ]
            )
        );

        $quantity = 0;
        $amount = 0;
        foreach ($ids->childs as $child){
            $quantity += $child->values['quantity'];
            $amount += $child->values['price_cost'] / 100 * (100 + $child->values['commission_supplier']) * $child->values['quantity'];
        }

        return [
            'quantity' => $quantity,
            'amount' => $amount,
        ];
    }

    /**
     * Сохранение закупа
     * @param Model_AutoPart_Shop_PreOrder $model
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @throws HTTP_Exception_404
     */
    public static function saveModel(Model_AutoPart_Shop_PreOrder $model, SitePageData $sitePageData,
                                     Model_Driver_DBBasicDriver $driver)
    {
        $model->setDBDriver($driver);

        $total = self::calcTotal($model->id, $sitePageData, $driver);
        $model->setQuantity($total['quantity']);
        $model->setAmount($total['amount']);

        Helpers_DB::saveDBObject($model, $sitePageData);

        // добавляем точку в маршрут
        Api_AutoPart_Shop_Courier_Route::addPreOrder($model, $sitePageData, $driver);
    }

}