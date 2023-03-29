<?php defined('SYSPATH') or die('No direct script access.');

class Api_Magazine_Shop_Worker_Limit  {
    /**
     * Просчет заблокированного баланса лимита сотрудника
     * @param $shopWorkerID
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @param bool $isSaveAmount
     * @return int
     * @throws HTTP_Exception_500
     */
    public static function calcAmountBlock($shopWorkerID, $date, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver,
                                            $isSaveAmount = TRUE)
    {
        $shopWorkerID = intval($shopWorkerID);
        if($shopWorkerID < 1) {
            return FALSE;
        }

        $year = Helpers_DateTime::getYear($date);
        $month = Helpers_DateTime::getMonth($date);

        $params = Request_RequestParams::setParams(
            array(
                'shop_worker_id' => $shopWorkerID,
                'year' => $year,
                'month' => $month,
            )
        );
        // реализация
        $shopWorkerLimitIDs = Request_Request::findBranch('DB_Magazine_Shop_Worker_Limit',
            array(), $sitePageData, $driver, $params, 1, true
        );
        if(count($shopWorkerLimitIDs->childs) == 0){
            return false;
        }

        $params = Request_RequestParams::setParams(
            array(
                'created_at_from_equally' => Helpers_DateTime::getMonthBeginStr($month, $year),
                'created_at_to' => Helpers_DateTime::getMonthEndStr($month, $year).' 23:59:59',
                'shop_worker_id_from' => 0,
                'shop_write_off_type_id' => [0, Model_Magazine_Shop_WriteOff_Type::WRITE_OFF_TYPE_REDRESS],
                'sum_amount' => TRUE,
                'shop_worker_id' => $shopWorkerID,
            )
        );

        $ids = Request_Request::findBranch('DB_Magazine_Shop_Realization',
            array(), $sitePageData, $driver, $params
        );
        if(count($ids->childs) > 0){
            $amount = $ids->childs[0]->values['amount'];
        }else{
            $amount = 0;
        }

        if($isSaveAmount) {
            $model = new Model_Magazine_Shop_Worker_Limit();
            $model->setDBDriver($driver);
            $shopWorkerLimitIDs->childs[0]->setModel($model);

            $model->setAmountBlock($amount);
            Helpers_DB::saveDBObject($model, $sitePageData, $model->shopID);
        }

        return $amount;
    }

    /**
     * удаление
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

        $model = new Model_Magazine_Shop_Worker_Limit();
        $model->setDBDriver($driver);

        if (!Helpers_DB::dublicateObjectLanguage($model, $id, $sitePageData, $sitePageData->shopMainID)) {
            throw new HTTP_Exception_500('Write off type not found.');
        }

        if(Request_RequestParams::getParamBoolean("is_undel") === TRUE){
            $model->dbUnDelete($sitePageData->userID, 0, $sitePageData->shopMainID);
        }else {
            $model->dbDelete($sitePageData->userID, 0, $sitePageData->shopMainID);
        }

        return TRUE;
    }

    /**
     * Сохранение
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @return array
     * @throws HTTP_Exception_500
     */
    public static function save(SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        $model = new Model_Magazine_Shop_Worker_Limit();
        $model->setDBDriver($driver);

        $id = Request_RequestParams::getParamInt('id');
        if($id > 0) {
            if (!Helpers_DB::dublicateObjectLanguage($model, $id, $sitePageData, $sitePageData->shopMainID)) {
                throw new HTTP_Exception_500('Write off type not found.');
            }
        }

        Request_RequestParams::setParamBoolean('is_public', $model);
        Request_RequestParams::setParamStr('text', $model);
        Request_RequestParams::setParamStr("old_id", $model);
        Request_RequestParams::setParamInt("shop_worker_id", $model);
        Request_RequestParams::setParamStr('name', $model);
        Request_RequestParams::setParamFloat("amount", $model);
        $model->setAmountBalance($model->getAmount() - $model->getAmountBlock());

        $month = Request_RequestParams::getParamInt("month");
        if($month !== NULL){
            $model->setMonth($month);
        }

        $year = Request_RequestParams::getParamInt("year");
        if($year !== NULL){
            $model->setYear($year);
        }

        $options = Request_RequestParams::getParamArray('options');
        if ($options !== NULL) {
            $model->addOptionsArray($options);
        }

        $result = array();
        if ($model->validationFields($result)) {
            if($model->id < 1) {
                Helpers_DB::saveDBObject($model, $sitePageData, $sitePageData->shopMainID);
            }

            // загружаем фотографии
            $file = new Model_File($sitePageData);
            $file->saveFiles(Request_RequestParams::getParamArray('files'), $model, $sitePageData, $driver);

            Helpers_DB::saveDBObject($model, $sitePageData, $sitePageData->shopMainID);
            $result['values'] = $model->getValues();
        }

        return array(
            'id' => $model->id,
            'result' => $result,
        );
    }
}
