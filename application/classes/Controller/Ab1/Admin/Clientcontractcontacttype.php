<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_Admin_ClientContractContactType extends Controller_Ab1_Admin_BasicAb1 {

    public function __construct(Request $request, Response $response)
    {
        $this->dbObject = 'DB_Ab1_ClientContract_Contact_Type';
        $this->controllerName = 'clientcontractcontacttype';
        $this->tableID = Model_Ab1_ClientContract_Contact_Type::TABLE_ID;
        $this->tableName = Model_Ab1_ClientContract_Contact_Type::TABLE_NAME;

        parent::__construct($request, $response);

        $this->shopID = 0;
        $this->editAndNewBasicTemplate = '';
    }
}
