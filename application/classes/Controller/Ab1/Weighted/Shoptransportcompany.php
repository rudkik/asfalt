<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_Weighted_ShopTransportCompany extends Controller_Ab1_Weighted_BasicAb1{

    public function __construct(Request $request, Response $response)
    {
        $this->dbObject = 'DB_Ab1_Shop_Transport_Company';
        $this->controllerName = 'shoptransportcompany';
        $this->tableID = Model_Ab1_Shop_Transport_Company::TABLE_ID;
        $this->tableName = Model_Ab1_Shop_Transport_Company::TABLE_NAME;
        $this->objectName = 'transportcompany';

        parent::__construct($request, $response);
    }

    public function action_json() {
        $this->_sitePageData->url = '/weighted/shoptransportcompany/json';
        $this->_getJSONList($this->_sitePageData->shopMainID);
    }

    public function action_index() {
        $this->_sitePageData->url = '/weighted/shoptransportcompany/index';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/transport/company/list/index',
            )
        );

        // получаем список
        View_View::find('DB_Ab1_Shop_Transport_Company', $this->_sitePageData->shopMainID, "_shop/transport/company/list/index", "_shop/transport/company/one/index",
            $this->_sitePageData, $this->_driverDB, array('is_main_shop' => FALSE, 'limit' => 1000, 'limit_page' => 25));

        $this->_putInMain('/main/_shop/transport/company/index');
    }

    public function action_new()
    {
        $this->_sitePageData->url = '/weighted/shoptransportcompany/new';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/transport/company/one/new',
            )
        );
        $dataID = new MyArray();
        $dataID->id = 0;
        $dataID->isFindDB = TRUE;

        $this->_sitePageData->replaceDatas['view::_shop/transport/company/one/new'] = Helpers_View::getViewObject($dataID, new Model_Ab1_Shop_Transport_Company(),
            '_shop/transport/company/one/new', $this->_sitePageData, $this->_driverDB, $this->_sitePageData->shopMainID);

        $this->_putInMain('/main/_shop/transport/company/new');
    }

    public function action_edit()
    {
        $this->_sitePageData->url = '/weighted/shoptransportcompany/edit';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/transport/company/one/edit',
            )
        );

        // id записи
        $shopTransportCompanyID = Request_RequestParams::getParamInt('id');
        if ($shopTransportCompanyID === NULL) {
            throw new HTTP_Exception_404('Transport company not is found!');
        }else {
            $model = new Model_Ab1_Shop_Transport_Company();
            if (! $this->dublicateObjectLanguage($model, $shopTransportCompanyID, $this->_sitePageData->shopMainID)) {
                throw new HTTP_Exception_404('Transport company not is found!');
            }
        }

        // получаем данные
        View_View::findOne('DB_Ab1_Shop_Transport_Company', $this->_sitePageData->shopMainID, "_shop/transport/company/one/edit",
            $this->_sitePageData, $this->_driverDB, array('id' => $shopTransportCompanyID), array('shop_table_catalog_id'));

        $this->_putInMain('/main/_shop/transport/company/edit');
    }

    public function action_save()
    {
        $this->_sitePageData->url = '/weighted/shoptransportcompany/save';

        $result = Api_Ab1_Shop_Transport_Company::save($this->_sitePageData, $this->_driverDB);
        $this->_redirectSaveResult($result);
    }
}
