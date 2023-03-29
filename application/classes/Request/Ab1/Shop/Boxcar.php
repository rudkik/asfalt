<?php defined('SYSPATH') or die('No direct script access.');

class Request_Ab1_Shop_Boxcar extends Request_Request {
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
     * Добавляем базовые запросы SELECT SQL
     * @param $dbObject
     * @param $fieldWhere
     * @param $fieldValue
     * @param array $params
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
        // если вагон не пришел
        if($fieldWhere == 'is_date_arrival_empty') {
            $date = Request_RequestParams::valParamBoolean($fieldValue);
            if ($date === TRUE) {
                $sql->getRootWhere()->addField('date_arrival', Model_Ab1_Shop_Boxcar::TABLE_NAME, 0, '', Model_Driver_DBBasicWhere::COMPARE_TYPE_ISNULL);
            } elseif ($date === FALSE) {
                $sql->getRootWhere()->addField('date_arrival', Model_Ab1_Shop_Boxcar::TABLE_NAME, 0, '', Model_Driver_DBBasicWhere::COMPARE_TYPE_ISNULL)->isNot = TRUE;
            }
            return true;
        }

        // если вагон не убыл
        if($fieldWhere == 'is_date_departure_empty') {
            $date = Request_RequestParams::valParamBoolean($fieldValue);
            if($date === TRUE){
                $sql->getRootWhere()->addField('date_departure', Model_Ab1_Shop_Boxcar::TABLE_NAME, 0, '', Model_Driver_DBBasicWhere::COMPARE_TYPE_ISNULL);
            }elseif($date === FALSE){
                $sql->getRootWhere()->addField('date_departure', Model_Ab1_Shop_Boxcar::TABLE_NAME, 0, '', Model_Driver_DBBasicWhere::COMPARE_TYPE_ISNULL)->isNot = TRUE;
            }
            return true;
        }

        // если вагон не разгрузился
        if($fieldWhere == 'is_date_drain_to_empty') {
            $date = Request_RequestParams::valParamBoolean($fieldValue);
            if($date === TRUE){
                $sql->getRootWhere()->addField('date_drain_to', Model_Ab1_Shop_Boxcar::TABLE_NAME, 0, '', Model_Driver_DBBasicWhere::COMPARE_TYPE_ISNULL);
            }elseif($date === FALSE){
                $sql->getRootWhere()->addField('date_drain_to', Model_Ab1_Shop_Boxcar::TABLE_NAME, 0, '', Model_Driver_DBBasicWhere::COMPARE_TYPE_ISNULL)->isNot = TRUE;
            }
            return true;
        }

        // если вагон начал слив
        if($fieldWhere == 'is_date_drain_from_empty') {
            $date = Request_RequestParams::valParamBoolean($fieldValue);
            if($date === TRUE){
                $sql->getRootWhere()->addField('date_drain_from', Model_Ab1_Shop_Boxcar::TABLE_NAME, 0, '', Model_Driver_DBBasicWhere::COMPARE_TYPE_ISNULL);
            }elseif($date === FALSE){
                $sql->getRootWhere()->addField('date_drain_from', Model_Ab1_Shop_Boxcar::TABLE_NAME, 0, '', Model_Driver_DBBasicWhere::COMPARE_TYPE_ISNULL)->isNot = TRUE;
            }

            return true;
        }

        return parent::_addWhere($dbObject, $fieldWhere, $fieldValue, $params, $sql, $sitePageData, $driver, $isNotReadRequest, $groupBy, $elements);
    }
}
