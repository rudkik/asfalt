<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_Abc_Admin extends Controller_Ab1_Abc_BasicAb1 {
    public function action_index() {
        $this->_sitePageData->url = '/abc/admin/index';

        $this->_putInMain('/main/admin/index');
    }
}
