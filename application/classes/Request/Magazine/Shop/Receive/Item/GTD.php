<?php defined('SYSPATH') or die('No direct script access.');

class Request_Magazine_Shop_Receive_Item_GTD extends Request_Request {
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
        if($elementName == 'shop_production_id') {
            $table = static::_addElementTableSQL(
                Model_Magazine_Shop_Receive_Item::TABLE_NAME, 'shop_product_id',
                Model_Magazine_Shop_Product::TABLE_NAME, array(), $sql
            );
            static::_addElementTableSQL(
                $table, 'id',
                Model_Magazine_Shop_Production::TABLE_NAME, $elementFields, $sql, -1, -1,
                'shop_product_id', 'shop_production_id'
            );

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
        // вид приемки ЭСФ (электронная, бумажная и т.д.)
        if($fieldWhere == 'shop_receive_esf_type_id') {
            $esfTypeID = $fieldValue;
            if($esfTypeID !== NULL && ((is_array($esfTypeID) && !empty($esfTypeID)) || $esfTypeID > -1)){
                $tableJoin = self::_addJoinTable(
                    $sql,
                    Model_Magazine_Shop_Receive_Item_GTD::TABLE_NAME, 'shop_receive_id',
                    Model_Magazine_Shop_Receive::TABLE_NAME
                );

                if(is_array($esfTypeID)){
                    $sql->getRootWhere()->addField('esf_type_id', $tableJoin, $esfTypeID, '', Model_Driver_DBBasicWhere::COMPARE_TYPE_IN);
                }else{
                    $sql->getRootWhere()->addField('esf_type_id', $tableJoin, intval($esfTypeID));

                }
            }

            return true;
        }

        return parent::_addWhere($dbObject, $fieldWhere, $fieldValue, $params, $sql, $sitePageData, $driver, $isNotReadRequest, $groupBy, $elements);
    }
}
