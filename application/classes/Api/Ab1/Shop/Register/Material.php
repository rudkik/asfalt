<?php defined('SYSPATH') or die('No direct script access.');

class Api_Ab1_Shop_Register_Material  {
    const IS_CALC_BALANCE = false;

    /**
     * Материальный отчет остатков материалов при производстве, вывозе, заволе, перемещении, ответ.хранении и реализации
     * @param $dateFrom
     * @param $dateTo
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @return MyArray
     */
    public static function materialsReport($dateFrom, $dateTo, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        $ids = new MyArray(array(), true);
        $daughters = array();
        $receivers = array();
        $additionDatas = array(
            'receivers' => array(),
            'daughters' => array(),
            'total_receiver' => 0,
            'total_daughter' => 0,
            'total_make' => 0,
            'total_side' => 0,
            'total_realization' => 0,
            'total' => 0,
        );

        /*****************************/
        /***** Приход материалов *****/
        /*****************************/

        $params = Request_RequestParams::setParams(
            array(
                'sum_daughter_weight' => true,
                'date_document_from' => $dateFrom,
                'date_document_to' => $dateTo,
                'shop_branch_receiver_id' => $sitePageData->shopID,
                'shop_branch_daughter_id_not' => $sitePageData->shopID,
                'group_by' => array(
                    'shop_material_id', 'shop_material_id.name',
                    'shop_daughter_id', 'shop_daughter_id.name',
                    'shop_branch_daughter_id', 'shop_branch_daughter_id.name',
                ),
                'sort_by' => array(
                    'shop_daughter_id' => 'desc',
                    'shop_daughter_id.name' => 'asc',
                    'shop_branch_daughter_id.name' => 'asc',
                )
            )
        );
        $shopCarToMaterialIDs = Request_Request::find('DB_Ab1_Shop_Car_To_Material',
            $sitePageData->shopMainID, $sitePageData, $driver, $params, 0, TRUE,
            array(
                'shop_material_id' => array('name'),
                'shop_daughter_id' => array('name'),
                'shop_branch_daughter_id' => array('name'),
            )
        );

        foreach ($shopCarToMaterialIDs->childs as $child){
            $daughter = $child->values['shop_daughter_id'].'_'.$child->values['shop_branch_daughter_id'];
            if(!key_exists($daughter, $daughters)){
                $daughters[$daughter] = array(
                    'shop_daughter_id' => $child->values['shop_daughter_id'],
                    'shop_branch_daughter_id' => $child->values['shop_branch_daughter_id'],
                    'name' => $child->getElementValue('shop_daughter_id', 'name',
                        $child->getElementValue('shop_branch_daughter_id')),
                );
            }

            $material = $child->values['shop_material_id'];
            if(!key_exists($material, $ids->childs)){
                $ids->addChildObjectIndex($material, $child);
                $child->additionDatas = $additionDatas;
            }

            if(!key_exists($daughter, $ids->childs[$material]->additionDatas['daughters'])){
                $ids->childs[$material]->additionDatas['daughters'][$daughter] = 0;
            }

            $quantity = $child->values['quantity'];
            $ids->childs[$material]->additionDatas['daughters'][$daughter] += $quantity;
            $ids->childs[$material]->additionDatas['total_daughter'] += $quantity;
        }

        /****************************/
        /***** Вывоз материалов *****/
        /****************************/

        $params = Request_RequestParams::setParams(
            array(
                'sum_daughter_weight' => true,
                'date_document_from' => $dateFrom,
                'date_document_to' => $dateTo,
                'shop_branch_daughter_id' => $sitePageData->shopID,
                'shop_branch_receiver_id_not' => $sitePageData->shopID,
                'group_by' => array(
                    'shop_material_id', 'shop_material_id.name',
                    'shop_branch_receiver_id', 'shop_branch_receiver_id.name',
                )
            )
        );
        $shopCarToMaterialIDs = Request_Request::find('DB_Ab1_Shop_Car_To_Material',
            $sitePageData->shopMainID, $sitePageData, $driver, $params, 0, TRUE,
            array(
                'shop_material_id' => array('name'),
                'shop_branch_receiver_id' => array('name'),
            )
        );

        foreach ($shopCarToMaterialIDs->childs as $child){
            $receiver = $child->values['shop_branch_receiver_id'];
            if(!key_exists($receiver, $receivers)){
                $receivers[$receiver] = array(
                    'shop_branch_receiver_id' => $child->values['shop_branch_receiver_id'],
                    'name' => $child->getElementValue('shop_branch_receiver_id'),
                );
            }

            $material = $child->values['shop_material_id'];
            if(!key_exists($material, $ids->childs)){
                $ids->addChildObjectIndex($material, $child);
                $child->additionDatas = $additionDatas;
            }

            if(!key_exists($receiver, $ids->childs[$material]->additionDatas['receivers'])){
                $ids->childs[$material]->additionDatas['receivers'][$receiver] = 0;
            }

            $quantity = $child->values['quantity'];
            $ids->childs[$material]->additionDatas['receivers'][$receiver] += $quantity;
            $ids->childs[$material]->additionDatas['total_receiver'] += $quantity;
        }

        /*******************************************************************************/
        /***** Расход материалов на производство исключая первый уровень продукции *****/
        /*******************************************************************************/

        $params = Request_RequestParams::setParams(
            array(
                'sum_quantity' => true,
                'created_at_from' => $dateFrom,
                'created_at_to' => $dateTo,
                'quantity_less' => 0,
                'shop_formula_product_id' => 0,
                'is_side' => false,
                'table_id' => array(
                    Model_Ab1_Shop_Car::TABLE_ID,
                    Model_Ab1_Shop_Piece_Item::TABLE_ID,
                    Model_Ab1_Shop_Move_Car::TABLE_ID,
                    Model_Ab1_Shop_Defect_Car::TABLE_ID,
                    Model_Ab1_Shop_Lessee_Car::TABLE_ID,
                    Model_Ab1_Shop_Product_Storage::TABLE_ID,
                ),
                'group_by' => array(
                    'shop_material_id', 'shop_material_id.name',
                )
            )
        );
        $shopRegisterMaterialIDs = Request_Request::find(
            'DB_Ab1_Shop_Register_Material', $sitePageData->shopID, $sitePageData, $driver, $params,
            0, TRUE,
            array(
                'shop_material_id' => array('name'),
            )
        );

        foreach ($shopRegisterMaterialIDs->childs as $child){
            $material = $child->values['shop_material_id'];
            if(!key_exists($material, $ids->childs)){
                $ids->addChildObjectIndex($material, $child);
                $child->additionDatas = $additionDatas;
            }

            $quantity = $child->values['quantity'];
            $ids->childs[$material]->additionDatas['total_make'] -= $quantity;
        }

        /**************************************************************************************************/
        /***** Расход материалов на производство первого уровеня продукции исключая соотношения 1 к 1 *****/
        /**************************************************************************************************/

        $params = Request_RequestParams::setParams(
            array(
                'sum_quantity' => true,
                'created_at_from' => $dateFrom,
                'created_at_to' => $dateTo,
                'quantity_less' => 0,
                'shop_formula_product_id_from' => 0,
                'shop_product_id.shop_material_id' => 0,
                'is_side' => false,
                'table_id' => array(
                    Model_Ab1_Shop_Car::TABLE_ID,
                    Model_Ab1_Shop_Piece_Item::TABLE_ID,
                    Model_Ab1_Shop_Move_Car::TABLE_ID,
                    Model_Ab1_Shop_Defect_Car::TABLE_ID,
                    Model_Ab1_Shop_Lessee_Car::TABLE_ID,
                    Model_Ab1_Shop_Product_Storage::TABLE_ID,
                ),
                'group_by' => array(
                    'shop_material_id', 'shop_material_id.name',
                )
            )
        );
        $shopRegisterMaterialIDs = Request_Request::find(
            'DB_Ab1_Shop_Register_Material', $sitePageData->shopID, $sitePageData, $driver, $params,
            0, TRUE,
            array(
                'shop_material_id' => array('name'),
            )
        );

        foreach ($shopRegisterMaterialIDs->childs as $child){
            $material = $child->values['shop_material_id'];
            if(!key_exists($material, $ids->childs)){
                $ids->addChildObjectIndex($material, $child);
                $child->additionDatas = $additionDatas;
            }

            $quantity = $child->values['quantity'];
            $ids->childs[$material]->additionDatas['total_make'] -= $quantity;
        }

        /*********************************/
        /***** Побочное производство *****/
        /*********************************/

        $params = Request_RequestParams::setParams(
            array(
                'sum_quantity' => true,
                'created_at_from' => $dateFrom,
                'created_at_to' => $dateTo,
                'is_side' => true,
                'table_id' => array(
                    Model_Ab1_Shop_Car::TABLE_ID,
                    Model_Ab1_Shop_Piece_Item::TABLE_ID,
                    Model_Ab1_Shop_Move_Car::TABLE_ID,
                    Model_Ab1_Shop_Defect_Car::TABLE_ID,
                    Model_Ab1_Shop_Lessee_Car::TABLE_ID,
                    Model_Ab1_Shop_Product_Storage::TABLE_ID,
                ),
                'group_by' => array(
                    'shop_material_id', 'shop_material_id.name',
                )
            )
        );
        $shopRegisterMaterialIDs = Request_Request::find(
            'DB_Ab1_Shop_Register_Material', $sitePageData->shopID, $sitePageData, $driver, $params,
            0, TRUE,
            array(
                'shop_material_id' => array('name'),
            )
        );

        foreach ($shopRegisterMaterialIDs->childs as $child){
            $material = $child->values['shop_material_id'];
            if(!key_exists($material, $ids->childs)){
                $ids->addChildObjectIndex($material, $child);
                $child->additionDatas = $additionDatas;
            }

            $quantity = $child->values['quantity'];
            $ids->childs[$material]->additionDatas['total_side'] = $quantity;
        }

        /******************************************************************************************/
        /***** Реализация материалов производство первого уровеня продукции соотношения 1 к 1 *****/
        /******************************************************************************************/

        $params = Request_RequestParams::setParams(
            array(
                'sum_quantity' => true,
                'created_at_from' => $dateFrom,
                'created_at_to' => $dateTo,
                'quantity_less' => 0,
                'shop_formula_product_id_from' => 0,
                'shop_product_id.shop_material_id_from' => 0,
                'is_side' => false,
                'table_id' => array(
                    Model_Ab1_Shop_Car::TABLE_ID,
                    Model_Ab1_Shop_Piece_Item::TABLE_ID,
                    Model_Ab1_Shop_Move_Car::TABLE_ID,
                    Model_Ab1_Shop_Defect_Car::TABLE_ID,
                    Model_Ab1_Shop_Lessee_Car::TABLE_ID,
                    Model_Ab1_Shop_Product_Storage::TABLE_ID,
                ),
                'group_by' => array(
                    'shop_material_id', 'shop_material_id.name',
                )
            )
        );
        $shopRegisterMaterialIDs = Request_Request::find(
            'DB_Ab1_Shop_Register_Material', $sitePageData->shopID, $sitePageData, $driver, $params,
            0, TRUE,
            array(
                'shop_material_id' => array('name'),
            )
        );

        foreach ($shopRegisterMaterialIDs->childs as $child){
            $material = $child->values['shop_material_id'];
            if(!key_exists($material, $ids->childs)){
                $ids->addChildObjectIndex($material, $child);
                $child->additionDatas = $additionDatas;
            }

            $quantity = $child->values['quantity'];
            $ids->childs[$material]->additionDatas['total_realization'] -= $quantity;
        }

        /*******************/
        /***** Остатки *****/
        /*******************/

        $params = Request_RequestParams::setParams(
            array(
                'sum_quantity' => true,
                'created_at_from' => $dateFrom,
                'created_at_to' => $dateTo,
                'shop_material_id.is_weighted' => true,
                'group_by' => array(
                    'shop_material_id', 'shop_material_id.name',
                )
            )
        );
        $shopRegisterMaterialIDs = Request_Request::find(
            'DB_Ab1_Shop_Register_Material', $sitePageData->shopID, $sitePageData, $driver, $params,
            0, TRUE,
            array(
                'shop_material_id' => array('name'),
            )
        );

        foreach ($shopRegisterMaterialIDs->childs as $child){
            $quantity = $child->values['quantity'];
            if($quantity == 0){
                continue;
            }

            $material = $child->values['shop_material_id'];
            if(!key_exists($material, $ids->childs)){
                $ids->addChildObjectIndex($material, $child);
                $child->additionDatas = $additionDatas;
            }

            $ids->childs[$material]->additionDatas['total'] -= $quantity;
        }

        $ids->additionDatas['daughters'] = $daughters;
        $ids->additionDatas['receivers'] = $receivers;
        return $ids;
    }


