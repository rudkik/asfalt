<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_Pto_ShopReport extends Controller_Ab1_ShopReport {

    public function __construct(Request $request, Response $response)
    {
        $this->actionURLName = 'pto';
        $this->prefixView = 'pto';

        parent::__construct($request, $response);
        $this->_sitePageData->actionURLName = 'pto';
        $this->_sitePageData->interfaceID = Model_Ab1_Shop_Operation::RUBRIC_PTO;
    }

    public function action_index() {
        $this->_sitePageData->url = '/pto/shopreport/index';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
            )
        );
        $this->_requestShopTurnPlaces(NULL, 0, TRUE);
        $this->_requestShopProductRubrics();
        $this->_requestShopMaterials();
        $this->_requestShopMaterialRubrics();
        $this->_requestShopSubdivisions();
        $this->_requestShopWorkShiftsBranches();
        $this->_requestShopBranches(null, true);
        $this->_requestShopBallastCarsBranches();
        $this->_requestShopBallastDrivers();
        $this->_requestShopTransportCompanies();
        $this->_requestShopRaws();

        $this->_requestShopProducts(
            null, 0, NULL, FALSE,
            [
                Model_Ab1_ProductView::PRODUCT_TYPE_CAR,
                Model_Ab1_ProductView::PRODUCT_TYPE_CAR_AND_PIECE,
            ]
        );
        $this->_requestShopClients(null, Model_Ab1_ClientType::CLIENT_TYPE_LESSEE);


        $data = $this->_requestShopClients(null, Model_Ab1_ClientType::CLIENT_TYPE_BUY_RAW);
        $this->_sitePageData->addReplaceAndGlobalDatas('view::_shop/boxcar/client/list/list', $data);

        $this->_putInMain('/main/_shop/report/index');
    }
}
