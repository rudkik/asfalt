<?php defined('SYSPATH') or die('No direct script access.');

class View_Shop_Table_Rubric extends View_View {

    /**
     * Получаем хлебные крошки для рубрики начиная с заданной рубрика
     * Последовательность сначала самая верхняя рубрика, последная заданная рубрика
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
     * @throws HTTP_Exception_404
     */
    public static function findBreadCrumbs($dbObject, $shopID, $viewObjects, $viewObject, SitePageData $sitePageData,
                                           Model_Driver_DBBasicDriver $driver, array $params = array(), $elements = NULL,
                                           $isLoadOneView = FALSE, $isLoadView = TRUE){
        if (Model_Memcache_ShopMemcacheDriver::IS_SAVE_MEMCACHE) {
            $tables = self::getTables($dbObject, $elements);
            $result = Helpers_DB::getMemcacheFunctionView(
                $shopID, $dbObject . '::findBreadCrumbs', $tables, $viewObjects, $sitePageData, $driver
            );
            if ($result !== NULL) {
                $sitePageData->replaceDatas['view::' . $viewObjects] = $result;
                return $result;
            }
        }

        $isNotReadRequest = Request_RequestParams::getIsNotReadRequest($params);
        $id = Request_RequestParams::getParamInt('id', $params, $isNotReadRequest);

        $objectID = Request_Request::findOneByID($dbObject, $id, $shopID, $sitePageData, $driver, $elements);
        if($objectID === null){
            if (Request_RequestParams::getParamBoolean('is_error_404', $params) === TRUE) {
                throw new HTTP_Exception_404('Object id="'.$id.'" not found.');
            } else {
                $objectID = new MyArray();
                $objectID->setIsFind(true);
            }
        }

        $model = DB_Basic::createModel($dbObject, $driver);

        $ids = new MyArray();
        if ($objectID->id > 0) {
            $list = array();
            $rootID = $objectID->values['root_id'];

            $arr = array();
            $n = 0;
            while (($rootID > 0) && ($n < 10) && (!key_exists($rootID, $arr))) {
                $child = new MyArray();
                $child->id = $rootID;
                if (!Helpers_View::getDBData($child, $model, $sitePageData, $shopID, $elements)) {
                    break;
                }
                $rootID = $child->values['root_id'];
                $list[] = $child;

                $arr[$rootID] = '';
                $n++;
            }

            for ($i = count($list) - 1; $i > -1; $i--) {
                $ids->addChildObject($list[$i]);
            }
            $ids->addChildObject($objectID);
        }

        if (!$isLoadView) {
            return $ids;
        }

        $result = Helpers_View::getViewObjects(
            $ids, $model, $viewObjects, $viewObject, $sitePageData, $driver, $shopID, TRUE, $elements, $isLoadOneView
        );
        $sitePageData->addReplaceAndGlobalDatas('view::'.$viewObjects,  $result);

        if (Model_Memcache_ShopMemcacheDriver::IS_SAVE_MEMCACHE) {
            Helpers_DB::setMemcacheFunctionView(
                $result, $shopID, $dbObject . '::findBreadCrumbs', $tables, $viewObjects, $sitePageData, $driver
            );
        }

        return $result;
    }

