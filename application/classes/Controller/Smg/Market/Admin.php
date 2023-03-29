<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Smg_Market_Admin extends Controller_Smg_Market_Basic {
    public function action_index() {
        $this->_sitePageData->url = '/market/shopproduct/index';

        $this->_putInMain('/main/admin/index');
    }
}
