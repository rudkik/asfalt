<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_General_ShopCar extends Controller_Ab1_General_BasicAb1 {

    public function __construct(Request $request, Response $response)
    {
        $this->dbObject = 'DB_Ab1_Shop_Car';
        $this->controllerName = 'shopcar';
        $this->tableID = Model_Ab1_Shop_Car::TABLE_ID;
        $this->tableName = Model_Ab1_Shop_Car::TABLE_NAME;
        $this->objectName = 'car';

        parent::__construct($request, $response);
    }

    public function action_ttn() {
        $this->_sitePageData->url = '/general/shopcar/ttn';
        $this->_requestShopSubdivisions(null, 0, '');
        $this->_actionShopCarTTN();
    }

    public function action_history() {
        $this->_sitePageData->url = '/general/shopcar/history';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/car/list/history',
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
            $this->_requestShopOperations(Model_Ab1_Shop_Operation::RUBRIC_GENERAL);

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

    public function action_show()
    {
        $this->_sitePageData->url = '/general/shopcar/show';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/car/one/show',
            )
        );

        // id записи
        $id = Request_RequestParams::getParamInt('id');
        $model = new Model_Ab1_Shop_Car();
        if (! $this->dublicateObjectLanguage($model, $id, -1, FALSE)) {
            throw new HTTP_Exception_404('Car not is found!');
        }
        $model->dbGetElements($this->_sitePageData->shopMainID, array('shop_client_id'));

        // основная продукция
        $this->_requestShopProducts(
            NULL, 0, NULL, FALSE,
            [
                Model_Ab1_ProductView::PRODUCT_TYPE_CAR,
                Model_Ab1_ProductView::PRODUCT_TYPE_CAR_AND_PIECE,
            ]
        );
        // дополнительные услуги
        $this->_requestShopProducts(
            NULL, 0, NULL, FALSE,
            Model_Ab1_ProductView::PRODUCT_TYPE_ADDITION_SERVICE, 'addition-service'
        );

        $this->_requestShopClientAttorney($model->getShopClientID());

        // получаем данные
        View_View::findOne('DB_Ab1_Shop_Car', $this->_sitePageData->shopID, "_shop/car/one/show",
            $this->_sitePageData, $this->_driverDB, array('id' => $id),
            array('shop_payment_id', 'shop_client_id', 'shop_client_attorney_id', 'shop_product_id', 'shop_driver_id'));

        $this->_putInMain('/main/_shop/car/show');
    }

    public function action_edit()
    {
        $this->_sitePageData->url = '/general/shopcar/edit';
        $this->_actionShopCarEdit();
    }

    public function action_save()
    {
        $this->_sitePageData->url = '/general/shopcar/save';

        $result = Api_Ab1_Shop_Car::save($this->_sitePageData, $this->_driverDB);
        $this->_redirectSaveResult($result, '/general/shopcar/history');
    }

    public function action_asu() {
        $this->_sitePageData->url = '/general/shopcar/asu';
        $this->_requestShopBranches(null, true);
        $this->_actionASU();
    }

    public function action_asu_cars() {
        $this->_sitePageData->url = '/general/shopcar/asu_cars';
        $this->_actionASUCars();
    }
}
