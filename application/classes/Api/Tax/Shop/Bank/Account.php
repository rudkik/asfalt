<?php defined('SYSPATH') or die('No direct script access.');

class Api_Tax_Shop_Bank_Account  {

    /**
     * удаление записи
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

        $model = new Model_Tax_Shop_Bank_Account();
        $model->setDBDriver($driver);

        if (!Helpers_DB::dublicateObjectLanguage($model, $id, $sitePageData)) {
            throw new HTTP_Exception_500('Bank account not found.');
        }

        if (($isUnDel && !$model->getIsDelete()) or (!$isUnDel && $model->getIsDelete())){
            return FALSE;
        }

        if($isUnDel){
            $model->dbUnDelete($sitePageData->userID, 0, $sitePageData->shopID);
        }else {
            $model->dbDelete($sitePageData->userID, 0, $sitePageData->shopID);
        }

        $sitePageData->shop->addRequisitesArray(
            array(
                'is_many_bank_account' => self::getCount($sitePageData, $driver) > 1,
            )
        );
        Helpers_DB::saveDBObject($sitePageData->shop, $sitePageData);
    }


    /**
     * Количество счетов фактуры
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @return int
     */
    public static function getCount(SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver){
        $params = Request_RequestParams::setParams(
            array(
                'count_id' => TRUE,
            )
        );
        $ids = Request_Tax_Shop_Bank_Account::findShopBankAccountIDs($sitePageData->shopID, $sitePageData, $driver, $params);

        if (count($ids->childs) == 0){
            return 0;
        }else {
            return $ids->childs[0]->values['count'];
        }
    }

    /**
     * Сохранение товары
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @throws HTTP_Exception_500
     */
    public static function save(SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        $model = new Model_Tax_Shop_Bank_Account();
        $model->setDBDriver($driver);

        $id = Request_RequestParams::getParamInt('id');
        if($id > 0) {
            if (!Helpers_DB::dublicateObjectLanguage($model, $id, $sitePageData)) {
                throw new HTTP_Exception_500('Bank account not found.');
            }
        }

        Request_RequestParams::setParamBoolean('is_public', $model);
        Request_RequestParams::setParamStr('text', $model);
        Request_RequestParams::setParamStr('name', $model);
        Request_RequestParams::setParamStr("old_id", $model);

        Request_RequestParams::setParamStr('iik', $model);
        Request_RequestParams::setParamInt('bank_id', $model);

        $options = Request_RequestParams::getParamArray('options');
        if ($options !== NULL) {
            $model->addOptionsArray($options);
        }

        $result = array();
        if ($model->validationFields($result)) {
            if($model->id < 1) {
                Helpers_DB::saveDBObject($model, $sitePageData);
            }

            $currentID = Arr::path($sitePageData->shop->getRequisitesArray(), 'shop_bank_account_id', 0);
            if ($currentID <= 0){
                $sitePageData->shop->addRequisitesArray(
                    array(
                        'shop_bank_account_id' => $model->id,
                    )
                );

                Helpers_DB::saveDBObject($sitePageData->shop, $sitePageData);
            }elseif($currentID != $model->id){
                $sitePageData->shop->addRequisitesArray(
                    array(
                        'is_many_bank_account' => self::getCount($sitePageData, $driver) > 1,
                    )
                );
                Helpers_DB::saveDBObject($sitePageData->shop, $sitePageData);
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
}
