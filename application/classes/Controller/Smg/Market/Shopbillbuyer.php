<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Smg_Market_ShopBillBuyer extends Controller_Smg_Market_Basic {

    public function __construct(Request $request, Response $response)
    {
        $this->dbObject = 'DB_AutoPart_Shop_Bill_Buyer';
        $this->controllerName = 'shopbillbuyer';
        $this->tableID = Model_AutoPart_Shop_Bill_Buyer::TABLE_ID;
        $this->tableName = Model_AutoPart_Shop_Bill_Buyer::TABLE_NAME;

        parent::__construct($request, $response);

        $this->shopID = $this->_sitePageData->shopID;
        $this->editAndNewBasicTemplate = '';
    }

    public function action_index()
    {
        $this->_sitePageData->url = '/market/shopbillbuyer/index';

        $this->_requestListDB('DB_AutoPart_Shop_Source');

        parent::_actionIndex(
            array(
                'shop_source_id' => ['name']
            )
        );
    }
}
