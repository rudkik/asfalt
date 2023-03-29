<?php defined('SYSPATH') or die('No direct script access.');

class Api_Shop_Cart  {
    /**
     * Хеш всей корзины
     * @param SitePageData $sitePageData
     * @return string
     */
    public static function getHash(SitePageData $sitePageData){
        $session = Session::instance();
        $session_data =  &$session->as_array();
        return md5(json_encode(Arr::path($session_data, $sitePageData->actionURLName)));
    }

    /**
     * Хеш корзины магазина
     * @param $shopID
     * @param SitePageData $sitePageData
     * @return string
     */
    public static function getShopHash($shopID, SitePageData $sitePageData){
        $session = Session::instance();
        $session_data =  &$session->as_array();
        return md5(json_encode(Arr::path($session_data, $sitePageData->actionURLName.'.'.$shopID)));
    }

    /**
     * Добавляем товар в корзину
     * @param $shopID
     * @param $shopGoodID
     * @param $shopChildID
     * @param $count
     * @param SitePageData $sitePageData
     */
    public static function addGood($shopID, $shopGoodID, $shopChildID, $count, SitePageData $sitePageData){
        $session = Session::instance();
        $session_data = &$session->as_array();

        $shopID = intval($shopID);
        $shopGoodID = intval($shopGoodID);
        $shopChildID = intval($shopChildID);
        $count = intval($count);
        if (($shopGoodID > 0) && ($count > 0)){
            $tmp = intval(Arr::path($session_data, $sitePageData->actionURLName
                .'.'.$shopID.'.bill.'.$shopGoodID .'.'.$shopChildID.'.count', 0));
            $session_data[$sitePageData->actionURLName][$shopID]['bill'][$shopGoodID][$shopChildID]['count'] = $tmp + $count;

            $tmp = intval(Arr::path($_SESSION, $sitePageData->actionURLName
                .'.'.$shopID.'.bill.'.$shopGoodID .'.'.$shopChildID.'.count', 0));
            $_SESSION[$sitePageData->actionURLName][$shopID]['bill'][$shopGoodID][$shopChildID]['count'] = $tmp + $count;

        }
    }

    /**
     * Добавляем комментарий к товару
     * @param $shopID
     * @param $shopGoodID
     * @param $shopChildID
     * @param $comment
     * @param SitePageData $sitePageData
     */
    public static function setGoodComment($shopID, $shopGoodID, $shopChildID, $comment, SitePageData $sitePageData){
        $session = Session::instance();
        $session_data = &$session->as_array();

        $shopID = intval($shopID);
        $shopGoodID = intval($shopGoodID);
        $shopChildID = intval($shopChildID);
        if (($shopGoodID > 0)){
            $session_data[$sitePageData->actionURLName][$shopID]['bill'][$shopGoodID][$shopChildID]['comment'] = $comment;

            $_SESSION[$sitePageData->actionURLName][$shopID]['bill'][$shopGoodID][$shopChildID]['comment'] = $comment;
        }
    }

    /**
     * Добавляем количество товару
     * @param $shopID
     * @param $shopGoodID
     * @param $shopChildID
     * @param $count
     * @param SitePageData $sitePageData
     */
    public static function setGoodCount($shopID, $shopGoodID, $shopChildID, $count, SitePageData $sitePageData){
        $session = Session::instance();
        $session_data = &$session->as_array();

        $shopID = intval($shopID);
        $shopGoodID = intval($shopGoodID);
        $shopChildID = intval($shopChildID);
        $count = intval($count);
        if (($shopGoodID > 0) && ($count > -1)){
            $session_data[$sitePageData->actionURLName][$shopID]['bill'][$shopGoodID][$shopChildID]['count'] = $count;

            $_SESSION[$sitePageData->actionURLName][$shopID]['bill'][$shopGoodID][$shopChildID]['count'] = $count;
        }
    }

    /**
     * Добавляем количество товару
     * @param $shopID
     * @param $shopGoodID
     * @param $shopChildID
     * @param $count
     * @param SitePageData $sitePageData
     */
    public static function setGoodOptions($shopID, $shopGoodID, $shopChildID, array $options, SitePageData $sitePageData){
        $session = Session::instance();
        $session_data = &$session->as_array();

        $shopID = intval($shopID);
        $shopGoodID = intval($shopGoodID);
        $shopChildID = intval($shopChildID);
        if ($shopGoodID > 0){
            $session_data[$sitePageData->actionURLName][$shopID]['bill'][$shopGoodID][$shopChildID]['options'] = $options;

            $_SESSION[$sitePageData->actionURLName][$shopID]['bill'][$shopGoodID][$shopChildID]['options'] = $options;
        }
    }

    /**
     * Меняем количество у списка товаров
     * @param $shopID
     * @param array $shopGoodIDs
     * @param SitePageData $sitePageData
     */
    public static function updateGoodsCount($shopID, array $shopGoodIDs, SitePageData $sitePageData){
        foreach ($shopGoodIDs as $shopGoodID => $value) {
            $shopGoodID = intval($shopGoodID);
            if ($shopGoodID < 1) {
                continue;
            }

            if (is_array($value)) {
                foreach ($value as $shopChildID => $count) {
                    $shopChildID = intval($shopChildID);
                    if($shopChildID > 0) {
                        self::setGoodCount($shopID, $shopGoodID, $shopChildID, intval($count), $sitePageData);
                    }
                }
            } else {
                self::setGoodCount($shopID, $shopGoodID, 0, intval($value), $sitePageData);
            }
        }
    }

