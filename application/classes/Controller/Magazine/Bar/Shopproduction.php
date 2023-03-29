<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Magazine_Bar_ShopProduction extends Controller_Magazine_Bar_BasicMagazine {

    public function __construct(Request $request, Response $response)
    {
        $this->dbObject = 'DB_Magazine_Shop_Production';
        $this->controllerName = 'shopproduction';
        $this->tableID = Model_Magazine_Shop_Production::TABLE_ID;
        $this->tableName = Model_Magazine_Shop_Production::TABLE_NAME;
        $this->objectName = 'production';

        parent::__construct($request, $response);
    }

    public function action_index() {
        $this->_sitePageData->url = '/bar/shopproduction/index';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/production/list/index',
            )
        );

        $this->_requestShopProductionRubrics();

        // получаем список
        View_View::find('DB_Magazine_Shop_Production',
            $this->_sitePageData->shopMainID, "_shop/production/list/index", "_shop/production/one/index",
            $this->_sitePageData, $this->_driverDB, array('limit_page' => 25),
            array(
                'shop_production_rubric_id' => array('name'),
                'unit_id' => array('name'),
                'shop_product_id' => array('name', 'barcode'),
            )
        );

        $this->_putInMain('/main/_shop/production/index');
    }

    public function action_history() {
        $this->_sitePageData->url = '/bar/shopproduction/history';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/production/list/history',
            )
        );

        $this->_requestShopProductions();

        $result = new MyArray();

        $params = Request_RequestParams::setParams(
            array(
                'shop_production_id' => Request_RequestParams::getParamInt('shop_production_id')
            ),
            FALSE
        );

        $operation = Request_RequestParams::getParamArray('operation');

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
                'id' => 'desc',
            ),
            TRUE, TRUE
        );

        $this->_sitePageData->replaceDatas['view::_shop/production/list/history'] = Helpers_View::getViewObjects(
            $result, new Model_Magazine_Shop_Production(),
            "_shop/production/list/history", "_shop/production/one/history",
            $this->_sitePageData, $this->_driverDB, $this->_sitePageData->shopMainID
        );

        $this->_putInMain('/main/_shop/production/history');
    }

    public function action_stock() {
        $this->_sitePageData->url = '/bar/shopproduction/stock';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/production/list/stock',
            )
        );

        $this->_requestShopProductionRubrics();

        $dateStock = Request_RequestParams::getParamDate('date_stock');

        if(empty($dateStock) || $dateStock == date('Y-m-d')) {
            // получаем список
            $params = Request_RequestParams::setParams(
                array(
                    'shop_product_id' => 0,
                    'limit_page' => 25,
                    'sort_by' => array('quantity' => 'desc')
                ),
                FALSE
            );

            View_View::find(
                'DB_Magazine_Shop_Production', $this->_sitePageData->shopMainID,
                "_shop/production/list/stock", "_shop/production/one/stock",
                $this->_sitePageData, $this->_driverDB, $params,
                array(
                    'unit_id' => array('name'),
                    'shop_production_stock_id' => array('quantity_balance'),
                    'shop_production_rubric_id' => array('name'),
                    'unit_id' => array('name'),
                )
            );
        }else{
            // получаем список
            $params = Request_RequestParams::setParams(
                array(
                    'shop_product_id' => 0,
                    'limit_page' => 25,
                    'sort_by' => array('quantity' => 'desc')
                ),
                FALSE
            );

            $shopProductionIDs = Api_Magazine_Shop_Production::stockPeriod(
                NULL, $dateStock, $this->_sitePageData, $this->_driverDB
            );

            $ids = Request_Request::find(
                'DB_Magazine_Shop_Production',
                $this->_sitePageData->shopMainID, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
                array(
                    'unit_id' => array('name'),
                    'shop_production_stock_id' => array('quantity_balance'),
                    'shop_production_rubric_id' => array('name'),
                    'unit_id' => array('name'),
                )
            );

            foreach ($ids->childs as $child){
                Arr::set_path(
                    $child->values,
                    Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_production_stock_id.quantity_balance',
                    Arr::path($shopProductionIDs, $child->id, 0)
                );
            }

            $ids->childsSortBy(
                array(
                    Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_production_stock_id.quantity_balance' => 'desc'
                ),
                TRUE, TRUE
            );

            $result = Helpers_View::getViewObjects(
                $ids, new Model_Magazine_Shop_Production(),
                "_shop/production/list/stock", "_shop/production/one/stock",
                $this->_sitePageData, $this->_driverDB, $this->_sitePageData->shopMainID, FALSE
            );
            $this->_sitePageData->replaceDatas['view::_shop/production/list/stock'] = $result;
        }

        $this->_putInMain('/main/_shop/production/stock');
    }

    public function action_find_barcode() {
        $this->_sitePageData->url = '/bar/shopproduction/find_barcode';

        $params = Request_RequestParams::setParams(
            array(
                'barcode_full' => Request_RequestParams::getParamStr('barcode'),
                'is_special' => Request_RequestParams::getParamBoolean('is_special'),
            )
        );
        $ids = Request_Request::find('DB_Magazine_Shop_Production',
            $this->_sitePageData->shopMainID, $this->_sitePageData, $this->_driverDB,
            $params, 1, TRUE,
            array('unit_id' => array('name'), 'shop_product_id' => array('coefficient_revise', 'price_average'))
        );

        $result = array(
            'is_find' => count($ids->childs) > 0,
            'values' => array(),
        );
        if($result['is_find']){
            $shopProduction = $ids->childs[0];
            $coefficientRevise = $shopProduction->getElementValue('shop_product_id', 'coefficient_revise');
            $coefficient = $shopProduction->values['coefficient'];
            if($coefficient == 0){
                $coefficient = 1;
            }

            $result['values'] = array(
                'id' => $shopProduction->values['id'],
                'name' => $shopProduction->values['name'],
                'barcode' => $shopProduction->values['barcode'],
                'price' => $shopProduction->values['price'],
                'unit' => $shopProduction->getElementValue('unit_id'),
                'price_average' => round($shopProduction->getElementValue('shop_product_id', 'price_average', 0) / $coefficient, 2),
                'image_path' => $shopProduction->values['image_path'],
                'stock' => 0,
            );

            if(!empty($result['values']['image_path'])){
                $result['values']['image_path'] = Helpers_Image::getPhotoPath($result['values']['image_path'], 500, 500);
            }

            // находим остатки
            if($shopProduction->values['shop_product_id'] > 0){
                $ids = Request_Request::find('DB_Magazine_Shop_Product_Stock',
                    $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB,
                    Request_RequestParams::setParams(
                        array(
                            'shop_product_id' => $shopProduction->values['shop_product_id']
                        )
                    ),
                    1, TRUE
                );
            }else{
                $ids = Request_Request::find('DB_Magazine_Shop_Production_Stock',
                    $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB,
                    Request_RequestParams::setParams(
                        array(
                            'shop_production_id' => $shopProduction->id
                        )
                    ),
                    1, TRUE
                );
            }

            if(count($ids->childs) > 0){
                if($coefficientRevise == 0){
                    $coefficientRevise = 1;
                }
                $result['values']['stock'] = round($ids->childs[0]->values['quantity_balance'] * $coefficientRevise, 3);
            }
        }

        $this->response->body(Json::json_encode($result));
    }

    public function action_new()
    {
        $this->_sitePageData->url = '/bar/shopproduction/new';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/production/one/new',
                'view::_shop/production/item/list/index',
            )
        );

        $this->_requestShopProductionRubrics();
        $this->_requestShopProducts(NULL, $this->_sitePageData->shopMainID);
        $this->_requestShopProductions(NULL, $this->_sitePageData->shopMainID);
        $this->_requestUnits();

        $dataID = new MyArray();
        $dataID->id = 0;
        $dataID->isFindDB = TRUE;
        $this->_sitePageData->replaceDatas['view::_shop/production/item/list/index'] =
            Helpers_View::getViewObjects(
                $dataID, new Model_Magazine_Shop_Production_Item(),
                '_shop/production/item/list/index', '_shop/production/item/one/index',
                $this->_sitePageData, $this->_driverDB
            );

        $dataID = new MyArray();
        $dataID->id = 0;
        $dataID->isFindDB = TRUE;

        $this->_sitePageData->replaceDatas['view::_shop/production/one/new'] = Helpers_View::getViewObject(
            $dataID, new Model_Magazine_Shop_Production(),
            '_shop/production/one/new', $this->_sitePageData, $this->_driverDB, $this->_sitePageData->shopMainID
        );

        $this->_putInMain('/main/_shop/production/new');
    }

    public function action_edit()
    {
        $this->_sitePageData->url = '/bar/shopproduction/edit';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/production/one/edit',
                'view::_shop/production/item/list/index',
            )
        );

        // id записи
        $id = Request_RequestParams::getParamInt('id');
        $model = new Model_Magazine_Shop_Production();
        if (! $this->dublicateObjectLanguage($model, $id, $this->_sitePageData->shopMainID, FALSE)) {
            throw new HTTP_Exception_404('Production not is found!');
        }

        $this->_requestShopProductionRubrics($model->getShopProductionRubricID());
        $this->_requestShopProducts(NULL, $this->_sitePageData->shopMainID);
        $this->_requestShopProductions(NULL, $this->_sitePageData->shopMainID, NULL, $model->id);
        $this->_requestUnits($model->getUnitID());

        $params = Request_RequestParams::setParams(
            array(
                'root_id' => $id,
                'sort_by' => array('id' => 'asc')
            )
        );
        $this->_sitePageData->replaceDatas['view::_shop/production/item/list/index'] =
            View_View::find('DB_Magazine_Shop_Production_Item',
                $this->_sitePageData->shopMainID, '_shop/production/item/list/index', '_shop/production/item/one/index',
                $this->_sitePageData, $this->_driverDB, $params
            );

        // получаем данные
        View_View::findOne('DB_Magazine_Shop_Production', $this->_sitePageData->shopMainID, "_shop/production/one/edit",
            $this->_sitePageData, $this->_driverDB, array('id' => $id));

        $this->_putInMain('/main/_shop/production/edit');
    }

    public function action_save_coefficient()
    {
        $this->_sitePageData->url = '/bar/shopproduction/save_coefficient';

        Api_Magazine_Shop_Production::saveCoefficient($this->_sitePageData, $this->_driverDB);
        echo 'ok'; die;
    }

    public function action_save()
    {
        $this->_sitePageData->url = '/bar/shopproduction/save';

        $result = Api_Magazine_Shop_Production::save($this->_sitePageData, $this->_driverDB);
        $this->_redirectSaveResult($result);
    }

    public function action_add_image() {
        $this->_sitePageData->url = '/bar/shopproduction/add_image';

        $shopProductID = intval(Request_RequestParams::getParamInt('shop_product_id'));
        if($shopProductID < 1){
            throw new HTTP_Exception_404('Product not is found!');
        }

        $shopProductionIDs = Request_Request::find('DB_Magazine_Shop_Production',
            $this->_sitePageData->shopMainID, $this->_sitePageData, $this->_driverDB,
            Request_RequestParams::setParams(
                array(
                    'shop_product_id' => $shopProductID,
                )
            ),
            0, TRUE
        );

        if(count($shopProductionIDs->childs) == 0){
            throw new HTTP_Exception_404('Production not is found!');
        }
        $filePath = Helpers_File::loadImage($this->_sitePageData, FALSE);
        $filePath = array(
            'tmp_name' => DOCROOT . 'tmp_files' . DIRECTORY_SEPARATOR . $filePath['file'],
            'name' => $filePath['file_name'],
        );

        // загружаем картинку к продукту
        $model = new Model_Magazine_Shop_Product();
        $model->setDBDriver($this->_driverDB);
        if(!$this->getDBObject($model, $shopProductID)){
            throw new HTTP_Exception_404('Product not is found!');
        }

        $file = new Model_File($this->_sitePageData);
        $file->isDeleteFile = FALSE;
        // загружаем фотографии
        $file->addImageInModel($filePath, $model, $this->_sitePageData, $this->_driverDB);
        Helpers_DB::saveDBObject($model, $this->_sitePageData);

        $model = new Model_Magazine_Shop_Production();
        $model->setDBDriver($this->_driverDB);
        foreach ($shopProductionIDs->childs as $child) {
            $child->setModel($model);

            // загружаем фотографии
            $file->addImageInModel($filePath, $model, $this->_sitePageData, $this->_driverDB);

            Helpers_DB::saveDBObject($model, $this->_sitePageData);
        }

        unlink($filePath['tmp_name']);

        exit();
    }

    /**
     * Дубли штрихкодов продуктов
     */
    public function action_find_doubles()
    {
        $this->_sitePageData->url = '/bar/shopproduction/find_doubles';

        $shopProduction =  Request_Request::findAll('DB_Magazine_Shop_Production',
            $this->_sitePageData->shopMainID, $this->_sitePageData, $this->_driverDB, 0, TRUE
        );

        $arr = array();
        foreach ($shopProduction->childs as $child){
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

    /**
     * Пересчитываем остатки
     */
    public function action_calc_stocks()
    {
        $this->_sitePageData->url = '/bar/shopproduction/calc_stocks';

        $id = Request_RequestParams::getParamInt('shop_production_id');
        if($id > 0){
            $quantityComing = Api_Magazine_Shop_Production::calcComing($id, $this->_sitePageData, $this->_driverDB);
            $quantityExpense = Api_Magazine_Shop_Production::calcExpense($id, $this->_sitePageData, $this->_driverDB);

            $this->response->body(
                json_encode(
                    array(
                        'coming' => $quantityComing,
                        'expense' => $quantityExpense,
                    )
                )
            );
        }else{
            Api_Magazine_Shop_Production::calcStockAll($this->_sitePageData, $this->_driverDB);
            echo 'finish'; die;
        }
    }
}
