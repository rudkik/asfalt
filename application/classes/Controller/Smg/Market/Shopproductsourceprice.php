<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Smg_Market_ShopProductSourcePrice extends Controller_Smg_Market_Basic {

    public function __construct(Request $request, Response $response)
    {
        $this->dbObject = 'DB_AutoPart_Shop_Product_Source_Price';
        $this->controllerName = 'shopproductsourceprice';
        $this->tableID = Model_AutoPart_Shop_Product_Source_Price::TABLE_ID;
        $this->tableName = Model_AutoPart_Shop_Product_Source_Price::TABLE_NAME;

        parent::__construct($request, $response);
    }
    
    public function action_index() {
        $this->_sitePageData->url = '/market/shopproductsourceprice/index';

        $this->_requestListDB('DB_AutoPart_Shop_Source');
        $this->_requestListDB('DB_AutoPart_Shop_Rubric_Source');
        $this->_requestListDB('DB_AutoPart_Shop_Brand');
        $this->_requestListDB('DB_AutoPart_Shop_Supplier');
        $this->_requestListDB('DB_AutoPart_Shop_Company');

        parent::_actionIndex(
            array(
                'shop_source_id' => array('name'),
                'shop_rubric_source_id' => array('name', 'commission', 'commission_sale', 'is_sale'),
                'shop_product_id' => array('name', 'article', 'price', 'root_shop_product_id', 'child_product_count', 'url'),
                'shop_product_id.shop_brand_id' => array('name'),
                'shop_company_id' => array('name'),
                'shop_product_id.shop_supplier_id' => array('name'),
                'shop_product_source_id' => array('url'),
            ),
            [
                'shop_product_id.is_public' => 1,
                'shop_product_id.is_in_stock' => 1,
            ]
        );
    }
}
