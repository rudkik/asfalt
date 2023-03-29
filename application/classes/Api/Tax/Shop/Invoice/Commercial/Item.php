<?php defined('SYSPATH') or die('No direct script access.');

class Api_Tax_Shop_Invoice_Commercial_Item  {

    /**
     * @param Model_Tax_Shop_Invoice_Commercial $modelInvoice
     * @param array $shopInvoiceCommercialItems
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @return float|int
     */
    public static function save(Model_Tax_Shop_Invoice_Commercial $modelInvoice, array $shopInvoiceCommercialItems, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        $shopInvoiceCommercialID = $modelInvoice->id;
        $shopContractorID = $modelInvoice->getShopContractorID();
        $nds = $modelInvoice->getNDS();

        $model = new Model_Tax_Shop_Invoice_Commercial_Item();
        $model->setDBDriver($driver);

        $shopInvoiceCommercialItemIDs = Request_Tax_Shop_Invoice_Commercial_Item::findShopInvoiceCommercialItemIDs($sitePageData->shopID, $sitePageData, $driver,
            array('shop_invoice_id' => $shopInvoiceCommercialID, Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE), 0, TRUE);

        $modelProduct = new Model_Tax_Shop_Product();
        $modelProduct->setDBDriver($driver);

        $total = 0;
        foreach($shopInvoiceCommercialItems as $shopInvoiceCommercialItem){
            $name = trim(Arr::path($shopInvoiceCommercialItem, 'shop_product_name', ''));
            if(empty($name)){
                continue;
            }
            $quantity = str_replace(',', '.', str_replace(' ', '', floatval(Arr::path($shopInvoiceCommercialItem, 'quantity', 0))));
            if($quantity <= 0){
                continue;
            }

            $isService = Request_RequestParams::isBoolean(Arr::path($shopInvoiceCommercialItem, 'is_service', FALSE));
            $price = str_replace(',', '.', str_replace(' ', '', floatval(Arr::path($shopInvoiceCommercialItem, 'price', 0))));

            // получаем единицу измерения
            $unit = trim(Arr::path($shopInvoiceCommercialItem, 'unit_name', ''));
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
            $shopInvoiceCommercialItemID = array_shift($shopInvoiceCommercialItemIDs->childs);
            if($shopInvoiceCommercialItemID !== NULL){
                $model->__setArray(array('values' => $shopInvoiceCommercialItemID->values));
            }

            $model->setShopContractorID($shopContractorID);
            $model->setShopProductID($shopProductID);
            $model->setUnitID($unitID);
            $model->setUnitName($unit);
            $model->setNDS($nds);

            $model->setQuantity($quantity);

            $model->setPrice($price);
            $model->setAmount($price * $quantity);

            $model->setShopInvoiceCommercialID($shopInvoiceCommercialID);
            Helpers_DB::saveDBObject($model, $sitePageData);

            $total = $total + $model->getAmount();
        }

        // удаляем лишние
        $driver->deleteObjectIDs($shopInvoiceCommercialItemIDs->getChildArrayID(), $sitePageData->userID,
            Model_Tax_Shop_Invoice_Commercial_Item::TABLE_NAME, array(), $sitePageData->shopID);

        return $total;
    }
}
