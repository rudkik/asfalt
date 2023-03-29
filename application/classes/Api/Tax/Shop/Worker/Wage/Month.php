<?php defined('SYSPATH') or die('No direct script access.');

class Api_Tax_Shop_Worker_Wage_Month  {

    /**
     * Пересчитываем месяцы в полугодии
     * @param $halfYear
     * @param $year
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     */
    public static function checkCalcWagesHalfYear($halfYear, $year, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        if ($halfYear == 1){
            $months = array(1, 2, 3, 4, 5, 6);
        }else{
            $months = array(7, 8, 9, 10, 11, 12);
        }

        foreach ($months as $month){
            self::checkCalcWagesMonth($month, $year, $sitePageData, $driver);
        }
    }

    /**
     * Пересчитываем месяц
     * @param $month
     * @param $year
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @return int
     */
    public static function checkCalcWagesMonth($month, $year, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        // получаем месяц
        $params = Request_RequestParams::setParams(
            array(
                'year' => intval($year),
                'month' => intval($month),
            )
        );

        $shopWorkerWageMonthIDs = Request_Tax_Shop_Worker_Wage_Month::findShopWorkerWageMonthIDs($sitePageData->shopID,
            $sitePageData, $driver, $params, 0, TRUE);

        // если несколько строк месяца, то удаляем лишние
        if(count($shopWorkerWageMonthIDs->childs) > 1){
            $i = 0;
            foreach ($shopWorkerWageMonthIDs->childs as $key => $child){
                $i++;
                if ($i > 1){
                    $modelMonth = new Model_Tax_Shop_Worker_Wage_Month();
                    $modelMonth->setDBDriver($driver);
                    $modelMonth->__setArray(array('values' => $child->values));
                    $modelMonth->dbDelete($sitePageData->userID);

                    unset($shopWorkerWageMonthIDs->childs[$key]);
                }
            }
        }

        // получаем все зарплаты в месяце
        $shopWorkerWageIDs = Request_Tax_Shop_Worker_Wage::findShopWorkerWageIDs($sitePageData->shopID,
            $sitePageData, $driver, $params, 0, TRUE);

        // если нет зарплат, то удаляем месяц
        if(count($shopWorkerWageIDs->childs) == 0){
            if(count($shopWorkerWageMonthIDs->childs) == 1){
                $modelMonth = new Model_Tax_Shop_Worker_Wage_Month();
                $modelMonth->setDBDriver($driver);
                $modelMonth->__setArray(array('values' => $shopWorkerWageMonthIDs->childs[0]->values));
                $modelMonth->dbDelete($sitePageData->userID);
            }

            return 0;
        }

        $modelMonth = new Model_Tax_Shop_Worker_Wage_Month();
        $modelMonth->setDBDriver($driver);
        if(count($shopWorkerWageMonthIDs->childs) == 1){
            $modelMonth->__setArray(array('values' => $shopWorkerWageMonthIDs->childs[0]->values));
        }else{
            $modelMonth->setMonth($month);
            $modelMonth->setYear($year);
            Helpers_DB::saveDBObject($modelMonth, $sitePageData);
        }

        $modelWage = new Model_Tax_Shop_Worker_Wage();
        $modelWage->setDBDriver($driver);

        $opv = 0;
        $so = 0;
        $ipn = 0;
        $osms = 0;
        $wage = 0;
        $sn = 0;

        // проходим по всем зарплатам и считаем общие значения
        foreach ($shopWorkerWageIDs->childs as $index => $shopWorkerWageID){
            $opv += $shopWorkerWageID->values['opv'];
            $so += $shopWorkerWageID->values['so'];
            $ipn += $shopWorkerWageID->values['ipn'];
            $osms += $shopWorkerWageID->values['osms'];
            $wage += $shopWorkerWageID->values['wage'];
            $sn += $shopWorkerWageID->values['sn'];

            if($shopWorkerWageID->values['shop_worker_wage_month_id'] != $modelMonth->id){
                $modelWage->clear();
                $modelWage->__setArray(array('values' => $shopWorkerWageID->values));
                $modelWage->setShopWorkerWageMonthID($modelMonth->id);

                Helpers_DB::saveDBObject($modelWage, $sitePageData);
            }
        }

        $modelMonth->setOPV($opv);
        $modelMonth->setSO($so);
        $modelMonth->setIPN($ipn);
        $modelMonth->setOSMS($osms);
        $modelMonth->setWage($wage);
        $modelMonth->setSN($sn);
        $result = Helpers_DB::saveDBObject($modelMonth, $sitePageData);

        return $result;
    }

