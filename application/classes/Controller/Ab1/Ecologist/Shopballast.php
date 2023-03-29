<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_Ecologist_ShopBallast extends Controller_Ab1_Ecologist_BasicAb1{

    public function action_statistics()
    {
        $this->_sitePageData->url = '/ecologist/shopballast/statistics';
        $this->_actionShopBallastStatistics();
    }
}
