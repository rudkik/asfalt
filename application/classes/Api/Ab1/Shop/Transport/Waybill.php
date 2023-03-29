<?php defined('SYSPATH') or die('No direct script access.');

class Api_Ab1_Shop_Transport_Waybill {
    /**
     * Проверяем нужно ли сохранять для 1С через JSON
     * @param Model_Ab1_Shop_Transport_Waybill $model
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @return array
     */
    public static function is1CJSON(Model_Ab1_Shop_Transport_Waybill $model, SitePageData $sitePageData,
                                    Model_Driver_DBBasicDriver $driver)
    {
        if(Func::_empty($model->getToAt()) || Func::_empty($model->getFromAt())){
            return false;
        }

        $modelWork = new Model_Ab1_Transport_Work();
        $modelWork->setDBDriver($driver);
        Helpers_DB::getDBObject($modelWork, $model->getTransportWorkID(), $sitePageData, 0);

        return $modelWork->getIs1C();
    }

    /**
     * Сохранение для 1С через JSON
     * @param Model_Ab1_Shop_Transport_Waybill $model
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @return array
     */
    public static function get1CJSON(Model_Ab1_Shop_Transport_Waybill $model, SitePageData $sitePageData,
                                     Model_Driver_DBBasicDriver $driver)
    {
        $workIDs = Request_Request::find(
            DB_Ab1_Shop_Transport_Waybill_Work_Driver::NAME, 0, $sitePageData, $driver,
            Request_RequestParams::setParams(
                [
                    'shop_transport_waybill_id' => $model->id,
                    'quantity_from' => 0,
                    'shop_transport_work_id.is_load_1c' => true,
                ]
            ), 0, true,
            [
                'shop_transport_work_id' => ['name', 'number']
            ]
        );

        $modelWork = new Model_Ab1_Transport_Work();
        $modelWork->setDBDriver($driver);
        Helpers_DB::getDBObject($modelWork, $model->getTransportWorkID(), $sitePageData, 0);

        $result = [];

        // узнаем количество дней
        $days = Helpers_DateTime::diffDays(
                Helpers_DateTime::getDateFormatPHP($model->getToAt()),
                Helpers_DateTime::getDateFormatPHP($model->getFromAt())
            ) + 1;

        $hoursFirst = floor(Helpers_DateTime::diffHours(Helpers_DateTime::plusDays(Helpers_DateTime::getDateFormatPHP($model->getFromAt()), 1), $model->getFromAt()));
        $hoursLast = floor(Helpers_DateTime::diffHours($model->getToAt(), Helpers_DateTime::getDateFormatPHP($model->getToAt())));
        if($days == 1){
            $hoursLast = 0;
        }

        foreach ($workIDs->childs as $child) {
            if($days == 2){
                $hoursLast = $child->values['quantity'] - $hoursFirst;
            }

            $quantityBasic = intdiv($child->values['quantity'], $days);

            $first = $quantityBasic;
            if($first > $hoursFirst){
                $first = $hoursFirst;
            }

            $last = $quantityBasic;
            if ($last > $hoursLast) {
                $last = $hoursLast;
            }

            $quantityBasic = 0;
            if($days > 2) {
                $quantityBasic = intdiv($child->values['quantity'] - $first - $last, $days - 2);
            }

            for ($i = 0; $i < $days; $i++) {
                if($i == 0){
                    $quantity = $first;
                }elseif($i == $days - 1){
                    $quantity = $last;
                }else {
                    $quantity = $quantityBasic;
                }

                $result[] = [
                    'date_action' => Helpers_DateTime::getDateFormatPHP(Helpers_DateTime::plusDays($model->getDate(), $i)),
                    'typeofwork' => $modelWork->getNumber(),
                    'strtypeofwork' => $modelWork->getName(),
                    'typeoftime' => 1,
                    'code1c' => $child->getElementValue('shop_transport_work_id', 'number'),
                    'str' => $child->getElementValue('shop_transport_work_id'),
                    'value' => $quantity,
                ];
            }
        }

        $wage = Request_Request::findOne(
            DB_Ab1_Shop_Transport_Waybill_Car::NAME, 0, $sitePageData, $driver,
            Request_RequestParams::setParams(
                [
                    'shop_transport_waybill_id' => $model->id,
                    'is_wage' => true,
                    'sum_wage' => true,
                ]
            )
        );

        if($wage != null && $wage->values['wage'] > 0){
            $result[] = [
                'date_action' => $model->getToAt(),
                'typeofwork' => 0,
                'strtypeofwork' => '',
                'typeoftime' => '',
                'code1c' => '',
                'str' => '',
                'value' => $wage->values['wage'],
            ];
        }

        return $result;
    }

    /**
     * Пересчитываем количестов зарплаты
     * @param $shopTransportWaybillID
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @throws HTTP_Exception_404
     */
    public static function recalcWageTransportCar($shopTransportWaybillID, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver){
        $model = new Model_Ab1_Shop_Transport_Waybill();
        $model->setDBDriver($driver);

        if(!Helpers_DB::getDBObject($model, $shopTransportWaybillID, $sitePageData, 0)){
            throw new HTTP_Exception_404('Waybill id="' . $shopTransportWaybillID . '" not is found!');
        }

        $ids = Request_Request::find(
            DB_Ab1_Shop_Transport_Waybill_Car::NAME, 0, $sitePageData, $driver,
            Request_RequestParams::setParams(
                [
                    'shop_transport_waybill_id' => $shopTransportWaybillID,
                    'is_wage' => true,
                    'sum_wage' => true,
                ]
            )
        );

        if(count($ids->childs) > 0){
            $model->setWage($ids->childs[0]->values['wage']);
        }else{
            $model->setWage(0);
        }

        Helpers_DB::saveDBObject($model, $sitePageData);
    }

    /**
     * Получаем список маршрутов за заданный период сгруппированные по водителям, транспорту, дням и выработки в виде дерева
     * @param $dateFrom
     * @param $dateTo
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @return array
     */
    public static function getDriverTransportRouteValues($dateFrom, $dateTo, SitePageData $sitePageData,
                                                         Model_Driver_DBBasicDriver $driver){
        $dateFromD = strtotime($dateFrom);
        $dateToD = strtotime($dateTo.' 23:59:59');

        // получаем список выработок водителя
        $params = Request_RequestParams::setParams(
            array(
                'shop_transport_waybill_id.to_at_from_equally' => $dateFrom,
                'shop_transport_waybill_id.to_at_to' => $dateTo.' 23:59:59',
                'is_wage' => true,
                'sort_by' => array(
                    'shop_transport_driver_id.name' => 'asc',
                    'shop_transport_waybill_id.date' => 'asc',
                    'shop_transport_route_id.name' => 'asc',
                ),
            )
        );
        $workDriverIDs = Request_Request::find(
            DB_Ab1_Shop_Transport_Waybill_Car::NAME, $sitePageData->shopID, $sitePageData, $driver,
            $params, 0, true,
            array(
                'shop_transport_waybill_id' => array('date', 'from_at', 'to_at', 'shop_transport_id'),
                'shop_transport_driver_id' => array('name', 'number'),
                'shop_transport_route_id' => array('name'),
                'shop_transport_waybill_id.shop_transport_id' => array('number'),
            )
        );

        // ищем количетсво отработанных дней и часов в заданом периоде для водителя
        $diffDays = 0;
        $diffHours = 0;
        $driverDays = array();
        $getDiff = function (&$diffDays, &$diffHours, $fromAt, $toAt, $driverID, array &$driverDays){
            $diffDays = 0;
            $diffHours = 0;

            $fromAtB = Helpers_DateTime::getDateFormatPHP($fromAt);
            $toAtB = Helpers_DateTime::getDateFormatPHP($toAt);

            $fromAtD = strtotime($fromAtB);

            // в рамках одного дня
            $nexDay = Helpers_DateTime::plusDays($fromAtB, 1);
            if(strtotime($nexDay) > strtotime($toAt)){
                if(!key_exists($driverID, $driverDays) || !key_exists($fromAtD, $driverDays[$driverID])){
                    $diffDays++;
                    $diffHours += ceil(Helpers_DateTime::diffHours($toAt, $fromAt));
                    $driverDays[$driverID][$fromAtD] = '';
                }

                return;
            }

            // первый день
            if(!key_exists($driverID, $driverDays) || !key_exists($fromAtD, $driverDays[$driverID])){
                $diffDays++;
                $diffHours += ceil(Helpers_DateTime::diffHours($nexDay, $fromAt));
                $driverDays[$driverID][$fromAtD] = '';
            }

            // от второго до предпоследнего дня
            $toAtD = strtotime($toAtB);
            for ($i = $fromAtD + 24 * 60 * 60; $i < $toAtD; $i = $i + 24 * 60 * 60){
                if(!key_exists($driverID, $driverDays) || !key_exists($i, $driverDays[$driverID])){
                    $diffDays++;
                    $diffHours += 24;
                    $driverDays[$driverID][$i] = '';
                }
            }

            // последний день
            $fromAtD = strtotime(Helpers_DateTime::getDateFormatPHP($toAt));
            if($fromAtD != strtotime($toAt) && (!key_exists($driverID, $driverDays) || !key_exists($fromAtD, $driverDays[$driverID]))){
                $diffDays++;
                $diffHours += ceil(Helpers_DateTime::diffHours($toAt, Helpers_DateTime::getDateFormatPHP($toAt)));
                $driverDays[$driverID][$fromAtD] = '';
            }
        };

        $dataParams = [
            'quantity' => 0,
            'count' => 0,
            'hours' => 0,
            'days' => 0,
            'repair' => 0,
        ];

        $result = new MyArray();
        $result->additionDatas = $dataParams;
        foreach ($workDriverIDs->childs as $child){
            $quantity = $child->values['quantity'];
            $count = $child->values['count_trip'];

            $driverID = $child->values['shop_transport_driver_id'];

            $fromAt = $child->getElementValue('shop_transport_waybill_id', 'from_at');
            $toAt = $child->getElementValue('shop_transport_waybill_id', 'to_at');

            $getDiff($diffDays, $diffHours, $fromAt, $toAt, $driverID, $driverDays);

            if(strtotime($fromAt) < $dateFromD){
                $fromAt = $dateFrom;
            }
            $child->values['$elements$']['shop_transport_waybill_id']['from_at'] = $fromAt;

            if(strtotime($toAt) > $dateToD){
                $toAt = $dateTo.' 23:59:59';
            }
            $child->values['$elements$']['shop_transport_waybill_id']['to_at'] = $toAt;

            $result->additionDatas['hours'] += $diffHours;
            $result->additionDatas['days'] += $diffDays;

            if(!key_exists($driverID, $result->childs)){
                $result->childs[$driverID] = new MyArray();
                $result->childs[$driverID]->cloneObj($child);
                $result->childs[$driverID]->additionDatas = $dataParams;
            }
            $driverObj = $result->childs[$driverID];

            $transport = $child->getElementValue('shop_transport_waybill_id', 'shop_transport_id');
            if(!key_exists($transport, $driverObj->childs)){
                $driverObj->childs[$transport] = new MyArray();
                $driverObj->childs[$transport]->cloneObj($child);
                $driverObj->childs[$transport]->additionDatas = $dataParams;
            }
            $transportObj = $driverObj->childs[$transport];

            $route = $child->values['shop_transport_route_id'];
            if(!key_exists($route, $transportObj->childs)){
                $transportObj->childs[$route] = new MyArray();
                $transportObj->childs[$route]->cloneObj($child);
                $transportObj->childs[$route]->additionDatas = $dataParams;
            }
            $routeObj = $transportObj->childs[$route];

            $routeObj->additionDatas['quantity'] += $quantity;
            $routeObj->additionDatas['count'] += $count;
            $routeObj->additionDatas['hours'] += $diffHours;
            $routeObj->additionDatas['days'] += $diffDays;

            $transportObj->additionDatas['quantity'] += $quantity;
            $transportObj->additionDatas['count'] += $count;
            $transportObj->additionDatas['hours'] += $diffHours;
            $transportObj->additionDatas['days'] += $diffDays;

            $driverObj->additionDatas['quantity'] += $quantity;
            $driverObj->additionDatas['count'] += $count;
            $driverObj->additionDatas['hours'] += $diffHours;
            $driverObj->additionDatas['days'] += $diffDays;

            $result->additionDatas['quantity'] += $quantity;
            $result->additionDatas['count'] += $count;
            $result->additionDatas['hours'] += $diffHours;
            $result->additionDatas['days'] += $diffDays;
        }

        // получаем список выработок водителя
        $params = Request_RequestParams::setParams(
            array(
                'date_to_from_equally' => $dateFrom,
                'date_to_to' => $dateTo,
                'sort_by' => array(
                    'shop_transport_driver_id.name' => 'asc',
                ),
            )
        );
        $repairDriverIDs = Request_Request::find(
            DB_Ab1_Shop_Transport_Repair::NAME, $sitePageData->shopID, $sitePageData, $driver,
            $params, 0, true,
            array(
                'shop_transport_driver_id' => array('name', 'number'),
                'shop_transport_id' => array('number'),
            )
        );

        foreach ($repairDriverIDs->childs as $child){
            $quantity = $child->values['hours'];

            $driverID = $child->values['shop_transport_driver_id'];

            $fromAt = $child->values['from_at'];
            $toAt = $child->values['to_at'];

            $getDiff($diffDays, $diffHours, $fromAt, $toAt, $driverID, $driverDays);
            $result->additionDatas['hours'] += $quantity;
            $result->additionDatas['days'] += $diffDays;

            if(strtotime($fromAt) < $dateFromD){
                $fromAt = $dateFrom;
            }
            $child->values['from_at'] = $fromAt;

            if(strtotime($toAt) > $dateToD){
                $toAt = $dateTo.' 23:59:59';
            }
            $child->values['to_at'] = $toAt;

            if(!key_exists($driverID, $result->childs)){
                $result->childs[$driverID] = new MyArray();
                $result->childs[$driverID]->cloneObj($child);
                $result->childs[$driverID]->additionDatas = $dataParams;
            }
            $driverObj = $result->childs[$driverID];

            $transport = $child->values['shop_transport_id'];
            if(!key_exists($transport, $driverObj->childs)){
                $driverObj->childs[$transport] = new MyArray();
                $driverObj->childs[$transport]->cloneObj($child);
                $driverObj->childs[$transport]->additionDatas = $dataParams;
            }
            $transportObj = $driverObj->childs[$transport];

            $transportObj->additionDatas['hours'] += $quantity;
            $transportObj->additionDatas['days'] += $diffDays;
            $transportObj->additionDatas['repair'] += $quantity;

            $driverObj->additionDatas['hours'] += $quantity;
            $driverObj->additionDatas['days'] += $diffDays;
            $driverObj->additionDatas['repair'] += $quantity;
        }

        return $result;
    }

