<?php defined('SYSPATH') or die('No direct script access.');

class Request_Hotel_Shop_Bill extends Request_Request {
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
        if($fieldWhere == 'period_from') {
            $periodFrom = Request_RequestParams::valParamDateTime($fieldValue);
            $periodTo = Request_RequestParams::getParamDateTime('period_to', $params, $isNotReadRequest, $sitePageData);
            if(($periodFrom !== NULL) && ($periodTo !== NULL)){
                $tmp = $sql->getRootWhere()->addOR('period');

                $period = $tmp->addField('period_1');
                $period->addField('date_from', '', $periodFrom, '', Model_Driver_DBBasicWhere::COMPARE_TYPE_MORE_EQUALLY);
                $period->addField('date_from', '', $periodTo, '', Model_Driver_DBBasicWhere::COMPARE_TYPE_LESS_EQUALLY);

                $period = $tmp->addField('period_2');
                $period->addField('date_to', '', $periodFrom, '', Model_Driver_DBBasicWhere::COMPARE_TYPE_MORE_EQUALLY);
                $period->addField('date_to', '', $periodTo, '', Model_Driver_DBBasicWhere::COMPARE_TYPE_LESS_EQUALLY);

                $period = $tmp->addField('period_3');
                $period->addField('date_from', '', $periodFrom, '', Model_Driver_DBBasicWhere::COMPARE_TYPE_LESS_EQUALLY);
                $period->addField('date_to', '', $periodTo, '', Model_Driver_DBBasicWhere::COMPARE_TYPE_MORE_EQUALLY);
            }

            return true;
        }
        if($fieldWhere == 'period_to') {
            return true;
        }

        if($fieldWhere == 'search') {
            $search = Request_RequestParams::valParamStr($fieldValue);
            if(!empty($search)){
                $date = strtotime($search);
                if (!is_numeric($search) && $date !== FALSE){
                    $date = date('Y-m-d', $date);
                    $sql->getRootWhere()->addField('date_to', '', $date, '', Model_Driver_DBBasicWhere::COMPARE_TYPE_EQUALLY);
                }else {
                    $tmp = $sql->getRootWhere()->addField('search');
                    $tmp->relationsType = Model_Driver_DBBasicWhere::RELATIONS_TYPE_OR;

                    if ($search * 1 > 0) {
                        $tmp->addField('id', '', $search * 1, '', Model_Driver_DBBasicWhere::COMPARE_TYPE_EQUALLY);
                    }

                    $tableJoin = self::_addJoinTable(
                        $sql,
                        Model_Hotel_Shop_Bill::TABLE_NAME, 'shop_client_id',
                        Model_Hotel_Shop_Client::TABLE_NAME
                    );
                    $tmp->addField('name', $tableJoin, $search, '', Model_Driver_DBBasicWhere::COMPARE_TYPE_LIKE);
                    $tmp->addField('phone', $tableJoin, $search, '', Model_Driver_DBBasicWhere::COMPARE_TYPE_LIKE);
                }

                static::_addElementTableSQL(Model_Hotel_Shop_Bill::TABLE_NAME, 'shop_client_id', Model_Hotel_Shop_Client::TABLE_NAME, array('id'), $sql);
            }

            return true;
        }

        if($fieldWhere == 'amount_more_paid_amount') {
            $sql->getRootWhere()->addField(
                'amount', Model_Hotel_Shop_Bill::TABLE_NAME,
                'paid_amount', Model_Hotel_Shop_Bill::TABLE_NAME,
                Model_Driver_DBBasicWhere::COMPARE_TYPE_MORE
            );

            return true;
        }

        return parent::_addWhere($dbObject, $fieldWhere, $fieldValue, $params, $sql, $sitePageData, $driver, $isNotReadRequest, $groupBy, $elements);
    }
}
