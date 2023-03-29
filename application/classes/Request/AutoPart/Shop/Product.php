<?php defined('SYSPATH') or die('No direct script access.');

class Request_AutoPart_Shop_Product extends Request_Request {
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
        if($elementName == 'shop_rubric_source_id') {
            $table = static::_addElementTableSQL(
                Model_AutoPart_Shop_Product::TABLE_NAME, 'id',
                Model_AutoPart_Shop_Product_Source::TABLE_NAME, array(), $sql, -1, -1,
                'shop_product_id', '', FALSE, Model_Driver_DBBasicFrom::JOIN_LEFT,
                Model_AutoPart_Shop_Product_Source::TABLE_NAME . '__id.is_delete = 0 AND '
                    . Model_AutoPart_Shop_Product_Source::TABLE_NAME . '__id.shop_source_id = '
                    . intval(Request_RequestParams::getParamInt('shop_source_id', $params))
            );

            static::_addElementTableSQL(
                $table, 'shop_rubric_source_id',
                Model_AutoPart_Shop_Rubric_Source::TABLE_NAME, $elementFields, $sql, -1, -1,
                'id', 'shop_rubric_source_id'
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
        if($sortByName == 'price_minus_price_cost') {
            $sql->getrootSort()->addField('', '('.$dbObject::TABLE_NAME.'.price - '.$dbObject::TABLE_NAME.'.price_cost)', $isASC, false);

            return true;
        }

        return parent::_addSortBy($dbObject, $sortByName, $isASC, $sql);
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

        if($fieldWhere == 'is_root_child') {
            $isEmpty = Request_RequestParams::valParamBoolean($fieldValue);
            if ($isEmpty !== null) {
                $field = $sql->getRootWhere()->addOR('id_or_root_shop_product_id');
                $field->isNot = !$isEmpty;
                $field->addField(
                    'child_product_count', Model_AutoPart_Shop_Product::TABLE_NAME, 0,
                    '', Model_Driver_DBBasicWhere::COMPARE_TYPE_MORE
                );
                $field->addField(
                    'root_shop_product_id', Model_AutoPart_Shop_Product::TABLE_NAME, 0,
                    '', Model_Driver_DBBasicWhere::COMPARE_TYPE_MORE
                );

                return true;
            }
            return null;
        }

        if($fieldWhere == 'id_or_root_shop_product_id') {
            $fieldValue = Request_RequestParams::valParamInt($fieldValue);
            if ($fieldValue > -1) {
                $field = $sql->getRootWhere()->addOR('id_or_root_shop_product_id');
                $field->addField('id', Model_AutoPart_Shop_Product::TABLE_NAME, $fieldValue);
                $field->addField('root_shop_product_id', Model_AutoPart_Shop_Product::TABLE_NAME, $fieldValue);
                return true;
            }
            return null;
        }

        if($fieldWhere == 'shop_source_id_empty') {
            $isEmpty = Request_RequestParams::valParamBoolean($fieldValue);
            if ($isEmpty !== false) {
                $shopSourceID = Request_RequestParams::getParamInt('shop_source_id');

                $sqlText = '';
                if($shopSourceID > 0){
                    $sqlText = 'shop_source_id = ' . $shopSourceID;
                }

                $tableJoin = self::_addJoinTable(
                    $sql,
                    Model_AutoPart_Shop_Product::TABLE_NAME, 'id',
                    Model_AutoPart_Shop_Product_Source::TABLE_NAME, 'shop_product_id',
                    -1, -1, $sqlText
                );

                $sql->getRootWhere()->addFieldIsNULL('shop_product_id', $tableJoin);
                return true;
            }
            return null;
        }

        return parent::_addWhere($dbObject, $fieldWhere, $fieldValue, $params, $sql, $sitePageData, $driver, $isNotReadRequest, $groupBy, $elements);
    }
}
