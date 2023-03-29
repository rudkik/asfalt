<?php defined('SYSPATH') or die('No direct script access.');

class Api_Ab1_Shop_Invoice  {
    /**
     * Удаляем скидку у заданного продукта накладной с заданной ценой, ставим цену по прайсу
     * @param $shopInvoiceID
     * @param $shopProductID
     * @param $price
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @return array
     * @throws HTTP_Exception_500
     */
    public static function deleteDiscountProduct($shopInvoiceID, $shopProductID, $price,
                                                SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        if($shopInvoiceID < 1 || $shopProductID < 0){
            return false;
        }

        $model = new Model_Ab1_Shop_Invoice();
        $model->setDBDriver($driver);
        if(! Helpers_DB::getDBObject($model, $shopInvoiceID, $sitePageData)){
            throw new HTTP_Exception_500('Invoice id="'.$shopInvoiceID.'" not found.');
        }

        $params = Request_RequestParams::setParams(
            array(
                'shop_invoice_id' => $shopInvoiceID,
                'shop_product_id' => $shopProductID,
                'price' => $price,
            )
        );

        // машины
        $shopCarItemIDs = Request_Request::find(
            'DB_Ab1_Shop_Car_Item', $sitePageData->shopID, $sitePageData, $driver, $params, 0, true,
            ['shop_car_id' => ['created_at']]
        );
        foreach ($shopCarItemIDs->childs as $child) {
            Api_Ab1_Shop_Car::calcPriceCar(
                $child->getElementValue('shop_car_id', 'created_at'), $child->values['shop_car_id'],
                $sitePageData, $driver, $child->values['id'], false, true
            );
        }

        // штручный товар
        $shopPieceItemIDs = Request_Request::find('DB_Ab1_Shop_Piece_Item',
            $sitePageData->shopID, $sitePageData, $driver, $params, 0,
            ['shop_piece_id' => ['created_at']]
        );
        foreach ($shopPieceItemIDs->childs as $child) {
            Api_Ab1_Shop_Piece::calcPricePiece(
                $child->getElementValue('shop_piece_id', 'created_at'), $child->values['shop_piece_id'],
                $sitePageData, $driver, $child->values['id'], false, true
            );
        }

        // пересчываем счет-фактуру
        Api_Ab1_Shop_Invoice::calcInvoiceAmount(
            $shopInvoiceID, $sitePageData, $driver, true
        );

        // пересчитать баланс клиента
        Api_Ab1_Shop_Client::recountBalanceObject(
            $model, $sitePageData, $driver
        );

        return true;
    }

    /**
     * Получение виртуальные накладных
     * @param $dateFrom
     * @param $dateTo
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @param array $params
     * @param null $shopID
     * @return MyArray
     */
    public static function getVirtualInvoices($dateFrom, $dateTo, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver,
                                              array $params = array(), $shopID = null)
    {
        $params = array_merge(
            $params,
            Request_RequestParams::setParams(
                array(
                    'exit_at_from' => $dateFrom,
                    'exit_at_to' => $dateTo,
                    'is_exit' => TRUE,
                    'is_charity' => FALSE,
                    'shop_invoice_id' => 0,
                    'quantity_from' => 0,
                )
            )
        );

        if($shopID > 0){
            $shopIDs = array($shopID);
        }else{
            $shopIDs = array();
        }

        // получаем список реализации
        $shopCarItemIDs = Request_Request::findBranch('DB_Ab1_Shop_Car_Item',
            $shopIDs, $sitePageData, $driver,
            $params, 0, TRUE,
            array(
                'shop_client_id' => array('name', 'balance', 'balance_cache'),
                'shop_client_attorney_id' => array('number', 'amount', 'block_amount', 'balance'),
                'shop_client_contract_id' => array('number'),
                'shop_car_id' => array('shop_delivery_id', 'exit_at'),
                'shop_product_id' => array('product_type_id'),
                'shop_id' => array('name'),
            )
        );

        $shopPieceItemIDs = Request_Request::findBranch('DB_Ab1_Shop_Piece_Item',
            $shopIDs, $sitePageData, $driver,
            $params, 0, TRUE,
            array(
                'shop_client_id' => array('name', 'balance', 'balance_cache'),
                'shop_client_attorney_id' => array('number', 'amount', 'block_amount', 'balance'),
                'shop_client_contract_id' => array('number'),
                'shop_piece_id' => array('shop_delivery_id', 'created_at'),
                'shop_product_id' => array('product_type_id'),
                'shop_id' => array('name'),
            )
        );

        if(empty($shopCarItemIDs->childs)){
            $shopCarItemIDs->childs = $shopPieceItemIDs->childs;
        }elseif(! empty($shopPieceItemIDs->childs)) {
            $shopCarItemIDs->childs = array_merge($shopCarItemIDs->childs, $shopPieceItemIDs->childs);
        }

        // тип продуктов
        $productTypeIDs = Request_Request::findAllNotShop(
            'DB_Ab1_ProductType', $sitePageData, $driver, TRUE
        );
        $productTypeIDs->runIndex(TRUE);

        $ids = new MyArray();
        foreach ($shopCarItemIDs->childs as $child){
            $exitAt = $child->getElementValue('shop_car_id', 'exit_at', null);
            if($exitAt == null){
                $exitAt = $child->getElementValue('shop_piece_id', 'created_at', null);
            }
            if($exitAt == null) {
                $exitAt = Arr::path($child->values, 'created_at', null);
            }

            $date = $exitAt;
            if(strtotime($exitAt) <= strtotime(Helpers_DateTime::getDateFormatPHP($exitAt).' 06:00:00')){
                $date = Helpers_DateTime::minusDays($date, 1);
            }
            $date = Helpers_DateTime::getDateFormatPHP($date);

            $isDelivery = $child->getElementValue('shop_car_id', 'shop_delivery_id', $child->getElementValue('shop_piece_id', 'shop_delivery_id', 0)) > 0;
            $productType = $child->getElementValue('shop_product_id', 'product_type_id');
            $key = $child->values['shop_client_id']
                . '_' . $child->values['shop_client_attorney_id']
                . '_' . $child->values['shop_client_contract_id']
                . '_' . $productType
                . '_' . $isDelivery
                . '_' . $date
                . '_' . $child->values['shop_id'];

            if(!key_exists($key, $ids->childs)){
                $car = new MyArray();

                $car->values = array(
                    'shop_client_id' => $child->values['shop_client_id'],
                    'shop_client_name' => $child->getElementValue('shop_client_id'),
                    'shop_client_attorney_id' => $child->values['shop_client_attorney_id'],
                    'shop_client_attorney_number' => '',
                    'shop_client_contract_id' => $child->values['shop_client_contract_id'],
                    'shop_client_contract_number' => $child->getElementValue('shop_client_contract_id', 'number'),
                    'is_delivery' => $isDelivery,
                    'shop_id' => $child->values['shop_id'],
                    'date' => $date,
                    'total' => 0,
                    'count' => 0,
                );

                $car->values[Model_Basic_BasicObject::FIELD_ELEMENTS]['shop_id']['name'] =$child->getElementValue('shop_id');
                $car->values['product_type_id'] = $productType;
                if(key_exists($productType, $productTypeIDs->childs)){
                    $car->values['product_type_name'] = $productTypeIDs->childs[$productType]->values['name'];
                }else{
                    $car->values['product_type_name'] = '';
                }

                if($child->values['shop_client_attorney_id'] > 0){
                    $car->values['shop_client_attorney_number'] = $child->getElementValue('shop_client_attorney_id', 'number');
                    $car->values['amount'] = $child->getElementValue('shop_client_attorney_id', 'amount');
                    $car->values['block_amount'] = $child->getElementValue('shop_client_attorney_id', 'block_amount');
                }else{
                    $car->values['amount'] = $child->getElementValue('shop_client_id', 'amount_cash');
                    $car->values['block_amount'] = $child->getElementValue('shop_client_id', 'block_amount_cash');
                }

                $car->setIsFind(TRUE);
                $ids->childs[$key] = $car;
            }

            $ids->childs[$key]->values['total'] += $child->values['amount'];
            $ids->childs[$key]->values['count']++;
        }
        $ids->childsSortBy(
            array(
                'date', 'shop_client_name', 'shop_client_attorney_id',
            )
        );

        return $ids;
    }


