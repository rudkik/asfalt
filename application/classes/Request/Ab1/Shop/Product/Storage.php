<?php defined('SYSPATH') or die('No direct script access.');

class Request_Ab1_Shop_Product_Storage extends Request_Request {
    /**
     * Проверяем есть ли объект Request_...
     * @param $dbObject
     * @return bool|string
     */
    protected static function getRequest($dbObject)
    {
        return false;
    }

    /**
     * Добавляем группировка
     * @param $dbObject
     * @param $groupByName
     * @param Model_Driver_DBBasicSQL $sql
     * @param null $sortBy
     * @return bool
     */
    protected static function _addGroupBy($dbObject, $groupByName, Model_Driver_DBBasicSQL $sql, $sortBy = NULL)
    {

        if($groupByName == 'exit_at_day_6_hour') {
            $sql->getRootGroupBy()->addField(' ', 'exit_at_day');
            $sql->getRootSelect()->addFunctionField(
                '',
                'CASE WHEN date('.Model_Ab1_Shop_Product_Storage::TABLE_NAME.'.weighted_at) + interval \'6 hour\' > '.Model_Ab1_Shop_Product_Storage::TABLE_NAME.'.weighted_at THEN '.Model_Ab1_Shop_Product_Storage::TABLE_NAME.'.weighted_at - interval \'1 day\''
                . ' ELSE ' . Model_Ab1_Shop_Product_Storage::TABLE_NAME.'.weighted_at END',
                'date', 'exit_at_day'
            );

            return true;
        }
        
        if($groupByName == 'weighted_at_day_6_hour') {
            $sql->getRootGroupBy()->addField(' ', 'weighted_at_day');
            $sql->getRootSelect()->addFunctionField(
                '',
                'CASE WHEN date('.Model_Ab1_Shop_Product_Storage::TABLE_NAME.'.weighted_at) + interval \'6 hour\' > '.Model_Ab1_Shop_Product_Storage::TABLE_NAME.'.weighted_at THEN '.Model_Ab1_Shop_Product_Storage::TABLE_NAME.'.weighted_at - interval \'1 day\''
                . ' ELSE ' . Model_Ab1_Shop_Product_Storage::TABLE_NAME.'.weighted_at END',
                'date', 'weighted_at_day'
            );

            return true;
        }

        return parent::_addGroupBy($dbObject, $groupByName, $sql, $sortBy);
    }

    /**
     * Добавляем базовые запросы SELECT SQL
     * @param $dbObject
     * @param $fieldWhere
     * @param array $params
     * @param $fieldValue
     * @param Model_Driver_DBBasicSQL $sql
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @param $isNotReadRequest
     * @param array $groupBy
     * @param array $elements
     * @return bool
     */
    protected static function _addWhere($dbObject, $fieldWhere, $fieldValue, array $params, Model_Driver_DBBasicSQL $sql,
                                        SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver,
                                        $isNotReadRequest, array &$groupBy, array &$elements){       
        if($fieldWhere == 'exit_at_day_6_hour') {
            $days = Request_RequestParams::valParamArray($fieldValue);
            if(!empty($days)){
                $tmp = $sql->getRootWhere()->addOR('exit_at_day_6_hour');
                foreach ($days as $day){
                    $tmp->addField(
                        'date(CASE WHEN date(' . Model_Ab1_Shop_Product_Storage::TABLE_NAME . '.weighted_at) + interval \'6 hour\' > '
                        . Model_Ab1_Shop_Product_Storage::TABLE_NAME . '.weighted_at THEN ' . Model_Ab1_Shop_Product_Storage::TABLE_NAME . '.weighted_at - interval \'1 day\''
                        . ' ELSE ' . Model_Ab1_Shop_Product_Storage::TABLE_NAME . '.weighted_at END)',
                        '', $day
                    )->isFuncField1 = true;
                }
            }else{
                $days = Request_RequestParams::valParamDateTime($fieldValue);
                if($days != null) {
                    $sql->getRootWhere()->addField(
                        'date(CASE WHEN date(' . Model_Ab1_Shop_Product_Storage::TABLE_NAME . '.weighted_at) + interval \'6 hour\' > '
                        . Model_Ab1_Shop_Product_Storage::TABLE_NAME . '.weighted_at THEN ' . Model_Ab1_Shop_Product_Storage::TABLE_NAME . '.weighted_at - interval \'1 day\''
                        . ' ELSE ' . Model_Ab1_Shop_Product_Storage::TABLE_NAME . '.weighted_at END)',
                        '', $days
                    )->isFuncField1 = true;
                }
            }

            return true;
        }

        if($fieldWhere == 'is_night_22_to_6_hour') {
            $isNight = Request_RequestParams::valParamBoolean($fieldValue);
            if($isNight === true){
                $tmp = $sql->getRootWhere()->addOR('is_night_22_to_6_hour');
                $tmp->addField(
                    Model_Ab1_Shop_Product_Storage::TABLE_NAME . '.weighted_at::time',
                    '', '22:00:00', '', Model_Driver_DBBasicWhere::COMPARE_TYPE_MORE_EQUALLY
                )->isFuncField1 = true;
                $tmp->addField(
                    Model_Ab1_Shop_Product_Storage::TABLE_NAME . '.weighted_at::time',
                    '', '06:00:00', '', Model_Driver_DBBasicWhere::COMPARE_TYPE_LESS
                )->isFuncField1 = true;
                return true;
            }elseif($isNight === false){
                $tmp = $sql->getRootWhere()->addField('is_night_22_to_6_hour');
                $tmp->addField(
                    Model_Ab1_Shop_Product_Storage::TABLE_NAME . '.weighted_at::time',
                    '', '22:00:00', '', Model_Driver_DBBasicWhere::COMPARE_TYPE_LESS
                )->isFuncField1 = true;
                $tmp->addField(
                    Model_Ab1_Shop_Product_Storage::TABLE_NAME . '.weighted_at::time',
                    '', '06:00:00', '', Model_Driver_DBBasicWhere::COMPARE_TYPE_MORE_EQUALLY
                )->isFuncField1 = true;
                return true;
            }

            return null;
        }

        return parent::_addWhere($dbObject, $fieldWhere, $fieldValue, $params, $sql, $sitePageData, $driver, $isNotReadRequest, $groupBy, $elements);
    }
}
