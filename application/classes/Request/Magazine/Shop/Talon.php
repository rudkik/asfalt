<?php defined('SYSPATH') or die('No direct script access.');

class Request_Magazine_Shop_Talon extends Request_Request {
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
                    $sql->getRootWhere()->addField('date', '', $year . '-' . $year . '-01-01', '',
                        Model_Driver_DBBasicWhere::COMPARE_TYPE_MORE_EQUALLY);
                    $sql->getRootWhere()->addField('date', '', $year . '-' . $year . '-12-31', '',
                        Model_Driver_DBBasicWhere::COMPARE_TYPE_LESS_EQUALLY);
                }
            }
            return true;
        }

        //  дата срока действия
        if($fieldWhere == 'validity') {
            $validity = Request_RequestParams::valParamDateTime($fieldValue);
            if ($validity !== null){
                $sql->getRootWhere()->addField('validity_from', '', $validity, '', Model_Driver_DBBasicWhere::COMPARE_TYPE_LESS_EQUALLY);
                $sql->getRootWhere()->addField('validity_to', '', $validity, '', Model_Driver_DBBasicWhere::COMPARE_TYPE_MORE_EQUALLY);
            }
            return true;
        }

        if($fieldWhere == 'period_to') {
            return true;
        }
        if($fieldWhere == 'period_from') {
            $periodFrom = Request_RequestParams::valParamDateTime($fieldValue);
            $periodTo = Request_RequestParams::getParamDateTime('period_to', $params, $isNotReadRequest, $sitePageData);
            if(($periodFrom !== NULL) && ($periodTo !== NULL)){
                $tmp = $sql->getRootWhere()->addField('period');
                $tmp->relationsType = Model_Driver_DBBasicWhere::RELATIONS_TYPE_OR;

                $period = $tmp->addField('period_1');
                $period->addField('validity_from', '', $periodFrom, '', Model_Driver_DBBasicWhere::COMPARE_TYPE_MORE_EQUALLY);
                $period->addField('validity_from', '', $periodTo, '', Model_Driver_DBBasicWhere::COMPARE_TYPE_LESS_EQUALLY);

                $period = $tmp->addField('period_2');
                $period->addField('validity_to', '', $periodFrom, '', Model_Driver_DBBasicWhere::COMPARE_TYPE_MORE_EQUALLY);
                $period->addField('validity_to', '', $periodTo, '', Model_Driver_DBBasicWhere::COMPARE_TYPE_LESS_EQUALLY);

                $period = $tmp->addField('period_3');
                $period->addField('validity_from', '', $periodFrom, '', Model_Driver_DBBasicWhere::COMPARE_TYPE_LESS_EQUALLY);
                $period->addField('validity_to', '', $periodTo, '', Model_Driver_DBBasicWhere::COMPARE_TYPE_MORE_EQUALLY);
            }elseif ($periodFrom !== NULL){
                $sql->getRootWhere()->addField('period')->addField(
                    'validity_from', '', $periodFrom, '', Model_Driver_DBBasicWhere::COMPARE_TYPE_MORE_EQUALLY
                );
            }elseif ($periodTo !== NULL){
                $sql->getRootWhere()->addField('period')->addField(
                    'validity_to', '', $periodTo, '', Model_Driver_DBBasicWhere::COMPARE_TYPE_LESS_EQUALLY
                );
            }
            return true;
        }

        if($fieldWhere == 'date') {
            $date = Request_RequestParams::valParamDateTime($fieldValue);
            if($date !== NULL){
                $date = Helpers_DateTime::changeDateDay($date, 1);

                $sql->getRootWhere()->addField('date', Model_Magazine_Shop_Talon::TABLE_NAME, $date, '', Model_Driver_DBBasicWhere::COMPARE_TYPE_EQUALLY);
            }

            return true;
        }

        return parent::_addWhere($dbObject, $fieldWhere, $fieldValue, $params, $sql, $sitePageData, $driver, $isNotReadRequest, $groupBy, $elements);
    }
}
