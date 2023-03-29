<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_Atc_TransportView extends Controller_Ab1_Atc_BasicAb1 {

    public function __construct(Request $request, Response $response)
    {
        $this->dbObject = 'DB_Ab1_Transport_View';
        $this->controllerName = 'transportview';
        $this->tableID = Model_Ab1_Transport_View::TABLE_ID;
        $this->tableName = Model_Ab1_Transport_View::TABLE_NAME;
        $this->objectName = 'transportview';

        parent::__construct($request, $response);
    }
}
