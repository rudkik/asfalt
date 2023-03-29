<?php defined('SYSPATH') or die('No direct script access.');

class Api_Magazine_Shop_Receive  {

    /**
     * Приход продуктов на заданный период
     * @param $dateFrom
     * @param $dateTo
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @param int | null $shopProductID
     * @return array
     */
    public static function receiveShopProductPeriod($dateFrom, $dateTo, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver,
                                                    $shopProductID = null)
    {
        $shopProductIDs = array();

        /** Считаем приход продуктов **/
        $params = Request_RequestParams::setParams(
            array(
                'sum_quantity' => TRUE,
                'created_at_from' => $dateFrom,
                'created_at_to' => $dateTo,
                'shop_product_id' => $shopProductID,
                'group_by' => array(
                    'shop_product_id'
                ),
            )
        );
        // приход
        $ids = Request_Request::find('DB_Magazine_Shop_Receive_Item',
            $sitePageData->shopID, $sitePageData, $driver, $params
        );
        foreach ($ids->childs as $child){
            $shopProductIDs[$child->values['shop_product_id']] = $child->values['quantity'];
        }

        return $shopProductIDs;
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

        $model = new Model_Magazine_Shop_Receive();
        $model->setDBDriver($driver);

        if (!Helpers_DB::dublicateObjectLanguage($model, $id, $sitePageData)) {
            throw new HTTP_Exception_500('Receive not found.');
        }

        if (($isUnDel && !$model->getIsDelete()) or (!$isUnDel && $model->getIsDelete())){
            return FALSE;
        }

        if($isUnDel){
            $params = Request_RequestParams::setParams(
                array(
                    'shop_receive_id' => $id,
                    'is_delete' => 1,
                    'is_public' => FALSE,
                )
            );
            $ids = Request_Request::find('DB_Magazine_Shop_Receive_Item',
                $sitePageData->shopID, $sitePageData, $driver, $params
            );
            $driver->unDeleteObjectIDs(
                $ids->getChildArrayID(), $sitePageData->userID, Model_Magazine_Shop_Receive_Item::TABLE_NAME,
                array('is_public' => 1), $sitePageData->shopID
            );

            $ids = Request_Request::find('DB_Magazine_Shop_Receive_Item_GTD',
                $sitePageData->shopID, $sitePageData, $driver, $params
            );
            $driver->unDeleteObjectIDs(
                $ids->getChildArrayID(), $sitePageData->userID, Model_Magazine_Shop_Receive_Item_GTD::TABLE_NAME,
                array('is_public' => 1), $sitePageData->shopID
            );

            $model->dbUnDelete($sitePageData->userID, 0, $sitePageData->shopID);
        }else {
            $params = Request_RequestParams::setParams(
                array(
                    'shop_receive_id' => $id,
                    'is_delete' => 0,
                    'is_public' => TRUE,
                )
            );
            $ids = Request_Request::find('DB_Magazine_Shop_Receive_Item',
                $sitePageData->shopID, $sitePageData, $driver, $params
            );
            $driver->deleteObjectIDs(
                $ids->getChildArrayID(), $sitePageData->userID, Model_Magazine_Shop_Receive_Item::TABLE_NAME,
                array('is_public' => 0), $sitePageData->shopID
            );

            $ids = Request_Request::find('DB_Magazine_Shop_Receive_Item_GTD',
                $sitePageData->shopID, $sitePageData, $driver, $params
            );
            $driver->deleteObjectIDs(
                $ids->getChildArrayID(), $sitePageData->userID, Model_Magazine_Shop_Receive_Item_GTD::TABLE_NAME,
                array('is_public' => 0), $sitePageData->shopID
            );

            $model->dbDelete($sitePageData->userID, 0, $sitePageData->shopID);
        }

        return TRUE;
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
        $model = new Model_Magazine_Shop_Receive();
        $model->setDBDriver($driver);

        $id = Request_RequestParams::getParamInt('id');
        if($id > 0) {
            if (!Helpers_DB::dublicateObjectLanguage($model, $id, $sitePageData)) {
                throw new HTTP_Exception_500('Receive not found.');
            }
        }
        $isEditLastPrice = $id <= 0;

        Request_RequestParams::setParamBoolean('is_public', $model);
        Request_RequestParams::setParamStr('text', $model);
        Request_RequestParams::setParamStr('name', $model);
        Request_RequestParams::setParamStr("old_id", $model);
        Request_RequestParams::setParamInt("shop_supplier_id", $model);
        Request_RequestParams::setParamInt("esf_type_id", $model);
        Request_RequestParams::setParamStr("esf_number", $model);
        Request_RequestParams::setParamBoolean('is_nds', $model);

        $options = Request_RequestParams::getParamArray('options');
        if ($options !== NULL) {
            $model->addOptionsArray($options);
        }

        $shopReceiveItems = Request_RequestParams::getParamArray('shop_receive_items');
        if($shopReceiveItems !== NULL) {
            $model->setAmount(0);
        }

        $result = array();
        if ($model->validationFields($result)) {
            if(Func::_empty($model->getNumber())){
                $n = Database::instance()->query(Database::SELECT, 'SELECT nextval(\'sp_number_receive_'.$sitePageData->shopID.'\') as id;')->as_array(NULL, 'id')[0];
                $n = '000000'.$n;
                $n = 'Т'.substr($n, strlen($n) - 8);
                $model->setNumber($n);
            }

            if($model->id < 1) {
                /** @var Model_Magazine_Shop_Supplier $shopSupplier */
                $shopSupplier = $model->getElement('shop_supplier_id', true, $sitePageData->shopMainID);
                if($shopSupplier !== null) {
                    $model->setIsNDS($shopSupplier->getIsNDS());
                }

                if(Func::_empty($model->getDate())){
                    $model->setDate(date('Y-m-d'));
                }
                Helpers_DB::saveDBObject($model, $sitePageData);
            }

            // загружаем фотографии
            $file = new Model_File($sitePageData);
            $file->saveFiles(Request_RequestParams::getParamArray('files'), $model, $sitePageData, $driver);

            // сохраняем товары
            if($shopReceiveItems !== NULL) {
                $invoiceESF = $model->getESFObject();
                $arr = Api_Magazine_Shop_Receive_Item::save(
                    $model, $shopReceiveItems, $invoiceESF->getProducts(), $sitePageData, $driver, $isEditLastPrice
                );
                $model->setAmount($arr['amount']);
                $model->setQuantity($arr['quantity']);

                // проверяем сохранился ли статус проверено ЭСФ
                $model->setIsESF($arr['is_esf'] && $model->getIsESF());
                $model->setESFObject($invoiceESF);
            }

            Helpers_DB::saveDBObject($model, $sitePageData);
            $result['values'] = $model->getValues();

            // удаляем временные сохранения
            $params = Request_RequestParams::setParams(
                array(
                    'shop_receive_id' => 0,
                )
            );
            $ids = Request_Request::find('DB_Magazine_Shop_Receive_Item',
                $sitePageData->shopID, $sitePageData, $driver, $params
            );
            $driver->deleteObjectIDs(
                $ids->getChildArrayID(), $sitePageData->userID, Model_Magazine_Shop_Receive_Item::TABLE_NAME,
                array('is_public' => 0), $sitePageData->shopID
            );
        }

        return array(
            'id' => $model->id,
            'result' => $result,
        );
    }

