<?php defined('SYSPATH') or die('No direct script access.');

class Request_Shop_Address extends Request_Request {
    /**
     * Проверяем есть ли объект Request_...
     * @param $dbObject
     * @return bool|string
     */
    protected static function getRequest($dbObject)
    {
        return false;
    }

    /**
     * Получаем ID адреса основного магазина
     * @param $shopID
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @return int
     */
	public static function getMainAddressID($shopID, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver){
        $params = Request_RequestParams::setParams(
            array(
                'is_main_shop' => TRUE
            )
        );
 	    $object = self::_findOne(
            'DB_Shop_Address', $shopID, $sitePageData, $driver, $params
        );

		if ($object == null){
			return 0;
		}

		return $object->id;
	}
}
