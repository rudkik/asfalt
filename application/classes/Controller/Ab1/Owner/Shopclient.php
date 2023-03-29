<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_Owner_ShopClient extends Controller_Ab1_Owner_BasicAb1{

    public function __construct(Request $request, Response $response)
    {
        $this->dbObject = 'DB_Ab1_Shop_Client';
        $this->controllerName = 'shopclient';
        $this->tableID = Model_Ab1_Shop_Client::TABLE_ID;
        $this->tableName = Model_Ab1_Shop_Client::TABLE_NAME;
        $this->objectName = 'client';

        parent::__construct($request, $response);
    }

    public function action_statistics()
    {
        $this->_sitePageData->url = '/owner/shopclient/statistics';
        $this->_actionShopClientStatistics();
    }

    public function action_charity_statistics()
    {
        $this->_sitePageData->url = '/owner/shopclient/charity_statistics';

        $this->_actionCharityShopClientStatistics();
    }

    public function action_json() {
        $this->_sitePageData->url = '/owner/shopclient/json';
        $this->_getJSONList($this->_sitePageData->shopMainID);
    }
}
