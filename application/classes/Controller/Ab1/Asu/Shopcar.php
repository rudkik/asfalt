<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_Asu_ShopCar extends Controller_Ab1_Asu_BasicAb1 {

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
        $this->_sitePageData->url = '/asu/shopcar/index';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/car/list/index',
            )
        );

        $params = array(
            'is_exit' => 1,
            'sum_quantity' => TRUE,

        );
        if(!$this->_sitePageData->operation->getIsAdmin()){
            $params['shop_turn_place_id'] = $this->_sitePageData->operation->getShopTableSelectID();
        }

        // считаем сумму
        if(Request_RequestParams::getParamBoolean('is_sum')){
            $sum = Request_Request::find('DB_Ab1_Shop_Car', $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB,
                    $params)->childs[0]->values['quantity']
                + Request_Request::find('DB_Ab1_Shop_Move_Car', $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB,
                    $params)->childs[0]->values['quantity']
                + Request_Request::find('DB_Ab1_Shop_Defect_Car', $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB,
                    $params)->childs[0]->values['quantity'];
        }else{
            $sum = '';
        }
        $this->_sitePageData->addReplaceAndGlobalDatas('view::car_sum', $sum);

        // основная продукция
        $this->_requestShopProducts(
            NULL, 0, NULL, FALSE,
            [Model_Ab1_ProductView::PRODUCT_TYPE_CAR, Model_Ab1_ProductView::PRODUCT_TYPE_PIECE]
        );

        $params = array(
            'is_exit' => 1,
            'limit' => 1000,
            'limit_page' => 25,
        );
        if(!$this->_sitePageData->operation->getIsAdmin()){
            $params['shop_turn_place_id'] = $this->_sitePageData->operation->getShopTableSelectID();
            $params['asu_operation_id'] = $this->_sitePageData->operationID;
        }

        if($this->_sitePageData->operation->getIsAdmin()) {
            $this->_requestShopOperations(Model_Ab1_Shop_Operation::RUBRIC_ASU);

            // получаем список
            View_View::find('DB_Ab1_Shop_Car', $this->_sitePageData->shopID, "_shop/car/list/index", "_shop/car/one/index",
                $this->_sitePageData, $this->_driverDB, $params,
                array('shop_client_id' => array('name'), 'shop_product_id' => array('name'), 'shop_driver_id' => array('name'), 'asu_operation_id' => array('name')));
        }else{
            // получаем список
            View_View::find('DB_Ab1_Shop_Car', $this->_sitePageData->shopID, "_shop/car/list/index", "_shop/car/one/index",
                $this->_sitePageData, $this->_driverDB, $params,
                array('shop_client_id' => array('name'), 'shop_product_id' => array('name'), 'shop_driver_id' => array('name')));
        }

        $this->_putInMain('/main/_shop/car/index');
    }

    public function action_shipment() {
        $this->_sitePageData->url = '/asu/shopcar/shipment';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/car/list/shipment',
                'view::_shop/turn/place/list/transfer',
            )
        );

        $params = array(
            'is_exit' => 0,
            'limit_page' => 25,
            'shop_turn_id' => Model_Ab1_Shop_Turn::TURN_ASU,

            'sort_by' => array(
                'weighted_entry_at' => 'asc'
            ),
        );
        if(!$this->_sitePageData->operation->getIsAdmin()){
            $params['shop_turn_place_id'] = $this->_sitePageData->operation->getShopTableSelectID();
        }

        View_View::find('DB_Ab1_Shop_Turn_Place', $this->_sitePageData->shopID, "_shop/turn/place/list/transfer",
            "_shop/turn/place/one/transfer", $this->_sitePageData, $this->_driverDB,
            array(Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE,
                'sort_by' => array('value'=> array('name' => 'asc'))));

        // перемещение
        $moveCarIDs = Request_Request::find('DB_Ab1_Shop_Move_Car', $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB,
            $params, 0, TRUE, array('shop_product_id' => array('name')));
        foreach ($moveCarIDs->childs as $child){
            $child->values['type'] = Model_Ab1_Shop_Move_Car::TABLE_ID;
        }

        // брак
        $defectCarIDs = Request_Request::find('DB_Ab1_Shop_Defect_Car', $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB,
            $params, 0, TRUE, array('shop_product_id' => array('name'), 'shop_client_id' => array('name')));
        foreach ($defectCarIDs->childs as $child){
            $child->values['type'] = Model_Ab1_Shop_Defect_Car::TABLE_ID;
        }

        // реализация
        $carIDs = Request_Request::find('DB_Ab1_Shop_Car', $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB,
            $params, 0, TRUE, array('shop_product_id' => array('name'), 'shop_client_id' => array('name')));
        foreach ($carIDs->childs as $child){
            $child->values['type'] = Model_Ab1_Shop_Car::TABLE_ID;
        }

        $ids = new MyArray();
        $ids->childs = array_merge($carIDs->childs, $moveCarIDs->childs, $defectCarIDs->childs);
        $this->_sitePageData->countRecord = count($ids->childs);
        $this->_sitePageData->limitPage = $this->_sitePageData->countRecord;

        $this->_sitePageData->replaceDatas['view::_shop/car/list/shipment'] = Helpers_View::getViewObjects($ids, new Model_Ab1_Shop_Car(),
            '_shop/car/list/shipment', '_shop/car/one/shipment', $this->_sitePageData, $this->_driverDB, TRUE,
            array('shop_product_id' => array('name')));

        // количество ток
        $params = array(
            'asu_operation_id' => $this->_sitePageData->operationID,
            'asu_at_from' => date('Y-m-d 00:00:00'),
            'asu_at_to' => date('Y-m-d 23:59:59'),

            Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE,
            'sum_quantity' => TRUE
        );
        $this->_sitePageData->addReplaceAndGlobalDatas('view::car_sum',
            Request_Request::find('DB_Ab1_Shop_Car', $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB,
                $params)->childs[0]->values['quantity']
            + Request_Request::find('DB_Ab1_Shop_Move_Car', $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB,
                $params)->childs[0]->values['quantity']
            + Request_Request::find('DB_Ab1_Shop_Defect_Car', $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB,
                $params)->childs[0]->values['quantity']);

        $this->_putInMain('/main/_shop/car/shipment');
    }

    public function action_shipment_json() {
        $this->_sitePageData->url = '/asu/shopcar/shipment_json';

        $params = array(
            'is_exit' => 0,
            'shop_turn_id' => Model_Ab1_Shop_Turn::TURN_ASU,

            'shop_turn_place_id' => $this->_sitePageData->operation->getShopTableSelectID(),
            'count_id' => TRUE,
        );

        $count = Request_Request::find('DB_Ab1_Shop_Car', $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB,
                $params)->childs[0]->values['count']
            + Request_Request::find('DB_Ab1_Shop_Move_Car', $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB,
                $params)->childs[0]->values['count']
            + Request_Request::find('DB_Ab1_Shop_Defect_Car', $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB,
                $params)->childs[0]->values['count'];

        $result = array(
            'is_record' => $count > 0,
            'number' => $count,
        );
        $this->response->body(json_encode($result));
    }

    public function action_total() {
        $this->_sitePageData->url = '/asu/shopcar/total';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/car/list/total',
            )
        );

        $dateFrom = Request_RequestParams::getParamDate('date_from');
        if(empty($dateFrom)){
            $dateFrom = Helpers_DateTime::getMonthBeginStr(date('m'), date('Y'));
        }
        $dateFrom = $dateFrom . ' 06:00:00';
        $dateTo = Request_RequestParams::getParamDate('date_to');
        if(empty($dateTo)){
            $dateTo = date('Y-m-d');
        }
        $dateTo = Helpers_DateTime::plusDays($dateTo . ' 06:00:00', 1);

        $params = Request_RequestParams::setParams(
            array(
                'asu_operation_id' => $this->_sitePageData->operationID,
                'exit_at_from' => $dateFrom,
                'exit_at_to' => $dateTo,
                'sum_quantity' => TRUE,
                'group_by' => array(
                    'exit_at_date',
                ),
            )
        );
        $ids = Api_Ab1_Shop_Car::getExitShopCar(
            $dateFrom, $dateTo, $this->_sitePageData, $this->_driverDB, array(), $params
        );
        $ids->runIndex(true, 'exit_at_date');

        // перемещение
        $shopMoveCarIDs = Api_Ab1_Shop_Move_Car::getExitShopMoveCar(
            $dateFrom, $dateTo, $this->_sitePageData, $this->_driverDB, array(), $params
        );
        foreach ($shopMoveCarIDs->childs as $child){
            $key = $child->values['exit_at_date'];
            if(!key_exists($key, $ids->childs)){
                $ids->childs[$key] = $child;
            }else{
                $ids->childs[$key]->values['quantity'] += $child->values['quantity'];
            }
        }

        // брак
        $shopDefectCarIDs = Api_Ab1_Shop_Defect_Car::getExitShopDefectCar(
            $dateFrom, $dateTo, $this->_sitePageData, $this->_driverDB, array(), $params
        );
        foreach ($shopDefectCarIDs->childs as $child){
            $key = $child->values['exit_at_date'];
            if(!key_exists($key, $ids->childs)){
                $ids->childs[$key] = $child;
            }else{
                $ids->childs[$key]->values['quantity'] += $child->values['quantity'];
            }
        }

        // ответ хранения
        $shopLesseeCarIDs = Api_Ab1_Shop_Lessee_Car::getExitShopCar(
            $dateFrom, $dateTo, $this->_sitePageData, $this->_driverDB, array(), $params
        );
        foreach ($shopLesseeCarIDs->childs as $child){
            $key = $child->values['exit_at'];
            if(!key_exists($key, $ids->childs)){
                $ids->childs[$key] = $child;
            }else{
                $ids->childs[$key]->values['quantity'] += $child->values['quantity'];
            }
        }

        // Количество произведенного товара на склад
        $params = Request_RequestParams::setParams(
            array(
                'created_at_from' => $dateFrom,
                'created_at_to' => $dateTo,
                'shop_turn_place_id' => $this->_sitePageData->operation->getShopTableSelectID(),
                'sum_quantity' => true,
                'group_by' => array(
                    'created_at_date',
                )
            )
        );

        $shopProductStorageIDs = Request_Request::find('DB_Ab1_Shop_Product_Storage',
            $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB, $params
        );
        foreach ($shopProductStorageIDs->childs as $child){
            $key = $child->values['created_at_date'];
            if(!key_exists($key, $ids->childs)){
                $ids->childs[$key] = $child;
                $ids->childs[$key]->values['exit_at'] = $key;
            }else{
                $ids->childs[$key]->values['quantity'] += $child->values['quantity'];
            }
        }

        $sortBy = Request_RequestParams::getParamArray('sort_by', array(), array('exit_at' => 'desc'));
        $ids->childsSortBy($sortBy, false, true);

        $result = Helpers_View::getViewObjects(
            $ids, new Model_Ab1_Shop_Car(),
            "_shop/car/list/total", "_shop/car/one/total",
            $this->_sitePageData, $this->_driverDB
        );
        $this->_sitePageData->replaceDatas['view::_shop/car/list/total'] = $result;

        $this->_putInMain('/main/_shop/car/total');
    }

    public function action_save()
    {
        $this->_sitePageData->url = '/asu/shopcar/save';

        $result = Api_Ab1_Shop_Car::save($this->_sitePageData, $this->_driverDB);

        if (Request_RequestParams::getParamBoolean('json') || $result['result']['error']) {
            $this->response->body(Json::json_encode($result['result']));
        } else {
            $branchID = '';
            if($this->_sitePageData->branchID > 0){
                $branchID = '&shop_branch_id='.$this->_sitePageData->branchID;
            }

            if(Request_RequestParams::getParamBoolean('is_close') === FALSE){
                $this->redirect('/asu/shopcar/edit'
                    . URL::query(
                        array(
                            'id' => $result['id'],
                        ),
                        FALSE
                    )
                    .$branchID
                );
            }else {
                $this->redirect('/asu/shopcar/index'
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
}
