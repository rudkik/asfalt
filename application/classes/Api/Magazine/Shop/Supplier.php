<?php defined('SYSPATH') or die('No direct script access.');

class Api_Magazine_Shop_Supplier  {

    /**
     * удаление
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

        $model = new Model_Magazine_Shop_Supplier();
        $model->setDBDriver($driver);

        if (!Helpers_DB::dublicateObjectLanguage($model, $id, $sitePageData, $sitePageData->shopMainID)) {
            throw new HTTP_Exception_500('Supplier not found.');
        }

        if(Request_RequestParams::getParamBoolean("is_undel") === TRUE){
            $model->dbUnDelete($sitePageData->userID, 0, $sitePageData->shopMainID);
        }else {
            $model->dbDelete($sitePageData->userID, 0, $sitePageData->shopMainID);
        }

        return TRUE;
    }

    /**
     * Сохранение
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @return array
     * @throws HTTP_Exception_500
     */
    public static function save(SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        $model = new Model_Magazine_Shop_Supplier();
        $model->setDBDriver($driver);

        $id = Request_RequestParams::getParamInt('id');
        if($id > 0) {
            if (!Helpers_DB::dublicateObjectLanguage($model, $id, $sitePageData, $sitePageData->shopMainID)) {
                throw new HTTP_Exception_500('Supplier not found.');
            }
        }

        Request_RequestParams::setParamInt("organization_type_id", $model);
        Request_RequestParams::setParamInt("shop_table_rubric_id", $model);
        Request_RequestParams::setParamBoolean('is_public', $model);
        Request_RequestParams::setParamStr('text', $model);
        Request_RequestParams::setParamStr("old_id", $model);

        Request_RequestParams::setParamStr('bin', $model);
        Request_RequestParams::setParamStr('address', $model);
        Request_RequestParams::setParamStr('account', $model);
        Request_RequestParams::setParamStr('bank', $model);
        Request_RequestParams::setParamStr('bik', $model);
        Request_RequestParams::setParamStr('contract', $model);
        Request_RequestParams::setParamBoolean('is_nds', $model);

        Request_RequestParams::setParamInt("shop_client_id", $model);

        Request_RequestParams::setParamStr('name', $model);
        Request_RequestParams::setParamStr('name_1c', $model);
        $model->setNames($model->getName());

        if(Func::_empty($model->getOldID())){
            $n = Database::instance()->query(Database::SELECT, 'SELECT nextval(\'sp_number_supplier\') as id;')->as_array(NULL, 'id')[0];
            $n = '000000'.$n;
            $n = 'Т'.substr($n, strlen($n) - 7);
            $model->setOldID($n);
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
