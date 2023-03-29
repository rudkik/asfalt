<?php defined('SYSPATH') or die('No direct script access.');

class Api_Ab1_Shop_Client_Attorney  {
    /**
     * Просчет баланса доверенности
     * @param $shopClientAttorneyID
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @param int $shopID
     * @param string | null $dateTo
     * @return int
     * @throws HTTP_Exception_500
     */
    public static function calcBalance($shopClientAttorneyID, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver,
                                            $shopID = 0, $dateTo = null)
    {
        $shopClientAttorneyID = intval($shopClientAttorneyID);
        if($shopClientAttorneyID < 1) {
            return FALSE;
        }

        $model = new Model_Ab1_Shop_Client_Attorney();
        $model->setDBDriver($driver);

        if($shopID < 1){
            $shopID = $sitePageData->shopID;
        }

        if (!Helpers_DB::dublicateObjectLanguage($model, $shopClientAttorneyID, $sitePageData, $shopID)) {
            throw new HTTP_Exception_500('Client attorney id="'.$shopClientAttorneyID.'" not found. #7');
        }

        $block = self::calcBalanceBlock(
            $shopClientAttorneyID, $sitePageData, $driver, false, $shopID, $dateTo
        );
        $delivery = self::calcDeliveryBalanceBlock(
            $shopClientAttorneyID, $sitePageData, $driver, false, $shopID, $dateTo
        );

        return $model->getAmount() - $block - $delivery;
    }

    /**
     * Просчет заблокированного баланса доверенности
     * @param $shopClientAttorneyID
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @param bool $isSaveAmount
     * @param int $shopID
     * @param string | null $dateTo
     * @return int
     * @throws HTTP_Exception_500
     */
    public static function calcBalanceBlock($shopClientAttorneyID, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver,
                                            $isSaveAmount = TRUE, $shopID = 0, $dateTo = null)
    {
        $shopClientAttorneyID = intval($shopClientAttorneyID);
        if($shopClientAttorneyID < 1) {
            return FALSE;
        }

        $amount = 0;
        $params = Request_RequestParams::setParams(
            array(
                'exit_at_from_or_not_exit' => Api_Ab1_Basic::getDateFromBalance1С(),
                'shop_client_attorney_id' => $shopClientAttorneyID,
                'created_at_to' => $dateTo,
                'sum_amount' => TRUE,
            )
        );
        // реализация
        $ids = Request_Request::findBranch('DB_Ab1_Shop_Car_Item',
            array(), $sitePageData, $driver, $params
        );
        if(count($ids->childs) > 0){
            $amount += $ids->childs[0]->values['amount'];
        }

        // штучный товар
        $ids = Request_Request::findBranch('DB_Ab1_Shop_Piece_Item',
            array(), $sitePageData, $driver, $params
        );
        if(count($ids->childs) > 0){
            $amount += $ids->childs[0]->values['amount'];
        }

        // дополнительные услуги
        $ids = Request_Request::findBranch('DB_Ab1_Shop_Addition_Service_Item',
            array(), $sitePageData, $driver, $params
        );
        if(count($ids->childs) > 0){
            $amount += $ids->childs[0]->values['amount'];
        }

        if($isSaveAmount && $dateTo == null) {
            $model = new Model_Ab1_Shop_Client_Attorney();
            $model->setDBDriver($driver);

            if($shopID < 1){
                $shopID = $sitePageData->shopID;
            }

            if (!Helpers_DB::dublicateObjectLanguage($model, $shopClientAttorneyID, $sitePageData, $shopID)) {
                throw new HTTP_Exception_500('Client attorney id="'.$shopClientAttorneyID.'" not found. #7');
            }

            $model->setBlockAmount($amount);
            Helpers_DB::saveDBObject($model, $sitePageData, $shopID);
        }

        return $amount;
    }

