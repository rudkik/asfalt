<?php defined('SYSPATH') or die('No direct script access.');

class Request_Ads_Shop_Parcel extends Request_Request {
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
        if($fieldWhere == 'count_parcel_status_id') {
            if (Request_RequestParams::valParamBoolean($fieldValue) === TRUE) {
                $sql->getRootSelect()->addFunctionField(
                    Model_Ads_Shop_Parcel::TABLE_NAME, 'parcel_status_id', 'COUNT', 'count'
                );
                $sql->getRootSelect()->addField(Model_Ads_Shop_Parcel::TABLE_NAME, 'parcel_status_id');

                if(!is_array($groupBy)){
                    $groupBy = array();
                }
                $groupBy[] = 'parcel_status_id';
            }

            return true;
        }

        if($fieldWhere == 'search') {
            $search = Request_RequestParams::valParamStr($fieldValue);
            if(!empty($search)){
                $tmp = $sql->getRootWhere()->addField('search');
                $tmp->relationsType = Model_Driver_DBBasicWhere::RELATIONS_TYPE_OR;

                $tmp->addField('name', Model_Ads_Shop_Parcel::TABLE_NAME, $search, '', Model_Driver_DBBasicWhere::COMPARE_TYPE_LIKE);
                $tmp->addField('phone', Model_Ads_Shop_Parcel::TABLE_NAME, $search, '', Model_Driver_DBBasicWhere::COMPARE_TYPE_LIKE);
            }

            return true;
        }

        return parent::_addWhere($dbObject, $fieldWhere, $fieldValue, $params, $sql, $sitePageData, $driver, $isNotReadRequest, $groupBy, $elements);
    }
}
