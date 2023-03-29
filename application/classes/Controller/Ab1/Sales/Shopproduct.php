<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_Sales_ShopProduct extends Controller_Ab1_Sales_BasicAb1 {

    public function __construct(Request $request, Response $response)
    {
        $this->dbObject = 'DB_Ab1_Shop_Product';
        $this->controllerName = 'shopproduct';
        $this->objectName = 'product';

        parent::__construct($request, $response);
    }

    public function action_pricelist() {
        $this->_sitePageData->url = '/sales/shopproduct/pricelist';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
            )
        );

        $this->_putInMain('/main/_shop/product/pricelist');
    }

    public function action_get_price()
    {
        $this->_sitePageData->url = '/sales/shopproduct/get_price';
        $this->_actionShopCarGetPrice();
    }
}
