<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Cabinet_ShopTableSelect extends Controller_Cabinet_File {

    public function __construct(Request $request, Response $response)
    {
        $this->dbObject = 'DB_Shop_Table_Select';
        $this->controllerName = 'shoptableselect';
        $this->tableID = Model_Shop_Table_Select::TABLE_ID;
        $this->tableName = Model_Shop_Table_Select::TABLE_NAME;
        $this->objectName = 'select';

        parent::__construct($request, $response);
        $this->_sitePageData->controllerName = $this->controllerName;
    }

    public function action_index() {
        $this->_sitePageData->url = '/cabinet/shoptableselect/index';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/_table/select/list/index',
                'view::_shop/_table/rubric/list/list',
            )
        );

        // тип объекта
        $type = $this->_getType();
        $this->_requestTranslateTr();

        // получаем список
        View_View::find('DB_Shop_Table_Select', $this->_sitePageData->shopID,
            "_shop/_table/select/list/index", "_shop/_table/select/one/index", $this->_sitePageData, $this->_driverDB,
            array('type' => $type['id'], 'table_id' => Request_RequestParams::getParamInt('table_id'), 'limit_page' => 25), array('shop_table_rubric_id'));

        View_View::find('DB_Shop_Table_Rubric', $this->_sitePageData->shopID,
            "_shop/_table/rubric/list/list", "_shop/_table/rubric/one/list", $this->_sitePageData, $this->_driverDB,
            array('type' => array(0, $type['id']), 'table_id' => Model_Shop_Table_Select::TABLE_ID, Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE));

        $this->_putInMain('/main/_shop/_table/select/index');
    }

    public function action_sort() {
        $this->_sitePageData->url = '/cabinet/shoptableselect/sort';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/_table/select/list/index',
                'view::_shop/_table/rubric/list/list',
            )
        );

        // тип объекта
        $type = $this->_getType();

        // получаем список
        $this->_sitePageData->replaceDatas['view::_shop/_table/select/list/index'] = View_View::find('DB_Shop_Table_Select', $this->_sitePageData->shopID,
            "_shop/_table/select/list/sort", "_shop/_table/select/one/sort", $this->_sitePageData, $this->_driverDB,
            array('type' => $type['id'], 'table_id' => Request_RequestParams::getParamInt('table_id'), 'limit_page' => 25));

        View_View::find('DB_Shop_Table_Rubric', $this->_sitePageData->shopID,
            "_shop/_table/rubric/list/list", "_shop/_table/rubric/one/list",
            $this->_sitePageData, $this->_driverDB, array('type' => array(0, $type['id']), 'table_id' => Model_Shop_Table_Select::TABLE_ID, Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE));

        $this->_putInMain('/main/_shop/_table/select/index');
    }

    public function action_index_edit() {
        $this->_sitePageData->url = '/cabinet/shoptableselect/index_edit';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/_table/select/list/index',
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
        $options = Arr::path($type['fields_options'], 'shop_table_select', array());
        foreach($options as $key => $value){
            $s = 'options.'.htmlspecialchars(Arr::path($value, 'field', Arr::path($value, 'name', '')), ENT_QUOTES);
            $fields = $fields .'<option data-id="'.$s.'" value="'.$s.'">'.$value['title'].'</option>';
        }
        $fields = $fields
            .'<option data-id="is_public" value="is_public">Опубликован</option>'
            .'<option data-id="shop_table_rubric_id" value="shop_table_rubric_id">Рубрика</option>';
        $this->_sitePageData->replaceDatas['view::editfields/list'] = $fields;

        View_View::find('DB_Shop_Table_Rubric', $this->_sitePageData->shopID,
            "_shop/_table/rubric/list/list", "_shop/_table/rubric/one/list", $this->_sitePageData, $this->_driverDB,
            array('type' => array(0, $type['id']), 'table_id' => Model_Shop_Table_Select::TABLE_ID, Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE));

        // получаем список
        $this->_sitePageData->replaceDatas['_shop/_table/select/list/index'] = View_View::find('DB_Shop_Table_Select', $this->_sitePageData->shopID,
            "_shop/_table/select/list/index-edit", "_shop/_table/select/one/index-edit", $this->_sitePageData, $this->_driverDB,
            array_merge(array('sort_by'=>array('name' => 'asc', 'id' => 'desc', 'limit_page' => 25)), $_GET, $_POST, array('type' => $type['id'], 'table_id' => Request_RequestParams::getParamInt('table_id'), 'is_public_ignore' => TRUE, Request_RequestParams::IS_NOT_READ_REQUEST_NAME => FALSE)),
            array('shop_table_catalog_id', 'shop_table_rubric_id'));

        $this->_putInMain('/main/_shop/_table/select/index');
    }

    public function action_new() {
        $this->_sitePageData->url = '/cabinet/shoptableselect/new';

        // тип объекта
        $type = $this->_getType();

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/_table/select/one/new',
                'view::_shop/_table/rubric/list/list',
            )
        );

        // получаем языки перевода
        $this->getLanguagesByShop(
            URL::query(
                array(
                    'type' => $type['id'],
                ), FALSE
            ),
            FALSE
        );

        View_View::find('DB_Shop_Table_Rubric', $this->_sitePageData->shopID,
            "_shop/_table/rubric/list/list", "_shop/_table/rubric/one/list",
            $this->_sitePageData, $this->_driverDB, array('type' => array(0, $type['id']), 'table_id' => Request_RequestParams::getParamInt('table_id'), Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE));

        $dataID = new MyArray();
        $dataID->id = 0;
        // дополнительные поля
        Arr::set_path($dataID->values, Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_table_catalog_id', $type);
        $dataID->isFindDB = TRUE;

        $model = new Model_Shop_Table_Select();
        $datas = Helpers_View::getViewObject($dataID, $model,
            '_shop/_table/select/one/new', $this->_sitePageData, $this->_driverDB);
        $this->_sitePageData->replaceDatas['view::_shop/_table/select/one/new'] = $datas;

        $this->_putInMain('/main/_shop/_table/select/new');
    }

    public function action_edit() {
        $this->_sitePageData->url = '/cabinet/shoptableselect/edit';

        // тип объекта
        $type = $this->_getType();

        // id записи
        $id = Request_RequestParams::getParamInt('id');
        if ($id === NULL) {
            throw new HTTP_Exception_404('Table select not is found!');
        }else {
            $model = new Model_Shop_Table_Select();
            if (! $this->dublicateObjectLanguage($model, $id)) {
                throw new HTTP_Exception_404('Table select not is found!');
            }
        }

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/_table/select/one/edit',
                'view::_shop/_table/rubric/list/list',
            )
        );

        // получаем языки перевода
        $this->getLanguagesByShop(
            URL::query(
                array(
                    'id' => $id,
                    'type' => $type['id'],
                ), FALSE
            ),
            FALSE
        );

        // получаем список ID рубрик
        $shopTableRubricIDs = View_View::find('DB_Shop_Table_Rubric', $this->_sitePageData->shopID,
            "_shop/_table/rubric/list/list", "_shop/_table/rubric/one/list",
            $this->_sitePageData, $this->_driverDB, array('type' => array(0, $type['id']), 'table_id' => Request_RequestParams::getParamInt('table_id'), Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE));
        $s = 'value="' . $model->getShopTableRubricID() . '"';
        $shopTableRubricIDs = str_replace($s, $s . ' selected', $shopTableRubricIDs);
        $this->_sitePageData->replaceDatas['view::_shop/_table/rubric/list/list'] = $shopTableRubricIDs;

        // получаем данные
        View_View::findOne('DB_Shop_Table_Select', $this->_sitePageData->shopID, "_shop/_table/select/one/edit",
            $this->_sitePageData, $this->_driverDB, array('id' => $id), array('shop_table_catalog_id'));

        $this->_putInMain('/main/_shop/_table/select/edit');
    }

    public function action_save() {
        $this->_sitePageData->url = '/cabinet/shoptableselect/save';
        $result = Api_Shop_Table_Select::save($this->_sitePageData, $this->_driverDB);
        $this->_redirectSaveResult($result);
    }   
}
