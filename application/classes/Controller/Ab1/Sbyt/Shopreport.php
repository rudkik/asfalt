<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_Sbyt_ShopReport extends Controller_Ab1_ShopReport {

    public function __construct(Request $request, Response $response)
    {
        $this->actionURLName = 'sbyt';
        $this->prefixView = 'sbyt';
        parent::__construct($request, $response);
        $this->_sitePageData->actionURLName = 'sbyt';
        $this->_sitePageData->interfaceID = Model_Ab1_Shop_Operation::RUBRIC_SBYT;
    }

    public function action_index() {
        $this->_sitePageData->url = '/sbyt/shopreport/index';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
            )
        );

        // основная продукция
        $this->_requestShopProducts(
            null, 0, NULL, FALSE,
            [
                Model_Ab1_ProductView::PRODUCT_TYPE_CAR,
                Model_Ab1_ProductView::PRODUCT_TYPE_CAR_AND_PIECE,
                Model_Ab1_ProductView::PRODUCT_TYPE_PIECE
            ]
        );

        $this->_requestShopSubdivisions();
        $this->_requestOrganizationTypes();
        $this->_requestShopProductRubrics();
        $this->_requestShopBranches(NULL, TRUE);
        $this->_putInMain('/main/_shop/report/index');
    }
}