    /**
     * Поиск рубрик с детворой
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
    public static function findAllWithChildTwoLevel($dbObject, $shopID, $viewObjects, $viewObject, array $groupViews,
                                                    SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver,
                                                    array $params = array(), $elements = NULL, $isLoadView = TRUE){

        $params['is_list'] = TRUE;

        if (Model_Memcache_ShopMemcacheDriver::IS_SAVE_MEMCACHE) {
            $tables = self::getTables($dbObject, $elements);
            $result = Helpers_DB::getMemcacheFunctionView(
                $shopID, $dbObject . '::findAllWithChildTwoLevel', $tables, $viewObject, $sitePageData, $driver
            );
            if ($result !== NULL) {
                $sitePageData->replaceDatas['view::' . $viewObjects] = $result;
                return $result;
            }
        }

        $oneRubrics = Request_Request::find(
            DB_Shop_Table_Rubric::NAME, $shopID, $sitePageData, $driver, $params, Func::getLimit($params), TRUE, $elements
        );

        // получаем детвору
        $groupParams = Arr::path($groupViews, 'params', '');
        $groupElements = Arr::path($groupViews, 'elements', '');

        $two = $oneRubrics->getChildArrayID();
        if(!empty($two)) {
            $twoRubrics = Request_Request::find(
                DB_Shop_Table_Rubric::NAME, $shopID, $sitePageData, $driver,
                array_merge(
                    $groupParams,
                    array(
                        'root_id' => $two,
                        'is_list' => TRUE,
                        Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE,
                    )
                ),
                0, !$isLoadView, $groupElements
            );
        }else{
            $twoRubrics = new MyArray();
        }

        // получаем индекс
        $index = $oneRubrics->getIndexChildIDs();

        // третий уровень
        foreach ($twoRubrics->childs as $child){
            $oneRubric = $oneRubrics->childs[$index[$child->values['root_id']]];
            if(!key_exists('ids', $oneRubric->additionDatas)){
                $oneRubric->additionDatas['ids'] = new MyArray();
            }
            $oneRubric->additionDatas['ids']->addChildObject($child);
        }

        if (!$isLoadView) {
            return $oneRubrics;
        }

        $model = DB_Basic::createModel($dbObject, $driver);

        // html генерируем
        $list = $groupViews['list'];
        $one = $groupViews['one'];
        foreach($oneRubrics->childs as $shopGoodRubricID) {
            if(!key_exists('ids', $shopGoodRubricID->additionDatas)){
                $shopGoodRubricID->additionDatas['ids'] = new MyArray();
            }

            $shopGoodRubricID->additionDatas['view::'.$list] =  Helpers_View::getViewObjects(
                $shopGoodRubricID->additionDatas['ids'], $model, $list, $one, $sitePageData,
                $driver, $shopID, TRUE, $groupElements
            );

            unset($shopGoodRubricID->additionDatas['ids']);
        }

        $result = Helpers_View::getViewObjects(
            $oneRubrics, $model, $viewObjects, $viewObject, $sitePageData, $driver, $shopID, TRUE, $elements
        );

        $sitePageData->replaceDatas['view::'.$viewObjects] = $result;

        if (Model_Memcache_ShopMemcacheDriver::IS_SAVE_MEMCACHE) {
            Helpers_DB::setMemcacheFunctionView(
                $result, $shopID, $dbObject . '::findAllWithChildTwoLevel', $tables, $viewObjects, $sitePageData, $driver
            );
        }
        return $result;
    }

    /**
     * Поиск рубрик с детворой и детворой детворы (3 уровня)
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
        $params['is_list'] = TRUE;

        if (Model_Memcache_ShopMemcacheDriver::IS_SAVE_MEMCACHE) {
            $tables = self::getTables($dbObject, $elements);
            $result = Helpers_DB::getMemcacheFunctionView(
                $shopID, $dbObject . '::findWithChildTreeLevel', $tables, $viewObject, $sitePageData, $driver
            );
            if ($result !== NULL) {
                $sitePageData->replaceDatas['view::' . $viewObjects] = $result;
                return $result;
            }
        }


        // первый уровень
        $oneRubrics = Request_Request::find(
            DB_Shop_Table_Rubric::NAME, $shopID, $sitePageData, $driver, $params, Func::getLimit($params), TRUE, $elements
        );

        // получаем детвору
        $groupParams = Arr::path($groupViews, 'params', '');
        $groupElements = Arr::path($groupViews, 'elements', '');

        $groupChildParams = Arr::path($groupViews, 'group.params', '');
        $groupChildElements = Arr::path($groupViews, 'group.elements', '');

        $isAddGoods = Arr::path(
            $groupChildParams, 'is_add_goods.value', Arr::path($groupChildParams, 'is_add_goods', FALSE)
        );

        $isLoadGoods = $isAddGoods
            || Arr::path(
                $groupChildParams, 'id_load_goods_not_rubric.value',
                Arr::path($groupChildParams, 'id_load_goods_not_rubric', FALSE)
            );

        // второй уровень
        $two = $oneRubrics->getChildArrayID();
        if(!empty($two)) {
            $twoRubrics = Request_Request::find(
                DB_Shop_Table_Rubric::NAME, $shopID, $sitePageData, $driver,
                array_merge(
                    $groupParams,
                    array(
                        'root_id' => $two,
                        'is_list' => TRUE,
                        Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE,
                    )
                ),
                0, !$isLoadView, $groupElements
            );
        }else{
            $twoRubrics = new MyArray();
        }
        // третий уровень
        $tree = $twoRubrics->getChildArrayID();
        if(!empty($tree)) {
            $treeRubrics = Request_Request::find(
                DB_Shop_Table_Rubric::NAME, $shopID, $sitePageData,
                $driver,
                array_merge(
                    $groupChildParams,
                    array(
                        'root_id' => $tree,
                        'is_list' => TRUE,
                        Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE,
                    )
                ),
                0, !$isLoadView, $groupChildElements
            );

            if ($isLoadGoods || $isAddGoods){
                $treeGoods = Request_Request::find(
                    'DB_Shop_Good', $shopID, $sitePageData,
                    $driver,
                    array_merge(
                        $groupChildParams,
                        array(
                            'shop_table_rubric_id' => $tree,
                            Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE,
                        )
                    ),
                    0, !$isLoadView, $groupChildElements);
            }else{
                $treeGoods = new MyArray();
            }
        }else{
            $treeRubrics = new MyArray();
            $treeGoods = new MyArray();
        }

        /** строим дерево уровней **/

