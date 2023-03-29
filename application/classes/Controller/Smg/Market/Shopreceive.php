<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Smg_Market_ShopReceive extends Controller_Smg_Market_Basic {

    public function __construct(Request $request, Response $response)
    {
        $this->dbObject = 'DB_AutoPart_Shop_Receive';
        $this->controllerName = 'shopreceive';
        $this->tableID = Model_AutoPart_Shop_Receive::TABLE_ID;
        $this->tableName = Model_AutoPart_Shop_Receive::TABLE_NAME;

        parent::__construct($request, $response);

        $this->shopID = $this->_sitePageData->shopID;
        $this->editAndNewBasicTemplate = '';
    }
    
    public function action_index()
    {
        $this->_sitePageData->url = '/market/shopreceive/index';

            $this->_requestListDB('DB_AutoPart_Shop_Supplier');
            $this->_requestListDB('DB_AutoPart_Shop_Courier');
    
        parent::_actionIndex(
            array(
                'shop_supplier_id' => ['name'],
                'shop_supplier_address_id' => ['name'],
                'shop_courier_id' => ['name'],
                'shop_company_id' => ['name'],
                'return_shop_receive_id' => ['esf_number'],
            )
        );
    }

    public function action_new(){
        $this->_sitePageData->url = '/market/shopreceive/new';

        $this->_requestListDB('DB_AutoPart_Shop_Supplier');
        $this->_requestListDB('DB_AutoPart_Shop_Courier');

        parent::action_new();
    }

    public function action_edit(){
        $this->_sitePageData->url = '/market/shopreceive/edit';

        $id = Request_RequestParams::getParamInt('id');
        $model = new Model_AutoPart_Shop_Receive();
        if (! $this->dublicateObjectLanguage($model, $id, 0, false)) {
            throw new HTTP_Exception_404('Object "' . $this->dbObject . '" not is found!');
        }

        $this->_requestListDB('DB_AutoPart_Shop_Supplier', $model->getValueInt('shop_supplier_id'));
        $this->_requestListDB('DB_AutoPart_Shop_Courier', $model->getValueInt('shop_courier_id'));

        View_View::find(
            DB_AutoPart_Shop_Receive_Item::NAME, $this->_sitePageData->shopID,
            '_shop/receive/item/list/return', '_shop/receive/item/one/return',
            $this->_sitePageData, $this->_driverDB,
            Request_RequestParams::setParams(
                [
                    'return_shop_receive_id' => $id,
                    'sort_by' => ['name' => 'asc'],
                ]
            ),
            ['shop_product_id' => array('name')]
        );

        View_View::find(
            DB_AutoPart_Shop_Receive_Item::NAME, $this->_sitePageData->shopID,
            '_shop/receive/item/list/index', '_shop/receive/item/one/index',
            $this->_sitePageData, $this->_driverDB,
            Request_RequestParams::setParams(
                [
                    'shop_receive_id' => $id,
                    'sort_by' => ['shop_product_id' => 'asc'],
                ]
            ),
            ['shop_product_id' => array('name', 'image_path', 'options', 'integrations')]
        );

        if(!$model->getIsReturn()) {
            View_View::find(
                DB_AutoPart_Shop_Bill_Item::NAME, $this->_sitePageData->shopID,
                '_shop/bill/item/list/receive-edit', '_shop/bill/item/one/receive-edit',
                $this->_sitePageData, $this->_driverDB,
                Request_RequestParams::setParams(
                    [
                        'shop_receive_id' => $id,
                        'sort_by' => ['shop_product_id' => 'asc'],
                    ]
                ),
                [
                    'shop_product_id' => ['name', 'image_path', 'options', 'integrations'],
                    'shop_bill_id' => ['created_at', 'old_id'],
                    'shop_bill_id.shop_bill_status_source_id' => ['name'],
                ]
            );

            View_View::find(
                DB_AutoPart_Shop_Bill_Item::NAME, $this->_sitePageData->shopID,
                '_shop/bill/item/list/receive-new', '_shop/bill/item/one/receive-new',
                $this->_sitePageData, $this->_driverDB,
                Request_RequestParams::setParams(
                    [
                        'shop_bill_id.created_at_to' => Helpers_DateTime::plusDays($model->getDate(), 2222),
                        'shop_receive_id' => 0,
                        //'shop_source_id' => 2,
                        'shop_bill_id.shop_bill_status_source_id' => [
                            Model_AutoPart_Shop_Bill_Status_Source::STATUS_COMPLETED,
                        ],
                        'sort_by' => ['shop_bill_id.created_at' => 'desc']
                    ]
                ),
                [
                    'shop_supplier_id' => ['name'],
                    'shop_product_id' => ['name', 'image_path', 'options', 'integrations'],
                    'shop_bill_id' => ['created_at', 'old_id'],
                ]
            );
        }

        $this->_actionEdit($model, $this->_sitePageData->shopID);
    }

    public function action_load_esf()
    {
        $this->_sitePageData->url = '/market/shoppaymentsource/load_esf';

        if(!key_exists('file', $_FILES)){
            throw new HTTP_Exception_500('File not load.');
        }

        $files = $_FILES['file']['tmp_name'];
        if(!is_array($files)){
            $files = [$files];
        }

        $ids = [];
        foreach ($files  as $file) {
            $esf = new Helpers_ESF_Unload_Invoices();
            $esf->loadXML($file);

            $modelReceive = new Model_AutoPart_Shop_Receive();
            $modelReceive->setDBDriver($this->_driverDB);

            $modelItem = new Model_AutoPart_Shop_Receive_Item();
            $modelItem->setDBDriver($this->_driverDB);

            /** @var Helpers_ESF_Unload_Invoice $invoice */
            foreach ($esf->getValues() as $invoice) {
                if($invoice->getSeller()->getBIN() == 160140002070){
                    continue;
                }

                $company = Request_Request::findOneByField(
                    DB_AutoPart_Shop_Company::NAME, 'bin_full', $invoice->getConsignee()->getBIN(),
                    $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB
                );
                if ($company == null) {
                    throw new HTTP_Exception_500('Company "' . $invoice->getConsignee()->getName() . '" "' . $invoice->getConsignee()->getBIN() . '" not found.');
                }

                $supplier = Request_Request::findOneByField(
                    DB_AutoPart_Shop_Supplier::NAME, 'bin_full', $invoice->getSeller()->getBIN(),
                    $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB
                );
                if ($supplier == null) {
                    continue;
                    throw new HTTP_Exception_500('Supplier "' . $invoice->getSeller()->getName() . '" "' . $invoice->getSeller()->getBIN() . '" not found.');
                }

                $receive = Request_Request::findOne(
                    DB_AutoPart_Shop_Receive::NAME, $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB,
                    Request_RequestParams::setParams(
                        [
                            'esf_number_full' => $invoice->getRegistrationNumber(),
                            'shop_supplier_id' => $supplier->id,
                            'shop_company_id' => $company->id,
                            'is_public_ignore' => true,
                        ]
                    )
                );
                if ($receive == null) {
                    $modelReceive->clear();
                    $modelReceive->setShopSupplierID($supplier->id);
                    $modelReceive->setShopCompanyID($company->id);
                } else {
                    $receive->setModel($modelReceive);
                }

                $modelReceive->setIsReturn($invoice->getInvoiceType() == Helpers_ESF_Unload_Invoice::INVOICE_TYPE_ADDITIONAL_INVOICE);

                $returnShopReceiveID = 0;
                if($modelReceive->getIsReturn()){
                    $return = Request_Request::findOneByField(
                        DB_AutoPart_Shop_Receive::NAME, 'esf_number_full', $invoice->getRelatedInvoice()->getRegistrationNumber(),
                        $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB
                    );
                    if($return != null){
                        $returnShopReceiveID = $return->id;
                    }
                }

                $modelReceive->setIsLoadFile(true);
                $modelReceive->setReturnShopReceiveID($returnShopReceiveID);
                $modelReceive->setESFNumber($invoice->getRegistrationNumber());
                $modelReceive->setNumber($invoice->getNumber());
                $modelReceive->setDate($invoice->getTurnoverDate());
                $modelReceive->setESFDate($invoice->getDate());
                $modelReceive->setESFObject($invoice);
                $modelReceive->setIsPublic(true);

                if($modelReceive->getIsReturn()){
                    $modelReceive->setIsCheck($returnShopReceiveID > 0);
                }

                $modelReceive->setAmount($invoice->getProducts()->getAmount());
                $modelReceive->setQuantity($invoice->getProducts()->getQuantity());

                if ($modelReceive->id > 0) {
                    $shopReceiveItemIDs = Request_Request::find(
                        DB_AutoPart_Shop_Receive_Item::NAME, $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB,
                        Request_RequestParams::setParams(
                            [
                                'shop_receive_id' => $modelReceive->id,
                                'is_public_ignore' => true,
                                'sort_by' => ['created_at' => 'asc'],
                            ]
                        ),
                        0, true
                    );
                } else {
                    $shopReceiveItemIDs = new MyArray();
                }

                $ids[] = Helpers_DB::saveDBObject($modelReceive, $this->_sitePageData);

                /** @var Helpers_ESF_Unload_Product $product */
                foreach ($invoice->getProducts()->getValues() as $product) {
                    $shopReceiveItemIDs->childShiftSetModel($modelItem, 0, 0, false, ['name' => $product->getName()]);

                    $modelItem->setShopReceiveID($modelReceive->id);
                    $modelItem->setReturnShopReceiveID($returnShopReceiveID);

                    $modelItem->setName($product->getName());
                    $modelItem->setQuantity($product->getQuantity());
                    $modelItem->setPrice($product->getPrice());
                    $modelItem->setAmount($product->getAmount());
                    $modelItem->setOldID($product->getHash());
                    $modelItem->setIsPublic(true);

                    Helpers_DB::saveDBObject($modelItem, $this->_sitePageData);
                }

                // удаляем лишние
                $this->_driverDB->deleteObjectIDs(
                    $shopReceiveItemIDs->getChildArrayID(), $this->_sitePageData->userID,
                    DB_AutoPart_Shop_Receive_Item::TABLE_NAME, array(), $this->_sitePageData->shopID
                );
            }
        }

        $this->redirect('/market/shopreceive/index' . URL::query(['id' => $ids], false));
    }

    public function action_check()
    {
        $this->_sitePageData->url = '/market/shopreceive/check';

        $shopReceiveID = Request_RequestParams::getParamInt('shop_receive_id');
        if($shopReceiveID < 1){
            $shopReceiveID = Request_RequestParams::getParamInt('id');
        }

        if($shopReceiveID < 1){
            $isCheck = false;
        }else{
            $isCheck = null;
        }

        $ids = Request_Request::find(
            DB_AutoPart_Shop_Receive::NAME, $this->_sitePageData->shopID,
            $this->_sitePageData, $this->_driverDB,
            Request_RequestParams::setParams(
                [
                    'id' => $shopReceiveID,
                    'is_check' => $isCheck,
                ]
            ),
            0, true
        );

        $model = new Model_AutoPart_Shop_Receive();
        $model->setDBDriver($this->_driverDB);

        $modelItem = new Model_AutoPart_Shop_Receive_Item();
        $modelItem->setDBDriver($this->_driverDB);

        foreach ($ids->childs as $child){
            $child->setModel($model);

            if($model->getIsReturn()){
                $model->setIsCheck($model->getReturnShopReceiveID() > 0);
                Helpers_DB::saveDBObject($model, $this->_sitePageData);

                continue;
            }

            $billItems = Request_Request::find(
                DB_AutoPart_Shop_Bill_Item::NAME, $this->_sitePageData->shopID,
                $this->_sitePageData, $this->_driverDB,
                Request_RequestParams::setParams(
                    [
                        'shop_receive_id' => $model->id,
                        'sum_quantity' => true,
                        'shop_bill_id.shop_bill_status_source_id' => Model_AutoPart_Shop_Bill_Status_Source::STATUS_COMPLETED,
                        'group_by' => ['shop_product_id', 'name']
                    ]
                ),
                0, true
            );

            $list = [];
            foreach ($billItems->childs as $child){
                $shopProductID = $child->values['shop_product_id'];
                if(!key_exists($shopProductID, $list)){
                    $list[$shopProductID] = $child;
                }else{
                    $list[$shopProductID]->values['quantity'] += $child->values['quantity'];
                }
            }
            $billItems->childs = $list;

            $receiveItemsRetrun = Request_Request::find(
                DB_AutoPart_Shop_Receive_Item::NAME, $this->_sitePageData->shopID,
                $this->_sitePageData, $this->_driverDB,
                Request_RequestParams::setParams(
                    [
                        'return_shop_receive_id' => $model->id,
                        'sum_quantity' => true,
                        'group_by' => ['name']
                    ]
                ),
                0, true
            );
            $receiveItemsRetrun->runIndex(true, 'name');

            $receiveItems = Request_Request::find(
                DB_AutoPart_Shop_Receive_Item::NAME, $this->_sitePageData->shopID,
                $this->_sitePageData, $this->_driverDB,
                Request_RequestParams::setParams(
                    [
                        'shop_receive_id' => $model->id,
                        'sum_quantity' => true,
                        'is_expense' => false,
                        'group_by' => ['shop_product_id', 'name', 'is_store', 'is_expense']
                    ]
                ),
                0, true
            );
           /* echo '<pre>';
            print_r($billItems->childs);
            print_r($receiveItems->childs);
            print_r($receiveItemsRetrun->childs);die;*/

            $isCheck = true;
            foreach ($receiveItems->childs as $key => $receiveItem){
                $quantity = $receiveItem->values['quantity'];
                $sales = 0;

                $shopProductID = $receiveItem->values['shop_product_id'];
                if(key_exists($shopProductID, $billItems->childs)){
                    $sales += $billItems->childs[$shopProductID]->values['quantity'];
                }

                $name = $receiveItem->values['name'];
                if(key_exists($name, $receiveItemsRetrun->childs)){
                    $sales += $receiveItemsRetrun->childs[$name]->values['quantity'];
                }

                $quantity -= $sales;

                // распределяем количество проданного товара по срокам накладной, чтобы знать количество товаров на складе
                $params = ['shop_receive_id' => $model->id];
                if($shopProductID > 0){
                    $params['shop_product_id'] = $shopProductID;
                }else{
                    $params['name_full'] = $name;
                }

                $list = Request_Request::find(
                    DB_AutoPart_Shop_Receive_Item::NAME, $this->_sitePageData->shopID,
                    $this->_sitePageData, $this->_driverDB, Request_RequestParams::setParams($params),
                    0, true
                );

                foreach ($list->childs as $one){
                    $one->setModel($modelItem);

                    if($modelItem->getQuantity() > $sales){
                        $modelItem->setQuantitySales($sales);
                    }else {
                        $modelItem->setQuantitySales($modelItem->getQuantity());
                    }

                    Helpers_DB::saveDBObject($modelItem, $this->_sitePageData);

                    $sales -= $modelItem->getQuantitySales();
                }
                if(count($list->childs) > 0){
                    $modelItem->setQuantitySales($modelItem->getQuantitySales() + $sales);
                    Helpers_DB::saveDBObject($modelItem, $this->_sitePageData);
                }

                if($quantity > 0){
                    if(key_exists($shopProductID, $billItems->childs)
                        && $receiveItem->values['quantity'] > $billItems->childs[$shopProductID]->values['quantity']){

                        $receiveItem->values['quantity'] -= $billItems->childs[$shopProductID]->values['quantity'];
                        unset($billItems->childs[$shopProductID]);
                    }elseif(key_exists($name, $receiveItemsRetrun->childs)
                            && $receiveItem->values['quantity'] > $receiveItemsRetrun->childs[$name]->values['quantity']){

                        $receiveItem->values['quantity'] -= $receiveItemsRetrun->childs[$name]->values['quantity'];
                        unset($receiveItemsRetrun->childs[$name]);
                    }
                }else {
                    unset($billItems->childs[$shopProductID]);
                    unset($receiveItemsRetrun->childs[$name]);
                    unset($receiveItems->childs[$key]);
                }
            }

            /*echo '<pre>';
            print_r($billItems->childs);
            print_r($receiveItems->childs);
            print_r($receiveItemsRetrun->childs);die;*/

            // убираем расход
            foreach ($receiveItems->childs as $key => $child){
                if($child->values['is_expense'] == 1){
                    unset($receiveItems->childs[$key]);
                }
            }

            $isCheck = $isCheck && count($receiveItems->childs) == 0
                && count($billItems->childs) == 0 && count($receiveItemsRetrun->childs) == 0;

            $isStore = false;
            if(!$isCheck){
                if(count($billItems->childs) == 0 && count($receiveItemsRetrun->childs) == 0){
                    $isStore = true;
                    foreach ($receiveItems->childs as $child){
                        $isStore = $isStore && $child->values['is_store'] == 1;
                    }
                }
            }

            $model->setIsCheck($isCheck);
            $model->setIsStore($isStore);
            Helpers_DB::saveDBObject($model, $this->_sitePageData);
        }

        $this->redirect('/market/shopreceive/index');
    }

    public function action_set_bill_item(){
        $this->_sitePageData->url = '/market/shopreceive/set_bill_item';

        $shopReceiveItemID = Request_RequestParams::getParamInt('shop_receive_item_id');
        $modelReceiveItem = new Model_AutoPart_Shop_Receive_Item();
        $modelReceiveItem->setDBDriver($this->_driverDB);

        if (!Helpers_DB::getDBObject($modelReceiveItem, $shopReceiveItemID, $this->_sitePageData)) {
            throw new HTTP_Exception_404('Receive item "' . $shopReceiveItemID . '" not is found!');
        }

        $shopBillItemID = Request_RequestParams::getParamInt('shop_bill_item_id');
        $modelBillItem = new Model_AutoPart_Shop_Bill_Item();
        $modelBillItem->setDBDriver($this->_driverDB);

        if (!Helpers_DB::getDBObject($modelBillItem, $shopBillItemID, $this->_sitePageData)) {
            throw new HTTP_Exception_404('Bill item "' . $shopBillItemID . '" not is found!');
        }

        $modelReceive = new Model_AutoPart_Shop_Receive();
        $modelReceive->setDBDriver($this->_driverDB);

        if (!Helpers_DB::getDBObject($modelReceive, $modelReceiveItem->getShopReceiveID(), $this->_sitePageData)) {
            throw new HTTP_Exception_404('Receive "' . $modelReceiveItem->getShopReceiveID() . '" not is found!');
        }

        // удаляем привязку старой строчки
        if($modelReceiveItem->getShopBillItemID() > 0
            && $modelReceiveItem->getQuantity() == $modelBillItem->getQuantity()){
            $this->_driverDB->updateObjects(
                Model_AutoPart_Shop_Bill_Item::TABLE_NAME, [$modelReceiveItem->getShopBillItemID()],
                ['shop_receive_id' => 0]
            );
        }

        $modelReceiveItem->setShopProductID($modelBillItem->getShopProductID());
        $modelReceiveItem->setShopBillItemID($shopBillItemID);
        Helpers_DB::saveDBObject($modelReceiveItem, $this->_sitePageData);

        $modelBillItem->setShopSupplierID($modelReceive->getShopSupplierID());
        $modelBillItem->setShopReceiveID($modelReceiveItem->getShopReceiveID());
        $modelBillItem->setPriceCost($modelReceiveItem->getPrice());
        Helpers_DB::saveDBObject($modelBillItem, $this->_sitePageData);

        $this->response->body('ok');
    }

    public function action_del_bill_item(){
        $this->_sitePageData->url = '/market/shopreceive/del_bill_item';

        $modelReceiveItem = new Model_AutoPart_Shop_Receive_Item();
        $modelReceiveItem->setDBDriver($this->_driverDB);

        $id = Request_RequestParams::getParamInt('id');
        if (!Helpers_DB::getDBObject($modelReceiveItem, $id, $this->_sitePageData)) {
            throw new HTTP_Exception_404('Receive item "' . $id . '" not is found!');
        }

        $this->_driverDB->updateObjects(
            Model_AutoPart_Shop_Bill_Item::TABLE_NAME, [$modelReceiveItem->getShopBillItemID()],
            ['shop_receive_id' => 0]
        );

        $modelReceiveItem->setShopBillItemID(0);
        $modelReceiveItem->setShopProductID(0);
        Helpers_DB::saveDBObject($modelReceiveItem, $this->_sitePageData);

        $this->response->body('ok');
    }
}
