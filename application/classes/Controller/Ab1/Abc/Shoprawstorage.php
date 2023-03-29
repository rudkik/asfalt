<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_Abc_ShopRawStorage extends Controller_Ab1_Abc_BasicAb1 {

    public function __construct(Request $request, Response $response)
    {
        $this->dbObject = 'DB_Ab1_Shop_Raw_Storage';
        $this->controllerName = 'shoprawstorage';
        $this->tableID = Model_Ab1_Shop_Raw_Storage::TABLE_ID;
        $this->tableName = Model_Ab1_Shop_Raw_Storage::TABLE_NAME;
        $this->objectName = 'rawstorage';

        parent::__construct($request, $response);
    }

    public function action_total() {
        $this->_sitePageData->url = '/abc/shoprawstorage/total';
        $this->_actionShopRawStorageTotal();
    }
}
