<?php defined('SYSPATH') or die('No direct script access.');

class Request_Shop_Car extends  Request_Request {
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

        return parent::_addWhere($dbObject, $fieldWhere, $fieldValue, $params, $sql, $sitePageData, $driver, $isNotReadRequest, $groupBy, $elements);
    }
}
