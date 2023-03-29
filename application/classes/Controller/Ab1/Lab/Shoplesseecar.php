<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_Lab_ShopLesseeCar extends Controller_Ab1_Lab_BasicAb1 {
    public function action_statistics()
    {
        $this->_sitePageData->url = '/lab/shoplesseecar/statistics';

        $this->_actionShopLesseeCarStatistics();
    }
}
