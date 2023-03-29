<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_Peo_ShopLesseeCar extends Controller_Ab1_Peo_BasicAb1 {
    public function action_statistics()
    {
        $this->_sitePageData->url = '/peo/shoplesseecar/statistics';

        $this->_actionShopLesseeCarStatistics();
    }
}
