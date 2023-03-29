<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_Train_ShopReport extends Controller_Ab1_ShopReport {

    public function __construct(Request $request, Response $response)
    {
        $this->actionURLName = 'train';
        $this->prefixView = 'train';

        parent::__construct($request, $response);
        $this->_sitePageData->actionURLName = 'train';
        $this->_sitePageData->interfaceID = Model_Ab1_Shop_Operation::RUBRIC_TRAIN;
    }

    public function action_index() {
        $this->_sitePageData->url = '/train/shopreport/index';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
            )
        );

        $data = $this->_requestShopClients(null, Model_Ab1_ClientType::CLIENT_TYPE_BUY_RAW);
        $this->_sitePageData->addReplaceAndGlobalDatas('view::_shop/boxcar/client/list/list', $data);
        $this->_requestShopRaws();

        $this->_putInMain('/main/_shop/report/index');
    }
}
