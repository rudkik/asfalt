<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_Abc_ShopReport extends Controller_Ab1_ShopReport {

    public function __construct(Request $request, Response $response)
    {
        $this->actionURLName = 'abc';
        $this->prefixView = 'abc';

        parent::__construct($request, $response);
        $this->_sitePageData->actionURLName = 'abc';
        $this->_sitePageData->interfaceID = Model_Ab1_Shop_Operation::RUBRIC_ABC;
    }

    public function action_index() {
        $this->_sitePageData->url = '/abc/shopreport/index';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
            )
        );
        $this->_requestShopMaterials();
        $this->_requestShopProductRubrics();
        $this->_requestShopMaterialRubrics();
        $this->_requestShopOperations(Model_Ab1_Shop_Operation::RUBRIC_WEIGHT);
        $this->_requestShopTurnPlaces(NULL, 0, TRUE);
        $data = $this->_requestShopClients(null, Model_Ab1_ClientType::CLIENT_TYPE_BUY_RAW);
        $this->_sitePageData->addReplaceAndGlobalDatas('view::_shop/boxcar/client/list/list', $data);
        $this->_requestShopSubdivisions();
        $this->_requestShopBranches($this->_sitePageData->shopID, TRUE);
        $this->_requestShopTransportCompanies();
        $this->_requestShopMaterialOthers();
        $this->_requestShopSubdivisions(null, 0, '');
        $this->_requestShopClients(null, Model_Ab1_ClientType::CLIENT_TYPE_LESSEE);

        $this->_putInMain('/main/_shop/report/index');
    }
}
