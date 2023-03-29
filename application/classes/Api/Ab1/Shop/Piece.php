<?php defined('SYSPATH') or die('No direct script access.');

class Api_Ab1_Shop_Piece  {
    /**
     * Удаляем блокировку фиксированных цен
     * @param $shopPieceID
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @param int $shopProductID
     */
    public static function deleteClientBalanceDays($shopPieceID, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver,
                                                   $shopProductID = 0)
    {
        self::setCurrentPrice($shopPieceID, $sitePageData, $driver, $shopProductID, false);

        Api_Ab1_Shop_Client_Balance_Day::deleteBlockPieceClientBalanceDay($shopPieceID, $sitePageData, $driver, null);
    }

    /**
     * Устанавливаем цены на момент реализации не учитывая фиксированные балансы
     * @param $shopPieceID
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @param $shopProductID
     * @param bool $isUpdateBalanceDay
     * @throws HTTP_Exception_404
     */
    public static function setCurrentPrice($shopPieceID, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver,
                                           $shopProductID = 0, $isUpdateBalanceDay = true)
    {
        $model = new Model_Ab1_Shop_Piece();
        $model->setDBDriver($driver);
        if(!Helpers_DB::getDBObject($model, $shopPieceID, $sitePageData)){
            throw new HTTP_Exception_404('Piece not is found!');
        }

        // получаем товары реализации
        $ids = Request_Request::find(
            DB_Ab1_Shop_Piece_Item::NAME,
            $sitePageData->shopID, $sitePageData, $driver,
            Request_RequestParams::setParams(
                array(
                    'shop_piece_id' => $shopPieceID
                )
            ),
            0, true
        );

        $modelItem = new Model_Ab1_Shop_Piece_Item();
        $modelItem->setDBDriver($driver);

        $total = 0;
        if($shopProductID > 0){
            foreach ($ids->childs as $child){
                $child->setModel($modelItem);

                if($shopProductID == $modelItem->getShopProductID()){
                    continue;
                }

                $total += $modelItem->getAmount();
            }
        }

        foreach ($ids->childs as $child){
            $child->setModel($modelItem);

            if($shopProductID > 0 && $shopProductID != $modelItem->getShopProductID()){
                continue;
            }

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
        }

        if($isUpdateBalanceDay){
            Api_Ab1_Shop_Piece::setAmount($total, $model, $sitePageData, $driver);
        }else{
            $model->setAmount($total);
        }

        Helpers_DB::saveDBObject($model, $sitePageData);
    }

