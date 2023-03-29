<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_Owner_ShopReport extends Controller_Ab1_ShopReport {

    public function __construct(Request $request, Response $response)
    {
        $this->actionURLName = 'owner';
        $this->prefixView = 'owner';

        parent::__construct($request, $response);
        $this->_sitePageData->actionURLName = 'owner';
        $this->_sitePageData->interfaceID = Model_Ab1_Shop_Operation::RUBRIC_OWNER;
    }

    public function action_index() {
        $this->_sitePageData->url = '/owner/shopreport/index';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
            )
        );
        $this->_requestShopMaterials();
        $this->_requestShopProductRubrics();
        $this->_requestShopMaterialRubrics();
        $this->_requestShopOperations(Model_Ab1_Shop_Operation::RUBRIC_WEIGHT);

        $this->_putInMain('/main/_shop/report/index');
    }
}