    /**
     * Считаем по формуле сколько необходимо материала использовать
     * @param $quantity
     * @param MyArray $formulaItem
     * @param $isSide
     * @return float
     */
    private static function getQuantityFormula($quantity, MyArray $formulaItem, $isSide){
        $normWeight = $formulaItem->values['norm_weight'];
        if($normWeight > 0){
            $normWeight = $normWeight / 100 * (100 + $formulaItem->values['losses']);
            $quantity = $quantity * $normWeight;

            $coefficientRecipe = $formulaItem->getElementValue('shop_material_id', 'coefficient_recipe',
                $formulaItem->getElementValue('shop_raw_id', 'coefficient_recipe', 1));
            if($coefficientRecipe > 0){
                $quantity = $quantity / $coefficientRecipe;
            }
        }else{
            $quantity = $quantity / 100 * $formulaItem->values['norm'] + $formulaItem->values['losses'];
        }

        if(!$isSide){
            $quantity = $quantity * -1;
        }

        return round($quantity, 3);
    }

    /**
     * Сохранение производство материала из сырья
     * @param Model_Ab1_Shop_Raw_Material $modelRawMaterial
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @return boolean
     */
    public static function saveShopRawMaterial(Model_Ab1_Shop_Raw_Material $modelRawMaterial, SitePageData $sitePageData,
                                               Model_Driver_DBBasicDriver $driver)
    {
        $params = Request_RequestParams::setParams(
            array(
                'shop_object_id' => $modelRawMaterial->id,
                'table_id' => Model_Ab1_Shop_Raw_Material::TABLE_ID,
                'sort_by' => array(
                    'id' => 'asc'
                )
            )
        );
        $shopRegisterMaterialIDs = Request_Request::find(
            'DB_Ab1_Shop_Register_Material', $sitePageData->shopID, $sitePageData, $driver, $params,
            0, TRUE
        );

        if($modelRawMaterial->getIsDelete()){
            // удаляем лишние
            $driver->deleteObjectIDs(
                $shopRegisterMaterialIDs->getChildArrayID(), $sitePageData->userID,
                Model_Ab1_Shop_Register_Material::TABLE_NAME, array(), $sitePageData->shopID
            );

            return true;
        }

        $params = Request_RequestParams::setParams(
            array(
                'shop_raw_material_id' => $modelRawMaterial->id,
                'shop_material_id_from' => 0,
                'sort_by' => array(
                    'id' => 'asc'
                )
            )
        );
        $shopRawMaterialItemIDs = Request_Request::find(
            'DB_Ab1_Shop_Raw_Material_Item', $sitePageData->shopID, $sitePageData, $driver, $params,
            0, TRUE
        );
        $model = new Model_Ab1_Shop_Register_Material();
        $model->setDBDriver($driver);

        $materials = array();
        foreach ($shopRawMaterialItemIDs->childs as $child){
            $material = $child->values['shop_material_id'];
            $materials[$material] = $material;
        }

        foreach ($shopRawMaterialItemIDs->childs as $child){
            /** @var Model_Ab1_Shop_Raw_Material_Item $modelRawMaterialItem */
            $modelRawMaterialItem = $child->createModel('DB_Ab1_Shop_Raw_Material_Item');

            $shopRegisterMaterialIDs->childShiftSetModel($model);
            $model->setShopObjectID($modelRawMaterial->id);
            $model->setTableID(Model_Ab1_Shop_Raw_Material::TABLE_ID);

            $model->setQuantity($modelRawMaterialItem->getQuantity());

            $model->setShopSubdivisionID($modelRawMaterialItem->getShopSubdivisionID());
            $model->setShopHeapID($modelRawMaterialItem->getShopHeapID());
            $model->setShopFormulaRawID($modelRawMaterialItem->getShopFormulaRawID());
            $model->setShopBallastCrusherID($modelRawMaterialItem->getShopBallastCrusherID());
            $model->setShopMaterialID($modelRawMaterialItem->getShopMaterialID());
            $model->setCreatedAt($modelRawMaterial->getCreatedAt());

            Helpers_DB::saveDBObject($model, $sitePageData);

            $material = $modelRawMaterialItem->getShopMaterialID();
            $materials[$material] = $material;
        }

        // удаляем лишние
        $driver->deleteObjectIDs(
            $shopRegisterMaterialIDs->getChildArrayID(), $sitePageData->userID,
            Model_Ab1_Shop_Register_Material::TABLE_NAME, array(), $sitePageData->shopID
        );

        // пересчитываем остатки удаленных материалов
        foreach ($shopRegisterMaterialIDs->childs as $child){
            self::calcMaterialBalance(
                $child->values['shop_material_id'],
                $child->values['shop_subdivision_id'],
                $child->values['shop_heap_id'],
                $sitePageData, $driver, true,
                $child->values['shop_id']
            );
        }

        // пересчитываем остатки
        foreach ($materials as $material){
            self::calcMaterialBalance(
                $material, $modelRawMaterial->getShopSubdivisionID(), $modelRawMaterial->getShopHeapID(),
                $sitePageData, $driver, true, $modelRawMaterial->shopID
            );
        }

        if($modelRawMaterial->getShopSubdivisionID() != $modelRawMaterial->getOriginalValue('shop_subdivision_id')
            || $modelRawMaterial->getShopHeapID() != $modelRawMaterial->getOriginalValue('shop_heap_id')){
            foreach ($materials as $material){
                self::calcMaterialBalance(
                    $material,
                    $modelRawMaterial->getOriginalValue('shop_subdivision_id'),
                    $modelRawMaterial->getOriginalValue('shop_heap_id'),
                    $sitePageData, $driver, true,
                    $modelRawMaterial->shopID
                );
            }
        }

        return true;
    }

    /**
     * Сохранение всё производство материала из сырья
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     */
    public static function saveShopRawMaterials(SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        $params = Request_RequestParams::setParams(
            array(
                'shop_formula_product_id' => 0,
                'sort_by' => array(
                    'id' => 'asc'
                )
            )
        );
        $ids = Request_Request::findBranch(
            'DB_Ab1_Shop_Raw_Material', array(), $sitePageData, $driver, $params,
            0, TRUE
        );

        foreach ($ids->childs as $child){
            /** @var Model_Ab1_Shop_Raw_Material $model */
            $model = $child->createModel('DB_Ab1_Shop_Raw_Material', $driver);

            self::saveShopRawMaterial($model, $sitePageData, $driver);
        }
    }

