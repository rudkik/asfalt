<?php defined('SYSPATH') or die('No direct script access.');

class Api_Shop_Operation  {

    /**
     * Проверяем, что данный e-mail не существует в базе данных
     * @param $email
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @param int $shopOperationID
     * @return bool
     */
    public static function isOneEMail($email, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver,
                                      $shopOperationID = -1){
        $params = Request_RequestParams::setParams(
            array(
                'id_not' => $shopOperationID,
                'email' => $email,
            )
        );
        $ids = Request_Request::findBranch('DB_Shop_Operation', array(), $sitePageData, $driver, $params, 1);
        return count($ids->childs) == 0;
    }

    /**
     * Меняем пользователя оператора
     * @param Model_Shop_Operation $model
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @return int|mixed
     * @throws HTTP_Exception_500
     */
    public static function editUserOperation(Model_Shop_Operation $model, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver){
        // меняем данные основного пользователя
        $modelUser = new Model_User();
        $modelUser->setDBDriver($driver);
        if($model->getUserID() > 0) {
            if (!Helpers_DB::dublicateObjectLanguage($modelUser, $model->getUserID(), $sitePageData)) {
                throw new HTTP_Exception_500('User not found.');
            }
        }

        $modelUser->setName($model->getName());
        $modelUser->setPassword($model->getPassword());
        $modelUser->setEMail($model->getEMail());
        $model->setUserID(Helpers_DB::saveDBObject($modelUser, $sitePageData));

        return $modelUser->id;
    }

    /**
     * Сохранение списка
     * @param $shopTableCatalogID
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @return mixed|null
     */
    public static function saveListCollations($shopTableCatalogID, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        $model = new Model_Shop_Operation();
        $model->setDBDriver($driver);

        $shopOperations = Request_RequestParams::getParamArray('data', array());
        foreach ($shopOperations as &$shopOperation) {
            $model->clear();

            $id = intval(Arr::path($shopOperation, 'shop_operation_id', 0));
            if ($id > 0) {
                if (!Helpers_DB::dublicateObjectLanguage($model, $id, $sitePageData, $sitePageData->shopID)) {
                    continue;
                }
            } else {
                $model->setShopTableCatalogID($shopTableCatalogID);
            }

            if($id < 1) {
                if (key_exists('is_public', $shopOperation)) {
                    $model->setIsPublic($shopOperation['is_public']);
                }
                if (key_exists('email', $shopOperation)) {
                    $model->setArticle($shopOperation['email']);
                }
                if (key_exists('name', $shopOperation)) {
                    if (!empty($shopOperation['name'])) {
                        $model->setName($shopOperation['name']);
                    }
                }
                if (key_exists('text', $shopOperation)) {
                    $model->setText($shopOperation['text']);
                }
            }

            $options = array();
            foreach($shopOperation as $k => $v){
                if(strpos($k, 'options.') === 0){
                    $options[str_replace('options.', '', $k)] = $v;
                }
            }
            $model->addOptionsArray($options, FALSE);

            if (key_exists('price', $shopOperation)) {
                $model->setPrice($shopOperation['price']);
            }

            $shopOperation['shop_operation_id'] = Helpers_DB::saveDBObject($model, $sitePageData, $sitePageData->shopID);
            $shopOperation['shop_operation_name'] = $model->getName();
        }

        return $shopOperations;
    }

    /**
     * Сохранение списка
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @return bool
     */
    public static function saveList(SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        $model = new Model_Shop_Operation();
        $model->setDBDriver($driver);

        $shopOperations = Request_RequestParams::getParamArray('shop_operations', array());
        if ($shopOperations === NULL) {
            return FALSE;
        }

        foreach ($shopOperations as $id => $shopOperation) {
            $id = intval($id);
            if ($id > 0) {
                if (!Helpers_DB::dublicateObjectLanguage($model, $id, $sitePageData, $sitePageData->shopID)) {
                    continue;
                }

                if (key_exists('is_public', $shopOperation)) {
                    $model->setIsPublic($shopOperation['is_public']);
                }
                if (key_exists('name', $shopOperation)) {
                    if (!empty($shopOperation['name'])) {
                        $model->setName($shopOperation['name']);
                    }
                }

                if (key_exists('text', $shopOperation)) {
                    $model->setText($shopOperation['text']);
                }

                if (key_exists('email', $shopOperation)) {
                    $model->setArticle($shopOperation['email']);
                }

                if (key_exists('shop_table_rubric_id', $shopOperation)) {
                    $model->setShopTableRubricID($shopOperation['shop_table_rubric_id']);
                }

                if (key_exists('options', $shopOperation)) {
                    $options = $shopOperation['options'];
                    if (is_array($options)) {
                        $model->addOptionsArray($options);
                    }
                }

                Helpers_DB::saveDBObject($model, $sitePageData, $sitePageData->shopID);
            }
        }
    }

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

