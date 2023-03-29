<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_Kpp_ScheduleType extends Controller_Ab1_Kpp_BasicAb1 {

    public function __construct(Request $request, Response $response)
    {
        $this->dbObject = 'DB_Ab1_ScheduleType';
        $this->controllerName = 'scheduletype';
        $this->tableID = Model_Ab1_ScheduleType::TABLE_ID;
        $this->tableName = Model_Ab1_ScheduleType::TABLE_NAME;
        $this->objectName = 'scheduletype';

        parent::__construct($request, $response);

    }
}

