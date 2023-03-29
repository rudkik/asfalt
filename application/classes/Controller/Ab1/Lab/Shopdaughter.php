<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_Lab_ShopDaughter extends Controller_Ab1_Lab_BasicAb1{

    public function action_statistics()
    {
        $this->_sitePageData->url = '/lab/shopdaughter/statistics';
        $this->_actionShopDaughterStatistics();
    }
}
