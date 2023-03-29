<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ads_Admin extends Controller_Ads_BasicAds {
    public function action_index() {
        $this->_sitePageData->url = '/ads/admin/index';

        $this->_putInMain('/main/admin/index');
    }
}
