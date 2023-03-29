<?php defined('SYSPATH') or die('No direct script access.');

class Api_Nur_Shop  {

    /**
     * Сохранение реквизитов
     * @param Model_Nur_Shop $model
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @param $fileName
     * @param bool $isPHPOutput
     * @throws Exception
     */
    public static function saveRequisitesInPDF(Model_Nur_Shop $model, SitePageData $sitePageData,
                                                Model_Driver_DBBasicDriver $driver, $fileName, $isPHPOutput = FALSE)
    {
        $path = APPPATH.'views'.DIRECTORY_SEPARATOR. 'nur' . DIRECTORY_SEPARATOR . 'pdf' . DIRECTORY_SEPARATOR
            . $sitePageData->dataLanguageID . DIRECTORY_SEPARATOR . 'shop' . DIRECTORY_SEPARATOR. 'requisites' . DIRECTORY_SEPARATOR;

        $pdf = new PDF_Hotel_Page('Реквизиты', '', FALSE);

        $options = include $path. 'requisites.php';

        $pdf->headerHTML($options['header']);

        $pdf->setFooterFont(Array('BookAntiqua', '', 9));
        $pdf->footerHtml = $options['footer'];

        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
        $pdf->AddPage(PDF_PAGE_ORIENTATION, PDF_PAGE_FORMAT);

        $pdf->SetFont('BookAntiqua', '', 11);

        $file = 'nur' . DIRECTORY_SEPARATOR . 'pdf' . DIRECTORY_SEPARATOR . $sitePageData->dataLanguageID
            . DIRECTORY_SEPARATOR . 'shop' . DIRECTORY_SEPARATOR . 'requisites' . DIRECTORY_SEPARATOR  . $options['body_file'];
        try {
            $view = View::factory($file);
        }catch (Exception $e) {
            throw new Exception('Шаблон "'.$file.'" не найден.');
        }

        $model->getElement('requisites_bank_id', TRUE, $sitePageData->shopMainID);
        $view->siteData = $sitePageData;
        $view->shop = $model->getValues(TRUE, TRUE, $sitePageData->shopMainID);

        $strView = Helpers_View::viewToStr($view);

        $pdf->writeHTML($strView);

        if ($isPHPOutput){
            $pdf->Output($fileName, 'D');
        }else {
            $pdf->Output($fileName, 'F');
        }
    }

    /**
     * Сохранение информации магазина
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @param bool $isSaveBranch
     * @return array
     * @throws HTTP_Exception_500
     */
    public static function save(SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver, $isSaveBranch = FALSE)
    {
        $model = new Model_Nur_Shop();
        $model->setDBDriver($driver);

        if($isSaveBranch){
            $id = Request_RequestParams::getParamInt('id');
        }else{
            $id = $sitePageData->shopID;
        }

        if (!Helpers_DB::dublicateObjectLanguage($model, $id, $sitePageData)) {
            throw new HTTP_Exception_500('Shop not found.');
        }

        if($isSaveBranch){
            $model->setMainShopID($sitePageData->shopID);
        }

        Request_RequestParams::setParamInt("shop_table_rubric_id", $model);
        Request_RequestParams::setParamBoolean('is_public', $model);
        Request_RequestParams::setParamStr('text', $model);
        Request_RequestParams::setParamStr('name', $model);
        Request_RequestParams::setParamBoolean("is_public", $model);
        Request_RequestParams::setParamStr('official_name', $model);
        Request_RequestParams::setParamStr('sub_domain', $model);
        Request_RequestParams::setParamStr('domain', $model);
        Request_RequestParams::setParamBoolean('is_block', $model);
        Request_RequestParams::setParamInt("shop_bookkeeper_id", $model);

        $options = Request_RequestParams::getParamArray('options');
        if ($options !== NULL) {
            $model->addOptionsArray($options);
        }

        $ecf = Request_RequestParams::getParamArray('ecf');
        if ($ecf !== NULL) {
            $model->addECFArray($ecf);
        }

        $seo = Request_RequestParams::getParamArray('seo');
        if ($seo !== NULL) {
            $model->setSEOArray($seo);
        }

        $cityIDs = Request_RequestParams::getParamArray('city_ids');
        if ($cityIDs !== NULL) {
            $model->setCityIDsArray($cityIDs);
        }
        
        $landIDs = Request_RequestParams::getParamArray('land_ids');
        if ($landIDs !== NULL) {
            $model->setLandIDsArray($landIDs);
        }

        $currencyIDs = Request_RequestParams::getParamArray('currency_ids');
        if ($currencyIDs !== NULL) {
            $model->setCurrencyIDsArray($currencyIDs);
        }

        $requisites = Request_RequestParams::getParamArray('requisites');
        if ($requisites !== NULL) {
            if (key_exists('company', $requisites)){
                $requisites['company_name'] = $requisites['company'];
            }else{
                $requisites['company_name'] = $model->getName();
            }
            // добавляем форму организации для названия
            $modelOrganizationType = $model->getElement('requisites_organization_type_id', TRUE, $sitePageData->shopMainID);
            if ($modelOrganizationType !== NULL){
                $requisites['company_name'] = $modelOrganizationType->getName().' "'.$requisites['company_name'].'"';
            }

            $model->setRequisitesArray($requisites);
        }

        $options = Request_RequestParams::getParamArray('shop_menu');
        if ($options !== NULL) {
            $model->setShopMenuArray($options);
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
