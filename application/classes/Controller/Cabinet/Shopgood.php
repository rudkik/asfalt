<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Cabinet_ShopGood extends Controller_Cabinet_File {

    public function __construct(Request $request, Response $response)
    {
        $this->dbObject = 'DB_Shop_Good';
        $this->controllerName = 'shopgood';
        $this->tableID = Model_Shop_Good::TABLE_ID;
        $this->tableName = Model_Shop_Good::TABLE_NAME;
        $this->objectName = 'good';

        parent::__construct($request, $response);
        $this->_sitePageData->controllerName = $this->controllerName;
    }

    public function action_index() {
        $this->_sitePageData->url = '/cabinet/shopgood/index';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/good/list/index',
            )
        );

        // тип объекта
        $type = $this->_getType();
        // список объектов
        $this->_requestTableObjects($type);
        $this->_requestShopTableStock($type);
        $this->_requestTranslateTr();
        $this->_requestTranslateDataLanguages();

        // получаем список
        View_View::find('DB_Shop_Good',
            $this->_sitePageData->shopID,
            "_shop/good/list/index", "_shop/good/one/index",
            $this->_sitePageData, $this->_driverDB, array('limit_page' => 25),
            array(
                'shop_table_stock_rubric_id' => array('name'),
                'shop_table_stock_id' => array('name'),
                'shop_table_rubric_id' => array('name'),
                'shop_table_select_id' => array('name'),
                'shop_table_brand_id' => array('name'),
                'shop_table_unit_id' => array('name'),
            )
        );

        $this->_putInMain('/main/_shop/good/index');
    }

    public function action_sort(){
        $this->_sitePageData->url = '/cabinet/shopgood/sort';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/good/list/index',
            )
        );

        // тип объекта
        $type = $this->_getType();
        // список объектов
        $this->_requestTableObjects($type);
        $this->_requestShopTableStock($type);
        $this->_requestTranslateDataLanguages();

        // получаем список
        $this->_sitePageData->replaceDatas['view::_shop/good/list/index'] = View_View::find('DB_Shop_Good', $this->_sitePageData->shopID,
            "_shop/good/list/sort", "_shop/good/one/sort",
            $this->_sitePageData, $this->_driverDB,
            array_merge($_GET, $_POST, array('sort_by'=>array('order' => 'asc', 'id' => 'desc'), 'limit_page' => 0,
                'type' => $type['id'], Request_RequestParams::IS_NOT_READ_REQUEST_NAME => FALSE)));

        $this->_putInMain('/main/_shop/good/index');
    }

    public function action_index_edit() {
        $this->_sitePageData->url = '/cabinet/shopgood/index_edit';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/good/list/index',
                'view::editfields/list',
            )
        );

        // тип объекта
        $type = $this->_getType();
        // список объектов
        $this->_requestTableObjects($type);
        $this->_requestShopTableStock($type);
        $this->_requestTranslateDataLanguages();

        $fields =
            '<option data-id="old_id" value="old_id">ID</option>'
            .'<option data-id="name" value="name">Название</option>'
            .'<option data-id="price" value="price">Цена</option>'
            .'<option data-id="text" value="info">Описание</option>'
            .'<option data-id="article" value="article">Артикул</option>'
            .'<option data-id="options" value="options">Все заполненные атрибуты</option>';

        $arr = Arr::path($type, 'fields_options.shop_good', array());
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
        $this->_sitePageData->replaceDatas['view::_shop/good/list/index'] = View_View::find('DB_Shop_Good', $this->_sitePageData->shopID,
            "_shop/good/list/index-edit", "_shop/good/one/index-edit",
            $this->_sitePageData, $this->_driverDB,
            array_merge(array('sort_by'=>array('name' => 'asc', 'id' => 'desc', 'limit_page' => 25)), $_GET, $_POST, array('type' => $type['id'], 'is_public_ignore' => TRUE, Request_RequestParams::IS_NOT_READ_REQUEST_NAME => FALSE)),
            array('shop_table_catalog_id'));

        $this->_putInMain('/main/_shop/good/index');
    }

    public function action_index_stock() {
        $this->_sitePageData->url = '/cabinet/shopgood/index_stock';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/good/list/index',
            )
        );

        // тип объекта
        $type = $this->_getType();
        // список объектов
        $this->_requestTableObjects($type);
        $this->_requestShopTableStock($type);
        $this->_requestTranslateDataLanguages();

        // получаем список
        $this->_sitePageData->replaceDatas['view::_shop/good/list/index'] = View_View::find('DB_Shop_Good', $this->_sitePageData->shopID,
            "_shop/good/list/index-stock", "_shop/good/one/index-stock",
            $this->_sitePageData, $this->_driverDB, array('limit_page' => 25, 'work_type_id' => Model_WorkType::WORK_TYPE_NOT_WORK),
            array('shop_table_stock_id' => array('name'), 'shop_table_rubric_id' => array('name'), 'shop_table_select_id' => array('name'), 'shop_table_brand_id' => array('name'),
                'shop_table_unit_id' => array('name'), 'shop_table_stock_rubric_id' => array('name')));

        $this->_putInMain('/main/_shop/good/index');
    }

    public function action_new()
    {
        $this->_sitePageData->url = '/cabinet/shopgood/new';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/good/one/new',
            )
        );

        // тип объекта
        $type = $this->_getType();
        $this->_requestTableObject($type);
        $this->_requestShopTableStock($type);

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

        $this->_sitePageData->replaceDatas['view::_shop/good/one/new'] = Helpers_View::getViewObject($dataID, new Model_Shop_Good(),
            '_shop/good/one/new', $this->_sitePageData, $this->_driverDB);

        $this->_putInMain('/main/_shop/good/new');
    }

    public function action_edit()
    {
        $this->_sitePageData->url = '/cabinet/shopgood/edit';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/good/one/edit',
            )
        );

        // id записи
        $shopGoodID = Request_RequestParams::getParamInt('id');
        $modelGood = new Model_Shop_Good();
        if (! $this->dublicateObjectLanguage($modelGood, $shopGoodID, -1, FALSE, Request_RequestParams::getParamInt('version'))) {
            throw new HTTP_Exception_404('Goods not is found!');
        }

        // тип объекта
        $type = $this->_getType($modelGood->getShopTableCatalogID());

        $this->_requestTableObject($type, $modelGood);
        $this->_requestShopTableStock($type, $modelGood->getShopTableStockID());

        // получаем языки перевода
        $this->getLanguagesByShop(
            URL::query(
                array(
                    'id' => $shopGoodID,
                    'type' => $type['id'],
                    'is_group' => Request_RequestParams::getParamBoolean('is_group'),
                    'version' => Request_RequestParams::getParamInt('version'),
                ), FALSE
            ),
            FALSE
        );

        $dataID = new MyArray();
        $dataID->setValues($modelGood, $this->_sitePageData, array());
        // дополнительные поля
        Arr::set_path($dataID->values, Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_table_catalog_id', $type);

        $this->_sitePageData->replaceDatas['view::_shop/good/one/edit'] = Helpers_View::getViewObject($dataID, new Model_Shop_Good(),
            '_shop/good/one/edit', $this->_sitePageData, $this->_driverDB);

        $this->_putInMain('/main/_shop/good/edit');
    }

    public function action_edit_work()
    {
        $this->_sitePageData->url = '/cabinet/shopgood/edit_work';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/good/one/edit-work',
            )
        );

        // id записи
        $shopGoodID = Request_RequestParams::getParamInt('id');
        $modelGood = new Model_Shop_Good();
        if (! $this->dublicateObjectLanguage($modelGood, $shopGoodID, -1, FALSE)) {
            throw new HTTP_Exception_404('Goods not is found!');
        }

        // тип объекта
        $type = $this->_getType();

        $this->_requestTableObject($type, $modelGood);
        $this->_requestShopTableStock($type, $modelGood->getShopTableStockID());

        // получаем языки перевода
        $this->getLanguagesByShop(
            URL::query(
                array(
                    'id' => $shopGoodID,
                    'type' => $type['id'],
                    'is_group' => Request_RequestParams::getParamBoolean('is_group')
                ), FALSE
            ),
            FALSE
        );

        // получаем данные
        View_View::findOne('DB_Shop_Good', $this->_sitePageData->shopID, "_shop/good/one/edit-work",
            $this->_sitePageData, $this->_driverDB, array('id' => $shopGoodID,
                Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE), array('shop_table_catalog_id'));

        $this->_putInMain('/main/_shop/good/edit-work');
    }

    public function action_save()
    {
        $this->_sitePageData->url = '/cabinet/shopgood/save';
        $result = Api_Shop_Good::save($this->_sitePageData, $this->_driverDB);
        $this->_redirectSaveResult($result);
    }

    public function action_save_xls()
    {
        $this->_sitePageData->url = '/cabinet/shopgood/save_xls';
        Api_Shop_Good::saveXLS($this->_sitePageData, $this->_driverDB);
        exit();
    }

    public function action_save_work()
    {
        $this->_sitePageData->url = '/cabinet/shopgood/save_work';
        $_GET ['work_type_id'] = Model_WorkType::WORK_TYPE_FINISH;
        $result = Api_Shop_Good::save($this->_sitePageData, $this->_driverDB);

        $ids = Request_Request::find('DB_Shop_Good',$this->_sitePageData->shopID, $this->_sitePageData,
            $this->_driverDB, array('work_type_id' => Model_WorkType::WORK_TYPE_NOT_WORK, 'type' => $result['type'],
                Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE), 1);
        if(count($ids->childs) > 0){
            $this->redirect('/cabinet/shopgood/edit_work?id='.$ids->childs[0]->id.'&type='.$result['type']);
        }else {
            $this->_redirectSaveResult($result);
        }
    }

    public function action_del() {
        $this->_sitePageData->url = '/cabinet/shopgood/del';

        Api_Shop_Good::delete($this->_sitePageData, $this->_driverDB);
        $this->response->body(Json::json_encode(array('error' => FALSE)));
    }

    public function action_findpromo() {
        $this->_sitePageData->url = '/cabinet/shopgood/findpromo';

        if($this->_sitePageData->branchID > 0) {
            $shopID = $this->_sitePageData->branchID;
        }else{
            $shopID = $this->_sitePageData->shopID;
        }

        // получаем список
        $shopGoodIDs = View_View::find('DB_Shop_Good', $shopID,
            "_shop/good/list/promo-popup", "_shop/good/one/promo-popup",
            $this->_sitePageData, $this->_driverDB, array('limit' => 0));

        $this->response->body($shopGoodIDs);
    }

    public function action_promo() {
        $this->_sitePageData->url = '/cabinet/shopgood/promo';

        if($this->_sitePageData->branchID > 0) {
            $shopID = $this->_sitePageData->branchID;
        }else{
            $shopID = $this->_sitePageData->shopID;
        }

        // получаем список
        $shopGood = View_View::findOne('DB_Shop_Good', $shopID, "_shop/good/one/promo", $this->_sitePageData, $this->_driverDB,
            array('id' => Request_RequestParams::getParamInt('id')));

        $this->response->body(str_replace('value=""', 'value="'.(intval(Request_RequestParams::getParamInt('count'))).'"', $shopGood));
    }

    public function action_findpromogift() {
        $this->_sitePageData->url = '/cabinet/shopgood/findpromogift';

        // получаем список
        $shopGoodIDs = View_View::find('DB_Shop_Good', $this->_sitePageData->shopID,
            "_shop/good/list/promo-popup-gift", "_shop/good/one/promo-popup-gift",
            $this->_sitePageData, $this->_driverDB, array('limit' => 0));

        $this->response->body($shopGoodIDs);
    }

    public function action_promogift() {
        $this->_sitePageData->url = '/cabinet/shopgood/promogift';

        // получаем список
        $shopGood = View_View::findOne('DB_Shop_Good', $this->_sitePageData->shopID,
            "_shop/good/one/promo-gift", $this->_sitePageData, $this->_driverDB,
            array('id' => Request_RequestParams::getParamInt('id')));

        $this->response->body(str_replace('value=""', 'value="'.(intval(Request_RequestParams::getParamInt('count'))).'"', $shopGood));
    }










    /**
     * Загружаем данные о товаре с других сайтов через штрихкод
     */
    public function action_load_site_by_barcode()
    {
        set_time_limit(3600000);
        ignore_user_abort(TRUE);
        ini_set('max_execution_time', 360000);

        $this->_sitePageData->url = '/cabinet/shopgood/load_site_by_barcode';

        Drivers_ParserSite_Opto::loadSiteByBarcode($this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB);
    }

    /**
     * Парсим загруженные данные с сайтов загруженных через функцию
     * load_site_by_barcode
     */
    public function action_parser_data_site(){
        set_time_limit(3600000);
        ignore_user_abort(TRUE);
        ini_set('max_execution_time', 360000);

        $this->_sitePageData->url = '/cabinet/shopgood/parser_data_site';

        Drivers_ParserSite_Opto::parserLoadData();
    }

    /**
     * Сохраняем загруженные данные с сайтов загруженных через функцию
     * parser_data_site
     */
    public function action_save_data_site(){
        set_time_limit(3600000);
        ignore_user_abort(TRUE);
        ini_set('max_execution_time', 360000);

        $this->_sitePageData->url = '/cabinet/shopgood/save_data_site';

        Drivers_ParserSite_ShopGood::saveLoadData($this->_sitePageData, $this->_driverDB);
    }

    /**
     * Загружаем данные из другого сайта
     * Параметры:
     * url - откуда загружать файл, где __shop_branch_id__ будет заменяться на ID магазина
     * auth[email] - данные для авторизации логин
     * auth[password] - данные для авторизации пароль
     * request_params - array параметры для получения списка из БД
     * add_params - array параметры добавляемые к записи при создании
     * @throws HTTP_Exception_500
     */
    public function action_load_xml_in_url() {
        set_time_limit(36000);
        $this->_sitePageData->url = '/cabinet/shopgood/load_xml_in_url';

        $url = Request_RequestParams::getParamStr('url');
        if(empty($url)){
            throw new HTTP_Exception_500('URL empty.');
        }

        $data = array (
            'auth' => array(
                'email' => Request_RequestParams::getParamStr('email'),
                'password' => Request_RequestParams::getParamStr('password'),
            )
        );
        $data = http_build_query($data);

        $context_options = array (
            'http' => array (
                'method' => 'POST',
                'header'=> "Content-type: application/x-www-form-urlencoded\r\n"
                    . "Content-Length: " . strlen($data) . "\r\n",
                'content' => $data
            )
        );
        $context = stream_context_create($context_options);

        // параметры запроса в базу данных
        $params = Request_RequestParams::getParamArray('request_params', array(), array());
        $params = array_merge($params, array('is_public_ignore' => TRUE, 'is_delete_ignore' => TRUE, Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE));

        // параметры для добавления нового филиала
        $addParams = Request_RequestParams::getParamArray('add_params', array(), array());

        // парсинг для полей, названия которых не соответствует
        $parser = Request_RequestParams::getParamArray('parser', array(), array());

        // получение списка филиалов
        $shopBranchs = Request_Shop::findShopBranchIDs($this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB,
            array('is_public_ignore' => TRUE, Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE), 0, TRUE);
        // добавляем id основного магазина
        $shopBranchs->addChild($this->_sitePageData->shopID)->values = $this->_sitePageData->shop->getValues(TRUE, TRUE);

        $model = new Model_Shop_Good();
        foreach($shopBranchs->childs as $index => $shopBranch){

            $xml = file_get_contents(str_replace('__shop_branch_id__', $shopBranch->values['old_id'], $url), NULL, $context);
            if($xml === FALSE) {
                throw new HTTP_Exception_500('Load URL error.');
            }

            $xml = simplexml_load_string($xml);
            $json = json_encode($xml);
            $array = json_decode($json,TRUE);
            $records = Arr::path($array, 'record', array());

            // получение списка товаров
            $shopGoods = Request_Request::find('DB_Shop_Good',$shopBranch->id, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE);

            foreach($records as $record){
                $id = intval(Arr::path($record, 'id', 0));
                if($id < 1){
                    continue;
                }

                // проверяем если ли уже данная запись
                $isNew = TRUE;
                foreach($shopGoods->childs as $index => $shopGood){
                    if($shopGood->values['old_id'] == $id){

                        if(intval(Arr::path($record, 'is_delete', 0)) === 1){
                            $model->clear();
                            $model->id = $shopGood->id;
                            $model->globalID = $shopGood->values['global_id'];
                            $this->deleteDBObject($model, 0, $shopBranch->id);
                        }else {
                            $model->clear();
                            $model->id = $shopGood->id;
                            $model->globalID = $shopGood->values['global_id'];
                            if (intval(Arr::path($record, 'is_public', 1)) === 0) {
                                $model->setIsPublic(FALSE);
                            }
                            $price = Arr::path($parser, 'price', '');
                            if(empty($price)){
                                $model->setPrice(floatval(Arr::path($record, 'price', 0)));
                            }else{
                                $model->setPrice(floatval(Arr::path($record, $price, 0)));
                            }

                            //$model->setName(Arr::path($record, 'name', ''));
                            /*$tmp =  Arr::path($record, 'files', '');
                            if(is_array($tmp)) {
                                $model->setFilesArray($tmp);
                            }*/

                            $model->setIsDelete(FALSE);
                            $this->saveDBObject($model, $shopBranch->id);
                        }

                        unset($shopGoods->childs[$index]);
                        $isNew = FALSE;
                        continue;
                    }
                }
                if($isNew === FALSE){
                    continue;
                }

                // загружаем данные из xml
                $model->clear();
                foreach($record as $name => $value){
                    switch($name) {
                        case 'is_public': $model->setIsPublic($value); break;
                        case 'article': $model->setArticle($value); break;
                        case 'shop_table_rubric_id': $model->setShopTableRubricID($value); break;
                        case 'name': $model->setName($value); break;
                        case 'image_path': $model->setImagePath($value); break;
                        case 'text': $model->setText($value); break;
                        case 'order': $model->setOrder($value); break;
                        case 'options':
                            if(is_array($value)) {
                                $model->setOptionsArray($value);
                            }
                            break;
                        case 'shop_table_unit_type_id': $model->setShopTableUnitTypeID($value); break;
                        case 'storage_count': $model->setStorageCount($value); break;
                        case 'id': $model->setOldID($value); break;
                        case 'files':
                            if(is_array($value)) {
                                $model->setFilesArray($value);
                            }
                            break;
                    }
                }

                foreach($parser as $name => $value){
                    switch($name) {
                        case 'is_public': $model->setIsPublic(Arr::path($record, $value, 1)); break;
                        case 'article': $model->setArticle(Arr::path($record, $value, '')); break;
                        case 'shop_table_rubric_id': $model->setShopTableRubricID($value); break;
                        case 'name': $model->setName(Arr::path($record, $value, '')); break;
                        case 'image_path': $model->setImagePath(Arr::path($record, $value, '')); break;
                        case 'text': $model->setText(Arr::path($record, $value, '')); break;
                        case 'order': $model->setOrder(Arr::path($record, $value, '')); break;
                        case 'options':
                            $s = Arr::path($record, $value, array());
                            if(is_array($s)) {
                                $model->setOptionsArray($s);
                            }
                            break;
                        case 'shop_table_unit_type_id': $model->setShopTableUnitTypeID(intval(Arr::path($record, $value, ''))); break;
                        case 'storage_count': $model->setStorageCount(floatval(Arr::path($record, $value, ''))); break;
                        case 'id': $model->setOldID($value); break;
                        case 'files':
                            if(is_array($value)) {
                                $model->setFilesArray($value);
                            }
                            break;
                    }
                }

                // загружаем данные по умолчанию, которые надо задать
                foreach($addParams as $name => $value){
                    switch($name) {
                        case 'is_public': $model->setIsPublic($value); break;
                        case 'article': $model->setArticle($value); break;
                        case 'shop_table_rubric_id': $model->setShopTableRubricID($value); break;
                        case 'name': $model->setName($value); break;
                        case 'image_path': $model->setImagePath($value); break;
                        case 'text': $model->setText($value); break;
                        case 'order': $model->setOrder($value); break;
                        case 'options':
                            if(is_array($value)) {
                                $model->setOptionsArray($value);
                            }
                            break;
                        case 'shop_table_unit_type_id': $model->setShopTableUnitTypeID($value); break;
                        case 'shop_table_catalog_id': $model->setShopTableCatalogID($value); break;
                        case 'storage_count': $model->setStorageCount($value); break;
                        case 'id': $model->setOldID($value); break;
                        case 'files':  break;
                    }
                }
                $model->shopID = $shopBranch->id;
                $this->saveDBObject($model, $shopBranch->id);
            }

            // удаляем магазины, которые не были найдены
            foreach($shopGoods->childs as $index => $shopGood){
                $model->clear();
                $model->id = $shopGood->id;
                $model->globalID = $shopGood->values['global_id'];
                $this->deleteDBObject($model, 0, $shopBranch->id);
            }
        }

        $this->response->body('Finished');
    }

    /**
     * Делаем запрос на список хранилищь
     * @param array $type
     * @return string
     */
    protected function _requestShopTableStock(array $type, $currentID = NULL){
        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/_table/stock/list/list',
            )
        );

        $typeID = intval(Arr::path($type, 'child_shop_table_catalog_ids.stock.id',
                Arr::path($type, 'child_shop_table_catalog_ids.'.$this->_sitePageData->dataLanguageID.'.stock.id', 0)));
        if($typeID < 1){
            return '';
        }

        $data = View_View::find('DB_Shop_Table_Stock', $this->_sitePageData->shopID,
            "_shop/_table/stock/list/list", "_shop/_table/stock/one/list", $this->_sitePageData, $this->_driverDB,
            array('type' => array($typeID), 'table_id' => $this->tableID, Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE));

        if($currentID !== NULL){
            $s = 'data-id="'.$currentID.'"';
            $data = str_replace($s, $s.' selected', $data);
            $this->_sitePageData->replaceDatas['view::_shop/_table/stock/list/list'] = $data;
        }

        return $data;
    }

    /**
     * Перестроить товары
     * @param MyArray $ids
     * @param Model_Shop_Good $model
     */
    private function _rebuildGood(MyArray $ids, Model_Shop_Good $model){
        foreach ($ids->childs as $child){
            $model->clear();
            $model->__setArray(array('values' => $child->values));
            $model->setNameURL(Helpers_URL::getNameURL($model));
            Helpers_DB::saveDBObject($model, $this->_sitePageData);
        }
    }

    public function action_rebuild_goods() {
        $this->_sitePageData->url = '/cabinet/shopgood/rebuild_goods';

        $this->_sitePageData->dataLanguageID = 35;
        $this->_sitePageData->languageID = 35;
        // получаем список
        $ids = Request_Request::find('DB_Shop_Good',$this->_sitePageData->shopID,
            $this->_sitePageData, $this->_driverDB, array('limit_page' => 5000), 0,
            TRUE, array());

        $model = new Model_Shop_Good();
        $model->setDBDriver($this->_driverDB);
        $this->_rebuildGood($ids, $model);

        $this->_sitePageData->dataLanguageID = 36;
        $this->_sitePageData->languageID = 36;
        // получаем список
        $ids = Request_Request::find('DB_Shop_Good',$this->_sitePageData->shopID,
            $this->_sitePageData, $this->_driverDB, array('limit_page' => 50000), 0,
            TRUE, array());

        $model = new Model_Shop_Good();
        $model->setDBDriver($this->_driverDB);
        $this->_rebuildGood($ids, $model);
    }

    public function action_modal_parse_site_by_article() {
        $this->_sitePageData->url = '/cabinet/shopgood/modal_parse_site_by_article';

        $params = Request_RequestParams::setParams(
            array_merge($_POST, $_GET, array('limit_page' => 0,))
        );
        $ids = Request_Request::find('DB_Shop_Good',$this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB,
            $params, 5000);
        $ids = $ids->getChildArrayID();

        $dataID = new MyArray();
        $dataID->id = 0;
        $dataID->isFindDB = TRUE;
        $dataID->isLoadElements = TRUE;
        $dataID->isParseData = FALSE;
        $dataID->values['ids'] = $ids;

        $data = Helpers_View::getViewObject($dataID, new Model_Shop_Good(), '_shop/good/modal/parse-site/by-article',
            $this->_sitePageData, $this->_driverDB);

        $this->response->body($data);
    }

    public function action_modal_parse_site_by_url() {
        $this->_sitePageData->url = '/cabinet/shopgood/modal_parse_site_by_url';

        $dataID = new MyArray();
        $dataID->id = 0;
        $dataID->isFindDB = TRUE;
        $dataID->isLoadElements = TRUE;
        $dataID->isParseData = FALSE;

        $data = Helpers_View::getViewObject($dataID, new Model_Shop_Good(), '_shop/good/modal/parse-site/by-url',
            $this->_sitePageData, $this->_driverDB);

        $this->response->body($data);
    }

    public function action_parse_site_by_article() {
        $this->_sitePageData->url = '/cabinet/shopgood/parse_site_by_article';

        $id = Request_RequestParams::getParamInt('id');
        $article = Request_RequestParams::getParamStr('article');
        $isReplace = Request_RequestParams::getParamBoolean('is_replace');

        $result = FALSE;
        $model = new Model_Shop_Good();
        switch (Request_RequestParams::getParamStr('site')){
            case 'ekt.kz':
                if ($id > 0) {
                    $result = Drivers_ParserSite_EktKZ::findOne($article, $id, $this->_sitePageData->shopID, $model,
                        $this->_sitePageData, $this->_driverDB, $isReplace);

                    if ($result){
                        Helpers_DB::saveDBObject($model, $this->_sitePageData);
                    }
                }else{
                    $result = Drivers_ParserSite_EktKZ::findOneInObject($article, $model, $this->_sitePageData,
                        $this->_driverDB, $isReplace);
                }
                break;
            case 'ensto.com':
                if ($id > 0) {
                    $result = Drivers_ParserSite_EnstoCom::findOne($article, $id, $this->_sitePageData->shopID, $model,
                        $this->_sitePageData, $this->_driverDB, $isReplace);

                    if ($result){
                        Helpers_DB::saveDBObject($model, $this->_sitePageData);
                    }
                }else{
                    $result = Drivers_ParserSite_EnstoCom::findOneInObject($article, $model, $this->_sitePageData,
                        $this->_driverDB, $isReplace);
                }
                break;
            case 'phk-holod.ru':
                if ($id > 0) {
                    $result = Drivers_ParserSite_PhkHolodRU::findOne($article, $id, $this->_sitePageData->shopID, $model,
                        $this->_sitePageData, $this->_driverDB, $isReplace);

                    if ($result){
                        Helpers_DB::saveDBObject($model, $this->_sitePageData);
                    }
                }else{
                    $result = Drivers_ParserSite_EnstoCom::findOneInObject($article, $model, $this->_sitePageData,
                        $this->_driverDB, $isReplace);
                }
                break;
            case 'made-in-china.com':
                if ($id > 0) {
                    $result = Drivers_ParserSite_MadeInChinaCom::findOne($article, $id, $this->_sitePageData->shopID, $model,
                        $this->_sitePageData, $this->_driverDB, $isReplace);

                    if ($result){
                        Helpers_DB::saveDBObject($model, $this->_sitePageData);
                    }
                }else{
                    $result = Drivers_ParserSite_MadeInChinaCom::findOneInObject($article, $model, $this->_sitePageData,
                        $this->_driverDB, $isReplace);
                }
                break;
            case 'stolicaholoda.ru':
                if ($id > 0) {
                    $result = Drivers_ParserSite_StolicaholodaRU::findOne($article, $id, $this->_sitePageData->shopID, $model,
                        $this->_sitePageData, $this->_driverDB, $isReplace);

                    if ($result){
                        Helpers_DB::saveDBObject($model, $this->_sitePageData);
                    }
                }else{
                    $result = Drivers_ParserSite_StolicaholodaRU::findOneInObject($article, $model, $this->_sitePageData,
                        $this->_driverDB, $isReplace);
                }
                break;
            case 'nzeta.ru':
                if ($id > 0) {
                    $result = Drivers_ParserSite_NzetaRU::findOne($article, $id, $this->_sitePageData->shopID, $model,
                        $this->_sitePageData, $this->_driverDB, $isReplace);

                    if ($result){
                        Helpers_DB::saveDBObject($model, $this->_sitePageData);
                    }
                }else{
                    $result = Drivers_ParserSite_NzetaRU::findOneInObject($article, $model, $this->_sitePageData,
                        $this->_driverDB, $isReplace);
                }
                break;
            case 'lotki.ru':
                if ($id > 0) {
                    $result = Drivers_ParserSite_LotkiRU::findOne($article, $id, $this->_sitePageData->shopID, $model,
                        $this->_sitePageData, $this->_driverDB, $isReplace);

                    if ($result){
                        Helpers_DB::saveDBObject($model, $this->_sitePageData);
                    }
                }else{
                    $result = Drivers_ParserSite_LotkiRU::findOneInObject($article, $model, $this->_sitePageData,
                        $this->_driverDB, $isReplace);
                }
                break;
        }

        if ($result){
            $result = array(
                'error' => FALSE,
                'values' => $model->getValues(TRUE, TRUE, $this->_sitePageData->shopID),
            );
        }else{
            $result = array(
                'error' => TRUE,
            );
        }

        $this->response->body(Json::json_encode($result));
    }

    public function action_parse_site_by_url() {
        $this->_sitePageData->url = '/cabinet/shopgood/parse_site_by_url';

        $type = Request_RequestParams::getParamInt('type');
        $url = Request_RequestParams::getParamStr('url');
        $isReplace = Request_RequestParams::getParamBoolean('is_replace');

        $result = FALSE;
        if((!empty($url)) && ($type > 0)) {
            $model = new Model_Shop_Good();
            $model->setDBDriver($this->_driverDB);
            switch (Request_RequestParams::getParamStr('site')) {
                case 'efa-germany.com/efa-en':
                    $result = Drivers_ParserSite_EfaGermany::parserEN($url, $type, $model,
                        $this->_sitePageData, $this->_driverDB, $isReplace);
                    break;
                case 'ziegra.co.uk':
                    $result = Drivers_ParserSite_ZiegraCoUk::parserEN($url, $type, $model,
                        $this->_sitePageData, $this->_driverDB, $isReplace);
                    break;
                case 'mecoima.com/web/en':
                    $result = Drivers_ParserSite_MecoimaCom::parserEN($url, $type, $model,
                        $this->_sitePageData, $this->_driverDB, $isReplace);
                    break;
                case 'idroinox.com/en':
                    $result = Drivers_ParserSite_IdroinoxCom::parserEN($url, $type, $model,
                        $this->_sitePageData, $this->_driverDB, $isReplace);
                    break;
                case 'gruppofabbri.com':
                    $result = Drivers_ParserSite_GruppoFabbriCom::parserENAndRus($url, $type, $model,
                        $this->_sitePageData, $this->_driverDB, $isReplace);
                    break;
                case 'techelectro.ru':
                    $result = Drivers_ParserSite_TechelectroRU::parserRus($url, $type, $model,
                        $this->_sitePageData, $this->_driverDB, $isReplace);
                    break;
                case 'ak-cent.kz':
                    $result = Drivers_ParserSite_AkCentKZ::parserRUS(
                        $type, $model, $this->_sitePageData, $this->_driverDB, $isReplace
                    );
                    break;
                case 'al-style.kz':
                    $result = Drivers_ParserSite_AlStyleKZ::parserRUS(
                        $type, $model, $this->_sitePageData, $this->_driverDB, $isReplace
                    );
                    break;
            }
        }

        if ($result){
            $result = array(
                'error' => FALSE,
                'values' => $model->getValues(TRUE, TRUE, $this->_sitePageData->shopID),
            );
        }else{
            $result = array(
                'error' => TRUE,
            );
        }

        $this->response->body(Json::json_encode($result));
    }
}
