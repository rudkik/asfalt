<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_Ogm_ShopStorage extends Controller_Ab1_Ogm_BasicAb1{

    public function action_statistics()
    {
        $this->_sitePageData->url = '/ogm/shopstorage/statistics';

        $this->_actionShopStorageStatistics();
    }

    public function action_balance_statistics()
    {
        $this->_sitePageData->url = '/ogm/shopstorage/balance_statistics';

        $this->_actionShopStorageBalanceStatistics();
    }
}
