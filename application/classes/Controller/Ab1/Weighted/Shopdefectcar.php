<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_Weighted_ShopDefectCar extends Controller_Ab1_Weighted_BasicAb1{

    public function __construct(Request $request, Response $response)
    {
        $this->dbObject = 'DB_Ab1_Shop_Defect_Car';
        $this->controllerName = 'shopdefectcar';
        $this->tableID = Model_Ab1_Shop_Defect_Car::TABLE_ID;
        $this->tableName = Model_Ab1_Shop_Defect_Car::TABLE_NAME;
        $this->objectName = 'defectcar';

        parent::__construct($request, $response);
    }

    public function action_index() {
        $this->_sitePageData->url = '/weighted/shopdefectcar/index';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/defect/car/list/index',
            )
        );

        // основная продукция
        $this->_requestShopProducts(
            null, 0, NULL, FALSE,
            [
                Model_Ab1_ProductView::PRODUCT_TYPE_CAR,
                Model_Ab1_ProductView::PRODUCT_TYPE_CAR_AND_PIECE,
                Model_Ab1_ProductView::PRODUCT_TYPE_PIECE
            ]
        );

        $this->_requestShopOperations(Model_Ab1_Shop_Operation::RUBRIC_WEIGHT);
        $this->_requestShopTurnPlaces();

        // получаем список
        View_View::find('DB_Ab1_Shop_Defect_Car', $this->_sitePageData->shopID, "_shop/defect/car/list/index", "_shop/defect/car/one/index",
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

        $this->_putInMain('/main/_shop/defect/car/index');
    }

    public function action_asu() {
        $this->_sitePageData->url = '/weighted/shopdefectcar/asu';
        $this->_actionASU();
    }

    public function action_entry() {
        $this->_sitePageData->url = '/weighted/shopdefectcar/entry';

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
                Model_Ab1_ProductView::PRODUCT_TYPE_PIECE
            ]
        );

        $this->_requestShopDeliveries();

        // перемещение
        $moveCarIDs = Request_Request::find('DB_Ab1_Shop_Move_Car', $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB,
            array('shop_turn_id' => Model_Ab1_Shop_Turn::TURN_WEIGHTED_ENTRY, 'is_exit' => 0, 'sort_by' => array('value' => array('id' => 'asc'))),
            0, TRUE, array('shop_client_id' => array('name'), 'shop_product_id' => array('name')));
        foreach ($moveCarIDs->childs as $child){
            $child->values['type'] = Model_Ab1_Shop_Move_Car::TABLE_ID;
        }

        // брак
        $defectCarIDs = Request_Request::find('DB_Ab1_Shop_Defect_Car', $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB,
            array('shop_turn_id' => Model_Ab1_Shop_Turn::TURN_WEIGHTED_ENTRY, 'is_exit' => 0, 'sort_by' => array('value' => array('id' => 'asc'))),
            0, TRUE, array('shop_client_id' => array('name'), 'shop_product_id' => array('name')));
        foreach ($moveCarIDs->childs as $child){
            $child->values['type'] = Model_Ab1_Shop_Defect_Car::TABLE_ID;
        }

        // реализация
        $carIDs = Request_Request::find('DB_Ab1_Shop_Car', $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB,
            array('shop_turn_id' => Model_Ab1_Shop_Turn::TURN_WEIGHTED_ENTRY, 'is_exit' => 0, 'sort_by' => array('value' => array('id' => 'asc'))),
            0, TRUE, array('shop_client_id' => array('name'), 'shop_product_id' => array('name')));
        foreach ($carIDs->childs as $child){
            $child->values['type'] = Model_Ab1_Shop_Car::TABLE_ID;
        }

        $ids = new MyArray();
        $ids->childs = array_merge($carIDs->childs, $moveCarIDs->childs, $defectCarIDs->childs);
        $this->_sitePageData->countRecord = count($ids->childs);
        $this->_sitePageData->limitPage = $this->_sitePageData->countRecord;

        $this->_sitePageData->replaceDatas['view::_shop/car/list/entry'] = Helpers_View::getViewObjects($ids, new Model_Ab1_Shop_Car(),
            '_shop/car/list/entry', '_shop/car/one/entry', $this->_sitePageData, $this->_driverDB, TRUE,
            array('shop_client_id' => array('name'), 'shop_product_id' => array('name')));

        $this->_putInMain('/main/_shop/car/entry');
    }

    public function action_exit() {
        $this->_sitePageData->url = '/weighted/shopdefectcar/exit';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/car/list/exit',
            )
        );

        // перемещение
        $moveCarIDs = Request_Request::find('DB_Ab1_Shop_Move_Car', $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB,
            array('shop_turn_id' => array('value' => array(Model_Ab1_Shop_Turn::TURN_WEIGHTED_EXIT, Model_Ab1_Shop_Turn::TURN_CASH_EXIT)),
                'is_exit' => 0, 'sort_by' => array('value' => array('updated_at' => 'asc'))),
            0, TRUE, array('shop_client_id' => array('name'), 'shop_product_id' => array('name')));
        foreach ($moveCarIDs->childs as $child){
            $child->values['type'] = Model_Ab1_Shop_Move_Car::TABLE_ID;
        }

        // перемещение
        $defectCarIDs = Request_Request::find('DB_Ab1_Shop_Defect_Car', $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB,
            array('shop_turn_id' => array('value' => array(Model_Ab1_Shop_Turn::TURN_WEIGHTED_EXIT, Model_Ab1_Shop_Turn::TURN_CASH_EXIT)),
                'is_exit' => 0, 'sort_by' => array('value' => array('updated_at' => 'asc'))),
            0, TRUE, array('shop_client_id' => array('name'), 'shop_product_id' => array('name')));
        foreach ($defectCarIDs->childs as $child){
            $child->values['type'] = Model_Ab1_Shop_Defect_Car::TABLE_ID;
        }

        // реализация
        $carIDs = Request_Request::find('DB_Ab1_Shop_Car', $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB,
            array('shop_turn_id' => array('value' => array(Model_Ab1_Shop_Turn::TURN_WEIGHTED_EXIT, Model_Ab1_Shop_Turn::TURN_CASH_EXIT)),
                'is_exit' => 0, 'sort_by' => array('value' => array('updated_at' => 'asc'))),
            0, TRUE, array('shop_client_id' => array('name'), 'shop_product_id' => array('name')));
        foreach ($carIDs->childs as $child){
            $child->values['type'] = Model_Ab1_Shop_Car::TABLE_ID;
        }

        $ids = new MyArray();
        $ids->childs = array_merge($carIDs->childs, $moveCarIDs->childs, $defectCarIDs->childs);
        $this->_sitePageData->countRecord = count($ids->childs);
        $this->_sitePageData->limitPage = $this->_sitePageData->countRecord;

        $this->_sitePageData->replaceDatas['view::_shop/car/list/exit'] = Helpers_View::getViewObjects($ids, new Model_Ab1_Shop_Car(),
            '_shop/car/list/exit', '_shop/car/one/exit', $this->_sitePageData, $this->_driverDB, TRUE,
            array('shop_client_id' => array('name'), 'shop_product_id' => array('name')));

        $this->_putInMain('/main/_shop/car/exit');
    }

    public function action_exit_empty() {
        $this->_sitePageData->url = '/weighted/shopdefectcar/exit_empty';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/car/list/exit-empty',
            )
        );

        // перемещение
        $moveCarIDs = Request_Request::find('DB_Ab1_Shop_Move_Car', $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB,
            array('shop_turn_id' => array('value' => array(Model_Ab1_Shop_Turn::TURN_WEIGHTED_EXIT, Model_Ab1_Shop_Turn::TURN_ASU, Model_Ab1_Shop_Turn::TURN_CASH_EXIT)),
                'is_exit' => 0, 'sort_by' => array('value' => array('updated_at' => 'asc'))),
            0, TRUE, array('shop_client_id' => array('name'), 'shop_product_id' => array('name')));
        foreach ($moveCarIDs->childs as $child){
            $child->values['type'] = Model_Ab1_Shop_Move_Car::TABLE_ID;
        }

        // перемещение
        $defectCarIDs = Request_Request::find('DB_Ab1_Shop_Defect_Car', $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB,
            array('shop_turn_id' => array('value' => array(Model_Ab1_Shop_Turn::TURN_WEIGHTED_EXIT, Model_Ab1_Shop_Turn::TURN_ASU, Model_Ab1_Shop_Turn::TURN_CASH_EXIT)),
                'is_exit' => 0, 'sort_by' => array('value' => array('updated_at' => 'asc'))),
            0, TRUE, array('shop_client_id' => array('name'), 'shop_product_id' => array('name')));
        foreach ($defectCarIDs->childs as $child){
            $child->values['type'] = Model_Ab1_Shop_Defect_Car::TABLE_ID;
        }

        // реализация
        $carIDs = Request_Request::find('DB_Ab1_Shop_Car', $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB,
            array('shop_turn_id' => array('value' => array(Model_Ab1_Shop_Turn::TURN_WEIGHTED_EXIT, Model_Ab1_Shop_Turn::TURN_ASU, Model_Ab1_Shop_Turn::TURN_CASH_EXIT)),
                'is_exit' => 0, 'sort_by' => array('value' => array('updated_at' => 'asc'))),
            0, TRUE, array('shop_client_id' => array('name'), 'shop_product_id' => array('name')));
        foreach ($carIDs->childs as $child){
            $child->values['type'] = Model_Ab1_Shop_Car::TABLE_ID;
        }

        $ids = new MyArray();
        $ids->childs = array_merge($carIDs->childs, $moveCarIDs->childs, $defectCarIDs->childs);
        $this->_sitePageData->countRecord = count($ids->childs);
        $this->_sitePageData->limitPage = $this->_sitePageData->countRecord;

        $this->_sitePageData->replaceDatas['view::_shop/car/list/exit-empty'] = Helpers_View::getViewObjects($ids, new Model_Ab1_Shop_Car(),
            '_shop/car/list/exit-empty', '_shop/car/one/exit-empty', $this->_sitePageData, $this->_driverDB, TRUE,
            array('shop_client_id' => array('name'), 'shop_product_id' => array('name')));

        $this->_putInMain('/main/_shop/car/exit-empty');
    }

    public function action_new()
    {
        $this->_sitePageData->url = '/weighted/shopdefectcar/new';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/defect/car/one/new',
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

        $this->_requestShopClients(null, Model_Ab1_ClientType::CLIENT_TYPE_LESSEE);

        $dataID = new MyArray();
        $dataID->id = 0;
        $dataID->isFindDB = TRUE;

        $this->_sitePageData->replaceDatas['view::_shop/defect/car/one/new'] = Helpers_View::getViewObject(
            $dataID, new Model_Ab1_Shop_Defect_Car(),
            '_shop/defect/car/one/new', $this->_sitePageData, $this->_driverDB
        );

        $this->_putInMain('/main/_shop/defect/car/new');
    }

    public function action_edit()
    {
        $this->_sitePageData->url = '/weighted/shopdefectcar/edit';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/defect/car/one/edit',
            )
        );

        // id записи
        $shopCarID = Request_RequestParams::getParamInt('id');
        $model = new Model_Ab1_Shop_Defect_Car();
        if (! $this->dublicateObjectLanguage($model, $shopCarID, -1, false)) {
            throw new HTTP_Exception_404('Car not is found!');
        }

        // основная продукция
        $this->_requestShopProducts(
            $model->getShopProductID(), 0, NULL, FALSE,
            [
                Model_Ab1_ProductView::PRODUCT_TYPE_CAR,
                Model_Ab1_ProductView::PRODUCT_TYPE_CAR_AND_PIECE,
                Model_Ab1_ProductView::PRODUCT_TYPE_PIECE
            ]
        );

        // получаем данные
        $result = View_View::findOne(
            'DB_Ab1_Shop_Defect_Car', $this->_sitePageData->shopID, "_shop/defect/car/one/edit",
            $this->_sitePageData, $this->_driverDB, array('id' => $shopCarID),
            array('shop_payment_id', 'shop_client_id', 'shop_product_id', 'shop_driver_id')
        );

        $this->response->body($this->_sitePageData->replaceStaticDatas($result));
        // $this->_putInMain('/main/_shop/car/edit');
    }

    public function action_get_images()
    {
        $this->_sitePageData->url = '/weighted/shopdefectcar/get_images';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/car/one/images',
            )
        );

        // id записи
        $shopCarID = Request_RequestParams::getParamInt('id');
        $model = new Model_Ab1_Shop_Defect_Car();
        if (! $this->dublicateObjectLanguage($model, $shopCarID, -1, false)) {
            throw new HTTP_Exception_404('Car not is found!');
        }

        // получаем данные
        $result = View_View::findOne('DB_Ab1_Shop_Car', $this->_sitePageData->shopID, "_shop/defect/car/one/images",
            $this->_sitePageData, $this->_driverDB, array('id' => $shopCarID));

        $this->response->body($this->_sitePageData->replaceStaticDatas($result));
    }

    public function action_get()
    {
        $this->_sitePageData->url = '/weighted/shopdefectcar/get';

        // id записи
        $shopCarID = Request_RequestParams::getParamInt('id');
        $model = new Model_Ab1_Shop_Defect_Car();
        if (! $this->dublicateObjectLanguage($model, $shopCarID, -1, false)) {
            throw new HTTP_Exception_404('Car not is found!');
        }
        $model->dbGetElements($this->_sitePageData->shopID, array('shop_payment_id', 'shop_turn_id', 'shop_driver_id', 'shop_product_id', 'shop_client_id'));

        $this->response->body(json_encode($model->getValues(TRUE, TRUE)));
    }

    public function action_save()
    {
        $this->_sitePageData->url = '/weighted/shopdefectcar/save';
        $result = Api_Ab1_Shop_Defect_Car::save($this->_sitePageData, $this->_driverDB);

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
            }elseif(Request_RequestParams::getParamBoolean('is_close') == FALSE){
                $this->redirect('/weighted/shopdefectcar/edit'
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

    public function action_send_tarra()
    {
        $this->_sitePageData->url = '/weighted/shopdefectcar/send_tarra';

        // id записи
        if (Request_RequestParams::getParamFloat('is_save')){
            $result = Api_Ab1_Shop_Defect_Car::save($this->_sitePageData, $this->_driverDB);
            $shopCarID = $result['id'];
        }else {
            $shopCarID = Request_RequestParams::getParamInt('id');
        }

        $model = new Model_Ab1_Shop_Defect_Car();
        if (! $this->dublicateObjectLanguage($model, $shopCarID, -1, false)) {
            throw new HTTP_Exception_404('Car not is found!');
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
                $file->saveFiles($files, $model, $this->_sitePageData, $this->_driverDB, TRUE);

                $this->saveDBObject($model);
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
        $this->_sitePageData->url = '/weighted/shopdefectcar/send_brutto';

        // id записи
        $shopCarID = Request_RequestParams::getParamInt('id');
        $model = new Model_Ab1_Shop_Defect_Car();
        if (! $this->dublicateObjectLanguage($model, $shopCarID, -1, false)) {
            throw new HTTP_Exception_404('Car not is found!');
        }

        $isError = FALSE;
        $brutto = Request_RequestParams::getParamFloat('brutto');
        $isEmpty = Request_RequestParams::getParamBoolean('is_empty');
        if ($isEmpty){
            $weight = abs($brutto - $model->getTarra());
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

        // убираем вес упаковки
        $packedCount = intval(Request_RequestParams::getParamInt('packed_count'));
        if ($packedCount > 0){
            $model->setPackedCount($packedCount);

            $modelProduct = new Model_Ab1_Shop_Product();
            if (!$this->getDBObject($modelProduct, $model->getShopProductID())) {
                throw new HTTP_Exception_404('Product not is found!');
            }
            $model->setPackedQuantity($modelProduct->getTare() * $packedCount);
        }else{
            $model->setPackedCount(0);
            $model->setPackedQuantity(0);
        }
        $weight = $weight - $model->getPackedQuantity();
        if ($weight < 0){
            $this->response->body(
                Json::json_encode(
                    array(
                        'error' => 2,
                        'msg' => 'Итоговый вес не может быть отрицательным "'.($weight).'" задан не верно.',
                    )
                )
            );
            $isError = TRUE;
            exit;
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

            $model->setQuantity($weight);
            $model->setWeightedExitOperationID($this->_sitePageData->operationID);
            $model->setWeightedExitAt(date('Y-m-d H:i:s'));
            $model->setShopTurnID(Model_Ab1_Shop_Turn::TURN_EXIT);
            $model->setIsExit(TRUE);

            Request_RequestParams::setParamInt("shop_transport_company_id", $model);

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
            Api_Ab1_Shop_Register_Material::saveShopDefectCar($model, $this->_sitePageData, $this->_driverDB);

            $this->response->body(
                Json::json_encode(
                    array(
                        'error' => 0,
                        'is_exit' => TRUE,
                        'amount' => 0,
                        'amount_str' => Func::getPriceStr($this->_sitePageData->currency, abs(0), TRUE, FALSE),
                    )
                )
            );
        }
    }
}
