<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_Abc_ShopMoveCar extends Controller_Ab1_Abc_BasicAb1 {

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
        $this->_sitePageData->url = '/cash/shopmovecar/index';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/move/car/list/index',
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

        $this->_requestShopMoveClients();
        $this->_requestShopTurnPlaces();

        if($this->_sitePageData->operation->getIsAdmin()) {
            $this->_requestShopOperations(Model_Ab1_Shop_Operation::RUBRIC_CASH);

            // получаем список
            View_View::find(
                'DB_Ab1_Shop_Move_Car', $this->_sitePageData->shopID,
                "_shop/move/car/list/index", "_shop/move/car/one/index",
                $this->_sitePageData, $this->_driverDB,
                array('limit' => 1000, 'limit_page' => 25, 'is_exit' => 1),
                array(
                    'shop_client_id' => array('name'),
                    'shop_product_id' => array('name'),
                    'shop_driver_id' => array('name'),
                    'cash_operation_id' => array('name'),
                    'shop_turn_place_id' => array('name'),
                    'shop_formula_product_id' => array('name'),
                )
            );
        }else{
            // получаем список
            View_View::find(
                'DB_Ab1_Shop_Move_Car', $this->_sitePageData->shopID,
                "_shop/move/car/list/index", "_shop/move/car/one/index",
                $this->_sitePageData, $this->_driverDB,
                array('limit' => 1000, 'limit_page' => 25, 'is_exit' => 1),
                array(
                    'shop_client_id' => array('name'),
                    'shop_product_id' => array('name'),
                    'shop_driver_id' => array('name'),
                    'cash_operation_id' => array('name'),
                    'shop_turn_place_id' => array('name'),
                    'shop_formula_product_id' => array('name'),
                )
            );
        }

        $this->_putInMain('/main/_shop/move/car/index');
    }

    public function action_edit()
    {
        $this->_sitePageData->url = '/abc/shopmovecar/edit';
        $this->_actionMoveCarEdit();
    }

}
