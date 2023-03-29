<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Magazine_Accounting_ShopTotal extends Controller_Magazine_Accounting_BasicMagazine {

    public function action_index() {
        $this->_sitePageData->url = '/accounting/shoptotal/index';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/total/list/index',
            )
        );

        $this->_requestShopProducts(null, $this->_sitePageData->shopMainID);

        $dateFrom = Request_RequestParams::getParamDate('date_from');
        if($dateFrom === NULL){
            $dateFrom = date('Y-m').'-01';
        }
        $this->_sitePageData->urlParams['date_from'] = $dateFrom;

        $dateTo = Request_RequestParams::getParamDate('date_to');
        if($dateTo === NULL){
            $dateTo = Helpers_DateTime::getMonthEndStr(date('m'), date('Y'));
        }
        $this->_sitePageData->urlParams['date_to'] = $dateTo;

        $shopProductIDs = Api_Magazine_Shop_Total::getShopProductTotal(
            $dateFrom, $dateTo, $this->_sitePageData, $this->_driverDB,
            Request_RequestParams::getParamInt('shop_product_id')
        );

        $this->_sitePageData->replaceDatas['view::_shop/total/list/index'] = Helpers_View::getViewObjects(
            $shopProductIDs, new Model_Magazine_Shop_Product(),
            "_shop/total/list/index", "_shop/total/one/index",
            $this->_sitePageData, $this->_driverDB, $this->_sitePageData->shopID
        );

        $this->_putInMain('/main/_shop/total/index');
    }
}
