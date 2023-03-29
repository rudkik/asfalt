<?php defined('SYSPATH') or die('No direct script access.');

class Api_Ab1_Shop_Car  {
    /**
     * Удаляем блокировку фиксированных цен
     * @param $shopCarID
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     */
    public static function deleteClientBalanceDays($shopCarID, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        self::setCurrentPrice($shopCarID, $sitePageData, $driver, false);

        Api_Ab1_Shop_Client_Balance_Day::deleteBlockCarClientBalanceDay($shopCarID, $sitePageData, $driver, null);
    }

    /**
     * Устанавливаем цены на момент реализации не учитывая фиксированные балансы
     * @param $shopCarID
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @param bool $isUpdateBalanceDay
     * @throws HTTP_Exception_404
     */
    public static function setCurrentPrice($shopCarID, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver,
                                           $isUpdateBalanceDay = true)
    {
        $model = new Model_Ab1_Shop_Car();
        $model->setDBDriver($driver);
        if(!Helpers_DB::getDBObject($model, $shopCarID, $sitePageData)){
            throw new HTTP_Exception_404('Car not is found!');
        }

        // получаем товары реализации
        $ids = Request_Request::find(
            DB_Ab1_Shop_Car_Item::NAME,
            $sitePageData->shopID, $sitePageData, $driver,
            Request_RequestParams::setParams(
                array(
                    'shop_car_id' => $shopCarID
                )
            ),
            0, true
        );

        $modelItem = new Model_Ab1_Shop_Car_Item();
        $modelItem->setDBDriver($driver);

        $total = 0;
        $priceOne = 0;
        foreach ($ids->childs as $child){
            $child->setModel($modelItem);

            $modelItem->setShopClientBalanceDayID(0);

            $price = Api_Ab1_Shop_Product::getPrice(
                $modelItem->getShopClientID(),
                $modelItem->getShopClientContractID(),
                0,
                $modelItem->getShopProductID(),
                $modelItem->getIsCharity(),
                $modelItem->getQuantity(),
                $sitePageData, $driver, TRUE,
                $model->getCreatedAt()
            );

            $modelItem->setPrice($price['price']);
            $modelItem->setShopClientContractItemID($price['shop_client_contract_item_id']);
            $modelItem->setShopProductPriceID($price['shop_product_price_id']);
            $modelItem->setShopProductTimePriceID($price['shop_product_time_price_id']);
            $modelItem->setShopClientBalanceDayID(0);

            Helpers_DB::saveDBObject($modelItem, $sitePageData);

            $total += $modelItem->getAmount();
            $priceOne = $modelItem->getPrice();
        }

        if($model->getIsOneAttorney()){
            $model->setPrice($priceOne);
            $total = $model->getAmount();
        }

        if($isUpdateBalanceDay){
            Api_Ab1_Shop_Car::setAmount($total, $model, $sitePageData, $driver);
        }else{
            $model->setAmount($total);
        }

        // обновляем балансы клиента
        Api_Ab1_Shop_Client::recountBalanceObject(
            null, $sitePageData, $driver, $model->getShopClientID()
        );

        Helpers_DB::saveDBObject($model, $sitePageData);
    }

    /**
     * Разбиваем реализацию по фиксированных балансам и устанавливаем цены
     * @param $shopCarID
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @throws HTTP_Exception_404
     */
    public static function breakBalanceDay($shopCarID, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        $model = new Model_Ab1_Shop_Car();
        $model->setDBDriver($driver);
        if(!Helpers_DB::getDBObject($model, $shopCarID, $sitePageData)){
            throw new HTTP_Exception_404('Car not is found!');
        }

        // освобождаем заблокированные суммы фиксированных балансов
        Api_Ab1_Shop_Client_Balance_Day::deleteBlockCarClientBalanceDay(
            $shopCarID, $sitePageData, $driver
        );

        // получаем свободные фиксированные суммы
        $balanceDayIDs = Api_Ab1_Shop_Client_Balance_Day::findClientBalanceDaysByClient(
            $model->getShopClientID(), $sitePageData, $driver, $model->getCreatedAt()
        );

        // получаем товары реализации
        $ids = Request_Request::find(
            DB_Ab1_Shop_Car_Item::NAME,
            $sitePageData->shopID, $sitePageData, $driver,
            Request_RequestParams::setParams(
                array(
                    'shop_car_id' => $shopCarID
                )
            ),
            0, true
        );

        $modelItem = new Model_Ab1_Shop_Car_Item();
        $modelItem->setDBDriver($driver);

        // группируем одинаковые реализации в одну
        $group = new MyArray();
        foreach ($ids->childs as $child){
            $key = $child->values['shop_product_id'].'_'
                . $child->values['price'].'_'
                . $child->values['shop_car_id'].'_'
                . $child->values['shop_client_id'].'_'
                . $child->values['shop_client_attorney_id'].'_'
                . $child->values['shop_client_contract_id'].'_'
                . $child->values['shop_invoice_id'].'_'
                . $child->values['shop_client_contract_item_id'].'_'
                . $child->values['shop_product_price_id'].'_'
                . $child->values['shop_product_time_price_id'].'_'
                . $child->values['shop_client_balance_day_id'].'_';

            if(key_exists($key, $group->childs)){
                $group->childs[$key]->setModel($modelItem);

                $item = $group->childs[$key];
                $item->values['quantity'] += $child->values['quantity'];
                $item->values['amount'] = round($item->values['quantity'] * $item->values['price'], 2);

                Helpers_DB::delDBByID(DB_Ab1_Shop_Car_Item::NAME, $child->id, $sitePageData, $driver);

                $modelItem->setQuantity($item->values['quantity']);
                Helpers_DB::saveDBObject($modelItem, $sitePageData);
            }else{
                $group->childs[$key] = $child;
            }
        }

        // получаем товары реализации
        $ids = Request_Request::find(
            DB_Ab1_Shop_Car_Item::NAME,
            $sitePageData->shopID, $sitePageData, $driver,
            Request_RequestParams::setParams(
                array(
                    'shop_car_id' => $shopCarID
                )
            ),
            0, true
        );

        $total = 0;
        $priceOne = 0;
        $isOneAttorney = count($ids->childs) == 1;
        foreach ($ids->childs as $child){
            $child->setModel($modelItem);

            $modelItem->setShopClientBalanceDayID(0);

            $isBalance = false;
            foreach ($balanceDayIDs->childs as $balanceDayID) {
                if($balanceDayID->values['balance'] < 0.0001){
                    continue;
                }

                $price = Api_Ab1_Shop_Product::getPrice(
                    $modelItem->getShopClientID(),
                    $modelItem->getShopClientContractID(),
                    $balanceDayID->id,
                    $modelItem->getShopProductID(),
                    $modelItem->getIsCharity(),
                    $modelItem->getQuantity(),
                    $sitePageData, $driver, TRUE,
                    $model->getCreatedAt()
                );

                if($balanceDayID->values['balance'] / $price['price'] < 0.001){
                    continue;
                }

                // если всю сумма помещается в фиксированных баланс
                if(round($price['price'] * $modelItem->getQuantity(), 2) <= $balanceDayID->values['balance']){
                    $modelItem->setPrice($price['price']);
                    $modelItem->setShopClientContractItemID($price['shop_client_contract_item_id']);
                    $modelItem->setShopProductPriceID($price['shop_product_price_id']);
                    $modelItem->setShopProductTimePriceID($price['shop_product_time_price_id']);
                    $modelItem->setShopClientBalanceDayID($balanceDayID->id);
                    Helpers_DB::saveDBObject($modelItem, $sitePageData);

                    $balanceDayID->values['balance'] -= $modelItem->getAmount();
                    $total += $modelItem->getAmount();
                    $isBalance = true;
                    break;
                }

                $isOneAttorney = false;

                // если нужно разбить строку на несколько фиксированных балансов
                $modelNew = new Model_Ab1_Shop_Car_Item();
                $modelNew->copy($modelItem, true);

                $modelNew->setPrice($price['price']);
                $modelNew->setShopClientContractItemID($price['shop_client_contract_item_id']);
                $modelNew->setShopProductPriceID($price['shop_product_price_id']);
                $modelNew->setShopProductTimePriceID($price['shop_product_time_price_id']);
                $modelNew->setShopClientBalanceDayID($balanceDayID->id);

                $modelNew->setQuantity($balanceDayID->values['balance'] / $modelNew->getPrice());
                Helpers_DB::saveDBObject($modelNew, $sitePageData);

                $total += $modelNew->getAmount();
                $balanceDayID->values['balance'] -= $modelItem->getAmount();

                $modelItem->setQuantity($modelItem->getQuantity() - $modelNew->getQuantity());
                Helpers_DB::saveDBObject($modelItem, $sitePageData);
            }

            $priceOne = $modelItem->getPrice();

            if($isBalance){
                continue;
            }

            // пересчитываем сумма реализации товара, если он стал не фиксированной ценой
            $price = Api_Ab1_Shop_Product::getPrice(
                $modelItem->getShopClientID(),
                $modelItem->getShopClientContractID(),
                0,
                $modelItem->getShopProductID(),
                $modelItem->getIsCharity(),
                $modelItem->getQuantity(),
                $sitePageData, $driver, TRUE,
                $model->getCreatedAt()
            );

            $modelItem->setPrice($price['price']);
            $modelItem->setShopClientContractItemID($price['shop_client_contract_item_id']);
            $modelItem->setShopProductPriceID($price['shop_product_price_id']);
            $modelItem->setShopProductTimePriceID($price['shop_product_time_price_id']);
            $modelItem->setShopClientBalanceDayID(0);

            Helpers_DB::saveDBObject($modelItem, $sitePageData);

            $total += $modelItem->getAmount();
        }

        $model->setIsOneAttorney($isOneAttorney);
        if($isOneAttorney){
            $model->setPrice($priceOne);
            $total = $model->getAmount();
        }
        Api_Ab1_Shop_Car::setAmount($total, $model, $sitePageData, $driver);

        // обновляем балансы клиента
        Api_Ab1_Shop_Client::recountBalanceObject(
            null, $sitePageData, $driver, $model->getShopClientID()
        );

        Helpers_DB::saveDBObject($model, $sitePageData);
    }

