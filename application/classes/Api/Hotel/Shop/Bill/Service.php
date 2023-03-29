<?php defined('SYSPATH') or die('No direct script access.');

class Api_Hotel_Shop_Bill_Service  {

    /**
     * @param $shopBillID
     * @param $shopClientID
     * @param array $shopBillServices
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @return array
     */
    public static function save($shopBillID, $shopClientID, array $shopBillServices, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        $model = new Model_Hotel_Shop_Bill_Service();
        $model->setDBDriver($driver);

        $shopBillServiceIDs = Request_Request::find('DB_Hotel_Shop_Bill_Service', $sitePageData->shopID, $sitePageData, $driver,
            array('shop_bill_id' => $shopBillID, Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE), 0, TRUE);

        $modelService = new Model_Hotel_Shop_Service();
        $modelService->setDBDriver($driver);

        $total = 0;
        $totalFrom = NULL;
        $totalTo = NULL;
        foreach($shopBillServices as $shopBillService){
            $shopServiceID = intval(Arr::path($shopBillService, 'shop_service_id', 0));
            if($shopServiceID < 1){
                continue;
            }

            if(! Helpers_DB::getDBObject($modelService, $shopServiceID, $sitePageData)){
                continue;
            }

            $date = Arr::path($shopBillService, 'date', NULL);
            $date = strtotime($date, NULL);
            if($date === NULL){
                $date = time();
            }

            $model->clear();
            $shopBillServiceID = array_shift($shopBillServiceIDs->childs);
            if($shopBillServiceID !== NULL){
                $model->__setArray(array('values' => $shopBillServiceID->values));
            }

            $model->setShopClientID($shopClientID);
            $model->setShopServiceID($shopServiceID);
            $model->setQuantity(Arr::path($shopBillService, 'quantity', 0));

            $model->setDate(date('Y-m-d', $date));

            $model->setPrice($modelService->getPrice());
            $model->setAmount($modelService->getPrice() * $model->getQuantity());

            $model->setShopBillID($shopBillID);
            Helpers_DB::saveDBObject($model, $sitePageData);

            $total = $total + $model->getAmount();
            if(($totalFrom > $date) || ($totalFrom === NULL)){
                $totalFrom = $date;
            }
            if(($totalTo < $date) || ($totalTo === NULL)){
                $totalTo = $date;
            }
        }

        // удаляем лишние
        $driver->deleteObjectIDs($shopBillServiceIDs->getChildArrayID(), $sitePageData->userID,
            Model_Hotel_Shop_Bill_Service::TABLE_NAME, array(), $sitePageData->shopID);

        if($totalFrom !== NULL){
            $totalFrom = date('Y-m-d H:i:s', $totalFrom);
        }
        if($totalTo !== NULL){
            $totalTo = date('Y-m-d H:i:s', $totalTo);
        }

        return array(
            'amount' => $total,
            'date_from' => $totalFrom,
            'date_to' => $totalTo,
        );
    }
}
