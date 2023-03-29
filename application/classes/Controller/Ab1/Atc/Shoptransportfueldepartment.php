<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_Atc_ShopTransportFuelDepartment extends Controller_Ab1_Atc_BasicAb1 {

    public function __construct(Request $request, Response $response)
    {
        $this->dbObject = 'DB_Ab1_Shop_Transport_Fuel_Department';
        $this->controllerName = 'shoptransportfueldepartment';
        $this->tableID = Model_Ab1_Shop_Transport_Fuel_Department::TABLE_ID;
        $this->tableName = Model_Ab1_Shop_Transport_Fuel_Department::TABLE_NAME;
        $this->objectName = 'transportfueldepartment';

        parent::__construct($request, $response);

        $this->shopID = $this->_sitePageData->shopID;
        $this->editAndNewBasicTemplate = 'ab1/_all';
    }
    
    public function action_index() {
        $this->_sitePageData->url = '/atc/shoptransportfueldepartment/index';
        $this->_actionIndex();
    }

    public function action_new() {
        $this->_actionNew();
    }

    public function action_edit() {
        $this->_sitePageData->url = '/atc/shoptransportfueldepartment/edit';

        // id записи
        $id = Request_RequestParams::getParamInt('id');
        $model = new Model_Ab1_Shop_Transport_Fuel_Department();
        if (! $this->dublicateObjectLanguage($model, $id, $this->_sitePageData->shopID, false)) {
            throw new HTTP_Exception_404('Object "' . $this->dbObject . '" not is found!');
        }

        $this->_actionEdit($model, $this->_sitePageData->shopID);
    }
}

