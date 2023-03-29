<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_Atc_ShopTransportFuelStorage extends Controller_Ab1_Atc_BasicAb1 {

    public function __construct(Request $request, Response $response)
    {
        $this->dbObject = 'DB_Ab1_Shop_Transport_Fuel_Storage';
        $this->controllerName = 'shoptransportfuelstorage';
        $this->tableID = Model_Ab1_Shop_Transport_Fuel_Storage::TABLE_ID;
        $this->tableName = Model_Ab1_Shop_Transport_Fuel_Storage::TABLE_NAME;
        $this->objectName = 'transportfuelstorage';

        parent::__construct($request, $response);

        $this->shopID = $this->_sitePageData->shopID;
        $this->editAndNewBasicTemplate = 'ab1/_all';
    }
}

