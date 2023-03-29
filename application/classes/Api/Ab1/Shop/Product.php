<?php defined('SYSPATH') or die('No direct script access.');

class Api_Ab1_Shop_Product  {
    /**
     * Прайс лист Бетон
     * @param $shopProductRubricID
     * @param $date
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @return array
     */
    public function getPriceListConcrete($shopProductRubricID, $date, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver) {
        $shopProductIDs = Api_Ab1_Shop_Product::findAllByMainRubric(
            $shopProductRubricID, $sitePageData, $driver
        );

        if(empty($date)){
            $date = date('Y-m-d');
        }

        $params = Request_RequestParams::setParams(
            array(
                'shop_product_id' => $shopProductIDs,
                'from_at_to' => $date,
                'to_at_from_equally' => $date,
                'price_from' => 0,
            )
        );
        $ids = Request_Request::findBranch(
            'DB_Ab1_Shop_Product_Time_Price',
            array(), $sitePageData, $driver, $params, 0, true,
            array(
                'shop_product_id' => array('name_site', 'is_public', 'is_pricelist', 'order'),
                'shop_product_pricelist_rubric_id' => array('id', 'name', 'order'),
            )
        );

        $dateStart = null;
        $products = array();
        foreach($ids->childs as $child){
            if($child->getElementValue('shop_product_id', 'is_public') != 1
                || $child->getElementValue('shop_product_id', 'is_pricelist') != 1){
                continue;
            }

            $rubricID = $child->getElementValue('shop_product_pricelist_rubric_id', 'id');
            if(!key_exists($rubricID, $products)){
                $products[$rubricID] = array(
                    'name' => $child->getElementValue('shop_product_pricelist_rubric_id'),
                    'order' => $child->getElementValue('shop_product_pricelist_rubric_id', 'order'),
                    'data' => array(),
                );
            }

            $order = $child->getElementValue('shop_product_id', 'order');

            $productName = $child->getElementValue('shop_product_id', 'name_site');
            if(!key_exists($productName, $products[$rubricID]['data'])){
                $product = array(
                    'name' => $productName,
                    'from_at' => $child->values['from_at'],
                    'price' => '',
                    'order' => $order,
                );
                $products[$rubricID]['data'][$productName] = $product;
            }elseif($order > $products[$rubricID]['data'][$productName]['order']){
                $products[$rubricID]['data'][$productName]['order'] = $order;
            }

            $products[$rubricID]['data'][$productName]['price'] = Func::getNumberStr($child->values['price'], true, 2, true);

            $fromAt = strtotime($child->values['from_at']);
            if($dateStart == null || $dateStart < $fromAt){
                $dateStart = $fromAt;
            }
        }

        foreach ($products as &$product){
            uasort($product['data'], function ($x, $y) {
                if($x['order'] == $y['order']){
                    return strcasecmp($x['name'], $y['name']);
                }
                if($x['order'] > $y['order']){
                    return 1;
                }
                return -1;
            });
        }
        uasort($products, function ($x, $y) {
            if($x['order'] == $y['order']){
                return strcasecmp($x['name'], $y['name']);
            }
            if($x['order'] > $y['order']){
                return 1;
            }
            return -1;
        });

        $params = Request_RequestParams::setParams(
            array(
                'shop_product_rubric_id' => $shopProductRubricID,
            )
        );
        $ids = Request_Request::find('DB_Ab1_Shop_Delivery',
            0, $sitePageData, $driver, $params, 0, true
        );

        $deliveries = array();
        foreach($ids->childs as $child){
            $distance = Arr::path(json_decode($child->values['options'], true),'distance', '');
            if(!key_exists($distance, $deliveries)){
                $deliveries[$distance] = array(
                    'name' => $distance,
                    'distance' => $distance,
                    'price' => $child->values['price'],
                );

                if($child->values['price'] <= 0){
                    $deliveries[$distance]['price'] = 'договорная';
                }
            }
        }
        uasort($deliveries, function ($x, $y) {
            if($x['price'] < 1 || !is_numeric($x['price'])){
                return 1;
            }

            if($y['price'] < 1 || !is_numeric($y['price'])){
                return -1;
            }

            if($x['price'] == $y['price']){
                return 0;
            }

            if($x['price'] > $y['price']){
                return 1;
            }

            return -1;
        });
        $deliveries = array_values($deliveries);

        $priceList = array(
            'date' => Helpers_DateTime::getDateTimeDayMonthRus(date('Y-m-d', $dateStart), true),
        );

        return array(
            'price_list' => $priceList,
            'deliveries' => $deliveries,
            'products' => $products,
        );
    }
    
    /**
     * Прайс лист ЖБИ
     * @param $shopProductRubricID
     * @param $date
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @return array
     */
    public function getPriceListZhbiOther($shopProductRubricID, $date, SitePageData $sitePageData,
                                          Model_Driver_DBBasicDriver $driver, $shopProductPricelistRubricID = -1) {
        $shopProductIDs = Api_Ab1_Shop_Product::findAllByMainRubric(
            $shopProductRubricID, $sitePageData, $driver
        );

        if(empty($date)){
            $date = date('Y-m-d');
        }

        $params = Request_RequestParams::setParams(
            array(
                'shop_product_id' => $shopProductIDs,
                'from_at_to' => $date,
                'to_at_from_equally' => $date,
                'price_from' => 0,
            )
        );
        $ids = Request_Request::findBranch('DB_Ab1_Shop_Product_Time_Price',
            array(), $sitePageData, $driver, $params, 0, true,
            array(
                'shop_product_id' => array('name_site', 'is_public', 'options', 'is_pricelist', 'order'),
                'shop_product_pricelist_rubric_id' => array('id', 'name', 'order'),
            )
        );

        $dateStart = null;
        $products = array();
        foreach($ids->childs as $child){
            if($child->getElementValue('shop_product_id', 'is_public') != 1
                || $child->getElementValue('shop_product_id', 'is_pricelist') != 1
                || ($shopProductPricelistRubricID > 0
                    && $child->getElementValue('shop_product_pricelist_rubric_id', 'id') == $shopProductPricelistRubricID)){
                continue;
            }

            $rubricID = $child->getElementValue('shop_product_pricelist_rubric_id', 'id');
            if(!key_exists($rubricID, $products)){
                $products[$rubricID] = array(
                    'name' => $child->getElementValue('shop_product_pricelist_rubric_id'),
                    'order' => $child->getElementValue('shop_product_pricelist_rubric_id', 'order'),
                    'data' => array(),
                );
            }

            $order = $child->getElementValue('shop_product_id', 'order');

            $productName = $child->getElementValue('shop_product_id', 'name_site');
            if(!key_exists($productName, $products[$rubricID]['data'])){
                $product = array(
                    'name' => $productName,
                    'from_at' => $child->values['from_at'],
                    'price' => '',
                    'options' => json_decode($child->getElementValue('shop_product_id', 'options'), true),
                    'order' => $order,
                );

                $length = Arr::path($product['options'], 'length', '');
                $width = Arr::path($product['options'], 'width', '');
                $height = Arr::path($product['options'], 'height', '');

                $s = '';
                if(!empty($length)){
                    $s = $length;
                }

                if(!empty($width)){
                    if(!empty($s)){
                        $width = 'x'.$width;
                    }
                    $s .= $width;
                }

                if(!empty($height)){
                    if(!empty($s)){
                        $height = 'x'.$height;
                    }
                    $s .= $height;
                }
                $product['size'] = $s;

                $products[$rubricID]['data'][$productName] = $product;
            }elseif($order > $products[$rubricID]['data'][$productName]['order']){
                $products[$rubricID]['data'][$productName]['order'] = $order;
            }

            $products[$rubricID]['data'][$productName]['price'] = Func::getNumberStr($child->values['price'], true, 2, true);

            $fromAt = strtotime($child->values['from_at']);
            if($dateStart == null || $dateStart < $fromAt){
                $dateStart = $fromAt;
            }
        }

        foreach ($products as &$product){
            uasort($product['data'], function ($x, $y) {
                if($x['order'] == $y['order']){
                    return strcasecmp($x['name'], $y['name']);
                }
                if($x['order'] > $y['order']){
                    return 1;
                }
                return -1;
            });
        }
        uasort($products, function ($x, $y) {
            if($x['order'] == $y['order']){
                return strcasecmp($x['name'], $y['name']);
            }
            if($x['order'] > $y['order']){
                return 1;
            }
            return -1;
        });

        $params = Request_RequestParams::setParams(
            array(
                'shop_product_rubric_id' => $shopProductRubricID,
            )
        );
        $ids = Request_Request::find('DB_Ab1_Shop_Delivery',
            $sitePageData->shopID, $sitePageData, $driver, $params, 0, true
        );

        $deliveries = array();
        foreach($ids->childs as $child){
            $distance = Arr::path(json_decode($child->values['options'], true),'distance', '');
            if(!key_exists($distance, $deliveries)){
                $deliveries[$distance] = array(
                    'name' => $distance,
                    'distance' => $distance,
                    'price' => $child->values['price'],
                );
            }
        }
        uasort($deliveries, function ($x, $y) {
            if($x['price'] < 1){
                return 1;
            }

            if($y['price'] < 1){
                return -1;
            }

            if($x['price'] == $y['price']){
                return 0;
            }

            if($x['price'] > $y['price']){
                return 1;
            }

            return -1;
        });
        $deliveries = array_values($deliveries);

        $priceList = array(
            'date' => Helpers_DateTime::getDateTimeDayMonthRus(date('Y-m-d', $dateStart), true),
        );

        return array(
            'price_list' => $priceList,
            'deliveries' => $deliveries,
            'products' => $products,
        );
    }