    /**
     * Загружаем ЭСФ из файла
     * @param $fileName
     * @param $shopReceiveID
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @return bool
     * @throws HTTP_Exception_404
     */
    public static function loadESFToFile($fileName, $shopReceiveID, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver){
        $model = new Model_Magazine_Shop_Receive();
        $model->setDBDriver($driver);
        if (! Helpers_DB::getDBObject($model, $shopReceiveID, $sitePageData)) {
            throw new HTTP_Exception_404('Receive not is found!');
        }

        $invoices = new Helpers_ESF_Unload_Invoices();
        $invoices->loadXML($fileName);

        if($invoices->count() < 1) {
            return FALSE;
        }

        // получаем продукцию приемки
        $shopReceiveItemIDs = Request_Request::find('DB_Magazine_Shop_Receive_Item',
            $model->shopID, $sitePageData, $driver,
            Request_RequestParams::setParams(
                array(
                    'shop_receive_id' => $model->id
                )
            ),
            0, TRUE,
            array('shop_product_id' => array('name_esf'))
        );

        $modelItem = new Model_Magazine_Shop_Receive_Item();
        $modelItem->setDBDriver($driver);

        // зачищаем привязки с ЭСФ и объединяем строчки с одинаковыми продуктами
        $arr = array();
        foreach ($shopReceiveItemIDs->childs as $child){
            $child->values['esf'] = ' ';
            $child->values['is_esf'] = -1;

            $product = $child->values['shop_product_id'].'_'.$child->values['price'];
            if(key_exists($product, $arr)){
                // увеличиваем количество продукта
                $arr[$product]->setModel($modelItem);
                $modelItem->setQuantity($modelItem->getQuantity() + $child->values['quantity']);
                Helpers_DB::saveDBObject($modelItem, $sitePageData);
                $arr[$product]->values['quantity'] = $modelItem->getQuantity();
                $arr[$product]->values['amount'] = $modelItem->getAmount();

                // удаляем лишную строку
                $child->setModel($modelItem);
                $modelItem->dbDelete($sitePageData->userID);
            }
        }

        /** @var Helpers_ESF_Unload_Invoice $invoice */
        $invoice = $invoices->first();

        /** @var Helpers_ESF_Unload_Product $child */
        foreach ($invoice->getProducts()->getValues() as $child){
            $tmp = false;
            foreach ($shopReceiveItemIDs->childs as $shopReceiveItemID) {
                if($shopReceiveItemID->getElementValue('shop_product_id', 'name_esf') == $child->getName()
                    && $shopReceiveItemID->values['quantity'] == $child->getQuantity()){
                    $tmp = $shopReceiveItemID;
                    break;
                }
            }

            if($tmp !== FALSE){
                $tmp->setModel($modelItem);
                $modelItem->setESFObject($child);
                Helpers_DB::saveDBObject($modelItem, $sitePageData);

                $shopReceiveItemIDs->removeChild($tmp);

                $child->getShopReceiveItemID($modelItem->id);
            }else{
                $child->getShopReceiveItemID(0);
            }
        }

        // сохраняем не привязанные продукты приемки к ЭСФ
        foreach ($shopReceiveItemIDs->childs as $child){
            $child->setModel($modelItem);
            $modelItem->setESF(NULL);
            $modelItem->setIsESF(FALSE);
            Helpers_DB::saveDBObject($modelItem, $sitePageData);
        }

        $model->setESFNumber($invoice->getNumber());
        $model->setDate($invoice->getTurnoverDate());
        $model->setESFDate($invoice->getDate());
        $model->setESFObject($invoice);
        $model->setIsNDS(!Func::_empty($invoice->getSeller()->getCertificateNumber()));
        Helpers_DB::saveDBObject($model, $sitePageData);

        return TRUE;
    }

