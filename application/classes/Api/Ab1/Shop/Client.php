<?php defined('SYSPATH') or die('No direct script access.');

class Api_Ab1_Shop_Client  {
    /**
     * @param Model_Ab1_Shop_Car | Model_Ab1_Shop_Piece $model
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @param int | null $shopClientID
     */
    public function recountBalanceObject($model, SitePageData $sitePageData,
                                         Model_Driver_DBBasicDriver $driver, $shopClientID = null)
    {
        if(empty($model)){
            $date = Helpers_DateTime::getYearBeginStr(date('Y'));
        }else{
            $date = Helpers_DateTime::getYearBeginStr(Helpers_DateTime::getYear($model->getCreatedAt()));
        }

        if($shopClientID > 0){
            // обновляем заблокированные суммы клиента
            Api_Ab1_Shop_Client::recountBalanceAll(
                $shopClientID, $sitePageData, $driver, $date
            );
        }

        if(!empty($model) && $shopClientID != $model->getShopClientID()){
            // обновляем заблокированные суммы клиента
            Api_Ab1_Shop_Client::recountBalanceAll(
                $model->getShopClientID(), $sitePageData, $driver, $date,
                $model->getValue('shop_client_contract_id', null),
                $model->getValue('shop_client_attorney_id', null)
            );
        }

        if(!empty($model) && $shopClientID != $model->getOriginalValue('shop_client_id')){
            // обновляем заблокированные суммы клиента
            Api_Ab1_Shop_Client::recountBalanceAll(
                $model->getShopClientID(), $sitePageData, $driver, $date,
                $model->getOriginalValue('shop_client_contract_id', null),
                $model->getOriginalValue('shop_client_attorney_id', null)
            );
        }

        /*
        // пересчитываем баланс договоров
        Api_Ab1_Shop_Client_Contract::calcBalancesBlock($shopClientContractIDs, $sitePageData, $driver);
        // пересчитываем баланс прайс-листов
        Api_Ab1_Shop_Product_Price::calcBalancesBlock($shopProductPriceIDs, $sitePageData, $driver);
        // пересчитываем баланс доверенностей
        Api_Ab1_Shop_Client_Attorney::calcBalancesBlock(
            $shopCarItemIDs->getChildArrayInt('shop_client_attorney_id', TRUE),
            $sitePageData, $driver
        );

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
        */
    }

    /**
     * Пересчитать баланс клиента со всеми доверенностями и договорами
     * @param $shopClientID
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @param null $date
     * @param null $shopClientContractID
     * @param null $shopClientAttorneyID
     * @throws HTTP_Exception_500
     */
    public function recountBalanceAll($shopClientID, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver,
                                      $date = null, $shopClientContractID = null, $shopClientAttorneyID = null)
    {
        if($shopClientID < 1){
            return;
        }
        $fromAt = Helpers_DateTime::moreDates(Api_Ab1_Basic::getDateFromBalance1С(), $date);

        $model = new Model_Ab1_Shop_Client();
        $model->setDBDriver($driver);

        if (!Helpers_DB::getDBObject($model, $shopClientID, $sitePageData, $sitePageData->shopMainID)) {
            throw new HTTP_Exception_500('Client id="' . $shopClientID . '" not found. #02022020');
        }

        Api_Ab1_Shop_Client::calcBalanceBlock(
            $shopClientID, $sitePageData, $driver
        );
        Api_Ab1_Shop_Client::calcBalanceActRevive(
            $shopClientID, $sitePageData, $driver
        );
        Api_Ab1_Shop_Client::calcBalanceCash(
            $shopClientID, $sitePageData, $driver
        );

        $shopClientAttorneyIDs = Request_Request::findBranch('DB_Ab1_Shop_Client_Attorney',
            array(), $sitePageData, $driver,
            Request_RequestParams::setParams(
                array(
                    'shop_client_id' => $shopClientID,
                    'id' => $shopClientAttorneyID,
                    'from_at_from' => $fromAt,
                )
            )
        );
        foreach ($shopClientAttorneyIDs->childs as $shopClientAttorneyID){
            Api_Ab1_Shop_Client_Attorney::calcBalanceBlock(
                $shopClientAttorneyID->id, $sitePageData, $driver, true,
                $shopClientAttorneyID->values['shop_id']
            );
            Api_Ab1_Shop_Client_Attorney::calcDeliveryBalanceBlock(
                $shopClientAttorneyID->id, $sitePageData, $driver, true,
                $shopClientAttorneyID->values['shop_id']
            );
        }

        $shopClientContractIDs = Request_Request::find('DB_Ab1_Shop_Client_Contract',
            $sitePageData->shopMainID, $sitePageData, $driver,
            Request_RequestParams::setParams(
                array(
                    'shop_client_id' => $shopClientID,
                    'id' => $shopClientContractID,
                    'from_at_from' => $fromAt,
                )
            )
        );
        foreach ($shopClientContractIDs->childs as $shopClientContractID){
            Api_Ab1_Shop_Client_Contract::calcBalanceBlock(
                $shopClientContractID->id, $sitePageData, $driver
            );
        }

        $shopProductPriceIDs = Request_Request::findBranch('DB_Ab1_Shop_Product_Price',
            array(), $sitePageData, $driver,
            Request_RequestParams::setParams(
                array(
                    'shop_client_id' => $shopClientID,
                )
            )
        );
        foreach ($shopProductPriceIDs->childs as $shopProductPriceID){
            Api_Ab1_Shop_Product_Price::calcBalanceBlock(
                $shopProductPriceID->id, $sitePageData, $driver
            );
        }
    }

