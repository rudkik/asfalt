<?php defined('SYSPATH') or die('No direct script access.');

class Api_Tax_Shop_Worker_Wage  {

    /**
     * Средняя зарплата рабочего дня сотрудника за указанный период
     * @param $dateFrom
     * @param $dateTo
     * @param $shopWorkerID
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @return float
     */
    public static function getAveragedWorkDayWageWorker($dateFrom, $dateTo, $shopWorkerID, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        $params = Request_RequestParams::setParams(
            array(
                'shop_worker_id' => $shopWorkerID,
                'sum_wage' => TRUE,
                'sum_work_days' => TRUE,
                'date_from' => $dateFrom,
                'date_to' => $dateTo,
            )
        );
        $total = Request_Tax_Shop_Worker_Wage::findShopWorkerWageIDs($sitePageData->shopID, $sitePageData, $driver,
            $params , 0, TRUE);

        $result = intval($total->childs[0]->values['work_days']);
        if ($result > 0) {
            $result = round($total->childs[0]->values['wage'] / $result, 2);
        }else{
            $result = 0;
            $model = new Model_Tax_Shop_Worker();
            if (Helpers_DB::getDBObject($model, $shopWorkerID, $sitePageData)){
                $months = Helpers_DateTime::getMonthsPeriod($dateFrom, $dateTo);
                $workDays = Api_Tax_Shop_Work_Time::getWorkDay($dateFrom, $dateTo, $sitePageData, $driver);

                if ($workDays > 0) {
                    $result = round($model->getWageBasic() * count($months) / $workDays, 2);
                }
            }
        }

        return $result;
    }

