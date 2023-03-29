<?php defined('SYSPATH') or die('No direct script access.');

class Api_Ab1_Shop_Material_Storage_Metering  {

    /**
     * Сохранение
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @return array
     * @throws HTTP_Exception_500
     */
    public static function save(SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        $model = new Model_Ab1_Shop_Material_Storage_Metering();
        $model->setDBDriver($driver);

        $id = Request_RequestParams::getParamInt('id');
        if($id > 0) {
            if (!Helpers_DB::dublicateObjectLanguage($model, $id, $sitePageData)) {
                throw new HTTP_Exception_500('Material storage metering not found.');
            }
        }

        Request_RequestParams::setParamBoolean('is_public', $model);
        Request_RequestParams::setParamStr('text', $model);
        Request_RequestParams::setParamStr('name', $model);
        Request_RequestParams::setParamFloat("quantity", $model);
        Request_RequestParams::setParamFloat("meter", $model);
        Request_RequestParams::setParamInt("shop_material_storage_id", $model);
        Request_RequestParams::setParamInt("shop_material_id", $model);


        $options = Request_RequestParams::getParamArray('options');
        if ($options !== NULL) {
            $model->addOptionsArray($options);
        }

        $modelStorage = new Model_Ab1_Shop_Material_Storage();
        $modelStorage->setDBDriver($driver);
        if (Helpers_DB::getDBObject($modelStorage, $model->getShopMaterialStorageID(), $sitePageData)) {
            if($modelStorage->getSizeMeter() < $model->getMeter()){
                return array(
                    'id' => $model->id,
                    'result' => true,
                );
            }

            $model->setShopMaterialID($modelStorage->getShopMaterialID());
            $model->setQuantity($model->getMeter() * $modelStorage->getTonInMeter());

            if($model->id < 1) {
                $modelStorage->setQuantity($model->getQuantity());
                $modelStorage->setMeter($model->getMeter());
                Helpers_DB::saveDBObject($modelStorage, $sitePageData);
            }
        }

        $result = array();
        if ($model->validationFields($result)) {

            if ($model->id < 1) {
                Helpers_DB::saveDBObject($model, $sitePageData);
            }

            // загружаем фотографии
            $file = new Model_File($sitePageData);
            $file->saveFiles(Request_RequestParams::getParamArray('files'), $model, $sitePageData, $driver);

            Helpers_DB::saveDBObject($model, $sitePageData, $sitePageData->shopID);
            $result['values'] = $model->getValues();
        }

        return array(
            'id' => $model->id,
            'result' => $result,
        );
    }
}