    /**
     * Задаем данные товара
     * @param $shopID
     * @param SitePageData $sitePageData
     * @return bool
     */
    public static function setGoodData($shopID, SitePageData $sitePageData){
        $shopGoodID = Request_RequestParams::getParamInt('id');
        $shopChildID = Request_RequestParams::getParamInt('shop_good_child_id');
        if($shopChildID === NULL){
            $shopChildID = Request_RequestParams::getParamInt('child_id');
        }

        $shopGoodID = intval($shopGoodID);
        if($shopGoodID < 1){
            return FALSE;
        }

        $count = Request_RequestParams::getParamInt('count');
        if($count !== NULL){
           self::setGoodCount($shopID, $shopGoodID, $shopChildID, $count, $sitePageData);
        }

        $comment = Request_RequestParams::getParamStr('comment');
        if($comment !== NULL){
            self::setGoodComment($shopID, $shopGoodID, $shopChildID, $comment, $sitePageData);
        }

        $options = Request_RequestParams::getParamArray('options');
        if($options !== NULL){
            self::setGoodOptions($shopID, $shopGoodID, $shopChildID, $options, $sitePageData);
        }

        $options = Helpers_Image::getChildrenFILES('options');
        if($options !== NULL){
            $file = new Model_File($sitePageData, TRUE);
            foreach ($options as $key => $value) {
                $options[$key] = $file->saveDownloadFilePath($value, 'bill_item_'.str_replace('.', '_', microtime(TRUE)), Model_Shop_Bill_Item::TABLE_ID, $sitePageData);
            }
            self::setGoodOptions($shopID, $shopGoodID, $shopChildID, $options, $sitePageData);
        }

        return TRUE;
    }

    /**
     * Задаем данные списку товаров
     * @param $shopID
     * @param SitePageData $sitePageData
     * @return bool
     */
    public static function setGoodsData($shopID, SitePageData $sitePageData)
    {
        $shopGoods = Request_RequestParams::getParamArray('goods');
        if(! is_array($shopGoods)){
            $shopGoods = Request_RequestParams::getParamArray('shop_goods');
        }
        if(!is_array($shopGoods)) {
            return FALSE;
        }

        foreach($shopGoods as $shopGoodID => $shopGood){
            $shopGoodID = intval($shopGoodID);
            if($shopGoodID < 1){
                continue;
            }

            $shopChildID =  Arr::path($shopGood, 'shop_good_child_id', Arr::path($shopGood, 'child_id', 0));

            $count = Arr::path($shopGood, 'count', NULL);
            if($count !== NULL){
                self::setGoodCount($shopID, $shopGoodID, $shopChildID, $count, $sitePageData);
            }

            $comment = Arr::path($shopGood, 'comment', NULL);
            if($comment !== NULL){
                self::setGoodComment($shopID, $shopGoodID, $shopChildID, $comment, $sitePageData);
            }

            $options = Arr::path($shopGood, 'options', NULL);
            if(is_array($options)){
                self::setGoodOptions($shopID, $shopGoodID, $shopChildID, $options, $sitePageData);
            }
        }

    }

    /**
     * Задаем тип доставки
     * @param $shopDeliveryTypeID
     * @param SitePageData $sitePageData
     */
    public static function setShopDeliveryTypeID($shopDeliveryTypeID, SitePageData $sitePageData){
        $session = Session::instance();
        $session_data = &$session->as_array();

        $session_data[$sitePageData->actionURLName]['bill_data']['shop_delivery_type_id'] = intval($shopDeliveryTypeID);

        $_SESSION[$sitePageData->actionURLName]['bill_data']['shop_delivery_type_id'] = intval($shopDeliveryTypeID);
    }

    /**
     * Получаем тип доставки
     * @param SitePageData $sitePageData
     * @return mixed
     */
    public static function getShopDeliveryTypeID(SitePageData $sitePageData){
        $session = Session::instance();
        $session_data = &$session->as_array();

        return Arr::path($session_data, $sitePageData->actionURLName.'.bill_data.shop_delivery_type_id',
            Arr::path($_SESSION, $sitePageData->actionURLName.'.bill_data.shop_delivery_type_id', 0));
    }

    /**
     * Задаем тип оплаты
     * @param $shopPaidTypeID
     * @param SitePageData $sitePageData
     */
    public static function setShopPaidTypeID($shopPaidTypeID, SitePageData $sitePageData){
        $session = Session::instance();
        $session_data = &$session->as_array();

        $session_data[$sitePageData->actionURLName]['bill_data']['shop_paid_type_id'] = intval($shopPaidTypeID);

        $_SESSION[$sitePageData->actionURLName]['bill_data']['shop_paid_type_id'] = intval($shopPaidTypeID);
    }

    /**
     * Получаем тип оплаты
     * @param SitePageData $sitePageData
     * @return mixed
     */
    public static function getShopPaidTypeID(SitePageData $sitePageData){
        $session = Session::instance();
        $session_data = &$session->as_array();

        return Arr::path($session_data, $sitePageData->actionURLName.'.bill_data.shop_paid_type_id',
            Arr::path($_SESSION, $sitePageData->actionURLName.'.bill_data.shop_paid_type_id', 0));
    }

    /**
     * Получаем параметры заказа
     * @param SitePageData $sitePageData
     * @return mixed
     */
    public static function getBillOptions(SitePageData $sitePageData){
        $session = Session::instance();
        $session_data = &$session->as_array();

        return Arr::path($session_data, $sitePageData->actionURLName.'.bill_data.'.'options',
            Arr::path($_SESSION, $sitePageData->actionURLName.'.bill_data.'.'options', array()));
    }