    /**
     * Пересчитать цены накладной
     * @param $shopInvoiceID
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @throws HTTP_Exception_404
     */
    public static function calcInvoicePrice($shopInvoiceID, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        if ($shopInvoiceID < 1) {
            throw new HTTP_Exception_404('Invoice not found.');
        }

        $shopClientID = 0;
        $params = Request_RequestParams::setParams(
            array(
                'shop_invoice_id' => $shopInvoiceID,
            )
        );
        // машины
        $shopCarItemIDs = Request_Request::find(
            'DB_Ab1_Shop_Car_Item', $sitePageData->shopID, $sitePageData, $driver, $params, 0, true,
            ['shop_car_id' => ['created_at']]
        );

        foreach ($shopCarItemIDs->childs as $child) {
            Api_Ab1_Shop_Car::calcPriceCar(
                $child->getElementValue('shop_car_id', 'created_at'), $child->values['shop_car_id'],
                $sitePageData, $driver, $child->values['id']
            );
            $shopClientID = $child->values['shop_client_id'];
        }

        // штручный товар
        $shopPieceItemIDs = Request_Request::find('DB_Ab1_Shop_Piece_Item',
            $sitePageData->shopID, $sitePageData, $driver, $params, 0,
            ['shop_piece_id' => ['created_at']]
        );

        foreach ($shopPieceItemIDs->childs as $child) {
            Api_Ab1_Shop_Piece::calcPricePiece(
                $child->getElementValue('shop_piece_id', 'created_at'), $child->values['shop_piece_id'],
                $sitePageData, $driver, $child->values['id']
            );
            $shopClientID = $child->values['shop_client_id'];
        }

        // пересчываем счет-фактуру
        Api_Ab1_Shop_Invoice::calcInvoiceAmount(
            $shopInvoiceID, $sitePageData, $driver, true
        );

        // пересчитать баланс клиента
        Api_Ab1_Shop_Client::recountBalanceObject(
            null, $sitePageData, $driver, $shopClientID
        );
    }