    /**
     * Сохранение ЭСФ соединение строчек
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @return array
     * @throws HTTP_Exception_500
     */
    public static function saveESF(SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        $model = new Model_Magazine_Shop_Receive();
        $model->setDBDriver($driver);

        $id = Request_RequestParams::getParamInt('id');
        if (!Helpers_DB::getDBObject($model, $id, $sitePageData)) {
            throw new HTTP_Exception_500('Receive not found.');
        }

        Request_RequestParams::setParamBoolean("is_nds", $model);
        Request_RequestParams::setParamInt("esf_type_id", $model);
        Request_RequestParams::setParamStr("esf_number", $model);
        Request_RequestParams::setParamDate('date', $model);
        Request_RequestParams::setParamDate('esf_date', $model);

        if($model->getESFTypeID() == Model_Magazine_ESFType::ESF_TYPE_ELECTRONIC) {
            // загружаем электронную счет-фактуру
            $shopReceiveItems = Request_RequestParams::getParamArray('shop_receive_items');
            if($shopReceiveItems !== NULL) {
                self::loadElectronicESFItem($model, $shopReceiveItems, $sitePageData, $driver);
            }
        }else{
            // загружаем фумажную счет-фактуру
            self::loadPaperESFItem($model, $sitePageData, $driver);
        }

        Helpers_DB::saveDBObject($model, $sitePageData);
    }

    /**
     * Загружаем БУМАЖНУЮ счет-фактуру
     * @param Model_Magazine_Shop_Receive $model
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     */
    private static function loadPaperESFItem(Model_Magazine_Shop_Receive $model,
                                                  SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        // получаем список продуктов приемки
        $params = Request_RequestParams::setParams(
            array(
                'shop_receive_id' => $model->id,
            )
        );
        $shopReceiveItemIDs = Request_Request::find('DB_Magazine_Shop_Receive_Item',
            $sitePageData->shopID, $sitePageData, $driver, $params, 0, TRUE
        );
        $shopReceiveItemIDs->runIndex();

        $modelItem = new Model_Magazine_Shop_Receive_Item();
        $modelItem->setDBDriver($driver);

        foreach ($shopReceiveItemIDs->childs as $shopReceiveItemID) {
            $shopReceiveItemID->setModel($modelItem);
            $modelItem->setESF(NULL);
            $modelItem->setIsESF(TRUE);

            /** @var Model_Magazine_Shop_Product $modelProduct */
            $modelProduct = $modelItem->getElement('shop_product_id', TRUE, $sitePageData->shopMainID);
            if ($modelProduct !== NULL) {
                // Создаем / изменяем продукцию напрямую связанные с продуктом
                Api_Magazine_Shop_Production::editProduction($modelProduct, $sitePageData, $driver);
            }

            // Сохраняем список ГТД продуктов приемки
            Api_Magazine_Shop_Receive_Item_GTD::savePaper($modelItem, $sitePageData, $driver);

            Helpers_DB::saveDBObject($modelItem, $sitePageData);
        }

        $model->setESF(NULL);
        $model->setIsESF(TRUE);
    }