    /**
     * Задаем параметры заказа
     * @param array $options
     * @param SitePageData $sitePageData
     */
    public static function setBillOptions(array $options, SitePageData $sitePageData){
        $session = Session::instance();
        $session_data = &$session->as_array();

        $session_data[$sitePageData->actionURLName]['bill_data']['options'] = array_merge(Arr::path($session_data, $sitePageData->actionURLName.'.bill_options', array()), $options);

        $_SESSION[$sitePageData->actionURLName]['bill_data']['options'] = array_merge(Arr::path($_SESSION, $sitePageData->actionURLName.'.bill_options', array()), $options);
    }

    /**
     * Получаем параметры заказа
     * @param SitePageData $sitePageData
     * @return mixed
     */
    public static function getBillShopRootID(SitePageData $sitePageData){
        $session = Session::instance();
        $session_data = &$session->as_array();

        return Arr::path($session_data, $sitePageData->actionURLName.'.bill_data.'.'shop_root_id',
            Arr::path($_SESSION, $sitePageData->actionURLName.'.bill_data.'.'shop_root_id', 0));
    }

    /**
     * Задаем параметры заказа
     * @param $shopRootID
     * @param SitePageData $sitePageData
     */
    public static function setBillShopRootID($shopRootID, SitePageData $sitePageData){
        $session = Session::instance();
        $session_data = &$session->as_array();

        $session_data[$sitePageData->actionURLName]['bill_data']['shop_root_id'] = intval($shopRootID);

        $_SESSION[$sitePageData->actionURLName]['bill_data']['shop_root_id'] = intval($shopRootID);
    }

    /**
     * Получаем комментарий заказа
     * @param SitePageData $sitePageData
     * @return mixed
     */
    public static function getBillComment(SitePageData $sitePageData){
        $session = Session::instance();
        $session_data = &$session->as_array();

        return Arr::path($session_data, $sitePageData->actionURLName.'.bill_data.'.'comment',
            Arr::path($_SESSION, $sitePageData->actionURLName.'.bill_data.'.'comment', ''));
    }

    /**
     * Задаем комментарий заказа
     * @param $comment
     * @param SitePageData $sitePageData
     */
    public static function setBillComment($comment, SitePageData $sitePageData){
        $session = Session::instance();
        $session_data = &$session->as_array();

        $session_data[$sitePageData->actionURLName]['bill_data']['comment'] = $comment;

        $_SESSION[$sitePageData->actionURLName]['bill_data']['comment'] = $comment;
    }

    /**
     * Получаем город заказа
     * @param SitePageData $sitePageData
     * @return mixed
     */
    public static function getBillCityID(SitePageData $sitePageData){
        $session = Session::instance();
        $session_data = &$session->as_array();

        return Arr::path($session_data, $sitePageData->actionURLName.'.bill_data.'.'city_id',
            Arr::path($_SESSION, $sitePageData->actionURLName.'.bill_data.'.'city_id', ''));
    }

    /**
     * Задаем город заказа
     * @param $cityID
     * @param SitePageData $sitePageData
     */
    public static function setBillCityID($cityID, SitePageData $sitePageData){
        $session = Session::instance();
        $session_data = &$session->as_array();

        $session_data[$sitePageData->actionURLName]['bill_data']['city_id'] = $cityID;

        $_SESSION[$sitePageData->actionURLName]['bill_data']['city_id'] = $cityID;
    }

    /**
     * Получаем город заказа
     * @param SitePageData $sitePageData
     * @return mixed
     */
    public static function getBillTypeID(SitePageData $sitePageData){
        $session = Session::instance();
        $session_data = &$session->as_array();

        return Arr::path($session_data, $sitePageData->actionURLName.'.bill_data.'.'type',
            Arr::path($_SESSION, $sitePageData->actionURLName.'.bill_data.'.'type', ''));
    }

    /**
     * Задаем город заказа
     * @param $type
     * @param SitePageData $sitePageData
     */
    public static function setBillTypeID($type, SitePageData $sitePageData){
        $session = Session::instance();
        $session_data = &$session->as_array();

        $session_data[$sitePageData->actionURLName]['bill_data']['type'] = floatval($type);

        $_SESSION[$sitePageData->actionURLName]['bill_data']['type'] = floatval($type);
    }

    /**
     * Получаем страну заказа
     * @param SitePageData $sitePageData
     * @return mixed
     */
    public static function getBillCountryID(SitePageData $sitePageData){
        $session = Session::instance();
        $session_data = &$session->as_array();

        return Arr::path($session_data, $sitePageData->actionURLName.'.bill_data.'.'country_id',
            Arr::path($_SESSION, $sitePageData->actionURLName.'.bill_data.'.'country_id', 0));
    }

    /**
     * Задаем страну заказа
     * @param $countryID
     * @param SitePageData $sitePageData
     */
    public static function setBillCountryID($countryID, SitePageData $sitePageData){
        $session = Session::instance();
        $session_data = &$session->as_array();

        $session_data[$sitePageData->actionURLName]['bill_data']['country_id'] = $countryID;

        $_SESSION[$sitePageData->actionURLName]['bill_data']['country_id'] = $countryID;
    }

