<?php defined('SYSPATH') or die('No direct script access.');

class Api_Ab1_Shop_Delivery  {

    /**
     * Просчитываем стоимость доставки
     * @param $deliveryAmount
     * @param $deliveryKM
     * @param $quantity
     * @param $shopDeliveryID
     * @param $isCharity - благотворительность
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @param bool $isValue
     * @return float
     * @throws HTTP_Exception_500
     */
    public static function getPrice($deliveryAmount, $deliveryKM, $quantity, $shopDeliveryID, $isCharity,
                                    SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver, $isValue = FALSE)
    {
        if($isCharity){
            if($isValue){
                return array(
                    'result' => 0,
                    'value' => 0,
                );
            }else {
                return 0;
            }
        }

        $model = new Model_Ab1_Shop_Delivery();
        $model->setDBDriver($driver);

        if (!Helpers_DB::dublicateObjectLanguage($model, $shopDeliveryID, $sitePageData)) {
            throw new HTTP_Exception_500('Delivery not found.');
        }

        switch ($model->getDeliveryTypeID()){
            case Model_Ab1_DeliveryType::DELIVERY_TYPE_KM:
                $result = $model->getPrice() * $deliveryKM;
                break;
            case Model_Ab1_DeliveryType::DELIVERY_TYPE_WEIGHT:
                if($model->getMinQuantity() > $quantity){
                    $quantity = $model->getMinQuantity();
                }
                $result = $model->getPrice() * $quantity;
                break;
            case Model_Ab1_DeliveryType::DELIVERY_TYPE_WEIGHT_AND_KM:
                if($model->getMinQuantity() > $quantity){
                    $quantity = $model->getMinQuantity();
                }
                $result = $model->getPrice() * $deliveryKM * $quantity;
                break;
            case Model_Ab1_DeliveryType::DELIVERY_TYPE_TREATY:
                $result = $deliveryAmount;
                break;
            default:
                $result = $model->getPrice();
        }

        if($isValue) {
            switch ($model->getDeliveryTypeID()){
                case Model_Ab1_DeliveryType::DELIVERY_TYPE_KM:
                    $value = $deliveryKM;
                    break;
                case Model_Ab1_DeliveryType::DELIVERY_TYPE_WEIGHT:
                    $value = $quantity;
                    break;
                case Model_Ab1_DeliveryType::DELIVERY_TYPE_WEIGHT_AND_KM:
                    $value = $quantity;
                    break;
                case Model_Ab1_DeliveryType::DELIVERY_TYPE_TREATY:
                    $value = $quantity;
                    break;
                default:
                    $value = 1;
            }

            return array(
                'result' => $result,
                'value' => $value,
            );
        }else{
            return $result;
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

        $model = new Model_Ab1_Shop_Delivery();
        $model->setDBDriver($driver);

        if (!Helpers_DB::dublicateObjectLanguage($model, $id, $sitePageData)) {
            throw new HTTP_Exception_500('Delivery not found.');
        }

        if(Request_RequestParams::getParamBoolean("is_undel") === TRUE){
            $model->dbUnDelete($sitePageData->userID, 0, $sitePageData->shopID);
        }else {
            $model->dbDelete($sitePageData->userID, 0, $sitePageData->shopID);
        }
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
        $model = new Model_Ab1_Shop_Delivery();
        $model->setDBDriver($driver);

        $id = Request_RequestParams::getParamInt('id');
        if($id > 0) {
            if (!Helpers_DB::dublicateObjectLanguage($model, $id, $sitePageData)) {
                throw new HTTP_Exception_500('Delivery not found.');
            }
        }

        Request_RequestParams::setParamBoolean('is_public', $model);
        Request_RequestParams::setParamStr('text', $model);
        Request_RequestParams::setParamStr('name', $model);
        Request_RequestParams::setParamStr("old_id", $model);

        Request_RequestParams::setParamStr('name_1c', $model);
        Request_RequestParams::setParamStr('name_site', $model);
        Request_RequestParams::setParamFloat('price', $model);
        Request_RequestParams::setParamFloat('km', $model);
        Request_RequestParams::setParamInt("shop_delivery_group_id", $model);
        Request_RequestParams::setParamInt("shop_product_rubric_id", $model);
        Request_RequestParams::setParamInt("shop_product_id", $model);

        Request_RequestParams::setParamInt('delivery_type_id', $model);
        Request_RequestParams::setParamFloat('min_quantity', $model);

        // название
        if(empty($model->getName()) || empty($model->getNameSite()) || empty($model->getName1C())){
            if(!empty($model->getName())){
                $name = $model->getName();
            }elseif(!empty($model->getName1C())){
                $name = $model->getName1C();
            }elseif(!empty($model->getNameSite())){
                $name = $model->getNameSite();
            }else{
                $name = '';
            }

            if(empty($model->getName())){
                $model->setName($name);
            }
            if(empty($model->getNameSite())){
                $model->setNameSite($name);
            }
            if(empty($model->getName1C())){
                $model->setName1C($name);
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

            Helpers_DB::saveDBObject($model, $sitePageData);
            $result['values'] = $model->getValues();
        }

        return array(
            'id' => $model->id,
            'result' => $result,
        );
    }

    /**
     * Загрузить товары из XML
     * @param $fileName
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     */
    public static function loadXML($fileName, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        $xml = simplexml_load_file($fileName);

        $model = new Model_Ab1_Shop_Delivery();
        $model->setDBDriver($driver);

        $deliveryIDs = Request_Request::find('DB_Ab1_Shop_Delivery', $sitePageData->shopMainID, $sitePageData, $driver,
            array('is_public_ignore' => TRUE, Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE), 0, TRUE);

        // находим данные с одинаковый кодом 1С и удаляем их
        $deliveries = array();
        foreach ($deliveryIDs->childs as $child) {
            if (key_exists($child->values['old_id'], $deliveries)){
                $model->clear();
                $model->__setArray(array('values' => $child->values));
                $model->dbDelete($sitePageData->userID);
            }
            $deliveries[$child->values['old_id']] = $child;
        }
        unset($deliveryIDs);

        foreach($xml->rate as $delivery) {
            $model->clear();

            $deliveryID = trim($delivery->code);
            if (key_exists($deliveryID, $deliveries)) {
                $model->__setArray(array('values' => $deliveries[$deliveryID]->values));
            } else {
                $model->setOldID($deliveryID);
            }

            // название
            $model->setName1C($delivery->name);
            if(empty($model->getName()) || empty($model->getNameSite()) || empty($model->getName1C())){
                if(!empty($model->getName())){
                    $name = $model->getName();
                }elseif(!empty($model->getName1C())){
                    $name = $model->getName1C();
                }elseif(!empty($model->getNameSite())){
                    $name = $model->getNameSite();
                }else{
                    $name = '';
                }

                if(empty($model->getName())){
                    $model->setName($name);
                }
                if(empty($model->getNameSite())){
                    $model->setNameSite($name);
                }
                if(empty($model->getName1C())){
                    $model->setName1C($name);
                }
            }

            $model->setPrice($delivery->price);

            Helpers_DB::saveDBObject($model, $sitePageData);
        }
    }
}
