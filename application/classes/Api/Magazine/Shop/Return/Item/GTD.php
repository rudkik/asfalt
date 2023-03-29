<?php defined('SYSPATH') or die('No direct script access.');

class Api_Magazine_Shop_Return_Item_GTD  {
    /**
     * Посчитать остатки ГТД приема продуктов
     * @param array $shopReceiveItemGTDIDs
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @param int $notShopInvoiceID
     * @return bool
     * @throws HTTP_Exception_404
     */
    public static function calcQuantityInvoice(array $shopReceiveItemGTDIDs, SitePageData $sitePageData,
                                               Model_Driver_DBBasicDriver $driver, $notShopInvoiceID = -1)
    {
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

                $model->setQuantityInvoice($child->childs['quantity']);
                Helpers_DB::saveDBObject($model, $sitePageData);
            }
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
