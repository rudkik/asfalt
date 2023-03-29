<?php defined('SYSPATH') or die('No direct script access.');

class Api_Magazine_Shop_Invoice_Item  {

    /**
     * Считаем итого по Счету-фактурам за заданный период
     * @param $shopInvoiceID
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @return array
     */
    public static function calcTotalPeriod($dateFrom, $dateTo, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        // список реализованных продукций
        $shopInvoiceItemIDs = Request_Request::find('DB_Magazine_Shop_Invoice_Item',
            $sitePageData->shopID, $sitePageData, $driver,
            Request_RequestParams::setParams(
                array(
                    'date_from' => $dateFrom,
                    'date_to' => $dateTo,
                    'sum_amount' => true,
                    'sum_quantity' => true,
                    'group_by' => array(
                        'price', 'shop_production_id', 'shop_invoice_id'
                    )
                )
            )
        );

        $result =  array(
            'amount' => 0,
            'quantity' => 0,
        );
        foreach ($shopInvoiceItemIDs->childs as $child){
            $quantity = round($child->values['quantity'], 3);
            $result['quantity'] += $quantity;
            $result['amount'] += round($child->values['price'] * $quantity, 2);
        }

        return $result;
    }

    /**
     * Считаем итого по Счету-фактуре
     * @param $shopInvoiceID
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @return array
     */
    public static function calcTotal($shopInvoiceID, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        // список реализованных продукций
        $shopInvoiceItemIDs = Request_Request::find('DB_Magazine_Shop_Invoice_Item',
            $sitePageData->shopID, $sitePageData, $driver,
            Request_RequestParams::setParams(
                array(
                    'shop_invoice_id' => $shopInvoiceID,
                    'sum_amount' => true,
                    'sum_quantity' => true,
                    'group_by' => array(
                        'price', 'shop_production_id'
                    )
                )
            )
        );

        $result =  array(
            'amount' => 0,
            'quantity' => 0,
        );
        foreach ($shopInvoiceItemIDs->childs as $child){
            $quantity = round($child->values['quantity'], 3);
            $result['quantity'] += $quantity;
            $result['amount'] += round($child->values['price'] * $quantity, 2);
        }

        return $result;
    }

