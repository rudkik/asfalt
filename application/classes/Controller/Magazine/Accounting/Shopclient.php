<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Magazine_Accounting_ShopClient extends Controller_Magazine_Accounting_BasicMagazine {

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
        $this->_sitePageData->url = '/act/shopclient/json';
        $this->_getJSONList(0);
    }
}
