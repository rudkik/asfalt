<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Tax_Client_ShopConfidant extends Controller_Tax_Client_BasicTax {

    public function __construct(Request $request, Response $response)
    {
        $this->controllerName = 'shopconfidant';
        $this->tableID = Model_Tax_Shop_Confidant::TABLE_ID;
        $this->tableName = Model_Tax_Shop_Confidant::TABLE_NAME;
        $this->objectName = 'confidant';

        parent::__construct($request, $response);
    }

    public function action_index() {
        $this->_sitePageData->url = '/tax/shopconfidant/index';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/confidant/list/index',
            )
        );

        // получаем список
        View_View::find('DB_Tax_Shop_Confidant', $this->_sitePageData->shopID, "_shop/confidant/list/index",
            "_shop/confidant/one/index", $this->_sitePageData, $this->_driverDB, array(),
            array('bank_id' => array('name')), TRUE, TRUE);

        $this->_putInMain('/main/_shop/confidant/index');
    }

    public function action_json() {
        $this->_sitePageData->url = '/tax/shopconfidant/json';

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
        $ids = Request_Tax_Shop_Confidant::findShopConfidantIDs($this->_sitePageData->shopID,
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
        $this->_sitePageData->url = '/tax/shopconfidant/new';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/confidant/one/new',
            )
        );

        $dataID = new MyArray();
        $dataID->id = 0;
        $dataID->isFindDB = TRUE;

        $this->_sitePageData->replaceDatas['view::_shop/confidant/one/new'] = Helpers_View::getViewObject($dataID, new Model_Tax_Shop_Confidant(),
            '_shop/confidant/one/new', $this->_sitePageData, $this->_driverDB);

        $this->_putInMain('/main/_shop/confidant/new');
    }

    public function action_edit()
    {
        $this->_sitePageData->url = '/tax/shopconfidant/edit';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/confidant/one/edit',
            )
        );

        // id записи
        $shopConfidantID = Request_RequestParams::getParamInt('id');
        if ($shopConfidantID === NULL) {
            throw new HTTP_Exception_404('Confidant not is found!');
        }else {
            $model = new Model_Tax_Shop_Confidant();
            if (! $this->dublicateObjectLanguage($model, $shopConfidantID)) {
                throw new HTTP_Exception_404('Confidant not is found!');
            }
        }
        $model->dbGetElements($this->_sitePageData->shopID, array('bank_id'));

        // получаем данные
        $data = View_View::findOne('DB_Tax_Shop_Confidant', $this->_sitePageData->shopID, "_shop/confidant/one/edit",
            $this->_sitePageData, $this->_driverDB, array('id' => $shopConfidantID), array('bank_id'));

        $this->response->body($data);
    }

    public function action_save()
    {
        $this->_sitePageData->url = '/tax/shopconfidant/save';

        $result = Api_Tax_Shop_Confidant::save($this->_sitePageData, $this->_driverDB);

        if (Request_RequestParams::getParamBoolean('json') || $result['result']['error']) {
            $this->response->body(Json::json_encode($result['result']));
        } else {
            $branchID = '';
            if($this->_sitePageData->branchID > 0){
                $branchID = '&shop_branch_id='.$this->_sitePageData->branchID;
            }

            if(Request_RequestParams::getParamBoolean('is_close') === FALSE){
                $this->redirect('/tax/shopconfidant/edit'
                    . URL::query(
                        array(
                            'id' => $result['id'],
                        ),
                        FALSE
                    )
                    .$branchID
                );
            }else {
                $this->redirect('/tax/shopconfidant/index'
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
