<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_Tunable_ShopClient extends Controller_Ab1_Tunable_BasicAb1 {

    public function __construct(Request $request, Response $response)
    {
        $this->dbObject = 'DB_Ab1_Shop_Client';
        $this->controllerName = 'shopclient';
        $this->tableID = Model_Ab1_Shop_Client::TABLE_ID;
        $this->tableName = Model_Ab1_Shop_Client::TABLE_NAME;
        $this->objectName = 'client';

        parent::__construct($request, $response);
    }

    public function action_json() {
        $this->_sitePageData->url = '/tunable/shopclient/json';
        $this->_getJSONList($this->_sitePageData->shopMainID);
    }

    public function action_index() {
        $this->_sitePageData->url = '/tunable/shopclient/index';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/client/list/index',
            )
        );
        $this->_requestOrganizationTypes();
        $this->_requestKatos();

        // получаем список
        View_View::find('DB_Ab1_Shop_Client', $this->_sitePageData->shopMainID, "_shop/client/list/index", "_shop/client/one/index",
            $this->_sitePageData, $this->_driverDB, array('limit' => 1000, 'limit_page' => 25, 'id_not' => 175747));

        $this->_putInMain('/main/_shop/client/index');
    }

    public function action_new()
    {
        $this->_sitePageData->url = '/tunable/shopclient/new';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/client/one/new',
            )
        );

        $this->_requestOrganizationTypes();
        $this->_requestKatos();

        $dataID = new MyArray();
        $dataID->id = 0;
        $dataID->isFindDB = TRUE;

        $this->_sitePageData->replaceDatas['view::_shop/client/one/new'] = Helpers_View::getViewObject($dataID, new Model_Ab1_Shop_Client(),
            '_shop/client/one/new', $this->_sitePageData, $this->_driverDB, $this->_sitePageData->shopMainID);

        $this->_putInMain('/main/_shop/client/new');
    }

    public function action_edit()
    {
        $this->_sitePageData->url = '/tunable/shopclient/edit';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/client/one/edit',
            )
        );

        // id записи
        $shopClientID = Request_RequestParams::getParamInt('id');
        $model = new Model_Ab1_Shop_Client();
        if (! $this->dublicateObjectLanguage($model, $shopClientID, $this->_sitePageData->shopMainID, FALSE)) {
            throw new HTTP_Exception_404('Client not is found!');
        }

        $this->_requestOrganizationTypes($model->getOrganizationTypeID());
        $this->_requestKatos($model->getKatoID());

        // получаем данные
        View_View::findOne('DB_Ab1_Shop_Client', $this->_sitePageData->shopMainID, "_shop/client/one/edit",
            $this->_sitePageData, $this->_driverDB, array('id' => $shopClientID), array('shop_table_catalog_id'));

        $this->_putInMain('/main/_shop/client/edit');
    }

    public function action_save()
    {
        $this->_sitePageData->url = '/tunable/shopclient/save';

        $result = Api_Ab1_Shop_Client::save($this->_sitePageData, $this->_driverDB);
        $this->_redirectSaveResult($result);
    }

    public function action_del()
    {
        $this->_sitePageData->url = '/tunable/shopclient/del';
        $result = Api_Ab1_Shop_Client::delete($this->_sitePageData, $this->_driverDB);
        $this->response->body(Json::json_encode(array('error' => $result)));
    }
}
