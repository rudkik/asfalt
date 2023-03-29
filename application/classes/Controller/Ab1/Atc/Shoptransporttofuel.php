<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_Atc_ShopTransportToFuel extends Controller_Ab1_Atc_BasicAb1 {

    public function __construct(Request $request, Response $response)
    {
        $this->dbObject = 'DB_Ab1_Shop_Transport_To_Fuel';
        $this->controllerName = 'shoptransporttofuel';
        $this->tableID = Model_Ab1_Shop_Transport_To_Fuel::TABLE_ID;
        $this->tableName = Model_Ab1_Shop_Transport_To_Fuel::TABLE_NAME;
        $this->objectName = 'transporttofuel';

        parent::__construct($request, $response);

        $this->shopID = $this->_sitePageData->shopMainID;
        $this->editAndNewBasicTemplate = 'ab1/_all';
    }
}