    /**
     * Сохранение расход / приход материала ввоза / вывоза / покупки
     * @param Model_Ab1_Shop_Car_To_Material $modelCarToMaterial
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @return boolean
     */
    public static function saveShopCarToMaterial(Model_Ab1_Shop_Car_To_Material $modelCarToMaterial,
                                                 SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        if($modelCarToMaterial->getQuantityFact() < 0){
            return false;
        }

        $params = Request_RequestParams::setParams(
            array(
                'shop_object_id' => $modelCarToMaterial->id,
                'table_id' => Model_Ab1_Shop_Car_To_Material::TABLE_ID,
                'sort_by' => array(
                    'id' => 'asc'
                ),
            )
        );
        $shopRegisterMaterialIDs = Request_Request::findBranch(
            'DB_Ab1_Shop_Register_Material', array(), $sitePageData, $driver, $params,
            0, TRUE
        );

        if($modelCarToMaterial->getShopBranchReceiverID() < 1){
            $modelCarToMaterial->setShopBranchReceiverID($modelCarToMaterial->shopID);
        }

        $model = new Model_Ab1_Shop_Register_Material();
        $model->setDBDriver($driver);

        // фиксируем приход материалов
        $shopRegisterMaterialIDs->childShiftSetModel($model, 0, $modelCarToMaterial->getShopBranchReceiverID());
        $model->setShopObjectID($modelCarToMaterial->id);
        $model->setTableID(Model_Ab1_Shop_Car_To_Material::TABLE_ID);

        $model->setQuantity($modelCarToMaterial->getQuantityFact());
        $model->setShopTransportCompanyID($modelCarToMaterial->getShopTransportCompanyID());
        $model->setShopSubdivisionID($modelCarToMaterial->getShopSubdivisionReceiverID());
        $model->setShopHeapID($modelCarToMaterial->getShopHeapReceiverID());
        $model->setShopMaterialID($modelCarToMaterial->getShopMaterialID());
        $model->setCreatedAt($modelCarToMaterial->getCreatedAt());

        Helpers_DB::saveDBObject($model, $sitePageData, $modelCarToMaterial->getShopBranchReceiverID());

        // фиксируем расход материалов
        if($modelCarToMaterial->getShopBranchDaughterID() > 0){
            $shopRegisterMaterialIDs->childShiftSetModel($model, 0, $modelCarToMaterial->getShopBranchDaughterID());
            $model->setShopObjectID($modelCarToMaterial->id);
            $model->setTableID(Model_Ab1_Shop_Car_To_Material::TABLE_ID);

            $model->setQuantity($modelCarToMaterial->getQuantityFact() * (-1));
            $model->setShopTransportCompanyID($modelCarToMaterial->getShopTransportCompanyID());
            $model->setShopSubdivisionID($modelCarToMaterial->getShopSubdivisionDaughterID());
            $model->setShopHeapID($modelCarToMaterial->getShopHeapDaughterID());
            $model->setShopMaterialID($modelCarToMaterial->getShopMaterialID());
            $model->setCreatedAt($modelCarToMaterial->getCreatedAt());

            Helpers_DB::saveDBObject($model, $sitePageData, $modelCarToMaterial->getShopBranchDaughterID());
        }

        // удаляем лишние
        $driver->deleteObjectIDs(
            $shopRegisterMaterialIDs->getChildArrayID(), $sitePageData->userID,
            Model_Ab1_Shop_Register_Material::TABLE_NAME, array(), 0
        );

        // пересчитываем баланс материала
        self::calcMaterialBalance(
            $modelCarToMaterial->getShopMaterialID(),
            $modelCarToMaterial->getShopSubdivisionReceiverID(),
            $modelCarToMaterial->getShopHeapReceiverID(),
            $sitePageData, $driver, true,
            $modelCarToMaterial->getShopBranchReceiverID()
        );

        // пересчитываем предыдущего баланс материала
        if($modelCarToMaterial->getShopMaterialID() != $modelCarToMaterial->getOriginalValue('shop_material_id')
            || $modelCarToMaterial->getShopSubdivisionReceiverID() != $modelCarToMaterial->getOriginalValue('shop_subdivision_receiver_id')
            || $modelCarToMaterial->getShopHeapReceiverID() != $modelCarToMaterial->getOriginalValue('shop_heap_receiver_id')
            || $modelCarToMaterial->getShopBranchReceiverID() != $modelCarToMaterial->getOriginalValue('shop_branch_receiver_id')){
            self::calcMaterialBalance(
                $modelCarToMaterial->getOriginalValue('shop_material_id'),
                $modelCarToMaterial->getOriginalValue('shop_subdivision_receiver_id'),
                $modelCarToMaterial->getOriginalValue('shop_heap_receiver_id'),
                $sitePageData, $driver, true,
                $modelCarToMaterial->getOriginalValue('shop_branch_receiver_id')
            );
        }

        // фиксируем расход материалов
        if($modelCarToMaterial->getShopBranchDaughterID() > 0) {
            // пересчитываем баланс материала
            $total = self::calcMaterialBalance(
                $modelCarToMaterial->getShopMaterialID(),
                $modelCarToMaterial->getShopSubdivisionDaughterID(),
                $modelCarToMaterial->getShopHeapDaughterID(),
                $sitePageData, $driver, true,
                $modelCarToMaterial->getShopBranchDaughterID()
            );

            // пересчитываем предыдущего баланс материала
            if ($modelCarToMaterial->getShopMaterialID() != $modelCarToMaterial->getOriginalValue('shop_material_id')
                || $modelCarToMaterial->getShopSubdivisionDaughterID() != $modelCarToMaterial->getOriginalValue('shop_subdivision_daughter_id')
                || $modelCarToMaterial->getShopHeapDaughterID() != $modelCarToMaterial->getOriginalValue('shop_heap_daughter_id')
                || $modelCarToMaterial->getShopBranchDaughterID() != $modelCarToMaterial->getOriginalValue('shop_branch_daughter_id')) {
                self::calcMaterialBalance(
                    $modelCarToMaterial->getOriginalValue('shop_material_id'),
                    $modelCarToMaterial->getOriginalValue('shop_subdivision_daughter_id'),
                    $modelCarToMaterial->getOriginalValue('shop_heap_daughter_id'),
                    $sitePageData, $driver, true,
                    $modelCarToMaterial->getOriginalValue('shop_branch_daughter_id')
                );
            }

            // провеяем, есть ли в наличие данный материал, если нет то создаем его по рецепту
            if($total < $modelCarToMaterial->getQuantityFact()){
                // производство материала
                self::makeShopCarToMaterial($modelCarToMaterial, $sitePageData, $driver);
            }
        }

        return true;
    }

    /**
     * Сохранение все расход / приход материала ввоза / вывоза / покупки
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     */
    public static function saveShopCarToMaterials(SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        $params = Request_RequestParams::setParams(
            array(
                'shop_formula_product_id' => 0,
                'sort_by' => array(
                    'id' => 'asc'
                )
            )
        );
        $ids = Request_Request::findBranch(
            'DB_Ab1_Shop_Car_To_Material', array(), $sitePageData, $driver, $params,
            0, TRUE
        );

        foreach ($ids->childs as $child){
            /** @var Model_Ab1_Shop_Car_To_Material $model */
            $model = $child->createModel('DB_Ab1_Shop_Car_To_Material', $driver);

            self::saveShopCarToMaterial($model, $sitePageData, $driver);
        }
    }

    /**
     * Производство материала
     * @param $rootShopRegisterMaterialID
     * @param $shopObjectID
     * @param $date
     * @param $quantity
     * @param $shopMaterialID
     * @param $shopSubdivisionID
     * @param $shopHeapID
     * @param $tableID
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @param $number
     * @param $shopID
     * @param $level
     * @return array
     */
    private static function _makeShopMaterial($rootShopRegisterMaterialID, $shopObjectID, $date, $quantity, $shopMaterialID,
                                              $shopSubdivisionID, $shopHeapID, $tableID,
                                              SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver, &$number,
                                              $shopID, $level)
    {
        $params = Request_RequestParams::setParams(
            array(
                'shop_formula_material_id.shop_material_id' => $shopMaterialID,
                'from_at_to' => $date,
                'to_at_from_equally' => $date,
                'sort_by' => array(
                    'id' => 'asc'
                ),
            )
        );
        $shopFormulaMaterialItemIDs = Request_Request::find(
            'DB_Ab1_Shop_Formula_Material_Item', $shopID, $sitePageData, $driver, $params, 0, TRUE,
            array(
                'shop_material_id' => array('coefficient_recipe'),
                'shop_raw_id' => array('coefficient_recipe'),
            )
        );

        if(count($shopFormulaMaterialItemIDs->childs) < 1){
            return array(
                'materials' => [],
                'raws' => [],
            );
        }

        /*** Фиксируем материал производства ***/
        $shopFormulaMaterialID = $shopFormulaMaterialItemIDs->childs[0]->values['shop_formula_material_id'];

        $model = new Model_Ab1_Shop_Register_Material();
        $model->setDBDriver($driver);

        $model->setShopMaterialID($shopMaterialID);
        $model->setTableID($tableID);
        $model->setShopObjectID($shopObjectID);
        $model->setQuantity($quantity);
        $model->setShopSubdivisionID($shopSubdivisionID);
        $model->setShopHeapID($shopHeapID);
        $model->setRootShopRegisterMaterialID($rootShopRegisterMaterialID);
        $model->setRootShopRegisterRawID(0);
        $model->setLevel($level);
        $model->setShopFormulaMaterialID($shopFormulaMaterialID);
        $model->setShopFormulaRawID(0);
        $model->setShopFormulaProductID(0);
        $model->setCreatedAt($date);

        Helpers_DB::saveDBObject($model, $sitePageData, $shopID);

        /****** Фиксируем производство по рецепту ******/
        $quantities = array();
        foreach ($shopFormulaMaterialItemIDs->childs as $child){
            if($child->values['shop_raw_id'] > 0){
                $model = new Model_Ab1_Shop_Register_Raw();
                $model->setShopRawID($child->values['shop_raw_id']);
            }else{
                $model = new Model_Ab1_Shop_Register_Material();
                $model->setShopMaterialID($child->values['shop_material_id']);
                $model->setShopFormulaProductID(0);
            }
            $model->setDBDriver($driver);

            $model->setTableID($tableID);
            $model->setShopObjectID($shopObjectID);
            $model->setQuantity(self::getQuantityFormula($quantity, $child, false));
            $model->setShopSubdivisionID($shopSubdivisionID);
            $model->setShopHeapID($shopHeapID);
            $model->setRootShopRegisterMaterialID($rootShopRegisterMaterialID);
            $model->setRootShopRegisterRawID(0);
            $model->setLevel($level);
            $model->setShopFormulaMaterialID($shopFormulaMaterialID);
            $model->setShopFormulaRawID(0);
            $model->setCreatedAt($date);

            Helpers_DB::saveDBObject($model, $sitePageData, $shopID);

            if($child->values['shop_material_id'] > 0) {
                $quantities[$model->getShopMaterialID()] = [
                    'id' => $model->id,
                    'quantity' => $model->getQuantity() * -1,
                ];
            }
        }

        $raws = $shopFormulaMaterialItemIDs->getChildArrayInt('shop_raw_id', true);
        $materials = $shopFormulaMaterialItemIDs->getChildArrayInt('shop_material_id', true);

        /****** Проверяем нужно ли произвести под материалы по рецептам ******/
        $number++;
        $level++;
        if($number > 10) {
            foreach ($shopFormulaMaterialItemIDs->childs as $child){
                $material = $child->values['shop_material_id'];
                if($material < 1 || !key_exists($material, $quantities)){
                    continue;
                }

                $quantity = self::calcMaterialBalance(
                    $material, $shopSubdivisionID, $shopHeapID, $sitePageData, $driver, false, $shopID, $shopObjectID
                );

                if ($quantity < $quantities[$material]) {
                    $ids = self::_makeShopMaterial(
                        $quantities[$material]['id'], $shopObjectID, $date, $quantities[$material]['quantity'], $material,
                        $shopSubdivisionID, $shopHeapID, $tableID, $sitePageData, $driver, $number, $shopID, $level
                    );

                    foreach ($ids['materials'] as $material) {
                        $materials[$material] = $material;
                    }
                    foreach ($ids['raws'] as $raw) {
                        $raws[$raw] = $raw;
                    }
                }

            }
        }

        return array(
            'materials' => $materials,
            'raws' => $raws,
        );
    }