    /**
     * Удаление товара
     * @param $shopID
     * @param $shopGoodID
     * @param $shopChildID
     * @param SitePageData $sitePageData
     */
    public static function delGood($shopID, $shopGoodID, $shopChildID, SitePageData $sitePageData){
        $session = Session::instance();
        $session_data = &$session->as_array();

        $shopID = intval($shopID);
        $shopGoodID = intval($shopGoodID);
        $shopChildID = intval($shopChildID);
        if (($shopGoodID > 0)){
            if (Arr::path($session_data, $sitePageData->actionURLName
                    .'.'.$shopID.'.bill.'.$shopGoodID .'.'.$shopChildID.'.count', -1) > -1){
                unset($session_data[$sitePageData->actionURLName][$shopID]['bill'][$shopGoodID][$shopChildID]);

                if(count($session_data[$sitePageData->actionURLName][$shopID]['bill'][$shopGoodID]) == 0){
                    unset($session_data[$sitePageData->actionURLName][$shopID]['bill'][$shopGoodID]);
                }
            }

            if (Arr::path($_SESSION, $sitePageData->actionURLName
                    .'.'.$shopID.'.bill.'.$shopGoodID .'.'.$shopChildID.'.count', -1) > -1){
                unset($_SESSION[$sitePageData->actionURLName][$shopID]['bill'][$shopGoodID][$shopChildID]);

                if(count($_SESSION[$sitePageData->actionURLName][$shopID]['bill'][$shopGoodID]) == 0){
                    unset($_SESSION[$sitePageData->actionURLName][$shopID]['bill'][$shopGoodID]);
                }
            }
        }
    }

    /**
     * Получаем количествао товара
     * @param $shopID
     * @param SitePageData $sitePageData
     * @return int|mixed
     */
    public static function getGoodsCount($shopID, SitePageData $sitePageData){
        $session = Session::instance();
        $session_data = &$session->as_array();

        $shopID = intval($shopID);
        $shopGoods = Arr::path($session_data, $sitePageData->actionURLName.'.'.$shopID.'.bill',
            Arr::path($_SESSION, $sitePageData->actionURLName.'.'.$shopID.'.bill', array()));

        $result = 0;
        foreach($shopGoods as $shopGood){
            foreach($shopGood as $shopChild){
                $result = $result + intval(Arr::path($shopChild, 'count', 0));
            }
        }
        return $result;
    }

    /**
     * Очищаем заказ
     * @param $shopID
     * @param SitePageData $sitePageData
     */
    public static function clearShop($shopID, SitePageData $sitePageData){
        $session = Session::instance();
        $session_data = &$session->as_array();

        $shopID = intval($shopID);
        if (is_array(Arr::path($session_data, $sitePageData->actionURLName.'.'.$shopID.'.bill', -1))){
            unset($session_data[$sitePageData->actionURLName][$shopID]['bill']);
        }

        if (is_array(Arr::path($_SESSION, $sitePageData->actionURLName.'.'.$shopID.'.bill', -1))){
            unset($_SESSION[$sitePageData->actionURLName][$shopID]['bill']);
        }
    }

