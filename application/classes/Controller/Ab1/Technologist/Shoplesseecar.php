<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_Technologist_ShopLesseeCar extends Controller_Ab1_Technologist_BasicAb1 {
    public function action_statistics()
    {
        $this->_sitePageData->url = '/technologist/shoplesseecar/statistics';

        $this->_actionShopLesseeCarStatistics();
    }
}