    /**
     * Задаем суммы реализации
     * @param $amount
     * @param Model_Ab1_Shop_Car $model
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     */
    public static function setAmount($amount, Model_Ab1_Shop_Car $model, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        $model->setAmount($amount);

        // блокируем сумму реализации в фиксированных балансах
        if(!$model->getIsDelete()) {
            Api_Ab1_Shop_Client_Balance_Day::blockCarClientBalanceDay(
                $model->getShopClientID(), $model->id,
                $model->getDeliveryAmount() + $model->getAmountService(),
                $sitePageData, $driver, $model->getCreatedAt(), true
            );

            Api_Ab1_Shop_Client_Balance_Day::blockCarClientBalanceDay(
                $model->getShopClientID(), $model->id,
                $model->getAmount(),
                $sitePageData, $driver, $model->getCreatedAt()
            );
        }
    }

    /**
     * Удаляем скидку у заданного продукта с заданной ценой, ставим цену по прайсу
     * @param $dateFrom
     * @param $dateTo
     * @param $shopClientID
     * @param $shopClientAttorneyID
     * @param $shopClientContractID
     * @param $productTypeID
     * @param $isDelivery
     * @param $shopProductID
     * @param $price
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @return bool
     */
    public static function deleteDiscountProduct($dateFrom, $dateTo, $shopClientID, $shopClientAttorneyID, $shopClientContractID,
                                         $productTypeID, $isDelivery, $shopProductID, $price,
                                         SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        if($shopClientID < 1 || $shopProductID < 0){
            return false;
        }

        $params = Request_RequestParams::setParams(
            array(
                'exit_at_from' => $dateFrom,
                'exit_at_to' => $dateTo,
                'shop_client_id' => $shopClientID,
                'shop_car_id.shop_client_id' => $shopClientID,
                'shop_client_attorney_id' => $shopClientAttorneyID,
                'shop_client_contract_id' => $shopClientContractID,
                'shop_product_id' => $shopProductID,
                'shop_product_id.product_type_id' => $productTypeID,
                'price' => $price,
                'is_exit' => TRUE,
                'is_charity' => FALSE,
                'is_delivery' => $isDelivery,
                'shop_invoice_id' => 0,
            )
        );

        $shopCarItemIDs = Request_Request::find(
            'DB_Ab1_Shop_Car_Item', $sitePageData->shopID, $sitePageData, $driver, $params, 0, TRUE,
            ['shop_car_id' => ['created_at']]
        );

        foreach ($shopCarItemIDs->childs as $child) {
            self::calcPriceCar(
                $child->getElementValue('shop_car_id', 'created_at'), $child->values['shop_car_id'],
                $sitePageData, $driver, $child->values['id'], false, true
            );
            $shopClientID = $child->values['shop_client_id'];
        }

        // штручный товар
        $shopPieceItemIDs = Request_Request::find(
            'DB_Ab1_Shop_Piece_Item', $sitePageData->shopID, $sitePageData, $driver, $params, 0, true,
            ['shop_piece_id' => ['created_at']]
        );
        foreach ($shopPieceItemIDs->childs as $child) {
            Api_Ab1_Shop_Piece::calcPricePiece(
                $child->getElementValue('shop_piece_id', 'created_at'), $child->values['shop_piece_id'],
                $sitePageData, $driver, $child->values['id'], false, true
            );
        }

        // пересчитать баланс клиента
        Api_Ab1_Shop_Client::recountBalanceObject(
            null, $sitePageData, $driver, $shopClientID
        );

        return true;
    }

    /**
     * Получаем список ТТН
     * @param $dateFrom
     * @param $dateTo
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @param $isQuantityReceive
     * @param array $params
     * @return MyArray
     */
    public static function getTTNs($dateFrom, $dateTo, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver,
                                   $isQuantityReceive, $params = array())
    {
        if($dateFrom == null){
            $dateFrom = date('Y-m-d 06:00:00');
        }

        if($dateTo == null){
            $dateTo = Helpers_DateTime::plusDays($dateFrom, 1);
        }

        $receiverShopSubdivisionID = Arr::path($params, 'receiver_shop_subdivision_id', 0);
        $shopClientID = Arr::path($params, 'shop_client_id', 0);
        $shopBranchDaughterReceiverID = Arr::path($params, 'shop_branch_daughter_receiver_id', 0);

        $sortBy = Arr::path($params, 'sort_by.value', Arr::path($params, 'sort_by', null));
        if(empty($sortBy)){
            $sortBy = ['id' => 'desc'];
        }
        unset($params['limit_page']);

        $dataCars = new MyArray();
        $dataCars->additionDatas = array(
            'data' => array(),
            'brutto' => 0,
            'netto' => 0,
            'tare' => 0,
        );

        if($receiverShopSubdivisionID < 1) {
            $paramsNew = $params;
            $paramsNew['shop_id'] = $shopBranchDaughterReceiverID;

            // реализация
            $ids = Api_Ab1_Shop_Car::getExitShopCar(
                $dateFrom, $dateTo, $sitePageData, $driver,
                array(
                    'shop_transport_company_id' => array('name'),
                    'shop_client_id' => array('name'),
                    'shop_product_id' => array('name'),
                    'shop_id' => array('name'),
                ),
                $paramsNew, true, null
            );

            foreach ($ids->childs as $child) {
                $quantity = $child->values['quantity'];

                $tmp = $dataCars->addChild($child->values['id']);
                $tmp->setIsFind(true);
                $tmp->values = array(
                    'date' => $child->values['exit_at'],
                    'id' => $child->values['id'],
                    'shop_id' => $child->values['shop_id'],
                    'daughter' => $child->getElementValue('shop_id'),
                    'transport_company' => $child->getElementValue('shop_transport_company_id'),
                    'number' => $child->values['name'],
                    'heap_receiver' => $child->getElementValue('shop_client_id'),
                    'heap_daughter' => '',
                    'product' => $child->getElementValue('shop_product_id'),
                    'brutto' => $child->values['tarra'] + $quantity,
                    'netto' => $quantity,
                    'tare' => $child->values['tarra'],
                    'table_id' => Model_Ab1_Shop_Car::TABLE_ID,
                );

                $dataCars->additionDatas['brutto'] += $child->values['tarra'] + $quantity;
                $dataCars->additionDatas['netto'] += $quantity;
                $dataCars->additionDatas['tare'] += $child->values['tarra'];
            }

            // штучный товар
            $ids = Api_Ab1_Shop_Piece::getExitShopPieces(
                $dateFrom, $dateTo, $sitePageData, $driver,
                array(
                    'shop_transport_company_id' => array('name'),
                    'shop_client_id' => array('name'),
                    'shop_id' => array('name'),
                ),
                $paramsNew, true, null
            );

            foreach ($ids->childs as $child) {
                $quantity = $child->values['quantity'];

                $tmp = $dataCars->addChild($child->values['id']);
                $tmp->setIsFind(true);
                $tmp->values = array(
                    'date' => $child->values['created_at'],
                    'id' => $child->values['id'],
                    'shop_id' => $child->values['shop_id'],
                    'daughter' => $child->getElementValue('shop_id'),
                    'transport_company' => $child->getElementValue('shop_transport_company_id'),
                    'number' => $child->values['name'],
                    'heap_receiver' => $child->getElementValue('shop_client_id'),
                    'heap_daughter' => '',
                    'product' => $child->values['text'],
                    'brutto' => $quantity,
                    'netto' => $quantity,
                    'tare' => 0,
                    'table_id' => Model_Ab1_Shop_Piece::TABLE_ID,
                );

                $dataCars->additionDatas['brutto'] += $quantity;
                $dataCars->additionDatas['netto'] += $quantity;
            }
        }

        if($shopClientID < 1) {
            if ($receiverShopSubdivisionID > 0) {
                $params['shop_subdivision_receiver_id'] = $receiverShopSubdivisionID;
            }

            $params['date_document_from'] = $dateFrom;
            $params['date_document_to'] = $dateTo;

            $ids = Request_Request::find('DB_Ab1_Shop_Car_To_Material',
                $sitePageData->shopID, $sitePageData, $driver, $params, 0, TRUE,
                array(
                    'shop_daughter_id' => array('name'),
                    'shop_material_id' => array('name'),
                    'shop_client_material_id' => array('name'),
                    'shop_branch_receiver_id' => array('name'),
                    'shop_branch_daughter_id' => array('name'),
                    'shop_heap_daughter_id' => array('name'),
                    'shop_heap_receiver_id' => array('name'),
                    'shop_subdivision_receiver_id' => array('name'),
                    'shop_subdivision_receiver_id' => array('name'),
                    'shop_transport_company_id' => array('name'),
                )
            );

            foreach ($ids->childs as $child) {
                if ($isQuantityReceive) {
                    $quantity = $child->values['quantity'];
                } elseif ($child->values['quantity_invoice'] > 0.001) {
                    $quantity = $child->values['quantity_invoice'];
                } else {
                    $quantity = $child->values['quantity_daughter'];
                }

                $tmp = $dataCars->addChild($child->values['id']);
                $tmp->setIsFind(true);
                $tmp->values = array(
                    'date' => $child->values['created_at'],
                    'id' => $child->values['id'],
                    'shop_id' => $child->values['shop_id'],
                    'daughter' => $child->getElementValue('shop_client_material_id', 'name', $child->getElementValue('shop_daughter_id', 'name', $child->getElementValue('shop_branch_daughter_id'))),
                    'transport_company' => $child->getElementValue('shop_transport_company_id'),
                    'number' => $child->values['name'],
                    'heap_receiver' => $child->getElementValue('shop_heap_receiver_id'),
                    'heap_daughter' => $child->getElementValue('shop_heap_daughter_id'),
                    'subdivision_receiver' => $child->getElementValue('shop_subdivision_receiver_id'),
                    'subdivision_daughter' => $child->getElementValue('shop_subdivision_daughter_id', 'name', $child->getElementValue('shop_daughter_id')),
                    'product' => $child->getElementValue('shop_material_id'),
                    'brutto' => $child->values['tarra'] + $quantity,
                    'netto' => $quantity,
                    'tare' => $child->values['tarra'],
                    'table_id' => Model_Ab1_Shop_Car_To_Material::TABLE_ID,
                );

                $dataCars->additionDatas['brutto'] += $child->values['tarra'] + $quantity;
                $dataCars->additionDatas['netto'] += $quantity;
                $dataCars->additionDatas['tare'] += $child->values['tarra'];
            }
        }
        $dataCars->childsSortBy($sortBy, false, true);

        return $dataCars;
    }

