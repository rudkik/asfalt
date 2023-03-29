<?php defined('SYSPATH') or die('No direct script access.');

class Request_Ab1_Shop_Client_Contract_Item extends Request_Request {
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
        if($elementName == 'product_root_rubric_id'){
            $table = static::_addElementTableSQL(
                Model_Ab1_Shop_Client_Contract_Item::TABLE_NAME, 'shop_product_id',
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
                'id', 'product_root_rubric_id'
            );

            return true;
        }

        if($elementName == 'rubric_root_rubric_id'){
            $table = static::_addElementTableSQL(
                Model_Ab1_Shop_Client_Contract_Item::TABLE_NAME, 'shop_product_rubric_id',
                Model_Ab1_Shop_Product_Rubric::TABLE_NAME, array(), $sql
            );

            static::_addElementTableSQL(
                $table, 'root_id',
                Model_Ab1_Shop_Product_Rubric::TABLE_NAME, $elementFields, $sql, -1, -1,
                'id', 'rubric_root_rubric_id'
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
        if($fieldWhere == 'basic_or_contract') {
            $contract = $fieldValue;
            if($contract !== null){
                if(is_array($contract) && !empty($contract)){
                    $field = $sql->getRootWhere()->addOR('basic_or_contract');
                    $field->addField(
                        'shop_client_contract_id', '', $contract, '', Model_Driver_DBBasicWhere::COMPARE_TYPE_IN
                    );
                    $field->addField(
                        'basic_shop_client_contract_id', '', $contract, Model_Driver_DBBasicWhere::COMPARE_TYPE_IN
                    );
                }elseif ($contract > -1) {
                    $field = $sql->getRootWhere()->addOR('basic_or_contract');
                    $field->addField('shop_client_contract_id', '', $contract);
                    $field->addField('basic_shop_client_contract_id', '', $contract);
                }
            }

            return true;
        }

        if($fieldWhere == 'date') {
            $date = Request_RequestParams::valParamDate($fieldValue);
            if($date !== null){
                $sql->getRootWhere()->addField('from_at', Model_Ab1_Shop_Client_Contract_Item::TABLE_NAME, $date, '', Model_Driver_DBBasicWhere::COMPARE_TYPE_LESS_EQUALLY);
                $tableJoin = self::_addJoinTable(
                    $sql,
                    Model_Ab1_Shop_Client_Contract_Item::TABLE_NAME, 'shop_client_contract_id',
                    Model_Ab1_Shop_Client_Contract::TABLE_NAME
                );

                $sql->getRootWhere()->addField('from_at', $tableJoin, $date, '', Model_Driver_DBBasicWhere::COMPARE_TYPE_LESS_EQUALLY);

                $or = $sql->getRootWhere()->addOR('to_at');
                $or->addField('to_at', $tableJoin, $date, '', Model_Driver_DBBasicWhere::COMPARE_TYPE_MORE_EQUALLY);
                $or->addFieldIsNULL('to_at', $tableJoin);
            }
            return true;
        }

        if($fieldWhere == 'contract_date_year') {
            $contractDateYear = Request_RequestParams::valParamInt($fieldValue);
            if($contractDateYear > 0){
                $tableJoin = self::_addJoinTable(
                    $sql,
                    Model_Ab1_Shop_Client_Contract_Item::TABLE_NAME, 'shop_client_contract_id',
                    Model_Ab1_Shop_Client_Contract::TABLE_NAME
                );

                $dateFrom = Helpers_DateTime::getYearBeginStr($contractDateYear);
                $dateTo = Helpers_DateTime::getYearEndStr($contractDateYear);

                $basic = $sql->getRootWhere()->addField('contract_date_year');
                $basic->relationsType = Model_Driver_DBBasicWhere::RELATIONS_TYPE_OR;

                $tmp = $basic->addField('from_at_year');
                $tmp->addField('from_at', $tableJoin, $dateFrom, '', Model_Driver_DBBasicWhere::COMPARE_TYPE_MORE_EQUALLY);
                $tmp->addField('from_at', $tableJoin, $dateTo, '', Model_Driver_DBBasicWhere::COMPARE_TYPE_LESS_EQUALLY);

                $tmp = $basic->addField('to_at_year');
                $tmp->addField('to_at', $tableJoin, $dateFrom, '', Model_Driver_DBBasicWhere::COMPARE_TYPE_MORE_EQUALLY);
                $tmp->addField('to_at', $tableJoin, $dateTo, '', Model_Driver_DBBasicWhere::COMPARE_TYPE_LESS_EQUALLY);

                $tmp = $basic->addField('to_at_from_at_year');
                $tmp->addField('from_at', $tableJoin, $dateFrom, '', Model_Driver_DBBasicWhere::COMPARE_TYPE_LESS_EQUALLY);
                $tmp->addField('to_at', $tableJoin, $dateTo, '', Model_Driver_DBBasicWhere::COMPARE_TYPE_MORE_EQUALLY);
            }
            return true;
        }

        if($fieldWhere == 'contract_date_to') {
            return true;
        }
        if($fieldWhere == 'contract_date_from') {
            $dateFrom = Request_RequestParams::valParamDate($fieldValue);
            $dateTo = Request_RequestParams::getParamDate('contract_date_to', $params, $isNotReadRequest, $sitePageData);
            if($dateFrom !== null && $dateTo !== null){
                $tableJoin = self::_addJoinTable(
                    $sql,
                    Model_Ab1_Shop_Client_Contract_Item::TABLE_NAME, 'shop_client_contract_id',
                    Model_Ab1_Shop_Client_Contract::TABLE_NAME
                );

                $basic = $sql->getRootWhere()->addField('contract_date');
                $basic->relationsType = Model_Driver_DBBasicWhere::RELATIONS_TYPE_OR;

                $tmp = $basic->addField('from_at_year');
                $tmp->addField('from_at', $tableJoin, $dateFrom, '', Model_Driver_DBBasicWhere::COMPARE_TYPE_MORE_EQUALLY);
                $tmp->addField('from_at', $tableJoin, $dateTo, '', Model_Driver_DBBasicWhere::COMPARE_TYPE_LESS_EQUALLY);

                $tmp = $basic->addField('to_at_year');
                $tmp->addField('to_at', $tableJoin, $dateFrom, '', Model_Driver_DBBasicWhere::COMPARE_TYPE_MORE_EQUALLY);
                $tmp->addField('to_at', $tableJoin, $dateTo, '', Model_Driver_DBBasicWhere::COMPARE_TYPE_LESS_EQUALLY);

                $tmp = $basic->addField('to_at_from_at_year');
                $tmp->addField('from_at', $tableJoin, $dateFrom, '', Model_Driver_DBBasicWhere::COMPARE_TYPE_LESS_EQUALLY);
                $tmp->addField('to_at', $tableJoin, $dateTo, '', Model_Driver_DBBasicWhere::COMPARE_TYPE_MORE_EQUALLY);
            }

            return true;
        }

        return parent::_addWhere(
            $dbObject, $fieldWhere, $fieldValue, $params, $sql, $sitePageData, $driver, $isNotReadRequest,
            $groupBy, $elements
        );
    }
}