    /**
     * Разбиваем реализацию по фиксированных балансам и устанавливаем цены
     * @param $shopPieceID
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @param int $shopProductID
     * @throws HTTP_Exception_404
     */
    public static function breakBalanceDay($shopPieceID, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver,
                                           $shopProductID = 0)
    {
        $model = new Model_Ab1_Shop_Piece();
        $model->setDBDriver($driver);
        if(!Helpers_DB::getDBObject($model, $shopPieceID, $sitePageData)){
            throw new HTTP_Exception_404('Piece not is found!');
        }

        // освобождаем заблокированные суммы фиксированных балансов
        Api_Ab1_Shop_Client_Balance_Day::deleteBlockPieceClientBalanceDay(
            $shopPieceID, $sitePageData, $driver
        );

        // получаем свободные фиксированные суммы
        $balanceDayIDs = Api_Ab1_Shop_Client_Balance_Day::findClientBalanceDaysByClient(
            $model->getShopClientID(), $sitePageData, $driver, $model->getCreatedAt()
        );
        $balanceDayIDs->runIndex();

        // получаем товары реализации
        $ids = Request_Request::find(
            DB_Ab1_Shop_Piece_Item::NAME,
            $sitePageData->shopID, $sitePageData, $driver,
            Request_RequestParams::setParams(
                array(
                    'shop_piece_id' => $shopPieceID
                )
            ),
            0, true
        );

        $modelItem = new Model_Ab1_Shop_Piece_Item();
        $modelItem->setDBDriver($driver);

        $total = 0;
        if($shopProductID > 0) {
            foreach ($ids->childs as $child) {
                $child->setModel($modelItem);

                $balanceDayID = $modelItem->getShopClientBalanceDayID();
                if ($shopProductID == $modelItem->getShopProductID()
                    || $balanceDayID == 0
                    || !key_exists($balanceDayID, $balanceDayIDs->childs)) {
                    continue;
                }
                $balanceDayIDs->childs[$balanceDayID]->values['balance'] -= $modelItem->getAmount();

                $total += $modelItem->getAmount();
            }
        }

        foreach ($ids->childs as $child){
            $child->setModel($modelItem);

            if($shopProductID > 0 && $shopProductID != $modelItem->getShopProductID()){
                continue;
            }

            $modelItem->setShopClientBalanceDayID(0);

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

                // если всю сумма помещается в фиксированных баланс
                if($price['price'] * $modelItem->getQuantity() <= $balanceDayID->values['balance']){
                    $modelItem->setPrice($price['price']);
                    $modelItem->setShopClientContractItemID($price['shop_client_contract_item_id']);
                    $modelItem->setShopProductPriceID($price['shop_product_price_id']);
                    $modelItem->setShopProductTimePriceID($price['shop_product_time_price_id']);
                    $modelItem->setShopClientBalanceDayID($balanceDayID->id);

                    $balanceDayID->values['balance'] -= $modelItem->getAmount();
                    break;
                }

                // если нужно разбить строку на несколько фиксированных балансов
                $modelNew = new Model_Ab1_Shop_Piece_Item();
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
            }

            // пересчитываем сумма реализации товара, если он стал не фиксированной ценой
            if($modelItem->getShopClientBalanceDayID() == 0){
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
            }

            Helpers_DB::saveDBObject($modelItem, $sitePageData);
            $total += $modelItem->getAmount();
        }

        Api_Ab1_Shop_Piece::setAmount($total, $model, $sitePageData, $driver);

