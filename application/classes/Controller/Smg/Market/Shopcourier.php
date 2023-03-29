<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Smg_Market_ShopCourier extends Controller_Smg_Market_Basic {

    public function __construct(Request $request, Response $response)
    {
        $this->dbObject = 'DB_AutoPart_Shop_Courier';
        $this->controllerName = 'shopcourier';
        $this->tableID = Model_AutoPart_Shop_Courier::TABLE_ID;
        $this->tableName = Model_AutoPart_Shop_Courier::TABLE_NAME;

        parent::__construct($request, $response);

        $this->shopID = $this->_sitePageData->shopID;
        $this->editAndNewBasicTemplate = '';
    }
}
