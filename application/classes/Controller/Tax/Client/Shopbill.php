<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Tax_Client_ShopBill extends Controller_Tax_Client_BasicTax {

    public function __construct(Request $request, Response $response)
    {
        $this->controllerName = 'shopbill';
        $this->tableID = Model_Tax_Shop_Bill::TABLE_ID;
        $this->tableName = Model_Tax_Shop_Bill::TABLE_NAME;
        $this->objectName = 'bill';

        parent::__construct($request, $response);
    }

    public function action_index() {
        $this->_sitePageData->url = '/tax/shopbill/index';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/bill/list/index',
            )
        );

        // получаем список
        View_View::find('DB_Tax_Shop_Bill', $this->_sitePageData->shopID, "_shop/bill/list/index",
            "_shop/bill/one/index", $this->_sitePageData, $this->_driverDB, array(),
            array('shop_good_id' => array('name')), TRUE, TRUE);

        $this->_putInMain('/main/_shop/bill/index');
    }

    public function action_list() {
        $this->_sitePageData->url = '/tax/shopbill/list';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/bill/list/list',
            )
        );

        // получаем список
        $data = View_View::find('DB_Tax_Shop_Bill', $this->_sitePageData->shopID, "_shop/bill/list/list",
            "_shop/bill/one/list", $this->_sitePageData, $this->_driverDB,
            array('sort_by' => array('value' => array('created_at' => 'desc'))), array('shop_good_id' => array('name')));

        $this->response->body($this->_sitePageData->replaceStaticDatas($data));
    }

    public function action_show()
    {
        $this->_sitePageData->url = '/tax/shopbill/show';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/bill/one/show',
            )
        );

        // id записи
        $shopBillID = Request_RequestParams::getParamInt('id');
        if ($shopBillID === NULL) {
            throw new HTTP_Exception_404('Bill not is found!');
        }else {
            $model = new Model_Tax_Shop_Bill();
            if (! $this->dublicateObjectLanguage($model, $shopBillID)) {
                throw new HTTP_Exception_404('Bill not is found!');
            }
        }

        $this->_requestShopContractors($model->getShopContractorID());

        // получаем данные
        $data = View_View::findOne('DB_Tax_Shop_Bill', $this->_sitePageData->shopID, "_shop/bill/one/edit",
            $this->_sitePageData, $this->_driverDB, array('id' => $shopBillID), array('shop_good_id' => array('name')));

        $this->response->body($this->_sitePageData->replaceStaticDatas($data));
    }

    public function action_add() {
        $this->_sitePageData->url = '/tax/shopbill/add';

        $result = Api_Tax_Shop_Bill::add(Request_RequestParams::getParamInt('shop_good_id'),
            $this->_sitePageData, $this->_driverDB);

        $this->redirect('/tax/site/pays?shop_bill_id='.$result['id']);

        $this->_redirectSaveResult($result);
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
        $params[Request_RequestParams::IS_NOT_READ_REQUEST_NAME] = TRUE;

        // получаем список
        $ids = Request_Tax_Shop_Bill::findShopBillIDs($this->_sitePageData->shopID,
            $this->_sitePageData, $this->_driverDB, $params, 5000, TRUE,
            array('shop_good_id' => array('name')));

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
                    }elseif ($field == 'shop_good_name'){
                        $values[$field] = Arr::path($child->values, Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_good_id.name', '');
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

    public function action_save()
    {
        $this->_sitePageData->url = '/tax/shopbill/save';

        $result = Api_Tax_Shop_Bill::save($this->_sitePageData, $this->_driverDB);

        $this->_redirectSaveResult(
            $result,
            array(
                'shop_good_name' => array(
                    'id' => 'shop_good_id',
                    'model' => new Model_Shop_Good(),
                ),
            )
        );
    }

    /**
     * Делаем запрос на список доставок
     * @param null|int $currentID
     */
    protected function _requestAkimats($currentID = NULL)
    {
        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::akimat/list/list',
            )
        );
        $data = View_View::findAll('DB_Tax_Akimat', $this->_sitePageData->shopID,
            "akimat/list/list", "akimat/one/list", $this->_sitePageData, $this->_driverDB,
            array('sort_by' => array('value' => array('name' => 'asc')), Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE));

        if ($currentID !== NULL) {
            $s = 'data-id="' . $currentID . '"';
            $data = str_replace($s, $s . ' selected', $data);
            $this->_sitePageData->replaceDatas['view::akimat/list/list'] = $data;
        }
    }
}
