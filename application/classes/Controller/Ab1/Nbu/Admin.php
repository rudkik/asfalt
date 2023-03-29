<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_Nbu_Admin extends Controller_Ab1_Nbu_BasicAb1 {
    public function action_index() {
        $this->_sitePageData->url = '/nbu/admin/index';

        $this->_putInMain('/main/admin/index');
    }
}
