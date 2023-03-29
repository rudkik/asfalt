<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_Kpp_MissType extends Controller_Ab1_Kpp_BasicAb1 {

    public function __construct(Request $request, Response $response)
    {
        $this->dbObject = 'DB_Ab1_MissType';
        $this->controllerName = 'misstype';
        $this->tableID = Model_Ab1_MissType::TABLE_ID;
        $this->tableName = Model_Ab1_MissType::TABLE_NAME;
        $this->objectName = 'misstype';

        parent::__construct($request, $response);

    }
}

