<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_Atc_ShopReport extends Controller_Ab1_ShopReport {

    public function __construct(Request $request, Response $response)
    {
        $this->actionURLName = 'atc';
        $this->prefixView = 'atc';

        parent::__construct($request, $response);
        $this->_sitePageData->actionURLName = 'atc';
        $this->_sitePageData->interfaceID = Model_Ab1_Shop_Operation::RUBRIC_ATC;
    }

    public function action_index() {
        $this->_sitePageData->url = '/atc/shopreport/index';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
            )
        );

        $this->_requestShopBallastDriversBranches();
        $this->_requestShopMaterialRubrics();
        $this->_requestShopProductRubrics();
        $this->_requestShopTransportCompanies();
        $this->_requestShopMaterials();
        $this->_requestShopBranches(null, true);
        $this->_requestListDB(DB_Ab1_Transport_Type1c::NAME);
        $this->_requestListDB(DB_Ab1_Shop_Transport_Work::NAME, 1458614);
        $this->_requestListDB(
            'DB_Ab1_Shop_Subdivision', null, $this->_sitePageData->shopID,
            ['id' => $this->_sitePageData->operation->getProductShopSubdivisionIDsArray()]
        );

        $this->_putInMain('/main/_shop/report/index');
    }
}
