<?php defined('SYSPATH') or die('No direct script access.');

class Api_Ab1_Shop_Bid_Item  {

    /**
     * Сохранение список продуrции плана
     * @param $shopBidID
     * @param $shopClientID
     * @param $date
     * @param array $shopBidItems
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @return bool
     */
    public static function save($shopBidID, $shopClientID, $date, array $shopBidItems,
                                SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        $model = new Model_Ab1_Shop_Bid_Item();
        $model->setDBDriver($driver);

        $params = Request_RequestParams::setParams(
            array(
                'shop_bid_id' => $shopBidID,
                'sort_by' => array('id' => 'asc')
            )
        );
        $shopBidItemIDs = Request_Request::find('DB_Ab1_Shop_Bid_Item',
            $sitePageData->shopID, $sitePageData, $driver, $params, 0, TRUE
        );

        $total = 0;
        foreach($shopBidItems as $shopBidItem){
            $shopProductID = intval(Arr::path($shopBidItem, 'shop_product_id', 0));
            if($shopProductID < 1){
                continue;
            }

            $quantity = Request_RequestParams::strToFloat(Arr::path($shopBidItem, 'quantity', 0));
            if($quantity <= 0){
                continue;
            }

            $model->clear();
            $shopBidItemID = array_shift($shopBidItemIDs->childs);
            if($shopBidItemID !== NULL){
                $model->__setArray(array('values' => $shopBidItemID->values));
            }

            $model->setShopProductID($shopProductID);
            $model->setQuantity($quantity);
            $model->setDelivery(Request_RequestParams::strToFloat(Arr::path($shopBidItem, 'delivery', 0)));

            $model->setDate($date);
            $model->setShopBidID($shopBidID);
            $model->setShopClientID($shopClientID);
            Helpers_DB::saveDBObject($model, $sitePageData);

            $total += $model->getQuantity();
        }

        // удаляем лишние
        $driver->deleteObjectIDs(
            $shopBidItemIDs->getChildArrayID(), $sitePageData->userID,
            Model_Ab1_Shop_Bid_Item::TABLE_NAME, array(), $sitePageData->shopID
        );

        return $total;
    }


    /**
     * Добавляем минуты в массив часов
     * @param array $time
     * @param $hour
     * @param $minute
     * @param $shopProductName
     * @param $isLeft
     * @param $quantity
     */
    private static function _addClientHour(array &$time, $hour, $minute, $shopProductName, $isLeft, $quantity){
        if ($isLeft){
            if (empty($time[$hour])){
                $time[$hour] = array(
                    'minute_left' => $minute,
                    'minute_right' => 0,
                    'shop_product_name_left' => array(
                        $shopProductName => $quantity,
                    ),
                    'shop_product_name_right' => array(),
                    'quantity_left' => $quantity,
                    'quantity_right' => 0,
                );
            }else{
                if($minute > $time[$hour]['minute_left']){
                    $time[$hour]['minute_left'] = $minute;
                }
                if (!key_exists($shopProductName, $time[$hour]['shop_product_name_left'])){
                    $time[$hour]['shop_product_name_left'][$shopProductName] = $quantity;
                }else {
                    $time[$hour]['shop_product_name_left'][$shopProductName] += $quantity;
                }
                $time[$hour]['quantity_left'] += $quantity;
            }
        }else{
            if (empty($time[$hour])){
                $time[$hour] = array(
                    'minute_left' => 0,
                    'minute_right' => $minute,
                    'shop_product_name_left' => array(),
                    'shop_product_name_right' => array(
                        $shopProductName => $quantity,
                    ),
                    'quantity_left' => 0,
                    'quantity_right' => $quantity,
                );
            }else{
                if($minute > $time[$hour]['minute_right']){
                    $time[$hour]['minute_right'] = $minute;
                }
                if (!key_exists($shopProductName, $time[$hour]['shop_product_name_right'])){
                    $time[$hour]['shop_product_name_right'][$shopProductName] = $quantity;
                }else {
                    $time[$hour]['shop_product_name_right'][$shopProductName] += $quantity;
                }
                $time[$hour]['quantity_right'] += $quantity;
            }
        }

    }

