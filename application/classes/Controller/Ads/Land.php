<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ads_Land extends Controller_Ads_BasicAds {

    public function __construct(Request $request, Response $response)
    {
        $this->controllerName = 'land';
        $this->tableID = Model_Land::TABLE_ID;
        $this->tableName = Model_Land::TABLE_NAME;
        $this->objectName = 'land';

        parent::__construct($request, $response);
    }

    public function action_index() {
        $this->_sitePageData->url = '/ads/land/index';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::land/list/index',
            )
        );

        // получаем список
        View_View::find('DB_Land', $this->_sitePageData->shopID, "land/list/index",
            "land/one/index", $this->_sitePageData, $this->_driverDB, array(),
            array(), TRUE, TRUE);

        $this->_putInMain('/main/land/index');
    }

    public function action_list() {
        $this->_sitePageData->url = '/ads/land/list';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::land/list/list',
            )
        );

        // получаем список
        $data = View_View::find('DB_Land', $this->_sitePageData->shopID, "land/list/list",
            "land/one/list", $this->_sitePageData, $this->_driverDB,
            array('sort_by' => array('value' => array('name' => 'asc'))));

        $this->response->body($this->_sitePageData->replaceStaticDatas($data));
    }

    public function action_json() {
        $this->_sitePageData->url = '/ads/land/json';

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
        $ids = Request_Land::findLandIDs($this->_sitePageData, $this->_driverDB, $params, 5000,
            TRUE, array());

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
        $this->_sitePageData->url = '/ads/land/new';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::land/one/new',
            )
        );

        $dataID = new MyArray();
        $dataID->id = 0;
        $dataID->isFindDB = TRUE;

        $data = $this->_sitePageData->replaceDatas['view::land/one/new'] = Helpers_View::getViewObject($dataID, new Model_Land(),
            'land/one/new', $this->_sitePageData, $this->_driverDB);

        $this->response->body($this->_sitePageData->replaceStaticDatas($data));
    }

    public function action_edit()
    {
        $this->_sitePageData->url = '/ads/land/edit';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::land/one/edit',
            )
        );

        // id записи
        $id = Request_RequestParams::getParamInt('id');
        $model = new Model_Land();
        if (! $this->dublicateObjectLanguage($model, $id, -1, FALSE)) {
            throw new HTTP_Exception_404('Land not is found!');
        }

        // получаем данные
        $data = View_View::findOne('DB_Land', $this->_sitePageData->shopID, "land/one/edit",
            $this->_sitePageData, $this->_driverDB, array('id' => $id), array());

        $this->response->body($this->_sitePageData->replaceStaticDatas($data));
    }

    public function action_save()
    {
        $this->_sitePageData->url = '/ads/land/save';

        $result = Api_Land::save($this->_sitePageData, $this->_driverDB);

        $this->_redirectSaveResult($result);
    }
}
