<?php defined('SYSPATH') or die('No direct script access.');

class Api_Shop_Table_Rubric_Object
{

    public static function del($shopObjectID, $tableID, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        $isUndel = Request_RequestParams::getParamBoolean("is_undel");

        $params = Request_RequestParams::setParams(
            array(
                'shop_object_id' => $shopObjectID,
                'object_table_id' => $tableID,
                'is_delete' => $isUndel,
            )
        );
        if($isUndel){
            $params['is_public'] = 2;
        }
        $items = Request_Request::find('DB_Shop_Table_Rubric_Object',
            $sitePageData->shopID, $sitePageData, $driver, $params, 0
        );

        $ids = array();
        $items->getArrayID($ids);

        if($isUndel === TRUE){
            $driver->unDeleteObjectIDs(
                $ids, $sitePageData->userID, Model_Shop_Table_Rubric_Object::TABLE_NAME,
                array('is_public' => 1), $sitePageData->shopID
            );
        }else {
            $driver->deleteObjectIDs(
                $ids, $sitePageData->userID, Model_Shop_Table_Rubric_Object::TABLE_NAME,
                array('is_public' => 2), $sitePageData->shopID
            );
        }
    }

    /**
     * Сохранение списка
     * @param Model_Shop_Table_Basic_Table $modelObject
     * @param array $shopTableRubricIDs
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @return array
     */
    public static function save(Model_Shop_Table_Basic_Table $modelObject, array $shopTableRubricIDs,
                                         SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        $params = Request_RequestParams::setParams(
            array(
                'shop_object_id' => $modelObject->id,
                'object_table_id' => $modelObject->tableID,
                'shop_table_catalog_id' => $modelObject->getShopTableCatalogID(),
            )
        );
        // считываем записи о связки товаров и атрибутов из базы данных
        $rubricObjectIDs = Request_Request::find('DB_Shop_Table_Rubric_Object',
            $sitePageData->shopID, $sitePageData, $driver, $params, 0, TRUE
        );

        $basic = $modelObject->getShopTableRubricID();

        $model = new Model_Shop_Table_Rubric_Object();
        $model->setDBDriver($driver);

        $result = array();
        foreach($shopTableRubricIDs as $shopTableRubricID){
            if(!is_numeric($shopTableRubricID)){
                continue;
            }
            $shopTableRubricID = intval($shopTableRubricID);
            if($shopTableRubricID < 1){
                continue;
            }

            $tmp = array_shift($rubricObjectIDs->childs);
            if($tmp !== NULL){
                $tmp->setModel($model);
            }else{
                $model->clear();
            }

            $model->setShopObjectID($modelObject->id);
            $model->setObjectTableID($modelObject->tableID);
            $model->setShopTableCatalogID($modelObject->getShopTableCatalogID());
            $model->setShopTableRubricID($shopTableRubricID);

            $modelObject->setShopTableRubricID($shopTableRubricID);
            $model->setNameURL(Helpers_URL::getNameURL($modelObject));

            Helpers_DB::saveDBObject($model, $sitePageData);
            $result[$shopTableRubricID] = array(
                'shop_table_rubric_id' => $shopTableRubricID,
                'name_url' => $model->getNameURL(),
            );
        }
        $modelObject->setShopTableRubricID($basic);

        // удаляем лишние
        $driver->deleteObjectIDs(
            $rubricObjectIDs->getChildArrayID(), $sitePageData->userID,
            Model_Shop_Table_Rubric_Object::TABLE_NAME,
            array(), $sitePageData->shopID
        );

        return $result;
    }
}