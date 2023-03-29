<?php defined('SYSPATH') or die('No direct script access.');

class Api_Ab1_Shop_Product_Storage  {
    /**
     * удаление
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

        $model = new Model_Ab1_Shop_Product_Storage();
        $model->setDBDriver($driver);

        if (!Helpers_DB::dublicateObjectLanguage($model, $id, $sitePageData)) {
            throw new HTTP_Exception_500('Product storage not found.');
        }

        if (($isUnDel && !$model->getIsDelete()) or (!$isUnDel && $model->getIsDelete())){
            return FALSE;
        }

        if($isUnDel){
            $model->dbUnDelete($sitePageData->userID, 0, $sitePageData->shopID);
        }else {
            $model->dbDelete($sitePageData->userID, 0, $sitePageData->shopID);
        }

        // пересчитать баланс остатка продукции
        Api_Ab1_Shop_Product_Storage::calcProductBalance(
            $model->getShopProductID(), $model->getShopStorageID(), $sitePageData, $driver, true
        );

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
        $model = new Model_Ab1_Shop_Product_Storage();
        $model->setDBDriver($driver);

        $id = Request_RequestParams::getParamInt('id');
        if($id > 0) {
            if (!Helpers_DB::dublicateObjectLanguage($model, $id, $sitePageData)) {
                throw new HTTP_Exception_500('Product storage not found.');
            }
        }

        Request_RequestParams::setParamBoolean('is_public', $model);
        Request_RequestParams::setParamStr('text', $model);
        Request_RequestParams::setParamStr('name', $model);
        Request_RequestParams::setParamStr("old_id", $model);

        Request_RequestParams::setParamInt("shop_product_id", $model);
        Request_RequestParams::setParamFloat("quantity", $model);
        Request_RequestParams::setParamInt("asu_operation_id", $model);
        Request_RequestParams::setParamInt('shop_storage_id', $model);
        Request_RequestParams::setParamInt('shop_turn_place_id', $model);
        Request_RequestParams::setParamInt('shop_car_tare_id', $model);

        $model->setName(mb_strtoupper($model->getName()));

        $options = Request_RequestParams::getParamArray('options');
        if ($options !== NULL) {
            $model->addOptionsArray($options);
        }

        // определяем транспортную компанию
        if($model->isEditValue('shop_car_tare_id') || $model->getShopCarTareID() > 0){
            $carTare = Request_Request::findOneByField(
                'DB_Ab1_Shop_Car_Tare', 'id', $model->getShopCarTareID(), 0, $sitePageData, $driver
            );
            if($carTare != null) {
                $model->setShopTransportID($carTare->values['shop_transport_id']);
                $model->setName($carTare->values['name']);
            }else{
                $model->setShopTransportID(0);
                $model->setName('');
            }
        }

        // определяем привязку к путевому листу
        if($model->isEditValue('shop_transport_id')){
            $model->setShopTransportWaybillID(
                Api_Ab1_Shop_Transport_Waybill::findWaybillID(
                    $model->getShopTransportID(), $model->getCreatedAt(), $sitePageData, $driver
                )
            );
        }else{
            $model->setShopTransportWaybillID(0);
        }

        $result = array();
        if ($model->validationFields($result)) {
            if($model->id < 1) {
                $model->setWeightedOperationID($sitePageData->operationID);
                $model->setWeightedAt(date('Y-m-d H:i:s'));
                Helpers_DB::saveDBObject($model, $sitePageData);
            }

            // загружаем фотографии
            $file = new Model_File($sitePageData);
            $file->saveFiles(Request_RequestParams::getParamArray('files'), $model, $sitePageData, $driver);

            Helpers_DB::saveDBObject($model, $sitePageData);
            $result['values'] = $model->getValues();

            // пересчитать баланс остатка продукции
            Api_Ab1_Shop_Product_Storage::calcProductBalance(
                $model->getShopProductID(), $model->getShopStorageID(), $sitePageData, $driver, true
            );
            if($model->getShopProductID() != $model->getOriginalValue('shop_product_id')
                || $model->getShopStorageID() != $model->getOriginalValue('shop_storage_id')) {
                Api_Ab1_Shop_Product_Storage::calcProductBalance(
                    $model->getOriginalValue('shop_product_id'),
                    $model->getOriginalValue('shop_storage_id'),
                    $sitePageData, $driver, true
                );
            }
        }

        return array(
            'id' => $model->id,
            'result' => $result,
        );
    }

    /**
     * Считаем остатки продукции на складе
     * @param $shopProductID
     * @param $shopStorageID
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @param bool $isSaveBalance
     * @param int $shopID
     * @return float|int
     */
    public static function calcProductBalance($shopProductID, $shopStorageID,
                                              SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver,
                                              $isSaveBalance = false, $shopID = 0)
    {
        if($shopProductID < 1 || $shopStorageID < 0){
            return 0;
        }

        if($shopID < 1){
            $shopID = $sitePageData->shopID;
        }

        $params = Request_RequestParams::setParams(
            array(
                'shop_product_id' => $shopProductID,
                'shop_storage_id' => $shopStorageID,
                'sum_quantity' => true,
            )
        );
        $shopRegisterMaterialIDs = Request_Request::find(
            'DB_Ab1_Shop_Product_Storage', $shopID, $sitePageData, $driver, $params,
            0, TRUE
        );

        if(count($shopRegisterMaterialIDs->childs) == 0){
            return 0;
        }

        $quantity = floatval($shopRegisterMaterialIDs->childs[0]->values['quantity']);

        if($isSaveBalance){
            Api_Ab1_Shop_Product_Balance::saveProductBalance(
                $quantity, $shopProductID, $shopStorageID, $sitePageData, $driver, $shopID
            );
        }

        return $quantity;
    }

    /**
     * Считаем остатки продукции по складам
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     */
    public static function calcProductsBalance(SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        $params = Request_RequestParams::setParams(
            array(
                'sum_quantity' => true,
                'group_by' => array(
                    'shop_product_id', 'shop_storage_id', 'shop_id',
                ),
            )
        );
        $shopRegisterProductIDs = Request_Request::findBranch(
            'DB_Ab1_Shop_Product_Storage', array(), $sitePageData, $driver, $params, 0, TRUE
        );

        foreach ($shopRegisterProductIDs->childs as $child){
            Api_Ab1_Shop_Product_Balance::saveProductBalance(
                $child->values['quantity'],
                $child->values['shop_product_id'],
                $child->values['shop_storage_id'],
                $sitePageData, $driver,
                $child->values['shop_id']
            );
        }
    }
}
