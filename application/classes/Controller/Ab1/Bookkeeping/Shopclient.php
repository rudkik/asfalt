<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_Bookkeeping_ShopClient extends Controller_Ab1_Bookkeeping_BasicAb1 {

    public function __construct(Request $request, Response $response)
    {
        $this->dbObject = 'DB_Ab1_Shop_Client';
        $this->controllerName = 'shopclient';
        $this->tableID = Model_Ab1_Shop_Client::TABLE_ID;
        $this->tableName = Model_Ab1_Shop_Client::TABLE_NAME;
        $this->objectName = 'client';

        parent::__construct($request, $response);
    }

    public function action_json() {
        $this->_sitePageData->url = '/bookkeeping/shopclient/json';
        $this->_getJSONList($this->_sitePageData->shopMainID);
    }

    public function action_index() {
        $this->_sitePageData->url = '/bookkeeping/shopclient/index';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/client/list/index',
            )
        );
        $this->_requestOrganizationTypes();
        $this->_requestKatos();

        // получаем список
        View_View::find('DB_Ab1_Shop_Client', $this->_sitePageData->shopMainID,
            "_shop/client/list/index", "_shop/client/one/index",
            $this->_sitePageData, $this->_driverDB, array('is_main_shop' => FALSE, 'limit' => 1000, 'limit_page' => 25, 'id_not' => 175747));

        $this->_putInMain('/main/_shop/client/index');
    }

    public function action_new()
    {
        $this->_sitePageData->url = '/bookkeeping/shopclient/new';
        $this->_actionShopClientNew();
    }

    public function action_edit()
    {
        $this->_sitePageData->url = '/bookkeeping/shopclient/edit';
        $this->_actionShopClientEdit();
    }

    public function action_save()
    {
        $this->_sitePageData->url = '/bookkeeping/shopclient/save';

        $result = Api_Ab1_Shop_Client::save($this->_sitePageData, $this->_driverDB);
        $this->_redirectSaveResult($result);
    }

    public function action_calc_balance()
    {
        $this->_sitePageData->url = '/bookkeeping/shopclient/calc_balance';

        $shopClientID = Request_RequestParams::getParamInt('id');

        Api_Ab1_Shop_Client::recountBalanceAll($shopClientID, $this->_sitePageData, $this->_driverDB);

        $url = Request_RequestParams::getParamStr('url');
        if(empty($url)){
            $url = '/sbyt/shopclientattorney/index';
        }
        $this->redirect($url);
    }

    public function action_calc_balance_all()
    {
        $this->_sitePageData->url = '/bookkeeping/shopclient/calc_balance_all';

        $shopClientIDs = Request_Request::find('DB_Ab1_Shop_Client',
            $this->_sitePageData->shopMainID, $this->_sitePageData, $this->_driverDB,
            Request_RequestParams::setParams(
                array(
                    'sort_by' => array('updated_at' => 'desc'),
                    'id_not' => 175747
                )
            )
        );

        foreach ($shopClientIDs->childs as $child){
            Api_Ab1_Shop_Client::recountBalanceAll($child->id, $this->_sitePageData, $this->_driverDB);
        }

        $url = Request_RequestParams::getParamStr('url');
        if(empty($url)){
            $url = '/sbyt/shopclient/index';
        }
        $this->redirect($url);
    }
}
