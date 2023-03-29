<?php defined('SYSPATH') or die('No direct script access.');

class Api_Ab1_Shop_Formula_Raw_Item  {
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

        $model = new Model_Ab1_Shop_Formula_Raw();
        $model->setDBDriver($driver);

        if (!Helpers_DB::dublicateObjectLanguage($model, $id, $sitePageData)) {
            throw new HTTP_Exception_500('Formula not found.');
        }

        if (($isUnDel && !$model->getIsDelete()) or (!$isUnDel && $model->getIsDelete())){
            return FALSE;
        }

        if($isUnDel){
            $params = Request_RequestParams::setParams(
                array(
                    'shop_formula_raw_id' => $id,
                    'is_delete' => 1,
                    'is_public' => FALSE,
                )
            );
            $ids = Request_Request::find('DB_Ab1_Shop_Formula_Raw_Item', $sitePageData->shopID, $sitePageData, $driver, $params);
            $driver->unDeleteObjectIDs(
                $ids->getChildArrayID(), $sitePageData->userID, Model_Ab1_Shop_Formula_Raw_Item::TABLE_NAME,
                array('is_public' => 1), $sitePageData->shopID
            );

            $model->dbUnDelete($sitePageData->userID, 0, $sitePageData->shopID);
        }else {
            $params = Request_RequestParams::setParams(
                array(
                    'shop_formula_raw_id' => $id,
                    'is_delete' => 0,
                    'is_public' => TRUE,
                )
            );
            $ids = Request_Request::find('DB_Ab1_Shop_Formula_Raw_Item', $sitePageData->shopID, $sitePageData, $driver, $params);
            $driver->deleteObjectIDs(
                $ids->getChildArrayID(), $sitePageData->userID, Model_Ab1_Shop_Formula_Raw_Item::TABLE_NAME,
                array('is_public' => 0), $sitePageData->shopID
            );

            $model->dbDelete($sitePageData->userID, 0, $sitePageData->shopID);
        }

        return TRUE;
    }

    /**
     * @param Model_Ab1_Shop_Formula_Raw $modelFormula
     * @param array $shopFormulaItems
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @return bool
     */
    public static function save(Model_Ab1_Shop_Formula_Raw $modelFormula, array $shopFormulaItems, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        $model = new Model_Ab1_Shop_Formula_Raw_Item();
        $model->setDBDriver($driver);

        $params = Request_RequestParams::setParams(
            array(
                'shop_formula_raw_id' => $modelFormula->id,
                'sort_by' => array(
                    'id' => 'asc',
                )
            )
        );
        $shopFormulas = Request_Request::find(
            'DB_Ab1_Shop_Formula_Raw_Item', $sitePageData->shopID, $sitePageData, $driver, $params, 0, TRUE
        );

        foreach($shopFormulaItems as $shopFormulaItem){
            $shopRawID = intval(Arr::path($shopFormulaItem, 'shop_raw_id', 0));
            $shopMaterialID = intval(Arr::path($shopFormulaItem, 'shop_material_id', 0));
            if($shopRawID < 1 && $shopMaterialID < 1){
                continue;
            }

            $norm = Request_RequestParams::strToFloat(Arr::path($shopFormulaItem, 'norm', 0));

            $model->clear();
            $shopFormula = array_shift($shopFormulas->childs);
            if($shopFormula !== NULL){
                $model->__setArray(array('values' => $shopFormula->values));
            }

            $model->setShopRawID($shopRawID);
            $model->setShopMaterialID($shopMaterialID);
            $model->setNorm($norm);
            $model->setShopFormulaRawID($modelFormula->id);
            $model->setShopBallastCrusherID($modelFormula->getShopBallastCrusherID());
            $model->setFromAt($modelFormula->getFromAt());
            $model->setToAt($modelFormula->getToAt());
            $model->setIsStart($modelFormula->getIsStart());

            $options = Arr::path($shopFormulaItem, 'options', array());
            if(is_array($options)) {
                $model->addOptionsArray($options);
            }

            Helpers_DB::saveDBObject($model, $sitePageData, $sitePageData->shopID);
        }

        // удаляем лишние
        $driver->deleteObjectIDs(
            $shopFormulas->getChildArrayID(), $sitePageData->userID,
            Model_Ab1_Shop_Formula_Raw_Item::TABLE_NAME, array(), $sitePageData->shopID
        );

        return TRUE;
    }
}
