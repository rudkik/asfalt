<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Sladushka_Main_ShopWorker extends Controller_Sladushka_Main_BasicSladushka {

    public function __construct(Request $request, Response $response)
    {
        $this->controllerName = 'shopworker';
        $this->tableID = Model_Sladushka_Shop_Worker::TABLE_ID;
        $this->tableName = Model_Sladushka_Shop_Worker::TABLE_NAME;
        $this->objectName = 'worker';

        parent::__construct($request, $response);
    }

    public function action_index() {
        $this->_sitePageData->url = '/sladushka/shopworker/index';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/worker/list/index',
            )
        );

        // получаем список
        View_View::find('DB_Sladushka_Shop_Worker', $this->_sitePageData->shopID, "_shop/worker/list/index",
            "_shop/worker/one/index", $this->_sitePageData, $this->_driverDB, array(),
            array(), TRUE, TRUE);

        $this->_putInMain('/main/_shop/worker/index');
    }

    public function action_json() {
        $this->_sitePageData->url = '/sladushka/shopworker/json';

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
        $ids = Request_Request::find('DB_Sladushka_Shop_Worker', $this->_sitePageData->shopID,
            $this->_sitePageData, $this->_driverDB, $params, 5000, TRUE);

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
        $this->_sitePageData->url = '/sladushka/shopworker/new';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/worker/one/new',
            )
        );

        $dataID = new MyArray();
        $dataID->id = 0;
        $dataID->isFindDB = TRUE;

        $data = $this->_sitePageData->replaceDatas['view::_shop/worker/one/new'] = Helpers_View::getViewObject($dataID, new Model_Sladushka_Shop_Worker(),
            '_shop/worker/one/new', $this->_sitePageData, $this->_driverDB);

        $this->response->body($data);
    }

    public function action_edit()
    {
        $this->_sitePageData->url = '/sladushka/shopworker/edit';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/worker/one/edit',
            )
        );

        // id записи
        $shopWorkerID = Request_RequestParams::getParamInt('id');
        if ($shopWorkerID === NULL) {
            throw new HTTP_Exception_404('Worker not is found!');
        }else {
            $model = new Model_Sladushka_Shop_Worker();
            if (! $this->dublicateObjectLanguage($model, $shopWorkerID)) {
                throw new HTTP_Exception_404('Worker not is found!');
            }
        }
        $model->dbGetElements($this->_sitePageData->shopID, array('bank_id'));

        // получаем данные
        $data = View_View::findOne('DB_Sladushka_Shop_Worker', $this->_sitePageData->shopID, "_shop/worker/one/edit",
            $this->_sitePageData, $this->_driverDB, array('id' => $shopWorkerID), array('bank_id'));

        $this->response->body($data);
    }

    public function action_save()
    {
        $this->_sitePageData->url = '/sladushka/shopworker/save';

        $result = Api_Sladushka_Shop_Worker::save($this->_sitePageData, $this->_driverDB);

        if (Request_RequestParams::getParamBoolean('json') || $result['result']['error']) {
            $this->response->body(Json::json_encode($result['result']));
        } else {
            $branchID = '';
            if($this->_sitePageData->branchID > 0){
                $branchID = '&shop_branch_id='.$this->_sitePageData->branchID;
            }

            if(Request_RequestParams::getParamBoolean('is_close') === FALSE){
                $this->redirect('/sladushka/shopworker/edit'
                    . URL::query(
                        array(
                            'id' => $result['id'],
                        ),
                        FALSE
                    )
                    .$branchID
                );
            }else {
                $this->redirect('/sladushka/shopworker/index'
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
