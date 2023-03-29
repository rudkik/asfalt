<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_Abc_ShopLesseeCar extends Controller_Ab1_Abc_BasicAb1 {

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
        $this->_sitePageData->url = '/abc/shoplesseecar/index';

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

        if($this->_sitePageData->operation->getIsAdmin()) {
            $this->_requestShopOperations(Model_Ab1_Shop_Operation::RUBRIC_CASH);
        }

        // получаем список
        View_View::find(
            'DB_Ab1_Shop_Lessee_Car', $this->_sitePageData->shopID,
            "_shop/lessee/car/list/index", "_shop/lessee/car/one/index",
            $this->_sitePageData, $this->_driverDB,
            array(
                'limit' => 1000,
                'limit_page' => 25
            ),
            array(
                'shop_client_id' => array('name'),
                'shop_product_id' => array('name'),
                'shop_driver_id' => array('name'),
                'shop_delivery_id' => array('name'),
                'shop_turn_id' => array('name'),
                'cash_operation_id' => array('name'),
                'shop_formula_product_id' => array('name'),
            )
        );

        $this->_putInMain('/main/_shop/lessee/car/index');
    }

    public function action_edit()
    {
        $this->_sitePageData->url = '/abc/shoplesseecar/edit';
        $this->_actionLesseeCarEdit();
    }
}
