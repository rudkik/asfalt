<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Cabinet_ShopBill extends Controller_Cabinet_BasicCabinet {

    public function __construct(Request $request, Response $response)
    {
        $this->dbObject = 'DB_Shop_Bill';
        $this->controllerName = 'shopbill';
        $this->tableID = Model_Shop_Bill::TABLE_ID;
        $this->tableName = Model_Shop_Bill::TABLE_NAME;
        $this->objectName = 'bill';

        parent::__construct($request, $response);
        $this->_sitePageData->controllerName = $this->controllerName;
    }

    public function action_index(){
        $this->_sitePageData->url = '/cabinet/shopbill/index';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/bill/list/index',
            )
        );

        // тип объекта
        $type = $this->_getType();
        $this->_requestShopBillStatus();
        $this->_requestShopBranch();
        $this->_requestShopPaidType();
        $this->_requestShopDeliveryType();

        if(Request_RequestParams::getParamBoolean('is_branch') === TRUE){
            View_View::findBranch(
                'DB_Shop_Bill', $this->_sitePageData->shopID,
                '_shop/bill/list/index', '_shop/bill/one/index',
                $this->_sitePageData, $this->_driverDB, array('limit_page' => 25),
                [
                    'shop_id' => ['name'],
                    'shop_delivery_type_id' => ['name'],
                    'shop_paid_type_id' => ['name'],
                ]
            );
        }else {
            View_View::find(
                'DB_Shop_Bill', $this->_sitePageData->shopID,
                '_shop/bill/list/index', '_shop/bill/one/index',
                $this->_sitePageData, $this->_driverDB, array('limit_page' => 25),
                [
                    'shop_id' => ['name'],
                    'shop_delivery_type_id' => ['name'],
                    'shop_paid_type_id' => ['name'],
                ]
            );
        }



        $this->_putInMain('/main/_shop/bill/index');
    }

    public function action_edit()
    {
        $this->_sitePageData->url = '/cabinet/shopbill/edit';

        // id записи
        $id = Request_RequestParams::getParamInt('id');
        if ($id === NULL) {
            throw new HTTP_Exception_404('Bill not is found!');
        }else {
            $model = new Model_Shop_Bill();
            if (!$this->getDBObject($model, $id)) {
                throw new HTTP_Exception_404('Bill not is found!');
            }
        }

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/bill/one/edit',
                'view::_shop/bill/item/list/index',
            )
        );

        $type = $this->_getType($model->getShopTableCatalogID());
        $this->_requestShopBillStatus($model->getShopBillStatusID());
        $this->_requestShopDeliveryType($model->getShopDeliveryTypeID());
        $this->_requestShopPaidType($model->getShopPaidTypeID());
        $this->_requestShopBranch($model->getShopRootID());

        // получаем список товаров
        View_View::find('DB_Shop_Bill_Item', $this->_sitePageData->shopID, "_shop/bill/item/list/index", "_shop/bill/item/one/index",
            $this->_sitePageData, $this->_driverDB, array('is_delete' => $model->getIsDelete(), 'shop_bill_id' => $id, Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE),
            array('shop_good_id', 'shop_table_catalog_id'));

        // получаем данные
        View_View::findOne('DB_Shop_Bill', $this->_sitePageData->shopID, "_shop/bill/one/edit",
            $this->_sitePageData, $this->_driverDB, array('id' => $id), array('shop_table_catalog_id'));

        $this->_putInMain('/main/_shop/bill/edit');
    }

    /**
     * Изменение
     */
    public function action_save(){
        $this->_sitePageData->url = '/cabinet/shopbill/save';
        $result = Api_Shop_Bill::save($this->_sitePageData, $this->_driverDB);
        $this->_redirectSaveResult($result);
    }

    public function action_del() {
        $this->_sitePageData->url = '/cabinet/shopbill/del';
        Api_Shop_Bill::delete($this->_sitePageData, $this->_driverDB);
        $this->response->body(Json::json_encode(array('error' => FALSE)));
    }

    public function action_menu(){
        $this->_sitePageData->url = '/cabinet/shopbill/menu';

        $type = Request_RequestParams::getParamInt('type');

        $shopBillIDs = Request_Request::find('DB_Shop_Bill', $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB,
            array('type' => $type, Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE));

        $model = new Model_Shop_Bill();
        $model->setDBDriver($this->_driverDB);
        $shopBillIDs->additionDatas['type'] = $type;
        $result = Helpers_View::getViewObjects($shopBillIDs, $model, '_shop/bill/list/menu', '_shop/bill/one/menu',
                $this->_sitePageData, $this->_driverDB);

        $this->response->body($result);
    }

    public function action_count(){
        $this->_sitePageData->url = '/cabinet/shopbill/count';

        $type = Request_RequestParams::getParamInt('type');

        $shopBillIDs = Request_Request::find('DB_Shop_Bill', $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB,
            array('type' => $type, 'count_id' => TRUE, Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE));

        $result = count($shopBillIDs->childs);
        if ($result > 0){
            $result = $shopBillIDs->childs[0]->values['count'];
        }
        $this->response->body($result);
    }

    /**
     * Выдача заказа в excel файле
     * @throws HTTP_Exception_500
     */
    public function action_load_bill_in_excel(){
        $this->_sitePageData->url = '/supplier/shopbill/load_bill_in_excel';

        $filePath = APPPATH.'views' . DIRECTORY_SEPARATOR . $this->_sitePageData->shopShablonPath . DIRECTORY_SEPARATOR
            . 'load-in-file' . DIRECTORY_SEPARATOR . $this->_sitePageData->dataLanguageID . DIRECTORY_SEPARATOR . Request_RequestParams::getParamStr('file');
        if(!file_exists($filePath)){
            throw new HTTP_Exception_500('File shablon not is found.');
        }

        // id записи
        $id = Request_RequestParams::getParamInt('id');
        if ($id === NULL) {
            throw new HTTP_Exception_404('Bill not is found!');
        }else {
            $model = new Model_Shop_Bill();
            if (!$this->getDBObject($model, $id)) {
                throw new HTTP_Exception_404('Bill not is found!');
            }
            $model->dbGetElements($this->_sitePageData->shopMainID,
                array('bill_status_id','shop_bill_status_id','city_id','country_id','shop_coupon_id',
                    'shop_delivery_type_id','shop_paid_type_id','shop_root_id','shop_id'),
                $this->_sitePageData->languageIDDefault);
        }

        // получаем список товаров в заказе
        $shopBillItems = Request_Request::find('DB_Shop_Bill_Item', $this->_sitePageData->shopID,
            $this->_sitePageData, $this->_driverDB, array('shop_bill_id' => $id, Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE));

        $modelItem = new Model_Shop_Bill_Item();
        $modelItem->setDBDriver($this->_driverDB);
        $billItems = array();
        $countBillItems = 0;
        foreach($shopBillItems->childs as $shopBillItem){
            Helpers_View::getDBDataIfNotFind($shopBillItem, $modelItem, $this->_sitePageData, $this->_sitePageData->shopID,
                array('shop_bill_id', 'shop_bill_child_id'));
            $billItems[] = $modelItem->getValues(TRUE, TRUE);
            $countBillItems = $countBillItems + $modelItem->getCountElement();
        }

        $bill = $model->getValues(TRUE, TRUE);
        $bill['amount_str'] = Func::numberToStr($model->getAmount(), TRUE, $this->_sitePageData->currency);
        $bill['count'] = $countBillItems;
        $bill['count_str'] = Func::numberToStr($countBillItems);
        Helpers_Excel::saleInFile($filePath,
            array('bill' => $bill),
            array('bill_items' => $billItems));

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
     * Делаем запрос на список брендов
     * @param array $type
     * @return string
     */
    protected function _requestShopBillStatus($currentID = NULL){
        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/bill/status/list/list',
            )
        );

        $data = View_View::find('DB_Shop_Bill_Status', $this->_sitePageData->shopID,
            "_shop/bill/status/list/list", "_shop/bill/status/one/list", $this->_sitePageData, $this->_driverDB,
            array('sort_by' => array('value' => array('order' => 'asc', 'name' => 'asc')), Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE));

        if($currentID !== NULL){
            $s = 'data-id="'.$currentID.'"';
            $data = str_replace($s, $s.' selected', $data);
            $this->_sitePageData->replaceDatas['view::_shop/bill/status/list/list'] = $data;
        }

        return $data;
    }

    /**
     * Делаем запрос на список брендов
     * @param array $type
     * @return string
     */
    protected function _requestShopDeliveryType($currentID = NULL){
        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/deliverytype/list/list',
            )
        );

        $data = View_View::find('DB_Shop_DeliveryType', $this->_sitePageData->shopID,
            "_shop/deliverytype/list/list", "_shop/deliverytype/one/list", $this->_sitePageData, $this->_driverDB,
            array('sort_by' => array('value' => array('order' => 'asc', 'name' => 'asc')), Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE));

        if($currentID !== NULL){
            $s = 'data-id="'.$currentID.'"';
            $data = str_replace($s, $s.' selected', $data);
            $this->_sitePageData->replaceDatas['view::_shop/deliverytype/list/list'] = $data;
        }

        return $data;
    }

    /**
     * Делаем запрос на список брендов
     * @param array $type
     * @return string
     */
    protected function _requestShopPaidType($currentID = NULL){
        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/paidtype/list/list',
            )
        );

        $data = View_View::find('DB_Shop_PaidType', $this->_sitePageData->shopID,
            "_shop/paidtype/list/list", "_shop/paidtype/one/list", $this->_sitePageData, $this->_driverDB,
            array('sort_by' => array('value' => array('order' => 'asc', 'name' => 'asc')), Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE));

        if($currentID !== NULL){
            $s = 'data-id="'.$currentID.'"';
            $data = str_replace($s, $s.' selected', $data);
            $this->_sitePageData->replaceDatas['view::_shop/paidtype/list/list'] = $data;
        }

        return $data;
    }
}
