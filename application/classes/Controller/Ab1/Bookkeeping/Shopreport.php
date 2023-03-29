<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_Bookkeeping_ShopReport extends Controller_Ab1_ShopReport {

    public function __construct(Request $request, Response $response)
    {
        $this->actionURLName = 'bookkeeping';
        $this->prefixView = 'bookkeeping';

        parent::__construct($request, $response);
        $this->_sitePageData->actionURLName = 'bookkeeping';
        $this->_sitePageData->interfaceID = Model_Ab1_Shop_Operation::RUBRIC_BOOKKEEPING;
    }

    public function action_index() {
        $this->_sitePageData->url = '/bookkeeping/shopreport/index';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
            )
        );

        $this->_requestShopProductRubrics();
        $this->_requestShopMaterialRubrics();
        $this->_requestShopTransportCompanies();
        $this->_requestShopBranches($this->_sitePageData->shopID, true);
        $this->_requestShopSubdivisions(null, 0, '');
        $this->_putInMain('/main/_shop/report/index');
    }
}
