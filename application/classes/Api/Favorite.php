<?php defined('SYSPATH') or die('No direct script access.');

class Api_Favorite  {
    const FIELD_NAME = 'favorite';

    /**
     * Хеш всех избранных товаров
     * @param SitePageData $sitePageData
     * @return string
     */
    public static function getHash(SitePageData $sitePageData){
        $session_data =  $_SESSION;
        return md5(json_encode(Arr::path($session_data, $sitePageData->actionURLName)));
    }
    
    /**
     * Добавляем товар в избранное
     * @param $shopGoodID
     * @param $shopChildID
     * @param SitePageData $sitePageData
     */
    public static function addGood($shopGoodID, $shopChildID, SitePageData $sitePageData){
        $shopGoodID = intval($shopGoodID);
        $shopChildID = intval($shopChildID);
        if ($shopGoodID > 0){
            $_SESSION[$sitePageData->actionURLName][self::FIELD_NAME][$shopGoodID][$shopChildID] = true;
        }
    }

    /**
     * Найден ли товар в избранном
     * @param $shopGoodID
     * @param $shopChildID
     * @param SitePageData $sitePageData
     * @return mixed
     */
    public static function isFindGood($shopGoodID, $shopChildID, SitePageData $sitePageData){
        $shopGoodID = intval($shopGoodID);
        $shopChildID = intval($shopChildID);

        return Arr::path($_SESSION, $sitePageData->actionURLName . '.' .self::FIELD_NAME . '.' .$shopGoodID . '.' .$shopChildID, false);
    }

    /**
     * Удаление товара
     * @param $shopGoodID
     * @param $shopChildID
     * @param SitePageData $sitePageData
     */
    public static function delGood($shopGoodID, $shopChildID, SitePageData $sitePageData){
        $shopGoodID = intval($shopGoodID);
        $shopChildID = intval($shopChildID);
        if ($shopGoodID > 0){
            unset($_SESSION[$sitePageData->actionURLName][self::FIELD_NAME][$shopGoodID][$shopChildID]);

            if(count($_SESSION[$sitePageData->actionURLName][self::FIELD_NAME][$shopGoodID]) == 0){
                unset($_SESSION[$sitePageData->actionURLName][self::FIELD_NAME][$shopGoodID]);
            }
        }
    }

    /**
     * Очищаем заказ
     * @param SitePageData $sitePageData
     */
    public static function clear(SitePageData $sitePageData){
        $session = Session::instance();
        $session_data = &$session->as_array();

        unset($session_data[$sitePageData->actionURLName][self::FIELD_NAME]);
        unset($_SESSION[$sitePageData->actionURLName][self::FIELD_NAME]);
    }

    /**
     * Делаем просчет скидок и акций по корзине
     * @param SitePageData $sitePageData
     * @return bool|MyArray
     */
    public static function getShopGoods(SitePageData $sitePageData)
    {
        $session_data = $_SESSION;

        $favorites = Arr::path(
            $session_data,
            $sitePageData->actionURLName . '.' . self::FIELD_NAME,
            Arr::path($_SESSION, $sitePageData->actionURLName . '.' . self::FIELD_NAME, NULL)
        );
        if (empty($favorites)) {
            return new MyArray();
        }

        // получаем список товаров
        $shopGoods = new MyArray();
        foreach ($favorites as $shopGoodID => $shopChild) {
            foreach ($shopChild as $shopChildID => $values) {
                $shopGoods->addChild($shopGoodID);
            }
        }

        return $shopGoods;
    }
}