    /**
     * Пересчитать баланс клиента, доверенности, договора
     * @param $shopClientID
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @param int $shopClientAttorneyID
     * @param int $shopClientContractID
     * @return bool
     */
    public static function recountBalance($shopClientID, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver,
                                          $shopClientAttorneyID = 0, $shopClientContractID = 0)
    {
        $shopClientID = intval($shopClientID);
        if($shopClientID < 1){
            return FALSE;
        }

        // обновляем заблокированные суммы клиента
        Api_Ab1_Shop_Client::calcBalanceBlock($shopClientID, $sitePageData, $driver);

        // обновляем заблокированные суммы наличных клиента
        if($shopClientAttorneyID < 1) {
            Api_Ab1_Shop_Client::calcBalanceCash($shopClientID, $sitePageData, $driver);
        }

        // обновляем заблокированные суммы доверенностей
        Api_Ab1_Shop_Client_Attorney::calcBalanceBlock($shopClientAttorneyID, $sitePageData, $driver);

        // пересчитываем балансы договора
        if ($shopClientContractID > 0) {
            Api_Ab1_Shop_Client_Contract::calcBalanceBlock($shopClientContractID, $sitePageData, $driver);
        }

        return true;
    }


    /**
     * Просчет заблокированного баланса клиента
     * @param $shopClientID
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @param bool $isSaveAmount
     * @return bool|int
     * @throws HTTP_Exception_500
     */
    public static function calcBalanceBlock($shopClientID, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver,
                                            $isSaveAmount = TRUE)
    {
        $shopClientID = intval($shopClientID);
        if($shopClientID < 1){
            return FALSE;
        }

        $amountCash = 0;
        $dateFrom1C = Api_Ab1_Basic::getDateFromBalance1С();

        /** Считаем наличные деньги **/
        $params = Request_RequestParams::setParams(
            array(
                'exit_at_from_or_not_exit' => $dateFrom1C,
                'shop_client_id' => $shopClientID,
                'shop_car_id.shop_client_id' => $shopClientID,
                'shop_client_attorney_id' => 0,
                'sum_amount' => TRUE,
            )
        );
        // реализация
        $ids = Request_Request::findBranch('DB_Ab1_Shop_Car_Item',
            array(), $sitePageData, $driver, $params
        );
        if(count($ids->childs) > 0){
            $amountCash += $ids->childs[0]->values['amount'];
        }

        // штучный товар
        $ids = Request_Request::findBranch('DB_Ab1_Shop_Piece_Item',
            array(), $sitePageData, $driver, $params
        );
        if(count($ids->childs) > 0){
            $amountCash += $ids->childs[0]->values['amount'];
        }

        // дополнительные услуги
        $ids = Request_Request::findBranch('DB_Ab1_Shop_Addition_Service_Item',
            array(), $sitePageData, $driver, $params
        );
        if(count($ids->childs) > 0){
            $amountCash += $ids->childs[0]->values['amount'];
        }

        /** Доставка за наличные **/
        $params = Request_RequestParams::setParams(
            array(
                'exit_at_from_or_not_exit' => $dateFrom1C,
                'shop_client_id' => $shopClientID,
                'delivery_shop_client_attorney_id' => 0,
                'sum_delivery_amount' => TRUE,
            )
        );
        // реализация
        $ids = Request_Request::findBranch('DB_Ab1_Shop_Car',
            array(), $sitePageData, $driver, $params
        );
        if(count($ids->childs) > 0){
            $amountCash += $ids->childs[0]->values['delivery_amount'];
        }

        // штучный товар
        $ids = Request_Request::findBranch('DB_Ab1_Shop_Piece',
            array(), $sitePageData, $driver, $params
        );
        if(count($ids->childs) > 0){
            $amountCash += $ids->childs[0]->values['delivery_amount'];
        }

        /** Считаем безналичный баланс **/
        $amount = 0;
        $params = Request_RequestParams::setParams(
            array(
                'exit_at_from_or_not_exit' => $dateFrom1C,
                'shop_client_id' => $shopClientID,
                'shop_car_id.shop_client_id' => $shopClientID,
                'shop_client_attorney_id_from' => 0,
                'sum_amount' => TRUE,
                'sum_delivery_amount' => TRUE,
            )
        );
        // реализация
        $ids = Request_Request::findBranch('DB_Ab1_Shop_Car_Item',
            array(), $sitePageData, $driver, $params
        );
        if(count($ids->childs) > 0){
            $amount += $ids->childs[0]->values['amount'];
        }

        // штучный товар
        $ids = Request_Request::findBranch('DB_Ab1_Shop_Piece_Item',
            array(), $sitePageData, $driver, $params
        );
        if(count($ids->childs) > 0){
            $amount += $ids->childs[0]->values['amount'];
        }

        // дополнительные услуги
        $ids = Request_Request::findBranch('DB_Ab1_Shop_Addition_Service_Item',
            array(), $sitePageData, $driver, $params
        );
        if(count($ids->childs) > 0){
            $amount += $ids->childs[0]->values['amount'];
        }

        /** Доставка **/
        $params = Request_RequestParams::setParams(
            array(
                'exit_at_from_or_not_exit' => $dateFrom1C,
                'shop_client_id' => $shopClientID,
                'delivery_shop_client_attorney_id_from' => 0,
                'sum_delivery_amount' => TRUE,
            )
        );
        // реализация
        $ids = Request_Request::findBranch('DB_Ab1_Shop_Car',
            array(), $sitePageData, $driver, $params
        );
        if(count($ids->childs) > 0){
            $amount += $ids->childs[0]->values['delivery_amount'];
        }

        // штучный товар
        $ids = Request_Request::findBranch('DB_Ab1_Shop_Piece',
            array(), $sitePageData, $driver, $params
        );
        if(count($ids->childs) > 0){
            $amount += $ids->childs[0]->values['delivery_amount'];
        }

        if($isSaveAmount) {
            $model = new Model_Ab1_Shop_Client();
            $model->setDBDriver($driver);

            if (!Helpers_DB::dublicateObjectLanguage($model, $shopClientID, $sitePageData, $sitePageData->shopMainID)) {
                throw new HTTP_Exception_500('Client not found. #1');
            }

            $model->setBlockAmountCash($amountCash);
            $model->setBlockAmount($amount);
            $model->setAmount(0);
            Helpers_DB::saveDBObject($model, $sitePageData, $sitePageData->shopMainID);
        }

        return array(
            'amount' => $amount,
            'amount_cash' => $amountCash,
        );
    }

