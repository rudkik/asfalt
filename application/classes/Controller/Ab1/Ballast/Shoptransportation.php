<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_Ballast_ShopTransportation extends Controller_Ab1_Ballast_BasicAb1
{
    public function __construct(Request $request, Response $response)
    {
        $this->dbObject = 'DB_Ab1_Shop_Transportation';
        $this->controllerName = 'shoptransportation';
        $this->tableID = Model_Ab1_Shop_Transportation::TABLE_ID;
        $this->tableName = Model_Ab1_Shop_Transportation::TABLE_NAME;
        $this->objectName = 'transportation';

        parent::__construct($request, $response);
    }

    public function action_index()
    {
        $this->_sitePageData->url = '/ballast/shoptransportation/index';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/transportation/list/index',
            )
        );

        $this->_requestShopBallastDrivers();
        $this->_requestShopBallastCars();
        $this->_requestShopBallastDistances();
        $this->_requestListDB('DB_Ab1_Shop_Transportation_Place', null, -1);
        $this->_requestShopWorkShifts();

        // получаем список
        View_View::find(
            'DB_Ab1_Shop_Transportation', $this->_sitePageData->shopID,
            "_shop/transportation/list/index", "_shop/transportation/one/index",
            $this->_sitePageData, $this->_driverDB, array('limit' => 1000, 'limit_page' => 25),
            array(
                'shop_ballast_driver_id' => array('name'),
                'shop_ballast_car_id' => array('name'),
                'shop_transportation_place_id' => array('name'),
                'shop_ballast_distance_id' => array('name'),
                'shop_work_shift_id' => array('name'),
                'shop_transport_waybill_id' => array('number'),
            )
        );

        if($this->_sitePageData->operation->getIsAdmin()) {
            $this->_requestShopBranches($this->_sitePageData->shopID, TRUE);
        }

        $this->_putInMain('/main/_shop/transportation/index');
    }

    public function action_new()
    {
        $this->_sitePageData->url = '/transportation/shoptransportation/new';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/transportation/one/new',
            )
        );

        $this->_requestShopBallastDrivers();
        $this->_requestShopBallastCars();
        $this->_requestShopBallastDistances();
        $this->_requestListDB('DB_Ab1_Shop_Transportation_Place', null, -1);
        $this->_requestShopWorkShifts();

        $dataID = new MyArray();
        $dataID->id = 0;
        $dataID->isFindDB = TRUE;
        $this->_sitePageData->replaceDatas['view::_shop/transportation/one/new'] = Helpers_View::getViewObject(
            $dataID, new Model_Ab1_Shop_Transportation(),
            '_shop/transportation/one/new', $this->_sitePageData, $this->_driverDB
        );

        $this->_putInMain('/main/_shop/transportation/new');
    }

    public function action_edit()
    {
        $this->_sitePageData->url = '/transportation/shoptransportation/edit';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/transportation/one/edit',
            )
        );

        // id записи
        $shopDriverID = Request_RequestParams::getParamInt('id');
        $model = new Model_Ab1_Shop_Transportation();
        if (!$this->dublicateObjectLanguage($model, $shopDriverID, -1, FALSE)) {
            throw new HTTP_Exception_404('Driver not is found!');
        }
        $this->_requestShopBallastDrivers($model->getShopBallastDriverID());
        $this->_requestShopBallastCars($model->getShopBallastCarID());
        $this->_requestShopBallastDistances($model->getShopBallastDistanceID());
        $this->_requestListDB('DB_Ab1_Shop_Transportation_Place', $model->getShopTransportationPlaceID(), -1);
        $this->_requestShopWorkShifts($model->getShopWorkShiftID());

        // получаем данные
        View_View::findOne(
            'DB_Ab1_Shop_Transportation', $this->_sitePageData->shopID,
            "_shop/transportation/one/edit",
            $this->_sitePageData, $this->_driverDB, array('id' => $shopDriverID)
        );

        $this->_putInMain('/main/_shop/transportation/edit');
    }

    public function action_save()
    {
        $this->_sitePageData->url = '/transportation/shoptransportation/save';

        $result = Api_Ab1_Shop_Transportation::save($this->_sitePageData, $this->_driverDB);
        $this->_redirectSaveResult($result);
    }
}
