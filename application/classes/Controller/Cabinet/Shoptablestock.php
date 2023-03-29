<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Cabinet_ShopTableStock extends Controller_Cabinet_File {

    public function __construct(Request $request, Response $response)
    {
        $this->dbObject = 'DB_Shop_Table_Stock';
        $this->controllerName = 'shoptablestock';
        $this->tableID = Model_Shop_Table_Stock::TABLE_ID;
        $this->tableName = Model_Shop_Table_Stock::TABLE_NAME;
        $this->objectName = 'table_stock';

        parent::__construct($request, $response);
        $this->_sitePageData->controllerName = $this->controllerName;
    }

    public function action_index() {
        $this->_sitePageData->url = '/cabinet/shoptablestock/index';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/_table/stock/list/index',
            )
        );

        $type = $this->_getType();
        $typeID = $type['id'];

        $tableID = intval(Request_RequestParams::getParamInt('table_id'));
        $this->_requestShopTableRubric($typeID);
        $this->_requestShopTableStock($typeID, $tableID);

        // получаем список
        View_View::find('DB_Shop_Table_Stock', $this->_sitePageData->shopID,
            "_shop/_table/stock/list/index", "_shop/_table/stock/one/index",
            $this->_sitePageData, $this->_driverDB, array('limit_page' => 25, 'type' => $typeID, 'table_id' => $tableID, 'is_list' => TRUE),
            array('root_id' => array('name'), 'shop_table_rubric_id' => array('name')));

        $this->_putInMain('/main/_shop/_table/stock/index');
    }

    public function action_sort() {
        $this->_sitePageData->url = '/cabinet/shoptablestock/sort';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/_table/stock/list/index',
            )
        );

        $type = $this->_getType();
        $typeID = $type['id'];

        $tableID = intval(Request_RequestParams::getParamInt('table_id'));
        $this->_requestShopTableRubric($typeID);
        $this->_requestShopTableStock($typeID, $tableID);

        // получаем список
        $this->_sitePageData->replaceDatas['view::_shop/_table/stock/list/index'] = View_View::find('DB_Shop_Table_Stock', $this->_sitePageData->shopID,
            "_shop/_table/stock/list/sort", "_shop/_table/stock/one/sort", $this->_sitePageData, $this->_driverDB,
                array_merge($_GET, $_POST, array('sort_by' => array('root_id' => 'desc', 'order' => 'asc', 'id' => 'desc'),
                    'limit_page' => 0, 'type' => $typeID, 'table_id' => $tableID, 'is_list' => TRUE, Request_RequestParams::IS_NOT_READ_REQUEST_NAME => FALSE)));

        $this->_putInMain('/main/_shop/_table/stock/index');
    }

    public function action_index_edit() {
        $this->_sitePageData->url = '/cabinet/shoptablestock/index_edit';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/_table/stock/list/index',
                'view::editfields/list',
            )
        );

        $type = $this->_getType();
        $typeID = $type['id'];

        $tableID = intval(Request_RequestParams::getParamInt('table_id'));
        $this->_requestShopTableRubric($typeID);
        $this->_requestShopTableStock($typeID, $tableID);

        $fields =
            '<option data-id="old_id" value="old_id">ID</option>'
            .'<option data-id="name" value="name">Название</option>'
            .'<option data-id="text" value="text">Описание</option>'
            .'<option data-id="options" value="options">Все заполненные атрибуты</option>';
        $options = Arr::path($type['fields_options'], 'shop_table_stock', array());
        foreach($options as $key => $value){
            $s = 'options.'.htmlspecialchars(Arr::path($value, 'field', Arr::path($value, 'name', '')), ENT_QUOTES);
            $fields = $fields .'<option data-id="'.$s.'" value="'.$s.'">'.$value['title'].'</option>';
        }
        $fields = $fields
            .'<option data-id="is_public" value="is_public">Опубликован</option>'
            .'<option data-id="root_id" value="root_id">Родитель</option>';
        $this->_sitePageData->replaceDatas['view::editfields/list'] = $fields;

        // получаем список
        $this->_sitePageData->replaceDatas['_shop/_table/stock/list/index'] = View_View::find('DB_Shop_Table_Stock', $this->_sitePageData->shopID,
            "_shop/_table/stock/list/index-edit", "_shop/_table/stock/one/index-edit", $this->_sitePageData, $this->_driverDB,
            array_merge(array('sort_by'=>array('name' => 'asc', 'id' => 'desc', 'limit_page' => 25)), $_GET, $_POST, array('type' => $typeID, 'table_id' => Request_RequestParams::getParamInt('table_id'), 'is_public_ignore' => TRUE, Request_RequestParams::IS_NOT_READ_REQUEST_NAME => FALSE)),
            array('shop_table_catalog_id', 'root_id'));

        $this->_putInMain('/main/_shop/_table/stock/index');
    }

    public function action_new() {
        $this->_sitePageData->url = '/cabinet/shoptablestock/new';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/_table/stock/one/new',
            )
        );

        $type = $this->_getType();
        $typeID = $type['id'];

        $tableID = intval(Request_RequestParams::getParamInt('table_id'));
        $this->_requestShopTableRubric($typeID);
        $this->_requestShopTableStock($typeID, $tableID);

        // получаем языки перевода
        $this->getLanguagesByShop(
            URL::query(
                array(
                    'type' => $typeID,
                    'table_id' => $tableID,
                ), FALSE
            ),
            FALSE
        );

        $dataID = new MyArray();
        $dataID->id = 0;
        // дополнительные поля
        Arr::set_path($dataID->values, Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_table_catalog_id', $type);
        $dataID->isFindDB = TRUE;

        $data = Helpers_View::getViewObject($dataID, new Model_Shop_Table_Stock(), '_shop/_table/stock/one/new',
            $this->_sitePageData, $this->_driverDB);
        $this->_sitePageData->replaceDatas['view::_shop/_table/stock/one/new'] = $data;

        $this->_putInMain('/main/_shop/_table/stock/new');
    }

    public function action_edit() {
        $this->_sitePageData->url = '/cabinet/shoptablestock/edit';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/_table/stock/one/edit',
            )
        );

        $id = Request_RequestParams::getParamInt('id');
        if ($id === NULL) {
            throw new HTTP_Exception_404('Table stock not is found!');
        }else {
            $model = new Model_Shop_Table_Stock();
            if (! $this->dublicateObjectLanguage($model, $id)) {
                throw new HTTP_Exception_404('Table stock not is found!');
            }
        }

        $type = $this->_getType($model->getShopTableCatalogID());
        $typeID = $type['id'];
        $tableID = $model->getTableID();

        $this->_requestShopTableRubric($typeID, $model->getShopTableRubricID());
        $this->_requestShopTableStock($typeID, $tableID, $model->getRootID());

        // получаем языки перевода
        $this->getLanguagesByShop(
            URL::query(
                array(
                    'id' => $id,
                    'type' => $typeID,
                    'table_id' => $tableID,
                ), FALSE
            ),
            FALSE
        );

        View_View::findOne('DB_Shop_Table_Stock', $this->_sitePageData->shopID, '_shop/_table/stock/one/edit',
            $this->_sitePageData, $this->_driverDB, array('id' => $id, Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE));

        $this->_putInMain('/main/_shop/_table/stock/edit');
    }

    public function action_save() {
        $this->_sitePageData->url = '/cabinet/shoptablestock/save';
        $result = Api_Shop_Table_Stock::save($this->_sitePageData, $this->_driverDB);
        $this->_redirectSaveResult($result);
    }

    /**
     * Делаем запрос на список
     * @param $typeID
     * @param $tableID
     * @param null $currentID
     */
    protected function _requestShopTableStock($typeID, $tableID, $currentID = NULL){
        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/_table/stock/list/list',
            )
        );

        $data = View_View::find('DB_Shop_Table_Stock', $this->_sitePageData->shopID,
            "_shop/_table/stock/list/list", "_shop/_table/stock/one/list", $this->_sitePageData, $this->_driverDB,
            array('type' => array(0, $typeID), 'table_id' => $tableID, 'sort_by' => array('value' => array('shop_table_rubric_id' => 'asc', 'name' => 'asc')),
                Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE), array('shop_table_rubric_id' => array('name')));

        if($currentID !== NULL){
            $s = 'data-id="'.$currentID.'"';
            $data = str_replace($s, $s.' selected', $data);
            $this->_sitePageData->replaceDatas['view::_shop/_table/stock/list/list'] = $data;
        }
    }
}
