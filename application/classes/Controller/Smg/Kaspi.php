<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Smg_Kaspi extends Controller_Smg_BasicShop {
    const DIFF_PRICE = 25;
    const PERCENT = 11;
    const IS_MIN_1600 = true;
    const IS_DISABLE_DUMPING = false;

    public function __construct(Request $request, Response $response)
    {
        $this->actionURLName = 'market';
        $this->prefixView = 'market';

        parent::__construct($request, $response);
        $this->_sitePageData->actionURLName = 'market';

        $this->_sitePageData->shopShablonPath = 'smg/market';
        $this->_sitePageData->languageID = Model_Language::LANGUAGE_RUSSIAN;
    }

    /**
     * @param $priceCost
     * @param Model_AutoPart_Shop_Product $model
     * @param $shopCompanyID
     * @param bool $isDisableDumping
     * @param int $minMarkup
     * @param int $percent
     * @return float|int
     */
    public static function getPrice($priceCost, Model_AutoPart_Shop_Product $model, $shopCompanyID, $isDisableDumping = false,
                                    $minMarkup = 5000, $rubricMarkup = 0, $percent = 0){
        $diff = self::DIFF_PRICE;
        if($shopCompanyID == 3){
            $diff = 10;
        }

        if($percent <= 0) {
            $percent = self::PERCENT;
        }
        $percent += 1;

        if(self::IS_MIN_1600 && $priceCost <= 150000){
            if($shopCompanyID == 3){
                $minMarkup = 1500;
            }else {
                $minMarkup = 1600;
            }
        }
        $minMarkup += $rubricMarkup;

        $shopNames = Drivers_ParserSite_Kaspi::getConnectionOptions($shopCompanyID);
        $shopNames = $shopNames['my_companies'];

        $priceMin = round(($priceCost + $minMarkup) / 100 * (100 + ($percent / (100 - $percent) * 100)), -1);
        if($priceMin > $model->getPrice()){
            $result = $priceMin;
        }else{
            $result = $model->getPrice();
        }

        if($isDisableDumping && $model->getPrice() > $priceMin){
            $priceMin = $model->getPrice();
        }
        if($isDisableDumping){
            $result = $model->getPrice();
        }

        if($priceMin > $result){
            $result = $priceMin;
        }

        $sources = $model->getOptionsValue('sources');
        if(!is_array($sources)){
            return $result;
        }

        $offers = Arr::path($sources, 'kaspi.price_data.components.0.offers');
        if(!is_array($offers)){
            return $result;
        }

        if(count($offers) > 3){
            $offers[] = [
                'id' => 875003,
                'name' => '_LastCompany_',
                'unitSalePrice' => $priceMin + $diff,
            ];
        }

        if($isDisableDumping){
            $numberShop = 0;
            foreach ($offers as $offer){
                $price = Arr::path($offer, 'unitSalePrice', 0);
                if($price < 0.001){
                    continue;
                }

                $shop = Arr::path($offer, 'name');
                if(empty($shop) || key_exists($shop, $shopNames)){
                    continue;
                }
                $numberShop++;
            }

            if($numberShop < 1) {
                if (self::IS_MIN_1600) {
                    // Если мы единственные продавцы товара на каспи, то накручиваем 30%, но не более 100000
                    $tmp = $priceCost * 0.3;
                    if ($tmp > 100000) {
                        $tmp = 100000;
                    }

                    $result = round(($priceCost + $tmp) / 100 * (100 + ($percent / (100 - $percent) * 100)), -1);

                    if ($result > 1500000) {
                        $result = 1500000;
                    }
                } else {
                    if ($priceCost < 100000) {
                        // Если мы единственные продавцы товара на каспи: На товары с закупочной стоимостью от 1 до 99 999 тг  ставим накрутку 100% + актуальный %каспи от ррц (5% или 11%).
                        $result = round(($priceCost * 2) / 100 * (100 + ($percent / (100 - $percent) * 100)), -1);
                    } else {
                        // На товары с закупочной стоимостью от 100 000 тг и выше ставим накрутку 100 000 тг + актуал. % каспи от ррц(5% или 11%)
                        $result = round(($priceCost + 100000) / 100 * (100 + ($percent / (100 - $percent) * 100)), -1);
                    }
                }
            }else {
                foreach ($offers as $offer) {
                    $price = Arr::path($offer, 'unitSalePrice', 0);
                    if ($price < 0.001) {
                        continue;
                    }

                    $shop = Arr::path($offer, 'name');
                    if (empty($shop) || key_exists($shop, $shopNames)) {
                        continue;
                    }

                    if ($price - $diff > $result) {
                        $result = $price - $diff;
                    }

                    break;
                }
            }

            // чтобы цена не была в несколько раз больше
            if(self::IS_MIN_1600 && $result > $priceMin * 1.6){
                $result = round($priceMin * 1.6);
            }

            if($priceMin > $result){
                $result = $priceMin;
            }

            return $result;
        }

        $numberShop = 0;
        foreach ($offers as $offer){
            $price = Arr::path($offer, 'unitSalePrice', 0);
            if($price < 0.001){
                continue;
            }

            $shop = Arr::path($offer, 'name');
            if(empty($shop) || key_exists($shop, $shopNames)){
                continue;
            }
            $numberShop++;

            if($price - $diff >= $priceMin){
                $result = $price - $diff;
                break;
            }
        }

        if($numberShop < 1){
            if(self::IS_MIN_1600){
                // Если мы единственные продавцы товара на каспи, то накручиваем 30%, но не более 100000
                $tmp = $priceCost * 0.4;
                if($tmp > 100000){
                    $tmp = 100000;
                }

                $result = round(($priceCost + $tmp) / 100 * (100 + ($percent / (100 - $percent) * 100)), -1);

                if($result > 1500000){
                    $result = 1500000;
                }

                // чтобы цена не была в несколько раз больше
                if($result > $priceMin * 1.6){
                    $result = round($priceMin * 1.6);
                }
            }else {
                if ($priceCost < 100000) {
                    // Если мы единственные продавцы товара на каспи: На товары с закупочной стоимостью от 1 до 99 999 тг  ставим накрутку 100% + актуальный %каспи от ррц (5% или 11%).
                    $result = round(($priceCost * 2) / 100 * (100 + ($percent / (100 - $percent) * 100)), -1);
                } else {
                    // На товары с закупочной стоимостью от 100 000 тг и выше ставим накрутку 100 000 тг + актуал. % каспи от ррц(5% или 11%)
                    $result = round(($priceCost + 100000) / 100 * (100 + ($percent / (100 - $percent) * 100)), -1);
                }
            }
        }

        // чтобы цена не была в несколько раз больше
        if(self::IS_MIN_1600 && $result > $priceMin * 1.6){
            $result = round($priceMin * 1.6);
        }

        if($priceMin > $result){
            $result = $priceMin;
        }

        return $result;
    }

    /**
     * @param $priceCost
     * @param Model_AutoPart_Shop_Product $model
     * @param $shopCompanyID
     * @param bool $isDisableDumping
     * @param int $minMarkup
     * @param int $percent
     * @return float|int
     */
    public static function getPriceOne($priceCost, Model_AutoPart_Shop_Product $model, $shopCompanyID, $isDisableDumping = false,
                                       $minMarkup = 5000, $rubricMarkup = 0, $percent = 0){
        $diff = self::DIFF_PRICE;
        if($shopCompanyID == 3){
            $diff = 10;
        }

        if($percent <= 0) {
            $percent = self::PERCENT;
        }
        $percent += 1;

        if(self::IS_MIN_1600 && $priceCost <= 150000){
            if($shopCompanyID == 3){
                $minMarkup = 1500;
            }else {
                $minMarkup = 1600;
            }
        }

        $minMarkup += $rubricMarkup;

        $shopNames = Drivers_ParserSite_Kaspi::getConnectionOptions($shopCompanyID);
        $shopNames = $shopNames['my_companies'];

        $priceMin = round(($priceCost + $minMarkup) / 100 * (100 + ($percent / (100 - $percent) * 100)), -1);
        if($priceMin > $model->getPrice()){
            $result = $priceMin;
        }else{
            $result = $model->getPrice();
        }
        if($isDisableDumping && $model->getPrice() > $priceMin){
            $priceMin = $model->getPrice();
        }
        if($isDisableDumping){
            $result = $model->getPrice();
        }

        if($priceMin > $result){
            $result = $priceMin;
        }

        $sources = $model->getOptionsValue('sources');
        if(!is_array($sources)){
            return $result;
        }

        $offers = Arr::path($sources, 'kaspi.price_data.components.0.offers');
        if(!is_array($offers)){
            return $result;
        }

        if(count($offers) > 3){
            $offers[] = [
                'id' => 875003,
                'name' => '_LastCompany_',
                'unitSalePrice' => $priceMin + $diff,
            ];
        }

        if($isDisableDumping){
            $numberShop = 0;
            foreach ($offers as $offer){
                $price = Arr::path($offer, 'unitSalePrice', 0);
                if($price < 0.001){
                    continue;
                }

                $shop = Arr::path($offer, 'name');
                if(empty($shop) || key_exists($shop, $shopNames)){
                    continue;
                }
                $numberShop++;
            }

            if($numberShop < 1) {
                if (self::IS_MIN_1600) {
                    // Если мы единственные продавцы товара на каспи, то накручиваем 30%, но не более 100000
                    $tmp = $priceCost * 0.4;
                    if ($tmp > 100000) {
                        $tmp = 100000;
                    }

                    $result = round(($priceCost + $tmp) / 100 * (100 + ($percent / (100 - $percent) * 100)), -1);

                    if ($result > 1500000) {
                        $result = 1500000;
                    }
                } else {
                    if ($priceCost < 100000) {
                        // Если мы единственные продавцы товара на каспи: На товары с закупочной стоимостью от 1 до 99 999 тг  ставим накрутку 100% + актуальный %каспи от ррц (5% или 11%).
                        $result = round(($priceCost * 2) / 100 * (100 + ($percent / (100 - $percent) * 100)), -1);
                    } else {
                        // На товары с закупочной стоимостью от 100 000 тг и выше ставим накрутку 100 000 тг + актуал. % каспи от ррц(5% или 11%)
                        $result = round(($priceCost + 100000) / 100 * (100 + ($percent / (100 - $percent) * 100)), -1);
                    }
                }
            }else {
                foreach ($offers as $offer) {
                    $price = Arr::path($offer, 'unitSalePrice', 0);
                    if ($price < 0.001) {
                        continue;
                    }

                    $shop = Arr::path($offer, 'name');
                    if (empty($shop) || key_exists($shop, $shopNames)) {
                        continue;
                    }

                    if ($price - $diff > $result) {
                        $result = $price - $diff;
                    }

                    break;
                }
            }

            // чтобы цена не была в несколько раз больше
            if(self::IS_MIN_1600 && $result > $priceMin * 1.6){
                $result = round($priceMin * 1.6);
            }

            if($priceMin > $result){
                $result = $priceMin;
            }

            return $result;
        }

        $numberShop = 0;
        foreach ($offers as $offer){
            $price = Arr::path($offer, 'unitSalePrice', 0);
            if($price < 0.001){
                continue;
            }

            $shop = Arr::path($offer, 'name');
            if(empty($shop) || key_exists($shop, $shopNames)){
                continue;
            }
            $numberShop++;

            if($price - $diff >= $priceMin){
                $result = $price - $diff;
                break;
            }
        }

        if($numberShop < 1){
            if(self::IS_MIN_1600){
                // Если мы единственные продавцы товара на каспи, то накручиваем 30%, но не более 100000
                $tmp = $priceCost * 0.4;
                if($tmp > 100000){
                    $tmp = 100000;
                }

                $result = round(($priceCost + $tmp) / 100 * (100 + ($percent / (100 - $percent) * 100)), -1);

                if($result > 1500000){
                    $result = 1500000;
                }

                // чтобы цена не была в несколько раз больше
                if($result > $priceMin * 1.6){
                    $result = round($priceMin * 1.6);
                }
            }else {
                if ($priceCost < 100000) {
                    // Если мы единственные продавцы товара на каспи: На товары с закупочной стоимостью от 1 до 99 999 тг  ставим накрутку 100% + актуальный %каспи от ррц (5% или 11%).
                    $result = round(($priceCost * 2) / 100 * (100 + ($percent / (100 - $percent) * 100)), -1);
                } else {
                    // На товары с закупочной стоимостью от 100 000 тг и выше ставим накрутку 100 000 тг + актуал. % каспи от ррц(5% или 11%)
                    $result = round(($priceCost + 100000) / 100 * (100 + ($percent / (100 - $percent) * 100)), -1);
                }
            }
        }

        // чтобы цена не была в несколько раз больше
        if(self::IS_MIN_1600 && $result > $priceMin * 1.6){
            $result = round($priceMin * 1.6);
        }

        if($priceMin > $result){
            $result = $priceMin;
        }

        return $result;
    }

    /**
     * Получаем номер позиции в цене и количество предложений
     * @param $price
     * @param Model_AutoPart_Shop_Product $model
     * @param $shopCompanyID
     * @return array
     */
    public static function getPriceNumber($price, Model_AutoPart_Shop_Product $model, $shopCompanyID){
        $sources = $model->getOptionsValue('sources');
        if(!is_array($sources)){
            return [
                'number' => 1,
                'count' => 0,
            ];
        }

        $offers = Arr::path($sources, 'kaspi.price_data.components.0.offers');
        if(!is_array($offers)){
            return [
                'number' => 1,
                'count' => 0,
            ];
        }

        $shopNames = Drivers_ParserSite_Kaspi::getConnectionOptions($shopCompanyID);
        $shopName = $shopNames['company'];

        $number = 1;
        foreach ($offers as $offer){
            $priceSale = Arr::path($offer, 'unitSalePrice', 0);
            if($priceSale < 0.001){
                continue;
            }

            $shop = Arr::path($offer, 'name');
            if(empty($shop) || $shop == $shopName){
                continue;
            }

            if($priceSale > $price){
                break;
            }

            $number++;
        }

        return [
            'number' => $number,
            'count' => count($offers),
        ];
    }

    /**
     * Считаем цену товара
     * @param $shopSourceID
     * @param $shopCompanyID
     * @param $companyIsDumping
     * @param MyArray $child
     * @param Model_AutoPart_Shop_Product $model
     * @param array $bindIDs
     * @return array
     */
    function _calcPrice($shopSourceID, $shopCompanyID, $companyIsDumping, MyArray $child, Model_AutoPart_Shop_Product $model,
                        array $bindIDs){
        if($child->getElementValue('shop_rubric_source_id', 'is_sale', 0) == 0){
            $commission = $child->getElementValue('shop_rubric_source_id', 'commission', 0);
        }else{
            $commission = $child->getElementValue('shop_rubric_source_id', 'commission_sale', 0);
        }
        $rubricMarkup = floatval($child->getElementValue('shop_rubric_source_id', 'markup', 0));

        $minMarkup = floatval($child->getElementValue('shop_supplier_id', 'min_markup', 5000));
        $isDisableDumpingSupplier = $child->getElementValue('shop_supplier_id', 'is_disable_dumping', false);

        $priceCost = $model->getPriceCost();
        if(key_exists($model->id, $bindIDs) && ($child->values['is_public'] == 0 || $child->values['is_in_stock'] == 0 || $priceCost > $bindIDs[$model->id]['price_cost'] || $priceCost == 0)){
            $priceCost = $bindIDs[$model->id]['price_cost'];
            $minMarkup = $bindIDs[$model->id]['min_markup'];
            $isDisableDumpingSupplier = $bindIDs[$model->id]['is_disable_dumping'];
            $isPublic = 1;
        }else{
            $isPublic = $child->values['is_public'] == 1 && $child->values['is_in_stock'] == 1;
        }

        if($priceCost == 0){
            $priceCost = $model->getPriceCost();
        }

        if($shopSourceID == 2){
            $commission = 15;
        }

        $isDisableDumping = $child->getElementValue('shop_brand_id', 'is_disable_dumping', false);
        if(self::IS_DISABLE_DUMPING || !$companyIsDumping){
            $isDisableDumping = $isDisableDumping || $isDisableDumpingSupplier;
        }

        if(($child->values['shop_supplier_id'] == 1827825 && $shopCompanyID != 3)){
            $isDisableDumping = true;
        }

        // отключить демпинг Технограда
        if($child->values['shop_supplier_id'] == 1554965){
            $isDisableDumping = true;
        }

        // отключить демпинг Элфорт
        if($child->values['shop_supplier_id'] == 1677387 && false){
            $isDisableDumping = true;
        }

        $price = self::getPrice(
            $priceCost, $model, $shopCompanyID, $isDisableDumping, $minMarkup, $rubricMarkup, floatval($commission)
        );

        if($priceCost == 0 || $priceCost < 1500){
            $isPublic = 0;
        }

        // принудительно уменьшаем количество товаров в Велесе
        if($shopSourceID == 1 && $shopCompanyID == 3 && $child->values['shop_supplier_id']  == 1570406){
            $isPublic = 0;
        }

        return [
            'commission' => $commission,
            'price' => $price,
            'is_public' => $isPublic,
        ];
    }

    /**
     * Считаем цену товара
     * @param $shopSourceID
     * @param $shopCompanyID
     * @param $companyIsDumping
     * @param MyArray $child
     * @param Model_AutoPart_Shop_Product $model
     * @param array $bindIDs
     * @return array
     */
    function _calcPriceOne($shopSourceID, $shopCompanyID, $companyIsDumping, MyArray $child, Model_AutoPart_Shop_Product $model,
                           array $bindIDs){
        if($child->getElementValue('shop_rubric_source_id', 'is_sale', 0) == 0){
            $commission = $child->getElementValue('shop_rubric_source_id', 'commission', 0);
        }else{
            $commission = $child->getElementValue('shop_rubric_source_id', 'commission_sale', 0);
        }
        $rubricMarkup = floatval($child->getElementValue('shop_rubric_source_id', 'markup', 0));

        $minMarkup = floatval($child->getElementValue('shop_supplier_id', 'min_markup', 5000));
        $isDisableDumpingSupplier = $child->getElementValue('shop_supplier_id', 'is_disable_dumping', false);

        $priceCost = $model->getPriceCost();
        if(key_exists($model->id, $bindIDs) && ($child->values['is_public'] == 0 || $child->values['is_in_stock'] == 0 || $priceCost > $bindIDs[$model->id]['price_cost'] || $priceCost == 0)){
            $priceCost = $bindIDs[$model->id]['price_cost'];
            $minMarkup = $bindIDs[$model->id]['min_markup'];
            $isDisableDumpingSupplier = $bindIDs[$model->id]['is_disable_dumping'];
            $isPublic = 1;
        }else{
            $isPublic = $child->values['is_public'] == 1 && $child->values['is_in_stock'] == 1;
        }

        if($priceCost == 0){
            $priceCost = $model->getPriceCost();
        }

        if($shopSourceID == 2){
            $commission = 15;
        }

        $isDisableDumping = $child->getElementValue('shop_brand_id', 'is_disable_dumping', false);
        if(self::IS_DISABLE_DUMPING || !$companyIsDumping){
            $isDisableDumping = $isDisableDumping || $isDisableDumpingSupplier;
        }

        if(($child->values['shop_supplier_id'] == 1827825 && $shopCompanyID != 3)){
            $isDisableDumping = true;
        }

        // отключить демпинг Технограда
        if($child->values['shop_supplier_id'] == 1554965){
            $isDisableDumping = true;
        }

        // отключить демпинг Элфорт
        if($child->values['shop_supplier_id'] == 1677387){
            $isDisableDumping = true;
        }
        $price = self::getPriceOne(
            $priceCost, $model, $shopCompanyID, $isDisableDumping, $minMarkup, $rubricMarkup, floatval($commission)
        );

        if($priceCost == 0 || $priceCost < 1500){
            $isPublic = 0;
        }

        // принудительно уменьшаем количество товаров в Велесе
        if($shopSourceID == 1 && $shopCompanyID == 3 && $child->values['shop_supplier_id']  == 1570406){
            $isPublic = 0;
        }

        return [
            'commission' => $commission,
            'price' => $price,
            'is_public' => $isPublic,
        ];
    }

    /*
     * Описание: https://kaspi.kz/merchantcabinet/support/display/CB/XML
     */
    public function action_price_list()
    {
        $this->_sitePageData->url = '/smg/kaspi/price_list';

        $shopCompanyID = Request_RequestParams::getParamInt('shop_company_id');

        $shopSourceID = Request_RequestParams::getParamInt('shop_source_id');
        if($shopSourceID < 1){
            throw new HTTP_Exception_500('Source not correct.');
        }

        $modelCompany = new Model_AutoPart_Shop_Company();
        $modelCompany->setDBDriver($this->_driverDB);
        if(!Helpers_DB::getDBObject($modelCompany, $shopCompanyID, $this->_sitePageData)){
            throw new HTTP_Exception_500('Company not found.');
        }

        // ищем связанные товары
        $bindIDs = Api_AutoPart_Shop_Product::getBindProducts($shopSourceID, $this->_sitePageData, $this->_driverDB);

        $ids = Request_Request::find(
            DB_AutoPart_Shop_Product::NAME, $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB,
            Request_RequestParams::setParams(
                [
                    'is_public_ignore' => true,
                    'shop_source_id' => $shopSourceID,
                    'root_shop_product_id' => 0,
                ]
            ),
            0, true,
            [
                'shop_brand_id' => array('name', 'is_disable_dumping'),
                'shop_supplier_id' => array('is_disable_dumping', 'min_markup'),
                'shop_rubric_source_id' => array('is_sale', 'commission', 'commission_sale', 'markup'),
            ]
        );

        $model = new Model_AutoPart_Shop_Product();
        $model->setDBDriver($this->_driverDB);

        foreach ($ids->childs as $keyChild => $child){
            $child->setModel($model);
            if($shopCompanyID == 3) {
                $source = Arr::path($model->getOptionsArray(), 'sources.kaspi', array());
                if (empty($source)) {
                    $child->values['is_public'] = 0;
                    continue;
                }
            }

            // считаем цену реализации
            $priceData = self::_calcPrice(
                $shopSourceID, $shopCompanyID, $modelCompany->getIsDumping(), $child, $model, $bindIDs
            );
            $child->values['price']  = $priceData['price'];
            $child->values['is_public']  = $priceData['is_public'];
        }

        $config = Drivers_ParserSite_Kaspi::getConnectionOptions($shopCompanyID);

        if($shopSourceID == 2){
            $fileName = Helpers_Path::getPathFile(DOCROOT, ['sources'], 'jmart_c' . $shopCompanyID . '.xml');
        }else {
            $fileName = Helpers_Path::getPathFile(DOCROOT, ['sources'], 'kaspi_c' . $shopCompanyID . '.xml');
        }
        if(file_exists($fileName)) {
            unlink($fileName);
        }

        $fh = fopen($fileName, 'w');

        $text = '<?xml version="1.0" encoding="utf-8"?>'
            . '<kaspi_catalog date="string" xmlns="kaspiShopping" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="kaspiShopping http://kaspi.kz/kaspishopping.xsd">'
            . '<company>' . htmlspecialchars($config['company'], ENT_XML1) . '</company>'
            . '<merchantid>' . htmlspecialchars($config['merchantid'], ENT_XML1) . '</merchantid>'
            . '<offers>';
        fwrite($fh, $text);

        foreach ($ids->childs as $child) {
            $text = '<offer sku="' . htmlspecialchars($child->values['article'], ENT_XML1) . '">'
                . '<model>' . htmlspecialchars(mb_substr(trim($child->values['name']), 0, 119), ENT_XML1) . '</model>'
                . '<brand>' . htmlspecialchars($child->getElementValue('shop_brand_id'), ENT_XML1) . '</brand>'
                . '<availabilities>'
                . '<availability available="';

            if ($child->values['is_public'] == 1) {
                $text .= 'yes';
            } else {
                $text .= 'no';
            }

            $text .= '" storeId="PP1"/>';

            if($shopSourceID == 2){
                $text .= '<availability available="no" storeId="PP3"/>';
            }

            $text .= '</availabilities>'
                . '<price>' . Func::getNumberStr($child->values['price'], false, 0) . '</price>'
                . '</offer>';

            fwrite($fh, $text);
        }

        $text = '</offers> </kaspi_catalog>';
        fwrite($fh, $text);
        fclose($fh);

        if($shopSourceID == 2){
            self::redirect('/sources/jmart_c' . $shopCompanyID . '.xml');
        }else {
            self::redirect('/sources/kaspi_c' . $shopCompanyID . '.xml');
        }
    }

    /*
     * Проверка цены одного товара
     */
    public function action_price_one()
    {
        $this->_sitePageData->url = '/smg/kaspi/price_one';

        $id = Request_RequestParams::getParamInt('id');

        $shopCompanyID = Request_RequestParams::getParamInt('shop_company_id');

        $shopSourceID = Request_RequestParams::getParamInt('shop_source_id');
        if($shopSourceID < 1){
            throw new HTTP_Exception_500('Source not correct.');
        }

        $modelCompany = new Model_AutoPart_Shop_Company();
        $modelCompany->setDBDriver($this->_driverDB);
        if(!Helpers_DB::getDBObject($modelCompany, $shopCompanyID, $this->_sitePageData)){
            throw new HTTP_Exception_500('Company not found.');
        }

        // ищем связанные товары
        $bindIDs = Api_AutoPart_Shop_Product::getBindProducts(
            $shopSourceID, $this->_sitePageData, $this->_driverDB, ['root_shop_product_id' => $id]
        );

        $ids = Request_Request::find(
            DB_AutoPart_Shop_Product::NAME, $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB,
            Request_RequestParams::setParams(
                [
                    'is_public_ignore' => true,
                    'shop_source_id' => $shopSourceID,
                    'root_shop_product_id' => 0,
                    'id' => $id,
                ]
            ),
            0, true,
            [
                'shop_brand_id' => array('name', 'is_disable_dumping'),
                'shop_supplier_id' => array('is_disable_dumping', 'min_markup'),
                'shop_rubric_source_id' => array('is_sale', 'commission', 'commission_sale', 'markup'),
            ]
        );

        $model = new Model_AutoPart_Shop_Product();
        $model->setDBDriver($this->_driverDB);

        foreach ($ids->childs as $child){
            $child->setModel($model);

            // считаем цену реализации
            $priceData = self::_calcPriceOne(
                $shopSourceID, $shopCompanyID, $modelCompany->getIsDumping(), $child, $model, $bindIDs
            );
            $child->values['price']  = $priceData['price'];
            $child->values['is_public']  = $priceData['is_public'];
        }

        $config = Drivers_ParserSite_Kaspi::getConnectionOptions($shopCompanyID);

        $length = 0;
        $text = '<?xml version="1.0" encoding="utf-8"?>'
            . '<kaspi_catalog date="string" xmlns="kaspiShopping" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="kaspiShopping http://kaspi.kz/kaspishopping.xsd">'
            . '<company>' . htmlspecialchars($config['company'], ENT_XML1) . '</company>'
            . '<merchantid>' . htmlspecialchars($config['merchantid'], ENT_XML1) . '</merchantid>'
            . '<offers>';

        $length += strlen($text);
        echo $text;
        foreach ($ids->childs as $child) {
            $text = '<offer sku="' . htmlspecialchars($child->values['article'], ENT_XML1) . '">'
                . '<model>' . htmlspecialchars(mb_substr(trim($child->values['name']), 0, 119), ENT_XML1) . '</model>'
                . '<brand>' . htmlspecialchars($child->getElementValue('shop_brand_id'), ENT_XML1) . '</brand>'
                . '<availabilities>'
                . '<availability available="';

            if ($child->values['is_public'] == 1) {
                $text .= 'yes';
            } else {
                $text .= 'no';
            }

            $text .= '" storeId="PP1"/>';

            if($shopSourceID == 2){
                $text .= '<availability available="no" storeId="PP3"/>';
            }

            $text .= '</availabilities>'
                . '<price>' . Func::getNumberStr($child->values['price'], false, 0) . '</price>'
                . '</offer>';

            $length += strlen($text);
            echo $text;
        }

        $text = '</offers> </kaspi_catalog>';

        $length += strlen($text);
        echo $text;

        $this->response->headers('Content-Type', 'application/xml');
        $this->response->headers('Last-Modified', gmdate('D, d M Y H:i:s').' GMT');
        $this->response->headers('Content-Length', $length);

        //$this->response->body($text);
    }

    /**
     * Обновление рубрик из kaspi.kz
     * Список рубрик находится по адресу
     * https://kaspi.kz/merchantcabinet/#/products/import
     * Получаем по адресу
     * https://kaspi.kz/merchantcabinet/api/category/tree
     */
    public function action_load_rubrics(){
        $this->_sitePageData->url = '/smg/kaspi/load_rubrics';
        $this->_sitePageData->shopID = Request_RequestParams::getParamInt('shop_branch_id');

        $shopCompanyID = Request_RequestParams::getParamInt('shop_company_id');

        $shopSourceID = Request_RequestParams::getParamInt('shop_source_id');
        if($shopSourceID < 1){
            throw new HTTP_Exception_500('Source not correct.');
        }

        $options = [];
        $cs = Drivers_ParserSite_Kaspi::authMerchantСabinet($shopCompanyID, $options);

        $options[CURLOPT_HTTPHEADER] = array('Content-type: application/json; charset=utf-8');
        $options[CURLOPT_URL] = 'https://kaspi.kz/merchantcabinet/api/category/tree';

        curl_setopt_array($cs, $options);
        $rubrics = curl_exec($cs);

        $rubrics = json_decode($rubrics, true);
        if(!is_array($rubrics) || !key_exists(0, $rubrics) || !key_exists('subCategories', $rubrics[0])){
            throw new HTTP_Exception_500('Data https://kaspi.kz/merchantcabinet/api/category/tree not correct.');
        }
        $rubrics = $rubrics[0]['subCategories'];

        // ************** Обновляем рубрики **************//
        // список рубрик kaspi.kz
        $shopProductRubricIDs = Request_Request::find(
            DB_AutoPart_Shop_Rubric_Source::NAME, $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB,
            Request_RequestParams::setParams(), 0, true
        );
        $shopProductRubricIDs->runIndex(true, 'old_id');

        $model = new Model_AutoPart_Shop_Rubric_Source();
        $model->setDBDriver($this->_driverDB);

        // обновляем список рубрик kaspi.kz
        $addRubrics = function ($shopSourceID, $rootID, array $rubrics, MyArray $shopProductRubricIDs,
                                Model_AutoPart_Shop_Rubric_Source $model, $addRubrics) {
            foreach ($rubrics as $rubric) {
                $code = $rubric['code'];

                if(!key_exists($code, $shopProductRubricIDs->childs)){
                    $model->clear();
                    $model->setOldID($rubric['code']);
                    $model->setShopSourceID($shopSourceID);
                }else{
                    $shopProductRubricIDs->childs[$code]->setModel($model);
                    unset($shopProductRubricIDs->childs[$code]);
                }

                $model->setRootID($rootID);
                $model->setIsLast(empty($rubric['subCategories']));
                $model->setName($rubric['name']);
                Helpers_DB::saveDBObject($model, $this->_sitePageData);

                if(!$model->getIsLast()){
                    $addRubrics($shopSourceID, $model->id, $rubric['subCategories'], $shopProductRubricIDs, $model, $addRubrics);
                }

            }
        };

        $addRubrics($shopSourceID, 0, $rubrics, $shopProductRubricIDs, $model, $addRubrics);

        $this->_driverDB->deleteObjectIDs(
            $shopProductRubricIDs->getChildArrayID(), $this->_sitePageData->userID, Model_AutoPart_Shop_Rubric_Source::TABLE_NAME,
            array(), $this->_sitePageData->shopID
        );

        self::redirect('/market/shoprubricsource/index' . URL::query());
    }

    /**
     * Считываем цены у товаров, которые распознаны, в несколько потоков
     * Параметры URL
     * step - шаг (какое максимальное количество товаро должен обрабатывать один поток)
     */
    public function action_get_price_streams() {
        $this->_sitePageData->url = '/smg/kaspi/get_price_streams';

        $shopSourceID = Request_RequestParams::getParamInt('shop_source_id');
        if($shopSourceID < 1){
            throw new HTTP_Exception_500('Source not found.');
        }

        $count = Request_Request::findOne(
            DB_AutoPart_Shop_Product::NAME, $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB,
            Request_RequestParams::setParams(
                [
                    'count_id' => true,
                    //'is_public_ignore' => true,
                ],
                false
            )
        );
        if($count == null){
            $count = 0;
        }else{
            $count = $count->values['count'];
        }

        // размер шага
        $step = Request_RequestParams::getParamInt('step');
        if($step < 2){
            $step = $count;
        }

        $count = ceil($count / $step);
        $list = [];
        for ($i = 1; $i <= $count; $i++) {
            $list[$i] = $i;
        }
        shuffle($list);

        foreach ($list as $i){
            $url = $this->_sitePageData->urlBasic . '/smg/kaspi/get_price'
                . URL::query(
                    [
                        'step' => $count,
                        'step_current' => $i,
                        'sort_by' => ['updated_at' => 'asc'],
                    ]
                );
            $result = Helpers_URL::getDataURLEmulationBrowser($url, 1);

            echo 'Запущен поток №' . $i . ' url: ' . $url . '<br>' . "\r\n";

            if (!empty($result)) {
                echo $result . '<br>';
            }
        }

        echo 'Конец';
    }

    /**
     * Считываем цены у товаров, которые распознаны
     * Параметры URL
     * step - шаг (если нужно обрабатывать в несколько потоков)
     * step_current - позиция шага
     */
    public function action_get_price() {
        $this->_sitePageData->url = '/smg/kaspi/get_price';
        $microtime = microtime(true);

        set_time_limit(3600000);
        ini_set("max_execution_time", "3600000");

        $shopSourceID = Request_RequestParams::getParamInt('shop_source_id');
        if($shopSourceID < 1){
            throw new HTTP_Exception_500('Source not found.');
        }

        // размер шага
        $step = Request_RequestParams::getParamInt('step');
        if($step < 1){
            $step = 1;
        }

        // позиция в шаге
        $stepCurrent = Request_RequestParams::getParamInt('step_current');
        if($stepCurrent < 1){
            $stepCurrent = 1;
        }elseif($stepCurrent > $step){
            $stepCurrent = $step;
        }
        $stepCurrent--;

        // ищем связанные товары
        $bindIDs = Api_AutoPart_Shop_Product::getBindProducts(
            $shopSourceID, $this->_sitePageData, $this->_driverDB,
            ['root_shop_product_id_modulo' => ['divisor' => $step, 'result' => $stepCurrent]]
        );

        $params = Request_RequestParams::getParamArray('sort_by');
        if(empty($params)) {
            if ($step == 1) {
                $params = ['sort_by' => ['updated_at' => 'asc']];
            } else {
                $params = ['sort_by' => ['created_at' => 'asc']];
            }
        }
        $params['id_modulo'] = ['divisor' => $step, 'result' => $stepCurrent];
        $params['shop_source_id'] = $shopSourceID;
        $params['root_shop_product_id'] = 0;
        //$params['is_public_ignore'] = true;

        $shopProductIDs = Request_Request::find(
            DB_AutoPart_Shop_Product::NAME, $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB,
            Request_RequestParams::setParams($params, false), 0, true,
            [
                'shop_brand_id' => array('is_disable_dumping'),
                'shop_supplier_id' => array('is_disable_dumping', 'min_markup'),
                'shop_rubric_source_id' => array('is_sale', 'commission', 'commission_sale', 'markup'),
            ]
        );

        $shopCompanyIDs = Request_Request::findAll(
            DB_AutoPart_Shop_Company::NAME, $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB
        );

        $proxies = include Helpers_Path::getFilesProxies();
        $user = $proxies['user'];
        $password = $proxies['password'];
        $urlEditIP = $proxies['edit_ip'];
        $proxies = $proxies['proxies'];

        $cookies = [];
        foreach ($proxies as $proxy){
            $cookies[$proxy] = '';
        }

        $getPrice = function ($shopSourceID, Model_AutoPart_Shop_Product $modelProduct,
                              Model_AutoPart_Shop_Product_Source $modelSource,
                              SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver,
                              $url, $getPrice, &$i, &$proxies, &$cookies, &$n, $user, $password, $logFile, $urlEditIP){
            $i += random_int(1, 3);
            $proxy = $proxies[$i % count($proxies)];
            try {
                $prices = Drivers_ParserSite_Kaspi::getProductPricesUpdateData(
                    $shopSourceID, $modelProduct, $modelSource, $sitePageData, $driver, $url, $cookies[$proxy], $proxy, $user, $password, $urlEditIP
                );
            }catch (Drivers_ParserSite_Kaspi_Exception $e){
                $n++;
                if($n > count($proxies)){
                    Helpers_File::saveInLogs($logFile, 'Ни один прокси не работает. :(', ['kaspi']);
                    throw new HTTP_Exception_500('Ни один прокси не работает. :(');
                }

                $prices = $getPrice(
                    $shopSourceID, $modelProduct, $modelSource, $sitePageData, $driver,
                    $url, $getPrice, $i, $proxies, $cookies, $n, $user, $password, $logFile, $urlEditIP
                );
            }catch (HTTP_Exception_500 $e){
                $n++;
                if($n > count($proxies)){
                    Helpers_File::saveInLogs($logFile, 'Ни один прокси не работает. :(', ['kaspi']);

                    throw new HTTP_Exception_500('Ни один прокси не работает. :(');
                }

                $prices = $getPrice(
                    $shopSourceID, $modelProduct, $modelSource, $sitePageData, $driver,
                    $url, $getPrice, $i, $proxies, $cookies, $n, $user, $password, $logFile, $urlEditIP
                );
            }

            return $prices;
        };

        $model = new Model_AutoPart_Shop_Product();
        $model->setDBDriver($this->_driverDB);

        Helpers_File::saveInLogs('step_'.$stepCurrent.'.txt', 'Начало: шаг ' . $step . ' кол-во '. count($shopProductIDs->childs), ['kaspi']);

        $i = random_int(1, 3);
        foreach ($shopProductIDs->childs as $child){
            $child->setModel($model);

            Helpers_File::saveInLogs('step_'.$stepCurrent.'.txt', 'В работе: ' . ' id '. $model->id . ' url '. $model->getOptionsValue('sources.kaspi.url'), ['kaspi']);

            $url = $model->getOptionsValue('sources.kaspi.url');
            if(empty($url)){
                continue;
            }

            $options = $model->getOptionsValue('sources');

            $date = Arr::path($options, 'kaspi.prices.update');
            $update = date('Y-m-d H:i:s');
            if($date != null && Helpers_DateTime::diffMinutes($update, $date) < 1){
                continue;
            }

            $modelSourceProduct = Request_Request::findOneModel(
                DB_AutoPart_Shop_Product_Source::NAME, $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB,
                Request_RequestParams::setParams(
                    [
                        'shop_source_id' => $shopSourceID,
                        'shop_product_id' => $child->id,
                    ]
                )
            );
            if($modelSourceProduct == false) {
                $modelSourceProduct = new Model_AutoPart_Shop_Product_Source();
            }

            $n = 0;
            $prices = $getPrice(
                $shopSourceID, $model, $modelSourceProduct, $this->_sitePageData, $this->_driverDB,
                $url, $getPrice, $i, $proxies, $cookies, $n, $user, $password, 'step_'.$stepCurrent.'.txt', $urlEditIP
            );
            if($prices === false){
                continue;
            }

            // удаляем лишные значения
            unset($prices['endpoint']);
            foreach ($prices['components'] as $k => $v){
                unset($prices['components'][$k]['hideMap']);
                unset($prices['components'][$k]['limit']);
                unset($prices['components'][$k]['total']);
                unset($prices['components'][$k]['offersEndpoint']);
                unset($prices['components'][$k]['sort']);
                unset($prices['components'][$k]['loanPeriodSelector']);
                unset($prices['components'][$k]['t']);

                foreach ($prices['components'][$k]['offers'] as $k1 => $v1){
                    unset($prices['components'][$k]['offers'][$k1]['reviewsLink']);
                    unset($prices['components'][$k]['offers'][$k1]['cartStatus']);
                    unset($prices['components'][$k]['offers'][$k1]['deliveryOptions']);
                    unset($prices['components'][$k]['offers'][$k1]['monthlyInstallments']);
                    unset($prices['components'][$k]['offers'][$k1]['promo']);
                    unset($prices['components'][$k]['offers'][$k1]['superExpress']);
                    unset($prices['components'][$k]['offers'][$k1]['kaspiDelivery']);
                }
            }

            $options['kaspi']['price_data'] = $prices;

            $options['kaspi']['prices'] = [
                'max' => Arr::path($prices, 'maxPrice'),
                'min' => Arr::path($prices, 'minPrice'),
                'update' => $update,
            ];
            $model->setOptionsValue('sources', $options);

            Helpers_DB::saveDBObject($model, $this->_sitePageData);

            $priceCost = $model->getPriceCost();
            if(key_exists($model->id, $bindIDs) && ($priceCost > $bindIDs[$model->id]['price_cost'] || $priceCost == 0)){
                $priceCost = $bindIDs[$model->id]['price_cost'];
            }

            if($modelSourceProduct->id > 0){
                $modelSource = $modelSourceProduct;
            }else {

                /** @var Model_AutoPart_Shop_Product_Source $modelSource */
                $modelSource = Request_Request::findOneModel(
                    DB_AutoPart_Shop_Product_Source::NAME, $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB,
                    Request_RequestParams::setParams(
                        [
                            'shop_source_id' => $shopSourceID,
                            'shop_product_id' => $child->id,
                        ]
                    )
                );
                if ($modelSource == false) {
                    $modelSource = $modelSourceProduct;
                } else {
                    $modelSource->setShopRubricSourceID($modelSourceProduct->getShopRubricSourceID());
                    $modelSource->setPriceSource($modelSourceProduct->getPriceSource());
                    if (Func::_empty($modelSource->getName())) {
                        $modelSource->setName($modelSourceProduct->getName());
                    }
                }
            }

            $modelSource->setPriceCost($priceCost);

            $modelSource->setPriceMin($options['kaspi']['prices']['min']);
            $modelSource->setPriceMax($options['kaspi']['prices']['max']);
            $modelSource->setOptionsValue('source', $options);

            Helpers_DB::saveDBObject($modelSource, $this->_sitePageData, $model->shopID);

            // сохраняем новые цены реализации
            foreach ($shopCompanyIDs->childs as $company){
                // считаем цену реализации
                $priceData = self::_calcPrice(
                    $shopSourceID, $company->id, $company->values['is_dumping'] == 1, $child, $model, $bindIDs
                );
                $child->values['price']  = $priceData['price'];
                $child->values['is_public']  = $priceData['is_public'];

                $position = self::getPriceNumber($priceData['price'], $model, $company->id);

                Api_AutoPart_Shop_Product_Source_Price::savePrices(
                    $company->id, $priceData['commission'], $priceData['price'],
                    $position['number'], $position['count'],
                    $modelSource, $this->_sitePageData, $this->_driverDB
                );
            }
        }

        Helpers_File::saveInLogs('step_'.$stepCurrent.'.txt', 'Конец ' . Helpers_DateTime::secondToTime((microtime(true) - $microtime)), ['kaspi']);
        echo 'Конец ' . Helpers_DateTime::secondToTime((microtime(true) - $microtime));
    }

    /**
     * Считываем с Каспи распознанные продукции
     */
    public function action_check_product(){
        $this->_sitePageData->url = '/smg/kaspi/check_product';

        $shopCompanyID = Request_RequestParams::getParamInt('shop_company_id');

        $shopSourceID = Request_RequestParams::getParamInt('shop_source_id');
        if($shopSourceID < 1){
            throw new HTTP_Exception_500('Source not found.');
        }

        $optionsURL = array();
        $cs = Drivers_ParserSite_Kaspi::authMerchantСabinet($shopCompanyID, $optionsURL);

        // ************** Получаем количетво записей **************//
        $params = array(
            'searchTerm' => null,
            'offerStatus' => Request_RequestParams::getParamStr('status'),
            'categoryCode' => null,
            'cityId' => null,
            'start' => 0,
            'count' => 1,
        );

        $paramsStr = json_encode($params);

        $optionsURL[CURLOPT_POST] = TRUE;
        $optionsURL[CURLOPT_URL] = 'https://kaspi.kz/merchantcabinet/api/offer';
        $optionsURL[CURLOPT_HTTPHEADER] = array('Content-type: application/json; charset=utf-8');
        $optionsURL[CURLOPT_POSTFIELDS] = $paramsStr;
        curl_setopt_array($cs, $optionsURL);
        $result = curl_exec($cs);

        $result = json_decode($result, true);
        $count = intval(Arr::path($result, 'totalCount', 0));

        // ************** Получаем все записи **************//
        $offers = [];
        $step = 500;
        $params['count'] = $step;
        for ($i = 0; $i < ceil($count / $step); $i++){
            $params['start'] = $i * $step;
            $paramsStr = json_encode($params);

            $optionsURL[CURLOPT_POSTFIELDS] = $paramsStr;
            curl_setopt_array($cs, $optionsURL);
            $result = curl_exec($cs);

            $list = Arr::path(json_decode($result, true), 'offers', array());
            foreach ($list as $offer){
                // удаляем лишные значения
                unset($offer['thumbnailUrl']);
                unset($offer['productUrl']);
                unset($offer['actualPrice']);
                unset($offer['localizedActualPrice']);
                unset($offer['expireDate']);
                unset($offer['offerStatus']);
                unset($offer['cityInfo']);
                unset($offer['avgProcessingTime']);
                unset($offer['description']);
                unset($offer['category']);
                unset($offer['nextGen']);
                unset($offer['entryId']);

                unset($offer['masterProduct']['priceMin']);
                unset($offer['masterProduct']['priceMax']);
                unset($offer['masterProduct']['actualPrice']);
                unset($offer['masterProduct']['priceMin']);
                unset($offer['masterProduct']['localizedActualPrice']);
                unset($offer['masterProduct']['quantity']);
                unset($offer['masterProduct']['expireDate']);
                unset($offer['masterProduct']['offerStatus']);
                unset($offer['masterProduct']['masterProduct']);
                unset($offer['masterProduct']['cityInfo']);
                unset($offer['masterProduct']['avgProcessingTime']);
                unset($offer['masterProduct']['description']);
                unset($offer['masterProduct']['category']);
                unset($offer['masterProduct']['nextGen']);
                unset($offer['masterProduct']['entryId']);

                $offers[$offer['sku']] = $offer;
            }
        }

        // ************** Делаем сопоставление **************//
        $shopProductIDs = Request_Request::find(
            DB_AutoPart_Shop_Product::NAME, $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB,
            Request_RequestParams::setParams(['is_delete_public_ignore' => true]), 0, true
        );

        $shopProductSourceIDs = Request_Request::find(
            DB_AutoPart_Shop_Product_Source::NAME, $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB,
            Request_RequestParams::setParams(['shop_source_id' => $shopSourceID]), 0, true
        );
        $shopProductSourceIDs->runIndex(true, 'shop_product_id');

        $model = new Model_AutoPart_Shop_Product();
        $model->setDBDriver($this->_driverDB);

        $modelSource = new Model_AutoPart_Shop_Product_Source();
        $modelSource->setDBDriver($this->_driverDB);

        foreach ($shopProductIDs->childs as $child){
            $child->setModel($model);

            $article = $model->getArticle();
            if(!key_exists($article, $offers)){
                /*$options = $model->getOptionsArray();
                if(key_exists('sources', $options) && key_exists('kaspi', $options['sources'])) {
                    unset($options['sources']['kaspi']);
                    $model->setOptionsArray($options);

                    Helpers_DB::saveDBObject($model, $this->_sitePageData, $model->shopID);

                    if (key_exists($model->id, $shopProductSourceIDs->childs)) {
                        $shopProductSourceIDs->childs[$child->id]->setModel($modelSource);
                        $modelSource->dbDelete($this->_sitePageData->userID);
                    }
                }*/
                continue;
            }

            $options = $model->getOptionsArray();
            $options['sources']['kaspi']['data'] = $offers[$article];
            $options['sources']['kaspi']['url'] = $offers[$article]['masterProduct']['productUrl'];
            $options['sources']['kaspi']['image'] = 'https://kaspi.kz' . $offers[$article]['masterProduct']['primaryImage']['large'];
            $model->setOptionsArray($options);

            Helpers_DB::saveDBObject($model, $this->_sitePageData);

            if(key_exists($model->id, $shopProductSourceIDs->childs)){
                $shopProductSourceIDs->childs[$child->id]->setModel($modelSource);
            }else{
                $modelSource->clear();
                $modelSource->setShopSourceID($shopSourceID);
                $modelSource->setShopProductID($model->id);
            }

            $modelSource->setPriceCost($model->getPriceCost());
            $modelSource->setProfit($modelSource->getPrice() - $model->getPriceCost() - round($modelSource->getPrice() / 100 * self::PERCENT));

            $modelSource->setURL($options['sources']['kaspi']['url']);
            $modelSource->setImageURL($options['sources']['kaspi']['image']);

            $url = $modelSource->getURL();
            $sourceSiteID = str_replace('/', '', substr($url, strrpos($url, '-') + 1));
            $modelSource->setSourceSiteID($sourceSiteID);

            Helpers_DB::saveDBObject($modelSource, $this->_sitePageData, $model->shopID);
        }

        // получаем данные из сайта (характеристики, название и т.д.)
       // Drivers_ParserSite_Kaspi::loadProducts($shopSourceID, $this->_sitePageData, $this->_driverDB);

        self::redirect('/market/shopproduct/index');
    }

    /**
     * Обновляем процент комиссии в рубриках
     */
    public function action_update_rubric_percent(){
        $this->_sitePageData->url = '/smg/kaspi/update_rubric_percent';

        $shopSourceID = Request_RequestParams::getParamInt('shop_source_id');
        if($shopSourceID < 1){
            throw new HTTP_Exception_500('Source not found.');
        }

        $rubrics = Drivers_ParserSite_Kaspi::getRubricPercent();

        $params = [
            'shop_source_id_from' => 0,
            'shop_source_id' => $shopSourceID,
            'is_tree' => true,
        ];

        $shopRubricSources = Request_Request::find(
            DB_AutoPart_Shop_Rubric_Source::NAME, $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB,
            Request_RequestParams::setParams($params), 0, true
        );

        $setCommission = function (array $rubrics, MyArray $shopRubricSources, Model_AutoPart_Shop_Rubric_Source $model,
                                   $setCommission, array &$rubricsNotFind){
            foreach ($rubrics as $rubricName => $child){
                $shopRubricSource = $shopRubricSources->findChildValue('name', $rubricName, false);

                if($shopRubricSource === false){
                    $shopRubricSource = $shopRubricSources->findChildValue('name', $rubricName);

                    // некокретно указаны окончальные рубрики и рубрики с процентами (Каспи косячит)
                    if($shopRubricSource === false) {
                        $new = '';
                        switch ($rubricName) {
                            case 'Бальзамы для волос': $new = 'Бальзамы и кондиционеры для волос'; break;
                            case 'Инструментальные столики': $new = 'Столики инструментальные'; break;
                            case 'Ароматерапия и эфирные масла': $new = 'Масла и эфирные масла'; break;
                            case 'Средства для снятия макияжа': $new = 'Средства для очищения и снятия макияжа'; break;
                            case 'Кремы': $new = 'Кремы и сыворотки'; break;
                            case 'Моющие средства для мебели и ковров': $new = 'Моющие средства для мебели, ковров и напольных покрытий'; break;
                            case 'Мини-инструменты для обработки почвы': $new = 'Инструменты для обработки почвы'; break;
                            case 'Настольные лампы': $new = 'Настольные и напольные лампы'; break;
                            case 'Уход за одеждой и обувью': $new = 'Хозяйственные товары'; break;
                            case 'Наборы посуды': $new = 'Наборы посуды для готовки'; break;
                            case 'Уход за одеждой и бельем': $new = 'Хозяйственные товары'; break;
                            case 'Кухонные аксессуары': $new = 'Посуда и принадлежности'; break;
                            case 'Освещение и электрика': $new = 'Розетки и выключатели'; break;
                            case 'Отдых и пикник': $new = 'Пикник, барбекю, гриль'; break;
                            case 'Тренажеры и фитнес': $new = 'Спорт, туризм'; break;
                            case 'Спортивная одежда': $new = 'Спортивная одежда и обувь'; break;
                            case 'Товары для рыб и рептилий': $new = 'Для рыб и рептилий'; break;
                            case 'Товары для кошек': $new = 'Для кошек'; break;
                            case 'Товары для грызунов': $new = 'Для грызунов'; break;
                            case 'Кухонные приборы': $new = 'Техника для кухни'; break;
                            case 'Крупы, мука, макароны': $new = 'Продукты питания'; break;
                            case 'Уход за ребенком': $new = 'Для малыша и мамы'; break;
                            case 'Оснастка для инструмента': $new = 'Строительное оборудование'; break;
                            case 'Двери': $new = 'Двери и окна'; break;
                            case 'Мужская одежда': $new = 'Мужчинам'; break;
                            case 'Одежда для мальчиков': $new = 'Мальчикам'; break;
                            case 'Одежда для девочек': $new = 'Девочкам'; break;
                            case 'Женская одежда': $new = 'Женщинам'; break;
                            case 'Товары для собак': $new = 'Товары для животных'; break;
                            case 'Товары для птиц': $new = 'Для птиц'; break;
                            case 'Кондитерские изделия': $new = 'Сладости'; break;
                            case 'Чипсы, орехи, сухофрукты': $new = 'Чипсы, орехи, снэки'; break;
                            case 'Прогулки и поездки': $new = 'Прогулки, поездки, активный отдых'; break;
                            case 'Детский активный отдых': $new = 'Прогулки, поездки, активный отдых'; break;
                            case 'Фитнес': $new = 'Фитнес и йога'; break;
                            case 'Товары для охоты': $new = 'Товары для охоты и стрельбы'; break;
                            case 'Путешествия': $new = 'Багаж'; break;
                            case 'Лекарственные средства': $new = 'Лекарства'; break;
                            case 'Товары для домашнего скота': $new = 'Для сельскохозяйственных животных'; break;
                            case 'Гигиена и уход для животных': $new = 'Гигиена и уход за животными'; break;
                            case 'Овощи и фрукты': $new = 'Овощи, фрукты, ягоды, грибы'; break;
                            case 'Специи и соусы': $new = 'Масла, специи, соусы'; break;
                            case 'Средства по уходу за больными': $new = 'Медицинские изделия и расходные материалы'; break;
                            case 'Средства и предметы гигиены': $new = 'Гигиена'; break;
                            case 'Системы отопления': $new = 'Системы отопления и вентиляции'; break;
                            case 'Оснастка для пневмоинструмента': $new = 'Пневмоинструменты'; break;
                            case 'Освещение и электрик': $new = 'Электрика'; break;
                            case 'Товары для праздников': $new = 'Подарки, товары для праздников'; break;
                            case 'Белье и домашняя одежда для девочек': $new = 'Домашняя одежда для девочек'; break;
                            case 'Белье и домашняя одежда для мальчиков': $new = 'Домашняя одежда для мальчиков'; break;
                            case 'Выпечка и сладости': $new = 'Сладости'; break;
                            case 'Пиво, сидр': $new = 'Пиво'; break;
                            case 'Кефир': $new = 'Кефир, Тан, Айран'; break;
                            case 'Сливки': $new = 'Молоко, Сухое молоко, Сливки'; break;
                            case 'Молоко': $new = 'Молоко, Сухое молоко, Сливки'; break;
                            case 'Овощи, фрукты и грибы': $new = 'Овощи, фрукты, ягоды, грибы'; break;
                            case 'Мясо, птица': $new = 'Колбасы, сосиски, деликатесы'; break;
                            case 'Сетевые фильтры и удлинители': $new = 'Сетевые фильтры'; break;
                            case 'Чистящие средства для сантехники': $new = 'Чистящие средства для сантехники, кафеля и труб'; break;
                            case 'Грузовые шины': $new = 'Шины для грузового транспорта'; break;
                            case 'МФУ': $new = 'Принтеры и МФУ'; break;
                            case 'Жесткие диски': $new = 'Жесткие диски и твердотельные накопители'; break;
                            case 'Беспроводные зарядки': $new = 'Зарядные устройства'; break;
                            case 'Цифровые книги, аудиокниги и видеокурсы': $new = 'Книги, аудиокниги и видеокурсы на цифровых носителях'; break;
                            case 'Утюги и гладильные системы': $new = 'Утюги'; break;
                            case 'Кабели и переходники': $new = 'Кабели и переходники для смартфонов'; break;
                            case 'Аксессуары для кухонных приборов': $new = 'Аксессуары для кухонной техники'; break;
                            case 'Аксессуары для колясок и автокресел': $new = 'Аксессуары для колясок'; break;
                            /*case '': $new = ''; break;*/
                        }
                        if (!empty($new)) {
                            $shopRubricSource = $shopRubricSources->findChildValue('name', $new);
                        }

                        if($shopRubricSource === false){
                            $rubricsNotFind[$rubricName] = $child;
                            continue;
                        }
                    }
                }

                if(is_array($child)){
                    $setCommission($child, $shopRubricSource, $model, $setCommission, $rubricsNotFind);
                    continue;
                }

                $shopRubricSource->getModel($model);
                $model->setCommission($child);
                Helpers_DB::saveDBObject($model, $this->_sitePageData);

                $shopRubricSource->values['commission'] = $child;
            }
        };

        $model =  new Model_AutoPart_Shop_Rubric_Source();
        $model->setDBDriver($this->_driverDB);

        $rubricsNotFind = [];
        $setCommission($rubrics, $shopRubricSources, $model, $setCommission, $rubricsNotFind);

        $rubrics = $rubricsNotFind;
        $rubricsNotFind = [];
        $setCommission($rubrics, $shopRubricSources, $model, $setCommission, $rubricsNotFind);

        $setRoot = function (MyArray $shopRubricSources, Model_AutoPart_Shop_Rubric_Source $model, $setRoot){
            if(count($shopRubricSources->childs) == 0){
                return $shopRubricSources->values['commission'];
            }

            $percents = [];
            foreach ($shopRubricSources->childs as $child){
                $percent = $setRoot($child, $model, $setRoot);
                Helpers_Array::plusValue($percents, $percent, 1);
            }

            // находим максимальное количество повторяющихся процентов для родителя
            $percentMain = 0;
            $countMain = 0;
            foreach ($percents as $percent => $count){
                if($countMain < $count || ($countMain == $count && $percentMain < $percent)){
                    $percentMain = $percent;
                    $countMain = $count;
                }
            }

            if($shopRubricSources->id < 1){
                return $percentMain;
            }

            $shopRubricSources->getModel($model);
            $model->setOriginalValue('commission', -1);
            $model->setCommission($percentMain);
            Helpers_DB::saveDBObject($model, $this->_sitePageData);

            return $percentMain;
        };
        $setRoot($shopRubricSources, $model, $setRoot);

       /* $rubrics = $rubricsNotFind;
        $rubricsNotFind = [];
        $setCommission($rubrics, $shopRubricSources, $model, $setCommission, $rubricsNotFind);*/

        echo '<pre>';
        print_r($rubricsNotFind);
    }

    /**
     * Считываем с Каспи заказы
     */
    public function action_check_bills(){
        $this->_sitePageData->url = '/smg/kaspi/check_bills';
        $this->_sitePageData->shopID = Request_RequestParams::getParamInt('shop_branch_id');

        $shopSourceID = Request_RequestParams::getParamInt('shop_source_id');

        $ids = Request_Request::find(
            DB_AutoPart_Shop_Company::NAME, $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB,
            Request_RequestParams::setParams(['sort_by' => ['id' => 'asc']]), 0, true
        );

        foreach ($ids->childs as $child){
            // ограничеваем Опто перенаправляем на Лучшего партнера
            if($child->id == 1){
                continue;
            }

            Drivers_ParserSite_Kaspi_Bill::loadBills($child->id, $shopSourceID, $this->_sitePageData, $this->_driverDB);
        }

        $url = Request_RequestParams::getParamStr('url');
        if($url === null){
            $url = '/market/shopbill/index';
        }

        if(!empty($url)) {
            self::redirect($url);
        }
    }

    /**
     * Отправляем СМС клиенту для подтвержения заказа
     * @throws HTTP_Exception_500
     */
    public function action_send_sms_bill(){
        $this->_sitePageData->url = '/smg/kaspi/send_sms_bill';
        $this->_sitePageData->shopID = Request_RequestParams::getParamInt('shop_branch_id');

        $shopBillID = Request_RequestParams::getParamInt('shop_bill_id');

        $result = Drivers_ParserSite_Kaspi_Bill::sendSMSBill($shopBillID, $this->_sitePageData, $this->_driverDB);
        $this->response->body(json_encode(['status' => $result]));
    }

    /**
     * Отправляем СМС клиенту для подтвержения заказа
     * @throws HTTP_Exception_500
     */
    public function action_complete_bill(){
        $this->_sitePageData->url = '/smg/kaspi/complete_bill';
        $this->_sitePageData->shopID = Request_RequestParams::getParamInt('shop_branch_id');

        $shopBillID = Request_RequestParams::getParamInt('shop_bill_id');
        $secretCode = Request_RequestParams::getParamInt('secret_code');

        $result = Drivers_ParserSite_Kaspi_Bill::completedBill($shopBillID, $secretCode, $this->_sitePageData, $this->_driverDB);
        $this->response->body(json_encode(['status' => $result]));
    }

    /**
     * Получаем товары для распознования
     * https://kaspi.kz/merchantcabinet/api/product/search/sku
     */
    public function action_search_sku(){
        $this->_sitePageData->url = '/smg/kaspi/search_sku';
        $this->_sitePageData->shopID = Request_RequestParams::getParamInt('shop_branch_id');

        $shopCompanyID = Request_RequestParams::getParamInt('shop_company_id');
        if($shopCompanyID == 1){
            $shopCompanyID = 2;
        }

        $article = Request_RequestParams::getParamStr('article');
        if(empty($article)){
            throw new HTTP_Exception_500('Article not correct.');
        }

        $curl = Drivers_ParserSite_Kaspi::authMerchantСabinetV2($shopCompanyID);
        $curl->setHeader('Content-type', 'application/json; charset=utf-8');

        $params = array(
            'categoryCode' => null,
            'categoryFilter' => null,
            'query' => $article,
        );
        $curl->post('https://kaspi.kz/merchantcabinet/api/product/search/sku', json_encode($params));

        $this->response->body($curl->getRawResponse());
    }

    /**
     * Получаем товары для распознования
     * https://kaspi.kz/merchantcabinet/api/product/search/name
     */
    public function action_search_name(){
        $this->_sitePageData->url = '/smg/kaspi/search_name';
        $this->_sitePageData->shopID = Request_RequestParams::getParamInt('shop_branch_id');

        $shopCompanyID = Request_RequestParams::getParamInt('shop_company_id');

        $name = Request_RequestParams::getParamStr('name');
        if(empty($name)){
            throw new HTTP_Exception_500('Name not correct.');
        }

        $curl = Drivers_ParserSite_Kaspi::authMerchantСabinetV2($shopCompanyID);
        $curl->setHeader('Content-type', 'application/json; charset=utf-8');

        $params = array(
            'categoryCode' => null,
            'categoryFilter' => null,
            'query' => $name,
        );
        $curl->post('https://kaspi.kz/merchantcabinet/api/product/search/name', json_encode($params));

        $this->response->body($curl->getRawResponse());
    }

    /**
     * Добавление связи
     * проверка связи
     * https://kaspi.kz/merchantcabinet/api/offer/check/master/12700082
     */
    public function action_set_map_product(){
        $this->_sitePageData->url = '/smg/kaspi/set_map_product';
        $this->_sitePageData->shopID = Request_RequestParams::getParamInt('shop_branch_id');

        $this->_readUserInterface();

        $shopCompanyID = Request_RequestParams::getParamInt('shop_company_id');

        $article = Request_RequestParams::getParamStr('article');
        if(empty($article)){
            throw new HTTP_Exception_500('Article not correct.');
        }

        $sku = Request_RequestParams::getParamStr('sku');
        if(empty($sku)){
            throw new HTTP_Exception_500('SKU not correct.');
        }

        $curl = Drivers_ParserSite_Kaspi::authMerchantСabinetV2($shopCompanyID);
        $curl->setHeader('Content-type', 'application/json; charset=utf-8');
        $curl->post('https://kaspi.kz/merchantcabinet/api/offer/check/master/' . $sku);
        $json = $curl->getRawResponse();

        if(empty($json)){
            throw new HTTP_Exception_500('Kaspi error check.');
        }

        $json = json_decode($json, true);

        if($json['totalCount'] > 0 && $json['offers'][0]['sku'] != $article){
            $curl->get(
                $this->_sitePageData->urlBasic . '/market/shopproduct/set_child_product'
                . URL::query(['article1' => $json['offers'][0]['sku'], 'article2' => $article, 'is_auth' => true], false)
            );
        }else{
            // каспи добавление связи
            $curl->post(
                'https://kaspi.kz/merchantcabinet/api/offer/mapToMasterProduct'
                . URL::query(['merchantProductCode' => $article, 'masterProductCode' => $sku], false)
            );
            $json = $curl->getRawResponse();
            $json = json_decode($json, true);
            if($json['status'] != 'SUCCESS'){
                throw new HTTP_Exception_500(implode('<br>', $json['messages']));
            }

            /** @var Model_AutoPart_Shop_Product $model */
            $model = Request_Request::findOneModel(
                DB_AutoPart_Shop_Product::NAME, $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB,
                Request_RequestParams::setParams(['article_full' => $article, 'is_public_ignore' => true])
            );

            if($model === false){
                throw new HTTP_Exception_500('Product not found.');
            }

            $options = $model->getOptionsArray();
            $options['sources']['kaspi']['data'] = [];
            $options['sources']['kaspi']['url'] = Request_RequestParams::getParamStr('product_url');
            $options['sources']['kaspi']['image'] = '';
            $model->setOptionsArray($options);

           // print_r($options);die;

            Helpers_DB::saveDBObject($model, $this->_sitePageData);

            $modelSource = new Model_AutoPart_Shop_Product_Source();
            $modelSource->setDBDriver($this->_driverDB);

            $modelSource->setShopSourceID(Model_AutoPart_Shop_Source::SHOP_SOURCE_KASPI_KZ);
            $modelSource->setShopProductID($model->id);

            $modelSource->setPriceCost($model->getPriceCost());
            $modelSource->setProfit($modelSource->getPrice() - $model->getPriceCost() - round($modelSource->getPrice() / 100 * self::PERCENT));

            $modelSource->setURL($options['sources']['kaspi']['url']);
            $modelSource->setImageURL($options['sources']['kaspi']['image']);

            $url = $modelSource->getURL();
            $sourceSiteID = str_replace('/', '', substr($url, strrpos($url, '-') + 1));
            $modelSource->setSourceSiteID($sourceSiteID);

            Helpers_DB::saveDBObject($modelSource, $this->_sitePageData, $model->shopID);
        }

        $product = Request_Request::findOne(
            DB_AutoPart_Shop_Product::NAME, $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB,
            Request_RequestParams::setParams(
                [
                    'is_public_ignore' => true,
                    'article_full' => $article,
                ]
            )
        );
        if($product != null) {
            Api_AutoPart_Shop_Product_Join::addJoin(
                Model_AutoPart_Shop_Source::SHOP_SOURCE_KASPI_KZ, $product->id, $this->_sitePageData, $this->_driverDB
            );
        }

        $paramsStr = str_replace('?', '', Request_RequestParams::getParamStr('params'));

        $params = [];
        parse_str($paramsStr, $params);

        $params['limit_page'] = 1;
        $params['page'] = intval(Request_RequestParams::getParamInt('page'));
        $params['shop_source_id_empty'] = true;
        $params['is_found_supplier'] = true;
        $params['root_shop_product_id'] = 0;
        $params['is_public'] = true;
        $params['is_in_stock'] = true;
        $params['price_cost_from'] = 0;

        $ids = Request_Request::find(
            DB_AutoPart_Shop_Product::NAME, $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB,
            Request_RequestParams::setParams($params), 0, true
        );

        $result = '';
        if(count($ids->childs) > 0) {
            $result = Helpers_View::getViewObject(
                $ids->childs[0], new Model_AutoPart_Shop_Product(), '_shop/product/one/identify',
                $this->_sitePageData, $this->_driverDB
            );

            $result = str_replace('#index#', $params['page'], $result);
        }

        $this->response->body($result);
    }

    /**
     * Получаем товары для распознования
     * https://kaspi.kz/merchantcabinet/api/product/search/sku
     */
    public function action_set_found(){
        $this->_sitePageData->url = '/smg/kaspi/set_found';
        $this->_sitePageData->shopID = Request_RequestParams::getParamInt('shop_branch_id');

        $article = Request_RequestParams::getParamStr('article');
        if(empty($article)){
            throw new HTTP_Exception_500('Article not correct.');
        }

        /** @var Model_AutoPart_Shop_Product $model */
        $model = Request_Request::findOneModel(
            DB_AutoPart_Shop_Product::NAME, $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB,
            Request_RequestParams::setParams([
                'article_full' => $article,
            ])
        );

        if($model !== false){
            $model->setIsFoundSupplier(false);
            Helpers_DB::saveDBObject($model, $this->_sitePageData);
        }

        $paramsStr = str_replace('?', '', Request_RequestParams::getParamStr('params'));

        $params = [];
        parse_str($paramsStr, $params);

        $params['limit_page'] = 1;
        $params['page'] = intval(Request_RequestParams::getParamInt('page'));
        $params['shop_source_id_empty'] = true;
        $params['is_found_supplier'] = true;
        $params['root_shop_product_id'] = 0;
        $params['is_public'] = true;
        $params['is_in_stock'] = true;

        // обновляем файл прайс листа
        $ids = Request_Request::find(
            DB_AutoPart_Shop_Product::NAME, $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB,
            Request_RequestParams::setParams($params), 0, true
        );

        $result = '';
        if(count($ids->childs) > 0) {
            $result = Helpers_View::getViewObject(
                $ids->childs[0], new Model_AutoPart_Shop_Product(), '_shop/product/one/identify',
                $this->_sitePageData, $this->_driverDB
            );

            $result = str_replace('#index#', $params['page'], $result);
        }

        $this->response->body($result);
    }

    /**
     * Следующий товар
     * @throws HTTP_Exception_500
     */
    public function action_next_product(){
        $this->_sitePageData->url = '/smg/kaspi/next_product';
        $this->_sitePageData->shopID = Request_RequestParams::getParamInt('shop_branch_id');

        $article = Request_RequestParams::getParamStr('article');
        if(empty($article)){
            throw new HTTP_Exception_500('Article not correct.');
        }

        $paramsStr = str_replace('?', '', Request_RequestParams::getParamStr('params'));

        $params = [];
        parse_str($paramsStr, $params);

        $params['limit_page'] = 1;
        $params['page'] = intval(Request_RequestParams::getParamInt('page')) + 1;
        $params['shop_source_id_empty'] = true;
        $params['is_found_supplier'] = true;
        $params['root_shop_product_id'] = 0;
        $params['is_public'] = true;
        $params['is_in_stock'] = true;
        $params['price_cost_from'] = 0;

        // обновляем файл прайс листа
        $ids = Request_Request::find(
            DB_AutoPart_Shop_Product::NAME, $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB,
            Request_RequestParams::setParams($params), 0, true
        );

        $result = '';
        if(count($ids->childs) > 0) {
            $result = Helpers_View::getViewObject(
                $ids->childs[0], new Model_AutoPart_Shop_Product(), '_shop/product/one/identify',
                $this->_sitePageData, $this->_driverDB
            );

            $result = str_replace('#index#', $params['page'], $result);
        }

        $this->response->body($result);
    }

    public function isAccess(){}
}