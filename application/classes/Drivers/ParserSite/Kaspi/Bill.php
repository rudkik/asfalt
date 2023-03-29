<?php defined('SYSPATH') or die('No direct script access.');


class Drivers_ParserSite_Kaspi_Bill {
    /**
     * Авторизация в личном кабинете
     * Возвращает соедение для запроса и настройки подключения
     * https://kaspi.kz/merchantcabinet
     * @param $shopCompanyID
     * @param array $options
     * @return resource
     */
    public static function authToken($shopCompanyID, array &$options)
    {
        $params = Drivers_ParserSite_Kaspi::getConnectionOptions($shopCompanyID);
        $token = $params['token'];

        $opt = array(
            CURLOPT_ENCODING => 'gzip',
            CURLOPT_COOKIE => '',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_AUTOREFERER => true,
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_HEADER => false,
            CURLOPT_COOKIESESSION => true,
            CURLOPT_REFERER => null,
            CURLOPT_TIMEOUT => 10,
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_FOLLOWLOCATION => 1,
            CURLOPT_SSL_VERIFYPEER => FALSE,
            CURLOPT_HTTPHEADER => array(
                'Content-type: application/vnd.api+json',
                'X-Auth-Token: ' . $token,
            ),
        );

        $cs = curl_init();

        $options = $opt;
        return $cs;
    }

    /**
     * Считываем заказы заданного статуса и выбранных период
     * https://kaspi.kz/shop/api/v2/orders
     * @param $status
     * @param $dateFrom
     * @param $dateTo
     * @param $curlInit
     * @param array $curlOptions
     * @return mixed
     */
    private static function _loadBills($status, $dateFrom, $dateTo, $curlInit, array $curlOptions)
    {
        $params = array(
            'page' => [
                'number' => 0,
                'size' => 1000
            ],
            'filter' => [
                'orders' => [
                    'state' => $status,
                    'creationDate' => [
                        '$ge' => strtotime($dateFrom) * 1000,
                        '$le' => strtotime($dateTo) * 1000,
                    ],
                ]
            ],
        );

        $curlOptions[CURLOPT_URL] = 'https://kaspi.kz/shop/api/v2/orders' . URL::query($params, false);
        curl_setopt_array($curlInit, $curlOptions);
        $result = curl_exec($curlInit);

        return json_decode($result, true);
    }

    /**
     * Получение списка товаров заказа
     * https://kaspi.kz/shop/api/v2/orders/{billID}/entries
     * @param $billID
     * @param $curlInit
     * @param array $curlOptions
     * @return mixed
     */
    private static function _loadBillItems($billID, $curlInit, array $curlOptions)
    {
        $curlOptions[CURLOPT_URL] = 'https://kaspi.kz/shop/api/v2/orders/' . $billID . '/entries';
        curl_setopt_array($curlInit, $curlOptions);
        $result = curl_exec($curlInit);

        return json_decode($result, true);
    }

    /**
     * Получение списка товаров заказа
     * https://kaspi.kz/shop/api/v2/orderentries/{productID}/product
     * @param $productID
     * @param $curlInit
     * @param array $curlOptions
     * @return mixed
     */
    private static function _loadProduct($productID, $curlInit, array $curlOptions)
    {
        $curlOptions[CURLOPT_URL] = 'https://kaspi.kz/shop/api/v2/orderentries/' . $productID . '/product';
        curl_setopt_array($curlInit, $curlOptions);
        $result = curl_exec($curlInit);

        return json_decode($result, true)['data'];
    }

