<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_Peo_Admin extends Controller_Ab1_Peo_BasicAb1 {
    public function action_index() {
        $this->_sitePageData->url = '/peo/admin/index';

        $this->_putInMain('/main/admin/index');
    }
}
