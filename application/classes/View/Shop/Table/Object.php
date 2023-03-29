<?php defined('SYSPATH') or die('No direct script access.');

class View_Shop_Table_Object extends View_View {
    /**
     * Найти и сгруппировать по рубрикам
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
     * @return array|mixed|string
     */
	public static function findGroupRubric($dbObject, $shopID, $viewObjects, $viewObject, array $groupViews, SitePageData $sitePageData,
                                           Model_Driver_DBBasicDriver $driver, array $params = array(), $elements = NULL,
                                           $isLoadView = TRUE){

		$groupElements = Arr::path($groupViews, 'elements', NULL);
		$groupParams = Arr::path($groupViews, 'params', array());

        if (Model_Memcache_ShopMemcacheDriver::IS_SAVE_MEMCACHE) {
            $tables = self::getTables($dbObject, $elements);
            $result = Helpers_DB::getMemcacheFunctionView(
                $shopID, $dbObject . '::findGroupRubric', $tables, $viewObjects, $sitePageData, $driver
            );
            if ($result !== NULL) {
                $sitePageData->replaceDatas['view::' . $viewObjects] = $result;
                return $result;
            }
        }

        $ids = Request_Request::find(
            $dbObject, $shopID, $sitePageData, $driver, $groupParams, Func::getLimit($groupParams), !$isLoadView, $elements
        );

		if(count($ids->childs) > 0) {
			// получаем рубрики
			$groupParams['id'] = $ids->getChildArrayValue('shop_table_rubric_id');
			$groupParams['table_id'] = $dbObject::TABLE_ID;
			$rubricIDs = Request_Request::find(
                'DB_Shop_Table_Rubric', $shopID, $sitePageData, $driver, $params, Func::getLimit($params),
                !$isLoadView, $elements
            );

			if (!$isLoadView) {
				return array(
					'shop_objects' => $ids,
					'shop_table_rubrics' => $rubricIDs,
				);
			}

			// группируем по рубрикам
			foreach ($ids->childs as $child) {
				$rubric = $rubricIDs->findChild($child->values['shop_table_rubric_id']);
				if ($rubric !== NULL) {
					if (key_exists('ids', $rubric->additionDatas)) {
						$rubric->additionDatas['ids'] = new MyArray();
					}
					$rubric->additionDatas['ids']->addChildObject($child);
				}
			}

			$list = $groupViews['list'];
			$one = $groupViews['one'];

            $model = DB_Basic::createModel($dbObject, $driver);
			foreach ($rubricIDs->childs as $child) {
				$child->additionDatas['view::' . $list] = Helpers_View::getViewObjects(
				    $child->additionDatas['ids'], $model, $list, $one, $sitePageData, $driver, $shopID,
                    TRUE, $groupElements
                );
				unset($child->additionDatas['ids']);
			}
		}else{
			$rubricIDs = new MyArray();
			if (!$isLoadView) {
				return array(
                    'shop_objects' => $ids,
                    'shop_table_rubrics' => $rubricIDs,
				);
			}
		}

		$model = new Model_Shop_Table_Rubric();
		$model->setDBDriver($driver);
		$result = Helpers_View::getViewObjects(
		    $rubricIDs, $model, $viewObjects, $viewObject, $sitePageData, $driver, $shopID, TRUE, $elements
        );

		$sitePageData->replaceDatas['view::'.$viewObjects] = $result;

        if (Model_Memcache_ShopMemcacheDriver::IS_SAVE_MEMCACHE) {
            Helpers_DB::setMemcacheFunctionView(
                $result, $shopID, $dbObject . '::findGroupRubric', $tables, $viewObjects, $sitePageData, $driver
            );
        }

		return $result;
	}

    /**
     * Поиск категорий/типов/видов записей
     * @param $dbObject
     * @param $shopID
     * @param $viewObjects
     * @param $viewObject
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @param array $params
     * @param null $elements
     * @param bool $isLoadView
     * @return mixed|MyArray|string
     */
    public static function findShopTableCatalog($dbObject, $shopID, $viewObjects, $viewObject, SitePageData $sitePageData,
                                                Model_Driver_DBBasicDriver $driver, array $params = array(), $elements = NULL,
                                                $isLoadView = TRUE){
        $params['table_id'] = $dbObject::TABLE_ID;
        return View_View::find(
            'DB_Shop_Table_Catalog', $shopID, $viewObjects, $viewObject, $sitePageData, $driver, $params,
            $elements, $isLoadView
        );
    }

