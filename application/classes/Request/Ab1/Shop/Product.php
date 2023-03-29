<?php defined('SYSPATH') or die('No direct script access.');

class Request_Ab1_Shop_Product extends Request_Request {
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
        if($elementName == 'shop_formula_product_id') {
            static::_addElementTableSQL(
                Model_Ab1_Shop_Product::TABLE_NAME, 'id',
                Model_Ab1_Shop_Formula_Product::TABLE_NAME, $elementFields, $sql, -1, -1,
                'shop_product_id', '', FALSE
            );

            return true;
        }

        if($elementName == 'root_rubric_id'){
            $table = static::_addElementTableSQL(
                Model_Ab1_Shop_Product::TABLE_NAME, 'shop_product_rubric_id',
                Model_Ab1_Shop_Product_Rubric::TABLE_NAME, array(), $sql
            );

            static::_addElementTableSQL(
                $table, 'root_id',
                Model_Ab1_Shop_Product_Rubric::TABLE_NAME, $elementFields, $sql, -1, -1,
                'id', 'root_rubric_id'
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
        if($fieldWhere == 'main_shop_product_rubric_id') {
            $shopProductRubricIDs = $fieldValue;
            if ($shopProductRubricIDs !== NULL && ($shopProductRubricIDs > -1 || is_array($shopProductRubricIDs))) {
                $ids = array();
                $paramsRubric = Request_RequestParams::setParams(array());
                if (is_array($shopProductRubricIDs)) {
                    foreach ($shopProductRubricIDs as $shopProductRubricID) {
                        $ids = array_merge(
                            $ids,
                            Request_Ab1_Shop_Product_Rubric::findAllByRoot($sitePageData->shopMainID, $shopProductRubricID, $sitePageData, $driver, $paramsRubric)->getChildArrayID()
                        );
                        $ids[] = $shopProductRubricID;
                    }
                } else {
                    $ids = Request_Ab1_Shop_Product_Rubric::findAllByRoot($sitePageData->shopMainID, $shopProductRubricIDs, $sitePageData, $driver, $paramsRubric)->getChildArrayID();
                    $ids[] = $shopProductRubricIDs;
                }
                $sql->getRootWhere()->addField('shop_product_rubric_id', Model_Ab1_Shop_Product::TABLE_NAME, $ids, '', Model_Driver_DBBasicWhere::COMPARE_TYPE_IN);
                return true;
            }
            return null;
        }

        if($fieldWhere == 'count_recipe') {
            if (Request_RequestParams::valParamBoolean($fieldValue) === TRUE) {
                $table = static::_addElementTableSQL(
                    Model_Ab1_Shop_Product::TABLE_NAME, 'id',
                    Model_Ab1_Shop_Formula_Product::TABLE_NAME, array(), $sql, -1, -1,
                    'shop_product_id', '', FALSE
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

    /**
     * Получаем ID родительской рубрики продукции
     * @param $id
     * @param $shopID
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @return mixed
     */
    public static function findRootRubricID($id, $shopID, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver){
        $params = Request_RequestParams::setParams(
            array(
                'id' => $id,
            )
        );

        $object = self::findOne(
            'DB_Ab1_Shop_Product', $shopID, $sitePageData, $driver, $params, array('root_rubric_id' => array('id'))
        );

        if($object == null){
            return 0;
        }

        return $object->getElementValue('root_rubric_id', 'id', 0);
    }
}
