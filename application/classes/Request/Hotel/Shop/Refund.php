<?php defined('SYSPATH') or die('No direct script access.');

class Request_Hotel_Shop_Refund extends Request_Request {
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

                $tmp->addField(
                    'number', Model_Hotel_Shop_Refund::TABLE_NAME,
                    $search, '', Model_Driver_DBBasicWhere::COMPARE_TYPE_EQUALLY
                );

                $tmp->addField(
                    'name', Model_Hotel_Shop_Client::TABLE_NAME,
                    $search, '', Model_Driver_DBBasicWhere::COMPARE_TYPE_LIKE
                );
                static::_addElementTableSQL(
                    Model_Hotel_Shop_Refund::TABLE_NAME, 'shop_client_id',
                    Model_Hotel_Shop_Client::TABLE_NAME, array('id'), $sql
                );
            }
            return true;
        }

        return parent::_addWhere($dbObject, $fieldWhere, $fieldValue, $params, $sql, $sitePageData, $driver, $isNotReadRequest, $groupBy, $elements);
    }
}
