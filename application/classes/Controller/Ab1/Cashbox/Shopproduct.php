<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_Cashbox_ShopProduct extends Controller_Ab1_Cashbox_BasicAb1 {

    public function __construct(Request $request, Response $response)
    {
        $this->dbObject = 'DB_Ab1_Shop_Product';
        $this->controllerName = 'shopproduct';
        $this->tableID = Model_Ab1_Shop_Product::TABLE_ID;
        $this->tableName = Model_Ab1_Shop_Product::TABLE_NAME;
        $this->objectName = 'product';

        parent::__construct($request, $response);
    }

    public function action_get_price()
    {
        $this->_sitePageData->url = '/cashbox/shopproduct/get_price';
        $this->_actionShopCarGetPrice();
    }
}
