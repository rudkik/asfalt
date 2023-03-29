<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Tax_Client_ShopWorkerWage extends Controller_Tax_Client_BasicTax {

    public function __construct(Request $request, Response $response)
    {
        $this->controllerName = 'shopworkerwage';
        $this->tableID = Model_Tax_Shop_Worker_Wage::TABLE_ID;
        $this->tableName = Model_Tax_Shop_Worker_Wage::TABLE_NAME;
        $this->objectName = 'workerwage';

        parent::__construct($request, $response);
    }

    public function action_index() {
        $this->_sitePageData->url = '/tax/shopworkerwage/index';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/worker/wage/list/index',
                'view::_shop/worker/wage/item/list/index',
            )
        );

        // получаем список
        View_View::find('DB_Tax_Shop_Worker_Wage', $this->_sitePageData->shopID, "_shop/worker/wage/list/index",
            "_shop/worker/wage/one/index", $this->_sitePageData, $this->_driverDB, array(),
            array(), TRUE, TRUE);

        $this->_putInMain('/main/_shop/worker/wage/index');
    }

    public function action_json() {
        $this->_sitePageData->url = '/tax/shopworkerwage/json';

        $params = array_merge($_POST, $_GET);
        if ((key_exists('offset', $params)) && (intval($params['offset']) > 0)) {
            $params['page'] =  round($params['offset'] / $params['limit']) + 1;
        }
        if ((key_exists('sort', $params)) ) {
            $params['sort_by'] = array('value' => array($params['sort'] => Arr::path($params, 'order', 'asc')));
        }
        if ((key_exists('limit', $params)) ) {
            $params['limit_page'] = intval($params['limit']);
            unset($params['limit']);
        }else{
            $params['limit_page'] = 25;
        }
        $params[Request_RequestParams::IS_NOT_READ_REQUEST_NAME] = TRUE;

        // получаем список
        $ids = Request_Tax_Shop_Worker_Wage::findShopWorkerWageIDs($this->_sitePageData->shopID,
            $this->_sitePageData, $this->_driverDB, $params, 5000, TRUE,
            array('shop_worker_id' => array('name'), 'worker_status_id' => array('name')));

        $fields = Request_RequestParams::getParam('_fields');
        if(!is_array($fields)){
            if($fields != '*'){
                $fields = array($fields);
            }
        }

        $result = array();
        if($fields == '*'){
            foreach ($ids->childs as $child) {
                $result[] = $child->values;
            }
        }elseif(!empty($fields)) {
            foreach ($ids->childs as $child) {
                $values = array('id' => $child->id);
                foreach ($fields as $field) {
                    if (key_exists($field, $child->values)) {
                        $values[$field] = $child->values[$field];
                    }elseif ($field == 'shop_worker_name'){
                        $values[$field] = Arr::path($child->values, Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_worker_id.name', '');
                    }elseif ($field == 'worker_status_name'){
                        $values[$field] = Arr::path($child->values, Model_Basic_BasicObject::FIELD_ELEMENTS.'.worker_status_id.name', '');
                    }
                }

                $result[] = $values;
            }
        }

        if (Request_RequestParams::getParamBoolean('is_total')) {
            $this->response->body(json_encode(array('total' => $this->_sitePageData->countRecord, 'rows' => $result)));
        }else{
            $this->response->body(json_encode($result));
        }
    }
    public function action_six_month() {
        $this->_sitePageData->url = '/tax/shoptaxreturn910/six_month';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/worker/wage/list/six-month',
            )
        );

        $this->_requestWorkerStatuses();

        $year = Request_RequestParams::getParamInt('year');
        if(strlen($year) != 4){
            $year = date('Y');
        }

        $halfYear = Request_RequestParams::getParamInt('half_year');
        if (($halfYear < 1) || ($halfYear > 2)) {
            $halfYear = intval(date('%m'));
            if($halfYear > 7){
                $halfYear = 2;
            }else{
                $halfYear = 1;
            }
        }
        if($halfYear == 1){
            $dateFrom = $year.'-01-01';
            $dateTo = $year.'-06-01';
        }else{
            $dateFrom = $year.'-07-01';
            $dateTo = $year.'-12-01';
        }

        $shopWorkerWageIDs = Request_Tax_Shop_Worker_Wage::findShopWorkerWageIDs($this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB,
            array('date_from' => $dateFrom, 'date_to' => $dateTo, 'is_owner' => Request_RequestParams::getParamBoolean('is_owner'),
                Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE), 0, TRUE,
            array('shop_worker_id' => array('name')));

        // перебираем все зарплаты пострудникам за 6 месяцев
        $shopWorkerIDs = new MyArray();
        foreach ($shopWorkerWageIDs->childs as $shopWorkerWageID){
            $shopWorkerID = $shopWorkerWageID->values['shop_worker_id'];
            if(!key_exists($shopWorkerID, $shopWorkerIDs->childs)){
                $tmp = $shopWorkerIDs->addUniqueChild($shopWorkerID, TRUE);
                $tmp->values = array(
                    1 => '',
                    2 => '',
                    3 => '',
                    4 => '',
                    5 => '',
                    6 => '',
                    'id' => $shopWorkerID,
                    'name' => Arr::path($shopWorkerWageID->values, Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_worker_id.name', ''),
                    'worker_status_id' => $shopWorkerWageID->values['worker_status_id'],
                );
                $shopWorkerID = $tmp;
            }else{
                $shopWorkerID = $shopWorkerIDs->childs[$shopWorkerID];
            }

            $tmp = intval(Helpers_DateTime::getMonth($shopWorkerWageID->values['date']));
            if($tmp > 6){
                $tmp = $tmp - 6;
            }

            $shopWorkerID->values[$tmp] = $shopWorkerWageID->values['wage'];
            $shopWorkerID->isFindDB = TRUE;
            $shopWorkerID->isLoadElements = TRUE;
        }
        $shopWorkerIDs->additionDatas['half_year'] = $halfYear;
        $data = $this->_sitePageData->replaceDatas['view::_shop/worker/wage/list/six-month'] =
            Helpers_View::getViewObjects($shopWorkerIDs, new Model_Tax_Shop_Worker(), '_shop/worker/wage/list/six-month',
                '_shop/worker/wage/one/six-month', $this->_sitePageData, $this->_driverDB);

        $this->response->body($this->_sitePageData->replaceStaticDatas($data));
    }

    public function action_new()
    {
        $this->_sitePageData->url = '/tax/shopworkerwage/new';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/worker/wage/one/new',
            )
        );

        $this->_requestShopWorkers();
        $this->_requestWorkerStatuses();

        $dataID = new MyArray();
        $dataID->id = 0;
        $dataID->isFindDB = TRUE;

        $data = $this->_sitePageData->replaceDatas['view::_shop/worker/wage/one/new'] = Helpers_View::getViewObject($dataID, new Model_Tax_Shop_Worker_Wage(),
            '_shop/worker/wage/one/new', $this->_sitePageData, $this->_driverDB);

        $this->response->body($this->_sitePageData->replaceStaticDatas($data));
    }

    public function action_edit()
    {
        $this->_sitePageData->url = '/tax/shopworkerwage/edit';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/worker/wage/one/edit',
            )
        );

        // id записи
        $shopWorkerWageID = Request_RequestParams::getParamInt('id');
        if ($shopWorkerWageID === NULL) {
            throw new HTTP_Exception_404('Worker wage not is found!');
        }else {
            $model = new Model_Tax_Shop_Worker_Wage();
            if (! $this->dublicateObjectLanguage($model, $shopWorkerWageID)) {
                throw new HTTP_Exception_404('Worker wage not is found!');
            }
        }

        $this->_requestShopWorkers($model->getShopWorkerID());
        $this->_requestWorkerStatuses($model->getWorkerStatusID());

        // получаем данные
        $data = View_View::findOne('DB_Tax_Shop_Worker_Wage', $this->_sitePageData->shopID, "_shop/worker/wage/one/edit",
            $this->_sitePageData, $this->_driverDB, array('id' => $shopWorkerWageID), array());

        $this->response->body($this->_sitePageData->replaceStaticDatas($data));
    }

    public function action_save()
    {
        $this->_sitePageData->url = '/tax/shopworkerwage/save';

        $result = Api_Tax_Shop_Worker_Wage::save($this->_sitePageData, $this->_driverDB);

        if (Request_RequestParams::getParamBoolean('json') || $result['result']['error']) {
            $result = $result['result'];

            $result['values']['shop_worker_name'] = '';
            $tmp = $result['values']['shop_worker_id'];
            if ($tmp > 0){
                $model = new Model_Tax_Shop_Worker();
                if($this->getDBObject($model, $tmp)){
                    $result['values']['shop_worker_name'] = $model->getName();
                }
            }

            $result['values']['worker_status_name'] = '';
            $tmp = $result['values']['worker_status_id'];
            if ($tmp > 0){
                $model = new Model_Tax_WorkerStatus();
                if($this->getDBObject($model, $tmp)){
                    $result['values']['worker_status_name'] = $model->getName();
                }
            }

            $this->response->body(Json::json_encode($result));
        } else {
            $branchID = '';
            if($this->_sitePageData->branchID > 0){
                $branchID = '&shop_branch_id='.$this->_sitePageData->branchID;
            }

            if(Request_RequestParams::getParamBoolean('is_close') === FALSE){
                $this->redirect('/tax/shopworkerwage/edit'
                    . URL::query(
                        array(
                            'id' => $result['id'],
                        ),
                        FALSE
                    )
                    .$branchID
                );
            }else {
                $this->redirect('/tax/shopworkerwage/index'
                    . URL::query(
                        array(
                            'is_public_ignore' => TRUE,
                        ),
                        FALSE
                    )
                    .$branchID
                );
            }
        }
    }
}
