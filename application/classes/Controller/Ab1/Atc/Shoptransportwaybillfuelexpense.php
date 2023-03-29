<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_Atc_ShopTransportWaybillFuelExpense extends Controller_Ab1_Atc_BasicAb1{

    public function action_statistics()
    {
        $this->_sitePageData->url = '/atc/shoptransportwaybillfuelexpense/statistics';
        $this->_actionShopTransportWaybillFuelExpenseStatistics();
    }
}
