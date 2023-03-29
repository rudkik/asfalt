<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Cabinet_BasicCabinet extends Controller_Cabinet_BasicShop
{
    protected $controllerName = '';
    protected $tableID = 0;
    protected $tableName = '';
    protected $objectName = '';

    /**
     * Меню типов объетов
     * @throws Exception
     */
    public function _getShopTableCatalogMenu()
    {
        $path = '_shop/_table/catalog/menu/list/';
        $pathTop = '_shop/_table/catalog/menu/top/list/';
        $this->_setGlobalDatas(
            array(
                $path.'shopcar',
                $path.'shopgood',
                $path.'shopnew',
                $path.'shopgallery',
                $path.'shopfile',
                $path.'shopcalendar',
                $path.'shopbill',
                $path.'shopclient',
                $path.'shopcomment',
                $path.'shopcoupon',
                $path.'shoppersondiscount',
                $path.'shopmessage',
                $path.'shopoperation',
                $path.'shopquestion',
                $path.'shopsubscribe',
                $path.'shopbranch',
                $path.'shoppaid',
                $path.'shopreturn',
                $path.'shopoperationstock',
                $pathTop.'shopcar',
                $pathTop.'shopgood',
                $pathTop.'shopnew',
                $pathTop.'shopgallery',
                $pathTop.'shopfile',
                $pathTop.'shopcalendar',
                $pathTop.'shopbill',
                $pathTop.'shopclient',
                $pathTop.'shopcomment',
                $pathTop.'shopcoupon',
                $pathTop.'shoppersondiscount',
                $pathTop.'shopmessage',
                $pathTop.'shopoperation',
                $pathTop.'shopquestion',
                $pathTop.'shopsubscribe',
                $pathTop.'shopbranch',
                $pathTop.'shoppaid',
                $pathTop.'shopreturn',
                $pathTop.'shopoperationstock',
            )
        );

        // получаем список всех типов объектов
        $shopTableCatalogIDs = Request_Request::find('DB_Shop_Table_Catalog',$this->_sitePageData->shopMainID, $this->_sitePageData,
            $this->_driverDB, array(Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE), 0, TRUE);

        // выбираем главные объекты
        $tableIDs = array();
        foreach ($shopTableCatalogIDs->childs as $shopTableCatalogID) {
            if ($shopTableCatalogID->values['root_shop_table_catalog_id'] > 0) {
                continue;
            }

            $tableID = $shopTableCatalogID->values['table_id'];
            if (!key_exists($tableID, $tableIDs)) {
                $tableIDs[$tableID] = new MyArray();
            }

            $tmp = $tableIDs[$tableID]->addChildObject($shopTableCatalogID);
            $tmp->additionDatas['view::_shop/_table/catalog/menu/one/child'] = new MyArray();
            $tmp->additionDatas['view::_shop/_table/catalog/menu/top/one/child'] = new MyArray();
        }

        // выбираем подчиненные объекты
        foreach ($shopTableCatalogIDs->childs as $shopTableCatalogID) {

            $rootShopTableCatalogID = $shopTableCatalogID->values['root_shop_table_catalog_id'];
            if ($rootShopTableCatalogID < 1) {
                continue;
            }

            foreach ($tableIDs as $tableID) {
                $tmp = $tableID->findChild($rootShopTableCatalogID);
                if ($tmp !== NULL) {
                    $tmp->additionDatas['view::_shop/_table/catalog/menu/one/child']->addChildObject($shopTableCatalogID);
                    $tmp->additionDatas['view::_shop/_table/catalog/menu/top/one/child']->addChildObject($shopTableCatalogID);
                }
            }
        }

        $model = new Model_Shop_Table_Catalog();
        $model->setDBDriver($this->_driverDB);

        foreach ($tableIDs as $tableID_ => $list) {
            switch ($tableID_) {
                case Model_Shop_Car::TABLE_ID:
                    $viewObjects = 'shopcar';
                    break;
                case Model_Shop_Good::TABLE_ID:
                    $viewObjects = 'shopgood';
                    break;
                case Model_Shop_New::TABLE_ID:
                    $viewObjects = 'shopnew';
                    break;
                case Model_Shop_Gallery::TABLE_ID:
                    $viewObjects = 'shopgallery';
                    break;
                case Model_Shop_File::TABLE_ID:
                    $viewObjects = 'shopfile';
                    break;
                case Model_Shop_Calendar::TABLE_ID:
                    $viewObjects = 'shopcalendar';
                    break;
                case Model_Shop_Bill::TABLE_ID:
                    $viewObjects = 'shopbill';
                    break;
                case Model_Shop_Client::TABLE_ID:
                    $viewObjects = 'shopclient';
                    break;
                case Model_Shop_Comment::TABLE_ID:
                    $viewObjects = 'shopcomment';
                    break;
                case Model_Shop_Coupon::TABLE_ID:
                    $viewObjects = 'shopcoupon';
                    break;
                case Model_Shop_PersonDiscount::TABLE_ID:
                    $viewObjects = 'shoppersondiscount';
                    break;
                case Model_Shop_Message::TABLE_ID:
                    $viewObjects = 'shopmessage';
                    break;
                case Model_Shop_Operation::TABLE_ID:
                    $viewObjects = 'shopoperation';
                    break;
                case Model_Shop_Question::TABLE_ID:
                    $viewObjects = 'shopquestion';
                    break;
                case Model_Shop_Subscribe::TABLE_ID:
                    $viewObjects = 'shopsubscribe';
                    break;
                case Model_Shop::TABLE_ID:
                    $viewObjects = 'shopbranch';
                    break;
                case Model_Shop_Paid::TABLE_ID:
                    $viewObjects = 'shoppaid';
                    break;
                case Model_Shop_Return::TABLE_ID:
                    $viewObjects = 'shopreturn';
                    break;
                case Model_Shop_Operation_Stock::TABLE_ID:
                    $viewObjects = 'shopoperationstock';
                    break;
                default:
                    continue 2;
            }

            // под типы
            foreach ($list->childs as $one) {
                $datas = Helpers_View::getViewObjects($one->additionDatas['view::_shop/_table/catalog/menu/one/child'], $model, '_shop/_table/catalog/menu/list/child',
                    '_shop/_table/catalog/menu/one/child', $this->_sitePageData, $this->_driverDB, $this->_sitePageData->shopMainID);
                $one->additionDatas['view::_shop/_table/catalog/menu/one/child'] = $datas;
            }

            // основные типы
            $datas = Helpers_View::getViewObjects($list, $model,
                '_shop/_table/catalog/menu/list/root', '_shop/_table/catalog/menu/one/root', $this->_sitePageData, $this->_driverDB,
                $this->_sitePageData->shopMainID);
            $this->_sitePageData->addReplaceDatas('view::' . $path.$viewObjects, $datas);
            $this->_sitePageData->addKeyInGlobalDatas('view::' . $path.$viewObjects);

            // под типы
            foreach ($list->childs as $one) {
                $one->str = NULL;
                foreach ($one->additionDatas['view::_shop/_table/catalog/menu/top/one/child']->childs as $tmp) {
                    $tmp->str = NULL;
                }

                $datas = Helpers_View::getViewObjects($one->additionDatas['view::_shop/_table/catalog/menu/top/one/child'], $model, '_shop/_table/catalog/menu/top/list/child',
                    '_shop/_table/catalog/menu/top/one/child', $this->_sitePageData, $this->_driverDB, $this->_sitePageData->shopMainID);
                $one->additionDatas['view::_shop/_table/catalog/menu/top/one/child'] = $datas;
            }

            // основные типы
            $datas = Helpers_View::getViewObjects($list, $model,
                '_shop/_table/catalog/menu/top/list/root', '_shop/_table/catalog/menu/top/one/root', $this->_sitePageData, $this->_driverDB,
                $this->_sitePageData->shopMainID);
            $this->_sitePageData->addReplaceDatas('view::' . $pathTop.$viewObjects, $datas);
            $this->_sitePageData->addKeyInGlobalDatas('view::' . $pathTop.$viewObjects);
        }
    }

    /**
     * Меню заказов
     */
    public function _getBillMenu(){
        // получаем список всех типов объектов
        $shopTableCatalogIDs = Request_Request::find('DB_Shop_Table_Catalog',$this->_sitePageData->shopMainID, $this->_sitePageData,
            $this->_driverDB, array('table_id' => Model_Shop_Bill::TABLE_ID, Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE), 0, TRUE);

        $result = '';
        foreach ($shopTableCatalogIDs->childs as $shopTableCatalogID){
            $shopBillIDs = Request_Request::find('DB_Shop_Bill', $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB,
                array('type' => $shopTableCatalogID->id, Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE));

            $model = new Model_Shop_Bill();
            $model->setDBDriver($this->_driverDB);
            $shopBillIDs->additionDatas['type'] = $shopTableCatalogID->id;
            $result = $result . Helpers_View::getViewObjects($shopBillIDs, $model, '_shop/bill/list/menu', '_shop/bill/one/menu',
                    $this->_sitePageData, $this->_driverDB);
        }

        $this->_sitePageData->addReplaceDatas('view::_shop/bill/list/menu', $result);
        $this->_sitePageData->addKeyInGlobalDatas('view::_shop/bill/list/menu');

        return $result;
    }

    /**
     * Формируем index старинцу
     * @param string $body
     */
    public function _putInIndex($body)
    {
        $tmp = $this->_sitePageData->dataLanguageID;
        $this->_sitePageData->dataLanguageID = Model_Language::LANGUAGE_RUSSIAN;

        // Меню типов объетов
        $this->_getShopTableCatalogMenu();

        // Меню заказов
        $this->_getBillMenu();

        $languageIDs = Arr::path($this->_sitePageData->operation->getAccessArray(), 'language_ids', NULL);
        if (is_array($languageIDs) && (! empty($languageIDs))) {
            $params = Request_RequestParams::setParams(
                array(
                    'id' => $languageIDs,
                )
            );
            $languages = View_View::find('DB_Language',
                $this->_sitePageData->shopMainID,
                'languages', 'language',
                $this->_sitePageData, $this->_driverDB, $params
            );
        }else{
            $languages = View_View::findAll('DB_Language',
                $this->_sitePageData->shopMainID,
                "languages", "language",
                $this->_sitePageData, $this->_driverDB);
        }

        if ($this->_sitePageData->shopID > 0) {

            $shop = View_View::findOne('DB_Shop', $this->_sitePageData->shopID, 'menu', $this->_sitePageData, $this->_driverDB);
            $shopMenuTop = View_View::findOne('DB_Shop', $this->_sitePageData->shopID, 'menu-top', $this->_sitePageData, $this->_driverDB);
        } else {
            $this->_sitePageData->replaceDatas['view::menu'] = '';
            $this->_sitePageData->replaceDatas['view::menu-top'] = '';
        }

        $this->_sitePageData->globalDatas['view::menu'] = '^#@view::menu@#^';
        $this->_sitePageData->globalDatas['view::menu-top'] = '^#@view::menu-top@#^';

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
                'view::menu' => '^#@view::menu@#^',
                'view::menu-top' => '^#@view::menu-top@#^',
                'view::main' => '^#@view::main_body@#^',
                'view::languages' => '^#@view::main_languages@#^',
                'view::phones' => '^#@view::main_phones@#^',
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

        $result = str_replace('^#@view::main_languages@#^', $languages,
                str_replace('^#@view::main_phones@#^', '',
                    str_replace('^#@view::menu@#^', $shop,
                        str_replace('^#@view::menu-top@#^', $shopMenuTop,
                            str_replace('^#@view::main_body@#^', $body, $index)
                        )
                    )
                )
            );

        $this->_sitePageData->dataLanguageID = $tmp;

        return $result;
    }

    /**
     * Формируем index старинцу
     * @param $file
     */
    public function _putInMain($file)
    {
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
        $this->_sitePageData->url = '/cabinet/' . $this->controllerName . '/group';

        switch ($this->tableID) {
            case Model_Shop_Good::TABLE_ID:
                $result = View_View::findOne('DB_Shop_Good', $this->_sitePageData->shopID, '_shop/'.$this->objectName.'/one/group', $this->_sitePageData, $this->_driverDB,
                    array('id' => Request_RequestParams::getParamInt('id'), Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE));
                break;
            default:
                throw new HTTP_Exception_404('Object not is found!');
        }

        $this->response->body($result);
    }

    /**
     * @throws HTTP_Exception_404
     */
    public function action_json()
    {
        $this->_sitePageData->url = '/cabinet/' . $this->controllerName . '/group';

        // id записи
        $id = Request_RequestParams::getParamInt('id');
        $model = Model_ModelList::createModel($this->tableID, $this->_driverDB);
        if (! $this->dublicateObjectLanguage($model, $id)) {
            throw new HTTP_Exception_404('Object not is found!');
        }

        $this->response->body(json_encode($model->getValues(TRUE, TRUE)));
    }


    /**
     * Поиск объектов для сгруппированных объектов
     * @throws HTTP_Exception_404
     */
    public function action_findgroup() {
        $this->_sitePageData->url = '/cabinet/' . $this->controllerName . '/findgroup';

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
        $this->_sitePageData->url = '/cabinet/' . $this->controllerName . '/similar';

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
        $this->_sitePageData->url = '/cabinet/' . $this->controllerName . '/findsimilar';

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
        $this->_sitePageData->url = '/cabinet/' . $this->controllerName . '/savesort';

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

        $this->redirect('/cabinet/' . $this->controllerName . '/sort' . URL::query($arr, FALSE));
    }

    /**
     * Получение списка ввиде данных для select
     * @throws HTTP_Exception_404
     */
    public function action_select_options() {
        $this->_sitePageData->url = '/cabinet/' . $this->controllerName . '/select_options';

        switch ($this->tableID) {
            case Model_Shop_Model::TABLE_ID:
                $result = View_View::find('DB_Shop_Model',
                    $this->_sitePageData->shopID,
                    '_shop/'.$this->objectName.'/list/select-option',
                    '_shop/'.$this->objectName.'/one/select-option',
                    $this->_sitePageData, $this->_driverDB, array('limit_page' => 10000), array()
                );
                break;
            case Model_City::TABLE_ID:
                $params = Request_RequestParams::setParams(
                    array(
                        'sort_by' => array('name' => 'asc'),
                        'limit_page' => 10000,
                    ),
                    FALSE
                );
                $result = View_View::find('DB_City',
                    $this->_sitePageData->shopID,
                    $this->objectName.'/list/select-option',
                    $this->objectName.'/one/select-option',
                    $this->_sitePageData, $this->_driverDB, $params, array()
                );
                break;
            default:
                $result = '';
        }

        $this->response->body($result);
    }

    /**
     * Получение списка ввиде данных
     * @throws HTTP_Exception_404
     */
    public function action_list() {
        $this->_sitePageData->url = '/cabinet/' . $this->controllerName . '/list';

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
        $this->_sitePageData->url = '/cabinet/' . $this->controllerName . '/savelist';

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
            case Model_Shop_Table_Stock::TABLE_ID:
                Api_Shop_Table_Stock::saveList($this->_sitePageData, $this->_driverDB);
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

            $this->redirect('/cabinet/' . $this->controllerName . '/index_edit' . URL::query($arr, FALSE));
        }
    }

    /**
     * Добавление группы изображений по id или по штрихкоду
     */
    public function action_addimages()
    {
        $this->_sitePageData->url = '/cabinet/' . $this->controllerName . '/addimages';

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
            case Model_Shop_Table_Stock::TABLE_ID:
                $result = Api_Shop_Table_Stock::addImages($this->_sitePageData, $this->_driverDB);
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
        $this->_sitePageData->url = '/cabinet/' . $this->controllerName . '/addimg';

        $model = Model_ModelList::createModel($this->tableID, $this->_driverDB);

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
     * @param null $typeID
     * @param string $typeName
     * @return array
     * @throws HTTP_Exception_404
     */
    protected function _getType($typeID = NULL, $typeName = 'type'){
        if($typeID === NULL) {
            $typeID = Request_RequestParams::getParamInt('type');
            if($typeID === NULL) {
                $typeID = intval(Request_RequestParams::getParamInt('shop_table_catalog_id'));
            }
        }
        if ($typeID > 0) {
            $model = new Model_Shop_Table_Catalog();
            $model->setDBDriver($this->_driverDB);
            if(! $this->dublicateObjectLanguage($model, $typeID, $this->_sitePageData->shopMainID, $this->_sitePageData->languageID)){
                throw new HTTP_Exception_404('Table catalog not is found!');
            }
            $result = $model->getValues(TRUE, TRUE, $this->_sitePageData->shopMainID);
        }else{
            $result = array('id' => 0);
        }

        $this->_sitePageData->replaceDatas['view::'.$typeName] = $result;

        return $result;
    }

    /**
     * Делаем запрос на список рубрик
     * @param $typeID
     * @param null $currentID
     * @param array $params
     */
    protected function _requestShopTableRubric($typeID, $currentID = NULL, array $params = array()){
        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/_table/rubric/list/list',
            )
        );

        if($typeID > 0){
            $typeID = array(0, $typeID);
        }else{
            $typeID = null;
        }

        $params = Request_RequestParams::setParams(
            array_merge(
                [
                    'type' => $typeID,
                    'table_id' => $this->tableID,
                ],
                $params
            )
        );

        $data = View_View::find(
            'DB_Shop_Table_Rubric', $this->_sitePageData->shopID,
            "_shop/_table/rubric/list/list", "_shop/_table/rubric/one/list", $this->_sitePageData, $this->_driverDB,
            $params
        );

        if($currentID !== NULL){
            if(is_array($currentID)){
                foreach ($currentID as $child) {
                    $s = 'data-id="' . $child . '"';
                    $data = str_replace($s, $s . ' selected', $data);
                }
            }else {
                $s = 'data-id="' . $currentID . '"';
                $data = str_replace($s, $s . ' selected', $data);
            }
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

        $typeID = intval(Arr::path($type, 'child_shop_table_catalog_ids.brand.id',
                Arr::path($type, 'child_shop_table_catalog_ids.'.$this->_sitePageData->languageID.'.brand.id', 0)));
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

        $typeID = intval(Arr::path($type, 'child_shop_table_catalog_ids.filter.id',
                Arr::path($type, 'child_shop_table_catalog_ids.'.$this->_sitePageData->languageID.'.filter.id', 0)));
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
     * @param null $currentIDs
     * @param bool $isLoadAll
     * @return string
     */
    protected function _requestShopTableHashtag(array $type, $currentIDs = NULL, $isLoadAll = FALSE){
        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/_table/hashtag/list/list',
            )
        );
        if(!$isLoadAll && (empty($currentIDs))){
            return '';
        }

        $typeID = intval(Arr::path($type, 'child_shop_table_catalog_ids.hashtag.id',
                Arr::path($type, 'child_shop_table_catalog_ids.'.$this->_sitePageData->languageID.'.hashtag.id', 0)));
        if($typeID < 1){
            return '';
        }

        if($isLoadAll) {
            $params = Request_RequestParams::setParams(
                array(
                    'type' => array($typeID),
                    'table_id' => $this->tableID,
                )
            );
        }else{
            $params = Request_RequestParams::setParams(
                array(
                    'type' => array($typeID),
                    'table_id' => $this->tableID,
                    'id' => $currentIDs,
                )
            );
        }
        $data = View_View::find('DB_Shop_Table_Hashtag', $this->_sitePageData->shopID,
            "_shop/_table/hashtag/list/list", "_shop/_table/hashtag/one/list",
            $this->_sitePageData, $this->_driverDB, $params);

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

        $typeID = intval(Arr::path($type, 'child_shop_table_catalog_ids.select.id',
                Arr::path($type, 'child_shop_table_catalog_ids.'.$this->_sitePageData->languageID.'.select.id', 0)));
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
     * @param null $currentID
     * @return mixed|string
     */
    protected function _requestShopTableUnit(array $type, $currentID = NULL){
        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/_table/unit/list/list',
            )
        );

        $typeID = intval(Arr::path($type, 'child_shop_table_catalog_ids.unit.id',
                Arr::path($type, 'child_shop_table_catalog_ids.'.$this->_sitePageData->languageID.'.unit.id', 0)));
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
     * @param null $model
     * @param bool $isShopTableParam
     */
    protected function _requestTableObjects(array $type, $model = NULL, $isShopTableParam = FALSE)
    {
        if ($model === NULL) {
            $this->_requestShopTableRubric($type['id']);
            $this->_requestShopTableBrand($type);
            $this->_requestShopTableFilter($type);
            $this->_requestShopTableSelect($type);
            $this->_requestShopTableUnit($type);

            if ($isShopTableParam){
                $this->_requestShopTableParams($type);
            }
        } else {
            $this->_requestShopTableRubric($type['id'], $model->getShopTableRubricID());
            $this->_requestShopTableBrand($type, $model->getShopTableBrandID());
            $this->_requestShopTableFilter($type, $model->getShopTableFilterIDsArray());
            $this->_requestShopTableHashtag($type, $model->getShopTableHashtagIDsArray());
            $this->_requestShopTableSelect($type, $model->getShopTableSelectID());
            $this->_requestShopTableUnit($type, $model->getShopTableUnitID());


            if ($isShopTableParam){
                $this->_requestShopTableParams($type, $model);
            }
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

        $typeID = intval(Arr::path($type, 'child_shop_table_catalog_ids.filter.id',
                Arr::path($type, 'child_shop_table_catalog_ids.'.$this->_sitePageData->languageID.'.filter.id', 0)));
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
                $ids = Request_Request::find('DB_Shop_Table_ObjectToObject', $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB,
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
     * Список подобных товаров
     * @param $shopObjectID
     */
    protected function _requestTableSimilars($modelObject = NULL, $isReadIsModel = TRUE)
    {
        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/'.$this->objectName.'/list/similar',
            )
        );

        if ($modelObject !== NULL) {
            if($isReadIsModel){
                $ids = new MyArray($modelObject->getShopTableSimilarIDsArray());
            }else {
                $ids = Request_Request::find('DB_Shop_Table_Similar', $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB,
                    array('shop_root_object_id' => $modelObject->id, 'root_table_id' => $this->tableID, Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE));
            }
        }else {
            $ids = new MyArray();
        }

        $this->_sitePageData->replaceDatas['view::_shop/'.$this->objectName.'/list/similar'] =
            Helpers_View::getViewObjects($ids, Model_ModelList::createModel($this->tableID, $this->_driverDB),
            '_shop/'.$this->objectName.'/list/similar', '_shop/'.$this->objectName.'/one/similar', $this->_sitePageData, $this->_driverDB);
    }

    /**
     * Список сгруппированных товаров
     * @param $shopObjectID
     */
    protected function _requestTableObjectGroups($modelObject = NULL, $isReadIsModel = TRUE)
    {
        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/'.$this->objectName.'/list/group',
            )
        );

        if ($modelObject !== NULL) {
            if($isReadIsModel){
                $ids = new MyArray($modelObject->getShopTableGroupIDsArray());
            }else {
                // товары сгруппированные
                $ids = Request_Request::find('DB_Shop_Table_Group', $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB,
                    array('shop_root_object_id' => $modelObject->id, 'root_table_id' => $this->tableID, Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE));
            }


            $result = Helpers_View::getViewObjects($ids, Model_ModelList::createModel($this->tableID, $this->_driverDB),
                '_shop/'.$this->objectName.'/list/group', '_shop/'.$this->objectName.'/one/group', $this->_sitePageData, $this->_driverDB);
        }else {
            $result = '';
        }

        $this->_sitePageData->replaceDatas['view::_shop/'.$this->objectName.'/list/group'] = $result;
    }


    /**
     * Делаем запрос на список данных объекта
     * @param array $type
     * @param Model_Shop_Table_Basic_Table|NULL $model
     */
    protected function _requestTableObject(array $type, $model = NULL)
    {
        if ($model === NULL) {
            $this->_requestShopTableObjectToFilter($type);
            $this->_requestTableSimilars();
            $this->_requestTableObjectGroups();
        } else {
            $this->_requestShopTableObjectToFilter($type, $model);
            $this->_requestTableSimilars($model);
            $this->_requestTableObjectGroups($model);
        }

        // список объектов
        $this->_requestTableObjects($type, $model);
    }

    /**
     * Возвращаем результать сохранения
     * @param array $result
     * @param string $urlAction
     */
    protected function _redirectSaveResult(array $result, $urlAction = ''){
        if (Request_RequestParams::getParamBoolean('json') || $result['result']['error']) {
            $this->response->body(Json::json_encode($result['result']));
        } else {
            $branchID = '';
            if($this->_sitePageData->branchID > 0){
                $branchID = '&shop_branch_id='.$this->_sitePageData->branchID;
            }

            $params = array(
                'is_public_ignore' => TRUE,
            );
            foreach($result as $key => $value){
                if(!is_array($value)){
                    $params[$key] = $value;
                }
            }
            $params = URL::query($params, FALSE).$branchID;

            if (empty($urlAction)) {
                if (Request_RequestParams::getParamBoolean('is_close') === FALSE) {
                    $params = 'edit' . $params;
                } else {
                    $params = 'index' . $params;
                }
            }else{
                $params = $urlAction . $params;
            }

            $this->redirect('/'.$this->_sitePageData->actionURLName.'/'.$this->controllerName.'/'.$params);
        }
    }

    /**
     * Получаем JSON массив элементов и возвращаем массив имен с id
     * @throws HTTP_Exception_404
     */
    public function action_find_list_json() {
        $this->_sitePageData->url = '/cabinet/' . $this->controllerName . '/find_list_json';

        $params = Request_RequestParams::setParams(
            array(
                'sort_by' => array(
                    'name' => 'asc'
                ),
            ),
            FALSE
        );
        switch ($this->tableID) {
            case Model_Shop_Table_Hashtag::TABLE_ID:
                $ids = Request_Request::find('DB_Shop_Table_Hashtag', $this->_sitePageData->shopID,
                    $this->_sitePageData, $this->_driverDB, $params, 500, TRUE);
                break;
            default:
                throw new HTTP_Exception_404('Object not is found!');
        }

        $result = array();
        if(Request_RequestParams::getParamBoolean('is_add')){
            $name = Request_RequestParams::getParamStr('name');
            if (!empty($name)){
                $result[] = array(
                    'id' => $name,
                    'text' => $name,
                );
            }
        }

        foreach ($ids->childs as $child){
            $result[] = array(
                'id' => $child->id,
                'text' => $child->values['name'],
            );
        }

        $this->response->body(Json::json_encode($result));
    }

    /**
     * Делаем запрос на список параметров
     * @param $index
     * @param $typeID
     * @param null $currentID
     * @return mixed|string
     */
    protected function _requestShopTableParam($index, $typeID, $currentID = NULL){
        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/_table/param/'.$index.'/list/list',
            )
        );

        if($typeID < 1){
            return '';
        }

        $params = Request_RequestParams::setParams(
            array(
                'type' => array($typeID),
                'param_index' => $index,
            )
        );
        $data = View_View::find('DB_Shop_Table_Param', $this->_sitePageData->shopID,
            "_shop/_table/param/list/list", "_shop/_table/param/one/list",
            $this->_sitePageData, $this->_driverDB, $params);

        if($currentID !== NULL){
            $s = 'data-id="'.$currentID.'"';
            $data = str_replace($s, $s.' selected', $data);
        }
        $this->_sitePageData->replaceDatas['view::_shop/_table/param/'.$index.'/list/list'] = $data;

        return $data;
    }

    /**
     * Делаем запрос на список параметров
     * @param array $type
     * @param null $model
     * @return mixed|string
     */
    protected function _requestShopTableParams(array $type, $model = NULL){
        $types = Arr::path($type, 'child_shop_table_catalog_ids',
                Arr::path($type, 'child_shop_table_catalog_ids.'.$this->_sitePageData->languageID, array()));
        if(empty($types) || (!is_array($types))){
            return FALSE;
        }

        foreach ($types as $name => $value){
            if(strpos($name, 'param') === FALSE){
                continue;
            }

            $index = floatval(str_replace('param', '', $name));
            if ($index < 1){
                continue;
            }

            if (Arr::path($value, 'is_public', FALSE)) {
                if ($model === NULL){
                    $currentID = NULL;
                }else {
                    $currentID = $model->getShopTableParamID($index);
                }

                $this->_requestShopTableParam($index, $value['id'], $currentID);
            }
        }
    }

    /**
     * Делаем запрос на список языков магазина
     */
    protected function _requestTranslateTr(){
        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::language/list/tr-translate',
            )
        );

        $languageIDs = Arr::path($this->_sitePageData->operation->getAccessArray(), 'language_ids', NULL);
        if (is_array($languageIDs) && (! empty($languageIDs))) {
            $params = Request_RequestParams::setParams(
                array(
                    'id' => $languageIDs,
                )
            );
            View_View::find('DB_Language',
                $this->_sitePageData->shopMainID,
                'language/list/tr-translate', 'language/one/tr-translate',
                $this->_sitePageData, $this->_driverDB, $params
            );
        }else {
            View_View::findAll('DB_Language', $this->_sitePageData->shopID, "language/list/tr-translate",
                "language/one/tr-translate", $this->_sitePageData, $this->_driverDB);
        }
    }

    /**
     * Делаем запрос на список языков магазина для поиска списка записей
     */
    protected function _requestTranslateDataLanguages(){
        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::language/list/data',
            )
        );

        $languageIDs = Arr::path($this->_sitePageData->operation->getAccessArray(), 'language_ids', NULL);
        if (empty($languageIDs)) {
            $languageIDs = $this->_sitePageData->shopMain->getLanguageIDsArray();
        }
        if (empty($languageIDs)) {
            $languageIDs = $this->_sitePageData->dataLanguageID;
        }

        $params = Request_RequestParams::setParams(
            array(
                'id' => $languageIDs,
            )
        );
        $data = View_View::find('DB_Language',
            $this->_sitePageData->shopMainID,
            'language/list/data', 'language/one/data',
            $this->_sitePageData, $this->_driverDB, $params
        );

        $s = 'data-id="'.$this->_sitePageData->dataLanguageID.'"';
        $data = str_replace($s, $s.' selected', $data);
        $this->_sitePageData->replaceDatas['view::language/list/data'] = $data;
    }
}