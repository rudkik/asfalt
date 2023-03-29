<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Hotel_Admin extends Controller_Hotel_BasicHotel {
    public function action_index() {
        $this->_sitePageData->url = '/hotel/admin/index';

        $this->_putInMain('/main/admin/index');
    }
}
