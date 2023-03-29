<?php defined('SYSPATH') or die('No direct script access.');

class Api_Ab1_Shop_Car_Item  {

    /**
     * Разбить на две записи и изменить доверенность на количество
     * @param $shopCarItemID
     * @param $shopClientAttorneyIDTo
     * @param $shopClientContractIDTo
     * @param $quantity
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @param bool $isCalcBalance
     * @param $shopInvoiceID
     * @return bool
     * @throws HTTP_Exception_500
     */
    public static function breakItemToTwoQuantity($shopCarItemID, $shopClientAttorneyIDTo, $shopClientContractIDTo,
                                                $quantity, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver,
                                                $isCalcBalance = TRUE, $shopInvoiceID = null)
    {
        $model = new Model_Ab1_Shop_Car_Item();
        $model->setDBDriver($driver);

        if (!Helpers_DB::getDBObject($model, $shopCarItemID, $sitePageData)) {
            throw new HTTP_Exception_500('Car item id ('.$shopCarItemID.') not found.');
        }

        $shopClientAttorneyID = $model->getShopClientAttorneyID();
        $shopClientContractID = $model->getShopClientContractID();
        if($shopClientAttorneyID === $shopClientAttorneyIDTo && $shopClientContractID === $shopClientContractIDTo) {
            return TRUE;
        }
        if($model->getQuantity() > $quantity){
            $model->setQuantity($model->getQuantity() - $quantity);
            Helpers_DB::saveDBObject($model, $sitePageData);

            $model->globalID = 0;
            $model->id = 0;
            $model->setQuantity($quantity);
        }

        $model->setShopClientAttorneyID($shopClientAttorneyIDTo);
        $model->setShopClientContractID($shopClientContractIDTo);

        if($shopInvoiceID !== null) {
            $model->setShopInvoiceID($shopInvoiceID);
        }

        Helpers_DB::saveDBObject($model, $sitePageData);

        $modelCar = new Model_Ab1_Shop_Car();
        $modelCar->setDBDriver($driver);
        if (Helpers_DB::getDBObject($modelCar, $model->getShopCarID(), $sitePageData)) {
            $modelCar->setShopClientAttorneyID(0);
            $modelCar->setIsOneAttorney(FALSE);
            Helpers_DB::saveDBObject($modelCar, $sitePageData);
        }

        if($isCalcBalance) {
            // считаем балансы доверенности
            Api_Ab1_Shop_Client_Attorney::calcBalanceBlock($shopClientAttorneyID, $sitePageData, $driver);
            Api_Ab1_Shop_Client_Attorney::calcBalanceBlock($shopClientAttorneyIDTo, $sitePageData, $driver);

            // считаем балансы договоров
            Api_Ab1_Shop_Client_Contract::calcBalanceBlock($shopClientContractID, $sitePageData, $driver);
            Api_Ab1_Shop_Client_Contract::calcBalanceBlock($shopClientContractIDTo, $sitePageData, $driver);
        }

        return TRUE;
    }

