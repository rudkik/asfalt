<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_Jurist_ShopWorkerEntryExit extends Controller_Ab1_Jurist_BasicAb1 {

    public function __construct(Request $request, Response $response)
    {
        $this->dbObject = 'DB_Ab1_Shop_Worker_EntryExit';
        $this->controllerName = 'shopworkerentryexit';
        $this->tableID = Model_Ab1_Shop_Worker_EntryExit::TABLE_ID;
        $this->tableName = Model_Ab1_Shop_Worker_EntryExit::TABLE_NAME;
        $this->objectName = 'workerentryexit';

        parent::__construct($request, $response);

    }
    public function action_index() {
        $this->_sitePageData->url = '/jurist/shopworkerentryexit/index';

        $this->_requestListDB('DB_Ab1_Shop_Worker');
        $this->_requestListDB('DB_Magazine_Shop_Card', null, 0, ['is_constant' => false]);

        $this->_requestListDB('DB_Ab1_Shop_Department', null, $this->_sitePageData->shopID);

        parent::_actionIndex(
            array(
                'shop_worker_passage_id' => array('name'),
                'exit_shop_worker_passage_id' => array('name'),
                'shop_worker_id' => array('name'),
                'shop_department_id' => array('name'),
                'shop_card_id' => array('name'),
                'guest_id' => array('name'),
            ),
            [
                'is_inside_move' => false,
                'sort_by' => ['updated_at' => 'desc']
            ],
            -1, 'index', 'ab1/_all'
        );
    }

    public function action_history() {
        $this->_sitePageData->url = '/jurist/shopworkerentryexit/history';

        $this->_requestListDB('DB_Ab1_Shop_Worker');
        $this->_requestListDB('DB_Ab1_Shop_Department', null, $this->_sitePageData->shopID);

        parent::_actionIndex(
            array(
                'shop_worker_passage_id' => array('name'),
                'exit_shop_worker_passage_id' => array('name'),
                'shop_worker_id' => array('name'),
                'shop_department_id' => array('name'),
                'shop_card_id' => array('name'),
                'guest_id' => array('name'),
            ),
            [
                'is_inside_move' => false,
                'sort_by' => ['updated_at' => 'desc']
            ],
            -1, 'history', 'ab1/_all'
        );
    }
}

