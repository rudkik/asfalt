<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_Train_ShopBoxcarClient extends Controller_Ab1_Train_BasicAb1 {

    public function __construct(Request $request, Response $response)
    {
        $this->dbObject = 'DB_Ab1_Shop_Boxcar_Client';
        $this->controllerName = 'shopboxcarclient';
        $this->tableID = Model_Ab1_Shop_Boxcar_Client::TABLE_ID;
        $this->tableName = Model_Ab1_Shop_Boxcar_Client::TABLE_NAME;
        $this->objectName = 'boxcarclient';

        parent::__construct($request, $response);
    }

    public function action_index() {
        $this->_sitePageData->url = '/train/shopboxcarclient/index';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/boxcar/client/list/index',
            )
        );

        // получаем список
        View_View::find('DB_Ab1_Shop_Boxcar_Client', $this->_sitePageData->shopMainID, "_shop/boxcar/client/list/index",
            "_shop/boxcar/client/one/index", $this->_sitePageData, $this->_driverDB, array('limit' => 1000, 'limit_page' => 25));

        $this->_putInMain('/main/_shop/boxcar/client/index');
    }

    public function action_new()
    {
        $this->_sitePageData->url = '/train/shopboxcarclient/new';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/boxcar/client/one/new',
            )
        );

        $this->_requestOrganizationTypes();
        $this->_requestKatos();

        $dataID = new MyArray();
        $dataID->id = 0;
        $dataID->isFindDB = TRUE;

        $this->_sitePageData->replaceDatas['view::_shop/boxcar/client/one/new'] =
            Helpers_View::getViewObject($dataID, new Model_Ab1_Shop_Boxcar_Client(), '_shop/boxcar/client/one/new',
                $this->_sitePageData, $this->_driverDB, $this->_sitePageData->shopMainID);

        $this->_putInMain('/main/_shop/boxcar/client/new');
    }

    public function action_edit()
    {
        $this->_sitePageData->url = '/train/shopboxcarclient/edit';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/boxcar/client/one/edit',
            )
        );

        // id записи
        $id = Request_RequestParams::getParamInt('id');
        $model = new Model_Ab1_Shop_Boxcar_Client();
        if (! $this->dublicateObjectLanguage($model, $id, $this->_sitePageData->shopMainID, FALSE)) {
            throw new HTTP_Exception_404('Client boxcar not is found!');
        }

        $this->_requestOrganizationTypes($model->getOrganizationTypeID());
        $this->_requestKatos($model->getKatoID());

        // получаем данные
        View_View::findOne('DB_Ab1_Shop_Boxcar_Client', $this->_sitePageData->shopMainID, "_shop/boxcar/client/one/edit",
            $this->_sitePageData, $this->_driverDB, array('id' => $id), array());

        $this->_putInMain('/main/_shop/boxcar/client/edit');
    }

    public function action_save()
    {
        $this->_sitePageData->url = '/train/shopboxcarclient/save';

        $result = Api_Ab1_Shop_Boxcar_Client::save($this->_sitePageData, $this->_driverDB);
        $this->_redirectSaveResult($result);
    }

    public function action_del()
    {
        $this->_sitePageData->url = '/train/shopboxcarclient/del';
        $result = Api_Ab1_Shop_Boxcar_Client::delete($this->_sitePageData, $this->_driverDB);
        $this->response->body(Json::json_encode(array('error' => $result)));
    }
}
