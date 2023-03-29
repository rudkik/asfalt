<?php defined('SYSPATH') or die('No direct script access.');

class View_Shop_Address extends View_View {

    /**
     * Получаем адрес магазина
     * @param $dbObject
     * @param $shopID
     * @param $viewObject
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @param array $params
     * @param null $elements
     * @param bool $isLoadView
     * @return mixed|string
     */
    public static function getMainShopAddress($dbObject, $shopID, $viewObject, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver,
                                              array $params = array(), $elements = NULL, $isLoadView = TRUE){
        // ищем в мемкеше
        $data = Helpers_DB::getMemcacheFunctionView($shopID, 'View_Shop_Address::getMainShopAddress',
            array(Model_Shop_Address::TABLE_NAME, Model_City::TABLE_NAME),
            $viewObject, $sitePageData, $driver);
        if ($data !== NULL){
            $sitePageData->replaceDatas['view::'.$viewObject] = $data;

            return $data;
        }

        // получаем ID адреса основного магазина
        $shopMainAddressID = new MyArray();
        $shopMainAddressID->id = Request_Shop_Address::getMainAddressID($shopID, $sitePageData, $driver);

        if ($shopMainAddressID->id > 0){
            $model = new Model_Shop_Address();
            $model->setDBDriver($driver);

            $data = Helpers_View::getViewObject($shopMainAddressID, $model, $viewObject, $sitePageData, $driver,
                $shopID, TRUE, $elements);
        }else{
            $data = '';
        }

        $sitePageData->replaceDatas['view::'.$viewObject] = $data;

        // записываем в мемкеш
        Helpers_DB::setMemcacheFunctionView($data, $shopID, 'View_Shop_Address::getMainShopAddress',
            array(Model_Shop_Address::TABLE_NAME, Model_City::TABLE_NAME),
            $viewObject, $sitePageData, $driver);

        return $data;
    }

    /**
     * Поиск адресов с контактами
     * @param $dbObject
     * @param $shopID
     * @param $viewObjects
     * @param $viewObject
     * @param array $groupViews
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @param array $params
     * @param null $elements
     * @param bool $isLoadView
     * @return mixed|string
     */
    public static function findShopAddressWithContacts($dbObject, $shopID, $viewObjects, $viewObject, array $groupViews,
                                                       SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver,
                                                       array $params = array(), $elements = NULL, $isLoadView = TRUE){
        $groupParams = Arr::path($groupViews, 'params', array());
        $groupElements = Arr::path($groupViews, 'elements', array());
        if (Model_Memcache_ShopMemcacheDriver::IS_SAVE_MEMCACHE) {
            $tables = self::getTables(array(Model_Shop_AddressContact::TABLE_NAME, Model_Shop::TABLE_NAME, Model_Shop_AddressContact::TABLE_NAME), $elements);
            $key = Helpers_DB::getURLParamDatas(Request_Shop_AddressContact::getParamsList(), $params).Helpers_DB::getURLParamDatas(Request_Shop_Table_Hashtag::getParamsList(), $groupParams);

            $result = Helpers_DB::getMemcacheFunctionView($shopID, 'View_Shop_AddressContact::findShopAddressWithContacts', $tables, $viewObjects, $sitePageData, $driver, $key);
            if ($result !== NULL) {
                $sitePageData->replaceDatas['view::' . $viewObjects] = $result;
                return $result;
            }
        }

        $ids = Request_Shop_Address::findShopAddressIDs($shopID, $sitePageData, $driver, $params,
            Func::getLimit($params), !$isLoadView,
            $elements);

        $model = new Model_Shop_AddressContact();
        $model->setDBDriver($driver);

        $list = $groupViews['list'];
        $one = $groupViews['one'];
        foreach ($ids->childs as $child) {
            $contactIDs = Request_Shop_AddressContact::findShopAddressContactIDs($child->values['shop_id'], $sitePageData, $driver,
                array_merge($groupParams, array('shop_address_id' => $child->id)),
                Arr::path($params, 'limit.value', intval(Arr::path($groupParams, 'limit', 0))), !$isLoadView);

            $child->additionDatas['view::'.$list] = Helpers_View::getViewObjects($contactIDs, $model,
                $list, $one, $sitePageData, $driver, $child->values['shop_id'], TRUE, $groupElements);
        }

        $model = new Model_Shop_Address();
        $model->setDBDriver($driver);
        $result = Helpers_View::getViewObjects($ids, $model, $viewObjects, $viewObject, $sitePageData, $driver, 0, TRUE, $elements);

        $sitePageData->replaceDatas['view::'.$viewObjects] = $result;

        if (Model_Memcache_ShopMemcacheDriver::IS_SAVE_MEMCACHE) {
            Helpers_DB::setMemcacheFunctionView($result, $shopID, 'View_Shop_AddressContact::findShopAddressWithContacts', $tables, $viewObjects, $sitePageData, $driver, $key);
        }

        return $result;
    }
}