    /**
     *  Просчет заблокированного баланса доверенностей
     * @param array $shopClientAttorneyIDs
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     */
    public static function calcBalancesBlock(array $shopClientAttorneyIDs, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        foreach ($shopClientAttorneyIDs as $child){
            if(empty($child)){
                continue;
            }
            self::calcBalanceBlock(floatval($child), $sitePageData, $driver);
        }
    }

    /**
     * Просчет заблокированного баланса доставки доверенности
     * @param int $shopClientAttorneyID
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @param bool $isSaveAmount
     * @param int $shopID
     * @return false|int|mixed
     * @throws HTTP_Exception_500
     */
    public static function calcDeliveryBalanceBlock(int $shopClientAttorneyID, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver,
                                            $isSaveAmount = TRUE, $shopID = 0, $dateTo = null)
    {
        if($shopClientAttorneyID < 1) {
            return FALSE;
        }

        $amount = 0;
        $params = Request_RequestParams::setParams(
            array(
                'exit_at_from_or_not_exit' => Api_Ab1_Basic::getDateFromBalance1С(),
                'delivery_shop_client_attorney_id' => $shopClientAttorneyID,
                'sum_delivery_amount' => TRUE,
                'is_delivery' => TRUE,
            )
        );
        // реализация
        $ids = Request_Request::find('DB_Ab1_Shop_Car',
            $sitePageData->shopID, $sitePageData, $driver, $params
        );
        if(count($ids->childs) > 0){
            $amount += $ids->childs[0]->values['delivery_amount'];
        }

        // штучный товар
        $ids = Request_Request::find('DB_Ab1_Shop_Piece',
            $sitePageData->shopID, $sitePageData, $driver, $params
        );
        if(count($ids->childs) > 0){
            $amount += $ids->childs[0]->values['delivery_amount'];
        }

        if($isSaveAmount) {
            $model = new Model_Ab1_Shop_Client_Attorney();
            $model->setDBDriver($driver);

            if($shopID < 1){
                $shopID = $sitePageData->shopID;
            }

            if (!Helpers_DB::dublicateObjectLanguage($model, $shopClientAttorneyID, $sitePageData, $shopID)) {
                throw new HTTP_Exception_500('Client attorney not found. #8');
            }

            $model->setBlockDeliveryAmount($amount);
            Helpers_DB::saveDBObject($model, $sitePageData, $shopID);
        }

        return $amount;
    }

