<?php defined('SYSPATH') or die('No direct script access.');

class Api_Ab1_Shop_Raw_Storage_Drain  {

    /**
     * Сохранение
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @return array
     * @throws HTTP_Exception_500
     */
    public static function save(SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        $model = new Model_Ab1_Shop_Raw_Storage_Drain();
        $model->setDBDriver($driver);

        $id = Request_RequestParams::getParamInt('id');
        if($id > 0) {
            if (!Helpers_DB::dublicateObjectLanguage($model, $id, $sitePageData)) {
                throw new HTTP_Exception_500('Raw storage drain not found.');
            }
        }

        Request_RequestParams::setParamBoolean('is_public', $model);
        Request_RequestParams::setParamStr('text', $model);
        Request_RequestParams::setParamStr('name', $model);
        Request_RequestParams::setParamInt("shop_raw_storage_id", $model);
        Request_RequestParams::setParamInt("shop_raw_id", $model);
        Request_RequestParams::setParamInt("shop_raw_drain_chute_id", $model);
        Request_RequestParams::setParamInt("shop_material_storage_id", $model);
        Request_RequestParams::setParamInt("shop_material_id", $model);
        Request_RequestParams::setParamBoolean('is_upload', $model);

        $options = Request_RequestParams::getParamArray('options');
        if ($options !== NULL) {
            $model->addOptionsArray($options);
        }

        $result = array();
        if ($model->validationFields($result)) {
            if ($model->id < 1) {
                if ($model->getIsUpload()) {
                    // получаем сырье и поставщика, которое заливают
                    if ($model->getShopRawDrainChuteID() != $model->getOriginalValue('shop_raw_drain_chute_id')) {
                        $model->setShopRawID(0);
                        $model->setShopBoxcarClientID(0);
                        if ($model->getShopRawDrainChuteID() > 0) {
                            $modelDrainChute = new Model_Ab1_Shop_Raw_DrainChute();
                            $modelDrainChute->setDBDriver($driver);
                            if (Helpers_DB::getDBObject($modelDrainChute, $model->getShopRawDrainChuteID(), $sitePageData)) {
                                $model->setShopRawID($modelDrainChute->getShopRawID());
                                $model->setShopBoxcarClientID($modelDrainChute->getShopBoxcarClientID());
                            }
                        }
                    }

                    // изменяем сырьевой парк
                    if ($model->getShopRawStorageID() > 0
                        && ($model->getShopRawStorageID() != $model->getOriginalValue('shop_raw_storage_id')
                            || $model->getShopRawDrainChuteID() != $model->getOriginalValue('shop_raw_drain_chute_id'))) {
                        $modelStorage = new Model_Ab1_Shop_Raw_Storage();
                        $modelStorage->setDBDriver($driver);
                        if (Helpers_DB::getDBObject($modelStorage, $model->getShopRawStorageID(), $sitePageData)) {
                            $modelStorage->setShopRawID($model->getShopRawID());
                            $modelStorage->setShopBoxcarClientID($model->getShopBoxcarClientID());
                            Helpers_DB::saveDBObject($modelStorage, $sitePageData);
                        }
                    }
                } else {
                    // изменяем сырьевой парк
                    if ($model->getShopRawStorageID() > 0 && $model->getShopRawStorageID() != $model->getOriginalValue('shop_raw_storage_id')) {
                        $modelStorage = new Model_Ab1_Shop_Raw_Storage();
                        $modelStorage->setDBDriver($driver);
                        if (Helpers_DB::getDBObject($modelStorage, $model->getShopRawStorageID(), $sitePageData)) {
                            $model->setShopRawID($modelStorage->getShopRawID());
                            $model->setShopBoxcarClientID($modelStorage->getShopBoxcarClientID());
                        }
                    }

                    // изменяем материал в кубе готовой продукции
                    if ($model->getShopMaterialStorageID() > 0
                        && ($model->getShopMaterialStorageID() != $model->getOriginalValue('shop_material_storage_id')
                            || $model->getShopMaterialID() != $model->getOriginalValue('shop_material_id'))) {
                        $modelStorage = new Model_Ab1_Shop_Material_Storage();
                        $modelStorage->setDBDriver($driver);
                        if (Helpers_DB::getDBObject($modelStorage, $model->getShopMaterialStorageID(), $sitePageData)) {
                            $modelStorage->setShopMaterialID($model->getShopMaterialID());
                            Helpers_DB::saveDBObject($modelStorage, $sitePageData);
                        }
                    }
                }

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
