<?php defined('SYSPATH') or die('No direct script access.');

class Api_AutoPart_Shop_Courier_Route {
    /**
     * Находим маршрут курьера, если не находим, то создаем
     * @param $date
     * @param $shopCourierID
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @return Model_AutoPart_Shop_Courier_Route
     */
    public static function getRoute($date, $shopCourierID, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        /** @var Model_AutoPart_Shop_Courier_Route $modelRoute */
        $modelRoute = Request_Request::findOneModel(
            DB_AutoPart_Shop_Courier_Route::NAME, $sitePageData->shopID, $sitePageData, $driver,
            Request_RequestParams::setParams(
                [
                    'date' => $date,
                    'shop_courier_id' => $shopCourierID,
                    'is_finish' => false,
                ]
            )
        );

        if($modelRoute == false){
            $modelRoute = new Model_AutoPart_Shop_Courier_Route();
            $modelRoute->setDBDriver($driver);

            $modelRoute->setDate($date);
            $modelRoute->setShopCourierID($shopCourierID);

            Helpers_DB::saveDBObject($modelRoute, $sitePageData);
        }

        return $modelRoute;
    }

    /**
     * Добавляем новую точку в маршрут из закупа товаров
     * @param Model_AutoPart_Shop_PreOrder $modelPreOrder
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     */
    public static function addPreOrder(Model_AutoPart_Shop_PreOrder $modelPreOrder, SitePageData $sitePageData,
                                       Model_Driver_DBBasicDriver $driver)
    {
        if($modelPreOrder->getShopCourierID() < 1){
            return;
        }

        $modelRoute = self::getRoute($modelPreOrder->getDate(), $modelPreOrder->getShopCourierID(), $sitePageData, $driver);

        /** @var Model_AutoPart_Shop_Courier_Route_Item $modelItem */
        $modelItem = Request_Request::findOneModel(
            DB_AutoPart_Shop_Courier_Route_Item::NAME, $sitePageData->shopID, $sitePageData, $driver,
            Request_RequestParams::setParams(
                [
                    'shop_pre_order_id' => $modelPreOrder->id,
                ]
            )
        );

        if($modelItem == false) {
            $modelItem = new Model_AutoPart_Shop_Courier_Route_Item();
            $modelItem->setDBDriver($driver);

            $modelItem->setShopPreOrderID($modelPreOrder->id);
        }

        $modelItem->setShopCourierRouteID($modelRoute->id);
        $modelItem->setShopCourierID($modelPreOrder->getShopCourierID());
        $modelItem->setShopSupplierID($modelPreOrder->getShopSupplierID());
        $modelItem->setShopSupplierAddressID($modelPreOrder->getShopSupplierAddressID());
        $modelItem->setOrder(1000);

        Helpers_DB::saveDBObject($modelItem, $sitePageData);
    }

    /**
     * Добавляем новую точку в маршрут из заказа
     * @param $date
     * @param Model_AutoPart_Shop_Bill $modelBill
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @param null | index $index
     */
    public static function addBill($date, Model_AutoPart_Shop_Bill $modelBill, SitePageData $sitePageData,
                                   Model_Driver_DBBasicDriver $driver, $index = null)
    {
        if($modelBill->getShopCourierID() < 1){
            return;
        }

        $modelRoute = self::getRoute($date, $modelBill->getShopCourierID(), $sitePageData, $driver);

        /** @var Model_AutoPart_Shop_Courier_Route_Item $modelItem */
        $modelItem = Request_Request::findOneModel(
            DB_AutoPart_Shop_Courier_Route_Item::NAME, $sitePageData->shopID, $sitePageData, $driver,
            Request_RequestParams::setParams(
                [
                    'shop_bill_id' => $modelBill->id,
                ]
            )
        );

        if($modelItem == false) {
            $modelItem = new Model_AutoPart_Shop_Courier_Route_Item();
            $modelItem->setDBDriver($driver);

            $modelItem->setShopBillID($modelBill->id);
        }

        $modelItem->setShopCourierRouteID($modelRoute->id);
        $modelItem->setShopCourierID($modelBill->getShopCourierID());
        $modelItem->setShopOtherAddressID($modelBill->getShopOtherAddressID());
        $modelItem->setShopBillDeliveryAddressID($modelBill->getShopBillDeliveryAddressID());

        if($index === null){
            $index = 1000;
        }
        $modelItem->setOrder($index);

        Helpers_DB::saveDBObject($modelItem, $sitePageData);


        // Фиксируем факт переноса на подочет курьеру
        $shopBillItemIDs = Request_Request::find(
            DB_AutoPart_Shop_Bill_Item::NAME, $sitePageData->shopID,
            $sitePageData, $driver,
            Request_RequestParams::setParams(['shop_bill_id' => $modelBill->id])
        );

        $modelBillItem = new Model_AutoPart_Shop_Bill_Item();
        $modelBillItem->setDBDriver($driver);

        foreach ($shopBillItemIDs->childs as $child){
            $child->setModel($modelBillItem);

            $modelBillItem->setNewShopCourierID($modelBill->getShopCourierID());
            Helpers_DB::saveDBObject($modelBillItem, $sitePageData);
        }
    }

