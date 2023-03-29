<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_Admin_Bank extends Controller_Ab1_Admin_BasicAb1 {

    public function __construct(Request $request, Response $response)
    {
        $this->dbObject = 'DB_Bank';
        $this->controllerName = 'bank';
        $this->tableID = Model_Bank::TABLE_ID;
        $this->tableName = Model_Bank::TABLE_NAME;
        $this->objectName = 'bank';

        parent::__construct($request, $response);

        $this->shopID = 0;
        $this->editAndNewBasicTemplate = 'ab1/_all';

    }
}