    /**
     * Разбить на две записи и изменить доверенность на сумму
     * @param $shopCarItemID
     * @param $shopClientAttorneyIDTo
     * @param $shopClientContractIDTo
     * @param $amount
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @param bool $isCalcBalance
     * @param $shopInvoiceID
     * @return bool
     * @throws HTTP_Exception_500
     */
    public static function breakItemToTwoAmount($shopCarItemID, $shopClientAttorneyIDTo, $shopClientContractIDTo,
                                          $amount, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver,
                                          $isCalcBalance = TRUE, $shopInvoiceID = null)
    {
        $model = new Model_Ab1_Shop_Car_Item();
        $model->setDBDriver($driver);

        if (!Helpers_DB::getDBObject($model, $shopCarItemID, $sitePageData)) {
            throw new HTTP_Exception_500('Car item id ('.$shopCarItemID.') not found.');
        }

        $shopClientAttorneyID = $model->getShopClientAttorneyID();
        $shopClientContractID = $model->getShopClientContractID();
        if($shopClientAttorneyID === $shopClientAttorneyIDTo && $shopClientContractID === $shopClientContractIDTo) {
            return TRUE;
        }
        if($model->getAmount() > $amount){
            $quantity = floor ($amount / $model->getPrice() * 1000) / 1000;
            if($quantity < 0.0001){
                return true;
            }

            $amount =  $quantity * $model->getPrice();
            $model->setQuantity(round(($model->getAmount() - $amount) / $model->getPrice(), 3));
            Helpers_DB::saveDBObject($model, $sitePageData);

            $model->globalID = 0;
            $model->id = 0;
            $model->setQuantity(round($amount / $model->getPrice(), 3));
        }

        $model->setShopClientAttorneyID($shopClientAttorneyIDTo);
        $model->setShopClientContractID($shopClientContractIDTo);

        if($shopInvoiceID !== null) {
            $model->setShopInvoiceID($shopInvoiceID);
        }

        Helpers_DB::saveDBObject($model, $sitePageData);

        $modelCar = new Model_Ab1_Shop_Car();
        $modelCar->setDBDriver($driver);
        if (Helpers_DB::getDBObject($modelCar, $model->getShopCarID(), $sitePageData)) {
            $modelCar->setShopClientAttorneyID(0);
            $modelCar->setIsOneAttorney(FALSE);
            Helpers_DB::saveDBObject($modelCar, $sitePageData);
        }

        if($isCalcBalance) {
            // считаем балансы доверенности
            Api_Ab1_Shop_Client_Attorney::calcBalanceBlock($shopClientAttorneyID, $sitePageData, $driver);
            Api_Ab1_Shop_Client_Attorney::calcBalanceBlock($shopClientAttorneyIDTo, $sitePageData, $driver);

            // считаем балансы договоров
            Api_Ab1_Shop_Client_Contract::calcBalanceBlock($shopClientContractID, $sitePageData, $driver);
            Api_Ab1_Shop_Client_Contract::calcBalanceBlock($shopClientContractIDTo, $sitePageData, $driver);
        }

        return TRUE;
    }

    /**
     * Изменение у записи доверенность и клиента
     * @param $shopCarItemID
     * @param $shopClientAttorneyIDTo
     * @param $shopClientContractIDTo
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @param bool $isCalcBalance
     * @param $shopInvoiceID
     * @return bool
     * @throws HTTP_Exception_500
     */
    public static function editAttorney($shopCarItemID, $shopClientAttorneyIDTo, $shopClientContractIDTo,
                                        SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver, $isCalcBalance = TRUE,
                                        $shopInvoiceID = null)
    {
        $model = new Model_Ab1_Shop_Car_Item();
        $model->setDBDriver($driver);

        if (!Helpers_DB::getDBObject($model, $shopCarItemID, $sitePageData)) {
            throw new HTTP_Exception_500('Car item not found.');
        }

        $shopClientAttorneyID = $model->getShopClientAttorneyID();
        $shopClientContractID = $model->getShopClientContractID();
        if($shopClientAttorneyID === $shopClientAttorneyIDTo && $shopClientContractID === $shopClientContractIDTo) {
            return TRUE;
        }

        $model->setShopClientAttorneyID($shopClientAttorneyIDTo);
        $model->setShopClientContractID($shopClientContractIDTo);

        if($shopInvoiceID !== null) {
            $model->setShopInvoiceID($shopInvoiceID);
        }

        Helpers_DB::saveDBObject($model, $sitePageData);

        $modelCar = new Model_Ab1_Shop_Car();
        $modelCar->setDBDriver($driver);
        if (Helpers_DB::getDBObject($modelCar, $model->getShopCarID(), $sitePageData)) {
            $modelCar->setShopClientAttorneyID(0);
            $modelCar->setIsOneAttorney(FALSE);
            Helpers_DB::saveDBObject($modelCar, $sitePageData);
        }

        if($isCalcBalance) {
            // считаем балансы доверенности
            Api_Ab1_Shop_Client_Attorney::calcBalanceBlock($shopClientAttorneyID, $sitePageData, $driver);
            Api_Ab1_Shop_Client_Attorney::calcBalanceBlock($shopClientAttorneyIDTo, $sitePageData, $driver);

            // считаем балансы договоров
            Api_Ab1_Shop_Client_Contract::calcBalanceBlock($shopClientContractID, $sitePageData, $driver);
            Api_Ab1_Shop_Client_Contract::calcBalanceBlock($shopClientContractIDTo, $sitePageData, $driver);
        }

        return TRUE;
    }

