<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Client_ShopBill extends Controller_Client_BasicShop {

	public function action_bank(){
		$bill = new Model_Shop_Bill();
        $bill->setDBDriver($this->_driverDB);
        $bill->setAmount(Request_RequestParams::getParamInt('amount'));
        $bill->setShopPaidTypeID(20737);
        $bill->setShopDeliveryTypeID(1);
        $bill->setEditUserID(1);

        $bill->setCreatedAt(date('Y-m-d H:i:s'));
        self::redirect('/index.php/a?bill_id='.Helpers_DB::saveDBObject($bill, $this->_sitePageData));
	}
}