<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_ZhbiBc_Admin extends Controller_Ab1_ZhbiBc_BasicAb1 {
    public function action_index() {
        $this->_sitePageData->url = '/zhbibc/admin/index';

        $this->_putInMain('/main/admin/index');
    }
}
