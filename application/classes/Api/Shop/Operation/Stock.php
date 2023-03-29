<?php defined('SYSPATH') or die('No direct script access.');

class Api_Shop_Operation_Stock
{
    public static function save(SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        $model = new Model_Shop_Operation_Stock();
        $model->setDBDriver($driver);

        $id = Request_RequestParams::getParamInt('id');
        if (!Helpers_DB::dublicateObjectLanguage($model, $id, $sitePageData)) {
            throw new HTTP_Exception_500('Operation stock not found.');
        }

        $options = Request_RequestParams::getParamArray('options');
        if($options !== NULL){
            $model->addOptionsArray($options);
        }

        Request_RequestParams::setParamInt('shop_operation_id', $model);

        $result = array();
        if ($model->validationFields($result)) {
            $amountOld = $model->getAmount();
            // сохранение изменений в списке заказа
            Api_Shop_Operation_Stock_Item::saveShopOperationStockItems($model, $sitePageData, $driver);

            Helpers_DB::saveDBObject($model, $sitePageData);

            $result['values'] = $model->getValues();
        }

        return array(
            'id' => $model->id,
            'type' => $model->getShopTableCatalogID(),
            'result' => $result,
        );
    }

    /**
     * удаление заказа
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @return bool
     * @throws HTTP_Exception_500
     */
    public static function delete(SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        $id = Request_RequestParams::getParamInt('id');
        if($id < 0){
            return FALSE;
        }

        $model = new Model_Shop_Operation_Stock();
        $model->setDBDriver($driver);

        if (!Helpers_DB::dublicateObjectLanguage($model, $id, $sitePageData)) {
            throw new HTTP_Exception_500('Operation stock not found.');
        }

        $isUnDel = Request_RequestParams::getParamBoolean("is_undel");
        if((($isUnDel === TRUE) && (!$model->getIsDelete()))
            || (($isUnDel !== TRUE) && ($model->getIsDelete()))){
            return FALSE;
        }

        if($isUnDel === TRUE){
            $model->dbUnDelete($sitePageData->userID, 0, $sitePageData->shopID);

            $shopOperationStockItemIDs = Request_Request::find('DB_Shop_Operation_Stock_Item', $sitePageData->shopID, $sitePageData, $driver,
                array('shop_operation_stock_id' => $id, 'is_delete' => 1, Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE))->getChildArrayID();
            $driver->unDeleteObjectIDs($shopOperationStockItemIDs, $sitePageData->userID,
                Model_Shop_Operation_Stock_Item::TABLE_NAME, array(), $sitePageData->shopID);
        }else {
            $model->dbDelete($sitePageData->userID, 0, $sitePageData->shopID);

            $shopOperationStockItemIDs = Request_Request::find('DB_Shop_Operation_Stock_Item', $sitePageData->shopID, $sitePageData, $driver,
                array('shop_operation_stock_id' => $id, Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE))->getChildArrayID();
            $driver->deleteObjectIDs($shopOperationStockItemIDs, $sitePageData->userID,
                Model_Shop_Operation_Stock_Item::TABLE_NAME, array(), $sitePageData->shopID);
        }

        return TRUE;
    }

    /**
     * Формирование отчета по филиалам сгруппированным по заказах
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @throws Exception
     */
    public static function reportShopGroupByOperationStockAmount(SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver, $isBranch = FALSE,
                                           $viewObjects = '_shop/operation/stock/list/save/group-by-operation-stock-amount', $viewObject = '_shop/operation/stock/one/save/group-by-operation-stock-amount',
                                           $groupBy = array('shop_id'), $sortBy = array('shop_id' => 'asc')) {
        if($isBranch) {
            $shopIDs = Request_Shop::getBranchShopIDs($sitePageData->shopID, $sitePageData, $driver);
        }else{
            $shopIDs = Request_Request::findNotShop('DB_Shop',$sitePageData, $driver,
                array('main_shop_id' => $sitePageData->shopMainID, 'shop_root_id' => $sitePageData->shopID, Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE));
            $shopIDs->addChild($sitePageData->shopID);
        }
        $shopIDs = $shopIDs->getChildArrayID();

        // получаем список ID заказов
        $shopOperationStockIDs = Request_Request::findBranch('DB_Shop_Operation_Stock', $shopIDs, $sitePageData,
            $driver, array('group_by' => $groupBy, 'sort_by' => $sortBy));


        $model = new Model_Shop_Operation_Stock();
        $model->setDBDriver($driver);

        foreach($shopOperationStockIDs->childs as $shopOperationStockID){
            if(key_exists('shop_id', $shopOperationStockID->values)){
                $shopID = $shopOperationStockID->values['shop_id'];
            }else{
                $shopID = 0;
            }

            Helpers_View::getViewObject($shopOperationStockID, $model,
                $viewObject, $sitePageData, $driver,
                $shopID, TRUE, $groupBy);
        }

        $datas = Helpers_View::getViewObjects($shopOperationStockIDs, $model,
            $viewObjects, $viewObject, $sitePageData, $driver,
            0);

        $datas = '<?xml version="1.0"?>'."\r\n".'<?mso-application progid="Excel.Sheet"?>'.$datas;
        header('Content-Description: File Transfer');
        header('Content-Type: application/excel');
        header('Content-Disposition: filename=save.xls');
        header('Content-Transfer-Encoding: binary');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . strlen($datas));

        echo $datas;
        exit;
    }
}