<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_Cashbox_ShopCashbox extends Controller_Ab1_Cashbox_BasicAb1
{

    public function __construct(Request $request, Response $response)
    {
        $this->dbObject = 'DB_Ab1_Shop_Cashbox';
        $this->controllerName = 'shopcashbox';
        $this->tableID = Model_Ab1_Shop_Cashbox::TABLE_ID;
        $this->tableName = Model_Ab1_Shop_Cashbox::TABLE_NAME;
        $this->objectName = 'cashbox';

        parent::__construct($request, $response);
    }

    public function action_index()
    {
        $this->_sitePageData->url = '/cashbox/shopcashbox/index';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/cashbox/list/index',
            )
        );

        // получаем список
        View_View::find(
            'DB_Ab1_Shop_Cashbox', 0,
            "_shop/cashbox/list/index", "_shop/cashbox/one/index",
            $this->_sitePageData, $this->_driverDB, array('limit' => 1000, 'limit_page' => 25), array('root_id' => array('name'))
        );

        $this->_putInMain('/main/_shop/cashbox/index');
    }

    public function action_list()
    {
        $this->_sitePageData->url = '/cashbox/shopcashbox/list';

        // получаем список
        $this->response->body(View_View::find('DB_Ab1_Shop_Cashbox', $this->_sitePageData->shopMainID,
            "_shop/cashbox/list/list", "_shop/cashbox/one/list",
            $this->_sitePageData, $this->_driverDB, array('limit_page' => 50)));
    }

    public function action_new()
    {
        $this->_sitePageData->url = '/cashbox/shopcashbox/new';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/cashbox/one/new',
            )
        );

        $dataID = new MyArray();
        $dataID->id = 0;
        $dataID->isFindDB = TRUE;
        $this->_sitePageData->replaceDatas['view::_shop/cashbox/one/new'] = Helpers_View::getViewObject($dataID, new Model_Ab1_Shop_Cashbox(),
            '_shop/cashbox/one/new', $this->_sitePageData, $this->_driverDB, $this->_sitePageData->shopMainID);

        $this->_putInMain('/main/_shop/cashbox/new');
    }

    public function action_edit()
    {
        $this->_sitePageData->url = '/cashbox/shopcashbox/edit';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/cashbox/one/edit',
            )
        );

        // id записи
        $shopCashboxID = Request_RequestParams::getParamInt('id');
        $model = new Model_Ab1_Shop_Cashbox();
        if (!$this->dublicateObjectLanguage($model, $shopCashboxID, $this->_sitePageData->shopMainID, FALSE)) {
            throw new HTTP_Exception_404('Cashbox not is found!');
        }

        // получаем данные
        View_View::findOne('DB_Ab1_Shop_Cashbox', $this->_sitePageData->shopMainID, "_shop/cashbox/one/edit",
            $this->_sitePageData, $this->_driverDB);

        $this->_putInMain('/main/_shop/cashbox/edit');
    }

    public function action_save()
    {
        $this->_sitePageData->url = '/cashbox/shopcashbox/save';

        $result = Api_Ab1_Shop_Cashbox::save($this->_sitePageData, $this->_driverDB);
        $this->_redirectSaveResult($result);
    }

}
