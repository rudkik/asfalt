<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_Sbyt_ShopCarItem extends Controller_Ab1_Sbyt_BasicAb1 {

    public function __construct(Request $request, Response $response)
    {
        $this->dbObject = 'DB_Ab1_Shop_Car_Item';
        $this->controllerName = 'shopcaritem';
        $this->tableID = Model_Ab1_Shop_Car_Item::TABLE_ID;
        $this->tableName = Model_Ab1_Shop_Car_Item::TABLE_NAME;
        $this->objectName = 'caritem';

        parent::__construct($request, $response);
    }

    public function action_index()
    {
        $this->_sitePageData->url = '/sbyt/shopcaritem/index';

        $this->_actionShopCarItemIndex();
    }

    public function action_product_price() {
        $this->_sitePageData->url = '/sbyt/shopcaritem/product_price';

        $this->_actionShopCarItemProductPrice();
    }

    public function action_attorney() {
        $this->_sitePageData->url = '/sbyt/shopcaritem/attorney';

        $this->_actionShopCarItemAttorney();
    }

    public function action_invoice() {
        $this->_sitePageData->url = '/sbyt/shopcaritem/invoice';

        $this->_actionShopCarItemInvoice();
    }

    public function action_balance_day() {
        $this->_sitePageData->url = '/sbyt/shopcaritem/balance_day';

        $this->_actionShopCarItemBalanceDay();
    }

    public function action_contract() {
        $this->_sitePageData->url = '/sbyt/shopcaritem/contract';

        $this->_actionShopCarItemContract();
    }

    public function action_save()
    {
        $this->_sitePageData->url = '/sbyt/shopcaritem/save';

        $result = Api_Ab1_Shop_Car_Item::saveItem($this->_sitePageData, $this->_driverDB);
        $this->_redirectSaveResult($result, '/sbyt/shopcaritem/history');
    }
}
