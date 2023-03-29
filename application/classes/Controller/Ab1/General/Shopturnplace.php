<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_General_ShopTurnPlace extends Controller_Ab1_General_BasicAb1{

    public function action_statistics()
    {
        $this->_sitePageData->url = '/general/shopturnplace/statistics';
        $this->_actionShopTurnPlaceStatistics();
    }

    public function action_statistics_car()
    {
        $this->_sitePageData->url = '/general/shopturnplace/statistics_car';
        $this->_actionShopTurnPlaceStatisticsCar();
    }
}
