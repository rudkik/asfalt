<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_Peo_ShopTurnPlace extends Controller_Ab1_Peo_BasicAb1{

    public function action_statistics()
    {
        $this->_sitePageData->url = '/peo/shopturnplace/statistics';
        $this->_actionShopTurnPlaceStatistics();
    }

    public function action_statistics_car()
    {
        $this->_sitePageData->url = '/peo/shopturnplace/statistics_car';
        $this->_actionShopTurnPlaceStatisticsCar();
    }
}
