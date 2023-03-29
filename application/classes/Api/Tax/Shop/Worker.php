<?php defined('SYSPATH') or die('No direct script access.');

class Api_Tax_Shop_Worker  {

    /**
     * Сохранение товары
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @throws HTTP_Exception_500
     */
    public static function save(SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        $model = new Model_Tax_Shop_Worker();
        $model->setDBDriver($driver);

        $id = Request_RequestParams::getParamInt('id');
        if($id > 0) {
            if (!Helpers_DB::dublicateObjectLanguage($model, $id, $sitePageData)) {
                throw new HTTP_Exception_500('Worker not found.');
            }
        }

        Request_RequestParams::setParamBoolean('is_public', $model);
        Request_RequestParams::setParamStr('text', $model);
        Request_RequestParams::setParamStr('name', $model);
        Request_RequestParams::setParamStr("old_id", $model);

        Request_RequestParams::setParamStr('iin', $model);
        Request_RequestParams::setParamDateTime('date_of_birth', $model);

        Request_RequestParams::setParamStr('name_d', $model);
        Request_RequestParams::setParamStr('number', $model);
        Request_RequestParams::setParamDateTime('date_from', $model);
        Request_RequestParams::setParamStr('issued_by', $model);
        Request_RequestParams::setParamStr('position', $model);
        Request_RequestParams::setParamFloat('wage_basic', $model);
        Request_RequestParams::setParamDateTime('date_work_from', $model);
        Request_RequestParams::setParamDateTime('date_work_to', $model);
        Request_RequestParams::setParamInt('worker_status_id', $model);

        $options = Request_RequestParams::getParamArray('options');
        if ($options !== NULL) {
            $model->addOptionsArray($options);
        }

        $result = array();
        if ($model->validationFields($result)) {
            if($model->id < 1) {
                Helpers_DB::saveDBObject($model, $sitePageData);
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

    /**
     * Сохранение товары
     * @param array $data
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @return array
     * @throws HTTP_Exception_500
     */
    public static function saveOfArray(array $data, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        $model = new Model_Tax_Shop_Worker();
        $model->setDBDriver($driver);

        $id = intval(Arr::path($data, 'id', 0));
        if($id > 0) {
            if (!Helpers_DB::dublicateObjectLanguage($model, $id, $sitePageData)) {
                throw new HTTP_Exception_500('Worker not found.');
            }
        }

        if (key_exists('is_public', $data)) {
            $model->setIsPublic($data['is_public']);
        }
        if (key_exists('text', $data)) {
            $model->setText($data['text']);
        }
        if (key_exists('name', $data)) {
            $model->setName($data['name']);
        }
        if (key_exists('old_id', $data)) {
            $model->setOldID($data['old_id']);
        }

        if (key_exists('iin', $data)) {
            $model->setIIN($data['iin']);
        }
        if (key_exists('date_of_birth', $data)) {
            $model->setDateOfBirth($data['date_of_birth']);
        }
        if (key_exists('name_d', $data)) {
            $model->setNameD($data['name_d']);
        }
        if (key_exists('number', $data)) {
            $model->setNumber($data['number']);
        }
        if (key_exists('date_from', $data)) {
            $model->setDateFrom($data['date_from']);
        }
        if (key_exists('issued_by', $data)) {
            $model->setIssuedBy($data['issued_by']);
        }
        if (key_exists('position', $data)) {
            $model->setPosition($data['position']);
        }
        if (key_exists('date_work_from', $data)) {
            $model->setDateWorkFrom($data['date_work_from']);
        }
        if (key_exists('wage_basic', $data)) {
            $model->setWageBasic($data['wage_basic']);
        }

        if (key_exists('options', $data)) {
            $options = $data['options'];
            if (is_array($options)) {
                $model->addOptionsArray($options);
            }
        }

        $result = array();
        if ($model->validationFields($result)) {
            if($model->id < 1) {
                Helpers_DB::saveDBObject($model, $sitePageData);
            }

            Helpers_DB::saveDBObject($model, $sitePageData);
            $result['values'] = $model->getValues();
        }

        return array(
            'id' => $model->id,
            'result' => $result,
        );
    }
}
