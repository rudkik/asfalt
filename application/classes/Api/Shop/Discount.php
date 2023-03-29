<?php defined('SYSPATH') or die('No direct script access.');

class Api_Shop_Discount  {

    /**
     * Сохранение списка товаров
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     */
    public static function saveListCollations($shopTableCatalogID, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        $model = new Model_Shop_Discount();
        $model->setDBDriver($driver);

        $shopDiscounts = Request_RequestParams::getParamArray('data', array());
        foreach ($shopDiscounts as &$shopDiscount) {
            $model->clear();

            $id = intval(Arr::path($shopDiscount, 'shop_discount_id', 0));
            if ($id > 0) {
                if (!Helpers_DB::dublicateObjectLanguage($model, $id, $sitePageData, $sitePageData->shopID)) {
                    continue;
                }
            } else {
                $model->setShopTableCatalogID($shopTableCatalogID);
            }

            if($id < 1) {
                if (key_exists('is_public', $shopDiscount)) {
                    $model->setIsPublic($shopDiscount['is_public']);
                }
                if (key_exists('collations', $shopDiscount)) {
                    $model->addCollationsArray($shopDiscount['collations']);
                }
                if (key_exists('old_id', $shopDiscount)) {
                    $model->setOldID($shopDiscount['old_id']);
                }
                if (key_exists('name', $shopDiscount)) {
                    if (!empty($shopDiscount['name'])) {
                        $model->setName($shopDiscount['name']);
                    }
                }
                if (key_exists('text', $shopDiscount)) {
                    $model->setText($shopDiscount['text']);
                }
            }

            $shopDiscount['shop_discount_id'] = Helpers_DB::saveDBObject($model, $sitePageData, $sitePageData->shopID);
            $shopDiscount['shop_discount_name'] = $model->getName();
        }

        return $shopDiscounts;
    }

    /**
     * Сохранение списка товаров
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     */
    public static function saveList(SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        $model = new Model_Shop_Discount();
        $model->setDBDriver($driver);

        $shopDiscounts = Request_RequestParams::getParamArray('shop_discounts', array());
        if ($shopDiscounts === NULL) {
            return FALSE;
        }

        foreach ($shopDiscounts as $id => $shopDiscount) {
            $id = intval($id);
            if ($id > 0) {
                if (!Helpers_DB::dublicateObjectLanguage($model, $id, $sitePageData, $sitePageData->shopID)) {
                    continue;
                }

                if (key_exists('is_public', $shopDiscount)) {
                    $model->setIsPublic($shopDiscount['is_public']);
                }
                if (key_exists('name', $shopDiscount)) {
                    if (!empty($shopDiscount['name'])) {
                        $model->setName($shopDiscount['name']);
                    }
                }
                if (key_exists('text', $shopDiscount)) {
                    $model->setText($shopDiscount['text']);
                }
                if (key_exists('remarketing', $shopDiscount)) {
                    $model->setRemarketing($shopDiscount['remarketing']);
                }
                if (key_exists('collations', $shopDiscount)) {
                    $options = $shopDiscount['collations'];
                    if (!is_array($options)) {
                        $options = explode("\r\n", $options);
                    }
                    $model->addCollationsArray($options);
                }

                Helpers_DB::saveDBObject($model, $sitePageData, $sitePageData->shopID);
            }
        }
    }

