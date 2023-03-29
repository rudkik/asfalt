<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Cabinet_ShopClient extends Controller_Cabinet_BasicCabinet
{
    public function __construct(Request $request, Response $response)
    {
        $this->dbObject = 'DB_Shop_Client';
        $this->controllerName = 'shopclient';
        $this->tableID = Model_Shop_Client::TABLE_ID;
        $this->tableName = Model_Shop_Client::TABLE_NAME;
        $this->objectName = 'client';

        parent::__construct($request, $response);
        $this->_sitePageData->controllerName = $this->controllerName;
    }

    public function action_index() {
        $this->_sitePageData->url = '/cabinet/shopclient/index';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/client/list/index',
            )
        );

        // тип объекта
        $type = $this->_getType();
        // список объектов
        $this->_requestTableObjects($type);

        // получаем список
        View_View::find('DB_Shop_Client', $this->_sitePageData->shopMainID, "_shop/client/list/index", "_shop/client/one/index",
            $this->_sitePageData, $this->_driverDB, array('limit_page' => 25));

        $this->_putInMain('/main/_shop/client/index');
    }

    public function action_index_edit() {
        $this->_sitePageData->url = '/cabinet/shopclient/index_edit';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/client/list/index',
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
            .'<option data-id="price" value="price">Цена</option>'
            .'<option data-id="text" value="info">Описание</option>'
            .'<option data-id="article" value="article">Артикул</option>'
            .'<option data-id="options" value="options">Все заполненные атрибуты</option>';

        $arr = Arr::path($type['fields_options'], 'shop_client', array());
        foreach($arr as $key => $value){
            $s = 'options.'.htmlspecialchars(Arr::path($value, 'field', Arr::path($value, 'name', '')), ENT_QUOTES);
            $fields = $fields .'<option data-id="'.$s.'" value="'.$s.'">'.$value['title'].'</option>';
        }
        $fields = $fields
            .'<option data-id="price_old" value="price_old">Старая цена</option>'
            .'<option data-id="is_public" value="is_public">Опубликован</option>'
            .'<option data-id="shop_table_rubric_id" value="shop_table_rubric_id">Рубрика</option>'
            .'<option data-id="shop_table_brand_id" value="shop_table_brand_id">Бренд</option>'
            .'<option data-id="shop_table_unit_id" value="shop_table_unit_id">Единица измерения</option>'
            .'<option data-id="shop_table_select_id" value="shop_table_select_id">Вид выделения</option>';
        $this->_sitePageData->replaceDatas['view::editfields/list'] = $fields;

        // получаем список
        $this->_sitePageData->replaceDatas['view::_shop/client/list/index'] = View_View::find('DB_Shop_Client', $this->_sitePageData->shopMainID,
            "_shop/client/list/index-edit", "_shop/client/one/index-edit",
            $this->_sitePageData, $this->_driverDB,
            array_merge(array('sort_by'=>array('name' => 'asc', 'id' => 'desc', 'limit_page' => 25)), $_GET, $_POST, array('type' => $type['id'], 'is_public_ignore' => TRUE, Request_RequestParams::IS_NOT_READ_REQUEST_NAME => FALSE)),
            array('shop_table_catalog_id'));

        $this->_putInMain('/main/_shop/client/index');
    }

    public function action_new()
    {
        $this->_sitePageData->url = '/cabinet/shopclient/new';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/client/one/new',
            )
        );

        // тип объекта
        $type = $this->_getType();

        $this->_requestTableObjects($type);

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

        $this->_sitePageData->replaceDatas['view::_shop/client/one/new'] = Helpers_View::getViewObject($dataID, new Model_Shop_Client(),
            '_shop/client/one/new', $this->_sitePageData, $this->_driverDB);

        $this->_putInMain('/main/_shop/client/new');
    }

    public function action_edit()
    {
        $this->_sitePageData->url = '/cabinet/shopclient/edit';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/client/one/edit',
            )
        );

        // id записи
        $shopClientID = Request_RequestParams::getParamInt('id');
        if ($shopClientID === NULL) {
            throw new HTTP_Exception_404('Clients not is found!');
        }else {
            $modelClient = new Model_Shop_Client();
            if (! $this->dublicateObjectLanguage($modelClient, $shopClientID)) {
                throw new HTTP_Exception_404('Clients not is found!');
            }
        }

        // тип объекта
        $type = $this->_getType();

        $this->_requestTableObjects($type, $modelClient);

        // получаем языки перевода
        $this->getLanguagesByShop(
            URL::query(
                array(
                    'id' => $shopClientID,
                    'type' => $type['id'],
                ), FALSE
            ),
            FALSE
        );

        // получаем данные
        View_View::findOne('DB_Shop_Client', $this->_sitePageData->shopID, "_shop/client/one/edit",
            $this->_sitePageData, $this->_driverDB, array('id' => $shopClientID), array('shop_table_catalog_id'));

        $this->_putInMain('/main/_shop/client/edit');
    }

    public function action_save()
    {
        $this->_sitePageData->url = '/cabinet/shopclient/save';
        $result = Api_Shop_Client::save($this->_sitePageData, $this->_driverDB);
        $this->_redirectSaveResult($result);
    }

    /**
     * Удаление
     */
    public function action_del() {
        $this->_sitePageData->url = '/cabinet/shopclient/del';

        Api_Shop_Client::delete($this->_sitePageData, $this->_driverDB);
        $this->response->body(Json::json_encode(array('error' => FALSE)));
    }
}
