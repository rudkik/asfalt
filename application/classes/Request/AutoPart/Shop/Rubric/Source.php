<?php defined('SYSPATH') or die('No direct script access.');

class Request_AutoPart_Shop_Rubric_Source extends Request_Request {
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
        // Если задана рубрика родителя
        if($fieldWhere == 'main_shop_table_rubric_id') {
            $mainRubricID = $fieldValue;
            if ($mainRubricID !== NULL) {
                if (is_array($mainRubricID) || (intval($mainRubricID) > 0)) {
                    $ids = self::findRubricIDsByMain(
                        $sitePageData->shopID, $sitePageData, $driver, Request_RequestParams::setParams(['id' => $mainRubricID])
                    );

                    if (count($ids->childs) == 0) {
                        return FALSE;
                    }
                    $sql->getRootWhere()->addField("shop_table_rubric_id", '', $ids->getChildArrayID(), "", Model_Driver_DBBasicWhere::COMPARE_TYPE_IN);

                    return true;
                }
            }
            return null;
        }

            // Если задана рубрика родителя из списка товары = рубрики
        if($fieldWhere == 'main_shop_table_rubric_ids') {
            $mainRubricIDs = $fieldValue;
            if ($mainRubricIDs !== NULL) {
                if (is_array($mainRubricIDs) || (intval($mainRubricIDs) > 0)) {
                    $ids = self::findRubricIDsByMain(
                        $sitePageData->shopID, $sitePageData, $driver, Request_RequestParams::setParams(['id' => $mainRubricIDs])
                    );
                    $ids->treeInList();

                    if (count($ids->childs) == 0) {
                        return FALSE;
                    }

                    $sql->getRootWhere()->addField("shop_table_rubric_id", '', $ids->getChildArrayID(true), "", Model_Driver_DBBasicWhere::COMPARE_TYPE_IN);
                }
            }
            return true;
        }

        return parent::_addWhere($dbObject, $fieldWhere, $fieldValue, $params, $sql, $sitePageData, $driver, $isNotReadRequest, $groupBy, $elements);
    }

    /**
     * Получаем список рубрик от основного родителя
     * @param $shopID
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @param array $params
     * @param int $limit
     * @param bool $isLoadAllFields
     * @return MyArray
     */
    public static function findRubricIDsByMain($shopID, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver,
                                               array $params = array(), $limit = 0, $isLoadAllFields = FALSE){
        $rubrics = self::find(
            DB_AutoPart_Shop_Rubric_Source::NAME, $shopID, $sitePageData, $driver,
            $params, $limit, $isLoadAllFields
        );

        foreach($rubrics->childs as $rubric){
            self::_getChildRubricIDs($rubric, $shopID, $sitePageData, $driver, $params, $limit, $isLoadAllFields);
        }

        return $rubrics;
    }

    /**
     * Получаем детвору у всех элементов
     * @param MyArray $rubric
     * @param $shopID
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @param array $params
     * @param int $limit
     * @param bool $isLoadAllFields
     */
    private static function _getChildRubricIDs(MyArray $rubric, $shopID, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver,
                                               array $params = array(), $limit = 0, $isLoadAllFields = FALSE)
    {
        $childRubricIDs = self::find(
            DB_AutoPart_Shop_Rubric_Source::NAME, $shopID, $sitePageData, $driver,
            Request_RequestParams::setParams(['root_id' => $rubric->id]), $limit, $isLoadAllFields
        );
        foreach($childRubricIDs->childs as $childRubricID){
            self::_getChildRubricIDs($childRubricID, $shopID, $sitePageData, $driver, $params, $limit, $isLoadAllFields);
        }
        $rubric->childs = $childRubricIDs->childs;
    }
}