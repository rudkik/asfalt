<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_Tunable_ShopBallast extends Controller_Ab1_Tunable_BasicAb1 {

    public function __construct(Request $request, Response $response)
    {
        $this->dbObject = 'DB_Ab1_Shop_Ballast';
        $this->controllerName = 'shopballast';
        $this->tableID = Model_Ab1_Shop_Ballast::TABLE_ID;
        $this->tableName = Model_Ab1_Shop_Ballast::TABLE_NAME;
        $this->objectName = 'ballast';

        parent::__construct($request, $response);
    }

    public function action_index() {
        $this->_sitePageData->url = '/tunable/shopballast/index';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/ballast/list/index',
            )
        );
        $this->_requestShopBallastDrivers();
        $this->_requestShopBallastCars();

        // получаем список
        View_View::find('DBAb1_Shop_Ballast', $this->_sitePageData->shopID, "_shop/ballast/list/index", "_shop/ballast/one/index",
            $this->_sitePageData, $this->_driverDB, array('limit' => 1000, 'limit_page' => 25), array('shop_ballast_driver_id' => array('name'), 'shop_ballast_car_id' => array('name')));

        $this->_putInMain('/main/_shop/ballast/index');
    }

    public function action_new()
    {
        $this->_sitePageData->url = '/tunable/shopballast/new';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/ballast/one/new',
            )
        );
        $this->_requestShopBallastDrivers();
        $this->_requestShopBallastCars();

        $dataID = new MyArray();
        $dataID->id = 0;
        $dataID->isFindDB = TRUE;

        $this->_sitePageData->replaceDatas['view::_shop/ballast/one/new'] = Helpers_View::getViewObject($dataID, new Model_Ab1_Shop_Ballast(),
            '_shop/ballast/one/new', $this->_sitePageData, $this->_driverDB, $this->_sitePageData->shopID);

        $this->_putInMain('/main/_shop/ballast/new');
    }

    public function action_edit()
    {
        $this->_sitePageData->url = '/tunable/shopballast/edit';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/ballast/one/edit',
            )
        );

        // id записи
        $shopBallastID = Request_RequestParams::getParamInt('id');
        $model = new Model_Ab1_Shop_Ballast();
        if (! $this->dublicateObjectLanguage($model, $shopBallastID, $this->_sitePageData->shopID, FALSE)) {
            throw new HTTP_Exception_404('Ballast not is found!');
        }

        $this->_requestShopBallastDrivers($model->getShopBallastDriverID());
        $this->_requestShopBallastCars($model->getShopBallastCarID());

        // получаем данные
        View_View::findOne('DB_Ab1_Shop_Ballast', $this->_sitePageData->shopID, "_shop/ballast/one/edit",
            $this->_sitePageData, $this->_driverDB, array('id' => $shopBallastID), array('shop_table_catalog_id'));

        $this->_putInMain('/main/_shop/ballast/edit');
    }

    public function action_save()
    {
        $this->_sitePageData->url = '/tunable/shopballast/save';

        $result = Api_Ab1_Shop_Ballast::save($this->_sitePageData, $this->_driverDB);
        $this->_redirectSaveResult($result);
    }

    public function action_del()
    {
        $this->_sitePageData->url = '/tunable/shopballast/del';
        $result = Api_Ab1_Shop_Ballast::delete($this->_sitePageData, $this->_driverDB);
        $this->response->body(Json::json_encode(array('error' => $result)));
    }
}
