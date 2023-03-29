<?php defined('SYSPATH') or die('No direct script access.');

class Request_Ab1_Shop_Formula_Product extends Request_Request {
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
        if($fieldWhere == 'shop_product_rubric_id') {
            $shopProductRubricIDs = $fieldValue;
            if($shopProductRubricIDs !== NULL){

                $table2 = $sql->getRootFrom()->addTable(Model_Ab1_Shop_Formula_Product::TABLE_NAME, 'shop_product_id',
                    Model_Ab1_Shop_Product::TABLE_NAME, 'id');

                $ids = array();
                $paramsRubric = Request_RequestParams::setParams(array());
                if(is_array($shopProductRubricIDs)) {
                    foreach ($shopProductRubricIDs as $shopProductRubricID){
                        $ids = array_merge(
                            $ids,
                            Request_Ab1_Shop_Product_Rubric::findAllByRoot(
                                $sitePageData->shopMainID, $shopProductRubricID, $sitePageData, $driver, $paramsRubric
                            )->getChildArrayID()
                        );
                        $ids[] = $shopProductRubricID;
                    }
                }else{
                    $ids = Request_Ab1_Shop_Product_Rubric::findAllByRoot(
                        $sitePageData->shopMainID, $shopProductRubricIDs, $sitePageData, $driver, $paramsRubric
                    )->getChildArrayID();
                    $ids[] = $shopProductRubricIDs;
                }

                $sql->getRootWhere()->addField('shop_product_rubric_id', $table2, $ids, '',
                    Model_Driver_DBBasicWhere::COMPARE_TYPE_IN);
            }

            return true;
        }

        return parent::_addWhere($dbObject, $fieldWhere, $fieldValue, $params, $sql, $sitePageData, $driver, $isNotReadRequest, $groupBy, $elements);
    }
}
