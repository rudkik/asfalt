<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_ZhbiBc_ShopCarToMaterial extends Controller_Ab1_ZhbiBc_BasicAb1{

    public function __construct(Request $request, Response $response)
    {
        $this->dbObject = 'DB_Ab1_Shop_Car_To_Material';
        $this->controllerName = 'shopcartomaterial';
        $this->tableID = Model_Ab1_Shop_Car_To_Material::TABLE_ID;
        $this->tableName = Model_Ab1_Shop_Car_To_Material::TABLE_NAME;
        $this->objectName = 'cartomaterial';

        parent::__construct($request, $response);
    }

    public function action_index() {
        $this->_sitePageData->url = '/zhbibc/shopcartomaterial/index';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/car/to/material/list/index',
            )
        );

        $this->_requestShopMaterials(NULL, null, true);
        $this->_requestShopDaughters();
        $this->_requestShopBranches(null, true);
        $this->_requestShopSubdivisions(null, -1, '');
        $this->_requestShopTransportCompanies();

        if($this->_sitePageData->operation->getIsAdmin()) {
            $this->_requestShopOperations(Model_Ab1_Shop_Operation::RUBRIC_WEIGHT);
        }

        // получаем список
        $params = Request_RequestParams::setParams(
            array(
                'is_zhbibc' => true,
                'limit' => 1000, 'limit_page' => 25,
                'is_exit' => 0,
                'sort_by' => array('updated_at' => 'desc'),
                'main_shop_id' => $this->_sitePageData->shopID,
                'is_weighted' => true,
            ),
            FALSE
        );

        if(Request_RequestParams::getParamBoolean('is_error_receiver')){
            $params['shop_client_material_id'] = 0;
            $params['shop_subdivision_receiver_id'] = 0;
            $params['shop_branch_receiver_id_from'] = 0;
            $params['limit'] = 0;
            $this->_sitePageData->urlParams['is_error_receiver'] = true;
        }

        if(Request_RequestParams::getParamBoolean('is_error_daughter')){
            $params['shop_client_material_id'] = 0;
            $params['shop_subdivision_daughter_id'] = 0;
            $params['shop_branch_daughter_id_from'] = 0;
            $params['limit'] = 0;
            $this->_sitePageData->urlParams['is_error_daughter'] = true;
        }

        $params['shop_subdivision_id'] = $this->_sitePageData->operation->getProductShopSubdivisionIDsArray();

        View_View::find('DB_Ab1_Shop_Car_To_Material', $this->_sitePageData->shopMainID,
            "_shop/car/to/material/list/index", "_shop/car/to/material/one/index",
            $this->_sitePageData, $this->_driverDB, $params,
            array(
                'shop_daughter_id' => array('name'),
                'shop_material_id' => array('name'),
                'shop_driver_id' => array('name'),
                'shop_client_material_id' => array('name'),
                'zhbibc_operation_id' => array('name'),
                'shop_branch_receiver_id' => array('name'),
                'shop_branch_daughter_id' => array('name'),
                'shop_heap_daughter_id' => array('name'),
                'shop_heap_receiver_id' => array('name'),
                'shop_subdivision_daughter_id' => array('name'),
                'shop_subdivision_receiver_id' => array('name'),
                'shop_transport_waybill_id' => array('number'),
            )
        );

        $this->_putInMain('/main/_shop/car/to/material/index');
    }

    public function action_move() {
        $this->_sitePageData->url = '/zhbibc/shopcartomaterial/move';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/car/to/material/list/move',
            )
        );

        $this->_requestShopMaterials(NULL, null, true);
        $this->_requestShopDaughters();
        $this->_requestShopBranches(null, true);
        $this->_requestShopSubdivisions(null, -1, '');

        if($this->_sitePageData->operation->getIsAdmin()) {
            $this->_requestShopOperations(Model_Ab1_Shop_Operation::RUBRIC_WEIGHT);
        }

        // получаем список
        $params = Request_RequestParams::setParams(
            array(
                'is_zhbibc' => true,
                'limit_page' => 25,
                'is_exit' => 0,
                'is_weighted' => false,
                'sort_by' => array('updated_at' => 'desc'),
                'main_shop_id' => $this->_sitePageData->shopID,
            ),
            FALSE
        );

        if(Request_RequestParams::getParamBoolean('is_error_receiver')){
            $params['shop_client_material_id'] = 0;
            $params['shop_subdivision_receiver_id'] = 0;
            $params['shop_branch_receiver_id_from'] = 0;
            $params['limit'] = 0;
            $this->_sitePageData->urlParams['is_error_receiver'] = true;
        }

        if(Request_RequestParams::getParamBoolean('is_error_daughter')){
            $params['shop_client_material_id'] = 0;
            $params['shop_subdivision_daughter_id'] = 0;
            $params['shop_branch_daughter_id_from'] = 0;
            $params['limit'] = 0;
            $this->_sitePageData->urlParams['is_error_daughter'] = true;
        }

        $params['shop_subdivision_id'] = $this->_sitePageData->operation->getProductShopSubdivisionIDsArray();

        View_View::find('DB_Ab1_Shop_Car_To_Material', $this->_sitePageData->shopMainID,
            "_shop/car/to/material/list/move", "_shop/car/to/material/one/move",
            $this->_sitePageData, $this->_driverDB, $params,
            array(
                'shop_daughter_id' => array('name'),
                'shop_material_id' => array('name'),
                'shop_driver_id' => array('name'),
                'shop_client_material_id' => array('name'),
                'zhbibc_operation_id' => array('name'),
                'shop_branch_receiver_id' => array('name'),
                'shop_branch_daughter_id' => array('name'),
                'shop_heap_daughter_id' => array('name'),
                'shop_heap_receiver_id' => array('name'),
                'shop_subdivision_daughter_id' => array('name'),
                'shop_subdivision_receiver_id' => array('name'),
                'shop_transport_waybill_id' => array('number'),
            )
        );

        $this->_putInMain('/main/_shop/car/to/material/move');
    }

    public function action_new()
    {
        $this->_sitePageData->url = '/zhbibc/shopcartomaterial/new';
        $this->_actionShopCarToMaterialNew();
    }

    public function action_edit()
    {
        $this->_sitePageData->url = '/zhbibc/shopcartomaterial/edit';
        $this->_actionShopCarToMaterialEdit();
    }

    public function action_get_images()
    {
        $this->_sitePageData->url = '/zhbibc/shopcartomaterial/get_images';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/car/to/material/one/images',
            )
        );

        // id записи
        $id = Request_RequestParams::getParamInt('id');
        $model = new Model_Ab1_Shop_Car_To_Material();
        if (! $this->dublicateObjectLanguage($model, $id, $this->_sitePageData->shopMainID, FALSE)) {
            throw new HTTP_Exception_404('Car not is found!');
        }

        // получаем данные
        $result = View_View::findOne('DB_Ab1_Shop_Car_To_Material', $this->_sitePageData->shopMainID, "_shop/car/to/material/one/images",
            $this->_sitePageData, $this->_driverDB, array('id' => $id));

        $this->response->body($this->_sitePageData->replaceStaticDatas($result));
    }
}
