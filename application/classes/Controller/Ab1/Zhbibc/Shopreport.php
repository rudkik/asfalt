<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_ZhbiBc_ShopReport extends Controller_Ab1_ShopReport {
    public function __construct(Request $request, Response $response)
    {
        $this->actionURLName = 'zhbibc';
        $this->prefixView = 'zhbibc';

        parent::__construct($request, $response);
        $this->_sitePageData->actionURLName = 'zhbibc';
        $this->_sitePageData->interfaceID = Model_Ab1_Shop_Operation::RUBRIC_ZHBIBC;
    }

    public function action_index() {
        $this->_sitePageData->url = '/zhbibc/shopreport/index';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
            )
        );

        $this->_requestShopProducts(
            null, 0, NULL, FALSE,
            [
                Model_Ab1_ProductView::PRODUCT_TYPE_CAR,
                Model_Ab1_ProductView::PRODUCT_TYPE_CAR_AND_PIECE,
                Model_Ab1_ProductView::PRODUCT_TYPE_PIECE
            ]
        );
        $this->_requestShopBranches(NULL, TRUE);
        $this->_requestShopSubdivisions();
        $this->_requestShopMaterialRubrics();
        $this->_requestShopProductRubrics([84598, 1081226], 0, ['id' => [84598, 1081226]]);
        $this->_requestShopClients(null, Model_Ab1_ClientType::CLIENT_TYPE_LESSEE);
        $this->_putInMain('/main/_shop/report/index');
    }
}
