<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_Weighted_ShopCarTare extends Controller_Ab1_Weighted_BasicAb1{

    public function __construct(Request $request, Response $response)
    {
        $this->dbObject = 'DB_Ab1_Shop_Car_Tare';
        $this->controllerName = 'shopcartare';
        $this->tableID = Model_Ab1_Shop_Car_Tare::TABLE_ID;
        $this->tableName = Model_Ab1_Shop_Car_Tare::TABLE_NAME;
        $this->objectName = 'cartare';

        parent::__construct($request, $response);
    }

    public function action_index() {
        $this->_sitePageData->url = '/weighted/shopcartare/index';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/car/tare/list/index',
            )
        );

        $this->_requestShopTransports();
        $this->_requestShopTransportCompanies();
        View_View::find('DB_Ab1_Shop_Car_Tare',
            $this->_sitePageData->shopMainID,
            "_shop/car/tare/list/index", "_shop/car/tare/one/index",
            $this->_sitePageData, $this->_driverDB, array('limit' => 1000, 'limit_page' => 25),
            array(
                'shop_transport_company_id' => array('name'),
                'shop_transport_id' => array('name'),
                'shop_client_id' => array('name'),
            )
        );

        $this->_putInMain('/main/_shop/car/tare/index');
    }

    public function action_new()
    {
        $this->_sitePageData->url = '/weighted/shopcartare/new';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/car/tare/one/new',
            )
        );

        if(Request_RequestParams::getParamInt('tare_type_id') != Model_Ab1_TareType::TARE_TYPE_CLIENT){
            $this->_requestShopTransportCompanies();
            $this->_requestShopTransports();
        }

        $dataID = new MyArray();
        $dataID->id = 0;
        $dataID->isFindDB = TRUE;

        $this->_sitePageData->replaceDatas['view::_shop/car/tare/one/new'] = Helpers_View::getViewObject(
            $dataID, new Model_Ab1_Shop_Car_Tare(), '_shop/car/tare/one/new',
            $this->_sitePageData, $this->_driverDB, $this->_sitePageData->shopMainID)
        ;

        $this->_putInMain('/main/_shop/car/tare/new');
    }

    public function action_edit()
    {
        $this->_sitePageData->url = '/weighted/shopcartare/edit';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/car/tare/one/edit',
            )
        );

        // id записи
        $shopCarTareID = Request_RequestParams::getParamInt('id');
        $model = new Model_Ab1_Shop_Car_Tare();
        if (! $this->dublicateObjectLanguage($model, $shopCarTareID, $this->_sitePageData->shopMainID, FALSE)) {
            throw new HTTP_Exception_404('Car tare not is found!');
        }
        if(Request_RequestParams::getParamBoolean('tare_type_id') != Model_Ab1_TareType::TARE_TYPE_CLIENT){
            $this->_requestShopTransportCompanies($model->getShopTransportCompanyID());
            $this->_requestShopTransports($model->getShopTransportID());
        }

        // получаем данные
        View_View::findOne('DB_Ab1_Shop_Car_Tare',
            $this->_sitePageData->shopMainID, "_shop/car/tare/one/edit",
            $this->_sitePageData, $this->_driverDB, array('id' => $shopCarTareID),
            array('shop_client_id' => array('name'))
        );

        $this->_putInMain('/main/_shop/car/tare/edit');
    }

    public function action_save()
    {
        $this->_sitePageData->url = '/weighted/shopcartare/save';

        $result = Api_Ab1_Shop_Car_Tare::save($this->_sitePageData, $this->_driverDB);
        $this->_redirectSaveResult($result, '', ['tare_type_id' => $result['result']['values']['tare_type_id']]);
    }

    public function action_json() {
        $this->_sitePageData->url = '/weighted/shopcartare/json';
        $this->_getJSONList($this->_sitePageData->shopMainID);
    }
}