    /**
     * Получаем продукт заказа
     * @param $productID
     * @param $curlInit
     * @param array $curlOptions
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @return array
     */
    private static function _getBillProduct($productID, $curlInit, array $curlOptions,
                                            SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver){
        $product = self::_loadProduct($productID, $curlInit, $curlOptions);

        $productSource = Request_Request::findOne(
            DB_AutoPart_Shop_Product_Source::NAME, $sitePageData->shopID,
            $sitePageData, $driver,
            Request_RequestParams::setParams(
                [
                    'source_site_id_full' => $product['attributes']['code'],
                ]
            ),
            [
                'shop_rubric_source_id' => ['commission', 'is_sale', 'commission_sale'],
                'shop_product_id' => ['name'],
            ]
        );

        $id = 0;
        $commission = Controller_Smg_Kaspi::PERCENT;
        if($productSource != null){
            $id = $productSource->values['shop_product_id'];

            if($productSource->getElementValue('shop_rubric_source_id', 'is_sale') == 1){
                $commission = $productSource->getElementValue('shop_rubric_source_id', 'commission_sale', $commission);
            }else{
                $commission = $productSource->getElementValue('shop_rubric_source_id', 'commission', $commission);
            }
            if($commission == 0){
                $commission = Controller_Smg_Kaspi::PERCENT;
            }

            $productName = $productSource->getElementValue('shop_product_id');
        }else{
            $productName = '';
        }

        return [
            'name' => Func::mb_str_replace('  ', ' ', trim($product['attributes']['name'])),
            'product' => $productName,
            'id' => $id,
            'commission' => $commission,
        ];
    }

    /**
     * Получаем ID объекта
     * @param $dbObject
     * @param $oldID
     * @param $shopSourceID
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @return int
     */
    private static function _getObjectTypeID($dbObject, $oldID, $shopSourceID, SitePageData $sitePageData,
                                             Model_Driver_DBBasicDriver $driver){
        return Request_Request::findID(
            $dbObject, $sitePageData->shopID,
            Request_RequestParams::setParams(
                [
                    'shop_source_id' => $shopSourceID,
                    'old_id_full' => $oldID,
                ]
            ),
            $sitePageData, $driver
        );
    }

    /**
     * Получае ID с адресом доставки
     * @param array $deliveryOptions
     * @param $shopSourceID
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @return int
     */
    private static function _getDelivery(array $deliveryOptions, $shopSourceID, SitePageData $sitePageData,
                                         Model_Driver_DBBasicDriver $driver){

        /** @var Model_AutoPart_Shop_Bill_Delivery_Address $model */
        $model = Request_Request::findOneModel(
            DB_AutoPart_Shop_Bill_Delivery_Address::NAME, $sitePageData->shopID, $sitePageData, $driver,
            Request_RequestParams::setParams(
                [
                    'shop_source_id' => $shopSourceID,
                    'name_full' => $deliveryOptions['formattedAddress'],
                ]
            )
        );

        if($model != null){
            /*$model->setLatitude($deliveryOptions['latitude']);
            $model->setLongitude($deliveryOptions['longitude']);
            Helpers_DB::saveDBObject($model, $sitePageData);*/

            return $model->id;
        }

        $model = new Model_AutoPart_Shop_Bill_Delivery_Address();
        $model->setDBDriver($driver);

        $model->setStreet($deliveryOptions['streetName']);
        $model->setCityName($deliveryOptions['town']);
        //$model->setDistrict($deliveryOptions['district']);
        $model->setHouse($deliveryOptions['building']);
        $model->setApartment($deliveryOptions['apartment']);
        $model->setName($deliveryOptions['formattedAddress']);
        $model->setLatitude($deliveryOptions['latitude']);
        $model->setLongitude($deliveryOptions['longitude']);
        $model->setShopSourceID($shopSourceID);

        return Helpers_DB::saveDBObject($model, $sitePageData);
    }

