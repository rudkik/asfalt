<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Smg_Market_ShopReceiveItem extends Controller_Smg_Market_Basic {

    public function __construct(Request $request, Response $response)
    {
        $this->dbObject = 'DB_AutoPart_Shop_Receive_Item';
        $this->controllerName = 'shopreceiveitem';
        $this->tableID = Model_AutoPart_Shop_Receive_Item::TABLE_ID;
        $this->tableName = Model_AutoPart_Shop_Receive_Item::TABLE_NAME;

        parent::__construct($request, $response);

        $this->shopID = $this->_sitePageData->shopID;
        $this->editAndNewBasicTemplate = '';
    }

    public function action_stock() {
        $this->_sitePageData->url = '/market/shopreceiveitem/stock';

        $this->_requestListDB('DB_AutoPart_Shop_Supplier');
        $this->_requestListDB('DB_AutoPart_Shop_Company');

        parent::_actionIndex(
            array(
                'shop_product_id' => array(
                    'name', 'price_cost', 'url', 'options', 'article', 'is_public',
                ),
                'shop_receive_id' => array('number', 'date', 'name'),
                'shop_product_id' => array('name'),
                'shop_receive_id.shop_supplier_id' => array('name'),
                'shop_company_id' => array('name'),
            ),
            ['quantity_balance_from' => 0, 'is_expense' => false, 'shop_receive_id.is_return' => false, 'is_return' => false],
            -1, 'stock'
        );
    }

    public function action_sold() {
        $this->_sitePageData->url = '/market/shopreceiveitem/sold';

        $this->_requestListDB('DB_AutoPart_Shop_Source');
        $this->_requestListDB('DB_AutoPart_Shop_Supplier');
        $this->_requestListDB('DB_AutoPart_Shop_Company');

        parent::_actionIndex(
            array(
                'shop_product_id' => array('name', 'article'),
                'shop_receive_id.shop_supplier_id' => array('name'),
                'shop_receive_id' => array('number', 'date'),
                'shop_receive_id.shop_company_id' => array('name'),
                'return_shop_receive_id' => array('number', 'date'),
            ),
            ['shop_receive_id.is_return' => false], -1, 'sold'
        );
    }
}
