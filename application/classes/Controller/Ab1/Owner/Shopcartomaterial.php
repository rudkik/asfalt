<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_Owner_ShopCarToMaterial extends Controller_Ab1_Owner_BasicAb1{

    public function action_statistics()
    {
        $this->_sitePageData->url = '/owner/shopcartomaterial/statistics';
        $this->_actionShopCarToMaterialStatistics();
    }

    public function action_statistics_daughter()
    {
        $this->_sitePageData->url = '/owner/shopcartomaterial/statistics_daughter';
        $this->_actionShopCarToMaterialDaughterStatistics();
    }

    public function action_statistics_daughter_material()
    {
        $this->_sitePageData->url = '/owner/shopcartomaterial/statistics_daughter_material';
        $this->_actionShopCarToMaterialDaughterMaterialStatistics();
    }

    public function action_statistics_subdivision()
    {
        $this->_sitePageData->url = '/owner/shopcartomaterial/statistics_subdivision';
        $this->_actionShopCarToMaterialSubdivisionStatistics();
    }
}
