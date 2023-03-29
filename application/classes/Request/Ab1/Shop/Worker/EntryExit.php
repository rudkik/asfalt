<?php defined('SYSPATH') or die('No direct script access.');

class Request_Ab1_Shop_Worker_EntryExit extends Request_Request {
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
        if($fieldWhere == 'main_shop_department_id') {
            if ($fieldValue !== null && ((is_array($fieldValue) && !Helpers_Array::_empty($fieldValue)) || $fieldValue > -1)) {
                $ids = Request_Ab1_Shop_Department::findByMain(
                    DB_Ab1_Shop_Department::NAME, $sitePageData->shopID, $sitePageData, $driver,
                     Request_RequestParams::setParams(['shop_department_id' => $fieldValue])
                );

                if(!is_array($fieldValue)){
                    $fieldValue = [$fieldValue];
                }

                $fieldValue = array_merge($fieldValue, $ids->getChildArrayID());

                $sql->getRootWhere()->addField(
                    'shop_department_id',Model_Ab1_Shop_Worker_EntryExit::TABLE_NAME,
                    $fieldValue, '', Model_Driver_DBBasicWhere::COMPARE_TYPE_IN
                );
                return true;
            }

            return null;
        }

        return parent::_addWhere($dbObject, $fieldWhere, $fieldValue, $params, $sql, $sitePageData, $driver, $isNotReadRequest, $groupBy, $elements);
    }
}
