<?php defined('SYSPATH') or die('No direct script access.');

class View_User {

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
	public static function getUsers($shopID, $viewObjects, $viewObject, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver,
											  array $params = array(), $elements = NULL, $isLoadView = TRUE){
		if (Model_Memcache_ShopMemcacheDriver::IS_SAVE_MEMCACHE) {
			$tables = self::getTables(Model_User::TABLE_NAME, $elements);
			$result = Helpers_DB::getMemcacheFunctionView($shopID, 'View_User::getUsers', $tables, $viewObjects, $sitePageData, $driver);
			if ($result !== NULL) {
				$sitePageData->replaceDatas['view::' . $viewObjects] = $result;

				return $result;
			}
		}

		$ids = Request_User::getUserIDs($shopID, $sitePageData, $driver, !$isLoadView);
		if (!$isLoadView) {
			return $ids;
		}

		$model = new Model_User();
		$model->setDBDriver($driver);
		$result = Helpers_View::getViewObjects($ids, $model, $viewObjects, $viewObject, $sitePageData, $driver, $shopID, TRUE, $elements);

		$sitePageData->replaceDatas['view::'.$viewObjects] = $result;

		if (Model_Memcache_ShopMemcacheDriver::IS_SAVE_MEMCACHE) {
			Helpers_DB::setMemcacheFunctionView($result, $shopID, 'View_User::getUsers', $tables, $viewObjects, $sitePageData, $driver);
		}

		return $result;
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
	public static function findUsers($shopID, $viewObjects, $viewObject, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver,
											   array $params = array(), $elements = NULL, $isLoadView = TRUE){
		if (Model_Memcache_ShopMemcacheDriver::IS_SAVE_MEMCACHE) {
			$tables = self::getTables(Model_User::TABLE_NAME, $elements);
			$key = Helpers_DB::getURLParamDatas(Request_User::getParamsList(), $params);
			$result = Helpers_DB::getMemcacheFunctionView($shopID, 'View_User::findUsers', $tables, $viewObjects, $sitePageData, $driver, $key);
			if ($result !== NULL) {
				$sitePageData->replaceDatas['view::' . $viewObjects] = $result;
				return $result;
			}
		}

		$ids = Request_User::findUserIDs($shopID, $sitePageData, $driver, $params,
			Func::getLimit($params), !$isLoadView);
		if (!$isLoadView) {
			return $ids;
		}

		$model = new Model_User();
		$model->setDBDriver($driver);
		$result = Helpers_View::getViewObjects($ids, $model, $viewObjects, $viewObject, $sitePageData, $driver, $shopID, TRUE, $elements);

		$sitePageData->replaceDatas['view::'.$viewObjects] = $result;

		if (Model_Memcache_ShopMemcacheDriver::IS_SAVE_MEMCACHE) {
			Helpers_DB::setMemcacheFunctionView($result, $shopID, 'View_User::findUsers', $tables, $viewObjects, $sitePageData, $driver, $key);
		}

		return $result;
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
	public static function getUser($shopID, $viewObject, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver,
											 array $params = array(), $elements = NULL, $isLoadView = TRUE){
		if (Model_Memcache_ShopMemcacheDriver::IS_SAVE_MEMCACHE) {
			$tables = self::getTables(Model_User::TABLE_NAME, $elements);
			$key = Helpers_DB::getURLParamDatas(Request_User::getParamsOne(), $params);

			$result = Helpers_DB::getMemcacheFunctionView($shopID, 'View_User::getUser', $tables, $viewObject, $sitePageData, $driver, $key);
			if ($result !== NULL) {
				$sitePageData->replaceDatas['view::' . $viewObject] = $result;
				return $result;
			}
		}

		$model = new Model_User();
		$model->setDBDriver($driver);
		$objectID = self::getShopObject($shopID, $model, $sitePageData, $params, $elements, 'Brand not found!');

		if (!$isLoadView) {
			return $objectID;
		}

		$result = Helpers_View::getViewObject($objectID, $model, $viewObject, $sitePageData, $driver, $shopID, TRUE, $elements);
		$sitePageData->replaceDatas['view::'.$viewObject] = $result;

		if (Model_Memcache_ShopMemcacheDriver::IS_SAVE_MEMCACHE) {
			Helpers_DB::setMemcacheFunctionView($result, $shopID, 'View_User::getUser', $tables, $viewObject, $sitePageData, $driver, $key);
		}

		return $result;
	}

    /**
     * Получаем данные залогиненного пользователя
     * @param $shopID
     * @param $viewObject
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @param array $params
     * @param null $elements
     * @param bool $isLoadView
     * @return MyArray|string
     * @throws Exception
     * @throws HTTP_Exception_404
     */
	public static function getUserCurrent($shopID, $viewObject, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver,
											  array $params = array(), $elements = NULL, $isLoadView = TRUE){
		if (Model_Memcache_ShopMemcacheDriver::IS_SAVE_MEMCACHE) {
			$tables = self::getTables(Model_Shop_Table_Brand::TABLE_NAME, $elements);
			$key = Helpers_DB::getURLParamDatas(Request_Shop_Table_Brand::getParamsOne(), $params) . $sitePageData->userID;
			$result = Helpers_DB::getMemcacheFunctionView($shopID, 'View_ShopUser::getUserCurrent', $tables, $viewObject, $sitePageData, $driver, $key);
			if ($result !== NULL) {
				$sitePageData->replaceDatas['view::' . $viewObject] = $result;
				return $result;
			}
		}

		$shopUserID = new MyArray();
		if($sitePageData->userID > 0){
            $shopUserID->id = $sitePageData->userID;
			$shopUserID->values = $sitePageData->user->getValues(TRUE, TRUE, $sitePageData->shopID);
		}else{
			if(Request_RequestParams::getParamBoolean('is_error_404', $params) === TRUE){
				throw new HTTP_Exception_404('User not found.');
			}else {
				$shopUserID->values = array();
			}
		}
		$shopUserID->isFindDB = TRUE;
        if(!$isLoadView){
            return $shopUserID;
        }
		
		$model = new Model_User();
		$model->setDBDriver($driver);
		$result = Helpers_View::getViewObject($shopUserID, $model, $viewObject, $sitePageData, $driver, 0, TRUE, $elements);
		
		$sitePageData->replaceDatas['view::'.$viewObject] = $result;

        if (Model_Memcache_ShopMemcacheDriver::IS_SAVE_MEMCACHE) {
            Helpers_DB::setMemcacheFunctionView($result, $shopID, 'View_ShopUser::getUserCurrent', $tables, $viewObject, $sitePageData, $driver, $key);
        }
		
		return $result;
	}
}