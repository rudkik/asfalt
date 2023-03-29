<?php defined('SYSPATH') or die('No direct script access.');

class Api_Ab1_Shop_Client_Balance_Day  {

    /**
     * Удаляем блокировку суммы реализации клиента у фиксированных балансов
     * @param $fieldName
     * @param int $shopObjectID
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @param bool $isAdditionAmount
     * @return null
     */
    private static function _deleteBlockClientBalanceDay($fieldName, int $shopObjectID,
                                                         SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver,
                                                         $isAdditionAmount = false)
    {
        if($shopObjectID < 1) {
            return null;
        }

        // получаем текущие заблокированные суммы
        $params = Request_RequestParams::setParams(
            array(
                $fieldName => $shopObjectID,
                'is_addition_amount' => $isAdditionAmount,
            )
        );
        $itemIDs = Request_Request::find(
            'DB_Ab1_Shop_Client_Balance_Day_Item', $sitePageData->shopMainID, $sitePageData, $driver,
            $params, 0, true
        );

        $driver->deleteObjectIDs(
            $itemIDs->getChildArrayID(), $sitePageData->userID, Model_Ab1_Shop_Client_Balance_Day_Item::TABLE_NAME,
            array(), $sitePageData->shopMainID
        );
    }

    /**
     * Удаляем блокировку суммы реализации клиента у фиксированных балансов
     * @param int $shopPieceID
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @param bool $isAdditionAmount
     */
    public static function deleteBlockPieceClientBalanceDay(int $shopPieceID,
                                                            SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver,
                                                            $isAdditionAmount = false)
    {
        self::_deleteBlockClientBalanceDay(
            'shop_piece_id', $shopPieceID, $sitePageData, $driver, $isAdditionAmount
        );
    }

    /**
     * Удаляем блокировку суммы реализации штучного товара клиента у фиксированных балансов
     * @param int $shopCarID
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @param bool $isAdditionAmount
     */
    public static function deleteBlockCarClientBalanceDay(int $shopCarID,
                                                          SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver,
                                                          $isAdditionAmount = false)
    {
        self::_deleteBlockClientBalanceDay(
            'shop_car_id', $shopCarID, $sitePageData, $driver, $isAdditionAmount
        );
    }

    /**
     * Удаляем блокировку суммы возврата клиента у фиксированных балансов
     * @param int $shopActReviseItemID
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @return null
     */
    public static function deleteBlockActReviseClientBalanceDay(int $shopActReviseItemID,
                                                                SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        self::_deleteBlockClientBalanceDay('shop_act_revise_item_id', $shopActReviseItemID, $sitePageData, $driver);
    }

    /**
     * Удаляем блокировку суммы возврата клиента у фиксированных балансов
     * @param int $shopPaymentReturnID
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @return null
     */
    public static function deleteBlockPaymentReturnClientBalanceDay(int $shopPaymentReturnID,
                                                       SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        self::_deleteBlockClientBalanceDay('shop_payment_return_id', $shopPaymentReturnID, $sitePageData, $driver);
    }

    /**
     * Получаем фиксированные балансов у клиента, у которые есть баланс
     * @param $shopClientID
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @param string $date
     * @return MyArray
     */
    public static function findClientBalanceDaysByClient($shopClientID, SitePageData $sitePageData,
                                                         Model_Driver_DBBasicDriver $driver, $date = '')
    {
        if(empty($date)){
            $date = date('Y-m-d');
        }else{
            $date = Helpers_DateTime::getDateFormatPHP($date);
        }

        // получаем свободные фиксированные суммы
        $params = Request_RequestParams::setParams(
            array(
                'shop_client_id' => $shopClientID,
                'balance_from' => 0,
                'date_from' => Helpers_DateTime::minusDays($date, 365),
                'date_to' => $date,
                'sort_by' => [
                    'date' => 'asc',
                ]
            )
        );
        $dayIDs = Request_Request::find(
            'DB_Ab1_Shop_Client_Balance_Day', $sitePageData->shopMainID, $sitePageData, $driver, $params,
            0, true
        );

        return $dayIDs;
    }

