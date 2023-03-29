<?php defined('SYSPATH') or die('No direct script access.');

class Controller_AutoPath_ShopBrand extends Controller_BasicAdmin{

    public function __construct(Request $request, Response $response)
    {
        $this->dbObject = 'DB_AutoPart_Shop_Brand';
        $this->controllerName = 'shopbrand';
        $this->tableID = Model_AutoPart_Shop_Brand::TABLE_ID;
        $this->tableName = Model_AutoPart_Shop_Brand::TABLE_NAME;
        $this->objectName = 'brand';

        parent::__construct($request, $response);

        $this->shopID = 0;
        $this->editAndNewBasicTemplate = 'smg/_all';
    }
}
