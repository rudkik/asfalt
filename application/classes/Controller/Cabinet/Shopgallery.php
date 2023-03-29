<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Cabinet_ShopGallery extends Controller_Cabinet_BasicCabinet
{
    public function __construct(Request $request, Response $response)
    {
        $this->dbObject = 'DB_Shop_Gallery';
        $this->controllerName = 'shopgallery';
        $this->tableID = Model_Shop_Gallery::TABLE_ID;
        $this->tableName = Model_Shop_Gallery::TABLE_NAME;
        $this->objectName = 'gallery';

        parent::__construct($request, $response);
        $this->_sitePageData->controllerName = $this->controllerName;
    }

    public function action_index() {
        $this->_sitePageData->url = '/cabinet/shopgallery/index';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/gallery/list/index',
            )
        );

        // тип объекта
        $type = $this->_getType();
        // список объектов
        $this->_requestTableObjects($type);

        // получаем список
        View_View::find('DB_Shop_Gallery', $this->_sitePageData->shopID, "_shop/gallery/list/index", "_shop/gallery/one/index",
            $this->_sitePageData, $this->_driverDB, array('limit_page' => 25), array('shop_table_rubric_id'));

        $this->_putInMain('/main/_shop/gallery/index');
    }

    public function action_sort(){
        $this->_sitePageData->url = '/cabinet/shopgallery/sort';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/gallery/list/index',
            )
        );

        // тип объекта
        $type = $this->_getType();
        // список объектов
        $this->_requestTableObjects($type);

        // получаем список
        $this->_sitePageData->replaceDatas['view::_shop/gallery/list/index'] = View_View::find('DB_Shop_Gallery', $this->_sitePageData->shopID,
            "_shop/gallery/list/sort", "_shop/gallery/one/sort",
            $this->_sitePageData, $this->_driverDB,
            array_merge($_GET, $_POST, array('sort_by'=>array('order' => 'asc', 'id' => 'desc'), 'limit_page' => 0, 'type' => $type['id'], Request_RequestParams::IS_NOT_READ_REQUEST_NAME => FALSE)));

        $this->_putInMain('/main/_shop/gallery/index');
    }

    public function action_index_edit() {
        $this->_sitePageData->url = '/cabinet/shopgallery/index_edit';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/gallery/list/index',
                'view::editfields/list',
            )
        );

        // тип объекта
        $type = $this->_getType();
        // список объектов
        $this->_requestTableObjects($type);

        $fields =
            '<option data-id="old_id" value="old_id">ID</option>'
            .'<option data-id="name" value="name">Название</option>'
            .'<option data-id="info" value="info">Описание</option>'
            .'<option data-id="article" value="article">Артикул</option>'
            .'<option data-id="options" value="options">Все заполненные атрибуты</option>';

        $arr = Arr::path($type['fields_options'], 'shop_gallery', array());
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
        $this->_sitePageData->replaceDatas['view::_shop/gallery/list/index'] = View_View::find('DB_Shop_Gallery', $this->_sitePageData->shopID,
            "_shop/gallery/list/index-edit", "_shop/gallery/one/index-edit",
            $this->_sitePageData, $this->_driverDB,
            array_merge(array('sort_by'=>array('name' => 'asc', 'id' => 'desc', 'limit_page' => 25)), $_GET, $_POST, array('type' => $type['id'], 'is_public_ignore' => TRUE, Request_RequestParams::IS_NOT_READ_REQUEST_NAME => FALSE)),
            array('shop_table_catalog_id'));

        $this->_putInMain('/main/_shop/gallery/index');
    }

    public function action_new()
    {
        $this->_sitePageData->url = '/cabinet/shopgallery/new';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/gallery/one/new',
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

        $this->_sitePageData->replaceDatas['view::_shop/gallery/one/new'] = Helpers_View::getViewObject($dataID, new Model_Shop_Gallery(),
            '_shop/gallery/one/new', $this->_sitePageData, $this->_driverDB);

        $this->_putInMain('/main/_shop/gallery/new');
    }

    public function action_edit()
    {
        $this->_sitePageData->url = '/cabinet/shopgallery/edit';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/gallery/one/edit',
            )
        );

        // id записи
        $shopGalleryID = Request_RequestParams::getParamInt('id');
        if ($shopGalleryID === NULL) {
            throw new HTTP_Exception_404('Gallery not is found!');
        }else {
            $modelGallery = new Model_Shop_Gallery();
            if (! $this->dublicateObjectLanguage($modelGallery, $shopGalleryID)) {
                throw new HTTP_Exception_404('Gallery not is found!');
            }
        }

        // тип объекта
        $type = $this->_getType();

        $this->_requestTableObject($type, $modelGallery);

        // получаем языки перевода
        $this->getLanguagesByShop(
            URL::query(
                array(
                    'id' => $shopGalleryID,
                    'type' => $type['id'],
                    'is_group' => Request_RequestParams::getParamBoolean('is_group')
                ), FALSE
            ),
            FALSE
        );

        // получаем данные
        View_View::findOne('DB_Shop_Gallery', $this->_sitePageData->shopID, "_shop/gallery/one/edit",
            $this->_sitePageData, $this->_driverDB, array('id' => $shopGalleryID), array('shop_table_catalog_id'));

        $this->_putInMain('/main/_shop/gallery/edit');
    }

    public function action_save()
    {
        $this->_sitePageData->url = '/cabinet/shopgallery/save';
        $result = Api_Shop_Gallery::save($this->_sitePageData, $this->_driverDB);
        $this->_redirectSaveResult($result);
    }
}
