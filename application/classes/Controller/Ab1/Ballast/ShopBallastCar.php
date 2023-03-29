<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_Ballast_ShopBallastCar extends Controller_Ab1_Ballast_BasicAb1
{

    public function __construct(Request $request, Response $response)
    {
        $this->dbObject = 'DB_Ab1_Shop_Ballast_Car';
        $this->controllerName = 'shopballastcar';
        $this->tableID = Model_Ab1_Shop_Ballast_Car::TABLE_ID;
        $this->tableName = Model_Ab1_Shop_Ballast_Car::TABLE_NAME;
        $this->objectName = 'ballastcar';

        parent::__construct($request, $response);
    }

    public function action_index()
    {
        $this->_sitePageData->url = '/ballast/shopballastcar/index';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/ballast/car/list/index',
            )
        );

        $this->_requestShopBallastDrivers();

        // получаем список
        View_View::find('DB_Ab1_Shop_Ballast_Car',
            $this->_sitePageData->shopMainID,
            "_shop/ballast/car/list/index", "_shop/ballast/car/one/index",
            $this->_sitePageData, $this->_driverDB,
            array('limit' => 1000, 'limit_page' => 25),
            array(
                'shop_ballast_driver_id' => array('name'),
                'shop_transport_id' => array('name'),
            )
        );

        $this->_putInMain('/main/_shop/ballast/car/index');
    }

    public function action_new()
    {
        $this->_sitePageData->url = '/ballast/shopballastcar/new';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/ballast/car/one/new',
            )
        );

        $this->_requestShopTransports();

        $dataID = new MyArray();
        $dataID->id = 0;
        $dataID->isFindDB = TRUE;
        $this->_sitePageData->replaceDatas['view::_shop/ballast/car/one/new'] = Helpers_View::getViewObject($dataID, new Model_Ab1_Shop_Ballast_Car(),
            '_shop/ballast/car/one/new', $this->_sitePageData, $this->_driverDB);

        $this->_putInMain('/main/_shop/ballast/car/new');
    }

    public function action_edit()
    {
        $this->_sitePageData->url = '/ballast/shopballastcar/edit';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/ballast/car/one/edit',
            )
        );

        // id записи
        $shopDriverID = Request_RequestParams::getParamInt('id');
        $model = new Model_Ab1_Shop_Ballast_Car();
        if (!$this->dublicateObjectLanguage($model, $shopDriverID, $this->_sitePageData->shopMainID, FALSE)) {
            throw new HTTP_Exception_404('Car not is found!');
        }

        $this->_requestShopBallastDrivers($model->getShopBallastDriverID());
        $this->_requestShopTransports($model->getShopTransportID());

        // получаем данные
        View_View::findOne('DB_Ab1_Shop_Ballast_Car',
            $this->_sitePageData->shopMainID, "_shop/ballast/car/one/edit",
            $this->_sitePageData, $this->_driverDB, array('id' => $shopDriverID)
        );

        $this->_putInMain('/main/_shop/ballast/car/edit');
    }

    public function action_save()
    {
        $this->_sitePageData->url = '/ballast/shopballastcar/save';

        $result = Api_Ab1_Shop_Ballast_Car::save($this->_sitePageData, $this->_driverDB);
        $this->_redirectSaveResult($result);
    }
}
