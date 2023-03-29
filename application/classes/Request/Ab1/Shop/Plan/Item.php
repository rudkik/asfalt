<?php defined('SYSPATH') or die('No direct script access.');

class Request_Ab1_Shop_Plan_Item extends Request_Request {
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
        if($elementName == 'root_rubric_id'){
            $table = static::_addElementTableSQL(
                Model_Ab1_Shop_Plan_Item::TABLE_NAME, 'shop_product_id',
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

        if($elementName == 'shop_product_rubric_id'){
            $table = static::_addElementTableSQL(
                Model_Ab1_Shop_Plan_Item::TABLE_NAME, 'shop_product_id',
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
        if($fieldWhere == 'period') {
            $periodFrom = Request_RequestParams::valParamDateTime($fieldValue);
            if(($periodFrom !== NULL)){
                $periodFrom = date('Y-m-d', strtotime($periodFrom));
                $periodTo = $periodFrom . ' 23:59:59';

                $tmp = $sql->getRootWhere()->addField('period');
                $tmp->relationsType = Model_Driver_DBBasicWhere::RELATIONS_TYPE_OR;

                $period = $tmp->addField('period_1');
                $period->addField('date_from', '', $periodFrom, '', Model_Driver_DBBasicWhere::COMPARE_TYPE_MORE_EQUALLY);
                $period->addField('date_from', '', $periodTo, '', Model_Driver_DBBasicWhere::COMPARE_TYPE_LESS_EQUALLY);

                $period = $tmp->addField('period_2');
                $period->addField('date_to', '', $periodFrom, '', Model_Driver_DBBasicWhere::COMPARE_TYPE_MORE_EQUALLY);
                $period->addField('date_to', '', $periodTo, '', Model_Driver_DBBasicWhere::COMPARE_TYPE_LESS_EQUALLY);

                $period = $tmp->addField('period_3');
                $period->addField('date_from', '', $periodFrom, '', Model_Driver_DBBasicWhere::COMPARE_TYPE_LESS_EQUALLY);
                $period->addField('date_to', '', $periodTo, '', Model_Driver_DBBasicWhere::COMPARE_TYPE_MORE_EQUALLY);
                return true;
            }
            return null;
        }

        if($fieldWhere == 'plan_date_from') {
            Request_RequestUtils::setWhereFieldDateTime($sitePageData, array('plan_date_from'),
                'date', $sql->getRootWhere(), $params, $isNotReadRequest, Model_Driver_DBBasicWhere::COMPARE_TYPE_MORE);
            return true;
        }

        if($fieldWhere == 'plan_date_from_equally') {
            Request_RequestUtils::setWhereFieldDateTime($sitePageData, array('plan_date_from_equally'),
                'date', $sql->getRootWhere(), $params, $isNotReadRequest, Model_Driver_DBBasicWhere::COMPARE_TYPE_MORE_EQUALLY);
            return true;
        }

        if($fieldWhere == 'plan_date_to') {
            Request_RequestUtils::setWhereFieldDateTime($sitePageData, array('plan_date_to'),
                'date', $sql->getRootWhere(), $params, $isNotReadRequest, Model_Driver_DBBasicWhere::COMPARE_TYPE_LESS_EQUALLY);
            return true;
        }

        return parent::_addWhere(
            $dbObject, $fieldWhere, $fieldValue, $params, $sql, $sitePageData, $driver, $isNotReadRequest,
            $groupBy, $elements
        );
    }
}
