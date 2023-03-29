<?php defined('SYSPATH') or die('No direct script access.');

class Controller_AutoPath_ShopRubric extends Controller_BasicAdmin{

    public function __construct(Request $request, Response $response)
    {
        $this->dbObject = 'DB_AutoPart_Shop_Rubric';
        $this->controllerName = 'shoprubric';
        $this->tableID = Model_AutoPart_Shop_Rubric::TABLE_ID;
        $this->tableName = Model_AutoPart_Shop_Rubric::TABLE_NAME;
        $this->objectName = 'rubric';

        parent::__construct($request, $response);

        $this->shopID = 0;
        $this->editAndNewBasicTemplate = 'smg/_all';
    }
}

