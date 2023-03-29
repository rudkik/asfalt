<?php defined('SYSPATH') or die('No direct script access.');

class Request_Ab1_Shop_Material extends Request_Request {
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
     * Добавляем сортировку
     * @param $dbObject
     * @param $sortByName
     * @param $isASC
     * @param Model_Driver_DBBasicSQL $sql
     * @return bool
     */
    protected static function _addSortBy($dbObject, $sortByName, $isASC, Model_Driver_DBBasicSQL $sql)
    {
        if($sortByName == 'count_recipe') {
            $sql->getrootSort()->addField('', 'count_recipe', $isASC, false);

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
        if($fieldWhere == 'count_recipe') {
            if (Request_RequestParams::valParamBoolean($fieldValue) === TRUE) {
                $table = static::_addElementTableSQL(
                    Model_Ab1_Shop_Material::TABLE_NAME, 'id',
                    Model_Ab1_Shop_Formula_Material::TABLE_NAME, array(), $sql, -1, -1,
                    'shop_material_id', '', FALSE
                );
                $tmp = $sql->getRootWhere()->addField('formula_is_public');
                $tmp->relationsType = Model_Driver_DBBasicWhere::RELATIONS_TYPE_OR;
                $tmp->addField('is_public', $table, 1, '', Model_Driver_DBBasicWhere::COMPARE_TYPE_EQUALLY);
                $tmp->addField('is_public', $table, null, '', Model_Driver_DBBasicWhere::COMPARE_TYPE_ISNULL);

                $tmp = $sql->getRootWhere()->addField('formula_is_delete');
                $tmp->relationsType = Model_Driver_DBBasicWhere::RELATIONS_TYPE_OR;
                $tmp->addField('is_delete', $table, 0, '', Model_Driver_DBBasicWhere::COMPARE_TYPE_EQUALLY);
                $tmp->addField('is_delete', $table, null, '', Model_Driver_DBBasicWhere::COMPARE_TYPE_ISNULL);

                $sql->getRootSelect()->addFunctionField($table, 'id', 'COUNT', 'count_recipe');
                return true;
            }

            return null;
        }

        return parent::_addWhere($dbObject, $fieldWhere, $fieldValue, $params, $sql, $sitePageData, $driver, $isNotReadRequest, $groupBy, $elements);
    }
}