    /**
     * Изменяем данные машин накладной одного клиента + доверенность на другого клиента + доверенность на количество
     * @param $shopInvoiceID
     * @param $shopClientAttorneyIDTo
     * @param $shopClientContractIDTo
     * @param $shopProductID
     * @param $quantity
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @return array
     * @throws HTTP_Exception_500
     */
    public static function breakInvoiceQuantity($shopInvoiceID, $shopClientAttorneyIDTo, $shopClientContractIDTo,
                                              $shopProductID, $quantity,
                                              SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        if($shopInvoiceID < 1){
            return false;
        }

        $modelFrom = new Model_Ab1_Shop_Invoice();
        $modelFrom->setDBDriver($driver);
        if(! Helpers_DB::getDBObject($modelFrom, $shopInvoiceID, $sitePageData)){
            throw new HTTP_Exception_500('Invoice id="'.$shopInvoiceID.'" not found.');
        }

        if($modelFrom->getShopClientAttorneyID() == $shopClientAttorneyIDTo
            && $modelFrom->getShopClientContractID() == $shopClientContractIDTo){
            return array(
                $modelFrom->id,
            );
        }

        // находим куда можно перенести продукцию
        $params = Request_RequestParams::setParams(
            array(
                'shop_client_id' => $modelFrom->getShopClientID(),
                'shop_client_attorney_id' => $shopClientAttorneyIDTo,
                'shop_client_contract_id' => $shopClientContractIDTo,
                'is_delivery' => $modelFrom->getIsDelivery(),
                'date' => $modelFrom->getDate(),
                'id_not' => $shopInvoiceID,
            )
        );
        $shopInvoiceIDs = Request_Request::find('DB_Ab1_Shop_Invoice',
            $sitePageData->shopID, $sitePageData, $driver, $params, 0, TRUE
        );

        $isAll = $quantity  < 0.0001;

        $params = Request_RequestParams::setParams(
            array(
                'shop_invoice_id' => $shopInvoiceID,
                'shop_product_id' => $shopProductID,
                'is_delivery' => $modelFrom->getIsDelivery(),
                'sort_by' => array('amount' => 'desc'),
            )
        );
        $shopCarItemIDs = Request_Request::find('DB_Ab1_Shop_Car_Item',
            $sitePageData->shopID, $sitePageData, $driver, $params, 0, TRUE
        );
        // если вдруг у счет-фактуры товары нет заданной доверенности и договора, то делаем правку
        foreach ($shopCarItemIDs->childs as $child){
            if($child->values['shop_client_attorney_id'] != $modelFrom->getShopClientAttorneyID()
                || $child->values['shop_client_contract_id'] != $modelFrom->getShopClientContractID()){
                $modelItem = new Model_Ab1_Shop_Car_Item();
                $modelItem->setDBDriver($driver);
                $child->setModel($modelItem);

                $modelItem->setShopClientContractID($modelFrom->getShopClientContractID());
                $modelItem->setShopClientAttorneyID($modelFrom->getShopClientAttorneyID());
                Helpers_DB::saveDBObject($modelItem, $sitePageData);
            }
        }

        $shopPieceItemIDs = Request_Request::find('DB_Ab1_Shop_Piece_Item',
            $sitePageData->shopID, $sitePageData, $driver, $params, 0, TRUE
        );
        // если вдруг у счет-фактуры товары нет заданной доверенности и договора, то делаем правку
        foreach ($shopPieceItemIDs->childs as $child){
            if($child->values['shop_client_attorney_id'] != $modelFrom->getShopClientAttorneyID()
                || $child->values['shop_client_contract_id'] != $modelFrom->getShopClientContractID()){
                $modelItem = new Model_Ab1_Shop_Piece_Item();
                $modelItem->setDBDriver($driver);
                $child->setModel($modelItem);

                $modelItem->setShopClientContractID($modelFrom->getShopClientContractID());
                $modelItem->setShopClientAttorneyID($modelFrom->getShopClientAttorneyID());
                Helpers_DB::saveDBObject($modelItem, $sitePageData);
            }
        }

        // если переносим один продукт и он всего лишь один, то откуда куда будет одна и таже счет-фактура
        if($isAll && count($shopCarItemIDs->childs) + count($shopPieceItemIDs->childs) == 1) {
            $modelTo = $modelFrom;
        }else{
            $modelTo = new  Model_Ab1_Shop_Invoice();
            $modelTo->setDBDriver($driver);

            if (count($shopInvoiceIDs->childs) > 0) {
                $shopInvoiceIDs->childs[0]->setModel($modelTo);
            } else {
                $modelTo->setShopClientID($modelFrom->getShopClientID());
                $modelTo->setShopClientAttorneyID($shopClientAttorneyIDTo);
                $modelTo->setShopClientContractID($shopClientContractIDTo);
                $modelTo->setIsDelivery($modelFrom->getIsDelivery());
                $modelTo->setDate($modelFrom->getDate());
                $modelTo->setDateFrom($modelFrom->getDateFrom());
                $modelTo->setDateTo($modelFrom->getDateTo());
                $modelTo->setProductTypeID($modelFrom->getProductTypeID());

                // счетчик как в 1с
                $modelTo->setNumber(DB_Basic::getNumber1C($modelTo, $sitePageData, $driver, $sitePageData->shopID));

                Helpers_DB::saveDBObject($modelTo, $sitePageData);
            }
        }

        /** переносим заказы, пытаемся разделить построчно **/
        if($isAll || $quantity > 0.0001) {
            foreach ($shopCarItemIDs->childs as $key => $child) {
                if ($isAll || ($quantity >= $child->values['quantity'])) {
                    Api_Ab1_Shop_Car_Item::editAttorney(
                        $child->id, $shopClientAttorneyIDTo, $shopClientContractIDTo, $sitePageData, $driver,
                        FALSE, $modelTo->id
                    );
                    $quantity = $quantity - $child->values['quantity'];

                    unset($shopCarItemIDs->childs[$key]);
                }

                if ((!$isAll) && ($quantity < 0.0001)) {
                    break;
                }
            }
        }

        /** переносим заказы Штучного товара, пытаемся разделить построчно **/
        if($isAll || $quantity > 0.0001) {
            foreach ($shopPieceItemIDs->childs as $key => $child) {
                if ($isAll || ($quantity >= $child->values['quantity'])) {
                    Api_Ab1_Shop_Piece_Item::editAttorney(
                        $child->id, $shopClientAttorneyIDTo, $shopClientContractIDTo, $sitePageData, $driver,
                        FALSE, $modelTo->id
                    );
                    $quantity = $quantity - $child->values['quantity'];

                    unset($shopPieceItemIDs->childs[$key]);
                }

                if ((!$isAll) && ($quantity < 0.0001)) {
                    break;
                }
            }
        }

        /** переносим заказы Штучного товара, пытаемся разделить на две строчки **/
        if($isAll || $quantity > 0.0001) {
            foreach ($shopPieceItemIDs->childs as $key => $child) {
                if ($quantity < $child->values['quantity']) {
                    Api_Ab1_Shop_Piece_Item::breakItemToTwoQuantity(
                        $child->id, $shopClientAttorneyIDTo, $shopClientContractIDTo, $quantity, $sitePageData, $driver,
                        FALSE, $modelTo->id
                    );
                    $quantity = 0;
                    break;
                }
            }
        }

        /** переносим заказы, пытаемся разделить на две строчки **/
        if($isAll || $quantity > 0.0001) {
            foreach ($shopCarItemIDs->childs as $key => $child) {
                if ($quantity < $child->values['quantity']) {
                    Api_Ab1_Shop_Car_Item::breakItemToTwoQuantity(
                        $child->id, $shopClientAttorneyIDTo, $shopClientContractIDTo, $quantity, $sitePageData, $driver,
                        FALSE, $modelTo->id
                    );
                    break;
                }
            }
        }

        // обновляем балансы клиента
        Api_Ab1_Shop_Client::recountBalanceObject(
            $modelFrom, $sitePageData, $driver
        );

        // пересчитываем балансы накладаных
        $modelFrom->setAmount(Api_Ab1_Shop_Invoice::calcInvoiceAmount($modelFrom->id, $sitePageData, $driver));
        if($modelFrom->getAmount() > 0){
            Helpers_DB::saveDBObject($modelFrom, $sitePageData);
        }elseif($modelFrom->id != $modelTo->id){
            $modelFrom->dbDelete($sitePageData->userID);
        }

        if($modelFrom->id != $modelTo->id) {
            $modelTo->setAmount(Api_Ab1_Shop_Invoice::calcInvoiceAmount($modelTo->id, $sitePageData, $driver));
            if ($modelTo->getAmount() > 0) {
                Helpers_DB::saveDBObject($modelTo, $sitePageData);
            } else {
                $modelTo->dbDelete($sitePageData->userID);
            }
        }

        // пересчитываем балансы наличных клиента
        Api_Ab1_Shop_Client::calcBalanceCash($modelTo->getShopClientID(), $sitePageData, $driver, true);
        if($modelFrom->getShopClientID() != $modelTo->getShopClientID()) {
            Api_Ab1_Shop_Client::calcBalanceCash($modelFrom->getShopClientID(), $sitePageData, $driver, true);
        }

        return array(
            $modelFrom->id,
            $modelTo->id,
        );
    }

