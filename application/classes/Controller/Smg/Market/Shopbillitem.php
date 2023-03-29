<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Smg_Market_ShopBillItem extends Controller_Smg_Market_Basic {

    public function __construct(Request $request, Response $response)
    {
        $this->dbObject = 'DB_AutoPart_Shop_Bill_Item';
        $this->controllerName = 'shopbillitem';
        $this->tableID = Model_AutoPart_Shop_Bill_Item::TABLE_ID;
        $this->tableName = Model_AutoPart_Shop_Bill_Item::TABLE_NAME;

        parent::__construct($request, $response);
    }

    public function action_stock() {
        $this->_sitePageData->url = '/market/shopbillitem/stock';

        $this->_requestListDB('DB_AutoPart_Shop_Source');
        $this->_requestListDB('DB_AutoPart_Shop_Supplier');
        $this->_requestListDB('DB_AutoPart_Shop_Company');
        $this->_requestListDB('DB_AutoPart_Shop_Courier');

        $shopCourierID = $this->_sitePageData->operation->getShopCourierID();
        if($shopCourierID < 1){
            $shopCourierID = -1;
        }

        $paramsBasic = [
            'shop_bill_id.shop_bill_status_source_id_not' => [Model_AutoPart_Shop_Bill_Status_Source::STATUS_COMPLETED],
            'is_buy' => true,
            'shop_courier_id' => $shopCourierID,
        ];

        $params = array_merge(
            $_GET,
            $_POST,
            [
                'sum_profit' => true,
                'sum_quantity' => true,
                'sum_amount' => true,
                'sum_delivery_amount' => true,
                'sum_amount_cost' => true,
                'page' => null,
            ],
            $paramsBasic
        );

        $paramsTotal = $params;
        $paramsTotal['price_cost_not'] = 0;
        unset($paramsTotal['sort_by']);
        $ids = Request_Request::find(
            DB_AutoPart_Shop_Bill_Item::NAME, $this->_sitePageData->shopID,
            $this->_sitePageData, $this->_driverDB, Request_RequestParams::setParams($paramsTotal)
        );
        $result = Helpers_View::getView(
            '_shop/bill/item/one/stock-total', $this->_sitePageData, $this->_driverDB, $ids->childs[0]
        );
        $this->_sitePageData->addReplaceAndGlobalDatas('view::_shop/bill/item/one/stock-total', $result);

        parent::_actionIndex(
            array(
                'shop_product_id' => array(
                    'name', 'shop_supplier_id', 'url', 'options', 'article',
                ),
                'shop_supplier_id' => array('name'),
                'shop_bill_id' => array('old_id', 'approve_source_at', 'delivery_at', 'delivery_plan_at'),
                'shop_source_id' => array('name'),
                'shop_company_id' => array('name'),
                'shop_courier_id' => array('name'),
                'new_shop_courier_id' => array('name'),
            ),
            $paramsBasic,
            -1, 'stock'
        );
    }

    public function action_stock_courier() {
        $this->_sitePageData->url = '/market/shopbillitem/stock_courier';

        $this->_requestListDB('DB_AutoPart_Shop_Supplier');

        $shopCourierID = $this->_sitePageData->operation->getShopCourierID();
        if($shopCourierID < 1){
            $shopCourierID = -1;
            $this->_requestListDB('DB_AutoPart_Shop_Courier');
        }

        $paramsBasic = [
            'shop_bill_id.shop_bill_status_source_id_not' => [Model_AutoPart_Shop_Bill_Status_Source::STATUS_COMPLETED],
            'is_buy' => true,
            'shop_courier_id' => $shopCourierID,
        ];

        parent::_actionIndex(
            array(
                'shop_product_id' => array(
                    'name', 'shop_supplier_id', 'url', 'options', 'article',
                ),
                'shop_supplier_id' => array('name'),
                'shop_bill_id' => array('old_id', 'approve_source_at', 'delivery_at', 'delivery_plan_at'),
                'shop_source_id' => array('name'),
                'shop_company_id' => array('name'),
                'shop_courier_id' => array('name'),
                'new_shop_courier_id' => array('name'),
            ),
            $paramsBasic,
            -1, 'stock-courier'
        );
    }

    public function action_stock_transfer() {
        $this->_sitePageData->url = '/market/shopbillitem/stock_transfer';

        $this->_requestListDB('DB_AutoPart_Shop_Supplier');

        $shopCourierID = $this->_sitePageData->operation->getShopCourierID();
        if($shopCourierID < 1){
            $shopCourierID = -1;
            $this->_requestListDB('DB_AutoPart_Shop_Courier');
        }

        $paramsBasic = [
            'shop_bill_id.shop_bill_status_source_id_not' => [Model_AutoPart_Shop_Bill_Status_Source::STATUS_COMPLETED],
            'is_buy' => true,
            'new_shop_courier_id' => $shopCourierID,
        ];

        parent::_actionIndex(
            array(
                'shop_product_id' => array(
                    'name', 'shop_supplier_id', 'url', 'options', 'article',
                ),
                'shop_supplier_id' => array('name'),
                'shop_bill_id' => array('old_id', 'approve_source_at', 'delivery_at', 'delivery_plan_at'),
                'shop_source_id' => array('name'),
                'shop_company_id' => array('name'),
                'shop_courier_id' => array('name'),
                'new_shop_courier_id' => array('name'),
            ),
            $paramsBasic,
            -1, 'stock-transfer'
        );
    }

    public function action_accept_transfer()
    {
        $this->_sitePageData->url = '/market/shopbillitem/accept_transfer';

        // id записи
        $id = Request_RequestParams::getParamInt('id');
        $model = new Model_AutoPart_Shop_Bill_Item();
        if (! $this->dublicateObjectLanguage($model, $id, $this->_sitePageData->shopID, false)) {
            throw new HTTP_Exception_404('Object "' . $this->dbObject . '" not is found!');
        }

        $model->setShopCourierID($model->getNewShopCourierID());
        $model->setNewShopCourierID(0);
        Helpers_DB::saveDBObject($model, $this->_sitePageData);

        $this->response->body(json_encode('ok'));
    }

    public function action_sold() {
        $this->_sitePageData->url = '/market/shopbillitem/sold';

        $this->_requestListDB('DB_AutoPart_Shop_Bill_Delivery_Type');
        $this->_requestListDB('DB_AutoPart_Shop_Bill_PaymentType');
        $this->_requestListDB('DB_AutoPart_Shop_Source');
        $this->_requestListDB('DB_AutoPart_Shop_Supplier');
        $this->_requestListDB('DB_AutoPart_Shop_Company');

        $status = Request_RequestParams::getParamInt('shop_bill_status_source_id');
        if($status < 1){
            $status = [
                Model_AutoPart_Shop_Bill_Status_Source::STATUS_COMPLETED,
            ];
        }

        $paramsBasic = [
            'shop_bill_id.shop_bill_status_source_id' => $status,
        ];

        $isReceive = Request_RequestParams::getParamBoolean('is_receive');
        if($isReceive === true){
            $paramsBasic['shop_receive_id_from'] = 0;
        }elseif($isReceive === false){
            $paramsBasic['shop_receive_id'] = 0;
        }

        $params = array_merge(
            $_GET,
            $_POST,
            [
                'sum_profit' => true,
                'sum_quantity' => true,
                'sum_amount' => true,
                'sum_delivery_amount' => true,
                'sum_amount_cost' => true,
                'page' => null,
            ],
            $paramsBasic
        );

        $paramsTotal = $params;
        $paramsTotal['price_cost_not'] = 0;
        unset($paramsTotal['sort_by']);
        $ids = Request_Request::find(
            DB_AutoPart_Shop_Bill_Item::NAME, $this->_sitePageData->shopID,
            $this->_sitePageData, $this->_driverDB, Request_RequestParams::setParams($paramsTotal)
        );
        $result = Helpers_View::getView(
            '_shop/bill/item/one/sold-total', $this->_sitePageData, $this->_driverDB, $ids->childs[0]
        );
        $this->_sitePageData->addReplaceAndGlobalDatas('view::_shop/bill/item/one/sold-total', $result);

        parent::_actionIndex(
            array(
                'shop_product_id' => array(
                    'name', 'shop_supplier_id', 'url', 'options', 'article',
                ),
                'shop_supplier_id' => array('name'),
                'shop_bill_id' => array('old_id', 'approve_source_at', 'delivery_at', 'delivery_plan_at'),
                'shop_source_id' => array('name'),
                'shop_company_id' => array('name'),
                'shop_receive_id' => array('number', 'date'),
            ),
            $paramsBasic, -1, 'sold'
        );
    }

    public function action_bill() {
        $this->_sitePageData->url = '/market/shopbillitem/bill';

        $this->_requestListDB('DB_AutoPart_Shop_Bill_Delivery_Type');
        $this->_requestListDB('DB_AutoPart_Shop_Bill_PaymentType');
        $this->_requestListDB('DB_AutoPart_Shop_Source');
        $this->_requestListDB('DB_AutoPart_Shop_Supplier');
        $this->_requestListDB('DB_AutoPart_Shop_Company');

        parent::_actionIndex(
            array(
                'shop_product_id' => array(
                    'name', 'price_cost', 'shop_supplier_id', 'stock_quantity', 'is_on_order', 'stock_compare_type_id', 'is_in_stock',
                    'url', 'root_shop_product_id', 'child_product_count', 'options', 'article', 'is_public', 'integrations',
                    'shop_supplier_id',
                ),
                'shop_supplier_id' => array('name')
            ),
            ['shop_bill_id.shop_bill_state_source_id' => [1478255, 1478254, 1478252],], -1, 'bill'
        );
    }

    public function action_completed() {
        $this->_sitePageData->url = '/market/shopbillitem/completed';

        $this->_requestListDB('DB_AutoPart_Shop_Bill_Delivery_Type');
        $this->_requestListDB('DB_AutoPart_Shop_Bill_PaymentType');
        $this->_requestListDB('DB_AutoPart_Shop_Source');
        $this->_requestListDB('DB_AutoPart_Shop_Supplier');
        $this->_requestListDB('DB_AutoPart_Shop_Company');

        parent::_actionIndex(
            array(
                'shop_product_id' => array(
                    'name', 'price_cost', 'shop_supplier_id', 'url', 'options', 'article', 'is_public',
                ),
                'shop_product_id.shop_supplier_id' => array('name'),
                'shop_bill_id' => array('old_id', 'approve_source_at', 'delivery_at', 'delivery_plan_at'),
                'shop_source_id' => array('name'),
                'shop_company_id' => array('name'),
            ),
            ['shop_bill_id.shop_bill_state_source_id' => [1478255, 1478254, 1478252],], -1, 'completed'
        );
    }

    public function action_income() {
        $this->_sitePageData->url = '/market/shopbillitem/income';

        $this->_requestListDB('DB_AutoPart_Shop_Bill_Delivery_Type');
        $this->_requestListDB('DB_AutoPart_Shop_Bill_PaymentType');
        $this->_requestListDB('DB_AutoPart_Shop_Source');
        $this->_requestListDB('DB_AutoPart_Shop_Supplier');
        $this->_requestListDB('DB_AutoPart_Shop_Company');

        $status = Request_RequestParams::getParamInt('shop_bill_status_source_id');
        if($status < 1){
            $status = Model_AutoPart_Shop_Bill_Status_Source::STATUS_COMPLETED;
        }

        $paramsBasic = [
            'shop_bill_id.shop_bill_status_source_id' => [$status],
        ];

        $isNotReceive = Request_RequestParams::getParamBoolean('is_not_receive');
        if($isNotReceive === true){
            $paramsBasic['shop_receive_id'] = 0;
        }elseif($isNotReceive === false){
            $paramsBasic['shop_receive_id_from'] = 0;
        }

        $params = array_merge(
            $_GET,
            $_POST,
            [
                'sum_profit' => true,
                'sum_quantity' => true,
                'sum_amount' => true,
                'sum_delivery_amount' => true,
                'sum_amount_cost' => true,
                'page' => null,
            ],
            $paramsBasic
        );

        $paramsTotal = $params;
        $paramsTotal['price_cost_not'] = 0;
        unset($paramsTotal['sort_by']);
        $ids = Request_Request::find(
            DB_AutoPart_Shop_Bill_Item::NAME, $this->_sitePageData->shopID,
            $this->_sitePageData, $this->_driverDB, Request_RequestParams::setParams($paramsTotal)
        );
        $result = Helpers_View::getView(
            '_shop/bill/item/one/income-total', $this->_sitePageData, $this->_driverDB, $ids->childs[0]
        );
        $this->_sitePageData->addReplaceAndGlobalDatas('view::_shop/bill/item/one/income-total', $result);

        parent::_actionIndex(
            array(
                'shop_product_id' => array(
                    'name', 'shop_supplier_id', 'url', 'options', 'article',
                ),
                'shop_supplier_id' => array('name'),
                'shop_bill_id' => array('old_id', 'approve_source_at', 'delivery_at', 'delivery_plan_at'),
                'shop_source_id' => array('name'),
                'shop_company_id' => array('name'),
            ),
            $paramsBasic,
            -1, 'income'
        );
    }

    public function action_to_book() {
        $this->_sitePageData->url = '/market/shopbillitem/to_book';

        $this->_requestListDB('DB_AutoPart_Shop_Bill_Delivery_Type');
        $this->_requestListDB('DB_AutoPart_Shop_Bill_PaymentType');
        $this->_requestListDB('DB_AutoPart_Shop_Source');

        parent::_actionIndex(
            array(
                'shop_product_id' => array(
                    'name', 'url', 'root_shop_product_id', 'child_product_count', 'options', 'article',
                ),
                'shop_supplier_id' => array('name')
            ),
            [], -1, 'to-book'
        );
    }

    public function action_need_buy() {
        $this->_sitePageData->url = '/market/shopbillitem/need_buy';

        $this->_requestListDB('DB_AutoPart_Shop_Source');
        $this->_requestListDB('DB_AutoPart_Shop_Company');
        $this->_requestListDB('DB_AutoPart_Shop_Bill_Item_Status');
        $this->_requestListDB('DB_AutoPart_Shop_Supplier');
        $this->_requestListDB('DB_AutoPart_Shop_Courier');
        $this->_requestListDB(
            'DB_AutoPart_Shop_Supplier_Address', NULL, 0,
            Request_RequestParams::setParams(['sort_by' => ['shop_supplier_id.name' => 'asc', 'name' => 'asc']]),
            ['shop_supplier_id' => ['name']]
        );

        $shopBillItemStatusID = Request_RequestParams::getParamInt('shop_bill_item_status_id');
        if($shopBillItemStatusID === null){
            $shopBillItemStatusID = [0, Model_AutoPart_Shop_Bill_Item_Status::STATUS_NEW];
        }
        $shopBillItemStatusIDs = Request_RequestParams::getParamArray('shop_bill_item_status_ids');
        if(is_array($shopBillItemStatusIDs)){
            $shopBillItemStatusID = $shopBillItemStatusIDs;
        }

        $ids = Request_Request::find(
            DB_AutoPart_Shop_Bill_Item::NAME, $this->_sitePageData->shopID,
            $this->_sitePageData, $this->_driverDB,
            Request_RequestParams::setParams(
                [
                    'shop_bill_item_status_id' => $shopBillItemStatusID,
                    'shop_bill_id.shop_bill_state_source_id' => [1478255, 1478254, 1478252],
                    'shop_source_id' => Request_RequestParams::getParamInt('shop_source_id'),
                    'shop_company_id' => Request_RequestParams::getParamInt('shop_company_id'),
                    'shop_bill_id.shop_courier_id' => Request_RequestParams::getParam('shop_courier_id'),
                    'shop_bill_id.shop_courier_id_not' => Request_RequestParams::getParamInt('shop_courier_id_not'),
                    'sort_by' => Request_RequestParams::getParamArray('sort_by'),
                ]
            ),
            0, true,
            array(
                'shop_product_id' => array(
                    'name', 'price_cost', 'shop_supplier_id', 'stock_quantity', 'is_on_order', 'stock_compare_type_id', 'is_in_stock',
                    'url', 'root_shop_product_id', 'child_product_count', 'options', 'article', 'is_public', 'integrations',
                    'shop_supplier_id',
                ),
                'shop_product_id.shop_supplier_id' => array('name'),
                'shop_source_id' => array('name'),
                'shop_bill_id' => array(
                    'old_id', 'approve_source_at', 'delivery_plan_at', 'delivery_at', 'buyer', 'delivery_address',
                    'shop_courier_id', 'shop_other_address_id', 'quantity'
                ),
                'shop_bill_id.shop_bill_buyer_id' => array('phone'),
                'shop_company_id' => array('name'),
                'shop_bill_id.shop_courier_id' => array('name'),
                'shop_bill_item_status_id' => array('name'),
                'shop_receive_id' => array('number'),
                'shop_bill_id.shop_other_address_id' => array('name'),
            )
        );

        // группируем по товарам
        $list = new MyArray();
        foreach ($ids->childs as $child){
            $product = $child->values['shop_product_id'] . '_' . $child->values['shop_source_id'] . '_' . $child->values['name'];
            if(!key_exists($product, $list->childs)){
                $new = new MyArray();
                $new->cloneObj($child);
                $new->additionDatas['childs'] = [$child];

                $list->childs[$product] = $new;
                continue;
            }

            $list->childs[$product]->additionDatas['childs'][] = $child;
            $list->childs[$product]->values['quantity'] += $child->values['quantity'];
            $list->childs[$product]->values['amount'] += $child->values['amount'];
        }

        if(Func::_empty(Request_RequestParams::getParamArray('sort_by'))){
            $list->childsSortBy(['shop_supplier_id.name' => 'asc', 'shop_product_id.name' => 'asc'], true, true);
        }

        $data = new MyArray();
        $data->additionDatas = $list->calcTotalsChild(['quantity', 'amount']);

        // находим список детворы ввиде замен
        foreach ($list->childs as $child){
            $data->childs[] = $child;

            $supplierIDs[$child->values['shop_supplier_id']] = $child->values['shop_supplier_id'];
            $child->additionDatas['supplier_list'] = [];

            if($child->getElementValue('shop_product_id', 'child_product_count', 0) < 1){
                $child->additionDatas['suppliers'] = new MyArray();
                continue;
            }

            $product = $child->values['shop_product_id'];
            $ids = Request_Request::find(
                DB_AutoPart_Shop_Product::NAME, $this->_sitePageData->shopID,
                $this->_sitePageData, $this->_driverDB,
                Request_RequestParams::setParams(
                    [
                        'root_shop_product_id' => $product,
                        'is_public_ignore' => true,
                    ]
                ),
                0, true,
                array(
                    'shop_supplier_id' => array('name')
                )
            );

            $child->additionDatas['suppliers'] = $ids;

            foreach ($ids->childs as $item){
                $supplier = $item->getElementValue('shop_supplier_id');
                $child->additionDatas['supplier_list'][$supplier] = $supplier;
            }
        }

        $shopSupplierID = Request_RequestParams::getParamInt('shop_supplier_id');
        if($shopSupplierID > -1){
            foreach ($data->childs as $key => $child){
                if($child->getElementValue('shop_product_id', 'shop_supplier_id', 0) != $shopSupplierID){
                    unset($data->childs[$key]);
                }
            }
        }

        $result = Helpers_View::getViews(
            '_shop/bill/item/list/need-buy', '_shop/bill/item/one/need-buy',
            $this->_sitePageData, $this->_driverDB, $data
        );
        $this->_sitePageData->addReplaceAndGlobalDatas('view::_shop/bill/item/list/need-buy', $result);

        $this->_putInMain('/main/_shop/bill/item/need-buy');
    }

    public function action_supplier() {
        $this->_sitePageData->url = '/market/shopbillitem/supplier';

        $shopBillItemStatusID = Request_RequestParams::getParamInt('shop_bill_item_status_id');
        if($shopBillItemStatusID === null){
            $shopBillItemStatusID = [0, Model_AutoPart_Shop_Bill_Item_Status::STATUS_NEW];
        }
        $shopBillItemStatusIDs = Request_RequestParams::getParamArray('shop_bill_item_status_ids');
        if(is_array($shopBillItemStatusIDs)){
            $shopBillItemStatusID = $shopBillItemStatusIDs;
        }

        $ids = Request_Request::find(
            DB_AutoPart_Shop_Bill_Item::NAME, $this->_sitePageData->shopID,
            $this->_sitePageData, $this->_driverDB,
            Request_RequestParams::setParams(
                [
                    'shop_bill_item_status_id' => $shopBillItemStatusID,
                    'shop_bill_id.shop_bill_state_source_id' => [1478255, 1478254, 1478252],
                    'shop_source_id' => Request_RequestParams::getParamInt('shop_source_id'),
                    'shop_company_id' => Request_RequestParams::getParamInt('shop_company_id'),
                    'sort_by' => Request_RequestParams::getParamArray('sort_by'),
                ]
            ),
            0, true,
            array(
                'shop_product_id' => array(
                    'name', 'price_cost', 'shop_supplier_id', 'stock_quantity', 'is_on_order', 'stock_compare_type_id', 'is_in_stock',
                    'url', 'root_shop_product_id', 'child_product_count', 'options', 'article', 'is_public', 'integrations',
                    'shop_supplier_id',
                ),
                'shop_product_id.shop_supplier_id' => array('name'),
                'shop_source_id' => array('name'),
                'shop_bill_id' => array('old_id', 'approve_source_at', 'delivery_plan_at', 'delivery_at', 'buyer', 'delivery_address'),
                'shop_bill_id.shop_bill_buyer_id' => array('phone'),
                'shop_company_id' => array('name'),
            )
        );

        // группируем по товарам
        $list = new MyArray();
        $products = [];
        foreach ($ids->childs as $child){
            $supplier = $child->getElementValue('shop_product_id', 'shop_supplier_id');
            if(!key_exists($supplier, $list->childs)){
                $child->additionDatas['childs'] = [];
                $list->childs[$supplier] = $child;
            }

            $product = $child->values['shop_product_id'];
            if(!key_exists($product, $list->childs[$supplier]->childs)){
                $list->childs[$supplier]->additionDatas['childs'][$product] = [
                    'name' => $child->getElementValue('shop_product_id'),
                    'integrations' => $child->getElementValue('shop_product_id', 'integrations'),
                    'quantity' => 0,
                ];
            }

            $list->childs[$supplier]->additionDatas['childs'][$product]['quantity'] += $child->values['quantity'];

            if($child->getElementValue('shop_product_id', 'child_product_count', 0) > 0){
                if(!key_exists($product, $products)){
                    $products[$product] = $child;
                    continue;
                }

                $products[$product]->values['quantity'] += $child->values['quantity'];
            }
        }

        $list->childsSortBy(['shop_supplier_id.name' => 'asc'], true, true);

        // находим список детворы ввиде замен
        foreach ($products as $product => $child){
            $ids = Request_Request::find(
                DB_AutoPart_Shop_Product::NAME, $this->_sitePageData->shopID,
                $this->_sitePageData, $this->_driverDB,
                Request_RequestParams::setParams(
                    [
                        'root_shop_product_id' => $product,
                        'is_public_ignore' => true,
                    ]
                ),
                0, true,
                array(
                    'shop_supplier_id' => array('name')
                )
            );

            foreach ($ids->childs as $item){
                $supplier = $item->values['shop_supplier_id'];
                if(!key_exists($supplier, $list->childs)){
                    $item->additionDatas['childs'] = [];
                    $list->childs[$supplier] = $item;
                }

                $product = $item->values['id'];
                if(!key_exists($product, $list->childs[$supplier]->childs)){
                    $list->childs[$supplier]->additionDatas['childs'][$product] = [
                        'name' => $item->values['name'],
                        'integrations' => $item->values['integrations'],
                        'quantity' => $child->values['quantity'],
                    ];
                }
            }
        }

        $result = Helpers_View::getViews(
            '_shop/bill/item/list/supplier', '_shop/bill/item/one/supplier',
            $this->_sitePageData, $this->_driverDB, $list
        );
        $this->_sitePageData->addReplaceAndGlobalDatas('view::_shop/bill/item/list/supplier', $result);

        $this->_putInMain('/main/_shop/bill/item/supplier', false);
    }

    public function action_set_status(){
        $this->_sitePageData->url = '/market/shopbillitem/set_status';

        $shopProductID = Request_RequestParams::getParamInt('shop_product_id');
        if($shopProductID < 1){
            throw new HTTP_Exception_500('Product not empty.');
        }

        $quantity = Request_RequestParams::getParamInt('quantity');
        if($quantity <= 0){
            $quantity = 1000000;
        }

        $shopBillItemID = Request_RequestParams::getParamInt('shop_bill_item_id');
        if($shopBillItemID > 0) {
            $params = [
                'id' => $shopBillItemID,
                'sort_by' => ['quantity' => 'desc']
            ];
        }else{
            $params = [
                'name_full' => Request_RequestParams::getParamStr('name'),
                'shop_product_id' => $shopProductID,
                'shop_bill_item_status_id_not' => Request_RequestParams::getParamInt('shop_bill_item_status_id'),
                'shop_bill_item_status_id' => Request_RequestParams::getParamInt('current_shop_bill_item_status_id'),
                'id' => Request_RequestParams::getParamInt('shop_bill_item_id'),
                'sort_by' => ['quantity' => 'desc']
            ];
        }

        $ids = Request_Request::find(
            DB_AutoPart_Shop_Bill_Item::NAME, $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB,
            Request_RequestParams::setParams($params), 0, true
        );

        $modelItem = new Model_AutoPart_Shop_Bill_Item();
        $modelItem->setDBDriver($this->_driverDB);

        $shopSupplierID = Request_RequestParams::getParamInt('shop_supplier_id');
        $shopBillItemStatusID = Request_RequestParams::getParamInt('shop_bill_item_status_id');

        foreach ($ids->childs as $child) {
            $child->setModel($modelItem);

            if($quantity < $modelItem->getQuantity()){
                continue;
            }

            $quantity -= $modelItem->getQuantity();

            $modelItem->setShopSupplierID($shopSupplierID);
            $modelItem->setShopBillItemStatusID($shopBillItemStatusID);

            Helpers_DB::saveDBObject($modelItem, $this->_sitePageData);
        }

        $this->response->body('ok');
    }

    public function action_set_pre_order(){
        $this->_sitePageData->url = '/market/shopbillitem/set_pre_order';

        $shopBillItemID = Request_RequestParams::getParamInt('shop_bill_item_id');

        $modelItem = new Model_AutoPart_Shop_Bill_Item();
        $modelItem->setDBDriver($this->_driverDB);
        if(!Helpers_DB::getDBObject($modelItem, $shopBillItemID, $this->_sitePageData)){
            throw new HTTP_Exception_500('Bill item not found.');
        }

        $shopSupplierAddressID = Request_RequestParams::getParamInt('shop_supplier_address_id');

        $modelAddress = new Model_AutoPart_Shop_Supplier_Address();
        $modelAddress->setDBDriver($this->_driverDB);
        if(!Helpers_DB::getDBObject($modelAddress, $shopSupplierAddressID, $this->_sitePageData)){
            throw new HTTP_Exception_500('Supplier address not found.');
        }

        $shopCourierID = Request_RequestParams::getParamInt('shop_courier_id');

        $commissionSupplier = Request_RequestParams::getParamFloat('commission_supplier');
        $priceCost = Request_RequestParams::getParamFloat('price_cost');

        $date = Request_RequestParams::getParamDate('date');
        if(empty($date)){
            $date = date('Y-m-d');
        }

        /** @var Model_AutoPart_Shop_PreOrder $modelPreOrder */
        $modelPreOrder = Request_Request::findOneModel(
            DB_AutoPart_Shop_PreOrder::NAME, $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB,
            Request_RequestParams::setParams(
                [
                    'date' => $date,
                    'is_buy' => false,
                    'shop_courier_id' => $shopCourierID,
                    'shop_supplier_address_id' => $shopSupplierAddressID,
                    'shop_supplier_id' => $modelAddress->getShopSupplierID(),
                ]
            )
        );

        if(!$modelPreOrder){
            $modelPreOrder = new Model_AutoPart_Shop_PreOrder();
            $modelPreOrder->setDBDriver($this->_driverDB);

            $modelPreOrder->setShopCourierID($shopCourierID);
            $modelPreOrder->setShopSupplierID($modelAddress->getShopSupplierID());
            $modelPreOrder->setShopSupplierAddressID($shopSupplierAddressID);
            $modelPreOrder->setDate($date);
            $modelPreOrder->setNumber($this->_driverDB->nextSequence('ab_shop_pre_order_number'));
            Helpers_DB::saveDBObject($modelPreOrder, $this->_sitePageData);

            // добавляем новую точку в маршрут
            Api_AutoPart_Shop_Courier_Route::addPreOrder($modelPreOrder, $this->_sitePageData, $this->_driverDB);
        }

        $modelItem->setPriceCost($priceCost);
        $modelItem->setCommissionSupplier($commissionSupplier);
        $modelItem->setShopCourierID($modelPreOrder->getShopCourierID());
        $modelItem->setShopPreOrderID($modelPreOrder->id);
        Helpers_DB::saveDBObject($modelItem, $this->_sitePageData);

        $total = Api_AutoPart_Shop_PreOrder::calcTotal($modelPreOrder->id, $this->_sitePageData, $this->_driverDB);
        $modelPreOrder->setQuantity($total['quantity']);
        $modelPreOrder->setAmount($total['amount']);
        Helpers_DB::saveDBObject($modelPreOrder, $this->_sitePageData);

        $this->response->body(Json::json_encode($modelPreOrder->getValues(true, true)));
    }

    public function action_set_comment(){
        $this->_sitePageData->url = '/market/shopbillitem/set_comment';

        $shopBillItemID = Request_RequestParams::getParamInt('shop_bill_item_id');

        $modelItem = new Model_AutoPart_Shop_Bill_Item();
        $modelItem->setDBDriver($this->_driverDB);
        if(!Helpers_DB::getDBObject($modelItem, $shopBillItemID, $this->_sitePageData)){
            throw new HTTP_Exception_500('Bill item not found.');
        }

        $text = Request_RequestParams::getParamStr('text');
        $modelItem->setText($text);
        Helpers_DB::saveDBObject($modelItem, $this->_sitePageData);

        $this->response->body('ok');
    }

    public function action_yandex_map() {
        $this->_sitePageData->url = '/market/shopbillitem/yandex_map';

        $shopBillItemStatusID = Request_RequestParams::getParamInt('shop_bill_item_status_id');
        if($shopBillItemStatusID === null){
            $shopBillItemStatusID = [0, Model_AutoPart_Shop_Bill_Item_Status::STATUS_NEW];
        }
        $shopBillItemStatusIDs = Request_RequestParams::getParamArray('shop_bill_item_status_ids');
        if(is_array($shopBillItemStatusIDs)){
            $shopBillItemStatusID = $shopBillItemStatusIDs;
        }

        $ids = Request_Request::find(
            DB_AutoPart_Shop_Bill_Item::NAME, $this->_sitePageData->shopID,
            $this->_sitePageData, $this->_driverDB,
            Request_RequestParams::setParams(
                [
                    'shop_bill_item_status_id' => $shopBillItemStatusID,
                    'shop_bill_id.shop_bill_state_source_id' => [1478255, 1478254, 1478252],
                    'shop_source_id' => Request_RequestParams::getParamInt('shop_source_id'),
                    'shop_company_id' => Request_RequestParams::getParamInt('shop_company_id'),
                    'shop_bill_id.shop_courier_id' => Request_RequestParams::getParam('shop_courier_id'),
                    'shop_bill_id.shop_courier_id_not' => Request_RequestParams::getParamInt('shop_courier_id_not'),
                    'sort_by' => ['shop_supplier_id.name' => 'asc'],
                ]
            ),
            0, true,
            array(
                'shop_bill_id.shop_bill_delivery_address_id' => array('latitude', 'longitude', 'id', 'name'),
                'shop_supplier_address_id' => array('latitude', 'longitude', 'id', 'name'),
                'shop_supplier_id' => array('name'),
                'shop_product_id' => array('name'),
                'shop_bill_item_status_id' => array('name'),
                'shop_bill_id.shop_other_address_id' => array('latitude', 'longitude', 'id', 'name'),
            )
        );

        // группируем по товарам
        $result = '';
        foreach ($ids->childs as $child){
            if ($child->values['shop_bill_item_status_id'] == Model_AutoPart_Shop_Bill_Item_Status::STATUS_TO_BOOK + 1000) {
                $name = 'shop_supplier_address_id';
            }elseif ($child->getElementValue('shop_other_address_id', 'id') > 0) {
                $name = 'shop_other_address_id';
            }else{
                $name = 'shop_bill_delivery_address_id';
            }

            $latitude = $child->getElementValue($name, 'latitude');
            $longitude = $child->getElementValue($name, 'longitude');

            if($latitude != 0 && $longitude != 0) {
                $result .= '~' . $latitude . '%2C' . $longitude;
            }
        }
        $this->_sitePageData->addReplaceAndGlobalDatas('view::yandex_map', $result);

        $result = Helpers_View::getViews(
            '_shop/bill/item/list/yandex-map', '_shop/bill/item/one/yandex-map',
            $this->_sitePageData, $this->_driverDB, $ids
        );
        $this->_sitePageData->addReplaceAndGlobalDatas('view::_shop/bill/item/list/yandex-map', $result);

        $this->_putInMain('/main/_shop/bill/item/yandex-map', false);
    }

    public function action_set_yandex_map_courier (){
        $this->_sitePageData->url = '/market/shopbillitem/set_yandex_map_courier ';

        $shopCourierID = Request_RequestParams::getParamInt('shop_courier_id');

        $url = Request_RequestParams::getParamStr('url');
        if(empty($url)){
            throw new HTTP_Exception_500('URL not found.');
        }

        $model = new Model_AutoPart_Shop_Bill();
        $model->setDBDriver($this->_driverDB);

        $query = Helpers_Yandex::getYandexMapsCoordinates($url);
        array_shift($query);

        foreach ($query as $coordinates){
            $shopBillIDs = Request_Request::find(
                DB_AutoPart_Shop_Bill::NAME, $this->_sitePageData->shopID,
                $this->_sitePageData, $this->_driverDB,
                Request_RequestParams::setParams(
                    [
                        'shop_bill_state_source_id' => [1478255, 1478254, 1478252],
                        'shop_bill_delivery_address_id.latitude' => $coordinates[0],
                        'shop_bill_delivery_address_id.longitude' => $coordinates[1],
                    ]
                ),
                0, true
            );

            if(count($shopBillIDs->childs) < 1){
                $shopBillIDs = Request_Request::find(
                    DB_AutoPart_Shop_Bill::NAME, $this->_sitePageData->shopID,
                    $this->_sitePageData, $this->_driverDB,
                    Request_RequestParams::setParams(
                        [
                            'shop_bill_state_source_id' => [1478255, 1478254, 1478252],
                            'shop_other_address_id.latitude' => $coordinates[0],
                            'shop_other_address_id.longitude' => $coordinates[1],
                        ]
                    ),
                    0, true
                );
            }

            $this->_driverDB->updateObjects(
                Model_AutoPart_Shop_Bill::TABLE_NAME, $shopBillIDs->getChildArrayID(), ['shop_courier_id' => $shopCourierID]
            );

            $index = 1;
            foreach ($shopBillIDs->childs as $child){
                $child->setModel($model);
                $model->setShopCourierID($shopCourierID);

                // добавляем точку в маршрут
                Api_AutoPart_Shop_Courier_Route::addBill(
                    Helpers_DateTime::getCurrentDatePHP(), $model, $this->_sitePageData, $this->_driverDB, $index++
                );
            }
        }

        $this->response->body('ok');
    }

    public function action_calc() {
        $this->_sitePageData->url = '/market/shopbillitem/calc';

        $params = array_merge(
            [
                'shop_bill_id.shop_bill_status_source_id' => [Model_AutoPart_Shop_Bill_Status_Source::STATUS_COMPLETED],
            ]
        );
        $ids = Request_Request::find(
            DB_AutoPart_Shop_Bill_Item::NAME, $this->_sitePageData->shopID,
            $this->_sitePageData, $this->_driverDB, Request_RequestParams::setParams($params)
        );

        $model = new Model_AutoPart_Shop_Bill_Item();
        $model->setDBDriver($this->_driverDB);

        foreach ($ids->childs as $child){
            $child->setModel($model);

            $model->calcProfit(true);
            Helpers_DB::saveDBObject($model, $this->_sitePageData);
        }

        $params = array_merge(
            [
                'shop_bill_id.shop_bill_status_source_id' => [Model_AutoPart_Shop_Bill_Status_Source::STATUS_CANCEL],
            ]
        );
        $ids = Request_Request::find(
            DB_AutoPart_Shop_Bill_Item::NAME, $this->_sitePageData->shopID,
            $this->_sitePageData, $this->_driverDB, Request_RequestParams::setParams($params)
        );

        $model = new Model_AutoPart_Shop_Bill_Item();
        $model->setDBDriver($this->_driverDB);

        foreach ($ids->childs as $child){
            $child->setModel($model);

            $model->setPriceCost(0);
            $model->setDeliveryAmount(0);
            $model->calcProfit(true);
            Helpers_DB::saveDBObject($model, $this->_sitePageData);
        }

        $this->response->body('ok');
    }
}