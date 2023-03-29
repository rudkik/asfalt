<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_Kpp_ShopWorkerAccess extends Controller_Ab1_Kpp_BasicAb1 {

    public function __construct(Request $request, Response $response)
    {
        $this->dbObject = 'DB_Ab1_Shop_Worker_Access';
        $this->controllerName = 'shopworkeraccess';
        $this->tableID = Model_Ab1_Shop_Worker_Access::TABLE_ID;
        $this->tableName = Model_Ab1_Shop_Worker_Access::TABLE_NAME;
        $this->objectName = 'workeraccess';

        parent::__construct($request, $response);

    }

    public function action_index() {
        $this->_sitePageData->url = '/kpp/shopworkeraccess/index';

        $this->_requestListDB('DB_Ab1_Shop_Worker' );
        $this->_requestListDB('DB_Magazine_Shop_Card', NULL,  0, array(), null, 'list', 'number');
        $this->_requestListDB(DB_Ab1_Shop_Department::NAME);
        parent::_actionIndex(
            array(
                'shop_worker_id' => array('name'),
                'shop_worker_id.shop_department_id' => array('name'),
                'shop_card_id' => array('number'),
            ),
            [
                'sort_by' => ['updated_at' => 'desc']
            ]

        );
    }

    public function action_new()
    {
        $this->_sitePageData->url = '/kpp/shopworkeraccess/new';

        $this->_requestListDB('DB_Ab1_Shop_Worker');
        $this->_requestListDB('DB_Magazine_Shop_Card', NULL,  0, array(), null, 'list', 'number');

        parent::_actionNew();
    }

    public function action_edit()
    {
        $this->_sitePageData->url = '/kpp/shopworkeraccess/edit';

        // id записи
        $id = Request_RequestParams::getParamInt('id');
        $model = new Model_Ab1_Shop_Worker_Access();
        if (! $this->dublicateObjectLanguage($model, $id, $this->_sitePageData->shopID, false)) {
            throw new HTTP_Exception_404('Object "' . $this->dbObject . '" not is found!');
        }

        $this->_requestListDB('DB_Ab1_Shop_Worker', $model->getShopWorkerID());
        $this->_requestListDB('DB_Magazine_Shop_Card', $model->getShopCardID(),0, array(), null, 'list', 'number');

        $this->_actionEdit($model, $this->_sitePageData->shopID);
    }
}

