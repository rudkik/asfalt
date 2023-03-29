<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Tax_Client_ShopTaxReturn200 extends Controller_Tax_Client_BasicTax {

    public function __construct(Request $request, Response $response)
    {
        $this->controllerName = 'shoptaxreturn200';
        $this->tableID = Model_Tax_Shop_Tax_Return_200::TABLE_ID;
        $this->tableName = Model_Tax_Shop_Tax_Return_200::TABLE_NAME;
        $this->objectName = 'taxreturn200';

        parent::__construct($request, $response);
    }

    public function action_save_pdf() {
        $this->_sitePageData->url = '/tax/shoptaxreturn200/save_pdf';
        Api_Tax_Shop_Tax_Return_200::saveInPDF(Request_RequestParams::getParamInt('id'),
            $this->_sitePageData, $this->_driverDB, '200.pdf', TRUE);
    }

    public function action_index() {
        $this->_sitePageData->url = '/tax/shoptaxreturn200/index';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/tax/return/200/list/index',
            )
        );

        // получаем список
        View_View::find('DB_Tax_Shop_Tax_Return_200', $this->_sitePageData->shopID, "_shop/tax/return/200/list/index",
            "_shop/tax/return/200/one/index", $this->_sitePageData, $this->_driverDB, array(),
            array(), TRUE, TRUE);

        $this->_putInMain('/main/_shop/tax/return/200/index');
    }

    public function action_data() {
        $this->_sitePageData->url = '/tax/shoptaxreturn200/data';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/tax/return/200/data',
                'view::_shop/worker/wage/list/six-month',
                'view::_shop/worker/wage/list/six-month-owner',
            )
        );

        // id записи
        $model = new Model_Tax_Shop_Tax_Return_200();
        $shop200ID = Request_RequestParams::getParamInt('id');
        if ($shop200ID > 0) {
            if (! $this->dublicateObjectLanguage($model, $shop200ID)) {
                throw new HTTP_Exception_404('Return 200.00 not is found!');
            }
            $halfYear = $model->getHalfYear();
            $year = $model->getYear();
        }else{
            $halfYear = intval(date('%m'));
            if($halfYear > 7){
                $halfYear = 2;
            }else{
                $halfYear = 1;
            }
            $year = date('Y');
        }
        if($halfYear == 1){
            $dateFrom = $year.'-01-01';
            $dateTo = $year.'-06-01';
        }else{
            $dateFrom = $year.'-07-01';
            $dateTo = $year.'-12-01';
        }

        $this->_requestWorkerStatuses();
        $this->_requestTaxViews($model->getTaxViewID());

        /** Для сотрудников */
        $shopWorkerWageIDs = Request_Tax_Shop_Worker_Wage::findShopWorkerWageIDs($this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB,
            array('date_from' => $dateFrom, 'date_to' => $dateTo, 'is_owner' => FALSE, Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE), 0, TRUE,
            array('shop_worker_id' => array('name')));

        // перебираем все зарплаты пострудникам за 6 месяцев
        $shopWorkerIDs = new MyArray();
        foreach ($shopWorkerWageIDs->childs as $shopWorkerWageID){
            $shopWorkerID = $shopWorkerWageID->values['shop_worker_id'];
            $workerStatusID = $shopWorkerWageID->values['worker_status_id'];

            $id = $shopWorkerID.'_'.$workerStatusID;
            if(!key_exists($id, $shopWorkerIDs->childs)){
                $tmp = $shopWorkerIDs->addUniqueChild($id, TRUE);
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
                $shopWorkerID = $shopWorkerIDs->childs[$id];
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
        $shopWorkerIDs->additionDatas['year'] = $year;
        $this->_sitePageData->replaceDatas['view::_shop/worker/wage/list/six-month'] =
            Helpers_View::getViewObjects($shopWorkerIDs, new Model_Tax_Shop_Worker(), '_shop/worker/wage/list/six-month',
                '_shop/worker/wage/one/six-month', $this->_sitePageData, $this->_driverDB);

        /** Для Владельца ИП */
        $shopOwnerWageIDs = Request_Tax_Shop_Worker_Wage::findShopWorkerWageIDs($this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB,
            array('date_from' => $dateFrom, 'date_to' => $dateTo, 'is_owner' => TRUE, Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE), 0, TRUE,
            array('shop_worker_id' => array('name')));

        // перебираем все зарплаты владельца за 6 месяцев
        $shopOwnerIDs = new MyArray();
        foreach ($shopOwnerWageIDs->childs as $shopOwnerWageID){
            $shopOwnerID = $shopOwnerWageID->values['shop_worker_id'];
            $workerStatusID = $shopOwnerWageID->values['worker_status_id'];

            $id = $shopOwnerID.'_'.$workerStatusID;
            if(!key_exists($id, $shopOwnerIDs->childs)){
                $tmp = $shopOwnerIDs->addUniqueChild($id, TRUE);
                $tmp->values = array(
                    1 => '',
                    2 => '',
                    3 => '',
                    4 => '',
                    5 => '',
                    6 => '',
                    'id' => $shopOwnerID,
                    'name' => Arr::path($shopOwnerWageID->values, Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_worker_id.name', ''),
                    'worker_status_id' => $shopOwnerWageID->values['worker_status_id'],
                );
                $shopOwnerID = $tmp;
            }else{
                $shopOwnerID = $shopOwnerIDs->childs[$id];
            }

            $tmp = intval(Helpers_DateTime::getMonth($shopOwnerWageID->values['date']));
            if($tmp > 6){
                $tmp = $tmp - 6;
            }

            $shopOwnerID->values[$tmp] = $shopOwnerWageID->values['wage'];
            $shopOwnerID->isFindDB = TRUE;
            $shopOwnerID->isLoadElements = TRUE;
        }
        $shopOwnerIDs->additionDatas['half_year'] = $halfYear;
        $shopOwnerIDs->additionDatas['year'] = $year;
        $this->_sitePageData->replaceDatas['view::_shop/worker/wage/list/six-month-owner'] =
            Helpers_View::getViewObjects($shopOwnerIDs, new Model_Tax_Shop_Worker(), '_shop/worker/wage/list/six-month-owner',
                '_shop/worker/wage/one/six-month-owner', $this->_sitePageData, $this->_driverDB);

        $dataID = new MyArray();
        $dataID->id = $model->id;
        $dataID->values = $model->getValues(TRUE, TRUE, $this->_sitePageData->shopMainID);
        if(!key_exists('half_year', $dataID->values)) {
            $dataID->values['half_year'] = $halfYear;
        }
        $dataID->isFindDB = TRUE;

        $data = $this->_sitePageData->replaceDatas['view::_shop/tax/return/200/one/data'] =
            Helpers_View::getViewObject($dataID, $model,'_shop/tax/return/200/one/data', $this->_sitePageData, $this->_driverDB);

        $this->response->body($this->_sitePageData->replaceStaticDatas($data));
    }

    public function action_json() {
        $this->_sitePageData->url = '/tax/shoptaxreturn200/json';

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
        $ids = Request_Tax_Shop_Tax_Return_200::findShopTaxReturn200IDs($this->_sitePageData->shopID,
            $this->_sitePageData, $this->_driverDB, $params, 5000, TRUE, array('tax_status_id' => array('name')));

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
                    }elseif ($field == 'tax_status_name'){
                        $values[$field] = Arr::path($child->values, Model_Basic_BasicObject::FIELD_ELEMENTS.'.tax_status_id.name', '');
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

    public function action_new_data()
    {
        $this->_sitePageData->url = '/tax/shoptaxreturn200/new_data';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/tax/return/200/new-data',
                'view::_shop/worker/wage/list/six-month',
                'view::_shop/worker/wage/list/six-month-owner',
            )
        );

        // id записи
        $model = new Model_Tax_Shop_Tax_Return_200();
        $halfYear = intval(date('%m'));
        if($halfYear > 7){
            $halfYear = 2;
        }else{
            $halfYear = 1;
        }
        $year = date('Y');
        if($halfYear == 1){
            $dateFrom = $year.'-01-01';
            $dateTo = $year.'-06-01';
        }else{
            $dateFrom = $year.'-07-01';
            $dateTo = $year.'-12-01';
        }

        $this->_requestWorkerStatuses();
        $this->_requestTaxViews($model->getTaxViewID());

        /** Для сотрудников */
        $shopWorkerWageIDs = Request_Tax_Shop_Worker_Wage::findShopWorkerWageIDs($this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB,
            array('date_from' => $dateFrom, 'date_to' => $dateTo, 'is_owner' => FALSE, Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE), 0, TRUE,
            array('shop_worker_id' => array('name')));

        // перебираем все зарплаты пострудникам за 6 месяцев
        $shopWorkerIDs = new MyArray();
        foreach ($shopWorkerWageIDs->childs as $shopWorkerWageID){
            $shopWorkerID = $shopWorkerWageID->values['shop_worker_id'];
            $workerStatusID = $shopWorkerWageID->values['worker_status_id'];

            $id = $shopWorkerID.'_'.$workerStatusID;
            if(!key_exists($id, $shopWorkerIDs->childs)){
                $tmp = $shopWorkerIDs->addUniqueChild($id, TRUE);
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
                $shopWorkerID = $shopWorkerIDs->childs[$id];
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
        $shopWorkerIDs->additionDatas['year'] = $year;
        $this->_sitePageData->replaceDatas['view::_shop/worker/wage/list/six-month'] =
            Helpers_View::getViewObjects($shopWorkerIDs, new Model_Tax_Shop_Worker(), '_shop/worker/wage/list/six-month',
                '_shop/worker/wage/one/six-month', $this->_sitePageData, $this->_driverDB);

        /** Для Владельца ИП */
        $shopOwnerWageIDs = Request_Tax_Shop_Worker_Wage::findShopWorkerWageIDs($this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB,
            array('date_from' => $dateFrom, 'date_to' => $dateTo, 'is_owner' => TRUE, Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE), 0, TRUE,
            array('shop_worker_id' => array('name')));

        // перебираем все зарплаты владельца за 6 месяцев
        $shopOwnerIDs = new MyArray();
        foreach ($shopOwnerWageIDs->childs as $shopOwnerWageID){
            $shopOwnerID = $shopOwnerWageID->values['shop_worker_id'];
            $workerStatusID = $shopOwnerWageID->values['worker_status_id'];

            $id = $shopOwnerID.'_'.$workerStatusID;
            if(!key_exists($id, $shopOwnerIDs->childs)){
                $tmp = $shopOwnerIDs->addUniqueChild($id, TRUE);
                $tmp->values = array(
                    1 => '',
                    2 => '',
                    3 => '',
                    4 => '',
                    5 => '',
                    6 => '',
                    'id' => $shopOwnerID,
                    'name' => Arr::path($shopOwnerWageID->values, Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_worker_id.name', ''),
                    'worker_status_id' => $shopOwnerWageID->values['worker_status_id'],
                );
                $shopOwnerID = $tmp;
            }else{
                $shopOwnerID = $shopOwnerIDs->childs[$id];
            }

            $tmp = intval(Helpers_DateTime::getMonth($shopOwnerWageID->values['date']));
            if($tmp > 6){
                $tmp = $tmp - 6;
            }

            $shopOwnerID->values[$tmp] = $shopOwnerWageID->values['wage'];
            $shopOwnerID->isFindDB = TRUE;
            $shopOwnerID->isLoadElements = TRUE;
        }
        $shopOwnerIDs->additionDatas['half_year'] = $halfYear;
        $shopOwnerIDs->additionDatas['year'] = $year;
        $this->_sitePageData->replaceDatas['view::_shop/worker/wage/list/six-month-owner'] =
            Helpers_View::getViewObjects($shopOwnerIDs, new Model_Tax_Shop_Worker(), '_shop/worker/wage/list/six-month-owner',
                '_shop/worker/wage/one/six-month-owner', $this->_sitePageData, $this->_driverDB);

        $dataID = new MyArray();
        $dataID->id = $model->id;
        $dataID->values = $model->getValues(TRUE, TRUE, $this->_sitePageData->shopMainID);
        if(!key_exists('half_year', $dataID->values)) {
            $dataID->values['half_year'] = $halfYear;
        }
        $dataID->isFindDB = TRUE;

        $data = $this->_sitePageData->replaceDatas['view::_shop/tax/return/200/one/new-data'] =
            Helpers_View::getViewObject($dataID, $model,'_shop/tax/return/200/one/new-data', $this->_sitePageData, $this->_driverDB);

        $this->response->body($this->_sitePageData->replaceStaticDatas($data));
    }

    public function action_edit_data()
    {
        $this->_sitePageData->url = '/tax/shoptaxreturn200/edit_data';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/tax/return/200/edit-data',
                'view::_shop/worker/wage/list/six-month',
                'view::_shop/worker/wage/list/six-month-owner',
            )
        );

        // id записи
        $model = new Model_Tax_Shop_Tax_Return_200();
        $shop200ID = Request_RequestParams::getParamInt('id');
        if (($shop200ID < 1) || (! $this->dublicateObjectLanguage($model, $shop200ID))) {
            throw new HTTP_Exception_404('Return 200.00 not is found!');
        }
        $halfYear = $model->getHalfYear();
        $year = $model->getYear();

        if($halfYear == 1){
            $dateFrom = $year.'-01-01';
            $dateTo = $year.'-06-01';
        }else{
            $dateFrom = $year.'-07-01';
            $dateTo = $year.'-12-01';
        }

        $this->_requestWorkerStatuses();
        $this->_requestTaxViews($model->getTaxViewID());

        /** Для сотрудников */
        $shopWorkerWageIDs = Request_Tax_Shop_Worker_Wage::findShopWorkerWageIDs($this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB,
            array('date_from' => $dateFrom, 'date_to' => $dateTo, 'is_owner' => FALSE, Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE), 0, TRUE,
            array('shop_worker_id' => array('name')));

        // перебираем все зарплаты пострудникам за 6 месяцев
        $shopWorkerIDs = new MyArray();
        foreach ($shopWorkerWageIDs->childs as $shopWorkerWageID){
            $shopWorkerID = $shopWorkerWageID->values['shop_worker_id'];
            $workerStatusID = $shopWorkerWageID->values['worker_status_id'];

            $id = $shopWorkerID.'_'.$workerStatusID;
            if(!key_exists($id, $shopWorkerIDs->childs)){
                $tmp = $shopWorkerIDs->addUniqueChild($id, TRUE);
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
                $shopWorkerID = $shopWorkerIDs->childs[$id];
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
        $shopWorkerIDs->additionDatas['year'] = $year;
        $this->_sitePageData->replaceDatas['view::_shop/worker/wage/list/six-month'] =
            Helpers_View::getViewObjects($shopWorkerIDs, new Model_Tax_Shop_Worker(), '_shop/worker/wage/list/six-month',
                '_shop/worker/wage/one/six-month', $this->_sitePageData, $this->_driverDB);

        /** Для Владельца ИП */
        $shopOwnerWageIDs = Request_Tax_Shop_Worker_Wage::findShopWorkerWageIDs($this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB,
            array('date_from' => $dateFrom, 'date_to' => $dateTo, 'is_owner' => TRUE, Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE), 0, TRUE,
            array('shop_worker_id' => array('name')));

        // перебираем все зарплаты владельца за 6 месяцев
        $shopOwnerIDs = new MyArray();
        foreach ($shopOwnerWageIDs->childs as $shopOwnerWageID){
            $shopOwnerID = $shopOwnerWageID->values['shop_worker_id'];
            $workerStatusID = $shopOwnerWageID->values['worker_status_id'];

            $id = $shopOwnerID.'_'.$workerStatusID;
            if(!key_exists($id, $shopOwnerIDs->childs)){
                $tmp = $shopOwnerIDs->addUniqueChild($id, TRUE);
                $tmp->values = array(
                    1 => '',
                    2 => '',
                    3 => '',
                    4 => '',
                    5 => '',
                    6 => '',
                    'id' => $shopOwnerID,
                    'name' => Arr::path($shopOwnerWageID->values, Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_worker_id.name', ''),
                    'worker_status_id' => $shopOwnerWageID->values['worker_status_id'],
                );
                $shopOwnerID = $tmp;
            }else{
                $shopOwnerID = $shopOwnerIDs->childs[$id];
            }

            $tmp = intval(Helpers_DateTime::getMonth($shopOwnerWageID->values['date']));
            if($tmp > 6){
                $tmp = $tmp - 6;
            }

            $shopOwnerID->values[$tmp] = $shopOwnerWageID->values['wage'];
            $shopOwnerID->isFindDB = TRUE;
            $shopOwnerID->isLoadElements = TRUE;
        }
        $shopOwnerIDs->additionDatas['half_year'] = $halfYear;
        $shopOwnerIDs->additionDatas['year'] = $year;
        $this->_sitePageData->replaceDatas['view::_shop/worker/wage/list/six-month-owner'] =
            Helpers_View::getViewObjects($shopOwnerIDs, new Model_Tax_Shop_Worker(), '_shop/worker/wage/list/six-month-owner',
                '_shop/worker/wage/one/six-month-owner', $this->_sitePageData, $this->_driverDB);

        $dataID = new MyArray();
        $dataID->id = $model->id;
        $dataID->values = $model->getValues(TRUE, TRUE, $this->_sitePageData->shopMainID);
        if(!key_exists('half_year', $dataID->values)) {
            $dataID->values['half_year'] = $halfYear;
        }
        $dataID->isFindDB = TRUE;

        $data = $this->_sitePageData->replaceDatas['view::_shop/tax/return/200/one/edit-data'] =
            Helpers_View::getViewObject($dataID, $model,'_shop/tax/return/200/one/edit-data', $this->_sitePageData, $this->_driverDB);

        $this->response->body($this->_sitePageData->replaceStaticDatas($data));
    }

    public function action_edit_form()
    {
        $this->_sitePageData->url = '/tax/shoptaxreturn200/edit_form';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/tax/return/200/one/edit-form',
            )
        );

        // id записи
        $shop200ID = Request_RequestParams::getParamInt('id');
        if ($shop200ID === NULL) {
            throw new HTTP_Exception_404('Tax 200.00 not is found!');
        }else {
            $model = new Model_Tax_Shop_Tax_Return_200();
            if (! $this->dublicateObjectLanguage($model, $shop200ID)) {
                throw new HTTP_Exception_404('Tax 200.00 not is found!');
            }
        }

        // получаем данные
        $data = View_View::find('DB_Tax_Shop_Tax_Return_200', $this->_sitePageData->shopID, "_shop/tax/return/200/one/edit-form",
            $this->_sitePageData, $this->_driverDB, array('id' => $shop200ID), array());

        $this->response->body($this->_sitePageData->replaceStaticDatas($data));
    }

    public function action_save_data()
    {
        $this->_sitePageData->url = '/tax/shoptaxreturn200/save_data';

        $result = Api_Tax_Shop_Tax_Return_200::saveData($this->_sitePageData, $this->_driverDB);

        if (Request_RequestParams::getParamBoolean('json') || $result['result']['error']) {
            $result = $result['result'];

            $result['values']['tax_status_name'] = '';
            $tmp = Arr::path($result['values'], 'tax_status_id', 0);
            if ($tmp > 0){
                $model = new Model_Tax_Status();
                if($this->getDBObject($model, $tmp)){
                    $result['values']['tax_status_name'] = $model->getName();
                }
            }

            $this->response->body(Json::json_encode($result));
        } else {
            $branchID = '';
            if($this->_sitePageData->branchID > 0){
                $branchID = '&shop_branch_id='.$this->_sitePageData->branchID;
            }

            if(Request_RequestParams::getParamBoolean('is_close') === FALSE){
                $this->redirect('/tax/shoptaxreturn200/edit_form'
                    . URL::query(
                        array(
                            'id' => $result['id'],
                        ),
                        FALSE
                    )
                    .$branchID
                );
            }else {
                $this->redirect('/tax/shoptaxreturn200/index'
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

    public function action_send_tax()
    {
        $this->_sitePageData->url = '/tax/shoptaxreturn200/send_tax';
         Api_Tax_Shop_Tax_Return_200::sendTax($this->_sitePageData, $this->_driverDB);
    }


    public function action_save()
    {
        $this->_sitePageData->url = '/tax/shoptaxreturn200/save';

        $result = Api_Tax_Shop_Tax_Return_200::save($this->_sitePageData, $this->_driverDB);

        if (Request_RequestParams::getParamBoolean('json') || $result['result']['error']) {
            $result = $result['result'];

            $result['values']['tax_status_name'] = '';
            $tmp = $result['values']['tax_status_id'];
            if ($tmp > 0){
                $model = new Model_Tax_Status();
                if($this->getDBObject($model, $tmp)){
                    $result['values']['tax_status_name'] = $model->getName();
                }
            }

            $this->response->body(Json::json_encode($result));
        } else {
            $branchID = '';
            if($this->_sitePageData->branchID > 0){
                $branchID = '&shop_branch_id='.$this->_sitePageData->branchID;
            }

            if(Request_RequestParams::getParamBoolean('is_close') === FALSE){
                $this->redirect('/tax/shoptaxreturn200/edit_form'
                    . URL::query(
                        array(
                            'id' => $result['id'],
                        ),
                        FALSE
                    )
                    .$branchID
                );
            }else {
                $this->redirect('/tax/shoptaxreturn200/index'
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