        // третий уровень
        $index = $twoRubrics->getIndexChildIDs();
        foreach ($treeRubrics->childs as $child){
            $rootID = $child->values['root_id'];
            if(!key_exists($rootID, $index)){
                continue;
            }
            $twoRubric = $twoRubrics->childs[$index[$rootID]];
            if(!key_exists('ids', $twoRubric->additionDatas)){
                $twoRubric->additionDatas['ids'] = new MyArray();
            }
            $twoRubric->additionDatas['ids']->addChildObject($child);
        }
        if ($isLoadGoods) {
            // находим рубрики, куда нужно добавить продукцию
            foreach ($twoRubrics->childs as $child){
                if(! key_exists('ids', $child->additionDatas)){
                    $child->additionDatas['ids'] = new MyArray();
                }
                $child->additionDatas['good_ids'] = new MyArray();

                $child->additionDatas['is_good'] = $isAddGoods || (count($child->additionDatas['ids']->childs) == 0);
            }

            foreach ($treeGoods->childs as $child) {
                $twoRubric = $twoRubrics->childs[$index[$child->values['shop_table_rubric_id']]];
                if($twoRubric->additionDatas['is_good']){
                    $twoRubric->additionDatas['good_ids']->addChildObject($child);
                }
            }
        }

        // второй уровень
        $index = $oneRubrics->getIndexChildIDs();
        foreach ($twoRubrics->childs as $child){
            $oneRubric = $oneRubrics->childs[$index[$child->values['root_id']]];
            if(!key_exists('ids', $oneRubric->additionDatas)){
                $oneRubric->additionDatas['ids'] = new MyArray();
            }
            $oneRubric->additionDatas['ids']->addChildObject($child);
        }

        if (!$isLoadView) {
            return $oneRubrics;
        }

        $model = DB_Basic::createModel($dbObject, $driver);

        $model = DB_Basic::createModel('DB_Shop_Good', $driver);

        // html  генерируем
        $list = $groupViews['list'];
        $one = $groupViews['one'];

        $listChild = Arr::path($groupViews, 'group.list', '');
        $oneChild = Arr::path($groupViews, 'group.one', '');
        foreach($oneRubrics->childs as $oneRubric) {
            if (!key_exists('ids', $oneRubric->additionDatas)) {
                $oneRubric->additionDatas['ids'] = new MyArray();
            }

            foreach($oneRubric->additionDatas['ids']->childs as $twoRubric) {

                if ($twoRubric->additionDatas['is_good']){
                    $twoRubric->additionDatas['ids']->childs = array_merge(
                        $twoRubric->additionDatas['ids']->childs,
                        $twoRubric->additionDatas['good_ids']->childs
                    );
                }

                $modelElement = $model;
                $twoRubric->additionDatas['view::' . $listChild] =
                    Helpers_View::getViewObjects($twoRubric->additionDatas['ids'], $modelElement, $listChild, $oneChild,
                        $sitePageData, $driver, $shopID, TRUE, $groupChildElements);
                unset($twoRubric->additionDatas['ids']);
                unset($twoRubric->additionDatas['goods_ids']);
            }

            $oneRubric->additionDatas['view::'.$list] =
                Helpers_View::getViewObjects($oneRubric->additionDatas['ids'], $model, $list, $one, $sitePageData,
                    $driver, $shopID, TRUE, $groupElements);

            unset($oneRubric->additionDatas['ids']);
        }

        $result = Helpers_View::getViewObjects(
            $oneRubrics, $model, $viewObjects, $viewObject, $sitePageData, $driver, $shopID, TRUE, $elements
        );
        $sitePageData->replaceDatas['view::'.$viewObjects] = $result;

        if (Model_Memcache_ShopMemcacheDriver::IS_SAVE_MEMCACHE) {
            Helpers_DB::setMemcacheFunctionView(
                $result, $shopID, $dbObject . '::findWithChildTreeLevel', $tables, $viewObjects, $sitePageData, $driver
            );
        }

        return $result;
    }
}