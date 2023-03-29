<?php defined('SYSPATH') or die('No direct script access.');

class Api_Magazine_Shop_Realization
{
    /**
     * Считаем количество и сумму продукции реализации
     * @param $shopRealizationID
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @return array
     */
    public static function calcAmountAndQuantity($shopRealizationID, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        $params = Request_RequestParams::setParams(
            array(
                'shop_realization_id' => $shopRealizationID,
                'sum_amount' => TRUE,
                'sum_quantity' => TRUE,
            )
        );
        $ids = Request_Request::find('DB_Magazine_Shop_Realization_Item',
            $sitePageData->shopID, $sitePageData, $driver, $params
        );

        if(count($ids->childs) > 0){
            $ids = $ids->childs[0];
            return array(
                'quantity' => $ids->values['quantity'],
                'amount' => $ids->values['amount'],
            );
        }
    }

    /**
     * Получение продукции для фикскального цека
     * @param $shopRealizationID
     * @param Drivers_CashRegister_Aura3_GoodsList $goodsList
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     */
    public static function getGoodListFiscalCheck($shopRealizationID, Drivers_CashRegister_Aura3_GoodsList $goodsList,
                                                  SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        $params = Request_RequestParams::setParams(
            array(
                'shop_realization_id' => $shopRealizationID,
            )
        );
        $ids = Request_Request::find('DB_Magazine_Shop_Realization_Item',
            $sitePageData->shopID, $sitePageData, $driver, $params, 0, TRUE,
            array('shop_production_id' => array('name'))
        );

        foreach ($ids->childs as $child){
            $goodsList->addGoods(
                $child->getElementValue('shop_production_id'),
                $child->values['price'],
                $child->values['quantity']
            );
        }
    }

    /**
     * Печать фискального чека
     * @param float $paidAmount
     * @param int $shopRealizationID
     * @param int $shopWorkerID
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @return array|bool
     * @throws HTTP_Exception_500
     */
    public static function printFiscalCheck(float $paidAmount, int $shopRealizationID, int $shopWorkerID,
                                            SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver) {

        $fiscalCheck = new Drivers_CashRegister_Aura3_FiscalCheck();

        // список продукции реализации
        Api_Magazine_Shop_Realization::getGoodListFiscalCheck(
            $shopRealizationID, $fiscalCheck->getGoodsList(), $sitePageData, $driver
        );

        if($shopWorkerID > 0) {
            $model = new Model_Ab1_Shop_Worker();
            $model->setDBDriver($driver);
            if(!Helpers_DB::getDBObject($model, $shopWorkerID, $sitePageData, 0)){
                throw new HTTP_Exception_500('Worker id="'.$shopWorkerID.'" not found. #2002041617');
            }
            $fiscalCheck->addVaultStrings('');
            $fiscalCheck->addVaultStrings('Сотрудник: ' . $model->getName());

            // Список талонов сотрудника на заданный день
            $ids = Api_Magazine_Shop_Talon::findWorkerTalons($shopWorkerID, date('Y-m-d'), $sitePageData, $driver);
            if (count($ids->childs) > 0) {
                // Остаток талонов на текущий момент времени.
                $dates = array();
                foreach ($ids->childs as $child) {
                    $date = $child->values['validity_to'];
                    if(!key_exists($date, $dates)){
                        $dates[$date] = $child->values['quantity_balance'];
                    }else{
                        $dates[$date] += $child->values['quantity_balance'];
                    }
                }

                foreach ($dates as $date => $count) {
                    $fiscalCheck->addVaultStrings('Остаток талонов: ' . $count . ' шт.');
                    $fiscalCheck->addVaultStrings('Срок действия: до ' . Helpers_DateTime::getDateTimeDayMonthRus($date, TRUE));
                }
            } else {
                $fiscalCheck->addVaultStrings('Остаток талонов: не осталось.');
            }
        }

        // печать чека
        return Drivers_CashRegister_RemoteComputerAura3::printFiscalCheck(
            'realization_'.$shopRealizationID, floatval($paidAmount), $fiscalCheck, $sitePageData
        );
    }

