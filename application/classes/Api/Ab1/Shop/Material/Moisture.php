<?php defined('SYSPATH') or die('No direct script access.');

class Api_Ab1_Shop_Material_Moisture  {

    /**
     * Сохранение
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @return array
     * @throws HTTP_Exception_500
     */
    public static function save(SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        $model = new Model_Ab1_Shop_Material_Moisture();
        $model->setDBDriver($driver);

        $id = Request_RequestParams::getParamInt('id');
        if($id > 0) {
            if (!Helpers_DB::dublicateObjectLanguage($model, $id, $sitePageData, $sitePageData->shopMainID)) {
                throw new HTTP_Exception_500('Material moisture not found.');
            }
        }

        Request_RequestParams::setParamInt("shop_raw_id", $model);
        Request_RequestParams::setParamInt("shop_material_id", $model);
        Request_RequestParams::setParamBoolean('is_public', $model);
        Request_RequestParams::setParamFloat('moisture', $model);
        Request_RequestParams::setParamFloat('density', $model);
        Request_RequestParams::setParamFloat('quantity', $model);
        Request_RequestParams::setParamDate('date', $model);
        Request_RequestParams::setParamInt("shop_daughter_id", $model);
        Request_RequestParams::setParamInt("shop_branch_daughter_id", $model);

        $options = Request_RequestParams::getParamArray('options');
        if ($options !== NULL) {
            $model->addOptionsArray($options);
        }

        $result = array();
        if ($model->validationFields($result)) {
            if($model->id < 1) {
                Helpers_DB::saveDBObject($model, $sitePageData, $sitePageData->shopMainID);
            }

            if($model->getShopMaterialID() > 0){
                $quantity = Api_Ab1_Shop_Car_To_Material::calcImportQuantity(
                    $model->getDate().' 06:00:00', Helpers_DateTime::plusDays($model->getDate().' 06:00:00', 1),
                    $model->getShopBranchDaughterID(), $model->getShopDaughterID(), $model->getShopMaterialID(),
                    $sitePageData, $driver
                );
            }elseif($model->getShopRawID() > 0){
                $quantity = Api_Ab1_Shop_Raw_Material::calcImportQuantity(
                    $model->getDate(), Helpers_DateTime::plusDays($model->getDate(), 1),
                    $model->getShopBranchDaughterID(), $model->getShopRawID(),
                    $sitePageData, $driver
                );
            }else{
                $quantity = 0;
            }

            $model->setQuantity($quantity);


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
