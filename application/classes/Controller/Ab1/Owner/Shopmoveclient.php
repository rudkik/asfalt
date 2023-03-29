<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_Owner_ShopMoveClient extends Controller_Ab1_Owner_BasicAb1{

    public function action_statistics()
    {
        $this->_sitePageData->url = '/owner/shopmoveclient/statistics';
        $this->_actionShopMoveClientStatistics();
    }
}
