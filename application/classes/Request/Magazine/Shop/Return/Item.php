<?php defined('SYSPATH') or die('No direct script access.');

class Request_Magazine_Shop_Return_Item extends Request_Request {
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
            $table = static::_addElementTableSQL(Model_Magazine_Shop_Return_Item::TABLE_NAME,
                'shop_product_id', Model_Magazine_Shop_Product::TABLE_NAME, array('NAME'), $sql);

            static::_addElementTableSQL($table, $elementName, Model_Magazine_Unit::TABLE_NAME, $elementFields, $sql);

            return true;
        }
        return parent::_addFromSQL($dbObject, $elementName, $elementFields, $sql, $params);
    }
}
