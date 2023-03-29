<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_Train_ShopLesseeCar extends Controller_Ab1_Train_BasicAb1 {
    public function action_statistics()
    {
        $this->_sitePageData->url = '/train/shoplesseecar/statistics';

        $this->_actionShopLesseeCarStatistics();
    }
}
