<?php defined('SYSPATH') or die('No direct script access.');

class Api_Magazine_Shop_Branch  {

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

        $model = new Model_Shop();
        $model->setDBDriver($driver);

        if (!Helpers_DB::dublicateObjectLanguage($model, $id, $sitePageData, $sitePageData->shopMainID)) {
            throw new HTTP_Exception_500('Branch not found.');
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
        $model = new Model_Shop();
        $model->setDBDriver($driver);

        $id = Request_RequestParams::getParamInt('id');
        if($id > 0) {
            if (!Helpers_DB::dublicateObjectLanguage($model, $id, $sitePageData, $sitePageData->shopMainID)) {
                throw new HTTP_Exception_500('Branch not found.');
            }
        }

        Request_RequestParams::setParamBoolean('is_public', $model);
        Request_RequestParams::setParamStr('text', $model);
        Request_RequestParams::setParamStr("old_id", $model);
        Request_RequestParams::setParamStr('name', $model);

        $options = Request_RequestParams::getParamArray('options');
        if ($options !== NULL) {
            $model->addOptionsArray($options);
        }

        $result = array();
        if ($model->validationFields($result)) {
            if($model->id < 1) {
                $model->setMainShopID($sitePageData->shopMainID);
                Helpers_DB::saveDBObject($model, $sitePageData, $sitePageData->shopMainID);
            }

            // добавляем администратора филиала
            $shopOperation = Request_RequestParams::getParamArray('shop_operation');
            if($shopOperation !== NULL){
                $email = Arr::path($shopOperation, 'email', '');
                $password = Arr::path($shopOperation, 'password', '');

                $options = $model->getOptionsArray();

                $modelOperation = new Model_Shop_Operation();
                $modelOperation->setDBDriver($driver);
                $operationID = Arr::path($options, 'shop_operation.id', 0);
                if($operationID > 0){
                    Helpers_DB::getDBObject($modelOperation, $operationID, $sitePageData, $model->id);
                }

                if(!empty($email)){
                    $modelOperation->setEMail($email);
                    $options['shop_operation']['email'] = $email;
                }
                if(!empty($password)){
                    $modelOperation->setPassword(Auth::instance()->hashPassword($email));
                }

                if(($modelOperation->id > 0) || (!Func::_empty($modelOperation->getEMail()))){
                    if(!Api_Shop_Operation::isOneEMail(
                        $modelOperation->getEMail(), $sitePageData, $driver, $modelOperation->id
                    )){
                        throw new HTTP_Exception_500('E-mail there is database.');
                    }

                    // меняем данные основного пользователя
                    Api_Shop_Operation::editUserOperation($modelOperation, $sitePageData, $driver);
                    $options['shop_operation']['id'] = Helpers_DB::saveDBObject($modelOperation, $sitePageData, $model->id);
                    $model->setOptionsArray($options);
                }
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
