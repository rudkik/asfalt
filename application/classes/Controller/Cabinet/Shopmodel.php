<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Cabinet_ShopModel extends Controller_Cabinet_File {

    public function __construct(Request $request, Response $response)
    {
        $this->dbObject = 'DB_Shop_Model';
        $this->controllerName = 'shopmodel';
        $this->tableID = Model_Shop_Model::TABLE_ID;
        $this->tableName = Model_Shop_Model::TABLE_NAME;
        $this->objectName = 'model';

        parent::__construct($request, $response);
        $this->_sitePageData->controllerName = $this->controllerName;
    }

    public function action_index() {
        $this->_sitePageData->url = '/cabinet/shopmodel/index';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/model/list/index',
            )
        );

        // тип объекта
        $type = $this->_getType();
        // список объектов
        $this->_requestTableObjects($type);
        $this->_requestTranslateTr();
        $this->_requestShopMarks();

        // получаем список
        View_View::find('DB_Shop_Model', $this->_sitePageData->shopID, "_shop/model/list/index", "_shop/model/one/index",
            $this->_sitePageData, $this->_driverDB, array('limit_page' => 25), array('shop_table_rubric_id' => array('name'),
                'shop_mark_id' => array('name')));

        $this->_putInMain('/main/_shop/model/index');
    }

    public function action_sort(){
        $this->_sitePageData->url = '/cabinet/shopmodel/sort';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/model/list/index',
            )
        );

        // тип объекта
        $type = $this->_getType();
        // список объектов
        $this->_requestTableObjects($type);

        // получаем список
        $this->_sitePageData->replaceDatas['view::_shop/model/list/index'] = View_View::find('DB_Shop_Model', $this->_sitePageData->shopID,
            "_shop/model/list/sort", "_shop/model/one/sort", $this->_sitePageData, $this->_driverDB,
            array_merge($_GET, $_POST, array('sort_by'=>array('order' => 'asc', 'id' => 'desc'), 'limit_page' => 0,
                'type' => $type['id'], Request_RequestParams::IS_NOT_READ_REQUEST_NAME => FALSE)));

        $this->_putInMain('/main/_shop/model/index');
    }

    public function action_index_edit() {
        $this->_sitePageData->url = '/cabinet/shopmodel/index_edit';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/model/list/index',
                'view::editfields/list',
            )
        );

        // тип объекта
        $type = $this->_getType();
        // список объектов
        $this->_requestTableObjects($type);
        $this->_requestShopMarks();

        $fields =
            '<option data-id="old_id" value="old_id">ID</option>'
            .'<option data-id="name" value="name">Название</option>'
            .'<option data-id="text" value="info">Описание</option>'
            .'<option data-id="options" value="options">Все заполненные атрибуты</option>';

        $arr = Arr::path($type, 'fields_options.shop_model', array());
        foreach($arr as $key => $value){
            $s = 'options.'.htmlspecialchars(Arr::path($value, 'field', Arr::path($value, 'name', '')), ENT_QUOTES);
            $fields = $fields .'<option data-id="'.$s.'" value="'.$s.'">'.$value['title'].'</option>';
        }
        $fields = $fields
            .'<option data-id="is_public" value="is_public">Опубликован</option>'
            .'<option data-id="shop_table_rubric_id" value="shop_table_rubric_id">Рубрика</option>'
            .'<option data-id="shop_table_brand_id" value="shop_table_brand_id">Бренд</option>'
            .'<option data-id="shop_table_unit_id" value="shop_table_unit_id">Единица измерения</option>'
            .'<option data-id="shop_table_select_id" value="shop_table_select_id">Вид выделения</option>';
        $this->_sitePageData->replaceDatas['view::editfields/list'] = $fields;

        // получаем список
        $this->_sitePageData->replaceDatas['view::_shop/model/list/index'] = View_View::find('DB_Shop_Model', $this->_sitePageData->shopID,
            "_shop/model/list/index-edit", "_shop/model/one/index-edit",
            $this->_sitePageData, $this->_driverDB,
            array_merge(array('sort_by'=>array('name' => 'asc', 'id' => 'desc', 'limit_page' => 25)), $_GET, $_POST, array('type' => $type['id'], 'is_public_ignore' => TRUE, Request_RequestParams::IS_NOT_READ_REQUEST_NAME => FALSE)),
            array('shop_table_catalog_id'));

        $this->_putInMain('/main/_shop/model/index');
    }

    public function action_new()
    {
        $this->_sitePageData->url = '/cabinet/shopmodel/new';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/model/one/new',
            )
        );

        // тип объекта
        $type = $this->_getType();
        $this->_requestTableObjects($type);
        $this->_requestShopMarks();

        // получаем языки перевода
        $this->getLanguagesByShop(
            URL::query(
                array(
                    'type' => $type['id'],
                ), FALSE
            ),
            FALSE
        );

        $dataID = new MyArray();
        $dataID->id = 0;
        // дополнительные поля
        Arr::set_path($dataID->values, Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_table_catalog_id', $type);
        $dataID->isFindDB = TRUE;

        $this->_sitePageData->replaceDatas['view::_shop/model/one/new'] = Helpers_View::getViewObject($dataID, new Model_Shop_Model(),
            '_shop/model/one/new', $this->_sitePageData, $this->_driverDB);

        $this->_putInMain('/main/_shop/model/new');
    }

    public function action_edit()
    {
        $this->_sitePageData->url = '/cabinet/shopmodel/edit';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/model/one/edit',
            )
        );

        // id записи
        $shopModelID = Request_RequestParams::getParamInt('id');
        $modelModel = new Model_Shop_Model();
        if (! $this->dublicateObjectLanguage($modelModel, $shopModelID, -1, FALSE)) {
            throw new HTTP_Exception_404('Models not is found!');
        }

        // тип объекта
        $type = $this->_getType($modelModel->getShopTableCatalogID());

        $this->_requestTableObjects($type, $modelModel);
        $this->_requestShopMarks($modelModel->getShopMarkID());

        // получаем языки перевода
        $this->getLanguagesByShop(
            URL::query(
                array(
                    'id' => $shopModelID,
                    'type' => $type['id'],
                ), FALSE
            ),
            FALSE
        );

        // получаем данные
        View_View::findOne('DB_Shop_Model', $this->_sitePageData->shopID, "_shop/model/one/edit",
            $this->_sitePageData, $this->_driverDB, array('id' => $shopModelID,
                Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE), array('shop_table_catalog_id'));

        $this->_putInMain('/main/_shop/model/edit');
    }

    public function action_save()
    {
        $this->_sitePageData->url = '/cabinet/shopmodel/save';
        $result = Api_Shop_Model::save($this->_sitePageData, $this->_driverDB);
        $this->_redirectSaveResult($result);
    }

    public function action_save_xls()
    {
        $this->_sitePageData->url = '/cabinet/shopmodel/save_xls';
        Api_Shop_Model::saveXLS($this->_sitePageData, $this->_driverDB);
        exit();
    }

    public function action_del() {
        $this->_sitePageData->url = '/cabinet/shopmodel/del';

        Api_Shop_Model::delete($this->_sitePageData, $this->_driverDB);
        $this->response->body(Json::json_encode(array('error' => FALSE)));
    }

    /**
     * Парсим загруженные данные с сайтов загруженных через функцию
     * load_site_by_barcode
     */
    public function action_parser_data_site(){
        set_time_limit(3600000);
        ignore_user_abort(TRUE);
        ini_set('max_execution_time', 360000);

        $this->_sitePageData->url = '/cabinet/shopmodel/parser_data_site';

        Drivers_ParserSite_Opto::parserLoadData();
    }

    /**
     * Сохраняем загруженные данные с сайтов загруженных через функцию
     * parser_data_site
     */
    public function action_save_data_site(){
        set_time_limit(3600000);
        ignore_user_abort(TRUE);
        ini_set('max_execution_time', 360000);

        $this->_sitePageData->url = '/cabinet/shopmodel/save_data_site';

        Drivers_ParserSite_ShopModel::saveLoadData($this->_sitePageData, $this->_driverDB);
    }

    /**
     * Перестроить товары
     * @param MyArray $ids
     * @param Model_Shop_Model $model
     */
    private function _rebuildModel(MyArray $ids, Model_Shop_Model $model){
        foreach ($ids->childs as $child){
            $model->clear();
            $model->__setArray(array('values' => $child->values));
            $model->setNameURL(Helpers_URL::getNameURL($model));
            Helpers_DB::saveDBObject($model, $this->_sitePageData);
        }
    }

    public function action_rebuild_models() {
        $this->_sitePageData->url = '/cabinet/shopmodel/rebuild_models';

        $this->_sitePageData->dataLanguageID = 35;
        $this->_sitePageData->languageID = 35;
        // получаем список
        $ids = Request_Request::find('DB_Shop_Model', $this->_sitePageData->shopID,
            $this->_sitePageData, $this->_driverDB, array('limit_page' => 5000), 0,
            TRUE, array());

        $model = new Model_Shop_Model();
        $model->setDBDriver($this->_driverDB);
        $this->_rebuildModel($ids, $model);

        $this->_sitePageData->dataLanguageID = 36;
        $this->_sitePageData->languageID = 36;
        // получаем список
        $ids = Request_Request::find('DB_Shop_Model', $this->_sitePageData->shopID,
            $this->_sitePageData, $this->_driverDB, array('limit_page' => 5000), 0,
            TRUE, array());

        $model = new Model_Shop_Model();
        $model->setDBDriver($this->_driverDB);
        $this->_rebuildModel($ids, $model);
    }

    public function action_modal_parse_site_by_article() {
        $this->_sitePageData->url = '/cabinet/shopmodel/modal_parse_site_by_article';

        $ids = Request_Request::find('DB_Shop_Model', $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB,
            array(), 5000);
        $ids = $ids->getChildArrayID();

        $dataID = new MyArray();
        $dataID->id = 0;
        $dataID->isFindDB = TRUE;
        $dataID->isLoadElements = TRUE;
        $dataID->isParseData = FALSE;
        $dataID->values['ids'] = $ids;

        $data = Helpers_View::getViewObject($dataID, new Model_Shop_Model(), '_shop/model/modal/parse-site/by-article',
            $this->_sitePageData, $this->_driverDB);

        $this->response->body($data);
    }

    public function action_parse_site_by_article() {
        $this->_sitePageData->url = '/cabinet/shopmodel/parse_site_by_article';

        $id = Request_RequestParams::getParamInt('id');
        $article = Request_RequestParams::getParamStr('article');
        $isReplace = Request_RequestParams::getParamBoolean('is_replace');

        $result = FALSE;
        $model = new Model_Shop_Model();
        switch (Request_RequestParams::getParamStr('site')){
            case 'ensto.com':
                if ($id > 0) {
                    $result = Drivers_ParserSite_EnstoCom::findOne($article, $id, $this->_sitePageData->shopID, $model,
                        $this->_sitePageData, $this->_driverDB, $isReplace);

                    if ($result){
                        Helpers_DB::saveDBObject($model, $this->_sitePageData);
                    }
                }else{
                    $result = Drivers_ParserSite_EnstoCom::findOneInObject($article, $model, $this->_sitePageData,
                        $this->_driverDB, $isReplace);
                }
                break;
        }

        if ($result){
            $result = array(
                'error' => FALSE,
                'values' => $model->getValues(TRUE, TRUE, $this->_sitePageData->shopID),
            );
        }else{
            $result = array(
                'error' => TRUE,
            );
        }

        $this->response->body(Json::json_encode($result));
    }
}
