<?php defined('SYSPATH') or die('No direct script access.');

class Api_Magazine_Shop_Invoice
{
    /**
     * удаление
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @return bool
     * @throws HTTP_Exception_500
     */
    public static function delete(SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        $id = Request_RequestParams::getParamInt('id');
        if ($id < 0) {
            return FALSE;
        }
        $isUnDel = Request_RequestParams::getParamBoolean("is_undel");

        $model = new Model_Magazine_Shop_Invoice();
        $model->setDBDriver($driver);

        if (!Helpers_DB::dublicateObjectLanguage($model, $id, $sitePageData)) {
            throw new HTTP_Exception_500('Invoice not found.');
        }

        if ($isUnDel) {
            throw new HTTP_Exception_500('Undelete error.');
        }

        if (!$isUnDel && $model->getIsDelete()) {
            return FALSE;
        }

        // удаляем ссылки на счет-фактуру
        $driver->sendSQL('UPDATE sp_shop_realization_items SET shop_invoice_id = 0 WHERE shop_invoice_id='.$model->id);
        // удаляем детвору счет-фактуры
        $driver->sendSQL('UPDATE sp_shop_invoice_items SET is_public = 0, is_delete = 1, delete_user_id = '.$sitePageData->userID.' WHERE shop_invoice_id='.$model->id);
        // удаляем ГТД детворы счет-фактуры
        $driver->sendSQL('UPDATE sp_shop_invoice_item_gtds SET is_public = 0, is_delete = 1, delete_user_id = '.$sitePageData->userID.' WHERE shop_invoice_id='.$model->id);

        // запустить пересчет количество остатков ГТД приемки из реализованных продуктов
        Api_Magazine_Shop_Receive_Item_GTD::calcQuantityInvoice(
            $model->id, $sitePageData, $driver
        );

        $model->dbDelete($sitePageData->userID, 0, $sitePageData->shopID);

        return TRUE;
    }

    /**
     * Получаем список реализации, у которой удалось определить ЭСФ приемки
     * @param $dateFrom
     * @param $dateTo
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @param int | array | null $shopReceiveEsfTypeID
     * @return MyArray
     */
    public static function getShopRealizationItemsByReceiveESF($dateFrom, $dateTo, SitePageData $sitePageData,
                                                               Model_Driver_DBBasicDriver $driver, $shopReceiveEsfTypeID = null)
    {
        if(($dateFrom === NULL) or ($dateTo === NULL)){
            return new MyArray();
        }

        $params = Request_RequestParams::setParams(
            array(
                'created_at_from' => $dateFrom,
                'created_at_to' => Helpers_DateTime::plusDays($dateTo, 1),
                'shop_invoice_id' => 0,
                'not_shop_write_off_type_id' => array(
                    Model_Magazine_Shop_WriteOff_Type::WRITE_OFF_TYPE_BY_STANDART,
                    Model_Magazine_Shop_WriteOff_Type::WRITE_OFF_TYPE_OVER_THE_NORM,
                    Model_Magazine_Shop_WriteOff_Type::WRITE_OFF_TYPE_RECEPTION,
                ),
                'sort_by' => array('shop_production_id.name' => 'asc'),
            )
        );
        $shopRealizationItemIDs = Request_Request::find('DB_Magazine_Shop_Realization_Item',
            $sitePageData->shopID, $sitePageData, $driver, $params, 0, TRUE,
            array('shop_production_id' => array('name', 'barcode', 'shop_product_id'))
        );

        /**********************************************/
        /** Список ГТД прихода необходимых нам продуктов **/
        /**********************************************/
        $shopProductIDs = $shopRealizationItemIDs->getChildArrayInt(Model_Basic_BasicObject::FIELD_ELEMENTS . '.shop_production_id.shop_product_id', TRUE);
        if(empty($shopProductIDs)){
            return new MyArray();
        }

        $shopReceiveItemGTDs = Api_Magazine_Shop_Receive_Item_GTD::getGTDsGroupByProducts(
            $shopProductIDs, $sitePageData, $driver, $shopReceiveEsfTypeID
        );

        // исключаем все реализации, которые без ЭСФ приемки
        $amountAll = 0;
        $quantityAll = 0;
        foreach($shopRealizationItemIDs->childs as $key => $child){
            $shopProductID = $child->getElementValue('shop_production_id', 'shop_product_id');

            // если это собственного производство (временно)
            if($shopProductID == 0){
                $amountAll += $child->values['amount'];
                $quantityAll += $child->values['quantity'];

                continue;
            }

            if(!key_exists($shopProductID, $shopReceiveItemGTDs)){
                unset($shopRealizationItemIDs->childs[$key]);
                continue;
            }

            $quantity = $child->values['quantity'];
            if($shopReceiveItemGTDs[$shopProductID]['quantity_balance'] < $quantity){
                unset($shopRealizationItemIDs->childs[$key]);
                continue;
            }

            $shopReceiveItemGTDs[$shopProductID]['quantity_balance'] -= $quantity;

            $amountAll += $child->values['amount'];
            $quantityAll += $quantity;
        }

        $shopRealizationItemIDs->additionDatas['amount'] = $amountAll;
        $shopRealizationItemIDs->additionDatas['quantity'] = $quantityAll;

        return $shopRealizationItemIDs;
    }

    /**
     * Получаем список реализации сгруппированной по цене продукции, у которой удалось определить ЭСФ приемки
     * @param $dateFrom
     * @param $dateTo
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @param int | array | null $shopReceiveEsfTypeID
     * @return MyArray
     */
    public static function getShopRealizationItemsByReceiveESFGroupProduction($dateFrom, $dateTo, SitePageData $sitePageData,
                                                               Model_Driver_DBBasicDriver $driver, $shopReceiveEsfTypeID = null)
    {
        if(($dateFrom === NULL) or ($dateTo === NULL)){
            $data = new MyArray();
            $data->additionDatas['amount'] = 0;
            $data->additionDatas['quantity'] = 0;
            $data->additionDatas['total_amount'] = 0;
            $data->additionDatas['total_quantity'] = 0;

            return $data;
        }

        $params = Request_RequestParams::setParams(
            array(
                'created_at_from' => $dateFrom,
                'created_at_to' => Helpers_DateTime::plusDays($dateTo, 1),
                'not_shop_write_off_type_id' => array(
                    Model_Magazine_Shop_WriteOff_Type::WRITE_OFF_TYPE_BY_STANDART,
                    Model_Magazine_Shop_WriteOff_Type::WRITE_OFF_TYPE_OVER_THE_NORM,
                    Model_Magazine_Shop_WriteOff_Type::WRITE_OFF_TYPE_RECEPTION,
                ),
                'sum_amount' => TRUE,
                'sum_quantity' => TRUE,
                'sum_esf_receive_quantity' => TRUE,
                'sort_by' => array('shop_production_id.name' => 'asc'),
                'group_by' => array(
                    'price', 'shop_invoice_id',
                    'shop_production_id', 'shop_production_id.name', 'shop_production_id.barcode', 'shop_production_id.shop_product_id',
                ),
            )
        );
        $shopRealizationItemIDs = Request_Request::find('DB_Magazine_Shop_Realization_Item',
            $sitePageData->shopID, $sitePageData, $driver, $params, 0, TRUE,
            array('shop_production_id' => array('name', 'barcode', 'shop_product_id'))
        );

        /**********************************************/
        /** Список ГТД прихода необходимых нам продуктов **/
        /**********************************************/
        $shopProductIDs = $shopRealizationItemIDs->getChildArrayInt(Model_Basic_BasicObject::FIELD_ELEMENTS . '.shop_production_id.shop_product_id', TRUE);
        if(empty($shopProductIDs)){
            $data = new MyArray();
            $data->additionDatas['amount'] = 0;
            $data->additionDatas['quantity'] = 0;
            $data->additionDatas['total_amount'] = 0;
            $data->additionDatas['total_quantity'] = 0;

            return $data;
        }

        $shopReceiveItemGTDs = Api_Magazine_Shop_Receive_Item_GTD::getGTDsGroupByProducts(
            $shopProductIDs, $sitePageData, $driver, $shopReceiveEsfTypeID
        );

        // исключаем все реализации, которые без ЭСФ приемки
        $amountAll = 0;
        $quantityAll = 0;
        $amountSplit = 0;
        $quantitySplit = 0;
        foreach($shopRealizationItemIDs->childs as $key => $child){
            $quantity = $child->values['quantity'];
            $amount = $child->values['amount'];

            $amountAll += $amount;
            $quantityAll += $quantity;

            $shopProductID = $child->getElementValue('shop_production_id', 'shop_product_id');

            // если это собственного производство (временно)
            if($shopProductID == 0){
                $amountAll += $child->values['amount'];
                $quantityAll += $child->values['quantity'];

                continue;
            }

            if(!key_exists($shopProductID, $shopReceiveItemGTDs)){
                unset($shopRealizationItemIDs->childs[$key]);
                continue;
            }

            $quantity = $child->values['quantity'];
            if($shopReceiveItemGTDs[$shopProductID]['quantity_balance'] < $quantity){
                unset($shopRealizationItemIDs->childs[$key]);
                continue;
            }

            $shopReceiveItemGTDs[$shopProductID]['quantity_balance'] -= $quantity;

            $amountSplit += $amount;
            $quantitySplit += $quantity;
        }

        $shopRealizationItemIDs->additionDatas['amount'] = $amountSplit;
        $shopRealizationItemIDs->additionDatas['quantity'] = $quantitySplit;
        $shopRealizationItemIDs->additionDatas['total_amount'] = $amountAll;
        $shopRealizationItemIDs->additionDatas['total_quantity'] = $quantityAll;

        return $shopRealizationItemIDs;
    }

