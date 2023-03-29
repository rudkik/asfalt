<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_ShopReport extends Controller_Ab1_All {

    public function __construct(Request $request, Response $response)
    {
        $this->controllerName = 'shopreport';
        $this->objectName = 'report';

        parent::__construct($request, $response);
        $this->_sitePageData->actionURLName = '';
    }

    /**
     * сортировка по имени
     * @param $x
     * @param $y
     * @return int
     */
    function mySortMethod($x, $y) {
        return strcasecmp($x['name'], $y['name']);
    }

    /**
     * Получаем подразделение оператора
     * @return array|int
     */
    function getOperationSubdivisionID() {
        if($this->_sitePageData->operation->getShopSubdivisionID() < 1){
            return -1;
        }

        return [0, $this->_sitePageData->operation->getShopSubdivisionID()];
    }

    /**
     * АТ22 Количество отработанных часов у водителей
     * @throws Exception
     */
    public function action_waybill_work_time() {
        set_time_limit(36000);
        $this->_sitePageData->url = '/'.$this->actionURLName.'/shopreport/waybill_work_time';

        $dateFrom = Request_RequestParams::getParamDate('date_from');
        $dateTo = Request_RequestParams::getParamDate('date_to');
        $shopTransportDriverID = Request_RequestParams::getParamInt('shop_transport_driver_id');

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

        /***********************************/
        // получаем выработок путевых листов
        $params = Request_RequestParams::setParams(
            [
                'shop_transport_waybill_id/to_at_from_equally' => $dateFrom,
                'shop_transport_waybill_id/to_at_to' => $dateTo . ' 23:59:59',
                'shop_transport_work_id' => $works,
                'quantity_from' => 0,
                'sum_quantity' => true,
                'group_by' => [
                    'shop_transport_work_id',
                    'shop_transport_waybill_id.shop_transport_driver_id', 'shop_transport_waybill_id.shop_transport_driver_id.name',
                    'shop_transport_waybill_id.transport_work_id', 'shop_transport_waybill_id.transport_work_id.name',
                ],
            ]
        );
        $ids = Request_Request::find(
            'DB_Ab1_Shop_Transport_Waybill_Work_Driver', $this->_sitePageData->shopID,
            $this->_sitePageData, $this->_driverDB, $params, 0, true,
            [
                'shop_transport_waybill_id.shop_transport_driver_id' => array('name'),
                'shop_transport_waybill_id.transport_work_id' => array('name'),
            ]
        );

        $dataTransports = [
            'data' => [],
            'works' => [],
        ];
        $waybillWorks = [];

        foreach ($ids->childs as $child) {
            $transportWork = $child->getElementValue('shop_transport_waybill_id', 'transport_work_id', 0);
            if (!key_exists($transportWork, $transportWorks)) {
                continue;
            }

            $work = $child->values['shop_transport_work_id'];
            if (!key_exists($work, $transportWorks[$transportWork])) {
                continue;
            }

            $key = $transportWork . '_'.  $child->getElementValue('shop_transport_waybill_id', 'shop_transport_driver_id');
            if(!key_exists($key, $dataTransports['data'])){
                $dataTransports['data'][$key] = [
                    'transport_work' => $child->getElementValue('transport_work_id'),
                    'driver' => $child->getElementValue('shop_transport_driver_id'),
                    'works' => [],
                ];
            }

            if (!key_exists($work, $dataTransports['data'][$key]['works'])) {
                $dataTransports['data'][$key]['works'][$work] = 0;
            }
            $dataTransports['data'][$key]['works'][$work] += $child->values['quantity'];

            if (!key_exists($work, $dataTransports['works'])) {
                $dataTransports['works'][$work] = 0;
            }
            $dataTransports['works'][$work] += $child->values['quantity'];

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
                    'sum_hours' => true,
                    'group_by' => [
                        'shop_transport_id', 'shop_transport_id.name',
                        'shop_transport_driver_id', 'shop_transport_driver_id.name',
                    ],
                ]
            ),
            0, true,
            [
                'shop_transport_id' => array('name'),
                'shop_transport_driver_id' => array('name'),
            ]
        );

        foreach ($ids->childs as $child) {
            $transportWork = 'repair';
            $work = Model_Ab1_Shop_Transport_Work::WORK_REPAIR_ID;

            $key = $transportWork . '_'.  $child->values['shop_transport_driver_id'];
            if(!key_exists($key, $dataTransports['data'])){
                $dataTransports['data'][$key] = [
                    'transport_work' => 'Ремонт',
                    'driver' => $child->getElementValue('shop_transport_driver_id'),
                    'works' => [],
                ];
            }

            if (!key_exists($work, $dataTransports['data'][$key]['works'])) {
                $dataTransports['data'][$key]['works'][$work] = 0;
            }
            $dataTransports['data'][$key]['works'][$work] += $child->values['hours'];

            if (!key_exists($work, $dataTransports['works'])) {
                $dataTransports['works'][$work] = 0;
            }
            $dataTransports['works'][$work] += $child->values['hours'];

            $waybillWorks[$work] = $work;
        }

        uasort($dataTransports['data'], function ($x, $y) {
            $result = strcasecmp($x['driver'], $y['driver']);
            if($result == 0) {
                return strcasecmp($x['transport_work'], $y['transport_work']);
            }

            return $result;
        });

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

        $dataWorks = [
            'data' => [],
        ];
        foreach ($workIDs->childs as $child) {
            $dataWorks['data'][$child->id] = [
                'id' => $child->id,
                'name' => $child->values['name'],
            ];
        }

        $viewObject = 'ab1/_report/'.$this->_sitePageData->languageID.'/waybill/work-time';
        $tmp = str_replace('\\', '/', $viewObject);
        try {
            $view = View::factory($tmp);
        }catch (Exception $e) {
            throw new Exception('Шаблон "'.$tmp.'" не найден.');
        }

        $view->transports = $dataTransports;
        $view->works = $dataWorks;
        $view->dateFrom = $dateFrom;
        $view->dateTo = $dateTo;
        $view->operation = $this->_sitePageData->operation->getValues();
        $view->shop = $this->_sitePageData->shop->getName();
        $view->shopOptions = $this->_sitePageData->shop->getOptionsArray();
        $strView = Helpers_View::viewToStr($view);

        header('Content-Type: application/x-download;charset=UTF-8');
        // header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: filename="АТ22 Количество отработанных часов у водителей ' . Helpers_DateTime::getPeriodRus($dateFrom, $dateTo) . '.xml"');
        header('Cache-Control: max-age=0');

        echo $strView;
        exit();
    }

    /**
     * ПР08 Справка по исполнению договоров по потребителям продукции
     * @throws Exception
     */
    public function action_contract_spent_bank() {
        set_time_limit(36000);

        $this->_sitePageData->url = '/'.$this->actionURLName.'/shopreport/contract_spent_bank';

        $shopProductRubrics = Request_RequestParams::getParamArray('shop_product_rubric_ids');

        $dateFrom = Request_RequestParams::getParamDate('date_from');
        $dateTo = Request_RequestParams::getParamDate('date_to');

        $params = Request_RequestParams::setParams(
            array(
                'contract_date_from' => $dateFrom,
                'contract_date_to' => $dateTo,
                'is_public_ignore' => true,
                'shop_product_id_from' => 0,
                'shop_client_contract_id.client_contract_type_id' => Model_Ab1_ClientContract_Type::CLIENT_CONTRACT_TYPE_SALE_PRODUCT,
                'shop_client_contract_id.is_basic' => true,
                'is_basic' => true,
                'sort_by' => array(
                    'shop_client_contract_id.from_at' => 'asc',
                )
            )
        );

        $ids = Request_Request::find(
            'DB_Ab1_Shop_Client_Contract_Item', $this->_sitePageData->shopMainID,
            $this->_sitePageData, $this->_driverDB,
            $params, 0, true,
            array(
                'shop_client_id' => array('name'),
                'product_root_rubric_id' => array('id', 'name', 'unit'),
                'shop_client_contract_id' => array('number', 'from_at', 'amount'),
            )
        );

        // добавляем строчки увеличивающие баланс договора
        $shopClientContractIDs = $ids->getChildArrayInt('shop_client_contract_id', true);
        if(!empty($shopClientContractIDs)) {
            $params = Request_RequestParams::setParams(
                array(
                    'is_add_basic_contract' => true,
                    'basic_shop_client_contract_id' => $shopClientContractIDs,
                    'is_public_ignore' => true,
                    'shop_product_id_from' => 0,
                    'sort_by' => array(
                        'shop_client_contract_id.from_at' => 'asc',
                    )
                )
            );

            $agreementsIDs = Request_Request::find(
                'DB_Ab1_Shop_Client_Contract_Item',
                $this->_sitePageData->shopMainID, $this->_sitePageData, $this->_driverDB,
                $params, 0, true,
                array(
                    'shop_client_id' => array('name'),
                    'product_root_rubric_id' => array('id', 'name', 'unit'),
                    'shop_client_contract_id' => array('number', 'from_at'),
                    'basic_shop_client_contract_id' => array('number', 'from_at', 'amount'),
                )
            );
        }else{
            $agreementsIDs = new MyArray();
        }

        $rubrics = array(
            'quantity_all' => 0,
            'quantity' => 0,
        );
        $dataRubrics = array(
            'contract' => [
                'quantity_all' => 0,
                'quantity' => 0,
                'amount_all' => 0,
                'amount' => 0,
            ],
            'not_contract' => [
                'quantity_all' => 0,
                'quantity' => 0,
                'amount_all' => 0,
                'amount' => 0,
            ],
            'data' => array(),
        );
        $setRubrics = function (MyArray $ids, array &$dataRubrics, array &$rubrics, $shopProductRubrics) {
            foreach ($ids->childs as $child) {
                // группировка по базовым рубрикам
                $rootID = $child->getElementValue('product_root_rubric_id', 'id', 0);
                if ($rootID < 1 || (!empty($shopProductRubrics) && array_search($rootID, $shopProductRubrics) === false)) {
                    continue;
                }

                if (!key_exists($rootID, $dataRubrics['data'])) {
                    $dataRubrics['data'][$rootID] = array(
                        'id' => $rootID,
                        'name' => $child->getElementValue('product_root_rubric_id'),
                        'unit' => $child->getElementValue('product_root_rubric_id', 'unit'),
                        'contract' => [
                            'quantity_all' => 0,
                            'quantity' => 0,
                            'amount_all' => 0,
                            'amount' => 0,
                        ],
                        'not_contract' => [
                            'quantity_all' => 0,
                            'quantity' => 0,
                            'amount_all' => 0,
                            'amount' => 0,
                        ],
                    );
                    $rubrics[$rootID] = array(
                        'quantity_all' => 0,
                        'quantity' => 0,
                        'amount_all' => 0,
                        'amount' => 0,
                    );
                }
            }
        };

        $setRubrics($ids, $dataRubrics, $rubrics, $shopProductRubrics);
        $setRubrics($agreementsIDs, $dataRubrics, $rubrics, $shopProductRubrics);

        uasort($dataRubrics['data'], array($this, 'mySortMethod'));

        $dataContracts = array(
            'data' => array(),
        );
        foreach ($ids->childs as $child) {
            $rootID = $child->getElementValue('product_root_rubric_id', 'id', 0);
            if($rootID < 1 || (!empty($shopProductRubrics) && array_search($rootID, $shopProductRubrics) === false)){
                continue;
            }

            $contract = $child->values['shop_client_contract_id'];

            // группировка по договорам
            if(!key_exists($contract, $dataContracts['data'])){
                $dataContracts['data'][$contract] = array(
                    'client' => $child->getElementValue('shop_client_id'),
                    'number' => $child->getElementValue('shop_client_contract_id', 'number'),
                    'from_at' => $child->getElementValue('shop_client_contract_id', 'from_at'),
                    'quantity_all' => 0,
                    'quantity' => 0,
                    'amount_all' => 0,
                    'amount' => 0,
                    'data' => $rubrics,
                    'agreements' => [],
                );
            }

            // количество
            $quantity = $child->values['quantity'] / 1000;

            $dataContracts['data'][$contract]['data'][$rootID]['quantity_all'] += $quantity;
            $dataContracts['data'][$contract]['quantity_all'] += $quantity;

            $dataRubrics['data'][$rootID]['contract']['quantity_all'] += $quantity;
            $dataRubrics['contract']['quantity_all'] += $quantity;

            // сумма
            $amount = $child->values['amount'] / 1000000;

            $dataContracts['data'][$contract]['data'][$rootID]['amount_all'] += $amount;
            $dataContracts['data'][$contract]['amount_all'] += $amount;

            $dataRubrics['data'][$rootID]['contract']['amount_all'] += $amount;
            $dataRubrics['contract']['amount_all'] += $amount;
        }

        foreach ($agreementsIDs->childs as $child) {
            $rootID = $child->getElementValue('product_root_rubric_id', 'id', 0);
            if($rootID < 1 || (!empty($shopProductRubrics) && array_search($rootID, $shopProductRubrics) === false)){
                continue;
            }

            $contract = $child->values['basic_shop_client_contract_id'];

            // группировка по договорам
            if(!key_exists($contract, $dataContracts['data'])){
                $dataContracts['data'][$contract] = array(
                    'client' => $child->getElementValue('shop_client_id'),
                    'number' => $child->getElementValue('basic_shop_client_contract_id', 'number'),
                    'from_at' => $child->getElementValue('basic_shop_client_contract_id', 'from_at'),
                    'quantity_all' => 0,
                    'quantity' => 0,
                    'amount_all' => 0,
                    'amount' => 0,
                    'data' => $rubrics,
                    'agreements' => [],
                );
            }

            // количество
            $quantity = $child->values['quantity'] / 1000;

            $dataContracts['data'][$contract]['data'][$rootID]['quantity_all'] += $quantity;
            $dataContracts['data'][$contract]['quantity_all'] += $quantity;

            $dataRubrics['data'][$rootID]['contract']['quantity_all'] += $quantity;
            $dataRubrics['contract']['quantity_all'] += $quantity;

            // сумма
            $amount = $child->values['amount'] / 1000000;

            $dataContracts['data'][$contract]['data'][$rootID]['amount_all'] += $amount;
            $dataContracts['data'][$contract]['amount_all'] += $amount;

            $dataRubrics['data'][$rootID]['contract']['amount_all'] += $amount;
            $dataRubrics['contract']['amount_all'] += $amount;

            $numberAgreement = $child->getElementValue('shop_client_contract_id', 'number');
            $fromAgreement = $child->getElementValue('shop_client_contract_id', 'from_at');
            $dataContracts['data'][$contract]['agreements'][$numberAgreement . '_' . $fromAgreement] = [
                'number' => $numberAgreement,
                'from_at' => $fromAgreement,
            ];
        }

        // расходы договоров
        if($dateFrom !== null){
            $dateFrom .= ' 06:00:00';
        }
        $dateTo = Request_RequestParams::getParamDate('date_to');
        if($dateTo !== null){
            $dateTo .= ' 06:00:00';
        }

        $params = Request_RequestParams::setParams(
            array(
                'exit_at_from' => $dateFrom,
                'exit_at_to' => $dateTo,
                'is_exit' => 1,
                'quantity_from' => 0,
                'is_charity' => false,
                'shop_client_contract_id_from' => 0,
                'sum_quantity' => TRUE,
                'sum_amount' => TRUE,
                'group_by' => array(
                    'shop_client_contract_id',
                    'root_rubric_id.id',
                )
            )
        );
        $elements = array(
            'root_rubric_id' => array('id'),
        );

        $shopCarItemIDs = Request_Request::findBranch('DB_Ab1_Shop_Car_Item',
            array(), $this->_sitePageData, $this->_driverDB, $params, 0, TRUE, $elements
        );
        $shopPieceItemIDs = Request_Request::findBranch('DB_Ab1_Shop_Piece_Item',
            array(), $this->_sitePageData, $this->_driverDB, $params, 0, TRUE, $elements
        );
        $shopCarItemIDs->addChilds($shopPieceItemIDs);

        foreach ($shopCarItemIDs->childs as $child) {
            $rootID = $child->getElementValue('root_rubric_id', 'id', 0);
            if($rootID < 1 || (!empty($shopProductRubrics) && array_search($rootID, $shopProductRubrics) === false)){
                continue;
            }

            // группировка по договорам
            $contract = $child->values['shop_client_contract_id'];
            if(!key_exists($contract, $dataContracts['data'])){
                continue;
            }

            // количество
            $quantity = $child->values['quantity'] / 1000;

            $dataContracts['data'][$contract]['data'][$rootID]['quantity'] += $quantity;
            $dataContracts['data'][$contract]['quantity'] += $quantity;

            $dataRubrics['data'][$rootID]['contract']['quantity'] += $quantity;
            $dataRubrics['contract']['quantity'] += $quantity;

            // сумма
            $amount = $child->values['amount'] / 1000000;

            $dataContracts['data'][$contract]['data'][$rootID]['amount'] += $amount;
            $dataContracts['data'][$contract]['amount'] += $amount;

            $dataRubrics['data'][$rootID]['contract']['amount'] += $amount;
            $dataRubrics['contract']['amount'] += $amount;
        }

        $params = Request_RequestParams::setParams(
            array(
                'exit_at_from' => $dateFrom,
                'exit_at_to' => $dateTo,
                'is_exit' => 1,
                'quantity_from' => 0,
                'is_charity' => false,
                'shop_client_contract_id' => 0,
                'sum_quantity' => TRUE,
                'sum_amount' => TRUE,
                'group_by' => array(
                    'root_rubric_id.id',
                )
            )
        );

        $shopCarItemIDs = Request_Request::findBranch('DB_Ab1_Shop_Car_Item',
            array(), $this->_sitePageData, $this->_driverDB, $params, 0, TRUE, $elements
        );
        $shopPieceItemIDs = Request_Request::findBranch('DB_Ab1_Shop_Piece_Item',
            array(), $this->_sitePageData, $this->_driverDB, $params, 0, TRUE, $elements
        );
        $shopCarItemIDs->addChilds($shopPieceItemIDs);

        foreach ($shopCarItemIDs->childs as $child) {
            $rootID = $child->getElementValue('root_rubric_id', 'id', 0);
            if($rootID < 1 || (!empty($shopProductRubrics) && array_search($rootID, $shopProductRubrics) === false)){
                continue;
            }

            // количество
            $quantity = $child->values['quantity'] / 1000;

            $dataRubrics['data'][$rootID]['not_contract']['quantity_all'] += $quantity;
            $dataRubrics['data'][$rootID]['not_contract']['quantity'] += $quantity;

            $dataRubrics['not_contract']['quantity_all'] += $quantity;
            $dataRubrics['not_contract']['quantity'] += $quantity;

            // сумма
            $amount = $child->values['amount'] / 1000000;

            $dataRubrics['data'][$rootID]['not_contract']['amount_all'] += $amount;
            $dataRubrics['data'][$rootID]['not_contract']['amount'] += $amount;

            $dataRubrics['not_contract']['amount_all'] += $amount;
            $dataRubrics['not_contract']['amount'] += $amount;
        }

        $viewObject = 'ab1/_report/'.$this->_sitePageData->languageID.'/contract/spent-bank';
        $tmp = str_replace('\\', '/', $viewObject);
        try {
            $view = View::factory($tmp);
        }catch (Exception $e) {
            throw new Exception('Шаблон "'.$tmp.'" не найден.');
        }

        $view->contracts = $dataContracts;
        $view->rubrics = $dataRubrics;
        $view->dateFrom = $dateFrom;
        $view->dateTo = $dateTo;
        $view->operation = $this->_sitePageData->operation->getValues();
        $view->shop = $this->_sitePageData->shop->getName();
        $view->shopOptions = $this->_sitePageData->shop->getOptionsArray();
        $strView = Helpers_View::viewToStr($view);

        header('Content-Type: application/x-download;charset=UTF-8');
        // header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: filename="ПР08 Справка по исполнению договоров по потребителям продукции c ' . Helpers_DateTime::getDateTimeFormatRus($dateFrom) . ' до ' . Helpers_DateTime::getDateTimeFormatRus($dateTo) .'.xml"');
        header('Cache-Control: max-age=0');

        echo $strView;
        exit();
    }

    /**
     * НБ02 Уведомление о приеме и сдачи хопров
     * @throws Exception
     */
    public function action_boxcar_cement() {
        set_time_limit(36000);

        $this->_sitePageData->url = '/'.$this->actionURLName.'/shopreport/boxcar_cement';

        // задаем время выборки
        $dateFrom = Request_RequestParams::getParamDate('date_from');
        $dateTo = Helpers_DateTime::getDateTimeEndDay(Request_RequestParams::getParamDate('date_to'));

        $params = array(
            'date_departure_from_equally' => $dateFrom,
            'date_departure_to' => $dateTo,
            'shop_raw_id' => Request_RequestParams::getParamInt('shop_raw_id'),
            'sort_by' => array(
                'created_at' => 'asc',
            ),
        );
        $ids = Request_Request::find('DB_Ab1_Shop_Boxcar',
            $this->_sitePageData->shopMainID, $this->_sitePageData, $this->_driverDB,
            $params, 0, TRUE,
            array(
                'shop_boxcar_client_id' => array('name'),
                'drain_zhdc_from_shop_operation_id' => array('name'),
                'drain_zhdc_to_shop_operation_id' => array('name'),
                'drain_from_shop_operation_id_1' => array('name'),
                'zhdc_shop_operation_id' => array('name'),
            )
        );

        $dataBoxcars = array(
            'data' => array(),
        );
        foreach ($ids->childs as $child) {
            $quantity = $child->values['quantity'];

            $dataBoxcars['data'][] = array(
                'number' => $child->values['number'],
                'date_arrival' => $child->values['date_arrival'],
                'zhdc_from' => $child->getElementValue('drain_zhdc_from_shop_operation_id'),
                'date_drain_from' => $child->values['date_drain_from'],
                'drain_from' => $child->getElementValue('drain_from_shop_operation_id_1'),
                'date_drain_to' => $child->values['date_drain_to'],
                'stamp' => $child->values['stamp'],
                'date_departure' => $child->values['date_departure'],
                'zhdc_to' => $child->getElementValue('drain_zhdc_to_shop_operation_id'),
                'sending' => $child->values['sending'],
                'zhdc' => $child->getElementValue('zhdc_shop_operation_id'),
            );
        }

        $viewObject = 'ab1/_report/'.$this->_sitePageData->languageID.'/boxcar/cement';
        $tmp = str_replace('\\', '/', $viewObject);
        try {
            $view = View::factory($tmp);
        }catch (Exception $e) {
            throw new Exception('Шаблон "'.$tmp.'" не найден.');
        }

        $view->boxcars = $dataBoxcars;
        $view->dateFrom = $dateFrom;
        $view->dateTo = $dateTo;
        $view->operation = $this->_sitePageData->operation->getValues();
        $view->shop = $this->_sitePageData->shop->getName();
        $view->shopOptions = $this->_sitePageData->shop->getOptionsArray();
        $strView = Helpers_View::viewToStr($view);

        header('Content-Type: application/x-download;charset=UTF-8');
        // header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: filename="НБ02 Уведомление о приеме и сдачи хопров за период ' . Helpers_DateTime::getPeriodRus($dateFrom, $dateTo) .'.xml"');
        header('Cache-Control: max-age=0');

        echo $strView;
        exit();
    }

    /**
     * АТ21 Ремонтная ведомость
     * @throws Exception
     */
    public function action_transport_repair_days() {
        set_time_limit(36000);

        $this->_sitePageData->url = '/'.$this->actionURLName.'/shopreport/transport_repair_days';

        $dateFrom = Request_RequestParams::getParamDate('date_from');
        $dateTo = Request_RequestParams::getParamDate('date_to');
        $shopBranchID = Request_RequestParams::getParamInt('shop_branch_id');

        $drivers = [
            'total_holiday' => 0,
            'total' => 0,
            'data' => [],
        ];


        /******************************************/
        // праздничные и выходные дни
        $holidays = Api_Ab1_Holiday::getHolidays($dateFrom, $dateTo, $this->_sitePageData, $this->_driverDB, true);


        /******************************************/
        // получаем ремонты
        $params = Request_RequestParams::setParams(
            array(
                'date_from_equally' => Helpers_DateTime::getDateFormatPHP($dateFrom),
                'date_to' => Helpers_DateTime::getDateFormatPHP($dateTo) . '23:59:59',
                'shop_transport_driver_id.shop_branch_from_id' => $shopBranchID,
                'sort_by' => ['shop_transport_driver_id.name' => 'asc'],
            )
        );
        $repairIDs = Request_Request::find(
            DB_Ab1_Shop_Transport_Repair::NAME, 0, $this->_sitePageData, $this->_driverDB,
            $params, 0, true,
            array(
                'shop_transport_driver_id' => array('name'),
            )
        );

        foreach ($repairIDs->childs as $child){
            // водитель
            $driver = $child->values['shop_transport_driver_id'];
            if(!key_exists($driver, $drivers['data'])){
                $drivers['data'][$driver] = [
                    'name' => $child->getElementValue('shop_transport_driver_id'),
                    'total_holiday' => 0,
                    'total' => 0,
                    'days' => [],
                ];
            }

            $hours = $child->values['hours'];
            $date = $child->values['date'];

            Helpers_Array::plusValue($drivers['data'][$driver]['days'], $date, $hours);
            $drivers['data'][$driver]['total'] += $hours;
            $drivers['total'] += $hours;

            if(key_exists($date, $holidays)){
                $drivers['data'][$driver]['total_holiday'] += $hours;
                $drivers['total_holiday'] += $hours;
            }
        }

        $viewObject = 'ab1/_report/'.$this->_sitePageData->languageID.'/transport/repair-days';
        $tmp = str_replace('\\', '/', $viewObject);
        try {
            $view = View::factory($tmp);
        }catch (Exception $e) {
            throw new Exception('Шаблон "'.$tmp.'" не найден.');
        }

        $view->drivers = $drivers;
        $view->holidays = $holidays;
        $view->dateFrom = $dateFrom;
        $view->dateTo = $dateTo;
        $view->operation = $this->_sitePageData->operation->getValues();
        $view->shop = $this->_sitePageData->shop->getName();
        $view->shopOptions = $this->_sitePageData->shop->getOptionsArray();
        $view->siteData = $this->_sitePageData;
        $strView = Helpers_View::viewToStr($view);

        header('Content-Type: application/x-download;charset=UTF-8');
        // header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: filename="АТ21 Ремонтная ведомость за период ' . Helpers_DateTime::getPeriodRus($dateFrom, $dateTo) .'.xml"');
        header('Cache-Control: max-age=0');

        echo $strView;
        exit();
    }

    /**
     * АТ19 Итоги по начислениям водителям
     * @throws Exception
     */
    public function action_waybill_total_wage() {
        set_time_limit(36000);

        $this->_sitePageData->url = '/'.$this->actionURLName.'/shopreport/waybill_total_wage';

        $dateFrom = Request_RequestParams::getParamDate('date_from');
        $dateTo = Request_RequestParams::getParamDate('date_to');

        $result = Api_Ab1_Shop_Transport_Waybill::getDriverTotalWages(
            $dateFrom, $dateTo, $this->_sitePageData, $this->_driverDB
        );

        $viewObject = 'ab1/_report/'.$this->_sitePageData->languageID.'/waybill/total-wage';
        $tmp = str_replace('\\', '/', $viewObject);
        try {
            $view = View::factory($tmp);
        }catch (Exception $e) {
            throw new Exception('Шаблон "'.$tmp.'" не найден.');
        }

        $view->drivers = $result['drivers'];
        $view->works = $result['works'];
        $view->dateFrom = $dateFrom;
        $view->dateTo = $dateTo;
        $view->operation = $this->_sitePageData->operation->getValues();
        $view->shop = $this->_sitePageData->shop->getName();
        $view->shopOptions = $this->_sitePageData->shop->getOptionsArray();
        $view->siteData = $this->_sitePageData;
        $strView = Helpers_View::viewToStr($view);
//        echo '<pre>';
//        print_r($view);
//        die();

        header('Content-Type: application/x-download;charset=UTF-8');
        // header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: filename="АТ12 Анализ начислений работникам организаций за период ' . Helpers_DateTime::getPeriodRus($dateFrom, $dateTo) .'.xml"');
        header('Cache-Control: max-age=0');

        echo $strView;
        exit();
    }

    /**
     * АТ20 Количество отработанных часов
     * @throws Exception
     */
    public function action_waybill_work_days() {
        set_time_limit(36000);

        $this->_sitePageData->url = '/'.$this->actionURLName.'/shopreport/waybill_work_days';

        $dateFrom = Request_RequestParams::getParamDate('date_from');
        $dateTo = Request_RequestParams::getParamDate('date_to');

        $shopTransportWorkID = Request_RequestParams::getParamInt('shop_transport_work_id');
        $modelWork = new Model_Ab1_Shop_Transport_Work();
        $modelWork->setDBDriver($this->_driverDB);
        Helpers_DB::getDBObject($modelWork, $shopTransportWorkID, $this->_sitePageData, 0);

        $shopSubdivisionID = Request_RequestParams::getParamInt('shop_subdivision_id');
        $modelSubdivision = new Model_Ab1_Shop_Subdivision();
        $modelSubdivision->setDBDriver($this->_driverDB);
        Helpers_DB::getDBObject($modelSubdivision, $shopSubdivisionID, $this->_sitePageData);

        $drivers = Api_Ab1_Shop_Transport_Waybill::getDriverTransportWorkDays(
            $shopTransportWorkID, $shopSubdivisionID, $dateFrom, $dateTo, $this->_sitePageData, $this->_driverDB
        );

        $viewObject = 'ab1/_report/'.$this->_sitePageData->languageID.'/waybill/work-days';
        $tmp = str_replace('\\', '/', $viewObject);
        try {
            $view = View::factory($tmp);
        }catch (Exception $e) {
            throw new Exception('Шаблон "'.$tmp.'" не найден.');
        }


        $view->drivers = $drivers;
        $view->dateFrom = $dateFrom;
        $view->dateTo = $dateTo;
        $view->work = $modelWork->getName();
        $view->subdivision = $modelSubdivision->getName();
        $view->operation = $this->_sitePageData->operation->getValues();
        $view->shop = $this->_sitePageData->shop->getName();
        $view->shopOptions = $this->_sitePageData->shop->getOptionsArray();
        $view->siteData = $this->_sitePageData;
        $strView = Helpers_View::viewToStr($view);

        header('Content-Type: application/x-download;charset=UTF-8');
        // header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: filename="АТ20 Количество отработанных часов за период ' . Helpers_DateTime::getPeriodRus($dateFrom, $dateTo) .'.xml"');
        header('Cache-Control: max-age=0');

        echo $strView;
        exit();
    }

    /**
     * АТ18 Время нахождения в ремонте
     * @throws Exception
     */
    public function action_transport_repair() {
        set_time_limit(36000);

        $this->_sitePageData->url = '/'.$this->actionURLName.'/shopreport/transport_repair';

        $id = Request_RequestParams::getParamInt('id');

        // путевой лист
        $repair = Request_Request::findOneByID(
            DB_Ab1_Shop_Transport_Repair::NAME, $id, $this->_sitePageData->shopID,
            $this->_sitePageData, $this->_driverDB,
            array(
                'shop_transport_id' => array('name'),
                'shop_transport_driver_id' => array('name'),
                'shop_subdivision_id' => array('name'),
            )
        );
        if($repair == null){
            throw new HTTP_Exception_404('Transport repair not is found!');
        }

        $dataRepair = [
            'date' => $repair->values['date'],
            'driver' => $repair->getElementValue('shop_transport_driver_id'),
            'transport' => $repair->getElementValue('shop_transport_id'),
            'subdivision' => $repair->getElementValue('shop_subdivision_id'),
            'hours' => $repair->values['hours'],
        ];

        $viewObject = 'ab1/_report/'.$this->_sitePageData->languageID.'/transport/repair';
        $tmp = str_replace('\\', '/', $viewObject);
        try {
            $view = View::factory($tmp);
        }catch (Exception $e) {
            throw new Exception('Шаблон "'.$tmp.'" не найден.');
        }

        $view->repair = $dataRepair;
        $view->operation = $this->_sitePageData->operation->getValues();
        $view->shop = $this->_sitePageData->shop->getName();
        $view->shopOptions = $this->_sitePageData->shop->getOptionsArray();
        $view->siteData = $this->_sitePageData;
        $strView = Helpers_View::viewToStr($view);

        header('Content-Type: application/x-download;charset=UTF-8');
        // header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: filename="АТ18 Время нахождения в ремонте № ' . $repair->values['id'] .'.xml"');
        header('Cache-Control: max-age=0');

        echo $strView;
        exit();
    }

    /**
     * АТ17 Итоги по путевому листу
     * @throws Exception
     */
    public function action_waybill_total() {
        set_time_limit(36000);

        $this->_sitePageData->url = '/'.$this->actionURLName.'/shopreport/waybill_total';

        $id = Request_RequestParams::getParamInt('id');

        // путевой лист
        $waybill = Request_Request::findOneByID(
            DB_Ab1_Shop_Transport_Waybill::NAME, $id, $this->_sitePageData->shopID,
            $this->_sitePageData, $this->_driverDB,
            array(
                'shop_transport_id' => array('name', 'shop_branch_storage_id'),
                'shop_transport_driver_id' => array('name'),
                'shop_subdivision_id' => array('name'),
                'transport_wage_id' => array('name'),
                'transport_work_id' => array('name', 'shop_transport_work_ids'),
                'transport_form_payment_id' => array('name'),
            )
        );
        if($waybill == null){
            throw new HTTP_Exception_404('Transport waybill not is found!');
        }

        $dataWaybill = [
            'date' => $waybill->values['date'],
            'number' => $waybill->values['number'],
            'from_at' => $waybill->values['from_at'],
            'to_at' => $waybill->values['to_at'],
            'driver' => $waybill->getElementValue('shop_transport_driver_id'),
            'transport' => $waybill->getElementValue('shop_transport_id'),
            'subdivision' => $waybill->getElementValue('shop_subdivision_id'),
            'transport_wage' => $waybill->getElementValue('transport_wage_id'),
            'transport_work' => $waybill->getElementValue('transport_work_id'),
            'transport_form_payment' => $waybill->getElementValue('transport_form_payment_id'),
            'transport_form_payment_id' => $waybill->values['transport_form_payment_id'],
        ];

        // Получаем список перевозок
        $dataCars = array(
            'data' => array(),
            'trip' => 0,
            'distance' => 0,
            'quantity' => 0,
        );

        if($waybill->values['transport_form_payment_id'] == Model_Ab1_Transport_FormPayment::FORM_PAYMENT_PIECE_RATE) {
            $branchTo = null;
        }else{
            $branchTo = $waybill->getElementValue('shop_transport_id', 'shop_branch_storage_id');
        }

        $params = Request_RequestParams::setParams(
            array(
                'shop_transport_waybill_id' => $id,
                'sum_count_trip' => true,
                'sum_distance' => true,
                'sum_quantity' => true,
                'shop_branch_to_id' => $branchTo,
                'group_by' => array(
                    'shop_raw_id', 'shop_raw_id.name',
                    'shop_material_id', 'shop_material_id.name',
                    'shop_product_id', 'shop_product_id.name',
                    'shop_client_to_id', 'shop_client_to_id.name',
                    'shop_daughter_from_id', 'shop_daughter_from_id.name',
                    'shop_branch_to_id', 'shop_branch_to_id.name',
                    'shop_branch_from_id', 'shop_branch_from_id.name',
                    'shop_ballast_crusher_to_id', 'shop_ballast_crusher_to_id.name',
                    'shop_ballast_crusher_from_id', 'shop_ballast_crusher_from_id.name',
                    'shop_transportation_place_to_id', 'shop_transportation_place_to_id.name',
                    'shop_material_other_id', 'shop_material_other_id.name',
                    'shop_move_place_to_id', 'shop_move_place_to_id.name',
                    'to_name', 'product_name',
                    'shop_transport_route_id', 'shop_transport_route_id.name',
                )
            )
        );
        $ids = Request_Request::find(
            DB_Ab1_Shop_Transport_Waybill_Car::NAME,
            $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB,
            $params, 0, true,
            array(
                'shop_raw_id' => array('name'),
                'shop_material_id' => array('name'),
                'shop_product_id' => array('name'),
                'shop_product_id' => array('name'),
                'shop_material_other_id' => array('name'),

                'shop_client_to_id' => array('name'),
                'shop_daughter_from_id' => array('name'),
                'shop_branch_to_id' => array('name'),
                'shop_branch_from_id' => array('name'),
                'shop_ballast_crusher_to_id' => array('name'),
                'shop_ballast_crusher_from_id' => array('name'),
                'shop_transportation_place_to_id' => array('name'),
                'shop_move_place_to_id' => array('name'),
                'shop_transport_route_id' => array('name'),
            )
        );

        foreach ($ids->childs as $child) {
            if ($child->values['shop_raw_id']) {
                $product = $child->getElementValue('shop_raw_id');
            } elseif ($child->values['shop_material_id']) {
                $product = $child->getElementValue('shop_material_id');
            } elseif ($child->values['shop_product_id']) {
                $product = $child->getElementValue('shop_product_id');
            } elseif ($child->values['shop_material_other_id']) {
                $product = $child->getElementValue('shop_material_other_id');
            } else {
                $product = $child->values['product_name'];
            }

            if ($child->values['shop_daughter_from_id']) {
                $from = $child->getElementValue('shop_daughter_from_id');
            } elseif ($child->values['shop_branch_from_id']) {
                $from = $child->getElementValue('shop_branch_from_id');
            } elseif ($child->values['shop_ballast_crusher_from_id']) {
                $from = $child->getElementValue('shop_ballast_crusher_from_id');
            } else {
                $from = '';
            }

            if ($child->values['shop_client_to_id']) {
                $to = $child->getElementValue('shop_client_to_id');
            } elseif ($child->values['shop_branch_to_id']) {
                $to = $child->getElementValue('shop_branch_to_id');
            } elseif ($child->values['shop_ballast_crusher_to_id']) {
                $to = $child->getElementValue('shop_ballast_crusher_to_id');
            } elseif ($child->values['shop_transportation_place_to_id']) {
                $to = $child->getElementValue('shop_transportation_place_to_id');
            } elseif ($child->values['shop_move_place_to_id']) {
                $to = $child->getElementValue('shop_move_place_to_id');
            } else {
                $to = 'to_name';
            }

            $dataCars['data'][] = array(
                'from' => $from,
                'to' => $to,
                'product' => $product,
                'route' => $child->getElementValue('shop_transport_route_id'),
                'trip' => $child->values['count_trip'],
                'distance' => $child->values['distance'],
                'quantity' => $child->values['quantity'],
            );

            $dataCars['trip'] += $child->values['count_trip'];
            $dataCars['distance'] += $child->values['distance'];
            $dataCars['quantity'] += $child->values['quantity'];
        }

        // получаем список выработок
        $dataWorks = array(
            'data' => array(),
            'quantity' => 0,
        );


        // список параметров для начислений заработной платы
        $workIDs = $waybill->getElementValue('transport_work_id', 'shop_transport_work_ids');
        $workIDs = explode(',', mb_substr($workIDs, 1, mb_strlen($workIDs) - 2));
        if(Helpers_Array::_empty($workIDs)){
            $workIDs = null;
        }

        $params = Request_RequestParams::setParams(
            array(
                'shop_transport_waybill_id' => $id,
                'shop_transport_work_id' => $workIDs,
            )
        );
        $ids = Request_Request::find(
            DB_Ab1_Shop_Transport_Waybill_Work_Driver::NAME,
            $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB,
            $params, 0, true,
            array(
                'shop_transport_work_id' => array('name'),
            )
        );
        foreach ($ids->childs as $child) {
            $dataWorks['data'][] = array(
                'name' => $child->getElementValue('shop_transport_work_id'),
                'quantity' => $child->values['quantity'],
            );

            $dataWorks['quantity'] += $child->values['quantity'];
        }

        $viewObject = 'ab1/_report/'.$this->_sitePageData->languageID.'/waybill/total';
        $tmp = str_replace('\\', '/', $viewObject);
        try {
            $view = View::factory($tmp);
        }catch (Exception $e) {
            throw new Exception('Шаблон "'.$tmp.'" не найден.');
        }

        $view->works = $dataWorks;
        $view->cars = $dataCars;
        $view->waybill = $dataWaybill;
        $view->operation = $this->_sitePageData->operation->getValues();
        $view->shop = $this->_sitePageData->shop->getName();
        $view->shopOptions = $this->_sitePageData->shop->getOptionsArray();
        $view->siteData = $this->_sitePageData;
        $strView = Helpers_View::viewToStr($view);

        header('Content-Type: application/x-download;charset=UTF-8');
        // header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: filename="АТ17 Итоги по путевому листу № ' . $waybill->values['number'] .'.xml"');
        header('Cache-Control: max-age=0');

        echo $strView;
        exit();
    }

    /**
     * АТ16 ТАБЕЛЬ учета маршрутов водителей
     * @throws Exception
     */
    public function action_waybill_route() {
        set_time_limit(36000);

        $this->_sitePageData->url = '/'.$this->actionURLName.'/shopreport/waybill_route';

        $dateFrom = Request_RequestParams::getParamDate('date_from');
        $dateTo = Request_RequestParams::getParamDate('date_to');

        $drivers = Api_Ab1_Shop_Transport_Waybill::getDriverTransportRouteValues(
            $dateFrom, $dateTo, $this->_sitePageData, $this->_driverDB
        );

        $viewObject = 'ab1/_report/'.$this->_sitePageData->languageID.'/waybill/route';
        $tmp = str_replace('\\', '/', $viewObject);
        try {
            $view = View::factory($tmp);
        }catch (Exception $e) {
            throw new Exception('Шаблон "'.$tmp.'" не найден.');
        }

        $view->drivers = $drivers;
        $view->dateFrom = $dateFrom;
        $view->dateTo = $dateTo;
        $view->operation = $this->_sitePageData->operation->getValues();
        $view->shop = $this->_sitePageData->shop->getName();
        $view->shopOptions = $this->_sitePageData->shop->getOptionsArray();
        $view->siteData = $this->_sitePageData;
        $strView = Helpers_View::viewToStr($view);

        header('Content-Type: application/x-download;charset=UTF-8');
        // header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: filename="АТ16 ТАБЕЛЬ учета маршрутов водителей за период ' . Helpers_DateTime::getPeriodRus($dateFrom, $dateTo) .'.xml"');
        header('Cache-Control: max-age=0');

        echo $strView;
        exit();
    }

    /**
     * Развернутый отчет по реализации по чекам
     */
    public function action_tax_checks() {
        $this->_sitePageData->url = '/'.$this->actionURLName.'/shopreport/tax_checks';

        $dateFrom = Request_RequestParams::getParamDate('created_at_from');
        $dateTo = Request_RequestParams::getParamDate('created_at_to');

        $params = Request_RequestParams::setParams(
            array(
                'created_at_from_equally' => $dateFrom,
                'created_at_to' => $dateTo . ' 23:59:59',
                'is_special' => [
                    Model_Magazine_Shop_Realization::SPECIAL_TYPE_BASIC,
                    Model_Magazine_Shop_Realization::SPECIAL_TYPE_PRODUCT,
                ]
            )
        );
        $ids = Request_Request::find('DB_Magazine_Shop_Realization',
            Request_RequestParams::getParamInt('_shop_branch_id'),
            $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
            array('shop_worker_id' => array('name'))
        );

        $dataRealizations = array(
            'data' => array(),
            'amount' => 0,
        );
        foreach ($ids->childs as $child){
            $amount = $child->values['amount'];

            $dataRealizations['data'][] = array(
                'created_at' => $child->values['created_at'],
                'fiscal_check' => $child->values['fiscal_check'],
                'worker' => $child->getElementValue('shop_worker_id'),
                'amount' => $amount,
            );

            $dataRealizations['amount'] += $amount;
        }

        $viewObject = 'magazine/_report/'.$this->_sitePageData->languageID.'/realization/tax-checks';
        $tmp = str_replace('\\', '/', $viewObject);
        try {
            $view = View::factory($tmp);
        }catch (Exception $e) {
            throw new Exception('Шаблон "'.$tmp.'" не найден.');
        }

        $view->realizations = $dataRealizations;
        $view->dateFrom = $dateFrom;
        $view->dateTo = $dateTo;
        $view->operation = $this->_sitePageData->operation->getValues();
        $view->siteData = $this->_sitePageData;
        $view->shop = $this->_sitePageData->shop->getName();
        $strView = Helpers_View::viewToStr($view);

        header('Content-Type: application/x-download;charset=UTF-8');
        // header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Развернутый отчет по реализации по чекам с '.Helpers_DateTime::getDateFormatRus($dateFrom).' по '.Helpers_DateTime::getDateFormatRus($dateTo).'.xml"');
        header('Cache-Control: max-age=0');

        echo $strView;
        exit();
    }

    /**
     * АБ12 Сводка по выпуску (АСУ/Место погрузки)
     * @throws Exception
     */
    public function action_realization_piece_asu() {
        set_time_limit(36000);

        $this->_sitePageData->url = '/'.$this->actionURLName.'/shopreport/realization_piece_asu';


        $dateFrom = Request_RequestParams::getParamDateTime('created_at_from');
        $dateTo = Request_RequestParams::getParamDateTime('created_at_to');

        $shopProductIDs = Api_Ab1_Shop_Product::findAllByMainRubric(
            Request_RequestParams::getParamInt('shop_product_rubric_id'),
            $this->_sitePageData, $this->_driverDB
        );

        // подразделения оператора
        $shopSubdivisionIDs = Request_RequestParams::getParamInt('shop_subdivision_id');
        if(empty($shopSubdivisionIDs)){
            $shopSubdivisionIDs = $this->_sitePageData->operation->getProductShopSubdivisionIDsArray();
        }

        /*********************************************************************/
        /************* Количество произведенного товара на склад *************/
        $params = Request_RequestParams::setParams(
            array(
                'shop_product_id' => $shopProductIDs,
                'created_at_from' => $dateFrom,
                'created_at_to' => $dateTo,
                'sum_quantity' => true,
                'shop_storage_id.shop_subdivision_id' => $shopSubdivisionIDs,
                'group_by' => array(
                    'shop_product_id', 'shop_product_id.name',
                    'shop_turn_place_id', 'shop_turn_place_id.name',
                )
            )
        );
        $shopProductStorageIDs = Request_Request::find('DB_Ab1_Shop_Product_Storage',
            $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB,
            $params, 0, true,
            array(
                'shop_turn_place_id' => array('name'),
                'shop_product_id' => array('name'),
            )
        );

        $turnPlaceStorages = [];
        foreach ($shopProductStorageIDs->childs as $child){
            $turnPlace = $child->values['shop_turn_place_id'];
            if (! key_exists($turnPlace, $turnPlaceStorages)){
                $turnPlaceStorages[$turnPlace] = array(
                    'quantity' => 0,
                    'data' => array(),
                    'name' => $child->getElementValue('shop_turn_place_id'),
                );
            }
        }
        uasort($turnPlaceStorages, array($this, 'mySortMethod'));

        $dataTurnPlaceStorages = [
            'data' => $turnPlaceStorages,
            'quantity' => 0,
        ];

        $dataMakes = array(
            'data' => array(),
            'quantity' => 0,
        );
        foreach ($shopProductStorageIDs->childs as $child){
            $quantity = $child->values['quantity'];
            $turn = $child->values['shop_turn_place_id'];
            $dataTurnPlaceStorages['data'][$turn]['quantity'] += $quantity;
            $dataTurnPlaceStorages['quantity'] += $quantity;

            $product = $child->values['shop_product_id'];
            if (! key_exists($product, $dataMakes['data'])){
                $dataMakes['data'][$product] = array(
                    'data' => $turnPlaceStorages,
                    'name' => $child->getElementValue('shop_product_id'),
                    'quantity' => 0
                );
            }

            $dataMakes['data'][$product]['data'][$turn]['quantity'] += $quantity;
            $dataMakes['data'][$product]['quantity'] += $quantity;
            $dataMakes['quantity'] += $quantity;
        }
        uasort($dataMakes['data'], array($this, 'mySortMethod'));

        /******************************************************************/
        /************* выпущенно продукции на заданный период *************/
        $params = Request_RequestParams::setParams(
            array(
                'shop_product_id' => $shopProductIDs,
                'shop_storage_id' => 0,
                'shop_storage_id.shop_subdivision_id' => $shopSubdivisionIDs,
                'sort_by' => array('shop_product_id' => 'asc')
            )
        );
        $ids = Api_Ab1_Shop_Car::getExitShopCar(
            $dateFrom, $dateTo, $this->_sitePageData, $this->_driverDB,
            array('shop_turn_place_id' => array('name'), 'shop_product_id' => array('name')),
            $params, false, null
        );

        // соединяем с внутренним перемещением
        $moveIDs = Api_Ab1_Shop_Move_Car::getExitShopMoveCar(
            $dateFrom, $dateTo, $this->_sitePageData, $this->_driverDB,
            array('shop_turn_place_id' => array('name'), 'shop_product_id' => array('name')),
            $params
        );
        $ids->addChilds($moveIDs);

        // соединяем с браком
        $defectIDs = Api_Ab1_Shop_Defect_Car::getExitShopDefectCar(
            $dateFrom, $dateTo, $this->_sitePageData, $this->_driverDB,
            array('shop_turn_place_id' => array('name'), 'shop_product_id' => array('name')),
            $params
        );
        $ids->addChilds($defectIDs);

        $turnPlaces = array();
        // реализация + перемещение
        foreach ($ids->childs as $child){
            $turnPlace = $child->values['shop_turn_place_id'];
            if (! key_exists($turnPlace, $turnPlaces)){
                $turnPlaces[$turnPlace] = array(
                    'quantity' => 0,
                    'data' => array(),
                    'name' => $child->getElementValue('shop_turn_place_id')
                );
            }
        }

        // производство на склад
        foreach ($shopProductStorageIDs->childs as $child){
            $turnPlace = $child->values['shop_turn_place_id'];
            if (! key_exists($turnPlace, $turnPlaces)){
                $turnPlaces[$turnPlace] = array(
                    'quantity' => 0,
                    'data' => array(),
                    'name' => $child->getElementValue('shop_turn_place_id'),
                );
            }
        }
        uasort($turnPlaces, array($this, 'mySortMethod'));

        /****************************************************/
        /************* реализация + перемещение *************/
        $dataTurnPlaces = $turnPlaces;
        $dataProducts = array(
            'data' => array(),
            'quantity' => 0,
        );

        // реализация + перемещение
        foreach ($ids->childs as $child){
            $quantity = $child->values['quantity'];
            $turn = $child->values['shop_turn_place_id'];
            $dataTurnPlaces[$turn]['quantity'] += $quantity;

            $product = $child->values['shop_product_id'];
            if (! key_exists($product, $dataProducts['data'])){
                $dataProducts['data'][$product] = array(
                    'data' => $turnPlaces,
                    'name' => $child->getElementValue('shop_product_id'),
                    'quantity' => 0
                );
            }

            $dataProducts['data'][$product]['data'][$turn]['quantity'] += $quantity;
            $dataProducts['data'][$product]['quantity'] += $quantity;
            $dataProducts['quantity'] += $quantity;
        }

        // производство на склад
        foreach ($shopProductStorageIDs->childs as $child){
            $quantity = $child->values['quantity'];
            $turn = $child->values['shop_turn_place_id'];
            $dataTurnPlaces[$turn]['quantity'] += $quantity;

            $product = $child->values['shop_product_id'];
            if (! key_exists($product, $dataProducts['data'])){
                $dataProducts['data'][$product] = array(
                    'data' => $turnPlaces,
                    'name' => $child->getElementValue('shop_product_id'),
                    'quantity' => 0
                );
            }

            $dataProducts['data'][$product]['data'][$turn]['quantity'] += $quantity;
            $dataProducts['data'][$product]['quantity'] += $quantity;
            $dataProducts['quantity'] += $quantity;
        }

        uasort($dataProducts['data'], array($this, 'mySortMethod'));

        /***************************************************/
        /************* ПЕРЕМЕЩЕНИЕ СО/НА СКЛАД *************/
        $dataMoveStorages = array(
            'data' => array(),
            'quantity_in' => 0,
            'quantity_out' => 0,
        );
        foreach ($shopProductStorageIDs->childs as $child){
            $quantity = $child->values['quantity'];

            $product = $child->values['shop_product_id'];
            if (! key_exists($product, $dataMoveStorages['data'])){
                $dataMoveStorages['data'][$product] = array(
                    'name' => $child->getElementValue('shop_product_id'),
                    'quantity_in' => 0,
                    'quantity_out' => 0,
                );
            }

            $dataMoveStorages['data'][$product]['quantity_in'] += $quantity;
            $dataMoveStorages['quantity_in'] += $quantity;
        }

        $params = Request_RequestParams::setParams(
            array(
                'shop_product_id' => $shopProductIDs,
                'shop_storage_id_from' => 0,
                'shop_storage_id.shop_subdivision_id' => $shopSubdivisionIDs,
                'sort_by' => array('shop_product_id' => 'asc')
            )
        );
        $ids = Api_Ab1_Shop_Car::getExitShopCar(
            $dateFrom, $dateTo, $this->_sitePageData, $this->_driverDB,
            array('shop_product_id' => array('name')),
            $params, false, null
        );

        $pieceItmIDs = Api_Ab1_Shop_Piece_Item::getExitShopPieceItems(
            $dateFrom, $dateTo, $this->_sitePageData, $this->_driverDB,
            array('shop_product_id' => array('name')),
            $params, false, null
        );
        $ids->addChilds($pieceItmIDs);

        $moveIDs = Api_Ab1_Shop_Move_Car::getExitShopMoveCar(
            $dateFrom, $dateTo, $this->_sitePageData, $this->_driverDB,
            array('shop_product_id' => array('name')),
            $params
        );
        $ids->addChilds($moveIDs);

        $defectIDs = Api_Ab1_Shop_Defect_Car::getExitShopDefectCar(
            $dateFrom, $dateTo, $this->_sitePageData, $this->_driverDB,
            array('shop_product_id' => array('name')),
            $params
        );
        $ids->addChilds($defectIDs);

        foreach ($ids->childs as $child){
            if($child->values['shop_storage_id'] < 1){
                continue;
            }

            $quantity = $child->values['quantity'];

            $product = $child->values['shop_product_id'];
            if (! key_exists($product, $dataMoveStorages['data'])){
                $dataMoveStorages['data'][$product] = array(
                    'name' => $child->getElementValue('shop_product_id'),
                    'quantity_in' => 0,
                    'quantity_out' => 0,
                );
            }

            $dataMoveStorages['data'][$product]['quantity_out'] += $quantity;
            $dataMoveStorages['quantity_out'] += $quantity;
        }

        /**********************************************/
        /************* ОСТАТКИ НА СКЛАДАХ *************/
        $params = Request_RequestParams::setParams(
            array(
                'shop_product_id' => $shopProductIDs,
                'created_at_to' => $dateTo,
                'sum_quantity' => true,
                'shop_storage_id.shop_subdivision_id' => $shopSubdivisionIDs,
                'group_by' => array(
                    'shop_product_id', 'shop_product_id.name',
                )
            )
        );

        // получаем список
        $shopProductStorageIDs = Request_Request::find('DB_Ab1_Shop_Product_Storage',
            $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB,
            $params, 0, true,
            array(
                'shop_product_id' => array('name'),
            )
        );

        $dataTotalStorages = array(
            'data' => array(),
            'quantity' => 0,
        );
        foreach ($shopProductStorageIDs->childs as $child){
            $quantity = $child->values['quantity'];

            $product = $child->values['shop_product_id'];
            if (! key_exists($product, $dataTotalStorages['data'])){
                $dataTotalStorages['data'][$product] = array(
                    'name' => $child->getElementValue('shop_product_id'),
                    'quantity' => 0,
                );
            }

            $dataTotalStorages['data'][$product]['quantity'] += $quantity;
            $dataTotalStorages['quantity'] += $quantity;
        }

        // выпущенно продукции на заданный период
        $params = Request_RequestParams::setParams(
            array(
                'shop_product_id' => $shopProductIDs,
                'sort_by' => array('shop_product_id' => 'asc'),
                'shop_storage_id_from' => 0,
                'sum_quantity' => true,
                'shop_storage_id.shop_subdivision_id' => $shopSubdivisionIDs,
                'group_by' => array(
                    'shop_product_id', 'shop_product_id.name',
                )
            )
        );
        $ids = Api_Ab1_Shop_Car::getExitShopCar(
            null, $dateTo, $this->_sitePageData, $this->_driverDB,
            array('shop_product_id' => array('name')),
            $params, false, null
        );

        $pieceItmIDs = Api_Ab1_Shop_Piece_Item::getExitShopPieceItems(
            $dateFrom, $dateTo, $this->_sitePageData, $this->_driverDB,
            array('shop_product_id' => array('name')),
            $params, false, null
        );
        $ids->addChilds($pieceItmIDs);

        // соединяем с браком
        $moveIDs = Api_Ab1_Shop_Move_Car::getExitShopMoveCar(
            $dateFrom, $dateTo, $this->_sitePageData, $this->_driverDB,
            array('shop_product_id' => array('name')),
            $params
        );
        $ids->addChilds($moveIDs);

        // соединяем с браком
        $defectIDs = Api_Ab1_Shop_Defect_Car::getExitShopDefectCar(
            $dateFrom, $dateTo, $this->_sitePageData, $this->_driverDB,
            array('shop_product_id' => array('name')),
            $params
        );
        $ids->addChilds($defectIDs);

        // реализация + перемещение
        foreach ($ids->childs as $child) {
            $quantity = $child->values['quantity'];

            $product = $child->values['shop_product_id'];
            if (!key_exists($product, $dataTotalStorages['data'])) {
                $dataTotalStorages['data'][$product] = array(
                    'name' => $child->getElementValue('shop_product_id'),
                    'quantity' => 0,
                );
            }

            $dataTotalStorages['data'][$product]['quantity'] -= $quantity;
            $dataTotalStorages['quantity'] -= $quantity;
        }

        $viewObject = 'ab1/_report/'.$this->_sitePageData->languageID.'/realization/piece-asu';
        $tmp = str_replace('\\', '/', $viewObject);
        try {
            $view = View::factory($tmp);
        }catch (Exception $e) {
            throw new Exception('Шаблон "'.$tmp.'" не найден.');
        }

        $view->makes = $dataMakes;
        $view->totalStorages = $dataTotalStorages;
        $view->moveStorages = $dataMoveStorages;
        $view->turnPlaceStorages = $dataTurnPlaceStorages;
        $view->products = $dataProducts;
        $view->turnPlaces = $dataTurnPlaces;
        $view->operation = $this->_sitePageData->operation->getValues();
        $view->shop = $this->_sitePageData->shop->getName();
        $view->shopOptions = $this->_sitePageData->shop->getOptionsArray();
        $strView = Helpers_View::viewToStr($view);

        header('Content-Type: application/x-download;charset=UTF-8');
        // header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: filename="АБ12 Сводка по выпуску (АСУ/Место погрузки).xml"');
        header('Cache-Control: max-age=0');

        echo $strView;
        exit();
    }

    /**
     * АБ11 Сводка по реализации
     * @throws Exception
     * @throws HTTP_Exception_404
     * @throws HTTP_Exception_500
     */
    public function action_realization_piece_turn_type() {
        set_time_limit(36000);

        $this->_sitePageData->url = '/'.$this->actionURLName.'/shopreport/realization_piece_turn_type';

        $shopProductRubricID = Request_RequestParams::getParamInt('shop_product_rubric_id');
        if($shopProductRubricID < 1){
            throw new HTTP_Exception_500('Rubric not found.');
        }

        $modelRubric = new Model_Ab1_Shop_Product_Rubric();
        $modelRubric->setDBDriver($this->_driverDB);
        if ($shopProductRubricID > 0) {
            if (!(($shopProductRubricID > 0)
                && (Helpers_DB::getDBObject($modelRubric, $shopProductRubricID, $this->_sitePageData, $this->_sitePageData->shopMainID)))) {
                throw new HTTP_Exception_404('Turn type not found.');
            }

            // считываем детвору
            $shopProductRubricIDs = Request_Request::find('DB_Ab1_Shop_Product_Rubric',
                $this->_sitePageData->shopMainID, $this->_sitePageData, $this->_driverDB,
                array('root_id' => $shopProductRubricID, 'sort_by' => array('value' => array('name' => 'asc')), Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE),
                0, TRUE);

            $rubricIDs = $shopProductRubricIDs->getChildArrayID();
            $rubricIDs[] = $shopProductRubricID;

            $shopProductIDs = Request_Request::find('DB_Ab1_Shop_Product',
                $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB,
                array(
                    'shop_product_rubric_id' => array('value' => $rubricIDs),
                    'is_public_ignore' => true,
                    'is_delete_ignore' => true,
                    Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE), 0, TRUE
            )->getChildArrayID();

            if (count($shopProductIDs) == 0) {
                throw new HTTP_Exception_404('Products rubric not found.');
            }
        }else{
            $shopProductIDs = NULL;
            $shopProductRubricIDs = new MyArray();
        }

        // подразделения оператора
        $shopSubdivisionIDs = Request_RequestParams::getParamInt('shop_subdivision_id');
        if(empty($shopSubdivisionIDs)){
            $shopSubdivisionIDs = $this->_sitePageData->operation->getProductShopSubdivisionIDsArray();
        }

        $dateFrom = Request_RequestParams::getParamDateTime('exit_at_from');
        $dateTo = Request_RequestParams::getParamDateTime('exit_at_to');
        $params = Request_RequestParams::setParams(
            array(
                'shop_product_id' => $shopProductIDs,
                'sort_by' => array('shop_product_id' => 'asc'),
                'shop_subdivision_id' => $shopSubdivisionIDs,
            )
        );
        $ids = Api_Ab1_Shop_Car::getExitShopCar(
            $dateFrom, $dateTo, $this->_sitePageData, $this->_driverDB,
            array('shop_client_id' => array('name'), 'shop_product_id' => array('name', 'shop_product_rubric_id')),
            $params
        );
        $pieceItemIDs = Api_Ab1_Shop_Piece_Item::getExitShopPieceItems(
            $dateFrom, $dateTo, $this->_sitePageData, $this->_driverDB,
            array('shop_client_id' => array('name'), 'shop_product_id' => array('name', 'shop_product_rubric_id')),
            $params
        );
        $ids->addChilds($pieceItemIDs);
        $ticketCount = count($ids->childs);

        // список продукции
        $products = array();
        foreach ($ids->childs as $child){
            $product = $child->values['shop_product_id'];
            if (! key_exists($product, $products)){
                $products[$product] = array(
                    'quantity' => 0,
                    'data' => array(),
                    'name' => $child->getElementValue('shop_product_id')
                );
            }
        }
        uasort($products, array($this, 'mySortMethod'));

        // список подрубрик
        $dataProductRubrics = array();
        foreach ($shopProductRubricIDs->childs as $child){
            $dataProductRubrics[$child->id] = array(
                'name' => $child->values['name'],
                'quantity' => 0,
            );
        }
        uasort($dataProductRubrics, array($this, 'mySortMethod'));
        $dataProductRubrics[$shopProductRubricID] = array(
            'name' => $modelRubric->getName(),
            'quantity' => 0,
        );

        $dataProducts = $products;
        $dataClients = array(
            'data' => array(),
            'quantity' => 0,
        );
        foreach ($ids->childs as $child){
            $quantity = $child->values['quantity'];

            $product = $child->values['shop_product_id'];
            $dataProducts[$product]['quantity'] += $quantity;

            $client = $child->values['shop_client_id'];
            if (! key_exists($client, $dataClients['data'])){
                $dataClients['data'][$client] = array(
                    'data' => $products,
                    'name' => $child->getElementValue('shop_client_id'),
                    'quantity' => 0
                );
            }

            $tmp = Arr::path($child->values, Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_product_id.shop_product_rubric_id', 0);
            if ($tmp > 0) {
                $dataProductRubrics[$tmp]['quantity'] += $quantity;
            }

            $dataClients['data'][$client]['data'][$product]['quantity'] += $quantity;
            $dataClients['data'][$client]['quantity'] += $quantity;
            $dataClients['quantity'] += $quantity;
        }
        $dataProductRubrics[$shopProductRubricID]['quantity'] = $dataClients['quantity'];

        uasort($dataClients['data'], array($this, 'mySortMethod'));

        // Находим продукцию собранной с холодного склада
        $params = array_merge(
            Request_RequestParams::setParams(
                array(
                    'exit_at_from' => $dateFrom,
                    'exit_at_to' => $dateTo,
                    'is_exit' => 1,
                    'quantity_from' => 0,
                    'is_charity' => FALSE,
                    'sum_quantity' => true,
                    'shop_turn_place_id' => [58086, 761594], // Холодный склад
                    'shop_subdivision_id' => $shopSubdivisionIDs,
                    'group_by' => array(
                        'shop_product_id', 'shop_product_id.name'
                    )
                )
            ),
            $params
        );
        $ids = Request_Request::find('DB_Ab1_Shop_Car',
            $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
            array(
                'shop_product_id' => array('name')
            )
        );

        $dataStorage = array(
            'data' => array(),
            'quantity' => 0,
        );
        foreach ($ids->childs as $child){
            $quantity = $child->values['quantity'];
            $product = $child->values['shop_product_id'];

            if (! key_exists($product, $dataStorage['data'])){
                $dataStorage['data'][$product] = array(
                    'name' => $child->getElementValue('shop_product_id'),
                    'quantity' => 0
                );
            }

            $dataStorage['data'][$product]['quantity'] += $quantity;
            $dataStorage['quantity'] += $quantity;
        }
        uasort($dataStorage['data'], array($this, 'mySortMethod'));

        $viewObject = 'ab1/_report/'.$this->_sitePageData->languageID.'/realization/piece-turn_type';
        $tmp = str_replace('\\', '/', $viewObject);
        try {
            $view = View::factory($tmp);
        }catch (Exception $e) {
            throw new Exception('Шаблон "'.$tmp.'" не найден.');
        }

        $view->products = $dataProducts;
        $view->clients = $dataClients;
        $view->rubric = $modelRubric->getValues();
        $view->childRubrics = $dataProductRubrics;
        $view->storage = $dataStorage;
        $view->ticketCount = $ticketCount;
        $view->operation = $this->_sitePageData->operation->getValues();
        $view->shop = $this->_sitePageData->shop->getName();
        $view->shopOptions = $this->_sitePageData->shop->getOptionsArray();
        $strView = Helpers_View::viewToStr($view);

        //header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Type: application/x-download;charset=UTF-8');
        header('Content-Disposition: filename="АБ11 Сводка по реализации.xml"');
        header('Cache-Control: max-age=0');

        echo $strView;
        exit();
    }

    /**
     * Сохраняем счет на оплату в PDF
     */
    public function action_invoice_proforma_pdf()
    {
        $this->_sitePageData->url = '/'.$this->actionURLName.'/shopreport/invoice_proforma_pdf';

        Api_Ab1_Shop_Invoice_Proforma::saveInPDF(
            Request_RequestParams::getParamInt('id'),
            $this->_sitePageData, $this->_driverDB
        );
    }

    /**
     * СБ12 Отчет по договорам поставки
     * @throws Exception
     */
    public function action_contract_supply() {
        set_time_limit(36000);

        $this->_sitePageData->url = '/'.$this->actionURLName.'/shopreport/contract_supply';

        $dateFrom = Request_RequestParams::getParamDateTime('date_from');
        $dateTo = Request_RequestParams::getParamDateTime('date_to');
        $params = Request_RequestParams::setParams(
            array(
                'created_at_from' => $dateFrom,
                'created_at_to' => $dateTo,
                'shop_client_contract_id_from' => 0,
                'shop_client_id' => Request_RequestParams::getParamInt('shop_client_id'),
                'sort_by' => array(
                    'shop_client_id.name' => 'asc',
                    'shop_client_contract_id.from_at' => 'desc',
                    'shop_product_id.name' => 'asc',
                )
            )
        );
        $ids = Request_Request::findBranch(
            'DB_Ab1_Shop_Car_Item',
            array(), $this->_sitePageData, $this->_driverDB, $params,0, TRUE,
            array(
                'shop_client_id' => array('name'),
                'shop_product_id' => array('name'),
                'shop_client_contract_id' => array('number', 'amount', 'quantity', 'from_at', 'to_at'),
            )
        );
        $shopPieceIDs = Request_Request::findBranch(
            'DB_Ab1_Shop_Piece_Item',
            array(), $this->_sitePageData, $this->_driverDB, $params,0, TRUE,
            array(
                'shop_client_id' => array('name'),
                'shop_product_id' => array('name'),
                'shop_client_contract_id' => array('number', 'amount', 'quantity', 'from_at', 'to_at'),
            )
        );
        $ids->addChilds($shopPieceIDs);

        $dataClients = array(
            'data' => array(),
            'contract_quantity' => 0,
            'contract_amount' => 0,
            'quantity' => 0,
            'amount' => 0,
        );
        foreach ($ids->childs as $child){
            $amount = $child->values['amount'];
            $quantity = $child->values['quantity'];
            $client = $child->values['shop_client_id'];
            $product = $child->values['shop_product_id'];
            $contract = $child->values['shop_client_contract_id'];
            $contractItem = $child->values['shop_client_contract_item_id'];
            $price = $child->values['price'];

            /** Создаем группу клиентов **/
            if (!key_exists($client, $dataClients['data'])) {
                $dataClients['data'][$client] = array(
                    'name' => $child->getElementValue('shop_client_id'),
                    'id' => $client,
                    'data' => array(),
                    'contract_quantity' => 0,
                    'contract_amount' => 0,
                    'quantity' => 0,
                    'amount' => 0,
                );
            }

            /** Создаем группу договоров **/
            if (!key_exists($contract, $dataClients['data'][$client]['data'])) {
                $totalAmount = $child->getElementValue('shop_client_contract_id', 'amount');
                $dataClients['data'][$client]['contract_amount'] += $totalAmount;

                $totalQuantity = $child->getElementValue('shop_client_contract_id', 'quantity');
                $dataClients['data'][$client]['contract_quantity'] += $totalQuantity;

                $dataClients['data'][$client]['data'][$contract] = array(
                    'number' => $child->getElementValue('shop_client_contract_id', 'number'),
                    'from_at' => $child->getElementValue('shop_client_contract_id', 'from_at'),
                    'to_at' => $child->getElementValue('shop_client_contract_id', 'to_at'),
                    'id' => $contract,
                    'data' => array(),
                    'contract_quantity' => $totalQuantity,
                    'contract_amount' => $totalAmount,
                    'quantity' => 0,
                    'amount' => 0,
                );

                $shopClientContractItems = Request_Request::findBranch(
                    'DB_Ab1_Shop_Client_Contract_Item',
                    array(), $this->_sitePageData, $this->_driverDB,
                    Request_RequestParams::setParams(
                        array(
                            'basic_or_contract' => $contract,
                        )
                    ),
                    0, TRUE,
                    array(
                        'shop_product_id' => array('name'),
                        'shop_product_rubric_id' => array('name'),
                    )
                );

                /** Для договора выбираем список групп товаров заложенных в договоре **/
                foreach ($shopClientContractItems->childs as $item){
                    $itemID = $item->values['shop_product_id'];
                    if($itemID > 0){
                        $name = $item->getElementValue('shop_product_id', 'name');
                        $productIDs = array($itemID);
                    }else{
                        $itemID = $item->values['shop_product_rubric_id'];
                        if($itemID > 0) {
                            $name = $item->getElementValue('shop_product_rubric_id', 'name');

                            $productIDs = Api_Ab1_Shop_Product::findAllByMainRubric(
                                $itemID, $this->_sitePageData, $this->_driverDB
                            );
                            if ($productIDs === NULL) {
                                $productIDs = array();
                            }
                        }else{
                            $name = 'Все';
                            $productIDs = array();
                        }
                    }

                    if($item->values['shop_product_id'] > 0){
                        $itemID .= '_' . $item->values['price'];
                    }
                    if (!key_exists($itemID, $dataClients['data'][$client]['data'][$contract]['data'])) {
                        $dataClients['data'][$client]['data'][$contract]['data'][$itemID] = array(
                            'name' => $name,
                            'id' => $itemID,
                            'is_product' => $item->values['shop_product_id'] > 0,
                            'price' => $item->values['price'],
                            'products' => $productIDs,
                            'contract_items' => array(),
                            'data' => array(),
                            'contract_quantity' => 0,
                            'contract_amount' => 0,
                            'quantity' => 0,
                            'amount' => 0,
                        );
                    }

                    if($contractItem > 0) {
                        $dataClients['data'][$client]['data'][$contract]['data'][$itemID]['contract_items'][] = $contractItem;
                    }
                    $dataClients['data'][$client]['data'][$contract]['data'][$itemID]['contract_amount'] += $item->values['amount'];
                    $dataClients['data'][$client]['data'][$contract]['data'][$itemID]['contract_quantity'] += $item->values['quantity'];
                }
            }

            // узнаем группу товаров в договоре
            $contractItem = 0;
            foreach ($dataClients['data'][$client]['data'][$contract]['data'] as $item) {
                if($item['is_product'] && $item['price'] != $price){
                    continue;
                }

                if ($contractItem > 0 && array_search($contractItem, $item['contract_items']) !== FALSE) {
                    $contractItem = $item['id'];
                    break;
                }
                if (array_search($product, $item['products']) !== FALSE) {
                    if($contractItem == 0 || $item['contract_amount'] - $item['amount'] >= $amount){
                        $contractItem = $item['id'];

                        if($item['contract_amount'] - $item['amount'] >= $amount){
                            $contractItem = $item['id'];
                            break;
                        }
                    }
                }
            }
            if ($contractItem == 0 && !key_exists($contractItem, $dataClients['data'][$client]['data'][$contract]['data'])) {
                $dataClients['data'][$client]['data'][$contract]['data'][$contractItem] = array(
                    'name' => 'Вне договора',
                    'id' => 0,
                    'is_product' => false,
                    'contract_items' => array(),
                    'products' => array(),
                    'data' => array(),
                    'contract_quantity' => 0,
                    'contract_amount' => 0,
                    'quantity' => 0,
                    'amount' => 0,
                );
            }

            /** Создаем группу товаров **/
            $key = $product.'_'.$price;
            if (!key_exists($key, $dataClients['data'][$client]['data'][$contract]['data'][$contractItem]['data'])) {
                $dataClients['data'][$client]['data'][$contract]['data'][$contractItem]['data'][$key] = array(
                    'name' => $child->getElementValue('shop_product_id'),
                    'id' => $product,
                    'contract_quantity' => 0,
                    'contract_amount' => 0,
                    'quantity' => 0,
                    'amount' => 0,
                );
            }
            $dataClients['data'][$client]['data'][$contract]['data'][$contractItem]['data'][$key]['amount'] += $amount;
            $dataClients['data'][$client]['data'][$contract]['data'][$contractItem]['data'][$key]['quantity'] += $quantity;

            $dataClients['data'][$client]['data'][$contract]['data'][$contractItem]['amount'] += $amount;
            $dataClients['data'][$client]['data'][$contract]['data'][$contractItem]['quantity'] += $quantity;

            $dataClients['data'][$client]['data'][$contract]['amount'] += $amount;
            $dataClients['data'][$client]['data'][$contract]['quantity'] += $quantity;

            $dataClients['data'][$client]['amount'] += $amount;
            $dataClients['data'][$client]['quantity'] += $quantity;

            $dataClients['amount'] += $amount;
            $dataClients['quantity'] += $quantity;
        }

        $dataProducts = array(
            'data' => array(),
            'contract_quantity' => 0,
            'contract_amount' => 0,
            'quantity' => 0,
            'amount' => 0,
            'balance_quantity' => 0,
            'balance_amount' => 0,
        );
        foreach ($dataClients['data'] as $dataClient){
            foreach ($dataClient['data'] as $dataContract){
                foreach ($dataContract['data'] as $dataContractItem){
                    $quantity = $dataContractItem['quantity'];
                    if($quantity == 0){
                        $quantity = 1;
                    }

                    $contractQuantity = $dataContractItem['contract_quantity'];
                    if($contractQuantity == 0){
                        $contractQuantity = 1;
                    }

                    $dataProducts['data'][] = array(
                        'contract_number' => $dataContract['number'],
                        'from_at' => $dataContract['from_at'],
                        'to_at' => $dataContract['to_at'],
                        'client' => $dataClient['name'],
                        'product' => $dataContractItem['name'],
                        'contract_quantity' => $dataContractItem['contract_quantity'],
                        'contract_price' => round($dataContractItem['contract_amount'] / $contractQuantity , 2),
                        'contract_amount' => $dataContractItem['contract_amount'],
                        'quantity' => $dataContractItem['quantity'],
                        'price' => round($dataContractItem['amount'] / $quantity , 2),
                        'amount' => $dataContractItem['amount'],
                        'balance_quantity' => $dataContractItem['contract_quantity'] - $dataContractItem['quantity'],
                        'balance_amount' => $dataContractItem['contract_amount'] - $dataContractItem['amount'],
                    );
                }
            }
        }

        $viewObject = 'ab1/_report/'.$this->_sitePageData->languageID.'/contract/supply';
        $tmp = str_replace('\\', '/', $viewObject);
        try {
            $view = View::factory($tmp);
        }catch (Exception $e) {
            throw new Exception('Шаблон "'.$tmp.'" не найден.');
        }

        $view->products = $dataProducts;
        $view->dateFrom = $dateFrom;
        $view->dateTo = $dateTo;
        $view->operation = $this->_sitePageData->operation->getValues();
        $view->shop = $this->_sitePageData->shop->getName();
        $view->shopOptions = $this->_sitePageData->shop->getOptionsArray();
        $strView = Helpers_View::viewToStr($view);

        header('Content-Type: application/x-download;charset=UTF-8');
        // header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: filename="СБ12 Отчет по договорам поставки за '.str_replace(':', '-', Helpers_DateTime::getPeriodRus($dateFrom, $dateTo)).'.xml"');
        header('Cache-Control: max-age=0');

        echo $strView;
        exit();
    }


    /**
     * СБ11 Контроль по отгрузке клиентов
     * @throws Exception
     */
    public function action_attorney_control() {
        set_time_limit(36000);

        $this->_sitePageData->url = '/'.$this->actionURLName.'/shopreport/attorney_control';

        $params = Request_RequestParams::setParams(
            array(
                'validity' => date('Y-m-d'),
                'sort_by' => array(
                    'shop_client_id.name' => 'asc',
                    'number' => 'asc'
                ),
            ),
            false
        );
        $shopClientAttorneyIDs = Request_Request::find('DB_Ab1_Shop_Client_Attorney',
            $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB,
            $params,0, true,
            array(
                'shop_client_id' => array('name', 'balance', 'balance_cache'),
                'create_user_id' => array('name')
            )
        );

        $dataAttorneys = array(
            'data' => array(),
        );

        foreach ($shopClientAttorneyIDs->childs as $child){
            $balance = $child->getElementValue('shop_client_id', 'balance', 0);
            $balanceCash = $child->getElementValue('shop_client_id', 'balance_cache', 0);
            $balance -= $balanceCash;

            $dataAttorneys['data'][] = array(
                'client' => $child->getElementValue('shop_client_id'),
                'number' => $child->values['number'],
                'from_at' => $child->values['from_at'],
                'to_at' => $child->values['to_at'],
                'balance' => $child->values['balance'],
                'client_balance' => $balance,
                'diff' => $balance - $child->values['balance'],
                'balance_cash' => $balanceCash,
                'create_user' => $child->getElementValue('create_user_id'),
            );
        }

        $viewObject = 'ab1/_report/'.$this->_sitePageData->languageID.'/attorney/control';
        $tmp = str_replace('\\', '/', $viewObject);
        try {
            $view = View::factory($tmp);
        }catch (Exception $e) {
            throw new Exception('Шаблон "'.$tmp.'" не найден.');
        }

        $view->attorneys = $dataAttorneys;
        $view->operation = $this->_sitePageData->operation->getValues();
        $view->shop = $this->_sitePageData->shop->getName();
        $view->shopOptions = $this->_sitePageData->shop->getOptionsArray();
        $strView = Helpers_View::viewToStr($view);

        header('Content-Type: application/x-download;charset=UTF-8');
        // header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: filename="СБ11 Контроль по отгрузке клиентов.xml"');
        header('Cache-Control: max-age=0');

        echo $strView;
        exit();
    }

    /**
     * CБ11 Реестр выгруженные накладных в 1С и акты выполнненных работ
     * @throws Exception
     */
    public function action_invoice_save_1c() {
        set_time_limit(36000);

        $this->_sitePageData->url = '/'.$this->actionURLName.'/shopreport/invoice_save_1c';

        $dateFrom = Request_RequestParams::getParamDate('date_from');
        $dateTo = Request_RequestParams::getParamDate('date_to');

        // Список накладная
        $params = Request_RequestParams::setParams(
            array(
                'date_from_equally' => $dateFrom,
                'date_to' => Helpers_DateTime::plusDays($dateTo, 1),
                'sort_by' => array(
                    'shop_client_id.name' => 'asc',
                    'date' => 'asc',
                    'number' => 'asc',
                )
            )
        );
        $shopInvoiceIDs = Request_Request::find('DB_Ab1_Shop_Invoice',
            $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
            array(
                'shop_client_id' => array('name')
            )
        );

        $dataInvoices = array(
            'data' => array(),
            'amount_nds' => 0,
            'amount' => 0,
        );

        foreach ($shopInvoiceIDs->childs as $child){
            $dataInvoices['data'][] = array(
                'data' => array(),
                'number' => $child->values['number'],
                'date' => $child->values['date'],
                'client' => $child->getElementValue('shop_client_id'),
                'amount' => $child->values['amount'],
            );

            $dataInvoices['amount'] += $child->values['amount'];
        }

        uasort($dataInvoices['data'], function ($x, $y) {
            return strcasecmp($x['number'], $y['number']);
        });

        // Список актов выполненных работ
        $params = Request_RequestParams::setParams(
            array(
                'date_from' => $dateFrom,
                'date_to' => Helpers_DateTime::plusDays($dateTo, 1),
                'sort_by' => array(
                    'shop_client_id.name' => 'asc',
                    'date' => 'asc',
                    'number' => 'asc',
                )
            )
        );
        $shopActIDs = Request_Request::find(
            DB_Ab1_Shop_Act_Service::NAME,
            $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
            array(
                'shop_client_id' => array('name')
            )
        );

        $dataActs = array(
            'data' => array(),
            'amount_nds' => 0,
            'amount' => 0,
        );

        foreach ($shopActIDs->childs as $child){
            $dataActs['data'][] = array(
                'data' => array(),
                'number' => $child->values['number'],
                'date' => $child->values['date'],
                'client' => $child->getElementValue('shop_client_id'),
                'amount' => $child->values['amount'],
            );

            $dataActs['amount'] += $child->values['amount'];
        }

        uasort($dataActs['data'], function ($x, $y) {
            return strcasecmp($x['number'], $y['number']);
        });


        $viewObject = 'ab1/_report/'.$this->_sitePageData->languageID.'/invoice/save-1c';
        $tmp = str_replace('\\', '/', $viewObject);
        try {
            $view = View::factory($tmp);
        }catch (Exception $e) {
            throw new Exception('Шаблон "'.$tmp.'" не найден.');
        }

        $view->invoices = $dataInvoices;
        $view->acts = $dataActs;
        $view->dateFrom = $dateFrom;
        $view->dateTo = $dateTo;
        $view->operation = $this->_sitePageData->operation->getValues();
        $view->shop = $this->_sitePageData->shop->getName();
        $view->shopOptions = $this->_sitePageData->shop->getOptionsArray();
        $strView = Helpers_View::viewToStr($view);

        header('Content-Type: application/x-download;charset=UTF-8');
        // header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: filename="CБ11 Реестр выгруженные накладных в 1С c ' . Helpers_DateTime::getDateFormatRus($dateFrom) . ' по ' . Helpers_DateTime::getDateFormatRus($dateTo) . '.xml"');
        header('Cache-Control: max-age=0');

        echo $strView;
        exit();
    }

    /**
     * АТ15 Материальный отчет по ГСМ
     * @throws Exception
     */
    public function action_transport_fuels() {
        set_time_limit(36000);

        $this->_sitePageData->url = '/'.$this->actionURLName.'/shopreport/transport_fuels';

        $dateFrom = Request_RequestParams::getParamDate('date_from');
        $dateTo = Request_RequestParams::getParamDate('date_to');

        $dataFuels = array(
            'data' => array(),
        );
        $dataFuelIssueDepartments = array(
            'data' => array(),
        );
        $dataFuelExpenseDepartments = array(
            'data' => array(),
        );
        $dataFuelExpenseTransports = array(
            'data' => array(),
        );

        // приход топлива
        $params = Request_RequestParams::setParams(
            array(
                'date_from_equally' => $dateFrom,
                'date_to' => $dateTo
            )
        );
        $ids = Request_Request::find(
            DB_Ab1_Shop_Transport_Fuel_Issue::NAME,
            0, $this->_sitePageData, $this->_driverDB,
            $params, 0, true,
            array(
                'fuel_id' => array('name'),
                'shop_id' => array('name'),
                'fuel_id.fuel_type_id' => array('unit'),
            )
        );

        foreach ($ids->childs as $child) {
            $fuel = $child->values['fuel_id'];
            if(!key_exists($fuel, $dataFuels['data'])){
                $dataFuels['data'][$fuel] = array(
                    'name' => $child->getElementValue('fuel_id'),
                    'unit' => $child->getElementValue('fuel_type_id', 'unit'),
                    'from' => 0,
                    'issue' => 0,
                    'issues' => array(),
                    'expense' => 0,
                    'expenses' => array(),
                );
            }


            $shop = $child->values['shop_id'];
            if(!key_exists($shop, $dataFuelIssueDepartments['data'])){
                $dataFuelIssueDepartments['data'][$shop] = array(
                    'id' => $shop,
                    'name' => $child->getElementValue('shop_id'),
                );
            }

            if(!key_exists($shop, $dataFuels['data'][$fuel]['issues'])){
                $dataFuels['data'][$fuel]['issues'][$shop] = 0;
            }

            $quantity = $child->values['quantity'];

            // наличные
            if($child->values['is_cash']) {
                if(!key_exists('cash', $dataFuelIssueDepartments['data'])){
                    $dataFuelIssueDepartments['data']['cash'] = array(
                        'id' => $child->values['shop_id'],
                        'name' => 'Наличные',
                    );
                }

                if (!key_exists('cash', $dataFuels['data'][$fuel]['issues'])) {
                    $dataFuels['data'][$fuel]['issues']['cash'] = 0;
                }

                $dataFuels['data'][$fuel]['issues']['cash'] += $quantity;
            }

            $dataFuels['data'][$fuel]['issue'] += $quantity;
            $dataFuels['data'][$fuel]['issues'][$shop] += $quantity;
        }

        // расход топлива по подразделениям
        $params = Request_RequestParams::setParams(
            array(
                'date_from_equally' => $dateFrom,
                'date_to' => $dateTo,
                'shop_transport_id' => 0,
            )
        );
        $ids = Request_Request::find(
            DB_Ab1_Shop_Transport_Fuel_Expense::NAME,
            0, $this->_sitePageData, $this->_driverDB,
            $params, 0, true,
            array(
                'fuel_id' => array('name'),
                'shop_move_client_id' => array('name'),
                'fuel_id.fuel_type_id' => array('unit'),
            )
        );

        foreach ($ids->childs as $child) {
            $fuel = $child->values['fuel_id'];
            if(!key_exists($fuel, $dataFuels['data'])){
                $dataFuels['data'][$fuel] = array(
                    'name' => $child->getElementValue('fuel_id'),
                    'unit' => $child->getElementValue('fuel_type_id', 'unit'),
                    'from' => 0,
                    'issue' => 0,
                    'issues' => array(),
                    'expense' => 0,
                    'expenses' => array(),
                );
            }

            $shop = 'd' . $child->values['shop_move_client_id'];
            if(!key_exists($shop, $dataFuelExpenseDepartments['data'])){
                $dataFuelExpenseDepartments['data'][$shop] = array(
                    'id' => $shop,
                    'name' => $child->getElementValue('shop_move_client_id'),
                );
            }

            if(!key_exists($shop, $dataFuels['data'][$fuel]['expenses'])){
                $dataFuels['data'][$fuel]['expenses'][$shop] = 0;
            }

            $quantity = $child->values['quantity'];

            $dataFuels['data'][$fuel]['expense'] += $quantity;
            $dataFuels['data'][$fuel]['expenses'][$shop] += $quantity;
        }

        // расход топлива по типам транспорта 1С
        $params = Request_RequestParams::setParams(
            array(
                'date_from_equally' => $dateFrom,
                'date_to' => $dateTo,
                'shop_transport_id_from' => 0,
            )
        );
        $ids = Request_Request::find(
            DB_Ab1_Shop_Transport_Fuel_Expense::NAME,
            0, $this->_sitePageData, $this->_driverDB,
            $params, 0, true,
            array(
                'fuel_id' => array('name'),
                'shop_transport_mark_id.transport_type_1c_id' => array('id', 'name'),
                'fuel_id.fuel_type_id' => array('unit'),
            )
        );

        foreach ($ids->childs as $child) {
            $fuel = $child->values['fuel_id'];
            if(!key_exists($fuel, $dataFuels['data'])){
                $dataFuels['data'][$fuel] = array(
                    'name' => $child->getElementValue('fuel_id'),
                    'unit' => $child->getElementValue('fuel_type_id', 'unit'),
                    'from' => 0,
                    'issue' => 0,
                    'issues' => array(),
                    'expense' => 0,
                    'expenses' => array(),
                );
            }

            $shop = 't' . $child->getElementValue('transport_type_1c_id', 'id');
            if(!key_exists($shop, $dataFuelExpenseTransports['data'])){
                $dataFuelExpenseTransports['data'][$shop] = array(
                    'id' => $shop,
                    'name' => $child->getElementValue('transport_type_1c_id'),
                );
            }

            if(!key_exists($shop, $dataFuels['data'][$fuel]['expenses'])){
                $dataFuels['data'][$fuel]['expenses'][$shop] = 0;
            }

            $quantity = $child->values['quantity'];

            $dataFuels['data'][$fuel]['expense'] += $quantity;
            $dataFuels['data'][$fuel]['expenses'][$shop] += $quantity;
        }

        // выдача топлива по путевым листам
        $params = Request_RequestParams::setParams(
            array(
                'date_from_equally' => $dateFrom,
                'date_to' => $dateTo,
                'sum_quantity' => true,
                'group_by' => array(
                    'fuel_id', 'fuel_id.name',
                    'shop_transport_mark_id.transport_type_1c_id.name', 'shop_transport_mark_id.transport_type_1c_id.id',
                    'fuel_id.fuel_type_id', 'fuel_id.fuel_type_id.unit',
                ),
            )
        );
        $ids = Request_Request::find(
            DB_Ab1_Shop_Transport_Fuel_Issue::NAME,
            0, $this->_sitePageData, $this->_driverDB,
            $params, 0, true,
            array(
                'fuel_id' => array('name'),
                'shop_transport_mark_id.transport_type_1c_id' => array('id', 'name'),
                'fuel_id.fuel_type_id' => array('unit'),
            )
        );

        foreach ($ids->childs as $child) {
            $fuel = $child->values['fuel_id'];
            if(!key_exists($fuel, $dataFuels['data'])){
                $dataFuels['data'][$fuel] = array(
                    'name' => $child->getElementValue('fuel_id'),
                    'unit' => $child->getElementValue('fuel_type_id', 'unit'),
                    'from' => 0,
                    'issue' => 0,
                    'issues' => array(),
                    'expense' => 0,
                    'expenses' => array(),
                );
            }

            $shop = 't' . $child->getElementValue('transport_type_1c_id', 'id');
            if(!key_exists($shop, $dataFuelExpenseTransports['data'])){
                $dataFuelExpenseTransports['data'][$shop] = array(
                    'id' => $shop,
                    'name' => $child->getElementValue('transport_type_1c_id'),
                );
            }

            if(!key_exists($shop, $dataFuels['data'][$fuel]['expenses'])){
                $dataFuels['data'][$fuel]['expenses'][$shop] = 0;
            }

            $quantity = $child->values['quantity'];

            $dataFuels['data'][$fuel]['expense'] += $quantity;
            $dataFuels['data'][$fuel]['expenses'][$shop] += $quantity;
        }

        // приход топлива на начало периода
        $params = Request_RequestParams::setParams(
            array(
                'date_less' => $dateFrom,
                'sum_quantity' => true,
                'group_by' => array(
                    'fuel_id', 'fuel_id.name', 'fuel_id.fuel_type_id.unit',
                )
            )
        );
        $ids = Request_Request::find(
            DB_Ab1_Shop_Transport_Fuel_Issue::NAME,
            0, $this->_sitePageData, $this->_driverDB,
            $params, 0, true,
            array(
                'fuel_id' => array('name'),
                'fuel_id.fuel_type_id' => array('unit'),
            )
        );

        foreach ($ids->childs as $child) {
            $fuel = $child->values['fuel_id'];
            if(!key_exists($fuel, $dataFuels['data'])){
                $dataFuels['data'][$fuel] = array(
                    'name' => $child->getElementValue('fuel_id'),
                    'unit' => $child->getElementValue('fuel_type_id', 'unit'),
                    'from' => 0,
                    'issue' => 0,
                    'issues' => array(),
                    'expense' => 0,
                    'expenses' => array(),
                );
            }
            $dataFuels['data'][$fuel]['from'] += $child->values['quantity'];
        }

        // расход топлива на начало периода
        $ids = Request_Request::find(
            DB_Ab1_Shop_Transport_Fuel_Expense::NAME,
            0, $this->_sitePageData, $this->_driverDB,
            $params, 0, true,
            array(
                'fuel_id' => array('name'),
                'fuel_id.fuel_type_id' => array('unit'),
            )
        );

        foreach ($ids->childs as $child) {
            $fuel = $child->values['fuel_id'];
            if(!key_exists($fuel, $dataFuels['data'])){
                $dataFuels['data'][$fuel] = array(
                    'name' => $child->getElementValue('fuel_id'),
                    'unit' => $child->getElementValue('fuel_type_id', 'unit'),
                    'from' => 0,
                    'issue' => 0,
                    'issues' => array(),
                    'expense' => 0,
                    'expenses' => array(),
                );
            }
            $dataFuels['data'][$fuel]['from'] -= $child->values['quantity'];
        }

        // выдача топлива по путевкам на начало периода
        $ids = Request_Request::find(
            DB_Ab1_Shop_Transport_Fuel_Issue::NAME,
            0, $this->_sitePageData, $this->_driverDB,
            $params, 0, true,
            array(
                'fuel_id' => array('name'),
                'fuel_id.fuel_type_id' => array('unit'),
            )
        );

        foreach ($ids->childs as $child) {
            $fuel = $child->values['fuel_id'];
            if(!key_exists($fuel, $dataFuels['data'])){
                $dataFuels['data'][$fuel] = array(
                    'name' => $child->getElementValue('fuel_id'),
                    'unit' => $child->getElementValue('fuel_type_id', 'unit'),
                    'from' => 0,
                    'issue' => 0,
                    'issues' => array(),
                    'expense' => 0,
                    'expenses' => array(),
                );
            }
            $dataFuels['data'][$fuel]['from'] -= $child->values['quantity'];
        }

        uasort($dataFuels['data'], array($this, 'mySortMethod'));
        uasort($dataFuelIssueDepartments['data'], array($this, 'mySortMethod'));
        uasort($dataFuelExpenseDepartments['data'], array($this, 'mySortMethod'));
        uasort($dataFuelExpenseTransports['data'], array($this, 'mySortMethod'));

        $viewObject = 'ab1/_report/'.$this->_sitePageData->languageID.'/transport/fuels';
        $tmp = str_replace('\\', '/', $viewObject);
        try {
            $view = View::factory($tmp);
        }catch (Exception $e) {
            throw new Exception('Шаблон "'.$tmp.'" не найден.');
        }

        $view->fuels = $dataFuels;
        $view->fuelExpenseTransports = $dataFuelExpenseTransports;
        $view->fuelExpenseDepartments = $dataFuelExpenseDepartments;
        $view->fuelIssueDepartments = $dataFuelIssueDepartments;
        $view->dateFrom = $dateFrom;
        $view->dateTo = $dateTo;
        $view->operation = $this->_sitePageData->operation->getValues();
        $view->shop = $this->_sitePageData->shop->getName();
        $view->shopOptions = $this->_sitePageData->shop->getOptionsArray();
        $view->siteData = $this->_sitePageData;
        $strView = Helpers_View::viewToStr($view);

        header('Content-Type: application/x-download;charset=UTF-8');
        // header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: filename="АТ15 Материальный отчет по ГСМ за период ' . Helpers_DateTime::getPeriodRus($dateFrom, $dateTo) .'.xml"');
        header('Cache-Control: max-age=0');

        echo $strView;
        exit();
    }

    /**
     * сортировка по полям order и name
     * @param $x
     * @param $y
     * @return int
     */
    function mySortOrderMethod($x, $y) {
        if($x['order'] == $y['order']){
            return strcasecmp($x['name'], $y['name']);
        }

        if($x['order'] > $y['order']){
            return 1;
        }

        return -1;
    }

    /**
     * АТ12 Анализ начислений работникам организаций (по маршрутам)
     * @throws Exception
     */
    public function action_waybill_wage() {
        set_time_limit(36000);

        $this->_sitePageData->url = '/'.$this->actionURLName.'/shopreport/waybill_wage';

        $dateFrom = Request_RequestParams::getParamDate('date_from');
        $dateTo = Request_RequestParams::getParamDate('date_to');

        $drivers = Api_Ab1_Shop_Transport_Waybill::getDriverWagesRoute(
            $dateFrom, $dateTo, $this->_sitePageData, $this->_driverDB
        );

        $viewObject = 'ab1/_report/'.$this->_sitePageData->languageID.'/waybill/wage';
        $tmp = str_replace('\\', '/', $viewObject);
        try {
            $view = View::factory($tmp);
        }catch (Exception $e) {
            throw new Exception('Шаблон "'.$tmp.'" не найден.');
        }

        $view->drivers = $drivers;
        $view->dateFrom = $dateFrom;
        $view->dateTo = $dateTo;
        $view->operation = $this->_sitePageData->operation->getValues();
        $view->shop = $this->_sitePageData->shop->getName();
        $view->shopOptions = $this->_sitePageData->shop->getOptionsArray();
        $view->siteData = $this->_sitePageData;
        $strView = Helpers_View::viewToStr($view);

        header('Content-Type: application/x-download;charset=UTF-8');
        // header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: filename="АТ12 Анализ начислений работникам организаций за период ' . Helpers_DateTime::getPeriodRus($dateFrom, $dateTo) .'.xml"');
        header('Cache-Control: max-age=0');

        echo $strView;
        exit();
    }

    /**
     * АТ11 УЗТ Табель учета рабочего времени (транспорт)
     * @throws Exception
     */
    public function action_waybill_work() {
        set_time_limit(36000);

        $this->_sitePageData->url = '/'.$this->actionURLName.'/shopreport/waybill_work';

        $dateFrom = Request_RequestParams::getParamDate('date_from');
        $dateTo = Request_RequestParams::getParamDate('date_to');

        $drivers = Api_Ab1_Shop_Transport_Waybill::getDriverTransportWorkValues(
            $dateFrom, $dateTo, $this->_sitePageData, $this->_driverDB
        );

        $viewObject = 'ab1/_report/'.$this->_sitePageData->languageID.'/waybill/work';
        $tmp = str_replace('\\', '/', $viewObject);
        try {
            $view = View::factory($tmp);
        }catch (Exception $e) {
            throw new Exception('Шаблон "'.$tmp.'" не найден.');
        }

        $view->drivers = $drivers['drivers'];
        $view->works = $drivers['works'];
        $view->dateFrom = $dateFrom;
        $view->dateTo = $dateTo;
        $view->operation = $this->_sitePageData->operation->getValues();
        $view->shop = $this->_sitePageData->shop->getName();
        $view->shopOptions = $this->_sitePageData->shop->getOptionsArray();
        $view->siteData = $this->_sitePageData;
        $strView = Helpers_View::viewToStr($view);

        header('Content-Type: application/x-download;charset=UTF-8');
        // header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: filename="АТ11 УЗТ Табель учета рабочего времени за период ' . Helpers_DateTime::getPeriodRus($dateFrom, $dateTo) .'.xml"');
        header('Cache-Control: max-age=0');

        echo $strView;
        exit();
    }

    /**
     * АТ09 Путевой лист Автомобильного крана
     * @throws Exception
     */
    public function action_waybill_crane() {
        set_time_limit(36000);

        $this->_sitePageData->url = '/'.$this->actionURLName.'/shopreport/waybill_crane';

        $shopTransportWaybillID = Request_RequestParams::getParamInt('id');

        // путевой лист
        $waybill = Request_Request::findOneByID(
            DB_Ab1_Shop_Transport_Waybill::NAME, $shopTransportWaybillID, $this->_sitePageData->shopID,
            $this->_sitePageData, $this->_driverDB,
            array(
                'shop_transport_id' => array('name', 'number'),
                'shop_transport_driver_id' => array('name', 'number'),
            )
        );

        if($waybill == null){
            throw new HTTP_Exception_404('Transport waybill not is found!');
        }

        $model = new Model_Ab1_Shop_Transport_Waybill();
        $waybill->setModel($model);

        $dataWaybill = array(
            'date' => $model->getDate(),
            'number' => $model->getNumber(),
            'from_at' => $model->getFromAt(),
            'milage_from' => $model->getMilageFrom(),
            'transport_number' => $waybill->getElementValue('shop_transport_id', 'number'),
            'transport_name' => $waybill->getElementValue('shop_transport_id'),
            'to_at' => $model->getToAt(),
            'milage_to' => $model->getMilageTo(),
            'driver_name' => $waybill->getElementValue('shop_transport_driver_id'),
            'driver_number' => $waybill->getElementValue('shop_transport_driver_id', 'number'),
            'trailer_number' => '',
            'trailer_name' => '',
            'fuel_name' => '',
            'fuel_quantity' => $model->getFuelQuantityExpenses(),
            'fuel_quantity_from' => $model->getFuelQuantityFrom(),
            'milage' => $model->getMilage(),
            'escorts' => array(),
        );

        // остатки топлива
        $balanceFuels = Api_Ab1_Shop_Transport::getTransportBalanceFuels(
            $model->getShopTransportID(), $this->_sitePageData, $this->_driverDB,  false, $model->getFromAt()
        );

        // топливо
        $fuel = Request_Request::findOneByField(
            DB_Ab1_Shop_Transport_Waybill_Fuel_Issue::NAME,
            'shop_transport_waybill_id', $shopTransportWaybillID,
            $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB,
            array(
                'fuel_id' => array('name'),
            )
        );
        if($fuel != null){
            $dataWaybill['fuel_name'] = $fuel->getElementValue('fuel_id');
        }

        // сопровождающие лица
        $escorts = Request_Request::findByField(
            DB_Ab1_Shop_Transport_Waybill_Escort::NAME,
            'shop_transport_waybill_id', $shopTransportWaybillID,
            $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB, 0, true,
            array(
                'shop_worker_id' => array('name'),
            )
        );
        foreach ($escorts->childs as $child){
            $dataWaybill['escorts'][] = $child->getElementValue('shop_worker_id');
        }
        $dataWaybill['escorts'] = implode(', ', $dataWaybill['escorts']);

        // прицеп
        $trailer = Request_Request::findOneByField(
            DB_Ab1_Shop_Transport_Waybill_Trailer::NAME,
            'shop_transport_waybill_id', $shopTransportWaybillID,
            $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB,
            array(
                'shop_transport_id' => array('name', 'number'),
            )
        );
        if($trailer != null){
            $dataWaybill['trailer_number'] = $trailer->getElementValue('shop_transport_id', 'number');
            $dataWaybill['trailer_name'] = $trailer->getElementValue('shop_transport_id');
        }

        $viewObject = 'ab1/_report/'.$this->_sitePageData->languageID.'/waybill/crane';
        $tmp = str_replace('\\', '/', $viewObject);
        try {
            $view = View::factory($tmp);
        }catch (Exception $e) {
            throw new Exception('Шаблон "'.$tmp.'" не найден.');
        }

        $view->waybill = $dataWaybill;
        $view->operation = $this->_sitePageData->operation->getValues();
        $view->shop = $this->_sitePageData->shop->getName();
        $view->shopOptions = $this->_sitePageData->shop->getOptionsArray();
        $view->siteData = $this->_sitePageData;
        $strView = Helpers_View::viewToStr($view);

        header('Content-Type: application/x-download;charset=UTF-8');
        // header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: filename="АТ09 Путевой лист Автомобильного крана №' . $model->getNumber() .'.xml"');
        header('Cache-Control: max-age=0');

        echo $strView;
        exit();
    }

    /**
     * АТ10 Расход топлива по автомобилям
     * @throws Exception
     */
    public function action_transport_act_fuel() {
        set_time_limit(36000);

        $this->_sitePageData->url = '/'.$this->actionURLName.'/shopreport/transport_act_fuel';

        $dateFrom = Request_RequestParams::getParamDate('date_from');
        $dateTo = Request_RequestParams::getParamDate('date_to');
        $transportType1CID = Request_RequestParams::getParamInt('transport_type_1c_id');

        $dataTransports = array(
            'data' => array(),
            'milage_from' => 0,
            'milage' => 0,
            'fuel_from' => 0,
            'fuel_issue' => 0,
            'fuel_expense' => 0,
        );
        $dataFuels = array(
            'data' => array(),
            'fuel_expense' => 0,
        );
        $dataWorks = array(
            'data' => array(),
            'quantity' => 0,
        );

        //список машин в путевых листах
        $params = Request_RequestParams::setParams(
            array(
                'date_from_equally' => $dateFrom,
                'date_to' => $dateTo,
                'shop_transport_id.shop_transport_mark_id.transport_type_1c_id' => $transportType1CID,
                'sort_by' => array(
                    'date_from' => 'asc',
                    'id' => 'asc',
                )
            )
        );
        $ids = Request_Request::find(
            DB_Ab1_Shop_Transport_Waybill::NAME,
            $this->_sitePageData->shopMainID, $this->_sitePageData, $this->_driverDB,
            $params, 0, true,
            array(
                'shop_transport_id.shop_transport_mark_id' => array('name'),
                'shop_transport_id' => array('number'),
            )
        );

        foreach ($ids->childs as $child) {
            $transport = $child->values['shop_transport_id'];
            if(!key_exists($transport, $dataTransports['data'])){
                $fuels = Api_Ab1_Shop_Transport::getTransportBalanceFuels(
                    $transport, $this->_sitePageData, $this->_driverDB, false, $dateFrom
                );

                $fuelQuantity = 0;
                foreach ($fuels as $fuel){
                    $fuelQuantity += $fuel['quantity'];
                }

                $dataTransports['data'][$transport] = array(
                    'mark' => $child->getElementValue('shop_transport_mark_id'),
                    'number' => $child->getElementValue('shop_transport_id', 'number'),
                    'milage_from' => Api_Ab1_Shop_Transport::getTransportMarkMilage(
                        $transport, $this->_sitePageData, $this->_driverDB, $dateFrom
                    ),
                    'milage' => 0,
                    'fuel_from' => $fuelQuantity,
                    'fuel_issue' => 0,
                    'fuel_expense' => 0,
                    'fuel_expenses' => array(),
                    'works' => array(),
                );

                //$dataTransports['milage_from'] += $child->values['milage_from'];
                //$dataTransports['fuel_from'] += $child->values['fuel_quantity_from'];
            }

            $dataTransports['data'][$transport]['milage'] += $child->values['milage'];
            $dataTransports['milage'] += $child->values['milage'];
        }

        $params = Request_RequestParams::setParams(
            array(
                'shop_transport_waybill_id.date_from_equally' => $dateFrom,
                'shop_transport_waybill_id.date_to' => $dateTo,
                'shop_transport_waybill_id.shop_transport_id.shop_transport_mark_id.transport_type_1c_id' => $transportType1CID,
            )
        );

        // выдано топлива
        $ids = Request_Request::find(
            DB_Ab1_Shop_Transport_Waybill_Fuel_Issue::NAME,
            $this->_sitePageData->shopMainID, $this->_sitePageData, $this->_driverDB,
            $params, 0, true

        );

        foreach ($ids->childs as $child) {
            $transport = $child->values['shop_transport_id'];
            if(!key_exists($transport, $dataTransports['data'])){
                continue;
            }

            $dataTransports['data'][$transport]['fuel_issue'] += $child->values['quantity'];
            $dataTransports['fuel_issue'] += $child->values['quantity'];
        }

        // израсходовано топлива
        $ids = Request_Request::find(
            DB_Ab1_Shop_Transport_Waybill_Fuel_Expense::NAME,
            $this->_sitePageData->shopMainID, $this->_sitePageData, $this->_driverDB,
            $params, 0, true,
            array(
                'fuel_id' => array('name'),
            )
        );

        foreach ($ids->childs as $child) {
            $transport = $child->values['shop_transport_id'];
            if(!key_exists($transport, $dataTransports['data'])){
                continue;
            }

            $quantity = $child->values['quantity'];

            $fuel = $child->values['fuel_id'];
            if(!key_exists($fuel, $dataFuels['data'])){
                $dataFuels['data'][$fuel] = array(
                    'id' => $fuel,
                    'name' => $child->getElementValue('fuel_id'),
                    'fuel_expense' => 0,
                );
            }
            $dataFuels['data'][$fuel]['fuel_expense'] += $quantity;
            $dataFuels['fuel_expense'] += $quantity;

            if(!key_exists($fuel, $dataTransports['data'][$transport]['fuel_expenses'])){
                $dataTransports['data'][$transport]['fuel_expenses'][$fuel]  = 0;
            }

            $dataTransports['data'][$transport]['fuel_expenses'][$fuel] += $quantity;
            $dataTransports['data'][$transport]['fuel_expense'] += $quantity;
            $dataTransports['fuel_expense'] += $quantity;

        }

        $params = Request_RequestParams::setParams(
            array(
                'shop_transport_waybill_id.date_from_equally' => $dateFrom,
                'shop_transport_waybill_id.date_to' => $dateTo,
                'shop_transport_work_id.is_trailer' => false,
                'shop_transport_id.shop_transport_mark_id.transport_type_1c_id' => $transportType1CID,
                'sum_quantity' => true,
                'group_by' => [
                    'shop_transport_id',
                    'shop_transport_work_id', 'shop_transport_work_id.name'
                ],
            )
        );

        // показатели расчета транспорта
        $ids = Request_Request::find(
            DB_Ab1_Shop_Transport_Waybill_Work_Car::NAME,
            $this->_sitePageData->shopMainID, $this->_sitePageData, $this->_driverDB,
            $params, 0, true,
            [
                'shop_transport_work_id' => array('name'),
            ]

        );

        foreach ($ids->childs as $child) {
            $transport = $child->values['shop_transport_id'];
            if(!key_exists($transport, $dataTransports['data'])){
                continue;
            }

            $quantity = $child->values['quantity'];

            $work = $child->values['shop_transport_work_id'];
            if(!key_exists($transport, $dataTransports['data'][$transport]['works'])){
                $dataTransports['data'][$transport]['works'][$work] = 0;
            }
            $dataTransports['data'][$transport]['works'][$work] += $quantity;

            if(!key_exists($work, $dataWorks['data'])){
                $dataWorks['data'][$work] = array(
                    'id' => $work,
                    'name' => $child->getElementValue('shop_transport_work_id'),
                    'quantity' => 0,
                );
            }
            $dataWorks['data'][$work]['quantity'] += $quantity;
            $dataWorks['quantity'] += $quantity;
        }

        uasort($dataFuels['data'], array($this, 'mySortMethod'));
        uasort($dataWorks['data'], array($this, 'mySortMethod'));

        $viewObject = 'ab1/_report/'.$this->_sitePageData->languageID.'/transport/act-fuel';
        $tmp = str_replace('\\', '/', $viewObject);
        try {
            $view = View::factory($tmp);
        }catch (Exception $e) {
            throw new Exception('Шаблон "'.$tmp.'" не найден.');
        }

        $view->transports = $dataTransports;
        $view->fuels = $dataFuels;
        $view->works = $dataWorks;
        $view->operation = $this->_sitePageData->operation->getValues();
        $view->shop = $this->_sitePageData->shop->getName();
        $view->shopOptions = $this->_sitePageData->shop->getOptionsArray();
        $strView = Helpers_View::viewToStr($view);

        header('Content-Type: application/x-download;charset=UTF-8');
        // header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: filename="АТ10 Расход топлива по автомобилям за период ' . Helpers_DateTime::getPeriodRus($dateFrom, $dateTo) .'.xml"');
        header('Cache-Control: max-age=0');

        echo $strView;
        exit();
    }

    /**
     * АТ14 Сведения о транспортных средствах
     * @throws Exception
     */
    public function action_transport_list() {
        set_time_limit(36000);

        $this->_sitePageData->url = '/'.$this->actionURLName.'/shopreport/transport_list';

        $dataTransports = array(
            'data' => array(),
        );
        $dataIndicators = array(
            'data' => array(),
        );
        $dataSeasons = array(
            'data' => array(),
        );

        $params = Request_RequestParams::setParams(
            array_merge($_POST, $_GET)
        );
        unset($params['limit_page']);

        $ids = Request_Request::find(
            DB_Ab1_Shop_Transport::NAME,
            $this->_sitePageData->shopMainID, $this->_sitePageData, $this->_driverDB,
            $params, 0, true,
            array(
                'shop_transport_mark_id' => array('name'),
                'shop_transport_driver_id' => array('name'),
                'shop_branch_storage_id' => array('name'),
            )
        );

        foreach ($ids->childs as $child) {
            $dataTransports['data'][$child->values['id']] = array(
                'id' => $child->values['id'],
                'mark' => $child->getElementValue('shop_transport_mark_id'),
                'number' => $child->values['number'],
                'storage' => $child->getElementValue('shop_branch_storage_id'),
                'driver' => $child->getElementValue('shop_transport_driver_id'),
                'is_trailer' => $child->values['is_trailer'],
                'fuel_types' => array(),
                'formulas' => array(),
                'indicators' => array(),
                'works' => array(),
                'driver_works' => array(),
            );
        }

        if(count($ids->childs) > 0){
            $transportIDs = $ids->getChildArrayID();
            $params = Request_RequestParams::setParams(
                array(
                    'shop_transport_id' => $transportIDs,
                )
            );

            // формулы просчета ГСМ
            $ids = Request_Request::find(
                DB_Ab1_Shop_Transport_To_Fuel::NAME,
                $this->_sitePageData->shopMainID, $this->_sitePageData, $this->_driverDB,
                $params, 0, true,
                array(
                    'fuel_type_id' => array('name'),
                    'shop_transport_indicator_formula_id' => array('name'),
                )
            );
            foreach ($ids->childs as $child) {
                $transport = $child->values['shop_transport_id'];

                $dataTransports['data'][$transport]['fuel_types'][] = $child->getElementValue('fuel_type_id');
                $dataTransports['data'][$transport]['formulas'][] = $child->getElementValue('shop_transport_indicator_formula_id');
            }

            // Параметры выработки транспорта
            $ids = Request_Request::find(
                DB_Ab1_Shop_Transport_To_Work::NAME,
                $this->_sitePageData->shopMainID, $this->_sitePageData, $this->_driverDB,
                $params, 0, true,
                array(
                    'shop_transport_work_id' => array('name'),
                )
            );
            foreach ($ids->childs as $child) {
                $transport = $child->values['shop_transport_id'];

                $dataTransports['data'][$transport]['works'][] = $child->getElementValue('shop_transport_work_id');
            }

            // Параметры выработки водителя
            $ids = Request_Request::find(
                DB_Ab1_Shop_Transport_To_Work_Driver::NAME,
                $this->_sitePageData->shopMainID, $this->_sitePageData, $this->_driverDB,
                $params, 0, true,
                array(
                    'shop_transport_work_id' => array('name'),
                )
            );
            foreach ($ids->childs as $child) {
                $transport = $child->values['shop_transport_id'];

                $dataTransports['data'][$transport]['driver_works'][] = $child->getElementValue('shop_transport_work_id');
            }

            // Параметры индикаторов
            $ids = Request_Request::find(
                DB_Ab1_Shop_Transport_To_Indicator_Season::NAME,
                $this->_sitePageData->shopMainID, $this->_sitePageData, $this->_driverDB,
                $params, 0, true,
                array(
                    'season_id' => array('name'),
                    'shop_transport_indicator_id' => array('name'),
                )
            );
            foreach ($ids->childs as $child) {
                $transport = $child->values['shop_transport_id'];
                $season = $child->values['season_id'];
                $indicator = $child->values['shop_transport_indicator_id'];

                $dataTransports['data'][$transport]['indicators'][$indicator][$season] = $child->values['quantity'];

                if(!key_exists($indicator, $dataIndicators['data'])){
                    $dataIndicators['data'][$indicator] = array(
                        'id' => $indicator,
                        'name' => $child->getElementValue('shop_transport_indicator_id'),
                    );
                }

                if(!key_exists($season, $dataSeasons['data'])){
                    $dataSeasons['data'][$season] = array(
                        'id' => $season,
                        'name' => $child->getElementValue('season_id'),
                    );
                }
            }
        }

        $viewObject = 'ab1/_report/'.$this->_sitePageData->languageID.'/transport/list';
        $tmp = str_replace('\\', '/', $viewObject);
        try {
            $view = View::factory($tmp);
        }catch (Exception $e) {
            throw new Exception('Шаблон "'.$tmp.'" не найден.');
        }

        $view->transports = $dataTransports;
        $view->indicators = $dataIndicators;
        $view->seasons = $dataSeasons;
        $view->operation = $this->_sitePageData->operation->getValues();
        $view->shop = $this->_sitePageData->shop->getName();
        $view->shopOptions = $this->_sitePageData->shop->getOptionsArray();
        $strView = Helpers_View::viewToStr($view);

        header('Content-Type: application/x-download;charset=UTF-8');
        // header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: filename="АТ14 Сведения о транспортных средствах.xml"');
        header('Cache-Control: max-age=0');

        echo $strView;
        exit();
    }

    /**
     * АТ13 Список транспортных средств
     * @throws Exception
     */
    public function action_transport_mark_list() {
        set_time_limit(36000);

        $this->_sitePageData->url = '/'.$this->actionURLName.'/shopreport/transport_mark_list';

        $params = Request_RequestParams::setParams(
            array_merge($_POST, $_GET)
        );
        unset($params['limit_page']);

        $ids = Request_Request::find(
            DB_Ab1_Shop_Transport_Mark::NAME,
            $this->_sitePageData->shopMainID, $this->_sitePageData, $this->_driverDB,
            $params, 0, true,
            array(
                'transport_work_id' => array('name'),
                'transport_view_id' => array('name'),
                'transport_wage_id' => array('name'),
            )
        );

        $dataTransportMarks = array(
            'data' => array(),
        );
        foreach ($ids->childs as $child) {

            $dataTransportMarks['data'][] = array(
                'number' => $child->values['number'],
                'name' => $child->values['name'],
                'transport_work' => $child->getElementValue('transport_work_id'),
                'transport_view' => $child->getElementValue('transport_view_id'),
                'transport_wage' => $child->getElementValue('transport_wage_id'),
                'milage' => $child->values['milage'],
                'fuel_quantity' => $child->values['fuel_quantity'],
            );
        }

        $viewObject = 'ab1/_report/'.$this->_sitePageData->languageID.'/transport/mark/list';
        $tmp = str_replace('\\', '/', $viewObject);
        try {
            $view = View::factory($tmp);
        }catch (Exception $e) {
            throw new Exception('Шаблон "'.$tmp.'" не найден.');
        }

        $view->transportMarks = $dataTransportMarks;
        $view->operation = $this->_sitePageData->operation->getValues();
        $view->shop = $this->_sitePageData->shop->getName();
        $view->shopOptions = $this->_sitePageData->shop->getOptionsArray();
        $strView = Helpers_View::viewToStr($view);

        header('Content-Type: application/x-download;charset=UTF-8');
        // header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: filename="АТ13 Список транспортных средств.xml"');
        header('Cache-Control: max-age=0');

        echo $strView;
        exit();
    }

    /**
     * АТ08 Путевой лист СпецТехники
     * @throws Exception
     */
    public function action_waybill_special() {
        set_time_limit(36000);

        $this->_sitePageData->url = '/'.$this->actionURLName.'/shopreport/waybill_special';

        $shopTransportWaybillID = Request_RequestParams::getParamInt('id');

        // путевой лист
        $waybill = Request_Request::findOneByID(
            DB_Ab1_Shop_Transport_Waybill::NAME, $shopTransportWaybillID, $this->_sitePageData->shopID,
            $this->_sitePageData, $this->_driverDB,
            array(
                'shop_transport_id' => array('name', 'number'),
                'shop_transport_driver_id' => array('name', 'number'),
            )
        );

        if($waybill == null){
            throw new HTTP_Exception_404('Transport waybill not is found!');
        }

        $model = new Model_Ab1_Shop_Transport_Waybill();
        $waybill->setModel($model);

        $dataWaybill = array(
            'date' => $model->getDate(),
            'number' => $model->getNumber(),
            'from_at' => $model->getFromAt(),
            'milage_from' => $model->getMilageFrom(),
            'transport_number' => $waybill->getElementValue('shop_transport_id', 'number'),
            'transport_name' => $waybill->getElementValue('shop_transport_id'),
            'to_at' => $model->getToAt(),
            'milage_to' => $model->getMilageTo(),
            'driver_name' => $waybill->getElementValue('shop_transport_driver_id'),
            'driver_number' => $waybill->getElementValue('shop_transport_driver_id', 'number'),
            'fuel_quantity_expenses' => $model->getFuelQuantityExpenses(),
            'fuel_quantity_issues' => $model->getFuelQuantityIssues(),
            'fuel_quantity_from' => $model->getFuelQuantityFrom(),
        );

        $viewObject = 'ab1/_report/'.$this->_sitePageData->languageID.'/waybill/special';
        $tmp = str_replace('\\', '/', $viewObject);
        try {
            $view = View::factory($tmp);
        }catch (Exception $e) {
            throw new Exception('Шаблон "'.$tmp.'" не найден.');
        }

        $view->waybill = $dataWaybill;
        $view->operation = $this->_sitePageData->operation->getValues();
        $view->shop = $this->_sitePageData->shop->getName();
        $view->shopOptions = $this->_sitePageData->shop->getOptionsArray();
        $view->siteData = $this->_sitePageData;
        $strView = Helpers_View::viewToStr($view);

        header('Content-Type: application/x-download;charset=UTF-8');
        // header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: filename="АТ08 Путевой лист СпецТехники №' . $model->getNumber() .'.xml"');
        header('Cache-Control: max-age=0');

        echo $strView;
        exit();
    }

    /**
     * АТ06 Путевой лист 4П
     * @throws Exception
     */
    public function action_waybill_p4() {
        set_time_limit(36000);

        $this->_sitePageData->url = '/'.$this->actionURLName.'/shopreport/waybill_p4';

        $shopTransportWaybillID = Request_RequestParams::getParamInt('id');

        // путевой лист
        $waybill = Request_Request::findOneByID(
            DB_Ab1_Shop_Transport_Waybill::NAME, $shopTransportWaybillID, $this->_sitePageData->shopID,
            $this->_sitePageData, $this->_driverDB,
            array(
                'shop_transport_id' => array('name', 'number'),
                'shop_transport_driver_id' => array('name', 'number'),
            )
        );

        if($waybill == null){
            throw new HTTP_Exception_404('Transport waybill not is found!');
        }

        $model = new Model_Ab1_Shop_Transport_Waybill();
        $waybill->setModel($model);

        $dataWaybill = array(
            'date' => $model->getDate(),
            'number' => $model->getNumber(),
            'from_at' => $model->getFromAt(),
            'milage_from' => $model->getMilageFrom(),
            'transport_number' => $waybill->getElementValue('shop_transport_id', 'number'),
            'transport_name' => $waybill->getElementValue('shop_transport_id'),
            'to_at' => $model->getToAt(),
            'milage_to' => $model->getMilageTo(),
            'driver_name' => $waybill->getElementValue('shop_transport_driver_id'),
            'driver_number' => $waybill->getElementValue('shop_transport_driver_id', 'number'),
            'trailer_number' => '',
            'trailer_name' => '',
            'fuel_name' => '',
            'fuel_quantity' => $model->getFuelQuantityExpenses(),
            'fuel_quantity_from' => $model->getFuelQuantityFrom(),
            'milage' => $model->getMilage(),
            'escorts' => array(),
        );

        // остатки топлива
        $balanceFuels = Api_Ab1_Shop_Transport::getTransportBalanceFuels(
            $model->getShopTransportID(), $this->_sitePageData, $this->_driverDB,  false, $model->getFromAt()
        );

        // топливо
        $fuel = Request_Request::findOneByField(
            DB_Ab1_Shop_Transport_Waybill_Fuel_Issue::NAME,
            'shop_transport_waybill_id', $shopTransportWaybillID,
            $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB,
            array(
                'fuel_id' => array('name'),
            )
        );
        if($fuel != null){
            $dataWaybill['fuel_name'] = $fuel->getElementValue('fuel_id');
        }

        // сопровождающие лица
        $escorts = Request_Request::findByField(
            DB_Ab1_Shop_Transport_Waybill_Escort::NAME,
            'shop_transport_waybill_id', $shopTransportWaybillID,
            $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB, 0, true,
            array(
                'shop_worker_id' => array('name'),
            )
        );
        foreach ($escorts->childs as $child){
            $dataWaybill['escorts'][] = $child->getElementValue('shop_worker_id');
        }
        $dataWaybill['escorts'] = implode(', ', $dataWaybill['escorts']);

        // прицеп
        $trailer = Request_Request::findOneByField(
            DB_Ab1_Shop_Transport_Waybill_Trailer::NAME,
            'shop_transport_waybill_id', $shopTransportWaybillID,
            $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB,
            array(
                'shop_transport_id' => array('name', 'number'),
            )
        );
        if($trailer != null){
            $dataWaybill['trailer_number'] = $trailer->getElementValue('shop_transport_id', 'number');
            $dataWaybill['trailer_name'] = $trailer->getElementValue('shop_transport_id');
        }

        $viewObject = 'ab1/_report/'.$this->_sitePageData->languageID.'/waybill/p4';
        $tmp = str_replace('\\', '/', $viewObject);
        try {
            $view = View::factory($tmp);
        }catch (Exception $e) {
            throw new Exception('Шаблон "'.$tmp.'" не найден.');
        }

        $view->waybill = $dataWaybill;
        $view->operation = $this->_sitePageData->operation->getValues();
        $view->shop = $this->_sitePageData->shop->getName();
        $view->shopOptions = $this->_sitePageData->shop->getOptionsArray();
        $view->siteData = $this->_sitePageData;
        $strView = Helpers_View::viewToStr($view);

        header('Content-Type: application/x-download;charset=UTF-8');
        // header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: filename="АТ06 Путевой лист 4П №' . $model->getNumber() .'.xml"');
        header('Cache-Control: max-age=0');

        echo $strView;
        exit();
    }

    /**
     * АТ07 Путевой лист Ф3
     * @throws Exception
     */
    public function action_waybill_f3() {
        set_time_limit(36000);

        $this->_sitePageData->url = '/'.$this->actionURLName.'/shopreport/waybill_f3';

        $shopTransportWaybillID = Request_RequestParams::getParamInt('id');

        // путевой лист
        $waybill = Request_Request::findOneByID(
            DB_Ab1_Shop_Transport_Waybill::NAME, $shopTransportWaybillID, $this->_sitePageData->shopID,
            $this->_sitePageData, $this->_driverDB,
            array(
                'shop_transport_id' => array('name', 'number'),
                'shop_transport_driver_id' => array('name', 'number'),
            )
        );

        if($waybill == null){
            throw new HTTP_Exception_404('Transport waybill not is found!');
        }

        $model = new Model_Ab1_Shop_Transport_Waybill();
        $waybill->setModel($model);

        $dataWaybill = array(
            'date' => $model->getDate(),
            'number' => $model->getNumber(),
            'from_at' => $model->getFromAt(),
            'milage_from' => $model->getMilageFrom(),
            'transport_number' => $waybill->getElementValue('shop_transport_id', 'number'),
            'transport_name' => $waybill->getElementValue('shop_transport_id'),
            'to_at' => $model->getToAt(),
            'milage_to' => $model->getMilageTo(),
            'driver_name' => $waybill->getElementValue('shop_transport_driver_id'),
            'driver_number' => $waybill->getElementValue('shop_transport_driver_id', 'number'),
            'fuel_quantity_expenses' => $model->getFuelQuantityExpenses(),
            'fuel_quantity_issues' => $model->getFuelQuantityIssues(),
            'fuel_quantity_from' => $model->getFuelQuantityFrom(),
        );

        $viewObject = 'ab1/_report/'.$this->_sitePageData->languageID.'/waybill/f3';
        $tmp = str_replace('\\', '/', $viewObject);
        try {
            $view = View::factory($tmp);
        }catch (Exception $e) {
            throw new Exception('Шаблон "'.$tmp.'" не найден.');
        }

        $view->waybill = $dataWaybill;
        $view->operation = $this->_sitePageData->operation->getValues();
        $view->shop = $this->_sitePageData->shop->getName();
        $view->shopOptions = $this->_sitePageData->shop->getOptionsArray();
        $view->siteData = $this->_sitePageData;
        $strView = Helpers_View::viewToStr($view);

        header('Content-Type: application/x-download;charset=UTF-8');
        // header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: filename="АТ07 Путевой лист Ф3 №' . $model->getNumber() .'.xml"');
        header('Cache-Control: max-age=0');

        echo $strView;
        exit();
    }

    /**
     * АТ05 Путевой лист 4С
     * @throws Exception
     */
    public function action_waybill_c4() {
        set_time_limit(36000);

        $this->_sitePageData->url = '/'.$this->actionURLName.'/shopreport/waybill_c4';

        $shopTransportWaybillID = Request_RequestParams::getParamInt('id');

        // путевой лист
        $waybill = Request_Request::findOneByID(
            DB_Ab1_Shop_Transport_Waybill::NAME, $shopTransportWaybillID, $this->_sitePageData->shopID,
            $this->_sitePageData, $this->_driverDB,
            array(
                'shop_transport_id' => array('name', 'number'),
                'shop_transport_driver_id' => array('name', 'number'),
            )
        );

        if($waybill == null){
            throw new HTTP_Exception_404('Transport waybill not is found!');
        }

        $model = new Model_Ab1_Shop_Transport_Waybill();
        $waybill->setModel($model);

        $dataWaybill = array(
            'date' => $model->getDate(),
            'number' => $model->getNumber(),
            'from_at' => $model->getFromAt(),
            'milage_from' => $model->getMilageFrom(),
            'transport_number' => $waybill->getElementValue('shop_transport_id', 'number'),
            'transport_name' => $waybill->getElementValue('shop_transport_id'),
            'to_at' => $model->getToAt(),
            'milage_to' => $model->getMilageTo(),
            'driver_name' => $waybill->getElementValue('shop_transport_driver_id'),
            'driver_number' => $waybill->getElementValue('shop_transport_driver_id', 'number'),
            'trailer_number' => '',
            'trailer_name' => '',
            'fuel_quantity_from' => $waybill->values['fuel_quantity_from'],
            'fuel_quantity' => 0,
            'fuels' => array(),
            'escorts' => array(),
        );

        // остатки топлива
        $balanceFuels = Api_Ab1_Shop_Transport::getTransportBalanceFuels(
            $model->getShopTransportID(), $this->_sitePageData, $this->_driverDB,  false, $model->getFromAt()
        );

        // топливо
        $fuels = Request_Request::findByField(
            DB_Ab1_Shop_Transport_Waybill_Fuel_Issue::NAME,
            'shop_transport_waybill_id', $shopTransportWaybillID,
            $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB, 0, true,
            array(
                'fuel_id' => array('name'),
            )
        );
        foreach ($fuels->childs as $child){
            $dataWaybill['fuels'][] = array(
                'fuel_name' => $child->getElementValue('fuel_id'),
                'fuel_quantity_from' => key_exists($child->values['fuel_id'], $balanceFuels) ? $balanceFuels[$child->values['fuel_id']]['quantity'] : 0,
                'fuel_quantity' => $child->values['quantity'],
            );

            $dataWaybill['fuel_quantity'] += $child->values['quantity'];
        }

        // сопровождающие лица
        $escorts = Request_Request::findByField(
            DB_Ab1_Shop_Transport_Waybill_Escort::NAME,
            'shop_transport_waybill_id', $shopTransportWaybillID,
            $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB, 0, true,
            array(
                'shop_worker_id' => array('name'),
            )
        );
        foreach ($escorts->childs as $child){
            $dataWaybill['escorts'][] = $child->getElementValue('shop_worker_id');
        }
        $dataWaybill['escorts'] = implode(', ', $dataWaybill['escorts']);

        // прицеп
        $trailer = Request_Request::findOneByField(
            DB_Ab1_Shop_Transport_Waybill_Trailer::NAME,
            'shop_transport_waybill_id', $shopTransportWaybillID,
            $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB,
            array(
                'shop_transport_id' => array('name', 'number'),
            )
        );
        if($trailer != null){
            $dataWaybill['trailer_number'] = $trailer->getElementValue('shop_transport_id', 'number');
            $dataWaybill['trailer_name'] = $trailer->getElementValue('shop_transport_id');
        }

        // Получаем список перевозок
        $dataCars = array(
            'data' => array(),
            'volume_month' => 0,
            'quantity_month' => 0,
            'volume_year' => 0,
            'quantity_year' => 0,
        );

        $params = Request_RequestParams::setParams(
            array(
                'shop_transport_waybill_id' => $shopTransportWaybillID,
                'sum_count_trip' => true,
                'group_by' => array(
                    'distance',
                    'shop_raw_id', 'shop_raw_id.name',
                    'shop_material_id', 'shop_material_id.name',
                    'shop_product_id', 'shop_product_id.name',
                    'shop_client_to_id', 'shop_client_to_id.name',
                    'shop_daughter_from_id', 'shop_daughter_from_id.name',
                    'shop_branch_to_id', 'shop_branch_to_id.name',
                    'shop_branch_from_id', 'shop_branch_from_id.name',
                    'shop_ballast_crusher_to_id', 'shop_ballast_crusher_to_id.name',
                    'shop_ballast_crusher_from_id', 'shop_ballast_crusher_from_id.name',
                    'shop_transportation_place_to_id', 'shop_transportation_place_to_id.name',
                    'shop_material_other_id', 'shop_material_other_id.name',
                    'shop_move_place_to_id', 'shop_move_place_to_id.name',
                )
            )
        );
        $ids = Request_Request::find(
            DB_Ab1_Shop_Transport_Waybill_Car::NAME,
            $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB,
            $params, 0, true,
            array(
                'shop_raw_id' => array('name'),
                'shop_material_id' => array('name'),
                'shop_product_id' => array('name'),
                'shop_product_id' => array('name'),
                'shop_material_other_id' => array('name'),

                'shop_client_to_id' => array('name'),
                'shop_daughter_from_id' => array('name'),
                'shop_branch_to_id' => array('name'),
                'shop_branch_from_id' => array('name'),
                'shop_ballast_crusher_to_id' => array('name'),
                'shop_ballast_crusher_from_id' => array('name'),
                'shop_transportation_place_to_id' => array('name'),
                'shop_move_place_to_id' => array('name'),
            )
        );

        foreach ($ids->childs as $child) {
            if($child->values['shop_raw_id']){
                $product = $child->getElementValue('shop_raw_id');
            }elseif($child->values['shop_material_id']){
                $product = $child->getElementValue('shop_material_id');
            }elseif($child->values['shop_product_id']){
                $product = $child->getElementValue('shop_product_id');
            }elseif($child->values['shop_material_other_id']){
                $product = $child->getElementValue('shop_material_other_id');
            }else{
                $product = '';
            }

            if($child->values['shop_daughter_from_id']){
                $from = $child->getElementValue('shop_daughter_from_id');
            }elseif($child->values['shop_branch_from_id']){
                $from = $child->getElementValue('shop_branch_from_id');
            }elseif($child->values['shop_ballast_crusher_from_id']){
                $from = $child->getElementValue('shop_ballast_crusher_from_id');
            }else{
                $from = '';
            }

            if($child->values['shop_client_to_id']){
                $to = $child->getElementValue('shop_client_to_id');
            }elseif($child->values['shop_branch_to_id']){
                $to = $child->getElementValue('shop_branch_to_id');
            }elseif($child->values['shop_ballast_crusher_to_id']){
                $to = $child->getElementValue('shop_ballast_crusher_to_id');
            }elseif($child->values['shop_transportation_place_to_id']){
                $to = $child->getElementValue('shop_transportation_place_to_id');
            }elseif($child->values['shop_move_place_to_id']){
                $to = $child->getElementValue('shop_move_place_to_id');
            }else{
                $to = '';
            }

            $dataCars['data'][] = array(
                'from' => $from,
                'to' => $to,
                'product' => $product,
                'count_trip' => $child->values['count_trip'],
                'distance' => $child->values['distance'],
            );
        }

        $viewObject = 'ab1/_report/'.$this->_sitePageData->languageID.'/waybill/c4';
        $tmp = str_replace('\\', '/', $viewObject);
        try {
            $view = View::factory($tmp);
        }catch (Exception $e) {
            throw new Exception('Шаблон "'.$tmp.'" не найден.');
        }

        $view->cars = $dataCars;
        $view->waybill = $dataWaybill;
        $view->operation = $this->_sitePageData->operation->getValues();
        $view->shop = $this->_sitePageData->shop->getName();
        $view->shopOptions = $this->_sitePageData->shop->getOptionsArray();
        $view->siteData = $this->_sitePageData;
        $strView = Helpers_View::viewToStr($view);

        header('Content-Type: application/x-download;charset=UTF-8');
        // header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: filename="АТ05 Путевой лист 4С №' . $model->getNumber() .'.xml"');
        header('Cache-Control: max-age=0');

        echo $strView;
        exit();
    }

    /**
     * ВС16 Справка по выпуску каменных материалов
     * @throws Exception
     */
    public function action_ballast_issuance_month() {
        set_time_limit(36000);

        $this->_sitePageData->url = '/'.$this->actionURLName.'/shopreport/ballast_issuance_month';

        $dateFromDay = Request_RequestParams::getParamDate('date_from');
        $dateToDay = Request_RequestParams::getParamDate('date_to');
        $dateFromYearDay = Helpers_DateTime::getYearBeginStr(Helpers_DateTime::getYear($dateToDay));

        // Получаем список материалов
        $dataMaterials = array(
            'data' => array(),
            'volume_month' => 0,
            'quantity_month' => 0,
            'volume_year' => 0,
            'quantity_year' => 0,
        );

        // Насыпная плотность / влажность с начала года / за выбранный период
        $date = $dateFromYearDay;
        if(strtotime($dateFromYearDay) > strtotime($dateFromDay)){
            $date = $dateFromDay;
        }

        $params = Request_RequestParams::setParams(
            array(
                'date_from_equally' => $date,
                'date_to' => $dateToDay,
                'shop_material_id_from' => 0,
                'shop_branch_daughter_id' => $this->_sitePageData->shopID,
            )
        );

        $shopMaterialMoistureIDs = Request_Request::find(
            'DB_Ab1_Shop_Material_Moisture',
            $this->_sitePageData->shopMainID, $this->_sitePageData, $this->_driverDB,
            $params, 0, true
        );

        $shopMaterialMoistures = array();
        foreach ($shopMaterialMoistureIDs->childs as $child) {
            $shopMaterialMoistures[$child->values['date'] . '_' . $child->values['shop_material_id']] = $child;
            $shopMaterialMoistures[$child->values['date'] . '_' . $child->values['shop_raw_id']] = $child;
        }

        /****** Производство в рамках выбранного периода ******/
        $params = Request_RequestParams::setParams(
            array(
                'date_from_equally' => $dateFromDay,
                'date_to' => $dateToDay,
            )
        );

        $ids = Request_Request::find(
            'DB_Ab1_Shop_Raw_Material_Item',
            $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB,
            $params, 0, true,
            array(
                'shop_material_id' => array('name', 'shop_material_rubric_make_id'),
                'shop_raw_id' => array('name'),
            )
        );

        foreach ($ids->childs as $child) {
            $rubric = $child->getElementValue('shop_material_id', 'shop_material_rubric_make_id', 0);
            if(!key_exists($rubric, $dataMaterials['data'])){
                $dataMaterials['data'][$rubric] = array(
                    'data' => array(),
                    'volume_month' => 0,
                    'quantity_month' => 0,
                    'volume_year' => 0,
                    'quantity_year' => 0,
                );
            }

            $material = $child->values['shop_material_id'].'_'.$child->values['shop_raw_id'];
            if(!key_exists($material, $dataMaterials['data'][$rubric]['data'])){
                $dataMaterials['data'][$rubric]['data'][$material] = array(
                    'data' => array(),
                    'name' => $child->getElementValue('shop_material_id', 'name', $child->getElementValue('shop_material_id')),
                    'density' => 0,
                    'quantity' => 0,
                    'volume_month' => 0,
                    'quantity_month' => 0,
                    'volume_year' => 0,
                    'quantity_year' => 0,
                );
            }

            $key = $child->values['date'] . '_' . $material;
            if(key_exists($key, $shopMaterialMoistures)){
                $moisture = $shopMaterialMoistures[$key]->values['moisture'];
                $density = $shopMaterialMoistures[$key]->values['density'];
            }else{
                $moisture = 0;
                $density = 1;
            }

            if($density == 0){
                $density = 1;
            }

            $quantity = $child->values['quantity'];
            $dataMaterials['data'][$rubric]['data'][$material]['quantity'] += $quantity;
            $dataMaterials['data'][$rubric]['data'][$material]['density'] += $quantity / $density;

            $quantity = $quantity / 100 * (100 - $moisture);
            $dataMaterials['data'][$rubric]['data'][$material]['quantity_month'] += $quantity;
            $dataMaterials['data'][$rubric]['data'][$material]['volume_month'] += $quantity / $density;

            $dataMaterials['data'][$rubric]['quantity_month'] += $quantity;
            $dataMaterials['data'][$rubric]['volume_month'] += $quantity / $density;

            $dataMaterials['quantity_month'] += $quantity;
            $dataMaterials['volume_month'] += $quantity / $density;
        }

        // определяем среднюю плотность
        foreach ($dataMaterials['data'] as &$childMaterial) {
            $childMaterial['density'] = round($childMaterial['density'] / $childMaterial['quantity'], 2);
        }

        /****** Производство сначала года ******/
        $params = Request_RequestParams::setParams(
            array(
                'date_from_equally' => $dateFromYearDay,
                'date_to' => $dateToDay,
                'shop_material_id_from' => 0,
            )
        );

        $ids = Request_Request::find(
            'DB_Ab1_Shop_Raw_Material_Item',
            $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB,
            $params, 0, true,
            array(
                'shop_material_id' => array('name', 'shop_material_rubric_make_id'),
                'shop_raw_id' => array('name'),
            )
        );

        foreach ($ids->childs as $child) {
            $rubric = $child->getElementValue('shop_material_id', 'shop_material_rubric_make_id', 0);
            if(!key_exists($rubric, $dataMaterials['data'])){
                $dataMaterials['data'][$rubric] = array(
                    'data' => array(),
                    'volume_month' => 0,
                    'quantity_month' => 0,
                    'volume_year' => 0,
                    'quantity_year' => 0,
                );
            }

            $material = $child->values['shop_material_id'].'_'.$child->values['shop_raw_id'];
            if(!key_exists($material, $dataMaterials['data'][$rubric]['data'])){
                $dataMaterials['data'][$rubric]['data'][$material] = array(
                    'data' => array(),
                    'name' => $child->getElementValue('shop_material_id', 'name', $child->getElementValue('shop_material_id')),
                    'density' => 0,
                    'quantity' => 0,
                    'volume_month' => 0,
                    'quantity_month' => 0,
                    'volume_year' => 0,
                    'quantity_year' => 0,
                );
            }

            $key = $child->values['date'] . '_' . $material;
            if(key_exists($key, $shopMaterialMoistures)){
                $moisture = $shopMaterialMoistures[$key]->values['moisture'];
                $density = $shopMaterialMoistures[$key]->values['density'];
            }else{
                $moisture = 0;
                $density = 0;
            }

            if($density == 0){
                $density = 1;
            }

            $quantity = $child->values['quantity'];

            $quantity = $quantity / 100 * (100 - $moisture);
            $dataMaterials['data'][$rubric]['data'][$material]['quantity_year'] += $quantity;
            $dataMaterials['data'][$rubric]['data'][$material]['volume_year'] += $quantity / $density;

            $dataMaterials['data'][$rubric]['quantity_year'] += $quantity;
            $dataMaterials['data'][$rubric]['volume_year'] += $quantity / $density;

            $dataMaterials['quantity_year'] += $quantity;
            $dataMaterials['volume_year'] += $quantity / $density;
        }

        uasort($dataMaterials['data'], array($this, 'mySortMethod'));

        $viewObject = 'ab1/_report/'.$this->_sitePageData->languageID.'/ballast/issuance-month';
        $tmp = str_replace('\\', '/', $viewObject);
        try {
            $view = View::factory($tmp);
        }catch (Exception $e) {
            throw new Exception('Шаблон "'.$tmp.'" не найден.');
        }

        $view->materials = $dataMaterials;
        $view->dateFrom = $dateFromDay;
        $view->dateTo = $dateToDay;
        $view->operation = $this->_sitePageData->operation->getValues();
        $view->shop = $this->_sitePageData->shop->getName();
        $view->shopOptions = $this->_sitePageData->shop->getOptionsArray();
        $view->siteData = $this->_sitePageData;
        $strView = Helpers_View::viewToStr($view);

        header('Content-Type: application/x-download;charset=UTF-8');
        // header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: filename="ВС16 Справка по выпуску каменных материалов за ' . Helpers_DateTime::getPeriodRus($dateFromDay, $dateToDay) .'.xml"');
        header('Cache-Control: max-age=0');

        echo $strView;
        exit();
    }

    /**
     * ВС15 Справка по выполненным работам по выпуску асфальтобетона
     */
    public function action_car_make() {
        set_time_limit(36000);

        $this->_sitePageData->url = '/'.$this->actionURLName.'/shopreport/car_make';

        // задаем время выборки
        $dateFrom = Request_RequestParams::getParamDateTime('date_from');
        $dateTo = Request_RequestParams::getParamDateTime('date_to');
        $dateYear = Helpers_DateTime::getYearBeginStr(Helpers_DateTime::getYear($dateFrom));
        $dateEndYear = Helpers_DateTime::getYearEndStr(Helpers_DateTime::getYear($dateFrom));
        $dateFrom1C = Api_Ab1_Basic::getDateFromBalance1С();

        $shopProductRubricID = Request_RequestParams::getParamInt('shop_product_rubric_id');
        $shopProductIDs = Api_Ab1_Shop_Product::findAllByMainRubric(
            $shopProductRubricID, $this->_sitePageData, $this->_driverDB
        );
        $modelRubric = new Model_Ab1_Shop_Product_Rubric();
        $modelRubric->setDBDriver($this->_driverDB);
        Helpers_DB::getDBObject($modelRubric, $shopProductRubricID, $this->_sitePageData, $this->_sitePageData->shopMainID);

        $dataProduct = array(
            'mount_from' => 0,
            'mount_make' => 0,
            'mount_realization' => 0,
            'mount_charity' => 0,
            'mount_move' => 0,
            'mount_to' => 0,
            'year_from' => 0,
            'year_make' => 0,
            'year_realization' => 0,
            'year_charity' => 0,
            'year_move' => 0,
            'year_to' => 0,
        );
        $dataProducts = $dataProduct;
        $dataProducts['data'] = array();

        /***** Реализация / Благотворительность за заданный период *****/
        $params = array(
            'shop_product_id' => $shopProductIDs,
            'sum_quantity' => true,
            'group_by' => array(
                'shop_product_id', 'shop_product_id.name',
                'is_charity',
            ),
            'sort_by' => array(
                'shop_product_id.name' => 'asc',
            ),
        );

        $ids = Api_Ab1_Shop_Car::getExitShopCar(
            $dateFrom, $dateTo, $this->_sitePageData, $this->_driverDB,
            array('shop_product_id' => array('name')),
            $params, false, null
        );

        foreach ($ids->childs as $child){
            $product = $child->values['shop_product_id'];
            if(!key_exists($product, $dataProducts['data'])){
                $dataProducts['data'][$product] = $dataProduct;
                $dataProducts['data'][$product]['name'] = $child->getElementValue('shop_product_id');
            }

            $quantity = $child->values['quantity'];
            if($child->values['is_charity'] == 1){
                $dataProducts['data'][$product]['mount_charity'] += $quantity;
            }else{
                $dataProducts['data'][$product]['mount_realization'] += $quantity;
            }

            $dataProducts['data'][$product]['mount_make'] += $quantity;
        }

        /***** Реализация / Благотворительность c начала года *****/
        $ids = Api_Ab1_Shop_Car::getExitShopCar(
            $dateYear, $dateTo, $this->_sitePageData, $this->_driverDB,
            array('shop_product_id' => array('name')),
            $params, false, null
        );

        foreach ($ids->childs as $child){
            $product = $child->values['shop_product_id'];
            if(!key_exists($product, $dataProducts['data'])){
                $dataProducts['data'][$product] = $dataProduct;
                $dataProducts['data'][$product]['name'] = $child->getElementValue('shop_product_id');
            }

            $quantity = $child->values['quantity'];
            if($child->values['is_charity'] == 1){
                $dataProducts['data'][$product]['year_charity'] += $quantity;
            }else{
                $dataProducts['data'][$product]['year_realization'] += $quantity;
            }

            $dataProducts['data'][$product]['year_make'] += $quantity;
        }

        /***** Перемещение за заданный период *****/
        $params = array(
            'shop_product_id' => $shopProductIDs,
            'sum_quantity' => true,
            'group_by' => array(
                'shop_product_id', 'shop_product_id.name',
            ),
            'sort_by' => array(
                'shop_product_id.name' => 'asc',
            ),
        );

        $ids = Api_Ab1_Shop_Move_Car::getExitShopMoveCar(
            $dateFrom, $dateTo, $this->_sitePageData, $this->_driverDB,
            array('shop_product_id' => array('name')),
            $params, false, null
        );

        foreach ($ids->childs as $child){
            $product = $child->values['shop_product_id'];
            if(!key_exists($product, $dataProducts['data'])){
                $dataProducts['data'][$product] = $dataProduct;
                $dataProducts['data'][$product]['name'] = $child->getElementValue('shop_product_id');
            }

            $quantity = $child->values['quantity'];
            $dataProducts['data'][$product]['mount_move'] += $quantity;

            $dataProducts['data'][$product]['mount_make'] += $quantity;
        }

        /***** Перемещение c начала года *****/
        $ids = Api_Ab1_Shop_Move_Car::getExitShopMoveCar(
            $dateYear, $dateTo, $this->_sitePageData, $this->_driverDB,
            array('shop_product_id' => array('name')),
            $params, false, null
        );

        foreach ($ids->childs as $child){
            $product = $child->values['shop_product_id'];
            if(!key_exists($product, $dataProducts['data'])){
                $dataProducts['data'][$product] = $dataProduct;
                $dataProducts['data'][$product]['name'] = $child->getElementValue('shop_product_id');
            }

            $quantity = $child->values['quantity'];
            $dataProducts['data'][$product]['year_move'] += $quantity;

            $dataProducts['data'][$product]['year_make'] += $quantity;
        }

        /***** Брак за заданный период *****/
        $params = array(
            'shop_product_id' => $shopProductIDs,
            'sum_quantity' => true,
            'group_by' => array(
                'shop_product_id', 'shop_product_id.name',
            ),
            'sort_by' => array(
                'shop_product_id.name' => 'asc',
            ),
        );

        $ids = Api_Ab1_Shop_Defect_Car::getExitShopDefectCar(
            $dateFrom, $dateTo, $this->_sitePageData, $this->_driverDB,
            array('shop_product_id' => array('name')),
            $params, false, null
        );

        foreach ($ids->childs as $child){
            $product = $child->values['shop_product_id'];
            if(!key_exists($product, $dataProducts['data'])){
                $dataProducts['data'][$product] = $dataProduct;
                $dataProducts['data'][$product]['name'] = $child->getElementValue('shop_product_id');
            }

            $quantity = $child->values['quantity'];
            $dataProducts['data'][$product]['mount_defect'] += $quantity;

            $dataProducts['data'][$product]['mount_make'] += $quantity;
        }

        /***** Брак c начала года *****/
        $ids = Api_Ab1_Shop_Defect_Car::getExitShopDefectCar(
            $dateYear, $dateTo, $this->_sitePageData, $this->_driverDB,
            array('shop_product_id' => array('name')),
            $params, false, null
        );

        foreach ($ids->childs as $child){
            $product = $child->values['shop_product_id'];
            if(!key_exists($product, $dataProducts['data'])){
                $dataProducts['data'][$product] = $dataProduct;
                $dataProducts['data'][$product]['name'] = $child->getElementValue('shop_product_id');
            }

            $quantity = $child->values['quantity'];
            $dataProducts['data'][$product]['year_defect'] += $quantity;

            $dataProducts['data'][$product]['year_make'] += $quantity;
        }

        /***** Производство за заданный период *****/
        $params = array(
            'weighted_at_from' => $dateFrom,
            'weighted_at_to' => $dateTo,
            'shop_product_id' => $shopProductIDs,
            'sum_quantity' => true,
            'group_by' => array(
                'shop_product_id', 'shop_product_id.name',
            ),
            'sort_by' => array(
                'shop_product_id.name' => 'asc',
            ),
        );

        $ids = Request_Request::find(
            'DB_Ab1_Shop_Product_Storage', $this->_sitePageData->shopID,
            $this->_sitePageData, $this->_driverDB, Request_RequestParams::setParams($params), 0, TRUE,
            array(
                'shop_product_id' => array('name'),
            )
        );

        foreach ($ids->childs as $child){
            $product = $child->values['shop_product_id'];
            if(!key_exists($product, $dataProducts['data'])){
                $dataProducts['data'][$product] = $dataProduct;
                $dataProducts['data'][$product]['name'] = $child->getElementValue('shop_product_id');
            }

            $quantity = $child->values['quantity'];
            $dataProducts['data'][$product]['mount_make'] += $quantity;
        }

        /***** Производство c начала года *****/
        $params['weighted_at_from'] = $dateYear;
        $ids = Request_Request::find(
            'DB_Ab1_Shop_Product_Storage', $this->_sitePageData->shopID,
            $this->_sitePageData, $this->_driverDB, Request_RequestParams::setParams($params), 0, TRUE,
            array(
                'shop_product_id' => array('name'),
            )
        );

        foreach ($ids->childs as $child){
            $product = $child->values['shop_product_id'];
            if(!key_exists($product, $dataProducts['data'])){
                $dataProducts['data'][$product] = $dataProduct;
                $dataProducts['data'][$product]['name'] = $child->getElementValue('shop_product_id');
            }

            $quantity = $child->values['quantity'];
            $dataProducts['data'][$product]['year_make'] += $quantity;
        }

        /***** Остаток (реализация) на начало заданного периода *****/
        $params = array(
            'shop_product_id' => $shopProductIDs,
            'sum_quantity' => true,
            'shop_storage_id_from' => 0,
            'group_by' => array(
                'shop_product_id', 'shop_product_id.name',
            ),
            'sort_by' => array(
                'shop_product_id.name' => 'asc',
            ),
        );

        $ids = Api_Ab1_Shop_Car::getExitShopCar(
            null, $dateFrom, $this->_sitePageData, $this->_driverDB,
            array('shop_product_id' => array('name')),
            $params, false, null
        );
        $ids->addChilds(
            Api_Ab1_Shop_Move_Car::getExitShopMoveCar(
                null, $dateFrom, $this->_sitePageData, $this->_driverDB,
                array('shop_product_id' => array('name')),
                $params, false, null
            )
        );

        foreach ($ids->childs as $child){
            $product = $child->values['shop_product_id'];
            if(!key_exists($product, $dataProducts['data'])){
                $dataProducts['data'][$product] = $dataProduct;
                $dataProducts['data'][$product]['name'] = $child->getElementValue('shop_product_id');
            }

            $quantity = $child->values['quantity'];
            $dataProducts['data'][$product]['mount_from'] -= $quantity;
        }

        /***** Остаток (реализация) на начало года *****/
        $ids = Api_Ab1_Shop_Car::getExitShopCar(
            null, $dateYear, $this->_sitePageData, $this->_driverDB,
            array('shop_product_id' => array('name')),
            $params, false, null
        );
        $ids->addChilds(
            Api_Ab1_Shop_Move_Car::getExitShopMoveCar(
                null, $dateFrom, $this->_sitePageData, $this->_driverDB,
                array('shop_product_id' => array('name')),
                $params, false, null
            )
        );

        foreach ($ids->childs as $child){
            $product = $child->values['shop_product_id'];
            if(!key_exists($product, $dataProducts['data'])){
                $dataProducts['data'][$product] = $dataProduct;
                $dataProducts['data'][$product]['name'] = $child->getElementValue('shop_product_id');
            }

            $quantity = $child->values['quantity'];
            $dataProducts['data'][$product]['year_from'] -= $quantity;
        }

        /***** Остаток (производство) на начало заданного периода *****/
        $params = array(
            'created_at_to' => $dateFrom,
            'shop_product_id' => $shopProductIDs,
            'sum_quantity' => true,
            'group_by' => array(
                'shop_product_id', 'shop_product_id.name',
            ),
            'sort_by' => array(
                'shop_product_id.name' => 'asc',
            ),
        );

        $ids = Request_Request::find(
            'DB_Ab1_Shop_Product_Storage', $this->_sitePageData->shopID,
            $this->_sitePageData, $this->_driverDB, Request_RequestParams::setParams($params), 0, TRUE,
            array(
                'shop_product_id' => array('name'),
            )
        );

        foreach ($ids->childs as $child){
            $product = $child->values['shop_product_id'];
            if(!key_exists($product, $dataProducts['data'])){
                $dataProducts['data'][$product] = $dataProduct;
                $dataProducts['data'][$product]['name'] = $child->getElementValue('shop_product_id');
            }

            $quantity = $child->values['quantity'];
            $dataProducts['data'][$product]['mount_from'] += $quantity;
        }

        /***** Остаток (производство) на начало года *****/
        $params['created_at_to'] = $dateYear;
        $ids = Request_Request::find(
            'DB_Ab1_Shop_Product_Storage', $this->_sitePageData->shopID,
            $this->_sitePageData, $this->_driverDB, Request_RequestParams::setParams($params), 0, TRUE,
            array(
                'shop_product_id' => array('name'),
            )
        );

        foreach ($ids->childs as $child){
            $product = $child->values['shop_product_id'];
            if(!key_exists($product, $dataProducts['data'])){
                $dataProducts['data'][$product] = $dataProduct;
                $dataProducts['data'][$product]['name'] = $child->getElementValue('shop_product_id');
            }

            $quantity = $child->values['quantity'];
            $dataProducts['data'][$product]['year_from'] += $quantity;
        }

        /***** Остаток (реализация) на конец заданного периода *****/
        $params = array(
            'shop_product_id' => $shopProductIDs,
            'sum_quantity' => true,
            'shop_storage_id_from' => 0,
            'group_by' => array(
                'shop_product_id', 'shop_product_id.name',
            ),
            'sort_by' => array(
                'shop_product_id.name' => 'asc',
            ),
        );

        $ids = Api_Ab1_Shop_Car::getExitShopCar(
            null, $dateTo, $this->_sitePageData, $this->_driverDB,
            array('shop_product_id' => array('name')),
            $params, false, null
        );

        foreach ($ids->childs as $child){
            $product = $child->values['shop_product_id'];
            if(!key_exists($product, $dataProducts['data'])){
                $dataProducts['data'][$product] = $dataProduct;
                $dataProducts['data'][$product]['name'] = $child->getElementValue('shop_product_id');
            }

            $quantity = $child->values['quantity'];
            $dataProducts['data'][$product]['mount_to'] -= $quantity;
        }

        /***** Остаток (реализация) на конец года *****/
        $ids = Api_Ab1_Shop_Car::getExitShopCar(
            null, $dateEndYear, $this->_sitePageData, $this->_driverDB,
            array('shop_product_id' => array('name')),
            $params, false, null
        );

        foreach ($ids->childs as $child){
            $product = $child->values['shop_product_id'];
            if(!key_exists($product, $dataProducts['data'])){
                $dataProducts['data'][$product] = $dataProduct;
                $dataProducts['data'][$product]['name'] = $child->getElementValue('shop_product_id');
            }

            $quantity = $child->values['quantity'];
            $dataProducts['data'][$product]['year_to'] -= $quantity;
        }

        /***** Остаток (производство) на конец заданного периода *****/
        $params = array(
            //'weighted_at_from' => $dateFrom1C,
            'weighted_at_to' => $dateTo,
            'shop_product_id' => $shopProductIDs,
            'sum_quantity' => true,
            'group_by' => array(
                'shop_product_id', 'shop_product_id.name',
            ),
            'sort_by' => array(
                'shop_product_id.name' => 'asc',
            ),
        );

        $ids = Request_Request::find(
            'DB_Ab1_Shop_Product_Storage', $this->_sitePageData->shopID,
            $this->_sitePageData, $this->_driverDB, Request_RequestParams::setParams($params), 0, TRUE,
            array(
                'shop_product_id' => array('name'),
            )
        );

        foreach ($ids->childs as $child){
            $product = $child->values['shop_product_id'];
            if(!key_exists($product, $dataProducts['data'])){
                $dataProducts['data'][$product] = $dataProduct;
                $dataProducts['data'][$product]['name'] = $child->getElementValue('shop_product_id');
            }

            $quantity = $child->values['quantity'];
            $dataProducts['data'][$product]['mount_to'] += $quantity;
        }

        /***** Остаток (производство) на конец года *****/
        $params['weighted_at_to'] = $dateEndYear;
        $ids = Request_Request::find(
            'DB_Ab1_Shop_Product_Storage', $this->_sitePageData->shopID,
            $this->_sitePageData, $this->_driverDB, Request_RequestParams::setParams($params), 0, TRUE,
            array(
                'shop_product_id' => array('name'),
            )
        );

        foreach ($ids->childs as $child){
            $product = $child->values['shop_product_id'];
            if(!key_exists($product, $dataProducts['data'])){
                $dataProducts['data'][$product] = $dataProduct;
                $dataProducts['data'][$product]['name'] = $child->getElementValue('shop_product_id');
            }

            $quantity = $child->values['quantity'];
            $dataProducts['data'][$product]['year_to'] += $quantity;
        }

        // подсчет итогов
        foreach ($dataProducts['data'] as $product){
            $dataProducts['mount_from'] += $product['mount_from'];
            $dataProducts['mount_make'] += $product['mount_make'];
            $dataProducts['mount_realization'] += $product['mount_realization'];
            $dataProducts['mount_charity'] += $product['mount_charity'];
            $dataProducts['mount_move'] += $product['mount_move'];
            $dataProducts['mount_to'] += $product['mount_to'];
            $dataProducts['year_from'] += $product['year_from'];
            $dataProducts['year_make'] += $product['year_make'];
            $dataProducts['year_realization'] += $product['year_realization'];
            $dataProducts['year_charity'] += $product['year_charity'];
            $dataProducts['year_move'] += $product['year_move'];
            $dataProducts['year_to'] += $product['year_to'];
        }

        uasort($dataProducts['data'], array($this, 'mySortMethod'));

        $viewObject = 'ab1/_report/'.$this->_sitePageData->languageID.'/car/make';
        $tmp = str_replace('\\', '/', $viewObject);
        try {
            $view = View::factory($tmp);
        }catch (Exception $e) {
            throw new Exception('Шаблон "'.$tmp.'" не найден.');
        }

        $view->products = $dataProducts;
        $view->dateFrom = $dateFrom;
        $view->dateTo = $dateTo;
        $view->rubric = $modelRubric->getName();
        $view->operation = $this->_sitePageData->operation->getValues();
        $view->shop = $this->_sitePageData->shop->getName();
        $view->shopOptions = $this->_sitePageData->shop->getOptionsArray();
        $strView = Helpers_View::viewToStr($view);

        header('Content-Type: application/x-download;charset=UTF-8');
        // header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: filename="ВС15 Справка по выполненным работам по выпуску за период ' . Helpers_DateTime::getPeriodRus($dateFrom, $dateTo) .'.xml"');
        header('Cache-Control: max-age=0');

        echo $strView;
        exit();
    }

    /**
     * ВС14 Справка по отгрузке каменных материалов
     * @throws Exception
     */
    public function action_material_export() {
        set_time_limit(36000);

        $this->_sitePageData->url = '/'.$this->actionURLName.'/shopreport/material_export';

        $shopMaterialIDs = NULL;

        // задаем время выборки
        $dateFrom = Request_RequestParams::getParamDateTime('date_from');
        $dateTo = Request_RequestParams::getParamDateTime('date_to');

        $rubric = Request_RequestParams::getParamInt('shop_material_rubric_id');
        if($rubric > 0){
            $model = new Model_Ab1_Shop_Material_Rubric();
            $model->setDBDriver($this->_driverDB);
            Helpers_DB::getDBObject($model, $rubric, $this->_sitePageData, $this->_sitePageData->shopMainID);
            $materialRubricName = $model->getName();
        }else{
            $materialRubricName = '';
        }

        $params = array(
            'is_exit' => 1,
            'shop_material_id' => $shopMaterialIDs,
            'shop_material_rubric_id' => $rubric,
            'date_document_from' => $dateFrom,
            'date_document_to' => $dateTo,
            'shop_branch_daughter_id' => $this->_sitePageData->shopID,
            'sum_daughter_weight' => true,
            'sort_by' => array(
                'date_document_day' => 'asc'
            ),
            'group_by' => array(
                'date_document_day_6_hour',
                'shop_branch_receiver_id', 'shop_branch_receiver_id.name',
                'shop_material_id', 'shop_material_id.name',
            ),
        );

        $ids = Request_Request::find('DB_Ab1_Shop_Car_To_Material',
            $this->_sitePageData->shopMainID, $this->_sitePageData, $this->_driverDB,
            $params,0, TRUE,
            array(
                'shop_branch_receiver_id' => array('name'),
                'shop_material_id' => array('name'),
            )
        );

        $dataMaterials = array(
            'data' => array(),
            'quantity' => 0,
        );
        $dataBranches = array(
            'data' => array(),
            'quantity' => 0,
        );
        $dataDays = array(
            'data' => array(),
            'total' => array(),
            'quantity' => 0,
        );
        foreach ($ids->childs as $child){
            $quantity = $child->values['quantity'];

            $material = $child->values['shop_material_id'];
            if(!key_exists($material, $dataMaterials['data'])){
                $dataMaterials['data'][$material] = array(
                    'id' => $material,
                    'name' => $child->getElementValue('shop_material_id'),
                    'quantity' => 0,
                );
            }
            $dataMaterials['data'][$material]['quantity'] += $quantity;
            $dataMaterials['quantity'] += $quantity;

            $branch = $child->values['shop_branch_receiver_id'];
            if(!key_exists($branch, $dataBranches['data'])){
                $dataBranches['data'][$branch] = array(
                    'id' => $branch,
                    'name' => $child->getElementValue('shop_branch_receiver_id'),
                    'quantity' => 0,
                );
            }
            $dataBranches['data'][$branch]['quantity'] += $quantity;
            $dataBranches['quantity'] += $quantity;

            $day = $child->values['date_document_day'];
            if(!key_exists($day, $dataDays['data'])){
                $dataDays['data'][$day] = array(
                    'data' => array(),
                    'name' => $day,
                    'date' => $day,
                    'quantity' => 0,
                );
            }

            if(!key_exists($material, $dataDays['data'][$day]['data'])){
                $dataDays['data'][$day]['data'][$material] = array(
                    'data' => array(),
                    'name' => $child->getElementValue('shop_material_id'),
                    'quantity' => 0,
                );
            }

            if(!key_exists($branch, $dataDays['data'][$day]['data'][$material]['data'])){
                $dataDays['data'][$day]['data'][$material]['data'][$branch] = 0;
            }

            $dataDays['data'][$day]['data'][$material]['data'][$branch] += $quantity;
            $dataDays['data'][$day]['data'][$material]['quantity'] += $quantity;
            $dataDays['data'][$day]['quantity'] += $quantity;
            $dataDays['quantity'] += $quantity;

            if(!key_exists($material, $dataDays['total'])){
                $dataDays['total'][$material] = array(
                    'data' => array(),
                    'name' => $child->getElementValue('shop_material_id'),
                    'quantity' => 0,
                );
            }

            if(!key_exists($branch, $dataDays['total'][$material]['data'])){
                $dataDays['total'][$material]['data'][$branch] = 0;
            }

            $dataDays['total'][$material]['data'][$branch] += $quantity;
            $dataDays['total'][$material]['quantity'] += $quantity;
        }

        uasort($dataMaterials['data'], array($this, 'mySortMethod'));
        uasort($dataBranches['data'], array($this, 'mySortMethod'));

        $viewObject = 'ab1/_report/'.$this->_sitePageData->languageID.'/material/export';
        $tmp = str_replace('\\', '/', $viewObject);
        try {
            $view = View::factory($tmp);
        }catch (Exception $e) {
            throw new Exception('Шаблон "'.$tmp.'" не найден.');
        }

        $view->materialRubricName = $materialRubricName;
        $view->materials = $dataMaterials;
        $view->branches = $dataBranches;
        $view->days = $dataDays;
        $view->dateFrom = $dateFrom;
        $view->dateTo = $dateTo;
        $view->operation = $this->_sitePageData->operation->getValues();
        $view->shop = $this->_sitePageData->shop->getName();
        $view->shopOptions = $this->_sitePageData->shop->getOptionsArray();
        $strView = Helpers_View::viewToStr($view);

        header('Content-Type: application/x-download;charset=UTF-8');
        // header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: filename="ВС14 Справка по отгрузке каменных материалов за '.Helpers_DateTime::getPeriodRus($dateFrom, $dateTo).'.xml"');
        header('Cache-Control: max-age=0');

        echo $strView;
        exit();
    }

    /**
     * ВС09 Сводка по завозу материалов по сменам
     * Смена 1 (07:00-19:00)
     * Смена 2 (19:00-07:00)
     * @throws Exception
     */
    public function action_material_coming() {
        set_time_limit(36000);

        $this->_sitePageData->url = '/'.$this->actionURLName.'/shopreport/material_coming';

        $shopMaterialIDs = NULL;

        $date = Request_RequestParams::getParamDateTime('date');
        if($date === NULL){
            $date = date('Y-m-d');
        }

        // задаем время выборки
        $dateFrom = Helpers_DateTime::getDateFormatPHP($date);
        $toWorkShift = strtotime(Helpers_DateTime::plusHours($dateFrom, 19));
        $dateTo = Helpers_DateTime::plusHours($dateFrom, 30);
        $dateFrom = Helpers_DateTime::plusHours($dateFrom, 6);

        $isUpdateTareAt = Request_RequestParams::getParamBoolean('is_update_tare_at');

        $shopMaterialRubricID = Request_RequestParams::getParamInt('shop_material_rubric_id');

        $modelRubric = new Model_Ab1_Shop_Material_Rubric();
        $modelRubric->setDBDriver($this->_driverDB);
        if($shopMaterialRubricID > 0){
            Helpers_DB::getDBObject($modelRubric, $shopMaterialRubricID, $this->_sitePageData, $this->_sitePageData->shopMainID);
        }

        if($isUpdateTareAt) {
            $params = Request_RequestParams::setParams(
                array(
                    'update_tare_at_from' => $dateFrom,
                    'update_tare_at_to' => $dateTo,
                    'is_exit' => 1,
                    'shop_material_id' => $shopMaterialIDs,
                    'shop_branch_receiver_id' => $this->_sitePageData->shopID,
                    'shop_material_id.shop_material_rubric_id' => $shopMaterialRubricID,
                    'sort_by' => array(
                        'update_tare_at' => 'asc',
                        'update_tare_at' => 'date_document',
                    )
                )
            );
        }else{
            $params = Request_RequestParams::setParams(
                array(
                    'date_document_from' => $dateFrom,
                    'date_document_to' => $dateTo,
                    'is_exit' => 1,
                    'shop_material_id' => $shopMaterialIDs,
                    'shop_branch_receiver_id' => $this->_sitePageData->shopID,
                    'shop_material_id.shop_material_rubric_id' => Request_RequestParams::getParamInt('shop_material_rubric_id'),
                    'sort_by' => array(
                        'update_tare_at' => 'asc',
                        'update_tare_at' => 'date_document',
                    )
                )
            );
        }

        $ids = Request_Request::find('DB_Ab1_Shop_Car_To_Material',
            $this->_sitePageData->shopMainID, $this->_sitePageData, $this->_driverDB,
            $params, 0, TRUE,
            array(
                'shop_daughter_id' => array('name', 'daughter_weight_id'),
                'shop_branch_daughter_id' => array('name'),
            )
        );

        $dataCars = array(
            'data' => array(
                1 => array(
                    'data' => array(),
                    'quantity' => 0,
                ),
                2 => array(
                    'data' => array(),
                    'quantity' => 0,
                ),
            ),
            'quantity' => 0,
        );
        foreach ($ids->childs as $child){
            // группируем по смене
            if($isUpdateTareAt){
                $date = $child->values['update_tare_at'];
                if(empty($date)){
                    $date = $child->values['date_document'];
                }
            }else{
                $date = $child->values['date_document'];
            }
            if (strtotime($date) > $toWorkShift){
                $workShift = 2;
            }else{
                $workShift = 1;
            }

            $quantity = Api_Ab1_Shop_Car_To_Material::getQuantity($child);

            $dataCars['data'][$workShift]['data'][] = array(
                'number' => $child->values['name'],
                'daughter' => $child->getElementValue(
                    'shop_branch_daughter_id', 'name', $child->getElementValue('shop_daughter_id')
                ),
                'time_from' => Helpers_DateTime::getTimeByDate($child->values['created_at']),
                'time_to' => Helpers_DateTime::getTimeByDate($date),
                'quantity' => $quantity,
            );

            $dataCars['data'][$workShift]['quantity'] += $quantity;
            $dataCars['quantity'] += $quantity;
        }

        $viewObject = 'ab1/_report/'.$this->_sitePageData->languageID.'/material/coming';
        $tmp = str_replace('\\', '/', $viewObject);
        try {
            $view = View::factory($tmp);
        }catch (Exception $e) {
            throw new Exception('Шаблон "'.$tmp.'" не найден.');
        }

        $view->cars = $dataCars;
        $view->dateFrom = $dateFrom;
        $view->dateTo = $dateTo;
        $view->material = $modelRubric->getName();
        $view->operation = $this->_sitePageData->operation->getValues();
        $view->shop = $this->_sitePageData->shop->getName();
        $view->shopOptions = $this->_sitePageData->shop->getOptionsArray();
        $strView = Helpers_View::viewToStr($view);

        header('Content-Type: application/x-download;charset=UTF-8');
        // header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: filename="ВС09 Сводка по завозу материалов по сменам за ' . Helpers_DateTime::getPeriodRus($dateFrom, $dateFrom) . '.xml"');
        header('Cache-Control: max-age=0');

        echo $strView;
        exit();
    }

    /**
     * НУ02 Акт переработки каменных материалов
     * @throws Exception
     */
    public function action_ballast_act_issuance() {
        set_time_limit(36000);

        $this->_sitePageData->url = '/'.$this->actionURLName.'/shopreport/ballast_act_issuance';

        $dateFromDay = Request_RequestParams::getParamDate('date_from');
        $dateToDay = Request_RequestParams::getParamDate('date_to');
        $dateFromYearDay = Helpers_DateTime::getYearBeginStr(Helpers_DateTime::getYear($dateToDay));

        // Насыпная плотность / влажность с начала года / за выбранный период
        $date = $dateFromYearDay;
        if(strtotime($dateFromYearDay) > strtotime($dateFromDay)){
            $date = $dateFromDay;
        }

        $params = Request_RequestParams::setParams(
            array(
                'date_from_equally' => $date,
                'date_to' => $dateToDay,
                'shop_material_id_from' => 0,
                'shop_branch_daughter_id' => $this->_sitePageData->shopID,
            )
        );

        $shopMaterialMoistureIDs = Request_Request::find(
            'DB_Ab1_Shop_Material_Moisture',
            $this->_sitePageData->shopMainID, $this->_sitePageData, $this->_driverDB,
            $params, 0, true
        );

        $shopMaterialMoistures = array();
        foreach ($shopMaterialMoistureIDs->childs as $child) {
            $shopMaterialMoistures[$child->values['date'] . '_' . $child->values['shop_material_id']] = $child;
        }

        /****** Производство в рамках выбранного периода ******/
        $params = Request_RequestParams::setParams(
            array(
                'date_from_equally' => $dateFromDay,
                'date_to' => $dateToDay,
            )
        );

        $ids = Request_Request::find(
            'DB_Ab1_Shop_Raw_Material_Item',
            $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB,
            $params, 0, true,
            array(
                'shop_material_id' => array('name', 'unit'),
                'shop_raw_id' => array('name'),
                'shop_ballast_crusher_id' => array('name'),
            )
        );

        // Получаем список материалов технологических линий
        $dataCrushers = array(
            'data' => array(),
            'quantity' => 0,
        );

        // Получаем список материалов
        $dataMaterials = array(
            'data' => array(),
            'quantity' => 0,
            'moisture' => 0,
            'moisture_quantity' => 0,
            'quantity_minus_moisture' => 0,
        );
        foreach ($ids->childs as $child) {
            $quantity = $child->values['quantity'];

            $crusher = $child->values['shop_ballast_crusher_id'];
            if(!key_exists($crusher, $dataCrushers['data'])){
                $dataCrushers['data'][$crusher] = array(
                    'rubrics' => array(),
                    'data' => array(),
                    'name' => $child->getElementValue('shop_ballast_crusher_id'),
                    'quantity' => 0,
                    'percent' => 0,
                );
            }

            $material = $child->values['shop_material_id'];
            if($material < 1){
                continue;
            }

            if(!key_exists($material, $dataCrushers['data'][$crusher]['data'])){
                $dataCrushers['data'][$crusher]['data'][$material] = array(
                    'data' => array(),
                    'name' => $child->getElementValue('shop_material_id'),
                    'unit' => $child->getElementValue('shop_material_id', 'unit'),
                    'quantity' => 0,
                    'percent' => 0,
                );
            }

            $dataCrushers['data'][$crusher]['data'][$material]['quantity'] += $quantity;
            $dataCrushers['data'][$crusher]['quantity'] += $quantity;
            $dataCrushers['quantity'] += $quantity;

            if(!key_exists($material, $dataMaterials['data'])){
                $dataMaterials['data'][$material] = array(
                    'data' => array(),
                    'name' => $child->getElementValue('shop_material_id'),
                    'unit' => $child->getElementValue('shop_material_id', 'unit'),
                    'quantity' => 0,
                    'moisture' => 0,
                    'moisture_quantity' => 0,
                    'quantity_minus_moisture' => 0,
                );
            }

            $key = $child->values['date'] . '_' . $material;
            if(key_exists($key, $shopMaterialMoistures)){
                $moisture = $shopMaterialMoistures[$key]->values['moisture'];
            }else{
                $moisture = 0;
            }

            $moistureQuantity = round($quantity / 100 * $moisture);

            $dataMaterials['data'][$material]['moisture'] += $moisture * $quantity;

            $dataMaterials['data'][$material]['quantity'] += $quantity;
            $dataMaterials['data'][$material]['moisture_quantity'] += $moistureQuantity;
            $dataMaterials['data'][$material]['quantity_minus_moisture'] += $quantity - $moistureQuantity;

            $dataMaterials['quantity'] += $quantity;
            $dataMaterials['moisture_quantity'] += $moistureQuantity;
            $dataMaterials['quantity_minus_moisture'] += $quantity - $moistureQuantity;
        }

        // определяем среднюю влажность
        foreach ($dataMaterials['data'] as &$child) {
            $child['moisture'] = round($child['moisture'] / $child['quantity'], 2);
        }

        // определяем проценты
        foreach ($dataCrushers['data'] as &$dataCrusher) {
            foreach ($dataCrusher['data'] as &$dataMaterial) {
                $dataMaterial['percent'] = round($dataMaterial['quantity'] / $dataCrusher['quantity'] * 100, 2);
            }
        }

        uasort($dataCrushers['data'], array($this, 'mySortMethod'));
        foreach ($dataCrushers['data'] as &$dataCrusher) {
            uasort($dataCrusher['data'], array($this, 'mySortMethod'));
        }

        uasort($dataMaterials['data'], array($this, 'mySortMethod'));

        $viewObject = 'ab1/_report/'.$this->_sitePageData->languageID.'/ballast/act-issuance';
        $tmp = str_replace('\\', '/', $viewObject);
        try {
            $view = View::factory($tmp);
        }catch (Exception $e) {
            throw new Exception('Шаблон "'.$tmp.'" не найден.');
        }

        $view->materials = $dataMaterials;
        $view->crushers = $dataCrushers;
        $view->dateFrom = $dateFromDay;
        $view->dateTo = $dateToDay;
        $view->operation = $this->_sitePageData->operation->getValues();
        $view->shop = $this->_sitePageData->shop->getName();
        $view->shopOptions = $this->_sitePageData->shop->getOptionsArray();
        $view->siteData = $this->_sitePageData;
        $strView = Helpers_View::viewToStr($view);

        header('Content-Type: application/x-download;charset=UTF-8');
        // header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: filename="НУ02 Акт переработки каменных материалов за ' . Helpers_DateTime::getPeriodRus($dateFromDay, $dateToDay) .'.xml"');
        header('Cache-Control: max-age=0');

        echo $strView;
        exit();
    }

    /**
     * НУ03 Справка по выпуску каменных материалов
     * @throws Exception
     */
    public function action_ballast_issuance() {
        set_time_limit(36000);

        $this->_sitePageData->url = '/'.$this->actionURLName.'/shopreport/ballast_issuance';

        $dateFromDay = Request_RequestParams::getParamDate('date_from');
        $dateToDay = Request_RequestParams::getParamDate('date_to');
        $dateFromYearDay = Helpers_DateTime::getYearBeginStr(Helpers_DateTime::getYear($dateToDay));

        // Получаем список материалов
        $dataMaterials = array(
            'data' => array(),
            'volume_month' => 0,
            'quantity_month' => 0,
            'volume_year' => 0,
            'quantity_year' => 0,
        );

        // Насыпная плотность / влажность с начала года / за выбранный период
        $date = $dateFromYearDay;
        if(strtotime($dateFromYearDay) > strtotime($dateFromDay)){
            $date = $dateFromDay;
        }

        $params = Request_RequestParams::setParams(
            array(
                'date_from_equally' => $date,
                'date_to' => $dateToDay,
                'shop_material_id_from' => 0,
                'shop_branch_daughter_id' => $this->_sitePageData->shopID,
            )
        );

        $shopMaterialMoistureIDs = Request_Request::find(
            'DB_Ab1_Shop_Material_Moisture',
            $this->_sitePageData->shopMainID, $this->_sitePageData, $this->_driverDB,
            $params, 0, true
        );

        $shopMaterialMoistures = array();
        foreach ($shopMaterialMoistureIDs->childs as $child) {
            $shopMaterialMoistures[$child->values['date'] . '_' . $child->values['shop_material_id']] = $child;
        }

        /****** Производство в рамках выбранного периода ******/
        $params = Request_RequestParams::setParams(
            array(
                'date_from_equally' => $dateFromDay,
                'date_to' => $dateToDay,
                'shop_material_id_from' => 0,
            )
        );

        $ids = Request_Request::find(
            'DB_Ab1_Shop_Raw_Material_Item',
            $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB,
            $params, 0, true,
            array(
                'shop_material_id' => array('name'),
            )
        );

        foreach ($ids->childs as $child) {
            $material = $child->values['shop_material_id'];
            if(!key_exists($material, $dataMaterials['data'])){
                $dataMaterials['data'][$material] = array(
                    'data' => array(),
                    'name' => $child->getElementValue('shop_material_id'),
                    'density' => 0,
                    'quantity' => 0,
                    'volume_month' => 0,
                    'quantity_month' => 0,
                    'volume_year' => 0,
                    'quantity_year' => 0,
                );
            }

            $key = $child->values['date'] . '_' . $material;
            if(key_exists($key, $shopMaterialMoistures)){
                $moisture = $shopMaterialMoistures[$key]->values['moisture'];
                $density = $shopMaterialMoistures[$key]->values['density'];
            }else{
                $moisture = 0;
                $density = 1;
            }

            if($density == 0){
                $density = 1;
            }

            $quantity = $child->values['quantity'];
            $dataMaterials['data'][$material]['quantity'] += $quantity;
            $dataMaterials['data'][$material]['density'] += $quantity / $density;

            $quantity = $quantity / 100 * (100 - $moisture);
            $dataMaterials['data'][$material]['quantity_month'] += $quantity;
            $dataMaterials['data'][$material]['volume_month'] += $quantity / $density;

            $dataMaterials['quantity_month'] += $quantity;
            $dataMaterials['volume_month'] += $quantity / $density;
        }

        // определяем среднюю плотность
        foreach ($dataMaterials['data'] as &$childMaterial) {
            $childMaterial['density'] = round($childMaterial['density'] / $childMaterial['quantity'], 2);
        }

        /****** Производство сначала года ******/
        $params = Request_RequestParams::setParams(
            array(
                'date_from_equally' => $dateFromYearDay,
                'date_to' => $dateToDay,
                'shop_material_id_from' => 0,
            )
        );

        $ids = Request_Request::find(
            'DB_Ab1_Shop_Raw_Material_Item',
            $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB,
            $params, 0, true,
            array(
                'shop_material_id' => array('name'),
            )
        );

        foreach ($ids->childs as $child) {
            $material = $child->values['shop_material_id'];
            if(!key_exists($material, $dataMaterials['data'])){
                $dataMaterials['data'][$material] = array(
                    'data' => array(),
                    'name' => $child->getElementValue('shop_material_id'),
                    'density' => 0,
                    'volume_month' => 0,
                    'quantity_month' => 0,
                    'volume_year' => 0,
                    'quantity_year' => 0,
                );
            }

            $key = $child->values['date'] . '_' . $material;
            if(key_exists($key, $shopMaterialMoistures)){
                $moisture = $shopMaterialMoistures[$key]->values['moisture'];
                $density = $shopMaterialMoistures[$key]->values['density'];
            }else{
                $moisture = 0;
                $density = 0;
            }

            if($density == 0){
                $density = 1;
            }

            $quantity = $child->values['quantity'];

            $quantity = $quantity / 100 * (100 - $moisture);
            $dataMaterials['data'][$material]['quantity_year'] += $quantity;
            $dataMaterials['data'][$material]['volume_year'] += $quantity / $density;

            $dataMaterials['quantity_year'] += $quantity;
            $dataMaterials['volume_year'] += $quantity / $density;
        }

        uasort($dataMaterials['data'], array($this, 'mySortMethod'));

        $viewObject = 'ab1/_report/'.$this->_sitePageData->languageID.'/ballast/issuance';
        $tmp = str_replace('\\', '/', $viewObject);
        try {
            $view = View::factory($tmp);
        }catch (Exception $e) {
            throw new Exception('Шаблон "'.$tmp.'" не найден.');
        }

        $view->materials = $dataMaterials;
        $view->dateFrom = $dateFromDay;
        $view->dateTo = $dateToDay;
        $view->operation = $this->_sitePageData->operation->getValues();
        $view->shop = $this->_sitePageData->shop->getName();
        $view->shopOptions = $this->_sitePageData->shop->getOptionsArray();
        $view->siteData = $this->_sitePageData;
        $strView = Helpers_View::viewToStr($view);

        header('Content-Type: application/x-download;charset=UTF-8');
        // header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: filename="НУ03 Справка по выпуску каменных материалов за ' . Helpers_DateTime::getPeriodRus($dateFromDay, $dateToDay) .'.xml"');
        header('Cache-Control: max-age=0');

        echo $strView;
        exit();
    }

    /**
     * ПР08 База клиентов
     * @throws Exception
     */
    public function action_client_list() {
        set_time_limit(36000);

        $this->_sitePageData->url = '/'.$this->actionURLName.'/shopreport/client_list';

        $params = Request_RequestParams::setParams(
            array_merge($_POST, $_GET)
        );
        unset($params['limit_page']);
        $params['id_not'] = 175747;

        $ids = Request_Request::find(
            'DB_Ab1_Shop_Client',
            $this->_sitePageData->shopMainID, $this->_sitePageData, $this->_driverDB,
            $params, 0, true
        );

        $dataClients = array(
            'data' => array(),
        );
        foreach ($ids->childs as $child) {

            $dataClients['data'][] = array(
                'name_1c' => $child->values['name_1c'],
                'bin' => $child->values['bin'],
                'address' => $child->values['address'],
                'account' => $child->values['account'],
                'bank' => $child->values['bank'],
                'director' => $child->values['director'],
                'charter' => $child->values['charter'],
                'phones' => $child->values['phones'],
                'email' => $child->values['email'],
                'contact_person' => $child->values['contact_person'],
            );
        }

        $viewObject = 'ab1/_report/'.$this->_sitePageData->languageID.'/client/list';
        $tmp = str_replace('\\', '/', $viewObject);
        try {
            $view = View::factory($tmp);
        }catch (Exception $e) {
            throw new Exception('Шаблон "'.$tmp.'" не найден.');
        }

        $view->clients = $dataClients;
        $view->operation = $this->_sitePageData->operation->getValues();
        $view->shop = $this->_sitePageData->shop->getName();
        $view->shopOptions = $this->_sitePageData->shop->getOptionsArray();
        $strView = Helpers_View::viewToStr($view);

        header('Content-Type: application/x-download;charset=UTF-8');
        // header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: filename="База клиентов на ' . date('d.m.Y') .'.xml"');
        header('Cache-Control: max-age=0');

        echo $strView;
        exit();
    }

    /**
     * ЛБ03 Насыпная плотность в состоянии естественной влажности, влажность в каменных материалах
     * @throws Exception
     */
    public function action_material_moisture() {
        set_time_limit(36000);

        $this->_sitePageData->url = '/'.$this->actionURLName.'/shopreport/material_moisture';

        $dateFrom = Request_RequestParams::getParamDateTime('date_from');
        $dateTo = Request_RequestParams::getParamDateTime('date_to');

        $params = Request_RequestParams::setParams(
            array(
                'date_from' => $dateFrom,
                'date_to' => $dateTo,
                'sort_by' => array(
                    'shop_branch_daughter_id.name' => 'asc',
                    'shop_daughter_id.name' => 'asc',
                    'shop_material_id.name' => 'asc',
                ),
            )
        );
        $ids = Request_Request::find(
            'DB_Ab1_Shop_Material_Moisture',
            $this->_sitePageData->shopMainID, $this->_sitePageData, $this->_driverDB,
            $params, 0, TRUE,
            array(
                'shop_material_id' => array('name'),
                'shop_daughter_id' => array('name'),
                'shop_branch_daughter_id' => array('name'),
            )
        );

        $dataMaterials = array(
            'data' => array(),
        );
        foreach ($ids->childs as $child) {
            $daughter = $child->values['shop_daughter_id'] . '_' . $child->values['shop_branch_daughter_id'];
            if (!key_exists($daughter, $dataMaterials['data'])) {
                $dataMaterials['data'][$daughter] = array(
                    'name' => $child->getElementValue(
                        'shop_branch_daughter_id', 'name',
                        $child->getElementValue('shop_daughter_id')
                    ),
                    'data' => array(),
                );
            }

            $material = $child->values['shop_material_id'];
            if (!key_exists($material, $dataMaterials['data'][$daughter]['data'])) {
                $dataMaterials['data'][$daughter]['data'][$material] = array(
                    'name' => $child->getElementValue('shop_material_id'),
                    'moisture' => 0,
                    'density' => 0,
                    'quantity' => 0,
                );
            }

            $quantity = $child->values['quantity'];
            $dataMaterials['data'][$daughter]['data'][$material]['moisture'] += $child->values['moisture'] * $quantity;
            $dataMaterials['data'][$daughter]['data'][$material]['density'] += $child->values['density'] * $quantity;
            $dataMaterials['data'][$daughter]['data'][$material]['quantity'] += $quantity;
        }

        foreach ($dataMaterials['data'] as &$daughter) {
            foreach ($daughter['data'] as &$material) {
                if($material['quantity'] != 0){
                    $material['moisture'] = round($material['moisture'] / $material['quantity'], 2);
                    $material['density'] = round($material['density'] / $material['quantity'], 2);
                }else{
                    $material['moisture'] = 0;
                    $material['density'] = 0;
                }
            }
        }

        $viewObject = 'ab1/_report/'.$this->_sitePageData->languageID.'/material/moisture';
        $tmp = str_replace('\\', '/', $viewObject);
        try {
            $view = View::factory($tmp);
        }catch (Exception $e) {
            throw new Exception('Шаблон "'.$tmp.'" не найден.');
        }

        $view->materials = $dataMaterials;
        $view->dateFrom = $dateFrom;
        $view->dateTo = $dateTo;
        $view->operation = $this->_sitePageData->operation->getValues();
        $view->shop = $this->_sitePageData->shop->getName();
        $view->shopOptions = $this->_sitePageData->shop->getOptionsArray();
        $strView = Helpers_View::viewToStr($view);

        header('Content-Type: application/x-download;charset=UTF-8');
        // header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: filename="ЛБ03 Насыпная плотность в состоянии естественной влажности за ' . Helpers_DateTime::getPeriodRus($dateFrom, $dateTo) . 'xml"');
        header('Cache-Control: max-age=0');

        echo $strView;
        exit();
    }

    /**
     * Выпуск материалов по дням
     * @throws Exception
     */
    public function action_material_days_quantity() {
        set_time_limit(36000);

        $this->_sitePageData->url = '/'.$this->actionURLName.'/shopreport/material_days_quantity';

        // задаем время выборки
        $dateFrom = Request_RequestParams::getParamDateTime('date_from');
        $dateTo = Request_RequestParams::getParamDateTime('date_to');

        $dataDays = array(
            'data' => array(),
            'quantity' => 0,
            'amount' => 0,
        );

        $dateFromD = strtotime(Helpers_DateTime::getDateFormatPHP($dateFrom));
        $dateToD = strtotime(Helpers_DateTime::getDateFormatPHP($dateTo));
        while ($dateFromD <= $dateToD + 1){
            $day = date('Y-m-d', $dateFromD);
            $dataDays['data'][$day] = array(
                'day' => $day,
                'data' => array(),
                'quantity' => 0,
                'amount' => 0,
            );

            $dateFromD += 24 * 60 * 60;
        }
        $days = $dataDays['data'];

        $dataMaterials = array(
            'data' => array(),
            'quantity' => 0,
            'amount' => 0,
        );

        /******* Производство материалов *******/
        $params = array(
            'sum_quantity' => true,
            'date_from' => Helpers_DateTime::getDateFormatPHP($dateFrom),
            'date_to' => Helpers_DateTime::getDateFormatPHP(Helpers_DateTime::minusDays($dateTo, 1)),
            'group_by' => array(
                'shop_material_id', 'shop_material_id.name',
                'shop_id', 'shop_id.name',
                'date'
            ),
            'sort_by' => array(
                'shop_id.name' => 'asc',
                'shop_material_id.name' => 'asc',
            ),
        );
        $ids = Request_Request::findBranch(
            'DB_Ab1_Shop_Raw_Material_Item', array(),
            $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
            array(
                'shop_material_id' => array('name'),
                'shop_id' => array('name'),
            )
        );

        foreach ($ids->childs as $child) {
            $quantity = $child->values['quantity'];

            $shop = $child->values['shop_id'];
            if(!key_exists($shop, $dataMaterials['data'])){
                $dataMaterials['data'][$shop] = array(
                    'id' => $shop,
                    'name' => $child->getElementValue('shop_id'),
                    'quantity' => 0,
                    'data' => array(),
                    'days' => $days,
                );
            }

            $material = $child->values['shop_material_id'];
            if(!key_exists($material, $dataMaterials['data'][$shop]['data'])){
                $dataMaterials['data'][$shop]['data'][$material] = array(
                    'name' => $child->getElementValue('shop_material_id'),
                    'quantity' => 0,
                    'data' => array(),
                );
            }

            $day = $child->values['date'];
            if(!key_exists($day, $dataMaterials['data'][$shop]['data'][$material]['data'])){
                $dataMaterials['data'][$shop]['data'][$material]['data'][$day] = array(
                    'day' => $day,
                    'quantity' => 0,
                );
            }

            $dataMaterials['data'][$shop]['days'][$day]['quantity'] += $quantity;

            $dataMaterials['data'][$shop]['data'][$material]['data'][$day]['quantity'] += $quantity;
            $dataMaterials['data'][$shop]['data'][$material]['quantity'] += $quantity;
            $dataMaterials['data'][$shop]['quantity'] += $quantity;
            $dataMaterials['quantity'] += $quantity;

            if(!key_exists($day, $dataDays['data'])){
                $dataDays['data'][$day] = array(
                    'day' => $day,
                    'data' => array(),
                    'quantity' => 0,
                    'amount' => 0,
                );
            }

            if(!key_exists($shop, $dataDays['data'][$day])){
                $dataDays['data'][$day][$shop] = array(
                    'quantity' => 0,
                );
            }

            $dataDays['data'][$day][$shop]['quantity'] += $quantity;
            $dataDays['data'][$day]['quantity'] += $quantity;
            $dataDays['quantity'] += $quantity;
        }

        $viewObject = 'ab1/_report/'.$this->_sitePageData->languageID.'/material/days-quantity';

        $tmp = str_replace('\\', '/', $viewObject);
        try {
            $view = View::factory($tmp);
        }catch (Exception $e) {
            throw new Exception('Шаблон "'.$tmp.'" не найден.');
        }

        $view->days = $dataDays;
        $view->materials = $dataMaterials;
        $view->dateFrom = $dateFrom;
        $view->dateTo = $dateTo;
        $view->operation = $this->_sitePageData->operation->getValues();
        $view->shop = $this->_sitePageData->shop->getName();
        $view->shopOptions = $this->_sitePageData->shop->getOptionsArray();
        $strView = Helpers_View::viewToStr($view);

        header('Content-Type: application/x-download;charset=UTF-8');
        // header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: filename="ФН03 Выпуск материалов за период ' . Helpers_DateTime::getPeriodRus($dateFrom, $dateTo) .'.xml"');
        header('Cache-Control: max-age=0');

        echo $strView;
        exit();
    }

    /**
     * Выпуск продукции по дням
     * @throws Exception
     */
    public function action_car_days() {
        set_time_limit(36000);

        $this->_sitePageData->url = '/'.$this->actionURLName.'/shopreport/car_days';

        $shopProductRubricID = Request_RequestParams::getParamInt('shop_product_rubric_id');
        $shopProductIDs = Api_Ab1_Shop_Product::findAllByMainRubric(
            $shopProductRubricID, $this->_sitePageData, $this->_driverDB
        );
        $modelRubric = new Model_Ab1_Shop_Product_Rubric();
        $modelRubric->setDBDriver($this->_driverDB);
        Helpers_DB::getDBObject($modelRubric, $shopProductRubricID, $this->_sitePageData, $this->_sitePageData->shopMainID);

        // задаем время выборки
        $dateFrom = Request_RequestParams::getParamDateTime('date_from');
        $dateTo = Request_RequestParams::getParamDateTime('date_to');

        $dataDays = array(
            'data' => array(),
            'quantity' => 0,
            'amount' => 0,
        );

        $dateFromD = strtotime(Helpers_DateTime::getDateFormatPHP($dateFrom));
        $dateToD = strtotime(Helpers_DateTime::getDateFormatPHP($dateTo));
        while ($dateFromD < $dateToD){
            $day = date('Y-m-d', $dateFromD);
            $dataDays['data'][$day] = array(
                'day' => $day,
                'realization' => array(
                    'quantity' => 0,
                    'amount' => 0,
                ),
                'charity' => array(
                    'quantity' => 0,
                    'amount' => 0,
                ),
                'move' => array(
                    'quantity' => 0,
                    'amount' => 0,
                ),
                'defect' => array(
                    'quantity' => 0,
                    'amount' => 0,
                ),
                'storage' => array(
                    'quantity' => 0,
                    'amount' => 0,
                ),
                'quantity' => 0,
                'amount' => 0,
            );

            $dateFromD += 24 * 60 * 60;
        }

        $dataProducts = array(
            'realization' => array(
                'quantity' => 0,
                'amount' => 0,
                'data' => array(),
            ),
            'charity' => array(
                'quantity' => 0,
                'amount' => 0,
                'data' => array(),
            ),
            'move' => array(
                'quantity' => 0,
                'amount' => 0,
                'data' => array(),
            ),
            'defect' => array(
                'quantity' => 0,
                'amount' => 0,
                'data' => array(),
            ),
            'storage' => array(
                'quantity' => 0,
                'amount' => 0,
                'data' => array(),
            ),
            'quantity' => 0,
            'amount' => 0,
        );

        /******* Реализация / благотворительность *******/
        $params = array(
            'shop_product_id' => $shopProductIDs,
            'sum_quantity' => true,
            'sum_amount' => true,
            'shop_storage_id' => 0,
            'group_by' => array(
                'shop_product_id', 'shop_product_id.name',
                'exit_at_day_6_hour', 'is_charity',
            ),
            'sort_by' => array(
                'shop_product_id.name' => 'asc',
            ),
        );

        $ids = Api_Ab1_Shop_Car::getExitShopCar(
            $dateFrom, $dateTo, $this->_sitePageData, $this->_driverDB,
            array('shop_product_id' => array('name')),
            $params, false, null
        );

        $params = array(
            'exit_at_from' => $dateFrom,
            'exit_at_to' => $dateTo,
            'shop_product_id' => $shopProductIDs,
            'sum_quantity' => true,
            'sum_amount' => true,
            'shop_storage_id' => 0,
            'group_by' => array(
                'shop_product_id', 'shop_product_id.name',
                'exit_at_day_6_hour', 'is_charity',
            ),
            'sort_by' => array(
                'shop_product_id.name' => 'asc',
            ),
        );
        $shopPieceItemIDs = Request_Request::find(
            'DB_Ab1_Shop_Piece_Item', $this->_sitePageData->shopID,
            $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
            array('shop_product_id' => array('name'))
        );
        $ids->addChilds($shopPieceItemIDs);

        foreach ($ids->childs as $child) {
            $quantity = $child->values['quantity'];
            $amount = $child->values['amount'];

            if($child->values['is_charity'] == 1){
                $dataKey = 'charity';
            }else{
                $dataKey = 'realization';
            }

            $product = $child->values['shop_product_id'];
            if(!key_exists($product, $dataProducts[$dataKey]['data'])){
                $dataProducts[$dataKey]['data'][$product] = array(
                    'name' => $child->getElementValue('shop_product_id'),
                    'quantity' => 0,
                    'amount' => 0,
                    'data' => array(),
                );
            }

            $day = $child->values['exit_at_day'];
            if(!key_exists($day, $dataProducts[$dataKey]['data'][$product]['data'])){
                $dataProducts[$dataKey]['data'][$product]['data'][$day] = array(
                    'day' => $day,
                    'quantity' => 0,
                    'amount' => 0,
                );
            }

            $dataProducts[$dataKey]['data'][$product]['data'][$day]['quantity'] += $quantity;
            $dataProducts[$dataKey]['data'][$product]['data'][$day]['amount'] += $amount;
            $dataProducts[$dataKey]['data'][$product]['quantity'] += $quantity;
            $dataProducts[$dataKey]['data'][$product]['amount'] += $amount;
            $dataProducts[$dataKey]['quantity'] += $quantity;
            $dataProducts[$dataKey]['amount'] += $amount;
            $dataProducts['quantity'] += $quantity;
            $dataProducts['amount'] += $amount;

            if(!key_exists($day, $dataDays['data'])){
                $dataDays['data'][$day] = array(
                    'day' => $day,
                    'realization' => array(
                        'quantity' => 0,
                        'amount' => 0,
                    ),
                    'charity' => array(
                        'quantity' => 0,
                        'amount' => 0,
                    ),
                    'move' => array(
                        'quantity' => 0,
                        'amount' => 0,
                    ),
                    'defect' => array(
                        'quantity' => 0,
                        'amount' => 0,
                    ),
                    'storage' => array(
                        'quantity' => 0,
                        'amount' => 0,
                    ),
                    'quantity' => 0,
                    'amount' => 0,
                );
            }

            $dataDays['data'][$day][$dataKey]['quantity'] += $quantity;
            $dataDays['data'][$day][$dataKey]['amount'] += $amount;
            $dataDays['data'][$day]['quantity'] += $quantity;
            $dataDays['data'][$day]['amount'] += $amount;
            $dataDays['quantity'] += $quantity;
            $dataDays['amount'] += $amount;
        }

        /******* Перемещение *******/
        $params = array(
            'shop_product_id' => $shopProductIDs,
            'sum_quantity' => true,
            'sum_amount' => true,
            'group_by' => array(
                'shop_client_id', 'shop_client_id.name',
                'shop_product_id', 'shop_product_id.name',
                'exit_at_day',
            ),
            'sort_by' => array(
                'shop_client_id.name' => 'asc',
                'shop_product_id.name' => 'asc',
            ),
        );

        $ids = Api_Ab1_Shop_Move_Car::getExitShopMoveCar(
            $dateFrom, $dateTo, $this->_sitePageData, $this->_driverDB,
            array(
                'shop_product_id' => array('name'),
                'shop_client_id' => array('name')
            ),
            $params, false, null
        );
        foreach ($ids->childs as $child) {
            $quantity = $child->values['quantity'];
            $amount = $child->values['amount'];

            $client = $child->values['shop_client_id'];
            if(!key_exists($client, $dataProducts['move']['data'])){
                $dataProducts['move']['data'][$client] = array(
                    'name' => $child->getElementValue('shop_client_id'),
                    'quantity' => 0,
                    'amount' => 0,
                    'data' => array(),
                );
            }

            $product = $child->values['shop_product_id'];
            if(!key_exists($product, $dataProducts['move']['data'][$client]['data'])){
                $dataProducts['move']['data'][$client]['data'][$product] = array(
                    'name' => $child->getElementValue('shop_product_id'),
                    'quantity' => 0,
                    'amount' => 0,
                    'data' => array(),
                );
            }

            $day = $child->values['exit_at_day'];
            if(!key_exists($day, $dataProducts['move']['data'][$client]['data'][$product]['data'])){
                $dataProducts['move']['data'][$client]['data'][$product]['data'][$day] = array(
                    'day' => $day,
                    'quantity' => 0,
                    'amount' => 0,
                );
            }

            $dataProducts['move']['data'][$client]['data'][$product]['data'][$day]['quantity'] += $quantity;
            $dataProducts['move']['data'][$client]['data'][$product]['data'][$day]['amount'] += $amount;
            $dataProducts['move']['data'][$client]['data'][$product]['quantity'] += $quantity;
            $dataProducts['move']['data'][$client]['data'][$product]['amount'] += $amount;
            $dataProducts['move']['data'][$client]['quantity'] += $quantity;
            $dataProducts['move']['data'][$client]['amount'] += $amount;
            $dataProducts['move']['quantity'] += $quantity;
            $dataProducts['move']['amount'] += $amount;
            $dataProducts['quantity'] += $quantity;
            $dataProducts['amount'] += $amount;

            if(!key_exists($day, $dataDays['data'])){
                $dataDays['data'][$day] = array(
                    'day' => $day,
                    'realization' => array(
                        'quantity' => 0,
                        'amount' => 0,
                    ),
                    'charity' => array(
                        'quantity' => 0,
                        'amount' => 0,
                    ),
                    'move' => array(
                        'quantity' => 0,
                        'amount' => 0,
                    ),
                    'storage' => array(
                        'quantity' => 0,
                        'amount' => 0,
                    ),
                    'quantity' => 0,
                    'amount' => 0,
                );
            }

            $dataDays['data'][$day]['move']['quantity'] += $quantity;
            $dataDays['data'][$day]['move']['amount'] += $amount;
            $dataDays['data'][$day]['quantity'] += $quantity;
            $dataDays['data'][$day]['amount'] += $amount;
            $dataDays['quantity'] += $quantity;
            $dataDays['amount'] += $amount;
        }

        /******* Брак *******/
        $params = array(
            'shop_product_id' => $shopProductIDs,
            'sum_quantity' => true,
            'sum_amount' => true,
            'group_by' => array(
                'shop_client_id', 'shop_client_id.name',
                'shop_product_id', 'shop_product_id.name',
                'exit_at_day',
            ),
            'sort_by' => array(
                'shop_client_id.name' => 'asc',
                'shop_product_id.name' => 'asc',
            ),
        );

        $ids = Api_Ab1_Shop_Defect_Car::getExitShopDefectCar(
            $dateFrom, $dateTo, $this->_sitePageData, $this->_driverDB,
            array(
                'shop_product_id' => array('name'),
                'shop_client_id' => array('name')
            ),
            $params, false, null
        );
        foreach ($ids->childs as $child) {
            $quantity = $child->values['quantity'];
            $amount = $child->values['amount'];

            $client = $child->values['shop_client_id'];
            if(!key_exists($client, $dataProducts['defect']['data'])){
                $dataProducts['defect']['data'][$client] = array(
                    'name' => $child->getElementValue('shop_client_id'),
                    'quantity' => 0,
                    'amount' => 0,
                    'data' => array(),
                );
            }

            $product = $child->values['shop_product_id'];
            if(!key_exists($product, $dataProducts['defect']['data'][$client]['data'])){
                $dataProducts['defect']['data'][$client]['data'][$product] = array(
                    'name' => $child->getElementValue('shop_product_id'),
                    'quantity' => 0,
                    'amount' => 0,
                    'data' => array(),
                );
            }

            $day = $child->values['exit_at_day'];
            if(!key_exists($day, $dataProducts['defect']['data'][$client]['data'][$product]['data'])){
                $dataProducts['defect']['data'][$client]['data'][$product]['data'][$day] = array(
                    'day' => $day,
                    'quantity' => 0,
                    'amount' => 0,
                );
            }

            $dataProducts['defect']['data'][$client]['data'][$product]['data'][$day]['quantity'] += $quantity;
            $dataProducts['defect']['data'][$client]['data'][$product]['data'][$day]['amount'] += $amount;
            $dataProducts['defect']['data'][$client]['data'][$product]['quantity'] += $quantity;
            $dataProducts['defect']['data'][$client]['data'][$product]['amount'] += $amount;
            $dataProducts['defect']['data'][$client]['quantity'] += $quantity;
            $dataProducts['defect']['data'][$client]['amount'] += $amount;
            $dataProducts['defect']['quantity'] += $quantity;
            $dataProducts['defect']['amount'] += $amount;
            $dataProducts['quantity'] += $quantity;
            $dataProducts['amount'] += $amount;

            if(!key_exists($day, $dataDays['data'])){
                $dataDays['data'][$day] = array(
                    'day' => $day,
                    'realization' => array(
                        'quantity' => 0,
                        'amount' => 0,
                    ),
                    'charity' => array(
                        'quantity' => 0,
                        'amount' => 0,
                    ),
                    'move' => array(
                        'quantity' => 0,
                        'amount' => 0,
                    ),
                    'defect' => array(
                        'quantity' => 0,
                        'amount' => 0,
                    ),
                    'storage' => array(
                        'quantity' => 0,
                        'amount' => 0,
                    ),
                    'quantity' => 0,
                    'amount' => 0,
                );
            }

            $dataDays['data'][$day]['defect']['quantity'] += $quantity;
            $dataDays['data'][$day]['defect']['amount'] += $amount;
            $dataDays['data'][$day]['quantity'] += $quantity;
            $dataDays['data'][$day]['amount'] += $amount;
            $dataDays['quantity'] += $quantity;
            $dataDays['amount'] += $amount;
        }

        /******* Производство на склад *******/
        $params = Request_RequestParams::setParams(
            array(
                'shop_product_id' => $shopProductIDs,
                'weighted_at_from' => $dateFrom,
                'weighted_at_to' => $dateTo,
                'sum_quantity' => true,
                'group_by' => array(
                    'shop_product_id', 'shop_product_id.name',
                    'weighted_at_day_6_hour',
                ),
                'sort_by' => array(
                    'shop_product_id.name' => 'asc',
                ),
            )
        );
        $ids = Request_Request::find(
            'DB_Ab1_Shop_Product_Storage', $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB,
            $params, 0, TRUE,
            array('shop_product_id' => array('name'))
        );
        foreach ($ids->childs as $child) {
            $quantity = $child->values['quantity'];

            $dataKey = 'storage';

            $product = $child->values['shop_product_id'];
            if(!key_exists($product, $dataProducts[$dataKey]['data'])){
                $dataProducts[$dataKey]['data'][$product] = array(
                    'name' => $child->getElementValue('shop_product_id'),
                    'quantity' => 0,
                    'amount' => 0,
                    'data' => array(),
                );
            }

            $day = $child->values['weighted_at_day'];
            if(!key_exists($day, $dataProducts[$dataKey]['data'][$product]['data'])){
                $dataProducts[$dataKey]['data'][$product]['data'][$day] = array(
                    'day' => $day,
                    'quantity' => 0,
                    'amount' => 0,
                );
            }

            $dataProducts[$dataKey]['data'][$product]['data'][$day]['quantity'] += $quantity;
            $dataProducts[$dataKey]['data'][$product]['quantity'] += $quantity;
            $dataProducts[$dataKey]['quantity'] += $quantity;
            $dataProducts['quantity'] += $quantity;

            if(!key_exists($day, $dataDays['data'])){
                $dataDays['data'][$day] = array(
                    'day' => $day,
                    'realization' => array(
                        'quantity' => 0,
                        'amount' => 0,
                    ),
                    'charity' => array(
                        'quantity' => 0,
                        'amount' => 0,
                    ),
                    'move' => array(
                        'quantity' => 0,
                        'amount' => 0,
                    ),
                    'defect' => array(
                        'quantity' => 0,
                        'amount' => 0,
                    ),
                    'storage' => array(
                        'quantity' => 0,
                        'amount' => 0,
                    ),
                    'quantity' => 0,
                    'amount' => 0,
                );
            }

            $dataDays['data'][$day][$dataKey]['quantity'] += $quantity;
            $dataDays['data'][$day]['quantity'] += $quantity;
            $dataDays['quantity'] += $quantity;
        }

        if(Request_RequestParams::getParamBoolean('is_quantity')){
            $viewObject = 'ab1/_report/'.$this->_sitePageData->languageID.'/car/days-quantity';
        }else{
            $viewObject = 'ab1/_report/'.$this->_sitePageData->languageID.'/car/days-amount';
        }

        $tmp = str_replace('\\', '/', $viewObject);
        try {
            $view = View::factory($tmp);
        }catch (Exception $e) {
            throw new Exception('Шаблон "'.$tmp.'" не найден.');
        }

        $view->days = $dataDays;
        $view->products = $dataProducts;
        $view->dateFrom = $dateFrom;
        $view->dateTo = $dateTo;
        $view->rubric = $modelRubric->getName();
        $view->operation = $this->_sitePageData->operation->getValues();
        $view->shop = $this->_sitePageData->shop->getName();
        $view->shopOptions = $this->_sitePageData->shop->getOptionsArray();
        $strView = Helpers_View::viewToStr($view);

        header('Content-Type: application/x-download;charset=UTF-8');
        // header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: filename="Выпуск продукции за период ' . Helpers_DateTime::getPeriodRus($dateFrom, $dateTo) .'.xml"');
        header('Cache-Control: max-age=0');

        echo $strView;
        exit();
    }

    /**
     * Уведомление о приеме и сдачи цистерн
     * @throws Exception
     */
    public function action_boxcar_drain() {
        set_time_limit(36000);

        $this->_sitePageData->url = '/'.$this->actionURLName.'/shopreport/boxcar_drain';

        $dateFrom = Request_RequestParams::getParamDateTime('date_from');
        $dateTo = Request_RequestParams::getParamDateTime('date_to');

        $params = Request_RequestParams::setParams(
            array(
                'shop_raw_id' => Request_RequestParams::getParamInt('shop_raw_id'),
                'date_departure_from' => $dateFrom,
                'date_departure_to' => $dateTo,
                'sort_by' => array('date_drain_from' => 'asc'),
            )
        );
        $ids = Request_Request::find('DB_Ab1_Shop_Boxcar',
            $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB,
            $params, 0, TRUE,
            array(
                'drain_from_shop_operation_id_1' => array('name'),
                'drain_to_shop_operation_id_1' => array('name'),
                'drain_from_shop_operation_id_2' => array('name'),
                'drain_to_shop_operation_id_2' => array('name'),
                'drain_zhdc_from_shop_operation_id' => array('name'),
                'drain_zhdc_to_shop_operation_id' => array('name'),
                'zhdc_shop_operation_id' => array('name'),
                'brigadier_drain_from_shop_operation_id' => array('name'),
                'brigadier_drain_to_shop_operation_id' => array('name'),
            )
        );

        $dataBoxcars = array(
            'data' => array(),
            'quantity' => 0,
        );
        $dataOperations = array(
            'operation' => array(),
            'brigadier' => array(),
            'zhdc' => array(),
        );
        foreach ($ids->childs as $child){
            $dataBoxcars['data'][] = array(
                'drain_from_operation_1' => $child->getElementValue('drain_from_shop_operation_id_1'),
                'drain_to_operation_1' => $child->getElementValue('drain_to_shop_operation_id_1'),
                'drain_from_operation_2' => $child->getElementValue('drain_from_shop_operation_id_2'),
                'drain_to_operation_2' => $child->getElementValue('drain_to_shop_operation_id_2'),
                'drain_zhdc_from_operation' => $child->getElementValue('drain_zhdc_from_shop_operation_id'),
                'drain_zhdc_to_operation' => $child->getElementValue('drain_zhdc_to_shop_operation_id'),
                'zhdc_operation' => $child->getElementValue('zhdc_shop_operation_id'),
                'date_drain_from' => $child->values['date_drain_from'],
                'date_drain_to' => $child->values['date_drain_to'],
                'date_departure' => $child->values['date_departure'],
                'residue' => $child->values['residue'],
                'number' => $child->values['number'],
                'stamp' => $child->values['stamp'],
                'sending' => $child->values['sending'],
                'drain_text' => $child->values['text'],
                'date_arrival' => $child->values['date_arrival'],
            );

            $operation = $child->values['drain_from_shop_operation_id_1'];
            if($operation > 0 && !key_exists($operation, $dataOperations['operation'])){
                $dataOperations['operation'][$operation] = array(
                    'name' => $child->getElementValue('drain_from_shop_operation_id_1'),
                );
            }
            $operation = $child->values['drain_to_shop_operation_id_1'];
            if($operation > 0 && !key_exists($operation, $dataOperations['operation'])){
                $dataOperations['operation'][$operation] = array(
                    'name' => $child->getElementValue('drain_to_shop_operation_id_1'),
                );
            }
            $operation = $child->values['drain_from_shop_operation_id_2'];
            if($operation > 0 && !key_exists($operation, $dataOperations['operation'])){
                $dataOperations['operation'][$operation] = array(
                    'name' => $child->getElementValue('drain_from_shop_operation_id_2'),
                );
            }
            $operation = $child->values['drain_to_shop_operation_id_2'];
            if($operation > 0 && !key_exists($operation, $dataOperations['operation'])){
                $dataOperations['operation'][$operation] = array(
                    'name' => $child->getElementValue('drain_to_shop_operation_id_2'),
                );
            }
            $operation = $child->values['drain_zhdc_from_shop_operation_id'];
            if($operation > 0 && !key_exists($operation, $dataOperations['zhdc'])){
                $dataOperations['zhdc'][$operation] = array(
                    'name' => $child->getElementValue('drain_zhdc_from_shop_operation_id'),
                );
            }
            $operation = $child->values['drain_zhdc_to_shop_operation_id'];
            if($operation > 0 && !key_exists($operation, $dataOperations['zhdc'])){
                $dataOperations['zhdc'][$operation] = array(
                    'name' => $child->getElementValue('drain_zhdc_to_shop_operation_id'),
                );
            }
            $operation = $child->values['brigadier_drain_from_shop_operation_id'];
            if($operation > 0 && !key_exists($operation, $dataOperations['brigadier'])){
                $dataOperations['brigadier'][$operation] = array(
                    'name' => $child->getElementValue('brigadier_drain_from_shop_operation_id'),
                );
            }
            $operation = $child->values['brigadier_drain_to_shop_operation_id'];
            if($operation > 0 && !key_exists($operation, $dataOperations['brigadier'])){
                $dataOperations['brigadier'][$operation] = array(
                    'name' => $child->getElementValue('brigadier_drain_to_shop_operation_id'),
                );
            }
        }

        $viewObject = 'ab1/_report/'.$this->_sitePageData->languageID.'/boxcar/drain';
        $tmp = str_replace('\\', '/', $viewObject);
        try {
            $view = View::factory($tmp);
        }catch (Exception $e) {
            throw new Exception('Шаблон "'.$tmp.'" не найден.');
        }

        $view->boxcars = $dataBoxcars;
        $view->operations = $dataOperations;
        $view->operation = $this->_sitePageData->operation->getValues();
        $view->shop = $this->_sitePageData->shop->getName();
        $view->shopOptions = $this->_sitePageData->shop->getOptionsArray();
        $strView = Helpers_View::viewToStr($view);

        header('Content-Type: application/x-download;charset=UTF-8');
        // header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: filename="НБ01 Уведомление о приеме и сдачи цистерн за ' . Helpers_DateTime::getPeriodRus($dateFrom, $dateTo) . 'xml"');
        header('Cache-Control: max-age=0');

        echo $strView;
        exit();
    }

    /**
     * Сводка по балласту
     * @throws Exception
     */
    public function action_ballast_raw_material() {
        set_time_limit(36000);

        $this->_sitePageData->url = '/'.$this->actionURLName.'/shopreport/ballast_raw_material';

        $dateFromDay = Request_RequestParams::getParamDate('date_from');
        $dateToDay = Request_RequestParams::getParamDate('date_to');

        $dateFrom = $dateFromDay. ' 06:00:00';
        $dateTo = Helpers_DateTime::getDateFormatPHP(Helpers_DateTime::plusDays($dateToDay, 1)) . ' 06:00:00';
        $dateFromMonthDay = Helpers_DateTime::getDateFormatPHP(
                Helpers_DateTime::getMonthBeginStr(
                    Helpers_DateTime::getMonth($dateFrom), Helpers_DateTime::getYear($dateFrom)
                )
        );
        $dateFromMonth = $dateFromMonthDay. ' 06:00:00';

        // Получаем список произведенного материала по рецептам и технологических линиям
        $dataRawMaterials = array(
            'data' => array(),
            'quantity_day' => 0,
            'quantity_month' => 0,
        );

        // Получаем список материалов
        $dataMaterials = array(
            'data' => array(
                0 => array(
                    'data' => array(),
                    'quantity_day' => 0,
                    'quantity_month' => 0,
                    'realization_day' => 0,
                    'realization_month' => 0,
                    'move_out_day' => 0,
                    'move_out_month' => 0,
                    'move_in' => 0,
                    'total' => 0,
                )
            ),
            'quantity_day' => 0,
            'quantity_month' => 0,
            'realization_day' => 0,
            'realization_month' => 0,
            'move_out_day' => 0,
            'move_out_month' => 0,
            'move_in' => 0,
            'total' => 0,
        );

        // Получаем список технологических линий
        $dataCrushers = array(
            'data' => array(),
            'quantity_day' => 0,
            'quantity_month' => 0,
        );

        $shopSubdivisionIDs = array();

        /****** Производство в рамках выбранного периода ******/
        $params = Request_RequestParams::setParams(
            array(
                'sum_quantity' => true,
                'date_from_equally' => $dateFromDay,
                'date_to' => $dateToDay,
                'group_by' => array(
                    'norm', 'shop_subdivision_id',
                    'shop_raw_id', 'shop_raw_id.name',
                    'shop_material_id', 'shop_material_id.name',
                    'shop_ballast_crusher_id', 'shop_ballast_crusher_id.name',
                    'shop_raw_material_id.shop_raw_id',
                ),
                'sort_by' => [
                    'shop_ballast_crusher_id.name' => 'asc',
                    'shop_ballast_crusher_id' => 'asc',
                ],
            )
        );

        $ids = Request_Request::find(
            'DB_Ab1_Shop_Raw_Material_Item',
            $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB,
            $params, 0, true,
            array(
                'shop_raw_id' => array('name'),
                'shop_material_id' => array('name'),
                'shop_ballast_crusher_id' => array('name'),
                'shop_raw_material_id' => array('shop_raw_id'),
            )
        );

        foreach ($ids->childs as $child) {
            $raw = $child->getElementValue('shop_raw_material_id', 'shop_raw_id');
            if(!key_exists($raw, $dataRawMaterials['data'])){
                $dataRawMaterials['data'][$raw] = array(
                    'data' => array(),
                    'quantity_day' => 0,
                    'quantity_month' => 0,
                );
                $dataCrushers['data'][$raw] = array(
                    'data' => array(),
                    'quantity_day' => 0,
                    'quantity_month' => 0,
                );
                $dataMaterials['data'][$raw] = array(
                    'data' => array(),
                    'quantity_day' => 0,
                    'quantity_month' => 0,
                    'realization_day' => 0,
                    'realization_month' => 0,
                    'move_out_day' => 0,
                    'move_out_month' => 0,
                    'move_in' => 0,
                    'total' => 0,
                );
            }

            $material = $child->values['shop_raw_id'].'_'.$child->values['shop_material_id'];
            if(!key_exists($material, $dataRawMaterials['data'][$raw]['data'])){
                $dataRawMaterials['data'][$raw]['data'][$material] = array(
                    'data' => array(),
                    'name' => $child->getElementValue(
                        'shop_material_id', 'name', $child->getElementValue('shop_raw_id')
                    ),
                    'quantity_day' => 0,
                    'quantity_month' => 0,
                );
            }

            $crusher = $child->values['shop_ballast_crusher_id'];
            if(!key_exists($crusher, $dataRawMaterials['data'][$raw]['data'][$material]['data'])){
                $dataRawMaterials['data'][$raw]['data'][$material]['data'][$crusher] = array(
                    'name' => $child->getElementValue('shop_ballast_crusher_id'),
                    'quantity_day' => 0,
                    'quantity_month' => 0,
                    'norm' => $child->values['norm'],
                );
            }

            $dataRawMaterials['data'][$raw]['data'][$material]['data'][$crusher]['norm'] = round(
                ($dataRawMaterials['data'][$raw]['data'][$material]['data'][$crusher]['norm'] + $child->values['norm']) / 2,
                2
            );

            $quantity = $child->values['quantity'];
            $dataRawMaterials['data'][$raw]['data'][$material]['data'][$crusher]['quantity_day'] += $quantity;
            $dataRawMaterials['data'][$raw]['data'][$material]['quantity_day'] += $quantity;
            $dataRawMaterials['data'][$raw]['quantity_day'] += $quantity;
            $dataRawMaterials['quantity_day'] += $quantity;

            if(!key_exists($material, $dataMaterials['data'][$raw]['data'])){
                $dataMaterials['data'][$raw]['data'][$material] = array(
                    'data' => array(),
                    'name' => $child->getElementValue(
                        'shop_material_id', 'name', $child->getElementValue('shop_raw_id')
                    ),
                    'quantity_day' => 0,
                    'quantity_month' => 0,
                    'realization_day' => 0,
                    'realization_month' => 0,
                    'move_out_day' => 0,
                    'move_out_month' => 0,
                    'move_in' => 0,
                    'total' => 0,
                );
            }
            $dataMaterials['data'][$raw]['data'][$material]['quantity_day'] += $quantity;
            $dataMaterials['data'][$raw]['quantity_day'] += $quantity;
            $dataMaterials['quantity_day'] += $quantity;

            if(!key_exists($crusher, $dataCrushers['data'][$raw]['data'])){
                $dataCrushers['data'][$raw]['data'][$crusher] = array(
                    'data' => array(),
                    'name' => $child->getElementValue('shop_ballast_crusher_id'),
                    'quantity_day' => 0,
                    'quantity_month' => 0,
                );
            }
            $dataCrushers['data'][$raw]['data'][$crusher]['quantity_day'] += $quantity;
            $dataCrushers['data'][$raw]['quantity_day'] += $quantity;
            $dataCrushers['quantity_day'] += $quantity;

            $shopSubdivisionID = $child->values['shop_subdivision_id'];
            $shopSubdivisionIDs[$shopSubdivisionID] = $shopSubdivisionID;
        }

        /****** Производство с начала месяца ******/
        $params = Request_RequestParams::setParams(
            array(
                'sum_quantity' => true,
                'date_from_equally' => $dateFromMonthDay,
                'date_to' => $dateToDay,
                'group_by' => array(
                    'norm',
                    'shop_raw_id', 'shop_raw_id.name',
                    'shop_material_id', 'shop_material_id.name',
                    'shop_ballast_crusher_id', 'shop_ballast_crusher_id.name',
                    'shop_raw_material_id.shop_raw_id',
                )
            )
        );

        $ids = Request_Request::find(
            'DB_Ab1_Shop_Raw_Material_Item',
            $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB,
            $params, 0, true,
            array(
                'shop_raw_id' => array('name'),
                'shop_material_id' => array('name'),
                'shop_ballast_crusher_id' => array('name'),
                'shop_raw_material_id' => array('shop_raw_id'),
            )
        );

        foreach ($ids->childs as $child) {
            $raw = $child->getElementValue('shop_raw_material_id', 'shop_raw_id');
            if(!key_exists($raw, $dataRawMaterials['data'])){
                $dataRawMaterials['data'][$raw] = array(
                    'data' => array(),
                    'quantity_day' => 0,
                    'quantity_month' => 0,
                );
                $dataCrushers['data'][$raw] = array(
                    'data' => array(),
                    'quantity_day' => 0,
                    'quantity_month' => 0,
                );
                $dataMaterials['data'][$raw] = array(
                    'data' => array(),
                    'quantity_day' => 0,
                    'quantity_month' => 0,
                    'realization_day' => 0,
                    'realization_month' => 0,
                    'move_out_day' => 0,
                    'move_out_month' => 0,
                    'move_in' => 0,
                    'total' => 0,
                );
            }

            $material = $child->values['shop_raw_id'].'_'.$child->values['shop_material_id'];
            if(!key_exists($material, $dataRawMaterials['data'][$raw]['data'])){
                $dataRawMaterials['data'][$raw]['data'][$material] = array(
                    'data' => array(),
                    'name' => $child->getElementValue(
                        'shop_material_id', 'name', $child->getElementValue('shop_raw_id')
                    ),
                    'quantity_day' => 0,
                    'quantity_month' => 0,
                );
            }

            $crusher = $child->values['shop_ballast_crusher_id'];
            if(!key_exists($crusher, $dataRawMaterials['data'][$raw]['data'][$material]['data'])){
                $dataRawMaterials['data'][$raw]['data'][$material]['data'][$crusher] = array(
                    'data' => array(),
                    'name' => $child->getElementValue('shop_ballast_crusher_id'),
                    'norm' => 0,
                    'quantity_day' => 0,
                    'quantity_month' => 0,
                );
            }

            $quantity = $child->values['quantity'];
            $dataRawMaterials['data'][$raw]['data'][$material]['data'][$crusher]['quantity_month'] += $quantity;
            $dataRawMaterials['data'][$raw]['data'][$material]['quantity_month'] += $quantity;
            $dataRawMaterials['data'][$raw]['quantity_month'] += $quantity;
            $dataRawMaterials['quantity_month'] += $quantity;

            if(!key_exists($material, $dataMaterials['data'][$raw]['data'])){
                $dataMaterials['data'][$raw]['data'][$material] = array(
                    'data' => array(),
                    'name' => $child->getElementValue(
                        'shop_material_id', 'name', $child->getElementValue('shop_raw_id')
                    ),
                    'quantity_day' => 0,
                    'quantity_month' => 0,
                    'realization_day' => 0,
                    'realization_month' => 0,
                    'move_out_day' => 0,
                    'move_out_month' => 0,
                    'move_in' => 0,
                    'total' => 0,
                );
            }
            $dataMaterials['data'][$raw]['data'][$material]['quantity_month'] += $quantity;
            $dataMaterials['data'][$raw]['quantity_month'] += $quantity;
            $dataMaterials['quantity_month'] += $quantity;

            if(!key_exists($crusher, $dataCrushers['data'][$raw]['data'])){
                $dataCrushers['data'][$raw]['data'][$crusher] = array(
                    'name' => $child->getElementValue('shop_ballast_crusher_id'),
                    'quantity_day' => 0,
                    'quantity_month' => 0,
                );
            }
            $dataCrushers['data'][$raw]['data'][$crusher]['quantity_month'] += $quantity;
            $dataCrushers['data'][$raw]['quantity_month'] += $quantity;
            $dataCrushers['quantity_month'] += $quantity;
        }

        /****** Перемещение в рамках выбранного периода ******/
        if(!empty($shopSubdivisionIDs)){
            $params = Request_RequestParams::setParams(
                array(
                    'shop_branch_daughter_id' => $this->_sitePageData->shopID,
                    'shop_subdivision_daughter_id' => $shopSubdivisionIDs,
                    'sum_daughter_weight' => true,
                    'date_document_from_equally' => $dateFrom,
                    'date_document_to' => $dateTo,
                    'group_by' => array(
                        'shop_branch_receiver_id',
                        'shop_material_id', 'shop_material_id.name',
                    )
                )
            );

            $ids = Request_Request::find(
                'DB_Ab1_Shop_Car_To_Material',
                $this->_sitePageData->shopMainID, $this->_sitePageData, $this->_driverDB,
                $params, 0, true,
                array(
                    'shop_material_id' => array('name'),
                )
            );

            foreach ($ids->childs as $child) {
                $quantity = $child->values['quantity'];
                $material = '0_'.$child->values['shop_material_id'];
                $branch = $child->values['shop_branch_receiver_id'];

                $isFind = false;
                foreach ($dataMaterials['data'] as &$dataMaterial) {
                    if(!key_exists($material, $dataMaterial['data'])){
                        continue;
                    }

                    if($branch == $this->_sitePageData->shopID){
                        $dataMaterial['data'][$material]['move_in'] += $quantity;
                        $dataMaterial['move_in'] += $quantity;
                    }else{
                        $dataMaterial['data'][$material]['move_out_day'] += $quantity;
                        $dataMaterial['move_out_day'] += $quantity;
                    }

                    $isFind = true;
                }

                if(!$isFind) {
                    if (!key_exists($material, $dataMaterials['data'][0]['data'])) {
                        $dataMaterials['data'][0]['data'][$material] = array(
                            'data' => array(),
                            'name' => $child->getElementValue(
                                'shop_material_id', 'name', $child->getElementValue('shop_raw_id')
                            ),
                            'quantity_day' => 0,
                            'quantity_month' => 0,
                            'realization_day' => 0,
                            'realization_month' => 0,
                            'move_out_day' => 0,
                            'move_out_month' => 0,
                            'move_in' => 0,
                            'total' => 0,
                        );

                        if ($branch == $this->_sitePageData->shopID) {
                            $dataMaterials['data'][0]['data'][$material]['move_in'] += $quantity;
                            $dataMaterials['data'][0]['move_in'] += $quantity;
                        } else {
                            $dataMaterials['data'][0]['data'][$material]['move_out_day'] += $quantity;
                            $dataMaterials['data'][0]['move_out_day'] += $quantity;
                        }
                    }
                    continue;
                }

                if($branch == $this->_sitePageData->shopID){
                    $dataMaterials['move_in'] += $quantity;
                }else{
                    $dataMaterials['move_out_day'] += $quantity;
                }
            }
        }

        /****** Перемещение в рамках с начала месяца ******/
        if(!empty($shopSubdivisionIDs)){
            $params = Request_RequestParams::setParams(
                array(
                    'shop_branch_daughter_id' => $this->_sitePageData->shopID,
                    'shop_branch_receiver_id_not' => $this->_sitePageData->shopID,
                    'shop_subdivision_daughter_id' => $shopSubdivisionIDs,
                    'sum_daughter_weight' => true,
                    'date_document_from_equally' => $dateFromMonth,
                    'date_document_to' => $dateTo,
                    'group_by' => array(
                        'shop_branch_receiver_id',
                        'shop_material_id', 'shop_material_id.name',
                    )
                )
            );

            $ids = Request_Request::find(
                'DB_Ab1_Shop_Car_To_Material',
                $this->_sitePageData->shopMainID, $this->_sitePageData, $this->_driverDB,
                $params, 0, true,
                array(
                    'shop_material_id' => array('name'),
                )
            );

            foreach ($ids->childs as $child) {
                $quantity = $child->values['quantity'];
                $material = '0_'.$child->values['shop_material_id'];
                $branch = $child->values['shop_branch_receiver_id'];

                $isFind = false;
                foreach ($dataMaterials['data'] as &$dataMaterial) {
                    if(!key_exists($material, $dataMaterial['data'])){
                        continue;
                    }

                    $dataMaterial['data'][$material]['move_out_month'] += $quantity;
                    $dataMaterial['move_out_month'] += $quantity;

                    $isFind = true;
                }

                if(!$isFind) {
                    if (!key_exists($material, $dataMaterials['data'][0]['data'])) {
                        $dataMaterials['data'][0]['data'][$material] = array(
                            'data' => array(),
                            'name' => $child->getElementValue(
                                'shop_material_id', 'name', $child->getElementValue('shop_raw_id')
                            ),
                            'quantity_day' => 0,
                            'quantity_month' => 0,
                            'realization_day' => 0,
                            'realization_month' => 0,
                            'move_out_day' => 0,
                            'move_out_month' => 0,
                            'move_in' => 0,
                            'total' => 0,
                        );

                        if ($branch == $this->_sitePageData->shopID) {
                            $dataMaterials['data'][0]['data'][$material]['move_in'] += $quantity;
                            $dataMaterials['data'][0]['move_in'] += $quantity;
                        } else {
                            $dataMaterials['data'][0]['data'][$material]['move_out_month'] += $quantity;
                            $dataMaterials['data'][0]['move_out_month'] += $quantity;
                        }
                    }
                    continue;
                }

                $dataMaterials['move_out_month'] += $quantity;
            }
        }

        $viewObject = 'ab1/_report/'.$this->_sitePageData->languageID.'/ballast/raw-material';
        $tmp = str_replace('\\', '/', $viewObject);
        try {
            $view = View::factory($tmp);
        }catch (Exception $e) {
            throw new Exception('Шаблон "'.$tmp.'" не найден.');
        }
        foreach ($dataMaterials['data'] as &$dataMaterial){
            uasort($dataMaterial['data'], array($this, 'mySortMethod'));
        }
        foreach ($dataRawMaterials['data'] as &$dataRawMaterial){
            uasort($dataRawMaterial['data'], array($this, 'mySortMethod'));
        }

        $view->crushers = $dataCrushers;
        $view->materials = $dataMaterials;
        $view->rawMaterials = $dataRawMaterials;
        $view->dateFrom = Request_RequestParams::getParamDate('date_from');
        $view->dateTo = Request_RequestParams::getParamDate('date_to');
        $view->operation = $this->_sitePageData->operation->getValues();
        $view->siteData = $this->_sitePageData;
        $view->shop = $this->_sitePageData->shop->getName();
        $view->shopOptions = $this->_sitePageData->shop->getOptionsArray();
        $strView = Helpers_View::viewToStr($view);

        header('Content-Type: application/x-download;charset=UTF-8');
        // header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: filename="НУ01 Сводка по балласту выпуск материала за ' . Helpers_DateTime::getPeriodRus($dateFrom, $dateTo) .'.xml"');
        header('Cache-Control: max-age=0');

        echo $strView;
        exit();
    }

    public function action_consumable_return_xls() {
        $this->_sitePageData->url = '/cash/shopreport/consumable_return_xls';

        $filePath = Helpers_Path::getPathFile(
            APPPATH, array('views', 'ab1', '_report', $this->_sitePageData->dataLanguageID, '_xls'), 'consumable.xls'
        );
        if(!file_exists($filePath)){
            throw new HTTP_Exception_500('File shablon not is found.');
        }

        // id записи
        $id = Request_RequestParams::getParamInt('id');
        $model = new Model_Ab1_Shop_Payment_Return();
        if (!$this->getDBObject($model, $id)) {
            throw new HTTP_Exception_404('Payment return not is found!');
        }

        $consumable = $model->getValues(TRUE, TRUE);
        $consumable['amount_str'] = Func::numberToStr($model->getAmount(), TRUE, $this->_sitePageData->currency);
        $consumable['created_at'] = strftime('%d.%m.%Y %H:%M', strtotime($model->getCreatedAt()));

        $shopClient = $model->getElement('shop_client_id', true, $this->_sitePageData->shopMainID);
        if($shopClient == null){
            $consumable['extradite'] = '';
        }else {
            $consumable['extradite'] = $shopClient->getName1C();
        }

        $consumable['base'] = 'Возврат денежных средств клиенту';

        Helpers_Excel::saleInFile(
            $filePath,
            array('consumable' => $consumable, 'operation' => array('name' => $this->_sitePageData->operation->getName())),
            array(),
            'php://output',
            'РКО '.$model->id.'.xlsx'
        );
        exit();
    }

    public function action_consumablexls() {
        $this->_sitePageData->url = '/'.$this->actionURLName.'/shopreport/consumablexls';

        $filePath = Helpers_Path::getPathFile(
            APPPATH, array('views', 'ab1', '_report', $this->_sitePageData->dataLanguageID, '_xls'), 'consumable.xls'
        );
        if(!file_exists($filePath)){
            throw new HTTP_Exception_500('File shablon not is found.');
        }

        // id записи
        $id = Request_RequestParams::getParamInt('id');
        $model = new Model_Ab1_Shop_Consumable();
        if (!$this->getDBObject($model, $id)) {
            throw new HTTP_Exception_404('Consumable not is found!');
        }

        $consumable = $model->getValues(TRUE, TRUE);
        $consumable['amount_str'] = Func::numberToStr($model->getAmount(), TRUE, $this->_sitePageData->currency);
        $consumable['created_at'] = strftime('%d.%m.%Y %H:%M', strtotime($model->getCreatedAt()));

        Helpers_Excel::saleInFile(
            $filePath,
            array(
                'consumable' => $consumable,
                'operation' => array('name' => $this->_sitePageData->operation->getName())
            ),
            array(),
            'php://output',
            'РКО '.$model->id.'.xlsx'
        );

        exit();
    }

    public function action_pkoxls_payment() {
        $this->_sitePageData->url = '/'.$this->actionURLName.'/shopreport/pkoxls_payment';

        $filePath = Helpers_Path::getPathFile(
            APPPATH, array('views', 'ab1', '_report', $this->_sitePageData->dataLanguageID, '_xls'), 'pko_payment.xls'
        );
        if(!file_exists($filePath)){
            throw new HTTP_Exception_500('File shablon not is found.');
        }

        // id записи
        $id = Request_RequestParams::getParamInt('id');
        $model = new Model_Ab1_Shop_Payment();
        if (!$this->getDBObject($model, $id)) {
            throw new HTTP_Exception_404('Payment not is found!');
        }
        $model->dbGetElements($this->_sitePageData->shopMainID, array('shop_client_id'));

        $payment = $model->getValues(TRUE, TRUE);
        $payment['amount'] = round($payment['amount']);
        $payment['amount_str'] = Func::numberToStr(round($model->getAmount(), 0), TRUE, $this->_sitePageData->currency);
        $payment['amount_nds'] = round($model->getAmount() / 112 * 12, 2);
        $payment['created_at'] = strftime('%d.%m.%Y', strtotime($model->getCreatedAt()));
        $payment['created_at_str'] = Helpers_DateTime::getDateTimeFormatRusMonthStr($model->getCreatedAt());

        // получаем текст для ПКО
        $shopPaymentItemIDs = Request_Request::find(
            'DB_Ab1_Shop_Payment_Item', $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB,
            Request_RequestParams::setParams(
                [
                    'shop_payment_id' => $id,
                    'sort_by' => [
                        'id' => 'asc',
                    ]
                ]
            ),
            0, TRUE
        );
        $s = '';
        foreach($shopPaymentItemIDs->childs as $shopPaymentItemID){
            $model = new Model_Ab1_Shop_Product();
            if ($this->getDBObject($model, $shopPaymentItemID->values['shop_product_id'])) {
                $s = $s . $model->getName() . ', ';
            }
        }
        $payment['text'] = substr($s, 0, -2);

        Helpers_Excel::saleInFile(
            $filePath,
            array(
                'payment' => $payment,
                'operation' => array('name' => $this->_sitePageData->operation->getName())
            ),
            array(),
            'php://output',
            'ПКО '.$model->id.'.xlsx'
        );

        exit();
    }

    public function action_orderxls_payment() {
        $this->_sitePageData->url = '/'.$this->actionURLName.'/shopreport/orderxls_payment';

        $filePath = Helpers_Path::getPathFile(
            APPPATH, array('views', 'ab1', '_report', $this->_sitePageData->dataLanguageID, '_xls'), 'order_payment.xls'
        );
        if(!file_exists($filePath)){
            throw new HTTP_Exception_500('File shablon not is found.');
        }

        // id записи
        $id = Request_RequestParams::getParamInt('id');
        $model = new Model_Ab1_Shop_Payment();
        if (!$this->getDBObject($model, $id)) {
            throw new HTTP_Exception_404('Payment not is found!');
        }

        $model->dbGetElements($this->_sitePageData->shopMainID, array('shop_client_id'), $this->_sitePageData->languageIDDefault);

        $payment = $model->getValues(TRUE, TRUE);
        $payment['amount_str'] = Func::numberToStr($model->getAmount(), TRUE, $this->_sitePageData->currency);
        $payment['amount_nds'] = round($model->getAmount() / 112 * 12, 2);
        $payment['created_at'] = strftime('%d.%m.%Y', strtotime($model->getCreatedAt()));


        $shopPaymentItemIDs = Request_Request::find(
            'DB_Ab1_Shop_Payment_Item', $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB,
            Request_RequestParams::setParams(
                [
                    'shop_payment_id' => $id,
                    'sort_by' => [
                        'id' => 'asc',
                    ]
                ]
            ),
            0, TRUE
        );
        $shopPaymentItems = array();
        foreach($shopPaymentItemIDs->childs as $shopPaymentItemID){
            $model = new Model_Ab1_Shop_Product();
            if ($this->getDBObject($model, $shopPaymentItemID->values['shop_product_id'])) {
                $shopPaymentItemID->values[Model_Basic_BasicObject::FIELD_ELEMENTS]['shop_product_id'] = $model->getValues(TRUE, TRUE);
            }
            $shopPaymentItems[] = $shopPaymentItemID->values;
        }

        $payment['count'] = count($shopPaymentItems);

        Helpers_Excel::saleInFile(
            $filePath,
            array(
                'payment' => $payment,
                'operation' => array('name' => $this->_sitePageData->operation->getName())
            ),
            array('payment_items' => $shopPaymentItems),
            'php://output',
            'Счет '.$model->id.'.xlsx'
        );

        exit();
    }

    public function action_ttnxls() {
        $this->_sitePageData->url = '/'.$this->actionURLName.'/shopreport/ttnxls';

        $filePath = Helpers_Path::getPathFile(
            APPPATH, array('views', 'ab1', '_report', $this->_sitePageData->dataLanguageID, '_xls'), 'ttn.xls'
        );
        if(!file_exists($filePath)){
            throw new HTTP_Exception_500('File shablon not is found.');
        }

        // id записи
        $id = Request_RequestParams::getParamInt('id');
        $model = new Model_Ab1_Shop_Piece();
        if (!$this->getDBObject($model, $id)) {
            throw new HTTP_Exception_404('Piece not is found!');
        }

        $model->dbGetElements(
            $this->_sitePageData->shopMainID,
            array('shop_client_id', 'shop_driver_id', 'shop_delivery_id'),
            $this->_sitePageData->languageIDDefault
        );

        $piece = $model->getValues(TRUE, TRUE);
        $piece['time'] = date('H:i');
        $piece['created_at_str'] = Helpers_DateTime::getDateTimeDayMonthRus($model->getCreatedAt(), TRUE);
        if($piece['delivery_km'] <= 0){
            $piece['delivery_km'] = Arr::path($piece, Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_delivery_id.km', 0);
        }
        if($model->getShopDeliveryID() > 0){
            $piece['delivery_str'] = 'централизовано';
        }else{
            $piece['delivery_str'] = 'самовывоз';
        }

        $shopPieceItemIDs = Request_Request::find('DB_Ab1_Shop_Piece_Item', $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB,
            array('shop_piece_id' => $id, Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE), 0, TRUE,
            array('shop_product_id' => array('name_1c', 'unit')));
        $shopPieceItems = array();
        foreach($shopPieceItemIDs->childs as $shopPieceItemID){
            $shopPieceItems[] = $shopPieceItemID->values;
        }

        Helpers_Excel::saleInFile(
            $filePath,
            array('piece' => $piece),
            array('piece_items' => $shopPieceItems),
            'php://output',
            'ТТН '.$model->id.'.xlsx',
            false
        );

        exit();
    }

    public function action_talon_weighted_xls() {
        $this->_sitePageData->url = '/'.$this->actionURLName.'/shopreport/talon_weighted_xls';

        $filePath = Helpers_Path::getPathFile(
            APPPATH, array('views', 'ab1', '_report', $this->_sitePageData->dataLanguageID, '_xls', 'talon'), 'talon_weighted.xls'
        );
        if(!file_exists($filePath)){
            throw new HTTP_Exception_500('File shablon "'.$filePath.'" not is found.');
        }

        // id записи
        $id = Request_RequestParams::getParamInt('id');
        $model = new Model_Ab1_Shop_Car();
        if (!$this->getDBObject($model, $id)) {
            throw new HTTP_Exception_404('Car not is found!');
        }
        $model->dbGetElements(
            $this->_sitePageData->shopMainID,
            array(
                'shop_driver_id',
                'shop_client_id',
                'shop_product_id',
                'cash_operation_id',
                'weighted_exit_operation_id'
            ),
            $this->_sitePageData->languageIDDefault
        );

        $car = $model->getValues(TRUE, TRUE);
        $car['brutto'] = $car['tarra'] + $car['quantity'];
        $car['created_at'] = strftime('%d.%m.%Y %H:%M', strtotime($model->getCreatedAt()));
        $operation = array('name' => $this->_sitePageData->operation->getName());
        Helpers_Excel::saleInFile(
            $filePath,
            array(
                'car' => $car,
                'operation' => $operation
            ),
            array(),
            'php://output',
            'Талон '.$model->id.'.xlsx'
        );

        exit();
    }

    public function action_talonxls() {
        $this->_sitePageData->url = '/'.$this->actionURLName.'/shopreport/talonxls';

        $filePath = Helpers_Path::getPathFile(
            APPPATH, array('views', 'ab1', '_report', $this->_sitePageData->dataLanguageID, '_xls', 'talon'), 'talon.xls'
        );
        if(!file_exists($filePath)){
            throw new HTTP_Exception_500('File shablon "'.$filePath.'" not is found.');
        }

        // id записи
        $id = Request_RequestParams::getParamInt('id');
        $model = new Model_Ab1_Shop_Car();
        if (!$this->getDBObject($model, $id)) {
            throw new HTTP_Exception_404('Car not is found!');
        }
        $model->dbGetElements(
            $this->_sitePageData->shopMainID,
            array('shop_driver_id', 'shop_client_id', 'shop_product_id'),
            $this->_sitePageData->languageIDDefault
        );

        $car = $model->getValues(TRUE, TRUE);
        $car['created_at'] = strftime('%d.%m.%Y %H:%M', strtotime($model->getCreatedAt()));
        $operation = array('name' => $this->_sitePageData->operation->getName());
        Helpers_Excel::saleInFile(
            $filePath,
            array(
                'car' => $car,
                'operation' => $operation
            ),
            array(),
            'php://output',
            'Талон '.$model->id.'.xlsx'
        );

        exit();
    }

    public function action_talon_left_xls() {
        $this->_sitePageData->url = '/'.$this->actionURLName.'/shopreport/talon_left_xls';

        $filePath = Helpers_Path::getPathFile(
            APPPATH, array('views', 'ab1', '_report', $this->_sitePageData->dataLanguageID, '_xls', 'talon'), 'talon_piece_left.xls'
        );
        if(!file_exists($filePath)){
            throw new HTTP_Exception_500('File shablon "'.$filePath.'" not is found.');
        }

        // id записи
        $id = Request_RequestParams::getParamInt('id');
        $model = new Model_Ab1_Shop_Car();
        if (!$this->getDBObject($model, $id)) {
            throw new HTTP_Exception_404('Car not is found!');
        }
        $model->dbGetElements(
            $this->_sitePageData->shopMainID,
            array('shop_driver_id', 'shop_client_id', 'shop_product_id'),
            $this->_sitePageData->languageIDDefault
        );

        $car = $model->getValues(TRUE, TRUE);
        $car['created_at'] = strftime('%d.%m.%Y %H:%M', strtotime($model->getCreatedAt()));
        $operation = array('name' => $this->_sitePageData->operation->getName());
        Helpers_Excel::saleInFile(
            $filePath,
            array(
                'car' => $car,
                'operation' => $operation
            ),
            array(),
            'php://output',
            'Талон '.$model->id.'.xlsx'
        );

        exit();
    }

    public function action_move_talonxls() {
        $this->_sitePageData->url = '/'.$this->actionURLName.'/shopreport/move_talonxls';

        $filePath = Helpers_Path::getPathFile(
            APPPATH, array('views', 'ab1', '_report', $this->_sitePageData->dataLanguageID, '_xls', 'talon'), 'talon.xls'
        );
        if(!file_exists($filePath)){
            throw new HTTP_Exception_500('File shablon not is found.');
        }

        // id записи
        $id = Request_RequestParams::getParamInt('id');
        $model = new Model_Ab1_Shop_Move_Car();
        if (!$this->getDBObject($model, $id)) {
            throw new HTTP_Exception_404('Car not is found!');
        }
        $model->dbGetElements(
            $this->_sitePageData->shopMainID, array('shop_driver_id', 'shop_client_id', 'shop_product_id')
        );

        $car = $model->getValues(TRUE, TRUE);
        $car['created_at'] = strftime('%d.%m.%Y %H:%M', strtotime($model->getCreatedAt()));
        Helpers_Excel::saleInFile(
            $filePath,
            array('car' => $car),
            array(),
            'php://output',
            'Талон '.$model->id.'.xlsx'
        );

        exit();
    }

    public function action_talon_piecexls() {
        $this->_sitePageData->url = '/'.$this->actionURLName.'/shopreport/talon_piecexls';

        $filePath = Helpers_Path::getPathFile(
            APPPATH, array('views', 'ab1', '_report', $this->_sitePageData->dataLanguageID, '_xls', 'talon'), 'talon_piece_left.xls'
        );
        if(!file_exists($filePath)){
            throw new HTTP_Exception_500('File shablon not is found.');
        }

        // id записи
        $id = Request_RequestParams::getParamInt('id');
        $model = new Model_Ab1_Shop_Piece();
        if (!$this->getDBObject($model, $id)) {
            throw new HTTP_Exception_404('Piece not is found!');
        }
        $model->dbGetElements(
            $this->_sitePageData->shopMainID,
            array('shop_driver_id', 'shop_client_id'),
            $this->_sitePageData->languageIDDefault
        );

        $car = $model->getValues(TRUE, TRUE);
        $car['created_at'] = strftime('%d.%m.%Y %H:%M', strtotime($model->getCreatedAt()));

        $pieceIDs = Request_Request::find('DB_Ab1_Shop_Piece_Item', $this->_sitePageData->shopID, $this->_sitePageData,
            $this->_driverDB, array('shop_piece_id' => $id, Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE),
            0, TRUE, array('shop_product_id' => array('name', 'unit')));

        $productsName = '';
        foreach ($pieceIDs->childs as $pieceID){
            $s = Arr::path($pieceID->values, Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_product_id.name', '');
            if (!empty($s)){
                $productsName .= $s.': '. Func::getNumberStr($pieceID->values['quantity'], FALSE)
                    . ' ' . Arr::path($pieceID->values, Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_product_id.unit', '')."\r\n";
            }
        }
        $productsName = substr($productsName, 0,-2);
        $car[Model_Basic_BasicObject::FIELD_ELEMENTS]['shop_product_id']['name'] = $productsName;

        Helpers_Excel::saleInFile(
            $filePath,
            array(
                'car' => $car,
                'operation' => array('name' => $this->_sitePageData->operation->getName())
            ),
            array(),
            'php://output',
            'Талон '.$model->id.'.xlsx');

        exit();
    }

    public function action_pkoxls() {
        $this->_sitePageData->url = '/cash/shopreport/pkoxls';

        $filePath = Helpers_Path::getPathFile(
            APPPATH, array('views', 'ab1', '_report', $this->_sitePageData->dataLanguageID, '_xls', 'talon'), 'pko.xls'
        );
        if(!file_exists($filePath)){
            throw new HTTP_Exception_500('File shablon not is found.');
        }

        // id записи
        $id = Request_RequestParams::getParamInt('id');
        if ($id === NULL) {
            throw new HTTP_Exception_404('Car not is found!');
        }else {
            $model = new Model_Ab1_Shop_Car();
            if (!$this->getDBObject($model, $id)) {
                throw new HTTP_Exception_404('Car not is found!');
            }
            $model->dbGetElements($this->_sitePageData->shopMainID,
                array('shop_client_id', 'shop_product_id'),
                $this->_sitePageData->languageIDDefault);
        }

        $car = $model->getValues(TRUE, TRUE);
        $car['amount_str'] = Func::numberToStr($model->getAmount(), TRUE, $this->_sitePageData->currency);
        $car['amount_nds'] = round($model->getAmount() / 112 * 12, 2);
        $car['created_at'] = strftime('%d.%m.%Y %H:%M', strtotime($model->getCreatedAt()));

        $modelPayment = new Model_Ab1_Shop_Payment();
        if (!$this->getDBObject($modelPayment, $model->getShopPaymentID())) {
            throw new HTTP_Exception_404('Payment not is found!');
        }
        $modelPayment->dbGetElements($this->_sitePageData->shopMainID, 'shop_client_id');

        $payment = $modelPayment->getValues(TRUE, TRUE);
        $payment['amount'] = round($payment['amount']);
        $payment['amount_str'] = Func::numberToStr($modelPayment->getAmount(), TRUE, $this->_sitePageData->currency);
        $payment['amount_nds'] = round($modelPayment->getAmount() / 112 * 12, 2);
        $payment['created_at'] = strftime('%d.%m.%Y', strtotime($modelPayment->getCreatedAt()));
        $payment['created_at_str'] = Helpers_DateTime::getDateTimeFormatRusMonthStr($modelPayment->getCreatedAt());

        Helpers_Excel::saleInFile($filePath,
            array(
                'car' => $car,
                'payment' => $payment,
                'operation' => array('name' => $this->_sitePageData->operation->getName())
            ),
            array(),
            'php://output',
            'ПКО '.$model->id.'.xlsx'
        );

        exit();
    }

    /**
     * ПТ01 ПЛАТЕЖНЫЙ КАЛЕНДАРЬ по исполнению условий договора
     * @throws Exception
     */
    public function action_payment_schedule() {
        set_time_limit(36000);

        $this->_sitePageData->url = '/'.$this->actionURLName.'/shopreport/payment_schedule';

        $date = Request_RequestParams::getParamDate('date');
        if($date === null){
            $date = date('Y-m-d');
        }
        $dateYear = Helpers_DateTime::getYearBeginStr(Helpers_DateTime::getYear($date));

        // Считываем балансы на начало года
        $shopClientIDs = Api_Ab1_Shop_Client::calcBalanceClientsOnDate(
            $dateYear, $this->_sitePageData, $this->_driverDB, null, ['is_lawsuit']
        );

        // удаляем всех у кого баланс положительный и кто не покупатель
        foreach ($shopClientIDs->childs as $key => $child){
            if($child->values['balance'] > -1000 || !Request_RequestParams::isBoolean($child->values['is_buyer'])){
                unset($shopClientIDs->childs[$key]);
            }
        }

        //  исключаем клиентов, которые не имею договора
        if(Request_RequestParams::getParamBoolean('is_contract') && count($shopClientIDs->childs) > 0){
            $params = Request_RequestParams::setParams(
                array(
                    'shop_client_id' => $shopClientIDs->getChildArrayID(),
                    'date' => $date,
                    'client_contract_type_id' => Model_Ab1_ClientContract_Type::CLIENT_CONTRACT_TYPE_SALE_PRODUCT,
                    'group_by' => array(
                        'shop_client_id',
                    )
                )
            );
            $shopClientContractIDs = Request_Request::find('DB_Ab1_Shop_Client_Contract',
                $this->_sitePageData->shopMainID, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE
            );
            $shopClients = $shopClientContractIDs->getChildArrayInt('shop_client_id', true);
            foreach ($shopClientIDs->childs as $key => $child){
                if(!key_exists($child->id, $shopClients)){
                    unset($shopClientIDs->childs[$key]);
                }
            }
        }

        // Считываем балансы на текущую дату
        $currentShopClientIDs = Api_Ab1_Shop_Client::calcBalanceClientsOnDate(
            $date, $this->_sitePageData, $this->_driverDB, null, ['is_lawsuit']
        );

        // добавляем дополнительно тех клиентов, которые стали должниками на текущий момент времени / фиксируем баланс на текущий момент
        foreach ($currentShopClientIDs->childs as $key => $child){
            if($child->values['balance'] > -1000 || !Request_RequestParams::isBoolean($child->values['is_buyer'])){
                continue;
            }

            if(!key_exists($child->id, $shopClientIDs->childs)){
                $child->values['balance_current'] = $child->values['balance'];
                $child->values['balance'] = 0;
                $shopClientIDs->childs[$child->id] = $child;
            }else{
                $shopClientIDs->childs[$child->id]->values['balance_current'] = $child->values['balance'];
            }
        }

        $dataDates = array(
            'data' => array(),
            'amount' => array(
                1 => 0,
                0 => 0,
            ),
        );
        if(count($shopClientIDs->childs) > 0) {
            $shopClients = $shopClientIDs->getChildArrayID();

            /** Получаем данные если ли судебное решение по клиентам **/
            $params = Request_RequestParams::setParams(
                array(
                    'id' => $shopClients,
                    'is_public_ignore' => true,
                    'is_delete_ignore' => true,
                    'is_buyer' => true,
                )
            );
            $ids = Request_Request::find('DB_Ab1_Shop_Client',
                $this->_sitePageData->shopMainID, $this->_sitePageData, $this->_driverDB, $params , 0, true
            );
            foreach ($ids->childs as $child) {
                $client = $child->values['id'];
                if (!key_exists($client, $shopClientIDs->childs)) {
                    continue;
                }

                // если клиент не покупатель, то удаляем его из списка
                if($child->values['is_buyer'] == 0){
                    unset($shopClientIDs->childs[$client]);
                    continue;
                }

                $shopClientIDs->childs[$client]->values['is_lawsuit'] = $child->values['is_lawsuit'];
            }

            /** Считываем планируемые оплаты **/
            $params = Request_RequestParams::setParams(
                array(
                    'date_from_equally' => $date,
                    'shop_client_id' => $shopClients,
                )
            );
            $ids = Request_Request::findBranch('DB_Ab1_Shop_Payment_Schedule',
                array(), $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
                array(
                    'shop_client_contract_id' => array('to_at'),
                    'shop_client_guarantee_id' => array('to_at'),
                )
            );

            foreach ($ids->childs as $child) {
                $client = $child->values['shop_client_id'];
                if (!key_exists($client, $shopClientIDs->childs)) {
                    continue;
                }

                $date = $child->values['date'];
                if (!key_exists($date, $dataDates['data'])) {
                    $dataDates['data'][$date] = array(
                        'name' => $date,
                        'date' => $date,
                        'amount' => array(
                            1 => 0,
                            0 => 0,
                        ),
                    );
                }

                if($child->values['shop_client_contract_id'] > 0) {
                    $shopClientIDs->childs[$client]->values['shop_client_contract_payment_at'] = $child->getElementValue('shop_client_contract_id', 'to_at');
                }

                if($child->values['shop_client_guarantee_id'] > 0) {
                    $shopClientIDs->childs[$client]->values['shop_client_guarantee_to_at'] = $child->getElementValue('shop_client_guarantee_id', 'to_at');
                }

                if (!key_exists('payment_schedules', $shopClientIDs->childs[$client]->values)) {
                    $shopClientIDs->childs[$client]->values['payment_schedules'] = array(
                        $date => 0,
                    );
                }elseif (!key_exists($date, $shopClientIDs->childs[$client]->values['payment_schedules'])) {
                    $shopClientIDs->childs[$client]->values['payment_schedules'][$date] = 0;
                }

                $amount = $child->values['amount'];
                $shopClientIDs->childs[$client]->values['payment_schedules'][$date] += $amount;
            }
        }
        uasort($dataDates['data'], array($this, 'mySortMethod'));
        $shopClientIDs->childsSortBy(
            array(
                'balance_current' => 'desc',
                'name' => 'asc',
            ),
            true, true
        );

        $dataClients = array(
            'data' => array(),
            'balance_year' => array(
                1 => 0,
                0 => 0,
            ),
            'balance_current' => array(
                1 => 0,
                0 => 0,
            ),
            'receive' => array(
                1 => 0,
                0 => 0,
            ),
        );
        foreach ($shopClientIDs->childs as $child) {
            $balanceCurrent = Arr::path($child->values, 'balance_current', 0) * -1;
            $balance = $child->values['balance'] * -1;

            $receive = 0;
            if($balance > 0){
                $receive = $balance - $balanceCurrent;
            }

            $paymentSchedules = Arr::path($child->values, 'payment_schedules', array());
            $isLawsuit = $child->values['is_lawsuit'];

            $dataClients['data'][] = array(
                'name' => $child->values['name'],
                'balance_year' => $balance,
                'balance_current' => $balanceCurrent,
                'receive' => $receive,
                'payment_schedules' => $paymentSchedules,
                'contract' => Arr::path($child->values, 'shop_client_contract_payment_at', ''),
                'guarantee' => Arr::path($child->values, 'shop_client_guarantee_to_at', ''),
                'is_lawsuit' => $isLawsuit,
            );

            foreach ($paymentSchedules as $date => $amount) {
                $dataDates['data'][$date]['amount'][$isLawsuit] += $amount;
            }

            $dataClients['balance_year'][$isLawsuit] += $balance;
            $dataClients['balance_current'][$isLawsuit] += $balanceCurrent;
            $dataClients['balance_current'][$isLawsuit] += $receive;
        }

        $viewObject = 'ab1/_report/'.$this->_sitePageData->languageID.'/payment/schedule';
        $tmp = str_replace('\\', '/', $viewObject);
        try {
            $view = View::factory($tmp);
        }catch (Exception $e) {
            throw new Exception('Шаблон "'.$tmp.'" не найден.');
        }

        $view->clients = $dataClients;
        $view->dates = $dataDates;
        $view->date = $date;
        $view->dateYear = $dateYear;
        $view->operation = $this->_sitePageData->operation->getValues();
        $view->shop = $this->_sitePageData->shop->getName();
        $view->shopOptions = $this->_sitePageData->shop->getOptionsArray();
        $strView = Helpers_View::viewToStr($view);

        header('Content-Type: application/x-download;charset=UTF-8');
        // header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: filename="ПТ01 ПЛАТЕЖНЫЙ КАЛЕНДАРЬ по исполнению условий договора на ' . Helpers_DateTime::getDateTimeFormatRus($date) .'.xml"');
        header('Cache-Control: max-age=0');

        echo $strView;
        exit();
    }

    /**
     * ПР07 Справка по исполнению договоров по потребителям продукции
     * @throws Exception
     */
    public function action_contract_spent() {
        set_time_limit(36000);

        $this->_sitePageData->url = '/'.$this->actionURLName.'/shopreport/contract_spent';

        $shopProductRubrics = Request_RequestParams::getParamArray('shop_product_rubric_ids');

        $dateFrom = Request_RequestParams::getParamDate('date_from');
        $dateTo = Request_RequestParams::getParamDate('date_to');

        $params = Request_RequestParams::setParams(
            array(
                'contract_date_from' => $dateFrom,
                'contract_date_to' => $dateTo,
                'is_public_ignore' => true,
                'shop_product_id_from' => 0,
                'shop_client_contract_id.client_contract_type_id' => Model_Ab1_ClientContract_Type::CLIENT_CONTRACT_TYPE_SALE_PRODUCT,
                'shop_client_contract_id.is_basic' => true,
                'is_basic' => true,
                'sort_by' => array(
                    'shop_client_contract_id.from_at' => 'asc',
                )
            )
        );

        $ids = Request_Request::find(
            'DB_Ab1_Shop_Client_Contract_Item', $this->_sitePageData->shopMainID,
            $this->_sitePageData, $this->_driverDB,
            $params, 0, true,
            array(
                'shop_client_id' => array('name'),
                'product_root_rubric_id' => array('id', 'name', 'unit'),
                'shop_client_contract_id' => array('number', 'from_at', 'amount'),
            )
        );

        // добавляем строчки увеличивающие баланс договора
        $shopClientContractIDs = $ids->getChildArrayInt('shop_client_contract_id', true);
        if(!empty($shopClientContractIDs)) {
            $params = Request_RequestParams::setParams(
                array(
                    'is_add_basic_contract' => true,
                    'basic_shop_client_contract_id' => $shopClientContractIDs,
                    'is_public_ignore' => true,
                    'sort_by' => array(
                        'shop_client_contract_id.from_at' => 'asc',
                    )
                )
            );
            $ids->addChilds(
                Request_Request::find('DB_Ab1_Shop_Client_Contract_Item',
                    $this->_sitePageData->shopMainID, $this->_sitePageData, $this->_driverDB,
                    $params, 0, true,
                    array(
                        'shop_client_id' => array('name'),
                        'product_root_rubric_id' => array('id', 'name', 'unit'),
                        'shop_client_contract_id' => array('number', 'from_at', 'amount'),
                    )
                )
            );
        }

        $rubrics = array();
        $dataRubrics = array(
            'data' => array(),
        );
        foreach ($ids->childs as $child) {
            // группировка по базовым рубрикам
            $rootID = $child->getElementValue('product_root_rubric_id', 'id', 0);
            if($rootID < 1 || (!empty($shopProductRubrics) && array_search($rootID, $shopProductRubrics) === false)){
                continue;
            }

            if (!key_exists($rootID, $dataRubrics['data'])) {
                $dataRubrics['data'][$rootID] = array(
                    'id' => $rootID,
                    'name' => $child->getElementValue('product_root_rubric_id'),
                    'unit' => $child->getElementValue('product_root_rubric_id', 'unit'),
                    'quantity' => 0,
                    'quantity_spent' => 0,
                    'quantity_balance' => 0,
                );
                $rubrics[$rootID] = array(
                    'quantity' => 0,
                    'quantity_spent' => 0,
                    'quantity_balance' => 0,
                );
            }
        }
        uasort($dataRubrics['data'], array($this, 'mySortMethod'));

        $dataContracts = array(
            'data' => array(),
        );
        foreach ($ids->childs as $child) {
            $rootID = $child->getElementValue('product_root_rubric_id', 'id', 0);
            if($rootID < 1 || (!empty($shopProductRubrics) && array_search($rootID, $shopProductRubrics) === false)){
                continue;
            }

            if($child->values['basic_shop_client_contract_id'] > 0) {
                $contract = $child->values['basic_shop_client_contract_id'];
            }else {
                $contract = $child->values['shop_client_contract_id'];
            }

            // группировка по договорам
            if(!key_exists($contract, $dataContracts['data'])){
                $dataContracts['data'][$contract] = array(
                    'client' => $child->getElementValue('shop_client_id'),
                    'number' => $child->getElementValue('shop_client_contract_id', 'number'),
                    'from_at' => $child->getElementValue('shop_client_contract_id', 'from_at'),
                    'data' => $rubrics,
                );
            }

            // группировка по базовым рубрикам
            $quantity = $child->values['quantity'];
            $dataContracts['data'][$contract]['data'][$rootID]['quantity'] += $quantity;
            $dataRubrics['data'][$rootID]['quantity'] += $quantity;

            $dataContracts['data'][$contract]['data'][$rootID]['quantity_balance'] =
                $dataContracts['data'][$contract]['data'][$rootID]['quantity'];
            $dataRubrics['data'][$rootID]['quantity_balance'] = $dataRubrics['data'][$rootID]['quantity'];
        }

        // расходы договоров
        if($dateFrom !== null){
            $dateFrom .= ' 06:00:00';
        }
        $dateTo = Request_RequestParams::getParamDate('date_to');
        if($dateTo !== null){
            $dateTo .= ' 06:00:00';
        }

        $params = Request_RequestParams::setParams(
            array(
                'exit_at_from' => $dateFrom,
                'exit_at_to' => $dateTo,
                'is_exit' => 1,
                'quantity_from' => 0,
                'is_charity' => false,
                'shop_client_contract_id_from' => 0,
                'sum_quantity' => TRUE,
                'group_by' => array(
                    'shop_client_contract_id',
                    'root_rubric_id.id',
                )
            )
        );
        $elements = array(
            'root_rubric_id' => array('id'),
        );

        $shopCarItemIDs = Request_Request::findBranch('DB_Ab1_Shop_Car_Item',
            array(), $this->_sitePageData, $this->_driverDB, $params, 0, TRUE, $elements
        );
        $shopPieceItemIDs = Request_Request::findBranch('DB_Ab1_Shop_Piece_Item',
            array(), $this->_sitePageData, $this->_driverDB, $params, 0, TRUE, $elements
        );
        $shopCarItemIDs->addChilds($shopPieceItemIDs);

        foreach ($shopCarItemIDs->childs as $child) {
            $rootID = $child->getElementValue('root_rubric_id', 'id', 0);
            if($rootID < 1 || (!empty($shopProductRubrics) && array_search($rootID, $shopProductRubrics) === false)){
                continue;
            }

            // группировка по договорам
            $contract = $child->values['shop_client_contract_id'];
            if(!key_exists($contract, $dataContracts['data'])){
                continue;
            }

            // группировка по базовым рубрикам
            $quantity = $child->values['quantity'];
            $dataContracts['data'][$contract]['data'][$rootID]['quantity_spent'] += $quantity;
            $dataRubrics['data'][$rootID]['quantity_spent'] += $quantity;

            $dataContracts['data'][$contract]['data'][$rootID]['quantity_balance'] =
                $dataContracts['data'][$contract]['data'][$rootID]['quantity']
                - $dataContracts['data'][$contract]['data'][$rootID]['quantity_spent'];
            $dataRubrics['data'][$rootID]['quantity_balance'] =
                $dataRubrics['data'][$rootID]['quantity']
                - $dataRubrics['data'][$rootID]['quantity_spent'];
        }

        $viewObject = 'ab1/_report/'.$this->_sitePageData->languageID.'/contract/spent';
        $tmp = str_replace('\\', '/', $viewObject);
        try {
            $view = View::factory($tmp);
        }catch (Exception $e) {
            throw new Exception('Шаблон "'.$tmp.'" не найден.');
        }

        $view->contracts = $dataContracts;
        $view->rubrics = $dataRubrics;
        $view->dateFrom = $dateFrom;
        $view->dateTo = $dateTo;
        $view->operation = $this->_sitePageData->operation->getValues();
        $view->shop = $this->_sitePageData->shop->getName();
        $view->shopOptions = $this->_sitePageData->shop->getOptionsArray();
        $strView = Helpers_View::viewToStr($view);

        header('Content-Type: application/x-download;charset=UTF-8');
        // header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: filename="ПР07 Справка по исполнению договоров по потребителям продукции c ' . Helpers_DateTime::getDateTimeFormatRus($dateFrom) . ' до ' . Helpers_DateTime::getDateTimeFormatRus($dateTo) .'.xml"');
        header('Cache-Control: max-age=0');

        echo $strView;
        exit();
    }

    /**
     * Реестр договоров по потребителям продукции
     * @throws Exception
     */
    public function action_contract_product() {
        set_time_limit(36000);

        $this->_sitePageData->url = '/'.$this->actionURLName.'/shopreport/contract_product';

        $year = Request_RequestParams::getParamInt('contract_date_year');

        $params = Request_RequestParams::setParams(
            array_merge(
                $_POST,
                $_GET,
                array(
                    'is_public_ignore' => true,
                    'sort_by' => array(
                        'shop_client_contract_id.from_at' => 'asc',
                    ),
                )
            )
        );
        $params['shop_client_contract_id.is_basic'] = true;
        $params['shop_client_contract_id.client_contract_type_id'] = Model_Ab1_ClientContract_Type::CLIENT_CONTRACT_TYPE_SALE_PRODUCT;
        unset($params['limit_page']);

        $ids = Request_Request::find('DB_Ab1_Shop_Client_Contract_Item',
            $this->_sitePageData->shopMainID, $this->_sitePageData, $this->_driverDB,
            $params, 0, true,
            array(
                'shop_client_id' => array('name'),
                'product_root_rubric_id' => array('id', 'name', 'unit'),
                'rubric_root_rubric_id' => array('id', 'name', 'unit'),
                'shop_client_contract_id' => array('number', 'from_at', 'amount'),
            )
        );

        // добавляем строчки увеличивающие баланс договора
        $shopClientContractIDs = $ids->getChildArrayInt('shop_client_contract_id', true);
        if(!empty($shopClientContractIDs)) {
            $params = Request_RequestParams::setParams(
                array(
                    'is_add_basic_contract' => true,
                    'basic_shop_client_contract_id' => $shopClientContractIDs,
                    'is_public_ignore' => true,
                    'sort_by' => array(
                        'shop_client_contract_id.from_at' => 'asc',
                    )
                )
            );
            $ids->addChilds(
                Request_Request::find('DB_Ab1_Shop_Client_Contract_Item',
                    $this->_sitePageData->shopMainID, $this->_sitePageData, $this->_driverDB,
                    $params, 0, true,
                    array(
                        'shop_client_id' => array('name'),
                        'product_root_rubric_id' => array('id', 'name', 'unit'),
                        'rubric_root_rubric_id' => array('id', 'name', 'unit'),
                        'shop_client_contract_id' => array('number', 'from_at', 'amount'),
                    )
                )
            );
        }

        $rubrics = array();
        $dataRubrics = array(
            'data' => array(),
        );
        foreach ($ids->childs as $child) {
            // группировка по базовым рубрикам
            $rootID = $child->getElementValue('product_root_rubric_id', 'id', 0);
            if($rootID < 1){
                $rootID = $child->getElementValue('rubric_root_rubric_id', 'id', 0);
            }
            if($rootID < 1){
                continue;
            }

            if (!key_exists($rootID, $dataRubrics['data'])) {
                if ($child->getElementValue('product_root_rubric_id', 'id', 0) > 0) {
                    $rootName = $child->getElementValue('product_root_rubric_id');
                    $rootUnit = $child->getElementValue('product_root_rubric_id', 'unit');
                } else {
                    $rootName = $child->getElementValue('rubric_root_rubric_id');
                    $rootUnit = $child->getElementValue('rubric_root_rubric_id', 'unit');
                }

                $dataRubrics['data'][$rootID] = array(
                    'id' => $rootID,
                    'name' => $rootName,
                    'unit' => $rootUnit,
                    'quantity' => 0,
                );
                $rubrics[$rootID] = array(
                    'quantity' => 0,
                );
            }
        }
        uasort($dataRubrics['data'], array($this, 'mySortMethod'));

        $dataContracts = array(
            'data' => array(),
            'amount' => 0,
        );
        foreach ($ids->childs as $child) {
            // группировка по договорам
            $contract = $child->values['shop_client_contract_id'];
            if(!key_exists($contract, $dataContracts['data'])){
                $amount = $child->getElementValue('shop_client_contract_id', 'amount');

                $dataContracts['data'][$contract] = array(
                    'client' => $child->getElementValue('shop_client_id'),
                    'number' => $child->getElementValue('shop_client_contract_id', 'number'),
                    'from_at' => $child->getElementValue('shop_client_contract_id', 'from_at'),
                    'amount' => $amount,
                    'data' => $rubrics,
                );

                $dataContracts['amount'] += $amount;
            }

            // группировка по базовым рубрикам
            $rootID = $child->getElementValue('product_root_rubric_id', 'id', 0);
            if($rootID < 1){
                $rootID = $child->getElementValue('rubric_root_rubric_id', 'id', 0);
            }
            if($rootID < 1){
                continue;
            }

            $quantity = $child->values['quantity'];
            $dataContracts['data'][$contract]['data'][$rootID]['quantity'] += $quantity;
            $dataRubrics['data'][$rootID]['quantity'] += $quantity;
        }

        $viewObject = 'ab1/_report/'.$this->_sitePageData->languageID.'/contract/product';
        $tmp = str_replace('\\', '/', $viewObject);
        try {
            $view = View::factory($tmp);
        }catch (Exception $e) {
            throw new Exception('Шаблон "'.$tmp.'" не найден.');
        }

        $view->contracts = $dataContracts;
        $view->rubrics = $dataRubrics;
        $view->year = $year;
        $view->operation = $this->_sitePageData->operation->getValues();
        $view->shop = $this->_sitePageData->shop->getName();
        $view->shopOptions = $this->_sitePageData->shop->getOptionsArray();
        $strView = Helpers_View::viewToStr($view);

        header('Content-Type: application/x-download;charset=UTF-8');
        // header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: filename="ПР06 Реестр договоров по потребителям продукции на ' . $year .'.xml"');
        header('Cache-Control: max-age=0');

        echo $strView;
        exit();
    }

    /**
     * Реестр договоров
     * @throws Exception
     */
    public function action_contract_list() {
        set_time_limit(36000);

        $this->_sitePageData->url = '/'.$this->actionURLName.'/shopreport/contract_list';

        $params = Request_RequestParams::setParams(
            array_merge($_POST, $_GET)
        );
        $params['is_basic'] = true;
        unset($params['limit_page']);

        $ids = Request_Request::find('DB_Ab1_Shop_Client_Contract',
            $this->_sitePageData->shopMainID, $this->_sitePageData, $this->_driverDB,
            $params, 0, true,
            array(
                'shop_client_id' => array('name', 'bin', 'organization_type_id'),
                'client_contract_type_id' => array('name'),
                'client_contract_status_id' => array('name'),
                'executor_shop_worker_id' => array('name'),
                'currency_id' => array('symbol'),
                'shop_client_contract_storage_id' => array('name'),
            )
        );

        $organizationTypeIDs = Request_Request::findAllNotShop('DB_OrganizationType', $this->_sitePageData, $this->_driverDB, true);
        $organizationTypeIDs->runIndex();

        $dataContracts = array(
            'data' => array(),
            'amount' => 0,
        );
        foreach ($ids->childs as $child) {
            $amount = $child->values['amount'];

            $dataContracts['data'][] = array(
                'number' => $child->values['number'],
                'created_at' => $child->values['created_at'],
                'client' => $child->getElementValue('shop_client_id'),
                'organization_type' => $organizationTypeIDs->findChildResultValue($child->getElementValue('shop_client_id', 'organization_type_id'), 'name', '', true),
                'client_bin' => $child->getElementValue('shop_client_id', 'bin'),
                'subject' => $child->values['subject'],
                'amount' => $amount,
                'currency' => $child->getElementValue('currency_id', 'symbol'),
                'from_at' => $child->values['from_at'],
                'to_at' => $child->values['to_at'],
                'is_basic' => $child->values['is_basic'],
                'client_contract_type' => $child->getElementValue('client_contract_type_id'),
                'client_contract_status' => $child->getElementValue('client_contract_status_id'),
                'is_prolongation' => $child->values['is_prolongation'],
                'worker' => $child->getElementValue('executor_shop_worker_id'),
                'is_redaction_client' => $child->values['is_redaction_client'],
                'text' => $child->values['text'],
                'storage' => $child->getElementValue('shop_client_contract_storage_id'),
                'is_perpetual' => $child->values['is_perpetual'],
            );

            $dataContracts['amount'] += $amount;
        }

        $viewObject = 'ab1/_report/'.$this->_sitePageData->languageID.'/contract/list';
        $tmp = str_replace('\\', '/', $viewObject);
        try {
            $view = View::factory($tmp);
        }catch (Exception $e) {
            throw new Exception('Шаблон "'.$tmp.'" не найден.');
        }

        $view->contracts = $dataContracts;
        $view->operation = $this->_sitePageData->operation->getValues();
        $view->shop = $this->_sitePageData->shop->getName();
        $view->shopOptions = $this->_sitePageData->shop->getOptionsArray();
        $strView = Helpers_View::viewToStr($view);

        header('Content-Type: application/x-download;charset=UTF-8');
        // header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: filename="Реестр договоров на ' . date('d.m.Y') .'.xml"');
        header('Cache-Control: max-age=0');

        echo $strView;
        exit();
    }

    /**
     * Бригадный наряд
     * @throws Exception
     */

    public function action_car_salary_asu() {
        set_time_limit(36000);

        $this->_sitePageData->url = '/'.$this->actionURLName.'/shopreport/car_salary_asu';

        $shopTurnPlaceID = Request_RequestParams::getParamInt('shop_turn_place_id');

        $model = new Model_Ab1_Shop_Turn_Place();
        $model->setDBDriver($this->_driverDB);
        if(!Helpers_DB::getDBObject($model, $shopTurnPlaceID, $this->_sitePageData)){
            throw new HTTP_Exception_500('Turn place "' . $shopTurnPlaceID . '" not is found.');
        }

        // задаем время выборки
        $dateFrom = Request_RequestParams::getParamDateTime('date_from');
        $dateTo = Request_RequestParams::getParamDateTime('date_to');

        $params = array(
            'shop_turn_place_id' => $shopTurnPlaceID,
            'sum_quantity' => true,
            'group_by' => array(
                'shop_product_id', 'shop_product_id.name', 'shop_product_id.unit',
            ),
            'sort_by' => array(
                'shop_product_id.name' => 'asc',
            ),
        );
        $ids = Api_Ab1_Shop_Car::getExitShopCar(
            $dateFrom, $dateTo, $this->_sitePageData, $this->_driverDB,
            array('shop_product_id' => array('name', 'unit')),
            $params, false, null
        );

        $shopMoveCarIDs = Api_Ab1_Shop_Move_Car::getExitShopMoveCar(
            $dateFrom, $dateTo, $this->_sitePageData, $this->_driverDB,
            array('shop_product_id' => array('name', 'unit')),
            $params, false
        );
        $ids->addChilds($shopMoveCarIDs);

        $shopDefectCarIDs = Api_Ab1_Shop_Defect_Car::getExitShopDefectCar(
            $dateFrom, $dateTo, $this->_sitePageData, $this->_driverDB,
            array('shop_product_id' => array('name', 'unit')),
            $params, false, null
        );
        $ids->addChilds($shopDefectCarIDs);

        $params = Request_RequestParams::setParams(
            array(
                'shop_turn_place_id' => $shopTurnPlaceID,
                'weighted_at_from' => $dateFrom,
                'weighted_at_to' => $dateTo,
                'sum_quantity' => true,
                'group_by' => array(
                    'shop_product_id', 'shop_product_id.name', 'shop_product_id.unit',
                ),
                'sort_by' => array(
                    'shop_product_id.name' => 'asc',
                ),
            )
        );
        $shopProductStorageIDs = Request_Request::find(
            'DB_Ab1_Shop_Product_Storage', $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB,
            $params, 0, TRUE,
            array('shop_product_id' => array('name', 'unit'))
        );
        $ids->addChilds($shopProductStorageIDs);

        $params = array(
            'from_at_to' => $dateFrom,
            'to_at_from' => $dateFrom,
        );
        $shopProductTurnPlaceItemIDs = Request_Request::find('DB_Ab1_Shop_Product_TurnPlace_Item',
            $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB, $params, 0, true
        );
        $shopProductTurnPlaceItemIDs->runIndex(true, 'shop_product_id');

        $dataProducts = array(
            'data' => array(),
            'quantity' => 0,
            'amount' => 0,
        );
        foreach ($ids->childs as $child) {
            $quantity = $child->values['quantity'];
            $product = $child->values['shop_product_id'];

            if(!key_exists($product, $dataProducts['data'])){
                $dataProducts['data'][$product] = array(
                    'name' => $child->getElementValue('shop_product_id'),
                    'unit' => $child->getElementValue('shop_product_id', 'unit'),
                    'quantity' => 0,
                    'price' => 0,
                    'norm' => 0,
                    'amount' => 0,
                );

                if(key_exists($product, $shopProductTurnPlaceItemIDs->childs)){
                    $dataProducts['data'][$product]['norm'] = $shopProductTurnPlaceItemIDs->childs[$product]->values['norm'];
                    $dataProducts['data'][$product]['price'] = $shopProductTurnPlaceItemIDs->childs[$product]->values['price'];
                }
            }
            $dataProducts['data'][$product]['quantity'] += $quantity;
            $dataProducts['data'][$product]['amount'] += $quantity * $dataProducts['data'][$product]['price'];

            $dataProducts['quantity'] += $quantity;
            $dataProducts['amount'] += $quantity * $dataProducts['data'][$product]['price'];
        }

        $viewObject = 'ab1/_report/'.$this->_sitePageData->languageID.'/car/salary-asu';
        $tmp = str_replace('\\', '/', $viewObject);
        try {
            $view = View::factory($tmp);
        }catch (Exception $e) {
            throw new Exception('Шаблон "'.$tmp.'" не найден.');
        }

        $view->products = $dataProducts;
        $view->dateFrom = $dateFrom;
        $view->dateTo = Helpers_DateTime::minusDays($dateTo, 1);
        $view->turnPlace = $model->getName();
        $view->operation = $this->_sitePageData->operation->getValues();
        $view->shop = $this->_sitePageData->shop->getName();
        $view->shopOptions = $this->_sitePageData->shop->getOptionsArray();
        $strView = Helpers_View::viewToStr($view);

        header('Content-Type: application/x-download;charset=UTF-8');
        // header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: filename="АБ05 АБЦ бригадный наряд '. str_replace('#', '', $model->getName()) .' за период ' . Helpers_DateTime::getPeriodRus($dateFrom, $dateTo) .'_.xml"');
        header('Cache-Control: max-age=0');

        echo $strView;
        exit();
    }

    /**
     * Бригадный наряд в выходные и праздничные дни
     * @throws Exception
     */
    public function action_car_salary_asu_holiday() {
        set_time_limit(36000);

        $this->_sitePageData->url = '/'.$this->actionURLName.'/shopreport/car_salary_asu';

        $shopTurnPlaceID = Request_RequestParams::getParamInt('shop_turn_place_id');

        $model = new Model_Ab1_Shop_Turn_Place();
        $model->setDBDriver($this->_driverDB);
        if(!Helpers_DB::getDBObject($model, $shopTurnPlaceID, $this->_sitePageData)){
            throw new HTTP_Exception_500('Turn place "' . $shopTurnPlaceID . '" not is found.');
        }

        // задаем время выборки
        $dateFrom = Request_RequestParams::getParamDateTime('date_from');
        $dateTo = Request_RequestParams::getParamDateTime('date_to');

        // праздничные и выходные дни
        $params = Request_RequestParams::setParams(
            array(
                'day_from_equally' => $dateFrom,
                'day_to' => Helpers_DateTime::minusDays($dateTo, 1),
                'sort_by' => array(
                    'day' => 'asc'
                )
            )
        );
        $holidayIDs = Request_Request::findNotShop(
            'DB_Ab1_Holiday', $this->_sitePageData, $this->_driverDB,
            $params, 0, TRUE
        );
        $holidayIDs->runIndex(true, 'day');

        $params = array(
            'shop_turn_place_id' => $shopTurnPlaceID,
            'sort_by' => array(
                'shop_product_id.name' => 'asc',
            ),
        );
        $ids = Api_Ab1_Shop_Car::getExitShopCar(
            $dateFrom, $dateTo, $this->_sitePageData, $this->_driverDB,
            array('shop_product_id' => array('name', 'unit')),
            $params, false, null
        );

        $shopMoveCarIDs = Api_Ab1_Shop_Move_Car::getExitShopMoveCar(
            $dateFrom, $dateTo, $this->_sitePageData, $this->_driverDB,
            array('shop_product_id' => array('name', 'unit')),
            $params, false, null
        );
        $ids->addChilds($shopMoveCarIDs);

        $shopDefectCarIDs = Api_Ab1_Shop_Defect_Car::getExitShopDefectCar(
            $dateFrom, $dateTo, $this->_sitePageData, $this->_driverDB,
            array('shop_product_id' => array('name', 'unit')),
            $params, false, null
        );
        $ids->addChilds($shopDefectCarIDs);

        $params = Request_RequestParams::setParams(
            array(
                'shop_turn_place_id' => $shopTurnPlaceID,
                'weighted_at_from' => $dateFrom,
                'weighted_at_to' => $dateTo,
                'sort_by' => array(
                    'shop_product_id.name' => 'asc',
                ),
            )
        );
        $shopProductStorageIDs = Request_Request::find(
            'DB_Ab1_Shop_Product_Storage', $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB,
            $params, 0, TRUE,
            array('shop_product_id' => array('name', 'unit'))
        );
        $ids->addChilds($shopProductStorageIDs);

        $params = array(
            'from_at_to' => $dateFrom,
            'to_at_from' => $dateFrom,
        );
        $shopProductTurnPlaceItemIDs = Request_Request::find('DB_Ab1_Shop_Product_TurnPlace_Item',
            $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB, $params, 0, true
        );
        $shopProductTurnPlaceItemIDs->runIndex(true, 'shop_product_id');

        $holidays = array();
        $dataProducts = array(
            'data' => array(),
            'quantity' => 0,
            'amount' => 0,
        );
        foreach ($ids->childs as $child) {
            if(key_exists('exit_at', $child->values)){
                $day = $child->values['exit_at'];
            }else {
                $day = $child->values['weighted_at'];
            }

            if(strtotime($day) <= strtotime(Helpers_DateTime::getDateFormatPHP($day) . ' 06:00:00')){
                $day = Helpers_DateTime::getDateFormatPHP(Helpers_DateTime::minusDays($day, 1));
            }else{
                $day = Helpers_DateTime::getDateFormatPHP($day);
            }

            if(!key_exists($day, $holidayIDs->childs)){
                continue;
            }

            $quantity = $child->values['quantity'];

            $product = $child->values['shop_product_id'];
            if(!key_exists($product, $dataProducts['data'])){
                $dataProduct = array(
                    'name' => $child->getElementValue('shop_product_id'),
                    'unit' => $child->getElementValue('shop_product_id', 'unit'),
                    'quantity' => 0,
                    'price' => 0,
                    'norm' => 0,
                    'amount' => 0,
                );

                if (key_exists($product, $shopProductTurnPlaceItemIDs->childs)) {
                    $dataProduct['norm'] = $shopProductTurnPlaceItemIDs->childs[$product]->values['norm'];
                    $dataProduct['price'] = $shopProductTurnPlaceItemIDs->childs[$product]->values['price'];
                    $dataProduct['amount'] = $dataProduct['quantity'] * $dataProduct['price'];
                }

                $dataProducts['data'][$product] = $dataProduct;
            }

            $dataProducts['data'][$product]['quantity'] += $quantity;
            $dataProducts['quantity'] += $quantity;

            if (key_exists($product, $shopProductTurnPlaceItemIDs->childs)) {
                $dataProducts['data'][$product]['amount'] += $quantity * $shopProductTurnPlaceItemIDs->childs[$product]->values['price'];
                $dataProducts['amount'] += $quantity * $shopProductTurnPlaceItemIDs->childs[$product]->values['price'];
            }

            $holidays[$day] = $day;
        }
        sort($holidays);

        // собираем строку выходных и праздничных дней
        $list = array();
        foreach ($holidays as $day){
            $list[Helpers_DateTime::getYear($day)][Helpers_DateTime::getMonth($day)][Helpers_DateTime::getDay($day)] = $day;
        }

        $holidays = '';
        foreach ($list as $year => $listMonth) {
            foreach ($listMonth as $month => $listDay) {
                foreach ($listDay as $day => $date) {
                    $holidays .= $day . ', ';
                }

                $holidays = mb_substr($holidays, 0, -2). ' ' . Helpers_DateTime::getMonthRusStr($month) . ', ';
            }
            $holidays = mb_substr($holidays, 0, -2). ' ' . $year . ' г., ';
        }
        $holidays = mb_substr($holidays, 0, -2);

        $viewObject = 'ab1/_report/'.$this->_sitePageData->languageID.'/car/salary-asu-holiday';
        $tmp = str_replace('\\', '/', $viewObject);
        try {
            $view = View::factory($tmp);
        }catch (Exception $e) {
            throw new Exception('Шаблон "'.$tmp.'" не найден.');
        }

        $view->products = $dataProducts;
        $view->dateFrom = $dateFrom;
        $view->dateTo = Helpers_DateTime::minusDays($dateTo, 1);
        $view->turnPlace = $model->getName();
        $view->holidays = $holidays;
        $view->operation = $this->_sitePageData->operation->getValues();
        $view->shop = $this->_sitePageData->shop->getName();
        $view->shopOptions = $this->_sitePageData->shop->getOptionsArray();
        $strView = Helpers_View::viewToStr($view);

        header('Content-Type: application/x-download;charset=UTF-8');
        // header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: filename="АБ06 АБЦ бригадный наряд за выходные и праздничные дни '. str_replace('#', '', $model->getName()) .' за период ' . Helpers_DateTime::getPeriodRus($dateFrom, $dateTo) .'_.xml"');
        header('Cache-Control: max-age=0');

        echo $strView;
        exit();
    }

    /**
     * Общий реестр по выгрузке цемента
     * @throws Exception
     */
    public function action_boxcar_cement_list() {
        set_time_limit(36000);

        $this->_sitePageData->url = '/'.$this->actionURLName.'/shopreport/boxcar_cement_list';

        $shopRawID = Request_RequestParams::getParamInt('shop_raw_id');

        $model = new Model_Ab1_Shop_Raw();
        $model->setDBDriver($this->_driverDB);
        if(!Helpers_DB::getDBObject($model, $shopRawID, $this->_sitePageData)){
            throw new HTTP_Exception_500('Raw "' . $shopRawID . '" not is found.');
        }

        // задаем время выборки
        $dateFrom = Request_RequestParams::getParamDate('date_from');
        $dateTo = Request_RequestParams::getParamDate('date_to');

        $params = array(
            'date_drain_to_from_equally' => $dateFrom,
            'date_drain_to_to' => $dateTo,
            'shop_raw_id' => $shopRawID,
            'sort_by' => array(
                'created_at' => 'asc',
            ),
        );
        $ids = Request_Request::find('DB_Ab1_Shop_Boxcar',
            $this->_sitePageData->shopMainID, $this->_sitePageData, $this->_driverDB,
            $params, 0, TRUE,
            array(
                'shop_boxcar_client_id' => array('name'),
            )
        );

        $dataBoxcars = array(
            'data' => array(),
            'quantity' => 0,
        );
        foreach ($ids->childs as $child) {
            $quantity = $child->values['quantity'];

            $dataBoxcars['data'][] = array(
                'date_arrival' => $child->values['date_arrival'],
                'number' => $child->values['number'],
                'boxcar_client' => $child->getElementValue('shop_boxcar_client_id'),
                'quantity' => $quantity,
            );

            $dataBoxcars['quantity'] += $quantity;
        }

        $viewObject = 'ab1/_report/'.$this->_sitePageData->languageID.'/boxcar/cement-list';
        $tmp = str_replace('\\', '/', $viewObject);
        try {
            $view = View::factory($tmp);
        }catch (Exception $e) {
            throw new Exception('Шаблон "'.$tmp.'" не найден.');
        }

        $view->boxcars = $dataBoxcars;
        $view->dateFrom = $dateFrom;
        $view->dateTo = $dateTo;
        $view->raw = $model->getName();
        $view->operation = $this->_sitePageData->operation->getValues();
        $view->shop = $this->_sitePageData->shop->getName();
        $view->shopOptions = $this->_sitePageData->shop->getOptionsArray();
        $strView = Helpers_View::viewToStr($view);

        header('Content-Type: application/x-download;charset=UTF-8');
        // header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: filename="ВГ08 Общий реестр по выгрузке '. Func::getStringCaseRus($model->getName(), 1) .' за период ' . Helpers_DateTime::getPeriodRus($dateFrom, $dateTo) .'.xml"');
        header('Cache-Control: max-age=0');

        echo $strView;
        exit();
    }

    /**
     * Прайс лист ЖБИ
     * @throws HTTP_Exception_404
     * @throws HTTP_Exception_500
     */
    public function action_price_list_zhbi_other() {
        $this->_sitePageData->url = '/'.$this->actionURLName.'/shopreport/price_list_zhbi_other';

        $filePath = APPPATH.'views' . DIRECTORY_SEPARATOR . 'ab1' . DIRECTORY_SEPARATOR . '_report' . DIRECTORY_SEPARATOR
            . $this->_sitePageData->dataLanguageID . DIRECTORY_SEPARATOR . '_xls' . DIRECTORY_SEPARATOR
            . 'price-list' . DIRECTORY_SEPARATOR . 'zhbi' . DIRECTORY_SEPARATOR . 'other.xls';
        if(!file_exists($filePath)){
            throw new HTTP_Exception_500('File template "' . $filePath . '" not is found.');
        }

        $shopProductPricelistRubricID = Request_RequestParams::getParamInt('not_shop_product_pricelist_rubric_id');
        if(empty($shopProductPricelistRubricID)){
            $shopProductPricelistRubricID = Request_RequestParams::getParamInt('_not_shop_product_pricelist_rubric_id');
        }

        $shopProductRubricID = Request_RequestParams::getParamInt('shop_product_rubric_id');
        if(empty($shopProductRubricID)){
            $shopProductRubricID = Request_RequestParams::getParamInt('main_shop_product_rubric_id');
        }
        $model = new Model_Ab1_Shop_Product_Rubric();
        if (!$this->getDBObject($model, $shopProductRubricID, $this->_sitePageData->shopMainID)) {
            throw new HTTP_Exception_404('Product rubric not is found!');
        }

        $date = Request_RequestParams::getParamDate('date');

        $data = Api_Ab1_Shop_Product::getPriceListZhbiOther(
            $shopProductRubricID, $date, $this->_sitePageData, $this->_driverDB, $shopProductPricelistRubricID
        );

        $data = array(
            'price_list' => $data['price_list'],
            'operation' => array('name' => $this->_sitePageData->operation->getName()),
            'deliveries' => $data['deliveries'],
            'products' => $data['products'],
        );

        $list = array(
            'deliveries' => $data['deliveries'],
        );

        $i = 1;
        foreach ($data['products'] as $rubric){
            $data['product_rubric'.$i] = array('name' => $rubric['name']);
            $list['products'.$i] = $rubric['data'];
            $i++;
        }

        Helpers_Excel::saleInFile($filePath,
            $data,
            $list,
            'php://output',
            Helpers_DateTime::getYear($date).'-'.$model->getName().'.xlsx'
        );

        exit();
    }

    /**
     * Прайс лист ЖБИ Плиты перекрытия
     * @throws HTTP_Exception_404
     * @throws HTTP_Exception_500
     */
    public function action_price_list_zhbi_floor_slabs(){
        $this->_sitePageData->url = '/'.$this->actionURLName.'/shopreport/price_list_zhbi_floor_slabs';

        $filePath = APPPATH.'views' . DIRECTORY_SEPARATOR . 'ab1' . DIRECTORY_SEPARATOR . '_report' . DIRECTORY_SEPARATOR
            . $this->_sitePageData->dataLanguageID . DIRECTORY_SEPARATOR . '_xls' . DIRECTORY_SEPARATOR
            . 'price-list' . DIRECTORY_SEPARATOR . 'zhbi' . DIRECTORY_SEPARATOR . 'floor-slabs.xls';
        if(!file_exists($filePath)){
            throw new HTTP_Exception_500('File template "' . $filePath . '" not is found.');
        }

        $shopProductRubricID = Request_RequestParams::getParamInt('shop_product_rubric_id');
        if(empty($shopProductRubricID)){
            $shopProductRubricID = Request_RequestParams::getParamInt('main_shop_product_rubric_id');
        }
        $model = new Model_Ab1_Shop_Product_Rubric();
        if (!$this->getDBObject($model, $shopProductRubricID, $this->_sitePageData->shopMainID)) {
            throw new HTTP_Exception_404('Product rubric not is found!');
        }
        $shopProductIDs = Api_Ab1_Shop_Product::findAllByMainRubric(
            $shopProductRubricID, $this->_sitePageData, $this->_driverDB
        );

        $shopProductPricelistRubricID = Request_RequestParams::getParamInt('shop_product_pricelist_rubric_id');
        $modelPricelistRubric = new Model_Ab1_Shop_Product_Pricelist_Rubric();
        if (!$this->getDBObject($modelPricelistRubric, $shopProductPricelistRubricID, $this->_sitePageData->shopMainID)) {
            throw new HTTP_Exception_404('Product pricelist rubric not is found!');
        }

        $date = Request_RequestParams::getParamDate('date');
        if(empty($date)){
            $date = date('Y-m-d');
        }

        $params = Request_RequestParams::setParams(
            array(
                'shop_product_id' => $shopProductIDs,
                'from_at_to' => $date,
                'to_at_from_equally' => $date,
                'price_from' => 0,
            )
        );
        $ids = Request_Request::findBranch('DB_Ab1_Shop_Product_Time_Price',
            array(), $this->_sitePageData, $this->_driverDB, $params, 0, true,
            array(
                'shop_product_id' => array(
                    'name_site', 'is_public', 'shop_product_pricelist_rubric_id', 'options', 'is_pricelist', 'order'
                )
            )
        );

        $dateStart = null;
        $products = array();
        foreach($ids->childs as $child){
            if($child->getElementValue('shop_product_id', 'is_public') != 1
                || $child->getElementValue('shop_product_id', 'is_pricelist') != 1
                || $child->getElementValue('shop_product_id', 'shop_product_pricelist_rubric_id') != $shopProductPricelistRubricID){
                continue;
            }

            $order = $child->getElementValue('shop_product_id', 'order');

            $productName = $child->getElementValue('shop_product_id', 'name_site');
            if(!key_exists($productName, $products)){
                $product = array(
                    'name' => $productName,
                    'price' => '',
                    'options' => json_decode($child->getElementValue('shop_product_id', 'options'), true),
                    'order' => $order,
                );

                $products[$productName] = $product;
            }elseif($order > $products[$productName]['order']){
                $products[$productName]['order'] = $order;
            }

            $products[$productName]['price'] = Func::getNumberStr($child->values['price'], true, 2, true);

            $fromAt = strtotime($child->values['from_at']);
            if($dateStart == null || $dateStart < $fromAt){
                $dateStart = $fromAt;
            }
        }

        uasort($products, array($this, 'mySortOrderMethod'));

        $priceList = array(
            'date' => Helpers_DateTime::getDateTimeDayMonthRus(date('Y-m-d', $dateStart), true),
        );

        Helpers_Excel::saleInFile($filePath,
            array(
                'price_list' => $priceList,
                'operation' => array('name' => $this->_sitePageData->operation->getName())
            ),
            array(
                'products' => $products,
            ),
            'php://output',
            Helpers_DateTime::getYear($date) . '-' . $model->getName() . ' (' . $modelPricelistRubric->getName() . ').xlsx'
        );

        exit();
    }

    /**
     * Прайс лист Бетон
     * @throws HTTP_Exception_404
     * @throws HTTP_Exception_500
     */
    public function action_price_list_concrete() {
        $this->_sitePageData->url = '/'.$this->actionURLName.'/shopreport/price_list_concrete';

        $filePath = APPPATH.'views' . DIRECTORY_SEPARATOR . 'ab1' . DIRECTORY_SEPARATOR . '_report' . DIRECTORY_SEPARATOR
            . $this->_sitePageData->dataLanguageID . DIRECTORY_SEPARATOR . '_xls' . DIRECTORY_SEPARATOR
            . 'price-list' . DIRECTORY_SEPARATOR . 'concrete.xlsx';
        if(!file_exists($filePath)){
            throw new HTTP_Exception_500('File template "' . $filePath . '" not is found.');
        }

        $shopProductRubricID = Request_RequestParams::getParamInt('shop_product_rubric_id');
        if(empty($shopProductRubricID)){
            $shopProductRubricID = Request_RequestParams::getParamInt('main_shop_product_rubric_id');
        }
        $model = new Model_Ab1_Shop_Product_Rubric();
        if (!$this->getDBObject($model, $shopProductRubricID, $this->_sitePageData->shopMainID)) {
            throw new HTTP_Exception_404('Product rubric not is found!');
        }

        $date = Request_RequestParams::getParamDate('date');

        $data = Api_Ab1_Shop_Product::getPriceListConcrete(
            $shopProductRubricID, $date, $this->_sitePageData, $this->_driverDB
        );

        $list = array(
            'deliveries' => $data['deliveries'],
        );
        $data = array(
            'price_list' => $data['price_list'],
            'operation' => array('name' => $this->_sitePageData->operation->getName()),
            'products' => $data['products'],
        );

        $i = 1;
        foreach ($data['products'] as $rubric){
            $data['product_rubric'.$i] = array('name' => $rubric['name']);
            $list['products'.$i] = $rubric['data'];
            $i++;
        }

        Helpers_Spreadsheet::saleInFile($filePath,
            $data,
            $list,
            'php://output',
            Helpers_DateTime::getYear($date).'-'.$model->getName().'.xlsx',
            false
        );
        exit();

        Helpers_Excel::saleInFile($filePath,
            $data,
            $list,
            'php://output',
            Helpers_DateTime::getYear($date).'-'.$model->getName().'.xlsx',
            false
        );

        exit();
    }

    /**
     * Прайс лист Нефтебитум
     * @throws HTTP_Exception_404
     * @throws HTTP_Exception_500
     */
    public function action_price_list_bitumen_branch() {
        $this->_sitePageData->url = '/'.$this->actionURLName.'/shopreport/price_list_bitumen_branch';

        $filePath = APPPATH.'views' . DIRECTORY_SEPARATOR . 'ab1' . DIRECTORY_SEPARATOR . '_report' . DIRECTORY_SEPARATOR
            . $this->_sitePageData->dataLanguageID . DIRECTORY_SEPARATOR . '_xls' . DIRECTORY_SEPARATOR
            . 'price-list' . DIRECTORY_SEPARATOR . 'bitumen-branch.xlsx';
        if(!file_exists($filePath)){
            throw new HTTP_Exception_500('File template "' . $filePath . '" not is found.');
        }

        $shopProductRubricID = Request_RequestParams::getParamInt('shop_product_rubric_id');
        if(empty($shopProductRubricID)){
            $shopProductRubricID = Request_RequestParams::getParamInt('main_shop_product_rubric_id');
        }
        $model = new Model_Ab1_Shop_Product_Rubric();
        if (!$this->getDBObject($model, $shopProductRubricID, $this->_sitePageData->shopMainID)) {
            throw new HTTP_Exception_404('Product rubric not is found!');
        }

        $date = Request_RequestParams::getParamDate('date');

        $result = Api_Ab1_Shop_Product::getPriceListBitumenBranch(
            $shopProductRubricID, $date, $this->_sitePageData, $this->_driverDB
        );

        Helpers_Spreadsheet::saleInFile($filePath,
            array(
                'price_list' => $result['price_list'],
                'operation' => array('name' => $this->_sitePageData->operation->getName())
            ),
            array(
                'products' => $result['products'],
                'deliveries' => $result['deliveries'],
            ),
            'php://output',
            Helpers_DateTime::getYear($date).'-'.$model->getName().'.xlsx'
        );

        exit();
    }


    /**
     * Прайс лист Нефтебитум
     * @throws HTTP_Exception_404
     * @throws HTTP_Exception_500
     */
    public function action_price_list_bitumen() {
        $this->_sitePageData->url = '/'.$this->actionURLName.'/shopreport/price_list_bitumen';

        $filePath = APPPATH.'views' . DIRECTORY_SEPARATOR . 'ab1' . DIRECTORY_SEPARATOR . '_report' . DIRECTORY_SEPARATOR
            . $this->_sitePageData->dataLanguageID . DIRECTORY_SEPARATOR . '_xls' . DIRECTORY_SEPARATOR
            . 'price-list' . DIRECTORY_SEPARATOR . 'bitumen.xlsx';
        if(!file_exists($filePath)){
            throw new HTTP_Exception_500('File template "' . $filePath . '" not is found.');
        }

        $shopProductRubricID = Request_RequestParams::getParamInt('shop_product_rubric_id');
        if(empty($shopProductRubricID)){
            $shopProductRubricID = Request_RequestParams::getParamInt('main_shop_product_rubric_id');
        }
        $model = new Model_Ab1_Shop_Product_Rubric();
        if (!$this->getDBObject($model, $shopProductRubricID, $this->_sitePageData->shopMainID)) {
            throw new HTTP_Exception_404('Product rubric not is found!');
        }

        $date = Request_RequestParams::getParamDate('date');

        $result = Api_Ab1_Shop_Product::getPriceListBitumen(
            $shopProductRubricID, $date, $this->_sitePageData, $this->_driverDB
        );

        Helpers_Spreadsheet::saleInFile($filePath,
            array(
                'price_list' => $result['price_list'],
                'operation' => array('name' => $this->_sitePageData->operation->getName())
            ),
            array(
                'products' => $result['products'],
                'deliveries' => $result['deliveries'],
            ),
            'php://output',
            Helpers_DateTime::getYear($date).'-'.$model->getName().'.xlsx'
        );

        exit();
    }

    /**
     * Прайс лист Каменных материалов
     * @throws HTTP_Exception_404
     * @throws HTTP_Exception_500
     */
    public function action_price_list_stone_material() {
        $this->_sitePageData->url = '/'.$this->actionURLName.'/shopreport/price_list_stone_material';

        $filePath = APPPATH.'views' . DIRECTORY_SEPARATOR . 'ab1' . DIRECTORY_SEPARATOR . '_report' . DIRECTORY_SEPARATOR
            . $this->_sitePageData->dataLanguageID . DIRECTORY_SEPARATOR . '_xls' . DIRECTORY_SEPARATOR
            . 'price-list' . DIRECTORY_SEPARATOR . 'stone-material.xls';
        if(!file_exists($filePath)){
            throw new HTTP_Exception_500('File template "' . $filePath . '" not is found.');
        }

        $shopProductRubricID = Request_RequestParams::getParamInt('shop_product_rubric_id');
        if(empty($shopProductRubricID)){
            $shopProductRubricID = Request_RequestParams::getParamInt('main_shop_product_rubric_id');
        }
        $model = new Model_Ab1_Shop_Product_Rubric();
        if (!$this->getDBObject($model, $shopProductRubricID, $this->_sitePageData->shopMainID)) {
            throw new HTTP_Exception_404('Product rubric not is found!');
        }

        $date = Request_RequestParams::getParamDate('date');

        $result = Api_Ab1_Shop_Product::getPriceListStoneMaterial(
            $shopProductRubricID, $date, $this->_sitePageData, $this->_driverDB
        );

        Helpers_Excel::saleInFile($filePath,
            array(
                'price_list' => $result['price_list'],
                'operation' => array('name' => $this->_sitePageData->operation->getName())
            ),
            array(
                'products' => $result['products'],
            ),
            'php://output',
            Helpers_DateTime::getYear($date).'-'.$model->getName().'.xlsx'
        );

        exit();
    }

    /**
     * Прайс лист Асфальтобетон
     * @throws HTTP_Exception_404
     * @throws HTTP_Exception_500
     */
    public function action_price_list_asphalt() {
        $this->_sitePageData->url = '/'.$this->actionURLName.'/shopreport/price_list_asphalt';

        $filePath = APPPATH.'views' . DIRECTORY_SEPARATOR . 'ab1' . DIRECTORY_SEPARATOR . '_report' . DIRECTORY_SEPARATOR
            . $this->_sitePageData->dataLanguageID . DIRECTORY_SEPARATOR . '_xls' . DIRECTORY_SEPARATOR
            . 'price-list' . DIRECTORY_SEPARATOR . 'asphalt.xls';
        if(!file_exists($filePath)){
            throw new HTTP_Exception_500('File template "' . $filePath . '" not is found.');
        }

        $shopProductRubricID = Request_RequestParams::getParamInt('shop_product_rubric_id');
        if(empty($shopProductRubricID)){
            $shopProductRubricID = Request_RequestParams::getParamInt('main_shop_product_rubric_id');
        }
        $model = new Model_Ab1_Shop_Product_Rubric();
        if (!$this->getDBObject($model, $shopProductRubricID, $this->_sitePageData->shopMainID)) {
            throw new HTTP_Exception_404('Product rubric not is found!');
        }

        $date = Request_RequestParams::getParamDate('date');

        $result = Api_Ab1_Shop_Product::getPriceListAsphalt(
            $shopProductRubricID, $date, $this->_sitePageData, $this->_driverDB
        );

        Helpers_Excel::saleInFile($filePath,
            array(
                'price_list' => $result['price_list'],
                'operation' => array('name' => $this->_sitePageData->operation->getName())
            ),
            array(
                'products' => $result['products'],
                'deliveries' => $result['deliveries'],
            ),
            'php://output',
            Helpers_DateTime::getYear($date).'-'.$model->getName().'.xlsx',
            false
        );

        exit();
    }

    /**
     * Сохранение рецептов продуктов по шаблону Бетона
     * @throws Exception
     */
    public function action_formulaproduct_concrete() {
        set_time_limit(36000);

        $this->_sitePageData->url = '/'.$this->actionURLName.'/shopreport/formulaproduct_concrete';

        $params = Request_RequestParams::setParams(
            array(
                'sort_by' => array(
                    'id' => 'asc',
                ),
            ), false
        );
        $shopFormulaProductItemIDs = Request_Request::find('DB_Ab1_Shop_Formula_Product_Item',
            $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
            array(
                'shop_product_id' => array('unit'),
                'shop_formula_product_id' => array('name'),
                'shop_material_id' => array('name', 'unit_recipe'),
            )
        );

        $dataProducts = array(
            'data' => array(),
        );

        foreach ($shopFormulaProductItemIDs->childs as $child){
            $shopProductID = $child->values['shop_product_id'];
            if(!key_exists($shopProductID, $dataProducts['data'])) {
                $dataProducts['data'][$shopProductID] = array(
                    'name' => $child->getElementValue('shop_formula_product_id'),
                    'unit' => $child->getElementValue('shop_product_id', 'unit'),
                    'materials' => array(),

                    'norm_weight' => 0,
                    'norm_industrial' => 0,
                );
            }

            $shopMaterialID = $child->values['shop_material_id'];
            $options = json_decode($child->values['options'], true);
            $isLiter = Arr::path($options, 'is_liter', '') == 1;

            if($isLiter){
                $data = array(
                    'name' => $child->getElementValue('shop_material_id'),
                    'norm_weight_kg' => '-',
                    'norm_weight_liter' => $child->values['norm_weight'],
                    'losses' => $child->values['losses'],
                    'norm_industrial_kg' => '-',
                    'norm_industrial_liter' => Arr::path($options, 'norm_industrial', ''),
                );
            }else{
                $data = array(
                    'name' => $child->getElementValue('shop_material_id'),
                    'norm_weight_kg' => $child->values['norm_weight'],
                    'norm_weight_liter' => '-',
                    'losses' => $child->values['losses'],
                    'norm_industrial_kg' => Arr::path($options, 'norm_industrial', ''),
                    'norm_industrial_liter' => '-',
                );
            }

            $dataProducts['data'][$shopProductID]['materials'][$shopMaterialID] = $data;

            $dataProducts['data'][$shopProductID]['norm_weight'] += $child->values['norm_weight'];
            $dataProducts['data'][$shopProductID]['norm_industrial'] += floatval(Arr::path($options, 'norm_industrial', 0));
        }
        uasort($dataProducts['data'], array($this, 'mySortMethod'));


        $viewObject = 'ab1/_report/'.$this->_sitePageData->languageID.'/formula-product/concrete';
        $tmp = str_replace('\\', '/', $viewObject);
        try {
            $view = View::factory($tmp);
        }catch (Exception $e) {
            throw new Exception('Шаблон "'.$tmp.'" не найден.');
        }

        $view->products = $dataProducts;
        $view->operation = $this->_sitePageData->operation->getValues();
        $view->shop = $this->_sitePageData->shop->getName();
        $view->shopOptions = $this->_sitePageData->shop->getOptionsArray();
        $strView = Helpers_View::viewToStr($view);

        header('Content-Type: application/x-download;charset=UTF-8');
        // header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: filename="Производственные нормы расхода материалов при производстве товарного бетона.xml"');
        header('Cache-Control: max-age=0');

        echo $strView;
        exit();
    }

    /**
     * Сохранение рецептов продуктов по шаблону Эмульсии
     * @throws Exception
     */
    public function action_formulaproduct_emulsion() {
        set_time_limit(36000);

        $this->_sitePageData->url = '/'.$this->actionURLName.'/shopreport/formulaproduct_emulsion';

        $params = Request_RequestParams::setParams(
            array(
                'sort_by' => array(
                    'id' => 'asc',
                ),
            ), false
        );
        $shopFormulaProductItemIDs = Request_Request::find('DB_Ab1_Shop_Formula_Product_Item',
            $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
            array(
                'shop_product_id' => array('unit'),
                'shop_formula_product_id' => array('name'),
                'shop_material_id' => array('name', 'unit_recipe'),
            )
        );

        $dataProducts = array(
            'data' => array(),
        );

        foreach ($shopFormulaProductItemIDs->childs as $child){
            $shopProductID = $child->values['shop_product_id'];
            if(!key_exists($shopProductID, $dataProducts['data'])) {
                $dataProducts['data'][$shopProductID] = array(
                    'name' => $child->getElementValue('shop_formula_product_id'),
                    'unit' => $child->getElementValue('shop_product_id', 'unit'),
                    'materials' => array(),

                    'norm_percent' => 0,
                    'norm_weight' => 0,
                    'losses_weight' => 0,
                    'norm_industrial' => 0,
                );
            }

            $shopMaterialID = $child->values['shop_material_id'];
            $options = json_decode($child->values['options'], true);
            $dataProducts['data'][$shopProductID]['materials'][$shopMaterialID] = array(
                'name' => $child->getElementValue('shop_material_id'),
                'norm_percent' => Arr::path($options, 'norm_percent', ''),
                'norm_weight' => $child->values['norm_weight'],
                'losses' => $child->values['losses'],
                'losses_weight' => Arr::path($options, 'losses_weight', ''),
                'norm_industrial' => Arr::path($options, 'norm_industrial', ''),
            );

            $dataProducts['data'][$shopProductID]['norm_percent'] += floatval(Arr::path($options, 'norm_percent', 0));
            $dataProducts['data'][$shopProductID]['norm_weight'] += $child->values['norm_weight'];
            $dataProducts['data'][$shopProductID]['losses_weight'] += floatval(Arr::path($options, 'losses_weight', 0));
            $dataProducts['data'][$shopProductID]['norm_industrial'] += floatval(Arr::path($options, 'norm_industrial', 0));
        }
        uasort($dataProducts['data'], array($this, 'mySortMethod'));


        $viewObject = 'ab1/_report/'.$this->_sitePageData->languageID.'/formula-product/emulsion';
        $tmp = str_replace('\\', '/', $viewObject);
        try {
            $view = View::factory($tmp);
        }catch (Exception $e) {
            throw new Exception('Шаблон "'.$tmp.'" не найден.');
        }

        $view->products = $dataProducts;
        $view->operation = $this->_sitePageData->operation->getValues();
        $view->shop = $this->_sitePageData->shop->getName();
        $view->shopOptions = $this->_sitePageData->shop->getOptionsArray();
        $strView = Helpers_View::viewToStr($view);

        header('Content-Type: application/x-download;charset=UTF-8');
        // header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: filename="Производственные нормы расхода материалов для приготовления эмульсии.xml"');
        header('Cache-Control: max-age=0');

        echo $strView;
        exit();
    }

    /**
     * Сохранение рецептов продуктов по шаблону Асфальтобетона
     * Производственные нормы расхода материалов
     * для приготовления асфальтобетонных смесей c применением отсева дробления фракции
     * @throws Exception
     */
    public function action_formulaproduct_asphalt_bunker() {
        set_time_limit(36000);

        $this->_sitePageData->url = '/'.$this->actionURLName.'/shopreport/formulaproduct_asphalt_bunker';

        $params = Request_RequestParams::setParams(
            array(
                'sort_by' => array(
                    'id' => 'asc',
                ),
            ), false
        );
        $shopFormulaProductItemIDs = Request_Request::find('DB_Ab1_Shop_Formula_Product_Item',
            $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
            array(
                'shop_product_id' => array('unit'),
                'shop_formula_product_id' => array('name'),
                'shop_material_id' => array('name', 'unit_recipe'),
            )
        );

        $dataProducts = array(
            'data' => array(),
        );

        foreach ($shopFormulaProductItemIDs->childs as $child){
            $shopProductID = $child->values['shop_product_id'];
            if(!key_exists($shopProductID, $dataProducts['data'])) {
                $dataProducts['data'][$shopProductID] = array(
                    'name' => $child->getElementValue('shop_formula_product_id'),
                    'unit' => $child->getElementValue('shop_product_id', 'unit'),
                    'materials' => array(),

                    'norm_bunker' => 0,
                    'norm_percent' => 0,
                    'norm_weight' => 0,
                    'losses_weight' => 0,
                    'norm_industrial' => 0,
                );
            }

            $shopMaterialID = $child->values['shop_material_id'];
            $options = json_decode($child->values['options'], true);
            $dataProducts['data'][$shopProductID]['materials'][$shopMaterialID] = array(
                'name' => $child->getElementValue('shop_material_id'),
                'norm_bunker' => Arr::path($options, 'norm_bunker', ''),
                'norm_percent' => Arr::path($options, 'norm_percent', ''),
                'norm_weight' => $child->values['norm_weight'],
                'losses' => $child->values['losses'],
                'losses_weight' => Arr::path($options, 'losses_weight', ''),
                'norm_industrial' => Arr::path($options, 'norm_industrial', ''),
            );

            $dataProducts['data'][$shopProductID]['norm_bunker'] += floatval(Arr::path($options, 'norm_bunker', 0));
            $dataProducts['data'][$shopProductID]['norm_percent'] += floatval(Arr::path($options, 'norm_percent', 0));
            $dataProducts['data'][$shopProductID]['norm_weight'] += $child->values['norm_weight'];
            $dataProducts['data'][$shopProductID]['losses_weight'] += floatval(Arr::path($options, 'losses_weight', 0));
            $dataProducts['data'][$shopProductID]['norm_industrial'] += floatval(Arr::path($options, 'norm_industrial', 0));
        }
        uasort($dataProducts['data'], array($this, 'mySortMethod'));


        $viewObject = 'ab1/_report/'.$this->_sitePageData->languageID.'/formula-product/asphalt-v2';
        $tmp = str_replace('\\', '/', $viewObject);
        try {
            $view = View::factory($tmp);
        }catch (Exception $e) {
            throw new Exception('Шаблон "'.$tmp.'" не найден.');
        }

        $view->products = $dataProducts;
        $view->operation = $this->_sitePageData->operation->getValues();
        $view->shop = $this->_sitePageData->shop->getName();
        $view->shopOptions = $this->_sitePageData->shop->getOptionsArray();
        $strView = Helpers_View::viewToStr($view);

        header('Content-Type: application/x-download;charset=UTF-8');
        // header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: filename="Производственные нормы расхода материалов для приготовления асфальтобетонных смесей.xml"');
        header('Cache-Control: max-age=0');

        echo $strView;
        exit();
    }

    /**
     * Сохранение рецептов продуктов по шаблону Асфальтобетона
     * @throws Exception
     */
    public function action_formulaproduct_asphalt() {
        set_time_limit(36000);

        $this->_sitePageData->url = '/'.$this->actionURLName.'/shopreport/formulaproduct_asphalt';

        $params = Request_RequestParams::setParams(
            array(
                'sort_by' => array(
                    'id' => 'asc',
                ),
            ), false
        );
        $shopFormulaProductItemIDs = Request_Request::find('DB_Ab1_Shop_Formula_Product_Item',
            $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
            array(
                'shop_product_id' => array('unit'),
                'shop_formula_product_id' => array('name'),
                'shop_material_id' => array('name', 'unit_recipe'),
            )
        );

        $dataProducts = array(
            'data' => array(),
        );

        foreach ($shopFormulaProductItemIDs->childs as $child){
            $shopProductID = $child->values['shop_product_id'];
            if(!key_exists($shopProductID, $dataProducts['data'])) {
                $dataProducts['data'][$shopProductID] = array(
                    'name' => $child->getElementValue('shop_formula_product_id'),
                    'unit' => $child->getElementValue('shop_product_id', 'unit'),
                    'materials' => array(),

                    'norm_percent' => 0,
                    'norm_weight' => 0,
                    'losses_weight' => 0,
                    'norm_industrial' => 0,
                );
            }

            $shopMaterialID = $child->values['shop_material_id'];
            $options = json_decode($child->values['options'], true);
            $dataProducts['data'][$shopProductID]['materials'][$shopMaterialID] = array(
                'name' => $child->getElementValue('shop_material_id'),
                'norm_percent' => Arr::path($options, 'norm_percent', ''),
                'norm_weight' => $child->values['norm_weight'],
                'losses' => $child->values['losses'],
                'losses_weight' => Arr::path($options, 'losses_weight', ''),
                'norm_industrial' => Arr::path($options, 'norm_industrial', ''),
            );

            $dataProducts['data'][$shopProductID]['norm_percent'] += floatval(Arr::path($options, 'norm_percent', 0));
            $dataProducts['data'][$shopProductID]['norm_weight'] += $child->values['norm_weight'];
            $dataProducts['data'][$shopProductID]['losses_weight'] += floatval(Arr::path($options, 'losses_weight', 0));
            $dataProducts['data'][$shopProductID]['norm_industrial'] += floatval(Arr::path($options, 'norm_industrial', 0));
        }
        uasort($dataProducts['data'], array($this, 'mySortMethod'));


        $viewObject = 'ab1/_report/'.$this->_sitePageData->languageID.'/formula-product/asphalt';
        $tmp = str_replace('\\', '/', $viewObject);
        try {
            $view = View::factory($tmp);
        }catch (Exception $e) {
            throw new Exception('Шаблон "'.$tmp.'" не найден.');
        }

        $view->products = $dataProducts;
        $view->operation = $this->_sitePageData->operation->getValues();
        $view->shop = $this->_sitePageData->shop->getName();
        $view->shopOptions = $this->_sitePageData->shop->getOptionsArray();
        $strView = Helpers_View::viewToStr($view);

        header('Content-Type: application/x-download;charset=UTF-8');
        // header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: filename="Производственные нормы расхода материалов для приготовления асфальтобетонных смесей.xml"');
        header('Cache-Control: max-age=0');

        echo $strView;
        exit();
    }

    /**
     * Сохранение рецептов продуктов по шаблону ЖБИ
     * @throws Exception
     */
    public function action_formulaproduct_zhbi() {
        set_time_limit(36000);

        $this->_sitePageData->url = '/'.$this->actionURLName.'/shopreport/formulaproduct_zhbi';

        $params = Request_RequestParams::setParams(
            array(), false
        );
        $shopFormulaProductItemIDs = Request_Request::find('DB_Ab1_Shop_Formula_Product_Item',
            $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
            array(
                'shop_product_id' => array('unit'),
                'shop_formula_product_id' => array('name'),
                'shop_material_id' => array('name', 'unit_recipe'),
            )
        );

        $dataMaterials = array(
            'data' => array(),
        );
        $materials = array();
        foreach ($shopFormulaProductItemIDs->childs as $child){
            $shopMaterialID = $child->values['shop_material_id'];
            if(!key_exists($shopMaterialID, $dataMaterials['data'])) {
                $dataMaterials['data'][$shopMaterialID] = array(
                    'id' => $shopMaterialID,
                    'name' => $child->getElementValue('shop_material_id'),
                    'unit' => $child->getElementValue('shop_material_id', 'unit_recipe'),
                );

                $materials[$shopMaterialID] = 0;
            }
        }
        uasort($dataMaterials['data'], array($this, 'mySortMethod'));

        $dataProducts = array(
            'data' => array(),
        );

        foreach ($shopFormulaProductItemIDs->childs as $child){
            $shopProductID = $child->values['shop_product_id'];
            if(!key_exists($shopProductID, $dataProducts['data'])) {
                $dataProducts['data'][$shopProductID] = array(
                    'name' => $child->getElementValue('shop_formula_product_id'),
                    'unit' => $child->getElementValue('shop_product_id', 'unit'),
                    'materials' => $materials,
                );
            }

            $shopMaterialID = $child->values['shop_material_id'];
            $dataProducts['data'][$shopProductID]['materials'][$shopMaterialID] = $child->values['norm_weight'];
        }
        uasort($dataProducts['data'], array($this, 'mySortMethod'));


        $viewObject = 'ab1/_report/'.$this->_sitePageData->languageID.'/formula-product/zhbi';
        $tmp = str_replace('\\', '/', $viewObject);
        try {
            $view = View::factory($tmp);
        }catch (Exception $e) {
            throw new Exception('Шаблон "'.$tmp.'" не найден.');
        }

        $view->materials = $dataMaterials;
        $view->products = $dataProducts;
        $view->operation = $this->_sitePageData->operation->getValues();
        $view->shop = $this->_sitePageData->shop->getName();
        $view->shopOptions = $this->_sitePageData->shop->getOptionsArray();
        $strView = Helpers_View::viewToStr($view);

        header('Content-Type: application/x-download;charset=UTF-8');
        // header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: filename="Производственные нормы  расходов материалов на производство ЖБИ.xml"');
        header('Cache-Control: max-age=0');

        echo $strView;
        exit();
    }

    /**
     * Итоговый остатки
     * @param $shopMaterialID
     * @param $date
     * @return array
     */
    private function _getMaterialLesseeTotal($shopMaterialID, $date)
    {
        $dataTotal = array(
            'quantity_day' => 0,
            'quantity_month' => 0,
            'quantity' => 0,
            'quantity_current' => 0,
        );

        return $dataTotal;

        // Список накладная
        $params = Request_RequestParams::setParams(
            array(
                'is_exit' => true,
                'exit_at_from' => Helpers_DateTime::minusDays($date, 1) . ' 06:00:00',
                'exit_at_to' => $date . ' 06:00:00',
                'sum_quantity' => true,
                'shop_product_id' => $shopProductIDs,
                'group_by' => array(
                    'shop_client_id', 'shop_client_id.name',
                )
            )
        );
        $elements = array(
            'shop_client_id' => array('name', 'options'),
            'shop_supplier_id' => array('name'),
            'shop_id' => array('name'),
        );

        $shopBoxcarIDs = Request_Request::find('DB_Ab1_Shop_Lessee_Car',
            array(), $this->_sitePageData, $this->_driverDB, $params, 0, TRUE, $elements
        );

        foreach ($shopBoxcarIDs->childs as $child) {
            $shopClientID = $child->values['shop_client_id'] . '_' . $child->values['shop_supplier_id'];
            if (!key_exists($shopClientID, $dataRealizations['data'])) {
                $dataRealizations['data'][$shopClientID] = array(
                    'shop_client_id' => $child->values['shop_client_id'],
                    'client' => $child->getElementValue('shop_client_id', 'name', $child->getElementValue('shop_id')),
                    'quantity_day' => 0,
                    'quantity_month' => 0,
                    'quantity' => 0,
                );
            }

            $dataRealizations['data'][$shopClientID]['quantity_day'] += $child->values['quantity'];
            $dataRealizations['quantity_day'] += $child->values['quantity'];
        }

        $params['exit_at_from'] = Helpers_DateTime::getMonthBeginStr(Helpers_DateTime::getMonth($date), Helpers_DateTime::getYear($date)) . ' 06:00:00';
        $shopBoxcarIDs = Request_Request::findBranch('DB_Ab1_Shop_Boxcar',
            array(), $this->_sitePageData, $this->_driverDB, $params, 0, TRUE, $elements
        );

        foreach ($shopBoxcarIDs->childs as $child) {
            $shopClientID = $child->values['shop_client_id'] . '_' . $child->values['shop_supplier_id'];
            if (!key_exists($shopClientID, $dataRealizations['data'])) {
                $dataRealizations['data'][$shopClientID] = array(
                    'shop_client_id' => $child->values['shop_client_id'],
                    'client' => $child->getElementValue('shop_client_id', 'name', $child->getElementValue('shop_id')),
                    'quantity_day' => 0,
                    'quantity_month' => 0,
                    'quantity' => 0,
                );
            }

            $dataRealizations['data'][$shopClientID]['quantity_month'] += $child->values['quantity'];
            $dataRealizations['quantity_month'] += $child->values['quantity'];
        }

        $params['exit_at_from'] = Helpers_DateTime::getYearBeginStr(Helpers_DateTime::getYear($date)) . ' 06:00:00';
        $shopBoxcarIDs = Request_Request::findBranch('DB_Ab1_Shop_Boxcar',
            array(), $this->_sitePageData, $this->_driverDB, $params, 0, TRUE, $elements
        );

        foreach ($shopBoxcarIDs->childs as $child) {
            $shopClientID = $child->values['shop_client_id'] . '_' . $child->values['shop_supplier_id'];
            if (!key_exists($shopClientID, $dataRealizations['data'])) {
                $dataRealizations['data'][$shopClientID] = array(
                    'shop_client_id' => $child->values['shop_client_id'],
                    'client' => $child->getElementValue('shop_client_id', 'name', $child->getElementValue('shop_id')),
                    'quantity_day' => 0,
                    'quantity_month' => 0,
                    'quantity' => 0,
                );
            }

            $dataRealizations['data'][$shopClientID]['quantity'] += $child->values['quantity'];
            $dataRealizations['quantity'] += $child->values['quantity'];
        }

        return $dataRealizations;
    }

    /**
     * Реализация ответ.хранения
     * @param $shopProductIDs
     * @param $date
     * @return array
     */
    private function _getMaterialLesseeCarLessees($shopProductIDs, $date)
    {
        $dataRealizations = array(
            'data' => array(),
            'quantity_day' => 0,
            'quantity_month' => 0,
            'quantity' => 0,
            'quantity_current' => 0,
        );

        // Список накладная
        $params = Request_RequestParams::setParams(
            array(
                'is_exit' => true,
                'exit_at_from' => Helpers_DateTime::minusDays($date, 1) . ' 06:00:00',
                'exit_at_to' => $date . ' 06:00:00',
                'sum_quantity' => true,
                'shop_product_id' => $shopProductIDs,
                'group_by' => array(
                    'shop_client_id', 'shop_client_id.name',
                )
            )
        );
        $elements = array(
            'shop_client_id' => array('name'),
        );

        $shopCarLesseeIDs = Request_Request::findBranch('DB_Ab1_Shop_Lessee_Car',
            array(), $this->_sitePageData, $this->_driverDB, $params, 0, TRUE, $elements
        );

        foreach ($shopCarLesseeIDs->childs as $child) {
            $shopClientID = $child->values['shop_client_id'];
            if (!key_exists($shopClientID, $dataRealizations['data'])) {
                $dataRealizations['data'][$shopClientID] = array(
                    'shop_client_id' => $child->values['shop_client_id'],
                    'client' => $child->getElementValue('shop_client_id', 'name', $child->getElementValue('shop_id')),
                    'quantity_day' => 0,
                    'quantity_month' => 0,
                    'quantity' => 0,
                    'quantity_current' => 0,
                );
                $dataRealizations['quantity_current'] += $dataRealizations['data'][$shopClientID]['quantity_current'];
            }

            $dataRealizations['data'][$shopClientID]['quantity_day'] += $child->values['quantity'];
            $dataRealizations['quantity_day'] += $child->values['quantity'];
        }

        $params['exit_at_from'] = Helpers_DateTime::getMonthBeginStr(Helpers_DateTime::getMonth($date), Helpers_DateTime::getYear($date)) . ' 06:00:00';
        $shopCarLesseeIDs = Request_Request::findBranch('DB_Ab1_Shop_Lessee_Car',
            array(), $this->_sitePageData, $this->_driverDB, $params, 0, TRUE, $elements
        );

        foreach ($shopCarLesseeIDs->childs as $child) {
            $shopClientID = $child->values['shop_client_id'];
            if (!key_exists($shopClientID, $dataRealizations['data'])) {
                $dataRealizations['data'][$shopClientID] = array(
                    'shop_client_id' => $child->values['shop_client_id'],
                    'client' => $child->getElementValue('shop_client_id', 'name', $child->getElementValue('shop_id')),
                    'quantity_day' => 0,
                    'quantity_month' => 0,
                    'quantity' => 0,
                    'quantity_current' => 0,
                );
                $dataRealizations['quantity_current'] += $dataRealizations['data'][$shopClientID]['quantity_current'];
            }

            $dataRealizations['data'][$shopClientID]['quantity_month'] += $child->values['quantity'];
            $dataRealizations['quantity_month'] += $child->values['quantity'];
        }

        $params['exit_at_from'] = Helpers_DateTime::getYearBeginStr(Helpers_DateTime::getYear($date)) . ' 06:00:00';
        $shopCarLesseeIDs = Request_Request::findBranch('DB_Ab1_Shop_Lessee_Car',
            array(), $this->_sitePageData, $this->_driverDB, $params, 0, TRUE, $elements
        );

        foreach ($shopCarLesseeIDs->childs as $child) {
            $shopClientID = $child->values['shop_client_id'];
            if (!key_exists($shopClientID, $dataRealizations['data'])) {
                $dataRealizations['data'][$shopClientID] = array(
                    'shop_client_id' => $child->values['shop_client_id'],
                    'client' => $child->getElementValue('shop_client_id', 'name', $child->getElementValue('shop_id')),
                    'quantity_day' => 0,
                    'quantity_month' => 0,
                    'quantity' => 0,
                    'quantity_current' => 0,
                );
                $dataRealizations['quantity_current'] += $dataRealizations['data'][$shopClientID]['quantity_current'];
            }

            $dataRealizations['data'][$shopClientID]['quantity'] += $child->values['quantity'];
            $dataRealizations['quantity'] += $child->values['quantity'];
        }

        return $dataRealizations;
    }

    /**
     * Поступление сырья через ЖД
     * @param $shopRawID
     * @param $date
     * @return array
     */
    private function _getMaterialLesseeReceives($shopRawID, $date)
    {
        $dataReceives = array(
            'data' => array(),
            'quantity_day' => 0,
            'quantity_month' => 0,
            'quantity' => 0,
        );

        // Список накладная
        $params = Request_RequestParams::setParams(
            array(
                'date_drain_to_from_equally' => $date,
                'date_drain_to_to' => $date . ' 23:59:59',
                'sum_quantity' => true,
                'shop_raw_id' => $shopRawID,
                'group_by' => array(
                    'shop_client_id', 'shop_client_id.name', 'shop_client_id.options',
                    'shop_supplier_id', 'shop_supplier_id.name',
                    'shop_id', 'shop_id.name',
                )
            )
        );
        $elements = array(
            'shop_client_id' => array('name', 'options'),
            'shop_supplier_id' => array('name'),
            'shop_id' => array('name'),
        );

        $shopBoxcarIDs = Request_Request::findBranch('DB_Ab1_Shop_Boxcar',
            array(), $this->_sitePageData, $this->_driverDB, $params, 0, TRUE, $elements
        );

        foreach ($shopBoxcarIDs->childs as $child) {
            $shopClientID = $child->values['shop_client_id'] . '_' . $child->values['shop_supplier_id'];
            if (!key_exists($shopClientID, $dataReceives['data'])) {
                $dataReceives['data'][$shopClientID] = array(
                    'shop_client_id' => $child->values['shop_client_id'],
                    'client' => $child->getElementValue('shop_client_id', 'name', $child->getElementValue('shop_id')),
                    'supplier' => $child->getElementValue('shop_supplier_id'),
                    'percent' => Arr::path(json_decode($child->getElementValue('shop_client_id', 'options', '[]'), true), 'lessee_percent'),
                    'quantity_day' => 0,
                    'quantity_month' => 0,
                    'quantity' => 0,
                );
            }

            $dataReceives['data'][$shopClientID]['quantity_day'] += $child->values['quantity'];
            $dataReceives['quantity_day'] += $child->values['quantity'];
        }

        $params['date_drain_to_from_equally'] = Helpers_DateTime::getMonthBeginStr(Helpers_DateTime::getMonth($date), Helpers_DateTime::getYear($date));
        $shopBoxcarIDs = Request_Request::findBranch('DB_Ab1_Shop_Boxcar',
            array(), $this->_sitePageData, $this->_driverDB, $params, 0, TRUE, $elements
        );

        foreach ($shopBoxcarIDs->childs as $child) {
            $shopClientID = $child->values['shop_client_id'] . '_' . $child->values['shop_supplier_id'];
            if (!key_exists($shopClientID, $dataReceives['data'])) {
                $dataReceives['data'][$shopClientID] = array(
                    'shop_client_id' => $child->values['shop_client_id'],
                    'client' => $child->getElementValue('shop_client_id', 'name', $child->getElementValue('shop_id')),
                    'supplier' => $child->getElementValue('shop_supplier_id'),
                    'percent' => Arr::path(json_decode($child->getElementValue('shop_client_id', 'options', '[]'), true), 'lessee_percent'),
                    'quantity_day' => 0,
                    'quantity_month' => 0,
                    'quantity' => 0,
                );
            }

            $dataReceives['data'][$shopClientID]['quantity_month'] += $child->values['quantity'];
            $dataReceives['quantity_month'] += $child->values['quantity'];
        }

        $params['date_drain_to_from_equally'] = Helpers_DateTime::getYearBeginStr(Helpers_DateTime::getYear($date));
        $shopBoxcarIDs = Request_Request::findBranch('DB_Ab1_Shop_Boxcar',
            array(), $this->_sitePageData, $this->_driverDB, $params, 0, TRUE, $elements
        );

        foreach ($shopBoxcarIDs->childs as $child) {
            $shopClientID = $child->values['shop_client_id'] . '_' . $child->values['shop_supplier_id'];
            if (!key_exists($shopClientID, $dataReceives['data'])) {
                $dataReceives['data'][$shopClientID] = array(
                    'shop_client_id' => $child->values['shop_client_id'],
                    'client' => $child->getElementValue('shop_client_id', 'name', $child->getElementValue('shop_id')),
                    'supplier' => $child->getElementValue('shop_supplier_id'),
                    'percent' => Arr::path(json_decode($child->getElementValue('shop_client_id', 'options', '[]'), true), 'lessee_percent'),
                    'quantity_day' => 0,
                    'quantity_month' => 0,
                    'quantity' => 0,
                );
            }

            $dataReceives['data'][$shopClientID]['quantity'] += $child->values['quantity'];
            $dataReceives['quantity'] += $child->values['quantity'];
        }

        $dataReceives['lessee_quantity_day'] = 0;
        $dataReceives['lessee_quantity_month'] = 0;
        $dataReceives['lessee_quantity'] = 0;
        foreach ($dataReceives['data'] as &$child) {
            if($child['shop_client_id'] < 1){
                continue;
            }

            $child['lessee_quantity_day'] = round($child['quantity_day'] / 100 * $child['percent'], 3);
            $child['lessee_quantity_month'] = round($child['quantity_month'] / 100 * $child['percent'], 3);
            $child['lessee_quantity'] = round($child['quantity'] / 100 * $child['percent'], 3);

            $dataReceives['lessee_quantity_day'] += $child['lessee_quantity_day'];
            $dataReceives['lessee_quantity_month'] += $child['lessee_quantity_month'];
            $dataReceives['lessee_quantity'] += $child['lessee_quantity'];
        }

        return $dataReceives;
    }

    /**
     * С9 - Реестр накладных
     * @throws Exception
     */
    public function action_material_lessee() {
        set_time_limit(36000);

        $this->_sitePageData->url = '/'.$this->actionURLName.'/shopreport/material_lessee';

        $date = Request_RequestParams::getParamDate('date');
        $shopMaterialID = Request_RequestParams::getParamDate('shop_material_id');

        $modelMaterial = new Model_Ab1_Shop_Material();
        $modelMaterial->setDBDriver($this->_driverDB);
        if(!Helpers_DB::getDBObject($modelMaterial, $shopMaterialID, $this->_sitePageData, $this->_sitePageData->shopMainID)){
            throw new HTTP_Exception_500('Material not found.');
        }
        $shopRawID = 0;
        $shopProductIDs = null;
        $shopMaterialID = null;

        // Поступление сырья через ЖД
        $dataReceives = $this->_getMaterialLesseeReceives($shopRawID, $date);
        // Реализация ответ.хранения
        $dataRealizations = $this->_getMaterialLesseeCarLessees($shopProductIDs, $date);
        // Итоговый остатки
        $dataTotal = $this->_getMaterialLesseeTotal($shopMaterialID, $date);


        $viewObject = 'ab1/_report/'.$this->_sitePageData->languageID.'/material/lessee';
        $tmp = str_replace('\\', '/', $viewObject);
        try {
            $view = View::factory($tmp);
        }catch (Exception $e) {
            throw new Exception('Шаблон "'.$tmp.'" не найден.');
        }

        $view->date = $date;
        $view->total = $dataTotal;
        $view->receives = $dataReceives;
        $view->realizationLessees = $dataRealizations;
        $view->subdivisions = array('data' => array());
        $view->material = $modelMaterial->getName();
        $view->operation = $this->_sitePageData->operation->getName();
        $view->shop = $this->_sitePageData->shop->getName();
        $view->shopOptions = $this->_sitePageData->shop->getOptionsArray();
        $strView = Helpers_View::viewToStr($view);

        header('Content-Type: application/x-download;charset=UTF-8');
        // header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: filename="СПРАВКА по '. $modelMaterial->getName() .' за ' . Helpers_DateTime::getDateFormatRus($date) . '.xml"');
        header('Cache-Control: max-age=0');

        echo $strView;
        exit();
    }

    /**
     * Печать ТТН перемещение
     * @throws Exception
     * @throws HTTP_Exception_500
     */
    public function action_move_car_ttn() {
        set_time_limit(36000);

        $this->_sitePageData->url = '/'.$this->actionURLName.'/shopreport/move_car_ttn';

        $id = Request_RequestParams::getParamInt('id');

        $model = new Model_Ab1_Shop_Move_Car();
        $model->setDBDriver($this->_driverDB);
        if(!Helpers_DB::getDBObject($model, $id, $this->_sitePageData)){
            throw new HTTP_Exception_500('Car move not found.');
        }

        $model->getElement('shop_product_id', true);
        $model->getElement('shop_client_id', true);
        $model->getElement('shop_driver_id', true);

        $viewObject = 'ab1/_report/'.$this->_sitePageData->languageID.'/move/car/ttn';
        $tmp = str_replace('\\', '/', $viewObject);
        try {
            $view = View::factory($tmp);
        }catch (Exception $e) {
            throw new Exception('Шаблон "'.$tmp.'" не найден.');
        }

        $dataCar = new MyArray();
        $dataCar->setValues($model, $this->_sitePageData);

        $view->car = $dataCar;
        $view->operation = $this->_sitePageData->operation->getValues();
        $view->shop = $this->_sitePageData->shop->getName();
        $view->shopOptions = $this->_sitePageData->shop->getOptionsArray();
        $strView = Helpers_View::viewToStr($view);

        header('Content-Type: application/x-download;charset=UTF-8');
        // header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: filename="ТТН '.$model->id.'.xml"');
        header('Cache-Control: max-age=0');

        echo $strView;
        exit();
    }

    /**
     * Печать ТТН брака
     * @throws Exception
     * @throws HTTP_Exception_500
     */
    public function action_defect_car_ttn() {
        set_time_limit(36000);

        $this->_sitePageData->url = '/'.$this->actionURLName.'/shopreport/defect_car_ttn';

        $id = Request_RequestParams::getParamInt('id');

        $model = new Model_Ab1_Shop_Defect_Car();
        $model->setDBDriver($this->_driverDB);
        if(!Helpers_DB::getDBObject($model, $id, $this->_sitePageData)){
            throw new HTTP_Exception_500('Car defect not found.');
        }

        $model->getElement('shop_product_id', true);
        $model->getElement('shop_client_id', true);
        $model->getElement('shop_driver_id', true);

        $viewObject = 'ab1/_report/'.$this->_sitePageData->languageID.'/defect/car/ttn';
        $tmp = str_replace('\\', '/', $viewObject);
        try {
            $view = View::factory($tmp);
        }catch (Exception $e) {
            throw new Exception('Шаблон "'.$tmp.'" не найден.');
        }

        $dataCar = new MyArray();
        $dataCar->setValues($model, $this->_sitePageData);

        $view->car = $dataCar;
        $view->operation = $this->_sitePageData->operation->getValues();
        $view->shop = $this->_sitePageData->shop->getName();
        $view->shopOptions = $this->_sitePageData->shop->getOptionsArray();
        $strView = Helpers_View::viewToStr($view);

        header('Content-Type: application/x-download;charset=UTF-8');
        // header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: filename="ТТН '.$model->id.'.xml"');
        header('Cache-Control: max-age=0');

        echo $strView;
        exit();
    }

    /**
     * Печать ТТН ответ.хранения
     * @throws Exception
     * @throws HTTP_Exception_500
     */
    public function action_lessee_car_ttn() {
        set_time_limit(36000);

        $this->_sitePageData->url = '/'.$this->actionURLName.'/shopreport/lessee_car_ttn';

        $id = Request_RequestParams::getParamInt('id');

        $model = new Model_Ab1_Shop_Lessee_Car();
        $model->setDBDriver($this->_driverDB);
        if(!Helpers_DB::getDBObject($model, $id, $this->_sitePageData)){
            throw new HTTP_Exception_500('Car not found.');
        }

        $model->getElement('shop_product_id', true);
        $model->getElement('shop_client_id', true);
        $model->getElement('shop_driver_id', true);

        $viewObject = 'ab1/_report/'.$this->_sitePageData->languageID.'/car/ttn';
        $tmp = str_replace('\\', '/', $viewObject);
        try {
            $view = View::factory($tmp);
        }catch (Exception $e) {
            throw new Exception('Шаблон "'.$tmp.'" не найден.');
        }

        $dataCar = new MyArray();
        $dataCar->setValues($model, $this->_sitePageData);

        $view->car = $dataCar;
        $view->operation = $this->_sitePageData->operation->getValues();
        $view->shop = $this->_sitePageData->shop->getName();
        $view->shopOptions = $this->_sitePageData->shop->getOptionsArray();
        $strView = Helpers_View::viewToStr($view);

        header('Content-Type: application/x-download;charset=UTF-8');
        // header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: filename="ТТН '.$model->id.'.xml"');
        header('Cache-Control: max-age=0');

        echo $strView;
        exit();
    }

    /**
     * Печать ТТН машин с материалов
     * @throws Exception
     * @throws HTTP_Exception_500
     */
    public function action_car_to_material_ttn() {
        set_time_limit(36000);

        $this->_sitePageData->url = '/'.$this->actionURLName.'/shopreport/car_ttn';

        $id = Request_RequestParams::getParamInt('id');

        $model = new Model_Ab1_Shop_Car_To_Material();
        $model->setDBDriver($this->_driverDB);
        if(!Helpers_DB::getDBObject($model, $id, $this->_sitePageData)){
            throw new HTTP_Exception_500('Car to material not found.');
        }

        $model->getElement('shop_subdivision_daughter_id', true);
        $model->getElement('shop_subdivision_receiver_id', true);
        $model->getElement('shop_heap_daughter_id', true);
        $model->getElement('shop_heap_receiver_id', true);
        $model->getElement('shop_branch_receiver_id', true);
        $model->getElement('shop_branch_daughter_id', true);
        $model->getElement('shop_daughter_id', true);
        $model->getElement('shop_material_id', true);
        $model->getElement('shop_client_material_id', true);
        $model->getElement('shop_driver_id', true);
        $model->getElement('shop_transport_company_id', true);

        $viewObject = 'ab1/_report/'.$this->_sitePageData->languageID.'/material/ttn';
        $tmp = str_replace('\\', '/', $viewObject);
        try {
            $view = View::factory($tmp);
        }catch (Exception $e) {
            throw new Exception('Шаблон "'.$tmp.'" не найден.');
        }

        $dataCar = new MyArray();
        $dataCar->setValues($model, $this->_sitePageData);

        $view->car = $dataCar;
        $view->operation = $this->_sitePageData->operation->getValues();
        $view->shop = $this->_sitePageData->shop->getName();
        $view->shopOptions = $this->_sitePageData->shop->getOptionsArray();
        $strView = Helpers_View::viewToStr($view);

        header('Content-Type: application/x-download;charset=UTF-8');
        // header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: filename="ТТН '.$model->id.'.xml"');
        header('Cache-Control: max-age=0');

        echo $strView;
        exit();
    }

    /**
     * Печать ТТН реализации
     * @throws Exception
     * @throws HTTP_Exception_500
     */
    public function action_car_ttn() {
        set_time_limit(36000);

        $this->_sitePageData->url = '/'.$this->actionURLName.'/shopreport/car_ttn';

        $id = Request_RequestParams::getParamInt('id');

        $model = new Model_Ab1_Shop_Car();
        $model->setDBDriver($this->_driverDB);
        if(!Helpers_DB::getDBObject($model, $id, $this->_sitePageData)){
            throw new HTTP_Exception_500('Car not found.');
        }

        $model->getElement('shop_product_id', true);
        $model->getElement('shop_client_id', true);
        $model->getElement('shop_driver_id', true);

        $viewObject = 'ab1/_report/'.$this->_sitePageData->languageID.'/car/ttn';
        $tmp = str_replace('\\', '/', $viewObject);
        try {
            $view = View::factory($tmp);
        }catch (Exception $e) {
            throw new Exception('Шаблон "'.$tmp.'" не найден.');
        }

        $dataCar = new MyArray();
        $dataCar->setValues($model, $this->_sitePageData);

        $view->car = $dataCar;
        $view->operation = $this->_sitePageData->operation->getValues();
        $view->shop = $this->_sitePageData->shop->getName();
        $view->shopOptions = $this->_sitePageData->shop->getOptionsArray();
        $strView = Helpers_View::viewToStr($view);

        header('Content-Type: application/x-download;charset=UTF-8');
        // header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: filename="ТТН '.$model->id.'.xml"');
        header('Cache-Control: max-age=0');

        echo $strView;
        exit();
    }

    /**
     * Реестр по товарно-транспортным накладным по реализации продукции
     */
    public function action_car_piece_registry_old() {
        set_time_limit(36000);

        $this->_sitePageData->url = '/'.$this->actionURLName.'/shopreport/car_piece_registry_old';

        $dateFrom = Request_RequestParams::getParamDateTime('created_at_from');
        $dateTo = Request_RequestParams::getParamDateTime('created_at_to');

        $shopTransportCompanyID = Request_RequestParams::getParamInt('shop_transport_company_id');

        $rubric = Request_RequestParams::getParamInt('shop_product_rubric_id');
        if ($rubric > 0) {
            $shopProductIDs = Api_Ab1_Shop_Product::findAllByMainRubric(
                $rubric,
                $this->_sitePageData, $this->_driverDB
            );
        }else{
            $shopProductIDs = NULL;
        }


        $params = Request_RequestParams::setParams(
            array(
                'shop_transport_company_id' => $shopTransportCompanyID,
                'shop_product_id' => $shopProductIDs,
            )
        );
        // реализация
        $ids = Api_Ab1_Shop_Car::getExitShopCar(
            $dateFrom, $dateTo, $this->_sitePageData, $this->_driverDB,
            array(
                'shop_transport_company_id' => array('name'),
                'shop_client_id' => array('name'),
                'shop_product_id' => array('name'),
                'shop_id' => array('name'),
            ),
            $params, true, null
        );

        $dataCars = array(
            'data' => array(),
            'brutto' => 0,
            'netto' => 0,
            'tare' => 0,
        );

        foreach ($ids->childs as $child){
            $quantity = $child->values['quantity'];

            $dataCars['data'][] = array(
                'date' => $child->values['exit_at'],
                'id' => $child->values['id'],
                'daughter' => $child->getElementValue('shop_id'),
                'receiver' => $child->getElementValue('shop_transport_company_id'),
                'number' => $child->values['name'],
                'heap_receiver' => $child->getElementValue('shop_client_id'),
                'heap_daughter' => '',
                'product' => $child->getElementValue('shop_product_id'),
                'brutto' => $child->values['tarra'] + $quantity,
                'netto' => $quantity,
                'tare' => $child->values['tarra'],
            );

            $dataCars['brutto'] += $child->values['tarra'] + $quantity;
            $dataCars['netto'] += $quantity;
            $dataCars['tare'] += $child->values['tarra'];
        }

        // штучный товар
        $ids = Api_Ab1_Shop_Piece::getExitShopPieces(
            $dateFrom, $dateTo, $this->_sitePageData, $this->_driverDB,
            array(
                'shop_transport_company_id' => array('name'),
                'shop_client_id' => array('name'),
                'shop_id' => array('name'),
            ),
            $params, true, null
        );

        foreach ($ids->childs as $child){
            $quantity = $child->values['quantity'];

            $dataCars['data'][] = array(
                'date' => $child->values['created_at'],
                'id' => $child->values['id'],
                'daughter' => $child->getElementValue('shop_id'),
                'receiver' => $child->getElementValue('shop_transport_company_id'),
                'number' => $child->values['name'],
                'heap_receiver' => $child->getElementValue('shop_client_id'),
                'heap_daughter' => '',
                'product' => $child->values['text'],
                'brutto' => $quantity,
                'netto' => $quantity,
                'tare' => 0,
            );

            $dataCars['brutto'] += $quantity;
            $dataCars['netto'] += $quantity;
            $dataCars['tare'] += 0;
        }

        $viewObject = 'ab1/_report/'.$this->_sitePageData->languageID.'/car/car_piece_registry_old';
        $tmp = str_replace('\\', '/', $viewObject);
        try {
            $view = View::factory($tmp);
        }catch (Exception $e) {
            throw new Exception('Шаблон "'.$tmp.'" не найден.');
        }

        $view->cars = $dataCars;
        $view->dateFrom = $dateFrom;
        $view->dateTo = $dateTo;
        $view->operation = $this->_sitePageData->operation->getValues();
        $view->shop = $this->_sitePageData->shop->getName();
        $view->shopOptions = $this->_sitePageData->shop->getOptionsArray();
        $strView = Helpers_View::viewToStr($view);

        header('Content-Type: application/x-download;charset=UTF-8');
        // header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: filename="БХ01 Реестр товарно-транспортных накладных за период '.Helpers_DateTime::getPeriodRus($dateFrom, $dateTo).'.xml"');
        header('Cache-Control: max-age=0');

        echo $strView;
        exit();
    }

    /**
     * Реестр по товарно-транспортным накладным по реализации продукции
     */
    public function action_car_piece_registry() {
        set_time_limit(36000);

        $this->_sitePageData->url = '/'.$this->actionURLName.'/shopreport/car_piece_registry';

        $dateFrom = Request_RequestParams::getParamDateTime('created_at_from');
        $dateTo = Request_RequestParams::getParamDateTime('created_at_to');

        $shopTransportCompanyID = Request_RequestParams::getParamInt('shop_transport_company_id');
        $shopSubdivisionID = Request_RequestParams::getParamInt('shop_subdivision_id');

        $rubric = Request_RequestParams::getParamInt('shop_product_rubric_id');
        if ($rubric > 0) {
            $shopProductIDs = Api_Ab1_Shop_Product::findAllByMainRubric(
                $rubric,
                $this->_sitePageData, $this->_driverDB
            );
        }else{
            $shopProductIDs = NULL;
        }


        $params = Request_RequestParams::setParams(
            array(
                'shop_transport_company_id' => $shopTransportCompanyID,
                'shop_product_id' => $shopProductIDs,
                'shop_subdivision_id' => $shopSubdivisionID,
            )
        );
        // реализация
        $ids = Api_Ab1_Shop_Car::getExitShopCar(
            $dateFrom, $dateTo, $this->_sitePageData, $this->_driverDB,
            array(
                'shop_transport_company_id' => array('name'),
                'shop_client_id' => array('name', 'bin'),
                'shop_product_id' => array('name'),
                'shop_subdivision_id' => array('name'),
                'shop_driver_id' => array('name'),
                'shop_delivery_id' => array('name'),
                'shop_storage_id' => array('name'),
                'shop_turn_place_id' => array('name'),
            ),
            $params, true, null
        );

        // находим номера накладных
        $shopInvoices = array();
        if(count($ids->childs) > 0){
            $shopCarItemIDs = Request_Request::findBranch('DB_Ab1_Shop_Car_Item',
                array(), $this->_sitePageData, $this->_driverDB,
                Request_RequestParams::setParams(
                    array(
                        'shop_car_id' => $ids->getChildArrayID(),
                    )
                ),
                0, TRUE,
                array('shop_invoice_id' => array('number'))
            );

            foreach ($shopCarItemIDs->childs as $child){
                $shopCarID = $child->values['shop_car_id'];
                if(key_exists($shopCarID, $shopInvoices)){
                    $shopInvoices[$shopCarID] .= ', '. $child->getElementValue('shop_invoice_id', 'number');
                }else{
                    $shopInvoices[$shopCarID] = $child->getElementValue('shop_invoice_id', 'number');
                }
            }
        }

        $dataCars = array(
            'data' => array(),
            'brutto' => 0,
            'netto' => 0,
            'tare' => 0,
        );

        foreach ($ids->childs as $child){
            $quantity = $child->values['quantity'];

            $dataCars['data'][] = array(
                'created_at' => $child->values['created_at'],
                'exit_at' => $child->values['exit_at'],
                'client' => $child->getElementValue('shop_client_id'),
                'client_bin' => $child->getElementValue('shop_client_id', 'bin'),
                'product' => $child->getElementValue('shop_product_id'),
                'id' => $child->values['id'],
                'transport_company' => $child->getElementValue('shop_transport_company_id'),
                'number' => $child->values['name'],
                'driver' => $child->getElementValue('shop_driver_id'),
                'delivery' => $child->getElementValue('shop_delivery_id'),
                'brutto' => $child->values['tarra'] + $quantity,
                'netto' => $quantity,
                'tare' => $child->values['tarra'],
                'amount' => $child->values['amount'],
                'subdivision' => $child->getElementValue('shop_subdivision_id'),
                'turn_place' => $child->getElementValue('shop_storage_id', 'name', $child->getElementValue('shop_turn_place_id')),
                'is_charity' => $child->values['is_charity'],
                'invoice' => key_exists($child->id, $shopInvoices) ? $shopInvoices[$child->id] : '',
            );

            $dataCars['brutto'] += $child->values['tarra'] + $quantity;
            $dataCars['netto'] += $quantity;
            $dataCars['tare'] += $child->values['tarra'];
        }

        // штучный товар
        $ids = Api_Ab1_Shop_Piece::getExitShopPieces(
            $dateFrom, $dateTo, $this->_sitePageData, $this->_driverDB,
            array(
                'shop_transport_company_id' => array('name'),
                'shop_client_id' => array('name', 'bin'),
                'shop_driver_id' => array('name'),
                'shop_delivery_id' => array('name'),
            ),
            $params, true, null
        );
        $ids->runIndex();

        // находим номера накладных
        $shopInvoices = array();
        if(count($ids->childs) > 0){
            $shopPieceItemIDs = Request_Request::findBranch('DB_Ab1_Shop_Piece_Item',
                array(), $this->_sitePageData, $this->_driverDB,
                Request_RequestParams::setParams(
                    array(
                        'shop_piece_id' => $ids->getChildArrayID(),
                        'shop_product_id' => $shopProductIDs,
                    )
                ),
                0, TRUE,
                array(
                    'shop_invoice_id' => array('number'),
                    'shop_subdivision_id' => array('name'),
                    'shop_storage_id' => array('name'),
                )
            );

            foreach ($shopPieceItemIDs->childs as $child){
                $shopPieceID = $child->values['shop_piece_id'];
                $invoice = $child->getElementValue('shop_invoice_id', 'number');
                $storage = $child->getElementValue('shop_storage_id');
                $subdivision = $child->getElementValue('shop_subdivision_id');

                if(!key_exists($shopPieceID, $shopInvoices)){
                    $shopInvoices[$shopPieceID] =[
                        'invoice' => [],
                        'storage' => [],
                        'subdivision' => [],
                    ];
                }

                if(!empty($invoice)) {
                    $shopInvoices[$shopPieceID]['invoice'][$invoice] = $invoice;
                }
                if(!empty($invoice)) {
                    $shopInvoices[$shopPieceID]['storage'][$storage] = $storage;
                }
                if(!empty($invoice)) {
                    $shopInvoices[$shopPieceID]['subdivision'][$subdivision] = $subdivision;
                }

                $ids->childs[$shopPieceID]->additionDatas['is_add'] = true;
            }
        }

        foreach ($ids->childs as $child){
            if(!Arr::path($child->additionDatas, 'is_add', false)){
                continue;
            }

            $quantity = $child->values['quantity'];

            $dataCars['data'][] = array(
                'created_at' => $child->values['created_at'],
                'exit_at' => $child->values['created_at'],
                'client' => $child->getElementValue('shop_client_id'),
                'client_bin' => $child->getElementValue('shop_client_id', 'bin'),
                'product' => $child->values['text'],
                'id' => $child->values['id'],
                'transport_company' => $child->getElementValue('shop_transport_company_id'),
                'number' => $child->values['name'],
                'driver' => $child->getElementValue('shop_driver_id'),
                'delivery' => $child->getElementValue('shop_delivery_id'),
                'brutto' => $quantity,
                'netto' => $quantity,
                'tare' => 0,
                'amount' => $child->values['amount'],
                'subdivision' => key_exists($child->id, $shopInvoices) ? implode(', ' , $shopInvoices[$child->id]['subdivision']) : '',
                'turn_place' => key_exists($child->id, $shopInvoices) ? implode(', ' , $shopInvoices[$child->id]['storage']) : '',
                'is_charity' => $child->values['is_charity'],
                'invoice' => key_exists($child->id, $shopInvoices) ? implode(', ' , $shopInvoices[$child->id]['invoice']) : '',
            );

            $dataCars['brutto'] += $quantity;
            $dataCars['netto'] += $quantity;
            $dataCars['tare'] += 0;
        }

        $viewObject = 'ab1/_report/'.$this->_sitePageData->languageID.'/car/car_piece_registry';
        $tmp = str_replace('\\', '/', $viewObject);
        try {
            $view = View::factory($tmp);
        }catch (Exception $e) {
            throw new Exception('Шаблон "'.$tmp.'" не найден.');
        }

        $view->cars = $dataCars;
        $view->dateFrom = $dateFrom;
        $view->dateTo = $dateTo;
        $view->operation = $this->_sitePageData->operation->getValues();
        $view->shop = $this->_sitePageData->shop->getName();
        $view->shopOptions = $this->_sitePageData->shop->getOptionsArray();
        $strView = Helpers_View::viewToStr($view);

        header('Content-Type: application/x-download;charset=UTF-8');
        // header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: filename="Реестр по товарно-транспортным накладным по реализации продукции за период '.Helpers_DateTime::getPeriodRus($dateFrom, $dateTo).'.xml"');
        header('Cache-Control: max-age=0');

        echo $strView;
        exit();
    }

    /**
     * Реестр по товарно-транспортным накладным по завозу и внутреннему перемещению сырья и материалов
     */
    public function action_material_registry() {
        set_time_limit(36000);

        $this->_sitePageData->url = '/'.$this->actionURLName.'/shopreport/material_registry';

        $dateFrom = Request_RequestParams::getParamDateTime('created_at_from');
        $dateTo = Request_RequestParams::getParamDateTime('created_at_to');

        $shopTransportCompanyID = Request_RequestParams::getParamInt('shop_transport_company_id');
        $shopMaterialRubricID = Request_RequestParams::getParamInt('shop_material_rubric_id');

        $isQuantityReceive = Request_RequestParams::getParamBoolean('is_quantity_receive');

        $params = Request_RequestParams::setParams(
            array(
                'date_document_from' => $dateFrom,
                'date_document_to' => $dateTo,
                'shop_transport_company_id' => $shopTransportCompanyID,
                'shop_material_rubric_id' => $shopMaterialRubricID,
            )
        );
        $shopCarToMaterialIDs = Request_Request::find('DB_Ab1_Shop_Car_To_Material',
            $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
            array(
                'shop_daughter_id' => array('name', 'daughter_weight_id'),
                'shop_material_id' => array('name'),
                'shop_client_material_id' => array('name'),
                'shop_branch_receiver_id' => array('name'),
                'shop_branch_daughter_id' => array('name'),
                'shop_heap_daughter_id' => array('name'),
                'shop_heap_receiver_id' => array('name'),
                'shop_subdivision_receiver_id' => array('name'),
                'shop_subdivision_daughter_id' => array('name'),
                'shop_transport_company_id' => array('name'),
            )
        );

        $dataCars = array(
            'data' => array(),
            'brutto' => 0,
            'netto' => 0,
            'tare' => 0,
        );

        foreach ($shopCarToMaterialIDs->childs as $child){
            $quantity = Api_Ab1_Shop_Car_To_Material::getQuantity($child, $isQuantityReceive);

            $dataCars['data'][] = array(
                'date' => $child->values['date_document'],
                'id' => $child->values['id'],
                'daughter' => $child->getElementValue('shop_client_material_id', 'name', $child->getElementValue('shop_daughter_id', 'name', $child->getElementValue('shop_branch_daughter_id'))),
                'receiver' => $child->getElementValue('shop_transport_company_id'),
                'number' => $child->values['name'],
                'heap_receiver' => $child->getElementValue('shop_heap_receiver_id'),
                'heap_daughter' => $child->getElementValue('shop_heap_daughter_id'),
                'subdivision_receiver' => $child->getElementValue('shop_subdivision_receiver_id'),
                'subdivision_daughter' => $child->getElementValue('shop_subdivision_daughter_id', 'name', $child->getElementValue('shop_daughter_id')),
                'material' => $child->getElementValue('shop_material_id'),
                'brutto' => $child->values['tarra'] + $quantity,
                'netto' => $quantity,
                'tare' => $child->values['tarra'],
            );

            $dataCars['brutto'] += $child->values['tarra'] + $quantity;
            $dataCars['netto'] += $quantity;
            $dataCars['tare'] += $child->values['tarra'];
        }

        $viewObject = 'ab1/_report/'.$this->_sitePageData->languageID.'/material/registry';
        $tmp = str_replace('\\', '/', $viewObject);
        try {
            $view = View::factory($tmp);
        }catch (Exception $e) {
            throw new Exception('Шаблон "'.$tmp.'" не найден.');
        }

        $view->cars = $dataCars;
        $view->dateFrom = $dateFrom;
        $view->dateTo = $dateTo;
        $view->operation = $this->_sitePageData->operation->getValues();
        $view->shop = $this->_sitePageData->shop->getName();
        $view->shopOptions = $this->_sitePageData->shop->getOptionsArray();
        $strView = Helpers_View::viewToStr($view);

        header('Content-Type: application/x-download;charset=UTF-8');
        // header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: filename="БХ02 Реестр по товарно-транспортным накладным по завозу и внутреннему перемещению сырья и материалов за период '.Helpers_DateTime::getPeriodRus($dateFrom, $dateTo).'.xml"');
        header('Cache-Control: max-age=0');

        echo $strView;
        exit();
    }

    /**
     * Реестр машин ответ хранения
     * @throws Exception
     * @throws HTTP_Exception_404
     */
    public function action_lessee_car_registry() {
        set_time_limit(36000);

        $this->_sitePageData->url = '/'.$this->actionURLName.'/shopreport/lessee_car_registry';

        $dateFrom = Request_RequestParams::getParamStr('created_at_from');
        $dateTo = Request_RequestParams::getParamStr('created_at_to');

        $ids = Request_Request::find('DB_Ab1_Shop_Lessee_Car',
            $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB,
            array('created_at_from' => $dateFrom, 'created_at_to' => $dateTo, 'is_exit' => 1), 0, TRUE,
            array(
                'shop_client_id' => array('name'),
                'shop_delivery_id' => array('km')
            )
        );

        $clients = array();
        foreach ($ids->childs as $child){
            $deliveryKm = $child->values['delivery_km'];
            if($deliveryKm <= 0){
                $deliveryKm = $child->getElementValue('shop_delivery_id', 'km', 0);
            }

            $clients[$child->id] = array(
                'shop_client_id' => $child->values['shop_client_id'],
                'name' => $child->values['name'],
                'delivery_km' => $deliveryKm,
                'shop_client_name' => $child->getElementValue('shop_client_id'),
            );
        }
        if (count($ids->childs) > 0) {
            $shopProductRubricID = Request_RequestParams::getParamInt('shop_product_rubric_id');
            if ($shopProductRubricID > 0) {
                $modelRubric = new Model_Ab1_Shop_Product_Rubric();
                $modelRubric->setDBDriver($this->_driverDB);
                if (!(($shopProductRubricID > 0) && (Helpers_DB::getDBObject($modelRubric, $shopProductRubricID, $this->_sitePageData)))) {
                    throw new HTTP_Exception_404('Turn type not found.');
                }

                $shopProductIDs = Api_Ab1_Shop_Product::findAllByMainRubric(
                    Request_RequestParams::getParamInt('shop_product_rubric_id'),
                    $this->_sitePageData, $this->_driverDB
                );
            }else{
                $shopProductIDs = NULL;
            }

            $ids = Request_Request::find('DB_Ab1_Shop_Lessee_Car_Item',
                $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB,
                Request_RequestParams::setParams(
                    array(
                        'shop_lessee_car_id' => $ids->getChildArrayID(),
                        'quantity_from' => 0,
                        'shop_product_id' => $shopProductIDs,
                    )
                ),
                0, TRUE, array('shop_product_id' => array('name'))
            );
        }

        // список продукции
        $products = array();
        foreach ($ids->childs as $child){
            $product = $child->values['shop_product_id'];
            if (! key_exists($product, $products)){
                $products[$product] = array(
                    'quantity' => 0,
                    'delivery_km' => 0,
                    'data' => array(),
                    'name' => $child->getElementValue('shop_product_id')
                );
            }
        }
        uasort($products, array($this, 'mySortMethod'));

        $dataProducts = $products;
        $dataClients = array(
            'data' => array(),
            'quantity' => 0,
            'delivery_km' => 0,
        );
        foreach ($ids->childs as $child){
            $car = $clients[$child->values['shop_lessee_car_id']];

            $quantity = $child->values['quantity'];
            $delivery_km = $car['delivery_km'];

            $product = $child->values['shop_product_id'];
            $dataProducts[$product]['quantity'] += $quantity;

            $client = $car['shop_client_id'].'_'.$car['name'];
            if (! key_exists($client, $dataClients['data'])){
                $dataClients['data'][$client] = array(
                    'data' => $products,
                    'name' => $car['shop_client_name'],
                    'number' => $car['name'],
                    'quantity' => 0,
                    'delivery_km' => 0
                );
            }

            $dataClients['data'][$client]['data'][$product]['quantity'] += $quantity;
            $dataClients['data'][$client]['data'][$product]['delivery_km'] += $delivery_km;

            $dataClients['data'][$client]['quantity'] += $quantity;
            $dataClients['data'][$client]['delivery_km'] += $delivery_km;

            $dataClients['quantity'] += $quantity;
            $dataClients['delivery_km'] += $delivery_km;
        }

        uasort($dataClients['data'], array($this, 'mySortMethod'));

        $viewObject = 'ab1/_report/'.$this->_sitePageData->languageID.'/lessee-car/registry';
        $tmp = str_replace('\\', '/', $viewObject);
        try {
            $view = View::factory($tmp);
        }catch (Exception $e) {
            throw new Exception('Шаблон "'.$tmp.'" не найден.');
        }

        $view->products = $dataProducts;
        $view->clients = $dataClients;
        $view->dateFrom = $dateFrom;
        $view->dateTo = $dateTo;
        $view->operation = $this->_sitePageData->operation->getValues();
        $view->shop = $this->_sitePageData->shop->getName();
        $view->shopOptions = $this->_sitePageData->shop->getOptionsArray();
        $strView = Helpers_View::viewToStr($view);

        header('Content-Type: application/x-download;charset=UTF-8');
        // header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: filename="ВС12 Реестр машин ответ.хранения за период'
            . ' c ' . Helpers_DateTime::getDateTimeRusWithoutSeconds($dateFrom)
            . ' по ' . Helpers_DateTime::getDateTimeRusWithoutSeconds($dateTo). '.xml"');
        header('Cache-Control: max-age=0');

        echo $strView;
        exit();
    }

    /**
     * ВС17 Пустые машины
     * @throws Exception
     */
    public function action_move_empty_list() {
        set_time_limit(36000);

        $this->_sitePageData->url = '/'.$this->actionURLName.'/shopreport/move_empty_list';

        // задаем время выборки
        $dateFrom = Request_RequestParams::getParamDateTime('created_at_from');
        $dateTo = Request_RequestParams::getParamDateTime('created_at_to');

        $params = array(
            'created_at_from' => $dateFrom,
            'created_at_to' => $dateTo,
            'sort_by' => array(
                'created_at' => 'asc'
            ),
        );

        $params = Request_RequestParams::setParams(
            $params
        );
        $ids = Request_Request::find('DB_Ab1_Shop_Move_Empty',
            $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB,
            $params, 0, TRUE,
            array(
                'shop_move_place_id' => array('name'),
                'shop_transport_company_id' => array('name'),
                'weighted_exit_operation_id' => array('name')
            )
        );

        $dataCars = array(
            'data' => array(),
            'quantity' => 0
        );
        foreach ($ids->childs as $child){
            $quantity = $child->values['quantity'];

            $dataCars['data'][] = array(
                'weighted_exit_at' => $child->values['weighted_exit_at'],
                'shop_move_place_name' => $child->getElementValue('shop_move_place_id'),
                'shop_transport_company_name' => $child->getElementValue('shop_transport_company_id'),
                'number' => $child->values['name'],
                'quantity' => $quantity,
            );

            $dataCars['quantity'] += $quantity;
        }

        $viewObject = 'ab1/_report/'.$this->_sitePageData->languageID.'/move/empty/list';
        $tmp = str_replace('\\', '/', $viewObject);
        try {
            $view = View::factory($tmp);
        }catch (Exception $e) {
            throw new Exception('Шаблон "'.$tmp.'" не найден.');
        }

        $view->cars = $dataCars;
        $view->dateFrom = $dateFrom;
        $view->dateTo = $dateTo;
        $view->operation = $this->_sitePageData->operation->getValues();
        $view->shop = $this->_sitePageData->shop->getName();
        $view->shopOptions = $this->_sitePageData->shop->getOptionsArray();
        $strView = Helpers_View::viewToStr($view);

        header('Content-Type: application/x-download;charset=UTF-8');
        // header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: filename="ВС17 Пустые машины за период ' . Helpers_DateTime::getPeriodRus($dateFrom, $dateTo) . '.xml"');
        header('Cache-Control: max-age=0');

        echo $strView;
        exit();
    }

    /**
     * Отчет прочие машины
     * @throws Exception
     */
    public function action_move_other_list() {
        set_time_limit(36000);

        $this->_sitePageData->url = '/'.$this->actionURLName.'/shopreport/move_other_list';

        // задаем время выборки
        $dateFrom = Request_RequestParams::getParamDateTime('created_at_from');
        $dateTo = Request_RequestParams::getParamDateTime('created_at_to');

        $params = array(
            'created_at_from' => $dateFrom,
            'created_at_to' => $dateTo,
            'shop_material_other_id' => Request_RequestParams::getParamInt('shop_material_other_id'),
            'shop_material_id' => Request_RequestParams::getParamInt('shop_material_id'),
            'sort_by' => array(
                'created_at' => 'asc'
            ),
        );

        $params = Request_RequestParams::setParams(
            $params
        );
        $ids = Request_Request::find('DB_Ab1_Shop_Move_Other',
            $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB,
            $params, 0, TRUE,
            array(
                'shop_move_place_id' => array('name'),
                'shop_material_id' => array('name'),
                'shop_material_other_id' => array('name'),
                'shop_transport_company_id' => array('name'),
                'weighted_exit_operation_id' => array('name')
            )
        );

        $dataCars = array(
            'data' => array(),
            'quantity' => 0
        );
        foreach ($ids->childs as $child){
            $quantity = $child->values['quantity'];

            $dataCars['data'][] = array(
                'weighted_exit_at' => $child->values['weighted_exit_at'],
                'shop_move_place_name' => $child->getElementValue('shop_move_place_id'),
                'shop_transport_company_name' => $child->getElementValue('shop_transport_company_id'),
                'shop_material_name' => $child->getElementValue('shop_material_other_id', 'name', $child->getElementValue('shop_material_id')),
                'number' => $child->values['name'],
                'quantity' => $quantity,
            );

            $dataCars['quantity'] += $quantity;
        }

        $viewObject = 'ab1/_report/'.$this->_sitePageData->languageID.'/move/other/list';
        $tmp = str_replace('\\', '/', $viewObject);
        try {
            $view = View::factory($tmp);
        }catch (Exception $e) {
            throw new Exception('Шаблон "'.$tmp.'" не найден.');
        }

        $view->cars = $dataCars;
        $view->dateFrom = $dateFrom;
        $view->dateTo = $dateTo;
        $view->operation = $this->_sitePageData->operation->getValues();
        $view->shop = $this->_sitePageData->shop->getName();
        $view->shopOptions = $this->_sitePageData->shop->getOptionsArray();
        $strView = Helpers_View::viewToStr($view);

        header('Content-Type: application/x-download;charset=UTF-8');
        // header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: filename="ВС13 Прочие машины за период ' . Helpers_DateTime::getPeriodRus($dateFrom, $dateTo) . '.xml"');
        header('Cache-Control: max-age=0');

        echo $strView;
        exit();
    }

    /*
     * Отчет по поступлению денежных средств по фискальному регистратору
     */
    public function action_payment_cashbox_days() {
        set_time_limit(36000);

        $this->_sitePageData->url = '/'.$this->actionURLName.'/shopreport/payment_cashbox_days';

        $dateFrom = Request_RequestParams::getParamDate('created_at_from');
        $dateTo = Request_RequestParams::getParamDate('created_at_to').' 23:59:59';

        $shopCashboxID = Request_RequestParams::getParamInt('shop_cashbox_id');
        if($shopCashboxID > 0){
            $cashbox = new Model_Ab1_Shop_Cashbox();
            $cashbox->setDBDriver($this->_driverDB);
            if (!Helpers_DB::getDBObject($cashbox, $shopCashboxID, $this->_sitePageData, 0)) {
                throw new HTTP_Exception_500('Cashbox no found');
            }
        }else{
            /** @var Model_Ab1_Shop_Cashbox $cashbox */
            $cashbox = $this->_sitePageData->operation->getElement('shop_cashbox_id', true, $this->_sitePageData->shopMainID);
            if (empty($cashbox)) {
                throw new HTTP_Exception_500('Cashbox no found');
            }
        }

        $params = Request_RequestParams::setParams(
            array(
                'created_at_to' => $dateFrom,
                'sum_amount' => TRUE,
                'shop_cashbox_id' => $cashbox->id,
                'payment_type_id' => Model_Ab1_PaymentType::PAYMENT_TYPE_CASH,
            )
        );

        /** Сколько денег было прихода на начало **/
        $ids = Request_Request::findBranch('DB_Ab1_Shop_Payment',
            array(), $this->_sitePageData, $this->_driverDB, $params,0, TRUE
        );
        $total = 0;
        if(count($ids->childs) > 0){
            $total = $ids->childs[0]->values['amount'];
        }
        $totalPayment = $total;

        /** Сколько денег было возврата на начало **/
        $ids = Request_Request::findBranch('DB_Ab1_Shop_Payment_Return',
            array(), $this->_sitePageData, $this->_driverDB, $params,0, TRUE
        );
        if(count($ids->childs) > 0){
            $total -= $ids->childs[0]->values['amount'];
        }

        /** Сколько денег было расхода на начало **/
        $ids = Request_Request::findBranch('DB_Ab1_Shop_Consumable',
            array(), $this->_sitePageData, $this->_driverDB, $params,0, TRUE
        );
        if(count($ids->childs) > 0){
            $total -= $ids->childs[0]->values['amount'];
        }

        /** Сколько денег было приход денег на начало **/
       /* $ids = Request_Request::find('DB_Ab1_Shop_Coming_Money',
            $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB, $params,0, TRUE
        );
        if(count($ids->childs) > 0){
            $total += $ids->childs[0]->values['amount'];
        }*/

        /** Группировка по дням **/
        $params = Request_RequestParams::setParams(
            array(
                'created_at_from_equally' => $dateFrom,
                'created_at_to' => $dateTo,
                'sum_amount' => TRUE,
                'shop_cashbox_id' => $cashbox->id,
                'count_id' => TRUE,
                'group_by' => array(
                    'created_at_date',
                    'payment_type_id',
                ),
                'sort_by' => array(
                    'created_at_date' => 'asc',
                ),
            )
        );

        /** Группировка по дням оплаты **/
        $ids = Request_Request::findBranch('DB_Ab1_Shop_Payment',
            array(), $this->_sitePageData, $this->_driverDB, $params,0, TRUE
        );

        $dataDates = array(
            'data' => array(),
            'cash' => 0,
            'card' => 0,
            'payment_count' => 0,
            'return_cash' => 0,
            'return_card' => 0,
            'consumable' => 0,
            'coming_money' => 0,
        );
        foreach ($ids->childs as $child){
            $date = Helpers_DateTime::getDateFormatPHP($child->values['created_at_date']);
            $amount = $child->values['amount'];
            $count = $child->values['count'];

            if(!key_exists($date, $dataDates['data'])){
                $dataDates['data'][$date] = array(
                    'date' => $date,
                    'from' => 0,
                    'from_all' => 0,
                    'cash' => 0,
                    'card' => 0,
                    'payment_count' => 0,
                    'return_cash' => 0,
                    'return_card' => 0,
                    'consumable' => 0,
                    'coming_money' => 0,
                );
            }

            switch ($child->values['payment_type_id']){
                case Model_Ab1_PaymentType::PAYMENT_TYPE_BANK_CARD:
                    $dataDates['data'][$date]['card'] += $amount;
                    $dataDates['card'] += $amount;
                    break;
                default:
                    $dataDates['data'][$date]['cash'] += $amount;
                    $dataDates['cash'] += $amount;
                    break;
            }

            $dataDates['data'][$date]['payment_count'] += $count;
            $dataDates['payment_count'] += $count;
        }

        /** Группировка по дням расходники **/
        $ids = Request_Request::findBranch('DB_Ab1_Shop_Consumable',
            array(), $this->_sitePageData, $this->_driverDB, $params,0, TRUE
        );
        foreach ($ids->childs as $child){
            $date = Helpers_DateTime::getDateFormatPHP($child->values['created_at_date']);
            $amount = $child->values['amount'];

            if(!key_exists($date, $dataDates['data'])){
                $dataDates['data'][$date] = array(
                    'date' => $date,
                    'from' => 0,
                    'from_all' => 0,
                    'cash' => 0,
                    'card' => 0,
                    'payment_count' => 0,
                    'return_cash' => 0,
                    'return_card' => 0,
                    'consumable' => 0,
                    'coming_money' => 0,
                );
            }
            $dataDates['data'][$date]['consumable'] += $amount;
            $dataDates['consumable'] += $amount;
        }

        /** Группировка по дням приходники **/
        /*$ids = Request_Request::find('DB_Ab1_Shop_Coming_Money',
            $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB, $params,0, TRUE
        );
        foreach ($ids->childs as $child){
            $date = Helpers_DateTime::getDateFormatPHP($child->values['created_at_date']);
            $amount = $child->values['amount'];

            if(!key_exists($date, $dataDates['data'])){
                $dataDates['data'][$date] = array(
                    'date' => $date,
                    'from' => 0,
                    'from_all' => 0,
                    'cash' => 0,
                    'card' => 0,
                    'payment_count' => 0,
                    'return_cash' => 0,
                    'return_card' => 0,
                    'consumable' => 0,
                    'coming_money' => 0,
                );
            }
            $dataDates['data'][$date]['coming_money'] += $amount;
            $dataDates['coming_money'] += $amount;
        }*/

        /** Группировка по дням возврата **/
        $ids = Request_Request::findBranch('DB_Ab1_Shop_Payment_Return',
            array(), $this->_sitePageData, $this->_driverDB, $params,0, TRUE
        );
        foreach ($ids->childs as $child){
            $date = Helpers_DateTime::getDateFormatPHP($child->values['created_at_date']);
            $amount = $child->values['amount'];

            if(!key_exists($date, $dataDates['data'])){
                $dataDates['data'][$date] = array(
                    'date' => $date,
                    'from' => 0,
                    'from_all' => 0,
                    'cash' => 0,
                    'card' => 0,
                    'payment_count' => 0,
                    'return_cash' => 0,
                    'return_card' => 0,
                    'consumable' => 0,
                    'coming_money' => 0,
                );
            }

            $dataDates['data'][$date]['return_cash'] += $amount;
            $dataDates['return_cash'] += $amount;
        }

        uasort($dataDates['data'], function ($x, $y) {
            return strcasecmp($x['date'], $y['date']);
        });

        foreach ($dataDates['data'] as &$child) {
            $child['from'] = $total;
            $total = $total + $child['cash'] - $child['return_cash'] - $child['consumable'];

            $child['from_payment'] = $totalPayment;
            $totalPayment = $totalPayment + $child['cash'] + $child['card'];
        }

        $viewObject = 'ab1/_report/'.$this->_sitePageData->languageID.'/payment/cashbox-days';
        $tmp = str_replace('\\', '/', $viewObject);
        try {
            $view = View::factory($tmp);
        }catch (Exception $e) {
            throw new Exception('Шаблон "'.$tmp.'" не найден.');
        }

        $view->dates = $dataDates;
        $view->dateFrom = $dateFrom;
        $view->dateTo = $dateTo;
        $view->operation = $this->_sitePageData->operation->getValues();
        $view->shop = $this->_sitePageData->shop->getName();
        $view->shopOptions = $this->_sitePageData->shop->getOptionsArray();
        $strView = Helpers_View::viewToStr($view);

        header('Content-Type: application/x-download;charset=UTF-8');
        // header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="КА01 Отчет по поступлению денежных средств по фискальному регистратору за период '.Helpers_DateTime::getDateFormatRus($dateFrom).'-'.Helpers_DateTime::getDateFormatRus($dateTo).'.xml"');
        header('Cache-Control: max-age=0');

        echo $strView;
        exit();
    }

    /**
     * С9 - Реестр накладных
     * @throws Exception
     */
    public function action_invoice_list() {
        set_time_limit(36000);

        $this->_sitePageData->url = '/'.$this->actionURLName.'/shopreport/invoice_list';

        $dateFrom = Request_RequestParams::getParamDate('date_from');
        $dateTo = Request_RequestParams::getParamDate('date_to');

        // Список накладная
        $params = Request_RequestParams::setParams(
            array(
                'date_from_equally' => $dateFrom,
                'date_to' => Helpers_DateTime::plusDays($dateTo, 1),
                'empty_date_received_from_client' => false,
                'empty_date_give_to_bookkeeping' => true,
                'sort_by' => array(
                    'date' => 'asc',
                    'number' => 'asc',
                )
            )
        );
        $shopInvoiceIDs = Request_Request::find('DB_Ab1_Shop_Invoice',
            $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
            array(
                'shop_client_id' => array('name')
            )
        );

        $dataInvoices = array(
            'data' => array(),
            'amount_nds' => 0,
            'amount' => 0,
        );

        foreach ($shopInvoiceIDs->childs as $child){
            $dataInvoices['data'][] = array(
                'data' => array(),
                'number' => $child->values['number'],
                'date' => $child->values['date'],
                'client' => $child->getElementValue('shop_client_id'),
                'amount' => $child->values['amount'],
            );

            $dataInvoices['amount'] += $child->values['amount'];
        }

        uasort($dataInvoices['data'], function ($x, $y) {
            $result = strcasecmp($x['date'], $y['date']);
            if($result != 0){
                return $result;
            }

            return strcasecmp($x['number'], $y['number']);
        });

        // Список актов выполненных работ
        $params = Request_RequestParams::setParams(
            array(
                'date_from' => $dateFrom,
                'date_to' => Helpers_DateTime::plusDays($dateTo, 1),
                'empty_date_received_from_client' => false,
                'empty_date_give_to_bookkeeping' => true,
                'sort_by' => array(
                    'date' => 'asc',
                    'number' => 'asc',
                )
            )
        );
        $shopActIDs = Request_Request::find(
            DB_Ab1_Shop_Act_Service::NAME,
            $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
            array(
                'shop_client_id' => array('name')
            )
        );

        $dataActs = array(
            'data' => array(),
            'amount_nds' => 0,
            'amount' => 0,
        );

        foreach ($shopActIDs->childs as $child){
            $dataActs['data'][] = array(
                'data' => array(),
                'number' => $child->values['number'],
                'date' => $child->values['date'],
                'client' => $child->getElementValue('shop_client_id'),
                'amount' => $child->values['amount'],
            );

            $dataActs['amount'] += $child->values['amount'];
        }

        uasort($dataActs['data'], function ($x, $y) {
            $result = strcasecmp($x['date'], $y['date']);
            if($result != 0){
              return $result;
            }

            return strcasecmp($x['number'], $y['number']);
        });


        $viewObject = 'ab1/_report/'.$this->_sitePageData->languageID.'/invoice/list';
        $tmp = str_replace('\\', '/', $viewObject);
        try {
            $view = View::factory($tmp);
        }catch (Exception $e) {
            throw new Exception('Шаблон "'.$tmp.'" не найден.');
        }

        $view->invoices = $dataInvoices;
        $view->acts = $dataActs;
        $view->dateFrom = $dateFrom;
        $view->dateTo = $dateTo;
        $view->operation = $this->_sitePageData->operation->getValues();
        $view->shop = $this->_sitePageData->shop->getName();
        $view->shopOptions = $this->_sitePageData->shop->getOptionsArray();
        $strView = Helpers_View::viewToStr($view);

        header('Content-Type: application/x-download;charset=UTF-8');
        // header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: filename="СБ09 Реестр накладных c ' . Helpers_DateTime::getDateFormatRus($dateFrom) . ' по ' . Helpers_DateTime::getDateFormatRus($dateTo) . '.xml"');
        header('Cache-Control: max-age=0');

        echo $strView;
        exit();
    }
/**
     * С14- Невыданные накладных
     * @throws Exception
     */
    public function action_invoice_list_not_give() {
        set_time_limit(36000);

        $this->_sitePageData->url = '/'.$this->actionURLName.'/shopreport/invoice_list_not_give';

        $dateFrom = Request_RequestParams::getParamDate('date_from');
        $dateTo = Request_RequestParams::getParamDate('date_to');

        $shopOrganizationTypeIDs = Request_RequestParams::getParamArray('organization_ids');

        // Список накладная
        $params = Request_RequestParams::setParams(
            array(
                'shop_client_id.organization_id' => $shopOrganizationTypeIDs,
                'date_from_equally' => $dateFrom,
                'date_to' => Helpers_DateTime::plusDays($dateTo, 1),
                'date_give_to_client_empty' => true,
                'sort_by' => array(
                    'date_give_to_client' => 'desc',
                )
            )
        );
        $shopInvoiceIDs = Request_Request::find('DB_Ab1_Shop_Invoice',
            $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
            array(
                'shop_client_id' => array('name'),
            )
        );

        $dataInvoices = array(
            'data' => array(),
            'amount_nds' => 0,
            'amount' => 0,
        );
        foreach ($shopInvoiceIDs->childs as $child){
            if ( $child->values['date_give_to_client'] == '') {
                $dataInvoices['data'][] = array(
                    'data' => array(),
                    'number' => $child->values['number'],
                    'date' => $child->values['date'],
                    'client' => $child->getElementValue('shop_client_id'),
                    'amount' => $child->values['amount'],
                );
                $dataInvoices['amount'] += $child->values['amount'];
            }
        }

        uasort($dataInvoices['data'], function ($x, $y) {
            $result = strcasecmp($x['date'], $y['date']);
            if($result != 0){
                return $result;
            }

            return strcasecmp($x['number'], $y['number']);
        });

        $viewObject = 'ab1/_report/'.$this->_sitePageData->languageID.'/invoice/not-give';
        $tmp = str_replace('\\', '/', $viewObject);
        try {
            $view = View::factory($tmp);
        }catch (Exception $e) {
            throw new Exception('Шаблон "'.$tmp.'" не найден.');
        }

        $view->invoices = $dataInvoices;
        $view->dateFrom = $dateFrom;
        $view->dateTo = $dateTo;
        $view->operation = $this->_sitePageData->operation->getValues();
        $view->shop = $this->_sitePageData->shop->getName();
        $view->shopOptions = $this->_sitePageData->shop->getOptionsArray();
        $strView = Helpers_View::viewToStr($view);

        header('Content-Type: application/x-download;charset=UTF-8');
        // header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: filename="СБ14 Список невыданных накладных c ' . Helpers_DateTime::getDateFormatRus($dateFrom) . ' по ' . Helpers_DateTime::getDateFormatRus($dateTo) . '.xml"');
        header('Cache-Control: max-age=0');

        echo $strView;
        exit();
    }

    /*
     * Касса за период
     */
    public function action_payment_cashbox() {
        set_time_limit(36000);

        $this->_sitePageData->url = '/'.$this->actionURLName.'/shopreport/payment_cashbox';

        $dateFrom = Request_RequestParams::getParamDate('created_at_from');
        $dateTo = Request_RequestParams::getParamDate('created_at_to');
        if($dateTo !== null){
            $dateTo = Helpers_DateTime::plusDays($dateTo, 1);
        }

        $shopCashboxID = Request_RequestParams::getParamInt('shop_cashbox_id');
        if($shopCashboxID < 1) {
            $shopCashboxID = $this->_sitePageData->operation->getShopCashboxID();
        }

        $modelCashbox = new Model_Ab1_Shop_Cashbox();
        $modelCashbox->setDBDriver($this->_driverDB);
        if(!Helpers_DB::getDBObject($modelCashbox, $shopCashboxID, $this->_sitePageData, 0)){
            throw new HTTP_Exception_500('Cashbox not found.');
        }

        $params = Request_RequestParams::setParams(
            array(
                'created_at_from' => $dateFrom,
                'created_at_to' => $dateTo,
                'shop_cashbox_id' => $shopCashboxID,
                'payment_type_id' => Model_Ab1_PaymentType::PAYMENT_TYPE_CASH,
            )
        );

        // ПКО
        $ids = Request_Request::findBranch('DB_Ab1_Shop_Payment',
            array(), $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
            array(
                'shop_client_id' => array('name'),
            )
        );

        $paymentCount = count($ids->childs);

        $dataPayments = array(
            'data' => array(),
            'coming' => 0,
            'expense' => 0,
            'from_coming' => 0,
            'from_expense' => 0,
            'to_coming' => 0,
            'to_expense' => 0,
        );
        foreach ($ids->childs as $child){
            $amount = $child->values['amount'];

            $dataPayments['data'][] = array(
                'name' => 'Приходный кассовый ордер '. $child->values['number'] .' ('.Helpers_DateTime::getDateFormatRus($child->values['created_at']).')',
                'client' => $child->getElementValue('shop_client_id'),
                'date' => $child->values['created_at'],
                'coming' => $amount,
                'expense' => 0,
            );

            $dataPayments['coming'] += $amount;
        }

        // Возврат
        $ids = Request_Request::findBranch('DB_Ab1_Shop_Payment_Return',
            array(), $this->_sitePageData, $this->_driverDB, $params,0, TRUE,
            array(
                'shop_client_id' => array('name'),
            )
        );
        $consumableCount = count($ids->childs);

        foreach ($ids->childs as $child){
            $amount = $child->values['amount'];

            $dataPayments['data'][] = array(
                'name' => 'Возврат '. $child->values['number'],
                'client' => $child->getElementValue('shop_client_id'),
                'date' => $child->values['created_at'],
                'coming' => 0,
                'expense' => $amount,
            );

            $dataPayments['expense'] += $amount;
        }

        // Расходники
        $ids = Request_Request::findBranch('DB_Ab1_Shop_Consumable',
            array(), $this->_sitePageData, $this->_driverDB, $params,0, TRUE
        );
        $consumableCount += count($ids->childs);

        foreach ($ids->childs as $child){
            $amount = $child->values['amount'];

            $dataPayments['data'][] = array(
                'name' => 'Расходный кассовый ордер '. $child->values['number'] .' ('.Helpers_DateTime::getDateFormatRus($child->values['created_at']).')',
                'client' => $child->values['base'],
                'date' => $child->values['created_at'],
                'coming' => 0,
                'expense' => $amount,
            );

            $dataPayments['expense'] += $amount;
        }

        // Приходники
        /*$ids = Request_Request::find('DB_Ab1_Shop_Coming_Money',
            $modelCashbox->shopID, $this->_sitePageData, $this->_driverDB, $params,0, TRUE
        );
        foreach ($ids->childs as $child){
            $amount = $child->values['amount'];

            $dataPayments['data'][] = array(
                'name' => 'РКО '. $child->values['number'],
                'client' => $child->values['base'],
                'date' => $child->values['created_at'],
                'coming' => $amount,
                'expense' => 0,
            );

            $dataPayments['coming'] += $amount;
        }*/

        /** Первоначальные данные */
        $params = Request_RequestParams::setParams(
            array(
                'created_at_to' => $dateFrom,
                'shop_cashbox_id' => $shopCashboxID,
                'sum_amount' => true,
                'payment_type_id' => Model_Ab1_PaymentType::PAYMENT_TYPE_CASH,
            )
        );

        // ПКО
        $ids = Request_Request::findBranch('DB_Ab1_Shop_Payment',
            array(), $this->_sitePageData, $this->_driverDB, $params,0, TRUE
        );
        if(count($ids->childs)){
            $dataPayments['from_coming'] += $ids->childs[0]->values['amount'];
        }

        // Возврат
        $ids = Request_Request::findBranch('DB_Ab1_Shop_Payment_Return',
            array(), $this->_sitePageData, $this->_driverDB, $params,0, TRUE
        );
        if(count($ids->childs)){
            $dataPayments['from_expense'] += $ids->childs[0]->values['amount'];
        }

        // Расходники
        $ids = Request_Request::findBranch('DB_Ab1_Shop_Consumable',
            array(), $this->_sitePageData, $this->_driverDB, $params,0, TRUE
        );
        if(count($ids->childs)){
            $dataPayments['from_expense'] += $ids->childs[0]->values['amount'];
        }

        // Приходники
        /*$ids = Request_Request::find('DB_Ab1_Shop_Coming_Money',
            $modelCashbox->shopID, $this->_sitePageData, $this->_driverDB, $params,0, TRUE
        );
        if(count($ids->childs)){
            $dataPayments['from_coming'] += $ids->childs[0]->values['amount'];
        }*/

        if($dataPayments['from_expense'] > $dataPayments['from_coming']){
            $dataPayments['from_expense'] -= $dataPayments['from_coming'];
            $dataPayments['from_coming'] = 0;
        }else{
            $dataPayments['from_coming'] -= $dataPayments['from_expense'];
            $dataPayments['from_expense'] = 0;
        }

        $dataPayments['to_coming'] = $dataPayments['from_coming'] + $dataPayments['coming'];
        $dataPayments['to_expense'] = $dataPayments['from_expense'] + $dataPayments['expense'];

        if($dataPayments['to_expense'] > $dataPayments['to_coming']){
            $dataPayments['to_expense'] -= $dataPayments['to_coming'];
            $dataPayments['to_coming'] = 0;
        }else{
            $dataPayments['to_coming'] -= $dataPayments['to_expense'];
            $dataPayments['to_expense'] = 0;
        }

        uasort($dataPayments['data'], function ($x, $y) {
            return strcasecmp($x['date'], $y['date']);
        });

        $viewObject = 'ab1/_report/'.$this->_sitePageData->languageID.'/payment/cashbox';
        $tmp = str_replace('\\', '/', $viewObject);
        try {
            $view = View::factory($tmp);
        }catch (Exception $e) {
            throw new Exception('Шаблон "'.$tmp.'" не найден.');
        }

        $view->payments = $dataPayments;
        $view->dateFrom = $dateFrom;
        $view->dateTo = Helpers_DateTime::minusDays($dateTo, 1);
        $view->paymentCount = $paymentCount;
        $view->consumableCount = $consumableCount;
        $view->cashbox = $modelCashbox->getName();
        $view->siteData = $this->_sitePageData;
        $view->operation = $this->_sitePageData->operation->getName();
        $view->shop = $this->_sitePageData->shop->getName();
        $view->shopOptions = $this->_sitePageData->shop->getOptionsArray();
        $strView = Helpers_View::viewToStr($view);

        header('Content-Type: application/x-download;charset=UTF-8');
        // header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="МС01 Кассовая книга за период с '.Helpers_DateTime::getDateFormatRus($dateFrom, true).' по '.Helpers_DateTime::getDateFormatRus($dateTo, true).'.xml"');
        header('Cache-Control: max-age=0');

        echo $strView;
        exit();
    }

    /**
     * Возвращаем список реализации
     */
    public function action_car_list() {
        set_time_limit(36000);

        $this->_sitePageData->url = '/'.$this->actionURLName.'/shopreport/car_list';

        $shopCarIDs = Request_Request::find('DB_Ab1_Shop_Car',
            $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB, array(), 200, TRUE,
            array(
                'shop_client_id' => array('name'),
                'shop_product_id' => array('name'),
                'shop_driver_id' => array('name'),
                'shop_turn_place_id' => array('name'),
            )
        );

        $viewObject = 'ab1/_report/'.$this->_sitePageData->languageID.'/car/list';
        $tmp = str_replace('\\', '/', $viewObject);
        try {
            $view = View::factory($tmp);
        }catch (Exception $e) {
            throw new Exception('Шаблон "'.$tmp.'" не найден.');
        }

        $view->cars = $shopCarIDs->childs;
        $view->currency = $this->_sitePageData->currency;
        $view->operation = $this->_sitePageData->operation->getValues();
        $view->shop = $this->_sitePageData->shop->getName();
        $view->shopOptions = $this->_sitePageData->shop->getOptionsArray();
        $strView = Helpers_View::viewToStr($view);

        header('Content-Type: application/x-download;charset=UTF-8');
        // header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: filename="Список ЖБИ и БС.xml"');
        header('Cache-Control: max-age=0');

        echo $strView;
        exit();
    }

    /**
     * Возвращаем список реализации
     */
    public function action_piece_list() {
        set_time_limit(36000);

        $this->_sitePageData->url = '/'.$this->actionURLName.'/shopreport/piece_list';

        $shopPieceIDs = Request_Request::find('DB_Ab1_Shop_Piece',
            $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB, array(), 200, TRUE,
            array(
                'shop_client_id' => array('name'),
                'shop_driver_id' => array('name'),
                'shop_turn_place_id' => array('name'),
            )
        );

        $viewObject = 'ab1/_report/'.$this->_sitePageData->languageID.'/piece/list';
        $tmp = str_replace('\\', '/', $viewObject);
        try {
            $view = View::factory($tmp);
        }catch (Exception $e) {
            throw new Exception('Шаблон "'.$tmp.'" не найден.');
        }

        $view->cars = $shopPieceIDs->childs;
        $view->currency = $this->_sitePageData->currency;
        $view->operation = $this->_sitePageData->operation->getValues();
        $view->shop = $this->_sitePageData->shop->getName();
        $view->shopOptions = $this->_sitePageData->shop->getOptionsArray();
        $strView = Helpers_View::viewToStr($view);

        header('Content-Type: application/x-download;charset=UTF-8');
        // header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: filename="Список реализации.xml"');
        header('Cache-Control: max-age=0');

        echo $strView;
        exit();
    }

    /**
     * С1 - Реестр банковских документов
     * @throws Exception
     */
    public function action_act_revise_registry_payment() {
        set_time_limit(36000);

        $this->_sitePageData->url = '/'.$this->actionURLName.'/shopreport/act_revise_registry_payment';

        $dateFrom = Request_RequestParams::getParamDate('date_from');
        $dateTo = Request_RequestParams::getParamDate('date_to').' 23:59:59';

        /** Акт сверки ПЛАТЕЖИ ПО БАНКУ **/
        $params = Request_RequestParams::setParams(
            array(
                'name_full' => Model_Ab1_ActReviseType::BANK_PAYMENT,
                'date_from_equally' => $dateFrom,
                'date_to' => $dateTo,
                'shop_client_id.is_buyer' => true,
                'is_receive' => true,
            )
        );
        $shopActReviseItemIDs = Request_Request::findBranch('DB_Ab1_Shop_Act_Revise_Item',
            array(), $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
            array('shop_client_id' => array('name'))
        );

        $dataActRevises = array(
            'data' => array(),
            'amount' => 0,
        );
        foreach ($shopActReviseItemIDs->childs as $child){
            $amount = $child->values['amount'];
            $dataActRevises['data'][] = array(
                'date' => $child->values['date'],
                'name' => $child->getElementValue('shop_client_id'),
                'amount' => $amount,
                'text' => $child->values['text'],
            );

            $dataActRevises['amount'] += $amount;
        }

        $viewObject = 'ab1/_report/'.$this->_sitePageData->languageID.'/act-revise/registry-payment';
        $tmp = str_replace('\\', '/', $viewObject);
        try {
            $view = View::factory($tmp);
        }catch (Exception $e) {
            throw new Exception('Шаблон "'.$tmp.'" не найден.');
        }

        $view->actRevises = $dataActRevises;
        $view->dateFrom = $dateFrom;
        $view->dateTo = $dateTo;
        $view->operation = $this->_sitePageData->operation->getValues();
        $view->shop = $this->_sitePageData->shop->getName();
        $view->shopOptions = $this->_sitePageData->shop->getOptionsArray();
        $view->siteData = $this->_sitePageData;
        $strView = Helpers_View::viewToStr($view);

        header('Content-Type: application/x-download;charset=UTF-8');
        // header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: filename="СБ01 Реестр банковских документов c '.Helpers_DateTime::getDateFormatRus($dateFrom) . ' по ' . Helpers_DateTime::getDateFormatRus($dateTo).'.xml"');
        header('Cache-Control: max-age=0');

        echo $strView;
        exit();
    }

    /**
     * Счет на оплату
     * @throws Exception
     */
    public function action_invoice_proforma_one() {
        set_time_limit(36000);

        $this->_sitePageData->url = '/'.$this->actionURLName.'/shopreport/invoice_proforma_one';

        $shopInvoiceProformaID = Request_RequestParams::getParamInt('shop_invoice_proforma_id');

        $model = new Model_Ab1_Shop_Invoice_Proforma();
        $model->setDBDriver($this->_driverDB);
        if(!Helpers_DB::getDBObject($model, $shopInvoiceProformaID, $this->_sitePageData, $this->_sitePageData->shopID)){
            throw new HTTP_Exception_500('Invoice proforma not found.');
        }

        $shopInvoiceProformaItemIDs = Request_Request::find('DB_Ab1_Shop_Invoice_Proforma_Item',
            $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB,
            Request_RequestParams::setParams(
                array(
                    'shop_invoice_proforma_id' => $model->id,
                    'sort_by' => ['id' => 'asc']
                )
            ),
            0, TRUE,
            array(
                'shop_product_id' => array('name', 'unit'),
            )
        );

        $dataInvoiceItems = array(
            'data' => array(),
            'amount_nds' => 0,
            'amount' => 0,
        );

        foreach ($shopInvoiceProformaItemIDs->childs as $child){
            $amount = $child->values['amount'];
            $amountNDS = round($amount / 112 * 12, 2);

            $dataInvoiceItems['data'][] = array(
                'name' => $child->getElementValue('shop_product_id'),
                'unit' => $child->getElementValue('shop_product_id', 'unit'),
                'price' => $child->values['price'],
                'quantity' => $child->values['quantity'],
                'amount_nds' => $amountNDS,
                'amount' => $amount,
            );

            $dataInvoiceItems['amount_nds'] += $amountNDS;
            $dataInvoiceItems['amount'] += $amount;
        }

        $viewObject = 'ab1/_report/'.$this->_sitePageData->languageID.'/invoice/proforma/one';
        $tmp = str_replace('\\', '/', $viewObject);
        try {
            $view = View::factory($tmp);
        }catch (Exception $e) {
            throw new Exception('Шаблон "'.$tmp.'" не найден.');
        }

        $view->invoiceItems = $dataInvoiceItems;
        $view->invoice = $model->getValues();

        $client = $model->getElement('shop_client_id', TRUE);
        if($client == null){
            $view->client = array();
        }else {
            $view->client = $client->getValues();
        }

        $contract = $model->getElement('shop_client_contract_id', TRUE);
        if($contract == null){
            $view->contract = array();
        }else {
            $view->contract = $contract->getValues();
        }
        $view->operation = $this->_sitePageData->operation->getValues();
        $view->shop = $this->_sitePageData->shop->getName();
        $view->shopOptions = $this->_sitePageData->shop->getOptionsArray();
        $view->siteData = $this->_sitePageData;
        $strView = Helpers_View::viewToStr($view);

        header('Content-Type: application/x-download;charset=UTF-8');
        // header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: filename="Счет на оплату №' . $model->getNumber() . '.xml"');
        header('Cache-Control: max-age=0');

        echo $strView;
        exit();
    }

    /**
     * С6 - Отчет по дням
     * @throws Exception
     */
    public function action_invoice_client() {
        set_time_limit(36000);

        $this->_sitePageData->url = '/'.$this->actionURLName.'/shopreport/invoice_client';

        $dateFrom = Request_RequestParams::getParamDate('date_from');
        if($dateFrom === null){
            $dateFrom = Request_RequestParams::getParamDate('date_from_equally');
        }
        $dateTo = Request_RequestParams::getParamDate('date_to').' 23:59:59';

        $shopClientID = Request_RequestParams::getParamInt('shop_client_id');

        $model = new Model_Ab1_Shop_Client();
        $model->setDBDriver($this->_driverDB);
        if(!Helpers_DB::getDBObject($model, $shopClientID, $this->_sitePageData, $this->_sitePageData->shopMainID)){
            throw new HTTP_Exception_500('Client not found.');
        }

        // Список накладная
        $params = Request_RequestParams::setParams(
            array(
                'date_from_equally' => $dateFrom,
                'date_to' => $dateTo,
                'shop_client_id' => $shopClientID,
                'sort_by' => array(
                    'date' => 'asc',
                )
            )
        );
        $shopInvoiceIDs = Request_Request::findBranch('DB_Ab1_Shop_Invoice',
            array(), $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
            array('shop_id' => array('name'))
        );

        // Список товаров накладных
        $arr = $shopInvoiceIDs->getChildArrayID();
        if(!empty($arr)){
            $params = Request_RequestParams::setParams(
                array(
                    'shop_invoice_id' => $arr,
                )
            );
            $shopCarItemIDs = Request_Request::findBranch('DB_Ab1_Shop_Car_Item',
                array(), $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
                array('shop_product_id' => array('name'))
            );

            $shopPieceItemIDs = Request_Request::findBranch('DB_Ab1_Shop_Piece_Item',
                array(), $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
                array('shop_product_id' => array('name'))
            );

            $shopCarItemIDs->childs = array_merge($shopCarItemIDs->childs, $shopPieceItemIDs->childs);
        }else{
            $shopCarItemIDs = new MyArray();
        }

        $dataInvoices = array(
            'data' => array(),
            'amount_nds' => 0,
            'amount' => 0,
            'quantity' => 0,
        );

        foreach ($shopInvoiceIDs->childs as $child){
            $dataInvoices['data'][$child->id] = array(
                'data' => array(),
                'number' => $child->values['number'],
                'date' => $child->values['date'],
                'shop' => $child->getElementValue('shop_id'),
                'amount_nds' => 0,
                'amount' => 0,
                'quantity' => 0,
            );

            foreach ($shopCarItemIDs->childs as $key => $item) {
                if ($item->values['shop_invoice_id'] == $child->id) {
                    $product = $item->values['shop_product_id'] . '_' . $item->values['price'];
                    $quantity = $item->values['quantity'];

                    $amount = $item->values['amount'];
                    $amountNDS = round($amount / 112 * 12, 2);

                    if (!key_exists($product, $dataInvoices['data'][$child->id]['data'])) {
                        $dataInvoices['data'][$child->id]['data'][$product] = array(
                            'data' => array(),
                            'name' => $item->getElementValue('shop_product_id'),
                            'price' => $item->values['price'],
                            'quantity' => 0,
                            'amount_nds' => 0,
                            'amount' => 0,
                        );
                    }

                    $dataInvoices['data'][$child->id]['data'][$product]['quantity'] += $quantity;
                    $dataInvoices['data'][$child->id]['data'][$product]['amount'] += $amount;
                    $dataInvoices['data'][$child->id]['data'][$product]['amount_nds'] += $amountNDS;

                    $dataInvoices['data'][$child->id]['amount'] += $amount;
                    $dataInvoices['data'][$child->id]['amount_nds'] += $amountNDS;
                    $dataInvoices['data'][$child->id]['quantity'] += $quantity;

                    $dataInvoices['amount'] += $amount;
                    $dataInvoices['amount_nds'] += $amountNDS;
                    $dataInvoices['quantity'] += $quantity;

                    unset($shopCarItemIDs->childs[$key]);
                }
            }
        }

        $viewObject = 'ab1/_report/'.$this->_sitePageData->languageID.'/invoice/client';
        $tmp = str_replace('\\', '/', $viewObject);
        try {
            $view = View::factory($tmp);
        }catch (Exception $e) {
            throw new Exception('Шаблон "'.$tmp.'" не найден.');
        }

        $view->invoices = $dataInvoices;
        $view->dateFrom = $dateFrom;
        $view->dateTo = $dateTo;
        $view->client = $model->getName();
        $view->operation = $this->_sitePageData->operation->getValues();
        $view->shop = $this->_sitePageData->shop->getName();
        $view->shopOptions = $this->_sitePageData->shop->getOptionsArray();
        $strView = Helpers_View::viewToStr($view);

        header('Content-Type: application/x-download;charset=UTF-8');
        // header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: filename="СБ06 Отчет по накладным по дням '.str_replace('"', '', $model->getName()).' c ' . Helpers_DateTime::getDateFormatRus($dateFrom) . ' по ' . Helpers_DateTime::getDateFormatRus($dateTo) . '.xml"');
        header('Cache-Control: max-age=0');

        echo $strView;
        exit();
    }

    /**
     * С2 - Дебиторы и кредиторы
     * @throws Exception
     */
    public function action_client_debtor_creditor() {
        set_time_limit(36000);

        $this->_sitePageData->url = '/'.$this->actionURLName.'/shopreport/client_debtor_creditor';

        $date = Request_RequestParams::getParamDateTime('date');
        $shopClientID = Request_RequestParams::getParamInt('shop_client_id');
        if($date == null){
            // баланс на текущий момент времени
            $params = Request_RequestParams::setParams(
                array(
                    'amount_not_equally' => 0,
                    'id' => $shopClientID,
                    'is_buyer' => true,
                    'sort_by' => array(
                        'name' => 'asc',
                    )
                )
            );
            $shopClientIDs = Request_Request::find('DB_Ab1_Shop_Client',
                $this->_sitePageData->shopMainID, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE
            );
            $date = date('Y-m-d');
        }else{
            $shopClientIDs = Api_Ab1_Shop_Client::calcBalanceClientsOnDate(
                $date, $this->_sitePageData, $this->_driverDB, $shopClientID
            );

            $shopClientIDs = $shopClientIDs->findChildren(array('is_buyer' => 1));
        }

        // исключаем клиентов с нулевым балансом
        foreach ($shopClientIDs->childs as $key => $child){
            if($child->values['balance'] == 0){
                unset($shopClientIDs->childs[$key]);
            }
        }

        //  исключаем клиентов, которые не имею договора
        if(Request_RequestParams::getParamBoolean('is_contract') && count($shopClientIDs->childs) > 0){

            $params = Request_RequestParams::setParams(
                array(
                    'shop_client_id' => $shopClientIDs->getChildArrayID(),
                    'date' => $date,
                    'client_contract_type_id' => Model_Ab1_ClientContract_Type::CLIENT_CONTRACT_TYPE_SALE_PRODUCT,
                    'group_by' => array(
                        'shop_client_id',
                    )
                )
            );
            $shopClientContractIDs = Request_Request::find('DB_Ab1_Shop_Client_Contract',
                $this->_sitePageData->shopMainID, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE
            );
            $shopClients = $shopClientContractIDs->getChildArrayInt('shop_client_id', true);
            foreach ($shopClientIDs->childs as $key => $child){
                if(!key_exists($child->id, $shopClients)){
                    unset($shopClientIDs->childs[$key]);
                }
            }
        }

        $dataClients = array(
            'data' => array(),
            'receive' => 0,
            'expense' => 0,
        );

        foreach ($shopClientIDs->childs as $child){
            $amount = $child->values['balance'];

            $dataClients['data'][$child->id] = array(
                'name' => $child->values['name'],
                'receive' => 0,
                'expense' => 0,
            );

            if($amount > 0){
                $dataClients['data'][$child->id]['receive'] = $amount;
                $dataClients['receive'] += $amount;
            }else{
                $amount = $amount * -1;
                $dataClients['data'][$child->id]['expense'] = $amount;
                $dataClients['expense'] += $amount;
            }
        }
        uasort($dataClients['data'], array($this, 'mySortMethod'));

        $viewObject = 'ab1/_report/'.$this->_sitePageData->languageID.'/client/debtor-creditor';
        $tmp = str_replace('\\', '/', $viewObject);
        try {
            $view = View::factory($tmp);
        }catch (Exception $e) {
            throw new Exception('Шаблон "'.$tmp.'" не найден.');
        }

        $view->clients = $dataClients;
        $view->operation = $this->_sitePageData->operation->getValues();
        $view->shop = $this->_sitePageData->shop->getName();
        $view->shopOptions = $this->_sitePageData->shop->getOptionsArray();
        $strView = Helpers_View::viewToStr($view);

        header('Content-Type: application/x-download;charset=UTF-8');
        // header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: filename="СБ02 Дебиторы и кредиторы на ' . date('d.m.Y') . '.xml"');
        header('Cache-Control: max-age=0');

        echo $strView;
        exit();
    }

    /**
     * С8 - АКТ СВЕРКИ
     * @throws Exception
     */
    public function action_act_revise_one() {
        set_time_limit(36000);

        $this->_sitePageData->url = '/'.$this->actionURLName.'/shopreport/act_revise_one';

        $dateFrom = Request_RequestParams::getParamDateTime('date_from');
        $dateTo = Request_RequestParams::getParamDateTime('date_to');
        if($dateTo !== null){
            $dateTo = Helpers_DateTime::minusSeconds(Helpers_DateTime::plusDays($dateTo, 1), 1);
        }
        $shopClientID = Request_RequestParams::getParamInt('shop_client_id');

        $model = new Model_Ab1_Shop_Client();
        $model->setDBDriver($this->_driverDB);
        if(!Helpers_DB::getDBObject($model, $shopClientID, $this->_sitePageData, $this->_sitePageData->shopMainID)){
            throw new HTTP_Exception_500('Client not found.');
        }

        $shopActReviseIDs = Api_Ab1_Shop_Act_Revise::getShopActRevises(
            $shopClientID, $dateFrom, $dateTo, $this->_sitePageData, $this->_driverDB,
            Request_RequestParams::getParamBoolean('is_add_virtual_invoice')
        );

        $viewObject = 'ab1/_report/'.$this->_sitePageData->languageID.'/act-revise/one';
        $tmp = str_replace('\\', '/', $viewObject);
        try {
            $view = View::factory($tmp);
        }catch (Exception $e) {
            throw new Exception('Шаблон "'.$tmp.'" не найден.');
        }

        $view->actRevises = $shopActReviseIDs;
        $view->dateFrom = $dateFrom;
        $view->dateTo = $dateTo;
        $view->client = $model->getValues();
        $view->operation = $this->_sitePageData->operation->getValues();
        $view->shop = $this->_sitePageData->shop->getName();
        $view->shopOptions = $this->_sitePageData->shop->getOptionsArray();
        $view->siteData = $this->_sitePageData;
        $strView = Helpers_View::viewToStr($view);

        header('Content-Type: application/x-download;charset=UTF-8');
        // header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: filename="С8 - АКТ СВЕРКИ '.Func::mb_str_replace('"', '', $model->getName()).' c '.Helpers_DateTime::getDateFormatRus($dateFrom) . ' по ' . Helpers_DateTime::getDateFormatRus($dateTo).'.xml"');
        header('Cache-Control: max-age=0');

        echo $strView;
        exit();
    }

    /**
     * С7 - Отчет по товарам клиента
     * @throws Exception
     */
    public function action_product_client_one() {
        set_time_limit(36000);

        $this->_sitePageData->url = '/'.$this->actionURLName.'/shopreport/product_client_one';

        $shopProductIDs = NULL;

        $dateFrom = Request_RequestParams::getParamDateTime('created_at_from');
        $dateTo = Request_RequestParams::getParamDateTime('created_at_to');
        $shopClientID = Request_RequestParams::getParamInt('shop_client_id');
        $isDelivery = Request_RequestParams::getParamBoolean('is_delivery');

        $client = '';
        if($shopClientID < 1){
            $shopClientID = NULL;
        }else{
            $model = new Model_Ab1_Shop_Client();
            $model->setDBDriver($this->_driverDB);
            if(Helpers_DB::getDBObject($model, $shopClientID, $this->_sitePageData, $this->_sitePageData->shopMainID)){
                $client = $model->getName();
            }
        }

        $isCharity = Request_RequestParams::getParamBoolean('is_charity') === TRUE;
        $params = Request_RequestParams::setParams(
            array(
                'exit_at_from' => $dateFrom,
                'exit_at_to' => $dateTo,
                'is_exit' => 1,
                'quantity_from' => 0,
                'shop_product_id' => $shopProductIDs,
                'is_charity' => $isCharity,
                'shop_client_id' => $shopClientID,
                'sum_amount' => TRUE,
                'sum_quantity' => TRUE,
                'group_by' => array(
                    'shop_product_id', 'shop_product_id.name',
                    'root_rubric_id.name', 'root_rubric_id.id', 'root_rubric_id.unit',
                    'shop_id', 'shop_id.name',

                )
            )
        );
        $elements = array(
            'shop_id' => array('name'),
            'shop_product_id' => array('name'),
            'root_rubric_id' => array('unit', 'name', 'id'),
        );

        $shopCarItemIDs = Request_Request::findBranch('DB_Ab1_Shop_Car_Item',
            array(), $this->_sitePageData, $this->_driverDB, $params, 0, TRUE, $elements
        );

        $pieceItemIDs = Request_Request::findBranch('DB_Ab1_Shop_Piece_Item',
            array(), $this->_sitePageData, $this->_driverDB, $params, 0, TRUE, $elements
        );
        $shopCarItemIDs->addChilds($pieceItemIDs);

        $dataRubrics = array(
            'data' => array(),
            'quantity' => 0,
            'amount' => 0,
        );

        foreach ($shopCarItemIDs->childs as $child){
            $quantity = $child->values['quantity'];
            $amount = $child->values['amount'];

            // родительная группа
            $shop = $child->values['shop_id'];
            if (! key_exists($shop, $dataRubrics['data'])){
                $dataRubrics['data'][$shop] = array(
                    'data' => array(),
                    'name' => $child->getElementValue('shop_id'),
                    'quantity' => 0,
                    'amount' => 0,
                );
            }

            // родительная группа
            $rubric = $child->getElementValue('root_rubric_id', 'id', 0);
            if (! key_exists($rubric, $dataRubrics['data'][$shop]['data'])){
                $dataRubrics['data'][$shop]['data'][$rubric] = array(
                    'data' => array(),
                    'name' => $child->getElementValue('root_rubric_id'),
                    'unit' => $child->getElementValue('root_rubric_id', 'unit'),
                    'quantity' => 0,
                    'amount' => 0,
                );
            }

            $product = $child->values['shop_product_id'];
            if (! key_exists($product, $dataRubrics['data'][$shop]['data'][$rubric]['data'])){
                $dataRubrics['data'][$shop]['data'][$rubric]['data'][$product] = array(
                    'data' => array(),
                    'name' => $child->getElementValue('shop_product_id'),
                    'quantity' => 0,
                    'amount' => 0,
                );
            }

            $dataRubrics['data'][$shop]['data'][$rubric]['data'][$product]['quantity'] += $quantity;
            $dataRubrics['data'][$shop]['data'][$rubric]['data'][$product]['amount'] += $amount;

            $dataRubrics['data'][$shop]['data'][$rubric]['quantity'] += $quantity;
            $dataRubrics['data'][$shop]['data'][$rubric]['amount'] += $amount;

            $dataRubrics['data'][$shop]['quantity'] += $quantity;
            $dataRubrics['data'][$shop]['amount'] += $amount;

            $dataRubrics['quantity'] += $quantity;
            $dataRubrics['amount'] += $amount;
        }

        // доставка
        if($isDelivery){
            $params = Request_RequestParams::setParams(
                array(
                    'exit_at_from' => $dateFrom,
                    'exit_at_to' => $dateTo,
                    'shop_delivery_id_from' => 0,
                    'is_exit' => 1,
                    'is_charity' => $isCharity,
                    'shop_client_id' => $shopClientID,
                    'sum_delivery_amount' => TRUE,
                    'sum_delivery_quantity' => TRUE,
                    'group_by' => array(
                        'shop_delivery_id', 'shop_delivery_id.name',
                        'shop_id', 'shop_id.name',

                    )
                )
            );
            $elements = array(
                'shop_id' => array('name'),
                'shop_delivery_id' => array('name'),
            );

            $shopCarIDs = Request_Request::findBranch('DB_Ab1_Shop_Car',
                array(), $this->_sitePageData, $this->_driverDB, $params, 0, TRUE, $elements
            );

            $pieceIDs = Request_Request::findBranch('DB_Ab1_Shop_Piece',
                array(), $this->_sitePageData, $this->_driverDB, $params, 0, TRUE, $elements
            );
            $shopCarIDs->addChilds($pieceIDs);

            foreach ($shopCarIDs->childs as $child){
                $quantity = $child->values['delivery_quantity'];
                $amount = $child->values['delivery_amount'];

                // родительная группа
                $shop = $child->values['shop_id'];
                if (! key_exists($shop, $dataRubrics['data'])){
                    $dataRubrics['data'][$shop] = array(
                        'data' => array(),
                        'name' => $child->getElementValue('shop_id'),
                        'quantity' => 0,
                        'amount' => 0,
                    );
                }

                // родительная группа
                $rubric = 'Доставка';
                if (! key_exists($rubric, $dataRubrics['data'][$shop]['data'])){
                    $dataRubrics['data'][$shop]['data'][$rubric] = array(
                        'data' => array(),
                        'name' => 'Доставка',
                        'unit' => 'км',
                        'quantity' => 0,
                        'amount' => 0,
                    );
                }

                $product = $child->values['shop_delivery_id'];
                if (! key_exists($product, $dataRubrics['data'][$shop]['data'][$rubric]['data'])){
                    $dataRubrics['data'][$shop]['data'][$rubric]['data'][$product] = array(
                        'data' => array(),
                        'name' => $child->getElementValue('shop_delivery_id'),
                        'quantity' => 0,
                        'amount' => 0,
                    );
                }

                $dataRubrics['data'][$shop]['data'][$rubric]['data'][$product]['quantity'] += $quantity;
                $dataRubrics['data'][$shop]['data'][$rubric]['data'][$product]['amount'] += $amount;

                $dataRubrics['data'][$shop]['data'][$rubric]['quantity'] += $quantity;
                $dataRubrics['data'][$shop]['data'][$rubric]['amount'] += $amount;

                $dataRubrics['data'][$shop]['quantity'] += $quantity;
                $dataRubrics['data'][$shop]['amount'] += $amount;

                $dataRubrics['quantity'] += $quantity;
                $dataRubrics['amount'] += $amount;
            }
        }

        uasort($dataRubrics['data'], array($this, 'mySortMethod'));
        foreach ($dataRubrics['data'] as &$dataShop){
            uasort($dataShop['data'], array($this, 'mySortMethod'));

            foreach ($dataShop['data'] as &$dataRubric){
                uasort($dataRubric['data'], array($this, 'mySortMethod'));
            }
        }

        $viewObject = 'ab1/_report/'.$this->_sitePageData->languageID.'/product/client-one';
        $tmp = str_replace('\\', '/', $viewObject);
        try {
            $view = View::factory($tmp);
        }catch (Exception $e) {
            throw new Exception('Шаблон "'.$tmp.'" не найден.');
        }

        $view->rubrics = $dataRubrics;
        $view->dateFrom = $dateFrom;
        $view->dateTo = $dateTo;
        $view->client = $client;
        $view->operation = $this->_sitePageData->operation->getValues();
        $view->shop = $this->_sitePageData->shop->getName();
        $view->shopOptions = $this->_sitePageData->shop->getOptionsArray();
        $strView = Helpers_View::viewToStr($view);

        header('Content-Type: application/x-download;charset=UTF-8');
        // header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: filename="СБ07 Отчет по товарам клиента '.$client.' c '.Helpers_DateTime::getDateFormatRus($dateFrom) . ' по ' . Helpers_DateTime::getDateFormatRus($dateTo).'.xml"');
        header('Cache-Control: max-age=0');

        echo $strView;
        exit();
    }

    /**
     * С3 - Отчет по отгруженным ценам
     * @throws Exception
     */
    public function action_product_client_price() {
        set_time_limit(36000);

        $this->_sitePageData->url = '/'.$this->actionURLName.'/shopreport/product_client_price';

        $shopProductID = Request_RequestParams::getParamInt('shop_product_id');
        if($shopProductID < 1) {
            $rubric = Request_RequestParams::getParamInt('shop_product_rubric_id');
            if ($rubric > 0) {
                $shopProductIDs = Api_Ab1_Shop_Product::findAllByMainRubric(
                    $rubric,
                    $this->_sitePageData, $this->_driverDB
                );
            }else{
                $shopProductIDs = NULL;
            }
        }else{
            $shopProductIDs = $shopProductID;
        }

        $dateFrom = Request_RequestParams::getParamDateTime('created_at_from');
        $dateTo = Request_RequestParams::getParamDateTime('created_at_to');
        $shopClientID = Request_RequestParams::getParamInt('shop_client_id');

        if($shopClientID < 1){
            $shopClientID = NULL;
        }

        $isCharity = Request_RequestParams::getParamBoolean('is_charity') === TRUE;
        $params = Request_RequestParams::setParams(
            array(
                'exit_at_from' => $dateFrom,
                'exit_at_to' => $dateTo,
                'is_exit' => 1,
                'quantity_from' => 0,
                'shop_product_id' => $shopProductIDs,
                'is_charity' => $isCharity,
                'shop_client_id' => $shopClientID,
                'sum_amount' => TRUE,
                'sum_quantity' => TRUE,
                'group_by' => array(
                    'price',
                    'shop_product_id', 'shop_product_id.name',
                    'shop_client_id', 'shop_client_id.name',
                    'root_rubric_id.name', 'root_rubric_id.id',

                )
            )
        );
        $elements = array(
            'shop_product_id' => array('name'),
            'shop_client_id' => array('name'),
            'root_rubric_id' => array('name', 'id'),
        );

        $shopCarItemIDs = Request_Request::find('DB_Ab1_Shop_Car_Item',
            $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE, $elements
        );

        $pieceItemIDs = Request_Request::find('DB_Ab1_Shop_Piece_Item',
            $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE, $elements
        );
        $shopCarItemIDs->addChilds($pieceItemIDs);

        $dataClients = array(
            'data' => array(),
            'quantity' => 0,
            'amount' => 0,
        );

        foreach ($shopCarItemIDs->childs as $child){
            $quantity = $child->values['quantity'];
            $amount = $child->values['amount'];

            $client = $child->values['shop_client_id'];
            if (! key_exists($client, $dataClients['data'])){
                $dataClients['data'][$client] = array(
                    'data' => array(),
                    'name' => $child->getElementValue('shop_client_id'),
                    'quantity' => 0,
                    'amount' => 0,
                );
            }

            // родительная группа
            $rubric = $child->getElementValue('root_rubric_id', 'id', 0);
            if (! key_exists($rubric, $dataClients['data'][$client]['data'])){
                $dataClients['data'][$client]['data'][$rubric] = array(
                    'data' => array(),
                    'name' => $child->getElementValue('root_rubric_id'),
                    'quantity' => 0,
                    'amount' => 0,
                );
            }

            $key = $child->values['shop_product_id'].'_'.$child->values['price'];
            if (! key_exists($key, $dataClients['data'][$client]['data'][$rubric]['data'])){
                $dataClients['data'][$client]['data'][$rubric]['data'][$key] = array(
                    'data' => array(),
                    'name' => $child->getElementValue('shop_product_id'),
                    'quantity' => 0,
                    'amount' => 0,
                    'price' => $child->values['price'],
                );
            }

            $dataClients['data'][$client]['data'][$rubric]['data'][$key]['quantity'] += $quantity;
            $dataClients['data'][$client]['data'][$rubric]['data'][$key]['amount'] += $amount;

            $dataClients['data'][$client]['data'][$rubric]['quantity'] += $quantity;
            $dataClients['data'][$client]['data'][$rubric]['amount'] += $amount;

            $dataClients['data'][$client]['quantity'] += $quantity;
            $dataClients['data'][$client]['amount'] += $amount;

            $dataClients['quantity'] += $quantity;
            $dataClients['amount'] += $amount;
        }
        uasort($dataClients['data'], array($this, 'mySortMethod'));
        foreach ($dataClients['data'] as &$dataClient){
            uasort($dataClient['data'], array($this, 'mySortMethod'));
            foreach ($dataClient['data'] as &$dataRubric){
                uasort($dataRubric['data'], array($this, 'mySortMethod'));
            }
        }

        $viewObject = 'ab1/_report/'.$this->_sitePageData->languageID.'/product/client-price';
        $tmp = str_replace('\\', '/', $viewObject);
        try {
            $view = View::factory($tmp);
        }catch (Exception $e) {
            throw new Exception('Шаблон "'.$tmp.'" не найден.');
        }

        $view->clients = $dataClients;
        $view->dateFrom = $dateFrom;
        $view->dateTo = $dateTo;
        $view->operation = $this->_sitePageData->operation->getValues();
        $view->shop = $this->_sitePageData->shop->getName();
        $view->shopOptions = $this->_sitePageData->shop->getOptionsArray();
        $strView = Helpers_View::viewToStr($view);

        header('Content-Type: application/x-download;charset=UTF-8');
        // header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: filename="СБ03 Отчет по отгруженным ценам c '.Helpers_DateTime::getDateFormatRus($dateFrom) . ' по ' . Helpers_DateTime::getDateFormatRus($dateTo).'.xml"');
        header('Cache-Control: max-age=0');

        echo $strView;
        exit();
    }

    /**
     * С8 - Объем реализации
     * @throws Exception
     */
    public function action_product_contract_client_price() {
        set_time_limit(36000);

        $this->_sitePageData->url = '/'.$this->actionURLName.'/shopreport/product_contract_client_price';

        $shopProductID = Request_RequestParams::getParamInt('shop_product_id');

        if($shopProductID < 1) {
            $rubric = Request_RequestParams::getParam('shop_product_rubric_id');
            if (!is_array($rubric)){
                $rubric = explode(',', $rubric);
            }
            if (!Helpers_Array::_empty($rubric)){
                $shopProductIDs = Api_Ab1_Shop_Product::findAllByMainRubric(
                    $rubric, $this->_sitePageData, $this->_driverDB
                );
            } else {
                $shopProductIDs = NULL;
            }
        }else{
            $shopProductIDs = $shopProductID;
        }


        $dateFrom = Request_RequestParams::getParamDateTime('created_at_from');
        $dateTo = Request_RequestParams::getParamDateTime('created_at_to');
        $shopClientID = Request_RequestParams::getParamInt('shop_client_id');

        if($shopClientID < 1){
            $shopClientID = NULL;
        }

        $isCharity = Request_RequestParams::getParamBoolean('is_charity') === TRUE;
        $params = Request_RequestParams::setParams(
            array(
                'exit_at_from' => $dateFrom,
                'exit_at_to' => $dateTo,
                'is_exit' => 1,
                'quantity_from' => 0,
                'shop_product_id' => $shopProductIDs,
                'is_charity' => $isCharity,
                'shop_client_id' => $shopClientID,
                'sum_amount' => TRUE,
                'sum_quantity' => TRUE,
                'group_by' => array(
                    'shop_product_id', 'shop_product_id.name',
                    'shop_client_id', 'shop_client_id.name',
                    'shop_client_contract_id',
                    'root_rubric_id.name', 'root_rubric_id.id',

                )
            )
        );
        $elements = array(
            'shop_product_id' => array('name'),
            'shop_client_id' => array('name'),
            'root_rubric_id' => array('name', 'id'),
        );

        $shopCarItemIDs = Request_Request::find('DB_Ab1_Shop_Car_Item',
            $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE, $elements
        );

        $pieceItemIDs = Request_Request::find('DB_Ab1_Shop_Piece_Item',
            $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE, $elements
        );
        $shopCarItemIDs->addChilds($pieceItemIDs);

        $dataAttorneys = array(
            'data' => array(),
            'quantity' => 0,
            'amount' => 0,
        );

        foreach ($shopCarItemIDs->childs as $child){
            $quantity = $child->values['quantity'];
            $amount = $child->values['amount'];

            $contract = $child->values['shop_client_contract_id'];
            if($contract > 0){
                $contract = 1;
            }
            if (! key_exists($contract, $dataAttorneys['data'])){
                $dataAttorneys['data'][$contract] = array(
                    'data' => array(),
                    'quantity' => 0,
                    'amount' => 0,
                );

                if($contract == 1){
                    $dataAttorneys['data'][$contract]['name'] = 'По договору';
                }else{
                    $dataAttorneys['data'][$contract]['name'] = 'Без договора';
                }
            }

            $client = $child->values['shop_client_id'];
            if (! key_exists($client, $dataAttorneys['data'][$contract]['data'])){
                $dataAttorneys['data'][$contract]['data'][$client] = array(
                    'data' => array(),
                    'name' => $child->getElementValue('shop_client_id'),
                    'quantity' => 0,
                    'amount' => 0,
                );
            }

            // родительная группа
            $rubric = $child->getElementValue('root_rubric_id', 'id', 0);
            if (! key_exists($rubric, $dataAttorneys['data'][$contract]['data'][$client]['data'])){
                $dataAttorneys['data'][$contract]['data'][$client]['data'][$rubric] = array(
                    'data' => array(),
                    'name' => $child->getElementValue('root_rubric_id'),
                    'quantity' => 0,
                    'amount' => 0,
                );
            }

            $product = $child->values['shop_product_id'];
            if (! key_exists($product, $dataAttorneys['data'][$contract]['data'][$client]['data'][$rubric]['data'])){
                $dataAttorneys['data'][$contract]['data'][$client]['data'][$rubric]['data'][$product] = array(
                    'data' => array(),
                    'name' => $child->getElementValue('shop_product_id'),
                    'quantity' => 0,
                    'amount' => 0,
                );
            }

            $dataAttorneys['data'][$contract]['data'][$client]['data'][$rubric]['data'][$product]['quantity'] += $quantity;
            $dataAttorneys['data'][$contract]['data'][$client]['data'][$rubric]['data'][$product]['amount'] += $amount;

            $dataAttorneys['data'][$contract]['data'][$client]['data'][$rubric]['quantity'] += $quantity;
            $dataAttorneys['data'][$contract]['data'][$client]['data'][$rubric]['amount'] += $amount;

            $dataAttorneys['data'][$contract]['data'][$client]['quantity'] += $quantity;
            $dataAttorneys['data'][$contract]['data'][$client]['amount'] += $amount;

            $dataAttorneys['data'][$contract]['quantity'] += $quantity;
            $dataAttorneys['data'][$contract]['amount'] += $amount;

            $dataAttorneys['quantity'] += $quantity;
            $dataAttorneys['amount'] += $amount;
        }
        uasort($dataAttorneys['data'], array($this, 'mySortMethod'));
        foreach ($dataAttorneys['data'] as &$dataClients){
            uasort($dataClients['data'], array($this, 'mySortMethod'));
            foreach ($dataClients['data'] as &$dataClient){
                uasort($dataClient['data'], array($this, 'mySortMethod'));
                foreach ($dataClient['data'] as &$dataRubric){
                    uasort($dataRubric['data'], array($this, 'mySortMethod'));
                }
            }
        }

        $viewObject = 'ab1/_report/'.$this->_sitePageData->languageID.'/product/contract-client-price';
        $tmp = str_replace('\\', '/', $viewObject);
        try {
            $view = View::factory($tmp);
        }catch (Exception $e) {
            throw new Exception('Шаблон "'.$tmp.'" не найден.');
        }

        $view->attorneys = $dataAttorneys;
        $view->dateFrom = $dateFrom;
        $view->dateTo = $dateTo;
        $view->operation = $this->_sitePageData->operation->getValues();
        $view->shop = $this->_sitePageData->shop->getName();
        $view->shopOptions = $this->_sitePageData->shop->getOptionsArray();
        $strView = Helpers_View::viewToStr($view);

        header('Content-Type: application/x-download;charset=UTF-8');
        // header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: filename="СБ08 Объем реализации c '.Helpers_DateTime::getDateFormatRus($dateFrom) . ' по ' . Helpers_DateTime::getDateFormatRus($dateTo).'.xml"');
        header('Cache-Control: max-age=0');

        echo $strView;
        exit();
    }

    /**
     * С5 - Отчет по отгрузке в разрезе договоров клиентов
     * @throws Exception
     */
    public function action_contract_client_goods() {
        set_time_limit(36000);

        $this->_sitePageData->url = '/'.$this->actionURLName.'/shopreport/contract_client_goods';

        $dateFrom = Request_RequestParams::getParamDateTime('date_from');
        $dateTo = Request_RequestParams::getParamDateTime('date_to');
        $params = Request_RequestParams::setParams(
            array(
                'created_at_from' => $dateFrom,
                'created_at_to' => $dateTo,
                'shop_client_contract_id_from' => 0,
                'shop_client_id' => Request_RequestParams::getParamInt('shop_client_id'),
                /*'sum_amount' => TRUE,
                'sum_quantity' => TRUE,
                'group_by' => array(
                    'price',
                    'shop_client_id', 'shop_client_id.name',
                    'shop_product_id', 'shop_product_id.name',
                    'shop_client_contract_id', 'shop_client_contract_id.number', 'shop_client_contract_id.quantity',
                    'shop_client_contract_id.amount', 'shop_client_contract_id.from_at', 'shop_client_contract_id.to_at',
                ),*/
                'sort_by' => array(
                    'shop_client_id.name' => 'asc',
                    'shop_client_contract_id.number' => 'asc',
                    'shop_product_id.name' => 'asc',
                )
            )
        );
        $ids = Request_Request::findBranch('DB_Ab1_Shop_Car_Item',
            array(), $this->_sitePageData, $this->_driverDB, $params,0, TRUE,
            array(
                'shop_client_id' => array('name'),
                'shop_product_id' => array('name'),
                'shop_client_contract_id' => array('number', 'amount', 'quantity', 'from_at', 'to_at'),
            )
        );
        $shopPieceIDs = Request_Request::findBranch('DB_Ab1_Shop_Piece_Item',
            array(), $this->_sitePageData, $this->_driverDB, $params,0, TRUE,
            array(
                'shop_client_id' => array('name'),
                'shop_product_id' => array('name'),
                'shop_client_contract_id' => array('number', 'amount', 'quantity', 'from_at', 'to_at'),
            )
        );
        $ids->addChilds($shopPieceIDs);

        $dataClients = array(
            'data' => array(),
            'amount' => 0,
            'quantity' => 0,
            'total_amount' => 0,
            'total_quantity' => 0,
        );
        foreach ($ids->childs as $child){
            $amount = $child->values['amount'];
            $quantity = $child->values['quantity'];
            $client = $child->values['shop_client_id'];
            $product = $child->values['shop_product_id'];
            $contract = $child->values['shop_client_contract_id'];
            $contractItem = $child->values['shop_client_contract_item_id'];
            $price = $child->values['price'];

            /** Создаем группу клиентов **/
            if (!key_exists($client, $dataClients['data'])) {
                $dataClients['data'][$client] = array(
                    'name' => $child->getElementValue('shop_client_id'),
                    'id' => $client,
                    'data' => array(),
                    'amount' => 0,
                    'quantity' => 0,
                    'total_amount' => 0,
                    'total_quantity' => 0,
                );
            }

            /** Создаем группу договоров **/
            if (!key_exists($contract, $dataClients['data'][$client]['data'])) {
                $totalAmount = intval($child->getElementValue('shop_client_contract_id', 'amount'));
                $dataClients['data'][$client]['total_amount'] += $totalAmount;

                $totalQuantity = intval($child->getElementValue('shop_client_contract_id', 'quantity'));
                $dataClients['data'][$client]['total_quantity'] += $totalQuantity;

                $dataClients['data'][$client]['data'][$contract] = array(
                    'number' => $child->getElementValue('shop_client_contract_id', 'number'),
                    'from_at' => $child->getElementValue('shop_client_contract_id', 'from_at'),
                    'to_at' => $child->getElementValue('shop_client_contract_id', 'to_at'),
                    'id' => $contract,
                    'data' => array(),
                    'amount' => 0,
                    'quantity' => 0,
                    'total_amount' => $totalAmount,
                    'total_quantity' => $totalQuantity,
                );

                $shopClientContractItems = Request_Request::findBranch('DB_Ab1_Shop_Client_Contract_Item',
                    array(), $this->_sitePageData, $this->_driverDB,
                    Request_RequestParams::setParams(
                        array(
                            'basic_or_contract' => $contract,
                        )
                    ),
                    0, TRUE,
                    array(
                        'shop_product_id' => array('name'),
                        'shop_product_rubric_id' => array('name'),
                    )
                );

                /** Для договора выбираем список групп товаров заложенных в договоре **/
                foreach ($shopClientContractItems->childs as $item){
                    $itemID = $item->values['shop_product_id'];
                    if($itemID > 0){
                        $name = $item->getElementValue('shop_product_id', 'name');
                        $productIDs = array($itemID);
                    }else{
                        $itemID = $item->values['shop_product_rubric_id'];
                        if($itemID > 0) {
                            $name = $item->getElementValue('shop_product_rubric_id', 'name');

                            $productIDs = Api_Ab1_Shop_Product::findAllByMainRubric(
                                $itemID, $this->_sitePageData, $this->_driverDB
                            );
                            if ($productIDs === NULL) {
                                $productIDs = array();
                            }
                        }else{
                            $name = 'Все';
                            $productIDs = array();
                        }
                    }

                    if (!key_exists($itemID, $dataClients['data'][$client]['data'][$contract]['data'])) {
                        $dataClients['data'][$client]['data'][$contract]['data'][$itemID] = array(
                            'name' => $name,
                            'id' => $itemID,
                            'products' => $productIDs,
                            'contract_items' => array(),
                            'data' => array(),
                            'amount' => 0,
                            'quantity' => 0,
                            'total_amount' => 0,
                            'total_quantity' => 0,
                        );
                    }

                    if($contractItem > 0) {
                        $dataClients['data'][$client]['data'][$contract]['data'][$itemID]['contract_items'][] = $contractItem;
                    }
                    $dataClients['data'][$client]['data'][$contract]['data'][$itemID]['total_amount'] += $item->values['amount'];
                    $dataClients['data'][$client]['data'][$contract]['data'][$itemID]['total_quantity'] += $item->values['quantity'];
                }
            }

            // узнаем группу товаров в договоре
            $contractItem = 0;
            foreach ($dataClients['data'][$client]['data'][$contract]['data'] as $item) {
                if ($contractItem > 0 && array_search($contractItem, $item['contract_items']) !== FALSE) {
                    $contractItem = $item['id'];
                    break;
                }
                if (array_search($product, $item['products']) !== FALSE) {
                    if($contractItem == 0 || $item['total_amount'] - $item['amount'] >= $amount){
                        $contractItem = $item['id'];

                        if($item['total_amount'] - $item['amount'] >= $amount){
                            $contractItem = $item['id'];
                            break;
                        }
                    }
                }
            }
            if ($contractItem == 0 && !key_exists($contractItem, $dataClients['data'][$client]['data'][$contract]['data'])) {
                $dataClients['data'][$client]['data'][$contract]['data'][$contractItem] = array(
                    'name' => 'Вне договора',
                    'id' => 0,
                    'contract_items' => array(),
                    'products' => array(),
                    'data' => array(),
                    'amount' => 0,
                    'quantity' => 0,
                    'total_amount' => 0,
                    'total_quantity' => 0,
                );
            }

            /** Создаем группу товаров **/
            $key = $product.'-'.$price;
            if (!key_exists($key, $dataClients['data'][$client]['data'][$contract]['data'][$contractItem]['data'])) {
                $dataClients['data'][$client]['data'][$contract]['data'][$contractItem]['data'][$key] = array(
                    'name' => $child->getElementValue('shop_product_id'),
                    'id' => $product,
                    'price' => $price,
                    'amount' => 0,
                    'quantity' => 0,
                    'total_amount' => 0,
                    'total_quantity' => 0,
                );
            }
            $dataClients['data'][$client]['data'][$contract]['data'][$contractItem]['data'][$key]['amount'] += $amount;
            $dataClients['data'][$client]['data'][$contract]['data'][$contractItem]['data'][$key]['quantity'] += $quantity;

            $dataClients['data'][$client]['data'][$contract]['data'][$contractItem]['amount'] += $amount;
            $dataClients['data'][$client]['data'][$contract]['data'][$contractItem]['quantity'] += $quantity;

            $dataClients['data'][$client]['data'][$contract]['amount'] += $amount;
            $dataClients['data'][$client]['data'][$contract]['quantity'] += $quantity;

            $dataClients['data'][$client]['amount'] += $amount;
            $dataClients['data'][$client]['quantity'] += $quantity;

            $dataClients['amount'] += $amount;
            $dataClients['quantity'] += $quantity;
        }

        $viewObject = 'ab1/_report/'.$this->_sitePageData->languageID.'/contract/client-goods';
        $tmp = str_replace('\\', '/', $viewObject);
        try {
            $view = View::factory($tmp);
        }catch (Exception $e) {
            throw new Exception('Шаблон "'.$tmp.'" не найден.');
        }

        $view->clients = $dataClients;
        $view->dateFrom = $dateFrom;
        $view->dateTo = $dateTo;
        $view->operation = $this->_sitePageData->operation->getValues();
        $view->shop = $this->_sitePageData->shop->getName();
        $view->shopOptions = $this->_sitePageData->shop->getOptionsArray();
        $strView = Helpers_View::viewToStr($view);

        header('Content-Type: application/x-download;charset=UTF-8');
        // header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: filename="СБ05 Отчет по отгрузке в разрезе договоров клиентовРазгруженные вагоны c '.Helpers_DateTime::getDateFormatRus($dateFrom) . ' по ' . Helpers_DateTime::getDateFormatRus($dateTo).'.xml"');
        header('Cache-Control: max-age=0');

        echo $strView;
        exit();
    }

    /**
     * СБ04 Отчет по отгрузке в разрезе доверенностей клиентов
     * @throws Exception
     */
    public function action_attorney_client_goods() {
        set_time_limit(36000);

        $this->_sitePageData->url = '/'.$this->actionURLName.'/shopreport/attorney_client_goods';

        $dateFrom = Request_RequestParams::getParamDateTime('date_from');
        $dateTo = Request_RequestParams::getParamDateTime('date_to');
        $params = Request_RequestParams::setParams(
            array(
                'exit_at_from' => $dateFrom,
                'exit_at_to' => $dateTo,
                'shop_client_id' => Request_RequestParams::getParamInt('shop_client_id'),
                'sum_amount' => TRUE,
                'sum_quantity' => TRUE,
                'min_created_at' => TRUE,
                'group_by' => array(
                    'price',
                    'shop_client_id', 'shop_client_id.name',
                    'shop_product_id', 'shop_product_id.name',
                    'shop_client_attorney_id', 'shop_client_attorney_id.number', 'shop_client_attorney_id.client_name',
                    'shop_client_attorney_id.amount', 'shop_client_attorney_id.from_at', 'shop_client_attorney_id.to_at',
                ),
                'sort_by' => array(
                    'shop_client_id.name' => 'asc',
                    'shop_client_attorney_id.number' => 'asc',
                    'shop_product_id.name' => 'asc',
                )
            )
        );
        $ids = Request_Request::find('DB_Ab1_Shop_Car_Item',
            $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB, $params,0, TRUE,
            array(
                'shop_client_id' => array('name'),
                'shop_product_id' => array('name'),
                'shop_client_attorney_id' => array('number', 'client_name', 'amount', 'from_at', 'to_at'),
            )
        );
        $pieceIDs = Request_Request::find('DB_Ab1_Shop_Piece_Item',
            $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB, $params,0, TRUE,
            array(
                'shop_client_id' => array('name'),
                'shop_product_id' => array('name'),
                'shop_client_attorney_id' => array('number', 'client_name', 'amount', 'from_at', 'to_at'),
            )
        );
        $ids->addChilds($pieceIDs);

        $dataClients = array(
            'data' => array(),
            'amount' => 0,
            'quantity' => 0,
        );
        foreach ($ids->childs as $child){
            $amount = $child->values['amount'];
            $client = $child->values['shop_client_id'];
            $product = $child->values['shop_product_id'];
            $attorney = $child->values['shop_client_attorney_id'];
            $price = $child->values['price'];
            $quantity = $child->values['quantity'];

            if (!key_exists($client, $dataClients['data'])) {
                $dataClients['data'][$client] = array(
                    'name' => $child->getElementValue('shop_client_id'),
                    'id' => $client,
                    'data' => array(),
                    'amount' => 0,
                    'quantity' => 0,
                );
            }

            if (!key_exists($attorney, $dataClients['data'][$client]['data'])) {
                $dataClients['data'][$client]['data'][$attorney] = array(
                    'number' => $child->getElementValue('shop_client_attorney_id', 'number', 'Наличные'),
                    'attorney_amount' => $child->getElementValue('shop_client_attorney_id', 'amount'),
                    'client_name' => $child->getElementValue('shop_client_attorney_id', 'client_name'),
                    'from_at' => $child->getElementValue('shop_client_attorney_id', 'from_at'),
                    'to_at' => $child->getElementValue('shop_client_attorney_id', 'to_at'),
                    'date' => $child->values['min_created_at'],
                    'id' => $attorney,
                    'data' => array(),
                    'amount' => 0,
                    'quantity' => 0,
                );
            }

            $key = $product;//.'-'.$price;
            if (!key_exists($key, $dataClients['data'][$client]['data'][$attorney]['data'])) {
                $dataClients['data'][$client]['data'][$attorney]['data'][$key] = array(
                    'name' => $child->getElementValue('shop_product_id'),
                    'id' => $product,
                    'price' => $price,
                    'quantity' => 0,
                    'amount' => 0,
                );
            }

            $dataClients['data'][$client]['data'][$attorney]['data'][$key]['amount'] += $amount;
            $dataClients['data'][$client]['data'][$attorney]['data'][$key]['quantity'] += $quantity;

            $dataClients['data'][$client]['data'][$attorney]['amount'] += $amount;
            $dataClients['data'][$client]['data'][$attorney]['quantity'] += $quantity;

            $dataClients['data'][$client]['amount'] += $amount;
            $dataClients['data'][$client]['quantity'] += $quantity;

            $dataClients['amount'] += $amount;
            $dataClients['quantity'] += $quantity;
        }

        $viewObject = 'ab1/_report/'.$this->_sitePageData->languageID.'/attorney/client-goods';
        $tmp = str_replace('\\', '/', $viewObject);
        try {
            $view = View::factory($tmp);
        }catch (Exception $e) {
            throw new Exception('Шаблон "'.$tmp.'" не найден.');
        }

        $view->clients = $dataClients;
        $view->dateFrom = $dateFrom;
        $view->dateTo = $dateTo;
        $view->operation = $this->_sitePageData->operation->getValues();
        $view->shop = $this->_sitePageData->shop->getName();
        $view->shopOptions = $this->_sitePageData->shop->getOptionsArray();
        $strView = Helpers_View::viewToStr($view);

        header('Content-Type: application/x-download;charset=UTF-8');
        // header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: filename="СБ04 Отчет по отгрузке в разрезе доверенностей клиентов c '.Helpers_DateTime::getDateFormatRus($dateFrom) . ' по ' . Helpers_DateTime::getDateFormatRus($dateTo).'.xml"');
        header('Cache-Control: max-age=0');

        echo $strView;
        exit();
    }

    /**
     * Ежедневный анализ реализации продукции с причинами
     * @throws Exception
     * @throws HTTP_Exception_404
     */
    public function action_plan_reason() {
        set_time_limit(36000);

        $this->_sitePageData->url = '/'.$this->actionURLName.'/shopreport/plan_reason';

        // получаем филиалы
        $shopIDs = Request_Shop::getBranchShopIDs(
            $this->_sitePageData->shopMainID, $this->_sitePageData, $this->_driverDB
        )->getChildArrayID();
        $shopIDs[] = $this->_sitePageData->shopMainID;

        // Список групп
        $dataGroups = array(
            'quantity' => array(
                'plan' => 0,
                'fact' => 0,
            ),
            'data' => array(),
        );

        $params = Request_RequestParams::setParams(
            array('root_id' => 0)
        );
        $shopProductRubricIDs = Request_Request::find('DB_Ab1_Shop_Product_Rubric',
            $this->_sitePageData->shopMainID, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE
        );
        foreach ($shopProductRubricIDs->childs as $child){
            $dataGroups['data'][$child->id] = array(
                'name' => $child->values['name'],
                'is_find' => FALSE,
                'quantity' => array(
                    'plan' => 0,
                    'fact' => 0,
                ),
            );
        }

        // получаем список рубрик второго уровня
        $params = Request_RequestParams::setParams(
            array('root_id' => $shopProductRubricIDs->getChildArrayID())
        );
        $shopProductRubricIDs = Request_Request::find('DB_Ab1_Shop_Product_Rubric',
            $this->_sitePageData->shopMainID, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE
        );
        $shopProductRubricIDs->runIndex();

        /** Планируемая реализация продукции **/
        $date = Request_RequestParams::getParamDate('date');
        $params = Request_RequestParams::setParams(
            array(
                'date' => $date,
            )
        );
        $ids = Request_Request::findBranch('DB_Ab1_Shop_Plan_Item',
            $shopIDs, $this->_sitePageData, $this->_driverDB, $params,0, TRUE,
            array(
                'shop_client_id' => array('name'),
                'shop_product_id' => array('name', 'name_short', 'shop_product_rubric_id'),
            )
        );

        $dataClients = array(
            'data' => array(
                'main' => array(
                    'quantity' => array(
                        'plan' => 0,
                        'fact' => 0,
                    ),
                    'data' => array(),
                ),
                'branch' => array(
                    'quantity' => array(
                        'plan' => 0,
                        'fact' => 0,
                    ),
                    'data' => array(),
                )
            )
        );
        foreach ($ids->childs as $child){
            $quantity = $child->values['quantity'];
            $client = $child->values['shop_client_id'];

            $shopID = $child->values['shop_id'];
            if($shopID == $this->_sitePageData->shopMainID){
                $shopID = 'main';
            }else{
                $shopID = 'branch';
            }
            $product = $child->getElementValue('shop_product_id', 'name_short');

            // определяем группу
            $group = $child->getElementValue('shop_product_id', 'shop_product_rubric_id');
            if(!key_exists($group, $shopProductRubricIDs->childs)){
                continue;
            }
            $group = $shopProductRubricIDs->childs[$group]->values['root_id'];
            if(!key_exists($group, $dataGroups['data'])){
                continue;
            }
            $dataGroups['data']['is_find'] = TRUE;

            // клиент
            if (!key_exists($client, $dataClients['data'][$shopID]['data'])) {
                $dataClients['data'][$shopID]['data'][$client] = array(
                    'data' => array(),
                    'quantity' => array(
                        'plan' => 0,
                        'fact' => 0,
                    ),
                    'name' => $child->getElementValue('shop_client_id'),
                    'id' => $client,
                );

                if($client == 0){
                    $dataClients['data'][$shopID]['data'][$client]['name'] = 'Прочие';
                }
            }

            // продукт
            if (!key_exists($product, $dataClients['data'][$shopID]['data'][$client]['data'])) {
                $dataClients['data'][$shopID]['data'][$client]['data'][$product] = array(
                    'data' => array(),
                    'quantity' => array(
                        'plan' => 0,
                        'fact' => 0,
                    ),
                    'name' => $product,
                );
            }

            // группа продукции
            if (!key_exists($group, $dataClients['data'][$shopID]['data'][$client]['data'][$product]['data'])) {
                $dataClients['data'][$shopID]['data'][$client]['data'][$product]['data'][$group] = array(
                    'quantity' => array(
                        'plan' => 0,
                        'fact' => 0,
                    ),
                );
            }

            $dataClients['data'][$shopID]['data'][$client]['data'][$product]['data'][$group]['quantity']['plan'] += $quantity;
            $dataClients['data'][$shopID]['data'][$client]['data'][$product]['quantity']['plan'] += $quantity;
            $dataClients['data'][$shopID]['data'][$client]['quantity']['plan'] += $quantity;
            $dataClients['data'][$shopID]['quantity']['plan'] += $quantity;
        }

        /** Итоговая реализация продукции **/
        $params = Request_RequestParams::setParams(
            array(
                'exit_at_from' => $date . ' 06:00:00',
                'exit_at_to' => Helpers_DateTime::plusDays($date . ' 06:00:00', 1),
                'is_exit' => TRUE,
                'is_charity' => FALSE,
            )
        );
        $ids = Request_Request::findBranch('DB_Ab1_Shop_Car_Item',
            $shopIDs, $this->_sitePageData, $this->_driverDB, $params,0, TRUE,
            array(
                'shop_client_id' => array('name'),
                'shop_product_id' => array('name', 'name_short', 'shop_product_rubric_id'),
            )
        );
        $pieceIDs = Request_Request::findBranch('DB_Ab1_Shop_Piece_Item',
            $shopIDs, $this->_sitePageData, $this->_driverDB, $params,0, TRUE,
            array(
                'shop_client_id' => array('name'),
                'shop_product_id' => array('name', 'name_short', 'shop_product_rubric_id'),
            )
        );
        $ids->childs = array_merge($ids->childs, $pieceIDs->childs);


        foreach ($ids->childs as $child){
            $quantity = $child->values['quantity'];
            $client = $child->values['shop_client_id'];

            $shopID = $child->values['shop_id'];
            if($shopID == $this->_sitePageData->shopMainID){
                $shopID = 'main';
            }else{
                $shopID = 'branch';
            }
            $product = $child->getElementValue('shop_product_id', 'name_short');

            // определяем группу
            $group = $child->getElementValue('shop_product_id', 'shop_product_rubric_id');
            if(!key_exists($group, $shopProductRubricIDs->childs)){
                continue;
            }
            $group = $shopProductRubricIDs->childs[$group]->values['root_id'];
            if(!key_exists($group, $dataGroups['data'])){
                continue;
            }
            $dataGroups['data']['is_find'] = TRUE;

            // клиент
            if (!key_exists($client, $dataClients['data'][$shopID]['data'])) {
                $dataClients['data'][$shopID]['data'][$client] = array(
                    'data' => array(),
                    'quantity' => array(
                        'plan' => 0,
                        'fact' => 0,
                    ),
                    'name' => $child->getElementValue('shop_client_id'),
                    'id' => $client,
                );

                if($client == 0){
                    $dataClients['data'][$shopID]['data'][$client]['name'] = 'Прочие';
                }
            }

            // продукт
            if (!key_exists($product, $dataClients['data'][$shopID]['data'][$client]['data'])) {
                $dataClients['data'][$shopID]['data'][$client]['data'][$product] = array(
                    'data' => array(),
                    'quantity' => array(
                        'plan' => 0,
                        'fact' => 0,
                    ),
                    'name' => $product,
                );
            }

            // группа продукции
            if (!key_exists($group, $dataClients['data'][$shopID]['data'][$client]['data'][$product]['data'])) {
                $dataClients['data'][$shopID]['data'][$client]['data'][$product]['data'][$group] = array(
                    'quantity' => array(
                        'plan' => 0,
                        'fact' => 0,
                    ),
                );
            }

            $dataClients['data'][$shopID]['data'][$client]['data'][$product]['data'][$group]['quantity']['plan'] += $quantity;
            $dataClients['data'][$shopID]['data'][$client]['data'][$product]['quantity']['plan'] += $quantity;
            $dataClients['data'][$shopID]['data'][$client]['quantity']['plan'] += $quantity;
            $dataClients['data'][$shopID]['quantity']['plan'] += $quantity;
        }

        uasort($dataGroups['data'], array($this, 'mySortMethod'));
        foreach ($dataClients['data'] as &$clients){
            uasort($clients['data'], array($this, 'mySortMethod'));
        }

        $viewObject = 'ab1/_report/'.$this->_sitePageData->languageID.'/plan/reason';
        $tmp = str_replace('\\', '/', $viewObject);
        try {
            $view = View::factory($tmp);
        }catch (Exception $e) {
            throw new Exception('Шаблон "'.$tmp.'" не найден.');
        }

        $view->clients = $dataClients;
        $view->groups = $dataGroups;
        $view->date = $date;
        $view->operation = $this->_sitePageData->operation->getValues();
        $view->shop = $this->_sitePageData->shop->getName();
        $view->shopOptions = $this->_sitePageData->shop->getOptionsArray();
        $strView = Helpers_View::viewToStr($view);

        header('Content-Type: application/x-download;charset=UTF-8');
        // header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: filename="Ежедневный анализ реализации продукции с причинами за '.Helpers_DateTime::getDateFormatRus($date) .'.xml"');
        header('Cache-Control: max-age=0');

        echo $strView;
        exit();
    }

    /**
     * График выполнения месячных заявок
     * @throws Exception
     * @throws HTTP_Exception_404
     */
    public function action_bid_plan_month() {
        set_time_limit(36000);

        $this->_sitePageData->url = '/'.$this->actionURLName.'/shopreport/bid_plan_month';

        /** Получаем рубрику, которая выбрана */
        $shopProductRubricID = Request_RequestParams::getParamInt('shop_product_rubric_id');
        if ($shopProductRubricID > 0) {
            $modelRubric = new Model_Ab1_Shop_Product_Rubric();
            $modelRubric->setDBDriver($this->_driverDB);
            if (!(($shopProductRubricID > 0) && (Helpers_DB::getDBObject($modelRubric, $shopProductRubricID, $this->_sitePageData)))) {
                throw new HTTP_Exception_404('Turn type not found.');
            }

            $productIDs = Api_Ab1_Shop_Product::findAllByMainRubric(
                Request_RequestParams::getParamInt('shop_product_rubric_id'),
                $this->_sitePageData, $this->_driverDB
            );
        }else{
            throw new HTTP_Exception_500('Rubric not found!');
        }

        // получаем филиалы
        $shopIDs = Request_Shop::getBranchShopIDs($this->_sitePageData->shopMainID, $this->_sitePageData, $this->_driverDB)->getChildArrayID();
        $shopIDs[] = $this->_sitePageData->shopMainID;

        $dataProducts = array(
            'quantity' => 0,
            'data' => array(),
        );

        /** Планируемая реализация продукции **/
        $dateFrom = Request_RequestParams::getParamDateTime('date_from');
        $dateTo = Request_RequestParams::getParamDateTime('date_to');
        $params = Request_RequestParams::setParams(
            array(
                'date_from' => $dateFrom,
                'date_to' => $dateTo,
                'shop_product_id' => $productIDs,
            )
        );
        $ids = Request_Request::findBranch('DB_Ab1_Shop_Bid_Item',
            $shopIDs, $this->_sitePageData, $this->_driverDB, $params,0, TRUE,
            array(
                'shop_client_id' => array('name'),
                'shop_product_id' => array('name', 'name_short'),
            )
        );
        $shopClients = $ids->getChildArrayInt('shop_client_id', TRUE);

        $dataClients = array(
            'data' => array(
                'main' => array(
                    'quantity' => 0,
                    'data' => array(),
                ),
                'branch' => array(
                    'quantity' => 0,
                    'data' => array(),
                )
            )
        );
        foreach ($ids->childs as $child){
            $quantity = $child->values['quantity'];
            $client = $child->values['shop_client_id'];

            $shopID = $child->values['shop_id'];
            if($shopID == $this->_sitePageData->shopMainID){
                $shopID = 'main';
            }else{
                $shopID = 'branch';
            }
            $group = $child->getElementValue('shop_product_id', 'name_short');
            if (!key_exists($group, $dataProducts['data'])) {
                $dataProducts['data'][$group] = array(
                    'name' => $group,
                    'id' => $group,
                    'quantity' => array(
                        'main' => 0,
                        'branch' => 0,
                    ),
                );
            }
            $dataProducts['data'][$group]['quantity'][$shopID] += $quantity;
            $dataProducts['quantity'] += $quantity;

            if (!key_exists($client, $dataClients['data'][$shopID]['data'])) {
                $dataClients['data'][$shopID]['data'][$client] = array(
                    'data' => array(),
                    'quantity' => 0,
                    'name' => $child->getElementValue('shop_client_id'),
                    'id' => $client,
                );

                if($client == 0){
                    $dataClients['data'][$shopID]['data'][$client]['name'] = 'Прочие';
                }
            }

            if (!key_exists($group, $dataClients['data'][$shopID]['data'][$client]['data'])) {
                $dataClients['data'][$shopID]['data'][$client]['data'][$group] = $quantity;
            } else {
                $dataClients['data'][$shopID]['data'][$client]['data'][$group] += $quantity;
            }

            $dataClients['data'][$shopID]['data'][$client]['quantity'] += $quantity;
            $dataClients['data'][$shopID]['quantity'] += $quantity;
        }

        /** Итоговая реализация продукции **/
        $params = Request_RequestParams::setParams(
            array(
                'exit_at_from' => $dateFrom,
                'exit_at_to' => Helpers_DateTime::plusDays($dateTo, 1),
                'is_exit' => TRUE,
                'is_charity' => FALSE,
                'shop_product_id' => $productIDs,
            )
        );
        $ids = Request_Request::findBranch('DB_Ab1_Shop_Car_Item',
            $shopIDs, $this->_sitePageData, $this->_driverDB, $params,0, TRUE,
            array(
                'shop_client_id' => array('name'),
                'shop_product_id' => array('name', 'name_short', 'shop_product_group_id'),
            )
        );
        $pieceIDs = Request_Request::findBranch('DB_Ab1_Shop_Piece_Item',
            $shopIDs, $this->_sitePageData, $this->_driverDB, $params,0, TRUE,
            array(
                'shop_client_id' => array('name'),
                'shop_product_id' => array('name', 'name_short', 'shop_product_group_id'),
            )
        );
        $ids->childs = array_merge($ids->childs, $pieceIDs->childs);

        foreach ($ids->childs as $child){
            $quantity = $child->values['quantity'];
            $client = $child->values['shop_client_id'];
            if(!key_exists($client, $shopClients)){
                $client = 0;
            }

            $shopID = $child->values['shop_id'];
            if($shopID == $this->_sitePageData->shopMainID){
                $shopID = 'main';
            }else{
                $shopID = 'branch';
            }
            $group = $child->getElementValue('shop_product_id', 'name_short');
            if (!key_exists($group, $dataProducts['data'])) {
                $dataProducts['data'][$group] = array(
                    'name' => $group,
                    'id' => $group,
                    'quantity' => array(
                        'main' => 0,
                        'branch' => 0,
                    ),
                );
            }
            $dataProducts['data'][$group]['quantity'][$shopID] -= $quantity;
            $dataProducts['quantity'] -= $quantity;

            if (!key_exists($client, $dataClients['data'][$shopID]['data'])) {
                $dataClients['data'][$shopID]['data'][$client] = array(
                    'data' => array(),
                    'quantity' => 0,
                    'name' => $child->getElementValue('shop_client_id'),
                    'id' => $client,
                );
            }

            if (!key_exists($group, $dataClients['data'][$shopID]['data'][$client]['data'])) {
                $dataClients['data'][$shopID]['data'][$client]['data'][$group] = $quantity * (-1);
            } else {
                $dataClients['data'][$shopID]['data'][$client]['data'][$group] -= $quantity;
            }

            $dataClients['data'][$shopID]['data'][$client]['quantity'] -= $quantity;
            $dataClients['data'][$shopID]['quantity'] -= $quantity;
        }

        uasort($dataProducts['data'], array($this, 'mySortMethod'));
        foreach ($dataClients['data'] as &$clients){
            uasort($clients['data'], array($this, 'mySortMethod'));
        }

        $viewObject = 'ab1/_report/'.$this->_sitePageData->languageID.'/bid/plan-month';
        $tmp = str_replace('\\', '/', $viewObject);
        try {
            $view = View::factory($tmp);
        }catch (Exception $e) {
            throw new Exception('Шаблон "'.$tmp.'" не найден.');
        }

        $view->clients = $dataClients;
        $view->products = $dataProducts;
        $view->dateFrom = $dateFrom;
        $view->dateTo = $dateTo;
        $view->rubricName = $modelRubric->getName();
        $view->operation = $this->_sitePageData->operation->getValues();
        $view->shop = $this->_sitePageData->shop->getName();
        $view->shopOptions = $this->_sitePageData->shop->getOptionsArray();
        $strView = Helpers_View::viewToStr($view);

        header('Content-Type: application/x-download;charset=UTF-8');
        // header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: filename="ПР04 График реализации продукции за месяц c '.Helpers_DateTime::getDateFormatRus($dateFrom) . ' по ' . Helpers_DateTime::getDateFormatRus($dateTo).'.xml"');
        header('Cache-Control: max-age=0');

        echo $strView;
        exit();
    }

    /**
     * Мониторинг цен / Цены конкурентов
     * @throws Exception
     * @throws HTTP_Exception_404
     */
    public function action_competitor_prices() {
        set_time_limit(36000);

        $this->_sitePageData->url = '/'.$this->actionURLName.'/shopreport/competitor_prices';

        /** Получаем рубрику, которая выбрана */
        $shopProductRubricID = Request_RequestParams::getParamInt('shop_product_rubric_id');
        if ($shopProductRubricID > 0) {
            $modelRubric = new Model_Ab1_Shop_Product_Rubric();
            $modelRubric->setDBDriver($this->_driverDB);
            if (!(($shopProductRubricID > 0) && (Helpers_DB::getDBObject($modelRubric, $shopProductRubricID, $this->_sitePageData)))) {
                throw new HTTP_Exception_404('Turn type not found.');
            }

            $productIDs = Api_Ab1_Shop_Product::findAllByMainRubric(
                Request_RequestParams::getParamInt('shop_product_rubric_id'),
                $this->_sitePageData, $this->_driverDB
            );
        }else{
            throw new HTTP_Exception_500('Rubric not found!');
        }

        /** получаем список продукции c ценами конкурентов */
        $dateFrom = Request_RequestParams::getParamDate('date_from');
        $dateTo = Request_RequestParams::getParamDate('date_to');

        $params = Request_RequestParams::setParams(
            array(
                'date_from' => $dateFrom,
                'date_to' => Helpers_DateTime::plusDays($dateTo, 1),
                'shop_product_id' => $productIDs,
            )
        );
        $ids = Request_Request::find('DB_Ab1_Shop_Competitor_Price_Item',
            $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
            array('shop_product_id' => array('name', 'price'), 'shop_competitor_id' => array('name'))
        );

        // цены продукции
        $dataProducts = array(
            'data' => array(),
        );
        // клиенты
        $dataCompetitors = array(
            'data' => array(),
        );
        // мощности
        $dataCapacities = array();
        // доставка
        $dataDeliveries = array();
        // доставка ЖД
        $dataDeliveriesZHD = array();
        foreach ($ids->childs as $child){
            $product = $child->values['shop_product_id'];
            $competitor = $child->values['shop_competitor_id'];

            // собираем список клиентов
            if (! key_exists($competitor, $dataCompetitors['data'])){
                $dataCompetitors['data'][$competitor] = array(
                    'id' => $competitor,
                    'name' => $child->getElementValue('shop_competitor_id'),
                );
            }

            // собираем цены продукции
            if (! key_exists($competitor, $dataProducts['data'])){
                $dataProducts['data'][$product] = array(
                    'name' => $child->getElementValue('shop_product_id'),
                    'prices' => array(
                        'ab1' => $child->getElementValue('shop_product_id', 'price'),
                    ),
                );
            }
            $dataProducts['data'][$product]['price'][$competitor] = $child->values['price'];

            $dataCapacities[$competitor] = $child->values['product_capacity'];
            $dataDeliveries[$competitor] = $child->values['delivery'];
            $dataDeliveriesZHD[$competitor] = $child->values['delivery_zhd'];
        }

        uasort($dataCompetitors['data'], array($this, 'mySortMethod'));
        uasort($dataProducts['data'], array($this, 'mySortMethod'));

        $viewObject = 'ab1/_report/'.$this->_sitePageData->languageID.'/competitor/price';
        $tmp = str_replace('\\', '/', $viewObject);
        try {
            $view = View::factory($tmp);
        }catch (Exception $e) {
            throw new Exception('Шаблон "'.$tmp.'" не найден.');
        }

        $view->products = $dataProducts;
        $view->competitors = $dataCompetitors;
        $view->capacities = $dataCapacities;
        $view->deliveries = $dataDeliveries;
        $view->deliveriesZHD = $dataDeliveriesZHD;
        $view->date = $dateTo;
        $view->rubricName = $modelRubric->getName();
        $view->operation = $this->_sitePageData->operation->getValues();
        $view->shop = $this->_sitePageData->shop->getName();
        $view->shopOptions = $this->_sitePageData->shop->getOptionsArray();
        $strView = Helpers_View::viewToStr($view);

        //header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Type: application/x-download;charset=UTF-8');
        header('Content-Disposition: filename="ПР05 Мониторинг цен конкурентов '.$modelRubric->getName().' '.Helpers_DateTime::getDateFormatRus($dateTo).'.xml"');
        header('Cache-Control: max-age=0');

        echo $strView;
        exit();
    }

    /**
     * Анализ работы грузоперевозок транспортных средств материала за 10 дней
     * @throws Exception
     */
    public function action_material_analysis_10() {
        set_time_limit(36000);

        $this->_sitePageData->url = '/'.$this->actionURLName.'/shopreport/material_analysis_10';

        $shopMaterialIDs = NULL;
        $rubric = Request_RequestParams::getParamInt('shop_material_rubric_id');

        $isQuantityReceive = Request_RequestParams::getParamBoolean('is_quantity_receive');

        // задаем время выборки
        $dateFrom = Request_RequestParams::getParamDate('date_from');
        $dateTo = Request_RequestParams::getParamDate('date_to');
        if(strtotime($dateTo) < strtotime($dateFrom)){
            $dateTo = $dateFrom;
        }

        $params = Request_RequestParams::setParams(
            array(
                'date_document_from' => $dateFrom,
                'date_document_to' => Helpers_DateTime::plusDays($dateTo, 1),
                'shop_branch_receiver_id' => $this->_sitePageData->shopID,
                'shop_material_rubric_id' => $rubric,
                'shop_transport_company_id' => Request_RequestParams::getParamInt('shop_transport_company_id'),
                'sort_by' => array(
                    'receiver_at' => 'asc'
                )
            )
        );
        $ids = Request_Request::find('DB_Ab1_Shop_Car_To_Material',
            $this->_sitePageData->shopMainID, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
            ['shop_daughter_id' =>  ['daughter_weight_id']]
        );

        $dataCars = array(
            'data' => array(),
            'count' => 0,
            'quantity' => 0,
            'dates' => array(),
        );
        foreach ($ids->childs as $child){
            $quantity = Api_Ab1_Shop_Car_To_Material::getQuantity($child, $isQuantityReceive);
            $name = $child->values['name'];

            // определяем смену
            $date = Helpers_DateTime::getDateFormatPHP($child->values['receiver_at']);

            // филиал
            if (! key_exists($name, $dataCars['data'])){
                $dataCars['data'][$name] = array(
                    'name' => $name,
                    'count' => 0,
                    'quantity' => 0,
                    'dates' => array(),
                );
            }

            // группируем по датам
            if (! key_exists($date, $dataCars['data'][$name]['dates'])){
                $dataCars['data'][$name]['dates'][$date] = array(
                    'count' => 0,
                    'quantity' => 0,
                );
            }

            $dataCars['data'][$name]['dates'][$date]['quantity'] += $quantity;
            $dataCars['data'][$name]['dates'][$date]['count'] ++;

            $dataCars['data'][$name]['quantity'] += $quantity;
            $dataCars['data'][$name]['count'] ++;

            $dataCars['quantity'] += $quantity;
            $dataCars['count'] ++;

            // группируем по датам
            if (! key_exists($date, $dataCars['dates'])){
                $dataCars['dates'][$date] = array(
                    'count' => 0,
                    'quantity' => 0,
                );
            }
            $dataCars['dates'][$date]['quantity'] += $quantity;
            $dataCars['dates'][$date]['count'] ++;
        }
        uasort($dataCars['data'], array($this, 'mySortMethod'));

        $viewObject = 'ab1/_report/'.$this->_sitePageData->languageID.'/material/analysis-10';
        if(Request_RequestParams::getParamBoolean('is_vertical')){
            $viewObject .= '-vertical';
        }

        $tmp = str_replace('\\', '/', $viewObject);
        try {
            $view = View::factory($tmp);
        }catch (Exception $e) {
            throw new Exception('Шаблон "'.$tmp.'" не найден.');
        }

        $view->operation = $this->_sitePageData->operation->getValues();
        $view->cars = $dataCars;
        $view->dateFrom = $dateFrom;
        $view->dateTo = $dateTo;
        $view->operation = $this->_sitePageData->operation->getValues();
        $view->shop = $this->_sitePageData->shop->getName();
        $view->shopOptions = $this->_sitePageData->shop->getOptionsArray();
        $strView = Helpers_View::viewToStr($view);

        header('Content-Type: application/x-download;charset=UTF-8');
        // header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: filename="АТ02 Анализ работы транспортных средств МАТЕРИАЛОВ за '.Helpers_DateTime::getDateFormatRus($dateFrom).' - '.Helpers_DateTime::getDateFormatRus($dateTo).'.xml"');
        header('Cache-Control: max-age=0');

        echo $strView;
        exit();
    }

    /**
     * Анализ работы грузоперевозок транспортных средств продукции
     * @throws Exception
     */
    public function action_product_analysis() {
        set_time_limit(36000);

        $this->_sitePageData->url = '/'.$this->actionURLName.'/shopreport/product_analysis';

        $shopMaterialIDs = NULL;

        $rubric = Request_RequestParams::getParamInt('shop_product_rubric_id');
        if($rubric > 0) {
            $shopProductIDs = Api_Ab1_Shop_Product::findAllByMainRubric(
                $rubric,
                $this->_sitePageData, $this->_driverDB
            );
        }else{
            $shopProductIDs = NULL;
        }

        // задаем время выборки
        $dateBasic = Request_RequestParams::getParamDateTime('date');
        if($dateBasic === NULL){
            $dateBasic = date('Y-m-d');
        }else{
            $dateBasic = Helpers_DateTime::getDateFormatPHP($dateBasic);
        }

        $dateFrom = $dateBasic . ' 06:00:00';
        $dateTo = date('d.m.Y',strtotime($dateBasic.' +1 day')) . ' 06:00:00';

        $params = Request_RequestParams::setParams(
            array(
                'exit_at_from' => $dateFrom,
                'exit_at_to' => $dateTo,
                'is_delivery' => TRUE,
                'shop_product_id' => $shopProductIDs,
            )
        );

        $dataProducts = array(
            'data' => array(),
            'quantity' => 0,
            'count' => 0,
        );

        /** Считывание машин с продукцией **/
        $ids = Request_Request::findBranch('DB_Ab1_Shop_Car_Item',
            array(), $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
            array('shop_id' => array('name'), 'shop_car_id' => array('name', 'exit_at'))
        );
        $listIDs = array();
        foreach ($ids->childs as $child){
            $id = $child->values['shop_car_id'];
            if(key_exists($id, $listIDs)){
                $count = 0;
            }else{
                $count = 1;
                $listIDs[$id] = '';
            }

            $quantity = $child->values['quantity'];
            $shopID = $child->values['shop_id'];
            $name = $child->getElementValue('shop_car_id');

            // определяем смену
            $exitAt = $child->getElementValue('shop_car_id', 'exit_at');
            $date = Helpers_DateTime::getDateFormatPHP($exitAt);
            $dateFrom = strtotime($date.' 06:00:00');
            $dateTo = strtotime($date.' 18:00:00');
            $date = strtotime($exitAt);
            if (($date > $dateFrom) && ($date <= $dateTo)) {
                $shopWorkShiftID = 1;
            }else{
                $shopWorkShiftID = 2;
            }

            // филиал
            if (! key_exists($shopID, $dataProducts['data'])){
                $dataProducts['data'][$shopID] = array(
                    'name' => $child->getElementValue('shop_id'),
                    'quantity' => 0,
                    'count' => 0,
                    'data' => array(),
                    'shift' => array(),
                );
            }

            // группируем по сменам
            if (! key_exists($shopWorkShiftID, $dataProducts['data'][$shopID]['shift'])){
                $dataProducts['data'][$shopID]['shift'][$shopWorkShiftID] = array(
                    'quantity' => 0,
                    'count' => 0,
                );
            }
            $dataProducts['data'][$shopID]['shift'][$shopWorkShiftID]['quantity'] += $quantity;
            $dataProducts['data'][$shopID]['shift'][$shopWorkShiftID]['count'] += $count;

            // группируем по машинам
            if (! key_exists($name, $dataProducts['data'][$shopID]['data'])){
                $dataProducts['data'][$shopID]['data'][$name] = array(
                    'name' => $name,
                    'quantity' => 0,
                    'count' => 0,
                    'shift' => array(),
                );
            }

            // группируем по сменам
            if (! key_exists($shopWorkShiftID, $dataProducts['data'][$shopID]['data'][$name]['shift'])){
                $dataProducts['data'][$shopID]['data'][$name]['shift'][$shopWorkShiftID] = array(
                    'quantity' => 0,
                    'count' => 0,
                );
            }

            $dataProducts['data'][$shopID]['data'][$name]['shift'][$shopWorkShiftID]['quantity'] += $quantity;
            $dataProducts['data'][$shopID]['data'][$name]['shift'][$shopWorkShiftID]['count'] += $count;

            $dataProducts['data'][$shopID]['data'][$name]['quantity'] += $quantity;
            $dataProducts['data'][$shopID]['data'][$name]['count'] += $count;

            $dataProducts['data'][$shopID]['quantity'] += $quantity;
            $dataProducts['data'][$shopID]['count'] += $count;

            $dataProducts['quantity'] += $quantity;
            $dataProducts['count'] += $count;
        }

        /** Считывание машин со штучним товаров **/
        $ids = Request_Request::findBranch('DB_Ab1_Shop_Piece_Item',
            array(), $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
            array('shop_id' => array('name'), 'shop_piece_id' => array('name', 'created_at'))
        );
        foreach ($ids->childs as $child){
            $id = 'p_'.$child->values['shop_piece_id'];
            if(key_exists($id, $listIDs)){
                $count = 0;
            }else{
                $count = 1;
                $listIDs[$id] = '';
            }

            $quantity = $child->values['quantity'];
            $shopID = $child->values['shop_id'];
            $name = $child->getElementValue('shop_piece_id');

            // определяем смену
            $exitAt = $child->getElementValue('shop_piece_id', 'created_at');
            $date = Helpers_DateTime::getDateFormatPHP($exitAt);
            $dateFrom = strtotime($date.' 06:00:00');
            $dateTo = strtotime($date.' 18:00:00');
            $date = strtotime($exitAt);
            if (($date > $dateFrom) && ($date <= $dateTo)) {
                $shopWorkShiftID = 1;
            }else{
                $shopWorkShiftID = 2;
            }

            // филиал
            if (! key_exists($shopID, $dataProducts['data'])){
                $dataProducts['data'][$shopID] = array(
                    'name' => $child->getElementValue('shop_id'),
                    'quantity' => 0,
                    'count' => 0,
                    'data' => array(),
                    'shift' => array(),
                );
            }

            // группируем по сменам
            if (! key_exists($shopWorkShiftID, $dataProducts['data'][$shopID]['shift'])){
                $dataProducts['data'][$shopID]['shift'][$shopWorkShiftID] = array(
                    'quantity' => 0,
                    'count' => 0,
                );
            }
            $dataProducts['data'][$shopID]['shift'][$shopWorkShiftID]['quantity'] += $quantity;
            $dataProducts['data'][$shopID]['shift'][$shopWorkShiftID]['count'] += $count;

            // группируем по машинам
            if (! key_exists($name, $dataProducts['data'][$shopID]['data'])){
                $dataProducts['data'][$shopID]['data'][$name] = array(
                    'name' => $name,
                    'quantity' => 0,
                    'count' => 0,
                    'shift' => array(),
                );
            }

            // группируем по сменам
            if (! key_exists($shopWorkShiftID, $dataProducts['data'][$shopID]['data'][$name]['shift'])){
                $dataProducts['data'][$shopID]['data'][$name]['shift'][$shopWorkShiftID] = array(
                    'quantity' => 0,
                    'count' => 0,
                );
            }

            $dataProducts['data'][$shopID]['data'][$name]['shift'][$shopWorkShiftID]['quantity'] += $quantity;
            $dataProducts['data'][$shopID]['data'][$name]['shift'][$shopWorkShiftID]['count'] += $count;

            $dataProducts['data'][$shopID]['data'][$name]['quantity'] += $quantity;
            $dataProducts['data'][$shopID]['data'][$name]['count'] += $count;

            $dataProducts['data'][$shopID]['quantity'] += $quantity;
            $dataProducts['data'][$shopID]['count'] += $count;

            $dataProducts['quantity'] += $quantity;
            $dataProducts['count'] += $count;
        }

        foreach ($dataProducts['data'] as &$shop){
            uasort($shop['data'], array($this, 'mySortMethod'));
        }
        uasort($dataProducts['data'], array($this, 'mySortMethod'));


        $viewObject = 'ab1/_report/'.$this->_sitePageData->languageID.'/product/analysis';
        $tmp = str_replace('\\', '/', $viewObject);
        try {
            $view = View::factory($tmp);
        }catch (Exception $e) {
            throw new Exception('Шаблон "'.$tmp.'" не найден.');
        }

        $view->products = $dataProducts;
        $view->date = $dateBasic;
        $view->operation = $this->_sitePageData->operation->getValues();
        $view->shop = $this->_sitePageData->shop->getName();
        $view->shopOptions = $this->_sitePageData->shop->getOptionsArray();
        $strView = Helpers_View::viewToStr($view);

        header('Content-Type: application/x-download;charset=UTF-8');
        // header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: filename="АТ03 Анализ работы транспортных средств ПРОДУКЦИИ за '.Helpers_DateTime::getDateFormatRus($dateBasic).'.xml"');
        header('Cache-Control: max-age=0');

        echo $strView;
        exit();
    }

    /**
     * Анализ работы грузоперевозок транспортных средств материала
     * @throws Exception
     */
    public function action_material_analysis() {
        set_time_limit(36000);

        $this->_sitePageData->url = '/'.$this->actionURLName.'/shopreport/material_analysis';

        $shopMaterialIDs = NULL;
        $rubric = Request_RequestParams::getParamInt('shop_material_rubric_id');

        $isQuantityReceive = Request_RequestParams::getParamBoolean('is_quantity_receive');

        // задаем время выборки
        $dateBasic = Request_RequestParams::getParamDateTime('date');
        if($dateBasic === NULL){
            $dateBasic = date('Y-m-d');
        }else{
            $dateBasic = Helpers_DateTime::getDateFormatPHP($dateBasic);
        }

        $dateFrom = $dateBasic . ' 07:00:00';
        $dateTo = date('d.m.Y',strtotime($dateBasic.' +1 day')) . ' 07:00:00';

        $params = Request_RequestParams::setParams(
            array(
                'date_document_from' => $dateFrom,
                'date_document_to' => $dateTo,
                'shop_branch_receiver_id' => $this->_sitePageData->shopID,
                'shop_material_rubric_id' => $rubric,
                'shop_transport_company_id' => Request_RequestParams::getParamInt('shop_transport_company_id'),
            )
        );
        $ids = Request_Request::find('DB_Ab1_Shop_Car_To_Material',
            $this->_sitePageData->shopMainID, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
            array(
                'shop_branch_receiver_id' => array('name'),
                'shop_branch_daughter_id' => array('name'),
                'shop_heap_receiver_id' => array('name'),
                'shop_subdivision_receiver_id' => array('name'),
                'shop_daughter_id' => array('daughter_weight_id'),
            )
        );

        $dataMaterials = array(
            'data' => array(),
            'quantity' => 0,
            'count' => 0,
            'heaps' => array(),
            'daughters' => array(),
        );
        foreach ($ids->childs as $child){
            $quantity = Api_Ab1_Shop_Car_To_Material::getQuantity($child, $isQuantityReceive);

            $count = 1;
            $shopID = $child->values['shop_branch_receiver_id'];
            $name = $child->values['name'];

            // определяем смену
            $date = Helpers_DateTime::getDateFormatPHP($child->values['receiver_at']);
            $dateFrom = strtotime($date.' 06:00:00');
            $dateTo = strtotime($date.' 18:00:00');
            $date = strtotime($child->values['receiver_at']);
            if (($date > $dateFrom) && ($date <= $dateTo)) {
                $shopWorkShiftID = 1;
            }else{
                $shopWorkShiftID = 2;
            }

            // филиал
            if (! key_exists($shopID, $dataMaterials['data'])){
                $dataMaterials['data'][$shopID] = array(
                    'name' => $child->getElementValue('shop_branch_receiver_id'),
                    'quantity' => 0,
                    'count' => 0,
                    'data' => array(),
                    'shift' => array(),
                );
            }

            // группируем по сменам
            if (! key_exists($shopWorkShiftID, $dataMaterials['data'][$shopID]['shift'])){
                $dataMaterials['data'][$shopID]['shift'][$shopWorkShiftID] = array(
                    'quantity' => 0,
                    'count' => 0,
                );
            }
            $dataMaterials['data'][$shopID]['shift'][$shopWorkShiftID]['quantity'] += $quantity;
            $dataMaterials['data'][$shopID]['shift'][$shopWorkShiftID]['count'] += $count;

            // группируем по машинам
            if (! key_exists($name, $dataMaterials['data'][$shopID]['data'])){
                $dataMaterials['data'][$shopID]['data'][$name] = array(
                    'name' => $name,
                    'quantity' => 0,
                    'count' => 0,
                    'shift' => array(),
                );
            }

            // группируем по сменам
            if (! key_exists($shopWorkShiftID, $dataMaterials['data'][$shopID]['data'][$name]['shift'])){
                $dataMaterials['data'][$shopID]['data'][$name]['shift'][$shopWorkShiftID] = array(
                    'quantity' => 0,
                    'count' => 0,
                );
            }

            $dataMaterials['data'][$shopID]['data'][$name]['shift'][$shopWorkShiftID]['quantity'] += $quantity;
            $dataMaterials['data'][$shopID]['data'][$name]['shift'][$shopWorkShiftID]['count'] += $count;

            $dataMaterials['data'][$shopID]['data'][$name]['quantity'] += $quantity;
            $dataMaterials['data'][$shopID]['data'][$name]['count'] += $count;

            $dataMaterials['data'][$shopID]['quantity'] += $quantity;
            $dataMaterials['data'][$shopID]['count'] += $count;

            $dataMaterials['quantity'] += $quantity;
            $dataMaterials['count'] += $count;

            /** @var Место завоза **/
            $heap = $child->values['shop_subdivision_receiver_id'];
            if (! key_exists($heap, $dataMaterials['heaps'])){
                $dataMaterials['heaps'][$heap] = array(
                    'name' => $child->getElementValue('shop_subdivision_receiver_id'),
                    'quantity' => 0,
                    'count' => 0,
                );
            }

            $dataMaterials['heaps'][$heap]['quantity'] += $quantity;
            $dataMaterials['heaps'][$heap]['count'] += $count;

            /** @var Филиал откуда завезли  **/
            $daughter = $child->values['shop_branch_daughter_id'];
            if (! key_exists($daughter, $dataMaterials['daughters'])){
                $dataMaterials['daughters'][$daughter] = array(
                    'name' => $child->getElementValue('shop_branch_daughter_id'),
                    'quantity' => 0,
                    'count' => 0,
                );
            }

            $dataMaterials['daughters'][$daughter]['quantity'] += $quantity;
            $dataMaterials['daughters'][$daughter]['count'] += $count;
        }

        foreach ($dataMaterials['data'] as &$shop){
            uasort($shop['data'], array($this, 'mySortMethod'));
        }
        uasort($dataMaterials['data'], array($this, 'mySortMethod'));


        $viewObject = 'ab1/_report/'.$this->_sitePageData->languageID.'/material/analysis';
        $tmp = str_replace('\\', '/', $viewObject);
        try {
            $view = View::factory($tmp);
        }catch (Exception $e) {
            throw new Exception('Шаблон "'.$tmp.'" не найден.');
        }

        $view->materials = $dataMaterials;
        $view->date = $dateBasic;
        $view->operation = $this->_sitePageData->operation->getValues();
        $view->shop = $this->_sitePageData->shop->getName();
        $view->shopOptions = $this->_sitePageData->shop->getOptionsArray();
        $strView = Helpers_View::viewToStr($view);

        header('Content-Type: application/x-download;charset=UTF-8');
        // header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: filename="АТ01 Анализ работы грузоперевозок транспортных средств МАТЕРИАЛА за '.Helpers_DateTime::getDateFormatRus($dateBasic).'.xml"');
        header('Cache-Control: max-age=0');

        echo $strView;
        exit();
    }

    /**
     * Анализ работы грузоперевозок транспортных средств балласта
     * @throws Exception
     */
    public function action_ballast_analysis() {
        set_time_limit(36000);

        $this->_sitePageData->url = '/'.$this->actionURLName.'/shopreport/ballast_analysis';

        $shopMaterialIDs = NULL;

        // задаем время выборки
        $dateBasic = Request_RequestParams::getParamDateTime('date');
        if($dateBasic === NULL){
            $dateBasic = date('Y-m-d');
        }else{
            $dateBasic = Helpers_DateTime::getDateFormatPHP($dateBasic);
        }

        $dateFrom = $dateBasic . ' 06:00:00';
        $dateTo = date('d.m.Y',strtotime($dateBasic.' +1 day')) . ' 06:00:00';

        $params = Request_RequestParams::setParams(
            array(
                'date_from' => $dateFrom,
                'date_to' => $dateTo,
                'count_id' => TRUE,
                'sum_quantity' => TRUE,
                'min_date' => TRUE,
                'max_date' => TRUE,
                'group_by' => array(
                    'shop_id', 'name', 'shop_id.name', 'shop_work_shift_id'
                ),
            )
        );
        $ids = Request_Request::findBranch('DB_Ab1_Shop_Ballast',
            array(), $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
            array('shop_id' => array('name'))
        );

        $dataBallasts = array(
            'data' => array(),
            'quantity' => 0,
            'count' => 0,
        );
        foreach ($ids->childs as $child){
            $quantity = $child->values['quantity'];
            $count = $child->values['count'];
            $shopID = $child->values['shop_id'];
            $name = $child->values['name'];
            $shopWorkShiftID = $child->values['shop_work_shift_id'];

            // филиал
            if (! key_exists($shopID, $dataBallasts['data'])){
                $dataBallasts['data'][$shopID] = array(
                    'name' => $child->getElementValue('shop_id'),
                    'quantity' => 0,
                    'count' => 0,
                    'data' => array(),
                    'shift' => array(),
                );
            }

            // группируем по сменам
            if (! key_exists($shopWorkShiftID, $dataBallasts['data'][$shopID]['shift'])){
                $dataBallasts['data'][$shopID]['shift'][$shopWorkShiftID] = array(
                    'quantity' => 0,
                    'count' => 0,
                );
            }
            $dataBallasts['data'][$shopID]['shift'][$shopWorkShiftID]['quantity'] += $quantity;
            $dataBallasts['data'][$shopID]['shift'][$shopWorkShiftID]['count'] += $count;

            // группируем по машинам
            if (! key_exists($name, $dataBallasts['data'][$shopID]['data'])){
                $dataBallasts['data'][$shopID]['data'][$name] = array(
                    'name' => $name,
                    'quantity' => 0,
                    'count' => 0,
                    'shift' => array(),
                );
            }

            // группируем по сменам
            if (! key_exists($shopWorkShiftID, $dataBallasts['data'][$shopID]['data'][$name]['shift'])){
                $dataBallasts['data'][$shopID]['data'][$name]['shift'][$shopWorkShiftID] = array(
                    'quantity' => 0,
                    'count' => 0,
                );
            }

            $dataBallasts['data'][$shopID]['data'][$name]['shift'][$shopWorkShiftID]['quantity'] += $quantity;
            $dataBallasts['data'][$shopID]['data'][$name]['shift'][$shopWorkShiftID]['count'] += $count;

            $dataBallasts['data'][$shopID]['data'][$name]['quantity'] += $quantity;
            $dataBallasts['data'][$shopID]['data'][$name]['count'] += $count;

            $dataBallasts['data'][$shopID]['quantity'] += $quantity;
            $dataBallasts['data'][$shopID]['count'] += $count;

            $dataBallasts['quantity'] += $quantity;
            $dataBallasts['count'] += $count;
        }

        foreach ($dataBallasts['data'] as &$shop){
            $shop['shift'] = array_values($shop['shift']);
            uasort($shop['data'], array($this, 'mySortMethod'));

            foreach ($shop['data'] as &$car){
                $car['shift'] = array_values($car['shift']);
            }
        }
        uasort($dataBallasts['data'], array($this, 'mySortMethod'));


        $viewObject = 'ab1/_report/'.$this->_sitePageData->languageID.'/ballast/analysis';
        $tmp = str_replace('\\', '/', $viewObject);
        try {
            $view = View::factory($tmp);
        }catch (Exception $e) {
            throw new Exception('Шаблон "'.$tmp.'" не найден.');
        }

        $view->ballasts = $dataBallasts;
        $view->date = $dateBasic;
        $view->operation = $this->_sitePageData->operation->getValues();
        $view->shop = $this->_sitePageData->shop->getName();
        $view->shopOptions = $this->_sitePageData->shop->getOptionsArray();
        $strView = Helpers_View::viewToStr($view);

        header('Content-Type: application/x-download;charset=UTF-8');
        // header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: filename="АТ04 Анализ работы транспортных средств БАЛЛАСТА за '.Helpers_DateTime::getDateFormatRus($dateBasic).'.xml"');
        header('Cache-Control: max-age=0');

        echo $strView;
        exit();
    }

    /**
     * Общий реестр по выгрузке мин.порошка
     * @throws Exception
     */
    public function action_mineral_powder_car_list() {
        set_time_limit(36000);

        $this->_sitePageData->url = '/'.$this->actionURLName.'/shopreport/mineral_powder_car_list';

        $shopMaterialIDs = NULL;

        // задаем время выборки
        $dateFrom = Request_RequestParams::getParamDateTime('created_at_from');
        $dateTo = Request_RequestParams::getParamDateTime('created_at_to');

        // id рубрики минирального порошка
        $rubric = 448080;

        $params = array(
            'date_document_from' => $dateFrom,
            'date_document_to' => $dateTo,
            'is_exit' => 1,
            'shop_material_id' => $shopMaterialIDs,
            'shop_material_rubric_id' => $rubric,
            'shop_daughter_id_from' => 0,
            'shop_branch_receiver_id' => $this->_sitePageData->shopID,
            'sort_by' => array(
                'update_tare_at' => 'asc',
                'name' => 'asc',
            ),
        );

        $params = Request_RequestParams::setParams(
            $params
        );
        $ids = Request_Request::find('DB_Ab1_Shop_Car_To_Material',
            $this->_sitePageData->shopMainID, $this->_sitePageData, $this->_driverDB,
            $params, 0, TRUE,
            array(
                'shop_daughter_id' => array('name', 'daughter_weight_id'),
                'shop_branch_daughter_id' => array('name'),
            )
        );

        $quantity = 0;
        $quantityDaughter = 0;
        $quantityInvoice = 0;
        $dataMaterials = array();
        foreach ($ids->childs as $child) {
            $quantity = Api_Ab1_Shop_Car_To_Material::getQuantity($child);

            $dataMaterials[] = array(
                'update_tare_at' => $child->values['update_tare_at'],
                'daughter' => $child->getElementValue('shop_branch_daughter_id', 'name', $child->getElementValue('shop_daughter_id')),
                'material' => $child->getElementValue('shop_material_id'),
                'name' => $child->values['name'],
                'quantity' => $quantity,
            );
        }

        $viewObject = 'ab1/_report/'.$this->_sitePageData->languageID.'/material/mineral-powder-list-car';
        $tmp = str_replace('\\', '/', $viewObject);
        try {
            $view = View::factory($tmp);
        }catch (Exception $e) {
            throw new Exception('Шаблон "'.$tmp.'" не найден.');
        }

        $view->materials = $dataMaterials;
        $view->quantity = $quantity;
        $view->quantityDaughter = $quantityDaughter;
        $view->quantityInvoice = $quantityInvoice;
        $view->operation = $this->_sitePageData->operation->getValues();
        $view->shop = $this->_sitePageData->shop->getName();
        $view->shopOptions = $this->_sitePageData->shop->getOptionsArray();
        $strView = Helpers_View::viewToStr($view);

        header('Content-Type: application/x-download;charset=UTF-8');
        // header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: filename="ВГ09 Общий реестр по выгрузке мин.порошка.xml"');
        header('Cache-Control: max-age=0');

        echo $strView;
        exit();
    }

    /*
     * Аналитика заявок (заявленно - реализовано) за месяц
     */
    public function action_bid_analysis_month() {
        set_time_limit(36000);

        $this->_sitePageData->url = '/'.$this->actionURLName.'/shopreport/bid_analysis_month';

        //  использовать сокращенное имя для вывода в шапке таблицы
        $isSortName = Request_RequestParams::getParamBoolean('is_sort_name');

        // получаем филиалы
        $shopIDs = Request_Shop::getBranchShopIDs($this->_sitePageData->shopMainID, $this->_sitePageData, $this->_driverDB)->getChildArrayID();
        $shopIDs[] = $this->_sitePageData->shopMainID;

        $dataGroups = array(
            'data' => array(),
        );

        // получаем группы продукции
        if(!$isSortName) {
            $params = Request_RequestParams::setParams(
                array(
                    'is_write_report' => TRUE,
                    'sort_by' => array(
                        'order' => 'asc',
                        'name' => 'asc',
                    )
                )
            );
            $shopProductGroupIDs = Request_Request::find('DB_Ab1_Shop_Product_Group',
                $this->_sitePageData->shopMainID, $this->_sitePageData, $this->_driverDB,
                $params, 0, TRUE
            );
            foreach ($shopProductGroupIDs->childs as $child) {
                $dataGroups['data'][] = array(
                    'name' => $child->values['name'],
                    'id' => $child->id
                );
            }
        }

        /** Планируемая реализация продукции **/
        $shopProductIDs = NULL;
        $dateFrom = Request_RequestParams::getParamDateTime('date_from');
        $dateTo = Request_RequestParams::getParamDateTime('date_to');
        $params = Request_RequestParams::setParams(
            array(
                'date_from' => $dateFrom,
                'date_to' => $dateTo,
                'shop_product_id' => $shopProductIDs,
            )
        );
        $ids = Request_Request::findBranch('DB_Ab1_Shop_Bid_Item',
            $shopIDs, $this->_sitePageData, $this->_driverDB, $params,0, TRUE,
            array(
                'shop_client_id' => array('name'),
                'shop_product_id' => array('name', 'name_short', 'shop_product_group_id'),
            )
        );
        $shopClients = $ids->getChildArrayInt('shop_client_id', TRUE);

        $dataClients = array(
            'data' => array(
                'main' => array(
                    'data' => array(),
                ),
                'branch' => array(
                    'data' => array(),
                )
            )
        );
        foreach ($ids->childs as $child){
            $quantity = $child->values['quantity'];
            $client = $child->values['shop_client_id'];

            $shopID = $child->values['shop_id'];
            if($shopID == $this->_sitePageData->shopMainID){
                $shopID = 'main';
            }else{
                $shopID = 'branch';
            }
            if(!$isSortName) {
                $group = $child->getElementValue('shop_product_id', 'shop_product_group_id');
            }else{
                $group = $child->getElementValue('shop_product_id', 'name_short');
                if (!key_exists($group, $dataGroups['data'])) {
                    $dataGroups['data'][$group] = array(
                        'name' => $group,
                        'id' => $group,
                    );
                }
            }

            if (!key_exists($client, $dataClients['data'][$shopID]['data'])) {
                $dataClients['data'][$shopID]['data'][$client] = array(
                    'plan' => array(
                        'data' => array(),
                        'quantity' => 0,
                    ),
                    'realization' => array(
                        'data' => array(),
                        'quantity' => 0,
                    ),
                    'name' => $child->getElementValue('shop_client_id'),
                );

                if($client == 0){
                    $dataClients['data'][$shopID]['data'][$client]['name'] = 'Прочие';
                }
            }

            if (!key_exists($group, $dataClients['data'][$shopID]['data'][$client]['plan']['data'])) {
                $dataClients['data'][$shopID]['data'][$client]['plan']['data'][$group] = $quantity;
            } else {
                $dataClients['data'][$shopID]['data'][$client]['plan']['data'][$group] += $quantity;
            }

            $dataClients['data'][$shopID]['data'][$client]['plan']['quantity'] += $quantity;
        }

        /** Итоговая реализация продукции **/
        $params = Request_RequestParams::setParams(
            array(
                'exit_at_from' => $dateFrom,
                'exit_at_to' => Helpers_DateTime::plusDays($dateTo, 1),
                'is_exit' => TRUE,
                'is_charity' => FALSE,
                'shop_product_id' => $shopProductIDs,
            )
        );
        $ids = Request_Request::findBranch('DB_Ab1_Shop_Car_Item',
            $shopIDs, $this->_sitePageData, $this->_driverDB, $params,0, TRUE,
            array(
                'shop_client_id' => array('name'),
                'shop_product_id' => array('name', 'name_short', 'shop_product_group_id'),
            )
        );
        $pieceIDs = Request_Request::findBranch('DB_Ab1_Shop_Piece_Item',
            $shopIDs, $this->_sitePageData, $this->_driverDB, $params,0, TRUE,
            array(
                'shop_client_id' => array('name'),
                'shop_product_id' => array('name', 'name_short', 'shop_product_group_id'),
            )
        );
        $ids->childs = array_merge($ids->childs, $pieceIDs->childs);

        foreach ($ids->childs as $child){
            $quantity = $child->values['quantity'];
            $client = $child->values['shop_client_id'];
            if(!key_exists($client, $shopClients)){
                $client = 0;
            }

            $shopID = $child->values['shop_id'];
            if($shopID == $this->_sitePageData->shopMainID){
                $shopID = 'main';
            }else{
                $shopID = 'branch';
            }
            if(!$isSortName) {
                $group = $child->getElementValue('shop_product_id', 'shop_product_group_id');
            }else{
                $group = $child->getElementValue('shop_product_id', 'name_short');
                if (!key_exists($group, $dataGroups['data'])) {
                    $dataGroups['data'][$group] = array(
                        'name' => $group,
                        'id' => $group,
                    );
                }
            }

            if (!key_exists($client, $dataClients['data'][$shopID]['data'])) {
                $dataClients['data'][$shopID]['data'][$client] = array(
                    'plan' => array(
                        'data' => array(

                        ),
                        'quantity' => 0,
                    ),
                    'realization' => array(
                        'data' => array(

                        ),
                        'quantity' => 0,
                    ),
                    'name' => $child->getElementValue('shop_client_id'),
                );
            }

            if (!key_exists($group, $dataClients['data'][$shopID]['data'][$client]['realization']['data'])) {
                $dataClients['data'][$shopID]['data'][$client]['realization']['data'][$group] = $quantity;
            } else {
                $dataClients['data'][$shopID]['data'][$client]['realization']['data'][$group] += $quantity;
            }

            $dataClients['data'][$shopID]['data'][$client]['realization']['quantity'] += $quantity;
        }

        uasort($dataGroups['data'], array($this, 'mySortMethod'));
        foreach ($dataClients['data'] as &$clients){
            uasort($clients['data'], array($this, 'mySortMethod'));
        }

        $viewObject = 'ab1/_report/'.$this->_sitePageData->languageID.'/bid/analysis-month';
        $tmp = str_replace('\\', '/', $viewObject);
        try {
            $view = View::factory($tmp);
        }catch (Exception $e) {
            throw new Exception('Шаблон "'.$tmp.'" не найден.');
        }

        $view->clients = $dataClients;
        $view->groups = $dataGroups;
        $view->dateFrom = $dateFrom;
        $view->dateTo = $dateTo;
        $view->operation = $this->_sitePageData->operation->getValues();
        $view->shop = $this->_sitePageData->shop->getName();
        $view->shopOptions = $this->_sitePageData->shop->getOptionsArray();
        $strView = Helpers_View::viewToStr($view);

        header('Content-Type: application/x-download;charset=UTF-8');
        // header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: filename="ПР03 Анализ реализации продукции за месяц c '.Helpers_DateTime::getDateFormatRus($dateFrom) . ' по ' . Helpers_DateTime::getDateFormatRus($dateTo).'.xml"');
        header('Cache-Control: max-age=0');

        echo $strView;
        exit();
    }

    /*
     * Аналитика заявок (заявленно - реализовано) фиксированные отчет
     */
    public function action_plan_analysis_fixed() {
        set_time_limit(36000);

        $this->_sitePageData->url = '/'.$this->actionURLName.'/shopreport/plan_analysis_fixed';

        // получаем филиалы
        $shopIDs = Request_Shop::getBranchShopIDs($this->_sitePageData->shopMainID, $this->_sitePageData, $this->_driverDB)->getChildArrayID();
        $shopIDs[] = $this->_sitePageData->shopMainID;

        // получаем группы продукции
        $params = Request_RequestParams::setParams(
            array(
               'is_write_report' => TRUE,
               'sort_by' => array(
                   'order' => 'asc',
                   'name' => 'asc',
               )
            )
        );
        $shopProductGroupIDs = Request_Request::find('DB_Ab1_Shop_Product_Group',
            $this->_sitePageData->shopMainID, $this->_sitePageData, $this->_driverDB,
            $params, 0, TRUE
        );
        $dataGroups = array(
            'data' => array(),
        );
        foreach ($shopProductGroupIDs->childs as $child){
            $dataGroups['data'][] = array(
                'name' => $child->values['name'],
                'id' => $child->id
            );
        }

        /** Планируемая реализация продукции **/
        $shopProductIDs = NULL;
        $dateFrom = Request_RequestParams::getParamDateTime('date_from');
        $dateTo = Request_RequestParams::getParamDateTime('date_to');
        $params = Request_RequestParams::setParams(
            array(
                'plan_date_from_equally' => $dateFrom,
                'plan_date_to' => $dateTo,
                'shop_product_id' => $shopProductIDs,
            )
        );
        $ids = Request_Request::findBranch('DB_Ab1_Shop_Plan_Item',
            $shopIDs, $this->_sitePageData, $this->_driverDB, $params,0, TRUE,
            array(
                'shop_client_id' => array('name'),
                'shop_product_id' => array('name', 'shop_product_group_id'),
            )
        );
        $shopClients = $ids->getChildArrayInt('shop_client_id', TRUE);

        $dataClients = array(
            'data' => array(
                'main' => array(
                    'data' => array(),
                ),
                'branch' => array(
                    'data' => array(),
                )
            )
        );
        foreach ($ids->childs as $child){
            $quantity = $child->values['quantity'];
            $client = $child->values['shop_client_id'];

            $shopID = $child->values['shop_id'];
            if($shopID == $this->_sitePageData->shopMainID){
                $shopID = 'main';
            }else{
                $shopID = 'branch';
            }
            $group = $child->getElementValue('shop_product_id', 'shop_product_group_id');

            if (!key_exists($client, $dataClients['data'][$shopID]['data'])) {
                $dataClients['data'][$shopID]['data'][$client] = array(
                    'plan' => array(
                        'data' => array(),
                        'quantity' => 0,
                    ),
                    'realization' => array(
                        'data' => array(),
                        'quantity' => 0,
                    ),
                    'name' => $child->getElementValue('shop_client_id'),
                );

                if($client == 0){
                    $dataClients['data'][$shopID]['data'][$client]['name'] = 'Прочие';
                }
            }

            if (!key_exists($group, $dataClients['data'][$shopID]['data'][$client]['plan']['data'])) {
                $dataClients['data'][$shopID]['data'][$client]['plan']['data'][$group] = $quantity;
            } else {
                $dataClients['data'][$shopID]['data'][$client]['plan']['data'][$group] += $quantity;
            }

            $dataClients['data'][$shopID]['data'][$client]['plan']['quantity'] += $quantity;
        }

        /** Итоговая реализация продукции **/
        $params = Request_RequestParams::setParams(
            array(
                'exit_at_from' => $dateFrom,
                'exit_at_to' => Helpers_DateTime::plusDays($dateTo, 1),
                'is_exit' => TRUE,
                'is_charity' => FALSE,
                'shop_product_id' => $shopProductIDs,
            )
        );
        $ids = Request_Request::findBranch('DB_Ab1_Shop_Car_Item',
            $shopIDs, $this->_sitePageData, $this->_driverDB, $params,0, TRUE,
            array(
                'shop_client_id' => array('name'),
                'shop_product_id' => array('name', 'shop_product_group_id'),
            )
        );

        foreach ($ids->childs as $child){
            $quantity = $child->values['quantity'];
            $client = $child->values['shop_client_id'];
            if(!key_exists($client, $shopClients)){
                $client = 0;
            }

            $shopID = $child->values['shop_id'];
            if($shopID == $this->_sitePageData->shopMainID){
                $shopID = 'main';
            }else{
                $shopID = 'branch';
            }
            $group = $child->getElementValue('shop_product_id', 'shop_product_group_id');

            if (!key_exists($client, $dataClients['data'][$shopID]['data'])) {
                $dataClients['data'][$shopID]['data'][$client] = array(
                    'plan' => array(
                        'data' => array(

                        ),
                        'quantity' => 0,
                    ),
                    'realization' => array(
                        'data' => array(

                        ),
                        'quantity' => 0,
                    ),
                    'name' => $child->getElementValue('shop_client_id'),
                );
            }

            if (!key_exists($group, $dataClients['data'][$shopID]['data'][$client]['realization']['data'])) {
                $dataClients['data'][$shopID]['data'][$client]['realization']['data'][$group] = $quantity;
            } else {
                $dataClients['data'][$shopID]['data'][$client]['realization']['data'][$group] += $quantity;
            }

            $dataClients['data'][$shopID]['data'][$client]['realization']['quantity'] += $quantity;
        }

        foreach ($dataClients['data'] as &$clients){
            uasort($clients['data'], array($this, 'mySortMethod'));
        }

        $viewObject = 'ab1/_report/'.$this->_sitePageData->languageID.'/plan/analysis-fixed';
        $tmp = str_replace('\\', '/', $viewObject);
        try {
            $view = View::factory($tmp);
        }catch (Exception $e) {
            throw new Exception('Шаблон "'.$tmp.'" не найден.');
        }

        $view->clients = $dataClients;
        $view->groups = $dataGroups;
        $view->dateFrom = $dateFrom;
        $view->dateTo = $dateTo;
        $view->operation = $this->_sitePageData->operation->getValues();
        $view->shop = $this->_sitePageData->shop->getName();
        $view->shopOptions = $this->_sitePageData->shop->getOptionsArray();
        $strView = Helpers_View::viewToStr($view);

        header('Content-Type: application/x-download;charset=UTF-8');
        // header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: filename="ПР02 Анализ реализации продукции на '.Helpers_DateTime::getDateFormatRus($dateFrom).'.xml"');
        header('Cache-Control: max-age=0');

        echo $strView;
        exit();
    }

    /**
     * Отчет список машин с материалом версия 2
     * @throws Exception
     */
    public function action_material_list_car_v2() {
        set_time_limit(36000);

        $this->_sitePageData->url = '/'.$this->actionURLName.'/shopreport/material_list_car_v2';


        // задаем время выборки
        $dateFrom = Request_RequestParams::getParamDateTime('created_at_from');
        $dateTo = Request_RequestParams::getParamDateTime('created_at_to');

        $params = array(
            'is_exit' => 1,
            'shop_material_id' => Request_RequestParams::getParamInt('shop_material_id'),
            'shop_transport_company_id' => Request_RequestParams::getParamInt('shop_transport_company_id'),
            'sort_by' => array(
                'shop_daughter_id' => 'desc',
                'shop_branch_daughter_id' => 'asc',
                'name' => 'asc',
                'created_at' => 'asc'
            ),
        );

        $params['shop_branch_receiver_id'] = $this->_sitePageData->shopID;
        $params['date_document_from'] = $dateFrom;
        $params['date_document_to'] = $dateTo;

        $params = Request_RequestParams::setParams(
            $params
        );
        $ids = Request_Request::find('DB_Ab1_Shop_Car_To_Material',
            $this->_sitePageData->shopMainID, $this->_sitePageData, $this->_driverDB,
            $params, 0, TRUE,
            array(
                'shop_transport_company_id' => array('name'), 'shop_material_id' => array('name'),
                'shop_driver_id' => array('name'),
                'shop_heap_daughter_id' => array('name'),
                'shop_heap_receiver_id' => array('name'),
                'shop_subdivision_daughter_id' => array('name'),
                'shop_subdivision_receiver_id' => array('name'),
                'shop_branch_receiver_id' => array('name'),
            )
        );
        $quantity = 0;
        $quantityDaughter = 0;
        $quantityInvoice = 0;
        $dataMaterials = array();
        foreach ($ids->childs as $child){
            $dataMaterials[] = array(
                'created_at' => $child->values['created_at'],
                'receiver_at' => $child->values['receiver_at'],
                'name' => $child->values['name'],
                'shop_driver_name' => $child->getElementValue('shop_driver_id'),
                'transport_company' => $child->getElementValue('shop_transport_company_id'),
                'receiver' => $child->getElementValue('shop_branch_receiver_id'),
                'material' => $child->getElementValue('shop_material_id'),
                'quantity' => $child->values['quantity'],
                'quantity_daughter' => $child->values['quantity_daughter'],
                'quantity_invoice' => $child->values['quantity_invoice'],
                'heap_receiver' => $child->getElementValue('shop_heap_receiver_id'),
                'subdivision_receiver' => $child->getElementValue('shop_subdivision_receiver_id'),
            );

            $quantity += $child->values['quantity'];
            $quantityDaughter += $child->values['quantity_daughter'];
            $quantityInvoice += $child->values['quantity_invoice'];
        }

        $viewObject = 'ab1/_report/'.$this->_sitePageData->languageID.'/material/list-car-v2';
        $tmp = str_replace('\\', '/', $viewObject);
        try {
            $view = View::factory($tmp);
        }catch (Exception $e) {
            throw new Exception('Шаблон "'.$tmp.'" не найден.');
        }

        $view->materials = $dataMaterials;
        $view->quantity = $quantity;
        $view->quantityDaughter = $quantityDaughter;
        $view->quantityInvoice = $quantityInvoice;
        $view->operation = $this->_sitePageData->operation->getValues();
        $view->shop = $this->_sitePageData->shop->getName();
        $view->shopOptions = $this->_sitePageData->shop->getOptionsArray();
        $strView = Helpers_View::viewToStr($view);

        header('Content-Type: application/x-download;charset=UTF-8');
        // header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: filename="ВС11 Список машин с материалом версия 2.xml"');
        header('Cache-Control: max-age=0');

        echo $strView;
        exit();
    }

    /**
     * Формируем данные для сохранения в Excel реестра акта выполненных работ
     * @param Model_Ab1_Shop_Act_Service $model
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @return array
     */
    private function _getActServiceRegistry(Model_Ab1_Shop_Act_Service $model, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver) {
        /** @var Model_Ab1_Shop_Client $client */
        $client = $model->getElement('shop_client_id', TRUE, $sitePageData->shopMainID);

        // накладная
        $actService = array(
            'number' => $model->getNumber(),
            'created_at' => $model->getCreatedAt(),
            'shop_client_name' => $client->getName(),
            'shop_client_address' => $client->getAddress(),
            'shop_client_bin' => $client->getBin(),
            'date' => $model->getDate(),
        );

        /** @var Model_Ab1_Shop_Client_Contract $contract */
        $contract = $model->getElement('shop_client_contract_id', TRUE, $sitePageData->shopMainID);
        if($contract !== NULL){
            $actService['shop_client_contract_number'] = $contract->getNumber();
            $actService['shop_client_contract_from_at'] = $contract->getFromAt();
        }

        $params = Request_RequestParams::setParams(
            array(
                'shop_act_service_id' => $model->id,
            )
        );
        $shopCarItemIDs = Request_Request::find('DB_Ab1_Shop_Car',
            $sitePageData->shopID, $sitePageData, $driver, $params, 0, TRUE,
            array('shop_delivery_id' => array('name_1c', 'price'))
        );
        $shopPieceItemIDs = Request_Request::find('DB_Ab1_Shop_Piece',
            $sitePageData->shopID, $sitePageData, $driver, $params, 0, TRUE,
            array('shop_delivery_id' => array('name_1c', 'price'))
        );

        $dataActServiceItems = array(
            'data' => array(),
            'delivery_quantity' => 0,
            'delivery_amount' => 0,
        );

        foreach ($shopCarItemIDs->childs as $child){
            $amount = $child->values['delivery_amount'];
            $quantity = $child->values['quantity'];

            $dataActServiceItems['data'][] = array(
                'id' => $child->values['id'],
                'name' => $child->values['name'],
                'exit_at' => $child->values['exit_at'],
                'delivery_name' => $child->getElementValue('shop_delivery_id', 'name_1c'),
                'delivery_price' => $child->getElementValue('shop_delivery_id', 'price') ,
                'delivery_quantity' => $quantity,
                'delivery_amount' => $amount,
            );

            $dataActServiceItems['delivery_amount'] += $amount;
            $dataActServiceItems['delivery_quantity'] += $quantity;
        }

        foreach ($shopPieceItemIDs->childs as $child){
            $amount = $child->values['delivery_amount'];
            $quantity = $child->values['quantity'];

            $dataActServiceItems['data'][] = array(
                'id' => $child->values['id'],
                'name' => $child->values['name'],
                'exit_at' => $child->values['created_at'],
                'delivery_name' => $child->getElementValue('shop_delivery_id', 'name_1c'),
                'delivery_price' => $child->getElementValue('shop_delivery_id', 'price') ,
                'delivery_quantity' => $quantity,
                'delivery_amount' => $amount,
            );

            $dataActServiceItems['delivery_amount'] += $amount;
            $dataActServiceItems['delivery_quantity'] += $quantity;
        }

        // Сортировка
        uasort($dataActServiceItems['data'], array($this, 'mySortMethod'));

        return array(
            'actServiceItems' => $dataActServiceItems,
            'actService' => $actService,
        );
    }

    /**
     * Реестр машин для основного СБЫТа
     */
    public function action_act_service_registry() {
        set_time_limit(36000);

        $this->_sitePageData->url = '/'.$this->actionURLName.'/shopreport/service_registry';

        $shopActServiceID = Request_RequestParams::getParamInt('id');

        $model = new Model_Ab1_Shop_Act_Service();
        $model->setDBDriver($this->_driverDB);
        if(!Helpers_DB::getDBObject($model, $shopActServiceID, $this->_sitePageData)){
            throw new HTTP_Exception_500('Act service not found.');
        }

        $data = $this->_getActServiceRegistry($model, $this->_sitePageData, $this->_driverDB);


        $viewObject = 'ab1/_report/'.$this->_sitePageData->languageID.'/act-service/registry';
        $tmp = str_replace('\\', '/', $viewObject);
        try {
            $view = View::factory($tmp);
        }catch (Exception $e) {
            throw new Exception('Шаблон "'.$tmp.'" не найден.');
        }

        $view->actServiceItems = $data['actServiceItems'];
        $view->actService = $data['actService'];
        $view->currency = $this->_sitePageData->currency;
        $view->operation = $this->_sitePageData->operation->getValues();
        $view->shop = $this->_sitePageData->shop->getName();
        $view->shopOptions = $this->_sitePageData->shop->getOptionsArray();
        $strView = Helpers_View::viewToStr($view);

        header('Content-Type: application/x-download;charset=UTF-8');
        // header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: filename="Реестр №'.$data['actService']['number'].'.xml"');
        header('Cache-Control: max-age=0');

        echo $strView;
        exit();
    }

    /**
     * Реестр машин для основного СБЫТа
     */
    public function action_act_service_print_registry() {
        set_time_limit(36000);

        $this->_sitePageData->url = '/'.$this->actionURLName.'/shopreport/act_service_print_registry';

        $isIssued = Request_RequestParams::getParamBoolean('is_issued');

        $params = array_merge($_GET, $_POST);
        unset($params['limit_page']);
        $params['sort_by'] = ['date' => 'asc'];
        $params = Request_RequestParams::setParams($params);

        $shopInvoiceIDs = Request_Request::find('DB_Ab1_Shop_Act_Service',
            $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB,
            $params, 0, TRUE
        );

        $model = new Model_Ab1_Shop_Act_Service();
        $model->setDBDriver($this->_driverDB);

        $dataActServices = array(
            'data' => array(),
        );
        foreach ($shopInvoiceIDs->childs as $child){
            $child->setModel($model);
            $dataActServices['data'][] = $this->_getActServiceRegistry($model, $this->_sitePageData, $this->_driverDB);

            if($isIssued){
                $model->setDateGiveToClient(date('Y-m-d H:i:s'));
                Helpers_DB::saveDBObject($model, $this->_sitePageData, $model->shopID);
            }
        }

        $viewObject = 'ab1/_report/'.$this->_sitePageData->languageID.'/act-service/print-registry';
        $tmp = str_replace('\\', '/', $viewObject);
        try {
            $view = View::factory($tmp);
        }catch (Exception $e) {
            throw new Exception('Шаблон "'.$tmp.'" не найден.');
        }

        $view->actServices = $dataActServices;
        $view->currency = $this->_sitePageData->currency;
        $view->operation = $this->_sitePageData->operation->getValues();
        $view->shop = $this->_sitePageData->shop->getName();
        $view->shopOptions = $this->_sitePageData->shop->getOptionsArray();
        $strView = Helpers_View::viewToStr($view);

        header('Content-Type: application/x-download;charset=UTF-8');
        // header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: filename="Реестры для выдачи клиентам.xml"');
        header('Cache-Control: max-age=0');

        echo $strView;
        exit();
    }

    /**
     * Формируем данные для сохранения в Excel акта выполненных работ
     * @param Model_Ab1_Shop_Act_Service $model
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @return array
     */
    private function _getActService(Model_Ab1_Shop_Act_Service $model, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver) {
        /** @var Model_Ab1_Shop_Client $client */
        $client = $model->getElement('shop_client_id', TRUE, $this->_sitePageData->shopMainID);

        // накладная
        $actService = array(
            'number' => $model->getNumber(),
            'created_at' => $model->getCreatedAt(),
            'shop_client_name' => $client->getName(),
            'shop_client_address' => $client->getAddress(),
            'shop_client_bin' => $client->getBin(),
            'date' => $model->getDate(),
        );

        /** @var Model_Ab1_Shop_Client_Contract $contract */
        $contract = $model->getElement('shop_client_contract_id', TRUE, $sitePageData->shopMainID);
        if($contract !== NULL){
            $actService['shop_client_contract_number'] = $contract->getNumber();
            $actService['shop_client_contract_from_at'] = $contract->getFromAt();
        }

        $params = Request_RequestParams::setParams(
            array(
                'shop_act_service_id' => $model->id,
            )
        );
        $shopCarIDs = Request_Request::find('DB_Ab1_Shop_Car',
            $sitePageData->shopID, $sitePageData, $driver, $params, 0, TRUE,
            array('shop_delivery_id' => array('name_1c', 'unit'))
        );
        $shopPieceIDs = Request_Request::find('DB_Ab1_Shop_Piece',
            $sitePageData->shopID, $sitePageData, $driver, $params, 0, TRUE,
            array('shop_delivery_id' => array('name_1c', 'unit'))
        );

        $dataActServiceItems = array(
            'data' => array(),
            'quantity' => 0,
            'amount' => 0,
            'count' => 0,
        );

        foreach ($shopCarIDs->childs as $child){
            $amount = $child->values['delivery_amount'];
            $quantity = $child->values['quantity'];
            $shopDeliveryID = $child->values['shop_delivery_id'];

            if(!key_exists($shopDeliveryID, $dataActServiceItems['data'])){
                $dataActServiceItems['data'][$shopDeliveryID] = array(
                    'name' => $child->getElementValue('shop_delivery_id', 'name_1c'),
                    'unit' => $child->getElementValue('shop_delivery_id', 'unit') ,
                    'quantity' => $quantity,
                    'amount' => $amount,
                );
            }else{
                $dataActServiceItems['data'][$shopDeliveryID]['amount']  += $amount;
                $dataActServiceItems['data'][$shopDeliveryID]['quantity'] += $quantity;
            }

            $dataActServiceItems['amount'] += $amount;
            $dataActServiceItems['quantity'] += $quantity;
            $dataActServiceItems['count'] ++;
        }

        foreach ($shopPieceIDs->childs as $child){
            $amount = $child->values['delivery_amount'];
            $quantity = $child->values['quantity'];
            $shopDeliveryID = $child->values['shop_delivery_id'];

            if(!key_exists($shopDeliveryID, $dataActServiceItems['data'])){
                $dataActServiceItems['data'][$shopDeliveryID] = array(
                    'name' => $child->getElementValue('shop_delivery_id', 'name_1c'),
                    'unit' => $child->getElementValue('shop_delivery_id', 'unit') ,
                    'quantity' => $quantity,
                    'amount' => $amount,
                );
            }else{
                $dataActServiceItems['data'][$shopDeliveryID]['amount']  += $amount;
                $dataActServiceItems['data'][$shopDeliveryID]['quantity'] += $quantity;
            }

            $dataActServiceItems['amount'] += $amount;
            $dataActServiceItems['quantity'] += $quantity;
            $dataActServiceItems['count'] ++;
        }

        $params = Request_RequestParams::setParams(
            array(
                'shop_act_service_id' => $model->id,
            )
        );
        $shopAdditionServiceItemIDs = Request_Request::find('DB_Ab1_Shop_Addition_Service_Item',
            $sitePageData->shopID, $sitePageData, $driver, $params, 0, TRUE,
            array('shop_product_id' => array('name_1c', 'unit'))
        );

        foreach ($shopAdditionServiceItemIDs->childs as $child){
            $amount = $child->values['amount'];
            $quantity = $child->values['quantity'];
            $shopProductID = 'p'.$child->values['shop_product_id'];

            if(!key_exists($shopProductID, $dataActServiceItems['data'])){
                $dataActServiceItems['data'][$shopProductID] = array(
                    'name' => $child->getElementValue('shop_product_id', 'name_1c'),
                    'unit' => $child->getElementValue('shop_product_id', 'unit') ,
                    'quantity' => $quantity,
                    'amount' => $amount,
                );
            }else{
                $dataActServiceItems['data'][$shopProductID]['amount']  += $amount;
                $dataActServiceItems['data'][$shopProductID]['quantity'] += $quantity;
            }

            $dataActServiceItems['amount'] += $amount;
            $dataActServiceItems['quantity'] += $quantity;
            $dataActServiceItems['count'] ++;
        }

        // Сортировка
        uasort($dataActServiceItems['data'], array($this, 'mySortMethod'));

        return array(
            'actServiceItems' => $dataActServiceItems,
            'actService' => $actService,
        );
    }

    /**
     * Акт выполнненных работ для основного СБЫТа
     */
    public function action_act_service_one() {
        set_time_limit(36000);

        $this->_sitePageData->url = '/'.$this->actionURLName.'/shopreport/act_service_one';

        $shopActServiceID = Request_RequestParams::getParamInt('id');

        $model = new Model_Ab1_Shop_Act_Service();
        $model->setDBDriver($this->_driverDB);
        if(!Helpers_DB::getDBObject($model, $shopActServiceID, $this->_sitePageData)){
            throw new HTTP_Exception_500('Act service not found.');
        }

        $data = $this->_getActService($model, $this->_sitePageData, $this->_driverDB);

        $viewObject = 'ab1/_report/'.$this->_sitePageData->languageID.'/act-service/one';
        $tmp = str_replace('\\', '/', $viewObject);
        try {
            $view = View::factory($tmp);
        }catch (Exception $e) {
            throw new Exception('Шаблон "'.$tmp.'" не найден.');
        }

        $view->actServiceItems = $data['actServiceItems'];
        $view->actService = $data['actService'];
        $view->currency = $this->_sitePageData->currency;
        $view->operation = $this->_sitePageData->operation->getValues();
        $view->shop = $this->_sitePageData->shop->getName();
        $view->shopOptions = $this->_sitePageData->shop->getOptionsArray();
        $strView = Helpers_View::viewToStr($view);

        header('Content-Type: application/x-download;charset=UTF-8');
        // header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: filename="Акт выполненных работ №'.$data['actService']['number'].'.xml"');
        header('Cache-Control: max-age=0');

        echo $strView;
        exit();
    }

    /**
     * Акт выполнненных работ для основного СБЫТа
     */
    public function action_act_service_print_list() {
        set_time_limit(36000);

        $this->_sitePageData->url = '/'.$this->actionURLName.'/shopreport/act_service_print_list';

        $isIssued = Request_RequestParams::getParamBoolean('is_issued');

        $params = array_merge($_GET, $_POST);
        unset($params['limit_page']);
        $params['sort_by'] = ['date' => 'asc'];
        $params = Request_RequestParams::setParams($params);

        $shopInvoiceIDs = Request_Request::find('DB_Ab1_Shop_Act_Service',
            $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB,
            $params, 0, TRUE
        );

        $model = new Model_Ab1_Shop_Act_Service();
        $model->setDBDriver($this->_driverDB);

        $dataActServices = array(
            'data' => array(),
        );
        foreach ($shopInvoiceIDs->childs as $child){
            $child->setModel($model);
            $dataActServices['data'][] = $this->_getActService($model, $this->_sitePageData, $this->_driverDB);

            if($isIssued){
                $model->setDateGiveToClient(date('Y-m-d H:i:s'));
                Helpers_DB::saveDBObject($model, $this->_sitePageData, $model->shopID);
            }
        }

        $viewObject = 'ab1/_report/'.$this->_sitePageData->languageID.'/act-service/print-list';
        $tmp = str_replace('\\', '/', $viewObject);
        try {
            $view = View::factory($tmp);
        }catch (Exception $e) {
            throw new Exception('Шаблон "'.$tmp.'" не найден.');
        }

        $view->actServices = $dataActServices;
        $view->currency = $this->_sitePageData->currency;
        $view->operation = $this->_sitePageData->operation->getValues();
        $view->shop = $this->_sitePageData->shop->getName();
        $view->shopOptions = $this->_sitePageData->shop->getOptionsArray();
        $strView = Helpers_View::viewToStr($view);

        header('Content-Type: application/x-download;charset=UTF-8');
        // header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: filename="Акт выполненных работ для выдачи клиентам.xml"');
        header('Cache-Control: max-age=0');

        echo $strView;
        exit();
    }

    /*
     * Заявка (план на один день) фиксированные отчет
     */
    public function action_plan_day_fixed() {
        set_time_limit(36000);

        $this->_sitePageData->url = '/'.$this->actionURLName.'/shopreport/plan_day_fixed';

        /** Планируемая реализация продукции **/

        $shopProductIDs = NULL;
        $dateFrom = Request_RequestParams::getParamDateTime('date_from');
        $dateTo = Request_RequestParams::getParamDateTime('date_to');
        $params = Request_RequestParams::setParams(
            array(
                'plan_date_from_equally' => $dateFrom,
                'plan_date_to' => $dateTo,
                'shop_product_id' => $shopProductIDs,
            )
        );
        $shopIDs = Request_Shop::getBranchShopIDs($this->_sitePageData->shopMainID, $this->_sitePageData, $this->_driverDB)->getChildArrayID();
        $shopIDs[] = $this->_sitePageData->shopMainID;

        $ids = Request_Request::findBranch('DB_Ab1_Shop_Plan_Item',
            $shopIDs, $this->_sitePageData, $this->_driverDB, $params,0, TRUE,
            array(
                'shop_id' => array('name'),
                'shop_client_id' => array('name'),
                'shop_product_id' => array('name', 'shop_product_group_id'),
                'shop_plan_id' => array('car_count', 'facility', 'date_from', 'date_to', 'deliveries'),
            )
        );

        $params = Request_RequestParams::setParams();
        $shopProductGroupIDs = Request_Request::find('DB_Ab1_Shop_Product_Group',
            $this->_sitePageData->shopMainID, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE
        );
        $shopProductGroupIDs->runIndex();

        $dataNightGroups = array();

        $dataClients = array(
            'data' => array(
                'main' => array(
                    'data' => array(),
                    'quantity' => 0,
                    'transports' => 0,
                    'groups' => array(),
                ),
                'branch' => array(
                    'data' => array(),
                    'quantity' => 0,
                    'transports' => 0,
                    'groups' => array(),
                ),
                'concrete' => array(
                    'data' => array(),
                    'quantity' => 0,
                    'transports' => 0,
                    'groups' => array(),
                ),
            ),
            'quantity' => 0,
            'transports' => 0,
        );

        // получаем список спецтранспорта
        $params = Request_RequestParams::setParams();
        $shopSpecialTransportIDs = Request_Request::find('DB_Ab1_Shop_Special_Transport',
            $this->_sitePageData->shopMainID, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE
        );
        $shopSpecialTransportIDs->runIndex(TRUE);

        $dataDeliveries = array(
            'data' => array(),
            'count' => 0,
            'shop_plans' => array(),
        );
        foreach ($ids->childs as $child){
            $quantity = $child->values['quantity'];
            $carCount = intval($child->getElementValue('shop_plan_id', 'car_count'));
            $client = $child->values['shop_client_id'];
            $workingShift = $child->values['working_shift'];

            $shopID = $child->values['shop_id'];
            if($shopID == $this->_sitePageData->shopMainID){
                $shopID = 'main';
            }else{
                $shopID = 'branch';
            }
            $group = $child->getElementValue('shop_product_id', 'shop_product_group_id');
            if($group == 568433) {
                $shopID = 'concrete';
            }

            if (!key_exists($client, $dataClients['data'][$shopID]['data'])) {
                $dataClients['data'][$shopID]['data'][$client] = array(
                    'data' => array(),
                    'name' => $child->getElementValue('shop_client_id'),
                    'date_from' => $child->getElementValue('shop_plan_id', 'date_from'),
                    'date_to' => $child->getElementValue('shop_plan_id', 'date_to'),
                    'object' => $child->getElementValue('shop_plan_id', 'facility'),
                    'quantity' => 0,
                    'transports' => 0,
                    'transport_list' => array(),
                    'groups' => array(),
                    'night' => array(),
                );
            }

            if($workingShift > 1){
                if (! key_exists($group, $dataNightGroups)){
                    $name = Helpers_DB::getDBObjectValue(
                        'name', new Model_Ab1_Shop_Product_Group(), $group, $this->_sitePageData, $this->_driverDB,
                        $this->_sitePageData->shopMainID
                    );
                    $dataNightGroups[$group] = array(
                        'name' => $name,
                        'id' => $group,
                        'quantity' => 0,
                    );
                }

                if (!key_exists($group, $dataClients['data'][$shopID]['data'][$client]['night'])) {
                    $dataClients['data'][$shopID]['data'][$client]['night'][$group] = $quantity;
                } else {
                    $dataClients['data'][$shopID]['data'][$client]['night'][$group] += $quantity;
                }
            }else {
                if (!key_exists($group, $dataClients['data'][$shopID]['data'][$client]['groups'])) {
                    $dataClients['data'][$shopID]['data'][$client]['groups'][$group] = $quantity;
                } else {
                    $dataClients['data'][$shopID]['data'][$client]['groups'][$group] += $quantity;
                }
            }

            $dataClients['data'][$shopID]['data'][$client]['quantity'] += $quantity;
            $dataClients['data'][$shopID]['quantity'] += $quantity;
            $dataClients['quantity'] += $quantity;

            if(!key_exists($child->values['shop_plan_id'], $dataClients['data'][$shopID]['data'][$client]['transport_list'])) {
                $dataClients['data'][$shopID]['data'][$client]['transport_list'][$child->values['shop_plan_id']] = TRUE;

                $dataClients['data'][$shopID]['data'][$client]['transports'] += $carCount;
                $dataClients['data'][$shopID]['transports'] += $carCount;
                $dataClients['transports'] += $carCount;
            }

            // собираем доставку
            if(!key_exists($child->values['shop_plan_id'], $dataDeliveries['shop_plans'])) {
                $dataDeliveries['shop_plans'][$child->values['shop_plan_id']] = '';
                $deliveries = json_decode($child->getElementValue('shop_plan_id', 'deliveries'), TRUE);
                if(is_array($deliveries)) {
                    foreach ($deliveries as $delivery) {
                        if((!key_exists('count', $delivery)) || (!key_exists('shop_special_transport_id', $delivery))){
                            continue;
                        }

                        $transport = $delivery['shop_special_transport_id'];
                        if (!key_exists($transport, $shopSpecialTransportIDs->childs)) {
                            continue;
                        }

                        $keyTransport = $client . '_' . $transport;
                        if(!key_exists($keyTransport, $dataDeliveries['data'])) {
                            $dataDeliveries['data'][$keyTransport] = array(
                                'shop_client_name' => $child->getElementValue('shop_client_id'),
                                'count' => $delivery['count'],
                                'shop_special_transport_name' => $shopSpecialTransportIDs->childs[$transport]->values['name'],
                            );
                        }else{
                            $dataDeliveries['data'][$keyTransport]['count'] += $delivery['count'];
                        }
                    }
                }
            }
        }
        foreach ($dataClients['data'] as &$clients){
            uasort($clients['data'], array($this, 'mySortMethod'));
        }

        /** Вывод спецтранспорта **/
        $params = Request_RequestParams::setParams(
            array(
                'date_from_equally' => $dateFrom,
                'date_to' => $dateTo,
            )
        );
        $shopPlanTransportItemIDs = Request_Request::find('DB_Ab1_Shop_Plan_Transport_Item',
            $this->_sitePageData->shopMainID, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
            array('shop_special_transport_id' => array('name'))
        );

        $dataTransports = array(
            'data' => array(
                0 => array(
                    'data' => array(),
                    'count' => 0,
                ),
                1 => array(
                    'data' => array(),
                    'count' => 0,
                ),
            ),
            'count' => 0,
        );
        foreach ($shopPlanTransportItemIDs->childs as $child){
            $count = $child->values['count'];
            $workingShift = $child->values['working_shift'];
            $isBSU = $child->values['is_bsu'];
            $shopSpecialTransportID = $child->values['shop_special_transport_id'];

            if (!key_exists($shopSpecialTransportID, $dataTransports['data'][$isBSU]['data'])) {
                $dataTransports['data'][$isBSU]['data'][$shopSpecialTransportID] = array(
                    'data' => array(),
                    'name' => $child->getElementValue('shop_special_transport_id'),
                    'count' => $count,
                );
            }else{
                $dataTransports['data'][$isBSU]['data'][$shopSpecialTransportID]['count'] += $count;
            }
            if(!$isBSU){
                 if (!key_exists($workingShift, $dataTransports['data'][$isBSU]['data'][$shopSpecialTransportID]['data'])) {
                    $dataTransports['data'][$isBSU]['data'][$shopSpecialTransportID]['data'][$workingShift] = $count;
                }else{
                     $dataTransports['data'][$isBSU]['data'][$shopSpecialTransportID]['data'][$workingShift] += $count;
                }
            }

            $dataTransports['data'][$isBSU]['count'] += $count;
            $dataTransports['count'] += $count;
        }

        $viewObject = 'ab1/_report/'.$this->_sitePageData->languageID.'/plan/day-fixed';
        $tmp = str_replace('\\', '/', $viewObject);
        try {
            $view = View::factory($tmp);
        }catch (Exception $e) {
            throw new Exception('Шаблон "'.$tmp.'" не найден.');
        }

        $view->clientAbs = $dataClients['data']['main'];
        $view->clientBranches = $dataClients['data']['branch'];
        $view->clientConcretes = $dataClients['data']['concrete'];
        $view->nightGroups = $dataNightGroups;
        $view->transports = $dataTransports;
        $view->deliveries = $dataDeliveries;
        $view->dateFrom = $dateFrom;
        $view->dateTo = $dateTo;
        $view->operation = $this->_sitePageData->operation->getValues();
        $view->shop = $this->_sitePageData->shop->getName();
        $view->shopOptions = $this->_sitePageData->shop->getOptionsArray();
        $strView = Helpers_View::viewToStr($view);

        header('Content-Type: application/x-download;charset=UTF-8');
        // header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: filename="ПР01 Анализ реализации продукции за месяцЗаявка на '.Helpers_DateTime::getDateFormatRus($dateFrom).'.xml"');
        header('Cache-Control: max-age=0');

        echo $strView;
        exit();
    }

    /**
     * Формируем данные для сохранения в Excel накладной
     * @param Model_Ab1_Shop_Invoice $model
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @return array
     */
    private function _getInvoice(Model_Ab1_Shop_Invoice $model, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver) {
        // накладная
        $invoice = array(
            'number' => $model->getNumber(),
            'created_at' => $model->getCreatedAt(),
            'client' => $model->getElement('shop_client_id', TRUE, $sitePageData->shopMainID)->getName1C(),
            'date' => $model->getDate(),
        );

        // доверенность
        /** @var Model_Ab1_Shop_Client_Attorney $modelAttorney */
        $modelAttorney = $model->getElement('shop_client_attorney_id', TRUE);
        if($modelAttorney !== NULL) {
            $attorney = array(
                'number' => $modelAttorney->getNumber(),
                'client_name' => $modelAttorney->getClientName(),
                'from_at' => $modelAttorney->getFromAt(),
            );
        }else{
            $attorney = array();
        }

        $params = Request_RequestParams::setParams(
            array(
                'shop_invoice_id' => $model->id,
            )
        );
        $shopCarItemIDs = Request_Request::find('DB_Ab1_Shop_Car_Item',
            $sitePageData->shopID, $sitePageData, $driver, $params, 0, TRUE,
            array('shop_product_id' => array('name_1c', 'unit', 'old_id'))
        );
        $shopPieceItemIDs = Request_Request::find('DB_Ab1_Shop_Piece_Item',
            $sitePageData->shopID, $sitePageData, $driver, $params, 0, TRUE,
            array('shop_product_id' => array('name_1c', 'unit', 'old_id'))
        );

        $dataInvoiceItems = array(
            'data' => array(),
            'quantity' => 0,
            'amount' => 0,
        );

        foreach ($shopCarItemIDs->childs as $child){
            $amount = $child->values['amount'];
            $quantity = $child->values['quantity'];
            $shopProductID = $child->values['shop_product_id'].'_'.$child->values['price'];

            if(!key_exists($shopProductID, $dataInvoiceItems['data'])){
                $dataInvoiceItems['data'][$shopProductID] = array(
                    'name' => $child->getElementValue('shop_product_id', 'name_1c'),
                    'old_id' => $child->getElementValue('shop_product_id', 'old_id') ,
                    'unit' => $child->getElementValue('shop_product_id', 'unit') ,
                    'quantity' => $quantity,
                    'price' => $child->values['price'],
                    'amount' => $amount,
                );
            }else{
                $dataInvoiceItems['data'][$shopProductID]['amount']  += $amount;
                $dataInvoiceItems['data'][$shopProductID]['quantity'] += $quantity;
            }

            $dataInvoiceItems['amount'] += $amount;
            $dataInvoiceItems['quantity'] += $quantity;
        }

        foreach ($shopPieceItemIDs->childs as $child){
            $amount = $child->values['amount'];
            $quantity = $child->values['quantity'];
            $shopProductID = $child->values['shop_product_id'].'_'.$child->values['price'];

            if(!key_exists($shopProductID, $dataInvoiceItems['data'])){
                $dataInvoiceItems['data'][$shopProductID] = array(
                    'name' => $child->getElementValue('shop_product_id', 'name_1c'),
                    'old_id' => $child->getElementValue('shop_product_id', 'old_id') ,
                    'unit' => $child->getElementValue('shop_product_id', 'unit') ,
                    'quantity' => $quantity,
                    'price' => $child->values['price'],
                    'amount' => $amount,
                );
            }else{
                $dataInvoiceItems['data'][$shopProductID]['amount']  += $amount;
                $dataInvoiceItems['data'][$shopProductID]['quantity'] += $quantity;
            }

            $dataInvoiceItems['amount'] += $amount;
            $dataInvoiceItems['quantity'] += $quantity;
        }

        // Сортировка
        uasort($dataInvoiceItems['data'], array($this, 'mySortMethod'));

        return array(
            'invoiceItems' => $dataInvoiceItems,
            'invoice' => $invoice,
            'attorney' => $attorney,
        );
    }

    /**
     * Накладная для основного СБЫТа
     */
    public function action_invoice_one() {
        set_time_limit(36000);

        $this->_sitePageData->url = '/'.$this->actionURLName.'/shopreport/invoice_one';

        $shopInvoiceID = Request_RequestParams::getParamInt('id');

        $model = new Model_Ab1_Shop_Invoice();
        $model->setDBDriver($this->_driverDB);
        if(!Helpers_DB::getDBObject($model, $shopInvoiceID, $this->_sitePageData)){
            throw new HTTP_Exception_500('Invoice not found.');
        }

        $data = $this->_getInvoice($model, $this->_sitePageData, $this->_driverDB);

        $viewObject = 'ab1/_report/'.$this->_sitePageData->languageID.'/invoice/one';
        $tmp = str_replace('\\', '/', $viewObject);
        try {
            $view = View::factory($tmp);
        }catch (Exception $e) {
            throw new Exception('Шаблон "'.$tmp.'" не найден.');
        }

        $view->invoiceItems = $data['invoiceItems'];
        $view->invoice = $data['invoice'];
        $view->attorney = $data['attorney'];
        $view->currency = $this->_sitePageData->currency;
        $view->operation = $this->_sitePageData->operation->getValues();
        $view->shop = $this->_sitePageData->shop->getName();
        $view->shopOptions = $this->_sitePageData->shop->getOptionsArray();
        $strView = Helpers_View::viewToStr($view);

        header('Content-Type: application/x-download;charset=UTF-8');
        // header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: filename="Накладная №'.$data['invoice']['number'].'.xml"');
        header('Cache-Control: max-age=0');

        echo $strView;
        exit();
    }

    /**
     * Печати списка накладных для основного СБЫТа
     */
    public function action_invoice_print_list() {
        set_time_limit(36000);

        $this->_sitePageData->url = '/'.$this->actionURLName.'/shopreport/invoice_print_list';

        $isIssued = Request_RequestParams::getParamBoolean('is_issued');

        $params = array_merge($_GET, $_POST);
        unset($params['limit_page']);
        $params['sort_by'] = ['date' => 'asc'];
        $params = Request_RequestParams::setParams($params);

        $shopInvoiceIDs = Request_Request::find('DB_Ab1_Shop_Invoice',
            $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB,
            $params, 0, TRUE
        );

        $model = new Model_Ab1_Shop_Invoice();
        $model->setDBDriver($this->_driverDB);

        $dataInvoices = array(
            'data' => array(),
        );
        foreach ($shopInvoiceIDs->childs as $child){
            $child->setModel($model);
            $dataInvoices['data'][] = $this->_getInvoice($model, $this->_sitePageData, $this->_driverDB);

            if($isIssued){
                $model->setDateGiveToClient(date('Y-m-d H:i:s'));
                $model->setIsInvoiceGiveToClient(true);
                Helpers_DB::saveDBObject($model, $this->_sitePageData, $model->shopID);
            }
        }

        $viewObject = 'ab1/_report/'.$this->_sitePageData->languageID.'/invoice/print-list';
        $tmp = str_replace('\\', '/', $viewObject);
        try {
            $view = View::factory($tmp);
        }catch (Exception $e) {
            throw new Exception('Шаблон "'.$tmp.'" не найден.');
        }

        $view->invoices = $dataInvoices;
        $view->currency = $this->_sitePageData->currency;
        $view->operation = $this->_sitePageData->operation->getValues();
        $view->shop = $this->_sitePageData->shop->getName();
        $view->shopOptions = $this->_sitePageData->shop->getOptionsArray();
        $strView = Helpers_View::viewToStr($view);

        header('Content-Type: application/x-download;charset=UTF-8');
        // header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: filename="Накладные для выдачи клиентам.xml"');
        header('Cache-Control: max-age=0');

        echo $strView;
        exit();
    }

    /**
     * Расширяем диапозон времени в массиве у заданного ключа для диапозона времени АСУ
     * @param array $list
     * @param $key
     * @param $from
     * @param $to
     * @param array $values
     */
    private function _editPeriodWorkTimeASU(array &$list, $key, $from, $to, array $values = array()) {
        $fromD = strtotime($from);
        $toD = strtotime($to);

        if(!key_exists($key, $list)){
            $list[$key] = array_merge(
                $values,
                array(
                    'from' => $from,
                    'from_d' => $fromD,
                    'to' => $to,
                    'to_d' => $toD,
                    'data' => array(),
                )
            );
        }else{
            if($list[$key]['to_d'] < $toD){
                $list[$key]['to'] = $to;
                $list[$key]['to_d'] = $toD;
            }

            if($list[$key]['from_d'] > $fromD){
                $list[$key]['from'] = $from;
                $list[$key]['from_d'] = $fromD;
            }
        }
    }

    /**
     * Порядковый номер для диапозона времени АСУ
     * @param array $list
     * @param $from
     * @param $to
     * @return int
     */
    private function _getIndexPeriodWorkTimeASU(array &$list, $from, $to) {
        $fromD = strtotime($from);
        $toD = strtotime($to);

        $index = count($list) - 1;
        if($index < 0){
            return 0;
        }

        if((((($list[$index]['from_d'] <= $fromD)
                && ($list[$index]['to_d'] >= $fromD))
            || (($list[$index]['from_d'] <= $toD)
                && ($list[$index]['to_d'] >= $toD))
            || (($list[$index]['from_d'] <= $fromD)
                && ($list[$index]['to_d'] >= $toD))))){
            return $index;
        }

        return $index + 1;
    }

    /**
     * Период работы диспетчеров по созданию заявок вместо Малого сбыта
     */
    public function action_work_time_asu() {
        set_time_limit(36000);

        $this->_sitePageData->url = '/'.$this->actionURLName.'/shopreport/work_time_asu';

        $params = Request_RequestParams::setParams(
            array(
                'is_exit' => 1,
                'is_empty_asu_at' => FALSE,
                'sort_by' => array(
                    'weighted_entry_at' => 'asc',
                )
            ),
            FALSE
        );
        $ids = Request_Request::find('DB_Ab1_Shop_Car',
            $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
            array('shop_turn_place_id' => array('name'))
        );

        $dataDates = array(
            'data' => array(),
        );

        foreach ($ids->childs as $child){
            $from = $child->values['weighted_entry_at'];
            $fromDay = Helpers_DateTime::getDateFormatRus($from);

            $to = $toFirst = $child->values['asu_at'];
            $toDay = Helpers_DateTime::getDateFormatRus($to);

          //  echo $child->values['weighted_entry_at'].'-';
          //  echo $child->values['asu_at'].'  ';

            // если выезд был на следующий день
            if($fromDay != $toDay){
                // Расширяем диапозон времени дня
                $this->_editPeriodWorkTimeASU($dataDates['data'], $toDay, $toDay, $toFirst);
                $to = Helpers_DateTime::getDateFormatPHP($toDay);
            }

            // Расширяем диапозон времени дня
            $this->_editPeriodWorkTimeASU($dataDates['data'], $fromDay, $from, $to);


            /** группа АСУ **/
            $shopTurnPlaceID = $child->values['shop_turn_place_id'];

            if($fromDay != $toDay){
                // Расширяем диапозон времени дня
                $this->_editPeriodWorkTimeASU(
                    $dataDates['data'][$toDay]['data'], $shopTurnPlaceID, $toDay, $toFirst,
                    array(
                        'name' => $child->getElementValue('shop_turn_place_id', 'name')
                    )
                );
            }

            // Расширяем диапозон времени дня
            $this->_editPeriodWorkTimeASU(
                $dataDates['data'][$fromDay]['data'], $shopTurnPlaceID, $from, $to,
                array(
                    'name' => $child->getElementValue('shop_turn_place_id', 'name')
                )
            );

            /** группа диапозон **/

            if($fromDay != $toDay){
                $index = $this->_getIndexPeriodWorkTimeASU(
                    $dataDates['data'][$toDay]['data'][$shopTurnPlaceID]['data'], $from, $to
                );
                // Расширяем диапозон времени дня
                $this->_editPeriodWorkTimeASU(
                    $dataDates['data'][$toDay]['data'][$shopTurnPlaceID]['data'], $index, $toDay, $toFirst
                );
            }

            $index = $this->_getIndexPeriodWorkTimeASU(
                $dataDates['data'][$fromDay]['data'][$shopTurnPlaceID]['data'], $from, $to
            );
            // Расширяем диапозон времени дня
            $this->_editPeriodWorkTimeASU($dataDates['data'][$fromDay]['data'][$shopTurnPlaceID]['data'], $index, $from, $to);
        }

        // Сортировка
        foreach ($dataDates['data'] as &$asu){
            uasort($asu['data'], array($this, 'mySortMethod'));
        }

        // пересчитываем диапозоны, перехода между днями, если этот диапозон меньше 2 часов, то соединяем их
        /*$from = NULL;
        $fromPeriod = NULL;
        $fromOperation = NULL;
        foreach ($dataDates['data'] as &$dataDate){
            if(($from !== NULL)
                && ($dataDate['from_d'] - $from['to_d'] < 4 * 60 * 60)
                && (Helpers_DateTime::getDateFormatPHP($dataDate['from']) != Helpers_DateTime::getDateFormatPHP($from['to']))){
                $from['to'] = Helpers_DateTime::getDateFormatPHP($dataDate['from']);
                $dataDate['from'] = $from['to'];
            }
            $from = &$dataDate;

            foreach ($dataDate['data'] as &$dataPeriod){
                if(($fromPeriod !== NULL)
                    && ($dataPeriod['from_d'] - $fromPeriod['to_d'] < 4 * 60 * 60)
                    && (Helpers_DateTime::getDateFormatPHP($dataPeriod['from']) != Helpers_DateTime::getDateFormatPHP($fromPeriod['to']))
                    && (Helpers_DateTime::getDateFormatPHP($dataPeriod['from']) != Helpers_DateTime::getDateFormatPHP($fromPeriod['to']))
                ){
                    $fromPeriod['to'] = Helpers_DateTime::getDateFormatPHP($dataPeriod['from']);
                    $dataPeriod['from'] = $fromPeriod['to'];
                }
                $fromPeriod = &$dataPeriod;

                uasort($dataPeriod['data'], array($this, 'mySortMethod'));

                foreach ($dataPeriod['data'] as &$dataOperation){
                    if(($fromOperation !== NULL)
                        && ($dataOperation['name'] == $fromOperation['name'])
                        && ($dataOperation['from_d'] - $fromOperation['to_d'] < 4 * 60 * 60)
                        && (Helpers_DateTime::getDateFormatPHP($dataOperation['from']) != Helpers_DateTime::getDateFormatPHP($fromOperation['to']))){
                        $fromOperation['to'] = Helpers_DateTime::getDateFormatPHP($dataOperation['from']);
                        $dataOperation['from'] = $fromOperation['to'];
                    }
                    $fromOperation = &$dataOperation;
                }
            }
        }*/

        // делаем итоговые данные по АСУ
        $dataASUs = array(
            'total' => 0,
            'data' => array(),
        );
        foreach ($dataDates['data'] as &$dataDate){
            foreach ($dataDate['data'] as &$dataASU){
                foreach ($dataASU['data'] as &$dataPeriod){
                    $diff = Helpers_DateTime::diffHours($dataPeriod['to'], $dataPeriod['from']);
                    $dataASUs['total'] += $diff;

                    $name = $dataASU['name'];
                    if(!key_exists($name, $dataASUs['data'])){
                        $dataASUs['data'][$name] = array(
                            'name' => $name,
                            'total' => 0,
                        );
                    }

                    $dataASUs['data'][$name]['total'] += $diff;
                }
            }
        }

        uasort($dataASUs['data'], array($this, 'mySortMethod'));

        $viewObject = 'ab1/_report/'.$this->_sitePageData->languageID.'/work_time_asu';
        $tmp = str_replace('\\', '/', $viewObject);
        try {
            $view = View::factory($tmp);
        }catch (Exception $e) {
            throw new Exception('Шаблон "'.$tmp.'" не найден.');
        }

        $view->dates = $dataDates;
        $view->asus = $dataASUs;
        $view->operation = $this->_sitePageData->operation->getValues();
        $view->shop = $this->_sitePageData->shop->getName();
        $view->shopOptions = $this->_sitePageData->shop->getOptionsArray();
        $strView = Helpers_View::viewToStr($view);

        header('Content-Type: application/x-download;charset=UTF-8');
        // header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: filename="АБ08 Время работы АСУ.xml"');
        header('Cache-Control: max-age=0');

        echo $strView;
        exit();
    }

    /*
     * Заявка (план на один день)
     */
    public function action_plan_day() {
        set_time_limit(36000);

        $this->_sitePageData->url = '/'.$this->actionURLName.'/shopreport/plan_day';

        $shopProductIDs = NULL;
        $date = Request_RequestParams::getParamDateTime('date');


        $params = Request_RequestParams::setParams(
            array(
                'date' => $date,
                'shop_product_id' => $shopProductIDs,
            )
        );
        $shopIDs = Request_Shop::getBranchShopIDs($this->_sitePageData->shopMainID, $this->_sitePageData, $this->_driverDB)->getChildArrayID();
        $shopIDs[] = $this->_sitePageData->shopMainID;

        $ids = Request_Request::findBranch('DB_Ab1_Shop_Plan_Item',
            $shopIDs, $this->_sitePageData, $this->_driverDB, $params,0, TRUE,
            array(
                'shop_id' => array('name'),
                'shop_client_id' => array('name'),
                'shop_product_id' => array('name'),
                'shop_plan_id' => array('car_count', 'facility', 'date_from', 'date_to'),
            )
        );

        $products = array();
        foreach ($ids->childs as $child){
            $product = $child->values['shop_product_id'];
            if (! key_exists($product, $products)){
                $products[$product] = array(
                    'quantity' => 0,
                    'car_count' => 0,
                    'data' => array(),
                    'name' => $child->getElementValue('shop_product_id'),
                );
            }
        }
        uasort($products, array($this, 'mySortMethod'));

        $dataProducts = $products;
        $dataClients = array(
            'data' => array(),
            'quantity' => 0,
            'car_count' => 0,
        );
        foreach ($ids->childs as $child){
            $quantity = $child->values['quantity'];
            $carCount = intval($child->getElementValue('shop_plan_id', 'car_count'));

            $shopID = $child->values['shop_id'];
            if (! key_exists($shopID, $dataClients['data'])){
                $dataClients['data'][$shopID] = array(
                    'data' => array(),
                    'name' => $child->getElementValue('shop_id'),
                    'quantity' => 0,
                    'car_count' => 0,
                    'products' => $products,
                );
            }

            $product = $child->values['shop_product_id'];
            $dataProducts[$product]['quantity'] += $quantity;
            $dataProducts[$product]['car_count'] += $carCount;

            $client = $child->values['shop_client_id'];
            $facility = $child->getElementValue('shop_plan_id', 'facility');

            $key = $client.'_'.$facility;
            if (! key_exists($key, $dataClients['data'][$shopID]['data'])){
                $dataClients['data'][$shopID]['data'][$key] = array(
                    'data' => $products,
                    'name' => $child->getElementValue('shop_client_id'),
                    'facility' => $facility,
                    'quantity' => 0,
                    'car_count' => 0,
                    'time_from' => Helpers_DateTime::getTimeByDate($child->getElementValue('shop_plan_id', 'date_from')),
                    'time_to' => Helpers_DateTime::getTimeByDate($child->getElementValue('shop_plan_id', 'date_to')),
                );
            }


            $dataClients['data'][$shopID]['products'][$product]['quantity'] += $quantity;
            $dataClients['data'][$shopID]['products'][$product]['car_count'] += $carCount;

            $dataClients['data'][$shopID]['data'][$key]['data'][$product]['quantity'] += $quantity;
            $dataClients['data'][$shopID]['data'][$key]['data'][$product]['car_count'] += $carCount;

            $dataClients['data'][$shopID]['data'][$key]['quantity'] += $quantity;
            $dataClients['data'][$shopID]['data'][$key]['car_count'] += $carCount;

            $dataClients['data'][$shopID]['quantity'] += $quantity;
            $dataClients['data'][$shopID]['car_count'] += $carCount;

            $dataClients['quantity'] += $quantity;
            $dataClients['car_count'] += $carCount;
        }
        uasort($dataClients['data'], array($this, 'mySortMethod'));

        $viewObject = 'ab1/_report/'.$this->_sitePageData->languageID.'/plan/day';
        $tmp = str_replace('\\', '/', $viewObject);
        try {
            $view = View::factory($tmp);
        }catch (Exception $e) {
            throw new Exception('Шаблон "'.$tmp.'" не найден.');
        }

        $view->products = $dataProducts;
        $view->clients = $dataClients;
        $view->date = $date;
        $view->operation = $this->_sitePageData->operation->getValues();
        $view->shop = $this->_sitePageData->shop->getName();
        $view->shopOptions = $this->_sitePageData->shop->getOptionsArray();
        $strView = Helpers_View::viewToStr($view);

        header('Content-Type: application/x-download;charset=UTF-8');
        // header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: filename="Заявка на '.Helpers_DateTime::getDateFormatRus($date).'.xml"');
        header('Cache-Control: max-age=0');

        echo $strView;
        exit();
    }


    /**
     * Реестр зарплаты водителей
     * @throws Exception
     */
    public function action_ballast_salary() {
        set_time_limit(36000);

        $this->_sitePageData->url = '/'.$this->actionURLName.'/shopreport/ballast_salary';

        $shopBranchID = Request_RequestParams::getParamInt('shop_branch_id');
        if($shopBranchID > 0){
            $branchIDs = array($shopBranchID);
        }else{
            $branchIDs = array();
        }

        // задаем время выборки
        $dateFrom = Request_RequestParams::getParamDateTime('created_at_from');
        $dateTo = Request_RequestParams::getParamDateTime('created_at_to');
        $shopBallastDriverID = Request_RequestParams::getParamInt('shop_ballast_driver_id');

        // праздничные дни
        $params = Request_RequestParams::setParams(
            array(
                'day_from_equally' => $dateFrom,
                'day_to' => $dateTo,
            )
        );
        $holidayIDs = Request_Request::findNotShop(
            'DB_Ab1_Holiday', $this->_sitePageData, $this->_driverDB,
            $params, 0, TRUE
        );
        $holidayIDs->runIndex(true, 'day');

        $params = Request_RequestParams::setParams(
            array(
                'date_from' => $dateFrom,
                'date_to' => $dateTo,
                'shop_ballast_driver_id' => $shopBallastDriverID,
                'sort_by' => array(
                    'shop_ballast_distance_id.distance' => 'asc',
                )
            )
        );
        $shopBallastIDs = Request_Request::findBranch('DB_Ab1_Shop_Ballast',
            $branchIDs, $this->_sitePageData, $this->_driverDB,
            $params, 0, TRUE,
            array(
                'shop_ballast_driver_id' => array('name'),
                'shop_ballast_distance_id' => array('name'),
            )
        );

        $shopTransportationIDs = Request_Request::findBranch('DB_Ab1_Shop_Transportation',
            $branchIDs, $this->_sitePageData, $this->_driverDB,
            $params, 0, TRUE,
            array(
                'shop_ballast_driver_id' => array('name'),
                'shop_ballast_distance_id' => array('name'),
            )
        );
        $shopBallastIDs->addChilds($shopTransportationIDs);

        // группируем по сменам
        $shopWorkShiftIDs = Request_Request::findBranch(
            'DB_Ab1_Shop_Work_Shift', $branchIDs, $this->_sitePageData, $this->_driverDB,
            Request_RequestParams::setParams()
        );
        $shopWorkShiftIDs->runIndex();

        $ids = new MyArray();
        foreach ($shopBallastIDs->childs as $child){
            $shift = $child->values['shop_work_shift_id'];

            $date = Helpers_DateTime::getDateFormatPHP($child->values['date']);
            if(key_exists($shift, $shopWorkShiftIDs->childs)
                && (strtotime($child->values['date']) < strtotime($date . ' ' . $shopWorkShiftIDs->childs[$shift]->values['time_from']))){
                $date = Helpers_DateTime::getDateFormatPHP(Helpers_DateTime::minusDays($date, 1));
            }

            $count = Arr::path($child->values, 'flight', 1);

            $key = $child->values['shop_ballast_driver_id']
                .'_'.$shift
                .'_'.$child->values['shop_ballast_distance_id']
                .'_'.$child->values['tariff']
                .'_'.$child->values['tariff_holiday']
                .'_'.$date;

            if(!key_exists($key, $ids->childs)){
                $ids->childs[$key] = $child;
                $ids->childs[$key]->values['count'] = $count;
                $ids->childs[$key]->values['min_date'] = $child->values['date'];
                $ids->childs[$key]->values['max_date'] = $child->values['date'];
                $ids->childs[$key]->values['date_day'] = $date;
                $ids->childs[$key]->values['date_days'] = array($date => $date);

                continue;
            }

            $ids->childs[$key]->values['date_days'][$date] = $date;
            $ids->childs[$key]->values['count'] += $count;
            if(strtotime($ids->childs[$key]->values['min_date']) > strtotime($child->values['date'])){
                $ids->childs[$key]->values['min_date'] = $child->values['date'];
            }elseif(strtotime($ids->childs[$key]->values['max_date']) < strtotime($child->values['date'])){
                $ids->childs[$key]->values['max_date'] = $child->values['date'];
            }
        }
        unset($shopBallastIDs);

        $dataBallasts = array(
            'data' => array(),
            'count' => 0, // кол-во рейсов
            'amount' => 0,
            'holiday' => array( // выходные дни
                'hour' => 0,
                'count' => 0,
                'amount' => 0,
            ),
            'repair' => array( // ремонт
                'day' => 0,
                'hour' => 0,
            ),
            'night_hour' => 0, // ночные часы
            'work_day' => 0, // отработанные дни
        );
        $dataDistances = array(
            'data' => array(),
            'count' => 0, // кол-во рейсов
            'amount' => 0,
            'list' => array(),
            'names' => array(),
            'index' => array(),
        );

        foreach ($ids->childs as $child){
            // группируем по водителю
            $driver = $child->values['shop_ballast_driver_id'];
            if (! key_exists($driver, $dataBallasts['data'])){
                $dataBallasts['data'][$driver] = array(
                    'name' => $child->getElementValue('shop_ballast_driver_id'),
                    'count' => 0, // кол-во рейсов
                    'amount' => 0, // зарплата
                    'data' => array(),
                    'holiday' => array( // выходные дни
                        'hour' => 0,
                        'count' => 0,
                        'amount' => 0,
                    ),
                    'repair' => array( // ремонт
                        'day' => 0,
                        'hour' => 0,
                    ),
                    'night_hour' => 0, // ночные часы
                    'work_day' => 0, // отработанные дни
                );
            }
            $dataBallasts['data'][$driver]['work_day'] += count($child->values['date_days']);
            $dataBallasts['work_day'] += count($child->values['date_days']);

            $distance = $child->values['shop_ballast_distance_id'];
            $tariff = str_replace('.', '-', $child->values['tariff']);

            // получаем индекс дистанции
            if(!key_exists($distance, $dataDistances['index'])){
                $dataDistances['index'][$distance][$tariff] = 0;
            }
            if(!key_exists($tariff, $dataDistances['index'][$distance])){
                $dataDistances['index'][$distance][$tariff] = count($dataDistances['index'][$distance]);
            }
            $distanceIndex = $dataDistances['index'][$distance][$tariff];

            // группируем по дистанциям и тарифам
            if (! key_exists($distanceIndex, $dataBallasts['data'][$driver]['data'])){
                $dataBallasts['data'][$driver]['data'][$distanceIndex] = array(
                    'count' => 0,
                    'amount' => 0,
                    'data' => [],
                );
            }

            // группируем по дистанциям
            if (! key_exists($distance, $dataBallasts['data'][$driver]['data'][$distanceIndex]['data'])){
                $dataBallasts['data'][$driver]['data'][$distanceIndex]['data'][$distance] = array(
                    'tariff' => $child->values['tariff'],
                    'count' => 0,
                    'amount' => 0,
                );
            }

            $count = $child->values['count'];
            $amount = $count * $child->values['tariff'];

            $dataBallasts['data'][$driver]['data'][$distanceIndex]['data'][$distance]['count'] += $count;
            $dataBallasts['data'][$driver]['data'][$distanceIndex]['data'][$distance]['amount'] += $amount;

            $dataBallasts['data'][$driver]['data'][$distanceIndex]['count'] += $count;
            $dataBallasts['data'][$driver]['data'][$distanceIndex]['amount'] += $amount;

            $dataBallasts['data'][$driver]['count'] += $count;
            $dataBallasts['data'][$driver]['amount'] += $amount;

            $dataBallasts['count'] += $count;
            $dataBallasts['amount'] += $amount;

            // группируем по дистанциям
            if (! key_exists($distance, $dataDistances['list'])){
                $distanceName = $child->getElementValue('shop_ballast_distance_id');
                $dataDistances['list'][$distance][$distanceName] = $distanceName;
                $dataDistances['names'][$distance][$distanceName] = $distanceName;
                if (key_exists($tariff, $dataDistances['data'])) {
                    $dataDistances['data'][$tariff]['name'] = implode(', ', $dataDistances['names'][$distance]);
                }
            }

            if (! key_exists($distance, $dataDistances['data'])){
                $dataDistances['data'][$distance] = array(
                    'id' => $distance,
                    'name' => implode(', ', $dataDistances['list'][$distance]),
                    'count' => 0, // кол-во рейсов
                    'amount' => 0,
                );
            }

            $dataDistances['data'][$distance]['count'] += $count;
            $dataDistances['data'][$distance]['amount'] += $amount;

            $dataDistances['count'] += $count;
            $dataDistances['amount'] += $amount;

            // праздничный день
            if(key_exists($child->values['date_day'], $holidayIDs->childs)){
                $amount = $count * $child->values['tariff_holiday'];
                $hours = abs(Helpers_DateTime::diffHours($child->values['min_date'], $child->values['max_date']));
                $hours = 8;

                $dataBallasts['data'][$driver]['holiday']['hour'] += $hours;
                $dataBallasts['data'][$driver]['holiday']['count'] += $count;
                $dataBallasts['data'][$driver]['holiday']['amount'] += $amount;

                $dataBallasts['holiday']['hour'] += $hours;
                $dataBallasts['holiday']['count'] += $count;
                $dataBallasts['holiday']['amount'] += $amount;

            }

            // ночные часы
            $shift = $child->values['shop_work_shift_id'];
            if(key_exists($shift, $shopWorkShiftIDs->childs)){
                $hours = $shopWorkShiftIDs->childs[$shift]->values['night_hours'];
                $dataBallasts['data'][$driver]['night_hour'] += $hours;
                $dataBallasts['night_hour'] += $hours;
            }
        }

        // получаем связть водителей баласта и водителей АТЦ
        $shopBallastDriverIDs = Request_Request::find(
            DB_Ab1_Shop_Ballast_Driver::NAME,
            $this->_sitePageData->shopMainID, $this->_sitePageData, $this->_driverDB,
            Request_RequestParams::setParams(), 0, TRUE
        );
        $shopBallastDriverIDs->runIndex(true, 'shop_worker_id');

        $shopTransportDriverIDs = Request_Request::find(
            DB_Ab1_Shop_Transport_Driver::NAME,
            0, $this->_sitePageData, $this->_driverDB,
            Request_RequestParams::setParams(), 0, TRUE
        );
        $shopTransportDriverIDs->runIndex(true, 'shop_worker_id');

        $listDrivers = [];
        foreach ($shopTransportDriverIDs->childs as $child){
            $worker = $child->values['shop_worker_id'];
            if(key_exists($worker, $shopBallastDriverIDs->childs)){
                $listDrivers[$worker] = $shopBallastDriverIDs->childs[$worker];
            }else{
                $listDrivers[$worker] = $child;
            }
        }

        $shopTransportDriverID = null;
        if($shopBallastDriverID > 0){
            $model = new Model_Ab1_Shop_Ballast_Driver();
            if(Helpers_DB::getDBObject($model, $shopBallastDriverID, $this->_sitePageData, 0)
                && key_exists($model->getShopWorkerID(), $listDrivers)){
                $shopTransportDriverID = $listDrivers[$model->getShopWorkerID()]->id;
            }
        }

        $params = Request_RequestParams::setParams(
            array(
                'shop_transport_waybill_id.date_from_equally' => Helpers_DateTime::getDateFormatPHP($dateFrom),
                'shop_transport_waybill_id.date_to' => Helpers_DateTime::getDateFormatPHP($dateTo),
                'shop_transport_waybill_id.shop_transport_driver_id' => $shopTransportDriverID,
                'shop_branch_from_id' => $this->_sitePageData->shopID,
                'shop_branch_to_id' => $this->_sitePageData->shopID,
                'shop_transport_route_id_from' => 0,
                'shop_car_to_material_id_from' => 0,
            )
        );
        $ids = Request_Request::findBranch(
            DB_Ab1_Shop_Transport_Waybill_Car::NAME,
            $branchIDs, $this->_sitePageData, $this->_driverDB,
            $params, 0, TRUE,
            array(
                'shop_transport_driver_id' => array('shop_worker_id'),
                'shop_transport_route_id' => array('name'),
                'shop_transport_waybill_id' => array('date'),
            )
        );

        foreach ($ids->childs as $child){
            $worker = $child->getElementValue('shop_transport_driver_id', 'shop_worker_id');
            if(!key_exists($worker, $listDrivers)){
                echo $worker;die;
                continue;
            }

            /** @var MyArray $driver */
            $driver = $listDrivers[$worker];

            // группируем по водителю
            $driverID = $driver->id;
            if (! key_exists($driverID, $dataBallasts['data'])){
                $dataBallasts['data'][$driverID] = array(
                    'name' => $driver->values['name'],
                    'count' => 0, // кол-во рейсов
                    'amount' => 0, // зарплата
                    'data' => array(),
                    'holiday' => array( // выходные дни
                        'hour' => 0,
                        'count' => 0,
                        'amount' => 0,
                    ),
                    'repair' => array( // ремонт
                        'day' => 0,
                        'hour' => 0,
                    ),
                    'night_hour' => 0, // ночные часы
                    'work_day' => 1, // отработанные дни
                );
                $dataBallasts['work_day'] ++;
            }

            $distance = $child->values['shop_transport_route_id'];
            $tariff = str_replace('.', '-', $child->values['wage']);

            // получаем индекс дистанции
            if(!key_exists($distance, $dataDistances['index'])){
                $dataDistances['index'][$distance][$tariff] = 0;
            }
            if(!key_exists($tariff, $dataDistances['index'][$distance])){
                $dataDistances['index'][$distance][$tariff] = count($dataDistances['index'][$distance]);
            }
            $distanceIndex = $dataDistances['index'][$distance][$tariff];

            // группируем по дистанциям и тарифу
            if (! key_exists($distanceIndex, $dataBallasts['data'][$driverID]['data'])){
                $dataBallasts['data'][$driverID]['data'][$distanceIndex] = array(
                    'count' => 0,
                    'amount' => 0,
                    'data' => [],
                );
            }

            // группируем по дистанциям
            if (! key_exists($distance, $dataBallasts['data'][$driverID]['data'][$distanceIndex]['data'])){
                $dataBallasts['data'][$driverID]['data'][$distanceIndex]['data'][$distance] = array(
                    'tariff' => $child->values['wage'],
                    'count' => 0,
                    'amount' => 0,
                );
            }

            $count = $child->values['count_trip'];
            $amount = $count * $child->values['wage'];

            $dataBallasts['data'][$driverID]['data'][$distanceIndex]['data'][$distance]['count'] += $count;
            $dataBallasts['data'][$driverID]['data'][$distanceIndex]['data'][$distance]['amount'] += $amount;

            $dataBallasts['data'][$driverID]['data'][$distanceIndex]['count'] += $count;
            $dataBallasts['data'][$driverID]['data'][$distanceIndex]['amount'] += $amount;

            $dataBallasts['data'][$driverID]['count'] += $count;
            $dataBallasts['data'][$driverID]['amount'] += $amount;

            $dataBallasts['count'] += $count;
            $dataBallasts['amount'] += $amount;

            // группируем по дистанциям
            if (! key_exists($distance, $dataDistances['list'])){
                $distanceName = $child->getElementValue('shop_transport_route_id');
                $dataDistances['list'][$distance][$distanceName] = $distanceName;
                $dataDistances['names'][$distance][$distanceName] = $distanceName;
                if (key_exists($tariff, $dataDistances['data'])) {
                    $dataDistances['data'][$tariff]['name'] = implode(', ', $dataDistances['names'][$distance]);
                }
            }

            if (! key_exists($distance, $dataDistances['data'])){
                $dataDistances['data'][$distance] = array(
                    'id' => $distance,
                    'name' => implode(', ', $dataDistances['list'][$distance]),
                    'count' => 0, // кол-во рейсов
                    'amount' => 0,
                );
            }

            $dataDistances['data'][$distance]['count'] += $count;
            $dataDistances['data'][$distance]['amount'] += $amount;

            $dataDistances['count'] += $count;
            $dataDistances['amount'] += $amount;

            $date = $child->getElementValue('shop_transport_waybill_id', 'date');

            // праздничный день
            if(key_exists($date, $holidayIDs->childs)){
                $amount = $count * round($child->values['wage'] / 2, 2);

                $dataBallasts['data'][$driverID]['holiday']['count'] += $count;
                $dataBallasts['data'][$driverID]['holiday']['amount'] += $amount;

                $dataBallasts['holiday']['count'] += $count;
                $dataBallasts['holiday']['amount'] += $amount;
            }
        }

        uasort($dataBallasts['data'], array($this, 'mySortMethod'));
        uasort($dataDistances['data'], array($this, 'mySortMethod'));
        /*echo '<pre>';
        print_r($dataDistances);
        print_r($dataBallasts);die;*/

        $viewObject = 'ab1/_report/'.$this->_sitePageData->languageID.'/ballast/salary';
        $tmp = str_replace('\\', '/', $viewObject);
        try {
            $view = View::factory($tmp);
        }catch (Exception $e) {
            throw new Exception('Шаблон "'.$tmp.'" не найден.');
        }

        $view->ballasts = $dataBallasts;
        $view->distances = $dataDistances;
        $view->dateFrom = $dateFrom;
        $view->dateTo = $dateTo;

        $view->branch = '';
        if($shopBranchID > 0){
            $view->branch = $this->_sitePageData->shop->getName();
        }
        $view->operation = $this->_sitePageData->operation->getValues();
        $view->shop = $this->_sitePageData->shop->getName();
        $view->shopOptions = $this->_sitePageData->shop->getOptionsArray();
        $strView = Helpers_View::viewToStr($view);

        header('Content-Type: application/x-download;charset=UTF-8');
        // header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: filename="БТ03 Реестр начисления заработной платы водителям карьера.xml"');
        header('Cache-Control: max-age=0');

        echo $strView;
        exit();
    }

    /**
     * БТ01 Сводка балласта за смену
     * @throws Exception
     */
    public function action_ballast_day() {
        set_time_limit(36000);

        $this->_sitePageData->url = '/'.$this->actionURLName.'/shopreport/ballast_day';

        $shopMaterialIDs = NULL;

        // задаем время выборки
        $date = Request_RequestParams::getParamDateTime('date');
        if($date === NULL){
            $date = date('Y-m-d');
        }else{
            $date = Helpers_DateTime::getDateFormatPHP($date);
        }

        $shopWorkShiftID = Request_RequestParams::getParamInt('shop_work_shift_id');

        $model = new Model_Ab1_Shop_Work_Shift();
        $model->setDBDriver($this->_driverDB);
        if(! Helpers_DB::getDBObject($model, $shopWorkShiftID, $this->_sitePageData)){
            throw new HTTP_Exception_500('Work shift not found.');
        }
        $workShift = $model->getName();

        $dateFrom = $date . ' 06:00:00';
        $dateTo = date('d.m.Y',strtotime($date.' +1 day')) . ' 06:00:00';

        $params = Request_RequestParams::setParams(
            array(
                'date_from' => $dateFrom,
                'date_to' => $dateTo,
                'count_id' => TRUE,
                'sum_quantity' => TRUE,
                'min_date' => TRUE,
                'max_date' => TRUE,
                'shop_work_shift_id' => $shopWorkShiftID,
                'shop_ballast_crusher_id.is_balance' => true,
                'group_by' => array(
                    'shop_ballast_crusher_id', 'shop_ballast_crusher_id.name',
                    'shop_ballast_driver_id', 'shop_ballast_driver_id.name',
                    'shop_ballast_distance_id', 'shop_ballast_distance_id.name',
                    'take_shop_ballast_crusher_id', 'is_storage', 'name', 'date_day',
                ),
            )
        );
        $ids = Request_Request::find('DB_Ab1_Shop_Ballast',
            $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB,
            $params, 0, TRUE,
            array(
                'shop_ballast_driver_id' => array('name'),
                'shop_ballast_crusher_id' => array('name'),
                'shop_ballast_distance_id' => array('name'),
            )
        );

        $dataCrushers = array(
            'data' => array(),
            'quantity' => 0,
            'count' => 0,
        );

        $dataDistances = array(
            'data' => array(),
            'quantity' => 0,
            'count' => 0,
        );

        $dataStorages = array(
            'data' => array(),
            'quantity' => 0,
            'count' => 0,
        );

        $dataOutStorages = array(
            'data' => array(),
            'quantity' => 0,
            'count' => 0,
        );

        $dataBallasts = array(
            'data' => array(),
            'quantity' => 0,
            'count' => 0,
        );
        foreach ($ids->childs as $child){
            $quantity = $child->values['quantity'];
            $count = $child->values['count'];

            $dateMin = $child->values['min_date'];
            $dateMinD = strtotime($dateMin);

            $dateMax = $child->values['max_date'];
            $dateMaxD = strtotime($dateMax);

            // группируем по водителю и машине
            $key = $child->values['name'].'_'.$child->values['shop_ballast_driver_id'];
            if (!key_exists($key, $dataBallasts['data'])) {
                $dataBallasts['data'][$key] = array(
                    'name' => $child->values['name'],
                    'shop_ballast_driver_name' => $child->getElementValue('shop_ballast_driver_id'),
                    'quantity' => 0,
                    'count' => 0,
                    'date_from' => $dateMin,
                    'date_from_d' => $dateMinD,
                    'date_to' => $dateMax,
                    'date_to_d' => $dateMaxD,
                    'distances' => array(),
                );
            }

            if ($dataBallasts['data'][$key]['date_from_d'] > $dateMinD) {
                $dataBallasts['data'][$key]['date_from'] = $dateMin;
                $dataBallasts['data'][$key]['date_from_d'] = $dateMinD;
            }
            if ($dataBallasts['data'][$key]['date_to_d'] < $dateMaxD) {
                $dataBallasts['data'][$key]['date_to'] = $dateMax;
                $dataBallasts['data'][$key]['date_to_d'] = $dateMaxD;
            }
            $dataBallasts['data'][$key]['quantity'] += $quantity;
            $dataBallasts['data'][$key]['count'] += $count;

            $dataBallasts['quantity'] += $quantity;
            $dataBallasts['count'] += $count;

            if($child->values['is_storage']){
                // группируем по дробилкам
                $crusher = $child->values['shop_ballast_crusher_id'];
                if (! key_exists($crusher, $dataStorages['data'])){
                    $dataStorages['data'][$crusher] = array(
                        'name' => $child->getElementValue('shop_ballast_crusher_id'),
                        'quantity' => 0,
                        'count' => 0,
                        'date_from' => $dateMin,
                        'date_from_d' => $dateMinD,
                        'date_to' => $dateMax,
                        'date_to_d' => $dateMaxD,
                    );
                }

                if($dataStorages['data'][$crusher]['date_from_d'] > $dateMinD){
                    $dataStorages['data'][$crusher]['date_from'] = $dateMin;
                    $dataStorages['data'][$crusher]['date_from_d'] = $dateMinD;
                }
                if($dataStorages['data'][$crusher]['date_to_d'] < $dateMaxD){
                    $dataStorages['data'][$crusher]['date_to'] = $dateMax;
                    $dataStorages['data'][$crusher]['date_to_d'] = $dateMaxD;
                }

                $dataStorages['data'][$crusher]['quantity'] += $quantity;
                $dataStorages['data'][$crusher]['count'] +=$count;

                $dataStorages['quantity'] += $quantity;
                $dataStorages['count'] += $count;
            }else {
                // группируем по дробилкам
                $crusher = $child->values['shop_ballast_crusher_id'];
                if (! key_exists($crusher, $dataCrushers['data'])){
                    $dataCrushers['data'][$crusher] = array(
                        'name' => $child->getElementValue('shop_ballast_crusher_id'),
                        'quantity' => 0,
                        'count' => 0,
                        'date_from' => $dateMin,
                        'date_from_d' => $dateMinD,
                        'date_to' => $dateMax,
                        'date_to_d' => $dateMaxD,
                    );
                }

                if($dataCrushers['data'][$crusher]['date_from_d'] > $dateMinD){
                    $dataCrushers['data'][$crusher]['date_from'] = $dateMin;
                    $dataCrushers['data'][$crusher]['date_from_d'] = $dateMinD;
                }
                if($dataCrushers['data'][$crusher]['date_to_d'] < $dateMaxD){
                    $dataCrushers['data'][$crusher]['date_to'] = $dateMax;
                    $dataCrushers['data'][$crusher]['date_to_d'] = $dateMaxD;
                }

                $dataCrushers['data'][$crusher]['quantity'] += $quantity;
                $dataCrushers['data'][$crusher]['count'] +=$count;

                $dataCrushers['quantity'] += $quantity;
                $dataCrushers['count'] += $count;
            }

            if($child->values['take_shop_ballast_crusher_id'] > 0){
                // группируем по дробилкам
                $crusher = $child->values['shop_ballast_crusher_id'];
                if (! key_exists($crusher, $dataOutStorages['data'])){
                    $dataOutStorages['data'][$crusher] = array(
                        'name' => $child->getElementValue('shop_ballast_crusher_id'),
                        'quantity' => 0,
                        'count' => 0,
                        'date_from' => $dateMin,
                        'date_from_d' => $dateMinD,
                        'date_to' => $dateMax,
                        'date_to_d' => $dateMaxD,
                    );
                }

                if($dataOutStorages['data'][$crusher]['date_from_d'] > $dateMinD){
                    $dataOutStorages['data'][$crusher]['date_from'] = $dateMin;
                    $dataOutStorages['data'][$crusher]['date_from_d'] = $dateMinD;
                }
                if($dataOutStorages['data'][$crusher]['date_to_d'] < $dateMaxD){
                    $dataOutStorages['data'][$crusher]['date_to'] = $dateMax;
                    $dataOutStorages['data'][$crusher]['date_to_d'] = $dateMaxD;
                }

                $dataOutStorages['data'][$crusher]['quantity'] += $quantity;
                $dataOutStorages['data'][$crusher]['count'] +=$count;

                $dataOutStorages['quantity'] += $quantity;
                $dataOutStorages['count'] += $count;
            }

            // группируем по дистанциям
            $distance = $child->values['shop_ballast_distance_id'];
            if (! key_exists($distance,  $dataBallasts['data'][$key]['distances'])){
                $dataBallasts['data'][$key]['distances'][$distance] = array(
                    'name' => $child->getElementValue('shop_ballast_distance_id'),
                    'count' => 0,
                    'quantity' => 0,
                );
            }

            $dataBallasts['data'][$key]['distances'][$distance]['quantity'] += $quantity;
            $dataBallasts['data'][$key]['distances'][$distance]['count'] +=$count;

            if (! key_exists($distance,  $dataDistances['data'])){
                $dataDistances['data'][$distance] = array(
                    'id' => $distance,
                    'name' => $child->getElementValue('shop_ballast_distance_id'),
                    'count' => 0,
                    'quantity' => 0,
                );
            }

            $dataDistances['data'][$distance]['quantity'] += $quantity;
            $dataDistances['data'][$distance]['count'] += $count;

            $dataDistances['quantity'] += $quantity;
            $dataDistances['count'] += $count;
        }

        uasort($dataBallasts['data'], array($this, 'mySortMethod'));
        uasort($dataStorages['data'], array($this, 'mySortMethod'));
        uasort($dataOutStorages['data'], array($this, 'mySortMethod'));
        uasort($dataCrushers['data'], array($this, 'mySortMethod'));
        uasort($dataDistances['data'], array($this, 'mySortMethod'));

        /****** Вычисляем остатки на складе ******/
        $dataStorageTotals = array(
            'data' => array(),
            'from' => 0,
            'in' => 0,
            'out' => 0,
            'to' => 0,
        );

        // завоз на склад на начало смены
        $params = Request_RequestParams::setParams(
            array(
                'date_to' => $dateFrom,
                'sum_quantity' => TRUE,
                'shop_ballast_crusher_id.is_storage' => true,
                'group_by' => array(
                    'shop_ballast_crusher_id', 'shop_ballast_crusher_id.name',
                ),
            )
        );
        $ids = Request_Request::find('DB_Ab1_Shop_Ballast',
            $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB,
            $params, 0, TRUE,
            array(
                'shop_ballast_crusher_id' => array('name'),
            )
        );

        foreach ($ids->childs as $child) {
            $quantity = $child->values['quantity'];

            // группируем по складам
            $crusher = $child->values['shop_ballast_crusher_id'];
            if (!key_exists($crusher, $dataStorageTotals['data'])) {
                $dataStorageTotals['data'][$crusher] = array(
                    'name' => $child->getElementValue('shop_ballast_crusher_id'),
                    'from' => 0,
                    'in' => 0,
                    'out' => 0,
                    'to' => 0,
                );
            }

            $dataStorageTotals['data'][$crusher]['from'] += $quantity;
            $dataStorageTotals['from'] += $quantity;
        }

        // вывоз со склада на начало смены
        $params = Request_RequestParams::setParams(
            array(
                'date_to' => $dateFrom,
                'sum_quantity' => TRUE,
                'take_shop_ballast_crusher_id_from' => 0,
                'group_by' => array(
                    'take_shop_ballast_crusher_id', 'take_shop_ballast_crusher_id.name',
                ),
            )
        );
        $ids = Request_Request::find('DB_Ab1_Shop_Ballast',
            $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB,
            $params, 0, TRUE,
            array(
                'take_shop_ballast_crusher_id' => array('name'),
            )
        );

        foreach ($ids->childs as $child) {
            $quantity = $child->values['quantity'];

            // группируем по складам
            $crusher = $child->values['take_shop_ballast_crusher_id'];
            if (!key_exists($crusher, $dataStorageTotals['data'])) {
                $dataStorageTotals['data'][$crusher] = array(
                    'name' => $child->getElementValue('take_shop_ballast_crusher_id'),
                    'from' => 0,
                    'in' => 0,
                    'out' => 0,
                    'to' => 0,
                );
            }

            $dataStorageTotals['data'][$crusher]['from'] -= $quantity;
            $dataStorageTotals['from'] -= $quantity;
        }

        // завоз на склад за смену
        $params = Request_RequestParams::setParams(
            array(
                'date_from' => $dateFrom,
                'date_to' => $dateTo,
                'sum_quantity' => TRUE,
                'shop_ballast_crusher_id.is_storage' => true,
                'group_by' => array(
                    'shop_ballast_crusher_id', 'shop_ballast_crusher_id.name',
                ),
            )
        );
        $ids = Request_Request::find('DB_Ab1_Shop_Ballast',
            $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB,
            $params, 0, TRUE,
            array(
                'shop_ballast_crusher_id' => array('name'),
            )
        );

        foreach ($ids->childs as $child) {
            $quantity = $child->values['quantity'];

            // группируем по складам
            $crusher = $child->values['shop_ballast_crusher_id'];
            if (!key_exists($crusher, $dataStorageTotals['data'])) {
                $dataStorageTotals['data'][$crusher] = array(
                    'name' => $child->getElementValue('shop_ballast_crusher_id'),
                    'from' => 0,
                    'in' => 0,
                    'out' => 0,
                    'to' => 0,
                );
            }

            $dataStorageTotals['data'][$crusher]['in'] += $quantity;
            $dataStorageTotals['in'] += $quantity;
        }

        // вывоз со склада за смену
        $params = Request_RequestParams::setParams(
            array(
                'date_from' => $dateFrom,
                'date_to' => $dateTo,
                'sum_quantity' => TRUE,
                'take_shop_ballast_crusher_id_from' => 0,
                'group_by' => array(
                    'take_shop_ballast_crusher_id', 'take_shop_ballast_crusher_id.name',
                ),
            )
        );
        $ids = Request_Request::find('DB_Ab1_Shop_Ballast',
            $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB,
            $params, 0, TRUE,
            array(
                'take_shop_ballast_crusher_id' => array('name'),
            )
        );

        foreach ($ids->childs as $child) {
            $quantity = $child->values['quantity'];

            // группируем по складам
            $crusher = $child->values['take_shop_ballast_crusher_id'];
            if (!key_exists($crusher, $dataStorageTotals['data'])) {
                $dataStorageTotals['data'][$crusher] = array(
                    'name' => $child->getElementValue('take_shop_ballast_crusher_id'),
                    'from' => 0,
                    'in' => 0,
                    'out' => 0,
                    'to' => 0,
                );
            }

            $dataStorageTotals['data'][$crusher]['out'] += $quantity;
            $dataStorageTotals['out'] += $quantity;
        }

        // завоз на склад на конец смены
        $params = Request_RequestParams::setParams(
            array(
                'date_to' => $dateTo,
                'sum_quantity' => TRUE,
                'shop_ballast_crusher_id.is_storage' => true,
                'group_by' => array(
                    'shop_ballast_crusher_id', 'shop_ballast_crusher_id.name',
                ),
            )
        );
        $ids = Request_Request::find('DB_Ab1_Shop_Ballast',
            $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB,
            $params, 0, TRUE,
            array(
                'shop_ballast_crusher_id' => array('name'),
            )
        );

        foreach ($ids->childs as $child) {
            $quantity = $child->values['quantity'];

            // группируем по складам
            $crusher = $child->values['shop_ballast_crusher_id'];
            if (!key_exists($crusher, $dataStorageTotals['data'])) {
                $dataStorageTotals['data'][$crusher] = array(
                    'name' => $child->getElementValue('shop_ballast_crusher_id'),
                    'from' => 0,
                    'in' => 0,
                    'out' => 0,
                    'to' => 0,
                );
            }

            $dataStorageTotals['data'][$crusher]['to'] += $quantity;
            $dataStorageTotals['to'] += $quantity;
        }

        // вывоз со склада на конец смены
        $params = Request_RequestParams::setParams(
            array(
                'date_to' => $dateTo,
                'sum_quantity' => TRUE,
                'take_shop_ballast_crusher_id_from' => 0,
                'group_by' => array(
                    'take_shop_ballast_crusher_id', 'take_shop_ballast_crusher_id.name',
                ),
            )
        );
        $ids = Request_Request::find('DB_Ab1_Shop_Ballast',
            $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB,
            $params, 0, TRUE,
            array(
                'take_shop_ballast_crusher_id' => array('name'),
            )
        );

        foreach ($ids->childs as $child) {
            $quantity = $child->values['quantity'];

            // группируем по складам
            $crusher = $child->values['take_shop_ballast_crusher_id'];
            if (!key_exists($crusher, $dataStorageTotals['data'])) {
                $dataStorageTotals['data'][$crusher] = array(
                    'name' => $child->getElementValue('take_shop_ballast_crusher_id'),
                    'from' => 0,
                    'in' => 0,
                    'out' => 0,
                    'to' => 0,
                );
            }

            $dataStorageTotals['data'][$crusher]['to'] -= $quantity;
            $dataStorageTotals['to'] -= $quantity;
        }

        $viewObject = 'ab1/_report/'.$this->_sitePageData->languageID.'/ballast/day';
        $tmp = str_replace('\\', '/', $viewObject);
        try {
            $view = View::factory($tmp);
        }catch (Exception $e) {
            throw new Exception('Шаблон "'.$tmp.'" не найден.');
        }

        $view->ballasts = $dataBallasts;
        $view->distances = $dataDistances;
        $view->storageTotals = $dataStorageTotals;
        $view->storages = $dataStorages;
        $view->outStorages = $dataOutStorages;
        $view->crushers = $dataCrushers;
        $view->date = $date;
        $view->workShift = $workShift;
        $view->operation = $this->_sitePageData->operation->getValues();
        $view->shop = $this->_sitePageData->shop->getName();
        $view->shopOptions = $this->_sitePageData->shop->getOptionsArray();
        $strView = Helpers_View::viewToStr($view);

        header('Content-Type: application/x-download;charset=UTF-8');
        // header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: filename="БТ01 Сводка балласта за '.Helpers_DateTime::getDateFormatRus($date).'.xml"');
        header('Cache-Control: max-age=0');

        echo $strView;
        exit();
    }

    /**
     * Количество перевезенного балласта за указанное время сгруппированные по водителям, машинам и дням
     * @throws Exception
     */
    public function action_ballast_day_drivers() {
        set_time_limit(36000);

        $this->_sitePageData->url = '/'.$this->actionURLName.'/shopreport/ballast_day_drivers';

        $shopMaterialIDs = NULL;

        // задаем время выборки
        $carNumber = Request_RequestParams::getParamStr('name');
        $dateFrom = Request_RequestParams::getParamDateTime('created_at_from');
        $dateTo = Request_RequestParams::getParamDateTime('created_at_to');
        $shopBallastDriverID = Request_RequestParams::getParamInt('shop_ballast_driver_id');
        $shopBallastCarID = Request_RequestParams::getParamInt('shop_ballast_car_id');

        $dataBallasts = array(
            'data' => array(),
            'quantity' => 0,
            'count' => 0,
        );

        /****** Перевозка балласта ******/
        $params = Request_RequestParams::setParams(
            array(
                'name' => $carNumber,
                'date_from' => $dateFrom,
                'date_to' => $dateTo,
                'shop_ballast_driver_id' => $shopBallastDriverID,
                'shop_ballast_car_id' => $shopBallastCarID,
                'count_id' => TRUE,
                'sum_quantity' => TRUE,
                'group_by' => array(
                    'shop_ballast_driver_id', 'shop_ballast_driver_id.name',
                    'shop_ballast_distance_id', 'shop_ballast_distance_id.name',
                    'shop_ballast_crusher_id', 'shop_ballast_crusher_id.name',
                    'name', 'date_day'
                ),
            )
        );
        $ids = Request_Request::find('DB_Ab1_Shop_Ballast',
            $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB,
            $params, 0, TRUE,
            array(
                'shop_ballast_driver_id' => array('name'),
                'shop_ballast_distance_id' => array('name'),
                'shop_ballast_crusher_id' => array('name'),
            )
        );

        foreach ($ids->childs as $child){
            $quantity = $child->values['quantity'];
            $count = $child->values['count'];

            // группируем по водителю и машине
            $key = $child->values['name'].'_'.$child->values['shop_ballast_driver_id'];
            if (! key_exists($key, $dataBallasts['data'])){
                $dataBallasts['data'][$key] = array(
                    'data' => array(),
                    'crushers' => array(),
                    'distances' => array(),
                    'name' => $child->values['name'],
                    'shop_ballast_driver_name' => $child->getElementValue('shop_ballast_driver_id'),
                    'quantity' => 0,
                    'count' => 0,
                );
            }

            // группируем по дням
            $date = $child->values['date_day'];
            if (! key_exists($date, $dataBallasts['data'][$key]['data'])){
                $dataBallasts['data'][$key]['data'][$date] = array(
                    'crushers' => array(),
                    'distances' => array(),
                    'name' => $date,
                    'quantity' => 0,
                    'count' => 0,
                );
            }

            $dataBallasts['data'][$key]['data'][$date]['quantity'] += $quantity;
            $dataBallasts['data'][$key]['data'][$date]['count'] += $count;

            $dataBallasts['data'][$key]['quantity'] += $quantity;
            $dataBallasts['data'][$key]['count'] += $count;

            $dataBallasts['quantity'] += $quantity;
            $dataBallasts['count'] += $count;

            // группируем по дистанциям
            $distance = $child->values['shop_ballast_distance_id'];
            if (! key_exists($distance, $dataBallasts['data'][$key]['distances'])){
                $dataBallasts['data'][$key]['distances'][$distance] = array(
                    'id' => $distance,
                    'name' => $child->getElementValue('shop_ballast_distance_id'),
                    'quantity' => 0,
                    'count' => 0,
                );
            }
            if (! key_exists($distance, $dataBallasts['data'][$key]['data'][$date]['distances'])){
                $dataBallasts['data'][$key]['data'][$date]['distances'][$distance] = 0;
            }

            $dataBallasts['data'][$key]['data'][$date]['distances'][$distance] += $count;

            $dataBallasts['data'][$key]['distances'][$distance]['quantity'] += $quantity;
            $dataBallasts['data'][$key]['distances'][$distance]['count'] += $count;

            // группируем по дробилкам
            $crusher = $child->values['shop_ballast_crusher_id'];
            if (! key_exists($crusher, $dataBallasts['data'][$key]['crushers'])){
                $dataBallasts['data'][$key]['crushers'][$crusher] = array(
                    'id' => $crusher,
                    'name' => $child->getElementValue('shop_ballast_crusher_id'),
                    'quantity' => 0,
                    'count' => 0,
                );
            }
            if (! key_exists($distance, $dataBallasts['data'][$key]['data'][$date]['crushers'])){
                $dataBallasts['data'][$key]['data'][$date]['crushers'][$crusher] = 0;
            }

            $dataBallasts['data'][$key]['data'][$date]['crushers'][$crusher] += $count;

            $dataBallasts['data'][$key]['crushers'][$crusher]['quantity'] += $quantity;
            $dataBallasts['data'][$key]['crushers'][$crusher]['count'] += $count;
        }

        /****** Перевозки ******/
        $params = Request_RequestParams::setParams(
            array(
                'name' => $carNumber,
                'date_from' => $dateFrom,
                'date_to' => $dateTo,
                'shop_ballast_driver_id' => $shopBallastDriverID,
                'shop_ballast_car_id' => $shopBallastCarID,
                'count_id' => TRUE,
                'group_by' => array(
                    'shop_ballast_driver_id', 'shop_ballast_driver_id.name',
                    'shop_ballast_distance_id', 'shop_ballast_distance_id.name',
                    'shop_transportation_place_id', 'shop_transportation_place_id.name',
                    'name', 'date_day'
                ),
            )
        );
        $ids = Request_Request::find('DB_Ab1_Shop_Transportation',
            $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB,
            $params, 0, TRUE,
            array(
                'shop_ballast_driver_id' => array('name'),
                'shop_ballast_distance_id' => array('name'),
                'shop_transportation_place_id' => array('name'),
            )
        );

        foreach ($ids->childs as $child){
            $count = $child->values['count'];

            // группируем по водителю и машине
            $key = $child->values['name'].'_'.$child->values['shop_ballast_driver_id'];
            if (! key_exists($key, $dataBallasts['data'])){
                $dataBallasts['data'][$key] = array(
                    'data' => array(),
                    'crushers' => array(),
                    'distances' => array(),
                    'name' => $child->values['name'],
                    'shop_ballast_driver_name' => $child->getElementValue('shop_ballast_driver_id'),
                    'quantity' => 0,
                    'count' => 0,
                );
            }

            // группируем по дням
            $date = $child->values['date_day'];
            if (! key_exists($date, $dataBallasts['data'][$key]['data'])){
                $dataBallasts['data'][$key]['data'][$date] = array(
                    'crushers' => array(),
                    'distances' => array(),
                    'name' => $date,
                    'quantity' => 0,
                    'count' => 0,
                );
            }

            // группируем по дистанциям
            $distance = $child->values['shop_ballast_distance_id'];
            if (! key_exists($distance, $dataBallasts['data'][$key]['distances'])){
                $dataBallasts['data'][$key]['distances'][$distance] = array(
                    'id' => $distance,
                    'name' => $child->getElementValue('shop_ballast_distance_id'),
                    'quantity' => 0,
                    'count' => 0,
                );
            }
            if (! key_exists($distance, $dataBallasts['data'][$key]['data'][$date]['distances'])){
                $dataBallasts['data'][$key]['data'][$date]['distances'][$distance] = 0;
            }

            $dataBallasts['data'][$key]['data'][$date]['distances'][$distance] += $count;

            $dataBallasts['data'][$key]['distances'][$distance]['quantity'] += $quantity;
            $dataBallasts['data'][$key]['distances'][$distance]['count'] += $count;

            // группируем по дробилкам
            $crusher = $child->values['shop_transportation_place_id'];
            if (! key_exists($crusher, $dataBallasts['data'][$key]['crushers'])){
                $dataBallasts['data'][$key]['crushers'][$crusher] = array(
                    'id' => $crusher,
                    'name' => $child->getElementValue('shop_transportation_place_id'),
                    'quantity' => 0,
                    'count' => 0,
                );
            }
            if (! key_exists($distance, $dataBallasts['data'][$key]['data'][$date]['crushers'])){
                $dataBallasts['data'][$key]['data'][$date]['crushers'][$crusher] = 0;
            }

            $dataBallasts['data'][$key]['data'][$date]['crushers'][$crusher] += $count;

            $dataBallasts['data'][$key]['crushers'][$crusher]['quantity'] += $quantity;
            $dataBallasts['data'][$key]['crushers'][$crusher]['count'] += $count;
        }
        uasort($dataBallasts['data'], array($this, 'mySortMethod'));
        foreach ($dataBallasts['data'] as &$dataDriver){
            uasort($dataDriver['data'], array($this, 'mySortMethod'));
            uasort($dataDriver['crushers'], array($this, 'mySortMethod'));
            uasort($dataDriver['distances'], array($this, 'mySortMethod'));
        }

        $viewObject = 'ab1/_report/'.$this->_sitePageData->languageID.'/ballast/day_drivers';
        $tmp = str_replace('\\', '/', $viewObject);
        try {
            $view = View::factory($tmp);
        }catch (Exception $e) {
            throw new Exception('Шаблон "'.$tmp.'" не найден.');
        }

        $view->ballasts = $dataBallasts;
        $view->dateFrom = $dateFrom;
        $view->dateTo = $dateTo;
        $view->operation = $this->_sitePageData->operation->getValues();
        $view->shop = $this->_sitePageData->shop->getName();
        $view->shopOptions = $this->_sitePageData->shop->getOptionsArray();
        $strView = Helpers_View::viewToStr($view);

        header('Content-Type: application/x-download;charset=UTF-8');
        // header('Content-Type: application/vnd.openxmlf.ormats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: filename="БТ02 Учет рейсов балласта по дням.xml"');
        header('Cache-Control: max-age=0');

        echo $strView;
        exit();
    }

    /**
     * Время простоя вагонов, которые не выехали
     * @throws Exception
     */
    public function action_boxcar_downtime() {
        set_time_limit(36000);

        $this->_sitePageData->url = '/'.$this->actionURLName.'/shopreport/boxcar_downtime';

        $shopMaterialIDs = NULL;

        // задаем время выборки
        $dateFrom = Request_RequestParams::getParamDateTime('date_departure_from');
        $dateTo = Request_RequestParams::getParamDateTime('date_departure_to');
        $shopBoxcarClientID = Request_RequestParams::getParamInt('shop_boxcar_client_id');

        $params = Request_RequestParams::setParams(
            array(
                'shop_boxcar_client_id' => $shopBoxcarClientID,
                'date_departure_from' => $dateFrom,
                'date_departure_to' => $dateTo,
                'sort_by' => array('created_at' => 'asc'),
            )
        );
        $ids = Request_Request::find('DB_Ab1_Shop_Boxcar',
            $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB,
            $params, 0, TRUE,
            array(
                'shop_boxcar_client_id' => array('name'),
                'shop_raw_id' => array('name'),
                'shop_boxcar_train_id' => array('date_shipment', 'fine_day', 'downtime_permitted'),
            )
        );

        $dataBoxcars = array(
            'data' => array(),
            'quantity' => 0,
            'fine' => 0,
        );
        foreach ($ids->childs as $child){
            $downtime = ceil(Helpers_DateTime::diffHours($child->values['date_departure'], $child->values['date_arrival']));
            $downtimePermitted = $child->getElementValue('shop_boxcar_train_id', 'downtime_permitted');

            if($downtimePermitted > $downtime){
                continue;
            }

            $downtime = ceil(($downtime - $downtimePermitted) / 24);
            if($downtime == 0){
                continue;
            }

            $downtime = ceil(
                Helpers_DateTime::diffDays(
                    Helpers_DateTime::getDateFormatPHP($child->values['date_departure']).'23:59:59',
                    Helpers_DateTime::plusHours($child->values['date_arrival'], $downtimePermitted)
                )
            );


            $fineDay = $child->getElementValue('shop_boxcar_train_id', 'fine_day');

            $quantity = $child->values['quantity'];
            $dateTimeShipment = $child->getElementValue('shop_boxcar_train_id', 'date_shipment');

            // группируем по дням отгрузки
            $dateShipment = Helpers_DateTime::getDateFormatPHP($dateTimeShipment);
            if (! key_exists($dateShipment, $dataBoxcars['data'])){
                $dataBoxcars['data'][$dateShipment] = array(
                    'data' => array(),
                    'name' => $dateShipment,
                    'quantity' => 0,
                    'fine' => 0,
                );
            }

            $fine = $downtime * $fineDay;
            $dataBoxcars['data'][$dateShipment]['data'][] = array(
                'shop_boxcar_client_name' => $child->getElementValue('shop_boxcar_client_id'),//
                'shop_raw_name' => $child->getElementValue('shop_raw_id'),//
                'date_shipment' => $child->getElementValue('shop_boxcar_train_id', 'date_shipment'),//
                'number' => $child->values['number'],//
                'quantity' => $quantity,//
                'date_arrival' => $child->values['date_arrival'],
                'date_departure' => $child->values['date_departure'],
                'downtime_permitted' => $downtimePermitted,
                'downtime' => $downtime,
                'fine_day' => $fineDay,
                'fine' => $fine,
            );

            $dataBoxcars['data'][$dateShipment]['quantity'] += $quantity;
            $dataBoxcars['data'][$dateShipment]['fine'] += $fine;

            $dataBoxcars['quantity'] += $quantity;
            $dataBoxcars['fine'] += $fine;
        }
        uasort($dataBoxcars['data'], array($this, 'mySortMethod'));

        $client = array();
        if($shopBoxcarClientID > 0){
            $model = new Model_Ab1_Shop_Client();
            $model->setDBDriver($this->_driverDB);
            if(Helpers_DB::getDBObject($model, $shopBoxcarClientID, $this->_sitePageData)){
                $client = $model->getValues(TRUE, TRUE);
            }
        }

        $viewObject = 'ab1/_report/'.$this->_sitePageData->languageID.'/boxcar/downtime';
        $tmp = str_replace('\\', '/', $viewObject);
        try {
            $view = View::factory($tmp);
        }catch (Exception $e) {
            throw new Exception('Шаблон "'.$tmp.'" не найден.');
        }

        $view->boxcars = $dataBoxcars;
        $view->client = $client;
        $view->dateFrom = $dateFrom;
        $view->dateTo = $dateTo;
        $view->operation = $this->_sitePageData->operation->getValues();
        $view->shop = $this->_sitePageData->shop->getName();
        $view->shopOptions = $this->_sitePageData->shop->getOptionsArray();
        $strView = Helpers_View::viewToStr($view);

        header('Content-Type: application/x-download;charset=UTF-8');
        // header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: filename="ВГ06 Время простоя вагонов.xml"');
        header('Cache-Control: max-age=0');

        echo $strView;
        exit();
    }

    /**
     * Реестр пломб вагонов, которые не выехали
     * @throws Exception
     */
    public function action_boxcar_stamps() {
        set_time_limit(36000);

        $this->_sitePageData->url = '/'.$this->actionURLName.'/shopreport/boxcar_stamps';

        $shopMaterialIDs = NULL;

        // задаем время выборки
        $shopBoxcarClientID = Request_RequestParams::getParamInt('shop_boxcar_client_id');

        $params = Request_RequestParams::setParams(
            array(
                //'is_exit' => 0,
                'shop_boxcar_client_id' => $shopBoxcarClientID,
                'is_date_departure_empty' => TRUE,
                'sort_by' => array('created_at' => 'asc'),
            )
        );
        $ids = Request_Request::find('DB_Ab1_Shop_Boxcar',
            $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB,
            $params, 0, TRUE,
            array(
                'shop_boxcar_client_id' => array('name'),
                'shop_raw_id' => array('name'),
                'shop_boxcar_departure_station_id' => array('name'),
                'shop_boxcar_train_id' => array('date_shipment'),
            )
        );

        $dataBoxcars = array(
            'data' => array(),
            'quantity' => 0,
        );
        foreach ($ids->childs as $child){
            $quantity = $child->values['quantity'];
            $dateTimeShipment = $child->getElementValue('shop_boxcar_train_id', 'date_shipment');

            // группируем по дням отгрузки
            $dateShipment = Helpers_DateTime::getDateFormatPHP($dateTimeShipment);
            if (! key_exists($dateShipment, $dataBoxcars['data'])){
                $dataBoxcars['data'][$dateShipment] = array(
                    'data' => array(),
                    'name' => $dateShipment,
                    'quantity' => 0,
                );
            }

            $dataBoxcars['data'][$dateShipment]['data'][] = array(
                'shop_boxcar_client_name' => $child->getElementValue('shop_boxcar_client_id'),
                'shop_raw_name' => $child->getElementValue('shop_raw_id'),
                'shop_boxcar_departure_station_name' => $child->getElementValue('shop_boxcar_departure_station_id'),
                'date_shipment' => $child->getElementValue('shop_boxcar_train_id', 'date_shipment'),
                'number' => $child->values['number'],
                'quantity' => $quantity,
                'stamp' => $child->values['stamp'],
            );

            $dataBoxcars['data'][$dateShipment]['quantity'] += $quantity;
            $dataBoxcars['quantity'] += $quantity;
        }
        uasort($dataBoxcars['data'], array($this, 'mySortMethod'));

        $client = array();
        if($shopBoxcarClientID > 0){
            $model = new Model_Ab1_Shop_Client();
            $model->setDBDriver($this->_driverDB);
            if(Helpers_DB::getDBObject($model, $shopBoxcarClientID, $this->_sitePageData)){
                $client = $model->getValues(TRUE, TRUE);
            }
        }

        $viewObject = 'ab1/_report/'.$this->_sitePageData->languageID.'/boxcar/stamps';
        $tmp = str_replace('\\', '/', $viewObject);
        try {
            $view = View::factory($tmp);
        }catch (Exception $e) {
            throw new Exception('Шаблон "'.$tmp.'" не найден.');
        }

        $view->boxcars = $dataBoxcars;
        $view->client = $client;
        $view->operation = $this->_sitePageData->operation->getValues();
        $view->shop = $this->_sitePageData->shop->getName();
        $view->shopOptions = $this->_sitePageData->shop->getOptionsArray();
        $strView = Helpers_View::viewToStr($view);

        header('Content-Type: application/x-download;charset=UTF-8');
        // header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: filename="ВГ05 Реестр пломб.xml"');
        header('Cache-Control: max-age=0');

        echo $strView;
        exit();
    }

    /**
     * Список вагонов, которые разгружаются
     * @throws Exception
     */
    public function action_boxcar_unload() {
        set_time_limit(36000);

        $this->_sitePageData->url = '/'.$this->actionURLName.'/shopreport/boxcar_unload';

        $shopMaterialIDs = NULL;

        // задаем время выборки
        $shopBoxcarClientID = Request_RequestParams::getParamInt('shop_boxcar_client_id');

        $params = Request_RequestParams::setParams(
            array(
               // 'is_exit' => 0,
                'shop_boxcar_client_id' => $shopBoxcarClientID,
                'is_date_drain_to_empty' => TRUE,
                'is_date_drain_from_empty' => FALSE,
                'sort_by' => array('created_at' => 'asc'),
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

        $dataBoxcars = array(
            'data' => array(),
            'quantity' => 0,
        );
        foreach ($ids->childs as $child){
            $quantity = $child->values['quantity'];
            $dateTimeShipment = $child->getElementValue('shop_boxcar_train_id', 'date_shipment');

            // группируем по дням отгрузки
            $dateShipment = Helpers_DateTime::getDateFormatPHP($dateTimeShipment);
            if (! key_exists($dateShipment, $dataBoxcars['data'])){
                $dataBoxcars['data'][$dateShipment] = array(
                    'data' => array(),
                    'name' => $dateShipment,
                    'quantity' => 0,
                );
            }

            $dataBoxcars['data'][$dateShipment]['data'][] = array(
                'shop_boxcar_client_name' => $child->getElementValue('shop_boxcar_client_id'),
                'shop_raw_name' => $child->getElementValue('shop_raw_id'),
                'date_shipment' => $child->getElementValue('shop_boxcar_train_id', 'date_shipment'),
                'number' => $child->values['number'],
                'quantity' => $quantity,
                'date_arrival' => $child->values['date_arrival'],
                'date_drain_from' => $child->values['date_drain_from'],
            );

            $dataBoxcars['data'][$dateShipment]['quantity'] += $quantity;
            $dataBoxcars['quantity'] += $quantity;
        }
        uasort($dataBoxcars['data'], array($this, 'mySortMethod'));

        $client = array();
        if($shopBoxcarClientID > 0){
            $model = new Model_Ab1_Shop_Client();
            $model->setDBDriver($this->_driverDB);
            if(Helpers_DB::getDBObject($model, $shopBoxcarClientID, $this->_sitePageData)){
                $client = $model->getValues(TRUE, TRUE);
            }
        }

        $viewObject = 'ab1/_report/'.$this->_sitePageData->languageID.'/boxcar/unload';
        $tmp = str_replace('\\', '/', $viewObject);
        try {
            $view = View::factory($tmp);
        }catch (Exception $e) {
            throw new Exception('Шаблон "'.$tmp.'" не найден.');
        }

        $view->boxcars = $dataBoxcars;
        $view->client = $client;
        $view->operation = $this->_sitePageData->operation->getValues();
        $view->shop = $this->_sitePageData->shop->getName();
        $view->shopOptions = $this->_sitePageData->shop->getOptionsArray();
        $strView = Helpers_View::viewToStr($view);

        header('Content-Type: application/x-download;charset=UTF-8');
        // header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: filename="ВГ04 Разгружающиеся вагоны.xml"');
        header('Cache-Control: max-age=0');

        echo $strView;
        exit();
    }

    /**
     * Список вагонов, которые прибыли
     * @throws Exception
     */
    public function action_boxcar_arrival() {
        set_time_limit(36000);

        $this->_sitePageData->url = '/'.$this->actionURLName.'/shopreport/boxcar_arrival';

        $shopMaterialIDs = NULL;

        // задаем время выборки
        $dateFrom = Request_RequestParams::getParamDateTime('date_arrival_from');
        $dateTo = Request_RequestParams::getParamDateTime('date_arrival_to');
        $shopBoxcarClientID = Request_RequestParams::getParamInt('shop_boxcar_client_id');

        $isDeparture = Request_RequestParams::getParamBoolean('is_date_departure_empty');
        if($isDeparture !== TRUE){
            $isDeparture = NULL;
        }
        $params = Request_RequestParams::setParams(
            array(
               // 'is_exit' => 0,
                'shop_boxcar_client_id' => $shopBoxcarClientID,
                'date_arrival_from' => $dateFrom,
                'date_arrival_to' => $dateTo,
                'is_date_departure_empty' => $isDeparture,
                'is_date_arrival_empty' => FALSE,
                'sort_by' => array('created_at' => 'asc'),
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

        $dataBoxcars = array(
            'data' => array(),
            'quantity' => 0,
        );
        foreach ($ids->childs as $child){
            $quantity = $child->values['quantity'];
            $dateTimeShipment = $child->getElementValue('shop_boxcar_train_id', 'date_shipment');

            // группируем по дням отгрузки
            $dateShipment = Helpers_DateTime::getDateFormatPHP($dateTimeShipment);
            if (! key_exists($dateShipment, $dataBoxcars['data'])){
                $dataBoxcars['data'][$dateShipment] = array(
                    'data' => array(),
                    'name' => $dateShipment,
                    'quantity' => 0,
                );
            }

            $dataBoxcars['data'][$dateShipment]['data'][] = array(
                'shop_boxcar_client_name' => $child->getElementValue('shop_boxcar_client_id'),
                'shop_raw_name' => $child->getElementValue('shop_raw_id'),
                'date_shipment' => $child->getElementValue('shop_boxcar_train_id', 'date_shipment'),
                'number' => $child->values['number'],
                'quantity' => $quantity,
                'date_arrival' => $child->values['date_arrival'],
            );

            $dataBoxcars['data'][$dateShipment]['quantity'] += $quantity;
            $dataBoxcars['quantity'] += $quantity;
        }
        uasort($dataBoxcars['data'], array($this, 'mySortMethod'));

        $client = array();
        if($shopBoxcarClientID > 0){
            $model = new Model_Ab1_Shop_Client();
            $model->setDBDriver($this->_driverDB);
            if(Helpers_DB::getDBObject($model, $shopBoxcarClientID, $this->_sitePageData)){
                $client = $model->getValues(TRUE, TRUE);
            }
        }

        $viewObject = 'ab1/_report/'.$this->_sitePageData->languageID.'/boxcar/arrival';
        $tmp = str_replace('\\', '/', $viewObject);
        try {
            $view = View::factory($tmp);
        }catch (Exception $e) {
            throw new Exception('Шаблон "'.$tmp.'" не найден.');
        }

        $view->boxcars = $dataBoxcars;
        $view->client = $client;
        $view->dateFrom = $dateFrom;
        $view->dateTo = $dateTo;
        $view->operation = $this->_sitePageData->operation->getValues();
        $view->shop = $this->_sitePageData->shop->getName();
        $view->shopOptions = $this->_sitePageData->shop->getOptionsArray();
        $strView = Helpers_View::viewToStr($view);

        header('Content-Type: application/x-download;charset=UTF-8');
        // header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: filename="ВГ03 Прибывшие вагоны.xml"');
        header('Cache-Control: max-age=0');

        echo $strView;
        exit();
    }

    /**
     * Список вагонов в пути сгруппированные по станциям
     * @throws Exception
     */
    public function action_boxcar_in_way_station() {
        set_time_limit(36000);

        $this->_sitePageData->url = '/'.$this->actionURLName.'/shopreport/boxcar_in_way_station';

        $shopMaterialIDs = NULL;

        // задаем время выборки
        $shopBoxcarClientID = Request_RequestParams::getParamInt('shop_boxcar_client_id');

        $params = Request_RequestParams::setParams(
            array(
                //'is_exit' => 0,
                'shop_boxcar_client_id' => $shopBoxcarClientID,
                'is_date_arrival_empty' => TRUE,
                'sort_by' => array('created_at' => 'asc'),
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

        $dataBoxcars = array(
            'data' => array(),
            'quantity' => 0,
            'count' => 0,
        );
        foreach ($ids->childs as $child){
            $station = Arr::path($child->values['options'], 'stations', array());
            $station = array_pop($station);

            $quantity = $child->values['quantity'];

            // группируем по станциям
            $key =  $station.'_'.$child->values['shop_boxcar_client_id'].'_'.$child->values['shop_raw_id'];
            if (! key_exists($key, $dataBoxcars['data'])){
                $dataBoxcars['data'][$key] = array(
                    'shop_boxcar_client_name' => $child->getElementValue('shop_boxcar_client_id'),
                    'shop_raw_name' => $child->getElementValue('shop_raw_id'),
                    'number' => $child->values['number'],
                    'quantity' => $quantity,
                    'station' => $station,
                    'count' => 0,
                );
            }

            $dataBoxcars['data'][$key]['quantity'] += $quantity;
            $dataBoxcars['data'][$key]['count'] ++;

            $dataBoxcars['quantity'] += $quantity;
            $dataBoxcars['count'] ++;
        }

        $client = array();
        if($shopBoxcarClientID > 0){
            $model = new Model_Ab1_Shop_Client();
            $model->setDBDriver($this->_driverDB);
            if(Helpers_DB::getDBObject($model, $shopBoxcarClientID, $this->_sitePageData)){
                $client = $model->getValues(TRUE, TRUE);
            }
        }

        $viewObject = 'ab1/_report/'.$this->_sitePageData->languageID.'/boxcar/in-way-station';
        $tmp = str_replace('\\', '/', $viewObject);
        try {
            $view = View::factory($tmp);
        }catch (Exception $e) {
            throw new Exception('Шаблон "'.$tmp.'" не найден.');
        }

        $view->boxcars = $dataBoxcars;
        $view->client = $client;
        $view->operation = $this->_sitePageData->operation->getValues();
        $view->shop = $this->_sitePageData->shop->getName();
        $view->shopOptions = $this->_sitePageData->shop->getOptionsArray();
        $strView = Helpers_View::viewToStr($view);

        header('Content-Type: application/x-download;charset=UTF-8');
        // header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: filename="ВГ01 Вагоны в пути сгруппированные по станциям.xml"');
        header('Cache-Control: max-age=0');

        echo $strView;
        exit();
    }

    /**
     * Список вагонов в пути
     * @throws Exception
     */
    public function action_boxcar_in_way() {
        set_time_limit(36000);

        $this->_sitePageData->url = '/'.$this->actionURLName.'/shopreport/boxcar_in_way';

        $shopMaterialIDs = NULL;

        // задаем время выборки
        $shopBoxcarClientID = Request_RequestParams::getParamInt('shop_boxcar_client_id');

        $params = Request_RequestParams::setParams(
            array(
                //'is_exit' => 0,
                'shop_boxcar_client_id' => $shopBoxcarClientID,
                'is_date_arrival_empty' => TRUE,
                'sort_by' => array('created_at' => 'asc'),
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

        $dataBoxcars = array(
            'data' => array(),
            'quantity' => 0,
        );
        foreach ($ids->childs as $child){
            $quantity = $child->values['quantity'];
            $dateTimeShipment = $child->getElementValue('shop_boxcar_train_id', 'date_shipment');

            // группируем по дням отгрузки
            $dateShipment = Helpers_DateTime::getDateFormatPHP($dateTimeShipment);
            if (! key_exists($dateShipment, $dataBoxcars['data'])){
                $dataBoxcars['data'][$dateShipment] = array(
                    'data' => array(),
                    'name' => $dateShipment,
                    'quantity' => 0,
                );
            }

            $station = Arr::path($child->values['options'], 'stations', array());
            $station = array_pop($station);

            $dataBoxcars['data'][$dateShipment]['data'][] = array(
                'shop_boxcar_client_name' => $child->getElementValue('shop_boxcar_client_id'),
                'shop_raw_name' => $child->getElementValue('shop_raw_id'),
                'date_shipment' => $child->getElementValue('shop_boxcar_train_id', 'date_shipment'),
                'number' => $child->values['number'],
                'quantity' => $quantity,
                'station' => $station,
            );


            $dataBoxcars['data'][$dateShipment]['quantity'] += $quantity;
            $dataBoxcars['quantity'] += $quantity;
        }
        uasort($dataBoxcars['data'], array($this, 'mySortMethod'));

        $client = array();
        if($shopBoxcarClientID > 0){
            $model = new Model_Ab1_Shop_Client();
            $model->setDBDriver($this->_driverDB);
            if(Helpers_DB::getDBObject($model, $shopBoxcarClientID, $this->_sitePageData)){
                $client = $model->getValues(TRUE, TRUE);
            }
        }

        $viewObject = 'ab1/_report/'.$this->_sitePageData->languageID.'/boxcar/in-way';
        $tmp = str_replace('\\', '/', $viewObject);
        try {
            $view = View::factory($tmp);
        }catch (Exception $e) {
            throw new Exception('Шаблон "'.$tmp.'" не найден.');
        }

        $view->boxcars = $dataBoxcars;
        $view->client = $client;
        $view->operation = $this->_sitePageData->operation->getValues();
        $view->shop = $this->_sitePageData->shop->getName();
        $view->shopOptions = $this->_sitePageData->shop->getOptionsArray();
        $strView = Helpers_View::viewToStr($view);

        header('Content-Type: application/x-download;charset=UTF-8');
        // header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: filename="ВГ02 Вагоны в пути.xml"');
        header('Cache-Control: max-age=0');

        echo $strView;
        exit();
    }

    /**
     * Реестр заезда и взвешивания тары материала
     * @throws Exception
     */
    public function action_material_entry_and_tare_cars() {
        set_time_limit(36000);

        $this->_sitePageData->url = '/'.$this->actionURLName.'/shopreport/material_entry_and_tare_cars';

        $shopMaterialIDs = NULL;

        // задаем время выборки
        $dateFrom = Request_RequestParams::getParamDateTime('created_at_from');
        $dateTo = Request_RequestParams::getParamDateTime('created_at_to');

        $rubric = Request_RequestParams::getParamInt('shop_material_rubric_id');
        if($rubric > 0){
            $model = new Model_Ab1_Shop_Material_Rubric();
            $model->setDBDriver($this->_driverDB);
            Helpers_DB::getDBObject($model, $rubric, $this->_sitePageData, $this->_sitePageData->shopMainID);
            $materialRubricName = $model->getName();
        }else{
            $materialRubricName = '';
        }

        $params = array(
            'is_exit' => 1,
            'shop_material_id' => $shopMaterialIDs,
            'shop_material_rubric_id' => $rubric,
            'date_document_from' => $dateFrom,
            'date_document_to' => $dateTo,
            'shop_branch_receiver_id' => $this->_sitePageData->shopID,
            'sort_by' => array(
                'created_at' => 'asc'
            ),
        );

        $ids = Request_Request::find('DB_Ab1_Shop_Car_To_Material',
            $this->_sitePageData->shopMainID, $this->_sitePageData, $this->_driverDB,
            $params,0, TRUE,
            array(
                'shop_branch_receiver_id' => array('name'),
                'shop_branch_daughter_id' => array('name'),
                'shop_daughter_id' => array('name'),
                'shop_heap_receiver_id' => array('name'),
                'shop_heap_daughter_id' => array('name'),
                'shop_subdivision_receiver_id' => array('name'),
                'shop_subdivision_daughter_id' => array('name'),
            )
        );

        $quantity = 0;
        $quantityDaughter = 0;
        $dataMaterials = array();
        foreach ($ids->childs as $child){
            $car = array(
                'created_at' => $child->values['created_at'],
                'update_tare_at' => '',
                'daughter' => $child->getElementValue('shop_branch_daughter_id', 'name', $child->getElementValue('shop_daughter_id')),
                'heap_daughter' => $child->getElementValue('shop_heap_daughter_id'),
                'subdivision_daughter' => $child->getElementValue('shop_subdivision_daughter_id'),
                'receiver' => $child->getElementValue('shop_branch_receiver_id'),
                'heap_receiver' => $child->getElementValue('shop_heap_receiver_id'),
                'subdivision_receiver' => $child->getElementValue('shop_subdivision_receiver_id'),
                'name' => $child->values['name'],
                'quantity' => 0,
                'quantity_daughter' => $child->values['quantity_daughter'],
            );

            if((!empty($child->values['update_tare_at']))
                && (strtotime($child->values['update_tare_at']) > strtotime($child->values['created_at']))) {
                $car['update_tare_at'] = $child->values['update_tare_at'];
                $car['quantity'] = $child->values['quantity'];

                $quantity += $child->values['quantity'];
            }

            $quantityDaughter += $child->values['quantity_daughter'];
            $dataMaterials[] = $car;
        }

        $viewObject = 'ab1/_report/'.$this->_sitePageData->languageID.'/material/entry_and_tare_cars';
        $tmp = str_replace('\\', '/', $viewObject);
        try {
            $view = View::factory($tmp);
        }catch (Exception $e) {
            throw new Exception('Шаблон "'.$tmp.'" не найден.');
        }

        $view->materialRubricName = $materialRubricName;
        $view->materials = $dataMaterials;
        $view->quantity = $quantity;
        $view->quantityDaughter = $quantityDaughter;
        $view->dateFrom = $dateFrom;
        $view->dateTo = $dateTo;
        $view->operation = $this->_sitePageData->operation->getValues();
        $view->shop = $this->_sitePageData->shop->getName();
        $view->shopOptions = $this->_sitePageData->shop->getOptionsArray();
        $strView = Helpers_View::viewToStr($view);

        header('Content-Type: application/x-download;charset=UTF-8');
        // header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: filename="АБ04 Реестр заезда и взвешивания тары материала.xml"');
        header('Cache-Control: max-age=0');

        echo $strView;
        exit();
    }

    /**
     * Отчет список машин с материалом
     * @throws Exception
     */
    public function action_material_list_car() {
        set_time_limit(36000);

        $this->_sitePageData->url = '/'.$this->actionURLName.'/shopreport/material_list_car';

        $shopMaterialIDs = NULL;

        // задаем время выборки
        $dateFrom = Request_RequestParams::getParamDateTime('created_at_from');
        $dateTo = Request_RequestParams::getParamDateTime('created_at_to');

        $rubric = Request_RequestParams::getParamInt('shop_material_rubric_id');

        $params = array(
            'is_exit' => 1,
            'shop_material_id' => $shopMaterialIDs,
            'shop_material_rubric_id' => $rubric,
            'shop_transport_company_id' => Request_RequestParams::getParamInt('shop_transport_company_id'),
            'sort_by' => array(
                'shop_daughter_id' => 'desc',
                'shop_branch_daughter_id' => 'asc',
                'name' => 'asc',
                'created_at' => 'asc'
            ),
        );

        // определяем завоз или вывоз надо считывать
        $isImport = Request_RequestParams::getParamBoolean('is_import');
        $isExport = Request_RequestParams::getParamBoolean('is_export');
        $isBuy = Request_RequestParams::getParamBoolean('is_buy');
        if($isImport && (!$isExport)){
            $params['shop_branch_receiver_id'] = $this->_sitePageData->shopID;
            if($isBuy){
                $params['shop_daughter_id_from'] = 0;
            }

            $params['receiver_created_at_from'] = $dateFrom;
            $params['receiver_created_at_to'] = $dateTo;
        }elseif((!$isImport) && $isExport){
            $params['shop_branch_daughter_id'] = $this->_sitePageData->shopID;

            $params['created_at_from'] = $dateFrom;
            $params['created_at_to'] = $dateTo;
        }elseif($isBuy && (!$isImport) && (!$isExport)){
            $params['shop_daughter_id_from'] = 0;
            $params['shop_branch_receiver_id'] = $this->_sitePageData->shopID;

            $params['created_at_from'] = $dateFrom;
            $params['created_at_to'] = $dateTo;
        }else{
            $params['main_shop_id'] = $this->_sitePageData->shopID;

            $params['date_document_from'] = $dateFrom;
            $params['date_document_to'] = $dateTo;
        }

        $params = Request_RequestParams::setParams(
            $params
        );
        $ids = Request_Request::find('DB_Ab1_Shop_Car_To_Material',
            $this->_sitePageData->shopMainID, $this->_sitePageData, $this->_driverDB,
            $params, 0, TRUE,
            array(
                'shop_transport_company_id' => array('name'), 'shop_material_id' => array('name'),
                'shop_daughter_id' => array('name'), 'shop_branch_daughter_id' => array('name'),
                'shop_heap_daughter_id' => array('name'),
                'shop_heap_receiver_id' => array('name'),
                'shop_subdivision_daughter_id' => array('name'),
                'shop_subdivision_receiver_id' => array('name'),
                'shop_branch_receiver_id' => array('name'),
            )
        );

        $quantity = 0;
        $quantityDaughter = 0;
        $quantityInvoice = 0;
        $dataMaterials = array();
        foreach ($ids->childs as $child){
            $dataMaterials[] = array(
                'created_at' => $child->values['created_at'],
                'update_tare_at' => $child->values['update_tare_at'],
                'daughter' => $child->getElementValue('shop_branch_daughter_id', 'name', $child->getElementValue('shop_daughter_id')),
                'heap_daughter' => $child->getElementValue('shop_heap_daughter_id'),
                'subdivision_daughter' => $child->getElementValue('shop_subdivision_daughter_id'),
                'receiver' => $child->getElementValue('shop_branch_receiver_id'),
                'heap_receiver' => $child->getElementValue('shop_heap_receiver_id'),
                'subdivision_receiver' => $child->getElementValue('shop_subdivision_receiver_id'),
                'transport_company' => $child->getElementValue('shop_transport_company_id'),
                'material' => $child->getElementValue('shop_material_id'),
                'name' => $child->values['name'],
                'quantity' => $child->values['quantity'],
                'quantity_daughter' => $child->values['quantity_daughter'],
                'quantity_invoice' => $child->values['quantity_invoice'],
            );

            $quantity += $child->values['quantity'];
            $quantityDaughter += $child->values['quantity_daughter'];
            $quantityInvoice += $child->values['quantity_invoice'];
        }

        $viewObject = 'ab1/_report/'.$this->_sitePageData->languageID.'/material/list-car';
        $tmp = str_replace('\\', '/', $viewObject);
        try {
            $view = View::factory($tmp);
        }catch (Exception $e) {
            throw new Exception('Шаблон "'.$tmp.'" не найден.');
        }

        $view->materials = $dataMaterials;
        $view->quantity = $quantity;
        $view->quantityDaughter = $quantityDaughter;
        $view->quantityInvoice = $quantityInvoice;
        $view->operation = $this->_sitePageData->operation->getValues();
        $view->shop = $this->_sitePageData->shop->getName();
        $view->shopOptions = $this->_sitePageData->shop->getOptionsArray();
        $strView = Helpers_View::viewToStr($view);

        header('Content-Type: application/x-download;charset=UTF-8');
        // header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: filename="ВС10 Список машин с материалом.xml"');
        header('Cache-Control: max-age=0');

        echo $strView;
        exit();
    }

    /**
     * Отчет по отправителям материалов вес с накладной
     * @throws Exception
     */
    public function action_material_daughter_invoice() {
        set_time_limit(36000);

        $this->_sitePageData->url = '/'.$this->actionURLName.'/shopreport/material_daughter_invoice';

        $shopMaterialIDs = NULL;

        $dateFrom = Request_RequestParams::getParamDateTime('created_at_from');
        $dateTo = Request_RequestParams::getParamDateTime('created_at_to');

        $params = Request_RequestParams::setParams(
            array(
                'is_exit' => 1,
                'shop_material_id' => $shopMaterialIDs,
                'shop_branch_receiver_id' => $this->_sitePageData->shopID,
                'date_document_from' => $dateFrom,
                'date_document_to' => $dateTo,
            )
        );
        $ids = Request_Request::find('DB_Ab1_Shop_Car_To_Material',
            $this->_sitePageData->shopMainID, $this->_sitePageData, $this->_driverDB,
            $params,0, TRUE,
            array(
                'shop_transport_company_id' => array('name'),
                'shop_material_id' => array('name'),
                'shop_daughter_id' => array('name', 'daughter_weight_id'),
                'shop_branch_daughter_id' => array('name')
            )
        );

        // список отправителей и список транспорных компаний
        $daughters = array();
        $companies = array();
        foreach ($ids->childs as $child){
            $daughterID = $child->values['shop_daughter_id'];
            if($daughterID > 0){
                $daughterID = 'd_'.$daughterID;
            }else{
                $daughterID = 'b_'.$child->values['shop_branch_daughter_id'];
            }

            if (!key_exists($daughterID, $daughters)){
                $daughters[$daughterID] = array(
                    'data' => array(),
                    'name' => $child->getElementValue('shop_daughter_id', 'name', $child->getElementValue('shop_branch_daughter_id')),
                    'quantity' => 0,
                    'count' => 0,
                    'cars' => array(),
                );
            }

            $material = $child->values['shop_material_id'];
            if (! key_exists($material, $daughters[$daughterID]['data'])){
                $daughters[$daughterID]['data'][$material] = array(
                    'data' => array(),
                    'name' => $child->getElementValue('shop_material_id'),
                    'quantity' => 0,
                    'count' => 0,
                    'cars' => array(),
                );
            }

            $companyID = $child->values['shop_transport_company_id'];
            if (!key_exists($companyID, $companies)){
                $companies[$companyID] = array(
                    'data' => array(),
                    'name' => $child->getElementValue('shop_transport_company_id'),
                    'quantity' => 0,
                    'count' => 0,
                    'cars' => array(),
                );
            }
        }
        uasort($daughters, array($this, 'mySortMethod'));
        uasort($companies, array($this, 'mySortMethod'));

        $dataDaughters = array(
            'data' => $daughters,
            'quantity' => 0,
            'count' => 0,
            'cars' => array(),
        );
        $dataCompanies = array(
            'data' => $companies,
            'quantity' => 0,
            'count' => 0,
            'cars' => array(),
        );
        $dataMaterials = array(
            'data' => array(),
            'quantity' => 0,
            'count' => 0,
            'cars' => array(),
        );
        foreach ($ids->childs as $child){
            $number = $child->values['name'];
            $quantity = Api_Ab1_Shop_Car_To_Material::getQuantity($child);

            $daughter = $child->values['shop_daughter_id'];
            if($daughter > 0){
                $daughter = 'd_'.$daughter;
            }else{
                $daughter = 'b_'.$child->values['shop_branch_daughter_id'];
            }

            $dataDaughters['data'][$daughter]['quantity'] += $quantity;
            $dataDaughters['data'][$daughter]['count'] ++;
            $dataDaughters['data'][$daughter]['cars'][$number] = '';

            $material = $child->values['shop_material_id'];
            $dataDaughters['data'][$daughter]['data'][$material]['quantity'] += $quantity;
            $dataDaughters['data'][$daughter]['data'][$material]['count'] ++;
            $dataDaughters['data'][$daughter]['data'][$material]['cars'][$number] = '';

            $company = $child->values['shop_transport_company_id'];
            if (! key_exists($company, $dataMaterials['data'])){
                $dataMaterials['data'][$company] = array(
                    'data' => $daughters,
                    'name' => $child->getElementValue('shop_transport_company_id'),
                    'quantity' => 0,
                    'count' => 0,
                    'cars' => array(),
                );
            }

            $dataMaterials['data'][$company]['data'][$daughter]['data'][$material]['quantity'] += $quantity;
            $dataMaterials['data'][$company]['data'][$daughter]['data'][$material]['count'] ++;
            $dataMaterials['data'][$company]['data'][$daughter]['data'][$material]['cars'][$number] = '';

            $dataMaterials['data'][$company]['data'][$daughter]['quantity'] += $quantity;
            $dataMaterials['data'][$company]['data'][$daughter]['count'] ++;
            $dataMaterials['data'][$company]['data'][$daughter]['cars'][$number] = '';

            $dataMaterials['data'][$company]['quantity'] += $quantity;
            $dataMaterials['data'][$company]['count'] ++;
            $dataMaterials['data'][$company]['cars'][$number] = '';

            $dataMaterials['quantity'] += $quantity;
            $dataMaterials['count'] ++;
            $dataMaterials['cars'][$number] = '';

            $dataCompanies['data'][$company]['quantity'] += $quantity;
            $dataCompanies['data'][$company]['count'] ++;
            $dataCompanies['data'][$company]['cars'][$number] = '';
        }
        uasort($dataCompanies['data'], array($this, 'mySortMethod'));
        uasort($dataMaterials['data'], array($this, 'mySortMethod'));

        $viewObject = 'ab1/_report/'.$this->_sitePageData->languageID.'/material/daughter-invoice';
        $tmp = str_replace('\\', '/', $viewObject);
        try {
            $view = View::factory($tmp);
        }catch (Exception $e) {
            throw new Exception('Шаблон "'.$tmp.'" не найден.');
        }

        $view->companies = $dataCompanies;
        $view->materials = $dataMaterials;
        $view->daughters = $dataDaughters;
        $view->operation = $this->_sitePageData->operation->getValues();
        $view->shop = $this->_sitePageData->shop->getName();
        $view->shopOptions = $this->_sitePageData->shop->getOptionsArray();
        $strView = Helpers_View::viewToStr($view);

        header('Content-Type: application/x-download;charset=UTF-8');
        // header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: filename="ВС08 Отчет по завозу материалов вес с накладной.xml"');
        header('Cache-Control: max-age=0');

        echo $strView;
        exit();
    }

    /**
     * Отчет по отправителям материалов список материалов сгрупированные по отправителям
     * @throws Exception
     */
    public function action_material_daughter() {
        set_time_limit(36000);

        $this->_sitePageData->url = '/'.$this->actionURLName.'/shopreport/material_daughter';

        $shopMaterialIDs = NULL;

        $dateFrom = Request_RequestParams::getParamDateTime('created_at_from');
        $dateTo = Request_RequestParams::getParamDateTime('created_at_to');

        $params = Request_RequestParams::setParams(
            array(
                'is_exit' => 1,
                'shop_material_id' => $shopMaterialIDs,
                'shop_branch_receiver_id' => $this->_sitePageData->shopID,
                'date_document_from' => $dateFrom,
                'date_document_to' => $dateTo,
            )
        );
        $ids = Request_Request::find('DB_Ab1_Shop_Car_To_Material',
            $this->_sitePageData->shopMainID, $this->_sitePageData, $this->_driverDB,
            $params,0, TRUE,
            array(
                'shop_branch_daughter_id' => array('name'),
                'shop_daughter_id' => array('name', 'daughter_weight_id'),
                'shop_material_id' => array('name')
            )
        );

        $materials = array();
        foreach ($ids->childs as $child){
            $material = $child->values['shop_material_id'];
            if (! key_exists($material, $materials)){
                $materials[$material] = array(
                    'quantity' => 0,
                    'data' => array(),
                    'name' => $child->getElementValue('shop_material_id'),
                );
            }
        }
        uasort($materials, array($this, 'mySortMethod'));

        $dataMaterials = $materials;
        $dataDaughters = array(
            'data' => array(),
            'quantity' => 0,
        );
        foreach ($ids->childs as $child){
            $quantity = Api_Ab1_Shop_Car_To_Material::getQuantity($child);
            $material = $child->values['shop_material_id'];
            $dataMaterials[$material]['quantity'] += $quantity;

            $daughter = $child->values['shop_daughter_id'];
            if($daughter > 0){
                $daughter = 'd_'.$daughter;
            }else{
                $daughter = 'b_'.$child->values['shop_branch_daughter_id'];
            }

            if (! key_exists($daughter, $dataDaughters['data'])){
                $dataDaughters['data'][$daughter] = array(
                    'data' => $materials,
                    'name' => $child->getElementValue('shop_daughter_id', 'name', $child->getElementValue('shop_branch_daughter_id')),
                    'quantity' => 0
                );
            }

            $dataDaughters['data'][$daughter]['data'][$material]['quantity'] += $quantity;
            $dataDaughters['data'][$daughter]['quantity'] += $quantity;
            $dataDaughters['quantity'] += $quantity;
        }
        uasort($dataDaughters['data'], array($this, 'mySortMethod'));

        $viewObject = 'ab1/_report/'.$this->_sitePageData->languageID.'/material/daughter';
        $tmp = str_replace('\\', '/', $viewObject);
        try {
            $view = View::factory($tmp);
        }catch (Exception $e) {
            throw new Exception('Шаблон "'.$tmp.'" не найден.');
        }

        $view->materials = $dataMaterials;
        $view->daughters = $dataDaughters;
        $view->operation = $this->_sitePageData->operation->getValues();
        $view->shop = $this->_sitePageData->shop->getName();
        $view->shopOptions = $this->_sitePageData->shop->getOptionsArray();
        $strView = Helpers_View::viewToStr($view);

        header('Content-Type: application/x-download;charset=UTF-8');
        // header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: filename="ВС08 Отчет по завозу материалов.xml"');
        header('Cache-Control: max-age=0');

        echo $strView;
        exit();
    }

    /**
     * Отчет по получателям материалов список материалов сгрупированные по получателям
     * @throws Exception
     */
    public function action_material_receiver() {
        set_time_limit(36000);

        $this->_sitePageData->url = '/'.$this->actionURLName.'/shopreport/material_receiver';

        $shopMaterialIDs = NULL;

        $dateFrom = Request_RequestParams::getParamDateTime('created_at_from');
        $dateTo = Request_RequestParams::getParamDateTime('created_at_to');
        $rubric = Request_RequestParams::getParamInt('shop_material_rubric_id');

        $params = Request_RequestParams::setParams(
            array(
                'is_exit' => 1,
                'shop_material_id' => $shopMaterialIDs,
                'shop_branch_daughter_id' => $this->_sitePageData->shopID,
                'date_document_from' => $dateFrom,
                'date_document_to' => $dateTo,
                'shop_material_rubric_id' => $rubric,
            )
        );
        $ids = Request_Request::find('DB_Ab1_Shop_Car_To_Material',
            $this->_sitePageData->shopMainID, $this->_sitePageData, $this->_driverDB,
            $params,0, TRUE,
            array('shop_branch_receiver_id' => array('name'), 'shop_material_id' => array('name'))
        );

        $materials = array();
        foreach ($ids->childs as $child){
            $material = $child->values['shop_material_id'];
            if (! key_exists($material, $materials)){
                $materials[$material] = array(
                    'quantity' => 0,
                    'data' => array(),
                    'name' => $child->getElementValue('shop_material_id'),
                );
            }
        }
        uasort($materials, array($this, 'mySortMethod'));

        $dataMaterials = $materials;
        $dataReceivers = array(
            'data' => array(),
            'quantity' => 0,
        );
        foreach ($ids->childs as $child){
            $quantity = $child->values['quantity_daughter'];

            $material = $child->values['shop_material_id'];
            $dataMaterials[$material]['quantity'] += $quantity;

            $receiver = $child->values['shop_branch_receiver_id'];
            if (! key_exists($receiver, $dataReceivers['data'])){
                $dataReceivers['data'][$receiver] = array(
                    'data' => $materials,
                    'name' => $child->getElementValue('shop_branch_receiver_id'),
                    'quantity' => 0
                );
            }

            $dataReceivers['data'][$receiver]['data'][$material]['quantity'] += $quantity;
            $dataReceivers['data'][$receiver]['quantity'] += $quantity;
            $dataReceivers['quantity'] += $quantity;
        }
        uasort($dataReceivers['data'], array($this, 'mySortMethod'));

        $viewObject = 'ab1/_report/'.$this->_sitePageData->languageID.'/material/receiver';
        $tmp = str_replace('\\', '/', $viewObject);
        try {
            $view = View::factory($tmp);
        }catch (Exception $e) {
            throw new Exception('Шаблон "'.$tmp.'" не найден.');
        }

        $view->materials = $dataMaterials;
        $view->receivers = $dataReceivers;
        $view->operation = $this->_sitePageData->operation->getValues();
        $view->shop = $this->_sitePageData->shop->getName();
        $view->shopOptions = $this->_sitePageData->shop->getOptionsArray();
        $strView = Helpers_View::viewToStr($view);

        header('Content-Type: application/x-download;charset=UTF-8');
        // header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: filename="Сводка по получателям материалов.xml"');
        header('Cache-Control: max-age=0');

        echo $strView;
        exit();
    }

    /**
     * Сводка по завозу и покупке материалов
     * @throws Exception
     */
    public function action_material_coming_group_daughter() {
        set_time_limit(36000);

        $this->_sitePageData->url = '/'.$this->actionURLName.'/shopreport/material_coming_group_daughter';

        $shopMaterialIDs = NULL;

        $dateFrom = Request_RequestParams::getParamDateTime('created_at_from');
        $dateTo = Request_RequestParams::getParamDateTime('created_at_to');
        $shopMaterialRubricID = Request_RequestParams::getParamInt('shop_material_rubric_id');

        $data = Api_Ab1_Shop_Car_To_Material::getMaterialComingGroupDaughter(
            $dateFrom, $dateTo, $shopMaterialRubricID,
            $this->_sitePageData, $this->_driverDB,
            Request_RequestParams::setParams(
                array(
                    'shop_heap_receiver_id' => Request_RequestParams::getParamInt('shop_heap_receiver_id'),
                    'shop_subdivision_receiver_id' => Request_RequestParams::getParamInt('shop_subdivision_receiver_id'),
                )
            ),
            Request_RequestParams::getParamBoolean('is_quantity_receive')
        );

        $viewObject = 'ab1/_report/'.$this->_sitePageData->languageID.'/material/coming-group-daughter';
        $tmp = str_replace('\\', '/', $viewObject);
        try {
            $view = View::factory($tmp);
        }catch (Exception $e) {
            throw new Exception('Шаблон "'.$tmp.'" не найден.');
        }

        $view->companies = $data['companies'];
        $view->materials = $data['materials'];
        $view->daughters = $data['daughters'];
        $view->operation = $this->_sitePageData->operation->getValues();
        $view->shop = $this->_sitePageData->shop->getName();
        $view->shopOptions = $this->_sitePageData->shop->getOptionsArray();
        $strView = Helpers_View::viewToStr($view);

        header('Content-Type: application/x-download;charset=UTF-8');
        // header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: filename="ВС06 Сводка по завозу и покупке материалов.xml"');
        header('Cache-Control: max-age=0');

        echo $strView;
        exit();
    }

    /**
     * Отчет по завозу материалов
     * @throws Exception
     */
    public function action_material_import_group_daughter() {
        set_time_limit(36000);

        $this->_sitePageData->url = '/'.$this->actionURLName.'/shopreport/material_import_group_daughter';

        $shopMaterialIDs = NULL;

        $dateFrom = Request_RequestParams::getParamDateTime('created_at_from');
        $dateTo = Request_RequestParams::getParamDateTime('created_at_to');

        $params = Request_RequestParams::setParams(
            array(
                'is_exit' => 1,
                'shop_material_id' => $shopMaterialIDs,
                'shop_branch_receiver_id' => $this->_sitePageData->shopID,
                'shop_branch_daughter_id_from' => 0,
                'date_document_from' => $dateFrom,
                'date_document_to' => $dateTo,
            )
        );

        $ids = Request_Request::find('DB_Ab1_Shop_Car_To_Material',
            $this->_sitePageData->shopMainID, $this->_sitePageData, $this->_driverDB,
            $params,0, TRUE,
            array(
                'shop_transport_company_id' => array('name'),
                'shop_material_id' => array('name'),
                'shop_branch_daughter_id' => array('name'),
                'shop_daughter_id' => array('daughter_weight_id')
            )
        );

        // список отправителей и список транспорных компаний
        $daughters = array();
        $companies = array();
        foreach ($ids->childs as $child){
            $daughterID = $child->values['shop_branch_daughter_id'];

            if (!key_exists($daughterID, $daughters)){
                $daughters[$daughterID] = array(
                    'data' => array(),
                    'name' => $child->getElementValue('shop_branch_daughter_id'),
                    'quantity' => 0,
                    'count' => 0,
                );
            }

            $material = $child->values['shop_material_id'];
            if (! key_exists($material, $daughters[$daughterID]['data'])){
                $daughters[$daughterID]['data'][$material] = array(
                    'data' => array(),
                    'name' => $child->getElementValue('shop_material_id'),
                    'quantity' => 0,
                    'count' => 0,
                );
            }

            $companyID = $child->values['shop_transport_company_id'];
            if (!key_exists($companyID, $companies)){
                $companies[$companyID] = array(
                    'data' => array(),
                    'name' => $child->getElementValue('shop_transport_company_id'),
                    'quantity' => 0,
                    'count' => 0,
                );
            }
        }
        uasort($daughters, array($this, 'mySortMethod'));
        uasort($companies, array($this, 'mySortMethod'));

        $dataDaughters = array(
            'data' => $daughters,
            'quantity' => 0,
            'count' => 0,
        );
        $dataCompanies = array(
            'data' => $companies,
            'quantity' => 0,
            'count' => 0,
        );
        $dataMaterials = array(
            'data' => array(),
            'quantity' => 0,
            'count' => 0,
        );
        foreach ($ids->childs as $child){
            $quantity = Api_Ab1_Shop_Car_To_Material::getQuantity($child);

            $daughter = $child->values['shop_branch_daughter_id'];

            $dataDaughters['data'][$daughter]['quantity'] += $quantity;
            $dataDaughters['data'][$daughter]['count'] ++;

            $material = $child->values['shop_material_id'];
            $dataDaughters['data'][$daughter]['data'][$material]['quantity'] += $quantity;
            $dataDaughters['data'][$daughter]['data'][$material]['count'] ++;

            $company = $child->values['shop_transport_company_id'];
            if (! key_exists($company, $dataMaterials['data'])){
                $dataMaterials['data'][$company] = array(
                    'data' => $daughters,
                    'name' => $child->getElementValue('shop_transport_company_id'),
                    'quantity' => 0,
                    'count' => 0,
                );
            }

            $dataMaterials['data'][$company]['data'][$daughter]['data'][$material]['quantity'] += $quantity;
            $dataMaterials['data'][$company]['data'][$daughter]['data'][$material]['count'] ++;

            $dataMaterials['data'][$company]['data'][$daughter]['quantity'] += $quantity;
            $dataMaterials['data'][$company]['data'][$daughter]['count'] ++;

            $dataMaterials['data'][$company]['quantity'] += $quantity;
            $dataMaterials['data'][$company]['count'] ++;

            $dataMaterials['quantity'] += $quantity;
            $dataMaterials['count'] ++;

            $dataCompanies['data'][$company]['quantity'] += $quantity;
            $dataCompanies['data'][$company]['count'] ++;
        }
        uasort($dataCompanies['data'], array($this, 'mySortMethod'));
        uasort($dataMaterials['data'], array($this, 'mySortMethod'));

        $viewObject = 'ab1/_report/'.$this->_sitePageData->languageID.'/material/import-group-daughter';
        $tmp = str_replace('\\', '/', $viewObject);
        try {
            $view = View::factory($tmp);
        }catch (Exception $e) {
            throw new Exception('Шаблон "'.$tmp.'" не найден.');
        }

        $view->companies = $dataCompanies;
        $view->materials = $dataMaterials;
        $view->daughters = $dataDaughters;
        $view->operation = $this->_sitePageData->operation->getValues();
        $view->shop = $this->_sitePageData->shop->getName();
        $view->shopOptions = $this->_sitePageData->shop->getOptionsArray();
        $strView = Helpers_View::viewToStr($view);

        header('Content-Type: application/x-download;charset=UTF-8');
        // header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: filename="Отчет по завозу материалов.xml"');
        header('Cache-Control: max-age=0');

        echo $strView;
        exit();
    }

    /**
     * Отчет по покупке материалов
     * @throws Exception
     */
    public function action_material_buy_group_daughter() {
        set_time_limit(36000);

        $this->_sitePageData->url = '/'.$this->actionURLName.'/shopreport/material_buy_group_daughter';

        $shopMaterialIDs = NULL;

        $dateFrom = Request_RequestParams::getParamDateTime('created_at_from');
        $dateTo = Request_RequestParams::getParamDateTime('created_at_to');

        $params = Request_RequestParams::setParams(
            array(
                'is_exit' => 1,
                'shop_material_id' => $shopMaterialIDs,
                'shop_branch_receiver_id' => $this->_sitePageData->shopID,
                'shop_daughter_id_from' => 0,
                'date_document_from' => $dateFrom,
                'date_document_to' => $dateTo,
            ),
            FALSE
        );

        $ids = Request_Request::find('DB_Ab1_Shop_Car_To_Material',
            $this->_sitePageData->shopMainID, $this->_sitePageData, $this->_driverDB,
            $params,0, TRUE,
            array(
                'shop_transport_company_id' => array('name'),
                'shop_material_id' => array('name'),
                'shop_daughter_id' => array('name', 'daughter_weight_id')
            )
        );

        // список отправителей и список транспорных компаний
        $daughters = array();
        $companies = array();
        foreach ($ids->childs as $child){
            $daughterID = $child->values['shop_daughter_id'];

            if (!key_exists($daughterID, $daughters)){
                $daughters[$daughterID] = array(
                    'data' => array(),
                    'name' => $child->getElementValue('shop_daughter_id'),
                    'quantity' => 0,
                    'count' => 0,
                    'cars' => array(),
                );
            }

            $material = $child->values['shop_material_id'];
            if (! key_exists($material, $daughters[$daughterID]['data'])){
                $daughters[$daughterID]['data'][$material] = array(
                    'data' => array(),
                    'name' => $child->getElementValue('shop_material_id'),
                    'quantity' => 0,
                    'count' => 0,
                    'cars' => array(),
                );
            }

            $companyID = $child->values['shop_transport_company_id'];
            if (!key_exists($companyID, $companies)){
                $companies[$companyID] = array(
                    'data' => array(),
                    'name' => $child->getElementValue('shop_transport_company_id'),
                    'quantity' => 0,
                    'count' => 0,
                    'cars' => array(),
                );
            }
        }
        uasort($daughters, array($this, 'mySortMethod'));
        uasort($companies, array($this, 'mySortMethod'));

        $dataDaughters = array(
            'data' => $daughters,
            'quantity' => 0,
            'count' => 0,
            'cars' => array(),
        );
        $dataCompanies = array(
            'data' => $companies,
            'quantity' => 0,
            'count' => 0,
            'cars' => array(),
        );
        $dataMaterials = array(
            'data' => array(),
            'quantity' => 0,
            'count' => 0,
            'cars' => array(),
        );
        foreach ($ids->childs as $child){
            $number = $child->values['name'];
            $quantity = Api_Ab1_Shop_Car_To_Material::getQuantity($child);

            $daughter = $child->values['shop_daughter_id'];

            $dataDaughters['data'][$daughter]['quantity'] += $quantity;
            $dataDaughters['data'][$daughter]['count'] ++;
            $dataDaughters['data'][$daughter]['cars'][$number] = '';

            $material = $child->values['shop_material_id'];
            $dataDaughters['data'][$daughter]['data'][$material]['quantity'] += $quantity;
            $dataDaughters['data'][$daughter]['data'][$material]['count'] ++;
            $dataDaughters['data'][$daughter]['data'][$material]['cars'][$number] = '';

            $company = $child->values['shop_transport_company_id'];
            if (! key_exists($company, $dataMaterials['data'])){
                $dataMaterials['data'][$company] = array(
                    'data' => $daughters,
                    'name' => $child->getElementValue('shop_transport_company_id'),
                    'quantity' => 0,
                    'count' => 0,
                    'cars' => array(),
                );
            }

            $dataMaterials['data'][$company]['data'][$daughter]['data'][$material]['quantity'] += $quantity;
            $dataMaterials['data'][$company]['data'][$daughter]['data'][$material]['count'] ++;
            $dataMaterials['data'][$company]['data'][$daughter]['data'][$material]['cars'][$number] = '';

            $dataMaterials['data'][$company]['data'][$daughter]['quantity'] += $quantity;
            $dataMaterials['data'][$company]['data'][$daughter]['count'] ++;
            $dataMaterials['data'][$company]['data'][$daughter]['cars'][$number] = '';

            $dataMaterials['data'][$company]['quantity'] += $quantity;
            $dataMaterials['data'][$company]['count'] ++;
            $dataMaterials['data'][$company]['cars'][$number] = '';

            $dataMaterials['quantity'] += $quantity;
            $dataMaterials['count'] ++;
            $dataMaterials['cars'][$number] = '';

            $dataCompanies['data'][$company]['quantity'] += $quantity;
            $dataCompanies['data'][$company]['count'] ++;
            $dataCompanies['data'][$company]['cars'][$number] = '';
        }
        uasort($dataCompanies['data'], array($this, 'mySortMethod'));
        uasort($dataMaterials['data'], array($this, 'mySortMethod'));

        $viewObject = 'ab1/_report/'.$this->_sitePageData->languageID.'/material/buy-group-daughter';
        $tmp = str_replace('\\', '/', $viewObject);
        try {
            $view = View::factory($tmp);
        }catch (Exception $e) {
            throw new Exception('Шаблон "'.$tmp.'" не найден.');
        }

        $view->companies = $dataCompanies;
        $view->materials = $dataMaterials;
        $view->daughters = $dataDaughters;
        $view->operation = $this->_sitePageData->operation->getValues();
        $view->shop = $this->_sitePageData->shop->getName();
        $view->shopOptions = $this->_sitePageData->shop->getOptionsArray();
        $strView = Helpers_View::viewToStr($view);

        header('Content-Type: application/x-download;charset=UTF-8');
        // header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: filename="АБ10 Отгружено материалов по видам, дате, за период.xml"');
        header('Cache-Control: max-age=0');

        echo $strView;
        exit();
    }

    /**
     * Отчет по вывозу материалов
     * @throws Exception
     */
    public function action_material_export_group_daughter() {
        set_time_limit(36000);

        $this->_sitePageData->url = '/'.$this->actionURLName.'/shopreport/material_export_group_daughter';

        $shopMaterialIDs = NULL;

        $params = Request_RequestParams::setParams(
            array(
                'is_exit' => 1,
                'shop_material_id' => $shopMaterialIDs,
                'shop_branch_daughter_id' => $this->_sitePageData->shopID,
                'quantity_daughter_from' => 0,
                'shop_heap_receiver_id' => Request_RequestParams::getParamInt('shop_heap_receiver_id'),
                'shop_subdivision_receiver_id' => Request_RequestParams::getParamInt('shop_subdivision_receiver_id'),
            ),
            FALSE
        );

        $ids = Request_Request::find('DB_Ab1_Shop_Car_To_Material',
            $this->_sitePageData->shopMainID, $this->_sitePageData, $this->_driverDB,
            $params,0, TRUE,
            array(
                'shop_transport_company_id' => array('name'),
                'shop_material_id' => array('name'),
                'shop_branch_receiver_id' => array('name')
            )
        );

        // список отправителей и список транспорных компаний
        $daughters = array();
        $companies = array();
        foreach ($ids->childs as $child){
            $daughterID = $child->values['shop_branch_receiver_id'];

            if (!key_exists($daughterID, $daughters)){
                $daughters[$daughterID] = array(
                    'data' => array(),
                    'name' => $child->getElementValue('shop_branch_receiver_id'),
                    'quantity' => 0,
                    'count' => 0,
                    'cars' => array(),
                );
            }

            $material = $child->values['shop_material_id'];
            if (! key_exists($material, $daughters[$daughterID]['data'])){
                $daughters[$daughterID]['data'][$material] = array(
                    'data' => array(),
                    'name' => $child->getElementValue('shop_material_id'),
                    'quantity' => 0,
                    'count' => 0,
                    'cars' => array(),
                );
            }

            $companyID = $child->values['shop_transport_company_id'];
            if (!key_exists($companyID, $companies)){
                $companies[$companyID] = array(
                    'data' => array(),
                    'name' => $child->getElementValue('shop_transport_company_id'),
                    'quantity' => 0,
                    'count' => 0,
                    'cars' => array(),
                );
            }
        }
        uasort($daughters, array($this, 'mySortMethod'));
        uasort($companies, array($this, 'mySortMethod'));

        $dataDaughters = array(
            'data' => $daughters,
            'quantity' => 0,
            'count' => 0,
            'cars' => array(),
        );
        $dataCompanies = array(
            'data' => $companies,
            'quantity' => 0,
            'count' => 0,
            'cars' => array(),
        );
        $dataMaterials = array(
            'data' => array(),
            'quantity' => 0,
            'count' => 0,
            'cars' => array(),
        );
        foreach ($ids->childs as $child){
            $number = $child->values['name'];
            $quantity = $child->values['quantity_daughter'];
            $daughter = $child->values['shop_branch_receiver_id'];

            $dataDaughters['data'][$daughter]['quantity'] += $quantity;
            $dataDaughters['data'][$daughter]['count'] ++;
            $dataDaughters['data'][$daughter]['count'] ++;

            $material = $child->values['shop_material_id'];
            $dataDaughters['data'][$daughter]['data'][$material]['quantity'] += $quantity;
            $dataDaughters['data'][$daughter]['data'][$material]['count'] ++;
            $dataDaughters['data'][$daughter]['data'][$material]['cars'][$number] = '';

            $company = $child->values['shop_transport_company_id'];
            if (! key_exists($company, $dataMaterials['data'])){
                $dataMaterials['data'][$company] = array(
                    'data' => $daughters,
                    'name' => $child->getElementValue('shop_transport_company_id'),
                    'quantity' => 0,
                    'count' => 0,
                    'cars' => array(),
                );
            }

            $dataMaterials['data'][$company]['data'][$daughter]['data'][$material]['quantity'] += $quantity;
            $dataMaterials['data'][$company]['data'][$daughter]['data'][$material]['count'] ++;
            $dataMaterials['data'][$company]['data'][$daughter]['data'][$material]['cars'][$number] = '';

            $dataMaterials['data'][$company]['data'][$daughter]['quantity'] += $quantity;
            $dataMaterials['data'][$company]['data'][$daughter]['count'] ++;
            $dataMaterials['data'][$company]['data'][$daughter]['cars'][$number] = '';

            $dataMaterials['data'][$company]['quantity'] += $quantity;
            $dataMaterials['data'][$company]['count'] ++;
            $dataMaterials['data'][$company]['cars'][$number] = '';

            $dataMaterials['quantity'] += $quantity;
            $dataMaterials['count'] ++;
            $dataMaterials['cars'][$number] = '';

            $dataCompanies['data'][$company]['quantity'] += $quantity;
            $dataCompanies['data'][$company]['count'] ++;
            $dataCompanies['data'][$company]['cars'][$number] = '';
        }
        uasort($dataCompanies['data'], array($this, 'mySortMethod'));
        uasort($dataMaterials['data'], array($this, 'mySortMethod'));

        $viewObject = 'ab1/_report/'.$this->_sitePageData->languageID.'/material/export-group-daughter';
        $tmp = str_replace('\\', '/', $viewObject);
        try {
            $view = View::factory($tmp);
        }catch (Exception $e) {
            throw new Exception('Шаблон "'.$tmp.'" не найден.');
        }

        $view->companies = $dataCompanies;
        $view->materials = $dataMaterials;
        $view->daughters = $dataDaughters;
        $view->operation = $this->_sitePageData->operation->getValues();
        $view->shop = $this->_sitePageData->shop->getName();
        $view->shopOptions = $this->_sitePageData->shop->getOptionsArray();
        $strView = Helpers_View::viewToStr($view);

        header('Content-Type: application/x-download;charset=UTF-8');
        // header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: filename="ВС07 Отчет по вывозу материалов.xml"');
        header('Cache-Control: max-age=0');

        echo $strView;
        exit();
    }

    /**
     * Отчет по движению материала
     * @throws Exception
     */
    public function action_material_cars() {
        set_time_limit(36000);

        $this->_sitePageData->url = '/'.$this->actionURLName.'/shopreport/material_cars';

        $modelMaterial = new Model_Ab1_Shop_Material();
        $modelMaterial->setDBDriver($this->_driverDB);
        $shopMaterialID = Request_RequestParams::getParamInt('shop_material_id');
        if (!Helpers_DB::getDBObject($modelMaterial, $shopMaterialID, $this->_sitePageData, $this->_sitePageData->shopMainID)){
            throw new HTTP_Exception_404('Material not found.');
        }

        $dateFrom = Request_RequestParams::getParamDateTime('created_at_from');
        $dateTo = Request_RequestParams::getParamDateTime('created_at_to');

        $params = Request_RequestParams::setParams(
            array(
                'is_exit' => 1,
                'shop_material_id' => $shopMaterialID,
                'date_document_from' => $dateFrom,
                'date_document_to' => $dateTo,
            ),
            FALSE
        );
        $ids = Request_Request::find('DB_Ab1_Shop_Car_To_Material',
            $this->_sitePageData->shopMainID, $this->_sitePageData, $this->_driverDB,
            $params,0, TRUE,
            array(
                'shop_branch_receiver_id' => array('name'),
                'shop_branch_daughter_id' => array('name'),
                'shop_daughter_id' => array('name'),
                'shop_heap_receiver_id' => array('name'),
                'shop_heap_daughter_id' => array('name'),
                'shop_subdivision_receiver_id' => array('name'),
                'shop_subdivision_daughter_id' => array('name'),
            )
        );

        $quantity = 0;
        $dataMaterials = array();
        foreach ($ids->childs as $child){
            $dataMaterials[] = array(
                'created_at' => $child->values['created_at'],
                'update_tare_at' => $child->values['update_tare_at'],
                'daughter' => $child->getElementValue('shop_branch_daughter_id', 'name', $child->getElementValue('shop_daughter_id')),
                'heap_daughter' => $child->getElementValue('shop_heap_daughter_id'),
                'subdivision_daughter' => $child->getElementValue('shop_subdivision_daughter_id'),
                'receiver' => $child->getElementValue('shop_branch_receiver_id'),
                'heap_receiver' => $child->getElementValue('shop_heap_receiver_id'),
                'subdivision_receiver' => $child->getElementValue('shop_subdivision_receiver_id'),
                'name' => $child->values['name'],
                'quantity' => $child->values['quantity'],
            );

            $quantity += $child->values['quantity'];
        }

        $viewObject = 'ab1/_report/'.$this->_sitePageData->languageID.'/material/cars';
        $tmp = str_replace('\\', '/', $viewObject);
        try {
            $view = View::factory($tmp);
        }catch (Exception $e) {
            throw new Exception('Шаблон "'.$tmp.'" не найден.');
        }

        $view->material = $modelMaterial->getValues();
        $view->materials = $dataMaterials;
        $view->quantity = $quantity;
        $view->operation = $this->_sitePageData->operation->getValues();
        $view->shop = $this->_sitePageData->shop->getName();
        $view->shopOptions = $this->_sitePageData->shop->getOptionsArray();
        $strView = Helpers_View::viewToStr($view);

        header('Content-Type: application/x-download;charset=UTF-8');
        // header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: filename="АБ09 Отчет по движению материала.xml"');
        header('Cache-Control: max-age=0');

        echo $strView;
        exit();
    }

    /**
     * Список вагонов в заданный период убытия и клиента
     * @throws Exception
     */
    public function action_boxcar_list() {
        set_time_limit(36000);

        $this->_sitePageData->url = '/'.$this->actionURLName.'/shopreport/boxcar_list';

        $shopMaterialIDs = NULL;

        // задаем время выборки
        $dateFrom = Request_RequestParams::getParamDateTime('date_departure_from');
        $dateTo = Request_RequestParams::getParamDateTime('date_departure_to');
        $shopBoxcarClientID = Request_RequestParams::getParamInt('shop_boxcar_client_id');

        $params = Request_RequestParams::setParams(
            array(
               // 'is_exit' => 1,
                'shop_boxcar_client_id' => $shopBoxcarClientID,
                'date_departure_from' => $dateFrom,
                'date_departure_to' => $dateTo,
                'sort_by' => array('created_at' => 'asc'),
            )
        );
        $ids = Request_Request::find('DB_Ab1_Shop_Boxcar',
            $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB,
            $params, 0, TRUE,
            array('shop_boxcar_train_id' => array('date_shipment'))
        );

        $dataBoxcars = array(
            'data' => array(),
            'quantity' => 0,
        );
        foreach ($ids->childs as $child){
            $quantity = $child->values['quantity'];
            $dateTimeShipment = $child->getElementValue('shop_boxcar_train_id', 'date_shipment');

            // группируем по дням отгрузки
            $dateShipment = Helpers_DateTime::getDateFormatPHP($dateTimeShipment);
            if (! key_exists($dateShipment, $dataBoxcars['data'])){
                $dataBoxcars['data'][$dateShipment] = array(
                    'data' => array(),
                    'name' => $dateShipment,
                    'quantity' => 0,
                );
            }

            $dataBoxcars['data'][$dateShipment]['data'][] = array(
                'date_shipment' => $child->getElementValue('shop_boxcar_train_id', 'date_shipment'),
                'date_arrival' => $child->values['date_arrival'],
                'number' => $child->values['number'],
                'date_drain_from' => $child->values['date_drain_from'],
                'date_drain_to' => $child->values['date_drain_to'],
                'date_departure' => $child->values['date_departure'],
                'stamp' => $child->values['stamp'],
                'quantity' => $quantity,
            );

            $dataBoxcars['data'][$dateShipment]['quantity'] += $quantity;
            $dataBoxcars['quantity'] += $quantity;
        }
        uasort($dataBoxcars['data'], array($this, 'mySortMethod'));

        $client = array();
        if($shopBoxcarClientID > 0){
            $model = new Model_Ab1_Shop_Client();
            $model->setDBDriver($this->_driverDB);
            if(Helpers_DB::getDBObject($model, $shopBoxcarClientID, $this->_sitePageData)){
                $client = $model->getValues(TRUE, TRUE);
            }
        }

        $viewObject = 'ab1/_report/'.$this->_sitePageData->languageID.'/boxcar/list';
        $tmp = str_replace('\\', '/', $viewObject);
        try {
            $view = View::factory($tmp);
        }catch (Exception $e) {
            throw new Exception('Шаблон "'.$tmp.'" не найден.');
        }

        $view->boxcars = $dataBoxcars;
        $view->dateFrom = $dateFrom;
        $view->dateTo = $dateTo;
        $view->client = $client;
        $view->operation = $this->_sitePageData->operation->getValues();
        $view->shop = $this->_sitePageData->shop->getName();
        $view->shopOptions = $this->_sitePageData->shop->getOptionsArray();
        $strView = Helpers_View::viewToStr($view);

        header('Content-Type: application/x-download;charset=UTF-8');
        // header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: filename="ВГ07 Разгруженные вагоны.xml"');
        header('Cache-Control: max-age=0');

        echo $strView;
        exit();
    }

    /**
     * Автоуслуги по материалам сгруппированный по дням завоз и/или вывоз
     * @throws Exception
     */
    public function action_material_days() {
        set_time_limit(36000);

        $this->_sitePageData->url = '/'.$this->actionURLName.'/shopreport/material_days';

        $shopMaterialIDs = NULL;

        // задаем время выборки
        $dateFrom = Request_RequestParams::getParamDateTime('created_at_from');
        $dateTo = Request_RequestParams::getParamDateTime('created_at_to');

        $rubric = Request_RequestParams::getParamInt('shop_material_rubric_id');
        $receiver = Request_RequestParams::getParamInt('shop_heap_receiver_id');
        $subdivision = Request_RequestParams::getParamInt('shop_subdivision_receiver_id');

        $params = array(
            'is_exit' => 1,
            'shop_material_id' => $shopMaterialIDs,
            'shop_material_rubric_id' => $rubric,
            'shop_heap_receiver_id' => $receiver,
            'shop_subdivision_receiver_id' => $subdivision,
            'sort_by' => array('created_at' => 'asc'),
        );

        // определяем завоз или вывоз надо считывать
        $isImport = Request_RequestParams::getParamBoolean('is_import');
        $isExport = Request_RequestParams::getParamBoolean('is_export');
        if($isImport && (!$isExport)){
            $params['shop_branch_receiver_id'] = $this->_sitePageData->shopID;

            $params['receiver_created_at_from'] = $dateFrom;
            $params['receiver_created_at_to'] = $dateTo;
        }elseif((!$isImport) && $isExport){
            $params['shop_branch_daughter_id'] = $this->_sitePageData->shopID;

            $params['created_at_from'] = $dateFrom;
            $params['created_at_to'] = $dateTo;
        }else{
            $params['main_shop_id'] = $this->_sitePageData->shopID;

            $params['receiver_created_at_from'] = $dateFrom;
            $params['receiver_created_at_to'] = $dateTo;
        }


        $params = Request_RequestParams::setParams(
            $params
        );
        $ids = Request_Request::find('DB_Ab1_Shop_Car_To_Material',
            $this->_sitePageData->shopMainID, $this->_sitePageData, $this->_driverDB,
            $params, 0, TRUE,
            array(
                'shop_transport_company_id' => array('name'),
                'shop_material_id' => array('name'),
                'shop_daughter_id' => array('name', 'daughter_weight_id'),
                'shop_branch_daughter_id' => array('name')
            )
        );

        // список отправителей и список транспорных компаний
        $daughters = array();
        $companies = array();
        foreach ($ids->childs as $child){
            $daughterID = $child->values['shop_daughter_id'];
            if($daughterID > 0){
                $daughterID = 'd_'.$daughterID;
            }else{
                $daughterID = 'b_'.$child->values['shop_branch_daughter_id'];
            }

            if (!key_exists($daughterID, $daughters)){
                $daughters[$daughterID] = array(
                    'data' => array(),
                    'name' => $child->getElementValue('shop_daughter_id', 'name', $child->getElementValue('shop_branch_daughter_id')),
                    'quantity' => 0,
                    'count' => 0,
                    'auto_count' => array(),
                );
            }

            $material = $child->values['shop_material_id'];
            if (! key_exists($material, $daughters[$daughterID]['data'])){
                $daughters[$daughterID]['data'][$material] = array(
                    'data' => array(),
                    'name' => $child->getElementValue('shop_material_id'),
                    'quantity' => 0,
                    'count' => 0,
                    'auto_count' => array(),
                );
            }

            $companyID = $child->values['shop_transport_company_id'];
            if (!key_exists($companyID, $companies)){
                $companies[$companyID] = array(
                    'data' => array(),
                    'name' => $child->getElementValue('shop_transport_company_id'),
                    'quantity' => 0,
                    'count' => 0,
                    'auto_count' => array(),
                );
            }
        }
        uasort($daughters, array($this, 'mySortMethod'));
        uasort($companies, array($this, 'mySortMethod'));

        $dataDaughters = array(
            'data' => $daughters,
            'quantity' => 0,
            'count' => 0,
            'auto_count' => array(),
        );
        $dataCompanies = array(
            'data' => $companies,
            'quantity' => 0,
            'count' => 0,
            'auto_count' => array(),
        );
        $dataMaterials = array(
            'data' => array(),
            'quantity' => 0,
            'count' => 0,
            'auto_count' => array(),
        );
        foreach ($ids->childs as $child){
            if($isImport) {
                $quantity = Api_Ab1_Shop_Car_To_Material::getQuantity($child);
            }elseif($isExport) {
                $quantity = $child->values['quantity_daughter'];
            }else{
                $quantity = $child->values['quantity'];
            }

            $daughter = $child->values['shop_daughter_id'];
            if($daughter > 0){
                $daughter = 'd_'.$daughter;
            }else{
                $daughter = 'b_'.$child->values['shop_branch_daughter_id'];
            }

            $material = $child->values['shop_material_id'];
            $company = $child->values['shop_transport_company_id'];
            $auto = $child->values['name'];

            // группируем по поставщикам
            $dataDaughters['data'][$daughter]['quantity'] += $quantity;
            $dataDaughters['data'][$daughter]['count'] ++;
            $dataDaughters['data'][$daughter]['auto_count'][$auto] = '';

            $dataDaughters['data'][$daughter]['data'][$material]['quantity'] += $quantity;
            $dataDaughters['data'][$daughter]['data'][$material]['count'] ++;
            $dataDaughters['data'][$daughter]['data'][$material]['auto_count'][$auto] = '';

            // группируем по грузоперевозчикам
            if (! key_exists($company, $dataMaterials['data'])){
                $dataMaterials['data'][$company] = array(
                    'data' => array(),
                    'name' => $child->getElementValue('shop_transport_company_id'),
                    'quantity' => 0,
                    'count' => 0,
                    'auto_count' => array(),
                    'daughters' => $daughters,
                );
            }

            $dataMaterials['data'][$company]['daughters'][$daughter]['data'][$material]['quantity'] += $quantity;
            $dataMaterials['data'][$company]['daughters'][$daughter]['data'][$material]['count'] ++;
            $dataMaterials['data'][$company]['daughters'][$daughter]['data'][$material]['auto_count'][$auto] = '';

            $dataMaterials['data'][$company]['daughters'][$daughter]['quantity'] += $quantity;
            $dataMaterials['data'][$company]['daughters'][$daughter]['count'] ++;
            $dataMaterials['data'][$company]['daughters'][$daughter]['auto_count'][$auto] = '';

            // группируем по дате
            $date = Helpers_DateTime::getDateFormatPHP($child->values['created_at']);
            if (strtotime($child->values['created_at']) < strtotime($date.' 06:00:00')){
                $date = Helpers_DateTime::minusDays($date, 1);
            }

            if (! key_exists($date, $dataMaterials['data'][$company]['data'])){
                $dataMaterials['data'][$company]['data'][$date] = array(
                    'data' => $daughters,
                    'name' => $date,
                    'quantity' => 0,
                    'count' => 0,
                    'auto_count' => array(),
                );
            }

            $dataMaterials['data'][$company]['data'][$date]['data'][$daughter]['data'][$material]['quantity'] += $quantity;
            $dataMaterials['data'][$company]['data'][$date]['data'][$daughter]['data'][$material]['count'] ++;
            $dataMaterials['data'][$company]['data'][$date]['data'][$daughter]['data'][$material]['auto_count'][$auto] = '';

            $dataMaterials['data'][$company]['data'][$date]['data'][$daughter]['quantity'] += $quantity;
            $dataMaterials['data'][$company]['data'][$date]['data'][$daughter]['count'] ++;
            $dataMaterials['data'][$company]['data'][$date]['data'][$daughter]['auto_count'][$auto] = '';

            $dataMaterials['data'][$company]['data'][$date]['quantity'] += $quantity;
            $dataMaterials['data'][$company]['data'][$date]['count'] ++;
            $dataMaterials['data'][$company]['data'][$date]['auto_count'][$auto] = '';

            $dataMaterials['data'][$company]['quantity'] += $quantity;
            $dataMaterials['data'][$company]['count'] ++;
            $dataMaterials['data'][$company]['auto_count'][$auto] = '';

            $dataMaterials['quantity'] += $quantity;
            $dataMaterials['count'] ++;
            $dataMaterials['auto_count'][$auto] = '';

            $dataCompanies['data'][$company]['quantity'] += $quantity;
            $dataCompanies['data'][$company]['count'] ++;
            $dataCompanies['data'][$company]['auto_count'][$auto] = '';
        }
        uasort($dataCompanies['data'], array($this, 'mySortMethod'));
        uasort($dataMaterials['data'], array($this, 'mySortMethod'));

        $viewObject = 'ab1/_report/'.$this->_sitePageData->languageID.'/material/days';
        $tmp = str_replace('\\', '/', $viewObject);
        try {
            $view = View::factory($tmp);
        }catch (Exception $e) {
            throw new Exception('Шаблон "'.$tmp.'" не найден.');
        }

        $view->companies = $dataCompanies;
        $view->materials = $dataMaterials;
        $view->daughters = $dataDaughters;
        $view->dateFrom = $dateFrom;
        $view->dateTo = $dateTo;
        $view->operation = $this->_sitePageData->operation->getValues();
        $view->shop = $this->_sitePageData->shop->getName();
        $view->shopOptions = $this->_sitePageData->shop->getOptionsArray();
        $strView = Helpers_View::viewToStr($view);

        header('Content-Type: application/x-download;charset=UTF-8');
        // header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: filename="АБ03 Автоуслуги завоза материала по дням.xml"');
        header('Cache-Control: max-age=0');

        echo $strView;
        exit();
    }

    /**
     * Завоз материалов за день сгруппированный по сменам
     * Смена 1 (07:00-19:00)
     * Смена 2 (19:00-07:00)
     * @throws Exception
     */
    public function action_material_day_group_work_shift() {
        set_time_limit(36000);

        $this->_sitePageData->url = '/'.$this->actionURLName.'/shopreport/material_day_group_work_shift';

        $shopMaterialIDs = NULL;

        $date = Request_RequestParams::getParamDateTime('date');
        if($date === NULL){
            $date = date('Y-m-d');
        }

        // задаем время выборки
        $dateFrom = Helpers_DateTime::getDateFormatPHP($date);
        $toWorkShift = strtotime(Helpers_DateTime::plusHours($dateFrom, 19));
        $dateTo = Helpers_DateTime::plusHours($dateFrom, 31);
        $dateFrom = Helpers_DateTime::plusHours($dateFrom, 7);

        $params = Request_RequestParams::setParams(
            array(
                'is_exit' => 1,
                'shop_material_id' => $shopMaterialIDs,
                'date_document_from' => $dateFrom,
                'date_document_to' => $dateTo,
                'shop_branch_receiver_id' => $this->_sitePageData->shopID,
            )
        );
        $ids = Request_Request::find('DB_Ab1_Shop_Car_To_Material',
            $this->_sitePageData->shopMainID, $this->_sitePageData, $this->_driverDB,
            $params, 0, TRUE,
            array(
                'shop_transport_company_id' => array('name'),
                'shop_material_id' => array('name'),
                'shop_daughter_id' => array('name', 'daughter_weight_id'),
                'shop_branch_daughter_id' => array('name')
            )
        );

        // список отправителей и список транспорных компаний
        $daughters = array();
        $companies = array();
        foreach ($ids->childs as $child){
            $daughterID = $child->values['shop_daughter_id'];
            if($daughterID > 0){
                $daughterID = 'd_'.$daughterID;
            }else{
                $daughterID = 'b_'.$child->values['shop_branch_daughter_id'];
            }

            if (!key_exists($daughterID, $daughters)){
                $daughters[$daughterID] = array(
                    'data' => array(),
                    'name' => $child->getElementValue('shop_daughter_id', 'name', $child->getElementValue('shop_branch_daughter_id')),
                    'quantity' => 0,
                    'count' => 0,
                    'auto_count' => array(),
                );
            }

            $material = $child->values['shop_material_id'];
            if (! key_exists($material, $daughters[$daughterID]['data'])){
                $daughters[$daughterID]['data'][$material] = array(
                    'data' => array(),
                    'name' => $child->getElementValue('shop_material_id'),
                    'quantity' => 0,
                    'count' => 0,
                    'auto_count' => array(),
                );
            }

            $companyID = $child->values['shop_transport_company_id'];
            if (!key_exists($companyID, $companies)){
                $companies[$companyID] = array(
                    'data' => array(),
                    'name' => $child->getElementValue('shop_transport_company_id'),
                    'quantity' => 0,
                    'count' => 0,
                    'auto_count' => array(),
                );
            }
        }
        uasort($daughters, array($this, 'mySortMethod'));
        uasort($companies, array($this, 'mySortMethod'));

        $dataDaughters = array(
            'data' => $daughters,
            'quantity' => 0,
            'count' => 0,
            'auto_count' => array(),
        );
        $dataCompanies = array(
            'data' => $companies,
            'quantity' => 0,
            'count' => 0,
            'auto_count' => array(),
        );
        $dataMaterials = array(
            'data' => array(),
            'quantity' => 0,
            'count' => 0,
            'auto_count' => array(),
        );
        foreach ($ids->childs as $child){
            $daughter = $child->values['shop_daughter_id'];
            if($daughter > 0){
                $daughter = 'd_'.$daughter;
            }else{
                $daughter = 'b_'.$child->values['shop_branch_daughter_id'];
            }

            $quantity = Api_Ab1_Shop_Car_To_Material::getQuantity($child);

            $material = $child->values['shop_material_id'];
            $company = $child->values['shop_transport_company_id'];
            $auto = $child->values['name'];

            // группируем по смене
            if (strtotime($child->values['quantity']) > $toWorkShift){
                $workShift = 2;
            }else{
                $workShift = 1;
            }

            if (! key_exists($workShift, $dataMaterials['data'])){
                $dataMaterials['data'][$workShift] = array(
                    'data' => array(),
                    'name' => $workShift.' смена',
                    'quantity' => 0,
                    'count' => 0,
                    'auto_count' => array(),
                    'daughters' => $daughters,
                );
            }

            $dataMaterials['data'][$workShift]['daughters'][$daughter]['data'][$material]['quantity'] += $quantity;
            $dataMaterials['data'][$workShift]['daughters'][$daughter]['data'][$material]['count'] ++;
            $dataMaterials['data'][$workShift]['daughters'][$daughter]['data'][$material]['auto_count'][$auto] = '';

            $dataMaterials['data'][$workShift]['daughters'][$daughter]['quantity'] += $quantity;
            $dataMaterials['data'][$workShift]['daughters'][$daughter]['count'] ++;
            $dataMaterials['data'][$workShift]['daughters'][$daughter]['auto_count'][$auto] = '';

            // группируем по поставщикам
            $dataDaughters['data'][$daughter]['quantity'] += $quantity;
            $dataDaughters['data'][$daughter]['count'] ++;
            $dataDaughters['data'][$daughter]['auto_count'][$auto] = '';


            $dataDaughters['data'][$daughter]['data'][$material]['quantity'] += $quantity;
            $dataDaughters['data'][$daughter]['data'][$material]['count'] ++;
            $dataDaughters['data'][$daughter]['data'][$material]['auto_count'][$auto] = '';

            if (! key_exists($company, $dataMaterials['data'][$workShift]['data'])){
                $dataMaterials['data'][$workShift]['data'][$company] = array(
                    'data' => $daughters,
                    'name' => $child->getElementValue('shop_transport_company_id'),
                    'quantity' => 0,
                    'count' => 0,
                    'auto_count' => array(),
                );
            }

            $dataMaterials['data'][$workShift]['data'][$company]['data'][$daughter]['data'][$material]['quantity'] += $quantity;
            $dataMaterials['data'][$workShift]['data'][$company]['data'][$daughter]['data'][$material]['count'] ++;
            $dataMaterials['data'][$workShift]['data'][$company]['data'][$daughter]['data'][$material]['auto_count'][$auto] = '';

            $dataMaterials['data'][$workShift]['data'][$company]['data'][$daughter]['quantity'] += $quantity;
            $dataMaterials['data'][$workShift]['data'][$company]['data'][$daughter]['count'] ++;
            $dataMaterials['data'][$workShift]['data'][$company]['data'][$daughter]['auto_count'][$auto] = '';

            $dataMaterials['data'][$workShift]['data'][$company]['quantity'] += $quantity;
            $dataMaterials['data'][$workShift]['data'][$company]['count'] ++;
            $dataMaterials['data'][$workShift]['data'][$company]['auto_count'][$auto] = '';

            $dataMaterials['data'][$workShift]['quantity'] += $quantity;
            $dataMaterials['data'][$workShift]['count'] ++;
            $dataMaterials['data'][$workShift]['auto_count'][$auto] = '';

            $dataMaterials['quantity'] += $quantity;
            $dataMaterials['count'] ++;
            $dataMaterials['auto_count'][$auto] = '';

            $dataCompanies['data'][$company]['quantity'] += $quantity;
            $dataCompanies['data'][$company]['count'] ++;
            $dataCompanies['data'][$company]['auto_count'][$auto] = '';
        }
        uasort($dataCompanies['data'], array($this, 'mySortMethod'));
        uasort($dataMaterials['data'], array($this, 'mySortMethod'));

        $viewObject = 'ab1/_report/'.$this->_sitePageData->languageID.'/material/day-group-work-shift';
        $tmp = str_replace('\\', '/', $viewObject);
        try {
            $view = View::factory($tmp);
        }catch (Exception $e) {
            throw new Exception('Шаблон "'.$tmp.'" не найден.');
        }

        $view->companies = $dataCompanies;
        $view->materials = $dataMaterials;
        $view->daughters = $dataDaughters;
        $view->dateFrom = $dateFrom;
        $view->dateTo = $dateTo;
        $view->operation = $this->_sitePageData->operation->getValues();
        $view->shop = $this->_sitePageData->shop->getName();
        $view->shopOptions = $this->_sitePageData->shop->getOptionsArray();
        $strView = Helpers_View::viewToStr($view);

        header('Content-Type: application/x-download;charset=UTF-8');
        // header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: filename="ВС09 Сводка по завозу материалов по сменам.xml"');
        header('Cache-Control: max-age=0');

        echo $strView;
        exit();
    }

    /**
     * Период работы диспетчеров по созданию заявок вместо Малого сбыта
     */
    public function action_work_time_weighted() {
        set_time_limit(36000);

        $this->_sitePageData->url = '/'.$this->actionURLName.'/shopreport/work_time_weighted';

        $params = Request_RequestParams::setParams(
            array(
                'is_exit' => 1,
                'sort_by' => array(
                    'id' => 'asc',
                )
            ),
            FALSE
        );
        $ids = Request_Request::find('DB_Ab1_Shop_Car', $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB,
            $params, 0, TRUE, array('cash_operation_id' => array('name', 'shop_table_rubric_id')));

        $dataDates = array(
            'data' => array(),
        );
        $indexPeriod = 0;
        foreach ($ids->childs as $child){
            $from = Helpers_DateTime::getDateFormatRus($child->values['created_at']);

            $rubricOperation = $child->getElementValue('cash_operation_id', 'shop_table_rubric_id');
            if ($rubricOperation != Model_Ab1_Shop_Operation::RUBRIC_WEIGHT){
                if(key_exists($from, $dataDates['data'])){
                    $indexPeriod++;
                }
                continue;
            }

            $fromD = strtotime($child->values['created_at']);

            $toFirst = $to = $child->values['exit_at'];
            $toDFirst = $toD = strtotime($child->values['exit_at']);

            // если выезд был на следующий день
            $toDay = Helpers_DateTime::getDateFormatRus($to);
            if($from != $toDay){
                // группа день
                if(!key_exists($toDay, $dataDates['data'])){
                    $dataDates['data'][$toDay] = array(
                        'from' => Helpers_DateTime::getDateFormatPHP($toDay),
                        'from_d' => strtotime($toDay),
                        'to' => $toFirst,
                        'to_d' => $toDFirst,
                        'data' => array(),
                    );
                }elseif($dataDates['data'][$toDay]['to_d'] < $toD){
                    $dataDates['data'][$toDay]['to'] = $to;
                    $dataDates['data'][$toDay]['to_d'] = $toD;
                }

                $to =  Helpers_DateTime::getDateFormatPHP($toDay);
                $toD = strtotime($toDay);
            }

            // группа день
            if(!key_exists($from, $dataDates['data'])){
                $dataDates['data'][$from] = array(
                    'from' => $child->values['created_at'],
                    'from_d' => $fromD,
                    'to' => $to,
                    'to_d' => $toD,
                    'data' => array(),
                );
            }elseif($dataDates['data'][$from]['to_d'] < $toD){
                $dataDates['data'][$from]['to'] = $to;
                $dataDates['data'][$from]['to_d'] = $toD;
            }

            /** группа диапозон **/

            // если выезд был на следующий день
            if($from != $toDay){
                // группа день
                if(!key_exists($indexPeriod, $dataDates['data'][$toDay]['data'])){
                    $dataDates['data'][$toDay]['data'][$indexPeriod] = array(
                        'from' => Helpers_DateTime::getDateFormatPHP($toDay),
                        'from_d' => strtotime($toDay),
                        'to' => $toFirst,
                        'to_d' => $toDFirst,
                        'data' => array(),
                    );
                }elseif($dataDates['data'][$toDay]['data'][$indexPeriod]['to_d'] < $toD){
                    $dataDates['data'][$toDay]['data'][$indexPeriod]['to'] = $to;
                    $dataDates['data'][$toDay]['data'][$indexPeriod]['to_d'] = $toD;
                }

                $to =  Helpers_DateTime::getDateFormatPHP($toDay);
                $toD = strtotime($toDay);
            }

            if(!key_exists($indexPeriod, $dataDates['data'][$from]['data'])){
                $dataDates['data'][$from]['data'][$indexPeriod] = array(
                    'from' => $child->values['created_at'],
                    'from_d' => $fromD,
                    'to' => $to,
                    'to_d' => $toD,
                    'data' => array(),
                );
            }elseif($dataDates['data'][$from]['data'][$indexPeriod]['to_d'] < $toD){
                $dataDates['data'][$from]['data'][$indexPeriod]['to'] = $to;
                $dataDates['data'][$from]['data'][$indexPeriod]['to_d'] = $toD;
            }

            /** группа оператор **/
            $shopOperationID = $child->values['cash_operation_id'];

            // если выезд был на следующий день
            if($from != $toDay){
                // группа день
                if(!key_exists($shopOperationID, $dataDates['data'][$toDay]['data'][$indexPeriod]['data'])){
                    $dataDates['data'][$toDay]['data'][$indexPeriod]['data'][$shopOperationID] = array(
                        'from' => Helpers_DateTime::getDateFormatPHP($toDay),
                        'from_d' => strtotime($toDay),
                        'to' => $toFirst,
                        'to_d' => $toDFirst,
                        'name' => $child->getElementValue('cash_operation_id', 'name'),
                    );
                }elseif($dataDates['data'][$toDay]['data'][$indexPeriod]['data'][$shopOperationID]['to_d'] < $toD){
                    $dataDates['data'][$toDay]['data'][$indexPeriod]['data'][$shopOperationID]['to'] = $to;
                    $dataDates['data'][$toDay]['data'][$indexPeriod]['data'][$shopOperationID]['to_d'] = $toD;
                }

                $to =  Helpers_DateTime::getDateFormatPHP($toDay);
                $toD = strtotime($toDay);
            }

            if(!key_exists($shopOperationID, $dataDates['data'][$from]['data'][$indexPeriod]['data'])){
                $dataDates['data'][$from]['data'][$indexPeriod]['data'][$shopOperationID] = array(
                    'from' => $child->values['created_at'],
                    'from_d' => $fromD,
                    'to' => $to,
                    'to_d' => $toD,
                    'name' => $child->getElementValue('cash_operation_id', 'name'),
                );
            }elseif($dataDates['data'][$from]['data'][$indexPeriod]['data'][$shopOperationID]['to_d'] < $toD){
                $dataDates['data'][$from]['data'][$indexPeriod]['data'][$shopOperationID]['to'] = $to;
                $dataDates['data'][$from]['data'][$indexPeriod]['data'][$shopOperationID]['to_d'] = $toD;
            }
        }

        // пересчитываем диапозоны, перехода между днями, если этот диапозон меньше 2 часов, то соединяем их
        $from = NULL;
        $fromPeriod = NULL;
        $fromOperation = NULL;
        foreach ($dataDates['data'] as &$dataDate){
            if(($from !== NULL)
                && ($dataDate['from_d'] - $from['to_d'] < 4 * 60 * 60)
                && (Helpers_DateTime::getDateFormatPHP($dataDate['from']) != Helpers_DateTime::getDateFormatPHP($from['to']))){
                $from['to'] = Helpers_DateTime::getDateFormatPHP($dataDate['from']);
                $dataDate['from'] = $from['to'];
            }
            $from = &$dataDate;

            foreach ($dataDate['data'] as &$dataPeriod){
                if(($fromPeriod !== NULL)
                    && ($dataPeriod['from_d'] - $fromPeriod['to_d'] < 4 * 60 * 60)
                    && (Helpers_DateTime::getDateFormatPHP($dataPeriod['from']) != Helpers_DateTime::getDateFormatPHP($fromPeriod['to']))
                    && (Helpers_DateTime::getDateFormatPHP($dataPeriod['from']) != Helpers_DateTime::getDateFormatPHP($fromPeriod['to']))
                ){
                    $fromPeriod['to'] = Helpers_DateTime::getDateFormatPHP($dataPeriod['from']);
                    $dataPeriod['from'] = $fromPeriod['to'];
                }
                $fromPeriod = &$dataPeriod;

                uasort($dataPeriod['data'], array($this, 'mySortMethod'));

                foreach ($dataPeriod['data'] as &$dataOperation){
                    if(($fromOperation !== NULL)
                        && ($dataOperation['name'] == $fromOperation['name'])
                        && ($dataOperation['from_d'] - $fromOperation['to_d'] < 4 * 60 * 60)
                        && (Helpers_DateTime::getDateFormatPHP($dataOperation['from']) != Helpers_DateTime::getDateFormatPHP($fromOperation['to']))){
                        $fromOperation['to'] = Helpers_DateTime::getDateFormatPHP($dataOperation['from']);
                        $dataOperation['from'] = $fromOperation['to'];
                    }
                    $fromOperation = &$dataOperation;
                }
            }
        }

        // делаем итоговые данные по операторам
        $dataOperations = array(
            'total' => 0,
            'data' => array(),
        );
        foreach ($dataDates['data'] as &$dataDate){
            foreach ($dataDate['data'] as &$dataPeriod){
               foreach ($dataPeriod['data'] as &$dataOperation){
                    $diff = Helpers_DateTime::diffHours($dataOperation['to'], $dataOperation['from']);
                    $dataOperations['total'] += $diff;

                    $name = $dataOperation['name'];
                    if(!key_exists($name, $dataOperations['data'])){
                        $dataOperations['data'][$name] = array(
                            'name' => $name,
                            'total' => 0,
                        );
                    }

                    $dataOperations['data'][$name]['total'] += $diff;
                }
            }
        }

        uasort($dataOperations['data'], array($this, 'mySortMethod'));

        $viewObject = 'ab1/_report/'.$this->_sitePageData->languageID.'/work_time_weighted';
        $tmp = str_replace('\\', '/', $viewObject);
        try {
            $view = View::factory($tmp);
        }catch (Exception $e) {
            throw new Exception('Шаблон "'.$tmp.'" не найден.');
        }

        $view->dates = $dataDates;
        $view->operations = $dataOperations;
        $view->operation = $this->_sitePageData->operation->getValues();
        $view->shop = $this->_sitePageData->shop->getName();
        $view->shopOptions = $this->_sitePageData->shop->getOptionsArray();
        $strView = Helpers_View::viewToStr($view);

        header('Content-Type: application/x-download;charset=UTF-8');
        // header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: filename="АБ07 Время работы операторов Весовой.xml"');
        header('Cache-Control: max-age=0');

        echo $strView;
        exit();
    }

    /**
     * АБ01 Выпуск продукции по дням
     * @throws Exception
     * @throws HTTP_Exception_404
     */
    public function action_realization_by_days() {
        set_time_limit(36000);

        $this->_sitePageData->url = '/'.$this->actionURLName.'/shopreport/realization_by_days';

        $shopTurnPlaceID = Request_RequestParams::getParamInt('shop_turn_place_id');

        /** Получаем рубрику, которая выбрана */
        $shopProductRubricID = Request_RequestParams::getParamInt('shop_product_rubric_id');
        $modelRubric = new Model_Ab1_Shop_Product_Rubric();
        $modelRubric->setDBDriver($this->_driverDB);
        if (!Helpers_DB::getDBObject($modelRubric, $shopProductRubricID, $this->_sitePageData, $this->_sitePageData->shopMainID)) {
            throw new HTTP_Exception_404('Rubric not found.');
        }

        // подразделения оператора
        $isSubdivision = Request_RequestParams::getParamBoolean('is_subdivision');
        $shopSubdivisionIDs = Request_RequestParams::getParamInt('shop_subdivision_id');
        if($isSubdivision) {
            if (empty($shopSubdivisionIDs)) {
                $shopSubdivisionIDs = $this->_sitePageData->operation->getProductShopSubdivisionIDsArray();
            }
        }

        // считываем детвору
        $params = Request_RequestParams::setParams(
            array(
                'root_id' => $shopProductRubricID,
                'is_public_ignore' => true,
                'is_delete_ignore' => true,
                'sort_by' => array('name' => 'asc'),
            )
        );
        $shopProductRubricIDs = Request_Request::find('DB_Ab1_Shop_Product_Rubric',
            $this->_sitePageData->shopMainID, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE
        );

        $rubricIDs = $shopProductRubricIDs->getChildArrayID();
        $rubricIDs[] = $shopProductRubricID;

        $params = Request_RequestParams::setParams(
            array(
                'shop_product_rubric_id' => $rubricIDs,
                'is_public_ignore' => true,
                'is_delete_ignore' => true,
                'group' => 1,
            )
        );
        $shopProductIDs = Request_Request::findBranch('DB_Ab1_Shop_Product',
            array(), $this->_sitePageData, $this->_driverDB, $params, 0, TRUE
        )->getChildArrayID();
        if(empty($shopProductIDs)){
            throw new HTTP_Exception_404('Product not found.');
        }

        /** получаем список реализации и перемещения сгруппированных по дням и продукции */
        $dateFrom = Request_RequestParams::getParamDateTime('exit_at_from');
        $dateTo = Request_RequestParams::getParamDateTime('exit_at_to');

        $isNight = Request_RequestParams::getParamBoolean('is_night');

        $isHoliday = Request_RequestParams::getParamBoolean('is_holiday');
        if($isHoliday){
            // праздничные и выходные дни
            $params = Request_RequestParams::setParams(
                array(
                    'day_from_equally' => Helpers_DateTime::getDateFormatPHP($dateFrom),
                    'day_to' => Helpers_DateTime::getDateFormatPHP($dateTo),
                    'sort_by' => array(
                        'day' => 'asc'
                    )
                )
            );
            $holidayIDs = Request_Request::findNotShop(
                'DB_Ab1_Holiday', $this->_sitePageData, $this->_driverDB,
                $params, 0, TRUE
            );
            $holidayIDs = $holidayIDs->getChildArrayValue('day');
            if(empty($holidayIDs)){
                throw new HTTP_Exception_404('Holidays not found.');
            }
        }else{
            $holidayIDs = null;
        }

        $dataTotal = array(
            'realization' => 0,
            'charity' => 0,
            'move' => 0,
            'storage' => 0,
            'defect' => 0,
        );

        $params = Request_RequestParams::setParams(
            array(
                'exit_at_day_6_hour' => $holidayIDs,
                'is_night_22_to_6_hour' => $isNight,
                'shop_product_id' => $shopProductIDs,
                'shop_turn_place_id' => $shopTurnPlaceID,
                'shop_subdivision_id' => $shopSubdivisionIDs,
                'quantity_from' => 0,
                'sort_by' => array(
                    'id' => 'asc'
                )
            )
        );
        // реализация
        $ids = Api_Ab1_Shop_Car::getExitShopCar(
            $dateFrom, $dateTo, $this->_sitePageData, $this->_driverDB,
            NULL, $params, false, null
        );
        foreach ($ids->childs as $child){
            if($child->values['is_charity'] == 1){
                $dataTotal['charity'] += $child->values['quantity'];
            }else{
                $dataTotal['realization'] += $child->values['quantity'];
            }
        }

        // перемещение
        $shopMoveCarIDs = Api_Ab1_Shop_Move_Car::getExitShopMoveCar(
            $dateFrom, $dateTo, $this->_sitePageData, $this->_driverDB,
            NULL, $params
        );
        $dataTotal['move'] += $shopMoveCarIDs->calcTotalChild('quantity');
        $ids->addChilds($shopMoveCarIDs);

        // брак
        $shopDefectCarIDs = Api_Ab1_Shop_Defect_Car::getExitShopDefectCar(
            $dateFrom, $dateTo, $this->_sitePageData, $this->_driverDB,
            NULL, $params
        );
        $dataTotal['defect'] += $shopDefectCarIDs->calcTotalChild('quantity');
        $ids->addChilds($shopDefectCarIDs);

        // штучный товар
        if($isSubdivision) {
            $pieceItemIDs = Api_Ab1_Shop_Piece_Item::getExitShopPieceItems(
                $dateFrom, $dateTo, $this->_sitePageData, $this->_driverDB,
                NULL, $params, false, null
            );
            foreach ($ids->childs as $child) {
                if (Arr::path($child->values, 'is_charity', 0) == 1) {
                    $dataTotal['charity'] += $child->values['quantity'];
                } else {
                    $dataTotal['realization'] += $child->values['quantity'];
                }
            }
            $ids->addChilds($pieceItemIDs);
        }

        // производство на склад
        $params = Request_RequestParams::setParams(
            array(
                'is_night_22_to_6_hour' => $isNight,
                'weighted_at_from' => $dateFrom,
                'weighted_at_to' => $dateTo,
                'exit_at_day_6_hour' => $holidayIDs,
                'shop_product_id' => $shopProductIDs,
                'shop_turn_place_id' => $shopTurnPlaceID,
                'shop_storage_id.shop_subdivision_id' => $shopSubdivisionIDs,
                'quantity_from' => 0,
                'sort_by' => array(
                    'id' => 'asc'
                )
            )
        );
        $shopProductStorageIDs = Request_Request::find(
            'DB_Ab1_Shop_Product_Storage', $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB,
            $params, 0, TRUE
        );
        $dataTotal['storage'] += $shopProductStorageIDs->calcTotalChild('quantity');
        $ids->addChilds($shopProductStorageIDs);

        /** Получаем список продукции для шапки Excel-файла */

        $params = Request_RequestParams::setParams(
            array(
                'id' => array_merge(
                    array(0),
                    $ids->getChildArrayInt('shop_product_id', TRUE)
                ),
                'is_public_ignore' => TRUE,
                'is_delete_ignore' => TRUE,
            )
        );
        $shopProductIDs = Request_Request::find('DB_Ab1_Shop_Product',
            $this->_sitePageData->shopID, $this->_sitePageData,
            $this->_driverDB, $params,0, TRUE, array()
        );
        $shopProductIDs->runIndex();

        // список продукции
        $products = array();
        foreach ($shopProductIDs->childs as $child){
            $product = $child->id;
            $products[$product] = array(
                'quantity' => 0,
                'data' => array(),
                'name' => $child->values['name']
            );
        }
        uasort($products, array($this, 'mySortMethod'));


        /** Получаем список подрубрик выбранной пользователем рубрики */

        // список подрубрик
        $dataProductRubrics = array();
        foreach ($shopProductRubricIDs->childs as $child){
            $dataProductRubrics[$child->id] = array(
                'name' => $child->values['name'],
                'quantity' => 0,
            );
        }
        uasort($dataProductRubrics, array($this, 'mySortMethod'));
        $dataProductRubrics[$shopProductRubricID] = array(
            'name' => $modelRubric->getName(),
            'quantity' => 0,
        );

        /** Считаем реализацию для вывода в таблицу Excel-файла */

        $dataProducts = $products;
        $dataDates = array(
            'data' => array(),
            'quantity' => 0,
        );

        $ticketCount = 0;

        // реализация
        foreach ($ids->childs as $child){
            $quantity = $child->values['quantity'];

            $product = $child->values['shop_product_id'];
            $dataProducts[$product]['quantity'] += $quantity;

            $exitAt = Arr::path($child->values, 'exit_at',
                Arr::path($child->values, 'weighted_at',
                    Arr::path($child->values, 'created_at', '')));
            $date = Helpers_DateTime::getDateFormatPHP($exitAt);
            $isNightDay = strtotime($exitAt) < strtotime($date.' 06:00:00');
            if ($isNightDay){
                $date = Helpers_DateTime::getDateFormatPHP(Helpers_DateTime::minusDays($date, 1));
            }
            $isNightDay = $isNightDay || strtotime($exitAt) >= strtotime(Helpers_DateTime::getDateFormatPHP($exitAt).' 22:00:00');

            if (! key_exists($date, $dataDates['data'])){
                $dataDates['data'][$date] = array(
                    'data' => $products,
                    'name' => $date,
                    'quantity' => 0,
                    'is_night' => FALSE,
                );
            }
            $dataDates['data'][$date]['is_night'] = $isNightDay || $dataDates['data'][$date]['is_night'];

            $tmp = $shopProductIDs->childs[$product]->values['shop_product_rubric_id'];
            if ($tmp > 0) {
                $dataProductRubrics[$tmp]['quantity'] += $quantity;
            }

            $dataDates['data'][$date]['data'][$product]['quantity'] += $quantity;
            $dataDates['data'][$date]['quantity'] += $quantity;
            $dataDates['quantity'] += $quantity;

            $ticketCount ++;
        }

        /** Считаем перемещение для вывода в таблицу Excel-файла */
        $dataProductRubrics[$shopProductRubricID]['quantity'] = $dataDates['quantity'];

        uasort($dataDates['data'], array($this, 'mySortMethod'));


        $viewObject = 'ab1/_report/'.$this->_sitePageData->languageID.'/realization/by_days';
        $tmp = str_replace('\\', '/', $viewObject);
        try {
            $view = View::factory($tmp);
        }catch (Exception $e) {
            throw new Exception('Шаблон "'.$tmp.'" не найден.');
        }

        $request = '';
        if($shopTurnPlaceID > 0){
            $request .= 'Место погрузки: '
                . Request_Request::findOneByIDResultField(
                    'DB_Ab1_Shop_Turn_Place', $shopTurnPlaceID, 'name', $this->_sitePageData->shopID,
                    $this->_sitePageData, $this->_driverDB
                )
                . "\r\n";
        }
        if($isHoliday){
            $request .= 'Выходные и праздничные дни' . "\r\n";
        }
        $request = trim($request);


        $view->products = $dataProducts;
        $view->dates = $dataDates;
        $view->rubric = $modelRubric->getValues();
        $view->childRubrics = $dataProductRubrics;
        $view->ticketCount = $ticketCount;
        $view->total = $dataTotal;
        $view->request = $request;
        $view->operation = $this->_sitePageData->operation->getValues();
        $view->shop = $this->_sitePageData->shop->getName();
        $view->shopOptions = $this->_sitePageData->shop->getOptionsArray();
        $strView = Helpers_View::viewToStr($view);

        //header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Type: application/x-download;charset=UTF-8');
        header('Content-Disposition: filename="АБ01 Выпуск продукции по дням.xml"');
        header('Cache-Control: max-age=0');

        echo $strView;
        exit();
    }

    /**
     * @throws Exception
     * @throws HTTP_Exception_404
     * @throws HTTP_Exception_500
     */
    public function action_move_by_days() {
        set_time_limit(36000);

        $this->_sitePageData->url = '/'.$this->actionURLName.'/shopreport/move_by_days';

        /** Получаем рубрику, которая выбрана */
        $shopProductRubricID = Request_RequestParams::getParamInt('shop_product_rubric_id');
        if ($shopProductRubricID > 0) {
            $modelRubric = new Model_Ab1_Shop_Product_Rubric();
            $modelRubric->setDBDriver($this->_driverDB);
            if (!(($shopProductRubricID > 0) && (Helpers_DB::getDBObject($modelRubric, $shopProductRubricID, $this->_sitePageData)))) {
                throw new HTTP_Exception_404('Turn type not found.');
            }

            // считываем детвору
            $params = Request_RequestParams::setParams(
                array(
                    'root_id' => $shopProductRubricID,
                    'is_public_ignore' => true,
                    'is_delete_ignore' => true,
                    'sort_by' => array('name' => 'asc'),
                )
            );
            $shopProductRubricIDs = Request_Request::find('DB_Ab1_Shop_Product_Rubric',
                $this->_sitePageData->shopMainID, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE
            );

            $productIDs = Api_Ab1_Shop_Product::findAllByMainRubric(
                Request_RequestParams::getParamInt('shop_product_rubric_id'),
                $this->_sitePageData, $this->_driverDB
            );
        }else{
            throw new HTTP_Exception_500('Rubric not found!');
        }

        /** получаем список реализации и перемещения сгруппированных по дням и продукции */
        $dateFrom = Request_RequestParams::getParamDateTime('exit_at_from');
        $dateTo = Request_RequestParams::getParamDateTime('exit_at_to');

        $params = Request_RequestParams::setParams(
            array(
                'group_by' => array(
                    'shop_product_id',
                    'exit_at_date'
                ),
                'is_exit' => 1,
                'shop_product_id' => $productIDs,
                'quantity_from' => 0,
                'sum_quantity' => TRUE,
                'count_id' => TRUE,
                'sort_by' => array(
                    'shop_product_id' => 'asc'
                )
            )
        );
        // реализация
        $ids = Api_Ab1_Shop_Car::getExitShopCar(
            $dateFrom, $dateTo, $this->_sitePageData, $this->_driverDB,
            NULL, $params
        );

        // перемещение
        $idsMove = Api_Ab1_Shop_Move_Car::getExitShopMoveCar(
            $dateFrom, $dateTo, $this->_sitePageData, $this->_driverDB,
            NULL, $params
        );

        /** Получаем список продукции для шапки Excel-файла */

        $params = Request_RequestParams::setParams(
            array(
                'id' => array_merge(
                    array(0),
                    $ids->getChildArrayInt('shop_product_id', TRUE),
                    $idsMove->getChildArrayInt('shop_product_id', TRUE)
                ),
                'is_public_ignore' => TRUE,
                'is_delete_ignore' => TRUE,
            )
        );
        $shopProductIDs = Request_Request::find('DB_Ab1_Shop_Product',$this->_sitePageData->shopID, $this->_sitePageData,
            $this->_driverDB, $params,0, TRUE, array());
        $shopProductIDs->runIndex();

        // список продукции
        $products = array();
        foreach ($shopProductIDs->childs as $child){
            $product = $child->id;
            $products[$product] = array(
                'quantity' => 0,
                'data' => array(),
                'name' => $child->values['name']
            );
        }
        uasort($products, array($this, 'mySortMethod'));


        /** Получаем список подрубрик выбранной пользователем рубрики */

        // список подрубрик
        $dataProductRubrics = array();
        foreach ($shopProductRubricIDs->childs as $child){
            $dataProductRubrics[$child->id] = array(
                'name' => $child->values['name'],
                'quantity' => 0,
            );
        }
        uasort($dataProductRubrics, array($this, 'mySortMethod'));
        $dataProductRubrics[$shopProductRubricID] = array(
            'name' => $modelRubric->getName(),
            'quantity' => 0,
        );

        /** Считаем реализацию для вывода в таблицу Excel-файла */

        $dataProducts = $products;
        $dataDates = array(
            'data' => array(),
            'quantity' => 0,
        );

        $ticketCount = 0;

        // реализация
        foreach ($ids->childs as $child){
            $quantity = $child->values['quantity'];

            $product = $child->values['shop_product_id'];
            $dataProducts[$product]['quantity'] += $quantity;

            $date = $child->values['exit_at'];
            if (! key_exists($date, $dataDates['data'])){
                $dataDates['data'][$date] = array(
                    'data' => $products,
                    'name' => $date,
                    'quantity' => 0
                );
            }

            $tmp = $shopProductIDs->childs[$product]->values['shop_product_rubric_id'];
            if ($tmp > 0) {
                $dataProductRubrics[$tmp]['quantity'] += $quantity;
            }

            $dataDates['data'][$date]['data'][$product]['quantity'] += $quantity;
            $dataDates['data'][$date]['quantity'] += $quantity;
            $dataDates['quantity'] += $quantity;

            $ticketCount +=  $child->values['count'];
        }
        $realization = $dataDates['quantity'];


        /** Считаем перемещение для вывода в таблицу Excel-файла */

        //перемещение
        $move = 0;
        foreach ($idsMove->childs as $child){
            $quantity = $child->values['quantity'];

            $product = $child->values['shop_product_id'];
            $dataProducts[$product]['quantity'] += $quantity;

            $date = $child->values['exit_at'];
            if (! key_exists($date, $dataDates['data'])){
                $dataDates['data'][$date] = array(
                    'data' => $products,
                    'name' => $date,
                    'quantity' => 0
                );
            }

            $tmp = $shopProductIDs->childs[$product]->values['shop_product_rubric_id'];
            if ($tmp > 0) {
                $dataProductRubrics[$tmp]['quantity'] += $quantity;
            }

            $dataDates['data'][$date]['data'][$product]['quantity'] += $quantity;
            $dataDates['data'][$date]['quantity'] += $quantity;
            $dataDates['quantity'] += $quantity;

            $move += $quantity;
            $ticketCount +=  $child->values['count'];
        }
        $dataProductRubrics[$shopProductRubricID]['quantity'] = $dataDates['quantity'];

        uasort($dataDates['data'], array($this, 'mySortMethod'));


        /** Получаем список перемещения сгруппированных по подразделению */

        $params = Request_RequestParams::setParams(
            array(
                'group_by' => array(
                    'shop_client_id'
                ),
                'is_exit' => 1,
                'shop_product_id' => $productIDs,
                'quantity_from' => 0,
                'sum_quantity' => TRUE,
                'count_id' => TRUE,
            )
        );
        // перемещение
        $idsMove = Api_Ab1_Shop_Move_Car::getExitShopMoveCar(
            $dateFrom, $dateTo, $this->_sitePageData, $this->_driverDB,
            NULL, $params
        );

        /** Считаем перемещение для вывода в таблицу перемещений Excel-файла */
        $dataMoves = array(
            'data' => array(),
            'quantity' => 0,
        );

        $model = new Model_Ab1_Shop_Move_Client();
        $model->setDBDriver($this->_driverDB);
        foreach ($idsMove->childs as $child){
            $client = $child->values['shop_client_id'];
            Helpers_DB::getDBObject($model, $client, $this->_sitePageData);

            $dataMoves['data'][] = array(
                'name' => $model->getName(),
                'quantity' => $child->values['quantity']
            );
        }
        uasort($dataMoves['data'], array($this, 'mySortMethod'));

        $viewObject = 'ab1/_report/'.$this->_sitePageData->languageID.'/realization/by_days';
        $tmp = str_replace('\\', '/', $viewObject);
        try {
            $view = View::factory($tmp);
        }catch (Exception $e) {
            throw new Exception('Шаблон "'.$tmp.'" не найден.');
        }

        $view->products = $dataProducts;
        $view->dates = $dataDates;
        $view->rubric = $modelRubric->getValues();
        $view->childRubrics = $dataProductRubrics;
        $view->ticketCount = $ticketCount;
        $view->realizationQuantity = $realization;
        $view->moveQuantity = $move;
        $view->moves = $dataMoves;
        $view->operation = $this->_sitePageData->operation->getValues();
        $view->shop = $this->_sitePageData->shop->getName();
        $view->shopOptions = $this->_sitePageData->shop->getOptionsArray();
        $strView = Helpers_View::viewToStr($view);

        //header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Type: application/x-download;charset=UTF-8');
        header('Content-Disposition: filename="Отгружено продукции по видам, дате, за период.xml"');
        header('Cache-Control: max-age=0');

        echo $strView;
        exit();
    }

    public function action_delivery_transport() {
        set_time_limit(36000);

        $this->_sitePageData->url = '/'.$this->actionURLName.'/shopreport/delivery_transport';

        /** Отбираем штучный товар **/
        $dateFrom = Request_RequestParams::getParamDateTime('created_at_from');
        $dateTo = Request_RequestParams::getParamDateTime('created_at_to');
        $params = Request_RequestParams::setParams(
            array(
                'shop_delivery_id_from' => 0
            )
        );
        $pieceIDs = Api_Ab1_Shop_Piece::getExitShopPieces(
            $dateFrom, $dateTo, $this->_sitePageData, $this->_driverDB,
            array(
                'shop_client_id' => array('name'),
                'shop_transport_company_id' => array('name'),
                'shop_delivery_id' => array('km', 'price', 'name'),
            ),
            $params
        );
        $pieceIDs->runIndex();

        $shopProductIDs = Api_Ab1_Shop_Product::findAllByMainRubric(
            Request_RequestParams::getParamInt('shop_product_rubric_id'),
            $this->_sitePageData, $this->_driverDB
        );

        if (count($pieceIDs->childs) > 0) {
            $params = Request_RequestParams::setParams(
                array(
                    'shop_piece_id' => $pieceIDs->getChildArrayID(),
                    'quantity_from' => 0,
                    'shop_product_id' => $shopProductIDs
                )
            );
            $ids = Request_Request::find('DB_Ab1_Shop_Piece_Item',
                $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB,
                $params, 0, TRUE, array('shop_product_id' => array('name'))
            );
        }else{
            $ids = new MyArray();
        }

        $dataCars = array(
            'data' => array(),
            'quantity' => 0,
            'amount' => 0,
        );

        $dataTransports = array(
            'data' => array(),
            'quantity' => 0,
            'amount' => 0,
        );

        foreach ($ids->childs as $child){
            $date = Helpers_DateTime::getDateFormatRus($child->values['created_at']);
            if (! key_exists($date, $dataCars['data'])){
                $dataCars['data'][$date] = array(
                    'data' => array(),
                    'date' => $date,
                    'name' => date('Y-m-d', strtotime($date)),
                    'quantity' => 0,
                    'amount' => 0,
                );
            }

            $piece = $pieceIDs->childs[$child->values['shop_piece_id']];

            $quantity = $child->values['quantity'];
            $amount = $piece->values['delivery_amount'];

            $deliveryKM = $piece->values['delivery_km'];
            if($deliveryKM == 0){
                $deliveryKM = $piece->getElementValue('shop_delivery_id', 'km', 0);
            }

            $dataCars['data'][$date]['data'][] = array(
                'quantity' => $quantity,
                'amount' => $amount,
                'rubric' => $child->getElementValue('shop_product_id'),
                'number' => $piece->values['name'],
                'client' => $piece->getElementValue('shop_client_id'),
                'km' => $deliveryKM,
                'delivery' => $piece->getElementValue('shop_delivery_id'),
                'price' => $piece->getElementValue('shop_delivery_id', 'price'),
                'shop_transport_company_name' => $piece->getElementValue('shop_transport_company_id'),
            );

            $dataCars['data'][$date]['quantity'] += $quantity;
            $dataCars['data'][$date]['amount'] += $amount;

            $dataCars['quantity'] += $quantity;
            $dataCars['amount'] += $amount;

            // транспортная компания
            $company = $piece->values['shop_transport_company_id'];
            if (! key_exists($company, $dataTransports['data'])){
                $dataTransports['data'][$company] = array(
                    'name' => $piece->getElementValue('shop_transport_company_id'),
                    'quantity' => 0,
                    'amount' => 0,
                );
            }

            $dataTransports['data'][$company]['quantity'] += $quantity;
            $dataTransports['data'][$company]['amount'] += $amount;

            $dataTransports['quantity'] += $quantity;
            $dataTransports['amount'] += $amount;
        }

        /** Отбираем машины **/
        $params = Request_RequestParams::setParams(
            array(
                'shop_product_id' => $shopProductIDs,
                'shop_delivery_id_from' => 0
            )
        );
        $ids = Api_Ab1_Shop_Car::getExitShopCar(
            $dateFrom, $dateTo, $this->_sitePageData, $this->_driverDB,
            array(
                'shop_client_id' => array('name'),
                'shop_delivery_id' => array('km', 'price', 'name'),
                'shop_product_id' => array('name'),
                'shop_transport_company_id' => array('name'),
            ),
            $params
        );

        foreach ($ids->childs as $child){
            $date = Helpers_DateTime::getDateFormatRus($child->values['created_at']);
            if (! key_exists($date, $dataCars['data'])){
                $dataCars['data'][$date] = array(
                    'data' => array(),
                    'date' => $date,
                    'name' => date('Y-m-d', strtotime($date)),
                    'quantity' => 0,
                    'amount' => 0,
                );
            }

            $quantity = $child->values['quantity'];
            $amount = $child->values['delivery_amount'];

            $deliveryKM = $child->values['delivery_km'];
            if($deliveryKM == 0){
                $deliveryKM = $child->getElementValue('shop_delivery_id', 'km', 0);
            }

            $dataCars['data'][$date]['data'][] = array(
                'quantity' => $quantity,
                'amount' => $amount,
                'rubric' => $child->getElementValue('shop_product_id'),
                'number' => $child->values['name'],
                'client' => $child->getElementValue('shop_client_id'),
                'km' => $deliveryKM,
                'delivery' => $child->getElementValue('shop_delivery_id'),
                'price' => $child->getElementValue('shop_delivery_id', 'price'),
                'shop_transport_company_name' => $child->getElementValue('shop_transport_company_id'),
            );

            $dataCars['data'][$date]['quantity'] += $quantity;
            $dataCars['data'][$date]['amount'] += $amount;

            $dataCars['quantity'] += $quantity;
            $dataCars['amount'] += $amount;

            // транспортная компания
            $company = $child->values['shop_transport_company_id'];
            if (! key_exists($company, $dataTransports['data'])){
                $dataTransports['data'][$company] = array(
                    'name' => $child->getElementValue('shop_transport_company_id'),
                    'quantity' => 0,
                    'amount' => 0,
                );
            }

            $dataTransports['data'][$company]['quantity'] += $quantity;
            $dataTransports['data'][$company]['amount'] += $amount;

            $dataTransports['quantity'] += $quantity;
            $dataTransports['amount'] += $amount;
        }

        uasort($dataCars['data'], array($this, 'mySortMethod'));
        uasort($dataCars['data'], array($this, 'mySortMethod'));

        $viewObject = 'ab1/_report/'.$this->_sitePageData->languageID.'/product/delivery-transport';
        $tmp = str_replace('\\', '/', $viewObject);
        try {
            $view = View::factory($tmp);
        }catch (Exception $e) {
            throw new Exception('Шаблон "'.$tmp.'" не найден.');
        }

        $view->cars = $dataCars;
        $view->transports = $dataTransports;
        $view->operation = $this->_sitePageData->operation->getValues();
        $view->shop = $this->_sitePageData->shop->getName();
        $view->shopOptions = $this->_sitePageData->shop->getOptionsArray();
        $strView = Helpers_View::viewToStr($view);

        header('Content-Type: application/x-download;charset=UTF-8');
        // header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: filename="МС06 Реестр по доставке.xml"');
        header('Cache-Control: max-age=0');

        echo $strView;
        exit();
    }

    public function action_site() {
        set_time_limit(36000);

        $this->_sitePageData->url = '/'.$this->actionURLName.'/shopreport/site';

        $dateFrom = Request_RequestParams::getParamDateTime('created_at_from');
        $dateTo = Request_RequestParams::getParamDateTime('created_at_to');
        $params = Request_RequestParams::setParams(
            array(
                'sort_by' => array('shop_product_id' => 'asc')
            )
        );
        $ids = Api_Ab1_Shop_Car::getExitShopCar(
            $dateFrom, $dateTo, $this->_sitePageData, $this->_driverDB,
            array('shop_client_id' => array('name_site'), 'shop_product_id' => array('name'), 'shop_id' => array('name')),
            $params, true
        );

        header('Content-Type: application/x-download;charset=UTF-8');
        // header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: filename="Для сайта.csv"');
        header('Cache-Control: max-age=0');

        foreach ($ids->childs as $child){
            echo $child->values['created_at'].';'
                .$child->values['exit_at'].';'
                .$child->values['name'].';'
                .$child->getElementValue('shop_product_id').';'
                .$child->values['quantity'].';'
                .Arr::path($child->values, Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_client_id.name_site', '').';'
                .Arr::path($child->values, Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_id.name', '').';'
                .''.';'."\r\n";
        }
        exit();
    }

    public function action_products_volume() {
        set_time_limit(36000);

        $this->_sitePageData->url = '/'.$this->actionURLName.'/shopreport/products_volume';

        $ids = Request_Request::find('DB_Ab1_Shop_Piece', $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB,
            array('is_exit' => 1));

        $shopProductRubricID = Request_RequestParams::getParamInt('shop_product_rubric_id');
        $shopProductIDs = Api_Ab1_Shop_Product::findAllByMainRubric(
            $shopProductRubricID, $this->_sitePageData, $this->_driverDB
        );

        if (count($ids->childs) > 0) {
            $ids = Request_Request::find('DB_Ab1_Shop_Piece_Item', $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB,
                array('shop_piece_id' => array('value' => $ids->getChildArrayID()), 'quantity_from' => 0,
                    'shop_product_id' => array('value' => $shopProductIDs), Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE),
                0, TRUE, array('shop_product_id' => array('name', 'volume')));
        }

        $dataCars = array(
            'data' => array(),
            'quantity' => 0,
            'amount' => 0,
            'volume' => 0,
        );

        foreach ($ids->childs as $child){
            $quantity = $child->values['quantity'];
            $amount = $child->values['amount'];

            $product = $child->values['shop_product_id'];
            if (! key_exists($product, $dataCars['data'])){
                $dataCars['data'][$product] = array(
                    'data' => array(),
                    'name' => $child->getElementValue('shop_product_id'),
                    'quantity' => 0,
                    'amount' => 0,
                    'volume' => 0,
                );
            }
            $volume = Arr::path($child->values, Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_product_id.volume', '');

            $dataCars['data'][$product]['quantity'] += $quantity;
            $dataCars['data'][$product]['amount'] += $amount;
            $dataCars['data'][$product]['volume'] += ($volume * $quantity);

            $dataCars['quantity'] += $quantity;
            $dataCars['amount'] += $amount;
            $dataCars['volume'] += ($volume * $quantity);
        }
        uasort($dataCars['data'], array($this, 'mySortMethod'));

        $viewObject = 'ab1/_report/'.$this->_sitePageData->languageID.'/products-volume';
        $tmp = str_replace('\\', '/', $viewObject);
        try {
            $view = View::factory($tmp);
        }catch (Exception $e) {
            throw new Exception('Шаблон "'.$tmp.'" не найден.');
        }

        $view->cars = $dataCars;
        $view->operation = $this->_sitePageData->operation->getValues();
        $view->shop = $this->_sitePageData->shop->getName();
        $view->shopOptions = $this->_sitePageData->shop->getOptionsArray();
        $strView = Helpers_View::viewToStr($view);

        header('Content-Type: application/x-download;charset=UTF-8');
        // header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: filename="Отгружено объемов ЖБИ и БС.xml"');
        header('Cache-Control: max-age=0');

        echo $strView;
        exit();
    }

    public function action_realization_turn_type() {
        set_time_limit(36000);

        $this->_sitePageData->url = '/'.$this->actionURLName.'/shopreport/realization_turn_type';

        $shopProductRubricID = Request_RequestParams::getParamInt('shop_product_rubric_id');
        if($shopProductRubricID < 1){
            throw new HTTP_Exception_500('Rubric not found.');
        }

        $modelRubric = new Model_Ab1_Shop_Product_Rubric();
        $modelRubric->setDBDriver($this->_driverDB);
        if ($shopProductRubricID > 0) {
            if (!(($shopProductRubricID > 0)
                && (Helpers_DB::getDBObject($modelRubric, $shopProductRubricID, $this->_sitePageData, $this->_sitePageData->shopMainID)))) {
                throw new HTTP_Exception_404('Turn type not found.');
            }

            // считываем детвору
            $shopProductRubricIDs = Request_Request::find('DB_Ab1_Shop_Product_Rubric',
                $this->_sitePageData->shopMainID, $this->_sitePageData, $this->_driverDB,
                array('root_id' => $shopProductRubricID, 'sort_by' => array('value' => array('name' => 'asc')), Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE),
                0, TRUE);

            $rubricIDs = $shopProductRubricIDs->getChildArrayID();
            $rubricIDs[] = $shopProductRubricID;

            $shopProductIDs = Request_Request::find('DB_Ab1_Shop_Product',
                $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB,
                array(
                    'shop_product_rubric_id' => array('value' => $rubricIDs),
                    'is_public_ignore' => true,
                    'is_delete_ignore' => true,
                    Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE), 0, TRUE
            )->getChildArrayID();

            if (count($shopProductIDs) == 0) {
                throw new HTTP_Exception_404('Products rubric not found.');
            }
        }else{
            $shopProductIDs = NULL;
            $shopProductRubricIDs = new MyArray();
        }

        $dateFrom = Request_RequestParams::getParamDateTime('exit_at_from');
        $dateTo = Request_RequestParams::getParamDateTime('exit_at_to');
        $params = Request_RequestParams::setParams(
            array(
                'shop_product_id' => $shopProductIDs,
                'sort_by' => array('shop_product_id' => 'asc'),
            )
        );
        $ids = Api_Ab1_Shop_Car::getExitShopCar(
            $dateFrom, $dateTo, $this->_sitePageData, $this->_driverDB,
            array('shop_client_id' => array('name'), 'shop_product_id' => array('name', 'shop_product_rubric_id')),
            $params
        );
        $ticketCount = count($ids->childs);

        // список продукции
        $products = array();
        foreach ($ids->childs as $child){
            $product = $child->values['shop_product_id'];
            if (! key_exists($product, $products)){
                $products[$product] = array(
                    'quantity' => 0,
                    'data' => array(),
                    'name' => $child->getElementValue('shop_product_id')
                );
            }
        }
        uasort($products, array($this, 'mySortMethod'));

        // список подрубрик
        $dataProductRubrics = array();
        foreach ($shopProductRubricIDs->childs as $child){
            $dataProductRubrics[$child->id] = array(
                'name' => $child->values['name'],
                'quantity' => 0,
            );
        }
        uasort($dataProductRubrics, array($this, 'mySortMethod'));
        $dataProductRubrics[$shopProductRubricID] = array(
            'name' => $modelRubric->getName(),
            'quantity' => 0,
        );

        $dataProducts = $products;
        $dataClients = array(
            'data' => array(),
            'quantity' => 0,
        );
        foreach ($ids->childs as $child){
            $quantity = $child->values['quantity'];

            $product = $child->values['shop_product_id'];
            $dataProducts[$product]['quantity'] += $quantity;

            $client = $child->values['shop_client_id'];
            if (! key_exists($client, $dataClients['data'])){
                $dataClients['data'][$client] = array(
                    'data' => $products,
                    'name' => $child->getElementValue('shop_client_id'),
                    'quantity' => 0
                );
            }

            $tmp = Arr::path($child->values, Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_product_id.shop_product_rubric_id', 0);
            if ($tmp > 0) {
                $dataProductRubrics[$tmp]['quantity'] += $quantity;
            }

            $dataClients['data'][$client]['data'][$product]['quantity'] += $quantity;
            $dataClients['data'][$client]['quantity'] += $quantity;
            $dataClients['quantity'] += $quantity;
        }
        $dataProductRubrics[$shopProductRubricID]['quantity'] = $dataClients['quantity'];

        uasort($dataClients['data'], array($this, 'mySortMethod'));

        // Находим продукцию собранной с холодного склада
        $params = array_merge(
            Request_RequestParams::setParams(
                array(
                    'exit_at_from' => $dateFrom,
                    'exit_at_to' => $dateTo,
                    'is_exit' => 1,
                    'quantity_from' => 0,
                    'is_charity' => FALSE,
                    'sum_quantity' => true,
                    'shop_turn_place_id' => [58086, 761594], // Холодный склад
                    'group_by' => array(
                        'shop_product_id', 'shop_product_id.name'
                    )
                )
            ),
            $params
        );
        $ids = Request_Request::find('DB_Ab1_Shop_Car',
            $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
            array(
                'shop_product_id' => array('name')
            )
        );

        $dataStorage = array(
            'data' => array(),
            'quantity' => 0,
        );
        foreach ($ids->childs as $child){
            $quantity = $child->values['quantity'];
            $product = $child->values['shop_product_id'];

            if (! key_exists($product, $dataStorage['data'])){
                $dataStorage['data'][$product] = array(
                    'name' => $child->getElementValue('shop_product_id'),
                    'quantity' => 0
                );
            }

            $dataStorage['data'][$product]['quantity'] += $quantity;
            $dataStorage['quantity'] += $quantity;
        }
        uasort($dataStorage['data'], array($this, 'mySortMethod'));

        $viewObject = 'ab1/_report/'.$this->_sitePageData->languageID.'/realization/turn_type';
        $tmp = str_replace('\\', '/', $viewObject);
        try {
            $view = View::factory($tmp);
        }catch (Exception $e) {
            throw new Exception('Шаблон "'.$tmp.'" не найден.');
        }

        $view->products = $dataProducts;
        $view->clients = $dataClients;
        $view->rubric = $modelRubric->getValues();
        $view->childRubrics = $dataProductRubrics;
        $view->storage = $dataStorage;
        $view->ticketCount = $ticketCount;
        $view->operation = $this->_sitePageData->operation->getValues();
        $view->shop = $this->_sitePageData->shop->getName();
        $view->shopOptions = $this->_sitePageData->shop->getOptionsArray();
        $strView = Helpers_View::viewToStr($view);

        //header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Type: application/x-download;charset=UTF-8');
        header('Content-Disposition: filename="ВС01 Сводка по реализации.xml"');
        header('Cache-Control: max-age=0');

        echo $strView;
        exit();
    }

    /**
     * ВС20 Сводка по выпуску возмещения брака
     * @throws HTTP_Exception_404
     * @throws HTTP_Exception_500
     */
    public function action_defect_turn_type() {
        set_time_limit(36000);

        $this->_sitePageData->url = '/'.$this->actionURLName.'/shopreport/defect_turn_type';

        $shopProductRubricID = Request_RequestParams::getParamInt('shop_product_rubric_id');
        if($shopProductRubricID < 1){
            throw new HTTP_Exception_500('Rubric not found.');
        }

        $modelRubric = new Model_Ab1_Shop_Product_Rubric();
        $modelRubric->setDBDriver($this->_driverDB);
        if ($shopProductRubricID > 0) {
            if (!(($shopProductRubricID > 0)
                && (Helpers_DB::getDBObject($modelRubric, $shopProductRubricID, $this->_sitePageData, $this->_sitePageData->shopMainID)))) {
                throw new HTTP_Exception_404('Turn type not found.');
            }

            // считываем детвору
            $shopProductRubricIDs = Request_Request::find('DB_Ab1_Shop_Product_Rubric',
                $this->_sitePageData->shopMainID, $this->_sitePageData, $this->_driverDB,
                array('root_id' => $shopProductRubricID, 'sort_by' => array('value' => array('name' => 'asc')), Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE),
                0, TRUE);

            $rubricIDs = $shopProductRubricIDs->getChildArrayID();
            $rubricIDs[] = $shopProductRubricID;

            $shopProductIDs = Request_Request::find('DB_Ab1_Shop_Product',
                $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB,
                array(
                    'shop_product_rubric_id' => array('value' => $rubricIDs),
                    'is_public_ignore' => true,
                    'is_delete_ignore' => true,
                    Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE), 0, TRUE
            )->getChildArrayID();

            if (count($shopProductIDs) == 0) {
                throw new HTTP_Exception_404('Products rubric not found.');
            }
        }else{
            $shopProductIDs = NULL;
            $shopProductRubricIDs = new MyArray();
        }

        $dateFrom = Request_RequestParams::getParamDateTime('exit_at_from');
        $dateTo = Request_RequestParams::getParamDateTime('exit_at_to');
        $params = Request_RequestParams::setParams(
            array(
                'shop_product_id' => $shopProductIDs,
                'sort_by' => array('shop_product_id' => 'asc'),
            )
        );
        $ids = Api_Ab1_Shop_Defect_Car::getExitShopDefectCar(
            $dateFrom, $dateTo, $this->_sitePageData, $this->_driverDB,
            array('shop_client_id' => array('name'), 'shop_product_id' => array('name', 'shop_product_rubric_id')),
            $params
        );
        $ticketCount = count($ids->childs);

        // список продукции
        $products = array();
        foreach ($ids->childs as $child){
            $product = $child->values['shop_product_id'];
            if (! key_exists($product, $products)){
                $products[$product] = array(
                    'quantity' => 0,
                    'data' => array(),
                    'name' => $child->getElementValue('shop_product_id')
                );
            }
        }
        uasort($products, array($this, 'mySortMethod'));

        // список подрубрик
        $dataProductRubrics = array();
        foreach ($shopProductRubricIDs->childs as $child){
            $dataProductRubrics[$child->id] = array(
                'name' => $child->values['name'],
                'quantity' => 0,
            );
        }
        uasort($dataProductRubrics, array($this, 'mySortMethod'));
        $dataProductRubrics[$shopProductRubricID] = array(
            'name' => $modelRubric->getName(),
            'quantity' => 0,
        );

        $dataProducts = $products;
        $dataClients = array(
            'data' => array(),
            'quantity' => 0,
        );
        foreach ($ids->childs as $child){
            $quantity = $child->values['quantity'];

            $product = $child->values['shop_product_id'];
            $dataProducts[$product]['quantity'] += $quantity;

            $client = $child->values['shop_client_id'];
            if (! key_exists($client, $dataClients['data'])){
                $dataClients['data'][$client] = array(
                    'data' => $products,
                    'name' => $child->getElementValue('shop_client_id'),
                    'quantity' => 0
                );
            }

            $tmp = Arr::path($child->values, Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_product_id.shop_product_rubric_id', 0);
            if ($tmp > 0) {
                $dataProductRubrics[$tmp]['quantity'] += $quantity;
            }

            $dataClients['data'][$client]['data'][$product]['quantity'] += $quantity;
            $dataClients['data'][$client]['quantity'] += $quantity;
            $dataClients['quantity'] += $quantity;
        }
        $dataProductRubrics[$shopProductRubricID]['quantity'] = $dataClients['quantity'];

        uasort($dataClients['data'], array($this, 'mySortMethod'));

        // Находим продукцию собранной с холодного склада
        $params = array_merge(
            Request_RequestParams::setParams(
                array(
                    'exit_at_from' => $dateFrom,
                    'exit_at_to' => $dateTo,
                    'is_exit' => 1,
                    'quantity_from' => 0,
                    'is_charity' => FALSE,
                    'sum_quantity' => true,
                    'shop_turn_place_id' => [58086, 761594], // Холодный склад
                    'group_by' => array(
                        'shop_product_id', 'shop_product_id.name'
                    )
                )
            ),
            $params
        );
        $ids = Request_Request::find('DB_Ab1_Shop_Defect_Car',
            $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
            array(
                'shop_product_id' => array('name')
            )
        );

        $dataStorage = array(
            'data' => array(),
            'quantity' => 0,
        );
        foreach ($ids->childs as $child){
            $quantity = $child->values['quantity'];
            $product = $child->values['shop_product_id'];

            if (! key_exists($product, $dataStorage['data'])){
                $dataStorage['data'][$product] = array(
                    'name' => $child->getElementValue('shop_product_id'),
                    'quantity' => 0
                );
            }

            $dataStorage['data'][$product]['quantity'] += $quantity;
            $dataStorage['quantity'] += $quantity;
        }
        uasort($dataStorage['data'], array($this, 'mySortMethod'));

        $viewObject = 'ab1/_report/'.$this->_sitePageData->languageID.'/defect/turn_type';
        $tmp = str_replace('\\', '/', $viewObject);
        try {
            $view = View::factory($tmp);
        }catch (Exception $e) {
            throw new Exception('Шаблон "'.$tmp.'" не найден.');
        }

        $view->products = $dataProducts;
        $view->clients = $dataClients;
        $view->rubric = $modelRubric->getValues();
        $view->childRubrics = $dataProductRubrics;
        $view->storage = $dataStorage;
        $view->ticketCount = $ticketCount;
        $view->operation = $this->_sitePageData->operation->getValues();
        $view->shop = $this->_sitePageData->shop->getName();
        $view->shopOptions = $this->_sitePageData->shop->getOptionsArray();
        $strView = Helpers_View::viewToStr($view);

        //header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Type: application/x-download;charset=UTF-8');
        header('Content-Disposition: filename="ВС01 Сводка по реализации.xml"');
        header('Cache-Control: max-age=0');

        echo $strView;
        exit();
    }

    public function action_realization_asu_old() {
        set_time_limit(36000);

        $this->_sitePageData->url = '/'.$this->actionURLName.'/shopreport/realization_asu_old';

        $shopProductIDs = Api_Ab1_Shop_Product::findAllByMainRubric(
            Request_RequestParams::getParamInt('shop_product_rubric_id'),
            $this->_sitePageData, $this->_driverDB
        );

        $dateFrom = Request_RequestParams::getParamDateTime('created_at_from');
        $dateTo = Request_RequestParams::getParamDateTime('created_at_to');
        $params = Request_RequestParams::setParams(
            array(
                'shop_product_id' => $shopProductIDs,
                'sort_by' => array('shop_product_id' => 'asc')
            )
        );
        $ids = Api_Ab1_Shop_Car::getExitShopCar(
            $dateFrom, $dateTo, $this->_sitePageData, $this->_driverDB,
            array('shop_turn_place_id' => array('name'), 'shop_product_id' => array('name')),
            $params
        );

        $ids->childs = array_merge(
            $ids->childs,
            Api_Ab1_Shop_Move_Car::getExitShopMoveCar(
                $dateFrom, $dateTo, $this->_sitePageData, $this->_driverDB,
                array('shop_turn_place_id' => array('name'), 'shop_product_id' => array('name')),
                $params
            )->childs
        );

        $products = array();
        foreach ($ids->childs as $child){
            $product = $child->values['shop_product_id'];
            if (! key_exists($product, $products)){
                $products[$product] = array(
                    'quantity' => 0,
                    'data' => array(),
                    'name' => $child->getElementValue('shop_product_id')
                );
            }
        }
        uasort($products, array($this, 'mySortMethod'));

        $dataProducts = $products;
        $dataTurns = array(
            'data' => array(),
            'quantity' => 0,
        );
        foreach ($ids->childs as $child){
            $quantity = $child->values['quantity'];

            $product = $child->values['shop_product_id'];
            $dataProducts[$product]['quantity'] += $quantity;

            $turn = $child->values['shop_turn_place_id'];
            if (! key_exists($turn, $dataTurns['data'])){
                $dataTurns['data'][$turn] = array(
                    'data' => $products,
                    'name' => $child->getElementValue('shop_turn_place_id'),
                    'quantity' => 0
                );
            }

            $dataTurns['data'][$turn]['data'][$product]['quantity'] += $quantity;
            $dataTurns['data'][$turn]['quantity'] += $quantity;
            $dataTurns['quantity'] += $quantity;
        }
        uasort($dataTurns['data'], array($this, 'mySortMethod'));

        $viewObject = 'ab1/_report/'.$this->_sitePageData->languageID.'/realization/asu_old';
        $tmp = str_replace('\\', '/', $viewObject);
        try {
            $view = View::factory($tmp);
        }catch (Exception $e) {
            throw new Exception('Шаблон "'.$tmp.'" не найден.');
        }

        $view->products = $dataProducts;
        $view->turns = $dataTurns;
        $view->operation = $this->_sitePageData->operation->getValues();
        $view->shop = $this->_sitePageData->shop->getName();
        $view->shopOptions = $this->_sitePageData->shop->getOptionsArray();
        $strView = Helpers_View::viewToStr($view);

        header('Content-Type: application/x-download;charset=UTF-8');
        // header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: filename="Сводка по выпуску (АСУ - Место погрузки).xml"');
        header('Cache-Control: max-age=0');

        echo $strView;
        exit();
    }

    /**
     * ВС02 Сводка по выпуску (АСУ/Место погрузки)
     * @throws Exception
     */
    public function action_realization_asu() {
        set_time_limit(36000);

        $this->_sitePageData->url = '/'.$this->actionURLName.'/shopreport/realization_asu';


        $dateFrom = Request_RequestParams::getParamDateTime('created_at_from');
        $dateTo = Request_RequestParams::getParamDateTime('created_at_to');

        $shopProductIDs = Api_Ab1_Shop_Product::findAllByMainRubric(
            Request_RequestParams::getParamInt('shop_product_rubric_id'),
            $this->_sitePageData, $this->_driverDB
        );

        /*********************************************************************/
        /************* Количество произведенного товара на склад *************/
        $params = Request_RequestParams::setParams(
            array(
                'shop_product_id' => $shopProductIDs,
                'created_at_from' => $dateFrom,
                'created_at_to' => $dateTo,
                'sum_quantity' => true,
                'group_by' => array(
                    'shop_product_id', 'shop_product_id.name',
                    'shop_turn_place_id', 'shop_turn_place_id.name',
                )
            )
        );
        $shopProductStorageIDs = Request_Request::find('DB_Ab1_Shop_Product_Storage',
            $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB,
            $params, 0, true,
            array(
                'shop_turn_place_id' => array('name'),
                'shop_product_id' => array('name'),
            )
        );

        $turnPlaceStorages = [];
        foreach ($shopProductStorageIDs->childs as $child){
            $turnPlace = $child->values['shop_turn_place_id'];
            if (! key_exists($turnPlace, $turnPlaceStorages)){
                $turnPlaceStorages[$turnPlace] = array(
                    'quantity' => 0,
                    'data' => array(),
                    'name' => $child->getElementValue('shop_turn_place_id'),
                );
            }
        }
        uasort($turnPlaceStorages, array($this, 'mySortMethod'));

        $dataTurnPlaceStorages = [
            'data' => $turnPlaceStorages,
            'quantity' => 0,
        ];

        $dataMakes = array(
            'data' => array(),
            'quantity' => 0,
        );
        foreach ($shopProductStorageIDs->childs as $child){
            $quantity = $child->values['quantity'];
            $turn = $child->values['shop_turn_place_id'];
            $dataTurnPlaceStorages['data'][$turn]['quantity'] += $quantity;
            $dataTurnPlaceStorages['quantity'] += $quantity;

            $product = $child->values['shop_product_id'];
            if (! key_exists($product, $dataMakes['data'])){
                $dataMakes['data'][$product] = array(
                    'data' => $turnPlaceStorages,
                    'name' => $child->getElementValue('shop_product_id'),
                    'quantity' => 0
                );
            }

            $dataMakes['data'][$product]['data'][$turn]['quantity'] += $quantity;
            $dataMakes['data'][$product]['quantity'] += $quantity;
            $dataMakes['quantity'] += $quantity;
        }
        uasort($dataMakes['data'], array($this, 'mySortMethod'));

        /******************************************************************/
        /************* выпущенно продукции на заданный период *************/
        $params = Request_RequestParams::setParams(
            array(
                'shop_product_id' => $shopProductIDs,
                'shop_storage_id' => 0,
                'sort_by' => array('shop_product_id' => 'asc')
            )
        );
        $ids = Api_Ab1_Shop_Car::getExitShopCar(
            $dateFrom, $dateTo, $this->_sitePageData, $this->_driverDB,
            array('shop_turn_place_id' => array('name'), 'shop_product_id' => array('name')),
            $params, false, null
        );

        // соединяем с внутренним перемещением
        $ids->childs = array_merge(
            $ids->childs,
            Api_Ab1_Shop_Move_Car::getExitShopMoveCar(
                $dateFrom, $dateTo, $this->_sitePageData, $this->_driverDB,
                array('shop_turn_place_id' => array('name'), 'shop_product_id' => array('name')),
                $params
            )->childs
        );

        // соединяем с браком
        $ids->childs = array_merge(
            $ids->childs,
            Api_Ab1_Shop_Defect_Car::getExitShopDefectCar(
                $dateFrom, $dateTo, $this->_sitePageData, $this->_driverDB,
                array('shop_turn_place_id' => array('name'), 'shop_product_id' => array('name')),
                $params
            )->childs
        );

        $turnPlaces = array();
        // реализация + перемещение
        foreach ($ids->childs as $child){
            $turnPlace = $child->values['shop_turn_place_id'];
            if (! key_exists($turnPlace, $turnPlaces)){
                $turnPlaces[$turnPlace] = array(
                    'quantity' => 0,
                    'data' => array(),
                    'name' => $child->getElementValue('shop_turn_place_id')
                );
            }
        }

        // производство на склад
        foreach ($shopProductStorageIDs->childs as $child){
            $turnPlace = $child->values['shop_turn_place_id'];
            if (! key_exists($turnPlace, $turnPlaces)){
                $turnPlaces[$turnPlace] = array(
                    'quantity' => 0,
                    'data' => array(),
                    'name' => $child->getElementValue('shop_turn_place_id'),
                );
            }
        }
        uasort($turnPlaces, array($this, 'mySortMethod'));

        /****************************************************/
        /************* реализация + перемещение *************/
        $dataTurnPlaces = $turnPlaces;
        $dataProducts = array(
            'data' => array(),
            'quantity' => 0,
        );

        // реализация + перемещение
        foreach ($ids->childs as $child){
            $quantity = $child->values['quantity'];
            $turn = $child->values['shop_turn_place_id'];
            $dataTurnPlaces[$turn]['quantity'] += $quantity;

            $product = $child->values['shop_product_id'];
            if (! key_exists($product, $dataProducts['data'])){
                $dataProducts['data'][$product] = array(
                    'data' => $turnPlaces,
                    'name' => $child->getElementValue('shop_product_id'),
                    'quantity' => 0
                );
            }

            $dataProducts['data'][$product]['data'][$turn]['quantity'] += $quantity;
            $dataProducts['data'][$product]['quantity'] += $quantity;
            $dataProducts['quantity'] += $quantity;
        }

        // производство на склад
        foreach ($shopProductStorageIDs->childs as $child){
            $quantity = $child->values['quantity'];
            $turn = $child->values['shop_turn_place_id'];
            $dataTurnPlaces[$turn]['quantity'] += $quantity;

            $product = $child->values['shop_product_id'];
            if (! key_exists($product, $dataProducts['data'])){
                $dataProducts['data'][$product] = array(
                    'data' => $turnPlaces,
                    'name' => $child->getElementValue('shop_product_id'),
                    'quantity' => 0
                );
            }

            $dataProducts['data'][$product]['data'][$turn]['quantity'] += $quantity;
            $dataProducts['data'][$product]['quantity'] += $quantity;
            $dataProducts['quantity'] += $quantity;
        }

        uasort($dataProducts['data'], array($this, 'mySortMethod'));

        /***************************************************/
        /************* ПЕРЕМЕЩЕНИЕ СО/НА СКЛАД *************/
        $dataMoveStorages = array(
            'data' => array(),
            'quantity_in' => 0,
            'quantity_out' => 0,
        );
        foreach ($shopProductStorageIDs->childs as $child){
            $quantity = $child->values['quantity'];

            $product = $child->values['shop_product_id'];
            if (! key_exists($product, $dataMoveStorages['data'])){
                $dataMoveStorages['data'][$product] = array(
                    'name' => $child->getElementValue('shop_product_id'),
                    'quantity_in' => 0,
                    'quantity_out' => 0,
                );
            }

            $dataMoveStorages['data'][$product]['quantity_in'] += $quantity;
            $dataMoveStorages['quantity_in'] += $quantity;
        }

        $params = Request_RequestParams::setParams(
            array(
                'shop_product_id' => $shopProductIDs,
                'shop_storage_id_from' => 0,
                'sort_by' => array('shop_product_id' => 'asc')
            )
        );
        $ids = Api_Ab1_Shop_Car::getExitShopCar(
            $dateFrom, $dateTo, $this->_sitePageData, $this->_driverDB,
            array('shop_turn_place_id' => array('name'), 'shop_product_id' => array('name')),
            $params, false, null
        );

        $ids->childs = array_merge(
            $ids->childs,
            Api_Ab1_Shop_Move_Car::getExitShopMoveCar(
                $dateFrom, $dateTo, $this->_sitePageData, $this->_driverDB,
                array('shop_turn_place_id' => array('name'), 'shop_product_id' => array('name')),
                $params
            )->childs
        );

        foreach ($ids->childs as $child){
            if($child->values['shop_storage_id'] < 1){
                continue;
            }

            $quantity = $child->values['quantity'];

            $product = $child->values['shop_product_id'];
            if (! key_exists($product, $dataMoveStorages['data'])){
                $dataMoveStorages['data'][$product] = array(
                    'name' => $child->getElementValue('shop_product_id'),
                    'quantity_in' => 0,
                    'quantity_out' => 0,
                );
            }

            $dataMoveStorages['data'][$product]['quantity_out'] += $quantity;
            $dataMoveStorages['quantity_out'] += $quantity;
        }

        /**********************************************/
        /************* ОСТАТКИ НА СКЛАДАХ *************/
        $params = Request_RequestParams::setParams(
            array(
                'shop_product_id' => $shopProductIDs,
                'created_at_to' => $dateTo,
                'sum_quantity' => true,
                'group_by' => array(
                    'shop_product_id', 'shop_product_id.name',
                )
            )
        );

        // получаем список
        $shopProductStorageIDs = Request_Request::find('DB_Ab1_Shop_Product_Storage',
            $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB,
            $params, 0, true,
            array(
                'shop_product_id' => array('name'),
            )
        );

        $dataTotalStorages = array(
            'data' => array(),
            'quantity' => 0,
        );
        foreach ($shopProductStorageIDs->childs as $child){
            $quantity = $child->values['quantity'];

            $product = $child->values['shop_product_id'];
            if (! key_exists($product, $dataTotalStorages['data'])){
                $dataTotalStorages['data'][$product] = array(
                    'name' => $child->getElementValue('shop_product_id'),
                    'quantity' => 0,
                );
            }

            $dataTotalStorages['data'][$product]['quantity'] += $quantity;
            $dataTotalStorages['quantity'] += $quantity;
        }

        // выпущенно продукции на заданный период
        $params = Request_RequestParams::setParams(
            array(
                'shop_product_id' => $shopProductIDs,
                'sort_by' => array('shop_product_id' => 'asc'),
                'shop_storage_id_from' => 0,
                'sum_quantity' => true,
                'group_by' => array(
                    'shop_product_id', 'shop_product_id.name',
                )
            )
        );
        $ids = Api_Ab1_Shop_Car::getExitShopCar(
            null, $dateTo, $this->_sitePageData, $this->_driverDB,
            array('shop_product_id' => array('name')),
            $params, false, null
        );

        // соединяем с внутренним перемещением
        $ids->childs = array_merge(
            $ids->childs,
            Api_Ab1_Shop_Move_Car::getExitShopMoveCar(
                null, $dateTo, $this->_sitePageData, $this->_driverDB,
                array('shop_product_id' => array('name')),
                $params
            )->childs
        );

        // соединяем с браком
        $ids->childs = array_merge(
            $ids->childs,
            Api_Ab1_Shop_Defect_Car::getExitShopDefectCar(
                null, $dateTo, $this->_sitePageData, $this->_driverDB,
                array('shop_product_id' => array('name')),
                $params
            )->childs
        );

        // реализация + перемещение
        foreach ($ids->childs as $child) {
            $quantity = $child->values['quantity'];

            $product = $child->values['shop_product_id'];
            if (!key_exists($product, $dataTotalStorages['data'])) {
                $dataTotalStorages['data'][$product] = array(
                    'name' => $child->getElementValue('shop_product_id'),
                    'quantity' => 0,
                );
            }

            $dataTotalStorages['data'][$product]['quantity'] -= $quantity;
            $dataTotalStorages['quantity'] -= $quantity;
        }

        $viewObject = 'ab1/_report/'.$this->_sitePageData->languageID.'/realization/asu';
        $tmp = str_replace('\\', '/', $viewObject);
        try {
            $view = View::factory($tmp);
        }catch (Exception $e) {
            throw new Exception('Шаблон "'.$tmp.'" не найден.');
        }

        $view->makes = $dataMakes;
        $view->totalStorages = $dataTotalStorages;
        $view->moveStorages = $dataMoveStorages;
        $view->turnPlaceStorages = $dataTurnPlaceStorages;
        $view->products = $dataProducts;
        $view->turnPlaces = $dataTurnPlaces;
        $view->operation = $this->_sitePageData->operation->getValues();
        $view->shop = $this->_sitePageData->shop->getName();
        $view->shopOptions = $this->_sitePageData->shop->getOptionsArray();
        $strView = Helpers_View::viewToStr($view);

        header('Content-Type: application/x-download;charset=UTF-8');
        // header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: filename="ВС02 Сводка по выпуску (АСУ/Место погрузки).xml"');
        header('Cache-Control: max-age=0');

        echo $strView;
        exit();
    }

    /**
     * ВС18 Сводка по выпуску (АСУ/Место погрузки) по всем филиалам
     * @throws Exception
     */
    public function action_realization_asu_branch() {
        set_time_limit(36000);

        $this->_sitePageData->url = '/'.$this->actionURLName.'/shopreport/realization_asu_branch';


        $dateFrom = Request_RequestParams::getParamDateTime('created_at_from');
        $dateTo = Request_RequestParams::getParamDateTime('created_at_to');

        $shopProductIDs = Api_Ab1_Shop_Product::findAllByMainRubric(
            Request_RequestParams::getParamInt('shop_product_rubric_id'),
            $this->_sitePageData, $this->_driverDB
        );

        /*********************************************************************/
        /************* Количество произведенного товара на склад *************/
        $params = Request_RequestParams::setParams(
            array(
                'shop_product_id' => $shopProductIDs,
                'created_at_from' => $dateFrom,
                'created_at_to' => $dateTo,
                'sum_quantity' => true,
                'shop_id.main_shop_id'=> $this->_sitePageData->shopMainID,
                'group_by' => array(
                    'shop_product_id', 'shop_product_id.name',
                    'shop_turn_place_id', 'shop_turn_place_id.name',
                )
            )
        );
        $shopProductStorageIDs = Request_Request::find(
            'DB_Ab1_Shop_Product_Storage',
            0, $this->_sitePageData, $this->_driverDB,
            $params, 0, true,
            array(
                'shop_turn_place_id' => array('name'),
                'shop_product_id' => array('name'),
            )
        );

        $turnPlaceStorages = [];
        foreach ($shopProductStorageIDs->childs as $child){
            $turnPlace = $child->values['shop_turn_place_id'];
            if (! key_exists($turnPlace, $turnPlaceStorages)){
                $turnPlaceStorages[$turnPlace] = array(
                    'quantity' => 0,
                    'data' => array(),
                    'name' => $child->getElementValue('shop_turn_place_id'),
                );
            }
        }
        uasort($turnPlaceStorages, array($this, 'mySortMethod'));

        $dataTurnPlaceStorages = [
            'data' => $turnPlaceStorages,
            'quantity' => 0,
        ];

        $dataMakes = array(
            'data' => array(),
            'quantity' => 0,
        );
        foreach ($shopProductStorageIDs->childs as $child){
            $quantity = $child->values['quantity'];
            $turn = $child->values['shop_turn_place_id'];
            $dataTurnPlaceStorages['data'][$turn]['quantity'] += $quantity;
            $dataTurnPlaceStorages['quantity'] += $quantity;

            $product = $child->values['shop_product_id'];
            if (! key_exists($product, $dataMakes['data'])){
                $dataMakes['data'][$product] = array(
                    'data' => $turnPlaceStorages,
                    'name' => $child->getElementValue('shop_product_id'),
                    'quantity' => 0
                );
            }

            $dataMakes['data'][$product]['data'][$turn]['quantity'] += $quantity;
            $dataMakes['data'][$product]['quantity'] += $quantity;
            $dataMakes['quantity'] += $quantity;
        }
        uasort($dataMakes['data'], array($this, 'mySortMethod'));

        /******************************************************************/
        /************* выпущенно продукции на заданный период *************/
        $params = Request_RequestParams::setParams(
            array(
                'shop_product_id' => $shopProductIDs,
                'shop_storage_id' => 0,
                'shop_id.main_shop_id'=> $this->_sitePageData->shopMainID,
                'sort_by' => array('shop_product_id' => 'asc')
            )
        );
        $ids = Api_Ab1_Shop_Car::getExitShopCar(
            $dateFrom, $dateTo, $this->_sitePageData, $this->_driverDB,
            array('shop_turn_place_id' => array('name'), 'shop_product_id' => array('name')),
            $params, true, null
        );

        // соединяем с внутренним перемещением
        $ids->childs = array_merge(
            $ids->childs,
            Api_Ab1_Shop_Move_Car::getExitShopMoveCar(
                $dateFrom, $dateTo, $this->_sitePageData, $this->_driverDB,
                array('shop_turn_place_id' => array('name'), 'shop_product_id' => array('name')),
                $params, true
            )->childs
        );

        // соединяем с браком
        $ids->childs = array_merge(
            $ids->childs,
            Api_Ab1_Shop_Defect_Car::getExitShopDefectCar(
                $dateFrom, $dateTo, $this->_sitePageData, $this->_driverDB,
                array('shop_turn_place_id' => array('name'), 'shop_product_id' => array('name')),
                $params, true
            )->childs
        );

        $turnPlaces = array();
        // реализация + перемещение
        foreach ($ids->childs as $child){
            $turnPlace = $child->values['shop_turn_place_id'];
            if (! key_exists($turnPlace, $turnPlaces)){
                $turnPlaces[$turnPlace] = array(
                    'quantity' => 0,
                    'data' => array(),
                    'name' => $child->getElementValue('shop_turn_place_id')
                );
            }
        }

        // производство на склад
        foreach ($shopProductStorageIDs->childs as $child){
            $turnPlace = $child->values['shop_turn_place_id'];
            if (! key_exists($turnPlace, $turnPlaces)){
                $turnPlaces[$turnPlace] = array(
                    'quantity' => 0,
                    'data' => array(),
                    'name' => $child->getElementValue('shop_turn_place_id'),
                );
            }
        }
        uasort($turnPlaces, array($this, 'mySortMethod'));

        /****************************************************/
        /************* реализация + перемещение *************/
        $dataTurnPlaces = $turnPlaces;
        $dataProducts = array(
            'data' => array(),
            'quantity' => 0,
        );

        // реализация + перемещение
        foreach ($ids->childs as $child){
            $quantity = $child->values['quantity'];
            $turn = $child->values['shop_turn_place_id'];
            $dataTurnPlaces[$turn]['quantity'] += $quantity;

            $product = $child->values['shop_product_id'];
            if (! key_exists($product, $dataProducts['data'])){
                $dataProducts['data'][$product] = array(
                    'data' => $turnPlaces,
                    'name' => $child->getElementValue('shop_product_id'),
                    'quantity' => 0
                );
            }

            $dataProducts['data'][$product]['data'][$turn]['quantity'] += $quantity;
            $dataProducts['data'][$product]['quantity'] += $quantity;
            $dataProducts['quantity'] += $quantity;
        }

        // производство на склад
        foreach ($shopProductStorageIDs->childs as $child){
            $quantity = $child->values['quantity'];
            $turn = $child->values['shop_turn_place_id'];
            $dataTurnPlaces[$turn]['quantity'] += $quantity;

            $product = $child->values['shop_product_id'];
            if (! key_exists($product, $dataProducts['data'])){
                $dataProducts['data'][$product] = array(
                    'data' => $turnPlaces,
                    'name' => $child->getElementValue('shop_product_id'),
                    'quantity' => 0
                );
            }

            $dataProducts['data'][$product]['data'][$turn]['quantity'] += $quantity;
            $dataProducts['data'][$product]['quantity'] += $quantity;
            $dataProducts['quantity'] += $quantity;
        }

        uasort($dataProducts['data'], array($this, 'mySortMethod'));

        /***************************************************/
        /************* ПЕРЕМЕЩЕНИЕ СО/НА СКЛАД *************/
        $dataMoveStorages = array(
            'data' => array(),
            'quantity_in' => 0,
            'quantity_out' => 0,
        );
        foreach ($shopProductStorageIDs->childs as $child){
            $quantity = $child->values['quantity'];

            $product = $child->values['shop_product_id'];
            if (! key_exists($product, $dataMoveStorages['data'])){
                $dataMoveStorages['data'][$product] = array(
                    'name' => $child->getElementValue('shop_product_id'),
                    'quantity_in' => 0,
                    'quantity_out' => 0,
                );
            }

            $dataMoveStorages['data'][$product]['quantity_in'] += $quantity;
            $dataMoveStorages['quantity_in'] += $quantity;
        }

        $params = Request_RequestParams::setParams(
            array(
                'shop_product_id' => $shopProductIDs,
                'shop_storage_id_from' => 0,
                'shop_id.main_shop_id'=> $this->_sitePageData->shopMainID,
                'sort_by' => array('shop_product_id' => 'asc')
            )
        );
        $ids = Api_Ab1_Shop_Car::getExitShopCar(
            $dateFrom, $dateTo, $this->_sitePageData, $this->_driverDB,
            array('shop_turn_place_id' => array('name'), 'shop_product_id' => array('name')),
            $params, true, null
        );

        foreach ($ids->childs as $child){
            if($child->values['shop_storage_id'] < 1){
                continue;
            }

            $quantity = $child->values['quantity'];

            $product = $child->values['shop_product_id'];
            if (! key_exists($product, $dataMoveStorages['data'])){
                $dataMoveStorages['data'][$product] = array(
                    'name' => $child->getElementValue('shop_product_id'),
                    'quantity_in' => 0,
                    'quantity_out' => 0,
                );
            }

            $dataMoveStorages['data'][$product]['quantity_out'] += $quantity;
            $dataMoveStorages['quantity_out'] += $quantity;
        }

        /**********************************************/
        /************* ОСТАТКИ НА СКЛАДАХ *************/
        $params = Request_RequestParams::setParams(
            array(
                'shop_product_id' => $shopProductIDs,
                'created_at_to' => $dateTo,
                'sum_quantity' => true,
                'shop_id.main_shop_id'=> $this->_sitePageData->shopMainID,
                'group_by' => array(
                    'shop_product_id', 'shop_product_id.name',
                )
            )
        );

        // получаем список
        $shopProductStorageIDs = Request_Request::find('DB_Ab1_Shop_Product_Storage',
            0, $this->_sitePageData, $this->_driverDB,
            $params, 0, true,
            array(
                'shop_product_id' => array('name'),
            )
        );

        $dataTotalStorages = array(
            'data' => array(),
            'quantity' => 0,
        );
        foreach ($shopProductStorageIDs->childs as $child){
            $quantity = $child->values['quantity'];

            $product = $child->values['shop_product_id'];
            if (! key_exists($product, $dataTotalStorages['data'])){
                $dataTotalStorages['data'][$product] = array(
                    'name' => $child->getElementValue('shop_product_id'),
                    'quantity' => 0,
                );
            }

            $dataTotalStorages['data'][$product]['quantity'] += $quantity;
            $dataTotalStorages['quantity'] += $quantity;
        }

        // выпущенно продукции на заданный период
        $params = Request_RequestParams::setParams(
            array(
                'shop_product_id' => $shopProductIDs,
                'sort_by' => array('shop_product_id' => 'asc'),
                'shop_storage_id_from' => 0,
                'sum_quantity' => true,
                'shop_id.main_shop_id'=> $this->_sitePageData->shopMainID,
                'group_by' => array(
                    'shop_product_id', 'shop_product_id.name',
                )
            )
        );
        $ids = Api_Ab1_Shop_Car::getExitShopCar(
            null, $dateTo, $this->_sitePageData, $this->_driverDB,
            array('shop_product_id' => array('name')),
            $params, true, null
        );

        // соединяем с внутренним перемещением
        $ids->childs = array_merge(
            $ids->childs,
            Api_Ab1_Shop_Move_Car::getExitShopMoveCar(
                $dateFrom, $dateTo, $this->_sitePageData, $this->_driverDB,
                array('shop_product_id' => array('name')),
                $params, true
            )->childs
        );

        // соединяем с внутренним перемещением
        $ids->childs = array_merge(
            $ids->childs,
            Api_Ab1_Shop_Defect_Car::getExitShopDefectCar(
                $dateFrom, $dateTo, $this->_sitePageData, $this->_driverDB,
                array('shop_product_id' => array('name')),
                $params, true
            )->childs
        );

        // реализация + перемещение
        foreach ($ids->childs as $child) {
            $quantity = $child->values['quantity'];

            $product = $child->values['shop_product_id'];
            if (!key_exists($product, $dataTotalStorages['data'])) {
                $dataTotalStorages['data'][$product] = array(
                    'name' => $child->getElementValue('shop_product_id'),
                    'quantity' => 0,
                );
            }

            $dataTotalStorages['data'][$product]['quantity'] -= $quantity;
            $dataTotalStorages['quantity'] -= $quantity;
        }

        $viewObject = 'ab1/_report/'.$this->_sitePageData->languageID.'/realization/asu-branch';
        $tmp = str_replace('\\', '/', $viewObject);
        try {
            $view = View::factory($tmp);
        }catch (Exception $e) {
            throw new Exception('Шаблон "'.$tmp.'" не найден.');
        }

        $view->makes = $dataMakes;
        $view->totalStorages = $dataTotalStorages;
        $view->moveStorages = $dataMoveStorages;
        $view->turnPlaceStorages = $dataTurnPlaceStorages;
        $view->products = $dataProducts;
        $view->turnPlaces = $dataTurnPlaces;
        $view->operation = $this->_sitePageData->operation->getValues();
        $view->shop = $this->_sitePageData->shop->getName();
        $view->shopOptions = $this->_sitePageData->shop->getOptionsArray();
        $strView = Helpers_View::viewToStr($view);

        header('Content-Type: application/x-download;charset=UTF-8');
        // header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: filename="ВС18 Сводка по выпуску (АСУ/Место погрузки).xml"');
        header('Cache-Control: max-age=0');

        echo $strView;
        exit();
    }

    public function action_car_empty() {
        set_time_limit(36000);

        $this->_sitePageData->url = '/'.$this->actionURLName.'/shopreport/car_empty';

        $ids = Request_Request::find('DB_Ab1_Shop_Car', $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB,
            array('is_exit' => 1, 'quantity' => 0),0, TRUE,
            array('shop_client_id' => array('name')));

        $cars = array();
        foreach ($ids->childs as $child){
            $cars[] = $child->values;
        }

        $viewObject = 'ab1/_report/'.$this->_sitePageData->languageID.'/car/empty';
        $tmp = str_replace('\\', '/', $viewObject);
        try {
            $view = View::factory($tmp);
        }catch (Exception $e) {
            throw new Exception('Шаблон "'.$tmp.'" не найден.');
        }

        $view->cars = $cars;
        $view->operation = $this->_sitePageData->operation->getValues();
        $view->shop = $this->_sitePageData->shop->getName();
        $view->shopOptions = $this->_sitePageData->shop->getOptionsArray();
        $strView = Helpers_View::viewToStr($view);

        header('Content-Type: application/x-download;charset=UTF-8');
        // header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: filename="ВС05 Отчет по выпуску пустых машин.xml"');
        header('Cache-Control: max-age=0');

        echo $strView;
        exit();
    }

    /*
     * Сводка по перемещению продукции
     */
    public function action_move_products() {
        set_time_limit(36000);

        $this->_sitePageData->url = '/'.$this->actionURLName.'/shopreport/move_products';

        $shopProductIDs = NULL;

        $dateFrom = Request_RequestParams::getParamDateTime('created_at_from');
        $dateTo = Request_RequestParams::getParamDateTime('created_at_to');
        $params = Request_RequestParams::setParams(
            array(
                'shop_product_id' => $shopProductIDs,
            )
        );
        $ids = Api_Ab1_Shop_Move_Car::getExitShopMoveCar(
            $dateFrom, $dateTo, $this->_sitePageData, $this->_driverDB,
            array('shop_client_id' => array('name'), 'shop_product_id' => array('name')),
            $params
        );

        $products = array();
        foreach ($ids->childs as $child){
            $product = $child->values['shop_product_id'];
            if (! key_exists($product, $products)){
                $products[$product] = array(
                    'quantity' => 0,
                    'data' => array(),
                    'name' => $child->getElementValue('shop_product_id')
                );
            }
        }
        uasort($products, array($this, 'mySortMethod'));

        $dataProducts = $products;
        $dataClients = array(
            'data' => array(),
            'quantity' => 0,
        );
        foreach ($ids->childs as $child){
            $quantity = $child->values['quantity'];

            $product = $child->values['shop_product_id'];
            $dataProducts[$product]['quantity'] += $quantity;

            $client = $child->values['shop_client_id'];
            if (! key_exists($client, $dataClients['data'])){
                $dataClients['data'][$client] = array(
                    'data' => $products,
                    'name' => $child->getElementValue('shop_client_id'),
                    'quantity' => 0
                );
            }

            $dataClients['data'][$client]['data'][$product]['quantity'] += $quantity;
            $dataClients['data'][$client]['quantity'] += $quantity;
            $dataClients['quantity'] += $quantity;
        }
        uasort($dataClients['data'], array($this, 'mySortMethod'));

        $viewObject = 'ab1/_report/'.$this->_sitePageData->languageID.'/move-products';
        $tmp = str_replace('\\', '/', $viewObject);
        try {
            $view = View::factory($tmp);
        }catch (Exception $e) {
            throw new Exception('Шаблон "'.$tmp.'" не найден.');
        }

        $view->products = $dataProducts;
        $view->clients = $dataClients;
        $view->operation = $this->_sitePageData->operation->getValues();
        $view->shop = $this->_sitePageData->shop->getName();
        $view->shopOptions = $this->_sitePageData->shop->getOptionsArray();
        $strView = Helpers_View::viewToStr($view);

        header('Content-Type: application/x-download;charset=UTF-8');
        // header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: filename="ВС03 Сводка по перемещению продукции.xml"');
        header('Cache-Control: max-age=0');

        echo $strView;
        exit();
    }

    /*
     * ВС19 Сводка по возмещения брака продукции
     */
    public function action_defect_products() {
        set_time_limit(36000);

        $this->_sitePageData->url = '/'.$this->actionURLName.'/shopreport/defect_products';

        $shopProductIDs = NULL;

        $dateFrom = Request_RequestParams::getParamDateTime('created_at_from');
        $dateTo = Request_RequestParams::getParamDateTime('created_at_to');
        $params = Request_RequestParams::setParams(
            array(
                'shop_product_id' => $shopProductIDs,
            )
        );
        $ids = Api_Ab1_Shop_Defect_Car::getExitShopDefectCar(
            $dateFrom, $dateTo, $this->_sitePageData, $this->_driverDB,
            array('shop_client_id' => array('name'), 'shop_product_id' => array('name')),
            $params
        );

        $products = array();
        foreach ($ids->childs as $child){
            $product = $child->values['shop_product_id'];
            if (! key_exists($product, $products)){
                $products[$product] = array(
                    'quantity' => 0,
                    'data' => array(),
                    'name' => $child->getElementValue('shop_product_id')
                );
            }
        }
        uasort($products, array($this, 'mySortMethod'));

        $dataProducts = $products;
        $dataClients = array(
            'data' => array(),
            'quantity' => 0,
        );
        foreach ($ids->childs as $child){
            $quantity = $child->values['quantity'];

            $product = $child->values['shop_product_id'];
            $dataProducts[$product]['quantity'] += $quantity;

            $client = $child->values['shop_client_id'];
            if (! key_exists($client, $dataClients['data'])){
                $dataClients['data'][$client] = array(
                    'data' => $products,
                    'name' => $child->getElementValue('shop_client_id'),
                    'quantity' => 0
                );
            }

            $dataClients['data'][$client]['data'][$product]['quantity'] += $quantity;
            $dataClients['data'][$client]['quantity'] += $quantity;
            $dataClients['quantity'] += $quantity;
        }
        uasort($dataClients['data'], array($this, 'mySortMethod'));

        $viewObject = 'ab1/_report/'.$this->_sitePageData->languageID.'/defect/products';
        $tmp = str_replace('\\', '/', $viewObject);
        try {
            $view = View::factory($tmp);
        }catch (Exception $e) {
            throw new Exception('Шаблон "'.$tmp.'" не найден.');
        }

        $view->products = $dataProducts;
        $view->clients = $dataClients;
        $view->operation = $this->_sitePageData->operation->getValues();
        $view->shop = $this->_sitePageData->shop->getName();
        $view->shopOptions = $this->_sitePageData->shop->getOptionsArray();
        $strView = Helpers_View::viewToStr($view);

        header('Content-Type: application/x-download;charset=UTF-8');
        // header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: filename="ВС19 Сводка по возмещения брака продукции.xml"');
        header('Cache-Control: max-age=0');

        echo $strView;
        exit();
    }

    /**
     * АБ02 Отгружено продукции по машинам
     * @throws Exception
     */
    public function action_products() {
        set_time_limit(36000);

        $this->_sitePageData->url = '/'.$this->actionURLName.'/shopreport/products';

        $shopProductIDs = NULL;

        // подразделения оператора
        $isSubdivision = Request_RequestParams::getParamBoolean('is_subdivision');
        $shopSubdivisionIDs = Request_RequestParams::getParamInt('shop_subdivision_id');
        if($isSubdivision) {
            if (empty($shopSubdivisionIDs)) {
                $shopSubdivisionIDs = $this->_sitePageData->operation->getProductShopSubdivisionIDsArray();
            }
        }

        $dateFrom = Request_RequestParams::getParamDateTime('created_at_from');
        $dateTo = Request_RequestParams::getParamDateTime('created_at_to');
        $params = Request_RequestParams::setParams(
            array(
                'shop_product_id' => $shopProductIDs,
                'shop_subdivision_id' => $shopSubdivisionIDs,
            )
        );
        $ids = Api_Ab1_Shop_Car::getExitShopCar(
            $dateFrom, $dateTo,
            $this->_sitePageData, $this->_driverDB,
            array(
                'shop_client_id' => array('name'),
                'shop_product_id' => array('name'),
                'shop_driver_id' => array('name'),
                'cash_operation_id' => array('name'),
                'shop_turn_place_id' => array('name'),
            ),
            $params
        );

        $dataProducts = array(
            'data' => array(),
            'quantity' => 0,
            'amount' => 0,
        );
        foreach ($ids->childs as $child){
            $quantity = $child->values['quantity'];
            $amount = $child->values['amount'];

            $dataProducts['data'][] = array(
                'created_at' => Helpers_DateTime::getDateTimeRusWithoutSeconds($child->values['created_at']).':00',
                'exit_at' => Helpers_DateTime::getDateTimeRusWithoutSeconds($child->values['exit_at']).':00',
                'weighted_entry_at' => Helpers_DateTime::getDateTimeRusWithoutSeconds($child->values['weighted_entry_at']).':00',
                'shop_client_name' => $child->getElementValue('shop_client_id'),
                'name' => $child->values['name'],
                'shop_driver_name' => $child->getElementValue('shop_driver_id'),
                'shop_product_name' => $child->getElementValue('shop_product_id'),
                'tarra' => $child->values['tarra'],
                'quantity' => $quantity,
                'amount' => $amount,
                'shop_turn_place_name' => $child->getElementValue('shop_turn_place_id'),
                'cash_operation_name' => $child->getElementValue('cash_operation_id'),
            );

            $dataProducts['quantity'] += $quantity;
            $dataProducts['amount'] += $amount;
        }

        if($isSubdivision) {
            $ids = Api_Ab1_Shop_Piece_Item::getExitShopPieceItems(
                $dateFrom, $dateTo,
                $this->_sitePageData, $this->_driverDB,
                array(
                    'shop_client_id' => array('name'),
                    'shop_product_id' => array('name'),
                    'shop_piece_id.shop_driver_id' => array('name'),
                    'shop_piece_id.cash_operation_id' => array('name'),
                    'shop_piece_id' => array('name'),
                ),
                $params
            );

            foreach ($ids->childs as $child) {
                $quantity = $child->values['quantity'];
                $amount = $child->values['amount'];

                $dataProducts['data'][] = array(
                    'created_at' => Helpers_DateTime::getDateTimeRusWithoutSeconds($child->values['created_at']) . ':00',
                    'exit_at' => Helpers_DateTime::getDateTimeRusWithoutSeconds($child->values['created_at']) . ':00',
                    'weighted_entry_at' => Helpers_DateTime::getDateTimeRusWithoutSeconds($child->values['created_at']) . ':00',
                    'shop_client_name' => $child->getElementValue('shop_client_id'),
                    'name' => $child->getElementValue('shop_piece_id'),
                    'shop_driver_name' => $child->getElementValue('shop_driver_id'),
                    'shop_product_name' => $child->getElementValue('shop_product_id'),
                    'tarra' => 0,
                    'quantity' => $quantity,
                    'amount' => $amount,
                    'shop_turn_place_name' => $child->getElementValue('shop_turn_place_id'),
                    'cash_operation_name' => $child->getElementValue('cash_operation_id'),
                );

                $dataProducts['quantity'] += $quantity;
                $dataProducts['amount'] += $amount;
            }
        }

        uasort($dataProducts['data'], function ($x, $y) {
            return strcasecmp(strtotime($x['created_at']), strtotime($y['created_at']));
        });

        $viewObject = 'ab1/_report/'.$this->_sitePageData->languageID.'/products';
        $tmp = str_replace('\\', '/', $viewObject);
        try {
            $view = View::factory($tmp);
        }catch (Exception $e) {
            throw new Exception('Шаблон "'.$tmp.'" не найден.');
        }

        $view->products = $dataProducts;
        $view->operation = $this->_sitePageData->operation->getValues();
        $view->shop = $this->_sitePageData->shop->getName();
        $view->shopOptions = $this->_sitePageData->shop->getOptionsArray();
        $strView = Helpers_View::viewToStr($view);

        header('Content-Type: application/x-download;charset=UTF-8');
        // header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: filename="АБ02 Отгружено продукции по машинам.xml"');
        header('Cache-Control: max-age=0');

        echo $strView;
        exit();
    }

    public function action_car_registry() {
        set_time_limit(36000);

        $this->_sitePageData->url = '/'.$this->actionURLName.'/shopreport/car_registry';

        $shopProductIDs = Api_Ab1_Shop_Product::findAllByMainRubric(
            Request_RequestParams::getParamInt('shop_product_rubric_id'),
            $this->_sitePageData, $this->_driverDB
        );

        $ids = Request_Request::find('DB_Ab1_Shop_Car', $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB,
            array('is_exit' => 1, 'quantity_from' => 0, 'shop_product_id' => array('value' => $shopProductIDs)),
            0, TRUE, array('shop_client_id' => array('name'), 'shop_delivery_id' => array('km'),
                'shop_product_id' => array('name')));

        $clients = array();
        foreach ($ids->childs as $child){
            $deliveryKm = $child->values['delivery_km'];
            if($deliveryKm <= 0){
                $deliveryKm = Arr::path($child->values, Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_delivery_id.km', 0);
            }
            $child->values['delivery_km'] = $deliveryKm;

            $clients[$child->id] = array(
                'shop_client_id' => $child->values['shop_client_id'],
                'name' => $child->values['name'],
                'delivery_km' => $deliveryKm,
                'shop_client_name' => $child->getElementValue('shop_client_id'),
            );
        }

        // список продукции
        $products = array();
        foreach ($ids->childs as $child){
            $product = $child->values['shop_product_id'];
            if (! key_exists($product, $products)){
                $products[$product] = array(
                    'quantity' => 0,
                    'delivery_km' => 0,
                    'data' => array(),
                    'name' => $child->getElementValue('shop_product_id')
                );
            }
        }
        uasort($products, array($this, 'mySortMethod'));

        $dataProducts = $products;
        $dataClients = array(
            'data' => array(),
            'quantity' => 0,
            'delivery_km' => 0,
        );
        foreach ($ids->childs as $child){
            $quantity = $child->values['quantity'];
            $delivery_km = $child->values['delivery_km'];

            $product = $child->values['shop_product_id'];
            $dataProducts[$product]['quantity'] += $quantity;

            $client = $child->values['shop_client_id'].'_'.$child->values['name'];
            if (! key_exists($client, $dataClients['data'])){
                $dataClients['data'][$client] = array(
                    'data' => $products,
                    'name' => $child->getElementValue('shop_client_id'),
                    'number' => $child->values['name'],
                    'quantity' => 0,
                    'delivery_km' => 0
                );
            }

            $dataClients['data'][$client]['data'][$product]['quantity'] += $quantity;
            $dataClients['data'][$client]['data'][$product]['delivery_km'] += $delivery_km;

            $dataClients['data'][$client]['quantity'] += $quantity;
            $dataClients['data'][$client]['delivery_km'] += $delivery_km;

            $dataClients['quantity'] += $quantity;
            $dataClients['delivery_km'] += $delivery_km;
        }

        uasort($dataClients['data'], array($this, 'mySortMethod'));

        $viewObject = 'ab1/_report/'.$this->_sitePageData->languageID.'/car-registry';
        $tmp = str_replace('\\', '/', $viewObject);
        try {
            $view = View::factory($tmp);
        }catch (Exception $e) {
            throw new Exception('Шаблон "'.$tmp.'" не найден.');
        }

        $view->products = $dataProducts;
        $view->clients = $dataClients;
        $view->operation = $this->_sitePageData->operation->getValues();
        $view->shop = $this->_sitePageData->shop->getName();
        $view->shopOptions = $this->_sitePageData->shop->getOptionsArray();
        $strView = Helpers_View::viewToStr($view);

        header('Content-Type: application/x-download;charset=UTF-8');
        // header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: filename="МС05 Реестр машин реализации продукции.xml"');
        header('Cache-Control: max-age=0');

        echo $strView;
        exit();
    }

    /**
     * МС10 Реестр машин ЖБИ и БС
     * @throws Exception
     * @throws HTTP_Exception_404
     */
    public function action_piece_registry() {
        set_time_limit(36000);

        $this->_sitePageData->url = '/'.$this->actionURLName.'/shopreport/piece_registry';

        $isSubdivision = Request_RequestParams::getParamBoolean('is_subdivision');

        // подразделения оператора
        if($isSubdivision) {
            $shopSubdivisionIDs = Request_RequestParams::getParamInt('shop_subdivision_id');
            if (empty($shopSubdivisionIDs)) {
                $shopSubdivisionIDs = $this->_sitePageData->operation->getProductShopSubdivisionIDsArray();
            }
        }else{
            $shopSubdivisionIDs = null;
        }

        $params = array(
            'shop_subdivision_id' => $shopSubdivisionIDs,
            'is_exit' => 1,
        );

        $ids = Request_Request::find(
            'DB_Ab1_Shop_Piece',
            $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB,
            $params, 0, TRUE,
            array('shop_client_id' => array('name'), 'shop_delivery_id' => array('km'))
        );

        $clients = array();
        foreach ($ids->childs as $child){
            $deliveryKm = $child->values['delivery_km'];
            if($deliveryKm <= 0){
                $deliveryKm = Arr::path($child->values, Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_delivery_id.km', 0);
            }

            $clients[$child->id] = array(
                'shop_client_id' => $child->values['shop_client_id'],
                'name' => $child->values['name'],
                'delivery_km' => $deliveryKm,
                'shop_client_name' => $child->getElementValue('shop_client_id'),
            );
        }

        if (count($ids->childs) > 0) {
            $shopProductRubricID = Request_RequestParams::getParamInt('shop_product_rubric_id');
            if ($shopProductRubricID > 0) {
                $modelRubric = new Model_Ab1_Shop_Product_Rubric();
                $modelRubric->setDBDriver($this->_driverDB);
                if (!(($shopProductRubricID > 0) && (Helpers_DB::getDBObject($modelRubric, $shopProductRubricID, $this->_sitePageData)))) {
                    throw new HTTP_Exception_404('Turn type not found.');
                }

                $shopProductIDs = Api_Ab1_Shop_Product::findAllByMainRubric(
                    $shopProductRubricID, $this->_sitePageData, $this->_driverDB
                );
            }else{
                $shopProductIDs = NULL;
            }

            $ids = Request_Request::find('DB_Ab1_Shop_Piece_Item', $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB,
                array('shop_piece_id' => array('value' => $ids->getChildArrayID()), 'quantity_from' => 0,
                    'shop_product_id' => array('value' => $shopProductIDs), Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE),
                0, TRUE, array('shop_product_id' => array('name')));
        }

        // список продукции
        $products = array();
        foreach ($ids->childs as $child){
            $product = $child->values['shop_product_id'];
            if (! key_exists($product, $products)){
                $products[$product] = array(
                    'quantity' => 0,
                    'delivery_km' => 0,
                    'data' => array(),
                    'name' => $child->getElementValue('shop_product_id')
                );
            }
        }
        uasort($products, array($this, 'mySortMethod'));

        $dataProducts = $products;
        $dataClients = array(
            'data' => array(),
            'quantity' => 0,
            'delivery_km' => 0,
        );
        foreach ($ids->childs as $child){
            $car = $clients[$child->values['shop_piece_id']];

            $quantity = $child->values['quantity'];
            $delivery_km = $car['delivery_km'];

            $product = $child->values['shop_product_id'];
            $dataProducts[$product]['quantity'] += $quantity;

            $client = $car['shop_client_id'].'_'.$car['name'];
            if (! key_exists($client, $dataClients['data'])){
                $dataClients['data'][$client] = array(
                    'data' => $products,
                    'name' => $car['shop_client_name'],
                    'number' => $car['name'],
                    'quantity' => 0,
                    'delivery_km' => 0
                );
            }

            $dataClients['data'][$client]['data'][$product]['quantity'] += $quantity;
            $dataClients['data'][$client]['data'][$product]['delivery_km'] += $delivery_km;

            $dataClients['data'][$client]['quantity'] += $quantity;
            $dataClients['data'][$client]['delivery_km'] += $delivery_km;

            $dataClients['quantity'] += $quantity;
            $dataClients['delivery_km'] += $delivery_km;
        }

        uasort($dataClients['data'], array($this, 'mySortMethod'));

        $viewObject = 'ab1/_report/'.$this->_sitePageData->languageID.'/piece-registry';
        $tmp = str_replace('\\', '/', $viewObject);
        try {
            $view = View::factory($tmp);
        }catch (Exception $e) {
            throw new Exception('Шаблон "'.$tmp.'" не найден.');
        }

        $view->products = $dataProducts;
        $view->clients = $dataClients;
        $view->operation = $this->_sitePageData->operation->getValues();
        $view->shop = $this->_sitePageData->shop->getName();
        $view->shopOptions = $this->_sitePageData->shop->getOptionsArray();
        $strView = Helpers_View::viewToStr($view);

        header('Content-Type: application/x-download;charset=UTF-8');
        // header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: filename="МС10 Реестр машин ЖБИ и БС.xml"');
        header('Cache-Control: max-age=0');

        echo $strView;
        exit();
    }

    /**
     * МС08 Отгружено продукции по рубрикам ЖБИ и БС
     * @throws Exception
     */
    public function action_piece_products_rubric() {
        set_time_limit(36000);

        $this->_sitePageData->url = '/'.$this->actionURLName.'/shopreport/piece_products_rubric';

        $ids = Request_Request::find(
            'DB_Ab1_Shop_Piece', $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB,
            array('is_exit' => 1)
        );

        if (count($ids->childs) > 0) {
            $shopProductIDs = NULL;
            $ids = Request_Request::find(
                'DB_Ab1_Shop_Piece_Item', $this->_sitePageData->shopID,
                $this->_sitePageData, $this->_driverDB,
                Request_RequestParams::setParams(
                    array(
                        'shop_piece_id' => $ids->getChildArrayID(),
                        'quantity_from' => 0,
                        'shop_product_id' => $shopProductIDs,
                        'sum_quantity' => true,
                        'sum_amount' => true,
                        'group_by' => array(
                            'shop_product_id', 'shop_product_id.name', 'shop_product_id.shop_product_rubric_id',
                        ),
                    )
                ),
                0, TRUE,
                array('shop_product_id' => array('name', 'shop_product_rubric_id'))
            );
        }

        $dataRubrics = array(
            'data' => array(),
            'quantity' => 0,
            'amount' => 0,
        );

        $rubricsByRoot = array();

        $rubrics = array();
        $model = new Model_Ab1_Shop_Product_Rubric();
        foreach ($ids->childs as $child){
            $quantity = $child->values['quantity'];
            $amount = $child->values['amount'];

            $rubric = Arr::path($child->values, Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_product_id.shop_product_rubric_id', '0');
            if (key_exists($rubric, $rubricsByRoot)) {
                $rubric = $rubricsByRoot[$rubric];
            }else{
                if ($this->getDBObject($model, $rubric)){
                    $rubric = $model->getRootID();
                    if($rubric < 1){
                        $rubric = $model->id;

                        $rubricsByRoot[$rubric] = $rubric;
                    }

                    if (!key_exists($rubric, $rubrics)) {
                        $this->getDBObject($model, $rubric);
                        $rubrics[$rubric]['id'] = $rubric;
                        $rubrics[$rubric]['name'] = $model->getName();

                        $rubricsByRoot[$rubric] = $rubric;
                    }
                }else{
                    $rubric = 0;
                    $rubrics[0]['id'] = 0;
                    $rubrics[0]['name'] = '';
                }
            }

            if (! key_exists($rubric, $dataRubrics['data'])){
                $dataRubrics['data'][$rubric] = array(
                    'data' => array(),
                    'name' => $rubrics[$rubric]['name'],
                    'quantity' => 0,
                    'amount' => 0,
                );
            }

            $product = $child->values['shop_product_id'];
            if (! key_exists($product, $dataRubrics['data'][$rubric]['data'])){
                $dataRubrics['data'][$rubric]['data'][$product] = array(
                    'data' => array(),
                    'name' => $child->getElementValue('shop_product_id'),
                    'quantity' => 0,
                    'amount' => 0,
                );
            }

            $dataRubrics['data'][$rubric]['data'][$product]['quantity'] += $quantity;
            $dataRubrics['data'][$rubric]['data'][$product]['amount'] += $amount;

            $dataRubrics['data'][$rubric]['quantity'] += $quantity;
            $dataRubrics['data'][$rubric]['amount'] += $amount;

            $dataRubrics['quantity'] += $quantity;
            $dataRubrics['amount'] += $amount;
        }
        uasort($dataRubrics['data'], array($this, 'mySortMethod'));
        foreach ($dataRubrics['data'] as &$dataRubric){
            uasort($dataRubric['data'], array($this, 'mySortMethod'));
        }

        $viewObject = 'ab1/_report/'.$this->_sitePageData->languageID.'/product/rubric';
        $tmp = str_replace('\\', '/', $viewObject);
        try {
            $view = View::factory($tmp);
        }catch (Exception $e) {
            throw new Exception('Шаблон "'.$tmp.'" не найден.');
        }

        $view->rubrics = $dataRubrics;
        $view->operation = $this->_sitePageData->operation->getValues();
        $view->shop = $this->_sitePageData->shop->getName();
        $view->shopOptions = $this->_sitePageData->shop->getOptionsArray();
        $strView = Helpers_View::viewToStr($view);

        header('Content-Type: application/x-download;charset=UTF-8');
        // header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: filename="МС08 Отгружено продукции по рубрикам ЖБИ и БС.xml"');
        header('Cache-Control: max-age=0');

        echo $strView;
        exit();
    }

    /**
     * ЖБ01 Отгружено продукции по рубрикам
     * @throws Exception
     */
    public function action_product_rubric_department() {
        set_time_limit(36000);

        $this->_sitePageData->url = '/'.$this->actionURLName.'/shopreport/product_rubric_department';

        $dateFrom = Request_RequestParams::getParamDateTime('created_at_from');
        $dateTo = Request_RequestParams::getParamDateTime('created_at_to');

        // если заданы рубрика товаров, то находим список товаров
        $shopProductRubricID = Request_RequestParams::getParamInt('shop_product_rubric_id');
        if($shopProductRubricID > 0) {
            $modelRubric = new Model_Ab1_Shop_Product_Rubric();
            $modelRubric->setDBDriver($this->_driverDB);

            if (!(($shopProductRubricID > 0) && (Helpers_DB::getDBObject($modelRubric, $shopProductRubricID, $this->_sitePageData)))) {
                throw new HTTP_Exception_404('Product rubric not found.');
            }

            $shopProductIDs = Api_Ab1_Shop_Product::findAllByMainRubric(
                $shopProductRubricID, $this->_sitePageData, $this->_driverDB
            );
        }else{
            $shopProductIDs = NULL;
        }

        $ids = Api_Ab1_Shop_Piece_Item::getExitShopPieceItems(
            $dateFrom, $dateTo, $this->_sitePageData, $this->_driverDB,
            array('shop_product_id' => array('name', 'shop_product_rubric_id')),
            [
                'quantity_from' => 0,
                'shop_product_id' => $shopProductIDs,
                'sum_quantity' => true,
                'sum_amount' => true,
                'shop_subdivision_id' => $this->_sitePageData->operation->getProductShopSubdivisionIDsArray(),
                'group_by' => array(
                    'shop_product_id', 'shop_product_id.name', 'shop_product_id.shop_product_rubric_id',
                ),
            ]
        );

        $carIDs = Api_Ab1_Shop_Car::getExitShopCar(
            $dateFrom, $dateTo, $this->_sitePageData, $this->_driverDB,
            array('shop_product_id' => array('name', 'shop_product_rubric_id')),
            [
                'quantity_from' => 0,
                'shop_product_id' => $shopProductIDs,
                'sum_quantity' => true,
                'sum_amount' => true,
                'shop_subdivision_id' => $this->_sitePageData->operation->getProductShopSubdivisionIDsArray(),
                'group_by' => array(
                    'shop_product_id', 'shop_product_id.name', 'shop_product_id.shop_product_rubric_id',
                ),
            ]
        );
        $ids->addChilds($carIDs);

        $dataRubrics = array(
            'data' => array(),
            'quantity' => 0,
            'amount' => 0,
        );

        $rubricsByRoot = array();

        $rubrics = array();
        $model = new Model_Ab1_Shop_Product_Rubric();
        foreach ($ids->childs as $child){
            $quantity = $child->values['quantity'];
            $amount = $child->values['amount'];

            $rubric = Arr::path($child->values, Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_product_id.shop_product_rubric_id', '0');
            if (key_exists($rubric, $rubricsByRoot)) {
                $rubric = $rubricsByRoot[$rubric];
            }else{
                if ($this->getDBObject($model, $rubric)){
                    $rubric = $model->getRootID();
                    if($rubric < 1){
                        $rubric = $model->id;

                        $rubricsByRoot[$rubric] = $rubric;
                    }

                    if (!key_exists($rubric, $rubrics)) {
                        $this->getDBObject($model, $rubric);
                        $rubrics[$rubric]['id'] = $rubric;
                        $rubrics[$rubric]['name'] = $model->getName();

                        $rubricsByRoot[$rubric] = $rubric;
                    }
                }else{
                    $rubric = 0;
                    $rubrics[0]['id'] = 0;
                    $rubrics[0]['name'] = '';
                }
            }

            if (! key_exists($rubric, $dataRubrics['data'])){
                $dataRubrics['data'][$rubric] = array(
                    'data' => array(),
                    'name' => $rubrics[$rubric]['name'],
                    'quantity' => 0,
                    'amount' => 0,
                );
            }

            $product = $child->values['shop_product_id'];
            if (! key_exists($product, $dataRubrics['data'][$rubric]['data'])){
                $dataRubrics['data'][$rubric]['data'][$product] = array(
                    'data' => array(),
                    'name' => $child->getElementValue('shop_product_id'),
                    'quantity' => 0,
                    'amount' => 0,
                );
            }

            $dataRubrics['data'][$rubric]['data'][$product]['quantity'] += $quantity;
            $dataRubrics['data'][$rubric]['data'][$product]['amount'] += $amount;

            $dataRubrics['data'][$rubric]['quantity'] += $quantity;
            $dataRubrics['data'][$rubric]['amount'] += $amount;

            $dataRubrics['quantity'] += $quantity;
            $dataRubrics['amount'] += $amount;
        }
        uasort($dataRubrics['data'], array($this, 'mySortMethod'));
        foreach ($dataRubrics['data'] as &$dataRubric){
            uasort($dataRubric['data'], array($this, 'mySortMethod'));
        }

        $viewObject = 'ab1/_report/'.$this->_sitePageData->languageID.'/product/rubric-department';
        $tmp = str_replace('\\', '/', $viewObject);
        try {
            $view = View::factory($tmp);
        }catch (Exception $e) {
            throw new Exception('Шаблон "'.$tmp.'" не найден.');
        }

        $view->rubrics = $dataRubrics;
        $view->operation = $this->_sitePageData->operation->getValues();
        $view->shop = $this->_sitePageData->shop->getName();
        $view->shopOptions = $this->_sitePageData->shop->getOptionsArray();
        $strView = Helpers_View::viewToStr($view);

        header('Content-Type: application/x-download;charset=UTF-8');
        // header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: filename="ЖБ01 Отгружено продукции по рубрикам.xml"');
        header('Cache-Control: max-age=0');

        echo $strView;
        exit();
    }

    /**
     * СБ13 Отгружено продукции по рубрикам
     * @throws Exception
     */
    public function action_product_rubric_departments() {
        set_time_limit(36000);

        $this->_sitePageData->url = '/'.$this->actionURLName.'/shopreport/product_rubric_departments';

        $dateFrom = Request_RequestParams::getParamDateTime('created_at_from');
        $dateTo = Request_RequestParams::getParamDateTime('created_at_to');

        $shopSubdivisionID = Request_RequestParams::getParam('shop_subdivision_id');

        $shopProductIDs = NULL;
        $ids = Api_Ab1_Shop_Piece_Item::getExitShopPieceItems(
            $dateFrom, $dateTo, $this->_sitePageData, $this->_driverDB,
            array('shop_product_id' => array('name', 'shop_product_rubric_id')),
            [
                'quantity_from' => 0,
                'shop_product_id' => $shopProductIDs,
                'sum_quantity' => true,
                'sum_amount' => true,
                'shop_subdivision_id' => $shopSubdivisionID,
                'group_by' => array(
                    'shop_product_id', 'shop_product_id.name', 'shop_product_id.shop_product_rubric_id',
                ),
            ]
        );

        $carIDs = Api_Ab1_Shop_Car::getExitShopCar(
            $dateFrom, $dateTo, $this->_sitePageData, $this->_driverDB,
            array('shop_product_id' => array('name', 'shop_product_rubric_id')),
            [
                'quantity_from' => 0,
                'shop_product_id' => $shopProductIDs,
                'sum_quantity' => true,
                'sum_amount' => true,
                'shop_subdivision_id' => $shopSubdivisionID,
                'group_by' => array(
                    'shop_product_id', 'shop_product_id.name', 'shop_product_id.shop_product_rubric_id',
                ),
            ]
        );
        $ids->addChilds($carIDs);

        $dataRubrics = array(
            'data' => array(),
            'quantity' => 0,
            'amount' => 0,
        );

        $rubricsByRoot = array();

        $rubrics = array();
        $model = new Model_Ab1_Shop_Product_Rubric();
        foreach ($ids->childs as $child){
            $quantity = $child->values['quantity'];
            $amount = $child->values['amount'];

            $rubric = Arr::path($child->values, Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_product_id.shop_product_rubric_id', '0');
            if (key_exists($rubric, $rubricsByRoot)) {
                $rubric = $rubricsByRoot[$rubric];
            }else{
                if ($this->getDBObject($model, $rubric)){
                    $rubric = $model->getRootID();
                    if($rubric < 1){
                        $rubric = $model->id;

                        $rubricsByRoot[$rubric] = $rubric;
                    }

                    if (!key_exists($rubric, $rubrics)) {
                        $this->getDBObject($model, $rubric);
                        $rubrics[$rubric]['id'] = $rubric;
                        $rubrics[$rubric]['name'] = $model->getName();

                        $rubricsByRoot[$rubric] = $rubric;
                    }
                }else{
                    $rubric = 0;
                    $rubrics[0]['id'] = 0;
                    $rubrics[0]['name'] = '';
                }
            }

            if (! key_exists($rubric, $dataRubrics['data'])){
                $dataRubrics['data'][$rubric] = array(
                    'data' => array(),
                    'name' => $rubrics[$rubric]['name'],
                    'quantity' => 0,
                    'amount' => 0,
                );
            }

            $product = $child->values['shop_product_id'];
            if (! key_exists($product, $dataRubrics['data'][$rubric]['data'])){
                $dataRubrics['data'][$rubric]['data'][$product] = array(
                    'data' => array(),
                    'name' => $child->getElementValue('shop_product_id'),
                    'quantity' => 0,
                    'amount' => 0,
                );
            }

            $dataRubrics['data'][$rubric]['data'][$product]['quantity'] += $quantity;
            $dataRubrics['data'][$rubric]['data'][$product]['amount'] += $amount;

            $dataRubrics['data'][$rubric]['quantity'] += $quantity;
            $dataRubrics['data'][$rubric]['amount'] += $amount;

            $dataRubrics['quantity'] += $quantity;
            $dataRubrics['amount'] += $amount;
        }
        uasort($dataRubrics['data'], array($this, 'mySortMethod'));
        foreach ($dataRubrics['data'] as &$dataRubric){
            uasort($dataRubric['data'], array($this, 'mySortMethod'));
        }

        $viewObject = 'ab1/_report/'.$this->_sitePageData->languageID.'/product/rubric-departments';
        $tmp = str_replace('\\', '/', $viewObject);
        try {
            $view = View::factory($tmp);
        }catch (Exception $e) {
            throw new Exception('Шаблон "'.$tmp.'" не найден.');
        }

        $view->rubrics = $dataRubrics;
        $view->operation = $this->_sitePageData->operation->getValues();
        $view->shop = $this->_sitePageData->shop->getName();
        $view->shopOptions = $this->_sitePageData->shop->getOptionsArray();
        $strView = Helpers_View::viewToStr($view);

        header('Content-Type: application/x-download;charset=UTF-8');
        // header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: filename="СБ13 Отгружено продукции по рубрикам.xml"');
        header('Cache-Control: max-age=0');

        echo $strView;
        exit();
    }

    /**
     * МС09 Отгружено продукции по клиентам ЖБИ и БС
     * @throws Exception
     * @throws HTTP_Exception_404
     */
    public function action_piece_products_client() {
        set_time_limit(36000);

        $this->_sitePageData->url = '/'.$this->actionURLName.'/shopreport/piece_products_client';

        // если заданы рубрика товаров, то находим список товаров
        $shopProductRubricID = Request_RequestParams::getParamInt('shop_product_rubric_id');
        if($shopProductRubricID > 0) {
            $modelRubric = new Model_Ab1_Shop_Product_Rubric();
            $modelRubric->setDBDriver($this->_driverDB);

            if (!(($shopProductRubricID > 0) && (Helpers_DB::getDBObject($modelRubric, $shopProductRubricID, $this->_sitePageData)))) {
                throw new HTTP_Exception_404('Product rubric not found.');
            }

            $shopProductIDs = Api_Ab1_Shop_Product::findAllByMainRubric(
                $shopProductRubricID, $this->_sitePageData, $this->_driverDB
            );
        }else{
            $shopProductIDs = NULL;
        }


        $isSubdivision = Request_RequestParams::getParamBoolean('is_subdivision');

        // подразделения оператора
        if($isSubdivision) {
            $shopSubdivisionIDs = Request_RequestParams::getParamInt('shop_subdivision_id');
            if (empty($shopSubdivisionIDs)) {
                $shopSubdivisionIDs = $this->_sitePageData->operation->getProductShopSubdivisionIDsArray();
            }
        }else{
            $shopSubdivisionIDs = null;
        }

        $dateFrom = Request_RequestParams::getParamDateTime('created_at_from');
        $dateTo = Request_RequestParams::getParamDateTime('created_at_to');

        $ids = Api_Ab1_Shop_Piece_Item::getExitShopPieceItems(
            $dateFrom, $dateTo, $this->_sitePageData, $this->_driverDB,
            array(
                'shop_product_id' => array('name', 'shop_product_rubric_id'),
                'root_rubric_id' => array('name'),
                'shop_client_id' => array('name'),
            ),
            [
                'shop_subdivision_id' => $shopSubdivisionIDs,
                'quantity_from' => 0,
                'shop_product_id' => $shopProductIDs,
                'sum_quantity' => true,
                'sum_amount' => true,
                'shop_client_id' => Request_RequestParams::getParamInt('shop_client_id'),
                'group_by' => array(
                    'shop_product_id', 'shop_product_id.name', 'shop_product_id.shop_product_rubric_id',
                    'shop_client_attorney_id',
                    'shop_client_id', 'shop_client_id.name',
                    'root_rubric_id.name',
                )
            ]
        );

        $dataAttorneys = array(
            'data' => array(),
            'quantity' => 0,
            'amount' => 0,
        );

        foreach ($ids->childs as $child){
            $quantity = $child->values['quantity'];
            $amount = $child->values['amount'];

            $attorney = $child->values['shop_client_attorney_id'];
            if($attorney > 0){
                $attorney = 1;
            }
            if (! key_exists($attorney, $dataAttorneys['data'])){
                if($attorney == 1){
                    $nameAttorney = 'По доверенности';
                }else{
                    $nameAttorney = 'Без доверенности';
                }

                $dataAttorneys['data'][$attorney] = array(
                    'name' => $nameAttorney,
                    'data' => array(),
                    'quantity' => 0,
                    'amount' => 0,
                );
            }

            $client = $child->values['shop_client_id'];
            if (! key_exists($client, $dataAttorneys['data'][$attorney]['data'])){
                $dataAttorneys['data'][$attorney]['data'][$client] = array(
                    'data' => array(),
                    'name' =>  $child->getElementValue('shop_client_id'),
                    'quantity' => 0,
                    'amount' => 0,
                );
            }

            $rubric = Arr::path($child->values, Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_product_id.shop_product_rubric_id', '0');
            if (! key_exists($rubric, $dataAttorneys['data'][$attorney]['data'][$client]['data'])){
                $dataAttorneys['data'][$attorney]['data'][$client]['data'][$rubric] = array(
                    'data' => array(),
                    'name' => $child->getElementValue('root_rubric_id'),
                    'quantity' => 0,
                    'amount' => 0,
                );
            }

            $product = $child->values['shop_product_id'];
            if (! key_exists($product, $dataAttorneys['data'][$attorney]['data'][$client]['data'][$rubric]['data'])){
                $dataAttorneys['data'][$attorney]['data'][$client]['data'][$rubric]['data'][$product] = array(
                    'data' => array(),
                    'name' => $child->getElementValue('shop_product_id'),
                    'quantity' => 0,
                    'amount' => 0,
                );
            }

            $dataAttorneys['data'][$attorney]['data'][$client]['data'][$rubric]['data'][$product]['quantity'] += $quantity;
            $dataAttorneys['data'][$attorney]['data'][$client]['data'][$rubric]['data'][$product]['amount'] += $amount;

            $dataAttorneys['data'][$attorney]['data'][$client]['data'][$rubric]['quantity'] += $quantity;
            $dataAttorneys['data'][$attorney]['data'][$client]['data'][$rubric]['amount'] += $amount;

            $dataAttorneys['data'][$attorney]['data'][$client]['quantity'] += $quantity;
            $dataAttorneys['data'][$attorney]['data'][$client]['amount'] += $amount;

            $dataAttorneys['data'][$attorney]['quantity'] += $quantity;
            $dataAttorneys['data'][$attorney]['amount'] += $amount;

            $dataAttorneys['quantity'] += $quantity;
            $dataAttorneys['amount'] += $amount;
        }
        uasort($dataAttorneys['data'], array($this, 'mySortMethod'));
        foreach ($dataAttorneys['data'] as &$dataClients) {
            uasort($dataClients['data'], array($this, 'mySortMethod'));
            foreach ($dataClients['data'] as &$dataClient) {
                uasort($dataClient['data'], array($this, 'mySortMethod'));
                foreach ($dataClient['data'] as &$dataRubric) {
                    uasort($dataRubric['data'], array($this, 'mySortMethod'));
                }
            }
        }

        $viewObject = 'ab1/_report/'.$this->_sitePageData->languageID.'/product/client';
        $tmp = str_replace('\\', '/', $viewObject);
        try {
            $view = View::factory($tmp);
        }catch (Exception $e) {
            throw new Exception('Шаблон "'.$tmp.'" не найден.');
        }

        $view->attorneys = $dataAttorneys;
        $view->isCharity = false;
        $view->isZHBI = true;
        $view->operation = $this->_sitePageData->operation->getValues();
        $view->shop = $this->_sitePageData->shop->getName();
        $view->shopOptions = $this->_sitePageData->shop->getOptionsArray();
        $strView = Helpers_View::viewToStr($view);

        header('Content-Type: application/x-download;charset=UTF-8');
        // header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: filename="МС09 Отгружено продукции по клиентам ЖБИ и БС.xml"');
        header('Cache-Control: max-age=0');

        echo $strView;
        exit();
    }

    /**
     * МС03 Отгружено продукции по рубрикам
     * @throws Exception
     */
    public function action_products_rubric() {
        set_time_limit(36000);

        $this->_sitePageData->url = '/'.$this->actionURLName.'/shopreport/products_rubric';

        $shopProductIDs = NULL;

        $dateFrom = Request_RequestParams::getParamDateTime('created_at_from');
        $dateTo = Request_RequestParams::getParamDateTime('created_at_to');
        $params = Request_RequestParams::setParams(
            array(
                'shop_product_id' => $shopProductIDs,
                'sum_quantity' => true,
                'sum_amount' => true,
                'group_by' => array(
                    'shop_product_id', 'shop_product_id.name', 'shop_product_id.shop_product_rubric_id',
                ),
            )
        );
        $ids = Api_Ab1_Shop_Car::getExitShopCar(
            $dateFrom, $dateTo, $this->_sitePageData, $this->_driverDB,
            array('shop_product_id' => array('name', 'shop_product_rubric_id')), $params
        );

        $pieceIDs = Api_Ab1_Shop_Piece::getExitShopPieces(
            $dateFrom, $dateTo, $this->_sitePageData, $this->_driverDB
        );
        if(count($pieceIDs->childs) > 0) {
            $params = Request_RequestParams::setParams(
                array(
                    'shop_piece_id' => $pieceIDs->getChildArrayID(),
                    'quantity_from' => 0,
                    'shop_product_id' => $shopProductIDs
                )
            );

            $pieceItemIDs = Request_Request::find('DB_Ab1_Shop_Piece_Item',
                $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB,
                $params, 0, TRUE,
                array('shop_product_id' => array('name', 'shop_product_rubric_id'))
            );

            $ids->childs = array_merge($ids->childs, $pieceItemIDs->childs);
        }

        $dataRubrics = array(
            'data' => array(),
            'quantity' => 0,
            'amount' => 0,
        );

        $rubricsByRoot = array();

        $rubrics = array();
        $model = new Model_Ab1_Shop_Product_Rubric();
        foreach ($ids->childs as $child){
            $quantity = $child->values['quantity'];
            $amount = $child->values['amount'];

            $rubric = Arr::path($child->values, Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_product_id.shop_product_rubric_id', '0');
            if (key_exists($rubric, $rubricsByRoot)) {
                $rubric = $rubricsByRoot[$rubric];
            }else{
                if ($this->getDBObject($model, $rubric, 0)){
                    $rubric = $model->getRootID();
                    if($rubric < 1){
                        $rubric = $model->id;

                        $rubricsByRoot[$rubric] = $rubric;
                    }

                    if (!key_exists($rubric, $rubrics)) {
                        $this->getDBObject($model, $rubric, 0);
                        $rubrics[$rubric]['id'] = $rubric;
                        $rubrics[$rubric]['name'] = $model->getName();

                        $rubricsByRoot[$rubric] = $rubric;
                    }
                }else{
                    $rubric = 0;
                    $rubrics[0]['id'] = 0;
                    $rubrics[0]['name'] = '';
                }
            }

            if (! key_exists($rubric, $dataRubrics['data'])){
                $dataRubrics['data'][$rubric] = array(
                    'data' => array(),
                    'name' => $rubrics[$rubric]['name'],
                    'quantity' => 0,
                    'amount' => 0,
                );
            }

            $product = $child->values['shop_product_id'];
            if (! key_exists($product, $dataRubrics['data'][$rubric]['data'])){
                $dataRubrics['data'][$rubric]['data'][$product] = array(
                    'data' => array(),
                    'name' => $child->getElementValue('shop_product_id'),
                    'quantity' => 0,
                    'amount' => 0,
                );
            }

            $dataRubrics['data'][$rubric]['data'][$product]['quantity'] += $quantity;
            $dataRubrics['data'][$rubric]['data'][$product]['amount'] += $amount;

            $dataRubrics['data'][$rubric]['quantity'] += $quantity;
            $dataRubrics['data'][$rubric]['amount'] += $amount;

            $dataRubrics['quantity'] += $quantity;
            $dataRubrics['amount'] += $amount;
        }
        uasort($dataRubrics['data'], array($this, 'mySortMethod'));
        foreach ($dataRubrics['data'] as &$dataRubric){
            uasort($dataRubric['data'], array($this, 'mySortMethod'));
        }

        $viewObject = 'ab1/_report/'.$this->_sitePageData->languageID.'/product/rubric';
        $tmp = str_replace('\\', '/', $viewObject);
        try {
            $view = View::factory($tmp);
        }catch (Exception $e) {
            throw new Exception('Шаблон "'.$tmp.'" не найден.');
        }

        $view->rubrics = $dataRubrics;
        $view->operation = $this->_sitePageData->operation->getValues();
        $view->shop = $this->_sitePageData->shop->getName();
        $view->shopOptions = $this->_sitePageData->shop->getOptionsArray();
        $strView = Helpers_View::viewToStr($view);

        header('Content-Type: application/x-download;charset=UTF-8');
        // header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: filename="МС03 Отгружено продукции по рубрикам.xml"');
        header('Cache-Control: max-age=0');

        echo $strView;
        exit();
    }

    /**
     * АБ13 Отчет по благотворительности
     * АБ13 Отгружено продукции по клиентам
     * ВС04 Отчет по благотворительности
     * МС04 Отгружено продукции по клиентам
     * @throws Exception
     */
    public function action_products_client() {
        set_time_limit(36000);

        $this->_sitePageData->url = '/'.$this->actionURLName.'/shopreport/products_client';

        $shopProductIDs = NULL;

        $dateFrom = Request_RequestParams::getParamDateTime('created_at_from');
        $dateTo = Request_RequestParams::getParamDateTime('created_at_to');
        $shopClientID = Request_RequestParams::getParamInt('shop_client_id');
        if($shopClientID < 1){
            $shopClientID = NULL;
        }

        $isSubdivision = Request_RequestParams::getParamBoolean('is_subdivision');

        // подразделения оператора
        if($isSubdivision) {
            $shopSubdivisionIDs = Request_RequestParams::getParamInt('shop_subdivision_id');
            if (empty($shopSubdivisionIDs)) {
                $shopSubdivisionIDs = $this->_sitePageData->operation->getProductShopSubdivisionIDsArray();
            }
        }else{
            $shopSubdivisionIDs = null;
        }

        $isCharity = Request_RequestParams::getParamBoolean('is_charity') === TRUE;
        $params = Request_RequestParams::setParams(
            array(
                'shop_product_id' => $shopProductIDs,
                'is_charity' => $isCharity,
                'shop_client_id' => $shopClientID,
                'shop_subdivision_id' => $shopSubdivisionIDs,
            )
        );

        $params = array_merge(
            Request_RequestParams::setParams(
                array(
                    'exit_at_from' => $dateFrom,
                    'exit_at_to' => $dateTo,
                    'is_exit' => 1,
                    'quantity_from' => 0,
                    'is_charity' => FALSE,
                    'sum_quantity' => true,
                    'sum_amount' => true,
                    'group_by' => array(
                        'shop_product_id', 'shop_product_id.name', 'shop_product_id.shop_product_rubric_id',
                        'shop_client_attorney_id',
                        'root_rubric_id.id', 'root_rubric_id.name',
                        'shop_client_id', 'shop_client_id.name',
                    )
                )
            ),
            $params
        );
        $elements = array(
            'shop_product_id' => array('name'),
            'root_rubric_id' => array('id', 'name'),
            'shop_client_id' => array('name'),
        );

        // реализация
        $ids = Request_Request::find('DB_Ab1_Shop_Car_Item',
            $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE, $elements
        );

        // штучный товар
        $pieceIDs = Request_Request::find('DB_Ab1_Shop_Piece_Item',
            $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE, $elements
        );

        $ids->addChilds($pieceIDs);

        $dataAttorneys = array(
            'data' => array(),
            'quantity' => 0,
            'amount' => 0,
        );

        foreach ($ids->childs as $child){
            $quantity = $child->values['quantity'];
            $amount = $child->values['amount'];

            $attorney = $child->values['shop_client_attorney_id'];
            if($attorney > 0){
                $attorney = 1;
            }
            if (! key_exists($attorney, $dataAttorneys['data'])){
                if($attorney == 1){
                    $nameAttorney = 'По доверенности';
                }else{
                    $nameAttorney = 'Без доверенности';
                }

                $dataAttorneys['data'][$attorney] = array(
                    'name' => $nameAttorney,
                    'data' => array(),
                    'quantity' => 0,
                    'amount' => 0,
                );
            }

            $client = $child->values['shop_client_id'];
            if (! key_exists($client, $dataAttorneys['data'][$attorney]['data'])){
                $dataAttorneys['data'][$attorney]['data'][$client] = array(
                    'data' => array(),
                    'name' => $child->getElementValue('shop_client_id'),
                    'quantity' => 0,
                    'amount' => 0,
                );
            }

            $rubric = $child->getElementValue('root_rubric_id', 'id');
            if (! key_exists($rubric, $dataAttorneys['data'][$attorney]['data'][$client]['data'])){
                $dataAttorneys['data'][$attorney]['data'][$client]['data'][$rubric] = array(
                    'data' => array(),
                    'name' => $child->getElementValue('root_rubric_id'),
                    'quantity' => 0,
                    'amount' => 0,
                );
            }

            $product = $child->values['shop_product_id'];
            if (! key_exists($product, $dataAttorneys['data'][$attorney]['data'][$client]['data'][$rubric]['data'])){
                $dataAttorneys['data'][$attorney]['data'][$client]['data'][$rubric]['data'][$product] = array(
                    'data' => array(),
                    'name' => $child->getElementValue('shop_product_id'),
                    'quantity' => 0,
                    'amount' => 0,
                );
            }

            $dataAttorneys['data'][$attorney]['data'][$client]['data'][$rubric]['data'][$product]['quantity'] += $quantity;
            $dataAttorneys['data'][$attorney]['data'][$client]['data'][$rubric]['data'][$product]['amount'] += $amount;

            $dataAttorneys['data'][$attorney]['data'][$client]['data'][$rubric]['quantity'] += $quantity;
            $dataAttorneys['data'][$attorney]['data'][$client]['data'][$rubric]['amount'] += $amount;

            $dataAttorneys['data'][$attorney]['data'][$client]['quantity'] += $quantity;
            $dataAttorneys['data'][$attorney]['data'][$client]['amount'] += $amount;

            $dataAttorneys['data'][$attorney]['quantity'] += $quantity;
            $dataAttorneys['data'][$attorney]['amount'] += $amount;

            $dataAttorneys['quantity'] += $quantity;
            $dataAttorneys['amount'] += $amount;
        }
        uasort($dataAttorneys['data'], array($this, 'mySortMethod'));
        foreach ($dataAttorneys['data'] as &$dataClients){
            uasort($dataClients['data'], array($this, 'mySortMethod'));
            foreach ($dataClients['data'] as &$dataClient){
                uasort($dataClient['data'], array($this, 'mySortMethod'));
                foreach ($dataClient['data'] as &$dataRubric){
                    uasort($dataRubric['data'], array($this, 'mySortMethod'));
                }
            }
        }

        $viewObject = 'ab1/_report/'.$this->_sitePageData->languageID.'/product/client';
        $tmp = str_replace('\\', '/', $viewObject);
        try {
            $view = View::factory($tmp);
        }catch (Exception $e) {
            throw new Exception('Шаблон "'.$tmp.'" не найден.');
        }

        $view->attorneys = $dataAttorneys;
        $view->isCharity = $isCharity;
        $view->isZHBI = false;
        $view->operation = $this->_sitePageData->operation->getValues();
        $view->shop = $this->_sitePageData->shop->getName();
        $view->shopOptions = $this->_sitePageData->shop->getOptionsArray();
        $strView = Helpers_View::viewToStr($view);

        header('Content-Type: application/x-download;charset=UTF-8');
        // header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        if($isSubdivision){
            if ($isCharity) {
                header('Content-Disposition: filename="АБ13 Отчет по благотворительности.xml"');
            } else {
                header('Content-Disposition: filename="АБ13 Отгружено продукции по клиентам.xml"');
            }
        }else {
            if ($isCharity) {
                header('Content-Disposition: filename="ВС04 Отчет по благотворительности.xml"');
            } else {
                header('Content-Disposition: filename="МС04 Отгружено продукции по клиентам.xml"');
            }
        }
        header('Cache-Control: max-age=0');

        echo $strView;
        exit();
    }

    public function action_clients_payment() {
        set_time_limit(36000);

        $this->_sitePageData->url = '/'.$this->actionURLName.'/shopreport/clients_payment';

        $shopProductIDs = NULL;

        $ids = Request_Request::find('DB_Ab1_Shop_Payment',
            $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB,
            array(),0, TRUE, array('shop_client_id' => array('name'))
        );

        $dataClients = array(
            'data' => array(),
            'amount' => 0,
        );

        foreach ($ids->childs as $child){
            $amount = $child->values['amount'];

            $client = $child->values['shop_client_id'];
            if (! key_exists($client, $dataClients['data'])){
                $dataClients['data'][$client] = array(
                    'data' => array(),
                    'name' => $child->getElementValue('shop_client_id'),
                    'amount' => 0,
                );
            }

            $dataClients['data'][$client]['amount'] += $amount;
            $dataClients['amount'] += $amount;
        }
        uasort($dataClients['data'], array($this, 'mySortMethod'));

        $viewObject = 'ab1/_report/'.$this->_sitePageData->languageID.'/clients-payment';
        $tmp = str_replace('\\', '/', $viewObject);
        try {
            $view = View::factory($tmp);
        }catch (Exception $e) {
            throw new Exception('Шаблон "'.$tmp.'" не найден.');
        }

        $view->clients = $dataClients;
        $view->operation = $this->_sitePageData->operation->getValues();
        $view->shop = $this->_sitePageData->shop->getName();
        $view->shopOptions = $this->_sitePageData->shop->getOptionsArray();
        $strView = Helpers_View::viewToStr($view);

        header('Content-Type: application/x-download;charset=UTF-8');
        // header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: filename="Принято денег по клиентам.xml"');
        header('Cache-Control: max-age=0');

        echo $strView;
        exit();
    }

    public function action_attorneys_client() {
        set_time_limit(36000);

        $this->_sitePageData->url = '/'.$this->actionURLName.'/shopreport/attorneys_client';

        $shopProductIDs = NULL;

        $dateFrom = Request_RequestParams::getParamDateTime('created_at_from');
        $dateTo = Request_RequestParams::getParamDateTime('created_at_to');
        $params = Request_RequestParams::setParams(
            array(
                'shop_product_id' => $shopProductIDs
            ), false
        );
        $ids = Api_Ab1_Shop_Car::getExitShopCar(
            $dateFrom, $dateTo,
            $this->_sitePageData, $this->_driverDB,
            array(
                'shop_product_id' => array('name'),
                'shop_client_id' => array('name'),
                'shop_client_attorney_id' => array('number', 'from_at', 'to_at'),
            ),
            $params
        );

        $dataClients = array(
            'data' => array(),
            'quantity' => 0,
            'amount' => 0,
        );

        foreach ($ids->childs as $child){
            $quantity = $child->values['quantity'];
            $amount = $child->values['amount'];

            $client = $child->values['shop_client_id'];
            if (! key_exists($client, $dataClients['data'])){
                $dataClients['data'][$client] = array(
                    'data' => array(),
                    'name' => Arr::path($child->values, Model_Basic_BasicObject::FIELD_ELEMENTS . '.shop_client_id.name', ''),
                    'quantity' => 0,
                    'amount' => 0,
                );
            }

            $attorney = $child->values['shop_client_attorney_id'];
            if (! key_exists($attorney, $dataClients['data'][$client]['data'])){
                if ($attorney > 0) {
                    $tmp = Arr::path($child->values, Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_client_attorney_id', array());
                    $dataClients['data'][$client]['data'][$attorney] = array(
                        'data' => array(),
                        'name' => 'Доверенность №'. Arr::path($tmp, 'number', '')
                            . ' от ' . Helpers_DateTime::getDateTimeRusWithoutSeconds(Arr::path($tmp, 'from_at', ''))
                            . ' до ' . Helpers_DateTime::getDateTimeRusWithoutSeconds(Arr::path($tmp, 'to_at', '')),
                        'quantity' => 0,
                        'amount' => 0,
                    );
                }else{
                    $dataClients['data'][$client]['data'][$attorney] = array(
                        'data' => array(),
                        'name' => 'Наличные',
                        'quantity' => 0,
                        'amount' => 0,
                    );
                }
            }

            $product = $child->values['shop_product_id'];
            if (! key_exists($product, $dataClients['data'][$client]['data'][$attorney]['data'])){
                $dataClients['data'][$client]['data'][$attorney]['data'][$product] = array(
                    'data' => array(),
                    'name' => $child->getElementValue('shop_product_id'),
                    'quantity' => 0,
                    'amount' => 0,
                );
            }

            $date = Helpers_DateTime::getDateFormatRus($child->values['created_at']);
            if (! key_exists($date, $dataClients['data'][$client]['data'][$attorney]['data'][$product]['data'])) {
                $dataClients['data'][$client]['data'][$attorney]['data'][$product]['data'][$date] = array(
                    'data' => array(),
                    'name' => $date,
                    'quantity' => 0,
                    'amount' => 0,
                );
            }

            $dataClients['data'][$client]['data'][$attorney]['data'][$product]['data'][$date]['quantity'] += $quantity;
            $dataClients['data'][$client]['data'][$attorney]['data'][$product]['data'][$date]['amount'] += $amount;

            $dataClients['data'][$client]['data'][$attorney]['data'][$product]['quantity'] += $quantity;
            $dataClients['data'][$client]['data'][$attorney]['data'][$product]['amount'] += $amount;

            $dataClients['data'][$client]['data'][$attorney]['quantity'] += $quantity;
            $dataClients['data'][$client]['data'][$attorney]['amount'] += $amount;

            $dataClients['data'][$client]['quantity'] += $quantity;
            $dataClients['data'][$client]['amount'] += $amount;

            $dataClients['quantity'] += $quantity;
            $dataClients['amount'] += $amount;
        }
        uasort($dataClients['data'], array($this, 'mySortMethod'));
        foreach ($dataClients['data'] as &$dataClient){
            uasort($dataClient['data'], array($this, 'mySortMethod'));
            foreach ($dataClient['data'] as &$dataAttorney){
                uasort($dataAttorney['data'], array($this, 'mySortMethod'));
                foreach ($dataAttorney['data'] as &$dataProduct){
                    uasort($dataProduct['data'], array($this, 'mySortMethod'));
                }
            }
        }

        $viewObject = 'ab1/_report/'.$this->_sitePageData->languageID.'/attorney/client';
        $tmp = str_replace('\\', '/', $viewObject);
        try {
            $view = View::factory($tmp);
        }catch (Exception $e) {
            throw new Exception('Шаблон "'.$tmp.'" не найден.');
        }

        $view->clients = $dataClients;
        $view->shop = $this->_sitePageData->shop->getName();
        $view->shopOptions = $this->_sitePageData->shop->getOptionsArray();
        $view->operation = $this->_sitePageData->operation->getValues();
        $strView = Helpers_View::viewToStr($view);

        header('Content-Type: application/x-download;charset=UTF-8');
        // header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: filename="СБ10 Отчет по доверенностям клиентов в разрезе дней.xml"');
        header('Cache-Control: max-age=0');

        echo $strView;
        exit();
    }

    public function action_payments() {
        set_time_limit(36000);

        $this->_sitePageData->url = '/'.$this->actionURLName.'/shopreport/payments';

        $shopProductIDs = NULL;

        $ids = Request_Request::find('DB_Ab1_Shop_Payment',$this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB,
            array(),0, TRUE,
            array('shop_client_id' => array('name')));

        $dataClients = array(
            'data' => array(),
            'amount' => 0,
        );

        foreach ($ids->childs as $child){
            $amount = $child->values['amount'];
            $dataClients['data'][$child->id] = array(
                'name' => $child->getElementValue('shop_client_id'),
                'amount' => $child->values['amount'],
                'number' => $child->values['number'],
            );
            $dataClients['amount'] += $amount;
        }

        $viewObject = 'ab1/_report/'.$this->_sitePageData->languageID.'/payments';
        $tmp = str_replace('\\', '/', $viewObject);
        try {
            $view = View::factory($tmp);
        }catch (Exception $e) {
            throw new Exception('Шаблон "'.$tmp.'" не найден.');
        }

        $view->clients = $dataClients;
        $view->operation = $this->_sitePageData->operation->getValues();
        $view->shop = $this->_sitePageData->shop->getName();
        $view->shopOptions = $this->_sitePageData->shop->getOptionsArray();
        $strView = Helpers_View::viewToStr($view);

        header('Content-Type: application/x-download;charset=UTF-8');
        // header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: filename="МС02 Принято денег по клиентам.xml"');
        header('Cache-Control: max-age=0');

        echo $strView;
        exit();
    }

    public function action_move_products_client() {
        set_time_limit(36000);

        $this->_sitePageData->url = '/'.$this->actionURLName.'/shopreport/move_products_client';

        $shopProductIDs = NULL;

        $dateFrom = Request_RequestParams::getParamDateTime('created_at_from');
        $dateTo = Request_RequestParams::getParamDateTime('created_at_to');
        $params = Request_RequestParams::setParams(
            array(
                'shop_product_id' => $shopProductIDs
            )
        );
        $ids = Api_Ab1_Shop_Move_Car::getExitShopMoveCar(
            $dateFrom, $dateTo,
            $this->_sitePageData, $this->_driverDB,
            array('shop_product_id' => array('name'), 'shop_client_id' => array('name')),
            $params
        );

        $dataClients = array(
            'data' => array(),
            'quantity' => 0,
        );

        foreach ($ids->childs as $child){
            $quantity = $child->values['quantity'];

            $client = $child->values['shop_client_id'];
            if (! key_exists($client, $dataClients['data'])){
                $dataClients['data'][$client] = array(
                    'data' => array(),
                    'name' => $child->getElementValue('shop_client_id'),
                    'quantity' => 0,
                );
            }


            $product = $child->values['shop_product_id'];
            if (! key_exists($product, $dataClients['data'][$client]['data'])){
                $dataClients['data'][$client]['data'][$product] = array(
                    'data' => array(),
                    'name' => $child->getElementValue('shop_product_id'),
                    'quantity' => 0,
                );
            }

            $dataClients['data'][$client]['data'][$product]['quantity'] += $quantity;
            $dataClients['data'][$client]['quantity'] += $quantity;
            $dataClients['quantity'] += $quantity;
        }
        uasort($dataClients['data'], array($this, 'mySortMethod'));
        foreach ($dataClients['data'] as &$dataClient){
            uasort($dataClient['data'], array($this, 'mySortMethod'));
        }

        $viewObject = 'ab1/_report/'.$this->_sitePageData->languageID.'/move-products-client';
        $tmp = str_replace('\\', '/', $viewObject);
        try {
            $view = View::factory($tmp);
        }catch (Exception $e) {
            throw new Exception('Шаблон "'.$tmp.'" не найден.');
        }

        $view->clients = $dataClients;
        $view->operation = $this->_sitePageData->operation->getValues();
        $view->shop = $this->_sitePageData->shop->getName();
        $view->shopOptions = $this->_sitePageData->shop->getOptionsArray();
        $strView = Helpers_View::viewToStr($view);

        header('Content-Type: application/x-download;charset=UTF-8');
        // header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: filename="МС07 Перемещение по подразделениям.xml"');
        header('Cache-Control: max-age=0');

        echo $strView;
        exit();
    }
}
