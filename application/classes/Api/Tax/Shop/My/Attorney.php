<?php defined('SYSPATH') or die('No direct script access.');

class Api_Tax_Shop_My_Attorney  {

    /**
     * Сохранение товары
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @throws HTTP_Exception_500
     */
    public static function save(SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        $model = new Model_Tax_Shop_My_Attorney();
        $model->setDBDriver($driver);

        $id = Request_RequestParams::getParamInt('id');
        if($id > 0) {
            if (!Helpers_DB::dublicateObjectLanguage($model, $id, $sitePageData)) {
                throw new HTTP_Exception_500('Attorney not found.');
            }
        }

        Request_RequestParams::setParamBoolean('is_public', $model);
        Request_RequestParams::setParamStr('text', $model);
        Request_RequestParams::setParamStr('name', $model);
        Request_RequestParams::setParamBoolean("is_public", $model);
        Request_RequestParams::setParamStr("email", $model);
        Request_RequestParams::setParamStr("old_id", $model);

        Request_RequestParams::setParamDateTime('date_from', $model);
        Request_RequestParams::setParamDateTime('date_to', $model);
        Request_RequestParams::setParamInt('shop_contractor_id', $model);
        Request_RequestParams::setParamStr('number', $model);
        Request_RequestParams::setParamInt('shop_worker_id', $model);
        Request_RequestParams::setParamFloat('amount', $model);
        Request_RequestParams::setParamInt('shop_bank_account_id', $model);

        $options = Request_RequestParams::getParamArray('options');
        if ($options !== NULL) {
            $model->addOptionsArray($options);
        }

        // при создании нового контрагента
        if(Request_RequestParams::getParamBoolean('is_add_worker')){
            $shopWorker = Request_RequestParams::getParamArray('shop_worker');
            if ($shopWorker !== NULL){
                $shopWorker = Api_Tax_Shop_Worker::saveOfArray($shopWorker, $sitePageData, $driver);
                $model->setShopWorkerID($shopWorker['id']);
            }
        }

        if(Func::_empty($model->getNumber())){
            $model->setNumber(Api_Tax_Sequence::getSequence($model->tableName,
                Helpers_DateTime::getYear($model->getDateFrom()), $sitePageData, $driver));
        }

        $result = array();
        if ($model->validationFields($result)) {
            if($model->id < 1) {
                Helpers_DB::saveDBObject($model, $sitePageData);
            }

            $shopMyAttorneyItems = Request_RequestParams::getParamArray('shop_my_attorney_items');
            if($shopMyAttorneyItems !== NULL) {
                $model->setAmount(Api_Tax_Shop_My_Attorney_Item::save($model->id, $model->getShopContractorID(), $shopMyAttorneyItems, $sitePageData, $driver));
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
        $model = new Model_Tax_Shop_My_Attorney();
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
