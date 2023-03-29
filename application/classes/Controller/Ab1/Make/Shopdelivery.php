<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_Make_ShopDelivery extends Controller_Ab1_Make_BasicAb1{

    public function action_statistics()
    {
        $this->_sitePageData->url = '/make/shopdelivery/statistics';
        $this->_actionShopDeliveryStatistics();
    }

    public function action_list_statistics()
    {
        $this->_sitePageData->url = '/make/shopdelivery/list_statistics';
        $this->_actionShopDeliveryListStatistics();
    }
}
