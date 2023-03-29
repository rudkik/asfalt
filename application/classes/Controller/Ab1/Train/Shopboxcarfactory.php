<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_Train_ShopBoxcarFactory extends Controller_Ab1_Train_BasicAb1 {

    public function __construct(Request $request, Response $response)
    {
        $this->dbObject = 'DB_Ab1_Shop_Boxcar_Factory';
        $this->controllerName = 'shopboxcarfactory';
        $this->tableID = Model_Ab1_Shop_Boxcar_Factory::TABLE_ID;
        $this->tableName = Model_Ab1_Shop_Boxcar_Factory::TABLE_NAME;
        $this->objectName = 'boxcarfactory';

        parent::__construct($request, $response);
    }

    public function action_index() {
        $this->_sitePageData->url = '/train/shopboxcarfactory/index';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/boxcar/factory/list/index',
            )
        );

        // получаем список
        View_View::find('DB_Ab1_Shop_Boxcar_Factory', $this->_sitePageData->shopMainID, "_shop/boxcar/factory/list/index",
            "_shop/boxcar/factory/one/index", $this->_sitePageData, $this->_driverDB, array('limit' => 1000, 'limit_page' => 25));

        $this->_putInMain('/main/_shop/boxcar/factory/index');
    }

    public function action_new()
    {
        $this->_sitePageData->url = '/train/shopboxcarfactory/new';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/boxcar/factory/one/new',
            )
        );

        $dataID = new MyArray();
        $dataID->id = 0;
        $dataID->isFindDB = TRUE;

        $this->_sitePageData->replaceDatas['view::_shop/boxcar/factory/one/new'] =
            Helpers_View::getViewObject($dataID, new Model_Ab1_Shop_Boxcar_Factory(), '_shop/boxcar/factory/one/new',
                $this->_sitePageData, $this->_driverDB, $this->_sitePageData->shopMainID);

        $this->_putInMain('/main/_shop/boxcar/factory/new');
    }

    public function action_edit()
    {
        $this->_sitePageData->url = '/train/shopboxcarfactory/edit';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/boxcar/factory/one/edit',
            )
        );

        // id записи
        $id = Request_RequestParams::getParamInt('id');
        $model = new Model_Ab1_Shop_Boxcar_Factory();
        if (! $this->dublicateObjectLanguage($model, $id, $this->_sitePageData->shopMainID, FALSE)) {
            throw new HTTP_Exception_404('Factory boxcar not is found!');
        }

        // получаем данные
        View_View::findOne('DB_Ab1_Shop_Boxcar_Factory', $this->_sitePageData->shopMainID, "_shop/boxcar/factory/one/edit",
            $this->_sitePageData, $this->_driverDB, array('id' => $id), array());

        $this->_putInMain('/main/_shop/boxcar/factory/edit');
    }

    public function action_save()
    {
        $this->_sitePageData->url = '/train/shopboxcarfactory/save';

        $result = Api_Ab1_Shop_Boxcar_Factory::save($this->_sitePageData, $this->_driverDB);
        $this->_redirectSaveResult($result);
    }

    public function action_del()
    {
        $this->_sitePageData->url = '/train/shopboxcarfactory/del';
        $result = Api_Ab1_Shop_Boxcar_Factory::delete($this->_sitePageData, $this->_driverDB);
        $this->response->body(Json::json_encode(array('error' => $result)));
    }
}
