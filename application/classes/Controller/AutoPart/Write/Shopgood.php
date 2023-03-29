<?php defined('SYSPATH') or die('No direct script access.');

class Controller_AutoPath_Write_ShopGood extends Controller_AutoPath_Write_File {

    public function __construct(Request $request, Response $response)
    {
        $this->controllerName = 'shopgood';
        $this->tableID = Model_Shop_Good::TABLE_ID;
        $this->tableName = Model_Shop_Good::TABLE_NAME;
        $this->objectName = 'good';

        parent::__construct($request, $response);
        $this->_sitePageData->controllerName = $this->controllerName;
    }

    public function action_photo()
    {
        $this->_sitePageData->url = '/stock_write/shopgood/photo';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/good/one/photo',
            )
        );

        // тип объекта
        $type = $this->_getType();
        $this->_requestShopTableStock($type);

        $dataID = new MyArray();
        $dataID->id = 0;
        // дополнительные поля
        Arr::set_path($dataID->values, Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_table_catalog_id', $type);
        $dataID->isFindDB = TRUE;

        $this->_sitePageData->replaceDatas['view::_shop/good/one/photo'] = Helpers_View::getViewObject($dataID, new Model_Shop(),
            '_shop/good/one/photo', $this->_sitePageData, $this->_driverDB);

        $this->_putInMain('/main/_shop/good/photo');
    }

    public function action_stock()
    {
        $this->_sitePageData->url = '/stock_write/shopgood/stock';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/good/one/stock',
            )
        );

        // тип объекта
        $type = $this->_getType();
        $this->_requestShopTableStock($type);

        $dataID = new MyArray();
        $dataID->id = 0;
        // дополнительные поля
        Arr::set_path($dataID->values, Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_table_catalog_id', $type);
        $dataID->isFindDB = TRUE;

        $this->_sitePageData->replaceDatas['view::_shop/good/one/stock'] = Helpers_View::getViewObject($dataID, new Model_Shop(),
            '_shop/good/one/stock', $this->_sitePageData, $this->_driverDB);

        $this->_putInMain('/main/_shop/good/stock');
    }

    public function action_index() {
        $this->_sitePageData->url = '/stock_write/shopgood/index';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/good/list/index',
            )
        );

        // тип объекта
        $type = $this->_getType();

        // получаем список
        View_View::find('DB_Shop_Good', $this->_sitePageData->shopID, "_shop/good/list/index", "_shop/good/one/index",
            $this->_sitePageData, $this->_driverDB, array('limit_page' => 25));

        $this->_putInMain('/main/_shop/good/index');
    }

    public function action_edit()
    {
        $this->_sitePageData->url = '/stock_write/shopgood/edit';

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

        // получаем данные
        View_View::findOne('DB_Shop_Good', $this->_sitePageData->shopID, "_shop/good/one/edit",
            $this->_sitePageData, $this->_driverDB, array('id' => $shopGoodID, Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE));

        $this->_putInMain('/main/_shop/good/edit');
    }

    public function action_save()
    {
        $this->_sitePageData->url = '/stock_write/shopgood/save';
        $result = Api_Shop_Good::save($this->_sitePageData, $this->_driverDB);
        $this->_redirectSaveResult($result);
    }

    public function action_save_stock()
    {
        $this->_sitePageData->url = '/stock_write/shopgood/save_stock';
        $result = Api_Shop_Good::markOutStock($this->_sitePageData, $this->_driverDB);
        if (!is_array($result)){
            $result = array_merge($_GET, $_POST);
            $result['result']['error'] = FALSE;
        }
        $this->_redirectSaveResult($result);
    }

    public function action_is_get() {
        $this->_sitePageData->url = '/stock_write/shopgood/is_get';

        $shopGood =  Request_Request::find('DB_Shop_Good',$this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB,
            array(), 1, TRUE);

        if (count($shopGood->childs) > 0){
            $result = array(
                'result' => TRUE,
                'values' => $shopGood->childs[0]->values,
            );
        }else{
            $result = array(
                'result' => FALSE,
                'values' => array(),
            );
        }

        $this->response->body(Json::json_encode($result));
    }

    /**
     * Делаем запрос на список хранилищ
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

        $typeID = intval(Arr::path($type, 'child_shop_table_catalog_ids.stock.id', 0));
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
}
