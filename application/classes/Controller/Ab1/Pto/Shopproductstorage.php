<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_Pto_ShopProductStorage extends Controller_Ab1_Pto_BasicAb1{

    public function action_statistics()
    {
        $this->_sitePageData->url = '/pto/shopproductstorage/statistics';

        $this->_actionShopProductStorageStatistics();
    }
}
