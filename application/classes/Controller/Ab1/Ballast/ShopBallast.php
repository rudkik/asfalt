<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_Ballast_ShopBallast extends Controller_Ab1_Ballast_BasicAb1
{

    public function __construct(Request $request, Response $response)
    {
        $this->dbObject = 'DB_Ab1_Shop_Ballast';
        $this->controllerName = 'shopballast';
        $this->tableID = Model_Ab1_Shop_Ballast::TABLE_ID;
        $this->tableName = Model_Ab1_Shop_Ballast::TABLE_NAME;
        $this->objectName = 'ballast';

        parent::__construct($request, $response);
    }

    public function action_index()
    {
        $this->_sitePageData->url = '/ballast/shopballast/index';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/ballast/list/index',
            )
        );

        $this->_requestShopBallastDrivers();
        $this->_requestShopBallastCars();
        $this->_requestShopBallastDistances();
        $this->_requestShopBallastCrushers(null, array('is_move' => true));
        $this->_requestShopWorkShifts();

        $params = Request_RequestParams::setParams(
            array(
                'limit' => 1000,
                'limit_page' => 25,
                'sort_by' => array(
                    'date' => 'desc',
                ),
            ),
            false
        );

        // получаем список
        View_View::find(
            'DB_Ab1_Shop_Ballast', $this->_sitePageData->shopID, "_shop/ballast/list/index", "_shop/ballast/one/index",
            $this->_sitePageData, $this->_driverDB, $params,
            array(
                'shop_ballast_driver_id' => array('name'),
                'shop_ballast_car_id' => array('name'),
                'shop_ballast_crusher_id' => array('name'),
                'shop_ballast_distance_id' => array('name'),
                'shop_work_shift_id' => array('name'),
                'take_shop_ballast_crusher_id' => array('name'),
                'shop_transport_waybill_id' => array('number'),
            )
        );

        if($this->_sitePageData->operation->getIsAdmin()) {
            $this->_requestShopBranches($this->_sitePageData->shopID, TRUE);
        }

        $this->_putInMain('/main/_shop/ballast/index');
    }

    public function action_new()
    {
        $this->_sitePageData->url = '/ballast/shopballast/new';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/ballast/one/new',
            )
        );

        $this->_requestShopBallastDrivers();
        $this->_requestShopBallastCars();
        $this->_requestShopBallastDistances();
        $this->_requestShopBallastCrushers(null, array('is_move' => true));
        $this->_requestShopWorkShifts();
        $this->_requestShopBallastCrushers(null, array('is_storage' => true), 'take');

        $dataID = new MyArray();
        $dataID->id = 0;
        $dataID->isFindDB = TRUE;
        $this->_sitePageData->replaceDatas['view::_shop/ballast/one/new'] = Helpers_View::getViewObject(
            $dataID, new Model_Ab1_Shop_Ballast(),
            '_shop/ballast/one/new', $this->_sitePageData, $this->_driverDB
        );

        $this->_putInMain('/main/_shop/ballast/new');
    }

    public function action_edit()
    {
        $this->_sitePageData->url = '/ballast/shopballast/edit';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/ballast/one/edit',
            )
        );

        // id записи
        $shopDriverID = Request_RequestParams::getParamInt('id');
        $model = new Model_Ab1_Shop_Ballast();
        if (!$this->dublicateObjectLanguage($model, $shopDriverID, -1, FALSE)) {
            throw new HTTP_Exception_404('Driver not is found!');
        }
        $this->_requestShopBallastDrivers($model->getShopBallastDriverID());
        $this->_requestShopBallastCars($model->getShopBallastCarID());
        $this->_requestShopBallastDistances($model->getShopBallastDistanceID());
        $this->_requestShopBallastCrushers($model->getShopBallastCrusherID(), array('is_move' => true));
        $this->_requestShopWorkShifts($model->getShopWorkShiftID());
        $this->_requestShopBallastCrushers($model->getTakeShopBallastCrusherID(), array('is_storage' => true), 'take');

        // получаем данные
        View_View::findOne('DB_Ab1_Shop_Ballast', $this->_sitePageData->shopID, "_shop/ballast/one/edit",
            $this->_sitePageData, $this->_driverDB, array('id' => $shopDriverID),
            array('shop_ballast_driver_id' => array('name'), 'shop_ballast_car_id' => array('name')));

        $this->_putInMain('/main/_shop/ballast/edit');
    }

    public function action_del()
    {
        $this->_sitePageData->url = '/ballast/shopballast/del';
        $result = Api_Ab1_Shop_Ballast::delete($this->_sitePageData, $this->_driverDB);
        $this->response->body(Json::json_encode(array('error' => $result)));
    }

    public function action_save()
    {
        $this->_sitePageData->url = '/ballast/shopballast/save';

        $result = Api_Ab1_Shop_Ballast::save($this->_sitePageData, $this->_driverDB);
        if(Request_RequestParams::getParamBoolean('is_add')){
            // получаем количество рейсов машин + водителей
            $shopWorkShiftIDs = Request_Request::findAll(
                'DB_Ab1_Shop_Work_Shift', $this->_sitePageData->shopID,
                $this->_sitePageData, $this->_driverDB, true
            );

            $timeFrom = strtotime('23:59:59');
            foreach ($shopWorkShiftIDs->childs as $child){
                $tmp = strtotime($child->values['time_from']);
                if($tmp < $timeFrom) {
                    $timeFrom = $tmp;
                }
            }

            $dateFrom = Request_RequestParams::getParamDate('date');
            if($dateFrom == null){
                $dateFrom = date('Y-m-d');
            }

            $dateFrom .= date(' H:i:s.u', $timeFrom);
            $dateTo = Helpers_DateTime::plusDays($dateFrom, 1);

            $params = Request_RequestParams::setParams(
                array(
                    'date_from' => $dateFrom,
                    'date_to' => $dateTo,
                    'shop_work_shift_id' => Request_RequestParams::getParamInt('shop_work_shift_id'),
                    'shop_ballast_car_id' => Request_RequestParams::getParamInt('shop_ballast_car_id'),
                    'shop_ballast_driver_id' => Request_RequestParams::getParamInt('shop_ballast_driver_id'),
                    'shop_ballast_driver_id' => Request_RequestParams::getParamInt('shop_ballast_driver_id'),
                    'count_id' => true,
                )
            );

            $ids = Request_Request::find(
                'DB_Ab1_Shop_Ballast', $this->_sitePageData->shopID,
                $this->_sitePageData, $this->_driverDB, $params
            );

            $this->response->body(Json::json_encode(array('count' => $ids->childs[0]->values['count'])));
        }else {
            $this->_redirectSaveResult($result);
        }
    }

    public function action_add()
    {
        $this->_sitePageData->url = '/ballast/shopballast/add';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/ballast/one/add',
                'view::_shop/ballast/crusher/list/add-ballast',
                'view::_shop/ballast/car/to/driver/list/add-ballast',
            )
        );

        $this->_requestShopBallastDistances();
        $this->_requestShopWorkShifts();
        $this->_requestShopBallastCrushers(null, array('is_storage' => true));

        $params = Request_RequestParams::setParams(
            array(
                'is_move' => true,
                'sort_by' => array('name' => 'asc')
            )
        );
        View_View::find('DB_Ab1_Shop_Ballast_Crusher',
            $this->_sitePageData->shopID,
            "_shop/ballast/crusher/list/add-ballast", "_shop/ballast/crusher/one/add-ballast",
            $this->_sitePageData, $this->_driverDB, $params
        );

        // получаем список машин + водителей
        $params = Request_RequestParams::setParams(
            array(
                'sort_by' => array(
                    'shop_ballast_car_id.name' => 'asc',
                    'shop_ballast_driver_id.name' => 'asc',
                )
            )
        );
        $shopBallastCarToDriverIDs = Request_Request::find('DB_Ab1_Shop_Ballast_Car_To_Driver',
            $this->_sitePageData->shopID,
            $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
            array('shop_ballast_driver_id' => array('name'), 'shop_ballast_car_id' => array('name'))
        );

        // получаем количество рейсов машин + водителей
        $shopWorkShiftIDs = Request_Request::findAll(
            'DB_Ab1_Shop_Work_Shift', $this->_sitePageData->shopID,
            $this->_sitePageData, $this->_driverDB, true
        );

        $timeFrom = strtotime('23:59:59');
        foreach ($shopWorkShiftIDs->childs as $child){
            $tmp = strtotime($child->values['time_from']);
            if($tmp < $timeFrom) {
                $timeFrom = $tmp;
            }
        }

        $dateFrom = Request_RequestParams::getParamDate('date');
        if($dateFrom == null){
            $dateFrom = date('Y-m-d');
        }

        $dateFrom .= date(' H:i:s', $timeFrom);
        if(strtotime($timeFrom) > strtotime(date('H:i:s'))){
            $dateTo = Helpers_DateTime::plusDays($dateFrom, 1);
        }else{
            $dateTo = $dateFrom;
            $dateFrom = Helpers_DateTime::minusDays($dateFrom, 1);
        }

        $shopWorkShiftID = Request_RequestParams::getParamInt('shop_work_shift_id');
        $params = Request_RequestParams::setParams(
            array(
                'count_id' => TRUE,
                'date_from' => $dateFrom,
                'date_to' => $dateTo,
                'shop_work_shift_id' => $shopWorkShiftID,
                'group_by' => array(
                    'shop_ballast_car_id',
                    'shop_ballast_driver_id',
                )
            )
        );
        $shopBallastIDs = Request_Request::find('DB_Ab1_Shop_Ballast',
            $this->_sitePageData->shopID,
            $this->_sitePageData, $this->_driverDB, $params
        );

        foreach ($shopBallastCarToDriverIDs->childs as $child){
            $count = $shopBallastIDs->findChildValues(
                array(
                    'shop_ballast_car_id' => $child->values['shop_ballast_car_id'],
                    'shop_ballast_driver_id' => $child->values['shop_ballast_driver_id'],
                ),
                false
            );

            if($count == null){
                $count = 0;
            }else{
                $count = intval($count->values['count']);
            }

            $child->additionDatas['count'] = $count;
        }

        $this->_sitePageData->replaceDatas['view::_shop/ballast/car/to/driver/list/add-ballast'] = Helpers_View::getViewObjects(
            $shopBallastCarToDriverIDs, new Model_Ab1_Shop_Ballast_Car_To_Driver(),
            '_shop/ballast/car/to/driver/list/add-ballast', '_shop/ballast/car/to/driver/one/add-ballast',
            $this->_sitePageData, $this->_driverDB
        );

        $dataID = new MyArray();
        $dataID->id = 0;
        $dataID->isFindDB = TRUE;
        $dataID->isLoadElements = TRUE;
        $this->_sitePageData->replaceDatas['view::_shop/ballast/one/add'] = Helpers_View::getViewObject($dataID, new Model_Ab1_Shop_Ballast(),
            '_shop/ballast/one/add', $this->_sitePageData, $this->_driverDB);

        $this->_putInMain('/main/_shop/ballast/add');
    }

    public function action_add_raws()
    {
        $this->_sitePageData->url = '/ballast/shopballast/add_raws';

        Api_Ab1_Shop_Register_Raw::addShopBallasts($this->_sitePageData, $this->_driverDB);
        echo 'ok'; die;
    }
}
