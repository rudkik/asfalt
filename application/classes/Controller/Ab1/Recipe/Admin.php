<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_Recipe_Admin extends Controller_Ab1_Recipe_BasicAb1 {
    public function action_index() {
        $this->_sitePageData->url = '/recipe/admin/index';

        $this->_putInMain('/main/admin/index');
    }
}
