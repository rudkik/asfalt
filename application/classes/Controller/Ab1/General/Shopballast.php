<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_General_ShopBallast extends Controller_Ab1_General_BasicAb1{

    public function action_statistics()
    {
        $this->_sitePageData->url = '/general/shopballast/statistics';
        $this->_actionShopBallastStatistics();
    }
}
