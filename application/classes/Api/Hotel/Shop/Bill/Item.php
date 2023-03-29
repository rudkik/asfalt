<?php defined('SYSPATH') or die('No direct script access.');

class Api_Hotel_Shop_Bill_Item  {
    /**
     * Отменяем заказ
     * @param $shopBillID
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     */
    public static function cancel($shopBillID, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        $model = new Model_Hotel_Shop_Bill_Item();
        $model->setDBDriver($driver);

        $params = Request_RequestParams::setParams(
            array(
                'shop_bill_id' => $shopBillID,
                'is_public' => 1,
            )

        );
        $shopBillItemIDs = Request_Request::find('DB_Hotel_Shop_Bill_Item', $sitePageData->shopID, $sitePageData, $driver,
            $params, 0, TRUE);

        // удаляем лишние
        $driver->updateObjects(Model_Hotel_Shop_Bill_Item::TABLE_NAME, $shopBillItemIDs->getChildArrayID(),
            array('is_public' => 0));

        $shopBillServiceIDs = Request_Request::find('DB_Hotel_Shop_Service', $sitePageData->shopID, $sitePageData, $driver,
            $params, 0, TRUE);

        // удаляем лишние
        $driver->updateObjects(Model_Hotel_Shop_Bill_Service::TABLE_NAME, $shopBillServiceIDs->getChildArrayID(),
            array('is_public' => 0));
    }

    /**
     * Восстановить заказ
     * @param $shopBillID
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     */
    public static function unCancel($shopBillID, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        $model = new Model_Hotel_Shop_Bill_Item();
        $model->setDBDriver($driver);

        $params = Request_RequestParams::setParams(
            array(
                'shop_bill_id' => $shopBillID,
                'is_public' => 0,
            )

        );
        $shopBillItemIDs = Request_Request::find('DB_Hotel_Shop_Bill_Item', $sitePageData->shopID, $sitePageData, $driver,
            $params, 0, TRUE);

        // удаляем лишние
        $driver->updateObjects(Model_Hotel_Shop_Bill_Item::TABLE_NAME, $shopBillItemIDs->getChildArrayID(),
            array('is_public' => 1));

        $shopBillServiceIDs = Request_Request::find('DB_Hotel_Shop_Service', $sitePageData->shopID, $sitePageData, $driver,
            $params, 0, TRUE);

        // удаляем лишние
        $driver->updateObjects(Model_Hotel_Shop_Bill_Service::TABLE_NAME, $shopBillServiceIDs->getChildArrayID(),
            array('is_public' => 1));
    }

    /**
     * Группируем номера по датам
     * @param array $shopBillItems
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @return array
     */
    public static function groupItems(array $shopBillItems, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        $result = array();
        foreach ($shopBillItems as $key => $shopBillItem){
            $shopRoomID = Arr::path($shopBillItem, 'shop_room_id', 0);
            if($shopRoomID < 1){
                continue;
            }

            $dateFrom = Arr::path($shopBillItem, 'date_from', NULL);
            $dateFrom = strtotime($dateFrom, NULL);
            if ($dateFrom === NULL){
                continue;
            }

            $dateTo = Arr::path($shopBillItem, 'date_to', NULL);
            $dateTo = strtotime($dateTo, NULL);
            if ($dateTo === NULL){
                continue;
            }

            if ($dateFrom > $dateTo){
                continue;
            }

            $isAdd = TRUE;
            foreach ($result as &$child){
                if ($child['shop_room_id'] != $shopRoomID){
                    continue;
                }
                if(($child['d_from'] == $dateTo)
                    && ($child['human_extra'] == $shopBillItem['human_extra'])
                    && ($child['child_extra'] == $shopBillItem['child_extra'])
                    && ($child['price'] == $shopBillItem['price'])){
                    $child['d_from'] = $dateFrom;
                    $child['date_from'] = $shopBillItem['date_from'];

                    $child['amount'] += $shopBillItem['amount'];
                    $isAdd = FALSE;
                    break;
                }

                if(($child['d_to'] == $dateFrom)
                    && ($child['human_extra'] == $shopBillItem['human_extra'])
                    && ($child['child_extra'] == $shopBillItem['child_extra'])
                    && ($child['price'] == $shopBillItem['price'])){
                    $child['d_to'] = $dateTo;
                    $child['date_to'] = $shopBillItem['date_to'];

                    $child['amount'] += $shopBillItem['amount'];
                    $isAdd = FALSE;
                    break;
                }
            }

            if($isAdd){
                $shopBillItem['d_from'] = $dateFrom;
                $shopBillItem['d_to'] = $dateTo;
                $result[] = $shopBillItem;
            }
        }

        return $result;
    }

