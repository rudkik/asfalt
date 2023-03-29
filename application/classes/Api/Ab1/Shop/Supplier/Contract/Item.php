<?php defined('SYSPATH') or die('No direct script access.');

class Api_Ab1_Shop_Supplier_Contract_Item  {

    /**
     * Сохранение список материалов договора
     * @param $shopSupplierContractID
     * @param $shopSupplierID
     * @param array $shopSupplierContractItems
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @return array
     */
    public static function save($shopSupplierContractID, $shopSupplierID, array $shopSupplierContractItems,
                                SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        $model = new Model_Ab1_Shop_Supplier_Contract_Item();
        $model->setDBDriver($driver);

        $params = Request_RequestParams::setParams(
            array(
                'shop_supplier_contract_id' => $shopSupplierContractID
            )
        );
        $shopSupplierContractItemIDs = Request_Request::find('DB_Ab1_Shop_Supplier_Contract_Item',
            $sitePageData->shopMainID, $sitePageData, $driver, $params, 0, TRUE
        );

        $amount = 0;
        foreach($shopSupplierContractItems as $shopSupplierContractItem){
            $shopMaterialID = intval(Arr::path($shopSupplierContractItem, 'shop_material_id', 0));
            if($shopMaterialID <= 0){
                continue;
            }

            $quantity = Request_RequestParams::strToFloat(Arr::path($shopSupplierContractItem, 'quantity', 0));
            if($quantity <= 0){
                continue;
            }

            $price =  Request_RequestParams::strToFloat(Arr::path($shopSupplierContractItem, 'price', 0));
            if($price <= 0){
                continue;
            }

            $shopSupplierContractItemID = array_shift($shopSupplierContractItemIDs->childs);
            if($shopSupplierContractItemID !== NULL){
                $shopSupplierContractItemID->setModel($model);
            }else{
                $model->clear();
            }

            $model->setShopMaterialID($shopMaterialID);
            $model->setQuantity($quantity);
            $model->setPrice($price);
            $model->setShopSupplierContractID($shopSupplierContractID);
            $model->setShopSupplierID($shopSupplierID);
            Helpers_DB::saveDBObject($model, $sitePageData, $sitePageData->shopMainID);

            $amount += $model->getAmount();
        }

        // удаляем лишние
        $driver->deleteObjectIDs(
            $shopSupplierContractItemIDs->getChildArrayID(), $sitePageData->userID,
            Model_Ab1_Shop_Supplier_Contract_Item::TABLE_NAME, array(), $sitePageData->shopMainID
        );

        return $amount;
    }
}
