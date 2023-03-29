<?php defined('SYSPATH') or die('No direct script access.');

class Api_Magazine_Shop_Receive_Item_GTD  {
    /**
     * Список ГТД прихода необходимых нам продуктов сгруппированных по продукту
     * @param array $shopProductIDs
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @param array | int | null $shopReceiveEsfTypeID
     * @return array
     */
    public static function getGTDsGroupByProducts(array $shopProductIDs, SitePageData $sitePageData,
                                                  Model_Driver_DBBasicDriver $driver, $shopReceiveEsfTypeID = null)
    {
        // список прихода необходимых нам продуктов
        $shopReceiveItemGTDIDs = Request_Request::find('DB_Magazine_Shop_Receive_Item_GTD',
            $sitePageData->shopID, $sitePageData, $driver,
            Request_RequestParams::setParams(
                array(
                    'shop_product_id' => $shopProductIDs,
                    'quantity_balance_from' => 0,
                    'shop_receive_esf_type_id' => $shopReceiveEsfTypeID,
                    'is_esf' => TRUE,
                    'sort_by' => array(
                        'id' => 'desc',
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
                $shopReceiveItemGTDs[$product] = array(
                    'products' => [],
                    'quantity_balance' => 0,
                );
            }

            $shopReceiveItemGTDs[$product]['products'][] = $child->getModel(new Model_Magazine_Shop_Receive_Item_GTD(), $driver);
            $shopReceiveItemGTDs[$product]['quantity_balance'] += $child->values['quantity_balance'];
        }
        return $shopReceiveItemGTDs;
    }

    /**
     * Посчитать остатки ГТД приема продуктов счет-фактуры
     * @param int $shopInvoiceID
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @param int $notShopInvoiceID
     * @return bool
     * @throws HTTP_Exception_404
     */
    public static function calcQuantityInvoice($shopInvoiceID, SitePageData $sitePageData,
                                               Model_Driver_DBBasicDriver $driver, $notShopInvoiceID = -1)
    {
        Api_Magazine_Shop_Receive_Item_GTD::calcQuantityReceiveItemGTDIDs(
            Request_Request::find('DB_Magazine_Shop_Invoice_Item_GTD',
                $sitePageData->shopID, $sitePageData, $driver,
                Request_RequestParams::setParams(
                    array(
                        'shop_invoice_id' => $shopInvoiceID,
                        'is_delete_ignore' => true,
                        'is_public_ignore' => true,
                    )
                ),
                0, TRUE
            )->getChildArrayInt('shop_receive_item_gtd_id', TRUE),
            $sitePageData,
            $driver,
            $notShopInvoiceID
        );


        if(empty($shopReceiveItemGTDIDs)){
            return TRUE;
        }

        $shopInvoiceItemGTDs = Request_Request::find('DB_Magazine_Shop_Invoice_Item_GTD',
            $sitePageData->shopID, $sitePageData, $driver,
            Request_RequestParams::setParams(
                array(
                    'shop_receive_item_gtd_id' => $shopReceiveItemGTDIDs,
                    'id_not' => $notShopInvoiceID,
                    'sum_quantity' => TRUE,
                    'group_by' => array(
                        'shop_receive_item_gtd_id',
                    ),
                )
            ),
            0, TRUE
        );

        $model = new Model_Magazine_Shop_Receive_Item_GTD();
        $model->setDBDriver($driver);
        foreach ($shopInvoiceItemGTDs->childs as $child){
            $shopReceiveItemGTDID = $child->values['shop_receive_item_gtd_id'];
            if($shopReceiveItemGTDID > 0) {
                if (!Helpers_DB::getDBObject($model, $shopReceiveItemGTDID, $sitePageData)) {
                    throw new HTTP_Exception_404('Receive item GTD id=' . $shopReceiveItemGTDID . ' not found.');
                }

                $model->setQuantityInvoice($child->values['quantity']);
                Helpers_DB::saveDBObject($model, $sitePageData);
            }
        }

        return TRUE;
    }

    /**
     * Посчитать остатки ГТД приема продуктов
     * @param array $shopReceiveItemGTDIDs
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @param int $notShopInvoiceID
     * @return bool
     * @throws HTTP_Exception_404
     */
    public static function calcQuantityReceiveItemGTDIDs(array $shopReceiveItemGTDIDs, SitePageData $sitePageData,
                                               Model_Driver_DBBasicDriver $driver, $notShopInvoiceID = -1)
    {
        if(empty($shopReceiveItemGTDIDs)){
            return TRUE;
        }

        // находим список позиций, которые нужно пересчитать
        $shopInvoiceItemGTDs = Request_Request::find('DB_Magazine_Shop_Invoice_Item_GTD',
            $sitePageData->shopID, $sitePageData, $driver,
            Request_RequestParams::setParams(
                array(
                    'shop_receive_item_gtd_id' => $shopReceiveItemGTDIDs,
                    'shop_invoice_id_not' => $notShopInvoiceID,
                    'sum_quantity' => TRUE,
                    'group_by' => array(
                        'shop_receive_item_gtd_id',
                    ),
                )
            ),
            0, TRUE
        );
        $shopInvoiceItemGTDs->runIndex(true, 'shop_receive_item_gtd_id');

        $model = new Model_Magazine_Shop_Receive_Item_GTD();
        $model->setDBDriver($driver);
        foreach ($shopReceiveItemGTDIDs as $shopReceiveItemGTDID){
            if($shopReceiveItemGTDID < 1) {
                continue;
            }

            if (!Helpers_DB::getDBObject($model, $shopReceiveItemGTDID, $sitePageData)) {
                throw new HTTP_Exception_404('Receive item GTD id=' . $shopReceiveItemGTDID . ' not found.');
            }

            if(key_exists($shopReceiveItemGTDID, $shopInvoiceItemGTDs->childs)){
                $quantity = $shopInvoiceItemGTDs->childs[$shopReceiveItemGTDID]->values['quantity'];
            }else{
                $quantity = 0;
            }

            $model->setQuantityInvoice($quantity);
            Helpers_DB::saveDBObject($model, $sitePageData);
        }

        return TRUE;
    }

    /**
     * Получаем правильно ли ЭСФ
     * @param Model_Magazine_Shop_Receive_Item $model
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @return bool
     */
    public static function isESF(Model_Magazine_Shop_Receive_Item $model, SitePageData $sitePageData,
                                Model_Driver_DBBasicDriver $driver)
    {
        $shopReceiveItemGTDIDs = Request_Request::find('DB_Magazine_Shop_Receive_Item_GTD',
            $sitePageData->shopID, $sitePageData, $driver,
            Request_RequestParams::setParams(
                array(
                    'shop_receive_item_id' => $model->id,
                )
            ),
            0, TRUE
        );

        $amountAll = 0;
        $quantityAll = 0;
        $price = 0;
        foreach($shopReceiveItemGTDIDs->childs as $child){
            $amountAll = $amountAll + $child->values['amount'];
            $quantityAll = $quantityAll + $child->values['quantity'];
            $price = $child->values['price'];
        }

        return $model->getPrice() == $price && $model->getQuantity() == $quantityAll && $model->getAmount() == $amountAll;
    }

    /**
     * Сохраняем список ГТД продуктов приемки для ЭЛЕКТРОННОЙ счет-фактуры
     * @param Model_Magazine_Shop_Receive_Item $modelReceiveItem
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     */
    public static function saveElectronic(Model_Magazine_Shop_Receive_Item $modelReceiveItem, SitePageData $sitePageData,
                                          Model_Driver_DBBasicDriver $driver)
    {
        $shopReceiveItemGTDIDs = Request_Request::find('DB_Magazine_Shop_Receive_Item_GTD',
            $sitePageData->shopID, $sitePageData, $driver,
            Request_RequestParams::setParams(
                array(
                    'shop_receive_item_id' => $modelReceiveItem->id,
                )
            ),
            0, TRUE
        );

        $model = new Model_Magazine_Shop_Receive_Item_GTD();
        $model->setDBDriver($driver);

        $productESF = $modelReceiveItem->getESFObject();

        /** @var Helpers_ESF_Unload_Product_Record $recordESF */
        foreach($productESF->getRecords()->getValues() as $recordESF){
            $quantity = $recordESF->getQuantity();

            // ищем ГТД продукт приемки, который максимально совпадает с новой строкой
            $findIdentical = NULL;
            foreach ($shopReceiveItemGTDIDs->childs as $key => $child){
                if($child->values['quantity'] == $quantity){
                    $findIdentical = $key;
                    break;
                }
            }

            if($findIdentical !== NULL){
                $shopReceiveItemGTDIDs->childs[$findIdentical]->setModel($model);
                unset($shopReceiveItemGTDIDs->childs[$findIdentical]);
            }else{
                $model->clear();
            }

            $model->setTruOriginCode($recordESF->getTruOriginCode());
            $model->setProductDeclaration($recordESF->getDeclaration());
            $model->setProductNumberInDeclaration($recordESF->getNumberInDeclaration());
            $model->setCatalogTruID($recordESF->getCatalogTruID());

            $model->setShopProductID($modelReceiveItem->getShopProductID());
            $model->setPrice($recordESF->getPrice());
            $model->setQuantity($recordESF->getQuantity());
            $model->setShopReceiveID($modelReceiveItem->getShopReceiveID());
            $model->setShopReceiveItemID($modelReceiveItem->id);
            $model->setShopSupplierID($modelReceiveItem->getShopSupplierID());
            $model->setESFObject($recordESF);
            $model->setIsESF($modelReceiveItem->getIsESF());
            Helpers_DB::saveDBObject($model, $sitePageData, $modelReceiveItem->shopID);
        }

        $modelReceiveItem->setNDSPercent($productESF->getNDSPercent());

        // удаляем лишние
        if(count($shopReceiveItemGTDIDs->childs) > 0) {
            $driver->deleteObjectIDs(
                $shopReceiveItemGTDIDs->getChildArrayID(), $sitePageData->userID,
                Model_Magazine_Shop_Receive_Item::TABLE_NAME, array(), $sitePageData->shopID
            );
        }
    }

    /**
     * Сохраняем список ГТД продуктов приемки для БУМАЖНОЙ счет-фактуры
     * @param Model_Magazine_Shop_Receive_Item $modelReceiveItem
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     */
    public static function savePaper(Model_Magazine_Shop_Receive_Item $modelReceiveItem, SitePageData $sitePageData,
                                          Model_Driver_DBBasicDriver $driver)
    {
        $shopReceiveItemGTDIDs = Request_Request::find('DB_Magazine_Shop_Receive_Item_GTD',
            $sitePageData->shopID, $sitePageData, $driver,
            Request_RequestParams::setParams(
                array(
                    'shop_receive_item_id' => $modelReceiveItem->id,
                )
            ),
            0, TRUE
        );

        $model = new Model_Magazine_Shop_Receive_Item_GTD();
        $model->setDBDriver($driver);

        // ищем ГТД продукт приемки, который максимально совпадает с новой строкой
        $findIdentical = NULL;
        $quantity = $modelReceiveItem->getQuantity();
        foreach ($shopReceiveItemGTDIDs->childs as $key => $child){
            if($child->values['quantity'] == $quantity){
                $findIdentical = $key;
                break;
            }
        }

        if($findIdentical !== NULL){
            $shopReceiveItemGTDIDs->childs[$findIdentical]->setModel($model);
            unset($shopReceiveItemGTDIDs->childs[$findIdentical]);
        }else{
            $model->clear();
        }

        $model->setTruOriginCode('');
        $model->setProductDeclaration('');
        $model->setProductNumberInDeclaration('');

        $model->setShopProductID($modelReceiveItem->getShopProductID());
        $model->setPrice($modelReceiveItem->getPrice());
        $model->setQuantity($modelReceiveItem->getQuantity());
        $model->setShopReceiveID($modelReceiveItem->getShopReceiveID());
        $model->setShopReceiveItemID($modelReceiveItem->id);
        $model->setShopSupplierID($modelReceiveItem->getShopSupplierID());
        $model->setESF(NULL);
        $model->setIsESF($modelReceiveItem->getIsESF());
        Helpers_DB::saveDBObject($model, $sitePageData, $modelReceiveItem->shopID);

        // удаляем лишние
        if(count($shopReceiveItemGTDIDs->childs) > 0) {
            $driver->deleteObjectIDs(
                $shopReceiveItemGTDIDs->getChildArrayID(), $sitePageData->userID,
                Model_Magazine_Shop_Receive_Item::TABLE_NAME, array(), $sitePageData->shopID
            );
        }
    }
}
