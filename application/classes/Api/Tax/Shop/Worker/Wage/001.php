<?php defined('SYSPATH') or die('No direct script access.');

class Api_Tax_Shop_Worker_Wage_001  {

    /**
     * Пересчитываем зарплату сотрудника
     * @param Model_Tax_Shop_Worker_Wage $model
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @param bool $isCalcMonthWage - надо ли пересчитывать группу месяцев
     */
    public static function recountWorkerWageModel(Model_Tax_Shop_Worker_Wage $model, SitePageData $sitePageData,
                                             Model_Driver_DBBasicDriver $driver, $isCalcMonthWage = TRUE)
    {
        $year = $model->getYear();
        $month = $model->getMonth();

        $dateFrom = Helpers_DateTime::getMonthBeginStr($month, $year);
        $dateTo = Helpers_DateTime::getMonthEndStr($month, $year);

        $params = Request_RequestParams::setParams(
            array(
                'period_from' => $dateFrom,
                'period_to' => $dateTo,
                'shop_worker_id' => $model->getShopWorkerID(),
            )
        );
        $shopWorkTimeIDs = Request_Tax_Shop_Work_Time::findShopWorkTimeIDs($sitePageData->shopID, $sitePageData, $driver,
            $params, 0, TRUE);

        $workDay = Api_Tax_Shop_Work_Time::getWorkDay($dateFrom, $dateTo, $sitePageData, $driver);

        $workDayWorker = $workDay;
        $wageWorker = 0;
        foreach ($shopWorkTimeIDs->childs as $child){
            $arr = json_decode($child->values['options'], TRUE);
            $arr = Arr::path($arr, 'decipher.' . $year . '.' . (intval($month)), 0);

            $workDayWorker -= intval(Arr::path($arr, 'work_days', 0));
            $wageWorker += floatval(Arr::path($arr, 'wage', 0));
        }

        // пересчитываем рабочие дни
        $model->setWorkDays($workDayWorker);
        $model->setDays(Helpers_DateTime::diffDays($dateTo, $dateFrom) + 1);

        if (($workDayWorker > 0) || ($workDay > 0)) {
            $model->setWage(round($model->getWageBasic() / $workDay * $workDayWorker + $wageWorker, 0));
        }else{
            $model->setWage($wageWorker);
        }

        // пересчитываем налоги
        Api_Tax_Shop_Worker_Wage::calcTax($model, $sitePageData);

        Helpers_DB::saveDBObject($model, $sitePageData);

        // пересчитываем группу для месяца
        if($isCalcMonthWage) {
            $monthID = Api_Tax_Shop_Worker_Wage_Month::checkCalcWagesMonth($model->getMonth(), $model->getYear(),
                $sitePageData, $driver);
            $model->setShopWorkerWageMonthID($monthID);
        }
    }

    /**
     * Пересчитываем зарплату сотрудника в заданный месяц и год
     * @param $month
     * @param $year
     * @param $shopWorkerID
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @return mixed
     */
    public static function recountWorkerWage($month, $year, $shopWorkerID, SitePageData $sitePageData,
                                             Model_Driver_DBBasicDriver $driver)
    {
        $params = Request_RequestParams::setParams(
            array(
                'shop_worker_id' => $shopWorkerID,
                'year' => $year,
                'month' => $month,
            )
        );
        $shopWorkerWageIDs = Request_Tax_Shop_Worker_Wage::findShopWorkerWageIDs($sitePageData->shopID, $sitePageData, $driver,
            $params, 1, TRUE);
        if(count($shopWorkerWageIDs->childs) == 0){
            return TRUE;
        }

        $model = new Model_Tax_Shop_Worker_Wage();
        $model->setDBDriver($driver);
        $model->__setArray(array('values' => $shopWorkerWageIDs->childs[0]->values));

        self::recountWorkerWageModel($model, $sitePageData, $driver);
    }

    /**
     * Сумма оплаты по больничному за определенный месяц заданное количества рабочих дней
     * @param $currentShopWorkTimeID
     * @param $month
     * @param $year
     * @param $workDay
     * @param $shopWorkerID
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @return float|int|mixed
     */
    public static function calcMonthHospitalWage($currentShopWorkTimeID, $month, $year, $workDay, $shopWorkerID,
        SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        $dateFrom = Helpers_DateTime::getMonthBeginStr($month, $year);
        $dateTo = Helpers_DateTime::getMonthEndStr($month, $year);

        /** среднюю оплату рабочего дня **/
        $averagedWorkDay = Api_Tax_Shop_Worker_Wage::getAveragedWorkDayWageWorker(
            Helpers_DateTime::deductDateYears($dateFrom, 1),
            $dateFrom,
            $shopWorkerID,
            $sitePageData,
            $driver
        );

        /** Получаем предыдущие больничные дни **/
        $params = Request_RequestParams::setParams(
            array(
                'shop_worker_id' => $shopWorkerID,
                'period_from' => $dateFrom,
                'period_to' => $dateTo,
                'work_time_type_id' => Model_Tax_WorkTimeType::WORK_TIME_TYPE_HOSPITAL,
            )
        );
        $shopWorkTimeIDs = Request_Tax_Shop_Work_Time::findShopWorkTimeIDs($sitePageData->shopID, $sitePageData, $driver,
            $params , 0, TRUE);

        $holidayWage = 0;
        foreach ($shopWorkTimeIDs->childs as $child){
            if ($child->id != $currentShopWorkTimeID) {
                $holidayWage += floatval(Arr::path(
                    json_decode($child->values['options'], TRUE),
                    'decipher.' . $year . '.' . (intval($month)) . '.wage', 0
                    ));
            }
        }

        $result = $averagedWorkDay * $workDay;
        $maxWageForHospatal = Api_Tax_Const::getMaxWageForHospatal($year);
        if ($maxWageForHospatal < $result + $holidayWage){
            $result = $maxWageForHospatal - $holidayWage;
        }

        if ($result < 0) {
            $result = 0;
        }

        return $result;
    }

    /**
     * Сумма оплаты по больничному
     * @param $currentShopWorkTimeID
     * @param $dateFrom
     * @param $dateTo
     * @param $shopWorkerID
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @param bool $isDecipher - если установить TRUE, то будет результат с расшифровкой по каждому месяцу
     * @return array|float|int
     */
    public static function calcHospitalWage($currentShopWorkTimeID, $dateFrom, $dateTo, $shopWorkerID, SitePageData $sitePageData,
                                            Model_Driver_DBBasicDriver $driver, $isDecipher = FALSE)
    {
        // массив месяцев в указанном периоде
        $months = Helpers_DateTime::getMonthsPeriod($dateFrom, $dateTo);

        $result = 0;
        $decipher = array();
        foreach ($months as $month){
            // количество рабочих дней в указанный месяц
            $workDay = Api_Tax_Shop_Work_Time::getWorkDayMonth($dateFrom, $dateTo, $month['month'], $month['year'],
                $sitePageData, $driver);

            // стоимость больничного периода
            $tmp = self::calcMonthHospitalWage($currentShopWorkTimeID, $month['month'], $month['year'], $workDay,
                $shopWorkerID, $sitePageData, $driver);

            $decipher[$month['year']][intval($month['month'])] = array(
                'wage' => $tmp,
                'work_days' => Api_Tax_Shop_Work_Time::getWorkDayMonth($dateFrom, $dateTo, $month['month'],
                    $month['year'], $sitePageData, $driver),
            );
            $result += $tmp;
        }

        if ($isDecipher){
            return array(
                'decipher' => $decipher,
                'total' => $result,
            );
        }else {
            return $result;
        }
    }

