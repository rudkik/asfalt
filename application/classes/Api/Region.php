<?php defined('SYSPATH') or die('No direct script access.');

class Api_Region  {

    /**
     * Сохранение списка 
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     */
    public static function saveListCollations(SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        $model = new Model_Region();
        $model->setDBDriver($driver);

        $regions = Request_RequestParams::getParamArray('data', array());
        foreach ($regions as &$region) {
            $model->clear();

            $id = intval(Arr::path($region, 'region_id', 0));
            if ($id > 0) {
                if (!Helpers_DB::dublicateObjectLanguage($model, $id, $sitePageData, $sitePageData->shopID)) {
                    continue;
                }
            } 

            if($id < 1) {
                if (key_exists('is_public', $region)) {
                    $model->setIsPublic($region['is_public']);
                }
                if (key_exists('old_id', $region)) {
                    $model->setOldID($region['old_id']);
                }
                if (key_exists('name', $region)) {
                    if (!empty($region['name'])) {
                        $model->setName($region['name']);
                    }
                }
                if (key_exists('land_id', $region)) {
                    $model->setLandID($region['land_id']);
                }
                if (key_exists('text', $region)) {
                    $model->setText($region['text']);
                }
            }

            $region['region_id'] = Helpers_DB::saveDBObject($model, $sitePageData, $sitePageData->shopID);
            $region['region_name'] = $model->getName();
        }

        return $regions;
    }

    /**
     * Сохранение списка товаров
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     */
    public static function saveList(SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        $model = new Model_Region();
        $model->setDBDriver($driver);

        $regions = Request_RequestParams::getParamArray('regions', array());
        if ($regions === NULL) {
            return FALSE;
        }

        foreach ($regions as $id => $region) {
            $id = intval($id);
            if ($id > 0) {
                if (!Helpers_DB::dublicateObjectLanguage($model, $id, $sitePageData, $sitePageData->shopID)) {
                    continue;
                }

                if (key_exists('is_public', $region)) {
                    $model->setIsPublic($region['is_public']);
                }
                if (key_exists('name', $region)) {
                    if (!empty($region['name'])) {
                        $model->setName($region['name']);
                    }
                }

                if (key_exists('text', $region)) {
                    $model->setText($region['text']);
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
        $model = new Model_Region();
        $model->setDBDriver($driver);

        $id = Request_RequestParams::getParamInt('id');
        if($id > 0) {
            if (!Helpers_DB::dublicateObjectLanguage($model, $id, $sitePageData)) {
                throw new HTTP_Exception_500('Region not found.');
            }
        }

        Request_RequestParams::setParamBoolean('is_public', $model);
        Request_RequestParams::setParamStr('text', $model);
        Request_RequestParams::setParamStr('name', $model);
        Request_RequestParams::setParamBoolean("is_public", $model);
        Request_RequestParams::setParamInt("order", $model);
        Request_RequestParams::setParamStr("old_id", $model);
        Request_RequestParams::setParamInt("land_id", $model);

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
