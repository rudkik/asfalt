<?php defined('SYSPATH') or die('No direct script access.');

class Api_Shop_Action  {

    /**
     * Сохранение списка товаров
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     */
    public static function saveListCollations($shopTableCatalogID, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        $model = new Model_Shop_Action();
        $model->setDBDriver($driver);

        $shopActions = Request_RequestParams::getParamArray('data', array());
        foreach ($shopActions as &$shopAction) {
            $model->clear();

            $id = intval(Arr::path($shopAction, 'shop_action_id', 0));
            if ($id > 0) {
                if (!Helpers_DB::dublicateObjectLanguage($model, $id, $sitePageData, $sitePageData->shopID)) {
                    continue;
                }
            } else {
                $model->setShopTableCatalogID($shopTableCatalogID);
            }

            if($id < 1) {
                if (key_exists('is_public', $shopAction)) {
                    $model->setIsPublic($shopAction['is_public']);
                }
                if (key_exists('collations', $shopAction)) {
                    $model->addCollationsArray($shopAction['collations']);
                }
                if (key_exists('old_id', $shopAction)) {
                    $model->setOldID($shopAction['old_id']);
                }
                if (key_exists('name', $shopAction)) {
                    if (!empty($shopAction['name'])) {
                        $model->setName($shopAction['name']);
                    }
                }
                if (key_exists('text', $shopAction)) {
                    $model->setText($shopAction['text']);
                }
            }

            $shopAction['shop_action_id'] = Helpers_DB::saveDBObject($model, $sitePageData, $sitePageData->shopID);
            $shopAction['shop_action_name'] = $model->getName();
        }

        return $shopActions;
    }

    /**
     * Сохранение списка товаров
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     */
    public static function saveList(SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        $model = new Model_Shop_Action();
        $model->setDBDriver($driver);

        $shopActions = Request_RequestParams::getParamArray('shop_actions', array());
        if ($shopActions === NULL) {
            return FALSE;
        }

        foreach ($shopActions as $id => $shopAction) {
            $id = intval($id);
            if ($id > 0) {
                if (!Helpers_DB::dublicateObjectLanguage($model, $id, $sitePageData, $sitePageData->shopID)) {
                    continue;
                }

                if (key_exists('is_public', $shopAction)) {
                    $model->setIsPublic($shopAction['is_public']);
                }
                if (key_exists('name', $shopAction)) {
                    if (!empty($shopAction['name'])) {
                        $model->setName($shopAction['name']);
                    }
                }

                if (key_exists('text', $shopAction)) {
                    $model->setText($shopAction['text']);
                }

                if (key_exists('remarketing', $shopAction)) {
                    $model->setRemarketing($shopAction['remarketing']);
                }
                if (key_exists('collations', $shopAction)) {
                    $options = $shopAction['collations'];
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

        $model = new Model_Shop_Action();
        $model->setDBDriver($driver);

        if (!Helpers_DB::dublicateObjectLanguage($model, $id, $sitePageData)) {
            throw new HTTP_Exception_500('Action not found.');
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
        $model = new Model_Shop_Action();
        $model->setDBDriver($driver);

        $id = Request_RequestParams::getParamInt('id');
        if($id > 0) {
            if (!Helpers_DB::dublicateObjectLanguage($model, $id, $sitePageData)) {
                throw new HTTP_Exception_500('Action not found.');
            }
        }

        Request_RequestParams::setParamBoolean('is_public', $model);
        Request_RequestParams::setParamStr('text', $model);
        Request_RequestParams::setParamStr('name', $model);
        Request_RequestParams::setParamBoolean("is_public", $model);
        Request_RequestParams::setParamInt("order", $model);
        Request_RequestParams::setParamBoolean("is_group", $model);
        Request_RequestParams::setParamStr("old_id", $model);
        Request_RequestParams::setParamStr('remarketing', $model);
        Request_RequestParams::setParamDateTime('from_at', $model);
        Request_RequestParams::setParamDateTime('to_at', $model);

        // тип акции
        Request_RequestParams::setParamInt('action_type_id', $model);
        switch ($model->getActionTypeID()) {
            case Model_ActionType::ACTION_TYPE_BILL_AMOUNT:
                $data = Request_RequestParams::getParamFloat('amount');
                if ($data !== NULL) {
                    $model->setDataArray(array('amount' => $data));
                }else{
                    $model->setActionTypeID(0);
                    $model->setDataArray(array());
                }
                break;
            case Model_ActionType::ACTION_TYPE_CATALOGS:
                $data = array();

                $catalogs = Request_RequestParams::getParamArray('shop_table_rubric_ids', array(), array());
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
                    $model->setActionTypeID(0);
                    $model->setDataArray(array());
                }

                break;
            case Model_ActionType::ACTION_TYPE_GOODS:
                $data = array();

                $catalogs = Request_RequestParams::getParamArray('shop_good_ids', array(), array());
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
                    $model->setActionTypeID(0);
                    $model->setDataArray(array());
                }
                break;
            default:
                $model->setActionTypeID(0);
                $model->setDataArray(array());

        }

        // подарок
        Request_RequestParams::setParamInt('gift_type_id', $model);
        switch ($model->getGiftTypeID()) {
            case Model_GiftType::GIFT_TYPE_BILL_COMMENT:
                $data = Request_RequestParams::getParamStr('gift_bill_comment');
                if ($data !== NULL) {
                    $model->setGiftIDsArray(array('comment' => $data));
                }else{
                    $model->setGiftTypeID(0);
                    $model->setGiftIDsArray(array());
                }
                break;
            case Model_GiftType::GIFT_TYPE_BILL_GIFT:
                $data = array();

                $catalogs = Request_RequestParams::getParamArray('gift_shop_good_ids', array(), array());
                foreach($catalogs as $catalog){
                    $catalog = intval($catalog);
                    if($catalog > 0){
                        $data[] = $catalog;
                    }
                }
                $count = Request_RequestParams::getParamInt('gift_shop_goods_count');
                if((! empty($data)) && ($count > 0)){
                    $model->setGiftIDsArray(
                        array(
                            'id' => $data,
                            'count' => $count,
                        )
                    );
                }else{
                    $model->setGiftTypeID(0);
                    $model->setGiftIDsArray(array());
                }
                break;
            default:
                $model->setGiftTypeID(0);
                $model->setGiftIDsArray(array());

        }

        $options = Request_RequestParams::getParamArray('options');
        if ($options !== NULL) {
            $model->addOptionsArray($options);
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

            // активируем акции
            Helpers_Action::runShopActions($sitePageData->shopMainID, $sitePageData, $driver);
        }

        return array(
            'id' => $model->id,
            'result' => $result,
        );
    }
}