    /**
     * Сумма оплаты за отпуск
     * @param $currentShopWorkTimeID
     * @param $dateFrom
     * @param $dateTo
     * @param $shopWorkerID
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @return int
     */
    public static function calcHolidayWage($currentShopWorkTimeID, $dateFrom, $dateTo, $shopWorkerID, SitePageData $sitePageData,
                                           Model_Driver_DBBasicDriver $driver)
    {
        return 0;
    }

    /**
     * Считаем стоимость записи табеля рабочего времени
     * @param Model_Tax_Shop_Work_Time $model
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     */
    public static function calcWorkTimeWage(Model_Tax_Shop_Work_Time $model, SitePageData $sitePageData,
                                            Model_Driver_DBBasicDriver $driver)
    {
        // кол-во дней
        $model->setDays(Helpers_DateTime::diffDays($model->getDateTo(), $model->getDateFrom()) + 1);
        // кол-во рабочих дней
        $model->setWorkDays(Api_Tax_Shop_Work_Time::getWorkDay($model->getDateFrom(), $model->getDateTo(), $sitePageData, $driver));

        // считаем, сколько нужно оплатить за данный период отстутствия сотрудника
        switch ($model->getWorkTimeTypeID()){
            case Model_Tax_WorkTimeType::WORK_TIME_TYPE_HOSPITAL:
                $result = self::calcHospitalWage($model->id, $model->getDateFrom(), $model->getDateTo(),
                    $model->getShopWorkerID(), $sitePageData, $driver, TRUE);

                // сохраняем расшифровку по месяцам, чтобы для просчета зарплаты не пересчитывать
                $model->addOptionsArray($result);

                $wage = $result['total'];
                break;
            case Model_Tax_WorkTimeType::WORK_TIME_TYPE_HOLIDAY:
                $wage = self::calcHolidayWage($model->id, $model->getDateFrom(), $model->getDateTo(), $model->getShopWorkerID(),
                    $sitePageData, $driver);
                break;
            default:
                $wage = 0;
        }
        $model->setWage($wage);

        // сохраняем нашу запись
        Helpers_DB::saveDBObject($model, $sitePageData);

        // проходимся по месяцам периода и пересчитываем зарплату сотрудника
        $months = Helpers_DateTime::getMonthsPeriod($model->getDateFrom(), $model->getDateTo());
        foreach ($months as $month){
            // пересчитываем зарплату сотрудника за указанный месяц
            Api_Tax_Shop_Worker_Wage::recountWorkerWage($month['month'], $month['year'],
                $model->getShopWorkerID(), $sitePageData, $driver);
        }
    }

