<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_Ballast_ShopReport extends Controller_Ab1_ShopReport {

    public function __construct(Request $request, Response $response)
    {
        $this->actionURLName = 'ballast';
        $this->prefixView = 'ballast';

        parent::__construct($request, $response);
        $this->_sitePageData->actionURLName = 'ballast';
        $this->_sitePageData->interfaceID = Model_Ab1_Shop_Operation::RUBRIC_BALLAST;
    }

    public function action_index() {
        $this->_sitePageData->url = '/ballast/shopreport/index';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
            )
        );

        if($this->_sitePageData->operation->getIsAdmin()){
            $this->_requestShopBallastCarsBranches();
            $this->_requestShopBallastDriversBranches();
            $this->_requestShopWorkShiftsBranches();
        }else {
            $this->_requestShopBallastCars();
            $this->_requestShopBallastDrivers();
            $this->_requestShopWorkShifts();
        }
        $this->_requestShopBranches(NULL, TRUE);

        $this->_putInMain('/main/_shop/report/index');
    }
}
