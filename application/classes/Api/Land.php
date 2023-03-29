<?php defined('SYSPATH') or die('No direct script access.');

class Api_Land  {

    /**
     * Сохранение списка
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @return mixed|null
     */
    public static function saveListCollations(SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        $model = new Model_Land();
        $model->setDBDriver($driver);

        $lands = Request_RequestParams::getParamArray('data', array());
        foreach ($lands as &$land) {
            $model->clear();

            $id = intval(Arr::path($land, 'land_id', 0));
            if ($id > 0) {
                if (!Helpers_DB::dublicateObjectLanguage($model, $id, $sitePageData, $sitePageData->shopID)) {
                    continue;
                }
            } 

            if($id < 1) {
                if (key_exists('is_public', $land)) {
                    $model->setIsPublic($land['is_public']);
                }
                if (key_exists('old_id', $land)) {
                    $model->setOldID($land['old_id']);
                }
                if (key_exists('name', $land)) {
                    if (!empty($land['name'])) {
                        $model->setName($land['name']);
                    }
                }
                if (key_exists('text', $land)) {
                    $model->setText($land['text']);
                }
            }

            $land['land_id'] = Helpers_DB::saveDBObject($model, $sitePageData, $sitePageData->shopID);
            $land['land_name'] = $model->getName();
        }

        return $lands;
    }

    /**
     * Сохранение списка товаров
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     */
    public static function saveList(SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        $model = new Model_Land();
        $model->setDBDriver($driver);

        $lands = Request_RequestParams::getParamArray('lands', array());
        if ($lands === NULL) {
            return FALSE;
        }

        foreach ($lands as $id => $land) {
            $id = intval($id);
            if ($id > 0) {
                if (!Helpers_DB::dublicateObjectLanguage($model, $id, $sitePageData, $sitePageData->shopID)) {
                    continue;
                }

                if (key_exists('is_public', $land)) {
                    $model->setIsPublic($land['is_public']);
                }
                if (key_exists('name', $land)) {
                    if (!empty($land['name'])) {
                        $model->setName($land['name']);
                    }
                }

                if (key_exists('text', $land)) {
                    $model->setText($land['text']);
                }

                Helpers_DB::saveDBObject($model, $sitePageData, $sitePageData->shopID);
            }
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
        $model = new Model_Land();
        $model->setDBDriver($driver);

        $id = Request_RequestParams::getParamInt('id');
        if($id > 0) {
            if (!Helpers_DB::dublicateObjectLanguage($model, $id, $sitePageData)) {
                throw new HTTP_Exception_500('Land not found.');
            }
        }

        Request_RequestParams::setParamBoolean('is_public', $model);
        Request_RequestParams::setParamStr('text', $model);
        Request_RequestParams::setParamStr('name', $model);
        Request_RequestParams::setParamBoolean("is_public", $model);
        Request_RequestParams::setParamInt("order", $model);
        Request_RequestParams::setParamStr("old_id", $model);

        $result = array();
        if ($model->validationFields($result)) {
            Helpers_DB::saveDBObject($model, $sitePageData);
            $result['values'] = $model->getValues();
        }

        return array(
            'id' => $model->id,
            'result' => $result,
        );
    }


}
