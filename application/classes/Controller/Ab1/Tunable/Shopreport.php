<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_Tunable_ShopReport extends Controller_Ab1_ShopReport {

    public function __construct(Request $request, Response $response)
    {
        $this->actionURLName = 'tunable';
        $this->prefixView = 'tunable';

        parent::__construct($request, $response);
        $this->_sitePageData->actionURLName = 'tunable';
        $this->_sitePageData->interfaceID = Model_Ab1_Shop_Operation::RUBRIC_TUNABLE;
    }

    public function action_index() {
        $this->_sitePageData->url = '/tunable/shopreport/index';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
            )
        );

        $this->_requestShopProductRubrics();
        $this->_requestShopMaterials();

        $this->_putInMain('/main/_shop/report/index');
    }
}
