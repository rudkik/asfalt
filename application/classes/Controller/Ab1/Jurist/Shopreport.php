<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_Jurist_ShopReport extends Controller_Ab1_ShopReport {

    public function __construct(Request $request, Response $response)
    {
        $this->actionURLName = 'jurist';
        $this->prefixView = 'jurist';

        parent::__construct($request, $response);
        $this->_sitePageData->actionURLName = 'jurist';
        $this->_sitePageData->interfaceID = Model_Ab1_Shop_Operation::RUBRIC_JURIST;
    }

    public function action_index() {
        $this->_sitePageData->url = '/jurist/shopreport/index';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
            )
        );

        $this->_requestShopMaterials();

        $this->_putInMain('/main/_shop/report/index');
    }
}