    /**
     * Добавляем минуты в массив часов и считаем общий массив
     * @param array $timeAll
     * @param array $time
     * @param $hour
     * @param $minute
     * @param $shopProductName
     * @param $isLeft
     * @param $quantity
     */
    private static function _addClientHourAndCalc(array &$timeAll, array &$time, $hour, $minute, $shopProductName,
                                                  $isLeft, $quantity){
        if ($hour < 10){
            $hour = '0'.$hour.':00';
        }else{
            $hour = $hour.':00';
        }

        self::_addClientHour($time, $hour, $minute, $shopProductName, $isLeft, $quantity);
        self::_addClientHour($timeAll, $hour, $minute, $shopProductName, $isLeft, $quantity);
    }

    /**
     * Получаем план заявок сгруппированных по клиентам и разбитым по часам дня
     * @param $date
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @return array
     */
    public static function getBidItemClients($date, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        if ($date === NULL) {
            $date = date('Y-m-d');
        }

        // получаем список
        $ids = Request_Request::find('DB_Ab1_Shop_Bid_Item', $sitePageData->shopID, $sitePageData, $driver, array('date' => $date),
            1000, TRUE, array('shop_client_id' => array('name'), 'shop_product_id' => array('name')));

        $dateFrom = strtotime(date('Y-m-d', strtotime($date)));
        $dateTo = $dateFrom + 24 * 60 * 60;

        $times = array();
        for ($i = 1; $i < 25; $i++){
            if ($i < 10){
                $times['0'.$i.':00'] = FALSE;
            }else{
                $times[$i.':00'] = FALSE;
            }
        }

        $clients[-1] = array(
            'name' => 'Общий итог',
            'time' => $times,
        );

        foreach ($ids->childs as $child){
            $shopClientID = $child->values['shop_client_id'];
            if(!key_exists($shopClientID, $clients)){
                $clients[$shopClientID] = array(
                    'name' => $child->getElementValue('shop_client_id'),
                    'time' => $times,
                );
            }

            $childFrom = strtotime($child->values['date_from']);
            if ($childFrom < $dateFrom){
                $childFrom = $dateFrom;
            }
            $hourFrom = date('H', $childFrom);
            $minuteFrom = date('i', $childFrom);

            $childTo = strtotime($child->values['date_to']);
            if ($childTo > $dateTo){
                $childTo = $dateTo;
            }
            $hourTo = date('H', $childTo);
            if ($hourTo == 0) {
                $hourTo = 23;
                $minuteTo = 60;
            }else{
                $minuteTo = date('i', $childTo);
            }

            // какое количество тонн в одной минуте
            $quantityMinute = $child->values['quantity'] / (($childTo - $childFrom) / 60);
            if ($quantityMinute < 0){
                continue;
            }

            $shopProductName = $child->getElementValue('shop_product_id');

            // добавляем в список времени
            self::_addClientHourAndCalc($clients[-1]['time'], $clients[$shopClientID]['time'],  $hourFrom,
                60 - $minuteFrom, $shopProductName, FALSE, $quantityMinute * (60 - $minuteFrom));

            for ($i = $hourFrom + 1; $i <= $hourTo; $i++){
                // добавляем в список времени
                self::_addClientHourAndCalc($clients[-1]['time'], $clients[$shopClientID]['time'], $i,  60,
                    $shopProductName, TRUE, $quantityMinute * 60);
            }
            if ($minuteTo > 0) {
                // добавляем в список времени
                self::_addClientHourAndCalc($clients[-1]['time'], $clients[$shopClientID]['time'], $hourTo + 1, $minuteTo,
                    $shopProductName, TRUE, $quantityMinute * $minuteTo);
            }
        }
        return $clients;
    }
}