    /**
     * Блокируем суммы реализации клиента у фиксированных балансов
     * @param $shopClientID
     * @param $fieldName
     * @param int $shopObjectID
     * @param float $amount
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @param string $date
     * @param bool $isAdditionAmount
     * @return bool|null
     */
    private static function _blockClientBalanceDay($shopClientID, $fieldName, int $shopObjectID, float $amount,
                                                   SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver,
                                                   $date = '', $isAdditionAmount = false)
    {
        if($shopClientID < 1 || $shopObjectID < 1 || $amount < 0) {
            return null;
        }

        // получаем текущие заблокированные суммы
        $params = Request_RequestParams::setParams(
            array(
                $fieldName => $shopObjectID,
                'is_public_ignore' => true,
                'is_delete_ignore' => true,
                'is_addition_amount' => $isAdditionAmount,
            )
        );
        $itemIDs = Request_Request::find(
            'DB_Ab1_Shop_Client_Balance_Day_Item', $sitePageData->shopMainID, $sitePageData, $driver,
            $params, 0, true
        );

        // освобождаем заблокированные суммы фиксированных балансов
        $driver->updateObjects(
            Model_Ab1_Shop_Client_Balance_Day_Item::TABLE_NAME, $itemIDs->getChildArrayID(),
            array('is_public' => false), 0, $sitePageData->shopMainID
        );

        // получаем свободные фиксированные суммы
        $dayIDs = self::findClientBalanceDaysByClient($shopClientID, $sitePageData, $driver, $date);

        $model = new Model_Ab1_Shop_Client_Balance_Day_Item();
        $model->setDBDriver($driver);

        foreach ($dayIDs->childs as $child){
            $itemIDs->childShiftSetModel($model);

            $model->setOriginalValue('is_public', 0);
            $model->setIsPublic(true);
            $model->setIsDelete(false);

            $model->setIsAdditionAmount($isAdditionAmount);
            $model->setShopClientBalanceDayID($child->id);
            $model->setShopClientID($shopClientID);
            $model->setValueInt($fieldName, $shopObjectID);

            if($child->values['balance'] < $amount){
                $model->setAmount($child->values['balance']);
                $amount -= $child->values['balance'];
            }else{
                $model->setAmount($amount);
                $amount = 0;
            }

            Helpers_DB::saveDBObject($model, $sitePageData, $sitePageData->shopMainID);

            if($amount < 0.0001){
                break;
            }
        }

        $driver->deleteObjectIDs(
            $itemIDs->getChildArrayID(), $sitePageData->userID, Model_Ab1_Shop_Client_Balance_Day_Item::TABLE_NAME,
            array(), $sitePageData->shopMainID
        );

        return true;
    }

    /**
     * Блокируем суммы реализации клиента у фиксированных балансов
     * @param $shopClientID
     * @param int $shopCarID
     * @param float $amount
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @param string $date
     * @param bool $isAdditionAmount
     * @return bool|null
     */
    public static function blockCarClientBalanceDay($shopClientID, int $shopCarID, float $amount,
                                                    SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver,
                                                    $date = '', $isAdditionAmount = false)
    {
        return self::_blockClientBalanceDay(
            $shopClientID, 'shop_car_id', $shopCarID, $amount, $sitePageData, $driver, $date, $isAdditionAmount
        );
    }

    /**
     * Блокируем суммы реализации штучного товара клиента у фиксированных балансов
     * @param $shopClientID
     * @param int $shopPieceID
     * @param float $amount
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @param string $date
     * @param bool $isAdditionAmount
     * @return bool|null
     */
    public static function blockPieceClientBalanceDay($shopClientID, int $shopPieceID, float $amount,
                                                      SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver,
                                                      $date = '', $isAdditionAmount = false)
    {
        return self::_blockClientBalanceDay(
            $shopClientID, 'shop_piece_id', $shopPieceID, $amount, $sitePageData, $driver, $date, $isAdditionAmount
        );
    }

    /**
     * Блокируем суммы списания актов из 1С клиента у фиксированных балансов
     * @param $shopClientID
     * @param int $shopActReviseItemID
     * @param float $amount
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @param string $date
     * @param bool $isAdditionAmount
     * @return bool|null
     */
    public static function blockActReviseClientBalanceDay($shopClientID, int $shopActReviseItemID, float $amount,
                                                          SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver,
                                                          $date = '', $isAdditionAmount = false)
    {
        return self::_blockClientBalanceDay(
            $shopClientID, 'shop_act_revise_item_id', $shopActReviseItemID, $amount, $sitePageData, $driver,
            $date, $isAdditionAmount
        );
    }

    /**
     * Блокируем суммы возврата клиента у фиксированных балансов
     * @param $shopClientID
     * @param int $shopPaymentReturnID
     * @param float $amount
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @param string $date
     * @param bool $isAdditionAmount
     * @return bool|null
     */
    public static function blockPaymentReturnClientBalanceDay($shopClientID, int $shopPaymentReturnID, float $amount,
                                                              SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver,
                                                              $date = '', $isAdditionAmount = false)
    {
        return self::_blockClientBalanceDay(
            $shopClientID, 'shop_payment_return_id', $shopPaymentReturnID, $amount, $sitePageData, $driver,
            $date, $isAdditionAmount
        );
    }

