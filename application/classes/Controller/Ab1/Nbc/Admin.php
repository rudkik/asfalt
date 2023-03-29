<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_Nbc_Admin extends Controller_Ab1_Nbc_BasicAb1 {
    public function action_index() {
        $this->_sitePageData->url = '/nbc/admin/index';

        $this->_putInMain('/main/admin/index');
    }
}
