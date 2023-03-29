<?php defined('SYSPATH') or die('No direct script access.');

class Request_Ab1_Shop_Piece extends Request_Request {
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
                Model_Ab1_Shop_Piece::TABLE_NAME, 'shop_delivery_id',
                Model_Ab1_Shop_Delivery::TABLE_NAME, array(), $sql
            );

            static::_addElementTableSQL(
                $table, 'shop_product_rubric_id',
                Model_Ab1_Shop_Product_Rubric::TABLE_NAME, $elementFields, $sql, -1, -1,
                'id', 'shop_delivery_product_rubric_id'
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
        if(count($groupFields) == 2 && $groupFields[0] == 'shop_delivery_product_rubric_id') {
            self::_addGroupTableSQL(
                'ab_shop_product_rubrics__shop_product_rubric_id', $groupFields[1],
                'ab_shop_product_rubrics__shop_product_rubric_id',
                Model_Ab1_Shop_Product_Rubric::TABLE_NAME,
                $sql, $sortBy, FALSE
            );
            return true;
        }

        if($groupByName == 'shop_formula_product_id') {
            $sql->getRootGroupBy()->addField(Model_Ab1_Shop_Piece::TABLE_NAME, $groupByName);
            $sql->getRootSelect()->addField(Model_Ab1_Shop_Piece::TABLE_NAME, $groupByName);
            if (($sortBy !== NULL) && (key_exists($groupByName, $sortBy))) {
                $sql->getrootSort()->addField(Model_Ab1_Shop_Piece::TABLE_NAME, $groupByName, !($sortBy[$groupByName] === 'desc'));
            }
            return true;
        }

        if($groupByName == 'exit_at_date') {
            $sql->getRootSelect()->addFunctionField(Model_Ab1_Shop_Piece::TABLE_NAME, 'created_at', 'DATE', 'exit_at_date');
            $sql->getRootGroupBy()->addFunctionField(Model_Ab1_Shop_Piece::TABLE_NAME, 'created_at', 'DATE');
            if (($sortBy !== NULL) && (key_exists($groupByName, $sortBy))) {
                $sql->getrootSort()->addField(Model_Ab1_Shop_Piece::TABLE_NAME, $groupByName, !($sortBy[$groupByName] === 'desc'));
            }
            return true;
        }

        if($groupByName == 'exit_at_day_6_hour') {
            $sql->getRootGroupBy()->addField(' ', 'exit_at_day');
            $sql->getRootSelect()->addFunctionField(
                '',
                'CASE WHEN date('.Model_Ab1_Shop_Piece::TABLE_NAME.'.created_at) + interval \'6 hour\' > '.Model_Ab1_Shop_Piece::TABLE_NAME.'.created_at THEN '.Model_Ab1_Shop_Piece::TABLE_NAME.'.created_at - interval \'1 day\''
                . ' ELSE ' . Model_Ab1_Shop_Piece::TABLE_NAME.'.created_at END',
                'date', 'exit_at_day'
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
                    Model_Ab1_Shop_Piece::TABLE_NAME, 'shop_transport_company_id',
                    Model_Ab1_Shop_Transport_Company::TABLE_NAME
                );

                $sql->getRootWhere()->addField('is_own', $tableJoin, Func::boolToInt($isOwn));
                return true;
            }
            return null;
        }

        // наличные
        if($fieldWhere == 'is_cash') {
            $isCash = Request_RequestParams::valParamBoolean($fieldValue);
            if($isCash !== NULL){
                if($isCash) {
                    $sql->getRootWhere()->addField('shop_client_attorney_id', Model_Ab1_Shop_Piece::TABLE_NAME, 0, '', Model_Driver_DBBasicWhere::COMPARE_TYPE_EQUALLY);
                }else{
                    $sql->getRootWhere()->addField('shop_client_attorney_id', Model_Ab1_Shop_Piece::TABLE_NAME, 0, '', Model_Driver_DBBasicWhere::COMPARE_TYPE_MORE);
                }
                return true;
            }
            return null;
        }

        // доставка
        if($fieldWhere == 'is_delivery') {
            $isDelivery = Request_RequestParams::valParamBoolean($fieldValue);
            if($isDelivery !== NULL){
                if($isDelivery) {
                    $sql->getRootWhere()->addField('shop_delivery_id', Model_Ab1_Shop_Piece::TABLE_NAME, 0, '', Model_Driver_DBBasicWhere::COMPARE_TYPE_MORE);
                }else{
                    $sql->getRootWhere()->addField('shop_delivery_id', Model_Ab1_Shop_Piece::TABLE_NAME, 0, '', Model_Driver_DBBasicWhere::COMPARE_TYPE_EQUALLY);
                }
                return true;
            }

            return null;
        }

        if($fieldWhere == 'exit_at_from' || $fieldWhere == 'exit_at_from_or_not_exit') {
            Request_RequestUtils::setWhereFieldDateTime($sitePageData, array('exit_at_from', 'exit_at_from_or_not_exit'),
                'created_at', $sql->getRootWhere(), $params, $isNotReadRequest, Model_Driver_DBBasicWhere::COMPARE_TYPE_MORE);


            return true;
        }

        if($fieldWhere == 'exit_at_to') {
            Request_RequestUtils::setWhereFieldDateTime($sitePageData, array('exit_at_to'),
                'created_at', $sql->getRootWhere(), $params, $isNotReadRequest, Model_Driver_DBBasicWhere::COMPARE_TYPE_LESS_EQUALLY);
            return true;
        }

        return parent::_addWhere($dbObject, $fieldWhere, $fieldValue, $params, $sql, $sitePageData, $driver, $isNotReadRequest, $groupBy, $elements);
    }
}