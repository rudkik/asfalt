<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_Atc_ShopTransportFuelExpense extends Controller_Ab1_Atc_BasicAb1 {

    public function __construct(Request $request, Response $response)
    {
        $this->dbObject = 'DB_Ab1_Shop_Transport_Fuel_Expense';
        $this->controllerName = 'shoptransportfuelexpense';
        $this->tableID = Model_Ab1_Shop_Transport_Fuel_Expense::TABLE_ID;
        $this->tableName = Model_Ab1_Shop_Transport_Fuel_Expense::TABLE_NAME;
        $this->objectName = 'transportfuelexpense';

        parent::__construct($request, $response);

        $this->shopID = $this->_sitePageData->shopID;
        $this->editAndNewBasicTemplate = 'ab1/_all';
    }

    public function action_index() {
        $this->_sitePageData->url = '/atc/shoptransportfuelexpense/index';

        $this->_requestListDB('DB_Ab1_Shop_Transport_Mark');
        $this->_requestListDB('DB_Ab1_Fuel');
        $this->_requestListDB('DB_Ab1_Shop_Move_Client');

        $this->_actionIndex(
            array(
                'shop_move_client_id' => array('name'),
                'shop_transport_mark_id' => array('name'),
                'fuel_id' => array('name'),
            )
        );
    }

    public function action_new() {
        $this->_requestListDB('DB_Ab1_Shop_Transport_Mark');
        $this->_requestListDB('DB_Ab1_Fuel');
        $this->_requestListDB('DB_Ab1_Shop_Move_Client');
        $this->_actionNew();
    }

    public function action_edit() {
        $this->_sitePageData->url = '/atc/shoptransportfuelexpense/edit';

        // id записи
        $id = Request_RequestParams::getParamInt('id');
        $model = new Model_Ab1_Shop_Transport_Fuel_Expense();
        if (! $this->dublicateObjectLanguage($model, $id, $this->_sitePageData->shopID, false)) {
            throw new HTTP_Exception_404('Object "' . $this->dbObject . '" not is found!');
        }

        $this->_requestListDB('DB_Ab1_Shop_Transport_Mark', $model->getShopTransportMarkID());
        $this->_requestListDB('DB_Ab1_Fuel', $model->getFuelID());
        $this->_requestListDB('DB_Ab1_Shop_Move_Client', $model->getShopMoveClientID());
        $this->_actionEdit($model, $this->_sitePageData->shopID);
    }
}

