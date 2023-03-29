<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_Make_ShopDefectCar extends Controller_Ab1_Make_BasicAb1 {

    public function __construct(Request $request, Response $response)
    {
        $this->dbObject = 'DB_Ab1_Shop_Defect_Car';
        $this->controllerName = 'shopdefectcar';
        $this->tableID = Model_Ab1_Shop_Defect_Car::TABLE_ID;
        $this->tableName = Model_Ab1_Shop_Defect_Car::TABLE_NAME;
        $this->objectName = 'defectcar';

        parent::__construct($request, $response);
    }

    public function action_history() {
        $this->_sitePageData->url = '/make/shopdefectcar/history';
        $this->_actionDefectCarHistory();
    }

    public function action_edit()
    {
        $this->_sitePageData->url = '/make/shopdefectcar/edit';
        $this->_actionDefectCarEdit();
    }

    public function action_save()
    {
        $this->_sitePageData->url = '/make/shopdefectcar/save';

        $result = Api_Ab1_Shop_Defect_Car::save($this->_sitePageData, $this->_driverDB);
        $this->_redirectSaveResult($result);
    }
}
