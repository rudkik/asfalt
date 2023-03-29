<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_Make_ShopTransportWaybillFuelExpense extends Controller_Ab1_Make_BasicAb1{

    public function action_statistics()
    {
        $this->_sitePageData->url = '/make/shoptransportwaybillfuelexpense/statistics';
        $this->_actionShopTransportWaybillFuelExpenseStatistics();
    }
}