    /**
     * Сохранение зарплат за 6 месяцев
     * @param $halfYear
     * @param $year
     * @param array $shopWorkerWages
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @param bool $isOwner
     * @param bool $isEditWage - сохраняем ли новые зарплаты в базе данных
     * @return array
     */
    public static function saveSixWage($halfYear, $year, array $shopWorkerWages, SitePageData $sitePageData,
                                       Model_Driver_DBBasicDriver $driver, $isOwner = FALSE, $isEditWage = TRUE)
    {
        $model = new Model_Tax_Shop_Worker_Wage();
        $model->setDBDriver($driver);

        $modelWorker = new Model_Tax_Shop_Worker();
        $modelWorker->setDBDriver($driver);

        if($halfYear == 2){
            $shift = 6;
        }else{
            $shift = 0;
        }

        // получаем зарплаты за данный промежуток времени
        if ($isEditWage) {
            if ($halfYear == 1) {
                $dateFrom = $year . '-01-01';
                $dateTo = $year . '-06-01';
            } else {
                $dateFrom = $year . '-07-01';
                $dateTo = $year . '-12-01';
            }
            $shopWorkerWageIDs = Request_Tax_Shop_Worker_Wage::findShopWorkerWageIDs($sitePageData->shopID, $sitePageData, $driver,
                array('date_from' => $dateFrom, 'date_to' => $dateTo, 'is_owner' => $isOwner, Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE), 0, TRUE);
        }

        $result = array(
            'half_year' => array(
                'all' => array(
                    'opv' => 0,
                    'so' => 0,
                    'ipn' => 0,
                    'osms' => 0,
                    'sn' => 0,
                    'count' => 0,
                    'wage' => 0,
                    'wage_opv' => 0,
                    'wage_so' => 0,
                    'wage_osms' => 0,
                    'wage_oppv' => 0,
                ),
                Model_Tax_WorkerStatus::WORKER_STATUS_NATIONAL => array(
                    'opv' => 0,
                    'so' => 0,
                    'ipn' => 0,
                    'osms' => 0,
                    'sn' => 0,
                    'count' => 0,
                    'wage' => 0,
                    'wage_opv' => 0,
                    'wage_so' => 0,
                    'wage_osms' => 0,
                    'wage_oppv' => 0,
                ),
                Model_Tax_WorkerStatus::WORKER_STATUS_PENSIONER => array(
                    'opv' => 0,
                    'so' => 0,
                    'ipn' => 0,
                    'osms' => 0,
                    'sn' => 0,
                    'count' => 0,
                    'wage' => 0,
                    'wage_opv' => 0,
                    'wage_so' => 0,
                    'wage_osms' => 0,
                    'wage_oppv' => 0,
                ),
                Model_Tax_WorkerStatus::WORKER_STATUS_HANDICAPPED => array(
                    'opv' => 0,
                    'so' => 0,
                    'ipn' => 0,
                    'osms' => 0,
                    'sn' => 0,
                    'count' => 0,
                    'wage' => 0,
                    'wage_opv' => 0,
                    'wage_so' => 0,
                    'wage_osms' => 0,
                    'wage_oppv' => 0,
                ),
                Model_Tax_WorkerStatus::WORKER_STATUS_ALIEN => array(
                    'opv' => 0,
                    'so' => 0,
                    'ipn' => 0,
                    'osms' => 0,
                    'sn' => 0,
                    'count' => 0,
                    'wage' => 0,
                    'wage_opv' => 0,
                    'wage_so' => 0,
                    'wage_osms' => 0,
                    'wage_oppv' => 0,
                ),
                Model_Tax_WorkerStatus::WORKER_STATUS_ALIEN_NATIONAL => array(
                    'opv' => 0,
                    'so' => 0,
                    'ipn' => 0,
                    'osms' => 0,
                    'sn' => 0,
                    'count' => 0,
                    'wage' => 0,
                    'wage_opv' => 0,
                    'wage_so' => 0,
                    'wage_osms' => 0,
                    'wage_oppv' => 0,
                ),
            ),
        );
        for ($i = 1; $i < 7; $i++) {
            $result[$i] = array(
                'all' => array(
                    'opv' => 0,
                    'so' => 0,
                    'ipn' => 0,
                    'osms' => 0,
                    'sn' => 0,
                    'count' => 0,
                    'wage' => 0,
                    'wage_opv' => 0,
                    'wage_so' => 0,
                    'wage_osms' => 0,
                    'wage_oppv' => 0,
                ),
                Model_Tax_WorkerStatus::WORKER_STATUS_NATIONAL => array(
                    'opv' => 0,
                    'so' => 0,
                    'ipn' => 0,
                    'osms' => 0,
                    'sn' => 0,
                    'count' => 0,
                    'wage' => 0,
                    'wage_opv' => 0,
                    'wage_so' => 0,
                    'wage_osms' => 0,
                    'wage_oppv' => 0,
                ),
                Model_Tax_WorkerStatus::WORKER_STATUS_PENSIONER => array(
                    'opv' => 0,
                    'so' => 0,
                    'ipn' => 0,
                    'osms' => 0,
                    'sn' => 0,
                    'count' => 0,
                    'wage' => 0,
                    'wage_opv' => 0,
                    'wage_so' => 0,
                    'wage_osms' => 0,
                    'wage_oppv' => 0,
                ),
                Model_Tax_WorkerStatus::WORKER_STATUS_HANDICAPPED => array(
                    'opv' => 0,
                    'so' => 0,
                    'ipn' => 0,
                    'osms' => 0,
                    'sn' => 0,
                    'count' => 0,
                    'wage' => 0,
                    'wage_opv' => 0,
                    'wage_so' => 0,
                    'wage_osms' => 0,
                    'wage_oppv' => 0,
                ),
                Model_Tax_WorkerStatus::WORKER_STATUS_ALIEN => array(
                    'opv' => 0,
                    'so' => 0,
                    'ipn' => 0,
                    'osms' => 0,
                    'sn' => 0,
                    'count' => 0,
                    'wage' => 0,
                    'wage_opv' => 0,
                    'wage_so' => 0,
                    'wage_osms' => 0,
                    'wage_oppv' => 0,
                ),
                Model_Tax_WorkerStatus::WORKER_STATUS_ALIEN_NATIONAL => array(
                    'opv' => 0,
                    'so' => 0,
                    'ipn' => 0,
                    'osms' => 0,
                    'sn' => 0,
                    'count' => 0,
                    'wage' => 0,
                    'wage_opv' => 0,
                    'wage_so' => 0,
                    'wage_osms' => 0,
                    'wage_oppv' => 0,
                ),
            );
        }

        foreach($shopWorkerWages as $shopWorkerWage){
            $name = trim(Arr::path($shopWorkerWage, 'shop_worker_name', ''));
            if(empty($name)){
                continue;
            }

            $shopWorkerID = Request_Request::findOneByName('DB_Tax_Shop_Worker', $name, $sitePageData->shopID, $sitePageData, $driver);
            if ($shopWorkerID !== NULL){
                $shopWorkerID = $shopWorkerID->id;
            }else{
                $modelWorker->clear();
                $modelWorker->setName($name);
                $shopWorkerID = Helpers_DB::saveDBObject($modelWorker, $sitePageData);
            }

            $workerStatusID = str_replace(',', '.', intval(Arr::path($shopWorkerWage, 'worker_status_id', 0)));
            if(($workerStatusID < Model_Tax_WorkerStatus::WORKER_STATUS_NATIONAL) || ($workerStatusID > Model_Tax_WorkerStatus::WORKER_STATUS_ALIEN_NATIONAL)){
                $workerStatusID = Model_Tax_WorkerStatus::WORKER_STATUS_NATIONAL;
            }

            for ($i = 1; $i < 7; $i++) {
                $wage = str_replace(' ', '', intval(Arr::path($shopWorkerWage, $i, '')));
                if($wage <= 0){
                    continue;
                }

                $model->clear();
                // находим запись о существующей зарплате
                if($isEditWage) {
                    foreach ($shopWorkerWageIDs->childs as $index => $child) {
                        if (($child->values['shop_worker_id'] == $shopWorkerID)
                            && ($child->values['worker_status_id'] == $workerStatusID)
                            && ($child->values['date'] == $year . '-' . Func::getMonthHalf($i, $halfYear) . '-01-')) {

                            $model->__setArray(array('values' => $child->values));
                            unset($shopWorkerWageIDs->childs[$index]);
                            break;
                        }
                    }
                }

                $model->setShopWorkerID($shopWorkerID);
                $model->setWorkerStatusID($workerStatusID);
                $model->setWage($wage);
                $model->setYear($year);
                $model->setMonth($i + $shift);
                $model->setIsOwner($isOwner);

                // прощет налогов для зарплаты для Казахстана
                $organizationTypeID = Arr::path($sitePageData->shop->getRequisitesArray(), 'organization_type_id', 0);
                $organizationTaxTypeID = Arr::path($sitePageData->shop->getRequisitesArray(), 'organization_tax_type_id', 0);
                $model->setOPV(self::calcOPV($year, $model->getWage(), $organizationTypeID, $organizationTaxTypeID, $model->getWorkerStatusID(), $model->getIsOwner()));
                $model->setSO(self::calcSO($year, $model->getWage(), $organizationTypeID, $organizationTaxTypeID, $model->getWorkerStatusID(), $model->getIsOwner()));
                $model->setIPN(self::calcIPN($year, $model->getWage(), $organizationTypeID, $organizationTaxTypeID, $model->getWorkerStatusID(), $model->getIsOwner()));
                $model->setOSMS(self::calcOSMS($year, $model->getWage(), $organizationTypeID, $organizationTaxTypeID, $model->getWorkerStatusID(), $model->getIsOwner()));
                $model->setSN(self::calcSN($year, $model->getWage(), $organizationTypeID, $organizationTaxTypeID, $model->getWorkerStatusID(), $model->getIsOwner()));

                // зарплаты для отчисления
                $wageOPV = self::getWageOPV($year, $model->getWage());
                if ($model->getOPV() == 0){
                    $wageOPV = 0;
                }
                $wageSO = self::getWageSO($year, $model->getWage(), $organizationTypeID, $organizationTaxTypeID, $model->getWorkerStatusID(), $model->getIsOwner());
                if ($model->getSO() == 0){
                    $wageSO = 0;
                }
                $wageOSMS = self::getWageOSMS($model->getYear(), $model->getWage());
                if ($model->getOSMS() == 0){
                    $wageOSMS = 0;
                }

                // считаем данные по налогам и количеству человек
                $result[$i][$workerStatusID]['opv'] += $model->getOPV();
                $result[$i][$workerStatusID]['so'] += $model->getSO();
                $result[$i][$workerStatusID]['ipn'] += $model->getIPN();
                $result[$i][$workerStatusID]['osms'] += $model->getOSMS();
                $result[$i][$workerStatusID]['sn'] += $model->getSN();
                $result[$i][$workerStatusID]['count']++;
                $result[$i][$workerStatusID]['wage'] += $wage;
                $result[$i][$workerStatusID]['wage_opv'] += $wageOPV;
                $result[$i][$workerStatusID]['wage_so'] += $wageSO;
                $result[$i][$workerStatusID]['wage_osms'] += $wageOSMS;

                $result[$i]['all']['opv'] += $model->getOPV();
                $result[$i]['all']['so'] += $model->getSO();
                $result[$i]['all']['ipn'] += $model->getIPN();
                $result[$i]['all']['osms'] += $model->getOSMS();
                $result[$i]['all']['sn'] += $model->getSN();
                $result[$i]['all']['count']++;
                $result[$i]['all']['wage'] += $wage;
                $result[$i]['all']['wage_opv'] += $wageOPV;
                $result[$i]['all']['wage_so'] += $wageSO;
                $result[$i]['all']['wage_osms'] += $wageOSMS;

                $result['half_year'][$workerStatusID]['opv'] += $model->getOPV();
                $result['half_year'][$workerStatusID]['so'] += $model->getSO();
                $result['half_year'][$workerStatusID]['ipn'] += $model->getIPN();
                $result['half_year'][$workerStatusID]['osms'] += $model->getOSMS();
                $result['half_year'][$workerStatusID]['sn'] += $model->getSN();
                $result['half_year'][$workerStatusID]['count']++;
                $result['half_year'][$workerStatusID]['wage'] += $wage;
                $result['half_year'][$workerStatusID]['wage_opv'] += $wageOPV;
                $result['half_year'][$workerStatusID]['wage_so'] += $wageSO;
                $result['half_year'][$workerStatusID]['wage_osms'] += $wageOSMS;

                $result['half_year']['all']['opv'] += $model->getOPV();
                $result['half_year']['all']['so'] += $model->getSO();
                $result['half_year']['all']['ipn'] += $model->getIPN();
                $result['half_year']['all']['osms'] += $model->getOSMS();
                $result['half_year']['all']['sn'] += $model->getSN();
                $result['half_year']['all']['count']++;
                $result['half_year']['all']['wage'] += $wage;
                $result['half_year']['all']['wage_opv'] += $wageOPV;
                $result['half_year']['all']['wage_so'] += $wageSO;
                $result['half_year']['all']['wage_osms'] += $wageOSMS;

                if($isEditWage && ($model->getWage() > 0)){
                    Helpers_DB::saveDBObject($model, $sitePageData);
                }
            }
        }

        // удаляем лишние
        if ($isEditWage) {
            $driver->deleteObjectIDs($shopWorkerWageIDs->getChildArrayID(), $sitePageData->userID,
                Model_Tax_Shop_Worker_Wage::TABLE_NAME, array(), $sitePageData->shopID);

            // делаем пересчет зарплат за полугодие по месяцам
            Api_Tax_Shop_Worker_Wage_Month::checkCalcWagesHalfYear($halfYear, $year, $sitePageData, $driver);
        }

        return $result;
    }

