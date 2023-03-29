<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Magazine_Accounting_ShopOptions extends Controller_Magazine_Accounting_BasicMagazine {

    public function action_aura3() {
        $this->_sitePageData->url = '/accounting/shopoptions/aura3';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/move/one/new',
                '_shop/move/item/list/index',
            )
        );

        $this->_requestShopBranches(NULL, Model_Magazine_Shop::SHOP_TABLE_RUBRIC_MAGAZINE);

        $dataID = new MyArray();
        $dataID->id = 0;
        $dataID->isFindDB = TRUE;
        $this->_sitePageData->replaceDatas['view::_shop/move/item/list/index'] = Helpers_View::getViewObjects($dataID,
            new Model_Magazine_Shop_Move(), '_shop/move/item/list/index',
            '_shop/move/item/one/index', $this->_sitePageData, $this->_driverDB
        );


        $this->_putInMain('/main/_shop/options/aura');
    }
}
