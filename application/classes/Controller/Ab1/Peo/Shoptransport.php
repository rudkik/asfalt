<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_Peo_ShopTransport extends Controller_Ab1_Peo_BasicAb1 {

    public function __construct(Request $request, Response $response)
    {
        $this->dbObject = 'DB_Ab1_Shop_Transport';
        $this->controllerName = 'shoptransport';
        $this->tableID = Model_Ab1_Shop_Transport::TABLE_ID;
        $this->tableName = Model_Ab1_Shop_Transport::TABLE_NAME;
        $this->objectName = 'transport';

        parent::__construct($request, $response);

        $this->shopID = $this->_sitePageData->shopMainID;
        $this->editAndNewBasicTemplate = 'ab1/_all';
    }


    public function action_statistics()
    {
        $this->_sitePageData->url = '/peo/shoptransport/statistics';

        $this->_actionShopTransportStatistics();
    }
}