    /**
     * Получае ID с адресом доставки
     * @param array $buyerOptions
     * @param $shopSourceID
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @return int
     */
    private static function _getBuyer(array $buyerOptions, $shopSourceID, SitePageData $sitePageData,
                                      Model_Driver_DBBasicDriver $driver){

        /** @var Model_AutoPart_Shop_Bill_Buyer $model */
        $model = Request_Request::findOneModel(
            DB_AutoPart_Shop_Bill_Buyer::NAME, $sitePageData->shopID, $sitePageData, $driver,
            Request_RequestParams::setParams(
                [
                    'shop_source_id' => $shopSourceID,
                    'old_id_full' => $buyerOptions['id'],
                ]
            )
        );

        if($model != null){
            return $model->id;
        }

        $model = new Model_AutoPart_Shop_Bill_Buyer();
        $model->setDBDriver($driver);

        $model->setOldID($buyerOptions['id']);
        $model->setPhone($buyerOptions['cellPhone']);
        $model->setFirstName($buyerOptions['firstName']);
        $model->setLastName($buyerOptions['lastName']);
        $model->setShopSourceID($shopSourceID);

        return Helpers_DB::saveDBObject($model, $sitePageData);
    }

    /**
     * Получаем фактическую дату доставку
     * https://kaspi.kz/merchantcabinet/api/order/details/%7Bstatus%7D/№ заказа
     * @param $billID
     * @param $shopCompanyID
     * @return array|mixed
     */
    private static function _getBillDeliveryAt($billID, $shopCompanyID){
        $curl = Drivers_ParserSite_Kaspi::authMerchantСabinetV2($shopCompanyID);

        $curl->setHeader('Content-type', 'application/json; charset=utf-8');
        $curl->get('https://kaspi.kz/merchantcabinet/api/order/details/%7Bstatus%7D/' . $billID);

        $result = json_decode($curl->getRawResponse(), true);

        $date = Arr::path($result, 'issueDate', null);
        if($date != null){
            $date = date('Y-m-d H:i:s', $date / 1000);
        }

        return $date;
    }

    /**
     * Задаем данные для заказа
     * @param Model_AutoPart_Shop_Bill $model
     * @param array $billOptions
     * @param $shopCompanyID
     * @param $shopSourceID
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     */
    private static function _setOptionsBill(Model_AutoPart_Shop_Bill $model, array $billOptions, $shopCompanyID, $shopSourceID,
                                            SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver){
        $model->setBillSourceID($billOptions['id']);
        $model->setOldID($billOptions['attributes']['code']);
        $model->setAmount($billOptions['attributes']['totalPrice']);
        $model->setShopBillPaymentTypeID(
            self::_getObjectTypeID(
                DB_AutoPart_Shop_Bill_PaymentType::NAME, $billOptions['attributes']['paymentMode'],
                $shopSourceID, $sitePageData, $driver
            )
        );

        if(key_exists('cancellationReason', $billOptions['attributes'])) {
            $model->setShopBillCancelTypeID(
                self::_getObjectTypeID(
                    DB_AutoPart_Shop_Bill_CancelType::NAME, $billOptions['attributes']['cancellationReason'],
                    $shopSourceID, $sitePageData, $driver
                )
            );
        }

        if(key_exists('plannedDeliveryDate', $billOptions['attributes'])) {
            $model->setDeliveryPlanAt(date('Y-m-d H:i:s', $billOptions['attributes']['plannedDeliveryDate'] / 1000));
        }

        /*if($billOptions['attributes']['status'] == 'COMPLETED'){
            echo '<pre>';
            print_r($billOptions);die;
        }*/

        if(key_exists('reservationDate', $billOptions['attributes']) && !empty($billOptions['attributes']['reservationDate'])) {
            $model->setDeliveryAt(date('Y-m-d H:i:s', $billOptions['attributes']['reservationDate'] / 1000));
        }

        $model->setCreatedAt(date('Y-m-d H:i:s', $billOptions['attributes']['creationDate'] / 1000));
        $model->setDeliverySourceAmount($billOptions['attributes']['deliveryCostForSeller']);
        $model->setIsDeliverySource($billOptions['attributes']['isKaspiDelivery']);
        $model->setShopBillDeliveryTypeID(
            self::_getObjectTypeID(
                DB_AutoPart_Shop_Bill_Delivery_Type::NAME, $billOptions['attributes']['deliveryMode'],
                $shopSourceID, $sitePageData, $driver
            )
        );

        if(key_exists('deliveryAddress', $billOptions['attributes'])) {
            $model->setDeliveryAddress($billOptions['attributes']['deliveryAddress']['formattedAddress']);
            $model->setShopBillDeliveryAddressID(
                self::_getDelivery($billOptions['attributes']['deliveryAddress'], $shopSourceID, $sitePageData, $driver)
            );
        }

        $model->setIsSignSource($billOptions['attributes']['signatureRequired']);
        $model->setCreditSource(Arr::path($billOptions['attributes'], 'creditTerm', 0));
        $model->setIsPreOrder($billOptions['attributes']['preOrder']);
        $model->setShopBillStateSourceID(
            self::_getObjectTypeID(
                DB_AutoPart_Shop_Bill_State_Source::NAME, $billOptions['attributes']['state'],
                $shopSourceID, $sitePageData, $driver
            )
        );
        $model->setApproveSourceAt(date('Y-m-d H:i:s', $billOptions['attributes']['approvedByBankDate'] / 1000));
        $model->setShopBillStatusSourceID(
            self::_getObjectTypeID(
                DB_AutoPart_Shop_Bill_Status_Source::NAME, $billOptions['attributes']['status'],
                $shopSourceID, $sitePageData, $driver
            )
        );

        $model->setBuyer($billOptions['attributes']['customer']['firstName'] . ' ' . $billOptions['attributes']['customer']['lastName']);
        $model->setShopBillBuyerID(
            self::_getBuyer($billOptions['attributes']['customer'], $shopSourceID, $sitePageData, $driver)
        );

        $model->setDeliveryAmount($billOptions['attributes']['deliveryCost']);


        // считываем дополнительно время доставки через личный кабинет
        if(($model->getShopBillStatusSourceID() == Model_AutoPart_Shop_Bill_Status_Source::STATUS_COMPLETED
            || $model->getShopBillStatusSourceID() == Model_AutoPart_Shop_Bill_Status_Source::STATUS_RETURN)
            && Func::_empty($model->getDeliveryAt())){
            $model->setDeliveryAt(self::_getBillDeliveryAt($model->getOldID(), $shopCompanyID));
        }
    }