    /**
     * Прайс лист Нефтебитум
     * @param $shopProductRubricID
     * @param $date
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @return array
     */
    public function getPriceListBitumenBranch($shopProductRubricID, $date, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver) {
        if(empty($date)){
            $date = date('Y-m-d');
        }

        $shopProductIDs = Api_Ab1_Shop_Product::findAllByMainRubric(
            $shopProductRubricID, $sitePageData, $driver
        );

        $params = Request_RequestParams::setParams(
            array(
                'shop_product_id' => $shopProductIDs,
                'from_at_to' => $date,
                'to_at_from_equally' => $date,
                'price_from' => 0,
            )
        );
        $ids = Request_Request::findBranch(
            'DB_Ab1_Shop_Product_Time_Price',
            array(), $sitePageData, $driver, $params, 0, true,
            array('shop_product_id' => array('name_site', 'is_public', 'is_pricelist', 'options', 'order', 'shop_id'))
        );

        $dateStart = null;
        $products = array();
        foreach($ids->childs as $child){
            if($child->getElementValue('shop_product_id', 'is_public') != 1
                || $child->getElementValue('shop_product_id', 'is_pricelist') != 1){
                continue;
            }
            $order = $child->getElementValue('shop_product_id', 'order');

            $productName = $child->getElementValue('shop_product_id', 'name_site');
            if(!key_exists($productName, $products)){
                $product = array(
                    'name' => $productName,
                    'from_at' => $child->values['from_at'],
                    'price_main' => '',
                    'price_branch' => '',
                    'order' => $order,
                );

                if(Request_RequestParams::isBoolean(Arr::path(json_decode($child->getElementValue('shop_product_id', 'options'), true),'amdor_9', false))){
                    $product['name'] .= ' *';
                }

                $products[$productName] = $product;
            }elseif($order > $products[$productName]['order']){
                $products[$productName]['order'] = $order;
            }

            if($child->getElementValue('shop_product_id', 'shop_id') == $sitePageData->shopMainID){
                $products[$productName]['price_main'] = Func::getNumberStr($child->values['price'], true, 2, true);
            }else{
                $products[$productName]['price_branch'] = Func::getNumberStr($child->values['price'], true, 2, true);
            }

            $fromAt = strtotime($child->values['from_at']);
            if($dateStart == null || $dateStart < $fromAt){
                $dateStart = $fromAt;
            }
        }
        uasort($products, function ($x, $y) {
            if($x['order'] == $y['order']){
                return strcasecmp($x['name'], $y['name']);
            }
            if($x['order'] > $y['order']){
                return 1;
            }
            return -1;
        });

        $params = Request_RequestParams::setParams(
            array(
                'shop_product_rubric_id' => $shopProductRubricID,
            )
        );
        $ids = Request_Request::find('DB_Ab1_Shop_Delivery',
            $sitePageData->shopMainID, $sitePageData, $driver, $params, 0, true
        );

        $deliveries = array();
        foreach($ids->childs as $child){
            $distance = Arr::path(json_decode($child->values['options'], true),'distance', '');
            if(!key_exists($distance, $deliveries)){
                $deliveries[$distance] = array(
                    'name' => $distance,
                    'price' => $child->values['price'],
                );
            }
        }
        uasort($deliveries, function ($x, $y) {
            if($x['price'] < 1){
                return 1;
            }

            if($y['price'] < 1){
                return -1;
            }

            if($x['price'] == $y['price']){
                return 0;
            }

            if($x['price'] > $y['price']){
                return 1;
            }

            return -1;
        });
        $deliveries = array_values($deliveries);

        $n = ceil(count($deliveries) / 2);
        $listTwo = array();
        for($i = 0; $i < $n; $i++){
            $listTwo[$i] = array(
                'distance_1' => $deliveries[$i]['name'],
                'price_1' => Func::getNumberStr($deliveries[$i]['price'], true, 2, true),
                'distance_2' => '',
                'price_2' => '',
            );
        }

        for($i = $n; $i < count($deliveries); $i++){
            $listTwo[$i - $n]['distance_2'] = $deliveries[$i]['name'];
            $listTwo[$i - $n]['price_2'] = Func::getNumberStr($deliveries[$i]['price'], true, 2, true);
        }

        $priceList = array(
            'date' => Helpers_DateTime::getDateTimeDayMonthRus(date('Y-m-d', $dateStart), true),
        );

        return array(
            'products' => $products,
            'deliveries' => $listTwo,
            'price_list' => $priceList,
        );
    }


