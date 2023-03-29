<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_Weighted_ShopReport extends Controller_Ab1_ShopReport {

    public function __construct(Request $request, Response $response)
    {
        $this->actionURLName = 'weighted';
        $this->prefixView = 'weighted';

        parent::__construct($request, $response);
        $this->_sitePageData->actionURLName = 'weighted';
        $this->_sitePageData->interfaceID = Model_Ab1_Shop_Operation::RUBRIC_WEIGHT;
    }

    public function action_index() {
        $this->_sitePageData->url = '/weighted/shopreport/index';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
            )
        );

        $this->_requestShopProductRubrics();
        $this->_requestShopMaterialOthers();
        $this->_requestShopMaterials(NULL, null, true);
        $this->_requestShopMaterialRubrics();
        $this->_requestShopOperations(Model_Ab1_Shop_Operation::RUBRIC_WEIGHT);
        $this->_requestShopSubdivisions();
        $this->_requestShopBranches($this->_sitePageData->shopID, TRUE);
        $this->_requestShopTransportCompanies();
        $this->_requestShopClients(null, Model_Ab1_ClientType::CLIENT_TYPE_LESSEE);

        $this->_putInMain('/main/_shop/report/index');
    }
}
