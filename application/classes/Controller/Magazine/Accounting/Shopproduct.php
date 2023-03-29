<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Magazine_Accounting_ShopProduct extends Controller_Magazine_Accounting_BasicMagazine {

    public function __construct(Request $request, Response $response)
    {
        $this->dbObject = 'DB_Magazine_Shop_Product';
        $this->controllerName = 'shopproduct';
        $this->tableID = Model_Magazine_Shop_Product::TABLE_ID;
        $this->tableName = Model_Magazine_Shop_Product::TABLE_NAME;
        $this->objectName = 'product';

        parent::__construct($request, $response);
    }

    public function action_index() {
        $this->_sitePageData->url = '/accounting/shopproduct/index';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/product/list/index',
            )
        );

        $this->_requestShopProductRubrics();

        // получаем список
        View_View::find('DB_Magazine_Shop_Product',
            $this->_sitePageData->shopMainID, "_shop/product/list/index", "_shop/product/one/index",
            $this->_sitePageData, $this->_driverDB, array('limit_page' => 25),
            array(
                'shop_product_rubric_id' => array('name'),
                'unit_id' => array('name'),
            )
        );

        $this->_putInMain('/main/_shop/product/index');
    }

    public function action_history() {
        $this->_sitePageData->url = '/accounting/shopproduct/history';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/product/list/history',
            )
        );

        $this->_requestShopProducts(null, $this->_sitePageData->shopMainID);

        $result = new MyArray();

        $params = Request_RequestParams::setParams(
            array(
                'shop_product_id' => Request_RequestParams::getParamInt('shop_product_id'),
            ),
            FALSE
        );

        $operation = Request_RequestParams::getParamArray('operation');

        // приход
        if(empty($operation) || in_array('receive', $operation)) {
            $ids = Request_Request::find('DB_Magazine_Shop_Receive_Item',
                $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
                array('shop_supplier_id' => array('name'))
            );
            $ids->addAdditionDataChilds(array('type' => 'receive', 'operation' => 1));
            $result->addChilds($ids);
        }

        // возврат реализации
        if(empty($operation) || in_array('realization_return', $operation)) {
            $params1 = $params;

            $ids = Request_Request::find('DB_Magazine_Shop_Realization_Return_Item',
                $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB, $params1, 0, TRUE,
                array()
            );
            $ids->addAdditionDataChilds(array('type' => 'realization_return', 'operation' => 1));
            $result->addChilds($ids);
        }

        // реализация
        if(empty($operation)) {
            $ids = Request_Request::find('DB_Magazine_Shop_Realization_Item',
                $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
                array('shop_worker_id' => array('name'), 'shop_write_off_type_id' => array('name'))
            );
            $ids->addAdditionDataChilds(array('type' => 'realization', 'operation' => -1));
            $result->addChilds($ids);
        }elseif(!empty($operation)) {
            if(in_array('realization', $operation)) {
                $params1 = $params;
                $params1['is_special'] = [Model_Magazine_Shop_Realization::SPECIAL_TYPE_BASIC, Model_Magazine_Shop_Realization::SPECIAL_TYPE_PRODUCT];
                $params1['shop_write_off_type_id'] = array('value' => [0, Model_Magazine_Shop_WriteOff_Type::WRITE_OFF_TYPE_REDRESS]);

                $ids = Request_Request::find('DB_Magazine_Shop_Realization_Item',
                    $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB, $params1, 0, TRUE,
                    array('shop_worker_id' => array('name'), 'shop_write_off_type_id' => array('name'))
                );
                $ids->addAdditionDataChilds(array('type' => 'realization', 'operation' => -1));
                $result->addChilds($ids);
            }

            if(in_array('write_off', $operation)) {
                $params1 = $params;
                $params1['shop_write_off_type_id'] = Model_Magazine_Shop_WriteOff_Type::WRITE_OFF_TYPE_RECEPTION;
                $params1['is_special'] = Model_Magazine_Shop_Realization::SPECIAL_TYPE_WRITE_OFF;

                $ids = Request_Request::find('DB_Magazine_Shop_Realization_Item',
                    $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB, $params1, 0, TRUE,
                    array('shop_worker_id' => array('name'), 'shop_write_off_type_id' => array('name'))
                );
                $ids->addAdditionDataChilds(array('type' => 'realization', 'operation' => -1));
                $result->addChilds($ids);
            }

            if(in_array('adjustment', $operation)) {
                $params1 = $params;
                $params1['shop_write_off_type_id'] = array(
                    'value' =>
                        [
                            Model_Magazine_Shop_WriteOff_Type::WRITE_OFF_TYPE_BY_STANDART, // по нормам
                            Model_Magazine_Shop_WriteOff_Type::WRITE_OFF_TYPE_OVER_THE_NORM, // сверх нормы
                        ]
                );
                $params1['is_special'] = Model_Magazine_Shop_Realization::SPECIAL_TYPE_WRITE_OFF;

                $ids = Request_Request::find('DB_Magazine_Shop_Realization_Item',
                    $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB, $params1, 0, TRUE,
                    array('shop_worker_id' => array('name'), 'shop_write_off_type_id' => array('name'))
                );
                $ids->addAdditionDataChilds(array('type' => 'realization', 'operation' => -1));
                $result->addChilds($ids);
            }
        }

        // перемещение c минусом
        if(empty($operation) || in_array('move_expense', $operation)) {
            $ids = Request_Request::find('DB_Magazine_Shop_Move_Item',
                $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
                array('branch_move_id' => array('name'), 'shop_id' => array('name'))
            );
            $ids->addAdditionDataChilds(array('type' => 'move', 'operation' => -1));
            $result->addChilds($ids);
        }

        // перемещение c плюсом
        if(empty($operation) || in_array('move_receive', $operation)) {
            $params['branch_move_id'] = $this->_sitePageData->shopID;
            $ids = Request_Request::findBranch('DB_Magazine_Shop_Move_Item',
                array(), $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
                array('shop_id' => array('name'))
            );
            $ids->addAdditionDataChilds(array('type' => 'move', 'operation' => 1));
            $result->addChilds($ids);
        }

        $result->childsSortBy(
            array(
                'created_at' => 'asc',
            ),
            TRUE, TRUE
        );

        $this->_sitePageData->replaceDatas['view::_shop/product/list/history'] = Helpers_View::getViewObjects(
            $result, new Model_Magazine_Shop_Product(),
            "_shop/product/list/history", "_shop/product/one/history",
            $this->_sitePageData, $this->_driverDB, $this->_sitePageData->shopMainID
        );

        $this->_putInMain('/main/_shop/product/history');
    }

    public function action_stock() {
        $this->_sitePageData->url = '/accounting/shopproduct/stock';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/product/list/stock',
            )
        );

        $this->_requestShopProductRubrics();
        $this->_requestShopSupplier();

        $dateStock = Request_RequestParams::getParamDate('date_stock');
        $shopSupplierID = Request_RequestParams::getParamInt('shop_supplier_id');


        if((empty($dateStock) || $dateStock == date('Y-m-d')) && $shopSupplierID < 1) {
            // получаем список
            $params = Request_RequestParams::setParams(
                array(
                    'limit_page' => 25,
                    'sort_by' => array('quantity' => 'desc')
                ),
                FALSE
            );

            View_View::find('DB_Magazine_Shop_Product',
                $this->_sitePageData->shopMainID, "_shop/product/list/stock", "_shop/product/one/stock",
                $this->_sitePageData, $this->_driverDB, $params,
                array(
                    'unit_id' => array('name'),
                    'shop_product_stock_id' => array('quantity_balance'),
                    'shop_production_id' => array('name', 'id', 'barcode', 'image_path'),
                    'shop_product_rubric_id' => array('name'),
                    'unit_id' => array('name'),
                )
            );
        }else{
            if($shopSupplierID > 0){
                $params = Request_RequestParams::setParams(
                    array(
                        'shop_supplier_id' => $shopSupplierID,
                        'group_by' => array('shop_product_id'),
                    )
                );

                $shopProductIDs = Request_Request::findBranch('DB_Magazine_Shop_Receive_Item',
                    array(), $this->_sitePageData, $this->_driverDB, $params, 0, TRUE
                )->getChildArrayInt('shop_product_id');

                if(empty($shopProductIDs)){
                    $shopProductIDs = null;
                }
            }else{
                $shopProductIDs = null;
            }

            // получаем список
            $params = Request_RequestParams::setParams(
                array(
                    'limit_page' => 25,
                    'id' => $shopProductIDs,
                    'sort_by' => array('quantity' => 'desc')
                ),
                FALSE
            );

            $shopProductIDs = Api_Magazine_Shop_Product::stockPeriod(
                NULL, $dateStock, $this->_sitePageData, $this->_driverDB, $shopProductIDs
            );

            $ids = Request_Request::find('DB_Magazine_Shop_Product',
                $this->_sitePageData->shopMainID, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
                array(
                    'unit_id' => array('name'),
                    'shop_product_stock_id' => array('quantity_balance'),
                    'shop_production_id' => array('name', 'id', 'barcode'),
                    'shop_product_rubric_id' => array('name'),
                    'unit_id' => array('name'),
                )
            );

            foreach ($ids->childs as $child){
                Arr::set_path(
                    $child->values,
                    Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_product_stock_id.quantity_balance',
                    Arr::path($shopProductIDs, $child->id, 0)
                );
            }

            $ids->childsSortBy(
                array(
                    Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_product_stock_id.quantity_balance' => 'desc'
                ),
                TRUE, TRUE
            );

            $result = Helpers_View::getViewObjects(
                $ids, new Model_Magazine_Shop_Product(),
                "_shop/product/list/stock", "_shop/product/one/stock",
                $this->_sitePageData, $this->_driverDB, $this->_sitePageData->shopMainID, FALSE
            );
            $this->_sitePageData->replaceDatas['view::_shop/product/list/stock'] = $result;
        }

        $this->_putInMain('/main/_shop/product/stock');
    }

    public function action_json() {
        $this->_sitePageData->url = '/accounting/unit/json';

        $this->_actionJSON(
            'Request_Magazine_Shop_Product',
            'find'
        );
    }

    public function action_find_barcode() {
        $this->_sitePageData->url = '/accounting/shopproduct/find_barcode';

        $params = Request_RequestParams::setParams(
            array(
                'barcode_full' => Request_RequestParams::getParamStr('barcode'),
            )
        );
        if(Request_RequestParams::getParamBoolean('is_stock')) {
            $ids = Request_Request::find('DB_Magazine_Shop_Product',
                $this->_sitePageData->shopMainID, $this->_sitePageData, $this->_driverDB,
                $params, 1, TRUE,
                array(
                    'unit_id' => array('name'),
                    'shop_product_stock_id' => array('quantity_coming', 'quantity_expense'),
                )
            );
        }else{
            $ids = Request_Request::find('DB_Magazine_Shop_Product',
                $this->_sitePageData->shopMainID, $this->_sitePageData, $this->_driverDB,
                $params, 1, TRUE,
                array(
                    'unit_id' => array('name'),
                )
            );
        }

        if(count($ids->childs) == 0){
            $params = Request_RequestParams::setParams(
                array(
                    'barcode_full' => Request_RequestParams::getParamStr('barcode'),
                    'shop_product_id_from' => 0,
                )
            );
            $ids = Request_Request::find('DB_Magazine_Shop_Production',
                $this->_sitePageData->shopMainID, $this->_sitePageData, $this->_driverDB,
                $params, 1, TRUE
            );

            if(count($ids->childs) > 0) {
                $params = Request_RequestParams::setParams(
                    array(
                        'id' => $ids->childs[0]->values['shop_product_id'],
                    )
                );
                if (Request_RequestParams::getParamBoolean('is_stock')) {
                    $ids = Request_Request::find('DB_Magazine_Shop_Product',
                        $this->_sitePageData->shopMainID, $this->_sitePageData, $this->_driverDB,
                        $params, 1, TRUE,
                        array(
                            'unit_id' => array('name'),
                            'shop_product_stock_id' => array('quantity_coming', 'quantity_expense'),
                        )
                    );
                } else {
                    $ids = Request_Request::find('DB_Magazine_Shop_Product',
                        $this->_sitePageData->shopMainID, $this->_sitePageData, $this->_driverDB,
                        $params, 1, TRUE,
                        array(
                            'unit_id' => array('name'),
                        )
                    );
                }
            }
        }

        $result = array(
            'is_find' => count($ids->childs) > 0,
            'values' => array(),
        );
        if($result['is_find']){
            $shopProduct = $ids->childs[0];

            $result['values'] = array(
                'id' => $shopProduct->values['id'],
                'name' => $shopProduct->values['name'],
                'barcode' => $shopProduct->values['barcode'],
                'price' => $shopProduct->values['price_cost'],
                'price_cost' => $shopProduct->values['price_cost'],
                'price_purchase' => $shopProduct->values['price_purchase'],
                'coefficient_revise' => $shopProduct->values['coefficient_revise'],
                'unit' => $shopProduct->getElementValue('unit_id'),
                'image_path' => $shopProduct->values['image_path'],
                'quantity' => floatval($shopProduct->getElementValue('shop_product_stock_id', 'quantity_coming'))
                    - floatval($shopProduct->getElementValue('shop_product_stock_id', 'quantity_expense')),
            );
        }

        $this->response->body(Json::json_encode($result));
    }

    public function action_new()
    {
        $this->_sitePageData->url = '/accounting/shopproduct/new';
        $this->_actionShopProductNew();
    }

    public function action_edit()
    {
        $this->_sitePageData->url = '/accounting/shopproduct/edit';
        $this->_actionShopProductEdit();
    }

    public function action_save_coefficient()
    {
        $this->_sitePageData->url = '/accounting/shopproduct/save_coefficient';

        Api_Magazine_Shop_Product::saveCoefficient($this->_sitePageData, $this->_driverDB);
        echo 'ok'; die;
    }

    public function action_save()
    {
        $this->_sitePageData->url = '/accounting/shopproduct/save';

        $result = Api_Magazine_Shop_Product::save($this->_sitePageData, $this->_driverDB);
        $this->_redirectSaveResult($result);
    }

    /**
     * Дубли штрихкодов продуктов
     */
    public function action_find_doubles()
    {
        $this->_sitePageData->url = '/accounting/shopproduct/find_doubles';

        $shopProduct =  Request_Request::findAll('DB_Magazine_Shop_Product',
            $this->_sitePageData->shopMainID, $this->_sitePageData, $this->_driverDB, 0, TRUE
        );

        $arr = array();
        foreach ($shopProduct->childs as $child){
            $barcode = $child->values['barcode'];
            if(empty($barcode)){
                continue;
            }

            if(key_exists($barcode, $arr)){
                echo $barcode.'<br>';
            }else{
                $arr[$barcode] = '';
            }
        }
        die;
    }

    public function action_calc_stocks()
    {
        $this->_sitePageData->url = '/accounting/shopproduct/calc_stocks';

        $id = Request_RequestParams::getParamInt('shop_product_id');
        if($id > 0){
            $quantityComing = Api_Magazine_Shop_Product::calcComing($id, $this->_sitePageData, $this->_driverDB);
            $quantityExpense = Api_Magazine_Shop_Product::calcExpense($id, $this->_sitePageData, $this->_driverDB);

            $this->response->body(
                json_encode(
                    array(
                        'coming' => $quantityComing,
                        'expense' => $quantityExpense,
                    )
                )
            );
        }else{
            Api_Magazine_Shop_Product::calcStockAll($this->_sitePageData, $this->_driverDB);
            echo 'finish'; die;
        }
    }

    public function action_save_array(){
     /*   $products = Request_Request::find('DB_Magazine_Shop_Product',
            $this->_sitePageData->shopMainID, $this->_sitePageData, $this->_driverDB, array(), 0, TRUE
        );
        foreach ($products->childs as $child){
            $params = Request_RequestParams::setParams(
                array(
                    'name_1c_full' => $child->values['name_1c'],
                )
            );
            $productChilds = Request_Request::find('DB_Magazine_Shop_Product',
                $this->_sitePageData->shopMainID, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE
            );
            if(count($productChilds->childs) < 2){
                continue;
            }

            foreach ($productChilds->childs as $productChild){
                if(empty($productChild->values['barcode'])){
                    $this->_driverDB->deleteObjectIDs(array($productChild->id), $this->_sitePageData->userID,
                        Model_Magazine_Shop_Product::TABLE_NAME, array(), $this->_sitePageData->shopID
                    );
                }
            }
        }
        die;*/



        $arr = array(
            array('barcode' => '48705011', 'name' => '3 Желания Провансаль 67 % верт 100 гр.',),
            array('barcode' => '4870035000926', 'name' => '3 Желания Провансаль 67 % верт 150 гр.',),
            array('barcode' => '4870035006706', 'name' => '3 Желания Провансаль 67% верт 190 гр.',),
            array('barcode' => '4870035007451', 'name' => '3 Желания Провансаль 67% верт 380 гр.',),
            array('barcode' => '4870035007550', 'name' => '3 Желания Провансаль 67% верт 700 гр.',),
            array('barcode' => '4870035007956', 'name' => '3 Желания Провансаль 67% ведро 800 гр.',),
            array('barcode' => '4870035008366', 'name' => '3 Желания Провансаль Классический верт 190 гр.',),
            array('barcode' => '4870035008380', 'name' => '3 Желания Провансаль Классический верт 380 гр.',),
            array('barcode' => '4870035008403', 'name' => '3 Желания Провансаль Классический верт 700 гр.',),
            array('barcode' => '4870035008427', 'name' => '3 Желания Провансаль Классический  ведро 800 гр.',),
            array('barcode' => '4870035007376', 'name' => '3 Желания С зеленью верт 190 гр.',),
            array('barcode' => '4870035007499', 'name' => '3 Желания С зеленью верт 380 гр.',),
            array('barcode' => '4870035007413', 'name' => '3 Желания Парижанка 35% 190 гр.',),
            array('barcode' => '4870035007512', 'name' => '3 Желания Парижанка 35% 380 гр.',),
            array('barcode' => '4870035007598', 'name' => '3 Желания Парижанка 35% 700 гр.',),
            array('barcode' => '4870035007857', 'name' => '3 Желания Парижанка 35% ведро 800 гр.',),
            array('barcode' => '4870035007437', 'name' => '3 Желания Завтрак на траве 190 гр.',),
            array('barcode' => '4870035007536', 'name' => '3 Желания Завтрак на траве 380 гр.',),
            array('barcode' => '4870035007895', 'name' => '3 Желания Завтрак на траве ведро 800 гр.',),
            array('barcode' => '4870035007390', 'name' => '3 Желания Оливковый 67% 190 гр.',),
            array('barcode' => '4870035006874', 'name' => '3 Желания Французский сырный  190 гр.',),
            array('barcode' => '4870035001190', 'name' => 'Майонез "Постный" 57% 190 гр.',),
            array('barcode' => '4870035007635', 'name' => 'Майонез "Провансаль Премиум" 70% 190 гр.',),
            array('barcode' => '4870035001343', 'name' => 'Майонез "Провансаль с лимонным соком"67% 190 гр.',),
            array('barcode' => '4870035001305', 'name' => 'Майонез "Провансаль с лимонным соком"67% 380 гр.',),
            array('barcode' => '4870035007932', 'name' => '3 Желания Экстра 40% ведро 800 гр.',),
            array('barcode' => '4870035007802', 'name' => '3 Желания  Оливьез 67% ведро 800 гр.',),
            array('barcode' => '4870035001138', 'name' => '3 Желания Легкий 40% ведро 800 гр.',),
            array('barcode' => '4870038005508', 'name' => 'Сливочный 180 гр.',),
            array('barcode' => '4870038005546', 'name' => 'Домашний 180 гр.',),
            array('barcode' => '4870038005522', 'name' => 'Пампушка 180 гр.',),
            array('barcode' => '4870038004914', 'name' => 'Плюшкин 180 гр.',),
            array('barcode' => '4870038004655', 'name' => 'Масло к чаю 230 гр.',),
            array('barcode' => '4870038004631', 'name' => 'Крем шоколадный 230 гр.',),
            array('barcode' => '4870038006062', 'name' => 'Пампушка 55% 450 гр.',),
            array('barcode' => '4870038005041', 'name' => 'Златые горы 82%  180 гр.',),
            array('barcode' => '4870038005065', 'name' => 'Элитное 82,5% 180 гр.',),
            array('barcode' => '4870038005027', 'name' => 'Деревенское 72,5% 180 гр.',),
            array('barcode' => '4870038005003', 'name' => 'Закрома 82,5% 180 гр.',),
            array('barcode' => '4870038004969', 'name' => 'Пастушье 72% 180 гр.',),
            array('barcode' => '4870038004945', 'name' => 'Крестьянское новое 180 гр.',),
            array('barcode' => '4870038004983', 'name' => 'Сливочные берега 60% 180 гр.',),
            array('barcode' => '4870038005102', 'name' => 'Шоколадное масло Шоколака 180 гр.',),
            array('barcode' => '4870038004891', 'name' => 'Крестьянское особенное 180 гр.',),
            array('barcode' => '4870038005836', 'name' => 'Масло сливочное "Деревенское"  450 гр.',),
            array('barcode' => '4870038005867', 'name' => 'Станичное особое 72,5% 450 гр.',),
            array('barcode' => '4870038005904', 'name' => 'Крестьянское новое 72,5% 450 гр.',),
            array('barcode' => '4870038005881', 'name' => 'Пастушье 72,5% 450 гр.',),
            array('barcode' => '4870038005676', 'name' => 'Сливочные берега 60% 450 гр.',),
            array('barcode' => '4870038005423', 'name' => 'Шедевр   180 гр.',),
            array('barcode' => '4870038004341', 'name' => 'Шедевр   500 гр.',),
            array('barcode' => '2200653', 'name' => 'Крестьянское  новое 72%  12 кг',),
            array('barcode' => '4870035002517', 'name' => 'Кетчуп Казахстанский 100 гр.',),
            array('barcode' => '4870035002579', 'name' => 'Кетчуп Классический 100 гр.',),
            array('barcode' => '4870035002616', 'name' => 'Кетчуп Чили 100 гр.',),
            array('barcode' => '4870035002654', 'name' => ' Кетчуп Барбекю 100 гр.',),
            array('barcode' => '4870035007239', 'name' => ' Кетчуп Шашлычный  100 гр.',),
            array('barcode' => '4870035007253', 'name' => 'Кетчуп Болгарский сладкий 100 гр.',),
            array('barcode' => '4870035002678', 'name' => 'Кетчуп  Казахстанский 250 гр.',),
            array('barcode' => '4870035002692', 'name' => 'Кетчуп Классический  250 гр.',),
            array('barcode' => '4870035002715', 'name' => ' Кетчуп Чили  250 гр.',),
            array('barcode' => '4870035002739', 'name' => 'Кетчуп Барбекю  250 гр.',),
            array('barcode' => '4870035003484', 'name' => 'Кетчуп Шашлычный  250 гр.',),
            array('barcode' => '4870035005495', 'name' => 'Кетчуп Болгарский сладкий 250 гр.',),
            array('barcode' => '4870035007666', 'name' => 'Кетчуп Казахстанский  450 гр.',),
            array('barcode' => '4870035007673', 'name' => 'Кетчуп Классический 450 гр.',),
            array('barcode' => '4870035007697', 'name' => 'Кетчуп Чили  450 гр.',),
            array('barcode' => '4870035007680', 'name' => ' Кетчуп Шашлычный  450 гр.',),
            array('barcode' => '4870035007710', 'name' => 'Кетчуп Барбекю  450 гр.',),
            array('barcode' => '4870035007703', 'name' => 'Кетчуп Болгарский сладкий 450 гр.',),
            array('barcode' => '4870035004047', 'name' => 'Соус К Шашлыку 250 гр.',),
            array('barcode' => '4870035003989', 'name' => 'Соус К спагетти 250 гр.',),
            array('barcode' => '4870035004023', 'name' => 'Соус Сырный с чесноком 250 гр.',),
            array('barcode' => '4870035004009', 'name' => 'Соус Чесночный 250 гр.',),
            array('barcode' => '4870035005228', 'name' => 'Соус Томатный с базиликом 250 гр.',),
            array('barcode' => '4870035005242', 'name' => 'Соус Итальянский с шампиньонами 250 гр.',),
            array('barcode' => '4870035006768', 'name' => 'Соус Лечо  250 гр.',),
            array('barcode' => '4870035005990', 'name' => 'Соус Карри с манго 250 гр.',),
            array('barcode' => '4870035004061', 'name' => 'Соус Грибной 250 гр.',),
            array('barcode' => '4870035001213', 'name' => 'Соус Тартар 250 гр.',),
            array('barcode' => '4870035000964', 'name' => 'Соус Цезарь 250 гр.',),
            array('barcode' => '4870035006447', 'name' => ' Горчица Заправская 140 гр.',),
            array('barcode' => '48705103', 'name' => ' Горчица Заправская 130 гр.',),
            array('barcode' => '48730976', 'name' => 'Горчица Заправская 70 гр.',),
            array('barcode' => '48740593', 'name' => 'Горчица с хреном 130 гр.',),
            array('barcode' => '48740661', 'name' => 'Горчица с хреном 70 гр.',),
            array('barcode' => '4870035006362', 'name' => 'Хрен  столовый  140 гр.',),
            array('barcode' => '4870035006386', 'name' => 'Хрен  столовый с лимонным соком  140 гр.',),
            array('barcode' => '4870035007000', 'name' => 'Аджика 140 гр.',),
            array('barcode' => '4870035005778', 'name' => 'Молоко сгущенное с сахаром 8,5% 380 гр.',),
            array('barcode' => '4870035008106', 'name' => 'Молоко сгущенное стерилиз. цельное 8,6% 300 гр.',),
            array('barcode' => '4870035001152', 'name' => 'Шедевр  1 л',),
            array('barcode' => '4870035001435', 'name' => 'Шедевр  5 л',),






        );

        $params = Request_RequestParams::setParams(
            array(
                'barcode_full' => '',
                'limit' => 1,
            )
        );

        $model = new Model_Magazine_Shop_Product();
        $model->setDBDriver($this->_driverDB);

        foreach ($arr as $child){
            $child['barcode'] = trim($child['barcode']);
            $child['name'] = trim($child['name']);
            $child['price'] = trim(Arr::path($child, 'price', 0));

            if((empty($child['barcode'])) || (empty($child['name']))){
                continue;
            }

            $params['barcode_full'] = NULL;
            $params['name_1c_full'] = $child['name'];
            $product = Request_Request::find('DB_Magazine_Shop_Product',
                $this->_sitePageData->shopMainID, $this->_sitePageData, $this->_driverDB, $params, 1, TRUE
            );

            if((count($product->childs) > 0) && ((empty($product->childs[0]->values['barcode']))||($product->childs[0]->values['barcode'] == $child['barcode']))){
                $product->childs[0]->setModel($model);
            }else{
                $params['name_1c_full'] = NULL;
                $params['barcode_full'] = $child['barcode'];
                $product = Request_Request::find('DB_Magazine_Shop_Product',
                    $this->_sitePageData->shopMainID, $this->_sitePageData, $this->_driverDB, $params, 1, TRUE
                );
                if(count($product->childs) > 0){
                    $product->childs[0]->setModel($model);
                    $model->setName($child['name']);
                    $model->setName1C($child['name']);
                }else {
                    $model->clear();
                    $model->setName($child['name']);
                    $model->setBarcode($child['barcode']);
                }
            }

            $model->setNames($model->getName());
            $model->setPriceCost(Arr::path($child, 'price', $model->getPriceCost()));

            echo Helpers_DB::saveDBObject($model, $this->_sitePageData, $this->_sitePageData->shopMainID).'<br>';

            // редактируем продукцию, которая напрямую связана с продуктом
            Api_Magazine_Shop_Production::editProduction($model, $this->_sitePageData, $this->_driverDB);
        }



    }
}
