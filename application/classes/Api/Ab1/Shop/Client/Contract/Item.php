<?php defined('SYSPATH') or die('No direct script access.');

class Api_Ab1_Shop_Client_Contract_Item  {

    /**
     * Пересчитываем заблокированные суммы для продукций договора
     * @param array $shopClientContractItemIDs
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @return int
     * @throws HTTP_Exception_500
     */
    public static function calcBalancesBlock(array $shopClientContractItemIDs, SitePageData $sitePageData,
                                            Model_Driver_DBBasicDriver $driver)
    {
        $total = 0;

        /** Пересчитываем остатки для продукций договора **/
        $model = new Model_Ab1_Shop_Client_Contract_Item();
        $model->setDBDriver($driver);
        foreach ($shopClientContractItemIDs as $shopClientContractItemID) {
            $shopClientContractItemID = intval($shopClientContractItemID);
            if($shopClientContractItemID < 1){
                continue;
            }

            if(!Helpers_DB::getDBObject($model, $shopClientContractItemID, $sitePageData, $sitePageData->shopMainID)){
                throw new HTTP_Exception_500('Client contract item not found.');
            }

            $amount = 0;
            $params = Request_RequestParams::setParams(
                array(
                    'shop_client_contract_item_id' => $shopClientContractItemID,
                    'sum_amount' => TRUE,
                )
            );
            // реализация
            $ids = Request_Request::findBranch('DB_Ab1_Shop_Car_Item', 
                array(), $sitePageData, $driver, $params
            );
            if (count($ids->childs) > 0) {
                $amount += $ids->childs[0]->values['amount'];
            }

            // штучный товар
            $ids = Request_Request::findBranch('DB_Ab1_Shop_Piece_Item', 
                array(), $sitePageData, $driver, $params
            );
            if (count($ids->childs) > 0) {
                $amount += $ids->childs[0]->values['amount'];
            }

            $model->setBlockAmount($amount);
            Helpers_DB::saveDBObject($model, $sitePageData, $sitePageData->shopMainID);

            $total += $amount;
        }

        return $total;
    }

