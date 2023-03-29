<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_Atc_Admin extends Controller_Ab1_Atc_BasicAb1 {
    public function action_index() {
        $this->_sitePageData->url = '/atc/admin/index';

        $this->_putInMain('/main/admin/index');
    }
}
