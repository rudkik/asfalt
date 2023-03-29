<?php defined('SYSPATH') or die('No direct script access.');

class Api_City  {

    /**
     * Сохранение списка 
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     */
    public static function saveListCollations(SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        $model = new Model_City();
        $model->setDBDriver($driver);

        $cities = Request_RequestParams::getParamArray('data', array());
        foreach ($cities as &$city) {
            $model->clear();

            $id = intval(Arr::path($city, 'city_id', 0));
            if ($id > 0) {
                if (!Helpers_DB::dublicateObjectLanguage($model, $id, $sitePageData, $sitePageData->shopID)) {
                    continue;
                }
            } 

            if($id < 1) {
                if (key_exists('is_public', $city)) {
                    $model->setIsPublic($city['is_public']);
                }
                if (key_exists('old_id', $city)) {
                    $model->setOldID($city['old_id']);
                }
                if (key_exists('name', $city)) {
                    if (!empty($city['name'])) {
                        $model->setName($city['name']);
                    }
                }
                if (key_exists('land_id', $city)) {
                    $model->setLandID($city['land_id']);
                }
                if (key_exists('region_id', $city)) {
                    $model->setLandID($city['region_id']);
                }
                if (key_exists('text', $city)) {
                    $model->setText($city['text']);
                }
            }

            $city['city_id'] = Helpers_DB::saveDBObject($model, $sitePageData, $sitePageData->shopID);
            $city['city_name'] = $model->getName();
        }

        return $cities;
    }

    /**
     * Сохранение списка товаров
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     */
    public static function saveList(SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        $model = new Model_City();
        $model->setDBDriver($driver);

        $cities = Request_RequestParams::getParamArray('cities', array());
        if ($cities === NULL) {
            return FALSE;
        }

        foreach ($cities as $id => $city) {
            $id = intval($id);
            if ($id > 0) {
                if (!Helpers_DB::dublicateObjectLanguage($model, $id, $sitePageData, $sitePageData->shopID)) {
                    continue;
                }

                if (key_exists('is_public', $city)) {
                    $model->setIsPublic($city['is_public']);
                }
                if (key_exists('name', $city)) {
                    if (!empty($city['name'])) {
                        $model->setName($city['name']);
                    }
                }

                if (key_exists('text', $city)) {
                    $model->setText($city['text']);
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
        $model = new Model_City();
        $model->setDBDriver($driver);

        $id = Request_RequestParams::getParamInt('id');
        if($id > 0) {
            if (!Helpers_DB::dublicateObjectLanguage($model, $id, $sitePageData)) {
                throw new HTTP_Exception_500('City not found.');
            }
        }

        Request_RequestParams::setParamBoolean('is_public', $model);
        Request_RequestParams::setParamStr('text', $model);
        Request_RequestParams::setParamStr('name', $model);
        Request_RequestParams::setParamBoolean("is_public", $model);
        Request_RequestParams::setParamInt("order", $model);
        Request_RequestParams::setParamStr("old_id", $model);
        Request_RequestParams::setParamInt("land_id", $model);
        Request_RequestParams::setParamInt("region_id", $model);

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
