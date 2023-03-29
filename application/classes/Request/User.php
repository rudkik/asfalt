<?php defined('SYSPATH') or die('No direct script access.');

class Request_User extends Request_Request {
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
        $result = parent::_addWhere(
            $dbObject, $fieldWhere, $fieldValue, $params, $sql, $sitePageData, $driver, $isNotReadRequest, $groupBy, $elements
        );

        if($fieldWhere == 'password'){
            Request_RequestUtils::setWhereFieldStr(
                $sitePageData, array('password'), 'password', $sql->getRootWhere(), $params, $isNotReadRequest,
                Model_Driver_DBBasicWhere::COMPARE_TYPE_EQUALLY, Model_User::TABLE_NAME
            );
            return true;
        }

        if($fieldWhere == 'user_hash'){
            Request_RequestUtils::setWhereFieldStr(
                $sitePageData, array('user_hash'), 'user_hash', $sql->getRootWhere(), $params, $isNotReadRequest,
                Model_Driver_DBBasicWhere::COMPARE_TYPE_EQUALLY, Model_User::TABLE_NAME
            );
            return true;
        }

        if($fieldWhere == 'email'){
            Request_RequestUtils::setWhereFieldStr(
                $sitePageData, array('email'), 'email', $sql->getRootWhere(), $params, $isNotReadRequest,
                Model_Driver_DBBasicWhere::COMPARE_TYPE_EQUALLY, Model_User::TABLE_NAME
            );
            return true;
        }

        return $result;
    }

    /**
     * Получаем ID пользователя по e-mail
     * @param $email
     * @param Model_Driver_DBBasicDriver $driver
     * @return int
     */
	public static function getShopUserIDByEMail($email, Model_Driver_DBBasicDriver $driver){
        return self::findIDByField('DB_Shop_Operation', 'email_full', $email, -1, new SitePageData(), $driver);
	}

}
