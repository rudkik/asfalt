<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Magazine_Accounting_ShopWorker extends Controller_Magazine_Accounting_BasicMagazine {

    public function __construct(Request $request, Response $response)
    {
        $this->dbObject = 'DB_Ab1_Shop_Worker';
        $this->controllerName = 'shopworker';
        $this->tableID = Model_Ab1_Shop_Worker::TABLE_ID;
        $this->tableName = Model_Ab1_Shop_Worker::TABLE_NAME;
        $this->objectName = 'worker';

        parent::__construct($request, $response);
    }
    
    public function action_json() {
        $this->_sitePageData->url = '/accounting/shopworker/json';

        $this->_actionJSON(
            'Request_Magazine_Shop_Worker',
            'findShopWorkerIDs',
            array(
            ),
            new Model_Ab1_Shop_Worker()
        );
    }

    public function action_index() {
        $this->_sitePageData->url = '/accounting/shopworker/index';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/worker/list/index',
            )
        );

        $this->_requestShopBranches();

        // получаем список
        View_View::findBranch('DB_Ab1_Shop_Worker',
            $this->_sitePageData->shopMainID, "_shop/worker/list/index", "_shop/worker/one/index",
            $this->_sitePageData, $this->_driverDB,
            array(
                'limit_page' => 25,
                'shop_id' => Request_RequestParams::getParamInt('shop_branch_id_')
            ),
            array('shop_id' => array('name'))
        );

        $this->_putInMain('/main/_shop/worker/index');
    }

    public function action_new()
    {
        $this->_sitePageData->url = '/accounting/shopworker/new';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/worker/one/new',
            )
        );
        $this->_requestShopBranches();

        $dataID = new MyArray();
        $dataID->id = 0;
        $dataID->isFindDB = TRUE;

        $this->_sitePageData->replaceDatas['view::_shop/worker/one/new'] = Helpers_View::getViewObject(
            $dataID, new Model_Ab1_Shop_Worker(), '_shop/worker/one/new', $this->_sitePageData,
            $this->_driverDB, $this->_sitePageData->shopMainID
        );

        $this->_putInMain('/main/_shop/worker/new');
    }

    public function action_edit()
    {
        $this->_sitePageData->url = '/accounting/shopworker/edit';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/worker/one/edit',
            )
        );

        // id записи
        $id = Request_RequestParams::getParamInt('id');
        $model = new Model_Ab1_Shop_Worker();
        if (! $this->dublicateObjectLanguage($model, $id, 0, FALSE)) {
            throw new HTTP_Exception_404('Worker not is found!');
        }
        $this->_requestShopBranches($model->shopID);

        // получаем данные
        View_View::findOne('DB_Ab1_Shop_Worker',
            0, "_shop/worker/one/edit", $this->_sitePageData, $this->_driverDB,
            array('id' => $id), array()
        );

        $this->_putInMain('/main/_shop/worker/edit');
    }

    public function action_save()
    {
        $this->_sitePageData->url = '/accounting/shopworker/save';

        $result = Api_Ab1_Shop_Worker::save($this->_sitePageData, $this->_driverDB);
        $this->_redirectSaveResult($result);
    }

    public function action_del()
    {
        $this->_sitePageData->url = '/accounting/shopworker/del';
        $result = Api_Ab1_Shop_Worker::delete($this->_sitePageData, $this->_driverDB);
        $this->response->body(Json::json_encode(array('error' => $result)));
    }
}
