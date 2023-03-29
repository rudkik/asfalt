<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_Tunable_ShopBallastDriver extends Controller_Ab1_Tunable_BasicAb1 {

    public function __construct(Request $request, Response $response)
    {
        $this->dbObject = 'DB_Ab1_Shop_Ballast_Driver';
        $this->controllerName = 'shopballastdriver';
        $this->tableID = Model_Ab1_Shop_Ballast_Driver::TABLE_ID;
        $this->tableName = Model_Ab1_Shop_Ballast_Driver::TABLE_NAME;
        $this->objectName = 'ballastdriver';

        parent::__construct($request, $response);
    }

    public function action_index() {
        $this->_sitePageData->url = '/tunable/shopballastdriver/index';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/ballast/driver/list/index',
            )
        );

        // получаем список
        View_View::find('DB_Ab1_Shop_Ballast_Driver', $this->_sitePageData->shopID, "_shop/ballast/driver/list/index", "_shop/ballast/driver/one/index",
            $this->_sitePageData, $this->_driverDB, array('limit' => 1000, 'limit_page' => 25));

        $this->_putInMain('/main/_shop/ballast/driver/index');
    }

    public function action_new()
    {
        $this->_sitePageData->url = '/tunable/shopballastdriver/new';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/ballast/driver/one/new',
            )
        );

        $dataID = new MyArray();
        $dataID->id = 0;
        $dataID->isFindDB = TRUE;

        $this->_sitePageData->replaceDatas['view::_shop/ballast/driver/one/new'] = Helpers_View::getViewObject($dataID, new Model_Ab1_Shop_Ballast_Driver(),
            '_shop/ballast/driver/one/new', $this->_sitePageData, $this->_driverDB, $this->_sitePageData->shopID);

        $this->_putInMain('/main/_shop/ballast/driver/new');
    }

    public function action_edit()
    {
        $this->_sitePageData->url = '/tunable/shopballastdriver/edit';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/ballast/driver/one/edit',
            )
        );

        // id записи
        $shopBallastDriverID = Request_RequestParams::getParamInt('id');
        if ($shopBallastDriverID === NULL) {
            throw new HTTP_Exception_404('BallastDriver not is found!');
        }else {
            $model = new Model_Ab1_Shop_Ballast_Driver();
            if (! $this->dublicateObjectLanguage($model, $shopBallastDriverID, $this->_sitePageData->shopID)) {
                throw new HTTP_Exception_404('BallastDriver not is found!');
            }
        }
        // получаем данные
        View_View::findOne('DB_Ab1_Shop_Ballast_Driver', $this->_sitePageData->shopID, "_shop/ballast/driver/one/edit",
            $this->_sitePageData, $this->_driverDB, array('id' => $shopBallastDriverID), array('shop_table_catalog_id'));

        $this->_putInMain('/main/_shop/ballast/driver/edit');
    }

    public function action_save()
    {
        $this->_sitePageData->url = '/tunable/shopballastdriver/save';

        $result = Api_Ab1_Shop_Ballast_Driver::save($this->_sitePageData, $this->_driverDB);
        $this->_redirectSaveResult($result);
    }

    public function action_del()
    {
        $this->_sitePageData->url = '/tunable/shopballastdriver/del';
        $result = Api_Ab1_Shop_Ballast_Driver::delete($this->_sitePageData, $this->_driverDB);
        $this->response->body(Json::json_encode(array('error' => $result)));
    }
}
