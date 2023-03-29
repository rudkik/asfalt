<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_Owner_ShopProduct extends Controller_Ab1_Owner_BasicAb1{

    public function action_statistics()
    {
        $this->_sitePageData->url = '/owner/shopproduct/statistics';
        $this->_actionShopProductStatistics();
    }

    public function action_pricelist()
    {
        $this->_sitePageData->url = '/owner/shopproduct/pricelist';

        $this->_actionShopProductPriceList();
    }
}
