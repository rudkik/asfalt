<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_Kpp_ShopWorkerMiss extends Controller_Ab1_Kpp_BasicAb1 {

    public function __construct(Request $request, Response $response)
    {
        $this->dbObject = 'DB_Ab1_Shop_Worker_Miss';
        $this->controllerName = 'shopworkermiss';
        $this->tableID = Model_Ab1_Shop_Worker_Miss::TABLE_ID;
        $this->tableName = Model_Ab1_Shop_Worker_Miss::TABLE_NAME;
        $this->objectName = 'workermiss';

        parent::__construct($request, $response);

    }

    public function action_index() {
        $this->_sitePageData->url = '/kpp/shopworkermiss/index';

        $this->_requestListDB('DB_Ab1_Shop_Worker');
        $this->_requestListDB('DB_Ab1_MissType');

        parent::_actionIndex(
            array(
                'shop_worker_id' => array('name'),
            )
        );
    }

    public function action_new()
    {
        $this->_sitePageData->url = '/kpp/shopworkermiss/new';

        $this->_requestListDB('DB_Ab1_Shop_Worker');

        parent::_actionNew();
    }

    public function action_edit()
    {
        $this->_sitePageData->url = '/kpp/shopworkermiss/edit';

        // id записи
        $id = Request_RequestParams::getParamInt('id');
        $model = new Model_Ab1_MissType();
        if (! $this->dublicateObjectLanguage($model, $id, $this->_sitePageData->shopID, false)) {
            throw new HTTP_Exception_404('Object "' . $this->dbObject . '" not is found!');
        }

        $this->_requestListDB('DB_Ab1_Shop_Worker', $model->getShopWorkerID());
        $this->_requestListDB('DB_Ab1_MissType', $model->getMissTypeID());

        $this->_actionEdit($model, $this->_sitePageData->shopID);
    }
}

