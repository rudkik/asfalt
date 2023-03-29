<?php defined('SYSPATH') or die('No direct script access.');

class Api_Ab1_Shop_Invoice_Proforma_Item  {

    /**
     * @param Model_Ab1_Shop_Invoice_Proforma $modelInvoice
     * @param array $shopInvoiceProformaItems
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @return float|int
     */
    public static function save(Model_Ab1_Shop_Invoice_Proforma $modelInvoice, array $shopInvoiceProformaItems,
                                SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        $shopInvoiceProformaID = $modelInvoice->id;
        $shopClientID = $modelInvoice->getShopClientID();
        $shopClientContractID = $modelInvoice->getShopClientContractID();

        $model = new Model_Ab1_Shop_Invoice_Proforma_Item();
        $model->setDBDriver($driver);

        $shopInvoiceProformaItemIDs = Request_Request::find('DB_Ab1_Shop_Invoice_Proforma_Item',
            $sitePageData->shopID, $sitePageData, $driver,
            Request_RequestParams::setParams(
                array(
                    'shop_invoice_proforma_id' => $shopInvoiceProformaID,
                )
            ), 0, TRUE
        );

        $modelProduct = new Model_Ab1_Shop_Product();
        $modelProduct->setDBDriver($driver);

        $total = 0;
        foreach($shopInvoiceProformaItems as $shopInvoiceProformaItem){
            $shopProductID = Arr::path($shopInvoiceProformaItem, 'shop_product_id', '');
            $shopProductRubricID = Arr::path($shopInvoiceProformaItem, 'shop_product_rubric_id', '');

            $quantity = Request_RequestParams::strToFloat(Arr::path($shopInvoiceProformaItem, 'quantity', 0));
            if($quantity <= 0){
                continue;
            }

            $price = Request_RequestParams::strToFloat(Arr::path($shopInvoiceProformaItem, 'price', 0));
            if($price <= 0){
                continue;
            }

            $model->clear();
            $shopInvoiceProformaItemID = array_shift($shopInvoiceProformaItemIDs->childs);
            if($shopInvoiceProformaItemID !== NULL){
                $shopInvoiceProformaItemID->setModel($model);
            }

            $model->setShopClientID($shopClientID);
            $model->setShopClientContractID($shopClientContractID);
            $model->setShopProductID($shopProductID);
            $model->setShopProductRubricID($shopProductRubricID);
            $model->setQuantity($quantity);
            $model->setPrice($price);
            $model->setShopInvoiceProformaID($shopInvoiceProformaID);
            Helpers_DB::saveDBObject($model, $sitePageData);

            $total = $total + $model->getAmount();
        }

        $ids = array();
        foreach ($shopInvoiceProformaItemIDs->childs as $child){
            if($child->values['shop_invoice_proforma_id'] == $shopInvoiceProformaID){
                $ids[] = $child->id;
            }
        }

        // удаляем лишние
        $driver->deleteObjectIDs(
            $ids, $sitePageData->userID,
            Model_Ab1_Shop_Invoice_Proforma_Item::TABLE_NAME,
            array(), $sitePageData->shopID
        );

        return $total;
    }
}
