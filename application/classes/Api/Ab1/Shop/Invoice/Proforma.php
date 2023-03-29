<?php defined('SYSPATH') or die('No direct script access.');

class Api_Ab1_Shop_Invoice_Proforma  {

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
        $isUnDel = Request_RequestParams::getParamBoolean("is_undel");

        $model = new Model_Ab1_Shop_Invoice_Proforma();
        $model->setDBDriver($driver);

        if (!Helpers_DB::dublicateObjectLanguage($model, $id, $sitePageData)) {
            throw new HTTP_Exception_500('Invoice proforma not found.');
        }

        if (($isUnDel && !$model->getIsDelete()) or (!$isUnDel && $model->getIsDelete())){
            return FALSE;
        }

        if ($isUnDel){
            $shopInvoiceProformaItemIDs = Request_Request::find('DB_Ab1_Shop_Invoice_Proforma_Item',
                $sitePageData->shopID, $sitePageData, $driver,
                Request_RequestParams::setParams(
                    array(
                        'shop_invoice_proforma_id' => $id,
                        'is_delete' => 1,
                        'is_public' => 0,
                    )
                )
            );

            $driver->unDeleteObjectIDs(
                $shopInvoiceProformaItemIDs->getChildArrayID(), $sitePageData->userID,
                Model_Ab1_Shop_Invoice_Proforma_Item::TABLE_NAME, array('is_public' => 1), $sitePageData->shopID
            );
        }else{
            $shopInvoiceProformaItemIDs = Request_Request::find('DB_Ab1_Shop_Invoice_Proforma_Item',
                $sitePageData->shopID, $sitePageData, $driver,
                Request_RequestParams::setParams(
                    array(
                        'shop_invoice_proforma_id' => $id,
                    )
                )
            );

            $driver->deleteObjectIDs(
                $shopInvoiceProformaItemIDs->getChildArrayID(), $sitePageData->userID,
                Model_Ab1_Shop_Invoice_Proforma_Item::TABLE_NAME,
                array('is_public' => 0), $sitePageData->shopID
            );
        }

        if($isUnDel){
            $model->dbUnDelete($sitePageData->userID, 0, $sitePageData->shopID);
        }else {
            $model->dbDelete($sitePageData->userID, 0, $sitePageData->shopID);
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
        $model = new Model_Ab1_Shop_Invoice_Proforma();
        $model->setDBDriver($driver);

        $id = Request_RequestParams::getParamInt('id');
        if($id > 0) {
            if (!Helpers_DB::dublicateObjectLanguage($model, $id, $sitePageData)) {
                throw new HTTP_Exception_500('Invoice not found.');
            }
        }

        Request_RequestParams::setParamBoolean('is_public', $model);
        Request_RequestParams::setParamStr('text', $model);
        Request_RequestParams::setParamStr('name', $model);
        Request_RequestParams::setParamStr("old_id", $model);

        Request_RequestParams::setParamStr('number', $model);
        Request_RequestParams::setParamInt('shop_client_id', $model);
        Request_RequestParams::setParamDateTime('date', $model);
        Request_RequestParams::setParamInt('shop_client_contract_id', $model);

        $options = Request_RequestParams::getParamArray('options');
        if ($options !== NULL) {
            $model->addOptionsArray($options);
        }

        $result = array();
        if ($model->validationFields($result)) {
            // счетчик как в 1с
            DB_Basic::setNumber1CIfEmpty($model, 'number', $sitePageData, $driver, $sitePageData->shopID);

            if($model->id < 1) {
                Helpers_DB::saveDBObject($model, $sitePageData);
            }
            $shopInvoiceProformaItems = Request_RequestParams::getParamArray('shop_invoice_proforma_items');
            if($shopInvoiceProformaItems !== NULL) {
                $model->setAmount(
                    Api_Ab1_Shop_Invoice_Proforma_Item::save(
                        $model, $shopInvoiceProformaItems, $sitePageData, $driver
                    )
                );
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
     * Сохранение счет на оплату в PDF
     * @param $shopInvoiceProformaID
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @param bool $isPHPOutput
     * @throws HTTP_Exception_404
     */
    public static function saveInPDF($shopInvoiceProformaID, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver,
                                     $isPHPOutput = true)
    {
        $model = new Model_Ab1_Shop_Invoice_Proforma();
        $model->setDBDriver($driver);
        if(!Helpers_DB::getDBObject($model, $shopInvoiceProformaID, $sitePageData, 0)){
            throw new HTTP_Exception_404('Invoice proforma not id="' . $shopInvoiceProformaID . '" found.');
        }

        $sitePageData->newShopShablonPath('ab1/_report');
        View_View::find(
            DB_Ab1_Shop_Invoice_Proforma_Item::NAME, 0,
            "_pdf/invoice-proforma/list/product", "_pdf/invoice-proforma/one/product",
            $sitePageData, $driver,
            Request_RequestParams::setParams(['shop_invoice_proforma_id' => $shopInvoiceProformaID]),
            ['shop_product_id' => ['name_1c', 'unit']]
        );

        $ids = new MyArray();
        $ids->setValues($model, $sitePageData, ['shop_client_id', 'shop_client_contract_id']);

        $ids->additionDatas['count'] = 1;
        $body = Helpers_View::getView(
            '_pdf/invoice-proforma/one/invoice', $sitePageData, $driver, $ids
        );

        $pdf = new PDF_Ab1_Page('', '');

        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER - 5);
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM - 6);
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
        $pdf->AddPage(PDF_PAGE_ORIENTATION, PDF_PAGE_FORMAT);

        // тело документа
        $pdf->SetFont('dejavusans', '', 8);

        $pdf->writeHTML($body);

        $path = Helpers_Path::getPathFile(APPPATH, ['views', 'ab1', '_report', $sitePageData->dataLanguageID, '_pdf', 'invoice-proforma']);

        $autograph = Helpers_Image::getPhotoPathByImageType($sitePageData->operation->getFilesArray(), Model_Ab1_Shop_Operation::IMAGE_TYPE_AUTOGRAPH);
        if(!empty($autograph)){
            $autograph = Helpers_Path::getPathFile(DOCROOT, [], $autograph);
            $pdf->Image($autograph, 47, $pdf->getY() - 30);
        }

        $pdf->Image($path . 'stamp.png', 80);

        ob_end_clean();
        $fileName = 'Счет на оплату №' . mb_str_replace('/', ' ', $model->getNumber()) . '.pdf';
        if ($isPHPOutput){
            $pdf->Output($fileName, 'D');
        }else {
            $pdf->Output($fileName, 'F');
        }
        die;
    }
}