    /**
     * Прайс лист Нефтебитум
     * @param $shopProductRubricID
     * @param $date
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @return array
     */
    public function getPriceListBitumen($shopProductRubricID, $date, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver) {
        $shopProductIDs = Api_Ab1_Shop_Product::findAllByMainRubric(
            $shopProductRubricID, $sitePageData, $driver
        );

        if(empty($date)){
            $date = date('Y-m-d');
        }

        $params = Request_RequestParams::setParams(
            array(
                'shop_product_id' => $shopProductIDs,
                'from_at_to' => $date,
                'to_at_from_equally' => $date,
                'price_from' => 0,
            )
        );
        $ids = Request_Request::findBranch('DB_Ab1_Shop_Product_Time_Price',
            array(), $sitePageData, $driver, $params, 0, true,
            array('shop_product_id' => array('name_site', 'is_public', 'is_pricelist', 'order'))
        );

        $dateStart = null;
        $products = array();
        foreach($ids->childs as $child){
            if($child->getElementValue('shop_product_id', 'is_public') != 1
                || $child->getElementValue('shop_product_id', 'is_pricelist') != 1){
                continue;
            }

            $order = $child->getElementValue('shop_product_id', 'order');

            $productName = $child->getElementValue('shop_product_id', 'name_site');
            if(!key_exists($productName, $products)){
                $product = array(
                    'name' => $productName,
                    'from_at' => $child->values['from_at'],
                    'price' => '',
                    'order' => $order,
                );
                $products[$productName] = $product;
            }elseif($order > $products[$productName]['order']){
                $products[$productName]['order'] = $order;
            }

            $products[$productName]['price'] = Func::getNumberStr($child->values['price'], true, 2, true);

            $fromAt = strtotime($child->values['from_at']);
            if($dateStart == null || $dateStart < $fromAt){
                $dateStart = $fromAt;
            }
        }
        uasort($products, function ($x, $y) {
            if($x['order'] == $y['order']){
                return strcasecmp($x['name'], $y['name']);
            }
            if($x['order'] > $y['order']){
                return 1;
            }
            return -1;
        });

        $params = Request_RequestParams::setParams(
            array(
                'shop_product_rubric_id' => $shopProductRubricID,
            )
        );
        $ids = Request_Request::find('DB_Ab1_Shop_Delivery',
            $sitePageData->shopMainID, $sitePageData, $driver, $params, 0, true
        );

        $deliveries = array();
        foreach($ids->childs as $child){
            $distance = Arr::path(json_decode($child->values['options'], true),'distance', '');
            if(!key_exists($distance, $deliveries)){
                $deliveries[$distance] = array(
                    'name' => $distance,
                    'price' => $child->values['price'],
                );
            }
        }
        uasort($deliveries, function ($x, $y) {
            if($x['price'] < 1){
                return 1;
            }

            if($y['price'] < 1){
                return -1;
            }

            if($x['price'] == $y['price']){
                return 0;
            }

            if($x['price'] > $y['price']){
                return 1;
            }

            return -1;
        });
        $deliveries = array_values($deliveries);

        $n = ceil(count($deliveries) / 2);
        $listTwo = array();
        for($i = 0; $i < $n; $i++){
            $listTwo[$i] = array(
                'distance_1' => $deliveries[$i]['name'],
                'price_1' => Func::getNumberStr($deliveries[$i]['price'], true, 2, true),
                'distance_2' => '',
                'price_2' => '',
            );
        }

        for($i = $n; $i < count($deliveries); $i++){
            $listTwo[$i - $n]['distance_2'] = $deliveries[$i]['name'];
            $listTwo[$i - $n]['price_2'] = Func::getNumberStr($deliveries[$i]['price'], true, 2, true);
        }

        $priceList = array(
            'date' => Helpers_DateTime::getDateTimeDayMonthRus(date('Y-m-d', $dateStart), true),
        );

        return array(
            'products' => $products,
            'deliveries' => $listTwo,
            'price_list' => $priceList,
        );
    }
    
    /**
     * Прайс лист Каменных материалов
     * @param $shopProductRubricID
     * @param $date
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @return array
     */
    public function getPriceListStoneMaterial($shopProductRubricID, $date, SitePageData $sitePageData,
                                              Model_Driver_DBBasicDriver $driver) {
        if(empty($date)){
            $date = date('Y-m-d');
        }

        $shopProductIDs = Api_Ab1_Shop_Product::findAllByMainRubric(
            $shopProductRubricID, $sitePageData, $driver
        );

        $params = Request_RequestParams::setParams(
            array(
                'shop_product_id' => $shopProductIDs,
                'from_at_to' => $date,
                'to_at_from_equally' => $date,
                'price_from' => 0,
            )
        );
        $ids = Request_Request::findBranch(
            'DB_Ab1_Shop_Product_Time_Price',
            array(), $sitePageData, $driver, $params, 0, true,
            array(
                'shop_product_id' => array('name_site', 'is_public', 'is_pricelist', 'order', 'shop_id'),
            )
        );

        $dateStart = null;
        $products = array();
        foreach($ids->childs as $child){
            if($child->getElementValue('shop_product_id', 'is_public') != 1
                || $child->getElementValue('shop_product_id', 'is_pricelist') != 1){
                continue;
            }

            $order = $child->getElementValue('shop_product_id', 'order');

            $productName = $child->getElementValue('shop_product_id', 'name_site');
            if(!key_exists($productName, $products)){
                $product = array(
                    'name' => $productName,
                    'from_at' => $child->values['from_at'],
                    'price_main' => '',
                    'price_branch' => '',
                    'order' => $order,
                );

                if(Request_RequestParams::isBoolean(Arr::path(json_decode($child->values['options'], true),'amdor_9', false))){
                    $product['name'] .= '*';
                }

                $products[$productName] = $product;
            }elseif($order > $products[$productName]['order']){
                $products[$productName]['order'] = $order;
            }

            if($child->getElementValue('shop_product_id', 'shop_id') == $sitePageData->shopMainID){
                $products[$productName]['price_main'] = Func::getNumberStr($child->values['price'], true, 2, true);
            }else{
                $products[$productName]['price_branch'] = Func::getNumberStr($child->values['price'], true, 2, true);
            }

            $fromAt = strtotime($child->values['from_at']);
            if($dateStart == null || $dateStart < $fromAt){
                $dateStart = $fromAt;
            }
        }
        uasort($products, function ($x, $y) {
            if($x['order'] == $y['order']){
                return strcasecmp($x['name'], $y['name']);
            }
            if($x['order'] > $y['order']){
                return 1;
            }
            return -1;
        });

        $priceList = array(
            'date' => Helpers_DateTime::getDateTimeDayMonthRus(date('Y-m-d', $dateStart), true),
        );
        
        return array(
            'price_list' => $priceList,
            'products' => $products,
        );
    }

