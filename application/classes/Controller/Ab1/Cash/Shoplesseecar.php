<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_Cash_ShopLesseeCar extends Controller_Ab1_Cash_BasicAb1 {

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
        $this->_sitePageData->url = '/cash/shoplesseecar/index';

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

        if($this->_sitePageData->operation->getIsAdmin()) {
            $this->_requestShopOperations(Model_Ab1_Shop_Operation::RUBRIC_CASH);
        }

        // получаем список
        View_View::find('DB_Ab1_Shop_Lessee_Car',
            $this->_sitePageData->shopID, "_shop/lessee/car/list/index", "_shop/lessee/car/one/index",
            $this->_sitePageData, $this->_driverDB,
            array('limit' => 1000, 'limit_page' => 25),
            array(
                'shop_client_id' => array('name'),
                'shop_product_id' => array('name'),
                'shop_driver_id' => array('name'),
                'shop_delivery_id' => array('name'),
                'shop_turn_id' => array('name'),
                'cash_operation_id' => array('name'),
            )
        );

        $this->_putInMain('/main/_shop/lessee/car/index');
    }

    public function action_new()
    {
        $this->_sitePageData->url = '/cash/shoplesseecar/new';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/lessee/car/one/new',
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

        $this->_requestShopClients(null, Model_Ab1_ClientType::CLIENT_TYPE_LESSEE);

        $dataID = new MyArray();
        $dataID->id = 0;
        $dataID->isFindDB = TRUE;
        $this->_sitePageData->replaceDatas['view::_shop/lessee/car/one/new'] = Helpers_View::getViewObject($dataID, new Model_Ab1_Shop_Lessee_Car(),
            '_shop/lessee/car/one/new', $this->_sitePageData, $this->_driverDB);

        $this->_putInMain('/main/_shop/lessee/car/new');
    }

    public function action_edit()
    {
        $this->_sitePageData->url = '/cash/shoplesseecar/edit';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/lessee/car/one/edit',
                'view::_shop/addition/service/item/list/index',
            )
        );

        // id записи
        $id = Request_RequestParams::getParamInt('id');
        $model = new Model_Ab1_Shop_Lessee_Car();
        if (! $this->dublicateObjectLanguage($model, $id, -1, false)) {
            throw new HTTP_Exception_404('Car not is found!');
        }
        $model->dbGetElements($this->_sitePageData->shopMainID, array('shop_client_id'));

        // основная продукция
        $this->_requestShopProducts(
            $model->getShopProductID(), 0, NULL, FALSE,
            [
                Model_Ab1_ProductView::PRODUCT_TYPE_CAR,
                Model_Ab1_ProductView::PRODUCT_TYPE_CAR_AND_PIECE,
            ]
        );

        $this->_requestShopClients($model->getShopClientID(), Model_Ab1_ClientType::CLIENT_TYPE_LESSEE);

        // получаем данные
        View_View::findOne('DB_Ab1_Shop_Lessee_Car', $this->_sitePageData->shopID, "_shop/lessee/car/one/edit",
            $this->_sitePageData, $this->_driverDB, array('id' => $id),
            array('shop_payment_id', 'shop_client_id', 'shop_product_id', 'shop_driver_id'));

        $this->_putInMain('/main/_shop/lessee/car/edit');
    }

    public function action_save()
    {
        $this->_sitePageData->url = '/cash/shoplesseecar/save';

        $result = Api_Ab1_Shop_Lessee_Car::save($this->_sitePageData, $this->_driverDB);
        $this->_redirectSaveResult($result);
    }

    public function action_del()
    {
        $this->_sitePageData->url = '/cash/shoplesseecar/del';
        $result = Api_Ab1_Shop_Lessee_Car::delete($this->_sitePageData, $this->_driverDB);
        $this->response->body(Json::json_encode(array('error' => $result)));
    }
}