    /**
     * Реализация продуктов на заданный период
     * @param $dateFrom
     * @param $dateTo
     * @param $isSpecial
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @param null $shopWriteOffTypeID
     * @param int | null $shopProductID
     * @return array
     */
    public static function realizationShopProductPeriod($dateFrom, $dateTo, $isSpecial, SitePageData $sitePageData,
                                                        Model_Driver_DBBasicDriver $driver, $shopWriteOffTypeID = NULL,
                                                        $shopProductID = null)
    {
        $shopProductIDs = array();

        /** Считаем реализации продуктов **/
        $params = Request_RequestParams::setParams(
            array(
                'shop_write_off_type_id' => $shopWriteOffTypeID,
                'is_special' => $isSpecial,
                'sum_quantity' => TRUE,
                'created_at_from' => $dateFrom,
                'created_at_to' => $dateTo,
                'shop_production_id.shop_product_id' => $shopProductID,
                'shop_production_id.shop_product_id_from' => 0,
                'group_by' => array(
                    'shop_production_id.shop_product_id',
                    'shop_production_id.coefficient',
                ),
            )
        );
        // расход
        $ids = Request_Request::find('DB_Magazine_Shop_Realization_Item',
            $sitePageData->shopID, $sitePageData, $driver, $params, 0, TRUE,
            array('shop_production_id' => array('coefficient', 'shop_product_id'))
        );
        foreach ($ids->childs as $child){
            $shopProductID = $child->getElementValue('shop_production_id', 'shop_product_id', 0);
            if(!key_exists($shopProductID, $shopProductIDs)){
                $shopProductIDs[$shopProductID] = 0;
            }

            $coefficient = $child->getElementValue('shop_production_id', 'coefficient', 1);
            if($coefficient == 0){
                $coefficient = 1;
            }
            $shopProductIDs[$shopProductID] += $child->values['quantity'] / $coefficient;
        }

        return $shopProductIDs;
    }

    /**
     * Реализация продукции собственного производства на заданный период
     * @param $dateFrom
     * @param $dateTo
     * @param $isSpecial
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @param null $shopWriteOffTypeID
     * @param int | null $shopProductionID
     * @return array
     */
    public static function realizationShopProductionPeriod($dateFrom, $dateTo, $isSpecial, SitePageData $sitePageData,
                                                           Model_Driver_DBBasicDriver $driver, $shopWriteOffTypeID = NULL,
                                                           $shopProductionID = null)
    {
        $shopProductionIDs = array();

        /** Считаем реализации продуктов **/
        $params = Request_RequestParams::setParams(
            array(
                'shop_write_off_type_id' => $shopWriteOffTypeID,
                'is_special' => $isSpecial,
                'sum_quantity' => TRUE,
                'created_at_from' => $dateFrom,
                'created_at_to' => $dateTo,
                'shop_production_id' => $shopProductionID,
                'shop_production_id.shop_product_id' => 0,
                'group_by' => array(
                    'shop_production_id',
                ),
            )
        );
        // расход
        $ids = Request_Request::find('DB_Magazine_Shop_Realization_Item',
            $sitePageData->shopID, $sitePageData, $driver, $params, 0, TRUE
        );
        foreach ($ids->childs as $child){
            $shopProductionID = $child->values['shop_production_id'];
            if(!key_exists($shopProductionID, $shopProductionIDs)){
                $shopProductionIDs[$shopProductionID] = 0;
            }

            $shopProductionIDs[$shopProductionID] += $child->values['quantity'];
        }

        return $shopProductionIDs;
    }