    /**
     *  Просчет заблокированного баланса клиентов
     * @param array $shopClientIDs
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     */
    public static function calcBalancesBlock(array $shopClientIDs, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        foreach ($shopClientIDs as $child){
            self::calcBalanceBlock(floatval($child), $sitePageData, $driver);
        }
    }

    /**
     * Просчет баланса актов сверок клиента
     * @param $shopClientID
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @param bool $isSaveAmount
     * @param string | null $dateTo
     * @return bool|int
     * @throws HTTP_Exception_500
     */
    public static function calcBalanceActRevive($shopClientID, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver,
                                            $isSaveAmount = TRUE, $dateTo = null)
    {
        if($shopClientID < 1){
            return FALSE;
        }
        /** Считаем наличные деньги **/
        $params = Request_RequestParams::setParams(
            array(
                'date_from' => Api_Ab1_Basic::getDateFromBalance1С(),
                'shop_client_id' => $shopClientID,
                'date_to' => $dateTo,
                'sum_amount' => TRUE,
                'group_by' => array(
                    'is_cache', 'is_receive',
                )
            )
        );
        // оплата
        $ids = Request_Request::findBranch('DB_Ab1_Shop_Act_Revise_Item',
            array(), $sitePageData, $driver, $params
        );

        $amountCash = 0;
        $amount = 0;
        foreach ($ids->childs as $child){
            $amountChild = $child->values['amount'];
            if($child->values['is_receive'] == 0){
                $amountChild = $amountChild * (-1);
            }

            if($child->values['is_cache'] == 1){
                $amountCash += $amountChild;
            }else {
                $amount += $amountChild;
            }
        }

        if($isSaveAmount) {
            $model = new Model_Ab1_Shop_Client();
            $model->setDBDriver($driver);

            if (!Helpers_DB::dublicateObjectLanguage($model, $shopClientID, $sitePageData, $sitePageData->shopMainID)) {
                throw new HTTP_Exception_500('Client not found. #2');
            }

            $model->setAmountActReviseCash($amountCash);
            $model->setAmountActRevise($amount);
            Helpers_DB::saveDBObject($model, $sitePageData, $sitePageData->shopMainID);
        }

        return array(
            'amount' => $amount,
            'amount_cash' => $amountCash,
        );
    }

    /**
     * Просчет актов сверок клиентов
     * @param array $shopClientIDs
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     */
    public static function calcBalancesActRevive(array $shopClientIDs, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        foreach ($shopClientIDs as $child){
            self::calcBalanceActRevive(floatval($child), $sitePageData, $driver);
        }
    }

    /**
     * Просчет баланса наличных клиента
     * @param $shopClientID
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @param bool $isSaveAmount
     * @param string | null $dateTo
     * @return bool|int
     * @throws HTTP_Exception_500
     */
    public static function calcBalanceCash($shopClientID, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver,
                                           $isSaveAmount = TRUE, $dateTo = null)
    {
        if($shopClientID < 1){
            return FALSE;
        }

        $amountCash = 0;

        /** Считаем наличные деньги **/
        $params = Request_RequestParams::setParams(
            array(
                'created_at_from' => Api_Ab1_Basic::getDateFromBalance1С(),
                'shop_client_id' => $shopClientID,
                'created_at_to' => $dateTo,
                'sum_amount' => TRUE,
            )
        );
        // оплата
        $ids = Request_Request::findBranch('DB_Ab1_Shop_Payment',
            array(), $sitePageData, $driver, $params
        );
        if(count($ids->childs) > 0){
            $amountCash += $ids->childs[0]->values['amount'];
        }
        // возврат
        $ids = Request_Request::findBranch('DB_Ab1_Shop_Payment_Return',
            array(), $sitePageData, $driver, $params
        );
        if(count($ids->childs) > 0){
            $amountCash -= $ids->childs[0]->values['amount'];
        }

        if($isSaveAmount) {
            $model = new Model_Ab1_Shop_Client();
            $model->setDBDriver($driver);

            if (!Helpers_DB::dublicateObjectLanguage($model, $shopClientID, $sitePageData, $sitePageData->shopMainID)) {
                throw new HTTP_Exception_500('Client not found. #2');
            }

            $model->setAmountCash($amountCash);
            Helpers_DB::saveDBObject($model, $sitePageData, $sitePageData->shopMainID);
        }

        return $amountCash;
    }

