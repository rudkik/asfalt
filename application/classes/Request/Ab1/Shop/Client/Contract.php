<?php defined('SYSPATH') or die('No direct script access.');

class Request_Ab1_Shop_Client_Contract extends Request_Request {
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
        //  дата срока действия
        if($fieldWhere == 'main_client_contract_type_id') {
            $validity = Request_RequestParams::valParamInt($fieldValue);
            if ($validity !== null && $validity > -1){
                $types = Request_Request::find(
                    DB_Ab1_ClientContract_Type::NAME, 0, $sitePageData, $driver,
                    Request_RequestParams::setParams(['root_id' => $validity]), 0, true, null, ['id']
                )->getChildArrayID();

                if(empty($types)){
                    return  false;
                }

                $sql->getRootWhere()->addField('client_contract_type_id', '', $types, '', Model_Driver_DBBasicWhere::COMPARE_TYPE_IN);
            }

            return true;
        }

        return parent::_addWhere($dbObject, $fieldWhere, $fieldValue, $params, $sql, $sitePageData, $driver, $isNotReadRequest, $groupBy, $elements);
    }
}
