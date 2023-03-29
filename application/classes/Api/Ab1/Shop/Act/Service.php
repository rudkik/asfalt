<?php defined('SYSPATH') or die('No direct script access.');

class Api_Ab1_Shop_Act_Service  {
    /**
     * Получение виртуальные накладных
     * @param $dateFrom
     * @param $dateTo
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @param array $params
     * @param array $paramsAdditionService
     * @param null $shopID
     * @return MyArray
     */
    public static function getVirtualActServices($dateFrom, $dateTo, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver,
                                              array $params = array(), array $paramsAdditionService = array(), $shopID = null)
    {
        $params = array_merge(
            $params,
            Request_RequestParams::setParams(
                array(
                    'exit_at_from' => $dateFrom,
                    'exit_at_to' => $dateTo,
                    'is_exit' => TRUE,
                    'is_delivery' => TRUE,
                    'is_charity' => FALSE,
                    'shop_act_service_id' => 0,
                    'delivery_quantity_from' => 0,
                )
            )
        );

        if($shopID > 0){
            $shopIDs = array($shopID);
        }else{
            $shopIDs = array();
        }

        // получаем список реализации
        $shopCarIDs = Request_Request::findBranch('DB_Ab1_Shop_Car',
            $shopIDs, $sitePageData, $driver,
            $params, 0, TRUE,
            array(
                'shop_client_id' => array('name', 'balance', 'balance_cache'),
                'delivery_shop_client_contract_id' => array('number'),
                'delivery_shop_client_attorney_id' => array('number'),
                'shop_delivery_id' => array('name'),
            )
        );

        $shopPieceIDs = Request_Request::findBranch('DB_Ab1_Shop_Piece',
            $shopIDs, $sitePageData, $driver,
            $params, 0, TRUE,
            array(
                'shop_client_id' => array('name', 'balance', 'balance_cache'),
                'delivery_shop_client_contract_id' => array('number'),
                'delivery_shop_client_attorney_id' => array('number'),
                'shop_delivery_id' => array('name'),
                'shop_id' => array('name'),
            )
        );

        if(empty($shopCarIDs->childs)){
            $shopCarIDs->childs = $shopPieceIDs->childs;
        }elseif(! empty($shopPieceIDs->childs)) {
            $shopCarIDs->childs = array_merge($shopCarIDs->childs, $shopPieceIDs->childs);
        }

        $ids = new MyArray();
        foreach ($shopCarIDs->childs as $child){
            $exitAt = Arr::path($child->values, 'exit_at', Arr::path($child->values, 'created_at', null));
            $date = Helpers_DateTime::getDateFormatPHP($exitAt);
            if(strtotime($exitAt) <= strtotime(Helpers_DateTime::getDateFormatPHP($exitAt).' 06:00:00')){
                $date = Helpers_DateTime::minusDays($date, 1);
            }

            $isCash = $child->values['delivery_shop_client_attorney_id'] < 1;

            $key = $child->values['shop_client_id']
                . '_' . $child->values['delivery_shop_client_contract_id']
                . '_' . $child->values['delivery_shop_client_attorney_id']
                . '_' . $isCash
                . '_' . $date
                . '_' . $child->values['shop_id'];

            if(!key_exists($key, $ids->childs)){
                $car = new MyArray();

                $car->values = array(
                    'shop_client_id' => $child->values['shop_client_id'],
                    'shop_client_name' => $child->getElementValue('shop_client_id'),
                    'shop_client_contract_id' => $child->values['delivery_shop_client_contract_id'],
                    'shop_client_contract_number' => $child->getElementValue('delivery_shop_client_contract_id', 'number'),
                    'shop_client_attorney_id' => $child->values['delivery_shop_client_attorney_id'],
                    'shop_client_attorney_number' => $child->getElementValue('delivery_shop_client_attorney_id', 'number'),
                    'shop_id' => $child->values['shop_id'],
                    'date' => $date,
                    'amount' => 0,
                    'is_cash' => $isCash,
                    'count' => 0,
                );

                $car->values[Model_Basic_BasicObject::FIELD_ELEMENTS]['shop_id']['name'] =$child->getElementValue('shop_id');

                $car->setIsFind(TRUE);
                $ids->childs[$key] = $car;
            }

            $ids->childs[$key]->values['amount'] += $child->values['delivery_amount'];
            $ids->childs[$key]->values['count']++;

        }

        // дополнительные услуги
        $params = array_merge(
            $paramsAdditionService,
            Request_RequestParams::setParams(
                array(
                    'exit_at_from' => $dateFrom,
                    'exit_at_to' => $dateTo,
                    'is_exit' => TRUE,
                    'is_charity' => FALSE,
                    'shop_act_service_id' => 0,
                )
            )
        );

        // получаем список дополнительных услуг
        $shopAdditionServiceIDs = Request_Request::findBranch('DB_Ab1_Shop_Addition_Service_Item',
            $shopIDs, $sitePageData, $driver,
            $params, 0, TRUE,
            array(
                'shop_client_id' => array('name', 'balance', 'balance_cache'),
                'shop_client_contract_id' => array('number'),
                'shop_client_attorney_id' => array('number'),
                'shop_product_id' => array('name'),
                'shop_car_id' => array('exit_at'),
                'shop_piece_id' => array('created_at'),
            )
        );

        foreach ($shopAdditionServiceIDs->childs as $child){
            $exitAt = $child->getElementValue('shop_car_id', 'exit_at', null);
            if(empty($exitAt)){
                $exitAt = $child->getElementValue('shop_piece_id', 'created_at', null);
            }
            $date = Helpers_DateTime::getDateFormatPHP($exitAt);
            if(strtotime($exitAt) <= strtotime(Helpers_DateTime::getDateFormatPHP($exitAt).' 06:00:00')){
                $date = Helpers_DateTime::minusDays($date, 1);
            }

            $isCash = $child->values['shop_client_attorney_id'] < 1;

            $key = $child->values['shop_client_id']
                . '_' . $child->values['shop_client_contract_id']
                . '_' . $child->values['shop_client_attorney_id']
                . '_' . $isCash
                . '_' . $date
                . '_' . $child->values['shop_id'];

            if(!key_exists($key, $ids->childs)){
                $car = new MyArray();

                $car->values = array(
                    'shop_client_id' => $child->values['shop_client_id'],
                    'shop_client_name' => $child->getElementValue('shop_client_id'),
                    'shop_client_contract_id' => $child->values['shop_client_contract_id'],
                    'shop_client_contract_number' => $child->getElementValue('shop_client_contract_id', 'number'),
                    'shop_client_attorney_id' => $child->values['shop_client_attorney_id'],
                    'shop_client_attorney_number' => $child->getElementValue('shop_client_attorney_id', 'number'),
                    'shop_id' => $child->values['shop_id'],
                    'date' => $date,
                    'amount' => 0,
                    'is_cash' => $isCash,
                    'count' => 0,
                );

                $car->setIsFind(TRUE);
                $ids->childs[$key] = $car;
            }

            $ids->childs[$key]->values['amount'] += $child->values['amount'];
        }

        // сортировка
        $ids->childsSortBy(
            array(
                'date', 'shop_client_name', 'shop_client_contract_number', 'shop_client_attorney_number',
            )
        );

        return $ids;
    }