    /**
     * Сохранение списка привязки реализации к приемки
     * @param Model_Magazine_Shop_Invoice $modelInvoice
     * @param SitePageData $sitePageData
     * @param bool $isLoadESF
     * @param Model_Driver_DBBasicDriver $driver
     * @return array | bool
     */
    public static function save(Model_Magazine_Shop_Invoice $modelInvoice, SitePageData $sitePageData,
                                Model_Driver_DBBasicDriver $driver, $isLoadESF = false)
    {
        // список реализованных продукций
        $shopRealizationItemIDs = Request_Request::find('DB_Magazine_Shop_Realization_Item',
            $sitePageData->shopID, $sitePageData, $driver,
            Request_RequestParams::setParams(
                array(
                    'shop_invoice_id' => $modelInvoice->id,
                    'sort_by' => array(
                        'shop_production_id' => 'desc',
                        'id' => 'asc',
                    ),
                    'not_shop_write_off_type_id' => array(
                        Model_Magazine_Shop_WriteOff_Type::WRITE_OFF_TYPE_BY_STANDART,
                        Model_Magazine_Shop_WriteOff_Type::WRITE_OFF_TYPE_OVER_THE_NORM,
                        Model_Magazine_Shop_WriteOff_Type::WRITE_OFF_TYPE_RECEPTION,
                    ),
                )
            ),
            0, TRUE,
            array(
                'shop_production_id' => array('shop_product_id', 'coefficient')
            )
        );

        // список привязок прихода к реализованным продуктам
        $shopInvoiceItemIDs = Request_Request::find('DB_Magazine_Shop_Invoice_Item',
            $sitePageData->shopID, $sitePageData, $driver,
            Request_RequestParams::setParams(
                array(
                    'shop_invoice_id' => $modelInvoice->id,
                    'sort_by' => array(
                        'shop_realization_item_id' => 'asc',
                    ),
                )
            ),
            0, TRUE
        );

        /***********************************/
        /** если список реализации пустой **/
        /***********************************/

        if(count($shopRealizationItemIDs->childs) == 0){
            $ids = $shopInvoiceItemIDs->getChildArrayID();
            if(count($ids) == 0){
                return FALSE;
            }

            $driver->deleteObjectIDs(
                $ids, $sitePageData->userID,
                Model_Magazine_Shop_Invoice_Item::TABLE_NAME, array()
            );

            // удаляем список привязок ГТД прихода к реализованным ГТД
            $driver->sendSQL('UPDATE sp_shop_invoice_item_gtds SET is_delete = 1, deleted_at=\''.date('Y-m-d H:i:s').'\', delete_user_id='.$sitePageData->userID.'  WHERE shop_invoice_id='.$modelInvoice->id);
            return FALSE;
        }

        /**********************************************/
        /** Список ГТД прихода необходимых нам продуктов **/
        /**********************************************/

        // список прихода необходимых нам продуктов
        $shopReceiveItemGTDIDs = Request_Request::find('DB_Magazine_Shop_Receive_Item_GTD',
            $sitePageData->shopID, $sitePageData, $driver,
            Request_RequestParams::setParams(
                array(
                    'shop_product_id' => $shopRealizationItemIDs->getChildArrayInt(Model_Basic_BasicObject::FIELD_ELEMENTS . '.shop_production_id.shop_product_id', TRUE),
                    'quantity_balance_from' => 0,
                    'is_esf' => TRUE,
                    'sort_by' => array(
                        'id' => 'asc',
                    ),
                )
            ),
            0, TRUE
        );

        // группируем приход по продуктам
        $shopReceiveItemGTDs = array();
        foreach ($shopReceiveItemGTDIDs->childs as $child){
            $product = $child->values['shop_product_id'];
            if(!key_exists($product, $shopReceiveItemGTDs)){
                $shopReceiveItemGTDs[$product] = array();
            }

            $shopReceiveItemGTDs[$product][] = $child->getModel(new Model_Magazine_Shop_Receive_Item_GTD(), $driver);
        }
        unset($shopReceiveItemGTDIDs);

        /****************************************/
        /** Распраделяем реализацию по приходу **/
        /****************************************/

        $modelRealizationItem = new Model_Magazine_Shop_Realization_Item();
        $modelRealizationItem->setDBDriver($driver);
        $modelInvoiceItem = new Model_Magazine_Shop_Invoice_Item();
        $modelInvoiceItem->setDBDriver($driver);

        $modelReceiveItemGTD = new Model_Magazine_Shop_Receive_Item_GTD();
        $modelReceiveItemGTD->setDBDriver($driver);
        $modelInvoiceItemGTD = new Model_Magazine_Shop_Invoice_Item_GTD();
        $modelInvoiceItemGTD->setDBDriver($driver);

        $addESFLines = function (array &$esfLines, Model_Magazine_Shop_Invoice_Item_GTD $modelInvoiceItemGTD) {
            $keyLine = $modelInvoiceItemGTD->getPriceRealization()
                . '_' . $modelInvoiceItemGTD->getShopProductionID()
                . '_' . $modelInvoiceItemGTD->getShopProductID()
                . '_' . $modelInvoiceItemGTD->getCatalogTruID()
                . '_' . $modelInvoiceItemGTD->getTruOriginCode()
                . '_' . $modelInvoiceItemGTD->getProductDeclaration()
                . '_' . $modelInvoiceItemGTD->getProductNumberInDeclaration()
                . '_' . $modelInvoiceItemGTD->getIsESF();
            $esfLines[$keyLine] = $modelInvoiceItemGTD->id;
        };

        $isESF = TRUE;
        $deleteRealizationItems = array();
        $esfLines = array();
        foreach($shopRealizationItemIDs->childs as $shopRealizationItemID){
            // собираем список реализаций, которые не поместились в ограничения 200 позиций для ЭСФ
            if(count($esfLines) == 200){
                $deleteRealizationItems[] = $shopRealizationItemID->id;
                continue;
            }

            $shopProductionID = $shopRealizationItemID->values['shop_production_id'];
            $coefficient = $shopRealizationItemID->getElementValue('shop_production_id', 'coefficient', '1');
            if($coefficient == 0){
                $coefficient = 1;
            }

            $shopProductID = $shopRealizationItemID->getElementValue('shop_production_id', 'shop_product_id');
            $shopRealizationItemID->setModel($modelRealizationItem);

            $quantityRealization = $modelRealizationItem->getQuantity() / $coefficient;
            $priceRealization = $modelRealizationItem->getPrice() * $coefficient;

            /****************************/
            /** Если продана продукция **/
            /****************************/
            if($shopProductID < 1) {
                $modelInvoiceItem->clear();
                $modelInvoiceItem->setShopInvoiceID($modelInvoice->id);
                $modelInvoiceItem->setShopRealizationItemID($modelRealizationItem->id);
                $modelInvoiceItem->setShopProductID(0);
                $modelInvoiceItem->setShopProductionID($shopProductionID);
                $modelInvoiceItem->setQuantity($quantityRealization);
                $modelInvoiceItem->setESFQuantity($quantityRealization);
                $modelInvoiceItem->setPrice($priceRealization);
                $modelInvoiceItem->setIsESF(TRUE);
                Helpers_DB::saveDBObject($modelInvoiceItem, $sitePageData, $modelRealizationItem->shopID);

                $modelRealizationItem->setESFReceiveQuantity($quantityRealization);
                $modelRealizationItem->setIsESF(TRUE);
                Helpers_DB::saveDBObject($modelRealizationItem, $sitePageData, $modelRealizationItem->shopID);

                // создаем пустую строчку для связи с ЭСФ приемки
                $modelInvoiceItemGTD->clear();

                $modelInvoiceItemGTD->setPriceRealization($priceRealization);
                $modelInvoiceItemGTD->setQuantity($quantityRealization);

                $modelInvoiceItemGTD->setShopInvoiceID($modelInvoice->id);
                $modelInvoiceItemGTD->setShopInvoiceItemID($modelInvoiceItem->id);

                $modelInvoiceItemGTD->setShopRealizationItemID($modelRealizationItem->id);
                $modelInvoiceItemGTD->setShopProductionID($shopProductionID);
                $modelInvoiceItemGTD->setShopProductID(0);

                $modelInvoiceItemGTD->setTruOriginCode(5);
                $modelInvoiceItemGTD->setCatalogTruID(1);
                $modelInvoiceItemGTD->setIsESF(TRUE);

                Helpers_DB::saveDBObject($modelInvoiceItemGTD, $sitePageData);
                $addESFLines($esfLines, $modelInvoiceItemGTD);

                continue;
            }

            /*************************/
            /** Если продан продукт, но нет прихода **/
            /*************************/
            if (!key_exists($shopProductID, $shopReceiveItemGTDs)) {
                $modelInvoiceItem->clear();
                $modelInvoiceItem->setShopInvoiceID($modelInvoice->id);
                $modelInvoiceItem->setShopRealizationItemID($modelRealizationItem->id);
                $modelInvoiceItem->setShopProductID($shopProductID);
                $modelInvoiceItem->setShopProductionID($shopProductionID);
                $modelInvoiceItem->setQuantity($quantityRealization);
                $modelInvoiceItem->setPrice($priceRealization);
                Helpers_DB::saveDBObject($modelInvoiceItem, $sitePageData, $modelRealizationItem->shopID);

                $modelRealizationItem->setIsESF(FALSE);
                $modelRealizationItem->setESFReceiveQuantity(0);
                Helpers_DB::saveDBObject($modelRealizationItem, $sitePageData, $modelRealizationItem->shopID);

                // создаем пустую строчку для связи с ЭСФ приемки
                $modelInvoiceItemGTD->clear();

                $modelInvoiceItemGTD->setPriceRealization($priceRealization);
                $modelInvoiceItemGTD->setQuantity($quantityRealization);

                $modelInvoiceItemGTD->setShopInvoiceID($modelInvoice->id);
                $modelInvoiceItemGTD->setShopInvoiceItemID($modelInvoiceItem->id);

                $modelInvoiceItemGTD->setShopRealizationItemID($modelRealizationItem->id);
                $modelInvoiceItemGTD->setShopProductionID($shopProductionID);
                $modelInvoiceItemGTD->setShopProductID($shopProductID);

                $modelInvoiceItemGTD->setTruOriginCode(5);
                $modelInvoiceItemGTD->setCatalogTruID(1);

                Helpers_DB::saveDBObject($modelInvoiceItemGTD, $sitePageData);
                $addESFLines($esfLines, $modelInvoiceItemGTD);

                $isESF = FALSE;
                continue;
            }

            /*********************************************************/
            /** Подбираем подходящие связи реализацию и ГТД прихода **/
            /*********************************************************/

            $list = array();
            $quantity = $quantityRealization;
            /**
             * находим подходящие ГТД продуктов прихода
             * @var string $key
             * @var Model_Magazine_Shop_Receive_Item_GTD $child
             */
            foreach ($shopReceiveItemGTDs[$shopProductID] as $key => $child){
                if($quantity >= $child->getQuantityBalance()){
                    // если вся строчка подходит
                    $quantity -= $child->getQuantityBalance();

                    $tmp = new MyArray();
                    $tmp->values = $child->getValues(TRUE, TRUE);
                    $list[] = $tmp;

                    unset($shopReceiveItemGTDs[$shopProductID][$key]);

                    if($quantity < 0.001){
                        $quantity = 0;
                        break;
                    }
                }else{
                    // если не вся строчка подходит
                    $t = $child->getQuantityBalance() - $quantity;

                    $tmp = new MyArray();
                    $child->setQuantityBalance($quantity);
                    $tmp->values = $child->getValues(TRUE, TRUE);
                    $list[] = $tmp;

                    $child->setQuantityBalance($t);
                    $quantity = 0;

                    break;
                }
            }

            /************************************/
            /** Создаем связь ЭСФ и реализации **/
            /************************************/

            // если весь вес распределен, то ставим что есть ЭСФ
            $isESFRealizationItem = $quantity > -0.0001 && $quantity < 0.0001;

            // ищем продукт счет-фактуры, который максимально совпадает с новой строкой
            $findProduct = NULL;
            $findIdentical = NULL;
            $diffQuantity = $quantity;
            $quantity = $quantityRealization - $quantity;
            foreach ($shopInvoiceItemIDs->childs as $key => $child){
                if($child->values['shop_product_id'] == $shopProductID){
                    if($findProduct === NULL) {
                        $findProduct = $key;
                    }
                    if($child->values['quantity'] == $quantity){
                        $findProduct = $key;
                        if($child->values['price'] == $shopRealizationItemID->values['price']){
                            $findIdentical = $key;
                            break;
                        }
                    }
                }
            }
            if($findIdentical !== NULL){
                $shopInvoiceItemIDs->childs[$findIdentical]->setModel($modelInvoiceItem);
                unset($shopInvoiceItemIDs->childs[$findIdentical]);
            }elseif($findProduct !== NULL){
                $shopInvoiceItemIDs->childs[$findProduct]->setModel($modelInvoiceItem);
                unset($shopInvoiceItemIDs->childs[$findProduct]);
            }else{
                $modelInvoiceItem->clear();
            }

            $isESF = $isESF && $isESFRealizationItem;
            $modelInvoiceItem->setIsESF($isESFRealizationItem);
            $modelInvoiceItem->setPrice($priceRealization);
            $modelInvoiceItem->setQuantity($quantityRealization);
            $modelInvoiceItem->setESFQuantity($quantity);

            $modelInvoiceItem->setShopInvoiceID($modelInvoice->id);
            $modelInvoiceItem->setShopRealizationItemID($modelRealizationItem->id);
            $modelInvoiceItem->setShopProductID($shopProductID);
            $modelInvoiceItem->setShopProductionID($shopProductionID);
            Helpers_DB::saveDBObject($modelInvoiceItem, $sitePageData);

            /*********************************************************/
            /** Создаем связь продукции счета-фактуры и ГТД прихода **/
            /*********************************************************/

            // список привязок ГТД прихода к реализованным ГТД на текущий момент
            $shopInvoiceItemGTDIDs = Request_Request::find('DB_Magazine_Shop_Invoice_Item_GTD',
                $sitePageData->shopID, $sitePageData, $driver,
                Request_RequestParams::setParams(
                    array(
                        'shop_invoice_item_id' => $modelInvoiceItem->id,
                        'sort_by' => array(
                            'shop_receive_item_gtd_id' => 'asc',
                        ),
                    )
                ),
                0, TRUE
            );

            /**
             * @var MyArray $child - сохранены список ГТД прихода
             */
            foreach ($list as $child) {
                $child->setModel($modelReceiveItemGTD);

                $modelInvoiceItemGTD->clear();
                $shopInvoiceItemGTDID = array_shift($shopInvoiceItemGTDIDs->childs);
                if($shopInvoiceItemGTDID !== NULL){
                    $shopInvoiceItemGTDID->setModel($modelInvoiceItemGTD);
                }

                $modelInvoiceItemGTD->setPriceRealization($priceRealization);
                $modelInvoiceItemGTD->setPriceReceive($modelReceiveItemGTD->getPrice());
                $modelInvoiceItemGTD->setQuantity($modelReceiveItemGTD->getQuantityBalance());

                $modelInvoiceItemGTD->setShopInvoiceID($modelInvoice->id);
                $modelInvoiceItemGTD->setShopInvoiceItemID($modelInvoiceItem->id);

                if($isLoadESF) {
                    $modelInvoiceItemGTD->setShopReceiveID($modelReceiveItemGTD->getShopReceiveID());
                    $modelInvoiceItemGTD->setShopReceiveItemID($modelReceiveItemGTD->getShopReceiveItemID());
                    $modelInvoiceItemGTD->setShopReceiveItemGTDID($modelReceiveItemGTD->id);
                }else{
                    $modelInvoiceItemGTD->setShopReceiveID(0);
                    $modelInvoiceItemGTD->setShopReceiveItemID(0);
                    $modelInvoiceItemGTD->setShopReceiveItemGTDID(0);
                }

                $modelInvoiceItemGTD->setShopRealizationItemID($modelRealizationItem->id);
                $modelInvoiceItemGTD->setShopProductionID($modelRealizationItem->getShopProductionID());
                $modelInvoiceItemGTD->setShopProductID($modelReceiveItemGTD->getShopProductID());

                $modelInvoiceItemGTD->setTruOriginCode($modelReceiveItemGTD->getTruOriginCode());
                $modelInvoiceItemGTD->setProductDeclaration($modelReceiveItemGTD->getProductDeclaration());
                $modelInvoiceItemGTD->setProductNumberInDeclaration($modelReceiveItemGTD->getProductNumberInDeclaration());
                $modelInvoiceItemGTD->setCatalogTruID(
                    Api_Magazine_Shop_Product_TNVED::getCatalogTruID(
                        $modelReceiveItemGTD->getCatalogTruID(), $modelReceiveItemGTD->getESFObject()->getUnitCode(), $sitePageData, $driver
                    )
                );

                $esfObject = $modelReceiveItemGTD->getESFObject();
                $esfObject->setQuantity($modelReceiveItemGTD->getQuantityBalance());
                $modelInvoiceItemGTD->setESFReceiveObject($esfObject);
                $modelInvoiceItemGTD->setIsESF(TRUE);

                Helpers_DB::saveDBObject($modelInvoiceItemGTD, $sitePageData);
                $addESFLines($esfLines, $modelInvoiceItemGTD);
            }

            // если часть веса не распределилось, то ставим его как не распределенный
            if($diffQuantity > 0.0001){
                $modelInvoiceItemGTD->clear();
                $shopInvoiceItemGTDID = array_shift($shopInvoiceItemGTDIDs->childs);
                if($shopInvoiceItemGTDID !== NULL){
                    $shopInvoiceItemGTDID->setModel($modelInvoiceItemGTD);
                }

                $modelInvoiceItemGTD->setPriceRealization($priceRealization);
                $modelInvoiceItemGTD->setPriceReceive(0);
                $modelInvoiceItemGTD->setQuantity($diffQuantity);

                $modelInvoiceItemGTD->setShopInvoiceID($modelInvoice->id);
                $modelInvoiceItemGTD->setShopInvoiceItemID($modelInvoiceItem->id);

                $modelInvoiceItemGTD->setShopReceiveID(0);
                $modelInvoiceItemGTD->setShopReceiveItemID(0);
                $modelInvoiceItemGTD->setShopReceiveItemGTDID(0);

                $modelInvoiceItemGTD->setShopRealizationItemID($modelRealizationItem->id);
                $modelInvoiceItemGTD->setShopProductionID($shopProductionID);
                $modelInvoiceItemGTD->setShopProductID($shopProductID);

                $modelInvoiceItemGTD->setTruOriginCode(5);
                $modelInvoiceItemGTD->setProductDeclaration('');
                $modelInvoiceItemGTD->setProductNumberInDeclaration('');
                $modelInvoiceItemGTD->setCatalogTruID(1);

                $modelInvoiceItemGTD->setESFReceive('');
                $modelInvoiceItemGTD->setIsESF(false);

                Helpers_DB::saveDBObject($modelInvoiceItemGTD, $sitePageData);
                $addESFLines($esfLines, $modelInvoiceItemGTD);
            }

            $driver->deleteObjectIDs(
                $shopInvoiceItemGTDIDs->getChildArrayID(), $sitePageData->userID,
                Model_Magazine_Shop_Invoice_Item_GTD::TABLE_NAME, array(), $sitePageData->shopID
            );

            $modelRealizationItem->setIsESF($isESFRealizationItem);
            $modelRealizationItem->setESFReceiveQuantity($quantity);
            Helpers_DB::saveDBObject($modelRealizationItem, $sitePageData, $modelRealizationItem->shopID);
        }

        // удаляем ссылки на счет-фактуру, которые не поместились в ограничения ЭСФ 200 позиций
        if(count($deleteRealizationItems) > 0) {
            $driver->updateObjects(
                Model_Magazine_Shop_Realization_Item::TABLE_NAME, $deleteRealizationItems,
                array('shop_invoice_id' => 0), 0, $sitePageData->shopID
            );
        }

        $shopInvoiceItems = $shopInvoiceItemIDs->getChildArrayID();
        if(count($shopInvoiceItems) > 0) {
            $driver->deleteObjectIDs(
                $shopInvoiceItems, $sitePageData->userID,
                Model_Magazine_Shop_Invoice_Item::TABLE_NAME, array(), $sitePageData->shopID
            );

            // удаляем список привязок ГТД прихода к реализованным ГТД на текущий момент
            $shopInvoiceItemGTDIDs = Request_Request::find('DB_Magazine_Shop_Invoice_Item_GTD',
                $sitePageData->shopID, $sitePageData, $driver,
                Request_RequestParams::setParams(
                    array(
                        'shop_invoice_item_id' => $shopInvoiceItems,
                    )
                ),
                0, TRUE
            );
            $driver->deleteObjectIDs(
                $shopInvoiceItemGTDIDs->getChildArrayID(), $sitePageData->userID,
                Model_Magazine_Shop_Invoice_Item_GTD::TABLE_NAME, array(), $sitePageData->shopID
            );
        }

        if(count($deleteRealizationItems) > 0) {
            // посчитаем общее количество
            $totalInvoice = Api_Magazine_Shop_Invoice_Item::calcTotal($modelInvoice->id, $sitePageData, $driver);

            return array(
                'is_esf' => $isESF,
                'amount' => $totalInvoice['amount'],
                'quantity' => $totalInvoice['quantity'],
            );
        }

        // посчитаем общее количество за этот день
        $totalInvoice = Api_Magazine_Shop_Invoice_Item::calcTotalPeriod(
            $modelInvoice->getDateFrom(), $modelInvoice->getDateTo(), $sitePageData, $driver
        );

        /** доводит итоговую сумма накладной до суммы реализации */
        if($totalInvoice['amount'] > 0.001) {
            // Получаем сумму реализации за заданный период
            $params = Request_RequestParams::setParams(
                array(
                    'created_at_from' => $modelInvoice->getDateFrom(),
                    'created_at_to' => Helpers_DateTime::plusDays($modelInvoice->getDateTo(), 1),
                    'sum_amount' => true,
                    'not_shop_write_off_type_id' => array(
                        Model_Magazine_Shop_WriteOff_Type::WRITE_OFF_TYPE_BY_STANDART,
                        Model_Magazine_Shop_WriteOff_Type::WRITE_OFF_TYPE_OVER_THE_NORM,
                        Model_Magazine_Shop_WriteOff_Type::WRITE_OFF_TYPE_RECEPTION,
                    ),
                )
            );
            $shopRealizationItemIDs = Request_Request::find('DB_Magazine_Shop_Realization_Item',
                $sitePageData->shopID, $sitePageData, $driver, $params
            );
            $totalRealization = $shopRealizationItemIDs->calcTotalChild('amount');

            if (abs($totalRealization - $totalInvoice['amount']) < 1) {
                return array(
                    'is_esf' => $isESF,
                    'amount' => $totalInvoice['amount'],
                    'quantity' => $totalInvoice['quantity'],
                );
            }

            $diff = $totalRealization - $totalInvoice['amount'];

            // список реализованных продукций
            $shopInvoiceItemIDs = Request_Request::find('DB_Magazine_Shop_Invoice_Item',
                $sitePageData->shopID, $sitePageData, $driver,
                Request_RequestParams::setParams(
                    array(
                        'shop_invoice_id' => $modelInvoice->id,
                        'sum_amount' => true,
                        'sum_quantity' => true,
                        'group_by' => array(
                            'price', 'shop_production_id', 'shop_product_id', 'shop_production_id.coefficient'
                        )
                    )
                ), 0, true,
                array('shop_production_id' => ['coefficient'])
            );

            // меняем цену за товар, у товара с коэффициентом, чтобы подогнать общую сумму до разницы меньше 1 тг, если коэффициент не равно 1
            foreach ($shopInvoiceItemIDs->childs as $child) {
                $coefficient = intval($child->getElementValue('shop_production_id', 'coefficient', 0));
                if ($coefficient == 1 || $coefficient == 0) {
                    continue;
                }

                $amount = round($child->values['amount'], 2) + $diff;
                $price = $amount / $child->values['quantity'] * 100;
                $price = explode('.', $price)[0];
                $price = round($price / 100, 2);
                if ($child->values['price'] == $price || $price < 1) {
                    continue;
                }

                // меняем цены строчек детворы ЭСФ
                $list = Request_Request::find('DB_Magazine_Shop_Invoice_Item',
                    $sitePageData->shopID, $sitePageData, $driver,
                    Request_RequestParams::setParams(
                        array(
                            'shop_invoice_id' => $modelInvoice->id,
                            'shop_production_id' => $child->values['shop_production_id'],
                            'shop_product_id' => $child->values['shop_product_id'],
                        )
                    ), 0, true
                );

                foreach ($list->childs as $one) {
                    $one->setModel($modelInvoiceItem);
                    $modelInvoiceItem->setPrice($price);
                    Helpers_DB::saveDBObject($modelInvoiceItem, $sitePageData);
                }

                // меняем цены строчек ГТД ЭСФ
                $list = Request_Request::find('DB_Magazine_Shop_Invoice_Item_GTD',
                    $sitePageData->shopID, $sitePageData, $driver,
                    Request_RequestParams::setParams(
                        array(
                            'shop_invoice_id' => $modelInvoice->id,
                            'shop_production_id' => $child->values['shop_production_id'],
                            'shop_product_id' => $child->values['shop_product_id'],
                        )
                    ), 0, true
                );
                foreach ($list->childs as $one) {
                    $one->setModel($modelInvoiceItemGTD);
                    $modelInvoiceItemGTD->setPriceRealization($price);
                    Helpers_DB::saveDBObject($modelInvoiceItemGTD, $sitePageData);
                }

                $amount = round($price * $child->values['quantity'], 2);
                $diff = $diff - ($amount - round($child->values['amount'], 2));
                if (abs($diff) < 1) {
                    break;
                }
            }

            // меняем цену за товар, у товара с коэффициентом, чтобы подогнать общую сумму до разницы меньше 1 тг, если товары только с 1 коэффициентом
            if (abs($diff) > 0.001) {
                foreach ($shopInvoiceItemIDs->childs as $child) {
                    $amount = round($child->values['amount'], 2) + $diff;
                    $price = $amount / $child->values['quantity'] * 100;
                    $price = explode('.', $price)[0];
                    $price = round($price / 100, 2);
                    if ($child->values['price'] == $price || $price < 1) {
                        continue;
                    }

                    // меняем цены строчек детворы ЭСФ
                    $list = Request_Request::find('DB_Magazine_Shop_Invoice_Item',
                        $sitePageData->shopID, $sitePageData, $driver,
                        Request_RequestParams::setParams(
                            array(
                                'shop_invoice_id' => $modelInvoice->id,
                                'shop_production_id' => $child->values['shop_production_id'],
                                'shop_product_id' => $child->values['shop_product_id'],
                            )
                        ), 0, true
                    );
                    foreach ($list->childs as $one) {
                        $one->setModel($modelInvoiceItem);
                        $modelInvoiceItem->setPrice($price);
                        $modelInvoiceItem->setAmount($modelInvoiceItem->getQuantity() * $price);
                        Helpers_DB::saveDBObject($modelInvoiceItem, $sitePageData);
                    }

                    // меняем цены строчек ГТД ЭСФ
                    $list = Request_Request::find('DB_Magazine_Shop_Invoice_Item_GTD',
                        $sitePageData->shopID, $sitePageData, $driver,
                        Request_RequestParams::setParams(
                            array(
                                'shop_invoice_id' => $modelInvoice->id,
                                'shop_production_id' => $child->values['shop_production_id'],
                                'shop_product_id' => $child->values['shop_product_id'],
                            )
                        ), 0, true
                    );
                    foreach ($list->childs as $one) {
                        $one->setModel($modelInvoiceItemGTD);
                        $modelInvoiceItemGTD->setPriceRealization($price);
                        $modelInvoiceItemGTD->setAmountRealization($modelInvoiceItemGTD->getQuantity() * $price);
                        Helpers_DB::saveDBObject($modelInvoiceItemGTD, $sitePageData);
                    }

                    $amount = round($price * $child->values['quantity'], 2);
                    $diff = $diff - ($amount - round($child->values['amount'], 2));
                    if (abs($diff) < 1) {
                        break;
                    }
                }
            }
        }

        // посчитаем общее количество
        $totalInvoice = Api_Magazine_Shop_Invoice_Item::calcTotal($modelInvoice->id, $sitePageData, $driver);
        return array(
            'is_esf' => $isESF,
            'amount' => $totalInvoice['amount'],
            'quantity' => $totalInvoice['quantity'],
        );
    }
}
