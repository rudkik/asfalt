<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_Kpp_ShopReport extends Controller_Ab1_ShopReport {

    public function __construct(Request $request, Response $response)
    {
        $this->actionURLName = 'kpp';
        $this->prefixView = 'kpp';

        parent::__construct($request, $response);
        $this->_sitePageData->actionURLName = 'kpp';
        $this->_sitePageData->interfaceID = Model_Ab1_Shop_Operation::RUBRIC_KPP;
    }

    public function action_index() {
        $this->_sitePageData->url = '/kpp/shopreport/index';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
            )
        );

        $this->_requestShopMaterialRubrics();
        $this->_requestShopProductRubrics();
        $this->_requestShopTransportCompanies();
        $this->_requestShopMaterials();
        $this->_requestShopBranches(null, true);

        $this->_putInMain('/main/_shop/report/index');
    }
}
