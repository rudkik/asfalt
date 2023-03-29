<?php defined('SYSPATH') or die('No direct script access.');

class Api_Ab1_Shop_Material  {
    /**
     * удаление товара
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

        $model = new Model_Ab1_Shop_Material();
        $model->setDBDriver($driver);

        if (!Helpers_DB::dublicateObjectLanguage($model, $id, $sitePageData, $sitePageData->shopMainID)) {
            throw new HTTP_Exception_500('Material not found.');
        }

        if(Request_RequestParams::getParamBoolean("is_undel") === TRUE){
            $model->dbUnDelete($sitePageData->userID, 0, $sitePageData->shopMainID);
        }else {
            $model->dbDelete($sitePageData->userID, 0, $sitePageData->shopMainID);
        }
    }


    /**
     * Сохранение товары
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @return array
     * @throws HTTP_Exception_500
     */
    public static function save(SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        $model = new Model_Ab1_Shop_Material();
        $model->setDBDriver($driver);

        $id = Request_RequestParams::getParamInt('id');
        if($id > 0) {
            if (!Helpers_DB::dublicateObjectLanguage($model, $id, $sitePageData, $sitePageData->shopMainID)) {
                throw new HTTP_Exception_500('Material not found.');
            }
        }

        Request_RequestParams::setParamInt("shop_material_rubric_id", $model);
        Request_RequestParams::setParamInt("shop_material_rubric_make_id", $model);
        Request_RequestParams::setParamBoolean('is_public', $model);
        Request_RequestParams::setParamStr('text', $model);
        Request_RequestParams::setParamStr('name', $model);
        Request_RequestParams::setParamStr("old_id", $model);
        Request_RequestParams::setParamBoolean('is_weighted', $model);
        Request_RequestParams::setParamBoolean('is_moisture_and_density', $model);

        Request_RequestParams::setParamStr('name_1c', $model);
        Request_RequestParams::setParamStr('name_site', $model);
        Request_RequestParams::setParamFloat('price', $model);
        Request_RequestParams::setParamStr('unit', $model);
        Request_RequestParams::setParamStr('unit_recipe', $model);
        Request_RequestParams::setParamFloat('coefficient_recipe', $model);

        // название
        if(empty($model->getName()) || empty($model->getNameSite()) || empty($model->getName1C())){
            if(!empty($model->getName())){
                $name = $model->getName();
            }elseif(!empty($model->getName1C())){
                $name = $model->getName1C();
            }elseif(!empty($model->getNameSite())){
                $name = $model->getNameSite();
            }else{
                $name = '';
            }

            if(empty($model->getName())){
                $model->setName($name);
            }
            if(empty($model->getNameSite())){
                $model->setNameSite($name);
            }
            if(empty($model->getName1C())){
                $model->setName1C($name);
            }
        }

        $formulaTypeIDs = Request_RequestParams::getParamArray('formula_type_ids');
        if ($formulaTypeIDs !== NULL) {
            $model->setFormulaTypeIDsArray($formulaTypeIDs);
        }

        $formulaTypeIDs = Request_RequestParams::getParamArray('access_formula_type_ids');
        if ($formulaTypeIDs !== NULL) {
            $model->setAccessFormulaTypeIDsArray($formulaTypeIDs);
        }

        $options = Request_RequestParams::getParamArray('options');
        if ($options !== NULL) {
            $model->addOptionsArray($options);
        }

        $result = array();
        if ($model->validationFields($result)) {
            if($model->id < 1) {
                Helpers_DB::saveDBObject($model, $sitePageData, $sitePageData->shopMainID);
            }

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
