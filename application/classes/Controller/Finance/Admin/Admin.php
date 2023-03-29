<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Finance_Admin_Admin extends Controller_Finance_Admin_Basic {
    public function action_index() {
        $this->_sitePageData->url = '/admin/index';

        $this->_putInMain('/main/admin/index');
    }
}
