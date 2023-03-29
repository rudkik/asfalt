<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Magazine_Social_ShopProductionRubric extends Controller_Magazine_Social_BasicMagazine{

    public function action_statistics()
    {
        $this->_sitePageData->url = '/social/shopproductionrubric/statistics';
        $this->_actionShopProductionRubricStatistics();
    }
}
