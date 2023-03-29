<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Cabinet_ShopTableRubric extends Controller_Cabinet_File {

    public function __construct(Request $request, Response $response)
    {
        $this->dbObject = DB_Shop_Table_Rubric::NAME;
        $this->controllerName = 'shoptablerubric';
        $this->tableID = Model_Shop_Table_Rubric::TABLE_ID;
        $this->tableName = Model_Shop_Table_Rubric::TABLE_NAME;
        $this->objectName = 'rubric';

        parent::__construct($request, $response);
        $this->_sitePageData->controllerName = $this->controllerName;
    }

    public function action_index() {
        $this->_sitePageData->url = '/cabinet/shoptablerubric/index';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/_table/rubric/list/index',
                'view::_shop/_table/rubric/list/list',
            )
        );

        $tableID = intval(Request_RequestParams::getParamInt('table_id'));

        // тип объекта
        $type = $this->_getType();
        $this->_requestShopTableSelect($type);
        $this->_requestShopTableUnit($type);
        $this->_requestShopTableBrand($type);
        $this->_requestTranslateTr();
        $this->_requestTranslateDataLanguages();

        // получаем список
        $params = Request_RequestParams::setParams(
            array(
                'limit_page' => 25,
                'type' => $type['id'],
                'table_id' => $tableID,
                'is_list' => TRUE,
            ),
            FALSE
        );
        View_View::find('DB_Shop_Table_Rubric', $this->_sitePageData->shopID,
            "_shop/_table/rubric/list/index", "_shop/_table/rubric/one/index",
            $this->_sitePageData, $this->_driverDB, $params, array('root_id'));

        $params = Request_RequestParams::setParams(
            array(
                'type' => $type['id'],
                'table_id' => $tableID,
            )
        );
        View_View::find('DB_Shop_Table_Rubric', $this->_sitePageData->shopID, "_shop/_table/rubric/list/list",
            "_shop/_table/rubric/one/list", $this->_sitePageData, $this->_driverDB, $params, array('root_id'));

        $this->_putInMain('/main/_shop/_table/rubric/index');
    }

    public function action_sort() {
        $this->_sitePageData->url = '/cabinet/shoptablerubric/sort';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/_table/rubric/list/index',
                'view::_shop/_table/rubric/list/list',
            )
        );

        $tableID = intval(Request_RequestParams::getParamInt('table_id'));

        // тип объекта
        $type = $this->_getType();
        $this->_requestShopTableSelect($type);
        $this->_requestShopTableUnit($type);
        $this->_requestShopTableBrand($type);
        $this->_requestTranslateDataLanguages();

        // получаем список
        $params = Request_RequestParams::setParams(
            array_merge(
                $_GET,
                $_POST,
                array(
                    'limit_page' => 5000,
                    'type' => $type['id'],
                    'table_id' => $tableID,
                    'is_list' => TRUE,
                    'sort_by' => array('root_id' => 'desc', 'order' => 'asc', 'id' => 'desc'),
                )
            )
        );
        $this->_sitePageData->replaceDatas['view::_shop/_table/rubric/list/index'] =
            View_View::find('DB_Shop_Table_Rubric', $this->_sitePageData->shopID, "_shop/_table/rubric/list/sort",
                "_shop/_table/rubric/one/sort", $this->_sitePageData, $this->_driverDB, $params, array('root_id'));

        $params = Request_RequestParams::setParams(
            array(
                'type' => $type['id'],
                'table_id' => $tableID,
            )
        );
        View_View::find('DB_Shop_Table_Rubric', $this->_sitePageData->shopID, "_shop/_table/rubric/list/list",
            "_shop/_table/rubric/one/list", $this->_sitePageData, $this->_driverDB, $params, array('root_id'));

        $this->_putInMain('/main/_shop/_table/rubric/index');
    }

    public function action_index_edit() {
        $this->_sitePageData->url = '/cabinet/shoptablerubric/index_edit';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/_table/rubric/list/index',
                'view::_shop/_table/rubric/list/list',
                'view::editfields/list',
            )
        );

        // тип объекта
        $type = $this->_getType();
        $this->_requestShopTableSelect($type);
        $this->_requestShopTableUnit($type);
        $this->_requestShopTableBrand($type);
        $this->_requestTranslateDataLanguages();

        $fields =
            '<option data-id="old_id" value="old_id">ID</option>'
            .'<option data-id="name" value="name">Название</option>'
            .'<option data-id="text" value="text">Описание</option>'
            .'<option data-id="options" value="options">Все заполненные атрибуты</option>';
        $options = Arr::path($type['fields_options'], 'shop_table_rubric', array());
        foreach($options as $key => $value){
            $s = 'options.'.htmlspecialchars(Arr::path($value, 'field', Arr::path($value, 'name', '')), ENT_QUOTES);
            $fields = $fields .'<option data-id="'.$s.'" value="'.$s.'">'.$value['title'].'</option>';
        }
        $fields = $fields
            .'<option data-id="is_public" value="is_public">Опубликован</option>'
            .'<option data-id="root_id" value="root_id">Родитель</option>';
        $this->_sitePageData->replaceDatas['view::editfields/list'] = $fields;

        View_View::find('DB_Shop_Table_Rubric', $this->_sitePageData->shopID,
            "_shop/_table/rubric/list/list", "_shop/_table/rubric/one/list", $this->_sitePageData, $this->_driverDB,
            array('type' => array(0, $type['id']), 'table_id' => Model_Shop_Table_Rubric::TABLE_ID, Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE));

        // получаем список
        $this->_sitePageData->replaceDatas['_shop/_table/rubric/list/index'] = View_View::find('DB_Shop_Table_Rubric', $this->_sitePageData->shopID,
            "_shop/_table/rubric/list/index-edit", "_shop/_table/rubric/one/index-edit", $this->_sitePageData, $this->_driverDB,
            array_merge(array('sort_by'=>array('name' => 'asc', 'id' => 'desc', 'limit_page' => 25)), $_GET, $_POST, array('type' => $type['id'], 'table_id' => Request_RequestParams::getParamInt('table_id'), 'is_public_ignore' => TRUE, Request_RequestParams::IS_NOT_READ_REQUEST_NAME => FALSE)),
            array('shop_table_catalog_id', 'root_id'));

        $this->_putInMain('/main/_shop/_table/rubric/index');
    }

    public function action_new() {
        $this->_sitePageData->url = '/cabinet/shoptablerubric/new';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/_table/rubric/list/list',
                'view::_shop/_table/rubric/one/new',
            )
        );

        $tableID = intval(Request_RequestParams::getParamInt('table_id'));

        // тип объекта
        $type = $this->_getType();
        $this->_requestShopTableSelect($type);
        $this->_requestShopTableUnit($type);
        $this->_requestShopTableBrand($type);

        // получаем языки перевода
        $this->getLanguagesByShop(
            URL::query(
                array(
                    'type' => $type['id'],
                    'table_id' => $tableID,
                ), FALSE
            ),
            FALSE
        );

        View_View::find('DB_Shop_Table_Rubric', $this->_sitePageData->shopID, "_shop/_table/rubric/list/list", "_shop/_table/rubric/one/list",
            $this->_sitePageData, $this->_driverDB, array('type' => $type['id'], 'table_id' => $tableID, Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE));

        $dataID = new MyArray();
        $dataID->id = 0;
        // дополнительные поля
        Arr::set_path($dataID->values, Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_table_catalog_id', $type);
        $dataID->isFindDB = TRUE;

        $model = new Model_Shop_Table_Rubric();
        $datas = Helpers_View::getViewObject($dataID, $model, '_shop/_table/rubric/one/new', $this->_sitePageData, $this->_driverDB);
        $this->_sitePageData->replaceDatas['view::_shop/_table/rubric/one/new'] = $datas;

        $this->_putInMain('/main/_shop/_table/rubric/new');
    }

    public function action_edit() {
        $this->_sitePageData->url = '/cabinet/shoptablerubric/edit';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/_table/rubric/list/list',
                'view::_shop/_table/rubric/one/edit',
            )
        );

        $tableID = intval(Request_RequestParams::getParamInt('table_id'));

        // тип объекта
        $type = $this->_getType();

        $id = Request_RequestParams::getParamInt('id');

        // получаем языки перевода
        $this->getLanguagesByShop(
            URL::query(
                array(
                    'id' => $id,
                    'type' => $type['id'],
                    'table_id' => $tableID,
                ), FALSE
            ),
            FALSE
        );

        // получаем список ID категорий
        $shopTableRubricIDs = Request_Request::find('DB_Shop_Table_Rubric', $this->_sitePageData->shopID,
            $this->_sitePageData, $this->_driverDB, array('type' => $type['id'], 'table_id' => $tableID, Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE));
        $shopTableRubricIDs->deleteChildByID($id);

        $model = new Model_Shop_Table_Rubric();
        $model->setDBDriver($this->_driverDB);
        $shopTableRubricIDAll = $this->getViewObjects($shopTableRubricIDs, $model, "_shop/_table/rubric/list/list", "_shop/_table/rubric/one/list");

        // получаем данные
        if(! $this->getDBObject($model, $id)){
            throw new HTTP_Exception_404('Table rubric not is found!');
        }

        $s = 'value="' . $model->getRootID() . '"';
        $shopTableRubricIDAll = str_replace($s, $s . ' selected', $shopTableRubricIDAll);
        $this->_sitePageData->replaceDatas['view::_shop/_table/rubric/list/list'] = $shopTableRubricIDAll;

        $this->_requestShopTableSelect($type, $model->getShopTableSelectID());
        $this->_requestShopTableUnit($type, $model->getShopTableUnitID());
        $this->_requestShopTableBrand($type, $model->getShopTableBrandID());

        View_View::findOne('DB_Shop_Table_Rubric', $this->_sitePageData->shopID, '_shop/_table/rubric/one/edit',
            $this->_sitePageData, $this->_driverDB, array('id' => $id, Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE), array('shop_table_catalog_id'));

        $this->_putInMain('/main/_shop/_table/rubric/edit');
    }

    public function action_save() {
        $this->_sitePageData->url = '/cabinet/shoptablerubric/save';
        $result = Api_Shop_Table_Rubric::save($this->_sitePageData, $this->_driverDB);
        $this->_redirectSaveResult($result);
    }

    public function action_save_in_good()
    {
        $this->_sitePageData->url = '/cabinet/shoptablerubric/save_in_good';

        $id = Request_RequestParams::getParamInt('id');
        $shopGoodID = Api_Shop_Table_Rubric::saveInGood($id, $this->_sitePageData, $this->_driverDB);

        self::redirect('/cabinet/shopgood/edit?id='.$shopGoodID.'&shop_branch_id='.$this->_sitePageData->shopID);
    }

    /**
     * Выводит дерево каталогов на экран
     * @param MyArray $ids
     * @param string $prefix
     */
    private function _echoTreeRubric(MyArray $ids, $prefix = '', $add = '--'){
        foreach ($ids->childs as $child){
            echo $prefix.$child->values['name'].'<br>';
            $this->_echoTreeRubric($child, $prefix.$add, $add.'--');
        }
    }

    public function action_tree() {
        $this->_sitePageData->url = '/cabinet/shoptablerubric/tree';

        // получаем список заказов
        $ids = Request_Request::find('DB_Shop_Table_Rubric', $this->_sitePageData->shopID,
            $this->_sitePageData, $this->_driverDB, array('is_tree' => TRUE, 'limit_page' => 5000), 0,
            TRUE, array());

        $this->_echoTreeRubric($ids);
    }

    /**
     * Перестроить дерево каталогов
     * @param MyArray $ids
     * @param string $prefix
     */
    private function _rebuildTreeRubric(MyArray $ids, Model_Shop_Table_Rubric $model){
        foreach ($ids->childs as $child){
            $model->clear();
            $model->__setArray(array('values' => $child->values));
            $model->setNameURL(Helpers_URL::getNameURL($model));
            Helpers_DB::saveDBObject($model, $this->_sitePageData);

            $this->_rebuildTreeRubric($child, $model);
        }
    }

    public function action_rebuild_tree() {
        $this->_sitePageData->url = '/cabinet/shoptablerubric/rebuild_tree';

        $this->_sitePageData->dataLanguageID = 35;
        $this->_sitePageData->languageID = 35;
        // получаем список
        $ids = Request_Request::find('DB_Shop_Table_Rubric', $this->_sitePageData->shopID,
            $this->_sitePageData, $this->_driverDB, array('is_tree' => TRUE, 'limit_page' => 5000), 0,
            TRUE, array());

        $model = new Model_Shop_Table_Rubric();
        $model->setDBDriver($this->_driverDB);
        $this->_rebuildTreeRubric($ids, $model);

        $this->_sitePageData->dataLanguageID = 36;
        $this->_sitePageData->languageID = 36;
        // получаем список
        $ids = Request_Request::find('DB_Shop_Table_Rubric', $this->_sitePageData->shopID,
            $this->_sitePageData, $this->_driverDB, array('is_tree' => TRUE, 'limit_page' => 5000), 0,
            TRUE, array());

        $model = new Model_Shop_Table_Rubric();
        $model->setDBDriver($this->_driverDB);
        $this->_rebuildTreeRubric($ids, $model);
    }

    /**
     * Проверяем дерево на зацикливание
     * @throws HTTP_Exception_500
     */
    public function action_check_tree() {
        $this->_sitePageData->url = '/cabinet/shoptablerubric/check_tree';
        // получаем список
        $ids = Request_Request::find('DB_Shop_Table_Rubric', $this->_sitePageData->shopID,
            $this->_sitePageData, $this->_driverDB, array('is_public_ignore' => TRUE, 'is_delete_ignore' => TRUE, 'limit_page' => 50000), 0,
            TRUE, array());


        $model = new Model_Shop_Table_Rubric();
        $model->setDBDriver($this->_driverDB);
        foreach ($ids->childs as $child) {
            $list = array();
            $rootID = $child->values['root_id'];

            $arr = array();
            while ($rootID > 0) {
                $child = new MyArray();
                $child->id = $rootID;
                if (!Helpers_View::getDBData($child, $model, $this->_sitePageData)) {
                    break;
                }

                $rootID = $child->values['root_id'];
                $list[] = $child;
                if(key_exists($rootID, $arr)){
                    break;
                }
                $arr[$rootID] = '';
            }
        }
        echo 'Finish. Error not.';
    }
}
