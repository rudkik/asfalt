<?php defined('SYSPATH') or die('No direct script access.');

class Helpers_Cart {
    /**
     * Проверяем подходит ли данная скидка
     * @param MyArray $shopGoodIDs
     * @param MyArray $discount
     * @return bool
     */
    private static function _fitDiscount(MyArray $shopGoodIDs, MyArray $discount){
        switch ($discount->values['discount_type_id']) {
            case Model_DiscountType::DISCOUNT_TYPE_BILL_AMOUNT:
                return TRUE;
            case Model_DiscountType::DISCOUNT_TYPE_CATALOGS:
                $count = floatval(Arr::path($discount->values['data'], 'count', 0));
                if($count < 1){
                    $count = FALSE;
                }
                $amount = floatval(Arr::path($discount->values['data'], 'amount', 0));
                if($amount < 1){
                    $amount = FALSE;
                }

                if(($count === FALSE) && ($amount === FALSE)) {
                    return FALSE;
                }

                $ids = Arr::path($discount->values['data'], 'id', array());
                foreach ($ids as $id) {
                    foreach ($shopGoodIDs->childs as $good) {
                        if ($good->values['shop_table_rubric_id'] == $id) {
                            if ($count !== FALSE) {
                                $count = $count - $good->additionDatas['count'];
                                if ($count <= 0) {
                                    break;
                                }
                            }

                            if ($amount !== FALSE) {
                                $amount = $amount - Func::getGoodAmount($good, $good->additionDatas['count'], FALSE);
                                if ($amount <= 0) {
                                    break;
                                }
                            }
                        }
                    }
                }
                return ($count <= 0) && ($amount <= 0);
            case Model_DiscountType::DISCOUNT_TYPE_GOODS:
                $ids = Arr::path($discount->values['data'], 'id', array());
                $count = floatval(Arr::path($discount->values['data'], 'count', 0));
                if($count < 1){
                    $count = FALSE;
                }
                $amount = floatval(Arr::path($discount->values['data'], 'amount', 0));
                if($amount < 1){
                    $amount = FALSE;
                }

                if(($count === FALSE) && ($amount === FALSE)) {
                    return FALSE;
                }

                foreach ($ids as $id) {
                    foreach ($shopGoodIDs->childs as $good) {
                        if ($good->id == $id){
                            if($count !== FALSE) {
                                $count = $count - $good->additionDatas['count'];
                                if ($count <= 0) {
                                    break;
                                }
                            }

                            if($amount !== FALSE) {
                                $amount = $amount - Func::getGoodAmount($good, $good->additionDatas['count'], FALSE);
                                if ($amount <= 0) {
                                    break;
                                }
                            }
                        }
                    }
                }
                return ($count <= 0) && ($amount <= 0);
        }

        return FALSE;
    }

    /**
     * Сравниваем две скидки, возвращаем какая скидка больше
     * (0 - скидки не равны)
     * (1 - больше 1 скидка)
     * (-1 - больше 2 скидка)
     * @param MyArray $discount1
     * @param MyArray $discount2
     * @param int $desc
     * @return int
     */
    private static function _compareDiscount(MyArray $discount1, MyArray $discount2, $desc = 1){
        if($discount1->values['discount_type_id'] != $discount2->values['discount_type_id']){
            return 0;
        }

        switch ($discount1->values['discount_type_id']) {
            case Model_DiscountType::DISCOUNT_TYPE_BILL_AMOUNT:
                $amount1 = floatval(Arr::path($discount1->values['data'], 'amount', 0));
                $amount2 = floatval(Arr::path($discount2->values['data'], 'amount', 0));

                if($amount1 == $amount2) {
                    return 0;
                }elseif ($amount1 > $amount2){
                    return 1 * $desc;
                }else{
                    return -1 * $desc;
                }
                break;
            case Model_DiscountType::DISCOUNT_TYPE_CATALOGS:
            case Model_DiscountType::DISCOUNT_TYPE_GOODS:
                $count1 = floatval(Arr::path($discount1->values['data'], 'count', 0));
                $count2 = floatval(Arr::path($discount2->values['data'], 'count', 0));

                if($count1 == $count2) {
                    $amount1 = floatval(Arr::path($discount1->values['data'], 'amount', 0));
                    $amount2 = floatval(Arr::path($discount2->values['data'], 'amount', 0));
                    if ($amount1 == $amount2) {
                        return 0;
                    } elseif ($amount1 > $amount2) {
                        return 1 * $desc;
                    } else {
                        return -1 * $desc;
                    }
                }elseif ($count1 > $count2) {
                    return 1 * $desc;
                } else {
                    return -1 * $desc;
                }
                break;
            default:
                return 0;
        }
    }

