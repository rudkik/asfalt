<?php defined('SYSPATH') or die('No direct script access.');

class Api_Ab1_Holiday  {

    /**
     * @param Model_Ab1_HolidayYear $modelHolidayYear
     * @param array $holidays
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @return array
     */
    public static function save(Model_Ab1_HolidayYear $modelHolidayYear, array $holidays,
                                SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        $holidayYearID = $modelHolidayYear->id;
        $year = $modelHolidayYear->getYear();


        $holidayIDs = Request_Request::findNotShop(
            'DB_Ab1_Holiday', $sitePageData, $driver,
            Request_RequestParams::setParams(
                array(
                    'holiday_year_id' => $holidayYearID,
                )
            ), 0, TRUE
        );

        $model = new Model_Ab1_Holiday();
        $model->setDBDriver($driver);

        $result = array(
            'frees' => 0,
            'holidays' => 0,
        );
        foreach($holidays as $holiday => $holidayType){
            if($holidayType == 0){
                continue;
            }

            $holidayIDs->childShiftSetModel($model);

            $model->setYear($year);
            $model->setHolidayYearID($holidayYearID);
            $model->setDay($holiday);
            $model->setIsFree($holidayType == 1);
            Helpers_DB::saveDBObject($model, $sitePageData, 0);

            if($model->getIsFree()){
                $result['frees']++;
            }else{
                $result['holidays']++;
            }
        }

        // удаляем лишние
        $driver->deleteObjectIDs(
            $holidayIDs->getChildArrayID(), $sitePageData->userID, Model_Ab1_Holiday::TABLE_NAME, array(), 0
        );

        return $result;
    }

    /**
     * Получение списка выходных и праздничных дней за период
     * @param $dateFrom
     * @param $dateTo
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @param bool $isArray
     * @return array|MyArray
     */
    public static function getHolidays($dateFrom, $dateTo, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver,
                                       $isArray = false){

        if(!empty($dateFrom)){
            $dateFrom = Helpers_DateTime::getDateFormatPHP(Helpers_DateTime::minusDays($dateFrom, 10));
        }

        // праздничные и выходные дни
        $params = Request_RequestParams::setParams(
            array(
                'day_from_equally' => $dateFrom,
                'day_to' => Helpers_DateTime::getDateFormatPHP($dateTo),
                'sort_by' => array(
                    'day' => 'asc'
                )
            )
        );
        $holidayIDs = Request_Request::findNotShop(
            'DB_Ab1_Holiday', $sitePageData, $driver, $params, 0, TRUE
        );

        if(!$isArray) {
            $holidayIDs->runIndex(true, 'day');

            return $holidayIDs;
        }

        $result = [];
        foreach ($holidayIDs->childs as $child){
            $day = $child->values['day'];
            $result[$day] = $day;
        }

        return $result;
    }
}
