<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_Abc_ShopProduct extends Controller_Ab1_Abc_BasicAb1 {

    public function __construct(Request $request, Response $response)
    {
        $this->dbObject = 'DB_Ab1_Shop_Product';
        $this->controllerName = 'shopproduct';
        $this->tableID = Model_Ab1_Shop_Product::TABLE_ID;
        $this->tableName = Model_Ab1_Shop_Product::TABLE_NAME;
        $this->objectName = 'product';

        parent::__construct($request, $response);
    }

    public function action_recipe()
    {
        $this->_sitePageData->url = '/abc/shopproduct/recipe';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/product/list/recipe',
            )
        );

        $this->_requestShopProductRubrics();

        // получаем список
        $params = Request_RequestParams::setParams(
            array(
                'limit_page' => 25,
                'count_recipe' => true,
                'product_view_id' =>  [
                    Model_Ab1_ProductView::PRODUCT_TYPE_CAR,
                    Model_Ab1_ProductView::PRODUCT_TYPE_CAR_AND_PIECE,
                    Model_Ab1_ProductView::PRODUCT_TYPE_PIECE
                ],
                'formula_type_id' => Arr::path($this->_sitePageData->operation->getAccessArray(), 'formula_type_ids', NULL),
                'group_by' => array(
                    'id', 'name',
                )
            ),
            FALSE
        );
        View_View::find('DB_Ab1_Shop_Product',
            $this->_sitePageData->shopID,
            "_shop/product/list/recipe", "_shop/product/one/recipe",
            $this->_sitePageData, $this->_driverDB, $params
        );

        $this->_putInMain('/main/_shop/product/recipe');
    }

    public function action_recipes()
    {
        $this->_sitePageData->url = '/abc/shopproduct/recipes';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/product/list/recipes',
            )
        );

        $this->_requestShopProductRubrics();

        // получаем список
        $params = Request_RequestParams::setParams(
            array(
                'limit_page' => 25,
                'product_view_id' =>  [
                    Model_Ab1_ProductView::PRODUCT_TYPE_CAR,
                    Model_Ab1_ProductView::PRODUCT_TYPE_CAR_AND_PIECE,
                    Model_Ab1_ProductView::PRODUCT_TYPE_PIECE
                ],
            ),
            FALSE
        );
        View_View::find('DB_Ab1_Shop_Product',
            $this->_sitePageData->shopID,
            "_shop/product/list/recipes", "_shop/product/one/recipes",
            $this->_sitePageData, $this->_driverDB, $params,
            array(
                'shop_product_rubric_id' => array('name'),
            )
        );

        $this->_putInMain('/main/_shop/product/recipes');
    }

    public function action_product_recipe()
    {
        $this->_sitePageData->url = '/abc/shopproduct/product_recipe';
        $this->_actionShopProductRecipe();
    }

    public function action_save()
    {
        $this->_sitePageData->url = '/abc/shopproduct/save';

        $result = Api_Ab1_Shop_Product::save($this->_sitePageData, $this->_driverDB);
        $this->_redirectSaveResult($result, '/abc/shopproduct/product_recipe');
    }
}