    /**
     * Производство материала
     * @param $rootShopRegisterMaterialID
     * @param $shopObjectID
     * @param $date
     * @param $quantity
     * @param $shopMaterialID
     * @param $shopSubdivisionID
     * @param $shopHeapID
     * @param $tableID
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @param int $shopID
     * @param bool $isDeleteRegister
     * @param int $level
     * @return array
     */
    public static function makeShopMaterial($rootShopRegisterMaterialID, $shopObjectID, $date, $quantity, $shopMaterialID,
                                            $shopSubdivisionID, $shopHeapID, $tableID,
                                            SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver, $shopID = 0,
                                            $isDeleteRegister = true, $level = 0)
    {
        if($shopID < 1){
            $shopID = $sitePageData->shopID;
        }

        $params = Request_RequestParams::setParams(
            array(
                'shop_formula_material_id.shop_material_id' => $shopMaterialID,
                'from_at_to' => $date,
                'to_at_from_equally' => $date,
                'sort_by' => array(
                    'id' => 'asc'
                ),
            )
        );
        $shopFormulaMaterialItemIDs = Request_Request::find(
            'DB_Ab1_Shop_Formula_Material_Item', $shopID, $sitePageData, $driver, $params, 0, TRUE,
            array(
                'shop_material_id' => array('coefficient_recipe'),
                'shop_raw_id' => array('coefficient_recipe'),
            )
        );

        $params = Request_RequestParams::setParams(
            array(
                'shop_object_id' => $shopObjectID,
                'table_id' => $tableID,
                'is_delete' => !$isDeleteRegister,
                'sort_by' => array(
                    'id' => 'asc'
                ),

            )
        );
        $shopRegisterMaterialIDs = Request_Request::findBranch(
            'DB_Ab1_Shop_Register_Material', array(), $sitePageData, $driver, $params,
            0, TRUE
        );
        $shopRegisterRawIDs = Request_Request::findBranch(
            'DB_Ab1_Shop_Register_Raw', array(), $sitePageData, $driver, $params,
            0, TRUE
        );

        /****** Какие материалы и сырье необходимо пересчитать ******/
        $materials = $shopRegisterMaterialIDs->getChildArrayInt('shop_material_id', true);
        $raws = $shopRegisterRawIDs->getChildArrayInt('shop_raw_id', true);

        if(count($shopFormulaMaterialItemIDs->childs) < 1){
            // удаляем лишние
            $driver->deleteObjectIDs(
                $shopRegisterMaterialIDs->getChildArrayID(), $sitePageData->userID,
                Model_Ab1_Shop_Register_Material::TABLE_NAME, array(), 0
            );
            $driver->deleteObjectIDs(
                $shopRegisterRawIDs->getChildArrayID(), $sitePageData->userID,
                Model_Ab1_Shop_Register_Raw::TABLE_NAME, array(), 0
            );

            return array(
                'materials' => $materials,
                'raws' => $raws,
            );
        }

        foreach ($shopFormulaMaterialItemIDs->childs as $child){
            $raw = $child->values['shop_raw_id'];
            if($child->values['shop_raw_id'] > 0){
                $raws[$raw] = 0;
            }else{
                $material = $child->values['shop_material_id'];
                $materials[$material] = 0;
            }
        }

        /*** Фиксируем материал производства ***/
        $shopFormulaMaterialID = $shopFormulaMaterialItemIDs->childs[0]->values['shop_formula_material_id'];

        $model = new Model_Ab1_Shop_Register_Material();
        $shopRegisterMaterialIDs->childShiftSetModel(
            $model, 0, $shopID, false, array('shop_material_id' => $shopMaterialID)
        );
        $model->setShopMaterialID($shopMaterialID);
        $model->setDBDriver($driver);

        $model->setTableID($tableID);
        $model->setShopObjectID($shopObjectID);
        $model->setQuantity($quantity);
        $model->setShopSubdivisionID($shopSubdivisionID);
        $model->setShopHeapID($shopHeapID);
        $model->setIsDelete(false);
        $model->setRootShopRegisterMaterialID($rootShopRegisterMaterialID);
        $model->setRootShopRegisterRawID(0);
        $model->setLevel($level);
        $model->setShopFormulaMaterialID($shopFormulaMaterialID);
        $model->setCreatedAt($date);

        Helpers_DB::saveDBObject($model, $sitePageData, $shopID);

        /****** Фиксируем производство по рецепту ******/
        $quantities = array();
        foreach ($shopFormulaMaterialItemIDs->childs as $child){
            if($child->values['shop_raw_id'] > 0){
                $model = new Model_Ab1_Shop_Register_Raw();
                $shopRegisterRawIDs->childShiftSetModel(
                    $model, 0, $shopID, false, array('shop_raw_id' => $child->values['shop_raw_id'])
                );
                $model->setShopRawID($child->values['shop_raw_id']);
            }else{
                $model = new Model_Ab1_Shop_Register_Material();
                $shopRegisterMaterialIDs->childShiftSetModel(
                    $model, 0, $shopID, false, array('shop_material_id' => $child->values['shop_material_id'])
                );
                $model->setShopMaterialID($child->values['shop_material_id']);
                $model->setShopFormulaProductID(0);
                $model->setIsSide($child->values['is_side']);
            }
            $model->setDBDriver($driver);

            $model->setTableID($tableID);
            $model->setShopObjectID($shopObjectID);
            $model->setQuantity(self::getQuantityFormula($quantity, $child, Request_RequestParams::isBoolean($child->values['is_side'])));
            $model->setShopSubdivisionID($shopSubdivisionID);
            $model->setShopHeapID($shopHeapID);
            $model->setIsDelete(false);
            $model->setRootShopRegisterMaterialID($rootShopRegisterMaterialID);
            $model->setRootShopRegisterRawID(0);
            $model->setLevel($level);
            $model->setShopFormulaMaterialID($shopFormulaMaterialID);
            $model->setShopFormulaRawID(0);
            $model->setCreatedAt($date);

            Helpers_DB::saveDBObject($model, $sitePageData, $shopID);

            if($child->values['shop_material_id'] > 0 && $child->values['is_side'] == 0) {
                $quantities[$model->getShopMaterialID()] = [
                    'id' => $model->id,
                    'quantity' => $model->getQuantity() * -1,
                ];
            }
        }

        // удаляем лишние
        $driver->deleteObjectIDs(
            $shopRegisterMaterialIDs->getChildArrayID(), $sitePageData->userID,
            Model_Ab1_Shop_Register_Material::TABLE_NAME, array(), 0
        );
        $driver->deleteObjectIDs(
            $shopRegisterRawIDs->getChildArrayID(), $sitePageData->userID,
            Model_Ab1_Shop_Register_Raw::TABLE_NAME, array(), 0
        );

        /****** Проверяем нужно ли произвести под материалы по рецептам ******/
        $number = 0;
        $level++;
        foreach ($shopFormulaMaterialItemIDs->childs as $child){
            $material = $child->values['shop_material_id'];
            if($material < 1 || !key_exists($material, $quantities)){
                continue;
            }

            $quantity = self::calcMaterialBalance(
                $material, $shopSubdivisionID, $shopHeapID, $sitePageData, $driver, false, $shopID, $shopObjectID
            );

            if ($quantity < $quantities[$material]) {
                $ids = self::_makeShopMaterial(
                    $quantities[$material]['id'], $shopObjectID, $date, $quantities[$material]['quantity'], $material,
                    $shopSubdivisionID, $shopHeapID, $tableID, $sitePageData, $driver, $number, $shopID, $level
                );

                foreach ($ids['materials'] as $material) {
                    $materials[$material] = $material;
                }
                foreach ($ids['raws'] as $raw) {
                    $raws[$raw] = $raw;
                }
            }
        }

        /*** Пересчет остатков материалов ***/
        self::calcMaterialBalance(
            $shopMaterialID, $shopSubdivisionID, $shopHeapID, $sitePageData, $driver, true, $shopID
        );
        foreach ($materials as $material){
            self::calcMaterialBalance(
                $material, $shopSubdivisionID, $shopHeapID, $sitePageData, $driver, true, $shopID
            );
        }
        foreach ($raws as $raw){
            Api_Ab1_Shop_Register_Raw::calcRawBalance(
                $raw, $shopSubdivisionID, $shopHeapID, $sitePageData, $driver, true, $shopID
            );
        }

        return array(
            'materials' => $materials,
            'raws' => $raws,
        );
    }

