<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Magazine_Social_Admin extends Controller_Magazine_Social_BasicMagazine {
    public function action_index() {
        $this->_sitePageData->url = '/social/admin/index';

        $this->_putInMain('/main/admin/index');
    }
}
