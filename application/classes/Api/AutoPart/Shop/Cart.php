<?php defined('SYSPATH') or die('No direct script access.');

class Api_AutoPart_Shop_Product
{
    /**
     * Получаем список товаров магазина в корзине
     * @param $dbObject
     * @param $shopID
     * @param $viewObjects
     * @param $viewObject
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @param array $params
     * @param null $elements
     * @param bool $isLoadOneView
     * @param bool $isLoadView
     * @return array|bool|mixed|MyArray
     */
    public static function getCartShopProducts($dbObject, $shopID, $viewObjects, $viewObject, SitePageData $sitePageData,
                                            Model_Driver_DBBasicDriver $driver, array $params = array(), $elements = NULL,
                                            $isLoadOneView = FALSE, $isLoadView = TRUE){

        // ставим дополнительные загрушки, системные вьюшки (чтобы много раз не пересчитывать корзину)
        $sitePageData->globalDatas['view::shopcart_count'] = '^#@view::shopcart_count@#^';
        $sitePageData->globalDatas['view::shopcart_amount'] = '^#@view::shopcart_amount@#^';
        $sitePageData->globalDatas['view::shopcart_amount_str'] = '^#@view::shopcart_amount_str@#^';
       // $sitePageData->globalDatas['view::shopcart_bonus'] = '^#@view::shopcart_bonus@#^';
       // $sitePageData->globalDatas['view::shopcart_bonus_str'] = '^#@view::shopcart_bonus_str@#^';

        // ищем в мемкеше
        $key =  Api_Shop_Cart::getShopHash($shopID, $sitePageData);
        $data = Helpers_DB::getMemcacheFunctionView($shopID, 'View_Shop_Cart::getCartShopGoods', array(Model_Shop_Good::TABLE_NAME, Model_Shop_Table_Child::TABLE_NAME),
            $viewObjects, $sitePageData, $driver, $key);
        if ($data !== NULL){
            $sitePageData->replaceDatas['view::'.$viewObjects] = $data['shopgoods'];

            $sitePageData->replaceDatas['view::shopcart_amount'] = $data['amount'];
            $sitePageData->replaceDatas['view::shopcart_amount_str'] = Func::getPriceStr($sitePageData->currency, $data['amount']);
           // $sitePageData->replaceDatas['view::shopcart_bonus'] = $data['bonus'];
           // $sitePageData->replaceDatas['view::shopcart_bonus_str'] = Func::getPriceStr($sitePageData->currency, $data['bonus']);
            $sitePageData->replaceDatas['view::shopcart_count'] = $data['count'];

            return $data;
        }

        // получаем количество товаров
        $shopProductIDs = Api_Shop_Cart::countUpShopGoods($shopID, $sitePageData, $driver);
        if (!$isLoadView) {
            return $shopProductIDs;
        }

        // получаем товары
        $model = new Model_AutoPart_Shop_Product();
        $model->setDBDriver($driver);
        $shopGoods = Helpers_View::getViewObjects($shopProductIDs, $model, $viewObjects, $viewObject, $sitePageData,
            $driver, $shopID, TRUE, $elements);

        $sitePageData->replaceDatas['view::'.$viewObjects] = $shopGoods;

        // количество товаров
        $count = Func::getGoodsCount($shopProductIDs);
        $amount = FuncPrice::getGoodsAmount($shopProductIDs, $sitePageData, $driver);
        $bonus = Func::getGoodsBonus($shopProductIDs);

        $sitePageData->replaceDatas['view::shopcart_amount'] = $amount;
        $sitePageData->replaceDatas['view::shopcart_amount_str'] = Func::getPriceStr($sitePageData->currency, $amount);
       // $sitePageData->replaceDatas['view::shopcart_bonus'] = $bonus;
       // $sitePageData->replaceDatas['view::shopcart_bonus_str'] = Func::getPriceStr($sitePageData->currency, $bonus);
        $sitePageData->replaceDatas['view::shopcart_count'] = $count;

        $data = array(
            'shopgoods' => $shopGoods,
            'count' => $count,
            'amount' => $amount,
            'bonus' => $bonus,
        );

        // записываем в мемкеш
        Helpers_DB::setMemcacheFunctionView($data, $shopID, 'View_Shop_Cart::getCartShopProducts', array(Model_AutoPart_Shop_Product::TABLE_NAME, Model_Shop_Table_Child::TABLE_NAME),
            $viewObjects, $sitePageData, $driver, $key);

        return $data;
    }

