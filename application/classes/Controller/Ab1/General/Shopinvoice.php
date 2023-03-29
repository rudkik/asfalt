<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_General_ShopInvoice extends Controller_Ab1_General_BasicAb1 {

    public function __construct(Request $request, Response $response)
    {
        $this->dbObject = 'DB_Ab1_Shop_Invoice';
        $this->controllerName = 'shopinvoice';
        $this->tableID = Model_Ab1_Shop_Invoice::TABLE_ID;
        $this->tableName = Model_Ab1_Shop_Invoice::TABLE_NAME;
        $this->objectName = 'invoice';

        parent::__construct($request, $response);
    }

    public function action_index() {
        $this->_sitePageData->url = '/general/shopinvoice/index';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/invoice/list/index',
            )
        );

        $this->_requestShopProducts();
        $this->_requestCheckTypes(Request_RequestParams::getParamInt('check_type_id'));

        if(Request_RequestParams::getParamBoolean('is_last_day')){
            $params = Request_RequestParams::setParams(
                array(
                    'limit' => 1000, 'limit_page' => 25,
                    'date' => Helpers_DateTime::minusDays(date('Y-m-d'), 9),
                    'is_send_esf' => Request_RequestParams::getParamBoolean('is_send_esf'),
                    'sort_by' => array(
                        'date' => 'desc',
                        'created_at' => 'desc',
                    )
                ),
                FALSE
            );
        }else{
            $params = array(
                'limit' => 1000, 'limit_page' => 25,
                'sort_by' => array(
                    'date' => 'desc',
                    'created_at' => 'desc',
                )
            );
        }

        // получаем список
        View_View::findBranch('DB_Ab1_Shop_Invoice',
            $this->_sitePageData->shopMainID,
            "_shop/invoice/list/index", "_shop/invoice/one/index",
            $this->_sitePageData, $this->_driverDB, $params,
            array(
                'shop_id' => array('name'),
                'shop_client_id' => array('name'),
                'shop_client_attorney_id' => array('number'),
                'shop_client_contract_id' => array('number'),
                'product_type_id' => array('name'),
                'check_type_id' => array('name'),
            )
        );

        $this->_putInMain('/main/_shop/invoice/index');
    }

    public function action_edit()
    {
        $this->_sitePageData->url = '/general/shopinvoice/edit';
        $this->_actionShopInvoiceEdit();
    }

    public function action_invoice_edit() {
        $this->_sitePageData->url = '/general/shopinvoice/invoice_edit';
        $this->_actionShopInvoiceModalEdit();
    }

    public function action_save()
    {
        $this->_sitePageData->url = '/general/shopinvoice/save';

        $result = Api_Ab1_Shop_Invoice::save($this->_sitePageData, $this->_driverDB);
        $this->_redirectSaveResult($result);
    }

    public function action_calc_invoice_price() {
        $this->_sitePageData->url = '/general/shopinvoice/calc_invoice_price';

        $shopInvoiceID = Request_RequestParams::getParamInt('shop_invoice_id');

        Api_Ab1_Shop_Invoice::calcInvoicePrice(
            $shopInvoiceID, $this->_sitePageData, $this->_driverDB
        );

        self::redirect(
            '/general/shopinvoice/edit' . URL::query(array('id' => $shopInvoiceID,))
        );
    }

    public function action_discount_delete() {
        $this->_sitePageData->url = '/general/shopinvoice/discount_delete';
        $this->_actionShopInvoiceDiscountDelete();
    }
}