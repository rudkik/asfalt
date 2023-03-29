<?php defined('SYSPATH') or die('No direct script access.');

class Request_LandToIP extends Request_Request {
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
        if($fieldWhere == 'ip') {
            $ip = Request_RequestParams::valParamStr($fieldValue);
            if (!empty($ip)) {
                $arr = explode('.', $ip);
                if (count($arr) == 4) {
                    $ip = $arr[0]
                        . Func::addBeginSymbol($arr[1], 0, 3)
                        . Func::addBeginSymbol($arr[2], 0, 3)
                        . Func::addBeginSymbol($arr[3], 0, 3);
                    $ip = floatval($ip);
                    if ($ip > 0) {
                        $sql->getRootWhere()->addField('ip_from_int', '', $ip, '', Model_Driver_DBBasicWhere::COMPARE_TYPE_LESS_EQUALLY);
                        $sql->getRootWhere()->addField('ip_to_int', '', $ip, '', Model_Driver_DBBasicWhere::COMPARE_TYPE_MORE_EQUALLY);
                    }
                }
            }

            return true;
        }

        return parent::_addWhere($dbObject, $fieldWhere, $fieldValue, $params, $sql, $sitePageData, $driver, $isNotReadRequest, $groupBy, $elements);
    }

    /**
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @param array $params
     * @param int $limit
     * @param bool $isLoadAllFields
     * @param null $elements
     * @return MyArray
     */
    public static function findLandToIPIDs(SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver,
                                           array $params = array(), $limit = 0, $isLoadAllFields = FALSE, $elements = NULL)
    {
        $tmp = $sitePageData->dataLanguageID;
        $sitePageData->dataLanguageID = 0;
        try {
            return self::find(
                DB_LandToIp::NAME, $sitePageData->shopID, $sitePageData, $driver,
                $params, $limit, $isLoadAllFields, $elements
            );
        }finally{
            $sitePageData->dataLanguageID = $tmp;
        }
    }
}