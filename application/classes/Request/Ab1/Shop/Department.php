<?php defined('SYSPATH') or die('No direct script access.');

class Request_Ab1_Shop_Department extends Request_Request
{
    /**
     * Проверяем есть ли объект Request_...
     * @param $dbObject
     * @return bool|string
     */
    protected static function getRequest($dbObject)
    {
        return false;
    }

    /**
     * Получаем список отделов от основного родителя
     * @param $dbObject
     * @param $shopID
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @param array $params
     * @param int $limit
     * @param bool $isLoadAllFields
     * @return MyArray
     */
    public static function findByMain($dbObject, $shopID, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver,
                                      array $params = array(), $limit = 0, $isLoadAllFields = FALSE)
    {
        $ids = Request_Request::find(
            DB_Ab1_Shop_Department::NAME, $sitePageData->shopID, $sitePageData, $driver, $params, $limit, $isLoadAllFields
        );

        foreach ($ids->childs as $child) {
            self::_getChildIDs($child, $shopID, $sitePageData, $driver, $params, $limit, $isLoadAllFields);
        }

        return $ids;
    }

    /**
     * Получаем детвору у всех элементов
     * @param MyArray $root
     * @param $shopID
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @param array $params
     * @param int $limit
     * @param bool $isLoadAllFields
     */
    private static function _getChildIDs(MyArray $root, $shopID, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver,
                                         array $params = array(), $limit = 0, $isLoadAllFields = FALSE)
    {
        $childIDs = $ids = Request_Request::find(
            DB_Ab1_Shop_Department::NAME, $sitePageData->shopID, $sitePageData, $driver,
            Request_RequestParams::setParams(['shop_department_id' => $root->id]), $limit, $isLoadAllFields
        );

        foreach ($childIDs->childs as $child) {
            self::_getChildIDs($child, $shopID, $sitePageData, $driver, $params, $limit, $isLoadAllFields);
        }
        $root->childs = $childIDs->childs;
    }
}