    /**
     * удаление реализации
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @return bool
     * @throws HTTP_Exception_500
     */
    public static function delete(SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        $id = Request_RequestParams::getParamInt('id');
        if($id < 0){
            return FALSE;
        }
        $isUnDel = Request_RequestParams::getParamBoolean("is_undel");

        $model = new Model_Magazine_Shop_Realization();
        $model->setDBDriver($driver);

        if (!Helpers_DB::dublicateObjectLanguage($model, $id, $sitePageData)) {
            throw new HTTP_Exception_500('Realization not found.');
        }

        if (($isUnDel && !$model->getIsDelete()) or (!$isUnDel && $model->getIsDelete())){
            return FALSE;
        }

        if($isUnDel){
            $params = Request_RequestParams::setParams(
                array(
                    'shop_realization_id' => $id,
                    'is_delete' => 1,
                    'is_public' => FALSE,
                )
            );
            $ids = Request_Request::find('DB_Magazine_Shop_Realization_Item',
                $sitePageData->shopID, $sitePageData, $driver, $params, 0, TRUE,
                array(
                    'shop_production_id' => array('shop_product_id'),
                )
            );
            $driver->unDeleteObjectIDs(
                $ids->getChildArrayID(), $sitePageData->userID, Model_Magazine_Shop_Realization_Item::TABLE_NAME,
                array('is_public' => 1), $sitePageData->shopID
            );

            $model->dbUnDelete($sitePageData->userID, 0, $sitePageData->shopID);
        }else {
            $params = Request_RequestParams::setParams(
                array(
                    'shop_realization_id' => $id,
                    'is_delete' => 0,
                    'is_public' => TRUE,
                )
            );
            $ids = Request_Request::find('DB_Magazine_Shop_Realization_Item',
                $sitePageData->shopID, $sitePageData, $driver, $params, 0, TRUE,
                array(
                    'shop_production_id' => array('shop_product_id'),
                )
            );
            $driver->deleteObjectIDs(
                $ids->getChildArrayID(), $sitePageData->userID, Model_Magazine_Shop_Realization_Item::TABLE_NAME,
                array('is_public' => 0), $sitePageData->shopID
            );

            $model->dbDelete($sitePageData->userID, 0, $sitePageData->shopID);
        }

        foreach ($ids->childs as $child){
            // расход продуктов
            Api_Magazine_Shop_Product::calcExpense(
                $child->getElementValue('shop_production_id', 'shop_product_id'),
                $sitePageData, $driver, TRUE
            );
            // расход продукции
            Api_Magazine_Shop_Production::calcExpense(
                $child->values['shop_production_id'], $sitePageData, $driver, TRUE
            );
        }

        return TRUE;
    }