    /**
     * Прайс лист Асфальтобетон
     * @param $shopProductRubricID
     * @param $date
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @return array
     */
    public static function getPriceListAsphalt($shopProductRubricID, $date, SitePageData $sitePageData,
                                               Model_Driver_DBBasicDriver $driver) {
        if(empty($date)){
            $date = date('Y-m-d');
        }

        $shopProductIDs = Api_Ab1_Shop_Product::findAllByMainRubric(
            $shopProductRubricID, $sitePageData, $driver
        );

        $params = Request_RequestParams::setParams(
            array(
                'shop_product_id' => $shopProductIDs,
                'from_at_to' => $date,
                'to_at_from_equally' => $date,
                'price_from' => 0,
            )
        );
        $ids = Request_Request::findBranch('DB_Ab1_Shop_Product_Time_Price',
            array(), $sitePageData, $driver, $params, 0, true,
            array('shop_product_id' => array('name_site', 'is_public', 'is_pricelist', 'options', 'order', 'shop_id'))
        );

        $dateStart = null;
        $products = array();
        foreach($ids->childs as $child){
            if($child->getElementValue('shop_product_id', 'is_public') != 1
                || $child->getElementValue('shop_product_id', 'is_pricelist') != 1){
                continue;
            }
            $order = $child->getElementValue('shop_product_id', 'order');

            $productName = $child->getElementValue('shop_product_id', 'name_site');
            if(!key_exists($productName, $products)){
                $product = array(
                    'name' => $productName,
                    'from_at' => $child->values['from_at'],
                    'price_main' => '',
                    'price_branch' => '',
                    'order' => $order,
                );

                if(Request_RequestParams::isBoolean(Arr::path(json_decode($child->getElementValue('shop_product_id', 'options'), true),'amdor_9', false))){
                    $product['name'] .= ' *';
                }

                $products[$productName] = $product;
            }elseif($order > $products[$productName]['order']){
                $products[$productName]['order'] = $order;
            }

            if($child->getElementValue('shop_product_id', 'shop_id') == $sitePageData->shopMainID){
                $products[$productName]['price_main'] = Func::getNumberStr($child->values['price'], true, 2, true);
            }else{
                $products[$productName]['price_branch'] = Func::getNumberStr($child->values['price'], true, 2, true);
            }

            $fromAt = strtotime($child->values['from_at']);
            if($dateStart == null || $dateStart < $fromAt){
                $dateStart = $fromAt;
            }
        }
        uasort($products, function ($x, $y) {
            if($x['order'] == $y['order']){
                return strcasecmp($x['name'], $y['name']);
            }
            if($x['order'] > $y['order']){
                return 1;
            }
            return -1;
        });

        $params = Request_RequestParams::setParams(
            array(
                'shop_product_rubric_id' => $shopProductRubricID,
            )
        );
        $ids = Request_Request::find(
            'DB_Ab1_Shop_Delivery', $sitePageData->shopMainID, $sitePageData, $driver, $params, 0, true
        );

        $list = array();
        foreach($ids->childs as $child){
            $child->values['options'] = json_decode($child->values['options'], true);
            $time = Arr::path($child->values['options'],'time', '');

            if(!key_exists($time, $list)){
                $list[$time] = $time;
            }
        }
        asort($list);

        $i = 1;
        $data = array();
        $times = array();
        $priceList = array(
            'date' => Helpers_DateTime::getDateTimeDayMonthRus(date('Y-m-d', $dateStart), true),
        );
        foreach ($list as $time){
            $times[$time] = 'time'.$i;
            $priceList['time'.$i] = $time;
            $data['time'.$i] = array(
                'price' => '',
                'unit' => '',
            );
            $i++;
        }


        $deliveries = array();
        foreach($ids->childs as $child){
            $distance = Arr::path($child->values['options'],'distance', '');
            $time = Arr::path($child->values['options'],'time', '');
            if(!key_exists($distance, $deliveries)){
                $deliveries[$distance] = array_merge($data, array('distance' => $distance));
            }

            $key = $times[$time];
            $deliveries[$distance][$key]['price'] = Func::getNumberStr($child->values['price'], true, 2, true);

            switch ($child->values['delivery_type_id']){
                case Model_Ab1_DeliveryType::DELIVERY_TYPE_KM:
                    $unit = 'км';
                    break;
                case Model_Ab1_DeliveryType::DELIVERY_TYPE_TREATY:
                    $unit = 'рейс';
                    break;
                case Model_Ab1_DeliveryType::DELIVERY_TYPE_WEIGHT:
                    $unit = 'тонну';
                    break;
                case Model_Ab1_DeliveryType::DELIVERY_TYPE_WEIGHT_AND_KM:
                    $unit = 'тн/км';
                    break;
                default:
                    $unit = '';
            }
            $deliveries[$distance][$key]['unit'] = $unit;
        }

        return array(
            'products' => $products,
            'deliveries' => $deliveries,
            'price_list' => $priceList,
        );
    }

    /**
     * Возвращаем строчку привязки в договоре / в прайс листе определяем по подходящей цене
     * @param int $shopClientID
     * @param int $shopClientContractID
     * @param int $shopProductID
     * @param float $price
     * @param string $date
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @return bool|array('price' => 0, 'shop_client_contract_item_id' => 0, 'shop_product_price_id' => 0, 'shop_product_price_id' => 0,)
     * @throws HTTP_Exception_500
     */
    public static function getDiscountItemByPrice(int $shopClientID, int $shopClientContractID, int $shopProductID,
                                                  float $price, $date, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        // получаем цену за заданный период
        $modelPrice = Api_Ab1_Shop_Product_Time_Price::getProductTimePrice(
            $shopProductID, $date, $sitePageData, $driver
        );
        if($modelPrice === null || $modelPrice->getPrice() == 0) {
            $model = new Model_Ab1_Shop_Product();
            $model->setDBDriver($driver);
            if (!Helpers_DB::getDBObject($model, $shopProductID, $sitePageData, 0)) {
                throw new HTTP_Exception_500('Product id="'.$shopProductID.'" not found.');
            }

            $productPrice = $model->getPrice();
            $shopProductTimePriceID = 0;
        }else{
            $productPrice = $modelPrice->getPrice();
            $shopProductTimePriceID = $modelPrice->id;
        }

        if($price == $productPrice){
            return false;
        }

        // получаем цену по договору
        $price = self::getContractItemByPrice($shopClientContractID, $price, $shopProductID, $productPrice, $sitePageData, $driver);
        if($price !== FALSE){
            $price['shop_product_price_id'] = 0;
            $price['shop_product_time_price_id'] = $shopProductTimePriceID;
            return $price;
        }

        // получаем цену по прайс-листу
        $price = self::getPriceListItemByPrice($shopClientID, $price, $shopProductID, $productPrice, $sitePageData, $driver, $date);
        if($price !== FALSE){
            $price['shop_client_contract_item_id'] = 0;
            $price['shop_product_time_price_id'] = $shopProductTimePriceID;
            return $price;
        }

        // возвращаем цену по базовой цене
        return false;
    }

    /**
     * Возвращаем строчку привязки в договоре определяем по подходящей цене
     * @param int $shopClientContractID
     * @param float $price
     * @param int $shopProductID
     * @param float | int $productPrice
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @return bool | array('price' => 0, 'shop_client_contract_item_id' => 0)
     */
    public static function getContractItemByPrice(int $shopClientContractID, float $price, $shopProductID,
                                                  $productPrice, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        if($shopProductID < 1 || $shopClientContractID < 1){
            return FALSE;
        }

        $params = Request_RequestParams::setParams(
            array(
                'basic_or_contract' => $shopClientContractID,
                'product_shop_branch_id' => [0, $sitePageData->shopID],
                'is_fixed_price' => TRUE,
            )
        );
        $shopContractItemIDs = Request_Request::find('DB_Ab1_Shop_Client_Contract_Item',
            $sitePageData->shopMainID, $sitePageData, $driver, $params, 0, TRUE
        );

        $priceObject = FALSE;
        foreach ($shopContractItemIDs->childs as $child){
            if(($child->values['price'] == 0) && ($child->values['discount'] == 0)){
                continue;
            }

            // если задана скидка на все товары
            if(($child->values['shop_product_id'] == 0) && ($child->values['shop_product_rubric_id'] == 0)){
                if($child->values['discount'] == 0){
                    continue;
                }

                $tmp = $productPrice - $child->values['discount'];
                $priceObject = array(
                    'price' => $tmp,
                    'shop_client_contract_item_id' => $child->id,
                );
                // если задана скидка на товар
            }elseif($child->values['shop_product_id'] > 0) {
                if ($child->values['shop_product_id'] != $shopProductID) {
                    continue;
                }

                if ($child->values['discount'] != 0) {
                    $tmp = $productPrice - $child->values['discount'];
                }else {
                    $tmp = $child->values['price'];
                }

                $priceObject = array(
                    'price' => $tmp,
                    'shop_client_contract_item_id' => $child->id,
                );
                // если задана скидка на рубрику товаров
            }elseif($child->values['shop_product_rubric_id'] > 0) {
                $productIDs = self::findAllByMainRubric(
                    $child->values['shop_product_rubric_id'], $sitePageData, $driver
                );
                if (empty($productIDs)) {
                    continue;
                }

                foreach ($productIDs as $productID) {
                    if ($productID != $shopProductID) {
                        continue;
                    }

                    if ($child->values['discount'] != 0) {
                        $tmp = $productPrice - $child->values['discount'];
                    }else {
                        $tmp = $productPrice;
                    }

                    $priceObject = array(
                        'price' => $tmp,
                        'shop_client_contract_item_id' => $child->id,
                    );
                }
            }

            if($price == $priceObject['price']){
                return $priceObject;
            }
        }

        return false;
    }

