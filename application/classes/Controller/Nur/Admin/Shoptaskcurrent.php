<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Nur_Admin_ShopTaskCurrent extends Controller_Nur_Admin_BasicNur {

    public function __construct(Request $request, Response $response)
    {
        $this->controllerName = 'shoptaskcurrent';
        $this->tableID = Model_Nur_Shop_Task_Current::TABLE_ID;
        $this->tableName = Model_Nur_Shop_Task_Current::TABLE_NAME;
        $this->objectName = 'taskcurrent';

        parent::__construct($request, $response);
    }

    public function action_index() {
        $this->_sitePageData->url = '/nur-admin/shoptaskcurrent/index';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/task/current/list/index',
            )
        );

        $this->_requestShopOperations(Model_Nur_Shop_Operation::RUBRIC_BOOKKEEPING);
        $this->_requestShopBranches();

        // получаем список
        $params = Request_RequestParams::setParams(
            array(
                'limit_page' => 25,
            ),
            TRUE
        );
        View_View::find('DB_Nur_Shop_Task_Current',
            $this->_sitePageData->shopMainID,
            "_shop/task/current/list/index", "_shop/task/current/one/index",
            $this->_sitePageData, $this->_driverDB, $params,
            array('shop_id' => array('name')),
            TRUE, TRUE

        );

        $this->_putInMain('/main/_shop/task/current/index');
    }

    public function action_json() {
        $this->_sitePageData->url = '/nur-admin/shoptaskcurrent/json';
        $shopBookkeeperID = Request_RequestParams::getParamInt('shop_bookkeeper_id');
        if($shopBookkeeperID < 1){
            $shopBookkeeperID = NULL;
        }

        if($this->_sitePageData->shopMainID != $this->_sitePageData->shopID) {
            $this->_actionJSON(
                'Request_Nur_Shop_Task_Current',
                'findShopTaskCurrentIDs',
                array(
                    'shop_id' => array('name'),
                    'shop_bookkeeper_id' => array('name')
                ),
                new Model_Nur_Shop_Task_Current(),
                FALSE,
                array(
                    'is_empty_date_finish' => FALSE,
                    'shop_bookkeeper_id' => $shopBookkeeperID,
                )
            );
        }else{
            $this->_actionJSON(
                'Request_Nur_Shop_Task_Current',
                'findBranchShopTaskCurrentIDs',
                array(
                    'shop_id' => array('name'),
                    'shop_bookkeeper_id' => array('name')
                ),
                new Model_Nur_Shop_Task_Current(),
                TRUE,
                array(
                    'is_empty_date_finish' => FALSE,
                    'shop_bookkeeper_id' => $shopBookkeeperID,
                )
            );
        }
    }

    public function action_run() {
        $this->_sitePageData->url = '/nur-admin/shoptaskcurrent/run';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/task/current/list/run',
            )
        );

        $this->_requestShopOperations(Model_Nur_Shop_Operation::RUBRIC_BOOKKEEPING);
        $this->_requestShopBranches();

        // получаем список
        $params = Request_RequestParams::setParams(
            array(
                'limit_page' => 25,
            ),
            TRUE
        );
        View_View::find('DB_Nur_Shop_Task_Current',
            $this->_sitePageData->shopMainID,
            "_shop/task/current/list/run", "_shop/task/current/one/run",
            $this->_sitePageData, $this->_driverDB, $params,
            array('shop_id' => array('name')),
            TRUE, TRUE
        );

        $this->_putInMain('/main/_shop/task/current/run');
    }

    public function action_json_run() {
        $this->_sitePageData->url = '/nur-admin/shoptaskcurrent/json_run';

        $shopBookkeeperID = Request_RequestParams::getParamInt('shop_bookkeeper_id');
        if($shopBookkeeperID < 1){
            $shopBookkeeperID = NULL;
        }

        if($this->_sitePageData->shopMainID != $this->_sitePageData->shopID) {
            $this->_actionJSON(
                'Request_Nur_Shop_Task_Current',
                'findShopTaskCurrentIDs',
                array(
                    'shop_id' => array('name'),
                    'shop_bookkeeper_id' => array('name')
                ),
                new Model_Nur_Shop_Task_Current(),
                FALSE,
                array(
                    'is_empty_date_finish' => TRUE,
                    'shop_bookkeeper_id' => $shopBookkeeperID,
                )
            );
        }else {
            $this->_actionJSON(
                'Request_Nur_Shop_Task_Current',
                'findBranchShopTaskCurrentIDs',
                array(
                    'shop_id' => array('name'),
                    'shop_bookkeeper_id' => array('name')
                ),
                new Model_Nur_Shop_Task_Current(),
                TRUE,
                array(
                    'is_empty_date_finish' => TRUE,
                    'shop_bookkeeper_id' => $shopBookkeeperID,
                )
            );
        }
    }

    public function action_calendar()
    {
        $this->_sitePageData->url = '/nur-admin/shoptaskcurrent/calendar';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/task/current/list/calendar',
            )
        );

        $model = new Model_Nur_Shop_Task_Current();
        $model->setDBDriver($this->_driverDB);
        $result = Helpers_View::getViewObjects(
            new MyArray(), $model, "_shop/task/current/list/calendar", "_shop/task/current/one/calendar",
            $this->_sitePageData, $this->_driverDB, $this->_sitePageData->shopID, TRUE,
            array(), TRUE
        );
        $this->_sitePageData->replaceDatas['view::_shop/task/current/list/calendar'] = $result;

        $this->_putInMain('/main/_shop/task/current/calendar');
    }

    public function action_json_calendar() {
        $this->_sitePageData->url = '/nur-admin/shoptaskcurrent/json_calendar';

        $dateFrom = Request_RequestParams::getParamDateTime('start');
        $dateTo = Request_RequestParams::getParamDateTime('end');

        $arr = Api_Nur_Shop_Task_Current::getCurrentTasks(
            $dateFrom, $dateTo, $this->_sitePageData, $this->_driverDB, NULL, TRUE
        );

        $result = array();
        foreach ($arr as $child){
            $values = array(
                'title' => $child['shop_task_name'].' - '. $child['shop_name'],
                'start' => $child['date_from'],
                'end' => $child['date_to'],
                'status' => $child['status'],
            );

            if(!$child['status'] == 2){
                $values['url'] = '/nur-admin/shoptaskcurrent/add?id=' . $child['shop_task_id'] .'&shop_branch_id='.$child['shop_id'];
            }

            $result[] = $values;
        }

        $this->response->body(json_encode($result));
    }

    public function action_json_calendar_day() {
        $this->_sitePageData->url = '/nur-admin/shoptaskcurrent/json_calendar_day';

        $date = Request_RequestParams::getParamDateTime('date');
        $result = Api_Nur_Shop_Task_Current::getCurrentTasks(
            Helpers_DateTime::minusDays($date, 1), $date, $this->_sitePageData, $this->_driverDB,
            Request_RequestParams::getParamInt('shop_bookkeeper_id'), TRUE
        );

        $bookkeepers = array();
        foreach ($result as $child){
            $bookkeeper = $child['shop_bookkeeper_id'];
            if(key_exists($bookkeeper, $bookkeepers)){
                $bookkeepers[$bookkeeper]['count']++;
            }else{
                $bookkeepers[$bookkeeper] = array(
                    'shop_bookkeeper_id' => $bookkeeper,
                    'shop_bookkeeper_name' => $child['shop_bookkeeper_name'],
                    'count' => 1,
                );
            }
        }

        $this->response->body(
            json_encode(
                array(
                    'tasks' => $result,
                    'bookkeepers' => $bookkeepers,
                )
            )
        );
    }

    public function action_new()
    {
        $this->_sitePageData->url = '/nur-admin/shoptaskcurrent/new';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/task/current/list/new',
            )
        );

        $this->_requestShopOperations(Model_Nur_Shop_Operation::RUBRIC_BOOKKEEPING);
        $this->_requestShopBranches();

        $model = new Model_Nur_Shop_Task_Current();
        $model->setDBDriver($this->_driverDB);
        $result = Helpers_View::getViewObjects(
            new MyArray(), $model, "_shop/task/current/list/new", "_shop/task/current/one/new",
            $this->_sitePageData, $this->_driverDB, $this->_sitePageData->shopID, TRUE,
            array(), TRUE
        );
        $this->_sitePageData->replaceDatas['view::_shop/task/current/list/new'] = $result;

        $this->_putInMain('/main/_shop/task/current/new');
    }

    public function action_json_new() {
        $this->_sitePageData->url = '/nur-admin/shoptaskcurrent/json_new';

        $dateFrom = date('Y-m-d');
        switch (Request_RequestParams::getParamStr('period')){
            case 'day':
                $dateTo = Helpers_DateTime::plusDays($dateFrom, 3);
                break;
            case 'week':
                $dateTo = Helpers_DateTime::plusDays($dateFrom, 7);
                break;
            case 'month':
                $dateTo = Helpers_DateTime::plusDays($dateFrom, 30);
                break;
            default:
                $dateTo = Helpers_DateTime::plusDays($dateFrom, 1);
        }

        $result = Api_Nur_Shop_Task_Current::getCurrentTasks(
            $dateFrom, $dateTo, $this->_sitePageData, $this->_driverDB,
            Request_RequestParams::getParamInt('shop_bookkeeper_id')
        );
        $this->response->body(json_encode(array('rows' => $result, 'total' => count($result))));
    }

    public function action_edit()
    {
        $this->_sitePageData->url = '/nur-admin/shoptaskcurrent/edit';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/task/current/one/edit',
            )
        );

        // id записи
        $id = Request_RequestParams::getParamInt('id');
        $model = new Model_Nur_Shop_Task_Current();
        if (! $this->dublicateObjectLanguage($model, $id, -1, FALSE)) {
            throw new HTTP_Exception_404('Task current not is found!');
        }

        // получаем данные
        View_View::findOne('DB_Nur_Shop_Task_Current', $this->_sitePageData->shopID, "_shop/task/current/one/edit",
            $this->_sitePageData, $this->_driverDB, array('id' => $id), array());

        $this->_putInMain('/main/_shop/task/current/edit');
    }

    public function action_add()
    {
        $this->_sitePageData->url = '/nur-admin/shoptaskcurrent/add';

        $model = new Model_Nur_Shop_Task_Current();
        $model->setDBDriver($this->_driverDB);
        $model->setShopBookkeeperID($this->_sitePageData->operationID);
        $model->setDateStart(date('Y-m-d H:i:s'));
        $model->setShopTaskID(Request_RequestParams::getParamStr('id'));

        $modelTask = $model->getElement('shop_task_id', TRUE, $this->_sitePageData->shopMainID);
        if($modelTask === NULL){
            $this->redirect('/nur-admin/shoptaskcurrent/index');
            exit();
        }
        $model->setName($modelTask->getName());
        $model->setDateFrom(Helpers_DateTime::changeDateYear($modelTask->getDateFrom(), date('Y')));
        if(strtotime($modelTask->getDateFrom()) < strtotime($modelTask->getDateTo())) {
            $model->setDateTo(Helpers_DateTime::changeDateYear($modelTask->getDateTo(), date('Y')));
        }else{
            $model->setDateTo(Helpers_DateTime::changeDateYear($modelTask->getDateTo(), date('Y') + 1));
        }
        Helpers_DB::saveDBObject($model, $this->_sitePageData);

        $this->redirect('/nur-admin/shoptaskcurrent/run?id='.$model->id);
    }

    public function action_finish()
    {
        $this->_sitePageData->url = '/nur-admin/shoptaskcurrent/finish';

        $model = new Model_Nur_Shop_Task_Current();
        $model->setDBDriver($this->_driverDB);

        $id = Request_RequestParams::getParamInt('id');
        if (!Helpers_DB::dublicateObjectLanguage($model, $id, $this->_sitePageData)) {
            throw new HTTP_Exception_500('Current task not found.');
        }

        $model->setShopBookkeeperID($this->_sitePageData->operationID);
        $model->setDateFinish(date('Y-m-d H:i:s'));
        Helpers_DB::saveDBObject($model, $this->_sitePageData);

        $this->redirect('/nur-admin/shoptaskcurrent/index');
    }

    public function action_save()
    {
        $this->_sitePageData->url = '/nur-admin/shoptaskcurrent/save';

        $result = Api_Nur_Shop_Task_Current::save($this->_sitePageData, $this->_driverDB);
        $this->_redirectSaveResult($result);
    }
}