    /**
     * Получаем список зарплат сотрудников полученных из маршрутов
     * @param $dateFrom
     * @param $dateTo
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @return MyArray
     */
    public static function getDriverWagesRoute($dateFrom, $dateTo, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver){
        // получаем список выработок водителя
        $params = Request_RequestParams::setParams(
            array(
                'shop_transport_waybill_id.to_at_from_equally' => Helpers_DateTime::getDateFormatPHP($dateFrom),
                'shop_transport_waybill_id.to_at_to' => Helpers_DateTime::getDateFormatPHP($dateTo) . '23:59:59',
                'shop_transport_waybill_id.shop_id' => $sitePageData->shopID,
                'shop_transport_route_id_from' => 0,
                'is_wage' => true,
                'sort_by' => array(
                    'shop_transport_driver_id.name' => 'asc',
                )
            )
        );
        $workDriverIDs = Request_Request::find(
            DB_Ab1_Shop_Transport_Waybill_Car::NAME, 0, $sitePageData, $driver,
            $params, 0, true,
            array(
                'shop_transport_driver_id' => array('name'),
                'shop_transport_waybill_id' => array('date'),
            )
        );

        // праздничные и выходные дни
        $holidayIDs = Api_Ab1_Holiday::getHolidays($dateFrom, $dateTo, $sitePageData, $driver);

        $result = new MyArray();
        $result->additionDatas['holiday'] = 0;
        $result->additionDatas['wage'] = 0;
        $result->additionDatas['total'] = 0;
        foreach ($workDriverIDs->childs as $child){
            $driverID = $child->values['shop_transport_driver_id'];
            if(!key_exists($driverID, $result->childs)){
                $result->childs[$driverID] = new MyArray();
                $result->childs[$driverID]->id = $driverID;
                $result->childs[$driverID]->values = [
                    'name' => $child->getElementValue('shop_transport_driver_id'),
                    'id' => $driver,
                    'holiday' => 0,
                    'wage' => 0,
                    'total' => 0,
                ];
            }
            $driverObj = $result->childs[$driverID];

            $wage = $child->values['wage'];
            $driverObj->values['wage'] += $wage;
            $result->additionDatas['wage'] += $wage;

            $driverObj->values['total'] += $wage;
            $result->additionDatas['total'] += $wage;

            if(key_exists(Helpers_DateTime::getDateFormatPHP($child->getElementValue('shop_transport_waybill_id', 'date')), $holidayIDs->childs)){
                $wage = round($wage / 2, 2);
                $driverObj->values['holiday'] += $wage;
                $result->additionDatas['holiday'] += $wage;

                $driverObj->values['total'] += $wage;
                $result->additionDatas['total'] += $wage;
            }
        }

        return $result;
    }

    /**
     * Получаем список отработанного за заданный период сгруппированные по водителям, транспорту, дням в виде дерева
     * @param $shopTransportWorkID
     * @param $shopSubdivisionID
     * @param $dateFrom
     * @param $dateTo
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @return MyArray
     */
    public static function getDriverTransportWorkDays($shopTransportWorkID, $shopSubdivisionID, $dateFrom, $dateTo,
                                                      SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver){
        // получаем список выработок водителя
        $params = Request_RequestParams::setParams(
            array(
                'shop_transport_waybill_id.to_at_from_equally' => $dateFrom,
                'shop_transport_waybill_id.to_at_to' => $dateTo.' 23:59:59',
                'shop_transport_work_id' => $shopTransportWorkID,
                'shop_transport_waybill_id.shop_subdivision_id' => $shopSubdivisionID,
                'quantity_from' => 0,
                'sort_by' => array(
                    'shop_transport_driver_id.name' => 'asc',
                    'shop_transport_waybill_id.date' => 'asc',
                ),
            )
        );
        $workDriverIDs = Request_Request::find(
            DB_Ab1_Shop_Transport_Waybill_Work_Driver::NAME, $sitePageData->shopID, $sitePageData, $driver,
            $params, 0, true,
            array(
                'shop_transport_waybill_id' => array('to_at', 'shop_transport_id'),
                'shop_transport_driver_id' => array('name'),
                'shop_transport_work_id' => array('name'),
                'shop_transport_waybill_id.shop_transport_id' => array('number'),
            )
        );

        $result = [
            'quantity' => 0,
            'data' => [],
        ];
        foreach ($workDriverIDs->childs as $child){
            $quantity = $child->values['quantity'];
            $driverID = $child->values['shop_transport_driver_id'];

            $result['quantity'] += $quantity;

            if(!key_exists($driverID, $result['data'])){
                $result['data'][$driverID] = [
                    'driver' => $child->getElementValue('shop_transport_driver_id'),
                    'quantity' => 0,
                    'data' => [],
                ];
            }
            $result['data'][$driverID]['quantity'] += $quantity;

            $transport = $child->getElementValue('shop_transport_waybill_id', 'shop_transport_id');
            if(!key_exists($transport, $result['data'][$driverID]['data'])){
                $result['data'][$driverID]['data'][$transport] = [
                    'transport' => $child->getElementValue('shop_transport_id', 'number'),
                    'quantity' => 0,
                    'data' => [],
                ];
            }
            $result['data'][$driverID]['data'][$transport]['quantity'] += $quantity;

            $day = Helpers_DateTime::getDateFormatPHP($child->getElementValue('shop_transport_waybill_id', 'to_at'));
            if(!key_exists($day, $result['data'][$driverID]['data'][$transport]['data'])){
                $result['data'][$driverID]['data'][$transport]['data'][$day] = 0;
            }
            $result['data'][$driverID]['data'][$transport]['data'][$day] += $quantity;
        }

        if($shopTransportWorkID != 1458614 && $shopTransportWorkID > -1){
            return $result;
        }

        // получаем список выработок водителя
        $params = Request_RequestParams::setParams(
            array(
                'to_at_from_equally' => $dateFrom,
                'to_at_to' => $dateTo,
                'sort_by' => array(
                    'shop_transport_driver_id.name' => 'asc',
                ),
            )
        );
        $repairDriverIDs = Request_Request::find(
            DB_Ab1_Shop_Transport_Repair::NAME, $sitePageData->shopID, $sitePageData, $driver,
            $params, 0, true,
            array(
                'shop_transport_driver_id' => array('name'),
                'shop_transport_id' => array('number'),
            )
        );

        foreach ($repairDriverIDs->childs as $child){
            $quantity = $child->values['hours'];
            $driverID = $child->values['shop_transport_driver_id'];

            $result['quantity'] += $quantity;

            if(!key_exists($driverID, $result['data'])){
                $result['data'][$driverID] = [
                    'driver' => $child->getElementValue('shop_transport_driver_id'),
                    'quantity' => 0,
                    'data' => [],
                ];
            }
            $result['data'][$driverID]['quantity'] += $quantity;

            $transport = $child->values['shop_transport_id'];
            if(!key_exists($transport, $result['data'][$driverID]['data'])){
                $result['data'][$driverID]['data'][$transport] = [
                    'transport' => $child->getElementValue('shop_transport_id', 'number'),
                    'hours' => 0,
                    'days' => 0,
                    'quantity' => 0,
                    'data' => [],
                ];
            }
            $result['data'][$driverID]['data'][$transport]['quantity'] += $quantity;

            $day = Helpers_DateTime::getDateFormatPHP($child->values['to_at']);
            if(!key_exists($day, $result['data'][$driverID]['data'][$transport]['data'])){
                $result['data'][$driverID]['data'][$transport]['data'][$day] = 0;
            }
            $result['data'][$driverID]['data'][$transport]['data'][$day] += $quantity;
        }

        return $result;
    }

    /**
     * Получаем список выработок за заданный период сгруппированные по водителям, транспорту, дням и выработки в виде дерева
     * @param $dateFrom
     * @param $dateTo
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @return array
     */
    public static function getDriverTransportWorkValues($dateFrom, $dateTo, SitePageData $sitePageData,
                                                        Model_Driver_DBBasicDriver $driver){
        $dateFromD = strtotime($dateFrom);
        $dateToD = strtotime($dateTo.' 23:59:59');

        // получаем список выработок водителя
        $params = Request_RequestParams::setParams(
            array(
                'shop_transport_waybill_id.to_at_from_equally' => $dateFrom,
                'shop_transport_waybill_id.to_at_to' => $dateTo.' 23:59:59',
                'quantity_from' => 0,
                'sort_by' => array(
                    'shop_transport_driver_id.name' => 'asc',
                    'shop_transport_waybill_id.date' => 'asc',
                ),
            )
        );
        $workDriverIDs = Request_Request::find(
            DB_Ab1_Shop_Transport_Waybill_Work_Driver::NAME, $sitePageData->shopID, $sitePageData, $driver,
            $params, 0, true,
            array(
                'shop_transport_waybill_id' => array('date', 'from_at', 'to_at', 'shop_transport_id'),
                'shop_transport_driver_id' => array('name', 'number'),
                'shop_transport_work_id' => array('short_name'),
                'shop_transport_waybill_id.shop_transport_id' => array('number'),
            )
        );

        // ищем количетсво отработанных дней и часов в заданом периоде для водителя
        $diffDays = 0;
        $diffHours = 0;
        $driverDays = array();
        $getDiff = function (&$diffDays, &$diffHours, $fromAt, $toAt, $driverID, array &$driverDays){
            $diffDays = 0;
            $diffHours = 0;

            $fromAtB = Helpers_DateTime::getDateFormatPHP($fromAt);
            $toAtB = Helpers_DateTime::getDateFormatPHP($toAt);

            $fromAtD = strtotime($fromAtB);

            // в рамках одного дня
            $nexDay = Helpers_DateTime::plusDays($fromAtB, 1);
            if(strtotime($nexDay) > strtotime($toAt)){
                if(!key_exists($driverID, $driverDays) || !key_exists($fromAtD, $driverDays[$driverID])){
                    $diffDays++;
                    $diffHours += ceil(Helpers_DateTime::diffHours($toAt, $fromAt));
                    $driverDays[$driverID][$fromAtD] = '';
                }

                return;
            }

            // первый день
            if(!key_exists($driverID, $driverDays) || !key_exists($fromAtD, $driverDays[$driverID])){
                $diffDays++;
                $diffHours += ceil(Helpers_DateTime::diffHours($nexDay, $fromAt));
                $driverDays[$driverID][$fromAtD] = '';
            }

            // от второго до предпоследнего дня
            $toAtD = strtotime($toAtB);
            for ($i = $fromAtD + 24 * 60 * 60; $i < $toAtD; $i = $i + 24 * 60 * 60){
                if(!key_exists($driverID, $driverDays) || !key_exists($i, $driverDays[$driverID])){
                    $diffDays++;
                    $diffHours += 24;
                    $driverDays[$driverID][$i] = '';
                }
            }

            // последний день
            $fromAtD = strtotime(Helpers_DateTime::getDateFormatPHP($toAt));
            if($fromAtD != strtotime($toAt) && (!key_exists($driverID, $driverDays) || !key_exists($fromAtD, $driverDays[$driverID]))){
                $diffDays++;
                $diffHours += ceil(Helpers_DateTime::diffHours($toAt, Helpers_DateTime::getDateFormatPHP($toAt)));
                $driverDays[$driverID][$fromAtD] = '';
            }
        };

        $result = new MyArray();
        $result->additionDatas['hours'] = 0;
        $result->additionDatas['days'] = 0;
        $works = array();
        foreach ($workDriverIDs->childs as $child){
            $work = $child->values['shop_transport_work_id'];
            $quantity = $child->values['quantity'];

            $driverID = $child->values['shop_transport_driver_id'];

            $fromAt = $child->getElementValue('shop_transport_waybill_id', 'from_at');
            $toAt = $child->getElementValue('shop_transport_waybill_id', 'to_at');

            $getDiff($diffDays, $diffHours, $fromAt, $toAt, $driverID, $driverDays);

            if(strtotime($fromAt) < $dateFromD){
                $fromAt = $dateFrom;
            }
            $child->values['$elements$']['shop_transport_waybill_id']['from_at'] = $fromAt;

            if(strtotime($toAt) > $dateToD){
                $toAt = $dateTo.' 23:59:59';
            }
            $child->values['$elements$']['shop_transport_waybill_id']['to_at'] = $toAt;

            $result->additionDatas['hours'] += $diffHours;
            $result->additionDatas['days'] += $diffDays;

            if(!key_exists($driverID, $result->childs)){
                $result->childs[$driverID] = new MyArray();
                $result->childs[$driverID]->cloneObj($child);
                $result->childs[$driverID]->additionDatas['works'] = array();
            }
            $driverObj = $result->childs[$driverID];
            Helpers_Array::plusValue($driverObj->additionDatas['works'], $work, $quantity);

            $transport = $child->getElementValue('shop_transport_waybill_id', 'shop_transport_id');
            if(!key_exists($transport, $driverObj->childs)){
                $driverObj->childs[$transport] = new MyArray();
                $driverObj->childs[$transport]->cloneObj($child);
                $driverObj->childs[$transport]->additionDatas['works'] = array();
                $driverObj->childs[$transport]->additionDatas['hours'] = 0;
                $driverObj->childs[$transport]->additionDatas['days'] = 0;
            }
            $transportObj = $driverObj->childs[$transport];
            Helpers_Array::plusValue($transportObj->additionDatas['works'], $work, $quantity);
            $transportObj->additionDatas['hours'] += $diffHours;
            $transportObj->additionDatas['days'] += $diffDays;

            $day = $child->getElementValue('shop_transport_waybill_id', 'date');
            if(!key_exists($day, $transportObj->childs)){
                $transportObj->childs[$day] = new MyArray();
                $transportObj->childs[$day]->cloneObj($child);
                $transportObj->childs[$day]->additionDatas['works'] = array();
            }
            $dayObj = $transportObj->childs[$day];
            Helpers_Array::plusValue($dayObj->additionDatas['works'], $work, $quantity);

            if(strtotime($dayObj->getElementValue('shop_transport_waybill_id', 'to_at')) < strtotime($toAt)){
                $dayObj->values[Model_Basic_DBObject::FIELD_ELEMENTS]['shop_transport_waybill_id']['to_at'] = $toAt;
            }

            if(!key_exists($work, $dayObj->childs)){
                $dayObj->childs[$work] = new MyArray();
                $dayObj->childs[$work]->cloneObj($child);
                $dayObj->childs[$work]->values['quantity'] = 0;
            }
            $workObj = $dayObj->childs[$work];
            $workObj->values['quantity'] += $quantity;

            if(!key_exists($work, $works)){
                $works[$work] = [
                    'id' => $work,
                    'name' => $child->getElementValue('shop_transport_work_id', 'short_name'),
                    'quantity' => 0,
                ];
            }
            $works[$work]['quantity'] += $quantity;
        }

        // получаем список выработок водителя
        $params = Request_RequestParams::setParams(
            array(
                'date_to_from_equally' => $dateFrom,
                'date_to_to' => $dateTo,
                'sort_by' => array(
                    'shop_transport_driver_id.name' => 'asc',
                ),
            )
        );
        $repairDriverIDs = Request_Request::find(
            DB_Ab1_Shop_Transport_Repair::NAME, $sitePageData->shopID, $sitePageData, $driver,
            $params, 0, true,
            array(
                'shop_transport_driver_id' => array('name', 'number'),
                'shop_transport_id' => array('number'),
            )
        );

        foreach ($repairDriverIDs->childs as $child){
            $work = 'Р';
            $quantity = $child->values['hours'];

            $driverID = $child->values['shop_transport_driver_id'];

            $fromAt = $child->values['from_at'];
            $toAt = $child->values['to_at'];

            $getDiff($diffDays, $diffHours, $fromAt, $toAt, $driverID, $driverDays);
            $result->additionDatas['hours'] += $quantity;
            $result->additionDatas['days'] += $diffDays;

            if(strtotime($fromAt) < $dateFromD){
                $fromAt = $dateFrom;
            }
            $child->values['from_at'] = $fromAt;

            if(strtotime($toAt) > $dateToD){
                $toAt = $dateTo.' 23:59:59';
            }
            $child->values['to_at'] = $toAt;

            if(!key_exists($driverID, $result->childs)){
                $result->childs[$driverID] = new MyArray();
                $result->childs[$driverID]->cloneObj($child);
                $result->childs[$driverID]->additionDatas['works'] = array();
            }
            $driverObj = $result->childs[$driverID];
            Helpers_Array::plusValue($driverObj->additionDatas['works'], $work, $quantity);

            $transport = $child->values['shop_transport_id'];
            if(!key_exists($transport, $driverObj->childs)){
                $driverObj->childs[$transport] = new MyArray();
                $driverObj->childs[$transport]->cloneObj($child);
                $driverObj->childs[$transport]->additionDatas['works'] = array();
                $driverObj->childs[$transport]->additionDatas['hours'] = 0;
                $driverObj->childs[$transport]->additionDatas['days'] = 0;
            }
            $transportObj = $driverObj->childs[$transport];
            Helpers_Array::plusValue($transportObj->additionDatas['works'], $work, $quantity);
            $transportObj->additionDatas['hours'] += $diffHours;
            $transportObj->additionDatas['days'] += $diffDays;

            $day = $child->values['date'];
            if(!key_exists($day, $transportObj->childs)){
                $transportObj->childs[$day] = new MyArray();
                $transportObj->childs[$day]->cloneObj($child);
                $transportObj->childs[$day]->additionDatas['works'] = array();
            }
            $dayObj = $transportObj->childs[$day];
            Helpers_Array::plusValue($dayObj->additionDatas['works'], $work, $quantity);

            if(strtotime($dayObj->getElementValue('shop_transport_waybill_id', 'to_at')) < strtotime($toAt)){
                $dayObj->values[Model_Basic_DBObject::FIELD_ELEMENTS]['shop_transport_waybill_id']['to_at'] = $toAt;
            }

            if(!key_exists($work, $dayObj->childs)){
                $dayObj->childs[$work] = new MyArray();
                $dayObj->childs[$work]->cloneObj($child);
                $dayObj->childs[$work]->values['quantity'] = 0;
            }
            $workObj = $dayObj->childs[$work];
            $workObj->values['quantity'] += $quantity;

            if(!key_exists($work, $works)){
                $works[$work] = [
                    'id' => $work,
                    'name' => $work,
                    'quantity' => 0,
                ];
            }
            $works[$work]['quantity'] += $quantity;
        }

        return [
            'drivers' => $result,
            'works' => $works,
        ];
    }

