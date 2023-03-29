<?php defined('SYSPATH') or die('No direct script access.');

class Api_Shop_GoodCatalog {

    /**
     * удаление категории
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @return bool
     * @throws HTTP_Exception_500
     */
    public static function delShopGoodCatalog(SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        $id = Request_RequestParams::getParamInt('id');
        if($id < 0){
            return FALSE;
        }

        $model = new Model_Shop_Table_Rubric();
        $model->setDBDriver($driver);

        if (!Helpers_DB::dublicateObjectLanguage($model, $id, $sitePageData)) {
            throw new HTTP_Exception_500('Goods catalog not found.');
        }

        if(Request_RequestParams::getParamBoolean("is_undel") === TRUE){
            $model->dbUnDelete($sitePageData->userID, 0, $sitePageData->shopID);
        }else {
            $model->dbDelete($sitePageData->userID, 0, $sitePageData->shopID);
        }

        // пересчитываем количество товаров на складе
        Api_Shop_GoodCatalog::countUpStorageShopGoodCatalog($model->getRootID(), $sitePageData, $driver);
    }

    /**
     * Пересчитываем количество товаров у каталога
     * @param $shopGoodCatalogID
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @return bool
     */
    public static function countUpStorageShopGoodCatalog($shopGoodCatalogID, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver){
        if($shopGoodCatalogID < 1){
            return TRUE;
        }

        $storageCount = floatval(Request_Shop_GoodCatalog::getShopGoodStorageCount($sitePageData->shopID, $shopGoodCatalogID,
                $sitePageData, $driver));

        $modelCatalog = new Model_Shop_Table_Rubric();
        $modelCatalog->setDBDriver($driver);
        if (!Helpers_DB::getDBObject($modelCatalog, $shopGoodCatalogID, $sitePageData)) {
            return TRUE;
        }

        // разницу узнаем в количестве
        $shiftStorageCount = $storageCount - $modelCatalog->getStorageCount();
        if ($shiftStorageCount == 0) {
            return TRUE;
        }

        $modelCatalog->setStorageCount($storageCount);
        Helpers_DB::saveDBObject($modelCatalog, $sitePageData, $sitePageData->shopID);
        $shopGoodCatalogID = $modelCatalog->getRootID();

        $i = 0;
        while(($shopGoodCatalogID > 0) && ($i < 50)){
            if (!Helpers_DB::getDBObject($modelCatalog, $shopGoodCatalogID, $sitePageData)){
                return TRUE;
            }
            $modelCatalog->setStorageCount($modelCatalog->getStorageCount() + $shiftStorageCount);
            Helpers_DB::saveDBObject($modelCatalog, $sitePageData, $sitePageData->shopID);

            $shopGoodCatalogID = $modelCatalog->getRootID();
            $i++;
        }
    }

}