    /**
     * Производство материала при перемещении
     * @param Model_Ab1_Shop_Car_To_Material $modelCarToMaterial
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     */
    public static function makeShopCarToMaterial(Model_Ab1_Shop_Car_To_Material $modelCarToMaterial,
                                                 SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        $ids = self::makeShopMaterial(
            0,
            $modelCarToMaterial->id,
            $modelCarToMaterial->getCreatedAt(),
            $modelCarToMaterial->getQuantityFact(),
            $modelCarToMaterial->getShopMaterialID(),
            $modelCarToMaterial->getShopSubdivisionDaughterID(),
            $modelCarToMaterial->getShopHeapDaughterID(),
            $modelCarToMaterial->tableID,
            $sitePageData, $driver,
            $modelCarToMaterial->getShopBranchDaughterID()
        );

        /****** Пересчитываем остатки материалов и сырья если сменилом место производства ******/
        if($modelCarToMaterial->getShopSubdivisionDaughterID() != $modelCarToMaterial->getOriginalValue('shop_subdivision_daughter_id')
            || $modelCarToMaterial->getShopHeapDaughterID() != $modelCarToMaterial->getOriginalValue('shop_heap_daughter_id')
            || $modelCarToMaterial->getShopBranchDaughterID() != $modelCarToMaterial->getOriginalValue('shop_branch_daughter_id')){
            foreach ($ids['materials'] as $material){
                self::calcMaterialBalance(
                    $material,
                    $modelCarToMaterial->getOriginalValue('shop_subdivision_daughter_id'),
                    $modelCarToMaterial->getOriginalValue('shop_heap_daughter_id'),
                    $sitePageData, $driver, true,
                    $modelCarToMaterial->getOriginalValue('shop_branch_daughter_id')
                );
            }

            foreach ($ids['raws'] as $raw){
                Api_Ab1_Shop_Register_Raw::calcRawBalance(
                    $raw,
                    $modelCarToMaterial->getOriginalValue('shop_subdivision_daughter_id'),
                    $modelCarToMaterial->getOriginalValue('shop_heap_daughter_id'),
                    $sitePageData, $driver, true,
                    $modelCarToMaterial->getOriginalValue('shop_branch_daughter_id')
                );
            }
        }
    }

    /**
     * Считаем остатки материала по подразделениям
     * @param $shopMaterialID
     * @param $shopSubdivisionID
     * @param $shopHeapID
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @param bool $isSaveBalance
     * @param int $shopID
     * @param null $shopObjectIDNot
     * @return float|int
     */
    public static function calcMaterialBalance($shopMaterialID, $shopSubdivisionID, $shopHeapID,
                                               SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver,
                                               $isSaveBalance = false, $shopID = 0, $shopObjectIDNot = null)
    {
        if(!self::IS_CALC_BALANCE){
            return 0;
        }

        if($shopMaterialID < 1){
            return 0;
        }

        if($shopID < 1){
            $shopID = $sitePageData->shopID;
        }

        $params = Request_RequestParams::setParams(
            array(
                'shop_material_id' => $shopMaterialID,
                'shop_subdivision_id' => $shopSubdivisionID,
                'shop_heap_id' => $shopHeapID,
                'shop_object_id_not' => $shopObjectIDNot,
                'sum_quantity' => true,
            )
        );
        $shopRegisterMaterialIDs = Request_Request::find(
            'DB_Ab1_Shop_Register_Material', $shopID, $sitePageData, $driver, $params,
            0, TRUE
        );

        if(count($shopRegisterMaterialIDs->childs) == 0){
            return 0;
        }

        $quantity = floatval($shopRegisterMaterialIDs->childs[0]->values['quantity']);

        if($isSaveBalance && $shopObjectIDNot === null){
            Api_Ab1_Shop_Material_Balance::saveMaterialBalance(
                $quantity, $shopMaterialID, $shopSubdivisionID, $shopHeapID, $sitePageData, $driver, $shopID
            );
        }

        return $quantity;
    }

    /**
     * Производство продукта
     * @param $shopObjectID
     * @param $tableID
     * @param $shopFormulaProductID
     * @param $shopProductID
     * @param $date
     * @param $quantity
     * @param $shopSubdivisionID
     * @param $shopHeapID
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @param $shopID
     * @return array
     */
    private static function _makeShopProduct($shopObjectID, $tableID, $shopFormulaProductID, $shopProductID, $date, $quantity,
                                             $shopSubdivisionID, $shopHeapID,
                                             SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver, $shopID)
    {
        $params = Request_RequestParams::setParams(
            array(
                'shop_formula_product_id' => $shopFormulaProductID,
                'sort_by' => array(
                    'id' => 'asc'
                ),
            )
        );
        $shopFormulaProductItemIDs = Request_Request::find(
            'DB_Ab1_Shop_Formula_Product_Item', $shopID, $sitePageData, $driver, $params, 0, TRUE,
            array(
                'shop_material_id' => array('coefficient_recipe'),
            )
        );

        $params = Request_RequestParams::setParams(
            array(
                'shop_object_id' => $shopObjectID,
            )
        );
        $shopRegisterMaterialIDs = Request_Request::findBranch(
            'DB_Ab1_Shop_Register_Material', array(), $sitePageData, $driver, $params, 0, TRUE
        );
        $shopRegisterRawIDs = Request_Request::findBranch(
            'DB_Ab1_Shop_Register_Raw', array(), $sitePageData, $driver, $params, 0, TRUE
        );

        /****** Какие материалы и сырье необходимо пересчитать ******/
        $materials = $shopRegisterMaterialIDs->getChildArrayInt('shop_material_id', true);
        foreach ($shopFormulaProductItemIDs->childs as $child){
            $material = $child->values['shop_material_id'];
            $materials[$material] = $material;
        }
        $prevMaterials = $materials;

        $raws = $shopRegisterRawIDs->getChildArrayInt('shop_raw_id', true);

        /****** Фиксируем производство по рецепту ******/
        $quantities = array();
        foreach ($shopFormulaProductItemIDs->childs as $child){
            $model = new Model_Ab1_Shop_Register_Material();
            $shopRegisterMaterialIDs->childShiftSetModel(
                $model, 0, $shopID, false, array('shop_material_id' => $child->values['shop_material_id'])
            );
            $model->setShopMaterialID($child->values['shop_material_id']);
            $model->setDBDriver($driver);

            $model->setTableID($tableID);
            $model->setShopObjectID($shopObjectID);
            $model->setQuantity(self::getQuantityFormula($quantity, $child, Request_RequestParams::isBoolean($child->values['is_side'])));
            $model->setShopSubdivisionID($shopSubdivisionID);
            $model->setShopHeapID($shopHeapID);
            $model->setRootShopRegisterMaterialID(0);
            $model->setRootShopRegisterRawID(0);
            $model->setShopFormulaProductID($shopFormulaProductID);
            $model->setShopProductID($shopProductID);
            $model->setShopFormulaRawID(0);
            $model->setShopFormulaMaterialID(0);
            $model->setLevel(0);
            $model->setCreatedAt($date);

            Helpers_DB::saveDBObject($model, $sitePageData, $shopID);

            if($child->values['is_side'] == 0) {
                $quantities[$model->getShopMaterialID()] = [
                    'id' => $model->id,
                    'quantity' => $model->getQuantity() * -1,
                ];
            }
        }

        // удаляем лишние
        $driver->deleteObjectIDs(
            $shopRegisterMaterialIDs->getChildArrayID(), $sitePageData->userID,
            Model_Ab1_Shop_Register_Material::TABLE_NAME, array(), 0
        );
        $driver->deleteObjectIDs(
            $shopRegisterRawIDs->getChildArrayID(), $sitePageData->userID,
            Model_Ab1_Shop_Register_Raw::TABLE_NAME, array(), 0
        );

        /****** Проверяем нужно ли произвести под материалы по рецептам ******/
        foreach ($shopFormulaProductItemIDs->childs as $child){
            $material = $child->values['shop_material_id'];
            if(!key_exists($material, $quantities)){
                continue;
            }

            $quantity = self::calcMaterialBalance(
                $material, $shopSubdivisionID, $shopHeapID, $sitePageData, $driver, false, $shopID, $shopObjectID
            );

            if ($quantity < $quantities[$material]) {
                $ids = self::makeShopMaterial(
                    $quantities[$material]['id'], $shopObjectID, $date, $quantities[$material]['quantity'], $material,
                    $shopSubdivisionID, $shopHeapID, $tableID, $sitePageData, $driver, $shopID, false, 1
                );

                foreach ($ids['materials'] as $material) {
                    $materials[$material] = $material;
                }
                foreach ($ids['raws'] as $raw) {
                    $raws[$raw] = $raw;
                }
            }
        }

        /****** Пересчитываем остатки материалов и сырья ******/
        foreach ($prevMaterials as $material) {
            self::calcMaterialBalance(
                $material, $shopSubdivisionID, $shopHeapID, $sitePageData, $driver, true, $shopID
            );
        }

        return array(
            'materials' => $materials,
            'raws' => $raws,
        );
    }