    /**
     * Находим путевой лист по транспорту и дате
     * @param $shopTransportID
     * @param $date
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @return int
     */
    public static function findWaybillID($shopTransportID, $date, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        $params = Request_RequestParams::setParams(
            array(
                'shop_transport_id' => $shopTransportID,
                'car_date' => $date,
            )
        );
        return Request_Request::findID(
            'DB_Ab1_Shop_Transport_Waybill', 0, $params, $sitePageData, $driver
        );
    }

    /**
     * Получаем время последнего рейса
     * @param $shopTransportWaybillID
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @return false|string
     */
    public static function getFinishDate($shopTransportWaybillID, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        if($shopTransportWaybillID < 1){
            return '';
        }

        $result = 0;

        $params = Request_RequestParams::setParams(
            array(
                'max_exit_at' => true,
                'max_created_at' => true,
                'max_weighted_exit_at' => true,
                'max_date' => true,
                'shop_transport_waybill_id' => $shopTransportWaybillID
            )
        );

        // получаем реализацию
        $ids = Request_Request::find(
            'DB_Ab1_Shop_Car', $sitePageData->shopID, $sitePageData, $driver, $params
        );
        foreach ($ids->childs as $child){
            if($result < strtotime($child->values['max_exit_at'])){
                $result = strtotime($child->values['max_exit_at']);
            }
        }

        // получаем штучный товар
        $ids = Request_Request::find(
            'DB_Ab1_Shop_Piece', $sitePageData->shopID, $sitePageData, $driver, $params
        );
        foreach ($ids->childs as $child){
            if($result < strtotime($child->values['max_created_at'])){
                $result = strtotime($child->values['max_created_at']);
            }
        }

        // получаем перемещение
        $ids = Request_Request::find(
            'DB_Ab1_Shop_Move_Car', 0, $sitePageData, $driver, $params
        );
        foreach ($ids->childs as $child){
            if($result < strtotime($child->values['max_exit_at'])){
                $result = strtotime($child->values['max_exit_at']);
            }
        }

        // получаем брака
        $ids = Request_Request::find(
            'DB_Ab1_Shop_Defect_Car', 0, $sitePageData, $driver, $params
        );
        foreach ($ids->childs as $child){
            if($result < strtotime($child->values['max_exit_at'])){
                $result = strtotime($child->values['max_exit_at']);
            }
        }

        // получаем прочие перемещение
        $ids = Request_Request::find(
            'DB_Ab1_Shop_Move_Other', 0, $sitePageData, $driver, $params
        );
        foreach ($ids->childs as $child){
            if($result < strtotime($child->values['max_weighted_exit_at'])){
                $result = strtotime($child->values['max_weighted_exit_at']);
            }
        }

        // получаем ответ.хранения
        $ids = Request_Request::find(
            'DB_Ab1_Shop_Lessee_Car', 0, $sitePageData, $driver, $params
        );
        foreach ($ids->childs as $child){
            if($result < strtotime($child->values['max_exit_at'])){
                $result = strtotime($child->values['max_exit_at']);
            }
        }

        // получаем завоз материала
        $ids = Request_Request::find(
            'DB_Ab1_Shop_Car_To_Material', 0, $sitePageData, $driver, $params
        );
        foreach ($ids->childs as $child){
            if($result < strtotime($child->values['max_created_at'])){
                $result = strtotime($child->values['max_created_at']);
            }
        }

        // получаем балласт
        $ids = Request_Request::find(
            'DB_Ab1_Shop_Ballast', 0, $sitePageData, $driver, $params
        );
        foreach ($ids->childs as $child){
            if($result < strtotime($child->values['max_date'])){
                $result = strtotime($child->values['max_date']);
            }
        }

        // получаем перевозки внутри карьера
        $ids = Request_Request::find(
            'DB_Ab1_Shop_Transportation', 0, $sitePageData, $driver, $params
        );
        foreach ($ids->childs as $child){
            if($result < strtotime($child->values['max_date'])){
                $result = strtotime($child->values['max_date']);
            }
        }

        if($result != 0){
            $result = Helpers_DateTime::plusMinutes(date('Y-m-d H:i:s', $result), 1);
        }else{
            $result = '';
        }

        return $result;
    }

    /**
     * Обновляем список поездок в путевом листе
     * @param $shopTransportWaybillID
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @return bool
     */
    public static function deleteCars($shopTransportWaybillID, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        if($shopTransportWaybillID < 1){
            return false;
        }

        $params = Request_RequestParams::setParams(
            array(
                'shop_transport_waybill_id' => $shopTransportWaybillID
            )
        );

        // получаем реализацию
        $ids = Request_Request::find(
            'DB_Ab1_Shop_Car', $sitePageData->shopID, $sitePageData, $driver, $params
        );
        $driver->updateObjects(
            Model_Ab1_Shop_Car::TABLE_NAME, $ids->getChildArrayID(),
            array('shop_transport_waybill_id' => 0)
        );

        // получаем штучный товар
        $ids = Request_Request::find(
            'DB_Ab1_Shop_Piece', $sitePageData->shopID, $sitePageData, $driver, $params
        );
        $driver->updateObjects(
            Model_Ab1_Shop_Piece::TABLE_NAME, $ids->getChildArrayID(),
            array('shop_transport_waybill_id' => 0)
        );

        // получаем перемещение
        $ids = Request_Request::find(
            'DB_Ab1_Shop_Move_Car', 0, $sitePageData, $driver, $params
        );
        $driver->updateObjects(
            Model_Ab1_Shop_Move_Car::TABLE_NAME, $ids->getChildArrayID(),
            array('shop_transport_waybill_id' => 0)
        );

        // получаем брак
        $ids = Request_Request::find(
            'DB_Ab1_Shop_Defect_Car', 0, $sitePageData, $driver, $params
        );
        $driver->updateObjects(
            Model_Ab1_Shop_Defect_Car::TABLE_NAME, $ids->getChildArrayID(),
            array('shop_transport_waybill_id' => 0)
        );

        // получаем брака
        $ids = Request_Request::find(
            'DB_Ab1_Shop_Defect_Car', 0, $sitePageData, $driver, $params
        );
        $driver->updateObjects(
            Model_Ab1_Shop_Defect_Car::TABLE_NAME, $ids->getChildArrayID(),
            array('shop_transport_waybill_id' => 0)
        );

        // получаем прочие перемещение
        $ids = Request_Request::find(
            'DB_Ab1_Shop_Move_Other', 0, $sitePageData, $driver, $params
        );
        $driver->updateObjects(
            Model_Ab1_Shop_Move_Other::TABLE_NAME, $ids->getChildArrayID(),
            array('shop_transport_waybill_id' => 0)
        );

        // получаем ответ.хранения
        $ids = Request_Request::find(
            'DB_Ab1_Shop_Lessee_Car', 0, $sitePageData, $driver, $params
        );

        $driver->updateObjects(
            Model_Ab1_Shop_Lessee_Car::TABLE_NAME, $ids->getChildArrayID(),
            array('shop_transport_waybill_id' => 0)
        );

        // получаем завоз материала
        $ids = Request_Request::find(
            'DB_Ab1_Shop_Car_To_Material', 0, $sitePageData, $driver, $params
        );

        $driver->updateObjects(
            Model_Ab1_Shop_Car_To_Material::TABLE_NAME, $ids->getChildArrayID(),
            array('shop_transport_waybill_id' => 0)
        );

        // получаем балласт
        $ids = Request_Request::find(
            'DB_Ab1_Shop_Ballast', 0, $sitePageData, $driver, $params
        );

        $driver->updateObjects(
            Model_Ab1_Shop_Ballast::TABLE_NAME, $ids->getChildArrayID(),
            array('shop_transport_waybill_id' => 0)
        );

        // получаем перевозки внутри карьера
        $ids = Request_Request::find(
            'DB_Ab1_Shop_Transportation', 0, $sitePageData, $driver, $params
        );

        $driver->updateObjects(
            Model_Ab1_Shop_Transportation::TABLE_NAME, $ids->getChildArrayID(),
            array('shop_transport_waybill_id' => 0)
        );

        return true;
    }

