<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_Cash_ShopClientContract extends Controller_Ab1_Cash_BasicAb1 {

    public function __construct(Request $request, Response $response)
    {
        $this->dbObject = 'DB_Ab1_Shop_Client_Contract';
        $this->controllerName = 'shopclientcontract';
        $this->tableID = Model_Ab1_Shop_Client_Contract::TABLE_ID;
        $this->tableName = Model_Ab1_Shop_Client_Contract::TABLE_NAME;
        $this->objectName = 'clientcontract';

        parent::__construct($request, $response);
    }

    public function action_json() {
        $this->_sitePageData->url = '/cash/shopclientcontract/json';
        $this->_getJSONList(
            $this->_sitePageData->shopMainID,
            Request_RequestParams::setParams(
                array(
                    'client_contract_type_id' => Model_Ab1_ClientContract_Type::CLIENT_CONTRACT_TYPE_SALE_PRODUCT,
                    'is_basic' => true,
                    'sort_by' => array(
                        'number' => 'desc'
                    )
                )
            )
        );
    }
}
