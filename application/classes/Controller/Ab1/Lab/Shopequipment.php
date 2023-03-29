<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_Lab_ShopEquipment extends Controller_Ab1_Lab_BasicAb1 {

    public function __construct(Request $request, Response $response)
    {
        $this->dbObject = 'DB_Ab1_Shop_Equipment';
        $this->controllerName = 'shopequipment';
        $this->tableID = Model_Ab1_Shop_Equipment::TABLE_ID;
        $this->tableName = Model_Ab1_Shop_Equipment::TABLE_NAME;
        $this->objectName = 'equipment';

        parent::__construct($request, $response);

    }

    public function action_index() {
        $this->_sitePageData->url = '/lab/shopequipment/index';

        $this->_requestListDB('DB_Ab1_Shop_Worker_Department');
        $this->_requestListDB('DB_Ab1_Shop_Equipment_State');

        parent::_actionIndex(
            array(
                'shop_worker_department_id' => array('name'),
                'shop_equipment_state_id' => array('name'),
            )
        );
    }

    public function action_new()
    {
        $this->_sitePageData->url = '/lab/shopequipment/new';

        $this->_requestListDB('DB_Ab1_Shop_Worker_Department');
        $this->_requestListDB('DB_Ab1_Shop_Equipment_State');
        parent::_actionNew();
    }

    public function action_edit()
    {
        $this->_sitePageData->url = '/lab/shopequipment/edit';

        // id записи
        $id = Request_RequestParams::getParamInt('id');
        $model = new Model_Ab1_Shop_Equipment();
        if (! $this->dublicateObjectLanguage($model, $id, $this->_sitePageData->shopID, false)) {
            throw new HTTP_Exception_404('Object "' . $this->dbObject . '" not is found!');
        }

        $this->_requestListDB('DB_Ab1_Shop_Worker_Department', $model->getShopWorkerDepartmentID());
        $this->_requestListDB('DB_Ab1_Shop_Equipment_State', $model->getShopEquipmentStateID());

        $this->_actionEdit($model, $this->_sitePageData->shopID);
    }
}

