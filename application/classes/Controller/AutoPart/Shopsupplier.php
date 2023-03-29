<?php defined('SYSPATH') or die('No direct script access.');

class Controller_AutoPath_ShopSupplier extends Controller_BasicAdmin{

    public function __construct(Request $request, Response $response)
    {
        $this->dbObject = 'DB_AutoPart_Shop_Supplier';
        $this->controllerName = 'shopsupplier';
        $this->tableID = Model_AutoPart_Shop_Supplier::TABLE_ID;
        $this->tableName = Model_AutoPart_Shop_Supplier::TABLE_NAME;
        $this->objectName = 'supplier';

        parent::__construct($request, $response);

        $this->shopID = 0;
        $this->editAndNewBasicTemplate = 'smg/_all';
    }
}
