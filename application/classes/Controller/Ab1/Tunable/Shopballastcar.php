<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_Tunable_ShopBallastCar extends Controller_Ab1_Tunable_BasicAb1 {

    public function __construct(Request $request, Response $response)
    {
        $this->dbObject = 'DB_Ab1_Shop_Ballast_Car';
        $this->controllerName = 'shopballastcar';
        $this->tableID = Model_Ab1_Shop_Ballast_Car::TABLE_ID;
        $this->tableName = Model_Ab1_Shop_Ballast_Car::TABLE_NAME;
        $this->objectName = 'ballastcar';

        parent::__construct($request, $response);
    }

    public function action_index() {
        $this->_sitePageData->url = '/tunable/shopballastcar/index';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/ballast/car/list/index',
            )
        );
        $this->_requestShopBallastDrivers();

        // получаем список
        View_View::find('DB_Ab1_Shop_Ballast_Car', $this->_sitePageData->shopID, "_shop/ballast/car/list/index", "_shop/ballast/car/one/index",
            $this->_sitePageData, $this->_driverDB, array('limit' => 1000, 'limit_page' => 25), array('shop_ballast_driver_id' => array('name')));

        $this->_putInMain('/main/_shop/ballast/car/index');
    }

    public function action_new()
    {
        $this->_sitePageData->url = '/tunable/shopballastcar/new';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/ballast/car/one/new',
            )
        );
        $this->_requestShopBallastDrivers();

        $dataID = new MyArray();
        $dataID->id = 0;
        $dataID->isFindDB = TRUE;

        $this->_sitePageData->replaceDatas['view::_shop/ballast/car/one/new'] = Helpers_View::getViewObject($dataID, new Model_Ab1_Shop_Ballast_Car(),
            '_shop/ballast/car/one/new', $this->_sitePageData, $this->_driverDB, $this->_sitePageData->shopID);

        $this->_putInMain('/main/_shop/ballast/car/new');
    }

    public function action_edit()
    {
        $this->_sitePageData->url = '/tunable/shopballastcar/edit';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/ballast/car/one/edit',
            )
        );

        // id записи
        $shopBallastCarID = Request_RequestParams::getParamInt('id');
        $model = new Model_Ab1_Shop_Ballast_Car();
        if (! $this->dublicateObjectLanguage($model, $shopBallastCarID, $this->_sitePageData->shopID, FALSE)) {
            throw new HTTP_Exception_404('BallastCar not is found!');
        }
        $this->_requestShopBallastDrivers($model->getShopBallastDriverID());

        // получаем данные
        View_View::findOne('DB_Ab1_Shop_Ballast_Car', $this->_sitePageData->shopID, "_shop/ballast/car/one/edit",
            $this->_sitePageData, $this->_driverDB, array('id' => $shopBallastCarID), array('shop_table_catalog_id'));

        $this->_putInMain('/main/_shop/ballast/car/edit');
    }

    public function action_save()
    {
        $this->_sitePageData->url = '/tunable/shopballastcar/save';

        $result = Api_Ab1_Shop_Ballast_Car::save($this->_sitePageData, $this->_driverDB);
        $this->_redirectSaveResult($result);
    }

    public function action_del()
    {
        $this->_sitePageData->url = '/tunable/shopballastcar/del';
        $result = Api_Ab1_Shop_Ballast_Car::delete($this->_sitePageData, $this->_driverDB);
        $this->response->body(Json::json_encode(array('error' => $result)));
    }
}
