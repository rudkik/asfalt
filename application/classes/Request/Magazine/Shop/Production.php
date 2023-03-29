<?php defined('SYSPATH') or die('No direct script access.');

class Request_Magazine_Shop_Production extends Request_Request {
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
        if($elementName == 'shop_production_stock_id') {
            static::_addElementTableSQL(
                Model_Magazine_Shop_Production::TABLE_NAME, 'id',
                Model_Magazine_Shop_Production_Stock::TABLE_NAME, $elementFields,
                $sql, GlobalData::$siteData->shopID, -1, 'shop_production_id', $elementName
            );
            return true;
        }

        return parent::_addFromSQL($dbObject, $elementName, $elementFields, $sql, $params);
    }

    /**
     * Добавляем сортировку
     * @param $dbObject
     * @param $sortByName
     * @param $isASC
     * @param Model_Driver_DBBasicSQL $sql
     * @return bool
     */
    protected static function _addSortBy($dbObject, $sortByName, $isASC, Model_Driver_DBBasicSQL $sql)
    {
        $sortFields = explode('.', $sortByName);
        if($sortFields[0] == 'shop_production_stock_id') {
            $sql->getrootSort()->addField(
                'sp_shop_production_stocks__id', $sortFields[1], $isASC, FALSE
            );

            return true;
        }

        return parent::_addSortBy($dbObject, $sortByName, $isASC, $sql);
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
        if($fieldWhere == 'main_shop_production_rubric_id') {
            $shopProductionRubricIDs = $fieldValue;
            if ($shopProductionRubricIDs !== NULL) {
                $ids = array();
                $paramsRubric = Request_RequestParams::setParams(array());
                if (is_array($shopProductionRubricIDs)) {
                    foreach ($shopProductionRubricIDs as $shopProductionRubricID) {
                        $ids = array_merge(
                            $ids,
                            Request_Magazine_Shop_Production_Rubric::findByRoot(
                                $sitePageData->shopID, $shopProductionRubricID, $sitePageData, $driver, $paramsRubric
                            )->getChildArrayID()
                        );
                        $ids[] = $shopProductionRubricID;
                    }
                } else {
                    $ids = Request_Magazine_Shop_Production_Rubric::findByRoot(
                        $sitePageData->shopID, $shopProductionRubricIDs, $sitePageData, $driver, $paramsRubric
                    )->getChildArrayID();
                    $ids[] = $shopProductionRubricIDs;
                }
                $sql->getRootWhere()->addField(
                    'shop_production_rubric_id', Model_Magazine_Shop_Production::TABLE_NAME,
                    $ids, '', Model_Driver_DBBasicWhere::COMPARE_TYPE_IN
                );
            }
            return true;
        }

        if($fieldWhere == 'quantity_from') {
            $quantity = Request_RequestParams::valParamFloat($fieldValue);
            if($quantity !== NULL){
                $tableJoin = self::_addJoinTable(
                    $sql,
                    Model_Magazine_Shop_Production::TABLE_NAME, 'id',
                    Model_Magazine_Shop_Production_Stock::TABLE_NAME, 'shop_production_id',
                    -1, $sitePageData->shopMainID
                );

                $sql->getRootWhere()->addField('quantity_balance', $tableJoin, $quantity, '', Model_Driver_DBBasicWhere::COMPARE_TYPE_MORE);
            }
            return true;
        }

        if($fieldWhere == 'shop_product_barcode_full') {
            $barcode = Request_RequestParams::valParamStr($fieldValue);
            if(!empty($barcode)){
                $tableJoin = self::_addJoinTable(
                    $sql,
                    Model_Magazine_Shop_Production::TABLE_NAME, 'shop_product_id',
                    Model_Magazine_Shop_Product::TABLE_NAME, 'id',
                    -1, $sitePageData->shopMainID
                );

                $sql->getRootWhere()->addField('barcode', $tableJoin, $barcode, '', Model_Driver_DBBasicWhere::COMPARE_TYPE_EQUALLY);
            }

            return true;
        }

        return parent::_addWhere($dbObject, $fieldWhere, $fieldValue, $params, $sql, $sitePageData, $driver, $isNotReadRequest, $groupBy, $elements);
    }

    /**
     * Проверка на уникальной штрих-кода
     * @param $shopID
     * @param $barcode
     * @param $idNot
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @param bool $isReturnModel
     * @return bool|Model_Magazine_Shop_Production
     */
    public static function checkUniqueBarcode($shopID, $barcode, $idNot, SitePageData $sitePageData,
                                              Model_Driver_DBBasicDriver $driver, $isReturnModel = TRUE)
    {
        if(empty($barcode)){
            return TRUE;
        }

        $params = Request_RequestParams::setParams(
            array(
                'barcode_full' => $barcode,
                'id_not' => $idNot,
            )
        );

        $object = self::findOne('DB_Magazine_Shop_Production', $shopID, $sitePageData, $driver, $params);

        if($object === null){
            return TRUE;
        }else{
            if(!$isReturnModel) {
                return FALSE;
            }

            $model = new Model_Magazine_Shop_Production();
            $model->setDBDriver($driver);
            $object->setModel($model);
            return $model;
        }
    }
}