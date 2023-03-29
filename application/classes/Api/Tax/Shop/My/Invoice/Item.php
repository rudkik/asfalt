<?php defined('SYSPATH') or die('No direct script access.');

class Api_Tax_Shop_My_Invoice_Item  {

    /**
     * @param Model_Tax_Shop_My_Invoice $modelInvoice
     * @param array $shopMyInvoiceItems
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @return float|int
     */
    public static function save(Model_Tax_Shop_My_Invoice $modelInvoice, array $shopMyInvoiceItems, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        $shopMyInvoiceID = $modelInvoice->id;
        $shopContractorID = $modelInvoice->getShopContractorID();
        $nds = $modelInvoice->getNDS();

        $model = new Model_Tax_Shop_My_Invoice_Item();
        $model->setDBDriver($driver);

        $shopMyInvoiceItemIDs = Request_Tax_Shop_My_Invoice_Item::findShopMyInvoiceItemIDs($sitePageData->shopID, $sitePageData, $driver,
            array('shop_my_invoice_id' => $shopMyInvoiceID, Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE), 0, TRUE);

        $modelProduct = new Model_Tax_Shop_Product();
        $modelProduct->setDBDriver($driver);

        $total = 0;
        foreach($shopMyInvoiceItems as $shopMyInvoiceItem){
            $name = Arr::path($shopMyInvoiceItem, 'shop_product_name', '');
            if(empty($name)){
                continue;
            }
            $quantity = str_replace(',', '.', str_replace(' ', '', floatval(Arr::path($shopMyInvoiceItem, 'quantity', 0))));
            if($quantity <= 0){
                continue;
            }

            $isService = Request_RequestParams::isBoolean(Arr::path($shopMyInvoiceItem, 'is_service', FALSE));
            $price = str_replace(',', '.', str_replace(' ', '', floatval(Arr::path($shopMyInvoiceItem, 'price', 0))));

            // получаем единицу измерения
            $unit = trim(Arr::path($shopMyInvoiceItem, 'unit_name', ''));
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
            $shopMyInvoiceItemID = array_shift($shopMyInvoiceItemIDs->childs);
            if($shopMyInvoiceItemID !== NULL){
                $model->__setArray(array('values' => $shopMyInvoiceItemID->values));
            }

            $model->setShopContractorID($shopContractorID);
            $model->setShopProductID($shopProductID);
            $model->setUnitID($unitID);
            $model->setUnitName($unit);

            $model->setNDS($nds);

            $model->setQuantity($quantity);

            $model->setPrice($price);
            $model->setAmount(round(($price * $quantity) / 100 * (100 + $nds), 2));

            $model->setShopMyInvoiceID($shopMyInvoiceID);
            Helpers_DB::saveDBObject($model, $sitePageData);

            $total = $total + $model->getAmount();
        }

        // удаляем лишние
        $driver->deleteObjectIDs($shopMyInvoiceItemIDs->getChildArrayID(), $sitePageData->userID,
            Model_Tax_Shop_My_Invoice_Item::TABLE_NAME, array(), $sitePageData->shopID);

        return $total ;
    }
}
