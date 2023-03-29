<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_Abc_ShopCarToMaterial extends Controller_Ab1_Abc_BasicAb1{

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
        $this->_sitePageData->url = '/abc/shopcartomaterial/index';

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
                'limit' => 1000,
                'limit_page' => 25,
                'is_exit' => 0,
                'sort_by' => array('updated_at' => 'desc'),
                'main_shop_id' => $this->_sitePageData->shopID,
            ),
            FALSE
        );

        View_View::find('DB_Ab1_Shop_Car_To_Material',
            $this->_sitePageData->shopMainID,
            "_shop/car/to/material/list/index", "_shop/car/to/material/one/index",
            $this->_sitePageData, $this->_driverDB, $params,
            array(
                'shop_daughter_id' => array('name'),
                'shop_material_id' => array('name'),
                'shop_driver_id' => array('name'),
                'shop_client_material_id' => array('name'),
                'weighted_operation_id' => array('name'),
                'shop_branch_receiver_id' => array('name'),
                'shop_branch_daughter_id' => array('name'),
                'shop_heap_daughter_id' => array('name'),
                'shop_heap_receiver_id' => array('name'),
                'shop_subdivision_daughter_id' => array('name'),
                'shop_subdivision_receiver_id' => array('name'),
                'shop_transport_company_id' => array('name'),
            )
        );

        $this->_putInMain('/main/_shop/car/to/material/index');
    }

    public function action_new()
    {
        $this->_sitePageData->url = '/abc/shopcartomaterial/new';
        $this->_actionShopCarToMaterialNew();
    }

    public function action_edit()
    {
        $this->_sitePageData->url = '/abc/shopcartomaterial/edit';
        $this->_actionShopCarToMaterialEdit();
    }

    public function action_save()
    {
        $this->_sitePageData->url = '/abc/shopcartomaterial/save';

        $result = Api_Ab1_Shop_Car_To_Material::save($this->_sitePageData, $this->_driverDB);
        $this->_redirectSaveResult($result, '', array('is_weighted' => $result['result']['values']['is_weighted']));
    }
}
