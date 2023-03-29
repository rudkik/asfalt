<?php defined('SYSPATH') or die('No direct script access.');

class Request_Ab1_Shop_File extends Request_Request {
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
        // по пути "\name1\name2\name3 ищем родителя
        if($fieldWhere == 'path') {
            $path = Request_RequestParams::valParamStr($fieldValue);
            if(!empty($path)){
                $path = explode('\\', str_replace('/', '\\', $path));

                $rootID = 0;
                foreach ($path as $name) {
                    $name = trim($name);
                    if(empty($name)){
                        continue;
                    }

                    $rootID = self::findShopFileIDs($sitePageData->shopMainID, $sitePageData, $driver,
                        array('is_directory' => 1, 'root_id' => $rootID, 'name_full' => $name, Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE), 1, TRUE);
                    if (count($rootID->childs) == 1){
                        $rootID = $rootID->childs[0]->id;
                    }else{
                        return FALSE;
                    }
                }
                $sql->getRootWhere()->addField('root_id', '', $rootID);
                return true;
            }

            return null;
        }

        return parent::_addWhere($dbObject, $fieldWhere, $fieldValue, $params, $sql, $sitePageData, $driver, $isNotReadRequest, $groupBy, $elements);
    }
}
