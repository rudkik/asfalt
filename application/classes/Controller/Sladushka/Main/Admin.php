<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Sladushka_Main_Admin extends Controller_Sladushka_Main_BasicSladushka {
    public function action_index() {
        $this->_sitePageData->url = '/sladushka/admin/index';

        $this->_putInMain('/main/admin/index');
    }
}