    /**
     * Сохранение список продукции договора
     * @param $shopID
     * @param Model_Ab1_Shop_Client_Contract $modelContract
     * @param array $shopClientContractItems
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @return array
     */
    public static function saveProduct($shopID, Model_Ab1_Shop_Client_Contract $modelContract, array $shopClientContractItems, SitePageData $sitePageData,
                                       Model_Driver_DBBasicDriver $driver)
    {
        $model = new Model_Ab1_Shop_Client_Contract_Item();
        $model->setDBDriver($driver);

        $params = Request_RequestParams::setParams(
            array(
                'shop_client_contract_id' => $modelContract->id,
                'sort_by' => array('id' => 'asc'),

            )
        );
        $shopClientContractItemIDs = Request_Request::find('DB_Ab1_Shop_Client_Contract_Item', 
            $sitePageData->shopMainID, $sitePageData, $driver, $params, 0, TRUE
        );
        $shopClientContractItemIDs->runIndex(true);

        $result = array(
            'amount' => 0,
            'quantity' => 0,
            'name' => '',
            'is_fixed_price' => false,
            'rubrics' => array(),
        );
        foreach($shopClientContractItems as $id => $shopClientContractItem){
            $shopProductID = intval(Arr::path($shopClientContractItem, 'shop_product_id', 0));
            $shopProductRubricID = intval(Arr::path($shopClientContractItem, 'shop_product_rubric_id', 0));

            $quantity = Request_RequestParams::strToFloat(Arr::path($shopClientContractItem, 'quantity', 0));
            $price =  Request_RequestParams::strToFloat(Arr::path($shopClientContractItem, 'price', 0));

            if(key_exists($id, $shopClientContractItemIDs->childs)){
                $shopClientContractItemIDs->childs[$id]->setModel($model);
                unset($shopClientContractItemIDs->childs[$id]);
            }else{
                $model->clear();
                $model->setShopClientContractID($modelContract->id);
            }

            $model->setIsFixedPrice(Request_RequestParams::isBoolean(Arr::path($shopClientContractItem, 'is_fixed_price', FALSE)));
            $model->setFromAt(Arr::path($shopClientContractItem, 'from_at', null));
            if(!$model->getIsFixedPrice()){
                $model->setFromAt(null);
            }elseif(Func::_empty($model->getFromAt())){
                $model->setFromAt(date('Y-m-d'));
            }
            $model->setAgreementNumber(Arr::path($shopClientContractItem, 'agreement_number', ''));

            $model->setShopProductID($shopProductID);
            $model->setShopProductRubricID($shopProductRubricID);
            $model->setShopClientID($modelContract->getShopClientID());
            $model->setBasicShopClientContractID($modelContract->getBasicShopClientContractID());
            $model->setIsAddBasicContract($modelContract->getIsAddBasicContract());
            $model->setQuantity($quantity);
            $model->setPrice($price);
            $model->setDiscount(Request_RequestParams::strToFloat(Arr::path($shopClientContractItem, 'discount', 0)));
            $model->setProductShopBranchID(Arr::path($shopClientContractItem, 'product_shop_branch_id', 0));

            if($shopProductID > 0){
                $modelItem = new Model_Ab1_Shop_Product();
                $id = $shopProductID;
            }else{
                $modelItem = new Model_Ab1_Shop_Product_Rubric();
                $id = $shopProductRubricID;
            }
            $modelItem->setDBDriver($driver);

            if(Helpers_DB::getDBObject($modelItem, $id, $sitePageData, 0)){
                $name = $modelItem->getName();
            }else{
                $name = 'Все';
            }

            $model->setName(
                'Продукция: <b>'.$name.'</b> на сумму: <b>'
                .Func::getPriceStr($sitePageData->currency, $model->getAmount())
                .'</b><br>'
            );

            Helpers_DB::saveDBObject($model, $sitePageData, $sitePageData->shopMainID);

            // собираем список родительских рубрик
            if($shopProductID > 0){
                $params = Request_RequestParams::setParams(
                    array(
                        'id' => $shopProductID,
                    )
                );
                $object = Request_Request::findOne(
                    'DB_Ab1_Shop_Product', 0, $sitePageData, $driver, $params, array('root_rubric_id' => array('id', 'name'))
                );
                if ($object != null){
                    $result['rubrics'][$object->getElementValue('root_rubric_id', 'id')] =
                        $object->getElementValue('root_rubric_id', 'name', '');
                }
            }else{
                $result['rubrics'][$shopProductRubricID] = $modelItem->getName();
            }

            $result['is_fixed_price'] = $result['is_fixed_price'] || $model->getIsFixedPrice();
            if(Func::_empty($model->getAgreementNumber())) {
                $result['amount'] += $model->getAmount();
                $result['quantity'] += $model->getQuantity();
                $result['name'] .= $model->getName();
            }
        }


        $ids = array();
        foreach ($shopClientContractItemIDs->childs as $child){
            if($child->values['shop_client_contract_id'] == $modelContract->id){
                $ids[] = $child->id;
            }
        }

        // удаляем лишние
        $driver->deleteObjectIDs(
            $ids, $sitePageData->userID,
            Model_Ab1_Shop_Client_Contract_Item::TABLE_NAME, array(), $sitePageData->shopMainID
        );

        return $result;
    }

    /**
     * Сохранение список материалы договора
     * @param $shopID
     * @param Model_Ab1_Shop_Client_Contract $modelContract
     * @param array $shopClientContractItems
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @return array
     */
    public static function saveMaterial($shopID, Model_Ab1_Shop_Client_Contract $modelContract, array $shopClientContractItems, SitePageData $sitePageData,
                                       Model_Driver_DBBasicDriver $driver)
    {
        $model = new Model_Ab1_Shop_Client_Contract_Item();
        $model->setDBDriver($driver);

        $params = Request_RequestParams::setParams(
            array(
                'shop_client_contract_id' => $modelContract->id,
                'sort_by' => array('id' => 'asc'),

            )
        );
        $shopClientContractItemIDs = Request_Request::find('DB_Ab1_Shop_Client_Contract_Item', 
            $sitePageData->shopMainID, $sitePageData, $driver, $params, 0, TRUE
        );
        $shopClientContractItemIDs->runIndex(true);

        $result = array(
            'amount' => 0,
            'quantity' => 0,
        );
        foreach($shopClientContractItems as $id => $shopClientContractItem){
            $shopMaterialID = intval(Arr::path($shopClientContractItem, 'shop_material_id', 0));

            $quantity = Request_RequestParams::strToFloat(Arr::path($shopClientContractItem, 'quantity', 0));
            $price =  Request_RequestParams::strToFloat(Arr::path($shopClientContractItem, 'price', 0));

            if(key_exists($id, $shopClientContractItemIDs->childs)){
                $shopClientContractItemIDs->childs[$id]->setModel($model);
                unset($shopClientContractItemIDs->childs[$id]);
            }else{
                $model->clear();
                $model->setShopClientContractID($modelContract->id);
            }

            $model->setShopMaterialID($shopMaterialID);
            $model->setShopClientID($modelContract->getShopClientID());
            $model->setBasicShopClientContractID($modelContract->getBasicShopClientContractID());
            $model->setIsAddBasicContract($modelContract->getIsAddBasicContract());
            $model->setQuantity($quantity);
            $model->setPrice($price);

            Helpers_DB::saveDBObject($model, $sitePageData, $sitePageData->shopMainID);

            $result['amount'] += $model->getAmount();
            $result['quantity'] += $model->getQuantity();
        }

        $ids = array();
        foreach ($shopClientContractItemIDs->childs as $child){
            if($child->values['shop_client_contract_id'] == $modelContract->id){
                $ids[] = $child->id;
            }
        }

        // удаляем лишние
        $driver->deleteObjectIDs(
            $ids, $sitePageData->userID,
            Model_Ab1_Shop_Client_Contract_Item::TABLE_NAME, array(), $sitePageData->shopMainID
        );

        return $result;
    }

