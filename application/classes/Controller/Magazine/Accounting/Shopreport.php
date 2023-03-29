<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Magazine_Accounting_ShopReport extends Controller_Magazine_ShopReport {

    public function __construct(Request $request, Response $response)
    {
        $this->actionURLName = 'accounting';
        $this->prefixView = 'accounting';

        parent::__construct($request, $response);
    }

    public function action_index() {
        $this->_sitePageData->url = '/accounting/shopreport/index';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
            )
        );

        $this->_requestShopWorkers();
        $this->_requestShopSupplier();
        $this->_requestShopProductionRubrics();
        $this->_requestShopBranches(NULL,Model_Magazine_Shop::SHOP_TABLE_RUBRIC_MAGAZINE);

        $this->_putInMain('/main/_shop/report/index');
    }
}
