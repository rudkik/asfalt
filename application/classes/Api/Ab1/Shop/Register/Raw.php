<?php defined('SYSPATH') or die('No direct script access.');

class Api_Ab1_Shop_Register_Raw  {
    const IS_CALC_BALANCE = false;
    /**
     * Сохранение прибытие сырья через добычу
     * @param Model_Ab1_Shop_Ballast $modelBallast
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @return boolean
     */
    public static function saveShopBallast(Model_Ab1_Shop_Ballast $modelBallast, SitePageData $sitePageData,
                                           Model_Driver_DBBasicDriver $driver)
    {
        $params = Request_RequestParams::setParams(
            array(
                'shop_object_id' => $modelBallast->id,
                'table_id' => Model_Ab1_Shop_Ballast::TABLE_ID,
                'sort_by' => array(
                    'id' => 'asc'
                )
            )
        );
        $shopRegisterMaterialIDs = Request_Request::find(
            'DB_Ab1_Shop_Register_Raw', $sitePageData->shopID, $sitePageData, $driver, $params,
            0, TRUE
        );

        /** @var Model_Ab1_Shop_Ballast_Crusher $modelCrusher */
        $modelCrusher = $modelBallast->getElement('shop_ballast_crusher_id', true, $sitePageData->shopMainID);

        if($modelBallast->getIsDelete() || !$modelCrusher->getIsBalance()){
            // удаляем лишние
            $driver->deleteObjectIDs(
                $shopRegisterMaterialIDs->getChildArrayID(), $sitePageData->userID,
                Model_Ab1_Shop_Register_Raw::TABLE_NAME, array(), $sitePageData->shopID
            );

            /*** Пересчет остатков сырья ***/
            foreach ($shopRegisterMaterialIDs->childs as $child){
                self::calcRawBalance(
                    $child->values['shop_raw_id'], $child->values['shop_subdivision_id'], $child->values['shop_heap_id'],
                    $sitePageData, $driver, true, $child->values['shop_id']
                );
            }

            return true;
        }

        $model = new Model_Ab1_Shop_Register_Raw();
        $model->setDBDriver($driver);

        $shopRegisterMaterialIDs->childShiftSetModel($model, 0, $sitePageData->shopID);
        $model->setShopObjectID($modelBallast->id);
        $model->setTableID(Model_Ab1_Shop_Ballast::TABLE_ID);

        if($modelCrusher != null){
            $model->setShopSubdivisionID($modelCrusher->getShopSubdivisionID());
            $model->setShopHeapID($modelCrusher->getShopHeapID());
        }else{
            $model->setShopSubdivisionID(0);
            $model->setShopHeapID(0);
        }

        $model->setQuantity($modelBallast->getQuantity());
        $model->setShopBallastCrusherID($modelBallast->getShopBallastCrusherID());
        $model->setShopRawID($modelBallast->getShopRawID());

        Helpers_DB::saveDBObject($model, $sitePageData);

        $shopRegisterMaterialIDs->childShiftSetModel($model, 0, $sitePageData->shopID);
        $model->setShopObjectID($modelBallast->id);
        $model->setTableID(Model_Ab1_Shop_Ballast::TABLE_ID);

        // перемещение с другого места
        if($modelBallast->getTakeShopBallastCrusherID() > 0) {
            $shopRegisterMaterialIDs->childShiftSetModel($model, 0, $sitePageData->shopID);
            $model->setShopObjectID($modelBallast->id);
            $model->setTableID(Model_Ab1_Shop_Ballast::TABLE_ID);

            /** @var Model_Ab1_Shop_Ballast_Crusher $modelCrusher */
            $modelCrusher = $modelBallast->getElement('take_shop_ballast_crusher_id', true, $sitePageData->shopMainID);
            if ($modelCrusher != null) {
                $model->setShopSubdivisionID($modelCrusher->getShopSubdivisionID());
                $model->setShopHeapID($modelCrusher->getShopHeapID());
            } else {
                $model->setShopSubdivisionID(0);
                $model->setShopHeapID(0);
            }

            $model->setQuantity($modelBallast->getQuantity() * -1);
            $model->setShopBallastCrusherID($modelBallast->getShopBallastCrusherID());
            $model->setShopRawID($modelBallast->getShopRawID());

            Helpers_DB::saveDBObject($model, $sitePageData);
        }

        // удаляем лишние
        $driver->deleteObjectIDs(
            $shopRegisterMaterialIDs->getChildArrayID(), $sitePageData->userID,
            Model_Ab1_Shop_Register_Raw::TABLE_NAME, array(), 0
        );

        /*** Пересчет остатков сырья ***/

        // если изменился филиал
        foreach ($shopRegisterMaterialIDs->childs as $child){
            self::calcRawBalance(
                $child->values['shop_raw_id'], $child->values['shop_subdivision_id'], $child->values['shop_heap_id'],
                $sitePageData, $driver, true, $child->values['shop_id']
            );
        }

        // пересчитываем остатки текущего сырья
        self::calcRawBalance(
            $model->getShopRawID(), $model->getShopSubdivisionID(), $model->getShopHeapID(),
            $sitePageData, $driver, true, $model->shopID
        );

        // пересчитываем остатки при изменении сырья и/или подразделения
        if($model->getShopRawID() != $model->getOriginalValue('shop_raw_id')
            || $model->getShopSubdivisionID() != $model->getOriginalValue('shop_ballast_crusher_id')
            || $model->getShopHeapID() != $model->getOriginalValue('shop_heap_id')) {
            self::calcRawBalance(
                $model->getOriginalValue('shop_raw_id'),
                $model->getOriginalValue('shop_ballast_crusher_id'),
                $model->getOriginalValue('shop_heap_id'),
                $sitePageData, $driver, true,
                $model->shopID
            );
        }

        return true;
    }

