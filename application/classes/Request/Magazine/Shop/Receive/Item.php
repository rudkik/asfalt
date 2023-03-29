<?php defined('SYSPATH') or die('No direct script access.');

class Request_Magazine_Shop_Receive_Item extends Request_Request {
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
        if($elementName == 'unit_id') {
            $table = static::_addElementTableSQL(
                Model_Magazine_Shop_Receive_Item::TABLE_NAME, 'shop_product_id',
                Model_Magazine_Shop_Product::TABLE_NAME, array(), $sql
            );
            static::_addElementTableSQL(
                $table, 'unit_id',
                Model_Magazine_Unit::TABLE_NAME, $elementFields, $sql, -1, -1,
                'id', 'unit_id'
            );
            return true;
        }

        if($elementName == 'shop_production_id') {
            $table = static::_addElementTableSQL(
                Model_Magazine_Shop_Receive_Item::TABLE_NAME, 'shop_product_id',
                Model_Magazine_Shop_Product::TABLE_NAME, array(), $sql
            );
            static::_addElementTableSQL(
                $table, 'id',
                Model_Magazine_Shop_Production::TABLE_NAME, $elementFields, $sql, -1, -1,
                'shop_product_id', 'shop_production_id'
            );

            return true;
        }

        return parent::_addFromSQL($dbObject, $elementName, $elementFields, $sql, $params);
    }

    /**
     * Добавляем группировка
     * @param $dbObject
     * @param $groupByName
     * @param Model_Driver_DBBasicSQL $sql
     * @param null $sortBy
     * @return bool
     */
    protected static function _addGroupBy($dbObject, $groupByName, Model_Driver_DBBasicSQL $sql, $sortBy = NULL)
    {
        $groupFields = explode('.', $groupByName);
        if($groupFields[0] == 'unit_id') {
            $table = static::_addElementTableSQL(
                Model_Magazine_Shop_Receive_Item::TABLE_NAME, 'shop_product_id',
                Model_Magazine_Shop_Product::TABLE_NAME, array(), $sql
            );
            $table = static::_addElementTableSQL(
                $table, 'unit_id',
                Model_Magazine_Unit::TABLE_NAME, array(), $sql, -1, -1,
                'id', 'unit_id'
            );
            self::_addGroupTableSQL(
                $groupFields[0], $groupFields[1], $table, Model_Magazine_Unit::TABLE_NAME,
                $sql, $sortBy
            );
        }

        return parent::_addGroupBy($dbObject, $groupByName, $sql, $sortBy);
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
        if($fieldWhere == 'quantity_receive_more_invoice') {
            if (Request_RequestParams::valParamBoolean($fieldValue) === TRUE) {
                $sql->getRootWhere()->addField(
                    Model_Magazine_Shop_Receive_Item::TABLE_NAME.'.quantity - '
                        . Model_Magazine_Shop_Receive_Item::TABLE_NAME.'.quantity_invoice',
                    '', '0', '', Model_Driver_DBBasicWhere::COMPARE_TYPE_MORE
                )->isFieldTable1 = FALSE;
            }

            return true;
        }

        return parent::_addWhere($dbObject, $fieldWhere, $fieldValue, $params, $sql, $sitePageData, $driver, $isNotReadRequest, $groupBy, $elements);
    }
}
