<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_Pto_ShopProduct extends Controller_Ab1_Pto_BasicAb1 {

    public function __construct(Request $request, Response $response)
    {
        $this->dbObject = 'DB_Ab1_Shop_Product';
        $this->controllerName = 'shopproduct';
        $this->tableID = Model_Ab1_Shop_Product::TABLE_ID;
        $this->tableName = Model_Ab1_Shop_Product::TABLE_NAME;
        $this->objectName = 'product';

        parent::__construct($request, $response);
    }

    public function action_index() {
        $this->_sitePageData->url = '/pto/shopproduct/index';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/product/list/index',
            )
        );

        $this->_requestShopProductRubrics();
        $this->_requestShopProductPricelistRubrics();
        $this->_requestShopBranches(null, true);

        // получаем список
        View_View::find('DB_Ab1_Shop_Product',
            $this->_sitePageData->shopID, "_shop/product/list/index", "_shop/product/one/index",
            $this->_sitePageData, $this->_driverDB, array('limit' => 1000, 'limit_page' => 25),
            array(
                'shop_product_rubric_id' => array('name'),
                'shop_product_group_id' => array('name'),
                'product_type_id' => array('name'),
                'product_view_id' => array('name'),
                'shop_subdivision_id' => array('name'),
                'shop_storage_id' => array('name'),
            )
        );

        $this->_putInMain('/main/_shop/product/index');
    }

    public function action_new()
    {
        $this->_sitePageData->url = '/pto/shopproduct/new';
        $this->_actionShopProductNew();
    }

    public function action_edit()
    {
        $this->_sitePageData->url = '/pto/shopproduct/edit'
        ;$this->_actionShopProductEdit();
    }

    public function action_save()
    {
        $this->_sitePageData->url = '/pto/shopproduct/save';

        $result = Api_Ab1_Shop_Product::save($this->_sitePageData, $this->_driverDB);
        $this->_redirectSaveResult($result);
    }

    public function action_statistics()
    {
        $this->_sitePageData->url = '/pto/shopproduct/statistics';
        $this->_actionShopProductStatistics();
    }

    public function action_pricelist()
    {
        $this->_sitePageData->url = '/pto/shopproduct/pricelist';

        $this->_actionShopProductPriceList();
    }

    public function action_pricelist_print() {
        $this->_sitePageData->url = '/pto/shopproduct/pricelist';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
            )
        );

        $this->_putInMain('/main/_shop/product/pricelist');
    }
}
