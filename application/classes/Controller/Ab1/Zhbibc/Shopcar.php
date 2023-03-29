<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_ZhbiBc_ShopCar extends Controller_Ab1_ZhbiBc_BasicAb1 {

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
        $this->_sitePageData->url = '/zhbibc/shopcar/index';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/car/list/index',
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

        if($this->_sitePageData->operation->getIsAdmin()) {
            $this->_requestShopOperations(Model_Ab1_Shop_Operation::RUBRIC_ZHBIBC);
        }

        $params = array(
            'limit' => 1000, 'limit_page' => 25,
            'is_exit' => 0,
            'shop_subdivision_id' => $this->_sitePageData->operation->getProductShopSubdivisionIDsArray(),
        );
        if(Request_RequestParams::getParamBoolean('is_public') === false){
            unset($params['is_exit']);
        }

        // получаем список
        View_View::find('DB_Ab1_Shop_Car',
            $this->_sitePageData->shopID, "_shop/car/list/index", "_shop/car/one/index",
            $this->_sitePageData, $this->_driverDB,
            $params,
            array(
                'shop_client_id' => array('name', 'amount', 'balance_cache', 'balance'),
                'shop_client_attorney_id' => array('name', 'amount', 'block_amount', 'balance', 'number'),
                'shop_product_id' => array('name'),
                'shop_driver_id' => array('name'),
                'shop_delivery_id' => array('name'),
                'shop_turn_id' => array('name')
            )
        );

        $this->_putInMain('/main/_shop/car/index');
    }

    public function action_history() {
        $this->_sitePageData->url = '/zhbibc/shopcar/history';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/car/list/history',
                'view::_shop/addition/service/item/list/index',
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
            $this->_requestShopOperations(Model_Ab1_Shop_Operation::RUBRIC_ZHBIBC);
        }

        $this->_requestShopTransportCompanies();

        // получаем список
        $params = Request_RequestParams::setParams(
            array(
                'limit' => 1000,
                'limit_page' => 25,
                'is_exit' => 1,
                'shop_subdivision_id' => $this->_sitePageData->operation->getProductShopSubdivisionIDsArray(),
                'sort_by' => array(
                    'weighted_exit_at' => 'desc',
                )
            ),
            false
        );
        View_View::find(
            'DB_Ab1_Shop_Car', $this->_sitePageData->shopID,
            "_shop/car/list/history", "_shop/car/one/history",
            $this->_sitePageData, $this->_driverDB, $params,
            array(
                'shop_client_id' => array('name'),
                'shop_product_id' => array('name'),
                'shop_driver_id' => array('name'),
                'cash_operation_id' => array('name'),
                'shop_turn_place_id' => array('name'),
                'shop_client_attorney_id' => array('number'),
            )
        );

        $this->_putInMain('/main/_shop/car/history');
    }

    public function action_new()
    {
        $this->_sitePageData->url = '/zhbibc/shopcar/new';
        $this->_actionShopCarNew();
    }

    public function action_edit()
    {
        $this->_sitePageData->url = '/zhbibc/shopcar/edit';
        $this->_actionShopCarEdit();
    }

    public function action_refusal()
    {
        $this->_sitePageData->url = '/zhbibc/shopcar/refusal';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/car/one/refusal',
                'view::_shop/addition/service/item/list/index',
            )
        );

        // id записи
        $id = Request_RequestParams::getParamInt('id');
        $model = new Model_Ab1_Shop_Car();
        if (! $this->dublicateObjectLanguage($model, $id, -1, false)) {
            throw new HTTP_Exception_404('Car not id "'.$id.'" is found! #03072020');
        }

        $model->dbGetElements($this->_sitePageData->shopMainID, array('shop_client_id'));

        // получаем данные
        View_View::findOne('DB_Ab1_Shop_Car',
            $this->_sitePageData->shopID, "_shop/car/one/refusal",
            $this->_sitePageData, $this->_driverDB, array('id' => $id),
            array('shop_payment_id', 'shop_client_id', 'shop_client_attorney_id', 'shop_product_id', 'shop_driver_id')
        );

        $this->_putInMain('/main/_shop/car/refusal');
    }

    public function action_save()
    {
        $this->_sitePageData->url = '/zhbibc/shopcar/save';

        $result = Api_Ab1_Shop_Car::save($this->_sitePageData, $this->_driverDB);
        $this->_redirectSaveResult($result);
    }

    public function action_del()
    {
        $this->_sitePageData->url = '/zhbibc/shopcar/del';
        $result = Api_Ab1_Shop_Car::delete($this->_sitePageData, $this->_driverDB);
        $this->response->body(Json::json_encode(array('error' => $result)));
    }

    public function action_clone_in_move()
    {
        $this->_sitePageData->url = '/zhbibc/shopcar/clone_in_move';

        $id = Request_RequestParams::getParamInt('id');

        $modelCar = new Model_Ab1_Shop_Car();
        $modelCar->setDBDriver($this->_driverDB);

        if (!Helpers_DB::dublicateObjectLanguage($modelCar, $id, $this->_sitePageData)) {
            throw new HTTP_Exception_404('Car not found.');
        }

        $modelMoveCar = new Model_Ab1_Shop_Move_Car();
        $modelMoveCar->setDBDriver($this->_driverDB);

        $modelCar->cloneInShopMoveCar($modelMoveCar);

        Helpers_DB::saveDBObject($modelMoveCar, $this->_sitePageData, $modelMoveCar->shopID);

        $this->redirect('/zhbibc/shopmovecar/edit?id='.$modelMoveCar->id);
    }
}
