<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_Atc_Season extends Controller_Ab1_Atc_BasicAb1 {

    public function __construct(Request $request, Response $response)
    {
        $this->dbObject = 'DB_Ab1_Season';
        $this->controllerName = 'season';
        $this->tableID = Model_Ab1_Season::TABLE_ID;
        $this->tableName = Model_Ab1_Season::TABLE_NAME;
        $this->objectName = 'season';

        parent::__construct($request, $response);

        $this->shopID = 0;
        $this->editAndNewBasicTemplate = 'ab1/_all';
    }
}
