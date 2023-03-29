<?php defined('SYSPATH') or die('No direct script access.');

class Helpers_IP {
    /**
     * Узнаем название ID страны по IP-адресу с помощью базы данных
     * @param $ip
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @return int
     */
    public static function getCountryIDByIP($ip, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        if(empty($ip)){
            $ip = $_SERVER["REMOTE_ADDR"];
        }

        if(empty($ip)){
            return 0;
        }

        $params = Request_RequestParams::setParams(
            array(
                'ip' => $ip,
            )
        );
        $ids = Request_LandToIP::findLandToIPIDs($sitePageData, $driver, $params, 1, TRUE);

        if(count($ids->childs) > 0){
            return $ids->childs[0]->values['land_id'];
        }

        return 0;
    }
}