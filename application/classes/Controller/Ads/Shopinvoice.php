<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ads_ShopInvoice extends Controller_Ads_BasicAds {

    public function __construct(Request $request, Response $response)
    {
        $this->controllerName = 'shopinvoice';
        $this->tableID = Model_Ads_Shop_Invoice::TABLE_ID;
        $this->tableName = Model_Ads_Shop_Invoice::TABLE_NAME;
        $this->objectName = 'invoice';

        parent::__construct($request, $response);
    }

    public function action_index() {
        $this->_sitePageData->url = '/ads/shopinvoice/index';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/invoice/list/index',
            )
        );

        // получаем список
        View_View::find('DB_Ads_Shop_Invoice', $this->_sitePageData->shopID, "_shop/invoice/list/index",
            "_shop/invoice/one/index", $this->_sitePageData, $this->_driverDB, array(),
            array(), TRUE, TRUE);

        $this->_putInMain('/main/_shop/invoice/index');
    }

    public function action_list() {
        $this->_sitePageData->url = '/ads/shopinvoice/list';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/invoice/list/list',
            )
        );

        // получаем список
        $data = View_View::find('DB_Ads_Shop_Invoice', $this->_sitePageData->shopID, "_shop/invoice/list/list",
            "_shop/invoice/one/list", $this->_sitePageData, $this->_driverDB,
            array('sort_by' => array('value' => array('name' => 'asc'))));

        $this->response->body($this->_sitePageData->replaceStaticDatas($data));
    }

    public function action_json() {
        $this->_sitePageData->url = '/ads/shopinvoice/json';

        $params = array_merge($_POST, $_GET);
        if ((key_exists('offset', $params)) && (intval($params['offset']) > 0)) {
            $params['page'] =  round($params['offset'] / $params['limit']) + 1;
        }
        if ((key_exists('sort', $params)) ) {
            $params['sort_by'] = array('value' => array($params['sort'] => Arr::path($params, 'order', 'desc')));
        }
        if ((key_exists('limit', $params)) ) {
            $params['limit_page'] = intval($params['limit']);
            unset($params['limit']);
        }else{
            $params['limit_page'] = 25;
        }
        $params[Request_RequestParams::IS_NOT_READ_REQUEST_NAME] = TRUE;

        // получаем список
        $ids = Request_Request::find('DB_Ads_Shop_Invoice', $this->_sitePageData->shopID,
            $this->_sitePageData, $this->_driverDB, $params, 5000, TRUE,
            array('shop_client_id' => array('name')));

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
                    }elseif ($field == 'shop_client_name'){
                        $values[$field] = Arr::path($child->values, Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_client_id.name', '');
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
        $this->_sitePageData->url = '/ads/shopinvoice/new';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/invoice/one/new',
            )
        );

        $dataID = new MyArray();
        $dataID->id = 0;
        $dataID->isFindDB = TRUE;

        $data = $this->_sitePageData->replaceDatas['view::_shop/invoice/one/new'] = Helpers_View::getViewObject($dataID, new Model_Ads_Shop_Invoice(),
            '_shop/invoice/one/new', $this->_sitePageData, $this->_driverDB);

        $this->response->body($this->_sitePageData->replaceStaticDatas($data));
    }

    public function action_edit()
    {
        $this->_sitePageData->url = '/ads/shopinvoice/edit';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/invoice/one/edit',
            )
        );

        // id записи
        $shopInvoiceID = Request_RequestParams::getParamInt('id');
        $model = new Model_Ads_Shop_Invoice();
        if (! $this->dublicateObjectLanguage($model, $shopInvoiceID, -1, FALSE)) {
            throw new HTTP_Exception_404('Invoice not is found!');
        }
        $model->getElement('shop_client_id', TRUE);

        // получаем данные
        $data = View_View::findOne('DB_Ads_Shop_Invoice', $this->_sitePageData->shopID, "_shop/invoice/one/edit",
            $this->_sitePageData, $this->_driverDB, array('id' => $shopInvoiceID), array());

        $this->response->body($this->_sitePageData->replaceStaticDatas($data));
    }

    public function action_save()
    {
        $this->_sitePageData->url = '/ads/shopinvoice/save';

        $result = Api_Ads_Shop_Invoice::save($this->_sitePageData, $this->_driverDB);

        $this->_redirectSaveResult(
            $result,
            array(
                'shop_client_name' => array(
                    'id' => 'shop_client_id',
                    'model' => new Model_Ads_Shop_Client(),
                ),
            )
        );
    }

    public function action_del()
    {
        $this->_sitePageData->url = '/ads/shopinvoice/del';

        Api_Ads_Shop_Invoice::delete($this->_sitePageData, $this->_driverDB);
        $this->response->body(Json::json_encode(array('error' => TRUE)));
    }
}
