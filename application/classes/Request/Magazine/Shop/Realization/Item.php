<?php defined('SYSPATH') or die('No direct script access.');

class Request_Magazine_Shop_Realization_Item extends Request_Request {
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
        if($elementName == 'unit_id'){
            $table = static::_addElementTableSQL(
                Model_Magazine_Shop_Realization_Item::TABLE_NAME, 'shop_production_id',
                Model_Magazine_Shop_Production::TABLE_NAME, array('NAME'), $sql
            );

            static::_addElementTableSQL(
                $table, $elementName, Model_Magazine_Unit::TABLE_NAME, $elementFields, $sql
            );
            return true;
        }

        if($elementName == 'shop_product_unit_id'){
            $table = static::_addElementTableSQL(
                Model_Magazine_Shop_Realization_Item::TABLE_NAME, 'shop_production_id',
                Model_Magazine_Shop_Production::TABLE_NAME, array('NAME'), $sql
            );
            $table = static::_addElementTableSQL(
                $table, 'shop_product_id', Model_Magazine_Shop_Product::TABLE_NAME, array('NAME'), $sql
            );

            static::_addElementTableSQL(
                $table, $elementName, Model_Magazine_Unit::TABLE_NAME, $elementFields, $sql
            );
            return true;
        }

        if($elementName == 'shop_production_rubric_id'){
            $table = static::_addElementTableSQL(
                Model_Magazine_Shop_Realization_Item::TABLE_NAME, 'shop_production_id',
                Model_Magazine_Shop_Production::TABLE_NAME, array(), $sql
            );

            static::_addElementTableSQL(
                $table, $elementName, Model_Magazine_Shop_Production_Rubric::TABLE_NAME, $elementFields, $sql
            );
            return true;
        }

        if($elementName == 'shop_product_id'){
            $table = static::_addElementTableSQL(
                Model_Magazine_Shop_Realization_Item::TABLE_NAME, 'shop_production_id',
                Model_Magazine_Shop_Production::TABLE_NAME, array(), $sql
            );

            static::_addElementTableSQL(
                $table, $elementName, Model_Magazine_Shop_Product::TABLE_NAME, $elementFields, $sql
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

         // группировка в текущей таблице
        if($groupFields[0] == 'unit_id') {
            $table = static::_addElementTableSQL(
                Model_Magazine_Shop_Realization_Item::TABLE_NAME, 'shop_production_id',
                Model_Magazine_Shop_Production::TABLE_NAME, array(), $sql
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

            return true;
        }

        if($groupFields[0] == 'shop_production_rubric_id') {
            self::_addGroupTableSQL(
                'shop_production_rubric_id', $groupFields[1], 'sp_shop_production_rubrics__shop_production_rubric_id',
                Model_Magazine_Shop_Production_Rubric::TABLE_NAME, $sql, $sortBy, FALSE
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
        if($fieldWhere == 'shop_cashbox_id') {
            $shopCashboxID = $fieldValue;
            if ((is_array($shopCashboxID) || $shopCashboxID > -1) && !empty($shopCashboxID)) {
                $tableJoin = self::_addJoinTable(
                    $sql,
                    Model_Magazine_Shop_Realization_Item::TABLE_NAME, 'shop_realization_id',
                    Model_Magazine_Shop_Realization::TABLE_NAME
                );

                if (is_array($shopCashboxID)) {
                    $sql->getRootWhere()->addField('shop_cashbox_id', $tableJoin, $shopCashboxID, '', Model_Driver_DBBasicWhere::COMPARE_TYPE_IN);
                } else {
                    $sql->getRootWhere()->addField('shop_cashbox_id', $tableJoin, $shopCashboxID);
                }
            }
            return true;
        }

        if($fieldWhere == 'shop_product_id') {
            $shopProductID = $fieldValue;
            if((is_array($shopProductID) || $shopProductID > -1) && !empty($shopProductID)){
                $tableJoin = self::_addJoinTable(
                    $sql,
                    Model_Magazine_Shop_Realization_Item::TABLE_NAME, 'shop_production_id',
                    Model_Magazine_Shop_Production::TABLE_NAME
                );

                if(is_array($shopProductID)){
                    $sql->getRootWhere()->addField('shop_product_id', $tableJoin, $shopProductID, '', Model_Driver_DBBasicWhere::COMPARE_TYPE_IN);
                }else{
                    $sql->getRootWhere()->addField('shop_product_id', $tableJoin, $shopProductID);
                }
            }
            return true;
        }

        if($fieldWhere == 'shop_production_rubric_id') {
            $shopProductionRubricID = $fieldValue;
            if((is_array($shopProductionRubricID) || $shopProductionRubricID > -1) && !empty($shopProductionRubricID)){
                $tableJoin = self::_addJoinTable(
                    $sql,
                    Model_Magazine_Shop_Realization_Item::TABLE_NAME, 'shop_production_id',
                    Model_Magazine_Shop_Production::TABLE_NAME
                );

                if(is_array($shopProductionRubricID)){
                    $sql->getRootWhere()->addField('shop_production_rubric_id', $tableJoin, $shopProductionRubricID, '', Model_Driver_DBBasicWhere::COMPARE_TYPE_IN);
                }else{
                    $sql->getRootWhere()->addField('shop_production_rubric_id', $tableJoin, $shopProductionRubricID);
                }
            }
            return true;
        }

        return parent::_addWhere($dbObject, $fieldWhere, $fieldValue, $params, $sql, $sitePageData, $driver, $isNotReadRequest, $groupBy, $elements);
    }
}