    /**
     * просчет процента от суммы с округлением
     * @param $amount
     * @param $percent
     * @return float
     */
    public static function calcPercent($amount, $percent){
        return ceil($amount / 100 * $percent);
    }

    /**
     * Зарплата для Пенсионных отчислений
     * @param $year
     * @param $wage
     * @return float
     */
    public static function getWageOPV($year, $wage){
        $maxWageForOPV = Api_Tax_Const::getMaxWageForOPV($year);
        if($wage >= $maxWageForOPV) {
            $wage = $maxWageForOPV;
        }else{
            $minWage = Api_Tax_Const::getMinWage($year);
            if($wage <= $minWage) {
                $wage = $minWage;
            }
        }

        return $wage;
    }

    /**
     * Просчет ОПВ
     * @param $year
     * @param $wage
     * @param $organizationTypeID
     * @param $organizationTaxTypeID
     * @param $workerStatusID
     * @param bool $isOwner
     * @return float|int
     */
    public static function calcOPV($year, $wage, $organizationTypeID, $organizationTaxTypeID, $workerStatusID, $isOwner = FALSE){
        $wage = self::getWageOPV($year, $wage);

        // прощет налогов для зарплаы для Казахстана
        $result = 0;
        switch ($organizationTypeID) {
            // ИП
            case Model_OrganizationType::ORGANIZATION_TYPE_IP:

                // выбор режима налогооблажения
                switch ($organizationTaxTypeID) {
                    // Упрощенный режим налогообложения
                    case Model_Tax_OrganizationTaxType::TAX_TYPE_SIMPLIFIED:
                        if($isOwner){
                            //упрощенка для владельца
                            switch ($workerStatusID) {
                                case Model_Tax_WorkerStatus::WORKER_STATUS_PENSIONER:
                                    $result = 0;
                                    break;
                                case Model_Tax_WorkerStatus::WORKER_STATUS_HANDICAPPED:
                                    $result = self::calcPercent($wage,10);
                                    break;
                                case Model_Tax_WorkerStatus::WORKER_STATUS_ALIEN:
                                    $result = 0;
                                    break;
                                case Model_Tax_WorkerStatus::WORKER_STATUS_ALIEN_NATIONAL:
                                    $result = self::calcPercent($wage,10);
                                    break;
                                default:
                                    $result = self::calcPercent($wage,10);
                            }
                        }else{
                            // упрощенка для сотрудников
                            switch ($workerStatusID) {
                                case Model_Tax_WorkerStatus::WORKER_STATUS_PENSIONER:
                                    $result = 0;
                                    break;
                                case Model_Tax_WorkerStatus::WORKER_STATUS_HANDICAPPED:
                                    $result = self::calcPercent($wage,10);
                                    break;
                                case Model_Tax_WorkerStatus::WORKER_STATUS_ALIEN:
                                    $result = 0;
                                    break;
                                case Model_Tax_WorkerStatus::WORKER_STATUS_ALIEN_NATIONAL:
                                    $result = self::calcPercent($wage,10);
                                    break;
                                default:
                                    $result = self::calcPercent($wage,10);
                            }
                        }
                        break;
                    // Общеустановленный режим налогообложения
                    case Model_Tax_OrganizationTaxType::TAX_TYPE_GENERALLY:
                        if($isOwner){
                            // для владельца общейустановленной
                            switch ($workerStatusID) {
                                case Model_Tax_WorkerStatus::WORKER_STATUS_PENSIONER:
                                    $result = 0;
                                    break;
                                case Model_Tax_WorkerStatus::WORKER_STATUS_HANDICAPPED:
                                    $result = self::calcPercent($wage,10);
                                    break;
                                case Model_Tax_WorkerStatus::WORKER_STATUS_ALIEN:
                                    $result = 0;
                                    break;
                                case Model_Tax_WorkerStatus::WORKER_STATUS_ALIEN_NATIONAL:
                                    $result = self::calcPercent($wage,10);
                                    break;
                                default:
                                    $result = self::calcPercent($wage,10);
                            }
                        }else{
                            // для сотрудников общейустановленной
                            switch ($workerStatusID) {
                                case Model_Tax_WorkerStatus::WORKER_STATUS_PENSIONER:
                                    $result = 0;
                                    break;
                                case Model_Tax_WorkerStatus::WORKER_STATUS_HANDICAPPED:
                                    $result = self::calcPercent($wage,10);
                                    break;
                                case Model_Tax_WorkerStatus::WORKER_STATUS_ALIEN:
                                    $result = 0;
                                    break;
                                case Model_Tax_WorkerStatus::WORKER_STATUS_ALIEN_NATIONAL:
                                    $result = self::calcPercent($wage,10);
                                    break;
                                default:
                                    $result = self::calcPercent($wage,10);
                            }
                        }
                        break;
                }
                break;
            // ТОО
            case Model_OrganizationType::ORGANIZATION_TYPE_TOO:
                // выбор режима налогооблажения
                switch ($organizationTaxTypeID) {
                    // Упрощенный режим налогообложения
                    case Model_Tax_OrganizationTaxType::TAX_TYPE_SIMPLIFIED:
                        // упращенка
                        switch ($workerStatusID) {
                            case Model_Tax_WorkerStatus::WORKER_STATUS_PENSIONER:
                                $result = 0;
                                break;
                            case Model_Tax_WorkerStatus::WORKER_STATUS_HANDICAPPED:
                                $result = self::calcPercent($wage,10);
                                break;
                            case Model_Tax_WorkerStatus::WORKER_STATUS_ALIEN:
                                $result = 0;
                                break;
                            case Model_Tax_WorkerStatus::WORKER_STATUS_ALIEN_NATIONAL:
                                $result = self::calcPercent($wage,10);
                                break;
                            default:
                                $result = self::calcPercent($wage,10);
                        }
                        break;
                    // Общеустановленный режим налогообложения
                    case Model_Tax_OrganizationTaxType::TAX_TYPE_GENERALLY:
                        // общеустановленное
                        switch ($workerStatusID) {
                            case Model_Tax_WorkerStatus::WORKER_STATUS_PENSIONER:
                                $result = 0;
                                break;
                            case Model_Tax_WorkerStatus::WORKER_STATUS_HANDICAPPED:
                                $result = self::calcPercent($wage,10);
                                break;
                            case Model_Tax_WorkerStatus::WORKER_STATUS_ALIEN:
                                $result = 0;
                                break;
                            case Model_Tax_WorkerStatus::WORKER_STATUS_ALIEN_NATIONAL:
                                $result = self::calcPercent($wage,10);
                                break;
                            default:
                                $result = self::calcPercent($wage,10);
                        }
                        break;
                }
                break;
        }

        if($result < 0){
            $result = 0;
        }
        return $result;
    }