    /**
     * Просчет суммы реализации
     * @param $shopCarID
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @param bool $isSaveAmount
     * @return bool|int
     * @throws HTTP_Exception_500
     */
    public static function calcCarAmount($shopCarID, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver,
                                         $isSaveAmount = FALSE)
    {
        if($shopCarID < 1){
            return FALSE;
        }

        $amount = 0;
        $params = Request_RequestParams::setParams(
            array(
                'shop_car_id' => $shopCarID,
                'sum_amount' => TRUE,
            )
        );
        // реализация
        $ids = Request_Request::find('DB_Ab1_Shop_Car_Item',
            $sitePageData->shopID, $sitePageData, $driver, $params, 0, TRUE
        );
        if(count($ids->childs) > 0){
            $amount += $ids->childs[0]->values['amount'];
        }

        if($isSaveAmount) {
            $model = new Model_Ab1_Shop_Car();
            $model->setDBDriver($driver);

            if (!Helpers_DB::dublicateObjectLanguage($model, $shopCarID, $sitePageData)) {
                throw new HTTP_Exception_500('Car not found. #56');
            }

            Api_Ab1_Shop_Car::setAmount($amount, $model, $sitePageData, $driver);
            Helpers_DB::saveDBObject($model, $sitePageData);
        }

        return $amount;
    }

    /**
     * Пересчитываем цены продукции одной машины для старых записей
     * @param $shopCarID
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @param int | null $shopCarItemID
     * @param boolean $isCalcBalance
     * @throws HTTP_Exception_500
     */
    public static function calcPriceCarOld($shopCarID, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver,
                                           $shopCarItemID = null, $isCalcBalance = false)
    {
        $model = new Model_Ab1_Shop_Car();
        $model->setDBDriver($driver);
        if(! Helpers_DB::getDBObject($model, $shopCarID, $sitePageData)){
            throw new HTTP_Exception_500('Car not found.');
        }

        $params = Request_RequestParams::setParams(
            array(
                'shop_car_id' => $shopCarID,
                'id' => $shopCarItemID,
            )
        );
        // реализация
        $shopCarItemIDs = Request_Request::find('DB_Ab1_Shop_Car_Item',
            $sitePageData->shopID, $sitePageData, $driver, $params, 0, TRUE
        );

        $modelItem = new Model_Ab1_Shop_Car_Item();
        $modelItem->setDBDriver($driver);

        $modelProduct = new Model_Ab1_Shop_Product();
        $modelProduct->setDBDriver($driver);

        $modelProductTime = new Model_Ab1_Shop_Product_Time_Price();
        $modelProductTime->setDBDriver($driver);

        $modelContractItem = new Model_Ab1_Shop_Client_Contract_Item();
        $modelContractItem->setDBDriver($driver);

        $priceEl = 0;
        foreach ($shopCarItemIDs->childs as $child){
            $child->setModel($modelItem);

            if($modelItem->getShopProductTimePriceID() > 0
                && Helpers_DB::getDBObject($modelProductTime, $modelItem->getShopProductTimePriceID(), $sitePageData, 0)){
                $modelItem->setPrice($modelProductTime->getPrice());
            }else{
                // получаем цену за заданный период
                $modelPrice = Api_Ab1_Shop_Product_Time_Price::getProductTimePrice(
                    $modelItem->getShopProductID(), $model->getCreatedAt(), $sitePageData, $driver
                );
                if($modelPrice != null) {
                    $modelItem->setPrice($modelPrice->getPrice());
                    $modelItem->setShopProductTimePriceID($modelPrice->id);
                }
            }

            if($modelItem->getShopClientContractItemID() > 0
                && Helpers_DB::getDBObject($modelContractItem, $modelItem->getShopClientContractItemID(), $sitePageData, 0)){


                if ($modelContractItem->getDiscount() > 0) {
                    $modelItem->setPrice($modelItem->getPrice() - $modelContractItem->getDiscount());
                }else {
                    $modelItem->setPrice($modelContractItem->getPrice());
                }
            }

            Helpers_DB::saveDBObject($modelItem, $sitePageData);

            $priceEl = $modelItem->getPrice();
        }

        $total =  self::calcCarAmount($shopCarID, $sitePageData, $driver);

        if($model->getIsOneAttorney()){
            $model->setPrice($priceEl);
            $total = $model->getAmount();
        }else{
            $model->setPrice(0);
        }

        Api_Ab1_Shop_Car::setAmount($total, $model, $sitePageData, $driver);
        Helpers_DB::saveDBObject($model, $sitePageData);

        // обновляем балансы клиента
        if($isCalcBalance) {
            Api_Ab1_Shop_Client::recountBalanceObject(
                $model, $sitePageData, $driver
            );
        }
    }

