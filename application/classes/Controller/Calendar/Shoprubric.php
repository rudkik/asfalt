<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Calendar_ShopRubric extends Controller_Calendar_BasicCalendar {

    public function __construct(Request $request, Response $response)
    {
        $this->controllerName = 'shoprubric';
        $this->tableID = Model_Calendar_Shop_Rubric::TABLE_ID;
        $this->tableName = Model_Calendar_Shop_Rubric::TABLE_NAME;
        $this->objectName = 'rubric';

        parent::__construct($request, $response);
    }

    public function action_index() {
        $this->_sitePageData->url = '/calendar/shoprubric/index';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/rubric/list/index',
            )
        );

        // получаем список
        View_View::find('DB_Calendar_Shop_Rubric',
            $this->_sitePageData->shopID, "_shop/rubric/list/index", "_shop/rubric/one/index",
            $this->_sitePageData, $this->_driverDB, array('limit_page' => 25)
        );

        $this->_putInMain('/main/_shop/rubric/index');
    }

    public function action_json() {
        $this->_sitePageData->url = '/calendar/unit/json';

        $this->_actionJSON(
            'Request_Calendar_Shop_Rubric',
            'find'
        );
    }

    public function action_new()
    {
        $this->_sitePageData->url = '/calendar/shoprubric/new';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/rubric/one/new',
            )
        );

        $dataID = new MyArray();
        $dataID->id = 0;
        $dataID->isFindDB = TRUE;

        $this->_sitePageData->replaceDatas['view::_shop/rubric/one/new'] = Helpers_View::getViewObject(
            $dataID, new Model_Calendar_Shop_Rubric(),
            '_shop/rubric/one/new', $this->_sitePageData, $this->_driverDB, $this->_sitePageData->shopID
        );

        $this->_putInMain('/main/_shop/rubric/new');
    }

    public function action_edit()
    {
        $this->_sitePageData->url = '/calendar/shoprubric/edit';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/rubric/one/edit',
            )
        );

        // id записи
        $shopRubricID = Request_RequestParams::getParamInt('id');
        $model = new Model_Calendar_Shop_Rubric();
        if (! $this->dublicateObjectLanguage($model, $shopRubricID, $this->_sitePageData->shopID, FALSE)) {
            throw new HTTP_Exception_404('Rubric not is found!');
        }

        // получаем данные
        View_View::findOne('DB_Calendar_Shop_Rubric', $this->_sitePageData->shopID, "_shop/rubric/one/edit",
            $this->_sitePageData, $this->_driverDB, array('id' => $shopRubricID));

        $this->_putInMain('/main/_shop/rubric/edit');
    }

    public function action_save()
    {
        $this->_sitePageData->url = '/calendar/shoprubric/save';

        $result = Api_Calendar_Shop_Rubric::save($this->_sitePageData, $this->_driverDB);
        $this->_redirectSaveResult($result);
    }
}