    /**
     * @param $shopBillID
     * @param $shopClientID
     * @param array $shopBillItems
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @return array
     */
    public static function save($shopBillID, $shopClientID, array $shopBillItems, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        $model = new Model_Hotel_Shop_Bill_Item();
        $model->setDBDriver($driver);

        $shopBillItemIDs = Request_Request::find('DB_Hotel_Shop_Bill_Item',
            $sitePageData->shopID, $sitePageData, $driver,
            array('shop_bill_id' => $shopBillID, 'is_public_ignore' => TRUE,
                Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE),
            0, TRUE
        );

        $modelRoom = new Model_Hotel_Shop_Room();
        $modelRoom->setDBDriver($driver);

        // разбиваем данные о ценах по комнатам и дням
        $detailedPriceRooms = array();
        foreach ($shopBillItemIDs->childs as $child){
            $detailed = Arr::path(json_decode($child->values['options'], TRUE), 'detailed', array());

            $shopRoomID = $child->values['shop_room_id'];
            if(!key_exists($shopRoomID, $detailedPriceRooms)){
                $detailedPriceRooms[$shopRoomID] = array();
            }

            foreach ($detailed as $day => $prices){
                $detailedPriceRooms[$shopRoomID][$day] = $prices;
            }
        }

        $total = 0;
        $totalFrom = NULL;
        $totalTo = NULL;
        foreach($shopBillItems as $shopBillItem){
            $dateFrom = Arr::path($shopBillItem, 'date_from', NULL);
            $dateFrom = strtotime($dateFrom, NULL);
            if ($dateFrom === NULL){
                continue;
            }

            $dateTo = Arr::path($shopBillItem, 'date_to', NULL);
            $dateTo = strtotime($dateTo, NULL);
            if ($dateTo === NULL){
                continue;
            }

            if ($dateFrom > $dateTo){
                continue;
            }

            $shopRoomID = intval(Arr::path($shopBillItem, 'shop_room_id', 0));
            if($shopRoomID < 1){
                continue;
            }

            if(! Helpers_DB::getDBObject($modelRoom, $shopRoomID, $sitePageData)){
                continue;
            }

            // проверяем, чтобы номер не был занят
           /* $notFree = Request_Request::find('DB_Hotel_Shop_Bill_Item',
                $sitePageData->shopID, $sitePageData, $driver,
                Request_RequestParams::setParams(
                    [
                        'shop_room_id' => $shopRoomID,
                        'not_shop_bill_id' => $shopBillID,
                        'period_from' => date('Y-m-d', $dateFrom),
                        'period_to' => date('Y-m-d', $dateTo),
                    ]
                )
            );
            if(count($notFree->childs) > 0){
                continue;
            }*/

            $shopBillItemID = array_shift($shopBillItemIDs->childs);
            if($shopBillItemID !== NULL){
                $shopBillItemID->setModel($model);
            }else{
                $model->clear();
            }

            $model->setShopClientID($shopClientID);
            $model->setShopRoomID($shopRoomID);
            $model->setHumanExtra(Arr::path($shopBillItem, 'human_extra', 0));
            $model->setChildExtra(Arr::path($shopBillItem, 'child_extra', 0));

            $model->setPrice($modelRoom->getPrice());
            $model->setPriceExtra($modelRoom->getPriceExtra());
            $model->setPriceChild($modelRoom->getPriceChild());

            $model->setDateFrom(date('Y-m-d H:i:s', $dateFrom));
            $model->setDateTo(date('Y-m-d H:i:s', $dateTo));


            if(key_exists($shopRoomID, $detailedPriceRooms)){
                $detailedPriceDays = $detailedPriceRooms[$shopRoomID];
            }else{
                $detailedPriceDays = array();
            }

            $detailedPriceDays = Api_Hotel_Shop_Room::getAmountRoomOfValues(
                $shopRoomID, $detailedPriceDays,
                $model->getHumanExtra(), $model->getChildExtra(),
                $model->getDateFrom(), date('Y-m-d H:i:s', $dateTo - 24 * 60 * 60),
                $sitePageData, $driver, TRUE
            );

            $model->setAmount($detailedPriceDays['amount']);
            $model->addOptionsArray(array('detailed' => $detailedPriceDays['detailed']));

            $detailedPriceRooms[$shopRoomID] = $detailedPriceDays['detailed'];

            $model->setShopBillID($shopBillID);
            Helpers_DB::saveDBObject($model, $sitePageData);

            $total = $total + $model->getAmount();
            if(($totalFrom > $dateFrom) || ($totalFrom === NULL)){
                $totalFrom = $dateFrom;
            }
            if(($totalTo < $dateTo) || ($totalTo === NULL)){
                $totalTo = $dateTo;
            }
        }

        // удаляем лишние
        $driver->deleteObjectIDs($shopBillItemIDs->getChildArrayID(), $sitePageData->userID,
            Model_Hotel_Shop_Bill_Item::TABLE_NAME, array(), $sitePageData->shopID);

        if($totalFrom !== NULL){
            $totalFrom = date('Y-m-d H:i:s', $totalFrom);
        }
        if($totalTo !== NULL){
            $totalTo = date('Y-m-d H:i:s', $totalTo);
        }

        return array(
            'amount' => $total,
            'date_from' => $totalFrom,
            'date_to' => $totalTo,
            'detailed' => $detailedPriceRooms,
        );
    }
}
