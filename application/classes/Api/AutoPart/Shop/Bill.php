<?php defined('SYSPATH') or die('No direct script access.');

class Api_AutoPart_Shop_Bill {
    /**
     * Пересчитываем количество
     * @param $shopBillID
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @throws HTTP_Exception_404
     */
    public static function calcTotal($shopBillID, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver){
        $ids = Request_Request::find(
            DB_AutoPart_Shop_Bill_Item::NAME, 0, $sitePageData, $driver,
            Request_RequestParams::setParams(
                [
                    'shop_bill_id' => $shopBillID,
                ]
            )
        );

        $quantity = 0;
        $amount = 0;
        foreach ($ids->childs as $child){
            $quantity += $child->values['quantity'];
            $amount += $child->values['amount'];
        }

        return [
            'quantity' => $quantity,
            'amount' => $amount,
        ];
    }

    /**
     * Сохранение заказа
     * @param Model_AutoPart_Shop_Bill $model
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @throws HTTP_Exception_404
     */
    public static function saveModel(Model_AutoPart_Shop_Bill $model, SitePageData $sitePageData,
                                     Model_Driver_DBBasicDriver $driver)
    {
        $model->setDBDriver($driver);

        $total = self::calcTotal($model->id, $sitePageData, $driver);
        $model->setQuantity($total['quantity']);
        $model->setAmount($total['amount']);

        // покупатель
        if(Request_RequestParams::getParamBoolean('is_buyer')) {
            $modelBuyer = new Model_AutoPart_Shop_Bill_Buyer();
            $modelBuyer->setDBDriver($driver);

            if ($model->getShopBillBuyerID() > 0) {
                Helpers_DB::getDBObject($modelBuyer, $model->getShopBillBuyerID(), $sitePageData);
            }

            $s = Request_RequestParams::getParamStr('buyer_firstname');
            if (!empty($s)) {
                $modelBuyer->setFirstName($s);
            }

            $s = Request_RequestParams::getParamStr('buyer_lastname');
            if (!empty($s)) {
                $modelBuyer->setLastName($s);
            }

            $s = Request_RequestParams::getParamStr('buyer_phone');
            if (!empty($s)) {
                $modelBuyer->setPhone($s);
            }

            $modelBuyer->setOldID($model->id);
            Helpers_DB::saveDBObject($modelBuyer, $sitePageData);

            $model->setShopBillBuyerID($modelBuyer->id);
            $model->setBuyer($modelBuyer->getName());
        }

        // адрес
        if(Request_RequestParams::getParamBoolean('is_delivery')) {
            $modelDelivery = new Model_AutoPart_Shop_Bill_Delivery_Address();
            $modelDelivery->setDBDriver($driver);

            if ($model->getShopBillDeliveryAddressID() > 0) {
                Helpers_DB::getDBObject($modelDelivery, $model->getShopBillDeliveryAddressID(), $sitePageData);
            }

            $s = Request_RequestParams::getParamStr('delivery_city_name');
            if (!empty($s)) {
                $modelDelivery->setCityName($s);
            }

            $s = Request_RequestParams::getParamStr('delivery_street');
            if (!empty($s)) {
                $modelDelivery->setStreet($s);
            }

            $s = Request_RequestParams::getParamStr('delivery_house');
            if (!empty($s)) {
                $modelDelivery->setHouse($s);
            }

            $s = Request_RequestParams::getParamStr('delivery_apartment');
            if (!empty($s)) {
                $modelDelivery->setApartment($s);
            }

            $s = Request_RequestParams::getParamStr('delivery_latitude');
            if (!empty($s)) {
                $modelDelivery->setLatitude($s);
            }

            $s = Request_RequestParams::getParamStr('delivery_longitude');
            if (!empty($s)) {
                $modelDelivery->setLongitude($s);
            }

            $modelDelivery->setShopSourceID($model->getShopSourceID());
            Helpers_DB::saveDBObject($modelDelivery, $sitePageData);

            $model->setShopBillDeliveryAddressID($modelDelivery->id);
            $model->setDeliveryAddress($modelDelivery->getName());
        }

        Helpers_DB::saveDBObject($model, $sitePageData);

        // добавляем точку в маршрут
        Api_AutoPart_Shop_Courier_Route::addBill(Helpers_DateTime::getCurrentDatePHP(), $model, $sitePageData, $driver);
    }
}
