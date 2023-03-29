<?php defined('SYSPATH') or die('No direct script access.');

class Request_Shop_Good extends Request_Shop_Table_Basic_Rubric {
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
        // получаем массив группированных фильтров для поиска
        if($fieldWhere == 'group_filters') {
            $groupAttributes = Request_RequestParams::valParamArray($fieldValue);
            if (($groupAttributes !== NULL) && (count($groupAttributes) > 0)) {
                foreach ($groupAttributes as $attributes) {
                    $tmp = array();
                    foreach ($attributes as $attributeID) {
                        $attributeID = intval($attributeID);
                        if ($attributeID > 0) {
                            $tmp[] = $attributeID;
                        }
                    }

                    if (count($tmp) > 0) {
                        $ids = Request_Shop_Table_ObjectToObject::findShopTableObjectToObjectIDs($sitePageData->shopID, $sitePageData,
                            $driver, array('shop_child_object_id' => $tmp, Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE));

                        if (count($ids->childs) == 0) {
                            return FALSE;
                        }

                        $tmp = array();
                        $ids->getArrayID($tmp);
                        $sql->getRootWhere()->addField("id", '', $tmp, "", Model_Driver_DBBasicWhere::COMPARE_TYPE_IN);
                    }
                }
            }
            return true;
        }

        if($fieldWhere == 'root_shop_table_stock_id') {
            $shopTableStockID = Request_RequestParams::valParamInt($fieldValue);
            if (($shopTableStockID !== NULL) && ($shopTableStockID > -1)) {
                $ids = Request_Shop_Table_Stock::findShopTableStockIDsByMain($sitePageData->shopID, $sitePageData, $driver,
                    array('root_id' => $shopTableStockID, Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE));

                $tmp = $ids->getChildArrayID();
                $tmp[] = $shopTableStockID;
                $sql->getRootWhere()->addField("shop_table_stock_id", '', $tmp, "", Model_Driver_DBBasicWhere::COMPARE_TYPE_IN);
            }
            return true;
        }

        if($fieldWhere == 'work_type_id') {
            $workTypeID = Request_RequestParams::valParamInt($fieldValue);
            if ($workTypeID === NULL){
                if ((Request_RequestParams::getParamBoolean('is_delete', $params, $isNotReadRequest, $sitePageData) !== TRUE)) {
                    $sql->getRootWhere()->addField('work_type_id', '', Model_WorkType::WORK_TYPE_FINISH);
                }
            }elseif($workTypeID > -1){
                $sql->getRootWhere()->addField('work_type_id', '', $workTypeID);
            }
            return true;
        }

        // со скидкой или акцией
        if($fieldWhere == 'is_discount_action') {
            $tmp = Request_RequestParams::valParamBoolean($fieldValue);
            if ($tmp === TRUE) {
                $tmp = $sql->getRootWhere()->addField('is_action_discount', '', '');
                $tmp->relationsType = Model_Driver_DBBasicWhere::RELATIONS_TYPE_OR;
                $tmp->addField('system_is_discount', '', 1);
                $tmp->addField('system_is_action', '', 1);
                $tmp->addField('price_old', '', 0, '', Model_Driver_DBBasicWhere::COMPARE_TYPE_MORE);
            }elseif($tmp === FALSE){
                $tmp = $sql->getRootWhere()->addField('is_action_discount', '', '');
                $tmp->addField("system_is_discount", '', 0);
                $tmp->addField("system_is_action", '', 0);
                $tmp->addField("price_old", "", 0);
            }
            return true;
        }

        // со скидкой
        if($fieldWhere == 'is_discount') {
            $tmp = Request_RequestParams::valParamBoolean($fieldValue);
            if ($tmp === TRUE){
                $tmp = $sql->getRootWhere()->addField('is_discount', '', '');
                $tmp->relationsType = Model_Driver_DBBasicWhere::RELATIONS_TYPE_OR;
                $tmp->addField('system_is_discount', '', 1);
                $tmp->addField('price_old', '', 0, '', Model_Driver_DBBasicWhere::COMPARE_TYPE_MORE);
            }elseif($tmp === FALSE){
                $tmp = $sql->getRootWhere()->addField('is_discount', '', '');
                $tmp->addField("system_is_discount", "", 0);
                $tmp->addField("price_old", "", 0);
            }

            return true;
        }

        return parent::_addWhere($dbObject, $fieldWhere, $fieldValue, $params, $sql, $sitePageData, $driver, $isNotReadRequest, $groupBy, $elements);
    }
}
