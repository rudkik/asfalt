<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_Abc_ShopFormulaMaterial extends Controller_Ab1_Abc_BasicAb1
{

    public function __construct(Request $request, Response $response)
    {
        $this->dbObject = 'DB_Ab1_Shop_Formula_Material';
        $this->controllerName = 'shopformulamaterial';
        $this->tableID = Model_Ab1_Shop_Formula_Material::TABLE_ID;
        $this->tableName = Model_Ab1_Shop_Formula_Material::TABLE_NAME;
        $this->objectName = 'formulamaterial';

        parent::__construct($request, $response);
    }

    public function action_index()
    {
        $this->_sitePageData->url = '/abc/shopformulamaterial/index';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/formula/material/list/index',
            )
        );

        $this->_requestShopMaterials();

        $params = Request_RequestParams::setParams(
            array(
                'limit' => 1000,
                'formula_type_id' => [
                    Model_Ab1_FormulaType::FORMULA_MATERIAL_TYPE_BITUMEN_FUEL_OIL,
                    Model_Ab1_FormulaType::FORMULA_MATERIAL_TYPE_BITUMEN,
                ],
                'limit_page' => 25,
            ),
            false
        );

        // получаем список
        View_View::find('DB_Ab1_Shop_Formula_Material',
            $this->_sitePageData->shopID,
            "_shop/formula/material/list/index", "_shop/formula/material/one/index",
            $this->_sitePageData, $this->_driverDB, $params,
            array('shop_material_id' => array('name'))
        );

        $this->_putInMain('/main/_shop/formula/material/index');
    }

    public function action_new()
    {
        $this->_sitePageData->url = '/abc/shopformulamaterial/new';
        $this->_actionShopFormulaMaterialNew();
    }

    public function action_edit()
    {
        $this->_sitePageData->url = '/abc/shopformulamaterial/edit';
        $this->_actionShopFormulaMaterialEdit();
    }

    public function action_save()
    {
        $this->_sitePageData->url = '/abc/shopformulamaterial/save';

        $result = Api_Ab1_Shop_Formula_Material::save($this->_sitePageData, $this->_driverDB);
        $this->_redirectSaveResult($result);
    }
}
