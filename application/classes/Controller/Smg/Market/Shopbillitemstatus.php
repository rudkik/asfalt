<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Smg_Market_ShopBillItemStatus extends Controller_Smg_Market_Basic {

    public function __construct(Request $request, Response $response)
    {
        $this->dbObject = 'DB_AutoPart_Shop_Bill_Item_Status';
        $this->controllerName = 'shopbillitemstatus';
        $this->tableID = Model_AutoPart_Shop_Bill_Item_Status::TABLE_ID;
        $this->tableName = Model_AutoPart_Shop_Bill_Item_Status::TABLE_NAME;

        parent::__construct($request, $response);

        $this->shopID = $this->_sitePageData->shopID;
        $this->editAndNewBasicTemplate = '';
    }
}
