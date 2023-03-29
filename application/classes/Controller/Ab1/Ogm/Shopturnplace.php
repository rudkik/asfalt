<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_Ogm_ShopTurnPlace extends Controller_Ab1_Ogm_BasicAb1{

    public function action_statistics()
    {
        $this->_sitePageData->url = '/ogm/shopturnplace/statistics';
        $this->_actionShopTurnPlaceStatistics();
    }

    public function action_statistics_car()
    {
        $this->_sitePageData->url = '/ogm/shopturnplace/statistics_car';
        $this->_actionShopTurnPlaceStatisticsCar();
    }
}
