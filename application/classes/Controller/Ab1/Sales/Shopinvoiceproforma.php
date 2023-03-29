<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_Sales_ShopInvoiceProforma extends Controller_Ab1_Sales_BasicAb1 {

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
        $this->_sitePageData->url = '/sales/shopinvoiceproforma/index';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/invoice/proforma/list/index',
            )
        );

        // получаем список
        View_View::find('DB_Ab1_Shop_Invoice_Proforma',
            $this->_sitePageData->shopID,
            "_shop/invoice/proforma/list/index", "_shop/invoice/proforma/one/index",
            $this->_sitePageData, $this->_driverDB, array('limit' => 1000, 'limit_page' => 25),
            array(
                'shop_client_id' => array('name'),
                'shop_client_contract_id' => array('number', 'from_at'),
            )
        );

        $this->_putInMain('/main/_shop/invoice/proforma/index');
    }

    public function action_new()
    {
        $this->_sitePageData->url = '/sales/shopinvoiceproforma/new';
        $this->_actionShopInvoiceProformaNew();
    }

    public function action_edit()
    {
        $this->_sitePageData->url = '/sales/shopinvoiceproforma/edit';
        $this->_actionShopInvoiceProformaEdit();
    }

    public function action_save()
    {
        $this->_sitePageData->url = '/sales/shopinvoiceproforma/save';

        $result = Api_Ab1_Shop_Invoice_Proforma::save($this->_sitePageData, $this->_driverDB);
        $this->_redirectSaveResult($result);
    }

    public function action_del()
    {
        $this->_sitePageData->url = '/sales/shopinvoiceproforma/del';
        $result = Api_Ab1_Shop_Invoice_Proforma::delete($this->_sitePageData, $this->_driverDB);
        $this->response->body(Json::json_encode(array('error' => $result)));
    }
}
