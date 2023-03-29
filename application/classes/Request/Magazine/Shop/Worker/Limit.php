<?php defined('SYSPATH') or die('No direct script access.');

class Request_Magazine_Shop_Worker_Limit extends Request_Request {
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
        // ищем по месяцам
        if($fieldWhere == 'month') {
            return true;
        }
        if($fieldWhere == 'year') {
            $year = Request_RequestParams::valParamInt($fieldValue);
            if ($year > 0){
                $month = Request_RequestParams::getParamInt('month', $params, $isNotReadRequest, $sitePageData);
                if (($month > 0) && ($month < 13)){
                    $sql->getRootWhere()->addField('date', '', $year.'-'.$month.'-01');
                }else{
                    $sql->getRootWhere()->addField(
                        'date', '', $year . '-01-01', '', Model_Driver_DBBasicWhere::COMPARE_TYPE_MORE_EQUALLY
                    );
                    $sql->getRootWhere()->addField(
                        'date', '', $year . '-12-01', '', Model_Driver_DBBasicWhere::COMPARE_TYPE_LESS_EQUALLY
                    );
                }
            }

            return true;
        }

        return parent::_addWhere($dbObject, $fieldWhere, $fieldValue, $params, $sql, $sitePageData, $driver, $isNotReadRequest, $groupBy, $elements);
    }
}