    /**
     * Сохранение список топлива договора
     * @param $shopID
     * @param Model_Ab1_Shop_Client_Contract $modelContract
     * @param array $shopClientContractItems
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @return array
     */
    public static function saveFuel($shopID, Model_Ab1_Shop_Client_Contract $modelContract, array $shopClientContractItems, SitePageData $sitePageData,
                                    Model_Driver_DBBasicDriver $driver)
    {
        $model = new Model_Ab1_Shop_Client_Contract_Item();
        $model->setDBDriver($driver);

        $params = Request_RequestParams::setParams(
            array(
                'shop_client_contract_id' => $modelContract->id,
                'sort_by' => array('id' => 'asc'),

            )
        );
        $shopClientContractItemIDs = Request_Request::find('DB_Ab1_Shop_Client_Contract_Item', 
            $sitePageData->shopMainID, $sitePageData, $driver, $params, 0, TRUE
        );
        $shopClientContractItemIDs->runIndex(true);

        $result = array(
            'amount' => 0,
            'quantity' => 0,
        );
        foreach($shopClientContractItems as $id => $shopClientContractItem){
            $fuelID = intval(Arr::path($shopClientContractItem, 'fuel_id', 0));

            $quantity = Request_RequestParams::strToFloat(Arr::path($shopClientContractItem, 'quantity', 0));
            $price =  Request_RequestParams::strToFloat(Arr::path($shopClientContractItem, 'price', 0));

            if(key_exists($id, $shopClientContractItemIDs->childs)){
                $shopClientContractItemIDs->childs[$id]->setModel($model);
                unset($shopClientContractItemIDs->childs[$id]);
            }else{
                $model->clear();
                $model->setShopClientContractID($modelContract->id);
            }

            $model->setFuelID($fuelID);
            $model->setShopClientID($modelContract->getShopClientID());
            $model->setBasicShopClientContractID($modelContract->getBasicShopClientContractID());
            $model->setIsAddBasicContract($modelContract->getIsAddBasicContract());
            $model->setQuantity($quantity);
            $model->setPrice($price);

            Helpers_DB::saveDBObject($model, $sitePageData, $sitePageData->shopMainID);

            $result['amount'] += $model->getAmount();
            $result['quantity'] += $model->getQuantity();
        }

        $ids = array();
        foreach ($shopClientContractItemIDs->childs as $child){
            if($child->values['shop_client_contract_id'] == $modelContract->id){
                $ids[] = $child->id;
            }
        }

        // удаляем лишние
        $driver->deleteObjectIDs(
            $ids, $sitePageData->userID,
            Model_Ab1_Shop_Client_Contract_Item::TABLE_NAME, array(), $sitePageData->shopMainID
        );

        return $result;
    }