        Helpers_DB::saveDBObject($model, $sitePageData);
    }

    /**
     * Задаем суммы реализации штучных товаров
     * @param $amount
     * @param Model_Ab1_Shop_Piece $model
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     */
    public static function setAmount($amount, Model_Ab1_Shop_Piece $model, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        $model->setAmount($amount);

        // блокируем сумму реализации в фиксированных балансах
        if(!$model->getIsDelete()) {
            Api_Ab1_Shop_Client_Balance_Day::blockPieceClientBalanceDay(
                $model->getShopClientID(), $model->id,
                $model->getDeliveryAmount() + $model->getAmountService(),
                $sitePageData, $driver, $model->getCreatedAt(), true
            );

            Api_Ab1_Shop_Client_Balance_Day::blockPieceClientBalanceDay(
                $model->getShopClientID(), $model->id,
                $model->getAmount(),
                $sitePageData, $driver, $model->getCreatedAt()
            );
        }
    }

    /**
     * Просчет суммы реализации
     * @param $shopPieceID
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @param bool $isSaveAmount
     * @return bool|int
     * @throws HTTP_Exception_500
     */
    public static function calcPieceAmount($shopPieceID, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver,
                                         $isSaveAmount = FALSE)
    {
        if($shopPieceID < 1){
            return FALSE;
        }

        $amount = 0;
        $params = Request_RequestParams::setParams(
            array(
                'shop_piece_id' => $shopPieceID,
                'sum_amount' => TRUE,
            )
        );
        // реализация
        $ids = Request_Request::find('DB_Ab1_Shop_Piece_Item',
            $sitePageData->shopID, $sitePageData, $driver, $params, 0, TRUE
        );
        if(count($ids->childs) > 0){
            $amount += $ids->childs[0]->values['amount'];
        }

        if($isSaveAmount) {
            $model = new Model_Ab1_Shop_Piece();
            $model->setDBDriver($driver);

            if (!Helpers_DB::dublicateObjectLanguage($model, $shopPieceID, $sitePageData)) {
                throw new HTTP_Exception_500('Piece not found. #56');
            }
            Api_Ab1_Shop_Piece::setAmount($amount, $model, $sitePageData, $driver);

            Helpers_DB::saveDBObject($model, $sitePageData);
        }

        return $amount;
    }

    /**
     * Пересчитываем цены продукции одной машины для старых записей
     * @param $shopPieceID
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @param int | null $shopPieceItemID
     * @param boolean $isCalcBalance
     * @throws HTTP_Exception_500
     */
    public static function calcPricePieceOld($shopPieceID, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver,
                                             $shopPieceItemID = null, $isCalcBalance = false)
    {
        $model = new Model_Ab1_Shop_Piece();
        $model->setDBDriver($driver);
        if(! Helpers_DB::getDBObject($model, $shopPieceID, $sitePageData)){
            throw new HTTP_Exception_500('Piece not found.');
        }

        $params = Request_RequestParams::setParams(
            array(
                'shop_car_id' => $shopPieceID,
                'id' => $shopPieceItemID,
            )
        );
        // реализация
        $shopPieceItemIDs = Request_Request::find('DB_Ab1_Shop_Piece_Item',
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

        foreach ($shopPieceItemIDs->childs as $child){
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
        }

        $total =  self::calcPieceAmount($shopPieceID, $sitePageData, $driver);
        Api_Ab1_Shop_Piece::setAmount($total, $model, $sitePageData, $driver);

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
     * @param $shopPieceID
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @param null | int $shopPieceItemID
     * @param boolean $isCalcBalance
     * @param boolean $isNotDiscount
     * @throws HTTP_Exception_500
     */
    public static function calcPricePieceNew($shopPieceID, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver,
                                             $shopPieceItemID = null, $isCalcBalance = false, $isNotDiscount = false)
    {
        $model = new Model_Ab1_Shop_Piece();
        $model->setDBDriver($driver);
        if(! Helpers_DB::getDBObject($model, $shopPieceID, $sitePageData)){
            throw new HTTP_Exception_500('Piece not found.');
        }

        $params = Request_RequestParams::setParams(
            array(
                'shop_piece_id' => $shopPieceID,
                'id' => $shopPieceItemID,
            )
        );
        // реализация
        $shopPieceItemIDs = Request_Request::find('DB_Ab1_Shop_Piece_Item',
            $sitePageData->shopID, $sitePageData, $driver, $params, 0, TRUE
        );

        // зануляем использованный объем по договорам
        $shopClientContractItemIDs = $shopPieceItemIDs->getChildArrayInt('shop_client_contract_item_id', TRUE);
        if (!empty($shopClientContractItemIDs)) {
            $driver->updateObjects(
                Model_Ab1_Shop_Piece_Item::TABLE_NAME, $shopPieceItemIDs->getChildArrayID(),
                array('shop_client_contract_item_id' => 0)
            );

            // пересчитываем заблокированные суммы детворы договора
            Api_Ab1_Shop_Client_Contract_Item::calcBalancesBlock($shopClientContractItemIDs, $sitePageData, $driver);
        }

        // зануляем использованный объем по прайс-листам
        $shopProductPriceIDs = $shopPieceItemIDs->getChildArrayInt('shop_product_price_id', TRUE);
        if (!empty($shopProductPriceIDs)) {
            $driver->updateObjects(
                Model_Ab1_Shop_Piece_Item::TABLE_NAME, $shopPieceItemIDs->getChildArrayID(),
                array('shop_product_price_id' => 0)
            );

            // пересчитываем баланс договора
            Api_Ab1_Shop_Product_Price::calcBalancesBlock($shopProductPriceIDs, $sitePageData, $driver);
        }

        $modelItem = new Model_Ab1_Shop_Piece_Item();
        $modelItem->setDBDriver($driver);

        foreach ($shopPieceItemIDs->childs as $child){
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
        }

        $total =  self::calcPieceAmount($shopPieceID, $sitePageData, $driver);
        Api_Ab1_Shop_Piece::setAmount($total, $model, $sitePageData, $driver);

        Helpers_DB::saveDBObject($model, $sitePageData);


        // обновляем балансы клиента
        if($isCalcBalance) {
            Api_Ab1_Shop_Client::recountBalanceObject(
                $model, $sitePageData, $driver
            );
        }
    }

    /**
     * Пересчитываем цены продукции одной машины
     * @param $date
     * @param $shopCarID
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @param null $shopCarItemID
     * @param bool $isCalcBalance
     * @param bool $isNotDiscount
     */
    public static function calcPricePiece($date, $shopCarID, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver,
                                          $shopCarItemID = null, $isCalcBalance = false, $isNotDiscount = false)
    {
        if(empty($date)){
            $date = date('Y-m-d H:i:s');
        }

        if(Helpers_DateTime::diffDays(date('Y-m-d H:i:s'), $date) <= 10){
            self::calcPricePieceNew(
                $shopCarID, $sitePageData, $driver, $shopCarItemID, $isCalcBalance, $isNotDiscount
            );
        }else{
            self::calcPricePieceOld(
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
     * @return bool|Model_Ab1_Shop_Invoice
     */
    public static function calcPricePieces($shopClientID, $shopClientAttorneyID, $shopClientContractID,
                                           $isDelivery, $dateFrom, $dateTo,
                                           SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        $params = Request_RequestParams::setParams(
            array(
                'exit_at_from' => $dateFrom,
                'exit_at_to' => $dateTo,
                'shop_client_id' => $shopClientID,
                'shop_client_attorney_id' => $shopClientAttorneyID,
                'shop_client_contract_id' => $shopClientContractID,
                'is_exit' => TRUE,
                'is_charity' => FALSE,
                'is_delivery' => $isDelivery,
                'shop_invoice_id' => 0,
            )
        );
        // реализация
        $shopPieceItemIDs = Request_Request::find(
            'DB_Ab1_Shop_Piece_Item', $sitePageData->shopID, $sitePageData, $driver, $params, 0, true,
            ['shop_piece_id' => ['created_at']]
        );

        foreach ($shopPieceItemIDs->childs as $child){
            self::calcPricePiece(
                $child->getElementValue('shop_piece_id', 'created_at'), $child->values['shop_piece_id'],
                $sitePageData, $driver, $child->values['id']
            );
        }
    }

    /**
     * Изменение у записи доверенность и клиента
     * @param $shopPieceID
     * @param $shopClientIDTo
     * @param $shopClientAttorneyIDTo
     * @param $shopClientContractIDTo
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @param bool $isCalcBalance
     * @throws HTTP_Exception_500
     */
    public static function editAttorney($shopPieceID, $shopClientIDTo, $shopClientAttorneyIDTo, $shopClientContractIDTo,
                                        SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver, $isCalcBalance = TRUE)
    {
        $model = new Model_Ab1_Shop_Piece();
        $model->setDBDriver($driver);

        if (!Helpers_DB::dublicateObjectLanguage($model, $shopPieceID, $sitePageData)) {
            throw new HTTP_Exception_500('Piece not found.');
        }

        $model->setShopClientID($shopClientIDTo);
        $model->setShopClientAttorneyID($shopClientAttorneyIDTo);
        $model->setShopClientContractID($shopClientContractIDTo);

        $model->setIsOneAttorney(TRUE);
        Helpers_DB::saveDBObject($model, $sitePageData);

        // изменяем детвору
        $params = Request_RequestParams::setParams(
            array(
                'shop_piece_id' => $model->id,
            )
        );
        $ids = Request_Request::find('DB_Ab1_Shop_Piece_Item', $sitePageData->shopID, $sitePageData, $driver, $params);
        $driver->updateObjects(
            Model_Ab1_Shop_Piece_Item::TABLE_NAME, $ids->getChildArrayID(),
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
     * @param boolean $isAllBranch
     * @return MyArray
     */
    public static function getExitShopPieces($dateFrom, $dateTo, SitePageData $sitePageData,
       Model_Driver_DBBasicDriver $driver, $elements = NULL, $params = array(), $isAllBranch = false, $isCharity = false)
    {
        $params = array_merge(
            Request_RequestParams::setParams(
                array(
                    'created_at_from' => $dateFrom,
                    'created_at_to' => $dateTo,
                    'is_exit' => 1,
                    'is_charity' => $isCharity,
                )
            ),
            $params
        );
        if($isAllBranch){
            $shopPieceIDs = Request_Request::findBranch('DB_Ab1_Shop_Piece',
                array(), $sitePageData, $driver, $params,0, TRUE, $elements
            );
        }else {
            $shopPieceIDs = Request_Request::find('DB_Ab1_Shop_Piece',
                $sitePageData->shopID, $sitePageData, $driver, $params,0, TRUE, $elements
            );
        }

        return $shopPieceIDs;
    }

    /**
     * удаление товара
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

        $model = new Model_Ab1_Shop_Piece();
        $model->setDBDriver($driver);

        if (!Helpers_DB::getDBObject($model, $id, $sitePageData)) {
            throw new HTTP_Exception_500('Piece not found.');
        }

        if (($isUnDel && !$model->getIsDelete()) or (!$isUnDel && $model->getIsDelete())){
            return FALSE;
        }

        // удаляем записи о купленных товаров
        if ($isUnDel){
            $shopPieceItemIDs = Request_Request::find('DB_Ab1_Shop_Piece_Item', $sitePageData->shopID, $sitePageData, $driver,
                array('shop_piece_id' => $id, 'is_delete' => 1, 'is_public' => 0, Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE));

            $driver->unDeleteObjectIDs($shopPieceItemIDs->getChildArrayID(), $sitePageData->userID, Model_Ab1_Shop_Piece_Item::TABLE_NAME,
                array('is_public' => 1), $sitePageData->shopID);

            $model->dbUnDelete($sitePageData->userID, 0, $sitePageData->shopID);

            self::setCurrentPrice($model->id, $sitePageData, $driver);
        }else{
            $shopPieceItemIDs = Request_Request::find('DB_Ab1_Shop_Piece_Item', $sitePageData->shopID, $sitePageData, $driver,
                array('shop_piece_id' => $id, Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE));

            $driver->deleteObjectIDs($shopPieceItemIDs->getChildArrayID(), $sitePageData->userID, Model_Ab1_Shop_Piece_Item::TABLE_NAME,
                array('is_public' => 0), $sitePageData->shopID);

            $model->dbDelete($sitePageData->userID, 0, $sitePageData->shopID);

            Api_Ab1_Shop_Client_Balance_Day::deleteBlockPieceClientBalanceDay($model->id, $sitePageData, $driver, null);
        }

        // обновляем балансы клиента
        Api_Ab1_Shop_Client::recountBalanceObject(
            $model, $sitePageData, $driver
        );

        return TRUE;
    }

    /**
     * Просчет суммы накладный у штучного товара
     * @param $shopPieceID
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @return bool
     * @throws HTTP_Exception_500
     */
    public static function calcInvoiceAmount($shopPieceID, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        if($shopPieceID < 1){
            return FALSE;
        }

        // реализация
        $params = Request_RequestParams::setParams(
            array(
                'shop_piece_id' => $shopPieceID,
            )
        );
        $ids = Request_Request::find('DB_Ab1_Shop_Piece_Item',
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
        $model = new Model_Ab1_Shop_Piece();
        $model->setDBDriver($driver);

        $id = Request_RequestParams::getParamInt('id');
        if($id > 0) {
            if (!Helpers_DB::dublicateObjectLanguage($model, $id, $sitePageData)) {
                throw new HTTP_Exception_500('Piece not found.');
            }
        }

        Request_RequestParams::setParamBoolean('is_public', $model);
        Request_RequestParams::setParamStr('text', $model);
        Request_RequestParams::setParamStr('name', $model);
        Request_RequestParams::setParamBoolean("is_public", $model);
        Request_RequestParams::setParamStr("old_id", $model);
        Request_RequestParams::setParamInt("shop_payment_id", $model);
        Request_RequestParams::setParamInt("shop_transport_company_id", $model);
        Request_RequestParams::setParamStr("ticket", $model);
        Request_RequestParams::setParamBoolean('is_charity', $model);
        Request_RequestParams::setParamInt('shop_driver_id', $model);
        Request_RequestParams::setParamBoolean('is_debt', $model);
        Request_RequestParams::setParamBoolean('is_delivery', $model);
        Request_RequestParams::setParamBoolean('is_invoice_print', $model);
        Request_RequestParams::setParamInt('shop_delivery_id', $model);
        Request_RequestParams::setParamBoolean('is_check_invoice', $model);

        $model->setName(mb_strtoupper($model->getName()));

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
            && ($model->getCreatedAt() != $model->getOriginalValue('created_at')
                || $model->getShopTransportID() != $model->getOriginalValue('shop_transport_id'))){
            $model->setShopTransportWaybillID(
                Api_Ab1_Shop_Transport_Waybill::findWaybillID(
                    $model->getShopTransportID(), $model->getCreatedAt(), $sitePageData, $driver
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
                $model->setCashOperationID($sitePageData->operationID);
                Helpers_DB::saveDBObject($model, $sitePageData);
            }

            // сохраняем дополнительные услуги
            $shopAdditionServiceItems = Request_RequestParams::getParamArray('shop_addition_service_items');
            if($shopAdditionServiceItems !== null){
                $arr = Api_Ab1_Shop_Addition_Service_Item::savePiece(
                    $model, $shopAdditionServiceItems, $sitePageData, $driver
                );

                $model->setAmountService($arr['amount']);
                $model->setQuantityService($arr['quantity']);
            }

            // сохраняем товары реализации
            $shopPieceItems = Request_RequestParams::getParamArray('shop_piece_items');
            if($shopPieceItems !== NULL) {
                $arr = Api_Ab1_Shop_Piece_Item::save($model, $shopPieceItems, $sitePageData, $driver);
                $model->setQuantity($arr['quantity']);
                $model->setText($arr['names']);

                $model->setAmount($arr['amount']);

                if($model->getIsOneAttorney()){
                    $model->setShopClientAttorneyID(current($arr['attorneys']));
                    $model->setShopClientContractID(current($arr['contracts']));
                    $model->setShopSubdivisionID(current($arr['subdivisions']));
                    $model->setShopStorageID(current($arr['storages']));
                    $model->setShopHeapID(current($arr['heaps']));
                }else{
                    $model->setShopClientAttorneyID(0);
                    $model->setShopClientContractID(0);
                    $model->setShopSubdivisionID(0);
                    $model->setShopStorageID(0);
                    $model->setShopHeapID(0);
                }
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

            // для договорных доставок
            $deliveryAmount = Request_RequestParams::getParamFloat('delivery_amount');
            Request_RequestParams::setParamInt('shop_delivery_id', $model);
            Request_RequestParams::setParamFloat('delivery_km', $model);
            $model->setDeliveryAmount(
                Api_Ab1_Shop_Delivery::getPrice(
                    $deliveryAmount, $model->getDeliveryKM(), $model->getDeliveryQuantity(), $model->getShopDeliveryID(),
                    $model->getIsCharity(), $sitePageData, $driver
                )
            );

            // Задаем суммы реализации
            Api_Ab1_Shop_Piece::setAmount($model->getAmount(), $model, $sitePageData, $driver);

            // загружаем фотографии
            $file = new Model_File($sitePageData);
            $file->saveFiles(Request_RequestParams::getParamArray('files'), $model, $sitePageData, $driver);

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

                // обновляем заблокированные суммы стоимость доставки довереннсости
                Api_Ab1_Shop_Client_Attorney::calcDeliveryBalancesBlock(
                    [
                        $model->getOriginalValue('delivery_shop_client_attorney_id') => $model->getOriginalValue('delivery_shop_client_attorney_id'),
                        $model->getDeliveryShopClientAttorneyID() => $model->getDeliveryShopClientAttorneyID(),
                    ],
                    $sitePageData, $driver
                );

                // обновляем заблокированные суммы стоимость доставки договора
                Api_Ab1_Shop_Client_Contract::calcBalancesBlock(
                    [
                        $model->getOriginalValue('delivery_shop_client_contract_id') => $model->getOriginalValue('delivery_shop_client_contract_id'),
                        $model->getDeliveryShopClientContractID() => $model->getDeliveryShopClientContractID(),
                    ],
                    $sitePageData, $driver
                );
            }

            Helpers_DB::saveDBObject($model, $sitePageData);
            $result['values'] = $model->getValues();
        }

        return array(
            'id' => $model->id,
            'result' => $result,
        );
    }

    /**
     * Сохраняем машины + оплату в виде XML
     * @param $from
     * @param $to
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @return string
     */
    public static function saveXML($from, $to, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver, $isPHPOutput = FALSE)
    {
        // получаем список оплат
        $shopPieceIDs = Request_Request::find(
            'DB_Ab1_Shop_Piece', $sitePageData->shopID, $sitePageData, $driver,
            array(Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE, 'created_at_from' => $from, 'created_at_to' => $to),
            0, TRUE
        );


        $modelProduct = new Model_Ab1_Shop_Product();
        $modelProduct->setDBDriver($driver);

        $modelClient = new Model_Ab1_Shop_Client();
        $modelClient->setDBDriver($driver);

        $data = '<?xml version="1.0" encoding="UTF-8"?><Data1C>';
        foreach($shopPieceIDs->childs as $shopPieceID){
            if (!Helpers_DB::getDBObject($modelClient, $shopPieceID->values['shop_client_id'], $sitePageData, $sitePageData->shopMainID)){
                continue;
            }

            $data .= '<Invoice>'
                .'<NumDoc>'.$shopPieceID->values['number'].'</NumDoc>'
                .'<date>'.strftime('%d.%m.%Y %H:%M:%S', strtotime($shopPieceID->values['created_at'])).'</date>'
                .'<IdKlient>'.$modelClient->getOldID().'</IdKlient>'
                .'<Company>'.htmlspecialchars($modelClient->getName(), ENT_XML1).'</Company>'
                .'<BIN>'.htmlspecialchars($modelClient->getBIN(), ENT_XML1).'</BIN>'
                .'<address>'.htmlspecialchars($modelClient->getAddress(), ENT_XML1).'</address>'
                .'<account>'.htmlspecialchars($modelClient->getAccount(), ENT_XML1).'</account>';

            $data .='<TypePay>1</TypePay>';
            $data .='<amount>'.$shopPieceID->values['amount'].'</amount>'
                .'<amount_pko>'. round($shopPieceID->values['amount'], 0) . '</amount_pko>'
                .'<sumNDS>'.round($shopPieceID->values['amount'] / 112 * 12, 2).'</sumNDS>';

            $shopPieceItemIDs = Request_Request::find('DB_Ab1_Shop_Piece_Item', $sitePageData->shopID, $sitePageData, $driver,
                array('shop_piece_id' => $shopPieceID->id, Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE), 0, TRUE);

            $data .= '<Goods>';
            foreach($shopPieceItemIDs->childs as $shopPieceItemID){
                if (!Helpers_DB::getDBObject($modelProduct, $shopPieceItemID->values['shop_product_id'], $sitePageData)){
                    continue;
                }

                $data .= '<GoodString>'
                    .'<Code>'.$modelProduct->getOldID().'</Code>'
                    .'<Type>'.$modelProduct->getType1C().'</Type>'
                    .'<quantity>'.$shopPieceItemID->values['quantity'].'</quantity>'
                    .'<price>'.$shopPieceItemID->values['price'].'</price>'
                    .'<sum>'.$shopPieceItemID->values['amount'].'</sum>'
                    .'<sumBN>'.($shopPieceItemID->values['amount'] - round($shopPieceItemID->values['amount'] / 112 * 12, 2)) .'</sumBN>'
                    .'<sumNDS>'.round($shopPieceItemID->values['amount'] / 112 * 12, 2).'</sumNDS>'
                    .'</GoodString>';
            }
            $data .= '</Goods>';

            $data .= '</Invoice>';
        }
        $data .= '</Data1C>';

        if($isPHPOutput) {
            header('Content-Type: text/xml');
            header('Content-Disposition: attachment;filename="invoice.xml"');
            header('Cache-Control: max-age=0');

            echo $data;
            exit();
        }


        return $data;
    }
}