    /**
     * Сохранение
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @param bool $isSaveRealizationItem
     * @return array
     * @throws HTTP_Exception_500
     */
    public static function save(SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver, $isSaveRealizationItem = TRUE)
    {
        $model = new Model_Magazine_Shop_Realization();
        $model->setDBDriver($driver);

        $id = Request_RequestParams::getParamInt('id');
        if($id > 0) {
            if (!Helpers_DB::dublicateObjectLanguage($model, $id, $sitePageData)) {
                throw new HTTP_Exception_500('Realization not found.');
            }
        }
        Request_RequestParams::setParamBoolean('is_public', $model);
        Request_RequestParams::setParamStr('text', $model);
        Request_RequestParams::setParamStr('name', $model);
        Request_RequestParams::setParamStr("old_id", $model);
        Request_RequestParams::setParamInt("is_special", $model);
        Request_RequestParams::setParamInt("shop_write_off_type_id", $model);
        Request_RequestParams::setParamDateTime('created_at', $model);

        // добавляем карту сотрудника с сотрудника
        $shopCardID = $model->getShopCardID();
        Request_RequestParams::setParamInt("shop_card_id", $model);
        if($shopCardID != $model->getShopCardID()){
            $modelCard = new Model_Magazine_Shop_Card();
            $modelCard->setDBDriver($driver);
            if (Helpers_DB::getDBObject($modelCard, $model->getShopCardID(), $sitePageData, 0)) {
                $model->setShopWorkerID($modelCard->getShopWorkerID());
            }else{
                $model->setShopWorkerID(0);
            }
        }

        $options = Request_RequestParams::getParamArray('options');
        if ($options !== NULL) {
            $model->addOptionsArray($options);
        }

        $shopRealizationItems = Request_RequestParams::getParamArray('shop_realization_items');
        if($shopRealizationItems !== NULL) {
            $model->setAmount(0);
        }

        // номер для 1С для списания
        if(empty($model->getOldID())){
            switch ($model->getShopWriteOffTypeID()){
                case Model_Magazine_Shop_WriteOff_Type::WRITE_OFF_TYPE_RECEPTION:
                case Model_Magazine_Shop_WriteOff_Type::WRITE_OFF_TYPE_OVER_THE_NORM:
                case Model_Magazine_Shop_WriteOff_Type::WRITE_OFF_TYPE_BY_STANDART:
                    $n = Database::instance()->query(Database::SELECT, 'SELECT nextval(\'sp_number_write_off\') as id;')->as_array(NULL, 'id')[0];
                    $n = '00000000'.$n;
                    $n = 'Т'.substr($n, strlen($n) - 8);
                    $model->setOldID($n);
                    $model->setNumber($n);
                    break;
            }
        }

        $result = array();
        $fiscalResult = null;
        if ($model->validationFields($result)) {
            $isNew = $model->id < 1;
            if($model->id < 1) {
                Helpers_DB::saveDBObject($model, $sitePageData);
            }

            // загружаем фотографии
            $file = new Model_File($sitePageData);
            $file->saveFiles(Request_RequestParams::getParamArray('files'), $model, $sitePageData, $driver);

            // сохраняем товары
            if($isSaveRealizationItem && $shopRealizationItems !== NULL) {
                $arr = Api_Magazine_Shop_Realization_Item::save(
                    $model, $shopRealizationItems, $sitePageData, $driver
                );
                $model->setAmount($arr['amount']);
                $model->setQuantity($arr['quantity']);
            }
            Helpers_DB::saveDBObject($model, $sitePageData);

            // считаем остатки талонов
            if($model->getIsSpecial() == Model_Magazine_Shop_Realization::SPECIAL_TYPE_PRODUCT){
                Api_Magazine_Shop_Talon::calcQuantityTalonDate(
                    $model->getShopWorkerID(), $model->getCreatedAt(), $sitePageData, $driver
                );
            }elseif ($model->getIsSpecial() == Model_Magazine_Shop_Realization::SPECIAL_TYPE_BASIC
                || ($model->getIsSpecial() == Model_Magazine_Shop_Realization::SPECIAL_TYPE_WRITE_OFF
                    && $model->getShopWriteOffTypeID() == Model_Magazine_Shop_WriteOff_Type::WRITE_OFF_TYPE_REDRESS)){
                // считаем лимит сотрудника по деньгам
                Api_Magazine_Shop_Worker_Limit::calcAmountBlock(
                    $model->getShopWorkerID(), $model->getCreatedAt(), $sitePageData, $driver
                );
            }

            // печать фискального чека
            if($isNew && !$model->getIsFiscalCheck() && $model->getIsSpecial() != Model_Magazine_Shop_Realization::SPECIAL_TYPE_WRITE_OFF){
                $paidAmount = Request_RequestParams::getParamFloat('paid_amount');
                if($paidAmount == null || $paidAmount < $model->getAmount()){
                    $paidAmount = $model->getAmount();
                }

                $fiscalResult = self::printFiscalCheck($paidAmount, $model->id, $model->getShopWorkerID(), $sitePageData, $driver);
                if(array($fiscalResult)){
                    $model->setFiscalCheck(Arr::path($fiscalResult, 'number', ''));

                    if (!$model->getIsFiscalCheck()) {
                        $fiscalResult['status'] = false;
                    }
                    $model->setShopCashboxID($sitePageData->operation->getShopCashboxID());
                }
            }

            Helpers_DB::saveDBObject($model, $sitePageData);

            $result['values'] = $model->getValues();
        }

        return array(
            'id' => $model->id,
            'is_special' => $model->getIsSpecial(),
            'result' => $result,
            'fiscal_result' => $fiscalResult,
        );
    }

