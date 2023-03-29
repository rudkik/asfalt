<?php defined('SYSPATH') or die('No direct script access.');

class Api_Shop_Operation_Stock_Item
{

    /**
     * Сохранение строк заказа
     * @param Model_Shop_Operation_Stock $model
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @return array
     * @throws HTTP_Exception_500
     */
    public static function saveShopOperationStockItems(Model_Shop_Operation_Stock $model, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver, $isDeleteNotFind = TRUE)
    {
        $newOperationStockItems = Request_RequestParams::getParamArray('shop_operation_stock_items');
        if(!is_array($newOperationStockItems)){
            return TRUE;
        }

        // получаем из базы старые данные
        $oldOperationStockItems =  Request_Request::find('DB_Shop_Operation_Stock_Item', $model->shopID, $sitePageData, $driver,
											  array('shop_operation_stock_id' => $model->id, Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE));

        $modelOperationStockItem = new Model_Shop_Operation_Stock_Item();
        $modelOperationStockItem->setDBDriver($driver);

        $amount = 0;
        $amountFirst = 0;
        foreach($newOperationStockItems as $id => $newOperationStockItem){
            $id = intval($id);
            if($id > 0){
                foreach($oldOperationStockItems->childs as $index => $oldOperationStockItem){
                    if($oldOperationStockItem->id == $id){
                        Helpers_DB::getDBObject($modelOperationStockItem, $id, $sitePageData, $model->shopID);

                        $price = Arr::path($newOperationStockItem, 'price', NULL);
                        if(($price !== NULL) && ($price > 0)){
                            $modelOperationStockItem->setPrice($price);
                        }

                        $modelOperationStockItem->setShopOperationID($model->getShopOperationID());
                        $modelOperationStockItem->setCountElement(intval(Arr::path($newOperationStockItem, 'count', $modelOperationStockItem->getCount())), TRUE);
                        $modelOperationStockItem->setCountFirst(intval(Arr::path($modelOperationStockItem, 'count_first', $modelOperationStockItem->getCountFist())));
                        Helpers_DB::saveDBObject($modelOperationStockItem, $sitePageData, $modelOperationStockItem->shopID);

                        $amount = $amount + $modelOperationStockItem->getAmount();
                        $amountFirst = $amountFirst + $modelOperationStockItem->getCountFist() * $modelOperationStockItem->getPrice();

                        unset($oldOperationStockItems->childs[$index]);
                        break;
                    }
                }
            }else{
                // хуй доработать добавление товара в заказ
                throw new HTTP_Exception_500('Не сделана функция добавления товара на склад оператора');
            }
        }

        // удаляем не найденые товары
        if($isDeleteNotFind === TRUE) {
            foreach ($oldOperationStockItems->childs as $oldOperationStockItem) {
                $modelOperationStockItem->clear();
                $modelOperationStockItem->id = $oldOperationStockItem->id;
                $modelOperationStockItem->shopID = $model->shopID;
                $modelOperationStockItem->dbDelete($sitePageData->userID);
            }
        }

        $model->setAmount($amount);
        $model->setAmountFirst($amountFirst);

        return TRUE;
    }
}