<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_Pto_Admin extends Controller_Ab1_Pto_BasicAb1 {
    public function action_index() {
        $this->_sitePageData->url = '/pto/admin/index';

        $this->_putInMain('/main/admin/index');
    }
}
