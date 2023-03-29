<?php defined('SYSPATH') or die('No direct script access.');

class Request_Shop_PaidType extends Request_Request {
    /**
     * Получаем ID способа оплаты по типу оплаты
     * @param $shopID
     * @param $paidTypeID
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @return int
     */
	public static function findIDByPaidTypeID($shopID, $paidTypeID, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver){
        return self::findIDByField('DB_Shop_PaidType', 'paid_type_id', $paidTypeID, $shopID, $sitePageData, $driver);
	}
}