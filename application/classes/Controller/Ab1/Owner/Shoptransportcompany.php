<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_Owner_ShopTransportCompany extends Controller_Ab1_Owner_BasicAb1{

    public function action_statistics()
    {
        $this->_sitePageData->url = '/owner/shoptransportcompany/statistics';
        $this->_actionShopTransportCompanyStatistics();
    }
}
