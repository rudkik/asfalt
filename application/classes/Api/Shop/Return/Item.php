<?php defined('SYSPATH') or die('No direct script access.');

class Api_Shop_Return_Item
{

    /**
     * Сохранение строк заказа
     * @param Model_Shop_Return $model
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @return array
     * @throws HTTP_Exception_500
     */
    public static function saveShopReturnItems(Model_Shop_Return $model, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver, $isDeleteNotFind = TRUE)
    {
        $newReturnItems = Request_RequestParams::getParamArray('shop_return_items');
        if(!is_array($newReturnItems)){
            return TRUE;
        }

        // получаем из базы старые данные
        $oldReturnItems =  Request_Request::find('DB_Shop_Return_Item', $model->shopID, $sitePageData, $driver,
											  array('shop_return_id' => $model->id, Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE));

        $modelReturnItem = new Model_Shop_Return_Item();
        $modelReturnItem->setDBDriver($driver);

        $amount = 0;
        foreach($newReturnItems as $id => $newReturnItem){
            $id = intval($id);
            if($id > 0){
                foreach($oldReturnItems->childs as $index => $oldReturnItem){
                    if($oldReturnItem->id == $id){
                        Helpers_DB::getDBObject($modelReturnItem, $id, $sitePageData, $model->shopID);

                        $price = Arr::path($newReturnItem, 'price', NULL);
                        if(($price !== NULL) && ($price > 0)){
                            $modelReturnItem->setPrice($price);
                        }

                        $modelReturnItem->setShopRootID($model->getShopRootID());
                        $modelReturnItem->setCountElement(intval(Arr::path($newReturnItem, 'count', 0)), TRUE);
                        Helpers_DB::saveDBObject($modelReturnItem, $sitePageData, $modelReturnItem->shopID);

                        $amount = $amount + $modelReturnItem->getAmount();

                        unset($oldReturnItems->childs[$index]);
                        break;
                    }
                }
            }else{
                // хуй доработать добавление товара в заказ
                throw new HTTP_Exception_500('Не сделана функция добавления товара в возрат');
            }
        }

        // удаляем не найденые товары
        if($isDeleteNotFind === TRUE) {
            foreach ($oldReturnItems->childs as $oldReturnItem) {
                $modelReturnItem->clear();
                $modelReturnItem->id = $oldReturnItem->id;
                $modelReturnItem->shopID = $model->shopID;
                $modelReturnItem->dbDelete($sitePageData->userID);
            }
        }

        $model->setAmount($amount);

        return TRUE;
    }
}