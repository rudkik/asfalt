<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Smg_Market_ShopCourierRoute extends Controller_Smg_Market_Basic {

    public function __construct(Request $request, Response $response)
    {
        $this->dbObject = 'DB_AutoPart_Shop_Courier_Route';
        $this->controllerName = 'shopcourierroute';
        $this->tableID = Model_AutoPart_Shop_Courier_Route::TABLE_ID;
        $this->tableName = Model_AutoPart_Shop_Courier_Route::TABLE_NAME;

        parent::__construct($request, $response);

        $this->shopID = $this->_sitePageData->shopID;
        $this->editAndNewBasicTemplate = '';
    }
    
    public function action_index()
    {
        $this->_sitePageData->url = '/market/shopcourierroute/index';

            $this->_requestListDB('DB_AutoPart_Shop_Courier');
            $this->_requestListDB('DB_AutoPart_Shop_Courier_Address');
    
        parent::_actionIndex(
            array(
                'shop_courier_id' => ['name'],
                'shop_courier_address_id' => ['name'],
            ),
            [
                'sort_by' => ['date' => 'desc'],
            ]
        );
    }

    public function action_courier()
    {
        $this->_sitePageData->url = '/market/shopcourierroute/courier';

        $shopCourierID = $this->_sitePageData->operation->getShopCourierID();
        if($shopCourierID < 1){
            $shopCourierID = -1;
        }

        $this->_requestListDB('DB_AutoPart_Shop_Courier');
        $this->_requestListDB(
            'DB_AutoPart_Shop_Courier_Address', null, 0, ['shop_courier_id' => $shopCourierID]
        );

        parent::_actionIndex(
            array(
                'shop_courier_id' => ['name'],
                'shop_courier_address_id_from' => ['name'],
                'shop_courier_address_id_to' => ['name'],
            ),
            [
                'shop_courier_id' => $shopCourierID,
                'sort_by' => ['date' => 'desc'],
            ],
            0, 'courier'
        );
    }

    public function action_new(){
        $this->_sitePageData->url = '/market/shopcourierroute/new';

        $this->_requestListDB('DB_AutoPart_Shop_Courier');
        $this->_requestListDB('DB_AutoPart_Shop_Courier_Address');

        parent::action_new();
    }

    public function action_edit(){
        $this->_sitePageData->url = '/market/shopcourierroute/edit';

        $id = Request_RequestParams::getParamInt('id');
        $model = new Model_AutoPart_Shop_Courier_Route();
        if (! $this->dublicateObjectLanguage($model, $id, 0, false)) {
            throw new HTTP_Exception_404('Object "' . $this->dbObject . '" not is found!');
        }

        $model->getElement('shop_courier_address_id_from', true);
        $model->getElement('shop_courier_address_id_to', true);
        $model->getElement('shop_courier_id', true);

        View_View::find(
            DB_AutoPart_Shop_Courier_Route_Item::NAME, $this->_sitePageData->shopID,
            '_shop/courier/route/item/list/index', '_shop/courier/route/item/one/index',
            $this->_sitePageData, $this->_driverDB,
            Request_RequestParams::setParams(
                [
                    'shop_courier_route_id' => $id,
                    'sort_by' => ['to_at' => 'desc', 'from_at' => 'desc', 'created_at' => 'desc']
                ]
            ),
            [
                'shop_supplier_address_id' => ['name'],
                'shop_bill_delivery_address_id' => ['name'],
                'shop_bill_id' => ['old_id'],
                'shop_supplier_id' => ['name'],
                'shop_other_address_id' => ['name'],
                'shop_pre_order_id' => ['number'],
                'shop_bill_id.shop_bill_buyer_id' => ['name'],
            ]
        );

        $this->_actionEdit($model, $this->_sitePageData->shopID);
    }

    public function action_show(){
        $this->_sitePageData->url = '/market/shopcourierroute/show';

        $id = Request_RequestParams::getParamInt('id');
        $model = new Model_AutoPart_Shop_Courier_Route();
        if (! $this->dublicateObjectLanguage($model, $id, 0, false)) {
            throw new HTTP_Exception_404('Object "' . $this->dbObject . '" not is found!');
        }

        $this->_requestListDB(
            'DB_AutoPart_Shop_Courier_Address', null, 0, ['shop_courier_id' => $model->getShopCourierID()]
        );

        $data = View_View::find(
            DB_AutoPart_Shop_Courier_Route_Item::NAME, $this->_sitePageData->shopID,
            '_shop/courier/route/item/list/show', '_shop/courier/route/item/one/show',
            $this->_sitePageData, $this->_driverDB,
            Request_RequestParams::setParams(
                [
                    'shop_courier_route_id' => $id,
                    'is_finish' => false,
                    'from_at_empty' => false,
                    'sort_by' => ['order' => 'asc', 'created_at' => 'asc'],
                ]
            ),
            [
                'shop_supplier_address_id' => ['name'],
                'shop_bill_delivery_address_id' => ['name'],
                'shop_bill_id' => ['old_id'],
                'shop_supplier_id' => ['name'],
                'shop_other_address_id' => ['name'],
                'shop_pre_order_id' => ['number'],
            ]
        );
        $this->_sitePageData->addReplaceAndGlobalDatas('view::_shop/courier/route/item/list/current', $data);

        $data = View_View::find(
            DB_AutoPart_Shop_Courier_Route_Item::NAME, $this->_sitePageData->shopID,
            '_shop/courier/route/item/list/show', '_shop/courier/route/item/one/show',
            $this->_sitePageData, $this->_driverDB,
            Request_RequestParams::setParams(
                [
                    'shop_courier_route_id' => $id,
                    'is_finish' => true,
                    'sort_by' => ['order' => 'asc', 'to_at' => 'desc'],
                ]
            ),
            [
                'shop_supplier_address_id' => ['name'],
                'shop_bill_delivery_address_id' => ['name'],
                'shop_other_address_id' => ['name'],
                'shop_bill_id' => ['old_id'],
                'shop_supplier_id' => ['name'],
                'shop_other_address_id' => ['name'],
                'shop_pre_order_id' => ['number'],
            ]
        );
        $this->_sitePageData->addReplaceAndGlobalDatas('view::_shop/courier/route/item/list/finish', $data);

        View_View::find(
            DB_AutoPart_Shop_Courier_Route_Item::NAME, $this->_sitePageData->shopID,
            '_shop/courier/route/item/list/show', '_shop/courier/route/item/one/show',
            $this->_sitePageData, $this->_driverDB,
            Request_RequestParams::setParams(
                [
                    'shop_courier_route_id' => $id,
                    'is_finish' => false,
                    'from_at_empty' => true,
                    'sort_by' => ['order' => 'asc', 'created_at' => 'asc'],
                ]
            ),
            [
                'shop_supplier_address_id' => ['name'],
                'shop_bill_delivery_address_id' => ['name'],
                'shop_bill_id' => ['old_id'],
                'shop_supplier_id' => ['name'],
                'shop_other_address_id' => ['name'],
                'shop_pre_order_id' => ['number'],
            ]
        );

        // получаем данные
        View_View::findOne(
            DB_AutoPart_Shop_Courier_Route::NAME, $this->_sitePageData->shopID,
            "_shop/courier/route/one/show",
            $this->_sitePageData, $this->_driverDB,
            Request_RequestParams::setParams(['id' => $id]),
            [
                'shop_courier_address_id_from' => ['name']
            ]
        );

        $this->_putInMain('/main/_shop/courier/route/show');
    }

    public function action_my_route(){
        $this->_sitePageData->url = '/market/shopcourierroute/my_route';

        $shopCourierID = $this->_sitePageData->operation->getShopCourierID();
        if($shopCourierID < 1){
            $shopCourierID = 1811354;
        }

        $route = Request_Request::findOne(
            DB_AutoPart_Shop_Courier_Route::NAME, $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB,
            Request_RequestParams::setParams(
                [
                    'date' => Helpers_DateTime::getCurrentDatePHP(),
                    'shop_courier_id' => $shopCourierID,
                    'is_finish' => false,
                ]
            )
        );

        if($route === null){
            self::redirect('/market/shopcourierroute/courier');
        }else {
            self::redirect('/market/shopcourierroute/show' . URL::query(['id' => $route->id], false));
        }
    }

    public function action_start_work(){
        $this->_sitePageData->url = '/market/shopcourierroute/start_work';

        $shopCourierAddressID = Request_RequestParams::getParamInt('shop_courier_address_id');
        $modelAddress = new Model_AutoPart_Shop_Courier_Address();
        if (! $this->dublicateObjectLanguage($modelAddress, $shopCourierAddressID, 0, false)) {
            throw new HTTP_Exception_404('Address not is found!');
        }

        /** @var Model_AutoPart_Shop_Courier_Route $model */
        $model = Request_Request::findOneModel(
            DB_AutoPart_Shop_Courier_Route::NAME, $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB,
            Request_RequestParams::setParams(
                [
                    'date' => Helpers_DateTime::getCurrentDatePHP(),
                    'shop_courier_id' => $modelAddress->getShopCourierID(),
                    'is_finish' => false,
                ]
            )
        );

        if($model == false){
            $model = new Model_AutoPart_Shop_Courier_Route();
            $model->setDBDriver($this->_driverDB);

            $model->setDate(Helpers_DateTime::getCurrentDatePHP());
            $model->setShopCourierID($modelAddress->getShopCourierID());
        }

        if($model->getShopCourierAddressIDFrom() < 1) {
            $model->setShopCourierAddressIDFrom($modelAddress->id);
            $model->setFromAt(Helpers_DateTime::getCurrentDateTimePHP());
        }

        Helpers_DB::saveDBObject($model, $this->_sitePageData);

        self::redirect('/market/shopcourierroute/show' . URL::query(['id' => $model->id], false));
    }

    public function action_finish_work(){
        $this->_sitePageData->url = '/market/shopcourierroute/finish_work';

        $shopCourierAddressID = Request_RequestParams::getParamInt('shop_courier_address_id');
        $modelAddress = new Model_AutoPart_Shop_Courier_Address();
        if (! $this->dublicateObjectLanguage($modelAddress, $shopCourierAddressID, 0, false)) {
            throw new HTTP_Exception_404('Address not is found!');
        }

        $shopCourierRouteID = Request_RequestParams::getParamInt('shop_courier_route_id');
        $model = new Model_AutoPart_Shop_Courier_Route();
        if (! $this->dublicateObjectLanguage($model, $shopCourierRouteID, 0, false)) {
            throw new HTTP_Exception_404('Route not is found!');
        }

        $model->setShopCourierAddressIDTo($shopCourierAddressID);

        if($model->getShopCourierAddressIDFrom() == 0){
            $model->setShopCourierAddressIDFrom($shopCourierAddressID);
        }

        if(Func::_empty($model->getFromAt())) {
            $model->setFromAt(
                Api_AutoPart_Shop_Courier_Route::getFirstPointTime($model, $this->_sitePageData, $this->_driverDB)
            );
        }

        if(Func::_empty($model->getToAt()) || $model->getDate() != Helpers_DateTime::getDateFormatPHP($model->getToAt())) {
            if ($model->getDate() == Helpers_DateTime::getCurrentDatePHP()) {
                $model->setToAt(Helpers_DateTime::getCurrentDateTimePHP());
            } else {
                $model->setToAt(
                    Api_AutoPart_Shop_Courier_Route::getLastPointTime($model, $this->_sitePageData, $this->_driverDB)
                );
            }
        }

        // считаем статичные данные
        Api_AutoPart_Shop_Courier_Route::calcStatistic($model, $this->_sitePageData, $this->_driverDB);

        Helpers_DB::saveDBObject($model, $this->_sitePageData);

        self::redirect('/market/shopcourierroute/courier');
    }
}
