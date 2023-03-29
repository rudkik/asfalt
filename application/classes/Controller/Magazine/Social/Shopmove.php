<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Magazine_Social_ShopMove extends Controller_Magazine_Social_BasicMagazine{

    public function action_statistics()
    {
        $this->_sitePageData->url = '/social/shopmove/statistics';
        $this->_actionShopMoveStatistics();
    }
}
