<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_Ogm_ShopDaughter extends Controller_Ab1_Ogm_BasicAb1{

    public function action_statistics()
    {
        $this->_sitePageData->url = '/ogm/shopdaughter/statistics';
        $this->_actionShopDaughterStatistics();
    }
}
