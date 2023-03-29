<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Cabinet_ShopNew extends Controller_Cabinet_BasicCabinet
{
    public function __construct(Request $request, Response $response)
    {
        $this->dbObject = 'DB_Shop_New';
        $this->controllerName = 'shopnew';
        $this->tableID = Model_Shop_New::TABLE_ID;
        $this->tableName = Model_Shop_New::TABLE_NAME;
        $this->objectName = 'new';

        parent::__construct($request, $response);
        $this->_sitePageData->controllerName = $this->controllerName;
    }

    public function action_index() {
        $this->_sitePageData->url = '/cabinet/shopnew/index';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/new/list/index',
            )
        );

        // тип объекта
        $type = $this->_getType();
        // список объектов
        $this->_requestTableObjects($type);
        $this->_requestTranslateTr();
        $this->_requestTranslateDataLanguages();

        // получаем список
        View_View::find('DB_Shop_New', $this->_sitePageData->shopID, "_shop/new/list/index", "_shop/new/one/index",
            $this->_sitePageData, $this->_driverDB, array('limit_page' => 25), array('shop_table_rubric_id' => array('name')));

        $this->_putInMain('/main/_shop/new/index');
    }

    public function action_sort(){
        $this->_sitePageData->url = '/cabinet/shopnew/sort';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/new/list/index',
            )
        );

        // тип объекта
        $type = $this->_getType();
        // список объектов
        $this->_requestTableObjects($type);
        $this->_requestTranslateDataLanguages();

        // получаем список
        $this->_sitePageData->replaceDatas['view::_shop/new/list/index'] = View_View::find('DB_Shop_New', $this->_sitePageData->shopID,
            "_shop/new/list/sort", "_shop/new/one/sort",
            $this->_sitePageData, $this->_driverDB,
            array_merge($_GET, $_POST, array('sort_by'=>array('order' => 'asc', 'id' => 'desc'), 'limit_page' => 0, 'type' => $type['id'], Request_RequestParams::IS_NOT_READ_REQUEST_NAME => FALSE)));

        $this->_putInMain('/main/_shop/new/index');
    }

    public function action_index_edit() {
        $this->_sitePageData->url = '/cabinet/shopnew/index_edit';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/new/list/index',
                'view::editfields/list',
            )
        );

        // тип объекта
        $type = $this->_getType();
        // список объектов
        $this->_requestTableObjects($type);
        $this->_requestTranslateDataLanguages();

        $fields =
            '<option data-id="old_id" value="old_id">ID</option>'
            .'<option data-id="name" value="name">Название</option>'
            .'<option data-id="info" value="info">Описание</option>'
            .'<option data-id="article" value="article">Артикул</option>'
            .'<option data-id="options" value="options">Все заполненные атрибуты</option>';

        $arr = Arr::path($type['fields_options'], 'shop_new', array());
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
        $this->_sitePageData->replaceDatas['view::_shop/new/list/index'] = View_View::find('DB_Shop_New', $this->_sitePageData->shopID,
            "_shop/new/list/index-edit", "_shop/new/one/index-edit",
            $this->_sitePageData, $this->_driverDB,
            array_merge(array('sort_by'=>array('name' => 'asc', 'id' => 'desc', 'limit_page' => 25)), $_GET, $_POST, array('type' => $type['id'], 'is_public_ignore' => TRUE, Request_RequestParams::IS_NOT_READ_REQUEST_NAME => FALSE)),
            array('shop_table_catalog_id'));

        $this->_putInMain('/main/_shop/new/index');
    }

    public function action_new()
    {
        $this->_sitePageData->url = '/cabinet/shopnew/new';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/new/one/new',
            )
        );

        // тип объекта
        $type = $this->_getType();

        $this->_requestTableObject($type);

        // получаем языки перевода
        $this->getLanguagesByShop(
            URL::query(
                array(
                    'type' => $type['id'],
                    'is_group' => Request_RequestParams::getParamBoolean('is_group')
                ), FALSE
            ),
            FALSE
        );

        $dataID = new MyArray();
        $dataID->id = 0;
        // дополнительные поля
        Arr::set_path($dataID->values, Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_table_catalog_id', $type);
        $dataID->isFindDB = TRUE;

        $this->_sitePageData->replaceDatas['view::_shop/new/one/new'] = Helpers_View::getViewObject($dataID, new Model_Shop_New(),
            '_shop/new/one/new', $this->_sitePageData, $this->_driverDB);

        $this->_putInMain('/main/_shop/new/new');
    }

    public function action_edit()
    {
        $this->_sitePageData->url = '/cabinet/shopnew/edit';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/new/one/edit',
            )
        );

        // id записи
        $shopNewID = Request_RequestParams::getParamInt('id');
        $modelNew = new Model_Shop_New();
        if (! $this->dublicateObjectLanguage($modelNew, $shopNewID, -1, FALSE)) {
            throw new HTTP_Exception_404('News not is found!');
        }

        // тип объекта
        $type = $this->_getType($modelNew->getShopTableCatalogID());

        $this->_requestTableObject($type, $modelNew);

        // получаем языки перевода
        $this->getLanguagesByShop(
            URL::query(
                array(
                    'id' => $shopNewID,
                    'type' => $type['id'],
                    'is_group' => Request_RequestParams::getParamBoolean('is_group')
                ), FALSE
            ),
            FALSE
        );

        // получаем данные
        View_View::findOne('DB_Shop_New', $this->_sitePageData->shopID, "_shop/new/one/edit",
            $this->_sitePageData, $this->_driverDB, array('id' => $shopNewID), array('shop_table_catalog_id'));

        $this->_putInMain('/main/_shop/new/edit');
    }

    public function action_save()
    {
        $this->_sitePageData->url = '/cabinet/shopnew/save';
        $result = Api_Shop_New::save($this->_sitePageData, $this->_driverDB);
        $this->_redirectSaveResult($result);
    }



    /**
     * Перестроить товары
     * @param MyArray $ids
     * @param Model_Shop_New $model
     */
    private function _rebuildNew(MyArray $ids, Model_Shop_New $model){
        foreach ($ids->childs as $child){
            $model->clear();
            $model->__setArray(array('values' => $child->values));
            $model->setNameURL(Helpers_URL::getNameURL($model));
            Helpers_DB::saveDBObject($model, $this->_sitePageData);
        }
    }

    public function action_rebuild_news() {
        $this->_sitePageData->url = '/cabinet/shopnew/rebuild_news';

        $this->_sitePageData->dataLanguageID = 35;
        $this->_sitePageData->languageID = 35;
        // получаем список
        $ids = Request_Request::find('DB_Shop_New', $this->_sitePageData->shopID,
            $this->_sitePageData, $this->_driverDB, array('limit_page' => 5000), 0,
            TRUE, array());

        $model = new Model_Shop_New();
        $model->setDBDriver($this->_driverDB);
        $this->_rebuildNew($ids, $model);

        $this->_sitePageData->dataLanguageID = 36;
        $this->_sitePageData->languageID = 36;
        // получаем список
        $ids = Request_Request::find('DB_Shop_New', $this->_sitePageData->shopID,
            $this->_sitePageData, $this->_driverDB, array('limit_page' => 5000), 0,
            TRUE, array());

        $model = new Model_Shop_New();
        $model->setDBDriver($this->_driverDB);
        $this->_rebuildNew($ids, $model);
    }
}
