<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_Atc_ShopTransportDriver extends Controller_Ab1_Atc_BasicAb1 {

    public function __construct(Request $request, Response $response)
    {
        $this->dbObject = 'DB_Ab1_Shop_Transport_Driver';
        $this->controllerName = 'shoptransportdriver';
        $this->tableID = Model_Ab1_Shop_Transport_Driver::TABLE_ID;
        $this->tableName = Model_Ab1_Shop_Transport_Driver::TABLE_NAME;
        $this->objectName = 'transportdriver';

        parent::__construct($request, $response);

        $this->shopID = $this->_sitePageData->shopMainID;
        $this->editAndNewBasicTemplate = 'ab1/_all';
    }

    public function action_index() {
        $this->_sitePageData->url = '/atc/shoptransportdriver/index';

        $this->_requestListDB('DB_Ab1_Shop_Worker');
        $this->_requestListDB('DB_Ab1_Shop_Transport_Class');
        $this->_requestShopBranches(null, true);

        parent::_actionIndex(
            array(
                'shop_worker_id' => array('name'),
                'shop_branch_from_id' => array('name'),
                'shop_transport_class_id' => array('name'),
            )
        );
    }

    public function action_new(){
        $this->_sitePageData->url = '/atc/shoptransportdriver/new';

        $this->_requestListDB('DB_Ab1_Shop_Worker');
        $this->_requestListDB('DB_Ab1_Shop_Transport_Class');

        $this->_requestShopBranches(null, true);

        $this->_actionNew();
    }

    public function action_edit()
    {
        $this->_sitePageData->url = '/atc/shoptransportdriver/edit';

        // id записи
        $id = Request_RequestParams::getParamInt('id');
        $model = new Model_Ab1_Shop_Transport_Driver();
        if (! $this->dublicateObjectLanguage($model, $id, $this->_sitePageData->shopMainID, false)) {
            throw new HTTP_Exception_404('Object "' . $this->dbObject . '" not is found!');
        }

        $this->_requestListDB('DB_Ab1_Shop_Worker', $model->getShopWorkerID());
        $this->_requestListDB('DB_Ab1_Shop_Transport_Class', $model->getShopTransportClassID());
        $this->_requestShopBranches($model->getShopBranchFromID(), true);

        $this->_actionEdit($model, $this->_sitePageData->shopMainID);
    }
}