    /**
     * Сохраняем реализацию в виде XML
     * Реализация наличные / по карте АБ1 / по банковской карте / Возмещение
     * @param $dateFrom
     * @param $dateTo
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @param bool $isPHPOutput
     * @return string
     */
    public static function saveRealizationXML($dateFrom, $dateTo, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver, $isPHPOutput = FALSE)
    {
        // получаем список реализаций
        $params = Request_RequestParams::setParams(
            array(
                'created_at_from' => $dateFrom,
                'created_at_to' => $dateTo,
                'shop_write_off_type_id' => [
                    0,
                    Model_Magazine_Shop_WriteOff_Type::WRITE_OFF_TYPE_REDRESS,
                ],
            )
        );
        $shopRealizationIDs = Request_Request::find('DB_Magazine_Shop_Realization',
            $sitePageData->shopID, $sitePageData, $driver, $params
        );

        $list = $shopRealizationIDs->getChildArrayID(true);
        if(count($list) == 0){
            $shopRealizationItemIDs = new MyArray();
        }else {
            // получаем список реализаций
            $params = Request_RequestParams::setParams(
                array(
                    'shop_realization_id' => $list,
                )
            );
            $shopRealizationItemIDs = Request_Request::find('DB_Magazine_Shop_Realization_Item',
                $sitePageData->shopID, $sitePageData, $driver,
                $params, 0, TRUE,
                array(
                    'shop_production_id' => array('name', 'old_id', 'shop_product_id'),
                    'shop_worker_id' => array('name', 'old_id'),
                    'unit_id' => array('name', 'old_id'),
                    'shop_id' => array('old_id'),
                )
            );
        }

        // группируем по реализациям
        $shopRealizations = array();
        foreach($shopRealizationItemIDs->childs as $child){
            $id = $child->values['shop_realization_id'];
            if(!key_exists($id, $shopRealizations)){
                $shopRealizations[$id] = array(
                    'value' => $child,
                    'data' => array(),
                );
            }

            $shopRealizations[$id]['data'][] = $child;
        }

        $data = '<?xml version="1.0" encoding="UTF-8"?><data>';
        foreach($shopRealizations as $child){
            $realization = $child['value'];

            $data .= '<realization>'
                .'<branch>'.$realization->getElementValue('shop_id', 'old_id').'</branch>'
                .'<id>'.$realization->values['id'].'</id>'
                .'<date>'.strftime('%d.%m.%Y %H:%M:%S', strtotime($realization->values['created_at'])).'</date>'
                .'<workerID>'.$realization->getElementValue('shop_worker_id', 'old_id').'</workerID>'
                .'<worker>'.htmlspecialchars($realization->getElementValue('shop_worker_id'), ENT_XML1).'</worker>';

            if($realization->values['shop_worker_id'] < 1){
                $data .= '<paidType>0</paidType>'
                    .'<paidTypeName>Наличные</paidTypeName>';
            }else{
                $data .= '<paidType>1</paidType>'
                    .'<paidTypeName>Карта АБ1</paidTypeName>';
            }

            $data .= '<amount>'.Api_Tax_NDS::getAmountWithoutNDS($realization->values['amount']).'</amount>'
                .'<amountNDS>'.round($realization->values['amount'] / (100 + Api_Tax_NDS::getNDS()) * Api_Tax_NDS::getNDS(), 2).'</amountNDS>';

            $data .= '<goodsList>';
            /** @var MyArray $item */
            foreach ($child['data'] as $item){
                if($item->values['is_special'] == Model_Magazine_Shop_Realization::SPECIAL_TYPE_PRODUCT){
                    $talon = $item->values['quantity'] * 2;
                }else{
                    $talon = 0;
                }

                $quantity = round($item->values['quantity'], 3);
                $amount = round($quantity * $item->values['price'], 2);
                $data .= '<goods>'
                    . '<id>' . $item->getElementValue('shop_production_id', 'shop_product_id', $item->values['shop_production_id']) . '</id>'
                    . '<name>' . htmlspecialchars($item->getElementValue('shop_production_id'), ENT_XML1) . '</name>'
                    . '<unit>' . $item->getElementValue('unit_id', 'old_id') . '</unit>'
                    . '<unit_name>' . htmlspecialchars($item->getElementValue('unit_id'), ENT_XML1) . '</unit_name>'
                    . '<quantity>' . $quantity . '</quantity>'
                    . '<price>' . $item->values['price'] . '</price>'
                    . '<amount>' . Api_Tax_NDS::getAmountWithoutNDS($amount) . '</amount>'
                    . '<amountNDS>' . Api_Tax_NDS::getAmountNDS($amount) . '</amountNDS>'
                    . '<talon>'.$talon.'</talon>'
                    .'</goods>';
            }

            $data .= '</goodsList>';

            $data .= '</realization>';
        }
        $data .= '</data>';

        if($isPHPOutput) {
            header('Content-Type: text/xml');
            header('Content-Disposition: attachment;filename="magazine_realization.xml"');
            header('Cache-Control: max-age=0');

            echo $data;
            exit();
        }

        return $data;
    }

