<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_Ecologist_Admin extends Controller_Ab1_Ecologist_BasicAb1 {
    public function action_index() {
        $this->_sitePageData->url = '/ecologist/admin/index';

        $this->_putInMain('/main/admin/index');
    }
}
