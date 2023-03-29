<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ads_Region extends Controller_Ads_BasicAds {

    public function __construct(Request $request, Response $response)
    {
        $this->controllerName = 'region';
        $this->tableID = Model_Region::TABLE_ID;
        $this->tableName = Model_Region::TABLE_NAME;
        $this->objectName = 'region';

        parent::__construct($request, $response);
    }

    public function action_index() {
        $this->_sitePageData->url = '/ads/region/index';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::region/list/index',
            )
        );

        // получаем список
        View_View::find('DB_Region', $this->_sitePageData->shopID, "region/list/index",
            "region/one/index", $this->_sitePageData, $this->_driverDB, array(),
            array(), TRUE, TRUE);

        $this->_putInMain('/main/region/index');
    }

    public function action_list() {
        $this->_sitePageData->url = '/ads/region/list';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::region/list/list',
            )
        );

        // получаем список
        $data = View_View::find('DB_Region', $this->_sitePageData->shopID, "region/list/list",
            "region/one/list", $this->_sitePageData, $this->_driverDB,
            array('sort_by' => array('value' => array('name' => 'asc'))));

        $this->response->body($this->_sitePageData->replaceStaticDatas($data));
    }

    public function action_json() {
        $this->_sitePageData->url = '/ads/region/json';

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
        $ids = Request_Region::findRegionIDs($this->_sitePageData, $this->_driverDB, $params, 5000,
            TRUE, array('land_id' => array('name')));

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
                    }elseif ($field == 'land_name'){
                        $values[$field] = Arr::path($child->values, Model_Basic_BasicObject::FIELD_ELEMENTS.'.land_id.name', '');
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
        $this->_sitePageData->url = '/ads/region/new';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::region/one/new',
            )
        );

        $this->_requestLands();

        $dataID = new MyArray();
        $dataID->id = 0;
        $dataID->isFindDB = TRUE;

        $data = $this->_sitePageData->replaceDatas['view::region/one/new'] = Helpers_View::getViewObject($dataID, new Model_Region(),
            'region/one/new', $this->_sitePageData, $this->_driverDB);

        $this->response->body($this->_sitePageData->replaceStaticDatas($data));
    }

    public function action_edit()
    {
        $this->_sitePageData->url = '/ads/region/edit';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::region/one/edit',
            )
        );

        // id записи
        $id = Request_RequestParams::getParamInt('id');
        $model = new Model_Region();
        if (! $this->dublicateObjectLanguage($model, $id, -1, FALSE)) {
            throw new HTTP_Exception_404('Region not is found!');
        }

        $this->_requestLands($model->getLandID());

        // получаем данные
        $data = View_View::findOne('DB_Region', $this->_sitePageData->shopID, "region/one/edit",
            $this->_sitePageData, $this->_driverDB, array('id' => $id), array());

        $this->response->body($this->_sitePageData->replaceStaticDatas($data));
    }

    public function action_save()
    {
        $this->_sitePageData->url = '/ads/region/save';

        $result = Api_Region::save($this->_sitePageData, $this->_driverDB);

        $this->_redirectSaveResult(
            $result,
            array(
                'land_name' => array(
                    'id' => 'land_id',
                    'model' => new Model_Land(),
                ),
            )
        );
    }

    /**
     * Делаем запрос на список доставок
     * @param null|int $currentID
     */
    protected function _requestLands($currentID = NULL)
    {
        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::land/list/list',
            )
        );
        $data = View_View::find('DB_Land', $this->_sitePageData->shopID,
            "land/list/list", "land/one/list", $this->_sitePageData, $this->_driverDB,
            array('sort_by' => array('value' => array('name' => 'asc')), Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE));

        if ($currentID !== NULL) {
            $s = 'data-id="' . $currentID . '"';
            $data = str_replace($s, $s . ' selected', $data);
            $this->_sitePageData->replaceDatas['view::land/list/list'] = $data;
        }
    }
}
