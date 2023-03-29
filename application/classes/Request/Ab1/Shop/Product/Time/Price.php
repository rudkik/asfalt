<?php defined('SYSPATH') or die('No direct script access.');

class Request_Ab1_Shop_Product_Time_Price extends Request_Request {
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
        if($elementName == 'shop_product_pricelist_rubric_id') {
            $table = static::_addElementTableSQL(
                Model_Ab1_Shop_Product_Time_Price::TABLE_NAME, 'shop_product_id',
                Model_Ab1_Shop_Product::TABLE_NAME, array(), $sql
            );

            static::_addElementTableSQL(
                $table, 'shop_product_pricelist_rubric_id',
                Model_Ab1_Shop_Product_Pricelist_Rubric::TABLE_NAME, $elementFields, $sql, -1, -1,
                'id', 'shop_product_pricelist_rubric_id'
            );

            return true;
        }
        return parent::_addFromSQL($dbObject, $elementName, $elementFields, $sql, $params);
    }
}
