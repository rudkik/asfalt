<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_Asu_ShopClient extends Controller_Ab1_Asu_BasicAb1 {

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
        $this->_sitePageData->url = '/asu/shopclient/json';
        $this->_getJSONList($this->_sitePageData->shopMainID);
    }
}
