<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_Ogm_ShopProductStorage extends Controller_Ab1_Ogm_BasicAb1{

    public function action_statistics()
    {
        $this->_sitePageData->url = '/ogm/shopproductstorage/statistics';

        $this->_actionShopProductStorageStatistics();
    }
}
