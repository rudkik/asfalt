<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_Crusher_ShopFormulaRaw extends Controller_Ab1_Crusher_BasicAb1
{

    public function __construct(Request $request, Response $response)
    {
        $this->dbObject = 'DB_Ab1_Shop_Formula_Raw';
        $this->controllerName = 'shopformularaw';
        $this->tableID = Model_Ab1_Shop_Formula_Raw::TABLE_ID;
        $this->tableName = Model_Ab1_Shop_Formula_Raw::TABLE_NAME;
        $this->objectName = 'formularaw';

        parent::__construct($request, $response);
    }

    public function action_index()
    {
        $this->_sitePageData->url = '/crusher/shopformularaw/index';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/formula/raw/list/index',
            )
        );

        $this->_requestShopMaterials();

        // получаем список
        $params = Request_RequestParams::setParams(
            array(
                'limit' => 1000, 'limit_page' => 25,
                'formula_type_id' => Arr::path($this->_sitePageData->operation->getAccessArray(), 'formula_type_ids', NULL),
            ),
            FALSE
        );

        // получаем список
        View_View::find(
            'DB_Ab1_Shop_Formula_Raw', $this->_sitePageData->shopID,
            "_shop/formula/raw/list/index", "_shop/formula/raw/one/index",
            $this->_sitePageData, $this->_driverDB, $params,
            array(
                'shop_ballast_id' => array('name'),
                'formula_type_id' => array('name'),
            )
        );

        $this->_putInMain('/main/_shop/formula/raw/index');
    }

    public function action_new()
    {
        $this->_sitePageData->url = '/crusher/shopformularaw/new';
        $this->_actionShopFormulaRawNew();
    }

    public function action_edit()
    {
        $this->_sitePageData->url = '/crusher/shopformularaw/edit';
        $this->_actionShopFormulaRawEdit();
    }

    public function action_save()
    {
        $this->_sitePageData->url = '/crusher/shopformularaw/save';

        $result = Api_Ab1_Shop_Formula_Raw::save($this->_sitePageData, $this->_driverDB);
        $result['id'] = Request_RequestParams::getParamInt('shop_raw_id');
        $this->_redirectSaveResult(
            $result, '/crusher/shopraw/raw_recipe',
            array(
                'id' => $result['id'],
            )
        );
    }
}
