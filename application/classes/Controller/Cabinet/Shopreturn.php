<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Cabinet_ShopReturn extends Controller_Cabinet_BasicCabinet {

    public function __construct(Request $request, Response $response)
    {
        $this->dbObject = 'DB_Shop_Return';
        $this->controllerName = 'shopreturn';
        $this->tableID = Model_Shop_Return::TABLE_ID;
        $this->tableName = Model_Shop_Return::TABLE_NAME;
        $this->objectName = 'return';

        parent::__construct($request, $response);
        $this->_sitePageData->controllerName = $this->controllerName;
    }

    public function action_index(){
        $this->_sitePageData->url = '/cabinet/shopreturn/index';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/return/list/index',
            )
        );

        // тип объекта
        $type = $this->_getType();
        $this->_requestShopBranch();

        if(Request_RequestParams::getParamBoolean('is_branch') === TRUE){
            View_View::findBranch('DB_Shop_Return', $this->_sitePageData->shopID, '_shop/return/list/index', '_shop/return/one/index',
                $this->_sitePageData, $this->_driverDB, array('limit_page' => 25), array('shop_id'));
        }else {
            View_View::find('DB_Shop_Return', $this->_sitePageData->shopID, '_shop/return/list/index', '_shop/return/one/index',
                $this->_sitePageData, $this->_driverDB, array('limit_page' => 25), array('shop_root_id'));
        }

        $this->_putInMain('/main/_shop/return/index');
    }

    public function action_edit()
    {
        $this->_sitePageData->url = '/cabinet/shopreturn/edit';

        // id записи
        $id = Request_RequestParams::getParamInt('id');
        if ($id === NULL) {
            throw new HTTP_Exception_404('Return not is found!');
        }else {
            $model = new Model_Shop_Return();
            if (!$this->getDBObject($model, $id)) {
                throw new HTTP_Exception_404('Return not is found!');
            }
        }

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/return/one/edit',
                'view::_shop/return/item/list/index',
            )
        );

        $type = $this->_getType($model->getShopTableCatalogID());
        $this->_requestShopBranch($model->getShopRootID());

        // получаем список товаров
        View_View::find('DB_Shop_Return_Item', $this->_sitePageData->shopID, "_shop/return/item/list/index", "_shop/return/item/one/index",
            $this->_sitePageData, $this->_driverDB, array('is_delete' => $model->getIsDelete(), 'shop_return_id' => $id, Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE),
            array('shop_return_id', 'shop_good_id', 'shop_table_catalog_id'));

        // получаем данные
        View_View::findOne('DB_Shop_Return', $this->_sitePageData->shopID, "_shop/return/one/edit",
            $this->_sitePageData, $this->_driverDB, array('id' => $id), array('shop_return_catalog_id'));

        $this->_putInMain('/main/_shop/return/edit');
    }

    /**
     * Изменение
     */
    public function action_save(){
        $this->_sitePageData->url = '/cabinet/shopreturn/save';
        $result = Api_Shop_Return::save($this->_sitePageData, $this->_driverDB);
        $this->_redirectSaveResult($result);
    }

    public function action_del() {
        $this->_sitePageData->url = '/cabinet/shopreturn/del';
        Api_Shop_Return::delete($this->_sitePageData, $this->_driverDB);
        $this->response->body(Json::json_encode(array('error' => FALSE)));
    }

    /**
     * Выдача заказа в excel файле
     * @throws HTTP_Exception_500
     */
    public function action_load_return_in_excel(){
        $this->_sitePageData->url = '/supplier/shopreturn/load_return_in_excel';

        $filePath = APPPATH.'views' . DIRECTORY_SEPARATOR . $this->_sitePageData->shopShablonPath . DIRECTORY_SEPARATOR
            . 'load-in-file' . DIRECTORY_SEPARATOR . $this->_sitePageData->dataLanguageID . DIRECTORY_SEPARATOR . Request_RequestParams::getParamStr('file');
        if(!file_exists($filePath)){
            throw new HTTP_Exception_500('File shablon not is found.');
        }

        // id записи
        $id = Request_RequestParams::getParamInt('id');
        if ($id === NULL) {
            throw new HTTP_Exception_404('Return not is found!');
        }else {
            $model = new Model_Shop_Return();
            if (!$this->getDBObject($model, $id)) {
                throw new HTTP_Exception_404('Return not is found!');
            }
            $model->dbGetElements($this->_sitePageData->shopMainID,
                array('return_status_id','shop_return_status_id','city_id','country_id','shop_coupon_id',
                    'shop_delivery_type_id','shop_paid_type_id','shop_root_id','shop_id'),
                $this->_sitePageData->languageIDDefault);
        }

        // получаем список товаров в заказе
        $shopReturnItems = Request_Request::find('DB_Shop_Return_Item', $this->_sitePageData->shopID,
            $this->_sitePageData, $this->_driverDB, array('shop_return_id' => $id, Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE));

        $modelItem = new Model_Shop_Return_Item();
        $modelItem->setDBDriver($this->_driverDB);
        $returnItems = array();
        $countReturnItems = 0;
        foreach($shopReturnItems->childs as $shopReturnItem){
            Helpers_View::getDBDataIfNotFind($shopReturnItem, $modelItem, $this->_sitePageData, $this->_sitePageData->shopID,
                array('shop_return_id', 'shop_return_child_id'));
            $returnItems[] = $modelItem->getValues(TRUE, TRUE);
            $countReturnItems = $countReturnItems + $modelItem->getCountElement();
        }

        $return = $model->getValues(TRUE, TRUE);
        $return['amount_str'] = Func::numberToStr($model->getAmount(), TRUE, $this->_sitePageData->currency);
        $return['count'] = $countReturnItems;
        $return['count_str'] = Func::numberToStr($countReturnItems);
        Helpers_Excel::saleInFile($filePath,
            array('return' => $return),
            array('return_items' => $returnItems));

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
}
