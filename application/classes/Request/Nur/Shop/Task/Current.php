<?php defined('SYSPATH') or die('No direct script access.');

class Request_Nur_Shop_Task_Current extends Request_Request {
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
        if($fieldWhere == 'period_to') {
            return true;
        }
        if($fieldWhere == 'period_from') {
            $periodFrom = Request_RequestParams::valParamDateTime($fieldValue);
            $periodTo = Request_RequestParams::getParamDateTime('period_to', $params, $isNotReadRequest, $sitePageData);
            if (($periodFrom !== NULL) && ($periodTo !== NULL)) {
                $tmp = $sql->getRootWhere()->addField('period');
                $tmp->relationsType = Model_Driver_DBBasicWhere::RELATIONS_TYPE_OR;

                $period = $tmp->addField('period_1');
                $period->addField('date_start', '', $periodFrom, '', Model_Driver_DBBasicWhere::COMPARE_TYPE_MORE_EQUALLY);
                $period->addField('date_start', '', $periodTo, '', Model_Driver_DBBasicWhere::COMPARE_TYPE_LESS_EQUALLY);

                $period = $tmp->addField('period_2');
                $period->addField('date_finish', '', $periodFrom, '', Model_Driver_DBBasicWhere::COMPARE_TYPE_MORE_EQUALLY);
                $period->addField('date_finish', '', $periodTo, '', Model_Driver_DBBasicWhere::COMPARE_TYPE_LESS_EQUALLY);

                $period = $tmp->addField('period_3');
                $period->addField('date_start', '', $periodFrom, '', Model_Driver_DBBasicWhere::COMPARE_TYPE_LESS_EQUALLY);
                $period->addField('date_finish', '', $periodTo, '', Model_Driver_DBBasicWhere::COMPARE_TYPE_MORE_EQUALLY);
            }

            return true;
        }

        if($fieldWhere == 'period_basic_to') {
            return true;
        }
        if($fieldWhere == 'period_basic_from') {
            $periodFrom = Request_RequestParams::valParamDateTime($fieldValue);
            $periodTo = Request_RequestParams::getParamDateTime('period_basic_to', $params, $isNotReadRequest, $sitePageData);
            if(($periodFrom !== NULL) && ($periodTo !== NULL)){
                $tmp = $sql->getRootWhere()->addField('period_basic');
                $tmp->relationsType = Model_Driver_DBBasicWhere::RELATIONS_TYPE_OR;

                $period = $tmp->addField('period_1');
                $period->addField('date_from', '', $periodFrom, '', Model_Driver_DBBasicWhere::COMPARE_TYPE_MORE_EQUALLY);
                $period->addField('date_from', '', $periodTo, '', Model_Driver_DBBasicWhere::COMPARE_TYPE_LESS_EQUALLY);

                $period = $tmp->addField('period_2');
                $period->addField('date_to', '', $periodFrom, '', Model_Driver_DBBasicWhere::COMPARE_TYPE_MORE_EQUALLY);
                $period->addField('date_to', '', $periodTo, '', Model_Driver_DBBasicWhere::COMPARE_TYPE_LESS_EQUALLY);

                $period = $tmp->addField('period_3');
                $period->addField('date_from', '', $periodFrom, '', Model_Driver_DBBasicWhere::COMPARE_TYPE_MORE_EQUALLY);
                $period->addField('date_to', '', $periodTo, '', Model_Driver_DBBasicWhere::COMPARE_TYPE_LESS_EQUALLY);

                $period = $tmp->addField('period_4');
                $period->addField('date_from', '', $periodFrom, '', Model_Driver_DBBasicWhere::COMPARE_TYPE_LESS_EQUALLY);
                $period->addField('date_to', '', $periodTo, '', Model_Driver_DBBasicWhere::COMPARE_TYPE_MORE_EQUALLY);
            }

            return true;
        }

        if($fieldWhere == 'is_empty_date_finish') {
            $isEmptyDateFinish = Request_RequestParams::valParamBoolean($fieldValue);
            if ($isEmptyDateFinish === TRUE) {
                $sql->getRootWhere()->addField(
                    'date_finish', Model_Nur_Shop_Task_Current::TABLE_NAME, NULL, '', Model_Driver_DBBasicWhere::COMPARE_TYPE_ISNULL
                );
            }elseif ($isEmptyDateFinish === FALSE) {
                $sql->getRootWhere()->addField(
                    'date_finish', Model_Nur_Shop_Task_Current::TABLE_NAME, NULL, '', Model_Driver_DBBasicWhere::COMPARE_TYPE_ISNULL
                )->isNot = TRUE;
            }

            return true;
        }

        return parent::_addWhere($dbObject, $fieldWhere, $fieldValue, $params, $sql, $sitePageData, $driver, $isNotReadRequest, $groupBy, $elements);
    }
}
