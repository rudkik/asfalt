<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Magazine_Accounting_ShopWorkerLimit extends Controller_Magazine_Accounting_BasicMagazine {

    public function __construct(Request $request, Response $response)
    {
        $this->dbObject = 'DB_Magazine_Shop_Worker_Limit';
        $this->controllerName = 'shopworkerlimit';
        $this->tableID = Model_Magazine_Shop_Worker_Limit::TABLE_ID;
        $this->tableName = Model_Magazine_Shop_Worker_Limit::TABLE_NAME;
        $this->objectName = 'production';

        parent::__construct($request, $response);
    }

    public function action_index() {
        $this->_sitePageData->url = '/accounting/shopworkerlimit/index';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/worker/limit/list/index',
            )
        );

        $this->_requestShopWorkers();

        // получаем список
        View_View::find('DB_Magazine_Shop_Worker_Limit',
            $this->_sitePageData->shopMainID, "_shop/worker/limit/list/index", "_shop/worker/limit/one/index",
            $this->_sitePageData, $this->_driverDB, array('limit_page' => 25),
            array(
                'shop_worker_id' => array('name'),
            )
        );

        $this->_putInMain('/main/_shop/worker/limit/index');
    }

    public function action_new()
    {
        $this->_sitePageData->url = '/accounting/shopworkerlimit/new';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/worker/limit/one/new',
            )
        );

        $this->_requestShopWorkers();

        $dataID = new MyArray();
        $dataID->id = 0;
        $dataID->isFindDB = TRUE;

        $this->_sitePageData->replaceDatas['view::_shop/worker/limit/one/new'] = Helpers_View::getViewObject(
            $dataID, new Model_Magazine_Shop_Worker_Limit(),
            '_shop/worker/limit/one/new', $this->_sitePageData, $this->_driverDB, $this->_sitePageData->shopMainID
        );

        $this->_putInMain('/main/_shop/worker/limit/new');
    }

    public function action_edit()
    {
        $this->_sitePageData->url = '/accounting/shopworkerlimit/edit';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/worker/limit/one/edit',
                'view::_shop/worker/limit/item/list/index',
            )
        );

        // id записи
        $id = Request_RequestParams::getParamInt('id');
        $model = new Model_Magazine_Shop_Worker_Limit();
        if (! $this->dublicateObjectLanguage($model, $id, $this->_sitePageData->shopMainID, FALSE)) {
            throw new HTTP_Exception_404('WorkerLimit not is found!');
        }

        $this->_requestShopWorkers($model->getShopWorkerID());

        // получаем данные
        View_View::findOne('DB_Magazine_Shop_Worker_Limit', $this->_sitePageData->shopMainID, "_shop/worker/limit/one/edit",
            $this->_sitePageData, $this->_driverDB, array('id' => $id));

        $this->_putInMain('/main/_shop/worker/limit/edit');
    }

    public function action_save()
    {
        $this->_sitePageData->url = '/accounting/shopworkerlimit/save';

        $result = Api_Magazine_Shop_Worker_Limit::save($this->_sitePageData, $this->_driverDB);
        $this->_redirectSaveResult($result);
    }

    public function action_del()
    {
        $this->_sitePageData->url = '/accounting/shopworkerlimit/del';
        $result = Api_Magazine_Shop_Worker_Limit::delete($this->_sitePageData, $this->_driverDB);
        $this->response->body(Json::json_encode(array('error' => $result)));
    }
}