    /**
     * Получаем ID маршрута перевозки
     * @param Model_Ab1_Shop_Transport_Waybill_Car $model
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @return int
     */
    public static function getRouteID(Model_Ab1_Shop_Transport_Waybill_Car $model, SitePageData $sitePageData,
                                      Model_Driver_DBBasicDriver $driver)
    {
        $isDistance = false;
        $params = null;
        if ($model->getShopCarID() > 0){
            $params = array(
                'shop_branch_from_to_id' => $model->getShopBranchFromID(),
                'shop_product_id' => $model->getShopProductID(),
                'shop_product_rubric_id' => $model->getShopProductRubricID(),
                'shop_client_to_id' => [$model->getShopClientToID(), 0],
                'table_id' => Model_Ab1_Shop_Car::TABLE_ID,
            );
        }elseif ($model->getShopPieceID() > 0){
            $pieceItemIDs = Request_Request::find(
                'DB_Ab1_Shop_Piece_Item', 0, $sitePageData, $driver,
                Request_RequestParams::setParams(
                    array(
                        'shop_piece_id' => $model->getShopPieceID(),
                    )
                ),
                0, true, ['root_rubric_id' => ['id']]
            );


            if(count($pieceItemIDs->childs) > 0){
                $products = $pieceItemIDs->getChildArrayInt('shop_product_id', true);
                $products[] = 0;
                $rubrics = $pieceItemIDs->getChildArrayInt(Model_Basic_DBObject::FIELD_ELEMENTS.'.root_rubric_id.id', true);
                $rubrics[] = 0;

                $params = array(
                    'shop_branch_from_to_id' => $model->getShopBranchFromID(),
                    'shop_product_id' => $products,
                    'shop_product_rubric_id' => $rubrics,
                    'shop_client_to_id' => [$model->getShopClientToID(), 0],
                    'table_id' => Model_Ab1_Shop_Piece::TABLE_ID,
                );
            }
        }elseif ($model->getShopMoveCarID() > 0) {
            $params = array(
                'shop_branch_from_to_id' => $model->getShopBranchFromID(),
                'shop_product_id' => $model->getShopProductID(),
                'table_id' => Model_Ab1_Shop_Move_Car::TABLE_ID,
            );
            $isDistance = true;
        }elseif ($model->getShopDefectCarID() > 0){
            $params = array(
                'shop_branch_from_to_id' => $model->getShopBranchFromID(),
                'shop_product_id' => $model->getShopProductID(),
                'shop_product_rubric_id' => $model->getShopProductRubricID(),
                'shop_client_to_id' => [$model->getShopClientToID(), 0],
                'table_id' => Model_Ab1_Shop_Car::TABLE_ID,
            );
        }elseif ($model->getShopDefectCarID() > 0){
            $params = array(
                'shop_branch_from_to_id' => $model->getShopBranchFromID(),
                'shop_product_id' => $model->getShopProductID(),
                'table_id' => Model_Ab1_Shop_Defect_Car::TABLE_ID,
            );
        }elseif ($model->getShopLesseeCarID() > 0){
            $params = array(
                'shop_branch_from_to_id' => $model->getShopBranchFromID(),
                'shop_product_id' => $model->getShopProductID(),
                'table_id' => Model_Ab1_Shop_Lessee_Car::TABLE_ID,
            );
        }elseif ($model->getShopMoveOtherID() > 0){
            $params = array(
                'shop_branch_from_to_id' => $model->getShopBranchFromID(),
                'table_id' => Model_Ab1_Shop_Move_Other::TABLE_ID,
            );
        }elseif ($model->getShopCarToMaterialID() > 0){
            $params =  array(
                'shop_branch_from_to_id' => [
                    $model->getShopBranchFromID(),
                    $model->getShopBranchToID(),
                ],
                'shop_daughter_from_to_id' => $model->getShopDaughterFromID() > 0 ? $model->getShopDaughterFromID() : -1,
                'table_id' => Model_Ab1_Shop_Car_To_Material::TABLE_ID,
            );
            $isDistance = true;
        }elseif ($model->getShopBallastID() > 0){
            $params = array(
                'shop_branch_from_to_id' => $model->getShopBranchFromID(),
                'shop_ballast_distance_id' => $model->getShopBallastDistanceID(),
                'table_id' => [Model_Ab1_Shop_Ballast::TABLE_ID],
            );
        }elseif ($model->getShopTransportationID() > 0){
            $params = array(
                'shop_branch_from_to_id' => $model->getShopBranchFromID(),
                'shop_transportation_place_to_id' => $model->getShopTransportationPlaceToID(),
                'table_id' => [Model_Ab1_Shop_Transportation::TABLE_ID],
            );
        }elseif ($model->getShopProductStorageID() > 0){
            $params = array(
                'shop_branch_from_to_id' => $model->getShopBranchFromID(),
                'shop_storage_to_id' => $model->getShopStorageToID(),
                'table_id' => [Model_Ab1_Shop_Product_Storage::TABLE_ID],
            );
            $isDistance = true;
        }

        // получаем маршрут
        $routeID = Request_Request::findOne(
            'DB_Ab1_Shop_Transport_Route', 0, $sitePageData, $driver, Request_RequestParams::setParams($params)
        );
        if($routeID != null){
            $model->setShopTransportRouteID($routeID->id);

            if($isDistance) {
                $model->setDistance($routeID->values['distance']);
            }

            if ($model->getShopPieceID() > 0){
                $model->setShopProductRubricID($routeID->values['shop_product_rubric_id']);
            }
        }else{
            $model->setShopTransportRouteID(0);

            if($isDistance) {
                $model->setDistance(0);
            }

            if ($model->getShopPieceID() > 0){
                $model->setShopProductRubricID(0);
            }
        }

        return $model->getShopTransportRouteID();
    }

