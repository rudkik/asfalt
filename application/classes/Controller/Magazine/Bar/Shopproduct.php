<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Magazine_Bar_ShopProduct extends Controller_Magazine_Bar_BasicMagazine {

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
        $this->_sitePageData->url = '/bar/shopproduct/index';

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
        $this->_sitePageData->url = '/bar/shopproduct/history';

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
                'shop_product_id' => Request_RequestParams::getParamInt('shop_product_id')
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
        $this->_sitePageData->url = '/bar/shopproduct/stock';

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
        $this->_sitePageData->url = '/bar/unit/json';

        $this->_actionJSON(
            'Request_Magazine_Shop_Product',
            'find'
        );
    }

    public function action_find_barcode() {
        $this->_sitePageData->url = '/bar/shopproduct/find_barcode';

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
                    'shop_product_stock_id' => array('quantity_coming', 'quantity_expense'),
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
                'price_average' => $shopProduct->values['price_average'],
                'price_cost' => $shopProduct->values['price_cost'],
                'price_purchase' => $shopProduct->values['price_purchase'],
                'coefficient_revise' => $shopProduct->values['coefficient_revise'],
                'unit' => $shopProduct->getElementValue('unit_id'),
                'image_path' => $shopProduct->values['image_path'],
                'quantity' => floatval($shopProduct->getElementValue('shop_product_stock_id', 'quantity_coming'))
                    - floatval($shopProduct->getElementValue('shop_product_stock_id', 'quantity_expense')) ,
            );
        }

        $this->response->body(Json::json_encode($result));
    }

    public function action_new()
    {
        $this->_sitePageData->url = '/bar/shopproduct/new';
        $this->_actionShopProductNew();
    }

    public function action_edit()
    {
        $this->_sitePageData->url = '/bar/shopproduct/edit';
        $this->_actionShopProductEdit();
    }

    public function action_save()
    {
        $this->_sitePageData->url = '/bar/shopproduct/save';

        $result = Api_Magazine_Shop_Product::save($this->_sitePageData, $this->_driverDB);
        $this->_redirectSaveResult($result);
    }

    /**
     * Дубли штрихкодов продуктов
     */
    public function action_find_doubles()
    {
        $this->_sitePageData->url = '/bar/shopproduct/find_doubles';

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
        $this->_sitePageData->url = '/bar/shopproduct/calc_stocks';

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

    public function action_calc_price_average_all()
    {
        $this->_sitePageData->url = '/bar/shopproduct/calc_price_average_all';

        Api_Magazine_Shop_Product::calcPriceAverageAll($this->_sitePageData, $this->_driverDB);
        echo 'finish'; die;
    }
}
