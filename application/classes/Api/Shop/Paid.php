<?php defined('SYSPATH') or die('No direct script access.');

class Api_Shop_Paid  {

    /**
     * Сохранение списка товаров
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     */
    public static function saveListCollations($shopTableCatalogID, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        $model = new Model_Shop_Paid();
        $model->setDBDriver($driver);

        $shopPaids = Request_RequestParams::getParamArray('data', array());
        foreach ($shopPaids as &$shopPaid) {
            $model->clear();

            $id = intval(Arr::path($shopPaid, 'shop_paid_id', 0));
            if ($id > 0) {
                if (!Helpers_DB::dublicateObjectLanguage($model, $id, $sitePageData, $sitePageData->shopID)) {
                    continue;
                }
            } else {
                $model->setShopTableCatalogID($shopTableCatalogID);
            }

            if($id < 1) {
                if (key_exists('is_public', $shopPaid)) {
                    $model->setIsPublic($shopPaid['is_public']);
                }
                if (key_exists('collations', $shopPaid)) {
                    $model->addCollationsArray($shopPaid['collations']);
                }
                if (key_exists('old_id', $shopPaid)) {
                    $model->setOldID($shopPaid['old_id']);
                }
                if (key_exists('name', $shopPaid)) {
                    if (!empty($shopPaid['name'])) {
                        $model->setName($shopPaid['name']);
                    }
                }
                if (key_exists('text', $shopPaid)) {
                    $model->setText($shopPaid['text']);
                }
            }

            $options = array();
            foreach($shopPaid as $k => $v){
                if(strpos($k, 'options.') === 0){
                    $options[str_replace('options.', '', $k)] = $v;
                }
            }
            $model->addOptionsArray($options, FALSE);

            if (key_exists('user_name', $shopPaid)) {
                $model->setUserName($shopPaid['user_name']);
            }

            $shopPaid['shop_paid_id'] = Helpers_DB::saveDBObject($model, $sitePageData, $sitePageData->shopID);
            $shopPaid['shop_paid_name'] = $model->getName();
        }

        return $shopPaids;
    }

    /**
     * Сохранение списка товаров
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     */
    public static function saveList(SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        $model = new Model_Shop_Paid();
        $model->setDBDriver($driver);

        $shopPaids = Request_RequestParams::getParamArray('shop_paids', array());
        if ($shopPaids === NULL) {
            return FALSE;
        }

        foreach ($shopPaids as $id => $shopPaid) {
            $id = intval($id);
            if ($id > 0) {
                if (!Helpers_DB::dublicateObjectLanguage($model, $id, $sitePageData, $sitePageData->shopID)) {
                    continue;
                }

                if (key_exists('is_public', $shopPaid)) {
                    $model->setIsPublic($shopPaid['is_public']);
                }
                if (key_exists('name', $shopPaid)) {
                    if (!empty($shopPaid['name'])) {
                        $model->setName($shopPaid['name']);
                    }
                }

                if (key_exists('text', $shopPaid)) {
                    $model->setText($shopPaid['text']);
                }

                if (key_exists('shop_table_rubric_id', $shopPaid)) {
                    $model->setShopTableRubricID($shopPaid['shop_table_rubric_id']);
                }

                if (key_exists('options', $shopPaid)) {
                    $options = $shopPaid['options'];
                    if (is_array($options)) {
                        $model->addOptionsArray($options);
                    }
                }
                if (key_exists('collations', $shopPaid)) {
                    $options = $shopPaid['collations'];
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

        $model = new Model_Shop_Paid();
        $model->setDBDriver($driver);

        if (!Helpers_DB::dublicateObjectLanguage($model, $id, $sitePageData)) {
            throw new HTTP_Exception_500('Paid not found.');
        }

        $isUnDel = Request_RequestParams::getParamBoolean("is_undel");
        if((($isUnDel === TRUE) && (!$model->getIsDelete()))
            || (($isUnDel !== TRUE) && ($model->getIsDelete()))){
            return FALSE;
        }

        if(($model->getPaidShopID() > 0) && ($model->getAmount() != 0)){
            $modelShop = new Model_Shop();
            $modelShop->setDBDriver($driver);

            // редактируем баланс
            if (Helpers_DB::getDBObject($modelShop, $model->getPaidShopID(), $sitePageData)) {
                if(Request_RequestParams::getParamBoolean("is_undel") === TRUE) {
                    $modelShop->setBalance($modelShop->getBalance() + $model->getAmount());
                }else{
                    $modelShop->setBalance($modelShop->getBalance() - $model->getAmount());
                }
                Helpers_DB::saveDBObject($modelShop, $sitePageData);
            }
        }

        if($isUnDel === TRUE){
            $model->dbUnDelete($sitePageData->userID, 0, $sitePageData->shopID);
        }else {
            $model->dbDelete($sitePageData->userID, 0, $sitePageData->shopID);
        }

        return TRUE;
    }

    /**
     * Сохранение товары
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @throws HTTP_Exception_500
     */
    public static function save(SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        $model = new Model_Shop_Paid();
        $model->setDBDriver($driver);

        $id = Request_RequestParams::getParamInt('id');
        if($id > 0) {
            if (!Helpers_DB::dublicateObjectLanguage($model, $id, $sitePageData)) {
                throw new HTTP_Exception_500('Paid not found.');
            }

            $type = $model->getShopTableCatalogID();
        }else{
            $type = Request_RequestParams::getParamInt('type');
            $model->setShopTableCatalogID($type);
        }

        Request_RequestParams::setParamStr('text', $model);
        Request_RequestParams::setParamStr('name', $model);
        Request_RequestParams::setParamInt("shop_table_catalog_id", $model);
        Request_RequestParams::setParamInt("shop_paid_type_id", $model);
        Request_RequestParams::setParamInt('shop_branch_id', $model);
        Request_RequestParams::setParamInt('paid_type_id', $model);
        Request_RequestParams::setParamInt('shop_operation_id', $model);
        Request_RequestParams::setParamInt("shop_bill_id", $model);
        Request_RequestParams::setParamInt("paid_shop_id", $model);

        $amountOld = $model->getAmount();
        Request_RequestParams::setParamFloat('amount', $model);

        $options = Request_RequestParams::getParamArray('options');
        if ($options !== NULL) {
            $model->addOptionsArray($options);
        }

        $result = array();
        if ($model->validationFields($result)) {
            if(($model->getPaidShopID() > 0) && ($model->getAmount() !== $amountOld)){
                $modelShop = new Model_Shop();
                $modelShop->setDBDriver($driver);

                // редактируем баланс
                if (Helpers_DB::getDBObject($modelShop, $model->getPaidShopID(), $sitePageData)) {
                    $modelShop->setBalance($modelShop->getBalance() - $amountOld + $model->getAmount());
                    Helpers_DB::saveDBObject($modelShop, $sitePageData);
                }
            }

            Helpers_DB::saveDBObject($model, $sitePageData);
            $result['values'] = $model->getValues();
        }

        return array(
            'id' => $model->id,
            'type' => $type,
            'result' => $result,
        );
    }
}
