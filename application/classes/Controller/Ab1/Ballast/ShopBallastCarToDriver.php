<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_Ballast_ShopBallastCarToDriver extends Controller_Ab1_Ballast_BasicAb1
{

    public function __construct(Request $request, Response $response)
    {
        $this->dbObject = 'DB_Ab1_Shop_Ballast_Car_To_Driver';
        $this->controllerName = 'shopballastcartodriver';
        $this->tableID = Model_Ab1_Shop_Ballast_Car_To_Driver::TABLE_ID;
        $this->tableName = Model_Ab1_Shop_Ballast_Car_To_Driver::TABLE_NAME;
        $this->objectName = 'ballastcartodriver';

        parent::__construct($request, $response);
    }

    public function action_index()
    {
        $this->_sitePageData->url = '/ballast/shopballastcartodriver/index';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/ballast/car/to/driver/list/index',
            )
        );

        $this->_requestShopBallastDrivers();
        $this->_requestShopBallastCars();

        // получаем список
        $params = Request_RequestParams::setParams(
            array(
                'limit' => 1000, 'limit_page' => 25,
                'sort_by' => array(
                    'shop_ballast_car_id.name' => 'asc',
                )
            ),
            FALSE
        );
        View_View::find('DB_Ab1_Shop_Ballast_Car_To_Driver',
            $this->_sitePageData->shopID,
            "_shop/ballast/car/to/driver/list/index", "_shop/ballast/car/to/driver/one/index",
            $this->_sitePageData, $this->_driverDB, $params,
            array('shop_ballast_driver_id' => array('name'), 'shop_ballast_car_id' => array('name'))
        );

        $this->_putInMain('/main/_shop/ballast/car/to/driver/index');
    }

    public function action_new()
    {
        $this->_sitePageData->url = '/ballast/shopballastcartodriver/new';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/ballast/car/to/driver/one/new',
            )
        );

        $this->_requestShopBallastDrivers();
        $this->_requestShopBallastCars();

        $dataID = new MyArray();
        $dataID->id = 0;
        $dataID->isFindDB = TRUE;
        $this->_sitePageData->replaceDatas['view::_shop/ballast/car/to/driver/one/new'] =
            Helpers_View::getViewObject($dataID, new Model_Ab1_Shop_Ballast_Car_To_Driver(),
            '_shop/ballast/car/to/driver/one/new', $this->_sitePageData, $this->_driverDB
            );

        $this->_putInMain('/main/_shop/ballast/car/to/driver/new');
    }

    public function action_edit()
    {
        $this->_sitePageData->url = '/ballast/shopballastcartodriver/edit';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/ballast/car/to/driver/one/edit',
            )
        );

        // id записи
        $id = Request_RequestParams::getParamInt('id');
        $model = new Model_Ab1_Shop_Ballast_Car_To_Driver();
        if (!$this->dublicateObjectLanguage($model, $id, $this->_sitePageData->shopID, FALSE)) {
            throw new HTTP_Exception_404('Car to driver not is found!');
        }

        $this->_requestShopBallastDrivers($model->getShopBallastDriverID());
        $this->_requestShopBallastCars($model->getShopBallastCarID());

        // получаем данные
        View_View::findOne('DB_Ab1_Shop_Ballast_Car_To_Driver',
            $this->_sitePageData->shopID, "_shop/ballast/car/to/driver/one/edit",
            $this->_sitePageData, $this->_driverDB, array('id' => $id)
        );

        $this->_putInMain('/main/_shop/ballast/car/to/driver/edit');
    }

    public function action_save()
    {
        $this->_sitePageData->url = '/ballast/shopballastcartodriver/save';

        $result = Api_Ab1_Shop_Ballast_Car_To_Driver::save($this->_sitePageData, $this->_driverDB);
        $this->_redirectSaveResult($result);
    }
}
