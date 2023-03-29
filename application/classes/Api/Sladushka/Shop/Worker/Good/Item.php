<?php defined('SYSPATH') or die('No direct script access.');

class Api_Sladushka_Shop_Worker_Good_Item  {

    /**
     * Сохранение список продуктов
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @throws HTTP_Exception_500
     */
    public static function save($shopWorkerGoodID, $shopWorkerID, array $shopWorkerGoodItems, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        $model = new Model_Sladushka_Shop_Worker_Good_Item();
        $model->setDBDriver($driver);

        $shopWorkerGoodItemIDs = Request_Request::find('DB_Sladushka_Shop_Worker_Good_Item', $sitePageData->shopID, $sitePageData, $driver,
            array('shop_worker_good_id' => $shopWorkerGoodID, Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE), 0, TRUE);

        $modelGood = new Model_Shop_Good();
        $modelGood->setDBDriver($driver);

        $total = array(
            'amount' => 0,
            'took' => 0,
            'return' => 0,
            'quantity' => 0,
            'weight' => 0,
        );
        foreach($shopWorkerGoodItems as $shopWorkerGoodItem){
            $took = Request_RequestParams::strToFloat(Arr::path($shopWorkerGoodItem, 'took', 0));
            if($took <= 0){
                continue;
            }

            $return = Request_RequestParams::strToFloat(Arr::path($shopWorkerGoodItem, 'return', 0));
            if($return < 0){
                continue;
            }

            if($took < $return){
                continue;
            }

            // получаем товар
            $shopGoodID = Arr::path($shopWorkerGoodItem, 'shop_good_id', '');
            if (($shopGoodID < 1) || (!Helpers_DB::getDBObject($modelGood, $shopGoodID, $sitePageData))){
                continue;
            }
            $weight = floatval(Arr::path($modelGood->getOptionsArray(), 'weight', 0));

            $model->clear();
            $shopWorkerGoodItemID = array_shift($shopWorkerGoodItemIDs->childs);
            if($shopWorkerGoodItemID !== NULL){
                $model->__setArray(array('values' => $shopWorkerGoodItemID->values));
            }

            $model->setShopWorkerID($shopWorkerID);
            $model->setShopGoodID($shopGoodID);
            $model->setTook($took);
            $model->setReturn($return);
            $model->setQuantity($took - $return);
            $model->setPrice($modelGood->getPrice());
            $model->setWeight($weight);
            $model->setAmount($model->getQuantity() * $model->getPrice() * $model->getWeight());

            $model->setShopWorkerGoodID($shopWorkerGoodID);
            Helpers_DB::saveDBObject($model, $sitePageData);

            $total['amount'] += $model->getAmount();
            $total['took'] += $model->getTook();
            $total['return'] += $model->getReturn();
            $total['quantity'] += $model->getQuantity();
            $total['weight'] += $model->getWeight();
        }

        // удаляем лишние
        $driver->deleteObjectIDs($shopWorkerGoodItemIDs->getChildArrayID(), $sitePageData->userID,
            Model_Sladushka_Shop_Worker_Good_Item::TABLE_NAME, array(), $sitePageData->shopID);

        return $total;
    }
}
