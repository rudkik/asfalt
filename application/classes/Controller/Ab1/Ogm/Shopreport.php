<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_Ogm_ShopReport extends Controller_Ab1_ShopReport {

    public function __construct(Request $request, Response $response)
    {
        $this->actionURLName = 'ogm';
        $this->prefixView = 'ogm';

        parent::__construct($request, $response);
        $this->_sitePageData->actionURLName = 'ogm';
        $this->_sitePageData->interfaceID = Model_Ab1_Shop_Operation::RUBRIC_OGM;
    }

    public function action_index() {
        $this->_sitePageData->url = '/ogm/shopreport/index';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
            )
        );
        $this->_requestShopProductRubrics();
        $this->_requestShopMaterials();
        $this->_requestShopMaterialRubrics();
        $this->_requestShopHeaps();
        $this->_requestShopTransportCompanies();
        $this->_requestShopBranches(null, true);

        $this->_putInMain('/main/_shop/report/index');
    }
}