    /**
     * Сохранение список
     * @param Model_Ab1_Shop_Car $modelCar
     * @param array $shopCarItems
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @return array
     */
    public static function save(Model_Ab1_Shop_Car $modelCar, array $shopCarItems,
                                SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        $params = Request_RequestParams::setParams(
            array(
                'shop_car_id' => $modelCar->id,
                'is_delete_ignore' => $modelCar->getIsDelete(),
                'is_public_ignore' => true,
            )
        );
        $shopCarItemIDs = Request_Request::find('DB_Ab1_Shop_Car_Item', 
            $sitePageData->shopID, $sitePageData, $driver, $params, 0, TRUE
        );
        $shopCarItemIDs->runIndex();

        if (!$modelCar->getIsDelete()) {
            // обнуляем балансы договоров
            $shopClientContractIDs = $shopCarItemIDs->getChildArrayInt('shop_client_contract_id', TRUE);
            if (!empty($shopClientContractIDs)) {
                $driver->updateObjects(
                    Model_Ab1_Shop_Car_Item::TABLE_NAME, $shopCarItemIDs->getChildArrayID(),
                    array('shop_client_contract_item_id' => 0)
                );

                // пересчитываем баланс договора
                Api_Ab1_Shop_Client_Contract::calcBalancesBlock($shopClientContractIDs, $sitePageData, $driver);
            }

            // обнуляем балансы продукции прайс-листов
            $shopProductPriceIDs = $shopCarItemIDs->getChildArrayInt('shop_product_price_id', TRUE);
            if (!empty($shopProductPriceIDs)) {
                $driver->updateObjects(
                    Model_Ab1_Shop_Car_Item::TABLE_NAME, $shopCarItemIDs->getChildArrayID(),
                    array('shop_product_price_id' => 0)
                );

                // пересчитываем балансы продукции прайс-листов
                Api_Ab1_Shop_Product_Price::calcBalancesBlock($shopProductPriceIDs, $sitePageData, $driver);
            }
        }

        $total = 0;
        $quantityAll = 0;
        $attorneys = array();
        $contracts = array();
        $productPrices = array();

        $model = new Model_Ab1_Shop_Car_Item();
        $model->setDBDriver($driver);
        foreach($shopCarItems as $key => $shopCarItem){
            $quantity = Request_RequestParams::strToFloat(Arr::path($shopCarItem, 'quantity', 0));
            if($quantity <= 0){
                continue;
            }

            $model->clear();
            if(key_exists($key, $shopCarItemIDs->childs)){
                $shopCarItemID = $shopCarItemIDs->childs[$key];

                $shopCarItemID->values['shop_client_contract_item_id'] = 0;
                $shopCarItemID->values['shop_product_price_id'] = 0;
                $shopCarItemID->setModel($model);

                unset($shopCarItemIDs->childs[$key]);

                $attorneys[$model->getShopClientAttorneyID()] = $model->getShopClientAttorneyID();
                $contracts[$model->getShopClientContractID()] = $model->getShopClientContractID();
                $productPrices[$model->getShopProductPriceID()] = $model->getShopProductPriceID();
            }

            // если есть накладная, то нельзя менять доверенность
            if(($modelCar->getIsInvoice()) && ($model->id > 0)) {
                $shopClientAttorneyID = $model->getShopClientAttorneyID();
                $shopClientContractID = $model->getShopClientContractID();
            }else{
                $shopClientAttorneyID = intval(Arr::path($shopCarItem, 'shop_client_attorney_id', $modelCar->getShopClientAttorneyID()));
                $shopClientContractID = intval(Arr::path($shopCarItem, 'shop_client_contract_id', $modelCar->getShopClientContractID()));
            }

            $price = Api_Ab1_Shop_Product::getPrice(
                $modelCar->getShopClientID(),
                $modelCar->getShopClientContractID(),
                $model->getShopClientBalanceDayID(),
                $modelCar->getShopProductID(),
                $modelCar->getIsCharity(),
                $quantity,
                $sitePageData, $driver,
                TRUE,
                $model->getCreatedAt()
            );

            $model->setShopStorageID($modelCar->getShopStorageID());
            $model->setShopSubdivisionID($modelCar->getShopSubdivisionID());
            $model->setShopHeapID($modelCar->getShopHeapID());

            $model->setIsDelete($modelCar->getIsDelete());
            $model->setIsPublic($modelCar->getIsPublic());
            $model->setShopProductID($modelCar->getShopProductID());
            $model->setPrice($price['price']);
            $model->setQuantity($quantity);
            $model->setShopCarID($modelCar->id);
            $model->setShopClientID($modelCar->getShopClientID());
            $model->setShopClientAttorneyID($shopClientAttorneyID);
            $model->setShopClientContractID($shopClientContractID);
            $model->setIsCharity($modelCar->getIsCharity());
            $model->setShopClientContractItemID($price['shop_client_contract_item_id']);
            $model->setShopProductPriceID($price['shop_product_price_id']);
            $model->setShopProductTimePriceID($price['shop_product_time_price_id']);
            $model->setShopClientBalanceDayID($price['shop_client_balance_day_id']);
            Helpers_DB::saveDBObject($model, $sitePageData);

            $total = $total + $model->getAmount();
            $quantityAll = $quantityAll + $model->getQuantity();

            $attorneys[$shopClientAttorneyID] = $shopClientAttorneyID;
            $contracts[$shopClientContractID] = $shopClientContractID;
            $productPrices[$model->getShopProductPriceID()] = $model->getShopProductPriceID();
        }

        // находим на удаление доверенности и контракты
        foreach ($shopCarItemIDs->childs as $child){
            $shopClientAttorneyID = $child->values['shop_client_attorney_id'];
            $shopClientContractID = $child->values['shop_client_contract_id'];
            $shopProductPriceID = $child->values['shop_product_price_id'];

            $attorneys[$shopClientAttorneyID] = $shopClientAttorneyID;
            $contracts[$shopClientContractID] = $shopClientContractID;
            $productPrices[$shopProductPriceID] = $shopProductPriceID;
        }

        // удаляем лишние
        $driver->deleteObjectIDs(
            $shopCarItemIDs->getChildArrayID(), $sitePageData->userID,
            Model_Ab1_Shop_Car_Item::TABLE_NAME, array(), $sitePageData->shopID
        );

        if (!$modelCar->getIsDelete()) {
            // пересчитываем баланс договоров
            Api_Ab1_Shop_Client_Contract::calcBalancesBlock($contracts, $sitePageData, $driver);
            // пересчитываем баланс доверенностей
            Api_Ab1_Shop_Client_Attorney::calcBalancesBlock($attorneys, $sitePageData, $driver);
            // пересчитываем баланс продукции прайс-листов
            Api_Ab1_Shop_Product_Price::calcBalancesBlock($productPrices, $sitePageData, $driver);
        }

        return array(
            'amount' => $total,
            'quantity' => $quantityAll,
            'attorneys' => $attorneys,
            'contracts' => $contracts,
            'productPrices' => $productPrices,
        );
    }

