<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Hotel_ShopBill extends Controller_Hotel_BasicHotel {

    public function __construct(Request $request, Response $response)
    {
        $this->dbObject = 'DB_Hotel_Shop_Bill';
        $this->controllerName = 'shopbill';
        $this->tableID = Model_Hotel_Shop_Bill::TABLE_ID;
        $this->tableName = Model_Hotel_Shop_Bill::TABLE_NAME;
        $this->objectName = 'bill';

        parent::__construct($request, $response);
    }

    public function action_index() {
        $this->_sitePageData->url = '/hotel/shopbill/index';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/bill/list/index',
            )
        );

        View_View::find('DB_Hotel_Shop_Bill', $this->_sitePageData->shopID, "_shop/bill/list/index",
            "_shop/bill/one/index", $this->_sitePageData, $this->_driverDB, array(),
            array('limit' => 1), TRUE, TRUE);

        $this->_putInMain('/main/_shop/bill/index');
    }

    public function action_index_cancel() {
        $this->_sitePageData->url = '/hotel/shopbill/index_cancel';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/bill/list/index',
            )
        );

        $this->_sitePageData->replaceDatas['view::_shop/bill/list/index'] =  View_View::find('DB_Hotel_Shop_Bill',
            $this->_sitePageData->shopID, "_shop/bill/list/index-cancel",
            "_shop/bill/one/index", $this->_sitePageData, $this->_driverDB, array(),
            array('limit' => 1), TRUE, TRUE);

        $this->_putInMain('/main/_shop/bill/index');
    }

    public function action_json() {
        $this->_sitePageData->url = '/hotel/shopbill/json';

        $this->_getJSONList(
            $this->_sitePageData->shopID,
            [],
            array(
                'shop_client_id' => array('name', 'phone'),
                'update_user_id' => array('name'),
                'create_user_id' => array('name'),
                'bill_cancel_status_id' => array('name'),
            )
        );
    }

    public function action_new()
    {
        $this->_sitePageData->url = '/hotel/shopbill/new';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/bill/one/new',
                'view::_shop/bill/item/list/index',
                'view::_shop/bill/service/list/index',
            )
        );

        $this->_requestShopClients();
        $this->_requestShopServices();

        // получаем данные
        $this->_sitePageData->replaceDatas['view::_shop/bill/item/list/index'] =
            Helpers_View::getViewObjects(new MyArray(), new Model_Hotel_Shop_Bill_Item(),
                '_shop/bill/item/list/index', '_shop/bill/item/one/index',
                $this->_sitePageData, $this->_driverDB);

        $this->_sitePageData->replaceDatas['view::_shop/bill/service/list/index'] =
            Helpers_View::getViewObjects(new MyArray(), new Model_Hotel_Shop_Bill_Service(),
                '_shop/bill/service/list/index', '_shop/bill/service/one/index',
                $this->_sitePageData, $this->_driverDB);

        $dataID = new MyArray();
        $dataID->id = 0;
        $dataID->isFindDB = TRUE;
        $this->_requestBanks();

        $data = $this->_sitePageData->replaceDatas['view::_shop/bill/one/new'] = Helpers_View::getViewObject($dataID, new Model_Hotel_Shop_Bill(),
            '_shop/bill/one/new', $this->_sitePageData, $this->_driverDB);

        $this->response->body($this->_sitePageData->replaceStaticDatas($data));
    }

    public function action_edit()
    {
        $this->_sitePageData->url = '/hotel/shopbill/edit';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/bill/one/edit',
                'view::_shop/bill/item/list/index',
                'view::_shop/bill/service/list/index',
                'view::_shop/payment/list/bill',
            )
        );

        // id записи
        $shopBillID = Request_RequestParams::getParamInt('id');
        if ($shopBillID === NULL) {
            throw new HTTP_Exception_404('Bill not is found!');
        }else {
            $model = new Model_Hotel_Shop_Bill();
            if (! $this->dublicateObjectLanguage($model, $shopBillID)) {
                throw new HTTP_Exception_404('Bill not is found!');
            }
        }

        $this->_requestShopClients($model->getShopClientID());
        $this->_requestShopServices();
        $this->_requestBanks();

        $params = Request_RequestParams::setParams(
            array(
                'shop_bill_id' => $shopBillID,
                'is_paid' => TRUE,
            )
        );
        View_View::find('DB_Hotel_Shop_Payment', $this->_sitePageData->shopID, "_shop/payment/list/bill",
            "_shop/payment/one/bill", $this->_sitePageData, $this->_driverDB, $params);

        View_View::find('DB_Hotel_Shop_Bill_Item', $this->_sitePageData->shopID,
            '_shop/bill/item/list/index', '_shop/bill/item/one/index',
            $this->_sitePageData, $this->_driverDB, array('shop_bill_id' => $shopBillID, 'is_public_ignore' => TRUE,
                'sort_by' => array('value' => array('id' => 'asc')), Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE),
            array('shop_room_id' => array('name', 'human', 'human_extra')));

        View_View::find('DB_Hotel_Shop_Bill_Service', $this->_sitePageData->shopID,
            '_shop/bill/service/list/index', '_shop/bill/service/one/index',
            $this->_sitePageData, $this->_driverDB, array('shop_bill_id' => $shopBillID, 'is_public_ignore' => TRUE,
                'sort_by' => array('value' => array('id' => 'asc')), Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE),
            array());


        // получаем данные
        $data = View_View::findOne('DB_Hotel_Shop_Bill', $this->_sitePageData->shopID, "_shop/bill/one/edit",
            $this->_sitePageData, $this->_driverDB, array('id' => $shopBillID), array());

        $this->response->body($this->_sitePageData->replaceStaticDatas($data));
    }

    public function action_modal_cancel()
    {
        $this->_sitePageData->url = '/hotel/shopbill/modal_cancel';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/bill/modal/cancel',
            )
        );

        $this->_requestBillCancelStatus();
        $dataID = new MyArray();
        $dataID->id = Request_RequestParams::getParamInt('id');
        $dataID->isFindDB = TRUE;

        $model = new Model_Hotel_Shop_Bill();
        $model->setDBDriver($this->_driverDB);
        Helpers_DB::getDBObject($model, $dataID->id, $this->_sitePageData);
        $dataID->values = $model->getValues(TRUE, TRUE, $this->_sitePageData->shopMainID);

        $data = $this->_sitePageData->replaceDatas['view::_shop/bill/modal/cancel'] =
            Helpers_View::getViewObject($dataID, new Model_Hotel_Shop_Bill(),
            '_shop/bill/modal/cancel', $this->_sitePageData, $this->_driverDB);

        $this->response->body($this->_sitePageData->replaceStaticDatas($data));
    }

    public function action_cancel()
    {
        $this->_sitePageData->url = '/hotel/shopbill/cancel';

        Api_Hotel_Shop_Bill::cancel($this->_sitePageData, $this->_driverDB);
    }

    public function action_un_cancel()
    {
        $this->_sitePageData->url = '/hotel/shopbill/un_cancel';

        Api_Hotel_Shop_Bill::unCancel($this->_sitePageData, $this->_driverDB);
    }

    public function action_save()
    {
        $this->_sitePageData->url = '/hotel/shopbill/save';

        $result = Api_Hotel_Shop_Bill::save($this->_sitePageData, $this->_driverDB);

        $this->_redirectSaveResult(
            $result,
            array(
                'shop_client_name' => array(
                    'id' => 'shop_client_id',
                    'model' => new Model_Hotel_Shop_Client(),
                ),
                'shop_client_phone' => array(
                    'id' => 'shop_client_id',
                    'field' => 'phone',
                    'model' => new Model_Hotel_Shop_Client(),
                ),
                'update_user_name' => array(
                    'id' => 'update_user_id',
                    'model' => new Model_User(),
                ),
                'create_user_name' => array(
                    'id' => 'create_user_id',
                    'model' => new Model_User(),
                ),
                'bill_cancel_status_name' => array(
                    'id' => 'bill_cancel_status_id',
                    'model' => new Model_Hotel_BillCancelStatus(),
                ),
            )
        );
    }

    public function action_del()
    {
        $this->_sitePageData->url = '/hotel/shopbill/del';

        Api_Hotel_Shop_Bill::delete($this->_sitePageData, $this->_driverDB);
        $this->response->body(Json::json_encode(array('error' => TRUE)));
    }

    public function action_save_pdf()
    {
        // id записи
        $shopBillID = Request_RequestParams::getParamInt('id');
        $model = new Model_Hotel_Shop_Bill();
        if (! $this->dublicateObjectLanguage($model, $shopBillID, -1, FALSE)) {
            throw new HTTP_Exception_404('Bill not is found!');
        }

        Api_Hotel_Shop_Bill::savePaidReserveInPDF($model, $this->_sitePageData, $this->_driverDB, 'Reserve '.$shopBillID.'.pdf', TRUE);
        exit;
    }

    public function action_save_halyk_pdf()
    {
        // id записи
        $shopBillID = Request_RequestParams::getParamInt('id');
        $model = new Model_Hotel_Shop_Bill();
        if (! $this->dublicateObjectLanguage($model, $shopBillID, -1, FALSE)) {
            throw new HTTP_Exception_404('Bill not is found!');
        }

        Api_Hotel_Shop_Bill::savePaidHalykInPDF($model, $this->_sitePageData, $this->_driverDB, 'Reserve '.$shopBillID.'.pdf', TRUE);
        exit;
    }

    public function action_save_bank_pdf()
    {
        // id записи
        $shopBillID = Request_RequestParams::getParamInt('id');
        $model = new Model_Hotel_Shop_Bill();
        if (! $this->dublicateObjectLanguage($model, $shopBillID, -1, FALSE)) {
            throw new HTTP_Exception_404('Bill not is found!');
        }

        Api_Hotel_Shop_Bill::savePaidBankInPDF($model, $this->_sitePageData, $this->_driverDB, 'Reserve '.$shopBillID.'.pdf', TRUE);
        exit;
    }

    public function action_save_bank_and_halyk_pdf()
    {
        // id записи
        $shopBillID = Request_RequestParams::getParamInt('id');
        $model = new Model_Hotel_Shop_Bill();
        if (! $this->dublicateObjectLanguage($model, $shopBillID, -1, FALSE)) {
            throw new HTTP_Exception_404('Bill not is found!');
        }

        Api_Hotel_Shop_Bill::savePaidBankAndHalykInPDF($model, $this->_sitePageData, $this->_driverDB, 'Reserve '.$shopBillID.'.pdf', TRUE);
        exit;
    }

    public function action_group_items()
    {
        $this->_sitePageData->url = '/hotel/shopbill/group_items';

        $result = Api_Hotel_Shop_Bill_Item::groupItems(Request_RequestParams::getParamArray('shop_bill_items', array(), array()),
            $this->_sitePageData, $this->_driverDB);
        $this->response->body(json_encode($result));
    }

    public function action_recount_paid_amount()
    {
        $this->_sitePageData->url = '/hotel/shopbill/recount_paid_amount';

        Api_Hotel_Shop_Bill::recountBillsPaidAmount($this->_sitePageData, $this->_driverDB);
    }
}
