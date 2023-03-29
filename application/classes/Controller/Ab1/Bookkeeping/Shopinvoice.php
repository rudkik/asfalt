<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_Bookkeeping_ShopInvoice extends Controller_Ab1_Bookkeeping_BasicAb1 {

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
        $this->_sitePageData->url = '/bookkeeping/shopinvoice/index';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/invoice/list/index',
            )
        );

        $this->_requestShopProducts();

        $this->_requestOrganizationTypes();
        $organizationTypeIDs = Request_RequestParams::getParamArray('organization_type_ids');

        $this->_requestCheckTypes(Request_RequestParams::getParamInt('check_type_id'));
        if(Request_RequestParams::getParamBoolean('is_last_day')){
            $params = Request_RequestParams::setParams(
                array(
                    'shop_client_id.organization_type_id' => $organizationTypeIDs,
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
                'shop_client_id.organization_type_id' => $organizationTypeIDs,
                'limit' => 1000,
                'limit_page' => 25,
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
                'shop_client_id.organization_id' => array('name'),
            )
        );


        $this->_putInMain('/main/_shop/invoice/index');
    }

    public function action_add() {
        $this->_sitePageData->url = '/bookkeeping/shopinvoice/add';

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
            '/bookkeeping/shopinvoice/edit'
            . URL::query(
                array(
                    'id' => $result->id,
                ), FALSE
            )
        );
    }

    public function action_calc_invoice_price() {
        $this->_sitePageData->url = '/bookkeeping/shopinvoice/calc_invoice_price';

        $shopInvoiceID = Request_RequestParams::getParamInt('shop_invoice_id');

        Api_Ab1_Shop_Invoice::calcInvoicePrice(
            $shopInvoiceID, $this->_sitePageData, $this->_driverDB
        );

        self::redirect(
            '/bookkeeping/shopinvoice/edit' . URL::query(array('id' => $shopInvoiceID,))
        );
    }

    public function action_edit()
    {
        $this->_sitePageData->url = '/bookkeeping/shopinvoice/edit';
        $this->_actionShopInvoiceEdit();
    }

    public function action_save()
    {
        $this->_sitePageData->url = '/bookkeeping/shopinvoice/save';

        $result = Api_Ab1_Shop_Invoice::save($this->_sitePageData, $this->_driverDB);
        $this->_redirectSaveResult($result);
    }

    public function action_invoice_edit() {
        $this->_sitePageData->url = '/bookkeeping/shopinvoice/invoice_edit';
        $this->_actionShopInvoiceModalEdit();
    }

    public function action_discount_delete() {
        $this->_sitePageData->url = '/bookkeeping/shopinvoice/discount_delete';
        $this->_actionShopInvoiceDiscountDelete();
    }

    public function action_invoice_break() {
        $this->_sitePageData->url = '/bookkeeping/shopinvoice/invoice_break';

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
            '/bookkeeping/shopinvoice/index'
            .URL::query(
                array(
                    'id' => $shopInvoiceIDs,
                ), FALSE
            )
        );
    }

    /**
     * Накладная клиенту
     * @throws HTTP_Exception_500
     */
    public function action_client_invoice() {
        $this->_sitePageData->url = '/bookkeeping/shopinvoice/client_invoice';

        // id записи
        $id = Request_RequestParams::getParamInt('id');
        $model = new Model_Ab1_Shop_Invoice();
        if (!$this->dublicateObjectLanguage($model, $id, -1, FALSE)) {
            throw new HTTP_Exception_404('Invoice not is found!');
        }

        $model->setIsGiveToClient(true);
        Helpers_DB::saveDBObject($model, $this->_sitePageData);

        self::redirect(
            '/bookkeeping/shopreport/invoice_one'
            . URL::query(
                array(
                    'id' => $id,
                ), FALSE
            )
        );
    }

    /**
     * Текущие цены
     * @throws HTTP_Exception_404
     */
    public function action_set_current_price() {
        $this->_sitePageData->url = '/bookkeeping/shopinvoice/set_current_price';


        $id = Request_RequestParams::getParamInt('shop_car_id');
        if($id > 0){
            Api_Ab1_Shop_Car::setCurrentPrice($id, $this->_sitePageData, $this->_driverDB);
        }else{
            $id = Request_RequestParams::getParamInt('shop_piece_id');
            if($id > 0) {
                Api_Ab1_Shop_Piece::setCurrentPrice(
                    $id, $this->_sitePageData, $this->_driverDB, Request_RequestParams::getParamInt('shop_product_id')
                );
            }else{
                $dateFrom = Request_RequestParams::getParamDateTime('date_from');
                $dateTo = Request_RequestParams::getParamDateTime('date_to');

                $params = Request_RequestParams::setParams(
                    array(
                        'exit_at_from' => $dateFrom,
                        'exit_at_to' => $dateTo,
                        'shop_client_id' => Request_RequestParams::getParamInt('shop_client_id'),
                        'shop_client_attorney_id' => Request_RequestParams::getParamInt('shop_client_attorney_id'),
                        'shop_client_contract_id' => Request_RequestParams::getParamInt('shop_client_contract_id'),
                        'shop_product_id.product_type_id' => Request_RequestParams::getParamInt('product_type_id'),
                        'is_exit' => TRUE,
                        'is_charity' => FALSE,
                        'is_delivery' => Request_RequestParams::getParamBoolean('is_delivery'),
                        'shop_invoice_id' => 0,
                        'quantity_from' => 0,
                        'group_by' => [
                            'shop_car_id',
                            'shop_price_id',
                        ]
                    )
                );

                // получаем список реализации
                $shopCarIDs = Request_Request::find('DB_Ab1_Shop_Car_Item',
                    $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB,
                    $params, 0, TRUE
                );

                foreach ($shopCarIDs->childs as $child){
                    Api_Ab1_Shop_Car::setCurrentPrice($child->values['shop_car_id'], $this->_sitePageData, $this->_driverDB);
                }

                $shopProductID = Request_RequestParams::getParamInt('shop_product_id');

                $shopPieceIDs = Request_Request::find('DB_Ab1_Shop_Piece_Item',
                    $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB,
                    $params, 0, TRUE
                );
                foreach ($shopPieceIDs->childs as $child){
                    Api_Ab1_Shop_Piece::setCurrentPrice($child->values['shop_piece_id'], $this->_sitePageData, $this->_driverDB, $shopProductID);
                }
            }
        }

        if(Request_RequestParams::getParamBoolean('is_edit_invoice')){
            $id = Request_RequestParams::getParamInt('id');
            Api_Ab1_Shop_Invoice::calcInvoiceAmount($id, $this->_sitePageData, $this->_driverDB, true);

            self::redirect('/bookkeeping/shopinvoice/edit' . URL::query(array('id' => $id, 'is_all' => true), false));
        }else {
            self::redirect('/bookkeeping/shopinvoice/index' . URL::query(array(), true));
        }
    }

    /**
     * Разбиваем реализацию по фиксированных балансам и устанавливаем цены
     */
    public function action_break_price_client_balance() {
        $this->_sitePageData->url = '/bookkeeping/shopinvoice/break_price_client_balance';

        $id = Request_RequestParams::getParamInt('shop_car_id');
        if($id > 0){
            Api_Ab1_Shop_Car::breakBalanceDay($id, $this->_sitePageData, $this->_driverDB);
        }else{
            $id = Request_RequestParams::getParamInt('shop_piece_id');
            if($id > 0) {
                Api_Ab1_Shop_Piece::breakBalanceDay(
                    $id, $this->_sitePageData, $this->_driverDB, Request_RequestParams::getParamInt('shop_product_id')
                );
            }else{
                $dateFrom = Request_RequestParams::getParamDateTime('date_from');
                $dateTo = Request_RequestParams::getParamDateTime('date_to');

                $params = Request_RequestParams::setParams(
                    array(
                        'exit_at_from' => $dateFrom,
                        'exit_at_to' => $dateTo,
                        'shop_client_id' => Request_RequestParams::getParamInt('shop_client_id'),
                        'shop_client_attorney_id' => Request_RequestParams::getParamInt('shop_client_attorney_id'),
                        'shop_client_contract_id' => Request_RequestParams::getParamInt('shop_client_contract_id'),
                        'shop_product_id.product_type_id' => Request_RequestParams::getParamInt('product_type_id'),
                        'is_exit' => TRUE,
                        'is_charity' => FALSE,
                        'is_delivery' => Request_RequestParams::getParamBoolean('is_delivery'),
                        'shop_invoice_id' => 0,
                        'quantity_from' => 0,
                        'group_by' => [
                            'shop_car_id',
                            'shop_price_id',
                        ]
                    )
                );

                // получаем список реализации
                $shopCarIDs = Request_Request::find('DB_Ab1_Shop_Car_Item',
                    $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB,
                    $params, 0, TRUE
                );

                foreach ($shopCarIDs->childs as $child){
                    Api_Ab1_Shop_Car::breakBalanceDay($child->values['shop_car_id'], $this->_sitePageData, $this->_driverDB);
                }

                $shopProductID = Request_RequestParams::getParamInt('shop_product_id');

                $shopPieceIDs = Request_Request::find('DB_Ab1_Shop_Piece_Item',
                    $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB,
                    $params, 0, TRUE
                );
                foreach ($shopPieceIDs->childs as $child){
                    Api_Ab1_Shop_Piece::breakBalanceDay($child->values['shop_piece_id'], $this->_sitePageData, $this->_driverDB, $shopProductID);
                }
            }
        }

        if(Request_RequestParams::getParamBoolean('is_edit_invoice')){
            $id = Request_RequestParams::getParamInt('id');
            Api_Ab1_Shop_Invoice::calcInvoiceAmount($id, $this->_sitePageData, $this->_driverDB, true);

            self::redirect('/bookkeeping/shopinvoice/edit' . URL::query(array('id' => $id, 'is_all' => true), false));
        }else {
            self::redirect('/bookkeeping/shopinvoice/index' . URL::query(array(), true));
        }
    }

    /**
     * Удаляем списывание фиксированных балансов
     * @throws HTTP_Exception_404
     */
    public function action_del_client_balance_days() {
        $this->_sitePageData->url = '/bookkeeping/shopinvoice/del_client_balance_days';

        $id = Request_RequestParams::getParamInt('shop_car_id');
        if($id > 0){
            Api_Ab1_Shop_Car::deleteClientBalanceDays($id, $this->_sitePageData, $this->_driverDB);
        }else{
            $id = Request_RequestParams::getParamInt('shop_piece_id');
            if($id > 0) {
                Api_Ab1_Shop_Piece::deleteClientBalanceDays(
                    $id, $this->_sitePageData, $this->_driverDB, Request_RequestParams::getParamInt('shop_product_id')
                );
            }else{
                $dateFrom = Request_RequestParams::getParamDateTime('date_from');
                $dateTo = Request_RequestParams::getParamDateTime('date_to');

                $params = Request_RequestParams::setParams(
                    array(
                        'exit_at_from' => $dateFrom,
                        'exit_at_to' => $dateTo,
                        'shop_client_id' => Request_RequestParams::getParamInt('shop_client_id'),
                        'shop_client_attorney_id' => Request_RequestParams::getParamInt('shop_client_attorney_id'),
                        'shop_client_contract_id' => Request_RequestParams::getParamInt('shop_client_contract_id'),
                        'shop_product_id.product_type_id' => Request_RequestParams::getParamInt('product_type_id'),
                        'is_exit' => TRUE,
                        'is_charity' => FALSE,
                        'is_delivery' => Request_RequestParams::getParamBoolean('is_delivery'),
                        'shop_invoice_id' => 0,
                        'quantity_from' => 0,
                        'group_by' => [
                            'shop_car_id',
                            'shop_price_id',
                        ]
                    )
                );

                // получаем список реализации
                $shopCarIDs = Request_Request::find('DB_Ab1_Shop_Car_Item',
                    $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB,
                    $params, 0, TRUE
                );

                foreach ($shopCarIDs->childs as $child){
                    Api_Ab1_Shop_Car::deleteClientBalanceDays($child->values['shop_car_id'], $this->_sitePageData, $this->_driverDB);
                }

                $shopProductID = Request_RequestParams::getParamInt('shop_product_id');

                $shopPieceIDs = Request_Request::find('DB_Ab1_Shop_Piece_Item',
                    $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB,
                    $params, 0, TRUE
                );
                foreach ($shopPieceIDs->childs as $child){
                    Api_Ab1_Shop_Piece::deleteClientBalanceDays($child->values['shop_piece_id'], $this->_sitePageData, $this->_driverDB, $shopProductID);
                }
            }
        }

        if(Request_RequestParams::getParamBoolean('is_edit_invoice')){
            $id = Request_RequestParams::getParamInt('id');
            Api_Ab1_Shop_Invoice::calcInvoiceAmount($id, $this->_sitePageData, $this->_driverDB, true);

            self::redirect('/bookkeeping/shopinvoice/edit' . URL::query(array('id' => $id, 'is_all' => true), false));
        }else {
            self::redirect('/bookkeeping/shopinvoice/index' . URL::query(array(), true));
        }
    }

    /**
     * Ставим отметку накладным и актам выполненных работ получено от клиента
     */
    public function action_received_from_client() {
        $this->_sitePageData->url = '/bookkeeping/shopinvoice/received_from_client';

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

        self::redirect('/bookkeeping/shopinvoice/index' . URL::query(array('id' => ''), true));
    }

    /**
     * Ставим отметку накладным и актам выполненных работ отдано бухгалтерии
     */
    public function action_give_to_bookkeeping() {
        $this->_sitePageData->url = '/bookkeeping/shopinvoice/give_to_bookkeeping';

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

        self::redirect('/bookkeeping/shopinvoice/index' . URL::query(array('id' => ''), true));
    }
}