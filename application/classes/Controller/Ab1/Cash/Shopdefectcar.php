<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_Cash_ShopDefectCar extends Controller_Ab1_Cash_BasicAb1 {

    public function __construct(Request $request, Response $response)
    {
        $this->dbObject = 'DB_Ab1_Shop_Defect_Car';
        $this->controllerName = 'shopdefectcar';
        $this->tableID = Model_Ab1_Shop_Defect_Car::TABLE_ID;
        $this->tableName = Model_Ab1_Shop_Defect_Car::TABLE_NAME;
        $this->objectName = 'defectcar';

        parent::__construct($request, $response);
    }

    public function action_index() {
        $this->_sitePageData->url = '/cash/shopdefectcar/index';
        $this->_actionDefectCarIndex();
    }

    public function action_history() {
        $this->_sitePageData->url = '/cash/shopdefectcar/history';
        $this->_actionDefectCarHistory();
    }

    public function action_new()
    {
        $this->_sitePageData->url = '/cash/shopdefectcar/new';
        $this->_actionDefectCarNew();
    }

    public function action_edit()
    {
        $this->_sitePageData->url = '/cash/shopdefectcar/edit';
        $this->_actionDefectCarEdit();
    }

    public function action_save()
    {
        $this->_sitePageData->url = '/cash/shopdefectcar/save';

        $result = Api_Ab1_Shop_Defect_Car::save($this->_sitePageData, $this->_driverDB);
        $this->_redirectSaveResult($result);
    }
}
