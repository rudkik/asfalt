<?php defined('SYSPATH') or die('No direct script access.');

class Api_Ab1_Shop_Work_Shift{

    /**
     * Получаем диазопон дат учитывая время смен
     * @param $dateFrom
     * @param $dateTo
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     */
    public static function getPeriodWorkShift(&$dateFrom, &$dateTo, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        // получаем количество рейсов машин + водителей
        $shopWorkShiftIDs = Request_Request::findAll(
            'DB_Ab1_Shop_Work_Shift', $sitePageData->shopID,
            $sitePageData, $driver, true
        );

        $timeFrom = strtotime('23:59:59');
        $timeTo = strtotime('00:00:00');
        foreach ($shopWorkShiftIDs->childs as $child) {
            $tmp = strtotime($child->values['time_from']);
            if ($tmp < $timeFrom) {
                $timeFrom = $tmp;
            }

            $tmp = strtotime($child->values['time_to']);
            if ($tmp > $timeTo) {
                $timeTo = $tmp;
            }
        }

        if(empty($dateFrom)){
            $dateFrom = date('Y-m-d');
        }
        if(empty($dateTo)){
            $dateTo = date('Y-m-d');
        }


        $dateFrom = Helpers_DateTime::getDateFormatRus($dateFrom) . date(' H:i:s', $timeFrom);
        $dateTo = Helpers_DateTime::getDateFormatRus($dateTo) . date(' H:i:s', $timeTo);
        if($timeTo <= $timeFrom){
            $dateTo = Helpers_DateTime::plusDays($dateTo, 1);
        }
    }

    /**
     * удаление товара
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

        $model = new Model_Ab1_Shop_Work_Shift();
        $model->setDBDriver($driver);

        if (!Helpers_DB::dublicateObjectLanguage($model, $id, $sitePageData)) {
            throw new HTTP_Exception_500('Work shift not found.');
        }

        if (($isUnDel && !$model->getIsDelete()) or (!$isUnDel && $model->getIsDelete())){
            return FALSE;
        }

        if($isUnDel){
            $model->dbUnDelete($sitePageData->userID, 0, $sitePageData->shopID);
        }else {
            $model->dbDelete($sitePageData->userID, 0, $sitePageData->shopID);
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
        $model = new Model_Ab1_Shop_Work_Shift();
        $model->setDBDriver($driver);

        $id = Request_RequestParams::getParamInt('id');
        if($id > 0) {
            if (!Helpers_DB::dublicateObjectLanguage($model, $id, $sitePageData, $sitePageData->shopID)) {
                throw new HTTP_Exception_500('Work shift not found.');
            }
        }

        Request_RequestParams::setParamBoolean('is_public', $model);
        Request_RequestParams::setParamStr('text', $model);
        Request_RequestParams::setParamStr('name', $model);
        Request_RequestParams::setParamStr("old_id", $model);
        Request_RequestParams::setParamTime("time_from", $model);
        Request_RequestParams::setParamTime("time_to", $model);
        Request_RequestParams::setParamInt("night_hours", $model);

        $options = Request_RequestParams::getParamArray('options');
        if ($options !== NULL) {
            $model->addOptionsArray($options);
        }

        $result = array();
        if ($model->validationFields($result)) {
            Helpers_DB::saveDBObject($model, $sitePageData, $sitePageData->shopID);
            $result['values'] = $model->getValues();
        }

        return array(
            'id' => $model->id,
            'result' => $result,
        );
    }
}