    /**
     * Добавляем новую точку в маршрут из закупа товаров
     * @param Model_AutoPart_Shop_Courier_Route $model
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     */
    public static function calcStatistic(Model_AutoPart_Shop_Courier_Route $model, SitePageData $sitePageData,
                                         Model_Driver_DBBasicDriver $driver)
    {
        $shopCourierRouteItemIDs = Request_Request::find(
            DB_AutoPart_Shop_Courier_Route_Item::NAME, $sitePageData->shopID, $sitePageData, $driver,
            Request_RequestParams::setParams(['shop_courier_route_id' => $model->id]),
            0, true,
            ['shop_bill_id' => ['shop_bill_status_source_id', 'delivery_at', 'shop_courier_id']]
        );

        $quantityPreOrder = 0;
        $quantityBill = 0;
        $quantityReturn = 0;
        foreach ($shopCourierRouteItemIDs->childs as $child){
            if($child->values['shop_bill_id'] > 0
                && ($child->values['is_finish'] == 1
                    || ($child->getElementValue('shop_bill_id', 'shop_bill_status_source_id') == Model_AutoPart_Shop_Bill_Status_Source::STATUS_COMPLETED
                        && Helpers_DateTime::getDateFormatPHP($child->getElementValue('shop_bill_id', 'delivery_at')) == $model->getDate()
                        && $child->getElementValue('shop_bill_id', 'shop_courier_id') == $model->getShopCourierID()))){
                $quantityBill++;
            }elseif($child->values['shop_pre_order_id'] > 0 && $child->values['is_finish'] == 1){
                $quantityPreOrder++;
            }elseif($child->values['shop_bill_return_id'] > 0 && $child->values['is_finish'] == 1){
                $quantityReturn++;
            }
        }

        $model->setQuantityPreOrderPoints($quantityPreOrder);
        $model->setQuantityBillPoints($quantityBill);
        $model->setQuantityReturnPoints($quantityReturn);

        $model->setPricePoint(700);
        if($model->getPriceKm() < 0.001) {
            $model->setPriceKm(21.24);
        }
    }

    /**
     * Определяем время последней точки
     * @param Model_AutoPart_Shop_Courier_Route $model
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @return string | null
     */
    public static function getLastPointTime(Model_AutoPart_Shop_Courier_Route $model, SitePageData $sitePageData,
                                            Model_Driver_DBBasicDriver $driver)
    {
        $shopCourierRouteItemIDs = Request_Request::find(
            DB_AutoPart_Shop_Courier_Route_Item::NAME, $sitePageData->shopID, $sitePageData, $driver,
            Request_RequestParams::setParams(['shop_courier_route_id' => $model->id]),
            0, true,
            ['shop_bill_id' => ['shop_bill_status_source_id', 'delivery_at', 'shop_courier_id']]
        );

        $result = null;
        foreach ($shopCourierRouteItemIDs->childs as $child){
            if($child->values['is_finish'] != 1){
                if($child->values['shop_bill_id'] > 0
                    && $child->getElementValue('shop_bill_id', 'shop_courier_id') == $model->getShopCourierID()
                    && $child->getElementValue('shop_bill_id', 'shop_bill_status_source_id') == Model_AutoPart_Shop_Bill_Status_Source::STATUS_COMPLETED){

                    $tmp = $child->getElementValue('shop_bill_id', 'delivery_at');
                    if(Helpers_DateTime::getDateFormatPHP($tmp) == $model->getDate()) {
                        if (!empty($tmp) && ($result == null || strtotime($result) < strtotime($tmp))) {
                            $result = $tmp;
                        }
                    }
                }else {
                    continue;
                }
            }

            $tmp = $child->values['to_at'];
            if(Helpers_DateTime::getDateFormatPHP($tmp) == $model->getDate()) {
                if (!empty($tmp) && ($result == null || strtotime($result) < strtotime($tmp))) {
                    $result = $tmp;
                }
            }
        }

        return $result;
    }

    /**
     * Определяем время первой точки
     * @param Model_AutoPart_Shop_Courier_Route $model
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @return string | null
     */
    public static function getFirstPointTime(Model_AutoPart_Shop_Courier_Route $model, SitePageData $sitePageData,
                                             Model_Driver_DBBasicDriver $driver)
    {
        $shopCourierRouteItemIDs = Request_Request::find(
            DB_AutoPart_Shop_Courier_Route_Item::NAME, $sitePageData->shopID, $sitePageData, $driver,
            Request_RequestParams::setParams(['shop_courier_route_id' => $model->id]),
            0, true,
            ['shop_bill_id' => ['shop_bill_status_source_id', 'delivery_at', 'shop_courier_id']]
        );

        $result = null;
        foreach ($shopCourierRouteItemIDs->childs as $child){
            if($child->values['is_finish'] != 1){
                if($child->values['shop_bill_id'] > 0
                    && $child->getElementValue('shop_bill_id', 'shop_bill_status_source_id')
                    && $child->getElementValue('shop_bill_id', 'shop_courier_id') == $model->getShopCourierID()){

                    $tmp = $child->getElementValue('shop_bill_id', 'delivery_at');
                    if(Helpers_DateTime::getDateFormatPHP($tmp) == $model->getDate()) {
                        if (!empty($tmp) && ($result == null || strtotime($result) > strtotime($tmp))) {
                            $result = $tmp;
                        }
                    }
                }else {
                    continue;
                }
            }

            $tmp = $child->values['to_at'];
            if(Helpers_DateTime::getDateFormatPHP($tmp) == $model->getDate()) {
                if (!empty($tmp) && ($result == null || strtotime($result) > strtotime($tmp))) {
                    $result = $tmp;
                }
            }
        }

        return $result;
    }

    /**
     * Сохранение адреса
     * @param Model_AutoPart_Shop_Courier_Route $model
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @throws HTTP_Exception_404
     */
    public static function saveModel(Model_AutoPart_Shop_Courier_Route $model, SitePageData $sitePageData,
                                     Model_Driver_DBBasicDriver $driver)
    {
        $model->setDBDriver($driver);
        $model->setQuantityOtherPoints($model->getQuantityOtherPoints());
        $model->setSeconds($model->getSeconds());

        Helpers_DB::saveDBObject($model, $sitePageData);
    }
}