    /**
     * Сохранение производство сырья из сырья
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
        $shopRegisterRawIDs = Request_Request::find(
            'DB_Ab1_Shop_Register_Raw', $sitePageData->shopID, $sitePageData, $driver, $params,
            0, TRUE
        );

        if($modelRawMaterial->getIsDelete()){
            // удаляем лишние
            $driver->deleteObjectIDs(
                $shopRegisterRawIDs->getChildArrayID(), $sitePageData->userID,
                Model_Ab1_Shop_Register_Raw::TABLE_NAME, array(), $sitePageData->shopID
            );

            return true;
        }

        $model = new Model_Ab1_Shop_Register_Raw();
        $model->setDBDriver($driver);

        /** Добавляем убытие основного сырья */
        $shopRegisterRawIDs->childShiftSetModel($model);
        $model->setShopObjectID($modelRawMaterial->id);
        $model->setTableID(Model_Ab1_Shop_Raw_Material::TABLE_ID);

        $model->setQuantity($modelRawMaterial->getQuantity() * -1);
        $model->setShopSubdivisionID($modelRawMaterial->getShopSubdivisionID());
        $model->setShopHeapID($modelRawMaterial->getShopHeapID());
        $model->setShopFormulaRawID($modelRawMaterial->getShopFormulaRawID());
        $model->setShopBallastCrusherID($modelRawMaterial->getShopBallastCrusherID());
        $model->setShopRawID($modelRawMaterial->getShopRawID());

        Helpers_DB::saveDBObject($model, $sitePageData);

        /** Добавляем прибытия произведенного сырья */
        $params = Request_RequestParams::setParams(
            array(
                'shop_raw_material_id' => $modelRawMaterial->id,
                'shop_raw_id_from' => 0,
                'sort_by' => array(
                    'id' => 'asc'
                )
            )
        );
        $shopRawMaterialItemIDs = Request_Request::find(
            'DB_Ab1_Shop_Raw_Material_Item', $sitePageData->shopID, $sitePageData, $driver, $params,
            0, TRUE
        );

        $raw = $modelRawMaterial->getShopRawID();
        $raws = array($raw => $raw);
        foreach ($shopRawMaterialItemIDs->childs as $child){
            $raw = $child->values['shop_raw_id'];
            $raws[$raw] = $raw;
        }

