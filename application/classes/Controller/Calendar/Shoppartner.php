<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Calendar_ShopPartner extends Controller_Calendar_BasicCalendar {

    public function __construct(Request $request, Response $response)
    {
        $this->controllerName = 'shoppartner';
        $this->tableID = Model_Calendar_Shop_Partner::TABLE_ID;
        $this->tableName = Model_Calendar_Shop_Partner::TABLE_NAME;
        $this->objectName = 'partner';

        parent::__construct($request, $response);
    }

    public function action_index() {
        $this->_sitePageData->url = '/calendar/shoppartner/index';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/partner/list/index',
            )
        );

        // получаем список
        View_View::find('DB_Calendar_Shop_Partner',
            $this->_sitePageData->shopID, "_shop/partner/list/index", "_shop/partner/one/index",
            $this->_sitePageData, $this->_driverDB, array('limit_page' => 25)
        );

        $this->_putInMain('/main/_shop/partner/index');
    }

    public function action_json() {
        $this->_sitePageData->url = '/calendar/unit/json';

        $this->_actionJSON(
            'Request_Calendar_Shop_Partner',
            'find'
        );
    }

    public function action_new()
    {
        $this->_sitePageData->url = '/calendar/shoppartner/new';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/partner/one/new',
            )
        );

        $dataID = new MyArray();
        $dataID->id = 0;
        $dataID->isFindDB = TRUE;

        $this->_sitePageData->replaceDatas['view::_shop/partner/one/new'] = Helpers_View::getViewObject(
            $dataID, new Model_Calendar_Shop_Partner(),
            '_shop/partner/one/new', $this->_sitePageData, $this->_driverDB, $this->_sitePageData->shopID
        );

        $this->_putInMain('/main/_shop/partner/new');
    }

    public function action_edit()
    {
        $this->_sitePageData->url = '/calendar/shoppartner/edit';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/partner/one/edit',
            )
        );

        // id записи
        $shopPartnerID = Request_RequestParams::getParamInt('id');
        $model = new Model_Calendar_Shop_Partner();
        if (! $this->dublicateObjectLanguage($model, $shopPartnerID, $this->_sitePageData->shopID, FALSE)) {
            throw new HTTP_Exception_404('Partner not is found!');
        }

        // получаем данные
        View_View::findOne('DB_Calendar_Shop_Partner', $this->_sitePageData->shopID, "_shop/partner/one/edit",
            $this->_sitePageData, $this->_driverDB, array('id' => $shopPartnerID));

        $this->_putInMain('/main/_shop/partner/edit');
    }

    public function action_save()
    {
        $this->_sitePageData->url = '/calendar/shoppartner/save';

        $result = Api_Calendar_Shop_Partner::save($this->_sitePageData, $this->_driverDB);
        $this->_redirectSaveResult($result);
    }
}
