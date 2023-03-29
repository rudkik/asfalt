<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ads_ShopClient extends Controller_Ads_BasicAds {

    public function __construct(Request $request, Response $response)
    {
        $this->controllerName = 'shopclient';
        $this->tableID = Model_Ads_Shop_Client::TABLE_ID;
        $this->tableName = Model_Ads_Shop_Client::TABLE_NAME;
        $this->objectName = 'client';

        parent::__construct($request, $response);
    }

    public function action_index() {
        $this->_sitePageData->url = '/ads/shopclient/index';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/client/list/index',
            )
        );

        // получаем список
        View_View::find('DB_Ads_Shop_Client', $this->_sitePageData->shopID, "_shop/client/list/index",
            "_shop/client/one/index", $this->_sitePageData, $this->_driverDB, array(),
            array(), TRUE, TRUE);

        $this->_putInMain('/main/_shop/client/index');
    }

    public function action_list() {
        $this->_sitePageData->url = '/ads/shopclient/list';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/client/list/list',
            )
        );

        // получаем список
        $data = View_View::find('DB_Ads_Shop_Client', $this->_sitePageData->shopID, "_shop/client/list/list",
            "_shop/client/one/list", $this->_sitePageData, $this->_driverDB,
            array('sort_by' => array('value' => array('name' => 'asc'))));

        $this->response->body($this->_sitePageData->replaceStaticDatas($data));
    }

    public function action_json() {
        $this->_sitePageData->url = '/ads/shopclient/json';

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
        $ids = Request_Request::find('DB_Ads_Shop_Client', $this->_sitePageData->shopID,
            $this->_sitePageData, $this->_driverDB, $params, 5000, TRUE, array());

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
        $this->_sitePageData->url = '/ads/shopclient/new';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/client/one/new',
            )
        );

        $dataID = new MyArray();
        $dataID->id = 0;
        $dataID->isFindDB = TRUE;

        $data = $this->_sitePageData->replaceDatas['view::_shop/client/one/new'] = Helpers_View::getViewObject($dataID, new Model_Ads_Shop_Client(),
            '_shop/client/one/new', $this->_sitePageData, $this->_driverDB);

        $this->response->body($this->_sitePageData->replaceStaticDatas($data));
    }

    public function action_edit()
    {
        $this->_sitePageData->url = '/ads/shopclient/edit';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/client/one/edit',
            )
        );

        // id записи
        $shopClientID = Request_RequestParams::getParamInt('id');
        if ($shopClientID === NULL) {
            throw new HTTP_Exception_404('Client not is found!');
        }else {
            $model = new Model_Ads_Shop_Client();
            if (! $this->dublicateObjectLanguage($model, $shopClientID)) {
                throw new HTTP_Exception_404('Client not is found!');
            }
        }

        // получаем данные
        $data = View_View::findOne('DB_Ads_Shop_Client', $this->_sitePageData->shopID, "_shop/client/one/edit",
            $this->_sitePageData, $this->_driverDB, array('id' => $shopClientID), array());

        $this->response->body($this->_sitePageData->replaceStaticDatas($data));
    }

    public function action_history()
    {
        $this->_sitePageData->url = '/ads/shopclient/history';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/client/one/history',
                'view::_shop/parcel/list/history',
                'view::_shop/invoice/list/history',
            )
        );

        // id записи
        $shopClientID = Request_RequestParams::getParamInt('id');
        $model = new Model_Ads_Shop_Client();
        if (! $this->dublicateObjectLanguage($model, $shopClientID, -1, TRUE)) {
            throw new HTTP_Exception_404('Client not is found!');
        }

        // получаем данные
        $data = View_View::findOne('DB_Ads_Shop_Client', $this->_sitePageData->shopID, "_shop/client/one/history",
            $this->_sitePageData, $this->_driverDB, array('id' => $shopClientID), array());

        $params = Request_RequestParams::setParams(array('shop_client_id' => $shopClientID));

        // получаем список посылок
        View_View::find('DB_Ads_Shop_Parcel', $this->_sitePageData->shopID, "_shop/parcel/list/history",
            "_shop/parcel/one/history", $this->_sitePageData, $this->_driverDB, $params,
            array('parcel_status_id' => array('name')));

        // получаем список посылок
        View_View::find('DB_Ads_Shop_Invoice', $this->_sitePageData->shopID, "_shop/invoice/list/history",
            "_shop/invoice/one/history", $this->_sitePageData, $this->_driverDB, $params, array());

        $this->response->body($this->_sitePageData->replaceStaticDatas($data));
    }

    public function action_del()
    {
        $this->_sitePageData->url = '/ads/shopclient/del';

        Api_Ads_Shop_Client::delete($this->_sitePageData, $this->_driverDB);

        $this->response->body(Json::json_encode(array('error' => TRUE)));
    }

    public function action_save()
    {
        $this->_sitePageData->url = '/ads/shopclient/save';

        $result = Api_Ads_Shop_Client::save($this->_sitePageData, $this->_driverDB);

        $this->_redirectSaveResult($result);
    }
}
