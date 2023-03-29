<?php defined('SYSPATH') or die('No direct script access.');

class Api_Ab1_Shop_Addition_Service_Item  {
    /**
     * Сохранение список дополнительных услуг у реализации
     * @param Model_Ab1_Shop_Car $modelCar
     * @param array $shopAdditionServiceItems
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @return array
     * @throws HTTP_Exception_404
     */
    public static function saveCar(Model_Ab1_Shop_Car $modelCar, array $shopAdditionServiceItems,
                                SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        $params = Request_RequestParams::setParams(
            array(
                'shop_car_id' => $modelCar->id,
            )
        );
        $shopAdditionServiceItemIDs = Request_Request::find('DB_Ab1_Shop_Addition_Service_Item',
            $sitePageData->shopID, $sitePageData, $driver, $params, 0, TRUE
        );
        $shopAdditionServiceItemIDs->runIndex();

        $total = 0;
        $quantityAll = 0;
        $attorneys = array();
        $contracts = array();

        $modelProduct = new Model_Ab1_Shop_Product();
        $modelProduct->setDBDriver($driver);

        $model = new Model_Ab1_Shop_Addition_Service_Item();
        $model->setDBDriver($driver);
        foreach($shopAdditionServiceItems as $key => $child){
            $quantity = Request_RequestParams::strToFloat(Arr::path($child, 'quantity', 0));
            if($quantity <= 0){
                continue;
            }

            $shopProductID = Request_RequestParams::strToFloat(Arr::path($child, 'shop_product_id', 0));
            if($shopProductID <= 0){
                continue;
            }

            $model->clear();
            if(key_exists($key, $shopAdditionServiceItemIDs->childs)){
                $shopAdditionServiceItemIDs->childs[$key]->setModel($model);
                unset($shopAdditionServiceItemIDs->childs[$key]);

                $attorneys[$model->getShopClientAttorneyID()] = $model->getShopClientAttorneyID();
                $contracts[$model->getShopClientContractID()] = $model->getShopClientContractID();
            }

            // если есть накладная, то нельзя менять доверенность
            if(($modelCar->getIsInvoice()) && ($model->id > 0)) {
                $shopClientAttorneyID = $model->getShopClientAttorneyID();
                $shopClientContractID = $model->getShopClientContractID();
            }else{
                $shopClientAttorneyID = intval(Arr::path($child, 'shop_client_attorney_id', $modelCar->getShopClientAttorneyID()));
                $shopClientContractID = intval(Arr::path($child, 'shop_client_contract_id', $modelCar->getShopClientContractID()));
            }

            $model->setShopProductID($shopProductID);

            if(!Helpers_DB::getDBObject($modelProduct, $shopProductID, $sitePageData)){
                throw new HTTP_Exception_404('Product not fount. #29052020');
            }

            $model->setPrice($modelProduct->getPrice());
            $model->setQuantity($quantity);
            $model->setShopCarID($modelCar->id);
            $model->setShopClientID($modelCar->getShopClientID());
            $model->setShopClientAttorneyID($shopClientAttorneyID);
            $model->setShopClientContractID($shopClientContractID);
            Helpers_DB::saveDBObject($model, $sitePageData);

            $total = $total + $model->getAmount();
            $quantityAll = $quantityAll + $model->getQuantity();

            $attorneys[$shopClientAttorneyID] = $shopClientAttorneyID;
            $contracts[$shopClientContractID] = $shopClientContractID;
        }

        // находим на удаление доверенности и контракты
        foreach ($shopAdditionServiceItemIDs->childs as $child){
            $shopClientAttorneyID = $child->values['shop_client_attorney_id'];
            $shopClientContractID = $child->values['shop_client_contract_id'];

            $attorneys[$shopClientAttorneyID] = $shopClientAttorneyID;
            $contracts[$shopClientContractID] = $shopClientContractID;
        }

        // удаляем лишние
        $driver->deleteObjectIDs(
            $shopAdditionServiceItemIDs->getChildArrayID(), $sitePageData->userID,
            Model_Ab1_Shop_Addition_Service_Item::TABLE_NAME, array(), $sitePageData->shopID
        );

        if (!$modelCar->getIsDelete()) {
            // пересчитываем баланс договоров
            Api_Ab1_Shop_Client_Contract::calcBalancesBlock($contracts, $sitePageData, $driver);
            // пересчитываем баланс доверенностей
            Api_Ab1_Shop_Client_Attorney::calcBalancesBlock($attorneys, $sitePageData, $driver);
        }

        return array(
            'amount' => $total,
            'quantity' => $quantityAll,
            'attorneys' => $attorneys,
            'contracts' => $contracts,
        );
    }