    /**
     * Просчет задолжностей клиентов на текущую дату
     * @param $date
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @param null $shopClientID
     * @param null $addFields
     * @return MyArray
     */
    public static function calcBalanceClientsOnDate($date, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver,
                                                    $shopClientID = null, $addFields = null)
    {
        $shopClientIDs = new MyArray();
        $dateFrom1C = Api_Ab1_Basic::getDateFromBalance1С();

        $date = Helpers_DateTime::getDateFormatPHP($date);
        $dateH6 = $date . ' 06:00:00';

        /** Считаем реализации / штучный товар деньги **/
        // реализация
        $params = Request_RequestParams::setParams(
            array(
                'shop_car_id.created_at_from' => $dateFrom1C,
                'shop_car_id.created_at_to' => $dateH6,
                'shop_car_id.shop_client_id' => $shopClientID,
                'sum_amount' => TRUE,
                'group_by' => array(
                    'shop_client_attorney_id', 'shop_client_id',
                    'shop_client_id.name', 'shop_client_id.old_id', 'shop_client_id.is_buyer',
                    'shop_client_id.amount_1c', 'shop_client_id.amount_cash_1c',
                )
            )
        );
        $ids = Request_Request::findBranch('DB_Ab1_Shop_Car_Item',
            array(), $sitePageData, $driver, $params, 0, TRUE,
            array('shop_client_id' => array('name', 'old_id', 'amount_1c', 'amount_cash_1c', 'is_buyer'))
        );

        // штучный товар
        $params = Request_RequestParams::setParams(
            array(
                'shop_piece_id.created_at_from' => $dateFrom1C,
                'shop_piece_id.created_at_to' => $dateH6,
                'shop_piece_id.shop_client_id' => $shopClientID,
                'sum_amount' => TRUE,
                'group_by' => array(
                    'shop_client_attorney_id', 'shop_client_id',
                    'shop_client_id.name', 'shop_client_id.old_id', 'shop_client_id.is_buyer',
                    'shop_client_id.amount_1c', 'shop_client_id.amount_cash_1c',
                )
            )
        );
        $pieceIDs = Request_Request::findBranch('DB_Ab1_Shop_Piece_Item',
            array(), $sitePageData, $driver, $params, 0, TRUE,
            array('shop_client_id' => array('name', 'old_id', 'amount_1c', 'amount_cash_1c'))
        );
        $ids->addChilds($pieceIDs);

        // дополнительные услуги реализации
        $params = Request_RequestParams::setParams(
            array(
                'shop_car_id.created_at_from' => $dateFrom1C,
                'shop_car_id.created_at_to' => $dateH6,
                'shop_car_id.shop_client_id' => $shopClientID,
                'shop_car_id_from' => 0,
                'sum_amount' => TRUE,
                'group_by' => array(
                    'shop_client_attorney_id', 'shop_client_id',
                    'shop_client_id.name', 'shop_client_id.old_id', 'shop_client_id.is_buyer',
                    'shop_client_id.amount_1c', 'shop_client_id.amount_cash_1c',
                )
            )
        );
        $additionServices = Request_Request::findBranch(DB_Ab1_Shop_Addition_Service_Item::NAME,
            array(), $sitePageData, $driver, $params, 0, TRUE,
            array('shop_client_id' => array('name', 'old_id', 'amount_1c', 'amount_cash_1c', 'is_buyer'))
        );
        $ids->addChilds($additionServices);

        // дополнительные услуги штучного товара
        $params = Request_RequestParams::setParams(
            array(
                'shop_piece_id.created_at_from' => $dateFrom1C,
                'shop_piece_id.created_at_to' => $dateH6,
                'shop_piece_id.shop_client_id' => $shopClientID,
                'shop_piece_id_from' => 0,
                'sum_amount' => TRUE,
                'group_by' => array(
                    'shop_client_attorney_id', 'shop_client_id',
                    'shop_client_id.name', 'shop_client_id.old_id', 'shop_client_id.is_buyer',
                    'shop_client_id.amount_1c', 'shop_client_id.amount_cash_1c',
                )
            )
        );
        $additionServices = Request_Request::findBranch(DB_Ab1_Shop_Addition_Service_Item::NAME,
            array(), $sitePageData, $driver, $params, 0, TRUE,
            array('shop_client_id' => array('name', 'old_id', 'amount_1c', 'amount_cash_1c', 'is_buyer'))
        );
        $ids->addChilds($additionServices);

        foreach ($ids->childs as $child){
            $client = $child->values['shop_client_id'];
            if(!key_exists($client, $shopClientIDs->childs)){
                $tmp = new MyArray();
                $tmp->id = $client;
                $tmp->values = [
                    'id' => $client,
                    'name' => $child->getElementValue('shop_client_id'),
                    'old_id' => $child->getElementValue('shop_client_id', 'old_id'),
                    'is_buyer' => $child->getElementValue('shop_client_id', 'is_buyer'),
                    'amount_1c' => $child->getElementValue('shop_client_id', 'amount_1c'),
                    'amount_cash_1c' => $child->getElementValue('shop_client_id', 'amount_cash_1c'),
                    'amount_cash' => 0,
                    'amount' => 0,
                    'block_amount_cash' => 0,
                    'block_amount' => 0,
                    'amount_act_revise_cash' => 0,
                    'amount_act_revise' => 0,
                ];
                $tmp->values['balance_cache'] = $tmp->values['amount_cash_1c'];
                $tmp->values['balance'] = $tmp->values['amount_1c'];

                $shopClientIDs->childs[$client] = $tmp;
            }

            $amount = $child->values['amount'];
            if($child->values['shop_client_attorney_id'] < 1){
                $shopClientIDs->childs[$client]->values['block_amount_cash'] += $amount;
                $shopClientIDs->childs[$client]->values['balance_cache'] -= $amount;
            }else{
                $shopClientIDs->childs[$client]->values['block_amount'] += $amount;
            }

            $shopClientIDs->childs[$client]->values['balance'] -= $amount;
        }

        /** Считаем доставки денег **/
        $params = Request_RequestParams::setParams(
            array(
                'created_at_from' => $dateFrom1C,
                'created_at_to' => $dateH6,
                'shop_delivery_id_from' => 0,
                'sum_delivery_amount' => TRUE,
                'shop_client_id' => $shopClientID,
                'group_by' => array(
                    'delivery_shop_client_attorney_id', 'shop_client_id',
                    'shop_client_id.name', 'shop_client_id.old_id', 'shop_client_id.is_buyer',
                    'shop_client_id.amount_1c', 'shop_client_id.amount_cash_1c',
                )
            )
        );
        // реализация
        $ids = Request_Request::findBranch('DB_Ab1_Shop_Car',
            array(), $sitePageData, $driver, $params, 0, TRUE,
            array('shop_client_id' => array('name', 'old_id', 'amount_1c', 'amount_cash_1c', 'is_buyer'))
        );

        // штучный товар
        $pieceIDs = Request_Request::findBranch('DB_Ab1_Shop_Piece',
            array(), $sitePageData, $driver, $params, 0, TRUE,
            array('shop_client_id' => array('name', 'old_id', 'amount_1c', 'amount_cash_1c'))
        );
        $ids->addChilds($pieceIDs);

        foreach ($ids->childs as $child){
            $client = $child->values['shop_client_id'];
            if(!key_exists($client, $shopClientIDs->childs)){
                $tmp = new MyArray();
                $tmp->id = $client;
                $tmp->values = [
                    'id' => $client,
                    'name' => $child->getElementValue('shop_client_id'),
                    'old_id' => $child->getElementValue('shop_client_id', 'old_id'),
                    'is_buyer' => $child->getElementValue('shop_client_id', 'is_buyer'),
                    'amount_1c' => $child->getElementValue('shop_client_id', 'amount_1c'),
                    'amount_cash_1c' => $child->getElementValue('shop_client_id', 'amount_cash_1c'),
                    'amount_cash' => 0,
                    'amount' => 0,
                    'block_amount_cash' => 0,
                    'block_amount' => 0,
                    'amount_act_revise_cash' => 0,
                    'amount_act_revise' => 0,
                ];
                $tmp->values['balance_cache'] = $tmp->values['amount_cash_1c'];
                $tmp->values['balance'] = $tmp->values['amount_1c'];

                $shopClientIDs->childs[$client] = $tmp;
            }

            $amount = $child->values['delivery_amount'];
            if($child->values['delivery_shop_client_attorney_id'] < 1){
                $shopClientIDs->childs[$client]->values['block_amount_cash'] += $amount;
                $shopClientIDs->childs[$client]->values['balance_cache'] -= $amount;
            }else{
                $shopClientIDs->childs[$client]->values['block_amount'] += $amount;
            }

            $shopClientIDs->childs[$client]->values['balance'] -= $amount;
        }

        /** Считаем пополение / возврат наличных денег **/
        $params = Request_RequestParams::setParams(
            array(
                'created_at_from' => Api_Ab1_Basic::getDateFromBalance1С(),
                'created_at_to' => $dateH6,
                'sum_amount' => TRUE,
                'shop_client_id' => $shopClientID,
                'group_by' => array(
                    'shop_client_attorney_id', 'shop_client_id',
                    'shop_client_id.name', 'shop_client_id.old_id', 'shop_client_id.is_buyer',
                    'shop_client_id.amount_1c', 'shop_client_id.amount_cash_1c',
                )
            )
        );
        // оплата
        $ids = Request_Request::findBranch('DB_Ab1_Shop_Payment',
            array(), $sitePageData, $driver, $params, 0, TRUE,
            array('shop_client_id' => array('name', 'old_id', 'amount_1c', 'amount_cash_1c', 'is_buyer'))
        );
        foreach ($ids->childs as $child){
            $client = $child->values['shop_client_id'];
            if(!key_exists($client, $shopClientIDs->childs)){
                $tmp = new MyArray();
                $tmp->id = $client;
                $tmp->values = [
                    'id' => $client,
                    'name' => $child->getElementValue('shop_client_id'),
                    'old_id' => $child->getElementValue('shop_client_id', 'old_id'),
                    'is_buyer' => $child->getElementValue('shop_client_id', 'is_buyer'),
                    'amount_1c' => $child->getElementValue('shop_client_id', 'amount_1c'),
                    'amount_cash_1c' => $child->getElementValue('shop_client_id', 'amount_cash_1c'),
                    'amount_cash' => 0,
                    'amount' => 0,
                    'block_amount_cash' => 0,
                    'block_amount' => 0,
                    'amount_act_revise_cash' => 0,
                    'amount_act_revise' => 0,
                ];
                $tmp->values['balance_cache'] = $tmp->values['amount_cash_1c'];
                $tmp->values['balance'] = $tmp->values['amount_1c'];

                $shopClientIDs->childs[$client] = $tmp;
            }

            $amount = $child->values['amount'];
            $shopClientIDs->childs[$client]->values['amount_cash'] += $amount;
            $shopClientIDs->childs[$client]->values['balance_cache'] += $amount;

            $shopClientIDs->childs[$client]->values['balance'] += $amount;
        }

        // возвраты
        $ids = Request_Request::findBranch('DB_Ab1_Shop_Payment_Return',
            array(), $sitePageData, $driver, $params, 0, TRUE,
            array('shop_client_id' => array('name', 'old_id', 'amount_1c', 'amount_cash_1c', 'is_buyer'))
        );
        foreach ($ids->childs as $child){
            $client = $child->values['shop_client_id'];
            if(!key_exists($client, $shopClientIDs->childs)){
                $tmp = new MyArray();
                $tmp->id = $client;
                $tmp->values = [
                    'id' => $client,
                    'name' => $child->getElementValue('shop_client_id'),
                    'old_id' => $child->getElementValue('shop_client_id', 'old_id'),
                    'is_buyer' => $child->getElementValue('shop_client_id', 'is_buyer'),
                    'amount_1c' => $child->getElementValue('shop_client_id', 'amount_1c'),
                    'amount_cash_1c' => $child->getElementValue('shop_client_id', 'amount_cash_1c'),
                    'amount_cash' => 0,
                    'amount' => 0,
                    'block_amount_cash' => 0,
                    'block_amount' => 0,
                    'amount_act_revise_cash' => 0,
                    'amount_act_revise' => 0,
                ];
                $tmp->values['balance_cache'] = $tmp->values['amount_cash_1c'];
                $tmp->values['balance'] = $tmp->values['amount_1c'];

                $shopClientIDs->childs[$client] = $tmp;
            }

            $amount = $child->values['amount'];
            $shopClientIDs->childs[$client]->values['amount_cash'] -= $amount;
            $shopClientIDs->childs[$client]->values['balance_cache'] -= $amount;

            $shopClientIDs->childs[$client]->values['amount'] -= $amount;
            $shopClientIDs->childs[$client]->values['balance'] -= $amount;
        }

        /** Считаем акты сверок **/
        $params = Request_RequestParams::setParams(
            array(
                'date_from' => Helpers_DateTime::getDateFormatPHP($dateFrom1C),
                'date_to' => $date,
                'shop_client_id' => $shopClientID,
                'sum_amount' => TRUE,
                'group_by' => array(
                    'is_cache', 'is_receive', 'shop_client_id',
                    'shop_client_id.name', 'shop_client_id.old_id', 'shop_client_id.is_buyer',
                    'shop_client_id.amount_1c', 'shop_client_id.amount_cash_1c',
                )
            )
        );
        // акты сверок
        $ids = Request_Request::findBranch('DB_Ab1_Shop_Act_Revise_Item',
            array(), $sitePageData, $driver, $params, 0, TRUE,
            array('shop_client_id' => array('name', 'old_id', 'amount_1c', 'amount_cash_1c', 'is_buyer'))
        );

        foreach ($ids->childs as $child){
            $client = $child->values['shop_client_id'];

            if(!key_exists($client, $shopClientIDs->childs)){
                $tmp = new MyArray();
                $tmp->id = $client;
                $tmp->values = [
                    'id' => $client,
                    'name' => $child->getElementValue('shop_client_id'),
                    'old_id' => $child->getElementValue('shop_client_id', 'old_id'),
                    'is_buyer' => $child->getElementValue('shop_client_id', 'is_buyer'),
                    'amount_1c' => $child->getElementValue('shop_client_id', 'amount_1c'),
                    'amount_cash_1c' => $child->getElementValue('shop_client_id', 'amount_cash_1c'),
                    'amount_cash' => 0,
                    'amount' => 0,
                    'block_amount_cash' => 0,
                    'block_amount' => 0,
                    'amount_act_revise_cash' => 0,
                    'amount_act_revise' => 0,
                ];

                $tmp->values['balance_cache'] = $tmp->values['amount_cash_1c'];
                $tmp->values['balance'] = $tmp->values['amount_1c'];

                $shopClientIDs->childs[$client] = $tmp;
            }

            $amount = $child->values['amount'];
            if($child->values['is_receive'] == 0){
                $amount = $amount * (-1);
            }

            if($child->values['is_cache'] == 1){
                $shopClientIDs->childs[$client]->values['amount_act_revise_cash'] += $amount;
                $shopClientIDs->childs[$client]->values['balance_cache'] += $amount;
            }

            $shopClientIDs->childs[$client]->values['amount_act_revise'] += $amount;
            $shopClientIDs->childs[$client]->values['balance'] += $amount;
        }

        /** Балансы клиентов, которые не покупали до 01.01.2020 **/
        $params = Request_RequestParams::setParams(
            array(
                'amount_1c_not' => 0,
                'id' => $shopClientID,
            )
        );
        // Клиенты
        $ids = Request_Request::findBranch('DB_Ab1_Shop_Client', array(), $sitePageData, $driver, $params, 0, TRUE);

        foreach ($ids->childs as $child){
            $client = $child->values['id'];
            if(key_exists($client, $shopClientIDs->childs)){
                continue;
            }

            $tmp = new MyArray();
            $tmp->id = $client;
            $tmp->values = [
                'id' => $client,
                'name' => $child->values['name'],
                'old_id' => $child->values['old_id'],
                'is_buyer' => $child->values['is_buyer'],
                'amount_1c' => $child->values['amount_1c'],
                'amount_cash_1c' => $child->values['amount_cash_1c'],
                'amount_cash' => 0,
                'amount' => 0,
                'block_amount_cash' => 0,
                'block_amount' => 0,
                'amount_act_revise_cash' => 0,
                'amount_act_revise' => 0,
            ];

            $tmp->values['balance_cache'] = $tmp->values['amount_cash_1c'];
            $tmp->values['balance'] = $tmp->values['amount_1c'];
            $shopClientIDs->childs[$client] = $tmp;
        }

        if(is_array($addFields) && !empty($addFields) && count($shopClientIDs->childs) > 0){
            $shopClients = array_keys($shopClientIDs->childs);

            $ids = Request_Request::findBranch(
                'DB_Ab1_Shop_Client', array(), $sitePageData, $driver,
                Request_RequestParams::setParams(['id' => $shopClients]),
                0, TRUE
            );

            foreach ($ids->childs as $child){
                foreach ($addFields as $field){
                    $shopClientIDs->childs[$child->id]->values[$field] = $child->values[$field];
                }
            }
        }

        return $shopClientIDs;
    }

