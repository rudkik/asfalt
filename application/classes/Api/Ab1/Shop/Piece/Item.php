<?php defined('SYSPATH') or die('No direct script access.');

class Api_Ab1_Shop_Piece_Item  {

    /**
     * Получаем список товаров вывезенных машин за заданный период
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
    public static function getExitShopPieceItems($dateFrom, $dateTo, SitePageData $sitePageData,
                                                 Model_Driver_DBBasicDriver $driver, $elements = NULL, $params = array(),
                                                 $isAllBranch = false, $isCharity = false)
    {
        $params = array_merge(
            Request_RequestParams::setParams(
                array(
                    'shop_piece_id.created_at_from' => $dateFrom,
                    'shop_piece_id.created_at_to' => $dateTo,
                    'shop_piece_id.is_exit' => 1,
                    'shop_piece_id.is_charity' => $isCharity,
                )
            ),
            $params
        );
        if($isAllBranch){
            $shopPieceItemIDs = Request_Request::findBranch('DB_Ab1_Shop_Piece_Item',
                array(), $sitePageData, $driver, $params,0, TRUE, $elements
            );
        }else {
            $shopPieceItemIDs = Request_Request::find('DB_Ab1_Shop_Piece_Item',
                $sitePageData->shopID, $sitePageData, $driver, $params,0, TRUE, $elements
            );
        }

        return $shopPieceItemIDs;
    }

    /**
     * Разбить на две записи и изменить доверенность по количеству
     * @param $shopPieceItemID
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
    public static function breakItemToTwoQuantity($shopPieceItemID, $shopClientAttorneyIDTo, $shopClientContractIDTo,
                                                $quantity, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver,
                                                $isCalcBalance = TRUE, $shopInvoiceID = null)
    {
        $model = new Model_Ab1_Shop_Piece_Item();
        $model->setDBDriver($driver);

        if (!Helpers_DB::getDBObject($model, $shopPieceItemID, $sitePageData)) {
            throw new HTTP_Exception_500('Piece item not found.');
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

        $modelPiece = new Model_Ab1_Shop_Piece();
        $modelPiece->setDBDriver($driver);
        if (Helpers_DB::getDBObject($modelPiece, $model->getShopPieceID(), $sitePageData)) {
            $modelPiece->setShopClientAttorneyID(0);
            $modelPiece->setShopClientContractID(0);
            $modelPiece->setIsOneAttorney(FALSE);
            Helpers_DB::saveDBObject($modelPiece, $sitePageData);
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
     * Разбить на две записи и изменить доверенность по сумме
     * @param $shopPieceItemID
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
    public static function breakItemToTwoAmount($shopPieceItemID, $shopClientAttorneyIDTo, $shopClientContractIDTo,
                                          $amount, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver,
                                          $isCalcBalance = TRUE, $shopInvoiceID = null)
    {
        $model = new Model_Ab1_Shop_Piece_Item();
        $model->setDBDriver($driver);

        if (!Helpers_DB::getDBObject($model, $shopPieceItemID, $sitePageData)) {
            throw new HTTP_Exception_500('Piece item not found.');
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

        $modelPiece = new Model_Ab1_Shop_Piece();
        $modelPiece->setDBDriver($driver);
        if (Helpers_DB::getDBObject($modelPiece, $model->getShopPieceID(), $sitePageData)) {
            $modelPiece->setShopClientAttorneyID(0);
            $modelPiece->setShopClientContractID(0);
            $modelPiece->setIsOneAttorney(FALSE);
            Helpers_DB::saveDBObject($modelPiece, $sitePageData);
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
     * @param $shopPieceItemID
     * @param $shopClientAttorneyIDTo
     * @param $shopClientContractIDTo
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @param bool $isCalcBalance
     * @param $shopInvoiceID
     * @return bool
     * @throws HTTP_Exception_500
     */
    public static function editAttorney($shopPieceItemID, $shopClientAttorneyIDTo, $shopClientContractIDTo,
                                        SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver, $isCalcBalance = TRUE,
                                        $shopInvoiceID = null)
    {
        $model = new Model_Ab1_Shop_Piece_Item();
        $model->setDBDriver($driver);

        if (!Helpers_DB::getDBObject($model, $shopPieceItemID, $sitePageData)) {
            throw new HTTP_Exception_500('Piece item not found.');
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

        $modelPiece = new Model_Ab1_Shop_Piece();
        $modelPiece->setDBDriver($driver);
        if (Helpers_DB::getDBObject($modelPiece, $model->getShopPieceID(), $sitePageData)) {
            $modelPiece->setShopClientAttorneyID(0);
            $modelPiece->setIsOneAttorney(FALSE);
            Helpers_DB::saveDBObject($modelPiece, $sitePageData);
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
     * @param Model_Ab1_Shop_Piece $modelPiece
     * @param array $shopPieceItems
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @return array
     */
    public static function save(Model_Ab1_Shop_Piece $modelPiece, array $shopPieceItems, SitePageData $sitePageData,
                                Model_Driver_DBBasicDriver $driver)
    {
        $params = Request_RequestParams::setParams(
            array(
                'shop_piece_id' => $modelPiece->id,
            )
        );
        $shopPieceItemIDs = Request_Request::find(
            'DB_Ab1_Shop_Piece_Item', $sitePageData->shopID, $sitePageData, $driver, $params, 0, TRUE
        );
        $shopPieceItemIDs->runIndex();

        // Получаем список продукции на складе
        $productStorages = array();
        foreach ($shopPieceItemIDs->childs as $child){
            $storage = $child->values['shop_storage_id'];
            if($storage > 0){
                $product = $child->values['shop_product_id'];
                $productStorages[$product.'_'.$storage] = array(
                    'shop_product_id' => $product,
                    'shop_storage_id' => $storage,
                );
            }
        }

        // обнуляем балансы договоров
        if (!$modelPiece->getIsDelete()) {
            $shopClientContractIDs = $shopPieceItemIDs->getChildArrayInt('shop_client_contract_id', TRUE);
            if (!empty($shopClientContractIDs)) {
                $driver->updateObjects(
                    Model_Ab1_Shop_Piece_Item::TABLE_NAME, $shopPieceItemIDs->getChildArrayID(),
                    array('shop_client_contract_item_id' => 0)
                );

                // пересчитываем баланс договора
                Api_Ab1_Shop_Client_Contract::calcBalancesBlock($shopClientContractIDs, $sitePageData, $driver);
            }

            // обнуляем балансы продукции прайс-листов
            $shopProductPriceIDs = $shopPieceItemIDs->getChildArrayInt('shop_product_price_id', TRUE);
            if (!empty($shopProductPriceIDs)) {
                $driver->updateObjects(
                    Model_Ab1_Shop_Piece_Item::TABLE_NAME, $shopPieceItemIDs->getChildArrayID(),
                    array('shop_product_price_id' => 0)
                );

                // пересчитываем балансы продукции прайс-листов
                Api_Ab1_Shop_Product_Price::calcBalancesBlock($shopProductPriceIDs, $sitePageData, $driver);
            }
        }

        $model = new Model_Ab1_Shop_Piece_Item();
        $model->setDBDriver($driver);

        $modelProduct = new Model_Ab1_Shop_Product();
        $modelProduct->setDBDriver($driver);

        $total = 0;
        $names = '';
        $quantityAll = 0;
        $attorneys = array();
        $contracts = array();
        $subdivisions = array();
        $storages = array();
        $heaps = array();
        $isOneAttorney = array();
        $productPrices = array();
        foreach($shopPieceItems as $key => $shopPieceItem){
            $quantity = Request_RequestParams::strToFloat(Arr::path($shopPieceItem, 'quantity', 0));
            if($quantity <= 0){
                continue;
            }

            $shopProductID = intval(Arr::path($shopPieceItem, 'shop_product_id', 0));
            if($shopProductID < 1){
                continue;
            }

            if (!Helpers_DB::getDBObject($modelProduct, $shopProductID, $sitePageData)){
                continue;
            }
            $subdivisions[$modelProduct->getShopSubdivisionID()] = $modelProduct->getShopSubdivisionID();
            $storages[$modelProduct->getShopStorageID()] = $modelProduct->getShopStorageID();
            $heaps[$modelProduct->getShopHeapID()] = $modelProduct->getShopHeapID();

            $model->clear();
            if(key_exists($key, $shopPieceItemIDs->childs)){
                $shopPieceItemID = $shopPieceItemIDs->childs[$key];

                $shopPieceItemID->values['shop_client_contract_item_id'] = 0;
                $shopPieceItemID->values['shop_product_price_id'] = 0;
                $shopPieceItemID->setModel($model);

                unset($shopPieceItemIDs->childs[$key]);

                $attorneys[$model->getShopClientAttorneyID()] = $model->getShopClientAttorneyID();
                $contracts[$model->getShopClientContractID()] = $model->getShopClientContractID();
                $productPrices[$model->getShopProductPriceID()] = $model->getShopProductPriceID();
            }

            // если есть накладная, то нельзя менять доверенность
            if(($modelPiece->getIsInvoice()) && ($model->id > 0)) {
                $shopClientAttorneyID = $model->getShopClientAttorneyID();
                $shopClientContractID = $model->getShopClientContractID();
            }else{
                $shopClientAttorneyID = intval(Arr::path($shopPieceItem, 'shop_client_attorney_id', $modelPiece->getShopClientAttorneyID()));
                $shopClientContractID = intval(Arr::path($shopPieceItem, 'shop_client_contract_id', $modelPiece->getShopClientContractID()));
            }
            $isOneAttorney[$shopClientAttorneyID.'_'.$shopClientContractID] = true;

            $price = Api_Ab1_Shop_Product::getPrice(
                $modelPiece->getShopClientID(),
                $modelPiece->getShopClientContractID(),
                $model->getShopClientBalanceDayID(),
                $shopProductID,
                $modelPiece->getIsCharity(),
                $quantity,
                $sitePageData, $driver,
                TRUE,
                $model->getCreatedAt()
            );

            $model->setShopSubdivisionID($modelProduct->getShopSubdivisionID());
            $model->setShopStorageID($modelProduct->getShopStorageID());
            $model->setShopHeapID($modelProduct->getShopHeapID());

            $model->setShopProductID($shopProductID);
            $model->setPrice($price['price']);
            $model->setQuantity($quantity);
            $model->setShopPieceID($modelPiece->id);
            $model->setShopClientID($modelPiece->getShopClientID());
            $model->setShopClientAttorneyID($shopClientAttorneyID);
            $model->setShopClientContractID($shopClientContractID);
            $model->setIsCharity($modelPiece->getIsCharity());
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

            $names .= $modelProduct->getName()."\r\n";

            // Сохраняем расхода материалов по рецептам
            Api_Ab1_Shop_Register_Material::saveShopPieceItem($modelPiece, $model, $sitePageData, $driver);

            $storage = $model->getShopStorageID();
            if($storage > 0){
                $product = $model->getShopProductID();
                $productStorages[$product.'_'.$storage] = array(
                    'shop_product_id' => $product,
                    'shop_storage_id' => $storage,
                );
            }
        }
        $names = mb_substr($names, 0, -2);

        $modelPiece->setIsOneAttorney(count($isOneAttorney) < 2);

        // находим на удаление доверенности и контракты
        foreach ($shopPieceItemIDs->childs as $child){
            $shopClientAttorneyID = $child->values['shop_client_attorney_id'];
            $shopClientContractID = $child->values['shop_client_contract_id'];
            $shopProductPriceID = $child->values['shop_product_price_id'];

            $attorneys[$shopClientAttorneyID] = $shopClientAttorneyID;
            $contracts[$shopClientContractID] = $shopClientContractID;
            $productPrices[$shopProductPriceID] = $shopProductPriceID;
        }

        // удаляем лишние
        $driver->deleteObjectIDs(
            $shopPieceItemIDs->getChildArrayID(), $sitePageData->userID,
            Model_Ab1_Shop_Piece_Item::TABLE_NAME, array(), $sitePageData->shopID
        );

        // Удаляем расход материалов по рецептам
        foreach ($shopPieceItemIDs->childs as $child){
            Api_Ab1_Shop_Register_Material::delShopPieceItem(
                $child->createModel('DB_Ab1_Shop_Piece_Item', $driver), $sitePageData, $driver
            );
        }

        if (!$modelPiece->getIsDelete()) {
            // пересчитываем баланс договоров
            Api_Ab1_Shop_Client_Contract::calcBalancesBlock($contracts, $sitePageData, $driver);
            // пересчитываем баланс доверенностей
            Api_Ab1_Shop_Client_Attorney::calcBalancesBlock($attorneys, $sitePageData, $driver);
            // пересчитываем баланс продукции прайс-листов
            Api_Ab1_Shop_Product_Price::calcBalancesBlock($productPrices, $sitePageData, $driver);
        }

        // остатки по продукциям на складе
        foreach ($productStorages as $productStorage){
            Api_Ab1_Shop_Product_Storage::calcProductBalance(
                $productStorage['shop_product_id'],
                $productStorage['shop_storage_id'],
                $sitePageData, $driver, true
            );
        }

        return array(
            'names' => $names,
            'amount' => $total,
            'quantity' => $quantityAll,
            'attorneys' => $attorneys,
            'contracts' => $contracts,
            'productPrices' => $productPrices,
            'subdivisions' => $subdivisions,
            'storages' => $storages,
            'heaps' => $heaps,
        );
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
        $model = new Model_Ab1_Shop_Piece_Item();
        $model->setDBDriver($driver);

        $id = Request_RequestParams::getParamInt('id');
        if (!Helpers_DB::dublicateObjectLanguage($model, $id, $sitePageData, -1, FALSE)) {
            throw new HTTP_Exception_500('Piece item not found.');
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
