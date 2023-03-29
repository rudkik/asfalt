<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_Admin_ShopCard extends Controller_Ab1_Admin_BasicAb1 {

    public function __construct(Request $request, Response $response)
    {
        $this->dbObject = 'DB_Magazine_Shop_Card';
        $this->controllerName = 'shopcard';
        $this->tableID = Model_Magazine_Shop_Card::TABLE_ID;
        $this->tableName = Model_Magazine_Shop_Card::TABLE_NAME;
        $this->objectName = 'card';

        parent::__construct($request, $response);

        $this->shopID = 0;
        $this->editAndNewBasicTemplate = 'ab1/_all';
    }

    public function action_index() {
        $this->_sitePageData->url = '/ab1-admin/shopcard/index';

        $this->_requestListDB('DB_Ab1_Shop_Worker');
        parent::_actionIndex(
            array(
                'shop_worker_id' => array('name'),
            )
        );
    }

    public function action_new()
    {
        $this->_sitePageData->url = '/ab1-admin/shopcard/new';

        $this->_requestListDB('DB_Ab1_Shop_Worker');

        parent::_actionNew();
    }

    public function action_edit()
    {
        $this->_sitePageData->url = '/ab1-admin/shopcard/edit';

        // id записи
        $id = Request_RequestParams::getParamInt('id');
        $model = new Model_Magazine_Shop_Card();
        if (! $this->dublicateObjectLanguage($model, $id, 0, false)) {
            throw new HTTP_Exception_404('Object "' . $this->dbObject . '" not is found!');
        }

        $this->_requestListDB('DB_Ab1_Shop_Worker', $model->getShopWorkerID());

        $this->_actionEdit($model, $model->shopID);
    }
}

