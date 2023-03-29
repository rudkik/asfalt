<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_Abc_ShopCar extends Controller_Ab1_Abc_BasicAb1{

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
        $this->_sitePageData->url = '/abc/shopcar/index';
        

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/car/list/index',
            )
        );

        // основная продукция
        $this->_requestShopProducts(
            NULL, 0, NULL, FALSE,
            [Model_Ab1_ProductView::PRODUCT_TYPE_CAR]
        );

        $this->_requestShopOperations(Model_Ab1_Shop_Operation::RUBRIC_WEIGHT);
        $this->_requestShopTurnPlaces();

        $params = Request_RequestParams::setParams(
            [
                'limit' => 1000,
                'shop_subdivision_id' => $this->_sitePageData->operation->getProductShopSubdivisionIDsArray(),
                'limit_page' => 25,
                'is_exit' => 1,

            ],
            false
        );

        // получаем список
        View_View::find(
            'DB_Ab1_Shop_Car', $this->_sitePageData->shopID,
            "_shop/car/list/index", "_shop/car/one/index",
            $this->_sitePageData, $this->_driverDB, $params,
            array(
                'shop_client_id' => array('name'),
                'shop_product_id' => array('name'),
                'weighted_exit_operation_id' => array('name'),
                'shop_turn_place_id' => array('name'),
                'shop_formula_product_id' => array('name'),
            )
        );

        $this->_putInMain('/main/_shop/car/index');
    }

    public function action_formula() {
        $this->_sitePageData->url = '/abc/shopcar/formula';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/car/list/formula',
            )
        );

        // основная продукция
        $this->_requestShopProducts(
            NULL, 0, NULL, FALSE,
            [Model_Ab1_ProductView::PRODUCT_TYPE_CAR, Model_Ab1_ProductView::PRODUCT_TYPE_CAR_AND_PIECE]
        );

        $this->_requestShopOperations(Model_Ab1_Shop_Operation::RUBRIC_WEIGHT);
        $this->_requestShopTurnPlaces();

        $dateFrom = Request_RequestParams::getParamDateTime('exit_at_from');
        if($dateFrom == null){
            $dateFrom = Helpers_DateTime::getMonthBeginStr(date('m'), date('Y')).' 06:00:00';
        }

        $dateTo = Request_RequestParams::getParamDateTime('exit_at_to');
        if($dateTo == null){
            $dateTo = Helpers_DateTime::plusMonth($dateFrom, 1);
        }

        $params = Request_RequestParams::setParams(
            array(
                'exit_at_from' => $dateFrom,
                'exit_at_to' => $dateTo,
                'is_exit' => 1,
                'count_id' => true,
                'sum_quantity' => true,
                'group_by' => array(
                    'shop_product_id', 'shop_product_id.name',
                    'shop_formula_product_id', 'shop_formula_product_id.name',
                ),
            ),
            false
        );

        // получаем список
        View_View::find(
            'DB_Ab1_Shop_Car', $this->_sitePageData->shopID,
            "_shop/car/list/formula", "_shop/car/one/formula",
            $this->_sitePageData, $this->_driverDB, $params,
            array(
                'shop_product_id' => array('name'),
                'shop_formula_product_id' => array('name'),
            )
        );

        $this->_putInMain('/main/_shop/car/formula');
    }

    public function action_edit()
    {
        $this->_sitePageData->url = '/abc/shopcar/edit';
        $this->_actionShopCarEdit();
    }

    public function action_save()
    {
        $this->_sitePageData->url = '/abc/shopcar/save';

        $result = Api_Ab1_Shop_Car::save($this->_sitePageData, $this->_driverDB);
        $this->_redirectSaveResult($result, '/abc/shopcar/sttn');
    }

    public function action_ttn() {
        $this->_sitePageData->url = '/abc/shopcar/ttn';
        $this->_actionShopCarTTN();
    }
}
