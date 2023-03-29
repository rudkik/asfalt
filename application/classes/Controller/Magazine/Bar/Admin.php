<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Magazine_Bar_Admin extends Controller_Magazine_Bar_BasicMagazine {
    public function action_index() {
        $this->_sitePageData->url = '/bar/admin/index';

        $this->_putInMain('/main/admin/index');
    }
}
