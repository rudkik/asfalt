<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_Kpp_Guest extends Controller_Ab1_Kpp_BasicAb1 {

    public function __construct(Request $request, Response $response)
    {
        $this->dbObject = 'DB_Ab1_Guest';
        $this->controllerName = 'guest';
        $this->tableID = Model_Ab1_Guest::TABLE_ID;
        $this->tableName = Model_Ab1_Guest::TABLE_NAME;
        $this->objectName = 'guest';

        parent::__construct($request, $response);

    }
}

