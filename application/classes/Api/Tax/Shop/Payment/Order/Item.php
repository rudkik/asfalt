<?php defined('SYSPATH') or die('No direct script access.');

class Api_Tax_Shop_Payment_Order_Item  {

    /**
     * Сохранение список продуктов
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @throws HTTP_Exception_500
     */
    public static function save($shopPaymentOrderID, $shopContractorID, array $shopPaymentOrderItems, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        $model = new Model_Tax_Shop_Payment_Order_Item();
        $model->setDBDriver($driver);

        $shopPaymentOrderItemIDs = Request_Tax_Shop_Payment_Order_Item::findShopPaymentOrderItemIDs($sitePageData->shopID, $sitePageData, $driver,
            array('shop_invoice_id' => $shopPaymentOrderID, Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE), 0, TRUE);

        $modelWorker = new Model_Tax_Shop_Worker();
        $modelWorker->setDBDriver($driver);

        $total = 0;
        foreach($shopPaymentOrderItems as $shopPaymentOrderItem){
            $name = Arr::path($shopPaymentOrderItem, 'shop_worker_name', '');
            if(empty($name)){
                continue;
            }
            $amount = str_replace(' ', '', str_replace(',', '.', floatval(Arr::path($shopPaymentOrderItem, 'amount', 0))));
            if($amount <= 0){
                continue;
            }
            $date = str_replace(',', '.', Arr::path($shopPaymentOrderItem, 'date', ''));
            if(strlen($date) != 6){
                continue;
            }

            $iin = Arr::path($shopPaymentOrderItem, 'shop_worker_iin', '');
            $dateOfBirth = date("Y-m-d H:i:s", strtotime(Arr::path($shopPaymentOrderItem, 'shop_worker_date_of_birth', '')));

            $params = array(
                'name_full' => $name,
                'date_of_birth' => $dateOfBirth,
                'iin_full' => $iin,
                Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE
            );

            // получаем товар
            $shopWorkerID = Request_Tax_Shop_Worker::findShopWorkerIDs($sitePageData->shopID, $sitePageData, $driver,
                $params, 1);
            if (count($shopWorkerID->childs) == 1){
                $shopWorkerID = $shopWorkerID->childs[0]->id;
            }else{
                $modelWorker->clear();
                $modelWorker->setName($name);
                $modelWorker->setIIN($iin);
                $modelWorker->setDateOfBirth($dateOfBirth);

                $shopWorkerID = Helpers_DB::saveDBObject($modelWorker, $sitePageData);
            }

            $model->clear();
            $shopPaymentOrderItemID = array_shift($shopPaymentOrderItemIDs->childs);
            if($shopPaymentOrderItemID !== NULL){
                $model->__setArray(array('values' => $shopPaymentOrderItemID->values));
            }

            $model->setShopContractorID($shopContractorID);
            $model->setShopWorkerID($shopWorkerID);
            $model->setDateInt($date);
            $model->setAmount($amount);

            $model->setShopPaymentOrderID($shopPaymentOrderID);
            Helpers_DB::saveDBObject($model, $sitePageData);

            $total = $total + $model->getAmount();
        }

        // удаляем лишние
        $driver->deleteObjectIDs($shopPaymentOrderItemIDs->getChildArrayID(), $sitePageData->userID,
            Model_Tax_Shop_Payment_Order_Item::TABLE_NAME, array(), $sitePageData->shopID);

        return $total;
    }
}
