<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_Lab_ShopEquipmentState extends Controller_Ab1_Lab_BasicAb1 {

    public function __construct(Request $request, Response $response)
    {
        $this->dbObject = 'DB_Ab1_Shop_Equipment_State';
        $this->controllerName = 'shopequipmentstate';
        $this->tableID = Model_Ab1_Shop_Equipment_State::TABLE_ID;
        $this->tableName = Model_Ab1_Shop_Equipment_State::TABLE_NAME;
        $this->objectName = 'equipmentstate';

        parent::__construct($request, $response);

        $this->shopID = $this->_sitePageData->shopMainID;
    }
}

