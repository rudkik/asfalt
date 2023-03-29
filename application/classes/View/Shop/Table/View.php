<?php defined('SYSPATH') or die('No direct script access.');

class View_Shop_Table_View extends View_View {

    /**
     * Поиск DB_ сгруппированных объектов
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
    public static function findByGroups($dbObject, $shopID, $viewObjects, $viewObject, SitePageData $sitePageData,
                                        Model_Driver_DBBasicDriver $driver,
                                        array $params = array(), $elements = NULL, $isLoadView = TRUE){
        $modelName = DB_Basic::getModelName($dbObject);
        
        $key = $tables = '';
        if (Model_Memcache_ShopMemcacheDriver::IS_SAVE_MEMCACHE) {
            $key = Helpers_DB::getURLParamDatas(array(), $params);
            $result = Helpers_DB::getMemcacheFunctionView(
                $shopID, 'View_Shop_Table_View::findByGroups', 
                array($modelName::TABLE_NAME, Model_Shop_Table_Group::TABLE_NAME),
                $viewObjects, $sitePageData, $driver, $key
            );
            if ($result !== NULL) {
                $sitePageData->replaceDatas['view::' . $viewObjects] = $result;
                return $result;
            }
        }

        $params['root_table_id'] = $modelName::TABLE_ID;
        $ids = Request_Shop_Table_Group::findShopChildIDs(
            $shopID, $sitePageData, $driver, $params, Func::getLimit($params)
        );
        if (!$isLoadView) {
            return $ids;
        }

        $model = new Model_Shop_Good();
        $model->setDBDriver($driver);
        $result = Helpers_View::getViewObjects(
            $ids, $model, $viewObjects, $viewObject, $sitePageData, $driver, $shopID, TRUE, $elements
        );

        $sitePageData->replaceDatas['view::' . $viewObjects] = $result;

        // записываем в мемкеш
        Helpers_DB::setMemcacheFunctionView(
            $result, $shopID, 'View_Shop_Table_View::findByGroups', 
            array($modelName::TABLE_NAME, Model_Shop_Table_Group::TABLE_NAME),
            $viewObjects, $sitePageData, $driver, $key
        );

        return $result;
    }

    /**
     * Поиск объектов и сгруппировать по рубрикам
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
    public static function findDBObjectGroupRubrics($dbObject, $shopID, $viewObjects, $viewObject, array $groupViews,
                                                    SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver,
                                                    array $params = array(), $elements = NULL, $isLoadView = TRUE){
        $modelName = DB_Basic::getModelName($dbObject);

        $groupElements = Arr::path($groupViews, 'elements', NULL);
        $groupParams = Arr::path($groupViews, 'params', array());

        if (Model_Memcache_ShopMemcacheDriver::IS_SAVE_MEMCACHE) {
            $tables = array_merge(self::getTables(Model_Shop_Table_Rubric::TABLE_NAME, $groupElements), self::getTables($modelName::TABLE_NAME, $elements));
            $key = Helpers_DB::getURLParamDatas(Request_Shop_Table_Rubric::getParamsList(), $groupParams). Helpers_DB::getURLParamDatas(Request_Shop_Good::getParamsList(), $params);
            $result = Helpers_DB::getMemcacheFunctionView($shopID, 'View_Shop_Table_View::findGroupRubric', $tables, $viewObjects, $sitePageData, $driver, $key);
            if ($result !== NULL) {
                $sitePageData->replaceDatas['view::' . $viewObjects] = $result;
                return $result;
            }
        }

        $ids = Request_Request::find(
            $dbObject, $shopID, $sitePageData, $driver, $groupParams, Func::getLimit($params), true
        );

        if(count($ids->childs) > 0) {
            // получаем рубрики
            $groupParams['id'] = $ids->getChildArrayValue('shop_table_rubric_id');
            $groupParams['table_id'] = Model_Shop_Good::TABLE_ID;
            $rubricIDs = Request_Request::find(
                DB_Shop_Table_Rubric::NAME, $shopID, $sitePageData, $driver, $params, 0, true
            );

            if (!$isLoadView) {
                return array(
                    'shop_news' => $ids,
                    'shop_table_rubrics' => $rubricIDs,
                );
            }

            // группируем по рубрикам
            foreach ($ids->childs as $child) {
                $rubric = $rubricIDs->findChild($child->values['shop_table_rubric_id']);
                if ($rubric == NULL) {
                    continue;
                }

                if (key_exists('ids', $rubric->additionDatas)) {
                    $rubric->additionDatas['ids'] = new MyArray();
                }
                $rubric->additionDatas['ids']->addChildObject($child);
            }

            $list = $groupViews['list'];
            $one = $groupViews['one'];

            $model = new Model_Shop_Good();
            $model->setDBDriver($driver);
            foreach ($rubricIDs->childs as $child) {
                $child->additionDatas['view::' . $list] =
                    Helpers_View::getViewObjects(
                        $child->additionDatas['ids'], $model, $list, $one, $sitePageData, $driver,
                        $shopID, TRUE, $groupElements
                    );
                unset($child->additionDatas['ids']);
            }
        }else{
            $rubricIDs = new MyArray();
            if (!$isLoadView) {
                return array(
                    'shop_goods' => $ids,
                    'shop_table_rubrics' => $rubricIDs,
                );
            }
        }

        $model = new $modelName();
        $model->setDBDriver($driver);
        $result = Helpers_View::getViewObjects(
            $rubricIDs, $model, $viewObjects, $viewObject, $sitePageData, $driver, $shopID, TRUE, $elements
        );

        $sitePageData->replaceDatas['view::'.$viewObjects] = $result;

        if (Model_Memcache_ShopMemcacheDriver::IS_SAVE_MEMCACHE) {
            Helpers_DB::setMemcacheFunctionView(
                $result, $shopID, 'View_Shop_Table_View::findGroupRubric', $tables, $viewObjects,
                $sitePageData, $driver, $key
            );
        }

        return $result;
    }

    /**
     * Поиск рубрик DB_
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
    public static function findRubrics($dbObject, $shopID, $viewObjects, $viewObject, SitePageData $sitePageData,
                                       Model_Driver_DBBasicDriver $driver,
                                       array $params = array(), $elements = NULL, $isLoadView = TRUE){
        $modelName = DB_Basic::getModelName($dbObject);
        $params['table_id'] = $modelName::TABLE_ID;
        return View_View::find(
            DB_Shop_Table_Rubric::NAME, $shopID, $viewObjects, $viewObject,
            $sitePageData, $driver, $params, $elements, $isLoadView
        );

    }

    /**
     * Поиск рубрик DB_ с детворой до третьего уровня
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
    public static function findWithChildTreeLevel($dbObject, $shopID, $viewObjects, $viewObject, array $groupViews,
                                                  SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver,
                                                  array $params = array(), $elements = NULL, $isLoadView = TRUE){
        $modelName = DB_Basic::getModelName($dbObject);
        $params['table_id'] = $modelName::TABLE_ID;
        return View_Shop_Table_Rubric::findWithChildTreeLevel(
            $dbObject, $shopID, $viewObjects, $viewObject,
            $groupViews, $sitePageData, $driver, $params, $elements, $isLoadView
        );

    }

    /**
     * Поиск категорий DB_
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
    public static function findCatalogs($dbObject, $shopID, $viewObjects, $viewObject, SitePageData $sitePageData,
                                                 Model_Driver_DBBasicDriver $driver,
                                                 array $params = array(), $elements = NULL, $isLoadView = TRUE){
        $modelName = DB_Basic::getModelName($dbObject);
        $params['table_id'] = $modelName::TABLE_ID;
        return View_View::find(
            DB_Shop_Table_Catalog::NAME, $shopID, $viewObjects, $viewObject,
            $sitePageData, $driver, $params, $elements, $isLoadView
        );

    }

    /**
     * Поиск рубрик DB_ с DB_
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
    public static function findRubricsWithDBObjects($dbObject, $shopID, $viewObjects, $viewObject, array $groupViews,
                                                    SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver,
                                                    array $params = array(), $elements = NULL, $isLoadView = TRUE){
        $modelName = DB_Basic::getModelName($dbObject);

        $groupElements = Arr::path($groupViews, 'elements', NULL);
        $groupParams = Arr::path($groupViews, 'params', array());

        if (Model_Memcache_ShopMemcacheDriver::IS_SAVE_MEMCACHE) {
            $tables = array_merge(self::getTables(Model_Shop_Table_Rubric::TABLE_NAME, $elements), self::getTables($modelName::TABLE_NAME, $groupElements));
            $key = Helpers_DB::getURLParamDatas(Model_Shop_Table_Rubric::getParamsList(), $params). Helpers_DB::getURLParamDatas($modelName::getParamsList(), $groupParams);
            $result = Helpers_DB::getMemcacheFunctionView($shopID, 'View_Shop_Table_View::findRubricsWithDBObjects', $tables, $viewObjects, $sitePageData, $driver, $key);
            if ($result !== NULL) {
                $sitePageData->replaceDatas['view::' . $viewObjects] = $result;
                return $result;
            }
        }

        $params['table_id'] = $modelName::TABLE_ID;
        $ids = Request_Request::find(
            DB_Shop_Table_Rubric::NAME, $shopID, $sitePageData, $driver, $params, Func::getLimit($params),
            !$isLoadView, $elements
        );

        if (Arr::path($params, 'is_main_rubric', FALSE)){
            $nameField = 'main_shop_table_rubric_id';
        }else{
            $nameField = 'shop_table_rubric_id';
        }

        // получаем товары
        foreach($ids->childs as $rubric) {
            $rubric->additionDatas['ids'] = Request_Request::find(
                'DB_Shop_Good',$shopID, $sitePageData, $driver,
                array_merge(
                    $groupParams,
                    array(
                        $nameField => $rubric->id,
                    )
                ),
                Func::getLimit($groupParams),
                !$isLoadView, $groupElements
            );
        }

        if (!$isLoadView) {
            return $ids;
        }

        $model = new $modelName();
        $model->setDBDriver($driver);

        // html  генерируем
        $list = $groupViews['list'];
        $one = $groupViews['one'];
        foreach($ids->childs as $child) {
            $child->additionDatas['view::'.$list] =
                Helpers_View::getViewObjects(
                    $child->additionDatas['ids'], $model, $list, $one, $sitePageData,
                    $driver, $shopID, TRUE, $groupElements
                );

            unset($child->additionDatas['ids']);
        }

        $model = new Model_Shop_Table_Rubric();
        $model->setDBDriver($driver);
        $result = Helpers_View::getViewObjects(
            $ids, $model, $viewObjects, $viewObject, $sitePageData, $driver,
            $shopID, TRUE, $elements
        );

        $sitePageData->replaceDatas['view::'.$viewObjects] = $result;

        if (Model_Memcache_ShopMemcacheDriver::IS_SAVE_MEMCACHE) {
            Helpers_DB::setMemcacheFunctionView(
                $result, $shopID, 'View_Shop_Table_View::findRubricsWithDBObjects',
                $tables, $viewObjects, $sitePageData, $driver, $key
            );
        }

        return $result;
    }

    /**
     * Поиск брендов DB_
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
    public static function findBrands($dbObject, $shopID, $viewObjects, $viewObject, SitePageData $sitePageData,
                                      Model_Driver_DBBasicDriver $driver,
                                               array $params = array(), $elements = NULL, $isLoadView = TRUE){
        $modelName = DB_Basic::getModelName($dbObject);
        $params['table_id'] = $modelName::TABLE_ID;
        return View_View::find(
            DB_Shop_Table_Brand::NAME, $shopID, $viewObjects, $viewObject,
            $sitePageData, $driver, $params, $elements, $isLoadView
        );
    }

    /**
     * Получение всех брендов DB_
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
    public static function findBrandAll($dbObject, $shopID, $viewObjects, $viewObject, SitePageData $sitePageData,
                                        Model_Driver_DBBasicDriver $driver,
                                        array $params = array(), $elements = NULL, $isLoadView = TRUE){
        $modelName = DB_Basic::getModelName($dbObject);
        $params = Request_RequestParams::setParams(
            ['table_id' => $modelName::TABLE_ID,]
        );
        return View_View::find(
            DB_Shop_Table_Brand::NAME, $shopID, $viewObjects, $viewObject,
            $sitePageData, $driver, $params, $elements, $isLoadView
        );
    }

    /**
     * Поиск единиц измерения DB_
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
    public static function findUnits($dbObject, $shopID, $viewObjects, $viewObject, SitePageData $sitePageData,
                                     Model_Driver_DBBasicDriver $driver,
                                     array $params = array(), $elements = NULL, $isLoadView = TRUE){
        $modelName = DB_Basic::getModelName($dbObject);
        $params['table_id'] = $modelName::TABLE_ID;
        return View_View::find(
            DB_Shop_Table_Unit::NAME, $shopID, $viewObjects, $viewObject,
            $sitePageData, $driver, $params, $elements, $isLoadView
        );
    }

    /**
     * Получение единиц измерения DB_
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
    public static function findUnitAll($dbObject, $shopID, $viewObjects, $viewObject, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver,
                                             array $params = array(), $elements = NULL, $isLoadView = TRUE){
        $modelName = DB_Basic::getModelName($dbObject);
        $params = Request_RequestParams::setParams(
            ['table_id' => $modelName::TABLE_ID,]
        );
        return View_View::find(
            DB_Shop_Table_Unit::NAME, $shopID, $viewObjects, $viewObject,
            $sitePageData, $driver, $params, $elements, $isLoadView
        );
    }

    /**
     * Получение хештегов DB_
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
    public static function getHashtagsByDBObject($dbObject, $shopID, $viewObjects, $viewObject, SitePageData $sitePageData,
                                                 Model_Driver_DBBasicDriver $driver,
                                                 array $params = array(), $elements = NULL, $isLoadView = TRUE){
        $modelName = DB_Basic::getModelName($dbObject);
        $key = $tables = '';
        if (Model_Memcache_ShopMemcacheDriver::IS_SAVE_MEMCACHE) {
            $tables = self::getTables($modelName::TABLE_NAME, $elements);
            $key = Helpers_DB::getURLParamDatas(Request_Shop_Good::getParamsOne(), $params)
                . Helpers_DB::getURLParamDatas(Request_Shop_Table_Hashtag::getParamsList(), $params);

            $result = Helpers_DB::getMemcacheFunctionView($shopID, 'View_Shop_Table_View::getHashtagsByDBObject', $tables, $viewObject, $sitePageData, $driver, $key);
            if ($result !== NULL) {
                $sitePageData->replaceDatas['view::' . $viewObject] = $result;
                return $result;
            }
        }

        $model = new $modelName();
        $model->setDBDriver($driver);
        $objectID = self::getShopObject($shopID, $model, $sitePageData, $params, $elements, 'Object not found!');

        $ids = Arr::path($objectID->values['shop_table_object_ids'], 'shop_table_hashtags', '');
        if (!empty($ids)) {
            unset($params['id']);
            $params['id']['value'] = $ids;
            $params[Request_RequestParams::IS_NOT_READ_REQUEST_NAME] = TRUE;

            $result = View_View::find(
                DB_Shop_Table_Hashtag::NAME, $shopID, $viewObjects, $viewObject,
                $sitePageData, $driver, $params, $elements, $isLoadView
            );
        }else {
            $result = '';
            $sitePageData->replaceDatas['view::'.$viewObjects] = $result;
        }

        if (Model_Memcache_ShopMemcacheDriver::IS_SAVE_MEMCACHE) {
            Helpers_DB::setMemcacheFunctionView(
                $result, $shopID, 'View_Shop_Table_View::getHashtagsByDBObject', $tables, $viewObject,
                $sitePageData, $driver, $key
            );
        }

        return $result;
    }

    /**
     * Поиск DB_ и возвращем список рубрик найденных DB_
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
     * @return array|mixed|MyArray|string
     */
    public static function findRubricsByDBObject($dbObject, $shopID, $viewObjects, $viewObject, SitePageData $sitePageData,
                                                 Model_Driver_DBBasicDriver $driver,
                                                 array $params = array(), $elements = NULL, $isLoadView = TRUE, $isLoadOneView = FALSE){
        $modelName = DB_Basic::getModelName($dbObject);
        $key = $tables = '';
        if (Model_Memcache_ShopMemcacheDriver::IS_SAVE_MEMCACHE) {
            $tables = array_merge(
                self::getTables($modelName::TABLE_NAME, $elements),
                self::getTables(Model_Shop_Table_Rubric::TABLE_NAME, $elements)
            );
            $key = Helpers_DB::getURLParamDatas(Request_Shop_Good::getParamsList(), $params);
            $result = Helpers_DB::getMemcacheFunctionView($shopID, 'View_Shop_Table_View::findRubricsByDBObject', $tables, $viewObjects, $sitePageData, $driver, $key);
            if ($result !== NULL) {
                $sitePageData->replaceDatas['view::' . $viewObjects] = $result;
                return $result;
            }
        }

        $ids = Request_Request::find(
            'DB_Shop_Good',$shopID, $sitePageData, $driver, $params, Func::getLimit($params), TRUE
        );

        $ids = $ids->getChildArrayInt('shop_table_rubric_id', TRUE);
        if (empty($ids)){
            $ids = new MyArray();
        }else {
            $params = array_merge(
                Arr::path($params, 'params_rubric', array()),
                Request_RequestParams::setParams(
                    array(
                        'id' => $ids,
                    )
                )
            );
            $ids = Request_Request::find(
                DB_Shop_Table_Rubric::NAME, $shopID, $sitePageData, $driver, $params, 0, !$isLoadView, $elements
            );
        }

        if (!$isLoadView) {
            return $ids;
        }

        $model = new Model_Shop_Table_Rubric();
        $model->setDBDriver($driver);
        $result = Helpers_View::getViewObjects(
            $ids, $model, $viewObjects, $viewObject, $sitePageData, $driver, $shopID, TRUE, $elements, $isLoadOneView
        );

        $sitePageData->replaceDatas['view::'.$viewObjects] = $result;

        if (Model_Memcache_ShopMemcacheDriver::IS_SAVE_MEMCACHE) {
            Helpers_DB::setMemcacheFunctionView(
                $result, $shopID, 'View_Shop_Table_View::findRubricsByDBObject', $tables, $viewObjects,
                $sitePageData, $driver, $key
            );
        }

        return $result;

    }

