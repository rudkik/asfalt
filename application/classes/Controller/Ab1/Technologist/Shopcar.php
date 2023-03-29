<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_Technologist_ShopCar extends Controller_Ab1_Technologist_BasicAb1{
    public function action_index() {
        $this->_sitePageData->url = '/technologist/shopcar/index';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/car/list/index',
            )
        );

        // основная продукция
        $this->_requestShopProducts(
            NULL, 0, NULL, FALSE,
            [Model_Ab1_ProductView::PRODUCT_TYPE_CAR, Model_Ab1_ProductView::PRODUCT_TYPE_CAR_AND_PIECE]
        );

        $this->_requestShopOperations(Model_Ab1_Shop_Operation::RUBRIC_WEIGHT);
        $this->_requestShopTurnPlaces();

        // получаем список
        View_View::find(
            'DB_Ab1_Shop_Car', $this->_sitePageData->shopID,
            "_shop/car/list/index", "_shop/car/one/index",
            $this->_sitePageData, $this->_driverDB,
            array('limit' => 1000, 'limit_page' => 25, 'is_exit' => 1),
            array(
                'shop_client_id' => array('name'),
                'shop_product_id' => array('name'),
                'shop_driver_id' => array('name'),
                'weighted_exit_operation_id' => array('name'),
                'shop_turn_place_id' => array('name'),
                'shop_formula_product_id' => array('name'),
            )
        );

        $this->_putInMain('/main/_shop/car/index');
    }

    public function action_edit()
    {
        $this->_sitePageData->url = '/technologist/shopcar/edit';
        $this->_actionShopCarEdit();
    }

    public function action_save()
    {
        $this->_sitePageData->url = '/technologist/shopcar/save';

        $result = Api_Ab1_Shop_Car::save($this->_sitePageData, $this->_driverDB);
        $this->_redirectSaveResult($result, '/abc/shopcar/sttn');
    }

    public function action_asu() {
        $this->_sitePageData->url = '/technologist/shopcar/asu';
        $this->_requestShopBranches(null, true);
        $this->_actionASU();
    }

    public function action_asu_cars() {
        $this->_sitePageData->url = '/technologist/shopcar/asu_cars';
        $this->_actionASUCars();
    }
}
