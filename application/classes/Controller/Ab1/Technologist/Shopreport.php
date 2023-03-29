<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_Technologist_ShopReport extends Controller_Ab1_ShopReport {

    public function __construct(Request $request, Response $response)
    {
        $this->actionURLName = 'technologist';
        $this->prefixView = 'technologist';

        parent::__construct($request, $response);
        $this->_sitePageData->actionURLName = 'technologist';
        $this->_sitePageData->interfaceID = Model_Ab1_Shop_Operation::RUBRIC_TECHNOLOGIST;
    }

    public function action_index() {
        $this->_sitePageData->url = '/technologist/shopreport/index';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
            )
        );

        $data = $this->_requestShopClients(null, Model_Ab1_ClientType::CLIENT_TYPE_BUY_RAW);
        $this->_sitePageData->addReplaceAndGlobalDatas('view::_shop/boxcar/client/list/list', $data);
        $this->_requestShopRaws();
        $this->_requestShopProductRubrics();

        $this->_putInMain('/main/_shop/report/index');
    }
}
