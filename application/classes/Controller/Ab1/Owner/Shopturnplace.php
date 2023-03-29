<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_Owner_ShopTurnPlace extends Controller_Ab1_Owner_BasicAb1{

    public function action_statistics()
    {
        $this->_sitePageData->url = '/owner/shopturnplace/statistics';
        $this->_actionShopTurnPlaceStatistics();
    }

    public function action_statistics_car()
    {
        $this->_sitePageData->url = '/owner/shopturnplace/statistics_car';
        $this->_actionShopTurnPlaceStatisticsCar();
    }
}
