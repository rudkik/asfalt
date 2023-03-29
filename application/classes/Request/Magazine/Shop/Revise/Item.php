<?php defined('SYSPATH') or die('No direct script access.');

class Request_Magazine_Shop_Revise_Item extends Request_Request {
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
        if($elementName == 'shop_production_id') {
            $table = static::_addElementTableSQL(
                Model_Magazine_Shop_Revise_Item::TABLE_NAME, 'shop_product_id',
                Model_Magazine_Shop_Product::TABLE_NAME, array(), $sql);
            static::_addElementTableSQL(
                $table, 'id',
                Model_Magazine_Shop_Production::TABLE_NAME, $elementFields, $sql, -1, -1,
                'shop_product_id', 'shop_production_id'
            );
            return true;
        }

        if($elementName == 'unit_id') {
            $table = static::_addElementTableSQL(
                Model_Magazine_Shop_Revise_Item::TABLE_NAME, 'shop_product_id',
                Model_Magazine_Shop_Product::TABLE_NAME, array(), $sql);
            static::_addElementTableSQL(
                $table, 'unit_id',
                Model_Magazine_Unit::TABLE_NAME, $elementFields, $sql, -1, -1,
                'id', 'unit_id'
            );
            return true;
        }

        return parent::_addFromSQL($dbObject, $elementName, $elementFields, $sql, $params);
    }

    /**
     * Добавляем сортировку
     * @param $dbObject
     * @param $sortByName
     * @param $isASC
     * @param Model_Driver_DBBasicSQL $sql
     * @return bool
     */
    protected static function _addSortBy($dbObject, $sortByName, $isASC, Model_Driver_DBBasicSQL $sql)
    {
        if($sortByName == 'quantity_diff') {
            $sql->getrootSort()->addField(
                $dbObject::TABLE_NAME,
                '(' . Model_Magazine_Shop_Revise_Item::TABLE_NAME . '.quantity - '
                    . Model_Magazine_Shop_Revise_Item::TABLE_NAME . '.quantity_actual)',
                $isASC, FALSE
            );
        }

        return parent::_addSortBy($dbObject, $sortByName, $isASC, $sql);
    }
}
