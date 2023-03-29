<?php defined('SYSPATH') or die('No direct script access.');

class Api_Tax_Shop_My_Attorney_Item  {

    /**
     * Сохранение список продуктов
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @throws HTTP_Exception_500
     */
    public static function save($shopMyAttorneyID, $shopContractorID, array $shopMyAttorneyItems, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        $model = new Model_Tax_Shop_My_Attorney_Item();
        $model->setDBDriver($driver);

        $shopMyAttorneyItemIDs = Request_Tax_Shop_My_Attorney_Item::findShopMyAttorneyItemIDs($sitePageData->shopID, $sitePageData, $driver,
            array('shop_my_attorney_id' => $shopMyAttorneyID, Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE), 0, TRUE);

        $modelProduct = new Model_Tax_Shop_Product();
        $modelProduct->setDBDriver($driver);

        $total = 0;
        foreach($shopMyAttorneyItems as $shopMyAttorneyItem){
            $name = Arr::path($shopMyAttorneyItem, 'shop_product_name', '');
            if(empty($name)){
                continue;
            }
            $quantity = str_replace(',', '.', str_replace(' ', '', floatval(Arr::path($shopMyAttorneyItem, 'quantity', 0))));
            if($quantity <= 0){
                continue;
            }

            $isService = Request_RequestParams::isBoolean(Arr::path($shopMyAttorneyItem, 'is_service', FALSE));
            $price = str_replace(',', '.', str_replace(' ', '', floatval(Arr::path($shopMyAttorneyItem, 'price', 0))));

            // получаем единицу измерения
            $unit = trim(Arr::path($shopMyAttorneyItem, 'unit_name', ''));
            if (!empty($unit)) {
                $unitID = Request_Request::findOneByNameNotShop('DB_Tax_Unit', $unit, $sitePageData, $driver);
                if ($unitID !== NULL){
                    $unitID = $unitID->id;
                } else {
                    $unitID = 0;
                }
            }else{
                $unitID = 0;
                $unit = '';
            }

            // получаем товар
            $shopProductID = Request_Request::findOneByName('DB_Tax_Shop_Product', $name, $sitePageData->shopID, $sitePageData, $driver);
            if ($shopProductID !== NULL){
                if ($isService != Request_RequestParams::isBoolean($shopProductID->values['is_service'])){
                    $modelProduct->clear();
                    $modelProduct->__setArray(array('values' => $shopProductID->values));

                    $modelProduct->setIsService($isService);
                    if ($modelProduct->getPrice() <= 0){
                        $modelProduct->setPrice($price);
                    }
                    $shopProductID = Helpers_DB::saveDBObject($modelProduct, $sitePageData);
                }elseif ($shopProductID->values['price'] <= 0){
                    $modelProduct->clear();
                    $modelProduct->__setArray(array('values' => $shopProductID->values));

                    $modelProduct->setPrice($price);
                    $shopProductID = Helpers_DB::saveDBObject($modelProduct, $sitePageData);
                }

                $shopProductID = $shopProductID->id;
            }else{
                $modelProduct->clear();

                $modelProduct->setName($name);
                $modelProduct->setIsService($isService);
                $modelProduct->setUnitName($unit);
                $modelProduct->setUnitID($unitID);

                $shopProductID = Helpers_DB::saveDBObject($modelProduct, $sitePageData);
            }

            $model->clear();
            $shopMyAttorneyItemID = array_shift($shopMyAttorneyItemIDs->childs);
            if($shopMyAttorneyItemID !== NULL){
                $model->__setArray(array('values' => $shopMyAttorneyItemID->values));
            }

            $model->setShopContractorID($shopContractorID);
            $model->setShopProductID($shopProductID);
            $model->setUnitID($unitID);
            $model->setUnitName($unit);

            $model->setQuantity($quantity);

            $model->setPrice($price);
            $model->setAmount($price * $quantity);

            $model->setShopMyAttorneyID($shopMyAttorneyID);
            Helpers_DB::saveDBObject($model, $sitePageData);

            $total = $total + $model->getAmount();
        }

        // удаляем лишние
        $driver->deleteObjectIDs($shopMyAttorneyItemIDs->getChildArrayID(), $sitePageData->userID,
            Model_Tax_Shop_My_Attorney_Item::TABLE_NAME, array(), $sitePageData->shopID);

        return $total;
    }
}
