<?php defined('SYSPATH') or die('No direct script access.');

class Api_Ab1_Shop_Boxcar  {

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

        $model = new Model_Ab1_Shop_Boxcar();
        $model->setDBDriver($driver);

        if (!Helpers_DB::dublicateObjectLanguage($model, $id, $sitePageData)) {
            throw new HTTP_Exception_500('Boxcar not found.');
        }

        if (($isUnDel && !$model->getIsDelete()) or (!$isUnDel && $model->getIsDelete())){
            return FALSE;
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
        $model = new Model_Ab1_Shop_Boxcar();
        $model->setDBDriver($driver);

        $id = Request_RequestParams::getParamInt('id');
        if($id > 0) {
            if (!Helpers_DB::dublicateObjectLanguage($model, $id, $sitePageData)) {
                throw new HTTP_Exception_500('Boxcar not found.');
            }
        }

        Request_RequestParams::setParamBoolean('is_public', $model);
        Request_RequestParams::setParamStr('text', $model);
        Request_RequestParams::setParamStr('name', $model);
        Request_RequestParams::setParamStr("old_id", $model);

        Request_RequestParams::setParamStr("number", $model);
        Request_RequestParams::setParamFloat("quantity", $model);

        Request_RequestParams::setParamDateTime('date_arrival', $model);
        Request_RequestParams::setParamDateTime('date_departure', $model);
        Request_RequestParams::setParamDateTime('date_drain_from', $model);
        Request_RequestParams::setParamDateTime('date_drain_to', $model);

        Request_RequestParams::setParamStr("stamp", $model);
        Request_RequestParams::setParamStr("sending", $model);
        Request_RequestParams::setParamInt("shop_client_id", $model);
        Request_RequestParams::setParamInt("drain_from_shop_operation_id_1", $model);
        Request_RequestParams::setParamInt("drain_to_shop_operation_id_1", $model);
        Request_RequestParams::setParamInt("drain_from_shop_operation_id_2", $model);
        Request_RequestParams::setParamInt("drain_to_shop_operation_id_2", $model);
        Request_RequestParams::setParamInt("brigadier_drain_from_shop_operation_id", $model);
        Request_RequestParams::setParamInt("brigadier_drain_to_shop_operation_id", $model);
        Request_RequestParams::setParamInt("drain_zhdc_from_shop_operation_id", $model);
        Request_RequestParams::setParamInt("drain_zhdc_to_shop_operation_id", $model);
        Request_RequestParams::setParamInt("zhdc_shop_operation_id", $model);
        Request_RequestParams::setParamInt("shop_raw_drain_chute_id", $model);

        Request_RequestParams::setParamStr("drain_text", $model);
        Request_RequestParams::setParamFloat("residue", $model);

        // меняем сырье и поставщика ямы слива
        if($model->getShopRawDrainChuteID() != $model->getOriginalValue('shop_raw_drain_chute_id')){
            $modelDrainChute = new Model_Ab1_Shop_Raw_DrainChute();
            $modelDrainChute->setDBDriver($driver);
            if (Helpers_DB::getDBObject($modelDrainChute, $model->getShopRawDrainChuteID(), $sitePageData)) {
                $modelDrainChute->setShopRawID($model->getShopRawID());
                $modelDrainChute->setShopBoxcarClientID($model->getShopBoxcarClientID());

                Helpers_DB::saveDBObject($modelDrainChute, $sitePageData);
            }
        }

        $options = Request_RequestParams::getParamArray('options');
        if ($options !== NULL) {
            $model->addOptionsArray($options);
        }

        $result = array();
        if ($model->validationFields($result)) {
            if($model->id < 1) {
                Helpers_DB::saveDBObject($model, $sitePageData);
            }

            // загружаем фотографии
            $file = new Model_File($sitePageData);
            $file->saveFiles(Request_RequestParams::getParamArray('files'), $model, $sitePageData, $driver);

            $options = $model->getOptionsArray();
            $files = Helpers_Image::getChildrenFILES('options');
            foreach ($files as $key => $child) {
                if(is_array($child['tmp_name'])){
                    foreach ($child['tmp_name'] as $index => $path){
                        $data = array(
                            'tmp_name' => $path,
                            'name' => $child['name'][$index],
                            'type' => $child['type'][$index],
                            'error' => $child['error'][$index],
                            'size' => $child['size'][$index],
                        );
                        $options[$key][] = array(
                            'file' => $file->saveDownloadFilePath($data, $model->id, Model_Ab1_Shop_Boxcar::TABLE_ID, $sitePageData),
                            'name' => $data['name'],
                            'size' => $data['size'],
                        );
                    }
                }else{
                    $options[$key][] = array(
                        'file' => $file->saveDownloadFilePath($child, $model->id, Model_Ab1_Shop_Boxcar::TABLE_ID, $sitePageData),
                        'name' => $child['name'],
                        'size' => $child['size'],
                    );
                }
            }
            $model->addOptionsArray($options);

            Helpers_DB::saveDBObject($model, $sitePageData);
            $result['values'] = $model->getValues();
        }

        return array(
            'id' => $model->id,
            'result' => $result,
        );
    }


