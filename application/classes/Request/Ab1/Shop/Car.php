<?php defined('SYSPATH') or die('No direct script access.');

class Request_Ab1_Shop_Car extends Request_Request {
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
        if($elementName == 'shop_delivery_product_rubric_id') {
            $table = static::_addElementTableSQL(
                Model_Ab1_Shop_Car::TABLE_NAME, 'shop_delivery_id',
                Model_Ab1_Shop_Delivery::TABLE_NAME, array(), $sql
            );

            static::_addElementTableSQL(
                $table, 'shop_product_rubric_id',
                Model_Ab1_Shop_Product_Rubric::TABLE_NAME, $elementFields, $sql, -1, -1,
                'id', 'shop_delivery_product_rubric_id'
            );
            return true;
        }

        if($elementName == 'root_rubric_id') {
            $table = static::_addElementTableSQL(
                Model_Ab1_Shop_Car::TABLE_NAME, 'shop_product_id',
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
                Model_Ab1_Shop_Car::TABLE_NAME, 'shop_product_id',
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
     * Добавляем группировка
     * @param $dbObject
     * @param $groupByName
     * @param Model_Driver_DBBasicSQL $sql
     * @param null $sortBy
     * @return bool
     */
    protected static function _addGroupBy($dbObject, $groupByName, Model_Driver_DBBasicSQL $sql, $sortBy = NULL)
    {
        if($groupByName == 'exit_at_day_6_hour') {
            $sql->getRootGroupBy()->addField(' ', 'exit_at_day');
            $sql->getRootSelect()->addFunctionField(
                '',
                'CASE WHEN date('.Model_Ab1_Shop_Car::TABLE_NAME.'.exit_at) + interval \'6 hour\' > '.Model_Ab1_Shop_Car::TABLE_NAME.'.exit_at THEN '.Model_Ab1_Shop_Car::TABLE_NAME.'.exit_at - interval \'1 day\''
                . ' ELSE ' . Model_Ab1_Shop_Car::TABLE_NAME.'.exit_at END',
                'date', 'exit_at_day'
            );

            return true;
        }

        $groupFields = explode('.', $groupByName);
        if(count($groupFields) == 2 && $groupFields[0] == 'shop_delivery_product_rubric_id') {
            self::_addGroupTableSQL(
                'ab_shop_product_rubrics__shop_product_rubric_id', $groupFields[1],
                'ab_shop_product_rubrics__shop_product_rubric_id',
                Model_Ab1_Shop_Product_Rubric::TABLE_NAME,
                $sql, $sortBy, FALSE
            );

            return true;
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
        if($fieldWhere == 'shop_transport_company_id-is_own') {
            $isOwn = Request_RequestParams::valParamBoolean($fieldValue);
            if ($isOwn !== NULL) {
                $tableJoin = self::_addJoinTable(
                    $sql,
                    Model_Ab1_Shop_Car::TABLE_NAME, 'shop_transport_company_id',
                    Model_Ab1_Shop_Transport_Company::TABLE_NAME
                );

                $sql->getRootWhere()->addField('is_own', $tableJoin, Func::boolToInt($isOwn));
                return true;
            }
            return null;
        }

        if($fieldWhere == 'exit_at_from_or_not_exit') {
            $exitAt = Request_RequestParams::valParamDateTime($fieldValue);
            if($exitAt !== NULL){
                $tmp = $sql->getRootWhere()->addField('exit_at_from_or_not_exit');
                $tmp->relationsType = Model_Driver_DBBasicWhere::RELATIONS_TYPE_OR;
                $tmp->addField('exit_at', Model_Ab1_Shop_Car::TABLE_NAME, $exitAt, '', Model_Driver_DBBasicWhere::COMPARE_TYPE_MORE);
                $tmp = $tmp->addField('is_exit');
                $tmp->addField('is_exit', Model_Ab1_Shop_Car::TABLE_NAME, 0);
                $tmp->addField('created_at', Model_Ab1_Shop_Car::TABLE_NAME, $exitAt, '', Model_Driver_DBBasicWhere::COMPARE_TYPE_MORE);
                return true;
            }
            return null;
        }

        if($fieldWhere == 'exit_at_to_or_not_exit') {
            $exitAt = Request_RequestParams::valParamDateTime($fieldValue);
            if($exitAt !== NULL){
                $tmp = $sql->getRootWhere()->addField('exit_at_to_or_not_exit');
                $tmp->relationsType = Model_Driver_DBBasicWhere::RELATIONS_TYPE_OR;
                $tmp->addField('exit_at', Model_Ab1_Shop_Car::TABLE_NAME, $exitAt, '', Model_Driver_DBBasicWhere::COMPARE_TYPE_LESS_EQUALLY);
                $tmp = $tmp->addField('is_exit');
                $tmp->addField('is_exit', Model_Ab1_Shop_Car::TABLE_NAME, 0);
                $tmp->addField('created_at', Model_Ab1_Shop_Car::TABLE_NAME, $exitAt, '', Model_Driver_DBBasicWhere::COMPARE_TYPE_LESS_EQUALLY);
                return true;
            }
            return null;
        }

        // наличные
        if($fieldWhere == 'is_cash') {
            $isCash = Request_RequestParams::valParamBoolean($fieldValue);
            if($isCash !== NULL){
                if($isCash) {
                    $sql->getRootWhere()->addField('shop_client_attorney_id', Model_Ab1_Shop_Car::TABLE_NAME, 0, '', Model_Driver_DBBasicWhere::COMPARE_TYPE_EQUALLY);
                }else{
                    $sql->getRootWhere()->addField('shop_client_attorney_id', Model_Ab1_Shop_Car::TABLE_NAME, 0, '', Model_Driver_DBBasicWhere::COMPARE_TYPE_MORE);
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
                $sql->getRootWhere()->addField('asu_at', Model_Ab1_Shop_Car::TABLE_NAME, NULL, '', Model_Driver_DBBasicWhere::COMPARE_TYPE_ISNULL);
            }elseif ($isEmptyASUAt === FALSE) {
                $sql->getRootWhere()->addField(
                    'asu_at', Model_Ab1_Shop_Car::TABLE_NAME, NULL, '', Model_Driver_DBBasicWhere::COMPARE_TYPE_ISNULL
                )->isNot = TRUE;
            }

            return true;
        }

        if($fieldWhere == 'exit_at_day_6_hour') {
            $days = Request_RequestParams::valParamArray($fieldValue);
            if(!empty($days)){
                $tmp = $sql->getRootWhere()->addOR('exit_at_day_6_hour');
                foreach ($days as $day){
                    $tmp->addField(
                        'date(CASE WHEN date(' . Model_Ab1_Shop_Car::TABLE_NAME . '.exit_at) + interval \'6 hour\' > '
                        . Model_Ab1_Shop_Car::TABLE_NAME . '.exit_at THEN ' . Model_Ab1_Shop_Car::TABLE_NAME . '.exit_at - interval \'1 day\''
                        . ' ELSE ' . Model_Ab1_Shop_Car::TABLE_NAME . '.exit_at END)',
                        '', $day
                    )->isFuncField1 = true;
                }
            }else{
                $days = Request_RequestParams::valParamDateTime($fieldValue);
                if($days != null) {
                    $sql->getRootWhere()->addField(
                        'date(CASE WHEN date(' . Model_Ab1_Shop_Car::TABLE_NAME . '.exit_at) + interval \'6 hour\' > '
                        . Model_Ab1_Shop_Car::TABLE_NAME . '.exit_at THEN ' . Model_Ab1_Shop_Car::TABLE_NAME . '.exit_at - interval \'1 day\''
                        . ' ELSE ' . Model_Ab1_Shop_Car::TABLE_NAME . '.exit_at END)',
                        '', $days
                    )->isFuncField1 = true;
                }
            }

            return true;
        }

        if($fieldWhere == 'is_night_22_to_6_hour') {
            $isNight = Request_RequestParams::valParamBoolean($fieldValue);
            if($isNight === true){
                $tmp = $sql->getRootWhere()->addOR('is_night_22_to_6_hour');
                $tmp->addField(
                    Model_Ab1_Shop_Car::TABLE_NAME . '.exit_at::time',
                    '', '22:00:00', '', Model_Driver_DBBasicWhere::COMPARE_TYPE_MORE_EQUALLY
                )->isFuncField1 = true;
                $tmp->addField(
                    Model_Ab1_Shop_Car::TABLE_NAME . '.exit_at::time',
                    '', '06:00:00', '', Model_Driver_DBBasicWhere::COMPARE_TYPE_LESS
                )->isFuncField1 = true;
                return true;
            }elseif($isNight === false){
                $tmp = $sql->getRootWhere()->addField('is_night_22_to_6_hour');
                $tmp->addField(
                    Model_Ab1_Shop_Car::TABLE_NAME . '.exit_at::time',
                    '', '22:00:00', '', Model_Driver_DBBasicWhere::COMPARE_TYPE_LESS
                )->isFuncField1 = true;
                $tmp->addField(
                    Model_Ab1_Shop_Car::TABLE_NAME . '.exit_at::time',
                    '', '06:00:00', '', Model_Driver_DBBasicWhere::COMPARE_TYPE_MORE_EQUALLY
                )->isFuncField1 = true;
                return true;
            }

            return null;
        }

        return parent::_addWhere($dbObject, $fieldWhere, $fieldValue, $params, $sql, $sitePageData, $driver, $isNotReadRequest, $groupBy, $elements);
    }
}
