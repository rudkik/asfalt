<?php defined('SYSPATH') or die('No direct script access.');

class View_Shop extends View_Shop_Table_Rubric {

    /**
     * Получаем список городов магазина
     * @param $shopID
     * @param $viewObjects
     * @param $viewObject
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @param array $params
     * @param null $elements
     * @param bool $isLoadView
     * @return MyArray|string
     * @throws Exception
     */
    public static function getShopCities($shopID, $viewObjects, $viewObject, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver,
                                         array $params = array(), $elements = NULL, $isLoadView = TRUE){
        if (Model_Memcache_ShopMemcacheDriver::IS_SAVE_MEMCACHE) {
            $tables = self::getTables(array(Model_City::TABLE_NAME, Model_Shop::TABLE_NAME), $elements);
            $result = Helpers_DB::getMemcacheFunctionView($shopID, 'View_City::getShopCities', $tables, $viewObjects, $sitePageData, $driver, $shopID);
            if ($result !== NULL) {
                $sitePageData->replaceDatas['view::' . $viewObjects] = $result;
                return $result;
            }
        }

        $ids = new MyArray($sitePageData->shop->getCityIDsArray());
        if (!$isLoadView) {
            return $ids;
        }

        $model = new Model_City();
        $model->setDBDriver($driver);
        $result = Helpers_View::getViewObjects($ids, $model, $viewObjects, $viewObject, $sitePageData, $driver, 0, TRUE, $elements);

        $sitePageData->replaceDatas['view::'.$viewObjects] = $result;

        if (Model_Memcache_ShopMemcacheDriver::IS_SAVE_MEMCACHE) {
            Helpers_DB::setMemcacheFunctionView($result, $shopID, 'View_City::getShopCities', $tables, $viewObjects, $sitePageData, $driver, $shopID);
        }

        return $result;
    }

    /**
     * Получаем список городов магазина
     * @param $shopID
     * @param $viewObjects
     * @param $viewObject
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @param array $params
     * @param null $elements
     * @param bool $isLoadOneView
     * @param bool $isLoadView
     * @return mixed|MyArray|string
     */
    public static function getShopRegions($shopID, $viewObjects, $viewObject, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver,
                                          array $params = array(), $elements = NULL, $isLoadOneView = FALSE, $isLoadView = TRUE){
        if (Model_Memcache_ShopMemcacheDriver::IS_SAVE_MEMCACHE) {
            $tables = self::getTables(array(Model_Region::TABLE_NAME, Model_Shop::TABLE_NAME), $elements);
            $result = Helpers_DB::getMemcacheFunctionView($shopID, 'View_Region::getShopRegions', $tables, $viewObjects, $sitePageData, $driver, $shopID);
            if ($result !== NULL) {
                $sitePageData->replaceDatas['view::' . $viewObjects] = $result;
                return $result;
            }
        }

        $ids = new MyArray($sitePageData->shop->getRegionIDsArray());
        if (!$isLoadView) {
            return $ids;
        }

        $model = new Model_Region();
        $model->setDBDriver($driver);
        $result = Helpers_View::getViewObjects(
            $ids, $model, $viewObjects, $viewObject, $sitePageData, $driver, 0, TRUE, $elements, $isLoadOneView
        );

        $sitePageData->replaceDatas['view::'.$viewObjects] = $result;

        if (Model_Memcache_ShopMemcacheDriver::IS_SAVE_MEMCACHE) {
            Helpers_DB::setMemcacheFunctionView($result, $shopID, 'View_Region::getShopRegions', $tables, $viewObjects, $sitePageData, $driver, $shopID);
        }

        return $result;
    }

    /**
     * Поиск языков магазина
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
     * @return mixed|MyArray|string
     */
    public static function getShopLanguages($dbObject, $shopID, $viewObjects, $viewObject, SitePageData $sitePageData,
                                            Model_Driver_DBBasicDriver $driver,
                                            array $params = array(), $elements = NULL, $isLoadOneView = FALSE, $isLoadView = TRUE){
        if (Model_Memcache_ShopMemcacheDriver::IS_SAVE_MEMCACHE) {
            $tables = self::getTables(array(Model_Language::TABLE_NAME, Model_Shop::TABLE_NAME), $elements);
            $result = Helpers_DB::getMemcacheFunctionView($shopID, 'View_Language::getShopLanguages', $tables, $viewObjects, $sitePageData, $driver);
            if ($result !== NULL) {
                $sitePageData->replaceDatas['view::' . $viewObjects] = $result;
                return $result;
            }
        }

        // получаем список ID языков
        if($shopID == $sitePageData->shopID){
            $ids = new MyArray($sitePageData->shop->getLanguageIDsArray());
        }elseif($shopID == $sitePageData->branchID){
            $ids = new MyArray($sitePageData->branch->getLanguageIDsArray());
        }elseif($shopID == $sitePageData->shopMainID){
            $ids = new MyArray($sitePageData->shopMain->getLanguageIDsArray());
        }else{
            return '';
        }

        if (!$isLoadView) {
            return $ids;
        }

        $model = new Model_Language();
        $model->setDBDriver($driver);
        $result = Helpers_View::getViewObjects(
            $ids, $model, $viewObjects, $viewObject, $sitePageData, $driver, $shopID, TRUE, $elements, $isLoadOneView
        );

        $sitePageData->replaceDatas['view::'.$viewObjects] = $result;

        if (Model_Memcache_ShopMemcacheDriver::IS_SAVE_MEMCACHE) {
            Helpers_DB::setMemcacheFunctionView($result, $shopID, 'View_Language::getShopLanguages', $tables, $viewObjects, $sitePageData, $driver);
        }

        return $result;
    }
    /**
     * Получаем список городов магазина
     * @param $shopID
     * @param $viewObjects
     * @param $viewObject
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @param array $params
     * @param null $elements
     * @param bool $isLoadView
     * @return array|mixed|MyArray|string
     */
    public static function getShopLands($dbObject, $shopID, $viewObjects, $viewObject, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver,
                                        array $params = array(), $elements = NULL, $isLoadView = TRUE){
        if (Model_Memcache_ShopMemcacheDriver::IS_SAVE_MEMCACHE) {
            $tables = self::getTables(array(Model_Shop::TABLE_NAME, Model_Land::TABLE_NAME), $elements);
            $result = Helpers_DB::getMemcacheFunctionView($shopID, 'View_Land::getShopLands', $tables, $viewObjects, $sitePageData, $driver, $shopID);
            if ($result !== NULL) {
                $sitePageData->replaceDatas['view::' . $viewObjects] = $result;

                return $result;
            }
        }

        $ids = $sitePageData->shop->getLandIDsArray();
        if (!empty($ids)) {
            $params['id'] = array('value' => $ids);
            $ids = Request_Land::findLandIDs($sitePageData, $driver, $params,
                Func::getLimit($params),
                !$isLoadView, $elements);
        }else {
            $ids = new MyArray();
        }

        if (!$isLoadView) {
            return $ids;
        }

        $model = new Model_Land();
        $model->setDBDriver($driver);
        $result = Helpers_View::getViewObjects($ids, $model, $viewObjects, $viewObject, $sitePageData, $driver, 0, TRUE, $elements);

        $sitePageData->replaceDatas['view::'.$viewObjects] = $result;

        if (Model_Memcache_ShopMemcacheDriver::IS_SAVE_MEMCACHE) {
            Helpers_DB::setMemcacheFunctionView($result, $shopID, 'View_Land::getShopLands', $tables, $viewObjects, $sitePageData, $driver, $shopID);
        }

        return $result;
    }
}