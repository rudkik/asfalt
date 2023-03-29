<?php defined('SYSPATH') or die('No direct script access.');

class Bank_Cashless_Pay
{
    const BANK_PAY_TYPE_ID = 904; // id оплата безналично

    /**
     * Настройки для работы с банком
     * @param array $options
     */
    public function __construct(array $options){
    }

    /**
     * Получаем HTML-код для страницы, чтобы сделать оплату
     * @param Model_Shop_Basic_Bill $bill
     * @param array $billItems типа Model_Shop_Bill_Item
     * @param SitePageData $sitePageData
     */
    public function getHMTLCode(Model_Shop_Basic_Bill $bill, array $billItems, SitePageData $sitePageData){
        $result = '';

        require_once("kkb.utils.php");

        $kkb = new KKBSign();
        $kkb->invert();
        // Открываем публичный ключ.
        if ( !$kkb->load_private_key(APPPATH.'views'.DIRECTORY_SEPARATOR.$sitePageData->shopShablonPath.DIRECTORY_SEPARATOR.'bank'.DIRECTORY_SEPARATOR.$this->filePrivateKey, $this->passwordPrivateKey)){
            throw new HTTP_Exception_500('FilePrivateKey not load.');
        }

        // Поле Signed_Order_B64
        $result = $result . $this->_getSignedOrderB64($kkb, $bill, $sitePageData);

        // Поле ShopID
        if(!empty($this->urlPayOk)) {
            $result = $result . '<input hidden="hidden" name="ShopID" value="' . $this->shopID . '">';
        }

        // Поле BackLink успешная оплата
        if(!empty($this->urlPayOk)) {
            $result = $result . '<input hidden="hidden" name="BackLink" value="' . htmlspecialchars($sitePageData->urlBasic.$this->urlPayOk) . '">';
        }else{
            $result = $result . '<input hidden="hidden" name="BackLink" value="#URL_PAY_OK#">';
        }

        // Поле FailureBackLink неуспешная авторизация
        if(!empty($this->urlAuthBankError)) {
            $result = $result . '<input hidden="hidden" name="FailureBackLink" value="' . htmlspecialchars($sitePageData->urlBasic.$this->urlAuthBankError) . '">';
        }else{
            $result = $result . '<input hidden="hidden" name="FailureBackLink" value="#URL_AUTH_BANK_ERROR#">';
        }

        // Поле PostLink возвращает результат на сайт
        $result = $result . '<input hidden="hidden" name="PostLink" value="'.htmlspecialchars($sitePageData->urlBasic.$this->urlBillPay.$bill->id).'">';

        // Поле Language возвращает результат на сайт
        $result = $result . $this->_getLanguage($sitePageData);

        // Поле appendix массив товаров
        $result = $result . $this->_getAppendix($kkb, $billItems, $sitePageData);

        return $result;
    }

    /**
     * Получаем HTML-код для страницы, чтобы сделать оплату отеля
     * @param $shopPaidTypeID
     * @param Model_Hotel_Shop_Bill $bill
     * @param array $billItems
     * @param SitePageData $sitePageData
     * @return string
     * @throws HTTP_Exception_500
     */
    public function getHMTLCodeHotel($shopPaidTypeID, Model_Hotel_Shop_Bill $bill, array $billItems, SitePageData $sitePageData){
        $result = '';

        require_once("kkb.utils.php");

        $kkb = new KKBSign();
        $kkb->invert();
        // Открываем публичный ключ.
        if ( !$kkb->load_private_key(APPPATH.'views'.DIRECTORY_SEPARATOR.$sitePageData->shopShablonPath.DIRECTORY_SEPARATOR.'bank'.DIRECTORY_SEPARATOR.$this->filePrivateKey, $this->passwordPrivateKey)){
            throw new HTTP_Exception_500('FilePrivateKey not load.');
        }

        $payment = new Model_Hotel_Shop_Payment();
        $payment->setDBDriver($bill->getDBDriver());
        $payment->setShopBillID($bill->id);
        $payment->setShopClientID($bill->getShopClientID());
        $payment->setShopPaidTypeID($shopPaidTypeID);
        $payment->setAmount(Request_RequestParams::getParamFloat('amount'));
        if (($payment->getAmount() < 1) || ($payment->getAmount() > $bill->getAmount())){
            $payment->setAmount($bill->getAmount());
        }
        Helpers_DB::saveDBObject($payment, $sitePageData);

        // Поле Signed_Order_B64
        $result = $result . $this->_getSignedOrderB64($kkb, $payment, $sitePageData);

        // Поле ShopID
        if(!empty($this->urlPayOk)) {
            $result = $result . '<input hidden="hidden" name="ShopID" value="' . $this->shopID . '">';
        }

        // Поле BackLink успешная оплата
        if(!empty($this->urlPayOk)) {
            $result = $result . '<input hidden="hidden" name="BackLink" value="' . htmlspecialchars($sitePageData->urlBasic.$this->urlPayOk) . '">';
        }else{
            $result = $result . '<input hidden="hidden" name="BackLink" value="#URL_PAY_OK#">';
        }

        // Поле FailureBackLink неуспешная авторизация
        if(!empty($this->urlAuthBankError)) {
            $result = $result . '<input hidden="hidden" name="FailureBackLink" value="' .
                htmlspecialchars(str_replace('#amount#', $payment->getAmount(), str_replace('#bill_id#', $bill->id, $sitePageData->urlBasic.$this->urlAuthBankError))) . '">';
        }else{
            $result = $result . '<input hidden="hidden" name="FailureBackLink" value="#URL_AUTH_BANK_ERROR#">';
        }

        // Поле PostLink возвращает результат на сайт
        $result = $result . '<input hidden="hidden" name="PostLink" value="'.htmlspecialchars($sitePageData->urlBasic.$this->urlBillPay.$bill->id.'&payment_id='.$payment->id).'">';

        // Поле Language возвращает результат на сайт
        $result = $result . $this->_getLanguage($sitePageData);

        // Поле appendix массив товаров
        $result = $result . $this->_getAppendix($kkb, $billItems, $sitePageData);

        return $result;
    }
}