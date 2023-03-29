<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_Ogm_ShopClient extends Controller_Ab1_Ogm_BasicAb1 {

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
        $this->_sitePageData->url = '/ogm/shopclient/json';
        $this->_getJSONList($this->_sitePageData->shopMainID);
    }

    public function action_index() {
        $this->_sitePageData->url = '/ogm/shopclient/index';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/client/list/index',
            )
        );
        $this->_requestOrganizationTypes();
        $this->_requestKatos();

        // получаем список
        View_View::find('DB_Ab1_Shop_Client', $this->_sitePageData->shopMainID, "_shop/client/list/index", "_shop/client/one/index",
            $this->_sitePageData, $this->_driverDB, array('is_main_shop' => FALSE, 'limit' => 1000, 'limit_page' => 25, 'id_not' => 175747));

        $this->_putInMain('/main/_shop/client/index');
    }

    public function action_edit()
    {
        $this->_sitePageData->url = '/ogm/shopclient/edit';
        $this->_actionShopClientEdit();
    }

    public function action_save()
    {
        $this->_sitePageData->url = '/ogm/shopclient/save';

        $result = Api_Ab1_Shop_Client::save($this->_sitePageData, $this->_driverDB);
        $this->_redirectSaveResult($result);
    }

    public function action_statistics()
    {
        $this->_sitePageData->url = '/ogm/shopclient/statistics';
        $this->_actionShopClientStatistics();
    }

    public function action_charity_statistics()
    {

        $this->_sitePageData->url = '/ogm/shopclient/charity_statistics';
        $this->_actionCharityShopClientStatistics();
    }
}