    /**
     * Зарплата от коротой идут Социальные отчисления
     * @param $year
     * @param $wage
     * @param $organizationTypeID
     * @param $organizationTaxTypeID
     * @param $workerStatusID
     * @param bool $isOwner
     * @return float|int
     */
    public static function getWageSO($year, $wage, $organizationTypeID, $organizationTaxTypeID, $workerStatusID, $isOwner = FALSE){
        $maxWageForSO = Api_Tax_Const::getMaxWageForSO($year);
        if ($wage >= $maxWageForSO) {
            $wage = $maxWageForSO;
        } else{
            $minWage = Api_Tax_Const::getMinWage($year);
            if ($wage <= $minWage) {
                $wage = $minWage;
            } else {
                $wage = $wage - self::calcOPV($year, $wage, $organizationTypeID, $organizationTaxTypeID, $workerStatusID, $isOwner);
                if ($wage < $minWage){
                    $wage = $minWage;
                }
            }
        }
        if($workerStatusID == Model_Tax_WorkerStatus::WORKER_STATUS_PENSIONER){
            $wage = 0;
        }

        return $wage;
    }

    /**
     * Просчет СО
     * @param $year
     * @param $wage
     * @param $organizationTypeID
     * @param $organizationTaxTypeID
     * @param $workerStatusID
     * @param bool $isOwner
     * @return float|int
     */
    public static function calcSO($year, $wage, $organizationTypeID, $organizationTaxTypeID, $workerStatusID, $isOwner = FALSE){
        $wage = self::getWageSO($year, $wage, $organizationTypeID, $organizationTaxTypeID, $workerStatusID, $isOwner);

        // прощет налогов для зарплаы для Казахстана
        $result = 0;
        switch ($organizationTypeID) {
            // ИП
            case Model_OrganizationType::ORGANIZATION_TYPE_IP:

                // выбор режима налогооблажения
                switch ($organizationTaxTypeID) {
                    // Упрощенный режим налогообложения
                    case Model_Tax_OrganizationTaxType::TAX_TYPE_SIMPLIFIED:
                        if($isOwner){
                            //упрощенка для владельца
                            switch ($workerStatusID) {
                                case Model_Tax_WorkerStatus::WORKER_STATUS_PENSIONER:
                                    $result = 0;
                                    break;
                                case Model_Tax_WorkerStatus::WORKER_STATUS_HANDICAPPED:
                                    $result = self::calcPercent($wage, 3.5);
                                    break;
                                case Model_Tax_WorkerStatus::WORKER_STATUS_ALIEN:
                                    $result = self::calcPercent($wage, 3.5);
                                    break;
                                case Model_Tax_WorkerStatus::WORKER_STATUS_ALIEN_NATIONAL:
                                    $result = self::calcPercent($wage, 3.5);
                                    break;
                                default:
                                    $result = self::calcPercent($wage, 3.5);
                            }
                        }else{
                            // упрощенка для сотрудников
                            switch ($workerStatusID) {
                                case Model_Tax_WorkerStatus::WORKER_STATUS_PENSIONER:
                                    $result = 0;
                                    break;
                                case Model_Tax_WorkerStatus::WORKER_STATUS_HANDICAPPED:
                                    $result = self::calcPercent($wage, 3.5);
                                    break;
                                case Model_Tax_WorkerStatus::WORKER_STATUS_ALIEN:
                                    $result = self::calcPercent($wage, 3.5);
                                    break;
                                case Model_Tax_WorkerStatus::WORKER_STATUS_ALIEN_NATIONAL:
                                    $result = self::calcPercent($wage, 3.5);
                                    break;
                                default:
                                    $result = self::calcPercent($wage, 3.5);
                            }
                        }
                        break;
                    // Общеустановленный режим налогообложения
                    case Model_Tax_OrganizationTaxType::TAX_TYPE_GENERALLY:
                        if($isOwner){
                            // для владельца общейустановленной
                            switch ($workerStatusID) {
                                case Model_Tax_WorkerStatus::WORKER_STATUS_PENSIONER:
                                    $result = 0;
                                    break;
                                case Model_Tax_WorkerStatus::WORKER_STATUS_HANDICAPPED:
                                    $result = self::calcPercent($wage, 3.5);
                                    break;
                                case Model_Tax_WorkerStatus::WORKER_STATUS_ALIEN:
                                    $result = self::calcPercent($wage, 3.5);
                                    break;
                                case Model_Tax_WorkerStatus::WORKER_STATUS_ALIEN_NATIONAL:
                                    $result = self::calcPercent($wage, 3.5);
                                    break;
                                default:
                                    $result = self::calcPercent($wage, 3.5);
                            }
                        }else{
                            // для сотрудников общейустановленной
                            switch ($workerStatusID) {
                                case Model_Tax_WorkerStatus::WORKER_STATUS_PENSIONER:
                                    $result = 0;
                                    break;
                                case Model_Tax_WorkerStatus::WORKER_STATUS_HANDICAPPED:
                                    $result = self::calcPercent($wage, 3.5);
                                    break;
                                case Model_Tax_WorkerStatus::WORKER_STATUS_ALIEN:
                                    $result = self::calcPercent($wage, 3.5);
                                    break;
                                case Model_Tax_WorkerStatus::WORKER_STATUS_ALIEN_NATIONAL:
                                    $result = self::calcPercent($wage, 3.5);
                                    break;
                                default:
                                    $result = self::calcPercent($wage, 3.5);
                            }
                        }
                        break;
                }
                break;
            // ТОО
            case Model_OrganizationType::ORGANIZATION_TYPE_TOO:
                // выбор режима налогооблажения
                switch ($organizationTaxTypeID) {
                    // Упрощенный режим налогообложения
                    case Model_Tax_OrganizationTaxType::TAX_TYPE_SIMPLIFIED:
                        // упращенка
                        switch ($workerStatusID) {
                            case Model_Tax_WorkerStatus::WORKER_STATUS_PENSIONER:
                                $result = 0;
                                break;
                            case Model_Tax_WorkerStatus::WORKER_STATUS_HANDICAPPED:
                                $result = self::calcPercent($wage, 3.5);
                                break;
                            case Model_Tax_WorkerStatus::WORKER_STATUS_ALIEN:
                                $result = self::calcPercent($wage, 3.5);
                                break;
                            case Model_Tax_WorkerStatus::WORKER_STATUS_ALIEN_NATIONAL:
                                $result = self::calcPercent($wage, 3.5);
                                break;
                            default:
                                $result = self::calcPercent($wage, 3.5);
                        }
                        break;
                    // Общеустановленный режим налогообложения
                    case Model_Tax_OrganizationTaxType::TAX_TYPE_GENERALLY:
                        // общеустановленное
                        switch ($workerStatusID) {
                            case Model_Tax_WorkerStatus::WORKER_STATUS_PENSIONER:
                                $result = 0;
                                break;
                            case Model_Tax_WorkerStatus::WORKER_STATUS_HANDICAPPED:
                                $result = self::calcPercent($wage, 3.5);
                                break;
                            case Model_Tax_WorkerStatus::WORKER_STATUS_ALIEN:
                                $result = self::calcPercent($wage, 3.5);
                                break;
                            case Model_Tax_WorkerStatus::WORKER_STATUS_ALIEN_NATIONAL:
                                $result = self::calcPercent($wage, 3.5);
                                break;
                            default:
                                $result = self::calcPercent($wage, 3.5);
                        }
                        break;
                }
                break;
        }

        if($result < 0){
            $result = 0;
        }
        return $result;
    }