    /**
     * Добавляем новый товар заказа
     * @param Model_AutoPart_Shop_Bill $modelBill
     * @param Model_AutoPart_Shop_Bill_Item $modelItem
     * @param array $billItem
     * @param $curlInit
     * @param array $curlOptions
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     */
    public static function _addBillItem(Model_AutoPart_Shop_Bill $modelBill, Model_AutoPart_Shop_Bill_Item $modelItem, array $billItem,
                                        $curlInit, array $curlOptions, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver){
        $modelItem->setShopBillID($modelBill->id);
        $modelItem->setShopSourceID($modelBill->getShopSourceID());
        $modelItem->setShopCompanyID($modelBill->getShopCompanyID());

        $modelItem->setPrice($billItem['attributes']['basePrice']);
        $modelItem->setQuantity($billItem['attributes']['quantity']);
        $modelItem->setDeliveryAmount($billItem['attributes']['deliveryCost']);

        $product = self::_getBillProduct($billItem['id'], $curlInit, $curlOptions, $sitePageData, $driver);
        $modelItem->setName($product['name']);
        $modelItem->setShopProductID($product['id']);
        if($modelItem->getShopProductID() != $modelItem->getOriginalValue('shop_product_id')) {
            $modelItem->setCommissionSource($product['commission']);
        }

        switch ($modelBill->getShopBillStatusSourceID()){
            case Model_AutoPart_Shop_Bill_Status::STATUS_CANCEL:
                $modelItem->setShopBillItemStatusID(Model_AutoPart_Shop_Bill_Item_Status::STATUS_CANCEL);
                break;
            case Model_AutoPart_Shop_Bill_Status::STATUS_DELIVERY:
                $modelItem->setShopBillItemStatusID(Model_AutoPart_Shop_Bill_Item_Status::STATUS_DELIVERY);
                break;
            case Model_AutoPart_Shop_Bill_Status::STATUS_RETURN:
                $modelItem->setShopBillItemStatusID(Model_AutoPart_Shop_Bill_Item_Status::STATUS_RETURN);
                break;
            default:
                if($modelItem->getShopBillItemStatusID() == 0) {
                    $modelItem->setShopBillItemStatusID(Model_AutoPart_Shop_Bill_Item_Status::STATUS_NEW);
                }
        }

        Helpers_DB::saveDBObject($modelItem, $sitePageData);

        return $product;
    }

