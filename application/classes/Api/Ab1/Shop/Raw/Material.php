<?php defined('SYSPATH') or die('No direct script access.');

class Api_Ab1_Shop_Raw_Material  {

    /**
     * Считаем количество сырья собственного производства
     * @param $dateFrom
     * @param $dateTo
     * @param $shopBranchDaughterID
     * @param $shopRawID
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @return int
     */
    public static function calcImportQuantity($dateFrom, $dateTo, $shopBranchDaughterID, $shopRawID,
                                              SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        $quantity = 0;

        // собственное производство
        $params = array(
            'shop_raw_id' => $shopRawID,
            'sum_quantity' => true,
            'date_from_equally' => $dateFrom,
            'date_to' => $dateTo,
        );
        if(!empty($shopBranchDaughterID)){
            $params['shop_id'] = $shopBranchDaughterID;
        }

        $data = Request_Request::findBranch(
            'DB_Ab1_Shop_Raw_Material_Item', array(), $sitePageData, $driver, Request_RequestParams::setParams($params)
        );

        if(count($data->childs) > 0){
            $quantity = $data->childs[0]->values['quantity'];
        }

        // добыча балласта
        $params = array(
            'shop_raw_id' => $shopRawID,
            'sum_quantity' => true,
            'date_from_equally' => $dateFrom,
            'date_to' => $dateTo,
        );
        if(!empty($shopBranchDaughterID)){
            $params['shop_id'] = $shopBranchDaughterID;
        }

        $data = Request_Request::findBranch(
            'DB_Ab1_Shop_Ballast', array(), $sitePageData, $driver, Request_RequestParams::setParams($params)
        );

        if(count($data->childs) > 0){
            $quantity += $data->childs[0]->values['quantity'];
        }

        return $quantity;
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
        $isUnDel = Request_RequestParams::getParamBoolean("is_undel");

        $model = new Model_Ab1_Shop_Raw_Material();
        $model->setDBDriver($driver);

        if (!Helpers_DB::dublicateObjectLanguage($model, $id, $sitePageData)) {
            throw new HTTP_Exception_500('Formula not found.');
        }

        if (($isUnDel && !$model->getIsDelete()) or (!$isUnDel && $model->getIsDelete())){
            return FALSE;
        }

        if ($isUnDel){
            $shopRawMaterialItemIDs = Request_Request::find(
                'DB_Ab1_Shop_Raw_Material_Item', $sitePageData->shopID, $sitePageData, $driver,
                Request_RequestParams::setParams(
                    array(
                        'shop_raw_material_id' => $id,
                        'is_delete' => 1,
                        'is_public' => 0,
                    )
                )
            );

            $driver->unDeleteObjectIDs(
                $shopRawMaterialItemIDs->getChildArrayID(), $sitePageData->userID,
                Model_Ab1_Shop_Raw_Material_Item::TABLE_NAME, array('is_public' => 1), $sitePageData->shopID
            );
        }else{
            $shopRawMaterialItemIDs = Request_Request::find(
                'DB_Ab1_Shop_Raw_Material_Item', $sitePageData->shopID, $sitePageData, $driver,
                Request_RequestParams::setParams(
                    array(
                        'shop_raw_material_id' => $id,
                    )
                )
            );

            $driver->deleteObjectIDs(
                $shopRawMaterialItemIDs->getChildArrayID(), $sitePageData->userID,
                Model_Ab1_Shop_Raw_Material_Item::TABLE_NAME, array('is_public' => 0), $sitePageData->shopID
            );
        }

        if(Request_RequestParams::getParamBoolean("is_undel") === TRUE){
            $model->dbUnDelete($sitePageData->userID, 0, $sitePageData->shopID);

            Api_Ab1_Shop_Register_Raw::unDelShopRawMaterial($model, $sitePageData, $driver);
            Api_Ab1_Shop_Register_Material::unDelShopRawMaterial($model, $sitePageData, $driver);
        }else {
            $model->dbDelete($sitePageData->userID, 0, $sitePageData->shopID);

            Api_Ab1_Shop_Register_Raw::delShopRawMaterial($model, $sitePageData, $driver);
            Api_Ab1_Shop_Register_Material::delShopRawMaterial($model, $sitePageData, $driver);
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
        $model = new Model_Ab1_Shop_Raw_Material();
        $model->setDBDriver($driver);

        $id = Request_RequestParams::getParamInt('id');
        if($id > 0) {
            if (!Helpers_DB::dublicateObjectLanguage($model, $id, $sitePageData)) {
                throw new HTTP_Exception_500('Material from raw not found.');
            }
        }

        Request_RequestParams::setParamBoolean('is_public', $model);
        Request_RequestParams::setParamStr('text', $model);
        Request_RequestParams::setParamStr('name', $model);
        Request_RequestParams::setParamStr("old_id", $model);
        Request_RequestParams::setParamInt('shop_raw_id', $model);
        Request_RequestParams::setParamInt('shop_formula_raw_id', $model);
        Request_RequestParams::setParamInt('shop_ballast_crusher_id', $model);
        Request_RequestParams::setParamDate("date", $model);
        Request_RequestParams::setParamFloat("quantity", $model);

        $options = Request_RequestParams::getParamArray('options');
        if ($options !== NULL) {
            $model->addOptionsArray($options);
        }

        $result = array();
        if ($model->validationFields($result)) {
            if ($model->id < 1) {
                Helpers_DB::saveDBObject($model, $sitePageData);
            }

            /** @var Model_Ab1_Shop_Ballast_Crusher $modelCrusher */
            $modelCrusher = $model->getElement('shop_ballast_crusher_id', true, $sitePageData->shopMainID);
            if($modelCrusher == null){
                $model->setShopSubdivisionID(0);
                $model->setShopHeapID(0);
            }else{
                $model->setShopSubdivisionID($modelCrusher->getShopSubdivisionID());
                $model->setShopHeapID($modelCrusher->getShopHeapID());
            }

            // загружаем фотографии
            $file = new Model_File($sitePageData);
            $file->saveFiles(Request_RequestParams::getParamArray('files'), $model, $sitePageData, $driver);

            Helpers_DB::saveDBObject($model, $sitePageData, $sitePageData->shopID);
            $result['values'] = $model->getValues();

            // сохраняем значения рецепта
            $shopRawMaterialItems = Request_RequestParams::getParamArray('shop_raw_material_items');
            if($shopRawMaterialItems !== NULL) {
                Api_Ab1_Shop_Raw_Material_Item::save($model, $shopRawMaterialItems, $sitePageData, $driver);
            }
        }

        return array(
            'id' => $model->id,
            'result' => $result,
        );
    }
}
