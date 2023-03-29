<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Sladushka_Manager_ShopGood extends Controller_Sladushka_Manager_File {

    public function __construct(Request $request, Response $response)
    {
        $this->controllerName = 'shopgood';
        $this->tableID = Model_Shop_Good::TABLE_ID;
        $this->tableName = Model_Shop_Good::TABLE_NAME;
        $this->objectName = 'good';

        parent::__construct($request, $response);
        $this->_sitePageData->controllerName = $this->controllerName;
    }

    public function action_index() {
        $this->_sitePageData->url = '/manager/shopgood/index';

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

        // получаем список
        $goodToOperationIDs = Request_Request::find('DB_Shop_Good_To_Operation', $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB,
            array('shop_operation_id' => $this->_sitePageData->operationID, Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE), 0, TRUE);

        $ids = $goodToOperationIDs->getChildArrayValue('shop_good_id');
        if(count($ids) > 0) {
            $shopGoodIDs = Request_Request::find('DB_Shop_Good',$this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB,
                array('id' => array('value' => $ids), 'sort_by' => array('value' => array('name' => 'asc')),
                    Request_RequestParams::IS_NOT_READ_REQUEST_NAME => FALSE, 'limit_page' => 15));
            foreach ($shopGoodIDs->childs as $shopGoodID) {
                $tmp = $goodToOperationIDs->findChildValue('shop_good_id', $shopGoodID->id);
                if ($tmp !== FALSE) {
                    $shopGoodID->additionDatas['price'] = $tmp->values['price'];
                }
            }
        }else{
            $shopGoodIDs = new MyArray();
        }

        $model = new Model_Shop_Good();
        $model->setDBDriver($this->_driverDB);
        $this->_sitePageData->replaceDatas['view::_shop/good/list/index'] =
            Helpers_View::getViewObjects($shopGoodIDs, $model, "_shop/good/list/index", "_shop/good/one/index",
                $this->_sitePageData, $this->_driverDB, $this->_sitePageData->shopID, TRUE, array('shop_table_unit_id'));

        $this->_putInMain('/main/_shop/good/index');
    }

    public function action_new()
    {
        $this->_sitePageData->url = '/manager/shopgood/new';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/good/one/new',
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

        $this->_sitePageData->replaceDatas['view::_shop/good/one/new'] = Helpers_View::getViewObject($dataID, new Model_Shop_Good(),
            '_shop/good/one/new', $this->_sitePageData, $this->_driverDB);

        $this->_putInMain('/main/_shop/good/new');
    }

    public function action_edit()
    {
        $this->_sitePageData->url = '/manager/shopgood/edit';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/good/one/edit',
            )
        );

        // id записи
        $shopGoodID = Request_RequestParams::getParamInt('id');
        if ($shopGoodID === NULL) {
            throw new HTTP_Exception_404('Goods not is found!');
        }else {
            $modelGood = new Model_Shop_Good();
            if (! $this->dublicateObjectLanguage($modelGood, $shopGoodID)) {
                throw new HTTP_Exception_404('Goods not is found!');
            }
        }

        // тип объекта
        $type = $this->_getType();

        $this->_requestTableObject($type, $modelGood);

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
        View_View::findOne('DB_Shop_Good', $this->_sitePageData->shopID, "_shop/good/one/edit",
            $this->_sitePageData, $this->_driverDB, array('id' => $shopGoodID), array('shop_table_catalog_id'));

        $this->_putInMain('/main/_shop/good/edit');
    }

    public function action_save()
    {
        $this->_sitePageData->url = '/manager/shopgood/save';
        $result = Api_Shop_Good::save($this->_sitePageData, $this->_driverDB);
        $this->_redirectSaveResult($result);
    }

    public function action_del() {
        $this->_sitePageData->url = '/manager/shopgood/del';

        Api_Shop_Good::delete($this->_sitePageData, $this->_driverDB);
        $this->response->body(Json::json_encode(array('error' => FALSE)));
    }

    public function action_findpromo() {
        $this->_sitePageData->url = '/manager/shopgood/findpromo';

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
        $this->_sitePageData->url = '/manager/shopgood/promo';

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
        $this->_sitePageData->url = '/manager/shopgood/findpromogift';

        // получаем список
        $shopGoodIDs = View_View::find('DB_Shop_Good', $this->_sitePageData->shopID,
            "_shop/good/list/promo-popup-gift", "_shop/good/one/promo-popup-gift",
            $this->_sitePageData, $this->_driverDB, array('limit' => 0));

        $this->response->body($shopGoodIDs);
    }

    public function action_promogift() {
        $this->_sitePageData->url = '/manager/shopgood/promogift';

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

        $this->_sitePageData->url = '/manager/shopgood/load_site_by_barcode';

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

        $this->_sitePageData->url = '/manager/shopgood/parser_data_site';

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

        $this->_sitePageData->url = '/manager/shopgood/save_data_site';

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
        $this->_sitePageData->url = '/manager/shopgood/load_xml_in_url';

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
                        case 'storage_count': $model->setStorageCount(intval(Arr::path($record, $value, ''))); break;
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
}
