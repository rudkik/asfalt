<?php defined('SYSPATH') or die('No direct script access.');

class Api_Ab1_Shop_Material_Balance  {
    /**
     * Получаем остатки материала по подразделению
     * @param $shopMaterialID
     * @param $shopSubdivisionID
     * @param $shopHeapID
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @return int|float
     */
    public static function getMaterialBalance($shopMaterialID, $shopSubdivisionID, $shopHeapID,
                                               SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        $params = Request_RequestParams::setParams(
            array(
                'shop_material_id' => $shopMaterialID,
                'shop_subdivision_id' => $shopSubdivisionID,
                'shop_heap_id' => $shopHeapID,
            )
        );
        $balance = Request_Request::findOne(
            'DB_Ab1_Shop_Material_Balance', $sitePageData->shopID, $sitePageData, $driver, $params
        );

        if($balance == null){
            return 0;
        }

        return floatval($balance->values['quantity']);
    }

    /**
     * Сохраняем остатки материала по подразделению
     * @param $quantity
     * @param $shopMaterialID
     * @param $shopSubdivisionID
     * @param $shopHeapID
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @param $shopID
     */
    public static function saveMaterialBalance($quantity, $shopMaterialID, $shopSubdivisionID, $shopHeapID,
                                               SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver, $shopID = 0)
    {
        if($shopID < 1){
            $shopID = $sitePageData->shopID;
        }

        $params = Request_RequestParams::setParams(
            array(
                'shop_material_id' => $shopMaterialID,
                'shop_subdivision_id' => $shopSubdivisionID,
                'shop_heap_id' => $shopHeapID,
            )
        );
        $model = Request_Request::findOneModel(
            'DB_Ab1_Shop_Material_Balance', $shopID, $sitePageData, $driver, $params
        );

        if($model == null){
            $model = new Model_Ab1_Shop_Material_Balance();
            $model->setDBDriver($driver);

            $model->setShopMaterialID($shopMaterialID);
            $model->setShopSubdivisionID($shopSubdivisionID);
            $model->setShopHeapID($shopHeapID);
        }

        $model->setQuantity($quantity);

        Helpers_DB::saveDBObject($model, $sitePageData, $shopID);
    }
}
