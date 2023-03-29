<?php defined('SYSPATH') or die('No direct script access.');

class Request_Magazine_Shop_Invoice_Item extends Request_Request {
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
     * Добавляем соединения таблиц
     * @param $dbObject
     * @param $elementName
     * @param array $elementFields
     * @param Model_Driver_DBBasicSQL $sql
     * @return bool
     */
    protected static function _addFromSQL($dbObject, $elementName, array $elementFields, Model_Driver_DBBasicSQL $sql, array $params){
        if($elementName == 'shop_product_unit_id') {
            $table = static::_addElementTableSQL(
                Model_Magazine_Shop_Invoice_Item::TABLE_NAME, 'shop_product_id',
                Model_Magazine_Shop_Product::TABLE_NAME, array(), $sql
            );
            static::_addElementTableSQL(
                $table, 'unit_id',
                Model_Magazine_Unit::TABLE_NAME, $elementFields, $sql, -1, -1,
                'id', 'shop_product_unit_id', true
            );
            return true;
        }

        if($elementName == 'shop_production_unit_id') {
            $table = static::_addElementTableSQL(
                Model_Magazine_Shop_Invoice_Item::TABLE_NAME, 'shop_production_id',
                Model_Magazine_Shop_Production::TABLE_NAME, array(), $sql
            );
            static::_addElementTableSQL(
                $table, 'unit_id',
                Model_Magazine_Unit::TABLE_NAME, $elementFields, $sql, -1, -1,
                'id', 'shop_production_unit_id', true
            );

            return true;
        }
        return parent::_addFromSQL($dbObject, $elementName, $elementFields, $sql, $params);
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
        if($fieldWhere == 'date_from') {
            $date = Request_RequestParams::valParamDateTime($fieldValue);
            if ($date !== NULL) {
                $tableJoin = self::_addJoinTable(
                    $sql,
                    Model_Magazine_Shop_Invoice_Item::TABLE_NAME, 'shop_invoice_id',
                    Model_Magazine_Shop_Invoice::TABLE_NAME
                );

                $sql->getRootWhere()->addField(
                    'date', $tableJoin, $date, '', Model_Driver_DBBasicWhere::COMPARE_TYPE_MORE_EQUALLY
                );
            }
            return true;
        }

        if($fieldWhere == 'date_to') {
            $date = Request_RequestParams::valParamDateTime($fieldValue);
            if($date !== NULL){
                $tableJoin = self::_addJoinTable(
                    $sql,
                    Model_Magazine_Shop_Invoice_Item::TABLE_NAME, 'shop_invoice_id',
                    Model_Magazine_Shop_Invoice::TABLE_NAME
                );

                $sql->getRootWhere()->addField(
                    'date', $tableJoin, $date, '', Model_Driver_DBBasicWhere::COMPARE_TYPE_LESS_EQUALLY
                );
            }

            return true;
        }

        return parent::_addWhere($dbObject, $fieldWhere, $fieldValue, $params, $sql, $sitePageData, $driver, $isNotReadRequest, $groupBy, $elements);
    }
}
