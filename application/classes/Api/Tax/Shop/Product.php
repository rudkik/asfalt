<?php defined('SYSPATH') or die('No direct script access.');

class Api_Tax_Shop_Product  {

    /**
     * Сохранение товары
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @throws HTTP_Exception_500
     */
    public static function save(SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        $model = new Model_Tax_Shop_Product();
        $model->setDBDriver($driver);

        $id = Request_RequestParams::getParamInt('id');
        if($id > 0) {
            if (!Helpers_DB::dublicateObjectLanguage($model, $id, $sitePageData)) {
                throw new HTTP_Exception_500('Product not found.');
            }
        }

        Request_RequestParams::setParamBoolean('is_public', $model);
        Request_RequestParams::setParamStr('text', $model);
        Request_RequestParams::setParamStr('name', $model);
        Request_RequestParams::setParamStr("old_id", $model);
        Request_RequestParams::setParamBoolean('is_service', $model);
        Request_RequestParams::setParamFloat('price', $model);

        // получаем единицу измерения
        $unit = Request_RequestParams::getParamStr('unit_name');
        if (!empty($unit)) {
            $params['name_full'] = $unit;
            $unitID = Request_Tax_Unit::find($sitePageData, $driver, $params, 1);
            if (count($unitID->childs) == 1) {
                $unitID = $unitID->childs[0]->id;
            } else {
                $unitID = 0;
            }

            $model->setUnitName($unit);
            $model->setUnitID($unitID);
        }

        $options = Request_RequestParams::getParamArray('options');
        if ($options !== NULL) {
            $model->addOptionsArray($options);
        }

        $result = array();
        if ($model->validationFields($result)) {
            if($model->id < 1) {
                Helpers_DB::saveDBObject($model, $sitePageData);
            }

            if(Func::_empty($model->getNumber())){
                $model->setNumber(Api_Tax_Sequence::getSequence($model->tableName,
                    0, $sitePageData, $driver));
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