    /**
     *  Просчет заблокированного баланса доставки доверенностей
     * @param array $shopClientAttorneyIDs
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     */
    public static function calcDeliveryBalancesBlock(array $shopClientAttorneyIDs, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        foreach ($shopClientAttorneyIDs as $child){
            self::calcDeliveryBalanceBlock(floatval($child), $sitePageData, $driver);
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
        $isUnDel = Request_RequestParams::getParamBoolean("is_undel");

        $model = new Model_Ab1_Shop_Client_Attorney();
        $model->setDBDriver($driver);

        if (!Helpers_DB::dublicateObjectLanguage($model, $id, $sitePageData)) {
            throw new HTTP_Exception_500('Client attorney not found.');
        }

        if (($isUnDel && !$model->getIsDelete()) or (!$isUnDel && $model->getIsDelete())){
            return FALSE;
        }

        if ($isUnDel){
            $shopClientAttorneyItemIDs = Request_Request::find('DB_Ab1_Shop_Client_Attorney_Item',
                $sitePageData->shopID, $sitePageData, $driver,
                Request_RequestParams::setParams(
                    array(
                        'shop_client_attorney_id' => $id,
                        'is_delete' => 1,
                        'is_public' => 0,
                    )
                )
            );

            $driver->unDeleteObjectIDs(
                $shopClientAttorneyItemIDs->getChildArrayID(), $sitePageData->userID,
                Model_Ab1_Shop_Client_Attorney_Item::TABLE_NAME, array('is_public' => 1), $sitePageData->shopID
            );
        }else{
            $shopClientAttorneyItemIDs = Request_Request::find('DB_Ab1_Shop_Client_Attorney_Item',
                $sitePageData->shopID, $sitePageData, $driver,
                Request_RequestParams::setParams(
                    array(
                        'shop_client_attorney_id' => $id,
                    )
                )
            );

            $driver->deleteObjectIDs(
                $shopClientAttorneyItemIDs->getChildArrayID(), $sitePageData->userID,
                Model_Ab1_Shop_Client_Attorney_Item::TABLE_NAME,
                array('is_public' => 0), $sitePageData->shopID
            );
        }

        if($isUnDel){
            $model->dbUnDelete($sitePageData->userID, 0, $sitePageData->shopID);
        }else {
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
        $model = new Model_Ab1_Shop_Client_Attorney();
        $model->setDBDriver($driver);

        $id = Request_RequestParams::getParamInt('id');
        if($id > 0) {
            if (!Helpers_DB::dublicateObjectLanguage($model, $id, $sitePageData, $sitePageData->shopID)) {
                throw new HTTP_Exception_500('Client attorney not found.');
            }
        }

        Request_RequestParams::setParamBoolean('is_public', $model);
        Request_RequestParams::setParamStr('text', $model);
        Request_RequestParams::setParamStr('name', $model);
        Request_RequestParams::setParamStr("old_id", $model);
        Request_RequestParams::setParamInt("shop_client_id", $model);
        Request_RequestParams::setParamInt("shop_client_contract_id", $model);

        Request_RequestParams::setParamStr('number', $model);
        Request_RequestParams::setParamStr('name', $model);
        Request_RequestParams::setParamFloat('delivery_amount', $model);
        Request_RequestParams::setParamFloat('amount', $model);
        Request_RequestParams::setParamDateTime('from_at', $model);
        Request_RequestParams::setParamDateTime('to_at', $model);
        Request_RequestParams::setParamStr('client_name', $model);

        $options = Request_RequestParams::getParamArray('options');
        if ($options !== NULL) {
            $model->addOptionsArray($options);
        }

        $result = array();
        if ($model->validationFields($result)) {
            if($model->id < 1) {
                Helpers_DB::saveDBObject($model, $sitePageData, $sitePageData->shopID);
            }

            // загружаем фотографии
            $file = new Model_File($sitePageData);
            $file->saveFiles(Request_RequestParams::getParamArray('files'), $model, $sitePageData, $driver);

            $shopClientAttorneyItems = Request_RequestParams::getParamArray('shop_client_attorney_items');
            if($shopClientAttorneyItems !== NULL) {
                $data = Api_Ab1_Shop_Client_Attorney_Item::save($sitePageData->shopID, $model->id,
                    $shopClientAttorneyItems, $sitePageData, $driver);
                $model->setAmount($data['amount']);

                $model->setName(
                    'Доверенность №'.$model->getNumber()
                    .' от '.Helpers_DateTime::getDateFormatRus($model->getFromAt())
                    .' до <b style="font-size: 18px;">'.Helpers_DateTime::getDateFormatRus($model->getToAt())
                    .'</b> сумма: <b style="font-size: 18px;">'
                    .Func::getPriceStr($sitePageData->currency, $model->getBalance()).'</b><br>'
                    . $data['name']
                );

                $model->setNameWeight(
                    'Доверенность №'.$model->getNumber()
                    .' от '.Helpers_DateTime::getDateFormatRus($model->getFromAt())
                    .' до <b style="font-size: 18px;">'.Helpers_DateTime::getDateFormatRus($model->getToAt()).'</b><br>'
                    . $data['name_weight']
                );
            }

            $model->setAttorneyUpdateUserID($sitePageData->userID);
            $model->setAttorneyUpdatedAt(date('Y-m-d H:i:s'));
            Helpers_DB::saveDBObject($model, $sitePageData, $sitePageData->shopID);
            $result['values'] = $model->getValues();
        }

        return array(
            'id' => $model->id,
            'result' => $result,
        );
    }
}