    /**
     * Сохраняем реализацию в виде XML
     * Списание по нормам / сверх норм / в приемную
     * @param $dateFrom
     * @param $dateTo
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @param bool $isPHPOutput
     * @return string
     */
    public static function saveWriteOffXML($dateFrom, $dateTo, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver, $isPHPOutput = FALSE)
    {
        // получаем список реализаций
        $params = Request_RequestParams::setParams(
            array(
                'created_at_from' => $dateFrom,
                'created_at_to' => $dateTo,
                'shop_write_off_type_id' => [
                    Model_Magazine_Shop_WriteOff_Type::WRITE_OFF_TYPE_RECEPTION,
                    Model_Magazine_Shop_WriteOff_Type::WRITE_OFF_TYPE_OVER_THE_NORM,
                    Model_Magazine_Shop_WriteOff_Type::WRITE_OFF_TYPE_BY_STANDART,
                ],
            )
        );
        $shopRealizationItemIDs = Request_Request::find('DB_Magazine_Shop_Realization_Item',
            $sitePageData->shopID, $sitePageData, $driver,
            $params, 0, TRUE,
            array(
                'shop_production_id' => array('name', 'old_id', 'shop_product_id', 'coefficient'),
                'shop_write_off_type_id' => array('name', 'old_id'),
                'shop_product_id' => array('name', 'unit_id'),
                'shop_realization_id' => array('number'),
                'shop_id' => array('old_id'),
            )
        );

        // группируем по реализациям
        $shopRealizations = array();
        foreach($shopRealizationItemIDs->childs as $child){
            $id = $child->values['shop_realization_id'];
            if(!key_exists($id, $shopRealizations)){
                $shopRealizations[$id] = array(
                    'value' => $child,
                    'data' => array(),
                );
            }

            $shopRealizations[$id]['data'][] = $child;
        }

        $data = '<?xml version="1.0" encoding="UTF-8"?><data>';
        foreach($shopRealizations as $child){
            $realization = $child['value'];

            $data .= '<write-off>'
                .'<branch>'.$realization->getElementValue('shop_id', 'old_id').'</branch>'
                .'<id>'.$realization->values['id'].'</id>'
                .'<date>'.strftime('%d.%m.%Y %H:%M:%S', strtotime($realization->values['created_at'])).'</date>'
                .'<subdivisionID>'.$realization->getElementValue('shop_write_off_type_id', 'old_id').'</subdivisionID>'
                .'<subdivision>'.htmlspecialchars($realization->getElementValue('shop_write_off_type_id'), ENT_XML1).'</subdivision>'
                .'<number>'.$realization->getElementValue('shop_realization_id', 'number').'</number>'
                .'<type>'.$realization->values['shop_write_off_type_id'].'</type>';

            $data .= '<goodsList>';
            /** @var MyArray $item */
            foreach ($child['data'] as $item){
                $coefficient = $item->getElementValue('shop_production_id', 'coefficient');
                if($coefficient == 0){
                    $coefficient = 1;
                }
                $quantity = round($item->values['quantity'] / $coefficient, 3);
                $price = round($item->values['price'] * $coefficient, 2);


                $unitID = $item->getElementValue('shop_product_id', 'unit_id');
                $modelUnit = new Model_Magazine_Unit();
                $modelUnit->setDBDriver($driver);
                Helpers_DB::getDBObject($modelUnit, $unitID, $sitePageData, 0);

                $data .= '<goods>'
                    . '<id>' . $item->getElementValue('shop_production_id', 'shop_product_id') . '</id>'
                    . '<name>' . htmlspecialchars($item->getElementValue('shop_production_id'), ENT_XML1) . '</name>'
                    . '<unit>' . $modelUnit->getOldID() . '</unit>'
                    . '<unit_name>' . htmlspecialchars($modelUnit->getName(), ENT_XML1) . '</unit_name>'
                    . '<quantity>' . $quantity . '</quantity>'
                    . '<price>' . $price . '</price>'
                    . '<amount>' . round($quantity * $price, 2) . '</amount>'
                    .'</goods>';
            }

            $data .= '</goodsList>';
            $data .= '</write-off>';
        }
        $data .= '</data>';

        if($isPHPOutput) {
            header('Content-Type: text/xml');
            header('Content-Disposition: attachment;filename="magazine_write_off.xml"');
            header('Cache-Control: max-age=0');

            echo $data;
            exit();
        }

        return $data;
    }

