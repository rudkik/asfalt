<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_Atc_TransportType1C extends Controller_Ab1_Atc_BasicAb1 {

    public function __construct(Request $request, Response $response)
    {
        $this->dbObject = 'DB_Ab1_Transport_Type1c';
        $this->controllerName = 'transporttype1c';
        $this->tableID = Model_Ab1_Transport_Type1c::TABLE_ID;
        $this->tableName = Model_Ab1_Transport_Type1c::TABLE_NAME;
        $this->objectName = 'transporttype1c';

        parent::__construct($request, $response);
    }
}
