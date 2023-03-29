<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_Atc_ShopTransportWaybill extends Controller_Ab1_Atc_BasicAb1 {

    public function __construct(Request $request, Response $response)
    {
        $this->dbObject = 'DB_Ab1_Shop_Transport_Waybill';
        $this->controllerName = 'shoptransportwaybill';
        $this->tableID = Model_Ab1_Shop_Transport_Waybill::TABLE_ID;
        $this->tableName = Model_Ab1_Shop_Transport_Waybill::TABLE_NAME;
        $this->objectName = 'transportwaybill';

        parent::__construct($request, $response);
        $this->editAndNewBasicTemplate = 'ab1/_all';
    }

    public function action_index() {
        $this->_sitePageData->url = '/atc/shoptransportwaybill/index';

        $this->_requestListDB('DB_Ab1_Shop_Transport_Driver');
        $this->_requestShopTransports();
        $this->_requestShopBranches($this->_sitePageData->shopID, true);

        parent::_actionIndex(
            array(
                'shop_transport_id' => array('name', 'number'),
                'shop_transport_driver_id' => array('name'),
                'create_user_id' => array('name'),
                'update_user_id' => array('name'),
                'transport_wage_id' => array('name'),
                'transport_view_id' => array('name'),
                'transport_work_id' => array('name'),
                'transport_form_payment_id' => array('name'),
                'shop_subdivision_id' => array('name'),
            ),
            array(
                'sort_by' => array(
                    'date' => 'desc',
                )
            )
        );
    }

    public function action_work() {
        $this->_sitePageData->url = '/atc/shoptransportwaybill/work';

        $dateFrom = Request_RequestParams::getParamDate('date_from');
        $dateTo = Request_RequestParams::getParamDate('date_to');

        $drivers = Api_Ab1_Shop_Transport_Waybill::getDriverTransportWorkValues(
            $dateFrom, $dateTo, $this->_sitePageData, $this->_driverDB
        );
        $drivers['drivers']->additionDatas['works'] = $drivers['works'];
        $drivers['drivers']->runRoot();

        Helpers_View::getViews(
            '_shop/transport/waybill/list/work', '_shop/transport/waybill/one/work',
            $this->_sitePageData, $this->_driverDB, $drivers['drivers'], TRUE
        );

        $this->_putInMain('/main/_shop/transport/waybill/work');
    }

    public function action_new(){
        $this->_sitePageData->url = '/atc/shoptransportwaybill/new';

        $this->_requestShopBranches(null, true);
        $this->_requestListDB('DB_Ab1_Shop_Transport_Route');
        $this->_requestListDB('DB_Ab1_Shop_Worker');
        $this->_requestListDB('DB_Ab1_Shop_Transport_Driver');
        $this->_requestListDB('DB_Ab1_Fuel');
        $this->_requestListDB('DB_Ab1_Fuel_Issue');
        $this->_requestShopListDB(DB_Ab1_Shop_Subdivision::NAME, [442007, 442662, 442661]);
        $this->_requestShopTransports(null, false);
        $this->_requestShopTransports(null, true, 'trailer');

        $this->_sitePageData->newShopShablonPath($this->editAndNewBasicTemplate);
        // выработки транспорта
        Helpers_View::getViews(
            '_shop/transport/waybill/work/car/list/index', '_shop/transport/waybill/work/car/one/index',
            $this->_sitePageData, $this->_driverDB
        );

        // выработки водителей
        View_View::find(
            'DB_Ab1_Shop_Transport_Work', $this->_sitePageData->shopMainID,
            "_shop/transport/waybill/work/driver/list/index", "_shop/transport/waybill/work/driver/one/index",
            $this->_sitePageData, $this->_driverDB,
            Request_RequestParams::setParams(
                array(
                    'is_driver' => true,
                    'sort_by' => array('name' => 'asc')
                )
            )
        );
        $this->_sitePageData->previousShopShablonPath();

        parent::action_new();
    }

    public function action_edit()
    {
        $this->_sitePageData->url = '/atc/shoptransportwaybill/edit';

        // id записи
        $id = Request_RequestParams::getParamInt('id');
        $model = new Model_Ab1_Shop_Transport_Waybill();
        if (! $this->dublicateObjectLanguage($model, $id, $this->_sitePageData->shopID, false)) {
            throw new HTTP_Exception_404('Object "' . $this->dbObject . '" not is found!');
        }

        $this->_requestShopBranches(null, true);
        $this->_requestListDB('DB_Ab1_Shop_Transport_Route');
        $this->_requestListDB('DB_Ab1_Shop_Worker');
        $this->_requestListDB('DB_Ab1_Shop_Transport_Driver', $model->getShopTransportDriverID());
        $this->_requestListDB('DB_Ab1_Fuel');
        $this->_requestListDB('DB_Ab1_Fuel_Issue');
        $this->_requestShopListDB(DB_Ab1_Shop_Subdivision::NAME, $model->getShopSubdivisionID());

        $this->_requestListDB('DB_Ab1_Transport_View', $model->getTransportViewID());
        $this->_requestListDB('DB_Ab1_Transport_Work', $model->getTransportWorkID());
        $this->_requestListDB('DB_Ab1_Transport_Wage', $model->getTransportWageID());
        $this->_requestListDB('DB_Ab1_Transport_FormPayment', $model->getTransportFormPaymentID());

        $this->_requestShopTransports($model->getShopTransportID(), false);
        $this->_requestShopTransports(null, true, 'trailer');

        $this->_sitePageData->newShopShablonPath($this->editAndNewBasicTemplate);
        // выработки транспорта
        Helpers_View::getViews(
            '_shop/transport/waybill/transport/list/index', '_shop/transport/waybill/transport/one/index',
            $this->_sitePageData, $this->_driverDB
        );

        // выработки водителя
        $params = Request_RequestParams::setParams(
            array(
                'shop_transport_waybill_id' => $id,
                'sort_by' => array(
                    'shop_transport_work_id.name' => 'asc',
                ),
            )
        );
        View_View::find(
            DB_Ab1_Shop_Transport_Waybill_Work_Driver::NAME, $this->_sitePageData->shopID,
            '_shop/transport/waybill/work/driver/list/index', '_shop/transport/waybill/work/driver/one/index',
            $this->_sitePageData, $this->_driverDB, $params,
            array(
                'shop_transport_work_id' => array('name', 'indicator_type_id'),
            )
        );

        // перевозки
        $params = Request_RequestParams::setParams(
            array(
                'shop_transport_waybill_id' => $id,
                'sort_by' => array(
                    'created_at' => 'asc',
                ),
            )
        );
        View_View::find(
            DB_Ab1_Shop_Transport_Waybill_Car::NAME, $this->_sitePageData->shopID,
            '_shop/transport/waybill/car/list/index', '_shop/transport/waybill/car/one/index',
            $this->_sitePageData, $this->_driverDB, $params,
            array(
                'shop_client_to_id' => array('name'),
                'shop_daughter_from_id' => array('name'),
                'shop_branch_to_id' => array('name'),
                'shop_branch_from_id' => array('name'),
                'shop_ballast_crusher_to_id' => array('name'),
                'shop_ballast_crusher_from_id' => array('name'),
                'shop_transportation_place_to_id' => array('name'),
                'shop_transport_route_id' => array('name'),
                'shop_material_id' => array('name'),
                'shop_raw_id' => array('name'),
                'shop_product_id' => array('name'),
                'shop_material_other_id' => array('name'),
                'shop_move_place_to_id' => array('name'),
                'shop_move_client_to_id' => array('name'),
                'shop_storage_to_id' => array('name'),
            )
        );
        $this->_sitePageData->previousShopShablonPath();

        $this->_actionEdit($model, $this->_sitePageData->shopID);
    }

    public function action_duplicate()
    {
        $this->_sitePageData->url = '/atc/shoptransportwaybill/duplicate';

        // id записи
        $id = Request_RequestParams::getParamInt('id');
        $model = new Model_Ab1_Shop_Transport_Waybill();
        if (! $this->dublicateObjectLanguage($model, $id, $this->_sitePageData->shopID, false)) {
            throw new HTTP_Exception_404('Object "' . $this->dbObject . '" not is found!');
        }

        $this->_requestShopBranches(null, true);
        $this->_requestListDB('DB_Ab1_Shop_Transport_Route');
        $this->_requestListDB('DB_Ab1_Shop_Worker');
        $this->_requestListDB('DB_Ab1_Shop_Transport_Driver', $model->getShopTransportDriverID());
        $this->_requestListDB('DB_Ab1_Fuel');
        $this->_requestListDB('DB_Ab1_Fuel_Issue');
        $this->_requestShopListDB(DB_Ab1_Shop_Subdivision::NAME, $model->getShopSubdivisionID());

        $this->_requestShopTransports($model->getShopTransportID(), false);
        $this->_requestShopTransports(null, true, 'trailer');

        $this->_sitePageData->newShopShablonPath($this->editAndNewBasicTemplate);
        // выработки транспорта
        Helpers_View::getViews(
            '_shop/transport/waybill/work/car/list/index', '_shop/transport/waybill/work/car/one/index',
            $this->_sitePageData, $this->_driverDB
        );

        // выработки водителей
        View_View::find(
            'DB_Ab1_Shop_Transport_Work', $this->_sitePageData->shopMainID,
            "_shop/transport/waybill/work/driver/list/index", "_shop/transport/waybill/work/driver/one/index",
            $this->_sitePageData, $this->_driverDB,
            Request_RequestParams::setParams(array('sort_by' => array('name' => 'asc')))
        );

        // прицепы
        View_View::find(
            DB_Ab1_Shop_Transport_Waybill_Trailer::NAME, $this->_sitePageData->shopID,
            "_shop/transport/waybill/trailer/list/index", "_shop/transport/waybill/trailer/one/index",
            $this->_sitePageData, $this->_driverDB,
            Request_RequestParams::setParams(
                array(
                    'shop_transport_waybill_id' => $id,
                    'sort_by' => array('id' => 'asc'),
                )
            )
        );
        $this->_sitePageData->previousShopShablonPath();

        $this->_actionNew($model, $this->_sitePageData->shopID);
    }

    public function action_save()
    {
        $this->_sitePageData->url = '/atc/shoptransportwaybill/save';

        $shopID = $this->shopID;
        if($shopID < 1){
            $shopID = $this->_sitePageData->shopID;
        }

        $result = DB_Basic::save($this->dbObject, $shopID, $this->_sitePageData, $this->_driverDB);
        $model = $result['model'];

        if(Request_RequestParams::getParamBoolean('is_duplicate')){
            $this->redirect('/atc/shoptransportwaybill/duplicate?id='.$model->id);
        }else {
            $this->_redirectSaveResult($result);
        }
    }

    public function action_get_finish_date(){
        $this->_sitePageData->url = '/atc/shoptransportwaybill/get_finish_date';

        $shopTransportWaybillID = Request_RequestParams::getParamInt('id');
        $result = Api_Ab1_Shop_Transport_Waybill::getFinishDate($shopTransportWaybillID,$this->_sitePageData, $this->_driverDB);

        $this->response->body(Helpers_DateTime::getDateTimeFormatRus($result));
    }

    public function action_refresh_cars(){
        $this->_sitePageData->url = '/atc/shoptransportwaybill/refresh_cars';

        $shopTransportWaybillID = Request_RequestParams::getParamInt('shop_transport_waybill_id');
        $shopTransportID = Request_RequestParams::getParamInt('shop_transport_id');

        $model = new Model_Ab1_Shop_Transport_Waybill();
        $model->setDBDriver($this->_driverDB);

        if (! Helpers_DB::getDBObject($model, $shopTransportWaybillID, $this->_sitePageData)) {
            throw new HTTP_Exception_404('Waybill id="' . $shopTransportWaybillID . '" not is found!');
        }

        $trailer = Api_Ab1_Shop_Transport_Waybill::getTrailerByWaybill(
            $model->id, $this->_sitePageData, $this->_driverDB
        );
        $trailerShopTransportID = $trailer['transport'];

        Api_Ab1_Shop_Transport_Waybill::refreshCars(
            $shopTransportWaybillID,
            $shopTransportID,
            $trailerShopTransportID,
            $model->getShopTransportDriverID(),
            Request_RequestParams::getParamDateTime('date_from'),
            Request_RequestParams::getParamDateTime('date_to'),
            $this->_sitePageData, $this->_driverDB
        );

        // Считаем выработки водителя зависящие от перевозок
        Api_Ab1_Shop_Transport_Waybill::calcDriverWorks(
            $model, $this->_sitePageData, $this->_driverDB
        );

        $params = Request_RequestParams::setParams(
            array(
                'shop_transport_waybill_id' => $shopTransportWaybillID,
            )
        );

        $this->_sitePageData->newShopShablonPath($this->editAndNewBasicTemplate);
        $waybillCar = View_View::find(
            DB_Ab1_Shop_Transport_Waybill_Car::NAME, $this->_sitePageData->shopID,
            '_shop/transport/waybill/car/list/index-not-table', '_shop/transport/waybill/car/one/index',
            $this->_sitePageData, $this->_driverDB, $params,
            array(
                'shop_client_to_id' => array('name'),
                'shop_daughter_from_id' => array('name'),
                'shop_branch_to_id' => array('name'),
                'shop_branch_from_id' => array('name'),
                'shop_ballast_crusher_to_id' => array('name'),
                'shop_ballast_crusher_from_id' => array('name'),
                'shop_transportation_place_to_id' => array('name'),
                'shop_transport_route_id' => array('name'),
                'shop_material_id' => array('name'),
                'shop_raw_id' => array('name'),
                'shop_product_id' => array('name'),
                'shop_material_other_id' => array('name'),
                'shop_move_place_to_id' => array('name'),
            )
        );

        // выработки водителя
        $params = Request_RequestParams::setParams(
            array(
                'shop_transport_waybill_id' => $shopTransportWaybillID,
                'sort_by' => array(
                    'shop_transport_work_id.name' => 'asc',
                ),
            )
        );
        $waybillWorkDriver = View_View::find(
            DB_Ab1_Shop_Transport_Waybill_Work_Driver::NAME, $this->_sitePageData->shopID,
            '_shop/transport/waybill/work/driver/list/index-no-table', '_shop/transport/waybill/work/driver/one/index',
            $this->_sitePageData, $this->_driverDB, $params,
            array(
                'shop_transport_work_id' => array('name', 'indicator_type_id'),
            )
        );
        $this->_sitePageData->previousShopShablonPath();

        $this->response->body(
            Json::json_encode(
                array(
                    'cars' => $waybillCar,
                    'work_drivers' => $waybillWorkDriver,
                )
            )
        );
    }

    public function action_calc_fuel(){
        $this->_sitePageData->url = '/atc/shoptransportwaybill/calc_fuel';

        $shopTransportWaybillID = Request_RequestParams::getParamInt('id');

        $model = new Model_Ab1_Shop_Transport_Waybill();
        $model->setDBDriver($this->_driverDB);

        if (! Helpers_DB::getDBObject($model, $shopTransportWaybillID, $this->_sitePageData)) {
            throw new HTTP_Exception_404('Waybill id="' . $shopTransportWaybillID . '" not is found!');
        }

        // остатки топлива
        $balanceFuels = Api_Ab1_Shop_Transport::getTransportBalanceFuels(
            $model->getShopTransportID(), $this->_sitePageData, $this->_driverDB, true
        );

        $result = array();
        foreach ($balanceFuels  as $data){
            $fuelTypeID = $data['fuel_type_id'];

            // получаем формулу расчета гсм
            $params = Request_RequestParams::setParams(
                array(
                    'shop_transport_id' => $model->getShopTransportID(),
                    'fuel_type_id' => $fuelTypeID,
                )
            );
            $formulas = Request_Request::find(
                DB_Ab1_Shop_Transport_To_Fuel::NAME, 0, $this->_sitePageData, $this->_driverDB, $params,
                0, true,
                array(
                    'shop_transport_indicator_formula_id' => array('formula'),
                )
            );

            foreach ($formulas->childs as $formula) {
                $formula = $formula->getElementValue('shop_transport_indicator_formula_id', 'formula');
                if (empty($formula)) {
                    continue;
                }

                $quantity = Api_Ab1_Shop_Transport::calcFormulaFuels(
                    $model->getDate(), $shopTransportWaybillID, $model->getShopTransportID(), $formula, $this->_sitePageData, $this->_driverDB
                );

                if(!key_exists($fuelTypeID, $result)){
                    $result[$fuelTypeID] = array(
                        'fuel_type_id' => $fuelTypeID,
                        'fuel_id' => $data['fuel_id'],
                        'quantity_norm' => 0,
                    );
                }

                $result[$fuelTypeID]['quantity_norm'] = round($quantity, 3);
            }
        }

        $result = array_values($result);
        $this->response->body(Json::json_encode($result));
    }

    public function action_car_works() {
        $this->_sitePageData->url = '/atc/shoptransportwaybill/car_works';

        // id записи
        $shopTransportID = Request_RequestParams::getParamInt('shop_transport_id');
        $shopTransportWaybillID = Request_RequestParams::getParamInt('id');
        $trailers = Request_RequestParams::getParamArray('trailers', array(), array());

        $shopTransportIDs = array_merge(
            array($shopTransportID),
            $trailers
        );

        $this->_sitePageData->newShopShablonPath($this->editAndNewBasicTemplate);
        $waybillCar = '';
        foreach ($shopTransportIDs as $transportID) {
            $transportID = intval($transportID);
            if($transportID < 1){
                continue;
            }

            $model = new Model_Ab1_Shop_Transport();
            $model->setDBDriver($this->_driverDB);
            if (! Helpers_DB::getDBObject($model, $transportID, $this->_sitePageData, $this->_sitePageData->shopMainID)) {
                throw new HTTP_Exception_404('Transport id="' . $transportID . '" not is found!');
            }

            $workIDs = new MyArray();
            if ($shopTransportWaybillID > 0) {
                $params = Request_RequestParams::setParams(
                    array(
                        'shop_transport_waybill_id' => $shopTransportWaybillID,
                        'shop_transport_id' => $transportID,
                        'sort_by' => array(
                            'shop_transport_work_id.name' => 'asc'
                        )
                    )
                );
                $workIDs = Request_Request::find(
                    'DB_Ab1_Shop_Transport_Waybill_Work_Car', $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB,
                    $params, 0, true,
                    array(
                        'shop_transport_work_id' => array('name', 'indicator_type_id')
                    )
                );
            }

            if(count($workIDs->childs) < 1){
                $params = Request_RequestParams::setParams(
                    array(
                        'shop_transport_id' => $transportID,
                        'sort_by' => array(
                            'shop_transport_work_id.name' => 'asc'
                        ),
                    )
                );
                $workIDs = Request_Request::find(
                    'DB_Ab1_Shop_Transport_To_Work', $this->_sitePageData->shopMainID, $this->_sitePageData, $this->_driverDB,
                    $params, 0, true,
                    array(
                        'shop_transport_work_id' => array('name', 'indicator_type_id')
                    )
                );
            }

            // выработки транспорта
            $workIDs->additionDatas['transport'] = $model->getValues(true, true);
            $waybillCar .= Helpers_View::getViews(
                '_shop/transport/waybill/work/car/list/index-no-table',
                '_shop/transport/waybill/work/car/one/index',
                $this->_sitePageData, $this->_driverDB, $workIDs
            );
        }
        $this->_sitePageData->previousShopShablonPath();

        // выработки водителя
        $trailers[] = $shopTransportID;
        foreach ($trailers as $trailer) {
            $params = Request_RequestParams::setParams(
                array(
                    'shop_transport_id' => $trailer,
                    'sort_by' => array(
                        'shop_transport_work_id.name' => 'asc',
                    ),
                )
            );
            $ids = Request_Request::find(
                'DB_Ab1_Shop_Transport_To_Work_Driver', $this->_sitePageData->shopMainID,
                $this->_sitePageData, $this->_driverDB, $params, 0, true,
                array(
                    'shop_transport_work_id' => array('name', 'indicator_type_id'),
                )
            );

            if(count($ids->childs) > 0){
                break;
            }
        }

        if($shopTransportWaybillID > 0) {
            $params = Request_RequestParams::setParams(
                array(
                    'shop_transport_waybill_id' => $shopTransportWaybillID,
                    'sort_by' => array(
                        'shop_transport_work_id.name' => 'asc',
                    ),
                )
            );
            $waybillWorkDriverIDs = Request_Request::find(
                'DB_Ab1_Shop_Transport_Waybill_Work_Driver', $this->_sitePageData->shopID,
                $this->_sitePageData, $this->_driverDB, $params, 0, true,
                array(
                    'shop_transport_work_id' => array('name', 'indicator_type_id'),
                )
            );

            // передаем заполненные данные
            foreach ($waybillWorkDriverIDs->childs as $child) {
                $workID = $child->values['shop_transport_work_id'];

                $isFind = false;
                foreach ($ids->childs as $work) {
                    if ($work->values['shop_transport_work_id'] == $workID) {
                        $work->values['quantity'] = $child->values['quantity'];
                        $isFind = true;
                        break;
                    }
                }

                if (!$isFind) {
                    $ids->childs[] = $child;
                }
            }
        }
        $ids->childsSortBy(
            array(
                'shop_transport_work_id.name' => 'asc',
            ),
            true, true
        );

        $this->_sitePageData->newShopShablonPath($this->editAndNewBasicTemplate);
        $waybillWorkDriver = Helpers_View::getViews(
            '_shop/transport/waybill/work/driver/list/index-no-table', '_shop/transport/waybill/work/driver/one/index',
            $this->_sitePageData, $this->_driverDB, $ids
        );
        $this->_sitePageData->previousShopShablonPath();

        $this->response->body(
            Json::json_encode(
                array(
                    'cars' => $waybillCar,
                    'work_drivers' => $waybillWorkDriver,
                )
            )
        );
    }
}

