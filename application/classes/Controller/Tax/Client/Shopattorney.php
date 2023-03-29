<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Tax_Client_ShopAttorney extends Controller_Tax_Client_BasicTax {

    public function __construct(Request $request, Response $response)
    {
        $this->controllerName = 'shopattorney';
        $this->tableID = Model_Tax_Shop_Attorney::TABLE_ID;
        $this->tableName = Model_Tax_Shop_Attorney::TABLE_NAME;
        $this->objectName = 'attorney';

        parent::__construct($request, $response);
    }

    public function action_index() {
        $this->_sitePageData->url = '/tax/shopattorney/index';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/attorney/list/index',
            )
        );

        // получаем список
        View_View::find('DB_Tax_Shop_Attorney', $this->_sitePageData->shopID, "_shop/attorney/list/index",
            "_shop/attorney/one/index", $this->_sitePageData, $this->_driverDB, array(),
            array('bank_id' => array('name')), TRUE, TRUE);

        $this->_putInMain('/main/_shop/attorney/index');
    }

    public function action_list() {
        $this->_sitePageData->url = '/tax/shopattorney/list';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/attorney/list/list',
            )
        );

        // получаем список
        $data = View_View::find('DB_Tax_Shop_Attorney', $this->_sitePageData->shopID, "_shop/attorney/list/list",
            "_shop/attorney/one/list", $this->_sitePageData, $this->_driverDB,
            array('sort_by' => array('value' => array('name' => 'asc'))));

        $this->response->body($this->_sitePageData->replaceStaticDatas($data));
    }

    public function action_json() {
        $this->_sitePageData->url = '/tax/shopattorney/json';

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
        $ids = Request_Tax_Shop_Attorney::findShopAttorneyIDs($this->_sitePageData->shopID,
            $this->_sitePageData, $this->_driverDB, $params, 5000, TRUE,
            array('shop_contractor_id' => array('name')));

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
        $this->_sitePageData->url = '/tax/shopattorney/new';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/attorney/one/new',
            )
        );

        $this->_requestShopContractors();

        $dataID = new MyArray();
        $dataID->id = 0;
        $dataID->isFindDB = TRUE;

        $data = $this->_sitePageData->replaceDatas['view::_shop/attorney/one/new'] =
            Helpers_View::getViewObject($dataID, new Model_Tax_Shop_Attorney(),
            '_shop/attorney/one/new', $this->_sitePageData, $this->_driverDB);

        $this->response->body($this->_sitePageData->replaceStaticDatas($data));
    }

    public function action_edit()
    {
        $this->_sitePageData->url = '/tax/shopattorney/edit';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/attorney/one/edit',
            )
        );

        // id записи
        $shopAttorneyID = Request_RequestParams::getParamInt('id');
        if ($shopAttorneyID === NULL) {
            throw new HTTP_Exception_404('Attorney not is found!');
        }else {
            $model = new Model_Tax_Shop_Attorney();
            if (! $this->dublicateObjectLanguage($model, $shopAttorneyID)) {
                throw new HTTP_Exception_404('Attorney not is found!');
            }
        }

        $this->_requestShopContractors($model->getShopContractorID());

        // получаем данные
        $data = View_View::findOne('DB_Tax_Shop_Attorney', $this->_sitePageData->shopID, "_shop/attorney/one/edit",
            $this->_sitePageData, $this->_driverDB, array('id' => $shopAttorneyID), array('bank_id'));

        $this->response->body($this->_sitePageData->replaceStaticDatas($data));
    }

    public function action_save()
    {
        $this->_sitePageData->url = '/tax/shopattorney/save';

        $result = Api_Tax_Shop_Attorney::save($this->_sitePageData, $this->_driverDB);

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

            $this->response->body(Json::json_encode($result));
        } else {
            $branchID = '';
            if($this->_sitePageData->branchID > 0){
                $branchID = '&shop_branch_id='.$this->_sitePageData->branchID;
            }

            if(Request_RequestParams::getParamBoolean('is_close') === FALSE){
                $this->redirect('/tax/shopattorney/edit'
                    . URL::query(
                        array(
                            'id' => $result['id'],
                        ),
                        FALSE
                    )
                    .$branchID
                );
            }else {
                $this->redirect('/tax/shopattorney/index'
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
}
