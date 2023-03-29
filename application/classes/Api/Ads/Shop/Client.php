<?php defined('SYSPATH') or die('No direct script access.');

class Api_Ads_Shop_Client  {

    /**
     * удаление клиента
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @param int $id
     * @return bool
     * @throws HTTP_Exception_500
     */
    public static function delete(SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver, $id = 0)
    {
        if ($id < 1) {
            $id = Request_RequestParams::getParamInt('id');
            if ($id < 0) {
                return FALSE;
            }
        }

        $model = new Model_Ads_Shop_Client();
        $model->setDBDriver($driver);

        if (!Helpers_DB::dublicateObjectLanguage($model, $id, $sitePageData)) {
            throw new HTTP_Exception_500('Client not found.');
        }

        $modelUser = new Model_User();
        $modelUser->setDBDriver($driver);
        Helpers_DB::dublicateObjectLanguage($modelUser, $model->getUserID(), $sitePageData);

        if(Request_RequestParams::getParamBoolean("is_undel") === TRUE){
            $model->dbUnDelete($sitePageData->userID, 0, $sitePageData->shopID);
            $modelUser->dbUnDelete($sitePageData->userID, 0, $sitePageData->shopID);
        }else {
            $model->dbDelete($sitePageData->userID, 0, $sitePageData->shopID);
            $modelUser->dbDelete($sitePageData->userID, 0, $sitePageData->shopID);
        }

        return TRUE;
    }

    /**
     * Сохранение данных авторизованного пользователя
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @return array
     * @throws HTTP_Exception_500
     */
    public static function saveAuthUser(SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        $model = new Model_Ads_Shop_Client();
        $model->setDBDriver($driver);

        $id = Request_Request::findOne('DB_Ads_Shop_Client', $sitePageData->userID, $sitePageData, $driver);
        if (!Helpers_DB::dublicateObjectLanguage($model, $id, $sitePageData, $sitePageData->shopID, FALSE)) {
            throw new HTTP_Exception_500('Client not found.');
        }

        Request_RequestParams::setParamStr('text', $model);
        Request_RequestParams::setParamStr('name', $model);

        Request_RequestParams::setParamStr('first_name', $model);
        Request_RequestParams::setParamStr('last_name', $model);
        Request_RequestParams::setParamStr('phone', $model);
        Request_RequestParams::setParamStr('email', $model);

        $addresses = Request_RequestParams::getParamArray('addresses');
        if ($addresses !== NULL){
            $modelLand = new Model_Land();
            $modelLand->setDBDriver($driver);

            $modelCity = new Model_City();
            $modelCity->setDBDriver($driver);

            foreach ($addresses as &$address){
                Helpers_DB::dublicateObjectLanguage($modelLand, Arr::path($address, 'land_id', 0), $sitePageData);
                $address['land_name'] = $modelLand->getName();

                Helpers_DB::dublicateObjectLanguage($modelCity, Arr::path($address, 'city_id', 0), $sitePageData);
                $address['city_name'] = $modelCity->getName();
            }

            $model->setAddressesArray($addresses);
        }

        $model->setName($model->getFirstName().' '.$model->getLastName());

        // загружаем фотографии
        $file = new Model_File($sitePageData);

        // загружаем дополнительные поля
        $options = Request_RequestParams::getParamArray('options');
        $files = Helpers_Image::getChildrenFILES('options');
        if ((!empty($files)) && ($options === NULL)){
            $options = array();
        }

        foreach ($files as $key => $child) {
            if ($child['error'] == 0) {
                $options[$key] = array(
                    'file' => $file->saveDownloadFilePath($child, $model->id, Model_Shop_Good::TABLE_ID, $sitePageData),
                    'name' => $child['name'],
                    'size' => $child['size'],
                );
            }
        }
        if ($options !== NULL) {
            $model->addOptionsArray($options);
        }

        $result = array();
        if ($model->validationFields($result)) {
            $password = Request_RequestParams::getParamStr('password');

            // загружаем фотографии
            $file = new Model_File($sitePageData);
            $file->saveFiles(Request_RequestParams::getParamArray('files'), $model, $sitePageData, $driver);


            $isFilled = (!Func::_empty($model->getPhone())) && (!Func::_empty($model->getFirstName()))
                && (!Func::_empty($model->getLastName())) && (!Func::_empty($model->getAddresses()))
                && (!Func::_empty(Arr::path($model->getOptionsArray(), 'file_passport_1', '')))
                && (!Func::_empty(Arr::path($model->getOptionsArray(), 'file_passport_2', '')));

            $modelUser = new Model_User();
            $modelUser->setDBDriver($driver);
            if (Helpers_DB::getDBObject($modelUser, $sitePageData->userID, $sitePageData)) {
                if (!empty($password)){
                    $modelUser->setPassword(Auth::instance()->hashPassword($password));
                }
                $modelUser->addOptionsArray(
                    array(
                        'is_filled' => $isFilled,
                        'is_load_passport' => FALSE,
                    )
                );
                $modelUser->setName($model->getName());
                $modelUser->setEMail($model->getEmail());
                Helpers_DB::saveDBObject($modelUser, $sitePageData);
            }

            Helpers_DB::saveDBObject($model, $sitePageData);
            $result['values'] = $model->getValues();
        }

        return array(
            'id' => $model->id,
            'is_filled' => $isFilled,
            'result' => $result,
        );
    }

