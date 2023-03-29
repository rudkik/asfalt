<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_Peo_ShopProduct extends Controller_Ab1_Peo_BasicAb1 {

    public function __construct(Request $request, Response $response)
    {
        $this->dbObject = 'DB_Ab1_Shop_Product';
        $this->controllerName = 'shopproduct';
        $this->tableID = Model_Ab1_Shop_Product::TABLE_ID;
        $this->tableName = Model_Ab1_Shop_Product::TABLE_NAME;
        $this->objectName = 'product';

        parent::__construct($request, $response);
    }

    public function action_statistics()
    {
        $this->_sitePageData->url = '/peo/shopproduct/statistics';
        $this->_actionShopProductStatistics();
    }

    public function action_pricelist() {
        $this->_sitePageData->url = '/peo/shopproduct/pricelist';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
            )
        );

        $this->_putInMain('/main/_shop/product/pricelist');
    }
}
