<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_Abc_ShopFormulaProduct extends Controller_Ab1_Abc_BasicAb1
{

    public function __construct(Request $request, Response $response)
    {
        $this->dbObject = 'DB_Ab1_Shop_Formula_Product';
        $this->controllerName = 'shopformulaproduct';
        $this->tableID = Model_Ab1_Shop_Formula_Product::TABLE_ID;
        $this->tableName = Model_Ab1_Shop_Formula_Product::TABLE_NAME;
        $this->objectName = 'formulaproduct';

        parent::__construct($request, $response);
    }

    public function action_index()
    {
        $this->_sitePageData->url = '/abc/shopformulaproduct/index';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/formula/product/list/index',
            )
        );

        // основная продукция
        $this->_requestShopProducts(
            NULL, 0, NULL, FALSE,
            [
                Model_Ab1_ProductView::PRODUCT_TYPE_CAR,
                Model_Ab1_ProductView::PRODUCT_TYPE_CAR_AND_PIECE,
                Model_Ab1_ProductView::PRODUCT_TYPE_PIECE
            ]
        );

        $params = Request_RequestParams::setParams(
            array(
                'limit' => 1000,
                'formula_type_id' => [
                    Model_Ab1_FormulaType::FORMULA_PRODUCT_TYPE_ASPHALT,
                    Model_Ab1_FormulaType::FORMULA_PRODUCT_TYPE_ASPHALT_BUNKER,
                    Model_Ab1_FormulaType::FORMULA_PRODUCT_TYPE_EMULSION,
                ],
                'limit_page' => 25,
            ),
        false
        );

        // получаем список
        View_View::find('DB_Ab1_Shop_Formula_Product',
            $this->_sitePageData->shopID,
            "_shop/formula/product/list/index", "_shop/formula/product/one/index",
            $this->_sitePageData, $this->_driverDB, $params,
            array('shop_product_id' => array('name'))
        );

        $this->_putInMain('/main/_shop/formula/product/index');
    }

    public function action_new()
    {
        $this->_sitePageData->url = '/abc/shopformulaproduct/new';
        $this->_actionShopFormulaProductNew();
    }

    public function action_edit()
    {
        $this->_sitePageData->url = '/abc/shopformulaproduct/edit';
        $this->_actionShopFormulaProductEdit();
    }

    public function action_save()
    {
        $this->_sitePageData->url = '/abc/shopformulaproduct/save';

        $result = Api_Ab1_Shop_Formula_Product::save($this->_sitePageData, $this->_driverDB);
        $this->_redirectSaveResult($result);
    }
}
