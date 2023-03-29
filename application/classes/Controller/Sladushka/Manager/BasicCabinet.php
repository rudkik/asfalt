<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Sladushka_Manager_BasicCabinet extends Controller_Sladushka_Manager_BasicShop
{
    protected $controllerName = '';
    protected $tableID = 0;
    protected $tableName = '';
    protected $objectName = '';

    /**
     * Формируем index старинцу
     * @param $body
     * @return mixed
     */
    public function _putInIndex($body)
    {
        $tmp = $this->_sitePageData->dataLanguageID;
        $this->_sitePageData->dataLanguageID = Model_Language::LANGUAGE_RUSSIAN;

        // Получаем индекс страницу
        $index = $this->_driverDB->getMemcache()->getShopPage(
            $this->_sitePageData->shopID,
            $this->_sitePageData->shopShablonPath,
            $this->_sitePageData->languageID,
            $this->_sitePageData->url . $this->_sitePageData->shopMainID
        );
        if ($index === NULL) {

            // генерируем не изменяемую часть
            $view = View::factory($this->_sitePageData->shopShablonPath . '/' . $this->_sitePageData->languageID . '/index');
            $view->data = array(
                'view::main' => '^#@view::main_body@#^',
            );
            $view->siteData = $this->_sitePageData;
            $index = Helpers_View::viewToStr($view);

            // записываем в мемкеш
            $this->_driverDB->getMemcache()->setShopPage(
                $index,
                $this->_sitePageData->shopID,
                $this->_sitePageData->shopShablonPath,
                $this->_sitePageData->languageID,
                $this->_sitePageData->url . $this->_sitePageData->shopMainID
            );
        }

        $result = str_replace('^#@view::main_body@#^', $body, $index);
        $this->_sitePageData->dataLanguageID = $tmp;

        return $result;
    }

    /**
     * Формируем index старинцу
     * @param $file
     */
    public function _putInMain($file)
    {
        $this->_sitePageData->addReplaceAndGlobalDatas('view::good_count',
            Request_Request::find('DB_Shop_Good',$this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB,
                array(Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE, 'count_id' => TRUE))->childs[0]->values['count']);

        $this->_sitePageData->addReplaceAndGlobalDatas('view::shop_count',
            Request_Shop::findShopBranchIDs($this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB,
            array(Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE, 'shop_operation_id' => $this->_sitePageData->operationID,
                'count_id' => TRUE))->childs[0]->values['count']);

        $this->_sitePageData->addReplaceAndGlobalDatas('view::bill_count',
            Request_Request::find('DB_Shop_Bill', $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB,
                array(Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE, 'create_user_id' => $this->_sitePageData->userID,
                    'created_at_from' => date('Y-m-d 00:00:00'), 'created_at_to' => date('Y-m-d 23:59:59'),
                    'count_id' => TRUE))->childs[0]->values['count']);

        $this->_sitePageData->addReplaceAndGlobalDatas('view::paid_count',
            Request_Request::find('DB_Shop_Paid', $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB,
                array(Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE, 'create_user_id' => $this->_sitePageData->userID,
                    'created_at_from' => date('Y-m-d 00:00:00'), 'created_at_to' => date('Y-m-d 23:59:59'),
                    'count_id' => TRUE))->childs[0]->values['count']);

        $this->_sitePageData->addReplaceAndGlobalDatas('view::cart_count',
            Api_Shop_Cart::getGoodsCount($this->_sitePageData->shopID, $this->_sitePageData));

        $this->_sitePageData->addReplaceAndGlobalDatas('view::return_count',
            Request_Request::find('DB_Shop_Return', $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB,
                array(Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE, 'create_user_id' => $this->_sitePageData->userID,
                    'created_at_from' => date('Y-m-d 00:00:00'), 'created_at_to' => date('Y-m-d 23:59:59'),
                    'count_id' => TRUE))->childs[0]->values['count']);

        // Получаем индекс страницу
        $key = $file . Helpers_DB::getURLParamDatas(array('system'));
        $index = $this->_driverDB->getMemcache()->getShopMain(
            $this->_sitePageData->shopID,
            $this->_sitePageData->shopShablonPath,
            $this->_sitePageData->languageID,
            $this->_sitePageData->url . $this->_sitePageData->shopMainID,
            $key
        );

        if ($index === NULL) {
            // генерируем не изменяемую часть
            $view = View::factory($this->_sitePageData->shopShablonPath . '/' . $this->_sitePageData->languageID . $file);

            $view->data = $this->_sitePageData->globalDatas;
            $view->siteData = $this->_sitePageData;
            $index = Helpers_View::viewToStr($view);

            // записываем в мемкеш
            $this->_driverDB->getMemcache()->setShopMain(
                $index,
                $this->_sitePageData->shopID,
                $this->_sitePageData->shopShablonPath,
                $this->_sitePageData->languageID,
                $this->_sitePageData->url . $this->_sitePageData->shopMainID,
                $key
            );
        }
        $this->response->body($this->_sitePageData->replaceStaticDatas($this->_putInIndex($index)));
    }


    /**
     * Получаем html для объекта сгруппированного объекта
     * @throws HTTP_Exception_404
     */
    public function action_group() {
        $this->_sitePageData->url = '/manager/' . $this->controllerName . '/group';

        switch ($this->tableID) {
            case Model_Shop_Good::TABLE_ID:
                $result = View_View::findOne('DB_Shop_Good', $this->_sitePageData->shopID, '_shop/'.$this->objectName.'/one/group', $this->_sitePageData, $this->_driverDB,
                    array('id' => Request_RequestParams::getParamInt('id'), Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE));
                break;
            default:
                throw new HTTP_Exception_404('');
        }

        $this->response->body($result);
    }

    /**
     * Поиск объектов для сгруппированных объектов
     * @throws HTTP_Exception_404
     */
    public function action_findgroup() {
        $this->_sitePageData->url = '/manager/' . $this->controllerName . '/findgroup';

        switch ($this->tableID) {
            case Model_Shop_Good::TABLE_ID:
                $result = View_View::find('DB_Shop_Good', $this->_sitePageData->shopID,
                    '_shop/'.$this->objectName.'/list/group-popup', '_shop/'.$this->objectName.'/one/group-popup',
                    $this->_sitePageData, $this->_driverDB, array('is_group' => 0));
                break;
            default:
                throw new HTTP_Exception_404('');
        }

        // тип объекта
        $this->_getType();
        $result = $this->_sitePageData->replaceStaticDatas($result);

        $this->response->body($result);
    }

    /**
     * Получаем html для объекта подобного
     * @throws HTTP_Exception_404
     */
    public function action_similar() {
        $this->_sitePageData->url = '/manager/' . $this->controllerName . '/similar';

        switch ($this->tableID) {
            case Model_Shop_Good::TABLE_ID:
                $result = View_View::findOne('DB_Shop_Good', $this->_sitePageData->shopID, '_shop/'.$this->objectName.'/one/similar', $this->_sitePageData, $this->_driverDB,
                    array('id' => Request_RequestParams::getParamInt('id'), Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE));
                break;
            default:
                throw new HTTP_Exception_404('');
        }

        $this->response->body($result);
    }

    /**
     * Поиск объектов для подобных объектов
     * @throws HTTP_Exception_404
     */
    public function action_findsimilar() {
        $this->_sitePageData->url = '/manager/' . $this->controllerName . '/findsimilar';

        switch ($this->tableID) {
            case Model_Shop_Good::TABLE_ID:
                $result = View_View::find('DB_Shop_Good', $this->_sitePageData->shopID,
                    '_shop/'.$this->objectName.'/list/similar-popup', '_shop/'.$this->objectName.'/one/similar-popup',
                    $this->_sitePageData, $this->_driverDB);
                break;
            default:
                throw new HTTP_Exception_404('');
        }

        // тип объекта
        $this->_getType();
        $result = $this->_sitePageData->replaceStaticDatas($result);

        $this->response->body($result);
    }

    /**
     * Сохранение сортировки
     */
    public function action_savesort()
    {
        $this->_sitePageData->url = '/manager/' . $this->controllerName . '/savesort';

        Api_Basic::saveListOrder($this->tableName, $this->_sitePageData, $this->_driverDB);

        $arr = array();

        $tmp = Request_RequestParams::getParamArray('request', array(), array());
        foreach($tmp as $key => $value){
            $arr[$key] = $value;
        }

        $tmp = Request_RequestParams::getParamInt('type');
        if ($tmp > 0) {
            $arr['type'] = $tmp;
        }

        $tmp = Request_RequestParams::getParamInt('table_id');
        if ($tmp > 0) {
            $arr['table_id'] = $tmp;
        }

        $tmp = Request_RequestParams::getParamInt('is_group');
        if ($tmp !== NULL) {
            $arr['is_group'] = $tmp;
        }

        if ($this->_sitePageData->branchID > 0) {
            $arr['shop_branch_id'] = $this->_sitePageData->branchID;
        }

        $this->redirect('/manager/' . $this->controllerName . '/sort' . URL::query($arr, FALSE));
    }

    /**
     * Получение списка ввиде данных
     * @throws HTTP_Exception_404
     */
    public function action_list() {
        $this->_sitePageData->url = '/manager/' . $this->controllerName . '/list';

        $fileType = Request_RequestParams::getParamStr('file_type');
        switch($fileType){
            case 'xml':
            case 'csv':
                break;
            default:
                throw new HTTP_Exception_404('File type not is found!');
        }

        switch ($this->tableID) {
            case Model_Shop_Good::TABLE_ID:
                $result = View_View::find('DB_Shop_Good', $this->_sitePageData->shopID,
                    '_shop/'.$this->objectName.'/list/save/' . $fileType, '_shop/'.$this->objectName.'/one/save/' . $fileType,
                    $this->_sitePageData, $this->_driverDB, array('limit_page' => 10000), array('shop_table_catalog_id', 'shop_table_rubric_id', 'shop_table_select_id', 'shop_table_unit_id', 'shop_table_brand_id'));
                break;
            case Model_Shop_New::TABLE_ID:
                $result = View_View::find('DB_Shop_New', $this->_sitePageData->shopID,
                    '_shop/'.$this->objectName.'/list/save/' . $fileType, '_shop/'.$this->objectName.'/one/save/' . $fileType,
                    $this->_sitePageData, $this->_driverDB, array('limit_page' => 10000), array('shop_table_catalog_id', 'shop_table_rubric_id', 'shop_table_select_id', 'shop_table_unit_id', 'shop_table_brand_id'));
                break;
            default:
                $result = '';
        }

        $this->response->body($result);
    }

    /**
     * Сохранение список изменений
     */
    public function action_savelist()
    {
        $this->_sitePageData->url = '/manager/' . $this->controllerName . '/savelist';

        switch ($this->tableID) {
            case Model_Shop_Table_Hashtag::TABLE_ID:
                Api_Shop_Table_Hashtag::saveList($this->_sitePageData, $this->_driverDB);
                break;
            case Model_Shop_Table_Rubric::TABLE_ID:
                Api_Shop_Table_Rubric::saveList($this->_sitePageData, $this->_driverDB);
                break;
            case Model_Shop_Table_Brand::TABLE_ID:
                Api_Shop_Table_Brand::saveList($this->_sitePageData, $this->_driverDB);
                break;
            case Model_Shop_Table_Filter::TABLE_ID:
                Api_Shop_Table_Filter::saveList($this->_sitePageData, $this->_driverDB);
                break;
            case Model_Shop_Table_Unit::TABLE_ID:
                Api_Shop_Table_Unit::saveList($this->_sitePageData, $this->_driverDB);
                break;
            case Model_Shop_Table_Select::TABLE_ID:
                Api_Shop_Table_Select::saveList($this->_sitePageData, $this->_driverDB);
                break;
            case Model_Shop_Table_Child::TABLE_ID:
                Api_Shop_Table_Child::saveList($this->_sitePageData, $this->_driverDB);
                break;
            case Model_Shop_Good::TABLE_ID:
                Api_Shop_Good::saveList($this->_sitePageData, $this->_driverDB);
                break;
        }

        if (Request_RequestParams::getParamBoolean('json') === TRUE) {
            $this->response->body(Json::json_encode(
                array(
                    'error' => FALSE,
                )
            ));
        } else {
            $arr = array();

            $tmp = Request_RequestParams::getParamArray('request', array(), array());
            foreach($tmp as $key => $value){
                $arr[$key] = $value;
            }

            $tmp = Request_RequestParams::getParamInt('type');
            if ($tmp > 0) {
                $arr['type'] = $tmp;
            }

            $tmp = Request_RequestParams::getParamInt('table_id');
            if ($tmp > 0) {
                $arr['table_id'] = $tmp;
            }

            if ($this->_sitePageData->branchID > 0) {
                $arr['shop_branch_id'] = $this->_sitePageData->branchID;
            }

            $this->redirect('/manager/' . $this->controllerName . '/index_edit' . URL::query($arr, FALSE));
        }
    }

    /**
     * Добавление группы изображений по id или по штрихкоду
     */
    public function action_addimages()
    {
        $this->_sitePageData->url = '/manager/' . $this->controllerName . '/addimages';

        switch ($this->tableID) {
            case Model_Shop_Table_Hashtag::TABLE_ID:
                $result = Api_Shop_Table_Hashtag::addImages($this->_sitePageData, $this->_driverDB);
                break;
            case Model_Shop_Table_Rubric::TABLE_ID:
                $result = Api_Shop_Table_Rubric::addImages($this->_sitePageData, $this->_driverDB);
                break;
            case Model_Shop_Table_Brand::TABLE_ID:
                $result = Api_Shop_Table_Brand::addImages($this->_sitePageData, $this->_driverDB);
                break;
            case Model_Shop_Table_Filter::TABLE_ID:
                $result = Api_Shop_Table_Filter::addImages($this->_sitePageData, $this->_driverDB);
                break;
            case Model_Shop_Table_Unit::TABLE_ID:
                $result = Api_Shop_Table_Unit::addImages($this->_sitePageData, $this->_driverDB);
                break;
            case Model_Shop_Table_Select::TABLE_ID:
                $result = Api_Shop_Table_Select::addImages($this->_sitePageData, $this->_driverDB);
                break;
            case Model_Shop_Good::TABLE_ID:
                $result = Api_Shop_Good::addImages($this->_sitePageData, $this->_driverDB);
                break;
            default:
                $result = array();
        }

        $this->response->body(json_encode(array('error' => 0, 'data' => $result)));
    }

    /**
     * Добавление изображений
     * @throws HTTP_Exception_500
     */
    public function action_addimg()
    {
        $this->_sitePageData->url = '/manager/' . $this->controllerName . '/addimg';

        $model = DB_Basic::createModel($this->dbObject, $this->_driverDB);

        $id = Request_RequestParams::getParamInt('id');
        if (($id < 1) || (!$this->dublicateObjectLanguage($model, $id))) {
            throw new HTTP_Exception_500('Object not found.');
        }

        // загружаем фотографии
        $file = new Model_File($this->_sitePageData);

        if (key_exists('file', $_FILES) && (file_exists($_FILES['file']['tmp_name']))) {
            if ($file->addImageInModel($_FILES['file'], $model, $this->_sitePageData, $this->_driverDB)) {
                $this->saveDBObject($model);
            }
        } else {
            $url = Request_RequestParams::getParamStr('file_url');
            if (!empty($url)) {
                if ($file->addImageURLInModel($url, $model, $this->_sitePageData, $this->_driverDB)) {
                    $this->saveDBObject($model);
                }
            }
        }

        $this->response->body(Json::json_encode(
            array(
                'error' => FALSE,
                'file_name' => Func::addSiteNameInFilePath($model->getImagePath(), $this->_sitePageData),
            )
        ));
    }


    /**
     * Считываем тип объекта
     * @return array
     * @throws HTTP_Exception_404
     */
    protected function _getType(){
        $typeID = intval(Request_RequestParams::getParamInt('type'));
        if ($typeID > 0) {
            $model = new Model_Shop_Table_Catalog();
            $model->setDBDriver($this->_driverDB);
            if(! $this->getDBObject($model,$typeID)){
                throw new HTTP_Exception_404('Table catalog not is found!');
            }
            $result = $model->getValues(TRUE, TRUE, $this->_sitePageData->shopMainID);
        }else{
            $result = array('id' => 0);
        }

        $this->_sitePageData->replaceDatas['view::type'] = $result;

        return $result;
    }

    /**
     * Делаем запрос на список рубрик
     * @param $typeID
     */
    protected function _requestShopTableRubric($typeID, $currentID = NULL){
        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/_table/rubric/list/list',
            )
        );

        $data = View_View::find('DB_Shop_Table_Rubric', $this->_sitePageData->shopID,
            "_shop/_table/rubric/list/list", "_shop/_table/rubric/one/list", $this->_sitePageData, $this->_driverDB,
            array('type' => array(0, $typeID), 'table_id' => $this->tableID, Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE));

        if($currentID !== NULL){
            $s = 'data-id="'.$currentID.'"';
            $data = str_replace($s, $s.' selected', $data);
            $this->_sitePageData->replaceDatas['view::_shop/_table/rubric/list/list'] = $data;
        }
    }

    /**
     * Делаем запрос на список брендов
     * @param array $type
     * @return string
     */
    protected function _requestShopTableBrand(array $type, $currentID = NULL){
        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/_table/brand/list/list',
            )
        );

        $typeID = intval(Arr::path($type, 'child_shop_table_catalog_ids.brand.id', 0));
        if($typeID < 1){
            return '';
        }

        $data = View_View::find('DB_Shop_Table_Brand', $this->_sitePageData->shopID,
            "_shop/_table/brand/list/list", "_shop/_table/brand/one/list", $this->_sitePageData, $this->_driverDB,
            array('type' => array($typeID), 'table_id' => $this->tableID, Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE));

        if($currentID !== NULL){
            $s = 'data-id="'.$currentID.'"';
            $data = str_replace($s, $s.' selected', $data);
            $this->_sitePageData->replaceDatas['view::_shop/_table/brand/list/list'] = $data;
        }

        return $data;
    }

    /**
     * Делаем запрос на список фильтров
     * @param array $type
     * @return string
     */
    protected function _requestShopTableFilter(array $type, $currentIDs = NULL){
        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/_table/filter/list/list',
            )
        );

        $typeID = intval(Arr::path($type, 'child_shop_table_catalog_ids.filter.id', 0));
        if($typeID < 1){
            return '';
        }

        $data = View_View::find('DB_Shop_Table_Filter', $this->_sitePageData->shopID,
            "_shop/_table/filter/list/list", "_shop/_table/filter/one/list", $this->_sitePageData, $this->_driverDB,
            array('type' => array($typeID), 'table_id' => $this->tableID, Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE));

        if(($currentIDs !== NULL) && (is_array($currentIDs))){
            foreach($currentIDs as $currentID) {
                $s = 'data-id="' . $currentID . '"';
                $data = str_replace($s, $s . ' selected', $data);
            }
            $this->_sitePageData->replaceDatas['view::_shop/_table/filter/list/list'] = $data;
        }
    }

    /**
     * Делаем запрос на список хэштег
     * @param array $type
     * @return string
     */
    protected function _requestShopTableHashtah(array $type, $currentIDs = NULL){
        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/_table/hashtag/list/list',
            )
        );

        $typeID = intval(Arr::path($type, 'child_shop_table_catalog_ids.hashtag.id', 0));
        if($typeID < 1){
            return '';
        }

        $data = View_View::find('DB_Shop_Table_Hashtag', $this->_sitePageData->shopID,
            "_shop/_table/hashtag/list/list", "_shop/_table/hashtag/one/list", $this->_sitePageData, $this->_driverDB,
            array('type' => array($typeID), 'table_id' => $this->tableID, Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE));

        if(($currentIDs !== NULL) && (is_array($currentIDs))){
            foreach($currentIDs as $currentID) {
                $s = 'data-id="' . $currentID . '"';
                $data = str_replace($s, $s . ' selected', $data);
            }
            $this->_sitePageData->replaceDatas['view::_shop/_table/hashtag/list/list'] = $data;
        }
    }

    /**
     * Делаем запрос на список видов выделения
     * @param array $type
     * @return string
     */
    protected function _requestShopTableSelect(array $type, $currentID = NULL){
        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/_table/select/list/list',
            )
        );

        $typeID = intval(Arr::path($type, 'child_shop_table_catalog_ids.select.id', 0));
        if($typeID < 1){
            return '';
        }

        $data = View_View::find('DB_Shop_Table_Select', $this->_sitePageData->shopID,
            "_shop/_table/select/list/list", "_shop/_table/select/one/list", $this->_sitePageData, $this->_driverDB,
            array('type' => array($typeID), 'table_id' => $this->tableID, Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE));

        if($currentID !== NULL){
            $s = 'data-id="'.$currentID.'"';
            $data = str_replace($s, $s.' selected', $data);
            $this->_sitePageData->replaceDatas['view::_shop/_table/select/list/list'] = $data;
        }

        return $data;
    }

    /**
     * Делаем запрос на список единиц измерения
     * @param array $type
     * @return string
     */
    protected function _requestShopTableUnit(array $type, $currentID = NULL){
        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/_table/unit/list/list',
            )
        );

        $typeID = intval(Arr::path($type, 'child_shop_table_catalog_ids.unit.id', 0));
        if($typeID < 1){
            return '';
        }

        $data = View_View::find('DB_Shop_Table_Unit', $this->_sitePageData->shopID,
            "_shop/_table/unit/list/list", "_shop/_table/unit/one/list", $this->_sitePageData, $this->_driverDB,
            array('type' => array($typeID), 'table_id' => $this->tableID, Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE));

        if($currentID !== NULL){
            $s = 'data-id="'.$currentID.'"';
            $data = str_replace($s, $s.' selected', $data);
            $this->_sitePageData->replaceDatas['view::_shop/_table/unit/list/list'] = $data;
        }

        return $data;
    }

    /**
     * Делаем запрос на список единиц измерения
     * @param array $type
     * @param Model_Shop_Table_Basic_Table|NULL $model
     */
    protected function _requestTableObjects(array $type, $model = NULL)
    {
        if ($model === NULL) {
            $this->_requestShopTableRubric($type['id']);
            $this->_requestShopTableBrand($type);
            $this->_requestShopTableFilter($type);
            $this->_requestShopTableHashtah($type);
            $this->_requestShopTableSelect($type);
            $this->_requestShopTableUnit($type);
        } else {
            $this->_requestShopTableRubric($type['id'], $model->getShopTableRubricID());
            $this->_requestShopTableBrand($type, $model->getShopTableBrandID());
            $this->_requestShopTableFilter($type, $model->getShopTableFilterIDsArray());
            $this->_requestShopTableHashtah($type, $model->getShopTableHashtagIDsArray());
            $this->_requestShopTableSelect($type, $model->getShopTableSelectID());
            $this->_requestShopTableUnit($type, $model->getShopTableUnitID());
        }
    }

    /**
     * Делаем запрос на список фильтров у товара
     * @param array $type
     * @return string
     */
    protected function _requestShopTableObjectToFilter(array $type, $modelObject = NULL, $isReadIsModel = TRUE)
    {
        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/_table/filter/list/list-edit',
                'view::filter#_shop/_table/rubric/list/list',
                'view::_shop/_table/rubric/list/data-list',
            )
        );

        $typeID = intval(Arr::path($type, 'child_shop_table_catalog_ids.filter.id', 0));
        if ($typeID < 1) {
            return '';
        }

        // получаем список атрбутов и категорий атрибутов
        $shopRubricIDs = Request_Request::find('DB_Shop_Table_Rubric', $this->_sitePageData->shopID,
            $this->_sitePageData, $this->_driverDB, array('type' => $typeID, 'table_id' => Model_Shop_Table_Filter::TABLE_ID, Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE));

        foreach ($shopRubricIDs->childs as $shopRubricID) {
            $shopRubricID->additionDatas['view::_shop/_table/object/list/data-list'] = View_View::find('DB_Shop_Table_Filter', $this->_sitePageData->shopID,
                "_shop/_table/filter/list/data-list", "_shop/_table/filter/one/data-list", $this->_sitePageData, $this->_driverDB,
                array('type' => $typeID, 'shop_table_rubric_id' => $shopRubricID->id, Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE));
        }

        $model = new Model_Shop_Table_Rubric();
        $model->setDBDriver($this->_driverDB);
        $this->_sitePageData->replaceDatas['view::_shop/_table/rubric/list/data-list'] = Helpers_View::getViewObjects($shopRubricIDs, $model,
            '_shop/_table/rubric/list/data-list', '_shop/_table/rubric/one/data-list', $this->_sitePageData, $this->_driverDB);

        $this->_sitePageData->replaceDatas['view::filter#_shop/_table/rubric/list/list'] = View_View::find('DB_Shop_Table_Rubric', $this->_sitePageData->shopID,
            "_shop/_table/rubric/list/list", "_shop/_table/rubric/one/list", $this->_sitePageData, $this->_driverDB,
            array('type' => array($typeID), 'table_id' => Model_Shop_Table_Filter::TABLE_ID, Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE));

        if ($modelObject !== NULL) {
            if($isReadIsModel){
                $ids = new MyArray($modelObject->getShopTableFilterIDsArray());
            }else {
                $ids = Request_Shop_Table_ObjectToObject::findShopChildIDs($this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB,
                    array('type' => array($typeID), 'table_id' => Model_Shop_Table_Filter::TABLE_ID, 'shop_root_object_id' => $modelObject->id, Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE));
            }

        } else {
            $ids = new MyArray();
        }

        $model = new Model_Shop_Table_Filter();
        $model->setDBDriver($this->_driverDB);

        $this->_sitePageData->replaceDatas['view::_shop/_table/filter/list/list-edit'] =
            Helpers_View::getViewObjects($ids, $model,
                '_shop/_table/filter/list/list-edit', '_shop/_table/filter/one/list-edit',
                $this->_sitePageData, $this->_driverDB, $this->_sitePageData->shopID, TRUE, array('shop_table_rubric_id'));
    }

    /**
     * Возвращаем результать сохранения
     * @param array $result
     */
    protected function _redirectSaveResult(array $result){
        if (Request_RequestParams::getParamBoolean('json') || $result['result']['error']) {
            $this->response->body(Json::json_encode($result['result']));
        } else {
            $branchID = '';
            if($this->_sitePageData->branchID > 0){
                $branchID = '&shop_branch_id='.$this->_sitePageData->branchID;
            }

            $params = array(
                'id' => $result['id'],
                'is_public_ignore' => TRUE,
            );
            if(key_exists('type', $result)){
                $params['type'] = $result['type'];
            }
            if(key_exists('table_id', $result)){
                $params['table_id'] = $result['table_id'];
            }
            if(key_exists('is_group', $result)){
                $params['is_group'] = $result['is_group'];
            }
            $params = URL::query($params, FALSE).$branchID;

            if(Request_RequestParams::getParamBoolean('is_close') === FALSE){
                $params = 'edit'.$params;
            }else{
                $params = 'index'.$params;
            }

            $this->redirect('/'.$this->_sitePageData->actionURLName.'/'.$this->controllerName.'/'.$params);
        }
    }

}