    /**
     * Просчет баланса клиента на заданную дату
     * @param int $shopClientID
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @param string | null $dateTo
     * @return array('balance_cache' => 0, 'balance' => 0,)
     * @throws HTTP_Exception_500
     */
    public static function calcBalance(int $shopClientID, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver,
                                       $dateTo = null)
    {
        $shopClientID = intval($shopClientID);
        if($shopClientID < 1) {
            return FALSE;
        }

        if($dateTo != null){
            $shopClient = self::calcBalanceClientsOnDate($dateTo, $sitePageData, $driver, $shopClientID);
            foreach ($shopClient->childs as $child){
                return array(
                    'balance_cache' => $child->values['balance_cache'],
                    'balance' => $child->values['balance'],
                );
            }

            return array(
                'balance_cache' => 0,
                'balance' => 0,
            );
        }

        $model = new Model_Ab1_Shop_Client();
        $model->setDBDriver($driver);
        if(Helpers_DB::getDBObject($model, $shopClientID, $sitePageData, $sitePageData->shopMainID)){
            return array(
                'balance_cache' => $model->getBalanceCache(),
                'balance' => $model->getBalance(),
            );
        }

        return array(
            'balance_cache' => 0,
            'balance' => 0,
        );
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

        $model = new Model_Ab1_Shop_Client();
        $model->setDBDriver($driver);

        if (!Helpers_DB::dublicateObjectLanguage($model, $id, $sitePageData, $sitePageData->shopMainID)) {
            throw new HTTP_Exception_500('Client not found. #3');
        }

        if(Request_RequestParams::getParamBoolean("is_undel") === TRUE){
            $model->dbUnDelete($sitePageData->userID, 0, $sitePageData->shopMainID);
        }else {
            $model->dbDelete($sitePageData->userID, 0, $sitePageData->shopMainID);
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
        $model = new Model_Ab1_Shop_Client();
        $model->setDBDriver($driver);

        $id = Request_RequestParams::getParamInt('id');
        if($id > 0) {
            if (!Helpers_DB::dublicateObjectLanguage($model, $id, $sitePageData, $sitePageData->shopMainID)) {
                throw new HTTP_Exception_500('Client not found. #4');
            }
        }

        Request_RequestParams::setParamInt("shop_table_rubric_id", $model);
        Request_RequestParams::setParamBoolean('is_public', $model);
        Request_RequestParams::setParamStr('text', $model);
        Request_RequestParams::setParamBoolean("is_buyer", $model);
        Request_RequestParams::setParamStr("old_id", $model);
        Request_RequestParams::setParamInt("shop_table_select_id", $model);
        Request_RequestParams::setParamInt("shop_table_unit_id", $model);
        Request_RequestParams::setParamInt("shop_table_brand_id", $model);
        Request_RequestParams::setParamInt("organization_type_id", $model);
        Request_RequestParams::setParamInt("kato_id", $model);
        Request_RequestParams::setParamInt("client_type_id", $model);

        Request_RequestParams::setParamStr('email', $model);
        Request_RequestParams::setParamStr('phones', $model);
        Request_RequestParams::setParamStr('bin', $model);
        Request_RequestParams::setParamStr('address', $model);
        Request_RequestParams::setParamStr('account', $model);
        Request_RequestParams::setParamStr('bank', $model);
        Request_RequestParams::setParamStr('bik', $model);
        Request_RequestParams::setParamFloat('amount', $model);
        Request_RequestParams::setParamStr('contract', $model);
        Request_RequestParams::setParamInt('shop_payment_type_id', $model);
        Request_RequestParams::setParamDateTime('power_of_attorney_from_at', $model);
        Request_RequestParams::setParamDateTime('power_of_attorney_to_at', $model);
        Request_RequestParams::setParamStr('director', $model);
        Request_RequestParams::setParamStr('charter', $model);
        Request_RequestParams::setParamBoolean("is_lawsuit", $model);
        Request_RequestParams::setParamStr('state_certificate', $model);

        Request_RequestParams::setParamStr('director_complete', $model);
        Request_RequestParams::setParamStr('name_complete', $model);
        Request_RequestParams::setParamStr('director_position', $model);

        Request_RequestParams::setParamStr('name', $model);
        Request_RequestParams::setParamStr('name_1c', $model);
        Request_RequestParams::setParamStr('name_site', $model);
        $model->setNames($model->getName());

        Request_RequestParams::setParamFloat("amount_1c", $model);
        Request_RequestParams::setParamFloat("amount_cash_1c", $model);
        Request_RequestParams::setParamStr('mobile', $model);

        // банк выбран из списка
        $bankID = Request_RequestParams::getParamInt('bank_id');
        if($bankID > 0){
            $modelBank = new Model_Bank();
            $modelBank->setDBDriver($driver);

            if (Helpers_DB::getDBObject($modelBank, $bankID, $sitePageData)) {
                $model->setBankID($bankID);
                $model->setBank($modelBank->getName());
                $model->setBIK($modelBank->getBIK());
            }
        }

        // счетчик как в 1с
        DB_Basic::setNumber1CIfEmpty($model, 'old_id', $sitePageData, $driver, $sitePageData->shopID);

        $options = Request_RequestParams::getParamArray('options');
        if ($options !== NULL) {
            $model->addOptionsArray($options);
        }

        $clientTypeIDs = Request_RequestParams::getParamArray('client_type_ids');
        if ($clientTypeIDs !== NULL) {
            $model->setClientTypeIDsArray($clientTypeIDs);
        }

        $result = array();
        if ($model->validationFields($result)) {
            if($model->id < 1) {
                Helpers_DB::saveDBObject($model, $sitePageData, $sitePageData->shopMainID);
            }

            // загружаем фотографии и файлы
            DB_Basic::saveFiles($model, $sitePageData, $driver);

            Helpers_DB::saveDBObject($model, $sitePageData, $sitePageData->shopMainID);
            $result['values'] = $model->getValues();
        }else{
            print_r($model->getValues());
        }

        return array(
            'id' => $model->id,
            'result' => $result,
        );
    }

    /**
     * Загрузить клиентов из XML
     * @param $fileName
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @param bool $isClearBlockAmount
     */
    public static function loadXMLALL($fileName, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver,
                                      $isClearBlockAmount = FALSE)
    {
        if ($isClearBlockAmount) {
            // обнуляем балансы клиентов
            $driver->sendSQL('UPDATE ab_shop_clients SET "block_amount" = 0, "block_amount_cash" = 0, "amount_1c" = 0, "amount_cash_1c" = 0, "amount" = 0, "amount_cash" = 0, "balance" = 0, "balance_cache" = 0;');

            // находим балансы клиентов, которые менялись с момента последней закрытия смены
            $clients = self::calcBalanceClientsOnDate(null, $sitePageData, $driver);

            foreach ($clients->childs as $child) {
                $driver->updateObjects(
                    Model_Ab1_Shop_Client::TABLE_NAME, array($child->id),
                    array(
                        'amount_cash' => $child->values['amount_cash'],
                        'amount' => $child->values['amount'],
                        'block_amount_cash' => $child->values['block_amount_cash'],
                        'block_amount' => $child->values['block_amount'],
                        'balance_cache' => $child->values['balance_cache'],
                        'balance' => $child->values['balance'],
                    )
                );
            }
        }

        $params = Request_RequestParams::setParams(
            array(
                'is_public_ignore' => TRUE,
            )
        );
        $clientIDs = Request_Request::find('DB_Ab1_Shop_Client',
            $sitePageData->shopMainID, $sitePageData, $driver,$params, 0, TRUE
        );
        $clientIDs->runIndex(true, 'old_id');

        $reader = new XMLReader();
        $reader->open($fileName);
        $xml = Helpers_XML::xmlReaderToArray($reader);

        $model = new Model_Ab1_Shop_Client();
        $model->setDBDriver($driver);

        $companies = Arr::path($xml, 'Data1C.Company', array());
        if(key_exists('Id', $companies)){
            $companies = array($companies);
        }
        foreach($companies as $company) {
            $clientID = trim(Arr::path($company, 'Id', ''));
            if(empty($clientID)){
                continue;
            }

            if(key_exists($clientID, $clientIDs->childs)){
                $clientIDs->childs[$clientID]->setModel($model);
            }else{
                $model->setOldID($clientID);
            }

            // название
            $model->setName1C(Arr::path($company, 'Name', $model->getName1C()));
            $model->setAddress(Arr::path($company, 'address', $model->getAddress()));
            $model->setBIN(Arr::path($company, 'BIN', $model->getBIN()));

            $model->setAmount1C(Arr::path($company, 'Balance', $model->getAmount1C()));
            $model->setAmountCash1C(Arr::path($company, 'BalanceCash', $model->getAmountCash1C()));

            Helpers_DB::saveDBObject($model, $sitePageData, $sitePageData->shopMainID);
        }
    }

    /**
     * Загрузить клиентов из XML
     * @param $fileName
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     */
    public static function loadXMLOne($fileName, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        $xml = simplexml_load_file($fileName);

        foreach($xml->Company as &$company) {
            self::_loadXMLClient($company, $sitePageData, $driver);
        }
    }

    /**
     * Из XML объекта загружем клиента
     * @param $company
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     */
    private static function _loadXMLClient(&$company, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver){
        $model = new Model_Ab1_Shop_Client();
        $model->setDBDriver($driver);

        $clientID = trim($company->Id);

        // находим клиентов в этим ID c 1C
        $params = Request_RequestParams::setParams(
            array(
                'is_public_ignore' => TRUE,
                'old_id' => $clientID,
            )
        );
        $clientIDs = Request_Request::find('DB_Ab1_Shop_Client',
            $sitePageData->shopMainID, $sitePageData, $driver, $params, 1, TRUE
        );

        if(count($clientIDs->childs) > 0) {
            $clientIDs->childs[0]->setModel($model);
        }else{
            $model->clear();
            $model->setOldID($clientID);
        }

        // название
        $model->setName1C($company->Name);
        $model->setAddress($company->address);
        $model->setBIN($company->BIN);

        $model->setAmount1C($company->Balance);

        if (Helpers_XML::isXMLField('BalanceCash', $company)) {
            $model->setAmountCash1C($company->BalanceCash);
        }
        Helpers_DB::saveDBObject($model, $sitePageData, $sitePageData->shopMainID);
    }

    /**
     * Загрузить клиентов из XML
     * @param $fileName
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     */
    public static function loadXMLData($fileName, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        $xml = simplexml_load_file($fileName);
        $company = $xml->ContractorParameter;

        $model = new Model_Ab1_Shop_Client();
        $model->setDBDriver($driver);

        $clientID = trim($company->contractorId);

        // находим клиентов в этим ID c 1C
        $params = Request_RequestParams::setParams(
            array(
                'is_public_ignore' => TRUE,
                'old_id' => $clientID,
            )
        );
        $clientIDs = Request_Request::find('DB_Ab1_Shop_Client',
            $sitePageData->shopMainID, $sitePageData, $driver, $params, 1, TRUE
        );

        if(count($clientIDs->childs) > 0) {
            $clientIDs->childs[0]->setModel($model);
        }else{
            $model->clear();
            $model->setOldID($clientID);
        }

        // название
        $model->setName1C(trim($company->Company));
        $model->setName(trim($company->name));
        $model->setAddress(trim($company->address));
        $model->setBIN(trim($company->BIN));

        $model->setAddress(trim($company->address));
        $model->setBIK(trim($company->BIC));

        if($model->isEditValue('bik')) {
            $model->setBankID(
                Request_Request::findIDByField(
                    DB_Bank::NAME, 'bik_full', $model->getBIK(), 0, $sitePageData, $driver
                )
            );
        }

        $model->setAccount(trim($company->Account));
        $model->setBank(trim($company->bank));
        $model->setEMail(trim($company->email));
        $model->setPhones(trim($company->phones));
        $model->setText(trim($company->text));
        $model->setContactPerson(trim($company->contact));


        Helpers_DB::saveDBObject($model, $sitePageData, $sitePageData->shopMainID);
    }
}