    /**
     * Поиск рубрик записей
     * @param $dbObject
     * @param $shopID
     * @param $viewObjects
     * @param $viewObject
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @param array $params
     * @param null $elements
     * @param bool $isLoadView
     * @return mixed|MyArray|string
     */
    public static function findShopTableRubric($dbObject, $shopID, $viewObjects, $viewObject, SitePageData $sitePageData,
                                               Model_Driver_DBBasicDriver $driver, array $params = array(), $elements = NULL,
                                               $isLoadView = TRUE){
        $params['table_id'] = $dbObject::TABLE_ID;
        return View_View::find(
            'DB_Shop_Table_Rubric', $shopID, $viewObjects, $viewObject, $sitePageData, $driver, $params,
            $elements, $isLoadView
        );
    }

    /**
     * Поиск хэштегов записей
     * @param $dbObject
     * @param $shopID
     * @param $viewObjects
     * @param $viewObject
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @param array $params
     * @param null $elements
     * @param bool $isLoadView
     * @return mixed|MyArray|string
     */
    public static function findShopTableHashtag($dbObject, $shopID, $viewObjects, $viewObject, SitePageData $sitePageData,
                                                Model_Driver_DBBasicDriver $driver, array $params = array(), $elements = NULL,
                                                $isLoadView = TRUE){
        $params['table_id'] = $dbObject::TABLE_ID;
        return View_View::find(
            'DB_Shop_Table_Hashtag', $shopID, $viewObjects, $viewObject, $sitePageData, $driver, $params,
            $elements, $isLoadView
        );
    }

    /**
     * Поиск детворы записей
     * @param $dbObject
     * @param $shopID
     * @param $viewObjects
     * @param $viewObject
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @param array $params
     * @param null $elements
     * @param bool $isLoadView
     * @return mixed|MyArray|string
     */
    public static function findShopTableChild($dbObject, $shopID, $viewObjects, $viewObject, SitePageData $sitePageData,
                                              Model_Driver_DBBasicDriver $driver, array $params = array(), $elements = NULL,
                                              $isLoadView = TRUE){
        $params['table_id'] = $dbObject::TABLE_ID;
        return View_View::find(
            'DB_Shop_Table_Child', $shopID, $viewObjects, $viewObject, $sitePageData, $driver, $params,
            $elements, $isLoadView
        );
    }

    /**
     * Поиск брендов записей
     * @param $dbObject
     * @param $shopID
     * @param $viewObjects
     * @param $viewObject
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @param array $params
     * @param null $elements
     * @param bool $isLoadView
     * @return mixed|MyArray|string
     */
    public static function findShopTableBrand($dbObject, $shopID, $viewObjects, $viewObject, SitePageData $sitePageData,
                                              Model_Driver_DBBasicDriver $driver, array $params = array(), $elements = NULL,
                                              $isLoadView = TRUE){
        $params['table_id'] = $dbObject::TABLE_ID;
        return View_View::find(
            'DB_Shop_Table_Brand', $shopID, $viewObjects, $viewObject, $sitePageData, $driver, $params,
            $elements, $isLoadView
        );
    }

