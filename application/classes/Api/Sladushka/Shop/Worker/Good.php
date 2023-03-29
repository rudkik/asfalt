<?php defined('SYSPATH') or die('No direct script access.');

class Api_Sladushka_Shop_Worker_Good  {

    /**
     * Сохранение товары
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @throws HTTP_Exception_500
     */
    public static function save(SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        $model = new Model_Sladushka_Shop_Worker_Good();
        $model->setDBDriver($driver);

        $id = Request_RequestParams::getParamInt('id');
        if($id > 0) {
            if (!Helpers_DB::dublicateObjectLanguage($model, $id, $sitePageData)) {
                throw new HTTP_Exception_500('Worker goods not found.');
            }
        }

        Request_RequestParams::setParamBoolean('is_public', $model);
        Request_RequestParams::setParamStr('text', $model);
        Request_RequestParams::setParamStr('name', $model);
        Request_RequestParams::setParamStr("old_id", $model);


        Request_RequestParams::setParamDateTime("date", $model);
        Request_RequestParams::setParamInt("shop_worker_id", $model);
        Request_RequestParams::setParamFloat("amount", $model);
        Request_RequestParams::setParamFloat('quantity', $model);
        Request_RequestParams::setParamFloat('took', $model);
        Request_RequestParams::setParamFloat('return', $model);

        $options = Request_RequestParams::getParamArray('options');
        if ($options !== NULL) {
            $model->addOptionsArray($options);
        }

        // при создании нового контрагента
        if(Request_RequestParams::getParamBoolean('is_add_worker')){
            $shopWorker = Request_RequestParams::getParamArray('shop_worker');
            if ($shopWorker !== NULL){
                $shopWorker = Api_Sladushka_Shop_Worker::saveOfArray($shopWorker, $sitePageData, $driver);
                $model->setShopWorkerID($shopWorker['id']);
            }
        }

        $result = array();
        if ($model->validationFields($result)) {
            if($model->id < 1) {
                Helpers_DB::saveDBObject($model, $sitePageData);
            }

            $shopWorkerGoodItems = Request_RequestParams::getParamArray('shop_worker_good_items');
            if($shopWorkerGoodItems !== NULL) {
                $total = Api_Sladushka_Shop_Worker_Good_Item::save($model->id, $model->getShopWorkerID(), $shopWorkerGoodItems, $sitePageData, $driver);

                $model->setAmount($total['amount']);
                $model->setTook($total['took']);
                $model->setQuantity($total['quantity']);
                $model->setReturn($total['return']);
                $model->setWeight($total['weight']);
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
        $model = new Model_Sladushka_Shop_Worker_Good();
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

        if (key_exists('date', $data)) {
            $model->setDateFrom($data['date']);
        }
        if (key_exists('shop_worker_id', $data)) {
            $model->setDateTo($data['shop_worker_id']);
        }
        $model->setShopContractorID($shopWorkerID);

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
                $n = Database::instance()->query(Database::SELECT, 'SELECT nextval(\'shop_my_attorney\') as id;')->as_array(NULL, 'id')[0];
                $n = '000000'.$n;
                $n = substr($n, strlen($n) - 7);
                $model->setNumber($n);
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
