<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_Technologist_ShopDelivery extends Controller_Ab1_Technologist_BasicAb1{

    public function action_statistics()
    {
        $this->_sitePageData->url = '/technologist/shopdelivery/statistics';
        $this->_actionShopDeliveryStatistics();
    }

    public function action_list_statistics()
    {
        $this->_sitePageData->url = '/technologist/shopdelivery/list_statistics';
        $this->_actionShopDeliveryListStatistics();
    }
}