    /**
     * Пересчитываем цены продукции одной машины для новых записей
     * @param $shopCarID
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @param int | null $shopCarItemID
     * @param boolean $isCalcBalance
     * @param boolean $isNotDiscount
     * @throws HTTP_Exception_500
     */
    public static function calcPriceCarNew($shopCarID, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver,
                                           $shopCarItemID = null, $isCalcBalance = false, $isNotDiscount = false)
    {
        $model = new Model_Ab1_Shop_Car();
        $model->setDBDriver($driver);
        if(! Helpers_DB::getDBObject($model, $shopCarID, $sitePageData)){
            throw new HTTP_Exception_500('Car not found.');
        }

        $params = Request_RequestParams::setParams(
            array(
                'shop_car_id' => $shopCarID,
                'id' => $shopCarItemID,
            )
        );
        // реализация
        $shopCarItemIDs = Request_Request::find('DB_Ab1_Shop_Car_Item',
            $sitePageData->shopID, $sitePageData, $driver, $params, 0, TRUE
        );

        // зануляем использованный объем по договорам
        $shopClientContractItemIDs = $shopCarItemIDs->getChildArrayInt('shop_client_contract_item_id', TRUE);
        if (!empty($shopClientContractItemIDs)) {
            $driver->updateObjects(
                Model_Ab1_Shop_Car_Item::TABLE_NAME, $shopCarItemIDs->getChildArrayID(),
                array('shop_client_contract_item_id' => 0)
            );

            // пересчитываем заблокированные суммы детворы договора
            Api_Ab1_Shop_Client_Contract_Item::calcBalancesBlock($shopClientContractItemIDs, $sitePageData, $driver);
        }

        // зануляем использованный объем по прайс-листам
        $shopProductPriceIDs = $shopCarItemIDs->getChildArrayInt('shop_product_price_id', TRUE);
        if (!empty($shopProductPriceIDs)) {
            $driver->updateObjects(
                Model_Ab1_Shop_Car_Item::TABLE_NAME, $shopCarItemIDs->getChildArrayID(),
                array('shop_product_price_id' => 0)
            );

            // пересчитываем баланс договора
            Api_Ab1_Shop_Product_Price::calcBalancesBlock($shopProductPriceIDs, $sitePageData, $driver);
        }

        $modelItem = new Model_Ab1_Shop_Car_Item();
        $modelItem->setDBDriver($driver);

        $priceEl = 0;
        foreach ($shopCarItemIDs->childs as $child){
            $child->values['shop_client_contract_item_id'] = -1;
            $child->values['shop_product_price_id'] = -1;
            $child->setModel($modelItem);

            $price = Api_Ab1_Shop_Product::getPrice(
                $modelItem->getShopClientID(),
                $modelItem->getShopClientContractID(),
                $modelItem->getShopClientBalanceDayID(),
                $modelItem->getShopProductID(),
                $model->getIsCharity(),
                $modelItem->getQuantity(),
                $sitePageData, $driver, TRUE,
                $model->getCreatedAt(),
                $isNotDiscount
            );
            $shopProductPriceIDs[$price['shop_product_price_id']] = $price['shop_product_price_id'];

            $modelItem->setPrice($price['price']);
            $modelItem->setShopClientContractItemID($price['shop_client_contract_item_id']);
            $modelItem->setShopProductPriceID($price['shop_product_price_id']);
            $modelItem->setShopProductTimePriceID($price['shop_product_time_price_id']);
            $modelItem->setShopClientBalanceDayID($price['shop_client_balance_day_id']);
            Helpers_DB::saveDBObject($modelItem, $sitePageData);

            $priceEl = $price['price'];
        }

        $total =  self::calcCarAmount($shopCarID, $sitePageData, $driver);

        if($total != $model->getAmount()){
            if($model->getIsOneAttorney()){
                $model->setPrice($priceEl);
                $total = $model->getAmount();
            }else{
                $model->setPrice(0);
            }

            Api_Ab1_Shop_Car::setAmount($total, $model, $sitePageData, $driver);
            Helpers_DB::saveDBObject($model, $sitePageData);
        }

        // обновляем балансы клиента
        if($isCalcBalance) {
            Api_Ab1_Shop_Client::recountBalanceObject(
                $model, $sitePageData, $driver
            );
        }
    }

    /**
     * Пересчитываем цены продукции одной машины
     * @param $shopCarID
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @param int | null $shopCarItemID
     * @param boolean $isCalcBalance
     * @param boolean $isNotDiscount
     * @throws HTTP_Exception_500
     */
    public static function calcPriceCar($date, $shopCarID, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver,
                                        $shopCarItemID = null, $isCalcBalance = false, $isNotDiscount = false)
    {
        if(empty($date)){
            $date = date('Y-m-d H:i:s');
        }

        if(Helpers_DateTime::diffDays(date('Y-m-d H:i:s'), $date) <= 10){
            Api_Ab1_Shop_Car::calcPriceCarNew(
                $shopCarID, $sitePageData, $driver, $shopCarItemID, $isCalcBalance, $isNotDiscount
            );
        }else{
            Api_Ab1_Shop_Car::calcPriceCarOld(
                $shopCarID, $sitePageData, $driver, $shopCarItemID, $isCalcBalance, $isNotDiscount
            );
        }
    }

    /**
     * Пересчитываем цены продукции списка машин
     * @param $shopClientID
     * @param $shopClientAttorneyID
     * @param $shopClientContractID
     * @param $isDelivery
     * @param $dateFrom
     * @param $dateTo
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @throws HTTP_Exception_500
     */
    public static function calcPriceCars($shopClientID, $shopClientAttorneyID, $shopClientContractID,
                                         $isDelivery, $dateFrom, $dateTo,
                                         SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        $params = Request_RequestParams::setParams(
            array(
                'exit_at_from_or_not_exit' => $dateFrom,
                'exit_at_to_or_not_exit' => $dateTo,
                'shop_client_id' => $shopClientID,
                'shop_car_id.shop_client_id' => $shopClientID,
                'shop_client_attorney_id' => $shopClientAttorneyID,
                'shop_client_contract_id' => $shopClientContractID,
                'is_charity' => FALSE,
                'is_delivery' => $isDelivery,
                'shop_invoice_id' => 0,
                'sort_by' => array(
                    'id' => 'asc',
                )
            )
        );
        // реализация
        $shopCarItemIDs = Request_Request::find('DB_Ab1_Shop_Car_Item',
            $sitePageData->shopID, $sitePageData, $driver, $params, 0, true,
            ['shop_car_id' => ['created_at']]
        );

        foreach ($shopCarItemIDs->childs as $child){
            self::calcPriceCar(
                $child->getElementValue('shop_car_id', 'created_at'), $child->values['shop_car_id'],
                $sitePageData, $driver, $child->values['id']
            );
        }
    }

    /**
     * Изменяем данные машин одного клиента + доверенность на другого клиента + доверенность
     * на сумму и за период
     * @param $dateFrom
     * @param $dateTo
     * @param $shopClientIDFrom
     * @param $shopClientIDTo
     * @param $shopClientAttorneyIDFrom
     * @param $shopClientAttorneyIDTo
     * @param $shopClientContractIDFrom
     * @param $shopClientContractIDTo
     * @param $productTypeID
     * @param bool $isDelivery
     * @param int $shopProductID
     * @param $amount
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @return bool
     */
    public static function breakAttorney($dateFrom, $dateTo, $shopClientIDFrom, $shopClientIDTo,
                                         $shopClientAttorneyIDFrom, $shopClientAttorneyIDTo,
                                         $shopClientContractIDFrom, $shopClientContractIDTo,
                                         $productTypeID, $isDelivery, $shopProductID, $amount,
                                         SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        if($shopClientIDTo < 1){
            $shopClientIDTo = $shopClientIDFrom;
        }

        $isAll = $amount  < 0.001;

        if($shopProductID < 1){
            $params = Request_RequestParams::setParams(
                array(
                    'shop_client_id' => $shopClientIDFrom,
                    'shop_client_attorney_id' => $shopClientAttorneyIDFrom,
                    'shop_client_contract_id' => $shopClientContractIDFrom,
                    'sort_by' => array('amount' => 'desc'),
                    'is_invoice' => FALSE,
                    'is_delivery' => $isDelivery,
                )
            );
            $shopCarIDs = self::getExitShopCar($dateFrom, $dateTo, $sitePageData, $driver, NULL, $params);
            $shopPieceIDs = Api_Ab1_Shop_Piece::getExitShopPieces(
                $dateFrom, $dateTo, $sitePageData, $driver, NULL, $params
            );

            /** переносим заказы, которые можно перенести полностью **/
            foreach ($shopCarIDs->childs as $key => $child){
                if($isAll || ($amount >= $child->values['amount'])){
                    self::editAttorney(
                        $child->id, $shopClientIDTo, $shopClientAttorneyIDTo, $shopClientContractIDTo,
                        $sitePageData, $driver, FALSE
                    );
                    $amount = $amount - $child->values['amount'];
                }

                if((!$isAll) && ($amount < 0.001)){
                    break;
                }
            }

            /** переносим заказы Штучного товара, которые можно перенести полностью **/
            if($isAll || $amount > 0.001) {
                foreach ($shopPieceIDs->childs as $key => $child) {
                    if ($isAll || ($amount >= $child->values['amount'])) {
                        Api_Ab1_Shop_Piece::editAttorney(
                            $child->id, $shopClientIDTo, $shopClientAttorneyIDTo, $shopClientContractIDTo, $sitePageData,
                            $driver, FALSE
                        );
                        $amount = $amount - $child->values['amount'];
                    }

                    if ((!$isAll) && ($amount < 0.001)) {
                        break;
                    }
                }
            }

            // обновляем балансы клиента
            Api_Ab1_Shop_Client::recountBalanceObject(
                null, $sitePageData, $driver, $shopClientIDFrom
            );
            if($shopClientIDFrom !== $shopClientIDTo){
                // обновляем балансы клиента
                Api_Ab1_Shop_Client::recountBalanceObject(
                    null, $sitePageData, $driver, $shopClientIDTo
                );
                return FALSE;
            }
        }

        if($isAll || $amount > 0.001) {
            $params = Request_RequestParams::setParams(
                array(
                    'exit_at_from' => $dateFrom,
                    'exit_at_to' => $dateTo,
                    'shop_client_id' => $shopClientIDFrom,
                    'shop_car_id.shop_client_id' => $shopClientIDFrom,
                    'shop_client_attorney_id' => $shopClientAttorneyIDFrom,
                    'shop_client_contract_id' => $shopClientContractIDFrom,
                    'shop_product_id' => $shopProductID,
                    'shop_product_id.product_type_id' => $productTypeID,
                    'sort_by' => array('amount' => 'desc'),
                    'is_exit' => TRUE,
                    'is_charity' => FALSE,
                    'is_delivery' => $isDelivery,
                    'shop_invoice_id' => 0,
                )
            );
            $shopCarItemIDs = Request_Request::find('DB_Ab1_Shop_Car_Item',
                $sitePageData->shopID, $sitePageData, $driver, $params, 0, TRUE
            );
            $shopPieceItemIDs = Request_Request::find('DB_Ab1_Shop_Piece_Item',
                $sitePageData->shopID, $sitePageData, $driver, $params, 0, TRUE
            );

            /** переносим заказы, пытаемся разделить построчно **/
            if($isAll || $amount > 0.001) {
                foreach ($shopCarItemIDs->childs as $key => $child) {
                    if ($isAll || ($amount >= $child->values['amount'])) {
                        Api_Ab1_Shop_Car_Item::editAttorney(
                            $child->id, $shopClientAttorneyIDTo, $shopClientContractIDTo, $sitePageData, $driver, FALSE
                        );
                        $amount = $amount - $child->values['amount'];

                        unset($shopCarItemIDs->childs[$key]);
                    }

                    if ((!$isAll) && ($amount < 0.001)) {
                        break;
                    }
                }
            }

            /** переносим заказы Штучного товара, пытаемся разделить построчно **/
            if($isAll || $amount > 0.001) {
                foreach ($shopPieceItemIDs->childs as $key => $child) {
                    if ($isAll || ($amount >= $child->values['amount'])) {
                        Api_Ab1_Shop_Piece_Item::editAttorney(
                            $child->id, $shopClientAttorneyIDTo, $shopClientContractIDTo, $sitePageData, $driver, FALSE
                        );
                        $amount = $amount - $child->values['amount'];

                        unset($shopPieceItemIDs->childs[$key]);
                    }

                    if ((!$isAll) && ($amount < 0.001)) {
                        break;
                    }
                }
            }

            /** переносим заказы Штучного товара, пытаемся разделить на две строчки **/
            if($isAll || $amount > 0.001) {
                foreach ($shopPieceItemIDs->childs as $key => $child) {
                    if ($amount < $child->values['amount']) {
                        Api_Ab1_Shop_Piece_Item::breakItemToTwoAmount(
                            $child->id, $shopClientAttorneyIDTo, $shopClientContractIDTo, $amount, $sitePageData, $driver, FALSE
                        );
                        $amount = 0;
                        break;
                    }
                }
            }

            /** переносим заказы, пытаемся разделить на две строчки **/
            if($isAll || $amount > 0.001) {
                foreach ($shopCarItemIDs->childs as $key => $child) {
                    if ($amount < $child->values['amount']) {
                        Api_Ab1_Shop_Car_Item::breakItemToTwoAmount(
                            $child->id, $shopClientAttorneyIDTo, $shopClientContractIDTo, $amount, $sitePageData, $driver, FALSE
                        );
                        $amount = 0;
                        break;
                    }
                }
            }
        }

        // обновляем балансы клиента
        Api_Ab1_Shop_Client::recountBalanceObject(
            null, $sitePageData, $driver, $shopClientIDFrom
        );
        if($shopClientIDFrom !== $shopClientIDTo){
            // обновляем балансы клиента
            Api_Ab1_Shop_Client::recountBalanceObject(
                null, $sitePageData, $driver, $shopClientIDTo
            );
        }

        return $amount < 0.001;
    }


