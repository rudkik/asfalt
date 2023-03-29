<?php defined('SYSPATH') or die('No direct script access.');

class Api_Ab1_Shop_Raw_Material_Item  {

    /**
     * @param Model_Ab1_Shop_Raw_Material $modelRawMaterial
     * @param array $shopRawMaterialItems
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @return bool
     */
    public static function save(Model_Ab1_Shop_Raw_Material $modelRawMaterial, array $shopRawMaterialItems,
                                SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        $model = new Model_Ab1_Shop_Raw_Material_Item();
        $model->setDBDriver($driver);

        $params = Request_RequestParams::setParams(
            array(
                'shop_raw_material_id' => $modelRawMaterial->id,
                'sort_by' => array(
                    'id' => 'asc',
                )
            )
        );
        $shopRawMaterialItemIDs = Request_Request::find(
            'DB_Ab1_Shop_Raw_Material_Item', $sitePageData->shopID, $sitePageData, $driver, $params,
            0, TRUE
        );
        $shopRawMaterialItemIDs->runIndex();

        foreach($shopRawMaterialItems as $key => $shopRawMaterialItem){
            $shopRawID = intval(Arr::path($shopRawMaterialItem, 'shop_raw_id', ''));
            $shopMaterialID = intval(Arr::path($shopRawMaterialItem, 'shop_material_id', ''));
            if($shopRawID < 1 && $shopMaterialID < 1){
                continue;
            }

            $norm = Request_RequestParams::strToFloat(Arr::path($shopRawMaterialItem, 'norm', 0));

            $shopRawMaterialItemIDs->childShiftSetModel($model, 0, $modelRawMaterial->shopID);
            $model->setShopRawID($shopRawID);
            $model->setShopMaterialID($shopMaterialID);
            $model->setNorm($norm);
            $model->setQuantity(round($modelRawMaterial->getQuantity() / 100 * $norm, 3));
            $model->setShopRawMaterialID($modelRawMaterial->id);
            $model->setShopBallastCrusherID($modelRawMaterial->getShopBallastCrusherID());
            $model->setDate($modelRawMaterial->getDate());
            $model->setShopSubdivisionID($modelRawMaterial->getShopSubdivisionID());
            $model->setShopHeapID($modelRawMaterial->getShopHeapID());

            Helpers_DB::saveDBObject($model, $sitePageData);
        }

        // удаляем лишние
        $driver->deleteObjectIDs(
            $shopRawMaterialItemIDs->getChildArrayID(), $sitePageData->userID,
            Model_Ab1_Shop_Raw_Material_Item::TABLE_NAME, array(), $sitePageData->shopID
        );

        // записываем данные в регистр прихода материала и сырья
        Api_Ab1_Shop_Register_Material::saveShopRawMaterial($modelRawMaterial, $sitePageData, $driver);
        Api_Ab1_Shop_Register_Raw::saveShopRawMaterial($modelRawMaterial, $sitePageData, $driver);

        return TRUE;
    }
}
