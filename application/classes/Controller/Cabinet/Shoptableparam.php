<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Cabinet_ShopTableParam extends Controller_Cabinet_File {
    protected $paramIndex = 1;

    public function __construct(Request $request, Response $response)
    {
        $this->dbObject = 'DB_Shop_Table_Param';
        $this->paramIndex = Request_RequestParams::getParamInt('param_index');
        $this->controllerName = 'shoptableparam';
        $this->tableID = Model_Shop_Table_Param::TABLE_ID;
        $this->tableName = Model_Shop_Table_Param::getTableName($this->paramIndex);

        parent::__construct($request, $response);
        $this->_sitePageData->controllerName = $this->controllerName;
    }

    public function action_index() {
        $this->_sitePageData->url = '/cabinet/shoptableparam/index';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/_table/param/list/index',
                'view::_shop/_table/rubric/list/list',
            )
        );

        // тип объекта
        $type = $this->_getType();
        $this->_requestTranslateTr();

        // получаем список
        $params = Request_RequestParams::setParams(
            array(
                'type' => $type['id'],
                'table_id' => Request_RequestParams::getParamInt('table_id'),
                'index' => $this->paramIndex,
                'limit_page' => 25
            ),
            TRUE
        );
        View_View::find('DB_Shop_Table_Param', $this->_sitePageData->shopID, "_shop/_table/param/list/index",
            "_shop/_table/param/one/index", $this->_sitePageData, $this->_driverDB, $params,
            array('shop_table_rubric_id'));

        $params = Request_RequestParams::setParams(
            array(
                'type' => array(0, $type['id']),
                'table_id' => Model_Shop_Table_Param::TABLE_ID,
            )
        );
        View_View::find('DB_Shop_Table_Rubric', $this->_sitePageData->shopID, "_shop/_table/rubric/list/list",
            "_shop/_table/rubric/one/list", $this->_sitePageData, $this->_driverDB, $params);

        $this->_putInMain('/main/_shop/_table/param/index');
    }

    public function action_sort() {
        $this->_sitePageData->url = '/cabinet/shoptableparam/sort';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/_table/param/list/index',
                'view::_shop/_table/rubric/list/list',
            )
        );

        // тип объекта
        $type = $this->_getType();

        // получаем список
        $params = Request_RequestParams::setParams(
            array(
                'type' => $type['id'],
                'table_id' => Request_RequestParams::getParamInt('table_id'),
                'index' => $this->paramIndex,
                'limit_page' => 25
            ),
            TRUE
        );
        $this->_sitePageData->replaceDatas['view::_shop/_table/param/list/index'] =
            View_View::find('DB_Shop_Table_Param', $this->_sitePageData->shopID, "_shop/_table/param/list/sort",
                "_shop/_table/param/one/sort", $this->_sitePageData, $this->_driverDB, $params);

        $params = Request_RequestParams::setParams(
            array(
                'type' => array(0, $type['id']),
                'table_id' => Model_Shop_Table_Param::TABLE_ID,
            )
        );
        View_View::find('DB_Shop_Table_Rubric', $this->_sitePageData->shopID, "_shop/_table/rubric/list/list",
            "_shop/_table/rubric/one/list", $this->_sitePageData, $this->_driverDB, $params);

        $this->_putInMain('/main/_shop/_table/param/index');
    }

    public function action_index_edit() {
        $this->_sitePageData->url = '/cabinet/shoptableparam/index_edit';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/_table/param/list/index',
                'view::_shop/_table/rubric/list/list',
                'view::editfields/list',
            )
        );

        // тип объекта
        $type = $this->_getType();

        $fields =
            '<option data-id="old_id" value="old_id">ID</option>'
            .'<option data-id="name" value="name">Название</option>'
            .'<option data-id="text" value="text">Описание</option>'
            .'<option data-id="options" value="options">Все заполненные атрибуты</option>';
        $arr = Arr::path($type['fields_options'], 'shop_good', array());
        foreach($arr as $key => $value){
            $s = 'options.'.htmlspecialchars(Arr::path($value, 'field', Arr::path($value, 'name', '')), ENT_QUOTES);
            $fields = $fields .'<option data-id="'.$s.'" value="'.$s.'">'.$value['title'].'</option>';
        }
        $fields = $fields
            .'<option data-id="is_public" value="is_public">Опубликован</option>'
            .'<option data-id="shop_table_rubric_id" value="shop_table_rubric_id">Рубрика</option>';
        $this->_sitePageData->replaceDatas['view::editfields/list'] = $fields;

        $params = Request_RequestParams::setParams(
            array(
                'type' => array(0, $type['id']),
                'table_id' => Model_Shop_Table_Param::TABLE_ID,
            )
        );
        View_View::find('DB_Shop_Table_Rubric', $this->_sitePageData->shopID, "_shop/_table/rubric/list/list",
            "_shop/_table/rubric/one/list", $this->_sitePageData, $this->_driverDB, $params);

        // получаем список
        $this->_sitePageData->replaceDatas['_shop/_table/param/list/index'] = View_View::find('DB_Shop_Table_Param', $this->_sitePageData->shopID,
            "_shop/_table/param/list/index-edit", "_shop/_table/param/one/index-edit", $this->_sitePageData, $this->_driverDB,
            array_merge(array('sort_by'=>array('name' => 'asc', 'id' => 'desc', 'limit_page' => 25)), $_GET, $_POST, array('type' => $type['id'], 'table_id' => Request_RequestParams::getParamInt('table_id'), 'is_public_ignore' => TRUE, Request_RequestParams::IS_NOT_READ_REQUEST_NAME => FALSE)),
            array('shop_table_catalog_id', 'shop_table_rubric_id'));

        $this->_putInMain('/main/_shop/_table/param/index');
    }

    public function action_new() {
        $this->_sitePageData->url = '/cabinet/shoptableparam/new';

        // тип объекта
        $type = $this->_getType();

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/_table/param/one/new',
                'view::_shop/_table/rubric/list/list',
            )
        );

        // получаем языки перевода
        $this->getLanguagesByShop(
            URL::query(
                array(
                    'type' => $type['id'],
                    'table_id' => Request_RequestParams::getParamInt('table_id'),
                    'index' => $this->paramIndex,
                ), FALSE
            ),
            FALSE
        );

        $params = Request_RequestParams::setParams(
            array(
                'type' => array(0, $type['id']),
                'table_id' => Model_Shop_Table_Param::TABLE_ID,
            )
        );
        View_View::find('DB_Shop_Table_Rubric', $this->_sitePageData->shopID, "_shop/_table/rubric/list/list",
            "_shop/_table/rubric/one/list", $this->_sitePageData, $this->_driverDB, $params);

        $dataID = new MyArray();
        $dataID->id = 0;
        // дополнительные поля
        Arr::set_path($dataID->values, Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_table_catalog_id', $type);
        $dataID->isFindDB = TRUE;

        $model = new Model_Shop_Table_Param($this->paramIndex);
        $datas = Helpers_View::getViewObject($dataID, $model,
            '_shop/_table/param/one/new', $this->_sitePageData, $this->_driverDB);
        $this->_sitePageData->replaceDatas['view::_shop/_table/param/one/new'] = $datas;

        $this->_putInMain('/main/_shop/_table/param/new');
    }

    public function action_edit() {
        $this->_sitePageData->url = '/cabinet/shoptableparam/edit';

        // тип объекта
        $type = $this->_getType();

        // id записи
        $id = Request_RequestParams::getParamInt('id');
        $model = new Model_Shop_Table_Param($this->paramIndex);
        if (! $this->dublicateObjectLanguage($model, $id, -1, FALSE)) {
            throw new HTTP_Exception_404('Table param not is found!');
        }

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/_table/param/one/edit',
                'view::_shop/_table/rubric/list/list',
            )
        );

        // получаем языки перевода
        $this->getLanguagesByShop(
            URL::query(
                array(
                    'id' => $id,
                    'type' => $type['id'],
                    'table_id' => Request_RequestParams::getParamInt('table_id'),
                    'index' => $this->paramIndex,
                ), FALSE
            ),
            FALSE
        );

        // получаем список ID рубрик
        $params = Request_RequestParams::setParams(
            array(
                'type' => array(0, $type['id']),
                'table_id' => Model_Shop_Table_Param::TABLE_ID,
            )
        );
        $shopTableRubricIDs = View_View::find('DB_Shop_Table_Rubric', $this->_sitePageData->shopID,
            "_shop/_table/rubric/list/list", "_shop/_table/rubric/one/list", $this->_sitePageData,
            $this->_driverDB, $params);

        $s = 'value="' . $model->getShopTableRubricID() . '"';
        $shopTableRubricIDs = str_replace($s, $s . ' selected', $shopTableRubricIDs);
        $this->_sitePageData->replaceDatas['view::_shop/_table/rubric/list/list'] = $shopTableRubricIDs;

        // получаем данные
        View_View::findOne('DB_Shop_Table_Param', $this->_sitePageData->shopID, "_shop/_table/param/one/edit",
            $this->_sitePageData, $this->_driverDB, array('id' => $id), array('shop_table_catalog_id'));

        $this->_putInMain('/main/_shop/_table/param/edit');
    }

    public function action_save() {
        $this->_sitePageData->url = '/cabinet/shoptableparam/save';
        $result = Api_Shop_Table_Param::save($this->_sitePageData, $this->_driverDB);
        $this->_redirectSaveResult($result);
    }
    /**
     * Удаление
     */
    public function action_del() {
        $this->_sitePageData->url = '/cabinet/shoptableparam/del';

        Api_Shop_Table_Param::delete($this->_sitePageData, $this->_driverDB);
        $this->response->body(Json::json_encode(array('error' => FALSE)));
    }


    /**
     * Перестроить товары
     * @param MyArray $ids
     * @param Model_Shop_Table_Param $model
     */
    private function _rebuildParam(MyArray $ids, Model_Shop_Table_Param $model){
        foreach ($ids->childs as $child){
            $model->clear();
            $model->__setArray(array('values' => $child->values));
            $model->setNameURL(Helpers_URL::getNameURL($model));
            Helpers_DB::saveDBObject($model, $this->_sitePageData);
        }
    }

    public function action_rebuild_params() {
        $this->_sitePageData->url = '/cabinet/shoptableparam/rebuild_params';

        $this->_sitePageData->dataLanguageID = 35;
        $this->_sitePageData->languageID = 35;
        // получаем список
        $ids = Request_Shop_Table_Param::findShopTableParamIDs($this->_sitePageData->shopID,
            $this->_sitePageData, $this->_driverDB, array('limit_page' => 5000), 0,
            TRUE, array());

        $model = new Model_Shop_Table_Param($this->paramIndex);
        $model->setDBDriver($this->_driverDB);
        $this->_rebuildParam($ids, $model);

        $this->_sitePageData->dataLanguageID = 36;
        $this->_sitePageData->languageID = 36;
        // получаем список
        $ids = Request_Shop_Table_Param::findShopTableParamIDs($this->_sitePageData->shopID,
            $this->_sitePageData, $this->_driverDB, array('limit_page' => 5000), 0,
            TRUE, array());

        $model = new Model_Shop_Table_Param($this->paramIndex);
        $model->setDBDriver($this->_driverDB);
        $this->_rebuildParam($ids, $model);
    }
}
