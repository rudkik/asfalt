<?php defined('SYSPATH') or die('No direct script access.');

class Request_Hotel_Shop_Bill_Item extends Request_Request {
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
        if($fieldWhere == 'search') {
            $search = Request_RequestParams::valParamStr($fieldValue);
            if(!empty($search)){
                $tmp = $sql->getRootWhere()->addOR('search');

                if($search * 1 > 0) {
                    $tmp->addField('shop_bill_id', '', $search * 1, '', Model_Driver_DBBasicWhere::COMPARE_TYPE_EQUALLY);
                }
                $tmp->addField('name', Model_Hotel_Shop_Client::TABLE_NAME, $search, '', Model_Driver_DBBasicWhere::COMPARE_TYPE_LIKE);
                $tmp->addField('name', Model_Hotel_Shop_Room::TABLE_NAME, $search, '', Model_Driver_DBBasicWhere::COMPARE_TYPE_LIKE);

                static::_addElementTableSQL(Model_Hotel_Shop_Bill_Item::TABLE_NAME, 'shop_client_id', Model_Hotel_Shop_Client::TABLE_NAME, array('id'), $sql);
                static::_addElementTableSQL(Model_Hotel_Shop_Bill_Item::TABLE_NAME, 'shop_room_id', Model_Hotel_Shop_Room::TABLE_NAME, array('id'), $sql);
            }

            return true;
        }

        if($fieldWhere == 'period_from') {
            $periodFrom = Request_RequestParams::valParamDateTime($fieldValue);
            $periodTo = Request_RequestParams::getParamDateTime('period_to', $params, $isNotReadRequest, $sitePageData);
            if(($periodFrom !== NULL) && ($periodTo !== NULL)){
                $tmp = $sql->getRootWhere()->addField('period');
                $tmp->relationsType = Model_Driver_DBBasicWhere::RELATIONS_TYPE_OR;

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

        return parent::_addWhere($dbObject, $fieldWhere, $fieldValue, $params, $sql, $sitePageData, $driver, $isNotReadRequest, $groupBy, $elements);
    }
}
