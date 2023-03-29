<?php defined('SYSPATH') or die('No direct script access.');

class Request_Shop_Operation extends Request_Request {
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
        if($fieldWhere == 'search') {
            $search = Request_RequestParams::valParamStr($fieldValue);
            if(!empty($search)){
                $tmp = $sql->getRootWhere()->addField('search');
                $tmp->relationsType = Model_Driver_DBBasicWhere::RELATIONS_TYPE_OR;

                $tmp->addField('name', Model_Shop_Operation::TABLE_NAME, $search, '', Model_Driver_DBBasicWhere::COMPARE_TYPE_LIKE);
                $tmp->addField('email', Model_Shop_Operation::TABLE_NAME, $search, '', Model_Driver_DBBasicWhere::COMPARE_TYPE_LIKE);
            }
            return true;
        }

        $result = parent::_addWhere(
            $dbObject, $fieldWhere, $fieldValue, $params, $sql, $sitePageData, $driver, $isNotReadRequest, $groupBy, $elements
        );

        if($fieldWhere == 'password'){
            Request_RequestUtils::setWhereFieldStr(
                $sitePageData, array('password'), 'password', $sql->getRootWhere(), $params, $isNotReadRequest,
                Model_Driver_DBBasicWhere::COMPARE_TYPE_EQUALLY, Model_Shop_Operation::TABLE_NAME
            );
            return true;
        }

        if($fieldWhere == 'user_hash'){
            Request_RequestUtils::setWhereFieldStr(
                $sitePageData, array('user_hash'), 'user_hash', $sql->getRootWhere(), $params, $isNotReadRequest,
                Model_Driver_DBBasicWhere::COMPARE_TYPE_EQUALLY, Model_Shop_Operation::TABLE_NAME
            );
            return true;
        }

        if($fieldWhere == 'email'){
            Request_RequestUtils::setWhereFieldStr(
                $sitePageData, array('email'), 'email', $sql->getRootWhere(), $params, $isNotReadRequest,
                Model_Driver_DBBasicWhere::COMPARE_TYPE_EQUALLY, Model_Shop_Operation::TABLE_NAME
            );
            return true;
        }

        return $result;
    }

    /**
     * Получаем ID оператора по e-mail
     * @param $email
     * @param $shopID
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @return int
     */
	public static function findIDByEMail($email, $shopID, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver){
        return self::findIDByField('DB_Shop_Operation', 'email', $email, $shopID, $sitePageData, $driver);
	}
}