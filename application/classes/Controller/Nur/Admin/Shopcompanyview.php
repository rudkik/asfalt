<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Nur_Admin_ShopCompanyView extends Controller_Nur_Admin_BasicNur {

    public function __construct(Request $request, Response $response)
    {
        $this->controllerName = 'shopcompanyview';
        $this->tableID = Model_Nur_Shop_Company_View::TABLE_ID;
        $this->tableName = Model_Nur_Shop_Company_View::TABLE_NAME;
        $this->objectName = 'companyview';

        parent::__construct($request, $response);
    }

    public function action_index() {
        $this->_sitePageData->url = '/nur-admin/shopcompanyview/index';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/company/view/list/index',
            )
        );

        // получаем список
        $params = Request_RequestParams::setParams(
            array(
                'limit_page' => 25,
            ),
            TRUE
        );
        View_View::find('DB_Nur_Shop_Company_View',
            $this->_sitePageData->shopMainID,
            "_shop/company/view/list/index", "_shop/company/view/one/index",
            $this->_sitePageData, $this->_driverDB, $params,
            array(),
            TRUE, TRUE

        );

        $this->_putInMain('/main/_shop/company/view/index');
    }

    public function action_json() {
        $this->_sitePageData->url = '/nur-admin/shopcompanyview/json';

        $this->_actionJSON(
            'Request_Nur_Shop_Company_View',
            'findShopCompanyViewIDs',
            array(),
            new Model_Nur_Shop_Company_View()
        );
    }

    public function action_new()
    {
        $this->_sitePageData->url = '/nur-admin/shopcompanyview/new';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/company/view/one/new',
            )
        );

        $dataID = new MyArray();
        $dataID->id = 0;
        $dataID->isFindDB = TRUE;

        $this->_sitePageData->replaceDatas['view::_shop/company/view/one/new'] = Helpers_View::getViewObject($dataID, new Model_Nur_Shop_Company_View(),
            '_shop/company/view/one/new', $this->_sitePageData, $this->_driverDB);

        $this->_putInMain('/main/_shop/company/view/new');
    }

    public function action_edit()
    {
        $this->_sitePageData->url = '/nur-admin/shopcompanyview/edit';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/company/view/one/edit',
            )
        );

        // id записи
        $id = Request_RequestParams::getParamInt('id');
        $model = new Model_Nur_Shop_Company_View();
        if (! $this->dublicateObjectLanguage($model, $id, -1, FALSE)) {
            throw new HTTP_Exception_404('Company view not is found!');
        }

        // получаем данные
        View_View::findOne('DB_Nur_Shop_Company_View', $this->_sitePageData->shopID, "_shop/company/view/one/edit",
            $this->_sitePageData, $this->_driverDB, array('id' => $id), array('shop_table_catalog_id'));

        $this->_putInMain('/main/_shop/company/view/edit');
    }

    public function action_save()
    {
        $this->_sitePageData->url = '/nur-admin/shopcompanyview/save';

        $result = Api_Nur_Shop_Company_View::save($this->_sitePageData, $this->_driverDB);
        $this->_redirectSaveResult($result);
    }
}
