<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Nur_Bookkeeping_ShopTask extends Controller_Nur_Bookkeeping_BasicNur {

    public function __construct(Request $request, Response $response)
    {
        $this->controllerName = 'shoptask';
        $this->tableID = Model_Nur_Shop_Task::TABLE_ID;
        $this->tableName = Model_Nur_Shop_Task::TABLE_NAME;
        $this->objectName = 'task';

        parent::__construct($request, $response);
    }

    public function action_index() {
        $this->_sitePageData->url = '/nur-bookkeeping/shoptask/index';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/task/list/index',
            )
        );

        // получаем список
        $params = Request_RequestParams::setParams(
            array(
                'limit_page' => 25,
            ),
            TRUE
        );
        View_View::find('DB_Nur_Shop_Task',
            $this->_sitePageData->shopMainID,
            "_shop/task/list/index", "_shop/task/one/index",
            $this->_sitePageData, $this->_driverDB, $params,
            array('shop_table_rubric_id' => array('name')),
            TRUE, TRUE

        );

        $this->_putInMain('/main/_shop/task/index');
    }

    public function action_json() {
        $this->_sitePageData->url = '/nur-bookkeeping/shopbranch/json';

        $this->_actionJSON(
            'Request_Nur_Shop_Task',
            'findShopTaskIDs',
            array(),
            new Model_Nur_Shop_Task()
        );
    }

    public function action_new()
    {
        $this->_sitePageData->url = '/nur-bookkeeping/shoptask/new';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/task/one/new',
            )
        );

        $dataID = new MyArray();
        $dataID->id = 0;
        $dataID->isFindDB = TRUE;

        $this->_sitePageData->replaceDatas['view::_shop/task/one/new'] = Helpers_View::getViewObject($dataID, new Model_Nur_Shop_Task(),
            '_shop/task/one/new', $this->_sitePageData, $this->_driverDB);

        $this->_putInMain('/main/_shop/task/new');
    }

    public function action_edit()
    {
        $this->_sitePageData->url = '/nur-bookkeeping/shoptask/edit';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/task/one/edit',
            )
        );

        // id записи
        $shopTaskID = Request_RequestParams::getParamInt('id');
        $model = new Model_Nur_Shop_Task();
        if (! $this->dublicateObjectLanguage($model, $shopTaskID, -1, FALSE)) {
            throw new HTTP_Exception_404('Task not is found!');
        }

        // получаем данные
        View_View::find('DB_Nur_Shop_Task', $this->_sitePageData->shopID, "_shop/task/one/edit",
            $this->_sitePageData, $this->_driverDB, array('id' => $shopTaskID), array('shop_table_catalog_id'));

        $this->_putInMain('/main/_shop/task/edit');
    }

    public function action_save()
    {
        $this->_sitePageData->url = '/nur-bookkeeping/shoptask/save';

        $result = Api_Nur_Shop_Task::save($this->_sitePageData, $this->_driverDB);
        $this->_redirectSaveResult($result);
    }
}
