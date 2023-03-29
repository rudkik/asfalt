<?php defined('SYSPATH') or die('No direct script access.');


class FuncPrice {


    /**
     * Считаем стоимость всех товаров  в зависимости от типа цены
     * @param MyArray $data
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @return float|int|mixed
     */
    public static function getGoodsAmount(MyArray $data, SitePageData $sitePageData, Model_Driver_DBBasicDriver  $driver){
        $amount = 0;
        foreach ($data->childs as $value) {
            $amount = $amount + self::getGoodPriceInModel($value, $sitePageData, $driver) * Arr::path($value->additionDatas, 'count', 0);
        }

        if ($sitePageData->currency->getIsRound()){
            $amount = round($amount);
        }

        return $amount;
    }

    /**
     * Устанавливаем в поле price цену в зависимости от типа цены
     * @param MyArray $data
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @return mixed
     */
    public static function getGoodPriceInModel(MyArray &$data, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        switch(Arr::path($data->values, Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_table_catalog_id.good_price_type_id', 0)){
            case Model_GoodPriceType::GOOD_PRICE_TYPE_SUPPLIER:
                $data->values['price'] = self::setGoodPriceInModelSupplier($sitePageData->shop->getShopTableCatalogID(), $data);
                break;
            case Model_GoodPriceType::GOOD_PRICE_TYPE_LAND_TWO:
                $data->values['price'] = self::getGoodPriceInModelLandTwo($sitePageData->currencyID, $data);
                break;
            case Model_GoodPriceType::GOOD_PRICE_TYPE_PLUS_MARKUP_AND_BONUS:
                $data->values['price'] = self::getGoodPriceInModelPlusMarkupAndBonus($sitePageData->currency, $data);
                break;
            case Model_GoodPriceType::GOOD_PRICE_TYPE_GOOD_TO_OPERATION:
                $data->values['price'] = self::getGoodPriceGoodToOperation($data, $sitePageData, $driver);
                break;
        }

        return $data->values['price'];
    }

    /**
     * const GOOD_PRICE_TYPE_SUPPLIER = 701;
     * Устанавливаем в поле price цену в зависимости от тип магазина
     * @param $currencyID
     * @param MyArray $data
     * @return int
     */
    public static function getGoodPriceInModelLandTwo($currencyID, MyArray $data)
    {
        switch ($currencyID) {
            case  Model_Currency::RUB:
                $result = $data->values['price_old'] ;
                break;
            default:
                $result = $data->values['price'];
        }

        return floatval($result);
    }


    /**
     * const GOOD_PRICE_TYPE_SUPPLIER = 701;
     *  Получаем цену в зависимости от тип магазина
     * @param $shopBranchTypeID
     * @param Model_Currency $currency
     * @param MyArray $data
     * @param $price
     * @param $priceOld
     * @param bool $isAddCurrency
     * @return float|mixed
     */
    public static function getGoodPriceStrSupplier($shopBranchTypeID, Model_Currency $currency, MyArray $data, &$price, &$priceOld, $isAddCurrency = TRUE)
    {

        $tmp = $data->values['price'];
        $data->values['price'] = self::setGoodPriceInModelSupplier($shopBranchTypeID, $data);
        $result = Func::getGoodPriceStr($currency, $data, $price, $priceOld, $isAddCurrency);
        $data->values['price'] = $tmp;

        return $result;
    }

    /**
     * const GOOD_PRICE_TYPE_SUPPLIER = 701;
     * Устанавливаем в поле price цену в зависимости от тип магазина
     * @param $shopBranchTypeID
     * @param MyArray $data
     * @return float|mixed
     */
    public static function setGoodPriceInModelSupplier($shopBranchTypeID, MyArray $data)
    {
        switch ($shopBranchTypeID) {
            case  3774:
                $result = floatval(Arr::path($data->values['options'], 'price_horeca', 0));
                break;
            case  3771:
                $result = floatval(Arr::path($data->values['options'], 'price_b_plus', 0));
                break;
            case  3769:
                $result = floatval(Arr::path($data->values['options'], 'price_a', 0));
                break;
            case  3770:
                $result = floatval(Arr::path($data->values['options'], 'price_b', 0));
                break;
            case  3772:
                $result = floatval(Arr::path($data->values['options'], 'price_c', 0));
                break;
            case  3773:
                $result = floatval(Arr::path($data->values['options'], 'price_market', 0));
                break;
            default:
                $result = floatval(Arr::path($data->values['options'], 'price_b', 0));
        }
        return $result;
    }


    /**
     * const GOOD_PRICE_TYPE_PLUS_MARKUP_AND_BONUS = 703;
     * Устанавливаем в поле price цену в зависимости от price + options[markup] от магазина или от товара + options[bonus] от магазина или от товара
     * @param Model_Currency $currency
     * @param MyArray $data
     * @return mixed
     */
    public static function getGoodPriceInModelPlusMarkupAndBonus(Model_Currency $currency, MyArray &$data)
    {
        $markup = floatval(Arr::path($data->values, 'options.markup', 0));
        $bonus = floatval(Arr::path($data->values, 'options.bonus', 0));
        if($markup <= 0) {
            $markup = floatval(Arr::path($data->values, Model_Basic_BasicObject::FIELD_ELEMENTS . '.shop_id.options.markup', 0));
            $bonus = floatval(Arr::path($data->values, Model_Basic_BasicObject::FIELD_ELEMENTS . '.shop_id.options.bonus', 0));
        }

        $markupOld = $data->values['price_old'] / 100 * $markup;
        $bonusOld = $data->values['price_old'] / 100 * $bonus;

        if($currency->getIsRound()){
            $markupOld = round($markupOld);
            $bonusOld = round($bonusOld);
        }else{
            $markupOld = round($markupOld, 2);
            $bonusOld = round($bonusOld, 2);
        }

        $data->values['bonus_old'] = $bonusOld;
        $data->values['price_old'] = $data->values['price_old'] + $markupOld + $bonusOld;

        $markup = $data->values['price'] / 100 * $markup;
        $bonus = $data->values['price'] / 100 * $bonus;

        if($currency->getIsRound()){
            $markup = round($markup);
            $bonus = round($bonus);
        }else{
            $markup = round($markup, 2);
            $bonus = round($bonus, 2);
        }

        $data->values['bonus'] = $bonus;
        $data->values['price'] = $data->values['price'] + $markup + $bonus;

        $data->additionDatas['bonus'] = $bonus;
        $data->additionDatas['bonus_old'] = $bonusOld;
        $data->additionDatas['is_calc_price'] = 1;

        return $data->values['price'];
    }

    /**
     * const GOOD_PRICE_TYPE_GOOD_TO_OPERATION = 704;
     * Устанавливаем в поле price цену в зависимости от оператора таблица ct_shop_good_to_operations
     * @param MyArray $data
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @return mixed
     */
    public static function getGoodPriceGoodToOperation(MyArray $data, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        // получаем список
        $goodToOperationIDs = Request_Shop_Good_To_Operation::findShopGoodToOperationIDs($sitePageData->shopID, $sitePageData, $driver,
            array('shop_good_id' => $data->id, 'shop_operation_id' => $sitePageData->operationID, Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE), 1, TRUE);

        if(count($goodToOperationIDs->childs) > 0){
            return $goodToOperationIDs->childs[0]->values['price'];
        }else{
            return $data->values['price'];
        }

    }
}