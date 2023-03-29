<?php defined('SYSPATH') or die('No direct script access.');

class Api_AutoPart_Shop_Supplier_Address {
    /**
     * Сохранение адреса
     * @param Model_AutoPart_Shop_Supplier_Address $model
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @throws HTTP_Exception_404
     */
    public static function saveModel(Model_AutoPart_Shop_Supplier_Address $model, SitePageData $sitePageData,
                                     Model_Driver_DBBasicDriver $driver)
    {
        $model->setDBDriver($driver);

        $query = Helpers_Yandex::getYandexMapsCoordinates(Request_RequestParams::getParamStr('yandex'));
        if(empty($query)){
            return;
        }

        $coordinates = array_shift($query);
        if(is_array($coordinates)){
            $model->setLatitude($coordinates[0]);
            $model->setLongitude($coordinates[1]);
        }

        Helpers_DB::saveDBObject($model, $sitePageData);
    }
}
