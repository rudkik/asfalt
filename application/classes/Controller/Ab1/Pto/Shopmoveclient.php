<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_Pto_ShopMoveClient extends Controller_Ab1_Pto_BasicAb1 {

    public function __construct(Request $request, Response $response)
    {
        $this->dbObject = 'DB_Ab1_Shop_Move_Client';
        $this->controllerName = 'shopmoveclient';
        $this->tableID = Model_Ab1_Shop_Move_Client::TABLE_ID;
        $this->tableName = Model_Ab1_Shop_Move_Client::TABLE_NAME;
        $this->objectName = 'moveclient';

        parent::__construct($request, $response);
    }

    public function action_json() {
        $this->_sitePageData->url = '/pto/shopmoveclient/json';
        $this->_getJSONList($this->_sitePageData->shopMainID);
    }

    public function action_index() {
        $this->_sitePageData->url = '/pto/shopmoveclient/index';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/move/client/list/index',
            )
        );

        // получаем список
        View_View::find('DB_Ab1_Shop_Move_Client', $this->_sitePageData->shopMainID, "_shop/move/client/list/index", "_shop/move/client/one/index",
            $this->_sitePageData, $this->_driverDB, array('limit' => 1000, 'limit_page' => 25));

        $this->_putInMain('/main/_shop/move/client/index');
    }

    public function action_new()
    {
        $this->_sitePageData->url = '/pto/shopmoveclient/new';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/move/client/one/new',
            )
        );

        $this->_requestOrganizationTypes();

        $dataID = new MyArray();
        $dataID->id = 0;
        $dataID->isFindDB = TRUE;

        $this->_sitePageData->replaceDatas['view::_shop/move/client/one/new'] = Helpers_View::getViewObject($dataID, new Model_Ab1_Shop_Move_Client(),
            '_shop/move/client/one/new', $this->_sitePageData, $this->_driverDB, $this->_sitePageData->shopMainID);

        $this->_putInMain('/main/_shop/move/client/new');
    }

    public function action_edit()
    {
        $this->_sitePageData->url = '/pto/shopmoveclient/edit';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/move/client/one/edit',
            )
        );

        // id записи
        $shopMoveClientID = Request_RequestParams::getParamInt('id');
        if ($shopMoveClientID === NULL) {
            throw new HTTP_Exception_404('Client not is found!');
        }else {
            $model = new Model_Ab1_Shop_Move_Client();
            if (! $this->dublicateObjectLanguage($model, $shopMoveClientID, $this->_sitePageData->shopMainID)) {
                throw new HTTP_Exception_404('Client not is found!');
            }
        }

        $this->_requestOrganizationTypes($model->getOrganizationTypeID());

        // получаем данные
        View_View::findOne('DB_Ab1_Shop_Move_Client', $this->_sitePageData->shopMainID, "_shop/move/client/one/edit",
            $this->_sitePageData, $this->_driverDB, array('id' => $shopMoveClientID), array('shop_table_catalog_id'));

        $this->_putInMain('/main/_shop/move/client/edit');
    }

    public function action_save()
    {
        $this->_sitePageData->url = '/pto/shopmoveclient/save';

        $result = Api_Ab1_Shop_Move_Client::save($this->_sitePageData, $this->_driverDB);
        $this->_redirectSaveResult($result);
    }

    public function action_statistics()
    {
        $this->_sitePageData->url = '/pto/shopmoveclient/statistics';
        $this->_actionShopMoveClientStatistics();
    }
}
