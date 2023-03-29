<?php defined('SYSPATH') or die('No direct script access.');

class Api_Hotel_Shop_Holiday_Day  {

    /**
     * @param $shopHolidayID
     * @param $dateFrom
     * @param $dateTo
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @return bool
     */
    public static function save($shopHolidayID, $dateFrom, $dateTo, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        $model = new Model_Hotel_Shop_Holiday_Day();
        $model->setDBDriver($driver);

        $shopHolidayItemIDs = Request_Request::find('DB_Hotel_Shop_Holiday_Day', $sitePageData->shopID, $sitePageData, $driver,
            array('shop_holiday_id' => $shopHolidayID, Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE), 0, TRUE);

        $dateFrom = strtotime($dateFrom);
        $dateTo = strtotime($dateTo);
        while ($dateFrom <= $dateTo){
            $model->clear();
            $shopHolidayItemID = array_shift($shopHolidayItemIDs->childs);
            if($shopHolidayItemID !== NULL){
                $model->__setArray(array('values' => $shopHolidayItemID->values));
            }

            $model->setDate(date('Y-m-d', $dateFrom));
            $model->setShopHolidayID($shopHolidayID);
            Helpers_DB::saveDBObject($model, $sitePageData);

            $dateFrom += 60 * 60 * 24;
        }

        // удаляем лишние
        $driver->deleteObjectIDs($shopHolidayItemIDs->getChildArrayID(), $sitePageData->userID,
            Model_Hotel_Shop_Holiday_Day::TABLE_NAME, array(), $sitePageData->shopID);

        return TRUE;
    }
}
