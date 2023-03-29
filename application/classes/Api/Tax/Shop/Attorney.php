<?php defined('SYSPATH') or die('No direct script access.');

class Api_Tax_Shop_Attorney  {

    /**
     * Сохранение товары
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @throws HTTP_Exception_500
     */
    public static function save(SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        $model = new Model_Tax_Shop_Attorney();
        $model->setDBDriver($driver);

        $id = Request_RequestParams::getParamInt('id');
        if($id > 0) {
            if (!Helpers_DB::dublicateObjectLanguage($model, $id, $sitePageData)) {
                throw new HTTP_Exception_500('Attorney not found.');
            }

            $type = $model->getShopTableCatalogID();
        }else{
            $type = Request_RequestParams::getParamInt('type');
            $model->setShopTableCatalogID($type);
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

        Request_RequestParams::setParamDateTime('date_from', $model);
        Request_RequestParams::setParamDateTime('date_to', $model);
        Request_RequestParams::setParamInt('shop_contractor_id', $model);
        Request_RequestParams::setParamInt('number', $model);

        $options = Request_RequestParams::getParamArray('options');
        if ($options !== NULL) {
            $model->addOptionsArray($options);
        }

        $result = array();
        if ($model->validationFields($result)) {
            if($model->id < 1) {
                Helpers_DB::saveDBObject($model, $sitePageData);
            }

            if(Func::_empty($model->getNumber())){
                $model->setNumber(Api_Tax_Sequence::getSequence($model->tableName,
                    Helpers_DateTime::getYear($model->getDate()), $sitePageData, $driver));
            }

            // загружаем фотографии
            $file = new Model_File($sitePageData);
            $file->saveFiles(Request_RequestParams::getParamArray('files'), $model, $sitePageData, $driver);

            if($type > 0) {
                $modelType = new Model_Shop_Table_Catalog();
                $modelType->setDBDriver($driver);
                Helpers_DB::dublicateObjectLanguage($modelType, $type, $sitePageData);

                // сохраняем список хэштегов
                $hashtags = Request_RequestParams::getParamArray('shop_table_hashtags');
                if ($hashtags !== NULL) {
                    $model->setShopTableHashtagIDsArray(Api_Shop_Table_ObjectToObject::saveToHashtags(
                        Model_Tax_Shop_Attorney::TABLE_ID, $model->id, $model->getShopTableCatalogID(),
                        $hashtags, $modelType->getChildShopTableCatalogID('hashtag', $sitePageData->dataLanguageID),
                        $sitePageData, $driver));
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

    /**
     * Сохранение товары
     * @param $shopContractorID
     * @param array $data
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @return array
     * @throws HTTP_Exception_500
     */
    public static function saveOfArray($shopContractorID, array $data, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        $model = new Model_Tax_Shop_Attorney();
        $model->setDBDriver($driver);

        $id = intval(Arr::path($data, 'id', 0));
        if($id > 0) {
            if (!Helpers_DB::dublicateObjectLanguage($model, $id, $sitePageData)) {
                throw new HTTP_Exception_500('Contract not found.');
            }

            $type = $model->getShopTableCatalogID();
        }else{
            $type = floatval(Arr::path($data, 'type', 0));
            $model->setShopTableCatalogID($type);
        }

        if (key_exists('shop_table_rubric_id', $data)) {
            $model->setShopTableRubricID($data['shop_table_rubric_id']);
        }
        if (key_exists('is_public', $data)) {
            $model->setIsPublic($data['is_public']);
        }
        if (key_exists('text', $data)) {
            $model->setText($data['text']);
        }
        if (key_exists('name', $data)) {
            $model->setName($data['name']);
        }
        if (key_exists('old_id', $data)) {
            $model->setOldID($data['old_id']);
        }
        if (key_exists('shop_table_select_id', $data)) {
            $model->setShopTableSelectID($data['shop_table_select_id']);
        }
        if (key_exists('shop_table_unit_id', $data)) {
            $model->setShopTableUnitID($data['shop_table_unit_id']);
        }
        if (key_exists('shop_table_brand_id', $data)) {
            $model->setShopTableBrandID($data['shop_table_brand_id']);
        }

        if (key_exists('date_from', $data)) {
            $model->setDateFrom($data['date_from']);
        }
        if (key_exists('date_to', $data)) {
            $model->setDateTo($data['date_to']);
        }
        if (key_exists('number', $data)) {
            $model->setNumber($data['number']);
        }

        $model->setShopContractorID($shopContractorID);

        if (key_exists('options', $data)) {
            $options = $data['options'];
            if (is_array($options)) {
                $model->addOptionsArray($options);
            }
        }

        $result = array();
        if ($model->validationFields($result)) {
            if($model->id < 1) {
                Helpers_DB::saveDBObject($model, $sitePageData);
            }

            if(Func::_empty($model->getNumber())){
                $model->setNumber(Api_Tax_Sequence::getSequence($model->tableName,
                    Helpers_DateTime::getYear($model->getDate()), $sitePageData, $driver));
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
