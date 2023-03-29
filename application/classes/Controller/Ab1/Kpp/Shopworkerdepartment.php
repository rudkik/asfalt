<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_Kpp_ShopWorkerDepartment extends Controller_Ab1_Kpp_BasicAb1 {

    public function __construct(Request $request, Response $response)
    {
        $this->dbObject = 'DB_Ab1_Shop_Worker_Department';
        $this->controllerName = 'shopworkerdepartment';
        $this->tableID = Model_Ab1_Shop_Worker_Department::TABLE_ID;
        $this->tableName = Model_Ab1_Shop_Worker_Department::TABLE_NAME;
        $this->objectName = 'workerdepartment';

        parent::__construct($request, $response);

        $this->shopID = $this->_sitePageData->shopID;
        $this->editAndNewBasicTemplate = 'ab1/_all';
    }

    public function action_index() {
        $this->_sitePageData->url = '/kpp/shopworkerdepartment/index';

        $this->_requestListDB('DB_Ab1_Shop_Worker_Department');

        parent::_actionIndex(
            array(
                'shop_worker_department_id' => array('name'),
            )
        );
    }

    public function action_new(){
        $this->_sitePageData->url = '/kpp/shopworkerdepartment/new';

        $this->_requestListDB('DB_Ab1_Shop_Worker_Department');

        parent::action_new();
    }

    public function action_edit()
    {
        $this->_sitePageData->url = '/kpp/shopworkerdepartment/edit';

        // id записи
        $id = Request_RequestParams::getParamInt('id');
        $model = new Model_Ab1_Shop_Worker_Department();
        if (! $this->dublicateObjectLanguage($model, $id, $this->_sitePageData->shopMainID, false)) {
            throw new HTTP_Exception_404('Object "' . $this->dbObject . '" not is found!');
        }

        $this->_requestListDB(
            'DB_Ab1_Shop_Worker_Department', $model->getShopWorkerDepartmentID(), 0,
            Request_RequestParams::setParams(
                array(
                    'id_not' => $id,
                )
            )
        );

        $this->_actionEdit($model, $this->_sitePageData->shopMainID);
    }
}

