<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Smg_Market_ShopPreOrder extends Controller_Smg_Market_Basic {

    public function __construct(Request $request, Response $response)
    {
        $this->dbObject = 'DB_AutoPart_Shop_PreOrder';
        $this->controllerName = 'shoppreorder';
        $this->tableID = Model_AutoPart_Shop_PreOrder::TABLE_ID;
        $this->tableName = Model_AutoPart_Shop_PreOrder::TABLE_NAME;

        parent::__construct($request, $response);

        $this->shopID = $this->_sitePageData->shopID;
        $this->editAndNewBasicTemplate = '';
    }

    public function action_index()
    {
        $this->_sitePageData->url = '/market/shoppreorder/index';

        $this->_requestListDB('DB_AutoPart_Shop_Supplier');
        $this->_requestListDB('DB_AutoPart_Shop_Courier');
        $this->_requestListDB('DB_AutoPart_Shop_Supplier_Address');
    
        parent::_actionIndex(
            array(
                'shop_supplier_id' => ['name'],
                'shop_courier_id' => ['name'],
                'shop_supplier_address_id' => ['name'],
            )
        );
    }

    public function action_courier()
    {
        $this->_sitePageData->url = '/market/shoppreorder/courier';

        $this->_requestListDB('DB_AutoPart_Shop_Supplier');
        $this->_requestListDB('DB_AutoPart_Shop_Courier');

        $shopCourierID = $this->_sitePageData->operation->getShopCourierID();
        if($shopCourierID < 1){
            $shopCourierID = -1;
        }

        $params = array_merge($_POST, $_GET);

        $date = Request_RequestParams::getParamDate('date');
        if(empty($date)){
            $date = Helpers_DateTime::getCurrentDatePHP();
        }
        $params['date'] = $date;

        $sortBy = Request_RequestParams::getParamArray('sort_by');
        if(empty($sortBy)){
            $sortBy = ['buy_at' => 'desc', 'created_at' => 'asc'];
        }
        $params['sort_by'] = $sortBy;

        $params['shop_courier_id'] = $shopCourierID;
        $params[Request_RequestParams::IS_NOT_READ_REQUEST_NAME] = true;

        parent::_actionIndex(
            array(
                'shop_supplier_id' => ['name'],
                'shop_supplier_address_id' => ['name'],
                'shop_courier_id' => ['name'],
            ),
            $params, -1, 'courier'
        );
    }

    public function action_new(){
        $this->_sitePageData->url = '/market/shoppreorder/new';

        $this->_requestListDB('DB_AutoPart_Shop_Supplier');
        $this->_requestListDB('DB_AutoPart_Shop_Courier');
        $this->_requestListDB('DB_AutoPart_Shop_Supplier_Address');

        parent::action_new();
    }

    public function action_edit(){
        $this->_sitePageData->url = '/market/shoppreorder/edit';

        $id = Request_RequestParams::getParamInt('id');
        $model = new Model_AutoPart_Shop_PreOrder();
        if (! $this->dublicateObjectLanguage($model, $id, 0, false)) {
            throw new HTTP_Exception_404('Object "' . $this->dbObject . '" not is found!');
        }

        $this->_requestListDB('DB_AutoPart_Shop_Supplier', $model->getValueInt('shop_supplier_id'));
        $this->_requestListDB('DB_AutoPart_Shop_Courier', $model->getValueInt('shop_courier_id'));
        $this->_requestListDB('DB_AutoPart_Shop_Supplier_Address', $model->getShopSupplierAddressID());

        $this->_actionEdit($model, $this->_sitePageData->shopID);
    }

    public function action_show(){
        $this->_sitePageData->url = '/market/shoppreorder/show';

        $id = Request_RequestParams::getParamInt('id');
        $model = new Model_AutoPart_Shop_PreOrder();
        if (! $this->dublicateObjectLanguage($model, $id, 0, false)) {
            throw new HTTP_Exception_404('Object "' . $this->dbObject . '" not is found!');
        }

        View_View::find(
            DB_AutoPart_Shop_Bill_Item::NAME, $this->_sitePageData->shopID,
            '_shop/bill/item/list/receive', '_shop/bill/item/one/receive',
            $this->_sitePageData, $this->_driverDB,
            Request_RequestParams::setParams(
                [
                    'shop_pre_order_id' => $id,
                ]
            ),
            ['shop_product_id' => array('image_path', 'options', 'integrations',),]
        );

        // получаем данные
        View_View::findOne(
            DB_AutoPart_Shop_PreOrder::NAME, $this->_sitePageData->shopID,
            "_shop/pre-order/one/show",
            $this->_sitePageData, $this->_driverDB, array('id' => $id), ['shop_supplier_id' => ['name']]
        );

        $this->_putInMain('/main/_shop/pre-order/show');
    }

    public function action_save_buy(){
        $this->_sitePageData->url = '/market/shoppreorder/save_buy';

        $id = Request_RequestParams::getParamInt('id');
        $model = new Model_AutoPart_Shop_PreOrder();
        if (! $this->dublicateObjectLanguage($model, $id, 0, false)) {
            throw new HTTP_Exception_404('Object "' . $this->dbObject . '" not is found!');
        }

        $model->setIsBuy(true);
        $model->setBuyAt(Helpers_DateTime::getCurrentDateTimePHP());
        Helpers_DB::saveDBObject($model, $this->_sitePageData);

        $shopBillItemIDs = Request_Request::findByField(
            DB_AutoPart_Shop_Bill_Item::NAME, 'shop_pre_order_id', $id, $this->_sitePageData->shopID,
            $this->_sitePageData, $this->_driverDB, 0, true
        );

        $isBuys = Request_RequestParams::getParamArray('is_buys');
        $barcodes = Request_RequestParams::getParamArray('barcodes');

        $modelItem = new Model_AutoPart_Shop_Bill_Item();
        $modelItem->setDBDriver($this->_driverDB);

        $modelBill = new Model_AutoPart_Shop_Bill();
        $modelBill->setDBDriver($this->_driverDB);

        foreach ($shopBillItemIDs->childs as $key => $child){
            if(!key_exists($child->id, $isBuys) || !Request_RequestParams::isBoolean($isBuys[$child->id])){
                continue;
            }

            $child->setModel($modelItem);
            $modelItem->setShopBillItemStatusID(Model_AutoPart_Shop_Bill_Item_Status::STATUS_BUY);
            $modelItem->setBarcode(Arr::path($barcodes, $modelItem->id, $modelItem->getBarcode()));
            $modelItem->setIsBuy(true);
            Helpers_DB::saveDBObject($modelItem, $this->_sitePageData);

            // меняем курьера (по умолчанию считаем, что товар в заказе только один товар)
            if (Helpers_DB::getDBObject($modelBill, $modelItem->getShopBillID(), $this->_sitePageData)) {
                $modelBill->setShopCourierID($model->getShopCourierID());
                Helpers_DB::saveDBObject($modelBill, $this->_sitePageData);

                // добавляем точку в маршрут
                Api_AutoPart_Shop_Courier_Route::addBill(
                    Helpers_DateTime::getCurrentDatePHP(), $modelBill, $this->_sitePageData, $this->_driverDB
                );
            }

            unset($shopBillItemIDs->childs[$key]);
        }

        // делаем новую привязку к закупу
        if(count($shopBillItemIDs->childs) > 0) {
            $modelPreOrder = new Model_AutoPart_Shop_PreOrder();
            $modelPreOrder->setDBDriver($this->_driverDB);

            $modelPreOrder->copy($model, true);

            $modelPreOrder->setIsBuy(false);
            $modelPreOrder->setCreatedAt(null);
            $modelPreOrder->setNumber($this->_driverDB->nextSequence('ab_shop_pre_order_number'));
            Helpers_DB::saveDBObject($modelPreOrder, $this->_sitePageData);

            $amount = 0;
            $quantity = 0;
            foreach ($shopBillItemIDs->childs as $child) {
                $child->setModel($modelItem);

                $modelItem->setShopPreOrderID($modelPreOrder->id);
                Helpers_DB::saveDBObject($modelItem, $this->_sitePageData);

                $amount += $modelItem->getAmount();
                $quantity += $modelItem->getQuantity();
            }

            $modelPreOrder->setAmount($amount);
            $modelPreOrder->setQuantity($quantity);
            Helpers_DB::saveDBObject($modelPreOrder, $this->_sitePageData);
        }

        self::redirect('/market/shoppreorder/courier');
    }
}
