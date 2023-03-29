<?php defined('SYSPATH') or die('No direct script access.');

class Bank_ATF_Pay
{
    const URL_BANK = 'https://www.atfbank.kz/ecom/api'; // сюда посылаются данные для оплаты в банке
    const URL_BANK_TEST = 'https://46.101.210.91:8182/ecom/api'; // сюда посылаются данные для оплаты в банке для тестирования

    const BANK_NAME = 'atf'; // внутреннее обозначение банка
    const BANK_PAY_TYPE_ID = 901; // id оплата банком
    const BANK_TITLE = 'АО "АТФ"';

    // настройки магазина в базе банка
    public $terminalID = ''; // Идентификатор терминала
    public $merchantID = ''; // ID продавца в системе

    // ключ банка
    public $passwordPrivateKey = ''; // пароль от приватного файла ключа SHARED_SECRET

    // системные ссылки
    public $urlPayOk = ''; // ссылка показывающая клиенту при успешной оплате
    public $urlAuthBankError = ''; // ссылка показывающая клиенту при авторизации сайта в банке с ошибкой
    public $urlBillPay = '/bank/pay/'.self::BANK_NAME.'/'; // ссылка принимающая статус оплаты с банка

    public $billTitle = ''; // заголовок заказа

    // интерфейс клиента
    private $language = Model_Language::LANGUAGE_RUSSIAN; // язык интерфейса банка rus/eng
    private $currency = Model_Currency::KZT; // курс валюты

    /**
     * заказ
     * @var null | Model_Shop_Basic_Bill
     */
    private $bill = NULL;
    /**
     * массив товаров
     * @var array Model_Shop_Bill_Item
     */
    private $billItems = array();

    // клиент
    private $emailShop = ''; // e-mail клиента

    /**
     * Настройки для работы с банком
     * @param array $options
     */
    public function __construct(array $options){
        $this->merchantID = Arr::path($options, 'merchantID', '');
        $this->terminalID = Arr::path($options, 'terminalID', '');
        $this->passwordPrivateKey = Arr::path($options, 'passwordPrivateKey', '');
        $this->urlPayOk = Arr::path($options, 'urlPayOk', '');
        $this->urlAuthBankError = Arr::path($options, 'urlAuthBankError', '');
        $this->billTitle = Arr::path($options, 'bill_title', '');
    }

    const WRITE_LOGS = TRUE;
    private function _writeLogs($select){
        if (!self::WRITE_LOGS){
            return FALSE;
        }

        if(is_array($select)){
            $select = Json::json_encode($select);
        }

        $select = Date::formatted_time('now').': '.$select;

        try {
            file_put_contents(APPPATH.'logs'.DIRECTORY_SEPARATOR.'atf.txt', str_replace("\r\n", ' ', $select."\r\n") , FILE_APPEND);
        } catch (Exception $e) {
        }

        return TRUE;
    }

    /**
     * Оправляем оплату через банк
     * @param Model_Shop_Basic_Bill $bill
     * @param array $billItems - элементы Model_Shop_Bill_Item
     * @param SitePageData $sitePageData
     * @param string $infoBill
     * @param string $emailClient
     * @return array
     */
    public function getHMTLCode(Model_Shop_Basic_Bill $bill, array $billItems, SitePageData $sitePageData, $infoBill = '',
                                $emailClient = ''){
        if(empty($infoBill)){
            $infoBill = $this->billTitle;
        }

        $infoBillItem = '';
        foreach ($billItems as $billItem){
            $infoBillItem = $infoBillItem . $billItem->getName() . ' - ' . $billItem->getCountElement(). ' шт.' . "\r\n";
        }
        if(empty($infoBillItem)){
            $infoBillItem = $infoBill;
        }

        $order = '00'.$bill->id;

        $url = $sitePageData->urlBasic.'/index.php' . $this->urlBillPay . $bill->id .'?redirect=true';
        $data = array(
            'ORDER' => $order,
            'AMOUNT' => $bill->getAmount(),
            'CURRENCY' => $sitePageData->currency->getCode(),
            'MERCHANT' => $this->merchantID,
            'TERMINAL' => $this->terminalID,
            'NONCE' => $bill->id,
            'LANGUAGE' => $sitePageData->language->getCode(),
            'CLIENT_ID' => $bill->getCreateUserID(),
            'DESC' => $infoBill,
            'DESC_ORDER' => $infoBillItem,
            'EMAIL' => $emailClient,
            'BACKREF' => $url,
            'redirect' => 'true',
            'Ucaf_Flag' => '',
            'Ucaf_Authentication_Data' => '',
            'P_SIGN' => hash("sha512", $this->passwordPrivateKey
                . $order . ";"
                . $bill->getAmount() . ";"
                . $sitePageData->currency->getCode() . ";"
                . $this->merchantID . ";"
                . $this->terminalID . ";"
                . $bill->id.";"
                . $bill->getCreateUserID() . ";"
                . str_replace("\n\r", "", $infoBill) . ";"
                . str_replace("\n\r", "", $infoBillItem) . ";"
                . $emailClient . ";"
                . $url . ";"
                . '' . ";"
                . '' . ";"
            ),
        );

        return $data;
    }

    /**
     * Проверяем оплату через банк
     * @param Model_Shop_Basic_Bill $bill
     * @return bool
     */
    public function setPayBill(Model_Shop_Basic_Bill $bill)
    {
        if ($bill->getIsPaid()){
            return TRUE;
        }

        $this->_writeLogs(print_r($_GET, TRUE) . print_r($_SERVER, TRUE));
        $isPay =
            (Request_RequestParams::getParamInt('order') == $bill->id)
            && (Request_RequestParams::getParamInt('rrn') > 0)
            && (Request_RequestParams::getParamStr('res_code') === '0')
            && (Request_RequestParams::getParamInt('amount') == $bill->getAmount());
        if ($isPay) {
            $bill->setIsPaid(TRUE);
            $bill->setPaidAt(date('Y-m-d H:i:s'));
            $bill->setPaidTypeID(self::BANK_PAY_TYPE_ID);

            $this->_writeLogs($bill->getValues());
            $bill->dbSave(0, 0, $bill->shopID);
        }

        return $isPay;
    }
}