    /**
     * Изменяем доверенноть + договор клиента на другие доверенноть + договор на сумму и за период
     * @param $dateFrom
     * @param $dateTo
     * @param $shopClientID
     * @param $shopClientAttorneyIDFrom
     * @param $shopClientAttorneyIDTo
     * @param $shopClientContractIDFrom
     * @param $shopClientContractIDTo
     * @param $amount
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @return bool
     */
    public static function breakDeliveryAttorney($dateFrom, $dateTo, $shopClientID,
                                                 $shopClientAttorneyIDFrom, $shopClientAttorneyIDTo,
                                                 $shopClientContractIDFrom, $shopClientContractIDTo,
                                                 $amount,
                                                 SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        if($shopClientID < 1){
            return FALSE;
        }

        $params = Request_RequestParams::setParams(
            array(
                'shop_client_id' => $shopClientID,
                'delivery_shop_client_attorney_id' => $shopClientAttorneyIDFrom,
                'delivery_shop_client_contract_id' => $shopClientContractIDFrom,
                'sort_by' => array('amount' => 'desc'),
                'shop_act_service_id' => 0,
            )
        );
        $shopCarIDs = self::getExitShopCar($dateFrom, $dateTo, $sitePageData, $driver, NULL, $params);
        $shopPieceIDs = Api_Ab1_Shop_Piece::getExitShopPieces(
            $dateFrom, $dateTo, $sitePageData, $driver, NULL, $params
        );
        $isAll = $amount  < 0.001;

        /** переносим заказы **/
        $model = new Model_Ab1_Shop_Car();
        $model->setDBDriver($driver);
        foreach ($shopCarIDs->childs as $key => $child){
            if($isAll || ($amount >= $child->values['delivery_amount'])){
                $child->setModel($model);

                $model->setDeliveryShopClientAttorneyID($shopClientAttorneyIDTo);
                $model->setDeliveryShopClientContractID($shopClientContractIDTo);

                Helpers_DB::saveDBObject($model, $sitePageData);
                $amount = $amount - $child->values['delivery_amount'];
            }

            if((!$isAll) && ($amount < 0.001)){
                break;
            }
        }

        /** переносим заказы Штучного товара **/
        if($isAll || $amount > 0.001) {
            $model = new Model_Ab1_Shop_Piece();
            $model->setDBDriver($driver);
            foreach ($shopPieceIDs->childs as $key => $child) {
                if ($isAll || ($amount >= $child->values['delivery_amount'])) {
                    $child->setModel($model);

                    $model->setDeliveryShopClientAttorneyID($shopClientAttorneyIDTo);
                    $model->setDeliveryShopClientContractID($shopClientContractIDTo);

                    Helpers_DB::saveDBObject($model, $sitePageData);

                    $amount = $amount - $child->values['delivery_amount'];
                }

                if ((!$isAll) && ($amount < 0.001)) {
                    break;
                }
            }
        }

        /** переносим Дополнительные услуги **/
        if($isAll || $amount > 0.001) {

            // дополнительные услуги
            $params = Request_RequestParams::setParams(
                array(
                    'shop_client_id' => $shopClientID,
                    'shop_client_attorney_id' => $shopClientAttorneyIDFrom,
                    'shop_client_contract_id' => $shopClientContractIDFrom,
                    'sort_by' => array('amount' => 'desc'),
                    'shop_act_service_id' => 0,
                )
            );
            $shopAdditionServiceItemIDs = Request_Request::find('DB_Ab1_Shop_Addition_Service_Item',
                $sitePageData->shopID, $sitePageData, $driver, $params, 0, TRUE
            );

            $model = new Model_Ab1_Shop_Addition_Service_Item();
            $model->setDBDriver($driver);
            foreach ($shopAdditionServiceItemIDs->childs as $key => $child) {
                if ($isAll || ($amount >= $child->values['amount'])) {
                    $child->setModel($model);

                    $model->setShopClientAttorneyID($shopClientAttorneyIDTo);
                    $model->setShopClientContractID($shopClientContractIDTo);

                    Helpers_DB::saveDBObject($model, $sitePageData);

                    $amount = $amount - $child->values['amount'];
                }

                if ((!$isAll) && ($amount < 0.001)) {
                    break;
                }
            }
        }

        // обновляем балансы клиента
        Api_Ab1_Shop_Client::recountBalanceObject(
            null, $sitePageData, $driver, $shopClientID
        );

        return $amount < 0.001;
    }

    /**
     * Изменение у записи доверенность и клиента
     * @param $shopCarID
     * @param $shopClientIDTo
     * @param $shopClientAttorneyIDTo
     * @param $shopClientContractIDTo
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @param bool $isCalcBalance
     * @throws HTTP_Exception_500
     */
    public static function editAttorney($shopCarID, $shopClientIDTo, $shopClientAttorneyIDTo, $shopClientContractIDTo,
                                        SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver, $isCalcBalance = TRUE)
    {
        $model = new Model_Ab1_Shop_Car();
        $model->setDBDriver($driver);

        if (!Helpers_DB::getDBObject($model, $shopCarID, $sitePageData)) {
            throw new HTTP_Exception_500('Car not found.');
        }

        $model->setShopClientID($shopClientIDTo);
        $model->setShopClientAttorneyID($shopClientAttorneyIDTo);
        $model->setShopClientContractID($shopClientContractIDTo);

        $model->setIsOneAttorney(TRUE);
        Helpers_DB::saveDBObject($model, $sitePageData);

        // изменяем детвору
        $params = Request_RequestParams::setParams(
            array(
                'shop_car_id' => $shopCarID,
            )
        );
        $ids = Request_Request::find('DB_Ab1_Shop_Car_Item', $sitePageData->shopID, $sitePageData, $driver, $params);
        $driver->updateObjects(
            Model_Ab1_Shop_Car_Item::TABLE_NAME, $ids->getChildArrayID(),
            array(
                'shop_client_id' => $model->getShopClientID(),
                'shop_client_attorney_id' => $model->getShopClientAttorneyID(),
                'shop_client_contract_id' => $model->getShopClientContractID(),
            )
        );

        if($isCalcBalance) {
            // обновляем балансы клиента
            Api_Ab1_Shop_Client::recountBalanceObject(
                $model, $sitePageData, $driver
            );
        }
    }

