<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_Crusher_ShopRaw extends Controller_Ab1_Crusher_BasicAb1 {

    public function __construct(Request $request, Response $response)
    {
        $this->dbObject = 'DB_Ab1_Shop_Raw';
        $this->controllerName = 'shopraw';
        $this->tableID = Model_Ab1_Shop_Raw::TABLE_ID;
        $this->tableName = Model_Ab1_Shop_Raw::TABLE_NAME;
        $this->objectName = 'raw';

        parent::__construct($request, $response);
    }

    public function action_recipe()
    {
        $this->_sitePageData->url = '/crusher/shopraw/recipe';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/ballast/list/recipe',
            )
        );

        $this->_requestShopBallastRubrics();

        // получаем список
        $params = Request_RequestParams::setParams(
            array(
                'limit_page' => 25,
                'count_recipe' => true,
                'formula_type_id' => Arr::path($this->_sitePageData->operation->getAccessArray(), 'formula_type_ids', NULL),
                'id' => Arr::path($this->_sitePageData->operation->getAccessArray(), 'shop_raw_ids', NULL),
                'group_by' => array(
                    'id', 'name',
                )
            ),
            FALSE
        );
        View_View::find(
            'DB_Ab1_Shop_Ballast', $this->_sitePageData->shopID,
            "_shop/ballast/list/recipe", "_shop/ballast/one/recipe",
            $this->_sitePageData, $this->_driverDB, $params
        );

        $this->_putInMain('/main/_shop/product/recipe');
    }

    public function action_recipes()
    {
        $this->_sitePageData->url = '/crusher/shopraw/recipes';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/raw/list/recipes',
            )
        );

        // получаем список
        $params = Request_RequestParams::setParams(
            array(
                'limit_page' => 25,
                'id' => Arr::path($this->_sitePageData->operation->getAccessArray(), 'shop_raw_ids', NULL),
            ),
            FALSE
        );
        View_View::find(
            'DB_Ab1_Shop_Raw', $this->_sitePageData->shopMainID,
            "_shop/raw/list/recipes", "_shop/raw/one/recipes",
            $this->_sitePageData, $this->_driverDB, $params
        );

        $this->_putInMain('/main/_shop/raw/recipes');
    }

    public function action_raw_recipe()
    {
        $this->_sitePageData->url = '/crusher/shopraw/raw_recipe';
        $this->_actionShopRawRecipe();
    }

    public function action_save()
    {
        $this->_sitePageData->url = '/crusher/shopraw/save';

        $result = Api_Ab1_Shop_Raw::save($this->_sitePageData, $this->_driverDB);
        $this->_redirectSaveResult($result, '/crusher/shopraw/raw_recipe');
    }
}
