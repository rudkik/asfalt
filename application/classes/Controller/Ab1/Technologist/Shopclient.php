<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_Technologist_ShopClient extends Controller_Ab1_Technologist_BasicAb1 {
    public function action_statistics()
    {
        $this->_sitePageData->url = '/technologist/shopclient/statistics';
        $this->_actionShopClientStatistics(false);
    }
}