    /**
     * Получаем список выехавших машин за заданный период
     * @param $dateFrom
     * @param $dateTo
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @param null $elements
     * @param array $params
     * @param bool $isAllBranch
     * @param bool $isCharity
     * @return MyArray
     */
    public static function getExitShopCar($dateFrom, $dateTo, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver,
                                          $elements = NULL, $params = array(), $isAllBranch = false, $isCharity = false)
    {
        $params = array_merge(
            Request_RequestParams::setParams(
                array(
                    'exit_at_from' => $dateFrom,
                    'exit_at_to' => $dateTo,
                    'is_exit' => 1,
                    'quantity_from' => 0,
                    'is_charity' => $isCharity,
                )
            ),
            $params
        );
        if($isAllBranch){
            $shopCarIDs = Request_Request::findBranch('DB_Ab1_Shop_Car',
                array(), $sitePageData, $driver, $params, 0, TRUE, $elements
            );
        }else {
            $shopCarIDs = Request_Request::find('DB_Ab1_Shop_Car',
                $sitePageData->shopID, $sitePageData, $driver, $params, 0, TRUE, $elements
            );
        }

        return $shopCarIDs;
    }

    /**
     * удаление реализации
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @return bool
     * @throws HTTP_Exception_500
     */
    public static function delete(SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        $id = Request_RequestParams::getParamInt('id');
        if($id < 0){
            return FALSE;
        }
        $isUnDel = Request_RequestParams::getParamBoolean("is_undel");

        $model = new Model_Ab1_Shop_Car();
        $model->setDBDriver($driver);

        if (!Helpers_DB::dublicateObjectLanguage($model, $id, $sitePageData)) {
            throw new HTTP_Exception_500('Car not found.');
        }

        if (($isUnDel && !$model->getIsDelete()) or (!$isUnDel && $model->getIsDelete())){
            return FALSE;
        }

        if($isUnDel){
            $params = Request_RequestParams::setParams(
                array(
                    'shop_car_id' => $id,
                    'is_delete' => 1,
                    'is_public' => FALSE,
                )
            );
            $ids = Request_Request::find('DB_Ab1_Shop_Car_Item', $sitePageData->shopID, $sitePageData, $driver, $params);
            $driver->unDeleteObjectIDs(
                $ids->getChildArrayID(), $sitePageData->userID, Model_Ab1_Shop_Car_Item::TABLE_NAME,
                array('is_public' => 1), $sitePageData->shopID
            );

            $model->dbUnDelete($sitePageData->userID, 0, $sitePageData->shopID);

            Api_Ab1_Shop_Register_Raw::unDelShopCar($model, $sitePageData, $driver);
            Api_Ab1_Shop_Register_Material::unDelShopCar($model, $sitePageData, $driver);

            self::setCurrentPrice($model->id, $sitePageData, $driver);
        }else {
            $params = Request_RequestParams::setParams(
                array(
                    'shop_car_id' => $id,
                    'is_delete' => 0,
                    'is_public_ignore' => TRUE,
                )
            );
            $ids = Request_Request::find('DB_Ab1_Shop_Car_Item', $sitePageData->shopID, $sitePageData, $driver, $params);
            $driver->deleteObjectIDs(
                $ids->getChildArrayID(), $sitePageData->userID, Model_Ab1_Shop_Car_Item::TABLE_NAME,
                array('is_public' => 0), $sitePageData->shopID
            );

            $model->dbDelete($sitePageData->userID, 0, $sitePageData->shopID);

            Api_Ab1_Shop_Register_Raw::delShopCar($model, $sitePageData, $driver);
            Api_Ab1_Shop_Register_Material::delShopCar($model, $sitePageData, $driver);

            Api_Ab1_Shop_Client_Balance_Day::deleteBlockCarClientBalanceDay($model->id, $sitePageData, $driver, null);
        }

        // пересчитать баланс остатка продукции
        Api_Ab1_Shop_Product_Storage::calcProductBalance(
            $model->getShopProductID(), $model->getShopStorageID(), $sitePageData, $driver, true
        );

        // обновляем балансы клиента
        Api_Ab1_Shop_Client::recountBalanceObject(
            $model, $sitePageData, $driver
        );

        return TRUE;
    }

    /**
     * Просчет суммы накладный у реализации
     * @param $shopCarID
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @return bool
     * @throws HTTP_Exception_500
     */
    public static function calcInvoiceAmount($shopCarID, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        if($shopCarID < 1){
            return FALSE;
        }

        // реализация
        $params = Request_RequestParams::setParams(
            array(
                'shop_car_id' => $shopCarID,
            )
        );
        $ids = Request_Request::find('DB_Ab1_Shop_Car_Item',
            $sitePageData->shopID, $sitePageData, $driver, $params
        );

        $shopInvoiceIDs = $ids->getChildArrayInt('shop_invoice_id', TRUE);
        foreach ($shopInvoiceIDs as $shopInvoiceID){
            Api_Ab1_Shop_Invoice::calcInvoiceAmount($shopInvoiceID, $sitePageData, $driver, TRUE);
        }

        return TRUE;
    }

