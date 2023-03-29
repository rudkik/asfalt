<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_Sge_Admin extends Controller_Ab1_Sge_BasicAb1 {
    public function action_index() {
        $this->_sitePageData->url = '/sge/admin/index';

        $this->_putInMain('/main/admin/index');
    }
}
