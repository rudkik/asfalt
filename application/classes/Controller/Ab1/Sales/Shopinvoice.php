<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_Sales_ShopInvoice extends Controller_Ab1_Sales_BasicAb1 {

    public function __construct(Request $request, Response $response)
    {
        $this->dbObject = 'DB_Ab1_Shop_Invoice';
        $this->controllerName = 'shopinvoice';
        $this->tableID = Model_Ab1_Shop_Invoice::TABLE_ID;
        $this->tableName = Model_Ab1_Shop_Invoice::TABLE_NAME;
        $this->objectName = 'invoice';

        parent::__construct($request, $response);
    }

    public function action_index() {
        $this->_sitePageData->url = '/sales/shopinvoice/index';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/invoice/list/index',
            )
        );

        $this->_requestShopProducts();
        $this->_requestCheckTypes(Request_RequestParams::getParamInt('check_type_id'));

        if(Request_RequestParams::getParamBoolean('is_last_day')){
            $params = Request_RequestParams::setParams(
                array(
                    'limit' => 1000, 'limit_page' => 25,
                    'date' => Helpers_DateTime::minusDays(date('Y-m-d'), 9),
                    'is_send_esf' => Request_RequestParams::getParamBoolean('is_send_esf'),
                    'sort_by' => array(
                        'date' => 'desc',
                        'number' => 'desc',
                    )
                ),
                FALSE
            );
        }else{
            $params = array(
                'limit' => 1000, 'limit_page' => 25,
                'sort_by' => array(
                    'date' => 'desc',
                    'created_at' => 'desc',
                )
            );
        }

        // получаем список
        View_View::find('DB_Ab1_Shop_Invoice',
            $this->_sitePageData->shopID,
            "_shop/invoice/list/index", "_shop/invoice/one/index",
            $this->_sitePageData, $this->_driverDB, $params,
            array(
                'shop_client_id' => array('name'),
                'shop_client_attorney_id' => array('number'),
                'shop_client_contract_id' => array('number'),
                'product_type_id' => array('name'),
                'check_type_id' => array('name'),
            )
        );

        $this->_putInMain('/main/_shop/invoice/index');
    }

    public function action_add() {
        $this->_sitePageData->url = '/sales/shopinvoice/add';

        $date = Request_RequestParams::getParamDateTime('date');
        $dateFrom = Request_RequestParams::getParamDateTime('date_from');
        $dateTo = Request_RequestParams::getParamDateTime('date_to');
        $shopClientID = Request_RequestParams::getParamInt('shop_client_id');
        $shopClientAttorneyID = Request_RequestParams::getParamInt('shop_client_attorney_id');
        $shopClientContractID = Request_RequestParams::getParamInt('shop_client_contract_id');
        $productTypeID = Request_RequestParams::getParamInt('product_type_id');
        $isDelivery = Request_RequestParams::getParamBoolean('is_delivery');

        $result = Api_Ab1_Shop_Invoice::addInvoice(
            $shopClientID, $shopClientAttorneyID, $shopClientContractID, $productTypeID, $isDelivery,
            $date, $dateFrom, $dateTo,
            $this->_sitePageData, $this->_driverDB
        );

        if($result === FALSE) {
            throw new HTTP_Exception_500('Cars not found.');
        }

        self::redirect(
            '/sales/shopinvoice/edit'
            . URL::query(
                array(
                    'id' => $result->id,
                ), FALSE
            )
        );
    }

    public function action_calc_goods_price() {
        $this->_sitePageData->url = '/sales/shopinvoice/calc_goods_price';

        $dateFrom = Request_RequestParams::getParamDateTime('date_from');
        $dateTo = Request_RequestParams::getParamDateTime('date_to');
        $shopClientID = Request_RequestParams::getParamInt('shop_client_id');
        $shopClientAttorneyID = Request_RequestParams::getParamInt('shop_client_attorney_id');
        $shopClientContractID = Request_RequestParams::getParamInt('shop_client_contract_id');
        $isDelivery = Request_RequestParams::getParamBoolean('is_delivery');

        Api_Ab1_Shop_Car::calcPriceCars(
            $shopClientID, $shopClientAttorneyID, $shopClientContractID, $isDelivery,
            $dateFrom, $dateTo, $this->_sitePageData, $this->_driverDB
        );

        Api_Ab1_Shop_Piece::calcPricePieces(
            $shopClientID, $shopClientAttorneyID, $shopClientContractID, $isDelivery,
            $dateFrom, $dateTo, $this->_sitePageData, $this->_driverDB
        );

        self::redirect(
            '/sales/shopinvoice/virtual_show'
            . URL::query()
        );
    }

    public function action_calc_invoice_price() {
        $this->_sitePageData->url = '/sales/shopinvoice/calc_invoice_price';

        $shopInvoiceID = Request_RequestParams::getParamInt('shop_invoice_id');

        Api_Ab1_Shop_Invoice::calcInvoicePrice(
            $shopInvoiceID, $this->_sitePageData, $this->_driverDB
        );

        self::redirect(
            '/sales/shopinvoice/edit' . URL::query(array('id' => $shopInvoiceID,))
        );
    }

    public function action_edit()
    {
        $this->_sitePageData->url = '/sales/shopinvoice/edit';
        $this->_actionShopInvoiceEdit();
    }

    public function action_save()
    {
        $this->_sitePageData->url = '/sales/shopinvoice/save';

        $result = Api_Ab1_Shop_Invoice::save($this->_sitePageData, $this->_driverDB);
        $this->_redirectSaveResult($result);
    }

    public function action_invoice_edit() {
        $this->_sitePageData->url = '/sales/shopinvoice/invoice_edit';
        $this->_actionShopInvoiceModalEdit();
    }

    public function action_discount_delete() {
        $this->_sitePageData->url = '/sales/shopinvoice/discount_delete';
        $this->_actionShopInvoiceDiscountDelete();
    }

    public function action_virtual_discount_delete() {
        $this->_sitePageData->url = '/sales/shopinvoice/virtual_discount_delete';

        $dateFrom = Request_RequestParams::getParamDateTime('date_from');
        $dateTo = Request_RequestParams::getParamDateTime('date_to');
        $shopClientID = Request_RequestParams::getParamInt('shop_client_id');
        $shopClientAttorneyID = Request_RequestParams::getParamInt('shop_client_attorney_id');
        $shopClientContractID = Request_RequestParams::getParamInt('shop_client_contract_id');
        $productTypeID = Request_RequestParams::getParamInt('product_type_id');
        $shopProductID = Request_RequestParams::getParamInt('shop_product_id');
        $isDelivery = Request_RequestParams::getParamBoolean('is_delivery');

        Api_Ab1_Shop_Car::deleteDiscountProduct(
            $dateFrom, $dateTo,
            $shopClientID, $shopClientAttorneyID, $shopClientContractID,
            $productTypeID, $isDelivery, $shopProductID,
            Request_RequestParams::getParamFloat('price'),
            $this->_sitePageData, $this->_driverDB
        );

        self::redirect(
            '/sales/shopinvoice/virtual_show'
            .URL::query()
        );
    }

    public function action_invoice_break() {
        $this->_sitePageData->url = '/sales/shopinvoice/invoice_break';

        $shopInvoiceID = intval(Request_RequestParams::getParamInt('shop_invoice_id'));
        $shopClientAttorneyIDTo = intval(Request_RequestParams::getParamInt('shop_client_attorney_id_to'));
        $shopClientContractIDTo = intval(Request_RequestParams::getParamInt('shop_client_contract_id_to'));
        $shopProductID = Request_RequestParams::getParamInt('shop_product_id');

        $quantity = Request_RequestParams::getParamFloat('quantity');
        if($quantity > 0){
            $shopInvoiceIDs = Api_Ab1_Shop_Invoice::breakInvoiceQuantity(
                $shopInvoiceID,
                $shopClientAttorneyIDTo, $shopClientContractIDTo,
                $shopProductID,
                $quantity,
                $this->_sitePageData, $this->_driverDB
            );
        }else {
            $amount = Request_RequestParams::getParamFloat('amount');
            $shopInvoiceIDs = Api_Ab1_Shop_Invoice::breakInvoiceAmount(
                $shopInvoiceID,
                $shopClientAttorneyIDTo, $shopClientContractIDTo,
                $shopProductID,
                $amount,
                $this->_sitePageData, $this->_driverDB
            );
        }

        if($shopInvoiceIDs === false){
            throw new HTTP_Exception_500('Invoice not found.');
        }
        self::redirect(
            '/sales/shopinvoice/index'
            .URL::query(
                array(
                    'id' => $shopInvoiceIDs,
                ), FALSE
            )
        );
    }

    public function action_virtual_index() {
        $this->_sitePageData->url = '/sales/shopinvoice/virtual_index';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/invoice/list/virtual/index',
            )
        );

        $dateFrom = Request_RequestParams::getParamDateTime('date_from');
        if($dateFrom === NULL){
            $dateFrom = date('Y-m-d').' 06:00:00';
        }
        $dateTo = Request_RequestParams::getParamDateTime('date_to');
        if($dateTo === NULL){
            $dateTo = date('Y-m-d',strtotime('+1 day')).' 06:00:00';
        }

        // Получение виртуальные накладных
        $params = Request_RequestParams::setParams(
            array(
                'shop_client_id' => Request_RequestParams::getParam('shop_client_id'),
                'shop_client_attorney_id' => Request_RequestParams::getParam('shop_client_attorney_id'),
                'shop_client_contract_id' => Request_RequestParams::getParam('shop_client_contract_id'),
            )
        );
        $ids = Api_Ab1_Shop_Invoice::getVirtualInvoices(
            $dateFrom, $dateTo, $this->_sitePageData, $this->_driverDB, $params, $this->_sitePageData->shopID
        );

        // получаем количество полученных наличных за заданный период
        if(count($ids->childs) > 0){
            $params = Request_RequestParams::setParams(
                array(
                    'shop_client_id' => $ids->getChildArrayInt('shop_client_id', true),
                    'created_at_from' => $dateFrom,
                    'created_at_to' => $dateTo,
                    'sum_amount' => true,
                    'group_by' => array(
                        'shop_client_id'
                    )
                )
            );
            $shopPaymentIDs = Request_Request::findBranch('DB_Ab1_Shop_Payment',
                array(), $this->_sitePageData, $this->_driverDB, $params, 0, TRUE
            );
            $shopPaymentIDs->runIndex(true, 'shop_client_id');

            foreach ($ids->childs as $child){
                $shopClientID = $child->values['shop_client_id'];
                if(key_exists($shopClientID, $shopPaymentIDs->childs)){
                    $child->additionDatas['cash'] = $shopPaymentIDs->childs[$shopClientID]->values['amount'];
                }
            }
        }

        $this->_sitePageData->replaceDatas['view::_shop/invoice/list/virtual/index'] = Helpers_View::getViewObjects(
            $ids, new Model_Ab1_Shop_Car_Item(),
            '_shop/invoice/list/virtual/index', '_shop/invoice/one/virtual/index',
            $this->_sitePageData, $this->_driverDB
        );

        $this->_putInMain('/main/_shop/invoice/virtual/index');
    }

    public function action_virtual_show()
    {
        $this->_sitePageData->url = '/sales/shopinvoice/virtual_show';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/invoice/list/virtual/show',
                'view::_shop/client/one/show-invoice',
                'view::_shop/client/one/invoice-balance',
            )
        );

        $shopClientID = Request_RequestParams::getParamInt('shop_client_id');
        $shopClientAttorneyID = Request_RequestParams::getParamInt('shop_client_attorney_id');
        $shopClientContractID = Request_RequestParams::getParamInt('shop_client_contract_id');
        $productTypeID = Request_RequestParams::getParamInt('product_type_id');

        // обновляем балансы клиента (дополнительно, перед формирование накладной)
        Api_Ab1_Shop_Client::recountBalanceObject(
            null, $this->_sitePageData, $this->_driverDB, $shopClientID
        );

        $this->_requestShopClientAttorney(
            $shopClientID, $shopClientAttorneyID, 'option', Request_RequestParams::getParamDate('date_from')
        );
        $this->_requestShopClientContract($shopClientID, $shopClientContractID, 'list', null,
            Model_Ab1_ClientContract_Status::CLIENT_CONTRACT_STATUS_WORK);
        $this->_requestProductTypes($productTypeID);

        // получаем данные
        View_View::findOne('DB_Ab1_Shop_Client',
            $this->_sitePageData->shopMainID, "_shop/client/one/show-invoice",
            $this->_sitePageData, $this->_driverDB, array('id' => $shopClientID)
        );

        // балансы клиента
        View_View::findOne('DB_Ab1_Shop_Client',
            $this->_sitePageData->shopMainID, "_shop/client/one/invoice-balance",
            $this->_sitePageData, $this->_driverDB, array('id' => $shopClientID)
        );
        $this->_requestShopClientAttorney($shopClientID, $shopClientAttorneyID, 'invoice');

        $dateFrom = Request_RequestParams::getParamDateTime('date_from');
        if ($dateFrom === NULL) {
            $dateFrom = date('Y-m-d') . ' 06:00:00';
        }
        $dateTo = Request_RequestParams::getParamDateTime('date_to');
        if ($dateTo === NULL) {
            $dateTo = date('Y-m-d', strtotime('+1 day')) . ' 06:00:00';
        }

        $params = Request_RequestParams::setParams(
            array(
                'exit_at_from' => $dateFrom,
                'exit_at_to' => $dateTo,
                'shop_client_id' => $shopClientID,
                'shop_client_attorney_id' => $shopClientAttorneyID,
                'shop_client_contract_id' => $shopClientContractID,
                'shop_product_id.product_type_id' => $productTypeID,
                'is_exit' => TRUE,
                'is_charity' => FALSE,
                'is_delivery' => Request_RequestParams::getParamBoolean('is_delivery'),
                'shop_invoice_id' => 0,
                'quantity_from' => 0,
                'sort_by' => array('shop_product_id.name' => 'asc'),
            )
        );

        // получаем список реализации
        $shopCarItemIDs = Request_Request::find('DB_Ab1_Shop_Car_Item',
            $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB,
            $params, 0, TRUE,
            array(
                'shop_product_id' => array('name'),
                'shop_car_id' => array('name', 'ticket'),
                'shop_product_time_price_id' => array('price'),
            )
        );

        $shopPieceItemIDs = Request_Request::find('DB_Ab1_Shop_Piece_Item',
            $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB,
            $params, 0, TRUE,
            array(
                'shop_product_id' => array('name', 'price'),
                'shop_piece_id' => array('name', 'ticket'),
                'shop_product_time_price_id' => array('price'),
            )
        );

        if (Request_RequestParams::getParamBoolean('is_all')) {
            if (empty($shopCarItemIDs->childs)) {
                $shopCarItemIDs->childs = $shopPieceItemIDs->childs;
            } elseif (!empty($shopPieceItemIDs->childs)) {
                $shopCarItemIDs->childs = array_merge($shopCarItemIDs->childs, $shopPieceItemIDs->childs);
            }
        } else {
            $arr = array();
            foreach ($shopCarItemIDs->childs as $child) {
                $id = $child->values['shop_car_id'];
                $shopProductID = $child->values['shop_product_id'] . '_' . $child->values['price'];

                if (!key_exists($shopProductID, $arr)) {
                    $arr[$shopProductID] = $child;
                    $arr[$shopProductID]->additionDatas['ids'] = array($id => $id);
                } else {
                    $arr[$shopProductID]->values['quantity'] += $child->values['quantity'];
                    $arr[$shopProductID]->values['amount'] += $child->values['amount'];
                    $arr[$shopProductID]->additionDatas['ids'][$id] = $id;
                }
            }
            foreach ($shopPieceItemIDs->childs as $child) {
                $id = $child->values['shop_piece_id'];
                $shopProductID = $child->values['shop_product_id'] . '_' . $child->values['price'];

                if (!key_exists($shopProductID, $arr)) {
                    $arr[$shopProductID] = $child;
                    $arr[$shopProductID]->additionDatas['ids'] = array($id => $id);
                } else {
                    $arr[$shopProductID]->values['quantity'] += $child->values['quantity'];
                    $arr[$shopProductID]->values['amount'] += $child->values['amount'];
                    $arr[$shopProductID]->additionDatas['ids'][$id] = $id;
                }
            }

            $shopCarItemIDs->childs = $arr;
        }

        $total = new MyArray();
        $total->setIsFind();
        $total->values['quantity'] = 0;
        $total->values['amount'] = 0;
        $total->additionDatas['ids'] = array();
        $total->additionDatas['is_total'] = TRUE;
        foreach ($shopCarItemIDs->childs as $child) {
            $total->values['quantity'] += $child->values['quantity'];
            $total->values['amount'] += $child->values['amount'];

            if (key_exists('ids', $child->additionDatas)) {
                foreach ($child->additionDatas['ids'] as $id) {
                    $total->additionDatas['ids'][$id] = $id;
                }
            }
        }

        $shopCarItemIDs->childsSortBy(array(Model_Basic_BasicObject::FIELD_ELEMENTS . '.shop_product_id.name', 'quantity'));
        $shopCarItemIDs->childs[] = $total;

        $this->_sitePageData->replaceDatas['view::_shop/invoice/list/virtual/show'] = Helpers_View::getViewObjects(
            $shopCarItemIDs, new Model_Ab1_Shop_Car_Item(),
            '_shop/invoice/list/virtual/show', '_shop/invoice/one/virtual/show',
            $this->_sitePageData, $this->_driverDB
        );

        $balance = Api_Ab1_Shop_Client::calcBalance(
            $shopClientID, $this->_sitePageData, $this->_driverDB, $dateTo
        );
        $this->_sitePageData->replaceDatas['balance_cash'] = $balance['balance_cache'];
        $this->_sitePageData->replaceDatas['balance'] = $balance['balance'];

        $this->_sitePageData->replaceDatas['balance_contract'] = Api_Ab1_Shop_Client_Contract::calcBalance(
            $shopClientContractID, $this->_sitePageData, $this->_driverDB, $dateTo
        );
        $this->_sitePageData->replaceDatas['balance_attorney'] = Api_Ab1_Shop_Client_Attorney::calcBalance(
            $shopClientAttorneyID, $this->_sitePageData, $this->_driverDB, 0, $dateTo
        );

        // Акт сверки клиента
        $dateFrom = Request_RequestParams::getParamDate('act.date_from', array(), FALSE, NULL, true);
        if(empty($dateFrom)){
            $dateFrom = Helpers_DateTime::minusDays(date('Y-m-d'), 30);
        }
        $dateTo = Request_RequestParams::getParamDate('act.date_to', array(), FALSE, NULL, true);

        $this->_actionShopActReviseItemShopClient($shopClientID, $dateFrom, $dateTo, true);

        $this->_putInMain('/main/_shop/invoice/virtual/show');
    }

    public function action_virtual_edit() {
        $this->_sitePageData->url = '/sales/shopinvoice/virtual_edit';

        $shopClientID = Request_RequestParams::getParamInt('shop_client_id');
        $shopClientAttorneyID = Request_RequestParams::getParamInt('shop_client_attorney_id');
        $shopClientContractID = Request_RequestParams::getParamInt('shop_client_contract_id');

        $this->_requestShopClientAttorney(
            $shopClientID, $shopClientAttorneyID, 'option', Request_RequestParams::getParamDate('date_from')
        );
        $this->_requestShopClientContract($shopClientID, $shopClientContractID, 'list', null,
            Model_Ab1_ClientContract_Status::CLIENT_CONTRACT_STATUS_WORK);

        $dataID = new MyArray();
        $dataID->id = $shopClientID;

        $model = new Model_Ab1_Shop_Client();
        $model->setDBDriver($this->_driverDB);
        $result = Helpers_View::getViewObject(
            $dataID, $model, '_shop/invoice/one/virtual/edit',
            $this->_sitePageData, $this->_driverDB, $this->_sitePageData->shopMainID
        );

        $this->response->body($this->_sitePageData->replaceStaticDatas($result));
    }

    public function action_virtual_break() {
        $this->_sitePageData->url = '/sales/shopinvoice/virtual_break';

        $dateFrom = Request_RequestParams::getParamDateTime('date_from');
        $dateTo = Request_RequestParams::getParamDateTime('date_to');
        $shopClientIDFrom = intval(Request_RequestParams::getParamInt('shop_client_id_from'));
        $shopClientIDTo = intval(Request_RequestParams::getParamInt('shop_client_id_to'));
        $shopClientAttorneyIDFrom = intval(Request_RequestParams::getParamInt('shop_client_attorney_id_from'));
        $shopClientAttorneyIDTo = intval(Request_RequestParams::getParamInt('shop_client_attorney_id_to'));
        $shopClientContractIDFrom = intval(Request_RequestParams::getParamInt('shop_client_contract_id_from'));
        $shopClientContractIDTo = intval(Request_RequestParams::getParamInt('shop_client_contract_id_to'));
        $productTypeID = Request_RequestParams::getParamInt('product_type_id');
        $shopProductID = Request_RequestParams::getParamInt('shop_product_id');
        $isDelivery = Request_RequestParams::getParamBoolean('is_delivery');

        Api_Ab1_Shop_Car::breakAttorney(
            $dateFrom, $dateTo,
            $shopClientIDFrom, $shopClientIDTo,
            $shopClientAttorneyIDFrom, $shopClientAttorneyIDTo,
            $shopClientContractIDFrom, $shopClientContractIDTo,
            $productTypeID, $isDelivery, $shopProductID,
            Request_RequestParams::getParamFloat('amount'),
            $this->_sitePageData, $this->_driverDB
        );

        self::redirect(
            '/sales/shopinvoice/virtual_index'
            .URL::query(
                array(
                    'date_from' => $dateFrom,
                    'date_to' => $dateTo,
                    'shop_client_id' =>  array($shopClientIDFrom, $shopClientIDTo),
                ), FALSE
            )
        );
    }

    /**
     * Накладная клиенту
     * @throws HTTP_Exception_500
     */
    public function action_client_invoice() {
        $this->_sitePageData->url = '/sales/shopinvoice/client_invoice';

        // id записи
        $id = Request_RequestParams::getParamInt('id');
        $model = new Model_Ab1_Shop_Invoice();
        if (!$this->dublicateObjectLanguage($model, $id, -1, FALSE)) {
            throw new HTTP_Exception_404('Invoice not is found!');
        }

        $model->setIsGiveToClient(true);
        Helpers_DB::saveDBObject($model, $this->_sitePageData);

        self::redirect(
            '/sales/shopreport/invoice_one'
            . URL::query(
                array(
                    'id' => $id,
                ), FALSE
            )
        );
    }

    /**
     * Ставим отметку накладным и актам выполненных работ получено от клиента
     */
    public function action_received_from_client() {
        $this->_sitePageData->url = '/sales/shopinvoice/received_from_client';

        $params = array_merge($_GET, $_POST);
        unset($params['limit_page']);
        $params = Request_RequestParams::setParams($params);

        $shopInvoiceIDs = Request_Request::find('DB_Ab1_Shop_Invoice',
            $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB,
            $params, 0, TRUE
        );

        $model = new Model_Ab1_Shop_Invoice();
        $model->setDBDriver($this->_driverDB);
        foreach ($shopInvoiceIDs->childs as $child){
            $child->setModel($model);
            $model->setDateReceivedFromClient(date('Y-m-d H:i:s'));
            Helpers_DB::saveDBObject($model, $this->_sitePageData, $model->shopID);
        }

        $shopActServiceIDs = Request_Request::find('DB_Ab1_Shop_Act_Service',
            $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB,
            $params, 0, TRUE
        );

        $model = new Model_Ab1_Shop_Act_Service();
        $model->setDBDriver($this->_driverDB);
        foreach ($shopActServiceIDs->childs as $child) {
            $child->setModel($model);
            $model->setDateReceivedFromClient(date('Y-m-d H:i:s'));
            Helpers_DB::saveDBObject($model, $this->_sitePageData, $model->shopID);
        }

        self::redirect('/sales/shopinvoice/index' . URL::query(array('id' => ''), true));
    }

    /**
     * Ставим отметку накладным и актам выполненных работ отдано бухгалтерии
     */
    public function action_give_to_bookkeeping() {
        $this->_sitePageData->url = '/sales/shopinvoice/give_to_bookkeeping';

        $params = array_merge($_GET, $_POST);
        unset($params['limit_page']);
        $params = Request_RequestParams::setParams($params);

        $shopInvoiceIDs = Request_Request::find('DB_Ab1_Shop_Invoice',
            $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB,
            $params, 0, TRUE
        );

        $model = new Model_Ab1_Shop_Invoice();
        $model->setDBDriver($this->_driverDB);
        foreach ($shopInvoiceIDs->childs as $child){
            $child->setModel($model);
            if(!Func::_empty($model->getDateReceivedFromClient())) {
                $model->setDateGiveToBookkeeping(date('Y-m-d H:i:s'));
                Helpers_DB::saveDBObject($model, $this->_sitePageData, $model->shopID);
            }
        }

        $shopActServiceIDs = Request_Request::find('DB_Ab1_Shop_Act_Service',
            $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB,
            $params, 0, TRUE
        );

        $model = new Model_Ab1_Shop_Act_Service();
        $model->setDBDriver($this->_driverDB);
        foreach ($shopActServiceIDs->childs as $child) {
            $child->setModel($model);
            if(!Func::_empty($model->getDateReceivedFromClient())) {
                $model->setDateGiveToBookkeeping(date('Y-m-d H:i:s'));
                Helpers_DB::saveDBObject($model, $this->_sitePageData, $model->shopID);
            }
        }

        self::redirect('/sales/shopinvoice/index' . URL::query(array('id' => ''), true));
    }


    /**
     * Текущие цены
     * @throws HTTP_Exception_404
     */
    public function action_set_current_price() {
        $this->_sitePageData->url = '/sales/shopinvoice/set_current_price';


        $id = Request_RequestParams::getParamInt('shop_car_id');
        if($id > 0){
            Api_Ab1_Shop_Car::setCurrentPrice($id, $this->_sitePageData, $this->_driverDB);
        }else{
            $id = Request_RequestParams::getParamInt('shop_piece_id');
            Api_Ab1_Shop_Piece::setCurrentPrice(
                $id, $this->_sitePageData, $this->_driverDB, Request_RequestParams::getParamInt('shop_product_id')
            );
        }

        if(Request_RequestParams::getParamBoolean('is_edit_invoice')){
            $id = Request_RequestParams::getParamInt('id');
            Api_Ab1_Shop_Invoice::calcInvoiceAmount($id, $this->_sitePageData, $this->_driverDB, true);

            self::redirect('/sales/shopinvoice/edit' . URL::query(array('id' => $id, 'is_all' => true), false));
        }else {
            self::redirect('/sales/shopinvoice/virtual_show' . URL::query(array(), true));
        }
    }

    /**
     * Разбиваем реализацию по фиксированных балансам и устанавливаем цены
     */
    public function action_break_price_client_balance() {
        $this->_sitePageData->url = '/sales/shopinvoice/break_price_client_balance';

        $id = Request_RequestParams::getParamInt('shop_car_id');
        if($id > 0){
            Api_Ab1_Shop_Car::breakBalanceDay($id, $this->_sitePageData, $this->_driverDB);
        }else{
            $id = Request_RequestParams::getParamInt('shop_piece_id');
            Api_Ab1_Shop_Piece::breakBalanceDay(
                $id, $this->_sitePageData, $this->_driverDB, Request_RequestParams::getParamInt('shop_product_id')
            );
        }

        if(Request_RequestParams::getParamBoolean('is_edit_invoice')){
            $id = Request_RequestParams::getParamInt('id');
            Api_Ab1_Shop_Invoice::calcInvoiceAmount($id, $this->_sitePageData, $this->_driverDB, true);

            self::redirect('/sales/shopinvoice/edit' . URL::query(array('id' => $id, 'is_all' => true), false));
        }else {
            self::redirect('/sales/shopinvoice/virtual_show' . URL::query(array(), true));
        }
    }

    /**
     * Удаляем списывание фиксированных балансов
     * @throws HTTP_Exception_404
     */
    public function action_del_client_balance_days() {
        $this->_sitePageData->url = '/sales/shopinvoice/del_client_balance_days';

        $id = Request_RequestParams::getParamInt('shop_car_id');
        if($id > 0){
            Api_Ab1_Shop_Car::deleteClientBalanceDays($id, $this->_sitePageData, $this->_driverDB);
        }else{
            $id = Request_RequestParams::getParamInt('shop_piece_id');
            Api_Ab1_Shop_Piece::deleteClientBalanceDays(
                $id, $this->_sitePageData, $this->_driverDB, Request_RequestParams::getParamInt('shop_product_id')
            );
        }

        if(Request_RequestParams::getParamBoolean('is_edit_invoice')){
            $id = Request_RequestParams::getParamInt('id');
            Api_Ab1_Shop_Invoice::calcInvoiceAmount($id, $this->_sitePageData, $this->_driverDB, true);

            self::redirect('/sales/shopinvoice/edit' . URL::query(array('id' => $id, 'is_all' => true), false));
        }else {
            self::redirect('/sales/shopinvoice/virtual_show' . URL::query(array(), true));
        }
    }
}
