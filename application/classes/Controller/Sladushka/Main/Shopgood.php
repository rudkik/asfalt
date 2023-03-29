<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Sladushka_Main_ShopGood extends Controller_Sladushka_Main_BasicSladushka {

    public function __construct(Request $request, Response $response)
    {
        $this->controllerName = 'shopgood';
        $this->tableID = Model_Shop_Good::TABLE_ID;
        $this->tableName = Model_Shop_Good::TABLE_NAME;
        $this->objectName = 'good';

        parent::__construct($request, $response);
    }

    public function action_index() {
        $this->_sitePageData->url = '/sladushka/shopgood/index';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/good/list/index',
            )
        );

        // получаем список
        View_View::find('DB_Shop_Good', $this->_sitePageData->shopID, "_shop/good/list/index",
            "_shop/good/one/index", $this->_sitePageData, $this->_driverDB, array(),
            array('bank_id' => array('name')), TRUE, TRUE);

        $this->_putInMain('/main/_shop/good/index');
    }

    public function action_list() {
        $this->_sitePageData->url = '/sladushka/shopgood/list';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/good/list/list',
            )
        );

        // получаем список
        $data = View_View::find('DB_Shop_Good', $this->_sitePageData->shopID, "_shop/good/list/list",
            "_shop/good/one/list", $this->_sitePageData, $this->_driverDB,
            array('sort_by' => array('value' => array('name' => 'asc'))));

        $this->response->body($this->_sitePageData->replaceStaticDatas($data));
    }

    public function action_json() {
        $this->_sitePageData->url = '/sladushka/shopgood/json';

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
        $ids = Request_Request::find('DB_Shop_Good',$this->_sitePageData->shopID,
            $this->_sitePageData, $this->_driverDB, $params, 5000, TRUE,
            array());

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
                $child->values['options'] = json_decode($child->values['options'], TRUE);
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
        $this->_sitePageData->url = '/sladushka/shopgood/new';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/good/one/new',
            )
        );

        $dataID = new MyArray();
        $dataID->id = 0;
        $dataID->isFindDB = TRUE;

        $data = $this->_sitePageData->replaceDatas['view::_shop/good/one/new'] =
            Helpers_View::getViewObject($dataID, new Model_Shop_Good(),
            '_shop/good/one/new', $this->_sitePageData, $this->_driverDB);

        $this->response->body($this->_sitePageData->replaceStaticDatas($data));
    }

    public function action_edit()
    {
        $this->_sitePageData->url = '/sladushka/shopgood/edit';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/good/one/edit',
            )
        );

        // id записи
        $shopGoodID = Request_RequestParams::getParamInt('id');
        if ($shopGoodID === NULL) {
            throw new HTTP_Exception_404('Good not is found!');
        }else {
            $model = new Model_Shop_Good();
            if (! $this->dublicateObjectLanguage($model, $shopGoodID)) {
                throw new HTTP_Exception_404('Good not is found!');
            }
        }

        // получаем данные
        $data = View_View::findOne('DB_Shop_Good', $this->_sitePageData->shopID, "_shop/good/one/edit",
            $this->_sitePageData, $this->_driverDB, array('id' => $shopGoodID), array('bank_id'));

        $this->response->body($this->_sitePageData->replaceStaticDatas($data));
    }

    public function action_save()
    {
        $this->_sitePageData->url = '/sladushka/shopgood/save';

        $result = Api_Shop_Good::save($this->_sitePageData, $this->_driverDB);

        if (Request_RequestParams::getParamBoolean('json') || $result['result']['error']) {
            $result = $result['result'];

            $this->response->body(Json::json_encode($result));
        } else {
            $branchID = '';
            if($this->_sitePageData->branchID > 0){
                $branchID = '&shop_branch_id='.$this->_sitePageData->branchID;
            }

            if(Request_RequestParams::getParamBoolean('is_close') === FALSE){
                $this->redirect('/sladushka/shopgood/edit'
                    . URL::query(
                        array(
                            'id' => $result['id'],
                        ),
                        FALSE
                    )
                    .$branchID
                );
            }else {
                $this->redirect('/sladushka/shopgood/index'
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
