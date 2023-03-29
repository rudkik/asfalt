<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_Sales_ShopClientBalanceDay extends Controller_Ab1_Sales_BasicAb1 {

    public function __construct(Request $request, Response $response)
    {
        $this->dbObject = 'DB_Ab1_Shop_Client_Balance_Day';
        $this->controllerName = 'shopclientbalanceday';
        $this->tableID = Model_Ab1_Shop_Client_Balance_Day::TABLE_ID;
        $this->tableName = Model_Ab1_Shop_Client_Balance_Day::TABLE_NAME;
        $this->objectName = 'clientbalanceday';

        parent::__construct($request, $response);
    }

    public function action_index() {
        $this->_sitePageData->url = '/sales/shopclientbalanceday/index';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/client/balance/day/list/index',
            )
        );

        // получаем список
        View_View::findBranch(
            'DB_Ab1_Shop_Client_Balance_Day', array(),
            "_shop/client/balance/day/list/index", "_shop/client/balance/day/one/index",
            $this->_sitePageData, $this->_driverDB,
            array('limit' => 1000, 'limit_page' => 25, 'shop_client_id_not' => 175747, 'shop_client_id.is_buyer' => true,), array('shop_client_id' => array('name'))
        );

        $this->_putInMain('/main/_shop/client/balance/day/index');
    }
}
