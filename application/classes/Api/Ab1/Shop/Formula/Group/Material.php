<?php defined('SYSPATH') or die('No direct script access.');

class Api_Ab1_Shop_Formula_Group_Material  {
    /**
     * @param Model_Ab1_Shop_Formula_Material $modelFormula
     * @param array $shopFormulaGroups
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @return bool
     */
    public static function save(Model_Ab1_Shop_Formula_Material $modelFormula, array $shopFormulaGroups, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        $model = new Model_Ab1_Shop_Formula_Group_Material();
        $model->setDBDriver($driver);

        $params = Request_RequestParams::setParams(
            array(
                'shop_formula_material_id' => $modelFormula->id,
                'sort_by' => array(
                    'id' => 'asc',
                )
            )
        );
        $shopFormulas = Request_Request::find('DB_Ab1_Shop_Formula_Group_Material',
            $sitePageData->shopID, $sitePageData, $driver, $params, 0, TRUE
        );

        foreach($shopFormulaGroups as $shopFormulaGroup){
            if($shopFormulaGroup < 1){
                continue;
            }
            $model->clear();
            $shopFormula = array_shift($shopFormulas->childs);
            if($shopFormula !== NULL){
                $model->__setArray(array('values' => $shopFormula->values));
            }

            $model->setShopFormulaGroupID($shopFormulaGroup);
            $model->setShopMaterialID($modelFormula->getShopMaterialID());
            $model->setShopFormulaMaterialID($modelFormula->id);
            Helpers_DB::saveDBObject($model, $sitePageData, $sitePageData->shopID);
        }

        // удаляем лишние
        $driver->deleteObjectIDs($shopFormulas->getChildArrayID(), $sitePageData->userID,
            Model_Ab1_Shop_Formula_Group_Material::TABLE_NAME, array(), $sitePageData->shopID);

        return TRUE;
    }
}
