<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_Kpp_ShopWorkerEntryExit extends Controller_Ab1_Kpp_BasicAb1 {

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
        $this->_sitePageData->url = '/kpp/shopworkerentryexit/index';

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
            ]
        );
    }

    public function action_index_new() {
        $this->_sitePageData->url = '/kpp/shopworkerentryexit/index_new';

        // получаем список
        $result = View_View::find(
            $this->dbObject, $this->_sitePageData->shopID,
            '_shop/worker/entry-exit/list/no-table', '_shop/worker/entry-exit/one/index',
            $this->_sitePageData, $this->_driverDB,
            array(
                'is_inside_move' => false,
                'limit' => 25,
                'sort_by' => [
                    'updated_at' => 'desc',
                ],
            ),
            array(
                'shop_worker_passage_id' => array('name'),
                'exit_shop_worker_passage_id' => array('name'),
                'shop_worker_id' => array('name'),
                'shop_department_id' => array('name'),
                'shop_card_id' => array('name'),
                'guest_id' => array('name'),
            )
        );

        $this->response->body($result);
    }

    public function action_history() {
        $this->_sitePageData->url = '/kpp/shopworkerentryexit/history';

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
            -1, 'history'
        );
    }

    /**
     * Внутреннее перемещение работников
     */
    public function action_move() {
        $this->_sitePageData->url = '/kpp/shopworkerentryexit/move';

        $this->_requestListDB('DB_Ab1_Shop_Worker_Passage', null, $this->_sitePageData->shopID);
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
                'is_inside_move' => true,
                'sort_by' => ['updated_at' => 'desc']
            ],
            -1, 'move'
        );
    }

    public function action_time_work() {
        $this->_sitePageData->url = '/kpp/shopworkerentryexit/time_work';

        $this->_requestListDB('DB_Ab1_Shop_Worker');
        $this->_requestListDB('DB_Ab1_Shop_Department', null, $this->_sitePageData->shopID);

        // получаем список
        View_View::find(
            $this->dbObject, $this->_sitePageData->shopID,
            '_shop/worker/entry-exit/list/time-work', '_shop/worker/entry-exit/one/time-work',
            $this->_sitePageData, $this->_driverDB,
            array(
                'is_inside_move' => false,
                'date_entry_from' => Helpers_DateTime::getMonthBeginStr(date('m'), date('Y')),
                'sum_time_work' => true,
                'sum_late_for' => true,
                'sum_early_exit' => true,
                'shop_worker_id_from' => 0,
                'exit_shop_worker_passage_id.is_exit' => true,
                'group_by' => [
                    'shop_worker_id', 'shop_worker_id.name',
                    'shop_department_id', 'shop_department_id.name',
                ],
                'sort_by' => [
                    'shop_worker_id.name' => 'asc',
                ],
            ),
            array(
                'shop_worker_id' => array('name'),
                'shop_department_id' => array('name'),
            )
        );

        $this->_putInMain('/main/_shop/worker/entry-exit/time-work');
    }

    public function action_new()
    {
        $this->_sitePageData->url = '/kpp/shopworkerentryexit/new';

        $this->_requestListDB('DB_Ab1_Shop_Worker_Passage');
        $this->_requestListDB('DB_Ab1_Shop_Worker');
        $this->_requestListDB('DB_Magazine_Shop_Card');
        $this->_requestListDB('DB_Ab1_Guest');

        parent::_actionNew();
    }

    public function action_edit()
    {
        $this->_sitePageData->url = '/kpp/shopworkerentryexit/edit';

        // id записи
        $id = Request_RequestParams::getParamInt('id');
        $model = new Model_Ab1_Shop_Worker_EntryExit();
        if (! $this->dublicateObjectLanguage($model, $id, $this->_sitePageData->shopID, false)) {
            throw new HTTP_Exception_404('Object "' . $this->dbObject . '" not is found!');
        }

        $this->_requestListDB('DB_Ab1_Shop_Worker', $model->getShopWorkerID());
        $this->_requestListDB('DB_Ab1_Shop_Worker_Passage', $model->getShopWorkerPassageID());
        $this->_requestListDB('DB_Magazine_Shop_Card', $model->getShopCardID());
        $this->_requestListDB('DB_Ab1_Guest');

        $this->_actionEdit($model, $this->_sitePageData->shopID);
    }

    public function action_save_guest()
    {
        $this->_sitePageData->url = '/kpp/shopworkerentryexit/save_guest';

        $name = Request_RequestParams::getParamStr('name');
        $iin = Request_RequestParams::getParamStr('iin');

        $guest = Request_Request::findOne(
            'DB_AB1_Guest', $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB,
            Request_RequestParams::setParams(
                [
                    'iin_full' => $iin,
                    'name_full' => $name,
                ]
            )
        );

        if($guest == null){
            $modelGuest = new Model_Ab1_Guest();
            $modelGuest->setDBDriver($this->_driverDB);
            $modelGuest->setName($name);
            $modelGuest->setIIN($iin);

            Request_RequestParams::setParamStr('company_name', $modelGuest);

            $guestID = Helpers_DB::saveDBObject($modelGuest, $this->_sitePageData, 0);
        }else{
            $guestID = $guest->id;
        }

        $model = new Model_Ab1_Shop_Worker_EntryExit();
        $model->setDBDriver($this->_driverDB);
        $model->setGuestID($guestID);
        Request_RequestParams::setParamInt('shop_card_id', $model);

        $model->setDateEntry(date('Y-m-d H:i:s'));
        $model->setShopWorkerPassageID($this->_sitePageData->operation->getShopWorkerPassageID());

        /** @var Model_Ab1_Shop_Worker_Passage $modelPassage */
        $modelPassage = Request_Request::findOneModelByID(
            'DB_Ab1_Shop_Worker_Passage', $model->getShopWorkerPassageID(), $this->_sitePageData->shopID,
            $this->_sitePageData, $this->_driverDB
        );
        If($modelPassage != null){
            $model->setIsCar($modelPassage->getIsCar());
        }

        Helpers_DB::saveDBObject($model, $this->_sitePageData);

        $this->redirect('/kpp/shopworkerentryexit/index');
    }

    public function action_save_worker()
    {
        $this->_sitePageData->url = '/kpp/shopworkerentryexit/save_worker';

        $name = Request_RequestParams::getParamStr('name');

        $model = new Model_Ab1_Shop_Worker_EntryExit();
        $model->setDBDriver($this->_driverDB);
        Request_RequestParams::setParamInt('shop_worker_id', $model);
        Request_RequestParams::setParamInt('shop_card_id', $model);

        $model->setDateEntry(date('Y-m-d H:i:s'));
        $model->setShopWorkerPassageID($this->_sitePageData->operation->getShopWorkerPassageID());

        /** @var Model_Ab1_Shop_Worker_Passage $modelPassage */
        $modelPassage = Request_Request::findOneModelByID(
            'DB_Ab1_Shop_Worker_Passage', $model->getShopWorkerPassageID(), $this->_sitePageData->shopID,
            $this->_sitePageData, $this->_driverDB
        );
        If($modelPassage != null){
            $model->setIsCar($modelPassage->getIsCar());
        }

        Helpers_DB::saveDBObject($model, $this->_sitePageData);

        $this->redirect('/kpp/shopworkerentryexit/index');
    }
}

