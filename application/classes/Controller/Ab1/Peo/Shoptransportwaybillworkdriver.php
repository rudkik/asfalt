<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_Peo_ShopTransportWaybillWorkDriver extends Controller_Ab1_Peo_BasicAb1 {

    public function __construct(Request $request, Response $response)
    {
        $this->dbObject = 'DB_Ab1_Shop_Transport_Waybill_Work_Driver';
        $this->controllerName = 'shoptransportwaybillworkdriver';
        $this->tableID = Model_Ab1_Shop_Transport_Waybill_Work_Driver::TABLE_ID;
        $this->tableName = Model_Ab1_Shop_Transport_Waybill_Work_Driver::TABLE_NAME;
        $this->objectName = 'transportwaybillworkdriver';

        parent::__construct($request, $response);
    }

    public function action_index() {
        $this->_sitePageData->url = '/peo/shoptransportwaybillworkdriver/index';

        $this->_requestListDB('DB_Ab1_Shop_Transport_Driver');
        $this->_requestListDB('DB_Ab1_Shop_Transport_Work');
        $this->_requestShopTransports();

        View_View::find(
            'DB_Ab1_Shop_Transport_Waybill_Work_Driver', $this->_sitePageData->shopID,
            '_shop/transport/waybill/work/driver/list/total', '_shop/transport/waybill/work/driver/one/total',
            $this->_sitePageData, $this->_driverDB,
            Request_RequestParams::setParams(
                array_merge(
                    $_GET,
                    $_POST,
                    [
                        'quantity_from' => 0,
                        'sum_quantity' => true,
                        'sort_by' => null,
                    ]
                )
            )
        );

        parent::_actionIndex(
            array(
                'shop_transport_waybill_id' => array('number', 'date'),
                'shop_transport_waybill_id.shop_transport_id' => array('name', 'number'),
                'shop_transport_driver_id' => array('name'),
                'shop_transport_work_id' => array('name'),
            ),
            array(
                'quantity_from' => 0,
                'sort_by' => array(
                    'shop_transport_waybill_id.date' => 'asc',
                )
            )
        );
    }

    public function action_work() {
        $this->_sitePageData->url = '/peo/shoptransportwaybillworkdriver/work';

        $dateFrom = Request_RequestParams::getParamDate('shop_transport_waybill_id/to_at_from_equally');
        $dateTo = Request_RequestParams::getParamDate('shop_transport_waybill_id/to_at_to');
        $shopTransportDriverID = Request_RequestParams::getParamInt('shop_transport_driver_id');

        $this->_requestListDB('DB_Ab1_Shop_Transport_Driver');
        $this->_requestShopTransports();

        if($shopTransportDriverID > 0 || !empty($dateFrom)) {
            // получаем список выработок по видам работ
            $transportWorkIDs = Request_Request::find(
                DB_Ab1_Transport_Work::NAME, $this->_sitePageData->shopID,
                $this->_sitePageData, $this->_driverDB,
                Request_RequestParams::setParams(
                    [
                        'shop_transport_work_ids_empty' => false,
                    ]
                ),
                0, true
            );

            $works = [];
            $transportWorks = [];
            $model = new Model_Ab1_Transport_Work();
            foreach ($transportWorkIDs->childs as $child) {
                $child->setModel($model);

                $list = $model->getShopTransportWorkIDsArray();
                foreach ($list as $one) {
                    $works[$one] = $one;
                }

                $transportWorks[$model->id] = [];
                foreach ($list as $one) {
                    $transportWorks[$model->id][$one] = $one;
                }
            }

            $params = array_merge($_POST, $_GET);

            unset($params['limit_page']);
            unset($params['limit']);
            if (key_exists('shop_transport_waybill_id/to_at_to', $params)) {
                $params['shop_transport_waybill_id/to_at_to'] = Helpers_DateTime::getDateFormatPHP($params['shop_transport_waybill_id/to_at_to']) . ' 23:59:59';
            }

            if (!key_exists('sort_by', $params)) {
                $params['sort_by'] = [
                    'shop_transport_waybill_id.to_at' => 'asc',
                ];
            }

            // праздничные и выходные дни
            $holidays = Api_Ab1_Holiday::getHolidays($dateFrom, $dateTo, $this->_sitePageData, $this->_driverDB, true);

            $result = new MyArray();
            $result->additionDatas['work_quantities'] = [];
            $waybillWorks = [];

            /***********************************/
            // получаем выработок путевых листов
            $ids = Request_Request::find(
                'DB_Ab1_Shop_Transport_Waybill_Work_Driver', $this->_sitePageData->shopID,
                $this->_sitePageData, $this->_driverDB,
                Request_RequestParams::setParams(
                    array_merge(
                        $params,
                        [
                            'shop_transport_work_id' => $works,
                            'quantity_from' => 0,
                        ]
                    )
                ),
                0, true,
                [
                    'shop_transport_waybill_id' => array('id', 'date', 'from_at', 'to_at', 'number', 'transport_work_id'),
                    'shop_transport_waybill_id.shop_transport_id' => array('name', 'number'),
                    'shop_transport_waybill_id.transport_work_id' => array('name'),
                ]
            );

            foreach ($ids->childs as $child) {
                $waybill = $child->getElementValue('shop_transport_waybill_id', 'id', 0);
                if (!key_exists($waybill, $result->childs)) {
                    $result->childs[$waybill] = $child;
                    $result->childs[$waybill]->additionDatas['work_quantities'] = [];
                }

                $result->childs[$waybill]->additionDatas['is_repair'] = false;
                $result->childs[$waybill]->additionDatas['date'] = $child->getElementValue('shop_transport_waybill_id', 'date');
                $result->childs[$waybill]->additionDatas['from_at'] = $child->getElementValue('shop_transport_waybill_id', 'from_at');
                $result->childs[$waybill]->additionDatas['number'] = $child->getElementValue('shop_transport_waybill_id', 'number');
                $result->childs[$waybill]->additionDatas['shop_transport_id_name'] = $child->getElementValue('shop_transport_id');
                $result->childs[$waybill]->additionDatas['shop_transport_id_number'] = $child->getElementValue('shop_transport_id', 'number');
                $result->childs[$waybill]->additionDatas['transport_work_id_name'] = $child->getElementValue('transport_work_id');

                $result->childs[$waybill]->additionDatas['is_free'] = key_exists($child->getElementValue('shop_transport_waybill_id', 'date'), $holidays);

                $transportWork = $child->getElementValue('shop_transport_waybill_id', 'transport_work_id', 0);
                if (!key_exists($transportWork, $transportWorks)) {
                    continue;
                }

                $work = $child->values['shop_transport_work_id'];
                if (!key_exists($work, $transportWorks[$transportWork])) {
                    continue;
                }

                $waybill = $child->getElementValue('shop_transport_waybill_id', 'id', 0);
                if (!key_exists($work, $result->childs[$waybill]->additionDatas['work_quantities'])) {
                    $result->childs[$waybill]->additionDatas['work_quantities'][$work] = 0;
                }
                $result->childs[$waybill]->additionDatas['work_quantities'][$work] += $child->values['quantity'];

                if (!key_exists($work, $result->additionDatas['work_quantities'])) {
                    $result->additionDatas['work_quantities'][$work] = 0;
                }
                $result->additionDatas['work_quantities'][$work] += $child->values['quantity'];

                $waybillWorks[$work] = $work;
            }


            /***********************************/
            // получаем список ремонтов

            $ids = Request_Request::find(
                'DB_Ab1_Shop_Transport_Repair', $this->_sitePageData->shopID,
                $this->_sitePageData, $this->_driverDB,
                Request_RequestParams::setParams(
                    [
                        'date_from_equally' => $dateFrom,
                        'date_to' => $dateTo,
                        'shop_transport_driver_id' => $shopTransportDriverID,
                    ]
                ),
                0, true,
                [
                    'shop_transport_id' => array('name', 'number'),
                ]
            );

            foreach ($ids->childs as $child) {
                $repair = 'r_' . $child->values['id'];
                $result->childs[$repair] = $child;
                $result->childs[$repair]->additionDatas['work_quantities'] = [];

                $result->childs[$repair]->additionDatas['is_repair'] = true;
                $result->childs[$repair]->additionDatas['shop_transport_id_name'] = $child->getElementValue('shop_transport_id');
                $result->childs[$repair]->additionDatas['shop_transport_id_number'] = $child->getElementValue('shop_transport_id', 'number');
                $result->childs[$repair]->additionDatas['transport_work_id_name'] = 'Ремонт';

                $work = Model_Ab1_Shop_Transport_Work::WORK_REPAIR_ID;

                $result->childs[$repair]->additionDatas['work_quantities'][$work] = $child->values['hours'];

                if (!key_exists($work, $result->additionDatas['work_quantities'])) {
                    $result->additionDatas['work_quantities'][$work] = 0;
                }
                $result->additionDatas['work_quantities'][$work] += $child->values['hours'];

                $waybillWorks[$work] = $work;

                $result->childs[$repair]->additionDatas['is_free'] = key_exists($child->getElementValue('shop_transport_waybill_id', 'date'), $holidays);
                if ($result->childs[$repair]->additionDatas['is_free']) {
                    $work = Model_Ab1_Shop_Transport_Work::WORK_HOLIDAY_ID;

                    $result->childs[$repair]->additionDatas['work_quantities'][$work] = $child->values['hours'];

                    if (!key_exists($work, $result->additionDatas['work_quantities'])) {
                        $result->additionDatas['work_quantities'][$work] = 0;
                    }
                    $result->additionDatas['work_quantities'][$work] += $child->values['hours'];

                    $waybillWorks[$work] = $work;
                }
            }
            /***********************************/
            // получаем список выработок по видам работ
            $workIDs = Request_Request::find(
                DB_Ab1_Shop_Transport_Work::NAME, $this->_sitePageData->shopMainID,
                $this->_sitePageData, $this->_driverDB,
                Request_RequestParams::setParams(
                    [
                        'id' => $waybillWorks,
                        'sort_by' => [
                            'order' => 'asc',
                            'name' => 'asc',
                        ]
                    ]
                ),
                0, true
            );

            $result->childsSortBy(Request_RequestParams::getParamArray('sort_by', [], ['date' => 'asc']), true, true);

            $result->additionDatas['works'] = $workIDs->childs;

            $result->addAdditionDataChilds(['works' => $workIDs->childs]);
        }else{
            $result = new MyArray();
            $result->additionDatas['works'] = [];
        }

        $data = Helpers_View::getView(
            '_shop/transport/waybill/work/driver/one/total-work',
            $this->_sitePageData, $this->_driverDB, $result
        );
        $this->_sitePageData->addReplaceAndGlobalDatas('view::_shop/transport/waybill/work/driver/one/total-work', $data);

        $this->_sitePageData->countRecord = count($result->childs);
        $this->_sitePageData->limitPage = count($result->childs);
        $data = Helpers_View::getViews(
            '_shop/transport/waybill/work/driver/list/work', '_shop/transport/waybill/work/driver/one/work',
            $this->_sitePageData, $this->_driverDB, $result
        );
        $this->_sitePageData->addReplaceAndGlobalDatas('view::_shop/transport/waybill/work/driver/list/total', $data);

        View_View::find(
            'DB_Ab1_Shop_Transport_Waybill_Work_Driver', $this->_sitePageData->shopID,
            '_shop/transport/waybill/work/driver/list/total', '_shop/transport/waybill/work/driver/one/total',
            $this->_sitePageData, $this->_driverDB,
            Request_RequestParams::setParams(
                array_merge(
                    $_GET,
                    $_POST,
                    [
                        'quantity_from' => 0,
                        'sum_quantity' => true,
                        'sort_by' => null,
                    ]
                )
            )
        );

        $this->_putInMain('/main/_shop/transport/waybill/work/driver/work');
    }

    public function action_work_1с() {
        $this->_sitePageData->url = '/peo/shoptransportwaybillworkdriver/work_1с';

        $dateFrom = Request_RequestParams::getParamDate('date_from');
        $dateTo = Request_RequestParams::getParamDate('date_to');

        if(empty($dateFrom) || empty($dateTo)){
            throw new HTTP_Exception_500('Period not empty.');
        }

        // получаем список выработок по видам работ
        $transportWorkIDs = Request_Request::find(
            DB_Ab1_Transport_Work::NAME, $this->_sitePageData->shopID,
            $this->_sitePageData, $this->_driverDB,
            Request_RequestParams::setParams(
                [
                    'shop_transport_work_ids_empty' => false,
                ]
            ),
            0, true
        );

        $works = [];
        $transportWorks = [];
        $model = new Model_Ab1_Transport_Work();
        foreach ($transportWorkIDs->childs as $child) {
            $child->setModel($model);

            $list = $model->getShopTransportWorkIDsArray();
            foreach ($list as $one) {
                $works[$one] = $one;
            }

            $transportWorks[$model->id] = [];
            foreach ($list as $one) {
                $transportWorks[$model->id][$one] = $one;
            }
        }

        $params = [
            'shop_transport_waybill_id/to_at_from_equally' => $dateFrom,
            'shop_transport_waybill_id/to_at_to' => $dateTo . ' 23:59:59',
            'sort_by' => ['shop_transport_waybill_id.to_at' => 'asc'],
        ];

        // праздничные и выходные дни
        $holidays = Api_Ab1_Holiday::getHolidays($dateFrom, $dateTo, $this->_sitePageData, $this->_driverDB, true);

        $result = new MyArray();
        $result->additionDatas['work_quantities'] = [];
        $waybillWorks = [];


        /***********************************/
        // получаем выработок путевых листов
        $ids = Request_Request::find(
            'DB_Ab1_Shop_Transport_Waybill_Work_Driver', $this->_sitePageData->shopID,
            $this->_sitePageData, $this->_driverDB,
            Request_RequestParams::setParams(
                array_merge(
                    $params,
                    [
                        'shop_transport_work_id' => $works,
                        'quantity_from' => 0,
                    ]
                )
            ),
            0, true,
            [
                'shop_transport_waybill_id' => array('id', 'date', 'from_at', 'to_at', 'number', 'transport_work_id'),
                'shop_transport_waybill_id.shop_transport_id' => array('name', 'number'),
                'shop_transport_waybill_id.transport_work_id' => array('name', 'number'),
            ]
        );

        foreach ($ids->childs as $child) {
            $waybill = $child->getElementValue('shop_transport_waybill_id', 'id', 0);
            if (!key_exists($waybill, $result->childs)) {
                $result->childs[$waybill] = $child;
                $result->childs[$waybill]->additionDatas['work_quantities'] = [];
            }

            $result->childs[$waybill]->additionDatas['is_repair'] = false;
            $result->childs[$waybill]->additionDatas['date'] = $child->getElementValue('shop_transport_waybill_id', 'date');
            $result->childs[$waybill]->additionDatas['from_at'] = $child->getElementValue('shop_transport_waybill_id', 'from_at');
            $result->childs[$waybill]->additionDatas['number'] = $child->getElementValue('shop_transport_waybill_id', 'number');
            $result->childs[$waybill]->additionDatas['shop_transport_id_name'] = $child->getElementValue('shop_transport_id');
            $result->childs[$waybill]->additionDatas['shop_transport_id_number'] = $child->getElementValue('shop_transport_id', 'number');
            $result->childs[$waybill]->additionDatas['transport_work_id_name'] = $child->getElementValue('transport_work_id');

            $result->childs[$waybill]->additionDatas['is_free'] = key_exists($child->getElementValue('shop_transport_waybill_id', 'date'), $holidays);

            $transportWork = $child->getElementValue('shop_transport_waybill_id', 'transport_work_id', 0);
            if (!key_exists($transportWork, $transportWorks)) {
                continue;
            }

            $work = $child->values['shop_transport_work_id'];
            if (!key_exists($work, $transportWorks[$transportWork])) {
                continue;
            }

            $waybill = $child->getElementValue('shop_transport_waybill_id', 'id', 0);
            if (!key_exists($work, $result->childs[$waybill]->additionDatas['work_quantities'])) {
                $result->childs[$waybill]->additionDatas['work_quantities'][$work] = 0;
            }
            $result->childs[$waybill]->additionDatas['work_quantities'][$work] += $child->values['quantity'];

            if (!key_exists($work, $result->additionDatas['work_quantities'])) {
                $result->additionDatas['work_quantities'][$work] = 0;
            }
            $result->additionDatas['work_quantities'][$work] += $child->values['quantity'];

            $waybillWorks[$work] = $work;
        }


        /***********************************/
        // получаем список ремонтов

        $ids = Request_Request::find(
            'DB_Ab1_Shop_Transport_Repair', $this->_sitePageData->shopID,
            $this->_sitePageData, $this->_driverDB,
            Request_RequestParams::setParams(
                [
                    'date_from_equally' => $dateFrom,
                    'date_to' => $dateTo,
                ]
            ),
            0, true,
            [
                'shop_transport_id' => array('name', 'number'),
            ]
        );

        foreach ($ids->childs as $child) {
            $repair = 'r_' . $child->values['id'];
            $result->childs[$repair] = $child;
            $result->childs[$repair]->additionDatas['work_quantities'] = [];

            $result->childs[$repair]->additionDatas['is_repair'] = true;
            $result->childs[$repair]->additionDatas['shop_transport_id_name'] = $child->getElementValue('shop_transport_id');
            $result->childs[$repair]->additionDatas['shop_transport_id_number'] = $child->getElementValue('shop_transport_id', 'number');
            $result->childs[$repair]->additionDatas['transport_work_id_name'] = 'Ремонт';

            $work = Model_Ab1_Shop_Transport_Work::WORK_REPAIR_ID;

            $result->childs[$repair]->additionDatas['work_quantities'][$work] = $child->values['hours'];

            if (!key_exists($work, $result->additionDatas['work_quantities'])) {
                $result->additionDatas['work_quantities'][$work] = 0;
            }
            $result->additionDatas['work_quantities'][$work] += $child->values['hours'];

            $waybillWorks[$work] = $work;

            $result->childs[$repair]->additionDatas['is_free'] = key_exists($child->getElementValue('shop_transport_waybill_id', 'date'), $holidays);
            if ($result->childs[$repair]->additionDatas['is_free']) {
                $work = Model_Ab1_Shop_Transport_Work::WORK_HOLIDAY_ID;

                $result->childs[$repair]->additionDatas['work_quantities'][$work] = $child->values['hours'];

                if (!key_exists($work, $result->additionDatas['work_quantities'])) {
                    $result->additionDatas['work_quantities'][$work] = 0;
                }
                $result->additionDatas['work_quantities'][$work] += $child->values['hours'];

                $waybillWorks[$work] = $work;
            }
        }

        /***********************************/
        // получаем список выработок по видам работ
        $workIDs = Request_Request::find(
            DB_Ab1_Shop_Transport_Work::NAME, $this->_sitePageData->shopMainID,
            $this->_sitePageData, $this->_driverDB,
            Request_RequestParams::setParams(
                [
                    'id' => $waybillWorks,
                    'sort_by' => [
                        'order' => 'asc',
                        'name' => 'asc',
                    ]
                ]
            ),
            0, true
        );
        $workIDs->runIndex();

        // создаем массив запроса
        $worker = Request_Request::findOneByID(
            DB_Ab1_Shop_Worker::NAME, $this->_sitePageData->operation->getShopWorkerID(),
            0, $this->_sitePageData, $this->_driverDB
        );

        $iin = '';
        if($worker != null){
            $iin = $worker->values['iin'];
        }

        $document = [
            'type' => 'waybill',
		    'code' => $dateFrom,
		    'guid' => $dateFrom,
		    'guid_1c' => '',
		    'date' => $dateFrom,
		    'month' => $dateFrom,
		    'bin_org' => '060440009474',
		    'division_org' => '',
		    'worker_iin' => $iin,
            'rows' => [],
        ];

        foreach ($result->childs as $child) {
            foreach ($child->additionDatas['work_quantities'] as $work => $quantity) {
                $document['rows'][] = [
                    'date_action' => $child->getElementValue('shop_transport_waybill_id', 'date', $child->values['date']),
                    'typeofwork' => $child->getElementValue('transport_work_id', 'number'),
                    'strtypeofwork' => $child->getElementValue('transport_work_id'),
                    'typeoftime' => 1,
                    'code1c' => $workIDs->childs[$work]->values['number'],
                    'str' => $workIDs->childs[$work]->values['name'],
                    'value' => $quantity
                ];
            }
        }

        $integration = new Integration_Ab1_1C_Service();
        $integration->sendData($document);

        $this->_putInMain('/main/_shop/transport/waybill/work/driver/work');
    }
}