    /**
     * удаление месяца
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

        $model = new Model_Tax_Shop_Worker_Wage_Month();
        $model->setDBDriver($driver);

        if (!Helpers_DB::dublicateObjectLanguage($model, $id, $sitePageData)) {
            throw new HTTP_Exception_500('Worker wage month not found.');
        }

        if (($isUnDel && !$model->getIsDelete()) or (!$isUnDel && $model->getIsDelete())){
            return FALSE;
        }

        if($isUnDel){
            $ids = Request_Tax_Shop_Worker_Wage::findShopWorkerWageIDs($sitePageData->shopID, $sitePageData, $driver,
              array('shop_worker_wage_month_id' => $id, 'is_delete' => 1, 'is_public' => 0, Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE));

            $driver->unDeleteObjectIDs($ids->getChildArrayID(), $sitePageData->userID, Model_Tax_Shop_Worker_Wage::TABLE_NAME,
                $sitePageData->shopID, array('is_public' => 1), $sitePageData->shopID);

            $model->dbUnDelete($sitePageData->userID, 0, $sitePageData->shopID);
        }else {
            $ids = Request_Tax_Shop_Worker_Wage::findShopWorkerWageIDs($sitePageData->shopID, $sitePageData, $driver,
                array('shop_worker_wage_month_id' => $id, Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE));

            $driver->deleteObjectIDs($ids->getChildArrayID(), $sitePageData->userID,
                Model_Tax_Shop_Worker_Wage::TABLE_NAME, array('is_public' => 0), $sitePageData->shopID);

            $model->dbDelete($sitePageData->userID, 0, $sitePageData->shopID);
        }

        return TRUE;
    }

    /**
     * Сохранение товары
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @throws HTTP_Exception_500
     */
    public static function save(SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        $model = new Model_Tax_Shop_Worker_Wage_Month();
        $model->setDBDriver($driver);

        $id = Request_RequestParams::getParamInt('id');
        if($id > 0) {
            if (!Helpers_DB::dublicateObjectLanguage($model, $id, $sitePageData)) {
                throw new HTTP_Exception_500('Worker wage month not found.');
            }

            $type = $model->getShopTableCatalogID();
        }else{
            $type = Request_RequestParams::getParamInt('type');
            $model->setShopTableCatalogID($type);
        }

        Request_RequestParams::setParamInt("shop_table_rubric_id", $model);
        Request_RequestParams::setParamBoolean('is_public', $model);
        Request_RequestParams::setParamStr('text', $model);
        Request_RequestParams::setParamStr('name', $model);
        Request_RequestParams::setParamBoolean("is_public", $model);
        Request_RequestParams::setParamStr("last_name", $model);
        Request_RequestParams::setParamStr("email", $model);
        Request_RequestParams::setParamStr("old_id", $model);
        Request_RequestParams::setParamInt("shop_table_select_id", $model);
        Request_RequestParams::setParamInt("shop_table_unit_id", $model);
        Request_RequestParams::setParamInt("shop_table_brand_id", $model);

        $year = Request_RequestParams::getParamInt('year');
        if($year > 0){
           $model->setYear($year);
        }

        $month = Request_RequestParams::getParamInt('month');
        if($month > 0){
            $model->setMonth($month);
        }

        $options = Request_RequestParams::getParamArray('options');
        if ($options !== NULL) {
            $model->addOptionsArray($options);
        }

        $result = array();
        if ($model->validationFields($result)) {
            if($model->id < 1) {
                Helpers_DB::saveDBObject($model, $sitePageData);
            }

            $shopWorkerWages = Request_RequestParams::getParamArray('shop_worker_wages');
            if($shopWorkerWages !== NULL) {
                $data = Api_Tax_Shop_Worker_Wage::saveList($model->getMonth(), $model->getYear(), $model->id, $shopWorkerWages, $sitePageData, $driver);
                $model->setWage($data['wage']);
                $model->setOSMS($data['osms']);
                $model->setIPN($data['ipn']);
                $model->setSN($data['sn']);
                $model->setSO($data['so']);
                $model->setOPV($data['opv']);
            }

            // загружаем фотографии
            $file = new Model_File($sitePageData);
            $file->saveFiles(Request_RequestParams::getParamArray('files'), $model, $sitePageData, $driver);

            if($type > 0) {
                $modelType = new Model_Shop_Table_Catalog();
                $modelType->setDBDriver($driver);
                Helpers_DB::dublicateObjectLanguage($modelType, $type, $sitePageData);

                // сохраняем список хэштегов
                $hashtags = Request_RequestParams::getParamArray('shop_table_hashtags');
                if ($hashtags !== NULL) {
                    $model->setShopTableHashtagIDsArray(Api_Shop_Table_ObjectToObject::saveToHashtags(
                        Model_Tax_Shop_Worker_Wage::TABLE_ID, $model->id, $model->getShopTableCatalogID(),
                        $hashtags, $modelType->getChildShopTableCatalogID('hashtag', $sitePageData->dataLanguageID),
                        $sitePageData, $driver));
                }
            }

            Helpers_DB::saveDBObject($model, $sitePageData);
            $result['values'] = $model->getValues();
        }

        return array(
            'id' => $model->id,
            'type' => $type,
            'result' => $result,
        );
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
        // до 2020 года
        if(($year > 2015) && ($year < 2020)) {
            return Api_Tax_Shop_Worker_Wage_001::calcIPN($year, $wage, $organizationTypeID, $organizationTaxTypeID, $workerStatusID, $isOwner);
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
