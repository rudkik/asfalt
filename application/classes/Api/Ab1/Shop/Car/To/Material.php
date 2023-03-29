<?php defined('SYSPATH') or die('No direct script access.');

class Api_Ab1_Shop_Car_To_Material  {
    // какое количество секунд запрещено создавать повторно машину с материалом
    const TIME_BAN_ADD_CURRENT_AUTO_SEC = 2 * 60;

    /**
     * Считаем количество завоза материала + собственное производство
     * @param $dateFrom
     * @param $dateTo
     * @param $shopBranchDaughterID
     * @param $shopDaughterID
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @return int
     */
    public static function calcImportQuantity($dateFrom, $dateTo, $shopBranchDaughterID, $shopDaughterID, $shopMaterialID,
                                              SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        $quantity = 0;

        // закуп материала
        $params = array(
            'shop_daughter_id_from' => 0,
            'shop_material_id' => $shopMaterialID,
            'sum_daughter_weight' => true,
            'date_document_from' => $dateFrom,
            'date_document_to' => $dateTo,
            'is_import_car' => true,
        );
        if(!empty($shopDaughterID)){
            $params['shop_daughter_id'] = $shopDaughterID;
        }

        $data = Request_Request::findBranch(
            'DB_Ab1_Shop_Car_To_Material', array(), $sitePageData, $driver, Request_RequestParams::setParams($params)
        );

        if(count($data->childs) > 0){
            $quantity = $data->childs[0]->values['quantity'];
        }

        // собственное производство материала
        $params = array(
            'shop_material_id' => $shopMaterialID,
            'sum_quantity' => true,
            'date_from_equally' => $dateFrom,
            'date_to' => $dateTo,
        );
        if(!empty($shopBranchDaughterID)){
            $params['shop_id'] = $shopBranchDaughterID;
        }

        $data = Request_Request::findBranch(
            'DB_Ab1_Shop_Raw_Material_Item', array(), $sitePageData, $driver, Request_RequestParams::setParams($params)
        );

        if(count($data->childs) > 0){
            $quantity += $data->childs[0]->values['quantity'];
        }

        return $quantity;
    }

    /**
     * Вес материала взависимости от настроек поставщика
     * $elements = ['shop_daughter_id' => ['daughter_weight_id']]
     * @param MyArray $data
     * @param bool $isQuantityReceive
     * @return mixed
     */
    public static function getQuantity(MyArray $data, $isQuantityReceive = false)
    {
        if($isQuantityReceive) {
            $quantity = $data->values['quantity'];
        }elseif ($data->values['quantity_invoice'] > 0){
            $quantity = $data->values['quantity_invoice'];
        }else{
            switch ($data->getElementValue('shop_daughter_id', 'daughter_weight_id')){
                case Model_Ab1_DaughterWeight::DAUGHTER_WEIGHT_RECEIVER:
                    $quantity = $data->values['quantity'];
                    break;
                case Model_Ab1_DaughterWeight::DAUGHTER_WEIGHT_INVOICE:
                    $quantity = $data->values['quantity_invoice'];
                    break;
                default:
                    $quantity = $data->values['quantity_daughter'];
            }
        }

        return $quantity;
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

        $model = new Model_Ab1_Shop_Car_To_Material();
        $model->setDBDriver($driver);

        if (!Helpers_DB::dublicateObjectLanguage($model, $id, $sitePageData, $sitePageData->shopMainID)) {
            throw new HTTP_Exception_500('Car to material not found.');
        }

        if(Request_RequestParams::getParamBoolean("is_undel") === TRUE){
            $model->dbUnDelete($sitePageData->userID, 0, $sitePageData->shopMainID);
            Api_Ab1_Shop_Register_Material::unDelShopCarToMaterial($model, $sitePageData, $driver);
        }else {
            $model->dbDelete($sitePageData->userID, 0, $sitePageData->shopMainID);
            Api_Ab1_Shop_Register_Material::delShopCarToMaterial($model, $sitePageData, $driver);
        }
    }


