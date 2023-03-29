<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Tax_Client_Site extends Controller_Tax_Client_BasicTax {

    public function action_main() {
        $this->_sitePageData->url = '/tax/site/main';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array()
        );

        $this->_putInMain('/main/site/main');
    }

    public function action_referral() {
        $this->_sitePageData->url = '/tax/site/referral';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array()
        );

        $this->_putInMain('/main/site/referral');
    }

    public function action_access() {
        $this->_sitePageData->url = '/tax/site/access';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/good/list/access',
            )
        );

        // получаем список
        View_View::find('DB_Shop_Good', $this->_sitePageData->shopMainID, "_shop/good/list/access",
            "_shop/good/one/access", $this->_sitePageData, $this->_driverDB,
            array(Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE, 'type' => 4059, 'sort_by' => array('value' => array('order' => 'asc'))));

        $this->_putInMain('/main/site/access');
    }

    public function action_pays() {
        $this->_sitePageData->url = '/tax/site/pays';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/bill/one/pays',
            )
        );

        // получаем список
        View_View::find('DB_Tax_Shop_Bill', $this->_sitePageData->shopID, "_shop/bill/one/pays",
            $this->_sitePageData, $this->_driverDB,
            array(Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE, 'is_error_404' => TRUE,
                'id' => Request_RequestParams::getParamInt('shop_bill_id')), array('shop_good_id' => array('options')));

        $this->_putInMain('/main/site/pays');
    }

    public function action_pay() {
        $this->_sitePageData->url = '/tax/site/pay';

        // id записи
        $shopBillID = Request_RequestParams::getParamInt('shop_bill_id');
        $model = new Model_Tax_Shop_Bill();
        if (! $this->dublicateObjectLanguage($model, $shopBillID, -1, FALSE)) {
            throw new HTTP_Exception_404('Bill not is found!');
        }

        $shopPaidTypeID = Request_RequestParams::getParamInt('shop_paid_type_id');
        $modelPaid = new Model_Shop_PaidType();
        if (! $this->dublicateObjectLanguage($modelPaid, $shopPaidTypeID, $this->_sitePageData->shopMainID, FALSE)) {
            throw new HTTP_Exception_404('Paid type not is found!');
        }

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::paidtype/one/pay',
            )
        );

        $modelGood = $model->getElement('shop_good_id', TRUE);
        $model->setPaidTypeID($modelPaid->getPaidTypeID());
        $model->setShopPaidTypeID($shopPaidTypeID);

        switch ($modelPaid->getPaidTypeID()){
            case Bank_Wooppay_Pay::BANK_PAY_TYPE_ID:
                $bank = new Bank_Wooppay_Pay($modelPaid->getOptionsArray());
                $bank->urlClientPay = '/tax/shopbill/index?id=#bill_id#';
                $bank->tableID = Model_Tax_Shop_Bill::TABLE_ID;
                $bank->shopID = $this->_sitePageData->shopID;
                $optionsBank = $bank->getHMTLCode($model, array(), $this->_sitePageData, 'Доступ на Bigbuh.kz '.Arr::path($modelGood->getOptionsArray(), 'period', ''));
                $this->redirect($optionsBank['url_bank']);
                exit();
                break;
            default:
                $optionsBank = array();
        }

        $dataID = new MyArray();
        $dataID->id = $modelPaid->id;
        $dataID->additionDatas['options_bank'] = $optionsBank;
        $this->_sitePageData->replaceDatas['view::paidtype/one/pay'] = Helpers_View::getViewObject($dataID, $modelPaid,
            'paidtype/one/pay', $this->_sitePageData, $this->_driverDB);

        $this->_putInMain('/main/site/pay');
    }
}
