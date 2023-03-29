<?php defined('SYSPATH') or die('No direct script access.');

class Api_Tax_Shop_Money  {

    /**
     * Сохранение товары
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @throws HTTP_Exception_500
     */
    public static function save(SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        $model = new Model_Tax_Shop_Money();
        $model->setDBDriver($driver);

        $id = Request_RequestParams::getParamInt('id');
        if($id > 0) {
            if (!Helpers_DB::dublicateObjectLanguage($model, $id, $sitePageData)) {
                throw new HTTP_Exception_500('Money not found.');
            }
        }

        Request_RequestParams::setParamBoolean('is_public', $model);
        Request_RequestParams::setParamStr('text', $model);
        Request_RequestParams::setParamStr('name', $model);
        Request_RequestParams::setParamStr("old_id", $model);

        Request_RequestParams::setParamFloat('amount', $model);
        Request_RequestParams::setParamInt('shop_contract_id', $model);
        Request_RequestParams::setParamInt('shop_contractor_id', $model);
        Request_RequestParams::setParamInt('shop_invoice_commercial_id', $model);
        Request_RequestParams::setParamInt('shop_my_invoice_id', $model);
        Request_RequestParams::setParamDateTime('date', $model);
        Request_RequestParams::setParamBoolean("is_cash", $model);
        Request_RequestParams::setParamBoolean("is_coming", $model);

        $options = Request_RequestParams::getParamArray('options');
        if ($options !== NULL) {
            $model->addOptionsArray($options);
        }

        // при создании нового контрагента
        if(Request_RequestParams::getParamBoolean('is_add_contractor')){
            $shopContractor = Request_RequestParams::getParamArray('shop_contractor');
            if ($shopContractor !== NULL){
                $shopContractor = Api_Tax_Shop_Contractor::saveOfArray($shopContractor, $sitePageData, $driver);
                $model->setShopContractorID($shopContractor['id']);
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