    /**
     * Изменяем данные машин накладной одного клиента + доверенность на другого клиента + доверенность на сумму
     * @param $shopInvoiceID
     * @param $shopClientAttorneyIDTo
     * @param $shopClientContractIDTo
     * @param $shopProductID
     * @param $amount
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @return array
     * @throws HTTP_Exception_500
     */
    public static function breakInvoiceAmount($shopInvoiceID, $shopClientAttorneyIDTo, $shopClientContractIDTo,
                                              $shopProductID, $amount,
                                              SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        if($shopInvoiceID < 1){
            return false;
        }

        $modelFrom = new Model_Ab1_Shop_Invoice();
        $modelFrom->setDBDriver($driver);
        if(! Helpers_DB::getDBObject($modelFrom, $shopInvoiceID, $sitePageData)){
            throw new HTTP_Exception_500('Invoice id="'.$shopInvoiceID.'" not found.');
        }

        if($modelFrom->getShopClientAttorneyID() == $shopClientAttorneyIDTo
            && $modelFrom->getShopClientContractID() == $shopClientContractIDTo){
            return array(
                $modelFrom->id,
            );
        }

        // находим куда можно перенести продукцию
        $params = Request_RequestParams::setParams(
            array(
                'shop_client_id' => $modelFrom->getShopClientID(),
                'shop_client_attorney_id' => $shopClientAttorneyIDTo,
                'shop_client_contract_id' => $shopClientContractIDTo,
                'is_delivery' => $modelFrom->getIsDelivery(),
                'date' => $modelFrom->getDate(),
                'id_not' => $shopInvoiceID,
            )
        );
        $shopInvoiceIDs = Request_Request::find('DB_Ab1_Shop_Invoice',
            $sitePageData->shopID, $sitePageData, $driver, $params, 0, TRUE
        );

        $isAll = $amount  < 0.001;

        $params = Request_RequestParams::setParams(
            array(
                'shop_invoice_id' => $shopInvoiceID,
                'shop_product_id' => $shopProductID,
                'is_delivery' => $modelFrom->getIsDelivery(),
                'sort_by' => array('amount' => 'desc'),
            )
        );
        $shopCarItemIDs = Request_Request::find('DB_Ab1_Shop_Car_Item',
            $sitePageData->shopID, $sitePageData, $driver, $params, 0, TRUE
        );
        // если вдруг у счет-фактуры товары нет заданной доверенности и договора, то делаем правку
        foreach ($shopCarItemIDs->childs as $child){
            if($child->values['shop_client_attorney_id'] != $modelFrom->getShopClientAttorneyID()
            || $child->values['shop_client_contract_id'] != $modelFrom->getShopClientContractID()){
                $modelItem = new Model_Ab1_Shop_Car_Item();
                $modelItem->setDBDriver($driver);
                $child->setModel($modelItem);

                $modelItem->setShopClientContractID($modelFrom->getShopClientContractID());
                $modelItem->setShopClientAttorneyID($modelFrom->getShopClientAttorneyID());
                Helpers_DB::saveDBObject($modelItem, $sitePageData);
            }
        }

        $shopPieceItemIDs = Request_Request::find('DB_Ab1_Shop_Piece_Item',
            $sitePageData->shopID, $sitePageData, $driver, $params, 0, TRUE
        );
        // если вдруг у счет-фактуры товары нет заданной доверенности и договора, то делаем правку
        foreach ($shopPieceItemIDs->childs as $child){
            if($child->values['shop_client_attorney_id'] != $modelFrom->getShopClientAttorneyID()
                || $child->values['shop_client_contract_id'] != $modelFrom->getShopClientContractID()){
                $modelItem = new Model_Ab1_Shop_Piece_Item();
                $modelItem->setDBDriver($driver);
                $child->setModel($modelItem);

                $modelItem->setShopClientContractID($modelFrom->getShopClientContractID());
                $modelItem->setShopClientAttorneyID($modelFrom->getShopClientAttorneyID());
                Helpers_DB::saveDBObject($modelItem, $sitePageData);
            }
        }

        // если переносим один продукт и он всего лишь один, то откуда куда будет одна и таже счет-фактура
        if($isAll && count($shopCarItemIDs->childs) + count($shopPieceItemIDs->childs) == 1) {
            $modelTo = $modelFrom;
        }else{
            $modelTo = new  Model_Ab1_Shop_Invoice();
            $modelTo->setDBDriver($driver);

            if (count($shopInvoiceIDs->childs) > 0) {
                $shopInvoiceIDs->childs[0]->setModel($modelTo);
            } else {
                $modelTo->setShopClientID($modelFrom->getShopClientID());
                $modelTo->setShopClientAttorneyID($shopClientAttorneyIDTo);
                $modelTo->setShopClientContractID($shopClientContractIDTo);
                $modelTo->setIsDelivery($modelFrom->getIsDelivery());
                $modelTo->setDate($modelFrom->getDate());
                $modelTo->setDateFrom($modelFrom->getDateFrom());
                $modelTo->setDateTo($modelFrom->getDateTo());
                $modelTo->setProductTypeID($modelFrom->getProductTypeID());

                // счетчик как в 1с
                $modelTo->setNumber(DB_Basic::getNumber1C($modelTo, $sitePageData, $driver, $sitePageData->shopID));

                Helpers_DB::saveDBObject($modelTo, $sitePageData);
            }
        }

        /** переносим заказы, пытаемся разделить построчно **/
        if($isAll || $amount > 0.001) {
            foreach ($shopCarItemIDs->childs as $key => $child) {
                if ($isAll || ($amount >= $child->values['amount'])) {
                    Api_Ab1_Shop_Car_Item::editAttorney(
                        $child->id, $shopClientAttorneyIDTo, $shopClientContractIDTo, $sitePageData, $driver,
                        FALSE, $modelTo->id
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
                        $child->id, $shopClientAttorneyIDTo, $shopClientContractIDTo, $sitePageData, $driver,
                        FALSE, $modelTo->id
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
                        $child->id, $shopClientAttorneyIDTo, $shopClientContractIDTo, $amount, $sitePageData, $driver,
                        FALSE, $modelTo->id
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
                        $child->id, $shopClientAttorneyIDTo, $shopClientContractIDTo, $amount, $sitePageData, $driver,
                        FALSE, $modelTo->id
                    );
                    $amount = 0;
                    break;
                }
            }
        }

        // обновляем балансы клиента
        Api_Ab1_Shop_Client::recountBalanceObject(
            $modelFrom, $sitePageData, $driver
        );

        // пересчитываем балансы накладаных
        $modelFrom->setAmount(Api_Ab1_Shop_Invoice::calcInvoiceAmount($modelFrom->id, $sitePageData, $driver));
        if($modelFrom->getAmount() > 0){
            Helpers_DB::saveDBObject($modelFrom, $sitePageData);
        }elseif($modelFrom->id != $modelTo->id){
            $modelFrom->dbDelete($sitePageData->userID);
        }

        if($modelFrom->id != $modelTo->id) {
            $modelTo->setAmount(Api_Ab1_Shop_Invoice::calcInvoiceAmount($modelTo->id, $sitePageData, $driver));
            if ($modelTo->getAmount() > 0) {
                Helpers_DB::saveDBObject($modelTo, $sitePageData);
            } else {
                $modelTo->dbDelete($sitePageData->userID);
            }
        }

        // пересчитываем балансы наличных клиента
        Api_Ab1_Shop_Client::calcBalanceCash($modelTo->getShopClientID(), $sitePageData, $driver, true);
        if($modelFrom->getShopClientID() != $modelTo->getShopClientID()) {
            Api_Ab1_Shop_Client::calcBalanceCash($modelFrom->getShopClientID(), $sitePageData, $driver, true);
        }

        return array(
            $modelFrom->id,
            $modelTo->id,
        );
    }

