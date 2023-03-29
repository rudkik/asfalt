<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Magazine_Bar_ShopConsumable extends Controller_Magazine_Bar_BasicMagazine
{
    public function __construct(Request $request, Response $response)
    {
        $this->dbObject = 'DB_Magazine_Shop_Consumable';
        $this->controllerName = 'shopconsumable';
        $this->tableID = Model_Magazine_Shop_Consumable::TABLE_ID;
        $this->tableName = Model_Magazine_Shop_Consumable::TABLE_NAME;
        $this->objectName = 'consumable';

        parent::__construct($request, $response);
    }

    public function action_index()
    {
        $this->_sitePageData->url = '/bar/shopconsumable/index';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/consumable/list/index',
            )
        );

        // получаем список
        View_View::find('DB_Magazine_Shop_Consumable',
            $this->_sitePageData->shopID, "_shop/consumable/list/index", "_shop/consumable/one/index",
            $this->_sitePageData, $this->_driverDB, array('limit_page' => 25), array()
        );

        $this->_putInMain('/main/_shop/consumable/index');
    }

    public function action_list()
    {
        $this->_sitePageData->url = '/bar/shopconsumable/list';

        // получаем список
        $this->response->body(View_View::find('DB_Magazine_Shop_Consumable', $this->_sitePageData->shopID,
            "_shop/consumable/list/list", "_shop/consumable/one/list",
            $this->_sitePageData, $this->_driverDB, array('limit_page' => 50)));
    }

    public function action_new()
    {
        $this->_sitePageData->url = '/bar/shopconsumable/new';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/consumable/one/new',
            )
        );

        $dataID = new MyArray();
        $dataID->id = 0;
        $dataID->isFindDB = TRUE;
        $this->_sitePageData->replaceDatas['view::_shop/consumable/one/new'] = Helpers_View::getViewObject(
            $dataID, new Model_Magazine_Shop_Consumable(),
            '_shop/consumable/one/new', $this->_sitePageData, $this->_driverDB
        );

        $this->_putInMain('/main/_shop/consumable/new');
    }

    public function action_edit()
    {
        $this->_sitePageData->url = '/bar/shopconsumable/edit';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/consumable/one/edit',
            )
        );

        // id записи
        $id = Request_RequestParams::getParamInt('id');
        $model = new Model_Magazine_Shop_Consumable();
        if (!$this->dublicateObjectLanguage($model, $id, -1, FALSE)) {
            throw new HTTP_Exception_404('Consumable not is found!');
        }

        // получаем данные
        View_View::findOne('DB_Magazine_Shop_Consumable', $this->_sitePageData->shopID, "_shop/consumable/one/edit",
            $this->_sitePageData, $this->_driverDB, array('id' => $id), array('shop_client_id'));

        $this->_putInMain('/main/_shop/consumable/edit');
    }

    public function action_save()
    {
        $this->_sitePageData->url = '/bar/shopconsumable/save';

        $result = Api_Magazine_Shop_Consumable::save($this->_sitePageData, $this->_driverDB);
        $this->_redirectSaveResult($result);
    }
}