    /**
     * Возвращаем строчку привязки в прайс листе определяем по подходящей цене
     * @param int $shopClientID
     * @param float $price
     * @param int $shopProductID
     * @param float | int $productPrice
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @param null $date
     * @return bool | array('price' => 0, 'shop_product_price_id' => 0)
     * @throws HTTP_Exception_500
     */
    public static function getPriceListItemByPrice(int $shopClientID, float $price, $shopProductID, $productPrice,
                                               SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver,
                                               $date = NULL)
    {
        if(empty($date)){
            $date = date('Y-m-d');
        }

        $params = Request_RequestParams::setParams(
            array(
                'shop_client_id' => $shopClientID,
                'product_shop_branch_id' => [0, $sitePageData->shopID],
                'from_at_to' => $date,
                'to_at_from' => $date,
            )
        );
        $shopProductIDs = Request_Request::find('DB_Ab1_Shop_Product_Price',
            $sitePageData->shopMainID, $sitePageData, $driver, $params, 0, TRUE
        );

        $priceObject = FALSE;
        foreach ($shopProductIDs->childs as $child){
            if(($child->values['price'] == 0) && ($child->values['discount'] == 0)){
                continue;
            }

            // если задана скидка на все товары
            if(($child->values['shop_product_id'] == 0) && ($child->values['shop_product_rubric_id'] == 0)){
                if($child->values['discount'] == 0){
                    continue;
                }

                $tmp = $productPrice - $child->values['discount'];
                $priceObject = array(
                    'price' => $tmp,
                    'shop_product_price_id' => $child->id,
                );
                // если задана скидка на товар
            }elseif($child->values['shop_product_id'] > 0) {
                if ($child->values['shop_product_id'] != $shopProductID) {
                    continue;
                }

                if ($child->values['price'] > 0) {
                    $tmp = $child->values['price'];
                }else {
                    $tmp = $productPrice - $child->values['discount'];
                }

                $priceObject = array(
                    'price' => $tmp,
                    'shop_product_price_id' => $child->id,
                );
                // если задана скидка на рубрику товаров
            }elseif($child->values['shop_product_rubric_id'] > 0) {
                $productIDs = self::findAllByMainRubric(
                    $child->values['shop_product_rubric_id'], $sitePageData, $driver
                );
                if (empty($productIDs)) {
                    continue;
                }

                foreach ($productIDs as $productID) {
                    if ($productID != $shopProductID) {
                        continue;
                    }

                    if ($child->values['price'] > 0) {
                        $tmp = $child->values['price'];
                    }else {
                        $tmp = $productPrice - $child->values['discount'];
                    }

                    $priceObject = array(
                        'price' => $tmp,
                        'shop_product_price_id' => $child->id,
                    );
                }
            }

            if($price == $priceObject['price']){
                return $priceObject;
            }
        }

        return false;
    }

    /**
     * Получаем массив ID продукции по рубрики (включая подрубрики)
     * @param $shopProductRubricID
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @return array|null
     * @throws HTTP_Exception_404
     */
    public static function findAllByMainRubric($shopProductRubricID, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        if (!is_array($shopProductRubricID) && $shopProductRubricID > 0) {
            $modelRubric = new Model_Ab1_Shop_Product_Rubric();
            $modelRubric->setDBDriver($driver);
            if (!Helpers_DB::getDBObject($modelRubric, $shopProductRubricID, $sitePageData, $sitePageData->shopMainID)) {
                throw new HTTP_Exception_404('Rubric not found.');
            }
        }elseif(!is_array($shopProductRubricID)){
            return NULL;
        }

        // считываем детвору
        $params = Request_RequestParams::setParams(
            array(
                'root_id' => $shopProductRubricID,
                'is_public_ignore' => true,
                'is_delete_ignore' => true,
                'sort_by' => array('name' => 'asc'),
            )
        );
        $shopProductRubricIDs = Request_Request::find('DB_Ab1_Shop_Product_Rubric',
            $sitePageData->shopMainID, $sitePageData, $driver, $params, 0, TRUE
        );
        $rubricIDs = $shopProductRubricIDs->getChildArrayID();

        if (is_array($shopProductRubricID)){
            $rubricIDs = array_merge($rubricIDs, $shopProductRubricID);
        }else {
            $rubricIDs[] = $shopProductRubricID;
        }

        $params = Request_RequestParams::setParams(
            array(
                'shop_product_rubric_id' => $rubricIDs,
                'is_public_ignore' => true,
                'is_delete_ignore' => true,
                'group' => 1,
            )
        );
        $shopProductIDs = Request_Request::findBranch('DB_Ab1_Shop_Product',
            array(), $sitePageData, $driver, $params, 0, TRUE
        )->getChildArrayID();

        if (count($shopProductIDs) == 0) {
            throw new HTTP_Exception_404('Products rubric "' . $shopProductRubricID . '" not found.');
        }
        return $shopProductIDs;
    }

    /**
     * Цена продукции по договору, если он есть, иначе возвращает FALSE
     * возвращаем минимальную возможную цену и строчку привязки к договоре
     * @param int $shopClientContractID
     * @param float $quantity
     * @param int $shopProductID
     * @param float | int $productPrice
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @param null $date
     * @return bool | array('price' => 0, 'shop_client_contract_item_id' => 0)
     */
    public static function getPriceOfContract(int $shopClientContractID, float $quantity, $shopProductID,
                                              $productPrice, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver,
                                              $date = NULL)
    {
        if($shopProductID < 1 || $shopClientContractID < 1){
            return FALSE;
        }

        if(empty($date)){
            $date = date('Y-m-d');
        }

        $params = Request_RequestParams::setParams(
            array(
                'basic_or_contract' => $shopClientContractID,
                'product_shop_branch_id' => [0, $sitePageData->shopID],
                'date' => $date,
                'is_fixed_price' => TRUE,
            )
        );
        $shopContractItemIDs = Request_Request::find('DB_Ab1_Shop_Client_Contract_Item',
            $sitePageData->shopMainID, $sitePageData, $driver, $params, 0, TRUE
        );

        $price = FALSE;
        foreach ($shopContractItemIDs->childs as $child){
            if(($child->values['price'] == 0) && ($child->values['discount'] == 0)){
                continue;
            }

            // если задана скидка на все товары
            if(($child->values['shop_product_id'] == 0) && ($child->values['shop_product_rubric_id'] == 0)){
                if($child->values['discount'] == 0){
                    continue;
                }

                $tmp = $productPrice - $child->values['discount'];
                // проверяем есть ли остаток неиспользованного баланса
                if(($child->values['balance_amount'] - $quantity * $tmp) <= -0.001){
                    continue;
                }

                if($price === FALSE || $price['price'] > $tmp){
                    $price = array(
                        'price' => $tmp,
                        'shop_client_contract_item_id' => $child->id,
                    );
                }
            // если задана скидка на товар
            }elseif($child->values['shop_product_id'] > 0) {
                if ($child->values['shop_product_id'] != $shopProductID) {
                    continue;
                }

                if ($child->values['discount'] != 0) {
                    $tmp = $productPrice - $child->values['discount'];
                }else {
                    $tmp = $child->values['price'];
                }

                // проверяем есть ли остаток неиспользованного баланса
                if(($child->values['balance_amount'] - $quantity * $tmp) <= -0.001){
                    continue;
                }

                if($price === FALSE || $price['price'] > $tmp){
                    $price = array(
                        'price' => $tmp,
                        'shop_client_contract_item_id' => $child->id,
                    );
                }
            // если задана скидка на рубрику товаров
            }elseif($child->values['shop_product_rubric_id'] > 0) {
                $productIDs = self::findAllByMainRubric(
                    $child->values['shop_product_rubric_id'], $sitePageData, $driver
                );
                if (empty($productIDs)) {
                    continue;
                }

                foreach ($productIDs as $productID) {
                    if ($productID != $shopProductID) {
                        continue;
                    }

                    if ($child->values['discount'] != 0) {
                        $tmp = $productPrice - $child->values['discount'];
                    }else {
                        $tmp = $productPrice;
                    }

                    // проверяем есть ли остаток неиспользованного баланса
                    if(($child->values['balance_amount'] - $quantity * $tmp) <= -0.001){
                        continue;
                    }

                    if($price === FALSE || $price['price'] > $tmp){
                        $price = array(
                            'price' => $tmp,
                            'shop_client_contract_item_id' => $child->id,
                        );
                    }
                }
            }
        }

        return $price;
    }

