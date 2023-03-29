<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Smg_Market_ShopReport extends Controller_Smg_ShopReport {

    public function __construct(Request $request, Response $response)
    {
        $this->actionURLName = 'market';
        $this->prefixView = 'market';

        parent::__construct($request, $response);
        $this->_sitePageData->actionURLName = 'market';
    }

    public function action_index() {
        $this->_sitePageData->url = '/market/shopreport/index';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
            )
        );

        $this->_putInMain('/main/_shop/report/index');
    }
}