    /**
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @return array
     * @throws HTTP_Exception_500
     */
    public static function save(SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        $model = new Model_Ab1_Shop_Car_To_Material();
        $model->setDBDriver($driver);

        $id = Request_RequestParams::getParamInt('id');
        if($id > 0) {
            if (!Helpers_DB::dublicateObjectLanguage($model, $id, $sitePageData, $sitePageData->shopMainID)) {
                throw new HTTP_Exception_500('Car not found.');
            }
        }

        Request_RequestParams::setParamBoolean('is_public', $model);
        Request_RequestParams::setParamStr('text', $model);
        Request_RequestParams::setParamStr('name', $model);
        Request_RequestParams::setParamStr("old_id", $model);

        Request_RequestParams::setParamInt('shop_transport_company_id', $model);
        Request_RequestParams::setParamInt("shop_client_material_id", $model);
        Request_RequestParams::setParamInt('shop_daughter_id', $model);
        Request_RequestParams::setParamInt('shop_material_id', $model);
        Request_RequestParams::setParamInt('shop_driver_id', $model);
        Request_RequestParams::setParamInt('shop_branch_receiver_id', $model);
        Request_RequestParams::setParamInt('shop_branch_daughter_id', $model);
        Request_RequestParams::setParamInt('shop_heap_daughter_id', $model);
        Request_RequestParams::setParamInt('shop_heap_receiver_id', $model);
        Request_RequestParams::setParamInt('shop_subdivision_daughter_id', $model);
        Request_RequestParams::setParamInt('shop_subdivision_receiver_id', $model);

        Request_RequestParams::setParamFloat('quantity', $model);
        Request_RequestParams::setParamFloat('quantity_invoice', $model);
        Request_RequestParams::setParamFloat('quantity_daughter', $model);
        Request_RequestParams::setParamBoolean('is_weighted', $model);

        Request_RequestParams::setParamDateTime('date_document', $model);
        Request_RequestParams::setParamDateTime('created_at', $model);

        $shopCarTareID = $model->getShopCarTareID();
        Request_RequestParams::setParamInt('shop_car_tare_id', $model);

        $options = Request_RequestParams::getParamArray('options');
        if ($options !== NULL) {
            $model->addOptionsArray($options);
        }

        $model->setName(mb_strtoupper($model->getName()));

        // добавляем id водителя
        $driverName = Request_RequestParams::getParamStr('shop_driver_name');
        if($driverName !== NULL) {
            $model->setShopDriverID(
                Api_Ab1_Shop_Driver::getShopDriverIDByName(
                    $driverName, $model->getShopDaughterID(), $sitePageData, $driver
                )
            );
        }

        $options = Request_RequestParams::getParamArray('options');
        if ($options !== NULL) {
            $model->addOptionsArray($options);
        }

        $result = array();
        if ($model->validationFields($result)) {
            if ($model->getWeightedOperationID() < 1) {
                $model->setWeightedOperationID($sitePageData->operationID);
            }

            $isNew = $model->id < 1;

            if($model->getIsWeighted()) {
                // проверить, чтобы машину в течение 10 минут не дублировали повторно
                if($model->id < 1 && !$sitePageData->operation->getIsAdmin()) {
                    $params = Request_RequestParams::setParams(
                        array(
                            'shop_car_tare_id' => $model->getShopCarTareID(),
                            'created_at_from' => date('Y-m-d H:i:s', time() - self::TIME_BAN_ADD_CURRENT_AUTO_SEC),
                        )
                    );
                    $shopCarToMaterialIDs = Request_Request::find(
                        'DB_Ab1_Shop_Car_To_Material', $sitePageData->shopMainID, $sitePageData, $driver,
                        $params, 1, TRUE
                    );
                    if(count($shopCarToMaterialIDs->childs) > 0){
                        $shopCarToMaterialIDs = $shopCarToMaterialIDs->childs[0];

                        $result['values'] = $shopCarToMaterialIDs->values;
                        return array(
                            'id' => $shopCarToMaterialIDs->id,
                            'result' => $result,
                        );
                    }
                }

                $brutto = Request_RequestParams::getParamFloat('brutto');
                if ($model->id < 1) {
                    if ($brutto != null && $brutto > 0) {
                        if (($model->getShopBranchDaughterID() == 0) || ($model->getShopBranchDaughterID() == $sitePageData->shopID)) {
                            $model->setQuantityDaughter($brutto - $model->getTare());
                        }
                        if ($model->getShopBranchReceiverID() == $sitePageData->shopID) {
                            $model->setQuantity($brutto - $model->getTare());
                        }
                    }

                    Helpers_DB::saveDBObject($model, $sitePageData, $sitePageData->shopMainID);

                    if ($brutto != null && $brutto > 0) {
                        // изображение
                        $file = new Model_File($sitePageData);

                        $data = Controller_Ab1_Weighted_Data::getDataFiles();
                        $files = array(
                            0 => array(
                                'title' => 'Брутто - передняя камера',
                                'url' => Arr::path($data, 'front', ''),
                                'type' => Model_ImageType::IMAGE_TYPE_IMAGE,
                            ),
                            1 => array(
                                'title' => 'Брутто - задняя камера',
                                'url' => Arr::path($data, 'backside', ''),
                                'type' => Model_ImageType::IMAGE_TYPE_IMAGE,
                            ),
                        );
                        $file->saveFiles($files, $model, $sitePageData, $driver);
                    }
                } else {
                    if ($brutto > 0) {
                        $model->setQuantity($brutto - $model->getTare());
                    }
                }
            }

            // меняем машину
            if ($shopCarTareID != $model->getShopCarTareID() || Func::_empty($model->getName()) || $model->getShopTransportID() == 0) {
                $modelCarTare = new Model_Ab1_Shop_Car_Tare();
                $modelCarTare->setDBDriver($driver);
                Helpers_DB::getDBObject($modelCarTare, $model->getShopCarTareID(), $sitePageData, $sitePageData->shopMainID);
                $model->setShopTransportID($modelCarTare->getShopTransportID());

                if($model->getIsWeighted() && $model->id > 0) {
                    $quantity = $model->getTare() + $model->getQuantity() - $modelCarTare->getWeight();
                    $quantityDaughter = $model->getTare() + $model->getQuantityDaughter() - $modelCarTare->getWeight();

                    if ($quantity < 0) {
                        $quantity = 0;
                    }
                    if ($quantityDaughter < 0) {
                        $quantityDaughter = 0;
                    }

                    $model->setQuantity($quantity);
                    $model->setQuantityDaughter($quantityDaughter);
                }

                $model->setTare($modelCarTare->getWeight());
                $model->setName($modelCarTare->getName());
                if (!Func::_empty($model->getUpdateTareAt())) {
                    $model->setUpdateTareAt(date('Y-m-d H:i:s'));
                }
            }

            if ($model->getIsWeighted() && ($model->getQuantity() <= 0) && ($model->getShopBranchReceiverID() == $sitePageData->shopID)) {
                $model->setQuantity($model->getQuantityDaughter());
            }

            // определяем привязку к путевому листу
            if($model->getShopBranchReceiverID() > 0
                && ($isNew
                    || $model->getShopTransportID() != $model->getOriginalValue('shop_transport_id'))){
                $model->setShopTransportWaybillID(
                    Api_Ab1_Shop_Transport_Waybill::findWaybillID(
                        $model->getShopTransportID(), $model->getCreatedAt(), $sitePageData, $driver
                    )
                );
            }

            // проверяем нужно ли создавать новую запись для сохранения нумерации
            // Если поменялась машина или филлиал вывоза
            if(!$isNew
                && ($shopCarTareID != $model->getShopCarTareID()
                    || $model->getShopBranchDaughterID() != $model->getOriginalValue('shop_branch_daughter_id'))){
                $model->dbDelete($sitePageData->userID);
                $model->id = 0;
                $model->globalID = 0;
                $model->setNumber('');
                $model->setIsDelete(false);
            }

            // задаем номер ТТН
            if(Func::_empty($model->getNumber()) && $model->getShopTransportWaybillID() > 0){
                $params = Request_RequestParams::setParams(
                    array(
                        'shop_transport_waybill_id' => $model->getShopTransportWaybillID(),
                        'shop_branch_daughter_id' => $model->getShopBranchDaughterID(),
                        'is_delete_ignore' => true,
                        'sort_by' => array(
                            'id' => 'acs',
                        )
                    )
                );
                $shopCarToMaterialIDs = Request_Request::find(
                    'DB_Ab1_Shop_Car_To_Material', 0, $sitePageData, $driver, $params, 0, true
                );

                if(count($shopCarToMaterialIDs->childs) == 0){
                    // счетчик как в 1с
                    DB_Basic::setNumber1CIfEmpty($model, 'number',$sitePageData, $driver, $model->getShopBranchDaughterID());
                }else{
                    $model->setNumber($shopCarToMaterialIDs->childs[0]->values['number'] . '/' . count($shopCarToMaterialIDs->childs));
                }
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
                            'file' => $file->saveDownloadFilePath($data, $model->id, Model_Ab1_Shop_Car_To_Material::TABLE_ID, $sitePageData),
                            'name' => $data['name'],
                            'size' => $data['size'],
                        );
                    }
                }else{
                    $options[$key][] = array(
                        'file' => $file->saveDownloadFilePath($child, $model->id, Model_Ab1_Shop_Car_To_Material::TABLE_ID, $sitePageData),
                        'name' => $child['name'],
                        'size' => $child['size'],
                    );
                }
            }
            $model->addOptionsArray($options);


            Helpers_DB::saveDBObject($model, $sitePageData, $sitePageData->shopMainID);
            $result['values'] = $model->getValues();

            // сохраняем расход / приход материала в регистр
            Api_Ab1_Shop_Register_Material::saveShopCarToMaterial($model, $sitePageData, $driver);
        }

        return array(
            'id' => $model->id,
            'result' => $result,
        );
    }

    /**
     * Сохраняем машины + оплату в виде XML
     * @param $from
     * @param $to
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @return string
     */
    public static function saveXML($from, $to, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver, $isPHPOutput = FALSE)
    {
        // получаем список машина
        $carIDs = Request_Request::find('DB_Ab1_Shop_Car_To_Material', $sitePageData->shopMainID, $sitePageData, $driver,
            array(Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE, 'created_at_from' => $from, 'created_at_to' => $to),
            0, TRUE);

        $modelProduct = new Model_Ab1_Shop_Product();
        $modelProduct->setDBDriver($driver);

        $modelClient = new Model_Ab1_Shop_Client();
        $modelClient->setDBDriver($driver);

        $data = '<?xml version="1.0" encoding="UTF-8"?><Data1C>';
        foreach($carIDs->childs as $car){
            if (!Helpers_DB::getDBObject($modelClient, $car->values['shop_daughter_id'], $sitePageData, $sitePageData->shopMainID)){
                continue;
            }

            if (!Helpers_DB::getDBObject($modelProduct, $car->values['shop_material_id'], $sitePageData, $sitePageData->shopMainID)){
                continue;
            }

            $data .= '<materials>'
                .'<NumDoc>'.$car->values['id'].'</NumDoc>'
                .'<DateDoc>'.strftime('%d.%m.%Y %H:%M:%S', strtotime($car->values['created_at'])).'</DateDoc>'
                .'<IdKlient>'.$modelClient->getOldID().'</IdKlient>'
                .'<Company>'.$modelClient->getName().'</Company>';

            $data .= '<material>'
                .'<Code>'.$modelProduct->getOldID().'</Code>'
                .'<Type>'.$modelProduct->getType1C().'</Type>'
                .'<quantity>'.$car->values['quantity'].'</quantity>'
                .'</material>';

            $data .= '</realization>';
        }
        $data .= '</materials>';

        if($isPHPOutput) {
            header('Content-Type: text/xml');
            header('Content-Disposition: attachment;filename=realization-"' . Helpers_DateTime::getDateFormatRus($from).'-'.Helpers_DateTime::getDateFormatRus($to) . '.xml"');
            header('Cache-Control: max-age=0');

            echo $data;
            exit();
        }


        return $data;
    }


    /**
     * Данные по завозу и покупке материалов
     * @param $dateFrom
     * @param $dateTo
     * @param $shopMaterialRubricID
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @param array $params
     * @param bool $isQuantityReceive
     * @param null $shopMaterialIDs
     * @return array
     */
    public static function getMaterialComingGroupDaughter($dateFrom, $dateTo, $shopMaterialRubricID,
                                                   SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver,
                                                   $params = array(), $isQuantityReceive = false, $shopMaterialIDs = NULL) {
        $params = array_merge(
            $params,
            Request_RequestParams::setParams(
                array(
                    'is_exit' => 1,
                    'shop_material_id' => $shopMaterialIDs,
                    'shop_branch_receiver_id' => $sitePageData->shopID,
                    'date_document_from' => $dateFrom,
                    'date_document_to' => $dateTo,
                    'shop_material_rubric_id' => $shopMaterialRubricID,
                )
            )
        );

        $ids = Request_Request::find('DB_Ab1_Shop_Car_To_Material',
            $sitePageData->shopMainID, $sitePageData, $driver,
            $params,0, TRUE,
            array(
                'shop_transport_company_id' => array('name'),
                'shop_material_id' => array('name'),
                'shop_branch_daughter_id' => array('name'),
                'shop_daughter_id' => array('name', 'daughter_weight_id')
            )
        );

        // список отправителей и список транспорных компаний
        $daughters = array();
        $companies = array();
        foreach ($ids->childs as $child){
            $daughterID = $child->values['shop_daughter_id'];
            if($daughterID > 0){
                $daughterID = 'd_'.$daughterID;
            }else{
                $daughterID = 'b_'.$child->values['shop_branch_daughter_id'];
            }

            if (!key_exists($daughterID, $daughters)){
                $daughters[$daughterID] = array(
                    'data' => array(),
                    'name' => $child->getElementValue(
                        'shop_daughter_id', 'name',
                        $child->getElementValue('shop_branch_daughter_id')
                    ),
                    'quantity' => 0,
                    'count' => 0,
                    'cars' => array(),
                );
            }

            $material = $child->values['shop_material_id'];
            if (! key_exists($material, $daughters[$daughterID]['data'])){
                $daughters[$daughterID]['data'][$material] = array(
                    'data' => array(),
                    'name' => $child->getElementValue('shop_material_id'),
                    'quantity' => 0,
                    'count' => 0,
                    'cars' => array(),
                );
            }

            $companyID = $child->values['shop_transport_company_id'];
            if (!key_exists($companyID, $companies)){
                $companies[$companyID] = array(
                    'data' => array(),
                    'name' => $child->getElementValue('shop_transport_company_id'),
                    'quantity' => 0,
                    'count' => 0,
                    'cars' => array(),
                );
            }
        }
        uasort($daughters, function ($x, $y) {
            return strcasecmp($x['name'], $y['name']);
        });
        uasort($companies, function ($x, $y) {
            return strcasecmp($x['name'], $y['name']);
        });

        $dataDaughters = array(
            'data' => $daughters,
            'quantity' => 0,
            'count' => 0,
            'cars' => array(),
        );
        $dataCompanies = array(
            'data' => $companies,
            'quantity' => 0,
            'count' => 0,
            'cars' => array(),
        );
        $dataMaterials = array(
            'data' => array(),
            'quantity' => 0,
            'count' => 0,
            'cars' => array(),
        );
        foreach ($ids->childs as $child){
            $number = $child->values['name'];
            $quantity = Api_Ab1_Shop_Car_To_Material::getQuantity($child, $isQuantityReceive);

            $daughter = $child->values['shop_daughter_id'];
            if($daughter > 0){
                $daughter = 'd_'.$daughter;
            }else{
                $daughter = 'b_'.$child->values['shop_branch_daughter_id'];
            }

            $dataDaughters['data'][$daughter]['quantity'] += $quantity;
            $dataDaughters['data'][$daughter]['count'] ++;
            $dataDaughters['data'][$daughter]['count'] ++;

            $material = $child->values['shop_material_id'];
            $dataDaughters['data'][$daughter]['data'][$material]['quantity'] += $quantity;
            $dataDaughters['data'][$daughter]['data'][$material]['count'] ++;
            $dataDaughters['data'][$daughter]['data'][$material]['cars'][$number] = '';

            $company = $child->values['shop_transport_company_id'];
            if (! key_exists($company, $dataMaterials['data'])){
                $dataMaterials['data'][$company] = array(
                    'data' => $daughters,
                    'name' => $child->getElementValue('shop_transport_company_id'),
                    'quantity' => 0,
                    'count' => 0,
                    'cars' => array(),
                );
            }

            $dataMaterials['data'][$company]['data'][$daughter]['data'][$material]['quantity'] += $quantity;
            $dataMaterials['data'][$company]['data'][$daughter]['data'][$material]['count'] ++;
            $dataMaterials['data'][$company]['data'][$daughter]['data'][$material]['cars'][$number] = '';

            $dataMaterials['data'][$company]['data'][$daughter]['quantity'] += $quantity;
            $dataMaterials['data'][$company]['data'][$daughter]['count'] ++;
            $dataMaterials['data'][$company]['data'][$daughter]['cars'][$number] = '';

            $dataMaterials['data'][$company]['quantity'] += $quantity;
            $dataMaterials['data'][$company]['count'] ++;
            $dataMaterials['data'][$company]['cars'][$number] = '';

            $dataMaterials['quantity'] += $quantity;
            $dataMaterials['count'] ++;
            $dataMaterials['cars'][$number] = '';

            $dataCompanies['data'][$company]['quantity'] += $quantity;
            $dataCompanies['data'][$company]['count'] ++;
            $dataCompanies['data'][$company]['cars'][$number] = '';
        }
        uasort($dataCompanies['data'], function ($x, $y) {
            return strcasecmp($x['name'], $y['name']);
        });
        uasort($dataMaterials['data'], function ($x, $y) {
            return strcasecmp($x['name'], $y['name']);
        });

        return array(
            'companies' => $dataCompanies,
            'materials' => $dataMaterials,
            'daughters' => $dataDaughters,
        );
    }
}
