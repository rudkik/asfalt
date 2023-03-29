<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_Kpp_ShopWorkerEntryExitLog extends Controller_Ab1_Kpp_BasicAb1 {

    public function __construct(Request $request, Response $response)
    {
        $this->dbObject = 'DB_Ab1_Shop_Worker_EntryExit_Log';
        $this->controllerName = 'shopworkerentryexitlog';
        $this->tableID = Model_Ab1_Shop_Worker_EntryExit_Log::TABLE_ID;
        $this->tableName = Model_Ab1_Shop_Worker_EntryExit_Log::TABLE_NAME;
        $this->objectName = 'workerentryexitlog';

        parent::__construct($request, $response);

    }

    public function action_index() {
        $this->_sitePageData->url = '/kpp/shopworkerentryexitlog/index';

        $this->_requestListDB('DB_Ab1_Shop_Worker_Passage');
        $this->_requestListDB('DB_Ab1_Shop_Worker');
        $this->_requestListDB('DB_Ab1_Guest');
        $this->_requestListDB('DB_Magazine_Shop_Card', null, 0, ['is_constant' => false]);

        parent::_actionIndex(
            array(
                'shop_worker_passage_id' => array('name'),
                'shop_worker_id' => array('name'),
                'shop_card_id' => array('name'),
                'guest_id' => array('name'),
            ),
            [
                'limit' => Request_RequestParams::getParamInt('limit'),
                'sort_by' => ['created_at' => 'desc']
            ]

        );
    }
}