    /**
     * Производство продукта
     * @param Model_Shop_Table_Basic_Table $model
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     */
    public static function makeShopProduct(Model_Shop_Table_Basic_Table $model, SitePageData $sitePageData,
                                           Model_Driver_DBBasicDriver $driver)
    {
        $rawMaterials = self::_makeShopProduct(
            $model->id, $model->tableID,
            $model->getShopFormulaProductID(),
            $model->getShopProductID(),
            $model->getCreatedAt(), $model->getQuantity(),
            $model->getShopSubdivisionID(), $model->getShopHeapID(),
            $sitePageData, $driver,
            $model->shopID
        );

        if($model->getShopSubdivisionID() != $model->getOriginalValue('shop_subdivision_id')
            || $model->getShopHeapID() != $model->getOriginalValue('shop_heap_id')) {
            foreach ($rawMaterials['materials'] as $material) {
                self::calcMaterialBalance(
                    $material,
                    $model->getOriginalValue('shop_subdivision_id'),
                    $model->getOriginalValue('shop_heap_id'),
                    $sitePageData, $driver, true, $model->shopID
                );
            }
            foreach ($rawMaterials['raws'] as $raw) {
                Api_Ab1_Shop_Register_Raw::calcRawBalance(
                    $raw,
                    $model->getOriginalValue('shop_subdivision_id'),
                    $model->getOriginalValue('shop_heap_id'),
                    $sitePageData, $driver, true, $model->shopID
                );
            }
        }
    }

    /**
     * Сохранение расход материала для перемещения
     * @param Model_Ab1_Shop_Move_Car $modelCar
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @return bool
     * @throws HTTP_Exception_500
     */
    public static function saveShopMoveCar(Model_Ab1_Shop_Move_Car $modelCar, SitePageData $sitePageData,
                                           Model_Driver_DBBasicDriver $driver)
    {
        if($modelCar->getShopStorageID() > 0){
            $total = Api_Ab1_Shop_Product_Balance::getProductBalance(
                $modelCar->getShopProductID(), $modelCar->getShopStorageID(), $sitePageData, $driver
            );

            if($total >= $modelCar->getQuantity()){
                Api_Ab1_Shop_Product_Balance::saveProductBalance(
                    $total - $modelCar->getQuantity(), $modelCar->getShopProductID(), $modelCar->getShopStorageID(),
                    $sitePageData, $driver, $modelCar->shopID
                );

                // удаляем предыдущие производство
                Api_Ab1_Shop_Register_Material::delShopMoveCar($modelCar, $sitePageData, $driver);
                Api_Ab1_Shop_Register_Raw::delShopMoveCar($modelCar, $sitePageData, $driver);

                return true;
            }
        }

        // находим рецепт
        if($modelCar->getShopFormulaProductID() < 1 || $modelCar->getShopProductID() != $modelCar->getOriginalValue('shop_product_id')) {
            $modelCar->setShopFormulaProductID(
                Api_Ab1_Shop_Formula_Product::getShopFormulaProductID(
                    $modelCar->getShopProductID(), $modelCar->getCreatedAt(), $sitePageData, $driver, $modelCar->shopID
                )
            );
            Helpers_DB::saveDBObject($modelCar, $sitePageData, $modelCar->shopID);

            if($modelCar->getShopFormulaProductID() < 1 ){
                throw new HTTP_Exception_500('Recipe product id="'.$modelCar->getShopProductID().'" shop_id="'.$modelCar->shopID.'" not found.');
            }
        }

        if($modelCar->getIsDelete() || $modelCar->getShopFormulaProductID() < 1){
            // удаляем предыдущие производство
            Api_Ab1_Shop_Register_Material::delShopMoveCar($modelCar, $sitePageData, $driver);
            Api_Ab1_Shop_Register_Raw::delShopMoveCar($modelCar, $sitePageData, $driver);

            return true;
        }

        self::makeShopProduct($modelCar, $sitePageData, $driver);
        return true;
    }

    /**
     * Сохранение расход материала для брака
     * @param Model_Ab1_Shop_Defect_Car $modelCar
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @return bool
     * @throws HTTP_Exception_500
     */
    public static function saveShopDefectCar(Model_Ab1_Shop_Defect_Car $modelCar, SitePageData $sitePageData,
                                             Model_Driver_DBBasicDriver $driver)
    {
        if($modelCar->getShopStorageID() > 0){
            $total = Api_Ab1_Shop_Product_Balance::getProductBalance(
                $modelCar->getShopProductID(), $modelCar->getShopStorageID(), $sitePageData, $driver
            );

            if($total >= $modelCar->getQuantity()){
                Api_Ab1_Shop_Product_Balance::saveProductBalance(
                    $total - $modelCar->getQuantity(), $modelCar->getShopProductID(), $modelCar->getShopStorageID(),
                    $sitePageData, $driver, $modelCar->shopID
                );

                // удаляем предыдущие производство
                Api_Ab1_Shop_Register_Material::delShopDefectCar($modelCar, $sitePageData, $driver);
                Api_Ab1_Shop_Register_Raw::delShopDefectCar($modelCar, $sitePageData, $driver);

                return true;
            }
        }

        // находим рецепт
        if($modelCar->getShopFormulaProductID() < 1 || $modelCar->getShopProductID() != $modelCar->getOriginalValue('shop_product_id')) {
            $modelCar->setShopFormulaProductID(
                Api_Ab1_Shop_Formula_Product::getShopFormulaProductID(
                    $modelCar->getShopProductID(), $modelCar->getCreatedAt(), $sitePageData, $driver, $modelCar->shopID
                )
            );
            Helpers_DB::saveDBObject($modelCar, $sitePageData, $modelCar->shopID);

            if($modelCar->getShopFormulaProductID() < 1 ){
                throw new HTTP_Exception_500('Recipe product id="'.$modelCar->getShopProductID().'" shop_id="'.$modelCar->shopID.'" not found.');
            }
        }

        if($modelCar->getIsDelete() || $modelCar->getShopFormulaProductID() < 1){
            // удаляем предыдущие производство
            Api_Ab1_Shop_Register_Material::delShopDefectCar($modelCar, $sitePageData, $driver);
            Api_Ab1_Shop_Register_Raw::delShopDefectCar($modelCar, $sitePageData, $driver);

            return true;
        }

        self::makeShopProduct($modelCar, $sitePageData, $driver);
        return true;
    }

    /**
     * Сохранение все расходы материала для перемещения
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     */
    public static function saveShopMoveCars(SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        $params = Request_RequestParams::setParams(
            array(
                'shop_formula_product_id' => 0,
                'sort_by' => array(
                    'id' => 'asc'
                )
            )
        );
        $ids = Request_Request::findBranch(
            'DB_Ab1_Shop_Move_Car', array(), $sitePageData, $driver, $params,
            0, TRUE
        );

        foreach ($ids->childs as $child){
            /** @var Model_Ab1_Shop_Move_Car $model */
            $model = $child->createModel('DB_Ab1_Shop_Move_Car', $driver);

            self::saveShopMoveCar($model, $sitePageData, $driver);
        }
    }

    /**
     * Сохранение все расходы материала для брака
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     */
    public static function saveShopDefectCars(SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        $params = Request_RequestParams::setParams(
            array(
                'shop_formula_product_id' => 0,
                'sort_by' => array(
                    'id' => 'asc'
                )
            )
        );
        $ids = Request_Request::findBranch(
            'DB_Ab1_Shop_Defect_Car', array(), $sitePageData, $driver, $params,
            0, TRUE
        );

        foreach ($ids->childs as $child){
            /** @var Model_Ab1_Shop_Defect_Car $model */
            $model = $child->createModel('DB_Ab1_Shop_Defect_Car', $driver);

            self::saveShopDefectCar($model, $sitePageData, $driver);
        }
    }

    /**
     * Сохранение расход материала для аренды
     * @param Model_Ab1_Shop_Lessee_Car $modelCar
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @return bool
     * @throws HTTP_Exception_500
     */
    public static function saveShopLesseeCar(Model_Ab1_Shop_Lessee_Car $modelCar, SitePageData $sitePageData,
                                             Model_Driver_DBBasicDriver $driver)
    {
        if($modelCar->getShopStorageID() > 0){
            $total = Api_Ab1_Shop_Product_Balance::getProductBalance(
                $modelCar->getShopProductID(), $modelCar->getShopStorageID(), $sitePageData, $driver
            );

            if($total >= $modelCar->getQuantity()){
                Api_Ab1_Shop_Product_Balance::saveProductBalance(
                    $total - $modelCar->getQuantity(), $modelCar->getShopProductID(), $modelCar->getShopStorageID(),
                    $sitePageData, $driver, $modelCar->shopID
                );

                // удаляем предыдущие производство
                Api_Ab1_Shop_Register_Material::delShopLesseeCar($modelCar, $sitePageData, $driver);
                Api_Ab1_Shop_Register_Raw::delShopLesseeCar($modelCar, $sitePageData, $driver);

                return true;
            }
        }

        // находим рецепт
        if($modelCar->getShopFormulaProductID() < 1 || $modelCar->getShopProductID() != $modelCar->getOriginalValue('shop_product_id')) {
            $modelCar->setShopFormulaProductID(
                Api_Ab1_Shop_Formula_Product::getShopFormulaProductID(
                    $modelCar->getShopProductID(), $modelCar->getCreatedAt(), $sitePageData, $driver, $modelCar->shopID
                )
            );
            Helpers_DB::saveDBObject($modelCar, $sitePageData, $modelCar->shopID);

            if($modelCar->getShopFormulaProductID() < 1 ){
                throw new HTTP_Exception_500('Recipe product id="'.$modelCar->getShopProductID().'" shop_id="'.$modelCar->shopID.'" not found.');
            }
        }

        if($modelCar->getIsDelete() || $modelCar->getShopFormulaProductID() < 1){
            // удаляем предыдущие производство
            Api_Ab1_Shop_Register_Material::delShopLesseeCar($modelCar, $sitePageData, $driver);
            Api_Ab1_Shop_Register_Raw::delShopLesseeCar($modelCar, $sitePageData, $driver);

            return true;
        }

        self::makeShopProduct($modelCar, $sitePageData, $driver);
        return true;
    }

