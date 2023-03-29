<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Cabinet_ShopMessageChat extends Controller_Cabinet_File
{

    public function action_index(){
        $this->_sitePageData->url = '/cabinet/shopmessagechat/index';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/message/chat/list/index',
            )
        );

        // тип объекта
        $type = $this->_getType();
        // список объектов
        $this->_requestTableObjects($type);

        // получаем список
        View_View::find('DB_Shop_Message_Chat', $this->_sitePageData->shopID, "_shop/message/chat/list/index", "_shop/message/chat/one/index",
            $this->_sitePageData, $this->_driverDB, array('limit_page' => 25), array(
                'shop_table_rubric_id' => array('name'), 'shop_table_select_id' => array('name'), 'shop_table_brand_id' => array('name'),
                'shop_table_unit_id' => array('name')));

        $this->_putInMain('/main/_shop/message/chat/index');
    }

    public function action_sort(){
        $this->_sitePageData->url = '/cabinet/shopmessagechat/sort';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/message/chat/list/index',
            )
        );

        // тип объекта
        $type = $this->_getType();
        // список объектов
        $this->_requestTableObjects($type);

        // получаем список
        $this->_sitePageData->replaceDatas['view::_shop/message/chat/list/index'] =
            View_View::find('DB_Shop_Message_Chat', $this->_sitePageData->shopID,
            "_shop/message/chat/list/sort", "_shop/message/chat/one/sort", $this->_sitePageData, $this->_driverDB,
            array_merge($_GET, $_POST, array('sort_by'=>array('order' => 'asc', 'id' => 'desc'), 'limit_page' => 0,
                'type' => $type['id'], Request_RequestParams::IS_NOT_READ_REQUEST_NAME => FALSE)));

        $this->_putInMain('/main/_shop/message/chat/index');
    }

    public function action_index_edit() {
        $this->_sitePageData->url = '/cabinet/shopmessagechat/index_edit';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/message/chat/list/index',
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

        $arr = Arr::path($type['fields_options'], 'shop_message_chat', array());
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
        $this->_sitePageData->replaceDatas['view::_shop/message/chat/list/index'] =
            View_View::find('DB_Shop_Message_Chat', $this->_sitePageData->shopID,
            "_shop/message/chat/list/index-edit", "_shop/message/chat/one/index-edit",
            $this->_sitePageData, $this->_driverDB,
            array_merge(array('sort_by'=>array('name' => 'asc', 'id' => 'desc', 'limit_page' => 25)), $_GET, $_POST, array('type' => $type['id'], 'is_public_ignore' => TRUE, Request_RequestParams::IS_NOT_READ_REQUEST_NAME => FALSE)),
            array('shop_table_catalog_id'));

        $this->_putInMain('/main/_shop/message/chat/index');
    }

    public function action_edit()
    {
        $this->_sitePageData->url = '/cabinet/shopmessagechat/edit';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/message/chat/one/edit',
                'view::_shop/message/list/index',
            )
        );

        // id записи
        $id = Request_RequestParams::getParamInt('id');
        if ($id === NULL) {
            throw new HTTP_Exception_404('Message chat not is found!');
        }else {
            $model = new Model_Shop_Message_Chat();
            if (! $this->dublicateObjectLanguage($model, $id)) {
                throw new HTTP_Exception_404('Message chat not is found!');
            }
        }

        // тип объекта
        $type = $this->_getType();

        $this->_requestTableObject($type, $model);
        $this->_requestShopTableStock($type, $model->getShopTableStockID());

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

        View_View::find('DB_Shop_Message', $this->_sitePageData->shopID, "_shop/message/list/index", "_shop/message/one/index",
            $this->_sitePageData, $this->_driverDB, array('limit_page' => 100, 'shop_message_chat_id' => $id), array(
                'shop_table_rubric_id' => array('name'), 'shop_table_select_id' => array('name'), 'shop_table_brand_id' => array('name'),
                'shop_table_unit_id' => array('name')));

        // получаем данные
        View_View::findOne('DB_Shop_Message_Chat', $this->_sitePageData->shopID, "_shop/message/chat/one/edit",
            $this->_sitePageData, $this->_driverDB, array('id' => $id,
                Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE), array('shop_table_catalog_id'));

        $this->_putInMain('/main/_shop/message/chat/edit');
    }

    public function action_add_message()
    {
        $this->_sitePageData->url = '/cabinet/shopmessagechat/add_message';
        $result = Api_Shop_Message_Chat::addMessage($this->_sitePageData, $this->_driverDB);
        $this->_redirectSaveResult($result);
    }
}
