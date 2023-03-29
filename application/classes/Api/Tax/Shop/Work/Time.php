<?php defined('SYSPATH') or die('No direct script access.');

class Api_Tax_Shop_Work_Time  {

    /**
     * удаление записи табеля
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @return bool
     * @throws HTTP_Exception_500
     */
    public static function delete(SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        $id = Request_RequestParams::getParamInt('id');
        if($id < 0){
            return FALSE;
        }
        $isUnDel = Request_RequestParams::getParamBoolean("is_undel");

        $model = new Model_Tax_Shop_Work_Time();
        $model->setDBDriver($driver);

        if (!Helpers_DB::dublicateObjectLanguage($model, $id, $sitePageData)) {
            throw new HTTP_Exception_500('Work time month not found.');
        }

        if (($isUnDel && !$model->getIsDelete()) or (!$isUnDel && $model->getIsDelete())){
            return FALSE;
        }

        if($isUnDel){
            $model->dbUnDelete($sitePageData->userID, 0, $sitePageData->shopID);

            // пересчитываем стоимость записи табеля рабочего времени
            Api_Tax_Shop_Worker_Wage::calcWorkTimeWage($model, $sitePageData, $driver);
        }else {
            $model->dbDelete($sitePageData->userID, 0, $sitePageData->shopID);
        }

        /** Получаем такие же строки в заданный период **/
        $params = Request_RequestParams::setParams(
            array(
                'shop_worker_id' => $model->getShopWorkerID(),
                'period_from' => $model->getDateFrom(),
                'period_to' => $model->getDateTo(),
                'work_time_type_id' => $model->getWorkTimeTypeID(),
            )
        );
        $shopWorkTimeIDs = Request_Tax_Shop_Work_Time::findShopWorkTimeIDs($sitePageData->shopID, $sitePageData, $driver,
            $params , 0, TRUE);

        foreach ($shopWorkTimeIDs->childs as $child){
            $model->clear();
            $model->__setArray(array('values' => $child->values));

            // пересчитываем стоимость записи табеля рабочего времени
            Api_Tax_Shop_Worker_Wage::calcWorkTimeWage($model, $sitePageData, $driver);
        }

        return TRUE;
    }

    /**
     * Количество рабочих дней за указанных период
     * @param $dateFrom
     * @param $dateTo
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @return float|int
     */
    public static function getWorkDay($dateFrom, $dateTo, SitePageData $sitePageData,
                                           Model_Driver_DBBasicDriver $driver)
    {
        $params = Request_RequestParams::setParams(
            array(
                'date_from' => $dateFrom,
                'date_to' => $dateTo,
                'count_id' => TRUE,
            )
        );
        $shopCalendarIDs = Request_Tax_Shop_Calendar::findShopCalendarIDs($sitePageData->shopMainID, $sitePageData, $driver,
            $params, 0, TRUE);

        $days = Helpers_DateTime::diffDays($dateTo, $dateFrom) + 1;
        return $days - $shopCalendarIDs->childs[0]->values['count'];
    }

    /**
     * Количество рабочих дней в указанных период за указанный месяц
     * @param $dateFrom
     * @param $dateTo
     * @param $month
     * @param $year
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @return float|int
     */
    public static function getWorkDayMonth($dateFrom, $dateTo, $month, $year, SitePageData $sitePageData,
                                           Model_Driver_DBBasicDriver $driver)
    {
        // получаем период для заданного месяца
        $period = Helpers_DateTime::getPeriodDateByMonth($dateFrom, $dateTo, $month, $year);
        if ($period === NULL){
            return 0;
        }

        return self::getWorkDay($period['from'], $period['to'], $sitePageData, $driver);
    }


    /**
     * Сохранение товары
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @throws HTTP_Exception_500
     */
    public static function save(SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        $model = new Model_Tax_Shop_Work_Time();
        $model->setDBDriver($driver);

        $id = Request_RequestParams::getParamInt('id');
        if($id > 0) {
            if (!Helpers_DB::dublicateObjectLanguage($model, $id, $sitePageData)) {
                throw new HTTP_Exception_500('Work time not found.');
            }
        }

        Request_RequestParams::setParamBoolean('is_public', $model);
        Request_RequestParams::setParamStr('text', $model);
        Request_RequestParams::setParamStr('name', $model);
        Request_RequestParams::setParamStr("old_id", $model);

        Request_RequestParams::setParamInt("shop_worker_id", $model);
        Request_RequestParams::setParamInt("work_time_type_id", $model);
        Request_RequestParams::setParamDateTime("date_from", $model);
        Request_RequestParams::setParamDateTime("date_to", $model);

        $period = Request_RequestParams::getParamStr("period");
        if (!empty($period)){
            $tmp = strpos($period, ' - ');
            if($tmp !== FALSE) {
                $model->setDateFrom(substr($period, 0, $tmp));
                $model->setDateTo(substr($period, $tmp + 3));
            }
        }

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

            // пересчитываем стоимость записи табеля рабочего времени
            Api_Tax_Shop_Worker_Wage::calcWorkTimeWage($model, $sitePageData, $driver);

            Helpers_DB::saveDBObject($model, $sitePageData);
            $result['values'] = $model->getValues();
        }

        return array(
            'id' => $model->id,
            'result' => $result,
        );
    }
}