    /**
     * Меняем договор, доверенность, клиента у детворы накладной
     * @param Model_Ab1_Shop_Invoice $modelInvoice
     * @param $shopClientIDFrom
     * @param $shopClientAttorneyIDFrom
     * @param $shopClientContractIDFrom
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @return bool|Model_Ab1_Shop_Invoice
     */
    public static function editInvoice(Model_Ab1_Shop_Invoice $modelInvoice,
                                       $shopClientIDFrom, $shopClientAttorneyIDFrom, $shopClientContractIDFrom,
                                       SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
       /* echo $shopClientIDFrom .'='.$modelInvoice->getShopClientID().'<br>'
            .$shopClientAttorneyIDFrom .'='.$modelInvoice->getShopClientAttorneyID().'<br>'
            .$shopClientContractIDFrom .'='.$modelInvoice->getShopClientContractID().'<br>';die;*/

        $params = Request_RequestParams::setParams(
            array(
                'shop_invoice_id' => $modelInvoice->id,
            )
        );
        // реализация
        $shopCarItemIDs = Request_Request::find('DB_Ab1_Shop_Car_Item',
            $sitePageData->shopID, $sitePageData, $driver, $params, 0, TRUE,
            array(
                'shop_car_id' => array('amount')
            )
        );
        // штучный товар
        $shopPieceItemIDs = Request_Request::find('DB_Ab1_Shop_Piece_Item',
            $sitePageData->shopID, $sitePageData, $driver, $params, 0, TRUE,
            array(
                'shop_piece_id' => array('amount')
            )
        );

        if((count($shopCarItemIDs->childs) == 0) && (count($shopPieceItemIDs->childs) == 0)){
            return true;
        }

        // если нужно менять клиента, то проверяем возможность
        if($modelInvoice->getShopClientID() != $shopClientIDFrom){
            $list = array();
            // собираем суммы детворы реализации
            foreach ($shopCarItemIDs->childs as $child){
                $shopCarID = $child->values['shop_car_id'];
                if(!key_exists($shopCarID, $list)){
                    $list[$shopCarID] = array(
                        'amount' => $child->getElementValue('shop_car_id', 'amount', 0),
                        'items' => 0,
                    );
                }

                $list[$shopCarID]['items'] += $child->values['amount'];
            }

            // собираем суммы детворы реализации штучного товара
            foreach ($shopPieceItemIDs->childs as $child){
                $shopPieceID = $child->values['shop_piece_id'];
                if(!key_exists($shopPieceID, $list)){
                    $list[$shopPieceID] = array(
                        'amount' => $child->getElementValue('shop_piece_id', 'amount', 0),
                        'items' => 0,
                    );
                }

                $list[$shopPieceID]['items'] += $child->values['amount'];
            }

            // если суммы реализации / реализации штучного товара не равны сумму детворы, то не возможно изменение клиента
            // получается часть данных привязаны к другой накладной
            foreach ($list as $child){
                if(abs($child['items'] - $child['amount']) > 0.001){
                    return false;
                }
            }
        }

        $contracts = array();
        $attorneys = array();
        $productPrices = array();

        /***** Меняем данные детворы *****/

        // меняем данные у реализации
        foreach ($shopCarItemIDs->childs as $child){
            $modelItem = new Model_Ab1_Shop_Car_Item();
            $modelItem->setDBDriver($driver);
            $child->setModel($modelItem);

            $contracts[$modelItem->getShopClientContractID()] = $modelItem->getShopClientContractID();
            $attorneys[$modelItem->getShopClientAttorneyID()] = $modelItem->getShopClientAttorneyID();
            $productPrices[$modelItem->getShopProductPriceID()] = $modelItem->getShopProductPriceID();

            if($shopClientIDFrom != $modelInvoice->getShopClientID()){
                $modelItem->setShopClientID($modelInvoice->getShopClientID());
                $modelItem->setShopClientContractItemID(0);
                $modelItem->setShopProductPriceID(0);
            }

            if($shopClientContractIDFrom != $modelInvoice->getShopClientContractID()) {
                $modelItem->setShopClientContractID($modelInvoice->getShopClientContractID());
                $modelItem->setShopClientContractItemID(0);
            }

            $modelItem->setShopClientAttorneyID($modelInvoice->getShopClientAttorneyID());

            Helpers_DB::saveDBObject($modelItem, $sitePageData);
        }

        // меняем данные у штучной реализации
        foreach ($shopPieceItemIDs->childs as $child){
            $modelItem = new Model_Ab1_Shop_Piece_Item();
            $modelItem->setDBDriver($driver);
            $child->setModel($modelItem);

            $contracts[$modelItem->getShopClientContractID()] = $modelItem->getShopClientContractID();
            $attorneys[$modelItem->getShopClientAttorneyID()] = $modelItem->getShopClientAttorneyID();
            $productPrices[$modelItem->getShopProductPriceID()] = $modelItem->getShopProductPriceID();

            if($shopClientIDFrom != $modelInvoice->getShopClientID()){
                $modelItem->setShopClientID($modelInvoice->getShopClientID());
                $modelItem->setShopClientContractItemID(0);
                $modelItem->setShopProductPriceID(0);
            }

            if($shopClientContractIDFrom != $modelInvoice->getShopClientContractID()) {
                $modelItem->setShopClientContractID($modelInvoice->getShopClientContractID());
                $modelItem->setShopClientContractItemID(0);
            }

            $modelItem->setShopClientAttorneyID($modelInvoice->getShopClientAttorneyID());
            Helpers_DB::saveDBObject($modelItem, $sitePageData);
        }

        /***** Меняем данные реализации *****/

        // реализация
        $shopCarIDs = $shopCarItemIDs->getChildArrayInt('shop_car_id', TRUE);
        if(count($shopCarIDs) > 0) {
            $params = Request_RequestParams::setParams(
                array(
                    'id' => $shopCarIDs,
                )
            );
            $shopCarIDs = Request_Request::find('DB_Ab1_Shop_Car',
                $sitePageData->shopID, $sitePageData, $driver, $params, 10000, TRUE
            );


            $model = new Model_Ab1_Shop_Car();
            $model->setDBDriver($driver);
            foreach ($shopCarIDs->childs as $child){
                $child->setModel($model);

                $model->setShopClientID($modelInvoice->getShopClientID());

                if($model->getShopClientAttorneyID() == $shopClientAttorneyIDFrom){
                    $model->setShopClientAttorneyID($modelInvoice->getShopClientAttorneyID());
                }

                if($model->getShopClientContractID() == $shopClientAttorneyIDFrom){
                    $model->setShopClientContractID($modelInvoice->getShopClientContractID());
                }

                Helpers_DB::saveDBObject($model, $sitePageData);
            }
        }

        // штучный товар
        $shopPieceIDs = $shopPieceItemIDs->getChildArrayInt('shop_piece_id', TRUE);
        if(count($shopPieceIDs) > 0) {
            $params = Request_RequestParams::setParams(
                array(
                    'id' => $shopPieceIDs,
                )
            );
            $shopPieceIDs = Request_Request::find('DB_Ab1_Shop_Piece',
                $sitePageData->shopID, $sitePageData, $driver, $params, 10000, TRUE
            );

            $model = new Model_Ab1_Shop_Piece();
            $model->setDBDriver($driver);
            foreach ($shopPieceIDs->childs as $child){
                $child->setModel($model);

                $model->setShopClientID($modelInvoice->getShopClientID());

                if($model->getShopClientAttorneyID() == $shopClientAttorneyIDFrom){
                    $model->setShopClientAttorneyID($modelInvoice->getShopClientAttorneyID());
                }

                if($model->getShopClientContractID() == $shopClientAttorneyIDFrom){
                    $model->setShopClientContractID($modelInvoice->getShopClientContractID());
                }

                Helpers_DB::saveDBObject($model, $sitePageData);
            }
        }

        // обновляем балансы клиентов
        if($modelInvoice->getShopClientID() != $shopClientIDFrom){
            Api_Ab1_Shop_Client::calcBalanceBlock($shopClientIDFrom, $sitePageData, $driver);
            Api_Ab1_Shop_Client::calcBalanceBlock($modelInvoice->getShopClientID(), $sitePageData, $driver);
        }

        // пересчитываем баланс договоров
        Api_Ab1_Shop_Client_Contract::calcBalancesBlock($contracts, $sitePageData, $driver);
        // пересчитываем баланс доверенностей
        Api_Ab1_Shop_Client_Attorney::calcBalancesBlock($attorneys, $sitePageData, $driver);
        // пересчитываем баланс продукции прайс-листов
        Api_Ab1_Shop_Product_Price::calcBalancesBlock($productPrices, $sitePageData, $driver);

        return TRUE;
    }