    /**
     * Сохраняем реализацию сотрудников в виде XML
     * @param $dateFrom
     * @param $dateTo
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @param bool $isPHPOutput
     * @return string
     */
    public static function saveRealizationWorkerXML($dateFrom, $dateTo, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver, $isPHPOutput = FALSE)
    {
        // получаем список реализаций
        $params = Request_RequestParams::setParams(
            array(
                'shop_worker_id_from' => 0,
                'created_at_from' => $dateFrom,
                'created_at_to' => $dateTo,
                'sum_amount' => true,
                'shop_write_off_type_id' => [
                    0,
                    Model_Magazine_Shop_WriteOff_Type::WRITE_OFF_TYPE_REDRESS,
                ],
                'is_special' => Model_Magazine_Shop_Realization::SPECIAL_TYPE_BASIC,
                'group_by' => array(
                    'shop_worker_id', 'shop_worker_id.name', 'shop_worker_id.old_id',
                    'shop_id', 'shop_id.old_id',
                )
            )
        );
        $shopRealizationItemIDs = Request_Request::find('DB_Magazine_Shop_Realization_Item',
            $sitePageData->shopID, $sitePageData, $driver,
            $params, 0, TRUE,
            array(
                'shop_worker_id' => array('name', 'old_id'),
                'shop_id' => array('old_id'),
            )
        );

        $data = '<?xml version="1.0" encoding="UTF-8"?><data>';

        $data .= '<datestart>'.strftime('%d.%m.%Y %H:%M:%S', strtotime($dateFrom)).'</datestart>'
            .'<datefinish>'.strftime('%d.%m.%Y %H:%M:%S', strtotime($dateTo)).'</datefinish>'
            . '<branch>'.$sitePageData->shop->getOldID().'</branch>';

        $total = 0;
        $data .= '<workerlists>';
        foreach($shopRealizationItemIDs->childs as $child){
            $data .= '<worker>'
                . '<id_worker>'.$child->getElementValue('shop_worker_id', 'old_id').'</id_worker>'
                . '<worker>'.htmlspecialchars($child->getElementValue('shop_worker_id'), ENT_XML1).'</worker>'
                . '<sum_worker>' . $child->values['amount'] . '</sum_worker>'
                . '</worker>';

            $total += $child->values['amount'];
        }
        $data .= '</workerlists>';
        $data .= '<sumworkers>' . $total . '</sumworkers>';
        $data .= '<sumbankcards>0</sumbankcards>';

        // получаем сумму по спецпродукту
        $params = Request_RequestParams::setParams(
            array(
                'created_at_from' => $dateFrom,
                'created_at_to' => $dateTo,
                'sum_amount' => true,
                'is_special' => Model_Magazine_Shop_Realization::SPECIAL_TYPE_PRODUCT,
            )
        );
        $total = Request_Request::find('DB_Magazine_Shop_Realization_Item',
            $sitePageData->shopID, $sitePageData, $driver, $params
        )->childs[0]->values['amount'];

        $data .=  '<sumspecmol>' . $total . '</sumspecmol>';

        // получаем сумму по наличным
        $params = Request_RequestParams::setParams(
            array(
                'created_at_from' => $dateFrom,
                'created_at_to' => $dateTo,
                'sum_amount' => true,
                'shop_write_off_type_id' => [
                    0,
                    Model_Magazine_Shop_WriteOff_Type::WRITE_OFF_TYPE_REDRESS,
                ],
                'is_special' => Model_Magazine_Shop_Realization::SPECIAL_TYPE_BASIC,
                'shop_worker_id' => 0,
                'shop_card_id' => 0,
            )
        );
        $total = Request_Request::find('DB_Magazine_Shop_Realization_Item',
            $sitePageData->shopID, $sitePageData, $driver, $params
        )->childs[0]->values['amount'];
        $data .=  '<sumcash>' . $total . '</sumcash>';
        $data .= '</data>';

        if($isPHPOutput) {
            header('Content-Type: text/xml');
            header('Content-Disposition: attachment;filename="magazine_realization_worker.xml"');
            header('Cache-Control: max-age=0');

            echo $data;
            exit();
        }

        return $data;
    }


