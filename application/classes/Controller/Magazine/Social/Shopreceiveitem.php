<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Magazine_Social_ShopReceiveItem extends Controller_Magazine_Social_BasicMagazine{

    public function action_statistics()
    {
        $this->_sitePageData->url = '/social/shopreceiveitem/statistics';
        $this->_actionShopReceiveItemStatistics();
    }
}