    /**
     * Просчет ИПН
     * @param $year
     * @param $wage
     * @param $organizationTypeID
     * @param $organizationTaxTypeID
     * @param $workerStatusID
     * @param bool $isOwner
     * @return float|int
     */
    public static function calcIPN($year, $wage, $organizationTypeID, $organizationTaxTypeID, $workerStatusID, $isOwner = FALSE){
        $basicWage = $wage;
        $opv = self::calcOPV($year, $wage, $organizationTypeID, $organizationTaxTypeID, $workerStatusID, $isOwner);
        $wage = $wage - $opv - Api_Tax_Const::getMinWage($year);

        // прощет налогов для зарплаы для Казахстана
        $result = 0;
        switch ($organizationTypeID) {
            // ИП
            case Model_OrganizationType::ORGANIZATION_TYPE_IP:

                // выбор режима налогооблажения
                switch ($organizationTaxTypeID) {
                    // Упрощенный режим налогообложения
                    case Model_Tax_OrganizationTaxType::TAX_TYPE_SIMPLIFIED:
                        if($isOwner){
                            //упрощенка для владельца
                            switch ($workerStatusID) {
                                case Model_Tax_WorkerStatus::WORKER_STATUS_PENSIONER:
                                    $result = 0;
                                    break;
                                case Model_Tax_WorkerStatus::WORKER_STATUS_HANDICAPPED:
                                    $result = 0;
                                    break;
                                case Model_Tax_WorkerStatus::WORKER_STATUS_ALIEN:
                                    $result = 0;
                                    break;
                                case Model_Tax_WorkerStatus::WORKER_STATUS_ALIEN_NATIONAL:
                                    $result = 0;
                                    break;
                                default:
                                    $result = 0;
                            }
                        }else{
                            // упрощенка для сотрудников
                            switch ($workerStatusID) {
                                case Model_Tax_WorkerStatus::WORKER_STATUS_PENSIONER:
                                    $result = self::calcPercent($wage, 10);
                                    break;
                                case Model_Tax_WorkerStatus::WORKER_STATUS_HANDICAPPED:
                                    $result = 0;
                                    break;
                                case Model_Tax_WorkerStatus::WORKER_STATUS_ALIEN:
                                    $result = self::calcPercent($basicWage, 10);
                                    break;
                                case Model_Tax_WorkerStatus::WORKER_STATUS_ALIEN_NATIONAL:
                                    $result = self::calcPercent($wage, 10);
                                    break;
                                default:
                                    $result = self::calcPercent($wage, 10);
                            }
                        }
                        break;
                    // Общеустановленный режим налогообложения
                    case Model_Tax_OrganizationTaxType::TAX_TYPE_GENERALLY:
                        if($isOwner){
                            // для владельца общейустановленной
                            switch ($workerStatusID) {
                                case Model_Tax_WorkerStatus::WORKER_STATUS_PENSIONER:
                                    $result = 0;
                                    break;
                                case Model_Tax_WorkerStatus::WORKER_STATUS_HANDICAPPED:
                                    $result = 0;
                                    break;
                                case Model_Tax_WorkerStatus::WORKER_STATUS_ALIEN:
                                    $result = 0;
                                    break;
                                case Model_Tax_WorkerStatus::WORKER_STATUS_ALIEN_NATIONAL:
                                    $result = 0;
                                    break;
                                default:
                                    $result = 0;
                            }
                        }else{
                            // для сотрудников общейустановленной
                            switch ($workerStatusID) {
                                case Model_Tax_WorkerStatus::WORKER_STATUS_PENSIONER:
                                    $result = self::calcPercent($wage, 10);
                                    break;
                                case Model_Tax_WorkerStatus::WORKER_STATUS_HANDICAPPED:
                                    $result = 0;
                                    break;
                                case Model_Tax_WorkerStatus::WORKER_STATUS_ALIEN:
                                    $result = self::calcPercent($basicWage, 10);
                                    break;
                                case Model_Tax_WorkerStatus::WORKER_STATUS_ALIEN_NATIONAL:
                                    $result = self::calcPercent($wage, 10);
                                    break;
                                default:
                                    $result = self::calcPercent($wage, 10);
                            }
                        }
                        break;
                }
                break;
            // ТОО
            case Model_OrganizationType::ORGANIZATION_TYPE_TOO:
                // выбор режима налогооблажения
                switch ($organizationTaxTypeID) {
                    // Упрощенный режим налогообложения
                    case Model_Tax_OrganizationTaxType::TAX_TYPE_SIMPLIFIED:
                        // упращенка
                        switch ($workerStatusID) {
                            case Model_Tax_WorkerStatus::WORKER_STATUS_PENSIONER:
                                $result = self::calcPercent($basicWage - 28284, 10);
                                break;
                            case Model_Tax_WorkerStatus::WORKER_STATUS_HANDICAPPED:
                                $result = 0;
                                break;
                            case Model_Tax_WorkerStatus::WORKER_STATUS_ALIEN:
                                $result = self::calcPercent($basicWage, 10);
                                break;
                            case Model_Tax_WorkerStatus::WORKER_STATUS_ALIEN_NATIONAL:
                                $result = self::calcPercent($wage, 10);
                                break;
                            default:
                                $result = self::calcPercent($wage, 10);
                        }
                        break;
                    // Общеустановленный режим налогообложения
                    case Model_Tax_OrganizationTaxType::TAX_TYPE_GENERALLY:
                        // общеустановленное
                        switch ($workerStatusID) {
                            case Model_Tax_WorkerStatus::WORKER_STATUS_PENSIONER:
                                $result = self::calcPercent($basicWage - 28284, 10);
                                break;
                            case Model_Tax_WorkerStatus::WORKER_STATUS_HANDICAPPED:
                                $result = 0;
                                break;
                            case Model_Tax_WorkerStatus::WORKER_STATUS_ALIEN:
                                $result = self::calcPercent($basicWage, 10);
                                break;
                            case Model_Tax_WorkerStatus::WORKER_STATUS_ALIEN_NATIONAL:
                                $result = self::calcPercent($wage, 10);
                                break;
                            default:
                                $result = self::calcPercent($wage, 10);
                        }
                        break;
                }
                break;
        }

        if($result < 0){
            $result = 0;
        }
        return $result;
    }