    /**
     * Загружаем ЭЛЕКТРОННУЮ счет-фактуру
     * @param Model_Magazine_Shop_Receive $model
     * @param array $shopReceiveItems
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     */
    private static function loadElectronicESFItem(Model_Magazine_Shop_Receive $model, array $shopReceiveItems,
                                                  SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        // получаем список продуктов приемки
        $params = Request_RequestParams::setParams(
            array(
                'shop_receive_id' => $model->id,
            )
        );
        $shopReceiveItemIDs = Request_Request::find('DB_Magazine_Shop_Receive_Item',
            $sitePageData->shopID, $sitePageData, $driver, $params, 0, TRUE
        );
        $shopReceiveItemIDs->runIndex();

        $modelItem = new Model_Magazine_Shop_Receive_Item();
        $modelItem->setDBDriver($driver);

        // ЭСФ загруженное в приемку
        $invoiceESF = $model->getESFObject();

        // зачищаем все привязки продуктов ЭСФ к продуктам приемки
        foreach ($invoiceESF->getProducts()->getValues() as $productESF) {
            $productESF->setShopReceiveItemID(0);
        }

        $isESF = TRUE;
        foreach ($shopReceiveItems as $shopReceiveItem) {
            $hash = Arr::path($shopReceiveItem, 'hash', Arr::path($shopReceiveItem, 'hash_esf', ''));
            if (empty($hash)) {
                continue;
            }
            $shopReceiveItemID = Arr::path($shopReceiveItem, 'shop_receive_item_id', '');
            if ($shopReceiveItemID < 1) {
                continue;
            }

            // ищем продукт в ЭСФ
            $productESF = $invoiceESF->getProducts()->findProductByHash($hash);


            if (key_exists($shopReceiveItemID, $shopReceiveItemIDs->childs)) {
                $shopReceiveItemIDs->childs[$shopReceiveItemID]->setModel($modelItem);
                if ($productESF === FALSE) {
                    $modelItem->setESF(NULL);
                } else {
                    $modelItem->setESFObject($productESF);

                    /** @var Model_Magazine_Shop_Product $modelProduct */
                    $modelProduct = $modelItem->getElement('shop_product_id', TRUE, $sitePageData->shopMainID);
                    if ($modelProduct !== NULL) {
                        $modelProduct->setNameESF($productESF->getName());
                        $modelProduct->setNames($productESF->getName());
                        if ($modelProduct->getUnitID() < 1) {
                            $modelProduct->setUnitID($productESF->getUnitNomenclature());
                        }
                        Helpers_DB::saveDBObject($modelProduct, $sitePageData, $sitePageData->shopMainID);

                        // Создаем / изменяем продукцию напрямую связанные с продуктом
                        Api_Magazine_Shop_Production::editProduction($modelProduct, $sitePageData, $driver);
                    }
                }

                // Сохраняем список ГТД продуктов приемки
                Api_Magazine_Shop_Receive_Item_GTD::saveElectronic($modelItem, $sitePageData, $driver);

                $isESF = $isESF && $modelItem->getIsESF();
                Helpers_DB::saveDBObject($modelItem, $sitePageData);
            } elseif ($productESF !== FALSE) {
                $isESF = FALSE;
            }
        }
        // проверяем все ли продукты ЭСФ учтены
        if ($isESF) {
            /** @var Helpers_ESF_Unload_Product $productESF */
            foreach ($invoiceESF->getProducts()->getValues() as $productESF) {
                if ($productESF->getShopReceiveItemID() < 1) {
                    $isESF = FALSE;
                    break;
                }
            }
        }
        $model->setIsESF($isESF);
        $model->setESFObject($invoiceESF);
    }