    /**
     * Делаем просчет по скидкам и акциям
     * @param $shopID
     * @param MyArray $shopGoodIDs
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @return MyArray
     */
    public static function countUpShopGoods($shopID, MyArray $shopGoodIDs, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver){
        // убираем товары, которых нет в базе данных
        $model = new Model_AutoPart_Shop_Product();
        $model->setDBDriver($driver);
        foreach ($shopGoodIDs->childs as $key => $shopGoodID) {
            if (!Helpers_View::getDBDataIfNotFind($shopGoodID, $model, $sitePageData, $shopID, array('shop_table_catalog_id', 'shop_id'))){
                unset($shopGoodIDs->childs[$key]);
            }else{
                $shopGoodID->additionDatas['original_price'] = $shopGoodID->values['price'];
                // выбираем цену и курс валюты на других типов просчета
                FuncPrice::getGoodPriceInModel($shopGoodID, $sitePageData, $driver);
            }
        }

        $shopPersonDiscountID = Api_Shop_Cart::getShopPersonDiscountID($sitePageData);
        if($shopPersonDiscountID > 0){
            /** @var Model_Shop_PersonDiscount $modelPersonDiscount */
            $modelPersonDiscount = Request_Request::findOneModelByID(
                DB_Shop_PersonDiscount::NAME, $shopPersonDiscountID, $sitePageData->shopID, $sitePageData, $driver
            );

            if($modelPersonDiscount != null){
                $rubrics = Request_Shop_Table_Basic_Rubric::findRubricIDsByMain(
                    $sitePageData->shopID, $sitePageData, $driver,
                    Request_RequestParams::setParams(['id' => $modelPersonDiscount->getShopTableRubricIDsArray()])
                );
                $rubrics->treeInList()->runIndex(true);

                foreach ($shopGoodIDs->childs as $child){
                    $shopTableRubricID = $child->values['shop_table_rubric_id'];
                    if(!key_exists($shopTableRubricID, $rubrics->childs)){
                        continue;
                    }

                    $shopGoodID->additionDatas['calc_is_person_discount'] = 1;
                    $shopGoodID->additionDatas['calc_person_discount'] = $modelPersonDiscount->getDiscount();
                    $shopGoodID->additionDatas['calc_person_is_percent'] = $modelPersonDiscount->getIsPercent();
                    $shopGoodID->additionDatas['calc_person_id'] = $shopPersonDiscountID;

                    if($modelPersonDiscount->getIsPercent()){
                        $child->values['price'] = round($child->values['price'] / 100 * (100 - $modelPersonDiscount->getDiscount()));
                    }else{
                        $child->values['price'] = $child->values['price'] - $modelPersonDiscount->getDiscount();
                    }
                }
            }
        }

        /*
         * Делаем просчет по скидкам
         */

        // получаем списка скидок магазина
        $shopDiscountIDs = Request_Request::findAll(
            DB_Shop_Discount::NAME, $shopID, $sitePageData, $driver, TRUE
        );

        // ищем группируем скидки, по условию, что одна скидка дает больше значение
        $discountTypes = array();
        foreach ($shopDiscountIDs->childs as $discount) {
            $discount->values['data'] = json_decode($discount->values['data'], TRUE);
            $type = $discount->values['discount_type_id'];
            if(! key_exists($type, $discountTypes)){
                $discountTypes[$type] = array();
            }
            $discountTypes[$type] = $discount;
        }
        foreach($discountTypes as $type){
            uasort($type, array(selt, '_compareDiscount'));
        }

        // добавляем скидку товарам максимальную
        foreach ($discountTypes as $type) {
            foreach ($type as $discount) {
                self::_applyDiscount($discount, $shopGoodIDs, $sitePageData->currency->getIsRound());
            }
        }

        /*
         * Делаем просчет по акциям
         */

        // получаем список акций магазина
        $shopActionIDs = Request_Request::findAll(
            DB_Shop_Action::NAME, $shopID, $sitePageData, $driver, TRUE
        );

        // группируем акции, по условию, что одна акция дает больше подарок
        $actionTypes = array();
        foreach ($shopActionIDs->childs as $action) {
            $action->values['data'] = json_decode($action->values['data'], TRUE);
            $action->values['gift_ids'] = json_decode($action->values['gift_ids'], TRUE);

            $type = $action->values['action_type_id'];
            if(! key_exists($type, $actionTypes)){
                $actionTypes[$type] = array();
            }
            $actionTypes[$type] = $action;
        }
        foreach($actionTypes as $type){
            uasort($type, array(selt, '_compareAction'));
        }

        foreach ($actionTypes as $type) {
            foreach ($type as $action) {
                if(self::_applyAction($action, $shopGoodIDs, $sitePageData->currency->getIsRound())){
                    break;
                }
            }
        }

        return $shopGoodIDs;
    }


    /**
     * Делаем просчет скидок и акций по корзине
     * @param $shopID
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @return bool|MyArray
     */
    public static function countUpShopProducts($shopID, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
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
        return self::countUpShopGoods($shopID, $shopGoods, $sitePageData, $driver);
    }

