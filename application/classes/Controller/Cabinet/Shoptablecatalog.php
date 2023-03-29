<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Cabinet_ShopTableCatalog extends Controller_Cabinet_File {
    public function __construct(Request $request, Response $response)
    {
        $this->dbObject = DB_Shop_Table_Catalog::NAME;
        $this->controllerName = 'shoptablecatalog';
        $this->tableID = Model_Shop_Table_Catalog::TABLE_ID;
        $this->tableName = Model_Shop_Table_Catalog::TABLE_NAME;

        parent::__construct($request, $response);
        $this->_sitePageData->controllerName = $this->controllerName;
    }

    public function action_index() {
        $this->_sitePageData->url = '/cabinet/shoptablecatalog/index';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/_table/catalog/list/index',
            )
        );
        $this->_requestTranslateDataLanguages();

        // получаем список заказов
        View_View::find('DB_Shop_Table_Catalog', $this->_sitePageData->shopID, "_shop/_table/catalog/list/index", "_shop/_table/catalog/one/index",
            $this->_sitePageData, $this->_driverDB, array('limit_page' => 25));

        $this->_putInMain('/main/_shop/_table/catalog/index');
    }

    public function action_new() {
        $this->_sitePageData->url = '/cabinet/shoptablecatalog/new';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/_table/catalog/one/new',
            )
        );

        // получаем языки перевода
        $this->getLanguagesByShop('', FALSE);

        $dataID = new MyArray();
        $dataID->id = 0;
        $dataID->isFindDB = TRUE;

        $model = new Model_Shop_Table_Catalog();
        $data = Helpers_View::getViewObject($dataID, $model,
            '_shop/_table/catalog/one/new', $this->_sitePageData, $this->_driverDB);
        $this->_sitePageData->replaceDatas['view::_shop/_table/catalog/one/new'] = $data;

        $this->_putInMain('/main/_shop/_table/catalog/new');
    }

    public function action_edit() {
        $this->_sitePageData->url = '/cabinet/shoptablecatalog/edit';

        // id записи
        $id = Request_RequestParams::getParamInt('id');
        if ($id === NULL) {
            throw new HTTP_Exception_404('Tables catalog not is found!');
        }else {
            $model = new Model_Shop_Table_Catalog();
            if (! $this->dublicateObjectLanguage($model, $id)) {
                throw new HTTP_Exception_404('Tables catalog not is found!');
            }
        }

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/_table/catalog/one/edit',
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

        // получаем список
        View_View::findOne('DB_Shop_Table_Catalog', $this->_sitePageData->shopID, "_shop/_table/catalog/one/edit",
            $this->_sitePageData, $this->_driverDB, array('id' => $id));

        $this->_putInMain('/main/_shop/_table/catalog/edit');
    }

    /**
     * изменение
     */
    public function action_save() {
        $this->_sitePageData->url = '/cabinet/shoptablecatalog/save';

        $model = new Model_Shop_Table_Catalog();

        $id = Request_RequestParams::getParamInt('id');
        if (! $this->dublicateObjectLanguage($model, $id)) {
            throw new HTTP_Exception_500('Tables catalog not found.');
        }

        Request_RequestParams::setParamBoolean('is_public', $model);
        Request_RequestParams::setParamStr('name', $model);

        if ($model->id < 1) {
            $tableID = Request_RequestParams::getParamInt('table_id');
            $model->setTableID($tableID);
        }else{
            $tableID = $model->getTableID();
        }

        // дополнительные поля
        $options = Request_RequestParams::getParamArray('fields_options');
        if ($options !== NULL) {
            $model->setFieldsOptionsArray($options, FALSE);
        }

        // дополнительные поля участвующие в поиске
        $params = Request_RequestParams::getParamArray('fields_params');
        if ($params !== NULL) {
            $model->setFieldsParamsArray($params, FALSE);
        }

        // виды картинок
        $imageTypes = Request_RequestParams::getParamArray('image_types');
        if (($imageTypes !== NULL)) {
            $model->setImageTypesArray($imageTypes, FALSE);
        }

        // настройка формы
        $formData = Request_RequestParams::getParamArray('form_data');
        if (($formData !== NULL)) {
            $model->joinFormDataArray($formData);
        }

        // SEO настройки
        $seo = Request_RequestParams::getParamArray('seo');
        if (($seo !== NULL)) {
            $model->setSEOArray($seo, $this->_sitePageData->dataLanguageID);
        }

        $childs = Request_RequestParams::getParamArray('child_shop_table_catalog_ids');
        if($childs !== NULL) {
            $childShopTableCatalogIDs = $model->getChildShopTableCatalogIDsArray();
            foreach ($childs as $key => $child) {
                $isSaveAll = FALSE;
                switch ($key) {
                    case 'brand':
                        $optionsName = 'shop_table_brand';
                        $childTableID = Model_Shop_Table_Brand::TABLE_ID;
                        break;
                    case 'stock':
                        $optionsName = 'shop_table_stock';
                        $childTableID = Model_Shop_Table_Stock::TABLE_ID;
                        break;
                    case 'revision':
                        $optionsName = 'shop_table_revision';
                        $childTableID = Model_Shop_Table_Revision::TABLE_ID;
                        break;
                    case 'hashtag':
                        $optionsName = 'shop_table_hashtag';
                        $childTableID = Model_Shop_Table_Hashtag::TABLE_ID;
                        break;
                    case 'filter':
                        $optionsName = 'shop_table_filter';
                        $childTableID = Model_Shop_Table_Filter::TABLE_ID;
                        break;
                    case 'unit':
                        $optionsName = 'shop_table_unit';
                        $childTableID = Model_Shop_Table_Unit::TABLE_ID;
                        break;
                    case 'select':
                        $optionsName = 'shop_table_select';
                        $childTableID = Model_Shop_Table_Select::TABLE_ID;
                        break;
                    case 'child':
                        $optionsName = 'shop_table_child';
                        $childTableID = Model_Shop_Table_Child::TABLE_ID;
                        $isSaveAll = TRUE;
                        break;
                    case 'mark':
                        $optionsName = 'shop_mark';
                        $childTableID = Model_Shop_Mark::TABLE_ID;
                        $isSaveAll = TRUE;
                        break;
                    case 'model':
                        $optionsName = 'shop_model';
                        $childTableID = Model_Shop_Model::TABLE_ID;
                        $isSaveAll = TRUE;
                        break;
                    default:
                        if(strpos($key, 'param') === 0){
                            $index = intval(str_replace('param', '', $key));
                            if($index < 1){
                                continue 2;
                            }

                            $child['is_public'] = TRUE;
                            $optionsName = 'shop_table_param'.$index;
                            $childTableID = Model_Shop_Table_Param::TABLE_ID;
                            $isSaveAll = TRUE;
                        }else {
                            continue 2;
                        }
                }

                $modelChild = new Model_Shop_Table_Catalog();
                $isPublic = Arr::path($child, 'is_public', NULL);
                $childID = Arr::path($childShopTableCatalogIDs, $key.'.id', 0);
                $childName = Arr::path($child, 'name', NULL);

                // создаем / изменяем зависимый тип
                if (($childID > 0) || (($isPublic == TRUE) && ((!empty($childName)) || ($childID > 0)))) {
                    if (!$this->dublicateObjectLanguage($modelChild, $childID)) {
                        throw new HTTP_Exception_500('Tables catalog not found.');
                    }
                    if ($modelChild->id < 1) {
                        $modelChild->setRootShopTableCatalogID($model->id);
                        $modelChild->setRootTableID($tableID);
                        $modelChild->setTableID($childTableID);
                    }

                    $tmp = Arr::path($child, 'name', NULL);
                    if (!empty($tmp)) {
                        $modelChild->setName($tmp);
                    }

                    if ($isPublic !== NULL) {
                        $modelChild->setIsPublic($isPublic);
                    }

                    // дополнительные поля
                    $brandOptions = array();

                    $tmp = Arr::path($options, $optionsName, array());
                    if (is_array($tmp)) {
                        $brandOptions[$optionsName] = $tmp;
                    }
                    $tmp = Arr::path($options, $optionsName . '_rubric', array());
                    if (is_array($tmp)) {
                        $brandOptions['shop_table_rubric'] = $tmp;
                    }

                    $modelChild->setFieldsOptionsArray($brandOptions, FALSE);

                    // список видов картинок
                    $brandImageTypes = array();

                    $tmp = Arr::path($imageTypes, $optionsName, array());
                    if (is_array($tmp)) {
                        $brandImageTypes[$optionsName] = $tmp;
                    }
                    $tmp = Arr::path($imageTypes, $optionsName . '_rubric', array());
                    if (is_array($tmp)) {
                        $brandImageTypes['shop_table_rubric'] = $tmp;
                    }

                    $modelChild->setImageTypesArray($brandImageTypes, FALSE);

                    // настройка формы
                    $brandFormData = array();

                    $tmp = Arr::path($formData, $optionsName, array());
                    if (is_array($tmp)) {
                        if($isSaveAll){
                            $brandFormData = $formData;
                        }else {
                            $brandFormData[$optionsName] = $tmp;
                        }
                    }
                    $tmp = Arr::path($formData, $optionsName . '_rubric', array());
                    if (is_array($tmp)) {
                        $brandFormData['shop_table_rubric'] = $tmp;
                    }

                    $modelChild->joinFormDataArray($brandFormData);

                    // сео
                    $brandSEO = array();

                    $tmp = Arr::path($seo, $optionsName, array());
                    if (is_array($tmp)) {
                        $brandSEO[$optionsName] = $tmp;
                    }
                    $tmp = Arr::path($seo, $optionsName . '_rubric', array());
                    if (is_array($tmp)) {
                        $brandSEO['shop_table_rubric'] = $tmp;
                    }

                    $modelChild->setSEOArray($brandSEO, $this->_sitePageData->dataLanguageID);

                    $childShopTableCatalogIDs[$key]['id'] = $this->saveDBObject($modelChild);
                }
                $childShopTableCatalogIDs[$key]['is_public'] = $isPublic && !empty($childName);
                $childShopTableCatalogIDs[$key]['name'] = $childName;
            }

            $model->setChildShopTableCatalogIDsArray($childShopTableCatalogIDs);
        }

        $result = array();
        if ($model->validationFields($result)) {
            $model->setEditUserID($this->_sitePageData->userID);
            if($model->id < 1) {
                $this->saveDBObject($model);

                // подчиненным типам задаем родителя
                $ids = array();

                $childShopTableCatalogIDs = $model->getChildShopTableCatalogIDsArray();
                foreach ($childShopTableCatalogIDs as $child) {
                    $tmp = Arr::path($child, 'id', 0);
                    if($tmp > 0){
                        $ids[] = $tmp;
                    }
                }

                $this->_driverDB->updateObjects(Model_Shop_Table_Catalog::TABLE_NAME, $ids,
                    array('root_shop_table_catalog_id' => $model->id, 'root_table_id' => $tableID),
                    $this->_sitePageData->dataLanguageID, $this->_sitePageData->shopID);
            }

            $file = new Model_File($this->_sitePageData);
            $file->saveFiles(Request_RequestParams::getParamArray('files'), $model, $this->_sitePageData, $this->_driverDB);

            $this->saveDBObject($model);
            $result['values'] = $model->getValues();
        }

        if (Request_RequestParams::getParamBoolean('json') || $result['error']) {
            $this->response->body(Json::json_encode($result));
        } else {
            if(Request_RequestParams::getParamBoolean('is_close') === FALSE){
                $this->redirect('/cabinet/shoptablecatalog/edit?id='.$model->id);
            }else{
                $this->redirect('/cabinet/shoptablecatalog/index?table_id='.$tableID.'&id='.$model->id);
            }
        }
    }

    public function action_access() {
        $this->_sitePageData->url = '/cabinet/shoptablecatalog/access';

        $this->_getShopTableCatalogAccess();

        $data = new MyArray();
        $data->id = 0;
        $data->isFindDB = TRUE;

        $model = new Model_Shop_Table_Catalog();
        $data = Helpers_View::getViewObject($data, $model,
            '_shop/_table/catalog/menu/access/one/edit', $this->_sitePageData, $this->_driverDB);
        $this->_sitePageData->addReplaceAndGlobalDatas('view::_shop/_table/catalog/menu/access/one/edit', $data);

        $this->_putInMain('/main/_shop/_table/catalog/menu/access');
    }

    /**
     * Меню типов объетов
     * @throws Exception
     */
    public function _getShopTableCatalogAccess()
    {
        $path = '_shop/_table/catalog/menu/access/list/';
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
            $tmp->additionDatas['view::_shop/_table/catalog/menu/access/one/child'] = new MyArray();
        }

        // выбираем подчиненные объекты
        foreach ($shopTableCatalogIDs->childs as $shopTableCatalogID) {

            $rootShopTableCatalogID = $shopTableCatalogID->values['root_shop_table_catalog_id'];
            if ($rootShopTableCatalogID < 1) {
                continue;
            }

            foreach ($tableIDs as &$tableID) {
                $tmp = $tableID->findChild($rootShopTableCatalogID);
                if ($tmp !== NULL) {
                    $tmp->additionDatas['view::_shop/_table/catalog/menu/access/one/child']->addChildObject($shopTableCatalogID);
                }
            }
        }

        $model = new Model_Shop_Table_Catalog();
        $model->setDBDriver($this->_driverDB);

        foreach ($tableIDs as $tableID_ => $list) {
            $viewObjects = '';
            switch ($tableID_) {
                case Model_Shop_Car::TABLE_ID:
                    $viewObjects = $path.'shopcar';
                    break;
                case Model_Shop_Good::TABLE_ID:
                    $viewObjects = $path.'shopgood';
                    break;
                case Model_Shop_New::TABLE_ID:
                    $viewObjects = $path.'shopnew';
                    break;
                case Model_Shop_Gallery::TABLE_ID:
                    $viewObjects = $path.'shopgallery';
                    break;
                case Model_Shop_File::TABLE_ID:
                    $viewObjects = $path.'shopfile';
                    break;
                case Model_Shop_Calendar::TABLE_ID:
                    $viewObjects = $path.'shopcalendar';
                    break;
                case Model_Shop_Bill::TABLE_ID:
                    $viewObjects = $path.'shopbill';
                    break;
                case Model_Shop_Client::TABLE_ID:
                    $viewObjects = $path.'shopclient';
                    break;
                case Model_Shop_Comment::TABLE_ID:
                    $viewObjects = $path.'shopcomment';
                    break;
                case Model_Shop_Coupon::TABLE_ID:
                    $viewObjects = $path.'shopcoupon';
                    break;
                case Model_Shop_PersonDiscount::TABLE_ID:
                    $viewObjects = $path.'shoppersondiscount';
                    break;
                case Model_Shop_Message::TABLE_ID:
                    $viewObjects = $path.'shopmessage';
                    break;
                case Model_Shop_Operation::TABLE_ID:
                    $viewObjects = $path.'shopoperation';
                    break;
                case Model_Shop_Question::TABLE_ID:
                    $viewObjects = $path.'shopquestion';
                    break;
                case Model_Shop_Subscribe::TABLE_ID:
                    $viewObjects = $path.'shopsubscribe';
                    break;
                case Model_Shop::TABLE_ID:
                    $viewObjects = $path.'shopbranch';
                    break;
                case Model_Shop_Paid::TABLE_ID:
                    $viewObjects = $path.'shoppaid';
                    break;
                case Model_Shop_Return::TABLE_ID:
                    $viewObjects = $path.'shopreturn';
                    break;
                case Model_Shop_Operation_Stock::TABLE_ID:
                    $viewObjects = $path.'shopoperationstock';
                    break;
                default:
                    continue 2;
            }

            // под типы
            foreach ($list->childs as $one) {
                $datas = Helpers_View::getViewObjects($one->additionDatas['view::_shop/_table/catalog/menu/access/one/child'], $model, '_shop/_table/catalog/menu/access/list/child',
                    '_shop/_table/catalog/menu/access/one/child', $this->_sitePageData, $this->_driverDB, $this->_sitePageData->shopMainID);
                $one->additionDatas['view::_shop/_table/catalog/menu/access/one/child'] = $datas;
            }

            // основные типы
            $datas = Helpers_View::getViewObjects($list, $model,
                '_shop/_table/catalog/menu/access/list/root', '_shop/_table/catalog/menu/access/one/root', $this->_sitePageData, $this->_driverDB,
                $this->_sitePageData->shopMainID);
            $this->_sitePageData->addReplaceDatas('view::' . $viewObjects, $datas);
            $this->_sitePageData->addKeyInGlobalDatas('view::' . $viewObjects);
        }
    }
}
