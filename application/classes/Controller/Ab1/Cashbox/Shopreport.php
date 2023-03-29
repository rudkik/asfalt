<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_Cashbox_ShopReport extends Controller_Ab1_ShopReport {
    public function __construct(Request $request, Response $response)
    {
        $this->actionURLName = 'cashbox';
        $this->prefixView = 'cashbox';

        parent::__construct($request, $response);
        $this->_sitePageData->actionURLName = 'cashbox';
        $this->_sitePageData->interfaceID = Model_Ab1_Shop_Operation::RUBRIC_CASHBOX;
    }

    public function action_index() {
        $this->_sitePageData->url = '/cashbox/shopreport/index';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
            )
        );

        $this->_requestShopCashboxes(null, true);
        $this->_requestShopBranchesMagazine(0);

        $this->_putInMain('/main/_shop/report/index');
    }
}
