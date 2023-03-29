<?php defined('SYSPATH') or die('No direct script access.');

class Controller_AutoPath_ShopMark extends Controller_BasicAdmin{

    public function __construct(Request $request, Response $response)
    {
        $this->dbObject = 'DB_AutoPart_Shop_Mark';
        $this->controllerName = 'shopmark';
        $this->tableID = Model_AutoPart_Shop_Mark::TABLE_ID;
        $this->tableName = Model_AutoPart_Shop_Mark::TABLE_NAME;
        $this->objectName = 'mark';

        parent::__construct($request, $response);

        $this->shopID = 0;
        $this->editAndNewBasicTemplate = 'smg/_all';
    }
}
