<?php defined('SYSPATH') or die('No direct script access.');

class Api_Basic
{

    /**
     * Сохранение списка сортировки
     * @param $tableName
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     */
    public static function saveListOrder($tableName, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        $orders = Request_RequestParams::getParamArray('order', array());
        foreach($orders as $id => $order){
            $id = intval($id);
            $order = intval($order);
            if($id > 0) {
                $driver->updateObjects($tableName, array($id), array('order' => $order), 0, $sitePageData->shopID);
            }
        }
    }
}