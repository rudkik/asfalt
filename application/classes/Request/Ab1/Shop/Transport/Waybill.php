<?php defined('SYSPATH') or die('No direct script access.');

class Request_Ab1_Shop_Transport_Waybill extends Request_Request {
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
        // фильтер филиалам отправления или получения
        if($fieldWhere == 'car_date') {
            $date = Request_RequestParams::valParamDateTime($fieldValue);
            if ($date !== NULL) {
                $sql->getRootWhere()->addField(
                    'from_at', Model_Ab1_Shop_Transport_Waybill::TABLE_NAME, $date, '',
                    Model_Driver_DBBasicWhere::COMPARE_TYPE_LESS_EQUALLY
                );

                $tmp = $sql->getRootWhere()->addOR('car_date');
                $tmp->addField(
                    'to_at', Model_Ab1_Shop_Transport_Waybill::TABLE_NAME, $date, '',
                    Model_Driver_DBBasicWhere::COMPARE_TYPE_MORE_EQUALLY
                );
                $tmp->addFieldIsNULL('to_at', Model_Ab1_Shop_Transport_Waybill::TABLE_NAME);
                return true;
            }
            return null;
        }

        return parent::_addWhere($dbObject, $fieldWhere, $fieldValue, $params, $sql, $sitePageData, $driver, $isNotReadRequest, $groupBy, $elements);
    }
}
