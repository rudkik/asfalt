<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Pyramid_Admin extends Controller_Pyramid_BasicPyramid {
    public function action_index() {
        $this->_sitePageData->url = '/pyramid/admin/index';

        $this->_putInMain('/main/admin/index');
    }
}
