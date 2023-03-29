<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Client_Hotel extends Controller_Client_BasicClient {

    /**
     * PDF подтверждения брони
     */
    public function action_bill_save_pdf()
    {
        $this->_sitePageData->url = '/client-hotel/bill_save_pdf';

        $shopBillID = Request_RequestParams::getParamInt('id');
        $model = new Model_Hotel_Shop_Bill();
        $model->setDBDriver($this->_driverDB);
        if (! Helpers_DB::dublicateObjectLanguage($model, $shopBillID, $this->_sitePageData)) {
            throw new HTTP_Exception_404('Bill not is found!');
        }

        Api_Hotel_Shop_Bill::savePaidReserveInPDF($model, $this->_sitePageData, $this->_driverDB, 'Reserve '.$shopBillID.'.pdf', TRUE);
    }
}
