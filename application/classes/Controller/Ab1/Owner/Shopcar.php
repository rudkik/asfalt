<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_Owner_ShopCar extends Controller_Ab1_Owner_BasicAb1{


    public function action_asu() {
        $this->_sitePageData->url = '/owner/shopcar/asu';
        $this->_requestShopBranches(null, true);
        $this->_actionASU();
    }

    public function action_asu_cars() {
        $this->_sitePageData->url = '/owner/shopcar/asu_cars';
        $this->_actionASUCars();
    }
}