    /**
     * Сохранение
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @return array
     * @throws HTTP_Exception_500
     */
    public static function save(SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        $model = new Model_Ab1_Shop_Car();
        $model->setDBDriver($driver);

        $id = Request_RequestParams::getParamInt('id');
        if($id > 0) {
            if (!Helpers_DB::dublicateObjectLanguage($model, $id, $sitePageData)) {
                throw new HTTP_Exception_500('Car not found.');
            }
        }

        Request_RequestParams::setParamBoolean('is_public', $model);
        Request_RequestParams::setParamStr('text', $model);
        Request_RequestParams::setParamStr('name', $model);
        Request_RequestParams::setParamStr("old_id", $model);
        Request_RequestParams::setParamInt("shop_payment_id", $model);
        Request_RequestParams::setParamInt("shop_transport_company_id", $model);
        Request_RequestParams::setParamStr("ticket", $model);
        Request_RequestParams::setParamBoolean('is_charity', $model);
        Request_RequestParams::setParamInt('shop_product_id', $model);
        Request_RequestParams::setParamInt('shop_driver_id', $model);
        Request_RequestParams::setParamDateTime('exit_at', $model);
        Request_RequestParams::setParamDateTime('arrival_at', $model);
        Request_RequestParams::setParamBoolean('is_debt', $model);
        Request_RequestParams::setParamBoolean('is_delivery', $model);
        Request_RequestParams::setParamBoolean('is_balance', $model);
        Request_RequestParams::setParamBoolean('is_invoice_print', $model);
        Request_RequestParams::setParamInt("shop_storage_id", $model);
        Request_RequestParams::setParamInt("shop_turn_place_id", $model);

        $options = Request_RequestParams::getParamArray('options');
        if ($options !== NULL) {
            $model->addOptionsArray($options);
        }

        $shopClientID = $model->getShopClientID();
        if(!$model->getIsInvoice()) {
            Request_RequestParams::setParamInt('shop_client_id', $model);
            Request_RequestParams::setParamInt('shop_client_attorney_id', $model);
            Request_RequestParams::setParamInt('shop_client_contract_id', $model);
        }

        // добавляем id водителя
        $driverName = Request_RequestParams::getParamStr('shop_driver_name');
        if($driverName !== NULL) {
            $model->setShopDriverID(
                Api_Ab1_Shop_Driver::getShopDriverIDByName(
                    $driverName, $model->getShopClientID(), $sitePageData, $driver
                )
            );
        }

        // Ставим очередь для машины через весовую
        Api_Ab1_Shop_Turn_Place::setTurn($model, $sitePageData, $driver);

        // если не был задан договор и задана доверенность добавляем договор из доверенности
        if($model->getShopClientAttorneyID() > 0){
            $modelAttorney = new Model_Ab1_Shop_Client_Attorney();
            $modelAttorney->setDBDriver($driver);
            if (Helpers_DB::getDBObject($modelAttorney, $model->getShopClientAttorneyID(), $sitePageData)) {
                // проверяем, чтобы доверенность принадлежала клиенту
                if($model->getShopClientID() != $modelAttorney->getShopClientID()){
                    $model->setShopClientContractID(0);
                    $model->setShopClientAttorneyID(0);
                }elseif($model->getShopClientID() != $model->getOriginalValue('shop_client_id') || $model->getOriginalValue('shop_client_id') < 1){
                    $model->setShopClientContractID($modelAttorney->getShopClientContractID());
                }
            }else{
                $model->setShopClientAttorneyID(0);
            }
        }

        $model->setShopTransportID(
            Request_Request::findIDByField(
                'DB_Ab1_Shop_Transport', 'number_full', $model->getName(), 0, $sitePageData, $driver
            )
        );

        // определяем транспортную компанию
        if($model->isEditValue('name') || $model->getShopTransportCompanyID() < 1){
            $carTare = Request_Request::findOneByField(
                'DB_Ab1_Shop_Car_Tare', 'name_full', $model->getName(), 0, $sitePageData, $driver
            );
            if($carTare != null && $carTare->values['shop_transport_company_id'] > 0) {
                $model->setShopTransportCompanyID($carTare->values['shop_transport_company_id']);
            }elseif($model->isEditValue('name')){
                $model->setShopTransportCompanyID(0);
            }
        }

        // определяем привязку к путевому листу
        if(!$model->getIsDelivery()
            && ($model->getExitAt() != $model->getOriginalValue('exit_at')
                || $model->getShopTransportID() != $model->getOriginalValue('shop_transport_id'))){
            $model->setShopTransportWaybillID(
                Api_Ab1_Shop_Transport_Waybill::findWaybillID(
                    $model->getShopTransportID(), $model->getExitAt(), $sitePageData, $driver
                )
            );
        }else{
            $model->setShopTransportWaybillID(0);
        }

        $result = array();
        if ($model->validationFields($result)) {
            // счетчик как в 1с
            DB_Basic::setNumber1CIfEmpty($model, 'number', $sitePageData, $driver, $sitePageData->shopID);

            if($model->id < 1) {
                $tare = Request_RequestParams::getParamFloat('tare');
                if($tare > 0.0001){
                    $model->setTarra($tare);
                    $model->setShopTurnID(Model_Ab1_Shop_Turn::TURN_WEIGHTED_EXIT);
                }

                $model->setCashOperationID($sitePageData->operationID);
                Helpers_DB::saveDBObject($model, $sitePageData);
            }

            // загружаем фотографии
            $file = new Model_File($sitePageData);
            $file->saveFiles(Request_RequestParams::getParamArray('files'), $model, $sitePageData, $driver);

            $options = $model->getOptionsArray();
            $files = Helpers_Image::getChildrenFILES('options');
            foreach ($files as $key => $child) {
                if(is_array($child['tmp_name'])){
                    foreach ($child['tmp_name'] as $index => $path){
                        $data = array(
                            'tmp_name' => $path,
                            'name' => $child['name'][$index],
                            'type' => $child['type'][$index],
                            'error' => $child['error'][$index],
                            'size' => $child['size'][$index],
                        );
                        $options[$key][] = array(
                            'file' => $file->saveDownloadFilePath($data, $model->id, Model_Ab1_Shop_Client_Contract::TABLE_ID, $sitePageData),
                            'name' => $data['name'],
                            'size' => $data['size'],
                        );
                    }
                }else{
                    $options[$key][] = array(
                        'file' => $file->saveDownloadFilePath($child, $model->id, Model_Ab1_Shop_Client_Contract::TABLE_ID, $sitePageData),
                        'name' => $child['name'],
                        'size' => $child['size'],
                    );
                }
            }
            $model->addOptionsArray($options);

            // сохраняем товары реализации
            $shopCarItems = Request_RequestParams::getParamArray('shop_car_items');
            if($shopCarItems !== NULL) {
                $arr = Api_Ab1_Shop_Car_Item::save(
                    $model, $shopCarItems, $sitePageData, $driver
                );
                $model->setQuantity($arr['quantity']);
                $model->setPrice($arr['amount'] / $model->getQuantity());

                $model->setIsOneAttorney(count( $arr['attorneys']) == 1);
                if($model->getIsOneAttorney()){
                    $model->setShopClientAttorneyID(current( $arr['attorneys']));
                    $model->setShopClientContractID(current($arr['contracts']));
                }else{
                    $model->setShopClientAttorneyID(0);
                    $model->setShopClientContractID(0);
                }
            }else{
                Request_RequestParams::setParamFloat('quantity', $model);
                Api_Ab1_Shop_Car_Item::saveOne($model, $sitePageData, $driver);
            }

            if(!$model->getIsInvoice()) {
                // присваем значение доверенности доставки
                $tmp = Request_RequestParams::getParamInt('delivery_shop_client_attorney_id');
                if ($tmp !== null) {
                    $model->setDeliveryShopClientAttorneyID($tmp);
                } elseif ($model->getOriginalValue('shop_client_attorney_id') == $model->getDeliveryShopClientAttorneyID()) {
                    $model->setDeliveryShopClientAttorneyID($model->getShopClientAttorneyID());
                }

                // присваем значение договора доставки
                $tmp = Request_RequestParams::getParamInt('delivery_shop_client_attorney_id');
                if ($tmp !== null) {
                    $model->setDeliveryShopClientContractID($tmp);
                } elseif ($model->getOriginalValue('shop_client_attorney_id') == $model->getDeliveryShopClientContractID()) {
                    $model->setDeliveryShopClientContractID($model->getShopClientContractID());
                }
            }

            // просчитываем стоимость доставки
            $deliveryAmount = Request_RequestParams::getParamFloat('delivery_amount');
            Request_RequestParams::setParamInt('shop_delivery_id', $model);
            Request_RequestParams::setParamFloat('delivery_km', $model);
            $model->setDeliveryAmount(
                Api_Ab1_Shop_Delivery::getPrice(
                    $deliveryAmount, $model->getDeliveryKM(), $model->getDeliveryQuantity(), $model->getShopDeliveryID(),
                    $model->getIsCharity(), $sitePageData, $driver
                )
            );

            // сохраняем дополнительные услуги
            $shopAdditionServiceItems = Request_RequestParams::getParamArray('shop_addition_service_items');
            if($shopAdditionServiceItems !== null){
                $arr = Api_Ab1_Shop_Addition_Service_Item::saveCar(
                    $model, $shopAdditionServiceItems, $sitePageData, $driver
                );

                $model->setAmountService($arr['amount']);
                $model->setQuantityService($arr['quantity']);
            }

            // Задаем суммы реализации
            Api_Ab1_Shop_Car::setAmount($model->getAmount(), $model, $sitePageData, $driver);

            Helpers_DB::saveDBObject($model, $sitePageData);

            // Сохраняем расхода материалов по рецептам
            Api_Ab1_Shop_Register_Material::saveShopCar($model, $sitePageData, $driver);

            // ставим клиента, как покутелем
            if($model->getShopClientID() > 0 && $model->getShopClientID() != $model->getOriginalValue('shop_client_id')){
                $driver->updateObjects(
                    Model_Ab1_Shop_Client::TABLE_NAME, array($model->getShopClientID()),
                    array('is_buyer' => 1)
                );
            }

            if (!$model->getIsDelete()) {
                // обновляем заблокированные суммы клиента
                Api_Ab1_Shop_Client::calcBalancesBlock(
                    [
                        $shopClientID => $shopClientID,
                        $model->getShopClientID() => $model->getShopClientID(),
                    ],
                    $sitePageData, $driver
                );

                // обновляем накладные
                self::calcInvoiceAmount($model->id, $sitePageData, $driver);

                // обновляем актов выполненных работ
                if($model->getShopActServiceID() > 0) {
                    Api_Ab1_Shop_Act_Service::calcActServiceAmount(
                        $model->getShopActServiceID(), $sitePageData, $driver, true
                    );
                }

                // обновляем заблокированные суммы клиента
                Api_Ab1_Shop_Client::recountBalanceObject(
                    $model, $sitePageData, $driver
                );
            }

            Helpers_DB::saveDBObject($model, $sitePageData);
            $result['values'] = $model->getValues();
        }

        return array(
            'id' => $model->id,
            'is_public' => $model->getIsPublic() || $model->getValue('is_public', null) === null,
            'result' => $result,
        );
    }

