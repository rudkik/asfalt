<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_Bid_ShopTurnPlace extends Controller_Ab1_Bid_BasicAb1{

    public function __construct(Request $request, Response $response)
    {
        $this->dbObject = 'DB_Ab1_Shop_Turn_Place';
        $this->controllerName = 'shopturnplace';
        $this->tableID = Model_Ab1_Shop_Turn_Place::TABLE_ID;
        $this->tableName = Model_Ab1_Shop_Turn_Place::TABLE_NAME;
        $this->objectName = 'turnplace';

        parent::__construct($request, $response);
    }
}
