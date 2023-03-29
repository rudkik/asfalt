<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_Admin_Integration extends Controller_Ab1_Admin_BasicAb1 {

    public function __construct(Request $request, Response $response)
    {
        $this->actionURLName = 'ab1-admin';
        $this->prefixView = 'admin';

        parent::__construct($request, $response);
        $this->_sitePageData->actionURLName = 'ab1-admin';
    }

    public function action_index() {
        $this->_sitePageData->url = '/ab1-admin/integration/index';

        $this->_putInMain('/main/integration/index');
    }

    public function action_sync()
    {
        $this->_sitePageData->url = '/ab1-admin/integration/sync';

        $object = Request_RequestParams::getParamStr('object');
        $id = Request_RequestParams::getParamInt('id');

        $limit = Request_RequestParams::getParamInt('limit');
        if($limit < 1){
            $limit = 10;
        }

        $model = 'Model_' . $object;
        $object = 'DB_' . $object;
        $tmp = new Integration_Ab1_1C_Service();

        $model = new $model();
        if($id > 0) {
            if (!$this->dublicateObjectLanguage($model, $id, 0, FALSE)) {
                throw new HTTP_Exception_404('Object not is found!');
            }

            $tmp->update1C($object, $model, $this->_sitePageData, $this->_driverDB);
        }else{
            $params = array_merge($_GET, $_POST);
            unset($params['object']);
            unset($params['id']);
            unset($params['limit']);
            $params['sort_by'] = ['id' => 'desc'];

            $ids = Request_Request::findNotShop(
                $object, $this->_sitePageData, $this->_driverDB, Request_RequestParams::setParams($params),
                $limit, true
            );

            foreach ($ids->childs as $child){
                $child->setModel($model);
                $tmp->update1C($object, $model, $this->_sitePageData, $this->_driverDB);
            }
        }
    }

    /*
     * Отчет реализации товаров по сотрудникам за период
     */
    public function action_realization_workers() {
        set_time_limit(36000);

        $this->_sitePageData->url = '/ab1-admin/integration/realization_workers';

        /** Реализация продукции сотрудников **/
        $dateFrom = Request_RequestParams::getParamDate('date_from');
        $dateTo = Request_RequestParams::getParamDate('date_to');
        $params = Request_RequestParams::setParams(
            array(
                'created_at_from_equally' => $dateFrom,
                'created_at_to' => $dateTo.' 23:59:59',
                'shop_worker_id_from' => 0,
                'shop_write_off_type_id' => [0, Model_Magazine_Shop_WriteOff_Type::WRITE_OFF_TYPE_REDRESS],
                'sum_amount' => TRUE,
                'is_special' => Model_Magazine_Shop_Realization::SPECIAL_TYPE_BASIC,
                'group_by' => array(
                    'shop_worker_id', 'shop_worker_id.name', 'shop_worker_id.iin',
                    'shop_id', 'shop_id.old_id',
                ),
                'sort_by' => array(
                    'shop_worker_id.name' => 'asc',
                ),
            )
        );

        $ids = Request_Request::findNotShop(
            'DB_Magazine_Shop_Realization',
            $this->_sitePageData, $this->_driverDB, $params,0, TRUE,
            array(
                'shop_worker_id' => array('name'),
                'shop_id' => array('old_id'),
            )
        );

        $worker = Request_Request::findOneByID(
            DB_Ab1_Shop_Worker::NAME, $this->_sitePageData->operation->getShopWorkerID(),
            0, $this->_sitePageData, $this->_driverDB
        );
        $iin = '';
        if($worker != null){
            $iin = $worker->values['iin'];
        }

        $divisions = [];
        foreach ($ids->childs as $child) {
            $division = $child->getElementValue('shop_id', 'old_id');

            if(!key_exists($division, $divisions)){
                $divisions[$division] = [];
            }

            $divisions[$division][] = [
                'worker_iin' => $child->getElementValue('shop_worker_id', 'iin'),
                'row_sum' => $child->values['amount'],
            ];
        }

        foreach ($divisions as $division => $child) {
            $code = str_replace('-', '', $dateFrom . $division);
            $document = [
                'type' => 'retention',
                'mode' => 'new',
                'ver' => 'mag',
                'code' => $code,
                'guid' => $code,
                'guid_1c' => '',
                'date' => $dateFrom,
                'start' => $dateFrom,
                'end' => $dateTo,
                'bin_org' => $this->_sitePageData->shop->getValue('bin'),
                'division_org' => $division,
                'user_iin' => $iin,
                'comment' => 'автоматическая загрузка',
                'rows' => [],
            ];

            $document['rows'] = $child;

            $integration = new Integration_Ab1_1C_Service();
            $integration->sendData($document);
        }
    }

    public function action_work_1с() {
        $this->_sitePageData->url = '/ab1-admin/integration/work_1с';

        $dateFrom = Request_RequestParams::getParamDate('date_from');
        $dateTo = Request_RequestParams::getParamDate('date_to');

        if(empty($dateFrom) || empty($dateTo)){
            throw new HTTP_Exception_500('Period not empty.');
        }

        $shopTurnPlaceID = [20834, 20835, 20836, 20837];

        $dateFrom = $dateFrom . ' 06:00:00';
        $dateTo = $dateTo . ' 06:00:00';

        $params = array(
            'shop_turn_place_id' => $shopTurnPlaceID,
            'sum_quantity' => true,
            'group_by' => array(
                'exit_at_day_6_hour',
                'shop_product_id', 'shop_product_id.name', 'shop_product_id.unit', 'shop_product_id.old_id',
                'shop_turn_place_id', 'shop_turn_place_id.name', 'shop_turn_place_id.old_id'
            ),
        );
        $elements = [
            'shop_product_id' => array('name', 'unit', 'old_id'),
            'shop_turn_place_id' => array('name', 'old_id')
        ];

        $ids = Api_Ab1_Shop_Car::getExitShopCar(
            $dateFrom, $dateTo, $this->_sitePageData, $this->_driverDB,
            $elements, $params, true, null
        );

        $shopMoveCarIDs = Api_Ab1_Shop_Move_Car::getExitShopMoveCar(
            $dateFrom, $dateTo, $this->_sitePageData, $this->_driverDB,
            $elements, $params, true, null
        );
        $ids->addChilds($shopMoveCarIDs);

        $shopDefectCarIDs = Api_Ab1_Shop_Defect_Car::getExitShopDefectCar(
            $dateFrom, $dateTo, $this->_sitePageData, $this->_driverDB,
            $elements, $params, true, null
        );
        $ids->addChilds($shopDefectCarIDs);

        $params = Request_RequestParams::setParams(
            array(
                'shop_turn_place_id' => $shopTurnPlaceID,
                'weighted_at_from' => $dateFrom,
                'weighted_at_to' => $dateTo,
                'sum_quantity' => true,
                'group_by' => array(
                    'exit_at_day_6_hour',
                    'shop_product_id', 'shop_product_id.name', 'shop_product_id.unit', 'shop_product_id.old_id',
                    'shop_turn_place_id', 'shop_turn_place_id.name', 'shop_turn_place_id.old_id'
                ),
                'sort_by' => array(
                    'shop_product_id.name' => 'asc',
                ),
            )
        );
        $shopProductStorageIDs = Request_Request::findNotShop(
            'DB_Ab1_Shop_Product_Storage', $this->_sitePageData, $this->_driverDB,
            $params, 0, TRUE, $elements
        );
        $ids->addChilds($shopProductStorageIDs);

        $params = array(
            'from_at_to' => $dateFrom,
            'to_at_from' => $dateFrom,
        );
        $shopProductTurnPlaceItemIDs = Request_Request::findNotShop(
            'DB_Ab1_Shop_Product_TurnPlace_Item', $this->_sitePageData, $this->_driverDB,
            $params, 0, true
        );

        $prices = [];
        foreach ($shopProductTurnPlaceItemIDs->childs as $child) {
            $prices[$child->values['shop_turn_place_id'].'_'.$child->values['shop_product_id']] = [
                'norm' => $child->values['norm'],
                'price' => $child->values['price'],
            ];
        }

        // праздничные и выходные дни
        $params = Request_RequestParams::setParams(
            array(
                'day_from_equally' => Helpers_DateTime::getDateFormatPHP(Helpers_DateTime::minusDays($dateFrom, 5)),
                'day_to' => Helpers_DateTime::getDateFormatPHP(Helpers_DateTime::plusDays($dateTo, 5)),
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

        $dataProducts = [];
        foreach ($ids->childs as $child) {
            $quantity = $child->values['quantity'];
            $product = $child->values['shop_product_id'];
            $place = $child->values['shop_turn_place_id'] . '_' . $product;
            $turn = $child->getElementValue('shop_turn_place_id', 'old_id');

            if(!key_exists($turn, $dataProducts)){
                $dataProducts[$turn] = [];
            }

            $isHoliday = 0;
            $key = $isHoliday . '_' . $product . '_' . $turn;

            if (!key_exists($isHoliday, $dataProducts[$turn])) {
                $dataProducts[$turn][$isHoliday] = [];
            }

            if (!key_exists($key, $dataProducts[$turn][$isHoliday])) {
                $dataProducts[$turn][$isHoliday][$key] = array(
                    'product_name' => $child->getElementValue('shop_product_id'),
                    'product_old_id' => $child->getElementValue('shop_product_id', 'old_id'),
                    'turn_name' => $child->getElementValue('shop_turn_place_id'),
                    'turn_old_id' => $child->getElementValue('shop_turn_place_id', 'old_id'),
                    'quantity' => 0,
                    'price' => 0,
                    'norm' => 0,
                    'amount' => 0,
                    'holiday' => $isHoliday,
                );

                if (key_exists($place, $prices)) {
                    $dataProducts[$turn][$isHoliday][$key]['norm'] = $prices[$place]['norm'];
                    $dataProducts[$turn][$isHoliday][$key]['price'] = $prices[$place]['price'];
                }
            }

            $dataProducts[$turn][$isHoliday][$key]['quantity'] += $quantity;

            $amount = $quantity * $dataProducts[$turn][$isHoliday][$key]['price'];
            $dataProducts[$turn][$isHoliday][$key]['amount'] += $amount;

            // выходной
            $isHoliday = key_exists($child->values['exit_at_day'], $holidayIDs->childs);
            if($isHoliday) {
                $isHoliday = Func::boolToInt($isHoliday);
                $key = $isHoliday . '_' . $product . '_' . $turn;

                if (!key_exists($isHoliday, $dataProducts[$turn])) {
                    $dataProducts[$turn][$isHoliday] = [];
                }

                if (!key_exists($key, $dataProducts[$turn][$isHoliday])) {
                    $dataProducts[$turn][$isHoliday][$key] = array(
                        'product_name' => $child->getElementValue('shop_product_id'),
                        'product_old_id' => $child->getElementValue('shop_product_id', 'old_id'),
                        'turn_name' => $child->getElementValue('shop_turn_place_id'),
                        'turn_old_id' => $child->getElementValue('shop_turn_place_id', 'old_id'),
                        'quantity' => 0,
                        'price' => 0,
                        'norm' => 0,
                        'amount' => 0,
                        'holiday' => $isHoliday,
                    );

                    if (key_exists($place, $prices)) {
                        $dataProducts[$turn][$isHoliday][$key]['norm'] = $prices[$place]['norm'];
                        $dataProducts[$turn][$isHoliday][$key]['price'] = $prices[$place]['price'];
                    }
                }

                $dataProducts[$turn][$isHoliday][$key]['quantity'] += $quantity;

                $amount = $quantity * $dataProducts[$turn][$isHoliday][$key]['price'];
                $dataProducts[$turn][$isHoliday][$key]['amount'] += $amount * 0.5;
            }
        }

        $worker = Request_Request::findOneByID(
            DB_Ab1_Shop_Worker::NAME, $this->_sitePageData->operation->getShopWorkerID(),
            0, $this->_sitePageData, $this->_driverDB
        );
        $iin = '';
        if($worker != null){
            $iin = $worker->values['iin'];
        }

        foreach ($dataProducts as $key1 => $turn) {
            foreach ($turn as $key2 => $holiday) {
                $dateFrom = Helpers_DateTime::getDateFormatPHP($dateFrom);
                $dateTo = Helpers_DateTime::getDateFormatPHP(Helpers_DateTime::minusDays($dateTo, 1));

                $code = str_replace('-', '', $dateFrom . $key1 . $key2);
                $document = [
                    'type' => 'salary_data',
                    'ver' => 'plus',
                    'mode' => 'new',
                    'code' => $code,
                    'guid' => $code,
                    'guid_1c' => '',
                    'date' => $dateFrom,
                    'start' => $dateFrom,
                    'end' => $dateTo,
                    'bin_org' => $this->_sitePageData->shop->getValue('bin'),
                    'division_org' => $this->_sitePageData->shop->getOldID(),
                    'user_iin' => $iin,
                    'comment' => 'автоматическая загрузка',
                    'rows' => [],
                ];

                foreach ($holiday as $child) {
                    $document['rows_works'][] = [
                        'typeofwork' => $child['product_old_id'],
                        'strtypeofwork' => $child['product_name'],
                        'number' => strval($child['quantity']),
                        'price' => strval($child['price']),
                        'row_sum' => strval($child['amount']),
                        'holiday' => strval($child['holiday']),
                        'asu' => $child['turn_old_id'],
                    ];
                }

                $integration = new Integration_Ab1_1C_Service();
                $integration->sendData($document);
            }
        }
    }

    public function action_talons()
    {
        $this->_sitePageData->url = '/ab1-admin/integration/talons';

        $dateFrom = Request_RequestParams::getParamDate('date_from');

        Api_Magazine_Shop_Talon::save1СJSON(
            Helpers_DateTime::getMonth($dateFrom), Helpers_DateTime::getYear($dateFrom),
            $this->_sitePageData, $this->_driverDB
        );
    }

    public function action_saves()
    {
        $this->_sitePageData->url = '/ab1-admin/integration/saves';

        $urls = [];

        foreach ($urls as $url) {
            file_get_contents($url);
        }
    }
}