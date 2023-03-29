<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_Ogm_ShopProduct extends Controller_Ab1_Ogm_BasicAb1{

    public function action_statistics()
    {
        $this->_sitePageData->url = '/ogm/shopproduct/statistics';
        $this->_actionShopProductStatistics();
    }

    public function action_pricelist()
    {
        $this->_sitePageData->url = '/ogm/shopproduct/pricelist';

        $this->_actionShopProductPriceList();
    }
}
