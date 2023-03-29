<?php defined('SYSPATH') or die('No direct script access.');

class Helpers_Discount {

    /**
     * Останавливаем скидку
     * @param Model_Shop_Discount $model
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     */
	public static function stopDiscount(Model_Shop_Discount $model, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver){
		// получаем список товаров, на которые распространяется данная скидка
		$shopGoodIDs = Request_Request::find('DB_Shop_Good',$model->shopID, $sitePageData, $driver,
            array('system_shop_discount_id' => $model->id, Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE));

		// скидываем у всех данную скидку
        $driver->updateObjects(Model_Shop_Good::TABLE_NAME, $shopGoodIDs->getChildArrayID(),
            array('system_is_discount' => 0, 'system_shop_discount_id' => 0, 'system_is_percent' => 0, 'system_discount' => 0),
            0, $model->shopID);

        $model->setIsPublic(FALSE);
        $model->setIsRun(FALSE);
        Helpers_DB::saveDBObject($model, $sitePageData);
	}

    /**
     * Останавливаем скидку по по ID
     * @param array $discountIDs
     * @param $shopID
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @return bool
     */
    public static function stopDiscountByID(array $discountIDs, $shopID, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver){
        if(empty($discountIDs)){
            return FALSE;
        }

        // получаем список товаров, на которые распространяется данная скидка
        $shopGoodIDs = Request_Request::find('DB_Shop_Good',$shopID, $sitePageData, $driver,
            array('system_shop_discount_id' => $discountIDs, Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE));

        // скидываем у всех данную скидку
        $driver->updateObjects(Model_Shop_Good::TABLE_NAME, $shopGoodIDs->getChildArrayID(),
            array('system_is_discount' => 0, 'system_shop_discount_id' => 0, 'system_is_percent' => 0, 'system_discount' => 0), 0, $shopID);

        return TRUE;
    }

    /**
     * Запускаем скидку
     * @param Model_Shop_Discount $model
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @return bool
     */
	public static function startDiscount(Model_Shop_Discount $model, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver){
        $countGoods = 0;
        $amountGoods = 0;
        $shopGoodIDs = array();
        switch ($model->getDiscountTypeID()) {
            case Model_DiscountType::DISCOUNT_TYPE_CATALOGS: {
                $arr = $model->getDataArray();
                $shopGoodcatalogIDs = Arr::path($arr, 'id', array());

                $countGoods = floatval(Arr::path($arr, 'count', 0));
                $amountGoods = floatval(Arr::path($arr, 'amount', 0));

                // получаем список товаров из категорий
                $ids = Request_Request::find('DB_Shop_Good',$model->shopID, $sitePageData, $driver,
                    array('shop_table_rubric_id' => $shopGoodcatalogIDs, Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE, 'is_public_ignore' => TRUE));
                $shopGoodIDs = $ids->getChildArrayID();
            }
                break;
            case Model_DiscountType::DISCOUNT_TYPE_GOODS: {
                $arr = $model->getDataArray();
                $shopGoodIDs = Arr::path($arr, 'id', array());

                $countGoods = floatval(Arr::path($arr, 'count', 0));
                $amountGoods = floatval(Arr::path($arr, 'amount', 0));
            }
                break;
            case Model_DiscountType::DISCOUNT_TYPE_GOOD: {
                $shopGoodIDs = array($model->getShopGoodID());

                $countGoods = 1;
                $amountGoods = 0;
            }
                break;
        }

        if(($countGoods == 1) && ($amountGoods == 0)){
            $discount = $model->getDiscount();
        }else{
            $discount = 0;
        }

        // если запущена скидка, то проверяем изменились ли товары для скидки
        if($model->getIsRun() === TRUE){
            // получаем список товаров, на которые распространяется данная скидка
            $discountShopGoodIDs = Request_Request::find('DB_Shop_Good',$model->shopID, $sitePageData, $driver,
                array('system_shop_discount_id' => $model->id, Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE));

            $b = count($discountShopGoodIDs->childs) == count($shopGoodIDs);
            if($b){
                foreach($shopGoodIDs as $shopGoodID){
                    foreach($discountShopGoodIDs->childs as $key => $discountShopGoodID){
                        if($shopGoodID == $discountShopGoodID->id){
                            unset($discountShopGoodIDs->childs[$key]);
                            break;
                        }
                    }
                }

                $b = count($discountShopGoodIDs->childs) != 0;
            }

            if($b){
                return TRUE;
            }

            // зануляем скидки для товаров, которые не подходят
            $driver->updateObjects(Model_Shop_Good::TABLE_NAME, $discountShopGoodIDs->getChildArrayID(),
                array('system_is_discount' => 1, 'system_shop_discount_id' => $model->id,
                    'system_is_percent' => 0, 'system_discount' => 0), 0, $model->shopID);
        }

        $driver->updateObjects(Model_Shop_Good::TABLE_NAME, $shopGoodIDs,
            array('system_is_discount' => 1, 'system_shop_discount_id' => $model->id,
                'system_is_percent' => $model->getIsPercent(), 'system_discount' => $discount), 0, $model->shopID);

        $model->setIsRun(TRUE);
        Helpers_DB::saveDBObject($model, $sitePageData);

        return TRUE;
	}


