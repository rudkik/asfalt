<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Client_BankPay extends Controller_Client_BasicShop
{
    public function action_pay(){
        $bank = Request_RequestParams::getParamStr('bank');
        if (empty($bank)) {
            $bank = $this->request->param('bank');
        }

        switch($bank) {
            case Bank_CloudPayments_Pay::BANK_NAME:
                $billID = Request_RequestParams::getParamInt('InvoiceId');
                break;
            default:
                $billID = Request_RequestParams::getParamInt('bill_id');
                if (empty($billID)) {
                    $billID = $this->request->param('bill');
                }
        }

        // определяем ID магазина
        $shopID = intval(Request_RequestParams::getParamInt('shop_id'));
        if ($shopID < 1){
            $shopID = $this->_sitePageData->shopID;
        }

        // получаем объект заказа по ID таблицы
        $tableID =  intval(Request_RequestParams::getParamInt('table_id'));
        if ($tableID < 1){
            $model = new Model_Shop_Bill();
        }else{
            $model = Model_Tax_ModelList::createModel($tableID, $this->_driverDB);
            if ($model === NULL){
                $model = Model_Hotel_ModelList::createModel($tableID, $this->_driverDB);
                if ($model === NULL){
                    throw new HTTP_Exception_404('Table not found!');
                }
            }
        }

        // получаем заказ
        if(! $this->getDBObject($model, $billID, $shopID)){
            throw new HTTP_Exception_404('Bill not found!');
        }

        $dataLanguageID = $this->_sitePageData->dataLanguageID;
        $languageID = $this->_sitePageData->languageID;
        $this->_sitePageData->dataLanguageID = $model->languageID;
        $this->_sitePageData->languageID = $model->languageID;
        // определяем банк
        switch($bank){
            case Bank_Kazkom_Pay::BANK_NAME:
                $shopPaidType = Request_Shop_PaidType::findIDByPaidTypeID($this->_sitePageData->shopID,
                    Bank_Kazkom_Pay::BANK_PAY_TYPE_ID, $this->_sitePageData, $this->_driverDB);

                $modelPaid = new Model_Shop_PaidType();
                if(($shopPaidType == 0) || (! $this->getDBObject($modelPaid, $shopPaidType))){
                    throw new HTTP_Exception_404('Paid type not found!');
                }

                // проверяем статус оплаты
                $bank = new Bank_Kazkom_Pay($modelPaid->getOptionsArray());
                $bank->setPayBill($model, $this->_sitePageData);
                break;
            case Bank_ATF_Pay::BANK_NAME:
                $shopPaidType = Request_Shop_PaidType::findIDByPaidTypeID($this->_sitePageData->shopID,
                    Bank_ATF_Pay::BANK_PAY_TYPE_ID, $this->_sitePageData, $this->_driverDB);

                $modelPaid = new Model_Shop_PaidType();
                if(($shopPaidType == 0) || (! $this->getDBObject($modelPaid, $shopPaidType))){
                    throw new HTTP_Exception_404('Paid type not found!');
                }

                // проверяем статус оплаты
                $bank = new Bank_ATF_Pay($modelPaid->getOptionsArray());
                $bank->setPayBill($model, $this->request->body());
                break;
            case Bank_Wooppay_Pay::BANK_NAME:
                $shopPaidType = Request_Shop_PaidType::findIDByPaidTypeID($this->_sitePageData->shopID,
                    Bank_Wooppay_Pay::BANK_PAY_TYPE_ID, $this->_sitePageData, $this->_driverDB);

                $modelPaid = new Model_Shop_PaidType();
                if(($shopPaidType == 0) || (! $this->getDBObject($modelPaid, $shopPaidType))){
                    throw new HTTP_Exception_404('Paid type not found!');
                }

                // проверяем статус оплаты
                $bank = new Bank_Wooppay_Pay($modelPaid->getOptionsArray());
                $bank->setPayBill($model, $this->_sitePageData, $this->_driverDB);
                break;
            case Bank_AlfaBank_Pay::BANK_NAME:
                $shopPaidType = Request_Shop_PaidType::findIDByPaidTypeID($this->_sitePageData->shopID,
                    Bank_AlfaBank_Pay::BANK_PAY_TYPE_ID, $this->_sitePageData, $this->_driverDB);

                $modelPaid = new Model_Shop_PaidType();
                if(($shopPaidType == 0) || (! $this->getDBObject($modelPaid, $shopPaidType))){
                    throw new HTTP_Exception_404('Paid type not found!');
                }

                // проверяем статус оплаты
                $bank = new Bank_AlfaBank_Pay($modelPaid->getOptionsArray());
                $bank->setPayBill($model, $this->request->body());
                break;
            case Bank_CloudPayments_Pay::BANK_NAME:
                $shopPaidType = Request_Shop_PaidType::findIDByPaidTypeID(
                    $this->_sitePageData->shopID, Bank_CloudPayments_Pay::BANK_PAY_TYPE_ID,
                    $this->_sitePageData, $this->_driverDB
                );

                $modelPaid = new Model_Shop_PaidType();
                if(($shopPaidType == 0) || (! $this->getDBObject($modelPaid, $shopPaidType))){
                    throw new HTTP_Exception_404('Paid type not found!');
                }

                // проверяем статус оплаты
                $bank = new Bank_CloudPayments_Pay($modelPaid->getOptionsArray());
                $bank->setPayBill($model);
                break;
            default:
                throw new HTTP_Exception_404('Bank not found!');
        }

        $this->_sitePageData->dataLanguageID = $dataLanguageID;
        $this->_sitePageData->languageID = $languageID;
    }

    public function action_in_bank(){
        $this->_sitePageData->url = '/bank/in_bank';

        $billID = Request_RequestParams::getParamInt('bill_id');
        $bank = Request_RequestParams::getParamStr('bank');

        // определяем ID магазина
        $shopID = intval(Request_RequestParams::getParamInt('shop_id'));
        if ($shopID < 1){
            $shopID = $this->_sitePageData->shopID;
        }

        // получаем объект заказа по ID таблицы
        $tableID =  intval(Request_RequestParams::getParamInt('table_id'));
        if ($tableID < 1){
            $model = new Model_Shop_Bill();
        }else{
            $model = Model_Tax_ModelList::createModel($tableID, $this->_driverDB);
            if ($model === NULL){
                $model = Model_Hotel_ModelList::createModel($tableID, $this->_driverDB);
                if ($model === NULL){
                    throw new HTTP_Exception_404('Table not found!');
                }
            }
        }

        // получаем заказ
        if(! $this->getDBObject($model, $billID, $shopID, FALSE)){
            throw new HTTP_Exception_404('Bill not found!');
        }

        // определяем банк
        switch($bank){
            case Bank_AlfaBank_Pay::BANK_NAME:
                $shopPaidType = Request_Shop_PaidType::findIDByPaidTypeID(
                    $this->_sitePageData->shopID, Bank_AlfaBank_Pay::BANK_PAY_TYPE_ID,
                    $this->_sitePageData, $this->_driverDB
                );

                $modelPaid = new Model_Shop_PaidType();
                if(($shopPaidType == 0) || (! $this->getDBObject($modelPaid, $shopPaidType))){
                    throw new HTTP_Exception_404('Paid type not found!');
                }

                // проверяем статус оплаты
                $bank = new Bank_AlfaBank_Pay($modelPaid->getOptionsArray());
                $bank->inBank($model, $this->_sitePageData);
                break;
            default:
                throw new HTTP_Exception_404('Bank not found!');
        }

    }
}