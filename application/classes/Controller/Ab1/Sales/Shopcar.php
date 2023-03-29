<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_Sales_ShopCar extends Controller_Ab1_Sales_BasicAb1 {

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
        self::redirect('/sales/shopcar/history'.URL::query());
    }

    public function action_history() {
        $this->_sitePageData->url = '/sales/shopcar/history';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/car/list/history',
            )
        );

        $this->_requestShopProducts();
        $this->_requestShopBranches();

        if($this->_sitePageData->operation->getIsAdmin()) {
            $this->_requestShopOperations(Model_Ab1_Shop_Operation::RUBRIC_CASH);

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


    public function action_territory() {
        $this->_sitePageData->url = '/sales/shopcar/territory';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/car/list/territory',
            )
        );

        // получаем список
        View_View::find('DB_Ab1_Shop_Car', $this->_sitePageData->shopID,
            "_shop/car/list/territory", "_shop/car/one/territory",
            $this->_sitePageData, $this->_driverDB,
            array('limit_page' => 25, 'is_exit' => 0),
            array(
                'shop_client_id' => array('name', 'amount', 'balance_cache', 'balance'),
                'shop_client_attorney_id' => array('name', 'amount', 'block_amount', 'balance'),
                'shop_product_id' => array('name'), '
                shop_driver_id' => array('name'),
                'shop_turn_id' => array('name')
            )
        );

        $this->_putInMain('/main/_shop/car/territory');
    }

    public function action_asu() {
        $this->_sitePageData->url = '/sales/shopcar/asu';
        $this->_requestShopBranches(null, true);
        $this->_actionASU();
    }

    public function action_asu_cars() {
        $this->_sitePageData->url = '/sales/shopcar/asu_cars';
        $this->_actionASUCars();
    }

    public function action_edit()
    {
        $this->_sitePageData->url = '/sales/shopcar/edit';
        $this->_actionShopCarEdit();
    }

    public function action_save()
    {
        $this->_sitePageData->url = '/sales/shopcar/save';

        $result = Api_Ab1_Shop_Car::save($this->_sitePageData, $this->_driverDB);
        $this->_redirectSaveResult($result, '/sales/shopcar/history');
    }

}