    /**
     * Применяем акцию
     * @param MyArray $action
     * @param MyArray $shopGoodIDs
     * @param $isRound
     * @return bool
     */
    private static function _applyAction(MyArray $action, MyArray $shopGoodIDs, $isRound){
        switch ($action->values['action_type_id']) {
            case Model_ActionType::ACTION_TYPE_BILL_AMOUNT:
                $amount = floatval(Arr::path($action->values['data'], 'amount', 0));
                if ($amount > Func::getGoodsAmount($shopGoodIDs, $isRound)){
                    return FALSE;
                }

                $gifts = $action->values['gift_ids'];
                foreach ($gifts as $gift) {
                    $shopGoodIDs->addChild($gift['id'])->additionDatas = array(
                        'count' => $gift['count'],
                        'free' => 1,
                        'is_add_action' => 1
                    );
                }
                return TRUE;
            case Model_ActionType::ACTION_TYPE_CATALOGS:
                $ids = Arr::path($action->values['data'], 'id', array());
                $amount = floatval(Arr::path($action->values['data'], 'amount', 0));
                $count = floatval(Arr::path($action->values['data'], 'count', 0));

                foreach ($shopGoodIDs->childs as $key => $shopGoodID) {
                    foreach ($ids as $id) {
                        if ($shopGoodID->values['shop_table_rubric_id'] == $id) {
                            $count = $count - $shopGoodID->additionDatas['count'];
                            if ($count <= 0) {
                                break;
                            }
                            $amount = $amount - Func::getGoodAmount($shopGoodID, $shopGoodID->additionDatas['count'], $isRound);
                            if ($amount <= 0) {
                                break;
                            }

                            $select[] = $key;
                        }
                    }
                }

                if (($count > 0) || ($amount > 0)) {
                    return FALSE;
                }

                // применяем акцию
                $gifts = $action->values['gift_ids'];
                foreach ($gifts as $gift) {
                    $shopGoodIDs->addChild($gift['id'])->additionDatas = array(
                        'count' => $gift['count'],
                        'free' => 1,
                        'is_add_action' => 1
                    );
                }
                return TRUE;
            case Model_ActionType::ACTION_TYPE_GOODS:
                $ids = Arr::path($action->values['data'], 'id', array());
                $amount = floatval(Arr::path($action->values['data'], 'amount', 0));
                $count = floatval(Arr::path($action->values['data'], 'count', 0));

                foreach ($shopGoodIDs->childs as $key => $shopGoodID) {
                    foreach ($ids as $id) {
                        if ($shopGoodID->id == $id) {
                            $count = $count - $shopGoodID->additionDatas['count'];
                            if ($count <= 0) {
                                break;
                            }
                            $amount = $amount - Func::getGoodAmount($shopGoodID, $shopGoodID->additionDatas['count'], $isRound);
                            if ($amount <= 0) {
                                break;
                            }

                            $select[] = $key;
                        }
                    }
                }

                if (($count > 0) || ($amount > 0)) {
                    return FALSE;
                }

                // применяем акцию
                $gifts = $action->values['gift_ids'];
                foreach ($gifts as $gift) {
                    $shopGoodIDs->addChild($gift['id'])->additionDatas = array(
                        'count' => $gift['count'],
                        'free' => 1,
                        'is_add_action' => 1
                    );
                }

                return TRUE;
        }

        return FALSE;
    }

