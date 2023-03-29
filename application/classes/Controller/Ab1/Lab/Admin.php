<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_Lab_Admin extends Controller_Ab1_Lab_BasicAb1 {
    public function action_index() {
        $this->_sitePageData->url = '/lab/admin/index';

        $this->_putInMain('/main/admin/index');
    }
}