    /**
     * Добавляем новый заказ
     * @param array $billOptions
     * @param array $billItemsOptions
     * @param $shopCompanyID
     * @param $shopSourceID
     * @param $curlInit
     * @param array $curlOptions
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @return Model_AutoPart_Shop_Bill
     */
    public static function _addBill(array $billOptions, array $billItemsOptions, $shopCompanyID, $shopSourceID,
                                    $curlInit, array $curlOptions, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver){

        $modelBill = new Model_AutoPart_Shop_Bill();
        $modelBill->setDBDriver($driver);

        $modelBill->setShopSourceID($shopSourceID);
        $modelBill->setShopCompanyID($shopCompanyID);

        // задаем данные для заказа
        self::_setOptionsBill($modelBill, $billOptions, $shopCompanyID, $shopSourceID, $sitePageData, $driver);

        Helpers_DB::saveDBObject($modelBill, $sitePageData);

        $modelItem = new Model_AutoPart_Shop_Bill_Item();
        $modelItem->setDBDriver($driver);

        $text = '';
        $products = '';
        foreach ($billItemsOptions['data'] as $billItem){
            $modelItem->clear();
            $product = self::_addBillItem($modelBill, $modelItem, $billItem, $curlInit, $curlOptions, $sitePageData, $driver);

            $text .= $product['name'] . "\r\n";
            $products .= $product['product'] . "\r\n";
        }

        $modelBill->setText(trim($text));
        $modelBill->setProducts(trim($products));

        return $modelBill;
    }

    /**
     * Обновляем статусы товаров заказа, если это необходимо
     * @param Model_AutoPart_Shop_Bill $modelBill
     * @param array $billItemsOptions
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     */
    public static function _updateBillItem(Model_AutoPart_Shop_Bill $modelBill, array $billItemsOptions,
                                           $curlInit, array $curlOptions, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver){

        $ids = Request_Request::find(
            DB_AutoPart_Shop_Bill_Item::NAME, $sitePageData->shopID, $sitePageData, $driver,
            Request_RequestParams::setParams(
                [
                    'shop_bill_id' => $modelBill->id,
                    'sort_by' => ['created_at' => 'asc'],
                ]
            ),
            0, true, ['shop_product_id' => ['name']]
        );

        $modelItem = new Model_AutoPart_Shop_Bill_Item();
        $modelItem->setDBDriver($driver);

        foreach ($ids->childs as $child){
            $billItem = array_shift($billItemsOptions['data']);

            $child->setModel($modelItem);
            self::_addBillItem($modelBill, $modelItem, $billItem, $curlInit, $curlOptions, $sitePageData, $driver);

            Helpers_DB::saveDBObject($modelItem, $sitePageData);
        }

        if(count($billItemsOptions['data']) > 0) {
            $text = $modelBill->getText();
            $products = $modelBill->getProducts();
            foreach ($billItemsOptions['data'] as $billItem) {
                $modelItem->clear();
                $product = self::_addBillItem($modelBill, $modelItem, $billItem, $curlInit, $curlOptions, $sitePageData, $driver);

                $text .= "\r\n" . $product['name'];
                $products .= "\r\n" . $product['product'];
            }

            $modelBill->setText(trim($text));
            $modelBill->setProducts(trim($products));
        }
    }

