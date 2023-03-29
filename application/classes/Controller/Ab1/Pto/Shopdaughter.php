<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_Pto_ShopDaughter extends Controller_Ab1_Pto_BasicAb1{

    public function action_statistics()
    {
        $this->_sitePageData->url = '/pto/shopdaughter/statistics';
        $this->_actionShopDaughterStatistics();
    }
}