        foreach ($shopRawMaterialItemIDs->childs as $child){
            /** @var Model_Ab1_Shop_Raw_Material_Item $modelRawMaterialItem */
            $modelRawMaterialItem = $child->createModel('DB_Ab1_Shop_Raw_Material_Item');

            $shopRegisterRawIDs->childShiftSetModel($model);
            $model->setShopObjectID($modelRawMaterial->id);
            $model->setTableID(Model_Ab1_Shop_Raw_Material::TABLE_ID);

            $model->setQuantity($modelRawMaterialItem->getQuantity());

            $model->setShopSubdivisionID($modelRawMaterialItem->getShopSubdivisionID());
            $model->setShopHeapID($modelRawMaterialItem->getShopHeapID());
            $model->setShopFormulaRawID($modelRawMaterialItem->getShopFormulaRawID());
            $model->setShopBallastCrusherID($modelRawMaterialItem->getShopBallastCrusherID());
            $model->setShopRawID($modelRawMaterialItem->getShopRawID());

            Helpers_DB::saveDBObject($model, $sitePageData);
        }

        // удаляем лишние
        $driver->deleteObjectIDs(
            $shopRegisterRawIDs->getChildArrayID(), $sitePageData->userID,
            Model_Ab1_Shop_Register_Raw::TABLE_NAME, array(), $sitePageData->shopID
        );

        // пересчитываем остатки удаленного сырья
        foreach ($shopRegisterRawIDs->childs as $child){
            self::calcRawBalance(
                $child->values['shop_raw_id'],
                $child->values['shop_subdivision_id'],
                $child->values['shop_heap_id'],
                $sitePageData, $driver, true,
                $child->values['shop_id']
            );
        }

        // пересчитываем остатки
        foreach ($raws as $raw){
            self::calcRawBalance(
                $raw, $modelRawMaterial->getShopSubdivisionID(), $modelRawMaterial->getShopHeapID(),
                $sitePageData, $driver, true, $modelRawMaterial->shopID
            );
        }

