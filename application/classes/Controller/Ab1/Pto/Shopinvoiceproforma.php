<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_Pto_ShopInvoiceProforma extends Controller_Ab1_Pto_BasicAb1 {

    public function __construct(Request $request, Response $response)
    {
        $this->dbObject = 'DB_Ab1_Shop_Invoice_Proforma';
        $this->controllerName = 'shopinvoiceproforma';
        $this->tableID = Model_Ab1_Shop_Invoice_Proforma::TABLE_ID;
        $this->tableName = Model_Ab1_Shop_Invoice_Proforma::TABLE_NAME;
        $this->objectName = 'invoice';

        parent::__construct($request, $response);
    }

    public function action_index() {
        $this->_sitePageData->url = '/pto/shopinvoiceproforma/index';

        // получаем список
        View_View::find('DB_Ab1_Shop_Invoice_Proforma',
            $this->_sitePageData->shopID,
            "_shop/invoice/proforma/list/index", "_shop/invoice/proforma/one/index",
            $this->_sitePageData, $this->_driverDB, array(),
            array(
                'shop_client_id' => array('name'),
                'shop_client_contract_id' => array('number', 'from_at'),
                'create_user_id' => array('name'),
            )
        );

        $this->_putInMain('/main/_shop/invoice/proforma/index');
    }

    public function action_edit()
    {
        $this->_sitePageData->url = '/pto/shopinvoiceproforma/edit';
        $this->_actionShopInvoiceProformaEdit();
    }

    public function action_save()
    {
        $this->_sitePageData->url = '/pto/shopinvoiceproforma/save';

        $result = Api_Ab1_Shop_Invoice_Proforma::save($this->_sitePageData, $this->_driverDB);
        $this->_redirectSaveResult($result);
    }
}