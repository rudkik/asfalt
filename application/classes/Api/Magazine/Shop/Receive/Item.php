<?php defined('SYSPATH') or die('No direct script access.');

class Api_Magazine_Shop_Receive_Item  {

    /**
     * Сохранение список
     * @param Model_Magazine_Shop_Receive $modelReceive
     * @param array $shopReceiveItems
     * @param Helpers_ESF_Unload_Products $productsESF
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @param bool $isEditLastPrice
     * @return array
     */
    public static function save(Model_Magazine_Shop_Receive $modelReceive, array $shopReceiveItems, Helpers_ESF_Unload_Products $productsESF,
                                SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver, $isEditLastPrice = TRUE)
    {
        $model = new Model_Magazine_Shop_Receive_Item();
        $model->setDBDriver($driver);

        $modelGTD = new Model_Magazine_Shop_Receive_Item_GTD();
        $modelGTD->setDBDriver($driver);

        $modelProduct = new Model_Magazine_Shop_Product();
        $modelProduct->setDBDriver($driver);

        if($isEditLastPrice){
            $findID = array($modelReceive->id, 0);
        }else{
            $findID = $modelReceive->id;
        }

        // получаем продуктов приемки
        $shopReceiveItemIDs = Request_Request::find('DB_Magazine_Shop_Receive_Item',
            $sitePageData->shopID, $sitePageData, $driver,
            Request_RequestParams::setParams(
                array(
                    'shop_receive_id' => $findID,
                )
            ), 0, TRUE
        );

        $amountAll = 0;
        $quantityAll = 0;
        $isESF = TRUE;
        foreach($shopReceiveItems as $shopReceiveItem){
            $quantity = Request_RequestParams::strToFloat(Arr::path($shopReceiveItem, 'quantity', 0));
            if($quantity <= 0){
                continue;
            }
            $price = Request_RequestParams::strToFloat(Arr::path($shopReceiveItem, 'price', 0));
            $shopProductID = intval(Arr::path($shopReceiveItem, 'shop_product_id', 0));
            if($shopProductID <= 0){
                continue;
            }
            if(!Helpers_DB::getDBObject($modelProduct, $shopProductID, $sitePageData, $sitePageData->shopMainID)){
                continue;
            }

            /** Создаем строку продукции приемки  */

            // ищем продукт приемки, который максимально совпадает с новой строкой
            $findProduct = NULL;
            $findIdentical = NULL;
            foreach ($shopReceiveItemIDs->childs as $key => $child){
                if($child->values['shop_product_id'] == $shopProductID){
                    if($findProduct === NULL) {
                        $findProduct = $key;
                    }
                    if($child->values['quantity'] == $quantity){
                        $findProduct = $key;
                        if($child->values['price'] == $price){
                            $findIdentical = $key;
                            break;
                        }
                    }
                }
            }
            if($findIdentical !== NULL){
                $shopReceiveItemIDs->childs[$findIdentical]->setModel($model);
                unset($shopReceiveItemIDs->childs[$findIdentical]);
            }elseif($findProduct !== NULL){
                $shopReceiveItemIDs->childs[$findProduct]->setModel($model);
                unset($shopReceiveItemIDs->childs[$findProduct]);

                $isESF = FALSE;
            }else{
                $model->clear();
                $isESF = FALSE;
            }

            $model->setShopProductID($shopProductID);
            $model->setQuantity($quantity);
            $model->setPrice($price);
            $amount = Request_RequestParams::strToFloat(Arr::path($shopReceiveItem, 'amount', 0));
            if(abs($model->getAmount() - $amount) < 10){
                $model->setAmount($amount);
            }

            $model->setShopReceiveID($modelReceive->id);
            $model->setShopSupplierID($modelReceive->getShopSupplierID());
            $model->setIsNDS($modelReceive->getIsNDS());
            $model->setIsESF(
                $model->id > 0
                && $model->getESF()
                && Api_Magazine_Shop_Receive_Item_GTD::isESF($model, $sitePageData, $driver)
            );
            if(!Func::_empty($modelReceive->getDate()) && Helpers_DateTime::getDateFormatPHP($model->getCreatedAt()) != Helpers_DateTime::getDateFormatPHP($modelReceive->getDate())){
                $model->setCreatedAt($modelReceive->getDate());
            }
            $isESF = $isESF && $model->getIsESF();
            Helpers_DB::saveDBObject($model, $sitePageData);

            // сохраняем последную цену приемки
            if ($isEditLastPrice) {
                $modelProduct->setPricePurchase($model->getPrice());
            }

            $priceNotNDS = Api_Tax_NDS::getAmountWithoutNDS($model->getPrice(), $model->getIsNDS());
            // себестоимость
            if($modelProduct->getPriceCost() < $model->getPrice()){
                $modelProduct->setPriceCost($model->getPrice());
                $modelProduct->setPriceCostWithoutNDS($priceNotNDS);
            }elseif($modelProduct->getPriceCostWithoutNDS() == 0){
                $modelProduct->setPriceCostWithoutNDS($priceNotNDS);
            }
            Helpers_DB::saveDBObject($modelProduct, $sitePageData);

            // Создаем / изменяем продукцию напрямую связанные с продуктом
            Api_Magazine_Shop_Production::editProduction($modelProduct, $sitePageData, $driver);

            // приход продуктов
            Api_Magazine_Shop_Product::calcComing($shopProductID, $sitePageData, $driver, TRUE);

            // среднюю стоимость
            if ($isEditLastPrice) {
                $modelProduct->setPriceAverage(Api_Magazine_Shop_Product::calcPriceAverage($shopProductID,  $sitePageData, $driver));
                Helpers_DB::saveDBObject($modelProduct, $sitePageData);
            }

            $amountAll = $amountAll + $model->getAmount();
            $quantityAll = $quantityAll + $model->getQuantity();
        }

        // удаляем лишние
        if(count($shopReceiveItemIDs->childs) > 0) {
            // удаляем привязку к ЭСФ
            foreach ($shopReceiveItemIDs->childs as $child){
                $child->setModel($model);
                $product = $productsESF->findProductByHash($model->getESFObject()->getHash());
                if($product !== FALSE){
                    $product->setShopReceiveItemID(0);
                }
            }

            // удаляем продкуты приемки
            $ids = $shopReceiveItemIDs->getChildArrayID();
            $driver->deleteObjectIDs(
                $ids, $sitePageData->userID,
                Model_Magazine_Shop_Receive_Item::TABLE_NAME, array(), $sitePageData->shopID
            );

            // удаляем ГТД продуктов приемки
            $shopReceiveItemGTDIDs = Request_Request::find('DB_Magazine_Shop_Receive_Item_GTD', 
                $sitePageData->shopID, $sitePageData, $driver,
                Request_RequestParams::setParams(
                    array(
                        'shop_receive_item_id' => $ids,
                    )
                ), 0, TRUE
            );
            $driver->deleteObjectIDs(
                $shopReceiveItemGTDIDs->getChildArrayID(), $sitePageData->userID,
                Model_Magazine_Shop_Receive_Item_GTD::TABLE_NAME, array(), $sitePageData->shopID
            );

            $isESF = FALSE;
        }

        return array(
            'amount' => $amountAll,
            'quantity' => $quantityAll,
            'is_esf' => $isESF,
        );
    }
}