    /**
     * Считываем заказы заданного статуса и выбранных период
     * @param $shopCompanyID
     * @param $shopSourceID
     * @param $status
     * @param $dateFrom
     * @param $dateTo
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @throws HTTP_Exception_500
     */
    public static function loadBillsByPeriod($shopCompanyID, $shopSourceID, $status, $dateFrom, $dateTo, SitePageData $sitePageData,
                                             Model_Driver_DBBasicDriver $driver){
        if($shopSourceID < 1){
            throw new HTTP_Exception_500('Source not found.');
        }

        $curlOptions = array();
        $curlInit = self::authToken($shopCompanyID, $curlOptions);

        if(empty($dateFrom)){
            $dateFrom = Helpers_DateTime::minusDays(date('Y-m-d'), 13);
        }
        if(empty($dateTo) || strtotime($dateTo) > strtotime(date('Y-m-d'))){
            $dateTo = date('Y-m-d');
        }

        $dateFrom = Helpers_DateTime::getDateFormatPHP($dateFrom) . ' 23:59:59';
        $dateTo = Helpers_DateTime::getDateFormatPHP($dateTo);

        $bills = [];
        $shift = 1;
        while (strtotime($dateFrom) < strtotime($dateTo)){
            $list = self::_loadBills($status, $dateFrom, Helpers_DateTime::plusDays($dateFrom, $shift), $curlInit, $curlOptions);
            if(empty($list)){
                echo 'жопа'; die;
                $shift = 1;
                $list = self::_loadBills($status, $dateFrom, Helpers_DateTime::plusDays($dateFrom, $shift), $curlInit, $curlOptions);
            }

            if(is_array($list) && key_exists('data', $list)){
                foreach ($list['data'] as $bill){
                    $bills[] = $bill;
                }
            }

            $dateFrom = Helpers_DateTime::plusDays($dateFrom, $shift);
        }

        foreach ($bills as $bill){
            /** @var Model_AutoPart_Shop_Bill $modelBill */
            $modelBill = Request_Request::findOneModel(
                DB_AutoPart_Shop_Bill::NAME, $sitePageData->shopID, $sitePageData, $driver,
                Request_RequestParams::setParams(
                    [
                        'shop_source_id' => $shopSourceID,
                        //'shop_company_id' => $shopCompanyID,
                        'old_id_full' => $bill['attributes']['code'],
                    ]
                )
            );

            $billItems = self::_loadBillItems($bill['id'], $curlInit, $curlOptions);

            if($modelBill === false){
                $modelBill = self::_addBill(
                    $bill, $billItems, $shopCompanyID, $shopSourceID, $curlInit, $curlOptions, $sitePageData, $driver
                );
            }else {
                self::_setOptionsBill($modelBill, $bill, $shopCompanyID, $shopSourceID, $sitePageData, $driver);
                self::_updateBillItem($modelBill, $billItems, $curlInit, $curlOptions, $sitePageData, $driver);
            }

            $total = Api_AutoPart_Shop_Bill::calcTotal($modelBill->id, $sitePageData, $driver);
            $modelBill->setQuantity($total['quantity']);
            $modelBill->setAmount($total['amount']);

            Helpers_DB::saveDBObject($modelBill, $sitePageData);
        }
    }

