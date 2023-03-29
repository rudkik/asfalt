<?php defined('SYSPATH') or die('No direct script access.');

class Api_Shop  {

    /**
     * Сохранение информации магазина
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @param bool $isSaveBranch
     * @return array
     * @throws HTTP_Exception_500
     */
    public static function save(SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver, $isSaveBranch = FALSE)
    {
        $model = new Model_Shop();
        $model->setDBDriver($driver);

        if($isSaveBranch){
            $id = Request_RequestParams::getParamInt('id');
        }else{
            $id = $sitePageData->shopID;
        }

        if (!Helpers_DB::dublicateObjectLanguage($model, $id, $sitePageData)) {
            throw new HTTP_Exception_500('Shop not found.');
        }

        if($isSaveBranch){
            $model->setMainShopID($sitePageData->shopID);
        }

        Request_RequestParams::setParamInt("shop_table_rubric_id", $model);
        Request_RequestParams::setParamBoolean('is_public', $model);
        Request_RequestParams::setParamStr('text', $model);
        Request_RequestParams::setParamStr('name', $model);
        Request_RequestParams::setParamBoolean("is_public", $model);
        Request_RequestParams::setParamStr('official_name', $model);
        Request_RequestParams::setParamStr('sub_domain', $model);
        Request_RequestParams::setParamStr('domain', $model);
        Request_RequestParams::setParamBoolean('is_block', $model);

        $options = Request_RequestParams::getParamArray('options');
        if ($options !== NULL) {
            $model->addOptionsArray($options);
        }

        $seo = Request_RequestParams::getParamArray('seo');
        if ($seo !== NULL) {
            $model->setSEOArray($seo);
        }

        $cityIDs = Request_RequestParams::getParamArray('city_ids');
        if ($cityIDs !== NULL) {
            $model->setCityIDsArray($cityIDs);
        }
        
        $landIDs = Request_RequestParams::getParamArray('land_ids');
        if ($landIDs !== NULL) {
            $model->setLandIDsArray($landIDs);
        }

        $currencyIDs = Request_RequestParams::getParamArray('currency_ids');
        if ($currencyIDs !== NULL) {
            $model->setCurrencyIDsArray($currencyIDs);
        }

        $requisites = Request_RequestParams::getParamArray('requisites');
        if ($requisites !== NULL) {
            if (key_exists('company', $requisites)){
                $requisites['company_name'] = $requisites['company'];
            }else{
                $requisites['company_name'] = $model->getName();
            }
            // добавляем форму организации для названия
            $modelOrganizationType = $model->getElement('requisites_organization_type_id', TRUE, $sitePageData->shopMainID);
            if ($modelOrganizationType !== NULL){
                $requisites['company_name'] = $modelOrganizationType->getName().' "'.$requisites['company_name'].'"';
            }
            $model->

            $model->setRequisitesArray($requisites);
        }

        $options = Request_RequestParams::getParamArray('shop_menu');
        if ($options !== NULL) {
            $model->setShopMenuArray($options);
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
     * Посчитать количетсво на складе
     * @param integer $shopID
     * @param Model_Driver_DBBasicDriver $driver
     * @param boolean $isIgnorIsPublic
     * @param integer $limit
     * @return MyArray
     */
    public static function getShopGoodItemStorageCount($shopID, $shopGoodID, SitePageData $sitePageData,
                                                       Model_Driver_DBBasicDriver $driver){
        $sql = GlobalData::newModelDriverDBSQL();
        $sql->getRootSelect()->addFunctionField('', 'storage_count', Model_Driver_DBBasicSelect::FUNCTION_SUM, 'storage_sum');
        $sql->setTableName(Model_Shop_GoodItem::TABLE_NAME);

        $sql->getRootWhere()->addField("is_delete", '', 0);
        $sql->getRootWhere()->addField("shop_id", '', $shopID);
        $sql->getRootWhere()->addField("shop_good_id", '', $shopGoodID);

        $arr = $driver->getSelect($sql, TRUE, 0, $shopID)['result'];

        if(count($arr) == 0){
            return NULL;
        }else{
            return $arr[0]['storage_sum'];
        }
    }

}
