<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_Asu_Admin extends Controller_Ab1_Asu_BasicAb1 {
    public function action_index() {
        $this->_sitePageData->url = '/asu/admin/index';

        $this->_putInMain('/main/admin/index');
    }
}
