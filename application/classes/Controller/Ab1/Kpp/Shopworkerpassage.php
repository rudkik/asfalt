<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_Kpp_ShopWorkerPassage extends Controller_Ab1_Kpp_BasicAb1 {

    public function __construct(Request $request, Response $response)
    {
        $this->dbObject = 'DB_Ab1_Shop_Worker_Passage';
        $this->controllerName = 'shopworkerpassage';
        $this->tableID = Model_Ab1_Shop_Worker_Passage::TABLE_ID;
        $this->tableName = Model_Ab1_Shop_Worker_Passage::TABLE_NAME;
        $this->objectName = 'workerpassage';

        parent::__construct($request, $response);

        $this->shopID = $this->_sitePageData->shopMainID;
    }
}

