<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Smg_Market_ShopProductJoin extends Controller_Smg_Market_Basic {

    public function __construct(Request $request, Response $response)
    {
        $this->dbObject = 'DB_AutoPart_Shop_Product_Join';
        $this->controllerName = 'shopproductjoin';
        $this->tableID = Model_AutoPart_Shop_Product_Join::TABLE_ID;
        $this->tableName = Model_AutoPart_Shop_Product_Join::TABLE_NAME;

        parent::__construct($request, $response);
    }
    
    public function action_index() {
        $this->_sitePageData->url = '/market/shopproductjoin/index';

        $this->_requestListDB('DB_AutoPart_Shop_Source');
        $this->_requestListDB('DB_Shop_Operation');

        parent::_actionIndex(
            array(
                'shop_source_id' => array('name'),
                'shop_product_id' => array('article'),
                'shop_operation_id' => array('name'),
            )
        );
    }
}
