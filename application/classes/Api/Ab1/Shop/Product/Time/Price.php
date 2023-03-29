<?php defined('SYSPATH') or die('No direct script access.');

class Api_Ab1_Shop_Product_Time_Price  {
    /**
     * Для реализации добавить связи с ценой прайс-листа
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @param array $params
     */
    public static function correctProductPrice(SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver,
                                             array $params = array())
    {
        $params = array_merge(
            Request_RequestParams::setParams(
                array(
                    'is_check_price' => false,
                    'sort_by' => array(
                        'id' => 'desc',
                    )
                )
            ),
            $params
        );

        $elements = array(
            'shop_product_time_price_id' => array('price'),
            'shop_client_contract_item_id' => array('discount', 'price'),
            'shop_product_price_id' => array('discount')
        );

        $shopCarItemIDs = Request_Request::findBranch('DB_Ab1_Shop_Car_Item',
            array(), $sitePageData, $driver, $params, 0, true, $elements
        );
        foreach ($shopCarItemIDs->childs as $child){
            $price = Api_Ab1_Shop_Product::getDiscountItemByPrice(
                $child->values['shop_client_id'],
                $child->values['shop_client_contract_id'],
                $child->values['shop_product_id'],
                $child->values['price'],
                $child->values['created_at'],
                $sitePageData, $driver
            );

            if($price !== false) {
                $driver->updateObjects(
                    Model_Ab1_Shop_Car_Item::TABLE_NAME, array($child->id),
                    array(
                        'shop_client_contract_item_id' => $price['shop_client_contract_item_id'],
                        'shop_product_price_id' => $price['shop_product_price_id'],
                    )
                );
            }
        }

        $shopPieceItemIDs = Request_Request::findBranch('DB_Ab1_Shop_Piece_Item',
            array(), $sitePageData, $driver, $params, 0, true, $elements
        );
        foreach ($shopPieceItemIDs->childs as $child){
            $price = Api_Ab1_Shop_Product::getDiscountItemByPrice(
                $child->values['shop_client_id'],
                $child->values['shop_client_contract_id'],
                $child->values['shop_product_id'],
                $child->values['price'],
                $child->values['created_at'],
                $sitePageData, $driver
            );

            if($price !== false) {
                $driver->updateObjects(
                    Model_Ab1_Shop_Piece_Item::TABLE_NAME, array($child->id),
                    array(
                        'shop_client_contract_item_id' => $price['shop_client_contract_item_id'],
                        'shop_product_price_id' => $price['shop_product_price_id'],
                    )
                );
            }
        }
    }

    /**
     * Для реализации ставим статус проверенная ли цена
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @param array $params
     */
    public static function checkProductPrice(SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver,
                                                  array $params = array())
    {
        $getIsCheckPrice = function (MyArray $child) {
            $isCheckPrice = $child->values['is_charity'] && $child->values['price'] == 0;
            $params = array(
                'shop_product_price_id' => 0,
                'shop_client_contract_item_id' => 0,
            );

            if(!$isCheckPrice){
                $timePrice = $child->getElementValue('shop_product_time_price_id', 'price');
                $isCheckPrice = $child->values['price'] == $timePrice;

                if(!$isCheckPrice){
                    if($child->values['shop_product_price_id'] > 0) {
                        $discount = $child->getElementValue('shop_product_price_id', 'discount');
                        $isCheckPrice = $child->values['price'] == $timePrice - $discount;

                        if($isCheckPrice){
                            $params['shop_product_price_id'] = $child->values['shop_product_price_id'];
                        }
                    }elseif($child->values['shop_client_contract_item_id'] > 0) {
                        $discount = $child->getElementValue('shop_client_contract_item_id', 'discount');

                        if($discount != 0){
                            $isCheckPrice = $child->values['price'] == $timePrice - $discount;
                        }else{
                            $price = $child->getElementValue('shop_client_contract_item_id', 'price');
                            $isCheckPrice = $child->values['price'] == $price;
                        }

                        if($isCheckPrice){
                            $params['shop_client_contract_item_id'] = $child->values['shop_client_contract_item_id'];
                        }
                    }
                }
            }

            $params['is_check_price'] = Func::boolToInt($isCheckPrice);
            return $params;
        };

        $params = array_merge(
            Request_RequestParams::setParams(
                array(
                    'is_check_price' => false,
                    'sort_by' => array(
                        'id' => 'asc',
                    )
                )
            ),
            $params
        );

        $elements = array(
            'shop_product_time_price_id' => array('price'),
            'shop_client_contract_item_id' => array('discount', 'price'),
            'shop_product_price_id' => array('discount')
        );

        $shopCarItemIDs = Request_Request::findBranch('DB_Ab1_Shop_Car_Item',
            array(), $sitePageData, $driver, $params, 0, true, $elements
        );
        foreach ($shopCarItemIDs->childs as $child){
            $isCheckPrice = $getIsCheckPrice($child);

            if(Request_RequestParams::isBoolean($child->values['is_check_price']) != $isCheckPrice['is_check_price']) {
                $driver->updateObjects(
                    Model_Ab1_Shop_Car_Item::TABLE_NAME, array($child->id), $isCheckPrice
                );
            }
        }

        $shopPieceItemIDs = Request_Request::findBranch('DB_Ab1_Shop_Piece_Item',
            array(), $sitePageData, $driver, $params, 0, true, $elements
        );
        foreach ($shopPieceItemIDs->childs as $child){
            $isCheckPrice = $getIsCheckPrice($child);

            if(Request_RequestParams::isBoolean($child->values['is_check_price']) != $isCheckPrice['is_check_price']) {
                $driver->updateObjects(
                    Model_Ab1_Shop_Piece_Item::TABLE_NAME, array($child->id), $isCheckPrice
                );
            }
        }
    }

