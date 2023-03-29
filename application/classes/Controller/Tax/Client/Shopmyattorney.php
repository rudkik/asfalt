<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Tax_Client_ShopMyAttorney extends Controller_Tax_Client_BasicTax {

    public function __construct(Request $request, Response $response)
    {
        $this->controllerName = 'shopmyattorney';
        $this->tableID = Model_Tax_Shop_My_Attorney::TABLE_ID;
        $this->tableName = Model_Tax_Shop_My_Attorney::TABLE_NAME;
        $this->objectName = 'attorney';

        parent::__construct($request, $response);
    }

    public function action_index() {
        $this->_sitePageData->url = '/tax/shopmyattorney/index';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/my/attorney/list/index',
            )
        );

        // получаем список
        View_View::find('DB_Tax_Shop_My_Attorney', $this->_sitePageData->shopID, "_shop/my/attorney/list/index",
            "_shop/my/attorney/one/index", $this->_sitePageData, $this->_driverDB, array(),
            array('shop_worker_id' => array('name')), TRUE, TRUE);

        $this->_putInMain('/main/_shop/my/attorney/index');
    }

    public function action_list() {
        $this->_sitePageData->url = '/tax/shopmyattorney/list';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/my/attorney/list/list',
            )
        );

        // получаем список
        $data = View_View::find('DB_Tax_Shop_My_Attorney', $this->_sitePageData->shopID, "_shop/my/attorney/list/list",
            "_shop/my/attorney/one/list", $this->_sitePageData, $this->_driverDB,
            array('sort_by' => array('value' => array('name' => 'asc'))), array('shop_worker_id' => array('name')));

        $this->response->body($this->_sitePageData->replaceStaticDatas($data));
    }

    public function action_json() {
        $this->_sitePageData->url = '/tax/shopmyattorney/json';

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
        $ids = Request_Tax_Shop_My_Attorney::findShopAttorneyIDs($this->_sitePageData->shopID,
            $this->_sitePageData, $this->_driverDB, $params, 5000, TRUE,
            array('shop_worker_id' => array('name'), 'shop_contractor_id' => array('name')));

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
                    }elseif ($field == 'shop_contractor_name'){
                        $values[$field] = Arr::path($child->values, Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_contractor_id.name', '');
                    }elseif ($field == 'shop_worker_name'){
                        $values[$field] = Arr::path($child->values, Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_worker_id.name', '');
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
        $this->_sitePageData->url = '/tax/shopmyattorney/new';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/my/attorney/one/new',
                'view::_shop/my/attorney/item/list/index',
            )
        );

        $this->_requestShopContractors();
        $this->_requestShopWorkers();

        $requisites = $this->_sitePageData->shop->getRequisitesArray();
        $this->_requestShopBankAccounts(Arr::path($requisites, 'shop_bank_account_id', 0));

        // получаем данные
        $this->_sitePageData->replaceDatas['view::_shop/my/attorney/item/list/index'] =
            Helpers_View::getViewObjects(new MyArray(), new Model_Tax_Shop_Invoice_Commercial_Item(),
                '_shop/my/attorney/item/list/index', '_shop/my/attorney/item/one/index',
                $this->_sitePageData, $this->_driverDB);

        $dataID = new MyArray();
        $dataID->id = 0;
        $dataID->isFindDB = TRUE;

        $data = $this->_sitePageData->replaceDatas['view::_shop/my/attorney/one/new'] =
            Helpers_View::getViewObject($dataID, new Model_Tax_Shop_My_Attorney(),
            '_shop/my/attorney/one/new', $this->_sitePageData, $this->_driverDB);

        $this->response->body($this->_sitePageData->replaceStaticDatas($data));
    }

    public function action_edit()
    {
        $this->_sitePageData->url = '/tax/shopmyattorney/edit';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/my/attorney/one/edit',
                'view::_shop/my/attorney/item/list/index',
            )
        );

        // id записи
        $id = Request_RequestParams::getParamInt('id');
        $model = new Model_Tax_Shop_My_Attorney();
        if (! $this->dublicateObjectLanguage($model, $id, -1, FALSE)) {
            throw new HTTP_Exception_404('Attorney not is found!');
        }

        $this->_requestShopContractors($model->getShopContractorID());
        $this->_requestShopWorkers($model->getShopWorkerID());
        $this->_requestShopBankAccounts($model->getShopBankAccountID());

        View_View::find('DB_Tax_Shop_My_Attorney_Item', $this->_sitePageData->shopID,
            '_shop/my/attorney/item/list/index', '_shop/my/attorney/item/one/index',
            $this->_sitePageData, $this->_driverDB, array('shop_my_attorney_id' => $id, Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE),
            array('shop_product_id' => array('name', 'is_service'), 'unit_id' => array('name')));

        // получаем данные
        $data = View_View::findOne('DB_Tax_Shop_My_Attorney', $this->_sitePageData->shopID, "_shop/my/attorney/one/edit",
            $this->_sitePageData, $this->_driverDB, array('id' => $id), array());

        $this->response->body($this->_sitePageData->replaceStaticDatas($data));
    }

    public function action_save()
    {
        $this->_sitePageData->url = '/tax/shopmyattorney/save';

        $result = Api_Tax_Shop_My_Attorney::save($this->_sitePageData, $this->_driverDB);

        if (Request_RequestParams::getParamBoolean('json') || $result['result']['error']) {
            $result = $result['result'];

            $result['values']['shop_contractor_name'] = '';
            $tmp = $result['values']['shop_contractor_id'];
            if ($tmp > 0){
                $model = new Model_Tax_Shop_Contractor();
                if($this->getDBObject($model, $tmp)){
                    $result['values']['shop_contractor_name'] = $model->getName();
                }
            }

            $result['values']['shop_worker_name'] = '';
            $tmp = $result['values']['shop_worker_id'];
            if ($tmp > 0){
                $model = new Model_Tax_Shop_Worker();
                if($this->getDBObject($model, $tmp)){
                    $result['values']['shop_worker_name'] = $model->getName();
                }
            }

            $this->response->body(Json::json_encode($result));
        } else {
            $branchID = '';
            if($this->_sitePageData->branchID > 0){
                $branchID = '&shop_branch_id='.$this->_sitePageData->branchID;
            }

            if(Request_RequestParams::getParamBoolean('is_close') === FALSE){
                $this->redirect('/tax/shopmyattorney/edit'
                    . URL::query(
                        array(
                            'id' => $result['id'],
                        ),
                        FALSE
                    )
                    .$branchID
                );
            }else {
                $this->redirect('/tax/shopmyattorney/index'
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

    /**
     * Делаем запрос на список доставок
     * @param null|int $currentID
     */
    protected function _requestShopContractors($currentID = NULL)
    {
        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/contractor/list/list',
            )
        );
        $data = View_View::find('DB_Tax_Shop_Contractor', $this->_sitePageData->shopID,
            "_shop/contractor/list/list", "_shop/contractor/one/list", $this->_sitePageData, $this->_driverDB,
            array('sort_by' => array('value' => array('name' => 'asc')), Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE));

        if ($currentID !== NULL) {
            $s = 'data-id="' . $currentID . '"';
            $data = str_replace($s, $s . ' selected', $data);
            $this->_sitePageData->replaceDatas['view::_shop/contractor/list/list'] = $data;
        }
    }

    /**
     * Делаем запрос на список доставок
     * @param null|int $currentID
     */
    protected function _requestShopWorkers($currentID = NULL)
    {
        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/worker/list/list',
            )
        );
        $data = View_View::find('DB_Tax_Shop_Worker', $this->_sitePageData->shopID,
            "_shop/worker/list/list", "_shop/worker/one/list", $this->_sitePageData, $this->_driverDB,
            array('sort_by' => array('value' => array('name' => 'asc')), Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE));

        if ($currentID !== NULL) {
            $s = 'data-id="' . $currentID . '"';
            $data = str_replace($s, $s . ' selected', $data);
            $this->_sitePageData->replaceDatas['view::_shop/worker/list/list'] = $data;
        }
    }
}
