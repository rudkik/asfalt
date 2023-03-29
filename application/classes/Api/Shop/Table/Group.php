<?php defined('SYSPATH') or die('No direct script access.');

class Api_Shop_Table_Group
{

    public static function del($shopRootObjectID, $tableID, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        $isUndel = Request_RequestParams::getParamBoolean("is_undel");

        $items = Request_Request::find('DB_Shop_Table_Group', $sitePageData->shopID, $sitePageData, $driver,
            array('shop_root_object_id' => $shopRootObjectID, 'root_table_id' => $tableID, 'is_delete' => $isUndel,
                Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE), 0);

        $ids = array();
        $items->getArrayID($ids);

        if($isUndel === TRUE){
            $driver->unDeleteObjectIDs($ids, $sitePageData->userID, Model_Shop_Table_Group::TABLE_NAME,
                array(), $sitePageData->shopID);
        }else {
            $driver->deleteObjectIDs($ids, $sitePageData->userID, Model_Shop_Table_Group::TABLE_NAME,
                array(), $sitePageData->shopID);
        }
    }

    /**
     * Сохранение списка сгруппированных объетов
     * @param $shopObjectID
     * @param $shopTableCatalogID
     * @param array $shopTableFilterIDs
     * @param $shopFilterCatalogID
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @return array
     */
    public static function saveList($tableID, $shopObjectID, $shopTableCatalogID, array $shopTableGroupIDs,
                                       SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        $result = array();
        if(count($shopTableGroupIDs) > 20){
            return $result;
        }

        // считываем записи о связки товаров и атрибутов из базы данных
        $groupIDs = Request_Request::find('DB_Shop_Table_Group', $sitePageData->shopID, $sitePageData, $driver,
            array('shop_root_object_id' => $shopObjectID, 'root_table_id' => $tableID, 'shop_root_catalog_id' => $shopTableCatalogID,
                'is_delete_ignore' => TRUE, Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE), 0, TRUE);

        $model = new Model_Shop_Table_Group();
        $model->setDBDriver($driver);

        foreach($shopTableGroupIDs as $shopTableGroupID){
            $shopTableGroupID = intval($shopTableGroupID);
            if($shopTableGroupID < 1){
                continue;
            }

            $model->clear();
            $model->setShopRootObjectID($shopObjectID);
            $model->setShopRootCatalogID($shopTableCatalogID);
            $model->setRootTableID($tableID);
            $model->setShopChildObjectID($shopTableGroupID);
            $model->setIsDelete(FALSE);

            $groupID = array_pop($groupIDs->childs);
            if($groupID !== NULL){
                $model->id = $groupID->id;
                $model->globalID = $groupID->values['global_id'];
            }

            Helpers_DB::saveDBObject($model, $sitePageData);
            $result[] = $shopTableGroupID;
        }

        $model->clear();
        foreach($groupIDs->childs as $groupID){
            $model->clear();
            $model->id = $groupID->id;
            $model->globalID = $groupID->values['global_id'];
            $model->setShopChildObjectID(0);
            Helpers_DB::saveDBObject($model, $sitePageData);

            $model->dbDelete($sitePageData->userID, 0, $sitePageData->shopID);
        }

        return $result;
    }
}