    /**
     * Обновляем список поездок в путевом листе
     * @param $shopTransportWaybillID
     * @param $shopTransportID
     * @param $trailerShopTransportID
     * @param $shopTransportDriverID
     * @param $dateFrom
     * @param $dateTo
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @return bool
     * @throws HTTP_Exception_404
     */
    public static function refreshCars($shopTransportWaybillID, $shopTransportID, $trailerShopTransportID, $shopTransportDriverID,
                                       $dateFrom, $dateTo, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        if($shopTransportWaybillID < 1 || $shopTransportID < 1 || empty($dateFrom) || empty($dateTo)){
            return false;
        }

        // получаем коэффициент для стоимости маршрутов
        $coefficient = self::getCoefficientRouteWageTransport(
            $dateFrom, $shopTransportID, $trailerShopTransportID, $sitePageData, $driver
        );

        $getDate = function ($dateTime){
            $result = Helpers_DateTime::getDateFormatPHP($dateTime);
            if(strtotime($dateTime) < strtotime($result . ' 06:00:00')){
                return Helpers_DateTime::minusDays($result, 1);
            }

            return $result;
        };

        $modelTransport = new Model_Ab1_Shop_Transport();
        $modelTransport->setDBDriver($driver);
        if(!Helpers_DB::getDBObject($modelTransport, $shopTransportID, $sitePageData, 0)){
            throw new HTTP_Exception_404('Transport id="' . $shopTransportID . '" not is found!');
        }

        // удаляем предыдущие связанные данные
        self::deleteCars($shopTransportWaybillID, $sitePageData, $driver);

        $model = new Model_Ab1_Shop_Transport_Waybill_Car();
        $model->setDBDriver($driver);

        // получаем список ранее сохраненных машин
        $params = Request_RequestParams::setParams(
            array(
                'shop_transport_waybill_id' => $shopTransportWaybillID,
                'is_hand' => false,
            )
        );
        $shopTransportWaybillCarIDs = Request_Request::find(
            DB_Ab1_Shop_Transport_Waybill_Car::NAME, 0, $sitePageData, $driver, $params
        );

        $params = Request_RequestParams::setParams(
            array(
                'shop_transport_id' => $shopTransportID,
                'exit_at_from' => $dateFrom,
                'exit_at_to' => $dateTo,
                'is_exit' => 1,
                'quantity_from' => 0,
            )
        );

        // получаем реализацию
        $ids = Request_Request::find(
            'DB_Ab1_Shop_Car', 0, $sitePageData, $driver, $params, 0, true,
            ['shop_product_id' => ['name'], 'shop_delivery_id' => ['km'], 'root_rubric_id' => ['id']]
        );

        // добавляем ссылки на путевой лист у реализации
        $driver->updateObjects(
            Model_Ab1_Shop_Car::TABLE_NAME, $ids->getChildArrayID(),
            array('shop_transport_waybill_id' => $shopTransportWaybillID)
        );

        foreach ($ids->childs as $child){
            $shopTransportWaybillCarIDs->childShiftSetModel($model, 0, 0, false, array('shop_car_id' => $child->id));

            $model->setShopTransportID($shopTransportID);
            $model->setShopTransportWaybillID($shopTransportWaybillID);
            $model->setShopTransportDriverID($shopTransportDriverID);
            $model->setCountTrip(1);
            $model->setShopCarID($child->id);
            $model->setDistance($child->values['delivery_km']);
            if($model->getDistance() < 0.0001){
                $model->setDistance($child->getElementValue('shop_delivery_id', 'km'));
            }
            $model->setShopClientToID($child->values['shop_client_id']);
            $model->setQuantity($child->values['quantity']);
            $model->setShopProductID($child->values['shop_product_id']);
            $model->setShopProductRubricID($child->getElementValue('root_rubric_id', 'id'));
            $model->setShopBranchFromID($child->values['shop_id']);
            $model->setDate($getDate($child->values['exit_at']));
            $model->setProductName($child->getElementValue('shop_product_id'));

            if($model->id < 1){
                $model->setIsWage($modelTransport->getIsWage());
            }

            // получаем маршрут
            $model->setShopTransportRouteID(self::getRouteID($model, $sitePageData, $driver));
            // зарплата
            $model->setCoefficient($coefficient);
            $model->setWage(Api_Ab1_Shop_Transport_Route::getWageCar($model, $sitePageData, $driver));

            Helpers_DB::saveDBObject($model, $sitePageData, $sitePageData->shopID);
        }

        // получаем штучный товар
        $ids = Request_Request::find(
            'DB_Ab1_Shop_Piece', 0, $sitePageData, $driver, $params, 0, true,
            ['shop_delivery_id' => ['km']]
        );

        // добавляем ссылки на путевой лист у штучного товара
        $driver->updateObjects(
            Model_Ab1_Shop_Piece::TABLE_NAME, $ids->getChildArrayID(),
            array('shop_transport_waybill_id' => $shopTransportWaybillID)
        );

        foreach ($ids->childs as $child){
            $shopTransportWaybillCarIDs->childShiftSetModel($model, 0, 0, false, array('shop_piece_id' => $child->id));

            $model->setShopTransportID($shopTransportID);
            $model->setShopTransportWaybillID($shopTransportWaybillID);
            $model->setShopTransportDriverID($shopTransportDriverID);
            $model->setCountTrip(1);
            $model->setShopPieceID($child->id);
            $model->setDistance($child->values['delivery_km']);
            $model->setDistance($child->values['delivery_km']);
            if($model->getDistance() < 0.0001){
                $model->setDistance($child->getElementValue('shop_delivery_id', 'km'));
            }
            $model->setShopClientToID($child->values['shop_client_id']);
            $model->setQuantity($child->values['quantity']);
            $model->setShopBranchFromID($child->values['shop_id']);
            $model->setDate($getDate($child->values['created_at']));
            $model->setProductName($child->values['text']);

            if($model->id < 1){
                $model->setIsWage($modelTransport->getIsWage());
            }

            // получаем маршрут
            $model->setShopTransportRouteID(self::getRouteID($model, $sitePageData, $driver));
            // зарплата
            $model->setCoefficient($coefficient);
            $model->setWage(Api_Ab1_Shop_Transport_Route::getWageCar($model, $sitePageData, $driver));

            Helpers_DB::saveDBObject($model, $sitePageData, $sitePageData->shopID);
        }

        // получаем перемещение
        $ids = Request_Request::find(
            'DB_Ab1_Shop_Move_Car', 0, $sitePageData, $driver, $params, 0, true,
            ['shop_product_id' => ['name']]
        );

        // добавляем ссылки на путевой лист у перемещения
        $driver->updateObjects(
            Model_Ab1_Shop_Move_Car::TABLE_NAME, $ids->getChildArrayID(),
            array('shop_transport_waybill_id' => $shopTransportWaybillID)
        );

        foreach ($ids->childs as $child){
            $shopTransportWaybillCarIDs->childShiftSetModel($model, 0, 0, false, array('shop_move_car_id' => $child->id));

            $model->setShopTransportID($shopTransportID);
            $model->setShopTransportWaybillID($shopTransportWaybillID);
            $model->setShopTransportDriverID($shopTransportDriverID);
            $model->setCountTrip(1);
            $model->setShopMoveCarID($child->id);
            $model->setDistance(0);
            $model->setShopMoveClientToID($child->values['shop_client_id']);
            $model->setQuantity($child->values['quantity']);
            $model->setShopProductID($child->values['shop_product_id']);
            $model->setShopBranchFromID($child->values['shop_id']);
            $model->setDate($getDate($child->values['exit_at']));
            $model->setProductName($child->getElementValue('shop_product_id'));

            if($model->id < 1){
                $model->setIsWage($modelTransport->getIsWage());
            }

            // получаем маршрут
            $model->setShopTransportRouteID(self::getRouteID($model, $sitePageData, $driver));
            // зарплата
            $model->setCoefficient($coefficient);
            $model->setWage(Api_Ab1_Shop_Transport_Route::getWageCar($model, $sitePageData, $driver));

            Helpers_DB::saveDBObject($model, $sitePageData, $sitePageData->shopID);
        }

        // получаем брак
        $ids = Request_Request::find(
            'DB_Ab1_Shop_Defect_Car', 0, $sitePageData, $driver, $params, 0, true,
            ['shop_product_id' => ['name'], 'root_rubric_id' => ['id']]
        );

        // добавляем ссылки на путевой лист у брака
        $driver->updateObjects(
            Model_Ab1_Shop_Defect_Car::TABLE_NAME, $ids->getChildArrayID(),
            array('shop_transport_waybill_id' => $shopTransportWaybillID)
        );

        foreach ($ids->childs as $child){
            $shopTransportWaybillCarIDs->childShiftSetModel($model, 0, 0, false, array('shop_defect_car_id' => $child->id));

            $model->setShopTransportID($shopTransportID);
            $model->setShopTransportWaybillID($shopTransportWaybillID);
            $model->setShopTransportDriverID($shopTransportDriverID);
            $model->setCountTrip(1);
            $model->setShopDefectCarID($child->id);
            $model->setDistance(0);
            $model->setShopClientToID($child->values['shop_client_id']);
            $model->setQuantity($child->values['quantity']);
            $model->setShopProductID($child->values['shop_product_id']);
            $model->setShopProductRubricID($child->getElementValue('root_rubric_id', 'id'));
            $model->setShopBranchFromID($child->values['shop_id']);
            $model->setDate($getDate($child->values['exit_at']));
            $model->setProductName($child->getElementValue('shop_product_id'));

            if($model->id < 1){
                $model->setIsWage($modelTransport->getIsWage());
            }

            // получаем маршрут
            $model->setShopTransportRouteID(self::getRouteID($model, $sitePageData, $driver));
            // зарплата
            $model->setCoefficient($coefficient);
            $model->setWage(Api_Ab1_Shop_Transport_Route::getWageCar($model, $sitePageData, $driver));

            Helpers_DB::saveDBObject($model, $sitePageData, $sitePageData->shopID);
        }

        // получаем ответ.хранение
        $ids = Request_Request::find(
            'DB_Ab1_Shop_Lessee_Car', 0, $sitePageData, $driver, $params, 0, true,
            ['shop_product_id' => ['name'], 'shop_delivery_id' => ['km']]
        );

        // добавляем ссылки на путевой лист у ответ.хранения
        $driver->updateObjects(
            Model_Ab1_Shop_Lessee_Car::TABLE_NAME, $ids->getChildArrayID(),
            array('shop_transport_waybill_id' => $shopTransportWaybillID)
        );

        foreach ($ids->childs as $child){
            $shopTransportWaybillCarIDs->childShiftSetModel($model, 0, 0, false, array('shop_lessee_car_id' => $child->id));

            $model->setShopTransportID($shopTransportID);
            $model->setShopTransportWaybillID($shopTransportWaybillID);
            $model->setShopTransportDriverID($shopTransportDriverID);
            $model->setCountTrip(1);
            $model->setShopLesseeCarID($child->id);
            $model->setDistance($child->values['delivery_km']);
            if($model->getDistance() < 0.0001){
                $model->setDistance($child->getElementValue('shop_delivery_id', 'km'));
            }
            $model->setShopClientToID($child->values['shop_client_id']);
            $model->setQuantity($child->values['quantity']);
            $model->setShopProductID($child->values['shop_product_id']);
            $model->setShopBranchFromID($child->values['shop_id']);
            $model->setDate($getDate($child->values['exit_at']));
            $model->setProductName($child->getElementValue('shop_product_id'));

            if($model->id < 1){
                $model->setIsWage($modelTransport->getIsWage());
            }

            // получаем маршрут
            $model->setShopTransportRouteID(self::getRouteID($model, $sitePageData, $driver));
            // зарплата
            $model->setCoefficient($coefficient);
            $model->setWage(Api_Ab1_Shop_Transport_Route::getWageCar($model, $sitePageData, $driver));

            Helpers_DB::saveDBObject($model, $sitePageData, $sitePageData->shopID);
        }

        $params = Request_RequestParams::setParams(
            array(
                'shop_transport_id' => $shopTransportID,
                'weighted_exit_at_from' => $dateFrom,
                'weighted_exit_at_to' => $dateTo,
                'quantity_from' => 0,
            )
        );

        // получаем прочие перемещение
        $ids = Request_Request::find(
            'DB_Ab1_Shop_Move_Other', 0, $sitePageData, $driver, $params, 0, true,
            ['shop_material_other_id' => ['name'], 'shop_material_id' => ['name']]
        );

        // добавляем ссылки на путевой лист
        $driver->updateObjects(
            Model_Ab1_Shop_Move_Other::TABLE_NAME, $ids->getChildArrayID(),
            array('shop_transport_waybill_id' => $shopTransportWaybillID)
        );

        foreach ($ids->childs as $child){
            $shopTransportWaybillCarIDs->childShiftSetModel($model, 0, 0, false, array('shop_move_other_id' => $child->id));

            $model->setShopTransportID($shopTransportID);
            $model->setShopTransportWaybillID($shopTransportWaybillID);
            $model->setShopTransportDriverID($shopTransportDriverID);
            $model->setCountTrip(1);
            $model->setShopMoveOtherID($child->id);
            $model->setShopMovePlaceToID($child->values['shop_move_place_id']);
            $model->setQuantity($child->values['quantity']);
            $model->setShopMaterialOtherID($child->values['shop_material_other_id']);
            $model->setShopMaterialID($child->values['shop_material_id']);
            $model->setShopBranchFromID($child->values['shop_id']);
            $model->setDate($getDate($child->values['weighted_exit_at']));
            $model->setProductName(trim($child->getElementValue('shop_material_other_id') . ' ' . $child->getElementValue('shop_material_id')));

            if($model->id < 1){
                $model->setIsWage($modelTransport->getIsWage());
            }

            // получаем маршрут
            $model->setShopTransportRouteID(self::getRouteID($model, $sitePageData, $driver));
            // зарплата
            $model->setCoefficient($coefficient);
            $model->setWage(Api_Ab1_Shop_Transport_Route::getWageCar($model, $sitePageData, $driver));

            Helpers_DB::saveDBObject($model, $sitePageData, $sitePageData->shopID);
        }

        $params = Request_RequestParams::setParams(
            array(
                'shop_transport_id' => $shopTransportID,
                'created_at_from' => $dateFrom,
                'created_at_to' => $dateTo,
            )
        );

        // получаем завоз материала
        $ids = Request_Request::find(
            'DB_Ab1_Shop_Car_To_Material', 0, $sitePageData, $driver, $params, 0, true,
            array(
                'shop_daughter_id' => array('daughter_weight_id'),
                'shop_material_id' => ['name'],
            )
        );
        // добавляем ссылки на путевой лист у завоза материала
        $driver->updateObjects(
            Model_Ab1_Shop_Car_To_Material::TABLE_NAME, $ids->getChildArrayID(),
            array('shop_transport_waybill_id' => $shopTransportWaybillID)
        );

        foreach ($ids->childs as $child){
            $quantity = Api_Ab1_Shop_Car_To_Material::getQuantity($child);
            if($quantity < 0.0001){
                continue;
            }

            $shopTransportWaybillCarIDs->childShiftSetModel($model, 0, 0, false, array('shop_car_to_material_id' => $child->id));

            $model->setShopTransportID($shopTransportID);
            $model->setShopTransportWaybillID($shopTransportWaybillID);
            $model->setShopTransportDriverID($shopTransportDriverID);
            $model->setCountTrip(1);
            $model->setShopCarToMaterialID($child->id);
            $model->setShopBranchFromID($child->values['shop_branch_daughter_id']);
            $model->setShopBranchToID($child->values['shop_branch_receiver_id']);
            $model->setShopDaughterFromID($child->values['shop_daughter_id']);
            $model->setQuantity($quantity);
            $model->setShopMaterialID($child->values['shop_material_id']);
            $model->setProductName($child->getElementValue('shop_material_id'));

            $model->setDate($getDate($child->values['created_at']));

            if($model->id < 1){
                $model->setIsWage($modelTransport->getIsWage());
            }

            // получаем маршрут
            $model->setShopTransportRouteID(self::getRouteID($model, $sitePageData, $driver));
            // зарплата
            $model->setCoefficient($coefficient);
            $model->setWage(Api_Ab1_Shop_Transport_Route::getWageCar($model, $sitePageData, $driver));

            Helpers_DB::saveDBObject($model, $sitePageData, $sitePageData->shopID);
        }

        // получаем ID работника
        $shopWorkerID = Request_Request::findOneByIDResultField(
            DB_Ab1_Shop_Transport_Driver::NAME, $shopTransportDriverID, 'shop_worker_id', 0,
            $sitePageData, $driver
        );

        // получаем производство на склад
        $ids = Request_Request::find(
            'DB_Ab1_Shop_Product_Storage', 0, $sitePageData, $driver, $params, 0, true,
            array(
                'shop_product_id' => ['name'],
            )
        );
        // добавляем ссылки на путевой лист у завоза материала
        $driver->updateObjects(
            Model_Ab1_Shop_Product_Storage::TABLE_NAME, $ids->getChildArrayID(),
            array('shop_transport_waybill_id' => $shopTransportWaybillID)
        );

        foreach ($ids->childs as $child){
            $quantity = $child->values['quantity'];
            if($quantity < 0.0001){
                continue;
            }

            $shopTransportWaybillCarIDs->childShiftSetModel($model, 0, 0, false, array('shop_product_storage_id' => $child->id));

            $model->setShopTransportID($shopTransportID);
            $model->setShopTransportWaybillID($shopTransportWaybillID);
            $model->setShopTransportDriverID($shopTransportDriverID);
            $model->setCountTrip(1);
            $model->setShopProductStorageID($child->id);
            $model->setShopBranchFromID($child->values['shop_id']);
            $model->setShopBranchToID($child->values['shop_id']);
            $model->setShopStorageToID($child->values['shop_storage_id']);
            $model->setQuantity($quantity);
            $model->setShopProductID($child->values['shop_product_id']);
            $model->setProductName($child->getElementValue('shop_product_id'));

            $model->setDate($getDate($child->values['created_at']));

            if($model->id < 1){
                $model->setIsWage($modelTransport->getIsWage());
            }

            // получаем маршрут
            $model->setShopTransportRouteID(self::getRouteID($model, $sitePageData, $driver));
            // зарплата
            $model->setCoefficient($coefficient);
            $model->setWage(Api_Ab1_Shop_Transport_Route::getWageCar($model, $sitePageData, $driver));

            Helpers_DB::saveDBObject($model, $sitePageData, $sitePageData->shopID);
        }

        // получаем ID работника
        $shopWorkerID = Request_Request::findOneByIDResultField(
            DB_Ab1_Shop_Transport_Driver::NAME, $shopTransportDriverID, 'shop_worker_id', 0,
            $sitePageData, $driver
        );

        $params = Request_RequestParams::setParams(
            array(
                'shop_transport_id' => $shopTransportID,
                'shop_ballast_driver_id.shop_worker_id' => $shopWorkerID,
                'date_from' => $dateFrom,
                'date_to' => $dateTo,
            )
        );

        // получаем балласт
        $ids = Request_Request::find(
            'DB_Ab1_Shop_Ballast', 0, $sitePageData, $driver, $params, 0, true,
            array(
                'shop_ballast_distance_id' => array('distance'),
                'shop_raw_id' => ['name'],
            )
        );

        // добавляем ссылки на путевой лист у балласта
        $driver->updateObjects(
            Model_Ab1_Shop_Ballast::TABLE_NAME, $ids->getChildArrayID(),
            array('shop_transport_waybill_id' => $shopTransportWaybillID)
        );

        foreach ($ids->childs as $child){
            $shopTransportWaybillCarIDs->childShiftSetModel($model, 0, 0, false, array('shop_ballast_id' => $child->id));

            $model->setShopTransportID($shopTransportID);
            $model->setShopTransportWaybillID($shopTransportWaybillID);
            $model->setShopTransportDriverID($shopTransportDriverID);
            $model->setCountTrip(1);
            $model->setShopBallastID($child->id);
            $model->setShopBranchFromID($child->values['shop_id']);
            $model->setDistance($child->getElementValue('shop_ballast_distance_id', 'distance', '0'));
            $model->setShopBallastDistanceID($child->values['shop_ballast_distance_id']);
            $model->setShopBallastCrusherFromID($child->values['take_shop_ballast_crusher_id']);
            $model->setShopBallastCrusherToID($child->values['shop_ballast_crusher_id']);
            $model->setQuantity($child->values['quantity']);
            $model->setShopRawID($child->values['shop_raw_id']);
            $model->setDate($getDate($child->values['date']));
            $model->setProductName($child->getElementValue('shop_raw_id'));

            if($model->id < 1){
                $model->setIsWage($modelTransport->getIsWage());
            }

            // получаем маршрут
            $model->setShopTransportRouteID(self::getRouteID($model, $sitePageData, $driver));
            // зарплата
            $model->setCoefficient($coefficient);
            $model->setWage(Api_Ab1_Shop_Transport_Route::getWageCar($model, $sitePageData, $driver));

            Helpers_DB::saveDBObject($model, $sitePageData, $sitePageData->shopID);
        }

        // получаем перевозки внутри карьера
        $ids = Request_Request::find(
            'DB_Ab1_Shop_Transportation', 0, $sitePageData, $driver, $params, 0, true,
            array(
                'shop_ballast_distance_id' => array('distance'),
            )
        );

        // добавляем ссылки на путевой лист у перевозки внутри карьера
        $driver->updateObjects(
            Model_Ab1_Shop_Transportation::TABLE_NAME, $ids->getChildArrayID(),
            array('shop_transport_waybill_id' => $shopTransportWaybillID)
        );

        foreach ($ids->childs as $child){
            $shopTransportWaybillCarIDs->childShiftSetModel($model, 0, 0, false, array('shop_transportation_id' => $child->id));

            $model->setShopTransportID($shopTransportID);
            $model->setShopTransportWaybillID($shopTransportWaybillID);
            $model->setShopTransportDriverID($shopTransportDriverID);
            $model->setCountTrip($child->values['flight']);
            $model->setShopTransportationID($child->id);
            $model->setShopBranchFromID($child->values['shop_id']);
            $model->setDistance($child->getElementValue('shop_ballast_distance_id', 'distance', '0'));
            $model->setShopBallastDistanceID($child->values['shop_ballast_distance_id']);
            $model->setShopTransportationPlaceToID($child->values['shop_transportation_place_id']);
            $model->setQuantity($child->values['quantity']);
            $model->setDate($getDate($child->values['date']));
            $model->setProductName('');

            if($model->id < 1){
                $model->setIsWage($modelTransport->getIsWage());
            }

            // получаем маршрут
            $model->setShopTransportRouteID(self::getRouteID($model, $sitePageData, $driver));
            // зарплата
            $model->setCoefficient($coefficient);
            $model->setWage(Api_Ab1_Shop_Transport_Route::getWageCar($model, $sitePageData, $driver));

            Helpers_DB::saveDBObject($model, $sitePageData, $sitePageData->shopID);
        }

        // удаляем лишние
        $driver->deleteObjectIDs(
            $shopTransportWaybillCarIDs->getChildArrayID(), $sitePageData->userID,
            Model_Ab1_Shop_Transport_Waybill_Car::TABLE_NAME, array(), $sitePageData->shopID
        );

        // пересчитываем общую сумму зарплаты
        self::recalcWageTransportCar($shopTransportWaybillID, $sitePageData, $driver);

        return true;
    }

    /**
     * Считаем выработки водителя
     * @param $shopTransportWaybillID
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @return mixed
     * @throws HTTP_Exception_404
     */
    public static function calcDriverWorksWaybill($shopTransportWaybillID, SitePageData $sitePageData,
                                                  Model_Driver_DBBasicDriver $driver){
        $model = new Model_Ab1_Shop_Transport_Waybill();
        $model->setDBDriver($driver);

        if (! Helpers_DB::getDBObject($model, $shopTransportWaybillID, $sitePageData)) {
            throw new HTTP_Exception_404('Waybill id="' . $shopTransportWaybillID . '" not is found!');
        }

        return self::calcDriverWorks($model, $sitePageData, $driver);
    }