        $model = new Model_Shop_Operation();
        $model->setDBDriver($driver);

        if (!Helpers_DB::dublicateObjectLanguage($model, $id, $sitePageData)) {
            throw new HTTP_Exception_500('Operation not found.');
        }

        if(Request_RequestParams::getParamBoolean("is_undel") === TRUE){
            $model->dbUnDelete($sitePageData->userID, 0, $sitePageData->shopID);
        }else {
            $model->dbDelete($sitePageData->userID, 0, $sitePageData->shopID);
        }
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
        $model = new Model_Ab1_Shop_Operation();
        $model->setDBDriver($driver);

        $id = Request_RequestParams::getParamInt('id');
        if($id > 0) {
            if (!Helpers_DB::dublicateObjectLanguage($model, $id, $sitePageData)) {
                throw new HTTP_Exception_500('Operation not found.');
            }

            $type = $model->getShopTableCatalogID();
        }else{
            $type = Request_RequestParams::getParamInt('type');
            $model->setShopTableCatalogID($type);
        }

        $tmp = Request_RequestParams::getParamStr('password');
        if (($tmp !== NULL) && (! empty($tmp))){
            $model->setPassword(Auth::instance()->hashPassword($tmp));
        }

        Request_RequestParams::setParamInt("shop_table_rubric_id", $model);
        Request_RequestParams::setParamInt("shop_cashbox_id", $model);
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

        $options = Request_RequestParams::getParamArray('options');
        if ($options !== NULL) {
            $model->addOptionsArray($options);
        }

        $ids = Request_RequestParams::getParamArray('product_shop_subdivision_ids');
        if ($ids !== NULL) {
            $model->setProductShopSubdivisionIDsArray($ids);
        }

        $ids = Request_RequestParams::getParamArray('shop_raw_rubric_ids');
        if ($ids !== NULL) {
            $model->setShopRawRubricIDsArray($ids);
        }

        $ids = Request_RequestParams::getParamArray('product_shop_storage_ids');
        if ($ids !== NULL) {
            $model->setProductShopStorageIDsArray($ids);
        }

        $access = Request_RequestParams::getParamArray('access');
        if ($access !== NULL) {
            $model->addAccessArray($access);
        }

        // меняем данные основного пользователя
        if(!self::isOneEMail($model->getEMail(), $sitePageData, $driver, $model->id)){
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

            if($type > 0) {
                $modelType = new Model_Shop_Table_Catalog();
                $modelType->setDBDriver($driver);
                Helpers_DB::dublicateObjectLanguage($modelType, $type, $sitePageData);

                // сохраняем список фильтров
                $filters = Request_RequestParams::getParamArray('shop_table_filters');
                if ($filters !== NULL) {
                    $model->setShopTableFilterIDsArray(Api_Shop_Table_ObjectToObject::saveToFilters(
                        Model_Shop_Operation::TABLE_ID, $model->id, $model->getShopTableCatalogID(),
                        $filters, $modelType->getChildShopTableCatalogID('filter', $sitePageData->dataLanguageID),
                        $sitePageData, $driver));
                }

                // сохраняем список хэштегов
                $hashtags = Request_RequestParams::getParamArray('shop_table_hashtags');
                if ($hashtags !== NULL) {
                    $model->setShopTableHashtagIDsArray(Api_Shop_Table_ObjectToObject::saveToHashtags(
                        Model_Shop_Operation::TABLE_ID, $model->id, $model->getShopTableCatalogID(),
                        $hashtags, $modelType->getChildShopTableCatalogID('hashtag', $sitePageData->dataLanguageID),
                        $sitePageData, $driver));
                }
            }

            // меняем данные основного пользователя
            self::editUserOperation($model, $sitePageData, $driver);

            Helpers_DB::saveDBObject($model, $sitePageData);
            $result['values'] = $model->getValues();

        }

        return array(
            'id' => $model->id,
            'type' => $type,
            'result' => $result,
        );
    }
}