    /**
     * Сохраняем машины + оплату в виде XML
     * @param $shopTurnPlaceID
     * @param $fileName
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @return bool
     * @throws HTTP_Exception_500
     */
    public static function loadASUCSS($shopTurnPlaceID, $fileName, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        $array_key_first = function (array $arr) {
            foreach ($arr as $key => $unused) {
                return $key;
            }
            return NULL;
        };
        $getQuantity = function (array $arr) {
            $result = 0;
            for ($i = 1; $i < count($arr) - 1; $i++) {
                $result += $arr[$i] / 1000;
            }
            return $result;
        };

        $data = trim(iconv('windows-1251', 'UTF-8', file_get_contents($fileName)));
        $list = explode("\r\n", $data);

        if (count($list) < 3) {
            return false;
        }

        // получаем заголовоки АСУ
        $arr = explode(';', $list[1]);
        $titles = array();
        foreach ($arr as $child) {
            $titles[] = array(
                'title' => $child,
                'value' => '',
            );
        }

        $arr = explode(';', $list[2]);
        $dateFrom = date('Y-m-d H:i:s', strtotime($arr[count($arr) - 1]));
        if ($dateFrom == '1970-01-01 06:00:00') {
            return false;
        }

        $arr = explode(';', $list[count($list) - 2]);
        $dateTo = date('Y-m-d H:i:s', strtotime($arr[count($arr) - 1]));
        if ($dateTo == '1970-01-01 06:00:00') {
            return false;
        }

        // получаем список машина
        $shopCarIDs = Api_Ab1_Shop_Car::getExitShopCar(
            $dateFrom, $dateTo, $sitePageData, $driver,
            array(
                'shop_product_id' => array('name')
            ),
            array(
                'shop_turn_place_id' => $shopTurnPlaceID,
            )
        );
        foreach ($shopCarIDs->childs as $child) {
            $child->additionDatas['table_id'] = Model_Ab1_Shop_Car::TABLE_ID;
        }

        $shopMoveCarIDs = Api_Ab1_Shop_Move_Car::getExitShopMoveCar(
            $dateFrom, $dateTo, $sitePageData, $driver,
            array(
                'shop_product_id' => array('name')
            ),
            array(
                'shop_turn_place_id' => $shopTurnPlaceID,
            )
        );
        foreach ($shopMoveCarIDs->childs as $child) {
            $child->additionDatas['table_id'] = Model_Ab1_Shop_Move_Car::TABLE_ID;
            $shopCarIDs->childs[] = $child;
        }

        $shopLesseeCarIDs = Api_Ab1_Shop_Lessee_Car::getExitShopCar(
            $dateFrom, $dateTo, $sitePageData, $driver,
            array(
                'shop_product_id' => array('name')
            ),
            array(
                'shop_turn_place_id' => $shopTurnPlaceID,
            )
        );
        foreach ($shopLesseeCarIDs->childs as $child) {
            $child->additionDatas['table_id'] = Model_Ab1_Shop_Lessee_Car::TABLE_ID;
            $shopCarIDs->childs[] = $child;
        }

        usort($shopCarIDs->childs, function (MyArray $x, MyArray $y) {
            if (empty($x->values['asu_at']) || empty($y->values['asu_at'])) {
                return strcasecmp($x->values['weighted_exit_at'], $y->values['weighted_exit_at']);
            }

            return strcasecmp($x->values['asu_at'], $y->values['asu_at']);
        });

        $params = Request_RequestParams::setParams(
            array(
                'weighted_at_from' => $dateFrom,
                'weighted_at_to' => $dateTo,
                'shop_turn_place_id' => $shopTurnPlaceID,
                'sort_by' => array(
                    'weighted_at' => 'asc',
                )
            )
        );
        $shopProductStorageIDs = Request_Request::find(
            'DB_Ab1_Shop_Product_Storage', $sitePageData->shopID, $sitePageData, $driver, $params,
            0, TRUE,
            array(
                'shop_product_id' => array('name')
            )
        );
        foreach ($shopProductStorageIDs->childs as $child) {
            $child->additionDatas['table_id'] = Model_Ab1_Shop_Product_Storage::TABLE_ID;
            $child->additionDatas['quantity'] = 0;
        }

        $newCarIDs = new MyArray();
        $i = 2;
        while ($i < count($list) - 1) {
            $arr = explode(';', $list[$i]);

            $date = strtotime($arr[count($arr) - 1]);
            if (empty($date)) {
                throw new HTTP_Exception_500('Ошибка в дате в строке "' . $list[$i] . '".');
            }

            $child = $titles;
            for ($j = 0; $j < count($arr); $j++) {
                $child[$j]['value'] = $arr[$j];
            }

            $object = null;
            $key = $array_key_first($shopCarIDs->childs);
            if ($key !== null) {
                $tmp = $shopCarIDs->childs[$key];
                if (strtotime($tmp->values['weighted_entry_at']) < $date) {
                    $object = $tmp;
                } else {
                    $key = $array_key_first($shopProductStorageIDs->childs);
                    if ($key !== null) {
                        $object = $shopProductStorageIDs->childs[$key];
                    }
                }
            } else {
                $key = $array_key_first($shopProductStorageIDs->childs);
                if ($key !== null) {
                    $object = $shopProductStorageIDs->childs[$key];
                }
            }

            if ($object == null) {
                throw new HTTP_Exception_500('Ошибка в строке "' . $list[$i] . '". Не найдена машина в базе данных.');
            }

            switch ($object->additionDatas['table_id']) {
                case Model_Ab1_Shop_Car::TABLE_ID:
                    $model = $object->createModel('DB_Ab1_Shop_Car', $driver);
                    break;
                case Model_Ab1_Shop_Move_Car::TABLE_ID:
                    $model = $object->createModel('DB_Ab1_Shop_Move_Car', $driver);
                    break;
                case Model_Ab1_Shop_Lessee_Car::TABLE_ID:
                    $model = $object->createModel('DB_Ab1_Shop_Lessee_Car', $driver);
                    break;
                case Model_Ab1_Shop_Product_Storage::TABLE_ID:
                    $model = $object->createModel('DB_Ab1_Shop_Product_Storage', $driver);
                    break;
                default:
                    throw new HTTP_Exception_500('Ошибка системы.');
            }

            /** @var Model_Ab1_Shop_Move_Car $model */
            $quantity = Arr::path($object->additionDatas, 'asu_quantity', 0);
            $listASU = Arr::path($object->additionDatas, 'asu', array());
            $listFormula = Arr::path($object->additionDatas, 'asu_formulas', array());
            do {
                $listFormula[$arr[0]] = $arr[0];

                $listASU[] = $child;
                $quantity += $getQuantity($arr);

                if(key_exists('asu_at', $object->values)){
                    $s11 = $object->values['asu_at'];
                }else{
                    $s11 = $object->values['weighted_at'];
                }
                echo $object->additionDatas['table_id'] . ' | ' . $s11 . ' | ' . $model->id . ' | ' . $model->getName() . ' | ' . ($i + 1) . ' | ' . $model->getQuantity() . ' | ' . $quantity . ' | ' . $object->getElementValue('shop_product_id') . ' | ' . $arr[0];
                //print_r(implode(', ', $listFormula));
                echo "\r\n";//die;

                if ($model->getQuantity() <= $quantity) {
                    $object->additionDatas['asu_quantity'] = $quantity;
                    $object->additionDatas['asu'] = $listASU;
                    $object->additionDatas['asu_formulas'] = $listFormula;
                    $object->additionDatas['asu_number'] = $i + 1;

                    echo  ' | ' . ' | ' . ' | ' .  ' | '  . ' | '  . ' | ' . $quantity . ' | ' .  ' | '; echo "\r\n";

                 /*   echo $child->values['table_id'] . ' | ' . $child->values['asu_at'] . ' | ' . $model->id . ' | ' . $model->getName() . ' | ' . ($i + 1) . ' | ' . $model->getQuantity() . ' | ' . $quantity . ' | ' . $object->getElementValue('shop_product_id') . ' | ';
                    print_r(implode(', ', $listFormula));
                    echo "\r\n";//die;*/

                    switch ($object->additionDatas['table_id']) {
                        case Model_Ab1_Shop_Car::TABLE_ID:
                        case Model_Ab1_Shop_Move_Car::TABLE_ID:
                        case Model_Ab1_Shop_Lessee_Car::TABLE_ID:
                            $newCarIDs->childs[$key] = $shopCarIDs->childs[$key];
                            unset($shopCarIDs->childs[$key]);
                            break;
                        case Model_Ab1_Shop_Product_Storage::TABLE_ID:
                            $key = $array_key_first($shopProductStorageIDs->childs);
                            unset($shopProductStorageIDs->childs[$key]);
                            break;
                        default:
                            throw new HTTP_Exception_500('Ошибка системы.1');
                    }

                    //Helpers_DB::saveDBObject($model, $sitePageData);
                    break;
                }

                if ($object->additionDatas['table_id'] == Model_Ab1_Shop_Product_Storage::TABLE_ID) {
                    $object->additionDatas['asu_quantity'] = $quantity;
                    $object->additionDatas['asu'] = $listASU;
                    $object->additionDatas['asu_formulas'] = $listFormula;
                    break;
                } else {
                    $i++;
                    if ($i < count($list) - 1) {
                        $arr = explode(';', $list[$i]);

                        $child = $titles;
                        for ($j = 0; $j < count($arr); $j++) {
                            $child[$j]['value'] = $arr[$j];
                        }

                    }
                }
            } while ($i < count($list) - 1);

            $i++;
        }
/*
        foreach ($newCarIDs->childs as $child){
*

           if($child->values['asu_at']){

           }
            echo $child->values['table_id'] . ' | ' . $child->values['asu_at'] . ' | ' . $child->values['id'] . ' | ' . $child->values['name'] . ' | ' . ($child->additionDatas['asu_number']) . ' | ' . $child->values['quantity'] . ' | ' . $child->additionDatas['asu_quantity'] . ' | ' . $child->getElementValue('shop_product_id') . ' | ';
            print_r(implode(', ', $child->additionDatas['asu_formulas']));
            echo "\r\n";//die;
        }
*/
        echo 'Жопа';
        die;

        return true;
    }
}
