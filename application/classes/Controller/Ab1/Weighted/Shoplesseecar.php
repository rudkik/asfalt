<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_Weighted_ShopLesseeCar extends Controller_Ab1_Weighted_BasicAb1{

    public function __construct(Request $request, Response $response)
    {
        $this->dbObject = 'DB_Ab1_Shop_Lessee_Car';
        $this->controllerName = 'shoplesseecar';
        $this->tableID = Model_Ab1_Shop_Lessee_Car::TABLE_ID;
        $this->tableName = Model_Ab1_Shop_Lessee_Car::TABLE_NAME;
        $this->objectName = 'lesseecar';

        parent::__construct($request, $response);
    }

    public function action_index() {
        $this->_sitePageData->url = '/weighted/shoplesseecar/index';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/lessee/car/list/index',
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
        $this->_requestShopOperations(Model_Ab1_Shop_Operation::RUBRIC_WEIGHT);
        $this->_requestShopTurnPlaces();

        // получаем список
        View_View::find('DB_Ab1_Shop_Lessee_Car',
            $this->_sitePageData->shopID, "_shop/lessee/car/list/index", "_shop/lessee/car/one/index",
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

        $this->_putInMain('/main/_shop/lessee/car/index');
    }

    public function action_new()
    {
        $this->_sitePageData->url = '/weighted/shoplesseecar/new';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/lessee/car/one/new',
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

        $this->_sitePageData->replaceDatas['view::_shop/lessee/car/one/new'] = Helpers_View::getViewObject(
            $dataID, new Model_Ab1_Shop_Lessee_Car(),
            '_shop/lessee/car/one/new', $this->_sitePageData, $this->_driverDB
        );

        $this->_putInMain('/main/_shop/lessee/car/new');
    }

    public function action_edit()
    {
        $this->_sitePageData->url = '/weighted/shoplesseecar/edit';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/lessee/car/one/edit',
            )
        );

        // id записи
        $id = Request_RequestParams::getParamInt('id');
        $model = new Model_Ab1_Shop_Lessee_Car();
        if (! $this->dublicateObjectLanguage($model, $id, -1, false)) {
            throw new HTTP_Exception_404('Car not is found!');
        }

        // основная продукция
        $this->_requestShopProducts(
            $model->getShopProductID(), 0, NULL, FALSE,
            [
                Model_Ab1_ProductView::PRODUCT_TYPE_CAR,
                Model_Ab1_ProductView::PRODUCT_TYPE_CAR_AND_PIECE,
            ]
        );
        $this->_requestShopClients($model->getShopClientID(), Model_Ab1_ClientType::CLIENT_TYPE_LESSEE);

        // получаем данные
        $result = View_View::findOne('DB_Ab1_Shop_Lessee_Car',
            $this->_sitePageData->shopID, "_shop/lessee/car/one/edit",
            $this->_sitePageData, $this->_driverDB, array('id' => $id),
            array('shop_client_id', 'shop_product_id', 'shop_driver_id'));

        $this->response->body($this->_sitePageData->replaceStaticDatas($result));
       // $this->_putInMain('/main/_shop/lessee/car/edit');
    }

    public function action_get_images()
    {
        $this->_sitePageData->url = '/weighted/shoplesseecar/get_images';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/lessee/car/one/images',
            )
        );

        // id записи
        $id = Request_RequestParams::getParamInt('id');
        $model = new Model_Ab1_Shop_Lessee_Car();
        if (! $this->dublicateObjectLanguage($model, $id, -1, false)) {
            throw new HTTP_Exception_404('Car not is found!');
        }

        // получаем данные
        $result = View_View::find('DB_Ab1_Shop_Lessee_Car',
            $this->_sitePageData->shopID, "_shop/lessee/car/one/images",
            $this->_sitePageData, $this->_driverDB, array('id' => $id)
        );

        $this->response->body($this->_sitePageData->replaceStaticDatas($result));
    }

    public function action_get()
    {
        $this->_sitePageData->url = '/weighted/shoplesseecar/get';

        // id записи
        $id = Request_RequestParams::getParamInt('id');
        $model = new Model_Ab1_Shop_Lessee_Car();
        if (! $this->dublicateObjectLanguage($model, $id, -1, false)) {
            throw new HTTP_Exception_404('Car not is found!');
        }

        $model->dbGetElements($this->_sitePageData->shopID,
            array('shop_turn_id', 'shop_driver_id', 'shop_product_id', 'shop_client_id'));

        $this->response->body(json_encode($model->getValues(TRUE, TRUE)));
    }

    public function action_save()
    {
        $this->_sitePageData->url = '/weighted/shoplesseecar/save';

        $result = Api_Ab1_Shop_Lessee_Car::save($this->_sitePageData, $this->_driverDB);

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
                $this->redirect('/weighted/shoplesseecar/edit'
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
        $this->_sitePageData->url = '/weighted/shoplesseecar/del';
        $result = Api_Ab1_Shop_Lessee_Car::delete($this->_sitePageData, $this->_driverDB);
        $this->response->body(Json::json_encode(array('error' => $result)));
    }

    public function action_send_tarra()
    {
        $this->_sitePageData->url = '/weighted/shoplesseecar/send_tarra';

        // id записи
        if (Request_RequestParams::getParamFloat('is_save')){
            $result = Api_Ab1_Shop_Lessee_Car::save($this->_sitePageData, $this->_driverDB);
            $shopCarID = $result['id'];
        }else {
            $shopCarID = Request_RequestParams::getParamInt('id');
        }

        $model = new Model_Ab1_Shop_Lessee_Car();
        if (!$this->dublicateObjectLanguage($model, $shopCarID, NULL, FALSE)) {
            if (intval($shopCarID) < 1) {
                throw new HTTP_Exception_404('Car not is found!');
            }

            self::redirect('/weighted/shopmovecar/send_tarra'.URL::query());
            exit;
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
        $this->_sitePageData->url = '/weighted/shoplesseecar/send_brutto';

        // id записи
        $shopCarID = Request_RequestParams::getParamInt('id');
        $model = new Model_Ab1_Shop_Lessee_Car();
        if (! $this->dublicateObjectLanguage($model, $shopCarID, -1, false)) {
            throw new HTTP_Exception_404('Car lessee not is found!');
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
            $model->setAmount($model->getPrice() * $model->getQuantity());

            $params = Request_RequestParams::setParams(
                array(
                    'shop_lessee_car_id' => $model->id,
                )
            );

            // список товаров
            $items = Request_Request::find('DB_Ab1_Shop_Lessee_Car_Item',
                $model->shopID, $this->_sitePageData,$this->_driverDB, $params, 0, TRUE
            );
            if(count($items->childs) == 1){
                $modelItem = new Model_Ab1_Shop_Lessee_Car_Item();
                $modelItem->setDBDriver($this->_driverDB);
                $items->childs[0]->setModel($modelItem);
                $modelItem->setQuantity($model->getQuantity());
                $modelItem->setAmount($model->getQuantity() * $modelItem->getPrice());
                Helpers_DB::saveDBObject($modelItem, $this->_sitePageData, $model->shopID);
            }

            $model->setWeightedExitOperationID($this->_sitePageData->operationID);
            $model->setWeightedExitAt(date('Y-m-d H:i:s'));

            // узнаем можно ли выпустить
            $model->setShopTurnID(Model_Ab1_Shop_Turn::TURN_EXIT);
            $model->setIsExit(true);

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

            $this->response->body(
                Json::json_encode(
                    array(
                        'error' => 0,
                        'is_exit' => true,
                        'amount' => $model->getAmount(),
                        'amount_str' => Func::getPriceStr($this->_sitePageData->currency, abs($model->getAmount()), TRUE, FALSE),
                    )
                )
            );
        }
    }
}
