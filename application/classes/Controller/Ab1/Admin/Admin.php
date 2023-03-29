<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_Admin_Admin extends Controller_Ab1_Admin_BasicAb1 {
    public function action_index() {
        $this->_sitePageData->url = '/ab1-admin/admin/index';

        $this->_putInMain('/main/admin/index');
    }
}