    /**
     * Цена продукции по прайсу, если он есть, иначе возвращает FALSE
     * возвращаем минимальную возможную цену
     * @param int $shopClientID
     * @param float $quantity
     * @param int $shopProductID
     * @param float | int $productPrice
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @param null $date
     * @return bool | array('price' => 0, 'shop_product_price_id' => 0)
     * @throws HTTP_Exception_500
     */
    public static function getPriceOfPriceList(int $shopClientID, float $quantity, $shopProductID, $productPrice,
                                               SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver,
                                               $date = NULL)
    {
        if(empty($date)){
            $date = date('Y-m-d');
        }

        $params = Request_RequestParams::setParams(
            array(
                'shop_client_id' => $shopClientID,
                'product_shop_branch_id' => [0, $sitePageData->shopID],
                'from_at_to' => $date,
                'to_at_from' => $date,
            )
        );
        $shopProductIDs = Request_Request::find('DB_Ab1_Shop_Product_Price',
            $sitePageData->shopMainID, $sitePageData, $driver, $params, 0, TRUE
        );

        $price = FALSE;
        foreach ($shopProductIDs->childs as $child){
            if(($child->values['price'] == 0) && ($child->values['discount'] == 0)){
                continue;
            }

            // если задана скидка на все товары
            if(($child->values['shop_product_id'] == 0) && ($child->values['shop_product_rubric_id'] == 0)){
                if($child->values['discount'] == 0){
                    continue;
                }

                $tmp = $productPrice - $child->values['discount'];
                // проверяем есть ли остаток неиспользованного баланса
                if($child->values['amount'] > 0 && ($child->values['balance_amount'] - $quantity * $tmp) <= -0.001){
                    continue;
                }

                if($price === FALSE || $price['price'] > $tmp){
                    $price = array(
                        'price' => $tmp,
                        'shop_product_price_id' => $child->id,
                    );
                }
                // если задана скидка на товар
            }elseif($child->values['shop_product_id'] > 0) {
                if ($child->values['shop_product_id'] != $shopProductID) {
                    continue;
                }

                if ($child->values['price'] != 0) {
                    $tmp = $child->values['price'];
                }else {
                    $tmp = $productPrice - $child->values['discount'];
                }

                // проверяем есть ли остаток неиспользованного баланса
                if($child->values['amount'] > 0 && ($child->values['balance_amount'] - abs($quantity * $tmp)) <= -0.001){
                    continue;
                }

                if($price === FALSE || $price['price'] > $tmp){
                    $price = array(
                        'price' => $tmp,
                        'shop_product_price_id' => $child->id,
                    );
                }
                // если задана скидка на рубрику товаров
            }elseif($child->values['shop_product_rubric_id'] > 0) {
                $productIDs = self::findAllByMainRubric(
                    $child->values['shop_product_rubric_id'], $sitePageData, $driver
                );
                if (empty($productIDs)) {
                    continue;
                }

                foreach ($productIDs as $productID) {
                    if ($productID != $shopProductID) {
                        continue;
                    }

                    if ($child->values['price'] > 0) {
                        $tmp = $child->values['price'];
                    }else {
                        $tmp = $productPrice - $child->values['discount'];
                    }

                    // проверяем есть ли остаток неиспользованного баланса
                    if($child->values['amount'] > 0 && ($child->values['balance_amount'] - abs($quantity * $tmp)) <= -0.001){
                        continue;
                    }

                    if($price === FALSE || $price['price'] > $tmp){
                        $price = array(
                            'price' => $tmp,
                            'shop_product_price_id' => $child->id,
                        );
                    }
                }
            }
        }

        return $price;
    }

    /**
     * Цена продукции по договору при новой оплате
     * возвращаем минимальную возможную цену
     * @param int $shopClientID
     * @param int $shopClientContractID
     * @param int $shopClientBalanceDayID
     * @param int $shopProductID
     * @param bool $isCharity
     * @param float $quantity
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @param bool $isDefaultProductPrice
     * @param null $date
     * @return bool|array(
    'price' => 0, 'shop_client_contract_item_id' => 0, 'shop_product_price_id' => 0,
    'shop_product_price_id' => 0, 'shop_client_balance_day_id' => 0,
    )
     * @throws HTTP_Exception_500
     */
    public static function getPriceNewPayment(int $shopClientID, int $shopClientContractID, int $shopClientBalanceDayID,
                                              int $shopProductID, bool $isCharity, float $quantity,
                                              SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver,
                                              bool $isDefaultProductPrice = TRUE, $date = NULL)
    {
        if($isCharity || $shopProductID < 1){
            return array(
                'price' => 0,
                'shop_client_contract_item_id' => 0,
                'shop_product_price_id' => 0,
                'shop_product_time_price_id' => 0,
                'shop_client_balance_day_id' => 0,
            );
        }

        if(!empty($date)){
            $date = Helpers_DateTime::getDateFormatPHP($date);
        }
        $datePrice = $date;

        // находим балланс предоплаты, который во
        if($shopClientBalanceDayID > 0){
            $modelBalanceDay = new Model_Ab1_Shop_Client_Balance_Day();
            $modelBalanceDay->setDBDriver($driver);
            if(Helpers_DB::getDBObject($modelBalanceDay, $shopClientBalanceDayID, $sitePageData, $sitePageData->shopMainID)
                && $modelBalanceDay->getShopClientID() == $shopClientID){
                $datePrice = $modelBalanceDay->getDate();
            }
            $shopClientBalanceDayID = 0;
        }

        if($shopClientBalanceDayID > 0){
            $modelBalanceDay = Api_Ab1_Shop_Client_Balance_Day::getClientBalanceDay(
                $shopClientID, $shopProductID, $quantity, $sitePageData, $driver
            );
            if($modelBalanceDay != null){
                $shopClientBalanceDayID = $modelBalanceDay->id;
                $datePrice = $modelBalanceDay->getDate();
            }
        }

        // получаем цену за заданный период
        $modelPrice = Api_Ab1_Shop_Product_Time_Price::getProductTimePrice(
            $shopProductID, $datePrice, $sitePageData, $driver
        );

        if($modelPrice === null || $modelPrice->getPrice() == 0) {
            $model = new Model_Ab1_Shop_Product();
            $model->setDBDriver($driver);
            if (!Helpers_DB::getDBObject($model, $shopProductID, $sitePageData)) {
                throw new HTTP_Exception_500('Product not found.');
            }

            $productPrice = $model->getPrice();
            $shopProductTimePriceID = 0;
        }else{
            $productPrice = $modelPrice->getPrice();
            $shopProductTimePriceID = $modelPrice->id;
        }

        // получаем цену по договору
        $price = self::getPriceOfContract($shopClientContractID, $quantity, $shopProductID, $productPrice, $sitePageData, $driver, $date);
        if($price !== FALSE){
            $price['shop_product_price_id'] = 0;
            $price['shop_product_time_price_id'] = $shopProductTimePriceID;
            $price['shop_client_balance_day_id'] = $shopClientBalanceDayID;
            return $price;
        }

        // получаем цену по прайс-листу
        $price = self::getPriceOfPriceList($shopClientID, $quantity, $shopProductID, $productPrice, $sitePageData, $driver, $date);
        if($price !== FALSE){
            $price['shop_client_contract_item_id'] = 0;
            $price['shop_product_time_price_id'] = $shopProductTimePriceID;
            $price['shop_client_balance_day_id'] = $shopClientBalanceDayID;
            return $price;
        }

        if(!$isDefaultProductPrice){
            return array(
                'price' => 0,
                'shop_client_contract_item_id' => 0,
                'shop_product_price_id' => 0,
                'shop_product_time_price_id' => 0,
                'shop_client_balance_day_id' => $shopClientBalanceDayID,
            );
        }

        // возвращаем цену по базовой цене
        return array(
            'price' => $productPrice,
            'shop_client_contract_item_id' => 0,
            'shop_product_price_id' => 0,
            'shop_product_time_price_id' => $shopProductTimePriceID,
            'shop_client_balance_day_id' => $shopClientBalanceDayID,
        );
    }

