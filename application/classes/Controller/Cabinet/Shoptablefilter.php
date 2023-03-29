<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Cabinet_ShopTableFilter extends Controller_Cabinet_File {

    public function __construct(Request $request, Response $response)
    {
        $this->dbObject = 'DB_Shop_Table_Filter';
        $this->controllerName = 'shoptablefilter';
        $this->tableID = Model_Shop_Table_Filter::TABLE_ID;
        $this->tableName = Model_Shop_Table_Filter::TABLE_NAME;

        parent::__construct($request, $response);
        $this->_sitePageData->controllerName = $this->controllerName;
        $this->objectName = 'filter';
    }

    public function action_index() {
        $this->_sitePageData->url = '/cabinet/shoptablefilter/index';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/_table/filter/list/index',
                'view::_shop/_table/rubric/list/list',
            )
        );

        $typeID = intval(Request_RequestParams::getParamInt('type'));
        if ($typeID > 0) {
            $model = new Model_Shop_Table_Catalog();
            $model->setDBDriver($this->_driverDB);
            if(! $this->getDBObject($model,$typeID)){
                throw new HTTP_Exception_404('Table catalog not is found!');
            }
            $this->_sitePageData->replaceDatas['view::type'] = $model->getValues(TRUE, TRUE, $this->_sitePageData->shopMainID);
        }else{
            $this->_sitePageData->replaceDatas['view::type'] = array();
        }

        // получаем список
        View_View::find('DB_Shop_Table_Filter', $this->_sitePageData->shopID,
            "_shop/_table/filter/list/index", "_shop/_table/filter/one/index", $this->_sitePageData, $this->_driverDB,
            array('type' => $typeID, 'table_id' => Request_RequestParams::getParamInt('table_id'), 'limit_page' => 25), array('shop_table_rubric_id'));

        View_View::find('DB_Shop_Table_Rubric', $this->_sitePageData->shopID,
            "_shop/_table/rubric/list/list", "_shop/_table/rubric/one/list", $this->_sitePageData, $this->_driverDB,
            array('type' => array(0, $typeID), 'table_id' => Model_Shop_Table_Filter::TABLE_ID, Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE));

        $this->_putInMain('/main/_shop/_table/filter/index');
    }

    public function action_sort() {
        $this->_sitePageData->url = '/cabinet/shoptablefilter/sort';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/_table/filter/list/index',
                'view::_shop/_table/rubric/list/list',
            )
        );

        $typeID = intval(Request_RequestParams::getParamInt('type'));
        if ($typeID > 0) {
            $model = new Model_Shop_Table_Catalog();
            $model->setDBDriver($this->_driverDB);
            if(! $this->getDBObject($model,$typeID)){
                throw new HTTP_Exception_404('Table catalog not is found!');
            }
            $this->_sitePageData->replaceDatas['view::type'] = $model->getValues(TRUE, TRUE, $this->_sitePageData->shopMainID);
        }else{
            $this->_sitePageData->replaceDatas['view::type'] = array();
        }

        // получаем список
        $this->_sitePageData->replaceDatas['view::_shop/_table/filter/list/index'] = View_View::find('DB_Shop_Table_Filter', $this->_sitePageData->shopID,
            "_shop/_table/filter/list/sort", "_shop/_table/filter/one/sort", $this->_sitePageData, $this->_driverDB,
            array('type' => $typeID, 'table_id' => Request_RequestParams::getParamInt('table_id'), 'limit_page' => 25));

        View_View::find('DB_Shop_Table_Rubric', $this->_sitePageData->shopID,
            "_shop/_table/rubric/list/list", "_shop/_table/rubric/one/list",
            $this->_sitePageData, $this->_driverDB, array('type' => array(0, $typeID), 'table_id' => Model_Shop_Table_Filter::TABLE_ID, Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE));

        $this->_putInMain('/main/_shop/_table/filter/index');
    }

    public function action_index_edit() {
        $this->_sitePageData->url = '/cabinet/shoptablefilter/index_edit';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/_table/filter/list/index',
                'view::_shop/_table/rubric/list/list',
                'view::editfields/list',
            )
        );

        $typeID = intval(Request_RequestParams::getParamInt('type'));
        if ($typeID > 0) {
            $model = new Model_Shop_Table_Catalog();
            $model->setDBDriver($this->_driverDB);
            if(! $this->getDBObject($model,$typeID)){
                throw new HTTP_Exception_404('Table catalog not is found!');
            }
            $this->_sitePageData->replaceDatas['view::type'] = $model->getValues(TRUE, TRUE, $this->_sitePageData->shopMainID);
        }else{
            $this->_sitePageData->replaceDatas['view::type'] = array();
        }

        $fields =
            '<option data-id="old_id" value="old_id">ID</option>'
            .'<option data-id="name" value="name">Название</option>'
            .'<option data-id="text" value="text">Описание</option>'
            .'<option data-id="options" value="options">Все заполненные атрибуты</option>';
        $options = Arr::path($model->getFieldsOptionsArray(), 'shop_table_filter', array());
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
            array('type' => array(0, $typeID), 'table_id' => Model_Shop_Table_Filter::TABLE_ID, Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE));

        // получаем список
        $this->_sitePageData->replaceDatas['_shop/_table/filter/list/index'] = View_View::find('DB_Shop_Table_Filter', $this->_sitePageData->shopID,
            "_shop/_table/filter/list/index-edit", "_shop/_table/filter/one/index-edit", $this->_sitePageData, $this->_driverDB,
            array_merge(array('sort_by'=>array('name' => 'asc', 'id' => 'desc', 'limit_page' => 25)), $_GET, $_POST, array('type' => $typeID, 'table_id' => Request_RequestParams::getParamInt('table_id'), 'is_public_ignore' => TRUE, Request_RequestParams::IS_NOT_READ_REQUEST_NAME => FALSE)),
            array('shop_table_catalog_id', 'shop_table_rubric_id'));

        $this->_putInMain('/main/_shop/_table/filter/index');
    }

    public function action_new() {
        $this->_sitePageData->url = '/cabinet/shoptablefilter/new';

        $typeID = intval(Request_RequestParams::getParamInt('type'));
        if ($typeID > 0) {
            $model = new Model_Shop_Table_Catalog();
            $model->setDBDriver($this->_driverDB);
            if(! $this->getDBObject($model,$typeID)){
                throw new HTTP_Exception_404('ShopTableCatalog not is found!');
            }
            $this->_sitePageData->replaceDatas['view::type'] = $model->getValues(TRUE, TRUE, $this->_sitePageData->shopMainID);
        }else{
            $this->_sitePageData->replaceDatas['view::type'] = array();
        }

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/_table/filter/one/new',
                'view::_shop/_table/rubric/list/list',
            )
        );

        // получаем языки перевода
        $this->getLanguagesByShop(
            URL::query(
                array(
                    'type' => $typeID,
                ), FALSE
            ),
            FALSE
        );

        View_View::find('DB_Shop_Table_Rubric', $this->_sitePageData->shopID,
            "_shop/_table/rubric/list/list", "_shop/_table/rubric/one/list",
            $this->_sitePageData, $this->_driverDB, array('type' => array(0, $typeID), 'table_id' => Model_Shop_Table_Filter::TABLE_ID, Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE));

        $dataID = new MyArray();
        $dataID->id = 0;
        // дополнительные поля
        Arr::set_path($dataID->values, Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_table_catalog_id', $model->getValues(TRUE, TRUE, $this->_sitePageData));
        $dataID->isFindDB = TRUE;

        $model = new Model_Shop_Table_Filter();
        $datas = Helpers_View::getViewObject($dataID, $model,
            '_shop/_table/filter/one/new', $this->_sitePageData, $this->_driverDB);
        $this->_sitePageData->replaceDatas['view::_shop/_table/filter/one/new'] = $datas;

        $this->_putInMain('/main/_shop/_table/filter/new');
    }

    public function action_edit() {
        $this->_sitePageData->url = '/cabinet/shoptablefilter/edit';

        $typeID = intval(Request_RequestParams::getParamInt('type'));
        if ($typeID > 0) {
            $model = new Model_Shop_Table_Catalog();
            $model->setDBDriver($this->_driverDB);
            if(! $this->getDBObject($model,$typeID)){
                throw new HTTP_Exception_404('ShopTableCatalog not is found!');
            }
            $this->_sitePageData->replaceDatas['view::type'] = $model->getValues(TRUE, TRUE, $this->_sitePageData->shopMainID);
        }else{
            $this->_sitePageData->replaceDatas['view::type'] = array();
        }

        // id записи
        $id = Request_RequestParams::getParamInt('id');
        if ($id === NULL) {
            throw new HTTP_Exception_404('Table filter not is found!');
        }else {
            $model = new Model_Shop_Table_Filter();
            if (! $this->dublicateObjectLanguage($model, $id)) {
                throw new HTTP_Exception_404('Table filter not is found!');
            }
        }

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/_table/filter/one/edit',
                'view::_shop/_table/rubric/list/list',
            )
        );

        // получаем языки перевода
        $this->getLanguagesByShop(
            URL::query(
                array(
                    'id' => $id,
                    'type' => $typeID,
                ), FALSE
            ),
            FALSE
        );

        // получаем список ID рубрик
        $shopTableRubricIDs = View_View::find('DB_Shop_Table_Rubric', $this->_sitePageData->shopID,
            "_shop/_table/rubric/list/list", "_shop/_table/rubric/one/list",
            $this->_sitePageData, $this->_driverDB, array('type' => array(0, $typeID), 'table_id' => Model_Shop_Table_Filter::TABLE_ID, Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE));
        $s = 'value="' . $model->getShopTableRubricID() . '"';
        $shopTableRubricIDs = str_replace($s, $s . ' selected', $shopTableRubricIDs);
        $this->_sitePageData->replaceDatas['view::_shop/_table/rubric/list/list'] = $shopTableRubricIDs;

        // получаем данные
        View_View::findOne('DB_Shop_Table_Filter', $this->_sitePageData->shopID, "_shop/_table/filter/one/edit",
            $this->_sitePageData, $this->_driverDB, array('id' => $id), array('shop_table_catalog_id'));

        $this->_putInMain('/main/_shop/_table/filter/edit');
    }

    public function action_save() {
        $this->_sitePageData->url = '/cabinet/shoptablefilter/save';
        $result = Api_Shop_Table_Filter::save($this->_sitePageData, $this->_driverDB);
        $this->_redirectSaveResult($result);
    }   
}
