<?php defined('SYSPATH') or die('No direct script access.');

class Request_Ab1_Shop_Lessee_Car extends Request_Request {
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
        if($elementName == 'root_rubric_id') {
            $table = static::_addElementTableSQL(
                Model_Ab1_Shop_Lessee_Car::TABLE_NAME, 'shop_product_id',
                Model_Ab1_Shop_Product::TABLE_NAME, array(), $sql
            );

            $table = static::_addElementTableSQL(
                $table, 'shop_product_rubric_id',
                Model_Ab1_Shop_Product_Rubric::TABLE_NAME, array(), $sql, -1, -1,
                'id', 'shop_product_rubric_id'
            );

            static::_addElementTableSQL(
                $table, 'root_id',
                Model_Ab1_Shop_Product_Rubric::TABLE_NAME, $elementFields, $sql, -1, -1,
                'id', 'root_rubric_id'
            );
            return true;
        }

        if($elementName == 'shop_product_rubric_id') {
            $table = static::_addElementTableSQL(
                Model_Ab1_Shop_Lessee_Car::TABLE_NAME, 'shop_product_id',
                Model_Ab1_Shop_Product::TABLE_NAME, array(), $sql
            );

            static::_addElementTableSQL(
                $table, 'shop_product_rubric_id',
                Model_Ab1_Shop_Product_Rubric::TABLE_NAME, $elementFields, $sql, -1, -1,
                'id', 'shop_product_rubric_id'
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
        if($fieldWhere == 'exit_at_from_or_not_exit') {
            $exitAt = Request_RequestParams::valParamDateTime($fieldValue);
            if ($exitAt !== NULL) {
                $tmp = $sql->getRootWhere()->addField('exit_at_from_or_not_exit');
                $tmp->relationsType = Model_Driver_DBBasicWhere::RELATIONS_TYPE_OR;
                $tmp->addField('exit_at', Model_Ab1_Shop_Lessee_Car::TABLE_NAME, $exitAt, '', Model_Driver_DBBasicWhere::COMPARE_TYPE_MORE);
                $tmp = $tmp->addField('is_exit');
                $tmp->addField('is_exit', Model_Ab1_Shop_Lessee_Car::TABLE_NAME, 0);
                $tmp->addField('created_at', Model_Ab1_Shop_Lessee_Car::TABLE_NAME, $exitAt, '', Model_Driver_DBBasicWhere::COMPARE_TYPE_MORE);
                return true;
            }
            return null;
        }

        if($fieldWhere == 'exit_at_to_or_not_exit') {
            $exitAt = Request_RequestParams::valParamDateTime($fieldValue);
            if($exitAt !== NULL){
                $tmp = $sql->getRootWhere()->addField('exit_at_to_or_not_exit');
                $tmp->relationsType = Model_Driver_DBBasicWhere::RELATIONS_TYPE_OR;
                $tmp->addField('exit_at', Model_Ab1_Shop_Lessee_Car::TABLE_NAME, $exitAt, '', Model_Driver_DBBasicWhere::COMPARE_TYPE_LESS_EQUALLY);
                $tmp = $tmp->addField('is_exit');
                $tmp->addField('is_exit', Model_Ab1_Shop_Lessee_Car::TABLE_NAME, 0);
                $tmp->addField('created_at', Model_Ab1_Shop_Lessee_Car::TABLE_NAME, $exitAt, '', Model_Driver_DBBasicWhere::COMPARE_TYPE_LESS_EQUALLY);
                return true;
            }
            return null;
        }

        // доставка
        if($fieldWhere == 'is_delivery') {
            $isDelivery = Request_RequestParams::valParamBoolean($fieldValue);
            if($isDelivery !== NULL){
                if($isDelivery) {
                    $sql->getRootWhere()->addField('shop_delivery_id', Model_Ab1_Shop_Lessee_Car::TABLE_NAME, 0, '', Model_Driver_DBBasicWhere::COMPARE_TYPE_MORE);
                }else{
                    $sql->getRootWhere()->addField('shop_delivery_id', Model_Ab1_Shop_Lessee_Car::TABLE_NAME, 0, '', Model_Driver_DBBasicWhere::COMPARE_TYPE_EQUALLY);
                }
                return true;
            }
            return null;
        }

        if($fieldWhere == 'weighted_operation_id') {
            $weightedOperationID = Request_RequestParams::valParamInt($fieldValue);
            if($weightedOperationID > -1){
                $operation = $sql->getRootWhere()->addField('weighted_operation_id');
                $operation->relationsType = Model_Driver_DBBasicWhere::RELATIONS_TYPE_OR;
                $operation->addField('weighted_exit_operation_id', '', $weightedOperationID);
                $operation->addField('weighted_entry_operation_id', '', $weightedOperationID);
                return true;
            }
            return null;
        }

        if($fieldWhere == 'is_empty_asu_at') {
            $isEmptyASUAt = Request_RequestParams::valParamBoolean($fieldValue);
            if ($isEmptyASUAt === TRUE) {
                $sql->getRootWhere()->addField('asu_at', Model_Ab1_Shop_Lessee_Car::TABLE_NAME, NULL, '', Model_Driver_DBBasicWhere::COMPARE_TYPE_ISNULL);
                return true;
            }elseif ($isEmptyASUAt === FALSE) {
                $sql->getRootWhere()->addField(
                    'asu_at', Model_Ab1_Shop_Lessee_Car::TABLE_NAME, NULL, '', Model_Driver_DBBasicWhere::COMPARE_TYPE_ISNULL
                )->isNot = TRUE;
                return true;
            }

            return null;
        }

        return parent::_addWhere($dbObject, $fieldWhere, $fieldValue, $params, $sql, $sitePageData, $driver, $isNotReadRequest, $groupBy, $elements);
    }
}
