<?php defined('SYSPATH') or die('No direct script access.');

class Api_Shop_Question  {

    /**
     * Сохранение списка товаров
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     */
    public static function saveListCollations($shopTableCatalogID, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        $model = new Model_Shop_Question();
        $model->setDBDriver($driver);

        $shopQuestions = Request_RequestParams::getParamArray('data', array());
        foreach ($shopQuestions as &$shopQuestion) {
            $model->clear();

            $id = intval(Arr::path($shopQuestion, 'shop_question_id', 0));
            if ($id > 0) {
                if (!Helpers_DB::dublicateObjectLanguage($model, $id, $sitePageData, $sitePageData->shopID)) {
                    continue;
                }
            } else {
                $model->setShopTableCatalogID($shopTableCatalogID);
            }

            if($id < 1) {
                if (key_exists('is_public', $shopQuestion)) {
                    $model->setIsPublic($shopQuestion['is_public']);
                }
                if (key_exists('collations', $shopQuestion)) {
                    $model->addCollationsArray($shopQuestion['collations']);
                }
                if (key_exists('old_id', $shopQuestion)) {
                    $model->setOldID($shopQuestion['old_id']);
                }
                if (key_exists('answer_text', $shopQuestion)) {
                    $model->setAnswerText($shopQuestion['answer_text']);
                }
                if (key_exists('name', $shopQuestion)) {
                    if (!empty($shopQuestion['name'])) {
                        $model->setName($shopQuestion['name']);
                    }
                }
                if (key_exists('answer_at', $shopQuestion)) {
                    $model->setAnswerAt($shopQuestion['answer_at']);
                }
                if (key_exists('text', $shopQuestion)) {
                    $model->setText($shopQuestion['text']);
                }
            }

            $options = array();
            foreach($shopQuestion as $k => $v){
                if(strpos($k, 'options.') === 0){
                    $options[str_replace('options.', '', $k)] = $v;
                }
            }
            $model->addOptionsArray($options, FALSE);

            if (key_exists('user_name', $shopQuestion)) {
                $model->setUserName($shopQuestion['user_name']);
            }

            $shopQuestion['shop_question_id'] = Helpers_DB::saveDBObject($model, $sitePageData, $sitePageData->shopID);
            $shopQuestion['shop_question_name'] = $model->getName();
        }

        return $shopQuestions;
    }

    /**
     * Сохранение списка товаров
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     */
    public static function saveList(SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        $model = new Model_Shop_Question();
        $model->setDBDriver($driver);

        $shopQuestions = Request_RequestParams::getParamArray('shop_questions', array());
        if ($shopQuestions === NULL) {
            return FALSE;
        }

        foreach ($shopQuestions as $id => $shopQuestion) {
            $id = intval($id);
            if ($id > 0) {
                if (!Helpers_DB::dublicateObjectLanguage($model, $id, $sitePageData, $sitePageData->shopID)) {
                    continue;
                }

                if (key_exists('is_public', $shopQuestion)) {
                    $model->setIsPublic($shopQuestion['is_public']);
                }
                if (key_exists('name', $shopQuestion)) {
                    if (!empty($shopQuestion['name'])) {
                        $model->setName($shopQuestion['name']);
                    }
                }

                if (key_exists('text', $shopQuestion)) {
                    $model->setText($shopQuestion['text']);
                }

                if (key_exists('answer_text', $shopQuestion)) {
                    $model->setAnswerText($shopQuestion['answer_text']);
                }

                if (key_exists('remarketing', $shopQuestion)) {
                    $model->setRemarketing($shopQuestion['remarketing']);
                }

                if (key_exists('shop_table_rubric_id', $shopQuestion)) {
                    $model->setShopTableRubricID($shopQuestion['shop_table_rubric_id']);
                }

                if (key_exists('answer_at', $shopQuestion)) {
                    $model->setAnswerAt($shopQuestion['answer_at']);
                }

                if (key_exists('user_name', $shopQuestion)) {
                    $model->setUserName($shopQuestion['user_name']);
                }

                if (key_exists('options', $shopQuestion)) {
                    $options = $shopQuestion['options'];
                    if (is_array($options)) {
                        $model->addOptionsArray($options);
                    }
                }
                if (key_exists('collations', $shopQuestion)) {
                    $options = $shopQuestion['collations'];
                    if (!is_array($options)) {
                        $options = explode("\r\n", $options);
                    }
                    $model->addCollationsArray($options);
                }

                Helpers_DB::saveDBObject($model, $sitePageData, $sitePageData->shopID);
            }
        }
    }

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

