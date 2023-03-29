<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_Cash_Admin extends Controller_Ab1_Cash_BasicAb1 {
    public function action_index() {
        $this->_sitePageData->url = '/cash/admin/index';

        $this->_putInMain('/main/admin/index');
    }
}