    /**
     * Считаем скидку
     * @param $amount
     * @param $discount
     * @param $isPercent
     * @return float
     */
    private static function _calcDiscount($amount, $discount, $isPercent){
        if($isPercent == 1){
            return $amount / 100 * (100 - $discount);
        }else{
            return $amount - $discount;
        }
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

	/**
	 * Проверяем подходит ли данная акция
	 * @param MyArray $shopGoodIDs
	 * @param MyArray $action
	 * @return boolean
	 */
	private static function _fitAction(MyArray $shopGoodIDs, MyArray $action){
		switch ($action->values['action_type_id']) {
			case Model_ActionType::ACTION_TYPE_BILL_AMOUNT:
				return TRUE;
			case Model_ActionType::ACTION_TYPE_CATALOGS:{
				$count = floatval(Arr::path($action->values['data'], 'count', 0));
				if($count < 1){
					$count = FALSE;
				}
				$amount = floatval(Arr::path($action->values['data'], 'amount', 0));
				if($amount < 1){
					$amount = FALSE;
				}

                if(($count === FALSE) && ($amount === FALSE)) {
                    return FALSE;
                }

                $ids = Arr::path($action->values['data'], 'id', array());
                foreach ($ids as $id) {
					foreach ($shopGoodIDs->childs as $good) {
						if ($good->values['shop_table_rubric_id'] == $id){
							if($count !== FALSE) {
								$count = $count - $good->additionDatas['count'];
								if ($count <= 0) {
									break;
								}
							}

							if($amount !== FALSE) {
								$amount = $amount - Func::getGoodAmount($good, $good->additionDatas['count'], FALSE);
								if ($amount <= 0) {
									break;
								}
							}
						}
					}
				}
                return ($count <= 0) && ($amount <= 0);
			}
			break;
			case Model_ActionType::ACTION_TYPE_GOODS:{
                $count = floatval(Arr::path($action->values['data'], 'count', 0));
                if($count < 1){
                    $count = FALSE;
                }
                $amount = floatval(Arr::path($action->values['data'], 'amount', 0));
                if($amount < 1){
                    $amount = FALSE;
                }

                if(($count === FALSE) && ($amount === FALSE)) {
                    return FALSE;
                }

                $ids = Arr::path($action->values['data'], 'id', array());
                foreach ($ids as $id) {
                    foreach ($shopGoodIDs->childs as $good) {
                        if ($good->id == $id){
                            if($count !== FALSE) {
                                $count = $count - $good->additionDatas['count'];
                                if ($count <= 0) {
                                    break;
                                }
                            }

                            if($amount !== FALSE) {
                                $amount = $amount - Func::getGoodAmount($good, $good->additionDatas['count'], FALSE);
                                if ($amount <= 0) {
                                    break;
                                }
                            }
                        }
                    }
                }
                return ($count <= 0) && ($amount <= 0);
			}
		}
	
		return FALSE;
	}

    /**
     * Сравниваем две акции, возвращаем какая акция больше
     * (0 - акции не равны)
     * (1 - больше 1 акция)
     * (-1 - больше 2 акция)
     * @param MyArray $action1
     * @param MyArray $action2
     * @param int $desc
     * @return int
     */
	private static function _compareAction(MyArray $action1, MyArray $action2, $desc = -1){
		if($action1->values['action_type_id'] != $action2->values['action_type_id']){
			return 0;
		}
	
		switch ($action1->values['action_type_id']) {
            case Model_ActionType::ACTION_TYPE_BILL_AMOUNT:
                $amount1 = floatval(Arr::path($action1->values['data'], 'amount', 0));
                $amount2 = floatval(Arr::path($action2->values['data'], 'amount', 0));

                if($amount1 == $amount2) {
                    return 0;
                }elseif ($amount1 > $amount2){
                    return 1 * $desc;
                }else{
                    return -1 * $desc;
                }
                break;
            case Model_ActionType::ACTION_TYPE_CATALOGS:
            case Model_ActionType::ACTION_TYPE_GOODS:
                $count1 = floatval(Arr::path($action1->values['data'], 'count', 0));
                $count2 = floatval(Arr::path($action2->values['data'], 'count', 0));

                if($count1 == $count2) {
                    $amount1 = floatval(Arr::path($action1->values['data'], 'amount', 0));
                    $amount2 = floatval(Arr::path($action2->values['data'], 'amount', 0));
                    if ($amount1 == $amount2) {
                        return 0;
                    } elseif ($amount1 > $amount2) {
                        return 1 * $desc;
                    } else {
                        return -1 * $desc;
                    }
                }elseif ($count1 > $count2) {
                    return 1 * $desc;
                } else {
                    return -1 * $desc;
                }
                break;
			default:
				return 0;
		}
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
     * Делаем просчет по скидкам и акциям
     * @param $shopID
     * @param MyArray $shopGoodIDs
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @return MyArray
     */
    public static function countUpShopGoods($shopID, MyArray $shopGoodIDs, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver){
        // убираем товары, которых нет в базе данных
        $model = new Model_Shop_Good();
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

                    $child->additionDatas['calc_is_person_discount'] = 1;
                    $child->additionDatas['calc_person_discount'] = $modelPersonDiscount->getDiscount();
                    $child->additionDatas['calc_person_is_percent'] = $modelPersonDiscount->getIsPercent();
                    $child->additionDatas['calc_person_id'] = $shopPersonDiscountID;

                    if($modelPersonDiscount->getIsPercent()){
                        $child->values['price'] = round($child->values['price'] / 100 * (100 - $modelPersonDiscount->getDiscount()));
                    }else{
                        $child->values['price'] = $child->values['price'] - $modelPersonDiscount->getDiscount();
                    }
                }
            }
        }

