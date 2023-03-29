<?php defined('SYSPATH') or die('No direct script access.');

class Api_Hotel_Shop_Feast_Day  {

    /**
     * @param $shopFeastID
     * @param $dateFrom
     * @param $dateTo
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @return bool
     */
    public static function save($shopFeastID, $dateFrom, $dateTo, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        $model = new Model_Hotel_Shop_Feast_Day();
        $model->setDBDriver($driver);

        $shopFeastDayIDs = Request_Request::find('DB_Hotel_Shop_Feast_Day', $sitePageData->shopID, $sitePageData, $driver,
            array('shop_feast_id' => $shopFeastID, Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE), 0, TRUE);

        $dateFrom = strtotime($dateFrom);
        $dateTo = strtotime($dateTo);
        while ($dateFrom <= $dateTo){
            $model->clear();
            $shopFeastDayID = array_shift($shopFeastDayIDs->childs);
            if($shopFeastDayID !== NULL){
                $model->__setArray(array('values' => $shopFeastDayID->values));
            }

            $model->setDate(date('Y-m-d', $dateFrom));
            $model->setShopFeastID($shopFeastID);
            Helpers_DB::saveDBObject($model, $sitePageData);

            $dateFrom += 60 * 60 * 24;
        }

        // удаляем лишние
        $driver->deleteObjectIDs($shopFeastDayIDs->getChildArrayID(), $sitePageData->userID,
            Model_Hotel_Shop_Feast_Day::TABLE_NAME, array(), $sitePageData->shopID);

        return TRUE;
    }
}
