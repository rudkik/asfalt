<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_Cash_ShopReport extends Controller_Ab1_ShopReport {
    public function __construct(Request $request, Response $response)
    {
        $this->actionURLName = 'cash';
        $this->prefixView = 'cash';

        parent::__construct($request, $response);
        $this->_sitePageData->actionURLName = 'cash';
        $this->_sitePageData->interfaceID = Model_Ab1_Shop_Operation::RUBRIC_CASH;
    }

    public function action_index() {
        $this->_sitePageData->url = '/cash/shopreport/index';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
            )
        );

        $this->_requestShopProductRubrics();
        $this->_requestShopClients(null, Model_Ab1_ClientType::CLIENT_TYPE_LESSEE);
        $this->_putInMain('/main/_shop/report/index');
    }
}