    /**
     * Сохранение все расходы материала для аренды
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     */
    public static function saveShopLesseeCars(SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        $params = Request_RequestParams::setParams(
            array(
                'shop_formula_product_id' => 0,
                'sort_by' => array(
                    'id' => 'asc'
                )
            )
        );
        $ids = Request_Request::findBranch(
            'DB_Ab1_Shop_Lessee_Car', array(), $sitePageData, $driver, $params,
            0, TRUE
        );

        foreach ($ids->childs as $child){
            /** @var Model_Ab1_Shop_Lessee_Car $model */
            $model = $child->createModel('DB_Ab1_Shop_Lessee_Car', $driver);

            self::saveShopLesseeCar($model, $sitePageData, $driver);
        }
    }

    /**
     * Сохранение расход материала для реализации
     * @param Model_Ab1_Shop_Car $modelCar
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @return bool
     * @throws HTTP_Exception_500
     */
    public static function saveShopCar(Model_Ab1_Shop_Car $modelCar, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        if($modelCar->getShopStorageID() > 0){
            $total = Api_Ab1_Shop_Product_Balance::getProductBalance(
                $modelCar->getShopProductID(), $modelCar->getShopStorageID(), $sitePageData, $driver
            );

            if($total >= $modelCar->getQuantity()){
                Api_Ab1_Shop_Product_Balance::saveProductBalance(
                    $total - $modelCar->getQuantity(), $modelCar->getShopProductID(), $modelCar->getShopStorageID(),
                    $sitePageData, $driver, $modelCar->shopID
                );

                // удаляем предыдущие производство
                Api_Ab1_Shop_Register_Material::delShopCar($modelCar, $sitePageData, $driver);
                Api_Ab1_Shop_Register_Raw::delShopCar($modelCar, $sitePageData, $driver);

                return true;
            }

            // пересчитать баланс остатка продукции
            Api_Ab1_Shop_Product_Storage::calcProductBalance(
                $modelCar->getShopProductID(), $modelCar->getShopStorageID(), $sitePageData, $driver, true
            );
            if($modelCar->getShopProductID() != $modelCar->getOriginalValue('shop_product_id')
                || $modelCar->getShopStorageID() != $modelCar->getOriginalValue('shop_storage_id')) {
                Api_Ab1_Shop_Product_Storage::calcProductBalance(
                    $modelCar->getOriginalValue('shop_product_id'),
                    $modelCar->getOriginalValue('shop_storage_id'),
                    $sitePageData, $driver, true
                );
            }
        }

        // находим рецепт
        if($modelCar->getShopFormulaProductID() < 1 || $modelCar->getShopProductID() != $modelCar->getOriginalValue('shop_product_id')) {
             $modelCar->setShopFormulaProductID(
                Api_Ab1_Shop_Formula_Product::getShopFormulaProductID(
                    $modelCar->getShopProductID(), $modelCar->getCreatedAt(), $sitePageData, $driver, $modelCar->shopID
                )
            );
            Helpers_DB::saveDBObject($modelCar, $sitePageData, $modelCar->shopID);

            if($modelCar->getShopFormulaProductID() < 1 ){
                throw new HTTP_Exception_500('Recipe product id="'.$modelCar->getShopProductID().'" shop_id="'.$modelCar->shopID.'" not found.');
            }
        }

        if($modelCar->getIsDelete() || $modelCar->getShopFormulaProductID() < 1){
            // удаляем предыдущие производство
            Api_Ab1_Shop_Register_Material::delShopCar($modelCar, $sitePageData, $driver);
            Api_Ab1_Shop_Register_Raw::delShopCar($modelCar, $sitePageData, $driver);

            return true;
        }

        self::makeShopProduct($modelCar, $sitePageData, $driver);

        return true;
    }

    /**
     * Сохранение все материала для реализации
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     */
    public static function saveShopCars(SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        $params = Request_RequestParams::setParams(
            array(
                'shop_formula_product_id' => 0,
                'shop_storage_id' => 0,
                'is_public_ignore' => true,
                'sort_by' => array(
                    'id' => 'asc'
                )
            )
        );
        $ids = Request_Request::findBranch(
            'DB_Ab1_Shop_Car', array(), $sitePageData, $driver, $params,
            0, TRUE
        );

        foreach ($ids->childs as $child){
            /** @var Model_Ab1_Shop_Car $model */
            $model = $child->createModel('DB_Ab1_Shop_Car', $driver);

            self::saveShopCar($model, $sitePageData, $driver);
        }
    }

    /**
     * Сохранение расход материала для реализации штучного товара
     * @param Model_Ab1_Shop_Piece $modelPiece
     * @param Model_Ab1_Shop_Piece_Item $modelPieceItem
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @return bool
     * @throws HTTP_Exception_500
     */
    public static function saveShopPieceItem(Model_Ab1_Shop_Piece $modelPiece, Model_Ab1_Shop_Piece_Item $modelPieceItem,
                                             SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        if($modelPieceItem->getShopStorageID() > 0){
            $total = Api_Ab1_Shop_Product_Balance::getProductBalance(
                $modelPieceItem->getShopProductID(), $modelPieceItem->getShopStorageID(), $sitePageData, $driver
            );

            if($total >= $modelPieceItem->getQuantity()){
                Api_Ab1_Shop_Product_Balance::saveProductBalance(
                    $total - $modelPieceItem->getQuantity(),
                    $modelPieceItem->getShopProductID(), $modelPieceItem->getShopStorageID(),
                    $sitePageData, $driver, $modelPieceItem->shopID
                );

                // удаляем предыдущие производство
                Api_Ab1_Shop_Register_Material::delShopPieceItem($modelPieceItem, $sitePageData, $driver);
                Api_Ab1_Shop_Register_Raw::delShopPieceItem($modelPieceItem, $sitePageData, $driver);

                return true;
            }
        }

        // находим рецепт
        if($modelPieceItem->getShopFormulaProductID() < 1 || $modelPieceItem->getShopProductID() != $modelPieceItem->getOriginalValue('shop_product_id')) {
            $modelPieceItem->setShopFormulaProductID(
                Api_Ab1_Shop_Formula_Product::getShopFormulaProductID(
                    $modelPieceItem->getShopProductID(), $modelPiece->getCreatedAt(), $sitePageData, $driver, $modelPieceItem->shopID
                )
            );
            Helpers_DB::saveDBObject($modelPieceItem, $sitePageData, $modelPieceItem->shopID);

            if($modelPieceItem->getShopFormulaProductID() < 1 ){
                throw new HTTP_Exception_500('Recipe product id="'.$modelPieceItem->getShopProductID().'" shop_id="'.$modelPieceItem->shopID.'" not found.');
            }
        }

        if($modelPieceItem->getIsDelete() || $modelPieceItem->getShopFormulaProductID() < 1){
            // удаляем предыдущие производство
            Api_Ab1_Shop_Register_Material::delShopPieceItem($modelPieceItem, $sitePageData, $driver);
            Api_Ab1_Shop_Register_Raw::delShopPieceItem($modelPieceItem, $sitePageData, $driver);

            return true;
        }

        self::makeShopProduct($modelPieceItem, $sitePageData, $driver);

        return true;
    }

    /**
     * Сохранение все расходы материала для реализации штучного товара
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     */
    public static function saveShopPieces(SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        $params = Request_RequestParams::setParams(
            array(
                'shop_formula_product_id' => 0,
                'sort_by' => array(
                    'id' => 'asc'
                )
            )
        );
        $shopPieceIDs = Request_Request::findBranch(
            'DB_Ab1_Shop_Piece', array(), $sitePageData, $driver, $params,
            0, TRUE
        );
        $shopPieceIDs->runIndex();

        $ids = Request_Request::findBranch(
            'DB_Ab1_Shop_Piece_Item', array(), $sitePageData, $driver, $params,
            0, TRUE
        );

        foreach ($ids->childs as $child){
            /** @var Model_Ab1_Shop_Piece $modelPiece */
            $modelPiece = $shopPieceIDs->childs[$child->values['shop_piece_id']]->createModel('DB_Ab1_Shop_Piece', $driver);
            /** @var Model_Ab1_Shop_Piece_Item $model */
            $model = $child->createModel('DB_Ab1_Shop_Piece_Item', $driver);

            if($model->getShopProductID() == 178313){
                continue;
            }

            self::saveShopPieceItem($modelPiece, $model, $sitePageData, $driver);
        }
    }

    /**
     * Сохранение все расходы материала
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     */
    public static function saveAll(SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        self::saveShopCars($sitePageData, $driver);
        self::saveShopLesseeCars($sitePageData, $driver);
        self::saveShopMoveCars($sitePageData, $driver);
        self::saveShopDefectCars($sitePageData, $driver);
        self::saveShopRawMaterials($sitePageData, $driver);
        self::saveShopPieces($sitePageData, $driver);
        self::saveShopCarToMaterials($sitePageData, $driver);
    }

