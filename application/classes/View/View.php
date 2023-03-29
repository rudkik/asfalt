<?php defined('SYSPATH') or die('No direct script access.');

class View_View extends View_Basic_Basic {

    /**
     * Поиск всех опубликованных и не удаленных записей
     * @param $dbObject
     * @param $shopID
     * @param $viewObjects
     * @param $viewObject
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @param array $params
     * @param null $elements
     * @param $
     * @param bool $isLoadOneView
     * @param bool $isLoadView
     * @return mixed|MyArray|string
     */
	public static function findAll($dbObject, $shopID, $viewObjects, $viewObject, SitePageData $sitePageData, 
                                   Model_Driver_DBBasicDriver $driver, array $params = array(), $elements = NULL,
                                   $isLoadOneView = FALSE, $isLoadView = TRUE){
		if (Model_Memcache_ShopMemcacheDriver::IS_SAVE_MEMCACHE) {
			$tables = self::getTables($dbObject, $elements);
			$result = Helpers_DB::getMemcacheFunctionView(
			    $shopID, $dbObject . '::findAll', $tables, $viewObjects, $sitePageData, $driver
            );
			if ($result !== NULL) {
				$sitePageData->replaceDatas['view::' . $viewObjects] = $result;
				return $result;
			}
		}

		$ids = Request_Request::findAll($dbObject, $shopID, $sitePageData, $driver, 0, !$isLoadView, $elements);
		if (!$isLoadView) {
			return $ids;
		}

		$model = DB_Basic::createModel($dbObject, $driver);
		$result = Helpers_View::getViewObjects(
		    $ids, $model, $viewObjects, $viewObject, $sitePageData, $driver, $shopID, TRUE, $elements, $isLoadOneView
        );
		$sitePageData->replaceDatas['view::'.$viewObjects] = $result;

		if (Model_Memcache_ShopMemcacheDriver::IS_SAVE_MEMCACHE) {
			Helpers_DB::setMemcacheFunctionView(
			    $result, $shopID, $dbObject . '::findAll', $tables, $viewObjects, $sitePageData, $driver
            );
		}
		
		return $result;
	}

    /**
     * Поиск записей
     * @param $dbObject
     * @param $shopID
     * @param $viewObjects
     * @param $viewObject
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @param array $params
     * @param null $elements
     * @param bool $isLoadView
     * @param bool $isLoadOneView
     * @param bool $isAddReplaceAndGlobalData
     * @return mixed|MyArray|string
     */
	public static function find($dbObject, $shopID, $viewObjects, $viewObject, SitePageData $sitePageData,
                                Model_Driver_DBBasicDriver $driver, array $params = array(), $elements = NULL,
                                $isLoadOneView = FALSE, $isLoadView = TRUE, $isAddReplaceAndGlobalData = TRUE){
        if (Model_Memcache_ShopMemcacheDriver::IS_SAVE_MEMCACHE) {
            $tables = self::getTables($dbObject, $elements);
            $result = Helpers_DB::getMemcacheFunctionView(
                $shopID, $dbObject . '::find', $tables, $viewObjects, $sitePageData, $driver
            );
            if ($result !== NULL) {
                $sitePageData->replaceDatas['view::' . $viewObjects] = $result;
                return $result;
            }
        }

        $ids = Request_Request::find(
            $dbObject, $shopID, $sitePageData, $driver, $params, Func::getLimit($params), !$isLoadView, $elements
        );
		if (!$isLoadView) {
			return $ids;
		}

        $model = DB_Basic::createModel($dbObject, $driver);
		$result = Helpers_View::getViewObjects(
		    $ids, $model, $viewObjects, $viewObject, $sitePageData, $driver, $shopID, TRUE, $elements,
            $isLoadOneView
        );
		if($isAddReplaceAndGlobalData) {
            $sitePageData->addReplaceAndGlobalDatas('view::' . $viewObjects, $result);
        }

        if (Model_Memcache_ShopMemcacheDriver::IS_SAVE_MEMCACHE) {
            Helpers_DB::setMemcacheFunctionView(
                $result, $shopID, $dbObject . '::find', $tables, $viewObjects, $sitePageData, $driver
            );
        }

		return $result;
	}

