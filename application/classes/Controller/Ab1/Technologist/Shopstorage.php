<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_Technologist_ShopStorage extends Controller_Ab1_Technologist_BasicAb1{

    public function action_statistics()
    {
        $this->_sitePageData->url = '/technologist/shopstorage/statistics';

        $this->_actionShopStorageStatistics();
    }

    public function action_balance_statistics()
    {
        $this->_sitePageData->url = '/technologist/shopstorage/balance_statistics';

        $this->_actionShopStorageBalanceStatistics();
    }
}
