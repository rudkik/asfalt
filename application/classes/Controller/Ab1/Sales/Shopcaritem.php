<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_Sales_ShopCarItem extends Controller_Ab1_Sales_BasicAb1 {

    public function __construct(Request $request, Response $response)
    {
        $this->dbObject = 'DB_Ab1_Shop_Car_Item';
        $this->controllerName = 'shopcaritem';
        $this->tableID = Model_Ab1_Shop_Car_Item::TABLE_ID;
        $this->tableName = Model_Ab1_Shop_Car_Item::TABLE_NAME;
        $this->objectName = 'caritem';

        parent::__construct($request, $response);
    }

    public function action_index() {
        $this->_sitePageData->url = '/sales/shopcaritem/index';

        $id = Request_RequestParams::getParamInt('shop_client_contract_item_id');
        if($id > 0) {
            View_View::findOne('DB_Ab1_Shop_Client_Contract_Item',
                $this->_sitePageData->shopMainID,
                "_shop/client/contract/item/one/show",
                $this->_sitePageData, $this->_driverDB,
                array(
                    'id' => $id
                ),
                array('shop_product_id', 'shop_client_contract_id')
            );
        }else{
            $id = Request_RequestParams::getParamInt('shop_client_contract_id');
            if($id > 0) {
                View_View::findOne('DB_Ab1_Shop_Client_Contract',
                    $this->_sitePageData->shopMainID,
                    "_shop/client/contract/one/show",
                    $this->_sitePageData, $this->_driverDB,
                    array(
                        'id' => $id
                    ),
                    array('shop_client_contract_id')
                );
            }else{
                View_View::findOne('DB_Ab1_Shop_Client_Balance_Day',
                    $this->_sitePageData->shopMainID,
                    "_shop/client/balance/day/one/show",
                    $this->_sitePageData, $this->_driverDB,
                    array(
                        'id' => Request_RequestParams::getParamInt('shop_client_balance_day_id')
                    )
                );
            }
        }

        $ids = Request_Request::findBranch('DB_Ab1_Shop_Car_Item',
            array(), $this->_sitePageData, $this->_driverDB,
            array(), 1000, true,
            array(
                'shop_car_id' => array('name', 'weighted_exit_at', 'created_at'),
                'shop_product_id' => array('name'),
            )
        );

        $pieceIDs = Request_Request::findBranch('DB_Ab1_Shop_Piece_Item',
            array(), $this->_sitePageData, $this->_driverDB,
            array(), 1000, true,
            array(
                'shop_piece_id' => array('name', 'created_at'),
                'shop_product_id' => array('name'),
            )
        );

        $ids->addChilds($pieceIDs);

        $sortBy = Request_RequestParams::getParamArray('sort_by');
        if($sortBy === null){
            $sortBy = array('id' => 'desc');
        }
        $ids->childsSortBy($sortBy, true, true);
        $this->_sitePageData->urlParams['sort_by'] = $sortBy;

        $this->_sitePageData->addReplaceAndGlobalDatas(
            'view::_shop/car/item/list/index',
            Helpers_View::getViewObjects(
                $ids, new Model_Shop_Car(),
                '_shop/car/item/list/index', '_shop/car/item/one/index',
                $this->_sitePageData, $this->_driverDB, 0
            )
        );
        $this->_putInMain('/main/_shop/car/item/index');
    }

    public function action_invoice() {
        $this->_sitePageData->url = '/sales/shopcaritem/invoice';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/invoice/list/index',
                'view::_shop/client/contract/item/one/show',
            )
        );

        $shopClientContractItemID = Request_RequestParams::getParamInt('shop_client_contract_item_id');
        if($shopClientContractItemID < 1){
            throw new HTTP_Exception_500('Client contract item not found.');
        }

        View_View::findOne('DB_Ab1_Shop_Client_Contract_Item',
            $this->_sitePageData->shopMainID,
            "_shop/client/contract/item/one/show",
            $this->_sitePageData, $this->_driverDB,
            array('id' => $shopClientContractItemID),
            array('shop_product_id', 'shop_client_contract_id')
        );

        $params = Request_RequestParams::setParams(
            array(
                'shop_client_contract_item_id' => $shopClientContractItemID
            )
        );

        $ids = Request_Request::findBranch('DB_Ab1_Shop_Car_Item',
            array(), $this->_sitePageData, $this->_driverDB,
            $params, 1000, true
        );

        $pieceIDs = Request_Request::findBranch('DB_Ab1_Shop_Piece_Item',
            array(), $this->_sitePageData, $this->_driverDB,
            $params, 1000, true
        );

        $ids->addChilds($pieceIDs);
        $ids = $ids->getChildArrayInt('shop_invoice_id');

        if(count($ids) > 0) {
            $params = Request_RequestParams::setParams(
                array(
                    'limit_page' => 25,
                    'id' => $ids,
                    'sort_by' => array(
                        'date' => 'desc',
                        'created_at' => 'desc',
                    )
                ),
                FALSE
            );

            $ids = Request_Request::findBranch('DB_Ab1_Shop_Invoice',
                array(), $this->_sitePageData, $this->_driverDB, $params, 0, true,
                array(
                    'shop_client_id' => array('name'),
                    'shop_client_attorney_id' => array('number'),
                    'shop_client_contract_id' => array('number'),
                    'product_type_id' => array('name'),
                    'check_type_id' => array('name'),
                )
            );
        }else{
            $ids = new MyArray();
        }

        $this->_sitePageData->replaceDatas['view::_shop/invoice/list/index'] =
            Helpers_View::getViewObjects(
                $ids, new Model_Ab1_Shop_Invoice(),
                "_shop/invoice/list/index", "_shop/invoice/one/index",
                $this->_sitePageData, $this->_driverDB, 0
            );

        $this->_putInMain('/main/_shop/car/item/invoice');
    }

    public function action_balance_day() {
        $this->_sitePageData->url = '/sales/shopcaritem/balance_day';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/invoice/list/index',
                'view::_shop/client/contract/item/one/show',
            )
        );

        $shopClientBalanceDayID = Request_RequestParams::getParamInt('shop_client_balance_day_id');
        if($shopClientBalanceDayID < 1){
            throw new HTTP_Exception_500('Client balance day not found.');
        }

        View_View::findOne('DB_Ab1_Shop_Client_Balance_Day',
            $this->_sitePageData->shopMainID,
            "_shop/client/balance/day/one/show",
            $this->_sitePageData, $this->_driverDB,
            array('id' => $shopClientBalanceDayID)
        );

        $params = Request_RequestParams::setParams(
            array(
                'shop_client_balance_day_id' => $shopClientBalanceDayID
            )
        );

        $ids = Request_Request::findBranch('DB_Ab1_Shop_Car_Item',
            array(), $this->_sitePageData, $this->_driverDB,
            $params, 1000, true
        );

        $pieceIDs = Request_Request::findBranch('DB_Ab1_Shop_Piece_Item',
            array(), $this->_sitePageData, $this->_driverDB,
            $params, 1000, true
        );

        $ids->addChilds($pieceIDs);
        $ids = $ids->getChildArrayInt('shop_invoice_id');

        if(count($ids) > 0) {
            $params = Request_RequestParams::setParams(
                array(
                    'limit_page' => 25,
                    'id' => $ids,
                    'sort_by' => array(
                        'date' => 'desc',
                        'created_at' => 'desc',
                    )
                ),
                FALSE
            );

            $ids = Request_Request::findBranch('DB_Ab1_Shop_Invoice',
                array(), $this->_sitePageData, $this->_driverDB, $params, 0, true,
                array(
                    'shop_client_id' => array('name'),
                    'shop_client_attorney_id' => array('number'),
                    'shop_client_contract_id' => array('number'),
                    'product_type_id' => array('name'),
                    'check_type_id' => array('name'),
                )
            );
        }else{
            $ids = new MyArray();
        }

        $this->_sitePageData->replaceDatas['view::_shop/invoice/list/index'] =
            Helpers_View::getViewObjects(
                $ids, new Model_Ab1_Shop_Invoice(),
                "_shop/invoice/list/index", "_shop/invoice/one/index",
                $this->_sitePageData, $this->_driverDB, 0
            );

        $this->_putInMain('/main/_shop/car/item/balance-day');
    }

    public function action_contract() {
        $this->_sitePageData->url = '/sales/shopcaritem/contract';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/invoice/list/index',
                'view::_shop/client/contract/one/show',
            )
        );

        $shopClientContractID = Request_RequestParams::getParamInt('shop_client_contract_id');
        if($shopClientContractID < 1){
            throw new HTTP_Exception_500('Client contract not found.');
        }

        View_View::findOne(
            'DB_Ab1_Shop_Client_Contract',
            $this->_sitePageData->shopMainID,
            "_shop/client/contract/one/show",
            $this->_sitePageData, $this->_driverDB,
            array('id' => $shopClientContractID),
            array('shop_product_id')
        );

        $params = Request_RequestParams::setParams(
            array(
                'shop_client_contract_id' => $shopClientContractID
            )
        );

        $ids = Request_Request::findBranch(
            'DB_Ab1_Shop_Car_Item',
            array(), $this->_sitePageData, $this->_driverDB,
            $params, 1000, true
        );

        $pieceIDs = Request_Request::findBranch(
            'DB_Ab1_Shop_Piece_Item',
            array(), $this->_sitePageData, $this->_driverDB,
            $params, 1000, true
        );

        $ids->addChilds($pieceIDs);
        $ids = $ids->getChildArrayInt('shop_invoice_id');

        if(count($ids) > 0) {
            $params = Request_RequestParams::setParams(
                array(
                    'limit_page' => 25,
                    'id' => $ids,
                    'sort_by' => array(
                        'date' => 'desc',
                        'created_at' => 'desc',
                    )
                ),
                FALSE
            );

            $ids = Request_Request::findBranch(
                'DB_Ab1_Shop_Invoice',
                array(), $this->_sitePageData, $this->_driverDB, $params, 0, true,
                array(
                    'shop_client_id' => array('name'),
                    'shop_client_attorney_id' => array('number'),
                    'shop_client_contract_id' => array('number'),
                    'product_type_id' => array('name'),
                    'check_type_id' => array('name'),
                )
            );
        }else{
            $ids = new MyArray();
        }

        $this->_sitePageData->replaceDatas['view::_shop/invoice/list/index'] =
            Helpers_View::getViewObjects(
                $ids, new Model_Ab1_Shop_Invoice(),
                "_shop/invoice/list/index", "_shop/invoice/one/index",
                $this->_sitePageData, $this->_driverDB, 0
            );

        $this->_putInMain('/main/_shop/car/item/contract');
    }

    public function action_save()
    {
        $this->_sitePageData->url = '/sales/shopcaritem/save';

        $result = Api_Ab1_Shop_Car_Item::saveItem($this->_sitePageData, $this->_driverDB);
        $this->_redirectSaveResult($result, '/sales/shopcaritem/history');
    }
}