    /**
     * Зарплата от которой исчисляются Медицинское страхование
     * @param $wage
     * @return int
     */
    public static function getWageOSMS($year, $wage){
        $maxWageForOSMS = Api_Tax_Const::getMaxWageForOSMS($year);
        if ($wage >= $maxWageForOSMS) {
            $wage = $maxWageForOSMS;
        } else{
            $minWage = Api_Tax_Const::getMinWage($year);
            if ($wage <= $minWage) {
                $wage = $minWage;
            }
        }

        return $wage;
    }

    /**
     * Просчет ОСМС
     * @param $year
     * @param $wage
     * @param $organizationTypeID
     * @param $organizationTaxTypeID
     * @param $workerStatusID
     * @param bool $isOwner
     * @return int
     */
    public static function calcOSMS($year, $wage, $organizationTypeID, $organizationTaxTypeID, $workerStatusID, $isOwner = FALSE){
        $wage = self::getWageOSMS($year, $wage);

        // прощет налогов для зарплаы для Казахстана
        $result = 0;
        switch ($organizationTypeID) {
            // ИП
            case Model_OrganizationType::ORGANIZATION_TYPE_IP:

                // выбор режима налогооблажения
                switch ($organizationTaxTypeID) {
                    // Упрощенный режим налогообложения
                    case Model_Tax_OrganizationTaxType::TAX_TYPE_SIMPLIFIED:
                        if($isOwner){
                            //упрощенка для владельца
                            switch ($workerStatusID) {
                                case Model_Tax_WorkerStatus::WORKER_STATUS_PENSIONER:
                                    $result = 0;
                                    break;
                                case Model_Tax_WorkerStatus::WORKER_STATUS_HANDICAPPED:
                                    $result = 0;
                                    break;
                                case Model_Tax_WorkerStatus::WORKER_STATUS_ALIEN:
                                    $result = 0;
                                    break;
                                case Model_Tax_WorkerStatus::WORKER_STATUS_ALIEN_NATIONAL:
                                    $result = 0;
                                    break;
                                default:
                                    $result = 0;
                            }
                        }else{
                            // упрощенка для сотрудников
                            switch ($workerStatusID) {
                                case Model_Tax_WorkerStatus::WORKER_STATUS_PENSIONER:
                                    $result = 0;
                                    break;
                                case Model_Tax_WorkerStatus::WORKER_STATUS_HANDICAPPED:
                                    $result = 0;
                                    break;
                                case Model_Tax_WorkerStatus::WORKER_STATUS_ALIEN:
                                    $result = self::calcPercent($wage,1.5);
                                    break;
                                case Model_Tax_WorkerStatus::WORKER_STATUS_ALIEN_NATIONAL:
                                    $result = self::calcPercent($wage,1.5);
                                    break;
                                default:
                                    $result = self::calcPercent($wage,1.5);
                            }
                        }
                        break;
                    // Общеустановленный режим налогообложения
                    case Model_Tax_OrganizationTaxType::TAX_TYPE_GENERALLY:
                        if($isOwner){
                            // для владельца общейустановленной
                            switch ($workerStatusID) {
                                case Model_Tax_WorkerStatus::WORKER_STATUS_PENSIONER:
                                    $result = 0;
                                    break;
                                case Model_Tax_WorkerStatus::WORKER_STATUS_HANDICAPPED:
                                    $result = 0;
                                    break;
                                case Model_Tax_WorkerStatus::WORKER_STATUS_ALIEN:
                                    $result = 0;
                                    break;
                                case Model_Tax_WorkerStatus::WORKER_STATUS_ALIEN_NATIONAL:
                                    $result = 0;
                                    break;
                                default:
                                    $result = 0;
                            }
                        }else{
                            // для сотрудников общейустановленной
                            switch ($workerStatusID) {
                                case Model_Tax_WorkerStatus::WORKER_STATUS_PENSIONER:
                                    $result = 0;
                                    break;
                                case Model_Tax_WorkerStatus::WORKER_STATUS_HANDICAPPED:
                                    $result = 0;
                                    break;
                                case Model_Tax_WorkerStatus::WORKER_STATUS_ALIEN:
                                    $result = self::calcPercent($wage,1.5);
                                    break;
                                case Model_Tax_WorkerStatus::WORKER_STATUS_ALIEN_NATIONAL:
                                    $result = self::calcPercent($wage,1.5);
                                    break;
                                default:
                                    $result = self::calcPercent($wage,1.5);
                            }
                        }
                        break;
                }
                break;
            // ТОО
            case Model_OrganizationType::ORGANIZATION_TYPE_TOO:
                // выбор режима налогооблажения
                switch ($organizationTaxTypeID) {
                    // Упрощенный режим налогообложения
                    case Model_Tax_OrganizationTaxType::TAX_TYPE_SIMPLIFIED:
                        // упращенка
                        switch ($workerStatusID) {
                            case Model_Tax_WorkerStatus::WORKER_STATUS_PENSIONER:
                                $result = 0;
                                break;
                            case Model_Tax_WorkerStatus::WORKER_STATUS_HANDICAPPED:
                                $result = 0;
                                break;
                            case Model_Tax_WorkerStatus::WORKER_STATUS_ALIEN:
                                $result = self::calcPercent($wage,1.5);
                                break;
                            case Model_Tax_WorkerStatus::WORKER_STATUS_ALIEN_NATIONAL:
                                $result = self::calcPercent($wage,1.5);
                                break;
                            default:
                                $result = self::calcPercent($wage,1.5);
                        }
                        break;
                    // Общеустановленный режим налогообложения
                    case Model_Tax_OrganizationTaxType::TAX_TYPE_GENERALLY:
                        // общеустановленное
                        switch ($workerStatusID) {
                            case Model_Tax_WorkerStatus::WORKER_STATUS_PENSIONER:
                                $result = 0;
                                break;
                            case Model_Tax_WorkerStatus::WORKER_STATUS_HANDICAPPED:
                                $result = 0;
                                break;
                            case Model_Tax_WorkerStatus::WORKER_STATUS_ALIEN:
                                $result = self::calcPercent($wage,1.5);
                                break;
                            case Model_Tax_WorkerStatus::WORKER_STATUS_ALIEN_NATIONAL:
                                $result = self::calcPercent($wage,1.5);
                                break;
                            default:
                                $result = self::calcPercent($wage,1.5);
                        }
                        break;
                }
                break;
        }
        if($result < 0){
            $result = 0;
        }
        return $result;
    }

