<?php defined('SYSPATH') or die('No direct script access.');

class Api_Shop_Table_ObjectToObject
{

    public static function del($shopRootObjectID, $tableID, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        $isUndel = Request_RequestParams::getParamBoolean("is_undel");

        $items = Request_Request::find('DB_Shop_Table_ObjectToObject', $sitePageData->shopID, $sitePageData, $driver,
            array('shop_root_object_id' => $shopRootObjectID, 'root_table_id' => $tableID, 'is_delete' => $isUndel,
                Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE), 0);

        $ids = array();
        $items->getArrayID($ids);

        if($isUndel === TRUE){
            $driver->unDeleteObjectIDs($ids, $sitePageData->userID, Model_Shop_Table_ObjectToObject::TABLE_NAME,
                array(), $sitePageData->shopID);
        }else {
            $driver->deleteObjectIDs($ids, $sitePageData->userID, Model_Shop_Table_ObjectToObject::TABLE_NAME,
                array(), $sitePageData->shopID);
        }
    }

    /**
     * Сохранение списка фильтров
     * @param $shopObjectID
     * @param $shopTableCatalogID
     * @param array $shopTableFilterIDs
     * @param $shopFilterCatalogID
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @return array
     */
    public static function saveToFilters($tableID, $shopObjectID, $shopTableCatalogID, array $shopTableFilterIDs, $shopFilterCatalogID,
                                         SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        $result = array();
        if(count($shopTableFilterIDs) > 20){
            return $result;
        }

        // считываем записи о связки товаров и атрибутов из базы данных
        $objectToObjectIDs = Request_Request::find('DB_Shop_Table_ObjectToObject', $sitePageData->shopID, $sitePageData, $driver,
            array('shop_root_object_id' => $shopObjectID, 'root_table_id' => $tableID, 'shop_root_catalog_id' => $shopTableCatalogID,
                'is_delete_ignore' => TRUE, Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE), 0, TRUE);

        $model = new Model_Shop_Table_ObjectToObject();
        $model->setDBDriver($driver);

        foreach($shopTableFilterIDs as $shopTableFilterID){
            if(! is_array($shopTableFilterID)){
                continue;
            }

            $rubricID = intval(Arr::path($shopTableFilterID, 'rubric', ''));
            if($rubricID < 1){
                continue;
            }

            $filterID = intval(Arr::path($shopTableFilterID, 'id', ''));
            if($filterID < 1){
                $name = strval(Arr::path($shopTableFilterID, 'name', ''));
                if(empty($name)) {
                    continue;
                }

                $filterID = Request_Request::findID(
                    'DB_Shop_Table_Filter', $sitePageData->shopID,
                    Request_RequestParams::setParams(
                        array(
                            'name_full' => $name,
                            'shop_table_catalog_id' => $shopFilterCatalogID,
                            'shop_table_rubric_id' => $rubricID,
                        )
                    ),
                    $sitePageData, $driver
                );
                if ($filterID < 1) {
                    $modelFilter = new Model_Shop_Table_Filter();
                    $modelFilter->setShopTableCatalogID($shopFilterCatalogID);
                    $modelFilter->setShopTableRubricID($rubricID);
                    $modelFilter->setName($name);

                    $filterID = Helpers_DB::saveDBObject($modelFilter, $sitePageData);
                }
            }

            $model->clear();
            $model->setShopRootObjectID($shopObjectID);
            $model->setShopRootCatalogID($shopTableCatalogID);
            $model->setRootTableID($tableID);
            $model->setChildTableID(Model_Shop_Table_Filter::TABLE_ID);
            $model->setShopChildCatalogID($shopFilterCatalogID);
            $model->setShopChildObjectID($filterID);
            $model->setIsDelete(FALSE);

            $objectToObjectID = array_pop($objectToObjectIDs->childs);
            if($objectToObjectID !== NULL){
                $model->id = $objectToObjectID->id;
                $model->globalID = $objectToObjectID->values['global_id'];
            }

            Helpers_DB::saveDBObject($model, $sitePageData);
            $result[] = $filterID;
        }

        $model->clear();
        foreach($objectToObjectIDs->childs as $objectToObjectID){
            $model->clear();
            $model->id = $objectToObjectID->id;
            $model->globalID = $objectToObjectID->values['global_id'];
            $model->setShopChildObjectID(0);
            Helpers_DB::saveDBObject($model, $sitePageData);

            $model->dbDelete($sitePageData->userID, 0, $sitePageData->shopID);
        }

        return $result;
    }

    /**
     * Сохранение списка хэштегов
     * @param $tableID
     * @param $shopObjectID
     * @param $shopTableCatalogID
     * @param array $shopTableHashtagIDs
     * @param $shopHashtagCatalogID
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @return array
     */
    public static function saveToHashtags($tableID, $shopObjectID, $shopTableCatalogID, array $shopTableHashtagIDs, $shopHashtagCatalogID,
                                         SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        $result = array();
        if(empty($shopTableHashtagIDs)){
            return $result;
        }

        // считываем записи о связки товаров и атрибутов из базы данных
        $objectToObjectIDs = Request_Request::find('DB_Shop_Table_ObjectToObject', $sitePageData->shopID, $sitePageData, $driver,
            array('shop_root_object_id' => $shopObjectID, 'root_table_id' => $tableID, 'shop_root_catalog_id' => $shopTableCatalogID,
                'is_delete_ignore' => TRUE, Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE), 0, TRUE);

        $model = new Model_Shop_Table_ObjectToObject();
        $model->setDBDriver($driver);

        foreach($shopTableHashtagIDs as $shopTableHashtagID){
            $shopTableHashtagID = intval($shopTableHashtagID);
            // возможно необходимо добавить новый элемент
            if($shopTableHashtagID < 1){
                if (!empty($shopTableHashtagID)) {
                    $modelHashtag = new Model_Shop_Table_Hashtag();
                    $modelHashtag->setDBDriver($driver);
                    $modelHashtag->setName($shopTableHashtagID);
                    $modelHashtag->setShopTableCatalogID($shopHashtagCatalogID);
                    $modelHashtag->setTableID($tableID);

                    $shopTableHashtagID = Helpers_DB::saveDBObject($modelHashtag, $sitePageData);
                }
            }

            $shopTableHashtagID = intval($shopTableHashtagID);
            if($shopTableHashtagID < 1){
                continue;
            }

            $model->clear();
            $model->setShopRootObjectID($shopObjectID);
            $model->setShopRootCatalogID($shopTableCatalogID);
            $model->setRootTableID($tableID);
            $model->setChildTableID(Model_Shop_Table_Hashtag::TABLE_ID);
            $model->setShopChildCatalogID($shopHashtagCatalogID);
            $model->setShopChildObjectID($shopTableHashtagID);
            $model->setIsDelete(FALSE);

            $objectToObjectID = array_pop($objectToObjectIDs->childs);
            if($objectToObjectID !== NULL){
                $model->id = $objectToObjectID->id;
                $model->globalID = $objectToObjectID->values['global_id'];
            }

            Helpers_DB::saveDBObject($model, $sitePageData);
            $result[] = $shopTableHashtagID;
        }

        $model->clear();
        foreach($objectToObjectIDs->childs as $objectToObjectID){
            $model->clear();
            $model->id = $objectToObjectID->id;
            $model->globalID = $objectToObjectID->values['global_id'];
            $model->setShopChildObjectID(0);
            Helpers_DB::saveDBObject($model, $sitePageData);

            $model->dbDelete($sitePageData->userID, 0, $sitePageData->shopID);
        }

        return $result;
    }
}