    /**
     * Сохранение
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @return array
     * @throws HTTP_Exception_500
     */
    public static function rebuild($shopActServiceID, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        $model = new Model_Ab1_Shop_Act_Service();
        $model->setDBDriver($driver);
        if (!Helpers_DB::getDBObject($model, $shopActServiceID, $sitePageData)) {
            throw new HTTP_Exception_500('Act service not found.');
        }

        $params = Request_RequestParams::setParams(
            array(
                'exit_at_from' => $model->getDateFrom(),
                'exit_at_to' => $model->getDateTo(),
                'shop_client_id' => $model->getShopClientID(),
                'delivery_shop_client_contract_id' => $model->getShopClientContractID(),
                'delivery_shop_client_attorney_id' => $model->getShopClientAttorneyID(),
                'is_exit' => TRUE,
                'is_charity' => FALSE,
                'is_delivery' => TRUE,
                'shop_act_service_id' => 0,
            )
        );
        // реализация
        $shopCarIDs = Request_Request::find('DB_Ab1_Shop_Car',
            $sitePageData->shopID, $sitePageData, $driver, $params, 0, TRUE
        );
        // штучный товар
        $shopPieceIDs = Request_Request::find('DB_Ab1_Shop_Piece',
            $sitePageData->shopID, $sitePageData, $driver, $params, 0, TRUE
        );

        // дополнительные услуги
        $params = Request_RequestParams::setParams(
            array(
                'exit_at_from' => $model->getDateFrom(),
                'exit_at_to' => $model->getDateTo(),
                'shop_client_id' => $model->getShopClientID(),
                'delivery_shop_client_contract_id' => $model->getShopClientContractID(),
                'delivery_shop_client_attorney_id' => $model->getShopClientAttorneyID(),
                'is_exit' => TRUE,
                'is_charity' => FALSE,
                'shop_act_service_id' => 0,
            )
        );
        $shopAdditionServiceItemIDs = Request_Request::find('DB_Ab1_Shop_Addition_Service_Item',
            $sitePageData->shopID, $sitePageData, $driver, $params, 0, TRUE
        );

        if((count($shopCarIDs->childs) == 0) && (count($shopPieceIDs->childs) == 0) && (count($shopAdditionServiceItemIDs->childs) == 0)){
            return FALSE;
        }

        // добавляем ссылки на накладную у реализации
        $driver->updateObjects(
            Model_Ab1_Shop_Car::TABLE_NAME, $shopCarIDs->getChildArrayID(),
            array('shop_act_service_id' => $model->id), 0, $sitePageData->shopID
        );

        // добавляем ссылки на накладную у штучного товара
        $driver->updateObjects(
            Model_Ab1_Shop_Piece::TABLE_NAME, $shopPieceIDs->getChildArrayID(),
            array('shop_act_service_id' => $model->id), 0, $sitePageData->shopID
        );

        // добавляем ссылки на накладную у штучного товара
        $driver->updateObjects(
            Model_Ab1_Shop_Addition_Service_Item::TABLE_NAME, $shopAdditionServiceItemIDs->getChildArrayID(),
            array('shop_act_service_id' => $model->id), 0, $sitePageData->shopID
        );

        // считаем итоговую сумму акта выполненных работ
        $model->setAmount(self::calcActServiceAmount($model->id, $sitePageData, $driver));

        Helpers_DB::saveDBObject($model, $sitePageData);

        return $model;
    }

