<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_Weighted_ShopProduct extends Controller_Ab1_Weighted_BasicAb1 {

    public function __construct(Request $request, Response $response)
    {
        $this->dbObject = 'DB_Ab1_Shop_Product';
        $this->controllerName = 'shopproduct';
        $this->tableID = Model_Ab1_Shop_Product::TABLE_ID;
        $this->tableName = Model_Ab1_Shop_Product::TABLE_NAME;
        $this->objectName = 'product';

        parent::__construct($request, $response);
    }

    public function action_get_price()
    {
        $this->_sitePageData->url = '/weighted/shopproduct/get_price';

        $shopClientID = intval(Request_RequestParams::getParamInt('shop_client_id'));
        $shopClientContractID = intval(Request_RequestParams::getParamInt('shop_client_contract_id'));
        $shopProductID = intval(Request_RequestParams::getParamInt('shop_product_id'));
        $quantity = floatval(Request_RequestParams::getParamFloat('quantity'));
        $date = Request_RequestParams::getParamDateTime('date');
        $isCharity = Request_RequestParams::getParamBoolean('is_charity') == true;

        $result = Api_Ab1_Shop_Product::getPrice(
            $shopClientID, $shopClientContractID, 0, $shopProductID, $isCharity, $quantity,
            $this->_sitePageData, $this->_driverDB, true, $date
        );

        $result['shop_client_id'] = $shopClientID;
        $result['shop_client_contract_id'] = $shopClientContractID;
        $result['shop_product_id'] = $shopProductID;
        $result['quantity'] = $quantity;
        $result['date'] = $date;

        $this->response->body(Json::json_encode($result));
    }
}
