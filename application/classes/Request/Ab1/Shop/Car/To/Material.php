<?php defined('SYSPATH') or die('No direct script access.');

class Request_Ab1_Shop_Car_To_Material extends Request_Request {
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
     * Добавляем группировка
     * @param $dbObject
     * @param $groupByName
     * @param Model_Driver_DBBasicSQL $sql
     * @param null $sortBy
     * @return bool
     */
    protected static function _addGroupBy($dbObject, $groupByName, Model_Driver_DBBasicSQL $sql, $sortBy = NULL)
    {
        if($groupByName == 'date_document_day_6_hour') {
            $sql->getRootGroupBy()->addField(' ', 'date_document_day');
            $sql->getRootSelect()->addFunctionField(
                '',
                'CASE WHEN date('.Model_Ab1_Shop_Car_To_Material::TABLE_NAME.'.date_document) + interval \'6 hour\' > '.Model_Ab1_Shop_Car_To_Material::TABLE_NAME.'.date_document THEN '.Model_Ab1_Shop_Car_To_Material::TABLE_NAME.'.date_document - interval \'1 day\''
                . ' ELSE ' . Model_Ab1_Shop_Car_To_Material::TABLE_NAME.'.date_document END',
                'date', 'date_document_day'
            );

            return true;
        }

        return parent::_addGroupBy($dbObject, $groupByName, $sql, $sortBy);
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
        // фильтер по дате получения или дате создания
        if($fieldWhere == 'shop_subdivision_id') {
            $value = $fieldValue;
            if ($value !== NULL) {
                if(is_array($value)) {
                    if(!Helpers_Array::_empty($value)) {
                        $tmp = $sql->getRootWhere()->addOR('shop_subdivision_id');
                        $tmp->addField(
                            'shop_subdivision_receiver_id', '',
                            $value, '', Model_Driver_DBBasicWhere::COMPARE_TYPE_IN
                        );
                        $tmp->addField(
                            'shop_subdivision_daughter_id', '',
                            $value, '', Model_Driver_DBBasicWhere::COMPARE_TYPE_IN
                        );
                        return true;
                    }
                }elseif($value > -1){
                    $tmp = $sql->getRootWhere()->addOR('shop_subdivision_id');
                    $tmp->addField('shop_subdivision_receiver_id', '', $value);
                    $tmp->addField('shop_subdivision_daughter_id', '', $value);
                    return true;
                }
            }
            return null;
        }

        // фильтер по дате получения или дате создания
        if($fieldWhere == 'receiver_created_at_from') {
            $date = Request_RequestParams::valParamDateTime($fieldValue);
            if (($date !== NULL)) {
                $tmp = $sql->getRootWhere()->addField('receiver_created_at_from');
                $tmp->relationsType = Model_Driver_DBBasicWhere::RELATIONS_TYPE_OR;

                $tmp->addField('receiver_at', '', $date, '', Model_Driver_DBBasicWhere::COMPARE_TYPE_MORE);

                $tmp = $tmp->addField('created_at_from');
                $tmp->addField('created_at', '', $date, '', Model_Driver_DBBasicWhere::COMPARE_TYPE_MORE);
                $tmp->addField('receiver_at', '', NULL, '', Model_Driver_DBBasicWhere::COMPARE_TYPE_ISNULL);
                return true;
            }
            return null;
        }

        if($fieldWhere == 'receiver_created_at_to') {
            $date = Request_RequestParams::valParamDateTime($fieldValue);
            if (($date !== NULL)) {
                $tmp = $sql->getRootWhere()->addField('receiver_created_at_to');
                $tmp->relationsType = Model_Driver_DBBasicWhere::RELATIONS_TYPE_OR;

                $tmp->addField('receiver_at', '', $date, '', Model_Driver_DBBasicWhere::COMPARE_TYPE_LESS_EQUALLY);

                $tmp = $tmp->addField('created_at_from');
                $tmp->addField('created_at', '', $date, '', Model_Driver_DBBasicWhere::COMPARE_TYPE_LESS_EQUALLY);
                $tmp->addField('receiver_at', '', NULL, '', Model_Driver_DBBasicWhere::COMPARE_TYPE_ISNULL);
            }
            return true;
        }

        // фильтер по дате взвешивания тары или дате создания
        if($fieldWhere == 'update_tare_created_at_from') {
            $date = Request_RequestParams::valParamDateTime($fieldValue);
            if(($date !== NULL)){
                $tmp = $sql->getRootWhere()->addField('update_tare_created_at_from');
                $tmp->relationsType = Model_Driver_DBBasicWhere::RELATIONS_TYPE_OR;

                $tmp->addField('created_at', '', $date, '', Model_Driver_DBBasicWhere::COMPARE_TYPE_MORE);
                $tmp->addField('update_tare_at', '', $date, '', Model_Driver_DBBasicWhere::COMPARE_TYPE_MORE);
            }
            return true;
        }

        // фильтер по дате взвешивания тары или дате создания
        if($fieldWhere == 'update_tare_created_at_to') {
            $date = Request_RequestParams::valParamDateTime($fieldValue);
            if(($date !== NULL)){
                $tmp = $sql->getRootWhere()->addField('update_tare_created_at_to');
                $tmp->relationsType = Model_Driver_DBBasicWhere::RELATIONS_TYPE_OR;

                $tmp->addField('created_at', '', $date, '', Model_Driver_DBBasicWhere::COMPARE_TYPE_LESS_EQUALLY);
                $tmp->addField('update_tare_at', '', $date, '', Model_Driver_DBBasicWhere::COMPARE_TYPE_LESS_EQUALLY);
            }
            return true;
        }

        // фильтер по рубрики материалов
        if($fieldWhere == 'shop_material_rubric_id') {
            $shopMaterialRubricID = Request_RequestParams::valParamInt($fieldValue);
            if (($shopMaterialRubricID !== NULL)) {
                if (is_array($shopMaterialRubricID) || (intval($shopMaterialRubricID) > 0)) {
                    $tableJoin = $sql->getRootFrom()->addTable(Model_Ab1_Shop_Car_To_Material::TABLE_NAME, 'shop_material_id',
                        Model_Ab1_Shop_Material::TABLE_NAME);

                    $sql->getRootWhere()->addField('shop_material_rubric_id', $tableJoin, $shopMaterialRubricID, '', Model_Driver_DBBasicWhere::COMPARE_TYPE_IN);
                }
            }
            return true;
        }

        // фильтер по пустому весу отправителя
        if($fieldWhere == 'is_quantity_daughter_empty') {
            if(Request_RequestParams::valParamBoolean($fieldValue) === TRUE){
                $sql->getRootWhere()->addField('quantity_daughter', Model_Ab1_Shop_Car_To_Material::TABLE_NAME, 0, '', Model_Driver_DBBasicWhere::COMPARE_TYPE_EQUALLY);
            }
            return true;
        }

        // получатель или отправитель
        if($fieldWhere == 'main_shop_id') {
            $mainShopID = Request_RequestParams::valParamInt($fieldValue);
            if(($mainShopID !== NULL) && ($mainShopID > -1)){
                $tmp = $sql->getRootWhere()->addField('main_shop_id');
                $tmp->relationsType = Model_Driver_DBBasicWhere::RELATIONS_TYPE_OR;

                $tmp->addField('shop_branch_receiver_id', '', $mainShopID, '');
                $tmp->addField('shop_branch_daughter_id', '', $mainShopID, '');
            }
            return true;
        }

        // отправитель компания или филиал
        if($fieldWhere == 'daughter_id') {
            $daughterID = Request_RequestParams::valParamInt($fieldValue);
            if (($daughterID !== NULL) && ($daughterID > -1)) {
                $tmp = $sql->getRootWhere()->addField('daughter_id');
                $tmp->relationsType = Model_Driver_DBBasicWhere::RELATIONS_TYPE_OR;

                $tmp->addField('shop_daughter_id', '', $daughterID, '');
                $tmp->addField('shop_branch_daughter_id', '', $daughterID, '');
            }
            return true;
        }

        // отправитель компания или филиал
        if($fieldWhere == 'main_shop_id') {
            $daughterID = Request_RequestParams::valParamInt($fieldValue);
            if(($daughterID !== NULL) && ($daughterID > -1)){
                $tmp = $sql->getRootWhere()->addField('main_shop_id');
                $tmp->relationsType = Model_Driver_DBBasicWhere::RELATIONS_TYPE_OR;

                $tmp->addField('shop_daughter_id', '', $daughterID, '');
                $tmp->addField('shop_branch_daughter_id', '', $daughterID, '');
            }
            return true;
        }

        // отправитель или получаетль филиал
        if($fieldWhere == 'shop_branch_daughter_receiver_id') {
            $daughterID = Request_RequestParams::valParamInt($fieldValue);
            if(($daughterID !== NULL) && ($daughterID > -1)){
                $tmp = $sql->getRootWhere()->addField('shop_branch_daughter_receiver_id');
                $tmp->relationsType = Model_Driver_DBBasicWhere::RELATIONS_TYPE_OR;

                $tmp->addField('shop_branch_receiver_id', '', $daughterID, '');
                $tmp->addField('shop_branch_daughter_id', '', $daughterID, '');
            }
            return true;
        }

        if($fieldWhere == 'sum_quantity_invoice_daughter') {
            if (Request_RequestParams::valParamBoolean($fieldValue) === TRUE) {
                $sql->getRootSelect()->addFunctionField('', 'CASE WHEN '.Model_Ab1_Shop_Car_To_Material::TABLE_NAME.'.quantity_invoice > 0.001 THEN '.Model_Ab1_Shop_Car_To_Material::TABLE_NAME.'.quantity_invoice ELSE '.Model_Ab1_Shop_Car_To_Material::TABLE_NAME.'.quantity_daughter END', 'SUM', 'quantity_invoice_daughter');

                if(!is_array($groupBy)){
                    $groupBy = array();
                }
                $groupBy[] = '*';
            }
            return true;
        }

        if($fieldWhere == 'sum_daughter_weight') {
            if (Request_RequestParams::valParamBoolean($fieldValue) === TRUE) {
                $tableJoin = self::_addJoinTable(
                    $sql,
                    Model_Ab1_Shop_Car_To_Material::TABLE_NAME, 'shop_daughter_id',
                    Model_Ab1_Shop_Daughter::TABLE_NAME
                );

                $sql->getRootSelect()->addFunctionField(
                    '',
                    'CASE WHEN '.Model_Ab1_Shop_Car_To_Material::TABLE_NAME.'.quantity_invoice  > 0 THEN '.Model_Ab1_Shop_Car_To_Material::TABLE_NAME.'.quantity_invoice'
                    . ' ELSE CASE WHEN '.$tableJoin.'.daughter_weight_id  = ' . Model_Ab1_DaughterWeight::DAUGHTER_WEIGHT_RECEIVER . ' THEN '.Model_Ab1_Shop_Car_To_Material::TABLE_NAME.'.quantity'
                    . ' ELSE CASE WHEN '.$tableJoin.'.daughter_weight_id = ' . Model_Ab1_DaughterWeight::DAUGHTER_WEIGHT_INVOICE . ' THEN '.Model_Ab1_Shop_Car_To_Material::TABLE_NAME.'.quantity_invoice'
                    . ' ELSE ' . Model_Ab1_Shop_Car_To_Material::TABLE_NAME.'.quantity_daughter END END END',
                    'SUM', 'quantity'
                );

                if(!is_array($groupBy)){
                    $groupBy = array();
                }
                $groupBy[] = '*';
            }
            return true;
        }

        if($fieldWhere == 'is_import_car') {
            $isImportCar = Request_RequestParams::valParamBoolean($fieldValue);
            if ($isImportCar === TRUE) {
                $sql->getRootWhere()->addField(
                    'shop_branch_receiver_id', Model_Ab1_Shop_Car_To_Material::TABLE_NAME,
                    'shop_branch_daughter_id', Model_Ab1_Shop_Car_To_Material::TABLE_NAME,
                    Model_Driver_DBBasicWhere::COMPARE_TYPE_NOT_EQUALLY
                );
            }elseif ($isImportCar === false){
                $sql->getRootWhere()->addField(
                    'shop_branch_receiver_id', Model_Ab1_Shop_Car_To_Material::TABLE_NAME,
                    'shop_branch_daughter_id', Model_Ab1_Shop_Car_To_Material::TABLE_NAME,
                    Model_Driver_DBBasicWhere::COMPARE_TYPE_EQUALLY
                );

            }
            return true;
        }

        if($fieldWhere == 'shop_transport_company_id.is_own') {
            $isOwn = Request_RequestParams::valParamBoolean($fieldValue);
            if ($isOwn !== null) {
                $tableJoin = self::_addJoinTable(
                    $sql,
                    Model_Ab1_Shop_Car_To_Material::TABLE_NAME, 'shop_transport_company_id',
                    Model_Ab1_Shop_Transport_Company::TABLE_NAME
                );

                $sql->getRootWhere()->addField('is_own', $tableJoin, Func::boolToInt($isOwn));
            }
            return true;
        }

        return parent::_addWhere(
            $dbObject, $fieldWhere, $fieldValue, $params, $sql, $sitePageData, $driver, $isNotReadRequest,
            $groupBy, $elements
        );
    }
}
