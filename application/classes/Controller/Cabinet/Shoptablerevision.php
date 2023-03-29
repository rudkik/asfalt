<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Cabinet_ShopTableRevision extends Controller_Cabinet_File {
    public function __construct(Request $request, Response $response)
    {
        $this->dbObject = 'DB_Shop_Table_Revision';
        $this->controllerName = 'shoptablerevision';
        $this->tableID = Model_Shop_Table_Revision::TABLE_ID;
        $this->tableName = Model_Shop_Table_Revision::TABLE_NAME;

        parent::__construct($request, $response);
        $this->_sitePageData->controllerName = $this->controllerName;
    }

    public function action_index() {
        $this->_sitePageData->url = '/cabinet/shoptablerevision/index';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/_table/revision/list/index',
            )
        );

        // тип объекта
        $type = $this->_getType();
        $this->_requestShopTableRubric($type['id']);

        // получаем список
        View_View::find('DB_Shop_Table_Revision', $this->_sitePageData->shopID,
            "_shop/_table/revision/list/index", "_shop/_table/revision/one/index", $this->_sitePageData, $this->_driverDB,
            array('type' => $type['id'], 'table_id' => Request_RequestParams::getParamInt('table_id'), 'limit_page' => 25), array('shop_table_rubric_id'));
        $this->_putInMain('/main/_shop/_table/revision/index');
    }

    public function action_new() {
        $this->_sitePageData->url = '/cabinet/shoptablerevision/new';

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
                'view::_shop/_table/revision/one/new',
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
            $this->_sitePageData, $this->_driverDB, array('type' => array(0, $typeID), 'table_id' => Request_RequestParams::getParamInt('table_id'), Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE));

        $dataID = new MyArray();
        $dataID->id = 0;
        // дополнительные поля
        Arr::set_path($dataID->values, Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_table_catalog_id', $model->getValues(TRUE, TRUE, $this->_sitePageData));
        $dataID->isFindDB = TRUE;

        $model = new Model_Shop_Table_Revision();
        $datas = Helpers_View::getViewObject($dataID, $model,
            '_shop/_table/revision/one/new', $this->_sitePageData, $this->_driverDB);
        $this->_sitePageData->replaceDatas['view::_shop/_table/revision/one/new'] = $datas;

        $this->_putInMain('/main/_shop/_table/revision/new');
    }

    public function action_edit() {
        $this->_sitePageData->url = '/cabinet/shoptablerevision/edit';

        // тип объекта
        $type = $this->_getType();

        // id записи
        $id = Request_RequestParams::getParamInt('id');
        if ($id === NULL) {
            throw new HTTP_Exception_404('Table revision not is found!');
        }else {
            $model = new Model_Shop_Table_Revision();
            if (! $this->dublicateObjectLanguage($model, $id)) {
                throw new HTTP_Exception_404('Table revision not is found!');
            }
        }

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/_table/revision/one/edit',
                'view::_shop/_table/revision/child/list/index',
            )
        );

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

        $this->_requestShopTableRubric($type['id'], $model->getShopTableRubricID());
        $this->_requestShopTableStock($type, $model->getShopTableStockID());

        // получаем данные
        View_View::findOne('DB_Shop_Table_Revision', $this->_sitePageData->shopID, "_shop/_table/revision/one/edit",
            $this->_sitePageData, $this->_driverDB, array('id' => $id), array('shop_table_catalog_id'));

        $shopTableStockIDs = Request_Shop_Table_Stock::findShopTableStockIDsByMain($this->_sitePageData->shopID,
            $this->_sitePageData, $this->_driverDB, array('root_id' => $model->getShopTableStockID(),
                Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE), 0, TRUE);
        $stockIDs = $shopTableStockIDs->getChildArrayID();
        $stockIDs[] = $model->getShopTableStockID();

        $ids = Request_Shop_Table_Revision_Child::findShopTableRevisionChildIDs($this->_sitePageData->shopID,
            $this->_sitePageData, $this->_driverDB, array('shop_child_object_id' => $id,
                Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE), 0, TRUE,
            array('old_shop_table_stock_id' => array('name')));
        $revision = array();
        foreach ($ids->childs as $child){
            $revision[$child->values['shop_root_object_id']] = Arr::path($child->values, 'old_shop_table_stock_id___name', '');
        }
        unset($ids);

        $shopGoodIDs = Request_Request::find('DB_Shop_Good',$this->_sitePageData->shopID,
            $this->_sitePageData, $this->_driverDB, array('shop_table_stock_id' => array('value' => $stockIDs),
                'sort_by' => array('value' => Request_RequestParams::getParamArray('sort_by')), 'limit_page' => 0,
                'work_type_id' => -1, Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE), 0, TRUE,
            array('shop_table_stock_id' => array('name')));

        $yesShopGoodIDs = array();
        $noShopGoodIDs = array();
        foreach ($shopGoodIDs->childs as $shopGoodID){
            $shopGoodID->additionDatas['is_check'] = key_exists($shopGoodID->id, $revision);
            if ($shopGoodID->additionDatas['is_check']){
                $shopGoodID->additionDatas['old_shop_table_stock_name'] = $revision[$shopGoodID->id];
                $yesShopGoodIDs[] = $shopGoodID;
            }else{
                $noShopGoodIDs[] = $shopGoodID;
            }
        }

        $page = Request_RequestParams::getParamInt('page');
        if ($page < 1){
            $page = 1;
        }
        $limitPage = Request_RequestParams::getParamInt('limit_page');
        if ($limitPage < 1){
            $limitPage = 25;
        }

        $shopGoodIDs->childs = array();
        $this->_sitePageData->limitPage = $limitPage;
        $this->_sitePageData->page = $page;
        $this->_sitePageData->pages = ceil($this->_sitePageData->countRecord / $limitPage);

        $countNo = count($noShopGoodIDs);
        $countYes = count($yesShopGoodIDs);
        for ($i = $limitPage * ($page - 1); $i < $limitPage * ($page - 1) + $limitPage; $i++){
            if ($i < $countNo){
                $shopGoodIDs->childs[] = $noShopGoodIDs[$i];
            }elseif ($i - $countNo < $countYes){
                $shopGoodIDs->childs[] = $yesShopGoodIDs[$i - $countNo];
            }else{
                break;
            }
        }

        $result = Helpers_View::getViewObjects($shopGoodIDs, new Model_Shop_Good(), "_shop/_table/revision/child/list/index",
            "_shop/_table/revision/child/one/index", $this->_sitePageData, $this->_driverDB);
        $this->_sitePageData->replaceDatas['view::_shop/_table/revision/child/list/index'] = $result;

        $this->_putInMain('/main/_shop/_table/revision/edit');
    }

    public function action_save() {
        $this->_sitePageData->url = '/cabinet/shoptablerevision/save';
        $result = Api_Shop_Table_Revision::save($this->_sitePageData, $this->_driverDB);
        $this->_redirectSaveResult($result);
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

        $typeID = intval(Arr::path($type, 'child_shop_table_catalog_ids.stock.id', -1));

        $data = View_View::find('DB_Shop_Table_Stock', $this->_sitePageData->shopID,
            "_shop/_table/stock/list/list", "_shop/_table/stock/one/list", $this->_sitePageData, $this->_driverDB,
            array('type' => array($typeID), 'sort_by' => array('value' => array('shop_table_rubric_id' => 'asc', 'name' => 'asc')),
                Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE),
            array('shop_table_rubric_id' => array('name')));

        if($currentID !== NULL){
            $s = 'data-id="'.$currentID.'"';
            $data = str_replace($s, $s.' selected', $data);
            $this->_sitePageData->replaceDatas['view::_shop/_table/stock/list/list'] = $data;
        }

        return $data;
    }
}
