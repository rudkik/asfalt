<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Tax_Client_Shop extends Controller_Tax_Client_BasicTax {

    public function __construct(Request $request, Response $response)
    {
        $this->controllerName = 'shop';
        $this->tableID = Model_Shop::TABLE_ID;
        $this->tableName = Model_Shop::TABLE_NAME;
        $this->objectName = 'shop';

        parent::__construct($request, $response);
    }

    public function action_referral() {
        $this->_sitePageData->url = '/tax/shop/referral';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::shop/list/referral',
            )
        );

        $params = array_merge($_POST, $_GET);
        $params['referral_shop_id'] = $this->_sitePageData->shopID;
        $params[Request_RequestParams::IS_NOT_READ_REQUEST_NAME] = TRUE;

        // получаем список
        View_View::find('DB_Shop', $this->_sitePageData->shopID, "shop/list/referral",
            "shop/one/referral", $this->_sitePageData, $this->_driverDB,
            $params, array(), TRUE, TRUE);

        $this->_putInMain('/main/shop/referral');
    }

    public function action_json() {
        $this->_sitePageData->url = '/tax/shopbill/json';

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
        unset($params['order']);
        $params['referral_shop_id'] = $this->_sitePageData->shopID;
        $params[Request_RequestParams::IS_NOT_READ_REQUEST_NAME] = TRUE;

        // получаем список
        $ids = Request_Request::findNotShop('DB_Shop',$this->_sitePageData, $this->_driverDB,
            $params, 5000, TRUE, array());

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

    public function action_edit() {
        $this->_sitePageData->url = '/tax/shop/edit';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::shop/one/edit',
            )
        );

        $requisites = $this->_sitePageData->shop->getRequisitesArray();
        $this->_requestOrganizationTypes(Arr::path($requisites, 'organization_type_id', 0));
        $this->_requestOrganizationTaxTypes(Arr::path($requisites, 'organization_tax_type_id', 0));
        $this->_requestShopBankAccounts(Arr::path($requisites, 'shop_bank_account_id', 0));
        $this->_requestAuthorities(Arr::path($requisites, 'authority_id', 0));
        $this->_requestAkimats(Arr::path($requisites, 'akimat_id', 0));

        // получаем список заказов
        $shops = View_View::findOne('DB_Shop', $this->_sitePageData->shopID, "shop/one/edit", $this->_sitePageData, $this->_driverDB,
            array('id' => $this->_sitePageData->shopID, Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE));
        $this->_sitePageData->replaceDatas['view::shop/one/edit'] = $shops;

        $this->_putInMain('/main/shop/edit');
    }

    public function action_save()
    {
        $this->_sitePageData->url = '/tax/shop/save';

        $result = Api_Shop::save($this->_sitePageData, $this->_driverDB);

        if (Request_RequestParams::getParamBoolean('json') || $result['result']['error']) {
            $this->response->body(Json::json_encode($result));
        } else {
            $branchID = '';
            if($this->_sitePageData->branchID > 0){
                $branchID = '&shop_branch_id='.$this->_sitePageData->branchID;
            }

            $this->redirect('/tax/shop/edit'
                . URL::query(
                    array(
                        'id' => $result['id'],
                    ),
                    FALSE
                )
                .$branchID
            );
        }
    }
}
