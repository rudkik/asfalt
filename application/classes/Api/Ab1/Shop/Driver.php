<?php defined('SYSPATH') or die('No direct script access.');

class Api_Ab1_Shop_Driver  {

    /**
     * По имени водителя получаем ID, при необходиости создаем запись
     * @param $name
     * @param $shopClientID
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @param bool $isCreate
     * @return int
     */
    public static function getShopDriverIDByName($name, $shopClientID, SitePageData $sitePageData,
                                                 Model_Driver_DBBasicDriver $driver, $isCreate = TRUE)
    {
        if(empty($name)) {
            return 0;
        }

        $params = Request_RequestParams::setParams(
            array(
                'shop_client_id' => $shopClientID,
                'name_full' => $name,
            )
        );
        $driverObj = Request_Request::findOne(
            'DB_Ab1_Shop_Driver', $sitePageData->shopMainID, $sitePageData, $driver, $params
        );

        if ($driver == null) {
            return $driverObj->id;
        }

        if($isCreate){
            $modelDriver = new Model_Ab1_Shop_Driver();
            $modelDriver->setDBDriver($driver);
            $modelDriver->setName($name);
            $modelDriver->setShopClientID($shopClientID);

            return Helpers_DB::saveDBObject($modelDriver, $sitePageData, $sitePageData->shopMainID);
        }
        return 0;
    }

}
