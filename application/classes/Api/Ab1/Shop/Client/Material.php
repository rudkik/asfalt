<?php defined('SYSPATH') or die('No direct script access.');

class Api_Ab1_Shop_Client_Material  {

    /**
     * Сохранение списка товаров
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     */
    public static function saveListCollations($shopTableCatalogID, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        $model = new Model_Ab1_Shop_Client_Material();
        $model->setDBDriver($driver);

        $shopClientMaterials = Request_RequestParams::getParamArray('data', array());
        foreach ($shopClientMaterials as &$shopClientMaterial) {
            $model->clear();

            $id = intval(Arr::path($shopClientMaterial, 'shop_client_material_id', 0));
            if ($id > 0) {
                if (!Helpers_DB::dublicateObjectLanguage($model, $id, $sitePageData, $sitePageData->shopMainID)) {
                    continue;
                }
            } else {
                $model->setShopTableCatalogID($shopTableCatalogID);
            }

            if($id < 1) {
                if (key_exists('is_public', $shopClientMaterial)) {
                    $model->setIsPublic($shopClientMaterial['is_public']);
                }
                if (key_exists('collations', $shopClientMaterial)) {
                    $model->addCollationsArray($shopClientMaterial['collations']);
                }
                if (key_exists('old_id', $shopClientMaterial)) {
                    $model->setOldID($shopClientMaterial['old_id']);
                }
                if (key_exists('last_name', $shopClientMaterial)) {
                    $model->setLastName($shopClientMaterial['last_name']);
                }
                if (key_exists('name', $shopClientMaterial)) {
                    if (!empty($shopClientMaterial['name'])) {
                        $model->setName($shopClientMaterial['name']);
                    }
                }
                if (key_exists('text', $shopClientMaterial)) {
                    $model->setText($shopClientMaterial['text']);
                }
            }

            $options = array();
            foreach($shopClientMaterial as $k => $v){
                if(strpos($k, 'options.') === 0){
                    $options[str_replace('options.', '', $k)] = $v;
                }
            }
            $model->addOptionsArray($options, FALSE);

            if (key_exists('price', $shopClientMaterial)) {
                $model->setPrice($shopClientMaterial['price']);
            }

            $shopClientMaterial['shop_client_material_id'] = Helpers_DB::saveDBObject($model, $sitePageData, $sitePageData->shopMainID);
            $shopClientMaterial['shop_client_material_name'] = trim($model->getLastName().' '.$model->getName());
        }

        return $shopClientMaterials;
    }

    /**
     * Сохранение списка товаров
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @return false
     */
    public static function saveList(SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        $model = new Model_Ab1_Shop_Client_Material();
        $model->setDBDriver($driver);

        $shopClientMaterials = Request_RequestParams::getParamArray('shop_client_materials', array());
        if ($shopClientMaterials === NULL) {
            return FALSE;
        }

        foreach ($shopClientMaterials as $id => $shopClientMaterial) {
            $id = intval($id);
            if ($id > 0) {
                if (!Helpers_DB::dublicateObjectLanguage($model, $id, $sitePageData, $sitePageData->shopMainID)) {
                    continue;
                }

                if (key_exists('is_public', $shopClientMaterial)) {
                    $model->setIsPublic($shopClientMaterial['is_public']);
                }
                if (key_exists('name', $shopClientMaterial)) {
                    if (!empty($shopClientMaterial['name'])) {
                        $model->setName($shopClientMaterial['name']);
                    }
                }

                if (key_exists('text', $shopClientMaterial)) {
                    $model->setText($shopClientMaterial['text']);
                }

                if (key_exists('last_name', $shopClientMaterial)) {
                    $model->setLastName($shopClientMaterial['last_name']);
                }

                if (key_exists('remarketing', $shopClientMaterial)) {
                    $model->setRemarketing($shopClientMaterial['remarketing']);
                }

                if (key_exists('shop_table_rubric_id', $shopClientMaterial)) {
                    $model->setShopTableRubricID($shopClientMaterial['shop_table_rubric_id']);
                }
                if (key_exists('options', $shopClientMaterial)) {
                    $options = $shopClientMaterial['options'];
                    if (is_array($options)) {
                        $model->addOptionsArray($options);
                    }
                }
                if (key_exists('collations', $shopClientMaterial)) {
                    $options = $shopClientMaterial['collations'];
                    if (!is_array($options)) {
                        $options = explode("\r\n", $options);
                    }
                    $model->addCollationsArray($options);
                }

                Helpers_DB::saveDBObject($model, $sitePageData, $sitePageData->shopMainID);
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

        $model = new Model_Ab1_Shop_Client_Material();
        $model->setDBDriver($driver);

        if (!Helpers_DB::dublicateObjectLanguage($model, $id, $sitePageData, $sitePageData->shopMainID)) {
            throw new HTTP_Exception_500('Client material not found.');
        }

        if(Request_RequestParams::getParamBoolean("is_undel") === TRUE){
            $model->dbUnDelete($sitePageData->userID, 0, $sitePageData->shopMainID);
        }else {
            $model->dbDelete($sitePageData->userID, 0, $sitePageData->shopMainID);
        }
    }


    /**
     * Сохранение товары
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @return array
     * @throws HTTP_Exception_500
     */
    public static function save(SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        $model = new Model_Ab1_Shop_Client_Material();
        $model->setDBDriver($driver);

        $id = Request_RequestParams::getParamInt('id');
        if($id > 0) {
            if (!Helpers_DB::dublicateObjectLanguage($model, $id, $sitePageData, $sitePageData->shopMainID)) {
                throw new HTTP_Exception_500('Client material not found.');
            }
        }

        Request_RequestParams::setParamInt("shop_table_rubric_id", $model);
        Request_RequestParams::setParamBoolean('is_public', $model);
        Request_RequestParams::setParamStr('text', $model);
        Request_RequestParams::setParamStr('name', $model);
        Request_RequestParams::setParamBoolean("is_public", $model);
        Request_RequestParams::setParamStr("last_name", $model);
        Request_RequestParams::setParamStr("email", $model);
        Request_RequestParams::setParamStr("old_id", $model);
        Request_RequestParams::setParamInt("shop_table_select_id", $model);
        Request_RequestParams::setParamInt("shop_table_unit_id", $model);
        Request_RequestParams::setParamInt("shop_table_brand_id", $model);

        Request_RequestParams::setParamStr('name_1c', $model);
        Request_RequestParams::setParamStr('name_site', $model);

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
                Helpers_DB::saveDBObject($model, $sitePageData, $sitePageData->shopMainID);
            }

            // загружаем фотографии
            $file = new Model_File($sitePageData);
            $file->saveFiles(Request_RequestParams::getParamArray('files'), $model, $sitePageData, $driver);

            Helpers_DB::saveDBObject($model, $sitePageData, $sitePageData->shopMainID);
            $result['values'] = $model->getValues();
        }

        return array(
            'id' => $model->id,
            'result' => $result,
        );
    }
}