    /**
     * Считаем выработки водителя зависящие от перевозок
     * @param Model_Ab1_Shop_Transport_Waybill $model
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @return bool
     * @throws HTTP_Exception_404
     */
    public static function calcDriverWorks(Model_Ab1_Shop_Transport_Waybill $model, SitePageData $sitePageData,
                                           Model_Driver_DBBasicDriver $driver)
    {
        if(Func::_empty($model->getToAt())){
            return false;
        }

        // получаем итоговые значения ранее сохраненных машин
        $params = Request_RequestParams::setParams(
            array(
                'shop_transport_waybill_id' => $model->id
            )
        );
        $shopTransportWaybillCarIDs = Request_Request::find(
            DB_Ab1_Shop_Transport_Waybill_Car::NAME, 0, $sitePageData, $driver, $params
        );

        $totalCountTrip = 0;
        $totalQuantity = 0;
        foreach ($shopTransportWaybillCarIDs->childs as $child){
            $totalCountTrip += $child->values['count_trip'];
            $totalQuantity += $child->values['quantity'] * $child->values['count_trip'];
        }

        // получаем список выработок водителя
        $params = Request_RequestParams::setParams(
            array(
                'shop_transport_waybill_id' => $model->id,
            )
        );
        $workDriverIDs = Request_Request::find(
            DB_Ab1_Shop_Transport_Waybill_Work_Driver::NAME, 0, $sitePageData, $driver,
            $params, 0, true,
            array(
                'shop_transport_work_id' => array('indicator_type_id'),
            )
        );

        $trailerID = Request_Request::findOne(
            DB_Ab1_Shop_Transport_Waybill_Trailer::NAME, 0,
            $sitePageData, $driver,
            Request_RequestParams::setParams(
                array(
                    'shop_transport_waybill_id' => $model->id,
                )
            )
        );

        $modelTransport = new Model_Ab1_Shop_Transport();
        $modelTransport->setDBDriver($driver);

        if($trailerID != null){
            if (! Helpers_DB::getDBObject($modelTransport, $trailerID->values['shop_transport_id'], $sitePageData, $sitePageData->shopMainID)) {
                throw new HTTP_Exception_404('Transport id="' . $model->getShopTransportID() . '" not is found!');
            }
        }
        if($modelTransport->getDriverNormDay() <= 0) {
            if (!Helpers_DB::getDBObject($modelTransport, $model->getShopTransportID(), $sitePageData, $sitePageData->shopMainID)) {
                throw new HTTP_Exception_404('Transport id="' . $model->getShopTransportID() . '" not is found!');
            }
        }

        if($model->getTransportWageID() == Model_Ab1_Transport_Wage::WAGE_TECHNOLOGY) {
            // получаем предыдущий путевый лист, который был создан ранее менее 4 часов
            $params = Request_RequestParams::setParams(
                array(
                    'shop_transport_driver_id' => $model->getShopTransportDriverID(),
                    'to_at_from' => Helpers_DateTime::minusMinutes($model->getFromAt(), 4 * 60),
                    'to_at_to' => $model->getToAt(),
                    'id_not' => $model->id,
                )
            );
            $modelPrevious = Request_Request::findOneModel(
                DB_Ab1_Shop_Transport_Waybill::NAME, 0, $sitePageData, $driver, $params
            );

            if ($modelPrevious != false) {
                $params = Request_RequestParams::setParams(
                    array(
                        'shop_transport_waybill_id' => $modelPrevious->id,
                        'shop_transport_work_id.indicator_type_id' => [
                            Model_Ab1_Indicator_Type::INDICATOR_TYPE_NORM_TIME,
                        ],
                    )
                );
                $carIDsPrevious = Request_Request::find(
                    DB_Ab1_Shop_Transport_Waybill_Work_Driver::NAME, 0, $sitePageData, $driver, $params,
                    0, true, ['shop_transport_work_id' => ['indicator_type_id']]
                );

                $carIDsPrevious->runIndex(true, Model_Basic_DBGlobalObject::FIELD_ELEMENTS . '.shop_transport_work_id.indicator_type_id');
            } else {
                $carIDsPrevious = new MyArray();
            }
        } else {
            $carIDsPrevious = new MyArray();
        }

        $modelWork = new Model_Ab1_Shop_Transport_Waybill_Work_Driver();
        $modelWork->setDBDriver($driver);

        $normDay = self::getCountWorkNormHours(
            $model->getFromAt(), $model->getToAt(), $model->getTransportWageID(), $modelTransport->getDriverNormDay()
        );

        foreach ($workDriverIDs->childs as $child){
            switch ($child->getElementValue('shop_transport_work_id', 'indicator_type_id')){
                case Model_Ab1_Indicator_Type::INDICATOR_TYPE_COUTN_TRIP:
                    $child->setModel($modelWork);
                    $modelWork->setQuantity($totalCountTrip);
                    Helpers_DB::saveDBObject($modelWork, $sitePageData, $sitePageData->shopID);
                    break;
                case Model_Ab1_Indicator_Type::INDICATOR_TYPE_WEIGHT:
                    $child->setModel($modelWork);
                    $modelWork->setQuantity($totalQuantity);
                    Helpers_DB::saveDBObject($modelWork, $sitePageData, $sitePageData->shopID);
                    break;
                case Model_Ab1_Indicator_Type::INDICATOR_TYPE_MILAGE:
                    $child->setModel($modelWork);
                    $modelWork->setQuantity($model->getMilage());
                    Helpers_DB::saveDBObject($modelWork, $sitePageData, $sitePageData->shopID);
                    break;
                case Model_Ab1_Indicator_Type::INDICATOR_TYPE_MILAGE_GARGO:
                    $child->setModel($modelWork);
                    $modelWork->setQuantity($model->getMilage() / 2);
                    Helpers_DB::saveDBObject($modelWork, $sitePageData, $sitePageData->shopID);
                    break;
                case Model_Ab1_Indicator_Type::INDICATOR_TYPE_ALL_TIME:
                    $child->setModel($modelWork);
                    $modelWork->setQuantity(ceil(Helpers_DateTime::diffHours($model->getToAt(), $model->getFromAt())));
                    Helpers_DB::saveDBObject($modelWork, $sitePageData, $sitePageData->shopID);
                    break;
                case Model_Ab1_Indicator_Type::INDICATOR_TYPE_NORM_TIME:
                    $child->setModel($modelWork);

                    $norm = self::getCountWorkNormHours(
                        $model->getFromAt(), $model->getToAt(), $model->getTransportWageID(),
                        $modelTransport->getDriverNormDay(), true
                    );

                    // отнимаем предыдущую норму
                    if($model->getTransportWageID() != Model_Ab1_Transport_Wage::WAGE_TECHNOLOGY
                        && key_exists(Model_Ab1_Indicator_Type::INDICATOR_TYPE_NORM_TIME, $carIDsPrevious->childs)){
                        $norm -=  $carIDsPrevious->childs[Model_Ab1_Indicator_Type::INDICATOR_TYPE_NORM_TIME]->values['quantity'];
                        if($norm < 0){
                            $norm = 0;
                        }
                    }

                    $modelWork->setQuantity($norm);
                    Helpers_DB::saveDBObject($modelWork, $sitePageData, $sitePageData->shopID);
                    break;
                case Model_Ab1_Indicator_Type::INDICATOR_TYPE_HOLIDAY_TIME:
                    $child->setModel($modelWork);
                    $modelWork->setQuantity(
                        self::getCountWorkHolidayHours(
                            $model->getFromAt(), $model->getToAt(), $normDay, $model->getTransportWageID(),
                            $sitePageData, $driver
                        )
                    );
                    Helpers_DB::saveDBObject($modelWork, $sitePageData, $sitePageData->shopID);
                    break;
                case Model_Ab1_Indicator_Type::INDICATOR_TYPE_NIGHT_TIME:
                    $child->setModel($modelWork);
                    $modelWork->setQuantity(self::getCountWorkNightHours($model->getFromAt(), $model->getToAt()));
                    Helpers_DB::saveDBObject($modelWork, $sitePageData, $sitePageData->shopID);
                    break;
                case Model_Ab1_Indicator_Type::INDICATOR_TYPE_OVERTIME:
                    $child->setModel($modelWork);

                    $sunHours = 8;
                    // отнимаем предыдущие часы работы
                    if(key_exists(Model_Ab1_Indicator_Type::INDICATOR_TYPE_NORM_TIME, $carIDsPrevious->childs)){
                        $sunHours -=  $carIDsPrevious->childs[Model_Ab1_Indicator_Type::INDICATOR_TYPE_NORM_TIME]->values['quantity'];
                        if($sunHours < 0){
                            $sunHours = 0;
                        }
                    }

                    $modelWork->setQuantity(
                        self::getCountWorkOverTimeHours(
                            $model->getFromAt(), $model->getToAt(), $normDay, $sunHours, $model->getTransportWageID(),
                            $sitePageData, $driver
                        )
                    );

                    Helpers_DB::saveDBObject($modelWork, $sitePageData, $sitePageData->shopID);
                    break;
                case Model_Ab1_Indicator_Type::INDICATOR_TYPE_WEIGHT_HOLIDAY:
                    $child->setModel($modelWork);
                    $modelWork->setQuantity(
                        self::getWeightHoliday(
                            $model->getFromAt(), $model->getToAt(), $shopTransportWaybillCarIDs, $model->getTransportWageID(), $sitePageData, $driver
                        )
                    );
                    Helpers_DB::saveDBObject($modelWork, $sitePageData, $sitePageData->shopID);
                    break;
            }
        }

        return true;
    }

    /**
     * Считаем количество перевезенного груза в выходные дни
     * @param $dateFrom
     * @param $dateTo
     * @param $shopTransportWaybillCarIDs
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @return int
     */
    public static function getWeightHoliday($dateFrom, $dateTo, $shopTransportWaybillCarIDs, $transportWageID,
                                            SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver){
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
            'DB_Ab1_Holiday', $sitePageData, $driver, $params, 0, TRUE
        );
        $holidayIDs->runIndex(true, 'day');

        $result = 0;
        foreach ($shopTransportWaybillCarIDs->childs as $child){
            $date = $child->values['date'];
            if(key_exists($date, $holidayIDs->childs)){
                if($transportWageID != Model_Ab1_Transport_Wage::WAGE_DUTY){ // Дежурка
                    $result += $child->values['quantity'] * $child->values['count_trip'];
                }elseif($holidayIDs->childs[$date]->values['is_free'] == 0){
                    $result += $child->values['quantity'] * $child->values['count_trip'];
                }
            }
        }