        $model = new Model_Shop_Question();
        $model->setDBDriver($driver);

        if (!Helpers_DB::dublicateObjectLanguage($model, $id, $sitePageData)) {
            throw new HTTP_Exception_500('Question not found.');
        }

        if(Request_RequestParams::getParamBoolean("is_undel") === TRUE){
            $model->dbUnDelete($sitePageData->userID, 0, $sitePageData->shopID);
        }else {
            $model->dbDelete($sitePageData->userID, 0, $sitePageData->shopID);
        }
    }

    /**
     * Сохранение товары
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @throws HTTP_Exception_500
     */
    public static function save(SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        $model = new Model_Shop_Question();
        $model->setDBDriver($driver);

        $id = Request_RequestParams::getParamInt('id');
        if($id > 0) {
            if (!Helpers_DB::dublicateObjectLanguage($model, $id, $sitePageData)) {
                throw new HTTP_Exception_500('Question not found.');
            }

            $type = $model->getShopTableCatalogID();
        }else{
            $type = Request_RequestParams::getParamInt('type');
            $model->setShopTableCatalogID($type);
        }

        Request_RequestParams::setParamInt("shop_table_rubric_id", $model);
        Request_RequestParams::setParamBoolean('is_public', $model);
        Request_RequestParams::setParamStr('text', $model);
        Request_RequestParams::setParamStr('name', $model);
        Request_RequestParams::setParamBoolean("is_public", $model);
        Request_RequestParams::setParamStr("answer_text", $model);
        Request_RequestParams::setParamStr("answer_user_name", $model);
        Request_RequestParams::setParamStr("url", $model);
        Request_RequestParams::setParamDateTime("answer_at", $model);
        Request_RequestParams::setParamInt("order", $model);
        Request_RequestParams::setParamStr("old_id", $model);
        Request_RequestParams::setParamStr('remarketing', $model);
        Request_RequestParams::setParamInt("shop_table_select_id", $model);
        Request_RequestParams::setParamInt("shop_table_unit_id", $model);
        Request_RequestParams::setParamInt("shop_table_brand_id", $model);
        Request_RequestParams::setParamStr('email', $model);
        Request_RequestParams::setParamDateTime("created_at", $model);
        Request_RequestParams::setParamDateTime("answer_at", $model);

        $options = Request_RequestParams::getParamArray('options');
        if ($options !== NULL) {
            $model->addOptionsArray($options);
        }

        $seo = Request_RequestParams::getParamArray('seo');
        if ($seo !== NULL) {
            $model->setSEOArray($seo);
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
                        Model_Shop_Question::TABLE_ID, $model->id, $model->getShopTableCatalogID(),
                        $filters, $modelType->getChildShopTableCatalogID('filter', $sitePageData->dataLanguageID),
                        $sitePageData, $driver));
                }

                // сохраняем список хэштегов
                $hashtags = Request_RequestParams::getParamArray('shop_table_hashtags');
                if ($hashtags !== NULL) {
                    $model->setShopTableHashtagIDsArray(Api_Shop_Table_ObjectToObject::saveToHashtags(
                        Model_Shop_Question::TABLE_ID, $model->id, $model->getShopTableCatalogID(),
                        $hashtags, $modelType->getChildShopTableCatalogID('hashtag', $sitePageData->dataLanguageID),
                        $sitePageData, $driver));
                }
            }

            // сохраняем группу товаров
            $groups = Request_RequestParams::getParamArray('shop_table_groups');
            if ($groups !== NULL) {
                $model->setShopTableGroupIDsArray(Api_Shop_Table_Group::saveList(
                    Model_Shop_Question::TABLE_ID, $model->id, $model->getShopTableCatalogID(),
                    $groups, $sitePageData, $driver));
            }

            // подобные товары
            $similars = Request_RequestParams::getParamArray('shop_table_similars');
            if($similars !== NULL){
                $model->setShopTableSimilarIDsArray(Api_Shop_Table_Similar::saveList(
                    Model_Shop_Question::TABLE_ID, $model->id, $model->getShopTableCatalogID(),
                    $similars, $sitePageData, $driver));
            }

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
