<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_Peo_ShopProductStorage extends Controller_Ab1_Peo_BasicAb1{

    public function action_statistics()
    {
        $this->_sitePageData->url = '/peo/shopproductstorage/statistics';

        $this->_actionShopProductStorageStatistics();
    }
}
