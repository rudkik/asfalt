<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_Weighted_ShopCar extends Controller_Ab1_Weighted_BasicAb1{

    public function __construct(Request $request, Response $response)
    {
        $this->dbObject = 'DB_Ab1_Shop_Car';
        $this->controllerName = 'shopcar';
        $this->tableID = Model_Ab1_Shop_Car::TABLE_ID;
        $this->tableName = Model_Ab1_Shop_Car::TABLE_NAME;
        $this->objectName = 'car';

        parent::__construct($request, $response);
    }

    public function action_index() {
        $this->_sitePageData->url = '/weighted/shopcar/index';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/car/list/index',
            )
        );

        // основная продукция
        $this->_requestShopProducts(
            null, 0, NULL, FALSE,
            [
                Model_Ab1_ProductView::PRODUCT_TYPE_CAR,
                Model_Ab1_ProductView::PRODUCT_TYPE_CAR_AND_PIECE,
            ]
        );

        $this->_requestShopOperations(Model_Ab1_Shop_Operation::RUBRIC_WEIGHT);
        $this->_requestShopTurnPlaces();

        // получаем список
        View_View::find('DB_Ab1_Shop_Car', $this->_sitePageData->shopID, "_shop/car/list/index", "_shop/car/one/index",
            $this->_sitePageData, $this->_driverDB, array('limit' => 1000, 'limit_page' => 25, 'is_exit' => 1),
            array(
                'shop_client_id' => array('name'),
                'shop_product_id' => array('name'),
                'shop_driver_id' => array('name'),
                'weighted_exit_operation_id' => array('name'),
                'shop_turn_place_id' => array('name'),
                'shop_transport_waybill_id' => array('number'),
            )
        );

        $this->_putInMain('/main/_shop/car/index');
    }

    public function action_asu() {
        $this->_sitePageData->url = '/weighted/shopcar/asu';
        $this->_actionASU();
    }

    public function action_asu_cars() {
        $this->_sitePageData->url = '/weighted/shopcar/asu_cars';
        $this->_actionASUCars();
    }

    public function action_entry() {
        $this->_sitePageData->url = '/weighted/shopcar/entry';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/car/list/entry',
            )
        );

        // основная продукция
        $this->_requestShopProducts(
            null, 0, NULL, FALSE,
            [
                Model_Ab1_ProductView::PRODUCT_TYPE_CAR,
                Model_Ab1_ProductView::PRODUCT_TYPE_CAR_AND_PIECE,
            ]
        );

        $this->_requestShopMoveClients();
        $this->_requestShopDeliveries();

        $params = Request_RequestParams::setParams(
            array_merge(
                array(
                    'shop_turn_id' => Model_Ab1_Shop_Turn::TURN_WEIGHTED_ENTRY,
                    'is_exit' => 0,
                    'sort_by' => array('id' => 'asc')
                ),
                array(
                    'sort_by' => Request_RequestParams::getParamArray('sort_by', array(), array())
                )
            )
        );

        // ответ. хранение
        $shopLesseeIDs = Request_Request::find('DB_Ab1_Shop_Lessee_Car',
            $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB,
            $params, 0, TRUE, array('shop_client_id' => array('name'), 'shop_product_id' => array('name'))
        );
        foreach ($shopLesseeIDs->childs as $child){
            $child->values['type'] = Model_Ab1_Shop_Lessee_Car::TABLE_ID;
        }

        // перемещение
        $moveCarIDs = Request_Request::find('DB_Ab1_Shop_Move_Car',
            $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB,
            $params, 0, TRUE, array('shop_client_id' => array('name'), 'shop_product_id' => array('name'))
        );
        foreach ($moveCarIDs->childs as $child){
            $child->values['type'] = Model_Ab1_Shop_Move_Car::TABLE_ID;
        }

        // брак
        $defectCarIDs = Request_Request::find('DB_Ab1_Shop_Defect_Car',
            $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB,
            $params, 0, TRUE, array('shop_client_id' => array('name'), 'shop_product_id' => array('name'))
        );
        foreach ($defectCarIDs->childs as $child){
            $child->values['type'] = Model_Ab1_Shop_Defect_Car::TABLE_ID;
        }

        // реализация
        $carIDs = Request_Request::find('DB_Ab1_Shop_Car',
            $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB,
            $params, 0, TRUE, array('shop_client_id' => array('name'), 'shop_product_id' => array('name'))
        );
        foreach ($carIDs->childs as $child){
            $child->values['type'] = Model_Ab1_Shop_Car::TABLE_ID;
        }

        $ids = new MyArray();
        $ids->addChilds($carIDs);
        $ids->addChilds($moveCarIDs);
        $ids->addChilds($defectCarIDs);
        $ids->addChilds($shopLesseeIDs);
        $this->_sitePageData->countRecord = count($ids->childs);
        $this->_sitePageData->limitPage = $this->_sitePageData->countRecord;

        $this->_sitePageData->replaceDatas['view::_shop/car/list/entry'] = Helpers_View::getViewObjects(
            $ids, new Model_Ab1_Shop_Car(),
            '_shop/car/list/entry', '_shop/car/one/entry',
            $this->_sitePageData, $this->_driverDB, TRUE,
            array('shop_client_id' => array('name'), 'shop_product_id' => array('name'))
        );

        $this->_putInMain('/main/_shop/car/entry');
    }

    public function action_exit() {
        $this->_sitePageData->url = '/weighted/shopcar/exit';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/car/list/exit',
            )
        );
        $this->_requestShopTransportCompanies();
        $this->_requestShopTurnPlaces();

        $params = Request_RequestParams::setParams(
            array(
                'shop_turn_id' => array(Model_Ab1_Shop_Turn::TURN_WEIGHTED_EXIT, Model_Ab1_Shop_Turn::TURN_CASH_EXIT),
                'is_exit' => 0, 'sort_by' => array('updated_at' => 'asc')
            )
        );
        $elements = array(
            'shop_client_id' => array('name'),
            'shop_product_id' => array('name', 'is_packed', 'tare', 'coefficient_weight_quantity'),
            'shop_driver_id' => array('name')
        );

        // ответ.хранение
        $shopLesseeCarIDs = Request_Request::find('DB_Ab1_Shop_Lessee_Car',
            $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB,
            $params, 0, TRUE, $elements
        );
        foreach ($shopLesseeCarIDs->childs as $child){
            $child->values['type'] = Model_Ab1_Shop_Lessee_Car::TABLE_ID;
        }

        // перемещение
        $moveCarIDs = Request_Request::find('DB_Ab1_Shop_Move_Car',
            $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB,
            $params, 0, TRUE, $elements
        );
        foreach ($moveCarIDs->childs as $child){
            $child->values['type'] = Model_Ab1_Shop_Move_Car::TABLE_ID;
        }

        // брак
        $defectCarIDs = Request_Request::find('DB_Ab1_Shop_Defect_Car',
            $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB,
            $params, 0, TRUE, $elements
        );
        foreach ($defectCarIDs->childs as $child){
            $child->values['type'] = Model_Ab1_Shop_Defect_Car::TABLE_ID;
        }

        // реализация
        $carIDs = Request_Request::find('DB_Ab1_Shop_Car',
            $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB,
            $params, 0, TRUE, $elements
        );
        foreach ($carIDs->childs as $child){
            $child->values['type'] = Model_Ab1_Shop_Car::TABLE_ID;
        }

        $ids = new MyArray();
        $ids->childs = array_merge($carIDs->childs, $moveCarIDs->childs, $defectCarIDs->childs, $shopLesseeCarIDs->childs);
        $this->_sitePageData->countRecord = count($ids->childs);
        $this->_sitePageData->limitPage = $this->_sitePageData->countRecord;

        $this->_sitePageData->replaceDatas['view::_shop/car/list/exit'] = Helpers_View::getViewObjects($ids, new Model_Ab1_Shop_Car(),
            '_shop/car/list/exit', '_shop/car/one/exit', $this->_sitePageData, $this->_driverDB, TRUE,
            array('shop_client_id' => array('name'), 'shop_product_id' => array('name')));

        $this->_putInMain('/main/_shop/car/exit');
    }

    public function action_exit_all() {
        $this->_sitePageData->url = '/weighted/shopcar/exit_all';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/car/list/exit',
                'view::_shop/turn/place/list/transfer',
            )
        );
        $this->_requestShopTransportCompanies();
        $this->_requestShopTurnPlaces();

        View_View::find('DB_Ab1_Shop_Turn_Place',
            $this->_sitePageData->shopID,
            "_shop/turn/place/list/transfer", "_shop/turn/place/one/transfer",
            $this->_sitePageData, $this->_driverDB,
            array(
                Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE,
                'sort_by' => array('value'=> array('name' => 'asc'))
            )
        );

        $params = Request_RequestParams::setParams(
            array(
                'shop_turn_id' => array(Model_Ab1_Shop_Turn::TURN_ASU, Model_Ab1_Shop_Turn::TURN_WEIGHTED_EXIT, Model_Ab1_Shop_Turn::TURN_CASH_EXIT),
                'is_exit' => 0, 'sort_by' => array('updated_at' => 'asc')
            )
        );
        $elements = array(
            'shop_client_id' => array('name'),
            'shop_product_id' => array('name', 'is_packed', 'tare', 'coefficient_weight_quantity'),
            'shop_driver_id' => array('name'),
            'shop_turn_place_id' => array('name')
        );

        // ответ.хранение
        $shopLesseeCarIDs = Request_Request::find('DB_Ab1_Shop_Lessee_Car',
            $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB,
            $params, 0, TRUE, $elements
        );
        foreach ($shopLesseeCarIDs->childs as $child){
            $child->values['type'] = Model_Ab1_Shop_Lessee_Car::TABLE_ID;
        }

        // перемещение
        $moveCarIDs = Request_Request::find('DB_Ab1_Shop_Move_Car',
            $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB,
            $params, 0, TRUE, $elements
        );
        foreach ($moveCarIDs->childs as $child){
            $child->values['type'] = Model_Ab1_Shop_Move_Car::TABLE_ID;
        }

        // брак
        $defectCarIDs = Request_Request::find('DB_Ab1_Shop_Defect_Car',
            $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB,
            $params, 0, TRUE, $elements
        );
        foreach ($defectCarIDs->childs as $child){
            $child->values['type'] = Model_Ab1_Shop_Defect_Car::TABLE_ID;
        }

        // реализация
        $carIDs = Request_Request::find('DB_Ab1_Shop_Car',
            $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB,
            $params, 0, TRUE, $elements
        );
        foreach ($carIDs->childs as $child){
            $child->values['type'] = Model_Ab1_Shop_Car::TABLE_ID;
        }

        $ids = new MyArray();
        $ids->childs = array_merge($carIDs->childs, $moveCarIDs->childs, $defectCarIDs->childs, $shopLesseeCarIDs->childs);
        $this->_sitePageData->countRecord = count($ids->childs);
        $this->_sitePageData->limitPage = $this->_sitePageData->countRecord;

        $this->_sitePageData->replaceDatas['view::_shop/car/list/exit'] = Helpers_View::getViewObjects($ids, new Model_Ab1_Shop_Car(),
            '_shop/car/list/exit', '_shop/car/one/exit', $this->_sitePageData, $this->_driverDB, TRUE,
            array('shop_client_id' => array('name'), 'shop_product_id' => array('name')));

        $this->_putInMain('/main/_shop/car/exit');
    }

    public function action_exit_empty() {
        $this->_sitePageData->url = '/weighted/shopcar/exit_empty';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/car/list/exit-empty',
                'view::_shop/turn/place/list/transfer',
            )
        );
        $this->_requestShopTransportCompanies();

        View_View::find('DB_Ab1_Shop_Turn_Place', $this->_sitePageData->shopID, "_shop/turn/place/list/transfer",
            "_shop/turn/place/one/transfer", $this->_sitePageData, $this->_driverDB,
            array(Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE,
                'sort_by' => array('value'=> array('name' => 'asc'))));

        $params = Request_RequestParams::setParams(
            array(
                'shop_turn_id' => array(Model_Ab1_Shop_Turn::TURN_ASU, Model_Ab1_Shop_Turn::TURN_WEIGHTED_EXIT, Model_Ab1_Shop_Turn::TURN_CASH_EXIT),
                'is_exit' => 0, 'sort_by' => array('updated_at' => 'asc')
            )
        );
        $elements = array(
            'shop_client_id' => array('name'),
            'shop_product_id' => array('name', 'is_packed', 'tare', 'coefficient_weight_quantity'),
            'shop_driver_id' => array('name'),
            'shop_turn_place_id' => array('name')
        );

        // ответ.хранение
        $shopLesseeCarIDs = Request_Request::find('DB_Ab1_Shop_Lessee_Car',
            $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB,
            $params, 0, TRUE, $elements
        );
        foreach ($shopLesseeCarIDs->childs as $child){
            $child->values['type'] = Model_Ab1_Shop_Lessee_Car::TABLE_ID;
        }

        // перемещение
        $moveCarIDs = Request_Request::find('DB_Ab1_Shop_Move_Car',
            $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB,
            $params, 0, TRUE, $elements
        );
        foreach ($moveCarIDs->childs as $child){
            $child->values['type'] = Model_Ab1_Shop_Move_Car::TABLE_ID;
        }

        // брак
        $defectCarIDs = Request_Request::find('DB_Ab1_Shop_Defect_Car',
            $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB,
            $params, 0, TRUE, $elements
        );
        foreach ($defectCarIDs->childs as $child){
            $child->values['type'] = Model_Ab1_Shop_Defect_Car::TABLE_ID;
        }

        // реализация
        $carIDs = Request_Request::find('DB_Ab1_Shop_Car',
            $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB,
            $params, 0, TRUE, $elements
        );
        foreach ($carIDs->childs as $child){
            $child->values['type'] = Model_Ab1_Shop_Car::TABLE_ID;
        }

        $ids = new MyArray();
        $ids->childs = array_merge($carIDs->childs, $moveCarIDs->childs, $defectCarIDs->childs, $shopLesseeCarIDs->childs);
        $this->_sitePageData->countRecord = count($ids->childs);
        $this->_sitePageData->limitPage = $this->_sitePageData->countRecord;

        $this->_sitePageData->replaceDatas['view::_shop/car/list/exit-empty'] = Helpers_View::getViewObjects($ids, new Model_Ab1_Shop_Car(),
            '_shop/car/list/exit-empty', '_shop/car/one/exit-empty', $this->_sitePageData, $this->_driverDB, TRUE,
            array('shop_client_id' => array('name'), 'shop_product_id' => array('name')));

        $this->_putInMain('/main/_shop/car/exit-empty');
    }

    public function action_new()
    {
        $this->_sitePageData->url = '/weighted/shopcar/new';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/car/one/new',
            )
        );

        // основная продукция
        $this->_requestShopProducts(
            null, 0, NULL, FALSE,
            [
                Model_Ab1_ProductView::PRODUCT_TYPE_CAR,
                Model_Ab1_ProductView::PRODUCT_TYPE_CAR_AND_PIECE,
            ]
        );

        $this->_requestShopDeliveries();
        $this->_requestOrganizationTypes();
        $this->_requestKatos();

        $dataID = new MyArray();
        $dataID->id = 0;
        $dataID->isFindDB = TRUE;

        $this->_sitePageData->replaceDatas['view::_shop/car/one/new'] = Helpers_View::getViewObject($dataID, new Model_Ab1_Shop_Car(),
            '_shop/car/one/new', $this->_sitePageData, $this->_driverDB);

        $this->_putInMain('/main/_shop/car/new');
    }

    public function action_edit()
    {
        $this->_sitePageData->url = '/weighted/shopcar/edit';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/car/one/edit',
            )
        );

        // id записи
        $shopCarID = Request_RequestParams::getParamInt('id');
        if ($shopCarID === NULL) {
            throw new HTTP_Exception_404('Car not is found!');
        }else {
            $model = new Model_Ab1_Shop_Car();
            if (! $this->dublicateObjectLanguage($model, $shopCarID)) {
                throw new HTTP_Exception_404('Car not is found!');
            }
        }
        $model->dbGetElements($this->_sitePageData->shopMainID, array('shop_client_id'));

        // основная продукция
        $this->_requestShopProducts(
            $model->getShopProductID(), 0, NULL, FALSE,
            [
                Model_Ab1_ProductView::PRODUCT_TYPE_CAR,
                Model_Ab1_ProductView::PRODUCT_TYPE_CAR_AND_PIECE,
            ]
        );

        $this->_requestShopClientAttorney($model->getShopClientID(), NULL, 'list-weight');
        $this->_requestShopDeliveries($model->getShopDeliveryID());

        // получаем данные
        $result = View_View::findOne('DB_Ab1_Shop_Car', $this->_sitePageData->shopID, "_shop/car/one/edit",
            $this->_sitePageData, $this->_driverDB, array('id' => $shopCarID),
            array('shop_payment_id', 'shop_client_id', 'shop_client_attorney_id', 'shop_product_id', 'shop_driver_id'));

        $this->response->body($this->_sitePageData->replaceStaticDatas($result));
       // $this->_putInMain('/main/_shop/car/edit');
    }

    public function action_get_images()
    {
        $this->_sitePageData->url = '/weighted/shopcar/get_images';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/car/one/images',
            )
        );

        // id записи
        $shopCarID = Request_RequestParams::getParamInt('id');
        if ($shopCarID === NULL) {
            throw new HTTP_Exception_404('Car not is found!');
        }else {
            $model = new Model_Ab1_Shop_Car();
            if (! $this->dublicateObjectLanguage($model, $shopCarID)) {
                throw new HTTP_Exception_404('Car not is found!');
            }
        }

        // получаем данные
        $result = View_View::findOne('DB_Ab1_Shop_Car', $this->_sitePageData->shopID, "_shop/car/one/images",
            $this->_sitePageData, $this->_driverDB, array('id' => $shopCarID));

        $this->response->body($this->_sitePageData->replaceStaticDatas($result));
    }

    public function action_get()
    {
        $this->_sitePageData->url = '/weighted/shopcar/get';

        // id записи
        $shopCarID = Request_RequestParams::getParamInt('id');
        if ($shopCarID === NULL) {
            throw new HTTP_Exception_404('Car not is found!');
        }else {
            $model = new Model_Ab1_Shop_Car();
            if (! $this->dublicateObjectLanguage($model, $shopCarID)) {
                throw new HTTP_Exception_404('Car not is found!');
            }
        }
        $model->dbGetElements($this->_sitePageData->shopID, array('shop_payment_id', 'shop_turn_id', 'shop_driver_id', 'shop_product_id', 'shop_client_id'));

        $this->response->body(json_encode($model->getValues(TRUE, TRUE)));
    }

    public function action_save()
    {
        $this->_sitePageData->url = '/weighted/shopcar/save';

        $id = Request_RequestParams::getParamInt('id');
        if($id > 0) {
            $model = new Model_Ab1_Shop_Car();
            $model->setDBDriver($this->_driverDB);
            if (Helpers_DB::dublicateObjectLanguage($model, $id, $this->_sitePageData, -1, false)) {
                $result = Api_Ab1_Shop_Car::save($this->_sitePageData, $this->_driverDB);
            } else {
                $model = new Model_Ab1_Shop_Move_Car();
                $model->setDBDriver($this->_driverDB);
                if (Helpers_DB::dublicateObjectLanguage($model, $id, $this->_sitePageData, -1, false)) {
                    self::redirect('/weighted/shopmovecar/save' . URL::query($_POST));
                    exit();
                } else {
                    $model = new Model_Ab1_Shop_Defect_Car();
                    $model->setDBDriver($this->_driverDB);
                    if (Helpers_DB::dublicateObjectLanguage($model, $id, $this->_sitePageData, -1, false)) {
                        self::redirect('/weighted/shopdefectcar/save' . URL::query($_POST));
                        exit();
                    } else {
                        $model = new Model_Ab1_Shop_Lessee_Car();
                        $model->setDBDriver($this->_driverDB);
                        if (Helpers_DB::dublicateObjectLanguage($model, $id, $this->_sitePageData, -1, false)) {
                            self::redirect('/weighted/shoplesseecar/save' . URL::query($_POST));
                            exit();
                        } else {
                            throw new HTTP_Exception_500('Car not found.');
                        }
                    }
                }
            }
        }else{
            $result = Api_Ab1_Shop_Car::save($this->_sitePageData, $this->_driverDB);
        }

        if (Request_RequestParams::getParamBoolean('json') || $result['result']['error']) {
            $this->response->body(Json::json_encode($result['result']));
        } else {
            $branchID = '';
            if($this->_sitePageData->branchID > 0){
                $branchID = '&shop_branch_id='.$this->_sitePageData->branchID;
            }

            $url = Request_RequestParams::getParamStr('url');
            if (!empty($url)){
                $this->redirect($url);
            }elseif(Request_RequestParams::getParamBoolean('is_close') === FALSE){
                $this->redirect('/weighted/shopcar/edit'
                    . URL::query(
                        array(
                            'id' => $result['id'],
                        ),
                        FALSE
                    )
                    .$branchID
                );
            }else {
                $this->redirect('/weighted/shopcar/entry'
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

    public function action_del()
    {
        $this->_sitePageData->url = '/weighted/shopcar/del';
        $result = Api_Ab1_Shop_Car::delete($this->_sitePageData, $this->_driverDB);
        $this->response->body(Json::json_encode(array('error' => $result)));
    }

    public function action_send_tarra()
    {
        $this->_sitePageData->url = '/weighted/shopcar/send_tarra';

        // id записи
        if (Request_RequestParams::getParamFloat('is_save')){
            $result = Api_Ab1_Shop_Car::save($this->_sitePageData, $this->_driverDB);
            $shopCarID = $result['id'];
        }else {
            $shopCarID = Request_RequestParams::getParamInt('id');
        }

        $model = new Model_Ab1_Shop_Car();
        if (! $this->dublicateObjectLanguage($model, $shopCarID, -1, false)) {
            $model = new Model_Ab1_Shop_Lessee_Car();
            if ($this->dublicateObjectLanguage($model, $shopCarID, -1, false)) {
                $this->redirect('/weighted/shoplesseecar/send_tarra'.URL::query($_POST));
                exit();
            }else {
                $model = new Model_Ab1_Shop_Defect_Car();
                if ($this->dublicateObjectLanguage($model, $shopCarID, -1, false)) {
                    $this->redirect('/weighted/shopdefectcar/send_tarra' . URL::query($_POST));
                    exit();
                } else {
                    $this->redirect('/weighted/shopmovecar/send_tarra' . URL::query($_POST));
                    exit();
                }
            }
        }

        $isError = FALSE;

        $tarra = Request_RequestParams::getParamFloat('tarra');
        if ($tarra <= 0.01){
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

        if (! $isError) {
            Request_RequestParams::setParamStr('name', $model);
            Request_RequestParams::setParamFloat('tarra', $model);
            if(! $model->getIsTest()) {
                Request_RequestParams::setParamBoolean('is_test', $model);
            }

            $result = array();
            if ($model->validationFields($result)) {
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
                $file->saveFiles($files, $model, $this->_sitePageData, $this->_driverDB);

                $this->saveDBObject($model);

                // обновляем / добавляем тару машины клиента
                $shopCarTareIDs = Request_Request::find('DB_Ab1_Shop_Car_Tare',
                    $this->_sitePageData->shopMainID, $this->_sitePageData, $this->_driverDB,
                    Request_RequestParams::setParams(
                        array(
                            'shop_client_id' => $model->getShopClientID(),
                            'name' => $model->getName(),
                        )
                    ), 1
                );
                if(count($shopCarTareIDs->childs) == 0){
                    $modelTare = new Model_Ab1_Shop_Car_Tare();
                    $modelTare->setDBDriver($this->_driverDB);
                    $modelTare->setName($model->getName());
                    $modelTare->setWeight($model->getTarra());
                    $modelTare->setShopClientID($model->getShopClientID());

                    Helpers_DB::saveDBObject($modelTare, $this->_sitePageData, $this->_sitePageData->shopMainID);
                }

                $this->_driverDB->sendSQL('UPDATE ab_shop_car_tares SET weight = '.$model->getTarra().', updated_at = \''.date('Y-m-d H:i:s').'\' WHERE name=\''.Helpers_DB::htmlspecialchars($model->getName()).'\';');
            }

            $this->response->body(
                Json::json_encode(
                    array(
                        'error' => 0,
                        'result' => $result,
                        'html' => $this->_requestShopTurnPlacesByProduct($model->getShopProductID(), $model->id),
                    )
                )
            );
        }
    }

    public function action_send_brutto()
    {
        $this->_sitePageData->url = '/weighted/shopcar/send_brutto';

        // id записи
        $shopCarID = Request_RequestParams::getParamInt('id');
        $model = new Model_Ab1_Shop_Car();
        if (! $this->dublicateObjectLanguage($model, $shopCarID)) {
            $model = new Model_Ab1_Shop_Lessee_Car();
            if ($this->dublicateObjectLanguage($model, $shopCarID)) {
                $this->redirect('/weighted/shoplesseecar/send_brutto' . URL::query($_POST));
                exit();
            } else {
                $model = new Model_Ab1_Shop_Defect_Car();
                if ($this->dublicateObjectLanguage($model, $shopCarID)) {
                    $this->redirect('/weighted/shopdefectcar/send_brutto' . URL::query($_POST));
                    exit();
                } else {
                    $this->redirect('/weighted/shopmovecar/send_brutto' . URL::query($_POST));
                    exit();
                }
            }
        }

        $isError = FALSE;
        $brutto = Request_RequestParams::getParamFloat('brutto');
        $isEmpty = Request_RequestParams::getParamBoolean('is_empty');
        if ($isEmpty){
            $weight = $brutto - $model->getTarra();
            if ($weight >= 0.1) {
                $this->response->body(
                    Json::json_encode(
                        array(
                            'error' => 2,
                            'msg' => 'Вес брутто "' . (floatval($brutto)) . '" слишком на много отличается от тары.',
                        )
                    )
                );
                $isError = TRUE;
            }
            $weight = 0;
        }elseif (($brutto < $model->getTarra()) || ($brutto == 0)){
            $this->response->body(
                Json::json_encode(
                    array(
                        'error' => 2,
                        'msg' => 'Вес брутто "'.(intval($brutto)).'" задан не верно.',
                    )
                )
            );
            $isError = TRUE;
            exit;
        }else{
            $weight = $brutto - $model->getTarra();
        }

        $modelProduct = new Model_Ab1_Shop_Product();
        if (!$this->getDBObject($modelProduct, $model->getShopProductID())) {
            throw new HTTP_Exception_404('Product not is found!');
        }

        if (!$isEmpty) {
            // убираем вес упаковки
            $packedCount = intval(Request_RequestParams::getParamInt('packed_count'));
            if ($packedCount > 0) {
                $model->setPackedCount($packedCount);

                $model->setPackedQuantity($modelProduct->getTare() * $packedCount);
            } else {
                $model->setPackedCount(0);
                $model->setPackedQuantity(0);
            }
            $weight = $weight - $model->getPackedQuantity();
            if ($weight < 0) {
                $this->response->body(
                    Json::json_encode(
                        array(
                            'error' => 2,
                            'msg' => 'Итоговый вес не может быть отрицательным "' . ($weight) . '" задан не верно.',
                        )
                    )
                );
                $isError = TRUE;
                exit;
            }
        }

        if (! $isError) {
            // добавляем id водителя
            $driverName = Request_RequestParams::getParamStr('shop_driver_name');
            if($driverName !== NULL) {
                $model->setShopDriverID(
                    Api_Ab1_Shop_Driver::getShopDriverIDByName(
                        $driverName, $model->getShopClientID(), $this->_sitePageData, $this->_driverDB
                    )
                );
            }

            Request_RequestParams::setParamInt("shop_transport_company_id", $model);
            if(! $model->getIsTest()) {
                Request_RequestParams::setParamBoolean('is_test', $model);
            }

            // просыпал
            $spill = Request_RequestParams::getParamFloat('spill');
            if($spill < 0){
                $spill = 0;
            }
            $model->setSpill($spill);

            $weight = ($weight + $spill) * $modelProduct->getCoefficientWeightQuantity();

            // корректируем новый вес
            $model->setQuantity($weight);

            // просчитываем стоимость доставки
            $model->setDeliveryAmount(
                Api_Ab1_Shop_Delivery::getPrice(
                    $model->getDeliveryAmount(), $model->getDeliveryKM(), $model->getQuantity(), $model->getShopDeliveryID(),
                    $model->getIsCharity(), $this->_sitePageData, $this->_driverDB
                )
            );

            // Задаем суммы реализации
            Api_Ab1_Shop_Car::setAmount($model->getAmount(), $model, $this->_sitePageData, $this->_driverDB);

            $params = Request_RequestParams::setParams(
                array(
                    'shop_car_id' => $model->id,
                )
            );

            // список товаров
            $items = Request_Request::find('DB_Ab1_Shop_Car_Item',
                $model->shopID, $this->_sitePageData,$this->_driverDB, $params, 0, TRUE
            );
            if(count($items->childs) == 1){
                $modelItem = new Model_Ab1_Shop_Car_Item();
                $modelItem->setDBDriver($this->_driverDB);
                $items->childs[0]->setModel($modelItem);
                $modelItem->setQuantity($model->getQuantity());
                $modelItem->setAmount($model->getQuantity() * $modelItem->getPrice());
                Helpers_DB::saveDBObject($modelItem, $this->_sitePageData, $model->shopID);

                // обновляем заблокированные суммы клиента
                Api_Ab1_Shop_Client::recountBalanceObject(
                    $model, $this->_sitePageData, $this->_driverDB
                );
            }


            $model->setWeightedExitOperationID($this->_sitePageData->operationID);
            $model->setWeightedExitAt(date('Y-m-d H:i:s'));

            // узнаем можно ли выпустить
            $isExit = $isEmpty || $model->getIsDebt();
            if (!$isExit) {
                if ($model->getShopClientAttorneyID() < 1){
                    $modelClient = new Model_Ab1_Shop_Client();
                    if (!$this->getDBObject($modelClient, $model->getShopClientID(), $this->_sitePageData->shopMainID)) {
                        throw new HTTP_Exception_404('Client not is found!');
                    }

                    $amount = $modelClient->getBalanceCache();
                }else{
                    $modelAttorney = new Model_Ab1_Shop_Client_Attorney();
                    if (!$this->getDBObject($modelAttorney, $model->getShopClientAttorneyID(), $this->_sitePageData->shopID)) {
                        throw new HTTP_Exception_404('Client attorney not is found!');
                    }else{
                        $amount = $modelAttorney->getBalance();
                    }
                }

                $isExit = ($amount >= 0);
            } else {
                $amount = 0;
            }
            if ($isExit) {
                $model->setShopTurnID(Model_Ab1_Shop_Turn::TURN_EXIT);
            }else{
                $model->setShopTurnID(Model_Ab1_Shop_Turn::TURN_CASH_EXIT);
            }
            $model->setIsExit($isExit);

            // изображения
            $file = new Model_File($this->_sitePageData);

            $data = Controller_Ab1_Weighted_Data::getDataFiles();
            $files = array(
                0 => array(
                    'title' => 'Брутто - передняя камера',
                    'url' => Arr::path($data, 'front', ''),
                    'type' => Model_ImageType::IMAGE_TYPE_IMAGE,
                ),
                1 => array(
                    'title' => 'Брутто - задняя камера',
                    'url' => Arr::path($data, 'backside', ''),
                    'type' => Model_ImageType::IMAGE_TYPE_IMAGE,
                )
            );
            $file->saveFiles($files, $model, $this->_sitePageData, $this->_driverDB, TRUE);

            $this->saveDBObject($model);

            // Сохраняем расхода материалов по рецептам
            Api_Ab1_Shop_Register_Material::saveShopCar($model, $this->_sitePageData, $this->_driverDB);

            $this->response->body(
                Json::json_encode(
                    array(
                        'error' => 0,
                        'is_exit' => $isExit,
                        'amount' => $amount,
                        'amount_str' => Func::getPriceStr($this->_sitePageData->currency, abs($amount), TRUE, FALSE),
                    )
                )
            );
        }
    }
}