    /**
     * Сохраняем приход в виде XML
     * @param $dateFrom
     * @param $dateTo
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @param bool $isPHPOutput
     * @return string
     */
    public static function saveXML($dateFrom, $dateTo, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver, $isPHPOutput = FALSE)
    {
        // получаем список приемок
        $params = Request_RequestParams::setParams(
            array(
                'created_at_from' => $dateFrom,
                'created_at_to' => $dateTo,
            )
        );
        $shopReceiveIDs = Request_Request::find('DB_Magazine_Shop_Receive',
            $sitePageData->shopID, $sitePageData, $driver,
            $params, 0, TRUE,
            array(
                'shop_supplier_id' => array('name', 'bik', 'bin', 'address', 'account', 'bank', 'old_id'),
                'shop_id' => array('old_id'),
            )
        );

        $model = new Model_Magazine_Shop_Receive();
        $modelItem = new Model_Magazine_Shop_Receive_Item();

        $data = '<?xml version="1.0" encoding="UTF-8"?><data>';
        foreach($shopReceiveIDs->childs as $child){
            $child->setModel($model);

            $data .= '<receive>'
                . '<branch>'.$child->getElementValue('shop_id', 'old_id').'</branch>'
                . '<id>'.$child->values['id'].'</id>'
                . '<number>'.$child->values['number'].'</number>'
                . '<date>'.strftime('%d.%m.%Y %H:%M:%S', strtotime($child->values['date'])).'</date>'
                . '<IdKlient>'.$child->getElementValue('shop_supplier_id', 'old_id').'</IdKlient>'
                . '<Company>'.htmlspecialchars($child->getElementValue('shop_supplier_id'), ENT_XML1).'</Company>'
                . '<BIN>'.htmlspecialchars($child->getElementValue('shop_supplier_id', 'bin'), ENT_XML1).'</BIN>'
                . '<BIK>'.htmlspecialchars($child->getElementValue('shop_supplier_id', 'bik'), ENT_XML1).'</BIK>'
                . '<address>'.htmlspecialchars($child->getElementValue('shop_supplier_id', 'address'), ENT_XML1).'</address>'
                . '<account>'.htmlspecialchars($child->getElementValue('shop_supplier_id', 'account'), ENT_XML1).'</account>'
                . '<bank>'.htmlspecialchars($child->getElementValue('shop_supplier_id', 'bank'), ENT_XML1).'</bank>'
                . '<isNDS>'.$child->values['is_nds'].'</isNDS>'
                . '<amount>'.$model->getAmount().'</amount>'
                . '<esfClient>'.$child->values['esf_number'].'</esfClient>'
                . '<esfNumber>'.$model->getESFRegistrationNumber().'</esfNumber>';

            if(!empty($child->values['esf_date'])) {
                $data .= '<esfDate>' . strftime('%d.%m.%Y %H:%M:%S', strtotime($child->values['esf_date'])) . '</esfDate>';
            }else{
                $data .= '<esfDate></esfDate>';
            }

            $data .= '<goodsList>';

            // получаем список продуктов приемки
            $params = Request_RequestParams::setParams(
                array(
                    'shop_receive_id' => $model->id,
                )
            );
            $shopReceiveItemIDs = Request_Request::find('DB_Magazine_Shop_Receive_Item',
                $sitePageData->shopID, $sitePageData, $driver,
                $params, 0, TRUE,
                array(
                    'shop_product_id' => array('name', 'old_id'),
                    'unit_id' => array('name', 'old_id'),
                )
            );

            $nds = 0;
            foreach ($shopReceiveItemIDs->childs as $item) {
                $item->setModel($modelItem);
                $nds += $modelItem->getAmountNDS();

                $data .= '<goods>'
                    . '<id>' . $item->values['shop_product_id'] . '</id>'
                    . '<id_1c>' . $item->getElementValue('shop_product_id', 'old_id') . '</id_1c>'
                    . '<name>' . htmlspecialchars($item->getElementValue('shop_product_id'), ENT_XML1) . '</name>'
                    . '<unit>' . $item->getElementValue('unit_id', 'old_id') . '</unit>'
                    . '<unit_name>' . $item->getElementValue('unit_id') . '</unit_name>'
                    . '<quantity>' . $item->values['quantity'] . '</quantity>'
                    . '<price>' . $item->values['price'] . '</price>'
                    . '<amount>' . $modelItem->getAmount() . '</amount>'
                    . '<amountNDS>' . $modelItem->getAmountNDS() . '</amountNDS>'
                    . '<nds_percent>'.$modelItem->getNDSPercent().'</nds_percent>'
                    . '</goods>';
            }
            $data .= '</goodsList>';

            $data .= '<amountNDS>'.$nds.'</amountNDS>';
            $data .= '</receive>';
        }

        $data .= '</data>';

        if($isPHPOutput) {
            header('Content-Type: text/xml');
            header('Content-Disposition: attachment;filename="magazine_receive.xml"');
            header('Cache-Control: max-age=0');

            echo $data;
            exit();
        }

        return $data;
    }
}
