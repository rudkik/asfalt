<?php defined('SYSPATH') or die('No direct script access.');

class Api_Magazine_Shop_Realization_Return
{

    /**
     * Получение продукции для фикскального цека
     * @param $shopRealizationReturnID
     * @param Drivers_CashRegister_Aura3_GoodsList $goodsList
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     */
    public static function getGoodListFiscalCheck($shopRealizationReturnID, Drivers_CashRegister_Aura3_GoodsList $goodsList,
                                                  SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        $params = Request_RequestParams::setParams(
            array(
                'shop_realization_return_id' => $shopRealizationReturnID,
            )
        );
        $ids = Request_Request::find('DB_Magazine_Shop_Realization_Return_Item', 
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
     * @param $shopRealizationReturnID
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @return string
     */
    public static function printReturnFiscalCheck(float $paidAmount, $shopRealizationReturnID,
                                            SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver) {

        $fiscalCheck = new Drivers_CashRegister_Aura3_FiscalCheck();
        Api_Magazine_Shop_Realization_Return::getGoodListFiscalCheck(
            $shopRealizationReturnID, $fiscalCheck->getGoodsList(), $sitePageData, $driver
        );

        // печать чека
        return Drivers_CashRegister_RemoteComputerAura3::printReturnFiscalCheck(
            'realization_return_'.$shopRealizationReturnID, $paidAmount, $fiscalCheck, $sitePageData
        );
    }

    /**
     * Возврат реализации продуктов на заданный период
     * @param $dateFrom
     * @param $dateTo
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @param null $shopWriteOffTypeID
     * @param int | null $shopProductID
     * @return array
     */
    public static function returnShopProductPeriod($dateFrom, $dateTo, SitePageData $sitePageData,
                                                   Model_Driver_DBBasicDriver $driver, $shopWriteOffTypeID = NULL,
                                                   $shopProductID = null)
    {
        $shopProductIDs = array();

        /** Считаем возврат реализации продуктов **/
        $params = Request_RequestParams::setParams(
            array(
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
        $ids = Request_Request::find('DB_Magazine_Shop_Realization_Return_Item',
            $sitePageData->shopID, $sitePageData, $driver, $params, 0, TRUE,
            array('shop_production_id' => array('coefficient', 'shop_product_id'))
        );
        foreach ($ids->childs as $child){
            $shopProductID = $child->getElementValue('shop_production_id', 'shop_product_id', 0);
            if(!key_exists($shopProductID, $shopProductIDs)){
                $shopProductIDs[$shopProductID] = 0;
            }
            $shopProductIDs[$shopProductID] += $child->values['quantity'] / $child->getElementValue('shop_production_id', 'coefficient', 1);
        }

        return $shopProductIDs;
    }

    /**
     * Возврат реализации продукции собственного производства на заданный период
     * @param $dateFrom
     * @param $dateTo
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @param null $shopWriteOffTypeID
     * @param int | null $shopProductionID
     * @return array
     */
    public static function returnShopProductionPeriod($dateFrom, $dateTo, SitePageData $sitePageData,
                                                      Model_Driver_DBBasicDriver $driver, $shopWriteOffTypeID = NULL,
                                                      $shopProductionID = null)
    {
        $shopProductionIDs = array();

        /** Считаем возврат реализации продуктов **/
        $params = Request_RequestParams::setParams(
            array(
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
        $ids = Request_Request::find('DB_Magazine_Shop_Realization_Return_Item',
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
     * Удаление возврата реализации
     * Восстановление не возможно
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

        $model = new Model_Magazine_Shop_Realization_Return();
        $model->setDBDriver($driver);

        if (!Helpers_DB::dublicateObjectLanguage($model, $id, $sitePageData)) {
            throw new HTTP_Exception_500('Realization return not found.');
        }

        if (($isUnDel && !$model->getIsDelete()) or (!$isUnDel && $model->getIsDelete())){
            return FALSE;
        }

        if($isUnDel){
            $params = Request_RequestParams::setParams(
                array(
                    'shop_production_return_id' => $id,
                    'is_delete' => 1,
                    'is_public' => FALSE,
                )
            );
            $ids = Request_Request::find('DB_Magazine_Shop_Realization_Return_Item', 
                $sitePageData->shopID, $sitePageData, $driver, $params, 0, TRUE,
                array(
                    'shop_production_return_id' => array('shop_product_id'),
                )
            );
            $driver->unDeleteObjectIDs(
                $ids->getChildArrayID(), $sitePageData->userID, Model_Magazine_Shop_Realization_Return_Item::TABLE_NAME,
                array('is_public' => 1), $sitePageData->shopID
            );

            $model->dbUnDelete($sitePageData->userID, 0, $sitePageData->shopID);
        }else {
            $params = Request_RequestParams::setParams(
                array(
                    'shop_production_return_id' => $id,
                    'is_delete' => 0,
                    'is_public' => TRUE,
                )
            );
            $ids = Request_Request::find('DB_Magazine_Shop_Realization_Return_Item', 
                $sitePageData->shopID, $sitePageData, $driver, $params, 0, TRUE,
                array(
                    'shop_production_id' => array('shop_product_id'),
                )
            );
            $driver->deleteObjectIDs(
                $ids->getChildArrayID(), $sitePageData->userID, Model_Magazine_Shop_Realization_Return_Item::TABLE_NAME,
                array('is_public' => 0), $sitePageData->shopID
            );

            $model->dbDelete($sitePageData->userID, 0, $sitePageData->shopID);
        }

        foreach ($ids->childs as $child){
            // расход продуктов
            Api_Magazine_Shop_Product::calcComing(
                $child->getElementValue('shop_production_id', 'shop_product_id'),
                $sitePageData, $driver, TRUE
            );
            // расход продукции
            Api_Magazine_Shop_Production::calcComing(
                $child->values['shop_production_id'], $sitePageData, $driver, TRUE
            );
        }

        return true;
    }

    /**
     * Сохранение
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @return array
     * @throws HTTP_Exception_500
     */
    public static function save(SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        $model = new Model_Magazine_Shop_Realization_Return();
        $model->setDBDriver($driver);

        $id = Request_RequestParams::getParamInt('id');
        if($id > 0) {
            if (!Helpers_DB::dublicateObjectLanguage($model, $id, $sitePageData)) {
                throw new HTTP_Exception_500('Realization return not found.');
            }
        }
        Request_RequestParams::setParamBoolean('is_public', $model);
        Request_RequestParams::setParamStr('text', $model);
        Request_RequestParams::setParamStr('name', $model);
        Request_RequestParams::setParamStr("old_id", $model);

        $options = Request_RequestParams::getParamArray('options');
        if ($options !== NULL) {
            $model->addOptionsArray($options);
        }

        $shopRealizationReturnItems = Request_RequestParams::getParamArray('shop_realization_return_items');
        if($shopRealizationReturnItems !== NULL) {
            $model->setAmount(0);
        }

        $result = array();
        $fiscalResult = null;
        if ($model->validationFields($result)) {
            if(Func::_empty($model->getNumber())){
                $n = Database::instance()->query(Database::SELECT, 'SELECT nextval(\'sp_number_realization_return_s'.$sitePageData->shopID.'\') as id;')->as_array(NULL, 'id')[0];
                $n = '0000000'.$n;
                $n = substr($n, strlen($n) - 8);
                $model->setNumber($n);
            }

            if($model->id < 1) {
                Helpers_DB::saveDBObject($model, $sitePageData);
            }

            // загружаем фотографии
            $file = new Model_File($sitePageData);
            $file->saveFiles(Request_RequestParams::getParamArray('files'), $model, $sitePageData, $driver);

            // сохраняем товары
            if($shopRealizationReturnItems !== NULL) {
                $arr = Api_Magazine_Shop_Realization_Return_Item::save(
                    $model, $shopRealizationReturnItems, $sitePageData, $driver
                );
                $model->setAmount($arr['amount']);
                $model->setQuantity($arr['quantity']);
            }

            Helpers_DB::saveDBObject($model, $sitePageData);

            // печать фискального чека
            if(!$model->getIsFiscalCheck()){
                $fiscalResult = self::printReturnFiscalCheck($model->getAmount(), $model->id, $sitePageData, $driver);
                if(array($fiscalResult)){
                    $model->setFiscalCheck(Arr::path($fiscalResult, 'number', ''));

                    if (!$model->getIsFiscalCheck()) {
                        $fiscalResult['status'] = false;
                    }

                    $model->setShopCashboxID($sitePageData->operation->getShopCashboxID());
                }
            }

            $result['values'] = $model->getValues();
        }

        return array(
            'id' => $model->id,
            'result' => $result,
            'fiscal_result' => $fiscalResult,
        );
    }

    /**
     * Сохраняем возврат реализации в виде XML
     * Реализация наличные / по карте АБ1 / по банковской карте / Возмещение
     * @param $dateFrom
     * @param $dateTo
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @param bool $isPHPOutput
     * @return string
     */
    public static function saveXML($dateFrom, $dateTo, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver, $isPHPOutput = FALSE)
    {
        // получаем список реализаций
        $params = Request_RequestParams::setParams(
            array(
                'created_at_from' => $dateFrom,
                'created_at_to' => $dateTo,
            )
        );
        $shopRealizationReturnItemIDs = Request_Request::find('DB_Magazine_Shop_Realization_Return_Item', 
            $sitePageData->shopID, $sitePageData, $driver,
            $params, 0, TRUE,
            array(
                'shop_production_id' => array('name', 'old_id', 'shop_product_id'),
                'unit_id' => array('name', 'old_id'),
                'shop_id' => array('old_id'),
            )
        );

        // группируем по реализациям
        $shopRealizationReturns = array();
        foreach($shopRealizationReturnItemIDs->childs as $child){
            $id = $child->values['shop_realization_return_id'];
            if(!key_exists($id, $shopRealizationReturns)){
                $shopRealizationReturns[$id] = array(
                    'value' => $child,
                    'data' => array(),
                );
            }

            $shopRealizationReturns[$id]['data'][] = $child;
        }

        $data = '<?xml version="1.0" encoding="UTF-8"?><data>';
        foreach($shopRealizationReturns as $child){
            $realization = $child['value'];

            $data .= '<realization_return>'
                . '<branch>'.$realization->getElementValue('shop_id', 'old_id').'</branch>'
                . '<id>'.$realization->values['id'].'</id>'
                . '<date>'.strftime('%d.%m.%Y %H:%M:%S', strtotime($realization->values['created_at'])).'</date>'
                . '<amount>'.Api_Tax_NDS::getAmountWithoutNDS($realization->values['amount']).'</amount>'
                . '<amountNDS>'.round($realization->values['amount'] / (100 + Api_Tax_NDS::getNDS()) * Api_Tax_NDS::getNDS(), 2).'</amountNDS>';

            $data .= '<goodsList>';
            /** @var MyArray $item */
            foreach ($child['data'] as $item){
                $data .= '<goods>'
                    . '<id>' . $item->getElementValue('shop_production_id', 'shop_product_id', $item->values['shop_production_id']) . '</id>'
                    . '<name>' . htmlspecialchars($item->getElementValue('shop_production_id'), ENT_XML1) . '</name>'
                    . '<unit>' . $item->getElementValue('unit_id', 'old_id') . '</unit>'
                    . '<unit_name>' . htmlspecialchars($item->getElementValue('unit_id'), ENT_XML1) . '</unit_name>'
                    . '<quantity>' . $item->values['quantity'] . '</quantity>'
                    . '<price>' . $item->values['price'] . '</price>'
                    . '<amount>' . Api_Tax_NDS::getAmountWithoutNDS($item->values['amount']) . '</amount>'
                    . '<amountNDS>' . Api_Tax_NDS::getAmountNDS($item->values['amount']) . '</amountNDS>'
                    .'</goods>';
            }

            $data .= '</goodsList>';

            $data .= '</realization_return>';
        }
        $data .= '</data>';

        if($isPHPOutput) {
            header('Content-Type: text/xml');
            header('Content-Disposition: attachment;filename="magazine_realization_return.xml"');
            header('Cache-Control: max-age=0');

            echo $data;
            exit();
        }

        return $data;
    }
}
