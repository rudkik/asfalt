<?php defined('SYSPATH') or die('No direct script access.');

class Api_AutoPart_Shop_Operation  {

    /**
     * Сохранение
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @return array
     * @throws HTTP_Exception_500
     */
    public static function save(SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        $model = new Model_AutoPart_Shop_Operation();
        $model->setDBDriver($driver);

        $id = Request_RequestParams::getParamInt('id');
        if($id > 0) {
            if (!Helpers_DB::dublicateObjectLanguage($model, $id, $sitePageData)) {
                throw new HTTP_Exception_500('Operation not found.');
            }
        }

        $tmp = Request_RequestParams::getParamStr('password');
        if (($tmp !== NULL) && (! empty($tmp))){
            $model->setPassword(Auth::instance()->hashPassword($tmp));
        }

        Request_RequestParams::setParamInt("shop_table_rubric_id", $model);
        Request_RequestParams::setParamStr('text', $model);
        Request_RequestParams::setParamStr('name', $model);
        Request_RequestParams::setParamBoolean("is_public", $model);
        Request_RequestParams::setParamBoolean("is_admin", $model);
        Request_RequestParams::setParamStr("email", $model);
        Request_RequestParams::setParamInt("order", $model);
        Request_RequestParams::setParamInt("shop_table_select_id", $model);
        Request_RequestParams::setParamInt("shop_table_unit_id", $model);
        Request_RequestParams::setParamInt("shop_table_brand_id", $model);
        Request_RequestParams::setParamInt("shop_department_id", $model);
        Request_RequestParams::setParamInt("operation_type_id", $model);
        Request_RequestParams::setParamInt("shop_worker_id", $model);
        Request_RequestParams::setParamInt("shop_worker_passage_id", $model);
        Request_RequestParams::setParamInt("shop_subdivision_id", $model);
        Request_RequestParams::setParamInt("shop_raw_rubric_id", $model);
        Request_RequestParams::setParamInt("shop_raw_storage_type_id", $model);
        Request_RequestParams::setParamInt("shop_position_id", $model);
        Request_RequestParams::setParamInt("shop_courier_id", $model);

        $options = Request_RequestParams::getParamArray('options');
        if ($options !== NULL) {
            $model->addOptionsArray($options);
        }

        $access = Request_RequestParams::getParamArray('access');
        if ($access !== NULL) {
            $model->addAccessArray($access);
        }

        // меняем данные основного пользователя
        if(!Api_Shop_Operation::isOneEMail($model->getEMail(), $sitePageData, $driver, $model->id)){
            throw new HTTP_Exception_500('E-mail there is database.');
        }

        $result = array();
        if ($model->validationFields($result)) {
            if($model->id < 1) {
                Helpers_DB::saveDBObject($model, $sitePageData);
            }

            // загружаем фотографии
            $file = new Model_File($sitePageData);
            $file->saveFiles(Request_RequestParams::getParamArray('files'), $model, $sitePageData, $driver);

            // меняем данные основного пользователя
            Api_Shop_Operation::editUserOperation($model, $sitePageData, $driver);

            Helpers_DB::saveDBObject($model, $sitePageData);
            $result['values'] = $model->getValues();
        }

        return array(
            'id' => $model->id,
            'result' => $result,
        );
    }
}
