<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ads_ShopParcel extends Controller_Ads_BasicAds {

    public function __construct(Request $request, Response $response)
    {
        $this->controllerName = 'shopparcel';
        $this->tableID = Model_Ads_Shop_Parcel::TABLE_ID;
        $this->tableName = Model_Ads_Shop_Parcel::TABLE_NAME;
        $this->objectName = 'parcel';

        parent::__construct($request, $response);
    }

    public function action_index() {
        $this->_sitePageData->url = '/ads/shopparcel/index';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/parcel/list/index',
            )
        );

        $this->_requestParcelStatuses();

        // получаем список
        View_View::find('DB_Ads_Shop_Parcel', $this->_sitePageData->shopID, "_shop/parcel/list/index",
            "_shop/parcel/one/index", $this->_sitePageData, $this->_driverDB, array(),
            array(), TRUE, TRUE);

        $this->_putInMain('/main/_shop/parcel/index');
    }

    public function action_list() {
        $this->_sitePageData->url = '/ads/shopparcel/list';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/parcel/list/list',
            )
        );

        // получаем список
        $data = View_View::find('DB_Ads_Shop_Parcel', $this->_sitePageData->shopID, "_shop/parcel/list/list",
            "_shop/parcel/one/list", $this->_sitePageData, $this->_driverDB,
            array('sort_by' => array('value' => array('name' => 'asc'))));

        $this->response->body($this->_sitePageData->replaceStaticDatas($data));
    }

    public function action_json() {
        $this->_sitePageData->url = '/ads/shopparcel/json';

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
        $ids = Request_Request::find('DB_Ads_Shop_Parcel', $this->_sitePageData->shopID,
            $this->_sitePageData, $this->_driverDB, $params, 5000, TRUE,
            array('shop_client_id' => array('name'), 'delivery_type_id' => array('name'), 'parcel_status_id' => array('name')));

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
                    }elseif ($field == 'parcel_status_name'){
                        $values[$field] = Arr::path($child->values, Model_Basic_BasicObject::FIELD_ELEMENTS.'.parcel_status_id.name', '');
                    }elseif ($field == 'delivery_type_name'){
                        $values[$field] = Arr::path($child->values, Model_Basic_BasicObject::FIELD_ELEMENTS.'.delivery_type_id.name', '');
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
        $this->_sitePageData->url = '/ads/shopparcel/new';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/parcel/one/new',
            )
        );

        $this->_requestDeliveryTypes();

        $dataID = new MyArray();
        $dataID->id = 0;
        $dataID->isFindDB = TRUE;

        $data = $this->_sitePageData->replaceDatas['view::_shop/parcel/one/new'] = Helpers_View::getViewObject($dataID, new Model_Ads_Shop_Parcel(),
            '_shop/parcel/one/new', $this->_sitePageData, $this->_driverDB);

        $this->response->body($this->_sitePageData->replaceStaticDatas($data));
    }

    public function action_edit()
    {
        $this->_sitePageData->url = '/ads/shopparcel/edit';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/parcel/one/edit',
            )
        );

        // id записи
        $shopParcelID = Request_RequestParams::getParamInt('id');
        if ($shopParcelID === NULL) {
            throw new HTTP_Exception_404('Parcel not is found!');
        }else {
            $model = new Model_Ads_Shop_Parcel();
            if (! $this->dublicateObjectLanguage($model, $shopParcelID)) {
                throw new HTTP_Exception_404('Parcel not is found!');
            }
        }

        $this->_requestDeliveryTypes($model->getDeliveryTypeID());
        $this->_requestParcelStatuses($model->getParcelStatusID());

        // получаем данные
        $data = View_View::findOne('DB_Ads_Shop_Parcel', $this->_sitePageData->shopID, "_shop/parcel/one/edit",
            $this->_sitePageData, $this->_driverDB, array('id' => $shopParcelID), array('shop_client_id' => array('name')));

        $this->response->body($this->_sitePageData->replaceStaticDatas($data));
    }

    public function action_save()
    {
        $this->_sitePageData->url = '/ads/shopparcel/save';

        $result = Api_Ads_Shop_Parcel::save($this->_sitePageData, $this->_driverDB);

        $this->_redirectSaveResult(
            $result,
            array(
                'shop_client_name' => array(
                    'id' => 'shop_client_id',
                    'model' => new Model_Ads_Shop_Client(),
                ),
                'parcel_status_name' => array(
                    'id' => 'parcel_status_id',
                    'model' => new Model_Ads_ParcelStatus(),
                ),
                'delivery_type_name' => array(
                    'id' => 'delivery_type_id',
                    'model' => new Model_DeliveryType(),
                ),
            )
        );
    }

    /**
     * Делаем запрос на список доставок
     * @param null|int $currentID
     */
    protected function _requestDeliveryTypes($currentID = NULL)
    {
        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::delivery-type/list/list',
            )
        );
        $data = View_View::findOne('DB_DeliveryType', $this->_sitePageData->shopID,
            "delivery-type/list/list", "delivery-type/one/list", $this->_sitePageData, $this->_driverDB,
            array('sort_by' => array('value' => array('name' => 'asc')), Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE));

        if ($currentID !== NULL) {
            $s = 'data-id="' . $currentID . '"';
            $data = str_replace($s, $s . ' selected', $data);
            $this->_sitePageData->replaceDatas['view::delivery-type/list/list'] = $data;
        }
    }

    /**
     * Делаем запрос на список доставок
     * @param null|int $currentID
     */
    protected function _requestParcelStatuses($currentID = NULL)
    {
        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::parcel-status/list/list',
            )
        );
        $params = Request_RequestParams::setParams(
            array(
                'sort_by' => array(
                    'order' => 'asc',
                    'name' => 'asc',
                )
            )
        );
        $data = View_View::find('DB_Ads_ParcelStatus', $this->_sitePageData->shopID,
            "parcel-status/list/list", "parcel-status/one/list", $this->_sitePageData, $this->_driverDB,
            $params);

        if ($currentID !== NULL) {
            $s = 'data-id="' . $currentID . '"';
            $data = str_replace($s, $s . ' selected', $data);
            $this->_sitePageData->replaceDatas['view::parcel-status/list/list'] = $data;
        }
    }
}
