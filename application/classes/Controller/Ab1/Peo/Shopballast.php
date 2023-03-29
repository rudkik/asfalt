<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_Peo_ShopBallast extends Controller_Ab1_Peo_BasicAb1{

    public function action_statistics()
    {
        $this->_sitePageData->url = '/peo/shopballast/statistics';
        $this->_actionShopBallastStatistics();
    }
}