    /**
     * Сохраняем вагоны
     * @param Model_Ab1_Shop_Boxcar_Train $modelTrain
     * @param array $shopBoxcars
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @param bool $isSaveTrain
     * @return bool - отгружен ли последний вагон
     */
    public static function savelist(Model_Ab1_Shop_Boxcar_Train $modelTrain, array $shopBoxcars, SitePageData $sitePageData,
                                    Model_Driver_DBBasicDriver $driver, $isSaveTrain = FALSE)
    {
        $model = new Model_Ab1_Shop_Boxcar();
        $model->setDBDriver($driver);

        $params = Request_RequestParams::setParams(
            array(
                'shop_boxcar_train_id' => $modelTrain->id,
                'sort_by' => array('id' => 'asc'),
            )
        );
        $shopBoxcarIDs = Request_Request::find(
            'DB_Ab1_Shop_Boxcar', $sitePageData->shopID, $sitePageData, $driver, $params, 0, TRUE
        );

        $quantityTotal = 0;
        $dateDeparture = NULL;
        $dateDrainFrom = NULL;
        $dateDrainTo = NULL;
        $isExit = TRUE;
        $boxcars = array();
        foreach($shopBoxcars as $key => $shopBoxcar){
            $quantity = Request_RequestParams::strToFloat(Arr::path($shopBoxcar, 'quantity', ''));
            if($quantity < 0){
                continue;
            }

            $shopBoxcarID = array_shift($shopBoxcarIDs->childs);
            if($shopBoxcarID !== NULL){
                $shopBoxcarID->setModel($model);
            }else{
                $model->clear();
            }

            $tmp = Arr::path($shopBoxcar, 'date_departure', NULL);
            if($tmp !== NULL){
                $model->setDateDeparture($tmp);
                $isExit = $isExit && $model->getIsExit();
            }
            $tmp = Arr::path($shopBoxcar, 'date_drain_from', NULL);
            if($tmp !== NULL){
                $model->setDateDrainFrom($tmp);
            }
            $tmp = Arr::path($shopBoxcar, 'date_drain_to', NULL);
            if($tmp !== NULL){
                $model->setDateDrainTo($tmp);
            }
            $tmp = Arr::path($shopBoxcar, 'date_arrival', NULL);
            if($tmp !== NULL){
                $model->setDateArrival($tmp);
            }
            $tmp = Arr::path($shopBoxcar, 'number', NULL);
            if($tmp !== NULL){
                $model->setNumber($tmp);
            }
            $tmp = Arr::path($shopBoxcar, 'stamp', NULL);
            if($tmp !== NULL){
                $model->setStamp($tmp);
            }
            $tmp = Arr::path($shopBoxcar, 'sending', NULL);
            if($tmp !== NULL){
                $model->setSending($tmp);
            }

            $tmp = Arr::path($shopBoxcar, 'text', NULL);
            if($tmp !== NULL){
                $model->setText($tmp);
            }

            $tmp = Arr::path($shopBoxcar, 'drain_from_shop_operation_id_1', NULL);
            if($tmp !== NULL){
                $model->setDrainFromShopOperationID1($tmp);
            }

            $tmp = Arr::path($shopBoxcar, 'drain_to_shop_operation_id_1', NULL);
            if($tmp !== NULL){
                $model->setDrainToShopOperationID1($tmp);
            }

            $tmp = Arr::path($shopBoxcar, 'drain_from_shop_operation_id_2', NULL);
            if($tmp !== NULL){
                $model->setDrainFromShopOperationID2($tmp);
            }

            $tmp = Arr::path($shopBoxcar, 'drain_to_shop_operation_id_2', NULL);
            if($tmp !== NULL){
                $model->setDrainToShopOperationID2($tmp);
            }

            $tmp = Arr::path($shopBoxcar, 'brigadier_drain_from_shop_operation_id', NULL);
            if($tmp !== NULL){
                $model->setBrigadierDrainFromShopOperationID($tmp);
            }

            $tmp = Arr::path($shopBoxcar, 'brigadier_drain_to_shop_operation_id', NULL);
            if($tmp !== NULL){
                $model->setBrigadierDrainToShopOperationID($tmp);
            }

            $tmp = Arr::path($shopBoxcar, 'drain_zhdc_from_shop_operation_id', NULL);
            if($tmp !== NULL){
                $model->setDrainZHDCFromShopOperationID($tmp);
            }

            $tmp = Arr::path($shopBoxcar, 'drain_zhdc_to_shop_operation_id', NULL);
            if($tmp !== NULL){
                $model->setDrainZHDCToShopOperationID($tmp);
            }

            $tmp = Arr::path($shopBoxcar, 'zhdc_shop_operation_id', NULL);
            if($tmp !== NULL){
                $model->setZHDCShopOperationID($tmp);
            }

            $tmp = Arr::path($shopBoxcar, 'residue', NULL);
            if($tmp !== NULL){
                $model->setResidue($tmp);
            }

            if (($dateDeparture === NULL) || (strtotime($dateDeparture) < strtotime($model->getDateDeparture()))){
                $dateDeparture = $model->getDateDeparture();
            }
            if (($dateDrainFrom === NULL) || (strtotime($dateDrainFrom) < strtotime($model->getDateDrainFrom()))){
                $dateDrainFrom = $model->getDateDrainFrom();
            }
            if (($dateDrainTo === NULL) || (strtotime($dateDrainTo) < strtotime($model->getDateDrainTo()))){
                $dateDrainTo = $model->getDateDrainTo();
            }

            $model->setShopClientID($modelTrain->getShopClientID());
            $model->setShopBoxcarClientID($modelTrain->getShopBoxcarClientID());
            $model->setShopBoxcarDepartureStationID($modelTrain->getShopBoxcarDepartureStationID());
            $model->setShopRawID($modelTrain->getShopRawID());
            $model->setShopClientContractID($modelTrain->getShopClientContractID());

            $model->setQuantity($quantity);
            $model->setShopBoxcarTrainID($modelTrain->id);
            Helpers_DB::saveDBObject($model, $sitePageData);


            // сохраняем файлы
            $files = Helpers_Image::getChildrenFILES('shop_boxcars', $key.'.options', null);
            if($files !== null){
                // загружаем фотографии
                $file = new Model_File($sitePageData);

                $options = $model->getOptionsArray();
                foreach ($files as $key => $child) {
                    if(is_array($child['tmp_name'])){
                        foreach ($child['tmp_name'] as $index => $path){
                            $data = array(
                                'tmp_name' => $path,
                                'name' => $child['name'][$index],
                                'type' => $child['type'][$index],
                                'error' => $child['error'][$index],
                                'size' => $child['size'][$index],
                            );
                            $options[$key][] = array(
                                'file' => $file->saveDownloadFilePath($data, $model->id, Model_Ab1_Shop_Boxcar::TABLE_ID, $sitePageData),
                                'name' => $data['name'],
                                'size' => $data['size'],
                            );
                        }
                    }else{
                        $options[$key][] = array(
                            'file' => $file->saveDownloadFilePath($child, $model->id, Model_Ab1_Shop_Boxcar::TABLE_ID, $sitePageData),
                            'name' => $child['name'],
                            'size' => $child['size'],
                        );
                    }
                }
                $model->addOptionsArray($options);

                Helpers_DB::saveDBObject($model, $sitePageData);
            }

            $boxcars[] = $model->getNumber();

            $quantityTotal += $model->getQuantity();
        }

        $modelTrain->setQuantity($quantityTotal);
        $modelTrain->setDateDeparture($dateDeparture);
        $modelTrain->setDateDrainFrom($dateDrainFrom);
        $modelTrain->setDateDrainTo($dateDrainTo);
        $modelTrain->setBoxcarsArray($boxcars);

        if($isSaveTrain){
            Helpers_DB::saveDBObject($modelTrain, $sitePageData);
        }

        // удаляем лишние
        $driver->deleteObjectIDs($shopBoxcarIDs->getChildArrayID(), $sitePageData->userID,
            Model_Ab1_Shop_Boxcar::TABLE_NAME, array(), $sitePageData->shopID);

        return $isExit;
    }
}