        $shopCouponID = Api_Shop_Cart::getShopCouponID($sitePageData);
        if($shopCouponID > 0){
            /** @var Model_Shop_Coupon $modelCoupon */
            $modelCoupon = Request_Request::findOneModelByID(
                DB_Shop_Coupon::NAME, $shopCouponID, $sitePageData->shopID, $sitePageData, $driver
            );

            if($modelCoupon != null){
                $rubrics = Request_Shop_Table_Basic_Rubric::findRubricIDsByMain(
                    $sitePageData->shopID, $sitePageData, $driver,
                    Request_RequestParams::setParams(['id' => $modelCoupon->getShopTableRubricIDsArray()])
                );
                $rubrics->treeInList()->runIndex(true);

                foreach ($shopGoodIDs->childs as $child){
                    $shopTableRubricID = $child->values['shop_table_rubric_id'];
                    if(!key_exists($shopTableRubricID, $rubrics->childs)){
                        continue;
                    }

                    $child->additionDatas['calc_is_coupon'] = 1;
                    $child->additionDatas['calc_coupon_discount'] = $modelCoupon->getDiscount();
                    $child->additionDatas['calc_coupon_is_percent'] = $modelCoupon->getIsPercent();
                    $child->additionDatas['calc_coupon_id'] = $shopCouponID;

                    if($modelCoupon->getIsPercent()){
                        $child->values['price'] = round($child->values['price'] / 100 * (100 - $modelCoupon->getDiscount()));
                    }else{
                        $child->values['price'] = $child->values['price'] - $modelCoupon->getDiscount();
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
     * Делаем пересчет заказа с товарами
     * (при изменении количества или удалении товара)
     * @param $shopID
     * @param $shopBillID
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @throws HTTP_Exception_404
     */
    public static function countUpBill($shopID, $shopBillID, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        $model = new Model_Shop_Bill();
        $model->setDBDriver($driver);
        if(! $model->dbGet($shopBillID, $sitePageData->dataLanguageID, $sitePageData->languageID,  -1, $shopID)){
            throw new HTTP_Exception_404('Bill not found.');
        }

        $shopBillItemIDs = Request_Request::find(
            'DB_Shop_Bill_Item', $shopID, $sitePageData, $driver,
            Request_RequestParams::setParams(
                array(
                    'shop_bill_id' => $shopBillID
                )
            ), 0, true
        );

        $shopGoodIDs = new MyArray();
        foreach ($shopBillItemIDs->childs as $shopBillItemID) {
            if ($shopBillItemID->values['is_add_action'] != 1) {
                $shopGoodID = $shopGoodIDs->addChild($shopBillItemID->values['shop_good_id']);
                $shopGoodID->additionDatas = array(
                    'count' => $shopBillItemID->values['count'],
                    'shop_good_child_id' => $shopBillItemID->values['shop_good_child_id'],
                );
            }
        }
        // просчитываем скидки
        $shopGoodIDs = self::countUpShopGoods($shopID, $shopGoodIDs, $sitePageData, $driver);

        $billAmount = 0;
        $billItems = array();
        foreach ($shopGoodIDs->childs as $shopGoodID) {
            $modelBillItem = new Model_Shop_Bill_Item();
            $modelBillItem->setDBDriver($driver);

            $shopBillItemID = $shopBillItemIDs->findChildValues(
                array(
                    'shop_good_id' => $shopGoodID->id,
                    'shop_good_child_id' => $shopGoodID->additionDatas['shop_good_child_id'],
                )
            );
            if($shopBillItemID !== FALSE){
                $modelBillItem->__setArray(array('values' => $shopBillItemID->values));
                $shopBillItemID->id = 0;
            }

            $modelBillItem->shopID = $shopID;
			$modelBillItem->setShopTableChildID($shopGoodID->additionDatas['shop_good_child_id']);
            $modelBillItem->setShopGoodID($shopGoodID->id);
            $modelBillItem->setClientComment(trim($modelBillItem->getClientComment()."\r\n".Arr::path($shopGoodID->additionDatas, 'calc_bill_comment', '')));
            $modelBillItem->setCountElement($shopGoodID->additionDatas['count']);

            if (Arr::path($shopGoodID->additionDatas, 'free', '') == 1){
                $modelBillItem->setPrice(0);
            }else{
                $modelBillItem->setPrice($shopGoodID->values['price']);
            }

            if($shopGoodID->values['calc_is_discount'] == 1){
                $modelBillItem->setDiscount($shopGoodID->values['calc_discount']);
                $modelBillItem->setIsPercent($shopGoodID->values['calc_is_percent']);
                $modelBillItem->setShopDiscountID($shopGoodID->values['calc_discount_id']);
            }elseif($shopGoodID->values['calc_is_person_discount'] == 1){
                $modelBillItem->setDiscount($shopGoodID->additionDatas['calc_person_discount']);
                $modelBillItem->setIsPercent($shopGoodID->additionDatas['calc_person_is_percent']);
                $modelBillItem->setShopPersoneDiscountID($shopGoodID->additionDatas['calc_person_id']);
            }elseif($shopGoodID->values['calc_is_coupon'] == 1){
                $modelBillItem->setDiscount($shopGoodID->additionDatas['calc_coupon_discount']);
                $modelBillItem->setIsPercent($shopGoodID->additionDatas['calc_coupon_is_percent']);
                $modelBillItem->setShopCouponID($shopGoodID->additionDatas['calc_coupon_id']);
            }else{
                $modelBillItem->setDiscount(0);
                $modelBillItem->setIsPercent(FALSE);
                $modelBillItem->setShopDiscountID(0);
            }

            if ($sitePageData->currency->getisRound()){
                $modelBillItem->setAmount(round($modelBillItem->getAmount()));
            }
            $billAmount = $billAmount + $modelBillItem->getAmount();

            Helpers_DB::saveDBObject($modelBillItem, $sitePageData, $shopID);
            $billItems[] = $modelBillItem;
        }

        // удаляем лишние записи
        $modelItem = new Model_Shop_Bill_Item();
        $modelItem->setDBDriver($driver);
        foreach($shopBillItemIDs->childs as $shopBillItemID){
            if($shopBillItemID->id > 0){
                $modelItem->id = $shopBillItemID->id;
                $modelItem->dbDelete($sitePageData->userID, 0, $shopID);
            }
        }

        // меняем цену заказа
        $model->setGoodsAmount($billAmount);
        if ($sitePageData->currency->getisRound()){
            $model->setAmount(round($model->getAmount()));
        }
        Helpers_DB::saveDBObject($model, $sitePageData, $shopID);

        // корректируем баланс филиала
        if(($model->getShopRootID() > 0)) {
            $modelShop = new Model_Shop();
            $modelShop->setDBDriver($driver);

            // редактируем баланс
            if (Helpers_DB::getDBObject($modelShop, $model->getShopRootID(), $sitePageData)) {
                $modelShop->setBalance($modelShop->getBalance() + floatval($model->getOriginalValue('amount')) - $model->getAmount());
                Helpers_DB::saveDBObject($modelShop, $sitePageData);
            }
        }
    }



}