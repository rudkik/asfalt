<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_Lab_ShopDelivery extends Controller_Ab1_Lab_BasicAb1{

    public function action_statistics()
    {
        $this->_sitePageData->url = '/lab/shopdelivery/statistics';
        $this->_actionShopDeliveryStatistics();
    }

    public function action_list_statistics()
    {
        $this->_sitePageData->url = '/lab/shopdelivery/list_statistics';
        $this->_actionShopDeliveryListStatistics();
    }
}
