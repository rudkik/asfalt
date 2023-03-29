<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Cabinet_ShopLoadData extends Controller_Cabinet_File {
    public function __construct(Request $request, Response $response)
    {
        $this->dbObject = 'DB_Shop_Load_Data';
        $this->controllerName = 'shoploaddata';
        $this->tableID = Model_Shop_Load_Data::TABLE_ID;
        $this->tableName = Model_Shop_Load_Data::TABLE_NAME;
        $this->objectName = 'loaddata';

        parent::__construct($request, $response);
        $this->_sitePageData->controllerName = $this->controllerName;
    }

    public function action_index(){
        $this->_sitePageData->url = '/cabinet/shoploaddata/index';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/load/data/list/index',
            )
        );

        // тип объекта
        $type = $this->_getType();

        // получаем список
        View_View::find('DB_Shop_Load_Data', $this->_sitePageData->shopID, "_shop/load/data/list/index", "_shop/load/data/one/index",
            $this->_sitePageData, $this->_driverDB, array('limit_page' => 25));

        $this->_putInMain('/main/_shop/load/data/index');
    }

    public function action_new(){
        $this->_sitePageData->url = '/cabinet/shoploaddata/new';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/load/data/one/new',
                'view::_shop/load/data/list/field-list',
            )
        );

        $tableID = Request_RequestParams::getParamInt('table_id');
        // тип объекта
        $type = $this->_getType();

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

        // список полей
        $this->_getFields($tableID, $type['id']);

        $dataID = new MyArray();
        $dataID->id = 0;
        $dataID->isFindDB = TRUE;

        $model = new Model_Shop_Load_Data();
        $this->_sitePageData->replaceDatas['view::_shop/load/data/one/new'] =  Helpers_View::getViewObject($dataID, $model,
            '_shop/load/data/one/new', $this->_sitePageData, $this->_driverDB);

        $this->_putInMain('/main/_shop/load/data/new');
    }

    public function action_edit()
    {
        $this->_sitePageData->url = '/cabinet/shoploaddata/edit';

        // id записи
        $id = Request_RequestParams::getParamInt('id');
        $model = new Model_Shop_Load_Data();
        if (! $this->dublicateObjectLanguage($model, $id, -1, FALSE)) {
            throw new HTTP_Exception_404('Load data not is found!');
        }

        // тип объекта
        $type = $this->_getType($model->getShopTableCatalogID());
        $tableID = $model->getTableID();

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/load/data/one/edit',
                'view::_shop/load/data/list/field-list',
            )
        );

        // получаем языки перевода
        $this->getLanguagesByShop(
            URL::query(
                array(
                    'id' => $id,
                ), FALSE
            ),
            FALSE
        );

        // список полей
        $this->_getFields($tableID, $type['id']);

        // получаем данные
        View_View::findOne('DB_Shop_Load_Data', $this->_sitePageData->shopID, "_shop/load/data/one/edit",
            $this->_sitePageData, $this->_driverDB, array('id' => $id));

        $this->_putInMain('/main/_shop/load/data/edit');
    }

    /**
     * Получение списка полей
     * @param $tableID
     * @param $typeID
     */
    private function _getFields($tableID, $typeID){
        $fields = '<option data-id="collations" value="collations">Сопоставление</option>';
        switch($tableID){
            case Model_Shop_Good::TABLE_ID:

                $fields = $fields
                    .'<option data-id="old_id" value="old_id">ID</option>'
                    .'<option data-id="name" value="name">Название</option>'
                    .'<option data-id="price" value="price">Цена</option>'
                    .'<option data-id="text" value="text">Описание</option>'
                    .'<option data-id="image_path" value="image_path">Картинка</option>'
                    .'<option data-id="article" value="article">Артикул</option>';

                $model = new Model_Shop_Table_Catalog();
                $model->setDBDriver($this->_driverDB);
                if($this->getDBObject($model, $typeID, $this->_sitePageData->shopMainID)){
                    switch ($tableID){
                        case Model_Shop_Good::TABLE_ID:
                            $options = Arr::path($model->getFieldsOptionsArray(), 'shop_good', array());
                            break;
                        default:
                            $options = array();
                    }

                    foreach($options as $key => $value){
                        $s = 'options.'.htmlspecialchars(Arr::path($value, 'field', Arr::path($value, 'name', '')), ENT_QUOTES);
                        $fields = $fields .'<option data-id="'.$s.'" value="'.$s.'">'.$value['title'].'</option>';
                    }
                }

                $fields = $fields
                    .'<option data-id="price_cost" value="price_cost">Себестоимость</option>'
                    .'<option data-id="price_old" value="price_old">Старая цена</option>'
                    .'<option data-id="is_public" value="is_public">Опубликован</option>'
                    .'<option data-id="shop_table_rubric_id" value="shop_table_rubric_id">Рубрика</option>'
                    .'<option data-id="shop_table_unit_type_id" value="shop_table_unit_type_id">Единица измерения</option>';

                break;
        }
        $this->_sitePageData->replaceDatas['view::_shop/load/data/list/field-list'] = $fields;
    }

    public function action_save()
    {
        $this->_sitePageData->url = '/cabinet/shoploaddata/save';
        set_time_limit(36000);

        $result = Api_Shop_Load_Data::save($this->_sitePageData, $this->_driverDB);
        if ($result['is_load_file']) {
            $this->_redirectSaveResult($result, 'data');
        }else{
            $this->_redirectSaveResult($result);
        }
    }

    public function action_data()
    {
        $this->_sitePageData->url = '/cabinet/shoploaddata/data';

        // id записи
        $id = Request_RequestParams::getParamInt('id');
        $model = new Model_Shop_Load_Data();
        if (! $this->dublicateObjectLanguage($model, $id, -1, FALSE)) {
            throw new HTTP_Exception_404('Load files not is found!');
        }

        $typeID = $model->getShopTableCatalogID();
        $tableID = $model->getTableID();
        $model->getElement('shop_table_catalog_id', TRUE, $this->_sitePageData->shopMainID);

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/load/data/one/data',
            )
        );

        // получаем языки перевода
        $this->getLanguagesByShop(
            URL::query(
                array(
                    'id' => $id,
                ), FALSE
            ),
            FALSE
        );

        // список полей
        $this->_getFields($tableID, $typeID);

        // получаем данные
        $dataID = new MyArray();
        $dataID->id = $model->id;
        $dataID->values = $model->getValues(TRUE, TRUE);
        $dataID->isFindDB = TRUE;

        $this->_sitePageData->replaceDatas['view::_shop/load/data/one/data'] = Helpers_View::getViewObject($dataID, $model,
            "_shop/load/data/one/data", $this->_sitePageData, $this->_driverDB, $this->_sitePageData->shopID);


        $this->_putInMain('/main/_shop/load/data/data');
    }

    /**
     * Сохранение список изменений
     */
    public function action_save_data() {
        $this->_sitePageData->url = '/cabinet/shoploaddata/save_data';

        set_time_limit(36000);

        $id = Request_RequestParams::getParamInt('id');
        $model = new Model_Shop_Load_Data();
        if (! $this->dublicateObjectLanguage($model, $id, -1, FALSE)) {
            throw new HTTP_Exception_404('Load data not is found!');
        }

        $typeID = $model->getShopTableCatalogID();
        $tableID = $model->getTableID();

        switch($tableID){
            case Model_Shop_Good::TABLE_ID:
                $model->setDataArray(Api_Shop_Good::saveListCollations($typeID, $model->getDataArray(),
                    $this->_sitePageData, $this->_driverDB));
                break;

        }

        $this->saveDBObject($model);

        $branchID = '';
        if($this->_sitePageData->branchID > 0){
            $branchID = '&shop_branch_id='.$this->_sitePageData->branchID;
        }
        $this->redirect('/cabinet/shoploaddata/data?id='.$model->id.$branchID);
    }

    /**
     * Сопоставление данных с БД
     * @throws HTTP_Exception_404
     */
    public function action_run_find()
    {
        $this->_sitePageData->url = '/cabinet/shoploaddata/runfind';

        set_time_limit(36000);

        $id = Request_RequestParams::getParamInt('id');
        $model = new Model_Shop_Load_Data();
        if (! $this->dublicateObjectLanguage($model, $id, -1, FALSE)) {
            throw new HTTP_Exception_404('Load data not is found!');
        }

        $typeID = $model->getShopTableCatalogID();
        $tableID = $model->getTableID();

        $model->setDataArray(Api_Shop_Load_Data::findCollations($model->getDataArray(), $typeID, $tableID, $this->_sitePageData, $this->_driverDB));
        $this->saveDBObject($model);

        $branchID = '';
        if($this->_sitePageData->branchID > 0){
            $branchID = '&shop_branch_id='.$this->_sitePageData->branchID;
        }
        $this->redirect('/cabinet/shoploaddata/data?id='.$model->id.$branchID);
    }


}