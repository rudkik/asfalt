<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_Ballast_ShopWorker extends Controller_Ab1_ballast_BasicAb1 {

    public function __construct(Request $request, Response $response)
    {
        $this->dbObject = 'DB_Ab1_Shop_Worker';
        $this->controllerName = 'shopworker';
        $this->tableID = Model_Ab1_Shop_worker::TABLE_ID;
        $this->tableName = Model_Ab1_Shop_worker::TABLE_NAME;
        $this->objectName = 'worker';

        parent::__construct($request, $response);
    }

    public function action_index() {
        $this->_sitePageData->url = '/ballast/shopworker/index';
        $this->_actionShopWorkerIndex();
    }
}
