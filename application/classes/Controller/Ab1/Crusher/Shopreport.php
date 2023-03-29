<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_Crusher_ShopReport extends Controller_Ab1_ShopReport {

    public function __construct(Request $request, Response $response)
    {
        $this->actionURLName = 'crusher';
        $this->prefixView = 'crusher';

        parent::__construct($request, $response);
        $this->_sitePageData->actionURLName = 'crusher';
        $this->_sitePageData->interfaceID = Model_Ab1_Shop_Operation::RUBRIC_CRUSHER;
    }

    public function action_index() {
        $this->_sitePageData->url = '/crusher/shopreport/index';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
            )
        );

        $this->_requestShopMaterials();

        $this->_putInMain('/main/_shop/report/index');
    }
}
