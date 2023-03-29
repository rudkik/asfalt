<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_Lab_ShopStorage extends Controller_Ab1_Lab_BasicAb1{

    public function action_statistics()
    {
        $this->_sitePageData->url = '/lab/shopstorage/statistics';

        $this->_actionShopStorageStatistics();
    }

    public function action_balance_statistics()
    {
        $this->_sitePageData->url = '/lab/shopstorage/balance_statistics';

        $this->_actionShopStorageBalanceStatistics();
    }
}
