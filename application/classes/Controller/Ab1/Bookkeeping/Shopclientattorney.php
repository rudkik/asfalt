<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_Bookkeeping_ShopClientAttorney extends Controller_Ab1_Bookkeeping_BasicAb1 {

    public function __construct(Request $request, Response $response)
    {
        $this->dbObject = 'DB_Ab1_Shop_Client_Attorney';
        $this->controllerName = 'shopclientattorney';
        $this->tableID = Model_Ab1_Shop_Client_Attorney::TABLE_ID;
        $this->tableName = Model_Ab1_Shop_Client_Attorney::TABLE_NAME;
        $this->objectName = 'clientattorney';

        parent::__construct($request, $response);
    }

    public function action_index() {
        $this->_sitePageData->url = '/bookkeeping/shopclientattorney/index';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/client/attorney/list/index',
            )
        );

        // получаем список
        View_View::find('DB_Ab1_Shop_Client_Attorney', $this->_sitePageData->shopID,
            "_shop/client/attorney/list/index", "_shop/client/attorney/one/index",
            $this->_sitePageData, $this->_driverDB, array('is_main_shop' => FALSE, 'limit' => 1000, 'limit_page' => 25), array('shop_client_id' => array('name')));

        $this->_putInMain('/main/_shop/client/attorney/index');
    }

    public function action_edit()
    {
        $this->_sitePageData->url = '/bookkeeping/shopclientattorney/edit';
        $this->_actionShopClientAttorneyEdit();
    }

    public function action_new()
    {
        $this->_sitePageData->url = '/bookkeeping/shopclientattorney/new';
        $this->_actionShopClientAttorneyNew();
    }

    public function action_save()
    {
        $this->_sitePageData->url = '/bookkeeping/shopclientattorney/save';

        $result = Api_Ab1_Shop_Client_Attorney::save($this->_sitePageData, $this->_driverDB);
        $this->_redirectSaveResult($result);
    }

    public function action_del()
    {
        $this->_sitePageData->url = '/bookkeeping/shopclientattorney/del';
        $result = Api_Ab1_Shop_Client_Attorney::delete($this->_sitePageData, $this->_driverDB);
        $this->response->body(Json::json_encode(array('error' => $result)));
    }

    public function action_calc_balance()
    {
        $this->_sitePageData->url = '/bookkeeping/shopclientattorney/calc_balance';

        $shopClientAttorneyID = Request_RequestParams::getParamInt('id');
        Api_Ab1_Shop_Client_Attorney::calcBalanceBlock(
            $shopClientAttorneyID, $this->_sitePageData, $this->_driverDB
        );
        Api_Ab1_Shop_Client_Attorney::calcDeliveryBalanceBlock(
            $shopClientAttorneyID, $this->_sitePageData, $this->_driverDB
        );

        $this->redirect('/bookkeeping/shopclientattorney/index?id='.$shopClientAttorneyID);
    }
}
