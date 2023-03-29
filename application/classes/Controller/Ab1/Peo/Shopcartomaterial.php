<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_Peo_ShopCarToMaterial extends Controller_Ab1_Peo_BasicAb1 {

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
        $this->_sitePageData->url = '/peo/shopcartomaterial/index';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/car/to/material/list/index',
            )
        );

        $this->_requestShopMaterials(NULL, null, true);
        $this->_requestShopClientMaterial();
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
        $this->_sitePageData->url = '/peo/shopcartomaterial/edit';

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
        $this->_sitePageData->url = '/peo/shopcartomaterial/get_images';

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

    public function action_save()
    {
        $this->_sitePageData->url = '/peo/shopcartomaterial/save';

        $result = Api_Ab1_Shop_Car_To_Material::save($this->_sitePageData, $this->_driverDB);

        if (Request_RequestParams::getParamBoolean('json') || $result['result']['error']) {
            $this->response->body(Json::json_encode($result['result']));
        } else {
            $branchID = '';
            if($this->_sitePageData->branchID > 0){
                $branchID = '&shop_branch_id='.$this->_sitePageData->branchID;
            }

            if(Request_RequestParams::getParamBoolean('is_close') === FALSE){
                $this->redirect('/peo/shopcartomaterial/edit'
                    . URL::query(
                        array(
                            'id' => $result['id'],
                        ),
                        FALSE
                    )
                    .$branchID
                );
            }else {
                $this->redirect('/peo/shopcartomaterial/index'
                    . URL::query(
                        array(
                            'is_public_ignore' => TRUE,
                        ),
                        FALSE
                    )
                    .$branchID
                );
            }
        }
    }

    public function action_send_tare()
    {
        $this->_sitePageData->url = '/peo/shopcartomaterial/send_tare';

        // id записи
        $id = Request_RequestParams::getParamInt('id');
        if ($id === NULL) {
            throw new HTTP_Exception_404('Car to material not is found!');
        }else {
            $model = new Model_Ab1_Shop_Car_To_Material();
            if (! $this->dublicateObjectLanguage($model, $id)) {
                throw new HTTP_Exception_404('Car to material not is found!');
            }
        }

        $isError = FALSE;
        $tarra = Request_RequestParams::getParamFloat('tarra');
        if ($tarra <= 0.001){
            $this->response->body(
                Json::json_encode(
                    array(
                        'error' => 2,
                        'msg' => 'Вес тары "'.(floatval($tarra)).'" задан не верно.',
                    )
                )
            );
            $isError = TRUE;
        }

        $quantity = Request_RequestParams::getParamFloat('quantity');
        if ($quantity <= 0.001){
            $this->response->body(
                Json::json_encode(
                    array(
                        'error' => 2,
                        'msg' => 'Нетто "'.(floatval($quantity)).'" задан не верно.',
                    )
                )
            );
            $isError = TRUE;
        }

        if (!$isError) {
            $model->setTare($tarra);
            $model->setQuantity($quantity);
            $model->setUpdateTareAt(date('Y-m-d H:i:s'));

            $result = array();
            if ($model->validationFields($result)) {
                $file = new Model_File($this->_sitePageData);

                $data = Controller_Ab1_Peo_Data::getDataFiles();
                $files = array(
                    0 => array(
                        'title' => 'Тара - передняя камера',
                        'url' => Arr::path($data, 'front', ''),
                        'type' => Model_ImageType::IMAGE_TYPE_IMAGE,
                    ),
                    1 => array(
                        'title' => 'Тара - задняя камера',
                        'url' => Arr::path($data, 'backside', ''),
                        'type' => Model_ImageType::IMAGE_TYPE_IMAGE,
                    ),
                );
                $file->saveFiles($files, $model, $this->_sitePageData, $this->_driverDB, TRUE);

                $this->saveDBObject($model);
            }

            $this->response->body(
                Json::json_encode(
                    array(
                        'error' => 0,
                        'result' => $result,
                    )
                )
            );
        }
    }

    public function action_statistics()
    {
        $this->_sitePageData->url = '/peo/shopcartomaterial/statistics';
        $this->_actionShopCarToMaterialStatistics();
    }

    public function action_statistics_daughter()
    {
        $this->_sitePageData->url = '/peo/shopcartomaterial/statistics_daughter';
        $this->_actionShopCarToMaterialDaughterStatistics();
    }

    public function action_statistics_daughter_material()
    {
        $this->_sitePageData->url = '/peo/shopcartomaterial/statistics_daughter_material';
        $this->_actionShopCarToMaterialDaughterMaterialStatistics();
    }
}
