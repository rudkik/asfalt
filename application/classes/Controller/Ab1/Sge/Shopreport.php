<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_Sge_ShopReport extends Controller_Ab1_ShopReport {

    public function __construct(Request $request, Response $response)
    {
        $this->actionURLName = 'sge';
        $this->prefixView = 'sge';

        parent::__construct($request, $response);
        $this->_sitePageData->actionURLName = 'sge';
        $this->_sitePageData->interfaceID = Model_Ab1_Shop_Operation::RUBRIC_SGE;
    }

    public function action_index() {
        $this->_sitePageData->url = '/sge/shopreport/index';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
            )
        );
        $this->_requestShopProductRubrics();
        $this->_requestShopMaterials();
        $this->_requestShopMaterialRubrics();
        $this->_requestShopSubdivisions();
        $this->_requestShopWorkShiftsBranches();
        $this->_requestShopBranches();
        $this->_requestShopBallastCarsBranches();
        $this->_requestShopBallastDrivers();
        $this->_requestShopTransportCompanies();
        $this->_requestShopProducts();
        $data = $this->_requestShopClients(null, Model_Ab1_ClientType::CLIENT_TYPE_BUY_RAW);
        $this->_sitePageData->addReplaceAndGlobalDatas('view::_shop/boxcar/client/list/list', $data);
        $this->_requestShopOperations(null);
        $this->_requestShopTurnPlaces(NULL, 0, TRUE);

        $this->_putInMain('/main/_shop/report/index');
    }
}
