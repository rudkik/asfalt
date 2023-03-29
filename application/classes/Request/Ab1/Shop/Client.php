<?php defined('SYSPATH') or die('No direct script access.');

class Request_Ab1_Shop_Client extends Request_Request {
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
        if($fieldWhere == 'name_bin') {
            $tmp = Request_RequestParams::valParamStr($fieldValue);
            if (!empty($tmp)) {
                $fields = $sql->getRootWhere()->addOR('name_bin');
                $fields->addField('name', $dbObject::TABLE_NAME, $tmp, '', Model_Driver_DBBasicWhere::COMPARE_TYPE_LIKE_BEGIN);
                $fields->addField('name_find', $dbObject::TABLE_NAME, $tmp, '', Model_Driver_DBBasicWhere::COMPARE_TYPE_LIKE_BEGIN);
                $fields->addField('bin', $dbObject::TABLE_NAME, $tmp, '', Model_Driver_DBBasicWhere::COMPARE_TYPE_LIKE);
                $fields->addField('mobile', $dbObject::TABLE_NAME, $tmp, '', Model_Driver_DBBasicWhere::COMPARE_TYPE_LIKE);
                return true;
            }
            return null;
        }

        if($fieldWhere == 'name_find') {
            $tmp = Request_RequestParams::valParamStr($fieldValue);
            if(!empty($tmp)){
                $fields = $sql->getRootWhere()->addOR('name_find');
                $fields->addField('name', $dbObject::TABLE_NAME, $tmp, '', Model_Driver_DBBasicWhere::COMPARE_TYPE_LIKE);
                $fields->addField('name_find', $dbObject::TABLE_NAME, $tmp, '', Model_Driver_DBBasicWhere::COMPARE_TYPE_LIKE);;
                return true;
            }
            return null;
        }

        if($fieldWhere == 'amount_not_equally') {
            $tmp = Request_RequestParams::valParamInt($fieldValue);
            if($tmp !== NULL){
                $sql->getRootWhere()->addField(
                    '(amount_1c - block_amount + amount_cash_1c + amount_cash - block_amount_cash)', '', $tmp, '',
                    Model_Driver_DBBasicWhere::COMPARE_TYPE_NOT_EQUALLY
                );
                return true;
            }

            return null;
        }

        if($fieldWhere == 'client_type_id') {
            $tmp = Request_RequestParams::valParamInt($fieldValue);
            if($tmp > -1){
                $fields = $sql->getRootWhere()->addOR('name_find');
                $fields->addField(
                    'client_type_ids', Model_Ab1_Shop_Client::TABLE_NAME,
                    ',' . $tmp . ',', '', Model_Driver_DBBasicWhere::COMPARE_TYPE_LIKE
                );
                $fields->addField('client_type_id', Model_Ab1_Shop_Client::TABLE_NAME, $tmp);
                return true;
            }

            return null;
        }

        return parent::_addWhere($dbObject, $fieldWhere, $fieldValue, $params, $sql, $sitePageData, $driver, $isNotReadRequest, $groupBy, $elements);
    }
}
