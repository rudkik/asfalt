<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_Ecologist_ShopCarToMaterial extends Controller_Ab1_Ecologist_BasicAb1 {

    public function __construct(Request $request, Response $response)
    {
        $this->dbObject = 'DB_Ab1_Shop_Car_To_Material';
        $this->controllerName = 'shopcar';
        $this->tableID = Model_Ab1_Shop_Car_To_Material::TABLE_ID;
        $this->tableName = Model_Ab1_Shop_Car_To_Material::TABLE_NAME;
        $this->objectName = 'cartomaterial';

        parent::__construct($request, $response);
    }

    public function action_index() {
        $this->_sitePageData->url = '/ecologist/shopcartomaterial/index';

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
            $this->_requestShopOperations(Model_Ab1_Shop_Operation::RUBRIC_ECOLOGIST);
        }

        // получаем список
        $params = Request_RequestParams::setParams(
            array(
                'limit' => 1000, 'limit_page' => 25,
                'is_exit' => 0,
                'sort_by' => array('created_at' => 'desc'),
                'main_shop_id' => $this->_sitePageData->shopID,
            ),
            FALSE
        );

        View_View::find('DB_Ab1_Shop_Car_To_Material', $this->_sitePageData->shopMainID,
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
            )
        );

        $this->_putInMain('/main/_shop/car/to/material/index');
    }

    public function action_edit()
    {
        $this->_sitePageData->url = '/ecologist/shopcartomaterial/edit';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/car/to/material/one/edit',
            )
        );

        // id записи
        $shopCarToMaterialID = Request_RequestParams::getParamInt('id');
        if ($shopCarToMaterialID === NULL) {
            throw new HTTP_Exception_404('Car to material not is found!');
        }else {
            $model = new Model_Ab1_Shop_Car_To_Material();
            if (! $this->dublicateObjectLanguage($model, $shopCarToMaterialID)) {
                throw new HTTP_Exception_404('Car to material not is found!');
            }
        }
        $this->_requestShopMaterials($model->getShopMaterialID());
        $this->_requestShopClientMaterial($model->getShopClientMaterialID());
        $this->_requestShopDaughters($model->getShopDaughterID());
        $this->_requestShopCarTares($model->getShopCarTareID());
        $this->_requestShopTransportCompanies($model->getShopTransportCompanyID());

        // получаем данные
        View_View::findOne('DB_Ab1_Shop_Car_To_Material', $this->_sitePageData->shopID, "_shop/car/to/material/one/edit",
            $this->_sitePageData, $this->_driverDB, array('id' => $shopCarToMaterialID),
            array('shop_daughter_id', 'shop_material_id', 'shop_driver_id'));

        $this->_putInMain('/main/_shop/car/to/material/edit');
    }

    public function action_get_images()
    {
        $this->_sitePageData->url = '/ecologist/shopcartomaterial/get_images';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/car/to/material/one/images',
            )
        );

        // id записи
        $shopCarID = Request_RequestParams::getParamInt('id');
        if ($shopCarID === NULL) {
            throw new HTTP_Exception_404('Car not is found!');
        }else {
            $model = new Model_Ab1_Shop_Car_To_Material();
            if (! $this->dublicateObjectLanguage($model, $shopCarID)) {
                throw new HTTP_Exception_404('Car not is found!');
            }
        }

        // получаем данные
        $result = View_View::findOne('DB_Ab1_Shop_Car', $this->_sitePageData->shopID, "_shop/car/to/material/one/images",
            $this->_sitePageData, $this->_driverDB, array('id' => $shopCarID));

        $this->response->body($this->_sitePageData->replaceStaticDatas($result));
    }

    public function action_statistics()
    {
        $this->_sitePageData->url = '/ecologist/shopcartomaterial/statistics';
        $this->_actionShopCarToMaterialStatistics();
    }

    public function action_statistics_daughter()
    {
        $this->_sitePageData->url = '/ecologist/shopcartomaterial/statistics_daughter';
        $this->_actionShopCarToMaterialDaughterStatistics();
    }

    public function action_statistics_daughter_material()
    {
        $this->_sitePageData->url = '/ecologist/shopcartomaterial/statistics_daughter_material';
        $this->_actionShopCarToMaterialDaughterMaterialStatistics();
    }
}
