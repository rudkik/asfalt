<?php defined('SYSPATH') or die('No direct script access.');

class Api_Ab1_Shop_Formula_Material  {

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

        $model = new Model_Ab1_Shop_Formula_Material();
        $model->setDBDriver($driver);

        if (!Helpers_DB::dublicateObjectLanguage($model, $id, $sitePageData)) {
            throw new HTTP_Exception_500('Formula not found.');
        }

        if(Request_RequestParams::getParamBoolean("is_undel") === TRUE){
            $model->dbUnDelete($sitePageData->userID, 0, $sitePageData->shopMainID);
        }else {
            $model->dbDelete($sitePageData->userID, 0, $sitePageData->shopMainID);
        }

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
        $model = new Model_Ab1_Shop_Formula_Material();
        $model->setDBDriver($driver);

        $id = Request_RequestParams::getParamInt('id');
        if($id > 0) {
            if (!Helpers_DB::dublicateObjectLanguage($model, $id, $sitePageData, $sitePageData->shopMainID)) {
                throw new HTTP_Exception_500('Formula not found.');
            }
        }

        Request_RequestParams::setParamBoolean('is_public', $model);
        Request_RequestParams::setParamStr('text', $model);
        Request_RequestParams::setParamStr('name', $model);
        Request_RequestParams::setParamStr("old_id", $model);
        Request_RequestParams::setParamInt('shop_material_id', $model);
        Request_RequestParams::setParamFloat('wet', $model);

        Request_RequestParams::setParamDate("from_at", $model);
        Request_RequestParams::setParamDate("to_at", $model);
        Request_RequestParams::setParamBoolean('is_start', $model);

        Request_RequestParams::setParamStr("contract_number", $model);
        Request_RequestParams::setParamDate("contract_date", $model);
        Request_RequestParams::setParamInt('formula_type_id', $model);

        $groupIDs = Request_RequestParams::getParamArray('shop_formula_group_ids');
        if ($groupIDs !== NULL) {
            $model->setShopFormulaGroupIDsArray($groupIDs);
        }

        $options = Request_RequestParams::getParamArray('options');
        if ($options !== NULL) {
            $model->addOptionsArray($options);
        }

        $result = array();
        if ($model->validationFields($result)) {

            if ($model->id < 1) {
                Helpers_DB::saveDBObject($model, $sitePageData);
            }

            // сохраняем значения рецепта
            $shopFormulaItems = Request_RequestParams::getParamArray('shop_formula_items');
            if($shopFormulaItems !== NULL) {
                Api_Ab1_Shop_Formula_Material_Item::save($model, $shopFormulaItems, false, $sitePageData, $driver);
            }

            // сохраняем побочное производства материала
            $shopFormulaItems = Request_RequestParams::getParamArray('shop_formula_sides');
            if($shopFormulaItems !== NULL) {
                Api_Ab1_Shop_Formula_Material_Item::save($model, $shopFormulaItems, true, $sitePageData, $driver);
            }

            // сохраняем группы
            Api_Ab1_Shop_Formula_Group_Material::save($model, $model->getShopFormulaGroupIDsArray(), $sitePageData, $driver);

            // загружаем фотографии
            $file = new Model_File($sitePageData);
            $file->saveFiles(Request_RequestParams::getParamArray('files'), $model, $sitePageData, $driver);

            Helpers_DB::saveDBObject($model, $sitePageData, $sitePageData->shopID);
            $result['values'] = $model->getValues();
        }

        return array(
            'id' => $model->id,
            'result' => $result,
        );
    }

    /**
     * Получаем ID рецепта
     * @param $shopMaterialID
     * @param $date
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @param int $shopID
     * @return int
     */
    public static function getShopFormulaMaterialID($shopMaterialID, $date, SitePageData $sitePageData,
                                                    Model_Driver_DBBasicDriver $driver, $shopID = 0){
        if($shopID < 1){
            $shopID = $sitePageData->shopID;
        }

        $params = Request_RequestParams::setParams(
            array(
                'shop_material_id' => $shopMaterialID,
                'from_at_to' => $date,
                'to_at_from_equally' => $date,
            )
        );
        $object = Request_Request::findOne(
            'DB_Ab1_Shop_Formula_Material', $shopID, $sitePageData, $driver, $params
        );

        if($object == null){
            return 0;
        }

        return $object->id;
    }
}
