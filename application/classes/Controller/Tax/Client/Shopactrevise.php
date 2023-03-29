<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Tax_Client_ShopActRevise extends Controller_Tax_Client_BasicTax {

    public function __construct(Request $request, Response $response)
    {
        $this->controllerName = 'shopactrevise';
        $this->tableID = Model_Tax_Shop_Act_Revise::TABLE_ID;
        $this->tableName = Model_Tax_Shop_Act_Revise::TABLE_NAME;
        $this->objectName = 'actrevise';

        parent::__construct($request, $response);
    }

    public function action_index() {
        $this->_sitePageData->url = '/tax/shopactrevise/index';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/act/revise/list/index',
            )
        );

        // получаем список
        View_View::find('DB_Tax_Shop_Act_Revise', $this->_sitePageData->shopID, "_shop/act/revise/list/index",
            "_shop/act/revise/one/index", $this->_sitePageData, $this->_driverDB, array(),
            array('shop_worker_id' => array('name')), TRUE, TRUE);

        $this->_putInMain('/main/_shop/act/revise/index');
    }

    public function action_list() {
        $this->_sitePageData->url = '/tax/shopactrevise/list';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/act/revise/list/list',
            )
        );

        // получаем список
        $data = View_View::find('DB_Tax_Shop_Act_Revise', $this->_sitePageData->shopID, "_shop/act/revise/list/list",
            "_shop/act/revise/one/list", $this->_sitePageData, $this->_driverDB,
            array('sort_by' => array('value' => array('name' => 'asc'))), array('shop_worker_id' => array('name')));

        $this->response->body($this->_sitePageData->replaceStaticDatas($data));
    }

    public function action_get_items() {
        $this->_sitePageData->url = '/tax/shopactrevise/get_items';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/act/revise/item/list/index',
            )
        );

        $itemsIDs = Api_Tax_Shop_Act_Revise::newItems(
            Request_RequestParams::getParamInt('shop_contractor_id'),
            Request_RequestParams::getParamInt('shop_contract_id'),
            Request_RequestParams::getParamDateTime('date_from'),
            Request_RequestParams::getParamDateTime('date_to'),
            $this->_sitePageData, $this->_driverDB);

        $data = Helpers_View::getViewObjects($itemsIDs, new Model_Basic_LanguageObject(array(), '', 0),
            '_shop/act/revise/item/list/index', '_shop/act/revise/item/one/index',
            $this->_sitePageData, $this->_driverDB);

        $this->response->body($this->_sitePageData->replaceStaticDatas($data));
    }

    public function action_json() {
        $this->_sitePageData->url = '/tax/shopactrevise/json';

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
        $ids = Request_Tax_Shop_Act_Revise::findShopActReviseIDs($this->_sitePageData->shopID,
            $this->_sitePageData, $this->_driverDB, $params, 5000, TRUE,
            array('shop_contract_id' => array('number'), 'shop_contractor_id' => array('name')));

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
                    }elseif ($field == 'shop_contract_number'){
                        $values[$field] = Arr::path($child->values, Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_contract_id.number', '');
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
        $this->_sitePageData->url = '/tax/shopactrevise/new';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/act/revise/one/new',
                'view::_shop/act/revise/item/list/index',
            )
        );

        $this->_requestShopContractors();

        // получаем данные
        $this->_sitePageData->replaceDatas['view::_shop/act/revise/item/list/index'] =
            Helpers_View::getViewObjects(new MyArray(), new Model_Tax_Shop_Invoice_Commercial_Item(),
                '_shop/act/revise/item/list/index', '_shop/act/revise/item/one/index',
                $this->_sitePageData, $this->_driverDB);

        $dataID = new MyArray();
        $dataID->id = 0;
        $dataID->isFindDB = TRUE;

        $data = $this->_sitePageData->replaceDatas['view::_shop/act/revise/one/new'] =
            Helpers_View::getViewObject($dataID, new Model_Tax_Shop_Act_Revise(),
            '_shop/act/revise/one/new', $this->_sitePageData, $this->_driverDB);

        $this->response->body($this->_sitePageData->replaceStaticDatas($data));
    }

    public function action_edit()
    {
        $this->_sitePageData->url = '/tax/shopactrevise/edit';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/act/revise/one/edit',
                'view::_shop/act/revise/item/list/index',
            )
        );

        // id записи
        $shopActReviseID = Request_RequestParams::getParamInt('id');
        if ($shopActReviseID === NULL) {
            throw new HTTP_Exception_404('Act revise not is found!');
        }else {
            $model = new Model_Tax_Shop_Act_Revise();
            if (! $this->dublicateObjectLanguage($model, $shopActReviseID)) {
                throw new HTTP_Exception_404('Act revise not is found!');
            }
        }

        $this->_requestShopContractors($model->getShopContractorID());
        $this->_requestShopContracts($model->getShopContractorID(), $model->getShopContractID());

        // получаем текущие элементы
        $itemsIDs = Api_Tax_Shop_Act_Revise::getItems($model, $this->_sitePageData, $this->_driverDB);

        $this->_sitePageData->replaceDatas['view::_shop/act/revise/item/list/index'] =
            Helpers_View::getViewObjects($itemsIDs, new Model_Basic_LanguageObject(array(), '', 0),
                '_shop/act/revise/item/list/index', '_shop/act/revise/item/one/index',
                $this->_sitePageData, $this->_driverDB);

        // получаем данные
        $data = View_View::findOne('DB_Tax_Shop_Act_Revise', $this->_sitePageData->shopID, "_shop/act/revise/one/edit",
            $this->_sitePageData, $this->_driverDB, array('id' => $shopActReviseID), array());

        $this->response->body($this->_sitePageData->replaceStaticDatas($data));
    }

    public function action_save()
    {
        $this->_sitePageData->url = '/tax/shopactrevise/save';

        $result = Api_Tax_Shop_Act_Revise::save($this->_sitePageData, $this->_driverDB);

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

            $result['values']['shop_contract_number'] = '';
            $tmp = $result['values']['shop_contract_id'];
            if ($tmp > 0){
                $model = new Model_Tax_Shop_Contract();
                if($this->getDBObject($model, $tmp)){
                    $result['values']['shop_contract_number'] = $model->getNumber();
                }
            }

            $this->response->body(Json::json_encode($result));
        } else {
            $branchID = '';
            if($this->_sitePageData->branchID > 0){
                $branchID = '&shop_branch_id='.$this->_sitePageData->branchID;
            }

            if(Request_RequestParams::getParamBoolean('is_close') === FALSE){
                $this->redirect('/tax/shopactrevise/edit'
                    . URL::query(
                        array(
                            'id' => $result['id'],
                        ),
                        FALSE
                    )
                    .$branchID
                );
            }else {
                $this->redirect('/tax/shopactrevise/index'
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
     * @param $shopContractorID
     * @param null $currentID
     */
    protected function _requestShopContracts($shopContractorID, $currentID = NULL)
    {
        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/contract/list/list',
            )
        );
        $data = View_View::find('DB_Tax_Shop_Contract', $this->_sitePageData->shopID,
            "_shop/contract/list/list", "_shop/contract/one/list", $this->_sitePageData, $this->_driverDB,
            array('sort_by' => array('value' => array('name' => 'asc')), 'shop_contractor_id' => $shopContractorID,
                Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE));

        if ($currentID !== NULL) {
            $s = 'data-id="' . $currentID . '"';
            $data = str_replace($s, $s . ' selected', $data);
            $this->_sitePageData->replaceDatas['view::_shop/contract/list/list'] = $data;
        }
    }
}