    /**
     * Сохранение корзины в заказ
     * @param $shopID
     * @param $shopBillStatusID
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @param int $shopBillRootID
     * @return int
     * @throws HTTP_Exception_400
     * @throws HTTP_Exception_500
     */
    public static function saveInBill($shopID, $shopBillStatusID, SitePageData $sitePageData,
                                      Model_Driver_DBBasicDriver $driver, $shopBillRootID = 0){
        // делаем просчет по скидкам и акциям
        $shopGoods = self::countUpShopGoods($shopID, $sitePageData, $driver);

        if (count($shopGoods->childs) == 0) {
            throw new HTTP_Exception_500('Basket empty!');
        }

        $modelBill = new Model_Shop_Bill();
        $modelBill->setDBDriver($driver);
        $modelBill->shopID = $shopID;
        $modelBill->setBillStatusID(Model_BillStatus::BILL_STATUS_NEW);
        $modelBill->setShopBillStatusID($shopBillStatusID);
        $modelBill->setCurrencyID($sitePageData->currencyID);
        $modelBill->setShopBillRootID($shopBillRootID);
        $modelBill->setClientComment(self::getBillComment($sitePageData));
        $modelBill->setCityID(self::getBillCityID($sitePageData));
        $modelBill->setCountryID(self::getBillCountryID($sitePageData));
        $modelBill->setShopRootID(self::getBillShopRootID($sitePageData));
        $modelBill->setShopTableCatalogID(self::getBillTypeID($sitePageData));
        $modelBill->setShopTableCatalogID(Request_RequestParams::getParamInt('type'));

        $options = self::getBillOptions($sitePageData);
        $modelBill->setOptionsArray($options);
        $modelBill->setName(str_replace('  ', ' ',trim(
            Arr::path($options, 'first_name', '').' '.Arr::path($options, 'first_name', '').' '.Arr::path($options, 'name', ''))));

        $modelBill->setAddress(Arr::path($options, 'address', ''));

        // определяем тип доставки
        $model = new Model_Shop_DeliveryType();
        $model->setDBDriver($driver);
        $shopDeliveryTypeID = self::getShopDeliveryTypeID($sitePageData);
        if (Helpers_DB::getDBObject($model, $shopDeliveryTypeID, $sitePageData, $sitePageData->shopMainID)) {
            $modelBill->setShopDeliveryTypeID($model->id);
            if($shopBillRootID < 1) {
                $modelBill->setDeliveryAmount($model->getPrice());
            }
        }

        // определяем тип оплаты
        $model = new Model_Shop_PaidType();
        $model->setDBDriver($driver);
        $shopPaidTypeID = self::getShopPaidTypeID($sitePageData);
        if (Helpers_DB::getDBObject($model, $shopPaidTypeID, $sitePageData, $sitePageData->shopMainID)) {
            $modelBill->setShopPaidTypeID($model->id);
        }

        $result = array();
        if (!$modelBill->validationFields($result)) {
            throw new HTTP_Exception_500('Save bill error');
        }
        $modelBill->setAmount(0);
        Helpers_DB::saveDBObject($modelBill, $sitePageData, $shopID);

        $goodsAmount = 0;
        foreach ($shopGoods->childs as $shopGood) {
            $modelBillItem = new Model_Shop_Bill_Item();
            $modelBillItem->setDBDriver($driver);
            $modelBillItem->shopID = $shopID;
            $modelBillItem->setShopBillID($modelBill->id);
            $modelBillItem->setShopTableCatalogID($modelBill->getShopTableCatalogID());
            $modelBillItem->setShopRootID($modelBill->getShopRootID());

            $modelBillItem->setShopGoodID($shopGood->id);
            $modelBillItem->setClientComment(Arr::path($shopGood->additionDatas, 'comment', ''));
            $modelBillItem->setOptionsArray(Arr::path($shopGood->additionDatas, 'options', array()));
            $modelBillItem->setShopTableChildID(intval($shopGood->additionDatas['shop_good_child_id']));
            $modelBillItem->setCountElement($shopGood->additionDatas['count']);

            if (Arr::path($shopGood->additionDatas, 'free', '') == 1) {
                $modelBillItem->setPrice(0);
            } else {
                $modelBillItem->setPrice($shopGood->additionDatas['original_price']);
            }
            $modelBillItem->setIsAddAction(floatval(Arr::path($shopGood->additionDatas, 'is_add_action', 0)));

            if (Arr::path($shopGood->additionDatas, 'calc_is_discount', 0) == 1) {
                $modelBillItem->setDiscount($shopGood->additionDatas['calc_discount']);
                $modelBillItem->setIsPercent($shopGood->additionDatas['calc_is_percent']);
                $modelBillItem->setShopDiscountID($shopGood->additionDatas['calc_discount_id']);
                $modelBillItem->setClientComment(trim($modelBillItem->getClientComment()."\r\n".$shopGood->additionDatas['calc_bill_comment']));
            }

            if (Arr::path($shopGood->additionDatas, 'calc_is_person_discount', 0) == 1) {
                $modelBillItem->setDiscount($shopGood->additionDatas['calc_person_discount']);
                $modelBillItem->setIsPercent($shopGood->additionDatas['calc_person_is_percent']);
                $modelBillItem->setShopPersoneDiscountID($shopGood->additionDatas['calc_person_id']);
            }

            if (Arr::path($shopGood->additionDatas, 'calc_is_coupon', 0) == 1) {
                $modelBillItem->setDiscount($shopGood->additionDatas['calc_coupon_discount']);
                $modelBillItem->setIsPercent($shopGood->additionDatas['calc_coupon_is_percent']);
                $modelBillItem->setShopCouponID($shopGood->additionDatas['calc_coupon_id']);
            }

            if ($sitePageData->currency->getisRound()) {
                $modelBillItem->setAmount(round($modelBillItem->getAmount()));
            }

            Helpers_DB::saveDBObject($modelBillItem, $sitePageData, $shopID);
            $goodsAmount = $goodsAmount + $modelBillItem->getAmount();
        }

        // определяем скидку при купоне
        $shopCouponID = self::getShopCouponID($sitePageData);
        if($shopCouponID > 0){
            $model = new Model_Shop_Coupon();
            $model->setDBDriver($driver);
            if (Helpers_DB::getDBObject($model, $shopPaidTypeID, $sitePageData, $sitePageData->shopMainID)) {
                $modelBill->setShopCouponID($model->id);
                $modelBill->setDiscount($model->getDiscount());
                $modelBill->setIsPercent($model->getIsPercent());
            }
        }

        $modelBill->setGoodsAmount($goodsAmount);

        Helpers_DB::saveDBObject($modelBill, $sitePageData, $shopID);

        // корректируем баланс филиала
        if(($modelBill->getShopRootID() > 0)) {
            $modelShop = new Model_Shop();
            $modelShop->setDBDriver($driver);

            // редактируем баланс
            if (Helpers_DB::getDBObject($modelShop, $modelBill->getShopRootID(), $sitePageData)) {
                $modelShop->setBalance($modelShop->getBalance() - $modelBill->getAmount());
                Helpers_DB::saveDBObject($modelShop, $sitePageData);
            }
        }

        // удаление заказа
        self::clearShop($shopID, $sitePageData);

        // узнаем e-mail пользователя
        $shopUserID = $sitePageData->userID;
        if ($shopUserID < 1) {
            $email = Arr::path($options, 'email', '');
            if (!empty($email)) {
                // пытаемся связать заказ с пользователем по емайлу
                $shopUserID = Request_User::getShopUserIDByEMail($email, $driver);

                // если пользователя нет, то создаем его
                if ($shopUserID < 1) {
                    $shopUserID = Helpers_User::createUser($email, $sitePageData, $driver);
                }
            }
        } else {
            $email = $sitePageData->user->getEmail();
        }

        // отправляем сообщение о создании заказа
        Api_EMail::sendCreateShopBill($email, $shopID, $modelBill->id, $sitePageData, $driver);

        return array(
            'id' => $modelBill->id,
            'values' => $modelBill->getValues(),
        );
    }

