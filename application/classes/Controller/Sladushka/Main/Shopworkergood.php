<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Sladushka_Main_ShopWorkerGood extends Controller_Sladushka_Main_BasicSladushka {

    public function __construct(Request $request, Response $response)
    {
        $this->controllerName = 'shopworkergood';
        $this->tableID = Model_Sladushka_Shop_Worker_Good::TABLE_ID;
        $this->tableName = Model_Sladushka_Shop_Worker_Good::TABLE_NAME;
        $this->objectName = 'workergood';

        parent::__construct($request, $response);
    }

    public function action_index() {
        $this->_sitePageData->url = '/sladushka/shopworkergood/index';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/worker/good/list/index',
            )
        );

        // получаем список
        View_View::find('DB_Sladushka_Shop_Worker_Good', $this->_sitePageData->shopID, "_shop/worker/good/list/index",
            "_shop/worker/good/one/index", $this->_sitePageData, $this->_driverDB, array(),
            array(), TRUE, TRUE);

        $this->_putInMain('/main/_shop/worker/good/index');
    }

    public function action_json() {
        $this->_sitePageData->url = '/sladushka/shopworkergood/json';

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
        $ids = Request_Request::find('DB_Sladushka_Shop_Worker_Good', $this->_sitePageData->shopID,
            $this->_sitePageData, $this->_driverDB, $params, 5000, TRUE,
            array('shop_worker_id' => array('name')));

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
        $this->_sitePageData->url = '/sladushka/shopworkergood/new';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/worker/good/one/new',
                'view::_shop/worker/good/item/list/index',
            )
        );

        $this->_requestShopWorkers();
        $this->_requestShopGoods();

        $this->_sitePageData->replaceDatas['view::_shop/worker/good/item/list/index'] =
            Helpers_View::getViewObjects(new MyArray(), new Model_Shop_Good(),
                '_shop/worker/good/item/list/index', '_shop/worker/good/item/one/index',
                $this->_sitePageData, $this->_driverDB);

        $dataID = new MyArray();
        $dataID->id = 0;
        $dataID->isFindDB = TRUE;

        $data = $this->_sitePageData->replaceDatas['view::_shop/worker/good/one/new'] = Helpers_View::getViewObject($dataID, new Model_Sladushka_Shop_Worker_Good(),
            '_shop/worker/good/one/new', $this->_sitePageData, $this->_driverDB);

        $this->response->body($this->_sitePageData->replaceStaticDatas($data));
    }

    public function action_edit()
    {
        $this->_sitePageData->url = '/sladushka/shopworkergood/edit';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/worker/good/one/edit',
                'view::_shop/worker/good/item/list/index',
            )
        );

        // id записи
        $id = Request_RequestParams::getParamInt('id');
        if ($id === NULL) {
            throw new HTTP_Exception_404('Worker goods not is found!');
        }else {
            $model = new Model_Sladushka_Shop_Worker_Good();
            if (! $this->dublicateObjectLanguage($model, $id)) {
                throw new HTTP_Exception_404('Worker good not is found!');
            }
        }

        $this->_requestShopWorkers($model->getShopWorkerID());
        $this->_requestShopGoods();

        View_View::find('DB_Sladushka_Shop_Worker_Good_Item', $this->_sitePageData->shopID,
            '_shop/worker/good/item/list/index', '_shop/worker/good/item/one/index',
            $this->_sitePageData, $this->_driverDB, array('shop_worker_good_id' => $id, Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE),
            array('shop_good_id' => array('name', 'options')));


        // получаем данные
        $data = View_View::findOne('DB_Sladushka_Shop_Worker_Good', $this->_sitePageData->shopID, "_shop/worker/good/one/edit",
            $this->_sitePageData, $this->_driverDB, array('id' => $id), array());

        $this->response->body($this->_sitePageData->replaceStaticDatas($data));
    }

    public function action_save()
    {
        $this->_sitePageData->url = '/sladushka/shopworkergood/save';

        $result = Api_Sladushka_Shop_Worker_Good::save($this->_sitePageData, $this->_driverDB);

        if (Request_RequestParams::getParamBoolean('json') || $result['result']['error']) {
            $result = $result['result'];

            $result['values']['shop_worker_name'] = '';
            $tmp = $result['values']['shop_worker_id'];
            if ($tmp > 0){
                $model = new Model_Sladushka_Shop_Worker();
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
                $this->redirect('/sladushka/shopworkergood/edit'
                    . URL::query(
                        array(
                            'id' => $result['id'],
                        ),
                        FALSE
                    )
                    .$branchID
                );
            }else {
                $this->redirect('/sladushka/shopworkergood/index'
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
     * сортировка по имени
     * @param $x
     * @param $y
     * @return int
     */
    function mySortMethod($x, $y) {
        return strcasecmp($x['name'], $y['name']);
    }

    public function action_report() {
        set_time_limit(36000);

        $this->_sitePageData->url = '/'.$this->actionURLName.'/shopworkergood/report';

        $id = Request_RequestParams::getParamInt('id');
        $ids = Request_Request::find('DB_Sladushka_Shop_Worker_Good_Item', $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB,
            array('shop_worker_good_id' => $id, Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE), 0, TRUE,
        array('shop_good_id' => array('name')));

        $dataGoods = array(
            'data' => array(),
            'amount' => 0,
        );
        foreach ($ids->childs as $child){
            $amount = $child->values['amount'];

            $dataGoods['data'][] = array(
                'name' => Arr::path($child->values, Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_good_id.name', ''),
                'weight' => $child->values['weight'],
                'price' => $child->values['price'],
                'took' => $child->values['took'],
                'quantity' => $child->values['quantity'],
                'amount' => $amount,
            );
            $dataGoods['amount'] += $amount;
        }

        uasort($dataGoods['data'], array($this, 'mySortMethod'));

        $viewObject = '/sladushka/main/35/_shop/worker/good/report/worker-good';
        $tmp = str_replace('\\', '/', $viewObject);
        try {
            $view = View::factory($tmp);
        }catch (Exception $e) {
            throw new Exception('Шаблон "'.$tmp.'" не найден.');
        }

        $view->goods = $dataGoods;
        $strView = Helpers_View::viewToStr($view);

        //header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Type: application/x-download;charset=UTF-8');
        header('Content-Disposition: attachment;filename="Отчет.xml"');
        header('Cache-Control: max-age=0');

        echo $strView;
        exit();
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
        $data = View_View::find('DB_Sladushka_Shop_Worker', $this->_sitePageData->shopID,
            "_shop/worker/list/list", "_shop/worker/one/list", $this->_sitePageData, $this->_driverDB,
            array('sort_by' => array('value' => array('name' => 'asc')), Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE));

        if ($currentID !== NULL) {
            $s = 'data-id="' . $currentID . '"';
            $data = str_replace($s, $s . ' selected', $data);
            $this->_sitePageData->replaceDatas['view::_shop/worker/list/list'] = $data;
        }
    }

    /**
     * Делаем запрос на список доставок
     * @param null|int $currentID
     */
    protected function _requestShopGoods($currentID = NULL)
    {
        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/good/list/list',
            )
        );
        $data = View_View::find('DB_Shop_Good', $this->_sitePageData->shopID,
            "_shop/good/list/list", "_shop/good/one/list", $this->_sitePageData, $this->_driverDB,
            array('sort_by' => array('value' => array('name' => 'asc')), Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE));

        if ($currentID !== NULL) {
            $s = 'data-id="' . $currentID . '"';
            $data = str_replace($s, $s . ' selected', $data);
            $this->_sitePageData->replaceDatas['view::_shop/good/list/list'] = $data;
        }
    }
}
