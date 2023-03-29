<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_Ecologist_ShopStorage extends Controller_Ab1_Ecologist_BasicAb1{

    public function action_statistics()
    {
        $this->_sitePageData->url = '/ecologist/shopstorage/statistics';

        $this->_actionShopStorageStatistics();
    }

    public function action_balance_statistics()
    {
        $this->_sitePageData->url = '/ecologist/shopstorage/balance_statistics';

        $this->_actionShopStorageBalanceStatistics();
    }
}
