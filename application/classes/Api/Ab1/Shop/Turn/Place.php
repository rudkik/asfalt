<?php defined('SYSPATH') or die('No direct script access.');

class Api_Ab1_Shop_Turn_Place  {

    /**
     * Ставим очередь для машины через весовую
     * @param Model_Shop_Table_Basic_Table $model
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     */
    public static function setTurn(Model_Shop_Table_Basic_Table $model, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        if($model->getShopTurnID() < 1){
            $model->setShopTurnID(Model_Ab1_Shop_Turn::TURN_CASH);
        }

        $shopTurnID = Request_RequestParams::getParamInt('shop_turn_id');
        if($shopTurnID !== NULL){
            switch($model->getShopTurnID()){
                case Model_Ab1_Shop_Turn::TURN_CASH:
                    if($shopTurnID == Model_Ab1_Shop_Turn::TURN_WEIGHTED_ENTRY){
                        $modelTurnType = Api_Ab1_Shop_Turn_Type::getByModelShopProduct(
                            $model->getShopProductID(), $sitePageData, $driver
                        );

                        if ($modelTurnType != null){
                            if (($modelTurnType->getIsSkipWeighted()) && ($modelTurnType->getIsSkipAsu())){
                                $shopTurnID = Model_Ab1_Shop_Turn::TURN_CASH_EXIT;
                            }elseif($modelTurnType->getIsSkipWeighted()){
                                $shopTurnID = Model_Ab1_Shop_Turn::TURN_ASU;
                            }
                        }

                        $model->setWeightedEntryOperationID($sitePageData->operationID);
                        $model->setWeightedEntryAt(date('Y-m-d H:i:s'));
                    }
                    break;
                case Model_Ab1_Shop_Turn::TURN_WEIGHTED_ENTRY:
                    if($shopTurnID == Model_Ab1_Shop_Turn::TURN_ASU){
                        $modelTurnType = Api_Ab1_Shop_Turn_Type::getByModelShopTurnPlace(
                            $model->getShopTurnPlaceID(), $model->getShopProductID(), $sitePageData, $driver
                        );

                        if ($modelTurnType != null){
                            if ($modelTurnType->getIsSkipAsu()) {
                                $shopTurnID = Model_Ab1_Shop_Turn::TURN_WEIGHTED_EXIT;
                            }
                        }

                        $model->setWeightedEntryOperationID($sitePageData->operationID);
                        $model->setWeightedEntryAt(date('Y-m-d H:i:s'));
                    }
                    break;
                case Model_Ab1_Shop_Turn::TURN_ASU:
                    if($shopTurnID == Model_Ab1_Shop_Turn::TURN_WEIGHTED_EXIT){
                        $model->setAsuOperationID($sitePageData->operationID);
                        $model->setAsuAt(date('Y-m-d H:i:s'));
                    }
                    break;
                case Model_Ab1_Shop_Turn::TURN_WEIGHTED_EXIT:
                    if($shopTurnID == Model_Ab1_Shop_Turn::TURN_EXIT){
                        $model->setWeightedExitOperationID($sitePageData->operationID);
                        $model->setWeightedExitAt(date('Y-m-d H:i:s'));
                    }
                    break;
            }
            $model->setShopTurnID($shopTurnID);
        }
        if($model->getShopTurnID() == Model_Ab1_Shop_Turn::TURN_CASH_EXIT && $model->getIsDebt()){
            $model->setShopTurnID(Model_Ab1_Shop_Turn::TURN_EXIT);
        }
        if($model->getShopTurnID() == Model_Ab1_Shop_Turn::TURN_EXIT) {
            $model->setIsExit(TRUE);
        }
        if($model->getShopTurnID() == Model_Ab1_Shop_Turn::TURN_WEIGHTED_EXIT
            && !Func::_empty($model->getWeightedExitAt())
            && !Func::_empty($model->getWeightedExitOperationID())) {
            $model->setShopTurnID(Model_Ab1_Shop_Turn::TURN_CASH_EXIT);
        }

        // если на АСУ меняют место погрузки, то проверяем нужно ли сразу переводить на весовую и малый сбыт
        if ($model->getShopTurnPlaceID() != $model->getOriginalValue('shop_turn_place_id')) {
            $modelTurnPlace = new Model_Ab1_Shop_Turn_Place();
            $modelTurnPlace->setDBDriver($driver);
            if (Helpers_DB::getDBObject($modelTurnPlace, $model->getShopTurnPlaceID(), $sitePageData, $sitePageData->shopID)) {
                $model->setShopStorageID($modelTurnPlace->getShopStorageID());
                $model->setShopSubdivisionID($modelTurnPlace->getShopSubdivisionID());
                $model->setShopHeapID($modelTurnPlace->getShopHeapID());

                if ($model->getShopTurnID() == Model_Ab1_Shop_Turn::TURN_ASU) {
                    $modelTurnType = Api_Ab1_Shop_Turn_Type::getByModelShopTurnPlace(
                        $model->getShopTurnPlaceID(), $model->getShopProductID(), $sitePageData, $driver
                    );

                    if ($modelTurnType != null){
                        if ($modelTurnType->getIsSkipAsu()) {
                            $model->setShopTurnID(Model_Ab1_Shop_Turn::TURN_WEIGHTED_EXIT);
                        }
                        if ($modelTurnType->getIsSkipWeighted()) {
                            $model->setShopTurnID(Model_Ab1_Shop_Turn::TURN_EXIT);
                        }
                    }
                } elseif ($model->getShopTurnID() == Model_Ab1_Shop_Turn::TURN_WEIGHTED_EXIT) {
                    $modelTurnType = Api_Ab1_Shop_Turn_Type::getByModelShopTurnPlace(
                        $model->getShopTurnPlaceID(), $model->getShopProductID(), $sitePageData, $driver
                    );

                    if ($modelTurnType != null){
                        if (!$modelTurnType->getIsSkipAsu() && $model->getAsuOperationID() < 1) {
                            $model->setShopTurnID(Model_Ab1_Shop_Turn::TURN_ASU);
                        }
                    }
                }
            }
        }

        $isExit = Request_RequestParams::getParamBoolean('is_exit');
        if($isExit && (! $model->getIsExit())){
            $model->setIsExit(TRUE);
            if($model->getShopTurnID() != Model_Ab1_Shop_Turn::TURN_EXIT){
                $model->setWeightedExitOperationID($sitePageData->operationID);
                $model->setWeightedExitAt(date('Y-m-d H:i:s'));
                $model->getShopTurnID(Model_Ab1_Shop_Turn::TURN_EXIT);
            }
        }

        // если пропущено установка подраздения, то берем из продукции
        if($model->getShopSubdivisionID() < 1){
            $modelProduct = new Model_Ab1_Shop_Product();
            $modelProduct->setDBDriver($driver);

            if (Helpers_DB::getDBObject($modelProduct, $model->getShopProductID(), $sitePageData, $sitePageData->shopID)) {
                $model->setShopSubdivisionID($modelProduct->getShopSubdivisionID());

                if($model->getShopStorageID() < 1){
                    $model->setShopStorageID($modelProduct->getShopStorageID());
                }
            }
        }
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

        $model = new Model_Ab1_Shop_Turn_Place();
        $model->setDBDriver($driver);

        if (!Helpers_DB::dublicateObjectLanguage($model, $id, $sitePageData)) {
            throw new HTTP_Exception_500('TurnPlace not found.');
        }

        if(Request_RequestParams::getParamBoolean("is_undel") === TRUE){
            $model->dbUnDelete($sitePageData->userID, 0, $sitePageData->shopID);
        }else {
            $model->dbDelete($sitePageData->userID, 0, $sitePageData->shopID);
        }
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
        $model = new Model_Ab1_Shop_Turn_Place();
        $model->setDBDriver($driver);

        $id = Request_RequestParams::getParamInt('id');
        if($id > 0) {
            if (!Helpers_DB::dublicateObjectLanguage($model, $id, $sitePageData)) {
                throw new HTTP_Exception_500('TurnPlace not found.');
            }
        }

        Request_RequestParams::setParamBoolean('is_public', $model);
        Request_RequestParams::setParamStr('text', $model);
        Request_RequestParams::setParamStr('name', $model);
        Request_RequestParams::setParamStr("old_id", $model);
        Request_RequestParams::setParamInt("shop_subdivision_id", $model);
        Request_RequestParams::setParamInt("shop_storage_id", $model);
        Request_RequestParams::setParamInt("shop_heap_id", $model);
        Request_RequestParams::setParamInt('shop_turn_type_id', $model);

        $options = Request_RequestParams::getParamArray('options');
        if ($options !== NULL) {
            $model->addOptionsArray($options);
        }

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
