<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Tax_Client_ShopWorkerWageMonth extends Controller_Tax_Client_BasicTax {

    public function __construct(Request $request, Response $response)
    {
        $this->controllerName = 'shopworkerwagemonth';
        $this->tableID = Model_Tax_Shop_Worker_Wage_Month::TABLE_ID;
        $this->tableName = Model_Tax_Shop_Worker_Wage_Month::TABLE_NAME;
        $this->objectName = 'workerwagemonth';

        parent::__construct($request, $response);
    }

    public function action_index() {
        $this->_sitePageData->url = '/tax/shopworkerwagemonth/index';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/worker/wage/month/list/index',
            )
        );

        // получаем список
        View_View::find('DB_Tax_Shop_Worker_Wage_Month', $this->_sitePageData->shopID, "_shop/worker/wage/month/list/index",
            "_shop/worker/wage/month/one/index", $this->_sitePageData, $this->_driverDB, array(),
            array(), TRUE, TRUE);

        $this->_putInMain('/main/_shop/worker/wage/month/index');
    }

    public function action_json() {
        $this->_sitePageData->url = '/tax/shopworkerwagemonth/json';

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
        $ids = Request_Tax_Shop_Worker_Wage_Month::findShopWorkerWageMonthIDs($this->_sitePageData->shopID,
            $this->_sitePageData, $this->_driverDB, $params, 5000, TRUE,
            array());

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

    public function action_new()
    {
        $this->_sitePageData->url = '/tax/shopworkerwagemonth/new';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/worker/wage/month/one/new',
                'view::_shop/worker/wage/list/month',
            )
        );

        $this->_requestShopWorkers();
        $this->_requestWorkerStatuses();

        $dataID = new MyArray();
        $dataID->id = 0;
        $dataID->isFindDB = TRUE;
        $this->_sitePageData->replaceDatas['view::_shop/worker/wage/list/month'] = Helpers_View::getViewObjects($dataID,
            new Model_Tax_Shop_Worker_Wage(), '_shop/worker/wage/list/month', '_shop/worker/wage/one/month',
            $this->_sitePageData, $this->_driverDB);

        $dataID = new MyArray();
        $dataID->id = 0;
        $dataID->isFindDB = TRUE;
        $data = $this->_sitePageData->replaceDatas['view::_shop/worker/wage/month/one/new'] = Helpers_View::getViewObject($dataID, new Model_Tax_Shop_Worker_Wage_Month(),
            '_shop/worker/wage/month/one/new', $this->_sitePageData, $this->_driverDB);

        $this->response->body($this->_sitePageData->replaceStaticDatas($data));
    }

    public function action_edit()
    {
        $this->_sitePageData->url = '/tax/shopworkerwagemonth/edit';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/worker/wage/month/one/edit',
                'view::_shop/worker/wage/list/month',
            )
        );

        // id записи
        $id = Request_RequestParams::getParamInt('id');
        if ($id === NULL) {
            throw new HTTP_Exception_404('Worker wage not is found!');
        }else {
            $model = new Model_Tax_Shop_Worker_Wage_Month();
            if (! $this->dublicateObjectLanguage($model, $id)) {
                throw new HTTP_Exception_404('Worker wage not is found!');
            }
        }

        $this->_requestShopWorkers();
        $this->_requestWorkerStatuses();

        View_View::find('DB_Tax_Shop_Worker_Wage', $this->_sitePageData->shopID, "_shop/worker/wage/list/month",
            "_shop/worker/wage/one/month", $this->_sitePageData, $this->_driverDB,
            array('shop_worker_wage_month_id' => $id, Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE));

        // получаем данные
        $data = View_View::findOne('DB_Tax_Shop_Worker_Wage_Month', $this->_sitePageData->shopID, "_shop/worker/wage/month/one/edit",
            $this->_sitePageData, $this->_driverDB, array('id' => $id), array());

        $this->response->body($this->_sitePageData->replaceStaticDatas($data));
    }

    public function action_save()
    {
        $this->_sitePageData->url = '/tax/shopworkerwagemonth/save';

        $result = Api_Tax_Shop_Worker_Wage_Month::save($this->_sitePageData, $this->_driverDB);

        if (Request_RequestParams::getParamBoolean('json') || $result['result']['error']) {
            $result = $result['result'];
            $this->response->body(Json::json_encode($result));
        } else {
            $branchID = '';
            if($this->_sitePageData->branchID > 0){
                $branchID = '&shop_branch_id='.$this->_sitePageData->branchID;
            }

            if(Request_RequestParams::getParamBoolean('is_close') === FALSE){
                $this->redirect('/tax/shopworkerwagemonth/edit'
                    . URL::query(
                        array(
                            'id' => $result['id'],
                        ),
                        FALSE
                    )
                    .$branchID
                );
            }else {
                $this->redirect('/tax/shopworkerwagemonth/index'
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

    public function action_del()
    {
        $this->_sitePageData->url = '/tax/shopworkerwagemonth/del';

        Api_Tax_Shop_Worker_Wage_Month::delete($this->_sitePageData, $this->_driverDB);

        $this->response->body(Json::json_encode(array('error' => TRUE)));
    }
}
