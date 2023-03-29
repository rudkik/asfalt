<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_Make_ShopPayment extends Controller_Ab1_Make_BasicAb1
{

    public function __construct(Request $request, Response $response)
    {
        $this->dbObject = 'DB_Ab1_Shop_Payment';
        $this->controllerName = 'shoppayment';
        $this->tableID = Model_Ab1_Shop_Payment::TABLE_ID;
        $this->tableName = Model_Ab1_Shop_Payment::TABLE_NAME;
        $this->objectName = 'payment';

        parent::__construct($request, $response);
    }

    public function action_index()
    {
        $this->_sitePageData->url = '/make/shoppayment/index';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/payment/list/index',
            )
        );
        $this->_requestListDB('DB_Ab1_Shop_Cashbox');

        // получаем список
        View_View::find('DB_Ab1_Shop_Payment', $this->_sitePageData->shopID,
            "_shop/payment/list/index", "_shop/payment/one/index",
            $this->_sitePageData, $this->_driverDB,
            array('limit' => 1000, 'limit_page' => 25),
            array(
                'shop_client_id' => array('name'),
                'shop_cashbox_id' => array('name'),
                )
        );

        $this->_putInMain('/main/_shop/payment/index');
    }

    public function action_list()
    {
        $this->_sitePageData->url = '/make/shoppayment/list';

        // получаем список
        $this->response->body(View_View::find('DB_Ab1_Shop_Payment', $this->_sitePageData->shopID,
            "_shop/payment/list/list", "_shop/payment/one/list",
            $this->_sitePageData, $this->_driverDB, array('limit_page' => 50)));
    }

    public function action_edit()
    {
        $this->_sitePageData->url = '/make/shoppayment/edit';
        $this->_actionShopPaymentEdit();
    }

    public function action_save()
    {
        $this->_sitePageData->url = '/make/shoppayment/save';

        $result = Api_Ab1_Shop_Payment::save($this->_sitePageData, $this->_driverDB);
        $this->_redirectSaveResult($result);
    }
}
