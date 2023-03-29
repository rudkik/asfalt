<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_Bid_ShopReport extends Controller_Ab1_ShopReport {

    public function __construct(Request $request, Response $response)
    {
        $this->actionURLName = 'bid';
        $this->prefixView = 'bid';

        parent::__construct($request, $response);
        $this->_sitePageData->actionURLName = 'bid';
        $this->_sitePageData->interfaceID = Model_Ab1_Shop_Operation::RUBRIC_BID;
    }

    public function action_index() {
        $this->_sitePageData->url = '/bid/shopreport/index';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
            )
        );

        $this->_requestShopProductRubrics();
        $this->_requestShopBranches($this->_sitePageData->shopID, TRUE);
        $this->_requestShopProducts(
            null, 0, NULL, FALSE,
            [
                Model_Ab1_ProductView::PRODUCT_TYPE_CAR,
                Model_Ab1_ProductView::PRODUCT_TYPE_CAR_AND_PIECE,
            ]
        );
        $this->_putInMain('/main/_shop/report/index');
    }
}
