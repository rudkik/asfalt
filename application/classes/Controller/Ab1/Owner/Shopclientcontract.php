<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_Owner_ShopClientContract extends Controller_Ab1_Owner_BasicAb1 {

    public function __construct(Request $request, Response $response)
    {
        $this->dbObject = 'DB_Ab1_Shop_Client_Contract';
        $this->controllerName = 'shopclientcontract';
        $this->tableID = Model_Ab1_Shop_Client_Contract::TABLE_ID;
        $this->tableName = Model_Ab1_Shop_Client_Contract::TABLE_NAME;
        $this->objectName = 'client/contract';

        parent::__construct($request, $response);
    }

    public function action_director() {
        $this->_sitePageData->url = '/owner/shopclientcontract/director';
        $this->_actionShopClientContractDirector();
    }
}
