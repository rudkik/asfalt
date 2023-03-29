<?php defined('SYSPATH') or die('No direct script access.');

class Api_Ab1_Shop_Payment_Material  {

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
        $isUnDel = Request_RequestParams::getParamBoolean("is_undel");

        $model = new Model_Ab1_Shop_Payment_Material();
        $model->setDBDriver($driver);

        if (!Helpers_DB::dublicateObjectLanguage($model, $id, $sitePageData)) {
            throw new HTTP_Exception_500('Payment material not found.');
        }

        if (($isUnDel && !$model->getIsDelete()) or (!$isUnDel && $model->getIsDelete())){
            return FALSE;
        }

        if($isUnDel){
            $model->dbUnDelete($sitePageData->userID, 0, $sitePageData->shopID);
        }else {
            $model->dbDelete($sitePageData->userID, 0, $sitePageData->shopID);
        }

        return TRUE;
    }


    /**
     * Сохранение товары
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @throws HTTP_Exception_500
     */
    public static function save(SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        $model = new Model_Ab1_Shop_Payment_Material();
        $model->setDBDriver($driver);

        $id = Request_RequestParams::getParamInt('id');
        if($id > 0) {
            if (!Helpers_DB::dublicateObjectLanguage($model, $id, $sitePageData)) {
                throw new HTTP_Exception_500('Payment material not found.');
            }
        }

        Request_RequestParams::setParamInt("shop_table_rubric_id", $model);
        Request_RequestParams::setParamBoolean('is_public', $model);
        Request_RequestParams::setParamStr('text', $model);
        Request_RequestParams::setParamStr('name', $model);
        Request_RequestParams::setParamBoolean("is_public", $model);
        Request_RequestParams::setParamStr("old_id", $model);
        Request_RequestParams::setParamInt("shop_table_select_id", $model);
        Request_RequestParams::setParamInt("shop_table_unit_id", $model);
        Request_RequestParams::setParamInt("shop_table_brand_id", $model);

        Request_RequestParams::setParamInt("rejection_reason_id", $model);
        Request_RequestParams::setParamInt('shop_supplier_id', $model);
        Request_RequestParams::setParamInt('shop_material_id', $model);
        Request_RequestParams::setParamFloat('price', $model);
        Request_RequestParams::setParamFloat('amount', $model);
        Request_RequestParams::setParamFloat('quantity', $model);

        Request_RequestParams::setParamDateTime('date', $model);

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

    /**
     * Сохранение товары
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @throws HTTP_Exception_500
     */
    public static function saveList(SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        $shopPaymentMaterialID = 0;
        $shopSupplierID = Request_RequestParams::getParamInt('shop_supplier_id');
        if ($shopSupplierID < 1){
            throw new HTTP_Exception_500('Supplier not found.');
        }

        $date = Request_RequestParams::getParamDateTime('date');

        $model = new Model_Ab1_Shop_Payment_Material();
        $model->setDBDriver($driver);

        $shopPaymentMaterialIDs = Request_Request::find('DB_Ab1_Shop_Payment_Material', $sitePageData->shopID, $sitePageData, $driver,
            array('shop_supplier_id' => $shopSupplierID, 'date' => $date, Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE), 0, TRUE);

        $shopPaymentMaterials = Request_RequestParams::getParamArray('shop_supplier_prices', array(), array());

        foreach($shopPaymentMaterials as $shopPaymentMaterial){
            $shopMaterialID = intval(Arr::path($shopPaymentMaterial, 'shop_material_id', ''));
            if($shopMaterialID < 1){
                continue;
            }
            $price = Request_RequestParams::strToFloat(Arr::path($shopPaymentMaterial, 'price', 0));
            if($price <= 0){
                continue;
            }
            $amount = Request_RequestParams::strToFloat(Arr::path($shopPaymentMaterial, 'amount', 0));
            if($amount <= 0){
                continue;
            }
            $quantity = Request_RequestParams::strToFloat(Arr::path($shopPaymentMaterial, 'quantity', 0));
            if($quantity <= 0){
                continue;
            }

            $model->clear();
            $shopPaymentMaterialID = array_shift($shopPaymentMaterialIDs->childs);
            if($shopPaymentMaterialID !== NULL){
                $model->__setArray(array('values' => $shopPaymentMaterialID->values));
            }

            $model->setShopSupplierID($shopSupplierID);
            $model->setShopMaterialID($shopMaterialID);
            $model->setPrice($price);
            $model->setAmount($amount);
            $model->setQuantity($quantity);
            $model->setDate($date);
            $shopPaymentMaterialID = Helpers_DB::saveDBObject($model, $sitePageData);
        }

        // удаляем лишние
        $driver->deleteObjectIDs($shopPaymentMaterialIDs->getChildArrayID(), $sitePageData->userID,
            Model_Ab1_Shop_Payment_Material::TABLE_NAME, array(), $sitePageData->shopID);

        return array(
            'id' => $shopPaymentMaterialID,
            'result' => array('error' => FALSE),
        );
    }
}
