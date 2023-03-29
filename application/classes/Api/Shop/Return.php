<?php defined('SYSPATH') or die('No direct script access.');

class Api_Shop_Return
{
    public static function save(SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        $model = new Model_Shop_Return();
        $model->setDBDriver($driver);

        $id = Request_RequestParams::getParamInt('id');
        if (!Helpers_DB::dublicateObjectLanguage($model, $id, $sitePageData)) {
            throw new HTTP_Exception_500('Return not found.');
        }

        $options = Request_RequestParams::getParamArray('options');
        if($options !== NULL){
            $model->addOptionsArray($options);

            $name = trim(Arr::path($options, 'first_name').' '.Arr::path($options, 'last_name').' '.Arr::path($options, 'name'));
            $model->setName($name);
        }

        $result = array();
        if ($model->validationFields($result)) {
            $amountOld = $model->getAmount();
            // сохранение изменений в списке заказа
            Api_Shop_Return_Item::saveShopReturnItems($model, $sitePageData, $driver);

            if(($model->getShopRootID() > 0) && ($model->getAmount() !== $amountOld)){
                $modelShop = new Model_Shop();
                $modelShop->setDBDriver($driver);

                // редактируем баланс
                if (Helpers_DB::getDBObject($modelShop, $model->getShopRootID(), $sitePageData)) {
                    $modelShop->setBalance($modelShop->getBalance() - $amountOld + $model->getAmount());
                    Helpers_DB::saveDBObject($modelShop, $sitePageData);
                }
            }

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

        $model = new Model_Shop_Return();
        $model->setDBDriver($driver);
        if (!Helpers_DB::dublicateObjectLanguage($model, $id, $sitePageData)) {
            throw new HTTP_Exception_500('Return not found.');
        }

        $isUnDel = Request_RequestParams::getParamBoolean("is_undel");
        if((($isUnDel === TRUE) && (!$model->getIsDelete()))
            || (($isUnDel !== TRUE) && ($model->getIsDelete()))){
            return FALSE;
        }

        if(($model->getShopRootID() > 0) && ($model->getAmount() != 0)){
            $modelShop = new Model_Shop();
            $modelShop->setDBDriver($driver);

            // редактируем баланс
            if (Helpers_DB::getDBObject($modelShop, $model->getShopRootID(), $sitePageData)) {
                if(Request_RequestParams::getParamBoolean("is_undel") === TRUE) {
                    $modelShop->setBalance($modelShop->getBalance() + $model->getAmount());
                }else{
                    $modelShop->setBalance($modelShop->getBalance() - $model->getAmount());
                }
                Helpers_DB::saveDBObject($modelShop, $sitePageData);
            }
        }

        if($isUnDel === TRUE){
            $model->dbUnDelete($sitePageData->userID, 0, $sitePageData->shopID);

            $shopReturnItemIDs = Request_Request::find('DB_Shop_Return_Item', $sitePageData->shopID, $sitePageData, $driver,
                array('shop_return_id' => $id, 'is_delete' => 1, Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE))->getChildArrayID();
            $driver->unDeleteObjectIDs($shopReturnItemIDs, $sitePageData->userID,
                Model_Shop_Return_Item::TABLE_NAME, array(), $sitePageData->shopID);
        }else {
            $model->dbDelete($sitePageData->userID, 0, $sitePageData->shopID);

            $shopReturnItemIDs = Request_Request::find('DB_Shop_Return_Item', $sitePageData->shopID, $sitePageData, $driver,
                array('shop_return_id' => $id, Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE))->getChildArrayID();
            $driver->deleteObjectIDs($shopReturnItemIDs, $sitePageData->userID, Model_Shop_Return_Item::TABLE_NAME,
                array(), $sitePageData->shopID);
        }

        return TRUE;
    }
}