    /**
     * Добавление акта выполненных работ
     * @param int $shopClientID
     * @param int $shopClientContractID
     * @param int $shopClientAttorneyID
     * @param $date
     * @param $dateFrom
     * @param $dateTo
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @return bool|Model_Ab1_Shop_Act_Service
     */
    public static function addActService($shopClientID, $shopClientContractID, $shopClientAttorneyID,
                                         $date, $dateFrom, $dateTo,
                                         SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        $params = Request_RequestParams::setParams(
            array(
                'exit_at_from' => $dateFrom,
                'exit_at_to' => $dateTo,
                'shop_client_id' => $shopClientID,
                'delivery_shop_client_contract_id' => $shopClientContractID,
                'delivery_shop_client_attorney_id' => $shopClientAttorneyID,
                'is_exit' => TRUE,
                'is_charity' => FALSE,
                'is_delivery' => TRUE,
                'shop_act_service_id' => 0,
                'delivery_quantity_from' => 0,
            )
        );
        // реализация
        $shopCarIDs = Request_Request::find('DB_Ab1_Shop_Car',
            $sitePageData->shopID, $sitePageData, $driver, $params, 0, TRUE
        );
        // штучный товар
        $shopPieceIDs = Request_Request::find('DB_Ab1_Shop_Piece',
            $sitePageData->shopID, $sitePageData, $driver, $params, 0, TRUE
        );

        // дополнительные услуги
        $params = Request_RequestParams::setParams(
            array(
                'exit_at_from' => $dateFrom,
                'exit_at_to' => $dateTo,
                'shop_client_id' => $shopClientID,
                'shop_client_contract_id' => $shopClientContractID,
                'shop_client_attorney_id' => $shopClientAttorneyID,
                'is_exit' => TRUE,
                'is_charity' => FALSE,
                'shop_act_service_id' => 0,
            )
        );
        $shopAdditionServiceItemIDs = Request_Request::find('DB_Ab1_Shop_Addition_Service_Item',
            $sitePageData->shopID, $sitePageData, $driver, $params, 0, TRUE
        );

        if((count($shopCarIDs->childs) == 0) && (count($shopPieceIDs->childs) == 0) && (count($shopAdditionServiceItemIDs->childs) == 0)){
            return FALSE;
        }

        $model = new Model_Ab1_Shop_Act_Service();
        $model->setDBDriver($driver);

        $model->setShopClientID($shopClientID);
        $model->setShopClientContractID($shopClientContractID);
        $model->setShopClientAttorneyID($shopClientAttorneyID);
        $model->setDate($date);
        $model->setDateFrom($dateFrom);
        $model->setDateTo($dateTo);

        // счетчик как в 1с
        DB_Basic::setNumber1CIfEmpty($model, 'number', $sitePageData, $driver, $sitePageData->shopID);

        Helpers_DB::saveDBObject($model, $sitePageData);

        // добавляем ссылки на накладную у реализации
        $driver->updateObjects(
            Model_Ab1_Shop_Car::TABLE_NAME, $shopCarIDs->getChildArrayID(),
            array('shop_act_service_id' => $model->id), 0, $sitePageData->shopID
        );

        // добавляем ссылки на накладную у штучного товара
        $driver->updateObjects(
            Model_Ab1_Shop_Piece::TABLE_NAME, $shopPieceIDs->getChildArrayID(),
            array('shop_act_service_id' => $model->id), 0, $sitePageData->shopID
        );

        // добавляем ссылки на накладную у штучного товара
        $driver->updateObjects(
            Model_Ab1_Shop_Addition_Service_Item::TABLE_NAME, $shopAdditionServiceItemIDs->getChildArrayID(),
            array('shop_act_service_id' => $model->id), 0, $sitePageData->shopID
        );

        // считаем итоговую сумму акта выполненных работ
        $model->setAmount(self::calcActServiceAmount($model->id, $sitePageData, $driver));

        Helpers_DB::saveDBObject($model, $sitePageData);

        return $model;
    }

