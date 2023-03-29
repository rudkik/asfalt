<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_Recipe_ShopMaterial extends Controller_Ab1_Recipe_BasicAb1{

    public function __construct(Request $request, Response $response)
    {
        $this->dbObject = 'DB_Ab1_Shop_Material';
        $this->controllerName = 'shopmaterial';
        $this->tableID = Model_Ab1_Shop_Material::TABLE_ID;
        $this->tableName = Model_Ab1_Shop_Material::TABLE_NAME;
        $this->objectName = 'material';

        parent::__construct($request, $response);
    }

    public function action_index() {
        $this->_sitePageData->url = '/recipe/shopmaterial/index';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/material/list/index',
            )
        );

        // получаем список
        $params = Request_RequestParams::setParams(
            array(
                'limit' => 1000, 'limit_page' => 25,
                'formula_type_ids_in' => Arr::path($this->_sitePageData->operation->getAccessArray(), 'formula_type_ids', NULL),
            ),
            FALSE
        );
        View_View::find(
            'DB_Ab1_Shop_Material', $this->_sitePageData->shopMainID,
            "_shop/material/list/index", "_shop/material/one/index",
            $this->_sitePageData, $this->_driverDB, $params, array()
        );

        $this->_putInMain('/main/_shop/material/index');
    }

    public function action_new()
    {
        $this->_sitePageData->url = '/recipe/shopmaterial/new';
        $this->_actionShopMaterialNew();
    }

    public function action_edit()
    {
        $this->_sitePageData->url = '/recipe/shopmaterial/edit';
        $this->_actionShopMaterialEdit();
    }
    
    public function action_recipe()
    {
        $this->_sitePageData->url = '/recipe/shopmaterial/recipe';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/material/list/recipe',
            )
        );

        $this->_requestShopMaterialRubrics();

        // получаем список
        $params = Request_RequestParams::setParams(
            array(
                'limit_page' => 25,
                'count_recipe' => true,
                'formula_type_ids_in' => Arr::path($this->_sitePageData->operation->getAccessArray(), 'formula_type_ids', NULL),
                'group_by' => array(
                    'id', 'name',
                )
            ),
            FALSE
        );
        View_View::find('DB_Ab1_Shop_Material',
            $this->_sitePageData->shopMainID,
            "_shop/material/list/recipe", "_shop/material/one/recipe",
            $this->_sitePageData, $this->_driverDB, $params
        );

        $this->_putInMain('/main/_shop/material/recipe');
    }

    public function action_recipes()
    {
        $this->_sitePageData->url = '/recipe/shopmaterial/recipes';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/material/list/recipes',
            )
        );

        $this->_requestShopMaterialRubrics();

        // получаем список
        $params = Request_RequestParams::setParams(
            array(
                'limit_page' => 25,
                'formula_type_ids_in' => Arr::path($this->_sitePageData->operation->getAccessArray(), 'formula_type_ids', NULL),
            ),
            FALSE
        );
        View_View::find('DB_Ab1_Shop_Material',
            $this->_sitePageData->shopMainID,
            "_shop/material/list/recipes", "_shop/material/one/recipes",
            $this->_sitePageData, $this->_driverDB, $params,
            array(
                'shop_material_rubric_id' => array('name'),
            )
        );

        $this->_putInMain('/main/_shop/material/recipes');
    }

    public function action_material_recipe()
    {
        $this->_sitePageData->url = '/recipe/shopmaterial/material_recipe';
        $this->_actionShopMaterialRecipe();
    }

    public function action_save()
    {
        $this->_sitePageData->url = '/recipe/shopmaterial/save';

        $result = Api_Ab1_Shop_Material::save($this->_sitePageData, $this->_driverDB);
        $this->_redirectSaveResult($result);
    }
}
