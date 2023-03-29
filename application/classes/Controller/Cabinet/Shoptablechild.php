<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Cabinet_ShopTablechild extends Controller_Cabinet_File {

    public function __construct(Request $request, Response $response)
    {
        $this->dbObject = 'DB_Shop_Table_child';
        $this->controllerName = 'shoptablechild';
        $this->tableID = Model_Shop_Table_child::TABLE_ID;
        $this->tableName = Model_Shop_Table_child::TABLE_NAME;
        $this->objectName = 'child';

        parent::__construct($request, $response);
        $this->_sitePageData->controllerName = $this->controllerName;
    }

    public function action_index() {
        $this->_sitePageData->url = '/cabinet/shoptablechild/index';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/_table/child/list/index',
                'view::_shop/_table/catalog/one/th-options',
            )
        );

        // тип объекта
        $type = $this->_getType();

        // колонки
        $dataID = new MyArray();
        $dataID->id = $type['id'];
        $dataID->additionDatas['options_name'] = 'shop_table_child';
        $dataID->values = $type;
        $dataID->isFindDB = TRUE;

        $this->_sitePageData->replaceDatas['view::_shop/_table/catalog/one/th-options'] =
            Helpers_View::getViewObject($dataID, new Model_Shop_Table_child(),
            '_shop/_table/catalog/one/th-options', $this->_sitePageData, $this->_driverDB);

        // получаем список
        View_View::find('DB_Shop_Table_child', $this->_sitePageData->shopID,
            "_shop/_table/child/list/index", "_shop/_table/child/one/index", $this->_sitePageData, $this->_driverDB,
            array('type' => $type['id'], 'limit_page' => 25), array('shop_table_catalog_id'));

        $this->_putInMain('/main/_shop/_table/child/index');
    }

    public function action_sort() {
        $this->_sitePageData->url = '/cabinet/shoptablechild/sort';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/_table/child/list/index',
                'view::_shop/_table/catalog/one/th-options',
            )
        );

        // тип объекта
        $type = $this->_getType();

        // колонки
        $dataID = new MyArray();
        $dataID->id = $type['id'];
        $dataID->additionDatas['options_name'] = 'shop_table_child';
        $dataID->values = $type;
        $dataID->isFindDB = TRUE;

        $this->_sitePageData->replaceDatas['view::_shop/_table/catalog/one/th-options'] =
            Helpers_View::getViewObject($dataID, new Model_Shop_Table_child(),
                '_shop/_table/catalog/one/th-options', $this->_sitePageData, $this->_driverDB);

        // получаем список
        $this->_sitePageData->replaceDatas['view::_shop/_table/child/list/index'] = View_View::find('DB_Shop_Table_child', $this->_sitePageData->shopID,
            "_shop/_table/child/list/sort", "_shop/_table/child/one/sort", $this->_sitePageData, $this->_driverDB,
            array_merge($_GET, $_POST, array('sort_by'=>array('order' => 'asc', 'id' => 'desc'), 'limit_page' => 0, 'type' => $type['id'], Request_RequestParams::IS_NOT_READ_REQUEST_NAME => FALSE)),
            array('shop_table_catalog_id'));

        $this->_putInMain('/main/_shop/_table/child/index');
    }

    public function action_index_edit() {
        $this->_sitePageData->url = '/cabinet/shoptablechild/index_edit';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/_table/child/list/index',
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
        $options = Arr::path($type['fields_options'], 'shop_table_child', array());
        foreach($options as $key => $value){
            $s = 'options.'.htmlspecialchars(Arr::path($value, 'field', Arr::path($value, 'name', '')), ENT_QUOTES);
            $fields = $fields .'<option data-id="'.$s.'" value="'.$s.'">'.$value['title'].'</option>';
        }
        $fields = $fields
            .'<option data-id="is_public" value="is_public">Опубликован</option>'
            .'<option data-id="shop_table_rubric_id" value="shop_table_rubric_id">Рубрика</option>';
        $this->_sitePageData->replaceDatas['view::editfields/list'] = $fields;

        // получаем список
        $this->_sitePageData->replaceDatas['_shop/_table/child/list/index'] = View_View::find('DB_Shop_Table_child', $this->_sitePageData->shopID,
            "_shop/_table/child/list/index-edit", "_shop/_table/child/one/index-edit", $this->_sitePageData, $this->_driverDB,
            array_merge(array('sort_by'=>array('name' => 'asc', 'id' => 'desc', 'limit_page' => 25)), $_GET, $_POST, array('type' => $type['id'], 'table_id' => Request_RequestParams::getParamInt('table_id'), 'is_public_ignore' => TRUE, Request_RequestParams::IS_NOT_READ_REQUEST_NAME => FALSE)),
            array('shop_table_catalog_id', 'shop_table_rubric_id'));

        $this->_putInMain('/main/_shop/_table/child/index');
    }

    public function action_new() {
        $this->_sitePageData->url = '/cabinet/shoptablechild/new';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/_table/child/one/new',
            )
        );

        // тип объекта
        $type = $this->_getType();

        // получаем языки перевода
        $this->getLanguagesByShop(
            URL::query(
                array(
                    'type' => $type['id'],
                    'root_table_id' => Request_RequestParams::getParamInt('root_table_id'),
                    'shop_root_table_catalog_id' => Request_RequestParams::getParamInt('shop_root_table_catalog_id'),
                    'shop_root_table_object_id' => Request_RequestParams::getParamInt('shop_root_table_object_id'),
                ), FALSE
            ),
            FALSE
        );

        $dataID = new MyArray();
        $dataID->id = 0;
        // дополнительные поля
        Arr::set_path($dataID->values, Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_table_catalog_id', $type);
        $dataID->isFindDB = TRUE;

        $this->_sitePageData->replaceDatas['view::_shop/_table/child/one/new'] =
            Helpers_View::getViewObject($dataID, new Model_Shop_Table_child(),
            '_shop/_table/child/one/new', $this->_sitePageData, $this->_driverDB);

        $this->_putInMain('/main/_shop/_table/child/new');
    }

    public function action_edit() {
        $this->_sitePageData->url = '/cabinet/shoptablechild/edit';

        // тип объекта
        $type = $this->_getType();

        // id записи
        $id = Request_RequestParams::getParamInt('id');
        if ($id === NULL) {
            throw new HTTP_Exception_404('Table child not is found!');
        }else {
            $model = new Model_Shop_Table_child();
            if (! $this->dublicateObjectLanguage($model, $id)) {
                throw new HTTP_Exception_404('Table child not is found!');
            }
        }

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/_table/child/one/edit',
            )
        );

        // получаем языки перевода
        $this->getLanguagesByShop(
            URL::query(
                array(
                    'id' => $id,
                    'type' => $type['id'],
                    'root_table_id' => $model->getRootTableID(),
                    'shop_root_table_catalog_id' => $model->getShopRootTableCatalogID(),
                    'shop_root_table_object_id' => $model->getShopRootTableObjectID(),
                ), FALSE
            ),
            FALSE
        );

        // получаем данные
        View_View::findOne('DB_Shop_Table_child', $this->_sitePageData->shopID, "_shop/_table/child/one/edit",
            $this->_sitePageData, $this->_driverDB, array('id' => $id), array('shop_table_catalog_id'));

        $this->_putInMain('/main/_shop/_table/child/edit');
    }

    public function action_save() {
        $this->_sitePageData->url = '/cabinet/shoptablechild/save';

        $result = Api_Shop_Table_child::save($this->_sitePageData, $this->_driverDB);

        if (Request_RequestParams::getParamBoolean('json') || $result['result']['error']) {
            $this->response->body(Json::json_encode($result));
        } else {
            unset($result['result']);

            if(Request_RequestParams::getParamBoolean('is_close') === FALSE){
                $this->redirect('/cabinet/shoptablechild/edit'.URL::query($result, FALSE));
            }else{
                $result['shop_table_child_id'] = $result['id'];
                $result['is_public_ignore'] = TRUE;
                unset($result['id']);

                $this->redirect('/cabinet/shoptablechild/index'.URL::query($result, FALSE));
            }
        }
    }   
}
