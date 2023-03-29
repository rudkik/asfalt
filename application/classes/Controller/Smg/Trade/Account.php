<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Smg_Trade_Account extends Controller_Smg_Trade_Basic {

    public function __construct(Request $request, Response $response)
    {
        $this->dbObject = 'DB_User';
        $this->controllerName = 'account';
        $this->tableID = Model_User::TABLE_ID;
        $this->tableName = Model_User::TABLE_NAME;
        $this->objectName = 'account';

        parent::__construct($request, $response);
    }

    public function action_index()
    {
        $this->_sitePageData->url = '/account/index';

        $id = $this->_sitePageData->userID;

        View_View::find(
            'DB_User',
            $this->_sitePageData->shopID,
            "_shop/account/list/account", "_shop/account/one/account",
            $this->_sitePageData, $this->_driverDB,
            Request_RequestParams::setParams(['id' => $id])
        );

        $this->_putInMain('/main/_shop/account/account');
    }

    public function action_orders()
    {
        $this->_sitePageData->url = '/account/orders';

        $id = $this->_sitePageData->userID;

        View_View::find(
            'DB_Shop_Operation',
            $this->_sitePageData->shopID,
            "_shop/account/list/orders", "_shop/account/one/orders",
            $this->_sitePageData, $this->_driverDB,
            Request_RequestParams::setParams(['id' => $id])
        );

        $this->_putInMain('/main/_shop/account/orders');
    }

    public function action_private()
    {
        $this->_sitePageData->url = '/account/private';

        $id = $this->_sitePageData->userID;

        View_View::find(
            'DB_User',
            $this->_sitePageData->shopID,
            "_shop/account/list/private", "_shop/account/one/private",
            $this->_sitePageData, $this->_driverDB,
            Request_RequestParams::setParams(['id' => $id])
        );

        $this->_putInMain('/main/_shop/account/private');
    }

    public function action_personal()
    {
        $this->_sitePageData->url = '/account/personal';

        $id = $this->_sitePageData->userID;

        View_View::find(
            'DB_User',
            $this->_sitePageData->shopID,
            "_shop/account/list/personal", "_shop/account/one/personal",
            $this->_sitePageData, $this->_driverDB,
            Request_RequestParams::setParams(['id' => $id])
        );

        $this->_putInMain('/main/_shop/account/personal');
    }
}
