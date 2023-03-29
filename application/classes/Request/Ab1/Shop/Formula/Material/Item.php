<?php defined('SYSPATH') or die('No direct script access.');

class Request_Ab1_Shop_Formula_Material_Item extends Request_Request {
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
        if($fieldWhere == 'formula_type_id') {
            $formulaTypeID = $fieldValue;
            if($formulaTypeID !== NULL){
                $tableJoin = self::_addJoinTable(
                    $sql,
                    Model_Ab1_Shop_Formula_Material_Item::TABLE_NAME, 'shop_formula_product_id',
                    Model_Ab1_Shop_Formula_Material::TABLE_NAME
                );

                if(is_array($formulaTypeID)){
                    $sql->getRootWhere()->addField('formula_type_id', $tableJoin, $formulaTypeID, '', Model_Driver_DBBasicWhere::COMPARE_TYPE_IN);
                }else{
                    $sql->getRootWhere()->addField('formula_type_id', $tableJoin, intval($formulaTypeID), '', Model_Driver_DBBasicWhere::COMPARE_TYPE_EQUALLY);
                }
            }

            return true;
        }

        return parent::_addWhere($dbObject, $fieldWhere, $fieldValue, $params, $sql, $sitePageData, $driver, $isNotReadRequest, $groupBy, $elements);
    }
}
