<?php defined('SYSPATH') or die('No direct script access.');

class Api_Tax_Shop_Tax_Return_910  {

    /**
     * Сохранение данных для посчета формы 910.00
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @throws HTTP_Exception_500
     */
    public static function sendTax(SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        $id = Request_RequestParams::getParamInt('id');

        $model = new Model_Tax_Shop_Tax_Return_910();
        $model->setDBDriver($driver);

        if (!Helpers_DB::dublicateObjectLanguage($model, $id, $sitePageData, $sitePageData->shopID, FALSE)) {
            throw new HTTP_Exception_500('Tax return 910 not found.');
        }

        if ($model->getTaxStatusID() == 0){
            $model->setTaxStatusID(Model_Tax_Status::TAX_STATUS_START);
            Helpers_DB::saveDBObject($model, $sitePageData);

            return TRUE;
        }
        return FALSE;
    }

    /**
     * Сохранение 910 формы в PDF
     * @param $id
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @param $fileName
     * @param bool $isPHPOutput
     * @throws HTTP_Exception_404
     */
    public static function saveInPDF($id, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver, $fileName, $isPHPOutput = FALSE)
    {
        $model = new Model_Tax_Shop_Tax_Return_910();
        $model->setDBDriver($driver);
        if (! Helpers_DB::getDBObject($model, $id, $sitePageData)){
            throw new HTTP_Exception_404('910 not found!');
        }

        // до 2020 года
        if(($model->getYear() > 2015) && ($model->getYear() < 2020)) {
            Api_Tax_Shop_Tax_Return_910_001::saveInPDF($model, $sitePageData, $fileName, $isPHPOutput);
        }

    }

    /**
     * Сохранение данных для посчета формы 910.00
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @throws HTTP_Exception_500
     */
    public static function saveData(SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {

        $halfYear = Request_RequestParams::getParamInt('half_year');
        $year = Request_RequestParams::getParamInt('year');

        // до 2020 года
        if(($year > 2015) && ($year < 2020)) {
            return Api_Tax_Shop_Tax_Return_910_001::saveData($halfYear, $year, $sitePageData, $driver);
        }
    }

    /**
     * Сохранение формы 910.00
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @throws HTTP_Exception_500
     */
    public static function save(SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        $model = new Model_Tax_Shop_Tax_Return_910();
        $model->setDBDriver($driver);

        $id = Request_RequestParams::getParamInt('id');
        if($id > 0) {
            if (!Helpers_DB::dublicateObjectLanguage($model, $id, $sitePageData)) {
                throw new HTTP_Exception_500('Tax return 910 not found.');
            }
        }

        Request_RequestParams::setParamBoolean('is_public', $model);
        Request_RequestParams::setParamStr('text', $model);
        Request_RequestParams::setParamStr('name', $model);
        Request_RequestParams::setParamBoolean("is_public", $model);
        Request_RequestParams::setParamStr("old_id", $model);

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
}
