<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_Bid_ShopCar extends Controller_Ab1_Bid_BasicAb1 {

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
            self::redirect('/bid/shoppiece/index');
        }

        $this->_sitePageData->url = '/bid/shopcar/index';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/car/list/index',
            )
        );

        // основная продукция
        $this->_requestShopProducts(
            NULL, 0, NULL, FALSE,
            [
                Model_Ab1_ProductView::PRODUCT_TYPE_CAR,
                Model_Ab1_ProductView::PRODUCT_TYPE_CAR_AND_PIECE,
            ]
        );

        if($this->_sitePageData->operation->getIsAdmin()) {
            $this->_requestShopOperations(Model_Ab1_Shop_Operation::RUBRIC_CASH);
        }

        // получаем список
        View_View::find('DB_Ab1_Shop_Car', $this->_sitePageData->shopID, "_shop/car/list/index", "_shop/car/one/index",
            $this->_sitePageData, $this->_driverDB, array('limit' => 1000, 'limit_page' => 25, 'is_exit' => 0),
            array('shop_client_id' => array('name', 'amount', 'balance_cache', 'balance'), 'shop_client_attorney_id' => array('name', 'amount', 'block_amount', 'balance'),
                'shop_product_id' => array('name'), 'shop_driver_id' => array('name'), 'shop_turn_id' => array('name')));

        $this->_putInMain('/main/_shop/car/index');
    }

    public function action_asu() {
        $this->_sitePageData->url = '/bid/shopcar/asu';
        $this->_requestShopBranches(null, true);
        $this->_actionASU();
    }

    public function action_asu_cars() {
        $this->_sitePageData->url = '/bid/shopcar/asu_cars';
        $this->_actionASUCars();
    }
}