    /**
     * Применяем скидку
     * @param MyArray $discount
     * @param MyArray $shopGoodIDs
     * @param $isRound
     * @return bool
     */
    private static function _applyDiscount(MyArray $discount, MyArray $shopGoodIDs, $isRound)
    {
        switch ($discount->values['discount_type_id']) {
            case Model_DiscountType::DISCOUNT_TYPE_BILL_AMOUNT:
                $amount = floatval(Arr::path($discount->values['data'], 'amount', 0));
                if ($amount > Func::getGoodsAmount($shopGoodIDs, $isRound)) {
                    return FALSE;
                }

                foreach ($shopGoodIDs->childs as $shopGoodID) {
                    $b = !(key_exists('calc_is_discount', $shopGoodID->additionDatas)) && ($shopGoodID->additionDatas['calc_is_discount']  == 1);
                    if (!$b){
                        $amountGoods = Func::getGoodAmount($shopGoodID, $shopGoodID->additionDatas['count'], $isRound);

                        $b = (self::_calcDiscount($amountGoods, $shopGoodID->additionDatas['calc_discount'], $shopGoodID->additionDatas['calc_is_percent']) > self::_calcDiscount($amountGoods, $discount->values['discount'], $discount->values['is_percent']));
                    }
                    if ($b){
                        $shopGoodID->additionDatas['calc_is_discount'] = 1;
                        $shopGoodID->additionDatas['calc_discount'] = $discount->values['discount'];
                        $shopGoodID->additionDatas['calc_is_percent'] = $discount->values['is_percent'];
                        $shopGoodID->additionDatas['calc_discount_id'] = $discount->values['id'];
                        $shopGoodID->additionDatas['calc_bill_comment'] = $discount->values['bill_comment'];
                    }
                }
                return TRUE;
            case Model_DiscountType::DISCOUNT_TYPE_CATALOGS:
                $ids = Arr::path($discount->values['data'], 'id', array());
                $amount = floatval(Arr::path($discount->values['data'], 'amount', 0));
                $count = floatval(Arr::path($discount->values['data'], 'count', 0));

                $select = array();
                foreach ($shopGoodIDs->childs as $key => $shopGoodID) {
                    foreach ($ids as $id) {
                        if ($shopGoodID->values['shop_table_rubric_id'] == $id) {
                            $count = $count - $shopGoodID->additionDatas['count'];
                            if ($count <= 0) {
                                break;
                            }
                            $amount = $amount - Func::getGoodAmount($shopGoodID, $shopGoodID->additionDatas['count'], $isRound);
                            if ($amount <= 0) {
                                break;
                            }

                            $select[] = $key;
                        }
                    }
                }

                if (($count > 0) || ($amount > 0)) {
                    return FALSE;
                }

                // применяем скидку
                foreach ($select as $key) {
                    $shopGoodID = &$shopGoodIDs->childs[$key];

                    $b = !(key_exists('calc_is_discount', $shopGoodID->additionDatas)) && ($shopGoodID->additionDatas['calc_is_discount']  == 1);
                    if (!$b){
                        $amountGoods = Func::getGoodAmount($shopGoodID, $shopGoodID->additionDatas['count'], $isRound);

                        $b = (self::_calcDiscount($amountGoods, $shopGoodID->additionDatas['calc_discount'], $shopGoodID->additionDatas['calc_is_percent']) > self::_calcDiscount($amountGoods, $discount->values['discount'], $discount->values['is_percent']));
                    }
                    if ($b){
                        $shopGoodID->additionDatas['calc_is_discount'] = 1;
                        $shopGoodID->additionDatas['calc_discount'] = $discount->values['discount'];
                        $shopGoodID->additionDatas['calc_is_percent'] = $discount->values['is_percent'];
                        $shopGoodID->additionDatas['calc_discount_id'] = $discount->values['id'];
                        $shopGoodID->additionDatas['calc_bill_comment'] = $discount->values['bill_comment'];
                    }

                }

                return TRUE;
            case Model_DiscountType::DISCOUNT_TYPE_GOODS:
                $ids = Arr::path($discount->values['data'], 'id', array());
                $amount = floatval(Arr::path($discount->values['data'], 'amount', 0));
                $count = floatval(Arr::path($discount->values['data'], 'count', 0));

                $select = array();
                foreach ($shopGoodIDs->childs as $key => $shopGoodID) {
                    foreach ($ids as $id) {
                        if ($shopGoodID->values['id'] == $id) {
                            $count = $count - $shopGoodID->additionDatas['count'];
                            if ($count <= 0) {
                                break;
                            }
                            $amount = $amount - Func::getGoodAmount($shopGoodID, $shopGoodID->additionDatas['count'], $isRound);
                            if ($amount <= 0) {
                                break;
                            }

                            $select[] = $key;
                        }
                    }
                }

                if (($count > 0) || ($amount > 0)) {
                    return FALSE;
                }

                // применяем скидку
                foreach ($select as $key) {
                    $shopGoodID = &$shopGoodIDs->childs[$key];

                    $b = !(key_exists('calc_is_discount', $shopGoodID->additionDatas)) && ($shopGoodID->additionDatas['calc_is_discount']  == 1);
                    if (!$b){
                        $amountGoods = Func::getGoodAmount($shopGoodID, $shopGoodID->additionDatas['count'], $isRound);

                        $b = (self::_calcDiscount($amountGoods, $shopGoodID->additionDatas['calc_discount'], $shopGoodID->additionDatas['calc_is_percent']) > self::_calcDiscount($amountGoods, $discount->values['discount'], $discount->values['is_percent']));
                    }
                    if ($b){
                        $shopGoodID->additionDatas['calc_is_discount'] = 1;
                        $shopGoodID->additionDatas['calc_discount'] = $discount->values['discount'];
                        $shopGoodID->additionDatas['calc_is_percent'] = $discount->values['is_percent'];
                        $shopGoodID->additionDatas['calc_discount_id'] = $discount->values['id'];
                        $shopGoodID->additionDatas['calc_bill_comment'] = $discount->values['bill_comment'];
                    }
                }

                return TRUE;
        }

        return FALSE;
    }
}