    /**
     * Пересчитываем зарплату сотрудника в заданный месяц и год
     * @param Model_Tax_Shop_Worker_Wage $model
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @param bool $isCalcMonthWage - надо ли пересчитывать группу месяцев
     * @return bool
     */
    public static function recountWorkerWageModel(Model_Tax_Shop_Worker_Wage $model, SitePageData $sitePageData,
                                             Model_Driver_DBBasicDriver $driver, $isCalcMonthWage = TRUE)
    {
        $year = $model->getYear();
        if(($year > 2015) && ($year < 2020)) {
            return Api_Tax_Shop_Worker_Wage_001::recountWorkerWageModel($model, $sitePageData, $driver,
                $isCalcMonthWage);
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
        if(($year > 2015) && ($year < 2020)) {
            return Api_Tax_Shop_Worker_Wage_001::recountWorkerWage($month, $year, $shopWorkerID,
                $sitePageData, $driver);
        }
    }

    /**
     * Считаем стоимость записи табеля рабочего времени
     * @param Model_Tax_Shop_Work_Time $model
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     */
    public static function calcWorkTimeWage(Model_Tax_Shop_Work_Time $model, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        $year = Helpers_DateTime::getYear($model->getDateFrom());
        if(($year > 2015) && ($year < 2020)) {
            return Api_Tax_Shop_Worker_Wage_001::calcWorkTimeWage($model, $sitePageData, $driver);
        }
    }

    /**
     * Считаем общие зарплаты и налоги за месяц
     * @param $shopWorkerWageMonthID
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @param bool $isOwner
     * @return array
     */
    public static function getCalcWageAndTax($shopWorkerWageMonthID, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver, $isOwner = FALSE)
    {
        $shopWorkerWageIDs = Request_Tax_Shop_Worker_Wage::findShopWorkerWageIDs($sitePageData->shopID, $sitePageData,
            $driver, array('shop_worker_wage_month_id' => $shopWorkerWageMonthID, Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE), 0, TRUE);

        $result = array(
            'wage' => 0,
            'osms' => 0,
            'ipn' => 0,
            'sn' => 0,
            'so' => 0,
            'opv' => 0,
        );
        foreach ($shopWorkerWageIDs->childs as $shopWorkerWageID){
            $result['wage'] += $shopWorkerWageID->values['wage'];
            $result['osms'] += $shopWorkerWageID->values['osms'];
            $result['ipn'] += $shopWorkerWageID->values['ipn'];
            $result['sn'] += $shopWorkerWageID->values['sn'];
            $result['so'] += $shopWorkerWageID->values['so'];
            $result['opv'] += $shopWorkerWageID->values['opv'];
        }

        return $result;
    }

    /**
     * Получаем минимальную зарплату
     * @param null $halfYear
     * @param null $year
     * @return int
     */
    public static function getMinWage($halfYear = NULL, $year = NULL)
    {
        if ($year === NULL){
            $year = date('Y');
        }

        return Api_Tax_Const::getMinWage($year);
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
        // до 2020 года
        if(($year > 2015) && ($year < 2020)) {
            return Api_Tax_Shop_Worker_Wage_001::saveSixWage($halfYear, $year, $shopWorkerWages,
                $sitePageData, $driver, $isOwner, $isEditWage);
        }
    }

    /**
     * Сохранение товары
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @throws HTTP_Exception_500
     */
    public static function save(SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        $model = new Model_Tax_Shop_Worker_Wage();
        $model->setDBDriver($driver);

        $id = Request_RequestParams::getParamInt('id');
        if($id > 0) {
            if (!Helpers_DB::dublicateObjectLanguage($model, $id, $sitePageData)) {
                throw new HTTP_Exception_500('Worker wage not found.');
            }
        }

        Request_RequestParams::setParamBoolean('is_public', $model);
        Request_RequestParams::setParamStr('text', $model);
        Request_RequestParams::setParamStr('name', $model);
        Request_RequestParams::setParamStr("old_id", $model);

        Request_RequestParams::setParamInt("shop_worker_id", $model);
        Request_RequestParams::setParamInt("worker_status_id", $model);
        Request_RequestParams::setParamBoolean("is_owner", $model);

        $yearOld = $model->getYear();
        $year = Request_RequestParams::getParamInt('year');
        if($year > 0){
           $model->setYear($year);
        }

        $monthOld = $model->getMonth();
        $month = Request_RequestParams::getParamInt('month');
        if($month > 0){
            $model->setMonth($month);
        }

        $wage = $model->getWage();
        $wageNew = Request_RequestParams::getParamFloat("wage");
        $model->setWageBasic($wageNew);

        $options = Request_RequestParams::getParamArray('options');
        if ($options !== NULL) {
            $model->addOptionsArray($options);
        }

        // при создании нового контрагента
        if(Request_RequestParams::getParamBoolean('is_add_worker')){
            $shopWorker = Request_RequestParams::getParamArray('shop_worker');
            if ($shopWorker !== NULL){
                $shopWorker = Api_Tax_Shop_Worker::saveOfArray($shopWorker, $sitePageData, $driver);
                $model->setShopWorkerID($shopWorker['id']);
            }
        }

        $result = array();
        if ($model->validationFields($result)) {

            Helpers_DB::saveDBObject($model, $sitePageData);

            // если поменялась заплата / месяц / год
            if (($wage != $model->getWageBasic()) || ($monthOld != $model->getMonth()) || ($yearOld != $model->getYear())) {
                // пересчитываем зарплату сотрудника за указанный месяц
                Api_Tax_Shop_Worker_Wage::recountWorkerWageModel($model, $sitePageData, $driver);

                // пересчитываем предыдущий месяц (группа зарплат)
                if ( ($monthOld != $model->getMonth()) || ($yearOld != $model->getYear())) {
                    Api_Tax_Shop_Worker_Wage_Month::checkCalcWagesMonth($model->getMonth(),
                        $model->getYear(), $sitePageData, $driver);
                }
            }

            $result['values'] = $model->getValues();
        }

        return array(
            'id' => $model->id,
            'result' => $result,
        );
    }

    /**
     * Сохраняем список зарплат сотрудников за месяц
     * @param $month
     * @param $year
     * @param $shopWorkerWageMonthID
     * @param array $shopWorkerWages
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @return float|int
     */
    public static function saveList($month, $year, $shopWorkerWageMonthID,  array $shopWorkerWages,
                                    SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        $model = new Model_Tax_Shop_Worker_Wage();
        $model->setDBDriver($driver);

        $shopWorkerWageIDs = Request_Tax_Shop_Worker_Wage::findShopWorkerWageIDs($sitePageData->shopID, $sitePageData, $driver,
            array('shop_worker_wage_month_id' => $shopWorkerWageMonthID, Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE),
            0, TRUE);

        $result = array(
            'wage' => 0,
            'osms' => 0,
            'ipn' => 0,
            'sn' => 0,
            'so' => 0,
            'opv' => 0,
        );
        foreach($shopWorkerWages as $shopWorkerWage){
            $shopWorkerID = intval(Arr::path($shopWorkerWage, 'shop_worker_id', ''));
            if($shopWorkerID < 1){
                continue;
            }
            $wage = str_replace(' ', '', str_replace(',', '.', floatval(Arr::path($shopWorkerWage, 'wage', 0))));
            if($wage <= 0){
                continue;
            }

            $model->clear();
            $shopWorkerWageID = array_shift($shopWorkerWageIDs->childs);
            if($shopWorkerWageID !== NULL){
                $model->__setArray(array('values' => $shopWorkerWageID->values));
            }

            $model->setWage($wage);
            $model->setMonth($month);
            $model->setYear($year);

            $model->setWorkerStatusID(Arr::path($shopWorkerWage, 'worker_status_id', ''));
            $model->setIsOwner(Request_RequestParams::isBoolean(Arr::path($shopWorkerWage, 'is_owner', '')));

            // пересчитываем зарплату сотрудника за указанный месяц
            Api_Tax_Shop_Worker_Wage::recountWorkerWageModel($model, $sitePageData, $driver, FALSE);

            $model->setShopWorkerWageMonthID($shopWorkerWageMonthID);
            $model->setShopWorkerID($shopWorkerID);
            Helpers_DB::saveDBObject($model, $sitePageData);

            $result['wage'] += $model->getWage();
            $result['osms'] += $model->getOSMS();
            $result['ipn'] += $model->getIPN();
            $result['sn'] += $model->getSN();
            $result['so'] += $model->getSO();
            $result['opv'] += $model->getOPV();
        }

        // удаляем лишние
        $driver->deleteObjectIDs($shopWorkerWageIDs->getChildArrayID(), $sitePageData->userID,
            Model_Tax_Shop_Worker_Wage::TABLE_NAME, array(), $sitePageData->shopID);

        return $result;
    }

    /**
     * Считаем налоги для зарплаты сотрудника
     * @param Model_Tax_Shop_Worker_Wage $model
     * @param SitePageData $sitePageData
     */
    public static function calcTax(Model_Tax_Shop_Worker_Wage $model, SitePageData $sitePageData){
        // прощет налогов для зарплаты для Казахстана
        $organizationTypeID = Arr::path($sitePageData->shop->getRequisitesArray(), 'organization_type_id', 0);
        $organizationTaxTypeID = Arr::path($sitePageData->shop->getRequisitesArray(), 'organization_tax_type_id', 0);
        $model->setOPV(self::calcOPV($model->getHalfYear(), $model->getYear(), $model->getWage(), $organizationTypeID, $organizationTaxTypeID, $model->getWorkerStatusID(), $model->getIsOwner()));
        $model->setSO(self::calcSO($model->getHalfYear(), $model->getYear(), $model->getWage(), $organizationTypeID, $organizationTaxTypeID, $model->getWorkerStatusID(), $model->getIsOwner()));
        $model->setIPN(self::calcIPN($model->getHalfYear(), $model->getYear(), $model->getWage(), $organizationTypeID, $organizationTaxTypeID, $model->getWorkerStatusID(), $model->getIsOwner()));
        $model->setOSMS(self::calcOSMS($model->getHalfYear(), $model->getYear(), $model->getWage(), $organizationTypeID, $organizationTaxTypeID, $model->getWorkerStatusID(), $model->getIsOwner()));
        $model->setSN(self::calcSN($model->getHalfYear(), $model->getYear(), $model->getWage(), $organizationTypeID, $organizationTaxTypeID, $model->getWorkerStatusID(), $model->getIsOwner()));

    }

    /**
     * просчет процента от суммы с округлением
     * @param $amount
     * @param $percent
     * @return float
     */
    public static function calcPercent($amount, $percent){
        return round($amount / 100 * $percent, 2);
    }

    /**
     * Просчет ОПВ
     * @param $halfYear
     * @param $year
     * @param $wage
     * @param $organizationTypeID
     * @param $organizationTaxTypeID
     * @param $workerStatusID
     * @param bool $isOwner
     * @return float|int
     */
    public static function calcOPV($halfYear, $year, $wage, $organizationTypeID, $organizationTaxTypeID, $workerStatusID, $isOwner = FALSE){
        // до 2020 года
        if(($year > 2015) && ($year < 2020)) {
            return Api_Tax_Shop_Worker_Wage_001::calcOPV($year, $wage, $organizationTypeID, $organizationTaxTypeID, $workerStatusID, $isOwner);
        }

        return 0;
    }

    /**
     * Зарплата от коротой идут Социальные отчисления
     * @param $halfYear
     * @param $year
     * @param $wage
     * @param $organizationTypeID
     * @param $organizationTaxTypeID
     * @param $workerStatusID
     * @param bool $isOwner
     * @return int
     */
    public static function getWageSO($halfYear, $year, $wage, $organizationTypeID, $organizationTaxTypeID, $workerStatusID, $isOwner = FALSE){
        // до 2020 года
        if(($year > 2015) && ($year < 2020)) {
            return Api_Tax_Shop_Worker_Wage_001::getWageSO($year, $wage, $organizationTypeID, $organizationTaxTypeID, $workerStatusID, $isOwner);
        }

        return $wage;
    }

    /**
     * Просчет СО
     * @param $halfYear
     * @param $year
     * @param $wage
     * @param $organizationTypeID
     * @param $organizationTaxTypeID
     * @param $workerStatusID
     * @param bool $isOwner
     * @return float|int
     */
    public static function calcSO($halfYear, $year, $wage, $organizationTypeID, $organizationTaxTypeID, $workerStatusID, $isOwner = FALSE){
        // до 2020 года
        if(($year > 2015) && ($year < 2020)) {
            return Api_Tax_Shop_Worker_Wage_001::calcSO($year, $wage, $organizationTypeID, $organizationTaxTypeID, $workerStatusID, $isOwner);
        }

        return 0;
    }

    /**
     * Просчет ИПН
     * @param $halfYear
     * @param $year
     * @param $wage
     * @param $organizationTypeID
     * @param $organizationTaxTypeID
     * @param $workerStatusID
     * @param bool $isOwner
     * @return float|int
     */
    public static function calcIPN($halfYear, $year, $wage, $organizationTypeID, $organizationTaxTypeID, $workerStatusID, $isOwner = FALSE){
        // до 2019 года
        if(($year > 2015) && ($year < 2019)) {
            return Api_Tax_Shop_Worker_Wage_001::calcIPN($year, $wage, $organizationTypeID, $organizationTaxTypeID, $workerStatusID, $isOwner);
        }elseif(($year >= 2019) && ($year < 2100)) {
            return Api_Tax_Shop_Worker_Wage_002::calcIPN($year, $wage, $organizationTypeID, $organizationTaxTypeID, $workerStatusID, $isOwner);
        }

        return 0;
    }

    /**
     * Зарплата от которой исчисляются Медицинское страхование
     * @param $halfYear
     * @param $year
     * @param $wage
     * @return int
     */
    public static function getWageOSMS($halfYear, $year, $wage){
        // до 2020 года
        if(($year > 2015) && ($year < 2020)) {
            return Api_Tax_Shop_Worker_Wage_001::getWageOSMS($year, $wage);
        }

        return $wage;
    }

    /**
     * Просчет ОСМС
     * @param $halfYear
     * @param $year
     * @param $wage
     * @param $organizationTypeID
     * @param $organizationTaxTypeID
     * @param $workerStatusID
     * @param bool $isOwner
     * @return int
     */
    public static function calcOSMS($halfYear, $year, $wage, $organizationTypeID, $organizationTaxTypeID, $workerStatusID, $isOwner = FALSE){
        // до 2020 года
        if(($year > 2015) && ($year < 2020)) {
            return Api_Tax_Shop_Worker_Wage_001::calcOSMS($year, $wage, $organizationTypeID, $organizationTaxTypeID, $workerStatusID, $isOwner);
        }

        return 0;
    }

    /**
     * Просчет СН
     * @param $halfYear
     * @param $year
     * @param $wage
     * @param $organizationTypeID
     * @param $organizationTaxTypeID
     * @param $workerStatusID
     * @param bool $isOwner
     * @return int
     */
    public static function calcSN($halfYear, $year, $wage, $organizationTypeID, $organizationTaxTypeID, $workerStatusID, $isOwner = FALSE){
        // до 2020 года
        if(($year > 2015) && ($year < 2020)) {
            return Api_Tax_Shop_Worker_Wage_001::calcSN($year, $wage, $organizationTypeID, $organizationTaxTypeID, $workerStatusID, $isOwner);
        }

        return 0;
    }
}
