<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_Sales_ShopClient extends Controller_Ab1_Sales_BasicAb1 {

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
        $this->_sitePageData->url = '/sales/shopclient/json';
        $this->_getJSONList($this->_sitePageData->shopMainID);
    }

    public function action_index() {
        $this->_sitePageData->url = '/sales/shopclient/index';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/client/list/index',
            )
        );
        $this->_requestOrganizationTypes();
        $this->_requestKatos();

        // получаем список
        View_View::find('DB_Ab1_Shop_Client',
            $this->_sitePageData->shopMainID, "_shop/client/list/index", "_shop/client/one/index",
            $this->_sitePageData, $this->_driverDB, array('is_main_shop' => FALSE, 'limit' => 1000, 'limit_page' => 25, 'id_not' => 175747)
        );

        $this->_putInMain('/main/_shop/client/index');
    }

    public function action_client() {
        $this->_sitePageData->url = '/sales/shopclient/client';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/client/list/client',
            )
        );

        // получаем список
        View_View::find('DB_Ab1_Shop_Client',
            $this->_sitePageData->shopMainID,
            "_shop/client/list/client", "_shop/client/one/client",
            $this->_sitePageData, $this->_driverDB,
            array(
                'amount_not_equally' => 0,
                'sort_by' => array(
                    'name' => 'asc',
                ),
                'limit_page' => 25,
                'id_not' => 175747
            )
        );

        $this->_putInMain('/main/_shop/client/client');
    }

    public function action_new()
    {
        $this->_sitePageData->url = '/sales/shopclient/new';
        $this->_actionShopClientNew();
    }

    public function action_edit()
    {
        $this->_sitePageData->url = '/sales/shopclient/edit';
        $this->_actionShopClientEdit();
    }

    public function action_save()
    {
        $this->_sitePageData->url = '/sales/shopclient/save';

        $result = Api_Ab1_Shop_Client::save($this->_sitePageData, $this->_driverDB);
        $this->_redirectSaveResult($result);
    }

    public function action_calc_balance()
    {
        $this->_sitePageData->url = '/sales/shopclient/calc_balance';

        $shopClientID = Request_RequestParams::getParamInt('id');

        Api_Ab1_Shop_Client::recountBalanceAll($shopClientID, $this->_sitePageData, $this->_driverDB);

        $url = Request_RequestParams::getParamStr('url');
        if(empty($url)){
            $url = '/sales/shopclientattorney/index';
        }
        $this->redirect($url);
    }

    public function action_calc_balance_all()
    {
        $this->_sitePageData->url = '/sales/shopclient/calc_balance_all';

        $shopClientIDs = Request_Request::find('DB_Ab1_Shop_Client',
            $this->_sitePageData->shopMainID, $this->_sitePageData, $this->_driverDB,
            Request_RequestParams::setParams(
                array(
                    'sort_by' => array('updated_at' => 'desc')
                )
            )
        );

        foreach ($shopClientIDs->childs as $child){
            Api_Ab1_Shop_Client::recountBalanceAll($child->id, $this->_sitePageData, $this->_driverDB);
        }

        $url = Request_RequestParams::getParamStr('url');
        if(empty($url)){
            $url = '/sales/shopclient/index';
        }
        $this->redirect($url);
    }

    /**
     * Задаем клиентам статус покупатель по реализации и штучному товару
     */
    public function action_set_is_buyer()
    {
        $this->_sitePageData->url = '/sales/shopclient/set_is_buyer';

        $params = Request_RequestParams::setParams(
            array(
                'group_by' => array(
                    'shop_client_id'
                )
            )
        );

        // реализация
        $ids = Request_Request::findBranch('DB_Ab1_Shop_Car',
            array(), $this->_sitePageData, $this->_driverDB, $params
        );
        if(count($ids->childs) > 0){
            $this->_driverDB->sendSQL('UPDATE ab_shop_clients SET is_buyer = 1 WHERE id in ('.implode(',', $ids->getChildArrayInt('shop_client_id', true)).')');
        }

        // штучный товар
        $ids = Request_Request::findBranch('DB_Ab1_Shop_Piece',
            array(), $this->_sitePageData, $this->_driverDB, $params
        );
        if(count($ids->childs) > 0){
            $this->_driverDB->sendSQL('UPDATE ab_shop_clients SET is_buyer = 1 WHERE id in ('.implode(',', $ids->getChildArrayInt('shop_client_id', true)).')');
        }

        $this->redirect('/sales/shopclient/index');
    }
}
