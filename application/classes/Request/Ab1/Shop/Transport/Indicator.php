<?php defined('SYSPATH') or die('No direct script access.');

class Request_Ab1_Shop_Transport_Indicator extends Request_Request {
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
     * @param array $params
     * @param $fieldValue
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
        // фильтер получаемый по запросу формулы
        if($fieldWhere == 'formula') {
            $formula = Request_RequestParams::valParamStr($fieldValue);
            if (!empty($formula)) {
                $list = preg_split("/[\*,\/,\-,\+,\=,\(,\)]+/", $formula);

                $formula = array();
                foreach ($list as $value){
                    $value = trim($value);
                    if(!empty($value)){
                        $formula[] = $value;
                    }
                }

                if (!empty($formula)) {
                    $tmp = $sql->getRootWhere()->addOR('formula');
                    $tmp->addField(
                        'identifier', Model_Ab1_Shop_Transport_Indicator::TABLE_NAME,
                        $formula, '', Model_Driver_DBBasicWhere::COMPARE_TYPE_IN
                    );
                    $tmp->addField(
                        'name', Model_Ab1_Shop_Transport_Indicator::TABLE_NAME,
                        $formula, '', Model_Driver_DBBasicWhere::COMPARE_TYPE_IN
                    );
                }
                return true;
            }
            return null;
        }

        return parent::_addWhere($dbObject, $fieldWhere, $fieldValue, $params, $sql, $sitePageData, $driver, $isNotReadRequest, $groupBy, $elements);
    }
}
