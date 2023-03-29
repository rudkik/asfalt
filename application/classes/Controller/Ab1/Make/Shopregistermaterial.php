<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_Make_ShopRegisterMaterial extends Controller_Ab1_Make_BasicAb1{

    public function action_statistics()
    {
        $this->_sitePageData->url = '/make/shopregistermaterial/statistics';

        $this->_actionShopRegisterMaterialStatistics();
    }
}
