<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_Admin_ShopReport extends Controller_Ab1_ShopReport {

    public function __construct(Request $request, Response $response)
    {
        $this->actionURLName = 'ab1-admin';
        $this->prefixView = 'admin';

        parent::__construct($request, $response);
        $this->_sitePageData->actionURLName = 'ab1-admin';
    }

    public function action_index() {
        $this->_sitePageData->url = '/abc/shopreport/index';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
            )
        );

        $this->_putInMain('/main/_shop/report/index');
    }
}
