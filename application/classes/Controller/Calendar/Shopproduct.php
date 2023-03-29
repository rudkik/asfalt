<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Calendar_ShopProduct extends Controller_Calendar_BasicCalendar {

    public function __construct(Request $request, Response $response)
    {
        $this->controllerName = 'shopproduct';
        $this->tableID = Model_Calendar_Shop_Product::TABLE_ID;
        $this->tableName = Model_Calendar_Shop_Product::TABLE_NAME;
        $this->objectName = 'product';

        parent::__construct($request, $response);
    }

    public function action_index() {
        $this->_sitePageData->url = '/calendar/shopproduct/index';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/product/list/index',
            )
        );

        // получаем список
        View_View::find('DB_Calendar_Shop_Product',
            $this->_sitePageData->shopID, "_shop/product/list/index", "_shop/product/one/index",
            $this->_sitePageData, $this->_driverDB, array('limit_page' => 25)
        );

        $this->_putInMain('/main/_shop/product/index');
    }

    public function action_json() {
        $this->_sitePageData->url = '/calendar/shopproduct/json';

        $this->_actionJSON(
            'Request_Calendar_Shop_Product',
            'find',
            array(),
            array(),
            new Model_Calendar_Shop_Product()
        );
    }

    public function action_new()
    {
        $this->_sitePageData->url = '/calendar/shopproduct/new';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/product/one/new',
            )
        );

        $dataID = new MyArray();
        $dataID->id = 0;
        $dataID->isFindDB = TRUE;

        $this->_sitePageData->replaceDatas['view::_shop/product/one/new'] = Helpers_View::getViewObject(
            $dataID, new Model_Calendar_Shop_Product(),
            '_shop/product/one/new', $this->_sitePageData, $this->_driverDB, $this->_sitePageData->shopID
        );

        $this->_putInMain('/main/_shop/product/new');
    }

    public function action_edit()
    {
        $this->_sitePageData->url = '/calendar/shopproduct/edit';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/product/one/edit',
            )
        );

        // id записи
        $shopProductID = Request_RequestParams::getParamInt('id');
        $model = new Model_Calendar_Shop_Product();
        if (! $this->dublicateObjectLanguage($model, $shopProductID, $this->_sitePageData->shopID, FALSE)) {
            throw new HTTP_Exception_404('Product not is found!');
        }

        // получаем данные
        View_View::findOne('DB_Calendar_Shop_Product', $this->_sitePageData->shopID, "_shop/product/one/edit",
            $this->_sitePageData, $this->_driverDB, array('id' => $shopProductID));

        $this->_putInMain('/main/_shop/product/edit');
    }

    public function action_save()
    {
        $this->_sitePageData->url = '/calendar/shopproduct/save';

        $result = Api_Calendar_Shop_Product::save($this->_sitePageData, $this->_driverDB);
        $this->_redirectSaveResult($result);
    }
}