    /**
     * Сохранение список сырье договора
     * @param $shopID
     * @param Model_Ab1_Shop_Client_Contract $modelContract
     * @param array $shopClientContractItems
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @return array
     */
    public static function saveRaw($shopID, Model_Ab1_Shop_Client_Contract $modelContract, array $shopClientContractItems, SitePageData $sitePageData,
                                   Model_Driver_DBBasicDriver $driver)
    {
        $model = new Model_Ab1_Shop_Client_Contract_Item();
        $model->setDBDriver($driver);

        $params = Request_RequestParams::setParams(
            array(
                'shop_client_contract_id' => $modelContract->id,
                'sort_by' => array('id' => 'asc'),

            )
        );
        $shopClientContractItemIDs = Request_Request::find('DB_Ab1_Shop_Client_Contract_Item',
            $sitePageData->shopMainID, $sitePageData, $driver, $params, 0, TRUE
        );
        $shopClientContractItemIDs->runIndex(true);

        $result = array(
            'amount' => 0,
            'quantity' => 0,
        );
        foreach($shopClientContractItems as $id => $shopClientContractItem){
            $shopRawID = intval(Arr::path($shopClientContractItem, 'shop_raw_id', 0));

            $quantity = Request_RequestParams::strToFloat(Arr::path($shopClientContractItem, 'quantity', 0));
            $price =  Request_RequestParams::strToFloat(Arr::path($shopClientContractItem, 'price', 0));

            if(key_exists($id, $shopClientContractItemIDs->childs)){
                $shopClientContractItemIDs->childs[$id]->setModel($model);
                unset($shopClientContractItemIDs->childs[$id]);
            }else{
                $model->clear();
                $model->setShopClientContractID($modelContract->id);
            }

            $model->setShopRawID($shopRawID);
            $model->setShopClientID($modelContract->getShopClientID());
            $model->setBasicShopClientContractID($modelContract->getBasicShopClientContractID());
            $model->setIsAddBasicContract($modelContract->getIsAddBasicContract());
            $model->setQuantity($quantity);
            $model->setPrice($price);

            Helpers_DB::saveDBObject($model, $sitePageData, $sitePageData->shopMainID);

            $result['amount'] += $model->getAmount();
            $result['quantity'] += $model->getQuantity();
        }

        $ids = array();
        foreach ($shopClientContractItemIDs->childs as $child){
            if($child->values['shop_client_contract_id'] == $modelContract->id){
                $ids[] = $child->id;
            }
        }

        // удаляем лишние
        $driver->deleteObjectIDs(
            $ids, $sitePageData->userID,
            Model_Ab1_Shop_Client_Contract_Item::TABLE_NAME, array(), $sitePageData->shopMainID
        );

        return $result;
    }

    /**
     * Сохранение список позиций договора
     * @param $shopID
     * @param Model_Ab1_Shop_Client_Contract $modelContract
     * @param array $shopClientContractItems
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @return array
     */
    public static function save($shopID, Model_Ab1_Shop_Client_Contract $modelContract, array $shopClientContractItems, SitePageData $sitePageData,
                                   Model_Driver_DBBasicDriver $driver)
    {
        $model = new Model_Ab1_Shop_Client_Contract_Item();
        $model->setDBDriver($driver);

        $params = Request_RequestParams::setParams(
            array(
                'shop_client_contract_id' => $modelContract->id,
                'sort_by' => array('id' => 'asc'),

            )
        );
        $shopClientContractItemIDs = Request_Request::find('DB_Ab1_Shop_Client_Contract_Item', 
            $sitePageData->shopMainID, $sitePageData, $driver, $params, 0, TRUE
        );
        $shopClientContractItemIDs->runIndex(true);

        $result = array(
            'amount' => 0,
            'quantity' => 0,
        );
        foreach($shopClientContractItems as $id => $shopClientContractItem){
            $quantity = Request_RequestParams::strToFloat(Arr::path($shopClientContractItem, 'quantity', 0));
            $price =  Request_RequestParams::strToFloat(Arr::path($shopClientContractItem, 'price', 0));

            if(key_exists($id, $shopClientContractItemIDs->childs)){
                $shopClientContractItemIDs->childs[$id]->setModel($model);
                unset($shopClientContractItemIDs->childs[$id]);
            }else{
                $model->clear();
                $model->setShopClientContractID($modelContract->id);
            }

            $model->setName(Arr::path($shopClientContractItem, 'name', ''));
            $model->setUnit(Arr::path($shopClientContractItem, 'unit', ''));
            $model->setShopClientID($modelContract->getShopClientID());
            $model->setBasicShopClientContractID($modelContract->getBasicShopClientContractID());
            $model->setIsAddBasicContract($modelContract->getIsAddBasicContract());
            $model->setQuantity($quantity);
            $model->setPrice($price);

            Helpers_DB::saveDBObject($model, $sitePageData, $sitePageData->shopMainID);

            $result['amount'] += $model->getAmount();
            $result['quantity'] += $model->getQuantity();
        }

        $ids = array();
        foreach ($shopClientContractItemIDs->childs as $child){
            if($child->values['shop_client_contract_id'] == $modelContract->id){
                $ids[] = $child->id;
            }
        }

        // удаляем лишние
        $driver->deleteObjectIDs(
            $ids, $sitePageData->userID,
            Model_Ab1_Shop_Client_Contract_Item::TABLE_NAME, array(), $sitePageData->shopMainID
        );

        return $result;
    }
}