    /**
     * Сохранение заказов всех магазинов
     * @param $shopBillCatalogID
     * @param $shopBillStatusID
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @return bool
     */
    public static function saveInBills($shopBillCatalogID, $shopBillStatusID, SitePageData $sitePageData,
                                      Model_Driver_DBBasicDriver $driver){
        $session = Session::instance();
        $session_data = &$session->as_array();

        $shopBillRootID = 0;
        $shops = Arr::path($session_data, $sitePageData->actionURLName,
            Arr::path($_SESSION, $sitePageData->actionURLName, array()));
        foreach($shops as $shopID => $bill){
            $bill = Arr::path($bill, 'bill', NULL);
            if(empty($bill)){
                continue;
            }
            $shopBillRootID = self::saveInBill($shopID, $shopBillCatalogID, $shopBillStatusID, $sitePageData, $driver, $shopBillRootID);

        }

        $bill = Arr::path($session_data, $sitePageData->actionURLName .'.'.$shopID.'.bill',
            Arr::path($_SESSION, $sitePageData->actionURLName .'.'.$shopID.'.bill', NULL));
        if(empty($bill)){
            return FALSE;
        }
        return TRUE;
    }

    /**
     * Загрузка заказа в куки
     * @param $shopID
     * @param $shopBillID
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     */
    public static function repairBill($shopID, $shopBillID, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver){
        $shopBillItems = Request_Request::find(
            'DB_Shop_Bill_Item', $shopID, $sitePageData, $driver,
            Request_RequestParams::setParams(
                array(
                    'shop_bill_id' => $shopBillID
                )
            ), 0, true
        );

        foreach ($shopBillItems->childs as $shopBillItem) {
            self::addGood($shopID, $shopBillItem->values['shop_good_id'], $shopBillItem->values['shop_table_child_id'],
                $shopBillItem->values['count'], $sitePageData);
        }
    }


    /**
     * Запоминаем данные заказа
     * @param SitePageData $sitePageData
     */
    public static function setBillData(SitePageData $sitePageData){
        $tmp = Request_RequestParams::getParamInt('delivery_type_id');
        if(($tmp === NULL)) {
            $tmp = Request_RequestParams::getParamInt('shop_delivery_type_id');
        }
        if(($tmp !== NULL)) {
            self::setShopDeliveryTypeID($tmp, $sitePageData);
        }

        $tmp = Request_RequestParams::getParamInt('pay_type_id');
        if(($tmp === NULL)) {
            $tmp = Request_RequestParams::getParamInt('shop_paid_type_id');
        }
        if(($tmp !== NULL)) {
            self::setShopPaidTypeID($tmp, $sitePageData);
        }

        $tmp = Request_RequestParams::getParamInt('type');
        if(($tmp !== NULL)) {
            self::setBillTypeID($tmp, $sitePageData);
        }

        $tmp = Request_RequestParams::getParamStr('comment');
        if(($tmp !== NULL)) {
            self::setBillComment($tmp, $sitePageData);
        }

        // данные получателя
        $tmp = Request_RequestParams::getParamArray('options');
        if(($tmp !== NULL)) {
            self::setBillOptions($tmp, $sitePageData);
        }

        $tmp = Request_RequestParams::getParamInt('city_id');
        if(($tmp !== NULL)) {
            self::setBillCityID($tmp, $sitePageData);
        }

        $tmp = Request_RequestParams::getParamInt('country_id');
        if(($tmp !== NULL)) {
            self::setBillCountryID($tmp, $sitePageData);
            $data['country_id'] = $tmp;
        }
    }

    /**
     * Делаем просчет скидок и акций по корзине
     * @param $shopID
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @return bool|MyArray
     */
    public static function countUpShopGoods($shopID, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        $session_data = $_SESSION;

        $bill = Arr::path(
            $session_data,
            $sitePageData->actionURLName . '.' . $shopID . '.bill',
            Arr::path($_SESSION, $sitePageData->actionURLName . '.' . $shopID . '.bill', NULL)
        );
        if (empty($bill)) {
            return new MyArray();
        }

        // получаем список товаров
        $shopGoods = new MyArray();
        foreach ($bill as $shopGoodID => $shopChild) {
            foreach ($shopChild as $shopChildID => $values) {
                $shopGood = $shopGoods->addChild($shopGoodID);
                $shopGood->additionDatas = $values;
                $shopGood->additionDatas['shop_good_child_id'] = $shopChildID;
            }

        }

        // делаем просчет по скидкам и акциям
        return Helpers_Cart::countUpShopGoods($shopID, $shopGoods, $sitePageData, $driver);
    }


    /**
     * Делаем просчет скидок и акций по всем магазинам
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @return bool|MyArray
     */
    public static function countUpShopsGoods(SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        $session = Session::instance();
        $session_data = &$session->as_array();

        $result = array();
        $shops = Arr::path($session_data, $sitePageData->actionURLName,
            Arr::path($_SESSION, $sitePageData->actionURLName, array()));
        foreach($shops as $shopID => $bill){
            $bill = Arr::path($bill, 'bill', NULL);
            if(empty($bill)){
                continue;
            }
            $result[$shopID] = self::countUpShopGoods($shopID, $sitePageData, $driver);
        }
        return $result;
    }


