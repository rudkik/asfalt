<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_Ogm_ShopTransportCompany extends Controller_Ab1_Ogm_BasicAb1{

    public function action_statistics()
    {
        $this->_sitePageData->url = '/ogm/shoptransportcompany/statistics';
        $this->_actionShopTransportCompanyStatistics();
    }
}