        if($modelRawMaterial->getShopSubdivisionID() != $modelRawMaterial->getOriginalValue('shop_subdivision_id')
            || $modelRawMaterial->getShopHeapID() != $modelRawMaterial->getOriginalValue('shop_heap_id')){
            foreach ($raws as $raw){
                self::calcRawBalance(
                    $raw,
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
     * Пересохранения балласта в регистр сырья
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     */
    public static function addShopBallasts(SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        $params = Request_RequestParams::setParams(
            array(
                'sort_by' => array(
                    'id' => 'asc'
                )
            )
        );
        $shopBallastIDs = Request_Request::find(
            'DB_Ab1_Shop_Ballast', $sitePageData->shopID, $sitePageData, $driver, $params,
            0, TRUE
        );

        foreach ($shopBallastIDs->childs as $child){
            /** @var Model_Ab1_Shop_Ballast $model */
            $model = $child->createModel('DB_Ab1_Shop_Ballast', $driver);
            self::saveShopBallast($model, $sitePageData, $driver);
        }
    }

    /**
     * Пересохранения производство сырья в регистр
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     */
    public static function addShopRawMaterials(SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        $params = Request_RequestParams::setParams(
            array(
                'sort_by' => array(
                    'id' => 'asc'
                )
            )
        );
        $shopRawMaterialIDs = Request_Request::find(
            'DB_Ab1_Shop_Raw_Material', $sitePageData->shopID, $sitePageData, $driver, $params,
            0, TRUE
        );

        foreach ($shopRawMaterialIDs->childs as $child){
            /** @var Model_Ab1_Shop_Raw_Material $model */
            $model = $child->createModel('DB_Ab1_Shop_Raw_Material', $driver);

            self::saveShopRawMaterial($model, $sitePageData, $driver);
            Api_Ab1_Shop_Register_Material::saveShopRawMaterial($model, $sitePageData, $driver);
        }
    }

    /**
     * Считаем остатки сырья по подразделениям
     * @param $shopRawID
     * @param $shopSubdivisionID
     * @param $shopHeapID
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @param bool $isSaveBalance
     * @param int $shopID
     * @return float|int
     */
    public static function calcRawBalance($shopRawID, $shopSubdivisionID, $shopHeapID,
                                          SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver,
                                          $isSaveBalance = false, $shopID = 0)
    {
        if(!self::IS_CALC_BALANCE){
            return 0;
        }

        if($shopRawID < 1){
            return 0;
        }

        if($shopID < 1){
            $shopID = $sitePageData->shopID;
        }

        $params = Request_RequestParams::setParams(
            array(
                'shop_raw_id' => $shopRawID,
                'shop_subdivision_id' => $shopSubdivisionID,
                'shop_heap_id' => $shopHeapID,
                'sum_quantity' => true,
            )
        );
        $shopRegisterRawIDs = Request_Request::find(
            'DB_Ab1_Shop_Register_Raw', $shopID, $sitePageData, $driver, $params,
            0, TRUE
        );

        if(count($shopRegisterRawIDs->childs) == 0){
            return 0;
        }

        $quantity = floatval($shopRegisterRawIDs->childs[0]->values['quantity']);

        if($isSaveBalance){
            Api_Ab1_Shop_Raw_Balance::saveRawBalance(
                $quantity, $shopRawID, $shopSubdivisionID, $shopHeapID, $sitePageData, $driver
            );
        }

        return $quantity;
    }

    /**
     * Считаем остатки сырья по подразделениям
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     */
    public static function calcRawsBalance(SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        $params = Request_RequestParams::setParams(
            array(
                'sum_quantity' => true,
                'group_by' => array(
                    'shop_raw_id', 'shop_subdivision_id', 'shop_heap_id', 'shop_id',
                ),
            )
        );
        $shopRegisterRawIDs = Request_Request::findBranch(
            'DB_Ab1_Shop_Raw_Balance', array(), $sitePageData, $driver, $params, 0, TRUE
        );

        foreach ($shopRegisterRawIDs->childs as $child){
            Api_Ab1_Shop_Raw_Balance::saveRawBalance(
                $child->values['quantity'],
                $child->values['shop_raw_id'],
                $child->values['shop_subdivision_id'],
                $child->values['shop_heap_id'],
                $sitePageData, $driver,
                $child->values['shop_id']
            );
        }
    }

    /**
     * Пересчетать остатки материалов списка материла
     * @param MyArray $shopRegisterRawIDs
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     */
    private static function _calcShopRegisterRaw(MyArray $shopRegisterRawIDs, SitePageData $sitePageData,
                                                      Model_Driver_DBBasicDriver $driver)
    {
        // пересчитываем баланс материала
        foreach ($shopRegisterRawIDs->childs as $child){
            self::calcRawBalance(
                $child->values['shop_raw_id'],
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
     * @return boolean
     */
    private static function delShopRegisterRaw($id, $tableID, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
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
        $shopRegisterRawIDs = Request_Request::find(
            'DB_Ab1_Shop_Register_Raw', $sitePageData->shopID, $sitePageData, $driver, $params,
            0, TRUE
        );

        // удаляем лишние
        $driver->deleteObjectIDs(
            $shopRegisterRawIDs->getChildArrayID(), $sitePageData->userID,
            Model_Ab1_Shop_Register_Raw::TABLE_NAME, array('is_public' => 0), $sitePageData->shopID
        );

        // пересчитываем баланс материала
        self::_calcShopRegisterRaw($shopRegisterRawIDs, $sitePageData, $driver);
    }

    /**
     * Восстановление производства
     * @param $id
     * @param $tableID
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @return boolean
     */
    private static function unDelShopRegisterRaw($id, $tableID, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
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
        $shopRegisterRawIDs = Request_Request::find(
            'DB_Ab1_Shop_Register_Raw', $sitePageData->shopID, $sitePageData, $driver, $params,
            0, TRUE
        );

        // удаляем лишние
        $driver->unDeleteObjectIDs(
            $shopRegisterRawIDs->getChildArrayID(), $sitePageData->userID,
            Model_Ab1_Shop_Register_Raw::TABLE_NAME, array('is_public' => 1), $sitePageData->shopID
        );

        // пересчитываем баланс материала
        self::_calcShopRegisterRaw($shopRegisterRawIDs, $sitePageData, $driver);
    }

    /**
     * Удаление производство сырья из сырья
     * @param Model_Ab1_Shop_Raw_Material $modelRawMaterial
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @return boolean
     */
    public static function delShopRawMaterial(Model_Ab1_Shop_Raw_Material $modelRawMaterial, SitePageData $sitePageData,
                                              Model_Driver_DBBasicDriver $driver)
    {
        return self::delShopRegisterRaw($modelRawMaterial->id, Model_Ab1_Shop_Raw_Material::TABLE_ID, $sitePageData, $driver);
    }

    /**
     * Восстановление производство сырья из сырья
     * @param Model_Ab1_Shop_Raw_Material $modelRawMaterial
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @return boolean
     */
    public static function unDelShopRawMaterial(Model_Ab1_Shop_Raw_Material $modelRawMaterial, SitePageData $sitePageData,
                                                Model_Driver_DBBasicDriver $driver)
    {
        return self::unDelShopRegisterRaw($modelRawMaterial->id, Model_Ab1_Shop_Raw_Material::TABLE_ID, $sitePageData, $driver);
    }

    /**
     * Удаляем прибытие сырья через добычу
     * @param Model_Ab1_Shop_Ballast $modelBallast
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @return boolean
     */
    public static function delShopBallast(Model_Ab1_Shop_Ballast $modelBallast, SitePageData $sitePageData,
                                          Model_Driver_DBBasicDriver $driver)
    {
        return self::delShopRegisterRaw($modelBallast->id, Model_Ab1_Shop_Ballast::TABLE_ID, $sitePageData, $driver);
    }

    /**
     * Восстанавливаем прибытие сырья через добычу
     * @param Model_Ab1_Shop_Ballast $modelBallast
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @return boolean
     */
    public static function unDelShopBallast(Model_Ab1_Shop_Ballast $modelBallast, SitePageData $sitePageData,
                                            Model_Driver_DBBasicDriver $driver)
    {
        return self::unDelShopRegisterRaw($modelBallast->id, Model_Ab1_Shop_Ballast::TABLE_ID, $sitePageData, $driver);
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
        return self::delShopRegisterRaw($modelMoveCar->id, Model_Ab1_Shop_Move_Car::TABLE_ID, $sitePageData, $driver);
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
        return self::unDelShopRegisterRaw($modelMoveCar->id, Model_Ab1_Shop_Move_Car::TABLE_ID, $sitePageData, $driver);
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
        return self::delShopRegisterRaw($modelDefectCar->id, Model_Ab1_Shop_Defect_Car::TABLE_ID, $sitePageData, $driver);
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
        return self::unDelShopRegisterRaw($modelDefectCar->id, Model_Ab1_Shop_Defect_Car::TABLE_ID, $sitePageData, $driver);
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
        return self::delShopRegisterRaw($modelPieceItem->id, Model_Ab1_Shop_Piece_Item::TABLE_ID, $sitePageData, $driver);
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
        return self::unDelShopRegisterRaw($modelPieceItem->id, Model_Ab1_Shop_Piece_Item::TABLE_ID, $sitePageData, $driver);
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
        return self::delShopRegisterRaw($modelCar->id, Model_Ab1_Shop_Car::TABLE_ID, $sitePageData, $driver);
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
        return self::unDelShopRegisterRaw($modelCar->id, Model_Ab1_Shop_Car::TABLE_ID, $sitePageData, $driver);
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
        return self::delShopRegisterRaw($modelLesseeCar->id, Model_Ab1_Shop_Lessee_Car::TABLE_ID, $sitePageData, $driver);
    }

    /**
     * Восстановление производство продукта
     * @param Model_Ab1_Shop_Car $modelLesseeCar
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @return bool
     */
    public static function unDelShopLesseeCar(Model_Ab1_Shop_Car $modelLesseeCar, SitePageData $sitePageData,
                                              Model_Driver_DBBasicDriver $driver)
    {
        return self::unDelShopRegisterRaw($modelLesseeCar->id, Model_Ab1_Shop_Lessee_Car::TABLE_ID, $sitePageData, $driver);
    }
}