    /**
     * Сохранение корзины в заказ
     * @param $shopID
     * @param $shopReturnCatalogID
     * @param $shopReturnStatusID
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @param int $shopReturnRootID
     * @return int
     * @throws HTTP_Exception_400
     * @throws HTTP_Exception_500
     */
    public static function saveInReturn($shopID, $shopReturnStatusID, SitePageData $sitePageData,
                                        Model_Driver_DBBasicDriver $driver, $shopReturnRootID = 0){
        // делаем просчет по скидкам и акциям
        $shopGoods = self::countUpShopGoods($shopID, $sitePageData, $driver);

        if (count($shopGoods->childs) == 0) {
            throw new HTTP_Exception_500('Return empty!');
        }

        $modelReturn = new Model_Shop_Return();
        $modelReturn->setDBDriver($driver);
        $modelReturn->shopID = $shopID;
        $modelReturn->setCurrencyID($sitePageData->currencyID);
        $modelReturn->setShopReturnRootID($shopReturnRootID);
        $modelReturn->setClientComment(self::getBillComment($sitePageData));
        $modelReturn->setCityID(self::getBillCityID($sitePageData));
        $modelReturn->setCountryID(self::getBillCountryID($sitePageData));
        $modelReturn->setShopRootID(self::getBillShopRootID($sitePageData));
        $modelReturn->setShopTableCatalogID(self::getBillTypeID($sitePageData));

        $options = self::getBillOptions($sitePageData);
        $modelReturn->setOptionsArray($options);
        $modelReturn->setName(str_replace('  ', ' ',trim(
            Arr::path($options, 'first_name', '').' '.Arr::path($options, 'first_name', '').' '.Arr::path($options, 'name', ''))));

        $result = array();
        if (!$modelReturn->validationFields($result)) {
            throw new HTTP_Exception_500('Save return error');
        }
        $modelReturn->setAmount(0);
        Helpers_DB::saveDBObject($modelReturn, $sitePageData, $shopID);

        $returnAmount = 0;
        foreach ($shopGoods->childs as $shopGood) {
            $modelReturnItem = new Model_Shop_Return_Item();
            $modelReturnItem->setDBDriver($driver);
            $modelReturnItem->shopID = $shopID;
            $modelReturnItem->setShopReturnID($modelReturn->id);
            $modelReturnItem->setShopTableCatalogID($modelReturn->getShopTableCatalogID());
            $modelReturnItem->setShopRootID($modelReturn->getShopRootID());

            $modelReturnItem->setShopGoodID($shopGood->id);
            $modelReturnItem->setClientComment(Arr::path($shopGood->additionDatas, 'comment', ''));
            $modelReturnItem->setOptionsArray(Arr::path($shopGood->additionDatas, 'options', array()));
            $modelReturnItem->setShopTableChildID(intval($shopGood->additionDatas['shop_good_child_id']));
            $modelReturnItem->setCountElement($shopGood->additionDatas['count']);

            if (Arr::path($shopGood->additionDatas, 'free', '') == 1) {
                $modelReturnItem->setPrice(0);
            } else {
                $modelReturnItem->setPrice($shopGood->values['price']);
            }
            $modelReturnItem->setIsAddAction(floatval(Arr::path($shopGood->additionDatas, 'is_add_action', 0)));

            if (Arr::path($shopGood->additionDatas, 'calc_is_discount', 0) == 1) {
                $modelReturnItem->setDiscount($shopGood->additionDatas['calc_discount']);
                $modelReturnItem->setIsPercent($shopGood->additionDatas['calc_is_percent']);
                $modelReturnItem->setShopDiscountID($shopGood->additionDatas['calc_discount_id']);
                $modelReturnItem->setClientComment(trim($modelReturnItem->getClientComment()."\r\n".$shopGood->additionDatas['calc_return_comment']));
            }

            $modelReturnItem->setAmount(round($modelReturnItem->getPrice() / 100 * (100 - $modelReturnItem->getDiscount()) * $modelReturnItem->getCountElement(), 2));
            if ($sitePageData->currency->getisRound()) {
                $modelReturnItem->setAmount(round($modelReturnItem->getAmount(), 0));
            }

            Helpers_DB::saveDBObject($modelReturnItem, $sitePageData, $shopID);
            $returnAmount = $returnAmount + $modelReturnItem->getAmount();
        }

        $modelReturn->setAmount($returnAmount);
        $modelReturn->setEditUserID($sitePageData->userID);
        Helpers_DB::saveDBObject($modelReturn, $sitePageData, $shopID);

        // корректируем баланс филиала
        if(($modelReturn->getShopRootID() > 0)) {
            $modelShop = new Model_Shop();
            $modelShop->setDBDriver($driver);

            // редактируем баланс
            if (Helpers_DB::getDBObject($modelShop, $modelReturn->getShopRootID(), $sitePageData)) {
                $modelShop->setBalance($modelShop->getBalance() + $modelReturn->getAmount());
                Helpers_DB::saveDBObject($modelShop, $sitePageData);
            }
        }

        // удаление заказа
        self::clearShop($shopID, $sitePageData);

        return array(
            'id' => $modelReturn->id,
            'values' => $modelReturn->getValues(),
        );
    }

    /**
     * Сохранение заказов всех магазинов
     * @param $shopReturnCatalogID
     * @param $shopReturnStatusID
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @return bool
     */
    public static function saveInReturns($shopReturnCatalogID, $shopReturnStatusID, SitePageData $sitePageData,
                                         Model_Driver_DBBasicDriver $driver){
        $session = Session::instance();
        $session_data = &$session->as_array();

        $shopReturnRootID = 0;
        $shops = Arr::path($session_data, $sitePageData->actionURLName,
            Arr::path($_SESSION, $sitePageData->actionURLName, array()));
        foreach($shops as $shopID => $return){
            $return = Arr::path($return, 'return', NULL);
            if(empty($return)){
                continue;
            }
            $shopReturnRootID = self::saveInReturn($shopID, $shopReturnCatalogID, $shopReturnStatusID, $sitePageData, $driver, $shopReturnRootID);

        }

        $return = Arr::path($session_data, $sitePageData->actionURLName .'.'.$shopID.'.bill',
            Arr::path($_SESSION, $sitePageData->actionURLName .'.'.$shopID.'.bill', NULL));
        if(empty($return)){
            return FALSE;
        }
        return TRUE;
    }

