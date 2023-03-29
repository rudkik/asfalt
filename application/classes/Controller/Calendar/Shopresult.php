<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Calendar_ShopResult extends Controller_Calendar_BasicCalendar {

    public function __construct(Request $request, Response $response)
    {
        $this->controllerName = 'shopresult';
        $this->tableID = Model_Calendar_Shop_Result::TABLE_ID;
        $this->tableName = Model_Calendar_Shop_Result::TABLE_NAME;
        $this->objectName = 'result';

        parent::__construct($request, $response);
    }

    public function action_index() {
        $this->_sitePageData->url = '/calendar/shopresult/index';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/result/list/index',
            )
        );

        // получаем список
        View_View::find('DB_Calendar_Shop_Result',
            $this->_sitePageData->shopID, "_shop/result/list/index", "_shop/result/one/index",
            $this->_sitePageData, $this->_driverDB, array('limit_page' => 25)
        );

        $this->_putInMain('/main/_shop/result/index');
    }

    public function action_json() {
        $this->_sitePageData->url = '/calendar/unit/json';

        $this->_actionJSON(
            'Request_Calendar_Shop_Result',
            'find'
        );
    }

    public function action_new()
    {
        $this->_sitePageData->url = '/calendar/shopresult/new';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/result/one/new',
            )
        );

        $dataID = new MyArray();
        $dataID->id = 0;
        $dataID->isFindDB = TRUE;

        $this->_sitePageData->replaceDatas['view::_shop/result/one/new'] = Helpers_View::getViewObject(
            $dataID, new Model_Calendar_Shop_Result(),
            '_shop/result/one/new', $this->_sitePageData, $this->_driverDB, $this->_sitePageData->shopID
        );

        $this->_putInMain('/main/_shop/result/new');
    }

    public function action_edit()
    {
        $this->_sitePageData->url = '/calendar/shopresult/edit';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/result/one/edit',
            )
        );

        // id записи
        $shopResultID = Request_RequestParams::getParamInt('id');
        $model = new Model_Calendar_Shop_Result();
        if (! $this->dublicateObjectLanguage($model, $shopResultID, $this->_sitePageData->shopID, FALSE)) {
            throw new HTTP_Exception_404('Result not is found!');
        }

        // получаем данные
        View_View::findOne('DB_Calendar_Shop_Result', $this->_sitePageData->shopID, "_shop/result/one/edit",
            $this->_sitePageData, $this->_driverDB, array('id' => $shopResultID));

        $this->_putInMain('/main/_shop/result/edit');
    }

    public function action_save()
    {
        $this->_sitePageData->url = '/calendar/shopresult/save';

        $result = Api_Calendar_Shop_Result::save($this->_sitePageData, $this->_driverDB);
        $this->_redirectSaveResult($result);
    }
}
