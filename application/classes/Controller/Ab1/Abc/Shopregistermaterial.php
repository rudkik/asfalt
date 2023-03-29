<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_Abc_ShopRegisterMaterial extends Controller_Ab1_Abc_BasicAb1 {

    public function __construct(Request $request, Response $response)
    {
        $this->dbObject = 'DB_Ab1_Shop_Register_Material';
        $this->controllerName = 'shopregistermaterial';
        $this->tableID = Model_Ab1_Shop_Register_Material::TABLE_ID;
        $this->tableName = Model_Ab1_Shop_Register_Material::TABLE_NAME;
        $this->objectName = 'registermaterial';

        parent::__construct($request, $response);
    }

    public function action_index() {
        $this->_sitePageData->url = '/abc/shopregistermaterial/index';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/register/material/list/index',
            )
        );

        // основная продукция
        $this->_requestShopMaterials();

        $params = array_merge(array('limit' => 1000, 'limit_page' => 25), $_POST, $_GET);
        if(Request_RequestParams::getParamInt('shop_object_id') > 0 && !key_exists('sort_by', $params)){
            $params['sort_by'] = [
                'level' => 'asc',
                'shop_material_id.name' => 'asc',
            ];

            $shopRegisterMaterialIDs = Request_Request::findBranch(
                'DB_Ab1_Shop_Register_Material', array(),
                $this->_sitePageData, $this->_driverDB,
                Request_RequestParams::setParams($params), 0, true,
                array(
                    'shop_material_id' => array('name'),
                    'shop_subdivision_id' => array('name'),
                    'shop_heap_id' => array('name'),
                    'shop_formula_material_id' => array('name'),
                    'shop_formula_raw_id' => array('name'),
                    'shop_formula_product_id' => array('name'),
                )
            );

            $shopRegisterMaterialIDs->buildTree('root_shop_register_material_id');

            $result = Helpers_View::getViewObjects(
                $shopRegisterMaterialIDs, new Model_Ab1_Shop_Register_Material(),
                "_shop/register/material/list/tree", "_shop/register/material/one/tree",
                $this->_sitePageData, $this->_driverDB, 0
            );
            $this->_sitePageData->replaceDatas['view::_shop/register/material/list/index'] = $result;
        }else {
            // получаем список
            View_View::findBranch(
                'DB_Ab1_Shop_Register_Material', array(),
                "_shop/register/material/list/index", "_shop/register/material/one/index",
                $this->_sitePageData, $this->_driverDB,
                Request_RequestParams::setParams($params),
                array(
                    'shop_material_id' => array('name'),
                    'shop_subdivision_id' => array('name'),
                    'shop_heap_id' => array('name'),
                    'shop_formula_material_id' => array('name'),
                    'shop_formula_raw_id' => array('name'),
                    'shop_formula_product_id' => array('name'),
                )
            );
        }

        $this->_putInMain('/main/_shop/register/material/index');
    }

    public function action_total() {
        $this->_sitePageData->url = '/abc/shopregistermaterial/total';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/register/material/list/total',
            )
        );

        $dateFrom = Request_RequestParams::getParamDateTime('date_from');
        if(empty($dateFrom)){
            $dateFrom = Helpers_DateTime::getDateFormatPHP(Helpers_DateTime::getMonthBeginStr(date('m'), date('Y'))) . '06:00:00';
        }
        $dateTo = Request_RequestParams::getParamDateTime('date_to');
        if(empty($dateTo)){
            $dateTo = Helpers_DateTime::getDateFormatPHP(Helpers_DateTime::plusDays(Helpers_DateTime::getMonthEndStr(date('m'), date('Y')), 1)) . '06:00:00';
        }

        $ids = Api_Ab1_Shop_Register_Material::materialsReport($dateFrom, $dateTo, $this->_sitePageData, $this->_driverDB);

        $ids->childsSortBy(
            Request_RequestParams::getParamArray('sort_by', array(), array('shop_material_id.name' => 'asc')),
            true, true
        );


        $result = Helpers_View::getViewObjects(
            $ids, new Model_Ab1_Shop_Register_Material(),
            "_shop/register/material/list/total", "_shop/register/material/one/total",
            $this->_sitePageData, $this->_driverDB, 0
        );
        $this->_sitePageData->replaceDatas['view::_shop/register/material/list/total'] = $result;

        $this->_putInMain('/main/_shop/register/material/total');
    }
}
