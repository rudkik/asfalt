<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Tax_Client_Admin extends Controller_Tax_Client_BasicTax {
    public function action_index() {
        $this->_sitePageData->url = '/tax/admin/index';

        $this->_putInMain('/main/admin/index');
    }
}