    /**
     * удаление товара
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

        $model = new Model_Shop_Discount();
        $model->setDBDriver($driver);

        if (!Helpers_DB::dublicateObjectLanguage($model, $id, $sitePageData)) {
            throw new HTTP_Exception_500('Discount not found.');
        }

        if(Request_RequestParams::getParamBoolean("is_undel") === TRUE){
            $model->dbUnDelete($sitePageData->userID, 0, $sitePageData->shopID);
        }else {
            $model->dbDelete($sitePageData->userID, 0, $sitePageData->shopID);
        }
    }

    /**
     * Сохранение товары
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @throws HTTP_Exception_500
     */
    public static function save(SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        $model = new Model_Shop_Discount();
        $model->setDBDriver($driver);

        $id = Request_RequestParams::getParamInt('id');
        if($id > 0) {
            if (!Helpers_DB::dublicateObjectLanguage($model, $id, $sitePageData)) {
                throw new HTTP_Exception_500('Discount not found.');
            }
        }

        Request_RequestParams::setParamBoolean('is_public', $model);
        Request_RequestParams::setParamStr('name', $model);
        Request_RequestParams::setParamDateTime('from_at', $model);
        Request_RequestParams::setParamDateTime('to_at', $model);
        Request_RequestParams::setParamStr('text', $model);

        Request_RequestParams::setParamInt('discount_type_id', $model);
        switch ($model->getDiscountTypeID()) {
            case Model_DiscountType::DISCOUNT_TYPE_BILL_AMOUNT:
                $data = Request_RequestParams::getParamFloat('amount');
                if ($data !== NULL) {
                    $model->setDataArray(array('amount' => $data));
                }else{
                    $model->setDiscountTypeID(0);
                    $model->setDataArray(array());
                }
                break;
            case Model_DiscountType::DISCOUNT_TYPE_CATALOGS:
                $data = array();

                $catalogs = Request_RequestParams::getParamArray('shop_table_rubric_ids');
                foreach($catalogs as $catalog){
                    $catalog = intval($catalog);
                    if($catalog > 0){
                        $data[] = $catalog;
                    }
                }

                $count = Request_RequestParams::getParamFloat('shop_table_rubrics_count');
                $amount = Request_RequestParams::getParamFloat('shop_table_rubrics_amount');
                if((! empty($data)) && (($count > 0) || ($amount > 0))){
                    $model->setDataArray(
                        array(
                            'id' => $data,
                            'count' => $count,
                            'amount' => $amount
                        )
                    );
                }else{
                    $model->setDiscountTypeID(0);
                    $model->setDataArray(array());
                }

                break;
            case Model_DiscountType::DISCOUNT_TYPE_GOODS:
                $data = array();

                $catalogs = Request_RequestParams::getParamArray('shop_good_ids');
                foreach($catalogs as $catalog){
                    $catalog = intval($catalog);
                    if($catalog > 0){
                        $data[] = $catalog;
                    }
                }

                $count = Request_RequestParams::getParamFloat('shop_goods_count');
                $amount = Request_RequestParams::getParamFloat('shop_goods_amount');
                if((! empty($data)) && (($count > 0) || ($amount > 0))){
                    $model->setDataArray(
                        array(
                            'id' => $data,
                            'count' => $count,
                            'amount' => $amount
                        )
                    );
                }else{
                    $model->setDiscountTypeID(0);
                    $model->setDataArray(array());
                }
                break;
            case Model_DiscountType::DISCOUNT_TYPE_GOOD:
                Request_RequestParams::setParamInt('shop_good_id', $model);
                break;
            default:
                $model->setDiscountTypeID(0);
                $model->setDataArray(array());
        }

        // подарок
        Request_RequestParams::setParamInt('gift_type_id', $model);
        switch ($model->getGiftTypeID()) {
            case Model_GiftType::GIFT_TYPE_BILL_COMMENT:
                $data = Request_RequestParams::getParamStr('bill_comment');
                if ($data !== NULL) {
                    $model->setBillComment($data);
                    $model->setDiscount(0);
                    $model->setIsPercent(FALSE);
                }else{
                    $model->setGiftTypeID(0);
                    $model->setDiscount(0);
                    $model->setIsPercent(FALSE);
                    $model->setBillComment('');
                }
                break;
            case Model_GiftType::GIFT_TYPE_BILL_DISCOUNT:
                $discount = Request_RequestParams::getParamFloat('discount');
                if($discount > 0){
                    Request_RequestParams::setParamBoolean('is_percent', $model);
                    $model->setDiscount($discount);
                    $model->setBillComment('');
                }else{
                    $model->setGiftTypeID(0);
                    $model->setDiscount(0);
                    $model->setIsPercent(FALSE);
                    $model->setBillComment('');
                }
                break;
            case Model_GiftType::GIFT_TYPE_BILL_DISCOUNT_AND_COMMENT:
                $discount = Request_RequestParams::getParamFloat('discount');
                Request_RequestParams::setParamStr('bill_comment', $model);
                if($discount > 0){
                    Request_RequestParams::setParamBoolean('is_percent', $model);
                    $model->setDiscount($discount);
                }else{
                    $model->setDiscount(0);
                    $model->setIsPercent(FALSE);
                }
                break;
            default:
                $model->setGiftTypeID(0);
                $model->setDiscount(0);
                $model->setIsPercent(FALSE);
                $model->setBillComment('');
        }

        $seo = Request_RequestParams::getParamArray('seo');
        if ($seo !== NULL) {
            $model->setSEOArray($seo);
        }

        $result = array();
        if ($model->validationFields($result)) {
            if($model->id < 1) {
                Helpers_DB::saveDBObject($model, $sitePageData);
            }

            // загружаем фотографии
            $file = new Model_File($sitePageData);
            $file->saveFiles(Request_RequestParams::getParamArray('files'), $model, $sitePageData, $driver);

            Helpers_DB::saveDBObject($model, $sitePageData);
            $result['values'] = $model->getValues();

            Helpers_Discount::runShopDiscounts($sitePageData->shopMainID, $sitePageData, $driver);
        }

        return array(
            'id' => $model->id,
            'result' => $result,
        );


    }