    /**
     * Просчет суммы акта выполненных работ
     * @param $shopActServiceID
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @param bool $isSaveAmount
     * @return bool|int
     * @throws HTTP_Exception_500
     */
    public static function calcActServiceAmount($shopActServiceID, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver,
                                             $isSaveAmount = FALSE)
    {
        if($shopActServiceID < 1){
            return FALSE;
        }

        $amount = 0;

        $params = Request_RequestParams::setParams(
            array(
                'shop_act_service_id' => $shopActServiceID,
                'sum_delivery_amount' => TRUE,
            )
        );
        // реализация
        $ids = Request_Request::find('DB_Ab1_Shop_Car',
            $sitePageData->shopID, $sitePageData, $driver, $params, 0, TRUE
        );
        if(count($ids->childs) > 0){
            $amount += $ids->childs[0]->values['delivery_amount'];
        }

        // штучный товар
        $ids = Request_Request::find('DB_Ab1_Shop_Piece',
            $sitePageData->shopID, $sitePageData, $driver, $params, 0, TRUE
        );
        if(count($ids->childs) > 0){
            $amount += $ids->childs[0]->values['delivery_amount'];
        }

        // дополнительные услуги
        $params = Request_RequestParams::setParams(
            array(
                'shop_act_service_id' => $shopActServiceID,
                'sum_amount' => TRUE,
            )
        );
        $ids = Request_Request::find('DB_Ab1_Shop_Addition_Service_Item',
            $sitePageData->shopID, $sitePageData, $driver, $params, 0, TRUE
        );
        if(count($ids->childs) > 0){
            $amount += $ids->childs[0]->values['amount'];
        }

        if($isSaveAmount) {
            $model = new Model_Ab1_Shop_Act_Service();
            $model->setDBDriver($driver);

            if (!Helpers_DB::getDBObject($model, $shopActServiceID, $sitePageData)) {
                throw new HTTP_Exception_500('Act service not found.');
            }
            $model->setAmount($amount);
            Helpers_DB::saveDBObject($model, $sitePageData);
        }

        return $amount;
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

        $model = new Model_Ab1_Shop_Act_Service();
        $model->setDBDriver($driver);

        if (!Helpers_DB::dublicateObjectLanguage($model, $id, $sitePageData)) {
            throw new HTTP_Exception_500('Act service not found.');
        }

        if ($isUnDel || ($isUnDel && !$model->getIsDelete()) || (!$isUnDel && $model->getIsDelete())){
            return FALSE;
        }

        $params = Request_RequestParams::setParams(
            array(
                'shop_act_service_id' => $id,
            )
        );

        // убираем ссылки на накладную у реализации
        $ids = Request_Request::find('DB_Ab1_Shop_Car',
            $sitePageData->shopID, $sitePageData, $driver,$params
        );
        $driver->updateObjects(
            Model_Ab1_Shop_Car::TABLE_NAME, $ids->getChildArrayID(),
            array('shop_act_service_id' => 0), 0, $sitePageData->shopID
        );

        // убираем ссылки на накладную у штучного товара
        $ids = Request_Request::find('DB_Ab1_Shop_Piece',
            $sitePageData->shopID, $sitePageData, $driver,$params
        );
        $driver->updateObjects(
            Model_Ab1_Shop_Piece::TABLE_NAME, $ids->getChildArrayID(),
            array('shop_act_service_id' => 0), 0, $sitePageData->shopID
        );

        $model->dbDelete($sitePageData->userID, 0, $sitePageData->shopID);

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
        $model = new Model_Ab1_Shop_Act_Service();
        $model->setDBDriver($driver);

        $id = Request_RequestParams::getParamInt('id');
        if($id > 0) {
            if (!Helpers_DB::dublicateObjectLanguage($model, $id, $sitePageData)) {
                throw new HTTP_Exception_500('Act service not found.');
            }
        }

        Request_RequestParams::setParamBoolean('is_public', $model);
        Request_RequestParams::setParamStr('text', $model);
        Request_RequestParams::setParamStr('name', $model);
        Request_RequestParams::setParamStr("old_id", $model);
        Request_RequestParams::setParamInt("shop_client_id", $model);
        Request_RequestParams::setParamInt("shop_client_contract_id", $model);
        Request_RequestParams::setParamInt("shop_client_attorney_id", $model);
        Request_RequestParams::setParamInt("shop_delivery_department_id", $model);
        Request_RequestParams::setParamInt("act_service_paid_type_id", $model);
        Request_RequestParams::setParamInt("check_type_id", $model);
        Request_RequestParams::setParamDateTime("date", $model);
        Request_RequestParams::setParamDateTime("date_from", $model);
        Request_RequestParams::setParamDateTime("date_to", $model);
        Request_RequestParams::setParamStr('number', $model);

        $options = Request_RequestParams::getParamArray('options');
        if ($options !== NULL) {
            $model->addOptionsArray($options);
        }

        $result = array();
        if ($model->validationFields($result)) {
            // счетчик как в 1с
            DB_Basic::setNumber1CIfEmpty($model, 'number', $sitePageData, $driver, $sitePageData->shopID);

            if($model->id < 1) {
                Helpers_DB::saveDBObject($model, $sitePageData);
            }

            $model->setAmount(self::calcActServiceAmount($model->id, $sitePageData, $driver));

            if($model->getShopClientAttorneyID() != $model->getOriginalValue('shop_client_attorney_id')
                || $model->getShopClientContractID() != $model->getOriginalValue('shop_client_contract_id')) {
                // изменяем доверенность и договор у реализации
                $driver->sendSQL('UPDATE ab_shop_cars SET delivery_shop_client_contract_id = '.$model->getShopClientContractID().', delivery_shop_client_attorney_id = '.$model->getShopClientAttorneyID().' WHERE shop_act_service_id='.$model->id);
                // изменяем доверенность и договор у штучного товара
                $driver->sendSQL('UPDATE ab_shop_pieces SET delivery_shop_client_contract_id = '.$model->getShopClientContractID().', delivery_shop_client_attorney_id = '.$model->getShopClientAttorneyID().' WHERE shop_act_service_id='.$model->id);
                // изменяем доверенность и договор у дополнительных услуг
                $driver->sendSQL('UPDATE ab_shop_addition_service_items SET shop_client_contract_id = '.$model->getShopClientContractID().', shop_client_attorney_id = '.$model->getShopClientAttorneyID().' WHERE shop_act_service_id='.$model->id);

                // обновляем балансы клиента
                Api_Ab1_Shop_Client::recountBalanceObject(
                    $model, $sitePageData, $driver
                );
            }

            // загружаем фотографии
            $file = new Model_File($sitePageData);
            $file->saveFiles(Request_RequestParams::getParamArray('files'), $model, $sitePageData, $driver);

            Helpers_DB::saveDBObject($model, $sitePageData);
            $result['values'] = $model->getValues();
        }

        return array(
            'id' => $model->id,
            'result' => $result,
        );
    }

