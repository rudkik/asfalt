
<?php defined('SYSPATH') or die('No direct script access.');

class View_Hotel_Shop_Room_Type extends View_View {
    /**
     * Выбор двух вариантов для заданного количества человек и срока
     * @param $shopID
     * @param $viewObjects
     * @param $viewObject
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @param array $params
     * @param null $elements
     * @param bool $isLoadView
     * @param bool $isLoadOneView
     * @return mixed|string
     */
    public static function selectionFreeRoomTypes($dbObject, $shopID, $viewObjects, $viewObject, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver,
                                              array $params = array(), $elements = NULL, $isLoadView = TRUE, $isLoadOneView = FALSE){
        if (Model_Memcache_ShopMemcacheDriver::IS_SAVE_MEMCACHE) {
            $tables = self::getTables(Model_Hotel_Shop_Room_Type::TABLE_NAME, $elements);
            $key = Helpers_DB::getURLParamDatas(Request_Request::getParamsList(), $params);
            $result = Helpers_DB::getMemcacheFunctionView($shopID, 'View_Hotel_Shop_Room_Type::selectionFreeRoomTypes', $tables, $viewObjects, $sitePageData, $driver, $key);
            if ($result !== NULL) {
                $sitePageData->replaceDatas['view::' . $viewObjects] = $result;
                return $result;
            }
        }

        $adults = Request_RequestParams::getParamInt('adults', $params);
        if($adults < 1){
            $adults = 1;
        }
        $childs = Request_RequestParams::getParamInt('childs', $params);
        if($childs < 0){
            $childs = 0;
        }
        $dateFrom = Request_RequestParams::getParamDateTime('date_from', $params);
        if($dateFrom === NULL){
            $dateFrom = date('Y-m-d');
        }
        $dateTo = Request_RequestParams::getParamDateTime('date_to', $params);
        if($dateTo === NULL){
            $dateTo = $dateFrom;
        }else{
            $dateTo = date('Y-m-d', strtotime($dateTo) - 60 * 60 * 24);
        }
        if ($dateTo < $dateFrom){
            $dateTo = $dateFrom;
        }

        // свободные номера на заданный период и количество человек
        $freeRoomTypeList = Api_Hotel_Shop_Room_Type::selectionFreeRoomTypes($adults, $childs, $dateFrom, $dateTo, $sitePageData, $driver);
        if (!$isLoadView) {
            return $freeRoomTypeList;
        }

        $result = '';
        foreach ($freeRoomTypeList as $key => $freeRooms) {
            $ids = new MyArray();
            foreach ($freeRooms['rooms'] as $freeRoom) {
                $ids->addChildObject($freeRoom);
            }
            $ids->additionDatas['amount'] = $freeRooms['amount'];
            $ids->additionDatas['date_from'] = $dateFrom;
            $ids->additionDatas['date_to'] = $dateTo;

            switch ($key){
                case 'min_amount':
                    $ids->additionDatas['is_min_amount'] = TRUE;
                    break;
                case 'min_room':
                    $ids->additionDatas['is_min_room'] = TRUE;
                    break;
            }

            $ids->addAdditionDataChilds(array('date_from' => $dateFrom, 'date_to' => $dateTo));

            $model = new Model_Hotel_Shop_Room_Type();
            $model->setDBDriver($driver);
            $result = $result . Helpers_View::getViewObjects($ids, $model, $viewObjects, $viewObject, $sitePageData, $driver, $shopID,
                TRUE, $elements, $isLoadOneView);
        }

        $sitePageData->replaceDatas['view::'.$viewObjects] = $result;

        if (Model_Memcache_ShopMemcacheDriver::IS_SAVE_MEMCACHE) {
            Helpers_DB::setMemcacheFunctionView($result, $shopID, 'View_Hotel_Shop_Room_Type::selectionFreeRoomTypes', $tables, $viewObjects, $sitePageData, $driver, $key);
        }

        return $result;
    }

    /**
     * Поиск свободных типов комнат для заданного срока
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
    public static function findFreeShopRoomTypes($dbObject, $shopID, $viewObjects, $viewObject, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver,
                                             array $params = array(), $elements = NULL, $isLoadView = TRUE, $isLoadOneView = FALSE){
        if (Model_Memcache_ShopMemcacheDriver::IS_SAVE_MEMCACHE) {
            $tables = self::getTables(Model_Hotel_Shop_Room_Type::TABLE_NAME, $elements);
            $key = Helpers_DB::getURLParamDatas(Request_Request::getParamsList(), $params);
            $result = Helpers_DB::getMemcacheFunctionView($shopID, 'View_Hotel_Shop_Room_Type::findFreeShopRoomTypes', $tables, $viewObjects, $sitePageData, $driver, $key);
            if ($result !== NULL) {
                $sitePageData->replaceDatas['view::' . $viewObjects] = $result;
                return $result;
            }
        }

        $ids = Request_Request::find('DB_Hotel_Room_Type', $shopID, $sitePageData, $driver, $params,
            Func::getLimit($params), !$isLoadView);

        $dateFrom = Request_RequestParams::getParamDateTime('date_from', $params);
        if($dateFrom === NULL){
            $dateFrom = date('Y-m-d');
        }
        $dateTo = Request_RequestParams::getParamDateTime('date_to', $params);
        if($dateTo === NULL){
            $dateTo = $dateFrom;
        }else{
            $dateTo = date('Y-m-d', strtotime($dateTo) - 60 * 60 * 24);
        }
        if ($dateTo < $dateFrom){
            $dateTo = $dateFrom;
        }

        $freeRoomIDs = Api_Hotel_Shop_Room::getFreeRooms(
            $dateFrom, $dateTo, $sitePageData, $driver, TRUE,
            array(
                'is_close' => Request_RequestParams::getParamBoolean('is_close'),
                Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE
            )
        );

        $freeRooms = array();
        foreach ($freeRoomIDs->childs as $child){
            $tmp = $child->values['shop_room_type_id'];
            if (!key_exists($tmp, $freeRooms)){
                $freeRooms[$tmp] = 0;
            }
            $freeRooms[$tmp]++;
        }

        foreach ($ids->childs as $key => $child){
            if (!key_exists($child->id, $freeRooms)){
                unset($ids->childs[$key]);
            }else{
                $child->additionDatas['count_free'] = $freeRooms[$child->id];
            }
        }

        if (!$isLoadView) {
            return $ids;
        }

        $model = new Model_Hotel_Shop_Room_Type();
        $model->setDBDriver($driver);
        $result = Helpers_View::getViewObjects($ids, $model, $viewObjects, $viewObject, $sitePageData, $driver, $shopID,
            TRUE, $elements, $isLoadOneView);

        $sitePageData->replaceDatas['view::'.$viewObjects] = $result;

        if (Model_Memcache_ShopMemcacheDriver::IS_SAVE_MEMCACHE) {
            Helpers_DB::setMemcacheFunctionView($result, $shopID, 'View_Hotel_Shop_Room_Type::findFreeShopRoomTypes', $tables, $viewObjects, $sitePageData, $driver, $key);
        }

        return $result;
    }
}