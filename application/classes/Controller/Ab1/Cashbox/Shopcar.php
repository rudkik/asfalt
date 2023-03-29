<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_Cashbox_ShopCar extends Controller_Ab1_Cashbox_BasicAb1 {

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
        if($this->_sitePageData->operation->getShopTableUnitID()){
            self::redirect('/cashbox/shoppiece/index');
        }

        $this->_sitePageData->url = '/cashbox/shopcar/index';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/car/list/index',
            )
        );

        $this->_requestShopProducts();

        if($this->_sitePageData->operation->getIsAdmin()) {
            $this->_requestShopOperations(Model_Ab1_Shop_Operation::RUBRIC_CASHBOX);
        }

        // получаем список
        View_View::find('DB_Ab1_Shop_Car',
            $this->_sitePageData->shopID, "_shop/car/list/index", "_shop/car/one/index",
            $this->_sitePageData, $this->_driverDB,
            array('limit' => 1000, 'limit_page' => 25, 'is_exit' => 0),
            array(
                'shop_client_id' => array('name', 'amount', 'block_amount', 'amount_cash', 'block_amount_cash'),
                'shop_client_attorney_id' => array('name', 'amount', 'block_amount'),
                'shop_product_id' => array('name'),
                'shop_driver_id' => array('name'),
                'shop_turn_id' => array('name')
            )
        );

        $this->_putInMain('/main/_shop/car/index');
    }

    public function action_history() {
        $this->_sitePageData->url = '/cashbox/shopcar/history';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/car/list/history',
            )
        );

        $this->_requestShopProducts();

        if($this->_sitePageData->operation->getIsAdmin()) {
            $this->_requestShopOperations(Model_Ab1_Shop_Operation::RUBRIC_CASHBOX);

            // получаем список
            View_View::find('DB_Ab1_Shop_Car', $this->_sitePageData->shopID, "_shop/car/list/history", "_shop/car/one/history",
                $this->_sitePageData, $this->_driverDB, array('limit_page' => 25, 'is_exit' => 1, 'limit' => 1000,),
                array('shop_client_id' => array('name'), 'shop_product_id' => array('name'), 'shop_driver_id' => array('name'),
                    'cash_operation_id' => array('name'), 'shop_turn_place_id' => array('name')));
        }else{
            // получаем список
            View_View::find('DB_Ab1_Shop_Car', $this->_sitePageData->shopID, "_shop/car/list/history", "_shop/car/one/history",
                $this->_sitePageData, $this->_driverDB, array('limit_page' => 25, 'is_exit' => 1, 'limit' => 1000,),
                array('shop_client_id' => array('name'), 'shop_product_id' => array('name'), 'shop_driver_id' => array('name'),
                    'cash_operation_id' => array('name'), 'shop_turn_place_id' => array('name')));
        }

        $this->_putInMain('/main/_shop/car/history');
    }

    public function action_new()
    {
        $this->_sitePageData->url = '/cashbox/shopcar/new';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/car/one/new',
            )
        );

        $this->_requestShopProducts();
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
        $this->_sitePageData->url = '/cashbox/shopcar/edit';
        $this->_actionShopCarEdit();
    }

    public function action_save()
    {
        $this->_sitePageData->url = '/cashbox/shopcar/save';

        $result = Api_Ab1_Shop_Car::save($this->_sitePageData, $this->_driverDB);

        if (Request_RequestParams::getParamBoolean('json') || $result['result']['error']) {
            $this->response->body(Json::json_encode($result['result']));
        } else {
            $branchID = '';
            if($this->_sitePageData->branchID > 0){
                $branchID = '&shop_branch_id='.$this->_sitePageData->branchID;
            }

            if(Request_RequestParams::getParamBoolean('is_close') === FALSE){
                $this->redirect('/cashbox/shopcar/edit'
                    . URL::query(
                        array(
                            'id' => $result['id'],
                        ),
                        FALSE
                    )
                    .$branchID
                );
            }else {
                $this->redirect('/cashbox/shopcar/index'
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
        $this->_sitePageData->url = '/cashbox/shopcar/del';
        $result = Api_Ab1_Shop_Car::delete($this->_sitePageData, $this->_driverDB);
        $this->response->body(Json::json_encode(array('error' => $result)));
    }
}
