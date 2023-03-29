<?php defined('SYSPATH') or die('No direct script access.');

class Request_Ab1_Shop_Transport_Route extends Request_Request {
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
        // фильтер филиалам отправления или получения
        if($fieldWhere == 'shop_branch_from_to_id') {
            $branches = $fieldValue;
            if ($branches !== NULL) {
                if(!is_array($branches)){
                    $branches = array($branches);
                }

                foreach ($branches as $branch) {
                    $branch = intval($branch);
                    if($branch < 0 || $branch === false){
                        continue;
                    }
                    $tmp = $sql->getRootWhere()->addField('shop_branch_from_to_id'.$branch);
                    $tmp->relationsType = Model_Driver_DBBasicWhere::RELATIONS_TYPE_OR;

                    $tmp->addField('shop_branch_from_id', '', $branch);
                    $tmp->addField('shop_branch_to_id', '', $branch);
                }
                return true;
            }
            return null;
        }
        // фильтер поставщикам отправления или получения
        if($fieldWhere == 'shop_daughter_from_to_id') {
            $daughter = Request_RequestParams::valParamInt($fieldValue);
            if ($daughter !== NULL && $daughter > -1) {
                $tmp = $sql->getRootWhere()->addField('shop_daughter_from_to_id');
                if($daughter > 0){
                    $tmp->relationsType = Model_Driver_DBBasicWhere::RELATIONS_TYPE_OR;
                }

                $tmp->addField('shop_daughter_from_id', '', $daughter);
                $tmp->addField('shop_daughter_to_id', '', $daughter);
                return true;
            }
            return null;
        }

        return parent::_addWhere($dbObject, $fieldWhere, $fieldValue, $params, $sql, $sitePageData, $driver, $isNotReadRequest, $groupBy, $elements);
    }
}