    /**
     * Просчет СН
     * @param $year
     * @param $wage
     * @param $organizationTypeID
     * @param $organizationTaxTypeID
     * @param $workerStatusID
     * @param bool $isOwner
     * @return int
     */
    public static function calcSN($year, $wage, $organizationTypeID, $organizationTaxTypeID, $workerStatusID, $isOwner = FALSE){
        // прощет налогов для зарплаы для Казахстана
        $result = 0;
        switch ($organizationTypeID) {
            // ИП
            case Model_OrganizationType::ORGANIZATION_TYPE_IP:

                // выбор режима налогооблажения
                switch ($organizationTaxTypeID) {
                    // Упрощенный режим налогообложения
                    case Model_Tax_OrganizationTaxType::TAX_TYPE_SIMPLIFIED:
                        if($isOwner){
                            //упрощенка для владельца
                            switch ($workerStatusID) {
                                case Model_Tax_WorkerStatus::WORKER_STATUS_PENSIONER:
                                    $result = 0;
                                    break;
                                case Model_Tax_WorkerStatus::WORKER_STATUS_HANDICAPPED:
                                    $result = 0;
                                    break;
                                case Model_Tax_WorkerStatus::WORKER_STATUS_ALIEN:
                                    $result = 0;
                                    break;
                                case Model_Tax_WorkerStatus::WORKER_STATUS_ALIEN_NATIONAL:
                                    $result = 0;
                                    break;
                                default:
                                    $result = 0;
                            }
                        }else{
                            // упрощенка для сотрудников
                            switch ($workerStatusID) {
                                case Model_Tax_WorkerStatus::WORKER_STATUS_PENSIONER:
                                    $result = 0;
                                    break;
                                case Model_Tax_WorkerStatus::WORKER_STATUS_HANDICAPPED:
                                    $result = 0;
                                    break;
                                case Model_Tax_WorkerStatus::WORKER_STATUS_ALIEN:
                                    $result = 0;
                                    break;
                                case Model_Tax_WorkerStatus::WORKER_STATUS_ALIEN_NATIONAL:
                                    $result = 0;
                                    break;
                                default:
                                    $result = 0;
                            }
                        }
                        break;
                    // Общеустановленный режим налогообложения
                    case Model_Tax_OrganizationTaxType::TAX_TYPE_GENERALLY:
                        if($isOwner){
                            $mrp = Api_Tax_Const::getMRP($year);
                            // для владельца общейустановленной
                            switch ($workerStatusID) {
                                case Model_Tax_WorkerStatus::WORKER_STATUS_PENSIONER:
                                    $result = $mrp * 2 - self::calcSO($year, $wage, $organizationTypeID, $organizationTaxTypeID, $workerStatusID, $isOwner);
                                    break;
                                case Model_Tax_WorkerStatus::WORKER_STATUS_HANDICAPPED:
                                    $result = $mrp * 2 - self::calcSO($year, $wage, $organizationTypeID, $organizationTaxTypeID, $workerStatusID, $isOwner);
                                    break;
                                case Model_Tax_WorkerStatus::WORKER_STATUS_ALIEN:
                                    $result = $mrp * 2 - self::calcSO($year, $wage, $organizationTypeID, $organizationTaxTypeID, $workerStatusID, $isOwner);
                                    break;
                                case Model_Tax_WorkerStatus::WORKER_STATUS_ALIEN_NATIONAL:
                                    $result = $mrp * 2 - self::calcSO($year, $wage, $organizationTypeID, $organizationTaxTypeID, $workerStatusID, $isOwner);
                                    break;
                                default:
                                    $result = $mrp * 2 - self::calcSO($year, $wage, $organizationTypeID, $organizationTaxTypeID, $workerStatusID, $isOwner);
                            }
                        }else{
                            $mrp = Api_Tax_Const::getMRP($year);
                            // для сотрудников общейустановленной
                            switch ($workerStatusID) {
                                case Model_Tax_WorkerStatus::WORKER_STATUS_PENSIONER:
                                    $result = $mrp;
                                    break;
                                case Model_Tax_WorkerStatus::WORKER_STATUS_HANDICAPPED:
                                    $result = $mrp - self::calcSO($year, $wage, $organizationTypeID, $organizationTaxTypeID, $workerStatusID, $isOwner);
                                    break;
                                case Model_Tax_WorkerStatus::WORKER_STATUS_ALIEN:
                                    $result = $mrp - self::calcSO($year, $wage, $organizationTypeID, $organizationTaxTypeID, $workerStatusID, $isOwner);
                                    break;
                                case Model_Tax_WorkerStatus::WORKER_STATUS_ALIEN_NATIONAL:
                                    $result = $mrp - self::calcSO($year, $wage, $organizationTypeID, $organizationTaxTypeID, $workerStatusID, $isOwner);
                                    break;
                                default:
                                    $result = $mrp - self::calcSO($year, $wage, $organizationTypeID, $organizationTaxTypeID, $workerStatusID, $isOwner);
                            }
                        }
                        break;
                }
                break;
            // ТОО
            case Model_OrganizationType::ORGANIZATION_TYPE_TOO:
                // выбор режима налогооблажения
                switch ($organizationTaxTypeID) {
                    // Упрощенный режим налогообложения
                    case Model_Tax_OrganizationTaxType::TAX_TYPE_SIMPLIFIED:
                        // упращенка
                        switch ($workerStatusID) {
                            case Model_Tax_WorkerStatus::WORKER_STATUS_PENSIONER:
                                $result = 0;
                                break;
                            case Model_Tax_WorkerStatus::WORKER_STATUS_HANDICAPPED:
                                $result = 0;
                                break;
                            case Model_Tax_WorkerStatus::WORKER_STATUS_ALIEN:
                                $result = 0;
                                break;
                            case Model_Tax_WorkerStatus::WORKER_STATUS_ALIEN_NATIONAL:
                                $result = self::calcPercent($wage - self::calcOPV($year, $wage, $organizationTypeID, $organizationTaxTypeID, $workerStatusID, $isOwner),9.5)
                                     - self::calcSO($year, $wage, $organizationTypeID, $organizationTaxTypeID, $workerStatusID, $isOwner);
                                break;
                            default:
                                $result = 0;
                        }
                        break;
                    // Общеустановленный режим налогообложения
                    case Model_Tax_OrganizationTaxType::TAX_TYPE_GENERALLY:
                        // общеустановленное
                        switch ($workerStatusID) {
                            case Model_Tax_WorkerStatus::WORKER_STATUS_PENSIONER:
                                $result = self::calcPercent($wage,9.5)
                                    - self::calcSO($year, $wage, $organizationTypeID, $organizationTaxTypeID, $workerStatusID, $isOwner);
                                break;
                            case Model_Tax_WorkerStatus::WORKER_STATUS_HANDICAPPED:
                                $result = self::calcPercent($wage - self::calcOPV($year, $wage, $organizationTypeID, $organizationTaxTypeID, $workerStatusID, $isOwner),9.5)
                                    - self::calcSO($year, $wage, $organizationTypeID, $organizationTaxTypeID, $workerStatusID, $isOwner);
                                break;
                            case Model_Tax_WorkerStatus::WORKER_STATUS_ALIEN:
                                $result = self::calcPercent($wage, 9.5)
                                    - self::calcSO($year, $wage, $organizationTypeID, $organizationTaxTypeID, $workerStatusID, $isOwner);
                                break;
                            case Model_Tax_WorkerStatus::WORKER_STATUS_ALIEN_NATIONAL:
                                $result = self::calcPercent($wage - self::calcOPV($year, $wage, $organizationTypeID, $organizationTaxTypeID, $workerStatusID, $isOwner),9.5)
                                    - self::calcSO($year, $wage, $organizationTypeID, $organizationTaxTypeID, $workerStatusID, $isOwner);
                                break;
                            default:
                                $result = self::calcPercent($wage - self::calcOPV($year, $wage, $organizationTypeID, $organizationTaxTypeID, $workerStatusID, $isOwner),9.5)
                                    - self::calcSO($year, $wage, $organizationTypeID, $organizationTaxTypeID, $workerStatusID, $isOwner);
                        }
                        break;
                }
                break;
        }

        if($result < 0){
            $result = 0;
        }
        return $result;
    }
}