    /**
     * Поиск рубрик DB_ с детворой
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
     */
    public static function findAllWithChildTwoLevel($dbObject, $shopID, $viewObjects, $viewObject, array $groupViews,
                                                    SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver,
                                                    array $params = array(), $elements = NULL, $isLoadView = TRUE){
        $modelName = DB_Basic::getModelName($dbObject);
        $params['table_id'] = $modelName::TABLE_ID;
        return View_Shop_Table_Rubric::findAllWithChildTwoLevel(
            $dbObject, $shopID, $viewObjects, $viewObject, $groupViews, $sitePageData, $driver, $params, $elements, $isLoadView
        );

    }

    /**
     * Поиск брендов с рубриками
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
    public static function findShopTableBrandsWithRubrics($dbObject, $shopID, $viewObjects, $viewObject, array $groupViews, 
                                                          SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver,
                                                          array $params = array(), $elements = NULL, $isLoadView = TRUE){

        $params['is_list'] = TRUE;

        if (Model_Memcache_ShopMemcacheDriver::IS_SAVE_MEMCACHE) {
            $tables = self::getTables(Model_Shop_Table_Brand::TABLE_NAME, $elements);
            $key = Helpers_DB::getURLParamDatas(Request_Shop_Table_Rubric::getParamsList(), $params);
            $result = Helpers_DB::getMemcacheFunctionView($shopID, 'View_Shop_Table_View::findShopTableBrandsWithRubrics', $tables, $viewObjects, $sitePageData, $driver, $key);
            if ($result !== NULL) {
                $sitePageData->replaceDatas['view::' . $viewObjects] = $result;
                return $result;
            }
        }

        $ids = Request_Shop_Table_Brand::findShopTableBrandIDs($shopID, $sitePageData, $driver, $params,
            Func::getLimit($params),
            TRUE, $elements);

        // получаем детвору
        $groupParams = Arr::path($groupViews, 'params', '');
        $groupElements = Arr::path($groupViews, 'elements', '');
        foreach($ids->childs as $brand) {
            $brand->additionDatas['ids'] = Request_Shop_Table_Rubric::findShopTableRubricIDs($shopID, $sitePageData, $driver,
                array_merge(
                    $groupParams,
                    array(
                        'shop_table_brand_id' => $brand->id,
                        Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE,
                    )
                ),
                0, !$isLoadView, $groupElements);
        }

        if (!$isLoadView) {
            return $ids;
        }

        $model = new Model_Shop_Table_Rubric();
        $model->setDBDriver($driver);

        // html  генерируем
        $list = $groupViews['list'];
        $one = $groupViews['one'];
        foreach($ids->childs as $shopGoodRubricID) {
            $shopGoodRubricID->additionDatas['view::'.$list] =
                Helpers_View::getViewObjects($shopGoodRubricID->additionDatas['ids'], $model, $list, $one, $sitePageData, $driver, $shopID, TRUE, $elements);

            unset($shopGoodRubricID->additionDatas['ids']);
        }

        $model = new Model_Shop_Table_Brand();
        $model->setDBDriver($driver);
        $result = Helpers_View::getViewObjects($ids, $model, $viewObjects, $viewObject, $sitePageData, $driver, $shopID,
            TRUE, $elements);

        $sitePageData->replaceDatas['view::'.$viewObjects] = $result;

        if (Model_Memcache_ShopMemcacheDriver::IS_SAVE_MEMCACHE) {
            Helpers_DB::setMemcacheFunctionView($result, $shopID, 'View_Shop_Table_View::findShopTableBrandsWithRubrics', $tables, $viewObjects, $sitePageData, $driver, $key);
        }

        return $result;
    }
}