    /**
     * Цена продукции по договору / прайсу
     * возвращаем минимальную возможную цену
     * @param int $shopClientID
     * @param int $shopClientContractID
     * @param int $shopClientBalanceDayID
     * @param int $shopProductID
     * @param bool $isCharity
     * @param float $quantity
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @param bool $isDefaultProductPrice
     * @param null $date
     * @param bool $isNotDiscount
     * @return bool|array(
         'price' => 0, 'shop_client_contract_item_id' => 0, 'shop_product_price_id' => 0,
         'shop_product_price_id' => 0, 'shop_client_balance_day_id' => 0,
       )
     * @throws HTTP_Exception_500
     */
    public static function getPrice(int $shopClientID, int $shopClientContractID, int $shopClientBalanceDayID,
                                    int $shopProductID, bool $isCharity, float $quantity,
                                    SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver,
                                    bool $isDefaultProductPrice = TRUE, $date = NULL, $isNotDiscount = false)
    {
        if($isCharity || $shopProductID < 1){
            return array(
                'price' => 0,
                'shop_client_contract_item_id' => 0,
                'shop_product_price_id' => 0,
                'shop_product_time_price_id' => 0,
                'shop_client_balance_day_id' => 0,
            );
        }

        if(!empty($date)){
            $date = Helpers_DateTime::getDateFormatPHP($date);
        }
        $datePrice = $date;

        // находим балланс предоплаты, который во
        if($shopClientBalanceDayID > 0){
            $modelBalanceDay = new Model_Ab1_Shop_Client_Balance_Day();
            $modelBalanceDay->setDBDriver($driver);
            if(Helpers_DB::getDBObject($modelBalanceDay, $shopClientBalanceDayID, $sitePageData, $sitePageData->shopMainID)
                && $modelBalanceDay->getShopClientID() == $shopClientID){
                $datePrice = $modelBalanceDay->getDate();
            }
            $shopClientBalanceDayID = $modelBalanceDay->id;
        }

        // получаем цену за заданный период
        $modelPrice = Api_Ab1_Shop_Product_Time_Price::getProductTimePrice(
            $shopProductID, $datePrice, $sitePageData, $driver
        );

        if($modelPrice === null || $modelPrice->getPrice() == 0) {
            $model = new Model_Ab1_Shop_Product();
            $model->setDBDriver($driver);
            if (!Helpers_DB::getDBObject($model, $shopProductID, $sitePageData)) {
                throw new HTTP_Exception_500('Product not found.');
            }

            $productPrice = $model->getPrice();
            $shopProductTimePriceID = 0;
        }else{
            $productPrice = $modelPrice->getPrice();
            $shopProductTimePriceID = $modelPrice->id;
        }

        if($isNotDiscount){
            return array(
                'price' => $productPrice,
                'shop_client_contract_item_id' => 0,
                'shop_product_price_id' => 0,
                'shop_product_time_price_id' => $shopProductTimePriceID,
                'shop_client_balance_day_id' => $shopClientBalanceDayID,
            );
        }

        // получаем цену по договору
        $price = self::getPriceOfContract($shopClientContractID, $quantity, $shopProductID, $productPrice, $sitePageData, $driver, $date);
        if($price !== FALSE){
            $price['shop_product_price_id'] = 0;
            $price['shop_product_time_price_id'] = $shopProductTimePriceID;
            $price['shop_client_balance_day_id'] = $shopClientBalanceDayID;
            return $price;
        }

        // получаем цену по прайс-листу
        $price = self::getPriceOfPriceList($shopClientID, $quantity, $shopProductID, $productPrice, $sitePageData, $driver, $date);
        if($price !== FALSE){
            $price['shop_client_contract_item_id'] = 0;
            $price['shop_product_time_price_id'] = $shopProductTimePriceID;
            $price['shop_client_balance_day_id'] = $shopClientBalanceDayID;
            return $price;
        }

        if(!$isDefaultProductPrice){
            return array(
                'price' => 0,
                'shop_client_contract_item_id' => 0,
                'shop_product_price_id' => 0,
                'shop_product_time_price_id' => 0,
                'shop_client_balance_day_id' => $shopClientBalanceDayID,
            );
        }

        // возвращаем цену по базовой цене
        return array(
            'price' => $productPrice,
            'shop_client_contract_item_id' => 0,
            'shop_product_price_id' => 0,
            'shop_product_time_price_id' => $shopProductTimePriceID,
            'shop_client_balance_day_id' => $shopClientBalanceDayID,
        );
    }

    /**
     * удаление товара
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @return bool
     * @throws HTTP_Exception_500
     */
    public static function delete(SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        $id = Request_RequestParams::getParamInt('id');
        if($id < 0){
            return FALSE;
        }

        $model = new Model_Ab1_Shop_Product();
        $model->setDBDriver($driver);

        if (!Helpers_DB::dublicateObjectLanguage($model, $id, $sitePageData)) {
            throw new HTTP_Exception_500('Product not found.');
        }

        if(Request_RequestParams::getParamBoolean("is_undel") === TRUE){
            $model->dbUnDelete($sitePageData->userID, 0, $sitePageData->shopID);
        }else {
            $model->dbDelete($sitePageData->userID, 0, $sitePageData->shopID);
        }
    }