    /**
     * Сохранение корзины на склад менеджера
     * @param $shopID
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @return int
     * @throws HTTP_Exception_400
     * @throws HTTP_Exception_500
     */
    public static function saveInOperationStock($shopID, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver){
        // делаем просчет по скидкам и акциям
        $shopGoods = self::countUpShopGoods($shopID, $sitePageData, $driver);

        if (count($shopGoods->childs) == 0) {
            throw new HTTP_Exception_500('Basket empty!');
        }

        $modelOperationStock = new Model_Shop_Operation_Stock();
        $modelOperationStock->setDBDriver($driver);
        $modelOperationStock->shopID = $shopID;
        $modelOperationStock->setShopOperationID($sitePageData->operationID);
        $modelOperationStock->setShopTableCatalogID(self::getBillTypeID($sitePageData));

        $options = self::getBillOptions($sitePageData);
        $modelOperationStock->setOptionsArray($options);
        $modelOperationStock->setName(str_replace('  ', ' ',trim(
            Arr::path($options, 'first_name', '').' '.Arr::path($options, 'first_name', '').' '.Arr::path($options, 'name', ''))));

        $result = array();
        if (!$modelOperationStock->validationFields($result)) {
            throw new HTTP_Exception_500('Save operation stock error');
        }
        $modelOperationStock->setAmount(0);
        Helpers_DB::saveDBObject($modelOperationStock, $sitePageData, $shopID);

        $billAmount = 0;
        foreach ($shopGoods->childs as $shopGood) {
            $modelOperationStockItem = new Model_Shop_Operation_Stock_Item();
            $modelOperationStockItem->setDBDriver($driver);
            $modelOperationStockItem->shopID = $shopID;
            $modelOperationStockItem->setShopOperationStockID($modelOperationStock->id);
            $modelOperationStockItem->setShopTableCatalogID($modelOperationStock->getShopTableCatalogID());
            $modelOperationStockItem->setShopOperationID($sitePageData->operationID);

            $modelOperationStockItem->setShopGoodID($shopGood->id);
            $modelOperationStockItem->setOptionsArray(Arr::path($shopGood->additionDatas, 'options', array()));
            $modelOperationStockItem->setShopTableChildID(intval($shopGood->additionDatas['shop_good_child_id']));
            $modelOperationStockItem->setCountElement($shopGood->additionDatas['count']);

            if (Arr::path($shopGood->additionDatas, 'free', '') == 1) {
                $modelOperationStockItem->setPrice(0);
            } else {
                $modelOperationStockItem->setPrice($shopGood->values['price']);
            }
            $modelOperationStockItem->setAmount($modelOperationStockItem->getPrice() * $modelOperationStockItem->getCountElement());
            if ($sitePageData->currency->getisRound()) {
                $modelOperationStockItem->setAmount(round($modelOperationStockItem->getAmount(), 0));
            }

            Helpers_DB::saveDBObject($modelOperationStockItem, $sitePageData, $shopID);
            $billAmount = $billAmount + $modelOperationStockItem->getAmount();
        }

        $modelOperationStock->setAmount($billAmount);
        $modelOperationStock->setEditUserID($sitePageData->userID);
        Helpers_DB::saveDBObject($modelOperationStock, $sitePageData, $shopID);

        // удаление заказа
        self::clearShop($shopID, $sitePageData);

        return array(
            'id' => $modelOperationStock->id,
            'values' => $modelOperationStock->getValues(),
        );
    }

    /**
     * Задаем скидочный купон
     * @param $shopCouponID
     * @param SitePageData $sitePageData
     */
    public static function setShopCouponID($shopCouponID, SitePageData $sitePageData){
        $session = Session::instance();
        $session_data = &$session->as_array();

        $session_data[$sitePageData->actionURLName]['bill_data']['shop_coupon_id'] = intval($shopCouponID);

        $_SESSION[$sitePageData->actionURLName]['bill_data']['shop_coupon_id'] = intval($shopCouponID);
    }

    /**
     * Получаем скидочный купон
     * @param SitePageData $sitePageData
     * @return mixed
     */
    public static function getShopCouponID(SitePageData $sitePageData){
        $session = Session::instance();
        $session_data = &$session->as_array();

        return Arr::path($session_data, $sitePageData->actionURLName.'.bill_data.shop_coupon_id',
            Arr::path($_SESSION, $sitePageData->actionURLName.'.bill_data.shop_coupon_id', 0));
    }

    /**
     * Задаем персональную скидку
     * @param $shopPersonDiscountID
     * @param SitePageData $sitePageData
     */
    public static function setShopPersonDiscountID($shopPersonDiscountID, SitePageData $sitePageData){
        $session = Session::instance();
        $session_data = &$session->as_array();

        $session_data[$sitePageData->actionURLName]['bill_data']['shop_person_discount_id'] = intval($shopPersonDiscountID);

        $_SESSION[$sitePageData->actionURLName]['bill_data']['shop_person_discount_id'] = intval($shopPersonDiscountID);
    }

    /**
     * Получаем персональную скидку
     * @param SitePageData $sitePageData
     * @return mixed
     */
    public static function getShopPersonDiscountID(SitePageData $sitePageData){
        $session = Session::instance();
        $session_data = &$session->as_array();

        return Arr::path($session_data, $sitePageData->actionURLName.'.bill_data.shop_person_discount_id',
            Arr::path($_SESSION, $sitePageData->actionURLName.'.bill_data.shop_person_discount_id', 0));
    }
}
