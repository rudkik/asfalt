<?php defined('SYSPATH') or die('No direct script access.');

class Request_Ab1_Shop_Invoice extends Request_Request {
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
        // наличные
        if($fieldWhere == 'is_cash') {
            $isCash = Request_RequestParams::valParamBoolean($fieldValue);
            if($isCash !== NULL){
                if($isCash) {
                    $sql->getRootWhere()->addField('shop_client_attorney_id', Model_Ab1_Shop_Invoice::TABLE_NAME, 0);
                }else{
                    $sql->getRootWhere()->addField('shop_client_attorney_id', Model_Ab1_Shop_Invoice::TABLE_NAME, 0, '', Model_Driver_DBBasicWhere::COMPARE_TYPE_MORE);
                }
                return true;
            }
            return null;
        }

        return parent::_addWhere($dbObject, $fieldWhere, $fieldValue, $params, $sql, $sitePageData, $driver, $isNotReadRequest, $groupBy, $elements);
    }
}
