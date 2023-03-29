<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_Peo_ShopActReviseItem extends Controller_Ab1_Peo_BasicAb1 {

    public function __construct(Request $request, Response $response)
    {
        $this->dbObject = 'DB_Ab1_Shop_Act_Revise_Item';
        $this->controllerName = 'shopactreviseitem';
        $this->tableID = Model_Ab1_Shop_Act_Revise_Item::TABLE_ID;
        $this->tableName = Model_Ab1_Shop_Act_Revise_Item::TABLE_NAME;
        $this->objectName = 'actreviseitem';

        parent::__construct($request, $response);
    }

    public function action_index() {
        $this->_sitePageData->url = '/peo/shopactreviseitem/index';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/act/revise/item/list/index',
            )
        );

        // получаем список
        View_View::findBranch('DB_Ab1_Shop_Act_Revise_Item',
            array(),
            "_shop/act/revise/item/list/index", "_shop/act/revise/item/one/index",
            $this->_sitePageData, $this->_driverDB,
            array('limit' => 1000, 'limit_page' => 25), array('shop_client_id' => array('name'))
        );

        $this->_putInMain('/main/_shop/act/revise/item/index');
    }

    public function action_client() {
        $this->_sitePageData->url = '/peo/shopactreviseitem/client';
        $this->_actionShopActReviseItemClient();
    }

    public function action_virtual() {
        $this->_sitePageData->url = '/peo/shopactreviseitem/virtual';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/act/revise/item/list/virtual',
            )
        );

        $shopClientID = Request_RequestParams::getParamInt('shop_client_id');

        $dateFrom = Request_RequestParams::getParamDate('date_from');
        if($dateFrom === NULL){
            $dateFrom = Helpers_DateTime::getMonthBeginStr(date('m'), date('Y'));
        }

        $dateTo = Request_RequestParams::getParamDate('date_to');
        if($dateTo === NULL){
            $dateTo = date('Y-m-d') . ' 23:59:59';
        }else{
            $dateTo = $dateTo . ' 23:59:59';
        }

        $ids = Api_Ab1_Shop_Act_Revise::getVirtualShopActRevises(
            $shopClientID, $dateFrom, $dateTo, $this->_sitePageData, $this->_driverDB
        );

        $result = Helpers_View::getViewObjects(
            $ids, new Model_Ab1_Shop_Act_Revise_Item(),
            "_shop/act/revise/item/list/virtual", "_shop/act/revise/item/one/virtual",
            $this->_sitePageData, $this->_driverDB, 0
        );
        $this->_sitePageData->replaceDatas['view::_shop/act/revise/item/list/virtual'] = $result;

        $this->_putInMain('/main/_shop/act/revise/item/virtual');
    }
}
