<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Tax_ShopReport extends Controller_Tax_BasicShop {

    public function __construct(Request $request, Response $response)
    {
        $this->controllerName = 'shopreport';
        $this->objectName = 'report';

        parent::__construct($request, $response);
    }

    /**
     * сортировка по имени
     * @param $x
     * @param $y
     * @return int
     */
    function mySortMethod($x, $y) {
        return strcasecmp($x['name'], $y['name']);
    }

    public function action_invoice() {
        $this->_sitePageData->url = '/tax/shopexcel/invoice';

        $filePath = APPPATH.'views' . DIRECTORY_SEPARATOR . $this->_sitePageData->shopShablonPath . DIRECTORY_SEPARATOR
            . 'excel' . DIRECTORY_SEPARATOR . $this->_sitePageData->dataLanguageID . DIRECTORY_SEPARATOR . 'invoice.xls';
        if(!file_exists($filePath)){
            throw new HTTP_Exception_500('File shablon not is found.');
        }

        // id записи
        $id = Request_RequestParams::getParamInt('id');
        $model = new Model_Tax_Shop_Invoice_Commercial();
        if (!Helpers_DB::getDBObject($model, $id, $this->_sitePageData)) {
            throw new HTTP_Exception_404('Invoice not is found!');
        }

        $model->dbGetElements($this->_sitePageData->shopID, array('shop_contract_id', 'shop_contractor_id', 'shop_attorney_id', 'paid_type_id'),
            $this->_sitePageData->languageIDDefault);

        $invoice = $model->getValues(TRUE, TRUE);
        $invoice['amount_str'] = Func::numberToStr($model->getAmount(), TRUE, $this->_sitePageData->currency);
        $invoice['created_at'] = strftime('%d.%m.%Y', strtotime($model->getCreatedAt()));
        $invoice['created_at_str'] = Helpers_DateTime::getDateTimeDayMonthRus($model->getCreatedAt(), TRUE);


        $shopInvoiceItemIDs = Request_Tax_Shop_Invoice_Commercial_Item::findShopInvoiceCommercialItemIDs($this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB,
            array('shop_invoice_id' => $id, Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE), 0, TRUE,
            array('shop_contractor_id' => array('name', 'unit_name', 'unit_id'), 'unit_id' => array('name'),
                'shop_product_id' => array('name', 'bin', 'address', 'iik', 'bank')));

        $shopInvoiceItems = array();
        foreach($shopInvoiceItemIDs->childs as $shopInvoiceItemID){
            $shopInvoiceItems[] = $shopInvoiceItemID->values;
        }

        $payment['count'] = count($shopInvoiceItems);

        Helpers_Excel::saleInFile($filePath,
            array(
                'invoice' => $payment,
                'operation' => array('name' => $this->_sitePageData->operation->getName()),
                'shop' => $this->_sitePageData->shop->getValues(TRUE, TRUE, $this->_sitePageData->shopMainID),
            ),
            array('invoice_items' => $shopInvoiceItems));

        exit();
    }
}
