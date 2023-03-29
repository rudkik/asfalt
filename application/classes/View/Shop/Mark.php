
<?php defined('SYSPATH') or die('No direct script access.');

class View_Shop_Mark extends View_Shop_Table_View {
    /**
     * Поиск брендов
     * @param $shopID
     * @param $viewObjects
     * @param $viewObject
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @param array $params
     * @param null $elements
     * @param bool $isLoadView
     * @return string
     * @throws Exception
     */
    public static function findShopTableParam3s($dbObject, $shopID, $viewObjects, $viewObject, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver,
                                                array $params = array(), $elements = NULL, $isLoadView = TRUE){
        return View_Shop_Table_Param_3::findShopTableParams($shopID, $viewObjects, $viewObject,
            $sitePageData, $driver, $params, $elements, $isLoadView);
    }

    /**
     * Поиск брендов всех
     * @param $shopID
     * @param $viewObjects
     * @param $viewObject
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @param array $params
     * @param null $elements
     * @param bool $isLoadView
     * @return string
     * @throws Exception
     */
    public static function getShopTableParam3s($dbObject, $shopID, $viewObjects, $viewObject, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver,
                                              array $params = array(), $elements = NULL, $isLoadView = TRUE){
        $params = array('table_id' => Model_Shop_Mark::TABLE_ID, Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE);
        return View_Shop_Table_Param_3::findShopTableParams($shopID, $viewObjects, $viewObject,
            $sitePageData, $driver, $params, $elements, $isLoadView);
    }

    /**
     * Поиск бренда
     * @param $shopID
     * @param $viewObject
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @param array $params
     * @param null $elements
     * @param bool $isLoadView
     * @return string
     * @throws Exception
     * @throws HTTP_Exception_404
     */
    public static function getShopTableParam3($dbObject, $shopID, $viewObject, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver,
                                             array $params = array(), $elements = NULL, $isLoadView = TRUE){
        return View_Shop_Table_Param_3::getShopTableParam($shopID, $viewObject,
            $sitePageData, $driver, $params, $elements, $isLoadView);
    }

    /**
     * Поиск брендов
     * @param $shopID
     * @param $viewObjects
     * @param $viewObject
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @param array $params
     * @param null $elements
     * @param bool $isLoadView
     * @return string
     * @throws Exception
     */
    public static function findShopTableParam2s($dbObject, $shopID, $viewObjects, $viewObject, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver,
                                               array $params = array(), $elements = NULL, $isLoadView = TRUE){
        return View_Shop_Table_Param_2::findShopTableParams($shopID, $viewObjects, $viewObject,
            $sitePageData, $driver, $params, $elements, $isLoadView);
    }

    /**
     * Поиск брендов всех
     * @param $shopID
     * @param $viewObjects
     * @param $viewObject
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @param array $params
     * @param null $elements
     * @param bool $isLoadView
     * @return string
     * @throws Exception
     */
    public static function getShopTableParam2s($dbObject, $shopID, $viewObjects, $viewObject, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver,
                                              array $params = array(), $elements = NULL, $isLoadView = TRUE){
        $params = array('table_id' => Model_Shop_Mark::TABLE_ID, Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE);
        return View_Shop_Table_Param_2::findShopTableParams($shopID, $viewObjects, $viewObject,
            $sitePageData, $driver, $params, $elements, $isLoadView);
    }

    /**
     * Поиск бренда
     * @param $shopID
     * @param $viewObject
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @param array $params
     * @param null $elements
     * @param bool $isLoadView
     * @return string
     * @throws Exception
     * @throws HTTP_Exception_404
     */
    public static function getShopTableParam2($dbObject, $shopID, $viewObject, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver,
                                             array $params = array(), $elements = NULL, $isLoadView = TRUE){
        return View_Shop_Table_Param_2::getShopTableParam($shopID, $viewObject,
            $sitePageData, $driver, $params, $elements, $isLoadView);
    }


}