    /**
     * Пересчитываем количество товаров
     * @param $shopDiscountID
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @return bool|int
     */
    public static function countUpStorageShopDiscount($shopDiscountID, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver){
        $storageCount = Request_Shop_Discount::getShopDiscountItemStorageCount($sitePageData->shopID, $shopDiscountID,
            $sitePageData, $driver);
        return 0;

        $model = new Model_Shop_Discount();
        $model->setDBDriver($driver);
        if (!Helpers_DB::getDBObject($model, $shopDiscountID, $sitePageData)) {
            return TRUE;
        }

        $modelCatalog = new Model_Shop_Table_Rubric();
        $modelCatalog->setDBDriver($driver);

        if($storageCount === NULL) {
            $storageCount = Request_Shop_Discount::getShopDiscountStorageCount($sitePageData->shopID, $model->getShopTableRubricID(),
                $sitePageData, $driver);

            if (!Helpers_DB::getDBObject($modelCatalog, $model->getShopTableRubricID(), $sitePageData)){
                return TRUE;
            }

            // разницу узнаем в количестве
            $shiftStorageCount = $storageCount - $modelCatalog->getStorageCount();
            if ($shiftStorageCount == 0) {
                return TRUE;
            }

            $modelCatalog->setStorageCount($storageCount);
            Helpers_DB::saveDBObject($modelCatalog, $sitePageData, $sitePageData->shopID);
            $shopDiscountCatalogID = $modelCatalog->getRootID();
        }else{
            // разницу узнаем в количестве
            $shiftStorageCount = $storageCount - $model->getStorageCount();
            if ($shiftStorageCount == 0) {
                return TRUE;
            }

            $model->setStorageCount($storageCount);
            $model->id = $shopDiscountID;
            Helpers_DB::saveDBObject($model, $sitePageData, $sitePageData->shopID);

            $shopDiscountCatalogID = $model->getShopTableRubricID();
        }

        $i = 0;
        while(($shopDiscountCatalogID > 0) && ($i < 50)){
            if (!Helpers_DB::getDBObject($modelCatalog, $shopDiscountCatalogID, $sitePageData)){
                return TRUE;
            }
            $modelCatalog->setStorageCount($modelCatalog->getStorageCount() + $shiftStorageCount);
            Helpers_DB::saveDBObject($modelCatalog, $sitePageData, $sitePageData->shopID);

            $shopDiscountCatalogID = $modelCatalog->getRootID();
            $i++;
        }
    }


    /**
     * Посчитать количетсво на складе
     * @param integer $shopID
     * @param Model_Driver_DBBasicDriver $driver
     * @param boolean $isIgnorIsPublic
     * @param integer $limit
     * @return MyArray
     */
    public static function getShopDiscountItemStorageCount($shopID, $shopDiscountID, SitePageData $sitePageData,
                                                       Model_Driver_DBBasicDriver $driver){
        $sql = GlobalData::newModelDriverDBSQL();
        $sql->getRootSelect()->addFunctionField('', 'storage_count', Model_Driver_DBBasicSelect::FUNCTION_SUM, 'storage_sum');
        $sql->setTableName(Model_Shop_DiscountItem::TABLE_NAME);

        $sql->getRootWhere()->addField("is_delete", '', 0);
        $sql->getRootWhere()->addField("shop_id", '', $shopID);
        $sql->getRootWhere()->addField("shop_discount_id", '', $shopDiscountID);

        $arr = $driver->getSelect($sql, TRUE, 0, $shopID)['result'];

        if(count($arr) == 0){
            return NULL;
        }else{
            return $arr[0]['storage_sum'];
        }
    }

}