    /**
     *  Сохранение одну запись
     * @param Model_Ab1_Shop_Car $model
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @throws HTTP_Exception_500
     */
    public static function saveOne(Model_Ab1_Shop_Car $model, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        $params = Request_RequestParams::setParams(
            array(
                'shop_car_id' => $model->id,
                'is_delete_ignore' => $model->getIsDelete(),
                'is_public_ignore' => true,
            )
        );
        $shopCarItemIDs = Request_Request::find('DB_Ab1_Shop_Car_Item', 
            $sitePageData->shopID, $sitePageData, $driver, $params, 0, TRUE
        );

        // обнуляем балансы договоров
        if (!$model->getIsDelete()) {
            $shopClientContractIDs = $shopCarItemIDs->getChildArrayInt('shop_client_contract_id', TRUE);
            if (!empty($shopClientContractIDs)) {
                $driver->updateObjects(
                    Model_Ab1_Shop_Car_Item::TABLE_NAME, $shopCarItemIDs->getChildArrayID(),
                    array('shop_client_contract_item_id' => 0)
                );

                // пересчитываем баланс договора
                Api_Ab1_Shop_Client_Contract::calcBalancesBlock($shopClientContractIDs, $sitePageData, $driver);
            }

            // обнуляем балансы продукции прайс-листов
            $shopProductPriceIDs = $shopCarItemIDs->getChildArrayInt('shop_product_price_id', TRUE);
            if (!empty($shopProductPriceIDs)) {
                $driver->updateObjects(
                    Model_Ab1_Shop_Car_Item::TABLE_NAME, $shopCarItemIDs->getChildArrayID(),
                    array('shop_product_price_id' => 0)
                );

                // пересчитываем балансы продукции прайс-листов
                Api_Ab1_Shop_Product_Price::calcBalancesBlock($shopProductPriceIDs, $sitePageData, $driver);
            }
        }

        $modelItem = new Model_Ab1_Shop_Car_Item();
        $modelItem->setDBDriver($driver);
        $shopCarItemID = array_shift($shopCarItemIDs->childs);
        if($shopCarItemID !== NULL){
            $shopCarItemID->values['shop_client_contract_item_id'] = 0;
            $shopCarItemID->values['shop_product_price_id'] = 0;
            $shopCarItemID->setModel($modelItem);
        }

        $price = Api_Ab1_Shop_Product::getPrice(
            $model->getShopClientID(),
            $model->getShopClientContractID(),
            $modelItem->getShopClientBalanceDayID(),
            $model->getShopProductID(),
            $model->getIsCharity(),
            $model->getQuantity(),
            $sitePageData, $driver, TRUE,
            $model->getCreatedAt()
        );

        $modelItem->setIsDelete($model->getIsDelete());
        $modelItem->setIsPublic($model->getIsPublic());
        $modelItem->setShopStorageID($model->getShopStorageID());
        $modelItem->setShopSubdivisionID($model->getShopSubdivisionID());
        $modelItem->setShopHeapID($model->getShopHeapID());
        $modelItem->setShopProductID($model->getShopProductID());
        $modelItem->setQuantity($model->getQuantity());
        $modelItem->setPrice($price['price']);
        $modelItem->setShopCarID($model->id);
        $modelItem->setShopClientID($model->getShopClientID());
        $modelItem->setIsCharity($model->getIsCharity());
        $modelItem->setShopClientAttorneyID($model->getShopClientAttorneyID());
        $modelItem->setShopClientContractID($model->getShopClientContractID());
        $modelItem->setShopClientContractItemID($price['shop_client_contract_item_id']);
        $modelItem->setShopProductPriceID($price['shop_product_price_id']);
        $modelItem->setShopProductTimePriceID($price['shop_product_time_price_id']);
        $modelItem->setShopClientBalanceDayID($price['shop_client_balance_day_id']);
        Helpers_DB::saveDBObject($modelItem, $sitePageData);

        // удаляем лишние
        $driver->deleteObjectIDs(
            $shopCarItemIDs->getChildArrayID(), $sitePageData->userID,
            Model_Ab1_Shop_Car_Item::TABLE_NAME, array(), $sitePageData->shopID
        );

        $model->setIsOneAttorney(TRUE);
        $model->setPrice($price['price']);

        if (!$model->getIsDelete()) {
            // обновляем заблокированные суммы договоров
            $shopClientContractIDs[$model->getShopClientContractID()] = $model->getShopClientContractID();
            Api_Ab1_Shop_Client_Contract::calcBalancesBlock($shopClientContractIDs, $sitePageData, $driver);

            // обновляем заблокированные суммы доверенностей
            Api_Ab1_Shop_Client_Attorney::calcBalancesBlock(
                [
                    $model->getOriginalValue('shop_client_attorney_id') => $model->getOriginalValue('shop_client_attorney_id'),
                    $model->getShopClientAttorneyID() => $model->getShopClientAttorneyID(),
                ],
                $sitePageData, $driver
            );

            // пересчитываем балансы продукции прайс-листов
            $shopProductPriceIDs[$modelItem->getShopProductPriceID()] = $modelItem->getShopProductPriceID();
            Api_Ab1_Shop_Product_Price::calcBalancesBlock($shopProductPriceIDs, $sitePageData, $driver);
        }
    }

    /**
     * Сохранение
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @return array
     * @throws HTTP_Exception_500
     */
    public static function saveItem(SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        $model = new Model_Ab1_Shop_Car_Item();
        $model->setDBDriver($driver);

        $id = Request_RequestParams::getParamInt('id');
        if (!Helpers_DB::dublicateObjectLanguage($model, $id, $sitePageData, -1, FALSE)) {
            throw new HTTP_Exception_500('Car item not found.');
        }

        Request_RequestParams::setParamBoolean('is_check_invoice', $model);

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
}