    /**
     * Для реализации добавить связи с ценой прайс-листа
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @param array $params
     */
    public static function defineProductTimePrice(SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver,
                                                  array $params = array())
    {
        $find = function ($date, $shopProductID, array $shopProductTimePrices) {
            if(!key_exists($shopProductID, $shopProductTimePrices)){
                return 0;
            }
            $shopProductTimePrices = $shopProductTimePrices[$shopProductID];

            $date = strtotime(Helpers_DateTime::getDateFormatPHP($date));
            foreach ($shopProductTimePrices as $child){
                if($child['from'] <= $date && $child['to'] >= $date){
                    return $child['id'];
                }
            }

            return 0;
        };

        $shopProductTimePriceIDs = Request_Request::findBranch('DB_Ab1_Shop_Product_Time_Price',
            array(), $sitePageData, $driver,
            Request_RequestParams::setParams(
                array(

                )
            ),
            0, true
        );

        $shopProductTimePrices = array();
        foreach ($shopProductTimePriceIDs->childs as $child){
            $shopProductID = $child->values['shop_product_id'];
            if(!key_exists($shopProductID, $shopProductTimePrices)){
                $shopProductTimePrices[$shopProductID] = array();
            }

            $shopProductTimePrices[$shopProductID][] = array(
                'from' => strtotime($child->values['from_at']),
                'to' => strtotime($child->values['to_at']),
                'price' => $child->values['price'],
                'id' => $child->values['id'],
            );
        }

        $params = array_merge(
            Request_RequestParams::setParams(
                array(
                    'shop_product_time_price_id' => 0,
                )
            ),
            $params
        );

        $shopCarItemIDs = Request_Request::findBranch('DB_Ab1_Shop_Car_Item',
            array(), $sitePageData, $driver, $params, 0, true
        );
        foreach ($shopCarItemIDs->childs as $child){
            $shopProductTimePriceID = $find($child->values['created_at'], $child->values['shop_product_id'], $shopProductTimePrices);

            if($child->values['shop_product_time_price_id'] != $shopProductTimePriceID) {
                $driver->updateObjects(
                    Model_Ab1_Shop_Car_Item::TABLE_NAME, array($child->id),
                    array('shop_product_time_price_id' => $shopProductTimePriceID)
                );
            }
        }

        $shopPieceItemIDs = Request_Request::findBranch('DB_Ab1_Shop_Piece_Item',
            array(), $sitePageData, $driver, $params, 0, true
        );
        foreach ($shopPieceItemIDs->childs as $child){
            $shopProductTimePriceID = $find($child->values['created_at'], $child->values['shop_product_id'], $shopProductTimePrices);

            if($shopProductTimePriceID < 1){
                print_r($child->values);die;
            }

            if($child->values['shop_product_time_price_id'] != $shopProductTimePriceID) {
                $driver->updateObjects(
                    Model_Ab1_Shop_Piece_Item::TABLE_NAME, array($child->id),
                    array('shop_product_time_price_id' => $shopProductTimePriceID)
                );
            }
        }
    }