    /**
     * Сохранение списка счетов-фактур нового периода возврата
     * Может быть несколько ЭСФ, к которым придется привязать возврат
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @return array
     * @throws HTTP_Exception_500
     */
    public static function saveReturnNewList(SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {

        $dateFrom = Request_RequestParams::getParamDate("date_from");
        $dateTo = Request_RequestParams::getParamDate("date_to");

        // Получаем список продукции возврата на заданный период
        $params = Request_RequestParams::setParams(
            array(
                'created_at_from' => $dateFrom,
                'created_at_to' => Helpers_DateTime::plusDays($dateTo, 1),
                'shop_invoice_id' => 0,
            )
        );
        $shopRealizationReturnItemIDs = Request_Request::find('DB_Magazine_Shop_Realization_Return_Item',
            $sitePageData->shopID, $sitePageData, $driver, $params
        );

        if(count($shopRealizationReturnItemIDs->childs) < 1){
            return array();
        }

        // Получаем список ГТД ЭСФ, в котором есть заданая продукция
        $params = Request_RequestParams::setParams(
            array(
                'shop_production_id' => $shopRealizationReturnItemIDs->getChildArrayInt('shop_production_id', true),
                'esf_type_id' => array(
                    0,
                    Model_Magazine_ESFType::ESF_TYPE_ELECTRONIC,
                    Model_Magazine_ESFType::ESF_TYPE_AWAITING_RECEIPT
                ),
                'sort_by' => array(
                    'shop_invoice_id' => 'desc',
                    'quantity' => 'desc',
                ),
            )
        );
        $shopInvoiceItemGTDIDs = Request_Request::find(
            'DB_Magazine_Shop_Invoice_Item_GTD',
            $sitePageData->shopID, $sitePageData, $driver, $params
        );
        // группируем ГТД ЭСФ по продукции
        $productionGroups = $shopInvoiceItemGTDIDs->childsGroupBy('shop_production_id');

        if(count($productionGroups) < 1){
            return array();
        }

        // получаем список привязки ЭСФ к списку продукции возвратной ЭСФ
        $shopInvoices = array();
        foreach ($shopRealizationReturnItemIDs->childs as $child){
            $shopProductionID = $child->values['shop_production_id'];

            if(! key_exists($shopProductionID, $productionGroups)){
                continue;
            }

            $quantity = $child->values['quantity'];
            foreach ($productionGroups[$shopProductionID] as $key => $productionGroup){
                $shopInvoice = $productionGroup->values['shop_invoice_id'];

                if(!key_exists($shopInvoice, $shopInvoices)){
                    $shopInvoices[$shopInvoice] = [];
                }
                $shopInvoices[$shopInvoice][] = $child->id;

                if($productionGroup->values['quantity'] > $quantity){
                    $productionGroup->values['quantity'] -= $quantity;
                    break;
                }

                if($productionGroup->values['quantity'] == $quantity){
                    unset($productionGroups[$shopProductionID][$key]);
                    break;
                }

                $quantity -= $productionGroup->values['quantity'];
                if($quantity < 0.0001){
                    break;
                }
            }
        }

        // создаем ЭСФ возврата
        $shopInvoiceIDs = array();
        foreach ($shopInvoices as $shopInvoiceID => $shopRealizationReturnItemIDs){
            $shopInvoiceIDs[] = self::saveReturnNewOne(
                $shopInvoiceID, $shopRealizationReturnItemIDs, $dateFrom, $dateTo, $sitePageData, $driver
            );
        }

        return $shopInvoiceIDs;
    }


    /**
     * Сохранение счет-фактуру для заданного списка продукции возврата
     * @param $shopInvoiceID
     * @param array $shopRealizationReturnItemIDs
     * @param $dateFrom
     * @param $dateTo
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @return array
     * @throws HTTP_Exception_500
     */
    public static function saveReturnNewOne($shopInvoiceID, array $shopRealizationReturnItemIDs, $dateFrom, $dateTo,
                                            SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        if(count($shopRealizationReturnItemIDs) < 1){
            return false;
        }

        $model = new Model_Magazine_Shop_Invoice();
        $model->setDBDriver($driver);

        $model->setDateFrom($dateFrom);
        $model->setDateTo($dateTo);
        $model->setESFTypeID(Model_Magazine_ESFType::ESF_TYPE_RETURN);
        $model->setShopInvoiceID($shopInvoiceID);

        Request_RequestParams::setParamBoolean('is_public', $model);
        Request_RequestParams::setParamStr('text', $model);
        Request_RequestParams::setParamStr('name', $model);
        Request_RequestParams::setParamDate("date", $model);
        Request_RequestParams::setParamDate("esf_date", $model);

        $options = Request_RequestParams::getParamArray('options');
        if ($options !== NULL) {
            $model->addOptionsArray($options);
        }

        $result = array();
        if ($model->validationFields($result)) {
            $n = Database::instance()->query(Database::SELECT, 'SELECT nextval(\'sp_number_invoice_' . $sitePageData->shopID . '\') as id;')->as_array(NULL, 'id')[0];
            $n = '0000000' . $n;
            $n = substr($n, strlen($n) - 8);
            $model->setNumber($n);

            Helpers_DB::saveDBObject($model, $sitePageData);

            // получаем список продукции возврата, для которого необходимо сделать ЭСФ
            $params = Request_RequestParams::setParams(
                array(
                    'id' => $shopRealizationReturnItemIDs,
                )
            );
            $shopRealizationReturnItemIDs = Request_Request::find(
                'DB_Magazine_Shop_Realization_Return_Item',
                $sitePageData->shopID, $sitePageData, $driver, $params, 0, true,
                array('shop_production_id' => array('shop_product_id'))
            );

            // Получаем список ГТД ЭСФ, в котором есть заданая продукция
            $params = Request_RequestParams::setParams(
                array(
                    'shop_production_id' => $shopRealizationReturnItemIDs->getChildArrayInt('shop_production_id', true),
                    'shop_invoice_id' => $shopInvoiceID,
                    'sort_by' => array(
                        'shop_invoice_id' => 'desc',
                        'quantity' => 'desc',
                    ),
                )
            );
            $shopInvoiceItemGTDIDs = Request_Request::find('DB_Magazine_Shop_Invoice_Item_GTD',
                $sitePageData->shopID, $sitePageData, $driver, $params
            );
            $shopInvoiceItemGTDs = $shopInvoiceItemGTDIDs->childsGroupBy('shop_production_id');

            // добавляем ссылки на счет-фактуру
            $driver->updateObjects(
                Model_Magazine_Shop_Realization_Return_Item::TABLE_NAME, $shopRealizationReturnItemIDs->getChildArrayID(),
                array('shop_invoice_id' => $model->id), 0, $sitePageData->shopID
            );

            // создаем привязки продукции возврата и ЭСФ
            $modelInvoiceItem = new Model_Magazine_Shop_Invoice_Item();
            $modelInvoiceItem->setDBDriver($driver);

            $modelReturnItem = new Model_Magazine_Shop_Realization_Return_Item();
            $modelReturnItem->setDBDriver($driver);

            $amountAll = 0;
            $quantityAll = 0;

            foreach ($shopRealizationReturnItemIDs->childs as $child){
                $child->setModel($modelReturnItem);

                $modelInvoiceItem->setShopInvoiceID($model->id);
                $modelInvoiceItem->setShopRealizationReturnItemID($modelReturnItem->id);

                $modelInvoiceItem->setShopProductID($child->getElementValue('shop_production_id', 'shop_product_id', 0));
                $modelInvoiceItem->setShopProductionID($modelReturnItem->getShopProductionID());
                $modelInvoiceItem->setQuantity($modelReturnItem->getQuantity());
                $modelInvoiceItem->setESFQuantity($modelReturnItem->getQuantity());
                $modelInvoiceItem->setPrice($modelReturnItem->getPrice());
                Helpers_DB::saveDBObject($modelInvoiceItem, $sitePageData, $modelReturnItem->shopID);

                $modelReturnItem->setESFReceiveQuantity($modelReturnItem->getQuantity());
                $modelReturnItem->setIsESF(TRUE);
                Helpers_DB::saveDBObject($modelReturnItem, $sitePageData, $modelReturnItem->shopID);

                $list = array();
                $quantity = $modelInvoiceItem->getQuantity();
                $shopProductionID = $modelReturnItem->getShopProductionID();
                /**
                 * находим подходящие ГТД продукции основной ЭСФ
                 * @var string $key
                 * @var Model_Magazine_Shop_Receive_Item_GTD $child
                 */
                foreach ($shopInvoiceItemGTDs[$shopProductionID] as $key => $child){

                    if($quantity >= $child->values['quantity']){
                        // если вся строчка подходит
                        $quantity -= $child->values['quantity'];
                        $list[] = $child;
                        unset($shopInvoiceItemGTDs[$shopProductionID][$key]);

                        if($quantity == 0){
                            break;
                        }
                    }else{
                        // если не вся строчка подходит
                        $t = $child->values['quantity'] - $quantity;

                        $tmp = new MyArray();
                        $tmp->values = $child->values;
                        $tmp->values['quantity'] = $quantity;
                        $list[] = $tmp;

                        $child->values['quantity'] = $t;
                        break;
                    }
                }

                $modelInvoiceItemGTD = new Model_Magazine_Shop_Invoice_Item_GTD();
                $modelInvoiceItemGTD->setDBDriver($driver);

                /**
                 * @var MyArray $child - сохранены список ГТД прихода
                 */
                foreach ($list as $child) {
                    $child->setModel($modelInvoiceItemGTD);
                    $modelInvoiceItemGTD->id = 0;
                    $modelInvoiceItemGTD->globalID = 0;

                    $modelInvoiceItemGTD->setPriceRealization($modelReturnItem->getPrice());
                    $modelInvoiceItemGTD->setShopInvoiceID($model->id);
                    $modelInvoiceItemGTD->setShopInvoiceItemID($modelInvoiceItem->id);
                    $modelInvoiceItemGTD->setShopRealizationReturnItemID($modelReturnItem->id);

                    $amountAll = $amountAll + $modelInvoiceItemGTD->getAmountRealization();
                    $quantityAll = $quantityAll + $modelInvoiceItemGTD->getQuantity();
                }
            }

            $model->setIsESFReceive(true);
            $model->setAmount($amountAll);
            $model->setQuantity($quantityAll);

            // запустить пересчет количество остатков ГТД приемки из реализованных продуктов c учетом текущей счета фактуры
            Api_Magazine_Shop_Receive_Item_GTD::calcQuantityInvoice(
                $model->id, $sitePageData, $driver
            );

            // загружаем фотографии
            $file = new Model_File($sitePageData);
            $file->saveFiles(Request_RequestParams::getParamArray('files'), $model, $sitePageData, $driver);

            Helpers_DB::saveDBObject($model, $sitePageData);
            $result['values'] = $model->getValues();
        }

        return $model->id;
    }

    /**
     * Сохранение нового периода
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @return array
     * @throws HTTP_Exception_500
     */
    public static function saveNew(SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        $model = new Model_Magazine_Shop_Invoice();
        $model->setDBDriver($driver);

        $id = Request_RequestParams::getParamInt('id');
        if($id > 0) {
            if (!Helpers_DB::dublicateObjectLanguage($model, $id, $sitePageData)) {
                throw new HTTP_Exception_500('Invoice not found.');
            }
        }

        Request_RequestParams::setParamBoolean('is_public', $model);
        Request_RequestParams::setParamStr('text', $model);
        Request_RequestParams::setParamStr('name', $model);
        Request_RequestParams::setParamStr("old_id", $model);
        Request_RequestParams::setParamStr("number_esf", $model);
        Request_RequestParams::setParamStr("number", $model);
        Request_RequestParams::setParamDate("date_from", $model);
        Request_RequestParams::setParamDate("date_to", $model);
        Request_RequestParams::setParamDate("date", $model);

        $tmp = Request_RequestParams::getParamIntOrArray('esf_type_id');
        if($tmp != null){
            $model->setESFTypeID($tmp);
        }

        $options = Request_RequestParams::getParamArray('options');
        if ($options !== NULL) {
            $model->addOptionsArray($options);
        }

        $result = array();
        if ($model->validationFields($result)) {
            if($model->id < 1) {
                $n = Database::instance()->query(Database::SELECT, 'SELECT nextval(\'sp_number_invoice_' . $sitePageData->shopID . '\') as id;')->as_array(NULL, 'id')[0];
                $n = '0000000' . $n;
                $n = substr($n, strlen($n) - 8);
                $model->setNumber($n);

                Helpers_DB::saveDBObject($model, $sitePageData);
            }else{
                // удаляем ссылки на счет-фактуру
                $driver->sendSQL('UPDATE sp_shop_realization_items SET shop_invoice_id = 0 WHERE shop_invoice_id='.$model->id);

                // запустить пересчет количество остатков ГТД приемки из реализованных продуктов без учета текущей счета фактуры
                Api_Magazine_Shop_Receive_Item_GTD::calcQuantityInvoice(
                    $model->id, $sitePageData, $driver, $model->id
                );
            }

            // Получаем список реализации сгруппированной по цене продукции, у которой удалось определить ЭСФ приемки
            $params = Request_RequestParams::setParams(
                array(
                    'created_at_from' => $model->getDateFrom(),
                    'created_at_to' => Helpers_DateTime::plusDays($model->getDateTo(), 1),
                    'shop_invoice_id' => 0,
                    'not_shop_write_off_type_id' => array(
                        Model_Magazine_Shop_WriteOff_Type::WRITE_OFF_TYPE_BY_STANDART,
                        Model_Magazine_Shop_WriteOff_Type::WRITE_OFF_TYPE_OVER_THE_NORM,
                        Model_Magazine_Shop_WriteOff_Type::WRITE_OFF_TYPE_RECEPTION,
                    ),
                    'sort_by' => array('shop_production_id.name' => 'asc'),
                )
            );
            $shopRealizationItemIDs = Request_Request::find('DB_Magazine_Shop_Realization_Item',
                $sitePageData->shopID, $sitePageData, $driver, $params, 0, TRUE,
                array('shop_production_id' => array('name', 'barcode', 'shop_product_id'))
            );

            // добавляем ссылки на счет-фактуру
            $driver->updateObjects(
                Model_Magazine_Shop_Realization_Item::TABLE_NAME, $shopRealizationItemIDs->getChildArrayID(),
                array('shop_invoice_id' => $model->id), 0, $sitePageData->shopID
            );

            $model->setIsCalcESF(Request_RequestParams::getParamBoolean('is_esf'));

            // сохранение связей прихода и реализации
            $total = Api_Magazine_Shop_Invoice_Item::save(
                $model, $sitePageData, $driver, $model->getIsCalcESF()
            );

            if(is_array($total)){
                $model->setIsESFReceive($total['is_esf']);
                $model->setQuantity($total['quantity']);
                $model->setAmount($total['amount']);
            }else{
                $model->setIsESFReceive(FALSE);
                $model->setQuantity(0);
                $model->setAmount(0);
            }

            // запустить пересчет количество остатков ГТД приемки из реализованных продуктов c учетом текущей счета фактуры
            Api_Magazine_Shop_Receive_Item_GTD::calcQuantityInvoice(
                $model->id, $sitePageData, $driver
            );

            // загружаем фотографии
            $file = new Model_File($sitePageData);
            $file->saveFiles(Request_RequestParams::getParamArray('files'), $model, $sitePageData, $driver);

            Helpers_DB::saveDBObject($model, $sitePageData);
            $result['values'] = $model->getValues();
        }

        return array(
            'id' => $model->id,
            'result' => $result,
        );
    }

    /**
     * Сохранение текущего периода
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @return array
     * @throws HTTP_Exception_500
     */
    public static function save(SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        $model = new Model_Magazine_Shop_Invoice();
        $model->setDBDriver($driver);

        $id = Request_RequestParams::getParamInt('id');
        if (!Helpers_DB::dublicateObjectLanguage($model, $id, $sitePageData, -1, FALSE)) {
            throw new HTTP_Exception_500('Invoice not found.');
        }

        Request_RequestParams::setParamBoolean('is_public', $model);
        Request_RequestParams::setParamStr('text', $model);
        Request_RequestParams::setParamStr('name', $model);
        Request_RequestParams::setParamStr("old_id", $model);
        Request_RequestParams::setParamStr("number_esf", $model);
        Request_RequestParams::setParamStr("number", $model);
        Request_RequestParams::setParamDate("date_from", $model);
        Request_RequestParams::setParamDate("date_to", $model);
        Request_RequestParams::setParamDate("date", $model);
        Request_RequestParams::setParamDate("esf_date", $model);

        $esfTypeID = Request_RequestParams::getParamInt('esf_type_id');
        if($esfTypeID !== null) {
            $model->setESFTypeID($esfTypeID);
        }

        $options = Request_RequestParams::getParamArray('options');
        if ($options !== NULL) {
            $model->addOptionsArray($options);
        }

        $result = array();
        if ($model->validationFields($result)) {
            if(Func::_empty($model->getNumber())){
                $n = Database::instance()->query(Database::SELECT, 'SELECT nextval(\'sp_number_invoice_'.$sitePageData->shopID.'\') as id;')->as_array(NULL, 'id')[0];
                $n = '0000000'.$n;
                $n = substr($n, strlen($n) - 8);
                $model->setNumber($n);
            }

            $total = Api_Magazine_Shop_Invoice_Item::calcTotal($model->id, $sitePageData, $driver);
            $model->setQuantity($total['quantity']);
            $model->setAmount($total['amount']);

            // загружаем фотографии
            $file = new Model_File($sitePageData);
            $file->saveFiles(Request_RequestParams::getParamArray('files'), $model, $sitePageData, $driver);

            Helpers_DB::saveDBObject($model, $sitePageData);
            $result['values'] = $model->getValues();
        }

        return array(
            'id' => $model->id,
            'result' => $result,
        );
    }

    /**
     * Получаю возвратной счета фактуры ЭСФ в виде XML
     * @param Model_Magazine_Shop_Invoice $model
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @return string
     */
    public static function _getReturnEFSXML(Model_Magazine_Shop_Invoice $model, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        $modelRoot = new Model_Magazine_Shop_Invoice();
        $modelRoot->setDBDriver($driver);

        if (!Helpers_DB::getDBObject($modelRoot, $model->getShopInvoiceID(), $sitePageData, -1)) {
            throw new HTTP_Exception_500('Root invoice not found.');
        }

        $data =
            '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>'
            . '<esf:invoiceContainer xmlns:esf="namespace.esf" xmlns:a="namespace.abstractInvoice" xmlns:v1="namespace.v1" xmlns:v2="namespace.v2">'
            . '<invoiceSet>'
            . '<v2:invoice xmlns:a="abstractInvoice.esf" xmlns:v2="v2.esf">'
            . '<date>' . Helpers_DateTime::getDateFormatRus($model->getESFDate()) . '</date>'
            . '<invoiceType>ADDITIONAL_INVOICE</invoiceType>'
            . '<num>' . $model->getNumber() . '</num>'
            . '<operatorFullname>ИСЛАМОВ ВАРИС АБУБАКИРОВИЧ</operatorFullname>'

            . '<relatedInvoice>'
            . '<date>' . Helpers_DateTime::getDateFormatRus($modelRoot->getESFDate()) . '</date>'
            . '<num>' . $modelRoot->getNumber() . '</num>'
            . '<registrationNumber>' . $modelRoot->getNumberESF() . '</registrationNumber>'
            . '</relatedInvoice>'

            . '<turnoverDate>' . Helpers_DateTime::getDateFormatRus($model->getDate()) . '</turnoverDate>'

            // грузополучатель
            . '<consignee>'
            . '<countryCode>KZ</countryCode>'
            . '<name>Физическое лицо</name>'
            . '</consignee>'

            // продавец
            . '<consignor>'
            . '<address>РК, 050014, г. Алматы, ул. Серикова, 20 А</address>'
            . '<name>Товарищество с ограниченной ответственностью "Асфальтобетон 1"</name>'
            . '<tin>060440009474</tin>'
            . '</consignor>'

            // покупатель
            . '<customers>'
            . '<customer>'
            . '<countryCode>KZ</countryCode>'
            . '<name>Физическое лицо</name>'
            . '<statuses><status>RETAIL</status></statuses>'
            . '</customer>'
            . '</customers>'

            // доставка
            . '<deliveryDocDate>' . Helpers_DateTime::getDateFormatRus($model->getDate()) . '</deliveryDocDate>'
            . '<deliveryDocNum>' . $model->getNumber() . '</deliveryDocNum>'
            . '<deliveryTerm>'
            . '<hasContract>false</hasContract>'
            . '</deliveryTerm>'

            // продукция
            . '<productSet>'
            . '<currencyCode>KZT</currencyCode>'
            . '<products>';


        $params = Request_RequestParams::setParams(
            array(
                'shop_invoice_id' => $modelRoot->id,
            )
        );
        $shopInvoiceItemGTDIDs = Request_Request::find(
            'DB_Magazine_Shop_Invoice_Item_GTD', $sitePageData->shopID, $sitePageData, $driver,
            $params, 0, TRUE,
            array(
                'shop_product_id' => array('name'),
                'shop_product_unit_id' => array('code_esf'),
                'shop_production_id' => array('name_esf', 'name'),
                'shop_production_unit_id' => array('code_esf'),
            )
        );

        // группируем по ГТД
        $shopInvoiceItemGTDs = array();
        foreach ($shopInvoiceItemGTDIDs->childs as $child) {
            $product = $child->values['shop_product_id'];
            if($product == 0){
                $product = $child->values['shop_production_id'];
            }

            $key = $product
                . '_' . $child->values['catalog_tru_id']
                . '_' . $child->values['tru_origin_code']
                . '_' . $child->values['product_declaration']
                . '_' . $child->values['product_number_in_declaration']
                . '_' . $child->values['price_realization'];

            if (!key_exists($key, $shopInvoiceItemGTDs)) {
                $shopInvoiceItemGTDs[$key] = $child;
            } else {
                $shopInvoiceItemGTDs[$key]->values['quantity'] += $child->values['quantity'];
                $shopInvoiceItemGTDs[$key]->values['amount_realization'] += $child->values['amount_realization'];
            }
        }

        $params = Request_RequestParams::setParams(
            array(
                'shop_invoice_id' => $model->id,
            )
        );
        $shopInvoiceItemIDs = Request_Request::find(
            'DB_Magazine_Shop_Invoice_Item',
            $sitePageData->shopID, $sitePageData, $driver,
            $params, 0, TRUE,
            array(
                'shop_product_id' => array('name'),
                'shop_product_unit_id' => array('code_esf'),
                'shop_production_id' => array('name_esf', 'name', 'coefficient'),
                'shop_production_unit_id' => array('code_esf'),
            )
        );

        $modelGTD = new Model_Magazine_Shop_Invoice_Item_GTD();

        // Товары ЭСФ
        $totalNdsAmount = 0;
        $totalPriceWithTax = 0;
        $totalPriceWithoutTax = 0;
        $totalTurnoverSize = 0;
        foreach ($shopInvoiceItemGTDs as $shopInvoiceItemGTD) {
            $shopProductionID = $shopInvoiceItemGTD->values['shop_production_id'];

            $shopInvoiceItem = null;
            foreach ($shopInvoiceItemIDs->childs as $key => $child){
                if($child->values['shop_production_id'] == $shopProductionID){
                    $shopInvoiceItem = $child;
                    break;
                }
            }

            if($shopInvoiceItem == null) {
                $quantity = round($shopInvoiceItemGTD->values['quantity'], 3);
            }else{

            }




            $unitPrice = Api_Tax_NDS::getAmountWithoutNDS($shopInvoiceItemGTD->values['price_realization']);

            $ndsAmount = round($shopInvoiceItemGTD->values['price_realization'] / (100 + 12) * 12 * $quantity, 2);
            $priceWithTax = round($shopInvoiceItemGTD->values['price_realization'] * $quantity, 2);
            $priceWithoutTax = Api_Tax_NDS::getAmountWithoutNDS($shopInvoiceItemGTD->values['price_realization'] * $quantity, 2);

            $totalNdsAmount += $ndsAmount;
            $totalPriceWithTax += $priceWithTax;
            $totalPriceWithoutTax += $priceWithoutTax;
            $totalTurnoverSize += $priceWithoutTax;

            // реализация продуктов
            if ($shopInvoiceItemGTD->values['shop_product_id'] > 0) {
                $data .=
                    '<product>'
                    // Идентификатор товара, работ, услуг
                    . '<catalogTruId>' . $shopInvoiceItemGTD->values['catalog_tru_id'] . '</catalogTruId>'
                    // Наименование товаров, работ, услуг
                    . '<description>' . htmlspecialchars($shopInvoiceItemGTD->getElementValue('shop_product_id', 'name'), ENT_XML1) . '</description>'
                    // НДС-Сумма
                    . '<ndsAmount>' . $ndsAmount . '</ndsAmount>'
                    // НДС-Ставка
                    . '<ndsRate>' . Api_Tax_NDS::getNDS() . '</ndsRate>'
                    // Стоимость товаров, работ, услуг с учетом косвенных налогов
                    . '<priceWithTax>' . $priceWithTax . '</priceWithTax>'
                    // Стоимость товаров, работ, услуг без косвенных налогов
                    . '<priceWithoutTax>' . $priceWithoutTax . '</priceWithoutTax>';

                // № Декларации на товары, заявления в рамках ТС, СТ-1 или СТ-KZ
                if (!Func::_empty($shopInvoiceItemGTD->values['product_declaration'])) {
                    $data .= '<productDeclaration>' . htmlspecialchars($shopInvoiceItemGTD->values['product_declaration'], ENT_XML1) . '</productDeclaration>';
                }

                // Номер товарной позиции из заявления в рамках ТС или Декларации на товары
                if (!Func::_empty($shopInvoiceItemGTD->values['product_number_in_declaration'])) {
                    $data .= '<productNumberInDeclaration>' . $shopInvoiceItemGTD->values['product_number_in_declaration'] . '</productNumberInDeclaration>';
                }

                $data .=
                    // Кол-во (объем)
                    '<quantity>' . Func::getNumberStr($quantity, false, 3, true) . '</quantity>';

                // Наименование товаров в соответствии с Декларацией на товары или заявлением о ввозе товаров и уплате косвенных налогов
                if (!Func::_empty($modelGTD->getESFReceiveObject()->getTNVEDName())) {
                    $data .= '<tnvedName>' . htmlspecialchars($modelGTD->getESFReceiveObject()->getTNVEDName(), ENT_XML1) . '</tnvedName>';
                }

                $data .=
                    // Признак происхождения товара, работ, услуг
                    '<truOriginCode>' . htmlspecialchars($shopInvoiceItemGTD->values['tru_origin_code'], ENT_XML1) . '</truOriginCode>'
                    // Размер оборота по реализации (облагаемый/необлагаемый оборот)
                    . '<turnoverSize>' . $priceWithoutTax . '</turnoverSize>';

                // Код товара (ТН ВЭД ЕАЭС)
                if (!Func::_empty($modelGTD->getESFReceiveObject()->getUnitCode())) {
                    $data .= '<unitCode>' . $modelGTD->getESFReceiveObject()->getUnitCode() . '</unitCode>';
                }

                $data .=
                    // Код единицы измерения
                    '<unitNomenclature>' . htmlspecialchars($shopInvoiceItemGTD->getElementValue('shop_product_unit_id', 'code_esf'), ENT_XML1) . '</unitNomenclature>'
                    // Цена (тариф) за единицу товара, работы, услуги без косвенных налогов
                    . '<unitPrice>' . $unitPrice . '</unitPrice>'
                    . '</product>';
            }else {
                // реализация продукции
                $data .=
                    '<product>'
                    // Идентификатор товара, работ, услуг
                    . '<catalogTruId>' . $shopInvoiceItemGTD->values['catalog_tru_id'] . '</catalogTruId>'
                    // Наименование товаров, работ, услуг
                    . '<description>' . htmlspecialchars($shopInvoiceItemGTD->getElementValue('shop_production_id', 'name'), ENT_XML1) . '</description>'
                    // НДС-Сумма
                    . '<ndsAmount>' . $ndsAmount . '</ndsAmount>'
                    // НДС-Ставка
                    . '<ndsRate>' . Api_Tax_NDS::getNDS() . '</ndsRate>'
                    // Стоимость товаров, работ, услуг с учетом косвенных налогов
                    . '<priceWithTax>' . $priceWithTax . '</priceWithTax>'
                    // Стоимость товаров, работ, услуг без косвенных налогов
                    . '<priceWithoutTax>' . $priceWithoutTax . '</priceWithoutTax>'
                    // Кол-во (объем)
                    . '<quantity>' . Func::getNumberStr($quantity, false, 3, true) . '</quantity>'
                    // Признак происхождения товара, работ, услуг
                    . '<truOriginCode>' . $shopInvoiceItemGTD->values['tru_origin_code'] . '</truOriginCode>'
                    // Размер оборота по реализации (облагаемый/необлагаемый оборот)
                    . '<turnoverSize>' . $priceWithoutTax . '</turnoverSize>'
                    // Код единицы измерения
                    . '<unitNomenclature>' . htmlspecialchars($shopInvoiceItemGTD->getElementValue('shop_production_unit_id', 'code_esf'), ENT_XML1) . '</unitNomenclature>'
                    // Цена (тариф) за единицу товара, работы, услуги без косвенных налогов
                    . '<unitPrice>' . $unitPrice . '</unitPrice>'
                    . '</product>';
            }
        }




            // группируем по ГТД
            $shopInvoiceItems = array();
            foreach ($shopInvoiceItemIDs->childs as $child) {
                $product = $child->values['shop_product_id'];
                if ($product == 0) {
                    $product = $child->values['shop_production_id'];
                }

                $key = $product
                    . '_' . $child->values['price'];

                if (!key_exists($key, $shopInvoiceItems)) {
                    $shopInvoiceItems[$key] = $child;
                } else {
                    $shopInvoiceItems[$key]->values['quantity'] += $child->values['quantity'];
                    $shopInvoiceItems[$key]->values['amount'] += $child->values['amount'];
                }
            }


        $data .=
            '</products>'
            // итоговые суммы
            . '<totalExciseAmount>0</totalExciseAmount>'
            . '<totalNdsAmount>-'.$totalNdsAmount.'</totalNdsAmount>'
            . '<totalPriceWithTax>-'.$totalPriceWithTax.'</totalPriceWithTax>'
            . '<totalPriceWithoutTax>-'.$totalPriceWithoutTax.'</totalPriceWithoutTax>'
            . '<totalTurnoverSize>-'.$totalTurnoverSize.'</totalTurnoverSize>'

            . '</productSet>'

            // продавец
            . '<sellers>'
            . '<seller>'
            . '<address>РК, 050014, г. Алматы, ул. Серикова, 20 А</address>'
            . '<bank>АО Народный Банк Казахстана</bank>'
            . '<bik>HSBKKZKX</bik>'
            . '<certificateNum>0031923</certificateNum>'
            . '<certificateSeries>60001</certificateSeries>'
            . '<iik>KZ906017131000030374</iik>'
            . '<kbe>17</kbe>'
            . '<name>Товарищество с ограниченной ответственностью "Асфальтобетон 1"</name>'
            . '<tin>060440009474</tin>'
            . '</seller>'
            . '</sellers>'

            . '</v2:invoice>'
            . '</invoiceSet>'
            . '</esf:invoiceContainer>';

        return $data;
    }

    /**
     * Получаю основной счета фактуры ЭСФ в виде XML
     * @param Model_Magazine_Shop_Invoice $model
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @return string
     */
    public static function _getEFSXML(Model_Magazine_Shop_Invoice $model, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        $data =
            '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>'
            . '<esf:invoiceContainer xmlns:esf="namespace.esf" xmlns:a="namespace.abstractInvoice" xmlns:v1="namespace.v1" xmlns:v2="namespace.v2">'
            . '<invoiceSet>'
            . '<v2:invoice xmlns:a="abstractInvoice.esf" xmlns:v2="v2.esf">'
            . '<date>' . Helpers_DateTime::getDateFormatRus($model->getESFDate()) . '</date>'
            . '<invoiceType>ORDINARY_INVOICE</invoiceType>'
            . '<num>' . $model->getNumber() . '</num>'
            . '<operatorFullname>ИСЛАМОВ ВАРИС АБУБАКИРОВИЧ</operatorFullname>'
            . '<turnoverDate>' . Helpers_DateTime::getDateFormatRus($model->getDate()) . '</turnoverDate>'

            // грузополучатель
            . '<consignee>'
            . '<countryCode>KZ</countryCode>'
            . '<name>Физическое лицо</name>'
            . '</consignee>'

            // продавец
            . '<consignor>'
            . '<address>РК, 050014, г. Алматы, ул. Серикова, 20 А</address>'
            . '<name>Товарищество с ограниченной ответственностью "Асфальтобетон 1"</name>'
            . '<tin>060440009474</tin>'
            . '</consignor>'

            // покупатель
            . '<customers>'
            . '<customer>'
            . '<countryCode>KZ</countryCode>'
            . '<name>Физическое лицо</name>'
            . '<statuses><status>RETAIL</status></statuses>'
            . '</customer>'
            . '</customers>'

            // доставка
            . '<deliveryDocDate>' . Helpers_DateTime::getDateFormatRus($model->getDate()) . '</deliveryDocDate>'
            . '<deliveryDocNum>' . $model->getNumber() . '</deliveryDocNum>'
            . '<deliveryTerm>'
            . '<hasContract>false</hasContract>'
            . '</deliveryTerm>'

            // продукция
            . '<productSet>'
            . '<currencyCode>KZT</currencyCode>'
            . '<products>';


        $params = Request_RequestParams::setParams(
            array(
                'shop_invoice_id' => $model->id,
            )
        );
        $shopInvoiceItemGTDIDs = Request_Request::find('DB_Magazine_Shop_Invoice_Item_GTD',
            $sitePageData->shopID, $sitePageData, $driver,
            $params, 0, TRUE,
            array(
                'shop_product_id' => array('name'),
                'shop_product_unit_id' => array('code_esf'),
                'shop_production_id' => array('name_esf', 'name'),
                'shop_production_unit_id' => array('code_esf'),
            )
        );

        // группируем по ГТД
        $shopInvoiceItemGTDs = array();
        foreach ($shopInvoiceItemGTDIDs->childs as $child) {
            $product = $child->values['shop_product_id'];
            if($product == 0){
                $product = $child->values['shop_production_id'];
            }

            $key = $product
                . '_' . $child->values['catalog_tru_id']
                . '_' . $child->values['tru_origin_code']
                . '_' . $child->values['product_declaration']
                . '_' . $child->values['product_number_in_declaration']
                . '_' . $child->values['price_realization'];

            if (!key_exists($key, $shopInvoiceItemGTDs)) {
                $shopInvoiceItemGTDs[$key] = $child;
            } else {
                $shopInvoiceItemGTDs[$key]->values['quantity'] += $child->values['quantity'];
                $shopInvoiceItemGTDs[$key]->values['amount_realization'] += $child->values['amount_realization'];
            }
        }

        $modelGTD = new Model_Magazine_Shop_Invoice_Item_GTD();

        // Товары ЭСФ
        $totalNdsAmount = 0;
        $totalPriceWithTax = 0;
        $totalPriceWithoutTax = 0;
        $totalTurnoverSize = 0;
        foreach ($shopInvoiceItemGTDs as $shopInvoiceItemGTD) {
            $shopInvoiceItemGTD->setModel($modelGTD);

            $quantity = round($shopInvoiceItemGTD->values['quantity'], 3);

            $unitPrice = Api_Tax_NDS::getAmountWithoutNDS($shopInvoiceItemGTD->values['price_realization']);

            $ndsAmount = round($shopInvoiceItemGTD->values['price_realization'] / (100 + 12) * 12 * $quantity, 2);
            $priceWithTax = round($shopInvoiceItemGTD->values['price_realization'] * $quantity, 2);
            $priceWithoutTax = Api_Tax_NDS::getAmountWithoutNDS($shopInvoiceItemGTD->values['price_realization'] * $quantity, 2);

            $totalNdsAmount += $ndsAmount;
            $totalPriceWithTax += $priceWithTax;
            $totalPriceWithoutTax += $priceWithoutTax;
            $totalTurnoverSize += $priceWithoutTax;

            // реализация продуктов
            if ($shopInvoiceItemGTD->values['shop_product_id'] > 0) {
                // корректируем номер декларации KZ.7500114.24.01.123 на KZ75001142401
                $productDeclaration = $shopInvoiceItemGTD->values['product_declaration'];
                if(strtoupper(substr($productDeclaration, 0, 2)) == 'KZ'
                    || Func::mb_strtoupper(mb_substr($productDeclaration, 0, 2)) == 'КZ'){
                    $productDeclaration = Func::mb_str_replace('К', 'K', str_replace(['.', '/'], '', $productDeclaration));

                    if(mb_strlen($productDeclaration) > 13){
                        $productDeclaration = mb_substr($productDeclaration, 0, 13);
                    }
                }

                $data .=
                    '<product>'
                    // Идентификатор товара, работ, услуг
                    . '<catalogTruId>' . $shopInvoiceItemGTD->values['catalog_tru_id'] . '</catalogTruId>'
                    // Наименование товаров, работ, услуг
                    . '<description>' . htmlspecialchars($shopInvoiceItemGTD->getElementValue('shop_product_id', 'name'), ENT_XML1) . '</description>'
                    // НДС-Сумма
                    . '<ndsAmount>' . $ndsAmount . '</ndsAmount>'
                    // НДС-Ставка
                    . '<ndsRate>' . Api_Tax_NDS::getNDS() . '</ndsRate>'
                    // Стоимость товаров, работ, услуг с учетом косвенных налогов
                    . '<priceWithTax>' . $priceWithTax . '</priceWithTax>'
                    // Стоимость товаров, работ, услуг без косвенных налогов
                    . '<priceWithoutTax>' . $priceWithoutTax . '</priceWithoutTax>';

                // № Декларации на товары, заявления в рамках ТС, СТ-1 или СТ-KZ
                if (!Func::_empty($productDeclaration)) {
                    $data .= '<productDeclaration>' . htmlspecialchars($productDeclaration, ENT_XML1) . '</productDeclaration>';
                }

                // Номер товарной позиции из заявления в рамках ТС или Декларации на товары
                if (!Func::_empty($shopInvoiceItemGTD->values['product_number_in_declaration'])) {
                    $data .= '<productNumberInDeclaration>' . $shopInvoiceItemGTD->values['product_number_in_declaration'] . '</productNumberInDeclaration>';
                }

                $data .=
                    // Кол-во (объем)
                    '<quantity>' . Func::getNumberStr($quantity, false, 3, true) . '</quantity>';

                // Наименование товаров в соответствии с Декларацией на товары или заявлением о ввозе товаров и уплате косвенных налогов
                if (!Func::_empty($modelGTD->getESFReceiveObject()->getTNVEDName())) {
                    $data .= '<tnvedName>' . htmlspecialchars($modelGTD->getESFReceiveObject()->getTNVEDName(), ENT_XML1) . '</tnvedName>';
                }

                $data .=
                    // Признак происхождения товара, работ, услуг
                    '<truOriginCode>' . htmlspecialchars($shopInvoiceItemGTD->values['tru_origin_code'], ENT_XML1) . '</truOriginCode>'
                    // Размер оборота по реализации (облагаемый/необлагаемый оборот)
                    . '<turnoverSize>' . $priceWithoutTax . '</turnoverSize>';

                // Код товара (ТН ВЭД ЕАЭС)
                if (!Func::_empty($modelGTD->getESFReceiveObject()->getUnitCode())) {
                    $data .= '<unitCode>' . $modelGTD->getESFReceiveObject()->getUnitCode() . '</unitCode>';
                }

                $data .=
                    // Код единицы измерения
                    '<unitNomenclature>' . htmlspecialchars($shopInvoiceItemGTD->getElementValue('shop_product_unit_id', 'code_esf'), ENT_XML1) . '</unitNomenclature>'
                    // Цена (тариф) за единицу товара, работы, услуги без косвенных налогов
                    . '<unitPrice>' . $unitPrice . '</unitPrice>'
                    . '</product>';
            }else {
                // реализация продукции
                $data .=
                    '<product>'
                    // Идентификатор товара, работ, услуг
                    . '<catalogTruId>' . $shopInvoiceItemGTD->values['catalog_tru_id'] . '</catalogTruId>'
                    // Наименование товаров, работ, услуг
                    . '<description>' . htmlspecialchars($shopInvoiceItemGTD->getElementValue('shop_production_id', 'name'), ENT_XML1) . '</description>'
                    // НДС-Сумма
                    . '<ndsAmount>' . $ndsAmount . '</ndsAmount>'
                    // НДС-Ставка
                    . '<ndsRate>' . Api_Tax_NDS::getNDS() . '</ndsRate>'
                    // Стоимость товаров, работ, услуг с учетом косвенных налогов
                    . '<priceWithTax>' . $priceWithTax . '</priceWithTax>'
                    // Стоимость товаров, работ, услуг без косвенных налогов
                    . '<priceWithoutTax>' . $priceWithoutTax . '</priceWithoutTax>'
                    // Кол-во (объем)
                    . '<quantity>' . Func::getNumberStr($quantity, false, 3, true) . '</quantity>'
                    // Признак происхождения товара, работ, услуг
                    . '<truOriginCode>' . $shopInvoiceItemGTD->values['tru_origin_code'] . '</truOriginCode>'
                    // Размер оборота по реализации (облагаемый/необлагаемый оборот)
                    . '<turnoverSize>' . $priceWithoutTax . '</turnoverSize>'
                    // Код единицы измерения
                    . '<unitNomenclature>' . htmlspecialchars($shopInvoiceItemGTD->getElementValue('shop_production_unit_id', 'code_esf'), ENT_XML1) . '</unitNomenclature>'
                    // Цена (тариф) за единицу товара, работы, услуги без косвенных налогов
                    . '<unitPrice>' . $unitPrice . '</unitPrice>'
                    . '</product>';
            }
        }

        $data .=
            '</products>'

            // итоговые суммы
            . '<totalExciseAmount>0</totalExciseAmount>'
            . '<totalNdsAmount>'.$totalNdsAmount.'</totalNdsAmount>'
            . '<totalPriceWithTax>'.$totalPriceWithTax.'</totalPriceWithTax>'
            . '<totalPriceWithoutTax>'.$totalPriceWithoutTax.'</totalPriceWithoutTax>'
            . '<totalTurnoverSize>'.$totalTurnoverSize.'</totalTurnoverSize>'

            . '</productSet>'

            // продавец
            . '<sellers>'
            . '<seller>'
            . '<address>РК, 050014, г. Алматы, ул. Серикова, 20 А</address>'
            . '<bank>АО Народный Банк Казахстана</bank>'
            . '<bik>HSBKKZKX</bik>'
            . '<certificateNum>0031923</certificateNum>'
            . '<certificateSeries>60001</certificateSeries>'
            . '<iik>KZ906017131000030374</iik>'
            . '<kbe>17</kbe>'
            . '<name>Товарищество с ограниченной ответственностью "Асфальтобетон 1"</name>'
            . '<tin>060440009474</tin>'
            . '</seller>'
            . '</sellers>'

            . '</v2:invoice>'
            . '</invoiceSet>'
            . '</esf:invoiceContainer>';

        return $data;
    }

    /**
     * Сохраняем счета фактуры ЭСФ в виде XML
     * @param $shopInvoiceID
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @param bool $isPHPOutput
     * @return string
     * @throws HTTP_Exception_500
     */
    public static function saveEFSXML($shopInvoiceID, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver, $isPHPOutput = FALSE)
    {
        $model = new Model_Magazine_Shop_Invoice();
        $model->setDBDriver($driver);

        if (!Helpers_DB::dublicateObjectLanguage($model, $shopInvoiceID, $sitePageData, -1, FALSE)) {
            throw new HTTP_Exception_500('Invoice not found.');
        }
        if (Func::_empty($model->getNumberESF())) {
            $model->setESFDate(date('Y-m-d'));
        }

        if($model->getESFTypeID() == Model_Magazine_ESFType::ESF_TYPE_RETURN){
            $data = self::_getReturnEFSXML($model, $sitePageData, $driver);
        }else{
            $data = self::_getEFSXML($model, $sitePageData, $driver);
        }

        if($isPHPOutput) {
            header('Content-Type: text/xml');
            header('Content-Disposition: attachment;filename="esf_'.$model->getNumber().'.xml"');
            header('Cache-Control: max-age=0');

            echo $data;
            exit();
        }

        return $data;
    }

    /**
     * Сохраняем основные счет-фактур для 1С в виде XML
     * @param $dateFrom
     * @param $dateTo
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @param bool $isPHPOutput
     * @return string
     */
    public static function saveMainXML($dateFrom, $dateTo, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver, $isPHPOutput = FALSE)
    {
        // получаем список счет-фактур
        $params = Request_RequestParams::setParams(
            array(
                'date_from_equally' => $dateFrom,
                'date_to' => $dateTo,
            )
        );
        $shopInvoiceIDs = Request_Request::find('DB_Magazine_Shop_Invoice',
            $sitePageData->shopID, $sitePageData, $driver, $params, 0, TRUE,
            array(
                'shop_invoice_id' => array('number'),
                'shop_id' => array('old_id'),
            )
        );

        $data = '<?xml version="1.0" encoding="UTF-8"?><data>';
        foreach($shopInvoiceIDs->childs as $shopInvoiceID) {
            if($shopInvoiceID->values['esf_type_id'] == Model_Magazine_ESFType::ESF_TYPE_RETURN){
                continue;
            }
            $data .= '<invoice>'
                . '<branch>'.$shopInvoiceID->getElementValue('shop_id', 'old_id').'</branch>'
                . '<id>' . $shopInvoiceID->values['id'] . '</id>'
                . '<number>' . $shopInvoiceID->values['number'] . '</number>'
                . '<number_esf>' . $shopInvoiceID->values['number_esf'] . '</number_esf>'
                . '<date>' . strftime('%d.%m.%Y %H:%M:%S', strtotime($shopInvoiceID->values['date'])) . '</date>';

            if(empty($shopInvoiceID->values['esf_date'])){
                $data .= '<esf_date></esf_date>';
            }else {
                $data .= '<esf_date>' . strftime('%d.%m.%Y %H:%M:%S', strtotime($shopInvoiceID->values['esf_date'])) . '</esf_date>';
            }

             $data .= '<root>' . $shopInvoiceID->values['shop_invoice_id'] . '</root>'
                . '<amount>' . $shopInvoiceID->values['amount'] . '</amount>';

            // получаем список реализаций
            $params = Request_RequestParams::setParams(
                array(
                    'shop_invoice_id' => $shopInvoiceID->id,
                    'sort_by' => array(
                        'shop_production_id.name' => 'asc',
                        'shop_product_id.name' => 'asc',
                    ),
                    'sum_amount' => TRUE,
                    'sum_quantity' => TRUE,
                    'sum_esf_receive_quantity' => TRUE,
                    'sort_by' => array('shop_production_id.name' => 'asc'),
                    'group_by' => array(
                        'price',
                        'shop_product_id', 'shop_product_id.name',
                        'shop_production_id', 'shop_production_id.name', 'shop_production_id.old_id',
                        'unit_id.name', 'unit_id.old_id',
                    ),
                )
            );

            if($shopInvoiceID->values['esf_type_id'] == Model_Magazine_ESFType::ESF_TYPE_RETURN){
                $shopRealizationItemIDs = Request_Request::find('DB_Magazine_Shop_Realization_Return_Item',
                    $sitePageData->shopID, $sitePageData, $driver,
                    $params, 0, TRUE,
                    array(
                        'shop_production_id' => array('name', 'old_id'),
                        'shop_product_id' => array('name'),
                        'unit_id' => array('name', 'old_id'),
                    )
                );

                $data .=
                    '<esf_type>' . Model_Magazine_ESFType::ESF_TYPE_RETURN . '</esf_type>'
                    . '<esf_type_name>Возвратная</esf_type_name>';
            }else {
                $shopRealizationItemIDs = Request_Request::find('DB_Magazine_Shop_Invoice_Item',
                    $sitePageData->shopID, $sitePageData, $driver,
                    $params, 0, TRUE,
                    array(
                        'shop_production_id' => array('name', 'old_id'),
                        'shop_product_id' => array('name'),
                    )
                );

                $data .=
                    '<esf_type>' . Model_Magazine_ESFType::ESF_TYPE_ELECTRONIC . '</esf_type>'
                    . '<esf_type_name>Основная</esf_type_name>';
            }

            $nds = 0;
            $data .= '<goodsList>';
            foreach ($shopRealizationItemIDs->childs as $child) {
                $nds += Api_Tax_NDS::getAmountNDS($child->values['amount']);
                $data .= '<goods>';

                if($child->values['shop_product_id'] > 0){
                    $data .= '<id>' . $child->values['shop_product_id'] . '</id>'
                    . '<id_1c></id_1c>'
                    . '<name>' . htmlspecialchars($child->getElementValue('shop_product_id'), ENT_XML1) . '</name>';
                }else{
                    $data .= '<id></id>'
                    . '<id_1c>' . $child->getElementValue('shop_production_id', 'old_id', '') . '</id_1c>'
                    . '<name>' . htmlspecialchars($child->getElementValue('shop_production_id', 'name'), ENT_XML1) . '</name>';
                }

                $quantity = round($child->values['quantity'], 3);
                $amount = round($quantity * $child->values['price'], 2);
                $data .=  '<quantity>' . $quantity . '</quantity>'
                    . '<price>' . $child->values['price'] . '</price>'
                    . '<amount>' . $amount . '</amount>'
                    . '<amountNDS>' . Api_Tax_NDS::getAmountNDS($amount) . '</amountNDS>'
                    . '</goods>';
            }
            $data .= '</goodsList>';
            $data .= '<amountNDS>'.$nds.'</amountNDS>';
            $data .= '</invoice>';
        }
        $data .= '</data>';

        if($isPHPOutput) {
            header('Content-Type: text/xml');
            header('Content-Disposition: attachment;filename="magazine_invoice.xml"');
            header('Cache-Control: max-age=0');

            echo $data;
            exit();
        }

        return $data;
    }

    /**
     * Сохраняем возвратные счет-фактур для 1С в виде XML
     * @param $dateFrom
     * @param $dateTo
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @param bool $isPHPOutput
     * @return string
     */
    public static function saveReturnXML($dateFrom, $dateTo, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver, $isPHPOutput = FALSE)
    {
        // получаем список счет-фактур
        $params = Request_RequestParams::setParams(
            array(
                'created_at_from' => $dateFrom,
                'created_at_to' => $dateTo,
            )
        );
        $shopInvoiceIDs = Request_Request::find('DB_Magazine_Shop_Invoice',
            $sitePageData->shopID, $sitePageData, $driver, $params, 0, TRUE,
            array(
                'shop_invoice_id' => array('number'),
                'shop_id' => array('old_id'),
            )
        );

        $data = '<?xml version="1.0" encoding="UTF-8"?><data>';
        foreach($shopInvoiceIDs->childs as $shopInvoiceID) {
            if($shopInvoiceID->values['esf_type_id'] != Model_Magazine_ESFType::ESF_TYPE_RETURN){
                continue;
            }
            $data .= '<invoice>'
                . '<branch>'.$shopInvoiceID->getElementValue('shop_id', 'old_id').'</branch>'
                . '<id>' . $shopInvoiceID->values['id'] . '</id>'
                . '<number>' . $shopInvoiceID->values['number'] . '</number>'
                . '<number_esf>' . $shopInvoiceID->values['number_esf'] . '</number_esf>'
                . '<date>' . strftime('%d.%m.%Y %H:%M:%S', strtotime($shopInvoiceID->values['date'])) . '</date>'
                . '<esf_date>' . strftime('%d.%m.%Y %H:%M:%S', strtotime($shopInvoiceID->values['esf_date'])) . '</esf_date>'
                . '<root>' . $shopInvoiceID->values['shop_invoice_id'] . '</root>'
                . '<amount>' . $shopInvoiceID->values['amount'] . '</amount>'
                . '<amount_nds>' . Api_Tax_NDS::getAmountNDS($shopInvoiceID->values['amount']) . '</amount_nds>';

            // получаем список реализаций
            $params = Request_RequestParams::setParams(
                array(
                    'shop_invoice_id' => $shopInvoiceID->id,
                    'sum_amount' => TRUE,
                    'sum_quantity' => TRUE,
                    'sum_esf_receive_quantity' => TRUE,
                    'sort_by' => array('shop_production_id.name' => 'asc'),
                    'group_by' => array(
                        'price',
                        'shop_production_id', 'shop_production_id.name', 'shop_production_id.old_id', 'shop_production_id.shop_product_id',
                        'unit_id.name', 'unit_id.old_id',
                    ),
                )
            );

            if($shopInvoiceID->values['esf_type_id'] == Model_Magazine_ESFType::ESF_TYPE_RETURN){
                $shopRealizationItemIDs = Request_Request::find(
                    'DB_Magazine_Shop_Realization_Return_Item',
                    $sitePageData->shopID, $sitePageData, $driver,
                    $params, 0, TRUE,
                    array(
                        'shop_production_id' => array('name', 'old_id', 'shop_product_id'),
                    )
                );

                $data .=
                    '<esf_type>' . Model_Magazine_ESFType::ESF_TYPE_RETURN . '</esf_type>'
                    . '<esf_type_name>Возвратная</esf_type_name>';
            }else {
                $shopRealizationItemIDs = Request_Request::find(
                    'DB_Magazine_Shop_Realization_Item',
                    $sitePageData->shopID, $sitePageData, $driver,
                    $params, 0, TRUE,
                    array(
                        'shop_production_id' => array('name', 'old_id', 'shop_product_id'),
                    )
                );

                $data .=
                    '<esf_type>' . Model_Magazine_ESFType::ESF_TYPE_ELECTRONIC . '</esf_type>'
                    . '<esf_type_name>Основная</esf_type_name>';
            }
            $data .= '<goodsList>';
            foreach ($shopRealizationItemIDs->childs as $child) {
                $data .= '<goods>'
                    . '<id>' . $child->getElementValue('shop_production_id', 'shop_product_id', $child->values['shop_production_id']) . '</id>'
                    . '<name>' . htmlspecialchars($child->getElementValue('shop_production_id'), ENT_XML1) . '</name>'
                    . '<quantity>' . $child->values['quantity'] . '</quantity>'
                    . '<price>' . $child->values['price'] . '</price>'
                    . '<amount>' . Api_Tax_NDS::getAmountWithoutNDS($child->values['amount']) . '</amount>'
                    . '<amountNDS>' . Api_Tax_NDS::getAmountNDS($child->values['amount']) . '</amountNDS>'
                    . '</goods>';
            }
            $data .= '</goodsList>';
            $data .= '</invoice>';
        }
        $data .= '</data>';

        if($isPHPOutput) {
            header('Content-Type: text/xml');
            header('Content-Disposition: attachment;filename="magazine_return_invoice.xml"');
            header('Cache-Control: max-age=0');

            echo $data;
            exit();
        }

        return $data;
    }

    /**
     * Загружаем файл ЭСФ из личного кабинета
     * @param $id
     * @param $fileName
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @return bool
     * @throws HTTP_Exception_404
     */
    public static function loadESF($id, $fileName, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        if (empty($fileName) || (!file_exists($fileName))) {
            throw new HTTP_Exception_404('File not found. #220420');
        }

        $model = new Model_Magazine_Shop_Invoice();
        $model->setDBDriver($driver);
        if (! Helpers_DB::getDBObject($model, $id, $sitePageData)) {
            throw new HTTP_Exception_404('Invoice not is found!');
        }

        $esf = new Helpers_ESF_Unload_Invoices();
        $esf->loadXML($fileName);

        if($esf->count() < 1){
            return false;
        }

        /** @var Helpers_ESF_Unload_Invoice $esf */
        $esf = $esf->getValues()[0];

        $model->setNumberESF($esf->getRegistrationNumber());
        $model->setESFDate($esf->getDate());
        $model->setDate($esf->getTurnoverDate());
        $model->setIsImportESF(true);
        $model->setImportESFObject($esf);

        Helpers_DB::saveDBObject($model, $sitePageData);

        return true;
    }
}
