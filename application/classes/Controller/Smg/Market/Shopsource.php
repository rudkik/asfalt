<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Smg_Market_ShopSource extends Controller_Smg_Market_Basic {

    public function __construct(Request $request, Response $response)
    {
        $this->dbObject = 'DB_AutoPart_Shop_Source';
        $this->controllerName = 'shopsource';
        $this->tableID = Model_AutoPart_Shop_Source::TABLE_ID;
        $this->tableName = Model_AutoPart_Shop_Source::TABLE_NAME;
        $this->objectName = 'source';

        parent::__construct($request, $response);
    }
}