    /**
     * Считываем заказы заданного статуса и выбранных период
     * @param $shopCompanyID
     * @param $shopSourceID
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @throws HTTP_Exception_500
     */
    public static function loadBills($shopCompanyID, $shopSourceID, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        if($shopCompanyID != 2){
            return false;
        }

        if ($shopSourceID < 1) {
            throw new HTTP_Exception_500('Source not found.');
        }

        self::loadBillsByPeriod(
            $shopCompanyID, $shopSourceID, 'NEW',
            Helpers_DateTime::minusDays(Helpers_DateTime::getCurrentDatePHP(), 3),
            Helpers_DateTime::getCurrentDatePHP(),
            $sitePageData, $driver
        );

        self::loadBillsByPeriod(
            $shopCompanyID, $shopSourceID, 'ARCHIVE',
            Helpers_DateTime::minusDays(Helpers_DateTime::getCurrentDatePHP(), 3),
            Helpers_DateTime::getCurrentDatePHP(),
            $sitePageData, $driver
        );


        self::loadBillsByPeriod(
            $shopCompanyID, $shopSourceID, 'ARCHIVE',
            Helpers_DateTime::minusDays(Helpers_DateTime::getCurrentDatePHP(), 14),
            Helpers_DateTime::minusDays(Helpers_DateTime::getCurrentDatePHP(), 3),
            $sitePageData, $driver
        );

        self::loadBillsByPeriod(
            $shopCompanyID, $shopSourceID, 'SIGN_REQUIRED',
            Helpers_DateTime::minusDays(Helpers_DateTime::getCurrentDatePHP(), 12),
            Helpers_DateTime::getCurrentDatePHP(),
            $sitePageData, $driver
        );

        /*self::loadBillsByPeriod(
            $shopCompanyID, $shopSourceID, 'PICKUP',
            Helpers_DateTime::minusDays(Helpers_DateTime::getCurrentDatePHP(), 12),
            Helpers_DateTime::getCurrentDatePHP(),
            $sitePageData, $driver
        );*/

        self::loadBillsByPeriod(
            $shopCompanyID, $shopSourceID, 'DELIVERY',
            Helpers_DateTime::minusDays(Helpers_DateTime::getCurrentDatePHP(), 12),
            Helpers_DateTime::getCurrentDatePHP(),
            $sitePageData, $driver
        );

        /*self::loadBillsByPeriod(
            $shopCompanyID, $shopSourceID, 'KASPI_DELIVERY',
            Helpers_DateTime::minusDays(Helpers_DateTime::getCurrentDatePHP(), 1),
            Helpers_DateTime::getCurrentDatePHP(),
            $sitePageData, $driver
        );*/
    }

    /**
     * Подтверждение заказа
     * @param Model_AutoPart_Shop_Bill $model
     * @param string $secretCode
     * @return bool
     */
    private static function _completedBill(Model_AutoPart_Shop_Bill $model, $secretCode = '')
    {
        $curlOptions = array();
        $curlInit = self::authToken($model->getShopCompanyID(), $curlOptions);

        $curlOptions[CURLOPT_HTTPHEADER][] = 'X-Security-Code: ' . $secretCode;
        $curlOptions[CURLOPT_HTTPHEADER][] = 'X-Send-Code: true';

        $params = array(
            'data' => [
                'type' => 'orders',
                'id' => $model->getBillSourceID(),
                'attributes' => [
                    'code' => $model->getOldID(),
                    'status' => 'COMPLETED',
                ],
            ],
        );

        $curlOptions[CURLOPT_URL] = 'https://kaspi.kz/shop/api/v2/orders';
        $curlOptions[CURLOPT_POSTFIELDS] = Json::json_encode($params);

        curl_setopt_array($curlInit, $curlOptions);
        $result = curl_exec($curlInit);

        $result = json_decode($result, true);

        return  Arr::path($result, 'data.attributes.status') == 'COMPLETED';
    }

    /**
     * Отправка кода клиенту для подтверждения заказа заказа
     * @param $shopBillID
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @throws HTTP_Exception_500
     * @return bool
     */
    public static function sendSMSBill($shopBillID, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        $model = new Model_AutoPart_Shop_Bill();
        $model->setDBDriver($driver);
        if (! Helpers_DB::getDBObject($model, $shopBillID, $sitePageData)) {
            throw new HTTP_Exception_404('Bill "' . $shopBillID . '" not is found!');
        }

        return self::_completedBill($model);
    }

    /**
     * Подтверждение заказа
     * @param $shopBillID
     * @param $secretCode
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @throws HTTP_Exception_404
     * @return bool
     */
    public static function completedBill($shopBillID, $secretCode, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        if (empty($secretCode)) {
            throw new HTTP_Exception_404('Secret code not is empty');
        }

        $model = new Model_AutoPart_Shop_Bill();
        $model->setDBDriver($driver);
        if (! Helpers_DB::getDBObject($model, $shopBillID, $sitePageData)) {
            throw new HTTP_Exception_404('Bill "' . $shopBillID . '" not is found!');
        }

        return self::_completedBill($model, $secretCode);
    }
}