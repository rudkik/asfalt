<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_Pto_ShopStorage extends Controller_Ab1_Pto_BasicAb1{

    public function action_statistics()
    {
        $this->_sitePageData->url = '/pto/shopstorage/statistics';

        $this->_actionShopStorageStatistics();
    }

    public function action_balance_statistics()
    {
        $this->_sitePageData->url = '/pto/shopstorage/balance_statistics';

        $this->_actionShopStorageBalanceStatistics();
    }
}
