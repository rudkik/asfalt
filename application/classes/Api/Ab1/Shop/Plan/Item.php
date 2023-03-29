<?php defined('SYSPATH') or die('No direct script access.');

class Api_Ab1_Shop_Plan_Item  {

    /**
     * Считаем фактическую реализацию
     * @param $date
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     */
    public static function calcQuantityFact($date, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        $date = Helpers_DateTime::getDateFormatPHP($date);
        if(empty($date)){
            $date = date('Y-m-d');
        }

        // получаем план реализации
        $params = Request_RequestParams::setParams(
            array(
                'date' => $date,
            )
        );
        $shopPlanItemIDs = Request_Request::findBranch('DB_Ab1_Shop_Plan_Item',
            array(), $sitePageData, $driver, $params, 0, TRUE
        );
        $shopPlanItems = array();
        foreach ($shopPlanItemIDs->childs as $child){
            $child->additionDatas['quantity_fact'] = 0;

            $model = new Model_Ab1_Shop_Plan_Item();
            $model->setDBDriver($driver);
            $child->setModel($model);
            $model->setQuantityFact(0);
            $shopPlanItems[$child->values['shop_client_id'].'_'.$child->values['shop_product_id']] = $model;
        }

        $params = Request_RequestParams::setParams(
            array(
                'exit_at_from' => $date . ' 06:00:00',
                'exit_at_to' => Helpers_DateTime::plusDays($date . ' 06:00:00', 1),
                'is_exit' => 1,
                'sum_quantity' => TRUE,
                'group_by' => array('shop_product_id', 'shop_client_id')
            )
        );

        // считаем реализацию машин
        $ids = Request_Request::findBranch('DB_Ab1_Shop_Car_Item',
            array(), $sitePageData, $driver, $params,0, TRUE
        );
        foreach ($ids->childs as $child){
            $key = $child->values['shop_client_id'].'_'.$child->values['shop_product_id'];
            if(key_exists($key, $shopPlanItems)){
                $shopPlanItems[$key]->setQuantityFact($shopPlanItems[$key]->getQuantityFact() + $child->values['quantity']);
            }else{
                $key = '0_'.$child->values['shop_product_id'];
                if(key_exists($key, $shopPlanItems)){
                    $shopPlanItems[$key]->setQuantityFact($shopPlanItems[$key]->getQuantityFact() + $child->values['quantity']);
                }
            }
        }

        // считаем реализацию штучного товара
        $pieceIDs = Request_Request::findBranch('DB_Ab1_Shop_Piece_Item',
            array(), $sitePageData, $driver, $params,0, TRUE
        );
        foreach ($pieceIDs->childs as $child){
            $key = $child->values['shop_client_id'].'_'.$child->values['shop_product_id'];
            if(key_exists($key, $shopPlanItems)){
                $shopPlanItems[$key]->setQuantityFact($shopPlanItems[$key]->getQuantityFact() + $child->values['quantity']);
            }else{
                $key = '0_'.$child->values['shop_product_id'];
                if(key_exists($key, $shopPlanItems)){
                    $shopPlanItems[$key]->setQuantityFact($shopPlanItems[$key]->getQuantityFact() + $child->values['quantity']);
                }
            }
        }

        // сохраняем фактическое количество реализации
        foreach ($shopPlanItems as $model){
            Helpers_DB::saveDBObject($model, $sitePageData, $model->shopID);
        }
    }


    /**
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @return array
     * @throws HTTP_Exception_500
     */
    public static function save(SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        $model = new Model_Ab1_Shop_Plan_Item();
        $model->setDBDriver($driver);

        $id = Request_RequestParams::getParamInt('id');
        if($id > 0) {
            if (!Helpers_DB::dublicateObjectLanguage($model, $id, $sitePageData)) {
                throw new HTTP_Exception_500('Plan item not found.');
            }
        }

        Request_RequestParams::setParamBoolean('is_public', $model);
        Request_RequestParams::setParamStr('text', $model);
        Request_RequestParams::setParamStr('name', $model);
        Request_RequestParams::setParamStr("old_id", $model);
        Request_RequestParams::setParamInt('shop_client_id', $model);
        Request_RequestParams::setParamDateTime('date', $model);


        Request_RequestParams::setParamFloat("quantity", $model);
        Request_RequestParams::setParamFloat('quantity_fact', $model);
        Request_RequestParams::setParamInt('plan_reason_type_id', $model);

        $options = Request_RequestParams::getParamArray('options');
        if ($options !== NULL) {
            $model->addOptionsArray($options);
        }

        $result = array();
        if ($model->validationFields($result)) {
            Helpers_DB::saveDBObject($model, $sitePageData);
            $result['values'] = $model->getValues();
        }

        return array(
            'id' => $model->id,
            'result' => $result,
        );
    }


    /**
     * Сохранение список продукции плана
     * @param $shopPlanID
     * @param $shopClientID
     * @param $date
     * @param $dateFrom
     * @param $dateTo
     * @param array $shopPlanItems
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @return bool
     */
    public static function saveList($shopPlanID, $shopClientID, $date, $dateFrom, $dateTo, array $shopPlanItems,
                                SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        $model = new Model_Ab1_Shop_Plan_Item();
        $model->setDBDriver($driver);

        $shopPlanItemIDs = Request_Request::find('DB_Ab1_Shop_Plan_Item', $sitePageData->shopID, $sitePageData, $driver,
            array('shop_plan_id' => $shopPlanID, Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE), 0, TRUE);

        foreach($shopPlanItems as $shopPlanItem){
            $shopProductID = intval(Arr::path($shopPlanItem, 'shop_product_id', 0));
            if($shopProductID < 1){
                continue;
            }

            $quantity = Request_RequestParams::strToFloat(Arr::path($shopPlanItem, 'quantity', 0));
            if($quantity <= 0){
                continue;
            }

            $model->clear();
            $shopPlanItemID = array_shift($shopPlanItemIDs->childs);
            if($shopPlanItemID !== NULL){
                $model->__setArray(array('values' => $shopPlanItemID->values));
            }

            $model->setShopProductID($shopProductID);
            $model->setQuantity($quantity);
            $model->setShopTurnPlaceID(intval(Arr::path($shopPlanItem, 'shop_turn_place_id', 0)));
            $model->setWorkingShift(intval(Arr::path($shopPlanItem, 'working_shift', 0)));

            $model->setDate($date);
            $model->setDateFrom($dateFrom);
            $model->setDateTo($dateTo);
            $model->setShopPlanID($shopPlanID);
            $model->setShopClientID($shopClientID);
            Helpers_DB::saveDBObject($model, $sitePageData);
        }

        // удаляем лишние
        $driver->deleteObjectIDs($shopPlanItemIDs->getChildArrayID(), $sitePageData->userID,
            Model_Ab1_Shop_Plan_Item::TABLE_NAME, array(), $sitePageData->shopID);

        return TRUE;
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
    public static function getPlanItemClients($date, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        if ($date === NULL) {
            $date = date('Y-m-d');
        }

        // получаем список
        $ids = Request_Request::findBranch('DB_Ab1_Shop_Plan_Item',
            array(), $sitePageData, $driver, array('period' => $date), 1000, TRUE,
            array('shop_client_id' => array('name'), 'shop_product_id' => array('name'))
        );

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
