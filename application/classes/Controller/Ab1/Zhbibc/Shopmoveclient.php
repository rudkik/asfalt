<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_ZhbiBc_ShopMoveClient extends Controller_Ab1_ZhbiBc_BasicAb1 {

    public function __construct(Request $request, Response $response)
    {
        $this->dbObject = 'DB_Ab1_Shop_Move_Client';
        $this->controllerName = 'shopmoveclient';
        $this->tableID = Model_Ab1_Shop_Move_Client::TABLE_ID;
        $this->tableName = Model_Ab1_Shop_Move_Client::TABLE_NAME;
        $this->objectName = 'moveclient';

        parent::__construct($request, $response);
    }

    public function action_json() {
        $this->_sitePageData->url = '/zhbibc/shopmoveclient/json';
        $this->_getJSONList($this->_sitePageData->shopMainID);
    }
}
