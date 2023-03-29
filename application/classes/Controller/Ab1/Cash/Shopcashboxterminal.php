<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_Cash_ShopCashboxTerminal extends Controller_Ab1_Cash_BasicAb1 {

    public function __construct(Request $request, Response $response)
    {
        $this->dbObject = 'DB_Ab1_Shop_Cashbox_Terminal';
        $this->controllerName = 'shopcashboxterminal';
        $this->tableID = Model_Ab1_Shop_Cashbox_Terminal::TABLE_ID;
        $this->tableName = Model_Ab1_Shop_Cashbox_Terminal::TABLE_NAME;

        parent::__construct($request, $response);
    }
}