        return $result;
    }

    /**
     * Считаем количество часов сверхурочно
     * @param $dateFrom
     * @param $dateTo
     * @param $driverNormDay
     * @param $sunHours
     * @param $transportWageID
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @return int|mixed
     */
    public static function getCountWorkOverTimeHours($dateFrom, $dateTo, $driverNormDay, $sunHours, $transportWageID,
                                                     SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver){
        if($transportWageID == Model_Ab1_Transport_Wage::WAGE_DUTY){
            return 0;
        }

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
            'DB_Ab1_Holiday', $sitePageData, $driver, $params, 0, TRUE
        );
        $holidayIDs->runIndex(true, 'day');

        $days = self::_breakDayNightSun($dateFrom, $dateTo, $driverNormDay, $sunHours, $transportWageID == Model_Ab1_Transport_Wage::WAGE_TECHNOLOGY);

        $result = 0;
        foreach ($days as $date => $day){
            if(!key_exists($date, $holidayIDs->childs)){
                if($transportWageID == Model_Ab1_Transport_Wage::WAGE_TECHNOLOGY) {
                    $result += $day['all'];
                }else{
                    $result += $day['overtime'];
                }
            }
        }

        if($transportWageID == Model_Ab1_Transport_Wage::WAGE_TECHNOLOGY) {
            $result -= $sunHours;
            if($result < 0){
                $result = 0;
            }
        }

        return $result;
    }

    /**
     * Считаем количество часов ночью
     * @param $dateFrom
     * @param $dateTo
     * @return int
     */
    public static function getCountWorkNightHours($dateFrom, $dateTo){
        $days = self::_breakDayNightSun($dateFrom, $dateTo);

        $result = 0;
        foreach ($days as $date => $day){
            $result += $day['night'];
        }

        return $result;
    }

    /**
     * Считаем количество часов в выходные дни
     * @param $dateFrom
     * @param $dateTo
     * @param $driverNormDay
     * @param $transportWageID
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @return int
     */
    public static function getCountWorkHolidayHours($dateFrom, $dateTo, $driverNormDay, $transportWageID,
                                                    SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver){
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
            'DB_Ab1_Holiday', $sitePageData, $driver, $params, 0, TRUE
        );
        $holidayIDs->runIndex(true, 'day');

        $days = self::_breakDayNightSun($dateFrom, $dateTo, $driverNormDay);

        $result = 0;
        $hours = ceil(Helpers_DateTime::diffHours($dateTo, $dateFrom));
        if($transportWageID == Model_Ab1_Transport_Wage::WAGE_CAR && $hours < 24) {
            $all = 0;
            foreach ($days as $date => $day) {
                if (key_exists($date, $holidayIDs->childs)) {
                    $all += $day['all'];
                }
            }

            if ($all > $driverNormDay) {
                $all = $driverNormDay;
            }

            $result += $all;
        }else {
            foreach ($days as $date => $day) {
                if (key_exists($date, $holidayIDs->childs)) {
                    $all = $day['all'];
                    if ($transportWageID == Model_Ab1_Transport_Wage::WAGE_CAR && $all > $driverNormDay) {
                        $all = $driverNormDay;
                    }

                    if ($transportWageID != Model_Ab1_Transport_Wage::WAGE_DUTY) { // Дежурка
                        $result += $all;
                    } elseif ($holidayIDs->childs[$date]->values['is_free'] == 0) {
                        $result += $all;
                    }
                }
            }
        }

        return $result;
    }

    /**
     * Считаем количество часов по норме
     * @param $dateFrom
     * @param $dateTo
     * @param $transportWageID
     * @param $driverNormDay
     * @param bool $isDays
     * @return float|int
     */
    public static function getCountWorkNormHours($dateFrom, $dateTo, $transportWageID, $driverNormDay, $isDays = false){
        if($transportWageID == Model_Ab1_Transport_Wage::WAGE_TECHNOLOGY){ // технология
            return ceil(Helpers_DateTime::diffHours($dateTo, $dateFrom));
        }

        $result = ceil(Helpers_DateTime::diffHours($dateTo, $dateFrom));
        if($result > $driverNormDay){
            $result = $driverNormDay;
        }

        if($isDays){
            $hours = ceil(Helpers_DateTime::diffHours($dateTo, $dateFrom));

            if($hours % 24 >= 8){
                $days = ceil($hours / 24);
            }else{
                $days = intdiv($hours, 24);
            }
            if($days < 1){
                $days = 1;
            }

            $result = $result * $days;
        }

        return  $result;
    }

    /**
     * Разбиваем период на дни с указание дневных, ночных и сверхурочных часов
     * @param $dateFrom
     * @param $dateTo
     * @param int $driverNormDay
     * @param int $sunHours
     * @param bool $isOneDay
     * @return array
     */
    private static function _breakDayNightSun($dateFrom, $dateTo, $driverNormDay = 0, $sunHours = 8, bool $isOneDay = false){
        if($driverNormDay > 24){
            $driverNormDay = 24;
        }

        $result = array();

        $addTimeDay = function ($dateFrom, $dateTo, $driverNormDay, $sunHours = 8, bool $isOneDay = false){
            $result = array(
                'sun' => 0,
                'night' => 0,
                'overtime' => 0,
                'all' => ceil(Helpers_DateTime::diffHours($dateTo, $dateFrom)),
            );

            $dayBegin = Helpers_DateTime::getDateFormatPHP($dateFrom);

            $dFrom = strtotime($dateFrom);
            $dTo = strtotime($dateTo);

            $h6 = strtotime($dayBegin . ' 06:00:00');
            $h22 = strtotime($dayBegin . ' 22:00:00');

            if($dTo <= $h6){
                $result['night'] = ceil(Helpers_DateTime::diffHours($dateTo, $dateFrom));
                $result['sun'] = 0;
            }else{
                if($dFrom < $h6){
                    $result['night'] = ceil(Helpers_DateTime::diffHours($dayBegin . ' 06:00:00', $dateFrom));
                    $dateFrom = $dayBegin . ' 06:00:00';
                }

                if($dTo > $h22){
                    $hours = ceil(Helpers_DateTime::diffHours($dayBegin . ' 22:00:00', $dateFrom));
                }else {
                    $hours = ceil(Helpers_DateTime::diffHours($dateTo, $dateFrom));
                }

                if($hours >= $driverNormDay){
                    $result['sun'] = $driverNormDay;
                    $result['overtime'] = $hours - $sunHours;

                    if($driverNormDay - $sunHours < $result['overtime']){
                        $result['overtime'] = $driverNormDay - $sunHours;
                    }

                    if($result['overtime'] < 0){
                        $result['overtime'] = 0;
                    }
                }elseif($hours > $sunHours){
                    $result['sun'] = $hours;
                    $result['overtime'] = $hours - $sunHours;
                }else {
                    $result['sun'] = $hours;
                }

                if($dTo > $h22) {
                    if($dFrom < $h22) {
                        $result['night'] += ceil(Helpers_DateTime::diffHours($dateTo, $dayBegin . ' 22:00:00'));

                        $hours += ceil(Helpers_DateTime::diffHours($dateTo, $dayBegin . ' 22:00:00'));
                        if($hours >= $driverNormDay){
                            $result['overtime'] = $hours - $sunHours;

                            if($driverNormDay - $sunHours < $result['overtime']){
                                $result['overtime'] = $driverNormDay - $sunHours;
                            }

                            if($result['overtime'] < 0){
                                $result['overtime'] = 0;
                            }
                        }elseif($hours > $sunHours){
                            $result['overtime'] = $hours - $sunHours;
                        }
                    }else{
                        $result['night'] += ceil(Helpers_DateTime::diffHours($dateTo, $dateFrom));

                    }
                }
            }

            // сверхурочные
            if($isOneDay) {
                if ($result['all'] > $sunHours) {
                    if ($driverNormDay > $result['all']) {
                        $tmp = $driverNormDay;
                    } else {
                        $tmp = $result['all'];
                    }

                    $result['overtime'] = $tmp - $sunHours;
                    if ($result['overtime'] < 0) {
                        $result['overtime'] = 0;
                    }
                }
            }

            return $result;
        };

        $dFrom = strtotime($dateFrom);
        $dTo = strtotime($dateTo);

        // если период нулевой или меньше 0
        if($dFrom >= $dTo){
            $result[Helpers_DateTime::getDateFormatPHP($dateFrom)] = array(
                'sun' => 0,
                'night' => 0,
                'overtime' => 0,
                'all' => 0,
            );
            return $result;
        };


        $dayBegin = strtotime(Helpers_DateTime::getDateFormatPHP($dateFrom));

        // в рамках первого дня
        if($dFrom != $dayBegin){
            if($dTo > $dayBegin + 24 * 60 * 60){
                $dayEnd = date('Y-m-d', $dayBegin + 24 * 60 * 60);
            }else{
                $dayEnd = $dateTo;
            }

            $result[Helpers_DateTime::getDateFormatPHP($dateFrom)] = $addTimeDay($dateFrom, $dayEnd, $driverNormDay, $sunHours);
        }

        // в рамках дня
        if($dTo <= $dayBegin + 24 * 60 * 60) {
            return $result;
        }

        // в рамках полных дней
        if($dayBegin == strtotime($dateFrom)){
            $dFrom = $dayBegin;
        }else {
            $dFrom = $dayBegin + 24 * 60 * 60;
        }
        $dTo = strtotime(Helpers_DateTime::getDateFormatPHP($dateTo));

        while ($dFrom < $dTo){
            if($dFrom != $dayBegin) {
                $sunHours = 8;
            }

            $result[date('Y-m-d', $dFrom)] = array(
                'sun' => $driverNormDay,
                'night' => 8,
                'overtime' => $driverNormDay - $sunHours,
                'all' => 24,
            );

            $dFrom += 24 * 60 * 60;
            $sunHours = 8;
        }

        // в рамках последнего дня
        if(strtotime($dateTo) != $dTo){
            $result[Helpers_DateTime::getDateFormatPHP($dateTo)] = $addTimeDay(Helpers_DateTime::getDateFormatPHP($dateTo), $dateTo, $driverNormDay);
        }

        return $result;
    }

    /**
     * Получаем список зарплат сотрудников по параметрам выработки и оплатам по маршрутам
     * @param $dateFrom
     * @param $dateTo
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driverDB
     * @return MyArray
     */
    public static function getDriverTotalWages($dateFrom, $dateTo, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driverDB){

        //echo '<pre>';
        $dataParams = [
            'route_holiday' => 0,
            'route_day' => 0,
            'days' => 0,
            'salary' => 0,
            'salary_month' => 0,
            'class_amount' => 0,
        ];

        $drivers = $dataParams;
        $drivers['data'] = [];
        $works = [
            'amount' => 0,
            'quantity' => 0,
            'data' => [],
        ];


        /******************************************/
        // праздничные и выходные дни
        $holidayIDs = Api_Ab1_Holiday::getHolidays($dateFrom, $dateTo, $sitePageData, $driverDB);

        // узнаем количество рабочих дней и часов

        $workDays = 0;
        foreach ($holidayIDs->childs as $day => $child){
            if(strtotime($day) >= strtotime($dateFrom)){
                $workDays++;
            }
        }

        $workDays = Helpers_DateTime::diffDays(Helpers_DateTime::getDateFormatPHP($dateTo), Helpers_DateTime::getDateFormatPHP($dateFrom));
        - $workDays;
        $workHours = $workDays * 8;


        /******************************************/
        // получаем список вид работ
        $workIDs = Request_Request::findAllNotShop(
            DB_Ab1_Transport_Work::NAME, $sitePageData, $driverDB,true
        );
        $workIDs->runIndex();

        $model = new Model_Ab1_Transport_Work();

        $workTransports = [];
        foreach ($workIDs->childs as $child){
            $child->setModel($model);

            $workTransports[$model->id] = [];
            $list = $model->getShopTransportWorkIDsArray();
            foreach ($list as $item){
                $workTransports[$model->id][$item] = $item;
            }
        }


        /******************************************/
        // получаем список оплат водителей по рейсам
        $params = Request_RequestParams::setParams(
            array(
                'shop_transport_waybill_id.to_at_from_equally' => Helpers_DateTime::getDateFormatPHP($dateFrom),
                'shop_transport_waybill_id.to_at_to' => Helpers_DateTime::getDateFormatPHP($dateTo) . '23:59:59',
                'shop_transport_waybill_id.shop_id' => $sitePageData->shopID,
                'shop_transport_route_id_from' => 0,
                'is_wage' => true,
                'sort_by' => array(
                    'shop_transport_driver_id.name' => 'asc',
                )
            )
        );
        $workCarIDs = Request_Request::find(
            DB_Ab1_Shop_Transport_Waybill_Car::NAME, 0, $sitePageData, $driverDB,
            $params, 0, true,
            array(
                'shop_transport_driver_id' => array('name'),
                'shop_transport_driver_id.shop_transport_class_id' => array('percent'),
                'shop_transport_waybill_id' => array('transport_work_id', 'transport_form_payment_id'),
                'shop_transport_id' => array('shop_branch_storage_id'),
            )
        );

        foreach ($workCarIDs->childs as $child){
            // проверяем, что рейс должен быть оплачен
            $payment = $child->getElementValue('shop_transport_waybill_id', 'transport_form_payment_id');
            if($payment != Model_Ab1_Transport_FormPayment::FORM_PAYMENT_PIECE_RATE
                && $child->getElementValue('shop_transport_id', 'shop_branch_storage_id') != $child->values['shop_branch_to_id']){
                continue;
            }

            $transportWork = $child->getElementValue('shop_transport_waybill_id', 'transport_work_id', 0);
            if(!key_exists($transportWork, $workTransports)){
                continue;
            }

            // водитель
            $driver = $child->values['shop_transport_driver_id'];
            if(!key_exists($driver, $drivers['data'])){
                $drivers['data'][$driver] = $dataParams;
                $drivers['data'][$driver]['name'] = $child->getElementValue('shop_transport_driver_id');
                $drivers['data'][$driver]['id'] = $driver;
                $drivers['data'][$driver]['data'] = [];
            }

            // вид работ траспорта
            if(!key_exists($transportWork, $drivers['data'][$driver]['data'])){
                $transportWorkData = $workIDs->childs[$transportWork];

                $drivers['data'][$driver]['data'][$transportWork] = [
                    'name' => $transportWorkData->values['name'],
                    'salary' => $transportWorkData->values['salary'],
                    'salary_hour' => $transportWorkData->values['salary_hour'],
                    'salary_month' => 0,
                    'salary_hours' => 0,
                    'class_quantity' => $child->getElementValue('shop_transport_class_id', 'percent', 0),
                    'class_amount' => 0,
                    'route_holiday' => 0,
                    'route_day' => 0,
                    'works' => [],
                ];
            }


            $wage = $child->values['wage'];
            $drivers['data'][$driver]['data'][$transportWork]['route_day'] += $wage;
            $drivers['data'][$driver]['route_day'] += $wage;
            $drivers['route_day'] += $wage;

            if(key_exists($child->values['date'], $holidayIDs->childs)){
                $wage = round($wage / 2, 2);
                $drivers['data'][$driver]['data'][$transportWork]['route_holiday'] += $wage;
                $drivers['data'][$driver]['route_holiday'] += $wage;
                $drivers['route_holiday'] += $wage;
            }
        }


        /******************************************/
        // получаем список выработок водителя
        $params = Request_RequestParams::setParams(
            array(
                'shop_transport_waybill_id.to_at_from_equally' => Helpers_DateTime::getDateFormatPHP($dateFrom),
                'shop_transport_waybill_id.to_at_to' => Helpers_DateTime::getDateFormatPHP($dateTo) . '23:59:59',
                'shop_transport_waybill_id.shop_id' => $sitePageData->shopID,
                'quantity_from' => 0,
                'sum_quantity' => true,
                'group_by' => [
                    'shop_transport_driver_id', 'shop_transport_driver_id.name',
                    'shop_transport_work_id', 'shop_transport_work_id.name',
                    'shop_transport_waybill_id.transport_work_id',
                    'shop_transport_driver_id.shop_transport_class_id.percent',
                ],
            )
        );
        $workDriverIDs = Request_Request::find(
            DB_Ab1_Shop_Transport_Waybill_Work_Driver::NAME, 0, $sitePageData, $driverDB,
            $params, 0, true,
            array(
                'shop_transport_driver_id' => array('name'),
                'shop_transport_work_id' => array('name'),
                'transport_work_id' => array('name'),
                'shop_transport_driver_id.shop_transport_class_id' => array('percent'),
            )
        );

        foreach ($workDriverIDs->childs as $child){
            $transportWork = $child->getElementValue('shop_transport_waybill_id', 'transport_work_id', 0);
            if(!key_exists($transportWork, $workTransports)){
                continue;
            }

            $work = $child->values['shop_transport_work_id'];
            if(!key_exists($work, $workTransports[$transportWork])){
                continue;
            }

            // водитель
            $driver = $child->values['shop_transport_driver_id'];
            if(!key_exists($driver, $drivers['data'])){
                $drivers['data'][$driver] = $dataParams;
                $drivers['data'][$driver]['name'] = $child->getElementValue('shop_transport_driver_id');
                $drivers['data'][$driver]['id'] = $driver;
                $drivers['data'][$driver]['data'] = [];
            }

            // вид работ транспорта
            if(!key_exists($transportWork, $drivers['data'][$driver]['data'])){
                $transportWorkData = $workIDs->childs[$transportWork];

                $drivers['data'][$driver]['data'][$transportWork] = [
                    'name' => $transportWorkData->values['name'],
                    'salary' => $transportWorkData->values['salary'],
                    'salary_hour' => $transportWorkData->values['salary_hour'],
                    'salary_month' => 0,
                    'salary_hours' => 0,
                    'class_quantity' => $child->getElementValue('shop_transport_class_id', 'percent', 0),
                    'class_amount' => 0,
                    'route_holiday' => 0,
                    'route_day' => 0,
                    'works' => [],
                ];
            }

            $quantity = $child->values['quantity'];

            // вид работ водителя
            if(!key_exists($work, $drivers['data'][$driver]['data'][$transportWork]['works'])){
                $drivers['data'][$driver]['data'][$transportWork]['works'][$work] = [
                    'name' => $child->getElementValue('shop_transport_work_id'),
                    'quantity' => 0,
                    'amount' => 0,
                ];
            }
            $drivers['data'][$driver]['data'][$transportWork]['works'][$work]['quantity'] += $quantity;

            // общий список вид работ водителя
            if(!key_exists($work, $works['data'])){
                $works['data'][$work] = [
                    'name' => $child->getElementValue('shop_transport_work_id'),
                    'id' => $work,
                    'quantity' => 0,
                    'amount' => 0,
                ];
            }
            $works['data'][$work]['quantity'] += $quantity;
        }


        /******************************************/
        // получаем список путевые листов
        $params = Request_RequestParams::setParams(
            array(
                'to_at_from_equally' => Helpers_DateTime::getDateFormatPHP($dateFrom),
                'to_at_to' => Helpers_DateTime::getDateFormatPHP($dateTo) . '23:59:59',
                'shop_id' => $sitePageData->shopID,
            )
        );
        $transportWaybillIDs = Request_Request::find(
            DB_Ab1_Shop_Transport_Waybill::NAME, 0, $sitePageData, $driverDB,
            $params, 0, true,
            array(
                'shop_transport_driver_id' => array('name'),
            )
        );

        foreach ($transportWaybillIDs->childs as $child){
            $driver = $child->values['shop_transport_driver_id'];
            if(!key_exists($driver, $drivers['data'])){
                $drivers['data'][$driver] = $dataParams;
                $drivers['data'][$driver]['name'] = $child->getElementValue('shop_transport_driver_id');
                $drivers['data'][$driver]['id'] = $driver;
                $drivers['data'][$driver]['data'] = [];
            }

            $hours = ceil(Helpers_DateTime::diffHours($child->values['to_at'], $child->values['from_at']));
            $tmp = $hours % 24;
            $days = round(($hours - $tmp) / 24);
            if($tmp >= 9){
                $days++;
            }
            if($days < 1){
                $days = 1;
            }

            $drivers['data'][$driver]['days'] += $days;
        }


        /******************************************/
        // получаем ремонты
        $params = Request_RequestParams::setParams(
            array(
                'date_from_equally' => Helpers_DateTime::getDateFormatPHP($dateFrom),
                'date_to' => Helpers_DateTime::getDateFormatPHP($dateTo) . '23:59:59',
            )
        );
        $repairIDs = Request_Request::find(
            DB_Ab1_Shop_Transport_Repair::NAME, 0, $sitePageData, $driverDB,
            $params, 0, true,
            array(
                'shop_transport_driver_id' => array('name'),
            )
        );

        foreach ($repairIDs->childs as $child){
            // водитель
            $driver = $child->values['shop_transport_driver_id'];
            if(!key_exists($driver, $drivers['data'])){
                $drivers['data'][$driver] = $dataParams;
                $drivers['data'][$driver]['name'] = $child->getElementValue('shop_transport_driver_id');
                $drivers['data'][$driver]['id'] = $driver;
                $drivers['data'][$driver]['data'] = [];
            }

            // вид работ траспорта
            $transportWork = 'Ремонт';
            if(!key_exists($transportWork, $drivers['data'][$driver]['data'])){
                $drivers['data'][$driver]['data'][$transportWork] = [
                    'name' => 'Ремонт',
                    'salary' => 0,
                    'salary_hour' => 414.9,
                    'salary_month' => 0,
                    'salary_hours' => 0,
                    'class_quantity' => 0,
                    'class_amount' => 0,
                    'route_holiday' => 0,
                    'route_day' => 0,
                    'works' => [],
                ];
            }

            $hours = $child->values['hours'];

            // Норма времени
            $work = Model_Ab1_Shop_Transport_Work::WORK_NORM_ID;
            if(!key_exists($work, $drivers['data'][$driver]['data'][$transportWork]['works'])){
                $drivers['data'][$driver]['data'][$transportWork]['works'][$work] = [
                    'name' => 'Норма',
                    'quantity' => 0,
                    'amount' => 0,
                ];
            }
            $drivers['data'][$driver]['data'][$transportWork]['works'][$work]['quantity'] += $hours;

            // общий список вид работ водителя
            if(!key_exists($work, $works['data'])){
                $works['data'][$work] = [
                    'name' => 'Норма',
                    'id' => $work,
                    'quantity' => 0,
                    'amount' => 0,
                ];
            }
            $works['data'][$work]['quantity'] += $hours;

            if(key_exists($child->values['date'], $holidayIDs->childs)){
                // Выходные часы
                $work = Model_Ab1_Shop_Transport_Work::WORK_HOLIDAY_ID;
                if(!key_exists($work, $drivers['data'][$driver]['data'][$transportWork]['works'])){
                    $drivers['data'][$driver]['data'][$transportWork]['works'][$work] = [
                        'name' => 'Выходные',
                        'quantity' => 0,
                        'amount' => 0,
                    ];
                }
                $drivers['data'][$driver]['data'][$transportWork]['works'][$work]['quantity'] += $hours;

                // общий список вид работ водителя
                if(!key_exists($work, $works['data'])){
                    $works['data'][$work] = [
                        'name' => 'Выходные',
                        'id' => $work,
                        'quantity' => 0,
                        'amount' => 0,
                    ];
                }
                $works['data'][$work]['quantity'] += $hours;
            }
        }


        /******************************************/
        // считаем оклад + класстность 1458614 - id по норме
        foreach ($drivers['data'] as $driverID => $driver){
            foreach ($driver['data'] as $transportWorkID => $transportWork){
                $hours = 0;
                if(key_exists(Model_Ab1_Shop_Transport_Work::WORK_NORM_ID, $transportWork['works'])) {
                    $hours = $transportWork['works'][Model_Ab1_Shop_Transport_Work::WORK_NORM_ID]['quantity'];

                    unset($drivers['data'][$driverID]['data'][$transportWorkID]['works'][Model_Ab1_Shop_Transport_Work::WORK_NORM_ID]);
                }

                $salaryMonth = 0;
                if($transportWork['salary_hour'] > 0) {
                    $salaryMonth += $transportWork['salary_hour'] * $hours;
                }elseif($transportWork['salary'] > 0) {
                    $salaryMonth += round($transportWork['salary'] / $workHours * $hours, 2);
                }

                $drivers['data'][$driverID]['data'][$transportWorkID]['salary_month'] = $salaryMonth;
                $drivers['data'][$driverID]['data'][$transportWorkID]['salary_hours'] = $hours;

                $drivers['data'][$driverID]['data'][$transportWorkID]['class_amount'] = round(
                    $salaryMonth / 100 * $drivers['data'][$driverID]['data'][$transportWorkID]['class_quantity'], 2
                );
            }
        }
        unset($works['data'][Model_Ab1_Shop_Transport_Work::WORK_NORM_ID]);


        /******************************************/
        // оплаты по параметрам выработки
        foreach ($drivers['data'] as $driverID => $driver){
            foreach ($driver['data'] as $transportWorkID => $transportWork){
                foreach ($transportWork['works'] as $workID => $work) {
                    $hours = $work['quantity'];

                    $salaryMonth = 0;
                    if($transportWork['salary_hour'] > 0) {
                        $salaryMonth += $transportWork['salary_hour'] * $hours;
                    }elseif($transportWork['salary'] > 0) {
                        $salaryMonth += round($transportWork['salary'] / $workHours * $hours, 2);
                    }

                    $drivers['data'][$driverID]['data'][$transportWorkID]['works'][$workID]['amount'] = round($salaryMonth / 2, 0);
                    $works['data'][$workID]['amount'] += $salaryMonth;
                }
            }
        }


        /******************************************/
        // считаем общую сумму заработка
        foreach ($drivers['data'] as $driverID => $driver){

            $salary = $driver['route_day'] + $driver['route_holiday'];
            foreach ($driver['data'] as $transportWork){
                if(!key_exists('class_amount', $transportWork)){
                    echo '<pre>';
                    echo 1; print_r($driver); die;
                }

                $salary += $transportWork['salary_month']  + $transportWork['class_amount'];
                foreach ($transportWork['works'] as $work) {
                    $salary += $work['amount'];
                }
            }

            $drivers['data'][$driverID]['salary'] = $salary;
        }
        //print_r($drivers);die;

        return [
            'drivers' => $drivers,
            'works' => $works,
        ];
    }

    /**
     * Получае ID траспорта и марки прицепа путевого листа
     * @param $shopTransportWaybill
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @return array
     */
    public static function getTrailerByWaybill($shopTransportWaybill, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        // марка прицепа
        $trailerID = Request_Request::findOne(
            DB_Ab1_Shop_Transport_Waybill_Trailer::NAME, 0,
            $sitePageData, $driver,
            Request_RequestParams::setParams(
                array(
                    'shop_transport_waybill_id' => $shopTransportWaybill,
                )
            ),
            array(
                'shop_transport_id' => array('shop_transport_mark_id')
            )
        );

        $trailerMarkID = 0;
        $trailerShopTransportID = 0;
        if ($trailerID != null) {
            $trailerMarkID = $trailerID->getElementValue('shop_transport_id', 'shop_transport_mark_id');
            $trailerShopTransportID = $trailerID->values['shop_transport_id'];
        }

        return [
            'transport' => $trailerShopTransportID,
            'mark' => $trailerMarkID,
        ];
    }

    /**
     * Получае коэффициент для рейсов по причепу или по траспорту
     * @param $date
     * @param $shopTransportID
     * @param $trailerShopTransportID
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @return float
     */
    public static function getCoefficientRouteWageTransport($date, $shopTransportID, $trailerShopTransportID,
                                                            SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        $date = Helpers_DateTime::getDateFormatPHP($date);

        $ids = Request_Request::find(
            DB_Ab1_Shop_Transport_Driver_Tariff::NAME, 0,
            $sitePageData, $driver,
            Request_RequestParams::setParams(
                array(
                    'shop_transport_id' => [$shopTransportID, $trailerShopTransportID],
                    'date_from_to' => $date,
                    'date_to_from_equally' => $date,
                )
            ),
            0, true
        );
        $ids->runIndex(true, 'shop_transport_id');

        if(key_exists($trailerShopTransportID, $ids->childs) && $ids->childs[$trailerShopTransportID]->values['quantity'] > 0){
            return $ids->childs[$trailerShopTransportID]->values['quantity'];
        }

        if(key_exists($shopTransportID, $ids->childs) && $ids->childs[$shopTransportID]->values['quantity'] > 0){
            return $ids->childs[$shopTransportID]->values['quantity'];
        }

        return 1;
    }

    /**
     * Сохранение путевого листа из визуальной формы
     * @param Model_Ab1_Shop_Transport_Waybill $model
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @throws HTTP_Exception_404
     */
    public static function saveModel(Model_Ab1_Shop_Transport_Waybill $model, SitePageData $sitePageData,
                                     Model_Driver_DBBasicDriver $driver)
    {
        $model->setDBDriver($driver);

        /**** Сохраняем вид работ + вид транспорта в путевом листе *****/

        // марка прицепа
        $trailer = Api_Ab1_Shop_Transport_Waybill::getTrailerByWaybill(
            $model->id, $sitePageData, $driver
        );
        $trailerMarkID = $trailer['mark'];
        $trailerShopTransportID = $trailer['transport'];

        // марка транспорта
        $mark = Request_Request::findOneByID(
            DB_Ab1_Shop_Transport::NAME, $model->getShopTransportID(), $sitePageData->shopMainID,
            $sitePageData, $driver
        );
        $transportMarkID = 0;
        if($mark != null){
            $transportMarkID = $mark->values['shop_transport_mark_id'];
        }

        $transportViewID = Request_RequestParams::getParamInt('transport_view_id');
        $transportWorkID = Request_RequestParams::getParamInt('transport_work_id');
        $transportWageID = Request_RequestParams::getParamInt('transport_wage_id');
        $transportFormPaymentID = Request_RequestParams::getParamInt('transport_form_payment_id');

        $model->setTransportViewID($transportViewID);
        $model->setTransportWorkID($transportWorkID);
        $model->setTransportWageID($transportWageID);
        $model->setTransportFormPaymentID($transportFormPaymentID);

        if($trailerMarkID > 0) {
            $modelMark = new Model_Ab1_Shop_Transport_Mark();
            $modelMark->setDBDriver($driver);
            Helpers_DB::getDBObject($modelMark, $trailerMarkID, $sitePageData, $sitePageData->shopMainID);

            if($transportViewID < 1) {
                $model->setTransportViewID($modelMark->getTransportViewID());
            }
            if($transportWorkID < 1) {
                $model->setTransportWorkID($modelMark->getTransportWorkID());
            }
            if($transportWageID < 1) {
                $model->setTransportWageID($modelMark->getTransportWageID());
            }
            if($transportFormPaymentID < 1) {
                $model->setTransportFormPaymentID($modelMark->getTransportFormPaymentID());
            }

            Helpers_DB::saveDBObject($model, $sitePageData, $sitePageData->shopID);
        }else{
            if($transportViewID < 1) {
                $model->setTransportViewID(0);
            }
            if($transportWorkID < 1) {
                $model->setTransportWorkID(0);
            }
            if($transportWageID < 1) {
                $model->setTransportWageID(0);
            }
            if($transportFormPaymentID < 1) {
                $model->setTransportFormPaymentID(0);
            }
        }

        if($transportMarkID > 0) {
            $modelMark = new Model_Ab1_Shop_Transport_Mark();
            $modelMark->setDBDriver($driver);
            Helpers_DB::getDBObject($modelMark, $transportMarkID, $sitePageData, $sitePageData->shopMainID);

            if($model->getTransportViewID() < 1){
                $model->setTransportViewID($modelMark->getTransportViewID());
            }
            if($model->getTransportWorkID() < 1) {
                $model->setTransportWorkID($modelMark->getTransportWorkID());
            }
            if($model->getTransportWageID() < 1) {
                $model->setTransportWageID($modelMark->getTransportWageID());
            }
            if($model->getTransportFormPaymentID() < 1) {
                $model->setTransportFormPaymentID($modelMark->getTransportFormPaymentID());
            }

            Helpers_DB::saveDBObject($model, $sitePageData, $sitePageData->shopID);
        }

        // обновление машин
        Api_Ab1_Shop_Transport_Waybill::refreshCars(
            $model->id, $model->getShopTransportID(), $trailerShopTransportID, $model->getShopTransportDriverID(),
            $model->getFromAt(), $model->getToAt(), $sitePageData, $driver
        );

        // сохраняем рейсы созданные в ручную
        $cars = Request_RequestParams::getParamArray('hand_shop_transport_waybill_cars', array(), array());
        $params = Request_RequestParams::setParams(
            array(
                'shop_transport_waybill_id' => $model->id,
                'is_hand' => true,
                'sort_by' => [
                    'created_at' => 'asc'
                ]
            )
        );
        $carIDs = Request_Request::find(
            DB_Ab1_Shop_Transport_Waybill_Car::NAME,
            $sitePageData->shopID, $sitePageData, $driver,
            $params, 0, TRUE
        );

        $modelCar = new Model_Ab1_Shop_Transport_Waybill_Car();
        $modelCar->setDBDriver($driver);
        foreach($cars as $key => $car){
            $carIDs->childShiftSetModel($modelCar, $key);

            $modelCar->setDate($model->getDate());
            $modelCar->setShopTransportID($model->getShopTransportID());
            $modelCar->setShopTransportWaybillID($model->id);
            $modelCar->setShopTransportDriverID($model->getShopTransportDriverID());


            $modelCar->setShopBranchFromID(Arr::path($car, 'shop_branch_from_id', $modelCar->getShopBranchFromID()));
            $modelCar->setToName(Arr::path($car, 'to_name', $modelCar->getToName()));
            $modelCar->setCoefficient(Request_RequestParams::strToFloat(Arr::path($car, 'coefficient', $modelCar->getCoefficient())));
            $modelCar->setProductName(Arr::path($car, 'product_name', $modelCar->getProductName()));
            $modelCar->setShopTransportRouteID(Arr::path($car, 'shop_transport_route_id', $modelCar->getShopTransportRouteID()));
            $modelCar->setCountTrip(Arr::path($car, 'count_trip', $modelCar->getCountTrip()));
            $modelCar->setDistance(Request_RequestParams::strToFloat(Arr::path($car, 'distance', $modelCar->getDistance())));
            $modelCar->setQuantity(Request_RequestParams::strToFloat(Arr::path($car, 'quantity', $modelCar->getQuantity())));
            $modelCar->setWage(Request_RequestParams::strToFloat(Arr::path($car, 'wage', $modelCar->getWage())));
            $modelCar->setIsHand(true);

            Helpers_DB::saveDBObject($modelCar, $sitePageData);
        }

        // удаляем лишние
        $driver->deleteObjectIDs(
            $carIDs->getChildArrayID(), $sitePageData->userID,
            Model_Ab1_Shop_Transport_Waybill_Car::TABLE_NAME, array(), $sitePageData->shopID
        );
    }
}