    /**
     * Сохраняем накладные в виде XML
     * @param $dateFrom
     * @param $dateTo
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @param bool $isPHPOutput
     * @return string
     */
    public static function saveXML($dateFrom, $dateTo, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver, $isPHPOutput = FALSE)
    {
        // получаем список
        $params = Request_RequestParams::setParams(
            array(
                //'updated_at_from' => Helpers_DateTime::getDateTimeFormatPHP($date),
                'date_from_equally' => Helpers_DateTime::getDateFormatPHP($dateFrom),
                'date_to' => Helpers_DateTime::getDateFormatPHP($dateTo),
            )
        );
        $shopActServiceIDs = Request_Request::findBranch('DB_Ab1_Shop_Act_Service',
            array(), $sitePageData, $driver, $params, 0, TRUE,
            array(
                'shop_client_id' => array('name', 'old_id', 'bin', 'address', 'account', 'bik'),
                'shop_client_contract_id' => array('number', 'from_at'),
                'shop_client_attorney_id' => array('number', 'from_at', 'client_name'),
                'shop_client_id.organization_type_id' => array('old_id'),
                'shop_id' => array('old_id', 'name'),
                'act_service_paid_type_id' => array('old_id'),
                'check_type_id' => array('old_id', 'name'),
            )
        );

        // получаем список групп доставки
        $shopDeliveryGroupIDs = Request_Request::findAll(
            'DB_Ab1_Shop_Delivery_Group', $sitePageData->shopID, $sitePageData, $driver, TRUE
        );
        $shopDeliveryGroupIDs->runIndex();

        $data = '<?xml version="1.0" encoding="UTF-8"?><Data1C>';
        foreach($shopActServiceIDs->childs as $shopActServiceID){

            $data .= '<ActService>'
                .'<id>'.$shopActServiceID->values['id'].'</id>'
                .'<NumDoc>'.$shopActServiceID->values['number'].'</NumDoc>'
                .'<is_delete>'.$shopActServiceID->values['is_delete'].'</is_delete>'
                .'<is_control>'.($shopActServiceID->getElementValue('check_type_id', 'old_id') == 2).'</is_control>'
                .'<date>'.Helpers_DateTime::getDateFormatRus($shopActServiceID->values['date']).'</date>'
                .'<branch>'.$shopActServiceID->getElementValue('shop_id', 'old_id').'</branch>'
                .'<branch_name>'.$shopActServiceID->getElementValue('shop_id', 'name').'</branch_name>'
                .'<paid_type>'.$shopActServiceID->getElementValue('act_service_paid_type_id', 'old_id').'</paid_type>'
                .'<IdKlient>'.$shopActServiceID->getElementValue('shop_client_id', 'old_id').'</IdKlient>'
                .'<Company>'.htmlspecialchars($shopActServiceID->getElementValue('shop_client_id', 'name'), ENT_XML1).'</Company>'
                .'<BIN>'.htmlspecialchars($shopActServiceID->getElementValue('shop_client_id', 'bin'), ENT_XML1).'</BIN>'
                .'<address>'.htmlspecialchars($shopActServiceID->getElementValue('shop_client_id', 'address'), ENT_XML1).'</address>'
                .'<account>'.htmlspecialchars($shopActServiceID->getElementValue('shop_client_id', 'account'), ENT_XML1).'</account>'
                .'<bank>'.htmlspecialchars($shopActServiceID->getElementValue('shop_client_id', 'bik'), ENT_XML1).'</bank>'
                .'<organization_type>'.htmlspecialchars($shopActServiceID->getElementValue('organization_type_id', 'old_id'), ENT_XML1).'</organization_type>'
                .'<contract_id>'.$shopActServiceID->values['shop_client_contract_id'].'</contract_id>'
                .'<contract_number>'.htmlspecialchars($shopActServiceID->getElementValue('shop_client_contract_id', 'number'), ENT_XML1).'</contract_number>'
                .'<contract_date>'.Helpers_DateTime::getDateFormatRus($shopActServiceID->getElementValue('shop_client_contract_id', 'from_at')).'</contract_date>'
                .'<attorney_number>'.htmlspecialchars($shopActServiceID->getElementValue('shop_client_attorney_id', 'number'), ENT_XML1).'</attorney_number>'
                .'<attorney_date>'.Helpers_DateTime::getDateFormatRus($shopActServiceID->getElementValue('shop_client_attorney_id', 'from_at')).'</attorney_date>'
                .'<attorney_client>'.htmlspecialchars($shopActServiceID->getElementValue('shop_client_attorney_id', 'client_name'), ENT_XML1).'</attorney_client>';

            // получаем список строк актов выполненных работ
            $params = Request_RequestParams::setParams(
                array(
                    'shop_act_service_id' => $shopActServiceID->id,
                )
            );
            $shopCarIDs = Request_Request::find('DB_Ab1_Shop_Car',
                $shopActServiceID->values['shop_id'], $sitePageData, $driver, $params, 0, TRUE,
                array('shop_delivery_id' => array('old_id', 'shop_delivery_group_id'))
            );
            $shopPieceIDs = Request_Request::find('DB_Ab1_Shop_Piece',
                $shopActServiceID->values['shop_id'], $sitePageData, $driver, $params, 0, TRUE,
                array('shop_delivery_id' => array('old_id', 'shop_delivery_group_id'))
            );

            $data .='<cars>';

            $groups = array();
            foreach ($shopCarIDs->childs as $child){
                $data .= '<car>'
                    .'<number>'.$child->values['name'].'</number>'
                    .'<ttn>'.$child->values['id'].'</ttn>'
                    .'<deliveryID>'.$child->getElementValue('shop_delivery_id', 'old_id').'</deliveryID>'
                    .'<quantity>'.$child->values['delivery_quantity'].'</quantity>'
                    .'<delivery_km>'.$child->values['delivery_km'].'</delivery_km>'
                    .'<delivery_amount>'.$child->values['delivery_amount'].'</delivery_amount>'
                    .'</car>';

                $shopDeliveryGroupID = $child->getElementValue('shop_delivery_id', 'shop_delivery_group_id');
                if(!key_exists($shopDeliveryGroupID, $groups)){
                    $groups[$shopDeliveryGroupID] = array(
                        'shop_delivery_group_id' => $shopDeliveryGroupID,
                        'delivery_km' => 0,
                        'delivery_quantity' => 0,
                        'delivery_amount' => 0,
                    );
                }
                $groups[$shopDeliveryGroupID]['delivery_quantity']  += $child->values['delivery_quantity'];
                $groups[$shopDeliveryGroupID]['delivery_amount'] += $child->values['delivery_amount'];
                $groups[$shopDeliveryGroupID]['delivery_km'] += $child->values['delivery_km'];
            }
            foreach ($shopPieceIDs->childs as $child){
                $data .= '<car>'
                    .'<number>'.$child->values['name'].'</number>'
                    .'<ttn>'.$child->values['id'].'</ttn>'
                    .'<deliveryID>'.$child->getElementValue('shop_delivery_id', 'old_id').'</deliveryID>'
                    .'<quantity>'.$child->values['delivery_quantity'].'</quantity>'
                    .'<delivery_km>'.$child->values['delivery_km'].'</delivery_km>'
                    .'<delivery_amount>'.$child->values['delivery_amount'].'</delivery_amount>'
                    .'</car>';

                $shopDeliveryGroupID = $child->getElementValue('shop_delivery_id', 'shop_delivery_group_id');
                if(!key_exists($shopDeliveryGroupID, $groups)){
                    $groups[$shopDeliveryGroupID] = array(
                        'shop_delivery_group_id' => $shopDeliveryGroupID,
                        'delivery_km' => 0,
                        'delivery_quantity' => 0,
                        'delivery_amount' => 0,
                    );
                }
                $groups[$shopDeliveryGroupID]['delivery_quantity']  += $child->values['delivery_quantity'];
                $groups[$shopDeliveryGroupID]['delivery_amount'] += $child->values['delivery_amount'];
                $groups[$shopDeliveryGroupID]['delivery_km'] += $child->values['delivery_km'];
            }
            $data .='</cars>';

            $nds = 0;
            $amount = 0;
            $data .='<goods>';
            foreach ($groups as $child){
                $data .= '<good>';

                $shopDeliveryGroupID = $child['shop_delivery_group_id'];
                if(key_exists($shopDeliveryGroupID, $shopDeliveryGroupIDs->childs)){
                    $data .= '<productID>'.$shopDeliveryGroupIDs->childs[$shopDeliveryGroupID]->values['old_id'].'</productID>';
                }

                $amount += $child['delivery_amount'];
                $tmpNDS = Api_Tax_NDS::getAmountNDS($child['delivery_amount']);
                $nds += $tmpNDS;

                $data .= '<quantity>'.$child['delivery_quantity'].'</quantity>'
                    .'<delivery_km>'.$child['delivery_km'].'</delivery_km>'
                    .'<delivery_amount>'.$child['delivery_amount'].'</delivery_amount>'
                    .'<delivery_nds>'.$tmpNDS.'</delivery_nds>'
                    .'</good>';
            }

            // получаем список дополнительных услуг актов выполненных работ
            $params = Request_RequestParams::setParams(
                array(
                    'shop_act_service_id' => $shopActServiceID->id,
                )
            );
            $shopAdditionServiceItemIDs = Request_Request::find('DB_Ab1_Shop_Addition_Service_Item',
                $shopActServiceID->values['shop_id'], $sitePageData, $driver, $params, 0, TRUE,
                array(
                    'shop_product_id' => array('old_id', 'name'),
                    'shop_car_id' => array('name'),
                    'shop_piece_id' => array('name'),
                )
            );

            foreach ($shopAdditionServiceItemIDs->childs as $child){
                $amount += $child->values['amount'];
                $tmpNDS = Api_Tax_NDS::getAmountNDS($child->values['amount']);
                $nds += $tmpNDS;

                $data .= '<good>'
                    .'<productID>'.$child->getElementValue('shop_product_id', 'old_id').'</productID>'
                    .'<quantity>'.$child->values['quantity'].'</quantity>'
                    .'<delivery_km>0</delivery_km>'
                    .'<delivery_amount>'.$child->values['amount'].'</delivery_amount>'
                    .'<delivery_nds>'.$tmpNDS.'</delivery_nds>'
                    .'</good>';
            }
            $data .='</goods>';

            $data .= '<amount>'.$amount.'</amount>'
                .'<nds>'.$nds.'</nds>';
            $data .= '</ActService>';
        }
        $data .= '</Data1C>';

        if($isPHPOutput) {
            header('Content-Type: text/xml');
            header('Content-Disposition: attachment;filename="actservice.xml"');
            header('Cache-Control: max-age=0');

            echo $data;
            exit();
        }



        return $data;
    }
}