    /**
     * Запускаем скидки, которым пришло время
     * @param $shopID
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     */
	public static function runShopDiscounts($shopID, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver){
		$time = time();

		$model = new Model_Shop_Discount();
		$model->setDBDriver($driver);

		// получаем список скидок, которые запущены, и проверяем, должны ли они работать
		$shopDiscountIDs = Request_Request::find(
            DB_Shop_Discount::NAME, $shopID, $sitePageData, $driver,
            array('is_run' => TRUE, 'is_public_ignore' => TRUE, 'is_delete_ignore' => TRUE, Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE));

		foreach ($shopDiscountIDs->childs as $shopDiscountID) {
            if ($model->dbGet($shopDiscountID->id, $sitePageData->dataLanguageID, $sitePageData->languageIDDefault,  -1, $shopID)){
                if (($time < strtotime($model->getFromAt()) ||  ($time > strtotime($model->getToAt()))) || ($model->getIsDelete() === TRUE) || ($model->getIsPublic() === FALSE)){
                    self::stopDiscount($model, $sitePageData, $driver);
                }
            }
		}

        // получаем все завершеные и пинудительно их отключаем (где-то не учтено закрытие скидки)
        $shopDiscountIDs = Request_Request::find(
            DB_Shop_Discount::NAME, $shopID, $sitePageData, $driver,
            array('is_run' => FALSE, 'is_public_ignore' => TRUE, 'is_delete_ignore' => TRUE, Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE));
        self::stopDiscountByID($shopDiscountIDs->getChildArrayID(), $shopID, $sitePageData, $driver);

        // получаем список скидок, которые активные, но не запущены и проверяем,
        // должны ли они работать
        $shopDiscountIDs = Request_Request::find(
            DB_Shop_Discount::NAME, $shopID, $sitePageData, $driver,
            array('is_public' => TRUE, 'to_from_at' => date('Y-m-d H:i:s', $time), 'from_to_at' => date('Y-m-d H:i:s', $time), Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE));

        foreach ($shopDiscountIDs->childs as $shopDiscountID) {
            if ($model->dbGet($shopDiscountID->id, $sitePageData->dataLanguageID, $sitePageData->languageIDDefault,  -1, $shopID)) {
                if (($time >= strtotime($model->getFromAt())) && ($time < strtotime($model->getToAt()))) {
                    self::startDiscount($model, $sitePageData, $driver);
                }
            }
        }

        // получаем список скидок, которые запущены, и проверяем, должны ли они работать
        $shopIDs = Request_Shop::getBranchShopIDs($shopID, $sitePageData, $driver)->getChildArrayID();
        if(!empty($shopIDs)) {
            $shopDiscountIDs = Request_Request::findBranch(
                DB_Shop_Discount::NAME, $shopIDs, $sitePageData, $driver,
                array('is_run' => TRUE, 'is_public_ignore' => TRUE, 'is_delete_ignore' => TRUE, Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE));

            foreach ($shopDiscountIDs->childs as $shopDiscountID) {
                if ($model->dbGet($shopDiscountID->id, $sitePageData->dataLanguageID, $sitePageData->languageIDDefault,  -1, $shopDiscountID->values['shop_id'])) {
                    if (($time < strtotime($model->getFromAt()) || ($time > strtotime($model->getToAt()))) || ($model->getIsDelete() === TRUE) || ($model->getIsPublic() === FALSE)) {
                        self::stopDiscount($model, $sitePageData, $driver);
                    }
                }
            }

            // получаем все завершеные и пинудительно их отключаем (где-то не учтено закрытие скидки)
            foreach ($shopIDs as $shopID) {
                $shopDiscountIDs = Request_Request::find(
                    DB_Shop_Discount::NAME, $shopID, $sitePageData, $driver,
                    array('is_run' => FALSE, 'is_public_ignore' => TRUE, 'is_delete_ignore' => TRUE, Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE));
                self::stopDiscountByID($shopDiscountIDs->getChildArrayID(), $shopID, $sitePageData, $driver);
            }

            // получаем список скидок, которые активные, но не запущены и проверяем,
            // должны ли они работать
            $shopDiscountIDs = Request_Request::findBranch(
                DB_Shop_Discount::NAME, $shopIDs, $sitePageData, $driver,
                array('is_public' => TRUE, 'to_from_at' => date('Y-m-d H:i:s', $time), 'from_to_at' => date('Y-m-d H:i:s', $time), Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE));

            foreach ($shopDiscountIDs->childs as $shopDiscountID) {
                if ($model->dbGet($shopDiscountID->id, $sitePageData->dataLanguageID, $sitePageData->languageIDDefault,  -1, $shopDiscountID->values['shop_id'])) {
                    if (($time >= strtotime($model->getFromAt())) && ($time < strtotime($model->getToAt())) && ($model->getIsDelete() === FALSE)) {
                        self::startDiscount($model, $sitePageData, $driver);
                    }
                }
            }
        }
	}
}