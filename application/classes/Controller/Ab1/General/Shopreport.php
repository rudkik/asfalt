<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_General_ShopReport extends Controller_Ab1_ShopReport {

    public function __construct(Request $request, Response $response)
    {
        $this->actionURLName = 'general';
        $this->prefixView = 'general';

        parent::__construct($request, $response);
        $this->_sitePageData->actionURLName = 'general';
        $this->_sitePageData->interfaceID = Model_Ab1_Shop_Operation::RUBRIC_GENERAL;

    }

    public function action_index() {
        $this->_sitePageData->url = '/general/shopreport/index';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
            )
        );

        $this->_requestShopClients(null, Model_Ab1_ClientType::CLIENT_TYPE_LESSEE);
        $this->_requestShopProducts();
        $this->_requestShopBallastDriversBranches();
        $this->_requestShopBallastCarsBranches();
        $this->_requestShopWorkShiftsBranches();
        $data = $this->_requestShopClients(null, Model_Ab1_ClientType::CLIENT_TYPE_BUY_RAW);
        $this->_sitePageData->addReplaceAndGlobalDatas('view::_shop/boxcar/client/list/list', $data);
        $this->_requestShopTurnPlaces(NULL, 0, TRUE);
        $this->_requestShopOperations(null);
        $this->_requestShopMaterialOthers();
        $this->_requestShopSubdivisions();
        $this->_requestShopMaterials();
        $this->_requestShopBranches(null, true);
        $this->_requestShopProductRubrics();
        $this->_requestShopMaterialRubrics();
        $this->_requestShopTransportCompanies();
        $this->_requestShopCashboxes(null, true);
        $this->_requestShopSubdivisions(null, 0, '');
        $this->_putInMain('/main/_shop/report/index');
    }
}