    /**
     * Сохранение список дополнительных услуг у штучного товара
     * @param Model_Ab1_Shop_Piece $modelPiece
     * @param array $shopAdditionServiceItems
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @return array
     * @throws HTTP_Exception_404
     */
    public static function savePiece(Model_Ab1_Shop_Piece $modelPiece, array $shopAdditionServiceItems,
                                   SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        $params = Request_RequestParams::setParams(
            array(
                'shop_piece_id' => $modelPiece->id,
            )
        );
        $shopAdditionServiceItemIDs = Request_Request::find('DB_Ab1_Shop_Addition_Service_Item',
            $sitePageData->shopID, $sitePageData, $driver, $params, 0, TRUE
        );
        $shopAdditionServiceItemIDs->runIndex();

        $total = 0;
        $quantityAll = 0;
        $attorneys = array();
        $contracts = array();

        $modelProduct = new Model_Ab1_Shop_Product();
        $modelProduct->setDBDriver($driver);

        $model = new Model_Ab1_Shop_Addition_Service_Item();
        $model->setDBDriver($driver);
        foreach($shopAdditionServiceItems as $key => $child){
            $quantity = Request_RequestParams::strToFloat(Arr::path($child, 'quantity', 0));
            if($quantity <= 0){
                continue;
            }

            $shopProductID = Request_RequestParams::strToFloat(Arr::path($child, 'shop_product_id', 0));
            if($shopProductID <= 0){
                continue;
            }

            $model->clear();
            if(key_exists($key, $shopAdditionServiceItemIDs->childs)){
                $shopAdditionServiceItemIDs->childs[$key]->setModel($model);
                unset($shopAdditionServiceItemIDs->childs[$key]);

                $attorneys[$model->getShopClientAttorneyID()] = $model->getShopClientAttorneyID();
                $contracts[$model->getShopClientContractID()] = $model->getShopClientContractID();
            }

            // если есть накладная, то нельзя менять доверенность
            if(($modelPiece->getIsInvoice()) && ($model->id > 0)) {
                $shopClientAttorneyID = $model->getShopClientAttorneyID();
                $shopClientContractID = $model->getShopClientContractID();
            }else{
                $shopClientAttorneyID = intval(Arr::path($child, 'shop_client_attorney_id', $modelPiece->getShopClientAttorneyID()));
                $shopClientContractID = intval(Arr::path($child, 'shop_client_contract_id', $modelPiece->getShopClientContractID()));
            }

            $model->setShopProductID($shopProductID);

            if(!Helpers_DB::getDBObject($modelProduct, $shopProductID, $sitePageData)){
                throw new HTTP_Exception_404('Product not fount. #29052020');
            }

            $model->setPrice($modelProduct->getPrice());
            $model->setQuantity($quantity);
            $model->setShopPieceID($modelPiece->id);
            $model->setShopClientID($modelPiece->getShopClientID());
            $model->setShopClientAttorneyID($shopClientAttorneyID);
            $model->setShopClientContractID($shopClientContractID);
            Helpers_DB::saveDBObject($model, $sitePageData);

            $total = $total + $model->getAmount();
            $quantityAll = $quantityAll + $model->getQuantity();

            $attorneys[$shopClientAttorneyID] = $shopClientAttorneyID;
            $contracts[$shopClientContractID] = $shopClientContractID;
        }

        // находим на удаление доверенности и контракты
        foreach ($shopAdditionServiceItemIDs->childs as $child){
            $shopClientAttorneyID = $child->values['shop_client_attorney_id'];
            $shopClientContractID = $child->values['shop_client_contract_id'];

            $attorneys[$shopClientAttorneyID] = $shopClientAttorneyID;
            $contracts[$shopClientContractID] = $shopClientContractID;
        }

        // удаляем лишние
        $driver->deleteObjectIDs(
            $shopAdditionServiceItemIDs->getChildArrayID(), $sitePageData->userID,
            Model_Ab1_Shop_Addition_Service_Item::TABLE_NAME, array(), $sitePageData->shopID
        );

        if (!$modelPiece->getIsDelete()) {
            // пересчитываем баланс договоров
            Api_Ab1_Shop_Client_Contract::calcBalancesBlock($contracts, $sitePageData, $driver);
            // пересчитываем баланс доверенностей
            Api_Ab1_Shop_Client_Attorney::calcBalancesBlock($attorneys, $sitePageData, $driver);
        }

        return array(
            'amount' => $total,
            'quantity' => $quantityAll,
            'attorneys' => $attorneys,
            'contracts' => $contracts,
        );
    }
}