    /**
     * Получение данных для баланса по фиксированной цене
     * Пердварительная предоплата фиксирует цену
     * @param $shopClientID
     * @param int $shopProductID
     * @param float $quantity
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @return Model_Ab1_Shop_Client_Balance_Day|null
     */
    public static function getClientBalanceDay($shopClientID, int $shopProductID, float $quantity, SitePageData $sitePageData,
                                               Model_Driver_DBBasicDriver $driver)
    {
        if($shopClientID < 1 || $shopProductID < 1 || $quantity <= 0) {
            return null;
        }

        $ids = self::findClientBalanceDaysByClient($shopClientID, $sitePageData, $driver);

        foreach ($ids->childs as $child){
            // получаем цену за заданный период
            $modelPrice = Api_Ab1_Shop_Product_Time_Price::getProductTimePrice(
                $shopProductID, $child->values['date'], $sitePageData, $driver
            );
            if($modelPrice == null){
                continue;
            }

            if($child->values['balance'] >= $quantity * $modelPrice->getPrice()){
                $model = new Model_Ab1_Shop_Client_Balance_Day();
                $model->setDBDriver($driver);
                $child->setModel($model);

                return $model;
            }
        }

        return null;
    }


    /**
     * Обновляем баланс заблокировки фиксированного баланса
     * @param Model_Ab1_Shop_Client_Balance_Day $model
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @return float
     */
    public static function getBlockBalance(Model_Ab1_Shop_Client_Balance_Day $model, SitePageData $sitePageData,
                                           Model_Driver_DBBasicDriver $driver)
    {
        if($model->getDate() != date('Y-m-d')){
            $balance = Api_Ab1_Shop_Client::calcBalance($model->getShopClientID(), $sitePageData, $driver, $model->getDate());
            $balance = $balance['balance'];
        }else {
            $modelClient = new Model_Ab1_Shop_Client();
            $modelClient->setDBDriver($driver);
            if (!Helpers_DB::getDBObject($modelClient, $model->getShopClientID(), $sitePageData, $sitePageData->shopMainID)) {
                return 0;
            }

            $balance = $modelClient->getBalance();
        }

        // если баланс отрицательный, то блокируем сумму баланса, чтобы погасить долг
        if($balance < 0){
            $balance = $balance * -1;
            if($balance > $model->getAmount()){
                $balance = $model->getAmount();
            }
        }elseif ($model->getDate() == '2021-01-01'){
            $balance = $balance * -1;
        }else{
            $balance = 0;
        }

        return $balance;
    }

    /**
     * Получаем / создаем день фиксации цены продукции на баланс
     * @param $shopClientID
     * @param $date
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @return int
     */
    public static function setClientBalanceDay($shopClientID, $date, SitePageData $sitePageData,
                                               Model_Driver_DBBasicDriver $driver)
    {
        if($shopClientID < 1) {
            return 0;
        }

        if($date == null){
            $date = date('Y-m-d');
        }
        $date = Helpers_DateTime::getDateFormatPHP($date);

        $params = Request_RequestParams::setParams(
            array(
                'shop_client_id' => $shopClientID,
                'date' => $date,
            )
        );
        $ids = Request_Request::find(
            'DB_Ab1_Shop_Client_Balance_Day', $sitePageData->shopMainID, $sitePageData, $driver, $params, 1, true
        );

        if(count($ids->childs) > 0 ){
            return $ids->childs[0]->id;
        }

        $model = new Model_Ab1_Shop_Client_Balance_Day();
        $model->setDBDriver($driver);
        $model->setShopClientID($shopClientID);
        $model->setDate($date);

        // заблокированные баланс
        $model->setBlockBalanceClient(self::getBlockBalance($model, $sitePageData, $driver));

        return Helpers_DB::saveDBObject($model, $sitePageData, $sitePageData->shopMainID);
    }

    /**
     * Списываем сумму с баланса фиксированных цен (на пример при возврате клиенту)
     * Возврат суммы не возможен
     * @param $shopClientID
     * @param float $amount
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     */
    public static function reduceAmount($shopClientID, float $amount, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        if($shopClientID < 1 || $amount <= 0) {
            return;
        }

        $params = Request_RequestParams::setParams(
            array(
                'shop_client_id' => $shopClientID,
                'balance_from' => 0,
                'date_from' => Helpers_DateTime::minusDays(date('Y-m-d'), 365),
            )
        );
        $ids = Request_Request::find(
            'DB_Ab1_Shop_Client_Balance_Day', $sitePageData->shopMainID, $sitePageData, $driver, $params, 0, true
        );

        $model = new Model_Ab1_Shop_Client_Balance_Day();
        $model->setDBDriver($driver);

        foreach ($ids->childs as $child){
            $child->setModel($model);
            if($model->getBalance() >= $amount){
                $model->setBlockAmount($model->getBlockAmount() + $amount);
                Helpers_DB::saveDBObject($model, $sitePageData, $sitePageData->shopMainID);
                break;
            }

            $amount -= $model->getBalance();
            $model->setBlockAmount($model->getBlockAmount() + $model->getBalance());
            Helpers_DB::saveDBObject($model, $sitePageData, $sitePageData->shopMainID);
        }
    }
}
