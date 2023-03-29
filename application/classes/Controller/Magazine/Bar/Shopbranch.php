<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Magazine_Bar_ShopBranch extends Controller_Magazine_Bar_BasicMagazine {

    public function __construct(Request $request, Response $response)
    {
        $this->dbObject = 'DB_Shop';
        $this->controllerName = 'shopbranch';
        $this->tableID = Model_Shop::TABLE_ID;
        $this->tableName = Model_Shop::TABLE_NAME;
        $this->objectName = 'branch';

        parent::__construct($request, $response);
    }

    public function action_index() {
        $this->_sitePageData->url = '/bar/shopbranch/index';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/branch/list/index',
            )
        );

        // получаем список
        View_View::find('DB_Shop',
            $this->_sitePageData->shopMainID, "_shop/branch/list/index", "_shop/branch/one/index",
            $this->_sitePageData, $this->_driverDB, array('limit_page' => 25)
        );

        $this->_putInMain('/main/_shop/branch/index');
    }

    public function action_new()
    {
        $this->_sitePageData->url = '/bar/shopbranch/new';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/branch/one/new',
            )
        );

        $dataID = new MyArray();
        $dataID->id = 0;
        $dataID->isFindDB = TRUE;

        $this->_sitePageData->replaceDatas['view::_shop/branch/one/new'] = Helpers_View::getViewObject(
            $dataID, new Model_Shop(), '_shop/branch/one/new', $this->_sitePageData,
            $this->_driverDB, $this->_sitePageData->shopMainID
        );

        $this->_putInMain('/main/_shop/branch/new');
    }

    public function action_edit()
    {
        $this->_sitePageData->url = '/bar/shopbranch/edit';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/branch/one/edit',
            )
        );

        // id записи
        $id = Request_RequestParams::getParamInt('id');
        $model = new Model_Shop();
        if (! $this->dublicateObjectLanguage($model, $id, $this->_sitePageData->shopMainID, FALSE)) {
            throw new HTTP_Exception_404('Branch not is found!');
        }

        // получаем данные
        View_Shop::getShopBranch(
            $this->_sitePageData->shopMainID, "_shop/branch/one/edit", $this->_sitePageData, $this->_driverDB,
            array('id' => $id), array()
        );

        $this->_putInMain('/main/_shop/branch/edit');
    }

    public function action_save()
    {
        $this->_sitePageData->url = '/bar/shopbranch/save';

        $result = Api_Magazine_Shop_Branch::save($this->_sitePageData, $this->_driverDB);
        $this->_redirectSaveResult($result);
    }

    public function action_del()
    {
        $this->_sitePageData->url = '/bar/shopbranch/del';
        $result = Api_Magazine_Shop_Branch::delete($this->_sitePageData, $this->_driverDB);
        $this->response->body(Json::json_encode(array('error' => $result)));
    }
}
