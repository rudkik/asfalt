<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Smg_Trade_Admin extends Controller_Smg_Trade_Basic {
    public function action_index() {
        $this->_sitePageData->url = '/trade/shopproduct/index';

        $this->_putInMain('/main/admin/index');
    }
}
