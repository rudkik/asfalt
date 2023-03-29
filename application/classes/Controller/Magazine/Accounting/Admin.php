<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Magazine_Accounting_Admin extends Controller_Magazine_Accounting_BasicMagazine {
    public function action_index() {
        $this->_sitePageData->url = '/accounting/admin/index';

        $this->_putInMain('/main/admin/index');
    }
}
