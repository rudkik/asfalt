<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Tax_Client_ShopPaymentOrder extends Controller_Tax_Client_BasicTax {

    public function __construct(Request $request, Response $response)
    {
        $this->controllerName = 'shoppaymentorder';
        $this->tableID = Model_Tax_Shop_Payment_Order::TABLE_ID;
        $this->tableName = Model_Tax_Shop_Payment_Order::TABLE_NAME;
        $this->objectName = 'paymentorder';

        parent::__construct($request, $response);
    }

    public function action_index() {
        $this->_sitePageData->url = '/tax/shoppaymentorder/index';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/payment/order/list/index',
                'view::_shop/payment/order/item/list/index',
            )
        );

        // получаем данные
        $this->_sitePageData->replaceDatas['view::_shop/payment/order/item/list/index'] =
            Helpers_View::getViewObjects(new MyArray(), new Model_Tax_Shop_Payment_Order_Item(),
                '_shop/payment/order/item/list/index', '_shop/payment/order/item/one/index',
                $this->_sitePageData, $this->_driverDB);

        // получаем список
        View_View::find('DB_Tax_Shop_Payment_Order', $this->_sitePageData->shopID, "_shop/payment/order/list/index",
            "_shop/payment/order/one/index", $this->_sitePageData, $this->_driverDB, array(),
            array('bank_id' => array('name')), TRUE, TRUE);

        $this->_putInMain('/main/_shop/payment/order/index');
    }

    public function action_json() {
        $this->_sitePageData->url = '/tax/shoppaymentorder/json';

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
        $ids = Request_Tax_Shop_Payment_Order::findShopPaymentOrderIDs($this->_sitePageData->shopID,
            $this->_sitePageData, $this->_driverDB, $params, 5000, TRUE,
            array('shop_contractor_id' => array('name'), 'kbk_id' => array('code'), 'kbe_id' => array('code'),
                'gov_contractor_id' => array('name'), 'knp_id' => array('code')));

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
                        if($child->values['gov_contractor_id'] > 0){
                            $values[$field] = Arr::path($child->values, Model_Basic_BasicObject::FIELD_ELEMENTS.'.gov_contractor_id.name', '');
                        }else {
                            $values[$field] = Arr::path($child->values, Model_Basic_BasicObject::FIELD_ELEMENTS . '.shop_contractor_id.name', '');
                        }
                    }elseif ($field == 'kbk_code'){
                        $values[$field] = Arr::path($child->values, Model_Basic_BasicObject::FIELD_ELEMENTS.'.kbk_id.code', '');
                    }elseif ($field == 'knp_code'){
                        $values[$field] = Arr::path($child->values, Model_Basic_BasicObject::FIELD_ELEMENTS.'.knp_id.code', '');
                    }elseif ($field == 'kbe_code'){
                        $values[$field] = Arr::path($child->values, Model_Basic_BasicObject::FIELD_ELEMENTS.'.kbe_id.code', '');
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
        $this->_sitePageData->url = '/tax/shoppaymentorder/new';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/payment/order/one/new',
                'view::_shop/payment/order/item/list/index',
                'view::gov_contractor_name',
            )
        );


        $this->_requestKBKs();
        $this->_requestKBes();
        $this->_requestKNPs();
        $this->_requestShopBankAccounts(Arr::path($this->_sitePageData->shop->getRequisitesArray(), 'shop_bank_account_id', 0));

        $govContractorID = Request_RequestParams::getParamInt('gov_contractor_id');
        if(($govContractorID < 1)) {
            $this->_requestShopContractors();
        }else{
            // выбор бенефециара госудаства
            $model = new Model_Tax_GovContractor();
            $this->getDBObject($model, $govContractorID);
            $this->_sitePageData->replaceDatas['view::gov_contractor_name'] = $model->getName();
        }

        // выбор налогового коммитета
        $authorityID = Request_RequestParams::getParamInt('authority_id');
        if($authorityID > 0) {
            $this->_requestAuthorities();
        }

        // получаем данные
        $this->_sitePageData->replaceDatas['view::_shop/payment/order/item/list/index'] =
            Helpers_View::getViewObjects(new MyArray(), new Model_Tax_Shop_Payment_Order_Item(),
            '_shop/payment/order/item/list/index', '_shop/payment/order/item/one/index',
            $this->_sitePageData, $this->_driverDB);

        $dataID = new MyArray();
        $dataID->id = 0;
        $dataID->isFindDB = TRUE;

        $data = $this->_sitePageData->replaceDatas['view::_shop/payment/order/one/new'] = Helpers_View::getViewObject($dataID, new Model_Tax_Shop_Payment_Order(),
            '_shop/payment/order/one/new', $this->_sitePageData, $this->_driverDB);

        $this->response->body($this->_sitePageData->replaceStaticDatas($data));
    }

    public function action_edit()
    {
        $this->_sitePageData->url = '/tax/shoppaymentorder/edit';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/payment/order/one/edit',
                'view::_shop/payment/order/item/list/index',
            )
        );

        // id записи
        $shopPaymentOrderID = Request_RequestParams::getParamInt('id');
        if ($shopPaymentOrderID === NULL) {
            throw new HTTP_Exception_404('Payment order not is found!');
        }else {
            $model = new Model_Tax_Shop_Payment_Order();
            if (! $this->dublicateObjectLanguage($model, $shopPaymentOrderID)) {
                throw new HTTP_Exception_404('Payment order not is found!');
            }
        }

        if(($model->getGovContractorID() < 1)) {
            $this->_requestShopContractors($model->getShopContractorID());
        }
        if($model->getAuthorityID() > 0) {
            $this->_requestAuthorities($model->getAuthorityID());
        }

        $this->_requestKBKs($model->getKBKID());
        $this->_requestKBes($model->getKBeID());
        $this->_requestKNPs($model->getKNPID());
        $this->_requestShopBankAccounts($model->getShopBankAccountID());

        View_View::find('DB_Tax_Shop_Payment_Order_Item', $this->_sitePageData->shopID,
            '_shop/payment/order/item/list/index', '_shop/payment/order/item/one/index',
            $this->_sitePageData, $this->_driverDB, array('shop_paymentorder_id' => $shopPaymentOrderID, Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE),
            array('shop_worker_id' => array('name', 'iin', 'date_of_birth')));

        // получаем данные
        $data = View_View::findOne('DB_Tax_Shop_Payment_Order', $this->_sitePageData->shopID, "_shop/payment/order/one/edit",
            $this->_sitePageData, $this->_driverDB, array('id' => $shopPaymentOrderID), array('gov_contractor_id' => array('name')));

        $this->response->body($this->_sitePageData->replaceStaticDatas($data));
    }

    public function action_save()
    {
        $this->_sitePageData->url = '/tax/shoppaymentorder/save';

        $result = Api_Tax_Shop_Payment_Order::save($this->_sitePageData, $this->_driverDB);

        if (Request_RequestParams::getParamBoolean('json') || $result['result']['error']) {
            $result = $result['result'];

            $result['values']['shop_contractor_name'] = '';
            if (key_exists('shop_contractor_id', $result['values'])) {
                $tmp = $result['values']['shop_contractor_id'];
                if ($tmp > 0) {
                    $model = new Model_Tax_Shop_Contractor();
                    if ($this->getDBObject($model, $tmp)) {
                        $result['values']['shop_contractor_name'] = $model->getName();
                    }
                }
            }
            if (key_exists('gov_contractor_id', $result['values'])) {
                $tmp = $result['values']['gov_contractor_id'];
                if ($tmp > 0) {
                    $model = new Model_Tax_GovContractor();
                    if ($this->getDBObject($model, $tmp)) {
                        $result['values']['shop_contractor_name'] = $model->getName();
                    }
                }
            }

            $result['values']['kbk_code'] = '';
            $tmp = $result['values']['kbk_id'];
            if ($tmp > 0){
                $model = new Model_Tax_KBK();
                if($this->getDBObject($model, $tmp)){
                    $result['values']['kbk_code'] = $model->getCode();
                }
            }

            $result['values']['knp_code'] = '';
            $tmp = $result['values']['knp_id'];
            if ($tmp > 0){
                $model = new Model_Tax_KNP();
                if($this->getDBObject($model, $tmp)){
                    $result['values']['knp_code'] = $model->getCode();
                }
            }

            $result['values']['kbe_code'] = '';
            $tmp = $result['values']['kbe_id'];
            if ($tmp > 0){
                $model = new Model_Tax_KBe();
                if($this->getDBObject($model, $tmp)){
                    $result['values']['kbe_code'] = $model->getCode();
                }
            }

            $this->response->body(Json::json_encode($result));
        } else {
            $branchID = '';
            if($this->_sitePageData->branchID > 0){
                $branchID = '&shop_branch_id='.$this->_sitePageData->branchID;
            }

            if(Request_RequestParams::getParamBoolean('is_close') === FALSE){
                $this->redirect('/tax/shoppaymentorder/edit'
                    . URL::query(
                        array(
                            'id' => $result['id'],
                        ),
                        FALSE
                    )
                    .$branchID
                );
            }else {
                $this->redirect('/tax/shoppaymentorder/index'
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
