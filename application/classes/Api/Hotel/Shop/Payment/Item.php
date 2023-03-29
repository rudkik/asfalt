<?php defined('SYSPATH') or die('No direct script access.');

class Api_Hotel_Shop_Payment_Item  {

    /**
     * Сохранение список оплаченных комнат
     * @param $shopPaymentID
     * @param $shopClientID
     * @param array $shopPaymentItems
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @return int
     */
    public static function save($shopPaymentID, $shopClientID, array $shopPaymentItems, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        $model = new Model_Hotel_Shop_Payment_Item();
        $model->setDBDriver($driver);

        $shopPaymentItemIDs = Request_Request::find('DB_Hotel_Shop_Payment_Item', $sitePageData->shopID, $sitePageData, $driver,
            array('shop_payment_id' => $shopPaymentID, Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE), 0, TRUE);

        $modelRoom = new Model_Hotel_Shop_Room();
        $modelRoom->setDBDriver($driver);

        $total = 0;
        $names = '';
        foreach($shopPaymentItems as $shopPaymentItem){
            $dateFrom = Arr::path($shopPaymentItem, 'date_from', NULL);
            $dateFrom = strtotime($dateFrom, NULL);
            if ($dateFrom === NULL){
                continue;
            }

            $dateTo = Arr::path($shopPaymentItem, 'date_to', NULL);
            $dateTo = strtotime($dateTo, NULL);
            if ($dateTo === NULL){
                continue;
            }

            $shopRoomID = intval(Arr::path($shopPaymentItem, 'shop_room_id', 0));
            if($shopRoomID < 1){
                continue;
            }

            if(! Helpers_DB::getDBObject($modelRoom, $shopRoomID, $sitePageData)){
                continue;
            }

            $names .= $modelRoom->getName()."\r\n";

            $model->clear();
            $shopPaymentItemID = array_shift($shopPaymentItemIDs->childs);
            if($shopPaymentItemID !== NULL){
                $model->__setArray(array('values' => $shopPaymentItemID->values));
            }

            $model->setShopClientID($shopClientID);
            $model->setShopRoomID($shopRoomID);
            $model->setHumanExtra(Arr::path($shopPaymentItem, 'human_extra', 0));
            $model->setChildExtra(Arr::path($shopPaymentItem, 'child_extra', 0));

            $model->setPrice($modelRoom->getPrice());
            $model->setPriceExtra($modelRoom->getPriceExtra());
            $model->setPriceChild($modelRoom->getPriceChild());

            $model->setDateFrom(date('Y-m-d H:i:s', $dateFrom));
            $model->setDateTo(date('Y-m-d H:i:s', $dateTo));

            $diff = Helpers_DateTime::diffDays($model->getDateTo(), $model->getDateFrom());
            if ($diff < 0){
                $diff = 0;
            }
            $model->setAmount(($modelRoom->getPrice()
                    + $modelRoom->getPriceExtra() * $model->getHumanExtra()
                    + $modelRoom->getPriceChild() * $model->getChildExtra()) * $diff
            );

            $model->setShopPaymentID($shopPaymentID);
            Helpers_DB::saveDBObject($model, $sitePageData);

            $total = $total + $model->getAmount();
        }
        $names = substr($names, 0, -2);

        // удаляем лишние
        $driver->deleteObjectIDs($shopPaymentItemIDs->getChildArrayID(), $sitePageData->userID, Model_Hotel_Shop_Payment_Item::TABLE_NAME);

        return array(
            'amount' => $total,
            'rooms' => $names,
        );
    }
}
