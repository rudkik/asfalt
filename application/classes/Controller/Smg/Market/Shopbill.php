<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Smg_Market_ShopBill extends Controller_Smg_Market_Basic {

    public function __construct(Request $request, Response $response)
    {
        $this->dbObject = 'DB_AutoPart_Shop_Bill';
        $this->controllerName = 'shopbill';
        $this->tableID = Model_AutoPart_Shop_Bill::TABLE_ID;
        $this->tableName = Model_AutoPart_Shop_Bill::TABLE_NAME;
        $this->objectName = 'bill';

        parent::__construct($request, $response);
    }

    public function action_index() {
        $this->_sitePageData->url = '/market/shopbill/index';

        $this->_requestListDB('DB_AutoPart_Shop_Bill_Delivery_Type');
        $this->_requestListDB('DB_AutoPart_Shop_Bill_PaymentType');
        $this->_requestListDB('DB_AutoPart_Shop_Source');
        $this->_requestListDB('DB_AutoPart_Shop_Bill_Status_Source');
        $this->_requestListDB('DB_AutoPart_Shop_Courier');
        $this->_requestListDB('DB_AutoPart_Shop_Bank_Account', NULL, 0, [], ['shop_company_id' => ['name']]);
        $this->_requestListDB('DB_AutoPart_Shop_Company');

        parent::_actionIndex(
            array(
                'shop_bill_delivery_type_id' => array('name'),
                'shop_bill_payment_type_id' => array('name'),
                'shop_bill_buyer_id' => array('phone'),
                'shop_source_id' => array('name'),
                'shop_bill_cancel_type_id' => array('name'),
                'shop_bill_status_id' => array('name'),
                'shop_bill_status_source_id' => array('name'),
                'shop_bill_state_source_id' => array('name'),
                'shop_company_id' => array('name'),
                'shop_courier_id' => array('name'),
                'shop_other_address_id' => array('name'),
            )
        );
    }

    public function action_graph() {
        $this->_sitePageData->url = '/market/shopbill/graph';

        $dateFrom = Request_RequestParams::getParamDate('date_from');
        if(empty($dateFrom)){
            $dateFrom = Helpers_DateTime::minusDays(Helpers_DateTime::getCurrentDatePHP(), 30);
        }

        $dateTo = Request_RequestParams::getParamDate('date_to');
        if(!empty($dateTo)){
            $dateTo = Helpers_DateTime::getDateTimeEndDay($dateTo);
        }


        $params = Request_RequestParams::setParams(
            array(
                'approve_source_at_from_equally' => $dateFrom,
                'approve_source_at_to' => $dateTo,
                'count_id' => true,
                'group_by' => array(
                    'approve_source_at_date',
                ),
                'sort_by' => ['approve_source_at_date' => 'asc']
            )
        );

        // выданные заказы
        $params['shop_bill_status_source_id'] = Model_AutoPart_Shop_Bill_Status_Source::STATUS_COMPLETED;
        $billsCompleted = Request_Request::find(
            'DB_AutoPart_Shop_Bill', $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB,
            $params
        );

        // отмененные заказы
        $params['shop_bill_status_source_id'] = Model_AutoPart_Shop_Bill_Status_Source::STATUS_CANCEL;
        $billsCancel = Request_Request::find(
            'DB_AutoPart_Shop_Bill', $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB,
            $params
        );

        // возвратные заказы
        $params['shop_bill_status_source_id'] = Model_AutoPart_Shop_Bill_Status_Source::STATUS_RETURN;
        $billsReturn = Request_Request::find(
            'DB_AutoPart_Shop_Bill', $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB,
            $params
        );

        // общее кол-во заказов
        unset($params['shop_bill_status_source_id']);
        $billsAll = Request_Request::find(
            'DB_AutoPart_Shop_Bill', $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB,
            $params
        );

        $data = new MyArray();
        $data->additionDatas['completed'] = $billsCompleted;
        $data->additionDatas['return'] = $billsReturn;
        $data->additionDatas['cancel'] = $billsCancel;
        $data->additionDatas['all'] = $billsAll;
        $result = Helpers_View::getView(
            '_shop/bill/one/graph', $this->_sitePageData, $this->_driverDB, $data
        );
        $this->_sitePageData->addReplaceAndGlobalDatas('view::_shop/bill/one/graph', $result);

        $this->_putInMain('/main/_shop/bill/graph');
    }

    public function action_courier() {
        $this->_sitePageData->url = '/market/shopbill/courier';

        $this->_requestListDB('DB_AutoPart_Shop_Source');
        $this->_requestListDB('DB_AutoPart_Shop_Courier');

        $shopCourierID = $this->_sitePageData->operation->getShopCourierID();
        if($shopCourierID < 1){
            $shopCourierID = -1;
        }

        $shopBills = Request_Request::find(
            'DB_AutoPart_Shop_Bill', $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB,
            array(
                'shop_courier_id_from' => 0,
                'shop_courier_id' => $shopCourierID,
                'shop_bill_state_source_id' => [1478255, 1478254, 1478252],
            ), 0, true,
            array(
                'shop_bill_delivery_type_id' => array('name'),
                'shop_bill_payment_type_id' => array('name'),
                'shop_bill_buyer_id' => array('phone'),
                'shop_source_id' => array('name'),
                'shop_bill_cancel_type_id' => array('name'),
                'shop_bill_status_type_id' => array('name'),
                'shop_bill_status_source_type_id' => array('name'),
                'shop_bill_status_id' => array('name'),
                'shop_bill_status_source_id' => array('name'),
                'shop_bill_state_source_id' => array('name'),
                'shop_company_id' => array('name'),
                'shop_courier_id' => array('name'),
                'shop_other_address_id' => array('name'),
            )
        );

        foreach ($shopBills->childs as $shopBill){
            $shopBillItems = Request_Request::find(
                'DB_AutoPart_Shop_Bill_Item', $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB,
                Request_RequestParams::setParams(['shop_bill_id' => $shopBill->values['id']]), 100, true
            );

            $result = Helpers_View::getViewObjects(
                $shopBillItems, new Model_AutoPart_Shop_Bill_Item(),
                "_shop/bill/item/list/courier", "_shop/bill/item/one/courier",
                $this->_sitePageData, $this->_driverDB
            );

            $shopBill->additionDatas['view::_shop/bill/item/list/courier'] = $result;
        }

        $result = Helpers_View::getViewObjects(
            $shopBills, new Model_AutoPart_Shop_Bill(),
            "_shop/bill/list/courier", "_shop/bill/one/courier",
            $this->_sitePageData, $this->_driverDB, $this->_sitePageData->shopID, true,
            array(
                'shop_bill_delivery_type_id' => array('name'),
                'shop_bill_payment_type_id' => array('name'),
                'shop_bill_buyer_id' => array('phone'),
                'shop_source_id' => array('name'),
                'shop_bill_cancel_type_id' => array('name'),
                'shop_bill_status_type_id' => array('name'),
                'shop_bill_status_source_type_id' => array('name'),
                'shop_bill_status_id' => array('name'),
                'shop_bill_status_source_id' => array('name'),
                'shop_bill_state_source_id' => array('name'),
                'shop_company_id' => array('name'),
                'shop_bill_payment_source_id' => array('name'),
                'shop_other_address_id' => array('name'),
            )
        );
        $this->_sitePageData->addReplaceAndGlobalDatas('view::_shop/bill/list/courier', $result);

        $this->_putInMain('/main/_shop/bill/courier');
    }

    public function action_new()
    {
        $this->_sitePageData->url = '/market/shopbill/new';

        $this->_requestListDB('DB_AutoPart_Shop_Bill_Delivery_Type');
        $this->_requestListDB('DB_AutoPart_Shop_Bill_PaymentType');
        $this->_requestListDB('DB_AutoPart_Shop_Company');
        $this->_requestListDB('DB_AutoPart_Shop_Source');
        $this->_requestListDB('DB_AutoPart_Shop_Bill_Status_Source');
        $this->_requestListDB('DB_AutoPart_Shop_Bill_State_Source');

        parent::_actionNew();
    }

    public function action_edit()
    {
        $this->_sitePageData->url = '/market/shopbill/edit';

        // id записи
        $id = Request_RequestParams::getParamInt('id');
        $model = new Model_AutoPart_Shop_Bill();
        if (! $this->dublicateObjectLanguage($model, $id, $this->_sitePageData->shopID, false)) {
            throw new HTTP_Exception_404('Object "' . $this->dbObject . '" not is found!');
        }

        $this->_requestListDB('DB_AutoPart_Shop_Bill_Delivery_Type', $model->getShopBillDeliveryTypeID());
        $this->_requestListDB('DB_AutoPart_Shop_Bill_PaymentType', $model->getShopBillPaymentTypeID());
        $this->_requestListDB('DB_AutoPart_Shop_Company', $model->getShopCompanyID());
        $this->_requestListDB('DB_AutoPart_Shop_Source', $model->getShopSourceID());
        $this->_requestListDB('DB_AutoPart_Shop_Bill_Status_Source', $model->getShopBillStatusSourceID());
        $this->_requestListDB('DB_AutoPart_Shop_Bill_State_Source', $model->getShopBillStateSourceID());

        View_View::find(
            DB_AutoPart_Shop_Bill_Item::NAME, $this->_sitePageData->shopID,
            '_shop/bill/item/list/index',  '_shop/bill/item/one/index',
            $this->_sitePageData, $this->_driverDB, Request_RequestParams::setParams(['shop_bill_id' => $id]),
            ['shop_product_id' => ['name']]
        );

        // получаем данные
        $ids = new MyArray();
        $ids->setValues($model, $this->_sitePageData, ['shop_buyer_id', 'shop_bill_delivery_id']);
        $ids->setIsFind(true);

        $result = Helpers_View::getViewObject(
            $ids, $model, '_shop/bill/one/edit', $this->_sitePageData, $this->_driverDB, $this->_sitePageData->shopID
        );
        $this->_sitePageData->addReplaceAndGlobalDatas('view::_shop/bill/one/edit',  $result);

        $this->_putInMain('/main/_shop/bill/edit');
    }

    public function action_set_courier(){
        $this->_sitePageData->url = '/market/shopbill/set_courier';

        $shopCourierID = Request_RequestParams::getParamInt('shop_courier_id');

        $shopBillID = Request_RequestParams::getParamInt('shop_bill_id');
        $model = new Model_AutoPart_Shop_Bill();
        if (! $this->getDBObject($model, $shopBillID, $this->_sitePageData->shopID)) {
            throw new HTTP_Exception_404('Object "' . $this->dbObject . '" not is found!');
        }

        $model->setShopCourierID($shopCourierID);
        Helpers_DB::saveDBObject($model, $this->_sitePageData);

        // добавляем точку в маршрут
        Api_AutoPart_Shop_Courier_Route::addBill(
            Helpers_DateTime::getCurrentDatePHP() , $model, $this->_sitePageData, $this->_driverDB
        );

        $this->redirect(Request_RequestParams::getParamStr('url'));
    }

    public function action_set_address(){
        $this->_sitePageData->url = '/market/shopbill/set_address';

        $modelAddress = new Model_AutoPart_Shop_Other_Address();
        $modelAddress->setDBDriver($this->_driverDB);

        $modelAddress->setStreet(Request_RequestParams::getParamStr('street'));
        $modelAddress->setCityName(Request_RequestParams::getParamStr('city_name'));
        $modelAddress->setHouse(Request_RequestParams::getParamStr('house'));
        $modelAddress->setApartment(Request_RequestParams::getParamStr('apartment'));

        $query = Helpers_Yandex::getYandexMapsCoordinates(Request_RequestParams::getParamStr('yandex'));
        $coordinates = array_shift($query);
        if(is_array($coordinates)){
            $modelAddress->setLatitude($coordinates[0]);
            $modelAddress->setLongitude($coordinates[1]);
        }

        Helpers_DB::saveDBObject($modelAddress, $this->_sitePageData);
        $modelAddress->setStreet(Request_RequestParams::getParamStr('street'));

        $shopBillID = Request_RequestParams::getParamInt('shop_bill_id');
        $model = new Model_AutoPart_Shop_Bill();
        if (! $this->getDBObject($model, $shopBillID, $this->_sitePageData->shopID)) {
            throw new HTTP_Exception_404('Object "' . $this->dbObject . '" not is found!');
        }

        $model->setShopOtherAddressID($modelAddress->id);
        Helpers_DB::saveDBObject($model, $this->_sitePageData);

        $this->response->body(Json::json_encode(['values' => $modelAddress->getValues(true, true)]));
    }

    public function action_load_kaspi()
    {
        $this->_sitePageData->url = '/market/shopbill/load_kaspi';

        if(!key_exists('file', $_FILES)){
            throw new HTTP_Exception_500('File not load.');
        }

        $shopBankAccountID = Request_RequestParams::getParamInt('shop_bank_account_id');
        if($shopBankAccountID < 1){
            throw new HTTP_Exception_500('Bank account not found.');
        }

        $shopCompanyID = Request_RequestParams::getParamInt('shop_company_id');
        if($shopCompanyID < 1){
            throw new HTTP_Exception_500('Company not found.');
        }

        $firstRow = Request_RequestParams::getParamInt('first_row');
        $data = Helpers_Excel::loadFileInArray($_FILES['file']['tmp_name'], $firstRow);

        $model = new Model_AutoPart_Shop_Bill_Item();
        $model->setDBDriver($this->_driverDB);

        foreach ($data as $child){
            if($child[13] != 'Покупка'){
                continue;
            }

            $shopBillItemIDs = Request_Request::find(
                DB_AutoPart_Shop_Bill_Item::NAME, $this->_sitePageData->shopID,
                $this->_sitePageData, $this->_driverDB,
                Request_RequestParams::setParams(
                    [
                        'shop_bill_id.shop_company_id' => $shopCompanyID,
                        'shop_bill_id.old_id_full' => $child[9],
                        'amount' => $child[19],
                    ]
                )
            );
            if(count($shopBillItemIDs->childs) < 1){
                throw new HTTP_Exception_500('Bill items "' . $child[9] . '" not found.');
            }

            $child[32] = Func::mb_str_replace('  ', ' ', trim($child[32]));
            foreach ($shopBillItemIDs->childs as $shopBillItem){
                if(($shopBillItem->values['name'] == $child[32] && $shopBillItem->values['quantity'] == 1)
                    || $shopBillItem->values['name'] . ', '.$shopBillItem->values['quantity'].' шт.' == $child[32]
                    || mb_strpos($child[32], $shopBillItem->values['name']) !== false
                    || mb_strpos($shopBillItem->values['name'], $child[32]) !== false){
                    $shopBillItem->setModel($model);
                    $model->setOptionsValue('kaspi_pay', ['v1' => $child]);
                    $model->setBankDate($child[12]);
                    $model->setShopBankAccountID($shopBankAccountID);
                    $model->setCommissionSourceService(Request_RequestParams::strToFloat($child[22]) * 100);
                    $model->setCommissionSourcePayment(Request_RequestParams::strToFloat($child[28]) * 100);

                    Helpers_DB::saveDBObject($model, $this->_sitePageData);
                    break;
                }else{
                    throw new HTTP_Exception_500('Bill item "' . $child[9] . '" "' . $child[32] . '" "' . $shopBillItem->values['name'] . '" not found.');
                }
            }
        }

        $this->redirect('/market/shopbill/index');
    }
}