    /**
     * Сохранение товары
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @return array
     * @throws HTTP_Exception_500
     */
    public static function save(SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        $model = new Model_Ab1_Shop_Product();
        $model->setDBDriver($driver);

        $id = Request_RequestParams::getParamInt('id');
        if($id > 0) {
            if (!Helpers_DB::dublicateObjectLanguage($model, $id, $sitePageData)) {
                throw new HTTP_Exception_500('Product not found.');
            }
        }

        Request_RequestParams::setParamInt("shop_table_rubric_id", $model);
        Request_RequestParams::setParamInt("order", $model);
        Request_RequestParams::setParamBoolean('is_public', $model);
        Request_RequestParams::setParamStr('text', $model);
        Request_RequestParams::setParamStr('name', $model);
        Request_RequestParams::setParamStr("old_id", $model);
        Request_RequestParams::setParamInt("shop_table_select_id", $model);
        Request_RequestParams::setParamInt("shop_table_unit_id", $model);
        Request_RequestParams::setParamInt("shop_table_brand_id", $model);
        Request_RequestParams::setParamInt("shop_product_rubric_id", $model);
        Request_RequestParams::setParamInt("shop_product_group_id", $model);
        Request_RequestParams::setParamInt("product_type_id", $model);
        Request_RequestParams::setParamInt("product_view_id", $model);
        Request_RequestParams::setParamInt("shop_subdivision_id", $model);
        Request_RequestParams::setParamInt("shop_storage_id", $model);
        Request_RequestParams::setParamInt("shop_heap_id", $model);
        Request_RequestParams::setParamInt("shop_product_pricelist_rubric_id", $model);
        Request_RequestParams::setParamInt("shop_material_id", $model);

        Request_RequestParams::setParamStr('name_short', $model);
        Request_RequestParams::setParamStr('name_1c', $model);
        Request_RequestParams::setParamStr('name_site', $model);
        Request_RequestParams::setParamStr('name_recipe', $model);
        Request_RequestParams::setParamFloat('price', $model);
        Request_RequestParams::setParamStr('unit', $model);
        Request_RequestParams::setParamBoolean('is_packed', $model);
        Request_RequestParams::setParamFloat('tare', $model);
        Request_RequestParams::setParamFloat('volume', $model);
        Request_RequestParams::setParamFloat('coefficient_weight_quantity', $model);
        Request_RequestParams::setParamBoolean('is_pricelist', $model);

        // название
        if(empty($model->getName()) || empty($model->getNameSite()) || empty($model->getName1C())){
            if(!empty($model->getName())){
                $name = $model->getName();
            }elseif(!empty($model->getName1C())){
                $name = $model->getName1C();
            }elseif(!empty($model->getNameSite())){
                $name = $model->getNameSite();
            }else{
                $name = '';
            }

            if(empty($model->getName())){
                $model->setName($name);
            }
            if(empty($model->getNameSite())){
                $model->setNameSite($name);
            }
            if(empty($model->getName1C())){
                $model->setName1C($name);
            }
        }

        $options = Request_RequestParams::getParamArray('options');
        if ($options !== NULL) {
            $model->addOptionsArray($options);
        }

        $formulaTypeIDs = Request_RequestParams::getParamArray('formula_type_ids');
        if ($formulaTypeIDs !== NULL) {
            $model->setFormulaTypeIDsArray($formulaTypeIDs);
        }

        $result = array();
        if ($model->validationFields($result)) {
            if($model->id < 1) {
                Helpers_DB::saveDBObject($model, $sitePageData);
            }

            // загружаем фотографии
            $file = new Model_File($sitePageData);
            $file->saveFiles(Request_RequestParams::getParamArray('files'), $model, $sitePageData, $driver);

            Helpers_DB::saveDBObject($model, $sitePageData);
            $result['values'] = $model->getValues();
        }

        return array(
            'id' => $model->id,
            'result' => $result,
        );
    }

    /**
     * Загрузить товары из 1C XML
     * @param $fileName
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @param string $dateLoad
     * @throws HTTP_Exception_500
     */
    public static function loadXML($fileName, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver, $dateLoad = '')
    {
        $reader = new XMLReader();
        $reader->open($fileName);

        $model = new Model_Ab1_Shop_Product();
        $model->setDBDriver($driver);

        $modelOld = new Model_Ab1_Shop_Product();
        $modelOld->setDBDriver($driver);

        $shopIDs = Request_Request::findAllNotShop(
            'DB_Shop', $sitePageData, $driver, TRUE
        );
        $shopIDs->runIndex(true, 'old_id');

        if(empty($dateLoad)){
            $dateLoad = date('Y-m-d');
        }

        if(strtotime($dateLoad) < strtotime(date('Y-m-d'))){
            return;
        }

        $isProduct = FALSE;
        $shopID = 0;
        while ($reader->read()) {
            if ($reader->nodeType == XMLReader::ELEMENT) {
                switch($reader->localName){
                    case 'branch':
                        $reader->read();
                        if($reader->nodeType == XMLReader::TEXT) {
                            $shopID = trim($reader->value);
                            if(!key_exists($shopID, $shopIDs->childs)){
                                throw new HTTP_Exception_500('Branch "'.$shopID.'" not found.');
                            }

                            $shopID = $shopIDs->childs[$shopID]->id;
                        }
                        break;
                    case 'goods':
                        if(!empty($model->getName())) {
                            if($shopID < 1){
                                throw new HTTP_Exception_500('Branch not found.');
                            }

                            $ids = Request_Request::find('DB_Ab1_Shop_Product',
                                $shopID, $sitePageData, $driver,
                                array(
                                    'is_public_ignore' => true,
                                    'old_id' => $model->getOldID(),
                                    Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE
                                ),
                                1, TRUE
                            );

                            if(count($ids->childs) > 0){
                                $modelOld->clear();
                                $modelOld->__setArray(array('values' => $ids->childs[0]->values));

                                $modelOld->setName1C($model->getName());
                                $modelOld->setPrice($model->getPrice());
                                $modelOld->setUnit($model->getUnit());
                                Helpers_DB::saveDBObject($modelOld, $sitePageData, $shopID);

                                Api_Ab1_Shop_Product_Time_Price::addProductTimePrice(
                                    $modelOld->id, $modelOld->getPrice(), $dateLoad, $sitePageData, $driver, $shopID
                                );
                            }else {
                                $model->setName1C($model->getName());
                                $model->setNameSite($model->getName());
                                $model->setIsPublic($model->getPrice() > 0);
                                Helpers_DB::saveDBObject($model, $sitePageData, $shopID);

                                Api_Ab1_Shop_Product_Time_Price::addProductTimePrice(
                                    $model->id, $model->getPrice(), $dateLoad, $sitePageData, $driver, $shopID
                                );
                            }
                        }
                        $date = $dateLoad;
                        $model->clear();
                        break;
                    case 'code':
                        $reader->read();
                        if($reader->nodeType == XMLReader::TEXT) {
                            $model->setOldID($reader->value);
                        }
                        break;
                    case 'name':
                        $isProduct = TRUE;
                        $reader->read();
                        if($reader->nodeType == XMLReader::TEXT) {
                            $model->setName($reader->value);
                        }
                        break;
                    case 'unit':
                        $reader->read();
                        if($reader->nodeType == XMLReader::TEXT) {
                            $model->setUnit($reader->value);
                        }
                        break;
                    case 'price':
                        $reader->read();
                        if($reader->nodeType == XMLReader::TEXT) {
                            $model->setPrice($reader->value);
                        }
                        break;
                    case 'DateOfPrice':
                        $reader->read();
                        if($reader->nodeType == XMLReader::TEXT) {
                            $date = $reader->value;
                            if(strlen($date) == 8){
                                $date = substr($date, 0, 6).'20'.substr($date, 6);
                            }
                        }
                        break;
                }
            }
        }

        if($isProduct && (!empty($model->getName()))) {
            $ids = Request_Request::find(
                'DB_Ab1_Shop_Product',
                $shopID, $sitePageData, $driver,
                array(
                    'is_public_ignore' => true,
                    'old_id' => $model->getOldID(),
                    Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE
                ),
                1, TRUE
            );

            if(count($ids->childs) > 0){
                $modelOld->clear();
                $modelOld->__setArray(array('values' => $ids->childs[0]->values));

                $modelOld->setName1C($model->getName());
                $modelOld->setPrice($model->getPrice());
                $modelOld->setUnit($model->getUnit());
                Helpers_DB::saveDBObject($modelOld, $sitePageData, $shopID);
                $model->id = $modelOld->id;
            }else {
                Helpers_DB::saveDBObject($model, $sitePageData, $shopID);
            }

            Api_Ab1_Shop_Product_Time_Price::addProductTimePrice(
                $model->id, $model->getPrice(), $date, $sitePageData, $driver, $shopID
            );
        }

        $reader->close();
    }
}
