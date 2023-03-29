<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_Peo_HolidayYear extends Controller_Ab1_Peo_BasicAb1 {

    public function __construct(Request $request, Response $response)
    {
        $this->dbObject = 'DB_Ab1_HolidayYear';
        $this->controllerName = 'holidayyear';
        $this->tableID = Model_Ab1_HolidayYear::TABLE_ID;
        $this->tableName = Model_Ab1_HolidayYear::TABLE_NAME;
        $this->objectName = 'operation';

        parent::__construct($request, $response);
    }

    public function action_index() {
        $this->_sitePageData->url = '/peo/holidayyear/index';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::holiday/year/list/index',
            )
        );

        // получаем список
        View_View::find('DB_Ab1_HolidayYear', 0,
            "holiday/year/list/index", "holiday/year/one/index",
            $this->_sitePageData, $this->_driverDB, array('limit' => 1000, 'limit_page' => 25)
        );

        $this->_putInMain('/main/holiday/year/index');
    }

    public function action_new()
    {
        $this->_sitePageData->url = '/peo/holidayyear/new';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::holiday/year/one/new',
                'view::holiday/list/index',
            )
        );

        $dataID = new MyArray();
        $dataID->id = 0;
        $dataID->isFindDB = TRUE;

        $this->_sitePageData->newShopShablonPath('ab1/_all');
        $this->_sitePageData->replaceDatas['view::holiday/year/one/new'] = Helpers_View::getViewObject(
            $dataID, new Model_Ab1_HolidayYear(),
            'holiday/year/one/new', $this->_sitePageData, $this->_driverDB
        );

        $year = date('Y');

        $dataID = new MyArray();
        $dataID->id = 0;
        $dataID->isFindDB = TRUE;

        // январь
        $tmp = $dataID->addChild(1);
        $tmp->setIsFind(true);
        $tmp->values['year'] = $year;
        $tmp->values['holidays'] = array(
            1 => 'Новый год',
            2 => 'Новый год',
            7 => 'Православное Рождество',
        );

        // февраль
        $tmp = $dataID->addChild(2);
        $tmp->setIsFind(true);
        $tmp->values['year'] = $year;
        $tmp->values['holidays'] = array();

        // март
        $tmp = $dataID->addChild(3);
        $tmp->setIsFind(true);
        $tmp->values['year'] = $year;
        $tmp->values['holidays'] = array(
            8 => 'Международный женский день',
            21 => 'Наурыз мейрамы',
            22 => 'Наурыз мейрамы',
            23 => 'Наурыз мейрамы',
        );

        // апрель
        $tmp = $dataID->addChild(4);
        $tmp->setIsFind(true);
        $tmp->values['year'] = $year;
        $tmp->values['holidays'] = array();

        // май
        $tmp = $dataID->addChild(5);
        $tmp->setIsFind(true);
        $tmp->values['year'] = $year;
        $tmp->values['holidays'] = array(
            1 => 'Праздник единства народа Казахстана',
            7 => 'День защитника Отечества',
            8 => 'День Победы',
        );

        // июнь
        $tmp = $dataID->addChild(6);
        $tmp->setIsFind(true);
        $tmp->values['year'] = $year;
        $tmp->values['holidays'] = array();

        // июль
        $tmp = $dataID->addChild(7);
        $tmp->setIsFind(true);
        $tmp->values['year'] = $year;
        $tmp->values['holidays'] = array(
            6 => 'День Столицы',
        );

        // август
        $tmp = $dataID->addChild(8);
        $tmp->setIsFind(true);
        $tmp->values['year'] = $year;
        $tmp->values['holidays'] = array(
            30 => 'День Конституции РК',
        );

        // сентябрь
        $tmp = $dataID->addChild(9);
        $tmp->setIsFind(true);
        $tmp->values['year'] = $year;
        $tmp->values['holidays'] = array();

        // октябрь
        $tmp = $dataID->addChild(10);
        $tmp->setIsFind(true);
        $tmp->values['year'] = $year;
        $tmp->values['holidays'] = array();

        // ноябрь
        $tmp = $dataID->addChild(11);
        $tmp->setIsFind(true);
        $tmp->values['year'] = $year;
        $tmp->values['holidays'] = array();

        // декабрь
        $tmp = $dataID->addChild(12);
        $tmp->setIsFind(true);
        $tmp->values['year'] = $year;
        $tmp->values['holidays'] = array(
            1 => 'День Первого Президента РК',
            16 => 'День Независимости',
            17 => 'День Независимости',
        );

        $result = Helpers_View::getViewObjects(
            $dataID, new Model_Ab1_Holiday(),
            "holiday/list/index", "holiday/one/index",
            $this->_sitePageData, $this->_driverDB, 0
        );
        $this->_sitePageData->replaceDatas['view::holiday/list/index'] = $result;
        $this->_sitePageData->previousShopShablonPath();

        $this->_putInMain('/main/holiday/year/new');
    }

    public function action_edit()
    {
        $this->_sitePageData->url = '/peo/holidayyear/edit';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::holiday/year/one/edit',
                'view::holiday/list/index',
            )
        );

        // id записи
        $id = Request_RequestParams::getParamInt('id');
        $model = new Model_Ab1_HolidayYear();
        if (! $this->dublicateObjectLanguage($model, $id, -1, false)) {
            throw new HTTP_Exception_404('Holiday year not is found!');
        }

        // получаем данные
        $this->_sitePageData->newShopShablonPath('ab1/_all');

        $params = Request_RequestParams::setParams(
            array(
                'holiday_year_id' => $id
            )
        );
        $ids = Request_Request::findNotShop(
            'DB_Ab1_Holiday', $this->_sitePageData, $this->_driverDB, $params, 0
        );

        $months = new MyArray();
        $months->addChild(1, 0, true)->setIsFind(true)->values =
            array('year' => $model->getYear(), 'holidays' => array(), 'frees' => array());
        $months->addChild(2, 0, true)->setIsFind(true)->values =
            array('year' => $model->getYear(), 'holidays' => array(), 'frees' => array());
        $months->addChild(3, 0, true)->setIsFind(true)->values =
            array('year' => $model->getYear(), 'holidays' => array(), 'frees' => array());
        $months->addChild(4, 0, true)->setIsFind(true)->values =
            array('year' => $model->getYear(), 'holidays' => array(), 'frees' => array());
        $months->addChild(5, 0, true)->setIsFind(true)->values =
            array('year' => $model->getYear(), 'holidays' => array(), 'frees' => array());
        $months->addChild(6, 0, true)->setIsFind(true)->values =
            array('year' => $model->getYear(), 'holidays' => array(), 'frees' => array());
        $months->addChild(7, 0, true)->setIsFind(true)->values =
            array('year' => $model->getYear(), 'holidays' => array(), 'frees' => array());
        $months->addChild(8, 0, true)->setIsFind(true)->values =
            array('year' => $model->getYear(), 'holidays' => array(), 'frees' => array());
        $months->addChild(9, 0, true)->setIsFind(true)->values =
            array('year' => $model->getYear(), 'holidays' => array(), 'frees' => array());
        $months->addChild(10, 0, true)->setIsFind(true)->values =
            array('year' => $model->getYear(), 'holidays' => array(), 'frees' => array());
        $months->addChild(11, 0, true)->setIsFind(true)->values =
            array('year' => $model->getYear(), 'holidays' => array(), 'frees' => array());
        $months->addChild(12, 0, true)->setIsFind(true)->values =
            array('year' => $model->getYear(), 'holidays' => array(), 'frees' => array());

        foreach ($ids->childs as $child){
            $date = $child->values['day'];
            $month = intval(Helpers_DateTime::getMonth($date));

            if(!key_exists($month, $months->childs)){
                continue;
            }

            if($child->values['is_free'] == 1){
                $months->childs[$month]->values['frees'][] = $date;
            }else {
                $months->childs[$month]->values['holidays'][Helpers_DateTime::getDay($date)] = '';
            }
        }

        $this->_sitePageData->replaceDatas['view::holiday/list/index'] = Helpers_View::getViewObjects(
            $months, new Model_Ab1_Holiday(),
            'holiday/list/index', 'holiday/one/index',
            $this->_sitePageData, $this->_driverDB, 0
        );

        View_View::findOne(
            'DB_Ab1_HolidayYear', 0, "holiday/year/one/edit",
            $this->_sitePageData, $this->_driverDB, array('id' => $id)
        );
        $this->_sitePageData->previousShopShablonPath();

        $this->_putInMain('/main/holiday/year/edit');
    }

    public function action_save()
    {
        $this->_sitePageData->url = '/peo/holidayyear/save';

        $result = Api_Ab1_HolidayYear::save($this->_sitePageData, $this->_driverDB);
        $this->_redirectSaveResult($result);
    }
}
