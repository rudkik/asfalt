<?php defined('SYSPATH') or die('No direct script access.');

class Api_Tax_Shop_Invoice_Item  {

    /**
     * Сохранение список продуктов
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @throws HTTP_Exception_500
     */
    public static function save($shopInvoiceID, $shopContractorID, array $shopInvoiceItems, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        $model = new Model_Tax_Shop_Invoice_Item();
        $model->setDBDriver($driver);

        $shopInvoiceItemIDs = Request_Tax_Shop_Invoice_Item::findShopInvoiceItemIDs($sitePageData->shopID, $sitePageData, $driver,
            array('shop_invoice_id' => $shopInvoiceID, Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE), 0, TRUE);

        $modelProduct = new Model_Tax_Shop_Product();
        $modelProduct->setDBDriver($driver);

        $total = 0;
        foreach($shopInvoiceItems as $shopInvoiceItem){
            $name = Arr::path($shopInvoiceItem, 'shop_product_name', '');
            if(empty($name)){
                continue;
            }
            $quantity = Request_RequestParams::strToFloat(Arr::path($shopInvoiceItem, 'quantity', 0));
            if($quantity <= 0){
                continue;
            }

            $isService = Request_RequestParams::isBoolean(Arr::path($shopInvoiceItem, 'is_service', FALSE));
            $price = Request_RequestParams::strToFloat(Arr::path($shopInvoiceItem, 'price', 0));

            // получаем единицу измерения
            $unit = trim(Arr::path($shopInvoiceItem, 'unit_name', ''));
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
                $modelProduct->setPrice($price);
                $modelProduct->setUnitName($unit);
                $modelProduct->setUnitID($unitID);

                $shopProductID = Helpers_DB::saveDBObject($modelProduct, $sitePageData);
            }

            $model->clear();
            $shopInvoiceItemID = array_shift($shopInvoiceItemIDs->childs);
            if($shopInvoiceItemID !== NULL){
                $model->__setArray(array('values' => $shopInvoiceItemID->values));
            }

            $model->setShopContractorID($shopContractorID);
            $model->setShopProductID($shopProductID);
            $model->setUnitID($unitID);
            $model->setUnitName($unit);

            $model->setQuantity($quantity);

            $model->setPrice($price);
            $model->setAmount($price * $quantity);

            $model->setShopInvoiceID($shopInvoiceID);
            Helpers_DB::saveDBObject($model, $sitePageData);

            $total = $total + $model->getAmount();
        }

        // удаляем лишние
        $driver->deleteObjectIDs($shopInvoiceItemIDs->getChildArrayID(), $sitePageData->userID, Model_Tax_Shop_Invoice_Item::TABLE_NAME);

        return $total;
    }
}
