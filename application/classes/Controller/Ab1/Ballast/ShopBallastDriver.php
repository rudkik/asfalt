<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_Ballast_ShopBallastDriver extends Controller_Ab1_Ballast_BasicAb1
{

    public function __construct(Request $request, Response $response)
    {
        $this->dbObject = 'DB_Ab1_Shop_Ballast_Driver';
        $this->controllerName = 'shopballastdriver';
        $this->tableID = Model_Ab1_Shop_Ballast_Driver::TABLE_ID;
        $this->tableName = Model_Ab1_Shop_Ballast_Driver::TABLE_NAME;
        $this->objectName = 'ballastdriver';

        parent::__construct($request, $response);
    }

    public function action_index()
    {
        $this->_sitePageData->url = '/ballast/shopballastdriver/index';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/ballast/driver/list/index',
            )
        );

        // получаем список
        View_View::find('DB_Ab1_Shop_Ballast_Driver',
            $this->_sitePageData->shopMainID,
            "_shop/ballast/driver/list/index", "_shop/ballast/driver/one/index",
            $this->_sitePageData, $this->_driverDB, array('limit' => 1000, 'limit_page' => 25),
            ['shop_worker_id' => ['name']]
        );

        $this->_putInMain('/main/_shop/ballast/driver/index');
    }

    public function action_new()
    {
        $this->_sitePageData->url = '/ballast/shopballastdriver/new';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/ballast/driver/one/new',
            )
        );

        $this->_requestShopWorkers();

        $dataID = new MyArray();
        $dataID->id = 0;
        $dataID->isFindDB = TRUE;
        $this->_sitePageData->replaceDatas['view::_shop/ballast/driver/one/new'] = Helpers_View::getViewObject($dataID, new Model_Ab1_Shop_Ballast_Driver(),
            '_shop/ballast/driver/one/new', $this->_sitePageData, $this->_driverDB);

        $this->_putInMain('/main/_shop/ballast/driver/new');
    }

    public function action_edit()
    {
        $this->_sitePageData->url = '/ballast/shopballastdriver/edit';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/ballast/driver/one/edit',
            )
        );

        // id записи
        $id = Request_RequestParams::getParamInt('id');
        $model = new Model_Ab1_Shop_Ballast_Driver();
        if (!$this->dublicateObjectLanguage($model, $id, $this->_sitePageData->shopMainID, FALSE)) {
            throw new HTTP_Exception_404('Driver not is found!');
        }

        $this->_requestShopWorkers($model->getShopWorkerID());

        // получаем данные
        View_View::findOne('DB_Ab1_Shop_Ballast_Driver', $this->_sitePageData->shopMainID, "_shop/ballast/driver/one/edit",
            $this->_sitePageData, $this->_driverDB, array('id' => $id), array('shop_client_id'));

        $this->_putInMain('/main/_shop/ballast/driver/edit');
    }

    public function action_save()
    {
        $this->_sitePageData->url = '/ballast/shopballastdriver/save';

        $result = Api_Ab1_Shop_Ballast_Driver::save($this->_sitePageData, $this->_driverDB);
        $this->_redirectSaveResult($result);
    }

    public function action_statistics()
    {
        $this->_sitePageData->url = '/ballast/shopballastdriver/statistics';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/ballast/driver/list/statistics',
            )
        );

        $dateFrom = Request_RequestParams::getParamDate('date_from');
        $dateTo = Request_RequestParams::getParamDate('date_to');

        Api_Ab1_Shop_Work_Shift::getPeriodWorkShift($dateFrom, $dateTo, $this->_sitePageData, $this->_driverDB);

        $params = Request_RequestParams::setParams(
            array(
                'date_from' => $dateFrom,
                'date_to' => $dateTo,
                'sum_quantity' => true,
                'count_id' => true,
                'group_by' => array(
                    'shop_ballast_driver_id', 'shop_ballast_driver_id.name',
                    'shop_ballast_crusher_id', 'shop_ballast_crusher_id.name',
                ),
                'sort_by' => array(
                    'shop_ballast_driver_id.name' => 'asc',
                    'shop_ballast_crusher_id.name' => 'asc',
                ),
            )
        );

        $ids = Request_Request::find(
            'DB_Ab1_Shop_Ballast', $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB,
            $params, 0, true,
            array(
                'shop_ballast_driver_id' => array('name'),
                'shop_ballast_crusher_id' => array('name'),
            )
        );

        $crushers = array();

        $result = array(
            'quantity' => 0,
            'count' => 0,
            'data' => array(),
        );
        foreach ($ids->childs as $child){
            $driver = $child->values['shop_ballast_driver_id'];
            if(!key_exists($driver, $result['data'])){
                $result['data'][$driver] = array(
                    'name' => $child->getElementValue('shop_ballast_driver_id'),
                    'quantity' => 0,
                    'count' => 0,
                    'crushers' => array(),
                    'places' => array(),
                );
            }

            $crusher = $child->values['shop_ballast_crusher_id'];
            if(!key_exists($crusher, $result['data'][$driver]['crushers'])){
                $result['data'][$driver]['crushers'][$crusher] = array(
                    'name' => $child->getElementValue('shop_ballast_crusher_id'),
                    'quantity' => 0,
                    'count' => 0,
                    'data' => array(),
                );
                $crushers[$crusher] = $child->getElementValue('shop_ballast_crusher_id');
            }

            $quantity = $child->values['shop_ballast_driver_id'];
            $result['data'][$driver]['crushers'][$crusher]['quantity'] += $quantity;
            $result['data'][$driver]['quantity'] += $quantity;
            $result['quantity'] += $quantity;

            $count = $child->values['count'];
            $result['data'][$driver]['crushers'][$crusher]['count'] += $count;
            $result['data'][$driver]['count'] += $count;
            $result['count'] += $count;
        }

        // прибавляем количество перевозки
        $params = Request_RequestParams::setParams(
            array(
                'date_from' => $dateFrom,
                'date_to' => $dateTo,
                'sum_flight' => true,
                'group_by' => array(
                    'shop_ballast_driver_id', 'shop_ballast_driver_id.name',
                    'shop_transportation_place_id', 'shop_transportation_place_id.name',
                ),
                'sort_by' => array(
                    'shop_ballast_driver_id.name' => 'asc',
                    'shop_transportation_place_id.name' => 'asc',
                ),
            )
        );

        $ids = Request_Request::find(
            'DB_Ab1_Shop_Transportation', $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB,
            $params, 0, true,
            array(
                'shop_ballast_driver_id' => array('name'),
                'shop_transportation_place_id' => array('name'),
            )
        );

        $places = array();
        foreach ($ids->childs as $child){
            $driver = $child->values['shop_ballast_driver_id'];
            if(!key_exists($driver, $result['data'])){
                $result['data'][$driver] = array(
                    'name' => $child->getElementValue('shop_ballast_driver_id'),
                    'quantity' => 0,
                    'count' => 0,
                    'crushers' => array(),
                    'places' => array(),
                );
            }

            $place = $child->values['shop_transportation_place_id'];
            if(!key_exists($place, $result['data'][$driver]['places'])){
                $result['data'][$driver]['places'][$place] = array(
                    'name' => $child->getElementValue('shop_transportation_place_id'),
                    'quantity' => 0,
                    'count' => 0,
                    'data' => array(),
                );
                $places[$place] = $child->getElementValue('shop_transportation_place_id');
            }

            $count = $child->values['flight'];
            $result['data'][$driver]['places'][$place]['count'] += $count;
            $result['data'][$driver]['count'] += $count;
            $result['count'] += $count;
        }

        $ids = new MyArray();
        $ids->setIsFind(true);
        $ids->values = $result;
        $ids->additionDatas = array(
            'crushers' => $crushers,
            'places' => $places,
        );

        $ids->childsSortBy(
            Request_RequestParams::getParamArray('sort_by', [],
                array(
                    'crushers'=> 'asc',
                    'places'=> 'asc',
                    'name'=> 'asc',
                )
            ), true, true);
        $result = Helpers_View::getViewObject(
            $ids, new Model_Ab1_Shop_Ballast_Driver(), "_shop/ballast/driver/list/statistics",
            $this->_sitePageData, $this->_driverDB, $this->_sitePageData->shopID, false
        );
        $this->_sitePageData->replaceDatas['view::_shop/ballast/driver/list/statistics'] = $result;

        $this->_putInMain('/main/_shop/ballast/driver/statistics');
    }
}

