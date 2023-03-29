<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_Asu_ShopMoveCar extends Controller_Ab1_Asu_BasicAb1 {

    public function __construct(Request $request, Response $response)
    {
        $this->dbObject = 'DB_Ab1_Shop_Move_Car';
        $this->controllerName = 'shopmovecar';
        $this->tableID = Model_Ab1_Shop_Move_Car::TABLE_ID;
        $this->tableName = Model_Ab1_Shop_Move_Car::TABLE_NAME;
        $this->objectName = 'movecar';

        parent::__construct($request, $response);
    }

    public function action_index() {
        $this->_sitePageData->url = '/asu/shopmovecar/index';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/move/car/list/index',
            )
        );

        $params = array(
            'is_exit' => 1,

            'sum_quantity' => TRUE,
        );

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
            [
                Model_Ab1_ProductView::PRODUCT_TYPE_CAR,
                Model_Ab1_ProductView::PRODUCT_TYPE_CAR_AND_PIECE,
                Model_Ab1_ProductView::PRODUCT_TYPE_PIECE
            ]
        );

        $params = array(
            'is_exit' => 1,
            'limit' => 1000,
            'limit_page' => 25,
        );
        if(!$this->_sitePageData->operation->getIsAdmin()){
            $params['shop_turn_place_id'] = $this->_sitePageData->operation->getShopTableSelectID();
        }

        if($this->_sitePageData->operation->getIsAdmin()) {
            $this->_requestShopOperations(Model_Ab1_Shop_Operation::RUBRIC_ASU);

            // получаем список
            View_View::find('DB_Ab1_Shop_Move_Car', $this->_sitePageData->shopID, "_shop/move/car/list/index", "_shop/move/car/one/index",
                $this->_sitePageData, $this->_driverDB, $params,
                array('shop_client_id' => array('name'), 'shop_product_id' => array('name'), 'shop_driver_id' => array('name'), 'asu_operation_id' => array('name')));
        }else{
            // получаем список
            View_View::find('DB_Ab1_Shop_Move_Car', $this->_sitePageData->shopID, "_shop/move/car/list/index", "_shop/move/car/one/index",
                $this->_sitePageData, $this->_driverDB, $params,
                array('shop_client_id' => array('name'), 'shop_product_id' => array('name'), 'shop_driver_id' => array('name')));
        }

        $this->_putInMain('/main/_shop/move/car/index');
    }

    public function action_shipment() {
        $this->_sitePageData->url = '/asu/shopmovecar/shipment';

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
            $params, 0, TRUE, array('shop_product_id' => array('name')));
        foreach ($defectCarIDs->childs as $child){
            $child->values['type'] = Model_Ab1_Shop_Defect_Car::TABLE_ID;
        }

        // реализация
        $carIDs = Request_Request::find('DB_Ab1_Shop_Car', $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB,
            $params, 0, TRUE, array('shop_product_id' => array('name')));
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

        $this->_putInMain('/main/_shop/car/shipment');
    }

    public function action_shipment_json() {
        $this->_sitePageData->url = '/asu/shopmovecar/shipment_json';

        $params = array(
            'is_exit' => 0,
            'shop_turn_id' => Model_Ab1_Shop_Turn::TURN_ASU,

            'sort_by' => array('value' => array('weighted_entry_at' => 'desc'))
        );

        $ids = Request_Request::find('DB_Ab1_Shop_Car', $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB, $params,
            1, TRUE);

        $result = array(
            'is_record' => count($ids->childs) > 0,
        );
        if (count($ids->childs) > 0) {
            $result['number'] = $ids->childs[0]->values['name'];
        }
        $this->response->body(json_encode($result));
    }

    public function action_save()
    {
        $this->_sitePageData->url = '/asu/shopmovecar/save';

        $result = Api_Ab1_Shop_Move_Car::save($this->_sitePageData, $this->_driverDB);

        if (Request_RequestParams::getParamBoolean('json') || $result['result']['error']) {
            $this->response->body(Json::json_encode($result['result']));
        } else {
            $branchID = '';
            if($this->_sitePageData->branchID > 0){
                $branchID = '&shop_branch_id='.$this->_sitePageData->branchID;
            }

            if(Request_RequestParams::getParamBoolean('is_close') === FALSE){
                $this->redirect('/asu/shopmovecar/edit'
                    . URL::query(
                        array(
                            'id' => $result['id'],
                        ),
                        FALSE
                    )
                    .$branchID
                );
            }else {
                $this->redirect('/asu/shopmovecar/index'
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