    /**
     * Поиск одной записи ID
     * @param $dbObject
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
	public static function findOne($dbObject, $shopID, $viewObject, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver,
                                   array $params = array(), $elements = NULL, $isLoadView = TRUE){
        if (Model_Memcache_ShopMemcacheDriver::IS_SAVE_MEMCACHE) {
            $tables = self::getTables($dbObject, $elements);
            $result = Helpers_DB::getMemcacheFunctionView(
                $shopID, $dbObject . '::findOne', $tables, $viewObject, $sitePageData, $driver
            );
            if ($result !== NULL) {
                $sitePageData->replaceDatas['view::' . $viewObject] = $result;
                return $result;
            }
        }

        $isNotReadRequest = Request_RequestParams::getIsNotReadRequest($params);
        $id = Request_RequestParams::getParamInt('id', $params, $isNotReadRequest);

        $ids = Request_Request::findOneByID($dbObject, $id, $shopID, $sitePageData, $driver, $elements);
        if($ids === null){
            if (Request_RequestParams::getParamBoolean('is_error_404', $params) === TRUE) {
                throw new HTTP_Exception_404('Object id="'.$id.'" not found.');
            } else {
                $ids = new MyArray();
                $ids->setIsFind(true);
            }
        }

        if (!$isLoadView) {
            return $ids;
        }

        $model = DB_Basic::createModel($dbObject, $driver);
        $result = Helpers_View::getViewObject(
            $ids, $model, $viewObject, $sitePageData, $driver, $shopID, TRUE, $elements
        );
        $sitePageData->addReplaceAndGlobalDatas('view::'.$viewObject,  $result);

        if (Model_Memcache_ShopMemcacheDriver::IS_SAVE_MEMCACHE) {
            Helpers_DB::setMemcacheFunctionView(
                $result, $shopID, $dbObject . '::findOne', $tables, $viewObject, $sitePageData, $driver
            );
        }
        
		return $result;
	}

    /**
     * Поиск записей в филиалах
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
    public static function findBranch($dbObject, $shopID, $viewObjects, $viewObject, SitePageData $sitePageData,
                                      Model_Driver_DBBasicDriver $driver, array $params = array(), $elements = NULL,
                                      $isLoadOneView = FALSE, $isLoadView = TRUE){
        if (Model_Memcache_ShopMemcacheDriver::IS_SAVE_MEMCACHE) {
            $tables = self::getTables($dbObject, $elements);
            $result = Helpers_DB::getMemcacheFunctionView(
                $shopID, $dbObject . '::findBranch', $tables, $viewObjects, $sitePageData, $driver
            );
            if ($result !== NULL) {
                $sitePageData->replaceDatas['view::' . $viewObjects] = $result;
                return $result;
            }
        }

        $ids = Request_Request::findBranch(
            $dbObject, array(), $sitePageData, $driver, $params, Func::getLimit($params), !$isLoadView, $elements
        );
        if (!$isLoadView) {
            return $ids;
        }

        $model = DB_Basic::createModel($dbObject, $driver);
        foreach ($ids->childs as $child) {
            $child->str = Helpers_View::getViewObject(
                $child, $model, $viewObject, $sitePageData, $driver, $child->values['shop_id'], TRUE, $elements
            );
        }

        $result = Helpers_View::getViewObjects(
            $ids, $model, $viewObjects, $viewObject, $sitePageData, $driver, 0, TRUE, $elements,
            $isLoadOneView
        );
        $sitePageData->replaceDatas['view::' . $viewObjects] = $result;

        if (Model_Memcache_ShopMemcacheDriver::IS_SAVE_MEMCACHE) {
            Helpers_DB::setMemcacheFunctionView(
                $result, $shopID, $dbObject . '::findBranch', $tables, $viewObjects, $sitePageData, $driver
            );
        }

        return $result;
    }

    /**
     * Поиск хэгетов с единицами измерения
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
     * @return mixed|MyArray|string
     */
    public static function findShopTableHashtagsWithUnits($dbObject, $shopID, $viewObjects, $viewObject, array $groupViews,
                                                          SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver,
                                                          array $params = array(), $elements = NULL, $isLoadView = TRUE){

        $groupElements = Arr::path($groupViews, 'elements', NULL);
        $groupParams = Arr::path($groupViews, 'params', array());

        if (Model_Memcache_ShopMemcacheDriver::IS_SAVE_MEMCACHE) {
            $tables = array_merge(self::getTables(Model_Shop_Table_Unit::TABLE_NAME, $groupElements), self::getTables(Model_Shop_Table_Hashtag::TABLE_NAME, $elements));
            $key = Helpers_DB::getURLParamDatas(Request_Shop_Table_Unit::getParamsList(), $groupParams). Helpers_DB::getURLParamDatas(Request_Shop_Table_Hashtag::getParamsList(), $params);
            $result = Helpers_DB::getMemcacheFunctionView($shopID, 'View_Shop_Table_Unit::findShopTableHashtagsWithUnits', $tables, $viewObjects, $sitePageData, $driver, $key);
            if ($result !== NULL) {
                $sitePageData->replaceDatas['view::' . $viewObjects] = $result;
                return $result;
            }
        }

        $ids = Request_Request::find(
            DB_Shop_Table_Hashtag::NAME, $shopID, $sitePageData, $driver, $params,
            Func::getLimit($params), TRUE, $elements
        );

        // получаем единицы измерения
        foreach($ids->childs as $child) {
            $child->additionDatas['ids'] = Request_Request::find(
                DB_Shop_Table_Unit::NAME, $shopID, $sitePageData, $driver,
                array_merge(
                    $groupParams,
                    array(
                        'shop_table_hashtag_id' => $child->id,
                        Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE,
                    )
                ),
                0, !$isLoadView, $groupElements
            );
        }

        if (!$isLoadView) {
            return $ids;
        }

        $model = new Model_Shop_Table_Unit();
        $model->setDBDriver($driver);

        // html  генерируем
        $list = $groupViews['list'];
        $one = $groupViews['one'];
        foreach($ids->childs as $child) {
            $child->additionDatas['view::'.$list] =
                Helpers_View::getViewObjects($child->additionDatas['ids'], $model, $list, $one, $sitePageData,
                    $driver, $shopID, TRUE, $groupElements);

            unset($child->additionDatas['ids']);
        }

        $model = new Model_Shop_Table_Hashtag();
        $model->setDBDriver($driver);
        $result = Helpers_View::getViewObjects($ids, $model, $viewObjects, $viewObject, $sitePageData, $driver, $shopID,
            TRUE, $elements);

        $sitePageData->replaceDatas['view::'.$viewObjects] = $result;

        if (Model_Memcache_ShopMemcacheDriver::IS_SAVE_MEMCACHE) {
            Helpers_DB::setMemcacheFunctionView($result, $shopID, 'View_Shop_Table_Unit::findShopTableHashtagsWithUnits', $tables, $viewObjects, $sitePageData, $driver, $key);
        }

        return $result;
    }
}