<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_Sbyt_ShopCar extends Controller_Ab1_Sbyt_BasicAb1 {

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
        self::redirect('/sbyt/shopcar/history'.URL::query());
    }

    public function action_history() {
        $this->_sitePageData->url = '/sbyt/shopcar/history';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/car/list/history',
            )
        );

        $this->_requestShopProducts();

        if($this->_sitePageData->operation->getIsAdmin()) {
            $this->_requestShopOperations(Model_Ab1_Shop_Operation::RUBRIC_SBYT);

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

    public function action_asu() {
        $this->_sitePageData->url = '/sbyt/shopcar/asu';
        $this->_actionASU();

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/car/list/asu',
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

        // реализация
        $params = Request_RequestParams::setParams(
            array(
                'is_exit' => 0,
                'sort_by' => array('shop_turn_place_id.name' => 'asc')
            ),
            false
        );
        $carIDs = Request_Request::find('DB_Ab1_Shop_Car',
            $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB,
            $params, 0, TRUE,
            array(
                'shop_client_id' => array('name'),
                'shop_product_id' => array('name'),
                'shop_driver_id' => array('name'),
                'cash_operation_id' => array('name'),
                'shop_turn_place_id' => array('name')
            )
        );

        $result = Helpers_View::getViewObjects(
            $carIDs, new Model_Ab1_Shop_Car(),
            "_shop/car/list/asu", "_shop/car/one/asu",
            $this->_sitePageData, $this->_driverDB, $this->_sitePageData->shopID,
            TRUE, array('shop_turn_place_id' => array('name'))
        );
        $this->_sitePageData->replaceDatas['view::_shop/car/list/asu'] = $result;

        $this->_putInMain('/main/_shop/car/asu');
    }

    public function action_asu_cars() {
        $this->_sitePageData->url = '/sbyt/shopcar/asu_cars';
        $this->_actionASUCars();
    }

    public function action_edit()
    {
        $this->_sitePageData->url = '/sbyt/shopcar/edit';
        $this->_actionShopCarEdit();
    }

    public function action_save()
    {
        $this->_sitePageData->url = '/sbyt/shopcar/save';

        $result = Api_Ab1_Shop_Car::save($this->_sitePageData, $this->_driverDB);
        $this->_redirectSaveResult($result, '/sbyt/shopcar/history');
    }

}