    /**
     * Считаем остатки материалов по подразделениям
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     */
    public static function calcMaterialsBalance(SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        $params = Request_RequestParams::setParams(
            array(
                'sum_quantity' => true,
                'group_by' => array(
                    'shop_material_id', 'shop_subdivision_id', 'shop_heap_id', 'shop_id',
                ),
            )
        );
        $shopRegisterMaterialIDs = Request_Request::findBranch(
            'DB_Ab1_Shop_Material_Balance', array(), $sitePageData, $driver, $params, 0, TRUE
        );

        foreach ($shopRegisterMaterialIDs->childs as $child){
            Api_Ab1_Shop_Material_Balance::saveMaterialBalance(
                $child->values['quantity'],
                $child->values['shop_material_id'],
                $child->values['shop_subdivision_id'],
                $child->values['shop_heap_id'],
                $sitePageData, $driver,
                $child->values['shop_id']
            );
        }
    }

    /**
     * Пересчетать остатки материалов списка материла
     * @param MyArray $shopRegisterMaterialIDs
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     */
    private static function _calcShopRegisterMaterial(MyArray $shopRegisterMaterialIDs, SitePageData $sitePageData,
                                                      Model_Driver_DBBasicDriver $driver)
    {
        // пересчитываем баланс материала
        foreach ($shopRegisterMaterialIDs->childs as $child){
            self::calcMaterialBalance(
                $child->values['shop_material_id'],
                $child->values['shop_subdivision_id'],
                $child->values['shop_heap_id'],
                $sitePageData, $driver, true,
                $child->values['shop_id']
            );
        }
    }

    /**
     * Удаление производства
     * @param $id
     * @param $tableID
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     */
    private static function delShopRegisterMaterial($id, $tableID, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        $params = Request_RequestParams::setParams(
            array(
                'shop_object_id' => $id,
                'table_id' => $tableID,
                'sort_by' => array(
                    'id' => 'asc'
                )
            )
        );
        $shopRegisterMaterialIDs = Request_Request::findBranch(
            'DB_Ab1_Shop_Register_Material', array(), $sitePageData, $driver, $params,
            0, TRUE
        );

        // удаляем лишние
        $driver->deleteObjectIDs(
            $shopRegisterMaterialIDs->getChildArrayID(), $sitePageData->userID,
            Model_Ab1_Shop_Register_Material::TABLE_NAME, array('is_public' => 0), 0
        );

        // пересчитываем баланс материала
        self::_calcShopRegisterMaterial($shopRegisterMaterialIDs, $sitePageData, $driver);
    }

    /**
     * Восстановление производства
     * @param $id
     * @param $tableID
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     */
    private static function unDelShopRegisterMaterial($id, $tableID, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        $params = Request_RequestParams::setParams(
            array(
                'is_delete' => 1,
                'is_public' => 0,
                'shop_object_id' => $id,
                'table_id' => $tableID,
                'sort_by' => array(
                    'id' => 'asc'
                )
            )
        );
        $shopRegisterMaterialIDs = Request_Request::findBranch(
            'DB_Ab1_Shop_Register_Material', array(), $sitePageData, $driver, $params,
            0, TRUE
        );

        // удаляем лишние
        $driver->unDeleteObjectIDs(
            $shopRegisterMaterialIDs->getChildArrayID(), $sitePageData->userID,
            Model_Ab1_Shop_Register_Material::TABLE_NAME, array('is_public' => 1), 0
        );

        // пересчитываем баланс материала
        self::_calcShopRegisterMaterial($shopRegisterMaterialIDs, $sitePageData, $driver);
    }

    /**
     * Удаление производство продукта
     * @param Model_Ab1_Shop_Move_Car $modelMoveCar
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @return boolean
     */
    public static function delShopMoveCar(Model_Ab1_Shop_Move_Car $modelMoveCar, SitePageData $sitePageData,
                                          Model_Driver_DBBasicDriver $driver)
    {
        return self::delShopRegisterMaterial($modelMoveCar->id, Model_Ab1_Shop_Move_Car::TABLE_ID, $sitePageData, $driver);
    }

    /**
     * Восстановление производство продукта
     * @param Model_Ab1_Shop_Move_Car $modelMoveCar
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @return boolean
     */
    public static function unDelShopMoveCar(Model_Ab1_Shop_Move_Car $modelMoveCar, SitePageData $sitePageData,
                                            Model_Driver_DBBasicDriver $driver)
    {
        return self::unDelShopRegisterMaterial($modelMoveCar->id, Model_Ab1_Shop_Move_Car::TABLE_ID, $sitePageData, $driver);
    }

    /**
     * Удаление производство продукта
     * @param Model_Ab1_Shop_Defect_Car $modelDefectCar
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @return boolean
     */
    public static function delShopDefectCar(Model_Ab1_Shop_Defect_Car $modelDefectCar, SitePageData $sitePageData,
                                            Model_Driver_DBBasicDriver $driver)
    {
        return self::delShopRegisterMaterial($modelDefectCar->id, Model_Ab1_Shop_Defect_Car::TABLE_ID, $sitePageData, $driver);
    }

    /**
     * Восстановление производство продукта
     * @param Model_Ab1_Shop_Defect_Car $modelDefectCar
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @return boolean
     */
    public static function unDelShopDefectCar(Model_Ab1_Shop_Defect_Car $modelDefectCar, SitePageData $sitePageData,
                                              Model_Driver_DBBasicDriver $driver)
    {
        return self::unDelShopRegisterMaterial($modelDefectCar->id, Model_Ab1_Shop_Defect_Car::TABLE_ID, $sitePageData, $driver);
    }

    /**
     * Удаление производство продукта
     * @param Model_Ab1_Shop_Piece_Item $modelPieceItem
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @return boolean
     */
    public static function delShopPieceItem(Model_Ab1_Shop_Piece_Item $modelPieceItem, SitePageData $sitePageData,
                                            Model_Driver_DBBasicDriver $driver)
    {
        return self::delShopRegisterMaterial($modelPieceItem->id, Model_Ab1_Shop_Piece_Item::TABLE_ID, $sitePageData, $driver);
    }

    /**
     * Восстановление производство продукта
     * @param Model_Ab1_Shop_Piece_Item $modelPieceItem
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @return boolean
     */
    public static function unDelShopPieceItem(Model_Ab1_Shop_Piece_Item $modelPieceItem, SitePageData $sitePageData,
                                              Model_Driver_DBBasicDriver $driver)
    {
        return self::unDelShopRegisterMaterial($modelPieceItem->id, Model_Ab1_Shop_Piece_Item::TABLE_ID, $sitePageData, $driver);
    }

    /**
     * Удаление производство продукта
     * @param Model_Ab1_Shop_Car $modelCar
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @return boolean
     */
    public static function delShopCar(Model_Ab1_Shop_Car $modelCar, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        return self::delShopRegisterMaterial($modelCar->id, Model_Ab1_Shop_Car::TABLE_ID, $sitePageData, $driver);
    }

    /**
     * Восстановление производство продукта
     * @param Model_Ab1_Shop_Car $modelCar
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @return boolean
     */
    public static function unDelShopCar(Model_Ab1_Shop_Car $modelCar, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        return self::unDelShopRegisterMaterial($modelCar->id, Model_Ab1_Shop_Car::TABLE_ID, $sitePageData, $driver);
    }

    /**
     * Удаление производство продукта
     * @param Model_Ab1_Shop_Car_To_Material $model
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @return boolean
     */
    public static function delShopCarToMaterial(Model_Ab1_Shop_Car_To_Material $model, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        return self::delShopRegisterMaterial($model->id, null, $sitePageData, $driver);
    }

    /**
     * Восстановление производство продукта
     * @param Model_Ab1_Shop_Car_To_Material $model
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @return boolean
     */
    public static function unDelShopCarToMaterial(Model_Ab1_Shop_Car_To_Material $model, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        return self::unDelShopRegisterMaterial($model->id, null, $sitePageData, $driver);
    }

    /**
     * Удаление производство продукта
     * @param Model_Ab1_Shop_Lessee_Car $modelLesseeCar
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @return boolean
     */
    public static function delShopLesseeCar(Model_Ab1_Shop_Lessee_Car $modelLesseeCar, SitePageData $sitePageData,
                                            Model_Driver_DBBasicDriver $driver)
    {
        return self::delShopRegisterMaterial($modelLesseeCar->id, Model_Ab1_Shop_Lessee_Car::TABLE_ID, $sitePageData, $driver);
    }

    /**
     * Восстановление производство продукта
     * @param Model_Ab1_Shop_Lessee_Car $modelLesseeCar
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @return boolean
     */
    public static function unDelShopLesseeCar(Model_Ab1_Shop_Lessee_Car $modelLesseeCar, SitePageData $sitePageData,
                                              Model_Driver_DBBasicDriver $driver)
    {
        return self::unDelShopRegisterMaterial($modelLesseeCar->id, Model_Ab1_Shop_Lessee_Car::TABLE_ID, $sitePageData, $driver);
    }

    /**
     * Удаление производство материала из сырья
     * @param Model_Ab1_Shop_Raw_Material $modelRawMaterial
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @return boolean
     */
    public static function delShopRawMaterial(Model_Ab1_Shop_Raw_Material $modelRawMaterial, SitePageData $sitePageData,
                                              Model_Driver_DBBasicDriver $driver)
    {
        return self::delShopRegisterMaterial($modelRawMaterial->id, Model_Ab1_Shop_Raw_Material::TABLE_ID, $sitePageData, $driver);
    }

    /**
     * Восстановление производство материала из сырья
     * @param Model_Ab1_Shop_Raw_Material $modelRawMaterial
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @return boolean
     */
    public static function unDelShopRawMaterial(Model_Ab1_Shop_Raw_Material $modelRawMaterial, SitePageData $sitePageData,
                                                Model_Driver_DBBasicDriver $driver)
    {
        return self::unDelShopRegisterMaterial($modelRawMaterial->id, Model_Ab1_Shop_Raw_Material::TABLE_ID, $sitePageData, $driver);
    }
}