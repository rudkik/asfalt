<?php defined('SYSPATH') or die('No direct script access.');

class Api_Shop_Bill_Item
{

    /**
     * Сохранение строк заказа
     * @param Model_Shop_Bill $model
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @return array
     * @throws HTTP_Exception_500
     */
    public static function saveShopBillItems(Model_Shop_Bill $model, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver, $isDeleteNotFind = TRUE)
    {
        $newBillItems = Request_RequestParams::getParamArray('shop_bill_items');
        if(!is_array($newBillItems)){
            return TRUE;
        }

        // получаем из базы старые данные
        $oldBillItems =  Request_Request::find('DB_Shop_Bill_Item', $model->shopID, $sitePageData, $driver,
											  array('shop_bill_id' => $model->id, Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE));

        $modelBillItem = new Model_Shop_Bill_Item();
        $modelBillItem->setDBDriver($driver);

        $amount = 0;
        foreach($newBillItems as $id => $newBillItem){
            $id = intval($id);
            if($id > 0){
                foreach($oldBillItems->childs as $index => $oldBillItem){
                    if($oldBillItem->id == $id){
                        Helpers_DB::getDBObject($modelBillItem, $id, $sitePageData, $model->shopID);

                        $price = Arr::path($newBillItem, 'price', NULL);
                        if(($price !== NULL) && ($price > 0)){
                            $modelBillItem->setPrice($price);
                        }

                        $modelBillItem->setShopRootID($model->getShopRootID());
                        $modelBillItem->setCountElement(intval(Arr::path($newBillItem, 'count', $modelBillItem->getCountElement())), TRUE);
                        Helpers_DB::saveDBObject($modelBillItem, $sitePageData, $modelBillItem->shopID);

                        $amount = $amount + $modelBillItem->getAmount();

                        unset($oldBillItems->childs[$index]);
                        break;
                    }
                }
            }else{
                // хуй доработать добавление товара в заказ
                throw new HTTP_Exception_500('Не сделана функция добавления товара в заказ');
            }
        }

        // удаляем не найденые товары
        if($isDeleteNotFind === TRUE) {
            foreach ($oldBillItems->childs as $oldBillItem) {
                $modelBillItem->clear();
                $modelBillItem->id = $oldBillItem->id;
                $modelBillItem->shopID = $model->shopID;
                $modelBillItem->dbDelete($sitePageData->userID);
            }
        }

        $model->setAmount($amount);

        return TRUE;
    }
}