    /**
     * Получение стоимости доставки клиента
     * @param $shopClientID
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @return float|int|mixed
     */
    public static function getPriceDelivery($shopClientID, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        $model = new Model_Ads_Shop_Client();
        $model->setDBDriver($driver);

        $result = 0;
        if (Helpers_DB::getDBObject($model, $shopClientID, $sitePageData)) {
            $result = $model->getDeliveryAmount();
        }

        if($result <= 0){
            $result = floatval(Arr::path($sitePageData->shop->getOptionsArray(), 'delivery_amount', 0));
        }

        return $result;
    }

    /**
     * Сохранение посылки
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @return array
     * @throws HTTP_Exception_500
     */
    public static function save(SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        $model = new Model_Ads_Shop_Client();
        $model->setDBDriver($driver);

        $id = Request_RequestParams::getParamInt('id');
        if($id > 0) {
            if (!Helpers_DB::dublicateObjectLanguage($model, $id, $sitePageData)) {
                throw new HTTP_Exception_500('Client not found.');
            }
        }

        Request_RequestParams::setParamBoolean('is_public', $model);
        Request_RequestParams::setParamStr('text', $model);
        Request_RequestParams::setParamStr('name', $model);
        Request_RequestParams::setParamStr('old_id', $model);

        Request_RequestParams::setParamStr('first_name', $model);
        Request_RequestParams::setParamStr('last_name', $model);
        Request_RequestParams::setParamInt('address_code', $model);
        Request_RequestParams::setParamStr('phone', $model);
        Request_RequestParams::setParamStr('email', $model);
        Request_RequestParams::setParamFloat('delivery_amount', $model);

        $model->setName($model->getFirstName().' '.$model->getLastName());

        $options = Request_RequestParams::getParamArray('options');
        if ($options !== NULL) {
            $model->addOptionsArray($options);
        }

        if(Func::_empty($model->getAddressCode())){
            $n = Database::instance()->query(Database::SELECT, 'SELECT nextval(\'address_code\') as id;')->as_array(NULL, 'id')[0];
            $model->setAddressCode($n);
        }

        $result = array();
        if ($model->validationFields($result)) {
            if($model->id < 1) {
                Helpers_DB::saveDBObject($model, $sitePageData);

                $modelUser = new Model_User();
                $modelUser->setDBDriver($driver);

                $modelUser->setName($model->getName());
                $modelUser->setEMail($model->getEmail());
                $modelUser->setPassword(Auth::instance()->hashPassword(Func::generatePassword()));

                $model->setUserID(Helpers_DB::saveDBObject($modelUser, $sitePageData));
            }else{
                $modelUser = new Model_User();
                $modelUser->setDBDriver($driver);
                if (Helpers_DB::getDBObject($modelUser, $id, $sitePageData)) {
                    $modelUser->setName($model->getName());
                    $modelUser->setEMail($model->getEmail());
                    Helpers_DB::saveDBObject($modelUser, $sitePageData);
                }
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
