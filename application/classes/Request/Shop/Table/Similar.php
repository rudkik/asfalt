<?php defined('SYSPATH') or die('No direct script access.');

class Request_Shop_Table_Similar extends Request_Request{
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
	 * Поиск родителей из групп
	 * @param $shopID
	 * @param SitePageData $sitePageData
	 * @param Model_Driver_DBBasicDriver $driver
	 * @param array $params
	 * @param int $limit
	 * @return MyArray
	 */
	public static function findShopRootIDs($shopID, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver,
										   array $params = array(), $limit = 0){
		// не считывать параметры переданные в GET и POST запросах
		$isNotReadRequest = Request_RequestParams::getIsNotReadRequest($params);

		$groupBy = Request_RequestParams::getParamArray('group_by', $params, NULL, $isNotReadRequest, $sitePageData);
		$sortBy = Request_RequestParams::getParamArray('sort_by', $params, NULL, $isNotReadRequest, $sitePageData);

		$isLoadAllFields = FALSE;

		$sql = GlobalData::newModelDriverDBSQL();
		$sql->setTableName(Model_Shop_Table_Similar::TABLE_NAME);
		$sql->limit = $limit;

		$sql->getRootSelect()->addField('', "shop_root_object_id", 'id');

        $sql->basicTableName = Model_Shop_Table_Similar::TABLE_NAME;
		if(! static::_getRequestParamsSQL($shopID, $sql, $sitePageData, $driver, $isNotReadRequest, $params, $sortBy,
            $groupBy, Model_Shop_Table_Similar::TABLE_NAME)){
			return new MyArray();
		}

        $limitPage = Request_RequestParams::getParamInt('limit_page', $params, $isNotReadRequest, $sitePageData);
        $page = Request_RequestParams::getParamInt('page', $params, $isNotReadRequest, $sitePageData);

        $sql->page = $page;
        $sql->limitPage = $limitPage;
        $isShift = $limitPage < 1;

        $resultSQL = $driver->getSelect($sql, $isLoadAllFields, $sitePageData->dataLanguageID, $shopID);

        // возвращаем результат
        return Request_RequestUtils::ArrayInMyArrayList(
            $sitePageData, $resultSQL, $limit, $limitPage, $page, $params, $isLoadAllFields, false, $isShift
        );
	}

	/**
	 * Поиск детей из групп
	 * @param $shopID
	 * @param SitePageData $sitePageData
	 * @param Model_Driver_DBBasicDriver $driver
	 * @param array $params
	 * @param int $limit
	 * @return MyArray
	 */
	public static function findShopChildIDs($shopID, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver,
											array $params = array(), $limit = 0){
		// не считывать параметры переданные в GET и POST запросах
		$isNotReadRequest = Request_RequestParams::getIsNotReadRequest($params);

		$groupBy = Request_RequestParams::getParamArray('group_by', $params, NULL, $isNotReadRequest, $sitePageData);
		$sortBy = Request_RequestParams::getParamArray('sort_by', $params, NULL, $isNotReadRequest, $sitePageData);

		$isLoadAllFields = FALSE;

		$sql = GlobalData::newModelDriverDBSQL();
		$sql->setTableName(Model_Shop_Table_Similar::TABLE_NAME);
		$sql->limit = $limit;

		$sql->getRootSelect()->addField('', "shop_child_object_id", 'id');

        $sql->basicTableName = Model_Shop_Table_Similar::TABLE_NAME;
		if(! static::_getRequestParamsSQL($shopID, $sql, $sitePageData, $driver, $isNotReadRequest, $params, $sortBy,
            $groupBy, Model_Shop_Table_Similar::TABLE_NAME)){
			return new MyArray();
		}

        $limitPage = Request_RequestParams::getParamInt('limit_page', $params, $isNotReadRequest, $sitePageData);
        $page = Request_RequestParams::getParamInt('page', $params, $isNotReadRequest, $sitePageData);

        $sql->page = $page;
        $sql->limitPage = $limitPage;
        $isShift = $limitPage < 1;

        $resultSQL = $driver->getSelect($sql, $isLoadAllFields, $sitePageData->dataLanguageID, $shopID);

        // возвращаем результат
        return Request_RequestUtils::ArrayInMyArrayList(
            $sitePageData, $resultSQL, $limit, $limitPage, $page, $params, $isLoadAllFields, false, $isShift
        );
	}
}