    /**
     * Поиск записей филиалов привязанных к хэштегу
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
    public static function findBranchByHashtag($dbObject, $shopID, $viewObjects, $viewObject, array $groupViews,
                                               SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver,
                                               array $params = array(), $elements = NULL, $isLoadView = TRUE){
        $groupParams = Arr::path($groupViews, 'params', array());

        if (Model_Memcache_ShopMemcacheDriver::IS_SAVE_MEMCACHE) {
            $tables = self::getTables($dbObject, $elements);
            $result = Helpers_DB::getMemcacheFunctionView(
                $shopID, $dbObject . '::findBranchByHashtag', $tables, $viewObjects, $sitePageData, $driver
            );
            if ($result !== NULL) {
                $sitePageData->replaceDatas['view::' . $viewObjects] = $result;
                return $result;
            }
        }

        // список id принадлежащих хэштегам
        $groupParams['root_table_id'] = $dbObject::TABLE_ID;
        $groupParams['child_table_id'] = Model_Shop_Table_Hashtag::TABLE_ID;

        $ids = Request_Request::findBranch(
            'DB_Shop_Table_Hashtag', array(), $sitePageData, $driver, $groupParams, Func::getLimit($groupParams),
            !$isLoadView, $elements
        );

        $model = DB_Basic::createModel($dbObject, $driver);

        if(count($ids->childs) > 0) {
            $params['id']['value'] = $ids->getChildArrayID();

            $ids = Request_Request::find(
                $dbObject, array(), $sitePageData, $driver, $params, Func::getLimit($params), !$isLoadView, $elements
            );

            foreach ($ids->childs as $child) {
                $child->str = Helpers_View::getViewObject(
                    $child, $model, $viewObject, $sitePageData, $driver, $child->values['shop_id'], TRUE,
                    $elements
                );
            }
        }

        $result = Helpers_View::getViewObjects(
            $ids, $model, $viewObjects, $viewObject, $sitePageData, $driver, 0, TRUE, $elements
        );
        $sitePageData->replaceDatas['view::'.$viewObjects] = $result;

        if (Model_Memcache_ShopMemcacheDriver::IS_SAVE_MEMCACHE) {
            Helpers_DB::setMemcacheFunctionView(
                $result, $shopID, $dbObject . '::findBranchByHashtag', $tables, $viewObjects, $sitePageData,
                $driver
            );
        }

        return $result;
    }

    /**
     * Поиск хэгетов c записями
     * @param $shopID
     * @param $viewObjects
     * @param $viewObject
     * @param array $groupViews
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @param array $params
     * @param null $elements
     * @param bool $isLoadView
     * @return MyArray|string
     * @throws Exception
     */
    public static function findShopTableHashtagWithObject($dbObject, $shopID, $viewObjects, $viewObject, array $groupViews,
                                                     SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver,
                                                     array $params = array(), $elements = NULL, $isLoadView = TRUE){

        $groupElements = Arr::path($groupViews, 'elements', NULL);
        $groupParams = Arr::path($groupViews, 'params', array());

        if (Model_Memcache_ShopMemcacheDriver::IS_SAVE_MEMCACHE) {
            $tables = self::getTables($dbObject, $elements);
            $result = Helpers_DB::getMemcacheFunctionView(
                $shopID, $dbObject . '::findShopTableHashtagWithObject', $tables, $viewObjects, $sitePageData,
                $driver
            );
            if ($result !== NULL) {
                $sitePageData->replaceDatas['view::' . $viewObjects] = $result;
                return $result;
            }
        }

        $ids = Request_Request::find(
            'DB_Shop_Table_Hashtag', $shopID, $sitePageData, $driver, $params, Func::getLimit($params),
            true, $elements
        );

        // получаем единицы измерения
        foreach($ids->childs as $child) {
            $child->additionDatas['ids'] = Request_Request::find(
                $dbObject, $shopID, $sitePageData, $driver,
                array_merge(
                    $groupParams,
                    array(
                        'shop_table_hashtag_id' => $child->id,
                    )
                ),
                Func::getLimit($groupParams), true, $groupElements
            );
        }

        if (!$isLoadView) {
            return $ids;
        }

        $model = DB_Basic::createModel($dbObject, $driver);

        // html  генерируем
        $list = $groupViews['list'];
        $one = $groupViews['one'];
        foreach($ids->childs as $child) {
            $child->additionDatas['view::'.$list] =
                Helpers_View::getViewObjects(
                    $child->additionDatas['ids'], $model, $list, $one, $sitePageData, $driver, $shopID,
                    TRUE, $groupElements
                );

            unset($child->additionDatas['ids']);
        }

        $model = new Model_Shop_Table_Hashtag();
        $model->setDBDriver($driver);
        $result = Helpers_View::getViewObjects(
            $ids, $model, $viewObjects, $viewObject, $sitePageData, $driver, $shopID, TRUE, $elements
        );
        $sitePageData->replaceDatas['view::'.$viewObjects] = $result;


        if (Model_Memcache_ShopMemcacheDriver::IS_SAVE_MEMCACHE) {
            Helpers_DB::setMemcacheFunctionView(
                $result, $shopID, $dbObject . '::findShopTableHashtagWithObject', $tables, $viewObjects,
                $sitePageData, $driver
            );
        }

        return $result;
    }

}