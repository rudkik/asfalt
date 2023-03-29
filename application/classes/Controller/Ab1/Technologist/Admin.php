<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_Technologist_Admin extends Controller_Ab1_Technologist_BasicAb1 {
    public function action_index() {
        $this->_sitePageData->url = '/technologist/admin/index';

        $this->_putInMain('/main/admin/index');
    }
}
