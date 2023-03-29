<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_Admin_ShopWorker extends Controller_Ab1_Admin_BasicAb1 {

    public function __construct(Request $request, Response $response)
    {
        $this->dbObject = 'DB_Ab1_Shop_Worker';
        $this->controllerName = 'shopworker';
        $this->tableID = Model_Ab1_Shop_Worker::TABLE_ID;
        $this->tableName = Model_Ab1_Shop_Worker::TABLE_NAME;
        $this->objectName = 'worker';

        parent::__construct($request, $response);

        $this->shopID = 0;
        $this->editAndNewBasicTemplate = 'ab1/_all';
    }

    public function action_index() {
        $this->_sitePageData->url = '/ab1-admin/shopworker/index';

        $this->_requestListDB('DB_Ab1_Shop_Department', null, -1);

        parent::_actionIndex(
            array(
                'shop_department_id' => array('name'),
                'shop_id' => array('name'),
            )
        );
    }

    public function action_new(){
        $this->_sitePageData->url = '/ab1-admin/shopworker/new';

        $this->_requestListDB('DB_Ab1_Shop_Department', null, -1);
        $this->_requestShopBranches($this->_sitePageData->shopID, true);

        parent::action_new();
    }

    public function action_edit()
    {
        $this->_sitePageData->url = '/ab1-admin/shopworker/edit';

        // id записи
        $id = Request_RequestParams::getParamInt('id');
        $model = new Model_Ab1_Shop_Worker();
        if (! $this->dublicateObjectLanguage($model, $id, 0, false)) {
            throw new HTTP_Exception_404('Object "' . $this->dbObject . '" not is found!');
        }

        $this->_requestListDB('DB_Ab1_Shop_Department', $model->getShopDepartmentID(), $model->shopID);
        $this->_requestShopBranches($model->shopID, true);

        $this->_actionEdit($model, $model->shopID);
    }

    public function action_save()
    {
        $this->_sitePageData->url = '/ab1-admin/shopworker/save';

        $result = Api_Ab1_Shop_Worker::save($this->_sitePageData, $this->_driverDB);
        $this->_redirectSaveResult($result);
    }
}
