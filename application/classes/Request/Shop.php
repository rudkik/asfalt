<?php defined('SYSPATH') or die('No direct script access.');

class Request_Shop extends Request_Request {
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
     * Добавляем соединения таблиц
     * @param $dbObject
     * @param $elementName
     * @param array $elementFields
     * @param Model_Driver_DBBasicSQL $sql
     * @return bool
     */
    protected static function _addFromSQL($dbObject, $elementName, array $elementFields, Model_Driver_DBBasicSQL $sql, array $params){
        if($elementName == 'shop_operation_id'){
            $sql->getRootFrom()->addTable(
                Model_Shop::TABLE_NAME, 'id',
                Model_Shop_Operation::TABLE_NAME, 'shop_id',
                Model_Driver_DBBasicFrom::JOIN_LEFT
            );

            $rootSelect = $sql->getRootSelect();
            foreach ($elementFields as $field){
                $rootSelect->addField(
                    Model_Shop_Operation::TABLE_NAME.'__'.'id', $field, 'shop_operation_id'.'___'.$field
                );
            }

            return true;
        }
        return parent::_addFromSQL($dbObject, $elementName, $elementFields, $sql, $params);
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
        if($fieldWhere == 'domain_or_sub_domain' || $fieldWhere == 'domain' || $fieldWhere == 'sub_domain') {
            if (Request_RequestParams::getParamBoolean('domain_or_sub_domain', $params, $isNotReadRequest, $sitePageData) === TRUE) {
                $domain = Request_RequestParams::getParamStr('domain', $params, $isNotReadRequest, $sitePageData);
                $subDomain = Request_RequestParams::getParamStr('sub_domain', $params, $isNotReadRequest, $sitePageData);
                if ((!empty($domain)) && (!empty($subDomain))) {
                    $tmp = $sql->getRootWhere()->addField('', '', '');
                    $tmp->relationsType = Model_Driver_DBBasicWhere::RELATIONS_TYPE_OR;
                    $tmp->addField("domain", Model_Shop::TABLE_NAME, $domain);
                    $tmp->addField("sub_domain", Model_Shop::TABLE_NAME, $subDomain);
                }
            } else {
                Request_RequestUtils::setWhereFieldStr(
                    $sitePageData, array('domain'), 'domain', $sql->getRootWhere(), $params, $isNotReadRequest,
                    Model_Driver_DBBasicWhere::COMPARE_TYPE_EQUALLY
                );
                Request_RequestUtils::setWhereFieldStr(
                    $sitePageData, array('sub_domain'), 'sub_domain', $sql->getRootWhere(), $params, $isNotReadRequest,
                    Model_Driver_DBBasicWhere::COMPARE_TYPE_EQUALLY
                );
            }

            return true;
        }

        return parent::_addWhere(
            $dbObject, $fieldWhere, $fieldValue, $params, $sql, $sitePageData, $driver, $isNotReadRequest,
            $groupBy, $elements
        );
    }

    /**
     * Получаем ID магазина по поддомену
     * @param $domain
     * @param $subDomain
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @param bool $isGlobalID
     * @return int
     */
	public static function getShopID($domain, $subDomain, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver,
									 $isGlobalID = FALSE){

	    $params = Request_RequestParams::setParams(
	        array(
                'domain_or_sub_domain' => TRUE,
                'domain' => $domain,
                'sub_domain' => $subDomain,
            )
        );
        $shop = self::_findOneNotShop('DB_Shop', $sitePageData, $driver, $params);

        if($shop == null){
            return 0;
        }

        if($isGlobalID){
            return $shop->values['global_id'];
        }else{
            return $shop->id;
        }
	}

    /**
     * Получение значений таблицы по филиалам
     * @param string $dbObject
     * @param array $shopIDs
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @param array $params
     * @param int $limit
     * @param bool $isLoadAllFields
     * @param null $elements
     * @param array|int $selectFields
     * @return MyArray
     */
    protected static function _findBranch($dbObject, array $shopIDs, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver,
                                          array $params = array(), $limit = 0, $isLoadAllFields = FALSE, $elements = NULL,
                                          $selectFields = self::SELECT_FIELDS_ALL)
    {
        $params = array_merge($params, $_GET, $_POST);
        $params['main_shop_id'] = $sitePageData->shopID;
        $params[Request_RequestParams::IS_NOT_READ_REQUEST_NAME] = TRUE;

        return parent::_findBranch(
            $dbObject, $shopIDs, $sitePageData, $driver, $params, $limit, $isLoadAllFields, $elements, $selectFields
        );
    }

    /**
     * Поиск филиалов
     * @param $shopID
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @param array $params
     * @param int $limit
     * @param bool $isLoadAllFields
     * @param null $elements
     * @return MyArray
     */
    public static function findShopBranchIDs($shopID, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver,
                                             array $params = array(), $limit = 0, $isLoadAllFields = FALSE, $elements = NULL){
        $params['main_shop_id'] = $shopID;
        return parent::_findNotShop('DB_Shop', $sitePageData, $driver, $params, $limit, $isLoadAllFields, $elements);
    }

    /**
     * Получение всех филиалов
     * @param $shopID
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @param bool $isLoadAllFields
     * @param null $elements
     * @return MyArray
     */
	public static function getBranchShopIDs($shopID, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver,
                                            $isLoadAllFields = FALSE, $elements = NULL){
        $params = Request_RequestParams::setParams();
        return self::findShopBranchIDs($shopID, $sitePageData, $driver, $params, 0, $isLoadAllFields, $elements);
	}
}