    /**
     * Добавление накладной
     * @param $shopClientID
     * @param $shopClientAttorneyID
     * @param $shopClientContractID
     * @param $productTypeID
     * @param $isDelivery
     * @param $date
     * @param $dateFrom
     * @param $dateTo
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @return bool|Model_Ab1_Shop_Invoice
     */
    public static function addInvoice($shopClientID, $shopClientAttorneyID, $shopClientContractID, $productTypeID, $isDelivery,
                                      $date, $dateFrom, $dateTo, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        $params = Request_RequestParams::setParams(
            array(
                'exit_at_from' => $dateFrom,
                'exit_at_to' => $dateTo,
                'shop_client_id' => $shopClientID,
                'shop_car_id.shop_client_id' => $shopClientID,
                'shop_client_attorney_id' => $shopClientAttorneyID,
                'shop_client_contract_id' => $shopClientContractID,
                'shop_product_id.product_type_id' => $productTypeID,
                'is_exit' => TRUE,
                'is_charity' => FALSE,
                'is_delivery' => $isDelivery,
                'shop_invoice_id' => 0,
                'quantity_from' => 0,
            )
        );
        // реализация
        $shopCarItemIDs = Request_Request::find('DB_Ab1_Shop_Car_Item',
            $sitePageData->shopID, $sitePageData, $driver, $params, 0, TRUE
        );
        // штучный товар
        $shopPieceItemIDs = Request_Request::find('DB_Ab1_Shop_Piece_Item',
            $sitePageData->shopID, $sitePageData, $driver, $params, 0, TRUE
        );

        if((count($shopCarItemIDs->childs) == 0) && (count($shopPieceItemIDs->childs) == 0)){
            return FALSE;
        }

        $model = new Model_Ab1_Shop_Invoice();
        $model->setDBDriver($driver);

        $model->setShopClientID($shopClientID);
        $model->setShopClientAttorneyID($shopClientAttorneyID);
        $model->setShopClientContractID($shopClientContractID);
        $model->setDate($date);
        $model->setDateFrom($dateFrom);
        $model->setDateTo($dateTo);
        $model->setIsDelivery($isDelivery);
        $model->setProductTypeID($productTypeID);

        // счетчик как в 1с
        DB_Basic::setNumber1CIfEmpty($model, 'number', $sitePageData, $driver, $sitePageData->shopID);

        Helpers_DB::saveDBObject($model, $sitePageData);

        // добавляем ссылки на накладную у реализации
        $driver->updateObjects(
            Model_Ab1_Shop_Car_Item::TABLE_NAME, $shopCarItemIDs->getChildArrayID(),
            array('shop_invoice_id' => $model->id), 0, $sitePageData->shopID
        );

        // добавляем что у реализации есть накладная
        $driver->updateObjects(
            Model_Ab1_Shop_Car::TABLE_NAME, $shopCarItemIDs->getChildArrayInt('shop_car_id', TRUE),
            array('is_invoice' => 1), 0, $sitePageData->shopID
        );

        // убираем ссылки на накладную у штучного товара
        $driver->updateObjects(
            Model_Ab1_Shop_Piece_Item::TABLE_NAME, $shopPieceItemIDs->getChildArrayID(),
            array('shop_invoice_id' => $model->id), 0, $sitePageData->shopID
        );

        // добавляем что у реализации есть накладная
        $driver->updateObjects(
            Model_Ab1_Shop_Piece::TABLE_NAME, $shopPieceItemIDs->getChildArrayInt('shop_piece_id', TRUE),
            array('is_invoice' => 1), 0, $sitePageData->shopID
        );

        // считаем итоговую сумму накладной
        $model->setAmount(self::calcInvoiceAmount($model->id, $sitePageData, $driver));

        Helpers_DB::saveDBObject($model, $sitePageData);

        return $model;
    }

