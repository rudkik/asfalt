<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_Sbyt_ShopDeliveryDiscount extends Controller_Ab1_Sbyt_BasicAb1 {

    public function __construct(Request $request, Response $response)
    {
        $this->dbObject = 'DB_Ab1_Shop_Delivery_Discount';
        $this->controllerName = 'shopdeliverydiscount';
        $this->tableID = Model_Ab1_Shop_Delivery_Discount::TABLE_ID;
        $this->tableName = Model_Ab1_Shop_Delivery_Discount::TABLE_NAME;

        parent::__construct($request, $response);

        $this->shopID = $this->_sitePageData->shopID;
        $this->editAndNewBasicTemplate = '';
    }

    
    public function action_index()
    {
        $this->_sitePageData->url = '/sbyt/shopdeliverydiscount/index';

            $this->_requestListDB('DB_Ab1_Shop_Client');
    
        parent::_actionIndex(
            array(
                'shop_client_id' => ['name'],
            )
        );

    }

    public function action_new(){
        $this->_sitePageData->url = '/sbyt/shopdeliverydiscount/new';

        $this->_actionShopDeliveryDiscountNew();
    }

    public function action_edit(){
        $this->_sitePageData->url = '/sbyt/shopdeliverydiscount/edit';

        $this->_actionShopDeliveryDiscountEdit();
    }

    public function action_save()
    {
        $this->_sitePageData->url = '/sbyt/shopdeliverydiscount/save';

        $result = Api_Ab1_Shop_Delivery_Discount::save($this->_sitePageData, $this->_driverDB);
        $this->_redirectSaveResult($result);
    }


    public function action_calc_balance()
    {
        $this->_sitePageData->url = '/sbyt/shopdeliverydiscount/calc_balance';

        $id = Request_RequestParams::getParamInt('id');

        $params = Request_RequestParams::setParams(
            array(
                'shop_delivery_discount_id' => $id,
            )
        );
        $ids = Request_Request::find('DB_Ab1_Shop_Delivery_Discount_Item',
            $this->_sitePageData->shopMainID, $this->_sitePageData, $this->_driverDB, $params
        );

        foreach ($ids->childs as $child){
            Api_Ab1_Shop_Delivery_Discount_Item::calcBalanceBlock(
                $child->id, $this->_sitePageData, $this->_driverDB
            );
        }

        $this->redirect('/sbyt/shopdeliverydiscount/index?id='.$id);
    }
}
