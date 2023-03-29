<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_Atc_FuelIssue extends Controller_Ab1_Atc_BasicAb1 {

    public function __construct(Request $request, Response $response)
    {
        $this->dbObject = 'DB_Ab1_Fuel_Issue';
        $this->controllerName = 'fuelissue';
        $this->tableID = Model_Ab1_Fuel_Issue::TABLE_ID;
        $this->tableName = Model_Ab1_Fuel_Issue::TABLE_NAME;
        $this->objectName = 'fuelissue';

        parent::__construct($request, $response);

        $this->shopID = 0;
        $this->editAndNewBasicTemplate = 'ab1/_all';
    }
}