    /**
     * Получение цены
     * @param $shopProductID
     * @param $date
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @return null|Model_Ab1_Shop_Product_Time_Price
     */
    public static function getProductTimePrice($shopProductID, $date, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        if($shopProductID < 1) {
            return null;
        }

        if(empty($date)) {
            $date = date('Y-m-d');
        }

        $params = Request_RequestParams::setParams(
            array(
                'shop_product_id' => $shopProductID,
                'from_at_to' => $date,
                'to_at_from_equally' => $date,
            )
        );
        $ids = Request_Request::find('DB_Ab1_Shop_Product_Time_Price',
            $sitePageData->shopID, $sitePageData, $driver, $params, 1
        );
        if(count($ids->childs) > 0){
            $model = new Model_Ab1_Shop_Product_Time_Price();
            $model->setDBDriver($driver);
            $ids->childs[0]->setModel($model);

            return $model;
        }

        return null;
    }

    /**
     * Добавление цены на продукт
     * @param $shopProductID
     * @param $price
     * @param $date
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @param int $shopID
     * @return Model_Ab1_Shop_Product_Time_Price|null
     */
    public static function addProductTimePrice($shopProductID, $price, $date, SitePageData $sitePageData,
                                               Model_Driver_DBBasicDriver $driver, $shopID = 0)
    {
        if($shopProductID < 1) {
            return null;
        }

        if($shopID < 1){
            $shopID = $sitePageData->shopID;
        }

        $model = new Model_Ab1_Shop_Product_Time_Price();
        $model->setDBDriver($driver);

        if(empty($date)) {
            $date = date('Y-m-d');
        }

        $params = Request_RequestParams::setParams(
            array(
                'shop_product_id' => $shopProductID,
            )
        );
        $ids = Request_Request::find(
            'DB_Ab1_Shop_Product_Time_Price', $shopID, $sitePageData, $driver, $params
        );

        $dateD = strtotime($date);
        $from = null;
        $to = null;
        foreach ($ids->childs as $child){
            if(strtotime($child->values['from_at']) <= $dateD
                && ($from == null || strtotime($child->values['from_at']) > strtotime($from->values['from_at']))){
                $from = $child;
                if(strtotime($child->values['to_at']) >= $dateD){
                    break;
                }
            }
            if(($to == null || strtotime($child->values['from_at']) < strtotime($to->values['from_at']))
                && strtotime($child->values['from_at']) > $dateD){
                $to = $child;
            }
        }

        if($from !== null){
            if(strtotime($from->values['from_at']) == $dateD){
                $from->setModel($model);
                $model->setPrice($price);
                Helpers_DB::saveDBObject($model, $sitePageData, $shopID);

                return $model;
            }

            if(strtotime($from->values['from_at']) < $dateD && strtotime($from->values['to_at']) >= $dateD){
                $from->setModel($model);

                // проверяем, что цена изменилась
                if($model->getPrice() != $price) {
                    $toAt = $model->getToAt();
                    $model->setToAt(Helpers_DateTime::minusDays($date, 1));
                    Helpers_DB::saveDBObject($model, $sitePageData, $shopID);

                    $model->clear();
                    $model->setFromAt($date);
                    $model->setToAt($toAt);
                    $model->setPrice($price);
                    $model->setShopProductID($shopProductID);
                    Helpers_DB::saveDBObject($model, $sitePageData, $shopID);
                }

                return $model;
            }
        }

        $model->clear();
        $model->setFromAt($date);
        $model->setPrice($price);
        $model->setShopProductID($shopProductID);

        if($to == null){
            $model->setToAt('2222-01-01');
        }else{
            $model->setToAt(Helpers_DateTime::minusDays($to->values['from_at'], 1));
        }
        Helpers_DB::saveDBObject($model, $sitePageData, $shopID);

        return $model;
    }

    /**
     * Группируем цены по одинаковым ценам
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     */
    public static function groupProductTimePrice(SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        $params = Request_RequestParams::setParams(
            array(
                'sort_by' => array(
                    'shop_product_id' => 'asc',
                    'to_at' => 'asc',
                ),
            )
        );
        $ids = Request_Request::find(
            'DB_Ab1_Shop_Product_Time_Price', $sitePageData->shopID, $sitePageData, $driver, $params
        );

        $model = new Model_Ab1_Shop_Product_Time_Price();
        $model->setDBDriver($driver);

        foreach ($ids->childs as $child){
            if($model->getShopProductID() != $child->values['shop_product_id']){
                $child->setModel($model);
                continue;
            }

            if($model->getPrice() != $child->values['price']){
                $child->setModel($model);
                continue;
            }

            Helpers_DB::delDBByID(
                'DB_Ab1_Shop_Product_Time_Price', $child->id, $sitePageData, $driver
            );
            $model->setToAt($child->values['to_at']);
            Helpers_DB::saveDBObject($model, $sitePageData, $sitePageData->shopID);
        }
    }
}