    /**
     * Сохраняем реализацию талонов сотрудников в виде XML
     * @param $dateFrom
     * @param $dateTo
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @param bool $isPHPOutput
     * @return string
     */
    public static function saveRealizationTalonXML($dateFrom, $dateTo, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver, $isPHPOutput = FALSE)
    {
        // получаем список реализаций
        $params = Request_RequestParams::setParams(
            array(
                'created_at_from' => $dateFrom,
                'created_at_to' => $dateTo,
                'sum_quantity' => true,
                'is_special' => Model_Magazine_Shop_Realization::SPECIAL_TYPE_PRODUCT,
                'group_by' => array(
                    'shop_worker_id', 'shop_worker_id.name', 'shop_worker_id.old_id',
                    'shop_id', 'shop_id.old_id',
                )
            )
        );
        $shopRealizationItemIDs = Request_Request::find('DB_Magazine_Shop_Realization_Item',
            $sitePageData->shopID, $sitePageData, $driver,
            $params, 0, TRUE,
            array(
                'shop_worker_id' => array('name', 'old_id'),
                'shop_id' => array('old_id'),
            )
        );

        $data = '<?xml version="1.0" encoding="UTF-8"?><data>';
        $data .= '<date_from>' . $dateFrom . '</date_from>'
            . '<date_to>' . $dateTo . '</date_to>'
            . '<branch>'.$sitePageData->shop->getOldID().'</branch>';
        $data .= '<Workers>';
        foreach($shopRealizationItemIDs->childs as $child){
            $data .= '<Worker>'
                . '<Id>'.htmlspecialchars($child->getElementValue('shop_worker_id', 'old_id'), ENT_XML1).'</Id>'
                . '<FIO>'.htmlspecialchars($child->getElementValue('shop_worker_id'), ENT_XML1).'</FIO>'
                . '<Quantity>'.($child->values['quantity'] * 2).'</Quantity>'
                . '</Worker>';
        }
        $data .= '</Workers>';
        $data .= '</data>';

        if($isPHPOutput) {
            header('Content-Type: text/xml');
            header('Content-Disposition: attachment;filename="magazine_talon_realization.xml"');
            header('Cache-Control: max-age=0');

            echo $data;
            exit();
        }

        return $data;
    }
}
