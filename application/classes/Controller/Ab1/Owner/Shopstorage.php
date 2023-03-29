<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_Owner_ShopStorage extends Controller_Ab1_Owner_BasicAb1{


    public function __construct(Request $request, Response $response)
    {
        $this->dbObject = 'DB_Ab1_Shop_Storage';
        $this->controllerName = 'shopstorage';
        $this->tableID = Model_Ab1_Shop_Storage::TABLE_ID;
        $this->tableName = Model_Ab1_Shop_Storage::TABLE_NAME;
        $this->objectName = 'storage';

        parent::__construct($request, $response);
    }

    public function action_statistics()
    {
        $this->_sitePageData->url = '/owner/shopstorage/statistics';

        $this->_actionShopStorageStatistics();
    }

    public function action_balance_statistics()
    {
        $this->_sitePageData->url = '/owner/shopstorage/balance_statistics';

        $this->_actionShopStorageBalanceStatistics();
    }
}
