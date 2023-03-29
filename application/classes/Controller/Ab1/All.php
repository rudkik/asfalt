<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_All extends Controller_Ab1_BasicList
{
    public function _actionShopCarItemProductPrice() {
        $shopProductPriceID = Request_RequestParams::getParamInt('shop_product_price_id');
        if($shopProductPriceID < 1){
            throw new HTTP_Exception_500('Product price not found.');
        }

        $this->_sitePageData->newShopShablonPath('ab1/_all');

        View_View::findOne(
            'DB_Ab1_Shop_Product_Price',
            0,
            "_shop/product/price/one/show",
            $this->_sitePageData, $this->_driverDB,
            Request_RequestParams::setParams(['id' => $shopProductPriceID]),
            array(
                'shop_pricelist_id.shop_client_id' => array('name'),
                'shop_pricelist_id' => array('from_at', 'to_at'),
            )
        );

        $params = Request_RequestParams::setParams(
            array(
                'shop_product_price_id' => $shopProductPriceID
            )
        );

        $ids = Request_Request::findBranch(
            'DB_Ab1_Shop_Car_Item',
            array(), $this->_sitePageData, $this->_driverDB,
            $params, 1000, true, [], ['shop_invoice_id']
        );

        $pieceIDs = Request_Request::findBranch(
            'DB_Ab1_Shop_Piece_Item',
            array(), $this->_sitePageData, $this->_driverDB,
            $params, 1000, true, [], ['shop_invoice_id']
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

        $this->_sitePageData->addReplaceAndGlobalDatas(
            'view::_shop/invoice/list/decryption',
            Helpers_View::getViewObjects(
                $ids, new Model_Ab1_Shop_Invoice(),
                "_shop/invoice/list/decryption", "_shop/invoice/one/decryption",
                $this->_sitePageData, $this->_driverDB, 0
            )
        );

        $this->_sitePageData->previousShopShablonPath();

        $this->_putInMain('/main/_shop/car/item/product-price', 'ab1/_all');
    }

    public function _actionShopCarItemAttorney() {
        $shopClientAttorneyID = Request_RequestParams::getParamInt('shop_client_attorney_id');
        if($shopClientAttorneyID < 1){
            throw new HTTP_Exception_500('Client attorney not found.');
        }

        $this->_sitePageData->newShopShablonPath('ab1/_all');

        View_View::findOne(
            'DB_Ab1_Shop_Client_Attorney',
            0,
            "_shop/client/attorney/one/show",
            $this->_sitePageData, $this->_driverDB,
            Request_RequestParams::setParams(['id' => $shopClientAttorneyID]),
            array(
                'shop_client_id' => array('name'),
            )
        );

        $params = Request_RequestParams::setParams(
            array(
                'shop_client_attorney_id' => $shopClientAttorneyID
            )
        );

        $ids = Request_Request::findBranch(
            'DB_Ab1_Shop_Car_Item',
            array(), $this->_sitePageData, $this->_driverDB,
            $params, 1000, true, [], ['shop_invoice_id']
        );

        $pieceIDs = Request_Request::findBranch(
            'DB_Ab1_Shop_Piece_Item',
            array(), $this->_sitePageData, $this->_driverDB,
            $params, 1000, true, [], ['shop_invoice_id']
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

        $this->_sitePageData->addReplaceAndGlobalDatas(
            'view::_shop/invoice/list/decryption',
            Helpers_View::getViewObjects(
                $ids, new Model_Ab1_Shop_Invoice(),
                "_shop/invoice/list/decryption", "_shop/invoice/one/decryption",
                $this->_sitePageData, $this->_driverDB, 0
            )
        );

        $this->_sitePageData->previousShopShablonPath();

        $this->_putInMain('/main/_shop/car/item/attorney', 'ab1/_all');
    }

    public function _actionShopCarItemInvoice() {
        $shopClientContractItemID = Request_RequestParams::getParamInt('shop_client_contract_item_id');
        if($shopClientContractItemID < 1){
            throw new HTTP_Exception_500('Client contract item not found.');
        }

        $this->_sitePageData->newShopShablonPath('ab1/_all');

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

        $this->_sitePageData->addReplaceAndGlobalDatas(
            'view::_shop/invoice/list/decryption',
            Helpers_View::getViewObjects(
                $ids, new Model_Ab1_Shop_Invoice(),
                "_shop/invoice/list/decryption", "_shop/invoice/one/decryption",
                $this->_sitePageData, $this->_driverDB, 0
            )
        );

        $this->_sitePageData->previousShopShablonPath();

        $this->_putInMain('/main/_shop/car/item/invoice', 'ab1/_all');
    }

    public function _actionShopCarItemBalanceDay() {
        $shopClientBalanceDayID = Request_RequestParams::getParamInt('shop_client_balance_day_id');
        if($shopClientBalanceDayID < 1){
            throw new HTTP_Exception_500('Client balance day not found.');
        }

        $this->_sitePageData->newShopShablonPath('ab1/_all');

        View_View::findOne('DB_Ab1_Shop_Client_Balance_Day',
            $this->_sitePageData->shopMainID,
            "_shop/client/balance/day/one/show",
            $this->_sitePageData, $this->_driverDB,
            array('id' => $shopClientBalanceDayID)
        );

        $shopInvoices = [];

        $params = Request_RequestParams::setParams(
            array(
                'shop_client_balance_day_id' => $shopClientBalanceDayID
            )
        );

        $ids = Request_Request::findBranch(
            'DB_Ab1_Shop_Client_Balance_Day_Item',
            array(), $this->_sitePageData, $this->_driverDB,
            $params, 1000, true
        );

        $shopCars = $ids->getChildArrayInt('shop_car_id');
        if(count($shopCars) > 0) {
            $shopCarIDs = Request_Request::findBranch('DB_Ab1_Shop_Car_Item',
                array(), $this->_sitePageData, $this->_driverDB,
                Request_RequestParams::setParams(['shop_car_id' => $shopCars, 'shop_invoice_id_from' => 0]),
                1000, true
            );

            $shopInvoices = $shopCarIDs->getChildArrayInt('shop_invoice_id');
        }


        $shopPieces = $ids->getChildArrayInt('shop_piece_id');
        if(count($shopPieces) > 0) {
            $shopPieceIDs = Request_Request::findBranch('DB_Ab1_Shop_Piece_Item',
                array(), $this->_sitePageData, $this->_driverDB,
                Request_RequestParams::setParams(['shop_piece_id' => $shopPieces, 'shop_invoice_id_from' => 0]),
                1000, true
            );

            $shopInvoices = array_merge($shopInvoices, $shopPieceIDs->getChildArrayInt('shop_invoice_id'));
        }

        if(count($shopInvoices) > 0) {
            $params = Request_RequestParams::setParams(
                array(
                    'limit_page' => 25,
                    'id' => $shopInvoices,
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

        $this->_sitePageData->addReplaceAndGlobalDatas(
            'view::_shop/invoice/list/decryption',
            Helpers_View::getViewObjects(
                $ids, new Model_Ab1_Shop_Invoice(),
                "_shop/invoice/list/decryption", "_shop/invoice/one/decryption",
                $this->_sitePageData, $this->_driverDB, 0
            )
        );

        $this->_sitePageData->previousShopShablonPath();

        $this->_putInMain('/main/_shop/car/item/balance-day', 'ab1/_all');
    }

    public function _actionShopCarItemContract() {
        $shopClientContractID = Request_RequestParams::getParamInt('shop_client_contract_id');
        if($shopClientContractID < 1){
            throw new HTTP_Exception_500('Client contract not found.');
        }

        $this->_sitePageData->newShopShablonPath('ab1/_all');

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

        $this->_sitePageData->addReplaceAndGlobalDatas(
            'view::_shop/invoice/list/decryption',
            Helpers_View::getViewObjects(
                $ids, new Model_Ab1_Shop_Invoice(),
                "_shop/invoice/list/decryption", "_shop/invoice/one/decryption",
                $this->_sitePageData, $this->_driverDB, 0
            )
        );

        $this->_sitePageData->previousShopShablonPath();

        $this->_putInMain('/main/_shop/car/item/contract', 'ab1/_all');
    }

    public function _actionShopCarItemIndex() {
        $this->_sitePageData->newShopShablonPath('ab1/_all');

        $id = Request_RequestParams::getParamInt('shop_client_contract_item_id');
        if($id > 0) {
            View_View::findOne('DB_Ab1_Shop_Client_Contract_Item',
                $this->_sitePageData->shopMainID,
                "_shop/client/contract/item/one/show",
                $this->_sitePageData, $this->_driverDB,
                Request_RequestParams::setParams(['id' => $id]),
                array('shop_product_id', 'shop_client_contract_id')
            );
        }else{
            $id = Request_RequestParams::getParamInt('shop_client_contract_id');
            if($id > 0) {
                View_View::findOne('DB_Ab1_Shop_Client_Contract',
                    $this->_sitePageData->shopMainID,
                    "_shop/client/contract/one/show",
                    $this->_sitePageData, $this->_driverDB,
                    Request_RequestParams::setParams(['id' => $id])
                );
            }else{
                $id = Request_RequestParams::getParamInt('shop_client_id');
                if($id > 0) {
                    View_View::findOne('DB_Ab1_Shop_Client',
                        $this->_sitePageData->shopMainID,
                        "_shop/client/one/show",
                        $this->_sitePageData, $this->_driverDB,
                        Request_RequestParams::setParams(['id' => $id])
                    );
                }else {
                    $id = Request_RequestParams::getParamInt('shop_client_attorney_id');
                    if($id > 0) {
                        View_View::findOne('DB_Ab1_Shop_Client_Attorney',
                            $this->_sitePageData->shopMainID,
                            "_shop/client/attorney/one/show",
                            $this->_sitePageData, $this->_driverDB,
                            Request_RequestParams::setParams(['id' => $id]),
                            array('shop_client_id' => ['name'])
                        );
                    }else {
                        $id = Request_RequestParams::getParamInt('shop_product_price_id');
                        if($id > 0) {
                            View_View::findOne('DB_Ab1_Shop_Product_Price',
                                $this->_sitePageData->shopMainID,
                                "_shop/product/price/one/show",
                                $this->_sitePageData, $this->_driverDB,
                                Request_RequestParams::setParams(['id' => $id]),
                                array(
                                    'shop_pricelist_id.shop_client_id' => array('name'),
                                    'shop_pricelist_id' => array('from_at', 'to_at'),
                                )
                            );
                        }else {
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
                }
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

        $this->_sitePageData->previousShopShablonPath();

        $this->_putInMain('/main/_shop/car/item/index', 'ab1/_all');
    }

    public function _actionShopInvoiceMoneyType() {
        $shopClientID = Request_RequestParams::getParamInt('shop_client_id');
        if($shopClientID < 1){
            throw new HTTP_Exception_500('Client not found.');
        }

        $this->_sitePageData->newShopShablonPath('ab1/_all');

        View_View::findOne(
            'DB_Ab1_Shop_Client', $this->_sitePageData->shopMainID, "_shop/client/one/show",
            $this->_sitePageData, $this->_driverDB, array('id' => $shopClientID)
        );

        $params = Request_RequestParams::setParams(
            array(
                'shop_client_id' => $shopClientID,
                'is_cash' => Request_RequestParams::getParamBoolean('is_cash'),
                'limit_page' => 25,
            )
        );

        View_View::find(
            'DB_Ab1_Shop_Invoice', 0,
            "_shop/invoice/list/decryption", "_shop/invoice/one/decryption",
            $this->_sitePageData, $this->_driverDB, $params,
            array(
                'shop_client_id' => array('name'),
                'shop_client_attorney_id' => array('number'),
                'shop_client_contract_id' => array('number'),
                'product_type_id' => array('name'),
                'check_type_id' => array('name'),
            )
        );

        $this->_sitePageData->previousShopShablonPath();

        $this->_putInMain('/main/_shop/invoice/money-type', 'ab1/_all');
    }

    public function _actionShopWorkerIndex() {

        $this->_requestListDB('DB_Ab1_Shop_Worker', null, 0, ['shop_department_id' => $this->_sitePageData->operation->getShopDepartmentID()]);
        $this->_requestListDB('DB_Magazine_Shop_Card', null, 0, ['is_constant' => false]);

        $this->_requestListDB('DB_Ab1_Shop_Department', null, $this->_sitePageData->shopID);

        parent::_actionIndex(
            array(
                'shop_worker_passage_id' => array('name'),
                'exit_shop_worker_passage_id' => array('name'),
                'shop_worker_id' => array('name'),
                'shop_department_id' => array('name'),
                'shop_card_id' => array('name'),
                'guest_id' => array('name'),
            ),
            [
                'shop_worker_id.shop_department_id' => $this->_sitePageData->operation->getShopDepartmentID(),
                'is_inside_move' => false,
                'sort_by' => ['updated_at' => 'desc']
            ], -1, 'index', 'ab1/_all'

        );
    }

    public function _actionShopRawStorageTotal() {
        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/raw/storage/list/total',
                'view::_shop/raw/storage/list/table_total',
            )
        );

        $this->_requestShopRaws();
        $this->_requestListDB('DB_Ab1_Shop_Raw_Storage');

        $rawType = $this->_sitePageData->operation->getShopRawStorageTypeID();
        if($rawType < 1){
            $rawType = null;
        }

        $ids = Request_Request::find(
            'DB_Ab1_Shop_Raw_Storage', $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB,
            Request_RequestParams::setParams(
                array(
                    'shop_raw_storage_type_id' => $rawType,
                    'sort_by' => ['name' => 'asc'],
                ),
                false
            ),
            0, true,
            array(
                'shop_raw_id' => array('name'),
                'shop_raw_storage_group_id' => array('name'),
                'shop_client_id' => array('name'),
            )
        );

        $this->_sitePageData->newShopShablonPath('ab1/_all');

        Helpers_View::getViews(
            "_shop/raw/storage/list/total-table", "_shop/raw/storage/one/total-table",
            $this->_sitePageData, $this->_driverDB, $ids
        );

        $groups = new MyArray();
        foreach ($ids->childs as $child){
            $group = $child->values['shop_raw_storage_group_id'];
            if(!key_exists($group, $groups->childs)){
                $groups->childs[$group] = $child;
            }
            $groups->childs[$group]->childs[] = $child;
        }

        foreach ($groups->childs as $child){
            $child->additionDatas['view::_shop/raw/storage/list/total-show'] = Helpers_View::getViews(
                "_shop/raw/storage/list/total-show", "_shop/raw/storage/one/total-show",
                $this->_sitePageData, $this->_driverDB, $child
            );
        }
        $data = Helpers_View::getViews(
            "_shop/raw/storage/group/list/total-show", "_shop/raw/storage/group/one/total-show",
            $this->_sitePageData, $this->_driverDB, $groups
        );
        $this->_sitePageData->addReplaceAndGlobalDatas('view::_shop/raw/storage/group/list/total-show', $data);

        $this->_sitePageData->previousShopShablonPath();

        $this->_putInMain('/main/_shop/raw/storage/total', 'ab1/_all');
    }

    public function _actionShopMaterialStorageTotal() {
        $this->_requestShopMaterials();
        $this->_requestListDB('DB_Ab1_Shop_Material_Storage');

        $this->_sitePageData->newShopShablonPath('ab1/_all');

        // получаем список
        View_View::find(
            'DB_Ab1_Shop_Material_Storage', $this->_sitePageData->shopID,
            "_shop/material/storage/list/total", "_shop/material/storage/one/total",
            $this->_sitePageData, $this->_driverDB,
            Request_RequestParams::setParams(
                array(
                    'sort_by' => ['name' => 'asc'],
                ),
                false
            ),
            array(
                'shop_material_id' => array('name'),
            )
        );

        // получаем список
        View_View::find(
            'DB_Ab1_Shop_Material_Storage', $this->_sitePageData->shopID,
            "_shop/material/storage/list/total-table", "_shop/material/storage/one/total-table",
            $this->_sitePageData, $this->_driverDB,
            Request_RequestParams::setParams(
                array(
                    'sort_by' => ['name' => 'asc'],
                ),
                false
            ),
            array(
                'shop_material_id' => array('name'),
            )
        );

        $this->_sitePageData->previousShopShablonPath();

        $this->_putInMain('/main/_shop/material/storage/total', 'ab1/_all');
    }

    protected function _actionShopTurnPlaceStatisticsCar()
    {
        $shopIDs = array();
        if(Request_RequestParams::getParamInt('shop_branch_id') != -1){
            $shopIDs[] = $this->_sitePageData->shopID;
        }

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/turn/place/list/statistics-car',
            )
        );

        $this->_requestShopTurnPlaces();
        $this->_requestShopProducts(
            null, 0, NULL, FALSE,
            [
                Model_Ab1_ProductView::PRODUCT_TYPE_CAR,
                Model_Ab1_ProductView::PRODUCT_TYPE_CAR_AND_PIECE,
                Model_Ab1_ProductView::PRODUCT_TYPE_PIECE
            ]
        );
        $this->_requestShopProductPricelistRubrics();
        if(Request_RequestParams::getParamInt('shop_storage_id') !== null) {
            $this->_requestShopStorages();
        }
        $this->_requestShopBranches($this->_sitePageData->shopID, TRUE);

        $shopProductIDs = Request_RequestParams::getParam('shop_product_id');

        // задаем время выборки с начала дня
        $dateFrom = date('Y-m-d').' 06:00:00';
        $listIDs = new MyArray();
        $params = Request_RequestParams::setParams(
            array(
                'is_exit' => 1,
                'exit_at_from' => $dateFrom,
                'sum_quantity' => TRUE,
                'is_charity' => FALSE,
                'shop_product_id' => $shopProductIDs,
                'group_by' => array(
                    'name',
                    'shop_product_id.unit', 'shop_product_id.volume',
                    'shop_turn_place_id.name',
                ),
            ),
            FALSE
        );
        $elements = array(
            'shop_product_id' => array('unit', 'volume'),
            'shop_turn_place_id' => array('name')
        );

        $resultArray = array(
            'quantity_day' => 0,
            'quantity_yesterday' => 0,
            'quantity_week' => 0,
            'quantity_month' => 0,
            'quantity_month_previous' => 0,
            'quantity_year' => 0,
        );

        $ids = Request_Request::findBranch('DB_Ab1_Shop_Car',
            $shopIDs, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
            $elements
        );
        foreach ($ids->childs as $child){
            $shopTurnPlaceID = $child->values['name'];
            if(!key_exists($shopTurnPlaceID, $listIDs->childs)){
                $child->additionDatas = $resultArray;
                $listIDs->childs[$shopTurnPlaceID] = $child;
            }
            $listIDs->childs[$shopTurnPlaceID]->additionDatas['quantity_day'] +=
                $child->values['quantity'] * $child->getElementValue('shop_product_id', 'volume', 1);
        }

        $params['id'] = $ids->getChildArrayID();
        if(empty($params['id'])){
            $params['id'] = 0;
        }

        // задаем время выборки вчера
        $paramsYesterday = $params;
        $paramsYesterday['exit_at_to'] = $dateFrom;
        $paramsYesterday['exit_at_from'] = Helpers_DateTime::minusDays($dateFrom, 1);

        $ids = Request_Request::findBranch('DB_Ab1_Shop_Car',
            $shopIDs, $this->_sitePageData, $this->_driverDB, $paramsYesterday, 0, TRUE,
            $elements
        );
        foreach ($ids->childs as $child){
            $shopTurnPlaceID = $child->values['name'];
            if(!key_exists($shopTurnPlaceID, $listIDs->childs)){
                $child->additionDatas = $resultArray;
                $listIDs->childs[$shopTurnPlaceID] = $child;
            }

            $listIDs->childs[$shopTurnPlaceID]->additionDatas['quantity_yesterday'] +=
                $child->values['quantity'] * $child->getElementValue('shop_product_id', 'volume', 1);
        }

        // задаем время выборки с начала недели
        $dateFrom = Helpers_DateTime::getWeekBeginStr(date('Y-m-d')).' 06:00:00';
        $params['exit_at_from'] = $dateFrom;

        $ids = Request_Request::findBranch('DB_Ab1_Shop_Car',
            $shopIDs, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
            $elements
        );
        foreach ($ids->childs as $child){
            $shopTurnPlaceID = $child->values['name'];
            if(!key_exists($shopTurnPlaceID, $listIDs->childs)){
                $child->additionDatas = $resultArray;
                $listIDs->childs[$shopTurnPlaceID] = $child;
            }

            $listIDs->childs[$shopTurnPlaceID]->additionDatas['quantity_week'] +=
                $child->values['quantity'] * $child->getElementValue('shop_product_id', 'volume', 1);
        }

        // задаем время выборки с начала месяца
        $dateFrom = Helpers_DateTime::getMonthBeginStr(date('m'), date('Y')).' 06:00:00';
        $params['exit_at_from'] = $dateFrom;

        $ids = Request_Request::findBranch('DB_Ab1_Shop_Car',
            $shopIDs, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
            $elements
        );
        foreach ($ids->childs as $child){
            $shopTurnPlaceID = $child->values['name'];
            if(!key_exists($shopTurnPlaceID, $listIDs->childs)){
                $child->additionDatas = $resultArray;
                $listIDs->childs[$shopTurnPlaceID] = $child;
            }

            $listIDs->childs[$shopTurnPlaceID]->additionDatas['quantity_month'] +=
                $child->values['quantity'] * $child->getElementValue('shop_product_id', 'volume', 1);
        }

        // задаем время выборки с предыдущего месяца
        $paramsPreviousMonth = $params;
        $tmp = Helpers_DateTime::getMonthBeginStr(date('m'), date('Y')).' 06:00:00';
        $paramsPreviousMonth['exit_at_to'] = $tmp;
        $paramsPreviousMonth['exit_at_from'] = Helpers_DateTime::minusMonth($tmp, 1, true);

        $ids = Request_Request::findBranch('DB_Ab1_Shop_Car',
            $shopIDs, $this->_sitePageData, $this->_driverDB, $paramsPreviousMonth, 0, TRUE,
            $elements
        );
        foreach ($ids->childs as $child){
            $shopTurnPlaceID = $child->values['name'];
            if(!key_exists($shopTurnPlaceID, $listIDs->childs)){
                $child->additionDatas = $resultArray;
                $listIDs->childs[$shopTurnPlaceID] = $child;
            }

            $listIDs->childs[$shopTurnPlaceID]->additionDatas['quantity_month_previous'] +=
                $child->values['quantity'] * $child->getElementValue('shop_product_id', 'volume', 1);
        }

        // задаем время выборки с начала года
        $dateFrom = Helpers_DateTime::getYearBeginStr(date('Y')).' 06:00:00';
        $params['exit_at_from'] = $dateFrom;

        $ids = Request_Request::findBranch('DB_Ab1_Shop_Car',
            $shopIDs, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
            $elements
        );
        foreach ($ids->childs as $child){
            $shopTurnPlaceID = $child->values['name'];
            if(!key_exists($shopTurnPlaceID, $listIDs->childs)){
                $child->additionDatas = $resultArray;
                $listIDs->childs[$shopTurnPlaceID] = $child;
            }

            $listIDs->childs[$shopTurnPlaceID]->additionDatas['quantity_year'] +=
                $child->values['quantity'] * $child->getElementValue('shop_product_id', 'volume', 1);
        }

        // итог
        $total = array(
            'quantity_day' => 0,
            'quantity_yesterday' => 0,
            'quantity_week' => 0,
            'quantity_month' => 0,
            'quantity_month_previous' => 0,
            'quantity_year' => 0,
        );
        $totalVolume = array(
            'quantity_day' => 0,
            'quantity_yesterday' => 0,
            'quantity_week' => 0,
            'quantity_month' => 0,
            'quantity_month_previous' => 0,
            'quantity_year' => 0,
        );
        $isVolume = false;
        foreach ($listIDs->childs as $key => $child){
            $total['quantity_day'] += $child->additionDatas['quantity_day'];
            $total['quantity_yesterday'] += $child->additionDatas['quantity_yesterday'];
            $total['quantity_week'] += $child->additionDatas['quantity_week'];
            $total['quantity_month'] += $child->additionDatas['quantity_month'];
            $total['quantity_month_previous'] += $child->additionDatas['quantity_month_previous'];
            $total['quantity_year'] += $child->additionDatas['quantity_year'];

            $volume = $child->getElementValue('shop_product_id', 'volume', 1);
            $isVolume = $isVolume || $volume != 1;

            $totalVolume['quantity_day'] += $child->additionDatas['quantity_day'] / $volume;
            $totalVolume['quantity_yesterday'] += $child->additionDatas['quantity_yesterday'] / $volume;
            $totalVolume['quantity_week'] += $child->additionDatas['quantity_week'] / $volume;
            $totalVolume['quantity_month'] += $child->additionDatas['quantity_month'] / $volume;
            $totalVolume['quantity_month_previous'] += $child->additionDatas['quantity_month_previous'] / $volume;
            $totalVolume['quantity_year'] += $child->additionDatas['quantity_year'] / $volume;
        }
        $listIDs->additionDatas = $total;
        $listIDs->additionDatas['is_volume'] = $isVolume;
        $listIDs->additionDatas['volume'] = $totalVolume;

        $listIDs->childsSortBy(array('quantity_year', Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_product_id.name'), FALSE);
        $this->_sitePageData->countRecord = count($listIDs->childs);

        $this->_sitePageData->newShopShablonPath('ab1/_all');
        $this->_sitePageData->replaceDatas['view::_shop/turn/place/list/statistics-car'] = Helpers_View::getViewObjects(
            $listIDs, new Model_Ab1_Shop_Product_Rubric(),
            '_shop/turn/place/list/statistics-car','_shop/turn/place/one/statistics-car',
            $this->_sitePageData, $this->_driverDB
        );
        $this->_sitePageData->previousShopShablonPath();

        $this->_putInMain('/main/_shop/turn/place/statistics-car', 'ab1/_all');
    }

    protected function _actionShopTransportWaybillFuelExpenseStatistics()
    {
        $shopIDs = array();
        if(Request_RequestParams::getParamInt('shop_branch_id') != -1){
            $shopIDs[] = $this->_sitePageData->shopID;
        }

        $this->_requestShopBranches(NULL, TRUE);
        $this->_requestListDB(DB_Ab1_Fuel::NAME);

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/transport/waybill/fuel/expense/list/statistics',
            )
        );

        // задаем время выборки с начала дня
        $dateFrom = date('Y-m-d').' 06:00:00';
        $listIDs = new MyArray();
        $params = Request_RequestParams::setParams(
            array(
                'shop_transport_waybill_id.date_from' => $dateFrom,
                'sum_quantity' => TRUE,
                'fuel_id' => Request_RequestParams::getParamInt('fuel_id'),
                'group_by' => array(
                    'shop_transport_id', 'shop_transport_id.name',
                    'shop_transport_waybill_id.shop_transport_driver_id', 'shop_transport_waybill_id.shop_transport_driver_id.name',
                ),
            )
        );

        $elements = array(
            'shop_transport_id' => array('name'),
            'shop_transport_waybill_id.shop_transport_driver_id' => array('name'),
            'shop_transport_waybill_id' => array('shop_transport_driver_id'),
        );

        $resultArray = array(
            'quantity_day' => 0,
            'quantity_yesterday' => 0,
            'quantity_week' => 0,
            'quantity_month' => 0,
            'quantity_month_previous' => 0,
            'quantity_year' => 0,
        );

        $ids = Request_Request::findBranch(
            DB_Ab1_Shop_Transport_Waybill_Fuel_Expense::NAME,
            $shopIDs, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
            $elements
        );
        foreach ($ids->childs as $child){
            $shopClientID = $child->values['shop_transport_id'] . '_' . $child->getElementValue('shop_transport_waybill_id', 'shop_transport_driver_id');
            if(!key_exists($shopClientID, $listIDs->childs)){
                $child->additionDatas = $resultArray;
                $listIDs->childs[$shopClientID] = $child;
            }

            $listIDs->childs[$shopClientID]->additionDatas['quantity_day'] += $child->values['quantity'];
        }

        // задаем время выборки вчера
        $paramsYesterday = $params;
        $paramsYesterday['shop_transport_waybill_id.date_to'] = $dateFrom;
        $paramsYesterday['shop_transport_waybill_id.date_from'] = Helpers_DateTime::minusDays($dateFrom, 1);

        $ids = Request_Request::findBranch(
            DB_Ab1_Shop_Transport_Waybill_Fuel_Expense::NAME,
            $shopIDs, $this->_sitePageData, $this->_driverDB, $paramsYesterday, 0, TRUE,
            $elements
        );
        foreach ($ids->childs as $child){
            $shopClientID = $child->values['shop_transport_id'] . '_' . $child->getElementValue('shop_transport_waybill_id', 'shop_transport_driver_id');
            if(!key_exists($shopClientID, $listIDs->childs)){
                $child->additionDatas = $resultArray;
                $listIDs->childs[$shopClientID] = $child;
            }

            $listIDs->childs[$shopClientID]->additionDatas['quantity_yesterday'] += $child->values['quantity'];
        }

        // задаем время выборки с начала недели
        $dateFrom = Helpers_DateTime::getWeekBeginStr(date('Y-m-d')).' 06:00:00';
        $params['shop_transport_waybill_id.date_from'] = $dateFrom;

        $ids = Request_Request::findBranch(
            DB_Ab1_Shop_Transport_Waybill_Fuel_Expense::NAME,
            $shopIDs, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
            $elements
        );
        foreach ($ids->childs as $child){
            $shopClientID = $child->values['shop_transport_id'] . '_' . $child->getElementValue('shop_transport_waybill_id', 'shop_transport_driver_id');
            if(!key_exists($shopClientID, $listIDs->childs)){
                $child->additionDatas = $resultArray;
                $listIDs->childs[$shopClientID] = $child;
            }

            $listIDs->childs[$shopClientID]->additionDatas['quantity_week'] += $child->values['quantity'];
        }

        // задаем время выборки с начала месяца
        $dateFrom = Helpers_DateTime::getMonthBeginStr(date('m'), date('Y')).' 06:00:00';
        $params['shop_transport_waybill_id.date_from'] = $dateFrom;

        $ids = Request_Request::findBranch(
            DB_Ab1_Shop_Transport_Waybill_Fuel_Expense::NAME,
            $shopIDs, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
            $elements
        );
        foreach ($ids->childs as $child){
            $shopClientID = $child->values['shop_transport_id'] . '_' . $child->getElementValue('shop_transport_waybill_id', 'shop_transport_driver_id');
            if(!key_exists($shopClientID, $listIDs->childs)){
                $child->additionDatas = $resultArray;
                $listIDs->childs[$shopClientID] = $child;
            }

            $listIDs->childs[$shopClientID]->additionDatas['quantity_month'] += $child->values['quantity'];
        }

        // задаем время выборки с предыдущего месяца
        $paramsPreviousMonth = $params;
        $tmp = Helpers_DateTime::getMonthBeginStr(date('m'), date('Y')).' 06:00:00';
        $paramsPreviousMonth['shop_transport_waybill_id.date_to'] = $tmp;
        $paramsPreviousMonth['shop_transport_waybill_id.date_from'] = Helpers_DateTime::minusMonth($tmp, 1, true);

        $ids = Request_Request::findBranch(
            DB_Ab1_Shop_Transport_Waybill_Fuel_Expense::NAME,
            $shopIDs, $this->_sitePageData, $this->_driverDB, $paramsPreviousMonth, 0, TRUE,
            $elements
        );
        foreach ($ids->childs as $child){
            $shopClientID = $child->values['shop_transport_id'] . '_' . $child->getElementValue('shop_transport_waybill_id', 'shop_transport_driver_id');
            if(!key_exists($shopClientID, $listIDs->childs)){
                $child->additionDatas = $resultArray;
                $listIDs->childs[$shopClientID] = $child;
            }

            $listIDs->childs[$shopClientID]->additionDatas['quantity_month_previous'] += $child->values['quantity'];
        }

        // задаем время выборки с начала года
        $dateFrom = Helpers_DateTime::getYearBeginStr(date('Y')).' 06:00:00';
        $params['shop_transport_waybill_id.date_from'] = $dateFrom;

        $ids = Request_Request::findBranch(
            DB_Ab1_Shop_Transport_Waybill_Fuel_Expense::NAME,
            $shopIDs, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
            $elements
        );
        foreach ($ids->childs as $child){
            $shopClientID = $child->values['shop_transport_id'] . '_' . $child->getElementValue('shop_transport_waybill_id', 'shop_transport_driver_id');
            if(!key_exists($shopClientID, $listIDs->childs)){
                $child->additionDatas = $resultArray;
                $listIDs->childs[$shopClientID] = $child;
            }

            $listIDs->childs[$shopClientID]->additionDatas['quantity_year'] += $child->values['quantity'];
        }

        // итог
        $listIDs->additionDatas = $listIDs->calcTotalsChild(
            array(
                'quantity_day',
                'quantity_yesterday',
                'quantity_week',
                'quantity_month',
                'quantity_month_previous',
                'quantity_year',
            ),
            true
        );

        $listIDs->childsSortBy(
            Request_RequestParams::getParamArray('sort_by', [],
                array(
                    'shop_transport_id.name' => 'asc',
                    'shop_transport_driver_id.name' => 'asc',
                    'quantity_day' => 'asc',
                    'quantity_yesterday' => 'asc',
                    'quantity_week' => 'asc',
                    'quantity_month' => 'asc',
                    'quantity_month_previous' => 'asc',
                    'quantity_year' => 'asc',
                    )
            ), true, true
        );

        $this->_sitePageData->countRecord = count($listIDs->childs);

        $this->_sitePageData->newShopShablonPath('ab1/_all');
        $this->_sitePageData->replaceDatas['view::_shop/transport/waybill/fuel/expense/list/statistics'] = Helpers_View::getViewObjects(
            $listIDs, new Model_Ab1_Shop_Product_Rubric(),
            '_shop/transport/waybill/fuel/expense/list/statistics','_shop/transport/waybill/fuel/expense/one/statistics',
            $this->_sitePageData, $this->_driverDB
        );
        $this->_sitePageData->previousShopShablonPath();

        $this->_putInMain('/main/_shop/transport/waybill/fuel/expense/statistics', 'ab1/_all');
    }

    protected function _actionShopTransportFuelExpenseStatistics()
    {
        $shopIDs = array();
        if(Request_RequestParams::getParamInt('shop_branch_id') != -1){
            $shopIDs[] = $this->_sitePageData->shopID;
        }

        $this->_requestShopBranches(NULL, TRUE);
        $this->_requestListDB(DB_Ab1_Fuel::NAME);

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/transport/fuel/expense/list/statistics',
            )
        );

        // задаем время выборки с начала дня
        $dateFrom = date('Y-m-d').' 06:00:00';
        $listIDs = new MyArray();
        $params = Request_RequestParams::setParams(
            array(
                'date_from' => $dateFrom,
                'sum_quantity' => TRUE,
                'fuel_id' => Request_RequestParams::getParamInt('fuel_id'),
                'group_by' => array(
                    'shop_move_client_id',
                    'shop_move_client_id.name',
                ),
            )
        );

        $elements = array(
            'shop_move_client_id' => array('name'),
        );

        $resultArray = array(
            'quantity_day' => 0,
            'quantity_yesterday' => 0,
            'quantity_week' => 0,
            'quantity_month' => 0,
            'quantity_month_previous' => 0,
            'quantity_year' => 0,
        );

        $ids = Request_Request::findBranch(
            DB_Ab1_Shop_Transport_Fuel_Expense::NAME,
            $shopIDs, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
            $elements
        );
        foreach ($ids->childs as $child){
            $shopClientID = $child->values['shop_move_client_id'];
            if(!key_exists($shopClientID, $listIDs->childs)){
                $child->additionDatas = $resultArray;
                $listIDs->childs[$shopClientID] = $child;
            }

            $listIDs->childs[$shopClientID]->additionDatas['quantity_day'] += $child->values['quantity'];
        }

        // задаем время выборки вчера
        $paramsYesterday = $params;
        $paramsYesterday['date_to'] = $dateFrom;
        $paramsYesterday['date_from'] = Helpers_DateTime::minusDays($dateFrom, 1);

        $ids = Request_Request::findBranch(
            DB_Ab1_Shop_Transport_Fuel_Expense::NAME,
            $shopIDs, $this->_sitePageData, $this->_driverDB, $paramsYesterday, 0, TRUE,
            $elements
        );
        foreach ($ids->childs as $child){
            $shopClientID = $child->values['shop_move_client_id'];
            if(!key_exists($shopClientID, $listIDs->childs)){
                $child->additionDatas = $resultArray;
                $listIDs->childs[$shopClientID] = $child;
            }

            $listIDs->childs[$shopClientID]->additionDatas['quantity_yesterday'] += $child->values['quantity'];
        }

        // задаем время выборки с начала недели
        $dateFrom = Helpers_DateTime::getWeekBeginStr(date('Y-m-d')).' 06:00:00';
        $params['date_from'] = $dateFrom;

        $ids = Request_Request::findBranch(
            DB_Ab1_Shop_Transport_Fuel_Expense::NAME,
            $shopIDs, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
            $elements
        );
        foreach ($ids->childs as $child){
            $shopClientID = $child->values['shop_move_client_id'];
            if(!key_exists($shopClientID, $listIDs->childs)){
                $child->additionDatas = $resultArray;
                $listIDs->childs[$shopClientID] = $child;
            }

            $listIDs->childs[$shopClientID]->additionDatas['quantity_week'] += $child->values['quantity'];
        }

        // задаем время выборки с начала месяца
        $dateFrom = Helpers_DateTime::getMonthBeginStr(date('m'), date('Y')).' 06:00:00';
        $params['date_from'] = $dateFrom;

        $ids = Request_Request::findBranch(
            DB_Ab1_Shop_Transport_Fuel_Expense::NAME,
            $shopIDs, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
            $elements
        );
        foreach ($ids->childs as $child){
            $shopClientID = $child->values['shop_move_client_id'];
            if(!key_exists($shopClientID, $listIDs->childs)){
                $child->additionDatas = $resultArray;
                $listIDs->childs[$shopClientID] = $child;
            }

            $listIDs->childs[$shopClientID]->additionDatas['quantity_month'] += $child->values['quantity'];
        }

        // задаем время выборки с предыдущего месяца
        $paramsPreviousMonth = $params;
        $tmp = Helpers_DateTime::getMonthBeginStr(date('m'), date('Y')).' 06:00:00';
        $paramsPreviousMonth['date_to'] = $tmp;
        $paramsPreviousMonth['date_from'] = Helpers_DateTime::minusMonth($tmp, 1, true);

        $ids = Request_Request::findBranch(
            DB_Ab1_Shop_Transport_Fuel_Expense::NAME,
            $shopIDs, $this->_sitePageData, $this->_driverDB, $paramsPreviousMonth, 0, TRUE,
            $elements
        );
        foreach ($ids->childs as $child){
            $shopClientID = $child->values['shop_move_client_id'];
            if(!key_exists($shopClientID, $listIDs->childs)){
                $child->additionDatas = $resultArray;
                $listIDs->childs[$shopClientID] = $child;
            }

            $listIDs->childs[$shopClientID]->additionDatas['quantity_month_previous'] += $child->values['quantity'];
        }

        // задаем время выборки с начала года
        $dateFrom = Helpers_DateTime::getYearBeginStr(date('Y')).' 06:00:00';
        $params['date_from'] = $dateFrom;

        $ids = Request_Request::findBranch(
            DB_Ab1_Shop_Transport_Fuel_Expense::NAME,
            $shopIDs, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
            $elements
        );
        foreach ($ids->childs as $child){
            $shopClientID = $child->values['shop_move_client_id'];
            if(!key_exists($shopClientID, $listIDs->childs)){
                $child->additionDatas = $resultArray;
                $listIDs->childs[$shopClientID] = $child;
            }

            $listIDs->childs[$shopClientID]->additionDatas['quantity_year'] += $child->values['quantity'];
        }

        // итог
        $listIDs->additionDatas = $listIDs->calcTotalsChild(
            array(
                'quantity_day',
                'quantity_yesterday',
                'quantity_week',
                'quantity_month',
                'quantity_month_previous',
                'quantity_year',
            ),
            true
        );

        $listIDs->childsSortBy(
            array(
                'amount_year',
            ),
            false
        );

        $this->_sitePageData->countRecord = count($listIDs->childs);

        $this->_sitePageData->newShopShablonPath('ab1/_all');
        $this->_sitePageData->replaceDatas['view::_shop/transport/fuel/expense/list/statistics'] = Helpers_View::getViewObjects(
            $listIDs, new Model_Ab1_Shop_Product_Rubric(),
            '_shop/transport/fuel/expense/list/statistics','_shop/transport/fuel/expense/one/statistics',
            $this->_sitePageData, $this->_driverDB
        );
        $this->_sitePageData->previousShopShablonPath();

        $this->_putInMain('/main/_shop/transport/fuel/expense/statistics');
    }

    protected function _actionFuelStatistics()
    {
        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::fuel/type/list/statistics',
            )
        );

        $isAllBranch = Request_RequestParams::getParamInt('shop_branch_id') == -1;
        $this->_requestShopBranches($this->_sitePageData->shopID, TRUE);
        if($isAllBranch){
            $shopIDs = [];
        }else{
            $shopIDs = [$this->_sitePageData->shopID];
        }

        $resultArray = array(
            'total_year' => 0,
            'issue' => 0,
            'paid' => 0,
            'expense' => 0,
            'expense_department' => 0,
            'total_current' => 0,
        );
        $listIDs = new MyArray();

        // Поступление с начала года
        $params = Request_RequestParams::setParams(
            array(
                'date_from' => Helpers_DateTime::getYearBeginStr(date('Y')),
                'shop_transport_waybill_id.date_from' => Helpers_DateTime::getYearBeginStr(date('Y')),
                'sum_quantity' => true,
                'group_by' => array(
                    'fuel_id', 'fuel_id.name',
                    'fuel_type_id', 'fuel_type_id.name',
                ),
            )
        );
        $elements = array(
            'fuel_id' => array('name'),
            'fuel_type_id' => array('name'),
        );

        $ids = Request_Request::findBranch(
            DB_Ab1_Shop_Transport_Fuel_Issue::NAME, $shopIDs, $this->_sitePageData, $this->_driverDB,
            $params, 0, TRUE, $elements
        );
        foreach ($ids->childs as $child){
            $fuelType = $child->getElementValue('fuel_id', 'fuel_type_id');
            if(!key_exists($fuelType, $listIDs->childs)){
                $child->additionDatas = $resultArray;
                $listIDs->childs[$fuelType] = $child;
            }

            $fuel = $child->values['fuel_id'];
            if(!key_exists($fuel, $listIDs->childs[$fuelType]->childs)){
                $child->additionDatas = $resultArray;
                $listIDs->childs[$fuelType]->childs[$fuel] = $child;
            }
            $listIDs->childs[$fuelType]->childs[$fuel]->additionDatas['issue'] += $child->values['quantity'];
        }

        // выдано сначала года по путевым листам
        $ids = Request_Request::findBranch(
            DB_Ab1_Shop_Transport_Waybill_Fuel_Expense::NAME, $shopIDs, $this->_sitePageData, $this->_driverDB,
            $params, 0, TRUE, $elements
        );
        foreach ($ids->childs as $child){
            $fuelType = $child->getElementValue('fuel_id', 'fuel_type_id');
            if(!key_exists($fuelType, $listIDs->childs)){
                $child->additionDatas = $resultArray;
                $listIDs->childs[$fuelType] = $child;
            }

            $fuel = $child->values['fuel_id'];
            if(!key_exists($fuel, $listIDs->childs[$fuelType]->childs)){
                $child->additionDatas = $resultArray;
                $listIDs->childs[$fuelType]->childs[$fuel] = $child;
            }
            $listIDs->childs[$fuelType]->childs[$fuel]->additionDatas['expense'] += $child->values['quantity'];
        }

        // выдано сначала года по подразделениям
        $ids = Request_Request::findBranch(
            DB_Ab1_Shop_Transport_Fuel_Expense::NAME, $shopIDs, $this->_sitePageData, $this->_driverDB,
            $params, 0, TRUE, $elements
        );
        foreach ($ids->childs as $child){
            $fuelType = $child->getElementValue('fuel_id', 'fuel_type_id');
            if(!key_exists($fuelType, $listIDs->childs)){
                $child->additionDatas = $resultArray;
                $listIDs->childs[$fuelType] = $child;
            }

            $fuel = $child->values['fuel_id'];
            if(!key_exists($fuel, $listIDs->childs[$fuelType]->childs)){
                $child->additionDatas = $resultArray;
                $listIDs->childs[$fuelType]->childs[$fuel] = $child;
            }
            $listIDs->childs[$fuelType]->childs[$fuel]->additionDatas['expense_department'] += $child->values['quantity'];
        }

        /***********************************/
        /****** Остатки на начало года *****/
        /***********************************/

        // Поступление
        $params = Request_RequestParams::setParams(
            array(
                'date_to' => Helpers_DateTime::getYearBeginStr(date('Y')),
                'shop_transport_waybill_id.date_to' => Helpers_DateTime::getYearBeginStr(date('Y')),
                'sum_quantity' => true,
                'group_by' => array(
                    'fuel_id', 'fuel_id.name',
                    'fuel_type_id', 'fuel_type_id.name',
                ),
            )
        );

        $ids = Request_Request::findBranch(
            DB_Ab1_Shop_Transport_Fuel_Issue::NAME, $shopIDs, $this->_sitePageData, $this->_driverDB,
            $params, 0, TRUE, $elements
        );
        foreach ($ids->childs as $child){
            $fuelType = $child->getElementValue('fuel_id', 'fuel_type_id');
            if(!key_exists($fuelType, $listIDs->childs)){
                $child->additionDatas = $resultArray;
                $listIDs->childs[$fuelType] = $child;
            }

            $fuel = $child->values['fuel_id'];
            if(!key_exists($fuel, $listIDs->childs[$fuelType]->childs)){
                $child->additionDatas = $resultArray;
                $listIDs->childs[$fuelType]->childs[$fuel] = $child;
            }
            $listIDs->childs[$fuelType]->childs[$fuel]->additionDatas['total_year'] += $child->values['quantity'];
        }

        // выдано по путевым листам
        $ids = Request_Request::findBranch(
            DB_Ab1_Shop_Transport_Waybill_Fuel_Expense::NAME, $shopIDs, $this->_sitePageData, $this->_driverDB,
            $params, 0, TRUE, $elements
        );
        foreach ($ids->childs as $child){
            $fuelType = $child->getElementValue('fuel_id', 'fuel_type_id');
            if(!key_exists($fuelType, $listIDs->childs)){
                $child->additionDatas = $resultArray;
                $listIDs->childs[$fuelType] = $child;
            }

            $fuel = $child->values['fuel_id'];
            if(!key_exists($fuel, $listIDs->childs[$fuelType]->childs)){
                $child->additionDatas = $resultArray;
                $listIDs->childs[$fuelType]->childs[$fuel] = $child;
            }
            $listIDs->childs[$fuelType]->childs[$fuel]->additionDatas['total_year'] -= $child->values['quantity'];
        }

        // выдано по подразделениям
        $ids = Request_Request::findBranch(
            DB_Ab1_Shop_Transport_Fuel_Expense::NAME, $shopIDs, $this->_sitePageData, $this->_driverDB,
            $params, 0, TRUE, $elements
        );
        foreach ($ids->childs as $child){
            $fuelType = $child->getElementValue('fuel_id', 'fuel_type_id');
            if(!key_exists($fuelType, $listIDs->childs)){
                $child->additionDatas = $resultArray;
                $listIDs->childs[$fuelType] = $child;
            }

            $fuel = $child->values['fuel_id'];
            if(!key_exists($fuel, $listIDs->childs[$fuelType]->childs)){
                $child->additionDatas = $resultArray;
                $listIDs->childs[$fuelType]->childs[$fuel] = $child;
            }
            $listIDs->childs[$fuelType]->childs[$fuel]->additionDatas['total_year'] -= $child->values['quantity'];
        }

        /**********************************************/
        /****** Остатки на текущий момент времени *****/
        /**********************************************/

        // Поступление
        $params = Request_RequestParams::setParams(
            array(
                'sum_quantity' => true,
                'group_by' => array(
                    'fuel_id', 'fuel_id.name',
                    'fuel_type_id', 'fuel_type_id.name',
                ),
            )
        );

        $ids = Request_Request::findBranch(
            DB_Ab1_Shop_Transport_Fuel_Issue::NAME, $shopIDs, $this->_sitePageData, $this->_driverDB,
            $params, 0, TRUE, $elements
        );
        foreach ($ids->childs as $child){
            $fuelType = $child->getElementValue('fuel_id', 'fuel_type_id');
            if(!key_exists($fuelType, $listIDs->childs)){
                $child->additionDatas = $resultArray;
                $listIDs->childs[$fuelType] = $child;
            }

            $fuel = $child->values['fuel_id'];
            if(!key_exists($fuel, $listIDs->childs[$fuelType]->childs)){
                $child->additionDatas = $resultArray;
                $listIDs->childs[$fuelType]->childs[$fuel] = $child;
            }
            $listIDs->childs[$fuelType]->childs[$fuel]->additionDatas['total_current'] += $child->values['quantity'];
        }

        // выдано по путевым листам
        $ids = Request_Request::findBranch(
            DB_Ab1_Shop_Transport_Waybill_Fuel_Expense::NAME, $shopIDs, $this->_sitePageData, $this->_driverDB,
            $params, 0, TRUE, $elements
        );
        foreach ($ids->childs as $child){
            $fuelType = $child->getElementValue('fuel_id', 'fuel_type_id');
            if(!key_exists($fuelType, $listIDs->childs)){
                $child->additionDatas = $resultArray;
                $listIDs->childs[$fuelType] = $child;
            }

            $fuel = $child->values['fuel_id'];
            if(!key_exists($fuel, $listIDs->childs[$fuelType]->childs)){
                $child->additionDatas = $resultArray;
                $listIDs->childs[$fuelType]->childs[$fuel] = $child;
            }
            $listIDs->childs[$fuelType]->childs[$fuel]->additionDatas['total_current'] -= $child->values['quantity'];
        }

        // выдано по подразделениям
        $ids = Request_Request::findBranch(
            DB_Ab1_Shop_Transport_Fuel_Expense::NAME, $shopIDs, $this->_sitePageData, $this->_driverDB,
            $params, 0, TRUE, $elements
        );
        foreach ($ids->childs as $child){
            $fuelType = $child->getElementValue('fuel_id', 'fuel_type_id');
            if(!key_exists($fuelType, $listIDs->childs)){
                $child->additionDatas = $resultArray;
                $listIDs->childs[$fuelType] = $child;
            }

            $fuel = $child->values['fuel_id'];
            if(!key_exists($fuel, $listIDs->childs[$fuelType]->childs)){
                $child->additionDatas = $resultArray;
                $listIDs->childs[$fuelType]->childs[$fuel] = $child;
            }
            $listIDs->childs[$fuelType]->childs[$fuel]->additionDatas['total_current'] -= $child->values['quantity'];
        }

        $this->_sitePageData->newShopShablonPath('ab1/_all');

        $listIDs->childsSortBy(['fuel_type_id.name' => 'asc'], true, true);
        foreach ($listIDs->childs as $child){
            $child->childsSortBy(['expense' => 'desc', 'fuel_id.name' => 'asc'], true, true);

            $child->additionDatas['view::fuel/list/statistics'] = Helpers_View::getView(
                'fuel/list/statistics', $this->_sitePageData, $this->_driverDB, $listIDs
            );
        }

        $this->_sitePageData->replaceDatas['view::fuel-type/list/statistics'] = Helpers_View::getViews(
            'fuel/type/list/statistics', 'fuel/type/one/statistics',
            $this->_sitePageData, $this->_driverDB, $listIDs
        );
        $this->_sitePageData->previousShopShablonPath();

        $this->_putInMain('/main/fuel/statistics');
    }

    public function _actionShopProductStorageNew($productViewID = null)
    {
        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/product/storage/one/new',
            )
        );

        // основная продукция
        if($productViewID == null){
            $productViewID = [
                Model_Ab1_ProductView::PRODUCT_TYPE_CAR,
                Model_Ab1_ProductView::PRODUCT_TYPE_CAR_AND_PIECE,
                Model_Ab1_ProductView::PRODUCT_TYPE_PIECE
            ];
        }
        $this->_requestShopProducts(
            null, 0, NULL, FALSE, $productViewID
        );

        $this->_requestShopTurnPlaces(Request_RequestParams::getParamInt('shop_turn_place_id'));
        $this->_requestShopOperations(Model_Ab1_Shop_Operation::RUBRIC_ASU);
        $this->_requestShopStorages();
        $this->_requestShopCarTares(Request_RequestParams::getParamInt('shop_car_tare_id'));

        $dataID = new MyArray();
        $dataID->id = 0;
        $dataID->isFindDB = TRUE;

        $this->_sitePageData->newShopShablonPath('ab1/_all');
        $this->_sitePageData->replaceDatas['view::_shop/product/storage/one/new'] = Helpers_View::getViewObject(
            $dataID, new Model_Ab1_Shop_Product_Storage(),
            '_shop/product/storage/one/new', $this->_sitePageData, $this->_driverDB
        );
        $this->_sitePageData->previousShopShablonPath();

        $this->_putInMain('/main/_shop/product/storage/new');
    }

    public function _actionShopProductStorageEdit($productViewID = null)
    {
        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/product/storage/one/edit',
            )
        );

        // id записи
        $id = Request_RequestParams::getParamInt('id');
        $model = new Model_Ab1_Shop_Product_Storage();
        if (! $this->dublicateObjectLanguage($model, $id, -1, FALSE)) {
            throw new HTTP_Exception_404('Product storage not is found!');
        }

        // основная продукция
        if($productViewID == null){
            $productViewID = [
                Model_Ab1_ProductView::PRODUCT_TYPE_CAR,
                Model_Ab1_ProductView::PRODUCT_TYPE_CAR_AND_PIECE,
                Model_Ab1_ProductView::PRODUCT_TYPE_PIECE
            ];
        }
        $this->_requestShopProducts(
            $model->getShopProductID(), 0, NULL, FALSE, $productViewID
         );

        $this->_requestShopStorages($model->getShopStorageID());
        $this->_requestShopTurnPlaces($model->getShopTurnPlaceID());
        $this->_requestShopOperations(Model_Ab1_Shop_Operation::RUBRIC_ASU, $model->getAsuOperationID());
        $this->_requestShopCarTares($model->getShopCarTareID());

        // получаем данные
        $this->_sitePageData->newShopShablonPath('ab1/_all');
        View_View::findOne('DB_Ab1_Shop_Product_Storage',
            $this->_sitePageData->shopID, "_shop/product/storage/one/edit",
            $this->_sitePageData, $this->_driverDB, array('id' => $id)
        );
        $this->_sitePageData->previousShopShablonPath();

        $this->_putInMain('/main/_shop/product/storage/edit');
    }

    public function _actionShopInvoiceProformaNew()
    {
        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/invoice/proforma/one/new',
                'view::_shop/invoice/proforma/item/list/index',
            )
        );

        $this->_requestShopProducts();
        $this->_requestShopProductRubrics();

        $this->_requestOrganizationTypes();
        $this->_requestKatos();
        $this->_requestBanks();

        $this->_sitePageData->newShopShablonPath('ab1/_all');
        // получаем данные
        $this->_sitePageData->replaceDatas['view::_shop/invoice/proforma/item/list/index'] =
            Helpers_View::getViewObjects(
                new MyArray(), new Model_Ab1_Shop_Invoice_Proforma_Item(),
                '_shop/invoice/proforma/item/list/index', '_shop/invoice/proforma/item/one/index',
                $this->_sitePageData, $this->_driverDB
            );

        $dataID = new MyArray();
        $dataID->id = 0;
        $dataID->setIsFind(TRUE);
        $this->_sitePageData->replaceDatas['view::_shop/invoice/proforma/one/new'] =  Helpers_View::getViewObject(
            $dataID, new Model_Ab1_Shop_Invoice_Proforma(),
            '_shop/invoice/proforma/one/new', $this->_sitePageData, $this->_driverDB
        );
        $this->_sitePageData->previousShopShablonPath();

        $this->_putInMain('/main/_shop/invoice/proforma/new');
    }

    public function _actionShopInvoiceProformaEdit()
    {
        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/invoice/proforma/one/edit',
                'view::_shop/invoice/proforma/item/list/index',
            )
        );

        // id записи
        $id = Request_RequestParams::getParamInt('id');
        $model = new Model_Ab1_Shop_Invoice_Proforma();
        if (! $this->dublicateObjectLanguage($model, $id, -1, FALSE)) {
            throw new HTTP_Exception_404('Invoice not is found!');
        }

        $this->_requestShopClientContract($model->getShopClientID(), $model->getShopClientContractID(), 'list', null,
            Model_Ab1_ClientContract_Status::CLIENT_CONTRACT_STATUS_WORK);
        $this->_requestShopProducts();
        $this->_requestShopProductRubrics();
        $this->_requestShopClientContract($model->getShopClientID(), $model->getShopClientContractID(), 'option', null,
            Model_Ab1_ClientContract_Status::CLIENT_CONTRACT_STATUS_WORK);

        $this->_requestOrganizationTypes();
        $this->_requestKatos();
        $this->_requestBanks();

        $this->_sitePageData->newShopShablonPath('ab1/_all');

        View_View::find('DB_Ab1_Shop_Invoice_Proforma_Item',
            $this->_sitePageData->shopID,
            '_shop/invoice/proforma/item/list/index', '_shop/invoice/proforma/item/one/index',
            $this->_sitePageData, $this->_driverDB,
            Request_RequestParams::setParams(
                array(
                    'shop_invoice_proforma_id' => $id,
                )
            )
        );

        // получаем данные
        View_View::findOne(
            'DB_Ab1_Shop_Invoice_Proforma', $this->_sitePageData->shopID, "_shop/invoice/proforma/one/edit",
            $this->_sitePageData, $this->_driverDB, array('id' => $id), array('shop_client_id')
        );
        $this->_sitePageData->previousShopShablonPath();

        $this->_putInMain('/main/_shop/invoice/proforma/edit');
    }

    protected function _actionShopRawDrainChuteNew()
    {
        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/raw/drain-chute/one/new',
            )
        );
        $dataID = new MyArray();
        $dataID->id = 0;
        $dataID->isFindDB = TRUE;

        $this->_sitePageData->newShopShablonPath('ab1/_all');
        $this->_sitePageData->replaceDatas['view::_shop/raw/drain-chute/one/new'] = Helpers_View::getViewObject(
            $dataID, new Model_Ab1_Shop_Material_Storage(),
            '_shop/raw/drain-chute/one/new', $this->_sitePageData, $this->_driverDB,
            $this->_sitePageData->shopID
        );
        $this->_sitePageData->previousShopShablonPath();

        $this->_putInMain('/main/_shop/raw/drain-chute/new');
    }

    protected function _actionShopRawDrainChuteEdit()
    {
        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/raw/drain-chute/one/edit',
            )
        );

        // id записи
        $id = Request_RequestParams::getParamInt('id');
        $model = new Model_Ab1_Shop_Raw_DrainChute();
        if (! $this->dublicateObjectLanguage($model, $id, $this->_sitePageData->shopID, FALSE)) {
            throw new HTTP_Exception_404('Raw drain chute not is found!');
        }

        // получаем данные
        $this->_sitePageData->newShopShablonPath('ab1/_all');
        View_View::findOne('DB_Ab1_Shop_Raw_DrainChute',
            $this->_sitePageData->shopID, "_shop/raw/drain-chute/one/edit",
            $this->_sitePageData, $this->_driverDB, array('id' => $id)
        );
        $this->_sitePageData->previousShopShablonPath();

        $this->_putInMain('/main/_shop/raw/drain-chute/edit');
    }

    protected function _actionShopRawStorageNew()
    {
        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/raw/storage/one/new',
            )
        );
        $dataID = new MyArray();
        $dataID->id = 0;
        $dataID->isFindDB = TRUE;

        $this->_requestListDB('DB_Ab1_Shop_Raw_Storage_Type');
        $this->_requestListDB('DB_Ab1_Shop_Raw_Storage_Group');

        $this->_sitePageData->newShopShablonPath('ab1/_all');
        $this->_sitePageData->replaceDatas['view::_shop/raw/storage/one/new'] = Helpers_View::getViewObject(
            $dataID, new Model_Ab1_Shop_Material_Storage(),
            '_shop/raw/storage/one/new', $this->_sitePageData, $this->_driverDB,
            $this->_sitePageData->shopID
        );
        $this->_sitePageData->previousShopShablonPath();

        $this->_putInMain('/main/_shop/raw/storage/new');
    }

    protected function _actionShopRawStorageEdit()
    {
        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/raw/storage/one/edit',
            )
        );

        // id записи
        $id = Request_RequestParams::getParamInt('id');
        $model = new Model_Ab1_Shop_Raw_Storage();
        if (! $this->dublicateObjectLanguage($model, $id, $this->_sitePageData->shopID, FALSE)) {
            throw new HTTP_Exception_404('Raw storage not is found!');
        }

        $this->_requestListDB('DB_Ab1_Shop_Raw_Storage_Type', $model->getShopRawStorageTypeID());
        $this->_requestListDB('DB_Ab1_Shop_Raw_Storage_Group', $model->getShopRawStorageGroupID());

        // получаем данные
        $this->_sitePageData->newShopShablonPath('ab1/_all');
        View_View::findOne('DB_Ab1_Shop_Raw_Storage',
            $this->_sitePageData->shopID, "_shop/raw/storage/one/edit",
            $this->_sitePageData, $this->_driverDB, array('id' => $id)
        );
        $this->_sitePageData->previousShopShablonPath();

        $this->_putInMain('/main/_shop/raw/storage/edit');
    }

    protected function _actionShopMaterialStorageNew()
    {
        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/material/storage/one/new',
            )
        );
        $dataID = new MyArray();
        $dataID->id = 0;
        $dataID->isFindDB = TRUE;

        $this->_sitePageData->newShopShablonPath('ab1/_all');
        $this->_sitePageData->replaceDatas['view::_shop/material/storage/one/new'] = Helpers_View::getViewObject(
            $dataID, new Model_Ab1_Shop_Material_Storage(),
            '_shop/material/storage/one/new', $this->_sitePageData, $this->_driverDB,
            $this->_sitePageData->shopID
        );
        $this->_sitePageData->previousShopShablonPath();

        $this->_putInMain('/main/_shop/material/storage/new');
    }

    protected function _actionShopMaterialStorageEdit()
    {
        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/material/storage/one/edit',
            )
        );

        // id записи
        $id = Request_RequestParams::getParamInt('id');
        $model = new Model_Ab1_Shop_Material_Storage();
        if (! $this->dublicateObjectLanguage($model, $id, $this->_sitePageData->shopID, FALSE)) {
            throw new HTTP_Exception_404('Material storage not is found!');
        }

        // получаем данные
        $this->_sitePageData->newShopShablonPath('ab1/_all');
        View_View::findOne('DB_Ab1_Shop_Material_Storage',
            $this->_sitePageData->shopID, "_shop/material/storage/one/edit",
            $this->_sitePageData, $this->_driverDB, array('id' => $id)
        );
        $this->_sitePageData->previousShopShablonPath();

        $this->_putInMain('/main/_shop/material/storage/edit');
    }

    public function _actionShopOperationNew()
    {
        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/operation/one/new',
            )
        );

        $data = $this->_requestListDB('DB_Ab1_Interface');
        $this->_sitePageData->addReplaceAndGlobalDatas('view::interface/list/options', $data);

        $this->_requestListDB('DB_Ab1_Shop_Worker_Passage');
        $this->_requestListDB('DB_Ab1_Shop_Department');
        $this->_requestListDB('DB_Ab1_Interface');
        $this->_requestListDB('DB_OperationType');
        $this->_requestListDB('DB_Ab1_Shop_Worker');
        $this->_requestListDB(DB_Ab1_Shop_Raw_Storage_Type::NAME);
        $this->_sitePageData->addReplaceAndGlobalDatas(
            'view::_shop/subdivision/list/product',
            $this->_requestListDB('DB_Ab1_Shop_Subdivision', null, $this->_sitePageData->shopID)
        );
        $this->_sitePageData->addReplaceAndGlobalDatas(
            'view::_shop/storage/list/product',
            $this->_requestListDB('DB_Ab1_Shop_Storage', null, $this->_sitePageData->shopID)
        );
        $this->_sitePageData->addReplaceAndGlobalDatas(
            'view::_shop/raw/rubric/list/list',
            $this->_requestListDB('DB_Ab1_Shop_Raw_Rubric', null, $this->_sitePageData->shopID)
        );

        $this->_requestShopTurnPlaces();

        $dataID = new MyArray();
        $dataID->id = 0;
        $dataID->isFindDB = TRUE;

        $this->_sitePageData->newShopShablonPath('ab1/_all');
        $this->_sitePageData->replaceDatas['view::_shop/operation/one/new'] = Helpers_View::getViewObject(
            $dataID, new Model_Ab1_Shop_Operation(),
            '_shop/operation/one/new', $this->_sitePageData, $this->_driverDB
        );
        $this->_sitePageData->previousShopShablonPath();

        $this->_putInMain('/main/_shop/operation/new');
    }

    public function _actionShopOperationEdit()
    {
        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/operation/one/edit',
            )
        );

        // id записи
        $shopOperationID = Request_RequestParams::getParamInt('id');
        $model = new Model_Ab1_Shop_Operation();
        if (! $this->dublicateObjectLanguage($model, $shopOperationID, -1, false)) {
            throw new HTTP_Exception_404('Operation not is found!');
        }

        $data = $this->_requestListDB(
            'DB_Ab1_Interface', Arr::path($model->getOptionsArray(), 'interface_ids', array())
        );
        $this->_sitePageData->addReplaceAndGlobalDatas('view::interface/list/options', $data);

        $this->_requestShopMaterials(
            Arr::path($model->getAccessArray(), 'recipe_shop_material_ids', null)
        );
        $this->_requestShopBranches(
            Arr::path($model->getAccessArray(), 'shop_branch_ids', null), true
        );
        $this->_requestListDB('DB_Ab1_Shop_Worker', $model->getShopWorkerID());

        $this->_requestListDB('DB_Ab1_Shop_Worker_Passage', $model->getShopWorkerPassageID());
        $this->_requestListDB('DB_Ab1_Interface', $model->getShopTableRubricID());
        $this->_requestListDB('DB_Ab1_Shop_Department', $model->getShopDepartmentID());
        $this->_requestListDB('DB_OperationType', $model->getOperationTypeID());
        $this->_requestListDB(DB_Ab1_Shop_Raw_Storage_Type::NAME, $model->getShopRawStorageTypeID());

        $this->_sitePageData->addReplaceAndGlobalDatas(
            'view::_shop/subdivision/list/product',
            $this->_requestListDB('DB_Ab1_Shop_Subdivision', $model->getProductShopSubdivisionIDsArray(), $this->_sitePageData->shopID)
        );
        $this->_requestListDB('DB_Ab1_Shop_Subdivision', $model->getShopSubdivisionID(), $this->_sitePageData->shopID);

        $this->_sitePageData->addReplaceAndGlobalDatas(
            'view::_shop/storage/list/product',
            $this->_requestListDB('DB_Ab1_Shop_Storage', $model->getProductShopStorageIDsArray(), $this->_sitePageData->shopID)
        );

        $this->_requestListDB('DB_Ab1_Shop_Raw_Rubric', $model->getShopRawRubricIDsArray());


        $this->_requestShopTurnPlaces($model->getShopTableSelectID());

        // получаем данные
        $this->_sitePageData->newShopShablonPath('ab1/_all');
        View_View::findOne(
            'DB_Shop_Operation', $this->_sitePageData->shopID, "_shop/operation/one/edit",
            $this->_sitePageData, $this->_driverDB, array('id' => $shopOperationID)
        );
        $this->_sitePageData->previousShopShablonPath();

        $this->_putInMain('/main/_shop/operation/edit');
    }

    protected function _actionShopDepartmentNew()
    {
        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/department/one/new',
            )
        );

        $this->_requestListDB('DB_Ab1_Interface');
        $this->_requestListDB('DB_Ab1_Shop_Department');
        $this->_requestClientContractTypes(null, true);

        $dataID = new MyArray();
        $dataID->id = 0;
        $dataID->isFindDB = TRUE;

        $this->_sitePageData->newShopShablonPath('ab1/_all');
        $this->_sitePageData->replaceDatas['view::_shop/department/one/new'] = Helpers_View::getViewObject(
            $dataID, new Model_Ab1_Shop_Department(),
            '_shop/department/one/new', $this->_sitePageData, $this->_driverDB,
            $this->_sitePageData->shopMainID
        );
        $this->_sitePageData->previousShopShablonPath();

        $this->_putInMain('/main/_shop/department/new');
    }

    protected function _actionShopDepartmentEdit()
    {
        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/department/one/edit',
            )
        );

        // id записи
        $id = Request_RequestParams::getParamInt('id');
        $model = new Model_Ab1_Shop_Department();
        if (! $this->dublicateObjectLanguage($model, $id, $this->_sitePageData->shopMainID, FALSE)) {
            throw new HTTP_Exception_404('Department not is found!');
        }

        $this->_requestListDB('DB_Ab1_Interface', $model->getInterfaceIDsArray());
        $this->_requestListDB('DB_Ab1_Shop_Department', $model->getShopDepartmentID());

        // получаем данные
        $this->_sitePageData->newShopShablonPath('ab1/_all');
        View_View::findOne('DB_Ab1_Shop_Department',
            $this->_sitePageData->shopMainID, "_shop/department/one/edit",
            $this->_sitePageData, $this->_driverDB, array('id' => $id)
        );
        $this->_sitePageData->previousShopShablonPath();

        $this->_putInMain('/main/_shop/department/edit');
    }

    public function _actionShopClientContractDirector() {
        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/client/contract/list/director',
            )
        );

        $this->_requestClientContractTypes();
        $this->_requestClientContractStatuses();
        $this->_requestShopWorkers();
        $this->_requestListDB('DB_Ab1_ClientContract_View');


        // получаем список
        $this->_sitePageData->newShopShablonPath('ab1/_all');
        View_View::find(
            'DB_Ab1_Shop_Client_Contract', $this->_sitePageData->shopMainID,
            "_shop/client/contract/list/director", "_shop/client/contract/one/director",
            $this->_sitePageData, $this->_driverDB,
            array(
                //'from_at_to' => date('Y-m-d'),
                //'to_at_from' => date('Y-m-d'),
                'limit_page' => 25,
                'sort_by' => array(
                    'created_at' => 'desc',
                    'shop_client.name' => 'asc',
                )
            ),
            array(
                'client_contract_type_id' => array('name'),
                'client_contract_view_id' => array('name'),
                'client_contract_status_id' => array('name'),
                'shop_client_id' => array('name'),
                'executor_shop_worker_id' => array('name'),
            )
        );
        $this->_sitePageData->previousShopShablonPath();

        $this->_putInMain('/main/_shop/client/contract/director');
    }

    public function _actionShopMaterialDensityNew()
    {
        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/material/density/one/new',
            )
        );
        $this->_requestShopMaterials(NULL, null, null, true);
        $this->_requestShopRaws(NULL, array('is_moisture_and_density' => true));
        $this->_requestShopBranches();
        $this->_requestShopDaughters();

        $dataID = new MyArray();
        $dataID->id = 0;
        $dataID->isFindDB = TRUE;

        $this->_sitePageData->newShopShablonPath('ab1/_all');
        $this->_sitePageData->replaceDatas['view::_shop/material/density/one/new'] = Helpers_View::getViewObject(
            $dataID, new Model_Ab1_Shop_Material_Density(),
            '_shop/material/density/one/new',
            $this->_sitePageData, $this->_driverDB, $this->_sitePageData->shopMainID
        );
        $this->_sitePageData->previousShopShablonPath();

        $this->_putInMain('/main/_shop/material/density/new');
    }

    public function _actionShopMaterialDensityEdit()
    {
        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/material/moisture/one/edit',
            )
        );

        // id записи
        $id = Request_RequestParams::getParamInt('id');
        $model = new Model_Ab1_Shop_Material_Density();
        if (! $this->dublicateObjectLanguage($model, $id, $this->_sitePageData->shopID, FALSE)) {
            throw new HTTP_Exception_404('Material density not is found!');
        }
        $this->_requestShopMaterials($model->getShopMaterialID(), null, null, true);
        $this->_requestShopRaws($model->getShopRawID(), array('is_moisture_and_density' => true));
        $this->_requestShopBranches($model->getShopBranchDaughterID());
        $this->_requestShopDaughters($model->getShopDaughterID());

        // получаем данные
        $this->_sitePageData->newShopShablonPath('ab1/_all');
        View_View::findOne('DB_Ab1_Shop_Material_Density', $this->_sitePageData->shopID,
            "_shop/material/density/one/edit",
            $this->_sitePageData, $this->_driverDB, array('id' => $id));
        $this->_sitePageData->previousShopShablonPath();

        $this->_putInMain('/main/_shop/material/density/edit');
    }

    public function _actionShopMaterialMoistureNew()
    {
        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/material/moisture/one/new',
            )
        );
        $this->_requestShopMaterials(null, null, null, true);
        $this->_requestShopRaws(NULL, array('is_moisture_and_density' => true));
        $this->_requestShopBranches();
        $this->_requestShopDaughters();

        $dataID = new MyArray();
        $dataID->id = 0;
        $dataID->isFindDB = TRUE;

        $this->_sitePageData->newShopShablonPath('ab1/_all');
        $this->_sitePageData->replaceDatas['view::_shop/material/moisture/one/new'] = Helpers_View::getViewObject(
            $dataID, new Model_Ab1_Shop_Material_Moisture(),
            '_shop/material/moisture/one/new',
            $this->_sitePageData, $this->_driverDB, $this->_sitePageData->shopMainID
        );
        $this->_sitePageData->previousShopShablonPath();

        $this->_putInMain('/main/_shop/material/moisture/new');
    }

    public function _actionShopMaterialMoistureEdit()
    {
        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/material/moisture/one/edit',
            )
        );

        // id записи
        $id = Request_RequestParams::getParamInt('id');
        $model = new Model_Ab1_Shop_Material_Moisture();
        if (! $this->dublicateObjectLanguage($model, $id, $this->_sitePageData->shopID, FALSE)) {
            throw new HTTP_Exception_404('Material moisture not is found!');
        }
        $this->_requestShopMaterials($model->getShopMaterialID(), null, null, true);
        $this->_requestShopRaws($model->getShopRawID(), array('is_moisture_and_density' => true));
        $this->_requestShopBranches($model->getShopBranchDaughterID());
        $this->_requestShopDaughters($model->getShopDaughterID());

        // получаем данные
        $this->_sitePageData->newShopShablonPath('ab1/_all');
        View_View::findOne('DB_Ab1_Shop_Material_Moisture', $this->_sitePageData->shopID,
            "_shop/material/moisture/one/edit",
            $this->_sitePageData, $this->_driverDB, array('id' => $id));
        $this->_sitePageData->previousShopShablonPath();

        $this->_putInMain('/main/_shop/material/moisture/edit');
    }

    public function _actionShopBallastDistanceNew()
    {
        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/ballast/distance/one/new',
            )
        );

        $this->_requestShopBallastDistanceTariffs();

        $dataID = new MyArray();
        $dataID->id = 0;
        $dataID->isFindDB = TRUE;
        $this->_sitePageData->newShopShablonPath('ab1/_all');
        $this->_sitePageData->replaceDatas['view::_shop/ballast/distance/one/new'] = Helpers_View::getViewObject($dataID, new Model_Ab1_Shop_Ballast_Distance(),
            '_shop/ballast/distance/one/new', $this->_sitePageData, $this->_driverDB);
        $this->_sitePageData->previousShopShablonPath();

        $this->_putInMain('/main/_shop/ballast/distance/new');
    }

    public function _actionShopBallastDistanceEdit()
    {
        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/ballast/distance/one/edit',
            )
        );

        // id записи
        $shopDriverID = Request_RequestParams::getParamInt('id');
        $model = new Model_Ab1_Shop_Ballast_Distance();
        if (!$this->dublicateObjectLanguage($model, $shopDriverID, -1, FALSE)) {
            throw new HTTP_Exception_404('Distance not is found!');
        }

        $this->_requestShopBallastDistanceTariffs($model->getShopBallastDistanceTariffID());

        // получаем данные
        $this->_sitePageData->newShopShablonPath('ab1/_all');
        View_View::findOne('DB_Ab1_Shop_Ballast_Distance', $this->_sitePageData->shopID, "_shop/ballast/distance/one/edit",
            $this->_sitePageData, $this->_driverDB, array('id' => $shopDriverID),
            array('shop_ballast_driver_id' => array('name')));
        $this->_sitePageData->previousShopShablonPath();

        $this->_putInMain('/main/_shop/ballast/distance/edit');
    }

    public function _actionShopRawNew()
    {
        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/raw/one/new',
            )
        );

        $this->_requestListDB(DB_Ab1_Shop_Raw_Rubric::NAME);

        $dataID = new MyArray();
        $dataID->id = 0;
        $dataID->isFindDB = TRUE;

        $this->_sitePageData->newShopShablonPath('ab1/_all');
        $this->_sitePageData->replaceDatas['view::_shop/raw/one/new'] = Helpers_View::getViewObject($dataID,
            new Model_Ab1_Shop_Raw(), '_shop/raw/one/new', $this->_sitePageData, $this->_driverDB,
            $this->_sitePageData->shopMainID);
        $this->_sitePageData->previousShopShablonPath();

        $this->_putInMain('/main/_shop/raw/new');
    }

    public function _actionShopRawEdit()
    {
        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/raw/one/edit',
            )
        );

        // id записи
        $shopRawID = Request_RequestParams::getParamInt('id');
        $model = new Model_Ab1_Shop_Raw();
        if (! $this->dublicateObjectLanguage($model, $shopRawID, $this->_sitePageData->shopMainID, FALSE)) {
            throw new HTTP_Exception_404('Raw not is found!');
        }

        $this->_requestListDB(DB_Ab1_Shop_Raw_Rubric::NAME, $model->getShopRawRubricID());

        // получаем данные
        $this->_sitePageData->newShopShablonPath('ab1/_all');
        View_View::findOne('DB_Ab1_Shop_Raw', $this->_sitePageData->shopMainID, "_shop/raw/one/edit",
            $this->_sitePageData, $this->_driverDB, array('id' => $shopRawID));
        $this->_sitePageData->previousShopShablonPath();

        $this->_putInMain('/main/_shop/raw/edit');
    }

    protected function _actionShopRegisterMaterialStatistics()
    {
        $this->_requestShopBranches(NULL, TRUE);

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/material/balance/list/statistics',
                'view::_shop/raw/balance/list/statistics',
            )
        );

        $params = Request_RequestParams::setParams(
            array(
                'sum_quantity' => TRUE,
                'quantity_from' => 0,
                'group_by' => array(
                    'shop_material_id', 'shop_material_id.name',
                    'shop_subdivision_id', 'shop_subdivision_id.name',
                ),
            )
        );

        $elements = array(
            'shop_material_id' => array('name'),
            'shop_subdivision_id' => array('name'),
        );

        $ids = Request_Request::find(
            'DB_Ab1_Shop_Material_Balance', $this->_sitePageData->shopID,
            $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
            $elements
        );
        $ids->additionDatas = $ids->calcTotalsChild(array('quantity'));
        $ids->childsSortBy(
            array(
                'shop_material_id.'.Model_Basic_DBObject::FIELD_ELEMENTS.'.name'
            )
        );

        $this->_sitePageData->newShopShablonPath('ab1/_all');
        $this->_sitePageData->replaceDatas['view::_shop/material/balance/list/statistics'] = Helpers_View::getViewObjects(
            $ids, new Model_Ab1_Shop_Register_Material(),
            '_shop/material/balance/list/statistics','_shop/material/balance/one/statistics',
            $this->_sitePageData, $this->_driverDB
        );
        $this->_sitePageData->previousShopShablonPath();

        $params = Request_RequestParams::setParams(
            array(
                'sum_quantity' => TRUE,
                'quantity_from' => 0,
                'group_by' => array(
                    'shop_raw_id', 'shop_raw_id.name',
                    'shop_subdivision_id', 'shop_subdivision_id.name',
                ),
            )
        );

        $elements = array(
            'shop_raw_id' => array('name'),
            'shop_subdivision_id' => array('name'),
        );

        $ids = Request_Request::find('DB_Ab1_Shop_Raw_Balance',
            $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
            $elements
        );
        $ids->additionDatas = $ids->calcTotalsChild(array('quantity'));
        $ids->childsSortBy(
            array(
                'shop_raw_id.'.Model_Basic_DBObject::FIELD_ELEMENTS.'.name'
            )
        );

        $this->_sitePageData->newShopShablonPath('ab1/_all');
        $this->_sitePageData->replaceDatas['view::_shop/raw/balance/list/statistics'] = Helpers_View::getViewObjects(
            $ids, new Model_Ab1_Shop_Register_Material(),
            '_shop/raw/balance/list/statistics','_shop/raw/balance/one/statistics',
            $this->_sitePageData, $this->_driverDB
        );
        $this->_sitePageData->previousShopShablonPath();

        $this->_putInMain('/main/_shop/register/material/statistics');
    }

    public function _actionShopMoveClientStatistics()
    {
        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/move/client/list/statistics',
            )
        );
        $this->_requestShopBranches(NULL, TRUE);
        $this->_requestShopMoveClients();

        $shopProductIDs = NULL;

        $resultArray = array(
            'quantity_day' => 0,
            'quantity_yesterday' => 0,
            'quantity_week' => 0,
            'quantity_month' => 0,
            'quantity_month_previous' => 0,
            'quantity_year' => 0,
        );

        // задаем время выборки с начала дня
        $dateFrom = date('Y-m-d').' 06:00:00';
        $listIDs = new MyArray();
        $params = Request_RequestParams::setParams(
            array(
                'created_at_from' => $dateFrom,
                'sum_quantity' => TRUE,
                'shop_product_id' => $shopProductIDs,
                'shop_client_id' => Request_RequestParams::getParamInt('shop_client_id'),
                'group_by' => array(
                    'shop_product_id', 'shop_product_id.name', 'shop_product_id.volume',
                ),
            )
        );

        $elements = array(
            'shop_product_id' => array('name', 'volume'),
        );

        $ids = Request_Request::find('DB_Ab1_Shop_Move_Car',
            $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
            $elements
        );
        foreach ($ids->childs as $child){
            $shopClientID = $child->values['shop_product_id'];
            if(!key_exists($shopClientID, $listIDs->childs)){
                $child->additionDatas = $resultArray;
                $listIDs->childs[$shopClientID] = $child;
            }

            $listIDs->childs[$shopClientID]->additionDatas['quantity_day'] += $child->values['quantity'] * $child->getElementValue('shop_product_id', 'volume', 1);
        }

        // задаем время выборки вчера
        $paramsYesterday = $params;
        $paramsYesterday['created_at_to'] = $dateFrom;
        $paramsYesterday['created_at_from'] = Helpers_DateTime::minusDays($dateFrom, 1);

        $ids = Request_Request::find('DB_Ab1_Shop_Move_Car',
            $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB, $paramsYesterday, 0, TRUE,
            $elements
        );
        foreach ($ids->childs as $child){
            $shopClientID = $child->values['shop_product_id'];
            if(!key_exists($shopClientID, $listIDs->childs)){
                $child->additionDatas = $resultArray;
                $listIDs->childs[$shopClientID] = $child;
            }

            $listIDs->childs[$shopClientID]->additionDatas['quantity_yesterday'] += $child->values['quantity'] * $child->getElementValue('shop_product_id', 'volume', 1);
        }

        // задаем время выборки с начала недели
        $dateFrom = Helpers_DateTime::getWeekBeginStr(date('Y-m-d')).' 06:00:00';
        $params['created_at_from'] = $dateFrom;

        $ids = Request_Request::find('DB_Ab1_Shop_Move_Car',
            $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
            $elements
        );
        foreach ($ids->childs as $child){
            $shopClientID = $child->values['shop_product_id'];
            if(!key_exists($shopClientID, $listIDs->childs)){
                $child->additionDatas = $resultArray;
                $listIDs->childs[$shopClientID] = $child;
            }

            $listIDs->childs[$shopClientID]->additionDatas['quantity_week'] += $child->values['quantity'] * $child->getElementValue('shop_product_id', 'volume', 1);
        }

        // задаем время выборки с начала месяца
        $dateFrom = Helpers_DateTime::getMonthBeginStr(date('m'), date('Y')).' 06:00:00';
        $params['created_at_from'] = $dateFrom;

        $ids = Request_Request::find('DB_Ab1_Shop_Move_Car',
            $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
            $elements
        );
        foreach ($ids->childs as $child){
            $shopClientID = $child->values['shop_product_id'];
            if(!key_exists($shopClientID, $listIDs->childs)){
                $child->additionDatas = $resultArray;
                $listIDs->childs[$shopClientID] = $child;
            }

            $listIDs->childs[$shopClientID]->additionDatas['quantity_month'] += $child->values['quantity'] * $child->getElementValue('shop_product_id', 'volume', 1);
        }

        // задаем время выборки с предыдущего месяца
        $paramsPreviousMonth = $params;
        $tmp = Helpers_DateTime::getMonthBeginStr(date('m'), date('Y')).' 06:00:00';
        $paramsPreviousMonth['exit_at_to'] = $tmp;
        $paramsPreviousMonth['exit_at_from'] = Helpers_DateTime::minusMonth($tmp, 1, true);

        $ids = Request_Request::find('DB_Ab1_Shop_Move_Car',
            $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB, $paramsPreviousMonth, 0, TRUE,
            $elements
        );
        foreach ($ids->childs as $child){
            $shopClientID = $child->values['shop_product_id'];
            if(!key_exists($shopClientID, $listIDs->childs)){
                $child->additionDatas = $resultArray;
                $listIDs->childs[$shopClientID] = $child;
            }

            $listIDs->childs[$shopClientID]->additionDatas['quantity_month_previous'] += $child->values['quantity'] * $child->getElementValue('shop_product_id', 'volume', 1);
        }

        // задаем время выборки с начала года
        $dateFrom = Helpers_DateTime::getYearBeginStr(date('Y')).' 06:00:00';
        $params['created_at_from'] = $dateFrom;

        $ids = Request_Request::find('DB_Ab1_Shop_Move_Car',
            $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
            $elements
        );
        foreach ($ids->childs as $child){
            $shopClientID = $child->values['shop_product_id'];
            if(!key_exists($shopClientID, $listIDs->childs)){
                $child->additionDatas = $resultArray;
                $listIDs->childs[$shopClientID] = $child;
            }

            $listIDs->childs[$shopClientID]->additionDatas['quantity_year'] += $child->values['quantity'] * $child->getElementValue('shop_product_id', 'volume', 1);
        }

        $listIDs->childsSortBy(
            array(
                Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_product_id.name',
            )
        );

        $this->_sitePageData->countRecord = count($listIDs->childs);

        $this->_sitePageData->newShopShablonPath('ab1/_all');
        $this->_sitePageData->replaceDatas['view::_shop/move/client/list/statistics'] = Helpers_View::getViewObjects(
            $listIDs, new Model_Ab1_Shop_Product_Rubric(),
            '_shop/move/client/list/statistics','_shop/move/client/one/statistics',
            $this->_sitePageData, $this->_driverDB
        );
        $this->_sitePageData->previousShopShablonPath();

        $this->_putInMain('/main/_shop/move/client/statistics', 'ab1/_all');
    }

    public function _actionShopClientContractStorageNew()
    {
        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/client/contract/storage/one/new',
            )
        );

        $dataID = new MyArray();
        $dataID->id = 0;
        $dataID->isFindDB = TRUE;

        $this->_sitePageData->newShopShablonPath('ab1/_all');
        $this->_sitePageData->replaceDatas['view::_shop/client/contract/storage/one/new'] = Helpers_View::getViewObject($dataID, new Model_Ab1_Shop_Heap(),
            '_shop/client/contract/storage/one/new', $this->_sitePageData, $this->_driverDB, $this->_sitePageData->shopID);
        $this->_sitePageData->previousShopShablonPath();

        $this->_putInMain('/main/_shop/client/contract/storage/new');
    }

    public function _actionShopClientContractStorageEdit()
    {

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/client/contract/storage/one/edit',
            )
        );

        // id записи
        $shopHeapID = Request_RequestParams::getParamInt('id');
        $model = new Model_Ab1_Shop_Client_Contract_Storage();
        if (! $this->dublicateObjectLanguage($model, $shopHeapID, $this->_sitePageData->shopID)) {
            throw new HTTP_Exception_404('Client contract storage not is found!');
        }

        // получаем данные
        $this->_sitePageData->newShopShablonPath('ab1/_all');
        View_View::findOne('DB_Ab1_Shop_Heap', $this->_sitePageData->shopID, "_shop/client/contract/storage/one/edit",
            $this->_sitePageData, $this->_driverDB, array('id' => $shopHeapID));
        $this->_sitePageData->previousShopShablonPath();

        $this->_putInMain('/main/_shop/client/contract/storage/edit');
    }

    public function _actionShopProductPriceList()
    {
        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/product/list/pricelist',
            )
        );
        $shopProductRubricID = Request_RequestParams::getParamInt('shop_product_rubric_id');
        if($shopProductRubricID < 1){
            $shopProductRubricID = 84246;
        }

        $this->_requestShopBranches(null, true);
        $this->_requestShopProductRubrics($shopProductRubricID);

        $this->_sitePageData->newShopShablonPath('ab1/_all');

        switch ($shopProductRubricID){
            case 84246:
                $data = Api_Ab1_Shop_Product::getPriceListAsphalt(
                    $shopProductRubricID, date('Y-m-d'), $this->_sitePageData, $this->_driverDB
                );

                $ids = new MyArray();
                $ids->addChildrenArray($data['products']);
                $ids->additionDatas['deliveries'] = $data['deliveries'];
                $ids->additionDatas['price_list'] = $data['price_list'];

                $result = Helpers_View::getViewObjects(
                    $ids, new Model_Ab1_Shop_Product(),
                    '_shop/product/list/pricelist/asfalt', '_shop/product/one/pricelist/asfalt',
                    $this->_sitePageData, $this->_driverDB
                );
                $this->_sitePageData->replaceDatas['view::_shop/product/list/pricelist'] = $result;
                break;
            case 84605:
                $data = Api_Ab1_Shop_Product::getPriceListStoneMaterial(
                    $shopProductRubricID, date('Y-m-d'), $this->_sitePageData, $this->_driverDB
                );

                $ids = new MyArray();
                $ids->addChildrenArray($data['products']);
                $ids->additionDatas['price_list'] = $data['price_list'];

                $result = Helpers_View::getViewObjects(
                    $ids, new Model_Ab1_Shop_Product(),
                    '_shop/product/list/pricelist/stone-material', '_shop/product/one/pricelist/stone-material',
                    $this->_sitePageData, $this->_driverDB
                );
                $this->_sitePageData->replaceDatas['view::_shop/product/list/pricelist'] = $result;
                break;
            case 84250:
                $data = Api_Ab1_Shop_Product::getPriceListBitumen(
                    $shopProductRubricID, date('Y-m-d'), $this->_sitePageData, $this->_driverDB
                );

                $ids = new MyArray();
                $ids->addChildrenArray($data['products']);
                $ids->additionDatas['deliveries'] = $data['deliveries'];
                $ids->additionDatas['price_list'] = $data['price_list'];

                $result = Helpers_View::getViewObjects(
                    $ids, new Model_Ab1_Shop_Product(),
                    '_shop/product/list/pricelist/bitumen', '_shop/product/one/pricelist/bitumen',
                    $this->_sitePageData, $this->_driverDB
                );
                $this->_sitePageData->replaceDatas['view::_shop/product/list/pricelist'] = $result;
                break;
            case 84598:
                $data = Api_Ab1_Shop_Product::getPriceListZhbiOther(
                    $shopProductRubricID, date('Y-m-d'), $this->_sitePageData, $this->_driverDB
                );

                $ids = new MyArray();
                $ids->addChildrenArray($data['products']);
                $ids->additionDatas['price_list'] = $data['price_list'];

                $result = Helpers_View::getViewObjects(
                    $ids, new Model_Ab1_Shop_Product(),
                    '_shop/product/list/pricelist/zhbi', '_shop/product/one/pricelist/zhbi',
                    $this->_sitePageData, $this->_driverDB
                );
                $this->_sitePageData->replaceDatas['view::_shop/product/list/pricelist'] = $result;
                break;
            case 84606:
                $data = Api_Ab1_Shop_Product::getPriceListConcrete(
                    $shopProductRubricID, date('Y-m-d'), $this->_sitePageData, $this->_driverDB
                );

                $ids = new MyArray();
                $ids->addChildrenArray($data['products']);
                $ids->additionDatas['price_list'] = $data['price_list'];
                $ids->additionDatas['deliveries'] = $data['deliveries'];

                $result = Helpers_View::getViewObjects(
                    $ids, new Model_Ab1_Shop_Product(),
                    '_shop/product/list/pricelist/concrete', '_shop/product/one/pricelist/concrete',
                    $this->_sitePageData, $this->_driverDB
                );
                $this->_sitePageData->replaceDatas['view::_shop/product/list/pricelist'] = $result;
                break;
        }

        $this->_sitePageData->previousShopShablonPath();

        $this->_putInMain('/main/_shop/product/pricelist');
    }

    public function _actionShopFormulaGroupNew()
    {
        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/formula/group/one/new',
            )
        );

        $this->_requestShopProductRubrics();

        $dataID = new MyArray();
        $dataID->id = 0;
        $dataID->isFindDB = TRUE;
        $this->_sitePageData->newShopShablonPath('ab1/_all');
        $this->_sitePageData->replaceDatas['view::_shop/formula/group/one/new'] = Helpers_View::getViewObject(
            $dataID, new Model_Ab1_Shop_Formula_Group(), '_shop/formula/group/one/new',
            $this->_sitePageData, $this->_driverDB, $this->_sitePageData->shopMainID
        );
        $this->_sitePageData->previousShopShablonPath();

        $this->_putInMain('/main/_shop/formula/group/new');
    }

    public function _actionShopFormulaGroupEdit()
    {
        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/formula/group/one/edit',
            )
        );

        // id записи
        $id = Request_RequestParams::getParamInt('id');
        $model = new Model_Ab1_Shop_Formula_Group();
        if (!$this->dublicateObjectLanguage($model, $id, $this->_sitePageData->shopMainID, false)) {
            throw new HTTP_Exception_404('Formula group not is found!');
        }

        $this->_requestShopProductRubrics($model->getShopProductRubricID());

        // получаем данные
        $this->_sitePageData->newShopShablonPath('ab1/_all');
        View_View::findOne('DB_Ab1_Shop_Formula_Group',
            $this->_sitePageData->shopMainID, "_shop/formula/group/one/edit", $this->_sitePageData, $this->_driverDB
        );
        $this->_sitePageData->previousShopShablonPath();

        $this->_putInMain('/main/_shop/formula/group/edit');
    }

    public function _actionShopProductRubricNew()
    {
        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/product/rubric/one/new',
            )
        );

        $this->_requestShopProductRubrics();

        $dataID = new MyArray();
        $dataID->id = 0;
        $dataID->isFindDB = TRUE;
        $this->_sitePageData->newShopShablonPath('ab1/_all');
        $this->_sitePageData->replaceDatas['view::_shop/product/rubric/one/new'] = Helpers_View::getViewObject(
            $dataID, new Model_Ab1_Shop_Product_Rubric(), '_shop/product/rubric/one/new',
            $this->_sitePageData, $this->_driverDB, $this->_sitePageData->shopMainID
        );
        $this->_sitePageData->previousShopShablonPath();

        $this->_putInMain('/main/_shop/product/rubric/new');
    }

    public function _actionShopProductRubricEdit()
    {
        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/product/rubric/one/edit',
            )
        );

        // id записи
        $id = Request_RequestParams::getParamInt('id');
        $model = new Model_Ab1_Shop_Product_Rubric();
        if (!$this->dublicateObjectLanguage($model, $id, $this->_sitePageData->shopMainID, false)) {
            throw new HTTP_Exception_404('Rubric product not is found!');
        }

        $this->_requestShopProductRubrics($model->getRootID());

        // получаем данные
        $this->_sitePageData->newShopShablonPath('ab1/_all');
        View_View::findOne('DB_Ab1_Shop_Product_Rubric',
            $this->_sitePageData->shopMainID, "_shop/product/rubric/one/edit", $this->_sitePageData, $this->_driverDB
        );
        $this->_sitePageData->previousShopShablonPath();

        $this->_putInMain('/main/_shop/product/rubric/edit');
    }

    public function _actionShopHeapNew()
    {
        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/heap/one/new',
            )
        );

        $this->_requestShopSubdivisions(null, 0, '');

        $dataID = new MyArray();
        $dataID->id = 0;
        $dataID->isFindDB = TRUE;

        $this->_sitePageData->newShopShablonPath('ab1/_all');
        $this->_sitePageData->replaceDatas['view::_shop/heap/one/new'] = Helpers_View::getViewObject($dataID, new Model_Ab1_Shop_Heap(),
            '_shop/heap/one/new', $this->_sitePageData, $this->_driverDB, $this->_sitePageData->shopID);
        $this->_sitePageData->previousShopShablonPath();

        $this->_putInMain('/main/_shop/heap/new');
    }

    public function _actionShopHeapEdit()
    {

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/heap/one/edit',
            )
        );

        // id записи
        $shopHeapID = Request_RequestParams::getParamInt('id');
        $model = new Model_Ab1_Shop_Heap();
        if (! $this->dublicateObjectLanguage($model, $shopHeapID, $this->_sitePageData->shopID)) {
            throw new HTTP_Exception_404('Heap not is found!');
        }

        $this->_requestShopSubdivisions($model->getShopSubdivisionID(), 0, '');

        // получаем данные
        $this->_sitePageData->newShopShablonPath('ab1/_all');
        View_View::findOne('DB_Ab1_Shop_Heap', $this->_sitePageData->shopID, "_shop/heap/one/edit",
            $this->_sitePageData, $this->_driverDB, array('id' => $shopHeapID));
        $this->_sitePageData->previousShopShablonPath();

        $this->_putInMain('/main/_shop/heap/edit');
    }

    public function _actionShopRawRecipe()
    {
        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/raw/one/recipe',
                'view::_shop/formula/raw/list/recipe',
            )
        );

        // id записи
        $id = Request_RequestParams::getParamInt('id');
        $model = new Model_Ab1_Shop_Raw();
        if (! $this->dublicateObjectLanguage($model, $id, $this->_sitePageData->shopMainID, FALSE)) {
            throw new HTTP_Exception_404('Raw not is found!');
        }

        // получаем данные
        $this->_sitePageData->newShopShablonPath('ab1/_all');

        View_View::findOne(
            'DB_Ab1_Shop_Raw', $this->_sitePageData->shopMainID,
            "_shop/raw/one/recipe",
            $this->_sitePageData, $this->_driverDB,
            Request_RequestParams::setParams(
                array(
                    'id' => $id
                )
            )
        );

        View_View::find(
            'DB_Ab1_Shop_Formula_Raw', $this->_sitePageData->shopID,
            "_shop/formula/raw/list/recipe", '_shop/formula/raw/one/recipe',
            $this->_sitePageData, $this->_driverDB,
            Request_RequestParams::setParams(
                array(
                    'shop_raw_id' => $id,
                    'sort_by' => array(
                        'from_at' => 'desc',
                        'to_at' => 'desc',
                    ),
                )
            ),
            array(
                'shop_ballast_crusher_id' => array('name'),
            )
        );

        $this->_sitePageData->previousShopShablonPath();

        $this->_putInMain('/main/_shop/raw/raw-recipe');
    }

    public function _actionShopMaterialRecipe()
    {
        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/material/one/recipe',
                'view::_shop/formula/material/list/recipe',
            )
        );

        // id записи
        $shopMaterialID = Request_RequestParams::getParamInt('id');
        $model = new Model_Ab1_Shop_Material();
        if (! $this->dublicateObjectLanguage($model, $shopMaterialID, $this->_sitePageData->shopMainID, FALSE)) {
            throw new HTTP_Exception_404('Material not is found!');
        }

        // получаем данные
        $this->_sitePageData->newShopShablonPath('ab1/_all');

        View_View::findOne('DB_Ab1_Shop_Material',
            $this->_sitePageData->shopMainID, "_shop/material/one/recipe",
            $this->_sitePageData, $this->_driverDB,
            Request_RequestParams::setParams(
                array(
                    'id' => $shopMaterialID
                )
            )
        );

        View_View::find(
            'DB_Ab1_Shop_Formula_Material', $this->_sitePageData->shopID,
            "_shop/formula/material/list/recipe", '_shop/formula/material/one/recipe',
            $this->_sitePageData, $this->_driverDB,
            Request_RequestParams::setParams(
                array(
                    'shop_material_id' => $shopMaterialID,
                    'sort_by' => array(
                        'from_at' => 'desc',
                        'to_at' => 'desc',
                    ),
                )
            ),
            array(
                'formula_type_id' => array('name'),
            )
        );

        $this->_sitePageData->previousShopShablonPath();

        $this->_putInMain('/main/_shop/material/material-recipe');
    }

    public function _actionShopProductRecipe()
    {
        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/product/one/recipe',
                'view::_shop/formula/product/list/recipe',
            )
        );

        // id записи
        $shopProductID = Request_RequestParams::getParamInt('id');
        $model = new Model_Ab1_Shop_Product();
        if (! $this->dublicateObjectLanguage($model, $shopProductID, $this->_sitePageData->shopID, FALSE)) {
            throw new HTTP_Exception_404('Product not is found!');
        }

        $this->_requestShopProductRubrics();

        // получаем данные
        $this->_sitePageData->newShopShablonPath('ab1/_all');

        View_View::findOne('DB_Ab1_Shop_Product',
            $this->_sitePageData->shopID, "_shop/product/one/recipe",
            $this->_sitePageData, $this->_driverDB,
            Request_RequestParams::setParams(
                array(
                    'id' => $shopProductID
                )
            )
        );

        View_View::find('DB_Ab1_Shop_Formula_Product',
            $this->_sitePageData->shopID,
            "_shop/formula/product/list/recipe", '_shop/formula/product/one/recipe',
            $this->_sitePageData, $this->_driverDB,
            Request_RequestParams::setParams(
                array(
                    'shop_product_id' => $shopProductID,
                    'sort_by' => array(
                        'from_at' => 'desc',
                        'to_at' => 'desc',
                    ),
                )
            ),
            array(
                'formula_type_id' => array('name'),
            )
        );

        $this->_sitePageData->previousShopShablonPath();

        $this->_putInMain('/main/_shop/product/product-recipe');
    }

    public function _actionShopClientGuaranteeEdit()
    {
        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/client/guarantee/one/edit',
                'view::_shop/client/guarantee/item/list/item',
            )
        );

        // id записи
        $id = Request_RequestParams::getParamInt('id');
        $model = new Model_Ab1_Shop_Client_Guarantee();
        if (!$this->dublicateObjectLanguage($model, $id, $this->_sitePageData->shopMainID, FALSE)) {
            throw new HTTP_Exception_404('Client guarantee not is found!');
        }
        $this->_requestShopProducts();
        $this->_requestShopProductRubrics();


        $this->_sitePageData->newShopShablonPath('ab1/_all');
        $params = Request_RequestParams::setParams(
            array(
                'shop_client_guarantee_id' => $id,
                'sort_by' => array('id' => 'asc'),
            )
        );
        View_View::find(
            'DB_Ab1_Shop_Client_Guarantee_Item', $this->_sitePageData->shopMainID,
            '_shop/client/guarantee/item/list/item', '_shop/client/guarantee/item/one/item',
            $this->_sitePageData, $this->_driverDB, $params
        );

        // получаем данные
        $model->getElement('shop_client_id', TRUE, $this->_sitePageData->shopMainID);
        $dataID = new MyArray();
        $dataID->setValues($model, $this->_sitePageData);
        $this->_sitePageData->replaceDatas['view::_shop/client/guarantee/one/edit'] = Helpers_View::getViewObject(
            $dataID, new Model_Ab1_Shop_Client_Guarantee(),
            '_shop/client/guarantee/one/edit', $this->_sitePageData, $this->_driverDB
        );
        $this->_sitePageData->previousShopShablonPath();

        $this->_putInMain('/main/_shop/client/guarantee/edit');
    }

    public function _actionShopClientGuaranteeNew()
    {
        $this->_sitePageData->url = '/sbyt/shopclientguarantee/new';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/client/guarantee/one/new',
                'view::_shop/client/guarantee/item/list/item',
            )
        );

        $this->_requestShopProducts();
        $this->_requestShopProductRubrics();

        $this->_sitePageData->newShopShablonPath('ab1/_all');

        $dataID = new MyArray();
        $dataID->id = 0;
        $dataID->isFindDB = TRUE;
        $this->_sitePageData->replaceDatas['view::_shop/client/guarantee/one/new'] = Helpers_View::getViewObject($dataID, new Model_Ab1_Shop_Client_Guarantee(),
            '_shop/client/guarantee/one/new', $this->_sitePageData, $this->_driverDB);

        $dataID = new MyArray();
        $this->_sitePageData->replaceDatas['view::_shop/client/guarantee/item/list/item'] = Helpers_View::getViewObjects($dataID,
            new Model_Ab1_Shop_Client_Guarantee_Item(), '_shop/client/guarantee/item/list/item',
            '_shop/client/guarantee/item/one/item', $this->_sitePageData, $this->_driverDB);
        $this->_sitePageData->previousShopShablonPath();

        $this->_putInMain('/main/_shop/client/guarantee/new');
    }

    public function _actionShopCarGetPrice()
    {
        $shopClientID = intval(Request_RequestParams::getParamInt('shop_client_id'));
        $shopClientContractID = intval(Request_RequestParams::getParamInt('shop_client_contract_id'));
        $shopProductID = intval(Request_RequestParams::getParamInt('shop_product_id'));
        $quantity = intval(Request_RequestParams::getParamFloat('quantity'));
        $date = Request_RequestParams::getParamDateTime('date');
        $isCharity = Request_RequestParams::getParamBoolean('is_charity') == true;
        $isNewPayment = Request_RequestParams::getParamBoolean('is_new_payment') == true;

        if($isNewPayment){
            $result = Api_Ab1_Shop_Product::getPriceNewPayment(
                $shopClientID, $shopClientContractID, 0, $shopProductID, $isCharity, $quantity,
                $this->_sitePageData, $this->_driverDB, true, $date
            );
        }else {
            $result = Api_Ab1_Shop_Product::getPrice(
                $shopClientID, $shopClientContractID, 0, $shopProductID, $isCharity, $quantity,
                $this->_sitePageData, $this->_driverDB, true, $date
            );
        }

        $result['shop_client_id'] = $shopClientID;
        $result['shop_client_contract_id'] = $shopClientContractID;
        $result['shop_product_id'] = $shopProductID;
        $result['quantity'] = $quantity;
        $result['date'] = $date;

        $this->response->body(Json::json_encode($result));
    }

    public function _actionShopBoxcarEdit()
    {
        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/boxcar/one/edit',
            )
        );

        // id записи
        $id = Request_RequestParams::getParamInt('id');
        $model = new Model_Ab1_Shop_Boxcar();
        if (!$this->dublicateObjectLanguage($model, $id, -1, FALSE)) {
            throw new HTTP_Exception_404('Boxcar not is found!');
        }

        // получаем данные
        $this->_sitePageData->newShopShablonPath('ab1/_all');
        View_View::findOne('DB_Ab1_Shop_Boxcar',
            $this->_sitePageData->shopID, "_shop/boxcar/one/edit",
            $this->_sitePageData, $this->_driverDB, array('id' => $id),
            array(
                'shop_raw_id' => array('name'),
                'shop_boxcar_client_id' => array('name'),
            )
        );
        $this->_sitePageData->previousShopShablonPath();

        $this->_putInMain('/main/_shop/boxcar/edit');
    }

    public function _actionShopBoxcarTrainEdit()
    {
        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/boxcar/train/one/edit',
                'view::_shop/boxcar/list/item',
                'view::_shop/operation/list/zhdc',
            )
        );

        // id записи
        $id = Request_RequestParams::getParamInt('id');
        $model = new Model_Ab1_Shop_Boxcar_Train();
        if (!$this->dublicateObjectLanguage($model, $id, -1, FALSE)) {
            throw new HTTP_Exception_404('Train not is found!');
        }

        $data = $this->_requestShopClients($model->getShopBoxcarClientID(), Model_Ab1_ClientType::CLIENT_TYPE_BUY_RAW);
        $this->_sitePageData->addReplaceAndGlobalDatas('view::_shop/boxcar/client/list/list', $data);

        $this->_requestShopRaws($model->getShopRawID());
        $this->_requestShopBoxcarDepartureStations($model->getShopBoxcarDepartureStationID());
        $this->_requestShopBoxcarFactories($model->getShopBoxcarFactoryID());
        $this->_requestShopClients($model->getShopClientID(), Model_Ab1_ClientType::CLIENT_TYPE_LESSEE);
        $this->_requestShopClientContract(
            $model->getShopBoxcarClientID(), $model->getShopClientContractID(), 'list',
            Model_Ab1_ClientContract_Type::CLIENT_CONTRACT_TYPE_BUY_RAW,
            Model_Ab1_ClientContract_Status::CLIENT_CONTRACT_STATUS_WORK
        );

        $data = $this->_requestShopOperations([Model_Ab1_Shop_Operation::RUBRIC_TRAIN, Model_Ab1_Shop_Operation::RUBRIC_CONTROL]);
        $this->_sitePageData->replaceDatas['view::_shop/operation/list/zhdc'] = $data;

        $this->_requestShopOperations(Model_Ab1_Shop_Operation::RUBRIC_NBC);

        $this->_sitePageData->newShopShablonPath('ab1/_all');
        $params = Request_RequestParams::setParams(
            array(
                'shop_boxcar_train_id' => $id,
                'sort_by' => array('id' => 'asc'),
            )
        );
        View_View::find('DB_Ab1_Shop_Boxcar', $this->_sitePageData->shopMainID, '_shop/boxcar/list/item',
            '_shop/boxcar/one/item', $this->_sitePageData, $this->_driverDB, $params);

        // получаем данные
        View_View::findOne('DB_Ab1_Shop_Boxcar_Train',$this->_sitePageData->shopID, "_shop/boxcar/train/one/edit",
            $this->_sitePageData, $this->_driverDB, array('id' => $id), array());

        $this->_sitePageData->previousShopShablonPath();

        $this->_putInMain('/main/_shop/boxcar/train/edit');
    }

    public function _actionShopBoxcarTrainNew()
    {
        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/boxcar/train/one/new',
                'view::_shop/boxcar/list/item',
            )
        );

        $data = $this->_requestShopClients(null, Model_Ab1_ClientType::CLIENT_TYPE_BUY_RAW);
        $this->_sitePageData->addReplaceAndGlobalDatas('view::_shop/boxcar/client/list/list', $data);

        $this->_requestShopRaws();
        $this->_requestShopBoxcarDepartureStations();
        $this->_requestShopBoxcarFactories();
        $this->_requestShopClients(NULL, Model_Ab1_ClientType::CLIENT_TYPE_LESSEE);

        $this->_sitePageData->newShopShablonPath('ab1/_all');

        $dataID = new MyArray();
        $dataID->id = 0;
        $dataID->isFindDB = TRUE;
        $this->_sitePageData->replaceDatas['view::_shop/boxcar/train/one/new'] = Helpers_View::getViewObject($dataID, new Model_Ab1_Shop_Boxcar(),
            '_shop/boxcar/train/one/new', $this->_sitePageData, $this->_driverDB);

        $dataID = new MyArray();
        $this->_sitePageData->replaceDatas['view::_shop/boxcar/list/item'] = Helpers_View::getViewObjects($dataID,
            new Model_Ab1_Shop_Boxcar(), '_shop/boxcar/list/item',
            '_shop/boxcar/one/item', $this->_sitePageData, $this->_driverDB);

        $this->_sitePageData->previousShopShablonPath();

        $this->_putInMain('/main/_shop/boxcar/train/new');
    }


    protected function _actionShopStorageBalanceStatistics()
    {
        $this->_requestShopBranches(NULL, TRUE);
        $this->_requestShopStorages();

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/storage/list/statistics/balance',
            )
        );

        $shopStorageID = Request_RequestParams::getParamInt('shop_storage_id');

        // задаем время выборки с начала дня
        $listIDs = new MyArray();
        $params = Request_RequestParams::setParams(
            array(
                'is_exit' => 1,
                'sum_quantity' => TRUE,
                'is_charity' => FALSE,
                'shop_storage_id' => $shopStorageID,
                'group_by' => array(
                    'shop_product_id', 'shop_product_id.name',
                ),
            )
        );

        $elements = array(
            'shop_product_id' => array('name'),
        );

        $ids = Request_Request::find('DB_Ab1_Shop_Car',
            $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
            $elements
        );
        $ids->addChilds(
            Request_Request::find('DB_Ab1_Shop_Piece_Item',
                $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
                $elements
            )
        );
        foreach ($ids->childs as $child){
            $child->additionDatas = array(
                'quantity' => -$child->values['quantity'],
            );

            $listIDs->childs[$child->values['shop_product_id']] = $child;
        }


        $params = Request_RequestParams::setParams(
            array(
                'sum_quantity' => TRUE,
                'shop_storage_id' => $shopStorageID,
                'group_by' => array(
                    'shop_product_id', 'shop_product_id.name',
                ),
            )
        );

        $ids = Request_Request::find('DB_Ab1_Shop_Product_Storage',
            $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
            $elements
        );
        foreach ($ids->childs as $child){
            $shopClientID = $child->values['shop_product_id'];
            if(!key_exists($shopClientID, $listIDs->childs)){
                $child->additionDatas = array(
                    'quantity' => 0,
                );
                $listIDs->childs[$shopClientID] = $child;
            }

            $listIDs->childs[$shopClientID]->additionDatas['quantity'] += $child->values['quantity'];
        }

        $listIDs->childsSortBy(
            array(
                Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_product_id.name',
            )
        );

        $listIDs->additionDatas = $listIDs->calcTotalsChild(array('quantity'), true);

        $this->_sitePageData->countRecord = count($listIDs->childs);

        $this->_sitePageData->newShopShablonPath('ab1/_all');
        $this->_sitePageData->replaceDatas['view::_shop/storage/list/statistics/balance'] = Helpers_View::getViewObjects(
            $listIDs, new Model_Ab1_Shop_Product_Rubric(),
            '_shop/storage/list/statistics/balance','_shop/storage/one/statistics/balance',
            $this->_sitePageData, $this->_driverDB
        );
        $this->_sitePageData->previousShopShablonPath();

        $this->_putInMain('/main/_shop/storage/statistics-balance');
    }

    public function _actionShopMoveCarStatistics()
    {
        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/move/car/list/statistics',
            )
        );
        $this->_requestShopBranches($this->_sitePageData->shopID, TRUE);

        // задаем время выборки с начала дня
        $dateFrom = date('Y-m-d').' 06:00:00';
        $listIDs = new MyArray();
        $params = Request_RequestParams::setParams(
            array(
                'created_at_from' => $dateFrom,
                'sum_quantity' => TRUE,
                'group_by' => array(
                    'shop_client_id', 'shop_client_id.name',
                ),
            )
        );

        $elements = array(
            'shop_client_id' => array('name'),
        );

        $resultArray = array(
            'quantity_day' => 0,
            'quantity_yesterday' => 0,
            'quantity_week' => 0,
            'quantity_month' => 0,
            'quantity_month_previous' => 0,
            'quantity_year' => 0,
        );

        $ids = Request_Request::find('DB_Ab1_Shop_Move_Car',
            $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
            $elements
        );
        foreach ($ids->childs as $child){
            $shopClientID = $child->values['shop_client_id'];
            if(!key_exists($shopClientID, $listIDs->childs)){
                $child->additionDatas = $resultArray;
                $listIDs->childs[$shopClientID] = $child;
            }

            $listIDs->childs[$shopClientID]->additionDatas['quantity_day'] += $child->values['quantity'];
        }

        // задаем время выборки вчера
        $paramsYesterday = $params;
        $paramsYesterday['created_at_to'] = $dateFrom;
        $paramsYesterday['created_at_from'] = Helpers_DateTime::minusDays($dateFrom, 1);

        $ids = Request_Request::find('DB_Ab1_Shop_Move_Car',
            $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB, $paramsYesterday, 0, TRUE,
            $elements
        );
        foreach ($ids->childs as $child){
            $shopClientID = $child->values['shop_client_id'];
            if(!key_exists($shopClientID, $listIDs->childs)){
                $child->additionDatas = $resultArray;
                $listIDs->childs[$shopClientID] = $child;
            }

            $listIDs->childs[$shopClientID]->additionDatas['quantity_yesterday'] += $child->values['quantity'];
        }

        // задаем время выборки с начала недели
        $dateFrom = Helpers_DateTime::getWeekBeginStr(date('Y-m-d')).' 06:00:00';
        $params['created_at_from'] = $dateFrom;

        $ids = Request_Request::find('DB_Ab1_Shop_Move_Car',
            $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
            $elements
        );
        foreach ($ids->childs as $child){
            $shopClientID = $child->values['shop_client_id'];
            if(!key_exists($shopClientID, $listIDs->childs)){
                $child->additionDatas = $resultArray;
                $listIDs->childs[$shopClientID] = $child;
            }

            $listIDs->childs[$shopClientID]->additionDatas['quantity_week'] += $child->values['quantity'];
        }

        // задаем время выборки с начала месяца
        $dateFrom = Helpers_DateTime::getMonthBeginStr(date('m'), date('Y')).' 06:00:00';
        $params['created_at_from'] = $dateFrom;

        $ids = Request_Request::find('DB_Ab1_Shop_Move_Car',
            $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
            $elements
        );
        foreach ($ids->childs as $child){
            $shopClientID = $child->values['shop_client_id'];
            if(!key_exists($shopClientID, $listIDs->childs)){
                $child->additionDatas = $resultArray;
                $listIDs->childs[$shopClientID] = $child;
            }

            $listIDs->childs[$shopClientID]->additionDatas['quantity_month'] += $child->values['quantity'];
        }

        // задаем время выборки с предыдущего месяца
        $paramsPreviousMonth = $params;
        $tmp = Helpers_DateTime::getMonthBeginStr(date('m'), date('Y')).' 06:00:00';
        $paramsPreviousMonth['created_at_to'] = $tmp;
        $paramsPreviousMonth['created_at_from'] = Helpers_DateTime::minusMonth($tmp, 1, true);

        $ids = Request_Request::find('DB_Ab1_Shop_Move_Car',
            $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB, $paramsPreviousMonth, 0, TRUE,
            $elements
        );
        foreach ($ids->childs as $child){
            $shopClientID = $child->values['shop_client_id'];
            if(!key_exists($shopClientID, $listIDs->childs)){
                $child->additionDatas = $resultArray;
                $listIDs->childs[$shopClientID] = $child;
            }

            $listIDs->childs[$shopClientID]->additionDatas['quantity_month_previous'] += $child->values['quantity'];
        }

        // задаем время выборки с начала года
        $dateFrom = Helpers_DateTime::getYearBeginStr(date('Y')).' 06:00:00';
        $params['created_at_from'] = $dateFrom;

        $ids = Request_Request::find('DB_Ab1_Shop_Move_Car',
            $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
            $elements
        );
        foreach ($ids->childs as $child){
            $shopClientID = $child->values['shop_client_id'];
            if(!key_exists($shopClientID, $listIDs->childs)){
                $child->additionDatas = $resultArray;
                $listIDs->childs[$shopClientID] = $child;
            }

            $listIDs->childs[$shopClientID]->additionDatas['quantity_year'] += $child->values['quantity'];
        }

        $listIDs->additionDatas = $listIDs->calcTotalsChild(
            array(
                'quantity_day',
                'quantity_yesterday',
                'quantity_week',
                'quantity_month',
                'quantity_month_previous',
                'quantity_year',
            ),
            true
        );
        $listIDs->childsSortBy(
            Request_RequestParams::getParamArray('sort_by', [],
                array(
                    'shop_client_id'=> 'asc',
                    'quantity_day' => 'asc',
                    'quantity_yesterday' => 'asc',
                    'quantity_week' => 'asc',
                    'quantity_month' => 'asc',
                    'quantity_month_previous' => 'asc',
                    'quantity_year' => 'asc',
                )
            ), true, true
        );
        $this->_sitePageData->countRecord = count($listIDs->childs);

        $this->_sitePageData->newShopShablonPath('ab1/_all');
        $this->_sitePageData->replaceDatas['view::_shop/move/car/list/statistics'] = Helpers_View::getViewObjects(
            $listIDs, new Model_Ab1_Shop_Move_Car(),
            '_shop/move/car/list/statistics','_shop/move/car/one/statistics',
            $this->_sitePageData, $this->_driverDB
        );
        $this->_sitePageData->previousShopShablonPath();

        $this->_putInMain('/main/_shop/move/car/statistics');
    }

    public function _actionShopRawMaterialNew()
    {
        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/raw/material/one/new',
                'view::_shop/raw/material/item/list/index',
            )
        );

        $shopRawIDs = Arr::path($this->_sitePageData->operation->getAccessArray(), 'shop_raw_ids', NULL);
        $this->_requestShopRaws(
            null, Request_RequestParams::setParams(array('id' => $shopRawIDs))
        );
        $this->_requestShopBallastCrushers();

        $file = 'index';

        $dataID = new MyArray();
        $dataID->id = 0;
        $dataID->isFindDB = TRUE;
        $dataID->additionDatas['material'] = array();

        $this->_sitePageData->newShopShablonPath('ab1/_all');
        $this->_sitePageData->replaceDatas['view::_shop/raw/material/item/list/index'] = Helpers_View::getViewObjects(
            $dataID, new Model_Ab1_Shop_Formula_Raw_Item(),
            '_shop/raw/material/item/list/'.$file, '_shop/raw/material/item/one/'.$file,
            $this->_sitePageData, $this->_driverDB, $this->_sitePageData->shopMainID
        );

        $dataID = new MyArray();
        $dataID->id = 0;
        $dataID->isFindDB = TRUE;
        $this->_sitePageData->replaceDatas['view::_shop/raw/material/one/new'] = Helpers_View::getViewObject(
            $dataID, new Model_Ab1_Shop_Formula_Material(),
            '_shop/raw/material/one/new', $this->_sitePageData, $this->_driverDB, $this->_sitePageData->shopMainID
        );
        $this->_sitePageData->previousShopShablonPath();

        $this->_putInMain('/main/_shop/raw/material/new');
    }

    public function _actionShopRawMaterialEdit()
    {
        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/raw/material/one/edit',
                'view::_shop/raw/material/item/list/index',
            )
        );

        // id записи
        $id = Request_RequestParams::getParamInt('id');
        $model = new Model_Ab1_Shop_Raw_Material();
        if (!$this->dublicateObjectLanguage($model, $id, $this->_sitePageData->shopID, FALSE)) {
            throw new HTTP_Exception_404('Raw material not is found!');
        }

        $shopRawIDs = Arr::path($this->_sitePageData->operation->getAccessArray(), 'shop_raw_ids', NULL);
        $this->_requestShopRaws(
            null, Request_RequestParams::setParams(array('id' => $shopRawIDs))
        );
        $this->_requestShopMaterials();
        $this->_requestShopBallastCrushers($model->getShopBallastCrusherID());

        $file = 'index';

        $this->_sitePageData->newShopShablonPath('ab1/_all');

        $params = Request_RequestParams::setParams(
            array(
                'shop_raw_material_id' => $id,
                'is_delete' => $model->getIsDelete(),
                'sort_by' => array('id' => 'asc'),
            )
        );
        $ids = Request_Request::find(
            'DB_Ab1_Shop_Raw_Material_Item', $this->_sitePageData->shopID,
            $this->_sitePageData, $this->_driverDB, $params, 0, true,
            array(
                'shop_raw_id' => array('name'),
                'shop_material_id' => array('name'),
            )
        );
        $ids->additionDatas['material'] = $model->getValues(true, true);

        $modelItem = new Model_Ab1_Shop_Raw_Material_Item();
        $modelItem->setDBDriver($this->_driverDB);
        $result = Helpers_View::getViewObjects(
            $ids, $modelItem,
            '_shop/raw/material/item/list/'.$file, '_shop/raw/material/item/one/'.$file,
            $this->_sitePageData, $this->_driverDB, $this->_sitePageData->shopID
        );

        $this->_sitePageData->replaceDatas['view::_shop/raw/material/item/list/index'] = $result;

        // получаем данные
        View_View::findOne('DB_Ab1_Shop_Raw_Material',
            $this->_sitePageData->shopID, "_shop/raw/material/one/edit",
            $this->_sitePageData, $this->_driverDB, array('id' => $id), array()
        );
        $this->_sitePageData->previousShopShablonPath();

        $this->_putInMain('/main/_shop/raw/material/edit');
    }

    public function _actionShopFormulaRawNew()
    {
        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/formula/raw/one/new',
                'view::_shop/formula/raw/item/list/index',
            )
        );

        $this->_requestShopMaterials();
        $this->_requestShopRaws();
        $this->_requestShopBallastCrushers();

        $file = 'index';

        $dataID = new MyArray();
        $dataID->id = 0;
        $dataID->isFindDB = TRUE;
        $dataID->additionDatas['material'] = array();

        $this->_sitePageData->newShopShablonPath('ab1/_all');
        $this->_sitePageData->replaceDatas['view::_shop/formula/raw/item/list/index'] = Helpers_View::getViewObjects(
            $dataID, new Model_Ab1_Shop_Formula_Raw_Item(),
            '_shop/formula/raw/item/list/'.$file, '_shop/formula/raw/item/one/'.$file,
            $this->_sitePageData, $this->_driverDB, $this->_sitePageData->shopID
        );

        $dataID = new MyArray();
        $dataID->id = 0;
        $dataID->isFindDB = TRUE;
        $this->_sitePageData->replaceDatas['view::_shop/formula/raw/one/new'] = Helpers_View::getViewObject(
            $dataID, new Model_Ab1_Shop_Formula_Material(),
            '_shop/formula/raw/one/new', $this->_sitePageData, $this->_driverDB, $this->_sitePageData->shopID
        );
        $this->_sitePageData->previousShopShablonPath();

        $this->_putInMain('/main/_shop/formula/raw/new');
    }

    public function _actionShopFormulaRawEdit()
    {
        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/formula/raw/one/edit',
                'view::_shop/formula/raw/item/list/index',
            )
        );

        // id записи
        $id = Request_RequestParams::getParamInt('id');
        $model = new Model_Ab1_Shop_Formula_Raw();
        if (!$this->dublicateObjectLanguage($model, $id, $this->_sitePageData->shopID, FALSE)) {
            throw new HTTP_Exception_404('Formula ballast not is found!');
        }

        $this->_requestShopMaterials();
        $this->_requestShopRaws();
        $this->_requestShopBallastCrushers($model->getShopBallastCrusherID());

        $file = 'index';

        $this->_sitePageData->newShopShablonPath('ab1/_all');

        $params = Request_RequestParams::setParams(
            array(
                'shop_formula_raw_id' => $id,
                'sort_by' => array('id' => 'asc'),
            )
        );
        $ids = Request_Request::find(
            'DB_Ab1_Shop_Formula_Raw_Item', $this->_sitePageData->shopID,
            $this->_sitePageData, $this->_driverDB, $params, 0, true
        );
        $ids->additionDatas['material'] = $model->getValues(true, true);

        $modelItem = new Model_Ab1_Shop_Formula_Raw_Item();
        $modelItem->setDBDriver($this->_driverDB);
        $result = Helpers_View::getViewObjects(
            $ids, $modelItem,
            '_shop/formula/raw/item/list/'.$file, '_shop/formula/raw/item/one/'.$file,
            $this->_sitePageData, $this->_driverDB, $this->_sitePageData->shopID
        );

        $this->_sitePageData->replaceDatas['view::_shop/formula/raw/item/list/index'] = $result;

        // получаем данные
        View_View::findOne('DB_Ab1_Shop_Formula_Raw',
            $this->_sitePageData->shopID, "_shop/formula/raw/one/edit",
            $this->_sitePageData, $this->_driverDB, array('id' => $id), array()
        );
        $this->_sitePageData->previousShopShablonPath();

        $this->_putInMain('/main/_shop/formula/raw/edit');
    }

    public function _actionShopFormulaMaterialNew()
    {
        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/formula/material/one/new',
                'view::_shop/formula/material/item/list/index',
                'view::_shop/formula/material/item/list/side',
            )
        );

        $this->_requestShopMaterials();
        $this->_requestShopRaws();
        $this->_requestShopFormulaGroups();

        switch (Request_RequestParams::getParamInt('formula_type_id')){
            case Model_Ab1_FormulaType::FORMULA_MATERIAL_TYPE_BITUMEN_FUEL_OIL:
                $file = 'type/bitumen-fuel-oil';
                break;
            case Model_Ab1_FormulaType::FORMULA_MATERIAL_TYPE_BITUMEN:
                $file = 'type/bitumen';
                break;
            case Model_Ab1_FormulaType::FORMULA_MATERIAL_TYPE_CONCRETE:
                $file = 'type/concrete';
                break;
            default:
                $file = 'index';
        }

        $dataID = new MyArray();
        $dataID->id = 0;
        $dataID->isFindDB = TRUE;
        $dataID->additionDatas['material'] = array();

        $this->_sitePageData->newShopShablonPath('ab1/_all');
        $this->_sitePageData->replaceDatas['view::_shop/formula/material/item/list/index'] = Helpers_View::getViewObjects(
            $dataID, new Model_Ab1_Shop_Formula_Material_Item(),
            '_shop/formula/material/item/list/'.$file, '_shop/formula/material/item/one/'.$file,
            $this->_sitePageData, $this->_driverDB, $this->_sitePageData->shopID
        );

        $dataID = new MyArray();
        $dataID->id = 0;
        $dataID->isFindDB = TRUE;
        $this->_sitePageData->replaceDatas['view::_shop/formula/material/item/list/side'] = Helpers_View::getViewObjects(
            $dataID, new Model_Ab1_Shop_Formula_Material_Item(),
            '_shop/formula/material/item/list/side', '_shop/formula/material/item/one/side',
            $this->_sitePageData, $this->_driverDB, $this->_sitePageData->shopID
        );

        $dataID = new MyArray();
        $dataID->id = 0;
        $dataID->isFindDB = TRUE;
        $this->_sitePageData->replaceDatas['view::_shop/formula/material/one/new'] = Helpers_View::getViewObject(
            $dataID, new Model_Ab1_Shop_Formula_Material(), '_shop/formula/material/one/new',
            $this->_sitePageData, $this->_driverDB, $this->_sitePageData->shopID
        );
        $this->_sitePageData->previousShopShablonPath();

        $this->_putInMain('/main/_shop/formula/material/new');
    }

    public function _actionShopFormulaMaterialEdit()
    {
        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/formula/material/one/edit',
                'view::_shop/formula/material/item/list/index',
                'view::_shop/formula/material/item/list/side',
            )
        );

        // id записи
        $id = Request_RequestParams::getParamInt('id');
        $model = new Model_Ab1_Shop_Formula_Material();
        if (!$this->dublicateObjectLanguage($model, $id, $this->_sitePageData->shopID, FALSE)) {
            throw new HTTP_Exception_404('Formula material not is found!');
        }

        $this->_requestShopMaterials();
        $this->_requestShopRaws();
        $this->_requestShopFormulaGroups($model->getShopFormulaGroupIDsArray());

        switch ($model->getFormulaTypeID()){
            case Model_Ab1_FormulaType::FORMULA_MATERIAL_TYPE_BITUMEN_FUEL_OIL:
                $file = 'type/bitumen-fuel-oil';
                break;
            case Model_Ab1_FormulaType::FORMULA_MATERIAL_TYPE_BITUMEN:
                $file = 'type/bitumen';
                break;
            case Model_Ab1_FormulaType::FORMULA_MATERIAL_TYPE_CONCRETE:
                $file = 'type/concrete';
                break;
            default:
                $file = 'index';
        }

        $this->_sitePageData->newShopShablonPath('ab1/_all');

        $ids = Request_Request::find(
            'DB_Ab1_Shop_Formula_Material_Item', $this->_sitePageData->shopID,
            $this->_sitePageData, $this->_driverDB,
            Request_RequestParams::setParams(
                array(
                    'shop_formula_material_id' => $id,
                    'is_side' => false,
                    'sort_by' => array('id' => 'asc'),
                )
            ),
            0, true
        );
        $ids->additionDatas['material'] = $model->getValues(true, true);

        $modelItem = new Model_Ab1_Shop_Formula_Material_Item();
        $modelItem->setDBDriver($this->_driverDB);
        $result = Helpers_View::getViewObjects(
            $ids, $modelItem,
            '_shop/formula/material/item/list/'.$file, '_shop/formula/material/item/one/'.$file,
            $this->_sitePageData, $this->_driverDB, $this->_sitePageData->shopID
        );

        $this->_sitePageData->replaceDatas['view::_shop/formula/material/item/list/index'] = $result;

        $this->_sitePageData->replaceDatas['view::_shop/formula/material/item/list/side'] =
            View_View::find('DB_Ab1_Shop_Formula_Material_Item',
                $this->_sitePageData->shopID,
                '_shop/formula/material/item/list/side', '_shop/formula/material/item/one/side',
                $this->_sitePageData, $this->_driverDB,
                Request_RequestParams::setParams(
                    array(
                        'shop_formula_material_id' => $id,
                        'is_side' => true,
                        'sort_by' => array('id'=>'asc')
                    )
                )
            );

        // получаем данные
        View_View::findOne('DB_Ab1_Shop_Formula_Material',
            $this->_sitePageData->shopID, "_shop/formula/material/one/edit",
            $this->_sitePageData, $this->_driverDB, array('id' => $id), array()
        );
        $this->_sitePageData->previousShopShablonPath();

        $this->_putInMain('/main/_shop/formula/material/edit');
    }

    public function _actionShopFormulaProductNew()
    {
        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/formula/product/one/new',
                'view::_shop/formula/product/item/list/index',
                'view::_shop/formula/product/item/list/side',
            )
        );

        // основная продукция
        $this->_requestShopProducts(
            null, 0,
            Arr::path($this->_sitePageData->operation->getAccessArray(), 'shop_product_rubric_ids', NULL),
            TRUE,
            [
                Model_Ab1_ProductView::PRODUCT_TYPE_CAR,
                Model_Ab1_ProductView::PRODUCT_TYPE_CAR_AND_PIECE,
                Model_Ab1_ProductView::PRODUCT_TYPE_PIECE
            ],
            'list', true
        );

        // основная продукция
        $this->_requestShopFormulaGroups();

        $this->_requestShopMaterials(null, Request_RequestParams::getParamInt('formula_type_id'));

        switch (Request_RequestParams::getParamInt('formula_type_id')){
            case Model_Ab1_FormulaType::FORMULA_PRODUCT_TYPE_ASPHALT:
                $file = 'type/asphalt';
                break;
            case Model_Ab1_FormulaType::FORMULA_PRODUCT_TYPE_ZHBI:
                $file = 'type/zhbi';
                break;
            case Model_Ab1_FormulaType::FORMULA_PRODUCT_TYPE_EMULSION:
                $file = 'type/emulsion';
                break;
            case Model_Ab1_FormulaType::FORMULA_PRODUCT_TYPE_CONCRETE:
                $file = 'type/concrete';
                break;
            case Model_Ab1_FormulaType::FORMULA_PRODUCT_TYPE_ASPHALT_BUNKER:
                $file = 'type/asphalt-bunker';
                break;
            default:
                $file = 'index';
        }

        $this->_sitePageData->newShopShablonPath('ab1/_all');

        $dataID = new MyArray();
        $dataID->id = 0;
        $dataID->isFindDB = TRUE;
        $this->_sitePageData->replaceDatas['view::_shop/formula/product/item/list/index'] = Helpers_View::getViewObjects(
            $dataID, new Model_Ab1_Shop_Formula_Product_Item(),
            '_shop/formula/product/item/list/'.$file, '_shop/formula/product/item/one/'.$file,
            $this->_sitePageData, $this->_driverDB, $this->_sitePageData->shopID
        );

        $dataID = new MyArray();
        $dataID->id = 0;
        $dataID->isFindDB = TRUE;
        $this->_sitePageData->replaceDatas['view::_shop/formula/product/item/list/side'] = Helpers_View::getViewObjects(
            $dataID, new Model_Ab1_Shop_Formula_Product_Item(),
            '_shop/formula/product/item/list/side', '_shop/formula/product/item/one/side',
            $this->_sitePageData, $this->_driverDB, $this->_sitePageData->shopID
        );

        $dataID = new MyArray();
        $dataID->id = 0;
        $dataID->isFindDB = TRUE;
        $this->_sitePageData->replaceDatas['view::_shop/formula/product/one/new'] = Helpers_View::getViewObject(
            $dataID, new Model_Ab1_Shop_Formula_Product(),
            '_shop/formula/product/one/new',
            $this->_sitePageData, $this->_driverDB, $this->_sitePageData->shopID
        );
        $this->_sitePageData->previousShopShablonPath();

        $this->_putInMain('/main/_shop/formula/product/new');
    }

    public function _actionShopFormulaProductEdit()
    {
        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/formula/product/one/edit',
                'view::_shop/formula/product/item/list/index',
                'view::_shop/formula/product/item/list/side',
            )
        );

        // id записи
        $id = Request_RequestParams::getParamInt('id');
        $model = new Model_Ab1_Shop_Formula_Product();
        if (!$this->dublicateObjectLanguage($model, $id, $this->_sitePageData->shopID, FALSE)) {
            throw new HTTP_Exception_404('Formula product not is found!1');
        }

        // основная продукция
        $this->_requestShopProducts(
            $model->getShopProductID(), 0,
            Arr::path($this->_sitePageData->operation->getAccessArray(), 'shop_product_rubric_ids', NULL),
            TRUE,
            [
                Model_Ab1_ProductView::PRODUCT_TYPE_CAR,
                Model_Ab1_ProductView::PRODUCT_TYPE_CAR_AND_PIECE,
                Model_Ab1_ProductView::PRODUCT_TYPE_PIECE
            ],
            'list', true
        );

        $this->_requestShopFormulaGroups($model->getShopFormulaGroupIDsArray());
        $this->_requestShopMaterials(null, $model->getFormulaTypeID());

        switch ($model->getFormulaTypeID()){
            case Model_Ab1_FormulaType::FORMULA_PRODUCT_TYPE_ASPHALT:
                $file = 'type/asphalt';
                break;
            case Model_Ab1_FormulaType::FORMULA_PRODUCT_TYPE_ZHBI:
                $file = 'type/zhbi';
                break;
            case Model_Ab1_FormulaType::FORMULA_PRODUCT_TYPE_EMULSION:
                $file = 'type/emulsion';
                break;
            case Model_Ab1_FormulaType::FORMULA_PRODUCT_TYPE_CONCRETE:
                $file = 'type/concrete';
                break;
            case Model_Ab1_FormulaType::FORMULA_PRODUCT_TYPE_ASPHALT_BUNKER:
                $file = 'type/asphalt-bunker';
                break;
            default:
                $file = 'index';
        }

        $this->_sitePageData->newShopShablonPath('ab1/_all');

        $this->_sitePageData->replaceDatas['view::_shop/formula/product/item/list/index'] =
            View_View::find('DB_Ab1_Shop_Formula_Product_Item',
                $this->_sitePageData->shopID,
                '_shop/formula/product/item/list/'.$file, '_shop/formula/product/item/one/'.$file,
                $this->_sitePageData, $this->_driverDB,
                Request_RequestParams::setParams(
                    array(
                        'shop_formula_product_id' => $id,
                        'is_side' => false,
                        'sort_by' => array('id'=>'asc')
                    )
                )
            );

        $this->_sitePageData->replaceDatas['view::_shop/formula/product/item/list/side'] =
            View_View::find('DB_Ab1_Shop_Formula_Product_Item',
                $this->_sitePageData->shopID,
                '_shop/formula/product/item/list/side', '_shop/formula/product/item/one/side',
                $this->_sitePageData, $this->_driverDB,
                Request_RequestParams::setParams(
                    array(
                        'shop_formula_product_id' => $id,
                        'is_side' => true,
                        'sort_by' => array('id'=>'asc')
                    )
                )
            );

        // получаем данные
        View_View::findOne('DB_Ab1_Shop_Formula_Product',
            $this->_sitePageData->shopID,
            "_shop/formula/product/one/edit",
            $this->_sitePageData, $this->_driverDB,
            array('id' => $id), array()
        );
        $this->_sitePageData->previousShopShablonPath();

        $this->_putInMain('/main/_shop/formula/product/edit');
    }

    public function _actionShopCarTTN() {
        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/car/list/ttn',
            )
        );

        $dateFrom = Request_RequestParams::getParamDateTime('date_from');
        $dateTo = Request_RequestParams::getParamDateTime('date_to');
        $isQuantityReceive = Request_RequestParams::getParamBoolean('is_quantity_receive');

        $this->_requestShopBranches(null, true);

        $params = array_merge($_GET, $_POST);
        unset($params['date_from']);
        unset($params['date_to']);
        unset($params['is_quantity_receive']);

        $ttns = Api_Ab1_Shop_Car::getTTNs(
            $dateFrom, $dateTo,
            $this->_sitePageData, $this->_driverDB,
            $isQuantityReceive,
            Request_RequestParams::setParams($params)
        );

        $this->_sitePageData->newShopShablonPath('ab1/_all');
        $this->_sitePageData->replaceDatas['view::_shop/car/list/ttn'] = Helpers_View::getViewObjects(
            $ttns, new Model_Ab1_Shop_Car(),
            '_shop/car/list/ttn', '_shop/car/one/ttn',
            $this->_sitePageData, $this->_driverDB
        );
        $this->_sitePageData->previousShopShablonPath();

        $this->_putInMain('/main/_shop/car/ttn');
    }

    public function _actionShopPaymentNew()
    {
        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/payment/one/new',
                '_shop/payment/item/list/index',
            )
        );

        // основная продукция
        $this->_requestShopProducts(
            null, 0, NULL, FALSE,
            [
                Model_Ab1_ProductView::PRODUCT_TYPE_CAR,
                Model_Ab1_ProductView::PRODUCT_TYPE_CAR_AND_PIECE,
                Model_Ab1_ProductView::PRODUCT_TYPE_PIECE
            ]
        );

        $this->_requestPaymentTypes();

        $this->_requestOrganizationTypes();
        $this->_requestKatos();
        $this->_requestListDB(DB_Ab1_Shop_Cashbox_Terminal::NAME);

        $this->_sitePageData->newShopShablonPath('ab1/_all');

        $dataID = new MyArray();
        $dataID->id = 0;
        $dataID->isFindDB = TRUE;
        $this->_sitePageData->replaceDatas['view::_shop/payment/item/list/index'] = Helpers_View::getViewObjects($dataID,
            new Model_Ab1_Shop_Payment_Item(), '_shop/payment/item/list/index',
            '_shop/payment/item/one/index', $this->_sitePageData, $this->_driverDB);

        $dataID = new MyArray();
        $dataID->id = 0;
        $dataID->isFindDB = TRUE;
        $this->_sitePageData->replaceDatas['view::_shop/payment/one/new'] = Helpers_View::getViewObject($dataID, new Model_Ab1_Shop_Payment(),
            '_shop/payment/one/new', $this->_sitePageData, $this->_driverDB);

        $this->_sitePageData->previousShopShablonPath();

        $this->_putInMain('/main/_shop/payment/new');
    }

    public function _actionShopPaymentEdit()
    {
        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/payment/one/edit',
                '_shop/payment/item/list/index',
            )
        );

        // id записи
        $shopPaymentID = Request_RequestParams::getParamInt('id');
        $model = new Model_Ab1_Shop_Payment();
        if (!$this->dublicateObjectLanguage($model, $shopPaymentID, -1, FALSE)) {
            throw new HTTP_Exception_404('Payment not is found!');
        }

        // основная продукция
        $this->_requestShopProducts(
            null, 0, NULL, FALSE,
            [
                Model_Ab1_ProductView::PRODUCT_TYPE_CAR,
                Model_Ab1_ProductView::PRODUCT_TYPE_CAR_AND_PIECE,
                Model_Ab1_ProductView::PRODUCT_TYPE_PIECE
            ]
        );

        $this->_requestPaymentTypes($model->getPaymentTypeID());
        $this->_requestOrganizationTypes();
        $this->_requestKatos();
        $this->_requestListDB(DB_Ab1_Shop_Cashbox_Terminal::NAME, $model->getCashboxTerminalID());

        $this->_requestShopClientContract(
            $model->getShopClientID(), $model->getShopClientContractID(), 'list', null,
            Model_Ab1_ClientContract_Status::CLIENT_CONTRACT_STATUS_WORK
        );

        $this->_sitePageData->newShopShablonPath('ab1/_all');

        View_View::find('DB_Ab1_Shop_Payment_Item', $this->_sitePageData->shopID, '_shop/payment/item/list/index',
            '_shop/payment/item/one/index', $this->_sitePageData, $this->_driverDB, array('shop_payment_id' => $shopPaymentID,
                'sort_by'=>array('value'=>array('id'=>'asc')), Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE));

        // получаем данные
        View_View::findOne('DB_Ab1_Shop_Payment', $this->_sitePageData->shopID, "_shop/payment/one/edit",
            $this->_sitePageData, $this->_driverDB, array('id' => $shopPaymentID), array('shop_client_id'));

        $this->_sitePageData->previousShopShablonPath();

        $this->_putInMain('/main/_shop/payment/edit');
    }

    public function _actionShopMaterialNew()
    {
        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/material/one/new',
            )
        );
        $this->_requestShopMaterialRubrics();

        $this->_sitePageData->globalDatas['view::formula-type/list/access'] = $this->_requestFormulaTypes();
        $this->_requestFormulaTypes(NULL, Model_Ab1_FormulaType::PARTICLE_TYPE_MATERIAL);
        $this->_requestListDB('DB_Ab1_Shop_Material_Rubric_Make');

        $dataID = new MyArray();
        $dataID->id = 0;
        $dataID->isFindDB = TRUE;

        $this->_sitePageData->newShopShablonPath('ab1/_all');
        $this->_sitePageData->replaceDatas['view::_shop/material/one/new'] = Helpers_View::getViewObject(
            $dataID, new Model_Ab1_Shop_Material(),
            '_shop/material/one/new',
            $this->_sitePageData, $this->_driverDB, $this->_sitePageData->shopMainID
        );
        $this->_sitePageData->previousShopShablonPath();

        $this->_putInMain('/main/_shop/material/new');
    }

    public function _actionShopMaterialEdit()
    {
        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/material/one/edit',
            )
        );

        // id записи
        $id = Request_RequestParams::getParamInt('id');
        $model = new Model_Ab1_Shop_Material();
        if (! $this->dublicateObjectLanguage($model, $id, $this->_sitePageData->shopMainID, FALSE)) {
            throw new HTTP_Exception_404('Material not is found!');
        }
        $this->_requestShopMaterialRubrics($model->getShopMaterialRubricID());
        $this->_sitePageData->globalDatas['view::formula-type/list/access'] =
            $this->_requestFormulaTypes($model->getAccessFormulaTypeIDsArray());
        $this->_requestFormulaTypes($model->getFormulaTypeIDsArray(), Model_Ab1_FormulaType::PARTICLE_TYPE_MATERIAL);
        $this->_requestListDB('DB_Ab1_Shop_Material_Rubric_Make', $model->getShopMaterialRubricMakeID());

        // получаем данные
        $this->_sitePageData->newShopShablonPath('ab1/_all');
        View_View::findOne('DB_Ab1_Shop_Material', $this->_sitePageData->shopMainID, "_shop/material/one/edit",
            $this->_sitePageData, $this->_driverDB, array('id' => $id));
        $this->_sitePageData->previousShopShablonPath();

        $this->_putInMain('/main/_shop/material/edit');
    }

    protected function _actionShopInvoiceDiscountDelete() {
        $shopInvoiceID = Request_RequestParams::getParamInt('shop_invoice_id');
        $shopProductID = Request_RequestParams::getParamInt('shop_product_id');
        $price = Request_RequestParams::getParamInt('price');

        Api_Ab1_Shop_Invoice::deleteDiscountProduct(
            $shopInvoiceID, $shopProductID, $price, $this->_sitePageData, $this->_driverDB
        );

        self::redirect(
            '/sbyt/shopinvoice/edit' . URL::query(array('id' => $shopInvoiceID,))
        );
    }

    protected function _actionShopInvoiceModalEdit() {

        $shopClientID = Request_RequestParams::getParamInt('shop_client_id');
        $shopClientAttorneyID = Request_RequestParams::getParamInt('shop_client_attorney_id');
        $shopClientContractID = Request_RequestParams::getParamInt('shop_client_contract_id');

        $this->_requestShopClientAttorney($shopClientID, $shopClientAttorneyID, 'option');
        $this->_requestShopClientContract($shopClientID, $shopClientContractID, 'list', null,
            Model_Ab1_ClientContract_Status::CLIENT_CONTRACT_STATUS_WORK);

        $dataID = new MyArray();
        $dataID->id = $shopClientID;

        $model = new Model_Ab1_Shop_Client();
        $model->setDBDriver($this->_driverDB);

        $this->_sitePageData->newShopShablonPath('ab1/_all');
        $result = Helpers_View::getViewObject(
            $dataID, $model,
            '_shop/invoice/one/modal-edit',
            $this->_sitePageData, $this->_driverDB, $this->_sitePageData->shopMainID
        );
        $this->_sitePageData->previousShopShablonPath();

        $this->response->body($this->_sitePageData->replaceStaticDatas($result));
    }

    protected function _actionClientContractTypeNew()
    {
        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::client-contract/type/one/new',
            )
        );

        $this->_requestListDB('DB_Ab1_Interface');
        $this->_requestClientContractTypes(null, true);

        $dataID = new MyArray();
        $dataID->id = 0;
        $dataID->isFindDB = TRUE;

        $this->_sitePageData->newShopShablonPath('ab1/_all');
        $this->_sitePageData->replaceDatas['view::client-contract/type/one/new'] = Helpers_View::getViewObject(
            $dataID, new Model_Ab1_ClientContract_Type(),
            'client-contract/type/one/new', $this->_sitePageData, $this->_driverDB,
            $this->_sitePageData->shopMainID
        );
        $this->_sitePageData->previousShopShablonPath();

        $this->_putInMain('/main/client-contract/type/new');
    }

    protected function _actionClientContractTypeEdit()
    {
        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::client-contract/type/one/edit',
            )
        );

        // id записи
        $id = Request_RequestParams::getParamInt('id');
        $model = new Model_Ab1_ClientContract_Type();
        if (! $this->dublicateObjectLanguage($model, $id, $this->_sitePageData->shopMainID, FALSE)) {
            throw new HTTP_Exception_404('Client contract type not is found!');
        }

        $this->_requestListDB('DB_Ab1_Interface', $model->getInterfaceIDsArray());
        $this->_requestClientContractTypes($model->getRootID(), true);

        // получаем данные
        $this->_sitePageData->newShopShablonPath('ab1/_all');
        View_View::findOne('DB_Ab1_ClientContract_Type',
            $this->_sitePageData->shopMainID, "client-contract/type/one/edit",
            $this->_sitePageData, $this->_driverDB, array('id' => $id)
        );
        $this->_sitePageData->previousShopShablonPath();

        $this->_putInMain('/main/client-contract/type/edit');
    }

    protected function _actionClientContractStatusNew()
    {
        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::client-contract/status/one/new',
            )
        );

        $dataID = new MyArray();
        $dataID->id = 0;
        $dataID->isFindDB = TRUE;

        $this->_sitePageData->newShopShablonPath('ab1/_all');
        $this->_sitePageData->replaceDatas['view::client-contract/status/one/new'] = Helpers_View::getViewObject(
            $dataID, new Model_Ab1_ClientContract_Status(),
            'client-contract/status/one/new', $this->_sitePageData, $this->_driverDB,
            $this->_sitePageData->shopMainID
        );
        $this->_sitePageData->previousShopShablonPath();

        $this->_putInMain('/main/client-contract/status/new');
    }

    protected function _actionClientContractStatusEdit()
    {
        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::client-contract/status/one/edit',
            )
        );

        // id записи
        $id = Request_RequestParams::getParamInt('id');
        $model = new Model_Ab1_ClientContract_Status();
        if (! $this->dublicateObjectLanguage($model, $id, $this->_sitePageData->shopMainID, FALSE)) {
            throw new HTTP_Exception_404('Client contract status not is found!');
        }

        // получаем данные
        $this->_sitePageData->newShopShablonPath('ab1/_all');
        View_View::findOne('DB_Ab1_ClientContract_Status',
            $this->_sitePageData->shopMainID, "client-contract/status/one/edit",
            $this->_sitePageData, $this->_driverDB, array('id' => $id)
        );
        $this->_sitePageData->previousShopShablonPath();

        $this->_putInMain('/main/client-contract/status/edit');
    }

    protected function _actionClientContractViewNew()
    {
        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::client-contract/view/one/new',
            )
        );

        $dataID = new MyArray();
        $dataID->id = 0;
        $dataID->isFindDB = TRUE;

        $this->_sitePageData->newShopShablonPath('ab1/_all');
        $this->_sitePageData->replaceDatas['view::client-contract/view/one/new'] = Helpers_View::getViewObject(
            $dataID, new Model_Ab1_ClientContract_Status(),
            'client-contract/view/one/new', $this->_sitePageData, $this->_driverDB,
            $this->_sitePageData->shopMainID
        );
        $this->_sitePageData->previousShopShablonPath();

        $this->_putInMain('/main/client-contract/view/new');
    }

    protected function _actionClientContractViewEdit()
    {
        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::client-contract/view/one/edit',
            )
        );

        // id записи
        $id = Request_RequestParams::getParamInt('id');
        $model = new Model_Ab1_ClientContract_View();
        if (! $this->dublicateObjectLanguage($model, $id, $this->_sitePageData->shopMainID, FALSE)) {
            throw new HTTP_Exception_404('Client contract view not is found!');
        }

        // получаем данные
        $this->_sitePageData->newShopShablonPath('ab1/_all');
        View_View::findOne('DB_Ab1_ClientContract_View',
            $this->_sitePageData->shopMainID, "client-contract/view/one/edit",
            $this->_sitePageData, $this->_driverDB, array('id' => $id)
        );
        $this->_sitePageData->previousShopShablonPath();

        $this->_putInMain('/main/client-contract/view/edit');
    }

    /**
     * Акт сверки клиента
     * @param $shopClientID
     * @param null $dateFrom
     * @param null $dateTo
     * @param bool $isAddVirtualInvoice
     */
    protected function _actionShopActReviseItemShopClient($shopClientID, $dateFrom = null, $dateTo = null, $isAddVirtualInvoice = false) {
        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/act/revise/item/list/client',
            )
        );

        if($dateFrom === NULL){
            $dateFrom = Helpers_DateTime::getMonthBeginStr(date('m'), date('Y'));
        }

        if($dateTo === NULL){
            $dateTo = date('Y-m-d') . ' 23:59:59';
        }else{
            $dateTo = $dateTo . ' 23:59:59';
        }

        $ids = Api_Ab1_Shop_Act_Revise::getShopActRevises(
            $shopClientID, $dateFrom, $dateTo, $this->_sitePageData, $this->_driverDB,
            $isAddVirtualInvoice
        );

        $this->_sitePageData->newShopShablonPath('ab1/_all');
        $result = Helpers_View::getViewObjects(
            $ids, new Model_Ab1_Shop_Act_Revise_Item(),
            "_shop/act/revise/item/list/client", "_shop/act/revise/item/one/client",
            $this->_sitePageData, $this->_driverDB, 0
        );
        $this->_sitePageData->replaceDatas['view::_shop/act/revise/item/list/client'] = $result;
        $this->_sitePageData->previousShopShablonPath();
    }

    protected function _actionShopActReviseItemClient() {
        $this->_actionShopActReviseItemShopClient(
            Request_RequestParams::getParamInt('shop_client_id'),
            Request_RequestParams::getParamDate('date_from'),
            Request_RequestParams::getParamDate('date_to'),
            Request_RequestParams::getParamBoolean('is_add_virtual_invoice')
        );

        $this->_putInMain('/main/_shop/act/revise/item/client');
    }

    protected function _actionShopProductStorageStatistics()
    {
        $this->_requestShopBranches(NULL, TRUE);
        $this->_requestShopStorages();

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/product/storage/list/statistics',
            )
        );

        // задаем время выборки с начала дня
        $dateFrom = date('Y-m-d').' 06:00:00';
        $listIDs = new MyArray();
        $params = Request_RequestParams::setParams(
            array(
                'weighted_at_from' => $dateFrom,
                'sum_quantity' => TRUE,
                'group_by' => array(
                    'shop_product_id', 'shop_product_id.name',
                ),
            )
        );

        $elements = array(
            'shop_product_id' => array('name'),
        );

        $resultArray = array(
            'quantity_day' => 0,
            'quantity_yesterday' => 0,
            'quantity_week' => 0,
            'quantity_month' => 0,
            'quantity_month_previous' => 0,
            'quantity_year' => 0,
        );

        $ids = Request_Request::find('DB_Ab1_Shop_Product_Storage',
            $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
            $elements
        );
        foreach ($ids->childs as $child){
            $objectID = $child->values['shop_product_id'];
            if(!key_exists($objectID, $listIDs->childs)){
                $child->additionDatas = $resultArray;
                $listIDs->childs[$objectID] = $child;
            }

            $listIDs->childs[$objectID]->additionDatas['quantity_day'] += $child->values['quantity'];
        }

        // задаем время выборки вчера
        $paramsYesterday = $params;
        $paramsYesterday['weighted_at_to'] = $dateFrom;
        $paramsYesterday['weighted_at_from'] = Helpers_DateTime::minusDays($dateFrom, 1);

        $ids = Request_Request::find('DB_Ab1_Shop_Product_Storage',
            $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB, $paramsYesterday, 0, TRUE,
            $elements
        );
        foreach ($ids->childs as $child){
            $objectID = $child->values['shop_product_id'];
            if(!key_exists($objectID, $listIDs->childs)){
                $child->additionDatas = $resultArray;
                $listIDs->childs[$objectID] = $child;
            }

            $listIDs->childs[$objectID]->additionDatas['quantity_yesterday'] += $child->values['quantity'];
        }

        // задаем время выборки с начала недели
        $dateFrom = Helpers_DateTime::getWeekBeginStr(date('Y-m-d')).' 06:00:00';
        $params['weighted_at_from'] = $dateFrom;

        $ids = Request_Request::find('DB_Ab1_Shop_Product_Storage',
            $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
            $elements
        );
        foreach ($ids->childs as $child){
            $objectID = $child->values['shop_product_id'];
            if(!key_exists($objectID, $listIDs->childs)){
                $child->additionDatas = $resultArray;
                $listIDs->childs[$objectID] = $child;
            }

            $listIDs->childs[$objectID]->additionDatas['quantity_week'] += $child->values['quantity'];
        }

        // задаем время выборки с начала месяца
        $dateFrom = Helpers_DateTime::getMonthBeginStr(date('m'), date('Y')).' 06:00:00';
        $params['weighted_at_from'] = $dateFrom;

        $ids = Request_Request::find('DB_Ab1_Shop_Product_Storage',
            $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
            $elements
        );
        foreach ($ids->childs as $child){
            $objectID = $child->values['shop_product_id'];
            if(!key_exists($objectID, $listIDs->childs)){
                $child->additionDatas = $resultArray;
                $listIDs->childs[$objectID] = $child;
            }

            $listIDs->childs[$objectID]->additionDatas['quantity_month'] += $child->values['quantity'];
        }

        // задаем время выборки с предыдущего месяца
        $paramsPreviousMonth = $params;
        $tmp = Helpers_DateTime::getMonthBeginStr(date('m'), date('Y')).' 06:00:00';
        $paramsPreviousMonth['weighted_at_to'] = $tmp;
        $paramsPreviousMonth['weighted_at_from'] = Helpers_DateTime::minusMonth($tmp, 1, true);

        $ids = Request_Request::find('DB_Ab1_Shop_Product_Storage',
            $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB, $paramsPreviousMonth, 0, TRUE,
            $elements
        );
        foreach ($ids->childs as $child){
            $objectID = $child->values['shop_product_id'];
            if(!key_exists($objectID, $listIDs->childs)){
                $child->additionDatas = $resultArray;
                $listIDs->childs[$objectID] = $child;
            }

            $listIDs->childs[$objectID]->additionDatas['quantity_month_previous'] += $child->values['quantity'];
        }

        // задаем время выборки с начала года
        $dateFrom = Helpers_DateTime::getYearBeginStr(date('Y')).' 06:00:00';
        $params['weighted_at_from'] = $dateFrom;

        $ids = Request_Request::find('DB_Ab1_Shop_Product_Storage',
            $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
            $elements
        );
        foreach ($ids->childs as $child){
            $objectID = $child->values['shop_product_id'];
            if(!key_exists($objectID, $listIDs->childs)){
                $child->additionDatas = $resultArray;
                $listIDs->childs[$objectID] = $child;
            }

            $listIDs->childs[$objectID]->additionDatas['quantity_year'] += $child->values['quantity'];
        }

        // задаем время выборки с за все время
        /* $params['weighted_at_from'] = NULL;

        $ids = Request_Request::find('DB_Ab1_Shop_Product_Storage',
            $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
            $elements
        );
        foreach ($ids->childs as $child){
            $objectID = $child->values['shop_storage_id'];
            if(!key_exists($objectID, $listIDs->childs)){
                if(!$isAll){
                    continue;
                }
                $child->additionDatas = $resultArray;
                $listIDs->childs[$objectID] = $child;
            }

            $listIDs->childs[$objectID]->additionDatas['quantity'] += $child->values['quantity'];
        }*/

        // итог
        $listIDs->additionDatas = $listIDs->calcTotalsChild(
            array(
                'quantity_day',
                'quantity_yesterday',
                'quantity_week',
                'quantity_month',
                'quantity_month_previous',
                'quantity_year',
            ),
            true
        );

        $listIDs->childsSortBy(
            array(
                Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_product_id.name',
            )
        );

        $this->_sitePageData->countRecord = count($listIDs->childs);

        $this->_sitePageData->newShopShablonPath('ab1/_all');
        $this->_sitePageData->replaceDatas['view::_shop/product/storage/list/statistics'] = Helpers_View::getViewObjects(
            $listIDs, new Model_Ab1_Shop_Product_Rubric(),
            '_shop/product/storage/list/statistics','_shop/product/storage/one/statistics',
            $this->_sitePageData, $this->_driverDB
        );
        $this->_sitePageData->previousShopShablonPath();

        $this->_putInMain('/main/_shop/product/storage/statistics');
    }

    protected function _actionShopTransportCompanyStatistics()
    {
        $shopIDs = array();
        if(Request_RequestParams::getParamInt('shop_branch_id') != -1){
            $shopIDs[] = $this->_sitePageData->shopID;
        }

        $this->_requestShopBranches(NULL, TRUE);

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/transport/company/list/statistics',
            )
        );

        // задаем время выборки с начала дня
        $dateFrom = date('Y-m-d').' 06:00:00';
        $listIDs = new MyArray();
        $params = Request_RequestParams::setParams(
            array(
                'is_exit' => 1,
                'exit_at_from' => $dateFrom,
                'sum_delivery_quantity' => TRUE,
                'sum_delivery_amount' => TRUE,
                'is_charity' => FALSE,
                'shop_delivery_id_from' => 0,
                'shop_client_id' => Request_RequestParams::getParamInt('shop_client_id'),
                'shop_transport_company_id-is_own' => Request_RequestParams::getParamBoolean('shop_transport_company_id-is_own'),
                'group_by' => array(
                    'shop_transport_company_id',
                    'shop_transport_company_id.is_own',
                    'shop_transport_company_id.name',
                ),
            )
        );

        $elements = array(
            'shop_transport_company_id' => array('is_own', 'name'),
        );

        $resultArray = array(
            'quantity_day' => 0,
            'quantity_yesterday' => 0,
            'quantity_week' => 0,
            'quantity_month' => 0,
            'quantity_month_previous' => 0,
            'quantity_year' => 0,
            'amount_day' => 0,
            'amount_yesterday' => 0,
            'amount_week' => 0,
            'amount_month' => 0,
            'amount_month_previous' => 0,
            'amount_year' => 0,
        );

        $ids = Request_Request::findBranch('DB_Ab1_Shop_Car',
            $shopIDs, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
            $elements
        );
        $ids->addChilds(
            Request_Request::findBranch('DB_Ab1_Shop_Piece',
                $shopIDs, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
                $elements
            )
        );
        foreach ($ids->childs as $child){
            $shopClientID = $child->values['shop_transport_company_id'];
            if(!key_exists($shopClientID, $listIDs->childs)){
                $child->additionDatas = $resultArray;
                $listIDs->childs[$shopClientID] = $child;
            }

            $listIDs->childs[$shopClientID]->additionDatas['quantity_day'] += $child->values['delivery_quantity'];
            $listIDs->childs[$shopClientID]->additionDatas['amount_day'] += $child->values['delivery_amount'];
        }

        // задаем время выборки вчера
        $paramsYesterday = $params;
        $paramsYesterday['exit_at_to'] = $dateFrom;
        $paramsYesterday['exit_at_from'] = Helpers_DateTime::minusDays($dateFrom, 1);

        $ids = Request_Request::findBranch('DB_Ab1_Shop_Car',
            $shopIDs, $this->_sitePageData, $this->_driverDB, $paramsYesterday, 0, TRUE,
            $elements
        );
        $ids->addChilds(
            Request_Request::findBranch('DB_Ab1_Shop_Piece',
                $shopIDs, $this->_sitePageData, $this->_driverDB, $paramsYesterday, 0, TRUE,
                $elements
            )
        );
        foreach ($ids->childs as $child){
            $shopClientID = $child->values['shop_transport_company_id'];
            if(!key_exists($shopClientID, $listIDs->childs)){
                $child->additionDatas = $resultArray;
                $listIDs->childs[$shopClientID] = $child;
            }

            $listIDs->childs[$shopClientID]->additionDatas['quantity_yesterday'] += $child->values['delivery_quantity'];
            $listIDs->childs[$shopClientID]->additionDatas['amount_yesterday'] += $child->values['delivery_amount'];
        }

        // задаем время выборки с начала недели
        $dateFrom = Helpers_DateTime::getWeekBeginStr(date('Y-m-d')).' 06:00:00';
        $params['exit_at_from'] = $dateFrom;

        $ids = Request_Request::findBranch('DB_Ab1_Shop_Car',
            $shopIDs, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
            $elements
        );
        $ids->addChilds(
            Request_Request::findBranch('DB_Ab1_Shop_Piece',
                $shopIDs, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
                $elements
            )
        );
        foreach ($ids->childs as $child){
            $shopClientID = $child->values['shop_transport_company_id'];
            if(!key_exists($shopClientID, $listIDs->childs)){
                $child->additionDatas = $resultArray;
                $listIDs->childs[$shopClientID] = $child;
            }

            $listIDs->childs[$shopClientID]->additionDatas['quantity_week'] += $child->values['delivery_quantity'];
            $listIDs->childs[$shopClientID]->additionDatas['amount_week'] += $child->values['delivery_amount'];
        }

        // задаем время выборки с начала месяца
        $dateFrom = Helpers_DateTime::getMonthBeginStr(date('m'), date('Y')).' 06:00:00';
        $params['exit_at_from'] = $dateFrom;

        $ids = Request_Request::findBranch('DB_Ab1_Shop_Car',
            $shopIDs, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
            $elements
        );
        $ids->addChilds(
            Request_Request::findBranch('DB_Ab1_Shop_Piece',
                $shopIDs, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
                $elements
            )
        );
        foreach ($ids->childs as $child){
            $shopClientID = $child->values['shop_transport_company_id'];
            if(!key_exists($shopClientID, $listIDs->childs)){
                $child->additionDatas = $resultArray;
                $listIDs->childs[$shopClientID] = $child;
            }

            $listIDs->childs[$shopClientID]->additionDatas['quantity_month'] += $child->values['delivery_quantity'];
            $listIDs->childs[$shopClientID]->additionDatas['amount_month'] += $child->values['delivery_amount'];
        }

        // задаем время выборки с предыдущего месяца
        $paramsPreviousMonth = $params;
        $tmp = Helpers_DateTime::getMonthBeginStr(date('m'), date('Y')).' 06:00:00';
        $paramsPreviousMonth['exit_at_to'] = $tmp;
        $paramsPreviousMonth['exit_at_from'] = Helpers_DateTime::minusMonth($tmp, 1, true);

        $ids = Request_Request::findBranch('DB_Ab1_Shop_Car',
            $shopIDs, $this->_sitePageData, $this->_driverDB, $paramsPreviousMonth, 0, TRUE,
            $elements
        );
        $ids->addChilds(
            Request_Request::findBranch('DB_Ab1_Shop_Piece',
                $shopIDs, $this->_sitePageData, $this->_driverDB, $paramsPreviousMonth, 0, TRUE,
                $elements
            )
        );
        foreach ($ids->childs as $child){
            $shopClientID = $child->values['shop_transport_company_id'];
            if(!key_exists($shopClientID, $listIDs->childs)){
                $child->additionDatas = $resultArray;
                $listIDs->childs[$shopClientID] = $child;
            }

            $listIDs->childs[$shopClientID]->additionDatas['quantity_month_previous'] += $child->values['delivery_quantity'];
            $listIDs->childs[$shopClientID]->additionDatas['amount_month_previous'] += $child->values['delivery_amount'];
        }

        // задаем время выборки с начала года
        $dateFrom = Helpers_DateTime::getYearBeginStr(date('Y')).' 06:00:00';
        $params['exit_at_from'] = $dateFrom;

        $ids = Request_Request::findBranch('DB_Ab1_Shop_Car',
            $shopIDs, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
            $elements
        );
        $ids->addChilds(
            Request_Request::findBranch('DB_Ab1_Shop_Piece',
                $shopIDs, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
                $elements
            )
        );
        foreach ($ids->childs as $child){
            $shopClientID = $child->values['shop_transport_company_id'];
            if(!key_exists($shopClientID, $listIDs->childs)){
                $child->additionDatas = $resultArray;
                $listIDs->childs[$shopClientID] = $child;
            }

            $listIDs->childs[$shopClientID]->additionDatas['quantity_year'] += $child->values['delivery_quantity'];
            $listIDs->childs[$shopClientID]->additionDatas['amount_year'] += $child->values['delivery_amount'];
        }

        // задаем время выборки с за все время
        /* $params['exit_at_from'] = NULL;

        $ids = Request_Request::findBranch('DB_Ab1_Shop_Car',
            $shopIDs, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
            $elements
        );
        $ids->addChilds(
            Request_Request::findBranch('DB_Ab1_Shop_Piece',
                $shopIDs, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
                $elements
            )
        );
        foreach ($ids->childs as $child){
            $shopClientID = $child->values['shop_transport_company_id'];
            if(!key_exists($shopClientID, $listIDs->childs)){
                if(!$isAll){
                    continue;
                }
                $child->additionDatas = $resultArray;
                $listIDs->childs[$shopClientID] = $child;
            }

            $listIDs->childs[$shopClientID]->additionDatas['quantity'] += $child->values['delivery_quantity'];
            $listIDs->childs[$shopClientID]->additionDatas['amount'] += $child->values['delivery_amount'];
        }*/

        // итог
        $listIDs->additionDatas = $listIDs->calcTotalsChild(
            array(
                'quantity_day',
                'quantity_yesterday',
                'quantity_week',
                'quantity_month',
                'quantity_month_previous',
                'quantity_year',

                'amount_day',
                'amount_yesterday',
                'amount_week',
                'amount_month',
                'amount_month_previous',
                'amount_year',
            ),
            true
        );

        $listIDs->childsSortBy(
            array(
                'amount_year',
            ),
            false
        );

        $this->_sitePageData->countRecord = count($listIDs->childs);

        $this->_sitePageData->newShopShablonPath('ab1/_all');
        $this->_sitePageData->replaceDatas['view::_shop/transport/company/list/statistics'] = Helpers_View::getViewObjects(
            $listIDs, new Model_Ab1_Shop_Product_Rubric(),
            '_shop/transport/company/list/statistics','_shop/transport/company/one/statistics',
            $this->_sitePageData, $this->_driverDB
        );
        $this->_sitePageData->previousShopShablonPath();

        $this->_putInMain('/main/_shop/transport/company/statistics');
    }

    protected function _actionShopDeliveryListStatistics()
    {
        $shopIDs = array();
        if(Request_RequestParams::getParamInt('shop_branch_id') != -1){
            $shopIDs[] = $this->_sitePageData->shopID;
        }

        $this->_requestShopProductRubrics();
        $this->_requestShopBranches(NULL, TRUE);

        $shopDeliveryProductRubricID = Request_RequestParams::getParamInt('shop_delivery_product_rubric_id');

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/delivery/list/statistics/delivery',
            )
        );

        // задаем время выборки с начала дня
        $dateFrom = date('Y-m-d').' 06:00:00';
        $listIDs = new MyArray();
        $params = Request_RequestParams::setParams(
            array(
                'is_exit' => 1,
                'exit_at_from' => $dateFrom,
                'sum_delivery_quantity' => TRUE,
                'sum_delivery_amount' => TRUE,
                'is_charity' => FALSE,
                'shop_delivery_id_from' => 0,
                'shop_client_id' => Request_RequestParams::getParamInt('shop_client_id'),
                'shop_transport_company_id-is_own' => Request_RequestParams::getParamBoolean('shop_transport_company_id-is_own'),
                'group_by' => array(
                    'shop_delivery_id', 'shop_delivery_id.name',
                    'shop_transport_company_id.is_own',
                    'shop_delivery_product_rubric_id.id',
                ),
            )
        );

        $elements = array(
            'shop_delivery_id' => array('name'),
            'shop_transport_company_id' => array('is_own'),
            'shop_delivery_product_rubric_id' => array('id'),
        );

        $resultArray = array(
            'quantity_day' => 0,
            'quantity_yesterday' => 0,
            'quantity_week' => 0,
            'quantity_month' => 0,
            'quantity_month_previous' => 0,
            'quantity_year' => 0,

            'amount_day' => 0,
            'amount_yesterday' => 0,
            'amount_week' => 0,
            'amount_month' => 0,
            'amount_month_previous' => 0,
            'amount_year' => 0,
        );

        $ids = Request_Request::findBranch('DB_Ab1_Shop_Car',
            $shopIDs, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
            $elements
        );
        $ids->addChilds(
            Request_Request::findBranch('DB_Ab1_Shop_Piece',
                $shopIDs, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
                $elements
            )
        );
        foreach ($ids->childs as $child){
            if($shopDeliveryProductRubricID != $child->getElementValue('shop_delivery_product_rubric_id', 'id')){
                continue;
            }

            $shopClientID = $child->values['shop_delivery_id'];
            if(!key_exists($shopClientID, $listIDs->childs)){
                $child->additionDatas = $resultArray;
                $listIDs->childs[$shopClientID] = $child;
            }

            $listIDs->childs[$shopClientID]->additionDatas['quantity_day'] += $child->values['delivery_quantity'];
            $listIDs->childs[$shopClientID]->additionDatas['amount_day'] += $child->values['delivery_amount'];
        }

        // задаем время выборки вчера
        $paramsYesterday = $params;
        $paramsYesterday['exit_at_to'] = $dateFrom;
        $paramsYesterday['exit_at_from'] = Helpers_DateTime::minusDays($dateFrom, 1);

        $ids = Request_Request::findBranch('DB_Ab1_Shop_Car',
            $shopIDs, $this->_sitePageData, $this->_driverDB, $paramsYesterday, 0, TRUE,
            $elements
        );
        $ids->addChilds(
            Request_Request::findBranch('DB_Ab1_Shop_Piece',
                $shopIDs, $this->_sitePageData, $this->_driverDB, $paramsYesterday, 0, TRUE,
                $elements
            )
        );
        foreach ($ids->childs as $child){
            if(($shopDeliveryProductRubricID > 0 && $shopDeliveryProductRubricID != $child->getElementValue('shop_delivery_product_rubric_id', 'id'))){
                continue;
            }

            $shopClientID = $child->values['shop_delivery_id'];
            if(!key_exists($shopClientID, $listIDs->childs)){
                $child->additionDatas = $resultArray;
                $listIDs->childs[$shopClientID] = $child;
            }

            $listIDs->childs[$shopClientID]->additionDatas['quantity_yesterday'] += $child->values['delivery_quantity'];
            $listIDs->childs[$shopClientID]->additionDatas['amount_yesterday'] += $child->values['delivery_amount'];
        }

        // задаем время выборки с начала недели
        $dateFrom = Helpers_DateTime::getWeekBeginStr(date('Y-m-d')).' 06:00:00';
        $params['exit_at_from'] = $dateFrom;

        $ids = Request_Request::findBranch('DB_Ab1_Shop_Car',
            $shopIDs, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
            $elements
        );
        $ids->addChilds(
            Request_Request::findBranch('DB_Ab1_Shop_Piece',
                $shopIDs, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
                $elements
            )
        );
        foreach ($ids->childs as $child){
            if(($shopDeliveryProductRubricID > 0 && $shopDeliveryProductRubricID != $child->getElementValue('shop_delivery_product_rubric_id', 'id'))){
                continue;
            }

            $shopClientID = $child->values['shop_delivery_id'];
            if(!key_exists($shopClientID, $listIDs->childs)){
                $child->additionDatas = $resultArray;
                $listIDs->childs[$shopClientID] = $child;
            }

            $listIDs->childs[$shopClientID]->additionDatas['quantity_week'] += $child->values['delivery_quantity'];
            $listIDs->childs[$shopClientID]->additionDatas['amount_week'] += $child->values['delivery_amount'];
        }

        // задаем время выборки с начала месяца
        $dateFrom = Helpers_DateTime::getMonthBeginStr(date('m'), date('Y')).' 06:00:00';
        $params['exit_at_from'] = $dateFrom;

        $ids = Request_Request::findBranch('DB_Ab1_Shop_Car',
            $shopIDs, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
            $elements
        );
        $ids->addChilds(
            Request_Request::findBranch('DB_Ab1_Shop_Piece',
                $shopIDs, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
                $elements
            )
        );
        foreach ($ids->childs as $child){
            if(($shopDeliveryProductRubricID > 0 && $shopDeliveryProductRubricID != $child->getElementValue('shop_delivery_product_rubric_id', 'id'))){
                continue;
            }

            $shopClientID = $child->values['shop_delivery_id'];
            if(!key_exists($shopClientID, $listIDs->childs)){
                $child->additionDatas = $resultArray;
                $listIDs->childs[$shopClientID] = $child;
            }

            $listIDs->childs[$shopClientID]->additionDatas['quantity_month'] += $child->values['delivery_quantity'];
            $listIDs->childs[$shopClientID]->additionDatas['amount_month'] += $child->values['delivery_amount'];
        }

        // задаем время выборки с предыдущего месяца
        $paramsPreviousMonth = $params;
        $tmp = Helpers_DateTime::getMonthBeginStr(date('m'), date('Y')).' 06:00:00';
        $paramsPreviousMonth['exit_at_to'] = $tmp;
        $paramsPreviousMonth['exit_at_from'] = Helpers_DateTime::minusMonth($tmp, 1, true);

        $ids = Request_Request::findBranch('DB_Ab1_Shop_Car',
            $shopIDs, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
            $elements
        );
        $ids->addChilds(
            Request_Request::findBranch('DB_Ab1_Shop_Piece',
                $shopIDs, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
                $elements
            )
        );
        foreach ($ids->childs as $child){
            if(($shopDeliveryProductRubricID > 0 && $shopDeliveryProductRubricID != $child->getElementValue('shop_delivery_product_rubric_id', 'id'))){
                continue;
            }

            $shopClientID = $child->values['shop_delivery_id'];
            if(!key_exists($shopClientID, $listIDs->childs)){
                $child->additionDatas = $resultArray;
                $listIDs->childs[$shopClientID] = $child;
            }

            $listIDs->childs[$shopClientID]->additionDatas['quantity_month_previous'] += $child->values['delivery_quantity'];
            $listIDs->childs[$shopClientID]->additionDatas['amount_month_previous'] += $child->values['delivery_amount'];
        }

        // задаем время выборки с начала года
        $dateFrom = Helpers_DateTime::getYearBeginStr(date('Y')).' 06:00:00';
        $params['exit_at_from'] = $dateFrom;

        $ids = Request_Request::findBranch('DB_Ab1_Shop_Car',
            $shopIDs, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
            $elements
        );
        $ids->addChilds(
            Request_Request::findBranch('DB_Ab1_Shop_Piece',
                $shopIDs, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
                $elements
            )
        );
        foreach ($ids->childs as $child){
            if(($shopDeliveryProductRubricID > 0 && $shopDeliveryProductRubricID != $child->getElementValue('shop_delivery_product_rubric_id', 'id'))){
                continue;
            }

            $shopClientID = $child->values['shop_delivery_id'];
            if(!key_exists($shopClientID, $listIDs->childs)){
                $child->additionDatas = $resultArray;
                $listIDs->childs[$shopClientID] = $child;
            }

            $listIDs->childs[$shopClientID]->additionDatas['quantity_year'] += $child->values['delivery_quantity'];
            $listIDs->childs[$shopClientID]->additionDatas['amount_year'] += $child->values['delivery_amount'];
        }

        // задаем время выборки с за все время
        /* $params['exit_at_from'] = NULL;

        $ids = Request_Request::findBranch('DB_Ab1_Shop_Car',
            $shopIDs, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
            $elements
        );
        $ids->addChilds(
            Request_Request::findBranch('DB_Ab1_Shop_Piece',
                $shopIDs, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
                $elements
            )
        );
        foreach ($ids->childs as $child){
            if(($shopDeliveryProductRubricID > 0 && $shopDeliveryProductRubricID != $child->getElementValue('shop_delivery_product_rubric_id', 'id'))){
                continue;
            }

            $shopClientID = $child->values['shop_delivery_id'];
            if(!key_exists($shopClientID, $listIDs->childs)){
                if(!$isAll){
                    continue;
                }
                $child->additionDatas = $resultArray;
                $listIDs->childs[$shopClientID] = $child;
            }

            $listIDs->childs[$shopClientID]->additionDatas['quantity'] += $child->values['delivery_quantity'];
            $listIDs->childs[$shopClientID]->additionDatas['amount'] += $child->values['delivery_amount'];
        }*/

        // итог
        $listIDs->additionDatas = $listIDs->calcTotalsChild(
            array(
                'quantity_day',
                'quantity_yesterday',
                'quantity_week',
                'quantity_month',
                'quantity_month_previous',
                'quantity_year',

                'amount_day',
                'amount_yesterday',
                'amount_week',
                'amount_month',
                'amount_month_previous',
                'amount_year',
            ),
            true
        );

        $listIDs->childsSortBy(
            Request_RequestParams::getParamArray(
                'sort_by', array(),
                array(
                    'amount_year' => 'desc',
                    'amount_yesterday' => 'desc',
                    'amount_week' => 'desc',
                    'amount_month' => 'desc',
                    'amount_month_previous' => 'desc',
                    'amount_day' => 'desc',
                )
            ),
            true, true
        );

        $this->_sitePageData->countRecord = count($listIDs->childs);

        $this->_sitePageData->newShopShablonPath('ab1/_all');
        $this->_sitePageData->replaceDatas['view::_shop/delivery/list/statistics/delivery'] = Helpers_View::getViewObjects(
            $listIDs, new Model_Ab1_Shop_Product_Rubric(),
            '_shop/delivery/list/statistics/delivery','_shop/delivery/one/statistics/delivery',
            $this->_sitePageData, $this->_driverDB
        );
        $this->_sitePageData->previousShopShablonPath();

        $this->_putInMain('/main/_shop/delivery/list-statistics');
    }

    protected function _deliveryRubricStatistics(array $shopIDs)
    {
        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/delivery/list/statistics/rubric',
            )
        );

        // задаем время выборки с начала дня
        $dateFrom = date('Y-m-d').' 06:00:00';
        $listIDs = new MyArray();
        $params = Request_RequestParams::setParams(
            array(
                'is_exit' => 1,
                'exit_at_from' => $dateFrom,
                'sum_delivery_quantity' => TRUE,
                'sum_delivery_amount' => TRUE,
                'is_charity' => FALSE,
                'shop_delivery_id_from' => 0,
                'shop_transport_company_id-is_own' => Request_RequestParams::getParamBoolean('shop_transport_company_id-is_own'),
                'group_by' => array(
                    'shop_delivery_product_rubric_id.name', 'shop_delivery_product_rubric_id.id',
                    'shop_transport_company_id.is_own',
                ),
            )
        );

        $elements = array(
            'shop_delivery_product_rubric_id' => array('name', 'id'),
            'shop_transport_company_id' => array('is_own'),
        );

        $resultArray = array(
            'quantity_day' => 0,
            'quantity_yesterday' => 0,
            'quantity_week' => 0,
            'quantity_month' => 0,
            'quantity_month_previous' => 0,
            'quantity_year' => 0,

            'amount_day' => 0,
            'amount_yesterday' => 0,
            'amount_week' => 0,
            'amount_month' => 0,
            'amount_month_previous' => 0,
            'amount_year' => 0,
        );

        $ids = Request_Request::findBranch('DB_Ab1_Shop_Car',
            $shopIDs, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
            $elements
        );
        $ids->addChilds(
            Request_Request::findBranch('DB_Ab1_Shop_Piece',
                $shopIDs, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
                $elements
            )
        );
        foreach ($ids->childs as $child){
            $shopClientID = $child->getElementValue('shop_delivery_product_rubric_id');
            if(!key_exists($shopClientID, $listIDs->childs)){
                $child->additionDatas = $resultArray;
                $listIDs->childs[$shopClientID] = $child;
            }

            $listIDs->childs[$shopClientID]->additionDatas['quantity_day'] += $child->values['delivery_quantity'];
            $listIDs->childs[$shopClientID]->additionDatas['amount_day'] += $child->values['delivery_amount'];
        }

        // задаем время выборки вчера
        $paramsYesterday = $params;
        $paramsYesterday['exit_at_to'] = $dateFrom;
        $paramsYesterday['exit_at_from'] = Helpers_DateTime::minusDays($dateFrom, 1);

        $ids = Request_Request::findBranch('DB_Ab1_Shop_Car',
            $shopIDs, $this->_sitePageData, $this->_driverDB, $paramsYesterday, 0, TRUE,
            $elements
        );
        $ids->addChilds(
            Request_Request::findBranch('DB_Ab1_Shop_Piece',
                $shopIDs, $this->_sitePageData, $this->_driverDB, $paramsYesterday, 0, TRUE,
                $elements
            )
        );
        foreach ($ids->childs as $child){
            $shopClientID = $child->getElementValue('shop_delivery_product_rubric_id');
            if(!key_exists($shopClientID, $listIDs->childs)){
                $child->additionDatas = $resultArray;
                $listIDs->childs[$shopClientID] = $child;
            }

            $listIDs->childs[$shopClientID]->additionDatas['quantity_yesterday'] += $child->values['delivery_quantity'];
            $listIDs->childs[$shopClientID]->additionDatas['amount_yesterday'] += $child->values['delivery_amount'];
        }

        // задаем время выборки с начала недели
        $dateFrom = Helpers_DateTime::getWeekBeginStr(date('Y-m-d')).' 06:00:00';
        $params['exit_at_from'] = $dateFrom;

        $ids = Request_Request::findBranch('DB_Ab1_Shop_Car',
            $shopIDs, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
            $elements
        );
        $ids->addChilds(
            Request_Request::findBranch('DB_Ab1_Shop_Piece',
                $shopIDs, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
                $elements
            )
        );
        foreach ($ids->childs as $child){
            $shopClientID = $child->getElementValue('shop_delivery_product_rubric_id');
            if(!key_exists($shopClientID, $listIDs->childs)){
                $child->additionDatas = $resultArray;
                $listIDs->childs[$shopClientID] = $child;
            }

            $listIDs->childs[$shopClientID]->additionDatas['quantity_week'] += $child->values['delivery_quantity'];
            $listIDs->childs[$shopClientID]->additionDatas['amount_week'] += $child->values['delivery_amount'];
        }

        // задаем время выборки с начала месяца
        $dateFrom = Helpers_DateTime::getMonthBeginStr(date('m'), date('Y')).' 06:00:00';
        $params['exit_at_from'] = $dateFrom;

        $ids = Request_Request::findBranch('DB_Ab1_Shop_Car',
            $shopIDs, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
            $elements
        );
        $ids->addChilds(
            Request_Request::findBranch('DB_Ab1_Shop_Piece',
                $shopIDs, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
                $elements
            )
        );
        foreach ($ids->childs as $child){
            $shopClientID = $child->getElementValue('shop_delivery_product_rubric_id');
            if(!key_exists($shopClientID, $listIDs->childs)){
                $child->additionDatas = $resultArray;
                $listIDs->childs[$shopClientID] = $child;
            }

            $listIDs->childs[$shopClientID]->additionDatas['quantity_month'] += $child->values['delivery_quantity'];
            $listIDs->childs[$shopClientID]->additionDatas['amount_month'] += $child->values['delivery_amount'];
        }

        // задаем время выборки с предыдущего месяца
        $paramsPreviousMonth = $params;
        $tmp = Helpers_DateTime::getMonthBeginStr(date('m'), date('Y')).' 06:00:00';
        $paramsPreviousMonth['exit_at_to'] = $tmp;
        $paramsPreviousMonth['exit_at_from'] = Helpers_DateTime::minusMonth($tmp, 1, true);

        $ids = Request_Request::findBranch('DB_Ab1_Shop_Car',
            $shopIDs, $this->_sitePageData, $this->_driverDB, $paramsPreviousMonth, 0, TRUE,
            $elements
        );
        $ids->addChilds(
            Request_Request::findBranch('DB_Ab1_Shop_Piece',
                $shopIDs, $this->_sitePageData, $this->_driverDB, $paramsPreviousMonth, 0, TRUE,
                $elements
            )
        );
        foreach ($ids->childs as $child){
            $shopClientID = $child->getElementValue('shop_delivery_product_rubric_id');
            if(!key_exists($shopClientID, $listIDs->childs)){
                $child->additionDatas = $resultArray;
                $listIDs->childs[$shopClientID] = $child;
            }

            $listIDs->childs[$shopClientID]->additionDatas['quantity_month_previous'] += $child->values['delivery_quantity'];
            $listIDs->childs[$shopClientID]->additionDatas['amount_month_previous'] += $child->values['delivery_amount'];
        }

        // задаем время выборки с начала года
        $dateFrom = Helpers_DateTime::getYearBeginStr(date('Y')).' 06:00:00';
        $params['exit_at_from'] = $dateFrom;

        $ids = Request_Request::findBranch('DB_Ab1_Shop_Car',
            $shopIDs, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
            $elements
        );
        $ids->addChilds(
            Request_Request::findBranch('DB_Ab1_Shop_Piece',
                $shopIDs, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
                $elements
            )
        );
        foreach ($ids->childs as $child){
            $shopClientID = $child->getElementValue('shop_delivery_product_rubric_id');
            if(!key_exists($shopClientID, $listIDs->childs)){
                $child->additionDatas = $resultArray;
                $listIDs->childs[$shopClientID] = $child;
            }

            $listIDs->childs[$shopClientID]->additionDatas['quantity_year'] += $child->values['delivery_quantity'];
            $listIDs->childs[$shopClientID]->additionDatas['amount_year'] += $child->values['delivery_amount'];
        }

        // задаем время выборки с за все время
        /* $params['exit_at_from'] = NULL;

        $ids = Request_Request::findBranch('DB_Ab1_Shop_Car',
            $shopIDs, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
            $elements
        );
        $ids->addChilds(
            Request_Request::findBranch('DB_Ab1_Shop_Piece',
                $shopIDs, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
                $elements
            )
        );
        foreach ($ids->childs as $child){
            $shopClientID = $child->getElementValue('shop_delivery_product_rubric_id');
            if(!key_exists($shopClientID, $listIDs->childs)){
                if(!$isAll){
                    continue;
                }
                $child->additionDatas = $resultArray;
                $listIDs->childs[$shopClientID] = $child;
            }

            $listIDs->childs[$shopClientID]->additionDatas['quantity'] += $child->values['delivery_quantity'];
            $listIDs->childs[$shopClientID]->additionDatas['amount'] += $child->values['delivery_amount'];
        }*/

        // итог
        $listIDs->additionDatas = $listIDs->calcTotalsChild(
            array(
                'quantity_day',
                'quantity_yesterday',
                'quantity_week',
                'quantity_month',
                'quantity_month_previous',
                'quantity_year',

                'amount_day',
                'amount_yesterday',
                'amount_week',
                'amount_month',
                'amount_month_previous',
                'amount_year',
            ),
            true
        );

        $listIDs->childsSortBy(
            array(
                Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_storage_id.name',
            )
        );

        $this->_sitePageData->countRecord = count($listIDs->childs);

        $this->_sitePageData->newShopShablonPath('ab1/_all');
        $this->_sitePageData->replaceDatas['view::_shop/delivery/list/statistics/rubric'] = Helpers_View::getViewObjects(
            $listIDs, new Model_Ab1_Shop_Product_Rubric(),
            '_shop/delivery/list/statistics/rubric','_shop/delivery/one/statistics/rubric',
            $this->_sitePageData, $this->_driverDB
        );
        $this->_sitePageData->previousShopShablonPath();

        return $listIDs;
    }

    protected function _deliveryCompanyStatistics(array $shopIDs)
    {
        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/delivery/list/statistics/company',
            )
        );

        // задаем время выборки с начала дня
        $dateFrom = date('Y-m-d').' 06:00:00';
        $listIDs = new MyArray();
        $params = Request_RequestParams::setParams(
            array(
                'shop_transport_company_id-is_own' => Request_RequestParams::getParamBoolean('shop_transport_company_id-is_own'),
                'is_exit' => 1,
                'exit_at_from' => $dateFrom,
                'sum_delivery_quantity' => TRUE,
                'sum_delivery_amount' => TRUE,
                'delivery_quantity_from' => 0,
                'is_charity' => FALSE,
                'shop_delivery_id_from' => 0,
                'group_by' => array(
                    'shop_transport_company_id.is_own',
                ),
            )
        );

        $elements = array(
            'shop_transport_company_id' => array('is_own'),
        );

        $resultArray = array(
            'quantity_day' => 0,
            'quantity_yesterday' => 0,
            'quantity_week' => 0,
            'quantity_month' => 0,
            'quantity_month_previous' => 0,
            'quantity_year' => 0,

            'amount_day' => 0,
            'amount_yesterday' => 0,
            'amount_week' => 0,
            'amount_month' => 0,
            'amount_month_previous' => 0,
            'amount_year' => 0,
        );

        $ids = Request_Request::findBranch('DB_Ab1_Shop_Car',
            $shopIDs, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
            $elements
        );
        $ids->addChilds(
            Request_Request::findBranch('DB_Ab1_Shop_Piece',
                $shopIDs, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
                $elements
            )
        );
        foreach ($ids->childs as $child){
            $shopClientID = $child->getElementValue('shop_transport_company_id', 'is_own', 3);
            if(!key_exists($shopClientID, $listIDs->childs)){
                $child->additionDatas = $resultArray;
                $listIDs->childs[$shopClientID] = $child;
            }

            $listIDs->childs[$shopClientID]->additionDatas['quantity_day'] += $child->values['delivery_quantity'];
            $listIDs->childs[$shopClientID]->additionDatas['amount_day'] += $child->values['delivery_amount'];
        }

        // задаем время выборки вчера
        $paramsYesterday = $params;
        $paramsYesterday['exit_at_to'] = $dateFrom;
        $paramsYesterday['exit_at_from'] = Helpers_DateTime::minusDays($dateFrom, 1);

        $ids = Request_Request::findBranch('DB_Ab1_Shop_Car',
            $shopIDs, $this->_sitePageData, $this->_driverDB, $paramsYesterday, 0, TRUE,
            $elements
        );
        $ids->addChilds(
            Request_Request::findBranch('DB_Ab1_Shop_Piece',
                $shopIDs, $this->_sitePageData, $this->_driverDB, $paramsYesterday, 0, TRUE,
                $elements
            )
        );
        foreach ($ids->childs as $child){
            $shopClientID = $child->getElementValue('shop_transport_company_id', 'is_own', 3);
            if(!key_exists($shopClientID, $listIDs->childs)){
                $child->additionDatas = $resultArray;
                $listIDs->childs[$shopClientID] = $child;
            }

            $listIDs->childs[$shopClientID]->additionDatas['quantity_yesterday'] += $child->values['delivery_quantity'];
            $listIDs->childs[$shopClientID]->additionDatas['amount_yesterday'] += $child->values['delivery_amount'];
        }

        // задаем время выборки с начала недели
        $dateFrom = Helpers_DateTime::getWeekBeginStr(date('Y-m-d')).' 06:00:00';
        $params['exit_at_from'] = $dateFrom;

        $ids = Request_Request::findBranch('DB_Ab1_Shop_Car',
            $shopIDs, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
            $elements
        );
        $ids->addChilds(
            Request_Request::findBranch('DB_Ab1_Shop_Piece',
                $shopIDs, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
                $elements
            )
        );
        foreach ($ids->childs as $child){
            $shopClientID = $child->getElementValue('shop_transport_company_id', 'is_own', 3);
            if(!key_exists($shopClientID, $listIDs->childs)){
                $child->additionDatas = $resultArray;
                $listIDs->childs[$shopClientID] = $child;
            }

            $listIDs->childs[$shopClientID]->additionDatas['quantity_week'] += $child->values['delivery_quantity'];
            $listIDs->childs[$shopClientID]->additionDatas['amount_week'] += $child->values['delivery_amount'];
        }

        // задаем время выборки с начала месяца
        $dateFrom = Helpers_DateTime::getMonthBeginStr(date('m'), date('Y')).' 06:00:00';
        $params['exit_at_from'] = $dateFrom;

        $ids = Request_Request::findBranch('DB_Ab1_Shop_Car',
            $shopIDs, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
            $elements
        );
        $ids->addChilds(
            Request_Request::findBranch('DB_Ab1_Shop_Piece',
                $shopIDs, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
                $elements
            )
        );
        foreach ($ids->childs as $child){
            $shopClientID = $child->getElementValue('shop_transport_company_id', 'is_own', 3);
            if(!key_exists($shopClientID, $listIDs->childs)){
                $child->additionDatas = $resultArray;
                $listIDs->childs[$shopClientID] = $child;
            }

            $listIDs->childs[$shopClientID]->additionDatas['quantity_month'] += $child->values['delivery_quantity'];
            $listIDs->childs[$shopClientID]->additionDatas['amount_month'] += $child->values['delivery_amount'];
        }

        // задаем время выборки с предыдущего месяца
        $paramsPreviousMonth = $params;
        $tmp = Helpers_DateTime::getMonthBeginStr(date('m'), date('Y')).' 06:00:00';
        $paramsPreviousMonth['exit_at_to'] = $tmp;
        $paramsPreviousMonth['exit_at_from'] = Helpers_DateTime::minusMonth($tmp, 1, true);

        $ids = Request_Request::findBranch('DB_Ab1_Shop_Car',
            $shopIDs, $this->_sitePageData, $this->_driverDB, $paramsPreviousMonth, 0, TRUE,
            $elements
        );
        $ids->addChilds(
            Request_Request::findBranch('DB_Ab1_Shop_Piece',
                $shopIDs, $this->_sitePageData, $this->_driverDB, $paramsPreviousMonth, 0, TRUE,
                $elements
            )
        );
        foreach ($ids->childs as $child){
            $shopClientID = $child->getElementValue('shop_transport_company_id', 'is_own', 3);
            if(!key_exists($shopClientID, $listIDs->childs)){
                $child->additionDatas = $resultArray;
                $listIDs->childs[$shopClientID] = $child;
            }

            $listIDs->childs[$shopClientID]->additionDatas['quantity_month_previous'] += $child->values['delivery_quantity'];
            $listIDs->childs[$shopClientID]->additionDatas['amount_month_previous'] += $child->values['delivery_amount'];
        }

        // задаем время выборки с начала года
        $dateFrom = Helpers_DateTime::getYearBeginStr(date('Y')).' 06:00:00';
        $params['exit_at_from'] = $dateFrom;

        $ids = Request_Request::findBranch('DB_Ab1_Shop_Car',
            $shopIDs, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
            $elements
        );
        $ids->addChilds(
            Request_Request::findBranch('DB_Ab1_Shop_Piece',
                $shopIDs, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
                $elements
            )
        );
        foreach ($ids->childs as $child){
            $shopClientID = $child->getElementValue('shop_transport_company_id', 'is_own', 3);
            if(!key_exists($shopClientID, $listIDs->childs)){
                $child->additionDatas = $resultArray;
                $listIDs->childs[$shopClientID] = $child;
            }

            $listIDs->childs[$shopClientID]->additionDatas['quantity_year'] += $child->values['delivery_quantity'];
            $listIDs->childs[$shopClientID]->additionDatas['amount_year'] += $child->values['delivery_amount'];
        }

        // задаем время выборки с за все время
        /* $params['exit_at_from'] = NULL;

        $ids = Request_Request::findBranch('DB_Ab1_Shop_Car',
            $shopIDs, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
            $elements
        );
        $ids->addChilds(
            Request_Request::findBranch('DB_Ab1_Shop_Piece',
                $shopIDs, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
                $elements
            )
        );
        foreach ($ids->childs as $child){
            $shopClientID = $child->getElementValue('shop_transport_company_id', 'is_own', 3);
            if(!key_exists($shopClientID, $listIDs->childs)){
                if(!$isAll){
                    continue;
                }
                $child->additionDatas = $resultArray;
                $listIDs->childs[$shopClientID] = $child;
            }

            $listIDs->childs[$shopClientID]->additionDatas['quantity'] += $child->values['delivery_quantity'];
            $listIDs->childs[$shopClientID]->additionDatas['amount'] += $child->values['delivery_amount'];
        }*/

        // итог
        $listIDs->additionDatas = $listIDs->calcTotalsChild(
            array(
                'quantity_day',
                'quantity_yesterday',
                'quantity_week',
                'quantity_month',
                'quantity_month_previous',
                'quantity_year',

                'amount_day',
                'amount_yesterday',
                'amount_week',
                'amount_month',
                'amount_month_previous',
                'amount_year',
            ),
            true
        );

        $listIDs->childsSortBy(
            array(
                Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_storage_id.name',
            )
        );

        $this->_sitePageData->countRecord = count($listIDs->childs);

        $this->_sitePageData->newShopShablonPath('ab1/_all');
        $this->_sitePageData->replaceDatas['view::_shop/delivery/list/statistics/company'] = Helpers_View::getViewObjects(
            $listIDs, new Model_Ab1_Shop_Product_Rubric(),
            '_shop/delivery/list/statistics/company','_shop/delivery/one/statistics/company',
            $this->_sitePageData, $this->_driverDB
        );
        $this->_sitePageData->previousShopShablonPath();

        return $listIDs;
    }

    protected function _deliveryClientStatistics(array $shopIDs)
    {
        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/delivery/list/statistics/client',
            )
        );

        // задаем время выборки с начала дня
        $dateFrom = date('Y-m-d').' 06:00:00';
        $listIDs = new MyArray();
        $params = Request_RequestParams::setParams(
            array(
                'shop_transport_company_id-is_own' => Request_RequestParams::getParamBoolean('shop_transport_company_id-is_own'),
                'is_exit' => 1,
                'exit_at_from' => $dateFrom,
                'sum_delivery_quantity' => TRUE,
                'sum_delivery_amount' => TRUE,
                'is_charity' => FALSE,
                'shop_delivery_id_from' => 0,
                'group_by' => array(
                    'shop_client_id', 'shop_client_id.name',
                    'shop_transport_company_id.is_own',
                ),
            )
        );

        $elements = array(
            'shop_client_id' => array('name'),
            'shop_transport_company_id' => array('is_own'),
        );

        $resultArray = array(
            'quantity_day' => 0,
            'quantity_yesterday' => 0,
            'quantity_week' => 0,
            'quantity_month' => 0,
            'quantity_month_previous' => 0,
            'quantity_year' => 0,

            'amount_day' => 0,
            'amount_yesterday' => 0,
            'amount_week' => 0,
            'amount_month' => 0,
            'amount_month_previous' => 0,
            'amount_year' => 0,
        );

        $ids = Request_Request::findBranch('DB_Ab1_Shop_Car',
            $shopIDs, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
            $elements
        );
        $ids->addChilds(
            Request_Request::findBranch('DB_Ab1_Shop_Piece',
                $shopIDs, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
                $elements
            )
        );
        foreach ($ids->childs as $child){
            $shopClientID = $child->values['shop_client_id'];
            if(!key_exists($shopClientID, $listIDs->childs)){
                $child->additionDatas = $resultArray;
                $listIDs->childs[$shopClientID] = $child;
            }

            $listIDs->childs[$shopClientID]->additionDatas['quantity_day'] += $child->values['delivery_quantity'];
            $listIDs->childs[$shopClientID]->additionDatas['amount_day'] += $child->values['delivery_amount'];
        }

        // задаем время выборки вчера
        $paramsYesterday = $params;
        $paramsYesterday['exit_at_to'] = $dateFrom;
        $paramsYesterday['exit_at_from'] = Helpers_DateTime::minusDays($dateFrom, 1);

        $ids = Request_Request::findBranch('DB_Ab1_Shop_Car',
            $shopIDs, $this->_sitePageData, $this->_driverDB, $paramsYesterday, 0, TRUE,
            $elements
        );
        $ids->addChilds(
            Request_Request::findBranch('DB_Ab1_Shop_Piece',
                $shopIDs, $this->_sitePageData, $this->_driverDB, $paramsYesterday, 0, TRUE,
                $elements
            )
        );
        foreach ($ids->childs as $child){
            $shopClientID = $child->values['shop_client_id'];
            if(!key_exists($shopClientID, $listIDs->childs)){
                $child->additionDatas = $resultArray;
                $listIDs->childs[$shopClientID] = $child;
            }

            $listIDs->childs[$shopClientID]->additionDatas['quantity_yesterday'] += $child->values['delivery_quantity'];
            $listIDs->childs[$shopClientID]->additionDatas['amount_yesterday'] += $child->values['delivery_amount'];
        }

        // задаем время выборки с начала недели
        $dateFrom = Helpers_DateTime::getWeekBeginStr(date('Y-m-d')).' 06:00:00';
        $params['exit_at_from'] = $dateFrom;

        $ids = Request_Request::findBranch('DB_Ab1_Shop_Car',
            $shopIDs, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
            $elements
        );
        $ids->addChilds(
            Request_Request::findBranch('DB_Ab1_Shop_Piece',
                $shopIDs, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
                $elements
            )
        );
        foreach ($ids->childs as $child){
            $shopClientID = $child->values['shop_client_id'];
            if(!key_exists($shopClientID, $listIDs->childs)){
                $child->additionDatas = $resultArray;
                $listIDs->childs[$shopClientID] = $child;
            }

            $listIDs->childs[$shopClientID]->additionDatas['quantity_week'] += $child->values['delivery_quantity'];
            $listIDs->childs[$shopClientID]->additionDatas['amount_week'] += $child->values['delivery_amount'];
        }

        // задаем время выборки с начала месяца
        $dateFrom = Helpers_DateTime::getMonthBeginStr(date('m'), date('Y')).' 06:00:00';
        $params['exit_at_from'] = $dateFrom;

        $ids = Request_Request::findBranch('DB_Ab1_Shop_Car',
            $shopIDs, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
            $elements
        );
        $ids->addChilds(
            Request_Request::findBranch('DB_Ab1_Shop_Piece',
                $shopIDs, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
                $elements
            )
        );
        foreach ($ids->childs as $child){
            $shopClientID = $child->values['shop_client_id'];
            if(!key_exists($shopClientID, $listIDs->childs)){
                $child->additionDatas = $resultArray;
                $listIDs->childs[$shopClientID] = $child;
            }

            $listIDs->childs[$shopClientID]->additionDatas['quantity_month'] += $child->values['delivery_quantity'];
            $listIDs->childs[$shopClientID]->additionDatas['amount_month'] += $child->values['delivery_amount'];
        }

        // задаем время выборки с предыдущего месяца
        $paramsPreviousMonth = $params;
        $tmp = Helpers_DateTime::getMonthBeginStr(date('m'), date('Y')).' 06:00:00';
        $paramsPreviousMonth['exit_at_to'] = $tmp;
        $paramsPreviousMonth['exit_at_from'] = Helpers_DateTime::minusMonth($tmp, 1, true);

        $ids = Request_Request::findBranch('DB_Ab1_Shop_Car',
            $shopIDs, $this->_sitePageData, $this->_driverDB, $paramsPreviousMonth, 0, TRUE,
            $elements
        );
        $ids->addChilds(
            Request_Request::findBranch('DB_Ab1_Shop_Piece',
                $shopIDs, $this->_sitePageData, $this->_driverDB, $paramsPreviousMonth, 0, TRUE,
                $elements
            )
        );
        foreach ($ids->childs as $child){
            $shopClientID = $child->values['shop_client_id'];
            if(!key_exists($shopClientID, $listIDs->childs)){
                $child->additionDatas = $resultArray;
                $listIDs->childs[$shopClientID] = $child;
            }

            $listIDs->childs[$shopClientID]->additionDatas['quantity_month_previous'] += $child->values['delivery_quantity'];
            $listIDs->childs[$shopClientID]->additionDatas['amount_month_previous'] += $child->values['delivery_amount'];
        }

        // задаем время выборки с начала года
        $dateFrom = Helpers_DateTime::getYearBeginStr(date('Y')).' 06:00:00';
        $params['exit_at_from'] = $dateFrom;

        $ids = Request_Request::findBranch('DB_Ab1_Shop_Car',
            $shopIDs, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
            $elements
        );
        $ids->addChilds(
            Request_Request::findBranch('DB_Ab1_Shop_Piece',
                $shopIDs, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
                $elements
            )
        );
        foreach ($ids->childs as $child){
            $shopClientID = $child->values['shop_client_id'];
            if(!key_exists($shopClientID, $listIDs->childs)){
                $child->additionDatas = $resultArray;
                $listIDs->childs[$shopClientID] = $child;
            }

            $listIDs->childs[$shopClientID]->additionDatas['quantity_year'] += $child->values['delivery_quantity'];
            $listIDs->childs[$shopClientID]->additionDatas['amount_year'] += $child->values['delivery_amount'];
        }

        // задаем время выборки с за все время
        /* $params['exit_at_from'] = NULL;

        $ids = Request_Request::findBranch('DB_Ab1_Shop_Car',
            $shopIDs, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
            $elements
        );
        $ids->addChilds(
            Request_Request::findBranch('DB_Ab1_Shop_Piece',
                $shopIDs, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
                $elements
            )
        );
        foreach ($ids->childs as $child){
            $shopClientID = $child->values['shop_client_id'];
            if(!key_exists($shopClientID, $listIDs->childs)){
                if(!$isAll){
                    continue;
                }
                $child->additionDatas = $resultArray;
                $listIDs->childs[$shopClientID] = $child;
            }

            $listIDs->childs[$shopClientID]->additionDatas['quantity'] += $child->values['delivery_quantity'];
            $listIDs->childs[$shopClientID]->additionDatas['amount'] += $child->values['delivery_amount'];
        }*/

        // итог
        $listIDs->additionDatas = $listIDs->calcTotalsChild(
            array(
                'quantity_day',
                'quantity_yesterday',
                'quantity_week',
                'quantity_month',
                'quantity_month_previous',
                'quantity_year',

                'amount_day',
                'amount_yesterday',
                'amount_week',
                'amount_month',
                'amount_month_previous',
                'amount_year',
            ),
            true
        );

        $listIDs->childsSortBy(
            array(
                'amount_year',
            ),
            false
        );

        $this->_sitePageData->countRecord = count($listIDs->childs);

        $this->_sitePageData->newShopShablonPath('ab1/_all');
        $this->_sitePageData->replaceDatas['view::_shop/delivery/list/statistics/client'] = Helpers_View::getViewObjects(
            $listIDs, new Model_Ab1_Shop_Product_Rubric(),
            '_shop/delivery/list/statistics/client','_shop/delivery/one/statistics/client',
            $this->_sitePageData, $this->_driverDB
        );
        $this->_sitePageData->previousShopShablonPath();

        return $listIDs;
    }

    protected function _actionShopDeliveryStatistics()
    {
        $shopIDs = array();
        if(Request_RequestParams::getParamInt('shop_branch_id') != -1){
            $shopIDs[] = $this->_sitePageData->shopID;
        }

        $this->_requestShopBranches(NULL, TRUE);

        $this->_deliveryRubricStatistics($shopIDs);
        $this->_deliveryCompanyStatistics($shopIDs);
        $this->_deliveryClientStatistics($shopIDs);

        $this->_putInMain('/main/_shop/delivery/statistics');
    }

    public function _actionShopDeliveryNew()
    {
        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/delivery/one/new',
            )
        );

        $this->_requestDeliveryTypes();
        $this->_requestShopDeliveryGroups();
        $this->_requestShopProductRubrics();
        $this->_requestShopProducts();

        $dataID = new MyArray();
        $dataID->id = 0;
        $dataID->isFindDB = TRUE;

        $this->_sitePageData->newShopShablonPath('ab1/_all');
        $this->_sitePageData->replaceDatas['view::_shop/delivery/one/new'] = Helpers_View::getViewObject(
            $dataID, new Model_Ab1_Shop_Delivery(),
            '_shop/delivery/one/new',
            $this->_sitePageData, $this->_driverDB, $this->_sitePageData->shopMainID
        );
        $this->_sitePageData->previousShopShablonPath();

        $this->_putInMain('/main/_shop/delivery/new');
    }

    public function _actionShopDeliveryEdit()
    {
        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/delivery/one/edit',
            )
        );

        // id записи
        $id = Request_RequestParams::getParamInt('id');
        $model = new Model_Ab1_Shop_Delivery();
        if (! $this->dublicateObjectLanguage($model, $id, $this->_sitePageData->shopMainID, FALSE)) {
            throw new HTTP_Exception_404('Delivery not is found!');
        }

        $this->_requestDeliveryTypes($model->getDeliveryTypeID());
        $this->_requestShopDeliveryGroups($model->getShopDeliveryGroupID());
        $this->_requestShopProductRubrics($model->getShopProductRubricID());
        $this->_requestShopProducts($model->getShopProductID());

        // получаем данные
        $this->_sitePageData->newShopShablonPath('ab1/_all');
        View_View::findOne('DB_Ab1_Shop_Delivery',
            $this->_sitePageData->shopMainID,
            "_shop/delivery/one/edit",
            $this->_sitePageData, $this->_driverDB, array('id' => $id)
        );
        $this->_sitePageData->previousShopShablonPath();

        $this->_putInMain('/main/_shop/delivery/edit');
    }

    public function _actionShopClientNew()
    {
        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/client/one/new',
            )
        );
        $this->_requestOrganizationTypes();
        $this->_requestKatos();
        $this->_requestBanks();
        $this->_requestListDB('DB_Ab1_ClientType');

        $dataID = new MyArray();
        $dataID->id = 0;
        $dataID->isFindDB = TRUE;

        $this->_sitePageData->newShopShablonPath('ab1/_all');
        $this->_sitePageData->replaceDatas['view::_shop/client/one/new'] = Helpers_View::getViewObject(
            $dataID, new Model_Ab1_Shop_Client(),
            '_shop/client/one/new', $this->_sitePageData, $this->_driverDB, $this->_sitePageData->shopMainID
        );
        $this->_sitePageData->previousShopShablonPath();

        $this->_putInMain('/main/_shop/client/new');
    }

    protected function _actionShopClientEdit()
    {
        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/client/one/edit',
            )
        );

        // id записи
        $shopClientID = Request_RequestParams::getParamInt('id');
        $model = new Model_Ab1_Shop_Client();
        if (! $this->dublicateObjectLanguage($model, $shopClientID, $this->_sitePageData->shopMainID, FALSE)) {
            throw new HTTP_Exception_404('Client not is found!');
        }

        $this->_requestOrganizationTypes($model->getOrganizationTypeID());
        $this->_requestKatos($model->getKatoID());
        $this->_requestBanks($model->getBankID());
        $this->_sitePageData->addReplaceAndGlobalDatas(
            'view::client-type/list/list-list',
            $this->_requestListDB('DB_Ab1_ClientType', $model->getClientTypeIDsArray())
        );
        $this->_requestListDB('DB_Ab1_ClientType', $model->getClientTypeID());

        // получаем данные
        $this->_sitePageData->newShopShablonPath('ab1/_all');
        View_View::findOne('DB_Ab1_Shop_Client', $this->_sitePageData->shopMainID, "_shop/client/one/edit",
            $this->_sitePageData, $this->_driverDB, array('id' => $shopClientID), array());
        $this->_sitePageData->previousShopShablonPath();

        $this->_putInMain('/main/_shop/client/edit');
    }

    protected function _storageBranchStatistics()
    {
        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/storage/list/statistics/total-branch',
            )
        );

        $shops = array();

        // задаем время выборки с начала дня
        $listIDs = new MyArray();
        $elements = array(
            'shop_storage_id' => array('name'),
            'shop_id' => array('name'),
        );

        // реализация продукции со склада
        $params = Request_RequestParams::setParams(
            array(
                'is_exit' => 1,
                'sum_quantity' => TRUE,
                'is_charity' => FALSE,
                'shop_storage_id_from' => 0,
                'group_by' => array(
                    'shop_storage_id', 'shop_storage_id.name',
                    'shop_id', 'shop_id.name',
                ),
            )
        );
        $ids = Request_Request::findBranch('DB_Ab1_Shop_Car',
            array(), $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
            $elements
        );
        $ids->addChilds(
            Request_Request::findBranch('DB_Ab1_Shop_Piece_Item',
                array(), $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
                $elements
            )
        );

        // собираем филиалы
        foreach ($ids->childs as $child){
            $shopID = $child->values['shop_id'];
            if(!key_exists($shopID, $shops)){
                $shops[$shopID] = array(
                    'name' => $child->getElementValue('shop_id'),
                    'quantity' => 0,
                );
            }
        }

        // производство продукции на склада
        $params = Request_RequestParams::setParams(
            array(
                'sum_quantity' => TRUE,
                'group_by' => array(
                    'shop_storage_id', 'shop_storage_id.name',
                    'shop_id', 'shop_id.name',
                ),
            )
        );
        $shopProductStorageIDs = Request_Request::find('DB_Ab1_Shop_Product_Storage',
            array(), $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
            $elements
        );

        // собираем филиалы
        foreach ($shopProductStorageIDs->childs as $child){
            $shopID = $child->values['shop_id'];
            if(!key_exists($shopID, $shops)){
                $shops[$shopID] = array(
                    'name' => $child->getElementValue('shop_id'),
                    'quantity' => 0,
                );
            }
        }

        foreach ($ids->childs as $child){
            $shopClientID = $child->values['shop_storage_id'];
            if(!key_exists($shopClientID, $listIDs->childs)){
                $child->additionDatas = array(
                    'quantity' => 0,
                    'shops' => $shops,
                );
                $listIDs->childs[$shopClientID] = $child;
            }

            $listIDs->childs[$shopClientID]->additionDatas['shops'][$child->values['shop_id']]['quantity'] += $child->values['quantity'];
            $listIDs->childs[$shopClientID]->additionDatas['quantity'] += $child->values['quantity'];
        }

        foreach ($shopProductStorageIDs->childs as $child){
            $shopClientID = $child->values['shop_storage_id'];
            if(!key_exists($shopClientID, $listIDs->childs)){
                $child->additionDatas = array(
                    'quantity' => 0,
                    'shops' => $shops,
                );
                $listIDs->childs[$shopClientID] = $child;
            }

            $listIDs->childs[$shopClientID]->additionDatas['shops'][$child->values['shop_id']]['quantity'] += $child->values['quantity'];
            $listIDs->childs[$shopClientID]->additionDatas['quantity'] += $child->values['quantity'];
        }

        // итог
        $listIDs->additionDatas = $listIDs->calcTotalsChild(
            array(
                'quantity',
            ),
            true
        );

        $listIDs->childsSortBy(
            array(
                Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_storage_id.name',
            )
        );

        $this->_sitePageData->countRecord = count($listIDs->childs);

        $this->_sitePageData->newShopShablonPath('ab1/_all');
        $this->_sitePageData->replaceDatas['view::_shop/storage/list/statistics/total'] = Helpers_View::getViewObjects(
            $listIDs, new Model_Ab1_Shop_Product_Rubric(),
            '_shop/storage/list/statistics/total','_shop/storage/one/statistics/total',
            $this->_sitePageData, $this->_driverDB
        );
        $this->_sitePageData->previousShopShablonPath();

        return $listIDs;
    }

    protected function _storageStatistics()
    {
        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/storage/list/statistics/total',
            )
        );

        // задаем время выборки с начала дня
        $listIDs = new MyArray();
        $params = Request_RequestParams::setParams(
            array(
                'is_exit' => 1,
                'sum_quantity' => TRUE,
                'is_charity' => FALSE,
                'shop_storage_id_from' => 0,
                'group_by' => array(
                    'shop_storage_id', 'shop_storage_id.name',
                ),
            )
        );

        $elements = array(
            'shop_storage_id' => array('name'),
        );

        $ids = Request_Request::find('DB_Ab1_Shop_Car',
            $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
            $elements
        );
        $ids->addChilds(
            Request_Request::find('DB_Ab1_Shop_Piece_Item',
                $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
                $elements
            )
        );
        foreach ($ids->childs as $child){
            $child->additionDatas = array(
                'quantity' => -$child->values['quantity'],
            );

            $listIDs->childs[$child->values['shop_storage_id']] = $child;
        }


        $params = Request_RequestParams::setParams(
            array(
                'sum_quantity' => TRUE,
                'group_by' => array(
                    'shop_storage_id', 'shop_storage_id.name',
                ),
            )
        );

        $ids = Request_Request::find('DB_Ab1_Shop_Product_Storage',
            $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
            $elements
        );
        foreach ($ids->childs as $child){
            $shopClientID = $child->values['shop_storage_id'];
            if(!key_exists($shopClientID, $listIDs->childs)){
                $child->additionDatas = array(
                    'quantity' => 0,
                );
                $listIDs->childs[$shopClientID] = $child;
            }

            $listIDs->childs[$shopClientID]->additionDatas['quantity'] += $child->values['quantity'];
        }
        // итог
        $listIDs->additionDatas = $listIDs->calcTotalsChild(
            array(
                'quantity',
            ),
            true
        );

        $listIDs->childsSortBy(
            array(
                Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_storage_id.name',
            )
        );

        $this->_sitePageData->countRecord = count($listIDs->childs);

        $this->_sitePageData->newShopShablonPath('ab1/_all');
        $this->_sitePageData->replaceDatas['view::_shop/storage/list/statistics/total'] = Helpers_View::getViewObjects(
            $listIDs, new Model_Ab1_Shop_Product_Rubric(),
            '_shop/storage/list/statistics/total','_shop/storage/one/statistics/total',
            $this->_sitePageData, $this->_driverDB
        );
        $this->_sitePageData->previousShopShablonPath();

        return $listIDs;
    }

    protected function _storageTurnPlaceStatistics()
    {
        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/storage/list/statistics/turn-place',
            )
        );

        // задаем время выборки с начала дня
        $dateFrom = date('Y-m-d').' 06:00:00';
        $listIDs = new MyArray();
        $params = Request_RequestParams::setParams(
            array(
                'weighted_at_from' => $dateFrom,
                'sum_quantity' => TRUE,
                'group_by' => array(
                    'shop_turn_place_id', 'shop_turn_place_id.name',
                ),
            )
        );

        $elements = array(
            'shop_turn_place_id' => array('name'),
        );

        $resultArray = array(
            'quantity_day' => 0,
            'quantity_yesterday' => 0,
            'quantity_week' => 0,
            'quantity_month' => 0,
            'quantity_month_previous' => 0,
            'quantity_year' => 0,
        );

        $ids = Request_Request::find('DB_Ab1_Shop_Product_Storage',
            $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
            $elements
        );
        foreach ($ids->childs as $child){
            $shopClientID = $child->values['shop_turn_place_id'];
            if(!key_exists($shopClientID, $listIDs->childs)){
                $child->additionDatas = $resultArray;
                $listIDs->childs[$shopClientID] = $child;
            }

            $listIDs->childs[$shopClientID]->additionDatas['quantity_day'] += $child->values['quantity'];
        }

        // задаем время выборки вчера
        $paramsYesterday = $params;
        $paramsYesterday['weighted_at_to'] = $dateFrom;
        $paramsYesterday['weighted_at_from'] = Helpers_DateTime::minusDays($dateFrom, 1);

        $ids = Request_Request::find('DB_Ab1_Shop_Product_Storage',
            $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB, $paramsYesterday, 0, TRUE,
            $elements
        );
        foreach ($ids->childs as $child){
            $shopClientID = $child->values['shop_turn_place_id'];
            if(!key_exists($shopClientID, $listIDs->childs)){
                $child->additionDatas = $resultArray;
                $listIDs->childs[$shopClientID] = $child;
            }

            $listIDs->childs[$shopClientID]->additionDatas['quantity_yesterday'] += $child->values['quantity'];
        }

        // задаем время выборки с начала недели
        $dateFrom = Helpers_DateTime::getWeekBeginStr(date('Y-m-d')).' 06:00:00';
        $params['weighted_at_from'] = $dateFrom;

        $ids = Request_Request::find('DB_Ab1_Shop_Product_Storage',
            $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
            $elements
        );
        foreach ($ids->childs as $child){
            $shopClientID = $child->values['shop_turn_place_id'];
            if(!key_exists($shopClientID, $listIDs->childs)){
                $child->additionDatas = $resultArray;
                $listIDs->childs[$shopClientID] = $child;
            }

            $listIDs->childs[$shopClientID]->additionDatas['quantity_week'] += $child->values['quantity'];
        }

        // задаем время выборки с начала месяца
        $dateFrom = Helpers_DateTime::getMonthBeginStr(date('m'), date('Y')).' 06:00:00';
        $params['weighted_at_from'] = $dateFrom;

        $ids = Request_Request::find('DB_Ab1_Shop_Product_Storage',
            $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
            $elements
        );
        foreach ($ids->childs as $child){
            $shopClientID = $child->values['shop_turn_place_id'];
            if(!key_exists($shopClientID, $listIDs->childs)){
                $child->additionDatas = $resultArray;
                $listIDs->childs[$shopClientID] = $child;
            }

            $listIDs->childs[$shopClientID]->additionDatas['quantity_month'] += $child->values['quantity'];
        }

        // задаем время выборки с предыдущего месяца
        $paramsPreviousMonth = $params;
        $tmp = Helpers_DateTime::getMonthBeginStr(date('m'), date('Y')).' 06:00:00';
        $paramsPreviousMonth['weighted_at_to'] = $tmp;
        $paramsPreviousMonth['weighted_at_from'] = Helpers_DateTime::minusMonth($tmp, 1, true);

        $ids = Request_Request::find('DB_Ab1_Shop_Product_Storage',
            $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB, $paramsPreviousMonth, 0, TRUE,
            $elements
        );
        foreach ($ids->childs as $child){
            $shopClientID = $child->values['shop_turn_place_id'];
            if(!key_exists($shopClientID, $listIDs->childs)){
                $child->additionDatas = $resultArray;
                $listIDs->childs[$shopClientID] = $child;
            }

            $listIDs->childs[$shopClientID]->additionDatas['quantity_month_previous'] += $child->values['quantity'];
        }

        // задаем время выборки с начала года
        $dateFrom = Helpers_DateTime::getYearBeginStr(date('Y')).' 06:00:00';
        $params['weighted_at_from'] = $dateFrom;

        $ids = Request_Request::find('DB_Ab1_Shop_Product_Storage',
            $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
            $elements
        );
        foreach ($ids->childs as $child){
            $shopClientID = $child->values['shop_turn_place_id'];
            if(!key_exists($shopClientID, $listIDs->childs)){
                $child->additionDatas = $resultArray;
                $listIDs->childs[$shopClientID] = $child;
            }

            $listIDs->childs[$shopClientID]->additionDatas['quantity_year'] += $child->values['quantity'];
        }

        // задаем время выборки с за все время
        /* $params['weighted_at_from'] = NULL;

        $ids = Request_Request::find('DB_Ab1_Shop_Product_Storage',
            $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
            $elements
        );
        foreach ($ids->childs as $child){
            $shopClientID = $child->values['shop_turn_place_id'];
            if(!key_exists($shopClientID, $listIDs->childs)){
                if(!$isAll){
                    continue;
                }
                $child->additionDatas = $resultArray;
                $listIDs->childs[$shopClientID] = $child;
            }

            $listIDs->childs[$shopClientID]->additionDatas['quantity'] += $child->values['quantity'];
        }*/

        // итог
        $listIDs->additionDatas = $listIDs->calcTotalsChild(
            array(
                'quantity_day',
                'quantity_yesterday',
                'quantity_week',
                'quantity_month',
                'quantity_month_previous',
                'quantity_year',
            ),
            true
        );

        $listIDs->childsSortBy(
            array(
                Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_turn_place_id.name',
            )
        );

        $this->_sitePageData->countRecord = count($listIDs->childs);

        $this->_sitePageData->newShopShablonPath('ab1/_all');
        $this->_sitePageData->replaceDatas['view::_shop/storage/list/statistics/turn-place'] = Helpers_View::getViewObjects(
            $listIDs, new Model_Ab1_Shop_Product_Rubric(),
            '_shop/storage/list/statistics/turn-place','_shop/storage/one/statistics/turn-place',
            $this->_sitePageData, $this->_driverDB
        );
        $this->_sitePageData->previousShopShablonPath();

        return $listIDs;
    }

    protected function _storageRealizationStatistics()
    {
        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/storage/list/statistics/realization',
            )
        );

        // задаем время выборки с начала дня
        $dateFrom = date('Y-m-d').' 06:00:00';
        $listIDs = new MyArray();
        $params = Request_RequestParams::setParams(
            array(
                'is_exit' => 1,
                'exit_at_from' => $dateFrom,
                'sum_quantity' => TRUE,
                'is_charity' => FALSE,
                'shop_storage_id_from' => 0,
                'group_by' => array(
                    'shop_storage_id', 'shop_storage_id.name',
                ),
            )
        );

        $elements = array(
            'shop_storage_id' => array('name'),
        );

        $resultArray = array(
            'quantity_day' => 0,
            'quantity_yesterday' => 0,
            'quantity_week' => 0,
            'quantity_month' => 0,
            'quantity_month_previous' => 0,
            'quantity_year' => 0,
        );

        $ids = Request_Request::find('DB_Ab1_Shop_Car',
            $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
            $elements
        );
        $ids->addChilds(
            Request_Request::find('DB_Ab1_Shop_Piece_Item',
                $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
                $elements
            )
        );
        foreach ($ids->childs as $child){
            $shopClientID = $child->values['shop_storage_id'];
            if(!key_exists($shopClientID, $listIDs->childs)){
                $child->additionDatas = $resultArray;
                $listIDs->childs[$shopClientID] = $child;
            }

            $listIDs->childs[$shopClientID]->additionDatas['quantity_day'] = $child->values['quantity'];
        }

        // задаем время выборки вчера
        $paramsYesterday = $params;
        $paramsYesterday['exit_at_to'] = $dateFrom;
        $paramsYesterday['exit_at_from'] = Helpers_DateTime::minusDays($dateFrom, 1);

        $ids = Request_Request::find('DB_Ab1_Shop_Car',
            $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB, $paramsYesterday, 0, TRUE,
            $elements
        );
        $ids->addChilds(
            Request_Request::find('DB_Ab1_Shop_Piece_Item',
                $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB, $paramsYesterday, 0, TRUE,
                $elements
            )
        );
        foreach ($ids->childs as $child){
            $shopClientID = $child->values['shop_storage_id'];
            if(!key_exists($shopClientID, $listIDs->childs)){
                $child->additionDatas = $resultArray;
                $listIDs->childs[$shopClientID] = $child;
            }

            $listIDs->childs[$shopClientID]->additionDatas['quantity_yesterday'] = $child->values['quantity'];
        }

        // задаем время выборки с начала недели
        $dateFrom = Helpers_DateTime::getWeekBeginStr(date('Y-m-d')).' 06:00:00';
        $params['exit_at_from'] = $dateFrom;

        $ids = Request_Request::find('DB_Ab1_Shop_Car',
            $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
            $elements
        );
        $ids->addChilds(
            Request_Request::find('DB_Ab1_Shop_Piece_Item',
                $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
                $elements
            )
        );
        foreach ($ids->childs as $child){
            $shopClientID = $child->values['shop_storage_id'];
            if(!key_exists($shopClientID, $listIDs->childs)){
                $child->additionDatas = $resultArray;
                $listIDs->childs[$shopClientID] = $child;
            }

            $listIDs->childs[$shopClientID]->additionDatas['quantity_week'] = $child->values['quantity'];
        }

        // задаем время выборки с начала месяца
        $dateFrom = Helpers_DateTime::getMonthBeginStr(date('m'), date('Y')).' 06:00:00';
        $params['exit_at_from'] = $dateFrom;

        $ids = Request_Request::find('DB_Ab1_Shop_Car',
            $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
            $elements
        );
        $ids->addChilds(
            Request_Request::find('DB_Ab1_Shop_Piece_Item',
                $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
                $elements
            )
        );
        foreach ($ids->childs as $child){
            $shopClientID = $child->values['shop_storage_id'];
            if(!key_exists($shopClientID, $listIDs->childs)){
                $child->additionDatas = $resultArray;
                $listIDs->childs[$shopClientID] = $child;
            }

            $listIDs->childs[$shopClientID]->additionDatas['quantity_month'] = $child->values['quantity'];
        }

        // задаем время выборки с предыдущего месяца
        $paramsPreviousMonth = $params;
        $tmp = Helpers_DateTime::getMonthBeginStr(date('m'), date('Y')).' 06:00:00';
        $paramsPreviousMonth['exit_at_to'] = $tmp;
        $paramsPreviousMonth['exit_at_from'] = Helpers_DateTime::minusMonth($tmp, 1, true);

        $ids = Request_Request::find('DB_Ab1_Shop_Car',
            $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB, $paramsPreviousMonth, 0, TRUE,
            $elements
        );
        $ids->addChilds(
            Request_Request::find('DB_Ab1_Shop_Piece_Item',
                $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB, $paramsPreviousMonth, 0, TRUE,
                $elements
            )
        );
        foreach ($ids->childs as $child){
            $shopClientID = $child->values['shop_storage_id'];
            if(!key_exists($shopClientID, $listIDs->childs)){
                $child->additionDatas = $resultArray;
                $listIDs->childs[$shopClientID] = $child;
            }

            $listIDs->childs[$shopClientID]->additionDatas['quantity_month_previous'] = $child->values['quantity'];
        }

        // задаем время выборки с начала года
        $dateFrom = Helpers_DateTime::getYearBeginStr(date('Y')).' 06:00:00';
        $params['exit_at_from'] = $dateFrom;

        $ids = Request_Request::find('DB_Ab1_Shop_Car',
            $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
            $elements
        );
        $ids->addChilds(
            Request_Request::find('DB_Ab1_Shop_Piece_Item',
                $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
                $elements
            )
        );
        foreach ($ids->childs as $child){
            $shopClientID = $child->values['shop_storage_id'];
            if(!key_exists($shopClientID, $listIDs->childs)){
                $child->additionDatas = $resultArray;
                $listIDs->childs[$shopClientID] = $child;
            }

            $listIDs->childs[$shopClientID]->additionDatas['quantity_year'] = $child->values['quantity'];
        }

        // задаем время выборки с за все время
        /* $params['exit_at_from'] = NULL;

        $ids = Request_Request::find('DB_Ab1_Shop_Car',
            $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
            $elements
        );
        $ids->addChilds(
            Request_Request::find('DB_Ab1_Shop_Piece_Item',
                $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
                $elements
            )
        );
        foreach ($ids->childs as $child){
            $shopClientID = $child->values['shop_storage_id'];
            if(!key_exists($shopClientID, $listIDs->childs)){
                if(!$isAll){
                    continue;
                }
                $child->additionDatas = $resultArray;
                $listIDs->childs[$shopClientID] = $child;
            }

            $listIDs->childs[$shopClientID]->additionDatas['quantity'] = $child->values['quantity'];
        }*/

        // итог
        $listIDs->additionDatas = $listIDs->calcTotalsChild(
            array(
                'quantity_day',
                'quantity_yesterday',
                'quantity_week',
                'quantity_month',
                'quantity_month_previous',
                'quantity_year',
            ),
            true
        );

        $listIDs->childsSortBy(
            array(
                Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_storage_id.name',
            )
        );

        $this->_sitePageData->countRecord = count($listIDs->childs);

        $this->_sitePageData->newShopShablonPath('ab1/_all');
        $this->_sitePageData->replaceDatas['view::_shop/storage/list/statistics/realization'] = Helpers_View::getViewObjects(
            $listIDs, new Model_Ab1_Shop_Product_Rubric(),
            '_shop/storage/list/statistics/realization','_shop/storage/one/statistics/realization',
            $this->_sitePageData, $this->_driverDB
        );
        $this->_sitePageData->previousShopShablonPath();

        return $listIDs;
    }

    protected function _storageProductStatistics()
    {
        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/storage/list/statistics/storage',
            )
        );

        // задаем время выборки с начала дня
        $dateFrom = date('Y-m-d').' 06:00:00';
        $listIDs = new MyArray();
        $params = Request_RequestParams::setParams(
            array(
                'weighted_at_from' => $dateFrom,
                'sum_quantity' => TRUE,
                'group_by' => array(
                    'shop_storage_id', 'shop_storage_id.name',
                ),
            )
        );

        $elements = array(
            'shop_storage_id' => array('name'),
        );

        $resultArray = array(
            'quantity_day' => 0,
            'quantity_yesterday' => 0,
            'quantity_week' => 0,
            'quantity_month' => 0,
            'quantity_month_previous' => 0,
            'quantity_year' => 0,
        );

        $ids = Request_Request::find('DB_Ab1_Shop_Product_Storage',
            $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
            $elements
        );
        foreach ($ids->childs as $child){
            $shopClientID = $child->values['shop_storage_id'];
            if(!key_exists($shopClientID, $listIDs->childs)){
                $child->additionDatas = $resultArray;
                $listIDs->childs[$shopClientID] = $child;
            }

            $listIDs->childs[$shopClientID]->additionDatas['quantity_day'] += $child->values['quantity'];
        }

        // задаем время выборки вчера
        $paramsYesterday = $params;
        $paramsYesterday['weighted_at_to'] = $dateFrom;
        $paramsYesterday['weighted_at_from'] = Helpers_DateTime::minusDays($dateFrom, 1);

        $ids = Request_Request::find('DB_Ab1_Shop_Product_Storage',
            $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB, $paramsYesterday, 0, TRUE,
            $elements
        );
        foreach ($ids->childs as $child){
            $shopClientID = $child->values['shop_storage_id'];
            if(!key_exists($shopClientID, $listIDs->childs)){
                $child->additionDatas = $resultArray;
                $listIDs->childs[$shopClientID] = $child;
            }

            $listIDs->childs[$shopClientID]->additionDatas['quantity_yesterday'] += $child->values['quantity'];
        }

        // задаем время выборки с начала недели
        $dateFrom = Helpers_DateTime::getWeekBeginStr(date('Y-m-d')).' 06:00:00';
        $params['weighted_at_from'] = $dateFrom;

        $ids = Request_Request::find('DB_Ab1_Shop_Product_Storage',
            $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
            $elements
        );
        foreach ($ids->childs as $child){
            $shopClientID = $child->values['shop_storage_id'];
            if(!key_exists($shopClientID, $listIDs->childs)){
                $child->additionDatas = $resultArray;
                $listIDs->childs[$shopClientID] = $child;
            }

            $listIDs->childs[$shopClientID]->additionDatas['quantity_week'] += $child->values['quantity'];
        }

        // задаем время выборки с начала месяца
        $dateFrom = Helpers_DateTime::getMonthBeginStr(date('m'), date('Y')).' 06:00:00';
        $params['weighted_at_from'] = $dateFrom;

        $ids = Request_Request::find('DB_Ab1_Shop_Product_Storage',
            $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
            $elements
        );
        foreach ($ids->childs as $child){
            $shopClientID = $child->values['shop_storage_id'];
            if(!key_exists($shopClientID, $listIDs->childs)){
                $child->additionDatas = $resultArray;
                $listIDs->childs[$shopClientID] = $child;
            }

            $listIDs->childs[$shopClientID]->additionDatas['quantity_month'] += $child->values['quantity'];
        }

        // задаем время выборки с предыдущего месяца
        $paramsPreviousMonth = $params;
        $tmp = Helpers_DateTime::getMonthBeginStr(date('m'), date('Y')).' 06:00:00';
        $paramsPreviousMonth['weighted_at_to'] = $tmp;
        $paramsPreviousMonth['weighted_at_from'] = Helpers_DateTime::minusMonth($tmp, 1, true);

        $ids = Request_Request::find('DB_Ab1_Shop_Product_Storage',
            $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB, $paramsPreviousMonth, 0, TRUE,
            $elements
        );
        foreach ($ids->childs as $child){
            $shopClientID = $child->values['shop_storage_id'];
            if(!key_exists($shopClientID, $listIDs->childs)){
                $child->additionDatas = $resultArray;
                $listIDs->childs[$shopClientID] = $child;
            }

            $listIDs->childs[$shopClientID]->additionDatas['quantity_month_previous'] += $child->values['quantity'];
        }

        // задаем время выборки с начала года
        $dateFrom = Helpers_DateTime::getYearBeginStr(date('Y')).' 06:00:00';
        $params['weighted_at_from'] = $dateFrom;

        $ids = Request_Request::find('DB_Ab1_Shop_Product_Storage',
            $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
            $elements
        );
        foreach ($ids->childs as $child){
            $shopClientID = $child->values['shop_storage_id'];
            if(!key_exists($shopClientID, $listIDs->childs)){
                $child->additionDatas = $resultArray;
                $listIDs->childs[$shopClientID] = $child;
            }

            $listIDs->childs[$shopClientID]->additionDatas['quantity_year'] += $child->values['quantity'];
        }

        // задаем время выборки с за все время
        /* $params['weighted_at_from'] = NULL;

        $ids = Request_Request::find('DB_Ab1_Shop_Product_Storage',
            $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
            $elements
        );
        foreach ($ids->childs as $child){
            $shopClientID = $child->values['shop_storage_id'];
            if(!key_exists($shopClientID, $listIDs->childs)){
                if(!$isAll){
                    continue;
                }
                $child->additionDatas = $resultArray;
                $listIDs->childs[$shopClientID] = $child;
            }

            $listIDs->childs[$shopClientID]->additionDatas['quantity'] += $child->values['quantity'];
        }*/

        // итог
        $listIDs->additionDatas = $listIDs->calcTotalsChild(
            array(
                'quantity_day',
                'quantity_yesterday',
                'quantity_week',
                'quantity_month',
                'quantity_month_previous',
                'quantity_year',
            ),
            true
        );

        $listIDs->childsSortBy(
            array(
                Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_storage_id.name',
            )
        );

        $this->_sitePageData->countRecord = count($listIDs->childs);

        $this->_sitePageData->newShopShablonPath('ab1/_all');
        $this->_sitePageData->replaceDatas['view::_shop/storage/list/statistics/storage'] = Helpers_View::getViewObjects(
            $listIDs, new Model_Ab1_Shop_Product_Rubric(),
            '_shop/storage/list/statistics/storage','_shop/storage/one/statistics/storage',
            $this->_sitePageData, $this->_driverDB
        );
        $this->_sitePageData->previousShopShablonPath();
    }

    protected function _actionShopStorageStatistics()
    {
        $this->_requestShopBranches(NULL, TRUE);

        $this->_storageTurnPlaceStatistics();
        $this->_storageRealizationStatistics();
        $this->_storageProductStatistics();
        $this->_storageStatistics();

        $this->_putInMain('/main/_shop/storage/statistics');
    }

    public function _actionShopProductNew()
    {
        $this->_sitePageData->url = '/cash/shopproduct/new';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/product/one/new',
            )
        );

        $this->_requestShopProductRubrics(NULL, NULL);
        $this->_requestShopProductPricelistRubrics(NULL, NULL);
        $this->_requestShopProductGroups();
        $this->_requestProductTypes();
        $this->_requestProductViews();
        $this->_requestShopSubdivisions(null, 0, '');
        $this->_requestFormulaTypes();
        $this->_requestShopMaterials();

        $dataID = new MyArray();
        $dataID->id = 0;
        $dataID->isFindDB = TRUE;

        $this->_sitePageData->newShopShablonPath('ab1/_all');
        $this->_sitePageData->replaceDatas['view::_shop/product/one/new'] = Helpers_View::getViewObject(
            $dataID, new Model_Ab1_Shop_Product(),
            '_shop/product/one/new', $this->_sitePageData, $this->_driverDB, $this->_sitePageData->shopID
        );
        $this->_sitePageData->previousShopShablonPath();

        $this->_putInMain('/main/_shop/product/new');
    }

    public function _actionShopProductEdit()
    {
        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/product/one/edit',
                'view::_shop/product/time/price/list/index',
            )
        );

        // id записи
        $shopProductID = Request_RequestParams::getParamInt('id');
        $model = new Model_Ab1_Shop_Product();
        if (! $this->dublicateObjectLanguage($model, $shopProductID, $this->_sitePageData->shopID, FALSE)) {
            throw new HTTP_Exception_404('Product not is found!');
        }

        $this->_requestShopProductRubrics($model->getShopProductRubricID(), NULL);
        $this->_requestShopProductPricelistRubrics($model->getShopProductPricelistRubricID(), NULL);
        $this->_requestShopProductGroups($model->getShopProductGroupID());
        $this->_requestProductTypes($model->getProductTypeID());
        $this->_requestProductViews($model->getProductViewID());
        $this->_requestFormulaTypes($model->getFormulaTypeIDsArray());

        $this->_requestShopSubdivisions($model->getShopSubdivisionID(), 0, '');
        $this->_requestShopStorages($model->getShopStorageID(), 0, '', $model->getShopSubdivisionID());
        $this->_requestShopHeaps($model->getShopHeapID(), 0, '', $model->getShopSubdivisionID());
        $this->_requestShopMaterials($model->getShopMaterialID());

        // получаем данные
        $this->_sitePageData->newShopShablonPath('ab1/_all');

        View_View::findOne('DB_Ab1_Shop_Product',
            $this->_sitePageData->shopID, "_shop/product/one/edit",
            $this->_sitePageData, $this->_driverDB,
            Request_RequestParams::setParams(
                array(
                    'id' => $shopProductID
                )
            )
        );

        View_View::find('DB_Ab1_Shop_Product_Time_Price',
            $this->_sitePageData->shopID,
            "_shop/product/time/price/list/index", '_shop/product/time/price/one/index',
            $this->_sitePageData, $this->_driverDB,
            Request_RequestParams::setParams(
                array(
                    'shop_product_id' => $shopProductID,
                    'sort_by' => array(
                        'from_at' => 'desc',
                        'to_at' => 'desc',
                    ),
                )
            )
        );

        $this->_sitePageData->previousShopShablonPath();

        $this->_putInMain('/main/_shop/product/edit');
    }

    public function _actionShopTurnPlaceNew()
    {
        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/turn/place/one/new',
            )
        );

        $this->_requestShopTurnTypes();
        $this->_requestShopSubdivisions(null, 0, '');

        $dataID = new MyArray();
        $dataID->id = 0;
        $dataID->isFindDB = TRUE;

        $this->_sitePageData->newShopShablonPath('ab1/_all');
        $this->_sitePageData->replaceDatas['view::_shop/turn/place/one/new'] = Helpers_View::getViewObject(
            $dataID, new Model_Ab1_Shop_Turn_Place(),
            '_shop/turn/place/one/new',
            $this->_sitePageData, $this->_driverDB, $this->_sitePageData->shopID
        );
        $this->_sitePageData->previousShopShablonPath();

        $this->_putInMain('/main/_shop/turn/place/new');
    }

    public function _actionShopTurnPlaceEdit()
    {
        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/turn/place/one/edit',
            )
        );

        // id записи
        $id = Request_RequestParams::getParamInt('id');
        $model = new Model_Ab1_Shop_Turn_Place();
        if (! $this->dublicateObjectLanguage($model, $id, $this->_sitePageData->shopID, false)) {
            throw new HTTP_Exception_404('Turn place not is found!');
        }

        $this->_requestShopTurnTypes($model->getShopTurnTypeID());
        $this->_requestShopSubdivisions($model->getShopSubdivisionID(), 0, '');
        $this->_requestShopHeaps($model->getShopHeapID(), 0, '');
        $this->_requestShopStorages($model->getShopStorageID(), 0, '', $model->getShopSubdivisionID());

        // получаем данные
        $this->_sitePageData->newShopShablonPath('ab1/_all');
        View_View::findOne('DB_Ab1_Shop_Turn_Place',
            $this->_sitePageData->shopID, "_shop/turn/place/one/edit",
            $this->_sitePageData, $this->_driverDB, array('id' => $id), array()
        );
        $this->_sitePageData->previousShopShablonPath();

        $this->_putInMain('/main/_shop/turn/place/edit');
    }

    public function _actionShopDaughterNew()
    {
        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/daughter/one/new',
            )
        );

        $this->_requestDaughterWeights(Model_Ab1_DaughterWeight::DAUGHTER_WEIGHT_DAUGHTER);

        $dataID = new MyArray();
        $dataID->id = 0;
        $dataID->isFindDB = TRUE;

        $this->_sitePageData->newShopShablonPath('ab1/_all');
        $this->_sitePageData->replaceDatas['view::_shop/daughter/one/new'] = Helpers_View::getViewObject(
            $dataID, new Model_Ab1_Shop_Daughter(),
            '_shop/daughter/one/new', $this->_sitePageData, $this->_driverDB, $this->_sitePageData->shopMainID
        );
        $this->_sitePageData->previousShopShablonPath();

        $this->_putInMain('/main/_shop/daughter/new');
    }

    public function _actionShopDaughterEdit()
    {
        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/daughter/one/edit',
            )
        );

        // id записи
        $id = Request_RequestParams::getParamInt('id');
        $model = new Model_Ab1_Shop_Daughter();
        if (! $this->dublicateObjectLanguage($model, $id, $this->_sitePageData->shopMainID, false)) {
            throw new HTTP_Exception_404('Daughter not is found!');
        }

        $this->_requestDaughterWeights($model->getDaughterWeightID());

        // получаем данные
        $this->_sitePageData->newShopShablonPath('ab1/_all');
        View_View::findOne('DB_Ab1_Shop_Daughter',
            $this->_sitePageData->shopMainID, "_shop/daughter/one/edit",
            $this->_sitePageData, $this->_driverDB, array('id' => $id), array()
        );
        $this->_sitePageData->previousShopShablonPath();

        $this->_putInMain('/main/_shop/daughter/edit');
    }

    public function _actionShopClientContractItems()
    {
        // id записи
        $id = Request_RequestParams::getParamInt('id');
        $model = new Model_Ab1_Shop_Client_Contract();
        $this->getDBObject($model, $id, $this->_sitePageData->shopMainID);

        $clientContractTypeID = Request_RequestParams::getParamInt('client_contract_type_id');
        switch ($clientContractTypeID){
            case Model_Ab1_ClientContract_Type::CLIENT_CONTRACT_TYPE_SALE_PRODUCT:
                $this->_requestShopProductsBranches();
                $this->_requestShopProductRubrics();
                $this->_requestShopBranches(null, true);

                $file = 'product';
                break;
            case Model_Ab1_ClientContract_Type::CLIENT_CONTRACT_TYPE_BUY_MATERIAL:
                $this->_requestShopMaterials();

                $file = 'material';
                break;
            case Model_Ab1_ClientContract_Type::CLIENT_CONTRACT_TYPE_BUY_RAW:
                $this->_requestShopRaws();

                $file = 'raw';
                break;
            case Model_Ab1_ClientContract_Type::CLIENT_CONTRACT_TYPE_LEASE_CAR:
                $file = 'lease-car';
                break;
            case Model_Ab1_ClientContract_Type::CLIENT_CONTRACT_TYPE_TRANSPORTATION:
                $file = 'transportation';
                break;
            default:
                $file = 'item';
        }

        // продукция договора
        $params = Request_RequestParams::setParams(
            array(
                'shop_client_contract_id' => $id,
                'sort_by' => array('id' => 'asc'),
            )
        );

        $this->_sitePageData->newShopShablonPath('ab1/_all');
        $ids = Request_Request::find('DB_Ab1_Shop_Client_Contract_Item',
            $this->_sitePageData->shopMainID, $this->_sitePageData, $this->_driverDB, $params, 0, true
        );
        $ids->addAdditionDataChilds(['is_fixed_contract' => $model->getIsFixedContract()]);

        $this->_sitePageData->newShopShablonPath('ab1/_all');
        $result = Helpers_View::getViewObjects(
            $ids, new Model_Ab1_Shop_Client_Contract_Item(),
            '_shop/client/contract/item/list/'.$file, '_shop/client/contract/item/one/'.$file,
            $this->_sitePageData, $this->_driverDB, $this->_sitePageData->shopMainID
        );
        $this->_sitePageData->previousShopShablonPath();

        $this->response->body($result);
    }

    public function _actionShopClientContractNew()
    {

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/client/contract/one/new',
                'view::_shop/client/contract/item/list/item',
            )
        );

        $this->_requestClientContractStatuses();
        $this->_requestClientContractTypes();
        $this->_requestShopWorkers();
        $this->_requestListDB('DB_Currency', $this->_sitePageData->shop->getDefaultCurrencyID());
        $this->_requestListDB('DB_Ab1_ClientContract_View');
        $this->_requestListDB('DB_Ab1_Shop_Client_Contract_Storage');
        $this->_requestListDB('DB_Ab1_Shop_Department', $this->_sitePageData->operation->getShopDepartmentID());
        $this->_requestListDB('DB_Ab1_ClientContract_Kind');

        $this->_requestOrganizationTypes();
        $this->_requestKatos();

        switch (Request_RequestParams::getParamInt('client_contract_type_id')){
            case Model_Ab1_ClientContract_Type::CLIENT_CONTRACT_TYPE_SALE_PRODUCT:
                $this->_requestShopProductsBranches();
                $this->_requestShopProductRubrics();
                $this->_requestShopBranches(null, true);

                $file = 'product';
                break;
            case Model_Ab1_ClientContract_Type::CLIENT_CONTRACT_TYPE_BUY_MATERIAL:
                $this->_requestShopMaterials();

                $file = 'material';
                break;
            case Model_Ab1_ClientContract_Type::CLIENT_CONTRACT_TYPE_BUY_RAW:
                $this->_requestShopRaws();

                $file = 'raw';
                break;
            case Model_Ab1_ClientContract_Type::CLIENT_CONTRACT_TYPE_LEASE_CAR:
                $file = 'lease-car';
                break;
            case Model_Ab1_ClientContract_Type::CLIENT_CONTRACT_TYPE_TRANSPORTATION:
                $file = 'transportation';
                break;
            case Model_Ab1_ClientContract_Type::CLIENT_CONTRACT_TYPE_BUY_FUEL:
                $this->_requestListDB(DB_Ab1_Fuel::NAME);

                $file = 'fuel';
                break;
            default:
                $file = 'item';
        }

        $this->_sitePageData->newShopShablonPath('ab1/_all');

        $dataID = new MyArray();
        $dataID->id = 0;
        $dataID->isFindDB = TRUE;
        $this->_sitePageData->replaceDatas['view::_shop/client/contract/one/new'] = Helpers_View::getViewObject(
            $dataID, new Model_Ab1_Shop_Client_Contract(),
            '_shop/client/contract/one/new', $this->_sitePageData, $this->_driverDB
        );

        $dataID = new MyArray();
        $this->_sitePageData->replaceDatas['view::_shop/client/contract/item/list/item'] = Helpers_View::getViewObjects(
            $dataID, new Model_Ab1_Shop_Client_Contract_Item(),
            '_shop/client/contract/item/list/'.$file, '_shop/client/contract/item/one/'.$file,
            $this->_sitePageData, $this->_driverDB
        );
        $this->_sitePageData->previousShopShablonPath();

        $this->_putInMain('/main/_shop/client/contract/new');
    }

    public function _actionShopClientContractEdit()
    {
        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/client/contract/one/edit',
                'view::_shop/client/contract/item/list/item',
                'view::_shop/client/contract/list/agreement',
            )
        );

        // id записи
        $id = Request_RequestParams::getParamInt('id');
        $model = new Model_Ab1_Shop_Client_Contract();
        if (!$this->dublicateObjectLanguage($model, $id, $this->_sitePageData->shopMainID, FALSE)) {
            throw new HTTP_Exception_404('Client contract not is found!');
        }
        $model->getElement('client_contract_type_id', true);
        $model->getElement('shop_client_id', true, $this->_sitePageData->shopMainID);
        $model->getElement('basic_shop_client_contract_id', true, $this->_sitePageData->shopMainID);
        $model->getElement('shop_client_id', TRUE, $this->_sitePageData->shopMainID);

        $this->_requestClientContractStatuses($model->getClientContractStatusID());
        $this->_requestClientContractTypes($model->getClientContractTypeID());
        $this->_requestShopWorkers($model->getExecutorShopWorkerID());
        $this->_requestListDB('DB_Ab1_ClientContract_View', $model->getClientContractViewID());
        $this->_requestListDB('DB_Currency', $model->getCurrencyID());
        $this->_requestListDB('DB_Ab1_Shop_Client_Contract_Storage', $model->getShopClientContractStorageID(), -1);
        $this->_requestListDB('DB_Ab1_Shop_Department', $model->getShopDepartmentID());
        $this->_requestListDB('DB_Ab1_ClientContract_Kind', $model->getClientContractKindID());

        $this->_requestOrganizationTypes();
        $this->_requestKatos();

        switch ($model->getClientContractTypeID()){
            case Model_Ab1_ClientContract_Type::CLIENT_CONTRACT_TYPE_SALE_PRODUCT:
                $this->_requestShopProductsBranches();
                $this->_requestShopProductRubrics();
                $this->_requestShopBranches(null, true);

                $file = 'product';
                break;
            case Model_Ab1_ClientContract_Type::CLIENT_CONTRACT_TYPE_BUY_MATERIAL:
                $this->_requestShopMaterials();

                $file = 'material';
                break;
            case Model_Ab1_ClientContract_Type::CLIENT_CONTRACT_TYPE_BUY_RAW:
                $this->_requestShopRaws();

                $file = 'raw';
                break;
            case Model_Ab1_ClientContract_Type::CLIENT_CONTRACT_TYPE_LEASE_CAR:
                $file = 'lease-car';
                break;
            case Model_Ab1_ClientContract_Type::CLIENT_CONTRACT_TYPE_TRANSPORTATION:
                $file = 'transportation';
                break;
            case Model_Ab1_ClientContract_Type::CLIENT_CONTRACT_TYPE_BUY_FUEL:
                $this->_requestListDB(DB_Ab1_Fuel::NAME);

                $file = 'fuel';
                break;
            default:
                $file = 'item';
        }

        $this->_sitePageData->newShopShablonPath('ab1/_all');

        // продукция договора
        $params = Request_RequestParams::setParams(
            array(
                'shop_client_contract_id' => $id,
                'sort_by' => array('created_at' => 'asc'),
            )
        );

        $shopClientContractItemIDs = Request_Request::find(
            'DB_Ab1_Shop_Client_Contract_Item', $this->_sitePageData->shopMainID,
            $this->_sitePageData, $this->_driverDB, $params, 0, true,
            array(
                'shop_product_id' => array('name', 'unit', 'shop_id'),
                'shop_product_rubric_id' => array('name'),
                'shop_product_id.shop_id' => array('name', 'options'),
            )
        );

        $shopClientContractItemIDs->addAdditionDataChilds(['is_fixed_contract' => $model->getIsFixedContract()]);

        $result = Helpers_View::getViewObjects(
            $shopClientContractItemIDs, new Model_Ab1_Shop_Client_Contract_Item(),
            '_shop/client/contract/item/list/'.$file, '_shop/client/contract/item/one/'.$file,
            $this->_sitePageData, $this->_driverDB, $this->_sitePageData->shopMainID
        );
        $this->_sitePageData->replaceDatas['view::_shop/client/contract/item/list/item'] = $result;

        // доп. соглашения договора
        $params = Request_RequestParams::setParams(
            array(
                'basic_shop_client_contract_id' => $id,
                'sort_by' => array(
                    'shop_client_contract_id' => 'asc',
                    'id' => 'asc',
                ),
            )
        );

        $ids = Request_Request::find(
            'DB_Ab1_Shop_Client_Contract_Item',
            $this->_sitePageData->shopMainID, $this->_sitePageData, $this->_driverDB, $params, 0, true,
            array(
                'shop_client_contract_id' => array('id', 'number', 'from_at'),
                'product_shop_branch_id' => array('name'),
                'shop_product_rubric_id' => array('name'),
                'shop_product_id' => array('name'),
                'shop_raw_id' => array('name'),
                'shop_material_id' => array('name'),
                'fuel_id' => array('name'),
            )
        );

        $shopClientContractIDs = new MyArray();
        foreach ($ids->childs as $child){
            $contract = $child->values['shop_client_contract_id'];
            if(!key_exists($contract, $shopClientContractIDs->childs)){
                $tmp = new MyArray();
                $tmp->setIsFind(true);
                $tmp->values = $child->getElementValue('shop_client_contract_id', '', array());
                $shopClientContractIDs->childs[$contract] = $tmp;
            }
            $shopClientContractIDs->childs[$contract]->addChildObject($child);
        }

        $result = Helpers_View::getViewObjects(
            $shopClientContractIDs, new Model_Ab1_Shop_Client_Contract(),
            '_shop/client/contract/list/agreement/'.$file, '_shop/client/contract/one/agreement/'.$file,
            $this->_sitePageData, $this->_driverDB, $this->_sitePageData->shopMainID
        );
        $this->_sitePageData->replaceDatas['view::_shop/client/contract/list/agreement'] = $result;

        // получаем данные
        $dataID = new MyArray();
        $dataID->setValues($model, $this->_sitePageData);
        $dataID->setIsFind(true);
        $dataID->additionDatas['shop_client_contract_items'] = $shopClientContractItemIDs;
        $this->_sitePageData->replaceDatas['view::_shop/client/contract/one/edit'] = Helpers_View::getViewObject(
            $dataID, new Model_Ab1_Shop_Client_Contract(), '_shop/client/contract/one/edit',
            $this->_sitePageData, $this->_driverDB
        );

        $this->_sitePageData->previousShopShablonPath();

        $this->_putInMain('/main/_shop/client/contract/edit');
    }

    protected function _actionShopClientAttorneyEdit()
    {
        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/client/attorney/one/edit',
                'view::_shop/client/attorney/item/list/item',
            )
        );

        // id записи
        $id = Request_RequestParams::getParamInt('id');
        $model = new Model_Ab1_Shop_Client_Attorney();
        if (!$this->dublicateObjectLanguage($model, $id, -1, FALSE)) {
            throw new HTTP_Exception_404('Client attorney not is found!');
        }
        $this->_requestShopProducts();
        $this->_requestShopProductRubrics();
        $this->_requestShopClientContract($model->getShopClientID(), $model->getShopClientContractID(), 'list', null,
            Model_Ab1_ClientContract_Status::CLIENT_CONTRACT_STATUS_WORK);

        $this->_requestOrganizationTypes();
        $this->_requestKatos();
        $this->_requestBanks();

        $this->_sitePageData->newShopShablonPath('ab1/_all');
        $params = Request_RequestParams::setParams(
            array(
                'shop_client_attorney_id' => $id,
                'sort_by' => array('id' => 'asc'),
            )
        );
        View_View::find('DB_Ab1_Shop_Client_Attorney_Item',$this->_sitePageData->shopMainID, '_shop/client/attorney/item/list/item',
            '_shop/client/attorney/item/one/item', $this->_sitePageData, $this->_driverDB, $params);

        // получаем данные
        $model->getElement('shop_client_id', TRUE, $this->_sitePageData->shopMainID);
        $dataID = new MyArray();
        $dataID->setValues($model, $this->_sitePageData);
        $this->_sitePageData->replaceDatas['view::_shop/client/attorney/one/edit'] = Helpers_View::getViewObject($dataID, new Model_Ab1_Shop_Client_Attorney(),
            '_shop/client/attorney/one/edit', $this->_sitePageData, $this->_driverDB);

        $this->_sitePageData->previousShopShablonPath();

        $this->_putInMain('/main/_shop/client/attorney/edit');
    }

    protected function _actionShopClientAttorneyNew()
    {
        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/client/attorney/one/new',
                'view::_shop/client/attorney/item/list/item',
            )
        );

        $this->_requestShopProducts();
        $this->_requestShopProductRubrics();

        $this->_requestOrganizationTypes();
        $this->_requestKatos();
        $this->_requestBanks();

        $this->_sitePageData->newShopShablonPath('ab1/_all');

        $dataID = new MyArray();
        $dataID->id = 0;
        $dataID->isFindDB = TRUE;
        $this->_sitePageData->replaceDatas['view::_shop/client/attorney/one/new'] = Helpers_View::getViewObject($dataID, new Model_Ab1_Shop_Client_Attorney(),
            '_shop/client/attorney/one/new', $this->_sitePageData, $this->_driverDB);

        $dataID = new MyArray();
        $this->_sitePageData->replaceDatas['view::_shop/client/attorney/item/list/item'] = Helpers_View::getViewObjects($dataID,
            new Model_Ab1_Shop_Client_Attorney_Item(), '_shop/client/attorney/item/list/item',
            '_shop/client/attorney/item/one/item', $this->_sitePageData, $this->_driverDB);

        $this->_sitePageData->previousShopShablonPath();

        $this->_putInMain('/main/_shop/client/attorney/new');
    }

    protected function _actionShopActServiceEdit()
    {
        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/act/service/one/edit',
                'view::_shop/act/service/item/list/index',
                'view::_shop/act/service/item/list/addition-service',
            )
        );

        // id записи
        $id = Request_RequestParams::getParamInt('id');
        $model = new Model_Ab1_Shop_Act_Service();
        if (!$this->dublicateObjectLanguage($model, $id, -1, FALSE)) {
            throw new HTTP_Exception_404('Act service not is found!');
        }

        $this->_requestShopClientAttorney($model->getShopClientID(), NULL, 'list', $model->getDate());
        $this->_requestActServicePaidTypes($model->getActServicePaidTypeID());
        $this->_requestShopClientContract($model->getShopClientID(), $model->getShopClientContractID(), 'list', null,
            Model_Ab1_ClientContract_Status::CLIENT_CONTRACT_STATUS_WORK);
        $this->_requestShopClientAttorney($model->getShopClientID(), $model->getShopClientAttorneyID(), 'option', $model->getDate());
        $this->_requestShopDeliveryDepartments($model->getShopDeliveryDepartmentID());

        $params = Request_RequestParams::setParams(
            array(
                'shop_act_service_id' => $id,
            )
        );

        // получаем список реализации
        $shopCarIDs = Request_Request::find('DB_Ab1_Shop_Car',
            $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB,
            $params, 0, TRUE,
            array(
                'shop_delivery_id' => array('name'),
            )
        );
        $shopCarIDs->addAdditionDataChilds(array('is_car' => TRUE));

        $shopPieceIDs = Request_Request::find('DB_Ab1_Shop_Piece',
            $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB,
            $params, 0, TRUE,
            array(
                'shop_delivery_id' => array('name'),
            )
        );
        $shopPieceIDs->addAdditionDataChilds(array('is_piece' => TRUE));

        if (empty($shopCarIDs->childs)) {
            $shopCarIDs->childs = $shopPieceIDs->childs;
        } elseif (!empty($shopPieceIDs->childs)) {
            $shopCarIDs->childs = array_merge($shopCarIDs->childs, $shopPieceIDs->childs);
        }

        $shopCarIDs->childsSortBy(array(Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_delivery_id.name', 'quantity'));

        $this->_sitePageData->newShopShablonPath('ab1/_all');

        $this->_sitePageData->replaceDatas['view::_shop/act/service/item/list/index'] = Helpers_View::getViewObjects(
            $shopCarIDs, new Model_Ab1_Shop_Car(),
            '_shop/act/service/item/list/index', '_shop/act/service/item/one/index',
            $this->_sitePageData, $this->_driverDB
        );

        // список дополнительный услуг
        View_View::find('DB_Ab1_Shop_Addition_Service_Item',
            $this->_sitePageData->shopID,
            '_shop/act/service/item/list/addition-service', '_shop/act/service/item/one/addition-service',
            $this->_sitePageData, $this->_driverDB, $params,
            array(
                'shop_product_id' => array('name'),
                'shop_car_id' => array('ticket', 'name', 'id'),
                'shop_piece_id' => array('ticket', 'name', 'id'),
            )
        );

        // получаем данные
        View_View::findOne('DB_Ab1_Shop_Act_Service',
            $this->_sitePageData->shopID, "_shop/act/service/one/edit",
            $this->_sitePageData, $this->_driverDB, array('id' => $id),
            array(
                'shop_client_id',
                'shop_client_contract_id'
            )
        );

        $this->_sitePageData->previousShopShablonPath();

        $this->_putInMain('/main/_shop/act/service/edit');
    }

    protected function _actionShopInvoiceEdit()
    {
        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/invoice/one/edit',
                'view::_shop/invoice/item/list/index',
                'view::_shop/client/one/invoice-balance',
            )
        );

        // id записи
        $id = Request_RequestParams::getParamInt('id');
        $model = new Model_Ab1_Shop_Invoice();
        if (!$this->dublicateObjectLanguage($model, $id, -1, FALSE)) {
            throw new HTTP_Exception_404('Invoice not is found!');
        }

        $this->_requestShopClientAttorney($model->getShopClientID(), $model->getShopClientAttorneyID(), 'option');
        $this->_requestShopClientContract($model->getShopClientID(), $model->getShopClientContractID(), 'list', null,
            Model_Ab1_ClientContract_Status::CLIENT_CONTRACT_STATUS_WORK);
        $this->_requestShopClientAttorney($model->getShopClientID(), $model->getShopClientAttorneyID(), 'invoice');

        $this->_sitePageData->newShopShablonPath('ab1/_all');

        // балансы клиента
        View_View::findOne('DB_Ab1_Shop_Client',
            $this->_sitePageData->shopMainID, "_shop/client/one/invoice-balance",
            $this->_sitePageData, $this->_driverDB,
            Request_RequestParams::setParams(
                array('id' => $model->getShopClientID())
            )
        );

        $params = Request_RequestParams::setParams(
            array(
                'shop_invoice_id' => $id,
            )
        );

        // получаем список реализации
        $shopCarItemIDs = Request_Request::find('DB_Ab1_Shop_Car_Item',
            $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB,
            $params, 0, TRUE,
            array(
                'shop_product_id' => array('name'),
                'shop_car_id' => array('name', 'ticket'),
                'shop_invoice_id' => array('check_type_id'),
                'shop_product_time_price_id' => array('price'),
            )
        );

        $shopPieceItemIDs = Request_Request::find('DB_Ab1_Shop_Piece_Item',
            $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB,
            $params, 0, TRUE,
            array(
                'shop_product_id' => array('name'),
                'shop_piece_id' => array('name', 'ticket'),
                'shop_invoice_id' => array('check_type_id'),
                'shop_product_time_price_id' => array('price'),
            )
        );

        if(Request_RequestParams::getParamBoolean('is_all')) {
            if (empty($shopCarItemIDs->childs)) {
                $shopCarItemIDs->childs = $shopPieceItemIDs->childs;
            } elseif (!empty($shopPieceItemIDs->childs)) {
                $shopCarItemIDs->childs = array_merge($shopCarItemIDs->childs, $shopPieceItemIDs->childs);
            }
        }else{
            $arr = array();
            foreach ($shopCarItemIDs->childs as $child){
                $shopProductID = $child->values['shop_product_id'].'_'.$child->values['price'];
                if(!key_exists($shopProductID, $arr)){
                    $arr[$shopProductID] = $child;
                }else{
                    $arr[$shopProductID]->values['quantity'] += $child->values['quantity'];
                    $arr[$shopProductID]->values['amount'] += $child->values['amount'];
                }
            }
            foreach ($shopPieceItemIDs->childs as $child){
                $shopProductID = $child->values['shop_product_id'].'_'.$child->values['price'];
                if(!key_exists($shopProductID, $arr)){
                    $arr[$shopProductID] = $child;
                }else{
                    $arr[$shopProductID]->values['quantity'] += $child->values['quantity'];
                    $arr[$shopProductID]->values['amount'] += $child->values['amount'];
                }
            }

            $shopCarItemIDs->childs = $arr;
        }

        $shopCarItemIDs->childsSortBy(array(Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_product_id.name', 'shop_car_id', 'quantity'));

        $this->_sitePageData->replaceDatas['view::_shop/invoice/item/list/index'] = Helpers_View::getViewObjects(
            $shopCarItemIDs, new Model_Ab1_Shop_Car_Item(),
            '_shop/invoice/item/list/index', '_shop/invoice/item/one/index',
            $this->_sitePageData, $this->_driverDB
        );

        $model->getElement('shop_client_id', true, $this->_sitePageData->shopMainID);
        $model->getElement('shop_client_attorney_id', true, $this->_sitePageData->shopMainID);

        // получаем данные
        $objectID = new MyArray();
        $objectID->values = $model->getValues(true, true, $this->_sitePageData->shopMainID);
        $objectID->setIsFind();

        // балансы на момент создания накладной
        $dateTo = Helpers_DateTime::plusDays($model->getDate().' 06:00:00', 1);

        $balance = Api_Ab1_Shop_Client::calcBalance(
            $model->getShopClientID(), $this->_sitePageData, $this->_driverDB, $dateTo
        );
        $objectID->additionDatas = array(
            'balance_contract' => Api_Ab1_Shop_Client_Contract::calcBalance(
                $model->getShopClientContractID(), $this->_sitePageData, $this->_driverDB, $dateTo
            ),
            'balance_attorney' => Api_Ab1_Shop_Client_Attorney::calcBalance(
                $model->getShopClientAttorneyID(), $this->_sitePageData, $this->_driverDB, 0, $dateTo
            ),
            'balance_cash' => $balance['balance_cache'],
            'balance' => $balance['balance'],
        );

        $result = Helpers_View::getViewObject($objectID, $model, '_shop/invoice/one/edit',
            $this->_sitePageData, $this->_driverDB);
        $this->_sitePageData->replaceDatas['view::_shop/invoice/one/edit'] = $result;

        $this->_sitePageData->previousShopShablonPath();

        $this->_putInMain('/main/_shop/invoice/edit');
    }

    protected function _actionShopPricelistEdit()
    {
        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/pricelist/one/edit',
                'view::_shop/product-price/list/index',
            )
        );

        // id записи
        $id = Request_RequestParams::getParamInt('id');
        $model = new Model_Ab1_Shop_Pricelist();
        if (! $this->dublicateObjectLanguage($model, $id, $this->_sitePageData->shopMainID, FALSE)) {
            throw new HTTP_Exception_404('Pricelist not is found!');
        }

        $this->_requestShopProductsBranches(
            NULL, 0, NULL, FALSE,
            [
                Model_Ab1_ProductView::PRODUCT_TYPE_CAR,
                Model_Ab1_ProductView::PRODUCT_TYPE_CAR_AND_PIECE,
                Model_Ab1_ProductView::PRODUCT_TYPE_PIECE
            ]
        );

        $this->_requestOrganizationTypes();
        $this->_requestKatos();
        $this->_requestBanks();
        $this->_requestShopProductRubrics();
        $this->_requestShopBranches(null, true);

        $params = Request_RequestParams::setParams(
            array(
                'shop_pricelist_id' => $id,
                'sort_by' => array('id' => 'asc')
            )
        );

        $this->_sitePageData->newShopShablonPath('ab1/_all');

        View_View::find('DB_Ab1_Shop_Product_Price',
            $this->_sitePageData->shopMainID,
            '_shop/product-price/list/index', '_shop/product-price/one/index',
            $this->_sitePageData, $this->_driverDB, $params
        );

        // получаем данные
        View_View::findOne('DB_Ab1_Shop_Pricelist', $this->_sitePageData->shopMainID, "_shop/pricelist/one/edit",
            $this->_sitePageData, $this->_driverDB, array('id' => $id), array('shop_client_id'));

        $this->_sitePageData->previousShopShablonPath();

        $this->_putInMain('/main/_shop/pricelist/edit');
    }

    public function _actionShopPricelistNew()
    {
        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/pricelist/one/new',
                'view::_shop/product-price/list/index',
            )
        );

        $this->_requestShopProductsBranches(
            NULL, 0, NULL, FALSE,
            [
                Model_Ab1_ProductView::PRODUCT_TYPE_CAR,
                Model_Ab1_ProductView::PRODUCT_TYPE_CAR_AND_PIECE,
                Model_Ab1_ProductView::PRODUCT_TYPE_PIECE
            ]
        );

        $this->_requestOrganizationTypes();
        $this->_requestKatos();
        $this->_requestBanks();
        $this->_requestShopProductRubrics();
        $this->_requestShopBranches(null, true);

        $this->_sitePageData->newShopShablonPath('ab1/_all');

        $dataID = new MyArray();
        $dataID->id = 0;
        $dataID->isFindDB = TRUE;

        $this->_sitePageData->replaceDatas['view::_shop/product-price/list/index'] = Helpers_View::getViewObjects(
            $dataID, new Model_Ab1_Shop_Product(),
            '_shop/product-price/list/index', '_shop/product-price/one/index',
            $this->_sitePageData, $this->_driverDB, $this->_sitePageData->shopMainID
        );

        $dataID = new MyArray();
        $dataID->id = 0;
        $dataID->isFindDB = TRUE;

        $this->_sitePageData->replaceDatas['view::_shop/pricelist/one/new'] = Helpers_View::getViewObject(
            $dataID, new Model_Ab1_Shop_Pricelist(), '_shop/pricelist/one/new',
            $this->_sitePageData, $this->_driverDB, $this->_sitePageData->shopMainID
        );
        $this->_sitePageData->previousShopShablonPath();

        $this->_putInMain('/main/_shop/pricelist/new');
    }

    protected function _actionShopDeliveryDiscountEdit()
    {
        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/delivery/discount/one/edit',
                'view::_shop/delivery/discount/item/list/index',
            )
        );

        // id записи
        $id = Request_RequestParams::getParamInt('id');
        $model = new Model_Ab1_Shop_Delivery_Discount();
        if (! $this->dublicateObjectLanguage($model, $id, $this->_sitePageData->shopMainID, FALSE)) {
            throw new HTTP_Exception_404('Discount not is found!');
        }

        $this->_requestShopProductsBranches(
            NULL, 0, NULL, FALSE,
            [
                Model_Ab1_ProductView::PRODUCT_TYPE_CAR,
                Model_Ab1_ProductView::PRODUCT_TYPE_CAR_AND_PIECE,
                Model_Ab1_ProductView::PRODUCT_TYPE_PIECE
            ]
        );
        $this->_requestListDB('DB_Ab1_Shop_Delivery_Department');
        $this->_requestListDB('DB_Ab1_Shop_Delivery_Group');

        $this->_requestOrganizationTypes();
        $this->_requestKatos();
        $this->_requestBanks();
        $this->_requestShopProductRubrics();
        $this->_requestShopBranches(null, true);

        $params = Request_RequestParams::setParams(
            array(
                'shop_delivery_discount_id' => $id,
                'sort_by' => array('id' => 'asc')
            )
        );

        $this->_sitePageData->newShopShablonPath('ab1/_all');

        View_View::find('DB_Ab1_Shop_Delivery_Discount_Item',
            $this->_sitePageData->shopMainID,
            '_shop/delivery/discount/item/list/index', '_shop/delivery/discount/item/one/index',
            $this->_sitePageData, $this->_driverDB, $params
        );

        // получаем данные
        View_View::findOne('DB_Ab1_Shop_Delivery_Discount', $this->_sitePageData->shopMainID, "_shop/delivery/discount/one/edit",
            $this->_sitePageData, $this->_driverDB, array('id' => $id), array('shop_client_id'));

        $this->_sitePageData->previousShopShablonPath();

        $this->_putInMain('/main/_shop/delivery/discount/edit');
    }

    public function _actionShopDeliveryDiscountNew()
    {
        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/delivery/discount/one/edit',
                'view::_shop/delivery/discount/item/list/index',
            )
        );

        $this->_requestShopProductsBranches(
            NULL, 0, NULL, FALSE,
            [
                Model_Ab1_ProductView::PRODUCT_TYPE_CAR,
                Model_Ab1_ProductView::PRODUCT_TYPE_CAR_AND_PIECE,
                Model_Ab1_ProductView::PRODUCT_TYPE_PIECE
            ]
        );
        $this->_requestListDB('DB_Ab1_Shop_Delivery_Department');
        $this->_requestListDB('DB_Ab1_Shop_Delivery_Group');

        $this->_requestOrganizationTypes();
        $this->_requestKatos();
        $this->_requestBanks();
        $this->_requestShopProductRubrics();
        $this->_requestShopBranches(null, true);

        $this->_sitePageData->newShopShablonPath('ab1/_all');

        $dataID = new MyArray();
        $dataID->id = 0;
        $dataID->isFindDB = TRUE;

        $this->_sitePageData->replaceDatas['view::_shop/delivery/discount/item/list/index'] = Helpers_View::getViewObjects(
            $dataID, new Model_Ab1_Shop_Product(),
            '_shop/delivery/discount/item/list/index', '_shop/delivery/discount/item/one/index',
            $this->_sitePageData, $this->_driverDB, $this->_sitePageData->shopMainID
        );

        $dataID = new MyArray();
        $dataID->id = 0;
        $dataID->isFindDB = TRUE;

        $this->_sitePageData->replaceDatas['view::_shop/delivery/discount/one/new'] = Helpers_View::getViewObject(
            $dataID, new Model_Ab1_Shop_Pricelist(), '_shop/delivery/discount/one/new',
            $this->_sitePageData, $this->_driverDB, $this->_sitePageData->shopMainID
        );
        $this->_sitePageData->previousShopShablonPath();

        $this->_putInMain('/main/_shop/delivery/discount/new');
    }


    public function _actionShopPieceNew()
    {
        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/piece/one/new',
                'view::_shop/piece/item/list/index',
                'view::_shop/addition/service/item/list/index',
            )
        );

        // основная продукция
        $this->_requestShopProducts(
            NULL, 0, NULL, FALSE,
            [
                Model_Ab1_ProductView::PRODUCT_TYPE_CAR_AND_PIECE,
                Model_Ab1_ProductView::PRODUCT_TYPE_PIECE
            ]
        );
        // дополнительные услуги
        $this->_requestShopProducts(
            NULL, 0, NULL, FALSE,
            Model_Ab1_ProductView::PRODUCT_TYPE_ADDITION_SERVICE, 'addition-service'
        );
        $this->_requestShopDeliveries();

        $this->_requestOrganizationTypes();
        $this->_requestKatos();

        $this->_requestShopTransportCompanies();

        $this->_sitePageData->newShopShablonPath('ab1/_all');
        $dataID = new MyArray();
        $dataID->id = 0;
        $dataID->isFindDB = TRUE;
        $this->_sitePageData->replaceDatas['view::_shop/piece/item/list/index'] = Helpers_View::getViewObjects($dataID,
            new Model_Ab1_Shop_Piece_Item(), '_shop/piece/item/list/index',
            '_shop/piece/item/one/index', $this->_sitePageData, $this->_driverDB);

        // дополнительные услуги
        $dataID = new MyArray();
        $dataID->id = 0;
        $dataID->isFindDB = TRUE;
        $this->_sitePageData->replaceDatas['view::_shop/addition/service/item/list/index'] = Helpers_View::getViewObjects($dataID,
            new Model_Ab1_Shop_Addition_Service_Item(), '_shop/addition/service/item/list/index',
            '_shop/addition/service/item/one/index', $this->_sitePageData, $this->_driverDB);

        $dataID = new MyArray();
        $dataID->id = 0;
        $dataID->isFindDB = TRUE;
        $this->_sitePageData->replaceDatas['view::_shop/piece/one/new'] = Helpers_View::getViewObject($dataID, new Model_Ab1_Shop_Piece(),
            '_shop/piece/one/new', $this->_sitePageData, $this->_driverDB);
        $this->_sitePageData->previousShopShablonPath();

        $this->_putInMain('/main/_shop/piece/new');
    }

    protected function _actionShopPieceEdit()
    {
        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/piece/one/edit',
                'view::_shop/piece/item/list/index',
                'view::_shop/addition/service/item/list/index',
            )
        );

        // id записи
        $shopPieceID = Request_RequestParams::getParamInt('id');
        $model = new Model_Ab1_Shop_Piece();
        if (!$this->dublicateObjectLanguage($model, $shopPieceID, -1, false)) {
            throw new HTTP_Exception_404('Piece not is found!');
        }

        // дополнительные услуги
        $this->_requestShopProducts(
            NULL, 0, NULL, FALSE,
            Model_Ab1_ProductView::PRODUCT_TYPE_ADDITION_SERVICE, 'addition-service'
        );

        $this->_requestPaymentTypes(Model_Ab1_PaymentType::PAYMENT_TYPE_CASH);
        $this->_requestShopDeliveries($model->getShopDeliveryID());
        $this->_requestShopClientAttorney($model->getShopClientID(), $model->getShopClientAttorneyID(), 'option-balance');
        $this->_requestShopClientContract($model->getShopClientID(), $model->getShopClientContractID(), 'list', null,
            Model_Ab1_ClientContract_Status::CLIENT_CONTRACT_STATUS_WORK);

        $this->_requestOrganizationTypes();
        $this->_requestKatos();

        $this->_requestShopTransportCompanies($model->getShopTransportCompanyID());

        $params = Request_RequestParams::setParams(
            array(
                'shop_piece_id' => $shopPieceID,
                'sort_by'=>array('id'=>'asc'),
            )
        );
        $shopPieceItemIDs = Request_Request::find(
            'DB_Ab1_Shop_Piece_Item', $this->_sitePageData->shopID,
            $this->_sitePageData, $this->_driverDB, $params, 0, true
        );

        // основная продукция
        $this->_requestShopProducts(
            NULL, 0, NULL, FALSE,
            [
                Model_Ab1_ProductView::PRODUCT_TYPE_CAR_AND_PIECE,
                Model_Ab1_ProductView::PRODUCT_TYPE_PIECE
            ],
            'list', false,
            $shopPieceItemIDs->getChildArrayInt('shop_product_id', true)
        );

        $this->_sitePageData->newShopShablonPath('ab1/_all');

        $file = 'index';
        if(!$model->getIsOneAttorney() || Request_RequestParams::getParamBoolean('is_one_attorney') === false){
            $file = 'attorney';
        }

        $modelItem = new Model_Ab1_Shop_Piece_Item();
        $this->_sitePageData->replaceDatas['view::_shop/piece/item/list/index'] = Helpers_View::getViewObjects(
            $shopPieceItemIDs, $modelItem,
            '_shop/piece/item/list/'.$file, '_shop/piece/item/one/'.$file,
            $this->_sitePageData, $this->_driverDB, $this->_sitePageData->shopID
        );

        // дополнительные услуги
        View_View::find('DB_Ab1_Shop_Addition_Service_Item', $this->_sitePageData->shopID, '_shop/addition/service/item/list/index',
            '_shop/addition/service/item/one/index', $this->_sitePageData, $this->_driverDB, array('shop_piece_id' => $shopPieceID,
                'sort_by'=>array('value'=>array('id'=>'asc')), Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE));

        // получаем данные
        View_View::findOne('DB_Ab1_Shop_Piece', $this->_sitePageData->shopID, "_shop/piece/one/edit",
            $this->_sitePageData, $this->_driverDB, array('id' => $shopPieceID),
            array('shop_payment_id', 'shop_client_id', 'shop_client_attorney_id', 'shop_driver_id'));

        $this->_sitePageData->previousShopShablonPath();

        $this->_putInMain('/main/_shop/piece/edit');
    }

    protected function _actionMoveCarEdit()
    {
        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/move/car/one/edit',
            )
        );

        // id записи
        $shopMoveCarID = Request_RequestParams::getParamInt('id');
        $model = new Model_Ab1_Shop_Move_Car();
        if (! $this->dublicateObjectLanguage($model, $shopMoveCarID, -1, false)) {
            throw new HTTP_Exception_404('Car not is found!');
        }

        // основная продукция
        $this->_requestShopProducts(
            $model->getShopProductID(), 0, NULL, FALSE,
            [
                Model_Ab1_ProductView::PRODUCT_TYPE_CAR,
                Model_Ab1_ProductView::PRODUCT_TYPE_CAR_AND_PIECE,
                Model_Ab1_ProductView::PRODUCT_TYPE_PIECE
            ]
        );

        $model->dbGetElements($this->_sitePageData->shopMainID, array('shop_client_id'));
        $this->_requestShopMoveClients($model->getShopClientID());

        // получаем данные
        $this->_sitePageData->newShopShablonPath('ab1/_all');
        View_View::findOne('DB_Ab1_Shop_Move_Car', $this->_sitePageData->shopID, "_shop/move/car/one/edit",
            $this->_sitePageData, $this->_driverDB, array('id' => $shopMoveCarID),
            array('shop_payment_id', 'shop_client_id', 'shop_product_id', 'shop_driver_id'));
        $this->_sitePageData->previousShopShablonPath();

        $this->_putInMain('/main/_shop/move/car/edit');
    }


    protected function _actionDefectCarIndex() {
        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/defect/car/list/index',
            )
        );

        // основная продукция
        $this->_requestShopProducts(
            null, 0, NULL, FALSE,
            [
                Model_Ab1_ProductView::PRODUCT_TYPE_CAR,
                Model_Ab1_ProductView::PRODUCT_TYPE_CAR_AND_PIECE,
                Model_Ab1_ProductView::PRODUCT_TYPE_PIECE
            ]
        );

        if($this->_sitePageData->operation->getIsAdmin()) {
            $this->_requestShopOperations(Model_Ab1_Shop_Operation::RUBRIC_CASH);
        }

        // получаем список
        $this->_sitePageData->newShopShablonPath('ab1/_all');
        View_View::find('DB_Ab1_Shop_Defect_Car', $this->_sitePageData->shopID, "_shop/defect/car/list/index", "_shop/defect/car/one/index",
            $this->_sitePageData, $this->_driverDB, array('limit' => 1000, 'limit_page' => 25, 'is_exit' => 0),
            array('shop_client_id' => array('name'),
                'shop_product_id' => array('name'), 'shop_driver_id' => array('name'), 'shop_turn_id' => array('name')));
        $this->_sitePageData->previousShopShablonPath();

        $this->_putInMain('/main/_shop/defect/car/index', 'ab1/_all');
    }

    protected function _actionDefectCarHistory() {
        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/defect/car/list/history',
            )
        );

        // основная продукция
        $this->_requestShopProducts(
            null, 0, NULL, FALSE,
            [
                Model_Ab1_ProductView::PRODUCT_TYPE_CAR,
                Model_Ab1_ProductView::PRODUCT_TYPE_CAR_AND_PIECE,
                Model_Ab1_ProductView::PRODUCT_TYPE_PIECE
            ]
        );

        if($this->_sitePageData->operation->getIsAdmin()) {
            $this->_requestShopOperations(Model_Ab1_Shop_Operation::RUBRIC_ZHBIBC);

            // получаем список
            $this->_sitePageData->newShopShablonPath('ab1/_all');
            View_View::find('DB_Ab1_Shop_Defect_Car', $this->_sitePageData->shopID, "_shop/defect/car/list/history", "_shop/defect/car/one/history",
                $this->_sitePageData, $this->_driverDB,
                array(
                    'limit' => 1000,
                    'limit_page' => 25,
                    'is_exit' => 1,
                    'shop_subdivision_id' => $this->_sitePageData->operation->getProductShopSubdivisionIDsArray(),
                ),
                array('shop_client_id' => array('name'), 'shop_product_id' => array('name'), 'shop_driver_id' => array('name'),
                    'cash_operation_id' => array('name'), 'shop_turn_place_id' => array('name')));
            $this->_sitePageData->previousShopShablonPath();
        }else{
            // получаем список
            $this->_sitePageData->newShopShablonPath('ab1/_all');
            View_View::find('DB_Ab1_Shop_Defect_Car', $this->_sitePageData->shopID, "_shop/defect/car/list/history", "_shop/defect/car/one/history",
                $this->_sitePageData, $this->_driverDB,
                array(
                    'limit' => 1000,
                    'limit_page' => 25,
                    'is_exit' => 1,
                    'shop_subdivision_id' => $this->_sitePageData->operation->getProductShopSubdivisionIDsArray(),
                ),
                array('shop_client_id' => array('name'), 'shop_product_id' => array('name'), 'shop_driver_id' => array('name'),
                    'cash_operation_id' => array('name'), 'shop_turn_place_id' => array('name')));
            $this->_sitePageData->previousShopShablonPath();
        }

        $this->_putInMain('/main/_shop/defect/car/history', 'ab1/_all');

    }


    protected function _actionDefectCarNew()
    {
        $this->_sitePageData->url = '/cash/shopdefectcar/new';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/defect/car/one/new',
            )
        );

        // основная продукция
        $this->_requestShopProducts(
            null, 0, NULL, FALSE,
            [
                Model_Ab1_ProductView::PRODUCT_TYPE_CAR,
                Model_Ab1_ProductView::PRODUCT_TYPE_CAR_AND_PIECE,
                Model_Ab1_ProductView::PRODUCT_TYPE_PIECE
            ]
        );

        $dataID = new MyArray();
        $dataID->id = 0;
        $dataID->isFindDB = TRUE;

        $this->_sitePageData->newShopShablonPath('ab1/_all');
        $this->_sitePageData->replaceDatas['view::_shop/defect/car/one/new'] = Helpers_View::getViewObject($dataID, new Model_Ab1_Shop_Defect_Car(),
            '_shop/defect/car/one/new', $this->_sitePageData, $this->_driverDB);
        $this->_sitePageData->previousShopShablonPath();

        $this->_putInMain('/main/_shop/defect/car/new', 'ab1/_all');
    }

    protected function _actionDefectCarEdit()
    {
        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/defect/car/one/edit',
            )
        );

        // id записи
        $shopDefectCarID = Request_RequestParams::getParamInt('id');
        $model = new Model_Ab1_Shop_Defect_Car();
        if (! $this->dublicateObjectLanguage($model, $shopDefectCarID, -1, false)) {
            throw new HTTP_Exception_404('Car not is found!');
        }

        // основная продукция
        $this->_requestShopProducts(
            $model->getShopProductID(), 0, NULL, FALSE,
            [
                Model_Ab1_ProductView::PRODUCT_TYPE_CAR,
                Model_Ab1_ProductView::PRODUCT_TYPE_CAR_AND_PIECE,
                Model_Ab1_ProductView::PRODUCT_TYPE_PIECE
            ]
        );

        $model->dbGetElements($this->_sitePageData->shopMainID, array('shop_client_id'));

        // получаем данные
        $this->_sitePageData->newShopShablonPath('ab1/_all');
        View_View::findOne('DB_Ab1_Shop_Defect_Car', $this->_sitePageData->shopID, "_shop/defect/car/one/edit",
            $this->_sitePageData, $this->_driverDB, array('id' => $shopDefectCarID),
            array('shop_client_id', 'shop_product_id', 'shop_driver_id'));
        $this->_sitePageData->previousShopShablonPath();

        $this->_putInMain('/main/_shop/defect/car/edit', 'ab1/_all');
    }

    protected function _actionLesseeCarEdit()
    {
        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/lessee/car/one/edit',
            )
        );

        // id записи
        $id = Request_RequestParams::getParamInt('id');
        $model = new Model_Ab1_Shop_Lessee_Car();
        if (! $this->dublicateObjectLanguage($model, $id, -1, false)) {
            throw new HTTP_Exception_404('Car not is found!');
        }
        $model->dbGetElements($this->_sitePageData->shopMainID, array('shop_client_id'));

        // основная продукция
        $this->_requestShopProducts(
            $model->getShopProductID(), 0, NULL, FALSE,
            [
                Model_Ab1_ProductView::PRODUCT_TYPE_CAR,
                Model_Ab1_ProductView::PRODUCT_TYPE_CAR_AND_PIECE,
            ]
        );

        $this->_requestShopClients($model->getShopClientID(), Model_Ab1_ClientType::CLIENT_TYPE_LESSEE);

        // получаем данные
        $this->_sitePageData->newShopShablonPath('ab1/_all');
        View_View::findOne('DB_Ab1_Shop_Lessee_Car', $this->_sitePageData->shopID, "_shop/lessee/car/one/edit",
            $this->_sitePageData, $this->_driverDB, array('id' => $id),
            array('shop_payment_id', 'shop_client_id', 'shop_product_id', 'shop_driver_id'));
        $this->_sitePageData->previousShopShablonPath();

        $this->_putInMain('/main/_shop/lessee/car/edit');
    }

    public function _actionShopCarToMaterialNew()
    {
        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/car/to/material/one/new',
            )
        );

        $this->_requestShopMaterials();
        $this->_requestShopDaughters();
        $this->_requestShopBranches(NULL, TRUE);
        $this->_requestShopCarTares(null, Model_Ab1_TareType::TARE_TYPE_OUR);
        $this->_requestShopTransportCompanies();

        $dataID = new MyArray();
        $dataID->id = 0;
        $dataID->isFindDB = TRUE;

        $this->_sitePageData->newShopShablonPath('ab1/_all');
        $this->_sitePageData->replaceDatas['view::_shop/car/to/material/one/new'] = Helpers_View::getViewObject(
            $dataID, new Model_Ab1_Shop_Car_To_Material(),
            '_shop/car/to/material/one/new',
            $this->_sitePageData, $this->_driverDB, $this->_sitePageData->shopID
        );
        $this->_sitePageData->previousShopShablonPath();

        $this->_putInMain('/main/_shop/car/to/material/new');
    }

    protected function _actionShopCarToMaterialEdit()
    {
        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/car/to/material/one/edit',
            )
        );

        // id записи
        $shopCarToMaterialID = Request_RequestParams::getParamInt('id');
        $model = new Model_Ab1_Shop_Car_To_Material();
        if (! $this->dublicateObjectLanguage($model, $shopCarToMaterialID, $this->_sitePageData->shopMainID, FALSE)) {
            throw new HTTP_Exception_404('Car to material not is found!');
        }

        $this->_requestShopMaterials($model->getShopMaterialID());
        $this->_requestShopBranches(NULL, TRUE);
        $this->_requestShopDaughters($model->getShopDaughterID());
        $this->_requestShopCarTares($model->getShopCarTareID(), Model_Ab1_TareType::TARE_TYPE_OUR);
        $this->_requestShopTransportCompanies($model->getShopTransportCompanyID());
        $this->_requestShopSubdivisions($model->getShopSubdivisionReceiverID(), $model->getShopBranchReceiverID(), '/receiver');
        $this->_requestShopSubdivisions($model->getShopSubdivisionDaughterID(), $model->getShopBranchDaughterID(), '/daughter');
        $this->_requestShopHeaps($model->getShopHeapReceiverID(), $model->getShopBranchReceiverID(), '/receiver', $model->getShopSubdivisionReceiverID());
        $this->_requestShopHeaps($model->getShopHeapDaughterID(), $model->getShopBranchDaughterID(), '/daughter', $model->getShopSubdivisionDaughterID());

        // получаем данные
        $this->_sitePageData->newShopShablonPath('ab1/_all');
        View_View::findOne('DB_Ab1_Shop_Car_To_Material', $this->_sitePageData->shopMainID, "_shop/car/to/material/one/edit",
            $this->_sitePageData, $this->_driverDB, array('id' => $shopCarToMaterialID),
            array('shop_daughter_id', 'shop_material_id', 'shop_driver_id'));
        $this->_sitePageData->previousShopShablonPath();

        $this->_putInMain('/main/_shop/car/to/material/edit');
    }

    public function _actionShopCarNew()
    {
        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/car/one/new',
                'view::_shop/addition/service/item/list/index',
            )
        );

        // основная продукция
        $this->_requestShopProducts(
            NULL, 0, NULL, FALSE,
            [
                Model_Ab1_ProductView::PRODUCT_TYPE_CAR,
                Model_Ab1_ProductView::PRODUCT_TYPE_CAR_AND_PIECE,
            ]
        );
        // дополнительные услуги
        $this->_requestShopProducts(
            NULL, 0, NULL, FALSE,
            Model_Ab1_ProductView::PRODUCT_TYPE_ADDITION_SERVICE, 'addition-service'
        );

        $this->_requestShopDeliveries();
        $this->_requestOrganizationTypes();
        $this->_requestKatos();

        $this->_sitePageData->newShopShablonPath('ab1/_all');
        // дополнительные услуги
        $dataID = new MyArray();
        $dataID->id = 0;
        $dataID->isFindDB = TRUE;
        $this->_sitePageData->replaceDatas['view::_shop/addition/service/item/list/index'] = Helpers_View::getViewObjects($dataID,
            new Model_Ab1_Shop_Addition_Service_Item(), '_shop/addition/service/item/list/index',
            '_shop/addition/service/item/one/index', $this->_sitePageData, $this->_driverDB);

        $dataID = new MyArray();
        $dataID->id = 0;
        $dataID->isFindDB = TRUE;
        $this->_sitePageData->replaceDatas['view::_shop/car/one/new'] = Helpers_View::getViewObject($dataID, new Model_Ab1_Shop_Car(),
            '_shop/car/one/new', $this->_sitePageData, $this->_driverDB);
        $this->_sitePageData->previousShopShablonPath();

        $this->_putInMain('/main/_shop/car/new');
    }

    protected function _actionShopCarEdit()
    {
        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/car/one/edit',
                'view::_shop/addition/service/item/list/index',
            )
        );

        // id записи
        $id = Request_RequestParams::getParamInt('id');
        $model = new Model_Ab1_Shop_Car();
        if (! $this->dublicateObjectLanguage($model, $id, -1, false)) {
            throw new HTTP_Exception_404('Car not id "'.$id.'" is found! #03072020');
        }

        $model->dbGetElements($this->_sitePageData->shopMainID, array('shop_client_id'));

        // основная продукция
        $this->_requestShopProducts(
            $model->getShopProductID(), 0, NULL, FALSE,
            [
                Model_Ab1_ProductView::PRODUCT_TYPE_CAR,
                Model_Ab1_ProductView::PRODUCT_TYPE_CAR_AND_PIECE,
            ]
        );
        // дополнительные услуги
        $this->_requestShopProducts(
            NULL, 0, NULL, FALSE,
            Model_Ab1_ProductView::PRODUCT_TYPE_ADDITION_SERVICE, 'addition-service'
        );

        $this->_requestPaymentTypes(Model_Ab1_PaymentType::PAYMENT_TYPE_CASH);
        $this->_requestShopDeliveries($model->getShopDeliveryID());
        $this->_requestShopClientAttorney($model->getShopClientID(), $model->getShopClientAttorneyID(), 'option-balance');
        $this->_requestShopClientContract($model->getShopClientID(), $model->getShopClientContractID(), 'list', null,
            Model_Ab1_ClientContract_Status::CLIENT_CONTRACT_STATUS_WORK);

        $this->_requestOrganizationTypes();
        $this->_requestKatos();

        if($this->_sitePageData->operation->getIsAdmin()){
            $this->_requestShopTransportCompanies($model->getShopTransportCompanyID());
            $this->_requestShopTurnPlaces($model->getShopTurnPlaceID());
            $this->_requestShopStorages($model->getShopStorageID(), 0, FALSE, $model->getShopSubdivisionID());
        }

        // получаем данные
        $this->_sitePageData->newShopShablonPath('ab1/_all');
        View_View::findOne('DB_Ab1_Shop_Car', $this->_sitePageData->shopID, "_shop/car/one/edit",
            $this->_sitePageData, $this->_driverDB, array('id' => $id),
            array('shop_payment_id', 'shop_client_id', 'shop_client_attorney_id', 'shop_product_id', 'shop_driver_id'));

        // дополнительные услуги
        View_View::find('DB_Ab1_Shop_Addition_Service_Item', $this->_sitePageData->shopID, '_shop/addition/service/item/list/index',
            '_shop/addition/service/item/one/index', $this->_sitePageData, $this->_driverDB, array('shop_car_id' => $id,
                'sort_by'=>array('value'=>array('id'=>'asc')), Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE));
        $this->_sitePageData->previousShopShablonPath();

        $this->_putInMain('/main/_shop/car/edit');
    }

    protected function _actionShopTransportStatistics()
    {
        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/transport/list/statistics',
            )
        );

        $isAllBranch = Request_RequestParams::getParamInt('shop_branch_id') == -1;
        $this->_requestShopBranches($this->_sitePageData->shopID, TRUE);
        if($isAllBranch){
            $shopIDs = [];
        }else{
            $shopIDs = [$this->_sitePageData->shopID];
        }

        // задаем время выборки с начала дня
        $dateFrom = date('Y-m-d');
        $listIDs = new MyArray();
        $params = Request_RequestParams::setParams(
            array(
                'date' => $dateFrom,
                'group_by' => array(
                    'shop_transport_id.shop_transport_mark_id',
                    'shop_transport_id.shop_transport_mark_id.transport_view_id',
                    'shop_transport_id.shop_transport_mark_id.transport_view_id.name',
                ),
            )
        );
        $elements = array(
            'shop_transport_id.shop_transport_mark_id.transport_view_id' => array('name'),
        );

        $resultArray = array(
            'count_day' => 0,
            'count_yesterday' => 0,
            'count_week' => 0,
            'count_month' => 0,
            'count_month_previous' => 0,
            'count_year' => 0,

            'repair_day' => 0,
            'repair_yesterday' => 0,
            'repair_week' => 0,
            'repair_month' => 0,
            'repair_month_previous' => 0,
            'repair_year' => 0,

            'count_all' => 0,
        );

        // задаем время выборки сегодня
        $ids = Request_Request::findBranch('DB_Ab1_Shop_Transport_Waybill',
            $shopIDs, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
            $elements
        );
        foreach ($ids->childs as $child){
            $view = $child->getElementValue('shop_transport_mark_id', 'transport_view_id');
            if(!key_exists($view, $listIDs->childs)){
                $new = new MyArray();
                $new->cloneObj($child);
                $new->additionDatas = $resultArray;
                $listIDs->childs[$view] = $new;
            }
            $listIDs->childs[$view]->additionDatas['count_day'] ++;
        }

        // ремонт
        $ids = Request_Request::findBranch('DB_Ab1_Shop_Transport_Repair',
            $shopIDs, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
            $elements
        );
        foreach ($ids->childs as $child){
            $view = $child->getElementValue('shop_transport_mark_id', 'transport_view_id');
            if(!key_exists($view, $listIDs->childs)){
                $new = new MyArray();
                $new->cloneObj($child);
                $new->additionDatas = $resultArray;
                $listIDs->childs[$view] = $new;
            }
            $listIDs->childs[$view]->additionDatas['repair_day'] ++;
        }

        // задаем время выборки вчера
        $dateFrom = Helpers_DateTime::minusDays($dateFrom, 1);
        $params['date'] = $dateFrom;

        $ids = Request_Request::findBranch('DB_Ab1_Shop_Transport_Waybill',
            $shopIDs, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
            $elements
        );
        foreach ($ids->childs as $child){
            $view = $child->getElementValue('shop_transport_mark_id', 'transport_view_id');
            if(!key_exists($view, $listIDs->childs)){
                $new = new MyArray();
                $new->cloneObj($child);
                $new->additionDatas = $resultArray;
                $listIDs->childs[$view] = $new;
            }
            $listIDs->childs[$view]->additionDatas['count_yesterday'] ++;
        }

        // ремонт
        $ids = Request_Request::findBranch('DB_Ab1_Shop_Transport_Repair',
            $shopIDs, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
            $elements
        );
        foreach ($ids->childs as $child){
            $view = $child->getElementValue('shop_transport_mark_id', 'transport_view_id');
            if(!key_exists($view, $listIDs->childs)){
                $new = new MyArray();
                $new->cloneObj($child);
                $new->additionDatas = $resultArray;
                $listIDs->childs[$view] = $new;
            }
            $listIDs->childs[$view]->additionDatas['repair_yesterday'] ++;
        }

        // задаем время выборки неделя
        $dateFrom = Helpers_DateTime::getWeekBeginStr(date('Y-m-d'));
        $params['date'] = $dateFrom;

        $ids = Request_Request::findBranch('DB_Ab1_Shop_Transport_Waybill',
            $shopIDs, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
            $elements
        );
        foreach ($ids->childs as $child){
            $view = $child->getElementValue('shop_transport_mark_id', 'transport_view_id');
            if(!key_exists($view, $listIDs->childs)){
                $new = new MyArray();
                $new->cloneObj($child);
                $new->additionDatas = $resultArray;
                $listIDs->childs[$view] = $new;
            }
            $listIDs->childs[$view]->additionDatas['count_week'] ++;
        }

        // ремонт
        $ids = Request_Request::findBranch('DB_Ab1_Shop_Transport_Repair',
            $shopIDs, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
            $elements
        );
        foreach ($ids->childs as $child){
            $view = $child->getElementValue('shop_transport_mark_id', 'transport_view_id');
            if(!key_exists($view, $listIDs->childs)){
                $new = new MyArray();
                $new->cloneObj($child);
                $new->additionDatas = $resultArray;
                $listIDs->childs[$view] = $new;
            }
            $listIDs->childs[$view]->additionDatas['repair_week'] ++;
        }

        // задаем время выборки месяц
        $dateFrom = Helpers_DateTime::getMonthBeginStr(date('m'), date('Y'));
        $params['date'] = $dateFrom;

        $ids = Request_Request::findBranch('DB_Ab1_Shop_Transport_Waybill',
            $shopIDs, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
            $elements
        );
        foreach ($ids->childs as $child){
            $view = $child->getElementValue('shop_transport_mark_id', 'transport_view_id');
            if(!key_exists($view, $listIDs->childs)){
                $new = new MyArray();
                $new->cloneObj($child);
                $new->additionDatas = $resultArray;
                $listIDs->childs[$view] = $new;
            }
            $listIDs->childs[$view]->additionDatas['count_month'] ++;
        }

        // ремонт
        $ids = Request_Request::findBranch('DB_Ab1_Shop_Transport_Repair',
            $shopIDs, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
            $elements
        );
        foreach ($ids->childs as $child){
            $view = $child->getElementValue('shop_transport_mark_id', 'transport_view_id');
            if(!key_exists($view, $listIDs->childs)){
                $new = new MyArray();
                $new->cloneObj($child);
                $new->additionDatas = $resultArray;
                $listIDs->childs[$view] = $new;
            }
            $listIDs->childs[$view]->additionDatas['repair_month'] ++;
        }

        // задаем время выборки прошлый месяц
        $dateFrom = Helpers_DateTime::minusMonth(Helpers_DateTime::getMonthBeginStr(date('m'), date('Y')), 1, true);
        $params['date'] = $dateFrom;

        $ids = Request_Request::findBranch('DB_Ab1_Shop_Transport_Waybill',
            $shopIDs, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
            $elements
        );
        foreach ($ids->childs as $child){
            $view = $child->getElementValue('shop_transport_mark_id', 'transport_view_id');
            if(!key_exists($view, $listIDs->childs)){
                $new = new MyArray();
                $new->cloneObj($child);
                $new->additionDatas = $resultArray;
                $listIDs->childs[$view] = $new;
            }
            $listIDs->childs[$view]->additionDatas['count_month_previous'] ++;
        }

        // ремонт
        $ids = Request_Request::findBranch('DB_Ab1_Shop_Transport_Repair',
            $shopIDs, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
            $elements
        );
        foreach ($ids->childs as $child){
            $view = $child->getElementValue('shop_transport_mark_id', 'transport_view_id');
            if(!key_exists($view, $listIDs->childs)){
                $new = new MyArray();
                $new->cloneObj($child);
                $new->additionDatas = $resultArray;
                $listIDs->childs[$view] = $new;
            }
            $listIDs->childs[$view]->additionDatas['repair_month_previous'] ++;
        }

        // задаем время выборки за год
        $dateFrom = Helpers_DateTime::getYearBeginStr(date('Y'));
        $params['date'] = $dateFrom;

        $ids = Request_Request::findBranch('DB_Ab1_Shop_Transport_Waybill',
            $shopIDs, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
            $elements
        );
        foreach ($ids->childs as $child){
            $view = $child->getElementValue('shop_transport_mark_id', 'transport_view_id');
            if(!key_exists($view, $listIDs->childs)){
                $new = new MyArray();
                $new->cloneObj($child);
                $new->additionDatas = $resultArray;
                $listIDs->childs[$view] = $new;
            }
            $listIDs->childs[$view]->additionDatas['count_year'] ++;
        }

        // ремонт
        $ids = Request_Request::findBranch('DB_Ab1_Shop_Transport_Repair',
            $shopIDs, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
            $elements
        );
        foreach ($ids->childs as $child){
            $view = $child->getElementValue('shop_transport_mark_id', 'transport_view_id');
            if(!key_exists($view, $listIDs->childs)){
                $new = new MyArray();
                $new->cloneObj($child);
                $new->additionDatas = $resultArray;
                $listIDs->childs[$view] = $new;
            }
            $listIDs->childs[$view]->additionDatas['repair_year'] ++;
        }

        $params = Request_RequestParams::setParams(
            [
                'count_id' => true,
                'shop_branch_storage_id' => $this->_sitePageData->shopID,
                'group_by' => [
                    'shop_transport_mark_id.transport_view_id.name',
                    'shop_transport_mark_id.transport_view_id',
                ]
            ]
        );
        $elements = array(
            'shop_transport_mark_id.transport_view_id' => array('name'),
        );

        // список всех машин
        $ids = Request_Request::find('DB_Ab1_Shop_Transport',
            0,$this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
            $elements
        );
        foreach ($ids->childs as $child){
            $view = $child->getElementValue('shop_transport_mark_id','transport_view_id');
            if(!key_exists($view, $listIDs->childs)){
                $new = new MyArray();
                $new->cloneObj($child);
                $new->additionDatas = $resultArray;
                $listIDs->childs[$view] = $new;
            }
            $listIDs->childs[$view]->additionDatas['count_all'] = $child->values['count'];
        }

        // итог
        $listIDs->additionDatas = $listIDs->calcTotalsChild(
            array(
                'count_day',
                'count_yesterday',
                'count_week',
                'count_month',
                'count_month_previous',
                'count_year',
                'repair_day',
                'repair_yesterday',
                'repair_week',
                'repair_month',
                'repair_month_previous',
                'repair_year',
                'count_all',
            ),
            true
        );

        $listIDs->childsSortBy(
            Request_RequestParams::getParamArray('sort_by', [], array('transport_view_id.name' => 'asc')),
            true, true
        );


        $this->_sitePageData->countRecord = count($listIDs->childs);

        $this->_sitePageData->newShopShablonPath('ab1/_all');
        $this->_sitePageData->replaceDatas['view::_shop/transport/list/statistics'] = Helpers_View::getViewObjects(
            $listIDs, new Model_Ab1_Shop_Product_Rubric(),
            '_shop/transport/list/statistics','_shop/transport/one/statistics',
            $this->_sitePageData, $this->_driverDB
        );
        $this->_sitePageData->previousShopShablonPath();

        $this->_putInMain('/main/_shop/transport/statistics');
    }

    protected function _actionShopLesseeCarStatistics()
    {
        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/lessee/car/list/statistics',
            )
        );

        $isAllBranch = Request_RequestParams::getParamInt('shop_branch_id') == -1;
        $this->_requestShopBranches($this->_sitePageData->shopID, TRUE);

        // задаем время выборки с начала дня
        $dateFrom = date('Y-m-d').' 06:00:00';
        $listIDs = new MyArray();
        $params = Request_RequestParams::setParams(
            array(
                'is_exit' => 1,
                'exit_at_from' => $dateFrom,
                'sum_quantity' => TRUE,
                'is_charity' => FALSE,
                'group_by' => array(
                    'shop_client_id',
                    'shop_client_id.name',
                    'shop_client_id.balance',
                    'shop_product_id',
                    'shop_product_id.name',
                    'shop_product_id.volume',
                ),
            )
        );
        $elements = array(
            'shop_client_id' => array('name', 'balance'),
            'shop_product_id' => array('name', 'volume')
        );

        $resultArray = array(
            'quantity_day' => 0,
            'quantity_yesterday' => 0,
            'quantity_week' => 0,
            'quantity_month' => 0,
            'quantity_month_previous' => 0,
            'quantity_year' => 0,
        );

        if($isAllBranch) {
            $ids = Request_Request::findBranch('DB_Ab1_Shop_Lessee_Car',
                array(), $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
                $elements
            );
        }else{
            $ids = Request_Request::find('DB_Ab1_Shop_Lessee_Car',
                $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
                $elements
            );
        }
        foreach ($ids->childs as $child){
            $shopClientID = $child->values['shop_client_id'];
            if(!key_exists($shopClientID, $listIDs->childs)){
                $child->additionDatas = $resultArray;
                $listIDs->childs[$shopClientID] = $child;
            }

            $listIDs->childs[$shopClientID]->additionDatas['quantity_day'] += $child->values['quantity'];
        }

        // задаем время выборки вчера
        $paramsYesterday = $params;
        $paramsYesterday['exit_at_to'] = $dateFrom;
        $dateFrom = Helpers_DateTime::minusDays($dateFrom, 1);
        $paramsYesterday['exit_at_from'] = $dateFrom;

        if($isAllBranch) {
            $ids = Request_Request::findBranch('DB_Ab1_Shop_Lessee_Car',
                array(), $this->_sitePageData, $this->_driverDB, $paramsYesterday, 0, TRUE,
                $elements
            );
        }else{
            $ids = Request_Request::find('DB_Ab1_Shop_Lessee_Car',
                $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB, $paramsYesterday, 0, TRUE,
                $elements
            );
        }
        foreach ($ids->childs as $child){
            $shopClientID = $child->values['shop_client_id'];
            if(!key_exists($shopClientID, $listIDs->childs)){
                $child->additionDatas = $resultArray;
                $listIDs->childs[$shopClientID] = $child;
            }

            $listIDs->childs[$shopClientID]->additionDatas['quantity_yesterday'] +=
                $child->values['quantity'];
        }

        // задаем время выборки с начала недели
        $dateFrom = Helpers_DateTime::getWeekBeginStr(date('Y-m-d')).' 06:00:00';
        $params['exit_at_from'] = $dateFrom;

        if($isAllBranch) {
            $ids = Request_Request::findBranch('DB_Ab1_Shop_Lessee_Car',
                array(), $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
                $elements
            );
        }else{
            $ids = Request_Request::find('DB_Ab1_Shop_Lessee_Car',
                $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
                $elements
            );
        }
        foreach ($ids->childs as $child){
            $shopClientID = $child->values['shop_client_id'];
            if(!key_exists($shopClientID, $listIDs->childs)){
                $child->additionDatas = $resultArray;
                $listIDs->childs[$shopClientID] = $child;
            }

            $listIDs->childs[$shopClientID]->additionDatas['quantity_week'] +=
                $child->values['quantity'];
        }

        // задаем время выборки с начала месяца
        $dateFrom = Helpers_DateTime::getMonthBeginStr(date('m'), date('Y')).' 06:00:00';
        $params['exit_at_from'] = $dateFrom;

        if($isAllBranch) {
            $ids = Request_Request::findBranch('DB_Ab1_Shop_Lessee_Car',
                array(), $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
                $elements
            );
        }else{
            $ids = Request_Request::find('DB_Ab1_Shop_Lessee_Car',
                $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
                $elements
            );
        }
        foreach ($ids->childs as $child){
            $shopClientID = $child->values['shop_client_id'];
            if(!key_exists($shopClientID, $listIDs->childs)){
                $child->additionDatas = $resultArray;
                $listIDs->childs[$shopClientID] = $child;
            }

            $listIDs->childs[$shopClientID]->additionDatas['quantity_month'] +=
                $child->values['quantity'];
        }

        // задаем время выборки с предыдущего месяца
        $paramsPreviousMonth = $params;
        $tmp = Helpers_DateTime::getMonthBeginStr(date('m'), date('Y')).' 06:00:00';
        $paramsPreviousMonth['exit_at_to'] = $tmp;
        $paramsPreviousMonth['exit_at_from'] = Helpers_DateTime::minusMonth($tmp, 1, true);

        if($isAllBranch) {
            $ids = Request_Request::findBranch('DB_Ab1_Shop_Lessee_Car',
                array(), $this->_sitePageData, $this->_driverDB, $paramsPreviousMonth, 0, TRUE,
                $elements
            );
        }else{
            $ids = Request_Request::find('DB_Ab1_Shop_Lessee_Car',
                $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB, $paramsPreviousMonth, 0, TRUE,
                $elements
            );
        }
        foreach ($ids->childs as $child){
            $shopClientID = $child->values['shop_client_id'];
            if(!key_exists($shopClientID, $listIDs->childs)){
                $child->additionDatas = $resultArray;
                $listIDs->childs[$shopClientID] = $child;
            }

            $listIDs->childs[$shopClientID]->additionDatas['quantity_month_previous'] += $child->values['quantity'];
        }

        // задаем время выборки с начала года
        $dateFrom = Helpers_DateTime::getYearBeginStr(date('Y')).' 06:00:00';
        $params['exit_at_from'] = $dateFrom;

        if($isAllBranch) {
            $ids = Request_Request::findBranch('DB_Ab1_Shop_Lessee_Car',
                array(), $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
                $elements
            );
        }else{
            $ids = Request_Request::find('DB_Ab1_Shop_Lessee_Car',
                $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
                $elements
            );
        }
        foreach ($ids->childs as $child){
            $shopClientID = $child->values['shop_client_id'];
            if(!key_exists($shopClientID, $listIDs->childs)){
                $child->additionDatas = $resultArray;
                $listIDs->childs[$shopClientID] = $child;
            }

            $listIDs->childs[$shopClientID]->additionDatas['quantity_year'] +=
                $child->values['quantity'];
        }

        $listIDs->childsSortBy(array('quantity_year'), FALSE);

        // итог
        $listIDs->additionDatas = $listIDs->calcTotalsChild(
            array(
                'quantity_day',
                'quantity_yesterday',
                'quantity_week',
                'quantity_month',
                'quantity_month_previous',
                'quantity_year',
            ),
            true
        );
        $listIDs->childsSortBy(
            Request_RequestParams::getParamArray('sort_by', [],
                array(
                    'shop_client_id'=> 'asc',
                    'shop_product_id'=> 'asc',
                    'quantity_day' => 'asc',
                    'quantity_yesterday' => 'asc',
                    'quantity_week' => 'asc',
                    'quantity_month' => 'asc',
                    'quantity_month_previous' => 'asc',
                    'quantity_year' => 'asc',
                )
            ), true, true
        );

        $this->_sitePageData->countRecord = count($listIDs->childs);

        $this->_sitePageData->newShopShablonPath('ab1/_all');
        $this->_sitePageData->replaceDatas['view::_shop/lessee/car/list/statistics'] = Helpers_View::getViewObjects(
            $listIDs, new Model_Ab1_Shop_Product_Rubric(),
            '_shop/lessee/car/list/statistics','_shop/lessee/car/one/statistics',
            $this->_sitePageData, $this->_driverDB
        );
        $this->_sitePageData->previousShopShablonPath();

        // статистика по закуку ответ.хранения
        $this->_statisticsShopBoxcarLessee();

        // Список вагонов в пути по закуку ответ.хранения
        $this->_inTransitShopBoxcarLessee();

        // Список вагонов, которые на территории по закуку ответ.хранения
        $this->_unloadShopBoxcarLessee();

        // На складе ответ.хранения
        $this->_totalShopLessee();

        $this->_putInMain('/main/_shop/lessee/car/statistics');
    }
    /**
     * статистика по закуку ответ.хранения
     */
    private function _statisticsShopBoxcarLessee()
    {
        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/boxcar/list/statistics-lessee',
            )
        );

        $shopRawIDs = NULL;

        // задаем время выборки с начала дня
        $dateFrom = date('Y-m-d').' 06:00:00';
        $listIDs = new MyArray();
        $params = Request_RequestParams::setParams(
            array(
                'date_departure_from' => $dateFrom,
                'sum_quantity' => TRUE,
                'shop_raw_id' => $shopRawIDs,
                'shop_client_id_from' => 0,
                'group_by' => array(
                    'shop_raw_id', 'shop_raw_id.name',
                    'shop_boxcar_client_id', 'shop_boxcar_client_id.name',
                    'shop_client_id', 'shop_client_id.name',
                ),
            )
        );

        $elements = array(
            'shop_raw_id' => array('name'),
            'shop_boxcar_client_id' => array('name'),
            'shop_client_id' => array('name'),
        );

        $resultArray = array(
            'quantity_day' => 0,
            'quantity_yesterday' => 0,
            'quantity_week' => 0,
            'quantity_month' => 0,
            'quantity_month_previous' => 0,
            'quantity_year' => 0,
        );

        $ids = Request_Request::find('DB_Ab1_Shop_Boxcar',
            $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
            $elements
        );
        foreach ($ids->childs as $child){
            $shopClientID = $child->values['shop_raw_id'].'_'.$child->values['shop_boxcar_client_id'].'_'.$child->values['shop_client_id'];
            if(!key_exists($shopClientID, $listIDs->childs)){
                $child->additionDatas = $resultArray;
                $listIDs->childs[$shopClientID] = $child;
            }

            $listIDs->childs[$shopClientID]->additionDatas['quantity_day'] += $child->values['quantity'];
        }

        // задаем время выборки вчера
        $paramsYesterday = $params;
        $paramsYesterday['date_departure_to'] = $dateFrom;
        $paramsYesterday['date_departure_from'] = Helpers_DateTime::minusDays($dateFrom, 1);

        $ids = Request_Request::find('DB_Ab1_Shop_Boxcar',
            $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB, $paramsYesterday, 0, TRUE,
            $elements
        );
        foreach ($ids->childs as $child){
            $shopClientID = $child->values['shop_raw_id'].'_'.$child->values['shop_boxcar_client_id'].'_'.$child->values['shop_client_id'];
            if(!key_exists($shopClientID, $listIDs->childs)){
                $child->additionDatas = $resultArray;
                $listIDs->childs[$shopClientID] = $child;
            }

            $listIDs->childs[$shopClientID]->additionDatas['quantity_yesterday'] += $child->values['quantity'];
        }

        // задаем время выборки с начала недели
        $dateFrom = Helpers_DateTime::getWeekBeginStr(date('Y-m-d')).' 06:00:00';
        $params['date_departure_from'] = $dateFrom;

        $ids = Request_Request::find('DB_Ab1_Shop_Boxcar',
            $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
            $elements
        );
        foreach ($ids->childs as $child){
            $shopClientID = $child->values['shop_raw_id'].'_'.$child->values['shop_boxcar_client_id'].'_'.$child->values['shop_client_id'];
            if(!key_exists($shopClientID, $listIDs->childs)){
                $child->additionDatas = $resultArray;
                $listIDs->childs[$shopClientID] = $child;
            }

            $listIDs->childs[$shopClientID]->additionDatas['quantity_week'] += $child->values['quantity'];
        }

        // задаем время выборки с начала месяца
        $dateFrom = Helpers_DateTime::getMonthBeginStr(date('m'), date('Y')).' 06:00:00';
        $params['date_departure_from'] = $dateFrom;

        $ids = Request_Request::find('DB_Ab1_Shop_Boxcar',
            $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
            $elements
        );
        foreach ($ids->childs as $child){
            $shopClientID = $child->values['shop_raw_id'].'_'.$child->values['shop_boxcar_client_id'].'_'.$child->values['shop_client_id'];
            if(!key_exists($shopClientID, $listIDs->childs)){
                $child->additionDatas = $resultArray;
                $listIDs->childs[$shopClientID] = $child;
            }

            $listIDs->childs[$shopClientID]->additionDatas['quantity_month'] += $child->values['quantity'];
        }

        // задаем время выборки с предыдущего месяца
        $paramsPreviousMonth = $params;
        $tmp = Helpers_DateTime::getMonthBeginStr(date('m'), date('Y')).' 06:00:00';
        $paramsPreviousMonth['date_departure_to'] = $tmp;
        $paramsPreviousMonth['date_departure_from'] = Helpers_DateTime::minusMonth($tmp, 1, true);

        $ids = Request_Request::find('DB_Ab1_Shop_Boxcar',
            $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB, $paramsPreviousMonth, 0, TRUE,
            $elements
        );
        foreach ($ids->childs as $child){
            $shopClientID = $child->values['shop_raw_id'].'_'.$child->values['shop_boxcar_client_id'].'_'.$child->values['shop_client_id'];
            if(!key_exists($shopClientID, $listIDs->childs)){
                $child->additionDatas = $resultArray;
                $listIDs->childs[$shopClientID] = $child;
            }

            $listIDs->childs[$shopClientID]->additionDatas['quantity_month_previous'] += $child->values['quantity'];
        }

        // задаем время выборки с начала года
        $dateFrom = Helpers_DateTime::getYearBeginStr(date('Y')).' 06:00:00';
        $params['date_departure_from'] = $dateFrom;

        $ids = Request_Request::find('DB_Ab1_Shop_Boxcar',
            $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
            $elements
        );
        foreach ($ids->childs as $child){
            $shopClientID = $child->values['shop_raw_id'].'_'.$child->values['shop_boxcar_client_id'].'_'.$child->values['shop_client_id'];
            if(!key_exists($shopClientID, $listIDs->childs)){
                $child->additionDatas = $resultArray;
                $listIDs->childs[$shopClientID] = $child;
            }

            $listIDs->childs[$shopClientID]->additionDatas['quantity_year'] += $child->values['quantity'];
        }

        // задаем время выборки с за все время
        /* $params['date_departure_from'] = NULL;

         $ids = Request_Request::find('DB_Ab1_Shop_Boxcar',
             $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
            $elements
         );
        foreach ($ids->childs as $child){
            $shopClientID = $child->values['shop_raw_id'].'_'.$child->values['shop_boxcar_client_id'].'_'.$child->values['shop_client_id'];
            if(!key_exists($shopClientID, $listIDs->childs)){
                if(!$isAll){
                    continue;
                }
                $child->additionDatas = $resultArray;
                $listIDs->childs[$shopClientID] = $child;
            }

            $listIDs->childs[$shopClientID]->additionDatas['quantity'] += $child->values['quantity'];
        }*/

        // итог
        $listIDs->additionDatas = $listIDs->calcTotalsChild(
            array(
                'quantity_day',
                'quantity_yesterday',
                'quantity_week',
                'quantity_month',
                'quantity_month_previous',
                'quantity_year',
            ),
            true
        );

        $listIDs->childsSortBy(
            array(
                Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_client_id.name',
                Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_boxcar_client_id.name',
                Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_raw_id.name',
            )
        );
        $this->_sitePageData->countRecord = count($listIDs->childs);

        $this->_sitePageData->newShopShablonPath('ab1/_all');
        $this->_sitePageData->replaceDatas['view::_shop/boxcar/list/statistics-lessee'] = Helpers_View::getViewObjects(
            $listIDs, new Model_Ab1_Shop_Boxcar(),
            '_shop/boxcar/list/statistics-lessee','_shop/boxcar/one/statistics-lessee',
            $this->_sitePageData, $this->_driverDB
        );
        $this->_sitePageData->previousShopShablonPath();
    }

    /**
     * Список вагонов в пути по закуку ответ.хранения
     * @throws Exception
     */
    private function _inTransitShopBoxcarLessee() {
        $this->_setGlobalDatas(
            array(
                'view::_shop/boxcar/list/in-transit-lessee',
            )
        );

        $params = Request_RequestParams::setParams(
            array(
                'is_date_arrival_empty' => true,
                'count_id' => true,
                'sum_quantity' => true,
                'shop_client_id_from' => 0,
                'group_by' => array(
                    'shop_client_id', 'shop_client_id.name',
                    'shop_boxcar_client_id', 'shop_boxcar_client_id.name',
                    'shop_raw_id', 'shop_raw_id.name',
                    'shop_boxcar_train_id', 'shop_boxcar_train_id.date_shipment',
                )
            )
        );
        $ids = Request_Request::find('DB_Ab1_Shop_Boxcar',
            $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB,
            $params, 0, TRUE,
            array(
                'shop_client_id' => array('name'),
                'shop_boxcar_client_id' => array('name'),
                'shop_raw_id' => array('name'),
                'shop_boxcar_train_id' => array('date_shipment'),
            )
        );

        $total = array(
            'count' => 0,
            'quantity' => 0,
        );
        foreach ($ids->childs as $child){
            $total['count'] += $child->values['count'];
            $total['quantity'] += $child->values['quantity'];
        }
        $ids->additionDatas = $total;
        uasort($ids->childs, function (MyArray $x, MyArray $y) {
            return strcasecmp($x->getElementValue('shop_boxcar_train_id', 'date_shipment'), $y->getElementValue('shop_boxcar_train_id', 'date_shipment')) * (-1);
        });

        $this->_sitePageData->newShopShablonPath('ab1/_all');
        $this->_sitePageData->replaceDatas['view::_shop/boxcar/list/in-transit-lessee'] = Helpers_View::getViewObjects(
            $ids, new Model_Ab1_Shop_Boxcar(),
            '_shop/boxcar/list/in-transit-lessee','_shop/boxcar/one/in-transit-lessee',
            $this->_sitePageData, $this->_driverDB
        );
        $this->_sitePageData->previousShopShablonPath();
    }

    /**
     * Список вагонов, которые на территории по закуку ответ.хранения
     * @throws Exception
     */
    private function _unloadShopBoxcarLessee() {
        $this->_setGlobalDatas(
            array(
                'view::_shop/boxcar/list/unload-lessee',
            )
        );

        $params = Request_RequestParams::setParams(
            array(
                'is_date_arrival_empty' => false,
                'is_date_departure_empty' => TRUE,
                'count_id' => true,
                'sum_quantity' => true,
                'shop_client_id_from' => 0,
                'group_by' => array(
                    'shop_boxcar_train_id',
                    'shop_client_id', 'shop_client_id.name',
                    'shop_boxcar_client_id', 'shop_boxcar_client_id.name',
                    'shop_raw_id', 'shop_raw_id.name',
                    'date_arrival', 'date_drain_from',
                )
            )
        );
        $ids = Request_Request::find('DB_Ab1_Shop_Boxcar',
            $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB,
            $params, 0, TRUE,
            array(
                'shop_client_id' => array('name'),
                'shop_boxcar_client_id' => array('name'),
                'shop_raw_id' => array('name'),
            )
        );

        $total = array(
            'count' => 0,
            'quantity' => 0,
        );
        foreach ($ids->childs as $child){
            $total['count'] += $child->values['count'];
            $total['quantity'] += $child->values['quantity'];
        }
        $ids->additionDatas = $total;

        $this->_sitePageData->newShopShablonPath('ab1/_all');
        $this->_sitePageData->replaceDatas['view::_shop/boxcar/list/unload-lessee'] = Helpers_View::getViewObjects(
            $ids, new Model_Ab1_Shop_Boxcar(),
            '_shop/boxcar/list/unload-lessee','_shop/boxcar/one/unload-lessee',
            $this->_sitePageData, $this->_driverDB
        );
        $this->_sitePageData->previousShopShablonPath();
    }

    /**
     * Остатки на ответ.хранения
     * @throws Exception
     */
    private function _totalShopLessee() {
        $this->_setGlobalDatas(
            array(
                'view::_shop/lessee/car/list/statistics-total',
                'view::_shop/boxcar/list/statistics-lessee-client',
            )
        );

        $total = new MyArray();

        // приход
        $params = Request_RequestParams::setParams(
            array(
                'date_departure_empty' => false,
                'sum_quantity' => true,
                'shop_client_id_from' => 0,
                'group_by' => array(
                    'shop_client_id', 'shop_client_id.name', 'shop_client_id.options',
                    'shop_raw_id', 'shop_raw_id.name',
                )
            )
        );
        $shopBoxcarIDs = Request_Request::find('DB_Ab1_Shop_Boxcar',
            $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB,
            $params, 0, TRUE,
            array(
                'shop_client_id' => array('name', 'options'),
                'shop_raw_id' => array('name'),
            )
        );

        $childs = [];
        foreach ($shopBoxcarIDs->childs as $child){
            $key = $child->values['shop_client_id'] . '_' . $child->getElementValue('shop_raw_id');

            $percent = floatval(Arr::path(json_decode($child->getElementValue('shop_client_id', 'options'),true), 'lessee_percent', 0));
            if($percent == 0){
                $percent = 1;
            }
            $val = $child->values['quantity'] / 100 * $percent;

            $total->childs[$key] = new MyArray();
            $total->childs[$key]->cloneObj($child);
            $total->childs[$key]->values['quantity'] += $val;
            $total->childs[$key]->values['quantity_year'] = 0;

            $child->values['quantity'] = $val;
            $child->values['quantity_year'] = 0;

            $childs[$key] = $child;
        }
        $shopBoxcarIDs->childs = $childs;
        $shopBoxcarIDs->additionDatas['quantity'] = $shopBoxcarIDs->calcTotalChild('quantity');

        // расход
        $paramsLessee = Request_RequestParams::setParams(
            array(
                'is_date_drain_to_empty' => false,
                'sum_quantity' => true,
                'shop_client_id_from' => 0,
                'group_by' => array(
                    'shop_client_id', 'shop_client_id.name',
                    'shop_product_id', 'shop_product_id.name',
                )
            )
        );
        $shopLesseeCarIDs = Request_Request::find('DB_Ab1_Shop_Lessee_Car',
            $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB,
            $paramsLessee, 0, TRUE,
            array(
                'shop_client_id' => array('name'),
                'shop_product_id' => array('name'),
            )
        );

        foreach ($shopLesseeCarIDs->childs as $child){
            $key = $child->values['shop_client_id'] . '_' . $child->getElementValue('shop_product_id');
            if(!key_exists($key, $total->childs)){
                $total->childs[$key] = $child;
                $child->values['quantity'] = $child->values['quantity'] * (-1);
                $child->values['quantity_year'] = 0;
            }else {
                $total->childs[$key]->values['quantity'] -= $child->values['quantity'];
            }
        }
        $total->additionDatas['quantity'] = $total->calcTotalChild('quantity');

        /********* Приход сначала года ***********/

        $params['date_departure_from'] = Helpers_DateTime::getYearBeginStr(date('Y'));
        $shopBoxcarIDsYear = Request_Request::find('DB_Ab1_Shop_Boxcar',
            $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB,
            $params, 0, TRUE,
            array(
                'shop_client_id' => array('name', 'options'),
                'shop_raw_id' => array('name'),
            )
        );

        foreach ($shopBoxcarIDsYear->childs as $child){
            $key = $child->values['shop_client_id'] . '_' . $child->getElementValue('shop_raw_id');

            $percent = floatval(Arr::path(json_decode($child->getElementValue('shop_client_id', 'options'),true), 'lessee_percent', 0));
            if($percent == 0){
                $percent = 1;
            }
            $val = $child->values['quantity'] / 100 * $percent;

            if(!key_exists($key, $total->childs)){
                $shopBoxcarIDs->childs[$key] = $child;
                $child->values['quantity_year'] = $val;
                $child->values['quantity'] = 0;

            }else {
                $shopBoxcarIDs->childs[$key]->values['quantity_year'] += $val;
            }
        }
        $shopBoxcarIDs->additionDatas['quantity_year'] = $shopBoxcarIDs->calcTotalChild('quantity_year');

        /********* Остатки на начало года ***********/

        unset($params['date_departure_from']);
        $params['date_departure_to'] = Helpers_DateTime::getYearBeginStr(date('Y'));
        $shopBoxcarIDsYear = Request_Request::find('DB_Ab1_Shop_Boxcar',
            $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB,
            $params, 0, TRUE,
            array(
                'shop_client_id' => array('name', 'options'),
                'shop_raw_id' => array('name'),
            )
        );

        foreach ($shopBoxcarIDsYear->childs as $child){
            $key = $child->values['shop_client_id'] . '_' . $child->getElementValue('shop_raw_id');

            $percent = floatval(Arr::path(json_decode($child->getElementValue('shop_client_id', 'options'),true), 'lessee_percent', 0));
            if($percent == 0){
                $percent = 1;
            }
            $val = $child->values['quantity'] - $child->values['quantity'] / 100 * $percent;

            if(!key_exists($key, $total->childs)){
                $total->childs[$key] = $child;
                $child->values['quantity_year'] = $val;
                $child->values['quantity'] = 0;

            }else {
                $total->childs[$key]->values['quantity_year'] += $val;
            }
        }

        // расход
        $paramsLessee['exit_at_to'] = Helpers_DateTime::getYearBeginStr(date('Y'));
        $shopLesseeCarIDs = Request_Request::find('DB_Ab1_Shop_Lessee_Car',
            $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB,
            $paramsLessee, 0, TRUE,
            array(
                'shop_client_id' => array('name'),
                'shop_product_id' => array('name'),
            )
        );

        foreach ($shopLesseeCarIDs->childs as $child){
            $key = $child->values['shop_client_id'] . '_' . $child->getElementValue('shop_product_id');
            if(!key_exists($key, $total->childs)){
                $total->childs[$key] = $child;
                $child->values['quantity_year'] = $child->values['quantity'] * (-1);
                $child->values['quantity'] = 0;
            }else {
                $total->childs[$key]->values['quantity_year'] -= $child->values['quantity'];
            }
        }

        $total->additionDatas['quantity_year'] = $total->calcTotalChild('quantity_year');

        $this->_sitePageData->newShopShablonPath('ab1/_all');

        $this->_sitePageData->replaceDatas['view::_shop/lessee/car/list/statistics-total'] = Helpers_View::getViewObjects(
            $total, new Model_Ab1_Shop_Lessee_Car(),
            '_shop/lessee/car/list/statistics-total','_shop/lessee/car/one/statistics-total',
            $this->_sitePageData, $this->_driverDB
        );

        $this->_sitePageData->replaceDatas['view::_shop/boxcar/list/statistics-lessee-client'] = Helpers_View::getViewObjects(
            $shopBoxcarIDs, new Model_Ab1_Shop_Boxcar(),
            '_shop/boxcar/list/statistics-lessee-client','_shop/boxcar/one/statistics-lessee-client',
            $this->_sitePageData, $this->_driverDB
        );

        $this->_sitePageData->previousShopShablonPath();
    }

    protected function _shopBallastStatisticsQuantityCount()
    {
        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/ballast/list/statistics/quantity-count',
            )
        );

        // задаем время выборки с начала дня
        $dateFrom = date('Y-m-d').' 06:00:00';
        $listIDs = new MyArray();
        $params = Request_RequestParams::setParams(
            array(
                'date_from' => $dateFrom,
                'sum_quantity' => TRUE,
                'count_id' => TRUE,
                'group_by' => array(
                    'shop_id', 'shop_id.name',
                ),
            )
        );

        $elements = array(
            'shop_id' => array('name'),
        );

        $resultArray = array(
            'quantity_day' => 0,
            'quantity_yesterday' => 0,
            'quantity_week' => 0,
            'quantity_month' => 0,
            'quantity_month_previous' => 0,
            'quantity_year' => 0,

            'count_day' => 0,
            'count_yesterday' => 0,
            'count_week' => 0,
            'count_month' => 0,
            'count_month_previous' => 0,
            'count_year' => 0,
        );

        $shopIDs = Request_Shop::getBranchShopIDs($this->_sitePageData->shopMainID, $this->_sitePageData, $this->_driverDB)->getChildArrayID();

        $ids = Request_Request::findBranch('DB_Ab1_Shop_Ballast',
            $shopIDs, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
            $elements
        );
        foreach ($ids->childs as $child){
            $key = $child->values['shop_id'];
            if(!key_exists($key, $listIDs->childs)){
                $child->additionDatas = $resultArray;
                $listIDs->childs[$key] = $child;
            }

            $listIDs->childs[$key]->additionDatas['quantity_day'] += $child->values['quantity'];
            $listIDs->childs[$key]->additionDatas['count_day'] += $child->values['count'];
        }

        // задаем время выборки вчера
        $paramsYesterday = $params;
        $paramsYesterday['date_to'] = $dateFrom;
        $paramsYesterday['date_from'] = Helpers_DateTime::minusDays($dateFrom, 1);

        $ids = Request_Request::findBranch('DB_Ab1_Shop_Ballast',
            $shopIDs, $this->_sitePageData, $this->_driverDB, $paramsYesterday, 0, TRUE,
            $elements
        );
        foreach ($ids->childs as $child){
            $key = $child->values['shop_id'];
            if(!key_exists($key, $listIDs->childs)){
                $child->additionDatas = $resultArray;
                $listIDs->childs[$key] = $child;
            }

            $listIDs->childs[$key]->additionDatas['quantity_yesterday'] += $child->values['quantity'];
            $listIDs->childs[$key]->additionDatas['count_yesterday'] += $child->values['count'];
        }

        // задаем время выборки с начала недели
        $dateFrom = Helpers_DateTime::getWeekBeginStr(date('Y-m-d')).' 06:00:00';
        $params['date_from'] = $dateFrom;

        $ids = Request_Request::findBranch('DB_Ab1_Shop_Ballast',
            $shopIDs, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
            $elements
        );
        foreach ($ids->childs as $child){
            $key = $child->values['shop_id'];
            if(!key_exists($key, $listIDs->childs)){
                $child->additionDatas = $resultArray;
                $listIDs->childs[$key] = $child;
            }

            $listIDs->childs[$key]->additionDatas['quantity_week'] += $child->values['quantity'];
            $listIDs->childs[$key]->additionDatas['count_week'] += $child->values['count'];
        }

        // задаем время выборки с начала месяца
        $dateFrom = Helpers_DateTime::getMonthBeginStr(date('m'), date('Y')).' 06:00:00';
        $params['date_from'] = $dateFrom;

        $ids = Request_Request::findBranch('DB_Ab1_Shop_Ballast',
            $shopIDs, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
            $elements
        );
        foreach ($ids->childs as $child){
            $key = $child->values['shop_id'];
            if(!key_exists($key, $listIDs->childs)){
                $child->additionDatas = $resultArray;
                $listIDs->childs[$key] = $child;
            }

            $listIDs->childs[$key]->additionDatas['quantity_month'] += $child->values['quantity'];
            $listIDs->childs[$key]->additionDatas['count_month'] += $child->values['count'];
        }

        // задаем время выборки с предыдущего месяца
        $paramsPreviousMonth = $params;
        $tmp = Helpers_DateTime::getMonthBeginStr(date('m'), date('Y')).' 06:00:00';
        $paramsPreviousMonth['date_to'] = $tmp;
        $paramsPreviousMonth['date_from'] = Helpers_DateTime::minusMonth($tmp, 1, true);

        $ids = Request_Request::findBranch('DB_Ab1_Shop_Ballast',
            $shopIDs, $this->_sitePageData, $this->_driverDB, $paramsPreviousMonth, 0, TRUE,
            $elements
        );
        foreach ($ids->childs as $child){
            $key = $child->values['shop_id'];
            if(!key_exists($key, $listIDs->childs)){
                $child->additionDatas = $resultArray;
                $listIDs->childs[$key] = $child;
            }

            $listIDs->childs[$key]->additionDatas['quantity_month_previous'] += $child->values['quantity'];
            $listIDs->childs[$key]->additionDatas['count_month_previous'] += $child->values['count'];
        }

        // задаем время выборки с начала года
        $dateFrom = Helpers_DateTime::getYearBeginStr(date('Y')).' 06:00:00';
        $params['date_from'] = $dateFrom;

        $ids = Request_Request::findBranch('DB_Ab1_Shop_Ballast',
            $shopIDs, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
            $elements
        );
        foreach ($ids->childs as $child){
            $key = $child->values['shop_id'];
            if(!key_exists($key, $listIDs->childs)){
                $child->additionDatas = $resultArray;
                $listIDs->childs[$key] = $child;
            }

            $listIDs->childs[$key]->additionDatas['quantity_year'] += $child->values['quantity'];
            $listIDs->childs[$key]->additionDatas['count_year'] += $child->values['count'];
        }

        // задаем время выборки с за все время
        /* $params['date_from'] = NULL;

         $ids = Request_Request::findBranch('DB_Ab1_Shop_Ballast',
             $shopIDs, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
            $elements
         );
        foreach ($ids->childs as $child){
            $key = $child->values['shop_id'];
            if(!key_exists($key, $listIDs->childs)){
                if(!$isAll){
                    continue;
                }
                $child->additionDatas = $resultArray;
                $listIDs->childs[$key] = $child;
            }

            $listIDs->childs[$key]->additionDatas['quantity'] += $child->values['quantity'];
            $listIDs->childs[$key]->additionDatas['count'] += $child->values['count'];
        }*/

        // итог
        $listIDs->additionDatas = $listIDs->calcTotalsChild(
            array(
                'quantity_day',
                'quantity_yesterday',
                'quantity_week',
                'quantity_month',
                'quantity_month_previous',
                'quantity_year',

                'count_day',
                'count_yesterday',
                'count_week',
                'count_month',
                'count_month_previous',
                'count_year',
            ),
            true
        );

        $listIDs->childsSortBy(
            array(
                Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_id.name',
            )
        );

        $this->_sitePageData->countRecord = count($listIDs->childs);

        $this->_sitePageData->newShopShablonPath('ab1/_all');
        $this->_sitePageData->replaceDatas['view::_shop/ballast/list/statistics/quantity-count'] = Helpers_View::getViewObjects(
            $listIDs, new Model_Ab1_Shop_Product_Rubric(),
            '_shop/ballast/list/statistics/quantity-count','_shop/ballast/one/statistics/quantity-count',
            $this->_sitePageData, $this->_driverDB
        );
        $this->_sitePageData->previousShopShablonPath();
    }

    protected function _shopBallastStatisticsQuantity()
    {
        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/branch/list/statistics/ballast',
            )
        );

        // задаем время выборки с начала дня
        $dateFrom = date('Y-m-d').' 06:00:00';
        $listIDs = new MyArray();
        $params = Request_RequestParams::setParams(
            array(
                'date_from' => $dateFrom,
                'sum_quantity' => TRUE,
                'min_date' => TRUE,
                'max_date' => TRUE,
                'group_by' => array(
                    'shop_id', 'shop_id.name',
                    'shop_ballast_crusher_id', 'shop_ballast_crusher_id.name',
                ),
            )
        );

        $elements = array(
            'shop_id' => array('name'),
            'shop_ballast_crusher_id' => array('name'),
        );

        $resultArray = array(
            'quantity_day' => 0,
            'quantity_yesterday' => 0,
            'quantity_week' => 0,
            'quantity_month' => 0,
            'quantity_month_previous' => 0,
            'quantity_year' => 0,

            'min_date_day' => null,
            'max_date_day' => null,
            'min_date_yesterday' => null,
            'max_date_yesterday' => null,
        );

        $shopIDs = Request_Shop::getBranchShopIDs($this->_sitePageData->shopMainID, $this->_sitePageData, $this->_driverDB)->getChildArrayID();

        $ids = Request_Request::findBranch('DB_Ab1_Shop_Ballast',
            $shopIDs, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
            $elements
        );
        foreach ($ids->childs as $child){
            $shop = $child->values['shop_id'];
            if(!key_exists($shop, $listIDs->childs)){
                $tmp = new MyArray();
                $tmp->values['name'] = $child->getElementValue('shop_id');
                $tmp->additionDatas = $resultArray;
                $tmp->setIsFind(true);
                $listIDs->childs[$shop] = $tmp;
            }

            $crusher = $child->values['shop_ballast_crusher_id'];
            if(!key_exists($crusher, $listIDs->childs[$shop]->childs)){
                $child->additionDatas = $resultArray;
                $listIDs->childs[$shop]->childs[$crusher] = $child;
            }

            $listIDs->childs[$shop]->additionDatas['quantity_day'] += $child->values['quantity'];

            $date = $listIDs->childs[$shop]->additionDatas['min_date_day'];
            if($date == null || strtotime($date) > strtotime($child->values['min_date'])){
                $listIDs->childs[$shop]->additionDatas['min_date_day'] = $child->values['min_date'];
            }
            $date = $listIDs->childs[$shop]->additionDatas['max_date_day'];
            if($date == null || strtotime($date) < strtotime($child->values['max_date'])){
                $listIDs->childs[$shop]->additionDatas['max_date_day'] = $child->values['max_date'];
            }

            $listIDs->childs[$shop]->childs[$crusher]->additionDatas['quantity_day'] += $child->values['quantity'];

            $date = $listIDs->childs[$shop]->childs[$crusher]->additionDatas['min_date_day'];
            if($date == null || strtotime($date) > strtotime($child->values['min_date'])){
                $listIDs->childs[$shop]->childs[$crusher]->additionDatas['min_date_day'] = $child->values['min_date'];
            }
            $date = $listIDs->childs[$shop]->childs[$crusher]->additionDatas['max_date_day'];
            if($date == null || strtotime($date) < strtotime($child->values['max_date'])){
                $listIDs->childs[$shop]->childs[$crusher]->additionDatas['max_date_day'] = $child->values['max_date'];
            }
        }

        // задаем время выборки вчера
        $paramsYesterday = $params;
        $paramsYesterday['date_to'] = $dateFrom;
        $paramsYesterday['date_from'] = Helpers_DateTime::minusDays($dateFrom, 1);

        $ids = Request_Request::findBranch('DB_Ab1_Shop_Ballast',
            $shopIDs, $this->_sitePageData, $this->_driverDB, $paramsYesterday, 0, TRUE,
            $elements
        );
        foreach ($ids->childs as $child){
            $shop = $child->values['shop_id'];
            if(!key_exists($shop, $listIDs->childs)){
                $tmp = new MyArray();
                $tmp->values['name'] = $child->getElementValue('shop_id');
                $tmp->additionDatas = $resultArray;
                $tmp->setIsFind(true);
                $listIDs->childs[$shop] = $tmp;
            }

            $crusher = $child->values['shop_ballast_crusher_id'];
            if(!key_exists($crusher, $listIDs->childs[$shop]->childs)){
                $child->additionDatas = $resultArray;
                $listIDs->childs[$shop]->childs[$crusher] = $child;
            }

            $listIDs->childs[$shop]->additionDatas['quantity_yesterday'] += $child->values['quantity'];

            $date = $listIDs->childs[$shop]->additionDatas['min_date_yesterday'];
            if($date == null || strtotime($date) > strtotime($child->values['min_date'])){
                $listIDs->childs[$shop]->additionDatas['min_date_yesterday'] = $child->values['min_date'];
            }
            $date = $listIDs->childs[$shop]->additionDatas['max_date_yesterday'];
            if($date == null || strtotime($date) < strtotime($child->values['max_date'])){
                $listIDs->childs[$shop]->additionDatas['max_date_yesterday'] = $child->values['max_date'];
            }

            $listIDs->childs[$shop]->childs[$crusher]->additionDatas['quantity_yesterday'] += $child->values['quantity'];

            $date = $listIDs->childs[$shop]->childs[$crusher]->additionDatas['min_date_yesterday'];
            if($date == null || strtotime($date) > strtotime($child->values['min_date'])){
                $listIDs->childs[$shop]->childs[$crusher]->additionDatas['min_date_yesterday'] = $child->values['min_date'];
            }
            $date = $listIDs->childs[$shop]->childs[$crusher]->additionDatas['max_date_yesterday'];
            if($date == null || strtotime($date) < strtotime($child->values['max_date'])){
                $listIDs->childs[$shop]->childs[$crusher]->additionDatas['max_date_yesterday'] = $child->values['max_date'];
            }
        }

        // задаем время выборки с начала недели
        $dateFrom = Helpers_DateTime::getWeekBeginStr(date('Y-m-d')).' 06:00:00';
        $params['date_from'] = $dateFrom;

        $ids = Request_Request::findBranch('DB_Ab1_Shop_Ballast',
            $shopIDs, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
            $elements
        );
        foreach ($ids->childs as $child){
            $shop = $child->values['shop_id'];
            if(!key_exists($shop, $listIDs->childs)){
                $tmp = new MyArray();
                $tmp->values['name'] = $child->getElementValue('shop_id');
                $tmp->additionDatas = $resultArray;
                $tmp->setIsFind(true);
                $listIDs->childs[$shop] = $tmp;
            }

            $crusher = $child->values['shop_ballast_crusher_id'];
            if(!key_exists($crusher, $listIDs->childs[$shop]->childs)){
                $child->additionDatas = $resultArray;
                $listIDs->childs[$shop]->childs[$crusher] = $child;
            }

            $listIDs->childs[$shop]->additionDatas['quantity_week'] += $child->values['quantity'];
            $listIDs->childs[$shop]->childs[$crusher]->additionDatas['quantity_week'] += $child->values['quantity'];
        }

        // задаем время выборки с начала месяца
        $dateFrom = Helpers_DateTime::getMonthBeginStr(date('m'), date('Y')).' 06:00:00';
        $params['date_from'] = $dateFrom;

        $ids = Request_Request::findBranch('DB_Ab1_Shop_Ballast',
            $shopIDs, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
            $elements
        );
        foreach ($ids->childs as $child){
            $shop = $child->values['shop_id'];
            if(!key_exists($shop, $listIDs->childs)){
                $tmp = new MyArray();
                $tmp->values['name'] = $child->getElementValue('shop_id');
                $tmp->additionDatas = $resultArray;
                $tmp->setIsFind(true);
                $listIDs->childs[$shop] = $tmp;
            }

            $crusher = $child->values['shop_ballast_crusher_id'];
            if(!key_exists($crusher, $listIDs->childs[$shop]->childs)){
                $child->additionDatas = $resultArray;
                $listIDs->childs[$shop]->childs[$crusher] = $child;
            }

            $listIDs->childs[$shop]->additionDatas['quantity_month'] += $child->values['quantity'];
            $listIDs->childs[$shop]->childs[$crusher]->additionDatas['quantity_month'] += $child->values['quantity'];
        }

        // задаем время выборки с предыдущего месяца
        $paramsPreviousMonth = $params;
        $tmp = Helpers_DateTime::getMonthBeginStr(date('m'), date('Y')).' 06:00:00';
        $paramsPreviousMonth['date_to'] = $tmp;
        $paramsPreviousMonth['date_from'] = Helpers_DateTime::minusMonth($tmp, 1, true);

        $ids = Request_Request::findBranch('DB_Ab1_Shop_Ballast',
            $shopIDs, $this->_sitePageData, $this->_driverDB, $paramsPreviousMonth, 0, TRUE,
            $elements
        );
        foreach ($ids->childs as $child){
            $shop = $child->values['shop_id'];
            if(!key_exists($shop, $listIDs->childs)){
                $tmp = new MyArray();
                $tmp->values['name'] = $child->getElementValue('shop_id');
                $tmp->additionDatas = $resultArray;
                $tmp->setIsFind(true);
                $listIDs->childs[$shop] = $tmp;
            }

            $crusher = $child->values['shop_ballast_crusher_id'];
            if(!key_exists($crusher, $listIDs->childs[$shop]->childs)){
                $child->additionDatas = $resultArray;
                $listIDs->childs[$shop]->childs[$crusher] = $child;
            }

            $listIDs->childs[$shop]->additionDatas['quantity_month_previous'] += $child->values['quantity'];
            $listIDs->childs[$shop]->childs[$crusher]->additionDatas['quantity_month_previous'] += $child->values['quantity'];
        }

        // задаем время выборки с начала года
        $dateFrom = Helpers_DateTime::getYearBeginStr(date('Y')).' 06:00:00';
        $params['date_from'] = $dateFrom;

        $ids = Request_Request::findBranch('DB_Ab1_Shop_Ballast',
            $shopIDs, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
            $elements
        );
        foreach ($ids->childs as $child){
            $shop = $child->values['shop_id'];
            if(!key_exists($shop, $listIDs->childs)){
                $tmp = new MyArray();
                $tmp->values['name'] = $child->getElementValue('shop_id');
                $tmp->additionDatas = $resultArray;
                $tmp->setIsFind(true);
                $listIDs->childs[$shop] = $tmp;
            }

            $crusher = $child->values['shop_ballast_crusher_id'];
            if(!key_exists($crusher, $listIDs->childs[$shop]->childs)){
                $child->additionDatas = $resultArray;
                $listIDs->childs[$shop]->childs[$crusher] = $child;
            }

            $listIDs->childs[$shop]->additionDatas['quantity_year'] += $child->values['quantity'];
            $listIDs->childs[$shop]->childs[$crusher]->additionDatas['quantity_year'] += $child->values['quantity'];
        }

        // задаем время выборки с за все время
        /* $params['date_from'] = NULL;

         $ids = Request_Request::findBranch('DB_Ab1_Shop_Ballast',
             $shopIDs, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
            $elements
         );
        foreach ($ids->childs as $child){
            $shop = $child->values['shop_id'];
            if(!key_exists($shop, $listIDs->childs)){
                $tmp = new MyArray();
                $tmp->values['name'] = $child->getElementValue('shop_id');
                $tmp->additionDatas = $resultArray;
                $listIDs->childs[$shop] = $tmp;
            }

            $crusher = $child->values['shop_ballast_crusher_id'];
            if(!key_exists($crusher, $listIDs->childs[$shop]->childs)){
                $child->additionDatas = $resultArray;
                $listIDs->childs[$shop]->childs[$crusher] = $child;
            }

            $listIDs->childs[$shop]->additionDatas['quantity'] += $child->values['quantity'];
            $listIDs->childs[$shop]->childs[$crusher]->additionDatas['quantity] += $child->values['quantity'];
        }*/

        $listIDs->childsSortBy(
            array(
                Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_id.name',
            )
        );

        $this->_sitePageData->newShopShablonPath('ab1/_all');
        foreach ($listIDs->childs as $child){
            $child->childsSortBy(
                array(
                    Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_ballast_crusher_id.name',
                )
            );

            $child->additionDatas['view::_shop/ballast/list/statistics/quantity'] = Helpers_View::getViewObjects(
                $child, new Model_Ab1_Shop_Ballast(),
                '_shop/ballast/list/statistics/quantity','_shop/ballast/one/statistics/quantity',
                $this->_sitePageData, $this->_driverDB
            );
        }

        $this->_sitePageData->countRecord = count($listIDs->childs);
        $this->_sitePageData->replaceDatas['view::_shop/branch/list/statistics/ballast'] = Helpers_View::getViewObjects(
            $listIDs, new Model_Ab1_Shop_Product_Rubric(),
            '_shop/branch/list/statistics/ballast','_shop/branch/one/statistics/ballast',
            $this->_sitePageData, $this->_driverDB
        );
        $this->_sitePageData->previousShopShablonPath();
    }

    /*
     * Завоз и вывоз со штабеля балласта
     */
    protected function _shopBallastStatisticsStorage()
    {
        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/ballast/list/statistics/storage',
            )
        );

        // задаем время выборки с начала дня
        $dateFrom = date('Y-m-d').' 06:00:00';
        $listIDs = new MyArray();
        $paramsImport = Request_RequestParams::setParams(
            array(
                'date_from' => $dateFrom,
                'sum_quantity' => TRUE,
                'shop_ballast_crusher_id.is_storage' => true,
                'group_by' => array(
                    'shop_ballast_crusher_id', 'shop_ballast_crusher_id.name',
                    'shop_id', 'shop_id.name',
                ),
            )
        );
        $elementsImport = array(
            'shop_ballast_crusher_id' => array('name'),
            'shop_id' => array('name'),
        );

        $paramsExport = Request_RequestParams::setParams(
            array(
                'date_from' => $dateFrom,
                'sum_quantity' => TRUE,
                'take_shop_ballast_crusher_id_from' => 0,
                'group_by' => array(
                    'take_shop_ballast_crusher_id', 'take_shop_ballast_crusher_id.name',
                    'shop_id', 'shop_id.name',
                ),
            )
        );
        $elementsExport = array(
            'take_shop_ballast_crusher_id' => array('name'),
            'shop_id' => array('name'),
        );

        $resultArray = array(
            'from' => 0,
            'to' => 0,

            'import_day' => 0,
            'import_yesterday' => 0,
            'import_week' => 0,
            'import_month' => 0,
            'import_month_previous' => 0,
            'import_year' => 0,

            'export_day' => 0,
            'export_yesterday' => 0,
            'export_week' => 0,
            'export_month' => 0,
            'export_month_previous' => 0,
            'export_year' => 0,
        );

        // завоз
        $ids = Request_Request::findBranch('DB_Ab1_Shop_Ballast',
            array(), $this->_sitePageData, $this->_driverDB, $paramsImport, 0, TRUE,
            $elementsImport
        );
        foreach ($ids->childs as $child){
            $key = $child->values['shop_ballast_crusher_id'].'_'.$child->values['shop_id'];
            if(!key_exists($key, $listIDs->childs)){
                $child->additionDatas = $resultArray;
                $listIDs->childs[$key] = $child;
            }

            $listIDs->childs[$key]->additionDatas['import_day'] += $child->values['quantity'];
        }

        // вывоз
        $ids = Request_Request::findBranch('DB_Ab1_Shop_Ballast',
            array(), $this->_sitePageData, $this->_driverDB, $paramsExport, 0, TRUE,
            $elementsExport
        );
        foreach ($ids->childs as $child){
            $key = $child->values['take_shop_ballast_crusher_id'].'_'.$child->values['shop_id'];
            if(!key_exists($key, $listIDs->childs)){
                $child->additionDatas = $resultArray;
                $listIDs->childs[$key] = $child;
            }

            $listIDs->childs[$key]->additionDatas['export_day'] += $child->values['quantity'];
        }

        // задаем время выборки вчера
        $paramsYesterday = $paramsImport;
        $paramsYesterday['date_to'] = $dateFrom;
        $paramsYesterday['date_from'] = Helpers_DateTime::minusDays($dateFrom, 1);

        $ids = Request_Request::findBranch('DB_Ab1_Shop_Ballast',
            array(), $this->_sitePageData, $this->_driverDB, $paramsYesterday, 0, TRUE,
            $elementsImport
        );
        foreach ($ids->childs as $child){
            $key = $child->values['shop_ballast_crusher_id'].'_'.$child->values['shop_id'];
            if(!key_exists($key, $listIDs->childs)){
                $child->additionDatas = $resultArray;
                $listIDs->childs[$key] = $child;
            }

            $listIDs->childs[$key]->additionDatas['import_yesterday'] += $child->values['quantity'];
        }

        $paramsYesterday = $paramsExport;
        $paramsYesterday['date_to'] = $dateFrom;
        $paramsYesterday['date_from'] = Helpers_DateTime::minusDays($dateFrom, 1);

        $ids = Request_Request::findBranch('DB_Ab1_Shop_Ballast',
            array(), $this->_sitePageData, $this->_driverDB, $paramsYesterday, 0, TRUE,
            $elementsExport
        );
        foreach ($ids->childs as $child){
            $key = $child->values['take_shop_ballast_crusher_id'].'_'.$child->values['shop_id'];
            if(!key_exists($key, $listIDs->childs)){
                $child->additionDatas = $resultArray;
                $listIDs->childs[$key] = $child;
            }

            $listIDs->childs[$key]->additionDatas['export_yesterday'] += $child->values['quantity'];
        }

        // задаем время выборки с начала недели
        $dateFrom = Helpers_DateTime::getWeekBeginStr(date('Y-m-d')).' 06:00:00';
        $paramsImport['date_from'] = $dateFrom;

        $ids = Request_Request::findBranch('DB_Ab1_Shop_Ballast',
            array(), $this->_sitePageData, $this->_driverDB, $paramsImport, 0, TRUE,
            $elementsImport
        );
        foreach ($ids->childs as $child){
            $key = $child->values['shop_ballast_crusher_id'].'_'.$child->values['shop_id'];
            if(!key_exists($key, $listIDs->childs)){
                $child->additionDatas = $resultArray;
                $listIDs->childs[$key] = $child;
            }

            $listIDs->childs[$key]->additionDatas['import_week'] += $child->values['quantity'];
        }

        $paramsExport['date_from'] = $dateFrom;

        $ids = Request_Request::findBranch('DB_Ab1_Shop_Ballast',
            array(), $this->_sitePageData, $this->_driverDB, $paramsExport, 0, TRUE,
            $elementsExport
        );
        foreach ($ids->childs as $child){
            $key = $child->values['take_shop_ballast_crusher_id'].'_'.$child->values['shop_id'];
            if(!key_exists($key, $listIDs->childs)){
                $child->additionDatas = $resultArray;
                $listIDs->childs[$key] = $child;
            }

            $listIDs->childs[$key]->additionDatas['export_week'] += $child->values['quantity'];
        }

        // задаем время выборки с начала месяца
        $dateFrom = Helpers_DateTime::getMonthBeginStr(date('m'), date('Y')).' 06:00:00';
        $paramsImport['date_from'] = $dateFrom;

        $ids = Request_Request::findBranch('DB_Ab1_Shop_Ballast',
            array(), $this->_sitePageData, $this->_driverDB, $paramsImport, 0, TRUE,
            $elementsImport
        );
        foreach ($ids->childs as $child){
            $key = $child->values['shop_ballast_crusher_id'].'_'.$child->values['shop_id'];
            if(!key_exists($key, $listIDs->childs)){
                $child->additionDatas = $resultArray;
                $listIDs->childs[$key] = $child;
            }

            $listIDs->childs[$key]->additionDatas['import_month'] += $child->values['quantity'];
        }

        $paramsExport['date_from'] = $dateFrom;

        $ids = Request_Request::findBranch('DB_Ab1_Shop_Ballast',
            array(), $this->_sitePageData, $this->_driverDB, $paramsExport, 0, TRUE,
            $elementsExport
        );
        foreach ($ids->childs as $child){
            $key = $child->values['take_shop_ballast_crusher_id'].'_'.$child->values['shop_id'];
            if(!key_exists($key, $listIDs->childs)){
                $child->additionDatas = $resultArray;
                $listIDs->childs[$key] = $child;
            }

            $listIDs->childs[$key]->additionDatas['export_month'] += $child->values['quantity'];
        }

        // задаем время выборки с предыдущего месяца
        $paramsPreviousMonth = $paramsImport;
        $tmp = Helpers_DateTime::getMonthBeginStr(date('m'), date('Y')).' 06:00:00';
        $paramsPreviousMonth['date_to'] = $tmp;
        $paramsPreviousMonth['date_from'] = Helpers_DateTime::minusMonth($tmp, 1, true);

        $ids = Request_Request::findBranch('DB_Ab1_Shop_Ballast',
            array(), $this->_sitePageData, $this->_driverDB, $paramsPreviousMonth, 0, TRUE,
            $elementsImport
        );
        foreach ($ids->childs as $child){
            $key = $child->values['shop_ballast_crusher_id'].'_'.$child->values['shop_id'];
            if(!key_exists($key, $listIDs->childs)){
                $child->additionDatas = $resultArray;
                $listIDs->childs[$key] = $child;
            }

            $listIDs->childs[$key]->additionDatas['import_month_previous'] += $child->values['quantity'];
        }

        $paramsPreviousMonth = $paramsExport;
        $tmp = Helpers_DateTime::getMonthBeginStr(date('m'), date('Y')).' 06:00:00';
        $paramsPreviousMonth['date_to'] = $tmp;
        $paramsPreviousMonth['date_from'] = Helpers_DateTime::minusMonth($tmp, 1, true);

        $ids = Request_Request::findBranch('DB_Ab1_Shop_Ballast',
            array(), $this->_sitePageData, $this->_driverDB, $paramsPreviousMonth, 0, TRUE,
            $elementsExport
        );
        foreach ($ids->childs as $child){
            $key = $child->values['take_shop_ballast_crusher_id'].'_'.$child->values['shop_id'];
            if(!key_exists($key, $listIDs->childs)){
                $child->additionDatas = $resultArray;
                $listIDs->childs[$key] = $child;
            }

            $listIDs->childs[$key]->additionDatas['export_month_previous'] += $child->values['quantity'];
        }

        // задаем время выборки с начала года
        $dateFrom = Helpers_DateTime::getYearBeginStr(date('Y')).' 06:00:00';
        $paramsImport['date_from'] = $dateFrom;

        $ids = Request_Request::findBranch('DB_Ab1_Shop_Ballast',
            array(), $this->_sitePageData, $this->_driverDB, $paramsImport, 0, TRUE,
            $elementsImport
        );
        foreach ($ids->childs as $child){
            $key = $child->values['shop_ballast_crusher_id'].'_'.$child->values['shop_id'];
            if(!key_exists($key, $listIDs->childs)){
                $child->additionDatas = $resultArray;
                $listIDs->childs[$key] = $child;
            }

            $listIDs->childs[$key]->additionDatas['import_year'] += $child->values['quantity'];
        }

        $paramsExport['date_from'] = $dateFrom;

        $ids = Request_Request::findBranch('DB_Ab1_Shop_Ballast',
            array(), $this->_sitePageData, $this->_driverDB, $paramsExport, 0, TRUE,
            $elementsExport
        );
        foreach ($ids->childs as $child){
            $key = $child->values['take_shop_ballast_crusher_id'].'_'.$child->values['shop_id'];
            if(!key_exists($key, $listIDs->childs)){
                $child->additionDatas = $resultArray;
                $listIDs->childs[$key] = $child;
            }

            $listIDs->childs[$key]->additionDatas['export_year'] += $child->values['quantity'];
        }

        $listIDs->childsSortBy(
            array(
                Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_id.name',
            )
        );

        // узнаем остаток на начало года
        $dateFrom = Helpers_DateTime::getYearBeginStr(date('Y')).' 06:00:00';
        $paramsImport['date_from'] = null;
        $paramsImport['date_to'] = $dateFrom;

        $ids = Request_Request::findBranch('DB_Ab1_Shop_Ballast',
            array(), $this->_sitePageData, $this->_driverDB, $paramsImport, 0, TRUE,
            $elementsImport
        );
        foreach ($ids->childs as $child){
            $key = $child->values['shop_ballast_crusher_id'].'_'.$child->values['shop_id'];
            if(!key_exists($key, $listIDs->childs)){
                $child->additionDatas = $resultArray;
                $listIDs->childs[$key] = $child;
            }

            $listIDs->childs[$key]->additionDatas['from'] += $child->values['quantity'];
        }

        $paramsExport['date_from'] = null;
        $paramsExport['date_to'] = $dateFrom;

        $ids = Request_Request::findBranch('DB_Ab1_Shop_Ballast',
            array(), $this->_sitePageData, $this->_driverDB, $paramsExport, 0, TRUE,
            $elementsExport
        );
        foreach ($ids->childs as $child){
            $key = $child->values['take_shop_ballast_crusher_id'].'_'.$child->values['shop_id'];
            if(!key_exists($key, $listIDs->childs)){
                $child->additionDatas = $resultArray;
                $listIDs->childs[$key] = $child;
            }

            $listIDs->childs[$key]->additionDatas['from'] -= $child->values['quantity'];
        }

        // узнаем на текущий момент времени
        $paramsImport['date_from'] = null;
        $paramsImport['date_to'] = null;

        $ids = Request_Request::findBranch('DB_Ab1_Shop_Ballast',
            array(), $this->_sitePageData, $this->_driverDB, $paramsImport, 0, TRUE,
            $elementsImport
        );
        foreach ($ids->childs as $child){
            $key = $child->values['shop_ballast_crusher_id'].'_'.$child->values['shop_id'];
            if(!key_exists($key, $listIDs->childs)){
                $child->additionDatas = $resultArray;
                $listIDs->childs[$key] = $child;
            }

            $listIDs->childs[$key]->additionDatas['to'] += $child->values['quantity'];
        }

        $paramsExport['date_from'] = null;
        $paramsExport['date_to'] = null;

        $ids = Request_Request::findBranch('DB_Ab1_Shop_Ballast',
            array(), $this->_sitePageData, $this->_driverDB, $paramsExport, 0, TRUE,
            $elementsExport
        );
        foreach ($ids->childs as $child){
            $key = $child->values['take_shop_ballast_crusher_id'].'_'.$child->values['shop_id'];
            if(!key_exists($key, $listIDs->childs)){
                $child->additionDatas = $resultArray;
                $listIDs->childs[$key] = $child;
            }

            $listIDs->childs[$key]->additionDatas['to'] -= $child->values['quantity'];
        }

        $listIDs->childsSortBy(
            array(
                Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_id.name',
            )
        );

        // итог
        $listIDs->additionDatas = $listIDs->calcTotalsChild(
            array(
                'from',
                'to',

                'import_day',
                'import_yesterday',
                'import_week',
                'import_month',
                'import_month_previous',
                'import_year',

                'export_day',
                'export_yesterday',
                'export_week',
                'export_month',
                'export_month_previous',
                'export_year',
            ),
            true
        );


        $this->_sitePageData->newShopShablonPath('ab1/_all');

        $this->_sitePageData->countRecord = count($listIDs->childs);
        $this->_sitePageData->replaceDatas['view::_shop/ballast/list/statistics/storage'] = Helpers_View::getViewObjects(
            $listIDs, new Model_Ab1_Shop_Product_Rubric(),
            '_shop/ballast/list/statistics/storage','_shop/ballast/one/statistics/storage',
            $this->_sitePageData, $this->_driverDB
        );
        $this->_sitePageData->previousShopShablonPath();
    }

    protected function _actionShopBallastStatistics()
    {
        $this->_shopBallastStatisticsQuantityCount();
        $this->_shopBallastStatisticsQuantity();
        $this->_shopBallastStatisticsStorage();

        $this->_putInMain('/main/_shop/ballast/statistics');
    }

    protected function _actionShopBoxcarStatistics()
    {
        // статистика
        $this->_statisticsShopBoxcar();
        // Список вагонов на территории завода
        $this->_unloadShopBoxcar();
        // Список вагонов в пути
        $this->_inTransitShopBoxcar();

        $this->_putInMain('/main/_shop/boxcar/statistics');
    }

    /**
     * статистика
     */
    private function _statisticsShopBoxcar()
    {
        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/boxcar/list/statistics',
            )
        );
        $this->_requestShopBranches($this->_sitePageData->shopID, TRUE);

        $shopRawIDs = NULL;

        // задаем время выборки с начала дня
        $dateFrom = date('Y-m-d').' 06:00:00';
        $listIDs = new MyArray();
        $params = Request_RequestParams::setParams(
            array(
                'date_departure_from' => $dateFrom,
                'sum_quantity' => TRUE,
                'shop_raw_id' => $shopRawIDs,
                'shop_client_id' => 0,
                'group_by' => array(
                    'shop_raw_id', 'shop_raw_id.name',
                    'shop_boxcar_client_id', 'shop_boxcar_client_id.name',
                ),
            )
        );

        $elements = array(
            'shop_raw_id' => array('name'),
            'shop_boxcar_client_id' => array('name'),
        );

        $resultArray = array(
            'quantity_day' => 0,
            'quantity_yesterday' => 0,
            'quantity_week' => 0,
            'quantity_month' => 0,
            'quantity_month_previous' => 0,
            'quantity_year' => 0,
        );

        $ids = Request_Request::find('DB_Ab1_Shop_Boxcar',
            $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
            $elements
        );
        foreach ($ids->childs as $child){
            $shopClientID = $child->values['shop_raw_id'].'_'.$child->values['shop_boxcar_client_id'];
            if(!key_exists($shopClientID, $listIDs->childs)){
                $child->additionDatas = $resultArray;
                $listIDs->childs[$shopClientID] = $child;
            }

            $listIDs->childs[$shopClientID]->additionDatas['quantity_day'] += $child->values['quantity'];
        }

        // задаем время выборки вчера
        $paramsYesterday = $params;
        $paramsYesterday['date_departure_to'] = $dateFrom;
        $paramsYesterday['date_departure_from'] = Helpers_DateTime::minusDays($dateFrom, 1);

        $ids = Request_Request::find('DB_Ab1_Shop_Boxcar',
            $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB, $paramsYesterday, 0, TRUE,
            $elements
        );
        foreach ($ids->childs as $child){
            $shopClientID = $child->values['shop_raw_id'].'_'.$child->values['shop_boxcar_client_id'];
            if(!key_exists($shopClientID, $listIDs->childs)){
                $child->additionDatas = $resultArray;
                $listIDs->childs[$shopClientID] = $child;
            }

            $listIDs->childs[$shopClientID]->additionDatas['quantity_yesterday'] += $child->values['quantity'];
        }

        // задаем время выборки с начала недели
        $dateFrom = Helpers_DateTime::getWeekBeginStr(date('Y-m-d')).' 06:00:00';
        $params['date_departure_from'] = $dateFrom;

        $ids = Request_Request::find('DB_Ab1_Shop_Boxcar',
            $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
            $elements
        );
        foreach ($ids->childs as $child){
            $shopClientID = $child->values['shop_raw_id'].'_'.$child->values['shop_boxcar_client_id'];
            if(!key_exists($shopClientID, $listIDs->childs)){
                $child->additionDatas = $resultArray;
                $listIDs->childs[$shopClientID] = $child;
            }

            $listIDs->childs[$shopClientID]->additionDatas['quantity_week'] += $child->values['quantity'];
        }

        // задаем время выборки с начала месяца
        $dateFrom = Helpers_DateTime::getMonthBeginStr(date('m'), date('Y')).' 06:00:00';
        $params['date_departure_from'] = $dateFrom;

        $ids = Request_Request::find('DB_Ab1_Shop_Boxcar',
            $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
            $elements
        );
        foreach ($ids->childs as $child){
            $shopClientID = $child->values['shop_raw_id'].'_'.$child->values['shop_boxcar_client_id'];
            if(!key_exists($shopClientID, $listIDs->childs)){
                $child->additionDatas = $resultArray;
                $listIDs->childs[$shopClientID] = $child;
            }

            $listIDs->childs[$shopClientID]->additionDatas['quantity_month'] += $child->values['quantity'];
        }

        // задаем время выборки с предыдущего месяца
        $paramsPreviousMonth = $params;
        $tmp = Helpers_DateTime::getMonthBeginStr(date('m'), date('Y')).' 06:00:00';
        $paramsPreviousMonth['date_departure_to'] = $tmp;
        $paramsPreviousMonth['date_departure_from'] = Helpers_DateTime::minusMonth($tmp, 1, true);

        $ids = Request_Request::find('DB_Ab1_Shop_Boxcar',
            $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB, $paramsPreviousMonth, 0, TRUE,
            $elements
        );
        foreach ($ids->childs as $child){
            $shopClientID = $child->values['shop_raw_id'].'_'.$child->values['shop_boxcar_client_id'];
            if(!key_exists($shopClientID, $listIDs->childs)){
                $child->additionDatas = $resultArray;
                $listIDs->childs[$shopClientID] = $child;
            }

            $listIDs->childs[$shopClientID]->additionDatas['quantity_month_previous'] += $child->values['quantity'];
        }

        // задаем время выборки с начала года
        $dateFrom = Helpers_DateTime::getYearBeginStr(date('Y')).' 06:00:00';
        $params['date_departure_from'] = $dateFrom;

        $ids = Request_Request::find('DB_Ab1_Shop_Boxcar',
            $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
            $elements
        );
        foreach ($ids->childs as $child){
            $shopClientID = $child->values['shop_raw_id'].'_'.$child->values['shop_boxcar_client_id'];
            if(!key_exists($shopClientID, $listIDs->childs)){
                $child->additionDatas = $resultArray;
                $listIDs->childs[$shopClientID] = $child;
            }

            $listIDs->childs[$shopClientID]->additionDatas['quantity_year'] += $child->values['quantity'];
        }

        // задаем время выборки с за все время
        /* $params['date_departure_from'] = NULL;

         $ids = Request_Request::find('DB_Ab1_Shop_Boxcar',
             $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
            $elements
         );
        foreach ($ids->childs as $child){
            $shopClientID = $child->values['shop_raw_id'].'_'.$child->values['shop_boxcar_client_id'];
            if(!key_exists($shopClientID, $listIDs->childs)){
                if(!$isAll){
                    continue;
                }
                $child->additionDatas = $resultArray;
                $listIDs->childs[$shopClientID] = $child;
            }

            $listIDs->childs[$shopClientID]->additionDatas['quantity'] += $child->values['quantity'];
        }*/

        // итог
        $listIDs->additionDatas = $listIDs->calcTotalsChild(
            array(
                'quantity_day',
                'quantity_yesterday',
                'quantity_week',
                'quantity_month',
                'quantity_month_previous',
                'quantity_year',
            ),
            true
        );

        $listIDs->childsSortBy(
            array(
                Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_boxcar_client_id.name',
                Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_raw_id.name',
            )
        );
        $this->_sitePageData->countRecord = count($listIDs->childs);

        $this->_sitePageData->newShopShablonPath('ab1/_all');
        $this->_sitePageData->replaceDatas['view::_shop/boxcar/list/statistics'] = Helpers_View::getViewObjects(
            $listIDs, new Model_Ab1_Shop_Boxcar(),
            '_shop/boxcar/list/statistics','_shop/boxcar/one/statistics',
            $this->_sitePageData, $this->_driverDB
        );
        $this->_sitePageData->previousShopShablonPath();
    }

    /**
     * Список вагонов в пути
     * @throws Exception
     */
    private function _inTransitShopBoxcar() {
        $this->_setGlobalDatas(
            array(
                'view::_shop/boxcar/list/in-transit',
            )
        );

        $params = Request_RequestParams::setParams(
            array(
                'is_date_arrival_empty' => true,
                'count_id' => true,
                'sum_quantity' => true,
                'shop_client_id' => 0,
                'group_by' => array(
                    'shop_boxcar_client_id', 'shop_boxcar_client_id.name',
                    'shop_raw_id', 'shop_raw_id.name',
                    'shop_boxcar_train_id', 'shop_boxcar_train_id.date_shipment',
                ),
                'sort_by' => array(
                    'shop_boxcar_train_id.date_shipment' => 'desc',
                )
            )
        );
        $ids = Request_Request::find('DB_Ab1_Shop_Boxcar',
            $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB,
            $params, 0, TRUE,
            array(
                'shop_boxcar_client_id' => array('name'),
                'shop_raw_id' => array('name'),
                'shop_boxcar_train_id' => array('date_shipment'),
            )
        );

        $total = array(
            'count' => 0,
            'quantity' => 0,
        );
        foreach ($ids->childs as $child){
            $total['count'] += $child->values['count'];
            $total['quantity'] += $child->values['quantity'];
        }
        $ids->additionDatas = $total;
        uasort($ids->childs, function (MyArray $x, MyArray $y) {
            $result = strcasecmp($x->getElementValue('shop_boxcar_client_id', 'name'), $y->getElementValue('shop_boxcar_client_id', 'name'));
            if($result != 0){
                return $result;
            }

            return strcasecmp($x->getElementValue('shop_boxcar_train_id', 'date_shipment'), $y->getElementValue('shop_boxcar_train_id', 'date_shipment')) * (-1);
        });

        $this->_sitePageData->newShopShablonPath('ab1/_all');
        $this->_sitePageData->replaceDatas['view::_shop/boxcar/list/in-transit'] = Helpers_View::getViewObjects(
            $ids, new Model_Ab1_Shop_Boxcar(),
            '_shop/boxcar/list/in-transit','_shop/boxcar/one/in-transit',
            $this->_sitePageData, $this->_driverDB
        );
        $this->_sitePageData->previousShopShablonPath();
    }

    /**
     * Список вагонов, которые на территории
     * @throws Exception
     */
    private function _unloadShopBoxcar() {
        $this->_setGlobalDatas(
            array(
                'view::_shop/boxcar/list/unload',
            )
        );

        $params = Request_RequestParams::setParams(
            array(
                'is_date_arrival_empty' => false,
                'is_date_departure_empty' => TRUE,
                'count_id' => true,
                'sum_quantity' => true,
                'shop_client_id' => 0,
                'group_by' => array(
                    'shop_boxcar_train_id',
                    'shop_boxcar_client_id', 'shop_boxcar_client_id.name',
                    'shop_raw_id', 'shop_raw_id.name',
                    'date_arrival', 'date_drain_from', 'date_drain_to',
                ),
                'sort_by' => array(
                    'date_drain_from' => 'desc',
                )
            )
        );
        $ids = Request_Request::find('DB_Ab1_Shop_Boxcar',
            $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB,
            $params, 0, TRUE,
            array(
                'shop_boxcar_client_id' => array('name'),
                'shop_raw_id' => array('name'),
            )
        );

        $total = array(
            'count' => 0,
            'quantity' => 0,
        );
        foreach ($ids->childs as $child){
            $total['count'] += $child->values['count'];
            $total['quantity'] += $child->values['quantity'];
        }
        $ids->additionDatas = $total;

        $this->_sitePageData->newShopShablonPath('ab1/_all');
        $this->_sitePageData->replaceDatas['view::_shop/boxcar/list/unload'] = Helpers_View::getViewObjects(
            $ids, new Model_Ab1_Shop_Boxcar(),
            '_shop/boxcar/list/unload','_shop/boxcar/one/unload',
            $this->_sitePageData, $this->_driverDB
        );
        $this->_sitePageData->previousShopShablonPath();
    }

    protected function _actionShopDaughterStatistics()
    {
        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/daughter/list/statistics',
            )
        );
        $this->_requestShopBranches(NULL, TRUE);
        $this->_requestShopDaughters();

        $shopMaterialIDs = NULL;

        // задаем время выборки с начала дня
        $dateFrom = date('Y-m-d').' 06:00:00';
        $listIDs = new MyArray();
        $params = Request_RequestParams::setParams(
            array(
                'date_document_from' => $dateFrom,
                'sum_daughter_weight' => TRUE,
                'is_charity' => FALSE,
                'shop_material_id' => $shopMaterialIDs,
                'shop_branch_receiver_id' => $this->_sitePageData->shopID,
                'daughter_id' => Request_RequestParams::getParamInt('daughter_id'),
                'group_by' => array(
                    'shop_material_id', 'shop_material_id.name',
                ),
            )
        );

        $elements = array(
            'shop_material_id' => array('name'),
        );

        $resultArray = array(
            'quantity_day' => 0,
            'quantity_yesterday' => 0,
            'quantity_week' => 0,
            'quantity_month' => 0,
            'quantity_month_previous' => 0,
            'quantity_year' => 0,
        );

        $ids = Request_Request::find('DB_Ab1_Shop_Car_To_Material',
            $this->_sitePageData->shopMainID, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
            $elements
        );
        foreach ($ids->childs as $child){
            $shopClientID = $child->values['shop_material_id'];
            if(!key_exists($shopClientID, $listIDs->childs)){
                $child->additionDatas = $resultArray;
                $listIDs->childs[$shopClientID] = $child;
            }

            $listIDs->childs[$shopClientID]->additionDatas['quantity_day'] += $child->values['quantity'];
        }

        // задаем время выборки вчера
        $paramsYesterday = $params;
        $paramsYesterday['date_document_to'] = $dateFrom;
        $paramsYesterday['date_document_from'] = Helpers_DateTime::minusDays($dateFrom, 1);

        $ids = Request_Request::find('DB_Ab1_Shop_Car_To_Material',
            $this->_sitePageData->shopMainID, $this->_sitePageData, $this->_driverDB, $paramsYesterday, 0, TRUE,
            $elements
        );
        foreach ($ids->childs as $child){
            $shopClientID = $child->values['shop_material_id'];
            if(!key_exists($shopClientID, $listIDs->childs)){
                $child->additionDatas = $resultArray;
                $listIDs->childs[$shopClientID] = $child;
            }

            $listIDs->childs[$shopClientID]->additionDatas['quantity_yesterday'] += $child->values['quantity'];
        }

        // задаем время выборки с начала недели
        $dateFrom = Helpers_DateTime::getWeekBeginStr(date('Y-m-d')).' 06:00:00';
        $params['date_document_from'] = $dateFrom;

        $ids = Request_Request::find('DB_Ab1_Shop_Car_To_Material',
            $this->_sitePageData->shopMainID, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
            $elements
        );
        foreach ($ids->childs as $child){
            $shopClientID = $child->values['shop_material_id'];
            if(!key_exists($shopClientID, $listIDs->childs)){
                $child->additionDatas = $resultArray;
                $listIDs->childs[$shopClientID] = $child;
            }

            $listIDs->childs[$shopClientID]->additionDatas['quantity_week'] += $child->values['quantity'];
        }

        // задаем время выборки с начала месяца
        $dateFrom = Helpers_DateTime::getMonthBeginStr(date('m'), date('Y')).' 06:00:00';
        $params['date_document_from'] = $dateFrom;

        $ids = Request_Request::find('DB_Ab1_Shop_Car_To_Material',
            $this->_sitePageData->shopMainID, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
            $elements
        );
        foreach ($ids->childs as $child){
            $shopClientID = $child->values['shop_material_id'];
            if(!key_exists($shopClientID, $listIDs->childs)){
                $child->additionDatas = $resultArray;
                $listIDs->childs[$shopClientID] = $child;
            }

            $listIDs->childs[$shopClientID]->additionDatas['quantity_month'] += $child->values['quantity'];
        }

        // задаем время выборки с предыдущего месяца
        $paramsPreviousMonth = $params;
        $tmp = Helpers_DateTime::getMonthBeginStr(date('m'), date('Y')).' 06:00:00';
        $paramsPreviousMonth['date_document_to'] = $tmp;
        $paramsPreviousMonth['date_document_from'] = Helpers_DateTime::minusMonth($tmp, 1, true);

        $ids = Request_Request::find('DB_Ab1_Shop_Car_To_Material',
            $this->_sitePageData->shopMainID, $this->_sitePageData, $this->_driverDB, $paramsPreviousMonth, 0, TRUE,
            $elements
        );
        foreach ($ids->childs as $child){
            $shopClientID = $child->values['shop_material_id'];
            if(!key_exists($shopClientID, $listIDs->childs)){
                $child->additionDatas = $resultArray;
                $listIDs->childs[$shopClientID] = $child;
            }

            $listIDs->childs[$shopClientID]->additionDatas['quantity_month_previous'] += $child->values['quantity'];
        }

        // задаем время выборки с начала года
        $dateFrom = Helpers_DateTime::getYearBeginStr(date('Y')).' 06:00:00';
        $params['date_document_from'] = $dateFrom;

        $ids = Request_Request::find('DB_Ab1_Shop_Car_To_Material',
            $this->_sitePageData->shopMainID, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
            $elements
        );
        foreach ($ids->childs as $child){
            $shopClientID = $child->values['shop_material_id'];
            if(!key_exists($shopClientID, $listIDs->childs)){
                $child->additionDatas = $resultArray;
                $listIDs->childs[$shopClientID] = $child;
            }

            $listIDs->childs[$shopClientID]->additionDatas['quantity_year'] += $child->values['quantity'];
        }

        // задаем время выборки с за все время
        /* $params['date_document_from'] = NULL;

         $ids = Request_Request::find('DB_Ab1_Shop_Car_To_Material',
             $this->_sitePageData->shopMainID, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
            $elements
         );
        foreach ($ids->childs as $child){
            $shopClientID = $child->values['shop_material_id'];
            if(!key_exists($shopClientID, $listIDs->childs)){
                if(!$isAll){
                    continue;
                }
                $child->additionDatas = $resultArray;
                $listIDs->childs[$shopClientID] = $child;
            }

            $listIDs->childs[$shopClientID]->additionDatas['quantity'] += $child->values['quantity'];
        }*/

        // итог
        $listIDs->additionDatas = $listIDs->calcTotalsChild(
            array(
                'quantity_day',
                'quantity_yesterday',
                'quantity_week',
                'quantity_month',
                'quantity_month_previous',
                'quantity_year',
            ),
            true
        );

        $listIDs->childsSortBy(
            array(
                Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_material_id.name',
            )
        );

        $this->_sitePageData->countRecord = count($listIDs->childs);

        $this->_sitePageData->newShopShablonPath('ab1/_all');
        $this->_sitePageData->replaceDatas['view::_shop/daughter/list/statistics'] = Helpers_View::getViewObjects(
            $listIDs, new Model_Ab1_Shop_Product_Rubric(),
            '_shop/daughter/list/statistics','_shop/daughter/one/statistics',
            $this->_sitePageData, $this->_driverDB
        );
        $this->_sitePageData->previousShopShablonPath();

        $this->_putInMain('/main/_shop/daughter/statistics');
    }

    /**
     * Завоз материалов сгруппированые по материалам
     * @param $shopMaterialIDs
     */
    private function _actionShopCarToMaterialStatisticsMaterial($shopMaterialIDs)
    {
        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/car/to/material/list/statistics-material',
            )
        );

        // задаем время выборки с начала дня
        $dateFrom = date('Y-m-d').' 06:00:00';
        $listIDs = new MyArray();
        $params = Request_RequestParams::setParams(
            array(
                'date_document_from' => $dateFrom,
                'sum_daughter_weight' => TRUE,
                'shop_material_id' => $shopMaterialIDs,
                'shop_branch_receiver_id' => $this->_sitePageData->shopID,
                'is_weighted' => true,
                'is_import_car' => true,
                'group_by' => array(
                    'shop_material_id', 'shop_material_id.name',
                ),
            )
        );

        $elements = array(
            'shop_material_id' => array('name'),
        );

        $resultArray = array(
            'quantity_day' => 0,
            'quantity_yesterday' => 0,
            'quantity_week' => 0,
            'quantity_month' => 0,
            'quantity_month_previous' => 0,
            'quantity_year' => 0,
        );

        $ids = Request_Request::find('DB_Ab1_Shop_Car_To_Material',
            $this->_sitePageData->shopMainID, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
            $elements
        );
        foreach ($ids->childs as $child){
            $shopClientID = $child->values['shop_material_id'];
            if(!key_exists($shopClientID, $listIDs->childs)){
                $child->additionDatas = $resultArray;
                $listIDs->childs[$shopClientID] = $child;
            }

            $listIDs->childs[$shopClientID]->additionDatas['quantity_day'] += $child->values['quantity'];
        }

        // задаем время выборки вчера
        $paramsYesterday = $params;
        $paramsYesterday['date_document_to'] = $dateFrom;
        $paramsYesterday['date_document_from'] = Helpers_DateTime::minusDays($dateFrom, 1);

        $ids = Request_Request::find('DB_Ab1_Shop_Car_To_Material',
            $this->_sitePageData->shopMainID, $this->_sitePageData, $this->_driverDB, $paramsYesterday, 0, TRUE,
            $elements
        );
        foreach ($ids->childs as $child){
            $shopClientID = $child->values['shop_material_id'];
            if(!key_exists($shopClientID, $listIDs->childs)){
                $child->additionDatas = $resultArray;
                $listIDs->childs[$shopClientID] = $child;
            }

            $listIDs->childs[$shopClientID]->additionDatas['quantity_yesterday'] += $child->values['quantity'];
        }

        // задаем время выборки с начала недели
        $dateFrom = Helpers_DateTime::getWeekBeginStr(date('Y-m-d')).' 06:00:00';
        $params['date_document_from'] = $dateFrom;

        $ids = Request_Request::find('DB_Ab1_Shop_Car_To_Material',
            $this->_sitePageData->shopMainID, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
            $elements
        );
        foreach ($ids->childs as $child){
            $shopClientID = $child->values['shop_material_id'];
            if(!key_exists($shopClientID, $listIDs->childs)){
                $child->additionDatas = $resultArray;
                $listIDs->childs[$shopClientID] = $child;
            }

            $listIDs->childs[$shopClientID]->additionDatas['quantity_week'] += $child->values['quantity'];
        }

        // задаем время выборки с начала месяца
        $dateFrom = Helpers_DateTime::getMonthBeginStr(date('m'), date('Y')).' 06:00:00';
        $params['date_document_from'] = $dateFrom;

        $ids = Request_Request::find('DB_Ab1_Shop_Car_To_Material',
            $this->_sitePageData->shopMainID, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
            $elements
        );
        foreach ($ids->childs as $child){
            $shopClientID = $child->values['shop_material_id'];
            if(!key_exists($shopClientID, $listIDs->childs)){
                $child->additionDatas = $resultArray;
                $listIDs->childs[$shopClientID] = $child;
            }

            $listIDs->childs[$shopClientID]->additionDatas['quantity_month'] += $child->values['quantity'];
        }

        // задаем время выборки с предыдущего месяца
        $paramsPreviousMonth = $params;
        $tmp = Helpers_DateTime::getMonthBeginStr(date('m'), date('Y')).' 06:00:00';
        $paramsPreviousMonth['date_document_to'] = $tmp;
        $paramsPreviousMonth['date_document_from'] = Helpers_DateTime::minusMonth($tmp, 1, true);

        $ids = Request_Request::find('DB_Ab1_Shop_Car_To_Material',
            $this->_sitePageData->shopMainID, $this->_sitePageData, $this->_driverDB, $paramsPreviousMonth, 0, TRUE,
            $elements
        );
        foreach ($ids->childs as $child){
            $shopClientID = $child->values['shop_material_id'];
            if(!key_exists($shopClientID, $listIDs->childs)){
                $child->additionDatas = $resultArray;
                $listIDs->childs[$shopClientID] = $child;
            }

            $listIDs->childs[$shopClientID]->additionDatas['quantity_month_previous'] += $child->values['quantity'];
        }

        // задаем время выборки с начала года
        $dateFrom = Helpers_DateTime::getYearBeginStr(date('Y')).' 06:00:00';
        $params['date_document_from'] = $dateFrom;

        $ids = Request_Request::find('DB_Ab1_Shop_Car_To_Material',
            $this->_sitePageData->shopMainID, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
            $elements
        );
        foreach ($ids->childs as $child){
            $shopClientID = $child->values['shop_material_id'];
            if(!key_exists($shopClientID, $listIDs->childs)){
                $child->additionDatas = $resultArray;
                $listIDs->childs[$shopClientID] = $child;
            }

            $listIDs->childs[$shopClientID]->additionDatas['quantity_year'] += $child->values['quantity'];
        }

        // задаем время выборки с за все время
        /* $params['date_document_from'] = NULL;

         $ids = Request_Request::find('DB_Ab1_Shop_Car_To_Material',
             $this->_sitePageData->shopMainID, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
            $elements
         );
        foreach ($ids->childs as $child){
            $shopClientID = $child->values['shop_material_id'];
            if(!key_exists($shopClientID, $listIDs->childs)){
                $child->additionDatas = $resultArray;
                $listIDs->childs[$shopClientID] = $child;
            }

            $listIDs->childs[$shopClientID]->additionDatas['quantity'] += $child->values['quantity'];
        }*/

        // итог
        $listIDs->additionDatas = $listIDs->calcTotalsChild(
            array(
                'quantity_day',
                'quantity_yesterday',
                'quantity_week',
                'quantity_month',
                'quantity_month_previous',
                'quantity_year',
            ),
            true
        );

        $listIDs->childsSortBy(
            array(
                Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_material_id.name',
            )
        );

        $this->_sitePageData->countRecord = count($listIDs->childs);

        $this->_sitePageData->newShopShablonPath('ab1/_all');
        $this->_sitePageData->replaceDatas['view::_shop/car/to/material/list/statistics-material'] = Helpers_View::getViewObjects(
            $listIDs, new Model_Ab1_Shop_Product_Rubric(),
            '_shop/car/to/material/list/statistics-material','_shop/car/to/material/one/statistics-material',
            $this->_sitePageData, $this->_driverDB
        );
        $this->_sitePageData->previousShopShablonPath();
    }

    /**
     * Завоз материалов сгруппированые по отправителям
     * @param $shopMaterialIDs
     */
    private function _actionShopCarToMaterialStatisticsDaughter($shopMaterialIDs)
    {
        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/car/to/material/list/statistics',
            )
        );

        // задаем время выборки с начала дня
        $dateFrom = date('Y-m-d').' 06:00:00';
        $listIDs = new MyArray();
        $params = Request_RequestParams::setParams(
            array(
                'date_document_from' => $dateFrom,
                'sum_daughter_weight' => TRUE,
                'shop_material_id' => $shopMaterialIDs,
                'shop_branch_receiver_id' => $this->_sitePageData->shopID,
                'is_weighted' => true,
                'is_import_car' => true,
                'group_by' => array(
                    'shop_daughter_id', 'shop_daughter_id.name',
                    'shop_branch_daughter_id', 'shop_branch_daughter_id.name',
                ),
            )
        );

        $elements = array(
            'shop_daughter_id' => array('name'),
            'shop_branch_daughter_id' => array('name'),
        );

        $resultArray = array(
            'quantity_day' => 0,
            'quantity_yesterday' => 0,
            'quantity_week' => 0,
            'quantity_month' => 0,
            'quantity_month_previous' => 0,
            'quantity_year' => 0,
        );

        $ids = Request_Request::find('DB_Ab1_Shop_Car_To_Material',
            $this->_sitePageData->shopMainID, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
            $elements
        );
        foreach ($ids->childs as $child){
            $shopClientID = $child->values['shop_daughter_id'].'_'.$child->values['shop_branch_daughter_id'];
            if(!key_exists($shopClientID, $listIDs->childs)){
                $child->additionDatas = $resultArray;
                $listIDs->childs[$shopClientID] = $child;
            }

            $listIDs->childs[$shopClientID]->additionDatas['quantity_day'] += $child->values['quantity'];
        }

        // задаем время выборки вчера
        $paramsYesterday = $params;
        $paramsYesterday['date_document_to'] = $dateFrom;
        $paramsYesterday['date_document_from'] = Helpers_DateTime::minusDays($dateFrom, 1);

        $ids = Request_Request::find('DB_Ab1_Shop_Car_To_Material',
            $this->_sitePageData->shopMainID, $this->_sitePageData, $this->_driverDB, $paramsYesterday, 0, TRUE,
            $elements
        );
        foreach ($ids->childs as $child){
            $shopClientID = $child->values['shop_daughter_id'].'_'.$child->values['shop_branch_daughter_id'];
            if(!key_exists($shopClientID, $listIDs->childs)){
                $child->additionDatas = $resultArray;
                $listIDs->childs[$shopClientID] = $child;
            }

            $listIDs->childs[$shopClientID]->additionDatas['quantity_yesterday'] += $child->values['quantity'];
        }

        // задаем время выборки с начала недели
        $dateFrom = Helpers_DateTime::getWeekBeginStr(date('Y-m-d')).' 06:00:00';
        $params['date_document_from'] = $dateFrom;

        $ids = Request_Request::find('DB_Ab1_Shop_Car_To_Material',
            $this->_sitePageData->shopMainID, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
            $elements
        );
        foreach ($ids->childs as $child){
            $shopClientID = $child->values['shop_daughter_id'].'_'.$child->values['shop_branch_daughter_id'];
            if(!key_exists($shopClientID, $listIDs->childs)){
                $child->additionDatas = $resultArray;
                $listIDs->childs[$shopClientID] = $child;
            }

            $listIDs->childs[$shopClientID]->additionDatas['quantity_week'] += $child->values['quantity'];
        }

        // задаем время выборки с начала месяца
        $dateFrom = Helpers_DateTime::getMonthBeginStr(date('m'), date('Y')).' 06:00:00';
        $params['date_document_from'] = $dateFrom;

        $ids = Request_Request::find('DB_Ab1_Shop_Car_To_Material',
            $this->_sitePageData->shopMainID, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
            $elements
        );
        foreach ($ids->childs as $child){
            $shopClientID = $child->values['shop_daughter_id'].'_'.$child->values['shop_branch_daughter_id'];
            if(!key_exists($shopClientID, $listIDs->childs)){
                $child->additionDatas = $resultArray;
                $listIDs->childs[$shopClientID] = $child;
            }

            $listIDs->childs[$shopClientID]->additionDatas['quantity_month'] += $child->values['quantity'];
        }

        // задаем время выборки с предыдущего месяца
        $paramsPreviousMonth = $params;
        $tmp = Helpers_DateTime::getMonthBeginStr(date('m'), date('Y')).' 06:00:00';
        $paramsPreviousMonth['date_document_to'] = $tmp;
        $paramsPreviousMonth['date_document_from'] = Helpers_DateTime::minusMonth($tmp, 1, true);

        $ids = Request_Request::find('DB_Ab1_Shop_Car_To_Material',
            $this->_sitePageData->shopMainID, $this->_sitePageData, $this->_driverDB, $paramsPreviousMonth, 0, TRUE,
            $elements
        );
        foreach ($ids->childs as $child){
            $shopClientID = $child->values['shop_daughter_id'].'_'.$child->values['shop_branch_daughter_id'];
            if(!key_exists($shopClientID, $listIDs->childs)){
                $child->additionDatas = $resultArray;
                $listIDs->childs[$shopClientID] = $child;
            }

            $listIDs->childs[$shopClientID]->additionDatas['quantity_month_previous'] += $child->values['quantity'];
        }

        // задаем время выборки с начала года
        $dateFrom = Helpers_DateTime::getYearBeginStr(date('Y')).' 06:00:00';
        $params['date_document_from'] = $dateFrom;

        $ids = Request_Request::find('DB_Ab1_Shop_Car_To_Material',
            $this->_sitePageData->shopMainID, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
            $elements
        );
        foreach ($ids->childs as $child){
            $shopClientID = $child->values['shop_daughter_id'].'_'.$child->values['shop_branch_daughter_id'];
            if(!key_exists($shopClientID, $listIDs->childs)){
                $child->additionDatas = $resultArray;
                $listIDs->childs[$shopClientID] = $child;
            }

            $listIDs->childs[$shopClientID]->additionDatas['quantity_year'] += $child->values['quantity'];
        }

        // задаем время выборки с за все время
        /* $params['date_document_from'] = NULL;

         $ids = Request_Request::find('DB_Ab1_Shop_Car_To_Material',
             $this->_sitePageData->shopMainID, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
            $elements
         );
        foreach ($ids->childs as $child){
            $shopClientID = $child->values['shop_daughter_id'].'_'.$child->values['shop_branch_daughter_id'];
            if(!key_exists($shopClientID, $listIDs->childs)){
                $child->additionDatas = $resultArray;
                $listIDs->childs[$shopClientID] = $child;
            }

            $listIDs->childs[$shopClientID]->additionDatas['quantity'] += $child->values['quantity'];
        }*/

        // итог
        $listIDs->additionDatas = $listIDs->calcTotalsChild(
            array(
                'quantity_day',
                'quantity_yesterday',
                'quantity_week',
                'quantity_month',
                'quantity_month_previous',
                'quantity_year',
            ),
            true
        );

        $listIDs->childsSortBy(
            array(
                Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_daughter_id.name',
                Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_branch_daughter_id.name',
            )
        );

        $this->_sitePageData->countRecord = count($listIDs->childs);

        $this->_sitePageData->newShopShablonPath('ab1/_all');
        $this->_sitePageData->replaceDatas['view::_shop/car/to/material/list/statistics'] = Helpers_View::getViewObjects(
            $listIDs, new Model_Ab1_Shop_Product_Rubric(),
            '_shop/car/to/material/list/statistics','_shop/car/to/material/one/statistics',
            $this->_sitePageData, $this->_driverDB
        );
        $this->_sitePageData->previousShopShablonPath();
    }

    /**
     * Завоз материалов сгруппированые по собственным машинам
     * @param $shopMaterialIDs
     * @param $isImportCar
     */
    private function _actionShopCarToMaterialStatisticsOwn($shopMaterialIDs, $isImportCar)
    {
        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/car/to/material/list/statistics-own',
            )
        );

        // задаем время выборки с начала дня
        $dateFrom = date('Y-m-d').' 06:00:00';
        $listIDs = new MyArray();
        $params = Request_RequestParams::setParams(
            array(
                'date_document_from' => $dateFrom,
                'sum_daughter_weight' => TRUE,
                'shop_material_id' => $shopMaterialIDs,
                'shop_branch_receiver_id' => $this->_sitePageData->shopID,
                'is_weighted' => true,
                'is_import_car' => $isImportCar,
                'group_by' => array(
                    'shop_transport_company_id.is_own',
                ),
            )
        );

        $elements = array(
            'shop_transport_company_id' => array('is_own'),
        );

        $resultArray = array(
            'quantity_day' => 0,
            'quantity_yesterday' => 0,
            'quantity_week' => 0,
            'quantity_month' => 0,
            'quantity_month_previous' => 0,
            'quantity_year' => 0,
        );

        $ids = Request_Request::find('DB_Ab1_Shop_Car_To_Material',
            $this->_sitePageData->shopMainID, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
            $elements
        );
        foreach ($ids->childs as $child){
            $isOwn = $child->getElementValue('shop_transport_company_id', 'is_own');
            if(!key_exists($isOwn, $listIDs->childs)){
                $child->additionDatas = $resultArray;
                $listIDs->childs[$isOwn] = $child;
            }

            $listIDs->childs[$isOwn]->additionDatas['quantity_day'] += $child->values['quantity'];
        }

        // задаем время выборки вчера
        $paramsYesterday = $params;
        $paramsYesterday['date_document_to'] = $dateFrom;
        $paramsYesterday['date_document_from'] = Helpers_DateTime::minusDays($dateFrom, 1);

        $ids = Request_Request::find('DB_Ab1_Shop_Car_To_Material',
            $this->_sitePageData->shopMainID, $this->_sitePageData, $this->_driverDB, $paramsYesterday, 0, TRUE,
            $elements
        );
        foreach ($ids->childs as $child){
            $isOwn = $child->getElementValue('shop_transport_company_id', 'is_own');
            if(!key_exists($isOwn, $listIDs->childs)){
                $child->additionDatas = $resultArray;
                $listIDs->childs[$isOwn] = $child;
            }

            $listIDs->childs[$isOwn]->additionDatas['quantity_yesterday'] += $child->values['quantity'];
        }

        // задаем время выборки с начала недели
        $dateFrom = Helpers_DateTime::getWeekBeginStr(date('Y-m-d')).' 06:00:00';
        $params['date_document_from'] = $dateFrom;

        $ids = Request_Request::find('DB_Ab1_Shop_Car_To_Material',
            $this->_sitePageData->shopMainID, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
            $elements
        );
        foreach ($ids->childs as $child){
            $isOwn = $child->getElementValue('shop_transport_company_id', 'is_own');
            if(!key_exists($isOwn, $listIDs->childs)){
                $child->additionDatas = $resultArray;
                $listIDs->childs[$isOwn] = $child;
            }

            $listIDs->childs[$isOwn]->additionDatas['quantity_week'] += $child->values['quantity'];
        }

        // задаем время выборки с начала месяца
        $dateFrom = Helpers_DateTime::getMonthBeginStr(date('m'), date('Y')).' 06:00:00';
        $params['date_document_from'] = $dateFrom;

        $ids = Request_Request::find('DB_Ab1_Shop_Car_To_Material',
            $this->_sitePageData->shopMainID, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
            $elements
        );
        foreach ($ids->childs as $child){
            $isOwn = $child->getElementValue('shop_transport_company_id', 'is_own');
            if(!key_exists($isOwn, $listIDs->childs)){
                $child->additionDatas = $resultArray;
                $listIDs->childs[$isOwn] = $child;
            }

            $listIDs->childs[$isOwn]->additionDatas['quantity_month'] += $child->values['quantity'];
        }

        // задаем время выборки с предыдущего месяца
        $paramsPreviousMonth = $params;
        $tmp = Helpers_DateTime::getMonthBeginStr(date('m'), date('Y')).' 06:00:00';
        $paramsPreviousMonth['date_document_to'] = $tmp;
        $paramsPreviousMonth['date_document_from'] = Helpers_DateTime::minusMonth($tmp, 1, true);

        $ids = Request_Request::find('DB_Ab1_Shop_Car_To_Material',
            $this->_sitePageData->shopMainID, $this->_sitePageData, $this->_driverDB, $paramsPreviousMonth, 0, TRUE,
            $elements
        );
        foreach ($ids->childs as $child){
            $isOwn = $child->getElementValue('shop_transport_company_id', 'is_own');
            if(!key_exists($isOwn, $listIDs->childs)){
                $child->additionDatas = $resultArray;
                $listIDs->childs[$isOwn] = $child;
            }

            $listIDs->childs[$isOwn]->additionDatas['quantity_month_previous'] += $child->values['quantity'];
        }

        // задаем время выборки с начала года
        $dateFrom = Helpers_DateTime::getYearBeginStr(date('Y')).' 06:00:00';
        $params['date_document_from'] = $dateFrom;

        $ids = Request_Request::find('DB_Ab1_Shop_Car_To_Material',
            $this->_sitePageData->shopMainID, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
            $elements
        );
        foreach ($ids->childs as $child){
            $isOwn = $child->getElementValue('shop_transport_company_id', 'is_own');
            if(!key_exists($isOwn, $listIDs->childs)){
                $child->additionDatas = $resultArray;
                $listIDs->childs[$isOwn] = $child;
            }

            $listIDs->childs[$isOwn]->additionDatas['quantity_year'] += $child->values['quantity'];
        }

        // задаем время выборки с за все время
        /* $params['date_document_from'] = NULL;

         $ids = Request_Request::find('DB_Ab1_Shop_Car_To_Material',
             $this->_sitePageData->shopMainID, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
            $elements
         );
        foreach ($ids->childs as $child){
            $isOwn = $child->getElementValue('shop_transport_company_id', 'is_own');
            if(!key_exists($isOwn, $listIDs->childs)){
                $child->additionDatas = $resultArray;
                $listIDs->childs[$isOwn] = $child;
            }

            $listIDs->childs[$isOwn]->additionDatas['quantity'] += $child->values['quantity'];
        }*/

        // итог
        $listIDs->additionDatas = $listIDs->calcTotalsChild(
            array(
                'quantity_day',
                'quantity_yesterday',
                'quantity_week',
                'quantity_month',
                'quantity_month_previous',
                'quantity_year',
            ),
            true
        );

        $listIDs->childsSortBy(
            array(
                Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_transport_company_id.is_own',
            )
        );

        $this->_sitePageData->countRecord = count($listIDs->childs);

        $this->_sitePageData->newShopShablonPath('ab1/_all');
        $this->_sitePageData->replaceDatas['view::_shop/car/to/material/list/statistics-own'] = Helpers_View::getViewObjects(
            $listIDs, new Model_Ab1_Shop_Product_Rubric(),
            '_shop/car/to/material/list/statistics-own','_shop/car/to/material/one/statistics-own',
            $this->_sitePageData, $this->_driverDB
        );
        $this->_sitePageData->previousShopShablonPath();
    }

    protected function _actionShopCarToMaterialStatistics()
    {
        $this->_requestShopBranches($this->_sitePageData->shopID, TRUE);

        $shopMaterialIDs = NULL;
        $isImportCar = Request_RequestParams::getParamBoolean('is_import_car');

        //Завоз материалов сгруппированые по материалам
        $this->_actionShopCarToMaterialStatisticsMaterial($shopMaterialIDs, $isImportCar);

        //Завоз материалов сгруппированые по отправителям
        $this->_actionShopCarToMaterialStatisticsDaughter($shopMaterialIDs, $isImportCar);

        // Завоз материалов сгруппированые по собственным машинам
        $this->_actionShopCarToMaterialStatisticsOwn($shopMaterialIDs, $isImportCar);

        $this->_putInMain('/main/_shop/car/to/material/statistics');
    }

    protected function _actionShopCarToMaterialSubdivisionStatistics()
    {
        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/car/to/material/list/statistics-subdivision',
            )
        );
        $this->_requestShopBranches($this->_sitePageData->shopID, TRUE);

        $shopMaterialIDs = NULL;

        // задаем время выборки с начала дня
        $dateFrom = date('Y-m-d').' 06:00:00';
        $listIDs = new MyArray();
        $params = Request_RequestParams::setParams(
            array(
                'is_import_car' => false,
                'date_document_from' => $dateFrom,
                'sum_daughter_weight' => TRUE,
                'shop_material_id' => $shopMaterialIDs,
                'shop_branch_receiver_id' => $this->_sitePageData->shopID,
                'shop_transport_company_id.is_own' => Request_RequestParams::getParamBoolean('is_own'),
                'group_by' => array(
                    'shop_subdivision_daughter_id', 'shop_subdivision_daughter_id.name',
                    'shop_subdivision_receiver_id', 'shop_subdivision_receiver_id.name',
                    'shop_material_id', 'shop_material_id.name',
                ),
            )
        );

        $elements = array(
            'shop_subdivision_receiver_id' => array('name'),
            'shop_subdivision_daughter_id' => array('name'),
            'shop_material_id' => array('name'),
        );

        $resultArray = array(
            'quantity_day' => 0,
            'quantity_yesterday' => 0,
            'quantity_week' => 0,
            'quantity_month' => 0,
            'quantity_month_previous' => 0,
            'quantity_year' => 0,
        );

        $ids = Request_Request::find(
            'DB_Ab1_Shop_Car_To_Material', $this->_sitePageData->shopMainID,
            $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
            $elements
        );
        foreach ($ids->childs as $child){
            $shopClientID = $child->values['shop_subdivision_receiver_id']
                . '_' . $child->values['shop_subdivision_daughter_id']
                . '_' . $child->values['shop_material_id'];
            if(!key_exists($shopClientID, $listIDs->childs)){
                $child->additionDatas = $resultArray;
                $listIDs->childs[$shopClientID] = $child;
            }

            $listIDs->childs[$shopClientID]->additionDatas['quantity_day'] += $child->values['quantity'];
        }

        // задаем время выборки вчера
        $paramsYesterday = $params;
        $paramsYesterday['date_document_to'] = $dateFrom;
        $paramsYesterday['date_document_from'] = Helpers_DateTime::minusDays($dateFrom, 1);

        $ids = Request_Request::find('DB_Ab1_Shop_Car_To_Material',
            $this->_sitePageData->shopMainID, $this->_sitePageData, $this->_driverDB, $paramsYesterday, 0, TRUE,
            $elements
        );
        foreach ($ids->childs as $child){
            $shopClientID = $child->values['shop_subdivision_receiver_id']
                . '_' . $child->values['shop_subdivision_daughter_id']
                . '_' . $child->values['shop_material_id'];
            if(!key_exists($shopClientID, $listIDs->childs)){
                $child->additionDatas = $resultArray;
                $listIDs->childs[$shopClientID] = $child;
            }

            $listIDs->childs[$shopClientID]->additionDatas['quantity_yesterday'] += $child->values['quantity'];
        }

        // задаем время выборки с начала недели
        $dateFrom = Helpers_DateTime::getWeekBeginStr(date('Y-m-d')).' 06:00:00';
        $params['date_document_from'] = $dateFrom;

        $ids = Request_Request::find('DB_Ab1_Shop_Car_To_Material',
            $this->_sitePageData->shopMainID, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
            $elements
        );
        foreach ($ids->childs as $child){
            $shopClientID = $child->values['shop_subdivision_receiver_id']
                . '_' . $child->values['shop_subdivision_daughter_id']
                . '_' . $child->values['shop_material_id'];
            if(!key_exists($shopClientID, $listIDs->childs)){
                $child->additionDatas = $resultArray;
                $listIDs->childs[$shopClientID] = $child;
            }

            $listIDs->childs[$shopClientID]->additionDatas['quantity_week'] += $child->values['quantity'];
        }

        // задаем время выборки с начала месяца
        $dateFrom = Helpers_DateTime::getMonthBeginStr(date('m'), date('Y')).' 06:00:00';
        $params['date_document_from'] = $dateFrom;

        $ids = Request_Request::find('DB_Ab1_Shop_Car_To_Material',
            $this->_sitePageData->shopMainID, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
            $elements
        );
        foreach ($ids->childs as $child){
            $shopClientID = $child->values['shop_subdivision_receiver_id']
                . '_' . $child->values['shop_subdivision_daughter_id']
                . '_' . $child->values['shop_material_id'];
            if(!key_exists($shopClientID, $listIDs->childs)){
                $child->additionDatas = $resultArray;
                $listIDs->childs[$shopClientID] = $child;
            }

            $listIDs->childs[$shopClientID]->additionDatas['quantity_month'] += $child->values['quantity'];
        }

        // задаем время выборки с предыдущего месяца
        $paramsPreviousMonth = $params;
        $tmp = Helpers_DateTime::getMonthBeginStr(date('m'), date('Y')).' 06:00:00';
        $paramsPreviousMonth['date_document_to'] = $tmp;
        $paramsPreviousMonth['date_document_from'] = Helpers_DateTime::minusMonth($tmp, 1, true);

        $ids = Request_Request::find('DB_Ab1_Shop_Car_To_Material',
            $this->_sitePageData->shopMainID, $this->_sitePageData, $this->_driverDB, $paramsPreviousMonth, 0, TRUE,
            $elements
        );
        foreach ($ids->childs as $child){
            $shopClientID = $child->values['shop_subdivision_receiver_id']
                . '_' . $child->values['shop_subdivision_daughter_id']
                . '_' . $child->values['shop_material_id'];
            if(!key_exists($shopClientID, $listIDs->childs)){
                $child->additionDatas = $resultArray;
                $listIDs->childs[$shopClientID] = $child;
            }

            $listIDs->childs[$shopClientID]->additionDatas['quantity_month_previous'] += $child->values['quantity'];
        }

        // задаем время выборки с начала года
        $dateFrom = Helpers_DateTime::getYearBeginStr(date('Y')).' 06:00:00';
        $params['date_document_from'] = $dateFrom;

        $ids = Request_Request::find('DB_Ab1_Shop_Car_To_Material',
            $this->_sitePageData->shopMainID, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
            $elements
        );
        foreach ($ids->childs as $child){
            $shopClientID = $child->values['shop_subdivision_receiver_id']
                . '_' . $child->values['shop_subdivision_daughter_id']
                . '_' . $child->values['shop_material_id'];
            if(!key_exists($shopClientID, $listIDs->childs)){
                $child->additionDatas = $resultArray;
                $listIDs->childs[$shopClientID] = $child;
            }

            $listIDs->childs[$shopClientID]->additionDatas['quantity_year'] += $child->values['quantity'];
        }

        // задаем время выборки с за все время
        /* $params['date_document_from'] = NULL;

         $ids = Request_Request::find('DB_Ab1_Shop_Car_To_Material',
             $this->_sitePageData->shopMainID, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
            $elements
         );
        foreach ($ids->childs as $child){
            $shopClientID = $child->values['shop_subdivision_receiver_id']
                . '_' . $child->values['shop_subdivision_daughter_id']
                . '_' . $child->values['shop_material_id'];
            if(!key_exists($shopClientID, $listIDs->childs)){
                $child->additionDatas = $resultArray;
                $listIDs->childs[$shopClientID] = $child;
            }

            $listIDs->childs[$shopClientID]->additionDatas['quantity'] += $child->values['quantity'];
        }*/

        // итог
        $listIDs->additionDatas = $listIDs->calcTotalsChild(
            array(
                'quantity_day',
                'quantity_yesterday',
                'quantity_week',
                'quantity_month',
                'quantity_month_previous',
                'quantity_year',
            ),
            true
        );
        $listIDs->childsSortBy(
            Request_RequestParams::getParamArray('sort_by', [],
                array(
                    'shop_material_id'=> 'asc',
                    'shop_subdivision_daughter_id'=> 'asc',
                    'shop_subdivision_receiver_id'=> 'asc',
                    'quantity_day' => 'asc',
                    'quantity_yesterday' => 'asc',
                    'quantity_week' => 'asc',
                    'quantity_month' => 'asc',
                    'quantity_month_previous' => 'asc',
                    'quantity_year' => 'asc',
                )
            ), true, true
        );
//        $listIDs->childsSortBy(
//            array(
//                Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_subdivision_daughter_id.name',
//                Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_subdivision_receiver_id.name',
//            )
//        );

        $this->_sitePageData->countRecord = count($listIDs->childs);

        $this->_sitePageData->newShopShablonPath('ab1/_all');
        $this->_sitePageData->replaceDatas['view::_shop/car/to/material/list/statistics-subdivision'] = Helpers_View::getViewObjects(
            $listIDs, new Model_Ab1_Shop_Product_Rubric(),
            '_shop/car/to/material/list/statistics-subdivision','_shop/car/to/material/one/statistics-subdivision',
            $this->_sitePageData, $this->_driverDB
        );
        $this->_sitePageData->previousShopShablonPath();

        $this->_putInMain('/main/_shop/car/to/material/statistics-subdivision');
    }

    protected function _actionShopCarToMaterialDaughterStatistics()
    {
        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/car/to/material/list/statistics-daughter',
            )
        );
        $this->_requestShopBranches($this->_sitePageData->shopID, TRUE);

        $shopMaterialIDs = NULL;

        // задаем время выборки с начала дня
        $dateFrom = date('Y-m-d').' 06:00:00';
        $listIDs = new MyArray();
        $params = Request_RequestParams::setParams(
            array(
                'is_import_car' => true,
                'date_document_from' => $dateFrom,
                'sum_daughter_weight' => TRUE,
                'shop_material_id' => $shopMaterialIDs,
                'shop_branch_receiver_id' => $this->_sitePageData->shopID,
                'shop_transport_company_id.is_own' => Request_RequestParams::getParamBoolean('is_own'),
                'group_by' => array(
                    'shop_daughter_id', 'shop_daughter_id.name',
                    'shop_branch_daughter_id', 'shop_branch_daughter_id.name',
                ),
            )
        );

        $elements = array(
            'shop_daughter_id' => array('name'),
            'shop_branch_daughter_id' => array('name'),
        );

        $resultArray = array(
            'quantity_day' => 0,
            'quantity_yesterday' => 0,
            'quantity_week' => 0,
            'quantity_month' => 0,
            'quantity_month_previous' => 0,
            'quantity_year' => 0,
        );

        $ids = Request_Request::find(
            'DB_Ab1_Shop_Car_To_Material', $this->_sitePageData->shopMainID,
            $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
            $elements
        );
        foreach ($ids->childs as $child){
            $shopClientID = $child->values['shop_daughter_id'].'_'.$child->values['shop_branch_daughter_id'];
            if(!key_exists($shopClientID, $listIDs->childs)){
                $child->additionDatas = $resultArray;
                $listIDs->childs[$shopClientID] = $child;
            }

            $listIDs->childs[$shopClientID]->additionDatas['quantity_day'] += $child->values['quantity'];
        }

        // задаем время выборки вчера
        $paramsYesterday = $params;
        $paramsYesterday['date_document_to'] = $dateFrom;
        $paramsYesterday['date_document_from'] = Helpers_DateTime::minusDays($dateFrom, 1);

        $ids = Request_Request::find('DB_Ab1_Shop_Car_To_Material',
            $this->_sitePageData->shopMainID, $this->_sitePageData, $this->_driverDB, $paramsYesterday, 0, TRUE,
            $elements
        );
        foreach ($ids->childs as $child){
            $shopClientID = $child->values['shop_daughter_id'].'_'.$child->values['shop_branch_daughter_id'];
            if(!key_exists($shopClientID, $listIDs->childs)){
                $child->additionDatas = $resultArray;
                $listIDs->childs[$shopClientID] = $child;
            }

            $listIDs->childs[$shopClientID]->additionDatas['quantity_yesterday'] += $child->values['quantity'];
        }

        // задаем время выборки с начала недели
        $dateFrom = Helpers_DateTime::getWeekBeginStr(date('Y-m-d')).' 06:00:00';
        $params['date_document_from'] = $dateFrom;

        $ids = Request_Request::find('DB_Ab1_Shop_Car_To_Material',
            $this->_sitePageData->shopMainID, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
            $elements
        );
        foreach ($ids->childs as $child){
            $shopClientID = $child->values['shop_daughter_id'].'_'.$child->values['shop_branch_daughter_id'];
            if(!key_exists($shopClientID, $listIDs->childs)){
                $child->additionDatas = $resultArray;
                $listIDs->childs[$shopClientID] = $child;
            }

            $listIDs->childs[$shopClientID]->additionDatas['quantity_week'] += $child->values['quantity'];
        }

        // задаем время выборки с начала месяца
        $dateFrom = Helpers_DateTime::getMonthBeginStr(date('m'), date('Y')).' 06:00:00';
        $params['date_document_from'] = $dateFrom;

        $ids = Request_Request::find('DB_Ab1_Shop_Car_To_Material',
            $this->_sitePageData->shopMainID, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
            $elements
        );
        foreach ($ids->childs as $child){
            $shopClientID = $child->values['shop_daughter_id'].'_'.$child->values['shop_branch_daughter_id'];
            if(!key_exists($shopClientID, $listIDs->childs)){
                $child->additionDatas = $resultArray;
                $listIDs->childs[$shopClientID] = $child;
            }

            $listIDs->childs[$shopClientID]->additionDatas['quantity_month'] += $child->values['quantity'];
        }

        // задаем время выборки с предыдущего месяца
        $paramsPreviousMonth = $params;
        $tmp = Helpers_DateTime::getMonthBeginStr(date('m'), date('Y')).' 06:00:00';
        $paramsPreviousMonth['date_document_to'] = $tmp;
        $paramsPreviousMonth['date_document_from'] = Helpers_DateTime::minusMonth($tmp, 1, true);

        $ids = Request_Request::find('DB_Ab1_Shop_Car_To_Material',
            $this->_sitePageData->shopMainID, $this->_sitePageData, $this->_driverDB, $paramsPreviousMonth, 0, TRUE,
            $elements
        );
        foreach ($ids->childs as $child){
            $shopClientID = $child->values['shop_daughter_id'].'_'.$child->values['shop_branch_daughter_id'];
            if(!key_exists($shopClientID, $listIDs->childs)){
                $child->additionDatas = $resultArray;
                $listIDs->childs[$shopClientID] = $child;
            }

            $listIDs->childs[$shopClientID]->additionDatas['quantity_month_previous'] += $child->values['quantity'];
        }

        // задаем время выборки с начала года
        $dateFrom = Helpers_DateTime::getYearBeginStr(date('Y')).' 06:00:00';
        $params['date_document_from'] = $dateFrom;

        $ids = Request_Request::find('DB_Ab1_Shop_Car_To_Material',
            $this->_sitePageData->shopMainID, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
            $elements
        );
        foreach ($ids->childs as $child){
            $shopClientID = $child->values['shop_daughter_id'].'_'.$child->values['shop_branch_daughter_id'];
            if(!key_exists($shopClientID, $listIDs->childs)){
                $child->additionDatas = $resultArray;
                $listIDs->childs[$shopClientID] = $child;
            }

            $listIDs->childs[$shopClientID]->additionDatas['quantity_year'] += $child->values['quantity'];
        }

        // задаем время выборки с за все время
        /* $params['date_document_from'] = NULL;

         $ids = Request_Request::find('DB_Ab1_Shop_Car_To_Material',
             $this->_sitePageData->shopMainID, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
            $elements
         );
        foreach ($ids->childs as $child){
            $shopClientID = $child->values['shop_daughter_id'].'_'.$child->values['shop_branch_daughter_id'];
            if(!key_exists($shopClientID, $listIDs->childs)){
                $child->additionDatas = $resultArray;
                $listIDs->childs[$shopClientID] = $child;
            }

            $listIDs->childs[$shopClientID]->additionDatas['quantity'] += $child->values['quantity'];
        }*/

        // итог
        $listIDs->additionDatas = $listIDs->calcTotalsChild(
            array(
                'quantity_day',
                'quantity_yesterday',
                'quantity_week',
                'quantity_month',
                'quantity_month_previous',
                'quantity_year',
            ),
            true
        );

        $listIDs->childsSortBy(
            array(
                Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_daughter_id.name',
                Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_branch_daughter_id.name',
            )
        );

        $this->_sitePageData->countRecord = count($listIDs->childs);

        $this->_sitePageData->newShopShablonPath('ab1/_all');
        $this->_sitePageData->replaceDatas['view::_shop/car/to/material/list/statistics-daughter'] = Helpers_View::getViewObjects(
            $listIDs, new Model_Ab1_Shop_Product_Rubric(),
            '_shop/car/to/material/list/statistics-daughter','_shop/car/to/material/one/statistics-daughter',
            $this->_sitePageData, $this->_driverDB
        );
        $this->_sitePageData->previousShopShablonPath();

        $this->_putInMain('/main/_shop/car/to/material/statistics-daughter');
    }

    protected function _actionShopCarToMaterialDaughterMaterialStatistics()
    {
        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/car/to/material/list/statistics-daughter-material',
            )
        );
        $this->_requestShopBranches(null, TRUE);
        $this->_requestShopDaughters();

        $shopMaterialIDs = NULL;

        // задаем время выборки с начала дня
        $dateFrom = date('Y-m-d').' 06:00:00';
        $listIDs = new MyArray();
        $params = Request_RequestParams::setParams(
            array(
                'is_import_car' => true,
                'date_document_from' => $dateFrom,
                'sum_daughter_weight' => TRUE,
                'shop_material_id' => $shopMaterialIDs,
                'shop_branch_receiver_id' => $this->_sitePageData->shopID,
                'shop_transport_company_id.is_own' => Request_RequestParams::getParamBoolean('is_own'),
                'shop_daughter_id' => Request_RequestParams::getParamInt('shop_daughter_id'),
                'shop_branch_daughter_id' => Request_RequestParams::getParamInt('shop_branch_daughter_id'),
                'group_by' => array(
                    'shop_material_id', 'shop_material_id.name',
                ),
            )
        );

        $elements = array(
            'shop_material_id' => array('name'),
        );

        $resultArray = array(
            'quantity_day' => 0,
            'quantity_yesterday' => 0,
            'quantity_week' => 0,
            'quantity_month' => 0,
            'quantity_month_previous' => 0,
            'quantity_year' => 0,
        );

        $ids = Request_Request::find('DB_Ab1_Shop_Car_To_Material',
            $this->_sitePageData->shopMainID, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
            $elements
        );
        foreach ($ids->childs as $child){
            $objectID = $child->values['shop_material_id'];
            if(!key_exists($objectID, $listIDs->childs)){
                $child->additionDatas = $resultArray;
                $listIDs->childs[$objectID] = $child;
            }

            $listIDs->childs[$objectID]->additionDatas['quantity_day'] += $child->values['quantity'];
        }

        // задаем время выборки вчера
        $paramsYesterday = $params;
        $paramsYesterday['date_document_to'] = $dateFrom;
        $paramsYesterday['date_document_from'] = Helpers_DateTime::minusDays($dateFrom, 1);

        $ids = Request_Request::find('DB_Ab1_Shop_Car_To_Material',
            $this->_sitePageData->shopMainID, $this->_sitePageData, $this->_driverDB, $paramsYesterday, 0, TRUE,
            $elements
        );
        foreach ($ids->childs as $child){
            $objectID = $child->values['shop_material_id'];
            if(!key_exists($objectID, $listIDs->childs)){
                $child->additionDatas = $resultArray;
                $listIDs->childs[$objectID] = $child;
            }

            $listIDs->childs[$objectID]->additionDatas['quantity_yesterday'] += $child->values['quantity'];
        }

        // задаем время выборки с начала недели
        $dateFrom = Helpers_DateTime::getWeekBeginStr(date('Y-m-d')).' 06:00:00';
        $params['date_document_from'] = $dateFrom;

        $ids = Request_Request::find('DB_Ab1_Shop_Car_To_Material',
            $this->_sitePageData->shopMainID, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
            $elements
        );
        foreach ($ids->childs as $child){
            $objectID = $child->values['shop_material_id'];
            if(!key_exists($objectID, $listIDs->childs)){
                $child->additionDatas = $resultArray;
                $listIDs->childs[$objectID] = $child;
            }

            $listIDs->childs[$objectID]->additionDatas['quantity_week'] += $child->values['quantity'];
        }

        // задаем время выборки с начала месяца
        $dateFrom = Helpers_DateTime::getMonthBeginStr(date('m'), date('Y')).' 06:00:00';
        $params['date_document_from'] = $dateFrom;

        $ids = Request_Request::find('DB_Ab1_Shop_Car_To_Material',
            $this->_sitePageData->shopMainID, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
            $elements
        );
        foreach ($ids->childs as $child){
            $objectID = $child->values['shop_material_id'];
            if(!key_exists($objectID, $listIDs->childs)){
                $child->additionDatas = $resultArray;
                $listIDs->childs[$objectID] = $child;
            }

            $listIDs->childs[$objectID]->additionDatas['quantity_month'] += $child->values['quantity'];
        }

        // задаем время выборки с предыдущего месяца
        $paramsPreviousMonth = $params;
        $tmp = Helpers_DateTime::getMonthBeginStr(date('m'), date('Y')).' 06:00:00';
        $paramsPreviousMonth['date_document_to'] = $tmp;
        $paramsPreviousMonth['date_document_from'] = Helpers_DateTime::minusMonth($tmp, 1, true);

        $ids = Request_Request::find('DB_Ab1_Shop_Car_To_Material',
            $this->_sitePageData->shopMainID, $this->_sitePageData, $this->_driverDB, $paramsPreviousMonth, 0, TRUE,
            $elements
        );
        foreach ($ids->childs as $child){
            $objectID = $child->values['shop_material_id'];
            if(!key_exists($objectID, $listIDs->childs)){
                $child->additionDatas = $resultArray;
                $listIDs->childs[$objectID] = $child;
            }

            $listIDs->childs[$objectID]->additionDatas['quantity_month_previous'] += $child->values['quantity'];
        }

        // задаем время выборки с начала года
        $dateFrom = Helpers_DateTime::getYearBeginStr(date('Y')).' 06:00:00';
        $params['date_document_from'] = $dateFrom;

        $ids = Request_Request::find('DB_Ab1_Shop_Car_To_Material',
            $this->_sitePageData->shopMainID, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
            $elements
        );
        foreach ($ids->childs as $child){
            $objectID = $child->values['shop_material_id'];
            if(!key_exists($objectID, $listIDs->childs)){
                $child->additionDatas = $resultArray;
                $listIDs->childs[$objectID] = $child;
            }

            $listIDs->childs[$objectID]->additionDatas['quantity_year'] += $child->values['quantity'];
        }

        // задаем время выборки с за все время
        /* $params['date_document_from'] = NULL;

         $ids = Request_Request::find('DB_Ab1_Shop_Car_To_Material',
             $this->_sitePageData->shopMainID, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
            $elements
         );
        foreach ($ids->childs as $child){
            $objectID = $child->values['shop_material_id'];
            if(!key_exists($objectID, $listIDs->childs)){
                $child->additionDatas = $resultArray;
                $listIDs->childs[$objectID] = $child;
            }

            $listIDs->childs[$objectID]->additionDatas['quantity'] += $child->values['quantity'];
        }*/

        // итог
        $listIDs->additionDatas = $listIDs->calcTotalsChild(
            array(
                'quantity_day',
                'quantity_yesterday',
                'quantity_week',
                'quantity_month',
                'quantity_month_previous',
                'quantity_year',
            ),
            true
        );

        $listIDs->childsSortBy(
            array(
                Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_material_id.name',
            )
        );

        $this->_sitePageData->countRecord = count($listIDs->childs);

        $this->_sitePageData->newShopShablonPath('ab1/_all');
        $this->_sitePageData->replaceDatas['view::_shop/car/to/material/list/statistics-daughter-material'] = Helpers_View::getViewObjects(
            $listIDs, new Model_Ab1_Shop_Product_Rubric(),
            '_shop/car/to/material/list/statistics-daughter-material','_shop/car/to/material/one/statistics-daughter-material',
            $this->_sitePageData, $this->_driverDB
        );
        $this->_sitePageData->previousShopShablonPath();

        $this->_putInMain('/main/_shop/car/to/material/statistics-daughter-material');
    }

    protected function _actionShopCarToMaterialComingStatistics()
    {
        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/car/to/material/list/statistics-coming',
            )
        );
        $this->_requestShopBranches($this->_sitePageData->shopID, TRUE);

        $shopMaterialIDs = NULL;

        // задаем время выборки с начала дня
        $dateFrom = date('Y-m-d').' 06:00:00';
        $dateTo = null;
        $listIDs = new MyArray();
        $params = Request_RequestParams::setParams(
            array(
               /* 'date_document_from' => $dateFrom,
                'sum_daughter_weight' => TRUE,
                'shop_material_id' => $shopMaterialIDs,
                'shop_branch_receiver_id' => $this->_sitePageData->shopID,
                'group_by' => array(
                    'shop_daughter_id', 'shop_daughter_id.name',
                    'shop_branch_daughter_id', 'shop_branch_daughter_id.name',
                ),*/
            )
        );

        // задаем время выборки сегодня
        $data = Api_Ab1_Shop_Car_To_Material::getMaterialComingGroupDaughter(
            $dateFrom, $dateTo, null, $this->_sitePageData, $this->_driverDB, $params
        );
        $child = $listIDs->addChild(0);
        $child->setIsFind(true);
        $child->additionDatas = $data;
        $child->additionDatas['title'] = 'Сегодня';

        // задаем время выборки вчера
        $data = Api_Ab1_Shop_Car_To_Material::getMaterialComingGroupDaughter(
            Helpers_DateTime::minusDays($dateFrom, 1), $dateFrom, null, $this->_sitePageData, $this->_driverDB, $params
        );
        $child = $listIDs->addChild(0);
        $child->setIsFind(true);
        $child->additionDatas = $data;
        $child->additionDatas['title'] = 'Вчера';

        // задаем время выборки с начала недели
        $dateFrom = Helpers_DateTime::getWeekBeginStr(date('Y-m-d')).' 06:00:00';
        $data = Api_Ab1_Shop_Car_To_Material::getMaterialComingGroupDaughter(
            $dateFrom, null, null, $this->_sitePageData, $this->_driverDB, $params
        );
        $child = $listIDs->addChild(0);
        $child->setIsFind(true);
        $child->additionDatas = $data;
        $child->additionDatas['title'] = 'Неделя';

        // задаем время выборки с начала месяца
        $dateFrom = Helpers_DateTime::getMonthBeginStr(date('m'), date('Y')).' 06:00:00';
        $data = Api_Ab1_Shop_Car_To_Material::getMaterialComingGroupDaughter(
            $dateFrom, null, null, $this->_sitePageData, $this->_driverDB, $params
        );
        $child = $listIDs->addChild(0);
        $child->setIsFind(true);
        $child->additionDatas = $data;
        $child->additionDatas['title'] = 'Месяц';

        // задаем время выборки с предыдущего месяца
        $tmp = Helpers_DateTime::getMonthBeginStr(date('m'), date('Y')).' 06:00:00';

        $data = Api_Ab1_Shop_Car_To_Material::getMaterialComingGroupDaughter(
            $tmp,
            Helpers_DateTime::minusMonth($tmp, 1, true),
            null, $this->_sitePageData, $this->_driverDB, $params
        );
        $child = $listIDs->addChild(0);
        $child->setIsFind(true);
        $child->additionDatas = $data;
        $child->additionDatas['title'] = 'Прошлый месяц';

        // задаем время выборки с начала года
        $dateFrom = Helpers_DateTime::getYearBeginStr(date('Y')).' 06:00:00';
        $data = Api_Ab1_Shop_Car_To_Material::getMaterialComingGroupDaughter(
            $dateFrom, null, null, $this->_sitePageData, $this->_driverDB, $params
        );
        $child = $listIDs->addChild(0);
        $child->setIsFind(true);
        $child->additionDatas = $data;
        $child->additionDatas['title'] = 'Год';

        // задаем время выборки с за все время
        /*
        $data = Api_Ab1_Shop_Car_To_Material::getMaterialComingGroupDaughter(
            null, null, null, $this->_sitePageData, $this->_driverDB, $params
        );
        $child = $listIDs->addChild(0);
        $child->setIsFind(true);
        $child->additionDatas = $data;
        $child->additionDatas['title'] = 'Все';*/


        $this->_sitePageData->newShopShablonPath('ab1/_all');
        $this->_sitePageData->replaceDatas['view::_shop/car/to/material/list/statistics-coming'] = Helpers_View::getViewObjects(
            $listIDs, new Model_Ab1_Shop_Product_Rubric(),
            '_shop/car/to/material/list/statistics-coming','_shop/car/to/material/one/statistics-coming',
            $this->_sitePageData, $this->_driverDB
        );
        $this->_sitePageData->previousShopShablonPath();

        $this->_putInMain('/main/_shop/car/to/material/statistics-coming');
    }

    protected function _actionShopClientStatistics($isBalance = true)
    {
        $_GET['is_balance'] = $isBalance;
        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/client/list/statistics',
            )
        );

        $isAllBranch = Request_RequestParams::getParamInt('shop_branch_id') == -1;
        $isAll = Request_RequestParams::getParamBoolean('is_all');
        $isDebt = Request_RequestParams::getParamBoolean('is_debt');
        $shopProductIDs = Api_Ab1_Shop_Product::findAllByMainRubric(
            Request_RequestParams::getParamInt('shop_product_rubric_id'), $this->_sitePageData, $this->_driverDB
        );

        $this->_requestShopProductRubrics();
        $this->_requestShopBranches($this->_sitePageData->shopID, TRUE);

        // задаем время выборки с начала дня
        $dateFrom = date('Y-m-d').' 06:00:00';
        $listIDs = new MyArray();
        $params = Request_RequestParams::setParams(
            array(
                'is_exit' => 1,
                'exit_at_from' => $dateFrom,
                'sum_quantity' => TRUE,
                'quantity_from' => 0,
                'is_charity' => FALSE,
                'shop_product_id' => $shopProductIDs,
                'shop_client_id' => Request_RequestParams::getParamInt('shop_client_id'),
                'group_by' => array(
                    'shop_client_id',
                    'shop_client_id.name',
                    'shop_client_id.balance',
                    'shop_product_id.volume',
                ),
            )
        );
        $elements = array(
            'shop_client_id' => array('name', 'balance'),
            'shop_product_id' => array('volume')
        );

        $resultArray = array(
            'quantity_day' => 0,
            'quantity_yesterday' => 0,
            'quantity_week' => 0,
            'quantity_month' => 0,
            'quantity_month_previous' => 0,
            'quantity_year' => 0,
        );

        if($isAllBranch) {
            $ids = Request_Request::findBranch('DB_Ab1_Shop_Car_Item',
                array(), $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
                $elements
            );
        }else{
            $ids = Request_Request::find('DB_Ab1_Shop_Car_Item',
                $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
                $elements
            );
        }
        foreach ($ids->childs as $child){
            $shopClientID = $child->values['shop_client_id'];
            if(!key_exists($shopClientID, $listIDs->childs)){
                $child->additionDatas = $resultArray;
                $listIDs->childs[$shopClientID] = $child;
            }

            $listIDs->childs[$shopClientID]->additionDatas['quantity_day'] += $child->values['quantity'];
        }

        $clientIDs = array();
        if(!$isAll){
            $clientIDs = $listIDs->getChildArrayInt('shop_client_id', TRUE);
        }

        if($isAllBranch) {
            $ids = Request_Request::findBranch('DB_Ab1_Shop_Piece_Item',
                array(), $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
                $elements
            );
        }else{
            $ids = Request_Request::find('DB_Ab1_Shop_Piece_Item',
                $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
                $elements
            );
        }

        foreach ($ids->childs as $child){
            $shopClientID = $child->values['shop_client_id'];
            if(!key_exists($shopClientID, $listIDs->childs)){
                $child->additionDatas = $resultArray;
                $listIDs->childs[$shopClientID] = $child;
            }

            $listIDs->childs[$shopClientID]->additionDatas['quantity_day'] += $child->values['quantity'];
        }

        if(!$isAll){
            $clientIDs = array_merge($clientIDs, $listIDs->getChildArrayInt('shop_client_id', TRUE));
            if(!empty($clientIDs)) {
                $params['shop_client_id'] = array(
                    'value' => $clientIDs,
                );
            }
        }

        // задаем время выборки вчера
        $paramsYesterday = $params;
        $paramsYesterday['exit_at_to'] = $dateFrom;
        $dateFrom = Helpers_DateTime::minusDays($dateFrom, 1);
        $paramsYesterday['exit_at_from'] = $dateFrom;

        if($isAllBranch) {
            $ids = Request_Request::findBranch('DB_Ab1_Shop_Car_Item',
                array(), $this->_sitePageData, $this->_driverDB, $paramsYesterday, 0, TRUE,
                $elements
            );
        }else{
            $ids = Request_Request::find('DB_Ab1_Shop_Car_Item',
                $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB, $paramsYesterday, 0, TRUE,
                $elements
            );
        }
        foreach ($ids->childs as $child){
            $shopClientID = $child->values['shop_client_id'];
            if(!key_exists($shopClientID, $listIDs->childs)){
                if(!$isAll){
                    continue;
                }
                $child->additionDatas = $resultArray;
                $listIDs->childs[$shopClientID] = $child;
            }

            $listIDs->childs[$shopClientID]->additionDatas['quantity_yesterday'] +=
                $child->values['quantity'];
        }

        if($isAllBranch) {
            $ids = Request_Request::findBranch('DB_Ab1_Shop_Piece_Item',
                array(), $this->_sitePageData, $this->_driverDB, $paramsYesterday, 0, TRUE,
                $elements
            );
        }else{
            $ids = Request_Request::find('DB_Ab1_Shop_Piece_Item',
                $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB, $paramsYesterday, 0, TRUE,
                $elements
            );
        }
        foreach ($ids->childs as $child){
            $shopClientID = $child->values['shop_client_id'];
            if(!key_exists($shopClientID, $listIDs->childs)){
                if(!$isAll){
                    continue;
                }
                $child->additionDatas = $resultArray;
                $listIDs->childs[$shopClientID] = $child;
            }

            $listIDs->childs[$shopClientID]->additionDatas['quantity_yesterday'] +=
                $child->values['quantity'];
        }

        // задаем время выборки с начала недели
        $dateFrom = Helpers_DateTime::getWeekBeginStr(date('Y-m-d')).' 06:00:00';
        $params['exit_at_from'] = $dateFrom;

        if($isAllBranch) {
            $ids = Request_Request::findBranch('DB_Ab1_Shop_Car_Item',
                array(), $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
                $elements
            );
        }else{
            $ids = Request_Request::find('DB_Ab1_Shop_Car_Item',
                $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
                $elements
            );
        }
        foreach ($ids->childs as $child){
            $shopClientID = $child->values['shop_client_id'];
            if(!key_exists($shopClientID, $listIDs->childs)){
                if(!$isAll){
                    continue;
                }
                $child->additionDatas = $resultArray;
                $listIDs->childs[$shopClientID] = $child;
            }

            $listIDs->childs[$shopClientID]->additionDatas['quantity_week'] +=
                $child->values['quantity'];
        }

        if($isAllBranch) {
            $ids = Request_Request::findBranch('DB_Ab1_Shop_Piece_Item',
                array(), $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
                $elements
            );
        }else{
            $ids = Request_Request::find('DB_Ab1_Shop_Piece_Item',
                $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
                $elements
            );
        }
        foreach ($ids->childs as $child){
            $shopClientID = $child->values['shop_client_id'];
            if(!key_exists($shopClientID, $listIDs->childs)){
                if(!$isAll){
                    continue;
                }
                $child->additionDatas = $resultArray;
                $listIDs->childs[$shopClientID] = $child;
            }

            $listIDs->childs[$shopClientID]->additionDatas['quantity_week'] +=
                $child->values['quantity'];
        }

        // задаем время выборки с начала месяца
        $dateFrom = Helpers_DateTime::getMonthBeginStr(date('m'), date('Y')).' 06:00:00';
        $params['exit_at_from'] = $dateFrom;

        if($isAllBranch) {
            $ids = Request_Request::findBranch('DB_Ab1_Shop_Car_Item',
                array(), $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
                $elements
            );
        }else{
            $ids = Request_Request::find('DB_Ab1_Shop_Car_Item',
                $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
                $elements
            );
        }
        foreach ($ids->childs as $child){
            $shopClientID = $child->values['shop_client_id'];
            if(!key_exists($shopClientID, $listIDs->childs)){
                if(!$isAll){
                    continue;
                }
                $child->additionDatas = $resultArray;
                $listIDs->childs[$shopClientID] = $child;
            }

            $listIDs->childs[$shopClientID]->additionDatas['quantity_month'] +=
                $child->values['quantity'];
        }

        if($isAllBranch) {
            $ids = Request_Request::findBranch('DB_Ab1_Shop_Piece_Item',
                array(), $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
                $elements
            );
        }else{
            $ids = Request_Request::find('DB_Ab1_Shop_Piece_Item',
                $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
                $elements
            );
        }
        foreach ($ids->childs as $child){
            $shopClientID = $child->values['shop_client_id'];
            if(!key_exists($shopClientID, $listIDs->childs)){
                if(!$isAll){
                    continue;
                }
                $child->additionDatas = $resultArray;
                $listIDs->childs[$shopClientID] = $child;
            }

            $listIDs->childs[$shopClientID]->additionDatas['quantity_month'] +=
                $child->values['quantity'];
        }

        // задаем время выборки с предыдущего месяца
        $paramsPreviousMonth = $params;
        $tmp = Helpers_DateTime::getMonthBeginStr(date('m'), date('Y')).' 06:00:00';
        $paramsPreviousMonth['exit_at_to'] = $tmp;
        $paramsPreviousMonth['exit_at_from'] = Helpers_DateTime::minusMonth($tmp, 1, true);

        if($isAllBranch) {
            $ids = Request_Request::findBranch('DB_Ab1_Shop_Car_Item',
                array(), $this->_sitePageData, $this->_driverDB, $paramsPreviousMonth, 0, TRUE,
                $elements
            );
        }else{
            $ids = Request_Request::find('DB_Ab1_Shop_Car_Item',
                $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB, $paramsPreviousMonth, 0, TRUE,
                $elements
            );
        }
        foreach ($ids->childs as $child){
            $shopClientID = $child->values['shop_client_id'];
            if(!key_exists($shopClientID, $listIDs->childs)){
                if(!$isAll){
                    continue;
                }
                $child->additionDatas = $resultArray;
                $listIDs->childs[$shopClientID] = $child;
            }

            $listIDs->childs[$shopClientID]->additionDatas['quantity_month_previous'] += $child->values['quantity'];
        }

        if($isAllBranch) {
            $ids = Request_Request::findBranch('DB_Ab1_Shop_Piece_Item',
                array(), $this->_sitePageData, $this->_driverDB, $paramsPreviousMonth, 0, TRUE,
                $elements
            );
        }else{
            $ids = Request_Request::find('DB_Ab1_Shop_Piece_Item',
                $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB, $paramsPreviousMonth, 0, TRUE,
                $elements
            );
        }
        foreach ($ids->childs as $child){
            $shopClientID = $child->values['shop_client_id'];
            if(!key_exists($shopClientID, $listIDs->childs)){
                if(!$isAll){
                    continue;
                }
                $child->additionDatas = $resultArray;
                $listIDs->childs[$shopClientID] = $child;
            }

            $listIDs->childs[$shopClientID]->additionDatas['quantity_month_previous'] += $child->values['quantity'];
        }

        // задаем время выборки с начала года
        $dateFrom = Helpers_DateTime::getYearBeginStr(date('Y')).' 06:00:00';
        $params['exit_at_from'] = $dateFrom;

        if($isAllBranch) {
            $ids = Request_Request::findBranch('DB_Ab1_Shop_Car_Item',
                array(), $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
                $elements
            );
        }else{
            $ids = Request_Request::find('DB_Ab1_Shop_Car_Item',
                $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
                $elements
            );
        }
        foreach ($ids->childs as $child){
            $shopClientID = $child->values['shop_client_id'];
            if(!key_exists($shopClientID, $listIDs->childs)){
                if(!$isAll){
                    continue;
                }
                $child->additionDatas = $resultArray;
                $listIDs->childs[$shopClientID] = $child;
            }

            $listIDs->childs[$shopClientID]->additionDatas['quantity_year'] +=
                $child->values['quantity'];
        }

        if($isAllBranch) {
            $ids = Request_Request::findBranch('DB_Ab1_Shop_Piece_Item',
                array(), $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
                $elements
            );
        }else{
            $ids = Request_Request::find('DB_Ab1_Shop_Piece_Item',
                $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
                $elements
            );
        }
        foreach ($ids->childs as $child){
            $shopClientID = $child->values['shop_client_id'];
            if(!key_exists($shopClientID, $listIDs->childs)){
                if(!$isAll){
                    continue;
                }
                $child->additionDatas = $resultArray;
                $listIDs->childs[$shopClientID] = $child;
            }

            $listIDs->childs[$shopClientID]->additionDatas['quantity_year'] +=
                $child->values['quantity'];
        }

        // получаем список клиентов
        $clientIDs = new MyArray();
        foreach ($listIDs->childs as $child){
            $client = $clientIDs->addChild($child->values['shop_client_id']);
            $client->values = array(
                'id' => $child->values['shop_client_id'],
                'name' => $child->getElementValue('shop_client_id'),
            );
            $client->setIsFind(TRUE);
        }

        $this->_sitePageData->newShopShablonPath('ab1/_all');
        $this->_sitePageData->replaceDatas['view::_shop/client/list/list'] = Helpers_View::getViewObjects(
            $clientIDs, new Model_Ab1_Shop_Client(),
            '_shop/client/list/list','_shop/client/one/list',
            $this->_sitePageData, $this->_driverDB
        );
        $this->_sitePageData->previousShopShablonPath();

        // если требуется в долг, то удаляем всех клиентов с плюсовым балансом
        if($isDebt){
            foreach ($listIDs->childs as $key => $child){
                $amount = $child->getElementValue('shop_client_id', 'balance');
                if($amount < -1) {
                    $child->additionDatas['balance'] = $amount;
                }else{
                    unset($listIDs->childs[$key]);
                }
            }
        }

        // сортировка
        $sortBy = Request_RequestParams::getParamArray('sort_by', array(), array());
        if(empty($sortBy)){
            if($isDebt){
                $sortBy = array('balance' => 'desc');
            }elseif($isAll){
                $sortBy = array('quantity_year' => 'desc');
            }else{
                $sortBy = array('quantity_day' => 'desc');
            }
        }
        $listIDs->childsSortBy($sortBy, true, true);

        // итог
        $listIDs->additionDatas = $listIDs->calcTotalsChild(
            array(
                'quantity_day',
                'quantity_yesterday',
                'quantity_week',
                'quantity_month',
                'quantity_month_previous',
                'quantity_year',
            ),
            true
        );

        $listIDs->additionDatas['balance'] = $listIDs->calcTotalsChild(
            array(
                '$elements$.shop_client_id.balance',
            ),
            false
        )['$elements$.shop_client_id.balance'];

        $this->_sitePageData->countRecord = count($listIDs->childs);

        if($isDebt){
            // получаем сумму машин на территории
            $params = Request_RequestParams::setParams(
                array(
                    'is_exit' => 0,
                    'quantity_from' => 0,
                    'sum_amount' => true,
                    'group_by' => array(
                        'shop_client_id'
                    )
                )
            );
            $shopCarIDs = Request_Request::findBranch('DB_Ab1_Shop_Car',
                array(), $this->_sitePageData, $this->_driverDB, $params, 0, TRUE
            );

            foreach ($shopCarIDs->childs as $child){
                $tmp = $listIDs->findChildValues(
                    array(
                        'shop_client_id' => $child->values['shop_client_id'],
                    ),
                    false
                );

                if($tmp != null){
                    $tmp->additionDatas['territory'] = $child->values['amount'];
                }
            }

            // получаем пометку по поставщикам  по договорам
            $params = Request_RequestParams::setParams(
                array(
                    'date' => date('Y-m-d'),
                    'is_receive' => false,
                    'group_by' => array(
                        'shop_client_id',
                    )
                )
            );
            $shopClientContractIDs = Request_Request::findBranch('DB_Ab1_Shop_Client_Contract',
                array(), $this->_sitePageData, $this->_driverDB, $params, 0, TRUE
            );

            foreach ($shopClientContractIDs->childs as $child){
                $tmp = $listIDs->findChildValues(
                    array(
                        'shop_client_id' => $child->values['shop_client_id'],
                    ),
                    false
                );

                if($tmp != null){
                    $tmp->additionDatas['is_supplier'] = true;
                }
            }
        }


        $this->_sitePageData->newShopShablonPath('ab1/_all');
        $this->_sitePageData->replaceDatas['view::_shop/client/list/statistics'] = Helpers_View::getViewObjects(
            $listIDs, new Model_Ab1_Shop_Product_Rubric(),
            '_shop/client/list/statistics','_shop/client/one/statistics',
            $this->_sitePageData, $this->_driverDB
        );
        $this->_sitePageData->previousShopShablonPath();

        $this->_putInMain('/main/_shop/client/statistics');
    }

    protected function _actionCharityShopClientStatistics()
    {

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/client/list/charity',
            )
        );

        $isAllBranch = Request_RequestParams::getParamInt('shop_branch_id') == -1;
        if($isAllBranch){
            $shopIDs = array();
        }else{
            $shopIDs = array($this->_sitePageData->shopID);
        }

        $shopProductIDs = Api_Ab1_Shop_Product::findAllByMainRubric(
            Request_RequestParams::getParamInt('shop_product_rubric_id'), $this->_sitePageData, $this->_driverDB
        );
        $this->_requestShopBranches($this->_sitePageData->shopID, TRUE);
        $this->_requestShopProductRubrics();

        // задаем время выборки с начала дня
        $dateFrom = date('Y-m-d').' 06:00:00';
        $listIDs = new MyArray();
        $params = Request_RequestParams::setParams(
            array(
                'is_exit' => 1,
                'exit_at_from' => $dateFrom,
                'sum_quantity' => TRUE,
                'is_charity' => TRUE,
                'shop_product_id' => $shopProductIDs,
                'group_by' => array(
                    'shop_client_id',
                    'shop_client_id.name',
                    'shop_product_id.volume',
                ),
            ),
            false
        );
        $elements = array(
            'shop_client_id' => array('name'),
            'shop_product_id' => array('volume'),
        );

        $resultArray = array(
            'quantity_day' => 0,
            'quantity_yesterday' => 0,
            'quantity_week' => 0,
            'quantity_month' => 0,
            'quantity_month_previous' => 0,
            'quantity_year' => 0,
        );

        $ids = Request_Request::findBranch('DB_Ab1_Shop_Car_Item',
            $shopIDs, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
            $elements
        );
        foreach ($ids->childs as $child){
            $shopClientID = $child->values['shop_client_id'];
            if(!key_exists($shopClientID, $listIDs->childs)){
                $child->additionDatas = $resultArray;
                $listIDs->childs[$shopClientID] = $child;
            }

            $listIDs->childs[$shopClientID]->additionDatas['quantity_day'] +=
                $child->values['quantity'] * $child->getElementValue('shop_product_id', 'volume', 1);
        }

        $ids = Request_Request::findBranch('DB_Ab1_Shop_Piece_Item',
            $shopIDs, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
            $elements
        );
        foreach ($ids->childs as $child){
            $shopClientID = $child->values['shop_client_id'];
            if(!key_exists($shopClientID, $listIDs->childs)){
                $child->additionDatas = $resultArray;
                $listIDs->childs[$shopClientID] = $child;
            }

            $listIDs->childs[$shopClientID]->additionDatas['quantity_day'] +=
                $child->values['quantity'] * $child->getElementValue('shop_product_id', 'volume', 1);
        }

        // задаем время выборки вчера
        $paramsYesterday = $params;
        $paramsYesterday['exit_at_to'] = $dateFrom;
        $paramsYesterday['exit_at_from'] = Helpers_DateTime::minusDays($dateFrom, 1);

        $ids = Request_Request::findBranch('DB_Ab1_Shop_Car_Item',
            $shopIDs, $this->_sitePageData, $this->_driverDB, $paramsYesterday, 0, TRUE,
            $elements
        );
        foreach ($ids->childs as $child){
            $shopClientID = $child->values['shop_client_id'];
            if(!key_exists($shopClientID, $listIDs->childs)){
                $child->additionDatas = $resultArray;
                $listIDs->childs[$shopClientID] = $child;
            }

            $listIDs->childs[$shopClientID]->additionDatas['quantity_yesterday'] +=
                $child->values['quantity'] * $child->getElementValue('shop_product_id', 'volume', 1);
        }

        $ids = Request_Request::findBranch('DB_Ab1_Shop_Piece_Item',
            $shopIDs, $this->_sitePageData, $this->_driverDB, $paramsYesterday, 0, TRUE,
            $elements
        );
        foreach ($ids->childs as $child){
            $shopClientID = $child->values['shop_client_id'];
            if(!key_exists($shopClientID, $listIDs->childs)){
                $child->additionDatas = $resultArray;
                $listIDs->childs[$shopClientID] = $child;
            }

            $listIDs->childs[$shopClientID]->additionDatas['quantity_yesterday'] +=
                $child->values['quantity'] * $child->getElementValue('shop_product_id', 'volume', 1);
        }

        // задаем время выборки с начала недели
        $dateFrom = Helpers_DateTime::getWeekBeginStr(date('Y-m-d')).' 06:00:00';
        $params['exit_at_from'] = $dateFrom;

        $ids = Request_Request::findBranch('DB_Ab1_Shop_Car_Item',
            $shopIDs, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
            $elements
        );
        foreach ($ids->childs as $child){
            $shopClientID = $child->values['shop_client_id'];
            if(!key_exists($shopClientID, $listIDs->childs)){
                $child->additionDatas = $resultArray;
                $listIDs->childs[$shopClientID] = $child;
            }

            $listIDs->childs[$shopClientID]->additionDatas['quantity_week'] +=
                $child->values['quantity'] * $child->getElementValue('shop_product_id', 'volume', 1);
        }

        $ids = Request_Request::findBranch('DB_Ab1_Shop_Piece_Item',
            $shopIDs, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
            $elements
        );
        foreach ($ids->childs as $child){
            $shopClientID = $child->values['shop_client_id'];
            if(!key_exists($shopClientID, $listIDs->childs)){
                $child->additionDatas = $resultArray;
                $listIDs->childs[$shopClientID] = $child;
            }

            $listIDs->childs[$shopClientID]->additionDatas['quantity_week'] +=
                $child->values['quantity'] * $child->getElementValue('shop_product_id', 'volume', 1);
        }

        // задаем время выборки с начала месяца
        $dateFrom = Helpers_DateTime::getMonthBeginStr(date('m'), date('Y')).' 06:00:00';
        $params['exit_at_from'] = $dateFrom;

        $ids = Request_Request::findBranch('DB_Ab1_Shop_Car_Item',
            $shopIDs, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
            $elements
        );
        foreach ($ids->childs as $child){
            $shopClientID = $child->values['shop_client_id'];
            if(!key_exists($shopClientID, $listIDs->childs)){
                $child->additionDatas = $resultArray;
                $listIDs->childs[$shopClientID] = $child;
            }

            $listIDs->childs[$shopClientID]->additionDatas['quantity_month'] +=
                $child->values['quantity'] * $child->getElementValue('shop_product_id', 'volume', 1);
        }

        $ids = Request_Request::findBranch('DB_Ab1_Shop_Piece_Item',
            $shopIDs, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
            $elements
        );
        foreach ($ids->childs as $child){
            $shopClientID = $child->values['shop_client_id'];
            if(!key_exists($shopClientID, $listIDs->childs)){
                $child->additionDatas = $resultArray;
                $listIDs->childs[$shopClientID] = $child;
            }

            $listIDs->childs[$shopClientID]->additionDatas['quantity_month'] +=
                $child->values['quantity'] * $child->getElementValue('shop_product_id', 'volume', 1);
        }

        // задаем время выборки с предыдущего месяца
        $paramsPreviousMonth = $params;
        $tmp = Helpers_DateTime::getMonthBeginStr(date('m'), date('Y')).' 06:00:00';
        $paramsPreviousMonth['exit_at_to'] = $tmp;
        $paramsPreviousMonth['exit_at_from'] = Helpers_DateTime::minusMonth($tmp, 1, true);

        $ids = Request_Request::findBranch('DB_Ab1_Shop_Car_Item',
            $shopIDs, $this->_sitePageData, $this->_driverDB, $paramsPreviousMonth, 0, TRUE,
            $elements
        );
        foreach ($ids->childs as $child){
            $shopClientID = $child->values['shop_client_id'];
            if(!key_exists($shopClientID, $listIDs->childs)){
                $child->additionDatas = $resultArray;
                $listIDs->childs[$shopClientID] = $child;
            }

            $listIDs->childs[$shopClientID]->additionDatas['quantity_month_previous'] +=
                $child->values['quantity'] * $child->getElementValue('shop_product_id', 'volume', 1);
        }

        $ids = Request_Request::findBranch('DB_Ab1_Shop_Piece_Item',
            $shopIDs, $this->_sitePageData, $this->_driverDB, $paramsPreviousMonth, 0, TRUE,
            $elements
        );
        foreach ($ids->childs as $child){
            $shopClientID = $child->values['shop_client_id'];
            if(!key_exists($shopClientID, $listIDs->childs)){
                $child->additionDatas = $resultArray;
                $listIDs->childs[$shopClientID] = $child;
            }

            $listIDs->childs[$shopClientID]->additionDatas['quantity_month_previous'] +=
                $child->values['quantity'] * $child->getElementValue('shop_product_id', 'volume', 1);
        }

        // задаем время выборки с начала года
        $dateFrom = Helpers_DateTime::getYearBeginStr(date('Y')).' 06:00:00';
        $params['exit_at_from'] = $dateFrom;

        $ids = Request_Request::findBranch('DB_Ab1_Shop_Car_Item',
            $shopIDs, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
            $elements
        );
        foreach ($ids->childs as $child){
            $shopClientID = $child->values['shop_client_id'];
            if(!key_exists($shopClientID, $listIDs->childs)){
                $child->additionDatas = $resultArray;
                $listIDs->childs[$shopClientID] = $child;
            }

            $listIDs->childs[$shopClientID]->additionDatas['quantity_year'] +=
                $child->values['quantity'] * $child->getElementValue('shop_product_id', 'volume', 1);
        }

        $ids = Request_Request::findBranch('DB_Ab1_Shop_Piece_Item',
            $shopIDs, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
            $elements
        );
        foreach ($ids->childs as $child){
            $shopClientID = $child->values['shop_client_id'];
            if(!key_exists($shopClientID, $listIDs->childs)){
                $child->additionDatas = $resultArray;
                $listIDs->childs[$shopClientID] = $child;
            }

            $listIDs->childs[$shopClientID]->additionDatas['quantity_year'] +=
                $child->values['quantity'] * $child->getElementValue('shop_product_id', 'volume', 1);
        }

        // итог
        $listIDs->additionDatas = $listIDs->calcTotalsChild(
            array(
                'quantity_day',
                'quantity_yesterday',
                'quantity_week',
                'quantity_month',
                'quantity_month_previous',
                'quantity_year',
            ),
            true
        );

        $listIDs->childsSortBy(
            Request_RequestParams::getParamArray('sort_by', [],
                array(
                    'shop_client_id'=> 'asc',
                    'quantity_day' => 'asc',
                    'quantity_yesterday' => 'asc',
                    'quantity_week' => 'asc',
                    'quantity_month' => 'asc',
                    'quantity_month_previous' => 'asc',
                    'quantity_year' => 'asc',
                )
            ), true, true
        );
        $this->_sitePageData->countRecord = count($listIDs->childs);

        $this->_sitePageData->newShopShablonPath('ab1/_all');
        $this->_sitePageData->replaceDatas['view::_shop/client/list/charity'] = Helpers_View::getViewObjects(
            $listIDs, new Model_Ab1_Shop_Product_Rubric(),
            '_shop/client/list/charity','_shop/client/one/charity',
            $this->_sitePageData, $this->_driverDB
        );
        $this->_sitePageData->previousShopShablonPath();

        $this->_putInMain('/main/_shop/client/charity');
    }

    private function _statisticsPreviousYear($year, MyArray $shopProductRubricIDs, $isAllBranch)
    {
        $elements = array('shop_product_id' => array('volume'));

        foreach ($shopProductRubricIDs->childs as $child) {
            $child->additionDatas = array(
                'quantities' => array(
                    1 => 0, 2 => 0, 3 => 0, 4 => 0, 5 => 0, 6 => 0, 7 => 0, 8 => 0, 9 => 0, 10 => 0, 11 => 0, 12 => 0,
                ),
                'quantity' => 0,
            );

            $shopProductIDs = Api_Ab1_Shop_Product::findAllByMainRubric(
                $child->id, $this->_sitePageData, $this->_driverDB
            );

            for ($i = 1; $i < 12; $i++){
                $params = Request_RequestParams::setParams(
                    array(
                        'is_exit' => 1,
                        'is_charity' => FALSE,
                        'exit_at_from' => Helpers_DateTime::getMonthBeginStr($i, $year).' 06:00:00',
                        'exit_at_to' => Helpers_DateTime::getMonthBeginStr($i + 1, $year).' 06:00:00',
                        'sum_quantity' => TRUE,
                        'shop_product_id' => $shopProductIDs,
                        'group_by' => array(
                            'shop_product_id.volume'
                        ),
                    ),
                    FALSE
                );

                if(!$isAllBranch){
                    $ids = Request_Request::find('DB_Ab1_Shop_Car_Item',
                        $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
                        $elements
                    );
                }else{
                    $ids = Request_Request::findBranch('DB_Ab1_Shop_Car_Item',
                        array(), $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
                        $elements
                    );
                }

                foreach ($ids->childs as $item){
                    $child->additionDatas['quantities'][$i] += $item->values['quantity']
                        * $item->getElementValue('shop_product_id', 'volume', 1);
                }

                if (!$isAllBranch) {
                    $ids = Request_Request::find('DB_Ab1_Shop_Piece_Item',
                        $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
                        $elements
                    );
                } else {
                    $ids = Request_Request::findBranch('DB_Ab1_Shop_Piece_Item',
                        array(), $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
                        $elements
                    );
                }

                foreach ($ids->childs as $item){
                    $child->additionDatas['quantities'][$i] += $item->values['quantity']
                        * $item->getElementValue('shop_product_id', 'volume', 1);
                }
            }
        }

        $shopProductRubricIDs->childsSortBy(array('name'));
        $this->_sitePageData->countRecord = count($shopProductRubricIDs->childs);

        return Helpers_View::getViewObjects(
            $shopProductRubricIDs, new Model_Ab1_Shop_Product_Rubric(),
            '_shop/product/rubric/list/statistics-year','_shop/product/rubric/one/statistics-year',
            $this->_sitePageData, $this->_driverDB
        );
    }

    protected function _actionShopProductRubricStatistics()
    {
        // предыдущие года
        $year = Request_RequestParams::getParamInt('year');


        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/product/rubric/list/statistics',
            )
        );
        $this->_requestShopBranches($this->_sitePageData->shopID, TRUE);

        $shopProductRubricID = Request_RequestParams::getParamInt('shop_product_rubric_id');
        if($shopProductRubricID > 0){
            $model = new Model_Ab1_Shop_Product_Rubric();
            $model->setDBDriver($this->_driverDB);
            Helpers_DB::getDBObject($model, $shopProductRubricID, $this->_sitePageData, $this->_sitePageData->shopMainID);

            $shopProductRubricIDs = new MyArray();
            $shopProductRubricIDs->addChild($model->id)->setValues($model, $this->_sitePageData);
        }else{
            $params = Request_RequestParams::setParams(
                array(
                    'root_id' => 0,
                )
            );
            $shopProductRubricIDs = Request_Request::find('DB_Ab1_Shop_Product_Rubric',
                $this->_sitePageData->shopMainID, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE
            );
        }

        $isAllBranch = Request_RequestParams::getParamInt('shop_branch_id') == -1;

        if($year !== null){
            $result = $this->_statisticsPreviousYear($year, $shopProductRubricIDs, $isAllBranch);
        }else {
            foreach ($shopProductRubricIDs->childs as $child) {
                $child->additionDatas = array(
                    'quantity_day' => 0,
                    'quantity_yesterday' => 0,
                    'quantity_week' => 0,
                    'quantity_month' => 0,
                    'quantity_month_previous' => 0,
                    'quantity_year' => 0,
                    'quantity' => 0,
                );

                $shopProductIDs = Api_Ab1_Shop_Product::findAllByMainRubric(
                    $child->id, $this->_sitePageData, $this->_driverDB
                );

                // задаем время выборки с начала дня
                $dateFrom = date('Y-m-d') . ' 06:00:00';

                $params = Request_RequestParams::setParams(
                    array(
                        'is_exit' => 1,
                        'is_charity' => FALSE,
                        'exit_at_from' => $dateFrom,
                        'sum_quantity' => TRUE,
                        'shop_product_id' => $shopProductIDs,
                        'group_by' => array(
                            'shop_product_id.volume'
                        ),
                    )
                );
                $elements = array('shop_product_id' => array('volume'));

                if (!$isAllBranch) {
                    $ids = Request_Request::find('DB_Ab1_Shop_Car_Item',
                        $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
                        $elements
                    );
                } else {
                    $ids = Request_Request::findBranch('DB_Ab1_Shop_Car_Item',
                        array(), $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
                        $elements
                    );
                }

                foreach ($ids->childs as $item) {
                    $child->additionDatas['quantity_day'] += $item->values['quantity']
                        * $item->getElementValue('shop_product_id', 'volume', 1);
                }

                if (!$isAllBranch) {
                    $ids = Request_Request::find('DB_Ab1_Shop_Piece_Item',
                        $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
                        $elements
                    );
                } else {
                    $ids = Request_Request::findBranch('DB_Ab1_Shop_Piece_Item',
                        array(), $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
                        $elements
                    );
                }

                foreach ($ids->childs as $item) {
                    $child->additionDatas['quantity_day'] += $item->values['quantity']
                        * $item->getElementValue('shop_product_id', 'volume', 1);
                }

                // задаем время выборки вчера
                $params = Request_RequestParams::setParams(
                    array(
                        'is_exit' => 1,
                        'is_charity' => FALSE,
                        'exit_at_to' => $dateFrom,
                        'exit_at_from' => Helpers_DateTime::minusDays($dateFrom, 1),
                        'sum_quantity' => TRUE,
                        'shop_product_id' => $shopProductIDs,
                        'group_by' => array(
                            'shop_product_id.volume'
                        ),
                    )
                );

                if (!$isAllBranch) {
                    $ids = Request_Request::find('DB_Ab1_Shop_Car_Item',
                        $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
                        $elements
                    );
                } else {
                    $ids = Request_Request::findBranch('DB_Ab1_Shop_Car_Item',
                        array(), $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
                        $elements
                    );
                }

                foreach ($ids->childs as $item) {
                    $child->additionDatas['quantity_yesterday'] += $item->values['quantity']
                        * $item->getElementValue('shop_product_id', 'volume', 1);
                }

                if (!$isAllBranch) {
                    $ids = Request_Request::find('DB_Ab1_Shop_Piece_Item',
                        $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
                        $elements
                    );
                } else {
                    $ids = Request_Request::findBranch('DB_Ab1_Shop_Piece_Item',
                        array(), $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
                        $elements
                    );
                }

                foreach ($ids->childs as $item) {
                    $child->additionDatas['quantity_yesterday'] += $item->values['quantity']
                        * $item->getElementValue('shop_product_id', 'volume', 1);
                }

                // задаем время выборки с начала недели
                $dateFrom = Helpers_DateTime::getWeekBeginStr(date('Y-m-d')) . ' 06:00:00';

                $params = Request_RequestParams::setParams(
                    array(
                        'is_exit' => 1,
                        'is_charity' => FALSE,
                        'exit_at_from' => $dateFrom,
                        'sum_quantity' => TRUE,
                        'shop_product_id' => $shopProductIDs,
                        'group_by' => array(
                            'shop_product_id.volume'
                        ),
                    )
                );

                if (!$isAllBranch) {
                    $ids = Request_Request::find('DB_Ab1_Shop_Car_Item',
                        $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
                        $elements
                    );
                } else {
                    $ids = Request_Request::findBranch('DB_Ab1_Shop_Car_Item',
                        array(), $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
                        $elements
                    );
                }

                foreach ($ids->childs as $item) {
                    $child->additionDatas['quantity_week'] += $item->values['quantity']
                        * $item->getElementValue('shop_product_id', 'volume', 1);
                }

                if (!$isAllBranch) {
                    $ids = Request_Request::find('DB_Ab1_Shop_Piece_Item',
                        $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
                        $elements
                    );
                } else {
                    $ids = Request_Request::findBranch('DB_Ab1_Shop_Piece_Item',
                        array(), $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
                        $elements
                    );
                }

                foreach ($ids->childs as $item) {
                    $child->additionDatas['quantity_week'] += $item->values['quantity']
                        * $item->getElementValue('shop_product_id', 'volume', 1);
                }

                // задаем время выборки с начала месяца
                $dateFrom = Helpers_DateTime::getMonthBeginStr(date('m'), date('Y')) . ' 06:00:00';

                $params = Request_RequestParams::setParams(
                    array(
                        'is_exit' => 1,
                        'is_charity' => FALSE,
                        'exit_at_from' => $dateFrom,
                        'sum_quantity' => TRUE,
                        'shop_product_id' => $shopProductIDs,
                        'group_by' => array(
                            'shop_product_id.volume'
                        ),
                    )
                );

                if (!$isAllBranch) {
                    $ids = Request_Request::find('DB_Ab1_Shop_Car_Item',
                        $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
                        $elements
                    );
                } else {
                    $ids = Request_Request::findBranch('DB_Ab1_Shop_Car_Item',
                        array(), $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
                        $elements
                    );
                }

                foreach ($ids->childs as $item) {
                    $child->additionDatas['quantity_month'] += $item->values['quantity']
                        * $item->getElementValue('shop_product_id', 'volume', 1);
                }

                if (!$isAllBranch) {
                    $ids = Request_Request::find('DB_Ab1_Shop_Piece_Item',
                        $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
                        $elements
                    );
                } else {
                    $ids = Request_Request::findBranch('DB_Ab1_Shop_Piece_Item',
                        array(), $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
                        $elements
                    );
                }

                foreach ($ids->childs as $item) {
                    $child->additionDatas['quantity_month'] += $item->values['quantity']
                        * $item->getElementValue('shop_product_id', 'volume', 1);
                }

                // задаем время выборки с предыдущего месяца
                $paramsPreviousMonth = $params;
                $tmp = Helpers_DateTime::getMonthBeginStr(date('m'), date('Y')).' 06:00:00';
                $paramsPreviousMonth['exit_at_to'] = $tmp;
                $paramsPreviousMonth['exit_at_from'] = Helpers_DateTime::minusMonth($tmp, 1, true);

                if (!$isAllBranch) {
                    $ids = Request_Request::find('DB_Ab1_Shop_Car_Item',
                        $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB, $paramsPreviousMonth, 0, TRUE,
                        $elements
                    );
                } else {
                    $ids = Request_Request::findBranch('DB_Ab1_Shop_Car_Item',
                        array(), $this->_sitePageData, $this->_driverDB, $paramsPreviousMonth, 0, TRUE,
                        $elements
                    );
                }

                foreach ($ids->childs as $item) {
                    $child->additionDatas['quantity_month_previous'] += $item->values['quantity']
                        * $item->getElementValue('shop_product_id', 'volume', 1);
                }

                if (!$isAllBranch) {
                    $ids = Request_Request::find('DB_Ab1_Shop_Piece_Item',
                        $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB, $paramsPreviousMonth, 0, TRUE,
                        $elements
                    );
                } else {
                    $ids = Request_Request::findBranch('DB_Ab1_Shop_Piece_Item',
                        array(), $this->_sitePageData, $this->_driverDB, $paramsPreviousMonth, 0, TRUE,
                        $elements
                    );
                }

                foreach ($ids->childs as $item) {
                    $child->additionDatas['quantity_month_previous'] += $item->values['quantity']
                        * $item->getElementValue('shop_product_id', 'volume', 1);
                }

                // задаем время выборки с начала года
                $dateFrom = Helpers_DateTime::getYearBeginStr(date('Y')) . ' 06:00:00';

                $params = Request_RequestParams::setParams(
                    array(
                        'is_exit' => 1,
                        'is_charity' => FALSE,
                        'exit_at_from' => $dateFrom,
                        'sum_quantity' => TRUE,
                        'shop_product_id' => $shopProductIDs,
                        'group_by' => array(
                            'shop_product_id.volume'
                        ),
                    )
                );

                if (!$isAllBranch) {
                    $ids = Request_Request::find('DB_Ab1_Shop_Car_Item',
                        $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
                        $elements
                    );
                } else {
                    $ids = Request_Request::findBranch('DB_Ab1_Shop_Car_Item',
                        array(), $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
                        $elements
                    );
                }

                foreach ($ids->childs as $item) {
                    $child->additionDatas['quantity_year'] += $item->values['quantity']
                        * $item->getElementValue('shop_product_id', 'volume', 1);
                }

                if (!$isAllBranch) {
                    $ids = Request_Request::find('DB_Ab1_Shop_Piece_Item',
                        $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
                        $elements
                    );
                } else {
                    $ids = Request_Request::findBranch('DB_Ab1_Shop_Piece_Item',
                        array(), $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
                        $elements
                    );
                }


                foreach ($ids->childs as $item) {
                    $child->additionDatas['quantity_year'] += $item->values['quantity']
                        * $item->getElementValue('shop_product_id', 'volume', 1);
                }
            }

            $shopProductRubricIDs->additionDatas = $shopProductRubricIDs->calcTotalsChild(
                array(
                    'quantity_day',
                    'quantity_yesterday',
                    'quantity_week',
                    'quantity_month',
                    'quantity_month_previous',
                    'quantity_year',
                ),
                true
            );
            $shopProductRubricIDs->childsSortBy(
                Request_RequestParams::getParamArray('sort_by', [],
                    array(
                        'name'=> 'asc',
                        'quantity_day' => 'asc',
                        'quantity_yesterday' => 'asc',
                        'quantity_week' => 'asc',
                        'quantity_month' => 'asc',
                        'quantity_month_previous' => 'asc',
                        'quantity_year' => 'asc',
                    )
                ), true, true
            );
            //$shopProductRubricIDs->childsSortBy(array('name'));
            $this->_sitePageData->countRecord = count($shopProductRubricIDs->childs);

            $this->_sitePageData->newShopShablonPath('ab1/_all');
            $result = Helpers_View::getViewObjects(
                $shopProductRubricIDs, new Model_Ab1_Shop_Product_Rubric(),
                '_shop/product/rubric/list/statistics','_shop/product/rubric/one/statistics',
                $this->_sitePageData, $this->_driverDB
            );
            $this->_sitePageData->previousShopShablonPath();
        }

        $this->_sitePageData->replaceDatas['view::_shop/product/rubric/list/statistics'] = $result;

        $this->_putInMain('/main/_shop/product/rubric/statistics');
    }

    protected function _actionShopProductStatistics()
    {
        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/product/list/statistics',
            )
        );

        $this->_requestShopProductRubrics();
        $this->_requestShopProductPricelistRubrics();
        if(Request_RequestParams::getParamInt('shop_storage_id') !== null) {
            $this->_requestShopStorages();
        }
        $this->_requestShopBranches($this->_sitePageData->shopID, TRUE);

        $shopProductRubricID = Request_RequestParams::getParamInt('shop_product_rubric_id');
        if($shopProductRubricID > 0){
            $model = new Model_Ab1_Shop_Product_Rubric();
            $model->setDBDriver($this->_driverDB);
            Helpers_DB::getDBObject($model, $shopProductRubricID, $this->_sitePageData, $this->_sitePageData->shopMainID);

            $shopProductRubricIDs = new MyArray();
            $shopProductRubricIDs->addChild($model->id)->setValues($model, $this->_sitePageData);
        }else{
            $params = Request_RequestParams::setParams(
                array(
                    'root_id' => 0,
                )
            );
            $shopProductRubricIDs = Request_Request::find('DB_Ab1_Shop_Product_Rubric',
                $this->_sitePageData->shopMainID, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE
            );
        }

        $shopProductIDs = array();
        foreach ($shopProductRubricIDs->childs as $child) {
            $shopProductIDs = array_merge(
                $shopProductIDs,
                Api_Ab1_Shop_Product::findAllByMainRubric(
                    $child->id, $this->_sitePageData, $this->_driverDB
                )
            );
        }

        $isAllBranch = Request_RequestParams::getParamInt('shop_branch_id') == -1;

        // задаем время выборки с начала дня
        $dateFrom = date('Y-m-d').' 06:00:00';
        $listIDs = new MyArray();
        $params = Request_RequestParams::setParams(
            array(
                'is_exit' => 1,
                'exit_at_from' => $dateFrom,
                'sum_quantity' => TRUE,
                'is_charity' => FALSE,
                'shop_product_id' => $shopProductIDs,
                'group_by' => array(
                    'shop_product_id',
                    'shop_product_id.name',
                    'shop_product_id.unit',
                    'shop_product_id.volume',
                ),
            ),
            FALSE
        );
        $elements = array('shop_product_id' => array('name', 'unit', 'volume'));

        $resultArray = array(
            'quantity_day' => 0,
            'quantity_yesterday' => 0,
            'quantity_week' => 0,
            'quantity_month' => 0,
            'quantity_month_previous' => 0,
            'quantity_year' => 0,
        );

        if(!$isAllBranch){
            $ids = Request_Request::find('DB_Ab1_Shop_Car',
                $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
                $elements
            );
        }else{
            $ids = Request_Request::findBranch('DB_Ab1_Shop_Car',
                array(), $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
                $elements
            );
        }
        foreach ($ids->childs as $child){
            $shopProductID = $child->values['shop_product_id'];
            if(!key_exists($shopProductID, $listIDs->childs)){
                $child->additionDatas = $resultArray;
                $listIDs->childs[$shopProductID] = $child;
            }
            $listIDs->childs[$shopProductID]->additionDatas['quantity_day'] +=
                $child->values['quantity'] * $child->getElementValue('shop_product_id', 'volume', 1);
        }

        if(!$isAllBranch){
            $ids = Request_Request::find('DB_Ab1_Shop_Piece_Item',
                $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
                $elements
            );
        }else{
            $ids = Request_Request::findBranch('DB_Ab1_Shop_Piece_Item',
                array(), $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
                $elements
            );
        }
        foreach ($ids->childs as $child){
            $shopProductID = $child->values['shop_product_id'];
            if(!key_exists($shopProductID, $listIDs->childs)){
                $child->additionDatas = $resultArray;
                $listIDs->childs[$shopProductID] = $child;
            }

            $listIDs->childs[$shopProductID]->additionDatas['quantity_day'] +=
                $child->values['quantity'] * $child->getElementValue('shop_product_id', 'volume', 1);
        }

        // задаем время выборки вчера
        $paramsYesterday = $params;
        $paramsYesterday['exit_at_to'] = $dateFrom;
        $paramsYesterday['exit_at_from'] = Helpers_DateTime::minusDays($dateFrom, 1);

        if(!$isAllBranch){
            $ids = Request_Request::find('DB_Ab1_Shop_Car_Item',
                $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB, $paramsYesterday, 0, TRUE,
                $elements
            );
        }else{
            $ids = Request_Request::findBranch('DB_Ab1_Shop_Car_Item',
                array(), $this->_sitePageData, $this->_driverDB, $paramsYesterday, 0, TRUE,
                $elements
            );
        }
        foreach ($ids->childs as $child){
            $shopProductID = $child->values['shop_product_id'];
            if(!key_exists($shopProductID, $listIDs->childs)){
                $child->additionDatas = $resultArray;
                $listIDs->childs[$shopProductID] = $child;
            }

            $listIDs->childs[$shopProductID]->additionDatas['quantity_yesterday'] +=
                $child->values['quantity'] * $child->getElementValue('shop_product_id', 'volume', 1);
        }

        if(!$isAllBranch){
            $ids = Request_Request::find('DB_Ab1_Shop_Piece_Item',
                $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB, $paramsYesterday, 0, TRUE,
                $elements
            );
        }else{
            $ids = Request_Request::findBranch('DB_Ab1_Shop_Piece_Item',
                array(), $this->_sitePageData, $this->_driverDB, $paramsYesterday, 0, TRUE,
                $elements
            );
        }
        foreach ($ids->childs as $child){
            $shopProductID = $child->values['shop_product_id'];
            if(!key_exists($shopProductID, $listIDs->childs)){
                $child->additionDatas = $resultArray;
                $listIDs->childs[$shopProductID] = $child;
            }

            $listIDs->childs[$shopProductID]->additionDatas['quantity_yesterday'] +=
                $child->values['quantity'] * $child->getElementValue('shop_product_id', 'volume', 1);
        }

        // задаем время выборки с начала недели
        $dateFrom = Helpers_DateTime::getWeekBeginStr(date('Y-m-d')).' 06:00:00';
        $params['exit_at_from'] = $dateFrom;

        if(!$isAllBranch){
            $ids = Request_Request::find('DB_Ab1_Shop_Car_Item',
                $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
                $elements
            );
        }else{
            $ids = Request_Request::findBranch('DB_Ab1_Shop_Car_Item',
                array(), $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
                $elements
            );
        }
        foreach ($ids->childs as $child){
            $shopProductID = $child->values['shop_product_id'];
            if(!key_exists($shopProductID, $listIDs->childs)){
                $child->additionDatas = $resultArray;
                $listIDs->childs[$shopProductID] = $child;
            }

            $listIDs->childs[$shopProductID]->additionDatas['quantity_week'] +=
                $child->values['quantity'] * $child->getElementValue('shop_product_id', 'volume', 1);
        }

        if(!$isAllBranch){
            $ids = Request_Request::find('DB_Ab1_Shop_Piece_Item',
                $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
                $elements
            );
        }else{
            $ids = Request_Request::findBranch('DB_Ab1_Shop_Piece_Item',
                array(), $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
                $elements
            );
        }
        foreach ($ids->childs as $child){
            $shopProductID = $child->values['shop_product_id'];
            if(!key_exists($shopProductID, $listIDs->childs)){
                $child->additionDatas = $resultArray;
                $listIDs->childs[$shopProductID] = $child;
            }

            $listIDs->childs[$shopProductID]->additionDatas['quantity_week'] +=
                $child->values['quantity'] * $child->getElementValue('shop_product_id', 'volume', 1);
        }

        // задаем время выборки с начала месяца
        $dateFrom = Helpers_DateTime::getMonthBeginStr(date('m'), date('Y')).' 06:00:00';
        $params['exit_at_from'] = $dateFrom;

        if(!$isAllBranch){
            $ids = Request_Request::find('DB_Ab1_Shop_Car_Item',
                $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
                $elements
            );
        }else{
            $ids = Request_Request::findBranch('DB_Ab1_Shop_Car_Item',
                array(), $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
                $elements
            );
        }
        foreach ($ids->childs as $child){
            $shopProductID = $child->values['shop_product_id'];
            if(!key_exists($shopProductID, $listIDs->childs)){
                $child->additionDatas = $resultArray;
                $listIDs->childs[$shopProductID] = $child;
            }

            $listIDs->childs[$shopProductID]->additionDatas['quantity_month'] +=
                $child->values['quantity'] * $child->getElementValue('shop_product_id', 'volume', 1);
        }

        if(!$isAllBranch){
            $ids = Request_Request::find('DB_Ab1_Shop_Piece_Item',
                $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
                $elements
            );
        }else{
            $ids = Request_Request::findBranch('DB_Ab1_Shop_Piece_Item',
                array(), $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
                $elements
            );
        }
        foreach ($ids->childs as $child){
            $shopProductID = $child->values['shop_product_id'];
            if(!key_exists($shopProductID, $listIDs->childs)){
                $child->additionDatas = $resultArray;
                $listIDs->childs[$shopProductID] = $child;
            }

            $listIDs->childs[$shopProductID]->additionDatas['quantity_month'] +=
                $child->values['quantity'] * $child->getElementValue('shop_product_id', 'volume', 1);
        }

        // задаем время выборки с предыдущего месяца
        $paramsPreviousMonth = $params;
        $tmp = Helpers_DateTime::getMonthBeginStr(date('m'), date('Y')).' 06:00:00';
        $paramsPreviousMonth['exit_at_to'] = $tmp;
        $paramsPreviousMonth['exit_at_from'] = Helpers_DateTime::minusMonth($tmp, 1, true);

        if(!$isAllBranch){
            $ids = Request_Request::find('DB_Ab1_Shop_Car_Item',
                $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB, $paramsPreviousMonth, 0, TRUE,
                $elements
            );
        }else{
            $ids = Request_Request::findBranch('DB_Ab1_Shop_Car_Item',
                array(), $this->_sitePageData, $this->_driverDB, $paramsPreviousMonth, 0, TRUE,
                $elements
            );
        }
        foreach ($ids->childs as $child){
            $shopProductID = $child->values['shop_product_id'];
            if(!key_exists($shopProductID, $listIDs->childs)){
                $child->additionDatas = $resultArray;
                $listIDs->childs[$shopProductID] = $child;
            }

            $listIDs->childs[$shopProductID]->additionDatas['quantity_month_previous'] +=
                $child->values['quantity'] * $child->getElementValue('shop_product_id', 'volume', 1);
        }

        if(!$isAllBranch){
            $ids = Request_Request::find('DB_Ab1_Shop_Piece_Item',
                $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB, $paramsPreviousMonth, 0, TRUE,
                $elements
            );
        }else{
            $ids = Request_Request::findBranch('DB_Ab1_Shop_Piece_Item',
                array(), $this->_sitePageData, $this->_driverDB, $paramsPreviousMonth, 0, TRUE,
                $elements
            );
        }
        foreach ($ids->childs as $child){
            $shopProductID = $child->values['shop_product_id'];
            if(!key_exists($shopProductID, $listIDs->childs)){
                $child->additionDatas = $resultArray;
                $listIDs->childs[$shopProductID] = $child;
            }

            $listIDs->childs[$shopProductID]->additionDatas['quantity_month_previous'] +=
                $child->values['quantity'] * $child->getElementValue('shop_product_id', 'volume', 1);
        }

        // задаем время выборки с начала года
        $dateFrom = Helpers_DateTime::getYearBeginStr(date('Y')).' 06:00:00';
        $params['exit_at_from'] = $dateFrom;

        if(!$isAllBranch){
            $ids = Request_Request::find('DB_Ab1_Shop_Car_Item',
                $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
                $elements
            );
        }else{
            $ids = Request_Request::findBranch('DB_Ab1_Shop_Car_Item',
                array(), $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
                $elements
            );
        }
        foreach ($ids->childs as $child){
            $shopProductID = $child->values['shop_product_id'];
            if(!key_exists($shopProductID, $listIDs->childs)){
                $child->additionDatas = $resultArray;
                $listIDs->childs[$shopProductID] = $child;
            }

            $listIDs->childs[$shopProductID]->additionDatas['quantity_year'] +=
                $child->values['quantity'] * $child->getElementValue('shop_product_id', 'volume', 1);
        }

        if(!$isAllBranch){
            $ids = Request_Request::find('DB_Ab1_Shop_Piece_Item',
                $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
                $elements
            );
        }else{
            $ids = Request_Request::findBranch('DB_Ab1_Shop_Piece_Item',
                array(), $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
                $elements
            );
        }
        foreach ($ids->childs as $child){
            $shopProductID = $child->values['shop_product_id'];
            if(!key_exists($shopProductID, $listIDs->childs)){
                $child->additionDatas = $resultArray;
                $listIDs->childs[$shopProductID] = $child;
            }

            $listIDs->childs[$shopProductID]->additionDatas['quantity_year'] +=
                $child->values['quantity'] * $child->getElementValue('shop_product_id', 'volume', 1);
        }

        // задаем время выборки с за все время
        /*
         $params['exit_at_from'] = NULL;

        if(!$isAllBranch){
             $ids = Request_Request::find('DB_Ab1_Shop_Car_Item',
                 $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
                $elements
             );
        }else{
             $ids = Request_Request::findBranch('DB_Ab1_Shop_Car_Item',
                 array(), $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
                $elements
             );
        }
        foreach ($ids->childs as $child){
            $shopProductID = $child->values['shop_product_id'];
            if(!key_exists($shopProductID, $listIDs->childs)){
                $child->additionDatas = $resultArray;
                $listIDs->childs[$shopProductID] = $child;
            }

            $listIDs->childs[$shopProductID]->additionDatas['quantity'] +=
        $child->values['quantity'] * $child->getElementValue('shop_product_id', 'volume', 1);
        }

        if(!$isAllBranch){
             $ids = Request_Request::find('DB_Ab1_Shop_Piece_Item',
                 $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
                $elements
             );
        }else{
             $ids = Request_Request::findBranch('DB_Ab1_Shop_Piece_Item',
                 array(), $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
                $elements
             );
        }
        foreach ($ids->childs as $child){
            $shopProductID = $child->values['shop_product_id'];
            if(!key_exists($shopProductID, $listIDs->childs)){
                $child->additionDatas = $resultArray;
                $listIDs->childs[$shopProductID] = $child;
            }

            $listIDs->childs[$shopProductID]->additionDatas['quantity'] +=
        $child->values['quantity'] * $child->getElementValue('shop_product_id', 'volume', 1);
        }*/

        // итог
        $total = array(
            'quantity_day' => 0,
            'quantity_yesterday' => 0,
            'quantity_week' => 0,
            'quantity_month' => 0,
            'quantity_month_previous' => 0,
            'quantity_year' => 0,
        );
        $totalVolume = array(
            'quantity_day' => 0,
            'quantity_yesterday' => 0,
            'quantity_week' => 0,
            'quantity_month' => 0,
            'quantity_month_previous' => 0,
            'quantity_year' => 0,
        );
        $isVolume = false;
        foreach ($listIDs->childs as $key => $child){
            $total['quantity_day'] += $child->additionDatas['quantity_day'];
            $total['quantity_yesterday'] += $child->additionDatas['quantity_yesterday'];
            $total['quantity_week'] += $child->additionDatas['quantity_week'];
            $total['quantity_month'] += $child->additionDatas['quantity_month'];
            $total['quantity_month_previous'] += $child->additionDatas['quantity_month_previous'];
            $total['quantity_year'] += $child->additionDatas['quantity_year'];

            $volume = $child->getElementValue('shop_product_id', 'volume', 1);
            $isVolume = $isVolume || $volume != 1;

            $totalVolume['quantity_day'] += $child->additionDatas['quantity_day'] / $volume;
            $totalVolume['quantity_yesterday'] += $child->additionDatas['quantity_yesterday'] / $volume;
            $totalVolume['quantity_week'] += $child->additionDatas['quantity_week'] / $volume;
            $totalVolume['quantity_month'] += $child->additionDatas['quantity_month'] / $volume;
            $totalVolume['quantity_month_previous'] += $child->additionDatas['quantity_month_previous'] / $volume;
            $totalVolume['quantity_year'] += $child->additionDatas['quantity_year'] / $volume;
        }
        $listIDs->additionDatas = $total;
        $listIDs->additionDatas['is_volume'] = $isVolume;
        $listIDs->additionDatas['volume'] = $totalVolume;

        $listIDs->childsSortBy(array('quantity_year', Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_product_id.name'), FALSE);
        $this->_sitePageData->countRecord = count($listIDs->childs);

        $this->_sitePageData->newShopShablonPath('ab1/_all');
        $this->_sitePageData->replaceDatas['view::_shop/product/list/statistics'] = Helpers_View::getViewObjects(
            $listIDs, new Model_Ab1_Shop_Product_Rubric(),
            '_shop/product/list/statistics','_shop/product/one/statistics',
            $this->_sitePageData, $this->_driverDB
        );
        $this->_sitePageData->previousShopShablonPath();

        $this->_putInMain('/main/_shop/product/statistics');
    }

    protected function _actionShopTurnPlaceStatistics()
    {
        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/turn/place/list/statistics',
            )
        );

        $this->_requestShopProducts(
            null, 0, NULL, FALSE,
            [
                Model_Ab1_ProductView::PRODUCT_TYPE_CAR,
                Model_Ab1_ProductView::PRODUCT_TYPE_CAR_AND_PIECE,
                Model_Ab1_ProductView::PRODUCT_TYPE_PIECE
            ]
        );
        $this->_requestShopProductPricelistRubrics();
        if(Request_RequestParams::getParamInt('shop_storage_id') !== null) {
            $this->_requestShopStorages();
        }
        $this->_requestShopBranches($this->_sitePageData->shopID, TRUE);

        $shopProductIDs = Request_RequestParams::getParam('shop_product_id');

        $isAllBranch = Request_RequestParams::getParamInt('shop_branch_id') == -1;

        // задаем время выборки с начала дня
        $dateFrom = date('Y-m-d').' 06:00:00';
        $listIDs = new MyArray();
        $params = Request_RequestParams::setParams(
            array(
                'is_exit' => 1,
                'exit_at_from' => $dateFrom,
                'sum_quantity' => TRUE,
                'is_charity' => FALSE,
                'shop_product_id' => $shopProductIDs,
                'group_by' => array(
                    'shop_turn_place_id',
                    'shop_turn_place_id.name',
                    'shop_product_id',
                    'shop_product_id.unit',
                    'shop_product_id.volume',
                ),
            ),
            FALSE
        );
        $elements = array(
            'shop_product_id' => array('unit', 'volume'),
            'shop_turn_place_id' => array('name')
        );

        $resultArray = array(
            'quantity_day' => 0,
            'quantity_yesterday' => 0,
            'quantity_week' => 0,
            'quantity_month' => 0,
            'quantity_month_previous' => 0,
            'quantity_year' => 0,
        );

        if(!$isAllBranch){
            $ids = Request_Request::find('DB_Ab1_Shop_Car',
                $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
                $elements
            );
        }else{
            $ids = Request_Request::findBranch('DB_Ab1_Shop_Car',
                array(), $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
                $elements
            );
        }
        foreach ($ids->childs as $child){
            $shopTurnPlaceID = $child->values['shop_turn_place_id'];
            if(!key_exists($shopTurnPlaceID, $listIDs->childs)){
                $child->additionDatas = $resultArray;
                $listIDs->childs[$shopTurnPlaceID] = $child;
            }
            $listIDs->childs[$shopTurnPlaceID]->additionDatas['quantity_day'] +=
                $child->values['quantity'] * $child->getElementValue('shop_product_id', 'volume', 1);
        }

        // задаем время выборки вчера
        $paramsYesterday = $params;
        $paramsYesterday['exit_at_to'] = $dateFrom;
        $paramsYesterday['exit_at_from'] = Helpers_DateTime::minusDays($dateFrom, 1);

        if(!$isAllBranch){
            $ids = Request_Request::find('DB_Ab1_Shop_Car',
                $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB, $paramsYesterday, 0, TRUE,
                $elements
            );
        }else{
            $ids = Request_Request::findBranch('DB_Ab1_Shop_Car',
                array(), $this->_sitePageData, $this->_driverDB, $paramsYesterday, 0, TRUE,
                $elements
            );
        }
        foreach ($ids->childs as $child){
            $shopTurnPlaceID = $child->values['shop_turn_place_id'];
            if(!key_exists($shopTurnPlaceID, $listIDs->childs)){
                $child->additionDatas = $resultArray;
                $listIDs->childs[$shopTurnPlaceID] = $child;
            }

            $listIDs->childs[$shopTurnPlaceID]->additionDatas['quantity_yesterday'] +=
                $child->values['quantity'] * $child->getElementValue('shop_product_id', 'volume', 1);
        }

        // задаем время выборки с начала недели
        $dateFrom = Helpers_DateTime::getWeekBeginStr(date('Y-m-d')).' 06:00:00';
        $params['exit_at_from'] = $dateFrom;

        if(!$isAllBranch){
            $ids = Request_Request::find('DB_Ab1_Shop_Car',
                $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
                $elements
            );
        }else{
            $ids = Request_Request::findBranch('DB_Ab1_Shop_Car',
                array(), $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
                $elements
            );
        }
        foreach ($ids->childs as $child){
            $shopTurnPlaceID = $child->values['shop_turn_place_id'];
            if(!key_exists($shopTurnPlaceID, $listIDs->childs)){
                $child->additionDatas = $resultArray;
                $listIDs->childs[$shopTurnPlaceID] = $child;
            }

            $listIDs->childs[$shopTurnPlaceID]->additionDatas['quantity_week'] +=
                $child->values['quantity'] * $child->getElementValue('shop_product_id', 'volume', 1);
        }

        // задаем время выборки с начала месяца
        $dateFrom = Helpers_DateTime::getMonthBeginStr(date('m'), date('Y')).' 06:00:00';
        $params['exit_at_from'] = $dateFrom;

        if(!$isAllBranch){
            $ids = Request_Request::find('DB_Ab1_Shop_Car',
                $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
                $elements
            );
        }else{
            $ids = Request_Request::findBranch('DB_Ab1_Shop_Car',
                array(), $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
                $elements
            );
        }
        foreach ($ids->childs as $child){
            $shopTurnPlaceID = $child->values['shop_turn_place_id'];
            if(!key_exists($shopTurnPlaceID, $listIDs->childs)){
                $child->additionDatas = $resultArray;
                $listIDs->childs[$shopTurnPlaceID] = $child;
            }

            $listIDs->childs[$shopTurnPlaceID]->additionDatas['quantity_month'] +=
                $child->values['quantity'] * $child->getElementValue('shop_product_id', 'volume', 1);
        }

        // задаем время выборки с предыдущего месяца
        $paramsPreviousMonth = $params;
        $tmp = Helpers_DateTime::getMonthBeginStr(date('m'), date('Y')).' 06:00:00';
        $paramsPreviousMonth['exit_at_to'] = $tmp;
        $paramsPreviousMonth['exit_at_from'] = Helpers_DateTime::minusMonth($tmp, 1, true);

        if(!$isAllBranch){
            $ids = Request_Request::find('DB_Ab1_Shop_Car',
                $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB, $paramsPreviousMonth, 0, TRUE,
                $elements
            );
        }else{
            $ids = Request_Request::findBranch('DB_Ab1_Shop_Car',
                array(), $this->_sitePageData, $this->_driverDB, $paramsPreviousMonth, 0, TRUE,
                $elements
            );
        }
        foreach ($ids->childs as $child){
            $shopTurnPlaceID = $child->values['shop_turn_place_id'];
            if(!key_exists($shopTurnPlaceID, $listIDs->childs)){
                $child->additionDatas = $resultArray;
                $listIDs->childs[$shopTurnPlaceID] = $child;
            }

            $listIDs->childs[$shopTurnPlaceID]->additionDatas['quantity_month_previous'] +=
                $child->values['quantity'] * $child->getElementValue('shop_product_id', 'volume', 1);
        }

        // задаем время выборки с начала года
        $dateFrom = Helpers_DateTime::getYearBeginStr(date('Y')).' 06:00:00';
        $params['exit_at_from'] = $dateFrom;

        if(!$isAllBranch){
            $ids = Request_Request::find('DB_Ab1_Shop_Car',
                $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
                $elements
            );
        }else{
            $ids = Request_Request::findBranch('DB_Ab1_Shop_Car',
                array(), $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
                $elements
            );
        }
        foreach ($ids->childs as $child){
            $shopTurnPlaceID = $child->values['shop_turn_place_id'];
            if(!key_exists($shopTurnPlaceID, $listIDs->childs)){
                $child->additionDatas = $resultArray;
                $listIDs->childs[$shopTurnPlaceID] = $child;
            }

            $listIDs->childs[$shopTurnPlaceID]->additionDatas['quantity_year'] +=
                $child->values['quantity'] * $child->getElementValue('shop_product_id', 'volume', 1);
        }

        // итог
        $total = array(
            'quantity_day' => 0,
            'quantity_yesterday' => 0,
            'quantity_week' => 0,
            'quantity_month' => 0,
            'quantity_month_previous' => 0,
            'quantity_year' => 0,
        );
        $totalVolume = array(
            'quantity_day' => 0,
            'quantity_yesterday' => 0,
            'quantity_week' => 0,
            'quantity_month' => 0,
            'quantity_month_previous' => 0,
            'quantity_year' => 0,
        );
        $isVolume = false;
        foreach ($listIDs->childs as $key => $child){
            $total['quantity_day'] += $child->additionDatas['quantity_day'];
            $total['quantity_yesterday'] += $child->additionDatas['quantity_yesterday'];
            $total['quantity_week'] += $child->additionDatas['quantity_week'];
            $total['quantity_month'] += $child->additionDatas['quantity_month'];
            $total['quantity_month_previous'] += $child->additionDatas['quantity_month_previous'];
            $total['quantity_year'] += $child->additionDatas['quantity_year'];

            $volume = $child->getElementValue('shop_product_id', 'volume', 1);
            $isVolume = $isVolume || $volume != 1;

            $totalVolume['quantity_day'] += $child->additionDatas['quantity_day'] / $volume;
            $totalVolume['quantity_yesterday'] += $child->additionDatas['quantity_yesterday'] / $volume;
            $totalVolume['quantity_week'] += $child->additionDatas['quantity_week'] / $volume;
            $totalVolume['quantity_month'] += $child->additionDatas['quantity_month'] / $volume;
            $totalVolume['quantity_month_previous'] += $child->additionDatas['quantity_month_previous'] / $volume;
            $totalVolume['quantity_year'] += $child->additionDatas['quantity_year'] / $volume;
        }
        $listIDs->additionDatas = $total;
        $listIDs->additionDatas['is_volume'] = $isVolume;
        $listIDs->additionDatas['volume'] = $totalVolume;

        $listIDs->childsSortBy(array('quantity_year', Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_product_id.name'), FALSE);
        $this->_sitePageData->countRecord = count($listIDs->childs);

        $this->_sitePageData->newShopShablonPath('ab1/_all');
        $this->_sitePageData->replaceDatas['view::_shop/turn/place/list/statistics'] = Helpers_View::getViewObjects(
            $listIDs, new Model_Ab1_Shop_Product_Rubric(),
            '_shop/turn/place/list/statistics','_shop/turn/place/one/statistics',
            $this->_sitePageData, $this->_driverDB
        );
        $this->_sitePageData->previousShopShablonPath();

        $this->_putInMain('/main/_shop/turn/place/statistics', 'ab1/_all');
    }

    protected function _actionASU() {
        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/car/list/asu',
            )
        );

        // основная продукция
        $this->_requestShopProducts(
            null, 0, NULL, FALSE,
            [
                Model_Ab1_ProductView::PRODUCT_TYPE_CAR,
                Model_Ab1_ProductView::PRODUCT_TYPE_CAR_AND_PIECE,
            ]
        );

        $this->_requestShopOperations(Model_Ab1_Shop_Operation::RUBRIC_WEIGHT);

        $params = Request_RequestParams::setParams(
            array(
                'is_exit' => 0,
                'group_by' => array('shop_turn_place_id', 'shop_turn_place_id.name'),
                'sum_quantity' => TRUE,
                'count_id' => TRUE,
                'sort_by' =>  Request_RequestParams::getParamArray('sort_by', [],
                array(
                    'count'=> 'asc',
                    'shop_turn_place_id.name'=> 'asc',
                    'quantity'=> 'asc',
                    'total'=> 'asc',
                )
            ),
                'shop_turn_id'=> array(Model_Ab1_Shop_Turn::TURN_WEIGHTED_EXIT, Model_Ab1_Shop_Turn::TURN_ASU)
            )
        );

        // реализация
        $carIDs = Request_Request::find('DB_Ab1_Shop_Car',
            $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB,
            $params, 0, TRUE, array('shop_turn_place_id' => array('name'))
        );

        // перемещение
        $moveCarIDs = Request_Request::find('DB_Ab1_Shop_Move_Car',
            $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB,
            $params, 0, TRUE, array('shop_turn_place_id' => array('name'))
        );
        foreach ($moveCarIDs->childs as $child){
            $tmp = $carIDs->findChildValue('shop_turn_place_id', $child->values['shop_turn_place_id']);
            if ($tmp === false){
                $carIDs->addChildObject($child);
            }else{
                $tmp->values['quantity'] += $child->values['quantity'];
                $tmp->values['count'] += $child->values['count'];
            }
        }

        // ответ. хранение
        $shopLesseeCarIDs = Request_Request::find('DB_Ab1_Shop_Lessee_Car',
            $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB,
            $params, 0, TRUE, array('shop_turn_place_id' => array('name'))
        );
        foreach ($shopLesseeCarIDs->childs as $child){
            $tmp = $carIDs->findChildValue('shop_turn_place_id', $child->values['shop_turn_place_id']);
            if ($tmp === false){
                $carIDs->addChildObject($child);
            }else{
                $tmp->values['quantity'] += $child->values['quantity'];
                $tmp->values['count'] += $child->values['count'];
            }
        }

        /**** Выполненно за день ****/
        $dateFrom = date('Y-m-d 06:00:00');
        if(time() < strtotime($dateFrom)){
            $dateTo = $dateFrom;
            $dateFrom = Helpers_DateTime::minusDays($dateFrom, 1);
        }else{
            $dateTo = date('Y-m-d H:i:s');
        }

        $params = Request_RequestParams::setParams(
            array(
                'exit_at_from' => $dateFrom,
                'exit_at_to' => $dateTo,
                'is_exit' => true,
                'group_by' => array('shop_turn_place_id', 'shop_turn_place_id.name'),
                'sum_quantity' => TRUE,
                'count_id' => TRUE,
                'sort_by' =>  Request_RequestParams::getParamArray('sort_by', [],
                array(
                    'count'=> 'asc',
                    'shop_turn_place_id.name'=> 'asc',
                    'quantity'=> 'asc',
                    'total'=> 'asc',
                )
            ),
            )
        );

        // реализация
        $listIDs = Request_Request::find('DB_Ab1_Shop_Car',
            $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB,
            $params, 0, TRUE, array('shop_turn_place_id' => array('name'))
        );

        // перемещение
        $moveCarIDs = Request_Request::find('DB_Ab1_Shop_Move_Car',
            $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB,
            $params, 0, TRUE, array('shop_turn_place_id' => array('name'))
        );
        $listIDs->addChilds($moveCarIDs);

        // ответ. хранение
        $shopLesseeCarIDs = Request_Request::find('DB_Ab1_Shop_Lessee_Car',
            $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB,
            $params, 0, TRUE, array('shop_turn_place_id' => array('name'))
        );
        $listIDs->addChilds($shopLesseeCarIDs);

        foreach ($listIDs->childs as $child){
            $tmp = $carIDs->findChildValue('shop_turn_place_id', $child->values['shop_turn_place_id']);
            if ($tmp === false){
                $carIDs->addChildObject($child);
                $child->additionDatas['total'] = $child->values['quantity'];
                $child->values['quantity'] = 0;
                $child->values['count'] = 0;
            }else{
                if(!key_exists('total', $tmp->additionDatas)){
                    $tmp->additionDatas['total'] = 0;
                }
                $tmp->additionDatas['total'] += $child->values['quantity'];
            }
        }

        // производство на склад
        $params = Request_RequestParams::setParams(
            array(
                'weighted_at_from' => $dateFrom,
                'weighted_at_to' => $dateTo,
                'group_by' => array('shop_turn_place_id', 'shop_turn_place_id.name'),
                'sum_quantity' => TRUE,
                'count_id' => TRUE,
                'sort_by' =>  Request_RequestParams::getParamArray('sort_by', [],
                array(
                    'count'=> 'asc',
                    'shop_turn_place_id.name'=> 'asc',
                    'quantity'=> 'asc',
                    'total'=> 'asc',
                )
            ),
            )
        );

        $listIDs = Request_Request::find('DB_Ab1_Shop_Product_Storage',
            $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB,
            $params, 0, TRUE, array('shop_turn_place_id' => array('name'))
        );

        foreach ($listIDs->childs as $child){
            $tmp = $carIDs->findChildValue('shop_turn_place_id', $child->values['shop_turn_place_id']);
            if ($tmp === false){
                $carIDs->addChildObject($child);
                $child->additionDatas['total'] = $child->values['quantity'];
                $child->values['quantity'] = 0;
                $child->values['count'] = 0;
            }else{
                if(!key_exists('total', $tmp->additionDatas)){
                    $tmp->additionDatas['total'] = 0;
                }
                $tmp->additionDatas['total'] += $child->values['quantity'];
            }
        }

        $quantity = 0;
        $count = 0;
        $totalAll = 0;
        foreach ($carIDs->childs as $child){
            $count += $child->values['count'];
            $quantity += $child->values['quantity'];
            $totalAll += Arr::path($child->additionDatas, 'total', 0);
        }
        $total = $carIDs->addChild(0);
        $total->values['count'] = $count;
        $total->values['quantity'] = $quantity;
        $total->additionDatas['total'] = $totalAll;
        $total->values['is_all'] = TRUE;
        $total->isFindDB = TRUE;
        $total->isLoadElements = TRUE;

        $listIDs->childsSortBy(
            Request_RequestParams::getParamArray('sort_by', [],
                array(
                    'count'=> 'asc',
                    'shop_turn_place_id.name'=> 'asc',
                    'quantity'=> 'asc',
                    'total'=> 'asc',
                )
            ), true, true);

        $this->_sitePageData->newShopShablonPath('ab1/_all');
        $result = Helpers_View::getViewObjects(
            $carIDs, new Model_Ab1_Shop_Car(), "_shop/car/list/asu", "_shop/car/one/asu",
            $this->_sitePageData, $this->_driverDB, $this->_sitePageData->shopID,
            TRUE, array('shop_turn_place_id' => array('name'))
        );
        $this->_sitePageData->previousShopShablonPath();

        $this->_sitePageData->replaceDatas['view::_shop/car/list/asu'] = $result;

        $this->_putInMain('/main/_shop/car/asu');
    }

    protected function _actionASUCars() {
        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/car/list/asu-cars',
            )
        );
        $this->_requestShopBranches($this->_sitePageData->shopID, TRUE);

        $shopTurnPlaceID = Request_RequestParams::getParamInt('shop_turn_place_id');
        $this->_requestShopTurnPlaces($shopTurnPlaceID);

        $params = Request_RequestParams::setParams(
            array(
                'is_exit' => 0,
                'shop_turn_place_id' => $shopTurnPlaceID,
                'sort_by' => array('name' => 'asc'),
                'shop_turn_id'=> array(Model_Ab1_Shop_Turn::TURN_WEIGHTED_EXIT, Model_Ab1_Shop_Turn::TURN_ASU)
            )
        );
        // реализация
        $carIDs = Request_Request::find('DB_Ab1_Shop_Car',
            $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
            array('shop_product_id' => array('name'), 'shop_client_id' => array('name'))
        );

        // перемещение
        $moveCarIDs = Request_Request::find('DB_Ab1_Shop_Move_Car',
            $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
            array('shop_product_id' => array('name'), 'shop_client_id' => array('name'))
        );
        $carIDs->addChilds($moveCarIDs);

        // ответ.хранения
        $lesseeCarIDs = Request_Request::find('DB_Ab1_Shop_Lessee_Car',
            $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
            array('shop_product_id' => array('name'), 'shop_client_id' => array('name'))
        );
        $carIDs->addChilds($lesseeCarIDs);

        $quantity = 0;
        foreach ($carIDs->childs as $child){
            $quantity = $quantity + $child->values['quantity'];
        }
        $total = $carIDs->addChild(0);
        $total->values['count'] = count($carIDs->childs);
        $total->values['quantity'] = $quantity;
        $total->values['is_all'] = TRUE;
        $total->isFindDB = TRUE;
        $total->isLoadElements = TRUE;

        $this->_sitePageData->newShopShablonPath('ab1/_all');
        $result = Helpers_View::getViewObjects(
            $carIDs, new Model_Ab1_Shop_Car(), "_shop/car/list/asu-cars", "_shop/car/one/asu-cars",
            $this->_sitePageData, $this->_driverDB, $this->_sitePageData->shopID
        );
        $this->_sitePageData->previousShopShablonPath();
        $this->_sitePageData->replaceDatas['view::_shop/car/list/asu-cars'] = $result;

        $this->_putInMain('/main/_shop/car/asu-cars');
    }

}