    /**
     * Просчет суммы накладной
     * @param $shopInvoiceID
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @param bool $isSaveAmount
     * @return bool|int
     * @throws HTTP_Exception_500
     */
    public static function calcInvoiceAmount($shopInvoiceID, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver,
                                             $isSaveAmount = FALSE)
    {
        if($shopInvoiceID < 1){
            return FALSE;
        }

        $amount = 0;

        /** Считаем наличные деньги **/
        $params = Request_RequestParams::setParams(
            array(
                'shop_invoice_id' => $shopInvoiceID,
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

        // штучный товар
        $ids = Request_Request::find('DB_Ab1_Shop_Piece_Item',
            $sitePageData->shopID, $sitePageData, $driver, $params, 0, TRUE
        );
        if(count($ids->childs) > 0){
            $amount += $ids->childs[0]->values['amount'];
        }

        if($isSaveAmount) {
            $model = new Model_Ab1_Shop_Invoice();
            $model->setDBDriver($driver);

            if (!Helpers_DB::dublicateObjectLanguage($model, $shopInvoiceID, $sitePageData)) {
                throw new HTTP_Exception_500('Client not found. #5');
            }
            $model->setAmount($amount);
            Helpers_DB::saveDBObject($model, $sitePageData);
        }

        return $amount;
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

        $model = new Model_Ab1_Shop_Invoice();
        $model->setDBDriver($driver);

        if (!Helpers_DB::dublicateObjectLanguage($model, $id, $sitePageData)) {
            throw new HTTP_Exception_500('Invoice not found.');
        }

        if ($isUnDel || ($isUnDel && !$model->getIsDelete()) || (!$isUnDel && $model->getIsDelete())){
            return FALSE;
        }

        $params = Request_RequestParams::setParams(
            array(
                'shop_invoice_id' => $id,
            )
        );

        // убираем ссылки на накладную у реализации
        $ids = Request_Request::find('DB_Ab1_Shop_Car_Item',
            $sitePageData->shopID, $sitePageData, $driver,$params
        );
        $driver->updateObjects(
            Model_Ab1_Shop_Car_Item::TABLE_NAME, $ids->getChildArrayID(),
            array('shop_invoice_id' => 0), 0, $sitePageData->shopID
        );

        // убираем ссылки на накладную у штучного товара
        $ids = Request_Request::find('DB_Ab1_Shop_Piece_Item',
            $sitePageData->shopID, $sitePageData, $driver,$params
        );
        $driver->updateObjects(
            Model_Ab1_Shop_Piece_Item::TABLE_NAME, $ids->getChildArrayID(),
            array('shop_invoice_id' => 0), 0, $sitePageData->shopID
        );

        $model->dbDelete($sitePageData->userID, 0, $sitePageData->shopID);

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
        $model = new Model_Ab1_Shop_Invoice();
        $model->setDBDriver($driver);

        $id = Request_RequestParams::getParamInt('id');
        if($id > 0) {
            if (!Helpers_DB::dublicateObjectLanguage($model, $id, $sitePageData)) {
                throw new HTTP_Exception_500('Invoice not found.');
            }
        }

        $shopClientAttorneyIDFrom = $model->getShopClientAttorneyID();
        $shopClientContractIDFrom = $model->getShopClientContractID();
        $shopClientIDFrom = $model->getShopClientID();

        Request_RequestParams::setParamBoolean('is_public', $model);
        Request_RequestParams::setParamStr('text', $model);
        Request_RequestParams::setParamStr('name', $model);
        Request_RequestParams::setParamStr("old_id", $model);
        Request_RequestParams::setParamInt("shop_client_id", $model);
        Request_RequestParams::setParamInt("shop_client_attorney_id", $model);
        Request_RequestParams::setParamInt("shop_client_contract_id", $model);
        Request_RequestParams::setParamInt("check_type_id", $model);
        Request_RequestParams::setParamDateTime("date", $model);
        Request_RequestParams::setParamDateTime("date_from", $model);
        Request_RequestParams::setParamDateTime("date_to", $model);
        Request_RequestParams::setParamStr('number', $model);

        $options = Request_RequestParams::getParamArray('options');
        if ($options !== NULL) {
            $model->addOptionsArray($options);
        }

        // выдали накладную клиенту в бумажном виде
        if(Request_RequestParams::getParamBoolean('is_give_to_client')){
            $model->setIsGiveToClient(TRUE);
        }

        $result = array();
        if ($model->validationFields($result)) {
            // счетчик как в 1с
            DB_Basic::setNumber1CIfEmpty($model, 'number', $sitePageData, $driver, $sitePageData->shopID);

            if($model->id < 1) {
                Helpers_DB::saveDBObject($model, $sitePageData);
            }

            // Меняем договор, доверенность, клиента у детворы накладной
            if(! Api_Ab1_Shop_Invoice::editInvoice(
                $model,
                $shopClientIDFrom, $shopClientAttorneyIDFrom, $shopClientContractIDFrom,
                $sitePageData, $driver
            )){
                // менять нельзя
                $model->setShopClientAttorneyID($shopClientAttorneyIDFrom);
                $model->setShopClientContractID($shopClientContractIDFrom);
                $model->setShopClientID($shopClientIDFrom);
            }

            // считаем итоговую сумму накладной
            $model->setAmount(self::calcInvoiceAmount($model->id, $sitePageData, $driver));

            // загружаем фотографии
            $file = new Model_File($sitePageData);
            $file->saveFiles(Request_RequestParams::getParamArray('files'), $model, $sitePageData, $driver);

            Helpers_DB::saveDBObject($model, $sitePageData);
            $result['values'] = $model->getValues();
        }

        return array(
            'id' => $model->id,
            'result' => $result,
        );
    }

    /**
     * Сохраняем накладные в виде XML
     * @param $dateFrom
     * @param $dateTo
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @param bool $isPHPOutput
     * @return string
     */
    public static function saveXML($dateFrom, $dateTo, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver,
                                   $isPHPOutput = FALSE)
    {
        // получаем список
        $params = Request_RequestParams::setParams(
            array(
                //'updated_at_from' => Helpers_DateTime::getDateTimeFormatPHP($date),
                'date_from_equally' => Helpers_DateTime::getDateFormatPHP($dateFrom),
                'date_to' => Helpers_DateTime::getDateFormatPHP($dateTo),
            )
        );
        $shopInvoiceIDs = Request_Request::findBranch('DB_Ab1_Shop_Invoice',
            array(), $sitePageData, $driver, $params, 0, TRUE,
            array(
                'shop_client_id' => array('name', 'old_id', 'bin', 'address', 'account', 'bik'),
                'shop_client_contract_id' => array('number', 'from_at'),
                'shop_client_attorney_id' => array('number', 'from_at', 'client_name'),
                'shop_id' => array('old_id', 'name'),
                'check_type_id' => array('old_id', 'name'),
                'shop_client_id.organization_type_id' => array('old_id'),
            )
        );

        $data = '<?xml version="1.0" encoding="UTF-8"?><Data1C>';
        foreach($shopInvoiceIDs->childs as $shopInvoiceID){
            $data .= '<Invoice>'
                .'<id>М'.$shopInvoiceID->values['id'].'</id>'
                .'<NumDoc>М'.$shopInvoiceID->values['number'].'</NumDoc>'
                .'<type_of_doc>'.$shopInvoiceID->values['product_type_id'].'</type_of_doc>'
                .'<is_delivery>'.$shopInvoiceID->values['is_delivery'].'</is_delivery>'
                .'<is_control>'.($shopInvoiceID->getElementValue('check_type_id', 'old_id') == 2).'</is_control>'
                .'<is_cash>'.((intval($shopInvoiceID->values['shop_client_attorney_id'] < 1))).'</is_cash>'
                .'<check_type>'.$shopInvoiceID->getElementValue('check_type_id', 'old_id').'</check_type>'
                .'<check_type_name>'.htmlspecialchars($shopInvoiceID->getElementValue('check_type_id', 'name')).'</check_type_name>'
                .'<branch>'.$shopInvoiceID->getElementValue('shop_id', 'old_id').'</branch>'
                .'<branch_name>'.$shopInvoiceID->getElementValue('shop_id', 'name').'</branch_name>'
                .'<date>'.Helpers_DateTime::getDateTimeFormatRusAndSecond($shopInvoiceID->values['date']).'</date>'
                .'<IdKlient>'.$shopInvoiceID->getElementValue('shop_client_id', 'old_id').'</IdKlient>'
                .'<Company>'.htmlspecialchars($shopInvoiceID->getElementValue('shop_client_id', 'name'), ENT_XML1).'</Company>'
                .'<BIN>'.htmlspecialchars($shopInvoiceID->getElementValue('shop_client_id', 'bin'), ENT_XML1).'</BIN>'
                .'<address>'.htmlspecialchars($shopInvoiceID->getElementValue('shop_client_id', 'address'), ENT_XML1).'</address>'
                .'<account>'.htmlspecialchars($shopInvoiceID->getElementValue('shop_client_id', 'account'), ENT_XML1).'</account>'
                .'<bank>'.htmlspecialchars($shopInvoiceID->getElementValue('shop_client_id', 'bik'), ENT_XML1).'</bank>'
                .'<organization_type>'.htmlspecialchars($shopInvoiceID->getElementValue('organization_type_id', 'old_id'), ENT_XML1).'</organization_type>'
                .'<contract_id>'.$shopInvoiceID->values['shop_client_contract_id'].'</contract_id>'
                .'<contract_number>'.htmlspecialchars(str_replace(' ', '', $shopInvoiceID->getElementValue('shop_client_contract_id', 'number')), ENT_XML1).'</contract_number>'
                .'<contract_date>'.Helpers_DateTime::getDateFormatRus($shopInvoiceID->getElementValue('shop_client_contract_id', 'from_at')).'</contract_date>'
                .'<attorney_number>'.htmlspecialchars($shopInvoiceID->getElementValue('shop_client_attorney_id', 'number'), ENT_XML1).'</attorney_number>'
                .'<attorney_date>'.Helpers_DateTime::getDateFormatRus($shopInvoiceID->getElementValue('shop_client_attorney_id', 'from_at')).'</attorney_date>'
                .'<attorney_client>'.htmlspecialchars($shopInvoiceID->getElementValue('shop_client_attorney_id', 'client_name'), ENT_XML1).'</attorney_client>';

            // получаем список строк накладной
            $params = Request_RequestParams::setParams(
                array(
                    'shop_invoice_id' => $shopInvoiceID->id,
                    'group_by' => array(
                        'shop_product_id', 'shop_product_id.old_id',
                        'shop_subdivision_id', 'shop_subdivision_id.old_id',
                        'price',
                    ),
                    'sum_quantity' => TRUE,
                )
            );
            $shopCatItemIDs = Request_Request::find('DB_Ab1_Shop_Car_Item',
                $shopInvoiceID->values['shop_id'], $sitePageData, $driver, $params, 0, TRUE,
                array('shop_product_id' => array('old_id'), 'shop_subdivision_id' => array('old_id'))
            );
            $shopPieceItemIDs = Request_Request::find('DB_Ab1_Shop_Piece_Item',
                $shopInvoiceID->values['shop_id'], $sitePageData, $driver, $params, 0, TRUE,
                array('shop_product_id' => array('old_id'), 'shop_subdivision_id' => array('old_id'))
            );

            // группируем по продукции и ценам
            $shopProductIDs = array();
            foreach ($shopCatItemIDs->childs as $child){
                $shopProductID = $child->values['shop_product_id'] . '_' . $child->values['price']
                    . '_' . $child->getElementValue('shop_subdivision_id', 'old_id');
                if(!key_exists($shopProductID, $shopProductIDs)) {
                    $shopProductIDs[$shopProductID] = array(
                        'old_id' => $child->getElementValue('shop_product_id', 'old_id'),
                        'quantity' => $child->values['quantity'],
                        'price' => $child->values['price'],
                        'shop_subdivision' => $child->getElementValue('shop_subdivision_id', 'old_id'),
                    );
                }else{
                    $shopProductIDs[$shopProductID]['quantity'] += $child->values['quantity'];
                }
            }
            foreach ($shopPieceItemIDs->childs as $child){
                $shopProductID = $child->values['shop_product_id'] . '_' . $child->values['price']
                    . '_' . $child->getElementValue('shop_subdivision_id', 'old_id');
                if(!key_exists($shopProductID, $shopProductIDs)) {
                    $shopProductIDs[$shopProductID] = array(
                        'old_id' => $child->getElementValue('shop_product_id', 'old_id'),
                        'quantity' => $child->values['quantity'],
                        'price' => $child->values['price'],
                        'shop_subdivision' => $child->getElementValue('shop_subdivision_id', 'old_id'),
                    );
                }else{
                    $shopProductIDs[$shopProductID]['quantity'] += $child->values['quantity'];
                }
            }

            $data .='<items>';
            foreach ($shopProductIDs as $child){
                $data .= '<goods>'
                    .'<idGoods>'.$child['old_id'].'</idGoods>'
                    .'<quantity>'.$child['quantity'].'</quantity>'
                    .'<price>'.$child['price'].'</price>'
                    .'<amount>'.($child['quantity'] * $child['price']).'</amount>'
                    .'<amount_nds>'.(round($child['quantity'] * $child['price'] / 112 * 12, 2)).'</amount_nds>'
                    .'<storage>'.$child['shop_subdivision'].'</storage>'
                .'</goods>';
            }
            $data .='</items>';

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