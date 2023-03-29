<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Cabinet_ShopOperationStock extends Controller_Cabinet_BasicCabinet {

    public function __construct(Request $request, Response $response)
    {
        $this->dbObject = 'DB_Shop_Operation_Stock';
        $this->controllerName = 'shopoperationstock';
        $this->tableID = Model_Shop_Operation_Stock::TABLE_ID;
        $this->tableName = Model_Shop_Operation_Stock::TABLE_NAME;
        $this->objectName = 'operationstock';

        parent::__construct($request, $response);
        $this->_sitePageData->controllerName = $this->controllerName;
    }

    public function action_index(){
        $this->_sitePageData->url = '/cabinet/shopoperationstock/index';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/operation/stock/list/index',
            )
        );

        // тип объекта
        $type = $this->_getType();
        $this->_requestShopBranch();
        $this->_requestShopOperation();

        if(Request_RequestParams::getParamBoolean('is_branch') === TRUE){
            View_View::findBranch('DB_Shop_Operation_Stock', $this->_sitePageData->shopID, '_shop/operation/stock/list/index', '_shop/operation/stock/one/index',
                $this->_sitePageData, $this->_driverDB, array('limit_page' => 25), array('shop_id', 'shop_operation_id'));
        }else {
            View_View::find('DB_Shop_Operation_Stock', $this->_sitePageData->shopID, '_shop/operation/stock/list/index', '_shop/operation/stock/one/index',
                $this->_sitePageData, $this->_driverDB, array('limit_page' => 25), array('shop_operation_id'));
        }

        $this->_putInMain('/main/_shop/operation/stock/index');
    }

    public function action_edit()
    {
        $this->_sitePageData->url = '/cabinet/shopoperationstock/edit';

        // id записи
        $id = Request_RequestParams::getParamInt('id');
        if ($id === NULL) {
            throw new HTTP_Exception_404('Operation stock not is found!');
        }else {
            $model = new Model_Shop_Operation_Stock();
            if (!$this->getDBObject($model, $id)) {
                throw new HTTP_Exception_404('Operation stock not is found!');
            }
        }

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/operation/stock/one/edit',
                'view::_shop/operation/stock/item/list/index',
            )
        );

        $this->_getType($model->getShopTableCatalogID());
        $this->_requestShopOperation($model->getShopOperationID());

        // получаем список товаров
        View_View::find('DB_Shop_Operation_Stock_Item', $this->_sitePageData->shopID, "_shop/operation/stock/item/list/index", "_shop/operation/stock/item/one/index",
            $this->_sitePageData, $this->_driverDB, array('is_delete' => $model->getIsDelete(), 'shop_operation_stock_id' => $id, Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE),
            array('shop_operation_stock_id', 'shop_good_id', 'shop_table_catalog_id'));

        // получаем данные
        View_View::findOne('DB_Shop_Operation_Stock', $this->_sitePageData->shopID, "_shop/operation/stock/one/edit",
            $this->_sitePageData, $this->_driverDB, array('id' => $id), array('shop_table_catalog_id'));

        $this->_putInMain('/main/_shop/operation/stock/edit');
    }

    /**
     * Изменение
     */
    public function action_save(){
        $this->_sitePageData->url = '/cabinet/shopoperationstock/save';
        $result = Api_Shop_Operation_Stock::save($this->_sitePageData, $this->_driverDB);
        $this->_redirectSaveResult($result);
    }

    public function action_del() {
        $this->_sitePageData->url = '/cabinet/shopoperationstock/del';
        Api_Shop_Operation_Stock::delete($this->_sitePageData, $this->_driverDB);
        $this->response->body(Json::json_encode(array('error' => FALSE)));
    }

    /**
     * Выдача заказа в excel файле
     * @throws HTTP_Exception_500
     */
    public function action_load_operation_stock_in_excel(){
        $this->_sitePageData->url = '/cabinet/shopoperationstock/load_operation_stock_in_excel';

        $filePath = APPPATH.'views' . DIRECTORY_SEPARATOR . $this->_sitePageData->shopShablonPath . DIRECTORY_SEPARATOR
            . 'load-in-file' . DIRECTORY_SEPARATOR . $this->_sitePageData->dataLanguageID . DIRECTORY_SEPARATOR . Request_RequestParams::getParamStr('file');
        if(!file_exists($filePath)){
            throw new HTTP_Exception_500('File shablon not is found.');
        }

        // id записи
        $id = Request_RequestParams::getParamInt('id');
        if ($id === NULL) {
            throw new HTTP_Exception_404('Operation stock not is found!');
        }else {
            $model = new Model_Shop_Operation_Stock();
            if (!$this->getDBObject($model, $id)) {
                throw new HTTP_Exception_404('Operation stock not is found!');
            }
            $model->dbGetElements($this->_sitePageData->shopMainID,
                array('shop_operation_id','shop_id'),
                $this->_sitePageData->languageIDDefault);
        }

        // получаем список товаров в заказе
        $shopOperationStockItems = Request_Request::find('DB_Shop_Operation_Stock_Item', $this->_sitePageData->shopID,
            $this->_sitePageData, $this->_driverDB, array('shop_operation_stock_id' => $id, Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE));

        $modelItem = new Model_Shop_Operation_Stock_Item();
        $modelItem->setDBDriver($this->_driverDB);
        $operationStockItems = array();
        $countOperationStockItems = 0;
        foreach($shopOperationStockItems->childs as $shopOperationStockItem){
            Helpers_View::getDBDataIfNotFind($shopOperationStockItem, $modelItem, $this->_sitePageData, $this->_sitePageData->shopID,
                array('shop_operation_stock_id', 'shop_table_child_id'));
            $operationStockItems[] = $modelItem->getValues(TRUE, TRUE);
            $countOperationStockItems = $countOperationStockItems + $modelItem->getCountElement();
        }

        $operationStock = $model->getValues(TRUE, TRUE);
        $operationStock['amount_str'] = Func::numberToStr($model->getAmount(), TRUE, $this->_sitePageData->currency);
        $operationStock['count'] = $countOperationStockItems;
        $operationStock['count_str'] = Func::numberToStr($countOperationStockItems);
        Helpers_Excel::saleInFile($filePath,
            array('operation_stock' => $operationStock),
            array('operation_stock_items' => $operationStockItems));

        exit();
    }

    /**
     * Делаем запрос на список филиалов
     * @param array $type
     * @return string
     */
    protected function _requestShopBranch($currentID = NULL){
        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/branch/list/list',
            )
        );

        $data = View_View::find('DB_Shop', $this->_sitePageData->shopID,
            "_shop/branch/list/list", "_shop/branch/one/list", $this->_sitePageData, $this->_driverDB,
            array('sort_by' => array('value' => array('order' => 'asc', 'name' => 'asc')), Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE));

        if($currentID !== NULL){
            $s = 'data-id="'.$currentID.'"';
            $data = str_replace($s, $s.' selected', $data);
            $this->_sitePageData->replaceDatas['view::_shop/branch/list/list'] = $data;
        }

        return $data;
    }

    /**
     * Делаем запрос на список филиалов
     * @param array $type
     * @return string
     */
    protected function _requestShopOperation($currentID = NULL){
        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/operation/list/list',
            )
        );

        $data = View_View::find('DB_Shop_Operation', $this->_sitePageData->shopID,
            "_shop/operation/list/list", "_shop/operation/one/list", $this->_sitePageData, $this->_driverDB,
            array('sort_by' => array('value' => array('order' => 'asc', 'name' => 'asc')), Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE));

        if($currentID !== NULL){
            $s = 'data-id="'.$currentID.'"';
            $data = str_replace($s, $s.' selected', $data);
            $this->_sitePageData->replaceDatas['view::_shop/operation/list/list'] = $data;
        }

        return $data;
    }
}
