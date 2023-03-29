<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_Weighted_ShopCarToMaterial extends Controller_Ab1_Weighted_BasicAb1{

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
        $this->_sitePageData->url = '/weighted/shopcartomaterial/index';

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
                'is_weighted' => true,
                'limit' => 1000, 'limit_page' => 25,
                'is_exit' => 0,
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
                'shop_transport_waybill_id' => array('number'),
            )
        );

        $this->_putInMain('/main/_shop/car/to/material/index');
    }

    public function action_new()
    {
        $this->_sitePageData->url = '/weighted/shopcartomaterial/new';
        $this->_actionShopCarToMaterialNew();
    }

    public function action_edit()
    {
        $this->_sitePageData->url = '/weighted/shopcartomaterial/edit';
        $this->_actionShopCarToMaterialEdit();
    }

    public function action_get_images()
    {
        $this->_sitePageData->url = '/weighted/shopcartomaterial/get_images';

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

    public function action_del()
    {
        $this->_sitePageData->url = '/weighted/shoprawmaterial/del';
        $result = Api_Ab1_Shop_Car_To_Material::delete($this->_sitePageData, $this->_driverDB);
        $this->response->body(Json::json_encode(array('error' => $result)));
    }

    public function action_save()
    {
        $this->_sitePageData->url = '/weighted/shopcartomaterial/save';

        $result = Api_Ab1_Shop_Car_To_Material::save($this->_sitePageData, $this->_driverDB);
        $this->_redirectSaveResult($result);
    }

    public function action_send_tare()
    {
        $this->_sitePageData->url = '/weighted/shopcartomaterial/send_tare';

        // id записи
        $id = Request_RequestParams::getParamInt('id');
        $model = new Model_Ab1_Shop_Car_To_Material();
        if (! $this->dublicateObjectLanguage($model, $id, $this->_sitePageData->shopMainID, FALSE)) {
            throw new HTTP_Exception_404('Car to material not is found!');
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
            if ($model->getQuantity() > 0) {
                $model->setQuantity($quantity);
            }else{
                $model->setQuantityDaughter($quantity);
            }
            $model->setUpdateTareAt(date('Y-m-d H:i:s'));

            $result = array();
            if ($model->validationFields($result)) {
                if(! $model->getIsTest()) {
                    Request_RequestParams::setParamBoolean('is_test', $model);
                }

                $file = new Model_File($this->_sitePageData);

                $data = Controller_Ab1_Weighted_Data::getDataFiles();
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

                $this->saveDBObject($model, $this->_sitePageData->shopMainID);

                // обновление тары машины
                $modelTare = new Model_Ab1_Shop_Car_Tare();
                if ($this->dublicateObjectLanguage($modelTare, $model->getShopCarTareID(), $this->_sitePageData->shopMainID, FALSE)) {
                    $modelTare->setWeight($model->getTare());
                    $this->saveDBObject($modelTare, $this->_sitePageData->shopMainID);
                }
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

    /**
     * Вес получателя сделать весом отправителя
     * @throws HTTP_Exception_404
     */
    public function action_apply_weight_receiver(){
        $this->_sitePageData->url = '/weighted/shopcartomaterial/apply_weight_receiver';

        // id записи
        $id = Request_RequestParams::getParamInt('id');
        $model = new Model_Ab1_Shop_Car_To_Material();
        if (! $this->dublicateObjectLanguage($model, $id, $this->_sitePageData->shopMainID, FALSE)) {
            throw new HTTP_Exception_404('Car not is found!');
        }

        $model->setQuantityDaughter($model->getQuantity());
        Helpers_DB::saveDBObject($model, $this->_sitePageData);

        $this->response->body(
            json_encode(
                array(
                    'error' => FALSE,
                    'values' => $model->getValues(TRUE, TRUE),
                )
            )
        );
    }

    /**
     * Вес получателя сделать весом отправителя
     * @throws HTTP_Exception_404
     */
    public function action_get_receiver_form(){
        $this->_sitePageData->url = '/weighted/shopcartomaterial/get_receiver_form';

        // id записи
        $id = Request_RequestParams::getParamInt('id');
        $model = new Model_Ab1_Shop_Car_To_Material();
        if (! $this->dublicateObjectLanguage($model, $id, $this->_sitePageData->shopMainID, FALSE)) {
            throw new HTTP_Exception_404('Car not is found!');
        }

        $this->_requestShopSubdivisions($model->getShopSubdivisionReceiverID(), $model->getShopBranchReceiverID(), '/receiver');
        $this->_requestShopHeaps($model->getShopHeapReceiverID(), $model->getShopBranchReceiverID(), '/receiver', $model->getShopSubdivisionReceiverID());
        $this->_requestShopMaterials($model->getShopMaterialID(), null, true);

        $objectID = new MyArray();
        $objectID->setValues($model, $this->_sitePageData);
        $objectID->setIsFind(true);

        $data = Controller_Ab1_Weighted_Data::getDataCar();
        $objectID->additionDatas =[
            'is_test' => Arr::path($data, 'is_test', false),
            'brutto' => Arr::path($data, 'weight', 0),
        ];

        // получаем данные
        $result = $this->_sitePageData->replaceDatas['view::_shop/car/to/material/modal/reception-car'] =
            Helpers_View::getViewObject(
                $objectID,
                $model, "_shop/car/to/material/modal/reception-car",
                $this->_sitePageData, $this->_driverDB,
                $this->_sitePageData->shopID
            );

        $this->response->body($this->_sitePageData->replaceStaticDatas($result));
    }

    /**
     * Вес получателя сделать весом отправителя
     * @throws HTTP_Exception_404
     */
    public function action_get_daughter_form(){
        $this->_sitePageData->url = '/weighted/shopcartomaterial/get_daughter_form';

        // id записи
        $id = Request_RequestParams::getParamInt('id');
        $model = new Model_Ab1_Shop_Car_To_Material();
        if (! $this->dublicateObjectLanguage($model, $id, $this->_sitePageData->shopMainID, FALSE)) {
            throw new HTTP_Exception_404('Car not is found!');
        }

        $this->_requestShopSubdivisions($model->getShopSubdivisionReceiverID(), $model->getShopBranchReceiverID(), '/receiver');
        $this->_requestShopHeaps($model->getShopHeapReceiverID(), $model->getShopBranchReceiverID(), '/receiver', $model->getShopSubdivisionReceiverID());
        $this->_requestShopMaterials($model->getShopMaterialID(), null, true);

        $objectID = new MyArray();
        $objectID->setValues($model, $this->_sitePageData);
        $objectID->setIsFind(true);

        $data = Controller_Ab1_Weighted_Data::getDataCar();
        $objectID->additionDatas =[
            'is_test' => Arr::path($data, 'is_test', false),
            'brutto' => Arr::path($data, 'weight', 0),
        ];

        // получаем данные
        $result = $this->_sitePageData->replaceDatas['view::_shop/car/to/material/modal/daughter-car'] =
            Helpers_View::getViewObject(
                $objectID,
                $model, "_shop/car/to/material/modal/daughter-car",
                $this->_sitePageData, $this->_driverDB,
                $this->_sitePageData->shopID
            );

        $this->response->body($this->_sitePageData->replaceStaticDatas($result));
    }
}
