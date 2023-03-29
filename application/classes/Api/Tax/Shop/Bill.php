<?php defined('SYSPATH') or die('No direct script access.');

class Api_Tax_Shop_Bill
{
    /**
     * Добавления заказов в список
     * @param $shopGoodID
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @return array
     * @throws HTTP_Exception_500
     */
    public static function add($shopGoodID, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        $modelGood = new Model_Shop_Good();
        $modelGood->setDBDriver($driver);
        if (!Helpers_DB::dublicateObjectLanguage($modelGood, $shopGoodID, $sitePageData, $sitePageData->shopMainID)) {
            throw new HTTP_Exception_500('Goods not found.');
        }

        $model = new Model_Tax_Shop_Bill();
        $model->setDBDriver($driver);

        $model->setAmount($modelGood->getPrice());
        $model->setMonth(intval(Arr::path($modelGood->getOptionsArray(), 'month', 0)));
        $model->setAccessTypeID(floatval(Arr::path($modelGood->getOptionsArray(), 'type', 0)));
        $model->setShopGoodID($shopGoodID);

        $result = array();
        if ($model->validationFields($result)) {
            Helpers_DB::saveDBObject($model, $sitePageData, $sitePageData->shopID);
            $result['values'] = $model->getValues();
        }

        return array(
            'id' => $model->id,
            'result' => $result,
        );
    }

    public static function save(SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        $model = new Model_Tax_Shop_Bill();
        $model->setDBDriver($driver);

        $id = Request_RequestParams::getParamInt('id');
        if (!Helpers_DB::dublicateObjectLanguage($model, $id, $sitePageData)) {
            throw new HTTP_Exception_500('Bill not found.');
        }

        $options = Request_RequestParams::getParamArray('options');
        if($options !== NULL){
            $model->addOptionsArray($options);
        }

        /*Request_RequestParams::setParamDateTime('paid_at', $model);
        Request_RequestParams::setParamInt('paid_type_id', $model);
        Request_RequestParams::setParamBoolean('is_paid', $model);*/

        $shopGoodID = $model->getShopGoodID();
        Request_RequestParams::setParamInt('shop_good_id', $model);
        if ($shopGoodID != $model->getShopGoodID()){
            if ($model->getShopGoodID() > 0){
                $modelGood = new Model_Shop_Good();
                $modelGood->setDBDriver($driver);
                if (! Helpers_DB::dublicateObjectLanguage($modelGood, $model->getShopGoodID(), $sitePageData, $sitePageData->shopMainID)){
                    throw new HTTP_Exception_500('Goods not found.');
                }
                $model->setAmount($modelGood->getPrice());
                $model->setMonth(intval(Arr::path($modelGood->getOptionsArray(), 'month', 0)));
                $model->setAccessTypeID(floatval(Arr::path($modelGood->getOptionsArray(), 'type', 0)));
            }else{
                $model->setAmount(0);
                $model->setMonth(0);
            }
        }

        $result = array();
        if ($model->validationFields($result)) {
            Helpers_DB::saveDBObject($model, $sitePageData);
            $result['values'] = $model->getValues();
        }

        return array(
            'id' => $model->id,
            'result' => $result,
        );
    }

    /**
     * удаление заказа
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

        $model = new Model_Tax_Shop_Bill();
        $model->setDBDriver($driver);

        if (!Helpers_DB::dublicateObjectLanguage($model, $id, $sitePageData)) {
            throw new HTTP_Exception_500('Bill not found.');
        }

        $isUnDel = Request_RequestParams::getParamBoolean("is_undel");
        if((($isUnDel === TRUE) && (!$model->getIsDelete()))
            || (($isUnDel !== TRUE) && ($model->getIsDelete()))){
            return FALSE;
        }

        if($isUnDel === TRUE){
            $model->dbUnDelete($sitePageData->userID, 0, $sitePageData->shopID);
        }else {
            $model->dbDelete($sitePageData->userID, 0, $sitePageData->shopID);
        }

        return TRUE;
    }
}